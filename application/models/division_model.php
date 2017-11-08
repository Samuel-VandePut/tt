<?php

class division_model extends CI_Model{

  var $table = 'division';
  var $column_order = array('nom'); //set column field database for datatable orderable
  var $column_search = array('nom'); //set column field database for datatable searchable just firstname , lastname , address are searchable
  var $order = array('id_division' => 'asc'); // default order 
 

  function __construct() {
  parent::__construct();
  }
  
  public function get_by_id($id)
  {
      $this->db->from($this->table);
      $this->db->where('id_division',$id);
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
      $this->db->where('id_division', $id);
      $this->db->delete($this->table);
  }

  public function get()
  {
      $this->db->from($this->table);
      $query = $this->db->get();

      return $query->result();

  }

}

?>