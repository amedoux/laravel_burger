<!DOCTYPE html>
<html>
  <head> 

    <base href="/public">

    @include('admin.css')

    <style>
        .div_deg
        {
            padding: 10px;
        }

        label
        {
            display:inline-block;
            width: 200px;
        }
    </style>
  </head>
  <body>

 
        @include('admin.header')
    
        @include('admin.sidebar')


      <div class="page-content">
        <div class="page-header">
            <div class="container-fluid">

            <h1>Revision des menus</h1>

                <form action="{{url('edit_food',$food->id)}}" method="post" enctype="multipart/form-data">

                @csrf

                    <div class="div_deg">
                        <label for="">Nom Menu</label>
                        <input type="text" name="title" value="{{$food->title}}">
                    </div>


                    <div class="div_deg">
                        <label for="">Details</label>
                        <textarea name="details" id="">{{$food->detail}}</textarea>
                        
                    </div>

                    <div class="div_deg">
                        <label for="">Prix</label>
                        <input type="text" name="price" value="{{$food->price}}">
                    </div>

                    <div class="div_deg">
                        <label for="">Image actuelle</label>
                        <img width="150" src="food_img/{{$food->image}}" alt="">
                    </div>

                    <div class="div_deg">
                        <label for="">Nouvelle image</label>
                        <input type="file" name="image">
                    </div>

                    <div class="div_deg">
                       <input class="btn btn-warning" type="submit" value="Reviser le menu">
                    </div>








                </form>
              
            </div>
      </div>
    </div>
    @include('admin.js')
  </body>
</html>