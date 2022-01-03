<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class rekap_kasController extends CI_Controller {

	function __construct()
	{	 
		parent::__construct();
		$this->load->model('public_model','Mpublic');	
	}  
	
	
    function index(){ 
        $data['page_title']= 'REKAP PENGELUARAN';
        $this->template->set('title', 'REKAP PENGELUARAN');   
        $this->template->load('template','tukd/sp2d/rekon_daftar_pengeluaran_rekap_kasda',$data) ;  		        

    }	

  function skpd() {
    $skpd = $this->session->userdata('kdskpd');
    $lccr = $this->input->post('q');

    if ($lccr == '') {
      $where = '';
    } else {
      $where = "WHERE upper(kd_skpd) like upper('%$lccr%') or upper(nm_skpd) like upper('%$lccr%')";
    }

    $sql = "SELECT kd_skpd,nm_skpd FROM ms_skpd $where";
    $query1 = $this->db->query($sql);  
    $result = array();
    $ii = 0;
    foreach($query1->result_array() as $resulte)
    { 

      $result[] = array(
        'id' => $ii,        
        'kd_skpd' => $resulte['kd_skpd'],  
        'nm_skpd' => $resulte['nm_skpd'],  

      );
      $ii++;
    }

    echo json_encode($result);
    $query1->free_result(); 	   
  }
    
    function bulan() {
        for ($count = 1; $count <= 12; $count++)
        {
            $result[]= array(
                     'bln' => $count,
                     'nm_bulan' => $this->tukd_model->getBulan($count)
                     );    
        }
        echo json_encode($result);
    }

    
	function load_ttd($ttd){
    $kd_skpd = $this->session->userdata('kdskpd'); 		
    $sql = "SELECT * FROM ms_ttd WHERE kode='$ttd'";

        $mas = $this->db->query($sql);
        $result = array();
        $ii = 0;        
        foreach($mas->result_array() as $resulte)
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
        $mas->free_result();
    	   
	}
	
    function pgiat($cskpd='') {
        
        $sql = "SELECT DISTINCT kd_subkegiatan,nm_subkegiatan FROM trskpd WHERE kd_skpd = '$cskpd' AND jns_kegiatan = '5' GROUP BY kd_subkegiatan,nm_subkegiatan ORDER BY kd_subkegiatan";
        
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kd_subkegiatan' => $resulte['kd_subkegiatan'],  
                        'nm_subkegiatan' => $resulte['nm_subkegiatan'],  
                        );
                        $ii++;
        }
           
        echo json_encode($result);
    	   
	}

    function ld_rek($giat='') {
    
        $sql = " SELECT a.kd_rek6 as kd_rek6,b.nm_rek6 as nm_rek6 FROM trdrka a inner join ms_rek6 b on a.kd_rek6=b.kd_rek6 where a.kd_subkegiatan='$giat' order by a.kd_rek6 ";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kd_rek6' => $resulte['kd_rek6'],  
                        'nm_rek6' => $resulte['nm_rek6']
                       
                        );
                        $ii++;
        }
           
        echo json_encode($result);
     $query1->free_result();	   
	}
  
     function config_skpd(){
        $skpd     = $this->session->userdata('kdskpd');
        $sql = "SELECT a.kd_skpd,a.nm_skpd,b.status_rancang,b.statu,b.status_sempurna,b.status_ubah FROM  ms_skpd a LEFT JOIN trhrka b ON a.kd_skpd=b.kd_skpd WHERE a.kd_skpd = '$skpd'";
        $query1 = $this->db->query($sql);  
        
        $test = $query1->num_rows();
        
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
            $result = array(
                        'id' => $ii,        
                        'kd_skpd' => $resulte['kd_skpd'],
                        'nm_skpd' => $resulte['nm_skpd'],
                        'statu' => $resulte['statu'],
                        'status_ubah' => $resulte['status_ubah'],
                        'status_rancang' => $resulte['status_rancang'],
                        'status_sempurna' => $resulte['status_sempurna']
                        );
                        $ii++;
        }
        

        
        
        echo json_encode($result);
        $query1->free_result();   
    } 


    function ctk_rekap_pengeluaran_kasda_baru($print='', $ttd1='', $tgl=''){
    $idskpd = $this->session->userdata('kdskpd');
    $lcttd      = str_replace('123456789',' ',$this->uri->segment(5));
   // $thn_ang    = $this->session->userdata('pcThang');
    $prv        = $this->db->query("SELECT top 1 kab_kota,daerah,thn_ang from sclient");
    $prvn       = $prv->row();          
    $kab       = $prvn->kab_kota;         
    $daerah     = $prvn->daerah;
	$daerah     = $prvn->daerah;
	$thn_ang	= $prvn->thn_ang;
    //$jns_beban  = $this->uri->segment(3);
    $no_halaman = $this->uri->segment(8);
    $jns_cetak  = $this->uri->segment(7);
    $tgl_cetak  = $this->uri->segment(6);
    $tgl_cetak1 = $this->Mpublic->tanggal_format_indonesia($tgl_cetak);
    $spasi      = $this->uri->segment(9);
    $skpd       = $this->uri->segment(10);
    $tgl_per1   = $this->uri->segment(11);
    $tgl_per2   = $this->uri->segment(12);    
    
    $sqlttd1="SELECT TOP 1 nama as nm,nip as nip,jabatan as jab,pangkat FROM ms_ttd where kode='BUD' and nip='$lcttd'";
    $sqlttd=$this->db->query($sqlttd1);
     foreach ($sqlttd->result() as $rowttd)
      {
        $nip=$rowttd->nip;                    
        $nama= $rowttd->nm;
        $jabatan  = $rowttd->jab;
        $pangkat=$rowttd->pangkat;
      }    
    
     $judull = "REKAPITULASI KAS DIKAS DAERAH DAN KAS DI BENDAHARA PENGELUARAN";
     
     if($jns_cetak=='0'){
      $where2 = "";
     }else if($jns_cetak=='1'){
      $where2 = "AND a.kd_skpd='$skpd'";
      $pglskpd = $skpd;//$skpd.".00";
      $prvskpd    = $this->db->query("SELECT nm_skpd from ms_skpd where kd_skpd='$pglskpd'");
      $prvskpd2   = $prvskpd->row();          
      $nmmskpd    = $prvskpd2->nm_skpd;         
    
     }else{
       $where2 = "AND a.kd_skpd='$skpd'";
     }
    
	  $cRet = '';
    
      $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"1\" cellpadding=\"1\">";
	  
	  $cRet .="<tr>
					<td align=\"center\" colspan=\"7\" style=\"font-size:14px;border: solid 1px white;\"><b>$kab<br>$judull<br>TAHUN $thn_ang</b></td>            
			   </tr>";
     
     if($jns_cetak=="1"){   
      $cRet .="<tr>
				<td align=\"center\" colspan=\"7\" style=\"font-size:14px;border: solid 1px white;\"><b>".strtoupper($nmmskpd)."<br></b></td>            
				</tr>";
      }  

	  $cRet .="<tr>
					<td align=\"center\" colspan=\"7\" style=\"font-size:14px;border: solid 1px white;\"><b>".strtoupper($this->Mpublic->tanggal_format_indonesia($tgl_per1))." s/d ".strtoupper($this->Mpublic->tanggal_format_indonesia($tgl_per2))."</b></td>            
			   </tr>";
          
  
	 $cRet .="</table>";
		   
		   
	   
        $cRet .="<table style=\"border-collapse:collapse; border-color: black;font-size:12px\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"1\" cellpadding=\"$spasi\" >
        <thead>
       
       
        <tr>
          <td align=\"center\" rowspan=\"2\" bgcolor=\"#CCCCCC\" width=\"2%\" style=\"font-weight:bold;\">NO.</td>  
          <td align=\"center\" rowspan=\"2\" bgcolor=\"#CCCCCC\" width=\"8%\" style=\"font-weight:bold\">SKPD</td>
          <td align=\"center\" rowspan=\"2\" bgcolor=\"#CCCCCC\" width=\"7%\" style=\"font-weight:bold\">UP</td>
          <td align=\"center\" rowspan=\"2\" bgcolor=\"#CCCCCC\" width=\"8%\" style=\"font-weight:bold\">GU</td>
          <td align=\"center\" rowspan=\"2\" bgcolor=\"#CCCCCC\" width=\"8%\" style=\"font-weight:bold\">TU</td>
          <td align=\"center\" colspan=\"2\" bgcolor=\"#CCCCCC\" width=\"16%\" style=\"font-weight:bold\">BELANJA TIDAK LANGSUNG</td>
          <td align=\"center\" colspan=\"3\" bgcolor=\"#CCCCCC\" width=\"21%\" style=\"font-weight:bold\">BELANJA LANGSUNG</td>
          <td align=\"center\" rowspan=\"2\" bgcolor=\"#CCCCCC\" width=\"8%\" style=\"font-weight:bold\">KET</td>
        </tr>
        <tr>
          <td align=\"center\" bgcolor=\"#CCCCCC\" width=\"8%\" style=\"font-weight:bold;\">BTL GAJI</td>  
          <td align=\"center\" bgcolor=\"#CCCCCC\" width=\"8%\" style=\"font-weight:bold\">BTL NON GAJI</td>
          <td align=\"center\" bgcolor=\"#CCCCCC\" width=\"7%\" style=\"font-weight:bold\">PEGAWAI<br>(5.1.01)</td>
          <td align=\"center\" bgcolor=\"#CCCCCC\" width=\"7%\" style=\"font-weight:bold\">BARANG DAN JASA<br>(5.1.01)</td>
          <td align=\"center\" bgcolor=\"#CCCCCC\" width=\"7%\" style=\"font-weight:bold\">MODAL<br>(5.2)</td>
        </tr>
        <tr>
          <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"border-top:solid 1px black\">1</td>
          <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"border-top:solid 1px black\">2</td>
          <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"border-top:solid 1px black\">3</td>
          <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"border-top:solid 1px black\">4</td>
          <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"border-top:solid 1px black\">5</td>
          <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"border-top:solid 1px black\">6</td>
          <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"border-top:solid 1px black\">7</td>          
          <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"border-top:solid 1px black\">8</td>
          <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"border-top:solid 1px black\">9</td>
          <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"border-top:solid 1px black\">10</td>
          <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"border-top:solid 1px black\">11</td>
        </tr>";  
        
        $cRet .="</thead>";

          //isi
		$sql="select z.kd_skpd,v.nm_skpd,sum(z.up) as up,sum(z.gu) as gu,sum(z.tu) as tu,sum(z.btlgaji) as btlgaji,
				sum(z.btlnon) as btlnon,sum(z.ls_peg) as ls_peg,sum(z.ls_jasa) as ls_jasa,sum(z.ls_modal) as ls_modal from (
				SELECT a.kd_skpd as kd_skpd,
				(case when a.jns_spp=1 then sum(b.nilai) else 0  end)up,
				(case when a.jns_spp=2 then sum(b.nilai) else 0  end)gu,
				(case when a.jns_spp=3 then sum(b.nilai) else 0  end)tu,
				(case when a.jns_spp in (4,5) and left(b.kd_rek6,8) IN ('51010101','51010501','51010102','51010402','51010502','51010103','51010405','51010503','51010104','51010105','51010106','51010403','51010504','51010107','51010410','51010505','51010108','51010411','51010506') then sum(b.nilai) else 0  end)btlgaji,
				(case when a.jns_spp in (4,5) and left(b.kd_rek6,8) NOT IN ('51010101','51010501','51010102','51010402','51010502','51010103','51010405','51010503','51010104','51010105','51010106','51010403','51010504','51010107','51010410','51010505','51010108','51010411','51010506') then sum(b.nilai) else 0  end)btlnon,				
				(case when a.jns_spp=6 and left(b.kd_rek6,4) in ('5101') then sum(b.nilai) else 0  end)ls_peg,
				(case when a.jns_spp=6 and left(b.kd_rek6,4) in ('5102') then sum(b.nilai) else 0  end)ls_jasa,
				(case when a.jns_spp=6 and left(b.kd_rek6,2) in ('52') then sum(b.nilai) else 0  end)ls_modal		 
				 FROM TRHSP2D a 
				 inner join TRDSPP b on a.no_spp=b.no_spp and a.kd_skpd=b.kd_skpd 
				 where (a.sp2d_batal IS NULL  OR a.sp2d_batal !=1) 
					and a.status_bud=1 and (a.tgl_kas_bud>='$tgl_per1' and a.tgl_kas_bud<='$tgl_per2') $where2
				 group by a.kd_skpd,a.nm_skpd,a.jns_spp,b.kd_rek6

				)z left join ms_skpd v on v.kd_skpd = z.kd_skpd
				group by z.kd_skpd,v.nm_skpd
				order by z.kd_skpd,v.nm_skpd";
                
          $hasil = $this->db->query($sql);
          
          $total_up=0; $total_gu=0; $total_tu=0; $total_btlgaji=0; $total_btlnon=0;
          $total_lspeg=0; $total_lsjasa=0; $total_lsmodal=0;
          $no=0;
          
          foreach ($hasil->result() as $rowttd)
          {
            $kdskpd=$rowttd->kd_skpd;
            $nmskpd=$rowttd->nm_skpd;
            $n_up=$rowttd->up;
            $n_gu=$rowttd->gu;
            $n_tu=$rowttd->tu;
            $n_btglgaji=$rowttd->btlgaji;
            $n_btglnon=$rowttd->btlnon;
            $n_lspeg=$rowttd->ls_peg;
            $n_lsjasa=$rowttd->ls_jasa;
            $n_lsmodal=$rowttd->ls_modal;
            $no++;
            
            $total_up=$total_up+$n_up; $total_gu=$total_gu+$n_gu; $total_tu=$total_tu+$n_tu; 
            $total_btlgaji=$total_btlgaji+$n_btglgaji; $total_btlnon=$total_btlnon+$n_btglnon; 
            $total_lspeg=$total_lspeg+$n_lspeg; $total_lsjasa=$total_lsjasa+$n_lsjasa; $total_lsmodal=$total_lsmodal+$n_lsmodal;
            
            $cRet.="<tr>
          <td align=\"center\" style=\"border-top:solid 1px black\">$no</td>
          <td align=\"left\" style=\"border-top:solid 1px black\">$nmskpd</td>
          <td align=\"right\" style=\"border-top:solid 1px black\">".number_format($n_up,2)."</td>
          <td align=\"right\" style=\"border-top:solid 1px black\">".number_format($n_gu,2)."</td>
          <td align=\"right\" style=\"border-top:solid 1px black\">".number_format($n_tu,2)."</td>
          <td align=\"right\" style=\"border-top:solid 1px black\">".number_format($n_btglgaji,2)."</td>
          <td align=\"right\" style=\"border-top:solid 1px black\">".number_format($n_btglnon,2)."</td>          
          <td align=\"right\" style=\"border-top:solid 1px black\">".number_format($n_lspeg,2)."</td>
          <td align=\"right\" style=\"border-top:solid 1px black\">".number_format($n_lsjasa,2)."</td>
          <td align=\"right\" style=\"border-top:solid 1px black\">".number_format($n_lsmodal,2)."</td>
          <td align=\"right\" style=\"border-top:solid 1px black\"></td>
            </tr>";
                        
           }          
          
    $cRet.="<tr>
			  <td align=\"center\" colspan=\"2\" style=\"border-top:solid 1px black\">TOTAL</td>
			  <td align=\"right\" style=\"border-top:solid 1px black\">".number_format($total_up,2)."</td>
			  <td align=\"right\" style=\"border-top:solid 1px black\">".number_format($total_gu,2)."</td>
			  <td align=\"right\" style=\"border-top:solid 1px black\">".number_format($total_tu,2)."</td>
			  <td align=\"right\" style=\"border-top:solid 1px black\">".number_format($total_btlgaji,2)."</td>
			  <td align=\"right\" style=\"border-top:solid 1px black\">".number_format($total_btlnon,2)."</td>          
			  <td align=\"right\" style=\"border-top:solid 1px black\">".number_format($total_lspeg,2)."</td>
			  <td align=\"right\" style=\"border-top:solid 1px black\">".number_format($total_lsjasa,2)."</td>
			  <td align=\"right\" style=\"border-top:solid 1px black\">".number_format($total_lsmodal,2)."</td>
			  <td align=\"right\" style=\"border-top:solid 1px black\"></td>
				</tr>";
            
    $cRet .= "</table>";
  
    $cRet .="<table style=\"font-size:12px;border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
            <td align=\"center\" width=\"50%\">&nbsp;</td>
            <td align=\"center\" width=\"50%\">&nbsp;</td>
          </tr>
          <tr>
            <td align=\"center\" width=\"50%\">&nbsp;</td>
            <td align=\"center\" width=\"50%\">$daerah, $tgl_cetak1</td>
          </tr>
          <tr>
            <td align=\"center\" width=\"50%\">&nbsp;</td>
              <td align=\"center\" width=\"50%\">$jabatan</td>
          </tr>
                    <tr>
            <td align=\"center\" width=\"50%\">&nbsp;</td>
              <td align=\"center\" width=\"50%\">$pangkat</td>
          </tr>
                    <tr>
            <td align=\"center\" width=\"50%\">&nbsp;</td>
            <td align=\"center\" width=\"50%\">&nbsp;</td>
          </tr>
          <tr>
            <td align=\"center\" width=\"50%\">&nbsp;</td>
            <td align=\"center\" width=\"50%\">&nbsp;</td>
          </tr>                              
                    <tr>
            <td align=\"center\" width=\"50%\">&nbsp;</td>
            <td align=\"center\" width=\"50%\">&nbsp;</td>
          </tr>                                       
                    <tr>
            <td align=\"center\" width=\"50%\">&nbsp;</td>
            <td align=\"center\" width=\"50%\"><u>$nama</u></td>
          </tr>
          <tr>
            <td align=\"center\" width=\"50%\">&nbsp;</td>
            <td align=\"center\" width=\"50%\">NIP. $nip</td>
          </tr>
                    
        </table>";
            
    if($print==0){
       $data['prev']= $cRet;    
       echo ("<title></title>");
       echo $cRet;
    }else if($print==1){
			
			$this->Mpublic->_mpdf2('',$cRet,10,10,10,'1',$no_halaman,'');
			
		}else{
            $datax['prev']= $cRet;
            header("Cache-Control: no-cache, no-store, must-revalidate");
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename= Rekap Kas Per SKPD.xls");
            
            $this->load->view('anggaran/rka/perkadaII', $datax);
		}    
  }
 
  
  function ctk_rekap_pengeluaran_kasda_tgl($print='', $ttd1='', $tgl=''){
    $idskpd = $this->session->userdata('kdskpd');
    $lcttd      = str_replace('123456789',' ',$this->uri->segment(5));
   // $thn_ang    = $this->session->userdata('pcThang');
    $prv        = $this->db->query("SELECT top 1 kab_kota,daerah,thn_ang from sclient");
    $prvn       = $prv->row();          
    $kab       = $prvn->kab_kota;         
    $daerah     = $prvn->daerah;
	$thn_ang	= $prvn->thn_ang;
    //$jns_beban  = $this->uri->segment(3);
    $no_halaman = $this->uri->segment(8);
    $jns_cetak  = $this->uri->segment(7);
    $tgl_cetak  = $this->uri->segment(6);
    $tgl_cetak1 = $this->Mpublic->tanggal_format_indonesia($tgl_cetak);
    $spasi      = $this->uri->segment(9);
    $skpd       = $this->uri->segment(10);
    $tgl_per1   = $this->uri->segment(11);
    $tgl_per2   = $this->uri->segment(12);    
    
    $sqlttd1="SELECT TOP 1 nama as nm,nip as nip,jabatan as jab,pangkat FROM ms_ttd where kode='BUD' and nip='$lcttd'";
    $sqlttd=$this->db->query($sqlttd1);
     foreach ($sqlttd->result() as $rowttd)
      {
        $nip=$rowttd->nip;                    
        $nama= $rowttd->nm;
        $jabatan  = $rowttd->jab;
        $pangkat=$rowttd->pangkat;
      }    
    
     $judull = "REKAPITULASI KAS DIKAS DAERAH DAN KAS DI BENDAHARA PENGELUARAN";
     
     if($jns_cetak=='0'){
      $where2 = "";
     }else if($jns_cetak=='1'){
      $where2 = "AND a.kd_skpd='$skpd'";
      $pglskpd = $skpd;//.".00";
      $prvskpd    = $this->db->query("SELECT nm_skpd from ms_skpd where kd_skpd='$pglskpd'");
      $prvskpd2   = $prvskpd->row();          
      $nmmskpd    = $prvskpd2->nm_skpd;         
    
     }else{
       $where2 = "AND a.kd_skpd='$skpd'";
     }
    
   $cRet = '';
    
      $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"1\" cellpadding=\"1\">
        <tr>
          <td align=\"center\" colspan=\"7\" style=\"font-size:14px;border: solid 1px white;\"><b> $kab <br> $judull <br>TAHUN $thn_ang</b></td>            
        </tr>";
     
	 
     if($jns_cetak=="1"){   
			$cRet .="<tr>
					<td align=\"center\" colspan=\"7\" style=\"font-size:14px;border: solid 1px white;\"><b>".strtoupper($nmmskpd)."<br></b></td>            
				</tr>";
      }  


		$cRet .="<tr>
						<td align=\"center\" colspan=\"7\" style=\"font-size:14px;border: solid 1px white;\"><b>".strtoupper($this->Mpublic->tanggal_format_indonesia($tgl_per1))." s/d ".strtoupper($this->Mpublic->tanggal_format_indonesia($tgl_per2))."<br></b></td>            
					</tr>   
				</table>";
				
		$cRet .="<table style=\"border-collapse:collapse; border-color: black;font-size:12px\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"1\" cellpadding=\"$spasi\" >
					<thead>";
       
       
        $cRet .="<tr>
			  <td align=\"center\" rowspan=\"2\" bgcolor=\"#CCCCCC\" width=\"2%\" style=\"font-weight:bold;\">NO.</td>  
			  <td align=\"center\" rowspan=\"2\" bgcolor=\"#CCCCCC\" width=\"4%\" style=\"font-weight:bold\">TANGGAL</td>
			  <td align=\"center\" rowspan=\"2\" bgcolor=\"#CCCCCC\" width=\"7%\" style=\"font-weight:bold\">UP</td>
			  <td align=\"center\" rowspan=\"2\" bgcolor=\"#CCCCCC\" width=\"7%\" style=\"font-weight:bold\">GU</td>
			  <td align=\"center\" rowspan=\"2\" bgcolor=\"#CCCCCC\" width=\"7%\" style=\"font-weight:bold\">TU</td>
			  <td align=\"center\" colspan=\"7\" bgcolor=\"#CCCCCC\" width=\"21%\" style=\"font-weight:bold\">BELANJA TIDAK LANGSUNG</td>
			  <td align=\"center\" colspan=\"4\" bgcolor=\"#CCCCCC\" width=\"28%\" style=\"font-weight:bold\">BELANJA LANGSUNG</td>
			  <td align=\"center\" rowspan=\"2\" bgcolor=\"#CCCCCC\" width=\"7%\" style=\"font-weight:bold\">TOTAL</td>
			</tr>
			<tr>
			  <td align=\"center\" bgcolor=\"#CCCCCC\" width=\"7%\" style=\"font-weight:bold;\">GAJI</td>
			  <td align=\"center\" bgcolor=\"#CCCCCC\" width=\"7%\" style=\"font-weight:bold;\">NON GAJI</td>  
			  <td align=\"center\" bgcolor=\"#CCCCCC\" width=\"7%\" style=\"font-weight:bold\">HIBAH</td>          
			  <td align=\"center\" bgcolor=\"#CCCCCC\" width=\"7%\" style=\"font-weight:bold\">BANSOS</td>
			  <td align=\"center\" bgcolor=\"#CCCCCC\" width=\"7%\" style=\"font-weight:bold\">TIDAK TERDUGA</td>  
			  <td align=\"center\" bgcolor=\"#CCCCCC\" width=\"7%\" style=\"font-weight:bold\">PEMBIAYAAN</td>  
			  <td align=\"center\" bgcolor=\"#CCCCCC\" width=\"7%\" style=\"font-weight:bold\">JUMLAH</td> 
			  <td align=\"center\" bgcolor=\"#CCCCCC\" width=\"7%\" style=\"font-weight:bold;\">PEGAWAI</td>  
			  <td align=\"center\" bgcolor=\"#CCCCCC\" width=\"7%\" style=\"font-weight:bold\">BARANG JASA</td> 
			  <td align=\"center\" bgcolor=\"#CCCCCC\" width=\"7%\" style=\"font-weight:bold\">MODAL</td>
			  <td align=\"center\" bgcolor=\"#CCCCCC\" width=\"7%\" style=\"font-weight:bold\">JUMLAH</td>                            
			</tr>
			<tr>
			  <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"border-top:solid 1px black\">1</td>
			  <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"border-top:solid 1px black\">2</td>
			  <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"border-top:solid 1px black\">3</td>
			  <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"border-top:solid 1px black\">4</td>
			  <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"border-top:solid 1px black\">5</td>
			  <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"border-top:solid 1px black\">6</td>
			  <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"border-top:solid 1px black\">7</td>          
			  <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"border-top:solid 1px black\">8</td>
			  <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"border-top:solid 1px black\">9</td>
			  <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"border-top:solid 1px black\">10</td>                    
			  <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"border-top:solid 1px black\">11</td>
			  <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"border-top:solid 1px black\">12</td>
			  <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"border-top:solid 1px black\">13</td>          
			  <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"border-top:solid 1px black\">14</td>                    
			  <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"border-top:solid 1px black\">15</td>
			  <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"border-top:solid 1px black\">16</td>          
			  <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"border-top:solid 1px black\">17</td>
			</tr>";  
        
        $cRet .="</thead>";

          //isi
            $sql="select z.tgl_kas_bud,sum(z.up) as up,sum(z.gu) as gu,sum(z.tu) as tu,sum(z.btl_peg) as btl_peg,sum(z.btl_peg_non) as btl_peg_non,
            sum(z.btl_hibah) as btl_hibah,sum(z.btl_bansos) as btl_bansos,sum(z.btl_pemb) as btl_pemb,sum(z.ls_peg) as ls_peg,
            sum(z.ls_jasa) as ls_jasa,sum(z.ls_modal) as ls_modal,sum(z.ls_tt) as ls_tt from (
            SELECT a.kd_skpd as kd_skpd,a.tgl_kas_bud,
            (case when a.jns_spp=1 then sum(b.nilai) else 0  end)up,
            (case when a.jns_spp=2 then sum(b.nilai) else 0  end)gu,
            (case when a.jns_spp=3 then sum(b.nilai) else 0  end)tu,
            (case when a.jns_spp in (4) and left(b.kd_rek6,2) IN ('51') and left(b.kd_rek6,8) IN ('51010101','51010501','51010102','51010402','51010502','51010103','51010405','51010503','51010104','51010105','51010106','51010403','51010504','51010107','51010410','51010505','51010108','51010411','51010506') then sum(b.nilai) else 0  end) as btl_peg,
            (case when a.jns_spp in (4) and left(b.kd_rek6,2) IN ('51') and left(b.kd_rek6,8) NOT IN ('51010101','51010501','51010102','51010402','51010502','51010103','51010405','51010503','51010104','51010105','51010106','51010403','51010504','51010107','51010410','51010505','51010108','51010411','51010506') then sum(b.nilai) else 0  end) as btl_peg_non,
            (case when a.jns_spp in (5) and left(b.kd_rek6,4) IN ('5105') then sum(b.nilai) else 0  end) as btl_hibah,
            (case when a.jns_spp in (5) and left(b.kd_rek6,3) IN ('5106') then sum(b.nilai) else 0  end) as btl_bansos,
            (case when a.jns_spp in (5) and left(b.kd_rek6,2) IN ('72') then sum(b.nilai) else 0  end) as btl_pemb,
            (case when a.jns_spp=6 and left(b.kd_rek6,4) IN ('5101') then sum(b.nilai) else 0  end) as ls_peg,       
            (case when a.jns_spp=6 and left(b.kd_rek6,4) in ('5102') then sum(b.nilai) else 0  end) as ls_jasa,
            (case when a.jns_spp=6 and left(b.kd_rek6,2) in ('52') then sum(b.nilai) else 0  end) as ls_modal,
            (case when a.jns_spp=6 and left(b.kd_rek6,2) in ('53','54') then sum(b.nilai) else 0  end) as ls_tt
            FROM TRHSP2D a 
            inner join TRDSPP b on a.no_spp=b.no_spp and a.kd_skpd=b.kd_skpd 
            where (a.sp2d_batal IS NULL  OR a.sp2d_batal !=1) 
            and a.status_bud=1 and (a.tgl_kas_bud>='$tgl_per1' and a.tgl_kas_bud<='$tgl_per2') $where2
            group by a.kd_skpd,a.nm_skpd,a.tgl_kas_bud,a.jns_spp,b.kd_rek6     
)z left join ms_skpd v on v.kd_skpd = z.kd_skpd
group by z.tgl_kas_bud
order by z.tgl_kas_bud";
                
          $hasil = $this->db->query($sql);
          
          $total_up=0; $total_gu=0; $total_tu=0; $total_btlpeg=0; $total_btlpeg_non=0; $total_btlhibah=0; $total_btlbansos=0; $total_btlpemb=0; $total_btl=0;
          $total_lspeg=0; $total_lsjasa=0; $total_lsmodal=0; $total_bltt=0; $total_bl=0;
          $no=0;
          
          foreach ($hasil->result() as $rowttd)
          {
            $tgl_kas1=$rowttd->tgl_kas_bud;
            
            $tgl1 = explode("-",$tgl_kas1);
            $tgl_kas = $tgl1[2]."-".$tgl1[1]."-".$tgl1[0];
            
            //$nmskpd=$rowttd->nm_skpd;
            $n_up=$rowttd->up;
            $n_gu=$rowttd->gu;
            $n_tu=$rowttd->tu;
            $n_btl_peg=$rowttd->btl_peg;
            $n_btl_peg_non=$rowttd->btl_peg_non;
            $n_btl_hibah=$rowttd->btl_hibah;
            $n_btl_bansos=$rowttd->btl_bansos;
            $n_btl_pemb=$rowttd->btl_pemb;
            $n_ls_peg=$rowttd->ls_peg;
            $n_ls_jasa=$rowttd->ls_jasa;
            $n_ls_modal=$rowttd->ls_modal;
            $n_ls_tt=$rowttd->ls_tt;
            $no++;
            
            $total_up=$total_up+$n_up; 
            $total_gu=$total_gu+$n_gu; 
            $total_tu=$total_tu+$n_tu; 
            $total_btlpeg=$total_btlpeg+$n_btl_peg; 
            $total_btlpeg_non=$total_btlpeg_non+$n_btl_peg_non; 
            $total_btlhibah=$total_btlhibah+$n_btl_hibah; 
            $total_btlbansos=$total_btlbansos+$n_btl_bansos; 
            $total_btlpemb=$total_btlpemb+$n_btl_pemb; 

            $total_lspeg=$total_lspeg+$n_ls_peg;
            $total_lsjasa=$total_lsjasa+$n_ls_jasa;
            $total_lsmodal=$total_lsmodal+$n_ls_modal;
            $total_bltt=$total_bltt+$n_ls_tt;
            
        $cRet.="<tr>
          <td align=\"center\" style=\"border-top:solid 1px black\">$no</td>
          <td align=\"center\" style=\"border-top:solid 1px black\">$tgl_kas</td>
          <td align=\"right\" style=\"border-top:solid 1px black\">".number_format($n_up,2)."</td>
          <td align=\"right\" style=\"border-top:solid 1px black\">".number_format($n_gu,2)."</td>
          <td align=\"right\" style=\"border-top:solid 1px black\">".number_format($n_tu,2)."</td>
          <td align=\"right\" style=\"border-top:solid 1px black\">".number_format($n_btl_peg,2)."</td>
          <td align=\"right\" style=\"border-top:solid 1px black\">".number_format($n_btl_peg_non,2)."</td>
          <td align=\"right\" style=\"border-top:solid 1px black\">".number_format($n_btl_hibah,2)."</td>          
          <td align=\"right\" style=\"border-top:solid 1px black\">".number_format($n_btl_bansos,2)."</td>
          <td align=\"right\" style=\"border-top:solid 1px black\">".number_format($n_ls_tt,2)."</td>
          <td align=\"right\" style=\"border-top:solid 1px black\">".number_format($n_btl_pemb,2)."</td>
          <td align=\"right\" style=\"border-top:solid 1px black\">".number_format($n_btl_peg+$n_btl_peg_non+$n_btl_hibah+$n_btl_bansos+$n_ls_tt+$n_btl_pemb,2)."</td>  
          <td align=\"right\" style=\"border-top:solid 1px black\">".number_format($n_ls_peg,2)."</td> 
          <td align=\"right\" style=\"border-top:solid 1px black\">".number_format($n_ls_jasa,2)."</td> 
          <td align=\"right\" style=\"border-top:solid 1px black\">".number_format($n_ls_modal,2)."</td>
          <td align=\"right\" style=\"border-top:solid 1px black\">".number_format($n_ls_peg+$n_ls_jasa+$n_ls_modal,2)."</td>
          <td align=\"right\" style=\"border-top:solid 1px black\">".number_format($n_up+$n_gu+$n_tu+$n_btl_peg+$n_btl_peg_non+$n_btl_hibah+$n_btl_bansos+$n_ls_peg+$n_ls_jasa+$n_ls_modal+$n_ls_tt+$n_btl_pemb,2)."</td>
        </tr>";
                        
           }          
          
        $cRet.="<tr>
          <td align=\"center\" colspan=\"2\" style=\"border-top:solid 1px black\">TOTAL</td>
          <td align=\"right\" style=\"border-top:solid 1px black\">".number_format($total_up,2)."</td>
          <td align=\"right\" style=\"border-top:solid 1px black\">".number_format($total_gu,2)."</td>
          <td align=\"right\" style=\"border-top:solid 1px black\">".number_format($total_tu,2)."</td>
          <td align=\"right\" style=\"border-top:solid 1px black\">".number_format($total_btlpeg,2)."</td>
          <td align=\"right\" style=\"border-top:solid 1px black\">".number_format($total_btlpeg_non,2)."</td>
          <td align=\"right\" style=\"border-top:solid 1px black\">".number_format($total_btlhibah,2)."</td>
          <td align=\"right\" style=\"border-top:solid 1px black\">".number_format($total_btlbansos,2)."</td>
          <td align=\"right\" style=\"border-top:solid 1px black\">".number_format($total_bltt,2)."</td>
          <td align=\"right\" style=\"border-top:solid 1px black\">".number_format($total_btlpemb,2)."</td>
          <td align=\"right\" style=\"border-top:solid 1px black\">".number_format($total_btlpeg+$total_btlpeg_non+$total_btlhibah+$total_btlbansos+$total_bltt+$total_btlpemb,2)."</td>
          <td align=\"right\" style=\"border-top:solid 1px black\">".number_format($total_lspeg,2)."</td>
          <td align=\"right\" style=\"border-top:solid 1px black\">".number_format($total_lsjasa,2)."</td>
          <td align=\"right\" style=\"border-top:solid 1px black\">".number_format($total_lsmodal,2)."</td>
          <td align=\"right\" style=\"border-top:solid 1px black\">".number_format($total_lspeg+$total_lsjasa+$total_lsmodal,2)."</td>
          <td align=\"right\" style=\"border-top:solid 1px black\">".number_format($total_up+$total_gu+$total_tu+$total_btlpeg+$total_btlpeg_non+$total_btlhibah+$total_btlbansos+$total_lspeg+$total_lsjasa+$total_lsmodal+$total_bltt+$total_btlpemb,2)."</td>
        </tr>";
      
            
    $cRet .= "</table>";
  
    $cRet .="<table style=\"font-size:12px;border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
            <td align=\"center\" width=\"50%\">&nbsp;</td>
            <td align=\"center\" width=\"50%\">&nbsp;</td>
          </tr>
          <tr>
            <td align=\"center\" width=\"50%\">&nbsp;</td>
            <td align=\"center\" width=\"50%\">$daerah, $tgl_cetak1</td>
          </tr>
          <tr>
            <td align=\"center\" width=\"50%\">&nbsp;</td>
              <td align=\"center\" width=\"50%\">$jabatan</td>
          </tr>
                    <tr>
            <td align=\"center\" width=\"50%\">&nbsp;</td>
              <td align=\"center\" width=\"50%\">$pangkat</td>
          </tr>
                    <tr>
            <td align=\"center\" width=\"50%\">&nbsp;</td>
            <td align=\"center\" width=\"50%\">&nbsp;</td>
          </tr>
          <tr>
            <td align=\"center\" width=\"50%\">&nbsp;</td>
            <td align=\"center\" width=\"50%\">&nbsp;</td>
          </tr>                              
                    <tr>
            <td align=\"center\" width=\"50%\">&nbsp;</td>
            <td align=\"center\" width=\"50%\">&nbsp;</td>
          </tr>                                       
                    <tr>
            <td align=\"center\" width=\"50%\">&nbsp;</td>
            <td align=\"center\" width=\"50%\"><u>$nama</u></td>
          </tr>
          <tr>
            <td align=\"center\" width=\"50%\">&nbsp;</td>
            <td align=\"center\" width=\"50%\">NIP. $nip</td>
          </tr>
                    
                  </table>";
            
    if($print==0){
       $data['prev']= $cRet;    
       echo ("<title></title>");
       echo $cRet;
    }else if($print==1){
      
      $this->Mpublic->_mpdf2('',$cRet,10,10,10,'1',$no_halaman,'');
      
    }else{
            $datax['prev']= $cRet;
            header("Cache-Control: no-cache, no-store, must-revalidate");
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename= Rekap KAS per Tanggal.xls");
            
            $this->load->view('anggaran/rka/perkadaII', $datax);
    }    
  }
   

	
}	