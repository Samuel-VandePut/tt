



    <!-- Page Content -->
    <div class="container">

      <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">
        <br>
                  <?php
                   if(isset($er)=="no"){

                          echo'<div class="alert alert-danger" role="alert">Erreur : Connexion refusée, Login ou mot de passe incorrect. </div>';

                     }
                  ?>
          <h1 class="my-4 text-primary">
                 Bienvenue sur notre site
          </h1>
          <!-- Blog Post -->
          <div class="card mb-4">
            <img class="card-img-top" src="<?php echo base_url('assets/images/t1.png'); ?>" alt="Card image cap">
            <div class="card-body">
              <p class="card-text">L’Open international de Belgique naît en même temps que “Les Deux Rebonds” et connaît un succès instantané: 60 joueurs dès la première année. S’il s’implante au centre de la Forêt de Soignes pour la première édition, il déménage aux Eglantiers dès 1990. La première véritable consécration du tournoi intervient en 1992 avec l’organisation de la Coupe du Monde de tennis en chaise. Ce sont pas moins de 130 joueurs qui affluent cette année-là pour se disputer le titre. Un certain Jim Courier, alors n°1 mondial chez les valides, a même fait le déplacement des Etats-Unis pour venir admirer le spectacle et encourager les athlètes. Laurent Giammartini et Monique Kalman seront les grands vainqueurs de cette édition.</p>
              <a href="#" class="btn btn-primary">Read More &rarr;</a>
            </div>
            <div class="card-footer text-muted">
              Posted on January 1, 2017 by
              <a href="#">Tennis IEPSCF</a>
            </div>
          </div>


        </div>

        <!-- Sidebar Widgets Column -->
        <div class="col-md-4">

          <!-- Search Widget -->
          <div class="card my-4">
            <h5 class="card-header">Search</h5>
            <div class="card-body">
              <div class="input-group">
                <input type="text" class="form-control" placeholder="Search for...">
                <span class="input-group-btn">
                  <button class="btn btn-secondary" type="button">Go!</button>
                </span>
              </div>
            </div>
          </div>

          <!-- Categories Widget -->
          <div class="card my-4">
            <h5 class="card-header">Suivez nous sur...</h5>
            <div class="card-body">
                <div class="col-lg-12">
                    <div class="container">
                          <a href="#" class="fa fa-facebook"></a>
                          <a href="#" class="fa fa-twitter"></a>
                          <a href="#" class="fa fa-google"></a>
                          <a href="#" class="fa fa-twitter"></a>
                          <a href="#" class="fa fa-youtube"></a>
                          <a href="#" class="fa fa-snapchat-ghost"></a>
                          <a href="#" class="fa fa-skype"></a>
                          <a href="#" class="fa fa-android"></a>
                    </div>     
                </div>
              </div>
            </div>
          <!-- Side Widget -->
          <div class="card my-4">
            <h5 class="card-header">Machs en vue</h5>
            <div class="card-body">
                
            </div>
          </div>

        </div>

      </div>
      <!-- /.row -->

    </div>
    <!-- /.container -->


    
    <!-- Bootstrap modal -->
    <div class="modal fade" id="login-modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title">Login</h3>
                </div>
                <div class="modal-body form">
                    <form action="<?php echo site_url('Home/login'); ?>" method="POST" id="log" class="form-horizontal">                          
                        <div class="form-body">
                            <div class="form-group">
                                <label class="control-label col-md-3">Login</label>
                                <div class="col-md-9">
                                    <input name="login" placeholder="Login" class="form-control" type="text">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Password</label>
                                <div class="col-md-9">
                                    <input name="password" placeholder="Mot de passe" class="form-control" type="password">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
                    </form>
                  </div>
                <div class="modal-footer">
                    <button type="button" id="btnSave" onclick="login()" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-danger" onclick="hide()" data-dismiss="modal">Cancel</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- End Bootstrap modal -->


