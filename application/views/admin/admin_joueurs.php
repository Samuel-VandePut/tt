

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
          <div class="clear-fix container-fluid">
          <div class="col-md-12">
            <h2>Liste des joueurs</h3>
            <br />
          </div>
          <div id="poola" class="col-md-8 col-xs-8 float-left">
          <div class="clear-fix">
            <div class="float-left col-md-6"> 
              
            </div>
            <div class="float-right clear-fix col-md-6">
              <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Rafraichir</button>  
              <button class="btn btn-default" onclick="generate_team()"><i class="glyphicon glyphicon-check"></i>Générer l'équipe</button>    
            </div>
          </div>
          <br>
            <table id="table_pool_3" class="table table-striped table-bordered" cellspacing="0" width="100%">
              <thead>
                <tr>
                    <th>N°</th>
                    <th>Nom</th>
                    <th>Prenom</th>
                    <th>Class</th>
                    <th>Pool</th>
                    <th>Forme</th>
                    <th>Disp</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
              <tfoot>
                <tr>
                    <th>N°</th>
                    <th>Nom</th>
                    <th>Prenom</th>
                    <th>Class</th>
                    <th>Pool</th>
                    <th>Forme</th>
                    <th>Disp</th>
                </tr>
              </tfoot>
            </table>
            <br>
            <div class="col-md-6">
              <button class="btn btn-default" onclick="generate_team()"><i class="glyphicon glyphicon-check"></i>Générer l'équipe</button>    
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
    <div class="modal fade" id="equipe-modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title">Equipe Division</h3>
                </div>
                <div class="modal-body form">
                    <table id="modal_table_effectif" class="table table-striped table-bordered" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                            <th>N°</th>
                            <th>Nom</th>
                            <th>Prenom</th>
                            <th>Class</th>
                            <th>Forme</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                    <h3>Réserves</h3>
                    <table id="modal_table_reserve" class="table table-striped table-bordered" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                            <th>N°</th>
                            <th>Nom</th>
                            <th>Prenom</th>
                            <th>Class</th>
                            <th>Forme</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                </div>
              <div class="modal-footer">
                  <button type="button" id="btnSave" onclick="login()" class="btn btn-primary">Submit</button>
                  <button type="button" class="btn btn-danger" onclick="hide()" data-dismiss="modal">Cancel</button>
              </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- End Bootstrap modal -->


