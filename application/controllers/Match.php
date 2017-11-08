<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Match extends CI_Controller {

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
    $this->load->model('match_model','match');     
  }

  public function index()
  {
    $this->layout->views('includes/header.inc.php')->views('includes/navbar.inc.php')->views('page_admin.php')->views('includes/footer.inc.php')->view('page_admin_ajax.php');
  }

  public function ajax_list()
  {
      $this->load->helper('url');

      $list = $this->match->get_datatables();
      //var_dump($list);
      $data = array();
      $no = $_POST['start'];
      foreach ($list as $match) {
          $no++;
          $row = array();
          $row[] = $match->id_match;
          $row[] = $match->victoire;
          $row[] = $match->defaite;

          $data[] = $row;
      }

      $output = array(
                      "draw" => $_POST['draw'],
                      "recordsTotal" => $this->match->count_all(),
                      "recordsFiltered" => $this->match->count_filtered($pool),
                      "data" => $data,
              );
      //output to json format
      echo json_encode($output);
  }


  public function ajax_add()
  {
      //$this->_validate();
      $data = json_decode($_POST['json']);
      //ajouter les matchs
      $matchs = array();
      $id = array();  
      foreach($data as $joueur)
      {
        foreach($joueur as $match)
        {
          //récupérer id rencontre et id joueur avec date, nom et prenom du joueur 
          $this->load->model('joueur_model','joueur');
          $joueur = $this->joueur->get_by_name($match->Nom,$match->Prenom);

          //récupérer id_interclub si il existe
          $this->load->model('interclub_model','interclub');
          $interclub = $this->interclub->get_by_date(date('Y-m-j',strtotime($match->Date)));

          //Si l'interclub n'existe pas => renvoyer une erreur
          if($interclub == null)
          {
            $status['error'] = 'L\'interclub pour cette date n\'existe pas';
            break 2;
          } 

          $this->load->model('rencontre_model','rencontre');
          $rencontre = $this->rencontre->get_by_joueur_interclub($joueur->id_joueur,$interclub->id_interclub);
          //Si la rencontre n'existe pas => renvoyer une erreur
          if($rencontre == null) 
          {
            $status['error'] = 'Les équipes pour cet interclub n\'ont pas été créées ou les joueurs ne correspondent pas';
            break 2;
          }

          $row = array(
                'FK_rencontre' => $rencontre->id_rencontre,
                'victoire' => $match->Victoire,
                'defaite' => $match->Defaite
            );
          $matchs[] = $row;
        }
      //var_dump($matchs);die();

        $this->load->model('match_model','match');
        $id[] = $this->match->save_batch($matchs);
      
      }
      echo json_encode(array("status" => $status, 'matchs' => $id));
  }

  public function ajax_get_matchs()
  {
      //Select all matchs
      $matchs = $this->match->get_matchs();
      echo json_encode(array("status" => TRUE, "matchs" => $matchs));
  }

  


}