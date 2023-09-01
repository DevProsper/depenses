<div class="row p-4 pt-5">
    <div class="col-md-9">
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title"><i class="fa fa-calendar-plus"></i> Editer une nouvelle catégorie</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" wire:submit.prevent="updateCategorieRecette()">
                <div class="card-body">

                    <div class="d-flex">
                        <div class="form-group flex-grow-1 mr-2">
                            <label>Categorie *</label>
                            <input autocomplete="off" type="text" wire:model="editCategorieRecette.nom"
                                class="form-control @error('editCategorieRecette.nom') is-invalid @enderror">

                            @error("editCategorieRecette.nom")
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Groupe *</label>
                        <select
                            class="form-control @error('groupe_categories_recettes_id') 
                                                                                                                                            is-invalid @enderror"
                            name="groupe_categories_recettes_id"
                            wire:model="editCategorieRecette.groupe_categories_recettes_id">
                            <option value="">---------</option>
                            @foreach($groupes as $value)
                            <option value="{{ $value->id }}">{{ $value->nom }}</option>
                            @endforeach
                        </select>
                        @error("groupe_categories_recettes_id")
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                    <button type="button" wire:click.prevent="goToListCategorieRecette()"
                        class="btn btn-danger">Retouner à la liste des
                        catégories</button>

                </div>
                <!-- /.card-body -->
            </form>
        </div>
        <!-- /.card -->

    </div>
</div>