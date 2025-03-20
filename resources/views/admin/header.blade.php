<header class="header">   
      <nav class="navbar navbar-expand-lg">
        <div class="search-panel">
          <div class="search-inner d-flex align-items-center justify-content-center">
            <div class="close-btn">Close <i class="fa fa-close"></i></div>
            <form id="searchForm" action="#">
              <div class="form-group">
                <input type="search" name="search" placeholder="What are you searching for...">
                <button type="submit" class="submit">Search</button>
              </div>
            </form>
          </div>
        </div>
        <div class="container-fluid d-flex align-items-center justify-content-between">
          <div class="navbar-header">
            <div class="brand-text brand-big visible text-uppercase">
              @if(Auth::user()->usertype == 'gestionnaire')
                <strong class="text-primary">Dark</strong><strong>Gest</strong>
              @else
                <strong class="text-primary">Dark</strong><strong>Admin</strong>
              @endif
            </div>
            <div class="brand-text brand-sm"><strong class="text-primary">D</strong><strong>A</strong></div>
            <!-- Sidebar Toggle Btn-->
            <button class="sidebar-toggle"><i class="fa fa-long-arrow-left"></i></button>
          </div>
          
          <!-- Log out -->
          <div class="list-inline-item logout">           
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <input class="btn btn-primary" type="submit" value="Logout">
            </form>        
          </div>
        </div>
      </nav>
    </header>

<div class="right-menu list-inline no-margin-bottom">    
    <!-- Notifications -->
    <div class="list-inline-item dropdown">
        <a id="navbarDropdownMenuLink1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link messages-toggle">
            <i class="icon-email"></i>
            @if(auth()->user()->unreadNotifications->count() > 0)
                <span class="badge dashbg-1">{{ auth()->user()->unreadNotifications->count() }}</span>
            @endif
        </a>
        <div aria-labelledby="navbarDropdownMenuLink1" class="dropdown-menu messages">
            @foreach(auth()->user()->unreadNotifications as $notification)
                <a href="{{ url('/orders') }}" class="dropdown-item message d-flex align-items-center">
                    <div class="content">
                        <strong class="d-block">Commande #{{ $notification->data['order_id'] }}</strong>
                        <span class="d-block">{{ $notification->data['customer_name'] }}</span>
                        <small class="date d-block">{{ number_format($notification->data['price'], 2) }} €</small>
                    </div>
                </a>
            @endforeach
            @if(auth()->user()->unreadNotifications->count() > 0)
                <a href="#" class="dropdown-item text-center message" onclick="event.preventDefault(); document.getElementById('mark-as-read').submit();">
                    Marquer comme lu
                </a>
                <form id="mark-as-read" action="{{ url('/mark-notifications-as-read') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @else
                <a href="#" class="dropdown-item text-center message">
                    Pas de nouvelles notifications
                </a>
            @endif
        </div>
    </div>
    <!-- Autres éléments du menu -->
</div>