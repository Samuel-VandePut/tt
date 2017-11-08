<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Joueur extends CI_Controller {

  /**
   * Index Page for this controller.
   *
   * Maps to the following URL
   *    http://example.com/index.php/welcome
   *  - or -
   *    http://example.com/index.php/welcome/index
   *  - or -
   * Since this controller is set as the default controller in
   * config/routes.php, it's displayed at http://example.com/
   *
   * So any other public methods not prefixed with an underscore will
   * map to /index.php/welcome/<method_name>
   * @see https://codeigniter.com/user_guide/general/urls.html
   */

  function __construct() {
    parent::__construct();
    $this->load->library('layout');
    $this->load->model('joueur_model','joueur');     
  }

  public function index()
  {
    $this->layout->views('includes/header.inc.php')->views('includes/navbar.inc.php')->views('page_admin.php')->views('includes/footer.inc.php')->view('page_admin_ajax.php');
  }

  public function ajax_list($pool)
  {
      $this->load->helper('url');

      $list = $this->joueur->get_datatables($pool);
      //var_dump($list);
      $data = array();
      $no = $_POST['start'];
      foreach ($list as $joueur) {
          $no++;
          $row = array();
          $row[] = $joueur->id_joueur;
          $row[] = $joueur->nom;
          $row[] = $joueur->prenom;
          $row[] = $joueur->classement;
          $row[] = $joueur->FK_pool;

          if($joueur->disponibilite) $row[] = '<input type="checkbox" name="dispo'.$joueur->id_joueur.'" onclick="uncheck('.$joueur->id_joueur.')" checked>';
          else $row[] = '<input type="checkbox" name="dispo'.$joueur->id_joueur.'" onclick="check('.$joueur->id_joueur.')">';
          
          $data[] = $row;
      }

      $output = array(
                      "draw" => $_POST['draw'],
                      "recordsTotal" => $this->joueur->count_all(),
                      "recordsFiltered" => $this->joueur->count_filtered($pool),
                      "data" => $data,
              );
      //output to json format
      echo json_encode($output);
  }

  public function ajax_joueurs()
  {
      $this->load->helper('url');

      $list = $this->joueur->get_joueurs();
      //var_dump($list);
      $data = array();
      foreach ($list as $joueur)
      {
          $last_matchs = $this->joueur->get_form($joueur->id_joueur); //recupérer la forme(résultat des 5 derniers matchs) du joueur 
          $form = ""; //string qui va contenir le code html de la forme. Composé de 5 balises <a> contenant la class form_w pour victoire ou form_l pour défaite
          for($i = 0; $i < count($last_matchs); $i++) 
          {
            $form .= ($last_matchs[$i]->victoire != '')? "<a class=\"form_w\"></a>" : "<a class=\"form_l\"></a>";
          }
          $row = array();
          $row[] = $joueur->id_joueur;
          $row[] = $joueur->nom;
          $row[] = $joueur->prenom;
          $row[] = $joueur->classement;
          $row[] = $joueur->FK_pool;
          $row[] = $form;

          $row[] = '<input type="button" value="Présent">';
                    
          $data[] = $row;
      }

      $output = array(
                      "data" => $data,
              );
      //output to json format
      echo json_encode($output);
  }

  public function ajax_get_joueurs()
  {
      //Select all joueurs
      $joueurs = $this->joueur->get_joueurs();
      echo json_encode(array("status" => TRUE, "joueurs" => $joueurs));
  }

  public function ajax_generate_teams()
  {
      $joueurs = $this->joueur->get_joueurs_dispo();
      //foreach()
  }

  


}