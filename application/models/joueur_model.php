<?php

class joueur_model extends CI_Model{

  var $table = 'joueurs';
  var $column_order = array('classement','disponibilite','bannir','FK_personne','FK_pool'); //set column field database for datatable orderable
  var $column_search = array('classement','disponibilite','FK_pool'); //set column field database for datatable searchable just firstname , lastname , address are searchable
  var $order = array('id_joueur' => 'desc'); // default order 
 

  function __construct() {
  parent::__construct();
  }

  private function _get_datatables_query($pool)
  {
      //$this->db->select('id_joueur','nom','prenom','classement','FK_pool as pool','disponibilite');
      $this->db->from($this->table);
      $this->db->join('personnes','joueurs.FK_personne = personnes.id_personne','left');
      $this->db->where('FK_pool',$pool);
      
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

  function get_datatables($pool)
  {
      $this->_get_datatables_query($pool);
      if($_POST['length'] != -1)
      //$this->db->limit($_POST['length'], $_POST['start']);
      $query = $this->db->get();
      return $query->result();
  }

  function count_filtered($pool)
  {
      $this->_get_datatables_query($pool);
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
      $this->db->where('id_joueur',$id);
      $query = $this->db->get();

      return $query->row();
  }

  public function get_by_name($nom,$prenom)
  {
      $this->db->from($this->table);
      $this->db->join('personnes','joueurs.FK_personne = personnes.id_personne','left');
      $this->db->where('nom',$nom);
      $this->db->where('prenom',$prenom);
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
      $this->db->where('id_joueur', $id);
      $this->db->delete($this->table);
  }

  public function get_joueurs_dispo()
  {
      $this->db->from($this->table);
      $this->db->where('disponibilite', 1);
      $query = $this->db->get();

      return $query->row();
  }
  
  public function get_joueurs_pool($pool)
  {
    $this->db->from($this->table);
    $this->db->join('personnes','joueurs.FK_personne = personnes.id_personne','left');
    $this->db->where('FK_pool',$pool);
    $query = $this->db->get();
    return $query->result();
  }
  
  public function get_joueurs()
  {
    $this->db->from($this->table);
    $this->db->join('personnes','joueurs.FK_personne = personnes.id_personne','left');
    $query = $this->db->get();
    return $query->result();
  }

  public function get_joueurs_info($id_joueur)
  {
//SELECT * FROM `interclub` inner join rencontre on 
    //id_interclub = FK_interclub inner join `match` on id_rencontre=FK_rencontre
    //$this->db->select('*');   
    
    $this->db->from('interclub');
    $this->db->join('rencontre', 'rencontre.FK_interclub= interclub.id_interclub');
    $this->db->join('match', 'rencontre.id_rencontre = match.FK_rencontre');
    $this->db->where('rencontre.FK_joueur',$id_joueur);
    $query = $this->db->get();

  
        
        if (count($query) > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
   }

  public function get_form($id_joueur)
  {
    $this->db->select('victoire, defaite');    
    $this->db->from('match');
    $this->db->join('rencontre', 'match.FK_rencontre = rencontre.id_rencontre');
    $this->db->where('FK_joueur',$id_joueur);
    $this->db->limit(5);
    $query = $this->db->get();
    return $query->result();
  }


public function get_joueurs_match($id_joueur)
{
  $this->db->select('*');    
  $this->db->from($this->table);
  $this->db->join('rencontre', 'joueurs.id_joueur= rencontre.FK_joueur');
  $this->db->join('match', 'rencontre.id_rencontre = match.FK_rencontre');
  $this->db->where('joueurs.id_joueur',$id_joueur);
  $this->db->limit(1);
  $query = $this->db->get();
  //var_dump($this->db->last_query());die(); 

      
      if (count($query) > 0) {
          foreach ($query->result() as $row) {
              $data[] = $row;
          }
          return $data;
      }
}

  public function total_match_def($id_joueur)
  {
    /*$this->db->select('victoire');  
    $this->db->from($this->table);
    $this->db->join('rencontre', 'joueurs.id_joueur= rencontre.FK_joueur');
    $this->db->join('match', 'rencontre.id_rencontre = match.FK_rencontre');
    $this->db->where('joueurs.id_joueur',$id_joueur);
    $this->db->where('match.victoire',NULL);/*/
    //$query = $this->db->get();
    
    //SELECT * FROM `interclub` inner join rencontre on 
    //id_interclub = FK_interclub inner join `match` on id_rencontre=FK_rencontre WHERE FK_joueur=22 and victoire is not null

    // return $query->num_rows(); 

     $this->db->select('victoire');
     $this->db->from('interclub');
     $this->db->join('rencontre', 'rencontre.FK_interclub= interclub.id_interclub');
     $this->db->join('match', 'rencontre.id_rencontre = match.FK_rencontre');
     $this->db->where('rencontre.FK_joueur',$id_joueur);
     $this->db->where('match.victoire','');
     $query = $this->db->get();

     return $query->num_rows(); 
     
        
    }

  public function total_match_victoire($id_joueur)
  {
    

    $this->db->select('victoire');
    $this->db->from('interclub');
    $this->db->join('rencontre', 'rencontre.FK_interclub= interclub.id_interclub');
    $this->db->join('match', 'rencontre.id_rencontre = match.FK_rencontre');
    $this->db->where('rencontre.FK_joueur',$id_joueur);
    $this->db->where('match.defaite','');
    $query = $this->db->get();

    return $query->num_rows();
      

    }

  public function total_match($id_joueur)
  {

    $this->db->select('id_match');  
    $this->db->from($this->table);
    $this->db->join('rencontre', 'joueurs.id_joueur= rencontre.FK_joueur');
    $this->db->join('match', 'rencontre.id_rencontre = match.FK_rencontre');
    $this->db->where('joueurs.id_joueur',$id_joueur);
    $query = $this->db->get();

     return $query->num_rows(); 
        
    }

}

?>