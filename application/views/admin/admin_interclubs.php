

    <div class="content-wrapper py-3">

      <div class="container-fluid">

        <!-- Breadcrumbs -->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">Admin</a>
          </li>
          <li class="breadcrumb-item active">Tennis de table</li>
        </ol>

        <!-- Form Upload matchs -->
          <div class="container-fluid">
            <form action="#" id="form-upload" class="form-horizontal">
              <div class="form-group">
                  <h2 class="control-label col-md-8">Ajouter des matchs</h2>
                  <div class="col-md-8">
                      <input name="fichierCSV" type="file">
                      <span class="help-block"></span>
                  </div>
              </div>
              <div class="col-md-4">
                <button type="button" id="btnUpload" onclick="upload()" class="btn btn-primary">Télécharger</button>
              </div>
            </form>
          </div>
            <br />
            <br />
          <!-- /Form Upload matchs -->

          <!-- Pools Tables -->
          <div class="col-md-12">
            <h2>Liste des fichiers</h3>
            <br />
          </div>
          <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Rafraichir</button>
          <br />
          <br />
          <div id="csv" class="col-md-6 col-xs-6">
            <h2>Division 3</h2>
            <table id="table_csv" class="table table-striped table-bordered" cellspacing="0" width="100%">
              <thead>
                <tr>
                    <th>N°</th>
                    <th>Nom</th>
                    <th>Prenom</th>
                    <th>Classement</th>
                    <th>Pool</th>
                    <th>Disponibilite</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
   
              <tfoot>
                <tr>
                    <th>N°</th>
                    <th>Nom</th>
                    <th>Prenom</th>
                    <th>Classement</th>
                    <th>Pool</th>
                    <th>Disponibilite</th>
                </tr>
              </tfoot>
            </table>
          </div>
          
          

          <button class="btn btn-default" onclick="generate_teams()"><i class="glyphicon glyphicon-check"></i> Générer les équipes</button>
      </div>
      <!-- /.container-fluid -->

    </div>
    <!-- /.content-wrapper -->

    <!-- Scroll to Top Button -->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>
    </a>

    


    
    <!-- Bootstrap modal -->
    <div class="modal fade" id="login-modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title">Login</h3>
                </div>
                <div class="modal-body form">
                    <form action="<?php echo site_url('Home/login'); ?>" method="POST" id="form" class="form-horizontal">                          
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


