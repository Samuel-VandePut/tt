

    <div class="content-wrapper py-3">

      <div id="main" class="container-fluid">

        <!-- Breadcrumbs -->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">Admin</a>
          </li>
          <li class="breadcrumb-item active">Tennis de table</li>
        </ol>

          <form action="#" id="form-upload" class="form-horizontal">
            <div class="form-group">
              <label class="control-label col-md-8" id="interclub-select">Selectionnez un Interclub</label>
              <div class="col-md-9">
                <select name="interclub" id="select-interclub" class="form-control col-md-6">
                    <option value="0">Choix de l'interclub</option>
                </select>
              </div>
            </div>
          </form>

          <div class="alert" id="alert"></div>

      </div>
          
      <!-- /.container-fluid -->

    </div>
    <!-- /.content-wrapper -->
    <dir class="container-fluid">
      <button id="apply_teams">Appliquer</button>
    </dir>
    <!-- Scroll to Top Button -->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>
    </a>

    <!-- Bootstrap modal -->
    <div class="modal fade" id="reserve-modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title">Ajouter un joueur</h3>
                </div>
                <div class="modal-body form">
                  <!-- Form add interclub -->
                    <div class="container-fluid">
                      <table id="modal_table_reserve" class="table table-striped table-bordered" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                            <th>N°</th>
                            <th>Nom</th>
                            <th>Prenom</th>
                            <th>Class</th>
                            <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                    </div>
                    <input type="hidden" id="id_table" value="">
                    <!-- /Form add interclub -->
                  </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- End Bootstrap modal -->

