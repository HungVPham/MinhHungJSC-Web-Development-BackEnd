<style>
  #user-panel-img {height: auto; width: 2.5rem;}
  .sidebar-dark-primary .nav-sidebar>.nav-item>.nav-link.active, .sidebar-light-primary .nav-sidebar>.nav-item>.nav-link.active {background-color: #cb1c22 !important;}
  #logo-panel-img {opacity: 0.8;}
</style>
<!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/') }}" class="brand-link">
      <img src="{{ asset('images/admin_images/logo.png') }}" alt="MingHungJSC Logo" class="brand-image img-circle elevation-3" id="logo-panel-img">
      <span class="brand-text">MINH HUNG JSC</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <?php $admin_image_path = "images/admin_images/admin_photos/".Auth::guard('admin')->user()->image; ?>
          @if(!empty(Auth::guard('admin')->user()->image)&& file_exists($admin_image_path))
          <img src="{{ asset('images/admin_images/admin_photos/'.Auth::guard('admin')->user()->image) }}" class="img-circle elevation-2" id="user-panel-img" alt="User Image">
          @else
          <img src="{{ asset('images/admin_images/admin_photos/no-image.jpg') }}" class="img-circle elevation-2" id="user-panel-img" alt="User Image">
          @endif
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ ucwords(Auth::guard('admin')->user()->name) }}</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Tìm Kiếm" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">

        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            @if(Session::get('page')=="dashboard")
              <?php $active = "active"; ?>
            @else
              <?php $active = ""; ?>
            @endif     
          <li class="nav-item">
            <a href="{{ url('admin/dashboard') }}" class="nav-link {{ $active }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Bảng Điều Khiển
                </p>
            </a>
          </li>

             <!-- Settings -->
          @if(Session::get('page')=="settings" || Session::get('page')=="update-admin-details")
              <?php $active = "active"; ?>
            @else
              <?php $active = ""; ?>
          @endif
          <li class="nav-item menu-open">
            <a href="#" class="nav-link {{ $active }}">
              <i class="nav-icon fas fa-user-cog"></i>
              <p>
                Cài Đặt
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            @if(Session::get('page')=="settings")
                <?php $active = "active"; ?>
              @else
                <?php $active = ""; ?>
               @endif
              <li class="nav-item">
                <a href="{{ url('admin/settings') }}" class="nav-link {{ $active }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Cài Đặt An Ninh</p>
                </a>
              </li>
              @if(Session::get('page')=="update-admin-details")
                <?php $active = "active"; ?>
              @else
                <?php $active = ""; ?>
               @endif
              <li class="nav-item">
                <a href="{{ url('admin/update-admin-details') }}" class="nav-link {{ $active }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Cài Đặt Thông Tin</p>
                </a>
              </li>
            </ul>
          </li>

          <!-- Catalouges -->
          @if(Session::get('page')=="sections" || Session::get('page')=="categories" || Session::get('page')=="products")
              <?php $active = "active"; ?>
            @else
              <?php $active = ""; ?>
          @endif
          <li class="nav-item menu-open">
            <a href="#" class="nav-link {{ $active }}">
              <i class="nav-icon fas fa-th-list"></i>
              <p>
                Catalouges
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @if(Session::get('page')=="sections")
                <?php $active = "active"; ?>
              @else
                <?php $active = ""; ?>
              @endif
              <li class="nav-item">
                <a href="{{ url('admin/sections') }}" class="nav-link {{ $active }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Danh Mục Sản Phẩm</p>
                </a>
              </li>
              @if(Session::get('page')=="categories")
                <?php $active = "active"; ?>
              @else
                <?php $active = ""; ?>
               @endif
              <li class="nav-item">
                <a href="{{ url('admin/categories') }}" class="nav-link {{ $active }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Thể Loại Sản Phẩm</p>
                </a>
              </li>
              @if(Session::get('page')=="products")
                <?php $active = "active"; ?>
              @else
                <?php $active = ""; ?>
               @endif
              <li class="nav-item">
                <a href="{{ url('admin/products') }}" class="nav-link {{ $active }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Sản Phẩm</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>

      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>