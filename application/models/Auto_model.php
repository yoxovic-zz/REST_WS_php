<?php
class Auto_model extends CI_Model {
	
	function __construct() {
		parent::__construct ();
	}
		
	public function auto_lista() {
		
		//SQL upit: SELECT * FROM auto;
		
		$query = $this->db->get('auto');
		
		if (!is_null ($query)) {
			return $query->result();
		}

		return null;
	}
	
	public function auto_po_id($auto_id) {
		
		//SQL upit: SELECT * FROM auto WHERE auto_id=?;
		
		$query = $this->db->select('*')->from('auto')->where('auto_id', $auto_id)->get();
		
		if ($query->num_rows() === 1) {
			return $query->row_array();
		}
		
		return null;
	}
	
	public function sacuvaj_auto($marka, $model, $godiste, $kubikaza, $boja, $cena) {	
		
		$data = array('marka' => $marka, 'model' => $model, 
					'godiste' => $godiste, 'kubikaza'=> $kubikaza, 
					'boja'=> $boja, 'cena'=> $cena);
		
		//SQL upit: INSERT INTO auto (marka, model, godiste, kubikaza, boja, cena) VALUES(?,?,?,?,?,?);
		
		$this->db->insert('auto', $data);
		
		if ($this->db->affected_rows() === 1) {
			return true;
		}
		
		return null;
	}
	
	public function uredi_auto($auto_id, $marka) {
		
		$data = array('marka' => $marka);
		
		//SQL upit: UPDATE auto SET marka=? WHERE auto_id=?;
		
		$this->db->where('auto_id', $auto_id);
		$this->db->update('auto', $data);
		
		if ($this->db->affected_rows() === 1) {
			return true;
		}
	
		return null;
	}
	
	public function izbrisi_auto($auto_id) {
	
		$data = array('auto_id' => $auto_id);

		//SQL upit: DELETE FROM auto WHERE auto_id=?;
		
		$this->db->delete('auto', $data);
	
		if ($this->db->affected_rows() === 1) {
			return true;
		}
	
		return false;
	}

}