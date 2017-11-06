    <!-- Footer -->
    <footer class="py-5 bg-dark">
      <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; Your Website 2017</p>
      </div>
      <!-- /.container -->
    </footer>
<!-- jQuery -->
    <script src="<?php echo base_url();?>assets/vendor/jquery/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url();?>assets/vendor/popper/popper.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url();?>assets/vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="<?php echo base_url();?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="<?php echo base_url();?>assets/vendor/chart.js/Chart.min.js"></script>
    <script src="<?php echo base_url();?>assets/vendor/datatables/jquery.dataTables.js"></script>
    <script src="<?php echo base_url();?>assets/vendor/datatables/dataTables.bootstrap4.js"></script>
    <script src="<?php echo base_url('assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js')?>"></script>
    <script src="<?php echo base_url();?>assets/vendor/jquery/jquery.validate.min.js"></script>
   

    <script type="text/javascript">

    $(document).ready(function(){

    $("#log").validate({
        rules: {
            login: {
                required: true,
                email: true
            },
            password: {
                required: true
            }
        },
        submitHandler: function(log){
            form.submit();
        }
    });

    jQuery.validator.addMethod("email", function(value, element) {
      // allow any non-whitespace characters as the host part
      return this.optional( element ) || /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@(?:\S{1,63})$/.test( value );
    }, 'Entrez un login valide svp.');

    });

    /*var bouncingBall = anime({
        targets: '.ball',
        translateY: '50vh',
        duration: 300,
        loop: true,
        direction: 'alternate',
        easing: 'easeInCubic',
        scaleX: {
            value: 1.05,
            duration: 150,
            delay: 268
        }
    });*/

    var base_url = '<?php echo base_url();?>';

    function hide()
    {
        $('#modal_form').modal('hide');
    }

    </script>

  </body>

</html>