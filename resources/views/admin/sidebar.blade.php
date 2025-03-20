<div class="d-flex align-items-stretch">
      <!-- Sidebar Navigation-->
      <nav id="sidebar">
        <!-- Sidebar Header-->
        <div class="sidebar-header d-flex align-items-center">
          <div class="avatar"><img src="{{ asset('admin/img/avatar-6.jpg') }}" alt="..." class="img-fluid rounded-circle"></div>
          <div class="title">
            <h1 class="h5">{{ Auth::user()->name }}</h1>
            <p>{{ ucfirst(Auth::user()->usertype) }}</p>
          </div>
        </div>
        <!-- Sidebar Navidation Menus-->
        <span class="heading">Menu</span>
        <ul class="list-unstyled">
          @if(Auth::user()->usertype == 'admin')
            <li class="{{ Request::is('home') ? 'active' : '' }}">
              <a href="{{ url('/home') }}"> <i class="icon-home"></i>Accueil </a>
            </li>
            <li class="{{ Request::is('managers*') ? 'active' : '' }}">
              <a href="{{ route('managers') }}"> <i class="fa fa-users"></i>Gestionnaires </a>
            </li>
          @elseif(Auth::user()->usertype == 'gestionnaire')
            <li class="{{ Request::is('home') ? 'active' : '' }}">
              <a href="{{ url('/home') }}"> <i class="icon-home"></i>Accueil </a>
            </li>
            <li class="{{ Request::is('food*') ? 'active' : '' }}">
              <a href="#foodDropdown" aria-expanded="false" data-toggle="collapse"> 
                <i class="fa fa-utensils"></i>Menu 
              </a>
              <ul id="foodDropdown" class="collapse list-unstyled">
                <li><a href="{{ url('add_food') }}">Ajouter un menu</a></li>
                <li><a href="{{ url('view_food') }}">Voir les menus</a></li>
              </ul>
            </li>
            <li class="{{ Request::is('orders*') ? 'active' : '' }}">
              <a href="{{ url('orders') }}"> 
                <i class="fa fa-shopping-cart"></i>Commandes 
              </a>
            </li>
            <li class="{{ Request::is('reservations*') ? 'active' : '' }}">
              <a href="{{ url('reservations') }}"> 
                <i class="fa fa-calendar"></i>Réservations 
              </a>
            </li>
          @endif
        </ul>
      </nav>
      <!-- Sidebar Navigation end-->