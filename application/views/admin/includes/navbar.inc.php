    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="#">Tennis de table IEPSCF</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link" href="<?php echo base_url();?>Home">Accueil</a>
            </li>
            <li class="nav-item <?php if($page == 'interclubs') echo 'active'; ?>">
              <a class="nav-link" href="<?php echo base_url();?>Home/Interclubs">Interclubs</a>
            </li>
            <li class="nav-item <?php if($page == 'joueurs') echo 'active'; ?>">
              <a class="nav-link" href="<?php echo base_url();?>Home/Joueurs">Joueurs
                <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="nav-item <?php if($page == 'equipes') echo 'active'; ?>">
              <a class="nav-link" href="<?php echo base_url();?>Home/Equipes">Equipes</a>
            </li>
            <li class="nav-item <?php if($page == 'matchs') echo 'active'; ?>">
              <a class="nav-link" href="<?php echo base_url();?>Home/Matchs">Matchs</a>
            </li>
            <li class="nav-item">
                 <a class="nav-link" href="<?php echo base_url();?>'Home/backup">Backup de la BD</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo base_url();?>Home/Logout">Se déconnecter</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>