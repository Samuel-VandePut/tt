<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Division extends CI_Controller {

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
    $this->load->model('division_model','division');     
  }

  public function index()
  {
    $this->layout->views('includes/header.inc.php')->views('includes/navbar.inc.php')->views('page_admin.php')->views('includes/footer.inc.php')->view('page_admin_ajax.php');
  }

  public function ajax_list()
  {
      $this->load->helper('url');

      $list = $this->division->get_datatables();
      //var_dump($list);
      $data = array();
      $no = $_POST['start'];
      foreach ($list as $division) {
          $no++;
          $row = array();
          $row[] = $division->id_division;
          $row[] = $division->nom;
          $row[] = $division->prenom;
          $row[] = $division->classement;
          $row[] = $division->FK_pool;

          if($division->disponibilite) $row[] = '<input type="checkbox" name="dispo'.$division->id_division.'" onclick="uncheck('.$division->id_division.')" checked>';
          else $row[] = '<input type="checkbox" name="dispo'.$division->id_division.'" onclick="check('.$division->id_division.')">';
          
          $data[] = $row;
      }

      $output = array(
                      "draw" => $_POST['draw'],
                      "recordsTotal" => $this->division->count_all(),
                      "recordsFiltered" => $this->division->count_filtered($pool),
                      "data" => $data,
              );
      //output to json format
      echo json_encode($output);
  }

  public function ajax_delete($id)
  {
      //Check if division contain images
      $this->load->model('division_img_model','division_img');
      $result = $this->division_img->get_by_division_id($id);
      if(count($result) > 0)//delete images linked to realisation before deleting realisation 
      {
        foreach ($result as $img)
        {
          $this->division_img->delete_by_id($img->FK_images,$id);
        }
      }//delete realisation
      $this->division->delete_by_id($id);
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

  public function ajax_get()
  {
      //Select all divisions
      $divisions = $this->division->get();
      echo json_encode(array("status" => TRUE, "divisions" => $divisions));
  }

  


}