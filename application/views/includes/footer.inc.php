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

    <script type="text/javascript">

    var base_url = '<?php echo base_url();?>';


    function login()//load Home/login/parameter1/parameter2
    {
        $('#form').submit();
    }


    function hide()
    {
        $('#modal_form').modal('hide');
    }

    </script>

  </body>

</html>
