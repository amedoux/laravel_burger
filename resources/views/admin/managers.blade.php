<!DOCTYPE html>
<html>
  <head> 
    @include('admin.css')
  </head>
  <body>
    @include('admin.header')
    @include('admin.sidebar')

    <div class="page-content">
      <div class="page-header">
        <div class="container-fluid">
          <h2 class="h5 no-margin-bottom">Gestion des Gestionnaires</h2>
        </div>
      </div>

      <!-- Formulaire d'inscription -->
      <section class="forms mb-4">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-12">
              <div class="card">
                <div class="card-header d-flex align-items-center">
                  <h3 class="h4">Ajouter un gestionnaire</h3>
                </div>
                <div class="card-body">
                  @if(session('success'))
                    <div class="alert alert-success">
                      {{ session('success') }}
                    </div>
                  @endif

                  @if(session('error'))
                    <div class="alert alert-danger">
                      {{ session('error') }}
                    </div>
                  @endif

                  @if ($errors->any())
                    <div class="alert alert-danger">
                      <ul>
                        @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                        @endforeach
                      </ul>
                    </div>
                  @endif

                  <form method="POST" action="{{ route('register_manager') }}">
                    @csrf
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Nom</label>
                          <input type="text" name="name" class="form-control" required>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Email</label>
                          <input type="email" name="email" class="form-control" required>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Téléphone</label>
                          <input type="text" name="phone" class="form-control" required>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Mot de passe</label>
                          <input type="password" name="password" class="form-control" required>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Adresse</label>
                          <textarea name="address" class="form-control" rows="3" required></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <button type="submit" class="btn btn-primary">Ajouter le gestionnaire</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Liste des gestionnaires -->
      <section class="tables">   
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-12">
              <div class="card">
                <div class="card-header d-flex align-items-center">
                  <h3 class="h4">Liste des Gestionnaires</h3>
                </div>
                <div class="card-body">
                  <div class="table-responsive">                       
                    <table class="table table-striped table-sm">
                      <thead>
                        <tr>
                          <th>Nom</th>
                          <th>Email</th>
                          <th>Téléphone</th>
                          <th>Adresse</th>
                          <th>Statut</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($managers as $manager)
                        <tr>
                          <td>{{$manager->name}}</td>
                          <td>{{$manager->email}}</td>
                          <td>{{$manager->phone}}</td>
                          <td>{{$manager->address}}</td>
                          <td>
                            @if($manager->is_active)
                              <span class="badge badge-success">Actif</span>
                            @else
                              <span class="badge badge-danger">Bloqué</span>
                            @endif
                          </td>
                          <td>
                            <a href="{{url('toggle_manager_status',$manager->id)}}" class="btn btn-warning btn-sm">
                              @if($manager->is_active)
                                Bloquer
                              @else
                                Débloquer
                              @endif
                            </a>
                            <a href="{{url('edit_manager',$manager->id)}}" class="btn btn-info btn-sm">
                              Modifier
                            </a>
                            <a href="{{url('delete_manager',$manager->id)}}" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce gestionnaire ?')">
                              Supprimer
                            </a>
                          </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
    @include('admin.js')
  </body>
</html> 