

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
                    <!--button class="btn btn-default" onclick="show_modal()"><i class="glyphicon glyphicon-check"></i>Télécharger des matchs</button--> 
                    <input id="file" name="fichierCSV" type="file"> 
                  </div>
                </div>
                <div class="alert" id="alert">
                </div>
              <table id="table_matchs" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                  <tr>
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
                      <th>Date</th>
                      <th>Nom</th>
                      <th>Prenom</th>
                      <th>Victoire</th>
                      <th>Défaite</th>
                    </tr>
                </tfoot>
              </table>
              <br>
                    <button class="btn btn-default" id="apply_matchs"><i class="glyphicon glyphicon-check"></i>Appliquer</button> 
            </div>
            <!-- Pools Tables -->
            
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
                    <h3 class="modal-title">Télécharger des matchs</h3>
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
                                <input id="file" name="fichierCSV" type="file">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                        </div>
                      </form>
                    </div>
                    <!-- /Form Upload matchs -->
                  </div>
                <div class="modal-footer">
                    <button type="button" id="btnUpload" onclick="readFile()" class="btn btn-primary">Télécharger</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- End Bootstrap modal -->


