<div class="row p-4 pt-5">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-gradient-primary d-flex align-items-center">
                <h3 class="card-title flex-grow-1"><i class="fas fa-users fa-2x"></i> Liste des groupes de catégorie</h3>

                <div class="card-tools d-flex align-items-center ">
                    <a class="btn btn-success text-white mr-4 d-block" wire:click.prevent="goToAddGroupe()"><i
                            class="fas fa-user-plus"></i> Nouveau groupe</a>
                    <div class="input-group input-group-md" style="width: 250px;">
                        <input type="text" name="table_search" wire:model.debounce.700ms="search" class="form-control float-right" placeholder="Recherche par nom">

                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0 table-striped">
                <table class="table table-head-fixed">
                    <thead>
                        <tr>
                            <th style="width:20%;">Groupe</th>
                            <th style="width:20%;" class="text-center">Ajouté</th>
                            <th style="width:30%;" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($groupeDepenses as $value)
                        <tr>
                            <td>{{ $value->nom }}</td>
                            <td class="text-center">
                                <span class="tag tag-success">{{ $value->created_at->diffForHumans()
                                    }}</span>
                                    </td>
                            <td class="text-center">
                                <button class="btn btn-link" wire:click="goToEditGroupe({{$value->id}})"> <i
                                        class="far fa-edit"></i> </button>
                                <button class="btn btn-link"
                                    wire:click="confirmDelete('{{ $value->name }}', {{$value->id}})">
                                    <i class="far fa-trash-alt"></i> </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <div class="float-right">
                    {{ $groupeDepenses->links() }}
                </div>
            </div>
        </div>
        <!-- /.card -->
    </div>
</div>