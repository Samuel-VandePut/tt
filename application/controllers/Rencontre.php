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

  public function ajax_list()
  {
      $this->load->helper('url');

      $list = $this->rencontre->get_datatables();
      //var_dump($list);
      $data = array();
      $no = $_POST['start'];
      foreach ($list as $rencontre) {
          $no++;
          $row = array();
          $row[] = $rencontre->id_rencontre;
          $row[] = $rencontre->victoire;
          $row[] = $rencontre->defaite;

          $data[] = $row;
      }

      $output = array(
                      "draw" => $_POST['draw'],
                      "recordsTotal" => $this->rencontre->count_all(),
                      "recordsFiltered" => $this->rencontre->count_filtered($pool),
                      "data" => $data,
              );
      //output to json format
      echo json_encode($output);
  }

  public function ajax_delete($id)
  {
      //Check if rencontre contain images
      $this->load->model('rencontre_img_model','rencontre_img');
      $result = $this->rencontre_img->get_by_rencontre_id($id);
      if(count($result) > 0)//delete images linked to realisation before deleting realisation 
      {
        foreach ($result as $img)
        {
          $this->rencontre_img->delete_by_id($img->FK_images,$id);
        }
      }//delete realisation
      $this->rencontre->delete_by_id($id);
      echo json_encode(array("status" => TRUE));
  }

  private function _validate()
  {
      $data = array();
      $data['error_string'] = array();
      $data['inputerror'] = array();
      $data['status'] = TRUE;

      if($this->input->post('name') == '')
      {
          $data['inputerror'][] = 'name';
          $data['error_string'][] = 'name est requis';
          $data['status'] = FALSE;
      }

      if($this->input->post('description') == '')
      {
          $data['inputerror'][] = 'description';
          $data['error_string'][] = 'description est requis';
          $data['status'] = FALSE;
      }

      if($data['status'] === FALSE)
      {
          echo json_encode($data);
          exit();
      }
  }

  public function ajax_get_rencontres()
  {
      //Select all rencontres
      $rencontres = $this->rencontre->get_rencontres();
      echo json_encode(array("status" => TRUE, "rencontres" => $rencontres));
  }

  public function ajax_generate_teams()
  {
      $rencontres = $this->rencontre->get_rencontres_dispo();
      //foreach()
  }

  public function ajax_get_joueurs_lastIC()
  {
    $this->load->model('interclub_model','interclub');
    $lastIC = $this->interclub->get_lastIC();

    $joueurs_last = $this->rencontre->get_joueurs($lastIC[0]->id_interclub);
    $joueurs_slast = $this->rencontre->get_joueurs($lastIC[1]->id_interclub);
    
    echo json_encode(array("joueurs_last" =>  $joueurs_last,"joueurs_slast" =>  $joueurs_slast));
  }
  


}