<div class="row p-4 pt-5">
    <div class="col-md-9">
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title"><i class="fa fa-calendar-plus"></i> Ajoute d'une nouvelle catégorie</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" wire:submit.prevent="addCategorieDepense()">
                <div class="card-body">

                    <div class="d-flex">
                        <div class="form-group flex-grow-1 mr-2">
                            <label>Categorie *</label>
                            <input autocomplete="off" type="text" wire:model="newCategorieDepense.nom"
                                class="form-control @error('newCategorieDepense.nom') is-invalid @enderror">

                            @error("newCategorieDepense.nom")
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Groupe *</label>
                        <select
                            class="form-control @error('groupe_categories_depenses_id') 
                                                                                                                                            is-invalid @enderror"
                            name="groupe_categories_depenses_id" wire:model="newCategorieDepense.groupe_categories_depenses_id">
                            <option value="">---------</option>
                            @foreach($groupes as $value)
                            <option value="{{ $value->id }}">{{ $value->nom }}</option>
                            @endforeach
                        </select>
                        @error("groupe_categories_depenses_id")
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                        <button type="button" wire:click.prevent="goToListCategorieDepense()" class="btn btn-danger">Retouner à la liste des
                        catégories</button>

                </div>
                <!-- /.card-body -->
            </form>
        </div>
        <!-- /.card -->

    </div>
</div>