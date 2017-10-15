<?php

class user_model extends CI_Model{

  var $table = 'users';
  var $column_order = array('nom','prenom','email','telephone','password','token','niveau','date_creation','sexe','date_naissance'); //set column field database for datatable orderable
  var $column_search = array('nom','prenom','email','cp','sexe'); //set column field database for datatable searchable just firstname , lastname , address are searchable
  var $order = array('id' => 'desc'); // default order 
 

  function __construct() {
  parent::__construct();
  }

  private function _get_datatables_query()
  {
      $this->db->from($this->table);

      $i = 0;
   
      foreach ($this->column_search as $item) // loop column 
      {
          if($_POST['search']['value']) // if datatable send POST for search
          {
               
              if($i===0) // first loop
              {
                  $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                  $this->db->like($item, $_POST['search']['value']);
              }
              else
              {
                  $this->db->or_like($item, $_POST['search']['value']);
              }

              if(count($this->column_search) - 1 == $i) //last loop
                  $this->db->group_end(); //close bracket
          }
          $i++;
      }
       
      if(isset($_POST['order'])) // here order processing
      {
          $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
      } 
      else if(isset($this->order))
      {
          $order = $this->order;
          $this->db->order_by(key($order), $order[key($order)]);
      }
  }

  function get_datatables()
  {
      $this->_get_datatables_query();
      if($_POST['length'] != -1)
      $this->db->limit($_POST['length'], $_POST['start']);
      $query = $this->db->get();
      return $query->result();
  }

  function count_filtered()
  {
      $this->_get_datatables_query();
      $query = $this->db->get();
      return $query->num_rows();
  }

  public function count_all()
  {
      $this->db->from($this->table);
      return $this->db->count_all_results();
  }

  public function get_by_id($id)
  {
      $this->db->from($this->table);
      $this->db->where('id',$id);
      $query = $this->db->get();

      return $query->row();
  }

  public function save($data)
  {
      $this->db->insert($this->table, $data);
      return $this->db->insert_id();
  }

  public function update($where, $data)
  {
      $this->db->update($this->table, $data, $where);
      return $this->db->affected_rows();
  }

  public function delete_by_id($id)
  {
      $this->db->where('id', $id);
      $this->db->delete($this->table);
  }


