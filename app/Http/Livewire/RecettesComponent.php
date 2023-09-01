<?php

namespace App\Http\Livewire;

use Exception;
use Carbon\Carbon;
use App\Models\Recette;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\CategorieRecette;
use App\Models\GroupeCategorieRecette;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RecettesComponent extends Component
{
    protected $paginationTheme = "bootstrap";

    public $currentPage = PAGELIST;

    use WithPagination;
    public $newRecette = [];
    public $editRecette = [];

    public $categories;
    public $groupe_id;

    protected $messages = [
        'newRecette.nom.required' => "Veuillez saisir le libéllé de la recette.",
        'newRecette.montant.required' => "Le montant est obligatoire.",
        'newRecette.categories_recettes_id.required' => "La catégorie est obligatoire.",

        'editRecette.nom.required' => "Veuillez saisir le libéllé de la recette.",
        'editRecette.categories_recettes_id.required' => "La catégorie est obligatoire.",
        'editRecette.statut.required' => "le statut est obligatoire.",
        'editRecette.montant.required' => "Le montant est obligatoire."
    ];

    public function render()
    {
        Carbon::setLocale("fr");

        $recettes = Recette::latest()->paginate(15);
        $groupes = GroupeCategorieRecette::orderBy('nom', 'asc')->get();

        return view(
            'livewire.modules.recettes.index',
            compact(
                "recettes",
                "groupes",
            )
        )
            ->extends("layouts.master")
            ->section("contenu");
    }

    public function updatedGroupeId()
    {
        if ($this->groupe_id) {
            $this->categories =
                CategorieRecette::where('groupe_categories_recettes_id', $this->groupe_id)->get();
        } else {
            $this->categories = null;
        }
    }

    public function goToListRecette()
    {
        $this->currentPage = PAGELIST;
        $this->editRecette = [];
    }

    public function goToAddRecette()
    {
        $this->currentPage = PAGECREATEFORM;
    }

    public function goToEditRecette($id)
    {
        $this->editRecette = Recette::find($id)->toArray();
        $this->currentPage = PAGEEDITFORM;
    }

    public function rules()
    {
        if ($this->currentPage == PAGEEDITFORM) {

            return [
                'editRecette.nom' => 'required',
                'editRecette.montant' => 'required',
                'editRecette.categories_recettes_id' => 'required',
            ];
        }

        return [
            'newRecette.nom' => 'required',
            'newRecette.montant' => 'required',
            'newRecette.categories_recettes_id' => 'required',
            'newRecette.statut' => 'nullable',
        ];
    }

    public function addRecette()
    {
        $validationAttributes = $this->validate();
        try {
            DB::beginTransaction();
            Recette::create($validationAttributes["newRecette"]);
            DB::commit();
            $this->newRecette = [];

            $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "La catégorie a été créée avec succès!"]);
        } catch (Exception $e) {
            dd($e->getMessage());
            DB::rollback();
            Log::error($e->getMessage());
            $this->dispatchBrowserEvent("showErrorMessage", ["message" => "Une erreur s'est produite lors de la création de la catégorie."]);
        }
    }

    public function updateRecette()
    {
        $validationAttributes = $this->validate();
        try {
            Recette::find($this->editRecette["id"])->update($validationAttributes["editRecette"]);
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

    public function deleteRecette($id)
    {
        try {
            $categorie = Recette::find($id);
            $categorie->destroy($categorie->id);
            $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "La dépense a été suppriméee avec succès!"]);
        } catch (\Illuminate\Database\QueryException $e) {
            // Gestion de l'erreur
            if ($e->getCode() === '23000') {
                $this->dispatchBrowserEvent(
                    "showErrorMessage",
                    ["message" => "Impossible ! Cette dépense est liéee à d'autres données."]
                );
            } else {
                $this->dispatchBrowserEvent(
                    "showErrorMessage",
                    ["message" => "Une erreur s'est produite lors de la suppression de la dépense."]
                );
            }
        }
    }
}
