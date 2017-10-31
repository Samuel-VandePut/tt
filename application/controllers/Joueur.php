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

  public function ajax_set_dispo($id)
  {
      $data = array(
              'disponibilite' => 1
          );

      $this->joueur->update(array('id_joueur' => $id), $data);
      echo json_encode(array("status" => TRUE));
  }

  public function ajax_set_indispo($id)
  {
      $data = array(
              'disponibilite' => 0
          );

      $this->joueur->update(array('id_joueur' => $id), $data);
      echo json_encode(array("status" => TRUE));
  }

  public function ajax_upload()
  {
      $this->load->model('image_model','image');

      if(!empty($_FILES['photo']['name']))
      {
        if(file_exists('assets/img/projets/'.$joueur->name))
        {
          $data['photo'] = 'Le nom du fichier existe déjà';
        }
        else
        {
          $upload = $this->_do_upload();
          $data['photo'] = $upload;

          //insert img, get id
          $imgId = $this->image->save(array('name' => $data['photo']));
          //insert img in joueur_img
          $this->load->model('joueur_img_model','joueur_img');
          $this->joueur_img->save(array('FK_images' => $imgId, 'FK_joueurs' => $this->input->post('id')));
        }
      }
      /*if(!empty($_FILES['photo']['name']))
      {
           
          //delete file
          $joueur = $this->joueur->get_by_id($this->input->post('id'));
          if(file_exists('upload/'.$joueur->photo) && $joueur->photo)
              unlink('upload/'.$joueur->photo);

      }*/

      echo json_encode(array("status" => TRUE,'id' => $this->input->post('id')));
  }

  public function ajax_delete($id)
  {
      //Check if joueur contain images
      $this->load->model('joueur_img_model','joueur_img');
      $result = $this->joueur_img->get_by_joueur_id($id);
      if(count($result) > 0)//delete images linked to realisation before deleting realisation 
      {
        foreach ($result as $img)
        {
          $this->joueur_img->delete_by_id($img->FK_images,$id);
        }
      }//delete realisation
      $this->joueur->delete_by_id($id);
      echo json_encode(array("status" => TRUE));
  }


  public function ajax_delete_img($id_img,$id_joueur)
  {
      $this->load->model('joueur_img_model','joueur_img');
      $this->joueur_img->delete_by_id($id_img,$id_joueur);
      echo json_encode(array("status" => TRUE));
  }

  private function _do_upload()
  {
      $config['upload_path']          = 'assets/img/projets';
      $config['allowed_types']        = 'gif|jpg|png';
      $config['max_size']             = 100; //set max size allowed in Kilobyte
      $config['max_width']            = 1000; // set max width image allowed
      $config['max_height']           = 1000; // set max height allowed
      //$config['file_name']            = round(microtime(true) * 1000); //just milisecond timestamp fot unique name

      $this->load->library('upload', $config);

      if(!$this->upload->do_upload('photo')) //upload and validate
      {
          $data['inputerror'][] = 'photo';
          $data['error_string'][] = 'Upload error: '.$this->upload->display_errors('',''); //show ajax error
          $data['status'] = FALSE;
          echo json_encode($data);
          exit();
      }
      return $this->upload->data('file_name');
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