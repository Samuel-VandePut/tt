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
              'Prenom'  => $user->prenom
              );
        }
        //Charger la page
        $this->layout->views('includes/header.inc.php')->views('includes/navbar.inc.php')->views('page_perso.php')->view('includes/footer.inc.php');
      }
      else
      {      
        $erreur['Erm']='ok';
        $this->layout->views('includes/header.inc.php')->views('includes/navbar.inc.php')->views('body',$erreur)->view('includes/footer.inc.php');
      }
    }
  }


  function page_perso(){
    session_start();

    if($_SESSION['connect']['Prof'] == 0){

       $this->layout->views('includes/header.inc.php')->views('includes/navbar_user.inc.php')->views('page_perso')->view('includes/footer.inc.php');

    }elseif ($_SESSION['connect']['Prof'] == 1) {

        $membre['liste']=$this->users->list_of_members();
        $this->layout->views('includes/header.inc.php')->views('includes/navbar_user.inc.php')->views('page_admin',$membre)->view('includes/footer.inc.php');
    }

  }
  
  function Logout(){

      $this->load->library('session');
      $this->session->unset_userdata('connect');
      session_destroy();
      redirect('/home/', 'refresh');
  }

  public function password_check($old_password){

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




}