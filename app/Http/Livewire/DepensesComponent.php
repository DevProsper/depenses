<?php

namespace App\Http\Livewire;

use Exception;
use Carbon\Carbon;
use App\Models\Depense;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\CategorieDepense;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\GroupeCategorieDepense;

class DepensesComponent extends Component
{
    protected $paginationTheme = "bootstrap";

    public $currentPage = PAGELIST;

    use WithPagination;
    public $newDepense = [];
    public $editDepense = [];

    public $categories;
    public $groupe_id;

    protected $messages = [
        'newDepense.nom.required' => "Veuillez saisir le libéllé de la recette.",
        'newDepense.montant.required' => "Le montant est obligatoire.",
        'newDepense.categories_depenses_id.required' => "La catégorie est obligatoire.",
        'newDepense.date_depense.required' => "La date est obligatoire.",

        'editDepense.nom.required' => "Veuillez saisir le libéllé de la recette.",
        'editDepense.categories_depenses_id.required' => "La catégorie est obligatoire.",
        'editDepense.statut.required' => "le statut est obligatoire.",
        'editDepense.montant.required' => "Le montant est obligatoire.",
        'editDepense.date_depense.required' => "La date est obligatoire."
    ];

    public function render()
    {
        Carbon::setLocale("fr");

        $depenses = Depense::latest()->paginate(15);
        $groupes = GroupeCategorieDepense::orderBy('nom', 'asc')->get();

        return view(
            'livewire.modules.depenses.index',
            compact(
                "depenses",
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
                CategorieDepense::where('groupe_categories_depenses_id', $this->groupe_id)->get();
        } else {
            $this->categories = null;
        }
    }

    public function goToListDepense()
    {
        $this->currentPage = PAGELIST;
        $this->editDepense = [];
    }

    public function goToAddDepense()
    {
        $this->currentPage = PAGECREATEFORM;
    }

    public function goToEditDepense($id)
    {
        $this->editDepense = Depense::find($id)->toArray();
        $this->currentPage = PAGEEDITFORM;
    }

    public function rules()
    {
        if ($this->currentPage == PAGEEDITFORM) {

            return [
                'editDepense.nom' => 'required',
                'editDepense.date_depense' => 'required',
                'editDepense.montant' => 'required',
                'editDepense.categories_depenses_id' => 'required',
            ];
        }

        return [
            'newDepense.nom' => 'required',
            'newDepense.montant' => 'required',
            'newDepense.date_depense' => 'required',
            'newDepense.categories_depenses_id' => 'required',
            'newDepense.statut' => 'nullable',
        ];
    }

    public function addDepense()
    {
        $validationAttributes = $this->validate();
        try {
            DB::beginTransaction();
            Depense::create($validationAttributes["newDepense"]);
            DB::commit();
            $this->newDepense = [];

            $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "La catégorie a été créée avec succès!"]);
        } catch (Exception $e) {
            dd($e->getMessage());
            DB::rollback();
            Log::error($e->getMessage());
            $this->dispatchBrowserEvent("showErrorMessage", ["message" => "Une erreur s'est produite lors de la création de la catégorie."]);
        }
    }

    public function updateDepense()
    {
        $validationAttributes = $this->validate();
        try {
            Depense::find($this->editDepense["id"])->update($validationAttributes["editDepense"]);
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

    public function deleteDepense($id)
    {
        try {
            $categorie = Depense::find($id);
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
