<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

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
  }

  public function index()
  {
    $this->layout->views('includes/header.inc.php')->views('includes/navbar.inc.php')->views('body.php')->view('includes/footer.inc.php');
  }

  function login()
  {
    if (isset($_POST['password']) and isset($_POST['login']))
    {   
      $this->load->model('user_model','user');

      $users=$this->user->login($_POST['login'], $_POST['password']);

      if($users != null)//Si l'utilisateur existe
      {
        foreach ($users as $user)
        {
         session_start();//Démarrer la session
         //Initier $_SESSION
         $_SESSION['connect'] = array(
              'Nom' => $user->nom,
              'Prenom'  => $user->prenom,
              'Niveau'  => $user->niveau,
              'Id_jou'  => $user->id_joueur
              );
        }

        switch($_SESSION['connect']['Niveau'])
        {
          case 1: //show player page

          $this->load->model('joueur_model');  
          $joueur['recup']=$this->joueur_model->get_joueurs_info($_SESSION['connect']['Id_jou']);

          $data=array();
          $data['joueur']=$joueur['recup'];
          $data['nom']=$_SESSION['connect']['Nom'];
          $data['prenom']=$_SESSION['connect']['Prenom'];

          $this->layout->views('includes/header.inc.php')->views('includes/navbar.inc.php')->views('page_perso.php',$data)->view('includes/footer.inc.php');
          break;
          case 5: //show club admin page
          $this->layout->views('admin/includes/header.inc.php')->views('admin/includes/navbar.inc.php')->views('admin/admin_joueurs.php')->views('admin/includes/footer.inc.php')->view('admin/admin_joueurs_ajax.php');
          break;
        }
      }
      else
      {      
        $erreur['Erm']='ok';
        $this->layout->views('includes/header.inc.php')->views('includes/navbar.inc.php')->views('body',$erreur)->view('includes/footer.inc.php');
      }
    }
  }

  public function Logout()
  {
      $this->load->library('session');
      $this->session->unset_userdata('connect');
      session_destroy();
      redirect('/home/', 'refresh');
  }

  public function Interclubs()
  {
      $this->layout->views('admin/includes/header.inc.php')->views('admin/includes/navbar.inc.php')->views('admin/admin_interclubs.php')->views('admin/includes/footer.inc.php')->view('admin/admin_interclubs_ajax.php');
  }

  public function Joueurs()
  {
      $this->layout->views('admin/includes/header.inc.php')->views('admin/includes/navbar.inc.php')->views('admin/admin_joueurs.php')->views('admin/includes/footer.inc.php')->view('admin/admin_joueurs_ajax.php');
  }

  public function password_check($old_password)
  {
      //Récupérer le password utilisateur avec variable SESSION
      $user = $this->users->get_password($_SESSION['connect']['Nom'],$_SESSION['connect']['Prenom']);

      if (sha1($_POST['old_password']) == $user['password'])
      {
        return true;
      } else{    
        
        $this->form_validation->set_message('password_check', 'Ancien mot de passe incorrect');
        return false;
      }
  }

  public function ajax_upload()
  {
      $status = array();
      if(!empty($_FILES['fichierCSV']['name']))//SI un fichier a été sélectionné
      {
        if(file_exists('assets/files/'.$_FILES['fichierCSV']['name']))//Si le fichier existe déjà 
        {
          $status['error'] = 'Le nom du fichier existe déjà';
        }
        else
        {
          $upload = $this->_do_upload();
          $status['match'] = $upload;

          //Lire le fichier csv
          $csvData = $this->readExcel('assets/files/'.$_FILES['fichierCSV']['name']);
          $matchs = array();
          foreach($csvData as $match)//lire ligne par ligne
          {
            //récupérer id rencontre et id joueur avec date, nom et prenom du joueur      
            $this->load->model('joueur_model','joueur');
            $joueur = $this->joueur->get_by_name($match['nom'],$match['prenom']);

            //récupérer id_interclub si il existe, sinon créer l'interclub
            $this->load->model('interclub_model','interclub');
            $interclub = $this->interclub->get_by_date(date('Y-m-j',strtotime($match['date'])));
            if($interclub == null) $status['error'] = 'L\'interclub pour cette date n\'existe pas';
            
            $this->load->model('rencontre_model','rencontre');
            $rencontre = $this->rencontre->get_by_joueur_interclub($joueur->id_joueur,$interclub->id_interclub);
            //Si la rencontre n'existe pas => renvoyer une erreur date ou joueur
            if($rencontre == null) $status['error'] = 'Les équipes pour cet interclub n\'ont pas été créées';

            //ajouter les matchs            
            $this->load->model('match_model','match');
            $data = array(
                    'FK_rencontre' => $rencontre->id_rencontre,
                    'victoire' => $match['victoire'],
                    'defaite' => $match['defaite']
                );

            $id = $this->match->save($data);

            //Créer liste des matchs pour datatable
            $row = array();
            $row[] = $id;
            $row[] = $match['date'];
            $row[] = $match['nom'];
            $row[] = $match['prenom'];
            $row[] = $match['victoire'];
            $row[] = $match['defaite'];
            $matchs[] = $row;  
          }
        }
      }//sinon gérer l'erreur
      else
      {
        $status['error'] = 'Veuillez sélectionner un fichier svp';
      }

      echo json_encode(array("status" => $status,'name' => $_FILES['fichierCSV']['name'], 'matchs' => $matchs));
  }

  private function _do_upload()
  {
      $config['upload_path']          = 'assets/files';
      $config['allowed_types']        = 'csv|xls|txt';
      $config['max_size']             = 500; //set max size allowed in Kilobyte
      $config['max_width']            = 1000; // set max width image allowed
      $config['max_height']           = 1000; // set max height allowed
      //$config['file_name']            = round(microtime(true) * 1000); //just milisecond timestamp fot unique name

      $this->load->library('upload', $config);

      if(!$this->upload->do_upload('fichierCSV')) //upload and validate
      {
          $data['inputerror'][] = 'fichierCSV';
          $data['error_string'][] = 'Upload error: '.$this->upload->display_errors('',''); //show ajax error
          $data['status'] = FALSE;
          echo json_encode($data);
          exit();
      }
      return $this->upload->data('file_name');
  }

  public function readExcel($path)
  {
      $this->load->library('csvreader');
      $result = $this->csvreader->parse_file($path);
      return $result;
      //$data['csvData'] =  $result;
      //$this->load->view('view_csv', $data);  
  }

  public function filesList()
  {
      $this->load->helper('directory');
      $map = directory_map('assets/files/');
      $data = array();
      $no = 0;
      foreach ($map as $file) {
          $no++;
          $row = array();
          $row[] = $no;
          $row[] = $file;

          $data[] = $row;
      }
      echo json_encode(array("data" => $data));
  }

}