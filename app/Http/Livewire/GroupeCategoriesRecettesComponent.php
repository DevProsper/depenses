<?php

namespace App\Http\Livewire;

use Exception;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\GroupeCategorieRecette;

class GroupeCategoriesRecettesComponent extends Component
{
    protected $paginationTheme = "bootstrap";

    public $currentPage = PAGELIST;

    use WithPagination;
    public $newCategoriesRecettes = [];
    public $editCategoriesRecettes = [];
    public $search = "";

    protected $messages = [
        'newCategoriesRecettes.nom.required' => "le nom de la catégorie est obligatoire.",

        'editCategoriesRecettes.nom.required' => "le nom de la catégorie est obligatoire.",
        'editCategoriesRecettes.statut.required' => "Le statut de la catégorie est obligatoire",
    ];


    public function render()
    {
        Carbon::setLocale("fr");

        $groupeDepenses = GroupeCategorieRecette::latest();
        $search = $this->search;

        if ($search) {
            $groupeDepenses = $groupeDepenses->where('nom', 'LIKE', '%' . $search . '%');
        }

        $groupeDepenses = $groupeDepenses->paginate(15);

        return view('livewire.modules.administration.groupe_categories_recettes.index', compact("groupeDepenses"))
            ->extends("layouts.master")
            ->section("contenu");
    }

    public function goToListGroupe()
    {
        $this->currentPage = PAGELIST;
        $this->editCategoriesRecettes = [];
    }

    public function goToAddGroupe()
    {
        $this->currentPage = PAGECREATEFORM;
    }

    public function goToEditGroupe($id)
    {
        $this->editCategoriesRecettes = GroupeCategorieRecette::find($id)->toArray();
        $this->currentPage = PAGEEDITFORM;
    }

    public function rules()
    {
        if ($this->currentPage == PAGEEDITFORM) {

            return [
                'editCategoriesRecettes.nom' => 'required',
                'editCategoriesRecettes.statut' => 'required',
            ];
        }

        return [
            'newCategoriesRecettes.nom' => 'required',
        ];
    }

    public function addGroupe()
    {
        $validationAttributes = $this->validate();

        GroupeCategorieRecette::create($validationAttributes["newCategoriesRecettes"]);

        $this->newCategoriesRecettes = [];

        $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Le groupe a bel et bien été crée !"]);
    }

    public function updateGroupe()
    {
        // Vérifier que les informations envoyées par le formulaire sont correctes
        $validationAttributes = $this->validate();
        try {

            GroupeCategorieRecette::find($this->editCategoriesRecettes["id"])->update($validationAttributes["editCategoriesRecettes"]);

            $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Le groupe a été mis à jour avec succès!"]);
        } catch (Exception $e) {
            $this->dispatchBrowserEvent("showErrorMessage", ["message" => "Une erreur s'est produite lors de la mise à jour du groupe."]);
        }
    }

    public function confirmDelete($name, $id)
    {
        $this->dispatchBrowserEvent("showConfirmMessage", ["message" => [
            "text" => "Vous êtes sur le point de supprimer $name de la liste des utilisateurs. Voulez-vous continuer?",
            "title" => "Êtes-vous sûr de continuer?",
            "type" => "warning",
            "data" => [
                "groupe_id" => $id
            ]
        ]]);
    }

    public function deleteGroupe($id)
    {
        try {
            GroupeCategorieRecette::destroy($id);

            $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Le groupe a été supprimé !"]);
        } catch (\Illuminate\Database\QueryException $e) {
            // Gestion de l'erreur
            if ($e->getCode() === '23000') {
                $this->dispatchBrowserEvent("showErrorMessage", ["message" => "Impossible ! Cet groupe est lié à d'autres données."]);
            } else {
                $this->dispatchBrowserEvent("showErrorMessage", ["message" => "Une erreur s'est produite lors de la suppression du groupe."]);
            }
        }
    }
}
