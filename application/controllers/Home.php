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
    $this->load->model('service_model');
    $this->load->model('realisations');
    $this->load->library('layout');
  }

  public function index()
  {
    $this->layout->views('includes/header.inc.php')->views('includes/navbar.inc.php')->views('body')->view('includes/footer.inc.php');
  }

  function Services($service){

    if($service == "all"){
        $datas['services'] = $this->services->get_services();
        //$datas['query_result'] = (object) array('id' => 5);
        $this->layout->views('includes/header.inc.php')->views('includes/navbar.inc.php')->views('services', $datas)->view('includes/footer.inc.php');
    }
    else {
        $datas['query_result'] = $this->services->get_service($service);

        $this->layout->views('includes/header.inc.php')->views('includes/navbar.inc.php')->views('services.php', $datas)->view('includes/footer.inc.php');
    }

  }

  function Realisations($service){

    if($service == "all"){
        $datas['realisations'] = $this->realisations->get_realisations();
        //$datas['query_result'] = (object) array('id' => 5);
        $this->layout->views('includes/header.inc.php')->views('includes/navbar.inc.php')->views('realisations.php', $datas)->view('includes/footer.inc.php');   
     } else {
        $datas['query_result'] = $this->realisations->get_realisation($service);

        $this->layout->views('includes/header.inc.php')->views('includes/navbar.inc.php')->views('realisations.php', $datas)->view('includes/footer.inc.php');
    }
  }

  function Temoignages(){

    $this->load->model('temoignages');

    $datas['query_result'] = $this->temoignages->get_temoignages();
    
    $this->layout->views('includes/header.inc.php')->views('includes/navbar.inc.php')->views('temoignages.php', $datas)->view('includes/footer.inc.php');
  
  }

  
  function Contact(){
    $this->layout->views('includes/header.inc.php')->views('includes/navbar.inc.php')->views('contact.php')->view('includes/footer.inc.php');
  }

  /*function mail()
  {
    if(isset($_POST['email']) && isset($_POST['name']) && isset($_POST['content']))
    {
      $this->load->library('form_validation');

      $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

      //Validating First Name Field
      $this->form_validation->set_rules('name', 'Name', 'required|trim|min_length[3]|max_length[20]|callback_alpha_dash_space_name');
      $this->form_validation->set_message('alpha_dash_space_name', 'Veuillez entrer votre nom');

      //Validating Email Field
      $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
      $this->form_validation->set_message('required', 'Champ requis');

      //Validating First Name Field
      $this->form_validation->set_rules('content', 'Content', 'required|min_length[10]|max_length[300]');
      $this->form_validation->set_message('required', 'Champ requis');
      
      if ($this->form_validation->run() == FALSE) 
      {
        $this->layout->views('includes/header.inc.php')->views('includes/navbar.inc.php')->views('body')->view('includes/footer.inc.php');
      }  
      else
      {
        $mail = $_POST['email'];
        $name = $_POST['name'];
        $content = $_POST['content'];

        $this->send_mail($mail,$name,$content);

        $data['message'] = 'ok';

        //Loading View
        $this->layout->views('includes/header.inc.php')->views('includes/navbar.inc.php')->views('body')->view('includes/footer.inc.php');
      }
    }
  }

  function send_mail($mail,$name,$content)
  {
    $this->load->library('email');

    $this->email->from($mail, $name);
    $this->email->to('sam.vdp@hotmail.com');

    $this->email->subject('Email envoye depuis le site web');
    $this->email->message($content);

    $this->email->send();
  }

  function alpha_dash_space_name($str)
  {
      return ( ! preg_match("/^([-a-z_ ])+$/i", $str)) ? FALSE : TRUE;
  }*/

}