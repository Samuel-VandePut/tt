

    <div class="content-wrapper py-3">

      <div class="container-fluid">

        <!-- Breadcrumbs -->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">Admin</a>
          </li>
          <li class="breadcrumb-item active">Tennis de table</li>
        </ol>



          <!-- Pools Tables -->
          <div class="container-fluid clear-fix">
            <div id="csv" class="col-md-6 col-xs-6 float-left">
                <div class="clear-fix">
                  <div class="float-left">
                    <h2>Matchs ajoutés</h2>
                  </div>
                  <div class="float-right clear-fix">  
                    <button class="btn btn-default" onclick="show_modal()"><i class="glyphicon glyphicon-check"></i>Ajouter des matchs</button> 
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
              <br>
                    <button class="btn btn-default" onclick="show_modal()"><i class="glyphicon glyphicon-check"></i>Ajouter des matchs</button> 
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
    <div class="modal fade" id="upload-modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title">Ajouter des matchs</h3>
                </div>
                <div class="modal-body form">
                  <!-- Form Upload matchs -->
                    <div class="container-fluid">
                      <form action="#" id="form-upload" class="form-horizontal">
                        <div class="form-group">
                          <label class="control-label col-md-8" id="interclub-select">Selectionnez un Interclub</label>
                          <div class="col-md-9">
                            <select name="interclub" id="select-interclub" class="form-control col-md-6">
                                <option value="0">Choix de l'interclub</option>
                            </select>
                          </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8">
                                <input name="fichierCSV" type="file">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                        </div>
                      </form>
                      <div class="alert" id="alert">
                      </div>
                    </div>
                    <!-- /Form Upload matchs -->
                  </div>
                <div class="modal-footer">
                    <button type="button" id="btnUpload" onclick="upload()" class="btn btn-primary">Ajouter</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- End Bootstrap modal -->


