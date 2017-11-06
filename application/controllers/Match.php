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

      //compter les match par joueur

      //ajouter les matchs  
      $this->load->model('match_model','match');
      $datas = array(
              'FK_rencontre' => $rencontre->id_rencontre,
              'victoire' => $match['victoire'],
              'defaite' => $match['defaite']
          );

      $id = $this->match->save_batch($data);

  }

  public function ajax_delete($id)
  {
      //Check if match contain images
      $this->load->model('match_img_model','match_img');
      $result = $this->match_img->get_by_match_id($id);
      if(count($result) > 0)//delete images linked to realisation before deleting realisation 
      {
        foreach ($result as $img)
        {
          $this->match_img->delete_by_id($img->FK_images,$id);
        }
      }//delete realisation
      $this->match->delete_by_id($id);
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

  public function ajax_get_matchs()
  {
      //Select all matchs
      $matchs = $this->match->get_matchs();
      echo json_encode(array("status" => TRUE, "matchs" => $matchs));
  }

  public function ajax_generate_teams()
  {
      $matchs = $this->match->get_matchs_dispo();
      //foreach()
  }

  


}