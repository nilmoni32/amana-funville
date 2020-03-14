<!-- Sidebar menu-->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
  <div class="app-sidebar__user">
    <div>
      <p class="app-sidebar__user-name">John Doe</p>
      <p class="app-sidebar__user-designation">Frontend Developer</p>
    </div>
  </div>
  <ul class="app-menu">
    <li>
      {{-- if current route name is dashboard we will set active class  --}}
      <a class="app-menu__item {{ Route::currentRouteName() == 'admin.dashboard' ? 'active' : ''}}" href="{{route('admin.dashboard')}}">
        <i class="app-menu__icon fa fa-dashboard"></i>
        <span class="app-menu__label">Dashboard</span>
      </a>      
    </li>    
      {{-- if current route name is admin.categories.index we will set active class here --}}
    <a class="app-menu__item {{ Route::currentRouteName() == 'admin.categories.index' ? 'active' : '' }}" href="{{ route('admin.categories.index')}}">
        <i class="app-menu__icon fa fa-tags"></i>
        <span class="app-menu__label">Categories</span></a>      
    </li>
    <li>
      {{-- if current route name is admin.settings we will set active class here --}}
    <a class="app-menu__item {{ Route::currentRouteName() == 'admin.settings' ? 'active' : '' }}" href="{{ route('admin.settings')}}">
        <i class="app-menu__icon fa fa-cogs"></i>
        <span class="app-menu__label">Settings</span></a>      
    </li>
    <li>
    <li class="treeview">
      <a class="app-menu__item" href="#" data-toggle="treeview">
        <i class="app-menu__icon fa fa-users"></i><span class="app-menu__label">User</span>
        <i class="treeview-indicator fa fa-angle-right"></i>
      </a>
      <ul class="treeview-menu">
        <li>
          <a class="treeview-item" href="#">
            <i class="icon fa fa-circle-o"></i>Admin Users</a>          
        </li>
        <li>
          <a class="treeview-item" href="#" target="_blank" rel="noopener">
            <i class="icon fa fa-circle-o"></i>Roles</a>          
        </li>
        <li>
          <a class="treeview-item" href="#">
            <i class="icon fa fa-circle-o"></i>Permissions</a>
        </li>        
      </ul>
    </li>
  </ul>
</aside>