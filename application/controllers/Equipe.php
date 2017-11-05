<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Equipe extends CI_Controller {

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
    $this->load->model('equipe_model','equipe');     
  }

  public function index()
  {
    $this->layout->views('includes/header.inc.php')->views('includes/navbar.inc.php')->views('page_admin.php')->views('includes/footer.inc.php')->view('page_admin_ajax.php');
  }

  public function ajax_list($pool)
  {
      $this->load->helper('url');

      $list = $this->equipe->get_datatables($pool);
      //var_dump($list);
      $data = array();
      $no = $_POST['start'];
      foreach ($list as $equipe) {
          $no++;
          $row = array();
          $row[] = $equipe->id_equipe;
          $row[] = $equipe->nom;
          $row[] = $equipe->prenom;
          $row[] = $equipe->classement;
          $row[] = $equipe->FK_pool;

          if($equipe->disponibilite) $row[] = '<input type="checkbox" name="dispo'.$equipe->id_equipe.'" onclick="uncheck('.$equipe->id_equipe.')" checked>';
          else $row[] = '<input type="checkbox" name="dispo'.$equipe->id_equipe.'" onclick="check('.$equipe->id_equipe.')">';
          
          $data[] = $row;
      }

      $output = array(
                      "draw" => $_POST['draw'],
                      "recordsTotal" => $this->equipe->count_all(),
                      "recordsFiltered" => $this->equipe->count_filtered($pool),
                      "data" => $data,
              );
      //output to json format
      echo json_encode($output);
  }
  
  private function _validate()
  {
      $data = array();
      $data['error_string'] = array();
      $data['inputerror'] = array();
      $data['status'] = TRUE;

      if($this->input->post('json') == '')
      {
          $data['inputerror'][] = 'name';
          $data['error_string'][] = 'name est requis';
          $data['status'] = FALSE;
      }

      if($data['status'] === FALSE)
      {
          echo json_encode($data);
          exit();
      }
  }

  public function ajax_get_by_division($division)
  {
      //Select all equipes
      $equipes = $this->equipe->get_by_division($division);
      echo json_encode(array("status" => TRUE, "equipes" => $equipes));
  }

}