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
          <h2 class="h5 no-margin-bottom">Modifier un gestionnaire</h2>
        </div>
      </div>

      <section class="no-padding-top">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-12">
              <div class="block">
                <div class="title"><strong>Informations du gestionnaire</strong></div>
                <div class="block-body">
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

                  <form method="POST" action="{{ route('update_manager', $manager->id) }}" class="form-horizontal">
                    @csrf
                    <div class="form-group row">
                      <label class="col-sm-3 form-control-label">Nom</label>
                      <div class="col-sm-9">
                        <input type="text" name="name" class="form-control" value="{{ $manager->name }}" required>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label class="col-sm-3 form-control-label">Email</label>
                      <div class="col-sm-9">
                        <input type="email" name="email" class="form-control" value="{{ $manager->email }}" required>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label class="col-sm-3 form-control-label">Téléphone</label>
                      <div class="col-sm-9">
                        <input type="text" name="phone" class="form-control" value="{{ $manager->phone }}" required>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label class="col-sm-3 form-control-label">Nouveau mot de passe</label>
                      <div class="col-sm-9">
                        <input type="password" name="password" class="form-control" placeholder="Laisser vide pour ne pas changer">
                        <small class="help-block-none">Laisser vide pour ne pas changer le mot de passe</small>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label class="col-sm-3 form-control-label">Adresse</label>
                      <div class="col-sm-9">
                        <textarea name="address" class="form-control" rows="3" required>{{ $manager->address }}</textarea>
                      </div>
                    </div>

                    <div class="form-group row">
                      <div class="col-sm-9 ml-auto">
                        <button type="submit" class="btn btn-primary">Mettre à jour</button>
                        <a href="{{ route('managers') }}" class="btn btn-secondary">Annuler</a>
                      </div>
                    </div>
                  </form>
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