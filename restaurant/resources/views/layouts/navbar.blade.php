<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="index3.html" class="nav-link">Home</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="#" class="nav-link">Contact</a>
    </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <!-- Navbar Search -->
    <li class="nav-item">
      <a class="nav-link" data-widget="navbar-search" href="#" role="button">
        <i class="fas fa-search"></i>
      </a>
      <div class="navbar-search-block">
        <form class="form-inline">
          <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-navbar" type="submit">
                <i class="fas fa-search"></i>
              </button>
              <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
        </form>
      </div>
    </li>

    <!-- Messages Dropdown Menu -->
    
    <!-- Notifications Dropdown Menu -->
    
    <li class="nav-item">
      <a class="nav-link" data-widget="fullscreen" href="#" role="button">
        <i class="fas fa-expand-arrows-alt"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
        <i class="fas fa-th-large"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" role="button">
        <i class=""><img src="https://img.icons8.com/cotton/24/000000/shutdown--v1.png"/> Logout</i>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
              @csrf
          </form>
      </a>
    </li>
  </ul>
</nav>
  <!-- /.navbar -->

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="/" class="brand-link">
    <img src="{{ asset('admin/img/restau-logo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">Restaurant</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{ Auth::user()->avatar }}" class="img-circle elevation-2" alt="Profile Picture">
      </div>
      <div class="info">
        <a href="#" class="d-block">{{ Auth::user()->name }}</a>
      </div>
    </div>

    

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-item {{ request()->is('admin/'.Auth::user()->role.'/dashboard') ? 'menu-open' : '' }}{{ request()->is(Auth::user()->role.'/'.Auth::user()->role.'/profile') ? 'menu-open' : '' }}
          {{ request()->is('change-password') ? 'menu-open' : '' }}">
          <a href="#" class="nav-link ">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              @if (Auth::user()->role == 'admin')
                Admin
              @elseif (Auth::user()->role == 'staff')
                Staff
              @elseif (Auth::user()->role == 'client')
                Client
              @endif

              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{route('dashboard', ['slug' => Auth::user()->role])}}" class="nav-link {{ request()->is('admin/'.Auth::user()->role.'/dashboard') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Dashboard</p>
              </a>
            </li>
            {{-- <li class="nav-item">
              <a href="{{route(Auth::user()->role.'_profile')}}" class="nav-link {{ request()->is(Auth::user()->role.'/profile') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Profile</p>
              </a>
            </li> --}}
            <li class="nav-item">
              <a href="{{route('change_pass')}}" class="nav-link {{ request()->is('change-password') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Change Password</p>
              </a>
            </li>
          </ul>
        </li>
        
        @if (Auth::user()->role == 'admin')
        <li class="nav-item {{ request()->is('admin/admin/add-user/staff') ? 'menu-open' : '' }}
          {{ request()->is('admin/admin/users/staff') ? 'menu-open' : '' }}">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-edit"></i>
            <p>
              Manage Staff
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            
            <li class="nav-item">
              <a href="{{route('add_user', ['slug' => Auth::user()->role, 'role' => 'staff'])}}" class="nav-link {{ request()->is('admin/admin/add-user/staff') ? 'active' : '' }}">
                <i class="fas fa-user-plus"></i>&nbsp;
                <p>Add Staff</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('show_users', ['role' => 'staff','slug' => Auth::user()->role])}}" class="nav-link {{ request()->is('admin/admin/users/staff') ? 'active' : '' }}">
                <i class="fas fa-eye"></i>&nbsp;
                <p>Show Staffs</p>
              </a>
            </li>
          </ul>
        </li>
        @endif

        @if (Auth::user()->role == 'admin' || Auth::user()->role == 'staff')
        <li class="nav-item {{ request()->is('admin/'.Auth::user()->role.'/add-user/client') ? 'menu-open' : '' }}
          {{ request()->is('admin/'.Auth::user()->role.'/users/client') ? 'menu-open' : '' }}">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-edit"></i>
            <p>
              Manage Client
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            
            <li class="nav-item">
              <a href="{{route('add_user', ['role' => 'client','slug' => Auth::user()->role])}}" class="nav-link {{ request()->is('admin/'.Auth::user()->role.'/add-user/client') ? 'active' : '' }}">
                <i class="fas fa-user-plus"></i>&nbsp;
                <p>Add Client</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('show_users', ['slug' => Auth::user()->role, 'role' => 'client'])}}" class="nav-link {{ request()->is('admin/'.Auth::user()->role.'/users/client') ? 'active' : '' }}">
                <i class="fas fa-eye"></i>&nbsp;
                <p>Show Clients</p>
              </a>
            </li>
          </ul>
        </li>
        @endif

        @if (Auth::user()->role == 'admin' || Auth::user()->role == 'client')
        <li class="nav-item {{ request()->is('admin/'.Auth::user()->role.'/add-restaurant') ? 'menu-open' : '' }}
          {{ request()->is('admin/'.Auth::user()->role.'/restaurants') ? 'menu-open' : '' }}">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-edit"></i>
            <p>
              Manage Restaurant
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            
            <li class="nav-item">
              <a href="{{route('add_restaurant', ['slug' => Auth::user()->role])}}" class="nav-link {{ request()->is('admin/'.Auth::user()->role.'/add-restaurant') ? 'active' : '' }}">
                <i class="fas fa-plus"></i>&nbsp;
                <p>Add Restaurant</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('show_restaurants', ['slug' => Auth::user()->role])}}" class="nav-link {{ request()->is('admin/'.Auth::user()->role.'/restaurants') ? 'active' : '' }}">
                <i class="fas fa-eye"></i>&nbsp;
                <p>Show Restaurants</p>
              </a>
            </li>
          </ul>
        </li>
        @endif

        @if (Auth::user()->role == 'admin' || Auth::user()->role == 'client')
        <li class="nav-item {{ request()->is('admin/'.Auth::user()->role.'/add-menu') ? 'menu-open' : '' }}
          {{ request()->is('admin/'.Auth::user()->role.'/menus') ? 'menu-open' : '' }}">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-edit"></i>
            <p>
              Menu & Categorys
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            
            <li class="nav-item">
              <a href="{{route('add_menu', ['slug' => Auth::user()->role])}}" class="nav-link {{ request()->is('admin/'.Auth::user()->role.'/add-menu') ? 'active' : '' }}">
                <i class="fas fa-plus"></i>&nbsp;
                <p>Add Menu</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('show_menus', ['slug' => Auth::user()->role])}}" class="nav-link {{ request()->is('admin/'.Auth::user()->role.'/menus') ? 'active' : '' }}">
                <i class="fas fa-eye"></i>&nbsp;
                <p>Show Menus</p>
              </a>
            </li>
          </ul>
        </li>
        @endif

        @if (Auth::user()->role == 'admin' || Auth::user()->role == 'client')
        <li class="nav-item {{ request()->is('admin/'.Auth::user()->role.'/add-product') ? 'menu-open' : '' }}
          {{ request()->is('admin/'.Auth::user()->role.'/products') ? 'menu-open' : '' }}">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-edit"></i>
            <p>
              Manage Product
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            
            <li class="nav-item">
              <a href="{{route('add_product', ['slug' => Auth::user()->role])}}" class="nav-link {{ request()->is('admin/'.Auth::user()->role.'/add-product') ? 'active' : '' }}">
                <i class="fas fa-plus"></i>&nbsp;
                <p>Add Product</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('show_products', ['slug' => Auth::user()->role])}}" class="nav-link {{ request()->is('admin/'.Auth::user()->role.'/products') ? 'active' : '' }}">
                <i class="fas fa-eye"></i>&nbsp;
                <p>Show Products</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="{{route('getOrders', ['slug' => Auth::user()->role])}}" class="nav-link {{ request()->is('admin/'.Auth::user()->role.'/orders') ? 'active' : '' }}">
            <i class="nav-icon fas fa-th"></i>
            <p>
              Orders
            </p>
          </a>
        </li>
        @endif

        {{-- <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-th"></i>
            <p>
              Simple New Link
              <span class="right badge badge-danger">New</span>
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-th"></i>
            <p>
              Simple Link
            </p>
          </a>
        </li> --}}
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>