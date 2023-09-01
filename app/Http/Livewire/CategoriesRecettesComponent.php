<?php

namespace App\Http\Livewire;

use Exception;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\CategorieRecette;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\GroupeCategorieRecette;

class CategoriesRecettesComponent extends Component
{
    protected $paginationTheme = "bootstrap";

    public $currentPage = PAGELIST;

    use WithPagination;
    public $newCategorieRecette = [];
    public $editCategorieRecette = [];

    protected $messages = [
        'newCategorieRecette.nom.required' => "la catégorie est obligatoire.",
        'newCategorieRecette.groupe_categories_recettes_id.required' => "Le groupe est obligatoire.",

        'editCategorieRecette.nom.required' => "la catégorie est obligatoire.",
        'editCategorieRecette.groupe_categories_recettes_id.required' => "Le groupe est obligatoire.",
        'editCategorieRecette.statut.required' => "le statut est obligatoire.",
    ];

    public function render()
    {
        Carbon::setLocale("fr");

        $categories = CategorieRecette::latest()->paginate(15);
        $groupes = GroupeCategorieRecette::orderBy('nom', 'asc')->get();

        return view(
            'livewire.modules.administration.categories_recettes.index',
            compact(
                "categories",
                "groupes",
            )
        )
            ->extends("layouts.master")
            ->section("contenu");
    }

    public function goToListCategorieRecette()
    {
        $this->currentPage = PAGELIST;
        $this->editCategorieRecette = [];
    }

    public function goToAddCategorieRecette()
    {
        $this->currentPage = PAGECREATEFORM;
    }

    public function goToEditCategorieRecette($id)
    {
        $this->editCategorieRecette = CategorieRecette::find($id)->toArray();
        $this->currentPage = PAGEEDITFORM;
    }

    public function rules()
    {
        if ($this->currentPage == PAGEEDITFORM) {

            return [
                'editCategorieRecette.nom' => 'required',
                'editCategorieRecette.groupe_categories_recettes_id' => 'required',
            ];
        }

        return [
            'newCategorieRecette.nom' => 'required',
            'newCategorieRecette.groupe_categories_recettes_id' => 'required',
            'newCategorieRecette.statut' => 'nullable',
        ];
    }

    public function addCategorieRecette()
    {
        $validationAttributes = $this->validate();
        try {
            DB::beginTransaction();
            CategorieRecette::create($validationAttributes["newCategorieRecette"]);
            DB::commit();
            $this->newCategorieRecette = [];

            $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "La catégorie a été créée avec succès!"]);
        } catch (Exception $e) {
            dd($e->getMessage());
            DB::rollback();
            Log::error($e->getMessage());
            $this->dispatchBrowserEvent("showErrorMessage", ["message" => "Une erreur s'est produite lors de la création de la catégorie."]);
        }
    }

    public function updateCategorieRecette()
    {
        $validationAttributes = $this->validate();
        try {
            CategorieRecette::find($this->editCategorieRecette["id"])->update($validationAttributes["editCategorieRecette"]);
            $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "La classe a été mise à jour avec succès!"]);
        } catch (Exception $e) {
            $this->dispatchBrowserEvent("showErrorMessage", ["message" => "Une erreur s'est produite lors de la mise à jour de la catégorie."]);
        }
    }

    public function confirmDelete($nom, $id)
    {
        $this->dispatchBrowserEvent("showConfirmMessage", ["message" => [
            "text" => "Vous êtes sur le point de supprimer $nom de la liste. Voulez-vous continuer?",
            "title" => "Êtes-vous sûr de continuer?",
            "type" => "warning",
            "data" => [
                "data_id" => $id
            ]
        ]]);
    }

    public function deleteCategorieRecette($id)
    {
        try {
            $categorie = CategorieRecette::find($id);
            $categorie->destroy($categorie->id);
            $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "La catégorie a été suppriméee avec succès!"]);
        } catch (\Illuminate\Database\QueryException $e) {
            // Gestion de l'erreur
            if ($e->getCode() === '23000') {
                $this->dispatchBrowserEvent(
                    "showErrorMessage",
                    ["message" => "Impossible ! Cette catégorie est liéee à d'autres données."]
                );
            } else {
                $this->dispatchBrowserEvent(
                    "showErrorMessage",
                    ["message" => "Une erreur s'est produite lors de la suppression de la catégorie."]
                );
            }
        }
    }
}
