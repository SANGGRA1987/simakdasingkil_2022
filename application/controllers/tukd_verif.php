<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/** 
 * Tukd
 * 
 * @package  
 * @author Boomer
 * @copyright 2016
 * @version $Id$ 
 * @access public 
 */
class Tukd_verif extends CI_Controller {
  
	function __construct() 
	{	
		parent::__construct();
	}

    function _mpdf($judul='',$isi='',$lMargin='',$rMargin='',$font=0,$orientasi='') {
        
        ini_set("memory_limit","-1");
        ini_set("MAX_EXECUTION_TIME","-1");
        $this->load->library('mpdf');
        

        $this->mpdf->defaultheaderfontsize = 6; /* in pts */
        $this->mpdf->defaultheaderfontstyle = BI;   /* blank, B, I, or BI */
        $this->mpdf->defaultheaderline = 1;     /* 1 to include line below header/above footer */

        $this->mpdf->defaultfooterfontsize = 6; /* in pts */
        $this->mpdf->defaultfooterfontstyle = BI;   /* blank, B, I, or BI */
        $this->mpdf->defaultfooterline = 1; 
        $this->mpdf->SetLeftMargin = $lMargin;
        $this->mpdf->SetRightMargin = $rMargin;
        $jam = date("H:i:s");
        $this->mpdf = new mPDF('utf-8', array(215.9,330.2),$size); //folio
        $this->mpdf->AddPage($orientasi,'','',1,1,$lMargin,$rMargin,30,5);
        $this->mpdf->SetFooter("Printed on Simakda");
        if (!empty($judul)) $this->mpdf->writeHTML($judul);
        $this->mpdf->writeHTML($isi);      
        $this->mpdf->Output();
    }

    function  tanggal_format_indonesia($tgl){
        $tanggal  = explode('-',$tgl); 
        $bulan  = $this-> getBulan($tanggal[1]);
        $tahun  =  $tanggal[0];
        return  $tanggal[2].' '.$bulan.' '.$tahun;

    }

    function  getBulan($bln){
        switch  ($bln){
        case  1:
        return  "Januari";
        break;
        case  2:
        return  "Februari";
        break;
        case  3:
        return  "Maret";
        break;
        case  4:
        return  "April";
        break;
        case  5:
        return  "Mei";
        break;
        case  6:
        return  "Juni";
        break;
        case  7:
        return  "Juli";
        break;
        case  8:
        return  "Agustus";
        break;
        case  9:
        return  "September";
        break;
        case  10:
        return  "Oktober";
        break;
        case  11:
        return  "November";
        break;
        case  12:
        return  "Desember";
        break;
        }
    }

