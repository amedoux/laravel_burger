<!DOCTYPE html>
<html>
  <head> 
    @include('admin.css')
    <style>
        table
        {
            border:1px solid skyblue;
            margin: auto;
            width: 945px;
        }


        th
        {
            background:skyblue;
                color:white;
                padding: 10px;
                margin: 10px;
        }


        td
        {
            color:white;
            padding: 10px;
        }
    </style>
  </head>
  <body>
  <!-- #007bff -->
 
        @include('admin.header')
    
        @include('admin.sidebar')


      <div class="page-content">
        <div class="page-header">
            <div class="container-fluid">
                <h1>Full menu</h1>
               <div>
                <table>
                    <tr align="center">
                        <th>Nom menu</th>
                        <th>Details menu</th>
                        <th>Prix</th>
                        <th>Image</th>
                        <th>Retirer </th>
                        <th>Réviser </th>
                    </tr>

                    @foreach($data as $data)
                    <tr>
                        <td>{{$data->title}}</td>
                        <td>{{$data->detail}}</td>
                        <td>{{$data->price}}</td>
                        <td>
                            <img width="150" src="food_img/{{$data->image}}" alt="">
                        </td>


                        <td>
                            <a class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir retirer ce menu?')" href="{{url('delete_food',$data->id)}}">Retirer</a>
                        </td>

                        <td>
                            <a class="btn btn-warning" onclick="return confirm('Êtes-vous sûr de vouloir reviser ce menu?')" href="{{url('update_food',$data->id)}}">Réviser</a>
                        </td>


                    </tr>
                    @endforeach
                </table>
               </div>

            </div>
      </div>
    </div>
    @include('admin.js')
  </body>
</html>