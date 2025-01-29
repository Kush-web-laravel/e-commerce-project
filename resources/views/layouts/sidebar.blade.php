<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{asset('dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Alexander Pierce</a>
        </div>
      </div>
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

          <li class="nav-item">
            <a href="{{ route('dashboard-view') }}" class="nav-link {{ setActiveClass('dashboard-view') }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item {{ (Route::currentRouteName() == 'subAdmin-view') || (Route::currentRouteName() == 'addSubAdmin-view') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ (Route::currentRouteName() == 'subAdmin-view') || (Route::currentRouteName() == 'addSubAdmin-view') ? 'active' : '' }}">
              <i class="nav-icon fas fa-user-tie"></i>
              <p>
                SubAdmin
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('subAdmin-view') }}" class="nav-link {{ setActiveClass('subAdmin-view') }}">
                <i class="far fa-circle nav-icon"></i>
                  <p>
                    SubAdmin
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('addSubAdmin-view') }}" class="nav-link {{ setActiveClass('addSubAdmin-view') }}">
                <i class="far fa-circle nav-icon"></i>
                  <p>
                    Add SubAdmin
                  </p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item {{ (Route::currentRouteName() == 'category-view') || (Route::currentRouteName() == 'addCategory-view') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ (Route::currentRouteName() == 'category-view') || (Route::currentRouteName() == 'addCategory-view') ? 'active' : '' }}">
            <i class="nav-icon fas fa-table"></i>
              <p>
                Category
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('category-view') }}" class="nav-link {{ setActiveClass('category-view') }}">
                <i class="far fa-circle nav-icon"></i>
                  <p>
                    Category
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('addCategory-view') }}" class="nav-link {{ setActiveClass('addCategory-view') }}">
                <i class="far fa-circle nav-icon"></i>
                  <p>
                    Add Category
                  </p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item {{ (Route::currentRouteName() == 'subcategory-view') || (Route::currentRouteName() == 'addSubCategory-view') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ (Route::currentRouteName() == 'subcategory-view') || (Route::currentRouteName() == 'addSubCategory-view') ? 'active' : '' }}">
            <i class="nav-icon fas fa-network-wired"></i>
              <p>
                SubCategory
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('subcategory-view') }}" class="nav-link {{ setActiveClass('subcategory-view') }}">
                <i class="far fa-circle nav-icon"></i>
                  <p>
                    SubCategory
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('addSubCategory-view') }}" class="nav-link {{ setActiveClass('addSubCategory-view') }}">
                <i class="far fa-circle nav-icon"></i>
                  <p>
                    Add SubCategory
                  </p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item {{ (Route::currentRouteName() == 'product-view') || (Route::currentRouteName() == 'addProduct-view') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ (Route::currentRouteName() == 'product-view') || (Route::currentRouteName() == 'addProduct-view') ? 'active' : '' }}">
            <i class="nav-icon fas fa-box"></i>
              <p>
                Products
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('product-view') }}" class="nav-link {{ setActiveClass('product-view') }}">
                <i class="far fa-circle nav-icon"></i>
                  <p>
                    Products
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('addProduct-view') }}" class="nav-link {{ setActiveClass('addProduct-view') }}">
                <i class="far fa-circle nav-icon"></i>
                  <p>
                    Add Products
                  </p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="{{ route('orders-view') }}" class="nav-link {{ setActiveClass('orders-view') }}">
            <i class="nav-icon fas fa-clipboard-check"></i>
              <p>
                Orders
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>