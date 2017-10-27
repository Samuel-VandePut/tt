

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
            <br />
            <div class="alert" id="alert">
            </div>
            <br />
          </div>
          <!-- /Form Upload matchs -->

          <!-- Pools Tables -->
          <div class="container-fluid clear-fix">
            <div id="csv" class="col-md-6 col-xs-6 float-left">
                <div class="clear-fix">
                  <div class="float-left">
                    <h2>Matchs ajoutés</h2>
                  </div>
                  <div class="float-right clear-fix">  
                    <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Rafraichir</button>
                  </div>
                </div>
              <table id="table_matchs" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                  <tr>
                      <th>N°</th>
                      <th>Date</th>
                      <th>Nom</th>
                      <th>Prenom</th>
                      <th>Victoire</th>
                      <th>Défaite</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
     
                <tfoot>
                  <tr>
                      <th>N°</th>
                      <th>Date</th>
                      <th>Nom</th>
                      <th>Prenom</th>
                      <th>Victoire</th>
                      <th>Défaite</th>
                </tfoot>
              </table>
            </div>
            <!-- Pools Tables -->
            
            <div id="files" class="col-md-6 col-xs-6 float-right">
              <div class="clear-fix">
                <div class="float-left">
                  <h2>Fichiers</h2>
                </div>
                <div class="float-right clear-fix">  
                  <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Rafraichir</button>
                </div>
              </div>
              <table id="table_files" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                  <tr>
                      <th>N°</th>
                      <th>Nom</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
     
                <tfoot>
                  <tr>
                      <th>N°</th>
                      <th>Nom</th>
                  </tr>
                </tfoot>
              </table>
            </div>
        </div>  
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


