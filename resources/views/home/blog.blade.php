<div id="blog" class="container-fluid bg-dark text-light py-5 text-center wow fadeIn">
        <h2 class="section-title py-5">TOUS NOS MENUS</h2>
        
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="foods" role="tabpanel" aria-labelledby="pills-home-tab">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4">
                @foreach($data as $data)
                    <div class="col mb-4">
                        <div class="card bg-transparent border h-100">
                            <div class="card-img-wrapper" style="height: 200px; overflow: hidden;">
                                <img src="food_img/{{$data->image}}" class="card-img-top" style="object-fit: cover; height: 100%; width: 100%;">
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h1 class="text-center mb-3"><a href="#" class="badge badge-primary">{{$data->price}}fr</a></h1>
                                <h4 class="pt20 pb20">{{$data->title}}</h4>
                                <p class="text-white flex-grow-1">{{$data->detail}}</p>
                                <form action="{{url('add_cart',$data->id)}}" method="post" class="mt-auto">
                                    @csrf
                                    <div class="form-group">
                                        <input value="1" type="number" min="1" name="qty" class="form-control mb-2" required>
                                        <input class="btn btn-info w-100" type="submit" value="Ajouter au panier">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach    
                </div>
            </div>
        </div>
    </div>