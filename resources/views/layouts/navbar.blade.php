<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile border-bottom">
            <a href="#" class="nav-link">
                <div class="nav-profile-image p-2">
                    {{-- <img src="{{ asset('assets/images/faces/face1.jpg') }}" alt="profile"> --}}
                    <i class="fa fa-user mt-1"></i>
                    <span class="login-status online"></span>
                    <!--change to offline or busy as needed-->
                </div>
                <div class="nav-profile-text d-flex flex-column ">
                    <span class="font-weight-bold mb-2">{{ Auth::user()->name }}</span>
                    <span class="text-secondary text-small">{{ Auth::user()->roles[0]->name }}</span>
                </div>
                {{-- <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i> --}}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('home') }}">
                <span class="menu-title">Dashboard</span>
                <i class="mdi mdi-home menu-icon"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                <span class="menu-title">Projects</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-crosshairs-gps menu-icon"></i>
            </a>
            <div class="collapse" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                    @if (Auth::user()->roles[0]->name != 'User')
                        <li class="">
                            <a class="btn btn-sm btn-primary shadow-none d-flex align-items-center justify-content-center text-nowrap gap-2" href="{{ route('project.create') }}">
                                <i class="fa fa-plus"></i> Add New Project
                            </a>
                        </li>
                    @endif

                    @foreach ($projects as $item)
                        <li class="nav-item">
                            <a class="nav-link " href="{{ route('tasks.index') }}/{{ $item->id }}">
                                {{ $item->title }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </li>
        {{-- <li class="nav-item">
            <a class="nav-link" href="{{ route('projects.index') }}">
                <span class="menu-title">Projects</span>
                <i class="mdi mdi-contacts menu-icon"></i>
            </a>
        </li> --}}
        @if (Auth::user()->roles[0]->name != 'User')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('teams.index') }}">
                    <span class="menu-title">Teams</span>
                    <i class="mdi mdi-format-list-bulleted menu-icon"></i>
                </a>
            </li>
        @endif
        <li class="nav-item">
            <a class="nav-link" href="{{ route('projects.index') }}">
                <span class="menu-title">Project List</span>
                <i class="mdi mdi-format-list-bulleted menu-icon"></i>
            </a>
        </li>
        {{-- <li class="nav-item">
            <a class="nav-link" href="{{ route('tasks.index') }}">
                <span class="menu-title">Tasks</span>
                <i class="mdi mdi-chart-bar menu-icon"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('comments.index') }}">
                <span class="menu-title">Comments</span>
                <i class="mdi mdi-table-large menu-icon"></i>
            </a>
        </li> --}}
        {{-- <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#general-pages" aria-expanded="false"
                aria-controls="general-pages">
                <span class="menu-title">Sample Pages</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-medical-bag menu-icon"></i>
            </a>
            <div class="collapse" id="general-pages">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="pages/samples/blank-page.html"> Blank
                            Page </a></li>
                    <li class="nav-item"> <a class="nav-link" href="pages/samples/login.html"> Login </a>
                    </li>
                    <li class="nav-item"> <a class="nav-link" href="pages/samples/register.html">
                            Register </a></li>
                    <li class="nav-item"> <a class="nav-link" href="pages/samples/error-404.html"> 404
                        </a></li>
                    <li class="nav-item"> <a class="nav-link" href="pages/samples/error-500.html"> 500
                        </a></li>
                </ul>
            </div>
        </li> --}}

    </ul>
</nav>
