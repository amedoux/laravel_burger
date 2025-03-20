<!DOCTYPE html>
<html>
  <head> 
    @include('admin.css')
    <style>
        table{
            border: 1px solid skyblue;
            margin:auto;
            width: 100%;
            margin-top:20px
        }
        th{
            background-color:skyblue;
            text-align: center;
            padding: 20px;
            color:white;
            font-size: 18px;
        }
        td{
            text-align: center;
            padding: 10px;
            color:white;
            font-weight: bold;
        }
    </style>
  </head>
  <body>

 
        @include('admin.header')
    
        @include('admin.sidebar')


      <div class="page-content">
        <div class="page-header">
            <div class="container-fluid">
               
                <table>
                    <tr>
                        <th>Numero de telephone</th>
                        <th>Nombre de convives</th>
                        <th>Date</th>
                        <th>Heure</th>
                    </tr>
                    @foreach($book as $book)
                    <tr>
                        <td>{{$book->phone}}</td>
                        <td>{{$book->guest}}</td>
                        <td>{{$book->date}}</td>
                        <td>{{$book->time}}</td>
                    </tr>
                    @endforeach
                </table>

            
            </div>
      </div>
    </div>
    @include('admin.js')
  </body>
</html>