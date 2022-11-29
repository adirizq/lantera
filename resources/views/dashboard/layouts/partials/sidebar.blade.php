<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header position-relative">
            <div class="d-flex justify-content-between align-items-center">
                <div class="logo">
                    <a href="index.html"><img src="{{ asset('assets/images/logo/logo.png') }}" alt="Logo" srcset="" style="height: 3rem !important"></a>
                </div>
                <div class="sidebar-toggler  x">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                @if (auth()->user()->role == 0)
                    <li class="sidebar-item">
                        <div class="w-100 bg-light-primary p-3" style="border-radius: 0.5rem">
                            <span class="badge bg-danger m-0">Admin</span>
                            <br>
                            <span class="badge bg-primary mt-2">Admin Lantera</span>
                        </div>
                    </li>
                @elseif (auth()->user()->role == 1)
                    <li class="sidebar-item">
                        <div class="w-100 bg-light-primary p-3" style="border-radius: 0.5rem">
                            <span class="badge bg-success m-0">Puskesmas</span>
                            <br>
                            <span class="badge bg-primary mt-2">{{ auth()->user()->puskesmas->nama_puskesmas }}</span>
                        </div>
                    </li>
                @endif

                <li class="sidebar-title">Menu</li>

                <li class="sidebar-item {{ $page == 'Dashboard' ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                @if (auth()->user()->role == 0)
                    <li class="sidebar-item {{ $page == 'Puskesmas' ? 'active' : '' }}">
                        <a href="{{ route('usersPuskesmas') }}" class='sidebar-link'>
                            <i class="bi bi-hospital-fill"></i>
                            <span>Puskesmas</span>
                        </a>
                    </li>
                @elseif (auth()->user()->role == 1)
                    <li class="sidebar-item {{ $page == 'Posyandu' ? 'active' : '' }}">
                        <a href="{{ route('posyandu.index') }}" class='sidebar-link'>
                            <i class="bi bi-hospital-fill"></i>
                            <span>Posyandu</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{ $page == 'Kader' ? 'active' : '' }}">
                        <a href="{{ route('kader.index') }}" class='sidebar-link'>
                            <i class="bi bi-person-fill"></i>
                            <span>Kader</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{ $page == 'Lansia' ? 'active' : '' }}">
                        <a href="{{ route('lansia.index') }}" class='sidebar-link'>
                            <i class="bi bi-person-fill"></i>
                            <span>Lansia</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{ $page == 'Data Pemeriksaan' ? 'active' : '' }}">
                        <a href="{{ route('pemeriksaan.index') }}" class='sidebar-link'>
                            <i class="bi bi-file-earmark-medical-fill"></i>
                            <span>Data Pemeriksaan</span>
                        </a>
                    </li>
                @endif

                {{-- <li class="sidebar-item has-sub {{ in_array($page, ['Puskesmas', 'Kader']) ? 'active' : '' }}">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-person-fill"></i>
                        <span>Users</span>
                    </a>
                    <ul class="submenu ">
                        @can('Admin')
                            <li class="submenu-item {{ $page == 'Puskesmas' ? 'active' : '' }}">
                                <a href="{{ route('usersPuskesmas') }}">Puskesmas</a>
                            </li>
                        @endcan
                        <li class="submenu-item {{ $page == 'Kader' ? 'active' : '' }}">
                            <a href="component-badge.html">Kader</a>
                        </li>
                    </ul>
                </li> --}}

                <li class="sidebar-item mt-5">
                    <a class='sidebar-link bg-danger' href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bi bi-box-arrow-left text-white"></i>
                        <span class="text-white">Logout</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>
