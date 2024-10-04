<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color: #2D334A!important;">
    {{-- <ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color: #451a61!important; color: #451a61!important;"> --}}
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/admin/dashboard') }}">

        <div class="sidebar-brand-icon mx-3">
            <img src="{{ asset('images/logo.png') }}" width="50%">
{{-- <h5>Customer Address Book</h5> --}}
        </div>

    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ url('/admin/dashboard') }}">
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
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCustomer"
            aria-expanded="true" aria-controls="collapseCustomer">
            <i class="fas fa-fw fa-user"></i>
            <span>Customer Details</span>
        </a>
        <div id="collapseCustomer" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Customer Components:</h6>
                <a class="collapse-item" href="{{ url('/admin/customer') }}">Manage Customer</a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilitiesProjects"
            aria-expanded="true" aria-controls="collapseUtilitiesProjects">
            <i class="fas fa-file-import"></i>
            <span>Projects</span>
        </a>
        <div id="collapseUtilitiesProjects" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Projects Components:</h6>
                <a class="collapse-item" href="{{ url('/admin/project') }}">Projects</a>
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
