<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class register_lpjController extends CI_Controller {

	function __construct()
	{	 
		parent::__construct();
		$this->load->model('public_model','public_model');	
	}  
	
	
    function index(){ 
        $data['page_title']= 'REGISTER L P J';
        $this->template->set('title', 'REGISTER L P J');   
        $this->template->load('template','tukd/register/lpj',$data); 			        
    }	

    
    function bulan() {
        for ($count = 1; $count <= 12; $count++)
        {
            $result[]= array(
                     'bln' => $count,
                     'nm_bulan' => $this->public_model->getBulan($count)
                     );    
        }
        echo json_encode($result);
    }
	
    function load_ttd_bud(){
      $kd_skpd = $this->session->userdata('kdskpd'); 
      $kdskpd = substr($kd_skpd,0,7);
      $sql = "SELECT * FROM ms_ttd WHERE kode='bud'";

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

   function skpd() {
        $lccr = $this->input->post('q');
        $sql = "SELECT kd_skpd,nm_skpd,'' jns FROM ms_skpd where upper(kd_skpd) like upper('%$lccr%') or upper(nm_skpd) like upper('%$lccr%') order by kd_skpd ";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kd_skpd' => $resulte['kd_skpd'],  
                        'nm_skpd' => $resulte['nm_skpd'],
                        'jns' => $resulte['jns']
                        );
                        $ii++;
        }
           
        echo json_encode($result);
            $query1->free_result();
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


    function cetak_register_lpjup($ttd='',$skpd='',$cbulan='',$cetak='',$tglcetak){ 
	$print = $cetak;    
	$tahun  = $this->session->userdata('pcThang');
	$bulan = $cbulan;
    $sqlsc="SELECT tgl_rka,provinsi,kab_kota,daerah,thn_ang FROM sclient";
                 $sqlsclient=$this->db->query($sqlsc);
                 foreach ($sqlsclient->result() as $rowsc)
                {
                    $kab     = $rowsc->kab_kota;
                    $daerah  = $rowsc->daerah;
                   
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
            <td align=\"center\" style=\"font-size:14px;border: solid 1px white;border-bottom:solid 1px white;\" colspan=\"11\"><b>DAFTAR LPJ TAHUN ANGGARAN $tahun</b></td>
        </tr>
        <tr>            
            <td align=\"center\" style=\"font-size:14px;border: solid 1px white;border-bottom:solid 1px black;\" colspan=\"11\"><b> $a $nama</b><br>&nbsp;</td>
        </tr>
        <tr>
            <td style=\"font-size:10px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"3%\" rowspan=\"1\"><b>No.<br>Urut</b></td>
            <td style=\"font-size:10px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"12%\" rowspan=\"1\"><b>No. LPJ</b></td>
			<td style=\"font-size:10px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"5%\" rowspan=\"1\"><b>Tanggal LPJ</b></td>
            <td style=\"font-size:10px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"5%\" rowspan=\"1\"><b>Tanggal Awal</b></td>
            <td style=\"font-size:10px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"5%\" rowspan=\"1\"><b>tanggal Akhir</b></td>
            <td style=\"font-size:10px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"15%\" rowspan=\"1\"><b>Nama SKPD</b></td>
			<td style=\"font-size:10px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"8%\" rowspan=\"1\"><b>Nilai LPJ</b></td>
            <td style=\"font-size:10px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"8%\" rowspan=\"1\"><b>Nilai Transaksi</b></td>            
            <td style=\"font-size:10px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"7%\" rowspan=\"1\"><b>Selisih</b></td>
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
            <td style=\"font-size:10px\" align=\"center\" ><b>9  (7 - 8 = 9)</b></td>            
            <td style=\"font-size:10px\" align=\"center\" ><b>10</b></td>
            <td style=\"font-size:10px\" align=\"center\" ><b>11</b></td>            
            <td style=\"font-size:10px\" align=\"center\" ><b>12</b></td>                        
            <td style=\"font-size:10px\" align=\"center\" ><b>13</b></td>
          </tr>";
       //$skpd = $this->uri->segment(3); 
        $kd_skpd = $skpd;
              
        $sql = "select x.*,x.nilai_lpj-x.nilai_transaksi as selisih from(
					select z.no_lpj,z.tgl_lpj,z.tgl_awal,z.tgl_akhir,z.kd_skpd,z.nm_skpd,
					z.nilai_lpj,
					(
					select 
					sum(b.nilai)
					from trhtransout a left join trdtransout b on b.kd_skpd=a.kd_skpd and b.no_bukti=a.no_bukti
					where a.kd_skpd=z.kd_skpd and a.tgl_bukti>=z.tgl_awal and a.tgl_bukti<=z.tgl_akhir and a.jns_spp='1'
					) as nilai_transaksi,
					z.no_sp2d,z.tgl_sp2d,z.status_lpj,z.ket_kode_skpd
					from (
					select a.no_lpj,a.tgl_lpj,a.tgl_awal,a.tgl_akhir,a.kd_skpd,c.nm_skpd,sum(b.nilai) as nilai_lpj, 
					e.no_sp2d,e.tgl_sp2d,(case when a.status <>'0' then 'Sudah di SAH kan' else 'Belum di SAH kan' end) as status_lpj,
					(case when b.kd_bp_skpd<>b.kd_skpd then 'Kode SKPD Belum Benar' else 'Kode SKPD Sudah Benar' end) as ket_kode_skpd
					from trhlpj a inner join trlpj b on a.no_lpj=b.no_lpj and a.kd_skpd=b.kd_skpd inner join ms_skpd c on c.kd_skpd=a.kd_skpd 
					inner join trhspp d on a.kd_skpd=d.kd_skpd and a.no_lpj=d.no_lpj inner join trhsp2d e on d.kd_skpd=e.kd_skpd and d.no_spp=e.no_spp 
					where jenis='1'
					group by a.no_lpj,a.tgl_lpj,a.tgl_awal,a.tgl_akhir,a.kd_skpd,c.nm_skpd,a.status,e.no_sp2d,b.kd_bp_skpd,b.kd_skpd,e.tgl_sp2d
					) z where month(z.tgl_lpj)<='$bulan' and z.kd_skpd='$kd_skpd'
					)x order by x.kd_skpd,month(x.tgl_lpj)";
									
                $hasil = $this->db->query($sql);
				$lcno = 0;
                $totallpj = 0;
                $totaltrans = 0;
                $totalselisih = 0;
                foreach ($hasil->result() as $row)
                {
                    $lpj= $row->no_lpj;
                    $tgl_lpj=$row->tgl_lpj;
                    $tgl_awal=$row->tgl_awal;
                    $tgl_akhir=$row->tgl_akhir;
                    $selisih=$row->selisih;
                    $skpd=$row->nm_skpd;
                    $nil_lpj= $row->nilai_lpj;                    
                    $nil_trans= $row->nilai_transaksi;
                    $sp2d= $row->no_sp2d;
					$tgl_sp2d=$row->tgl_sp2d;
					$stat_lpj= $row->status_lpj;
					$stat_kode= $row->ket_kode_skpd;
                    $lcno = $lcno + 1;
					
                    $cRet .=  "<tr>
								<td align=\"center\" style=\"font-size:12px\">$lcno</td>
                                <td align=\"left\" style=\"font-size:12px\">$lpj</td>
                                <td align=\"center\" style=\"font-size:12px\">".$this->public_model->tanggal_indonesia($tgl_lpj)."</td>
                                <td align=\"center\" style=\"font-size:12px\">".$this->public_model->tanggal_indonesia($tgl_awal)."</td>
                                <td align=\"center\" style=\"font-size:12px\">".$this->public_model->tanggal_indonesia($tgl_akhir)."</td>
								<td align=\"left\" style=\"font-size:12px\">$skpd</td>
                                <td align=\"right\" style=\"font-size:12px\">".number_format($nil_lpj,"2",".",",")."</td>                                
                                <td align=\"right\" style=\"font-size:12px\">".number_format($nil_trans,"2",".",",")."</td>
                                <td align=\"right\" style=\"font-size:12px\">".number_format($selisih,"2",".",",")."</td>
                                <td align=\"left\" style=\"font-size:12px\">$sp2d</td>
                                <td align=\"center\" style=\"font-size:12px\">".$this->public_model->tanggal_indonesia($tgl_sp2d)."</td>
                                <td align=\"left\" style=\"font-size:12px\">$stat_lpj</td>
                                <td align=\"left\" style=\"font-size:12px\">$stat_kode</td>
                              </tr>  "; 
                    $totallpj = $totallpj + $nil_lpj;
                    $totaltrans = $totaltrans + $nil_trans;
                    $totalselisih = $totalselisih + $selisih;
                }
                
                $cRet .=  "<tr>
								<td align=\"center\" colspan=\"6\" style=\"font-size:12px\"></td>
                                <td align=\"right\" style=\"font-size:12px\">".number_format($totallpj,"2",".",",")."</td>                                
                                <td align=\"right\" style=\"font-size:12px\">".number_format($totaltrans,"2",".",",")."</td>
                                <td align=\"right\" style=\"font-size:12px\">".number_format($totalselisih,"2",".",",")."</td>
                                <td align=\"left\" colspan=\"4\" style=\"font-size:12px\"></td>
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
		//	$daerah = $daerah ;
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
						<TD align="center" >'.$daerah.', '.$this->public_model->tanggal_format_indonesia($tglcetak).'</TD>
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
     

	function cetak_register_lpjtu($ttd='',$skpd='',$cbulan='',$cetak='',$tglcetak){ 
	$print = $cetak;    
	$tahun  = $this->session->userdata('pcThang');
	$bulan = $cbulan;
    $sqlsc="SELECT tgl_rka,provinsi,kab_kota,daerah,thn_ang FROM sclient";
                 $sqlsclient=$this->db->query($sqlsc);
                 foreach ($sqlsclient->result() as $rowsc)
                {
                    $kab     = $rowsc->kab_kota;
                    $daerah  = $rowsc->daerah;
                   
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
            <td align=\"center\" style=\"font-size:14px;border: solid 1px white;border-bottom:solid 1px white;\" colspan=\"11\"><b>DAFTAR LPJ TAHUN ANGGARAN $tahun</b></td>
        </tr>
        <tr>            
            <td align=\"center\" style=\"font-size:14px;border: solid 1px white;border-bottom:solid 1px black;\" colspan=\"11\"><b> $a $nama</b><br>&nbsp;</td>
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
					
                    $cRet .=  "<tr>
								<td align=\"center\" style=\"font-size:12px\">$lcno</td>
                                <td align=\"left\" style=\"font-size:12px\">$lpj</td>
                                <td align=\"center\" style=\"font-size:12px\">".$this->public_model->tanggal_indonesia($tgl_lpj)."</td>
								<td align=\"left\" style=\"font-size:12px\">$skpd</td>
                                <td align=\"right\" style=\"font-size:12px\">".number_format($nil_lpj,"2",".",",")."</td>
                                <td align=\"left\" style=\"font-size:12px\">$sp2d</td>
                                <td align=\"center\" style=\"font-size:12px\">".$this->public_model->tanggal_indonesia($tgl_sp2d)."</td>
                                <td align=\"right\" style=\"font-size:12px\">".number_format($nil_sp2d,"2",".",",")."</td>
                                <td align=\"right\" style=\"font-size:12px\">".number_format($nil_sisa,"2",".",",")."</td>
                                <td align=\"left\" style=\"font-size:12px\">$stat_lpj</td>
                                <td align=\"left\" style=\"font-size:12px\">$ket_cp</td>
                                <td align=\"left\" style=\"font-size:12px\">$stat_cp</td>
                              </tr>  "; 
                   
                }

			
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
		//	$tanggal_ttd = date('d-m-Y');
			
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
						<TD align="center" >'.$daerah.', '.$this->public_model->tanggal_format_indonesia($tglcetak).'</TD>
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


}	