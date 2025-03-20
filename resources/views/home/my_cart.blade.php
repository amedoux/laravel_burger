<!DOCTYPE html>
<html lang="en">
<head>
	@include('home.css')
    <style>
        table
        {
            margin:40px;
            border:1px solid skyblue;
        }
        th
        {
            padding: 10px;
            text-align:center;
            background-color:skyblue;
            color:white;
            font-weight:bold;

        }
        td
        {
            padding: 10px;
            color:white;
        }
        .div_center
        {
            display:flex;
            justify-content:center;
            align-items:center;
            margin-top:50px;
        }
        label
        {
            display:inline-block;
            width: 200px;
        }
        .div_deg
        {
            padding: 20px;
        }
    </style>
</head>
<body data-spy="scroll" data-target=".navbar" data-offset="40" id="home">
    
    <!-- Navbar -->
<nav class="custom-navbar navbar navbar-expand-lg navbar-dark " data-spy="affix" data-offset-top="10">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="#home">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#about">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#gallary">Gallary</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#book-table">Book-Table</a>
                </li>
            </ul>
            <a class="navbar-brand m-auto" href="{{url('/')}}">
                <img src="assets/imgs/logo.svg" class="brand-img" alt="">
                <span class="brand-txt">ISI BURGER</span>
            </a>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="#blog">Blog<span class="sr-only">(current)</span></a>
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
                        <a class="nav-link" href="{{route('login')}}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('register')}}">Register</a>
                    </li>


                    @endauth
                @endif


            </ul>
        </div>
    </nav>

    <br>

    <div id="gallary" class="text-center bg-dark text-light has-height-md middle-items wow fadeIn">
        <table>
            <tr>
                <th>Nom Menu</th>
                <th>Prix</th>
                <th>Quantite</th>
                <th>Image</th>
                <th>Action</th>
            </tr>

            <?php 
                $total_price = 0;
            ?>


            @foreach($data as $data)
                <tr>
                    <td>{{$data->title}}</td>
                    <td>{{$data->price}}fr</td>
                    <td>{{$data->quantity}}</td>
                    <td>
                        <img width="150" src="food_img/{{$data->image}}" alt="">
                    </td>

                    <td>
                        <a class="btn btn-danger" onclick=" return confirm('voulez-vous supprime ce menu de votre panier ?')" href="{{url('remove_cart',$data->id)}}">Supprimer</a>
                    </td>
                </tr>

                <?php 
                $total_price += $data->price;
            ?>
            @endforeach
        </table>
        <h3>Total à payer: {{$total_price}}fr</h3>
        
    </div>

    <div class="div_center">
        <form action="{{url('confirm_order')}}" method="post">

            @csrf

            <div class="div_deg"> 
                <label for="">Nom</label>
                <input type="text" name="name" value="{{Auth()->user()->name}}">
            </div>
            <div class="div_deg">
                <label for="">Email</label>
                <input type="Email" name="email" value="{{Auth()->user()->email}}">
            </div>
            <div class="div_deg">
                <label for="">Telephone</label>
                <input type="number" name="phone" value="{{Auth()->user()->phone}}">
            </div>
            <div class="div_deg">
                <label for="">Adresse</label>
                <input type="text" name="address" value="{{Auth()->user()->address}}">
            </div>
            <div class="div_deg">
                <input class="btn btn-info" type="submit" value="Confirmer Commande">
            </div>




        </form>
    </div>

</body>
</html>
