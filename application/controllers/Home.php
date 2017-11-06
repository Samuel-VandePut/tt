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
    $this->load->library('session');
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
         //session_start();//Démarrer la session
         //Initier $_SESSION
         //$_SESSION['connect'] = array(
         $connect = array(
              'Nom' => $user->nom,
              'Prenom'  => $user->prenom,
              'Niveau'  => $user->niveau,
              'Id_jou'  => $user->id_joueur
              );
         $this->session->set_userdata($connect);
        }
        //var_dump($_SESSION);die();
        $this->layout->views('includes/header.inc.php')->views('includes/navbar.inc.php')->views('body.php')->view('includes/footer.inc.php');
         
      }
      else
      {      
        //$erreur['Erm']='ok';
       /// $this->layout->views('includes/header.inc.php')->views('includes/navbar.inc.php')->views('body',$erreur)->view('includes/footer.inc.php');
          $error['er']="no";
        
           $this->layout->views('includes/header.inc.php')->views('includes/navbar.inc.php')->views('body.php', $error)->view('includes/footer.inc.php');
                
      }
    }
  }

  public function Page_perso()
  {   
      $this->load->model('joueur_model');//charger le modèle joueur
      $joueur['recup_dv'] = $this->joueur_model->get_joueurs_info($_SESSION['Id_jou']);
      $joueur_t['total_j'] = $this->joueur_model->get_joueurs_match($_SESSION['Id_jou']);
      $joueur['recup_total'] = $this->joueur_model->total_match($_SESSION['Id_jou']);
      $joueur['def'] = $this->joueur_model->total_match_def($_SESSION['Id_jou']);
      $joueur['vict'] = $this->joueur_model->total_match_victoire($_SESSION['Id_jou']);
     
      $data=array();
      $data['victoire'] = $joueur['vict'];
      $data['defaite'] = $joueur['def'];
      $data['joueur'] = $joueur['recup_dv'];
      $data['T_match'] = $joueur['recup_total'];
      $data['total'] = $joueur_t['total_j'];
      $data['nom'] = $_SESSION['Nom'];
      $data['prenom'] = $_SESSION['Prenom'];

      $this->layout->views('includes/header.inc.php')->views('includes/navbar.inc.php')->views('page_perso.php',$data)->view('includes/footer.inc.php');
    
  }

  public function Logout()
  {
      //$this->session->unset_userdata('connect');
      $this->session->sess_destroy();
      //session_destroy();
      //session_regenerate_id();
      /*foreach($_SESSION as $k => $v) 
      {
        unset($_SESSION[$k]);
      }*/
      redirect('/home/', 'refresh');
  }

  public function Admin()
  {
    $this->layout->views('admin/includes/header.inc.php')->views('admin/includes/navbar.inc.php')->views('admin/admin_joueurs.php')->views('admin/includes/footer.inc.php')->view('admin/admin_joueurs_ajax.php');      
  }

  public function Interclubs()
  {
      $this->layout->views('admin/includes/header.inc.php')->views('admin/includes/navbar.inc.php')->views('admin/admin_interclubs.php')->views('admin/includes/footer.inc.php')->view('admin/admin_interclubs_ajax.php');
  }

  public function Matchs()
  {
      $this->layout->views('admin/includes/header.inc.php')->views('admin/includes/navbar.inc.php')->views('admin/admin_matchs.php')->views('admin/includes/footer.inc.php')->view('admin/admin_matchs_ajax.php');
  }

  public function Equipes()
  {
      /*$this->load->model('division_model','division');
      $datas['divisions'] = $this->division->get();
      $this->load->model('equipe_model','equipe');
      $datas['equipes'] = $this->equipe->get($datas['divisions']->id_division);*/

      $this->layout->views('admin/includes/header.inc.php')->views('admin/includes/navbar.inc.php')->views('admin/admin_equipes.php')->views('admin/includes/footer.inc.php')->view('admin/admin_equipes_ajax.php');
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
      $matchs = array();
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

          //Créer une liste des matchs

          foreach($csvData as $match)//lire ligne par ligne
          {
            //récupérer id rencontre et id joueur avec date, nom et prenom du joueur      
            $this->load->model('joueur_model','joueur');
            $joueur = $this->joueur->get_by_name($match['nom'],$match['prenom']);

            //récupérer id_interclub si il existe
            $this->load->model('interclub_model','interclub');
            $interclub = $this->interclub->get_by_date(date('Y-m-j',strtotime($match['date'])));
            //Si l'interclub n'existe pas => renvoyer une erreur
            if($interclub == null)
            {
              $status['error'] = 'L\'interclub pour cette date n\'existe pas';
              break;
            } 
            $this->load->model('rencontre_model','rencontre');
            $rencontre = $this->rencontre->get_by_joueur_interclub($joueur->id_joueur,$interclub->id_interclub);
            //Si la rencontre n'existe pas => renvoyer une erreur
            if($rencontre == null) 
            {
              $status['error'] = 'Les équipes pour cet interclub n\'ont pas été créées';
              break;
            }

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

  public function ajax_interclub()
  {
    $this->load->model('interclub_model','interclub');
    $data = $this->interclub->get();
    echo json_encode(array("interclub" => $data));
  }

}