    function pilih_ttd_penguji() {
        $lccr = $this->input->post('q');
        $kd_skpd  = $this->session->userdata('kdskpd');
        $sql = "SELECT nip,nama,jabatan FROM ms_ttd where kd_skpd='$kd_skpd' and (upper(nama) like upper('%$lccr%') or upper(nip) like upper('%$lccr%')) order by nama";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'nip' => $resulte['nip'],  
                        'nama' => $resulte['nama'],  
                        'jabatan' => $resulte['jabatan']
                        );
                        $ii++;
        }
           
        echo json_encode($result);
        $query1->free_result();       
    }

    function pilih_ttd_kabid() {
        $lccr = $this->input->post('q');
        $kd_skpd  = $this->session->userdata('kdskpd');
        $sql = "SELECT nip,nama,jabatan FROM ms_ttd where kd_skpd='$kd_skpd' and (upper(nama) like upper('%$lccr%') or upper(nip) like upper('%$lccr%')) order by nama";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'nip' => $resulte['nip'],  
                        'nama' => $resulte['nama'],  
                        'jabatan' => $resulte['jabatan']
                        );
                        $ii++;
        }
           
        echo json_encode($result);
        $query1->free_result();       
    }
    
    function bud_verifikasi_up()
    {
        $data['page_title']= 'VERIF UP';
        $this->template->set('title', 'VERIF UP');   
        $this->template->load('template','tukd/spp/verifikasi/v_spp_up',$data) ; 
    }

    function bud_verifikasi_gu()
    {
        $data['page_title']= 'VERIF GU';
        $this->template->set('title', 'VERIF GU');   
        $this->template->load('template','tukd/spp/verifikasi/v_spp_gu',$data) ; 
    }
	
    function bud_verifikasi_tu_desak()
    {
        $data['page_title']= 'VERIF TU MENDESAK';
        $this->template->set('title', 'VERIF TU MENDESAK');   
        $this->template->load('template','tukd/spp/verifikasi/v_spp_tu_desak',$data) ; 
    }

    function load_verif_spp_gu() {
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
        $offset = ($page-1)*$rows;
        $kriteria = '';
        $row = '';
        $where    = "";
        $kriteria = $this->input->post('cari');

        if ($kriteria <> '') {
            $where  = "AND (upper(c.no_spm) like upper('%$kriteria%')) ";
        } else {
            $where  = "";
        }
        
        $sql = "SELECT count(*) as tot from trhspm c inner join trhspp a on c.no_spp=a.no_spp WHERE a.jns_spp='2' $where ";
        $query1 = $this->db->query($sql);
        $total = $query1->row();
        
        $sql = "SELECT top $rows c.no_spm as no_spp,c.tgl_spm as tgl_spp,sum(b.nilai) as nilai from trhspm c inner join trhspp a on c.no_spp=a.no_spp 
                inner join trdspp b on a.no_spp=b.no_spp WHERE a.jns_spp='2' $where  
                and c.no_spm not in (SELECT top $offset c.no_spm from trhspm c inner join trhspp a on c.no_spp=a.no_spp 
                WHERE a.jns_spp='2' $where order by c.tgl_spm,c.no_spm)
                GROUP BY c.no_spm,c.tgl_spm order by c.tgl_spm,c.no_spm";
        
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
            
            $row[] = array(
                        'id' => $ii,        
                        'no_spp' => $resulte['no_spp'],
                        'tgl_spp' => $resulte['tgl_spp'],
                        'nilai' => number_format($resulte['nilai'],2,'.',',')
                        );
                        $ii++;
        }
        $result["total"] = $total->tot;
        $result["rows"] = $row; 
        echo json_encode($result);       
    }    

    function bud_verifikasi_tu_darurat()
    {
        $data['page_title']= 'VERIF TU DARURAT';
        $this->template->set('title', 'VERIF TU DARURAT');   
        $this->template->load('template','tukd/spp/verifikasi/v_spp_tu_darurat',$data) ; 
    }
    

    function bud_verifikasi_ls_gaji()
    {
        $data['page_title']= 'VERIF LS GAJI';
        $this->template->set('title', 'VERIF LS GAJI');   
        $this->template->load('template','tukd/spp/verifikasi/v_spp_ls_gaji',$data) ; 
    }
    

    function bud_verifikasi_ls_tpp()
    {
        $data['page_title']= 'VERIF LS TPP';
        $this->template->set('title', 'VERIF LS TPP');   
        $this->template->load('template','tukd/spp/verifikasi/v_spp_ls_tpp',$data) ; 
    }

    function bud_verifikasi_ls_barang_dibawah50()
    {
        $data['page_title']= 'VERIF LS BJ DIBAWAH50';
        $this->template->set('title', 'VERIF LS BJ DIBAWAH50');   
        $this->template->load('template','tukd/spp/verifikasi/v_spp_ls_barang_dibawah50',$data) ; 
    }    
    

    function bud_verifikasi_ls_barang_diatas50()
    {
        $data['page_title']= 'VERIF LS BJ DIATAS50';
        $this->template->set('title', 'VERIF LS BJ DIATAS50');   
        $this->template->load('template','tukd/spp/verifikasi/v_spp_ls_barang_diatas50',$data) ; 
    }
    

    function bud_verifikasi_ls_barang_kontruksi()
    {
        $data['page_title']= 'VERIF LS BJ KONTRUKSI';
        $this->template->set('title', 'VERIF LS BJ KONTRUKSI');   
        $this->template->load('template','tukd/spp/verifikasi/v_spp_ls_barang_kontruksi',$data) ; 
    }
    

    function bud_verifikasi_ls_barang_konsultasi()
    {
        $data['page_title']= 'VERIF LS BJ KONSULTASI';
        $this->template->set('title', 'VERIF LS BJ KONSULTASI');   
        $this->template->load('template','tukd/spp/verifikasi/v_spp_ls_barang_konsultasi',$data) ; 
    }
    

    function bud_verifikasi_ls_barang_honorarium()
    {
        $data['page_title']= 'VERIF LS BJ HONORARIUM';
        $this->template->set('title', 'VERIF LS BJ HONORARIUM');   
        $this->template->load('template','tukd/spp/verifikasi/v_spp_ls_barang_honorarium',$data) ; 
    }

    function bud_verifikasi_ls_pihak3_bansos()
    {
        $data['page_title']= 'VERIF LS PIHAK3 BANSOS';
        $this->template->set('title', 'VERIF LS PIHAK3 BANSOS');   
        $this->template->load('template','tukd/spp/verifikasi/v_spp_ls_pihak3_bansos',$data) ; 
    }
    

    function bud_verifikasi_ls_pihak3_hibah()
    {
        $data['page_title']= 'VERIF LS PIHAK3 HIBAH';
        $this->template->set('title', 'VERIF LS PIHAK3 HIBAH');   
        $this->template->load('template','tukd/spp/verifikasi/v_spp_ls_pihak3_hibah',$data) ; 
    }

    function bud_verifikasi_ls_pihak3_parpol()
    {
        $data['page_title']= 'VERIF LS PIHAK3 PARPOL';
        $this->template->set('title', 'VERIF LS PIHAK3 PARPOL');   
        $this->template->load('template','tukd/spp/verifikasi/v_spp_ls_pihak3_parpol',$data) ; 
    }

    function bud_verifikasi_ls_pihak3_subsidi()
    {
        $data['page_title']= 'VERIF LS PIHAK3 SUBSIDI';
        $this->template->set('title', 'VERIF LS PIHAK3 SUBSIDI');   
        $this->template->load('template','tukd/spp/verifikasi/v_spp_ls_pihak3_subsidi',$data) ; 
    }

    function bud_verifikasi_ls_pihak3_pajak()
    {
        $data['page_title']= 'VERIF LS PIHAK3';
        $this->template->set('title', 'VERIF LS PIHAK3');   
        $this->template->load('template','tukd/spp/verifikasi/v_spp_ls_pihak3_pajak',$data) ; 
    }   

    function load_verif_spp_ls_pihak_ketiga() {
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
        $offset = ($page-1)*$rows;
        $kriteria = '';
        $row = '';
        $where    = "";
        $kriteria = $this->input->post('cari');

        if ($kriteria <> '') {
            $where  = "AND (upper(c.no_spm) like upper('%$kriteria%')) ";
        } else {
            $where  = "";
        }
        
        $sql = "SELECT count(*) as tot from trhspm c inner join trhspp a on c.no_spp=a.no_spp WHERE a.jns_spp='8' $where";
        $query1 = $this->db->query($sql);
        $total = $query1->row();
        
        $sql = "SELECT top $rows c.no_spm as no_spp,c.tgl_spm as tgl_spp,sum(b.nilai) as nilai from trhspm c inner join trhspp a on c.no_spp=a.no_spp 
                inner join trdspp b on a.no_spp=b.no_spp WHERE a.jns_spp='8' $where
                and c.no_spm not in (SELECT top $offset c.no_spm from trhspm c inner join trhspp a on c.no_spp=a.no_spp 
                WHERE a.jns_spp='8' $where order by c.tgl_spm,c.no_spm)  
                GROUP BY c.no_spm,c.tgl_spm order by c.tgl_spm,c.no_spm";
        
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
            
            $row[] = array(
                        'id' => $ii,        
                        'no_spp' => $resulte['no_spp'],
                        'tgl_spp' => $resulte['tgl_spp'],
                        'nilai' => number_format($resulte['nilai'],2,'.',',')
                        );
                        $ii++;
        }
        $result["total"] = $total->tot;
        $result["rows"] = $row; 
        echo json_encode($result);       
    }

    function load_verif_spp_ls_barang_jasa() {
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
        $offset = ($page-1)*$rows;
        $kriteria = '';
        $row = '';
        $where    = "";
        $kriteria = $this->input->post('cari');

        if ($kriteria <> '') {
            $where  = "AND (upper(c.no_spm) like upper('%$kriteria%')) ";
        } else {
            $where  = "";
        }
        
        $sql = "SELECT count(*) as tot from trhspm c inner join trhspp a on c.no_spp=a.no_spp WHERE a.jns_spp='6' $where";
        $query1 = $this->db->query($sql);
        $total = $query1->row();
        
        $sql = "SELECT top $rows c.no_spm as no_spp,c.tgl_spm as tgl_spp,sum(b.nilai) as nilai from trhspm c inner join trhspp a on c.no_spp=a.no_spp 
                inner join trdspp b on a.no_spp=b.no_spp WHERE a.jns_spp='6' $where  
                and c.no_spm not in (SELECT top $offset c.no_spm from trhspm c inner join trhspp a on c.no_spp=a.no_spp 
                WHERE a.jns_spp='6' $where order by c.tgl_spm,c.no_spm)
                GROUP BY c.no_spm,c.tgl_spm order by c.tgl_spm,c.no_spm";
        
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
            
            $row[] = array(
                        'id' => $ii,        
                        'no_spp' => $resulte['no_spp'],
                        'tgl_spp' => $resulte['tgl_spp'],
                        'nilai' => number_format($resulte['nilai'],2,'.',',')
                        );
                        $ii++;
        }
        $result["total"] = $total->tot;
        $result["rows"] = $row; 
        echo json_encode($result);       
    }



    function load_verif_spp_ls_gaji() {
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
        $offset = ($page-1)*$rows;
        $kriteria = '';
        $row = '';
        $where    = "";
        $kriteria = $this->input->post('cari');

        if ($kriteria <> '') {
            $where  = "AND (upper(c.no_spm) like upper('%$kriteria%')) ";
        } else {
            $where  = "";
        }
        
        $sql = "SELECT count(*) as tot from trhspm c inner join trhspp a on c.no_spp=a.no_spp WHERE a.jns_spp='4' $where";
        $query1 = $this->db->query($sql);
        $total = $query1->row();

        $sql = "SELECT top $rows c.no_spm as no_spp,c.tgl_spm as tgl_spp,sum(b.nilai) as nilai from trhspm c inner join trhspp a on c.no_spp=a.no_spp 
                inner join trdspp b on a.no_spp=b.no_spp WHERE a.jns_spp='4' $where
                and c.no_spm not in (SELECT top $offset c.no_spm from trhspm c inner join trhspp a on c.no_spp=a.no_spp 
                WHERE a.jns_spp='4' $where order by c.tgl_spm,c.no_spm)  
                GROUP BY c.no_spm,c.tgl_spm order by c.tgl_spm,c.no_spm";
        
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
            
            $row[] = array(
                        'id' => $ii,        
                        'no_spp' => $resulte['no_spp'],
                        'tgl_spp' => $resulte['tgl_spp'],
                        'nilai' => number_format($resulte['nilai'],2,'.',',')
                        );
                        $ii++;
        }
        $result["total"] = $total->tot;
        $result["rows"] = $row; 
        echo json_encode($result);       
    }

    function load_verif_spp() {
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
        $offset = ($page-1)*$rows;
        $kriteria = '';
        $row = '';
        $where    = "";
        $kriteria = $this->input->post('cari');

        if ($kriteria <> '') {
            $where  = "AND (upper(c.no_spm) like upper('%$kriteria%')) ";
        } else {
            $where  = "";
        }
        
        $sql = "SELECT count(*) as tot from trhspm c inner join trhspp a on c.no_spp=a.no_spp WHERE a.jns_spp='1' $where ";
        $query1 = $this->db->query($sql);
        $total = $query1->row();
        
        $sql = "SELECT top $rows c.no_spm as no_spp,c.tgl_spm as tgl_spp,sum(b.nilai) as nilai from trhspm c inner join trhspp a on c.no_spp=a.no_spp 
                inner join trdspp b on a.no_spp=b.no_spp WHERE a.jns_spp='1' $where  
                and c.no_spm not in (SELECT top $offset c.no_spm from trhspm c inner join trhspp a on c.no_spp=a.no_spp 
                WHERE a.jns_spp='1' $where order by c.tgl_spm,c.no_spm)
                GROUP BY c.no_spm,c.tgl_spm order by c.tgl_spm,c.no_spm";
        
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
            
            $row[] = array(
                        'id' => $ii,        
                        'no_spp' => $resulte['no_spp'],
                        'tgl_spp' => $resulte['tgl_spp'],
                        'nilai' => number_format($resulte['nilai'],2,'.',',')
                        );
                        $ii++;
        }
        $result["total"] = $total->tot;
        $result["rows"] = $row; 
        echo json_encode($result);       
    }

    function load_verif_spp_tu_desak() {
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
        $offset = ($page-1)*$rows;
        $kriteria = '';
        $row = '';
        $where    = "";
        $kriteria = $this->input->post('cari');

        if ($kriteria <> '') {
            $where  = "AND (upper(c.no_spm) like upper('%$kriteria%')) ";
        } else {
            $where  = "";
        }
        
        $sql = "SELECT count(*) as tot from trhspm c inner join trhspp a on c.no_spp=a.no_spp WHERE a.jns_spp='3' $where";
        $query1 = $this->db->query($sql);
        $total = $query1->row();
        
        $sql = "SELECT top $rows c.no_spm as no_spp,c.tgl_spm as tgl_spp,sum(b.nilai) as nilai from trhspm c inner join trhspp a on c.no_spp=a.no_spp 
                inner join trdspp b on a.no_spp=b.no_spp WHERE a.jns_spp='3' $where 
                 and c.no_spm not in (SELECT top $offset c.no_spm from trhspm c inner join trhspp a on c.no_spp=a.no_spp 
                WHERE a.jns_spp='3' $where order by c.tgl_spm,c.no_spm) 
                GROUP BY c.no_spm,c.tgl_spm order by c.tgl_spm,c.no_spm";
        
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
            
            $row[] = array(
                        'id' => $ii,        
                        'no_spp' => $resulte['no_spp'],
                        'tgl_spp' => $resulte['tgl_spp'],
                        'nilai' => number_format($resulte['nilai'],2,'.',',')
                        );
                        $ii++;
        }
        $result["total"] = $total->tot;
        $result["rows"] = $row; 
        echo json_encode($result);       
    }

    function cetak_sppup(){
        $lcnospp = str_replace('123456789','/',$_REQUEST['no']); 
        $tgl_ttd = $_REQUEST['ctglttd'];
        $ttd = $_REQUEST['ttd'];
        $ttd1 = $_REQUEST['ttd1'];
        $cat1 = str_replace('123456789',' ',$_REQUEST['catatan1']); 
        $cat2 = str_replace('123456789',' ',$_REQUEST['catatan2']); 
        $cat3 = str_replace('123456789',' ',$_REQUEST['catatan3']);
        
        $dspm1 = $_REQUEST['dspm1'];        
        $dspm2 = $_REQUEST['dspm2'];
        $dspm3 = $_REQUEST['dspm3'];
        $dspm4 = $_REQUEST['dspm4'];
        $dspm5 = $_REQUEST['dspm5'];
        $dspm6 = $_REQUEST['dspm6'];        
        $dspm7 = $_REQUEST['dspm7'];
        $dspm8 = $_REQUEST['dspm8'];
        $dspm9 = $_REQUEST['dspm9'];
        $dspm10 = $_REQUEST['dspm10'];
        $dspm11 = $_REQUEST['dspm11'];        
        $dspm12 = $_REQUEST['dspm12'];
        $dspm13 = $_REQUEST['dspm13'];
        $dspm14 = $_REQUEST['dspm14'];

        if($dspm1=='true'){$dspm1="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm1="<input type=\"checkbox\">";}
        if($dspm2=='true'){$dspm2="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm2="<input type=\"checkbox\">";}
        if($dspm3=='true'){$dspm3="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm3="<input type=\"checkbox\">";}
        if($dspm4=='true'){$dspm4="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm4="<input type=\"checkbox\">";}
        if($dspm5=='true'){$dspm5="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm5="<input type=\"checkbox\">";}
        if($dspm6=='true'){$dspm6="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm6="<input type=\"checkbox\">";}
        if($dspm7=='true'){$dspm7="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm7="<input type=\"checkbox\">";}
        if($dspm8=='true'){$dspm8="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm8="<input type=\"checkbox\">";}
        if($dspm9=='true'){$dspm9="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm9="<input type=\"checkbox\">";}
        if($dspm10=='true'){$dspm10="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm10="<input type=\"checkbox\">";}
        if($dspm11=='true'){$dspm11="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm11="<input type=\"checkbox\">";}
        if($dspm12=='true'){$dspm12="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm12="<input type=\"checkbox\">";}
        if($dspm13=='true'){$dspm13="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm13="<input type=\"checkbox\">";}
        if($dspm14=='true'){$dspm14="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm14="<input type=\"checkbox\">";}

        $cnip = str_replace('123456789',' ',$ttd); 
        $cnip1 = str_replace('123456789',' ',$ttd1);

        $sqlsc="SELECT distinct kab_kota,daerah,thn_ang FROM sclient";
             $sqlsclient=$this->db->query($sqlsc);
             foreach ($sqlsclient->result() as $rowsc)
            {
                $kab     = $rowsc->kab_kota;
                $daerah  = $rowsc->daerah;
            }    
       
        $csql = "SELECT c.no_spm,c.tgl_spm,sum(b.nilai) as nilai from trhspm c inner join trhspp a on c.no_spp=a.no_spp inner join trdspp b on a.no_spp=b.no_spp
                WHERE a.jns_spp='1' and c.no_spm='$lcnospp' GROUP BY c.no_spm,c.tgl_spm
                order by c.tgl_spm,c.no_spm";
        $hasil = $this->db->query($csql);
        $trh = $hasil->row();
        $ldtglspp   = $trh->tgl_spm;
        $lcnospp    = $trh->no_spm;
        $nilai      = $trh->nilai;
        $tanggal    = $this->tanggal_format_indonesia($ldtglspp);
        
        $cRet = "";
        $cRet  .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
                        <td width=\"100%\" colspan = \"2\"  align=\"center\" style=\"font-size:14px;\"><b>LEMBAR KONTROL VERIFIKASI <br> DOKUMEN KELENGKAPAN SPM-UP</b></td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"center\" style=\"font-size:12px;\">&nbsp;</td>
                        <td width=\"85%\" align=\"center\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"left\" style=\"font-size:12px;\">Nomor SPM </td>
                        <td width=\"85%\" align=\"left\" style=\"font-size:12px;\"> : $lcnospp </td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"left\" style=\"font-size:12px;\">Tanggal </td>
                        <td width=\"85%\" align=\"left\" style=\"font-size:12px;\"> : $tanggal</td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"left\" style=\"font-size:12px;\">Nilai </td>
                        <td width=\"85%\" align=\"left\" style=\"font-size:12px;\"> : Rp. ".number_format($nilai,'2','.',',')." </td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"center\" style=\"font-size:12px;\">&nbsp;</td>
                        <td width=\"85%\" align=\"center\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>
                </table>";

            $sql = "SELECT * from verif_penguji_spp_up";
            $hasil = $this->db->query($sql);
            foreach ($hasil->result() as $row){
                $judul          = $row->judul;
                $pernyataan     = $row->pernyataan;
                $ceklist1       = $row->ceklist1;
                $ceklist2       = $row->ceklist2;
                $ceklist3       = $row->ceklist3;
                $ceklist4       = $row->ceklist4;
                $ceklist5       = $row->ceklist5;
                $ceklist6       = $row->ceklist6;
                $ceklist7       = $row->ceklist7;
                
                $cRet  .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">Kelengkapan dokumen Pengajuan SP2D UP</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>  
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm1 &nbsp;$ceklist1</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm2 &nbsp;$ceklist2</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm3 &nbsp;$ceklist3</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm4 &nbsp;$ceklist4</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm5 &nbsp;$ceklist5</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm6 &nbsp;$ceklist6</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm7 &nbsp;$ceklist7</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$pernyataan :</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>
                </table>";
            }

            $csql="SELECT nip,nama,jabatan FROM ms_ttd WHERE nip = '$cnip'";
            $hasil = $this->db->query($csql);
            $trh2 = $hasil->row(); 
            $nip = $trh2->nip;
            $nama = $trh2->nama;
            $jabatan = $trh2->jabatan;

            $cRet  .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-bottom: none;\">$dspm8 Berkas memenuhi persyaratan</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-bottom: none;\">Diverifikasi/diteliti oleh Penguji Tagihan</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">$dspm9 Berkas tidak memenuhi persyaratan</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\">".$daerah.', '.$this->tanggal_format_indonesia($tgl_ttd)."</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">Catatan atas berkas : <br> $cat1</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"></td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"><b><u>$nama</u></b></td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"><b>NIP. $nip</b></td>
                    </tr>
                </table>";

        $dsql="SELECT nip,nama,jabatan FROM ms_ttd WHERE nip = '$cnip1'";
            $hasil = $this->db->query($dsql);
            $trh3 = $hasil->row(); 
            $nip1 = $trh3->nip;
            $nama1 = $trh3->nama;
            $jabatan1 = $trh3->jabatan;

        $cRet  .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-bottom: none;\">$dspm10 Berkas memenuhi persyaratan</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-bottom: none;\">Diverifikasi/diteliti kembali oleh Kasubid</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">$dspm11 Berkas tidak memenuhi persyaratan</td>
                        <td width=\"50%\" align=\"left\" style=\"font-size:12px;border-top: none;border-bottom: none;\">$dspm12 Penatausahaan dan Pengelolaan Kas</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"left\" style=\"font-size:12px;border-top: none;border-bottom: none;\"> $dspm13 Belanja Langsung <br> $dspm14 Belanja Tidak Langsung</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\">".$daerah.', '.$this->tanggal_format_indonesia($tgl_ttd)."</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">Catatan atas berkas : <br> $cat2</td>
                        <td width=\"50%\" align=\"left\" style=\"font-size:12px;border-top: none;border-bottom: none;\"></td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"><b><u>$nama1</u></b></td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"><b>NIP. $nip1</b></td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" colspan=\"2\" style=\"font-size:12px;\">&nbsp; <br> Keterangan : <br> $cat3 <br> &nbsp;</td>
                    </tr>
                </table>";
         
        $data['prev']= $cRet;
        //echo $cRet;

        $this->_mpdf('',$cRet,30,25,5,'0');
    }    
    
    function cetak_sppgu(){
        $lcnospp = str_replace('123456789','/',$_REQUEST['no']); 
        $tgl_ttd = $_REQUEST['ctglttd'];
        $ttd = $_REQUEST['ttd'];
        $ttd1 = $_REQUEST['ttd1'];
        $cat1 = str_replace('123456789',' ',$_REQUEST['catatan1']); 
        $cat2 = str_replace('123456789',' ',$_REQUEST['catatan2']); 
        $cat3 = str_replace('123456789',' ',$_REQUEST['catatan3']);
        
        $dspm1 = $_REQUEST['dspm1'];        
        $dspm2 = $_REQUEST['dspm2'];
        $dspm3 = $_REQUEST['dspm3'];
        $dspm4 = $_REQUEST['dspm4'];
        $dspm5 = $_REQUEST['dspm5'];
        $dspm6 = $_REQUEST['dspm6'];        
        $dspm7 = $_REQUEST['dspm7'];
        $dspm8 = $_REQUEST['dspm8'];
        $dspm9 = $_REQUEST['dspm9'];
        $dspm10 = $_REQUEST['dspm10'];
        $dspm11 = $_REQUEST['dspm11'];        
        $dspm12 = $_REQUEST['dspm12'];
        $dspm13 = $_REQUEST['dspm13'];

        if($dspm1=='true'){$dspm1="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm1="<input type=\"checkbox\">";}
        if($dspm2=='true'){$dspm2="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm2="<input type=\"checkbox\">";}
        if($dspm3=='true'){$dspm3="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm3="<input type=\"checkbox\">";}
        if($dspm4=='true'){$dspm4="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm4="<input type=\"checkbox\">";}
        if($dspm5=='true'){$dspm5="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm5="<input type=\"checkbox\">";}
        if($dspm6=='true'){$dspm6="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm6="<input type=\"checkbox\">";}
        if($dspm7=='true'){$dspm7="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm7="<input type=\"checkbox\">";}
        if($dspm8=='true'){$dspm8="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm8="<input type=\"checkbox\">";}
        if($dspm9=='true'){$dspm9="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm9="<input type=\"checkbox\">";}
        if($dspm10=='true'){$dspm10="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm10="<input type=\"checkbox\">";}
        if($dspm11=='true'){$dspm11="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm11="<input type=\"checkbox\">";}
        if($dspm12=='true'){$dspm12="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm12="<input type=\"checkbox\">";}
        if($dspm13=='true'){$dspm13="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm13="<input type=\"checkbox\">";}

        $cnip = str_replace('123456789',' ',$ttd); 
        $cnip1 = str_replace('123456789',' ',$ttd1);

        $sqlsc="SELECT distinct kab_kota,daerah,thn_ang FROM sclient";
             $sqlsclient=$this->db->query($sqlsc);
             foreach ($sqlsclient->result() as $rowsc)
            {
                $kab     = $rowsc->kab_kota;
                $daerah  = $rowsc->daerah;
            }    
       
        $csql = "SELECT c.no_spm,c.tgl_spm,sum(b.nilai) as nilai from trhspm c inner join trhspp a on c.no_spp=a.no_spp inner join trdspp b on a.no_spp=b.no_spp
                WHERE a.jns_spp='2' and c.no_spm='$lcnospp' GROUP BY c.no_spm,c.tgl_spm
                order by c.tgl_spm,c.no_spm";
        $hasil = $this->db->query($csql);
        $trh = $hasil->row();
        $ldtglspp   = $trh->tgl_spm;
        $lcnospp    = $trh->no_spm;
        $nilai      = $trh->nilai;
        $tanggal    = $this->tanggal_format_indonesia($ldtglspp);
        
        $cRet = "";
        $cRet  .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
                        <td width=\"100%\" colspan = \"2\" align=\"center\" style=\"font-size:14px;\"><b>LEMBAR KONTROL VERIFIKASI <br> DOKUMEN KELENGKAPAN SPM GU</b></td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"center\" style=\"font-size:12px;\">&nbsp;</td>
                        <td width=\"85%\" align=\"center\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"left\" style=\"font-size:12px;\">Nomor SPM </td>
                        <td width=\"85%\" align=\"left\" style=\"font-size:12px;\"> : $lcnospp </td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"left\" style=\"font-size:12px;\">Tanggal </td>
                        <td width=\"85%\" align=\"left\" style=\"font-size:12px;\"> : $tanggal</td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"left\" style=\"font-size:12px;\">Nilai </td>
                        <td width=\"85%\" align=\"left\" style=\"font-size:12px;\"> : Rp. ".number_format($nilai,'2','.',',')." </td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"center\" style=\"font-size:12px;\">&nbsp;</td>
                        <td width=\"85%\" align=\"center\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>
                </table>";

            $sql = "SELECT * from verif_penguji_spp_gu";
            $hasil = $this->db->query($sql);
            foreach ($hasil->result() as $row){
                $judul          = $row->judul;
                $pernyataan     = $row->pernyataan;
                $ceklist1       = $row->ceklist1;
                $ceklist2       = $row->ceklist2;
                $ceklist3       = $row->ceklist3;
                $ceklist4       = $row->ceklist4;
                $ceklist5       = $row->ceklist5;
                $ceklist6       = $row->ceklist6;
                
                $cRet  .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">Kelengkapan dokumen Pengajuan SP2D GU</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>  
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm1 $ceklist1</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm2 $ceklist2</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm3 $ceklist3</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm4 $ceklist4</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm5 $ceklist5</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm6 $ceklist6</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$pernyataan :</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>
                </table>";
            }

            $csql="SELECT nip,nama,jabatan FROM ms_ttd WHERE nip = '$cnip'";
            $hasil = $this->db->query($csql);
            $trh2 = $hasil->row(); 
            $nip = $trh2->nip;
            $nama = $trh2->nama;
            $jabatan = $trh2->jabatan;

            $cRet  .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-bottom: none;\">$dspm7 Berkas memenuhi persyaratan</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-bottom: none;\">Diverifikasi/diteliti oleh Penguji Tagihan</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">$dspm8 Berkas tidak memenuhi persyaratan</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\">".$daerah.', '.$this->tanggal_format_indonesia($tgl_ttd)."</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">Catatan atas berkas : <br> $cat1</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"></td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"><b><u>$nama</u></b></td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"><b>NIP. $nip</b></td>
                    </tr>
                </table>";

        $dsql="SELECT nip,nama,jabatan FROM ms_ttd WHERE nip = '$cnip1'";
            $hasil = $this->db->query($dsql);
            $trh3 = $hasil->row(); 
            $nip1 = $trh3->nip;
            $nama1 = $trh3->nama;
            $jabatan1 = $trh3->jabatan;

        $cRet  .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-bottom: none;\">$dspm9 Berkas memenuhi persyaratan</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-bottom: none;\">Diverifikasi/diteliti kembali oleh Kasubid</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">$dspm10 Berkas tidak memenuhi persyaratan</td>
                        <td width=\"50%\" align=\"left\" style=\"font-size:12px;border-top: none;border-bottom: none;\">$dspm11 Penatausahaan dan Pengelolaan Kas</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"left\" style=\"font-size:12px;border-top: none;border-bottom: none;\"> $dspm12 Belanja Langsung <br> $dspm13 Belanja Tidak Langsung</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\">".$daerah.', '.$this->tanggal_format_indonesia($tgl_ttd)."</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">Catatan atas berkas : <br> $cat2</td>
                        <td width=\"50%\" align=\"left\" style=\"font-size:12px;border-top: none;border-bottom: none;\"></td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"><b><u>$nama1</u></b></td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"><b>NIP. $nip1</b></td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" colspan=\"2\" style=\"font-size:12px;\">&nbsp; <br> Keterangan : <br> $cat3 <br> &nbsp;</td>
                    </tr>
                </table>";
         
        $data['prev']= $cRet;
        $this->_mpdf('',$cRet,30,25,5,'0');
    }

    function cetak_spptu_desak(){
        $lcnospp = str_replace('123456789','/',$_REQUEST['no']); 
        $tgl_ttd = $_REQUEST['ctglttd'];
        $ttd = $_REQUEST['ttd'];
        $ttd1 = $_REQUEST['ttd1'];
        $cat1 = str_replace('123456789',' ',$_REQUEST['catatan1']); 
        $cat2 = str_replace('123456789',' ',$_REQUEST['catatan2']); 
        $cat3 = str_replace('123456789',' ',$_REQUEST['catatan3']);
        
        $dspm1 = $_REQUEST['dspm1'];        
        $dspm2 = $_REQUEST['dspm2'];
        $dspm3 = $_REQUEST['dspm3'];
        $dspm4 = $_REQUEST['dspm4'];
        $dspm5 = $_REQUEST['dspm5'];
        $dspm6 = $_REQUEST['dspm6'];        
        $dspm7 = $_REQUEST['dspm7'];
        $dspm8 = $_REQUEST['dspm8'];
        $dspm9 = $_REQUEST['dspm9'];
        $dspm10 = $_REQUEST['dspm10'];
        $dspm11 = $_REQUEST['dspm11'];        
        $dspm12 = $_REQUEST['dspm12'];
        $dspm13 = $_REQUEST['dspm13'];
        $dspm14 = $_REQUEST['dspm14'];

        if($dspm1=='true'){$dspm1="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm1="<input type=\"checkbox\">";}
        if($dspm2=='true'){$dspm2="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm2="<input type=\"checkbox\">";}
        if($dspm3=='true'){$dspm3="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm3="<input type=\"checkbox\">";}
        if($dspm4=='true'){$dspm4="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm4="<input type=\"checkbox\">";}
        if($dspm5=='true'){$dspm5="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm5="<input type=\"checkbox\">";}
        if($dspm6=='true'){$dspm6="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm6="<input type=\"checkbox\">";}
        if($dspm7=='true'){$dspm7="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm7="<input type=\"checkbox\">";}
        if($dspm8=='true'){$dspm8="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm8="<input type=\"checkbox\">";}
        if($dspm9=='true'){$dspm9="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm9="<input type=\"checkbox\">";}
        if($dspm10=='true'){$dspm10="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm10="<input type=\"checkbox\">";}
        if($dspm11=='true'){$dspm11="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm11="<input type=\"checkbox\">";}
        if($dspm12=='true'){$dspm12="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm12="<input type=\"checkbox\">";}
        if($dspm13=='true'){$dspm13="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm13="<input type=\"checkbox\">";}
        if($dspm14=='true'){$dspm14="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm14="<input type=\"checkbox\">";}

        $cnip = str_replace('123456789',' ',$ttd); 
        $cnip1 = str_replace('123456789',' ',$ttd1);

        $sqlsc="SELECT distinct kab_kota,daerah,thn_ang FROM sclient";
             $sqlsclient=$this->db->query($sqlsc);
             foreach ($sqlsclient->result() as $rowsc)
            {
                $kab     = $rowsc->kab_kota;
                $daerah  = $rowsc->daerah;
            }    
       
        $csql = "SELECT c.no_spm,c.tgl_spm,sum(b.nilai) as nilai from trhspm c inner join trhspp a on c.no_spp=a.no_spp inner join trdspp b on a.no_spp=b.no_spp
                WHERE a.jns_spp='3' and c.no_spm='$lcnospp' GROUP BY c.no_spm,c.tgl_spm
                order by c.tgl_spm,c.no_spm";
        $hasil = $this->db->query($csql);
        $trh = $hasil->row();
        $ldtglspp   = $trh->tgl_spm;
        $lcnospp    = $trh->no_spm;
        $nilai      = $trh->nilai;
        $tanggal    = $this->tanggal_format_indonesia($ldtglspp);
        
        $cRet = "";
        $cRet  .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
                        <td width=\"100%\" colspan = \"2\" align=\"center\" style=\"font-size:14px;\"><b>LEMBAR KONTROL VERIFIKASI <br> DOKUMEN KELENGKAPAN SPM TU</b></td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"center\" style=\"font-size:12px;\">&nbsp;</td>
                        <td width=\"85%\" align=\"center\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"left\" style=\"font-size:12px;\">Nomor SPM </td>
                        <td width=\"85%\" align=\"left\" style=\"font-size:12px;\"> : $lcnospp </td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"left\" style=\"font-size:12px;\">Tanggal </td>
                        <td width=\"85%\" align=\"left\" style=\"font-size:12px;\"> : $tanggal</td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"left\" style=\"font-size:12px;\">Nilai </td>
                        <td width=\"85%\" align=\"left\" style=\"font-size:12px;\"> : Rp. ".number_format($nilai,'2','.',',')." </td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"center\" style=\"font-size:12px;\">&nbsp;</td>
                        <td width=\"85%\" align=\"center\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>
                </table>";

            $sql = "SELECT * from verif_penguji_spp_tu_desak";
            $hasil = $this->db->query($sql);
            foreach ($hasil->result() as $row){
                $judul          = $row->judul;
                $pernyataan     = $row->pernyataan;
                $ceklist1       = $row->ceklist1;
                $ceklist2       = $row->ceklist2;
                $ceklist3       = $row->ceklist3;
                $ceklist4       = $row->ceklist4;
                $ceklist5       = $row->ceklist5;
                $ceklist6       = $row->ceklist6;
                $ceklist7       = $row->ceklist7;
                
                $cRet  .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">Kelengkapan dokumen Pengajuan SP2D TU yang bersifat mendesak dan tidak dapat menggunakan mekanisme LS atau SPP UP/GU</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>  
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm1 $ceklist1</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm2 $ceklist2</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm3 $ceklist3</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm4 $ceklist4</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm5 $ceklist5</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm6 $ceklist6</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm7 $ceklist7</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$pernyataan :</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>
                </table>";
            }

            $csql="SELECT nip,nama,jabatan FROM ms_ttd WHERE nip = '$cnip'";
            $hasil = $this->db->query($csql);
            $trh2 = $hasil->row(); 
            $nip = $trh2->nip;
            $nama = $trh2->nama;
            $jabatan = $trh2->jabatan;

            $cRet  .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-bottom: none;\">$dspm8 Berkas memenuhi persyaratan</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-bottom: none;\">Diverifikasi/diteliti oleh Penguji Tagihan</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">$dspm9 Berkas tidak memenuhi persyaratan</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\">".$daerah.', '.$this->tanggal_format_indonesia($tgl_ttd)."</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">Catatan atas berkas : <br> $cat1</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"></td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"><b><u>$nama</u></b></td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"><b>NIP. $nip</b></td>
                    </tr>
                </table>";

        $dsql="SELECT nip,nama,jabatan FROM ms_ttd WHERE nip = '$cnip1'";
            $hasil = $this->db->query($dsql);
            $trh3 = $hasil->row(); 
            $nip1 = $trh3->nip;
            $nama1 = $trh3->nama;
            $jabatan1 = $trh3->jabatan;

        $cRet  .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-bottom: none;\">$dspm10 Berkas memenuhi persyaratan</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-bottom: none;\">Diverifikasi/diteliti kembali oleh Kasubid</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">$dspm11 Berkas tidak memenuhi persyaratan</td>
                        <td width=\"50%\" align=\"left\" style=\"font-size:12px;border-top: none;border-bottom: none;\">$dspm12 Penatausahaan dan Pengelolaan Kas</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"left\" style=\"font-size:12px;border-top: none;border-bottom: none;\"> $dspm13 Belanja Langsung <br> $dspm14 Belanja Tidak Langsung</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\">".$daerah.', '.$this->tanggal_format_indonesia($tgl_ttd)."</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">Catatan atas berkas : <br> $cat2</td>
                        <td width=\"50%\" align=\"left\" style=\"font-size:12px;border-top: none;border-bottom: none;\"></td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"><b><u>$nama1</u></b></td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"><b>NIP. $nip1</b></td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" colspan=\"2\" style=\"font-size:12px;\">&nbsp; <br> Keterangan : <br> $cat3 <br> &nbsp;</td>
                    </tr>
                </table>";
         
        $data['prev']= $cRet;
        $this->_mpdf('',$cRet,30,25,5,'0');
    }

    function cetak_spptu_darurat(){
        $lcnospp = str_replace('123456789','/',$_REQUEST['no']); 
        $tgl_ttd = $_REQUEST['ctglttd'];
        $ttd = $_REQUEST['ttd'];
        $ttd1 = $_REQUEST['ttd1'];
        $cat1 = str_replace('123456789',' ',$_REQUEST['catatan1']); 
        $cat2 = str_replace('123456789',' ',$_REQUEST['catatan2']); 
        $cat3 = str_replace('123456789',' ',$_REQUEST['catatan3']);
        
        $dspm1 = $_REQUEST['dspm1'];        
        $dspm2 = $_REQUEST['dspm2'];
        $dspm3 = $_REQUEST['dspm3'];
        $dspm4 = $_REQUEST['dspm4'];
        $dspm5 = $_REQUEST['dspm5'];
        $dspm6 = $_REQUEST['dspm6'];        
        $dspm7 = $_REQUEST['dspm7'];
        $dspm8 = $_REQUEST['dspm8'];
        $dspm9 = $_REQUEST['dspm9'];
        $dspm10 = $_REQUEST['dspm10'];
        $dspm11 = $_REQUEST['dspm11'];        
        $dspm12 = $_REQUEST['dspm12'];
        $dspm13 = $_REQUEST['dspm13'];
        $dspm14 = $_REQUEST['dspm14'];
        $dspm15 = $_REQUEST['dspm15'];

        if($dspm1=='true'){$dspm1="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm1="<input type=\"checkbox\">";}
        if($dspm2=='true'){$dspm2="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm2="<input type=\"checkbox\">";}
        if($dspm3=='true'){$dspm3="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm3="<input type=\"checkbox\">";}
        if($dspm4=='true'){$dspm4="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm4="<input type=\"checkbox\">";}
        if($dspm5=='true'){$dspm5="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm5="<input type=\"checkbox\">";}
        if($dspm6=='true'){$dspm6="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm6="<input type=\"checkbox\">";}
        if($dspm7=='true'){$dspm7="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm7="<input type=\"checkbox\">";}
        if($dspm8=='true'){$dspm8="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm8="<input type=\"checkbox\">";}
        if($dspm9=='true'){$dspm9="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm9="<input type=\"checkbox\">";}
        if($dspm10=='true'){$dspm10="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm10="<input type=\"checkbox\">";}
        if($dspm11=='true'){$dspm11="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm11="<input type=\"checkbox\">";}
        if($dspm12=='true'){$dspm12="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm12="<input type=\"checkbox\">";}
        if($dspm13=='true'){$dspm13="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm13="<input type=\"checkbox\">";}
        if($dspm14=='true'){$dspm14="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm14="<input type=\"checkbox\">";}
        if($dspm15=='true'){$dspm15="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm15="<input type=\"checkbox\">";}

        $cnip = str_replace('123456789',' ',$ttd); 
        $cnip1 = str_replace('123456789',' ',$ttd1);

        $sqlsc="SELECT distinct kab_kota,daerah,thn_ang FROM sclient";
             $sqlsclient=$this->db->query($sqlsc);
             foreach ($sqlsclient->result() as $rowsc)
            {
                $kab     = $rowsc->kab_kota;
                $daerah  = $rowsc->daerah;
            }    
       
        $csql = "SELECT c.no_spm,c.tgl_spm,sum(b.nilai) as nilai from trhspm c inner join trhspp a on c.no_spp=a.no_spp inner join trdspp b on a.no_spp=b.no_spp
                WHERE a.jns_spp='3' and c.no_spm='$lcnospp' GROUP BY c.no_spm,c.tgl_spm
                order by c.tgl_spm,c.no_spm";
        $hasil = $this->db->query($csql);
        $trh = $hasil->row();
        $ldtglspp   = $trh->tgl_spm;
        $lcnospp    = $trh->no_spm;
        $nilai      = $trh->nilai;
        $tanggal    = $this->tanggal_format_indonesia($ldtglspp);
        
        $cRet = "";
        $cRet  .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
                        <td width=\"100%\" colspan = \"2\" align=\"center\" style=\"font-size:14px;\"><b>LEMBAR KONTROL VERIFIKASI <br> DOKUMEN KELENGKAPAN SPM TU</b></td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"center\" style=\"font-size:12px;\">&nbsp;</td>
                        <td width=\"85%\" align=\"center\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"left\" style=\"font-size:12px;\">Nomor SPM </td>
                        <td width=\"85%\" align=\"left\" style=\"font-size:12px;\"> : $lcnospp </td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"left\" style=\"font-size:12px;\">Tanggal </td>
                        <td width=\"85%\" align=\"left\" style=\"font-size:12px;\"> : $tanggal</td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"left\" style=\"font-size:12px;\">Nilai </td>
                        <td width=\"85%\" align=\"left\" style=\"font-size:12px;\"> : Rp. ".number_format($nilai,'2','.',',')." </td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"center\" style=\"font-size:12px;\">&nbsp;</td>
                        <td width=\"85%\" align=\"center\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>
                </table>";

            $sql = "SELECT * from verif_penguji_spp_tu_darurat";
            $hasil = $this->db->query($sql);
            foreach ($hasil->result() as $row){
                $judul          = $row->judul;
                $pernyataan     = $row->pernyataan;
                $ceklist1       = $row->ceklist1;
                $ceklist2       = $row->ceklist2;
                $ceklist3       = $row->ceklist3;
                $ceklist4       = $row->ceklist4;
                $ceklist5       = $row->ceklist5;
                $ceklist6       = $row->ceklist6;
                $ceklist7       = $row->ceklist7;
                $ceklist8       = $row->ceklist8;
                
                $cRet  .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">Kelengkapan dokumen Pengajuan SP2D TU yang bersifat mendesak dan tidak dapat menggunakan mekanisme LS atau SPP UP/GU</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>  
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm1 $ceklist1</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm2 $ceklist2</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm3 $ceklist3</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm4 $ceklist4</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm5 $ceklist5</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm6 $ceklist6</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm7 $ceklist7</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm8 $ceklist8</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$pernyataan :</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>
                </table>";
            }

            $csql="SELECT nip,nama,jabatan FROM ms_ttd WHERE nip = '$cnip'";
            $hasil = $this->db->query($csql);
            $trh2 = $hasil->row(); 
            $nip = $trh2->nip;
            $nama = $trh2->nama;
            $jabatan = $trh2->jabatan;

            $cRet  .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-bottom: none;\">$dspm9 Berkas memenuhi persyaratan</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-bottom: none;\">Diverifikasi/diteliti oleh Penguji Tagihan</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">$dspm10 Berkas tidak memenuhi persyaratan</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\">".$daerah.', '.$this->tanggal_format_indonesia($tgl_ttd)."</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">Catatan atas berkas : <br> $cat1</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"></td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"><b><u>$nama</u></b></td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"><b>NIP. $nip</b></td>
                    </tr>
                </table>";

        $dsql="SELECT nip,nama,jabatan FROM ms_ttd WHERE nip = '$cnip1'";
            $hasil = $this->db->query($dsql);
            $trh3 = $hasil->row(); 
            $nip1 = $trh3->nip;
            $nama1 = $trh3->nama;
            $jabatan1 = $trh3->jabatan;

        $cRet  .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-bottom: none;\">$dspm11 Berkas memenuhi persyaratan</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-bottom: none;\">Diverifikasi/diteliti kembali oleh Kasubid</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">$dspm12 Berkas tidak memenuhi persyaratan</td>
                        <td width=\"50%\" align=\"left\" style=\"font-size:12px;border-top: none;border-bottom: none;\">$dspm13 Penatausahaan dan Pengelolaan Kas</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"left\" style=\"font-size:12px;border-top: none;border-bottom: none;\"> $dspm14 Belanja Langsung <br> $dspm15 Belanja Tidak Langsung</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\">".$daerah.', '.$this->tanggal_format_indonesia($tgl_ttd)."</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">Catatan atas berkas : <br> $cat2</td>
                        <td width=\"50%\" align=\"left\" style=\"font-size:12px;border-top: none;border-bottom: none;\"></td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"><b><u>$nama1</u></b></td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"><b>NIP. $nip1</b></td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" colspan=\"2\" style=\"font-size:12px;\">&nbsp; <br> Keterangan : <br> $cat3 <br> &nbsp;</td>
                    </tr>
                </table>";
         
        $data['prev']= $cRet;
        $this->_mpdf('',$cRet,30,25,5,'0');
    }

    function cetak_sppls_gaji(){
        $lcnospp = str_replace('123456789','/',$_REQUEST['no']); 
        $tgl_ttd = $_REQUEST['ctglttd'];
        $ttd = $_REQUEST['ttd'];
        $ttd1 = $_REQUEST['ttd1'];
        $cat1 = str_replace('123456789',' ',$_REQUEST['catatan1']); 
        $cat2 = str_replace('123456789',' ',$_REQUEST['catatan2']); 
        $cat3 = str_replace('123456789',' ',$_REQUEST['catatan3']);
        
        $dspm1 = $_REQUEST['dspm1'];        
        $dspm2 = $_REQUEST['dspm2'];
        $dspm3 = $_REQUEST['dspm3'];
        $dspm4 = $_REQUEST['dspm4'];
        $dspm5 = $_REQUEST['dspm5'];
        $dspm6 = $_REQUEST['dspm6'];        
        $dspm7 = $_REQUEST['dspm7'];
        $dspm8 = $_REQUEST['dspm8'];
        $dspm9 = $_REQUEST['dspm9'];
        $dspm10 = $_REQUEST['dspm10'];
        $dspm11 = $_REQUEST['dspm11'];        
        $dspm12 = $_REQUEST['dspm12'];
        $dspm13 = $_REQUEST['dspm13'];
        $dspm14 = $_REQUEST['dspm14'];
        $dspm15 = $_REQUEST['dspm15'];
        $dspm16 = $_REQUEST['dspm16'];
        $dspm17 = $_REQUEST['dspm17'];
        $dspm18 = $_REQUEST['dspm18'];
        $dspm19 = $_REQUEST['dspm19'];

        if($dspm1=='true'){$dspm1="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm1="<input type=\"checkbox\">";}
        if($dspm2=='true'){$dspm2="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm2="<input type=\"checkbox\">";}
        if($dspm3=='true'){$dspm3="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm3="<input type=\"checkbox\">";}
        if($dspm4=='true'){$dspm4="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm4="<input type=\"checkbox\">";}
        if($dspm5=='true'){$dspm5="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm5="<input type=\"checkbox\">";}
        if($dspm6=='true'){$dspm6="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm6="<input type=\"checkbox\">";}
        if($dspm7=='true'){$dspm7="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm7="<input type=\"checkbox\">";}
        if($dspm8=='true'){$dspm8="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm8="<input type=\"checkbox\">";}
        if($dspm9=='true'){$dspm9="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm9="<input type=\"checkbox\">";}
        if($dspm10=='true'){$dspm10="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm10="<input type=\"checkbox\">";}
        if($dspm11=='true'){$dspm11="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm11="<input type=\"checkbox\">";}
        if($dspm12=='true'){$dspm12="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm12="<input type=\"checkbox\">";}
        if($dspm13=='true'){$dspm13="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm13="<input type=\"checkbox\">";}
        if($dspm14=='true'){$dspm14="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm14="<input type=\"checkbox\">";}
        if($dspm15=='true'){$dspm15="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm15="<input type=\"checkbox\">";}
        if($dspm16=='true'){$dspm16="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm16="<input type=\"checkbox\">";}
        if($dspm17=='true'){$dspm17="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm17="<input type=\"checkbox\">";}
        if($dspm18=='true'){$dspm18="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm18="<input type=\"checkbox\">";}
        if($dspm19=='true'){$dspm19="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm19="<input type=\"checkbox\">";}

        $cnip = str_replace('123456789',' ',$ttd); 
        $cnip1 = str_replace('123456789',' ',$ttd1);

        $sqlsc="SELECT distinct kab_kota,daerah,thn_ang FROM sclient";
             $sqlsclient=$this->db->query($sqlsc);
             foreach ($sqlsclient->result() as $rowsc)
            {
                $kab     = $rowsc->kab_kota;
                $daerah  = $rowsc->daerah;
            }    
       
        $csql = "SELECT c.no_spm,c.tgl_spm,sum(b.nilai) as nilai from trhspm c inner join trhspp a on c.no_spp=a.no_spp inner join trdspp b on a.no_spp=b.no_spp
                WHERE a.jns_spp='4' and c.no_spm='$lcnospp' GROUP BY c.no_spm,c.tgl_spm
                order by c.tgl_spm,c.no_spm";
        $hasil = $this->db->query($csql);
        $trh = $hasil->row();
        $ldtglspp   = $trh->tgl_spm;
        $lcnospp    = $trh->no_spm;
        $nilai      = $trh->nilai;
        $tanggal    = $this->tanggal_format_indonesia($ldtglspp);
        
        $cRet = "";
        $cRet  .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
                        <td width=\"100%\" colspan = \"2\" align=\"center\" style=\"font-size:14px;\"><b>LEMBAR KONTROL VERIFIKASI <br> DOKUMEN KELENGKAPAN SPM LS Gaji dan Tunjangan</b></td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"center\" style=\"font-size:12px;\">&nbsp;</td>
                        <td width=\"85%\" align=\"center\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"left\" style=\"font-size:12px;\">Nomor SPM </td>
                        <td width=\"85%\" align=\"left\" style=\"font-size:12px;\"> : $lcnospp </td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"left\" style=\"font-size:12px;\">Tanggal </td>
                        <td width=\"85%\" align=\"left\" style=\"font-size:12px;\"> : $tanggal</td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"left\" style=\"font-size:12px;\">Nilai </td>
                        <td width=\"85%\" align=\"left\" style=\"font-size:12px;\"> : Rp. ".number_format($nilai,'2','.',',')." </td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"center\" style=\"font-size:12px;\">&nbsp;</td>
                        <td width=\"85%\" align=\"center\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>
                </table>";

            $sql = "SELECT * from verif_penguji_spp_ls_gaji";
            $hasil = $this->db->query($sql);
            foreach ($hasil->result() as $row){
                $judul          = $row->judul;
                $pernyataan     = $row->pernyataan;
                $ceklist1       = $row->ceklist1;
                $ceklist2       = $row->ceklist2;
                $ceklist3       = $row->ceklist3;
                $ceklist4       = $row->ceklist4;
                $ceklist5       = $row->ceklist5;
                $ceklist6       = $row->ceklist6;
                $ceklist7       = $row->ceklist7;
                $ceklist8       = $row->ceklist8;
                $ceklist9       = $row->ceklist9;
                $ceklist10      = $row->ceklist10;
                $ceklist11      = $row->ceklist11;
                $ceklist12      = $row->ceklist12;
                
                $cRet  .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">Kelengkapan dokumen Pengajuan SP2D LS Gaji induk/terusan/susulan, dan sejenisnya</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>  
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm1 $ceklist1</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm2 $ceklist2</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm3 $ceklist3</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm4 $ceklist4</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm5 $ceklist5</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm6 $ceklist6</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm7 $ceklist7</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm8 $ceklist8</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm9 $ceklist9</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm10 $ceklist10</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm11 $ceklist11</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm12 $ceklist12</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$pernyataan :</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>
                </table>";
            }

            $csql="SELECT nip,nama,jabatan FROM ms_ttd WHERE nip = '$cnip'";
            $hasil = $this->db->query($csql);
            $trh2 = $hasil->row(); 
            $nip = $trh2->nip;
            $nama = $trh2->nama;
            $jabatan = $trh2->jabatan;

            $cRet  .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-bottom: none;\">$dspm13 Berkas memenuhi persyaratan</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-bottom: none;\">Diverifikasi/diteliti oleh Penguji Tagihan</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">$dspm14 Berkas tidak memenuhi persyaratan</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\">".$daerah.', '.$this->tanggal_format_indonesia($tgl_ttd)."</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">Catatan atas berkas : <br> $cat1</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"></td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"><b><u>$nama</u></b></td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"><b>NIP. $nip</b></td>
                    </tr>
                </table>";

        $dsql="SELECT nip,nama,jabatan FROM ms_ttd WHERE nip = '$cnip1'";
            $hasil = $this->db->query($dsql);
            $trh3 = $hasil->row(); 
            $nip1 = $trh3->nip;
            $nama1 = $trh3->nama;
            $jabatan1 = $trh3->jabatan;

        $cRet  .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-bottom: none;\">$dspm15 Berkas memenuhi persyaratan</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-bottom: none;\">Diverifikasi/diteliti kembali oleh Kasubid</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">$dspm16 Berkas tidak memenuhi persyaratan</td>
                        <td width=\"50%\" align=\"left\" style=\"font-size:12px;border-top: none;border-bottom: none;\">$dspm17 Penatausahaan dan Pengelolaan Kas</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"left\" style=\"font-size:12px;border-top: none;border-bottom: none;\"> $dspm18 Belanja Langsung <br> $dspm19 Belanja Tidak Langsung</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\">".$daerah.', '.$this->tanggal_format_indonesia($tgl_ttd)."</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">Catatan atas berkas : <br> $cat2</td>
                        <td width=\"50%\" align=\"left\" style=\"font-size:12px;border-top: none;border-bottom: none;\"></td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"><b><u>$nama1</u></b></td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"><b>NIP. $nip1</b></td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" colspan=\"2\" style=\"font-size:12px;\">&nbsp; <br> Keterangan : <br> $cat3 <br> &nbsp;</td>
                    </tr>
                </table>";
         
        $data['prev']= $cRet;
        $this->_mpdf('',$cRet,30,25,5,'0');
    }

    function cetak_sppls_tpp(){
        $lcnospp = str_replace('123456789','/',$_REQUEST['no']); 
        $tgl_ttd = $_REQUEST['ctglttd'];
        $ttd = $_REQUEST['ttd'];
        $ttd1 = $_REQUEST['ttd1'];
        $cat1 = str_replace('123456789',' ',$_REQUEST['catatan1']); 
        $cat2 = str_replace('123456789',' ',$_REQUEST['catatan2']); 
        $cat3 = str_replace('123456789',' ',$_REQUEST['catatan3']);
        
        $dspm1 = $_REQUEST['dspm1'];        
        $dspm2 = $_REQUEST['dspm2'];
        $dspm3 = $_REQUEST['dspm3'];
        $dspm4 = $_REQUEST['dspm4'];
        $dspm5 = $_REQUEST['dspm5'];
        $dspm6 = $_REQUEST['dspm6'];        
        $dspm7 = $_REQUEST['dspm7'];
        $dspm8 = $_REQUEST['dspm8'];
        $dspm9 = $_REQUEST['dspm9'];
        $dspm10 = $_REQUEST['dspm10'];
        $dspm11 = $_REQUEST['dspm11'];        
        $dspm12 = $_REQUEST['dspm12'];
        $dspm13 = $_REQUEST['dspm13'];
        $dspm14 = $_REQUEST['dspm14'];
        $dspm15 = $_REQUEST['dspm15'];
        $dspm16 = $_REQUEST['dspm16'];
        $dspm17 = $_REQUEST['dspm17'];

        if($dspm1=='true'){$dspm1="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm1="<input type=\"checkbox\">";}
        if($dspm2=='true'){$dspm2="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm2="<input type=\"checkbox\">";}
        if($dspm3=='true'){$dspm3="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm3="<input type=\"checkbox\">";}
        if($dspm4=='true'){$dspm4="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm4="<input type=\"checkbox\">";}
        if($dspm5=='true'){$dspm5="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm5="<input type=\"checkbox\">";}
        if($dspm6=='true'){$dspm6="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm6="<input type=\"checkbox\">";}
        if($dspm7=='true'){$dspm7="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm7="<input type=\"checkbox\">";}
        if($dspm8=='true'){$dspm8="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm8="<input type=\"checkbox\">";}
        if($dspm9=='true'){$dspm9="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm9="<input type=\"checkbox\">";}
        if($dspm10=='true'){$dspm10="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm10="<input type=\"checkbox\">";}
        if($dspm11=='true'){$dspm11="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm11="<input type=\"checkbox\">";}
        if($dspm12=='true'){$dspm12="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm12="<input type=\"checkbox\">";}
        if($dspm13=='true'){$dspm13="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm13="<input type=\"checkbox\">";}
        if($dspm14=='true'){$dspm14="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm14="<input type=\"checkbox\">";}
        if($dspm15=='true'){$dspm15="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm15="<input type=\"checkbox\">";}
        if($dspm16=='true'){$dspm16="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm16="<input type=\"checkbox\">";}
        if($dspm17=='true'){$dspm17="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm17="<input type=\"checkbox\">";}

        $cnip = str_replace('123456789',' ',$ttd); 
        $cnip1 = str_replace('123456789',' ',$ttd1);

        $sqlsc="SELECT distinct kab_kota,daerah,thn_ang FROM sclient";
             $sqlsclient=$this->db->query($sqlsc);
             foreach ($sqlsclient->result() as $rowsc)
            {
                $kab     = $rowsc->kab_kota;
                $daerah  = $rowsc->daerah;
            }    
       
        $csql = "SELECT c.no_spm,c.tgl_spm,sum(b.nilai) as nilai from trhspm c inner join trhspp a on c.no_spp=a.no_spp inner join trdspp b on a.no_spp=b.no_spp
                WHERE a.jns_spp='4' and c.no_spm='$lcnospp' GROUP BY c.no_spm,c.tgl_spm
                order by c.tgl_spm,c.no_spm";
        $hasil = $this->db->query($csql);
        $trh = $hasil->row();
        $ldtglspp   = $trh->tgl_spm;
        $lcnospp    = $trh->no_spm;
        $nilai      = $trh->nilai;
        $tanggal    = $this->tanggal_format_indonesia($ldtglspp);
        
        $cRet = "";
        $cRet  .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
                        <td width=\"100%\" colspan = \"2\" align=\"center\" style=\"font-size:14px;\"><b>LEMBAR KONTROL VERIFIKASI <br> DOKUMEN KELENGKAPAN SPM LS Gaji dan Tunjangan</b></td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"center\" style=\"font-size:12px;\">&nbsp;</td>
                        <td width=\"85%\" align=\"center\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"left\" style=\"font-size:12px;\">Nomor SPM </td>
                        <td width=\"85%\" align=\"left\" style=\"font-size:12px;\"> : $lcnospp </td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"left\" style=\"font-size:12px;\">Tanggal </td>
                        <td width=\"85%\" align=\"left\" style=\"font-size:12px;\"> : $tanggal</td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"left\" style=\"font-size:12px;\">Nilai </td>
                        <td width=\"85%\" align=\"left\" style=\"font-size:12px;\"> : Rp. ".number_format($nilai,'2','.',',')." </td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"center\" style=\"font-size:12px;\">&nbsp;</td>
                        <td width=\"85%\" align=\"center\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>
                </table>";

            $sql = "SELECT * from verif_penguji_spp_ls_tpp";
            $hasil = $this->db->query($sql);
            foreach ($hasil->result() as $row){
                $judul          = $row->judul;
                $pernyataan     = $row->pernyataan;
                $ceklist1       = $row->ceklist1;
                $ceklist2       = $row->ceklist2;
                $ceklist3       = $row->ceklist3;
                $ceklist4       = $row->ceklist4;
                $ceklist5       = $row->ceklist5;
                $ceklist6       = $row->ceklist6;
                $ceklist7       = $row->ceklist7;
                $ceklist8       = $row->ceklist8;
                $ceklist9       = $row->ceklist9;
                $ceklist10      = $row->ceklist10;
                
                $cRet  .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">Kelengkapan dokumen Pengajuan SP2D TPP PNS/Insentif PNS/lainnya, disesuaikan peruntukannya</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>  
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm1 $ceklist1</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm2 $ceklist2</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm3 $ceklist3</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm4 $ceklist4</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm5 $ceklist5</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm6 $ceklist6</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm7 $ceklist7</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm8 $ceklist8</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm9 $ceklist9</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm10 $ceklist10</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$pernyataan :</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>
                </table>";
            }

            $csql="SELECT nip,nama,jabatan FROM ms_ttd WHERE nip = '$cnip'";
            $hasil = $this->db->query($csql);
            $trh2 = $hasil->row(); 
            $nip = $trh2->nip;
            $nama = $trh2->nama;
            $jabatan = $trh2->jabatan;

            $cRet  .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-bottom: none;\">$dspm11 Berkas memenuhi persyaratan</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-bottom: none;\">Diverifikasi/diteliti oleh Penguji Tagihan</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">$dspm12 Berkas tidak memenuhi persyaratan</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\">".$daerah.', '.$this->tanggal_format_indonesia($tgl_ttd)."</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">Catatan atas berkas : <br> $cat1</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"></td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"><b><u>$nama</u></b></td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"><b>NIP. $nip</b></td>
                    </tr>
                </table>";

        $dsql="SELECT nip,nama,jabatan FROM ms_ttd WHERE nip = '$cnip1'";
            $hasil = $this->db->query($dsql);
            $trh3 = $hasil->row(); 
            $nip1 = $trh3->nip;
            $nama1 = $trh3->nama;
            $jabatan1 = $trh3->jabatan;

        $cRet  .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-bottom: none;\">$dspm13 Berkas memenuhi persyaratan</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-bottom: none;\">Diverifikasi/diteliti kembali oleh Kasubid</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">$dspm14 Berkas tidak memenuhi persyaratan</td>
                        <td width=\"50%\" align=\"left\" style=\"font-size:12px;border-top: none;border-bottom: none;\">$dspm15 Penatausahaan dan Pengelolaan Kas</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"left\" style=\"font-size:12px;border-top: none;border-bottom: none;\"> $dspm16 Belanja Langsung <br> $dspm17 Belanja Tidak Langsung</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\">".$daerah.', '.$this->tanggal_format_indonesia($tgl_ttd)."</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">Catatan atas berkas : <br> $cat2</td>
                        <td width=\"50%\" align=\"left\" style=\"font-size:12px;border-top: none;border-bottom: none;\"></td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"><b><u>$nama1</u></b></td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"><b>NIP. $nip1</b></td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" colspan=\"2\" style=\"font-size:12px;\">&nbsp; <br> Keterangan : <br> $cat3 <br> &nbsp;</td>
                    </tr>
                </table>";
         
        $data['prev']= $cRet;
        $this->_mpdf('',$cRet,30,25,5,'0');
    }

    function cetak_sppls_barang_jasa_dibawah50(){
        $lcnospp = str_replace('123456789','/',$_REQUEST['no']); 
        $tgl_ttd = $_REQUEST['ctglttd'];
        $ttd = $_REQUEST['ttd'];
        $ttd1 = $_REQUEST['ttd1'];
        $cat1 = str_replace('123456789',' ',$_REQUEST['catatan1']); 
        $cat2 = str_replace('123456789',' ',$_REQUEST['catatan2']); 
        $cat3 = str_replace('123456789',' ',$_REQUEST['catatan3']);
        
        $dspm1 = $_REQUEST['dspm1'];        
        $dspm2 = $_REQUEST['dspm2'];
        $dspm3 = $_REQUEST['dspm3'];
        $dspm4 = $_REQUEST['dspm4'];
        $dspm5 = $_REQUEST['dspm5'];
        $dspm6 = $_REQUEST['dspm6'];        
        $dspm7 = $_REQUEST['dspm7'];
        $dspm8 = $_REQUEST['dspm8'];
        $dspm9 = $_REQUEST['dspm9'];
        $dspm10 = $_REQUEST['dspm10'];
        $dspm11 = $_REQUEST['dspm11'];        
        $dspm12 = $_REQUEST['dspm12'];
        $dspm13 = $_REQUEST['dspm13'];
        $dspm14 = $_REQUEST['dspm14'];
        $dspm15 = $_REQUEST['dspm15'];
        $dspm16 = $_REQUEST['dspm16'];
        $dspm17 = $_REQUEST['dspm17'];

        if($dspm1=='true'){$dspm1="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm1="<input type=\"checkbox\">";}
        if($dspm2=='true'){$dspm2="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm2="<input type=\"checkbox\">";}
        if($dspm3=='true'){$dspm3="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm3="<input type=\"checkbox\">";}
        if($dspm4=='true'){$dspm4="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm4="<input type=\"checkbox\">";}
        if($dspm5=='true'){$dspm5="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm5="<input type=\"checkbox\">";}
        if($dspm6=='true'){$dspm6="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm6="<input type=\"checkbox\">";}
        if($dspm7=='true'){$dspm7="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm7="<input type=\"checkbox\">";}
        if($dspm8=='true'){$dspm8="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm8="<input type=\"checkbox\">";}
        if($dspm9=='true'){$dspm9="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm9="<input type=\"checkbox\">";}
        if($dspm10=='true'){$dspm10="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm10="<input type=\"checkbox\">";}
        if($dspm11=='true'){$dspm11="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm11="<input type=\"checkbox\">";}
        if($dspm12=='true'){$dspm12="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm12="<input type=\"checkbox\">";}
        if($dspm13=='true'){$dspm13="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm13="<input type=\"checkbox\">";}
        if($dspm14=='true'){$dspm14="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm14="<input type=\"checkbox\">";}
        if($dspm15=='true'){$dspm15="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm15="<input type=\"checkbox\">";}
        if($dspm16=='true'){$dspm16="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm16="<input type=\"checkbox\">";}
        if($dspm17=='true'){$dspm17="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm17="<input type=\"checkbox\">";}

        $cnip = str_replace('123456789',' ',$ttd); 
        $cnip1 = str_replace('123456789',' ',$ttd1);

        $sqlsc="SELECT distinct kab_kota,daerah,thn_ang FROM sclient";
             $sqlsclient=$this->db->query($sqlsc);
             foreach ($sqlsclient->result() as $rowsc)
            {
                $kab     = $rowsc->kab_kota;
                $daerah  = $rowsc->daerah;
            }    
       
        $csql = "SELECT c.no_spm,c.tgl_spm,sum(b.nilai) as nilai from trhspm c inner join trhspp a on c.no_spp=a.no_spp inner join trdspp b on a.no_spp=b.no_spp
                WHERE a.jns_spp='6' and c.no_spm='$lcnospp' GROUP BY c.no_spm,c.tgl_spm
                order by c.tgl_spm,c.no_spm";
        $hasil = $this->db->query($csql);
        $trh = $hasil->row();
        $ldtglspp   = $trh->tgl_spm;
        $lcnospp    = $trh->no_spm;
        $nilai      = $trh->nilai;
        $tanggal    = $this->tanggal_format_indonesia($ldtglspp);
        
        $cRet = "";
        $cRet  .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
                        <td width=\"100%\" colspan = \"2\" align=\"center\" style=\"font-size:14px;\"><b>LEMBAR KONTROL VERIFIKASI <br> DOKUMEN KELENGKAPAN SPM LS Barang dan Jasa</b></td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"center\" style=\"font-size:12px;\">&nbsp;</td>
                        <td width=\"85%\" align=\"center\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"left\" style=\"font-size:12px;\">Nomor SPM </td>
                        <td width=\"85%\" align=\"left\" style=\"font-size:12px;\"> : $lcnospp </td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"left\" style=\"font-size:12px;\">Tanggal </td>
                        <td width=\"85%\" align=\"left\" style=\"font-size:12px;\"> : $tanggal</td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"left\" style=\"font-size:12px;\">Nilai </td>
                        <td width=\"85%\" align=\"left\" style=\"font-size:12px;\"> : Rp. ".number_format($nilai,'2','.',',')." </td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"center\" style=\"font-size:12px;\">&nbsp;</td>
                        <td width=\"85%\" align=\"center\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>
                </table>";

            $sql = "SELECT * from verif_penguji_spp_ls_barang_dibawah50";
            $hasil = $this->db->query($sql);
            foreach ($hasil->result() as $row){
                $judul          = $row->judul;
                $pernyataan     = $row->pernyataan;
                $ceklist1       = $row->ceklist1;
                $ceklist2       = $row->ceklist2;
                $ceklist3       = $row->ceklist3;
                $ceklist4       = $row->ceklist4;
                $ceklist5       = $row->ceklist5;
                $ceklist6       = $row->ceklist6;
                $ceklist7       = $row->ceklist7;
                $ceklist8       = $row->ceklist8;
                $ceklist9       = $row->ceklist9;
                $ceklist10      = $row->ceklist10;
                
                $cRet  .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">Kelengkapan dokumen Pengajuan SP2D LS Pengadaan Barang dan Jasa (0 sd 50 Juta)</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>  
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm1 $ceklist1</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm2 $ceklist2</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm3 $ceklist3</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm4 $ceklist4</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm5 $ceklist5</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm6 $ceklist6</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm7 $ceklist7</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm8 $ceklist8</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm9 $ceklist9</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm10 $ceklist10</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$pernyataan :</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>
                </table>";
            }

            $csql="SELECT nip,nama,jabatan FROM ms_ttd WHERE nip = '$cnip'";
            $hasil = $this->db->query($csql);
            $trh2 = $hasil->row(); 
            $nip = $trh2->nip;
            $nama = $trh2->nama;
            $jabatan = $trh2->jabatan;

            $cRet  .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-bottom: none;\">$dspm11 Berkas memenuhi persyaratan</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-bottom: none;\">Diverifikasi/diteliti oleh Penguji Tagihan</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">$dspm12 Berkas tidak memenuhi persyaratan</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\">".$daerah.', '.$this->tanggal_format_indonesia($tgl_ttd)."</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">Catatan atas berkas : <br> $cat1</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"></td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"><b><u>$nama</u></b></td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"><b>NIP. $nip</b></td>
                    </tr>
                </table>";

        $dsql="SELECT nip,nama,jabatan FROM ms_ttd WHERE nip = '$cnip1'";
            $hasil = $this->db->query($dsql);
            $trh3 = $hasil->row(); 
            $nip1 = $trh3->nip;
            $nama1 = $trh3->nama;
            $jabatan1 = $trh3->jabatan;

        $cRet  .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-bottom: none;\">$dspm13 Berkas memenuhi persyaratan</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-bottom: none;\">Diverifikasi/diteliti kembali oleh Kasubid</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">$dspm14 Berkas tidak memenuhi persyaratan</td>
                        <td width=\"50%\" align=\"left\" style=\"font-size:12px;border-top: none;border-bottom: none;\">$dspm15 Penatausahaan dan Pengelolaan Kas</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"left\" style=\"font-size:12px;border-top: none;border-bottom: none;\"> $dspm16 Belanja Langsung <br> $dspm17 Belanja Tidak Langsung</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\">".$daerah.', '.$this->tanggal_format_indonesia($tgl_ttd)."</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">Catatan atas berkas : <br> $cat2</td>
                        <td width=\"50%\" align=\"left\" style=\"font-size:12px;border-top: none;border-bottom: none;\"></td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"><b><u>$nama1</u></b></td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"><b>NIP. $nip1</b></td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" colspan=\"2\" style=\"font-size:12px;\">&nbsp; <br> Keterangan : <br> $cat3 <br> &nbsp;</td>
                    </tr>
                </table>";
         
        $data['prev']= $cRet;
        $this->_mpdf('',$cRet,30,25,5,'0');
    }

    function cetak_sppls_barang_jasa_diatas50(){
        $lcnospp = str_replace('123456789','/',$_REQUEST['no']); 
        $tgl_ttd = $_REQUEST['ctglttd'];
        $ttd = $_REQUEST['ttd'];
        $ttd1 = $_REQUEST['ttd1'];
        $cat1 = str_replace('123456789',' ',$_REQUEST['catatan1']); 
        $cat2 = str_replace('123456789',' ',$_REQUEST['catatan2']); 
        $cat3 = str_replace('123456789',' ',$_REQUEST['catatan3']);
        
        $dspm1 = $_REQUEST['dspm1'];        
        $dspm2 = $_REQUEST['dspm2'];
        $dspm3 = $_REQUEST['dspm3'];
        $dspm4 = $_REQUEST['dspm4'];
        $dspm5 = $_REQUEST['dspm5'];
        $dspm6 = $_REQUEST['dspm6'];        
        $dspm7 = $_REQUEST['dspm7'];
        $dspm8 = $_REQUEST['dspm8'];
        $dspm9 = $_REQUEST['dspm9'];
        $dspm10 = $_REQUEST['dspm10'];
        $dspm11 = $_REQUEST['dspm11'];        
        $dspm12 = $_REQUEST['dspm12'];
        $dspm13 = $_REQUEST['dspm13'];
        $dspm14 = $_REQUEST['dspm14'];
        $dspm15 = $_REQUEST['dspm15'];
        $dspm16 = $_REQUEST['dspm16'];
        $dspm17 = $_REQUEST['dspm17'];
        $dspm18 = $_REQUEST['dspm18'];
        $dspm19 = $_REQUEST['dspm19'];
        $dspm20 = $_REQUEST['dspm20'];

        if($dspm1=='true'){$dspm1="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm1="<input type=\"checkbox\">";}
        if($dspm2=='true'){$dspm2="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm2="<input type=\"checkbox\">";}
        if($dspm3=='true'){$dspm3="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm3="<input type=\"checkbox\">";}
        if($dspm4=='true'){$dspm4="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm4="<input type=\"checkbox\">";}
        if($dspm5=='true'){$dspm5="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm5="<input type=\"checkbox\">";}
        if($dspm6=='true'){$dspm6="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm6="<input type=\"checkbox\">";}
        if($dspm7=='true'){$dspm7="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm7="<input type=\"checkbox\">";}
        if($dspm8=='true'){$dspm8="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm8="<input type=\"checkbox\">";}
        if($dspm9=='true'){$dspm9="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm9="<input type=\"checkbox\">";}
        if($dspm10=='true'){$dspm10="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm10="<input type=\"checkbox\">";}
        if($dspm11=='true'){$dspm11="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm11="<input type=\"checkbox\">";}
        if($dspm12=='true'){$dspm12="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm12="<input type=\"checkbox\">";}
        if($dspm13=='true'){$dspm13="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm13="<input type=\"checkbox\">";}
        if($dspm14=='true'){$dspm14="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm14="<input type=\"checkbox\">";}
        if($dspm15=='true'){$dspm15="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm15="<input type=\"checkbox\">";}
        if($dspm16=='true'){$dspm16="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm16="<input type=\"checkbox\">";}
        if($dspm17=='true'){$dspm17="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm17="<input type=\"checkbox\">";}
        if($dspm18=='true'){$dspm18="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm18="<input type=\"checkbox\">";}
        if($dspm19=='true'){$dspm19="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm19="<input type=\"checkbox\">";}
        if($dspm20=='true'){$dspm20="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm20="<input type=\"checkbox\">";}

        $cnip = str_replace('123456789',' ',$ttd); 
        $cnip1 = str_replace('123456789',' ',$ttd1);

        $sqlsc="SELECT distinct kab_kota,daerah,thn_ang FROM sclient";
             $sqlsclient=$this->db->query($sqlsc);
             foreach ($sqlsclient->result() as $rowsc)
            {
                $kab     = $rowsc->kab_kota;
                $daerah  = $rowsc->daerah;
            }    
       
        $csql = "SELECT c.no_spm,c.tgl_spm,sum(b.nilai) as nilai from trhspm c inner join trhspp a on c.no_spp=a.no_spp inner join trdspp b on a.no_spp=b.no_spp
                WHERE a.jns_spp='6' and c.no_spm='$lcnospp' GROUP BY c.no_spm,c.tgl_spm
                order by c.tgl_spm,c.no_spm";
        $hasil = $this->db->query($csql);
        $trh = $hasil->row();
        $ldtglspp   = $trh->tgl_spm;
        $lcnospp    = $trh->no_spm;
        $nilai      = $trh->nilai;
        $tanggal    = $this->tanggal_format_indonesia($ldtglspp);
        
        $cRet = "";
        $cRet  .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
                        <td width=\"100%\" colspan = \"2\" align=\"center\" style=\"font-size:14px;\"><b>LEMBAR KONTROL VERIFIKASI <br> DOKUMEN KELENGKAPAN SPM LS Barang dan Jasa</b></td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"center\" style=\"font-size:12px;\">&nbsp;</td>
                        <td width=\"85%\" align=\"center\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"left\" style=\"font-size:12px;\">Nomor SPM </td>
                        <td width=\"85%\" align=\"left\" style=\"font-size:12px;\"> : $lcnospp </td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"left\" style=\"font-size:12px;\">Tanggal </td>
                        <td width=\"85%\" align=\"left\" style=\"font-size:12px;\"> : $tanggal</td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"left\" style=\"font-size:12px;\">Nilai </td>
                        <td width=\"85%\" align=\"left\" style=\"font-size:12px;\"> : Rp. ".number_format($nilai,'2','.',',')." </td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"center\" style=\"font-size:12px;\">&nbsp;</td>
                        <td width=\"85%\" align=\"center\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>
                </table>";

            $sql = "SELECT * from verif_penguji_spp_ls_barang_diatas50";
            $hasil = $this->db->query($sql);
            foreach ($hasil->result() as $row){
                $judul          = $row->judul;
                $pernyataan     = $row->pernyataan;
                $ceklist1       = $row->ceklist1;
                $ceklist2       = $row->ceklist2;
                $ceklist3       = $row->ceklist3;
                $ceklist4       = $row->ceklist4;
                $ceklist5       = $row->ceklist5;
                $ceklist6       = $row->ceklist6;
                $ceklist7       = $row->ceklist7;
                $ceklist8       = $row->ceklist8;
                $ceklist9       = $row->ceklist9;
                $ceklist10      = $row->ceklist10;
                $ceklist11      = $row->ceklist11;
                $ceklist12      = $row->ceklist12;
                $ceklist13      = $row->ceklist13;
                
                $cRet  .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">Kelengkapan dokumen Pengajuan SP2D LS Pengadaan Barang dan Jasa (diatas 50 Juta)</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>  
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm1 $ceklist1</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm2 $ceklist2</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm3 $ceklist3</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm4 $ceklist4</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm5 $ceklist5</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm6 $ceklist6</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm7 $ceklist7</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm8 $ceklist8</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm9 $ceklist9</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm10 $ceklist10</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm11 $ceklist11</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm12 $ceklist12</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm13 $ceklist13</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$pernyataan :</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>
                </table>";
            }

            $csql="SELECT nip,nama,jabatan FROM ms_ttd WHERE nip = '$cnip'";
            $hasil = $this->db->query($csql);
            $trh2 = $hasil->row(); 
            $nip = $trh2->nip;
            $nama = $trh2->nama;
            $jabatan = $trh2->jabatan;

            $cRet  .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-bottom: none;\">$dspm14 Berkas memenuhi persyaratan</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-bottom: none;\">Diverifikasi/diteliti oleh Penguji Tagihan</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">$dspm15 Berkas tidak memenuhi persyaratan</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\">".$daerah.', '.$this->tanggal_format_indonesia($tgl_ttd)."</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">Catatan atas berkas : <br> $cat1</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"></td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"><b><u>$nama</u></b></td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"><b>NIP. $nip</b></td>
                    </tr>
                </table>";

        $dsql="SELECT nip,nama,jabatan FROM ms_ttd WHERE nip = '$cnip1'";
            $hasil = $this->db->query($dsql);
            $trh3 = $hasil->row(); 
            $nip1 = $trh3->nip;
            $nama1 = $trh3->nama;
            $jabatan1 = $trh3->jabatan;

        $cRet  .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-bottom: none;\">$dspm16 Berkas memenuhi persyaratan</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-bottom: none;\">Diverifikasi/diteliti kembali oleh Kasubid</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">$dspm17 Berkas tidak memenuhi persyaratan</td>
                        <td width=\"50%\" align=\"left\" style=\"font-size:12px;border-top: none;border-bottom: none;\">$dspm18 Penatausahaan dan Pengelolaan Kas</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"left\" style=\"font-size:12px;border-top: none;border-bottom: none;\"> $dspm19 Belanja Langsung <br> $dspm20 Belanja Tidak Langsung</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\">".$daerah.', '.$this->tanggal_format_indonesia($tgl_ttd)."</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">Catatan atas berkas : <br> $cat2</td>
                        <td width=\"50%\" align=\"left\" style=\"font-size:12px;border-top: none;border-bottom: none;\"></td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"><b><u>$nama1</u></b></td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"><b>NIP. $nip1</b></td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" colspan=\"2\" style=\"font-size:12px;\">&nbsp; <br> Keterangan : <br> $cat3 <br> &nbsp;</td>
                    </tr>
                </table>";
         
        $data['prev']= $cRet;
        $this->_mpdf('',$cRet,30,25,5,'0');
    }

    function cetak_sppls_barang_jasa_kontruksi(){
        $lcnospp = str_replace('123456789','/',$_REQUEST['no']); 
        $tgl_ttd = $_REQUEST['ctglttd'];
        $ttd = $_REQUEST['ttd'];
        $ttd1 = $_REQUEST['ttd1'];
        $cat1 = str_replace('123456789',' ',$_REQUEST['catatan1']); 
        $cat2 = str_replace('123456789',' ',$_REQUEST['catatan2']); 
        $cat3 = str_replace('123456789',' ',$_REQUEST['catatan3']);
        
        $dspm1 = $_REQUEST['dspm1'];        
        $dspm2 = $_REQUEST['dspm2'];
        $dspm3 = $_REQUEST['dspm3'];
        $dspm4 = $_REQUEST['dspm4'];
        $dspm5 = $_REQUEST['dspm5'];
        $dspm6 = $_REQUEST['dspm6'];        
        $dspm7 = $_REQUEST['dspm7'];
        $dspm8 = $_REQUEST['dspm8'];
        $dspm9 = $_REQUEST['dspm9'];
        $dspm10 = $_REQUEST['dspm10'];
        $dspm11 = $_REQUEST['dspm11'];        
        $dspm12 = $_REQUEST['dspm12'];
        $dspm13 = $_REQUEST['dspm13'];
        $dspm14 = $_REQUEST['dspm14'];
        $dspm15 = $_REQUEST['dspm15'];
        $dspm16 = $_REQUEST['dspm16'];
        $dspm17 = $_REQUEST['dspm17'];
        $dspm18 = $_REQUEST['dspm18'];
        $dspm19 = $_REQUEST['dspm19'];
        $dspm20 = $_REQUEST['dspm20'];
        $dspm21 = $_REQUEST['dspm21'];

        if($dspm1=='true'){$dspm1="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm1="<input type=\"checkbox\">";}
        if($dspm2=='true'){$dspm2="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm2="<input type=\"checkbox\">";}
        if($dspm3=='true'){$dspm3="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm3="<input type=\"checkbox\">";}
        if($dspm4=='true'){$dspm4="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm4="<input type=\"checkbox\">";}
        if($dspm5=='true'){$dspm5="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm5="<input type=\"checkbox\">";}
        if($dspm6=='true'){$dspm6="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm6="<input type=\"checkbox\">";}
        if($dspm7=='true'){$dspm7="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm7="<input type=\"checkbox\">";}
        if($dspm8=='true'){$dspm8="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm8="<input type=\"checkbox\">";}
        if($dspm9=='true'){$dspm9="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm9="<input type=\"checkbox\">";}
        if($dspm10=='true'){$dspm10="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm10="<input type=\"checkbox\">";}
        if($dspm11=='true'){$dspm11="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm11="<input type=\"checkbox\">";}
        if($dspm12=='true'){$dspm12="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm12="<input type=\"checkbox\">";}
        if($dspm13=='true'){$dspm13="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm13="<input type=\"checkbox\">";}
        if($dspm14=='true'){$dspm14="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm14="<input type=\"checkbox\">";}
        if($dspm15=='true'){$dspm15="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm15="<input type=\"checkbox\">";}
        if($dspm16=='true'){$dspm16="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm16="<input type=\"checkbox\">";}
        if($dspm17=='true'){$dspm17="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm17="<input type=\"checkbox\">";}
        if($dspm18=='true'){$dspm18="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm18="<input type=\"checkbox\">";}
        if($dspm19=='true'){$dspm19="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm19="<input type=\"checkbox\">";}
        if($dspm20=='true'){$dspm20="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm20="<input type=\"checkbox\">";}
        if($dspm21=='true'){$dspm21="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm21="<input type=\"checkbox\">";}

        $cnip = str_replace('123456789',' ',$ttd); 
        $cnip1 = str_replace('123456789',' ',$ttd1);

        $sqlsc="SELECT distinct kab_kota,daerah,thn_ang FROM sclient";
             $sqlsclient=$this->db->query($sqlsc);
             foreach ($sqlsclient->result() as $rowsc)
            {
                $kab     = $rowsc->kab_kota;
                $daerah  = $rowsc->daerah;
            }    
       
        $csql = "SELECT c.no_spm,c.tgl_spm,sum(b.nilai) as nilai from trhspm c inner join trhspp a on c.no_spp=a.no_spp inner join trdspp b on a.no_spp=b.no_spp
                WHERE a.jns_spp='6' and c.no_spm='$lcnospp' GROUP BY c.no_spm,c.tgl_spm
                order by c.tgl_spm,c.no_spm";
        $hasil = $this->db->query($csql);
        $trh = $hasil->row();
        $ldtglspp   = $trh->tgl_spm;
        $lcnospp    = $trh->no_spm;
        $nilai      = $trh->nilai;
        $tanggal    = $this->tanggal_format_indonesia($ldtglspp);
        
        $cRet = "";
        $cRet  .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
                        <td width=\"100%\" colspan = \"2\" align=\"center\" style=\"font-size:14px;\"><b>LEMBAR KONTROL VERIFIKASI <br> DOKUMEN KELENGKAPAN SPM LS Barang dan Jasa</b></td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"center\" style=\"font-size:12px;\">&nbsp;</td>
                        <td width=\"85%\" align=\"center\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"left\" style=\"font-size:12px;\">Nomor SPM </td>
                        <td width=\"85%\" align=\"left\" style=\"font-size:12px;\"> : $lcnospp </td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"left\" style=\"font-size:12px;\">Tanggal </td>
                        <td width=\"85%\" align=\"left\" style=\"font-size:12px;\"> : $tanggal</td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"left\" style=\"font-size:12px;\">Nilai </td>
                        <td width=\"85%\" align=\"left\" style=\"font-size:12px;\"> : Rp. ".number_format($nilai,'2','.',',')." </td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"center\" style=\"font-size:12px;\">&nbsp;</td>
                        <td width=\"85%\" align=\"center\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>
                </table>";

            $sql = "SELECT * from verif_penguji_spp_ls_barang_kontruksi";
            $hasil = $this->db->query($sql);
            foreach ($hasil->result() as $row){
                $judul          = $row->judul;
                $pernyataan     = $row->pernyataan;
                $ceklist1       = $row->ceklist1;
                $ceklist2       = $row->ceklist2;
                $ceklist3       = $row->ceklist3;
                $ceklist4       = $row->ceklist4;
                $ceklist5       = $row->ceklist5;
                $ceklist6       = $row->ceklist6;
                $ceklist7       = $row->ceklist7;
                $ceklist8       = $row->ceklist8;
                $ceklist9       = $row->ceklist9;
                $ceklist10      = $row->ceklist10;
                $ceklist11      = $row->ceklist11;
                $ceklist12      = $row->ceklist12;
                $ceklist13      = $row->ceklist13;
                $ceklist14      = $row->ceklist14;
                
                $cRet  .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">Kelengkapan dokumen Pengajuan SP2D LS Kontruksi</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>  
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm1 $ceklist1</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm2 $ceklist2</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm3 $ceklist3</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm4 $ceklist4</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm5 $ceklist5</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm6 $ceklist6</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm7 $ceklist7</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm8 $ceklist8</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm9 $ceklist9</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm10 $ceklist10</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm11 $ceklist11</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm12 $ceklist12</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm13 $ceklist13</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm14 $ceklist14</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$pernyataan :</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>
                </table>";
            }

            $csql="SELECT nip,nama,jabatan FROM ms_ttd WHERE nip = '$cnip'";
            $hasil = $this->db->query($csql);
            $trh2 = $hasil->row(); 
            $nip = $trh2->nip;
            $nama = $trh2->nama;
            $jabatan = $trh2->jabatan;

            $cRet  .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-bottom: none;\">$dspm15 Berkas memenuhi persyaratan</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-bottom: none;\">Diverifikasi/diteliti oleh Penguji Tagihan</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">$dspm16 Berkas tidak memenuhi persyaratan</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\">".$daerah.', '.$this->tanggal_format_indonesia($tgl_ttd)."</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">Catatan atas berkas : <br> $cat1</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"></td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"><b><u>$nama</u></b></td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"><b>NIP. $nip</b></td>
                    </tr>
                </table>";

        $dsql="SELECT nip,nama,jabatan FROM ms_ttd WHERE nip = '$cnip1'";
            $hasil = $this->db->query($dsql);
            $trh3 = $hasil->row(); 
            $nip1 = $trh3->nip;
            $nama1 = $trh3->nama;
            $jabatan1 = $trh3->jabatan;

        $cRet  .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-bottom: none;\">$dspm17 Berkas memenuhi persyaratan</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-bottom: none;\">Diverifikasi/diteliti kembali oleh Kasubid</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">$dspm18 Berkas tidak memenuhi persyaratan</td>
                        <td width=\"50%\" align=\"left\" style=\"font-size:12px;border-top: none;border-bottom: none;\">$dspm19 Penatausahaan dan Pengelolaan Kas</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"left\" style=\"font-size:12px;border-top: none;border-bottom: none;\"> $dspm20 Belanja Langsung <br> $dspm21 Belanja Tidak Langsung</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\">".$daerah.', '.$this->tanggal_format_indonesia($tgl_ttd)."</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">Catatan atas berkas : <br> $cat2</td>
                        <td width=\"50%\" align=\"left\" style=\"font-size:12px;border-top: none;border-bottom: none;\"></td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"><b><u>$nama1</u></b></td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"><b>NIP. $nip1</b></td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" colspan=\"2\" style=\"font-size:12px;\">&nbsp; <br> Keterangan : <br> $cat3 <br> &nbsp;</td>
                    </tr>
                </table>";
         
        $data['prev']= $cRet;
        $this->_mpdf('',$cRet,30,25,5,'0');
    }

    function cetak_sppls_barang_jasa_konsultasi(){
        $lcnospp = str_replace('123456789','/',$_REQUEST['no']); 
        $tgl_ttd = $_REQUEST['ctglttd'];
        $ttd = $_REQUEST['ttd'];
        $ttd1 = $_REQUEST['ttd1'];
        $cat1 = str_replace('123456789',' ',$_REQUEST['catatan1']); 
        $cat2 = str_replace('123456789',' ',$_REQUEST['catatan2']); 
        $cat3 = str_replace('123456789',' ',$_REQUEST['catatan3']);
        
        $dspm1 = $_REQUEST['dspm1'];        
        $dspm2 = $_REQUEST['dspm2'];
        $dspm3 = $_REQUEST['dspm3'];
        $dspm4 = $_REQUEST['dspm4'];
        $dspm5 = $_REQUEST['dspm5'];
        $dspm6 = $_REQUEST['dspm6'];        
        $dspm7 = $_REQUEST['dspm7'];
        $dspm8 = $_REQUEST['dspm8'];
        $dspm9 = $_REQUEST['dspm9'];
        $dspm10 = $_REQUEST['dspm10'];
        $dspm11 = $_REQUEST['dspm11'];        
        $dspm12 = $_REQUEST['dspm12'];
        $dspm13 = $_REQUEST['dspm13'];
        $dspm14 = $_REQUEST['dspm14'];
        $dspm15 = $_REQUEST['dspm15'];
        $dspm16 = $_REQUEST['dspm16'];
        $dspm17 = $_REQUEST['dspm17'];
        $dspm18 = $_REQUEST['dspm18'];
        $dspm19 = $_REQUEST['dspm19'];

        if($dspm1=='true'){$dspm1="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm1="<input type=\"checkbox\">";}
        if($dspm2=='true'){$dspm2="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm2="<input type=\"checkbox\">";}
        if($dspm3=='true'){$dspm3="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm3="<input type=\"checkbox\">";}
        if($dspm4=='true'){$dspm4="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm4="<input type=\"checkbox\">";}
        if($dspm5=='true'){$dspm5="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm5="<input type=\"checkbox\">";}
        if($dspm6=='true'){$dspm6="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm6="<input type=\"checkbox\">";}
        if($dspm7=='true'){$dspm7="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm7="<input type=\"checkbox\">";}
        if($dspm8=='true'){$dspm8="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm8="<input type=\"checkbox\">";}
        if($dspm9=='true'){$dspm9="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm9="<input type=\"checkbox\">";}
        if($dspm10=='true'){$dspm10="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm10="<input type=\"checkbox\">";}
        if($dspm11=='true'){$dspm11="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm11="<input type=\"checkbox\">";}
        if($dspm12=='true'){$dspm12="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm12="<input type=\"checkbox\">";}
        if($dspm13=='true'){$dspm13="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm13="<input type=\"checkbox\">";}
        if($dspm14=='true'){$dspm14="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm14="<input type=\"checkbox\">";}
        if($dspm15=='true'){$dspm15="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm15="<input type=\"checkbox\">";}
        if($dspm16=='true'){$dspm16="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm16="<input type=\"checkbox\">";}
        if($dspm17=='true'){$dspm17="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm17="<input type=\"checkbox\">";}
        if($dspm18=='true'){$dspm18="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm18="<input type=\"checkbox\">";}
        if($dspm19=='true'){$dspm19="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm19="<input type=\"checkbox\">";}

        $cnip = str_replace('123456789',' ',$ttd); 
        $cnip1 = str_replace('123456789',' ',$ttd1);

        $sqlsc="SELECT distinct kab_kota,daerah,thn_ang FROM sclient";
             $sqlsclient=$this->db->query($sqlsc);
             foreach ($sqlsclient->result() as $rowsc)
            {
                $kab     = $rowsc->kab_kota;
                $daerah  = $rowsc->daerah;
            }    
       
        $csql = "SELECT c.no_spm,c.tgl_spm,sum(b.nilai) as nilai from trhspm c inner join trhspp a on c.no_spp=a.no_spp inner join trdspp b on a.no_spp=b.no_spp
                WHERE a.jns_spp='6' and c.no_spm='$lcnospp' GROUP BY c.no_spm,c.tgl_spm
                order by c.tgl_spm,c.no_spm";
        $hasil = $this->db->query($csql);
        $trh = $hasil->row();
        $ldtglspp   = $trh->tgl_spm;
        $lcnospp    = $trh->no_spm;
        $nilai      = $trh->nilai;
        $tanggal    = $this->tanggal_format_indonesia($ldtglspp);
        
        $cRet = "";
        $cRet  .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
                        <td width=\"100%\" colspan = \"2\" align=\"center\" style=\"font-size:14px;\"><b>LEMBAR KONTROL VERIFIKASI <br> DOKUMEN KELENGKAPAN SPM LS Barang dan Jasa</b></td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"center\" style=\"font-size:12px;\">&nbsp;</td>
                        <td width=\"85%\" align=\"center\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"left\" style=\"font-size:12px;\">Nomor SPM </td>
                        <td width=\"85%\" align=\"left\" style=\"font-size:12px;\"> : $lcnospp </td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"left\" style=\"font-size:12px;\">Tanggal </td>
                        <td width=\"85%\" align=\"left\" style=\"font-size:12px;\"> : $tanggal</td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"left\" style=\"font-size:12px;\">Nilai </td>
                        <td width=\"85%\" align=\"left\" style=\"font-size:12px;\"> : Rp. ".number_format($nilai,'2','.',',')." </td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"center\" style=\"font-size:12px;\">&nbsp;</td>
                        <td width=\"85%\" align=\"center\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>
                </table>";

            $sql = "SELECT * from verif_penguji_spp_ls_barang_konsultasi";
            $hasil = $this->db->query($sql);
            foreach ($hasil->result() as $row){
                $judul          = $row->judul;
                $pernyataan     = $row->pernyataan;
                $ceklist1       = $row->ceklist1;
                $ceklist2       = $row->ceklist2;
                $ceklist3       = $row->ceklist3;
                $ceklist4       = $row->ceklist4;
                $ceklist5       = $row->ceklist5;
                $ceklist6       = $row->ceklist6;
                $ceklist7       = $row->ceklist7;
                $ceklist8       = $row->ceklist8;
                $ceklist9       = $row->ceklist9;
                $ceklist10      = $row->ceklist10;
                $ceklist11      = $row->ceklist11;
                $ceklist12      = $row->ceklist12;
                
                $cRet  .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">Kelengkapan dokumen Pengajuan SP2D LS Jasa Konsultansi dan sejenisnya</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>  
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm1 $ceklist1</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm2 $ceklist2</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm3 $ceklist3</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm4 $ceklist4</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm5 $ceklist5</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm6 $ceklist6</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm7 $ceklist7</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm8 $ceklist8</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm9 $ceklist9</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm10 $ceklist10</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm11 $ceklist11</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm12 $ceklist12</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$pernyataan :</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>
                </table>";
            }

            $csql="SELECT nip,nama,jabatan FROM ms_ttd WHERE nip = '$cnip'";
            $hasil = $this->db->query($csql);
            $trh2 = $hasil->row(); 
            $nip = $trh2->nip;
            $nama = $trh2->nama;
            $jabatan = $trh2->jabatan;

            $cRet  .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-bottom: none;\">$dspm13 Berkas memenuhi persyaratan</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-bottom: none;\">Diverifikasi/diteliti oleh Penguji Tagihan</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">$dspm14 Berkas tidak memenuhi persyaratan</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\">".$daerah.', '.$this->tanggal_format_indonesia($tgl_ttd)."</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">Catatan atas berkas : <br> $cat1</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"></td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"><b><u>$nama</u></b></td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"><b>NIP. $nip</b></td>
                    </tr>
                </table>";

        $dsql="SELECT nip,nama,jabatan FROM ms_ttd WHERE nip = '$cnip1'";
            $hasil = $this->db->query($dsql);
            $trh3 = $hasil->row(); 
            $nip1 = $trh3->nip;
            $nama1 = $trh3->nama;
            $jabatan1 = $trh3->jabatan;

        $cRet  .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-bottom: none;\">$dspm15 Berkas memenuhi persyaratan</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-bottom: none;\">Diverifikasi/diteliti kembali oleh Kasubid</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">$dspm16 Berkas tidak memenuhi persyaratan</td>
                        <td width=\"50%\" align=\"left\" style=\"font-size:12px;border-top: none;border-bottom: none;\">$dspm17 Penatausahaan dan Pengelolaan Kas</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"left\" style=\"font-size:12px;border-top: none;border-bottom: none;\"> $dspm18 Belanja Langsung <br> $dspm19 Belanja Tidak Langsung</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\">".$daerah.', '.$this->tanggal_format_indonesia($tgl_ttd)."</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">Catatan atas berkas : <br> $cat2</td>
                        <td width=\"50%\" align=\"left\" style=\"font-size:12px;border-top: none;border-bottom: none;\"></td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"><b><u>$nama1</u></b></td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"><b>NIP. $nip1</b></td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" colspan=\"2\" style=\"font-size:12px;\">&nbsp; <br> Keterangan : <br> $cat3 <br> &nbsp;</td>
                    </tr>
                </table>";
         
        $data['prev']= $cRet;
        $this->_mpdf('',$cRet,30,25,5,'0');
    }

    function cetak_sppls_barang_jasa_honorarium(){
        $lcnospp = str_replace('123456789','/',$_REQUEST['no']); 
        $tgl_ttd = $_REQUEST['ctglttd'];
        $ttd = $_REQUEST['ttd'];
        $ttd1 = $_REQUEST['ttd1'];
        $cat1 = str_replace('123456789',' ',$_REQUEST['catatan1']); 
        $cat2 = str_replace('123456789',' ',$_REQUEST['catatan2']); 
        $cat3 = str_replace('123456789',' ',$_REQUEST['catatan3']);
        
        $dspm1 = $_REQUEST['dspm1'];        
        $dspm2 = $_REQUEST['dspm2'];
        $dspm3 = $_REQUEST['dspm3'];
        $dspm4 = $_REQUEST['dspm4'];
        $dspm5 = $_REQUEST['dspm5'];
        $dspm6 = $_REQUEST['dspm6'];        
        $dspm7 = $_REQUEST['dspm7'];
        $dspm8 = $_REQUEST['dspm8'];
        $dspm9 = $_REQUEST['dspm9'];
        $dspm10 = $_REQUEST['dspm10'];
        $dspm11 = $_REQUEST['dspm11'];        
        $dspm12 = $_REQUEST['dspm12'];
        $dspm13 = $_REQUEST['dspm13'];
        $dspm14 = $_REQUEST['dspm14'];
        $dspm15 = $_REQUEST['dspm15'];
        $dspm16 = $_REQUEST['dspm16'];
        $dspm17 = $_REQUEST['dspm17'];
        $dspm18 = $_REQUEST['dspm18'];

        if($dspm1=='true'){$dspm1="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm1="<input type=\"checkbox\">";}
        if($dspm2=='true'){$dspm2="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm2="<input type=\"checkbox\">";}
        if($dspm3=='true'){$dspm3="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm3="<input type=\"checkbox\">";}
        if($dspm4=='true'){$dspm4="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm4="<input type=\"checkbox\">";}
        if($dspm5=='true'){$dspm5="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm5="<input type=\"checkbox\">";}
        if($dspm6=='true'){$dspm6="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm6="<input type=\"checkbox\">";}
        if($dspm7=='true'){$dspm7="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm7="<input type=\"checkbox\">";}
        if($dspm8=='true'){$dspm8="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm8="<input type=\"checkbox\">";}
        if($dspm9=='true'){$dspm9="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm9="<input type=\"checkbox\">";}
        if($dspm10=='true'){$dspm10="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm10="<input type=\"checkbox\">";}
        if($dspm11=='true'){$dspm11="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm11="<input type=\"checkbox\">";}
        if($dspm12=='true'){$dspm12="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm12="<input type=\"checkbox\">";}
        if($dspm13=='true'){$dspm13="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm13="<input type=\"checkbox\">";}
        if($dspm14=='true'){$dspm14="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm14="<input type=\"checkbox\">";}
        if($dspm15=='true'){$dspm15="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm15="<input type=\"checkbox\">";}
        if($dspm16=='true'){$dspm16="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm16="<input type=\"checkbox\">";}
        if($dspm17=='true'){$dspm17="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm17="<input type=\"checkbox\">";}
        if($dspm18=='true'){$dspm18="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm18="<input type=\"checkbox\">";}

        $cnip = str_replace('123456789',' ',$ttd); 
        $cnip1 = str_replace('123456789',' ',$ttd1);

        $sqlsc="SELECT distinct kab_kota,daerah,thn_ang FROM sclient";
             $sqlsclient=$this->db->query($sqlsc);
             foreach ($sqlsclient->result() as $rowsc)
            {
                $kab     = $rowsc->kab_kota;
                $daerah  = $rowsc->daerah;
            }    
       
        $csql = "SELECT c.no_spm,c.tgl_spm,sum(b.nilai) as nilai from trhspm c inner join trhspp a on c.no_spp=a.no_spp inner join trdspp b on a.no_spp=b.no_spp
                WHERE a.jns_spp='6' and c.no_spm='$lcnospp' GROUP BY c.no_spm,c.tgl_spm
                order by c.tgl_spm,c.no_spm";
        $hasil = $this->db->query($csql);
        $trh = $hasil->row();
        $ldtglspp   = $trh->tgl_spm;
        $lcnospp    = $trh->no_spm;
        $nilai      = $trh->nilai;
        $tanggal    = $this->tanggal_format_indonesia($ldtglspp);
        
        $cRet = "";
        $cRet  .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
                        <td width=\"100%\" colspan = \"2\" align=\"center\" style=\"font-size:14px;\"><b>LEMBAR KONTROL VERIFIKASI <br> DOKUMEN KELENGKAPAN SPM LS Barang dan Jasa</b></td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"center\" style=\"font-size:12px;\">&nbsp;</td>
                        <td width=\"85%\" align=\"center\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"left\" style=\"font-size:12px;\">Nomor SPM </td>
                        <td width=\"85%\" align=\"left\" style=\"font-size:12px;\"> : $lcnospp </td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"left\" style=\"font-size:12px;\">Tanggal </td>
                        <td width=\"85%\" align=\"left\" style=\"font-size:12px;\"> : $tanggal</td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"left\" style=\"font-size:12px;\">Nilai </td>
                        <td width=\"85%\" align=\"left\" style=\"font-size:12px;\"> : Rp. ".number_format($nilai,'2','.',',')." </td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"center\" style=\"font-size:12px;\">&nbsp;</td>
                        <td width=\"85%\" align=\"center\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>
                </table>";

            $sql = "SELECT * from verif_penguji_spp_ls_barang_honorarium";
            $hasil = $this->db->query($sql);
            foreach ($hasil->result() as $row){
                $judul          = $row->judul;
                $pernyataan     = $row->pernyataan;
                $ceklist1       = $row->ceklist1;
                $ceklist2       = $row->ceklist2;
                $ceklist3       = $row->ceklist3;
                $ceklist4       = $row->ceklist4;
                $ceklist5       = $row->ceklist5;
                $ceklist6       = $row->ceklist6;
                $ceklist7       = $row->ceklist7;
                $ceklist8       = $row->ceklist8;
                $ceklist9       = $row->ceklist9;
                $ceklist10      = $row->ceklist10;
                $ceklist11      = $row->ceklist11;
                
                $cRet  .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">Kelengkapan dokumen Pengajuan SP2D LS honorarium, jasa, biaya pemeliharaan/ operasional dan/atau sejenisnya</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>  
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm1 $ceklist1</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm2 $ceklist2</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm3 $ceklist3</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm4 $ceklist4</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm5 $ceklist5</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm6 $ceklist6</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm7 $ceklist7</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm8 $ceklist8</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm9 $ceklist9</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm10 $ceklist10</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm11 $ceklist11</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$pernyataan :</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>
                </table>";
            }

            $csql="SELECT nip,nama,jabatan FROM ms_ttd WHERE nip = '$cnip'";
            $hasil = $this->db->query($csql);
            $trh2 = $hasil->row(); 
            $nip = $trh2->nip;
            $nama = $trh2->nama;
            $jabatan = $trh2->jabatan;

            $cRet  .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-bottom: none;\">$dspm12 Berkas memenuhi persyaratan</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-bottom: none;\">Diverifikasi/diteliti oleh Penguji Tagihan</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">$dspm13 Berkas tidak memenuhi persyaratan</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\">".$daerah.', '.$this->tanggal_format_indonesia($tgl_ttd)."</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">Catatan atas berkas : <br> $cat1</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"></td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"><b><u>$nama</u></b></td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"><b>NIP. $nip</b></td>
                    </tr>
                </table>";

        $dsql="SELECT nip,nama,jabatan FROM ms_ttd WHERE nip = '$cnip1'";
            $hasil = $this->db->query($dsql);
            $trh3 = $hasil->row(); 
            $nip1 = $trh3->nip;
            $nama1 = $trh3->nama;
            $jabatan1 = $trh3->jabatan;

        $cRet  .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-bottom: none;\">$dspm14 Berkas memenuhi persyaratan</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-bottom: none;\">Diverifikasi/diteliti kembali oleh Kasubid</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">$dspm15 Berkas tidak memenuhi persyaratan</td>
                        <td width=\"50%\" align=\"left\" style=\"font-size:12px;border-top: none;border-bottom: none;\">$dspm16 Penatausahaan dan Pengelolaan Kas</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"left\" style=\"font-size:12px;border-top: none;border-bottom: none;\"> $dspm17 Belanja Langsung <br> $dspm18 Belanja Tidak Langsung</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\">".$daerah.', '.$this->tanggal_format_indonesia($tgl_ttd)."</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">Catatan atas berkas : <br> $cat2</td>
                        <td width=\"50%\" align=\"left\" style=\"font-size:12px;border-top: none;border-bottom: none;\"></td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"><b><u>$nama1</u></b></td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"><b>NIP. $nip1</b></td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" colspan=\"2\" style=\"font-size:12px;\">&nbsp; <br> Keterangan : <br> $cat3 <br> &nbsp;</td>
                    </tr>
                </table>";
         
        $data['prev']= $cRet;
        $this->_mpdf('',$cRet,30,25,5,'0');
    }

    function cetak_sppls_pihak3_bansos(){
        $lcnospp = str_replace('123456789','/',$_REQUEST['no']); 
        $tgl_ttd = $_REQUEST['ctglttd'];
        $ttd = $_REQUEST['ttd'];
        $ttd1 = $_REQUEST['ttd1'];
        $cat1 = str_replace('123456789',' ',$_REQUEST['catatan1']); 
        $cat2 = str_replace('123456789',' ',$_REQUEST['catatan2']); 
        $cat3 = str_replace('123456789',' ',$_REQUEST['catatan3']);
        
        $dspm1 = $_REQUEST['dspm1'];        
        $dspm2 = $_REQUEST['dspm2'];
        $dspm3 = $_REQUEST['dspm3'];
        $dspm4 = $_REQUEST['dspm4'];
        $dspm5 = $_REQUEST['dspm5'];
        $dspm6 = $_REQUEST['dspm6'];        
        $dspm7 = $_REQUEST['dspm7'];
        $dspm8 = $_REQUEST['dspm8'];
        $dspm9 = $_REQUEST['dspm9'];
        $dspm10 = $_REQUEST['dspm10'];
        $dspm11 = $_REQUEST['dspm11'];        
        $dspm12 = $_REQUEST['dspm12'];
        $dspm13 = $_REQUEST['dspm13'];
        $dspm14 = $_REQUEST['dspm14'];

        if($dspm1=='true'){$dspm1="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm1="<input type=\"checkbox\">";}
        if($dspm2=='true'){$dspm2="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm2="<input type=\"checkbox\">";}
        if($dspm3=='true'){$dspm3="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm3="<input type=\"checkbox\">";}
        if($dspm4=='true'){$dspm4="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm4="<input type=\"checkbox\">";}
        if($dspm5=='true'){$dspm5="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm5="<input type=\"checkbox\">";}
        if($dspm6=='true'){$dspm6="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm6="<input type=\"checkbox\">";}
        if($dspm7=='true'){$dspm7="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm7="<input type=\"checkbox\">";}
        if($dspm8=='true'){$dspm8="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm8="<input type=\"checkbox\">";}
        if($dspm9=='true'){$dspm9="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm9="<input type=\"checkbox\">";}
        if($dspm10=='true'){$dspm10="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm10="<input type=\"checkbox\">";}
        if($dspm11=='true'){$dspm11="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm11="<input type=\"checkbox\">";}
        if($dspm12=='true'){$dspm12="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm12="<input type=\"checkbox\">";}
        if($dspm13=='true'){$dspm13="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm13="<input type=\"checkbox\">";}
        if($dspm14=='true'){$dspm14="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm14="<input type=\"checkbox\">";}

        $cnip = str_replace('123456789',' ',$ttd); 
        $cnip1 = str_replace('123456789',' ',$ttd1);

        $sqlsc="SELECT distinct kab_kota,daerah,thn_ang FROM sclient";
             $sqlsclient=$this->db->query($sqlsc);
             foreach ($sqlsclient->result() as $rowsc)
            {
                $kab     = $rowsc->kab_kota;
                $daerah  = $rowsc->daerah;
            }    
       
        $csql = "SELECT c.no_spm,c.tgl_spm,sum(b.nilai) as nilai from trhspm c inner join trhspp a on c.no_spp=a.no_spp inner join trdspp b on a.no_spp=b.no_spp
                WHERE a.jns_spp='8' and c.no_spm='$lcnospp' GROUP BY c.no_spm,c.tgl_spm
                order by c.tgl_spm,c.no_spm";
        $hasil = $this->db->query($csql);
        $trh = $hasil->row();
        $ldtglspp   = $trh->tgl_spm;
        $lcnospp    = $trh->no_spm;
        $nilai      = $trh->nilai;
        $tanggal    = $this->tanggal_format_indonesia($ldtglspp);
        
        $cRet = "";
        $cRet  .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
                        <td width=\"100%\" colspan = \"2\"  align=\"center\" style=\"font-size:14px;\"><b>LEMBAR KONTROL VERIFIKASI <br> DOKUMEN KELENGKAPAN SPM LS Pihak Ketiga Lainnya</b></td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"center\" style=\"font-size:12px;\">&nbsp;</td>
                        <td width=\"85%\" align=\"center\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"left\" style=\"font-size:12px;\">Nomor SPM </td>
                        <td width=\"85%\" align=\"left\" style=\"font-size:12px;\"> : $lcnospp </td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"left\" style=\"font-size:12px;\">Tanggal </td>
                        <td width=\"85%\" align=\"left\" style=\"font-size:12px;\"> : $tanggal</td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"left\" style=\"font-size:12px;\">Nilai </td>
                        <td width=\"85%\" align=\"left\" style=\"font-size:12px;\"> : Rp. ".number_format($nilai,'2','.',',')." </td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"center\" style=\"font-size:12px;\">&nbsp;</td>
                        <td width=\"85%\" align=\"center\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>
                </table>";

            $sql = "SELECT * from verif_penguji_spp_ls_pihak_ketiga_bansos";
            $hasil = $this->db->query($sql);
            foreach ($hasil->result() as $row){
                $judul          = $row->judul;
                $pernyataan     = $row->pernyataan;
                $ceklist1       = $row->ceklist1;
                $ceklist2       = $row->ceklist2;
                $ceklist3       = $row->ceklist3;
                $ceklist4       = $row->ceklist4;
                $ceklist5       = $row->ceklist5;
                $ceklist6       = $row->ceklist6;
                $ceklist7       = $row->ceklist7;
                
                $cRet  .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">Kelengkapan dokumen Pengajuan SP2D LS Belanja Bantuan Sosial berupa uang</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>  
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm1 $ceklist1</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm2 $ceklist2</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm3 $ceklist3</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm4 $ceklist4</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm5 $ceklist5</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm6 $ceklist6</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm7 $ceklist7</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$pernyataan :</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>
                </table>";
            }

            $csql="SELECT nip,nama,jabatan FROM ms_ttd WHERE nip = '$cnip'";
            $hasil = $this->db->query($csql);
            $trh2 = $hasil->row(); 
            $nip = $trh2->nip;
            $nama = $trh2->nama;
            $jabatan = $trh2->jabatan;

            $cRet  .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-bottom: none;\">$dspm8 Berkas memenuhi persyaratan</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-bottom: none;\">Diverifikasi/diteliti oleh Penguji Tagihan</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">$dspm9 Berkas tidak memenuhi persyaratan</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\">".$daerah.', '.$this->tanggal_format_indonesia($tgl_ttd)."</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">Catatan atas berkas : <br> $cat1</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"></td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"><b><u>$nama</u></b></td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"><b>NIP. $nip</b></td>
                    </tr>
                </table>";

        $dsql="SELECT nip,nama,jabatan FROM ms_ttd WHERE nip = '$cnip1'";
            $hasil = $this->db->query($dsql);
            $trh3 = $hasil->row(); 
            $nip1 = $trh3->nip;
            $nama1 = $trh3->nama;
            $jabatan1 = $trh3->jabatan;

        $cRet  .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-bottom: none;\">$dspm10 Berkas memenuhi persyaratan</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-bottom: none;\">Diverifikasi/diteliti kembali oleh Kasubid</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">$dspm11 Berkas tidak memenuhi persyaratan</td>
                        <td width=\"50%\" align=\"left\" style=\"font-size:12px;border-top: none;border-bottom: none;\">$dspm12 Penatausahaan dan Pengelolaan Kas</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"left\" style=\"font-size:12px;border-top: none;border-bottom: none;\"> $dspm13 Belanja Langsung <br> $dspm14 Belanja Tidak Langsung</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\">".$daerah.', '.$this->tanggal_format_indonesia($tgl_ttd)."</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">Catatan atas berkas : <br> $cat2</td>
                        <td width=\"50%\" align=\"left\" style=\"font-size:12px;border-top: none;border-bottom: none;\"></td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"><b><u>$nama1</u></b></td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"><b>NIP. $nip1</b></td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" colspan=\"2\" style=\"font-size:12px;\">&nbsp; <br> Keterangan : <br> $cat3 <br> &nbsp;</td>
                    </tr>
                </table>";
         
        $data['prev']= $cRet;
        $this->_mpdf('',$cRet,30,25,5,'0');
    }

    function cetak_sppls_pihak3_hibah(){
        $lcnospp = str_replace('123456789','/',$_REQUEST['no']); 
        $tgl_ttd = $_REQUEST['ctglttd'];
        $ttd = $_REQUEST['ttd'];
        $ttd1 = $_REQUEST['ttd1'];
        $cat1 = str_replace('123456789',' ',$_REQUEST['catatan1']); 
        $cat2 = str_replace('123456789',' ',$_REQUEST['catatan2']); 
        $cat3 = str_replace('123456789',' ',$_REQUEST['catatan3']);
        
        $dspm1 = $_REQUEST['dspm1'];        
        $dspm2 = $_REQUEST['dspm2'];
        $dspm3 = $_REQUEST['dspm3'];
        $dspm4 = $_REQUEST['dspm4'];
        $dspm5 = $_REQUEST['dspm5'];
        $dspm6 = $_REQUEST['dspm6'];        
        $dspm7 = $_REQUEST['dspm7'];
        $dspm8 = $_REQUEST['dspm8'];
        $dspm9 = $_REQUEST['dspm9'];
        $dspm10 = $_REQUEST['dspm10'];
        $dspm11 = $_REQUEST['dspm11'];        
        $dspm12 = $_REQUEST['dspm12'];
        $dspm13 = $_REQUEST['dspm13'];
        $dspm14 = $_REQUEST['dspm14'];
        $dspm15 = $_REQUEST['dspm15'];
        $dspm16 = $_REQUEST['dspm16'];

        if($dspm1=='true'){$dspm1="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm1="<input type=\"checkbox\">";}
        if($dspm2=='true'){$dspm2="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm2="<input type=\"checkbox\">";}
        if($dspm3=='true'){$dspm3="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm3="<input type=\"checkbox\">";}
        if($dspm4=='true'){$dspm4="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm4="<input type=\"checkbox\">";}
        if($dspm5=='true'){$dspm5="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm5="<input type=\"checkbox\">";}
        if($dspm6=='true'){$dspm6="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm6="<input type=\"checkbox\">";}
        if($dspm7=='true'){$dspm7="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm7="<input type=\"checkbox\">";}
        if($dspm8=='true'){$dspm8="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm8="<input type=\"checkbox\">";}
        if($dspm9=='true'){$dspm9="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm9="<input type=\"checkbox\">";}
        if($dspm10=='true'){$dspm10="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm10="<input type=\"checkbox\">";}
        if($dspm11=='true'){$dspm11="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm11="<input type=\"checkbox\">";}
        if($dspm12=='true'){$dspm12="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm12="<input type=\"checkbox\">";}
        if($dspm13=='true'){$dspm13="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm13="<input type=\"checkbox\">";}
        if($dspm14=='true'){$dspm14="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm14="<input type=\"checkbox\">";}
        if($dspm15=='true'){$dspm15="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm15="<input type=\"checkbox\">";}
        if($dspm16=='true'){$dspm16="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm16="<input type=\"checkbox\">";}

        $cnip = str_replace('123456789',' ',$ttd); 
        $cnip1 = str_replace('123456789',' ',$ttd1);

        $sqlsc="SELECT distinct kab_kota,daerah,thn_ang FROM sclient";
             $sqlsclient=$this->db->query($sqlsc);
             foreach ($sqlsclient->result() as $rowsc)
            {
                $kab     = $rowsc->kab_kota;
                $daerah  = $rowsc->daerah;
            }    
       
        $csql = "SELECT c.no_spm,c.tgl_spm,sum(b.nilai) as nilai from trhspm c inner join trhspp a on c.no_spp=a.no_spp inner join trdspp b on a.no_spp=b.no_spp
                WHERE a.jns_spp='8' and c.no_spm='$lcnospp' GROUP BY c.no_spm,c.tgl_spm
                order by c.tgl_spm,c.no_spm";
        $hasil = $this->db->query($csql);
        $trh = $hasil->row();
        $ldtglspp   = $trh->tgl_spm;
        $lcnospp    = $trh->no_spm;
        $nilai      = $trh->nilai;
        $tanggal    = $this->tanggal_format_indonesia($ldtglspp);
        
        $cRet = "";
        $cRet  .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
                        <td width=\"100%\" colspan = \"2\"  align=\"center\" style=\"font-size:14px;\"><b>LEMBAR KONTROL VERIFIKASI <br> DOKUMEN KELENGKAPAN SPM LS Pihak Ketiga Lainnya</b></td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"center\" style=\"font-size:12px;\">&nbsp;</td>
                        <td width=\"85%\" align=\"center\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"left\" style=\"font-size:12px;\">Nomor SPM </td>
                        <td width=\"85%\" align=\"left\" style=\"font-size:12px;\"> : $lcnospp </td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"left\" style=\"font-size:12px;\">Tanggal </td>
                        <td width=\"85%\" align=\"left\" style=\"font-size:12px;\"> : $tanggal</td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"left\" style=\"font-size:12px;\">Nilai </td>
                        <td width=\"85%\" align=\"left\" style=\"font-size:12px;\"> : Rp. ".number_format($nilai,'2','.',',')." </td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"center\" style=\"font-size:12px;\">&nbsp;</td>
                        <td width=\"85%\" align=\"center\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>
                </table>";

            $sql = "SELECT * from verif_penguji_spp_ls_pihak_ketiga_hibah";
            $hasil = $this->db->query($sql);
            foreach ($hasil->result() as $row){
                $judul          = $row->judul;
                $pernyataan     = $row->pernyataan;
                $ceklist1       = $row->ceklist1;
                $ceklist2       = $row->ceklist2;
                $ceklist3       = $row->ceklist3;
                $ceklist4       = $row->ceklist4;
                $ceklist5       = $row->ceklist5;
                $ceklist6       = $row->ceklist6;
                $ceklist7       = $row->ceklist7;
                $ceklist8       = $row->ceklist8;
                $ceklist9       = $row->ceklist9;
                
                $cRet  .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">Kelengkapan dokumen Pengajuan SP2D LS Belanja Hibah berupa uang kepada Pemerintah Pusat, Pemerintah Daerah lainnya, badan usaha milik negara, BUMD, dan/atau badan dan lembaga, serta organisasi kemasyarakatan</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>  
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm1 $ceklist1</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm2 $ceklist2</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm3 $ceklist3</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm4 $ceklist4</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm5 $ceklist5</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm6 $ceklist6</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm7 $ceklist7</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm8 $ceklist8</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm9 $ceklist9</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$pernyataan :</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>
                </table>";
            }

            $csql="SELECT nip,nama,jabatan FROM ms_ttd WHERE nip = '$cnip'";
            $hasil = $this->db->query($csql);
            $trh2 = $hasil->row(); 
            $nip = $trh2->nip;
            $nama = $trh2->nama;
            $jabatan = $trh2->jabatan;

            $cRet  .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-bottom: none;\">$dspm10 Berkas memenuhi persyaratan</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-bottom: none;\">Diverifikasi/diteliti oleh Penguji Tagihan</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">$dspm11 Berkas tidak memenuhi persyaratan</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\">".$daerah.', '.$this->tanggal_format_indonesia($tgl_ttd)."</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">Catatan atas berkas : <br> $cat1</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"></td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"><b><u>$nama</u></b></td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"><b>NIP. $nip</b></td>
                    </tr>
                </table>";

        $dsql="SELECT nip,nama,jabatan FROM ms_ttd WHERE nip = '$cnip1'";
            $hasil = $this->db->query($dsql);
            $trh3 = $hasil->row(); 
            $nip1 = $trh3->nip;
            $nama1 = $trh3->nama;
            $jabatan1 = $trh3->jabatan;

        $cRet  .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-bottom: none;\">$dspm12 Berkas memenuhi persyaratan</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-bottom: none;\">Diverifikasi/diteliti kembali oleh Kasubid</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">$dspm13 Berkas tidak memenuhi persyaratan</td>
                        <td width=\"50%\" align=\"left\" style=\"font-size:12px;border-top: none;border-bottom: none;\">$dspm14 Penatausahaan dan Pengelolaan Kas</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"left\" style=\"font-size:12px;border-top: none;border-bottom: none;\"> $dspm15 Belanja Langsung <br> $dspm16 Belanja Tidak Langsung</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\">".$daerah.', '.$this->tanggal_format_indonesia($tgl_ttd)."</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">Catatan atas berkas : <br> $cat2</td>
                        <td width=\"50%\" align=\"left\" style=\"font-size:12px;border-top: none;border-bottom: none;\"></td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"><b><u>$nama1</u></b></td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"><b>NIP. $nip1</b></td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" colspan=\"2\" style=\"font-size:12px;\">&nbsp; <br> Keterangan : <br> $cat3 <br> &nbsp;</td>
                    </tr>
                </table>";
         
        $data['prev']= $cRet;
        $this->_mpdf('',$cRet,30,25,5,'0');
    }

    function cetak_sppls_pihak3_parpol(){
        $lcnospp = str_replace('123456789','/',$_REQUEST['no']); 
        $tgl_ttd = $_REQUEST['ctglttd'];
        $ttd = $_REQUEST['ttd'];
        $ttd1 = $_REQUEST['ttd1'];
        $cat1 = str_replace('123456789',' ',$_REQUEST['catatan1']); 
        $cat2 = str_replace('123456789',' ',$_REQUEST['catatan2']); 
        $cat3 = str_replace('123456789',' ',$_REQUEST['catatan3']);
        
        $dspm1 = $_REQUEST['dspm1'];        
        $dspm2 = $_REQUEST['dspm2'];
        $dspm3 = $_REQUEST['dspm3'];
        $dspm4 = $_REQUEST['dspm4'];
        $dspm5 = $_REQUEST['dspm5'];
        $dspm6 = $_REQUEST['dspm6'];        
        $dspm7 = $_REQUEST['dspm7'];
        $dspm8 = $_REQUEST['dspm8'];
        $dspm9 = $_REQUEST['dspm9'];
        $dspm10 = $_REQUEST['dspm10'];
        $dspm11 = $_REQUEST['dspm11'];        
        $dspm12 = $_REQUEST['dspm12'];
        $dspm13 = $_REQUEST['dspm13'];
        $dspm14 = $_REQUEST['dspm14'];
        $dspm15 = $_REQUEST['dspm15'];
        $dspm16 = $_REQUEST['dspm16'];

        if($dspm1=='true'){$dspm1="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm1="<input type=\"checkbox\">";}
        if($dspm2=='true'){$dspm2="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm2="<input type=\"checkbox\">";}
        if($dspm3=='true'){$dspm3="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm3="<input type=\"checkbox\">";}
        if($dspm4=='true'){$dspm4="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm4="<input type=\"checkbox\">";}
        if($dspm5=='true'){$dspm5="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm5="<input type=\"checkbox\">";}
        if($dspm6=='true'){$dspm6="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm6="<input type=\"checkbox\">";}
        if($dspm7=='true'){$dspm7="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm7="<input type=\"checkbox\">";}
        if($dspm8=='true'){$dspm8="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm8="<input type=\"checkbox\">";}
        if($dspm9=='true'){$dspm9="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm9="<input type=\"checkbox\">";}
        if($dspm10=='true'){$dspm10="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm10="<input type=\"checkbox\">";}
        if($dspm11=='true'){$dspm11="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm11="<input type=\"checkbox\">";}
        if($dspm12=='true'){$dspm12="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm12="<input type=\"checkbox\">";}
        if($dspm13=='true'){$dspm13="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm13="<input type=\"checkbox\">";}
        if($dspm14=='true'){$dspm14="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm14="<input type=\"checkbox\">";}
        if($dspm15=='true'){$dspm15="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm15="<input type=\"checkbox\">";}
        if($dspm16=='true'){$dspm16="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm16="<input type=\"checkbox\">";}

        $cnip = str_replace('123456789',' ',$ttd); 
        $cnip1 = str_replace('123456789',' ',$ttd1);

        $sqlsc="SELECT distinct kab_kota,daerah,thn_ang FROM sclient";
             $sqlsclient=$this->db->query($sqlsc);
             foreach ($sqlsclient->result() as $rowsc)
            {
                $kab     = $rowsc->kab_kota;
                $daerah  = $rowsc->daerah;
            }    
       
        $csql = "SELECT c.no_spm,c.tgl_spm,sum(b.nilai) as nilai from trhspm c inner join trhspp a on c.no_spp=a.no_spp inner join trdspp b on a.no_spp=b.no_spp
                WHERE a.jns_spp='8' and c.no_spm='$lcnospp' GROUP BY c.no_spm,c.tgl_spm
                order by c.tgl_spm,c.no_spm";
        $hasil = $this->db->query($csql);
        $trh = $hasil->row();
        $ldtglspp   = $trh->tgl_spm;
        $lcnospp    = $trh->no_spm;
        $nilai      = $trh->nilai;
        $tanggal    = $this->tanggal_format_indonesia($ldtglspp);
        
        $cRet = "";
        $cRet  .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
                        <td width=\"100%\" colspan = \"2\"  align=\"center\" style=\"font-size:14px;\"><b>LEMBAR KONTROL VERIFIKASI <br> DOKUMEN KELENGKAPAN SPM LS Pihak Ketiga Lainnya</b></td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"center\" style=\"font-size:12px;\">&nbsp;</td>
                        <td width=\"85%\" align=\"center\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"left\" style=\"font-size:12px;\">Nomor SPM </td>
                        <td width=\"85%\" align=\"left\" style=\"font-size:12px;\"> : $lcnospp </td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"left\" style=\"font-size:12px;\">Tanggal </td>
                        <td width=\"85%\" align=\"left\" style=\"font-size:12px;\"> : $tanggal</td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"left\" style=\"font-size:12px;\">Nilai </td>
                        <td width=\"85%\" align=\"left\" style=\"font-size:12px;\"> : Rp. ".number_format($nilai,'2','.',',')." </td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"center\" style=\"font-size:12px;\">&nbsp;</td>
                        <td width=\"85%\" align=\"center\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>
                </table>";

            $sql = "SELECT * from verif_penguji_spp_ls_pihak_ketiga_bantuan_keuangan";
            $hasil = $this->db->query($sql);
            foreach ($hasil->result() as $row){
                $judul          = $row->judul;
                $pernyataan     = $row->pernyataan;
                $ceklist1       = $row->ceklist1;
                $ceklist2       = $row->ceklist2;
                $ceklist3       = $row->ceklist3;
                $ceklist4       = $row->ceklist4;
                $ceklist5       = $row->ceklist5;
                $ceklist6       = $row->ceklist6;
                $ceklist7       = $row->ceklist7;
                $ceklist8       = $row->ceklist8;
                $ceklist9       = $row->ceklist9;
                
                $cRet  .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">Kelengkapan dokumen Pengajuan SP2D LS Belanja Hibah Bantuan Keuangan Partai Politik</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>  
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm1 $ceklist1</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm2 $ceklist2</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm3 $ceklist3</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm4 $ceklist4</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm5 $ceklist5</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm6 $ceklist6</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm7 $ceklist7</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm8 $ceklist8</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm9 $ceklist9</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$pernyataan :</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>
                </table>";
            }

            $csql="SELECT nip,nama,jabatan FROM ms_ttd WHERE nip = '$cnip'";
            $hasil = $this->db->query($csql);
            $trh2 = $hasil->row(); 
            $nip = $trh2->nip;
            $nama = $trh2->nama;
            $jabatan = $trh2->jabatan;

            $cRet  .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-bottom: none;\">$dspm10 Berkas memenuhi persyaratan</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-bottom: none;\">Diverifikasi/diteliti oleh Penguji Tagihan</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">$dspm11 Berkas tidak memenuhi persyaratan</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\">".$daerah.', '.$this->tanggal_format_indonesia($tgl_ttd)."</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">Catatan atas berkas : <br> $cat1</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"></td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"><b><u>$nama</u></b></td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"><b>NIP. $nip</b></td>
                    </tr>
                </table>";

        $dsql="SELECT nip,nama,jabatan FROM ms_ttd WHERE nip = '$cnip1'";
            $hasil = $this->db->query($dsql);
            $trh3 = $hasil->row(); 
            $nip1 = $trh3->nip;
            $nama1 = $trh3->nama;
            $jabatan1 = $trh3->jabatan;

        $cRet  .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-bottom: none;\">$dspm12 Berkas memenuhi persyaratan</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-bottom: none;\">Diverifikasi/diteliti kembali oleh Kasubid</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">$dspm13 Berkas tidak memenuhi persyaratan</td>
                        <td width=\"50%\" align=\"left\" style=\"font-size:12px;border-top: none;border-bottom: none;\">$dspm14 Penatausahaan dan Pengelolaan Kas</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"left\" style=\"font-size:12px;border-top: none;border-bottom: none;\"> $dspm15 Belanja Langsung <br> $dspm16 Belanja Tidak Langsung</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\">".$daerah.', '.$this->tanggal_format_indonesia($tgl_ttd)."</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">Catatan atas berkas : <br> $cat2</td>
                        <td width=\"50%\" align=\"left\" style=\"font-size:12px;border-top: none;border-bottom: none;\"></td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"><b><u>$nama1</u></b></td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"><b>NIP. $nip1</b></td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" colspan=\"2\" style=\"font-size:12px;\">&nbsp; <br> Keterangan : <br> $cat3 <br> &nbsp;</td>
                    </tr>
                </table>";
         
        $data['prev']= $cRet;
        $this->_mpdf('',$cRet,30,25,5,'0');
    }

    function cetak_sppls_pihak3_subsidi(){
        $lcnospp = str_replace('123456789','/',$_REQUEST['no']); 
        $tgl_ttd = $_REQUEST['ctglttd'];
        $ttd = $_REQUEST['ttd'];
        $ttd1 = $_REQUEST['ttd1'];
        $cat1 = str_replace('123456789',' ',$_REQUEST['catatan1']); 
        $cat2 = str_replace('123456789',' ',$_REQUEST['catatan2']); 
        $cat3 = str_replace('123456789',' ',$_REQUEST['catatan3']);
        
        $dspm1 = $_REQUEST['dspm1'];        
        $dspm2 = $_REQUEST['dspm2'];
        $dspm3 = $_REQUEST['dspm3'];
        $dspm4 = $_REQUEST['dspm4'];
        $dspm5 = $_REQUEST['dspm5'];
        $dspm6 = $_REQUEST['dspm6'];        
        $dspm7 = $_REQUEST['dspm7'];
        $dspm8 = $_REQUEST['dspm8'];
        $dspm9 = $_REQUEST['dspm9'];
        $dspm10 = $_REQUEST['dspm10'];
        $dspm11 = $_REQUEST['dspm11'];        
        $dspm12 = $_REQUEST['dspm12'];
        $dspm13 = $_REQUEST['dspm13'];
        $dspm14 = $_REQUEST['dspm14'];
        $dspm15 = $_REQUEST['dspm15'];
        $dspm16 = $_REQUEST['dspm16'];

        if($dspm1=='true'){$dspm1="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm1="<input type=\"checkbox\">";}
        if($dspm2=='true'){$dspm2="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm2="<input type=\"checkbox\">";}
        if($dspm3=='true'){$dspm3="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm3="<input type=\"checkbox\">";}
        if($dspm4=='true'){$dspm4="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm4="<input type=\"checkbox\">";}
        if($dspm5=='true'){$dspm5="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm5="<input type=\"checkbox\">";}
        if($dspm6=='true'){$dspm6="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm6="<input type=\"checkbox\">";}
        if($dspm7=='true'){$dspm7="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm7="<input type=\"checkbox\">";}
        if($dspm8=='true'){$dspm8="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm8="<input type=\"checkbox\">";}
        if($dspm9=='true'){$dspm9="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm9="<input type=\"checkbox\">";}
        if($dspm10=='true'){$dspm10="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm10="<input type=\"checkbox\">";}
        if($dspm11=='true'){$dspm11="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm11="<input type=\"checkbox\">";}
        if($dspm12=='true'){$dspm12="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm12="<input type=\"checkbox\">";}
        if($dspm13=='true'){$dspm13="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm13="<input type=\"checkbox\">";}
        if($dspm14=='true'){$dspm14="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm14="<input type=\"checkbox\">";}
        if($dspm15=='true'){$dspm15="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm15="<input type=\"checkbox\">";}
        if($dspm16=='true'){$dspm16="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm16="<input type=\"checkbox\">";}

        $cnip = str_replace('123456789',' ',$ttd); 
        $cnip1 = str_replace('123456789',' ',$ttd1);

        $sqlsc="SELECT distinct kab_kota,daerah,thn_ang FROM sclient";
             $sqlsclient=$this->db->query($sqlsc);
             foreach ($sqlsclient->result() as $rowsc)
            {
                $kab     = $rowsc->kab_kota;
                $daerah  = $rowsc->daerah;
            }    
       
        $csql = "SELECT c.no_spm,c.tgl_spm,sum(b.nilai) as nilai from trhspm c inner join trhspp a on c.no_spp=a.no_spp inner join trdspp b on a.no_spp=b.no_spp
                WHERE a.jns_spp='8' and c.no_spm='$lcnospp' GROUP BY c.no_spm,c.tgl_spm
                order by c.tgl_spm,c.no_spm";
        $hasil = $this->db->query($csql);
        $trh = $hasil->row();
        $ldtglspp   = $trh->tgl_spm;
        $lcnospp    = $trh->no_spm;
        $nilai      = $trh->nilai;
        $tanggal    = $this->tanggal_format_indonesia($ldtglspp);
        
        $cRet = "";
        $cRet  .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
                        <td width=\"100%\" colspan = \"2\"  align=\"center\" style=\"font-size:14px;\"><b>LEMBAR KONTROL VERIFIKASI <br> DOKUMEN KELENGKAPAN SPM LS Pihak Ketiga Lainnya</b></td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"center\" style=\"font-size:12px;\">&nbsp;</td>
                        <td width=\"85%\" align=\"center\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"left\" style=\"font-size:12px;\">Nomor SPM </td>
                        <td width=\"85%\" align=\"left\" style=\"font-size:12px;\"> : $lcnospp </td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"left\" style=\"font-size:12px;\">Tanggal </td>
                        <td width=\"85%\" align=\"left\" style=\"font-size:12px;\"> : $tanggal</td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"left\" style=\"font-size:12px;\">Nilai </td>
                        <td width=\"85%\" align=\"left\" style=\"font-size:12px;\"> : Rp. ".number_format($nilai,'2','.',',')." </td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"center\" style=\"font-size:12px;\">&nbsp;</td>
                        <td width=\"85%\" align=\"center\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>
                </table>";

            $sql = "SELECT * from verif_penguji_spp_ls_pihak_ketiga_subsidi";
            $hasil = $this->db->query($sql);
            foreach ($hasil->result() as $row){
                $judul          = $row->judul;
                $pernyataan     = $row->pernyataan;
                $ceklist1       = $row->ceklist1;
                $ceklist2       = $row->ceklist2;
                $ceklist3       = $row->ceklist3;
                $ceklist4       = $row->ceklist4;
                $ceklist5       = $row->ceklist5;
                $ceklist6       = $row->ceklist6;
                $ceklist7       = $row->ceklist7;
                $ceklist8       = $row->ceklist8;
                $ceklist9       = $row->ceklist9;
                
                $cRet  .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">Kelengkapan dokumen Pengajuan SP2D LS Belanja Subsidi</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>  
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm1 $ceklist1</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm2 $ceklist2</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm3 $ceklist3</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm4 $ceklist4</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm5 $ceklist5</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm6 $ceklist6</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm7 $ceklist7</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm8 $ceklist8</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm9 $ceklist9</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$pernyataan :</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>
                </table>";
            }

            $csql="SELECT nip,nama,jabatan FROM ms_ttd WHERE nip = '$cnip'";
            $hasil = $this->db->query($csql);
            $trh2 = $hasil->row(); 
            $nip = $trh2->nip;
            $nama = $trh2->nama;
            $jabatan = $trh2->jabatan;

            $cRet  .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-bottom: none;\">$dspm10 Berkas memenuhi persyaratan</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-bottom: none;\">Diverifikasi/diteliti oleh Penguji Tagihan</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">$dspm11 Berkas tidak memenuhi persyaratan</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\">".$daerah.', '.$this->tanggal_format_indonesia($tgl_ttd)."</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">Catatan atas berkas : <br> $cat1</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"></td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"><b><u>$nama</u></b></td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"><b>NIP. $nip</b></td>
                    </tr>
                </table>";

        $dsql="SELECT nip,nama,jabatan FROM ms_ttd WHERE nip = '$cnip1'";
            $hasil = $this->db->query($dsql);
            $trh3 = $hasil->row(); 
            $nip1 = $trh3->nip;
            $nama1 = $trh3->nama;
            $jabatan1 = $trh3->jabatan;

        $cRet  .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-bottom: none;\">$dspm12 Berkas memenuhi persyaratan</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-bottom: none;\">Diverifikasi/diteliti kembali oleh Kasubid</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">$dspm13 Berkas tidak memenuhi persyaratan</td>
                        <td width=\"50%\" align=\"left\" style=\"font-size:12px;border-top: none;border-bottom: none;\">$dspm14 Penatausahaan dan Pengelolaan Kas</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"left\" style=\"font-size:12px;border-top: none;border-bottom: none;\"> $dspm15 Belanja Langsung <br> $dspm16 Belanja Tidak Langsung</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\">".$daerah.', '.$this->tanggal_format_indonesia($tgl_ttd)."</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">Catatan atas berkas : <br> $cat2</td>
                        <td width=\"50%\" align=\"left\" style=\"font-size:12px;border-top: none;border-bottom: none;\"></td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"><b><u>$nama1</u></b></td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"><b>NIP. $nip1</b></td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" colspan=\"2\" style=\"font-size:12px;\">&nbsp; <br> Keterangan : <br> $cat3 <br> &nbsp;</td>
                    </tr>
                </table>";
         
        $data['prev']= $cRet;
        $this->_mpdf('',$cRet,30,25,5,'0');
    }

    function cetak_sppls_pihak3_pajak(){
        $lcnospp = str_replace('123456789','/',$_REQUEST['no']); 
        $tgl_ttd = $_REQUEST['ctglttd'];
        $ttd = $_REQUEST['ttd'];
        $ttd1 = $_REQUEST['ttd1'];
        $cat1 = str_replace('123456789',' ',$_REQUEST['catatan1']); 
        $cat2 = str_replace('123456789',' ',$_REQUEST['catatan2']); 
        $cat3 = str_replace('123456789',' ',$_REQUEST['catatan3']);
        
        $dspm1 = $_REQUEST['dspm1'];        
        $dspm2 = $_REQUEST['dspm2'];
        $dspm3 = $_REQUEST['dspm3'];
        $dspm4 = $_REQUEST['dspm4'];
        $dspm5 = $_REQUEST['dspm5'];
        $dspm6 = $_REQUEST['dspm6'];        
        $dspm7 = $_REQUEST['dspm7'];
        $dspm8 = $_REQUEST['dspm8'];
        $dspm9 = $_REQUEST['dspm9'];
        $dspm10 = $_REQUEST['dspm10'];
        $dspm11 = $_REQUEST['dspm11'];        
        $dspm12 = $_REQUEST['dspm12'];
        $dspm13 = $_REQUEST['dspm13'];
        $dspm14 = $_REQUEST['dspm14'];

        if($dspm1=='true'){$dspm1="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm1="<input type=\"checkbox\">";}
        if($dspm2=='true'){$dspm2="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm2="<input type=\"checkbox\">";}
        if($dspm3=='true'){$dspm3="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm3="<input type=\"checkbox\">";}
        if($dspm4=='true'){$dspm4="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm4="<input type=\"checkbox\">";}
        if($dspm5=='true'){$dspm5="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm5="<input type=\"checkbox\">";}
        if($dspm6=='true'){$dspm6="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm6="<input type=\"checkbox\">";}
        if($dspm7=='true'){$dspm7="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm7="<input type=\"checkbox\">";}
        if($dspm8=='true'){$dspm8="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm8="<input type=\"checkbox\">";}
        if($dspm9=='true'){$dspm9="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm9="<input type=\"checkbox\">";}
        if($dspm10=='true'){$dspm10="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm10="<input type=\"checkbox\">";}
        if($dspm11=='true'){$dspm11="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm11="<input type=\"checkbox\">";}
        if($dspm12=='true'){$dspm12="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm12="<input type=\"checkbox\">";}
        if($dspm13=='true'){$dspm13="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm13="<input type=\"checkbox\">";}
        if($dspm14=='true'){$dspm14="<img src=\"./image/ceklist.png\" weight=\"10\" height=\"10\"/>";}else{$dspm14="<input type=\"checkbox\">";}

        $cnip = str_replace('123456789',' ',$ttd); 
        $cnip1 = str_replace('123456789',' ',$ttd1);

        $sqlsc="SELECT distinct kab_kota,daerah,thn_ang FROM sclient";
             $sqlsclient=$this->db->query($sqlsc);
             foreach ($sqlsclient->result() as $rowsc)
            {
                $kab     = $rowsc->kab_kota;
                $daerah  = $rowsc->daerah;
            }    
       
        $csql = "SELECT c.no_spm,c.tgl_spm,sum(b.nilai) as nilai from trhspm c inner join trhspp a on c.no_spp=a.no_spp inner join trdspp b on a.no_spp=b.no_spp
                WHERE a.jns_spp='8' and c.no_spm='$lcnospp' GROUP BY c.no_spm,c.tgl_spm
                order by c.tgl_spm,c.no_spm";
        $hasil = $this->db->query($csql);
        $trh = $hasil->row();
        $ldtglspp   = $trh->tgl_spm;
        $lcnospp    = $trh->no_spm;
        $nilai      = $trh->nilai;
        $tanggal    = $this->tanggal_format_indonesia($ldtglspp);
        
        $cRet = "";
        $cRet  .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
                        <td width=\"100%\" colspan = \"2\"  align=\"center\" style=\"font-size:14px;\"><b>LEMBAR KONTROL VERIFIKASI <br> DOKUMEN KELENGKAPAN SPM LS Pihak Ketiga Lainnya</b></td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"center\" style=\"font-size:12px;\">&nbsp;</td>
                        <td width=\"85%\" align=\"center\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"left\" style=\"font-size:12px;\">Nomor SPM </td>
                        <td width=\"85%\" align=\"left\" style=\"font-size:12px;\"> : $lcnospp </td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"left\" style=\"font-size:12px;\">Tanggal </td>
                        <td width=\"85%\" align=\"left\" style=\"font-size:12px;\"> : $tanggal</td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"left\" style=\"font-size:12px;\">Nilai </td>
                        <td width=\"85%\" align=\"left\" style=\"font-size:12px;\"> : Rp. ".number_format($nilai,'2','.',',')." </td>
                    </tr>
                    <tr>
                        <td width=\"15%\" align=\"center\" style=\"font-size:12px;\">&nbsp;</td>
                        <td width=\"85%\" align=\"center\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>
                </table>";

            $sql = "SELECT * from verif_penguji_spp_ls_pihak_ketiga_bantuan_pajak";
            $hasil = $this->db->query($sql);
            foreach ($hasil->result() as $row){
                $judul          = $row->judul;
                $pernyataan     = $row->pernyataan;
                $ceklist1       = $row->ceklist1;
                $ceklist2       = $row->ceklist2;
                $ceklist3       = $row->ceklist3;
                $ceklist4       = $row->ceklist4;
                $ceklist5       = $row->ceklist5;
                $ceklist6       = $row->ceklist6;
                $ceklist7       = $row->ceklist7;
                
                $cRet  .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">Kelengkapan dokumen Pengajuan SP2D LS Alokasi Dana Desa/ADK dan Belanja Bagi Hasil Pendapatan Daerah dan Retribusi Daerah Kepada Pemerintahan Desa</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>  
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm1 $ceklist1</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm2 $ceklist2</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm3 $ceklist3</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm4 $ceklist4</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm5 $ceklist5</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm6 $ceklist6</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$dspm7 $ceklist7</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">$pernyataan :</td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" style=\"font-size:12px;\">&nbsp;</td>
                    </tr>
                </table>";
            }

            $csql="SELECT nip,nama,jabatan FROM ms_ttd WHERE nip = '$cnip'";
            $hasil = $this->db->query($csql);
            $trh2 = $hasil->row(); 
            $nip = $trh2->nip;
            $nama = $trh2->nama;
            $jabatan = $trh2->jabatan;

            $cRet  .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-bottom: none;\">$dspm8 Berkas memenuhi persyaratan</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-bottom: none;\">Diverifikasi/diteliti oleh Penguji Tagihan</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">$dspm9 Berkas tidak memenuhi persyaratan</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\">".$daerah.', '.$this->tanggal_format_indonesia($tgl_ttd)."</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">Catatan atas berkas : <br> $cat1</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"></td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"><b><u>$nama</u></b></td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"><b>NIP. $nip</b></td>
                    </tr>
                </table>";

        $dsql="SELECT nip,nama,jabatan FROM ms_ttd WHERE nip = '$cnip1'";
            $hasil = $this->db->query($dsql);
            $trh3 = $hasil->row(); 
            $nip1 = $trh3->nip;
            $nama1 = $trh3->nama;
            $jabatan1 = $trh3->jabatan;

        $cRet  .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-bottom: none;\">$dspm10 Berkas memenuhi persyaratan</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-bottom: none;\">Diverifikasi/diteliti kembali oleh Kasubid</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">$dspm11 Berkas tidak memenuhi persyaratan</td>
                        <td width=\"50%\" align=\"left\" style=\"font-size:12px;border-top: none;border-bottom: none;\">$dspm12 Penatausahaan dan Pengelolaan Kas</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"left\" style=\"font-size:12px;border-top: none;border-bottom: none;\"> $dspm13 Belanja Langsung <br> $dspm14 Belanja Tidak Langsung</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\">".$daerah.', '.$this->tanggal_format_indonesia($tgl_ttd)."</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">Catatan atas berkas : <br> $cat2</td>
                        <td width=\"50%\" align=\"left\" style=\"font-size:12px;border-top: none;border-bottom: none;\"></td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"><b><u>$nama1</u></b></td>
                    </tr>
                    <tr>
                        <td width=\"50%\" align=\"justify\" style=\"font-size:12px;border-top: none;border-bottom: none;\">&nbsp;</td>
                        <td width=\"50%\" align=\"center\" style=\"font-size:12px;border-top: none;border-bottom: none;\"><b>NIP. $nip1</b></td>
                    </tr>
                    <tr>
                        <td width=\"100%\" align=\"justify\" colspan=\"2\" style=\"font-size:12px;\">&nbsp; <br> Keterangan : <br> $cat3 <br> &nbsp;</td>
                    </tr>
                </table>";
         
        $data['prev']= $cRet;
        $this->_mpdf('',$cRet,30,25,5,'0');
    }


	
}