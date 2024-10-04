<ul class="navbar-nav  sidebar sidebar-dark accordion" style="background-color:#a96a68 !important;" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/user/dashboard') }}">

        <div class="sidebar-brand-icon mx-3">
            {{-- <i class=""> --}}
            <img src="{{ asset('web/media/images/logo.png') }}" width="100%">
            {{-- </i> --}}
        </div>
        {{-- <div class="sidebar-brand-text mx-3">AMBÉR</div> --}}
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Interface
    </div>


    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsefour"
            aria-expanded="true" aria-controls="collapsefour">
            <i class="fas fa-fw fa-folder-plus"></i>
            <span>Orders</span>
        </a>
        <div id="collapsefour" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Orders:</h6>
                <a class="collapse-item" href="{{ url('/user/orders/index') }}">Order Histry</a>
            </div>
        </div>
    </li>


    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
