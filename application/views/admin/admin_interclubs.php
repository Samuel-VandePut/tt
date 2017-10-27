

    <div class="content-wrapper py-3">

      <div class="container-fluid">

        <!-- Breadcrumbs -->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">Admin</a>
          </li>
          <li class="breadcrumb-item active">Tennis de table</li>
        </ol>



          <!-- Interclubs Tables -->
          <div class="container-fluid clear-fix">
            <div id="csv" class="col-md-6 col-xs-6 float-left">
                <div class="clear-fix">
                  <div class="float-left">
                    <h2>Interclubs</h2>
                  </div>
                  <div class="float-right clear-fix">  
                    <button class="btn btn-default" onclick="show_modal()"><i class="glyphicon glyphicon-check"></i>Ajouter un interclub</button> 
                    <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Rafraichir</button>   
                  </div>
                </div>
              <table id="table_interclubs" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                  <tr>
                      <th>N°</th>
                      <th>Date</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
     
                <tfoot>
                  <tr>
                      <th>N°</th>
                      <th>Date</th>
                </tfoot>
              </table>
              <br>
                    <button class="btn btn-default" onclick="show_modal()"><i class="glyphicon glyphicon-check"></i>Ajouter un interclub</button> 
            </div>
            <!-- Interclubs Tables -->
          
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
    <div class="modal fade" id="interclub-modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title">Ajouter un interclub</h3>
                </div>
                <div class="modal-body form">
                  <!-- Form add interclub -->
                    <div class="container-fluid">
                      <form action="#" id="form-interclub" class="form-horizontal">
                        <div class="form-group">
                            <label class="control-label col-md-3">Date</label>
                            <div class="col-md-9">
                                <input name="date" placeholder="Date" class="form-control" type="date">
                                <span class="help-block"></span>
                            </div>
                        </div>
                      </form>
                      <div class="alert" id="alert">
                      </div>
                    </div>
                    <!-- /Form add interclub -->
                  </div>
                <div class="modal-footer">
                    <button type="button" id="btnUpload" onclick="add_interclub()" class="btn btn-primary">Ajouter</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- End Bootstrap modal -->


