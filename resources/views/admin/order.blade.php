<!DOCTYPE html>
<html>
  <head> 
    @include('admin.css')
    <style>
        table {
            border: 1px solid skyblue;
            margin: auto;
            width: 100%;
            
        }

        th{
            color:white;
            font-weight:bold;
            font-size: 18px;
            text-align:center;
            background-color:skyblue;
            padding: 10px;
        }
        td{
            color:white;
            font-weight:bold;
            text-align:center;
            padding: 10px;
        }
    </style>
  </head>
  <body>

 
        @include('admin.header')
    
        @include('admin.sidebar')


      <div class="page-content">
        <div class="page-header">
            <div class="container-fluid" style="overflow: auto;">
              

                <table>
                    <tr>
                        <th>Customer Name</th>
                        <th>Email</th>
                        <th>Telephone</th>
                        <th>Adresse</th>
                        <th>Nom menu</th>
                        <th>Quantite</th>
                        <th>Prix</th>
                        <th>Image</th>
                        <th>Status</th>
                        <th>Changer le status</th>
                        
                    </tr>
                @foreach($data as $data)
                    <tr>
                        <td>{{$data->name}}</td>
                        <td>{{$data->email}}</td>
                        <td>{{$data->phone}}</td>
                        <td>{{$data->address}}</td>
                        <td>{{$data->title}}</td>
                        <td>{{$data->quantity}}</td>
                        <td>{{$data->price}}</td>
                        <td>
                            <img width="100" src="food_img/{{$data->image}}" alt="">
                        </td>
                        <td>{{$data->delivery_status}}</td>

                        <td>
                            <a onclick="return confirm('voulez-vous change le status')" href="{{url('on_the_way',$data->id)}}" class="btn btn-info">En route</a>

                            <a onclick="return confirm('voulez-vous change le status')"  href="{{url('pending',$data->id)}}" class="btn btn-warning">En attente</a>

                            <a onclick="return confirm('voulez-vous change le status')"  href="{{url('ready',$data->id)}}" class="btn btn-info">Prête</a>
                            <!-- Envoi d'un e-mail avec la facture en PDF   -->
                            <a onclick="return confirm('voulez-vous change le status')"  href="{{url('delivered',$data->id)}}" class="btn btn-success">Payée</a>
                            <!-- enregistrement de la date et du montant du paiement -->
                            <a onclick="return confirm('voulez-vous change le status')"  href="{{url('canceled',$data->id)}}" class="btn btn-danger">Annuler</a>
                        </td>
                        
                    </tr>
                @endforeach
                </table>


            </div>
      </div>
    </div>
    @include('admin.js')
  </body>
</html>