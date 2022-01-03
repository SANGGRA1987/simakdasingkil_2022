<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class reg_lpjrekonController extends CI_Controller {

	function __construct()
	{	 
		parent::__construct();
		$this->load->model('public_model','Mpublic');	
	}  
	
	
    function index(){ 
        $data['page_title']= 'REKAP LAPORAN L P J';
        $this->template->set('title', 'REKAP LAPORAN  L P J');   
        $this->template->load('template','tukd/register/rekon_lpj',$data) ;  		        

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
	
	

function cetak_register_lpjtu_baru($ttd='',$skpd='',$cbulan='',$cetak='',$pilihan='',$tglttd=''){ 
	$print = $cetak;    
	$tahun  = $this->session->userdata('pcThang');
	$bulan = $cbulan;
	
	$skpdd = $this->uri->segment(5);
	
    $sqlsc="SELECT tgl_rka,provinsi,kab_kota,daerah,thn_ang FROM sclient";
                 $sqlsclient=$this->db->query($sqlsc);
                 foreach ($sqlsclient->result() as $rowsc)
                {
                    $kab     = $rowsc->kab_kota;
                    $daerah  = $rowsc->daerah;
                   
                }
	
$sqlscx="SELECT KD_SKPD,UPPER(NM_SKPD) NM_SKPD FROM MS_SKPD WHERE KD_SKPD ='$skpdd'";
                 $sqlsclient=$this->db->query($sqlscx);
                 foreach ($sqlsclient->result() as $rowsc)
                {
                    $skpdxx    = $rowsc->KD_SKPD;
                    $namaskpdxx  = $rowsc->NM_SKPD;
                   
                }	
				
				
				
                
        $kd ='';
        $a ='';
        $nama ='';
		$where2='';

        $cRet = "<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"1\" cellpadding=\"1\">";
        $cRet .="<thead>
        <tr>
            <td align=\"center\" style=\"font-size:14px;border: solid 1px white;border-bottom:solid 1px white;\" colspan=\"11\"><b>PEMERINTAHAN ".strtoupper($kab)."</b></td>            
        </tr>
        <tr>            
            <td align=\"center\" style=\"font-size:14px;border: solid 1px white;border-bottom:solid 1px white;\" colspan=\"11\"><b>REKAP LAPORAN PERTANGGUNGJAWABAN TAMBAH UANG TAHUN ANGGARAN $tahun</b></td>
        </tr>
        <tr>            
            <td align=\"center\" style=\"font-size:14px;border: solid 1px white;border-bottom:solid 1px black;\" colspan=\"11\"><b>PADA SKPD $skpdxx - $namaskpdxx</b><br>&nbsp;</td>
        </tr>
        <tr>
            <td style=\"font-size:10px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"3%\" rowspan=\"1\"><b>No.<br>Urut</b></td>
            <td style=\"font-size:10px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"15%\" rowspan=\"1\"><b>No. LPJ</b></td>
			<td style=\"font-size:10px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"5%\" rowspan=\"1\"><b>Tanggal LPJ</b></td>
            <td style=\"font-size:10px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"15%\" rowspan=\"1\"><b>Nama SKPD</b></td>
			<td style=\"font-size:10px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"10%\" rowspan=\"1\"><b>Nilai LPJ</b></td>
			<td style=\"font-size:10px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"10%\" rowspan=\"1\"><b>No. SP2D</b></td>
			<td style=\"font-size:10px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"5%\" rowspan=\"1\"><b>Tanggal SP2D</b></td>
			<td style=\"font-size:10px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"10%\" rowspan=\"1\"><b>Nilai SP2D</b></td>
			<td style=\"font-size:10px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"10%\" rowspan=\"1\"><b>Sisa</b></td>
			<td style=\"font-size:10px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"4%\" rowspan=\"1\"><b>Status LPJ</b></td>
			<td style=\"font-size:10px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"10%\" rowspan=\"1\"><b>Keterangan CP</b></td>
			<td style=\"font-size:10px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"13%\" rowspan=\"1\"><b>Status CP</b></td>
        </tr>   
          </thead>
          <tr>
            <td style=\"font-size:10px\" align=\"center\" ><b>1</b></td>
            <td style=\"font-size:10px\" align=\"center\" ><b>2</b></td>
            <td style=\"font-size:10px\" align=\"center\" ><b>3</b></td>
            <td style=\"font-size:10px\" align=\"center\" ><b>4</b></td>
            <td style=\"font-size:10px\" align=\"center\" ><b>5</b></td>
            <td style=\"font-size:10px\" align=\"center\" ><b>6</b></td>
            <td style=\"font-size:10px\" align=\"center\" ><b>7</b></td>
            <td style=\"font-size:10px\" align=\"center\" ><b>8</b></td>
            <td style=\"font-size:10px\" align=\"center\" ><b>9</b></td>
            <td style=\"font-size:10px\" align=\"center\" ><b>10</b></td>
            <td style=\"font-size:10px\" align=\"center\" ><b>11</b></td>
            <td style=\"font-size:10px\" align=\"center\" ><b>12</b></td>
          </tr>";
       //$skpd = $this->uri->segment(3); 
        $kd_skpd = $skpd;
              
        $sql = "select z.no_lpj,z.tgl_lpj,z.nm_skpd,z.nilai_lpj,z.no_sp2d,z.tgl_sp2d,z.nilai_sp2d,z.sisa,z.status_lpj,z.nilai_cp,z.status_cp from (
				select a.no_lpj,a.tgl_lpj,c.nm_skpd,sum(b.nilai) as nilai_lpj,c.no_sp2d,c.tgl_sp2d,c.nilai as nilai_sp2d,(c.nilai-sum(b.nilai)) as sisa,
				(case when a.status in ('1') then 'Sudah di SAH kan' else 'Belum di SAH kan' end) as status_lpj,
				(case when d.total=(c.nilai-sum(b.nilai)) then 'Sudah Sesuai Dengan Sisa TU' else 'Masih Belum Sesuai' end) as nilai_cp,
				(case when sum(b.nilai)=c.nilai then 'Tidak Ada Sisa' else 'Sudah Di Setor' end) as status_cp,a.kd_skpd
				from trhlpj a inner join trlpj b on a.kd_skpd=b.kd_skpd and a.no_lpj=b.no_lpj
				INNER JOIN trhsp2d c on a.no_sp2d=c.no_sp2d and a.kd_skpd=c.kd_skpd 
				inner join trhkasin_pkd d on a.kd_skpd=d.kd_skpd and a.no_sp2d=d.no_sp2d
				where c.jns_spp = '3'  
				GROUP BY a.no_lpj,a.tgl_lpj,c.nm_skpd,c.no_sp2d,c.tgl_sp2d,a.status,c.nilai,a.kd_skpd,d.total,a.kd_skpd
				union all
				select a.no_lpj,a.tgl_lpj,c.nm_skpd,sum(b.nilai) as nilai_lpj,c.no_sp2d,c.tgl_sp2d,c.nilai as nilai_sp2d,(c.nilai-sum(b.nilai)) as sisa,
				(case when a.status in ('1') then 'Sudah di SAH kan' else 'Belum di SAH kan' end) as status_lpj, 
				'' as nilai_cp,
				(case when sum(b.nilai)=c.nilai then 'Tidak Ada Sisa' else 'Belum Di Setor' end) as statu_cp,a.kd_skpd
				 from trhlpj a inner join trlpj b on a.kd_skpd=b.kd_skpd and a.no_lpj=b.no_lpj
				INNER JOIN trhsp2d c on a.no_sp2d=c.no_sp2d and a.kd_skpd=c.kd_skpd 
				where c.jns_spp = '3' and c.no_sp2d not in (select no_sp2d from trhkasin_pkd)
				GROUP BY a.no_lpj,a.tgl_lpj,c.nm_skpd,c.no_sp2d,c.tgl_sp2d,a.status,c.nilai,a.kd_skpd
				) z where month(z.tgl_lpj)<='$bulan' and z.kd_skpd='$kd_skpd'
				order by month(z.tgl_lpj)";
				
                $hasil = $this->db->query($sql);
				$lcno = 0;
				$jumlpj = 0;
				$jumsp2d = 0;
				$jumsisa = 0;
                foreach ($hasil->result() as $row)
                {
                    $lpj= $row->no_lpj;
                    $tgl_lpj=$row->tgl_lpj;
                    $skpd=$row->nm_skpd;
                    $nil_lpj= $row->nilai_lpj;
                    $sp2d= $row->no_sp2d;
					$tgl_sp2d=$row->tgl_sp2d;
					$nil_sp2d= $row->nilai_sp2d;
                    $nil_sisa= $row->sisa;
					$stat_lpj= $row->status_lpj;
					$ket_cp= $row->nilai_cp;
					$stat_cp= $row->status_cp;
                    $lcno = $lcno + 1;
					
					$jumlpj= $jumlpj+$nil_lpj;
					$jumsp2d= $jumsp2d+$nil_sp2d;
					$jumsisa= $jumsisa+$nil_sisa;
					
                    $cRet .=  "<tr>
								<td align=\"center\" style=\"font-size:12px\">$lcno</td>
                                <td align=\"left\" style=\"font-size:12px\">$lpj</td>
                                <td align=\"center\" style=\"font-size:12px\">".$this->Mpublic->tanggal_indonesia($tgl_lpj)."</td>
								<td align=\"left\" style=\"font-size:12px\">$skpd</td>
                                <td align=\"right\" style=\"font-size:12px\">".number_format($nil_lpj,"2",".",",")."</td>
                                <td align=\"left\" style=\"font-size:12px\">$sp2d</td>
                                <td align=\"center\" style=\"font-size:12px\">".$this->Mpublic->tanggal_indonesia($tgl_sp2d)."</td>
                                <td align=\"right\" style=\"font-size:12px\">".number_format($nil_sp2d,"2",".",",")."</td>
                                <td align=\"right\" style=\"font-size:12px\">".number_format($nil_sisa,"2",".",",")."</td>
                                <td align=\"left\" style=\"font-size:12px\">$stat_lpj</td>
                                <td align=\"left\" style=\"font-size:12px\">$ket_cp</td>
                                <td align=\"left\" style=\"font-size:12px\">$stat_cp</td>
                              </tr>  "; 
                   
                }

				
				$cRet .=  "<tr>
								<td align=\"right\" colspan=\"4\" style=\"font-size:12px\">JUMLAH</td>
                                <td align=\"right\" style=\"font-size:12px\">".number_format($jumlpj,"2",".",",")."</td>
                                <td colspan=\"2\" align=\"left\" style=\"font-size:12px\"></td>
                                <td align=\"right\" style=\"font-size:12px\">".number_format($jumsp2d,"2",".",",")."</td>
                                <td align=\"right\" style=\"font-size:12px\">".number_format($jumsisa,"2",".",",")."</td>
                                <td  colspan=\"3\" align=\"left\" style=\"font-size:12px\"></td>
                              </tr>  "; 
			
        $cRet .="</table>";
		
		$nip = str_replace('a',' ',$ttd);

 $sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab,pangkat FROM ms_ttd where nip='$nip' AND kode='BUD'";
                 $sqlttd=$this->db->query($sqlttd1);
                 foreach ($sqlttd->result() as $rowttd)
                {
                    $nip=$rowttd->nip;                    
                    $nama= $rowttd->nm;
                    $jabatan  = $rowttd->jab;
                    $pangkat  = $rowttd->pangkat;
                }
			//$tanggal_ttd = date('d-m-Y');
			
			$cRet .='<TABLE style="border-collapse:collapse; font-size:12px" width="100%" border="0" cellspacing="0" cellpadding="0" align=center>
					<TR>
						<TD width="50%" align="center" ><b>&nbsp;</TD>
						<TD width="50%" align="center" ><b>&nbsp;</TD>
					</TR>
					<TR>
						<TD width="50%" align="center" ><b>&nbsp;</TD>
						<TD width="50%" align="center" ><b>&nbsp;</TD>
					</TR>
                    <TR>
						<TD width="50%" align="center" ><b>&nbsp;</TD>
						<TD align="center" >'.$daerah.', '.$this->Mpublic->tanggal_format_indonesia($tglttd).'</TD>
					</TR>
					
                    <TR>
						<TD width="50%" align="center" ><b>&nbsp;</TD>
						<TD align="center" >'.$jabatan.'</TD>
					</TR>
                    <TR>
						<TD width="50%" align="center" ><b>&nbsp;</TD>
						<TD width="50%" align="center" ><b>&nbsp;</TD>
					</TR>
					<TR>
						<TD width="50%" align="center" ><b>&nbsp;</TD>
						<TD width="50%" align="center" ><b>&nbsp;</TD>
					</TR>
					<TR>
						<TD width="50%" align="center" ><b>&nbsp;</TD>
						<TD width="50%" align="center" ><b>&nbsp;</TD>
					</TR>
                    <TR>
						<TD width="50%" align="center" ><b>&nbsp;</TD>
						<TD align="center" ><b><u>'.$nama.'</u></b><br>'.$pangkat.'</TD>
					</TR>
                    <TR>
						<TD width="50%" align="center" ><b>&nbsp;</TD>
						<TD align="center" >'.$nip.'</TD>
					</TR>
					</TABLE><br/>';
		
        $data['prev']= $cRet;    
		if ($print==1){
				$this->rka_model->_mpdf_folio('',$cRet,10,10,10,'1'); 

		} else{
		echo ("<title>REGISTER LPJ TU</title>");
  	    echo $cRet;
		}
		//echo("$cRet");   
    }	
  
    function cetak_register_lpjup_baru($ttd='',$skpd='',$cbulan='',$cetak='',$pilihan='',$tglttd=''){ 
	$print = $cetak;    
	$tahun  = $this->session->userdata('pcThang');
	$bulan = $cbulan;
	
	$skpdd = $this->uri->segment(5);
	
    $sqlsc="SELECT tgl_rka,provinsi,kab_kota,daerah,thn_ang FROM sclient";
                 $sqlsclient=$this->db->query($sqlsc);
                 foreach ($sqlsclient->result() as $rowsc)
                {
                    $kab     = $rowsc->kab_kota;
                    $daerah  = $rowsc->daerah;
                   
                }
				
		$sqlsc="SELECT KD_SKPD,UPPER(NM_SKPD) NM_SKPD FROM MS_SKPD WHERE KD_SKPD ='$skpdd'";
                 $sqlsclient=$this->db->query($sqlsc);
                 foreach ($sqlsclient->result() as $rows)
                {
                    $skpdxx    = $rows->KD_SKPD;
                    $namaskpdxx  = $rows->NM_SKPD;
                   
                }	
                
        $kd ='';
        $a ='';
        $nama ='';
		$where2='';

        $cRet = "<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"1\" cellpadding=\"1\">";
        $cRet .="<thead>
        <tr>
            <td align=\"center\" style=\"font-size:14px;border: solid 1px white;border-bottom:solid 1px white;\" colspan=\"9\"><b>PEMERINTAHAN ".strtoupper($kab)."</b></td>            
        </tr>
        <tr>            
            <td align=\"center\" style=\"font-size:14px;border: solid 1px white;border-bottom:solid 1px white;\" colspan=\"9\"><b>REKAP LAPORAN PERTANGGUNGJAWABAN UANG PERSEDIAAN TAHUN ANGGARAN $tahun</b></td>
        </tr>
        <tr>            
            <td align=\"center\" style=\"font-size:14px;border: solid 1px white;border-bottom:solid 1px black;\" colspan=\"9\"><b>PADA SKPD $skpdxx - $namaskpdxx</b><br>&nbsp;</td>
        </tr>
        <tr>
            <td style=\"font-size:10px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"3%\" rowspan=\"1\"><b>No.<br>Urut</b></td>
            <td style=\"font-size:10px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"15%\" rowspan=\"1\"><b>No. LPJ</b></td>
			<td style=\"font-size:10px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"5%\" rowspan=\"1\"><b>Tanggal LPJ</b></td>
            <td style=\"font-size:10px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"15%\" rowspan=\"1\"><b>Nama SKPD</b></td>
			<td style=\"font-size:10px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"10%\" rowspan=\"1\"><b>Nilai LPJ</b></td>
			<td style=\"font-size:10px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"10%\" rowspan=\"1\"><b>No. SP2D</b></td>
			<td style=\"font-size:10px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"5%\" rowspan=\"1\"><b>Tanggal SP2D</b></td>
			<td style=\"font-size:10px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"4%\" rowspan=\"1\"><b>Status LPJ</b></td>
			<td style=\"font-size:10px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"10%\" rowspan=\"1\"><b>Keterangan Kode</b></td>
        </tr>   
          </thead>
          <tr>
            <td style=\"font-size:10px\" align=\"center\" ><b>1</b></td>
            <td style=\"font-size:10px\" align=\"center\" ><b>2</b></td>
            <td style=\"font-size:10px\" align=\"center\" ><b>3</b></td>
            <td style=\"font-size:10px\" align=\"center\" ><b>4</b></td>
            <td style=\"font-size:10px\" align=\"center\" ><b>5</b></td>
            <td style=\"font-size:10px\" align=\"center\" ><b>6</b></td>
            <td style=\"font-size:10px\" align=\"center\" ><b>7</b></td>
            <td style=\"font-size:10px\" align=\"center\" ><b>8</b></td>
            <td style=\"font-size:10px\" align=\"center\" ><b>9</b></td>
          </tr>";
       //$skpd = $this->uri->segment(3); 
        $kd_skpd = $skpd;
              
        $sql = "SELECT z.no_lpj,z.tgl_lpj,z.nm_skpd,z.nilai_lpj,z.no_sp2d,z.tgl_sp2d,z.status_lpj,z.ket_kode_skpd from (
				select a.no_lpj,a.tgl_lpj,a.kd_skpd,c.nm_skpd,sum(b.nilai) as nilai_lpj, 
				e.no_sp2d,e.tgl_sp2d,(case when a.status <>'0' then 'Sudah di SAH kan' else 'Belum di SAH kan' end) as status_lpj,
				(case when b.kd_bp_skpd<>b.kd_skpd then 'Data SKPD Belum Benar' else 'Data SKPD Sudah Benar' end) as ket_kode_skpd
				 from trhlpj a inner join trlpj b on a.no_lpj=b.no_lpj and a.kd_skpd=b.kd_skpd inner join ms_skpd c on c.kd_skpd=a.kd_skpd 
				 inner join trhspp d on a.kd_skpd=d.kd_skpd and a.no_lpj=d.no_lpj inner join trhsp2d e on d.kd_skpd=e.kd_skpd and d.no_spp=e.no_spp 
				where jenis='1'
				group by a.no_lpj,a.tgl_lpj,a.kd_skpd,c.nm_skpd,a.status,e.no_sp2d,b.kd_bp_skpd,b.kd_skpd,e.tgl_sp2d
				) z where month(z.tgl_lpj)<='$bulan' and z.kd_skpd='$kd_skpd'
				order by z.kd_skpd,month(z.tgl_lpj)";
				
                $hasil = $this->db->query($sql);
				$lcno = 0;
				$nil_lpjx = 0;
				
                foreach ($hasil->result() as $row)
                {
                    $lpj= $row->no_lpj;
                    $tgl_lpj=$row->tgl_lpj;
                    $skpd=$row->nm_skpd;
                    $nil_lpj= $row->nilai_lpj;
                    $sp2d= $row->no_sp2d;
					$tgl_sp2d=$row->tgl_sp2d;
					$stat_lpj= $row->status_lpj;
					$stat_kode= $row->ket_kode_skpd;
                    $lcno = $lcno + 1;
					
					$nil_lpjx= $nil_lpjx+$nil_lpj;
					
                    $cRet .=  "<tr>
								<td align=\"center\" style=\"font-size:12px\">$lcno</td>
                                <td align=\"left\" style=\"font-size:12px\">$lpj</td>
                                <td align=\"center\" style=\"font-size:12px\">".$this->Mpublic->tanggal_indonesia($tgl_lpj)."</td>
								<td align=\"left\" style=\"font-size:12px\">$skpd</td>
                                <td align=\"right\" style=\"font-size:12px\">".number_format($nil_lpj,"2",".",",")."</td>
                                <td align=\"left\" style=\"font-size:12px\">$sp2d</td>
                                <td align=\"center\" style=\"font-size:12px\">".$this->Mpublic->tanggal_indonesia($tgl_sp2d)."</td>
                                <td align=\"left\" style=\"font-size:12px\">$stat_lpj</td>
                                <td align=\"left\" style=\"font-size:12px\">$stat_kode</td>
                              </tr>  "; 
                   
                }

				
					$cRet .=  "<tr>
								<td colspan=\"4\" align=\"right\" style=\"font-size:12px\">JUMLAH</td>
                                <td align=\"right\" style=\"font-size:12px\">".number_format($nil_lpjx,"2",".",",")."</td>
                                <td colspan=\"4\" align=\"left\" style=\"font-size:12px\"></td>
                              </tr>  "; 
			
        $cRet .="</table>";
		
		$nip = str_replace('a',' ',$ttd);

 $sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab,pangkat FROM ms_ttd where nip='$nip' AND kode='BUD'";
                 $sqlttd=$this->db->query($sqlttd1);
                 foreach ($sqlttd->result() as $rowttd)
                {
                    $nip=$rowttd->nip;                    
                    $nama= $rowttd->nm;
                    $jabatan  = $rowttd->jab;
                    $pangkat  = $rowttd->pangkat;
                }
			//$tanggal_ttd = date('d-m-Y');
			
			$cRet .='<TABLE style="border-collapse:collapse; font-size:12px" width="100%" border="0" cellspacing="0" cellpadding="0" align=center>
					<TR>
						<TD width="50%" align="center" ><b>&nbsp;</TD>
						<TD width="50%" align="center" ><b>&nbsp;</TD>
					</TR>
					<TR>
						<TD width="50%" align="center" ><b>&nbsp;</TD>
						<TD width="50%" align="center" ><b>&nbsp;</TD>
					</TR>
                    <TR>
						<TD width="50%" align="center" ><b>&nbsp;</TD>
						<TD align="center" >'.$daerah.', '.$this->Mpublic->tanggal_format_indonesia($tglttd).'</TD>
					</TR>
					
                    <TR>
						<TD width="50%" align="center" ><b>&nbsp;</TD>
						<TD align="center" >'.$jabatan.'</TD>
					</TR>
                    <TR>
						<TD width="50%" align="center" ><b>&nbsp;</TD>
						<TD width="50%" align="center" ><b>&nbsp;</TD>
					</TR>
					<TR>
						<TD width="50%" align="center" ><b>&nbsp;</TD>
						<TD width="50%" align="center" ><b>&nbsp;</TD>
					</TR>
					<TR>
						<TD width="50%" align="center" ><b>&nbsp;</TD>
						<TD width="50%" align="center" ><b>&nbsp;</TD>
					</TR>
                    <TR>
						<TD width="50%" align="center" ><b>&nbsp;</TD>
						<TD align="center" ><b><u>'.$nama.'</u></b><br>'.$pangkat.'</TD>
					</TR>
                    <TR>
						<TD width="50%" align="center" ><b>&nbsp;</TD>
						<TD align="center" >'.$nip.'</TD>
					</TR>
					</TABLE><br/>';
		
        $data['prev']= $cRet;    
		if ($print==1){
				$this->rka_model->_mpdf_folio('',$cRet,10,10,10,'1'); 

		} else{
		echo ("<title>REGISTER LPJ UP</title>");
  	    echo $cRet;
		}
		//echo("$cRet");   
    }	
   

	
}	