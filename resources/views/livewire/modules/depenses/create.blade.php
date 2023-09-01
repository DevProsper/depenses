<div class="row p-4 pt-5">
    <div class="col-md-9">
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title"><i class="fa fa-calendar-plus"></i> Ajoute d'une nouvelle catégorie</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" wire:submit.prevent="addDepense()">
                <div class="card-body">

                    <div class="d-flex">
                        <div class="form-group flex-grow-1 mr-2">
                            <label>Libelle *</label>
                            <input autocomplete="off" type="text" wire:model="newDepense.nom"
                                class="form-control @error('newDepense.nom') is-invalid @enderror">

                            @error("newDepense.nom")
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex">
                        <div class="form-group flex-grow-1 mr-2">
                            <label>Montant *</label>
                            <input autocomplete="off" type="number" wire:model="newDepense.montant"
                                class="form-control @error('newDepense.montant') is-invalid @enderror">
                    
                            @error("newDepense.montant")
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Groupe *</label>
                        <select class="form-control @error('groupe_id') is-invalid @enderror" name="groupe_id" wire:model="groupe_id">
                            <option value="">---------</option>
                            @foreach($groupes as $value)
                            <option value="{{ $value->id }}">{{ $value->nom }}</option>
                            @endforeach
                        </select>
                        @error("groupe_id")
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    @if ($categories)
                    <div class="form-group">
                        <label>Catégorie *</label>
                        <select class="form-control @error('newDepense.categories_recettes_id') is-invalid @enderror" name="newDepense.categories_recettes_id"
                            wire:model="newDepense.categories_recettes_id">
                            <option value="">---------</option>
                            @foreach($categories as $value)
                            <option value="{{ $value->id }}">{{ $value->nom }}</option>
                            @endforeach
                        </select>
                        @error("newDepense.categories_recettes_id")
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    @endif
                    
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                        <button type="button" wire:click.prevent="goToListDepense()" class="btn btn-danger">Retouner à la liste des
                        dépenses</button>

                </div>
                <!-- /.card-body -->
            </form>
        </div>
        <!-- /.card -->

    </div>
</div>