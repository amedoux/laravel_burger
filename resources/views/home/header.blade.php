<!-- Navbar -->
<nav class="custom-navbar navbar navbar-expand-lg navbar-dark fixed-top" data-spy="affix" data-offset-top="10">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="#home">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#about">À propos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#gallary">Galerie</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#book-table">Réserver une Table</a>
                </li>
            </ul>
            <a class="navbar-brand m-auto" href="{{url('/')}}">
                <img src="assets/imgs/logo.svg" class="brand-img" alt="">
                <span class="brand-txt">ISI BURGER</span>
            </a>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="#blog">Food<span class="sr-only">(current)</span></a>
                </li>

                @if (Route::has('login'))

                  @auth


                         <li class="nav-item">
                            <a class="nav-link" href="{{url('my_cart')}}">Panier</a>
                        </li>





                        <form action="{{route('logout')}}" method="POST">
                            @csrf
                             <input class="btn btn-primary ml-xl-4" type="submit" value="logout">

                        </form>

                @else


                    <li class="nav-item">
                        <a class="nav-link" href="{{route('login')}}">Se connecter</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('register')}}">S'inscrire</a>
                    </li>


                    @endauth
                @endif


            </ul>
        </div>
    </nav>
    <!-- header -->
    <header id="home" class="header">
        <div class="overlay text-white text-center">
            <h1 class="display-2 font-weight-bold my-3">ISI BURGER</h1>
            <h2 class="display-4 mb-5">Toujours frais &amp; délicieux</h2>
            <a class="btn btn-lg btn-primary" href="#gallary">Voir Notre Galerie</a>
        </div>
    </header>