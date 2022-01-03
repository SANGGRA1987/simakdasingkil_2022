<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class register_bast_budController extends CI_Controller {

	function __construct()
	{	 
		parent::__construct();
    
	}  
	
	
    function index(){ 
        $data['page_title']= 'REGISTER PENAGIHAN';
        $this->template->set('title', 'REGISTER PENAGIHAN');   
        $this->template->load('template','tukd/register/cek_bast',$data); 

    }	

      function  tanggal_format_indonesia($tgl){
        $tanggal  = explode('-',$tgl); 
        $bulan  = $this-> getBulan($tanggal[1]);
        $tahun  =  $tanggal[0];
        return  $tanggal[2].' '.$bulan.' '.$tahun;

        }
         
		function  tanggal_format_indonesia_kasda($tgl){
			$tanggal  = explode('-',$tgl); 
			$bulan  = $this-> getBulan_kasda($tanggal[1]);
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
	
		 
        function  tanggal_indonesia($tgl){
        $tanggal  =  substr($tgl,8,2);
        $bulan  = substr($tgl,5,2);
        $tahun  =  substr($tgl,0,4);
        return  $tanggal.'-'.$bulan.'-'.$tahun;
		}

   function skpduser() {
        $lccr = $this->input->post('q');
        $id  = $this->session->userdata('pcUser');
        $sql = "SELECT kd_skpd,nm_skpd FROM ms_skpd where (upper(kd_skpd) like upper('%$lccr%') or upper(nm_skpd) like upper('%$lccr%')) and 
                kd_skpd IN (SELECT kd_skpd FROM user_bud WHERE user_id='$id') order by kd_skpd ";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kd_skpd' => $resulte['kd_skpd'],  
                        'nm_skpd' => $resulte['nm_skpd']
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
   

	function cetak_register_cek_bast($ttd='',$skpd='',$cbulan='',$cetak='',$jns_beban=''){ 
	
	$print = $cetak;    
	$tahun  = $this->session->userdata('pcThang');
	$bulan = $cbulan;
	$ali = $this->uri->segment(8);
	$tglttd = $this->uri->segment(9);
	

	
    $sqlsc="SELECT tgl_rka,provinsi,kab_kota,daerah,thn_ang FROM sclient";
                 $sqlsclient=$this->db->query($sqlsc);
                 foreach ($sqlsclient->result() as $rowsc)
                {
                    $kab     = $rowsc->kab_kota;
                    $daerah  = $rowsc->daerah;
                   
                }
 
    $sqlss="SELECT nm_skpd FROM ms_skpd where kd_skpd='$skpd' ";
                 $sqlsclient=$this->db->query($sqlss);
                 foreach ($sqlsclient->result() as $rowsc)
                {
                    $nama     = $rowsc->nm_skpd;
                   
                }
				
        $modtahun= $tahun%4;
	 
	 if ($modtahun = 0){
        $nilaibulan=".31 JANUARI.29 FEBRUARI.31 MARET.30 APRIL.31 MEI.30 JUNI.31 JULI.31 AGUSTUS.30 SEPTEMBER.31 OKTOBER.30 NOVEMBER.31 DESEMBER";}
            else {
        $nilaibulan=".31 JANUARI.28 FEBRUARI.31 MARET.30 APRIL.31 MEI.30 JUNI.31 JULI.31 AGUSTUS.30 SEPTEMBER.31 OKTOBER.30 NOVEMBER.31 DESEMBER";}
	 
	 $arraybulan=explode(".",$nilaibulan);

        $cRet = "<table style=\"border-collapse:collapse;\" width=\"120%\" align=\"center\" border=\"1\" cellspacing=\"1\" cellpadding=\"1\">";
        $cRet .="<thead>
        <tr>
            <td align=\"center\" style=\"font-size:14px;border: solid 1px white;border-bottom:solid 1px white;\" colspan=\"14\"><b>PEMERINTAHAN ".strtoupper($kab)."</b></td>            
        </tr>
        <tr>            
            <td align=\"center\" style=\"font-size:14px;border: solid 1px white;border-bottom:solid 1px white;\" colspan=\"14\"><b>RINCIAN BAST ATAS SPP DAN SP2D $tahun</b></td>
        </tr>
        <tr>            
            <td align=\"center\" style=\"font-size:14px;border: solid 1px white;border-bottom:solid 1px white;\" colspan=\"14\"><b> $nama</b></td>
        </tr>
        <tr>            
            <td align=\"center\" style=\"font-size:14px;border: solid 1px white;border-bottom:solid 1px black;\" colspan=\"14\"><b> $arraybulan[$bulan] $tahun</b><br>&nbsp;</td>
        </tr>
        <tr>
            <td style=\"font-size:10px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"3%\" rowspan=\"1\"><b>No.<br>Urut</b></td>
            <td style=\"font-size:10px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"15%\" rowspan=\"1\"><b>Nomor Penagihan</b></td>
			<td style=\"font-size:10px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"5%\" rowspan=\"1\"><b>Tanggal Penagihan</b></td>
            <td style=\"font-size:10px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"5%\" rowspan=\"1\"><b>Nomor  Kontrak</b></td>
			<td style=\"font-size:10px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"5%\" rowspan=\"1\"><b>Nomor SP2D</b></td>
			<td style=\"font-size:10px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"5%\" rowspan=\"1\"><b>Tanggal SP2D</b></td>
			<td style=\"font-size:10px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"10%\" rowspan=\"1\"><b>Keterangan</b></td>
			<td style=\"font-size:10px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"10%\" rowspan=\"1\"><b>Jenis Penagihan</b></td>
			<td style=\"font-size:10px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"10%\" rowspan=\"1\"><b>Kode Kegiatan</b></td>
			<td style=\"font-size:10px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"10%\" rowspan=\"1\"><b>Nama Kegiatan</b></td>
			<td style=\"font-size:10px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"5%\" rowspan=\"1\"><b>Kode Rekening</b></td>
			<td style=\"font-size:10px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"10%\" rowspan=\"1\"><b>Nama Rekening</b></td>
			<td style=\"font-size:10px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"10%\" rowspan=\"1\"><b>Nilai</b></td>
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
            <td style=\"font-size:10px\" align=\"center\" ><b>13</b></td>
          </tr>";
       //$skpd = $this->uri->segment(3); 
        $kd_skpd = $skpd;
		
		if ($ali == 1){             
       
	   $sql = "SELECT
	*
FROM
	(
		SELECT
			a.no_bukti,
			a.tgl_bukti,
			a.kontrak,
			'TIDAK DI JADIKAN DASAR SPP' no_sp2d,
			'' tgl_sp2d,
			a.ket,
			(
				CASE
				WHEN a.jenis = '' THEN
					'TANPA TERMIN / SEKALI PEMBAYARAN'
				WHEN a.jenis = '5' THEN
					'BAST 95% dan 5%'
				WHEN a.jenis = '4' THEN
					'UANG MUKA TERMIN'
				WHEN a.jenis = '2' THEN
					'UANG MUKA LUNAS'
				WHEN a.jenis = '1' THEN
					'TERMIN'
				END
			) AS jns,
			b.kd_subkegiatan,
			b.nm_subkegiatan,
			b.kd_rek,
			b.nm_rek6,
			SUM (b.nilai) AS jml
		FROM
			trhtagih a
		LEFT JOIN trdtagih b ON a.kd_skpd = b.kd_skpd
		AND a.no_bukti = b.no_bukti
		WHERE
			LEFT (b.kd_rek, 2) NOT IN ('52')
		AND MONTH (a.tgl_bukti) <= '$cbulan'
		AND  (a.kd_skpd) =  ('$skpd')
		AND a.no_bukti NOT IN (
			SELECT
				no_tagih
			FROM
				trhspp
			WHERE
				 (kd_skpd) =  ('$skpd')
		)
		GROUP BY
			a.no_bukti,
			a.tgl_bukti,
			a.kontrak,
			a.ket,
			a.jenis,
			b.kd_subkegiatan,
			b.nm_subkegiatan,
			b.kd_rek,
			b.nm_rek6
		UNION ALL
			SELECT
				a.no_bukti,
				a.tgl_bukti,
				c.kontrak,
				d.no_sp2d,
				d.tgl_sp2d,
				a.ket,
				(
					CASE
					WHEN a.jenis = '' THEN
						'TANPA TERMIN / SEKALI PEMBAYARAN'
					WHEN a.jenis = '5' THEN
						'BAST 95% dan 5%'
					WHEN a.jenis = '4' THEN
						'UANG MUKA TERMIN'
					WHEN a.jenis = '2' THEN
						'UANG MUKA LUNAS'
					WHEN a.jenis = '1' THEN
						'TERMIN'
					END
				) AS jns,
				b.kd_subkegiatan,
				b.nm_subkegiatan,
				b.kd_rek,
				b.nm_rek6,
				SUM (b.nilai) AS jml
			FROM
				trhtagih a
			LEFT JOIN trdtagih b ON a.kd_skpd = b.kd_skpd
			AND a.no_bukti = b.no_bukti
			LEFT JOIN trhspp c ON a.kd_skpd = c.kd_skpd
			AND a.no_bukti = c.no_tagih
			LEFT JOIN trhsp2d d ON a.kd_skpd = d.kd_skpd
			AND c.no_spp = d.no_spp
			WHERE
				c.jns_spp = '6'
			AND c.jns_beban = '3'
			AND LEFT (b.kd_rek, 2) NOT IN ('52')
			AND MONTH (a.tgl_bukti) <= '$cbulan'
			AND  (a.kd_skpd) =  ('$skpd')
			GROUP BY
				a.no_bukti,
				a.tgl_bukti,
				c.kontrak,
				d.no_sp2d,
				d.tgl_sp2d,
				a.ket,
				a.jenis,
				b.kd_subkegiatan,
				b.nm_subkegiatan,
				b.kd_rek,
				b.nm_rek6
						) z
				ORDER BY
				z.no_bukti,
				z.tgl_bukti"; 
				}else{ 
				
				$sql = "SELECT
							*
						FROM
	(
		SELECT
			a.no_bukti,
			a.tgl_bukti,
			a.kontrak,
			'TIDAK DI JADIKAN DASAR SPP' no_sp2d,
			'' tgl_sp2d,
			a.ket,
			(
				CASE
				WHEN a.jenis = '' THEN
					'TANPA TERMIN / SEKALI PEMBAYARAN'
				WHEN a.jenis = '5' THEN
					'BAST 95% dan 5%'
				WHEN a.jenis = '4' THEN
					'UANG MUKA TERMIN'
				WHEN a.jenis = '2' THEN
					'UANG MUKA LUNAS'
				WHEN a.jenis = '1' THEN
					'TERMIN'
				END
			) AS jns,
			b.kd_subkegiatan,
			b.nm_subkegiatan,
			b.kd_rek,
			b.nm_rek6,
			SUM (b.nilai) AS jml
		FROM
			trhtagih a
		LEFT JOIN trdtagih b ON a.kd_skpd = b.kd_skpd
		AND a.no_bukti = b.no_bukti
		WHERE
			LEFT (b.kd_rek, 2) IN ('52')
		AND MONTH (a.tgl_bukti) <= '$cbulan'
		AND  (a.kd_skpd) =  ('$skpd')
		AND a.no_bukti NOT IN (
			SELECT
				no_tagih
			FROM
				trhspp
			WHERE
				 (kd_skpd) =  ('$skpd')
		)
		GROUP BY
			a.no_bukti,
			a.tgl_bukti,
			a.kontrak,
			a.ket,
			a.jenis,
			b.kd_subkegiatan,
			b.nm_subkegiatan,
			b.kd_rek,
			b.nm_rek6
		UNION ALL
			SELECT
				a.no_bukti,
				a.tgl_bukti,
				c.kontrak,
				d.no_sp2d,
				d.tgl_sp2d,
				a.ket,
				(
					CASE
					WHEN a.jenis = '' THEN
						'TANPA TERMIN / SEKALI PEMBAYARAN'
					WHEN a.jenis = '5' THEN
						'BAST 95% dan 5%'
					WHEN a.jenis = '4' THEN
						'UANG MUKA TERMIN'
					WHEN a.jenis = '2' THEN
						'UANG MUKA LUNAS'
					WHEN a.jenis = '1' THEN
						'TERMIN'
					END
				) AS jns,
				b.kd_subkegiatan,
				b.nm_subkegiatan,
				b.kd_rek,
				b.nm_rek6,
				SUM (b.nilai) AS jml
			FROM
				trhtagih a
			LEFT JOIN trdtagih b ON a.kd_skpd = b.kd_skpd
			AND a.no_bukti = b.no_bukti
			LEFT JOIN trhspp c ON a.kd_skpd = c.kd_skpd
			AND a.no_bukti = c.no_tagih
			LEFT JOIN trhsp2d d ON a.kd_skpd = d.kd_skpd
			AND c.no_spp = d.no_spp
			WHERE
				c.jns_spp = '6'
			AND c.jns_beban = '3'
			AND LEFT (b.kd_rek, 2) IN ('52')
			AND MONTH (a.tgl_bukti) <= '$cbulan'
			AND  (a.kd_skpd) =  ('$skpd')
			GROUP BY
				a.no_bukti,
				a.tgl_bukti,
				c.kontrak,
				d.no_sp2d,
				d.tgl_sp2d,
				a.ket,
				a.jenis,
				b.kd_subkegiatan,
				b.nm_subkegiatan,
				b.kd_rek,
				b.nm_rek6
						) z
				ORDER BY
				z.no_bukti,
				z.tgl_bukti"; 
				}		
							
                $hasil = $this->db->query($sql);
				$lcno = 0;
                foreach ($hasil->result() as $row)
                {
                    $no_bukti= $row->no_bukti;
                    $tgl_bukti= $row->tgl_bukti;
                    $kontrak= $row->kontrak;
                    $no_sp2d= $row->no_sp2d;
                    $tgl_sp2d= $row->tgl_sp2d;
                    $ket= $row->ket;
                    $jns= $row->jns;
                    $kd_subkegiatan= $row->kd_subkegiatan;
                    $nm_subkegiatan= $row->nm_subkegiatan;
                    $kd_rek= $row->kd_rek;
                    $nm_rek6= $row->nm_rek6;
                    $nilai= $row->jml;
                    $lcno = $lcno + 1;
					
                    $cRet .=  "<tr>
								<td align=\"center\" style=\"font-size:12px\">$lcno</td>
                                <td align=\"center\" style=\"font-size:12px\">$no_bukti</td>
                                <td align=\"center\" style=\"font-size:12px\">".$this->tanggal_indonesia($tgl_bukti)."</td>
                                <td align=\"center\" style=\"font-size:12px\">$kontrak</td>
                                <td align=\"center\" style=\"font-size:12px\">$no_sp2d</td>
                                <td align=\"center\" style=\"font-size:12px\">".$this->tanggal_indonesia($tgl_sp2d)."</td>
                                <td align=\"center\" style=\"font-size:12px\">$ket</td>
                                <td align=\"center\" style=\"font-size:12px\">$jns</td>
                                <td align=\"center\" style=\"font-size:12px\">$kd_subkegiatan</td>
                                <td align=\"center\" style=\"font-size:12px\">$nm_subkegiatan</td>
                                <td align=\"center\" style=\"font-size:12px\">$kd_rek</td>
                                <td align=\"center\" style=\"font-size:12px\">$nm_rek6</td>
                                <td align=\"right\" style=\"font-size:12px\">".number_format($nilai,"2",".",",")."</td>
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
			//$tanggal_ttd = date('d-m-Y');
		//	$tanggal_ttd = date('Y-m-d');
			$daerah = $daerah;
			$cRet .='<TABLE style="border-collapse:collapse; font-size:12px" width="120%" border="0" cellspacing="0" cellpadding="0" align=center>
					<TR>
						<TD width="60%" align="center" ><b>&nbsp;</TD>
						<TD width="60%" align="center" ><b>&nbsp;</TD>
					</TR>
					<TR>
						<TD width="60%" align="center" ><b>&nbsp;</TD>
						<TD width="60%" align="center" ><b>&nbsp;</TD>
					</TR>
                    <TR>
						<TD width="60%" align="center" ><b>&nbsp;</TD> 
						<TD align="center" >'.$daerah.', '.$this->tanggal_format_indonesia($tglttd).'</TD>
					</TR>
					
                    <TR>
						<TD width="60%" align="center" ><b>&nbsp;</TD>
						<TD align="center" >'.$jabatan.'</TD>
					</TR>
                    <TR>
						<TD width="60%" align="center" ><b>&nbsp;</TD>
						<TD width="60%" align="center" ><b>&nbsp;</TD>
					</TR>
					<TR>
						<TD width="60%" align="center" ><b>&nbsp;</TD>
						<TD width="60%" align="center" ><b>&nbsp;</TD>
					</TR>
					<TR>
						<TD width="60%" align="center" ><b>&nbsp;</TD>
						<TD width="60%" align="center" ><b>&nbsp;</TD>
					</TR>
                    <TR>
						<TD width="60%" align="center" ><b>&nbsp;</TD>
						<TD align="center" ><b><u>'.$nama.'</u></b><br>'.$pangkat.'</TD>
					</TR>
                    <TR>
						<TD width="60%" align="center" ><b>&nbsp;</TD>
						<TD align="center" >'.$nip.'</TD>
					</TR>
					</TABLE><br/>';
		
        $data['prev']= $cRet;    
		if ($print==1){
				$this->rka_model->_mpdf_folio('',$cRet,10,10,10,'$skpd'); 

		} else{
		echo ("<title>REGISTER PENAGIHAN</title>");
  	    echo $cRet;
		}
		//echo("$cRet");   
    }	


	
}	