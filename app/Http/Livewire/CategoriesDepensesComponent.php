<?php

namespace App\Http\Livewire;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\CategorieDepense;
use Illuminate\Support\Facades\DB;
use App\Models\GroupeCategorieDepense;

class CategoriesDepensesComponent extends Component
{
    protected $paginationTheme = "bootstrap";

    public $currentPage = PAGELIST;

    use WithPagination;
    public $newCategorieDepense = [];
    public $editCategorieDepense = [];

    protected $messages = [
        'newCategorieDepense.nom.required' => "la catégorie est obligatoire.",
        'newCategorieDepense.groupe_categories_depenses_id.required' => "Le groupe est obligatoire.",

        'editCategorieDepense.nom.required' => "la catégorie est obligatoire.",
        'editCategorieDepense.groupe_categories_depenses_id.required' => "Le groupe est obligatoire.",
        'editCategorieDepense.statut.required' => "le statut est obligatoire.",
    ];

    public function render()
    {
        Carbon::setLocale("fr");

        $categories = CategorieDepense::latest()->paginate(15);
        $groupes = GroupeCategorieDepense::orderBy('nom', 'asc')->get();

        return view(
            'livewire.modules.administration.categories_depenses.index',
            compact(
                "categories",
                "groupes",
            )
        )
            ->extends("layouts.master")
            ->section("contenu");
    }

    public function goToListCategorieDepense()
    {
        $this->currentPage = PAGELIST;
        $this->editCategorieDepense = [];
    }

    public function goToAddCategorieDepense()
    {
        $this->currentPage = PAGECREATEFORM;
    }

    public function goToEditCategorieDepense($id)
    {
        $this->editCategorieDepense = CategorieDepense::find($id)->toArray();
        $this->currentPage = PAGEEDITFORM;
    }

    public function rules()
    {
        if ($this->currentPage == PAGEEDITFORM) {

            return [
                'editCategorieDepense.nom' => 'required',
                'editCategorieDepense.groupe_categories_depenses_id' => 'required',
            ];
        }

        return [
            'newCategorieDepense.nom' => 'required',
            'newCategorieDepense.groupe_categories_depenses_id' => 'required',
            'newCategorieDepense.statut' => 'nullable',
        ];
    }

    public function addCategorieDepense()
    {
        $validationAttributes = $this->validate();
        try {
            DB::beginTransaction();
            CategorieDepense::create($validationAttributes["newCategorieDepense"]);
            DB::commit();
            $this->newCategorieDepense = [];

            $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "La catégorie a été créée avec succès!"]);
        } catch (Exception $e) {
            dd($e->getMessage());
            DB::rollback();
            Log::error($e->getMessage());
            $this->dispatchBrowserEvent("showErrorMessage", ["message" => "Une erreur s'est produite lors de la création de la catégorie."]);
        }
    }

    public function updateCategorieDepense()
    {
        $validationAttributes = $this->validate();
        try {
            CategorieDepense::find($this->editCategorieDepense["id"])->update($validationAttributes["editCategorieDepense"]);
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

    public function deleteCategorieDepense($id)
    {
        try {
            $categorie = CategorieDepense::find($id);
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