  public function send_mail_activation($user){

  $this->load->library('email');
          $config['protocol']    = 'smtp';
          $config['smtp_host']    = 'ssl://smtp.gmail.com';
          $config['smtp_port']    = '465';
          $config['smtp_timeout'] = '7';
          $config['smtp_user']    = 'ib.kone12@gmail.com';
          $config['smtp_pass']    = '';
          $config['charset']    = 'utf-8';
          $config['newline']    = "\r\n";
          $config['mailtype'] = 'html'; // or html
          $config['validation'] = TRUE; // bool whether to validate email or not      

          $this->email->initialize($config);

          $this->email->from('ib.kone12@gmail.com','Equipe Sam et IB ');
          $this->email->to('sam.vdp@hotmail.com'); 

          $this->email->subject('Inscription');
          $this->email->message('
            <p>Bonjour! Un nouvelle utilisateur souhaite s\'inscrire :</p>
            <p>Nom : '.$user['nom'].'</p>
            <p>Prenom : '.$user['prenom'].'</p>
            <p>Date de naissance : '.$user['date_naissance'].'</p>
            <p>Numero de téléphone : '.$user['telephone'].'</p>
            <p>Adresse mail : '.$user['email'].'</p>
            <p>Lien d\'activation : <a href="'.site_url('Home/account_activate/'.$user['token']).'">'.site_url('Home/account_activate/'.$user['token']).'</a></p>

                                                                                    <p>Bien à vous</p>
            ');  

          $this->email->send();

          echo $this->email->print_debugger();
}

public function send_mail_activated($user){

  $this->load->library('email');
          $config['protocol']    = 'smtp';
          $config['smtp_host']    = 'ssl://smtp.gmail.com';
          $config['smtp_port']    = '465';
          $config['smtp_timeout'] = '7';
          $config['smtp_user']    = 'ib.kone12@gmail.com';
          $config['smtp_pass']    = '';
          $config['charset']    = 'utf-8';
          $config['newline']    = "\r\n";
          $config['mailtype'] = 'html'; // or html
          $config['validation'] = TRUE; // bool whether to validate email or not      

          $this->email->initialize($config);

          $this->email->from('ib.kone12@gmail.com','Equipe Sam et IB ');
          $this->email->to($user->email); 

          $this->email->subject('Inscription');
          $this->email->message('
            <p>Bonjour '.$user->prenom.'! </p>
            <p>Féliciation votre compte est maintenant actif sur notre site web</p>
            <p>Vous pouvez dés lors vous logger avec vos références à cette addresse : </p>
            <p><a href="'.site_url().'">'.site_url().'</a></p>
            <p>Bonne journée!</p>
            
                                                                                    <p>Bien à vous</p>
            ');  

          $this->email->send();

          echo $this->email->print_debugger();
}


public function send_mail($mail,$password){

		  $this->load->library('email');
          $config['protocol']    = 'smtp';
          $config['smtp_host']    = 'ssl://smtp.gmail.com';
          $config['smtp_port']    = '465';
          $config['smtp_timeout'] = '7';
          $config['smtp_user']    = 'ib.kone12@gmail.com';
          $config['smtp_pass']    = '';
          $config['charset']    = 'utf-8';
          $config['newline']    = "\r\n";
          $config['mailtype'] = 'html'; // or html
          $config['validation'] = TRUE; // bool whether to validate email or not      

          $this->email->initialize($config);

          $this->email->from('ib.kone12@gmail.com','Equipe Sam et IB ');
          $this->email->to($mail); 

          $this->email->subject('Inscription');
          $this->email->message('
          	<p>Bienvenue!</p>
            <p>Nous avons bien reçu votre demande d\'inscription.  Vous allez recevoir prochainement un mail confirmant l\'activation de votre compte.</p>
            <p>Une fois activé, vous pourrez vous logger avec ces paramètres : </p> 
            <p>Votre Login : '.$mail.'</p>
            <p>Votre mot de passe : '.$password.'</p>

                                                                                    <p>Bien à vous</p>
            ');  

          $this->email->send();

          echo $this->email->print_debugger();

          //$this->load->view('email_view');
} 

public function send_password($mail,$password){

      $this->load->library('email');
          $config['protocol']    = 'smtp';
          $config['smtp_host']    = 'ssl://smtp.gmail.com';
          $config['smtp_port']    = '465';
          $config['smtp_timeout'] = '7';
          $config['smtp_user']    = 'ib.kone12@gmail.com';
          $config['smtp_pass']    = '';
          $config['charset']    = 'utf-8';
          $config['newline']    = "\r\n";
          $config['mailtype'] = 'html'; // or html
          $config['validation'] = TRUE; // bool whether to validate email or not      

          $this->email->initialize($config);

          $this->email->from('ib.kone12@gmail.com','Equipe Sam et IB ');
          $this->email->to($mail); 

          $this->email->subject('Inscription');
          $this->email->message('
            <p>Bienvenue! Votre Login : '.$mail.'</p>
            <p>Votre nouveau mot de passe : '.$password.'</p>

                                                                              <p>Bien à vous</p>
            ');  

          $this->email->send();

          echo $this->email->print_debugger();

          //$this->load->view('email_view');
} 

public function verifie_cle($jeton){

    $query = $this->db->query('select token,actif from personnes where token = "'.$jeton.'"');

    if ($query->num_rows() > 0)
    {   
        foreach ($query->result() as $row)
        {

            $sess['token'] = $row->token;
            $sess['actif'] = $row->actif; 
                 
        }
    }else{
         
         $sess['token'] = null;
         $sess['actif'] = null;

    }

    return $sess;

}

public function activer_compte($jeton,$data){

    $this->db->where('token', $jeton);
    $this->db->update('personnes', $data);
}

public function login($mail, $password){

   $email=htmlspecialchars(stripslashes($mail));
   $pwd= htmlspecialchars(stripslashes($password));

   $this->db->select('*');
   $this->db->from('personnes');
   $this->db->join('joueurs', 'personnes.id_personne=joueurs.FK_personne');
   $this->db->where('email',$email);
   $this->db->where('password',sha1($pwd));
   //$this->db->where('banned',0);
   $this->db->limit(1);
 
   $query = $this -> db -> get();
 
   if($query -> num_rows() == 1)
   {
     return $query->result();
   }
   else
   {
     return false;
   }
}

  public function passgen() {

    $chaine ="mnoTUzS5678kVvwxy9WXYZRNCDEFrslq41GtuaHIJKpOPQA23LcdefghiBMbj0";
    
    srand((double)microtime()*1000000);
    for($i=0; $i<8; $i++){
        @$pass .= $chaine[rand()%strlen($chaine)];
        }
    return $pass;

  }

  public function email_check($email){

     $this -> db -> select('*');
     $this -> db -> from('personnes');
     $this -> db -> where('email',$email); 
     $this -> db -> limit(1);
   
     $query = $this -> db -> get();
   
     if($query -> num_rows() == 1)
     {
        return $query->result();
     }
     else
     {
        return false;
     }
  }

  public function update_password($new_password,$email){

    $data = array(
               'password' => sha1($new_password)
            );
         $this->db->where('email', $email);
         $this->db->update('personnes', $data);

  }

  public function up_banned($data,$id) {

    $this->db->where('id', $id);
    $this->db->update('personnes',$data);

    
}

  public function new_update_password($new_password,$nom,$prenom){

       $data = array(
             'password' => sha1($new_password)
          );
       $this->db->where('nom', $nom);
       $this->db->where('prenom', $prenom);
       $this->db->update('personnes', $data);

  }

  public function get_password($nom,$prenom){

       $this -> db -> select('password');
       $this -> db -> from('personnes');
       $this -> db -> where('nom', $nom);
       $this -> db -> where('prenom',$prenom);
     
       $query = $this -> db -> get();
       $user = $query->row_array();

       return $user;
  }

}

?>