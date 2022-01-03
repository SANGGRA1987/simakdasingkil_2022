<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ClientModel extends CI_Model {
	function __construct(){
		parent::__construct();
	}

	public function clientData(){
		$this->db->select('*');
		$this->db->from('sclient');
		$data = $this->db->get();
		return $data->row();
	}
}