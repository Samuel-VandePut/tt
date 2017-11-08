<?php

class rencontre_model extends CI_Model{

  var $table = 'rencontre';
  var $column_order = array('FK_joueur','FK_interclub','FK_equipe'); //set column field database for datatable orderable
  var $column_search = array('FK_interclub'); //set column field database for datatable searchable just firstname , lastname , address are searchable
  var $order = array('id_renconte' => 'desc'); // default order 
 

  function __construct() {
  parent::__construct();
  }

  public function get_by_id($id)
  {
      $this->db->from($this->table);
      $this->db->where('id_joueur',$id);
      $query = $this->db->get();

      return $query->row();
  }

  public function get_by_interclub_id($id_interclub)
  {
      $this->db->from($this->table);
      $this->db->where('FK_interclub',$id_interclub);
      $query = $this->db->get();

      return $query->result();
  }

  public function get_by_joueur_interclub($id_joueur,$id_interclub)
  {
      $this->db->from($this->table);
      $this->db->where('FK_joueur',$id_joueur);
      $this->db->where('FK_interclub',$id_interclub);
      $query = $this->db->get();

      return $query->row();
  }

  public function save($data)
  {
      $this->db->insert($this->table, $data);
      return $this->db->insert_id();
  }

  public function save_batch($data)
  {
      $this->db->insert_batch($this->table, $data);
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

  public function get_joueurs($interclub)
  {
      $this->db->select('FK_joueur');
      $this->db->from($this->table);
      $this->db->join('interclub','rencontre.FK_interclub = interclub.id_interclub','left');
      $this->db->where('FK_interclub',$interclub);
      $query = $this->db->get();

      return $query->result();
  }

  public function get_rencontres_team($interclub,$team)
  {
      $this->db->select('FK_joueur, nom, prenom, classement');
      $this->db->from($this->table);
      $this->db->join('interclub','rencontre.FK_interclub = interclub.id_interclub','left');
      $this->db->join('joueurs','rencontre.FK_joueur = joueurs.id_joueur','left');
      $this->db->join('personnes','joueurs.FK_personne = personnes.id_personne','left');
      $this->db->where('FK_interclub', $interclub);
      $this->db->where('FK_equipe', $team);
      $query = $this->db->get();

      return $query->result();
  }

}

?>