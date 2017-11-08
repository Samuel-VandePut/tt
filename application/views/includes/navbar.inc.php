    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="#">Tennis de table IEPSCF</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item <?php if($page == 'accueil') echo 'active'; ?>">
              <a class="nav-link" href="<?php echo base_url();?>Home">Accueil
                <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="nav-item <?php if($page == 'apropos') echo 'active'; ?>">
              <a class="nav-link" href="#">A propos</a>
            </li>
            <li class="nav-item <?php if($page == 'equipe') echo 'active'; ?>">
              <a class="nav-link" href="#">Equipe</a>
            </li>
            <li class="nav-item <?php if($page == 'contact') echo 'active'; ?>">
              <a class="nav-link" href="#">Contact</a>
            </li>
            <?php 
              if(isset($_SESSION['Niveau']))
              { 
                $css = '';
                if($page == 'mapage') $css = ' active';
                echo '
                <li class="nav-item'.$css.'">
                  <a class="nav-link" href="'.base_url().'Home/Page_perso">Ma page</a>
                </li>';
                /*if($_SESSION['Niveau'] == 5)
                {
                  echo'<li class="nav-item">
                    <a class="nav-link" href="'.base_url().'Home/Admin">Admin</a>
                  </li>';
                }*/
                echo'<li class="nav-item">
                  <a class="nav-link" href="'.base_url().'Home/Logout">Se déconnecter</a>
                </li>'; 
              }
            ?>
          </ul>
        </div>
      </div>
    </nav>