<div class="row p-4 pt-5">
    <div class="col-md-9">
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-user-plus fa-2x"></i> Formulaire d'édition utilisateur</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" wire:submit.prevent="updateGroupe()" method="POST">
                <div class="card-body">
                
                    <div class="d-flex">
                        <div class="form-group flex-grow-1 mr-2">
                            <label>Nom</label>
                            <input autocomplete="off" type="text" wire:model="editCategoriesRecettes.nom"
                                class="form-control @error('editCategoriesRecettes.nom') is-invalid @enderror">
                
                            @error("editCategoriesRecettes.nom")
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Statut *</label>
                        <select class="form-control @error('editCategoriesRecettes.statut') is-invalid @enderror" wire:model="editCategoriesRecettes.statut">
                            <option value="0">Invisible</option>
                            <option value="1">Visible</option>
                        </select>
                        @error("editCategoriesRecettes.statut")
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                    <button type="button" wire:click.prevent="goToListGroupe()" class="btn btn-danger">Retouner à la liste
                        des
                        groupes de catégorie</button>
                
                </div>
                <!-- /.card-body -->
            </form>
        </div>
        <!-- /.card -->

    </div>
</div>