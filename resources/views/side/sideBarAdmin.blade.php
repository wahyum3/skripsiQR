<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Warehouse V to V Export</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('asset/images/logos/TTLC.jpg') }}" />
    <link rel="stylesheet" href="{{ asset('asset/css/styles.min.css') }}">

</head>

<body>
    <div id="sales-overview"></div>
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <aside class="left-sidebar">
            <!-- SIDE BAR -->
            <div class="brand-logo d-flex align-items-center justify-content-between">
                <a href="./index.html" class="text-nowrap logo-img">
                    <img src="{{ asset('asset/images/logos/TTLC_mini.jpeg') }}" alt="" />
                </a>
                <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                    <i class="ti ti-x fs-6"></i>
                </div>
            </div>
            <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
                <ul id="sidebarnav">
                    <li class="nav-small-cap">
                        <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4"></iconify-icon>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('admin.dashboard') }}" aria-expanded="false">
                            <i class="ti ti-atom"></i>
                            <span class="hide-menu">Dashboard</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="#" aria-expanded="false">
                            <i class="ti ti-atom"></i>
                            <span class="hide-menu">List User</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('admin.qr.show') }}" aria-expanded="false">
                            <i class="ti ti-atom"></i>
                            <span class="hide-menu">Generate QR</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('admin.updateMaterial') }}" aria-expanded="false">
                            <i class="ti ti-atom"></i>
                            <span class="hide-menu">Data Material Update</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- HEADER -->
        <header class="app-header">
            <nav class="navbar navbar-expand-lg navbar-light">
                <ul class="navbar-nav" aria-expanded="false">
                    <li class="nav-item d-block d-xl-none">
                        <a class="nav-link sidebartoggler " id="headerCollapse" href="javascript:void(0)">
                            <i class="ti ti-menu-2"></i>
                        </a>
                    </li>
                </ul>
                <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
                    <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end" aria-expanded="false" aria-labelledby="drop2">
                        <li class="nav-item dropdown">
                            <a class="nav-link " href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="{{ asset('asset/images/profile/user-1.jpg') }}" alt="" width="35" height="35" class="rounded-circle">
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                                <div class="message-body">
                                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                                        <i class="ti ti-user fs-6"></i>
                                        <p class="mb-0 fs-3">My Profile</p>
                                    </a>
                                    <form method="POST" action="{{ route('logout') }}" class="mx-3 mt-2 d-block">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-primary w-100">
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('/asset/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('/asset/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('/asset/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('/asset/js/app.min.js') }}"></script>
    <script src="{{ asset('/asset/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script src="{{ asset('/asset/libs/simplebar/dist/simplebar.js') }}"></script>
    <script src="{{ asset('/asset/js/dashboard.js') }}"></script>
    <!-- solar icons -->
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


</body>