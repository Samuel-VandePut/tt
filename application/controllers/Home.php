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
    $data['page'] = 'accueil';
    $this->layout->views('includes/header.inc.php')->views('includes/navbar.inc.php',$data)->views('body.php')->view('includes/footer.inc.php');
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
        switch($_SESSION['Niveau'])
        {
          case 1:
          $this->Page_perso();
          break;
          case 5:
          $data['page'] = 'joueurs';
          $this->layout->views('admin/includes/header.inc.php')->views('admin/includes/navbar.inc.php',$data)->views('admin/admin_joueurs.php')->views('admin/includes/footer.inc.php')->view('admin/admin_joueurs_ajax.php');  
          break;
          default: 
          $data['page'] = 'mapage';
          $this->layout->views('includes/header.inc.php')->views('includes/navbar.inc.php',$data)->views('body.php')->view('includes/footer.inc.php');
          break;
        }
         
      }
      else
      {      
        //$erreur['Erm']='ok';
       /// $this->layout->views('includes/header.inc.php')->views('includes/navbar.inc.php')->views('body',$erreur)->view('includes/footer.inc.php');
          $error['er']="no";
          $data['page'] = 'accueil';
           $this->layout->views('includes/header.inc.php')->views('includes/navbar.inc.php',$data)->views('body.php', $error)->view('includes/footer.inc.php');
                
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

      $datas['page'] = 'mapage';
      $this->layout->views('includes/header.inc.php')->views('includes/navbar.inc.php',$datas)->views('page_perso.php',$data)->views('includes/footer.inc.php')->view('page_perso_ajax.php');  
  }

  public function Logout()
  {
      $this->session->sess_destroy();
      redirect('/home/', 'refresh');
  }

  public function Admin()
  {
    $data['page'] = 'joueurs';
    $this->layout->views('admin/includes/header.inc.php')->views('admin/includes/navbar.inc.php',$data)->views('admin/admin_joueurs.php')->views('admin/includes/footer.inc.php')->view('admin/admin_joueurs_ajax.php');      
  }

  public function Interclubs()
  {
      $data['page'] = 'interclubs';
      $this->layout->views('admin/includes/header.inc.php')->views('admin/includes/navbar.inc.php',$data)->views('admin/admin_interclubs.php')->views('admin/includes/footer.inc.php')->view('admin/admin_interclubs_ajax.php');
  }

  public function Matchs()
  {
      $data['page'] = 'matchs';
      $this->layout->views('admin/includes/header.inc.php')->views('admin/includes/navbar.inc.php',$data)->views('admin/admin_matchs.php')->views('admin/includes/footer.inc.php')->view('admin/admin_matchs_ajax.php');
  }

  public function Equipes()
  {
      $data['page'] = 'equipes';
      $this->layout->views('admin/includes/header.inc.php')->views('admin/includes/navbar.inc.php',$data)->views('admin/admin_equipes.php')->views('admin/includes/footer.inc.php')->view('admin/admin_equipes_ajax.php');
  }


  public function Joueurs()
  {
      $data['page'] = 'joueurs';
      $this->layout->views('admin/includes/header.inc.php')->views('admin/includes/navbar.inc.php',$data)->views('admin/admin_joueurs.php')->views('admin/includes/footer.inc.php')->view('admin/admin_joueurs_ajax.php');
  }

  public function ajax_interclub()
  {
    $this->load->model('interclub_model','interclub');
    $data = $this->interclub->get();
    echo json_encode(array("interclub" => $data));
  }

  function backup()
  {
          $this->load->dbutil();
  
          $prefs = array(     
                  'format'      => 'zip',             
                  'filename'    => 'my_db_backup.sql'
                );
  
          $backup =& $this->dbutil->backup($prefs); 
  
          $db_name = 'backup-on-'. date("Y-m-d-H-i-s") .'.zip';
          $save = 'pathtobkfolder/'.$db_name;

          $this->load->helper('file');
          write_file($save, $backup); 
  
          $this->load->helper('download');
          force_download($db_name, $backup);
  }

  public function classementVirtuel()
  {
      $this->load->model('joueur_model');//charger le modèle joueur
      $def = $this->joueur_model->defaites($_SESSION['Id_jou']);
      $vict = $this->joueur_model->victoires($_SESSION['Id_jou']);
      $classement = $this->joueur_model->classement($_SESSION['Id_jou']);

      $this->load->library('classementVirtuel');
      $classementVirtuel = $this->classementvirtuel->classement_virtuel($classement,$vict,$def);
      echo json_encode(array("status" => TRUE, "classementVirtuel" => $classementVirtuel));
  }

}