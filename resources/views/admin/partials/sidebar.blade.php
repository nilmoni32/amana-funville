<!-- Sidebar menu-->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
  <div class="app-sidebar__user">
    <div>
      <p class="app-sidebar__user-name">{{ Auth::guard('admin')->user()->name  }}</p>
      @if(Auth::user()->roles()->first()->name == 'admin')
      <p class="app-sidebar__user-designation"> {{ __('Administrator') }} </p>
      @elseif(Auth::user()->roles()->first()->name == 'order_controller')
      <p class="app-sidebar__user-designation"> {{ __('Order Controller') }} </p>
      @else
      <p class="app-sidebar__user-designation"> {{ __('Generic User') }} </p>
      @endif
    </div>
  </div>
  <ul class="app-menu">
    @can('funville-dashboard')
    <li>
      {{-- if current route name is dashboard we will set active class  --}}
      <a class="app-menu__item {{ Route::currentRouteName() == 'admin.dashboard' ? 'active' : ''}}"
        href="{{route('admin.dashboard')}}">
        <i class="app-menu__icon fa fa-dashboard"></i>
        <span class="app-menu__label">Dashboard</span>
      </a>
    </li>
    @endcan

    @can('manage-reports')
    @php if(Route::currentRouteName() == 'admin.reports.daily' ||
    Route::currentRouteName() == 'admin.reports.dailytotal' ||
    Route::currentRouteName() == 'admin.reports.monthlytotal' ||
    Route::currentRouteName() == 'admin.reports.yearlytotal' ||
    Route::currentRouteName() == 'admin.reports.top20' ||
    Route::currentRouteName() == 'admin.reports.getTop20'||
    Route::currentRouteName() == 'admin.reports.single' ||
    Route::currentRouteName() == 'admin.reports.singleSale'){
    $temp = 1;
    }else{
    $temp = 0;
    }
    @endphp
    <li class="{{ $temp ? 'treeview is-expanded' : 'treeview' }}">
      <a class="app-menu__item" href="#" data-toggle="treeview">
        <i class="app-menu__icon fa fa fa-braille"></i><span class="app-menu__label">Reports</span>
        <i class="treeview-indicator fa fa-angle-right"></i>
      </a>
      <ul class="treeview-menu">
        <li>
          <a class="treeview-item {{ Route::currentRouteName() == 'admin.reports.daily' ? 'active' : '' }}"
            href="{{ route('admin.reports.daily') }}">
            <i class="icon fa fa-circle-o"></i>Item based daily sale</a>
        </li>
        <li>
          <a class="treeview-item {{ Route::currentRouteName() == 'admin.reports.dailytotal' ? 'active' : '' }}"
            href="{{ route('admin.reports.dailytotal') }}">
            <i class="icon fa fa-circle-o"></i>Daily Sale</a>
        </li>
        <li>
          <a class="treeview-item {{ Route::currentRouteName() == 'admin.reports.monthlytotal' ? 'active' : '' }}"
            href="{{ route('admin.reports.monthlytotal') }}">
            <i class="icon fa fa-circle-o"></i>Monthly Sale</a>
        </li>
        <li>
          <a class="treeview-item {{ Route::currentRouteName() == 'admin.reports.yearlytotal' ? 'active' : '' }}"
            href="{{ route('admin.reports.yearlytotal') }}">
            <i class="icon fa fa-circle-o"></i>Yearly Sale</a>
        </li>
        <li>
          <a class="treeview-item {{ Route::currentRouteName() == 'admin.reports.top20' ||
                                      Route::currentRouteName() == 'admin.reports.getTop20'  ? 'active' : '' }}"
            href="{{ route('admin.reports.top20') }}">
            <i class="icon fa fa-circle-o"></i>Item based sale [any Time]</a>
        </li>
        <li>
          <a class="treeview-item {{ Route::currentRouteName() == 'admin.reports.single' ||
           Route::currentRouteName() == 'admin.reports.singleSale' ? 'active' : '' }}"
            href="{{ route('admin.reports.single') }}">
            <i class="icon fa fa-circle-o"></i>Single item sale [any time]</a>
        </li>
      </ul>
    </li>
    @endcan

    @can('manage-orders')
    @php if(Route::currentRouteName() == 'admin.sales.index'){
    $temp1 = 1;
    }else{
    $temp1 = 0;
    }
    @endphp
    <li class="{{ $temp1 ? 'treeview is-expanded' : 'treeview' }}">
      <a class="app-menu__item" href="#" data-toggle="treeview">
        <i class="app-menu__icon fa fa-product-hunt"></i><span class="app-menu__label">POS</span>
        <i class="treeview-indicator fa fa-angle-right"></i>
      </a>
      <ul class="treeview-menu">
        <li>
          <a class="treeview-item" href="#">
            <i class="app-menu__icon fa fa-database"></i>
            <span class="app-menu__label">POS Sales Report</span>
          </a>
        </li>
        <li>
          <a class="treeview-item {{ Route::currentRouteName() == 'admin.sales.index' ? 'active' : '' }}"
            href="{{ route('admin.sales.index') }}">
            <i class="app-menu__icon fa fa-calculator"></i>
            <span class="app-menu__label">POS Sales</span>
          </a>
        </li>
      </ul>
    </li>
    <li>
      <a class="app-menu__item {{ Route::currentRouteName() == 'admin.orders.index' ? 'active' : '' }}"
        href="{{ route('admin.orders.index') }}">
        <i class="app-menu__icon fa fa-bar-chart"></i>
        <span class="app-menu__label">Manage Orders</span>
      </a>
    </li>
    @endcan

    @can('all-admin-features')
    <li>
      {{-- if current route name is admin.categories.index we will set active class here --}}
      <a class="app-menu__item {{ Route::currentRouteName() == 'admin.categories.index' ? 'active' : '' }}"
        href="{{ route('admin.categories.index')}}">
        <i class="app-menu__icon fa fa-tags"></i>
        <span class="app-menu__label">Categories</span></a>
    </li>
    <li>
      {{-- if current route name is admin.products.index we will set active class here --}}
      <a class="app-menu__item {{ Route::currentRouteName() == 'admin.products.index' ? 'active' : '' }}"
        href="{{ route('admin.products.index') }}">
        <i class="app-menu__icon fa fa-cutlery"></i>
        <span class="app-menu__label">Food Menu</span></a>
    </li>
    @php if(Route::currentRouteName() == 'admin.adduser.form' ||
    Route::currentRouteName() == 'admin.users.index' ){
    $temp2 = 1;
    }else{
    $temp2 = 0;
    }
    @endphp
    <li class="{{ $temp2 ? 'treeview is-expanded' : 'treeview' }}">
      <a class="app-menu__item" href="#" data-toggle="treeview">
        <i class="app-menu__icon fa fa-users"></i><span class="app-menu__label">Manage Users</span>
        <i class="treeview-indicator fa fa-angle-right"></i>
      </a>
      <ul class="treeview-menu">
        <li>
          {{-- if current route name is admin.settings we will set active class here --}}
          <a class="treeview-item {{ Route::currentRouteName() == 'admin.adduser.form' ? 'active' : '' }}"
            href="{{ route('admin.adduser.form') }}">
            <i class="app-menu__icon fa fa-user"></i>
            <span class="app-menu__label">Add User</span></a>
        </li>
        <li>
          {{-- if current route name is admin.settings we will set active class here --}}
          <a class="treeview-item {{ Route::currentRouteName() == 'admin.users.index' ? 'active' : '' }}"
            href="{{ route('admin.users.index') }}">
            <i class="app-menu__icon fa fa-user"></i>
            <span class="app-menu__label">Edit Users & Roles</span></a>
        </li>
      </ul>
    </li>
    <li>
      {{-- if current route name is admin.settings we will set active class here --}}
      <a class="app-menu__item {{ Route::currentRouteName() == 'admin.settings' ? 'active' : '' }}"
        href="{{ route('admin.settings')}}">
        <i class="app-menu__icon fa fa-cogs"></i>
        <span class="app-menu__label">Settings</span></a>
    </li>
    @php if(Route::currentRouteName() == 'admin.districts.index' ||
    Route::currentRouteName() == 'admin.zones.index' ||
    Route::currentRouteName() == 'admin.zones.getall' ){
    $temp4 = 1;
    }else{
    $temp4 = 0;
    }
    @endphp
    <li class="{{ $temp4 ? 'treeview is-expanded' : 'treeview' }}">
      <a class="app-menu__item" href="#" data-toggle="treeview">
        <i class="app-menu__icon fa fa-map-marker"></i><span class="app-menu__label">User Location</span>
        <i class="treeview-indicator fa fa-angle-right"></i>
      </a>
      <ul class="treeview-menu">
        <li>
          {{-- if current route name is dashboard we will set active class  --}}
          <a class="treeview-item {{ Route::currentRouteName() == 'admin.districts.index' ? 'active' : ''}}"
            href="{{route('admin.districts.index')}}">
            <i class="app-menu__icon fa fa-map-signs"></i>
            <span class="app-menu__label">Manage District</span>
          </a>
        </li>
        <li>
          {{-- if current route name is dashboard we will set active class  --}}
          <a class="treeview-item {{ Route::currentRouteName() == 'admin.zones.index' ||
          Route::currentRouteName() == 'admin.zones.getall' ? 'active' : ''}}" href="{{route('admin.zones.index')}}">
            <i class="app-menu__icon fa fa-map-signs"></i>
            <span class="app-menu__label">Manage Area</span>
          </a>
        </li>
      </ul>
    </li>
    @php if(Route::currentRouteName() == 'admin.services.create' ||
    Route::currentRouteName() == 'admin.services.index' ){
    $temp3 = 1;
    }else{
    $temp3 = 0;
    }
    @endphp
    <li class="{{ $temp3 ? 'treeview is-expanded' : 'treeview' }}">
      <a class="app-menu__item" href="#" data-toggle="treeview">
        <i class="app-menu__icon fa fa-paw"></i><span class="app-menu__label">Manage Services</span>
        <i class="treeview-indicator fa fa-angle-right"></i>
      </a>
      <ul class="treeview-menu">
        <li>
          {{-- if current route name is admin.settings we will set active class here --}}
          <a class="treeview-item {{ Route::currentRouteName() == 'admin.services.create' ? 'active' : '' }}"
            href="{{ route('admin.services.create')}}">
            <i class="app-menu__icon fa fa-crosshairs"></i>
            <span class="app-menu__label">Add Services</span></a>
        </li>
        <li>
          {{-- if current route name is admin.settings we will set active class here --}}
          <a class="treeview-item {{ Route::currentRouteName() == 'admin.services.index' ? 'active' : '' }}"
            href="{{ route('admin.services.index') }}">
            <i class="app-menu__icon fa fa-crosshairs"></i>
            <span class="app-menu__label">All Services</span></a>
        </li>
      </ul>
    </li>
    @endcan





  </ul>
</aside>