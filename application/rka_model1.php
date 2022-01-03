<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 
 */

class Rka_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	
	// Tampilkan semua master data kegiatan
	function getAll($limit, $offset,$id)
	{
		$this->db->select('trskpd.kd_urusan,trskpd.kd_skpd,trskpd.kd_kegiatan as giat,m_giat.nm_kegiatan');
		$this->db->from('trskpd');
        $this->db->join('m_giat','m_giat.kd_kegiatan=trskpd.kd_kegiatan1');
       	$this->db->where('trskpd.kd_skpd', $id);
        $this->db->where('trskpd.jns_kegiatan','52');
        $this->db->order_by('trskpd.kd_skpd');
		$this->db->order_by('trskpd.kd_kegiatan', 'asc');
		$this->db->limit($limit,$offset);
		return $this->db->get();
	}
    
    function getAllc()
	{
		$this->db->select('trskpd.kd_urusan,trskpd.kd_skpd,trskpd.kd_kegiatan as giat,m_giat.nm_kegiatan');
		$this->db->from('trskpd');
        $this->db->join('m_giat','m_giat.kd_kegiatan=trskpd.kd_kegiatan1');
        $this->db->order_by('trskpd.kd_skpd');
		$this->db->order_by('trskpd.kd_kegiatan', 'asc');
		//$this->db->limit($limit,$offset);
		return $this->db->get();
	}
    
    	function get_count_cari($data)
	{
        $this->db->select('trskpd.kd_urusan,trskpd.kd_skpd,trskpd.kd_kegiatan as giat,m_giat.nm_kegiatan');
		$this->db->from('trskpd');
        $this->db->join('m_giat','m_giat.kd_kegiatan=trskpd.kd_kegiatan1');
        $this->db->order_by('trskpd.kd_skpd');
		$this->db->order_by('trskpd.kd_kegiatan', 'asc');
		return $this->db->get()->num_rows();
		//return $this->db->get('ms_fungsi')->num_rows();
	}
    
    //cari
    function cari($limit, $offset,$data)
	{
		$this->db->select('trskpd.kd_urusan,trskpd.kd_skpd,trskpd.kd_kegiatan as giat,m_giat.nm_kegiatan');
		$this->db->from('trskpd');
        $this->db->join('m_giat','m_giat.kd_kegiatan=trskpd.kd_kegiatan1');
        $this->db->or_like('nm_kegiatan', $data);  
        $this->db->or_like('trskpd.kd_kegiatan', $data);      
		$this->db->order_by('trskpd.kd_kegiatan', 'asc');
		return $this->db->get();
	}
    
		// Simpan data
	function save($tabel,$data)
	{
		$this->db->insert($tabel,$data);
	}

	//get nama dari master
	function get_nama($kode,$hasil,$tabel,$field)
	{
        $this->db->select($hasil);
		$this->db->where($field, $kode);
		$q = $this->db->get($tabel);
		$data  = $q->result_array();
		$baris = $q->num_rows();
		return $data[0][$hasil];
	}
	

	// Total jumlah data
	function get_count($id)
	{
        $this->db->select('*');
		$this->db->from('trskpd');
		$this->db->where('kd_skpd', $id);
        $this->db->where('trskpd.jns_kegiatan','52');
		return $this->db->get()->num_rows();
	}
	
	// Ambil by ID
	function get_by_id($id)
	{
		$this->db->select('*');
		$this->db->from('trskpd');
		$this->db->where('kd_kegiatan', $id);
		return $this->db->get();
	}
    
    function get_program($id)
	{
		$this->db->select('*');
		$this->db->from('m_prog');
		$this->db->order_by('kd_program',$id);
        $this->db->limit($limit,$offset);
		return $this->db->get();
	}
    
    function combo_skpd($skpd='',$tahun='') 
    {
               
        $csql    = "SELECT * from ms_skpd order by kd_skpd ";
        $query   = $this->db->query($csql);
         
        $cRet    = "<select name=\"skpd\" id=\"skpd\" style=\"height:28px;width:350px\">";
        $cRet   .= "<option value=\"\">--Pilih Kode SKPD--</option>";
        foreach ($query->result_array() as $row)
        {
           $selected = ($row['kd_skpd']==$skpd) ? " selected" : "";
           if (!empty($row['kd_skpd'])) 
                $cRet .= "<option value='".$row['kd_skpd']."'".$selected.">".$row['kd_skpd']." | ".$row['nm_skpd']."</option>";
        
        }
        $cRet .= "</select>";
        
        return $cRet;
    }

	function combo_giat($giat='',$skpd=''){
               
        $csql    = "SELECT a.kd_kegiatan1,a.kd_kegiatan,b.nm_kegiatan FROM trskpd a LEFT JOIN m_giat b ON a.kd_kegiatan1=b.kd_kegiatan where a.kd_skpd like '%$skpd%' ORDER BY b.kd_kegiatan";
        $query   = $this->db->query($csql);
         
        $cRet    = "<select name=\"giat\" id=\"giat\" onchange=\"javascript:validate_combo();\" style=\"height:28px;width:350px\" >"; 
        $cRet   .= "<option value=\"\">--Pilih Kode Kegiatan--</option>";
        foreach ($query->result_array() as $row)
        {
           $selected = ($row['kd_kegiatan']==$giat) ? " selected" : "";
           if (!empty($row['kd_kegiatan'])) 
                $cRet .= "<option value='".$row['kd_kegiatan']."' ".$selected.">".$row['kd_kegiatan']." | ".$row['nm_kegiatan']."</option>";
     
        }
        $cRet .= "</select>";        
        return $cRet;
    }
    
    function combo_ttd($kode='') 
    {
               
        $csql    = "SELECT * from ms_ttd order by nama ";
        $query   = $this->db->query($csql);
         
        $cRet    = "<select name=\"ttd\" id=\"ttd\" style=\"height:28px;width:200px\">";
        $cRet   .= "<option value=\"\">Pilih Penanda Tangan</option>";
        foreach ($query->result_array() as $row)
        {
           $selected = ($row['nip']==$kode) ? " selected" : "";
           if (!empty($row['nip'])) 
                $cRet .= "<option value='".$row['nip']."'".$selected.">".$row['nama']."</option>";
        
        }
        $cRet .= "</select>";
        
        return $cRet;
    }

    function combo_urus($skpd='',$tahun='') 
    {
               
        $csql    = "SELECT * from ms_urusan order by kd_urusan ";
        $query   = $this->db->query($csql);
         
        $cRet    = "<select name=\"urusan\" id=\"urusan\">";
        $cRet   .= "<option value=\"\">--Pilih Kode Urusan--</option>";
        foreach ($query->result_array() as $row)
        {
           $selected = ($row['kd_urusan']==$skpd) ? " selected" : "";
           if (!empty($row['kd_urusan'])) 
                $cRet .= "<option value='".$row['kd_urusan']."'".$selected.">".$row['kd_urusan']." | ".$row['nm_urusan']."</option>";
        
        }
        $cRet .= "</select>";
        
        return $cRet;
    }

	function combo_skpd1($skpd='',$tahun='') 
    {
               
        $csql    = "SELECT * from ms_skpd order by kd_skpd ";
        $query   = $this->db->query($csql);
         
        $cRet    = "<select name=\"skpd\" id=\"skpd\" onchange=\"javascript:validate_combo();\">";
        $cRet   .= "<option value=\"\">--Pilih Kode SKPD--</option>";
        foreach ($query->result_array() as $row)
        {
           $selected = ($row['kd_skpd']==$skpd) ? " selected" : "";
           if (!empty($row['kd_skpd'])) 
                $cRet .= "<option value='".$row['kd_skpd']."'".$selected.">".$row['kd_skpd']." | ".$row['nm_skpd']."</option>";
        
        }
        $cRet .= "</select>";
        
        return $cRet;
    }
       
}




/* End of file fungsi_model.php */
/* Location: ./application/models/fungsi_model.php */