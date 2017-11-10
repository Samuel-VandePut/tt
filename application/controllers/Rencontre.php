<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rencontre extends CI_Controller {

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
    $this->load->model('rencontre_model','rencontre');     
  }

  public function index()
  {
    $this->layout->views('includes/header.inc.php')->views('includes/navbar.inc.php')->views('page_admin.php')->views('includes/footer.inc.php')->view('page_admin_ajax.php');
  }

  public function ajax_joueurs_team($interclub, $team)
  {
      $this->load->helper('url');

      $list = $this->rencontre->get_rencontres_team($interclub, $team);
      //var_dump($list);
      $data = array();
      foreach ($list as $joueur)
      { 
          $row = array();
          $row[] = $joueur->FK_joueur;
          $row[] = $joueur->nom;
          $row[] = $joueur->prenom;
          $row[] = $joueur->classement;

          $row[] = '<input type="button" value="Retirer">';
                    
          $data[] = $row;
      }

      $output = array(
                      "data" => $data,
              );
      //output to json format
      //var_dump($output);die();
      echo json_encode($output);
  }

  public function ajax_add()
  {
      //$this->_validate();
      $data = json_decode($_POST['json']); 

      //vérifier si il n'existe pas déjà des rencontres pour cet interclub
      $result = $this->rencontre->get_by_interclub_id($data->interclub);
      var_dump($count($result));die();
      if(count($result) > 0)
      {
        echo json_encode(array("status" => FALSE));
      }
      else
      {
        foreach($data->tables as $table)
        {
          if($table->equipe[1] != 'r' && $table->equipe != 've')//On insère pas les équipes réserves
          {
            $this->load->model('equipe_model','equipe');  
            $equipe = $this->equipe->get_by_name_division($table->equipe[1],$table->equipe[0]);

            //si l'équipe n'existe pas, la créer
            if(count($equipe) == 0)
            {
              $row = array(
                    'nom' => $table->equipe[1],
                    'FK_Division' => $table->equipe[0]
                );
              $result = $this->equipe->save($row);
              $equipe = new stdClass();
              $equipe->id_equipe = $result;
            } 

            $rencontres = array();
            foreach ($table->joueurs as $joueur)
            {
              $row = array(
                    'FK_joueur' => $joueur->N°,
                    'FK_interclub' => $data->interclub,
                    'FK_equipe' => $equipe->id_equipe
                );
              $rencontres[] = $row;
            }

            $insert = $this->rencontre->save_batch($rencontres);

            echo json_encode(array("status" => TRUE, "rencontres" => $insert));
          }
        } 
      }
  }

  public function ajax_get_rencontres()
  {
      //Select all rencontres
      $rencontres = $this->rencontre->get_rencontres();
      echo json_encode(array("status" => TRUE, "rencontres" => $rencontres));
  }

  public function ajax_by_interclub_id($id)
  {
      //Select all rencontres
      $rencontres = $this->rencontre->get_by_interclub_id($id);
      echo json_encode(array("status" => TRUE, "rencontres" => $rencontres));
  }

  public function ajax_get_joueurs_lastIC()
  {
    //Récupérer le dernier interclub pour lequel il y a eu des matchs
    $this->load->model('interclub_model','interclub');
    $ics = $this->interclub->get();
    $lastIC = new class{};
    foreach ($ics as $ic)
    {
      $rencontres = $this->rencontre->get_by_interclub_id($ic->id_interclub);
      if(count($rencontres) > 0)
      {
        foreach ($rencontres as $r)
        {
          $this->load->model('match_model','match');
          if(count($this->match->get_by_rencontre($r->id_rencontre)) != 0)
          {
            $lastIC = $ic;
            break 2;
          }
        } 
      }
    }
    //$joueurs_last = $this->rencontre->get_joueurs($lastIC[0]->id_interclub);
    $joueurs_last = $this->rencontre->get_joueurs($lastIC->id_interclub);
    
    echo json_encode(array("joueurs_last" =>  $joueurs_last/*"joueurs_slast" =>  $joueurs_slast*/));
  }
  


}