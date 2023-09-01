<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <a href="index3.html" class="brand-link">
        <img src="{{asset('assets/images/logo-asnec-it.png')}}" alt="ASNEC-IT Logo" 
        class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">ASNEC-IT</span>
    </a>

    <div class="sidebar">

        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{asset('assets/images/avatar5.png')}}" class="img-circle elevation-2" 
                alt="images profile">
            </div>
            <div class="info">
                <a href="#" class="d-block">Prosper NGOUARI</a>
            </div>
        </div>

        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" 
                aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" 
            data-accordion="false">

                @can("recettes")
                    <li class="nav-item menu-open">
                        <a href="{{ setMenuClass('recettes.', 'menu-open') }}"
                        class="nav-link {{ setMenuClass('recettes.', 'active') }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Recettes
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('recettes.recettes.index')}}"
                                class="nav-link {{ setMenuClass('recettes.recettes.index', 'active') }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Liste</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                @can("depenses")
                <li class="nav-item menu-open">
                    <a href="{{ setMenuClass('depenses.', 'menu-open') }}" 
                    class="nav-link {{ setMenuClass('depenses.', 'active') }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dépenses
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('depenses.depenses.index')}}" 
                            class="nav-link {{ setMenuClass('depenses.depenses.index', 'active') }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Liste</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endcan
                @can("administration")
                    <li class="nav-item {{ setMenuClass('administration.', 'menu-open') }}">
                        <a href="#" class="nav-link {{ setMenuClass('administration.', 'active') }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Administration
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('administration.groupedepenses.groupedepenses.index')}}" 
                                class="nav-link {{ setMenuClass('administration.groupedepenses.groupedepenses.index', 'active') }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Groupe de dépenses</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('administration.grouperecettes.grouperecettes.index')}}" 
                                class="nav-link {{ setMenuClass('administration.grouperecettes.grouperecettes.index', 'active') }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Groupe de recettes</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('administration.categoriedepenses.categoriedepenses.index')}}" 
                                class="nav-link {{ setMenuClass('administration.categoriedepenses.categoriedepenses.index', 'active') }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Catégories dépenses</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('administration.categorierecettes.categorierecettes.index')}}" 
                                class="nav-link {{ setMenuClass('administration.categorierecettes.categorierecettes.index', 'active') }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Catégories recettes</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan

                @can("utilisateurs")
                    <li class="nav-item">
                        <a href="{{route('users.utilisateurs.index')}}" class="nav-link {{ setMenuClass('users.utilisateurs.index', 'active') }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Utilisateurs
                            </p>
                        </a>
                    </li>
                @endcan
            </ul>
        </nav>

    </div>

</aside>