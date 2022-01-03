<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class cetak_rka extends CI_Controller {

public $ppkd = "4.02.02";
public $ppkd1 = "4.02.02.02";
public $keu1 = "4.02.02.01";
public $kdbkad="5-02.0-00.0-00.02.01";

public $ppkd_lama = "4.02.02";
public $ppkd1_lama = "4.02.02.02";
 
    function __contruct()
    {   
        parent::__construct();
    }   

    function cetak_rka_rekap($jenis=''){
    	$data['jenis']=$jenis;
        $data['page_title']= 'CETAK';
        $this->template->set('title', 'Cetak '.$jenis.' SKPD Penetapan');   
        $this->template->load('template','anggaran/rka/penetapan/rka_skpd_penetapan',$data) ; 
    }
    function cetak_rka_pendapatan($jenis=''){
    	$data['jenis']=$jenis;
        $data['page_title']= 'CETAK';
        $this->template->set('title', 'Cetak '.$jenis.' 1 Penyusunan');   
        $this->template->load('template','anggaran/rka/penetapan/rka_pendapatan_penyusunan',$data) ; 
    }

	function rka22_penyusunan($jenis=''){
    	$data['jenis']=$jenis;
        $data['page_title']= 'CETAK';
        $this->template->set('title', 'Cetak '.$jenis.' Belanja SKPD Penyusunan');   
        $this->template->load('template','anggaran/rka/penyusunan/rka22_penyusunan',$data) ; 
    }
	
	function cetak_rka_pembiayaan($jenis=''){
    	$data['jenis']=$jenis;
        $data['page_title']= 'CETAK '.$jenis.' 31';
        $this->template->set('title', 'CETAK '.$jenis.' 31');   
        $this->template->load('template','anggaran/rka/penetapan/rka_pembiayaan_penetapan',$data) ; 
    }

    function list_cetakrka_skpd(){
        if($this->session->userdata('type')=='1'){
            $data['jenis']="RKA";
            $data['page_title']= 'CETAK RKA ';
            $this->template->set('title', 'CETAK RKA ');   
            $this->template->load('template','anggaran/rka/penetapan/list_cetak_skpd',$data) ;
        }else{
            $this->list_cetakrka_belanja_rinci();
        }

    }

    function list_cetakdpa_skpd(){
        if($this->session->userdata('type')=='1'){
            $data['jenis']="DPA";
            $data['page_title']= 'CETAK DPA ';
            $this->template->set('title', 'CETAK DPA ');   
            $this->template->load('template','anggaran/rka/penetapan/list_cetak_skpd',$data) ;
        }else{
            $this->list_cetakdpa_belanja_rinci();
        }

    }

    function list_cetakrka_belanja_rinci($skpd=''){
        $data['skpd']=$skpd;
        $data['jenis']="RKA";
        $data['page_title']= 'CETAK RKA ';
        $this->template->set('title', 'CETAK RKA ');   
        $this->template->load('template','anggaran/rka/penetapan/rka_rincian_belanja',$data) ;
    }

    function list_cetakdpa_belanja_rinci($skpd=''){
        $data['skpd']=$skpd;
        $data['jenis']="DPA";
        $data['page_title']= 'CETAK DPA ';
        $this->template->set('title', 'CETAK DPA ');   
        $this->template->load('template','anggaran/rka/penetapan/rka_rincian_belanja',$data) ;
    }

	function load_tanda_tangan($skpd=''){ 
		$lccr = $this->input->post('q');    
		echo $this->master_ttd->load_tanda_tangan($skpd,$lccr); 
	}

    /*cetak rka 0 skpd*/
    function preview_rka_skpd_penetapan(){
        $tgl_ttd= $this->uri->segment(2);
        $ttd1   = $this->uri->segment(3);
        $ttd2   = $this->uri->segment(4);
        $id     = $this->uri->segment(5);
        $cetak  = $this->uri->segment(6);
        $detail = $this->uri->segment(7);
        $doc    = $this->uri->segment(8);
        $gaji   = $this->uri->segment(9);
        $tanggal_ttd = $this->support->tanggal_format_indonesia($tgl_ttd);
        echo $this->cetak_rka_model->preview_rka_skpd_penetapan($tgl_ttd,$ttd1,$ttd2,$id,$cetak,$detail,$tanggal_ttd,$doc,$gaji);
                
    } 
    /*cetak rka 2 skpd*/
	function preview_pendapatan_penyusunan(){
        $tgl_ttd = $this->uri->segment(2);
        $ttd1    = $this->uri->segment(3);
        $ttd2    = $this->uri->segment(4);
        $id      = $this->uri->segment(5);
        $cetak   = $this->uri->segment(6);
        $doc     = $this->uri->segment(7);
        echo $this->cetak_rka_model->preview_pendapatan_penyusunan($tgl_ttd,$ttd1,$ttd2,$id,$cetak,$doc);
    }

	function preview_belanja_penyusunan(){
        $tgl_ttd = $this->uri->segment(2);
        $ttd1    = $this->uri->segment(3);
        $ttd2    = $this->uri->segment(4);
        $id      = $this->uri->segment(5);
        $cetak   = $this->uri->segment(6);
        $doc     = $this->uri->segment(7);
        echo $this->cetak_rka_model->preview_belanja_penyusunan($tgl_ttd,$ttd1,$ttd2,$id,$cetak,$doc);
    }

    function preview_rka_pembiayaan_penetapan(){
        $tgl_ttd= $this->uri->segment(2);
        $ttd1   = $this->uri->segment(3);
        $ttd2   = $this->uri->segment(4);
        $id     = $this->uri->segment(5);
        $cetak  = $this->uri->segment(6);
        $detail = $this->uri->segment(7);
        $doc    = $this->uri->segment(8);
        $tanggal_ttd = $this->support->tanggal_format_indonesia($tgl_ttd);
        echo $this->cetak_rka_model->preview_rka_pembiayaan_penetapan($tgl_ttd,$ttd1,$ttd2,$id,$cetak,$detail,$tanggal_ttd,$doc);            
    } 


     function preview_rka221_penyusunan(){
        $id = $this->uri->segment(2);
        $giat = $this->uri->segment(3);
        $cetak = $this->uri->segment(4);
        $atas = $this->uri->segment(5);
        $bawah = $this->uri->segment(6);
        $kiri = $this->uri->segment(7);
        $kanan = $this->uri->segment(8);
        $jns_an = $this->uri->segment(9);
        $tgl_ttd= $_REQUEST['tgl_ttd'];
        $ttd1= $_REQUEST['ttd1'];
        $ttd2= $_REQUEST['ttd2'];
        //$jns_an="RKA"; 
        $tanggal_ttd = $this->support->tanggal_format_indonesia($tgl_ttd);
        echo $this->cetak_rka_model->preview_rka221_penyusunan($id,$giat,$cetak,$atas,$bawah,$kiri,$kanan,$tgl_ttd,$ttd1,$ttd2, $tanggal_ttd,$jns_an);
       
    }


    function rka221_penyusunan(){   
        $id = $this->session->userdata('kdskpd');
        $type = $this->session->userdata('type');
        if($type=='1'){
            $this->index('0','ms_skpd','kd_skpd','nm_skpd','RKA 221 Penyusunan','penyusunan/rka221_penyusunan','');
        }else{
            $this->daftar_kegiatan_penyusunan($id);
        }
    }

    function index($offset=0,$lctabel,$field,$field1,$judul,$list,$lccari){
        $data['page_title'] = "CETAK $judul";
        if(empty($lccari)){
            $total_rows = $this->master_model->get_count($lctabel);
            $lc = "/.$lccari";
        }else{
            $total_rows = $this->master_model->get_count_teang($lctabel,$field,$field1,$lccari);
            $lc = "";
        }      
        $config['base_url']         = site_url("cetak_rka/".$list);
        $config['total_rows']       = $total_rows;
        $config['per_page']         = '10';
        $config['uri_segment']      = 3;
        $config['num_links']        = 5;
        $config['full_tag_open']    = '<ul class="page-navi">';
        $config['full_tag_close']   = '</ul>';
        $config['num_tag_open']     = '<li>';
        $config['num_tag_close']    = '</li>';
        $config['cur_tag_open']     = '<li class="current">';
        $config['cur_tag_close']    = '</li>';
        $config['prev_link']        = '&lt;';
        $config['prev_tag_open']    = '<li>';
        $config['prev_tag_close']   = '</li>';
        $config['next_link']        = '&gt;';
        $config['next_tag_open']    = '<li>';
        $config['next_tag_close']   = '</li>';
        $config['last_link']        = 'Last';
        $config['last_tag_open']    = '<li>';
        $config['last_tag_close']   = '</li>';
        $config['first_link']       = 'First';
        $config['first_tag_open']   = '<li>';
        $config['first_tag_close']  = '</li>';
        $limit                      = $config['per_page'];  
        $offset                     = $this->uri->segment(3);  
        $offset                     = ( ! is_numeric($offset) || $offset < 1) ? 0 : $offset;  
          
        if(empty($offset)){  
            $offset=0;  
        }
               
        if(empty($lccari)){     
            $data['list']       = $this->master_model->getAll($lctabel,$field,$limit, $offset);
        }else {
            $data['list']       = $this->master_model->getCari($lctabel,$field,$field1,$limit, $offset,$lccari);
        }
        $data['num']            = $offset;
        $data['total_rows']     = $total_rows;
        
        $this->pagination->initialize($config);
        $a=$judul;
        $data['sikap'] = 'list';
        $this->template->set('title', 'CETAK '.$judul);
        $this->template->load('template', "anggaran/rka/".$list, $data);
    }

    function daftar_kegiatan_penyusunan($offset=0){
        $type = $this->session->userdata('type');
        if($type=='1'){
            $id = $this->uri->segment(2);
        }else{
            $id = $this->session->userdata('kdskpd');
        }

        $data['page_title'] = "DAFTAR KEGIATAN";
        
        $total_rows = $this->rka_model->get_count($id);
        $config['base_url']         = base_url("cetak_rka/daftar_kegiatan_penyusunan/$id");
        $config['total_rows']       = $total_rows;
        $config['per_page']         = '10';
        $config['uri_segment']      = 3;
        $config['num_links']        = 5;
        $config['full_tag_open']    = '<ul class="page-navi">';
        $config['full_tag_close']   = '</ul>';
        $config['num_tag_open']     = '<li>';
        $config['num_tag_close']    = '</li>';
        $config['cur_tag_open']     = '<li class="current">';
        $config['cur_tag_close']    = '</li>';
        $config['prev_link']        = '&lt;';
        $config['prev_tag_open']    = '<li>';
        $config['prev_tag_close']   = '</li>';
        $config['next_link']        = '&gt;';
        $config['next_tag_open']    = '<li>';
        $config['next_tag_close']   = '</li>';
        $config['last_link']        = 'Last';
        $config['last_tag_open']    = '<li>';
        $config['last_tag_close']   = '</li>';
        $config['first_link']       = 'First';
        $config['first_tag_open']   = '<li>';
        $config['first_tag_close']  = '</li>';
        $limit                      = $config['per_page'];  
        $offset                     = $this->uri->segment(3);  
        $offset                     = ( ! is_numeric($offset) || $offset < 1) ? 0 : $offset;  
          
        if(empty($offset))  
        {  
            $offset=0;  
        }
    
        $data['list']       = $this->rka_model->getAll($limit, $offset,$id);
        $data['num']        = $offset;
        $data['total_rows'] = $total_rows;
        
                $this->pagination->initialize($config);
        
        $this->template->set('title', 'Master Data kegiatan');
        $this->template->load('template', 'anggaran/rka/penetapan/list_penyusunan', $data);
    }

    function cekkua()
    {
        $data['page_title']= 'CEK KUA SKPD';
        $this->template->set('title', 'CEK KUA SKPD');   
        $this->template->load('template','anggaran/rka/cek_kua',$data) ; 
    }

   function cek_kua(){
        $sql="SELECT nilai_kua-nilai_ang sel,* from(SELECT a.nilai_kua, a.nm_skpd, a.kd_skpd,
                                (SELECT SUM(nilai) FROM trdrka WHERE LEFT(kd_rek6,1)='5' AND left(kd_skpd,20) = left(a.kd_skpd,20)) as nilai_ang,
                                (SELECT SUM(nilai_sempurna) FROM trdrka WHERE LEFT(kd_rek6,1)='5' AND left(kd_skpd,20) =left(a.kd_skpd,20)) as nilai_angg_sempurna,
                                (SELECT SUM(nilai_ubah) FROM trdrka WHERE LEFT(kd_rek6,1)='5' AND left(kd_skpd,20) = a.kd_skpd) as nilai_angg_ubah
                                FROM ms_skpd a )xx ORDER by kd_skpd";
        $exe=$this->db->query($sql);
        $tbl="<table cellpadding='5px' cellspacing='0' border='1' style='border-collapse:collapse'>
                <tr> 
                    <td align='center' bgcolor='#cccccc'>Kode SKPD</td>
                    <td align='center' bgcolor='#cccccc'>Nama SKPD</td>
                    <td align='center' bgcolor='#cccccc'>Nilai KUA</td>
                    <td align='center' bgcolor='#cccccc'>TOTAL BELANJA</td>
                    <td align='center' bgcolor='#cccccc'>SELISIH</td>
                </tr>";
        foreach($exe->result() as $isi){
            $sel=number_format($isi->sel,2,',','.');
            $nilai_kua=number_format($isi->nilai_kua,2,',','.');
            $nilai_ang=number_format($isi->nilai_ang,2,',','.');
            $nm_skpd=$isi->nm_skpd;
            $kd_skpd=$isi->kd_skpd;

            if($isi->sel<0){
                $bgcolor="bgcolor='red'";
            }else{
                $bgcolor='';
            }
            $tbl .="<tr> 
                        <td $bgcolor align='center'>$kd_skpd</td>
                        <td $bgcolor align='left'>$nm_skpd</td>
                        <td $bgcolor align='right'>$nilai_kua</td>
                        <td $bgcolor align='right'>$nilai_ang</td>
                        <td $bgcolor align='right'>$sel</td>
                    </tr>";
        }

        $tbl .="</table>";
        echo "$tbl";
    }
}