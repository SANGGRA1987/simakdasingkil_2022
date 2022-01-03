<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


class Perda extends CI_Controller
{

    function __contruct() {
        parent::__construct();
    }

    function  tanggal_format_indonesia($tgl){
        $tanggal  = explode('-',$tgl); 
        $bulan  = $this-> getBulan($tanggal[1]);
        $tahun  =  $tanggal[0];
        return  $tanggal[2].' '.$bulan.' '.$tahun;
        }
         
    function  tanggal_indonesia($tgl){
        $tanggal  =  substr($tgl,8,2);
        $bulan  = substr($tgl,5,2);
        $tahun  =  substr($tgl,0,4);
        return  $tanggal.'-'.$bulan.'-'.$tahun;

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

	function right($value, $count){
    return substr($value, ($count*-1));
    }

    function left($string, $count){
    return substr($string, 0, $count);
    }  

	function dotrek($rek){
				$nrek=strlen($rek);
				switch ($nrek) {
                case 1:
				$rek = $this->left($rek,1);								
       			 break;
    			case 2:
					$rek = $this->left($rek,1).'.'.substr($rek,1,1);								
       			 break;
    			case 3:
					$rek = $this->left($rek,1).'.'.substr($rek,1,1).'.'.substr($rek,2,1);								
       			 break;
    			case 5:
					$rek = $this->left($rek,1).'.'.substr($rek,1,1).'.'.substr($rek,2,1).'.'.substr($rek,3,2);								
        		break;
    			case 7:
					$rek = $this->left($rek,1).'.'.substr($rek,1,1).'.'.substr($rek,2,1).'.'.substr($rek,3,2).'.'.substr($rek,5,2);								
        		break;
    			default:
				$rek = "";	
				}
				return $rek;
    }
	
	function perdaI(){
        $data['page_title']= 'CETAK PERDA LAMP. I';
        $this->template->set('title', 'CETAK PERDA LAMP. I');   
        $this->template->load('template','perda/cetak_perda_lampI',$data) ;	
	}
	
	function perdaI_1(){
        $data['page_title']= 'CETAK PERDA LAMP. I.1';
        $this->template->set('title', 'CETAK PERDA LAMP. I.1');   
        $this->template->load('template','perda/cetak_perda_lampI_1',$data) ;	
	}
		
    function perdaI_2(){
        $data['page_title']= 'CETAK PERDA LAMP. I.2';
        $this->template->set('title', 'CETAK PERDA LAMP. I.2');   
        $this->template->load('template','perda/cetak_perda_lampI_2',$data) ;	
	}
	
	function perdaI_3(){
        $data['page_title']= 'CETAK PERDA LAMP. I.3';
        $this->template->set('title', 'CETAK PERDA LAMP. I.3');   
        $this->template->load('template','perda/cetak_perda_lampI_3',$data) ;	
	}
	
	function perdaI_4(){
        $data['page_title']= 'CETAK PERDA LAMP. I.4';
        $this->template->set('title', 'CETAK PERDA LAMP. I.4');   
        $this->template->load('template','perda/cetak_perda_lampI_4',$data) ;	
	}
	
	function perkada_1(){
        $data['page_title']= 'CETAK PERGUB LAMP. I';
        $this->template->set('title', 'CETAK PERGUB LAMP. I');   
        $this->template->load('template','perda/cetak_perkada_lampI',$data) ;	
	}
	
	function perkada_2(){
        $data['page_title']= 'CETAK PERGUB LAMP. II';
        $this->template->set('title', 'CETAK PERGUB LAMP. III');   
        $this->template->load('template','perda/cetak_perkada_lampII',$data) ;	
	}

    function cetak_perda_lampI_1_0 ($bulan='',$anggaran='',$ctk='',$tglttd='',$ttd=''){
        $lntahunang = $this->session->userdata('pcThang');       
        if ($anggaran=='1'){
			$ang='nilai';
		} if ($anggaran=='2'){
			$ang='nilai_sempurna';
		} else{
			$ang='nilai_ubah';
		}
		
		
		$tanggal = $tglttd == '-' ? '' : 'Sanggau, '.$this->tukd_model->tanggal_format_indonesia($tglttd) ;
		
		
		$sqlsc="SELECT tgl_rka,provinsi,kab_kota,daerah,thn_ang FROM sclient";
                 $sqlsclient=$this->db->query($sqlsc);
                 foreach ($sqlsclient->result() as $rowsc){
                    $kab     = $rowsc->kab_kota;
                    $prov     = $rowsc->provinsi;
                    $daerah  = $rowsc->daerah;
                    $thn     = $rowsc->thn_ang;
                 }
		
			
		$cRet ='<TABLE style="border-collapse:collapse;font-size:11px;font-family:Arial" width="100%" border="0" cellspacing="0" cellpadding="1" align=center>
					<TR>
						<TD  width="70%" valign="top" align="right" > Lampiran I : </TD>
						<TD width="30%"  align="left" >Rancangan Peraturan Daerah </TD>
					</TR>
					<tr>
					</TABLE><br/>';
	$cRet .="<TABLE style=\"border-collapse:collapse;font-family:Arial\" width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"1\" align=\"center\">
					<tr>
					<td rowspan=\"3\" align=\"center\" style=\"border-right:hidden\">
                        <img src=\"".base_url()."/image/logoHP.png\"  width=\"75\" height=\"100\" />
                        </td>
					<td align=\"center\" style=\"border-left:hidden;border-bottom:hidden\"><strong>PEMERINTAH KABUPATEN SANGGAU </strong></td></tr>
                    <tr><td align=\"center\" style=\"border-left:hidden;border-bottom:hidden;border-top:hidden\"><b>RINGKASAN LAPORAN REALISASI ANGGARAN MENURUT URUSAN PEMERINTAHAN DAERAH DAN ORGANISASI </b></tr>
					<tr><td align=\"center\" style=\"border-left:hidden;border-top:hidden\" ><b>TAHUN ANGGARAN $lntahunang</b></tr>
					</TABLE>";
			
		$cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"2\" cellpadding=\"2\">
                <thead>
				<tr>
                    <td rowspan = \"3\" width=\"5%\" align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">KODE</td>
                    <td rowspan = \"3\" width=\"20%\" align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">URUSAN PEMERINTAH DAERAH</td>
					<td colspan = \"4\" width=\"20%\" align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">PENDAPATAN</td>
                    <td colspan = \"8\" width=\"40%\" align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">BELANJA</td>
                </tr>
				<tr>
                   <td align =\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">ANGGARAN SETELAH PERUBAHAN</td> 
                   <td align =\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">REALISASI</td> 
                   <td colspan =\"2\" align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">BERTAMBAH/KURANG</td> 
                   <td align =\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">BELANJA TIDAK LANGSUNG</td> 
                   <td align =\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">BELANJA LANGSUNG</td> 
                   <td align =\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">JUMLAH ANGGARAN SETELAH PERUBAHAN</td> 
                   <td align =\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">BELANJA TIDAK LANGSUNG</td>                     
                   <td align =\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">BELANJA LANGSUNG</td>                   
                   <td align =\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">JUMLAH REALISASI</td> 
                   <td colspan =\"2\" align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">BERTAMBAH/KURANG</td> 
				</tr>
				<tr>
                   <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">RP.</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">RP.</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">RP.</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">%</td> 
				   <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">RP.</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">RP.</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">RP.</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">RP.</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">RP.</td>                    
                   <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">RP.</td>                                       
                   <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">RP.</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">%</td> 
				    
				</tr>
				<tr>
                   <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">1</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">2</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">3</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">4</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">5</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">6</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">7</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">8</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">9</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">10</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">11</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">12</td>                    
                   <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">13</td>                                       
                   <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">14</td> 
				</tr>
				</thead>";
				
			$tot_ang_brng=0;
			$tot_ang_pelihara=0;
			$tot_ang_dinas=0;
			$tot_ang_honor=0;
			$total_ang=0;
			$tot_real_brng=0;
			$tot_real_pelihara=0;
			$tot_real_dinas=0;
			$tot_real_honor=0;
			$total_real=0;
			$no=0;
			
            $sql = " select kd_kegiatan kode, kd_kegiatan1 kode1 ,nm_rek,ang_pend,ang_btl,ang_bl,real_pend,real_btl,real_bl 
					FROM [perda_lampI.3_sub_3]($bulan,$anggaran) ORDER BY kd_kegiatan
								";
                    $hasil = $this->db->query($sql);
                    foreach ($hasil->result() as $row)
                    {
                       $no=$no+1;
					   $kode = $row->kode1;
					   $nama = $row->nm_rek;
                       $ang_pend = $row->ang_pend;
                       $ang_peg = $row->ang_btl;
                       $ang_modal = $row->ang_bl;
                       $bel_pend = $row->real_pend;
                       $bel_peg = $row->real_btl;
                       $bel_modal = $row->real_bl;
                       
					   $tot_ang=$ang_peg+$ang_modal;
					   $tot_bel=$bel_peg+$bel_modal;
                       $per_pend  = $ang_pend==0 || $ang_peg == '' ? 0 :$bel_pend/$ang_pend*100;
                       $per_bel  = $tot_ang==0 || $tot_ang == '' ? 0 :$tot_bel/$tot_ang*100;

					 $cRet .='<tr>
							   <td align="left" valign="top" style="font-size:12px">'.$kode.'</td> 
							   <td align="left"  valign="top" style="font-size:12px">'.strtoupper($nama).'</td> 
							   <td align="right" valign="top" style="font-size:12px">'.number_format($ang_pend, "2", ",", ".").'</td> 
							   <td align="right" valign="top" style="font-size:12px">'.number_format($bel_pend, "2", ",", ".").'</td> 
							   <td align="right" valign="top" style="font-size:12px">'.number_format($ang_pend-$bel_pend, "2", ",", ".").'</td> 
							   <td align="right" valign="top" style="font-size:12px">'.number_format($per_pend, "2", ",", ".").'</td> 
							   <td align="right" valign="top" style="font-size:12px">'.number_format($ang_peg, "2", ",", ".").'</td> 
							   <td align="right" valign="top" style="font-size:12px">'.number_format($ang_modal, "2", ",", ".").'</td> 
					           <td align="right" valign="top" style="font-size:12px">'.number_format($tot_ang, "2", ",", ".").'</td> 
							   <td align="right" valign="top" style="font-size:12px">'.number_format($bel_peg, "2", ",", ".").'</td>                                
							   <td align="right" valign="top" style="font-size:12px">'.number_format($bel_modal, "2", ",", ".").'</td> 
                               <td align="right" valign="top" style="font-size:12px">'.number_format($tot_bel, "2", ",", ".").'</td>                                
							   <td align="right" valign="top" style="font-size:12px">'.number_format($tot_ang-$tot_bel, "2", ",", ".").'</td> 
							   <td align="right" valign="top" style="font-size:12px">'.number_format($per_bel, "2", ",", ".").'</td> 
							</tr>'; 
					}
				
			$cRet .="</table>";
            
             if($ttd=="1"){
                                
                $sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab,pangkat FROM ms_ttd where kode='walikota'";
                 $sqlttd=$this->db->query($sqlttd1);
                 foreach ($sqlttd->result() as $rowttd)
                {
                    $nip=$rowttd->nip;                    
                    $nama= $rowttd->nm;
                    $jabatan  = $rowttd->jab;
                    $pangkat  = $rowttd->pangkat;
                }
                		
		$cRet .='<TABLE style="border-collapse:collapse; font-size:16px" width="100%" border="0" cellspacing="0" cellpadding="0" align=center>
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
						<TD align="center" >'.$tanggal.'</TD>
					</TR>					
                    <TR>
						<TD width="50%" align="center" ><b>&nbsp;</TD>
						<TD align="center" ><b>'.$jabatan.'</b></TD>
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
            }
            
            $data['prev']= $cRet;    
            $judul='Perda_LampI';
			switch ($ctk){
				case 0;
				echo ("<title>$judul</title>");
				echo $cRet;
				break;
				case 1;
				$this->tukd_model->_mpdf('',$cRet,10,10,10,'L');
				break;
				case 2;        
				header("Cache-Control: no-cache, no-store, must-revalidate");
				header("Content-Type: application/vnd.ms-excel");
				header("Content-Disposition: attachment; filename= $judul.xls");
				$this->load->view('anggaran/rka/perkadaII', $data);
				break;	
			}
		}
	
	function cetak_perda_lampI_1 ($bulan='',$anggaran='',$ctk='',$tglttd='',$ttd=''){
        $lntahunang = $this->session->userdata('pcThang');       
        if ($anggaran=='1'){
			$ang='nilai';
		} if ($anggaran=='2'){
			$ang='nilai_sempurna';
		} else{
			$ang='nilai_ubah';
		}
		
		
		$tanggal = $tglttd == '-' ? '' : 'Sanggau, '.$this->tukd_model->tanggal_format_indonesia($tglttd) ;
	if($ttd=='-'){
		$nama_ttd='';
		$pangkat='';
		$jabatan='';
		$nip='';
	}else{
	$ttd=str_replace("abc"," ",$ttd);
	$sqlsc="SELECT nama,jabatan,pangkat FROM ms_ttd where nip='$ttd' AND kode='PA' and kd_skpd='1.20.00.00'";
                 $sqlsclient=$this->db->query($sqlsc);
                 foreach ($sqlsclient->result() as $rowttd)
                {
                    $nama_ttd = $rowttd->nama;
                    $jabatan = $rowttd->jabatan;
                    $pangkat = $rowttd->pangkat;
                    $nip = 'NIP. '.$ttd;
                } 
	}
		
		
		$sqlsc="SELECT tgl_rka,provinsi,kab_kota,daerah,thn_ang FROM sclient";
                 $sqlsclient=$this->db->query($sqlsc);
                 foreach ($sqlsclient->result() as $rowsc){
                    $kab     = $rowsc->kab_kota;
                    $prov     = $rowsc->provinsi;
                    $daerah  = $rowsc->daerah;
                    $thn     = $rowsc->thn_ang;
                 }
		
			
		$cRet ='<TABLE style="border-collapse:collapse;font-size:11px;font-family:Arial" width="100%" border="0" cellspacing="0" cellpadding="1" align=center>
					<TR>
						<TD  width="70%" valign="top" align="right" > Lampiran I : </TD>
						<TD width="30%"  align="left" >Rancangan Peraturan Daerah </TD>
					</TR>
					<tr>
					</TABLE><br/>';
	$cRet .="<TABLE style=\"border-collapse:collapse;font-family:Arial\" width=\"100%\" border=\"1\" cellspacing=\"0\" cellpadding=\"1\" align=\"center\">
					<tr>
					<td rowspan=\"3\" align=\"center\" style=\"border-right:hidden\">
                        <img src=\"".base_url()."/image/logoHP.png\"  width=\"75\" height=\"100\" />
                        </td>
					<td align=\"center\" style=\"border-left:hidden;border-bottom:hidden\"><strong>PEMERINTAH KABUPATEN SANGGAU </strong></td></tr>
                    <tr><td align=\"center\" style=\"border-left:hidden;border-bottom:hidden;border-top:hidden\"><b>RINGKASAN LAPORAN REALISASI ANGGARAN MENURUT URUSAN PEMERINTAHAN DAERAH DAN ORGANISASI </b></tr>
					<tr><td align=\"center\" style=\"border-left:hidden;border-top:hidden\" ><b>TAHUN ANGGARAN $lntahunang</b></tr>
					</TABLE>";
			
		$cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"2\" cellpadding=\"2\">
                <thead>
				<tr>
                    <td rowspan = \"3\" width=\"5%\" align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">KODE</td>
                    <td rowspan = \"3\" width=\"20%\" align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">URUSAN PEMERINTAH DAERAH</td>
					<td colspan = \"4\" width=\"20%\" align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">PENDAPATAN</td>
                    <td colspan = \"6\" width=\"40%\" align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">BELANJA</td>
                </tr>
				<tr>
                   <td align =\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">ANGGARAN SETELAH PERUBAHAN</td> 
                   <td align =\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">REALISASI</td> 
                   <td colspan =\"2\" align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">BERTAMBAH/KURANG</td> 
                   <td rowspan =\"2\" align=\"LEFT\" bgcolor=\"#CCCCCC\" style=\"font-size:9px\"> 	 7. BLJ PEGAWAI<BR>
																									 8. BLJ BARANG JASA<BR>
																									 9. BLJ MODAL<BR>
																									 10.BLJ BUNGA<BR>
																									 11.BLJ SUBSIDI<BR>
																									 12.BLJ HIBAH<BR>
																									 13.BLJ BANSOS<BR>
																									 14.BLJ BAGI HASIL<BR>
																									 15.BLJ BANTUAN KEU.<BR>
																									 16.BLJ TDK TERDUGA
																									 </td> 
                   <td rowspan =\"2\" align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">JUMLAH BELANJA</td> 
				   <td rowspan =\"2\" align=\"LEFT\" bgcolor=\"#CCCCCC\" style=\"font-size:9px\">	 18.BLJ PEGAWAI<BR>
																									 19.BLJ BARANG JASA<BR>
																									 20.BLJ MODAL<BR>
																									 21.BLJ BUNGA<BR>
																									 22.BLJ SUBSIDI<BR>
																									 23.BLJ HIBAH<BR>
																									 24.BLJ BANSOS<BR>
																									 25.BLJ BAGI HASIL<BR>
																									 26.BLJ BANTUAN KEU.<BR>
																									 27.BLJ TDK TERDUGA
																									 </td> 
                   <td rowspan =\"2\" align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">JUMLAH BELANJA</td> 
				   <td colspan=\"2\" align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">BERTAMBAH/KURANG</td> 
				</tr>
				<tr>
                   <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">RP.</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">RP.</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">RP.</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">%</td> 
				   <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">RP.</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">%</td> 
				</tr>
				<tr>
                   <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">1</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">2</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">3</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">4</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">5(4-3)</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">6</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">RP</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">17=(7+sd+16)</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">RP</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">28=(18+sd+27)</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">29=28-17</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">30</td> 
				</tr>
				</thead>";
				
			$tot_ang_brng=0;
			$tot_ang_pelihara=0;
			$tot_ang_dinas=0;
			$tot_ang_honor=0;
			$total_ang=0;
			$tot_real_brng=0;
			$tot_real_pelihara=0;
			$tot_real_dinas=0;
			$tot_real_honor=0;
			$total_real=0;
			$no=0;
			$sql = "
SELECT a.kd_urusan1 as kode ,a.nm_urusan1 as nama,
isnull(ang_pend,0) as ang_pend, ISNULL(ang_peg,0) as ang_peg, ISNULL(ang_brjs,0) ang_brjs, ISNULL(ang_modal,0) ang_modal, 
ISNULL(ang_bunga,0) as ang_bunga, ISNULL(ang_subsidi,0) as ang_subsidi, ISNULL(ang_hibah,0) ang_hibah, ISNULL(ang_bansos,0) as ang_bansos, 
ISNULL(ang_bghasil,0) as ang_bghasil, ISNULL(ang_bantuan,0) as ang_bantuan, ISNULL(ang_takterduga,0) as ang_takterduga,
ISNULL(bel_pend,0) as bel_pend, ISNULL(bel_peg,0) as bel_peg, ISNULL(bel_brjs,0) bel_brjs, ISNULL(bel_modal,0) as bel_modal,
ISNULL(bel_bunga,0) as bel_bunga, ISNULL(bel_subsidi,0) as bel_subsidi, ISNULL(bel_hibah,0) as bel_hibah, ISNULL(bel_bansos,0) bel_bansos,
ISNULL(bel_bghasil,0) as bel_bghasil, ISNULL(bel_bantuan,0) as bel_bantuan, ISNULL(bel_takterduga,0) as bel_takterduga

FROM ms_urusan1  a 
LEFT JOIN
(
SELECT a.kode, 
ang_pend, ang_peg, ang_brjs, ang_modal, ang_bunga, ang_subsidi, ang_hibah, ang_bansos, ang_bghasil, ang_bantuan, ang_takterduga,
bel_pend, bel_peg, bel_brjs, bel_modal, bel_bunga, bel_subsidi, bel_hibah, bel_bansos, bel_bghasil, bel_bantuan, bel_takterduga
FROM (
SELECT LEFT(a.kd_skpd,1) as kode 
,SUM(CASE WHEN LEFT(a.kd_rek5,1) = '4' THEN a.$ang ELSE 0 END) AS ang_pend
,SUM(CASE WHEN LEFT(a.kd_rek5,3) IN ('511','521') THEN a.$ang ELSE 0 END) AS ang_peg
,SUM(CASE WHEN LEFT(a.kd_rek5,3) = '522' THEN a.$ang ELSE 0 END) AS ang_brjs
,SUM(CASE WHEN LEFT(a.kd_rek5,3) = '523' THEN a.$ang ELSE 0 END) AS ang_modal
,SUM(CASE WHEN LEFT(a.kd_rek5,3) = '512' THEN a.$ang ELSE 0 END) AS ang_bunga
,SUM(CASE WHEN LEFT(a.kd_rek5,3) = '513' THEN a.$ang ELSE 0 END) AS ang_subsidi
,SUM(CASE WHEN LEFT(a.kd_rek5,3) = '514' THEN a.$ang ELSE 0 END) AS ang_hibah
,SUM(CASE WHEN LEFT(a.kd_rek5,3) = '515' THEN a.$ang ELSE 0 END) AS ang_bansos
,SUM(CASE WHEN LEFT(a.kd_rek5,3) = '516' THEN a.$ang ELSE 0 END) AS ang_bghasil
,SUM(CASE WHEN LEFT(a.kd_rek5,3) = '517' THEN a.$ang ELSE 0 END) AS ang_bantuan
,SUM(CASE WHEN LEFT(a.kd_rek5,3) = '518' THEN a.$ang ELSE 0 END) AS ang_takterduga
FROM trdrka a GROUP BY LEFT(a.kd_skpd,1) ) a
LEFT JOIN 
(SELECT a.kode as kode 
,SUM(CASE WHEN LEFT(a.kd_rek,1) = '4' THEN a.nilai*-1 ELSE 0 END) AS bel_pend
,SUM(CASE WHEN LEFT(a.kd_rek,3) IN ('511','521') THEN a.nilai ELSE 0 END) AS bel_peg
,SUM(CASE WHEN LEFT(a.kd_rek,3) = '522' THEN a.nilai ELSE 0 END) AS bel_brjs
,SUM(CASE WHEN LEFT(a.kd_rek,3) = '523' THEN a.nilai ELSE 0 END) AS bel_modal
,SUM(CASE WHEN LEFT(a.kd_rek,3) = '512' THEN a.nilai ELSE 0 END) AS bel_bunga
,SUM(CASE WHEN LEFT(a.kd_rek,3) = '513' THEN a.nilai ELSE 0 END) AS bel_subsidi
,SUM(CASE WHEN LEFT(a.kd_rek,3) = '514' THEN a.nilai ELSE 0 END) AS bel_hibah
,SUM(CASE WHEN LEFT(a.kd_rek,3) = '515' THEN a.nilai ELSE 0 END) AS bel_bansos
,SUM(CASE WHEN LEFT(a.kd_rek,3) = '516' THEN a.nilai ELSE 0 END) AS bel_bghasil
,SUM(CASE WHEN LEFT(a.kd_rek,3) = '517' THEN a.nilai ELSE 0 END) AS bel_bantuan
,SUM(CASE WHEN LEFT(a.kd_rek,3) = '518' THEN a.nilai ELSE 0 END) AS bel_takterduga
FROM
(SELECT LEFT(a.kd_skpd,1) as kode ,LEFT(kd_rek5,3) kd_rek,SUM(realisasi) as nilai FROM (
SELECT a.kd_skpd,b.kd_rek5,(b.debet - b.kredit) as realisasi FROM trhju_pkd a INNER JOIN trdju_pkd b ON a.kd_skpd = b.kd_unit AND a.no_voucher=b.no_voucher
WHERE LEFT(b.map_real,1) IN ('5','4') AND MONTH(a.tgl_voucher)<='$bulan') a GROUP BY LEFT(a.kd_skpd,1) ,LEFT(kd_rek5,3))a
GROUP BY a.kode) b
ON a.kode=b.kode
) b ON a.kd_urusan1=b.kode
UNION ALL
SELECT a.kd_urusan as kode ,a.nm_urusan as nama,
isnull(ang_pend,0) as ang_pend, ISNULL(ang_peg,0) as ang_peg, ISNULL(ang_brjs,0) ang_brjs, ISNULL(ang_modal,0) ang_modal, 
ISNULL(ang_bunga,0) as ang_bunga, ISNULL(ang_subsidi,0) as ang_subsidi, ISNULL(ang_hibah,0) ang_hibah, ISNULL(ang_bansos,0) as ang_bansos, 
ISNULL(ang_bghasil,0) as ang_bghasil, ISNULL(ang_bantuan,0) as ang_bantuan, ISNULL(ang_takterduga,0) as ang_takterduga,
ISNULL(bel_pend,0) as bel_bend, ISNULL(bel_peg,0) as bel_peg, ISNULL(bel_brjs,0) bel_brjs, ISNULL(bel_modal,0) as bel_modal,
ISNULL(bel_bunga,0) as bel_bunga, ISNULL(bel_subsidi,0) as bel_subsidi, ISNULL(bel_hibah,0) as bel_hibah, ISNULL(bel_bansos,0) bel_bansos,
ISNULL(bel_bghasil,0) as bel_bghasil, ISNULL(bel_bantuan,0) as bel_bantuan, ISNULL(bel_takterduga,0) as bel_takterduga

FROM ms_urusan  a 
LEFT JOIN
(
SELECT a.kode, 
ang_pend, ang_peg, ang_brjs, ang_modal, ang_bunga, ang_subsidi, ang_hibah, ang_bansos, ang_bghasil, ang_bantuan, ang_takterduga,
bel_pend, bel_peg, bel_brjs, bel_modal, bel_bunga, bel_subsidi, bel_hibah, bel_bansos, bel_bghasil, bel_bantuan, bel_takterduga
FROM (
SELECT LEFT(a.kd_skpd,4) as kode 
,SUM(CASE WHEN LEFT(a.kd_rek5,1) = '4' THEN a.$ang ELSE 0 END) AS ang_pend
,SUM(CASE WHEN LEFT(a.kd_rek5,3) IN ('511','521') THEN a.$ang ELSE 0 END) AS ang_peg
,SUM(CASE WHEN LEFT(a.kd_rek5,3) = '522' THEN a.$ang ELSE 0 END) AS ang_brjs
,SUM(CASE WHEN LEFT(a.kd_rek5,3) = '523' THEN a.$ang ELSE 0 END) AS ang_modal
,SUM(CASE WHEN LEFT(a.kd_rek5,3) = '512' THEN a.$ang ELSE 0 END) AS ang_bunga
,SUM(CASE WHEN LEFT(a.kd_rek5,3) = '513' THEN a.$ang ELSE 0 END) AS ang_subsidi
,SUM(CASE WHEN LEFT(a.kd_rek5,3) = '514' THEN a.$ang ELSE 0 END) AS ang_hibah
,SUM(CASE WHEN LEFT(a.kd_rek5,3) = '515' THEN a.$ang ELSE 0 END) AS ang_bansos
,SUM(CASE WHEN LEFT(a.kd_rek5,3) = '516' THEN a.$ang ELSE 0 END) AS ang_bghasil
,SUM(CASE WHEN LEFT(a.kd_rek5,3) = '517' THEN a.$ang ELSE 0 END) AS ang_bantuan
,SUM(CASE WHEN LEFT(a.kd_rek5,3) = '518' THEN a.$ang ELSE 0 END) AS ang_takterduga
FROM trdrka a GROUP BY LEFT(a.kd_skpd,4) ) a
LEFT JOIN 
(SELECT a.kode as kode 
,SUM(CASE WHEN LEFT(a.kd_rek,1) = '4' THEN a.nilai*-1 ELSE 0 END) AS bel_pend
,SUM(CASE WHEN LEFT(a.kd_rek,3) IN ('511','521') THEN a.nilai ELSE 0 END) AS bel_peg
,SUM(CASE WHEN LEFT(a.kd_rek,3) = '522' THEN a.nilai ELSE 0 END) AS bel_brjs
,SUM(CASE WHEN LEFT(a.kd_rek,3) = '523' THEN a.nilai ELSE 0 END) AS bel_modal
,SUM(CASE WHEN LEFT(a.kd_rek,3) = '512' THEN a.nilai ELSE 0 END) AS bel_bunga
,SUM(CASE WHEN LEFT(a.kd_rek,3) = '513' THEN a.nilai ELSE 0 END) AS bel_subsidi
,SUM(CASE WHEN LEFT(a.kd_rek,3) = '514' THEN a.nilai ELSE 0 END) AS bel_hibah
,SUM(CASE WHEN LEFT(a.kd_rek,3) = '515' THEN a.nilai ELSE 0 END) AS bel_bansos
,SUM(CASE WHEN LEFT(a.kd_rek,3) = '516' THEN a.nilai ELSE 0 END) AS bel_bghasil
,SUM(CASE WHEN LEFT(a.kd_rek,3) = '517' THEN a.nilai ELSE 0 END) AS bel_bantuan
,SUM(CASE WHEN LEFT(a.kd_rek,3) = '518' THEN a.nilai ELSE 0 END) AS bel_takterduga
FROM
(SELECT LEFT(a.kd_skpd,4) as kode ,LEFT(kd_rek5,3) kd_rek,SUM(realisasi) as nilai FROM (
SELECT a.kd_skpd,b.kd_rek5,(b.debet - b.kredit) as realisasi FROM trhju_pkd a INNER JOIN trdju_pkd b ON a.kd_skpd = b.kd_unit AND a.no_voucher=b.no_voucher
WHERE LEFT(b.map_real,1) IN ('5','4') AND MONTH(a.tgl_voucher)<='$bulan') a GROUP BY LEFT(a.kd_skpd,4) ,LEFT(kd_rek5,3))a
GROUP BY a.kode) b
ON a.kode=b.kode
) b ON a.kd_urusan=b.kode
			UNION ALL
			SELECT a.kd_org as kode ,a.nm_org as nama,
			isnull(ang_pend,0) as ang_pend, ISNULL(ang_peg,0) as ang_peg, ISNULL(ang_brjs,0) ang_brjs, ISNULL(ang_modal,0) ang_modal, 
			ISNULL(ang_bunga,0) as ang_bunga, ISNULL(ang_subsidi,0) as ang_subsidi, ISNULL(ang_hibah,0) ang_hibah, ISNULL(ang_bansos,0) as ang_bansos, 
			ISNULL(ang_bghasil,0) as ang_bghasil, ISNULL(ang_bantuan,0) as ang_bantuan, ISNULL(ang_takterduga,0) as ang_takterduga,
			ISNULL(bel_pend,0) as bel_bend, ISNULL(bel_peg,0) as bel_peg, ISNULL(bel_brjs,0) bel_brjs, ISNULL(bel_modal,0) as bel_modal,
			ISNULL(bel_bunga,0) as bel_bunga, ISNULL(bel_subsidi,0) as bel_subsidi, ISNULL(bel_hibah,0) as bel_hibah, ISNULL(bel_bansos,0) bel_bansos,
			ISNULL(bel_bghasil,0) as bel_bghasil, ISNULL(bel_bantuan,0) as bel_bantuan, ISNULL(bel_takterduga,0) as bel_takterduga

			FROM ms_organisasi a 
			LEFT JOIN
			(
			SELECT a.kode, 
			ang_pend, ang_peg, ang_brjs, ang_modal, ang_bunga, ang_subsidi, ang_hibah, ang_bansos, ang_bghasil, ang_bantuan, ang_takterduga,
			bel_pend, bel_peg, bel_brjs, bel_modal, bel_bunga, bel_subsidi, bel_hibah, bel_bansos, bel_bghasil, bel_bantuan, bel_takterduga
			FROM (
			SELECT LEFT(a.kd_skpd,7) as kode 
			,SUM(CASE WHEN LEFT(a.kd_rek5,1) = '4' THEN a.$ang ELSE 0 END) AS ang_pend
			,SUM(CASE WHEN LEFT(a.kd_rek5,3) IN ('511','521') THEN a.$ang ELSE 0 END) AS ang_peg
			,SUM(CASE WHEN LEFT(a.kd_rek5,3) = '522' THEN a.$ang ELSE 0 END) AS ang_brjs
			,SUM(CASE WHEN LEFT(a.kd_rek5,3) = '523' THEN a.$ang ELSE 0 END) AS ang_modal
			,SUM(CASE WHEN LEFT(a.kd_rek5,3) = '512' THEN a.$ang ELSE 0 END) AS ang_bunga
			,SUM(CASE WHEN LEFT(a.kd_rek5,3) = '513' THEN a.$ang ELSE 0 END) AS ang_subsidi
			,SUM(CASE WHEN LEFT(a.kd_rek5,3) = '514' THEN a.$ang ELSE 0 END) AS ang_hibah
			,SUM(CASE WHEN LEFT(a.kd_rek5,3) = '515' THEN a.$ang ELSE 0 END) AS ang_bansos
			,SUM(CASE WHEN LEFT(a.kd_rek5,3) = '516' THEN a.$ang ELSE 0 END) AS ang_bghasil
			,SUM(CASE WHEN LEFT(a.kd_rek5,3) = '517' THEN a.$ang ELSE 0 END) AS ang_bantuan
			,SUM(CASE WHEN LEFT(a.kd_rek5,3) = '518' THEN a.$ang ELSE 0 END) AS ang_takterduga
			FROM trdrka a GROUP BY LEFT(a.kd_skpd,7) ) a
			LEFT JOIN 
			(SELECT a.kode as kode 
			,SUM(CASE WHEN LEFT(a.kd_rek,1) = '4' THEN a.nilai*-1 ELSE 0 END) AS bel_pend
			,SUM(CASE WHEN LEFT(a.kd_rek,3) IN ('511','521') THEN a.nilai ELSE 0 END) AS bel_peg
			,SUM(CASE WHEN LEFT(a.kd_rek,3) = '522' THEN a.nilai ELSE 0 END) AS bel_brjs
			,SUM(CASE WHEN LEFT(a.kd_rek,3) = '523' THEN a.nilai ELSE 0 END) AS bel_modal
			,SUM(CASE WHEN LEFT(a.kd_rek,3) = '512' THEN a.nilai ELSE 0 END) AS bel_bunga
			,SUM(CASE WHEN LEFT(a.kd_rek,3) = '513' THEN a.nilai ELSE 0 END) AS bel_subsidi
			,SUM(CASE WHEN LEFT(a.kd_rek,3) = '514' THEN a.nilai ELSE 0 END) AS bel_hibah
			,SUM(CASE WHEN LEFT(a.kd_rek,3) = '515' THEN a.nilai ELSE 0 END) AS bel_bansos
			,SUM(CASE WHEN LEFT(a.kd_rek,3) = '516' THEN a.nilai ELSE 0 END) AS bel_bghasil
			,SUM(CASE WHEN LEFT(a.kd_rek,3) = '517' THEN a.nilai ELSE 0 END) AS bel_bantuan
			,SUM(CASE WHEN LEFT(a.kd_rek,3) = '518' THEN a.nilai ELSE 0 END) AS bel_takterduga
			FROM
			(SELECT LEFT(a.kd_skpd,7) as kode ,LEFT(kd_rek5,3) kd_rek,SUM(realisasi) as nilai FROM (
			SELECT a.kd_skpd,b.kd_rek5,(b.debet - b.kredit) as realisasi FROM trhju_pkd a INNER JOIN trdju_pkd b ON a.kd_skpd = b.kd_unit AND a.no_voucher=b.no_voucher
			WHERE LEFT(b.map_real,1) IN ('5','4') AND MONTH(a.tgl_voucher)<='$bulan' ) a GROUP BY LEFT(a.kd_skpd,7) ,LEFT(kd_rek5,3))a
			GROUP BY a.kode) b
			ON a.kode=b.kode
			) b ON a.kd_org=b.kode
			
					UNION ALL
					SELECT a.kd_skpd as kode ,a.nm_skpd as nama,
					ang_pend, ang_peg, ang_brjs, ang_modal, ang_bunga, ang_subsidi, ang_hibah, ang_bansos, ang_bghasil, ang_bantuan, ang_takterduga,
					bel_pend, bel_peg, bel_brjs, bel_modal, bel_bunga, bel_subsidi, bel_hibah, bel_bansos, bel_bghasil, bel_bantuan, bel_takterduga

					FROM 
					ms_skpd a
					LEFT JOIN
					(
					SELECT a.kd_skpd, 
					ang_pend, ang_peg, ang_brjs, ang_modal, ang_bunga, ang_subsidi, ang_hibah, ang_bansos, ang_bghasil, ang_bantuan, ang_takterduga,
					bel_pend, bel_peg, bel_brjs, bel_modal, bel_bunga, bel_subsidi, bel_hibah, bel_bansos, bel_bghasil, bel_bantuan, bel_takterduga
					FROM (
					SELECT a.kd_skpd
					,SUM(CASE WHEN LEFT(a.kd_rek5,1) = '4' THEN a.$ang ELSE 0 END) AS ang_pend
					,SUM(CASE WHEN LEFT(a.kd_rek5,3) IN ('511','521') THEN a.$ang ELSE 0 END) AS ang_peg
					,SUM(CASE WHEN LEFT(a.kd_rek5,3) = '522' THEN a.$ang ELSE 0 END) AS ang_brjs
					,SUM(CASE WHEN LEFT(a.kd_rek5,3) = '523' THEN a.$ang ELSE 0 END) AS ang_modal
					,SUM(CASE WHEN LEFT(a.kd_rek5,3) = '512' THEN a.$ang ELSE 0 END) AS ang_bunga
					,SUM(CASE WHEN LEFT(a.kd_rek5,3) = '513' THEN a.$ang ELSE 0 END) AS ang_subsidi
					,SUM(CASE WHEN LEFT(a.kd_rek5,3) = '514' THEN a.$ang ELSE 0 END) AS ang_hibah
					,SUM(CASE WHEN LEFT(a.kd_rek5,3) = '515' THEN a.$ang ELSE 0 END) AS ang_bansos
					,SUM(CASE WHEN LEFT(a.kd_rek5,3) = '516' THEN a.$ang ELSE 0 END) AS ang_bghasil
					,SUM(CASE WHEN LEFT(a.kd_rek5,3) = '517' THEN a.$ang ELSE 0 END) AS ang_bantuan
					,SUM(CASE WHEN LEFT(a.kd_rek5,3) = '518' THEN a.$ang ELSE 0 END) AS ang_takterduga
					FROM trdrka a GROUP BY a.kd_skpd) a
					LEFT JOIN 
					(SELECT a.kd_skpd
					,SUM(CASE WHEN LEFT(a.kd_rek,1) = '4' THEN a.nilai*-1 ELSE 0 END) AS bel_pend
					,SUM(CASE WHEN LEFT(a.kd_rek,3) IN ('511','521') THEN a.nilai ELSE 0 END) AS bel_peg
					,SUM(CASE WHEN LEFT(a.kd_rek,3) = '522' THEN a.nilai ELSE 0 END) AS bel_brjs
					,SUM(CASE WHEN LEFT(a.kd_rek,3) = '523' THEN a.nilai ELSE 0 END) AS bel_modal
					,SUM(CASE WHEN LEFT(a.kd_rek,3) = '512' THEN a.nilai ELSE 0 END) AS bel_bunga
					,SUM(CASE WHEN LEFT(a.kd_rek,3) = '513' THEN a.nilai ELSE 0 END) AS bel_subsidi
					,SUM(CASE WHEN LEFT(a.kd_rek,3) = '514' THEN a.nilai ELSE 0 END) AS bel_hibah
					,SUM(CASE WHEN LEFT(a.kd_rek,3) = '515' THEN a.nilai ELSE 0 END) AS bel_bansos
					,SUM(CASE WHEN LEFT(a.kd_rek,3) = '516' THEN a.nilai ELSE 0 END) AS bel_bghasil
					,SUM(CASE WHEN LEFT(a.kd_rek,3) = '517' THEN a.nilai ELSE 0 END) AS bel_bantuan
					,SUM(CASE WHEN LEFT(a.kd_rek,3) = '518' THEN a.nilai ELSE 0 END) AS bel_takterduga
					FROM
					(SELECT kd_skpd,LEFT(kd_rek5,3) kd_rek,SUM(realisasi) as nilai FROM (
					SELECT a.kd_skpd,b.kd_rek5,(b.debet - b.kredit) as realisasi FROM trhju_pkd a INNER JOIN trdju_pkd b ON a.kd_skpd = b.kd_unit AND a.no_voucher=b.no_voucher
					WHERE LEFT(b.map_real,1) IN ('5','4') AND MONTH(a.tgl_voucher)<='$bulan' ) a GROUP BY kd_skpd,LEFT(kd_rek5,3))a
					GROUP BY a.kd_skpd) b
					ON a.kd_skpd=b.kd_skpd
					) b ON a.kd_skpd=b.kd_skpd
					order by kode
					";
                    $hasil = $this->db->query($sql);
                    foreach ($hasil->result() as $row)
                    {
                       $no=$no+1;
					   $kode = $row->kode;
					   $nama = $row->nama;
                       $ang_pend = $row->ang_pend;
                       $ang_peg = $row->ang_peg;
                       $ang_brjs = $row->ang_brjs;
                       $ang_modal = $row->ang_modal;
                       $ang_bunga = $row->ang_bunga;
                       $ang_subsidi = $row->ang_subsidi;
                       $ang_hibah = $row->ang_hibah;
                       $ang_bansos = $row->ang_bansos;
                       $ang_bghasil = $row->ang_bghasil;
                       $ang_bantuan  = $row->ang_bantuan;
                       $ang_takterduga = $row->ang_takterduga;
                       $bel_pend = $row->bel_pend;
                       $bel_peg = $row->bel_peg;
                       $bel_brjs = $row->bel_brjs;
                       $bel_modal = $row->bel_modal;
                       $bel_bunga = $row->bel_bunga;
                       $bel_subsidi = $row->bel_subsidi;
                       $bel_hibah = $row->bel_hibah;
                       $bel_bansos = $row->bel_bansos;
                       $bel_bghasil = $row->bel_bghasil;
                       $bel_bantuan = $row->bel_bantuan;
                       $bel_takterduga = $row->bel_takterduga;
					   
					   $tot_ang=$ang_peg+$ang_brjs+$ang_modal+$ang_bunga+$ang_subsidi+$ang_hibah+$ang_bansos+$ang_bghasil+$ang_bantuan+$ang_takterduga;
					   $tot_bel=$bel_peg+$bel_brjs+$bel_modal+$bel_bunga+$bel_subsidi+$bel_hibah+$bel_bansos+$bel_bghasil+$bel_bantuan+$bel_takterduga;
                       $per_pend  = $ang_pend==0 || $ang_peg == '' ? 0 :$bel_pend/$ang_pend;
                       $per_bel  = $tot_ang==0 || $tot_ang == '' ? 0 :$tot_bel/$tot_ang;

					 $cRet .='<tr>
							   <td align="left" valign="top" style="font-size:12px">'.$kode.'</td> 
							   <td align="left"  valign="top" style="font-size:12px">'.strtoupper($nama).'</td> 
							   <td align="right" valign="top" style="font-size:12px">'.number_format($ang_pend, "2", ",", ".").'</td> 
							   <td align="right" valign="top" style="font-size:12px">'.number_format($bel_pend, "2", ",", ".").'</td> 
							   <td align="right" valign="top" style="font-size:12px">'.number_format($ang_pend-$bel_pend, "2", ",", ".").'</td> 
							   <td align="right" valign="top" style="font-size:12px">'.number_format($per_pend, "2", ",", ".").'</td> 
							   <td align="right" valign="top" style="font-size:12px">'.number_format($ang_peg, "2", ",", ".").'<br>
																					'.number_format($ang_brjs, "2", ",", ".").'<br>
																					'.number_format($ang_modal, "2", ",", ".").'<br>
																					'.number_format($ang_bunga, "2", ",", ".").'<br>
																					'.number_format($ang_subsidi, "2", ",", ".").'<br>
																					'.number_format($ang_hibah, "2", ",", ".").'<br>
																					'.number_format($ang_bansos, "2", ",", ".").'<br>
																					'.number_format($ang_bghasil, "2", ",", ".").'<br>
																					'.number_format($ang_bantuan, "2", ",", ".").'<br>
																					'.number_format($ang_takterduga, "2", ",", ".").'
							   </td> 
							   <td align="right" valign="top" style="font-size:12px">'.number_format($tot_ang, "2", ",", ".").'</td> 
								 <td align="right" valign="top" style="font-size:12px">'.number_format($bel_peg, "2", ",", ".").'<br>
																					'.number_format($bel_brjs, "2", ",", ".").'<br>
																					'.number_format($bel_modal, "2", ",", ".").'<br>
																					'.number_format($bel_bunga, "2", ",", ".").'<br>
																					'.number_format($bel_subsidi, "2", ",", ".").'<br>
																					'.number_format($bel_hibah, "2", ",", ".").'<br>
																					'.number_format($bel_bansos, "2", ",", ".").'<br>
																					'.number_format($bel_bghasil, "2", ",", ".").'<br>
																					'.number_format($bel_bantuan, "2", ",", ".").'<br>
																					'.number_format($bel_takterduga, "2", ",", ".").'
							   </td> 
							   <td align="right" valign="top" style="font-size:12px">'.number_format($tot_bel, "2", ",", ".").'</td> 
							   <td align="right" valign="top" style="font-size:12px">'.number_format($tot_ang-$tot_bel, "2", ",", ".").'</td> 
							   <td align="right" valign="top" style="font-size:12px">'.number_format($per_bel, "2", ",", ".").'</td> 
							</tr>'; 
					}
				
			$cRet .="</table>";
			$cRet .="<table style=\"border-collapse:collapse;font-family:Arial;font-size:12px\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\">
				<tr>
                    <td width=\"50%\" align=\"center\">&nbsp;</td>
                    <td width=\"50%\" align=\"center\"></td>
				</tr>
				<tr>
                    <td width=\"50%\" align=\"center\">&nbsp;</td>
                    <td width=\"50%\" align=\"center\">$tanggal<br>$jabatan<br><br><br><br><br><b><u>$nama_ttd</u></b><br>$pangkat<br>$nip
					</td>
				</tr>
				</table>";
			$data['prev']= $cRet;    
            $judul='Perda_LampI';
			switch ($ctk){
				case 0;
				echo ("<title>$judul</title>");
				echo $cRet;
				break;
				case 1;
				$this->tukd_model->_mpdf('',$cRet,10,10,10,'L');
				break;
				case 2;        
				header("Cache-Control: no-cache, no-store, must-revalidate");
				header("Content-Type: application/vnd.ms-excel");
				header("Content-Disposition: attachment; filename= $judul.xls");
				$this->load->view('anggaran/rka/perkadaII', $data);
				break;	
			}
		}
	
	function cetak_perda_lampI_sap_spj($bulan='',$ctk='',$anggaran='',$jenis='',$kd_skpd=''){
        $lntahunang = $this->session->userdata('pcThang');       
		switch  ($bulan){
        case  1:
        $judul="JANUARI";
        break;
        case  2:
        $judul="FEBRUARI";
        break;
        case  3:
        $judul= "TRIWULAN I";
        break;
        case  4:
        $judul="APRIL";
        break;
        case  5:
        $judul= "MEI";
        break;
        case  6:
        $judul= "SEMESTER I";
        break;
        case  7:
        $judul= "JULI";
        break;
        case  8:
        $judul= "AGUSTUS";
        break;
        case  9:
        $judul= "TRIWULAN III";
        break;
        case  10:
        $judul= "OKTOBER";
        break;
        case  11:
        $judul= "NOVEMBER";
        break;
        case  12:
        $judul= "SEMESTER II";
        break;
    }
	if ($kd_skpd=='-'){                               
            $where="";            
        } else{
			$where="AND kd_skpd='$kd_skpd'";
		}
		
		$cRet ='<TABLE style="border-collapse:collapse;font-size:11px;font-family:Arial" width="100%" border="0" cellspacing="0" cellpadding="1" align=center>
					<TR>
						<TD  width="60%" valign="top" align="right" > Lampiran I : </TD>
						<TD width="40%"  align="left" >Peraturan Daerah <br>Nomor : <br>Tanggal: </TD>
					</TR>
					<tr>
					</TABLE><br/>';
	$cRet .="<TABLE style=\"border-collapse:collapse;font-family:Arial\" width=\"100%\" border=\"1\" cellspacing=\"0\" cellpadding=\"1\" align=\"center\">
					<tr>
					<td rowspan=\"3\" align=\"center\" style=\"border-right:hidden\">
                        <img src=\"".base_url()."/image/logoHP.png\"  width=\"75\" height=\"100\" />
                        </td>
					<td align=\"center\" style=\"border-left:hidden;border-bottom:hidden\"><strong>PEMERINTAH KABUPATEN SANGGAU </strong></td></tr>
                    <tr><td align=\"center\" style=\"border-left:hidden;border-bottom:hidden;border-top:hidden\"><b>RINGKASAN LAPORAN REALISASI ANGGARAN </b></tr>
					<tr><td align=\"center\" style=\"border-left:hidden;border-top:hidden\" ><b>$judul</b></tr>
					</TABLE>";
			
		$cRet .="<table style=\"border-collapse:collapse;font-family:Arial;font-size:11px\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"3\" cellpadding=\"3\">
                <thead>
				<tr>
                    <td rowspan=\"2\" width=\"7%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>KD REK</b></td>
                    <td rowspan=\"2\" width=\"32%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>URAIAN</b></td>
                    <td colspan=\"2\" width=\"37%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>JUMLAH (Rp.)</b></td>
                    <td colspan=\"2\" width=\"23%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>BERTAMBAH/KURANG</b></td>
				</tr>
				<tr>
					<td width=\"19%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>ANGGARAN</b></td>
					<td width=\"18%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>REALISASI</b></td>
					<td width=\"18%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>(Rp)</b></td>
					<td width=\"5%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>%</b></td>
					</tr>
					<tr>
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >1</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >2</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >3</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >4</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >5</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >6</td> 
				</tr>
				</thead>";
				
			$sql = "SELECT 
					SUM(CASE WHEN kd_rek='4' THEN (nil_ang) ELSE 0 END) - SUM(CASE WHEN kd_rek='5' THEN (nil_ang) ELSE 0 END) as ang_surplus,
					SUM(CASE WHEN kd_rek='4' THEN (kredit-debet) ELSE 0 END) - SUM(CASE WHEN kd_rek='5' THEN (debet-kredit) ELSE 0 END) as nil_surplus
					FROM
					(SELECT LEFT(kd_rek5,1) as kd_rek, SUM(nilai) as nil_ang, SUM(kredit) as kredit,SUM(debet) as debet FROM data_jurnal($bulan,$anggaran) WHERE LEFT(kd_rek5,1) IN ('4','5') $where
					GROUP BY LEFT(kd_rek5,1)) a;
					";
					  $hasil = $this->db->query($sql);
                    foreach ($hasil->result() as $row)
                    {
					   $ang_surplus = $row->ang_surplus;
                       $nil_surplus = $row->nil_surplus;
					}
					$sisa_surplus = $ang_surplus-$nil_surplus;
					if(($ang_surplus==0) || ($ang_surplus=='')){
						$persen_surplus=0;
					} else{
					$persen_surplus = $nil_surplus/$ang_surplus;
					}
					$hasil->free_result();        
					if($ang_surplus<0){
						$ang_surplus1=$ang_surplus*-1;
						$a='(';
						$b=')';
					} else{
						$ang_surplus1=$ang_surplus;
						$a='';
						$b='';
					}
					if($nil_surplus<0){
						$nil_surplus1=$nil_surplus*-1;
						$c='(';
						$d=')';
					} else{
						$nil_surplus1=$nil_surplus;
						$c='';
						$d='';
					}
					if($sisa_surplus<0){
						$sisa_surplus1=$sisa_surplus*-1;
						$e='(';
						$f=')';
					} else{
						$sisa_surplus1=$sisa_surplus;
						$e='';
						$f='';
					}
			
			$sql = "SELECT 
					SUM(CASE WHEN kd_rek='61' THEN (nil_ang) ELSE 0 END) - SUM(CASE WHEN kd_rek='62' THEN (nil_ang) ELSE 0 END) as ang_netto,
					SUM(CASE WHEN kd_rek='61' THEN (kredit-debet) ELSE 0 END) - SUM(CASE WHEN kd_rek='62' THEN (debet-kredit) ELSE 0 END) as nil_netto
					FROM
					(SELECT LEFT(kd_rek5,2) as kd_rek, SUM(nilai) as nil_ang, SUM(kredit) as kredit,SUM(debet) as debet FROM data_jurnal($bulan,$anggaran) WHERE LEFT(kd_rek5,2) IN ('61','62') $where
					GROUP BY LEFT(kd_rek5,2)) a;
					";
					  $hasil = $this->db->query($sql);
                    foreach ($hasil->result() as $row)
                    {
					   $ang_netto = $row->ang_netto;
                       $nil_netto = $row->nil_netto;
					}
					$sisa_netto = $ang_netto-$nil_netto;
					if(($ang_netto==0) || ($ang_netto=='')){
						$persen_netto=0;
					} else{
					$persen_netto = $nil_netto/$ang_netto;
					}
					$hasil->free_result();  
					if($ang_netto<0){
						$ang_netto1=$ang_netto*-1;
						$g='(';
						$h=')';
					} else{
						$ang_netto1=$ang_netto;
						$g='';
						$h='';
					}
					if($nil_netto<0){
						$nil_netto1=$nil_netto*-1;
						$i='(';
						$j=')';
					} else{
						$nil_netto1=$nil_netto;
						$i='';
						$j='';
					}
					if($sisa_netto<0){
						$sisa_netto1=$sisa_netto*-1;
						$k='(';
						$l=')';
					} else{
						$sisa_netto1=$sisa_netto;
						$k='';
						$l='';
					}	
					
					$ang_silpa = $ang_surplus+$ang_netto;
					$nil_silpa = $nil_surplus+$nil_netto;
					$sisa_silpa = $ang_silpa-$nil_silpa;
					if($ang_silpa==0){
						$persen_silpa=0;
					}else{
					$persen_silpa = $nil_silpa/$ang_silpa;
					}
					if($ang_silpa<0){
						$ang_silpa1=$ang_silpa*-1;
						$m='(';
						$n=')';
					} else{
						$ang_silpa1=$ang_silpa;
						$m='';
						$n='';
					}
					if($nil_silpa<0){
						$nil_silpa1=$nil_silpa*-1;
						$o='(';
						$p=')';
					} else{
						$nil_silpa1=$nil_silpa;
						$o='';
						$p='';
					}
					if($sisa_silpa<0){
						$sisa_silpa1=$sisa_silpa*-1;
						$q='(';
						$r=')';
					} else{
						$sisa_silpa1=$sisa_silpa;
						$q='';
						$r='';
					}	
			$sql = "SELECT seq, kode, nama, kode1, kode2, kode3,kode4, jenis, spasi FROM map_lra_sap ORDER BY seq
					";
					$no=0;
					$tot_peg=0;
					$tot_brg=0;
					$tot_mod=0;
					$tot_bansos=0;
                    $hasil = $this->db->query($sql);
                    foreach ($hasil->result() as $row)
                    {
					   $no=$no+1;
					   $seq = $row->seq;
					   $kode = $row->kode;
                       $nama = $row->nama;
                       $kode1 = $row->kode1;
                       $kode2 = $row->kode2;
                       $kode3 = $row->kode3;
                       $kode4 = $row->kode4;
                       $jenis = $row->jenis;
                       $spasi = $row->spasi;
					   
					   if($kode1==' '){
						$kode1="'X'";
						}
						if($kode2==' '){
							$kode2="'XX'";
						}
						if($kode3==' '){
							$kode3="'XXX'";
						}
						if($kode4==' '){
							$kode4="'XXXXX'";
						}
					$sql = "SELECT SUM(nilai) as nil_ang, SUM($jenis) as nilai FROM data_jurnal($bulan,$anggaran) WHERE (LEFT(kd_rek5,1) IN ($kode1) or LEFT(kd_rek5,2) IN ($kode2) or LEFT(kd_rek5,3) IN ($kode3) or LEFT(kd_rek5,5) IN($kode4)) $where
					";
										
					
                    $hasil = $this->db->query($sql);
                    foreach ($hasil->result() as $row)
                    {
                       $nil_ang = $row->nil_ang;
					   $nilai = $row->nilai;
					}
					$sel = $nil_ang-$nilai;
					if(($nil_ang==0) || ($nil_ang=='')){
						$persen=0;
					} else{
					$persen = $nilai/$nil_ang;
					}
					 switch ($spasi) {
					 case 1:
                        $cRet .='<tr>
							   <td align="left" valign="top"><b>'.$kode.'</b></td> 
							   <td align="left"  valign="top"><b>'.$nama.'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($nil_ang, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($nilai, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($sel, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($persen, "2", ",", ".").'</b></td> 
							</tr>'; 
                        break;	
                    case 2:
                         $cRet .='<tr>
							   <td align="left" valign="top"><b>'.$kode.'</b></td> 
							   <td align="left"  valign="top"><b>&nbsp;&nbsp;'.$nama.'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($nil_ang, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($nilai, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($sel, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($persen, "2", ",", ".").'</b></td> 
							</tr>';
                        break;
					 case 3:
                         $cRet .='<tr>
							   <td align="left" valign="top">'.$kode.'</b></td> 
							   <td align="left"  valign="top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$nama.'</td> 
							   <td align="right" valign="top">'.number_format($nil_ang, "2", ",", ".").'</td> 
							   <td align="right" valign="top">'.number_format($nilai, "2", ",", ".").'</td> 
							   <td align="right" valign="top">'.number_format($sel, "2", ",", ".").'</td> 
							   <td align="right" valign="top">'.number_format($persen, "2", ",", ".").'</td> 
							</tr>';
                        break;
					case 4:
                       $cRet .='<tr>
							   <td align="left" valign="top" ><b>'.$kode.'</b></td> 
							   <td align="left"  valign="top"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$nama.'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($nil_ang, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($nilai, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($sel, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($persen, "2", ",", ".").'</b></td> 
							</tr>';
                        break;
					case 5:
                       $cRet .='<tr>
							   <td align="left" valign="top" ><b>'.$kode.'</b></td> 
							   <td align="right"  valign="top"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$nama.'</b></td> 
							   <td align="right" valign="top"><b>'.$a.''.number_format($ang_surplus1, "2", ",", ".").''.$b.'</b></td> 
							   <td align="right" valign="top"><b>'.$c.''.number_format($nil_surplus1, "2", ",", ".").''.$d.'</b></td> 
							   <td align="right" valign="top"><b>'.$e.''.number_format($sisa_surplus1, "2", ",", ".").''.$f.'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($persen_surplus, "2", ",", ".").'</b></td> 
							</tr>';
                        break;
					case 6;
                       $cRet .='<tr>
							   <td align="left" valign="top" ><b>'.$kode.'</b></td> 
							   <td align="right"  valign="top"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$nama.'</b></td> 
							   <td align="right" valign="top" ><b>'.$g.''.number_format($ang_netto1, "2", ",", ".").''.$h.'</b></td> 
							   <td align="right" valign="top" ><b>'.$i.''.number_format($nil_netto1, "2", ",", ".").''.$j.'</b></td> 
							   <td align="right" valign="top" ><b>'.$k.''.number_format($sisa_netto1, "2", ",", ".").''.$l.'</b></td> 
							   <td align="right" valign="top" ><b>'.number_format($persen_netto, "2", ",", ".").'</b></td> 
							</tr>';
                        break;
					case 7;
                       $cRet .='<tr>
							   <td align="left" valign="top" ><b>'.$kode.'</b></td> 
							   <td align="right"  valign="top"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$nama.'</b></td> 
							   <td align="right" valign="top" ><b>'.$m.''.number_format($ang_silpa1, "2", ",", ".").''.$n.'</b></td> 
							   <td align="right" valign="top" ><b>'.$o.''.number_format($nil_silpa1, "2", ",", ".").''.$p.'</b></td> 
							   <td align="right" valign="top" ><b>'.$q.''.number_format($sisa_silpa1, "2", ",", ".").''.$r.'</b></td> 
							   <td align="right" valign="top" ><b>'.number_format($persen_silpa, "2", ",", ".").'</b></td> 
							</tr>';
                        break;
					}
					}
			 
                      
		
			$cRet .="</table>";
			$data['prev']= $cRet;    
            $judul='LRA_SAP ';
			switch ($ctk){
				case 0;
				echo ("<title>$judul</title>");
				echo $cRet;
				break;
				case 1;
				$this->tukd_model->_mpdf('',$cRet,10,10,10,'P');
				break;
				case 2;        
				header("Cache-Control: no-cache, no-store, must-revalidate");
				header("Content-Type: application/vnd.ms-excel");
				header("Content-Disposition: attachment; filename= $judul.xls");
				$this->load->view('anggaran/rka/perkadaII', $data);
				break;	
			}
		}
		
	function cetak_perda_lampI_sap_sp2d($bulan='',$ctk='',$anggaran='',$jenis='',$kd_skpd=''){
        $lntahunang = $this->session->userdata('pcThang');       
		 switch  ($bulan){
        case  1:
        $judul="JANUARI";
        break;
        case  2:
        $judul="FEBRUARI";
        break;
        case  3:
        $judul= "TRIWULAN I";
        break;
        case  4:
        $judul="APRIL";
        break;
        case  5:
        $judul= "MEI";
        break;
        case  6:
        $judul= "SEMESTER I";
        break;
        case  7:
        $judul= "JULI";
        break;
        case  8:
        $judul= "AGUSTUS";
        break;
        case  9:
        $judul= "TRIWULAN III";
        break;
        case  10:
        $judul= "OKTOBER";
        break;
        case  11:
        $judul= "NOVEMBER";
        break;
        case  12:
        $judul= "SEMESTER II";
        break;
    }
		if ($kd_skpd=='-'){                               
            $where="";            
        } else{
			$where="AND kd_skpd='$kd_skpd'";
		}
			
		if($jenis==2){
			$tabel='data_sp2d';
		  }else if($jenis==3){
			$tabel='data_sp2d_lunas';
		  } else if($jenis==4){
			$tabel='data_sp2d_advice';
		  }

		$cRet ='<TABLE style="border-collapse:collapse;font-size:11px;font-family:Arial" width="100%" border="0" cellspacing="0" cellpadding="1" align=center>
					<TR>
						<TD  width="60%" valign="top" align="right" > Lampiran I : </TD>
						<TD width="40%"  align="left" >Peraturan Daerah <br>Nomor : <br>Tanggal: </TD>
					</TR>
					<tr>
					</TABLE><br/>';
	$cRet .="<TABLE style=\"border-collapse:collapse;font-family:Arial\" width=\"100%\" border=\"1\" cellspacing=\"0\" cellpadding=\"1\" align=\"center\">
					<tr>
					<td rowspan=\"3\" align=\"center\" style=\"border-right:hidden\">
                        <img src=\"".base_url()."/image/logoHP.png\"  width=\"75\" height=\"100\" />
                        </td>
					<td align=\"center\" style=\"border-left:hidden;border-bottom:hidden\"><strong>PEMERINTAH KABUPATEN SANGGAU </strong></td></tr>
                    <tr><td align=\"center\" style=\"border-left:hidden;border-bottom:hidden;border-top:hidden\"><b>RINGKASAN LAPORAN REALISASI ANGGARAN </b></tr>
					<tr><td align=\"center\" style=\"border-left:hidden;border-top:hidden\" ><b>$judul</b></tr>
					</TABLE>";
			
		$cRet .="<table style=\"border-collapse:collapse;font-family:Arial;font-size:11px\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"3\" cellpadding=\"3\">
                <thead>
				<tr>
                    <td rowspan=\"2\" width=\"7%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>KD REK</b></td>
                    <td rowspan=\"2\" width=\"32%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>URAIAN</b></td>
                    <td colspan=\"2\" width=\"37%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>JUMLAH (Rp.)</b></td>
                    <td colspan=\"2\" width=\"23%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>BERTAMBAH/KURANG</b></td>
				</tr>
				<tr>
					<td width=\"19%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>ANGGARAN</b></td>
					<td width=\"18%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>REALISASI</b></td>
					<td width=\"18%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>(Rp)</b></td>
					<td width=\"5%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>%</b></td>
					</tr>
					<tr>
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >1</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >2</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >3</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >4</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >5</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >6</td> 
				</tr>
				</thead>";
				
			$sql = "SELECT 
					SUM(CASE WHEN kd_rek='4' THEN (nil_ang) ELSE 0 END) - SUM(CASE WHEN kd_rek='5' THEN (nil_ang) ELSE 0 END) as ang_surplus,
					SUM(CASE WHEN kd_rek='4' THEN (nilai) ELSE 0 END) - SUM(CASE WHEN kd_rek='5' THEN (nilai) ELSE 0 END) as nil_surplus
					FROM
					(SELECT LEFT(kd_rek5,1) as kd_rek, SUM(nil_ang) as nil_ang, SUM(nilai) as nilai FROM $tabel($bulan,$anggaran) WHERE LEFT(kd_rek5,1) IN ('4','5') $where
					GROUP BY LEFT(kd_rek5,1)) a;
					";
					  $hasil = $this->db->query($sql);
                    foreach ($hasil->result() as $row)
                    {
					   $ang_surplus = $row->ang_surplus;
                       $nil_surplus = $row->nil_surplus;
					}
					$sisa_surplus = $ang_surplus-$nil_surplus;
					if(($ang_surplus==0) || ($ang_surplus=='')){
						$persen_surplus=0;
					} else{
					$persen_surplus = $nil_surplus/$ang_surplus;
					}	
					$hasil->free_result();        
					if($ang_surplus<0){
						$ang_surplus1=$ang_surplus*-1;
						$a='(';
						$b=')';
					} else{
						$ang_surplus1=$ang_surplus;
						$a='';
						$b='';
					}
					if($nil_surplus<0){
						$nil_surplus1=$nil_surplus*-1;
						$c='(';
						$d=')';
					} else{
						$nil_surplus1=$nil_surplus;
						$c='';
						$d='';
					}
					if($sisa_surplus<0){
						$sisa_surplus1=$sisa_surplus*-1;
						$e='(';
						$f=')';
					} else{
						$sisa_surplus1=$sisa_surplus;
						$e='';
						$f='';
					}
			
			$sql = "SELECT 
					SUM(CASE WHEN kd_rek='61' THEN (nil_ang) ELSE 0 END) - SUM(CASE WHEN kd_rek='62' THEN (nil_ang) ELSE 0 END) as ang_netto,
					SUM(CASE WHEN kd_rek='61' THEN (nilai) ELSE 0 END) - SUM(CASE WHEN kd_rek='62' THEN (nilai) ELSE 0 END) as nil_netto
					FROM
					(SELECT LEFT(kd_rek5,2) as kd_rek, SUM(nil_ang) as nil_ang, SUM(nilai) as nilai FROM $tabel($bulan,$anggaran) WHERE LEFT(kd_rek5,2) IN ('61','62') $where
					GROUP BY LEFT(kd_rek5,2)) a;
					";
					  $hasil = $this->db->query($sql);
                    foreach ($hasil->result() as $row)
                    {
					   $ang_netto = $row->ang_netto;
                       $nil_netto = $row->nil_netto;
					}
					$sisa_netto = $ang_netto-$nil_netto;
					if(($ang_netto==0) || ($ang_netto=='')){
						$persen_netto=0;
					} else{
					$persen_netto = $nil_netto/$ang_netto;
					}
					$hasil->free_result();  
					if($ang_netto<0){
						$ang_netto1=$ang_netto*-1;
						$g='(';
						$h=')';
					} else{
						$ang_netto1=$ang_netto;
						$g='';
						$h='';
					}
					if($nil_netto<0){
						$nil_netto1=$nil_netto*-1;
						$i='(';
						$j=')';
					} else{
						$nil_netto1=$nil_netto;
						$i='';
						$j='';
					}
					if($sisa_netto<0){
						$sisa_netto1=$sisa_netto*-1;
						$k='(';
						$l=')';
					} else{
						$sisa_netto1=$sisa_netto;
						$k='';
						$l='';
					}	
					
					$ang_silpa = $ang_surplus+$ang_netto;
					$nil_silpa = $nil_surplus+$nil_netto;
					$sisa_silpa = $ang_silpa-$nil_silpa;
					if($ang_silpa==0){
						$persen_silpa=0;
					}else{
					$persen_silpa = $nil_silpa/$ang_silpa;
					}
					if($ang_silpa<0){
						$ang_silpa1=$ang_silpa*-1;
						$m='(';
						$n=')';
					} else{
						$ang_silpa1=$ang_silpa;
						$m='';
						$n='';
					}
					if($nil_silpa<0){
						$nil_silpa1=$nil_silpa*-1;
						$o='(';
						$p=')';
					} else{
						$nil_silpa1=$nil_silpa;
						$o='';
						$p='';
					}
					if($sisa_silpa<0){
						$sisa_silpa1=$sisa_silpa*-1;
						$q='(';
						$r=')';
					} else{
						$sisa_silpa1=$sisa_silpa;
						$q='';
						$r='';
					}	
			$sql = "SELECT seq, kode, nama, kode1, kode2, kode3,kode4, jenis, spasi FROM map_lra_sap ORDER BY seq
					";
					$no=0;
					$tot_peg=0;
					$tot_brg=0;
					$tot_mod=0;
					$tot_bansos=0;
                    $hasil = $this->db->query($sql);
                    foreach ($hasil->result() as $row)
                    {
					   $no=$no+1;
					   $seq = $row->seq;
					   $kode = $row->kode;
                       $nama = $row->nama;
                       $kode1 = $row->kode1;
                       $kode2 = $row->kode2;
                       $kode3 = $row->kode3;
                       $kode4 = $row->kode4;
                       //$jenis = $row->jenis;
                       $spasi = $row->spasi;
					   
					   if($kode1==''){
						$kode1="'X'";
						}
						if($kode2==''){
							$kode2="'XX'";
						}
						if($kode3==''){
							$kode3="'XXX'";
						}
						if($kode4==''){
							$kode4="'XXXXX'";
						}
					$sql = "SELECT SUM(nil_ang) as nil_ang, SUM(nilai) as nilai FROM $tabel($bulan,$anggaran) WHERE (LEFT(kd_rek5,1) IN ($kode1) or LEFT(kd_rek5,2) IN ($kode2) or LEFT(kd_rek5,3) IN ($kode3) or LEFT(kd_rek5,5) IN($kode4)) $where
					";
										
					
                    $hasil = $this->db->query($sql);
                    foreach ($hasil->result() as $row)
                    {
                       $nil_ang = $row->nil_ang;
					   $nilai = $row->nilai;
					}
					$sel = $nil_ang-$nilai;
					if(($nil_ang==0) || ($nil_ang=='')){
						$persen=0;
					} else{
					$persen = $nilai/$nil_ang;
					}
					 switch ($spasi) {
					 case 1:
                        $cRet .='<tr>
							   <td align="left" valign="top"><b>'.$kode.'</b></td> 
							   <td align="left"  valign="top"><b>'.$nama.'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($nil_ang, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($nilai, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($sel, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($persen, "2", ",", ".").'</b></td> 
							</tr>'; 
                        break;	
                    case 2:
                         $cRet .='<tr>
							   <td align="left" valign="top"><b>'.$kode.'</b></td> 
							   <td align="left"  valign="top"><b>&nbsp;&nbsp;'.$nama.'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($nil_ang, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($nilai, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($sel, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($persen, "2", ",", ".").'</b></td> 
							</tr>';
                        break;
					 case 3:
                         $cRet .='<tr>
							   <td align="left" valign="top">'.$kode.'</b></td> 
							   <td align="left"  valign="top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$nama.'</td> 
							   <td align="right" valign="top">'.number_format($nil_ang, "2", ",", ".").'</td> 
							   <td align="right" valign="top">'.number_format($nilai, "2", ",", ".").'</td> 
							   <td align="right" valign="top">'.number_format($sel, "2", ",", ".").'</td> 
							   <td align="right" valign="top">'.number_format($persen, "2", ",", ".").'</td> 
							</tr>';
                        break;
					case 4:
                       $cRet .='<tr>
							   <td align="left" valign="top" ><b>'.$kode.'</b></td> 
							   <td align="left"  valign="top"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$nama.'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($nil_ang, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($nilai, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($sel, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($persen, "2", ",", ".").'</b></td> 
							</tr>';
                        break;
					case 5:
                       $cRet .='<tr>
							   <td align="left" valign="top" ><b>'.$kode.'</b></td> 
							   <td align="right"  valign="top"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$nama.'</b></td> 
							   <td align="right" valign="top"><b>'.$a.''.number_format($ang_surplus1, "2", ",", ".").''.$b.'</b></td> 
							   <td align="right" valign="top"><b>'.$c.''.number_format($nil_surplus1, "2", ",", ".").''.$d.'</b></td> 
							   <td align="right" valign="top"><b>'.$e.''.number_format($sisa_surplus1, "2", ",", ".").''.$f.'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($persen_surplus, "2", ",", ".").'</b></td> 
							</tr>';
                        break;
					case 6;
                       $cRet .='<tr>
							   <td align="left" valign="top" ><b>'.$kode.'</b></td> 
							   <td align="right"  valign="top"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$nama.'</b></td> 
							   <td align="right" valign="top" ><b>'.$g.''.number_format($ang_netto1, "2", ",", ".").''.$h.'</b></td> 
							   <td align="right" valign="top" ><b>'.$i.''.number_format($nil_netto1, "2", ",", ".").''.$j.'</b></td> 
							   <td align="right" valign="top" ><b>'.$k.''.number_format($sisa_netto1, "2", ",", ".").''.$l.'</b></td> 
							   <td align="right" valign="top" ><b>'.number_format($persen_netto, "2", ",", ".").'</b></td> 
							</tr>';
                        break;
					case 7;
                       $cRet .='<tr>
							   <td align="left" valign="top" ><b>'.$kode.'</b></td> 
							   <td align="right"  valign="top"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$nama.'</b></td> 
							   <td align="right" valign="top" ><b>'.$m.''.number_format($ang_silpa1, "2", ",", ".").''.$n.'</b></td> 
							   <td align="right" valign="top" ><b>'.$o.''.number_format($nil_silpa1, "2", ",", ".").''.$p.'</b></td> 
							   <td align="right" valign="top" ><b>'.$q.''.number_format($sisa_silpa1, "2", ",", ".").''.$r.'</b></td> 
							   <td align="right" valign="top" ><b>'.number_format($persen_silpa, "2", ",", ".").'</b></td> 
							</tr>';
                        break;
					}
					}
			 
                      
		
			$cRet .="</table>";
			$data['prev']= $cRet;    
            $judul='LRA_SAP ';
			switch ($ctk){
				case 0;
				echo ("<title>$judul</title>");
				echo $cRet;
				break;
				case 1;
				$this->tukd_model->_mpdf('',$cRet,10,10,10,'P');
				break;
				case 2;        
				header("Cache-Control: no-cache, no-store, must-revalidate");
				header("Content-Type: application/vnd.ms-excel");
				header("Content-Disposition: attachment; filename= $judul.xls");
				$this->load->view('anggaran/rka/perkadaII', $data);
				break;	
			}
		}
		
	function cetak_perda_lampI_permen_spj($bulan='',$ctk='',$anggaran='',$jenis='',$kd_skpd=''){
        $lntahunang = $this->session->userdata('pcThang');       
		 switch  ($bulan){
        case  1:
        $judul="JANUARI";
        break;
        case  2:
        $judul="FEBRUARI";
        break;
        case  3:
        $judul= "TRIWULAN I";
        break;
        case  4:
        $judul="APRIL";
        break;
        case  5:
        $judul= "MEI";
        break;
        case  6:
        $judul= "SEMESTER I";
        break;
        case  7:
        $judul= "JULI";
        break;
        case  8:
        $judul= "AGUSTUS";
        break;
        case  9:
        $judul= "TRIWULAN III";
        break;
        case  10:
        $judul= "OKTOBER";
        break;
        case  11:
        $judul= "NOVEMBER";
        break;
        case  12:
        $judul= "SEMESTER II";
        break;
    }
		if ($kd_skpd=='-'){                               
            $where="";            
        } else{
			$where="AND kd_skpd='$kd_skpd'";
		}
		
		$cRet ='<TABLE style="border-collapse:collapse;font-size:11px;font-family:Arial" width="100%" border="0" cellspacing="0" cellpadding="1" align=center>
					<TR>
						<TD  width="60%" valign="top" align="right" > Lampiran I : </TD>
						<TD width="40%"  align="left" >Peraturan Daerah <br>Nomor : <br>Tanggal: </TD>
					</TR>
					<tr>
					</TABLE><br/>';
	$cRet .="<TABLE style=\"border-collapse:collapse;font-family:Arial\" width=\"100%\" border=\"1\" cellspacing=\"0\" cellpadding=\"1\" align=\"center\">
					<tr>
					<td rowspan=\"3\" align=\"center\" style=\"border-right:hidden\">
                        <img src=\"".base_url()."/image/logoHP.png\"  width=\"75\" height=\"100\" />
                        </td>
					<td align=\"center\" style=\"border-left:hidden;border-bottom:hidden\"><strong>PEMERINTAH KABUPATEN SANGGAU </strong></td></tr>
                    <tr><td align=\"center\" style=\"border-left:hidden;border-bottom:hidden;border-top:hidden\"><b>RINGKASAN LAPORAN REALISASI ANGGARAN </b></tr>
					<tr><td align=\"center\" style=\"border-left:hidden;border-top:hidden\" ><b>$judul $lntahunang</b></tr>
					</TABLE>";
			
		$cRet .="<table style=\"border-collapse:collapse;font-family:Arial;font-size:11px\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"3\" cellpadding=\"3\">
                <thead>
				<tr>
                    <td rowspan=\"2\" width=\"7%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>KD REK</b></td>
                    <td rowspan=\"2\" width=\"32%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>URAIAN</b></td>
                    <td colspan=\"2\" width=\"37%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>JUMLAH (Rp.)</b></td>
                    <td colspan=\"2\" width=\"23%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>BERTAMBAH/KURANG</b></td>
				</tr>
				<tr>
					<td width=\"19%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>ANGGARAN</b></td>
					<td width=\"18%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>REALISASI</b></td>
					<td width=\"18%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>(Rp)</b></td>
					<td width=\"5%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>%</b></td>
					</tr>
					<tr>
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >1</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >2</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >3</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >4</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >5</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >6</td> 
				</tr>
				</thead>";
				
			$sql = "SELECT 
					SUM(CASE WHEN kd_rek='4' THEN (nil_ang) ELSE 0 END) - SUM(CASE WHEN kd_rek='5' THEN (nil_ang) ELSE 0 END) as ang_surplus,
					SUM(CASE WHEN kd_rek='4' THEN (kredit-debet) ELSE 0 END) - SUM(CASE WHEN kd_rek='5' THEN (debet-kredit) ELSE 0 END) as nil_surplus
					FROM
					(SELECT LEFT(kd_rek5,1) as kd_rek, SUM(nilai) as nil_ang, SUM(kredit) as kredit,SUM(debet) as debet FROM data_jurnal($bulan,$anggaran) WHERE LEFT(kd_rek5,1) IN ('4','5') $where
					GROUP BY LEFT(kd_rek5,1)) a;
					";
					  $hasil = $this->db->query($sql);
                    foreach ($hasil->result() as $row)
                    {
					   $ang_surplus = $row->ang_surplus;
                       $nil_surplus = $row->nil_surplus;
					}
					$sisa_surplus = $ang_surplus-$nil_surplus;
						if(($ang_surplus==0) || ($ang_surplus=='')){
						$persen_surplus=0;
					} else{
					$persen_surplus = $nil_surplus/$ang_surplus;
					}	
										$hasil->free_result();        
					if($ang_surplus<0){
						$ang_surplus1=$ang_surplus*-1;
						$a='(';
						$b=')';
					} else{
						$ang_surplus1=$ang_surplus;
						$a='';
						$b='';
					}
					if($nil_surplus<0){
						$nil_surplus1=$nil_surplus*-1;
						$c='(';
						$d=')';
					} else{
						$nil_surplus1=$nil_surplus;
						$c='';
						$d='';
					}
					if($sisa_surplus<0){
						$sisa_surplus1=$sisa_surplus*-1;
						$e='(';
						$f=')';
					} else{
						$sisa_surplus1=$sisa_surplus;
						$e='';
						$f='';
					}
			
			$sql = "SELECT 
					SUM(CASE WHEN kd_rek='61' THEN (nil_ang) ELSE 0 END) - SUM(CASE WHEN kd_rek='62' THEN (nil_ang) ELSE 0 END) as ang_netto,
					SUM(CASE WHEN kd_rek='61' THEN (kredit-debet) ELSE 0 END) - SUM(CASE WHEN kd_rek='62' THEN (debet-kredit) ELSE 0 END) as nil_netto
					FROM
					(SELECT LEFT(kd_rek5,2) as kd_rek, SUM(nilai) as nil_ang, SUM(kredit) as kredit,SUM(debet) as debet FROM data_jurnal($bulan,$anggaran) WHERE LEFT(kd_rek5,2) IN ('61','62') $where
					GROUP BY LEFT(kd_rek5,2)) a;
					";
					  $hasil = $this->db->query($sql);
                    foreach ($hasil->result() as $row)
                    {
					   $ang_netto = $row->ang_netto;
                       $nil_netto = $row->nil_netto;
					}
					$sisa_netto = $ang_netto-$nil_netto;
					if(($ang_netto==0) || ($ang_netto=='')){
						$persen_netto=0;
					} else{
					$persen_netto = $nil_netto/$ang_netto;
					}
					$hasil->free_result();  
					if($ang_netto<0){
						$ang_netto1=$ang_netto*-1;
						$g='(';
						$h=')';
					} else{
						$ang_netto1=$ang_netto;
						$g='';
						$h='';
					}
					if($nil_netto<0){
						$nil_netto1=$nil_netto*-1;
						$i='(';
						$j=')';
					} else{
						$nil_netto1=$nil_netto;
						$i='';
						$j='';
					}
					if($sisa_netto<0){
						$sisa_netto1=$sisa_netto*-1;
						$k='(';
						$l=')';
					} else{
						$sisa_netto1=$sisa_netto;
						$k='';
						$l='';
					}	
					
					$ang_silpa = $ang_surplus+$ang_netto;
					$nil_silpa = $nil_surplus+$nil_netto;
					$sisa_silpa = $ang_silpa-$nil_silpa;
					if($ang_silpa==0){
						$persen_silpa=0;
					}else{
					$persen_silpa = $nil_silpa/$ang_silpa;
					}
					if($ang_silpa<0){
						$ang_silpa1=$ang_silpa*-1;
						$m='(';
						$n=')';
					} else{
						$ang_silpa1=$ang_silpa;
						$m='';
						$n='';
					}
					if($nil_silpa<0){
						$nil_silpa1=$nil_silpa*-1;
						$o='(';
						$p=')';
					} else{
						$nil_silpa1=$nil_silpa;
						$o='';
						$p='';
					}
					if($sisa_silpa<0){
						$sisa_silpa1=$sisa_silpa*-1;
						$q='(';
						$r=')';
					} else{
						$sisa_silpa1=$sisa_silpa;
						$q='';
						$r='';
					}	
			$sql = "SELECT seq, kode, nama, kode1, kode2, kode3,kode4, jenis, spasi FROM map_lra_permen ORDER BY seq
					";
					$no=0;
					$tot_peg=0;
					$tot_brg=0;
					$tot_mod=0;
					$tot_bansos=0;
                    $hasil = $this->db->query($sql);
                    foreach ($hasil->result() as $row)
                    {
					   $no=$no+1;
					   $seq = $row->seq;
					   $kode = $row->kode;
                       $nama = $row->nama;
                       $kode1 = $row->kode1;
                       $kode2 = $row->kode2;
                       $kode3 = $row->kode3;
                       $kode4 = $row->kode4;
                       $jenis = $row->jenis;
                       $spasi = $row->spasi;
					   
					   if($kode1==' '){
						$kode1="'X'";
						}
						if($kode2==' '){
							$kode2="'XX'";
						}
						if($kode3==' '){
							$kode3="'XXX'";
						}
						if($kode4==' '){
							$kode4="'XXXXX'";
						}
					$sql = "SELECT SUM(nilai) as nil_ang, SUM($jenis) as nilai FROM data_jurnal($bulan,$anggaran) WHERE (LEFT(kd_rek5,1) IN ($kode1) or LEFT(kd_rek5,2) IN ($kode2) or LEFT(kd_rek5,3) IN ($kode3) or LEFT(kd_rek5,5) IN($kode4)) $where
					";
										
					
                    $hasil = $this->db->query($sql);
                    foreach ($hasil->result() as $row)
                    {
                       $nil_ang = $row->nil_ang;
					   $nilai = $row->nilai;
					}
					$sel = $nil_ang-$nilai;
					if(($nil_ang==0) || ($nil_ang=='')){
						$persen=0;
					} else{
					$persen = $nilai/$nil_ang;
					}
					 switch ($spasi) {
					 case 1:
                        $cRet .='<tr>
							   <td align="left" valign="top"><b>'.$kode.'</b></td> 
							   <td align="left"  valign="top"><b>'.$nama.'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($nil_ang, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($nilai, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($sel, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($persen, "2", ",", ".").'</b></td> 
							</tr>'; 
                        break;	
                    case 2:
                         $cRet .='<tr>
							   <td align="left" valign="top"><b>'.$kode.'</b></td> 
							   <td align="left"  valign="top"><b>&nbsp;&nbsp;'.$nama.'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($nil_ang, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($nilai, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($sel, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($persen, "2", ",", ".").'</b></td> 
							</tr>';
                        break;
					 case 3:
                         $cRet .='<tr>
							   <td align="left" valign="top">'.$kode.'</b></td> 
							   <td align="left"  valign="top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$nama.'</td> 
							   <td align="right" valign="top">'.number_format($nil_ang, "2", ",", ".").'</td> 
							   <td align="right" valign="top">'.number_format($nilai, "2", ",", ".").'</td> 
							   <td align="right" valign="top">'.number_format($sel, "2", ",", ".").'</td> 
							   <td align="right" valign="top">'.number_format($persen, "2", ",", ".").'</td> 
							</tr>';
                        break;
					case 4:
                       $cRet .='<tr>
							   <td align="left" valign="top" ><b>'.$kode.'</b></td> 
							   <td align="left"  valign="top"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$nama.'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($nil_ang, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($nilai, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($sel, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($persen, "2", ",", ".").'</b></td> 
							</tr>';
                        break;
					case 5:
                       $cRet .='<tr>
							   <td align="left" valign="top" ><b>'.$kode.'</b></td> 
							   <td align="right"  valign="top"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$nama.'</b></td> 
							   <td align="right" valign="top"><b>'.$a.''.number_format($ang_surplus1, "2", ",", ".").''.$b.'</b></td> 
							   <td align="right" valign="top"><b>'.$c.''.number_format($nil_surplus1, "2", ",", ".").''.$d.'</b></td> 
							   <td align="right" valign="top"><b>'.$e.''.number_format($sisa_surplus1, "2", ",", ".").''.$f.'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($persen_surplus, "2", ",", ".").'</b></td> 
							</tr>';
                        break;
					case 6;
                       $cRet .='<tr>
							   <td align="left" valign="top" ><b>'.$kode.'</b></td> 
							   <td align="right"  valign="top"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$nama.'</b></td> 
							   <td align="right" valign="top" ><b>'.$g.''.number_format($ang_netto1, "2", ",", ".").''.$h.'</b></td> 
							   <td align="right" valign="top" ><b>'.$i.''.number_format($nil_netto1, "2", ",", ".").''.$j.'</b></td> 
							   <td align="right" valign="top" ><b>'.$k.''.number_format($sisa_netto1, "2", ",", ".").''.$l.'</b></td> 
							   <td align="right" valign="top" ><b>'.number_format($persen_netto, "2", ",", ".").'</b></td> 
							</tr>';
                        break;
					case 7;
                       $cRet .='<tr>
							   <td align="left" valign="top" ><b>'.$kode.'</b></td> 
							   <td align="right"  valign="top"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$nama.'</b></td> 
							   <td align="right" valign="top" ><b>'.$m.''.number_format($ang_silpa1, "2", ",", ".").''.$n.'</b></td> 
							   <td align="right" valign="top" ><b>'.$o.''.number_format($nil_silpa1, "2", ",", ".").''.$p.'</b></td> 
							   <td align="right" valign="top" ><b>'.$q.''.number_format($sisa_silpa1, "2", ",", ".").''.$r.'</b></td> 
							   <td align="right" valign="top" ><b>'.number_format($persen_silpa, "2", ",", ".").'</b></td> 
							</tr>';
                        break;
					}
					}
			 
                      
		
			$cRet .="</table>";
			$data['prev']= $cRet;    
            $judul='LRA_PERMEN ';
			switch ($ctk){
				case 0;
				echo ("<title>$judul</title>");
				echo $cRet;
				break;
				case 1;
				$this->tukd_model->_mpdf('',$cRet,10,10,10,'P');
				break;
				case 2;        
				header("Cache-Control: no-cache, no-store, must-revalidate");
				header("Content-Type: application/vnd.ms-excel");
				header("Content-Disposition: attachment; filename= $judul.xls");
				$this->load->view('anggaran/rka/perkadaII', $data);
				break;	
			}
		}
		
	function cetak_perda_lampI_permen_sp2d($bulan='',$ctk='',$anggaran='',$jenis='', $kd_skpd=''){
        $lntahunang = $this->session->userdata('pcThang');       
		 switch  ($bulan){
        case  1:
        $judul="JANUARI";
        break;
        case  2:
        $judul="FEBRUARI";
        break;
        case  3:
        $judul= "TRIWULAN I";
        break;
        case  4:
        $judul="APRIL";
        break;
        case  5:
        $judul= "MEI";
        break;
        case  6:
        $judul= "SEMESTER I";
        break;
        case  7:
        $judul= "JULI";
        break;
        case  8:
        $judul= "AGUSTUS";
        break;
        case  9:
        $judul= "TRIWULAN III";
        break;
        case  10:
        $judul= "OKTOBER";
        break;
        case  11:
        $judul= "NOVEMBER";
        break;
        case  12:
        $judul= "SEMESTER II";
        break;
    }
		
		if ($kd_skpd=='-'){                               
            $where="";            
        } else{
			$where="AND kd_skpd='$kd_skpd'";
		}
		
		if($jenis==2){
			$tabel='data_sp2d';
		  }else if($jenis==3){
			$tabel='data_sp2d_lunas';
		  } else if($jenis==4){
			$tabel='data_sp2d_advice';
		  }

		
		$cRet ='<TABLE style="border-collapse:collapse;font-size:11px;font-family:Arial" width="100%" border="0" cellspacing="0" cellpadding="1" align=center>
					<TR>
						<TD  width="60%" valign="top" align="right" > Lampiran I : </TD>
						<TD width="40%"  align="left" >Peraturan Daeraht <br>Nomor : <br>Tanggal: </TD>
					</TR>
					<tr>
					</TABLE><br/>';
	$cRet .="<TABLE style=\"border-collapse:collapse;font-family:Arial\" width=\"100%\" border=\"1\" cellspacing=\"0\" cellpadding=\"1\" align=\"center\">
					<tr>
					<td rowspan=\"3\" align=\"center\" style=\"border-right:hidden\">
                        <img src=\"".base_url()."/image/logoHP.png\"  width=\"75\" height=\"100\" />
                        </td>
					<td align=\"center\" style=\"border-left:hidden;border-bottom:hidden\"><strong>PEMERINTAH KABUPATEN SANGGAU </strong></td></tr>
                    <tr><td align=\"center\" style=\"border-left:hidden;border-bottom:hidden;border-top:hidden\"><b>RINGKASAN LAPORAN REALISASI ANGGARAN </b></tr>
					<tr><td align=\"center\" style=\"border-left:hidden;border-top:hidden\" ><b>$judul</b></tr>
					</TABLE>";
			
		$cRet .="<table style=\"border-collapse:collapse;font-family:Arial;font-size:11px\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"3\" cellpadding=\"3\">
                <thead>
				<tr>
                    <td rowspan=\"2\" width=\"7%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>KD REK</b></td>
                    <td rowspan=\"2\" width=\"32%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>URAIAN</b></td>
                    <td colspan=\"2\" width=\"37%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>JUMLAH (Rp.)</b></td>
                    <td colspan=\"2\" width=\"23%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>BERTAMBAH/KURANG</b></td>
				</tr>
				<tr>
					<td width=\"19%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>ANGGARAN</b></td>
					<td width=\"18%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>REALISASI</b></td>
					<td width=\"18%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>(Rp)</b></td>
					<td width=\"5%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>%</b></td>
					</tr>
					<tr>
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >1</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >2</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >3</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >4</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >5</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >6</td> 
				</tr>
				</thead>";
				
			$sql = "SELECT 
					SUM(CASE WHEN kd_rek='4' THEN (nil_ang) ELSE 0 END) - SUM(CASE WHEN kd_rek='5' THEN (nil_ang) ELSE 0 END) as ang_surplus,
					SUM(CASE WHEN kd_rek='4' THEN (nilai) ELSE 0 END) - SUM(CASE WHEN kd_rek='5' THEN (nilai) ELSE 0 END) as nil_surplus
					FROM
					(SELECT LEFT(kd_rek5,1) as kd_rek, SUM(nil_ang) as nil_ang, SUM(nilai) as nilai FROM $tabel($bulan,$anggaran) WHERE LEFT(kd_rek5,1) IN ('4','5') $where
					GROUP BY LEFT(kd_rek5,1)) a;
					";
					  $hasil = $this->db->query($sql);
                    foreach ($hasil->result() as $row)
                    {
					   $ang_surplus = $row->ang_surplus;
                       $nil_surplus = $row->nil_surplus;
					}
					$sisa_surplus = $ang_surplus-$nil_surplus;
						if(($ang_surplus==0) || ($ang_surplus=='')){
						$persen_surplus=0;
					} else{
					$persen_surplus = $nil_surplus/$ang_surplus;
					}	
					$hasil->free_result();        
					if($ang_surplus<0){
						$ang_surplus1=$ang_surplus*-1;
						$a='(';
						$b=')';
					} else{
						$ang_surplus1=$ang_surplus;
						$a='';
						$b='';
					}
					if($nil_surplus<0){
						$nil_surplus1=$nil_surplus*-1;
						$c='(';
						$d=')';
					} else{
						$nil_surplus1=$nil_surplus;
						$c='';
						$d='';
					}
					if($sisa_surplus<0){
						$sisa_surplus1=$sisa_surplus*-1;
						$e='(';
						$f=')';
					} else{
						$sisa_surplus1=$sisa_surplus;
						$e='';
						$f='';
					}
			
			$sql = "SELECT 
					SUM(CASE WHEN kd_rek='61' THEN (nil_ang) ELSE 0 END) - SUM(CASE WHEN kd_rek='62' THEN (nil_ang) ELSE 0 END) as ang_netto,
					SUM(CASE WHEN kd_rek='61' THEN (nilai) ELSE 0 END) - SUM(CASE WHEN kd_rek='62' THEN (nilai) ELSE 0 END) as nil_netto
					FROM
					(SELECT LEFT(kd_rek5,2) as kd_rek, SUM(nil_ang) as nil_ang, SUM(nilai) as nilai FROM $tabel($bulan,$anggaran) WHERE LEFT(kd_rek5,2) IN ('61','62')  $where
					GROUP BY LEFT(kd_rek5,2)) a;
					";
					  $hasil = $this->db->query($sql);
                    foreach ($hasil->result() as $row)
                    {
					   $ang_netto = $row->ang_netto;
                       $nil_netto = $row->nil_netto;
					}
					$sisa_netto = $ang_netto-$nil_netto;
					if(($ang_netto==0) || ($ang_netto=='')){
						$persen_netto=0;
					} else{
					$persen_netto = $nil_netto/$ang_netto;
					}
					$hasil->free_result();  
					if($ang_netto<0){
						$ang_netto1=$ang_netto*-1;
						$g='(';
						$h=')';
					} else{
						$ang_netto1=$ang_netto;
						$g='';
						$h='';
					}
					if($nil_netto<0){
						$nil_netto1=$nil_netto*-1;
						$i='(';
						$j=')';
					} else{
						$nil_netto1=$nil_netto;
						$i='';
						$j='';
					}
					if($sisa_netto<0){
						$sisa_netto1=$sisa_netto*-1;
						$k='(';
						$l=')';
					} else{
						$sisa_netto1=$sisa_netto;
						$k='';
						$l='';
					}	
					
					$ang_silpa = $ang_surplus+$ang_netto;
					$nil_silpa = $nil_surplus+$nil_netto;
					$sisa_silpa = $ang_silpa-$nil_silpa;
					if($ang_silpa==0){
						$persen_silpa=0;
					}else{
					$persen_silpa = $nil_silpa/$ang_silpa;
					}
					if($ang_silpa<0){
						$ang_silpa1=$ang_silpa*-1;
						$m='(';
						$n=')';
					} else{
						$ang_silpa1=$ang_silpa;
						$m='';
						$n='';
					}
					if($nil_silpa<0){
						$nil_silpa1=$nil_silpa*-1;
						$o='(';
						$p=')';
					} else{
						$nil_silpa1=$nil_silpa;
						$o='';
						$p='';
					}
					if($sisa_silpa<0){
						$sisa_silpa1=$sisa_silpa*-1;
						$q='(';
						$r=')';
					} else{
						$sisa_silpa1=$sisa_silpa;
						$q='';
						$r='';
					}	
			$sql = "SELECT seq, kode, nama, kode1, kode2, kode3,kode4, jenis, spasi FROM map_lra_permen ORDER BY seq
					";
					$no=0;
					$tot_peg=0;
					$tot_brg=0;
					$tot_mod=0;
					$tot_bansos=0;
                    $hasil = $this->db->query($sql);
                    foreach ($hasil->result() as $row)
                    {
					   $no=$no+1;
					   $seq = $row->seq;
					   $kode = $row->kode;
                       $nama = $row->nama;
                       $kode1 = $row->kode1;
                       $kode2 = $row->kode2;
                       $kode3 = $row->kode3;
                       $kode4 = $row->kode4;
                       //$jenis = $row->jenis;
                       $spasi = $row->spasi;
					   
					   if($kode1==''){
						$kode1="'X'";
						}
						if($kode2==''){
							$kode2="'XX'";
						}
						if($kode3==''){
							$kode3="'XXX'";
						}
						if($kode4==''){
							$kode4="'XXXXX'";
						}
					$sql = "SELECT SUM(nil_ang) as nil_ang, SUM(nilai) as nilai FROM $tabel($bulan,$anggaran) WHERE (LEFT(kd_rek5,1) IN ($kode1) or LEFT(kd_rek5,2) IN ($kode2) or LEFT(kd_rek5,3) IN ($kode3) or LEFT(kd_rek5,5) IN($kode4))  $where
					";
										
					
                    $hasil = $this->db->query($sql);
                    foreach ($hasil->result() as $row)
                    {
                       $nil_ang = $row->nil_ang;
					   $nilai = $row->nilai;
					}
					$sel = $nil_ang-$nilai;
					if(($nil_ang==0) || ($nil_ang=='')){
						$persen=0;
					} else{
					$persen = $nilai/$nil_ang;
					}
					 switch ($spasi) {
					 case 1:
                        $cRet .='<tr>
							   <td align="left" valign="top"><b>'.$kode.'</b></td> 
							   <td align="left"  valign="top"><b>'.$nama.'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($nil_ang, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($nilai, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($sel, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($persen, "2", ",", ".").'</b></td> 
							</tr>'; 
                        break;	
                    case 2:
                         $cRet .='<tr>
							   <td align="left" valign="top"><b>'.$kode.'</b></td> 
							   <td align="left"  valign="top"><b>&nbsp;&nbsp;'.$nama.'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($nil_ang, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($nilai, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($sel, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($persen, "2", ",", ".").'</b></td> 
							</tr>';
                        break;
					 case 3:
                         $cRet .='<tr>
							   <td align="left" valign="top">'.$kode.'</b></td> 
							   <td align="left"  valign="top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$nama.'</td> 
							   <td align="right" valign="top">'.number_format($nil_ang, "2", ",", ".").'</td> 
							   <td align="right" valign="top">'.number_format($nilai, "2", ",", ".").'</td> 
							   <td align="right" valign="top">'.number_format($sel, "2", ",", ".").'</td> 
							   <td align="right" valign="top">'.number_format($persen, "2", ",", ".").'</td> 
							</tr>';
                        break;
					case 4:
                       $cRet .='<tr>
							   <td align="left" valign="top" ><b>'.$kode.'</b></td> 
							   <td align="left"  valign="top"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$nama.'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($nil_ang, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($nilai, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($sel, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($persen, "2", ",", ".").'</b></td> 
							</tr>';
                        break;
					case 5:
                       $cRet .='<tr>
							   <td align="left" valign="top" ><b>'.$kode.'</b></td> 
							   <td align="right"  valign="top"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$nama.'</b></td> 
							   <td align="right" valign="top"><b>'.$a.''.number_format($ang_surplus1, "2", ",", ".").''.$b.'</b></td> 
							   <td align="right" valign="top"><b>'.$c.''.number_format($nil_surplus1, "2", ",", ".").''.$d.'</b></td> 
							   <td align="right" valign="top"><b>'.$e.''.number_format($sisa_surplus1, "2", ",", ".").''.$f.'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($persen_surplus, "2", ",", ".").'</b></td> 
							</tr>';
                        break;
					case 6;
                       $cRet .='<tr>
							   <td align="left" valign="top" ><b>'.$kode.'</b></td> 
							   <td align="right"  valign="top"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$nama.'</b></td> 
							   <td align="right" valign="top" ><b>'.$g.''.number_format($ang_netto1, "2", ",", ".").''.$h.'</b></td> 
							   <td align="right" valign="top" ><b>'.$i.''.number_format($nil_netto1, "2", ",", ".").''.$j.'</b></td> 
							   <td align="right" valign="top" ><b>'.$k.''.number_format($sisa_netto1, "2", ",", ".").''.$l.'</b></td> 
							   <td align="right" valign="top" ><b>'.number_format($persen_netto, "2", ",", ".").'</b></td> 
							</tr>';
                        break;
					case 7;
                       $cRet .='<tr>
							   <td align="left" valign="top" ><b>'.$kode.'</b></td> 
							   <td align="right"  valign="top"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$nama.'</b></td> 
							   <td align="right" valign="top" ><b>'.$m.''.number_format($ang_silpa1, "2", ",", ".").''.$n.'</b></td> 
							   <td align="right" valign="top" ><b>'.$o.''.number_format($nil_silpa1, "2", ",", ".").''.$p.'</b></td> 
							   <td align="right" valign="top" ><b>'.$q.''.number_format($sisa_silpa1, "2", ",", ".").''.$r.'</b></td> 
							   <td align="right" valign="top" ><b>'.number_format($persen_silpa, "2", ",", ".").'</b></td> 
							</tr>';
                        break;
					}
					}
			 
                      
		
			$cRet .="</table>";
			$data['prev']= $cRet;    
            $judul='LRA_PERMEN ';
			switch ($ctk){
				case 0;
				echo ("<title>$judul</title>");
				echo $cRet;
				break;
				case 1;
				$this->tukd_model->_mpdf('',$cRet,10,10,10,'P');
				break;
				case 2;        
				header("Cache-Control: no-cache, no-store, must-revalidate");
				header("Content-Type: application/vnd.ms-excel");
				header("Content-Disposition: attachment; filename= $judul.xls");
				$this->load->view('anggaran/rka/perkadaII', $data);
				break;	
			}
		}
			
	function cetak_perda_lampI_2($bulan='',$ctk='',$anggaran='',$kd_skpd='',$jenis='',$tglttd='', $ttd=''){
        $lntahunang = $this->session->userdata('pcThang');       
		switch  ($bulan){
        case  1:
        $judul="JANUARI";
        break;
        case  2:
        $judul="FEBRUARI";
        break;
        case  3:
        $judul= "MARET";
        break;
        case  4:
        $judul="APRIL";
        break;
        case  5:
        $judul= "MEI";
        break;
        case  6:
        $judul= "JUNI";
        break;
        case  7:
        $judul= "JULI";
        break;
        case  8:
        $judul= "AGUSTUS";
        break;
        case  9:
        $judul= "SEPTEMBER";
        break;
        case  10:
        $judul= "OKTOBER";
        break;
        case  11:
        $judul= "NOVEMBER";
        break;
        case  12:
        $judul= "DESEMBER";
        break;
    }
		$where= "WHERE kd_skpd='$kd_skpd'";	
		$tanggal = $tglttd == '-' ? '' : 'Sanggau, '.$this->tukd_model->tanggal_format_indonesia($tglttd) ;
	if($ttd=='-'){
		$nama='';
		$pangkat='';
		$jabatan='';
		$nip='';
	}else{
	$ttd=str_replace("abc"," ",$ttd);
	$sqlsc="SELECT nama,jabatan,pangkat FROM ms_ttd where nip='$ttd' AND kode='PA' and kd_skpd='1.20.00.00'";
                 $sqlsclient=$this->db->query($sqlsc);
                 foreach ($sqlsclient->result() as $rowttd)
                {
                    $nama = $rowttd->nama;
                    $jabatan = $rowttd->jabatan;
                    $pangkat = $rowttd->pangkat;
                    $nip = 'NIP. '.$ttd;
                } 
	}
		$cRet ='<TABLE style="border-collapse:collapse;font-size:11px;font-family:Arial" width="100%" border="0" cellspacing="0" cellpadding="1" align=center>
					<TR>
						<TD  width="60%" valign="top" align="right" > &nbsp;</TD>
						<TD width="40%"  align="left" >Lampiran I.2<br>Rancangan Peraturan Daerah<br>Nomor : <br>Tanggal : </TD>
					</TR>
					<tr>
					</TABLE><br/>';
	
	$cRet .="<TABLE style=\"border-collapse:collapse;font-family:Arial\" width=\"100%\" border=\"1\" cellspacing=\"0\" cellpadding=\"1\" align=\"center\">
					<tr>
					<td rowspan=\"4\" align=\"center\" style=\"border-right:hidden\">
                        <img src=\"".base_url()."/image/logoHP.png\"  width=\"75\" height=\"100\" />
                        </td>
					<td align=\"center\" style=\"border-left:hidden;border-bottom:hidden\"><strong>PEMERINTAH KABUPATEN SANGGAU </strong></td></tr>
                    <tr><td align=\"center\" style=\"border-left:hidden;border-bottom:hidden;border-top:hidden\"><b>RINCIAN LAPORAN REALISASI ANGGARAN MENURUT URUSAN PEMERINTAHAN DAERAH,ORGANISASI, </b></tr>
                    <tr><td align=\"center\" style=\"border-left:hidden;border-bottom:hidden;border-top:hidden\"><b>PENDAPATAN, BELANJA DAN PEMBIAYAAN</b></tr>
                    <tr><td align=\"center\" style=\"border-left:hidden;border-bottom:hidden;border-top:hidden\"><b>TAHUN ANGGARAN $lntahunang </b></tr>
					</TABLE>";
	$cRet .="<TABLE style=\"border-collapse:collapse;font-family:Arial;font-size:12px\" width=\"100%\" border=\"1\" cellspacing=\"0\" cellpadding=\"1\" align=\"center\">
					<tr>
					<td width=\"15%\" align=\"left\" style=\"border-right:hidden;border-bottom:hidden\">&nbsp;&nbsp; Urusan Pemerintahan </td>
					<td width=\"85%\" align=\"left\" style=\"border-left:hidden;border-bottom:hidden\"> : ".$this->left($kd_skpd,1)." - ".$this->tukd_model->get_nama($this->left($kd_skpd,1),'nm_urusan1','ms_urusan1','kd_urusan1')." </td>
					</tr>
					<tr>
					<td align=\"left\" style=\"border-right:hidden;border-bottom:hidden\"> &nbsp;&nbsp; Bidang Pemerintahan </td>
					<td align=\"left\" style=\"border-left:hidden;border-bottom:hidden\"> : ".$this->left($kd_skpd,4)." - ".$this->tukd_model->get_nama($this->left($kd_skpd,4),'nm_urusan','ms_urusan','kd_urusan')."</td>
					</tr>
					<tr>
					<td align=\"left\" style=\"border-right:hidden;border-bottom:hidden\"> &nbsp;&nbsp; Unit Organisasi </td>
					<td align=\"left\" style=\"border-left:hidden;border-bottom:hidden\"> : ".$this->left($kd_skpd,7)." - ".$this->tukd_model->get_nama($this->left($kd_skpd,7),'nm_org','ms_organisasi','kd_org')."</td>
					</tr>
					<tr>
					<td align=\"left\" style=\"border-right:hidden;border-bottom:hidden\">&nbsp;&nbsp; Sub Unit Organisasi </td>
					<td align=\"left\" style=\"border-left:hidden;border-bottom:hidden\"> : ".$this->left($kd_skpd,10)." - ".$this->tukd_model->get_nama($this->left($kd_skpd,10),'nm_skpd','ms_skpd','kd_skpd')."</td>
					</tr>
                    </TABLE>";
		
		$cRet .="<table style=\"border-collapse:collapse;font-family:Arial;font-size:11px\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"3\" cellpadding=\"3\">
                <thead>
				<tr>
                    <td rowspan=\"2\" width=\"7%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>KD REK</b></td>
                    <td rowspan=\"2\" width=\"25%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>URAIAN</b></td>
                    <td colspan=\"2\" width=\"45%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>JUMLAH (Rp.)</b></td>
                    <td colspan=\"2\" width=\"15%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>BERTAMBAH(BERKURANG)</b></td>
                    <td rowspan=\"2\" width=\"5%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>DASAR HUKUM</b></td>
				</tr>
				<tr>
					<td width=\"15%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>ANGGARAN</b></td>
					<td width=\"15%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>REALISASI</b></td>
					<td width=\"15%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>Rp.</b></td>
					<td width=\"15%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>%</b></td>
					</tr>
					<tr>
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >1</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >2</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >3</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >4</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >5=(4-3)</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >6)</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >7</td> 
				</tr>
				</thead>";
				
				$sql="SELECT kd_kegiatan,kd_rek,nm_rek,anggaran,sd_bulan_ini FROM realisasi_jurnal_pend($bulan,$anggaran) $where ORDER BY kd_kegiatan,kd_rek";
					$hasil = $this->db->query($sql);
                    foreach ($hasil->result() as $row)
                    {
					   $kd_kegiatan = $row->kd_kegiatan;
					   $kd_rek = $row->kd_rek;
                       $nm_rek = $row->nm_rek;
                       $nil_ang = $row->anggaran;
                       $sd_bulan_ini = $row->sd_bulan_ini;
					   $sisa=$sd_bulan_ini-$nil_ang;
					   $persen = empty($nil_ang) || $nil_ang == 0 ? 0 :$sd_bulan_ini/$nil_ang;
					   $sisa1 = $sisa<0 ? $sisa*-1 :$sisa;
					   $a = $sisa<0 ? '(' :'';
					   $b = $sisa<0 ? ')' :'';
					   $leng=strlen($kd_rek);
					   switch ($leng) {
					   case 3:
					   $cRet .='<tr>
							   <td align="left" valign="top">'.$kd_kegiatan.'.'.$this->dotrek($kd_rek).'</td> 
							   <td align="left"  valign="top">'.$nm_rek.'</td> 
							   <td align="right" valign="top">'.number_format($nil_ang, "2", ",", ".").'</td> 
							   <td align="right" valign="top">'.number_format($sd_bulan_ini, "2", ",", ".").'</td> 
							   <td align="right" valign="top">'.$a.' '.number_format($sisa1, "2", ",", ".").' '.$b.'</td> 
							   <td align="right" valign="top">'.number_format($persen, "2", ",", ".").'</td> 
							   <td align="right" valign="top"></td> 
							</tr>';
					   break;
					   default:
					    $cRet .='<tr>
							   <td align="left" valign="top"><b>'.$kd_kegiatan.'.'.$this->dotrek($kd_rek).'</b></td> 
							   <td align="left"  valign="top"><b>'.$nm_rek.'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($nil_ang, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($sd_bulan_ini, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.$a.' '.number_format($sisa1, "2", ",", ".").' '.$b.'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($persen, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b></td> 
							</tr>';
					   break;
					   }
					}
					$hasil->free_result();  
					
					$sql="SELECT SUM(anggaran) anggaran ,SUM(sd_bulan_ini) sd_bulan_ini FROM realisasi_jurnal_pend($bulan,$anggaran) $where AND LEN(kd_rek)='3'";
					$hasil = $this->db->query($sql);
                    foreach ($hasil->result() as $row)
                    {
					   
                       $nil_ang = $row->anggaran;
                       $sd_bulan_ini = $row->sd_bulan_ini;
					   $sisa=$sd_bulan_ini-$nil_ang;
					   $persen = empty($nil_ang) || $nil_ang == 0 ? 0 :$sd_bulan_ini/$nil_ang;
					   $sisa1 = $sisa<0 ? $sisa*-1 :$sisa;
					   $a = $sisa<0 ? '(' :'';
					   $b = $sisa<0 ? ')' :'';

					   $cRet .='<tr>
							   <td align="left" valign="top"></td> 
							   <td align="left"  valign="top"><b>JUMLAH PENDAPATAN</b></td> 
							   <td align="right" valign="top"><b>'.number_format($nil_ang, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($sd_bulan_ini, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.$a.' '.number_format($sisa1, "2", ",", ".").' '.$b.'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($persen, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b></td> 
							</tr>';
					}
					$hasil->free_result(); 
					
					$sql="SELECT SUM(anggaran) anggaran ,SUM(sd_bulan_ini) sd_bulan_ini FROM realisasi_jurnal_objek($bulan,$anggaran) $where AND LEN(kd_rek)='3'";
					$hasil = $this->db->query($sql);
                    foreach ($hasil->result() as $row)
                    {
					   
                       $nil_ang1 = $row->anggaran;
                       $sd_bulan_ini1 = $row->sd_bulan_ini;
					   $sisa1=$sd_bulan_ini1-$nil_ang1;
					   $persen1 = empty($nil_ang1) || $nil_ang1 == 0 ? 0 :$sd_bulan_ini1/$nil_ang1;
					   $sisa11 = $sisa1<0 ? $sisa1*-1 :$sisa1;
					   $a = $sisa<0 ? '(' :'';
					   $b = $sisa<0 ? ')' :'';

					   $cRet .='<tr>
							   <td align="left" valign="top"></td> 
							   <td align="left"  valign="top"><b>BELANJA DAERAH</b></td> 
							   <td align="right" valign="top"><b>'.number_format($nil_ang1, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($sd_bulan_ini1, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.$a.' '.number_format($sisa11, "2", ",", ".").' '.$b.'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($persen1, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b></td> 
							</tr>';
					}
					$hasil->free_result(); 
					
					$sql="SELECT kd_kegiatan,kd_rek,nm_rek,anggaran,sd_bulan_ini FROM realisasi_jurnal_rinci($bulan,$anggaran) $where AND LEN(kd_rek) <='$jenis' ORDER BY kd_kegiatan,kd_rek";
					$hasil = $this->db->query($sql);
                    foreach ($hasil->result() as $row)
                    {
					   $kd_kegiatan = $row->kd_kegiatan;
					   $kd_rek = $row->kd_rek;
                       $nm_rek = $row->nm_rek;
                       $nil_ang = $row->anggaran;
                       $sd_bulan_ini = $row->sd_bulan_ini;
					   $sisa=$sd_bulan_ini-$nil_ang;
					   $persen = empty($nil_ang) || $nil_ang == 0 ? 0 :$sd_bulan_ini/$nil_ang;
					   $sisa1 = $sisa<0 ? $sisa*-1 :$sisa;
					   $a = $sisa<0 ? '(' :'';
					   $b = $sisa<0 ? ')' :'';

					   $leng=strlen($kd_rek);
					   switch ($leng) {
					   case 3:
					   $cRet .='<tr>
							   <td align="left" valign="top">'.$kd_kegiatan.'.'.$this->dotrek($kd_rek).'</td> 
							   <td align="left"  valign="top">'.$nm_rek.'</td> 
							   <td align="right" valign="top">'.number_format($nil_ang, "2", ",", ".").'</td> 
							   <td align="right" valign="top">'.number_format($sd_bulan_ini, "2", ",", ".").'</td> 
							   <td align="right" valign="top">'.$a.' '.number_format($sisa1, "2", ",", ".").' '.$b.'</td> 
							   <td align="right" valign="top">'.number_format($persen, "2", ",", ".").'</td> 
							   <td align="right" valign="top"></td> 
							</tr>';
					   break;
					   case 5:
					   $cRet .='<tr>
							   <td align="left" valign="top">'.$kd_kegiatan.'.'.$this->dotrek($kd_rek).'</td> 
							   <td align="left"  valign="top">'.$nm_rek.'</td> 
							   <td align="right" valign="top">'.number_format($nil_ang, "2", ",", ".").'</td> 
							   <td align="right" valign="top">'.number_format($sd_bulan_ini, "2", ",", ".").'</td> 
							   <td align="right" valign="top">'.$a.' '.number_format($sisa1, "2", ",", ".").' '.$b.'</td> 
							   <td align="right" valign="top">'.number_format($persen, "2", ",", ".").'</td> 
							   <td align="right" valign="top"></td> 
							</tr>';
					   break;
					   case 7:
					   $cRet .='<tr>
							   <td align="left" valign="top">'.$kd_kegiatan.'.'.$this->dotrek($kd_rek).'</td> 
							   <td align="left"  valign="top">'.$nm_rek.'</td> 
							   <td align="right" valign="top">'.number_format($nil_ang, "2", ",", ".").'</td> 
							   <td align="right" valign="top">'.number_format($sd_bulan_ini, "2", ",", ".").'</td> 
							   <td align="right" valign="top">'.$a.' '.number_format($sisa1, "2", ",", ".").' '.$b.'</td> 
							   <td align="right" valign="top">'.number_format($persen, "2", ",", ".").'</td> 
							   <td align="right" valign="top"></td> 
							</tr>';
					   break;
					   default:
					    $cRet .='<tr>
							   <td align="left" valign="top"><b>'.$kd_kegiatan.'</b></td> 
							   <td align="left"  valign="top"><b>'.$nm_rek.'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($nil_ang, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($sd_bulan_ini, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.$a.' '.number_format($sisa1, "2", ",", ".").' '.$b.'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($persen, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b></td> 
							</tr>';
					   break;
					   }
					}
					$hasil->free_result();  
					$cRet .='<tr>
							   <td align="left" valign="top"></td> 
							   <td align="left"  valign="top"><b>JUMLAH BELANJA</b></td> 
							   <td align="right" valign="top"><b>'.number_format($nil_ang1, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($sd_bulan_ini1, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.$a.' '.number_format($sisa11, "2", ",", ".").' '.$b.'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($persen1, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b></td> 
							</tr>';
			$cRet .="</table>";
			$cRet .="<table style=\"border-collapse:collapse;font-family:Arial;font-size:12px\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\">
				<tr>
                    <td width=\"50%\" align=\"center\">&nbsp;</td>
                    <td width=\"50%\" align=\"center\"></td>
				</tr>
				<tr>
                    <td width=\"50%\" align=\"center\">&nbsp;</td>
                    <td width=\"50%\" align=\"center\">$tanggal<br>$jabatan<br><br><br><br><br><b><u>$nama</u></b><br>$pangkat<br>$nip
					</td>
				</tr>
				</table>";
			$data['prev']= $cRet;    
            $judul='PERDA_LAMP_I.2 ';
			switch ($ctk){
				case 0;
				echo ("<title>$judul</title>");
				echo $cRet;
				break;
				case 1;
				$this->tukd_model->_mpdf('',$cRet,10,10,10,'L');
				break;
				case 2;        
				header("Cache-Control: no-cache, no-store, must-revalidate");
				header("Content-Type: application/vnd.ms-excel");
				header("Content-Disposition: attachment; filename= $judul.xls");
				$this->load->view('anggaran/rka/perkadaII', $data);
				break;	
			}
		}
	
	function cetak_perda_lampI_3($bulan='',$anggaran='',$ctk='',$tglttd='',$ttd=''){
        $lntahunang = $this->session->userdata('pcThang');       
		$tanggal = $tglttd == '-' ? '' : 'Sanggau, '.$this->tukd_model->tanggal_format_indonesia($tglttd) ;
	if($ttd=='-'){
		$nama_ttd='';
		$pangkat='';
		$jabatan='';
		$nip='';
	}else{
	$ttd=str_replace("abc"," ",$ttd);
	$sqlsc="SELECT nama,jabatan,pangkat FROM ms_ttd where nip='$ttd' AND kode='PA' and kd_skpd='1.20.00.00'";
                 $sqlsclient=$this->db->query($sqlsc);
                 foreach ($sqlsclient->result() as $rowttd)
                {
                    $nama_ttd = $rowttd->nama;
                    $jabatan = $rowttd->jabatan;
                    $pangkat = $rowttd->pangkat;
                    $nip = 'NIP. '.$ttd;
                } 
	}
		
		
		$sqlsc="SELECT tgl_rka,provinsi,kab_kota,daerah,thn_ang FROM sclient";
                 $sqlsclient=$this->db->query($sqlsc);
                 foreach ($sqlsclient->result() as $rowsc){
                    $kab     = $rowsc->kab_kota;
                    $prov     = $rowsc->provinsi;
                    $daerah  = $rowsc->daerah;
                    $thn     = $rowsc->thn_ang;
                 }
		
			
		$cRet ='<TABLE style="border-collapse:collapse;font-size:11px;font-family:Arial" width="100%" border="0" cellspacing="0" cellpadding="1" align=center>
					<TR>
						<TD  width="70%" valign="top" align="right" > Lampiran I.3 : </TD>
						<TD width="30%"  align="left" >Rancangan Peraturan Daerah <br> Nomor : <br> Tanggal :</TD>
					</TR>
					<tr>
					</TABLE><br/>';
	$cRet .="<TABLE style=\"border-collapse:collapse;font-family:Arial\" width=\"100%\" border=\"1\" cellspacing=\"0\" cellpadding=\"1\" align=\"center\">
					<tr>
					<td rowspan=\"3\" align=\"center\" style=\"border-right:hidden\">
                        <img src=\"".base_url()."/image/logoHP.png\"  width=\"75\" height=\"100\" />
                        </td>
					<td align=\"center\" style=\"border-left:hidden;border-bottom:hidden\"><strong>PEMERINTAH KABUPATEN SANGGAU </strong></td></tr>
                    <tr><td align=\"center\" style=\"border-left:hidden;border-bottom:hidden;border-top:hidden\"><b>REKAPITULASI REALISASI BELANJA DAERAH MENURUT URUSAN PEMERINTAH DAERAH, <BR> ORGANISASI, PROGRAM, DAN KEGIATAN</b></tr>
					<tr><td align=\"center\" style=\"border-left:hidden;border-top:hidden\" ><b>TAHUN ANGGARAN $lntahunang</b></tr>
					</TABLE>";
			
		$cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"2\" cellpadding=\"2\">
                <thead>
				<tr>
                    <td rowspan = \"2\" width=\"10%\" align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">KODE</td>
                    <td rowspan = \"2\" width=\"35%\" align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">URUSAN PEMERINTAH DAERAH</td>
					<td colspan = \"3\" width=\"45%\" align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">ANGGARAN BELANJA</td>
                    <td rowspan = \"2\" width=\"15%\" align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">JUMLAH</td>
					<td colspan = \"3\" width=\"45%\" align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">REALISASI BELANJA</td>
                    <td rowspan = \"2\" width=\"15%\" align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">JUMLAH</td>
				</tr>
				<tr>
                   <td align =\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">PEGAWAI</td> 
                   <td align =\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">BARANG DAN JASA</td> 
                   <td align =\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">MODAL</td> 
				   <td align =\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">PEGAWAI</td> 
                   <td align =\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">BARANG DAN JASA</td> 
                   <td align =\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">MODAL</td>
				<tr>
                   <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">1</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">2</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">3</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">4</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">5</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">6</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">7</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">8</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">9</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\">10</td> 
				</tr>
				</thead>";
				
			
			$sql = " select kd_kegiatan kode ,nm_rek,ang_peg,ang_brng,ang_mod,real_peg,real_brng,real_mod 
					FROM [perda_lampI.3]($bulan,$anggaran) ORDER BY kd_kegiatan
					";
                    $hasil = $this->db->query($sql);
                    foreach ($hasil->result() as $row)
                    {
					   $kode = $row->kode;
					   $nm_rek = $row->nm_rek;
                       $ang_peg = $row->ang_peg;
                       $ang_brng = $row->ang_brng;
                       $ang_mod = $row->ang_mod;
					   $real_peg = $row->real_peg;
                       $real_brng = $row->real_brng;
                       $real_mod = $row->real_mod;
					   
					   $tot_ang=$ang_peg+$ang_brng+$ang_mod;
					   $tot_real=$real_peg+$real_brng+$real_mod;
                      

					 $cRet .='<tr>
							   <td align="left" valign="top" style="font-size:12px">'.$kode.'</td> 
							   <td align="left"  valign="top" style="font-size:12px">'.$nm_rek.'</td> 
							   <td align="right" valign="top" style="font-size:12px">'.number_format($ang_peg, "2", ",", ".").'</td> 
							   <td align="right" valign="top" style="font-size:12px">'.number_format($ang_brng, "2", ",", ".").'</td> 
							   <td align="right" valign="top" style="font-size:12px">'.number_format($ang_mod, "2", ",", ".").'</td> 
							   <td align="right" valign="top" style="font-size:12px">'.number_format($tot_ang, "2", ",", ".").'</td> 
							   <td align="right" valign="top" style="font-size:12px">'.number_format($real_peg, "2", ",", ".").'</td> 
							   <td align="right" valign="top" style="font-size:12px">'.number_format($real_brng, "2", ",", ".").'</td> 
							   <td align="right" valign="top" style="font-size:12px">'.number_format($real_mod, "2", ",", ".").'</td> 
							   <td align="right" valign="top" style="font-size:12px">'.number_format($tot_real, "2", ",", ".").'</td> 
							</tr>'; 
					}
				
			$cRet .="</table>";
			$cRet .="<table style=\"border-collapse:collapse;font-family:Arial;font-size:12px\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\">
				<tr>
                    <td width=\"50%\" align=\"center\">&nbsp;</td>
                    <td width=\"50%\" align=\"center\"></td>
				</tr>
				<tr>
                    <td width=\"50%\" align=\"center\">&nbsp;</td>
                    <td width=\"50%\" align=\"center\">$tanggal<br>$jabatan<br><br><br><br><br><b><u>$nama_ttd</u></b><br>$pangkat<br>$nip
					</td>
				</tr>
				</table>";
			$data['prev']= $cRet;    
            $judul='Perda_LampI';
			switch ($ctk){
				case 0;
				echo ("<title>$judul</title>");
				echo $cRet;
				break;
				case 1;
				$this->tukd_model->_mpdf('',$cRet,10,10,10,'L');
				break;
				case 2;        
				header("Cache-Control: no-cache, no-store, must-revalidate");
				header("Content-Type: application/vnd.ms-excel");
				header("Content-Disposition: attachment; filename= $judul.xls");
				$this->load->view('anggaran/rka/perkadaII', $data);
				break;	
			}
		}
	
	function cetak_perda_lampI_4($bulan='',$anggaran='',$ctk='',$tglttd='',$ttd=''){
        $lntahunang = $this->session->userdata('pcThang');       
		$tanggal = $tglttd == '-' ? '' : 'Sanggau, '.$this->tukd_model->tanggal_format_indonesia($tglttd) ;
	if($ttd=='-'){
		$nama_ttd='';
		$pangkat='';
		$jabatan='';
		$nip='';
	}else{
	$ttd=str_replace("abc"," ",$ttd);
	$sqlsc="SELECT nama,jabatan,pangkat FROM ms_ttd where nip='$ttd' AND kode='PA' and kd_skpd='1.20.00.00'";
                 $sqlsclient=$this->db->query($sqlsc);
                 foreach ($sqlsclient->result() as $rowttd)
                {
                    $nama_ttd = $rowttd->nama;
                    $jabatan = $rowttd->jabatan;
                    $pangkat = $rowttd->pangkat;
                    $nip = 'NIP. '.$ttd;
                } 
	}
		
		
		$sqlsc="SELECT tgl_rka,provinsi,kab_kota,daerah,thn_ang FROM sclient";
                 $sqlsclient=$this->db->query($sqlsc);
                 foreach ($sqlsclient->result() as $rowsc){
                    $kab     = $rowsc->kab_kota;
                    $prov     = $rowsc->provinsi;
                    $daerah  = $rowsc->daerah;
                    $thn     = $rowsc->thn_ang;
                 }
		
			
		$cRet ='<TABLE style="border-collapse:collapse;font-size:11px;font-family:Arial" width="100%" border="0" cellspacing="0" cellpadding="1" align=center>
					<TR>
						<TD  width="70%" valign="top" align="right" > Lampiran I.4 : </TD>
						<TD width="30%"  align="left" >Rancangan Peraturan Daerah <br> Nomor : <br> Tanggal :</TD>
					</TR>
					<tr>
					</TABLE><br/>';
	$cRet .="<TABLE style=\"border-collapse:collapse;font-family:Arial\" width=\"100%\" border=\"1\" cellspacing=\"0\" cellpadding=\"1\" align=\"center\">
					<tr>
					<td rowspan=\"3\" align=\"center\" style=\"border-right:hidden\">
                        <img src=\"".base_url()."/image/logoHP.png\"  width=\"75\" height=\"100\" />
                        </td>
					<td align=\"center\" style=\"border-left:hidden;border-bottom:hidden\"><strong>PEMERINTAH KABUPATEN SANGGAU </strong></td></tr>
                    <tr><td align=\"center\" style=\"border-left:hidden;border-bottom:hidden;border-top:hidden\"><b>REKAPITULASI REALISASI BELANJA DAERAH UNTUK<BR>KESELARASAN DAN KETERPADUAN URUSAN PEMERINTAH DAERAH<BR> DAN FUNGSI DALAM KERANGKA PENGELOLAAN KEUANGAN NEGARA</b></tr>
					<tr><td align=\"center\" style=\"border-left:hidden;border-top:hidden\" ><b>TAHUN ANGGARAN $lntahunang</b></tr>
					</TABLE>";
			
		$cRet .="<table style=\"border-collapse:collapse;font-family:Arial\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"2\" cellpadding=\"2\">
                <thead>
				<tr>
                    <td rowspan = \"2\" width=\"10%\" align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\"><b>KODE</b></td>
                    <td rowspan = \"2\" width=\"35%\" align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\"><b>URAIAN</b></td>
					<td rowspan = \"2\" width=\"20%\" align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\"><b>ANGGARAN</b></td>
                    <td rowspan = \"2\" width=\"20%\" align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\"><b>REALISASI</b></td>
					<td colspan = \"2\" width=\"25%\" align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\"><b>BERTAMBAH/BERKURANG</b></td>
				</tr>
				<tr>
                   <td align =\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\"><b>(Rp)</b></td> 
                   <td align =\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\"><b>(%)</b></td> 
				<tr>
                   <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\"><b>1</b></td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\"><b>2</b></td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\"><b>3</b></td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\"><b>4</b></td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\"><b>5</b></td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" style=\"font-size:12px\"><b>6</b></td> 
				</tr>
				</thead>";
				
			
			if($anggaran==1){
				$ang="nilai";
			} else if ($anggaran==2){
				$ang="nilai_sempurna";
			} else {
				$ang="nilai_ubah";
			}
			$sql = " SELECT a.kode, a.nama, ISNULL(a.anggaran,0) anggaran, 
						ISNULL(b.realisasi,0) realisasi, ISNULL(anggaran-realisasi,0) selisih FROM 
						(SELECT RTRIM(a.kd_fungsi)+'.'+a.kd_urusan  as kode, a.nm_urusan as nama
						,SUM(ISNULL(anggaran,0)) as anggaran
						FROM ms_urusan a 
						LEFT JOIN
						(
						SELECT LEFT(kd_kegiatan,4) kd_urusan 
						,SUM($ang) AS anggaran
						FROM trdrka a 
						WHERE LEFT(a.kd_rek5,1) IN ('5')  GROUP BY LEFT(kd_kegiatan,4))b
						ON a.kd_urusan=b.kd_urusan
						GROUP BY a.kd_fungsi,a.kd_urusan,a.nm_urusan) a
						LEFT JOIN 
						(
						SELECT RTRIM(a.kd_fungsi)+'.'+a.kd_urusan  as kode, a.nm_urusan as nama
						,SUM(ISNULL(realisasi,0)) as realisasi
						FROM ms_urusan a 
						LEFT JOIN
						(
						SELECT LEFT(kd_kegiatan,4) kd_urusan 
						,SUM(debet-kredit) AS realisasi
						FROM trdju_pkd a INNER JOIN trhju_pkd b ON a.no_voucher=b.no_voucher AND a.kd_unit=b.kd_skpd
						WHERE LEFT(a.map_real,1) IN ('5')  AND MONTH(tgl_voucher)<='$bulan' GROUP BY LEFT(kd_kegiatan,4))b
						ON a.kd_urusan=b.kd_urusan
						GROUP BY a.kd_fungsi,a.kd_urusan,a.nm_urusan)b
						ON a.kode=b.kode  

						UNION ALL

						SELECT a.kode, a.nama, ISNULL(a.anggaran,0) anggaran, 
						ISNULL(b.realisasi,0) realisasi, ISNULL(anggaran-realisasi,0) selisih
						 FROM (
						SELECT a.kd_fungsi as kode, a.nm_fungsi as nama
						,SUM(ISNULL(anggaran,0)) as anggaran
						FROM ms_fungsi a LEFT JOIN 
						(
						SELECT RTRIM(a.kd_fungsi) as kode
						,SUM(ISNULL(anggaran,0)) as anggaran
						FROM ms_urusan a 
						LEFT JOIN
						(
						SELECT LEFT(kd_kegiatan,4) kd_urusan 
						,SUM ($ang) AS anggaran
						FROM trdrka a 
						WHERE LEFT(a.kd_rek5,1) IN ('5')  GROUP BY LEFT(kd_kegiatan,4))b
						ON a.kd_urusan=b.kd_urusan
						GROUP BY a.kd_fungsi) b
						on a.kd_fungsi=b.kode
						GROUP BY a.kd_fungsi,nm_fungsi)a
						LEFT JOIN
						(
						SELECT a.kd_fungsi as kode, a.nm_fungsi as nama
						,SUM(ISNULL(realisasi,0)) as realisasi
						FROM ms_fungsi a LEFT JOIN 
						(
						SELECT RTRIM(a.kd_fungsi) as kode
						,SUM(ISNULL(realisasi,0)) as realisasi
						FROM ms_urusan a 
						LEFT JOIN
						(
						SELECT LEFT(kd_kegiatan,4) kd_urusan 
						,SUM (debet-kredit) AS realisasi
						FROM trdju_pkd a INNER JOIN trhju_pkd b ON a.no_voucher=b.no_voucher AND a.kd_unit=b.kd_skpd
						WHERE LEFT(a.map_real,1) IN ('5')  AND MONTH(tgl_voucher)<='$bulan' GROUP BY LEFT(kd_kegiatan,4))b
						ON a.kd_urusan=b.kd_urusan
						GROUP BY a.kd_fungsi) b
						on a.kd_fungsi=b.kode
						GROUP BY a.kd_fungsi,nm_fungsi)b
						ON a.kode=b.kode
						ORDER BY kode
					";
                    $hasil = $this->db->query($sql);
                    foreach ($hasil->result() as $row)
                    {
					   $kode = $row->kode;
					   $nm_rek = $row->nama;
                       $ang_bel = $row->anggaran;
                       $real_bel = $row->realisasi;
                       $selisih = $row->selisih;
					   $persen = empty($ang_bel) || $ang_bel == 0 ? 0 :$real_bel/$ang_bel;
					   
					   $selisih1 = $selisih<0 ? $selisih*-1 :$selisih;
					   $a = $selisih<0 ? '' :'(';
					   $b = $selisih<0 ? '' :')';
					   
					  
					
					 $leng=strlen($kode);
					   switch ($leng) {
					   case 2:
					   $cRet .='<tr>
							   <td align="left" valign="top" style="font-size:12px"><b>'.$kode.'</b></td> 
							   <td align="left"  valign="top" style="font-size:12px"><b>'.$nm_rek.'</b></td> 
							   <td align="right" valign="top" style="font-size:12px"><b>'.number_format($ang_bel, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top" style="font-size:12px"><b>'.number_format($real_bel, "2", ",", ".").'</b> </td> 
							   <td align="right" valign="top" style="font-size:12px"><b>'.$a.' '.number_format($selisih1, "2", ",", ".").' '.$b.'</b></td> 
							   <td align="right" valign="top" style="font-size:12px"><b>'.number_format($persen, "2", ",", ".").'</b></td> 
							</tr>';
					   break;
					   default;
						$cRet .='<tr>
							   <td align="left" valign="top" style="font-size:12px">'.$kode.'</td> 
							   <td align="left"  valign="top" style="font-size:12px">'.$nm_rek.'</td> 
							   <td align="right" valign="top" style="font-size:12px">'.number_format($ang_bel, "2", ",", ".").'</td> 
							   <td align="right" valign="top" style="font-size:12px">'.number_format($real_bel, "2", ",", ".").' </td> 
							   <td align="right" valign="top" style="font-size:12px">'.$a.' '.number_format($selisih1, "2", ",", ".").' '.$b.'</td> 
							   <td align="right" valign="top" style="font-size:12px">'.number_format($persen, "2", ",", ".").'</td> 
							</tr>';
					   break;
						}
					}
				
			$cRet .="</table>";
			$cRet .="<table style=\"border-collapse:collapse;font-family:Arial;font-size:12px\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\">
				<tr>
                    <td width=\"50%\" align=\"center\">&nbsp;</td>
                    <td width=\"50%\" align=\"center\"></td>
				</tr>
				<tr>
                    <td width=\"50%\" align=\"center\">&nbsp;</td>
                    <td width=\"50%\" align=\"center\">$tanggal<br>$jabatan<br><br><br><br><br><b><u>$nama_ttd</u></b><br>$pangkat<br>$nip
					</td>
				</tr>
				</table>";
			$data['prev']= $cRet;    
            $judul='Perda_LampI';
			switch ($ctk){
				case 0;
				echo ("<title>$judul</title>");
				echo $cRet;
				break;
				case 1;
				$this->tukd_model->_mpdf('',$cRet,10,10,10,'P');
				break;
				case 2;        
				header("Cache-Control: no-cache, no-store, must-revalidate");
				header("Content-Type: application/vnd.ms-excel");
				header("Content-Disposition: attachment; filename= $judul.xls");
				$this->load->view('anggaran/rka/perkadaII', $data);
				break;	
			}
		}
	
	function cetak_perkada_lampI_sap_spj($bulan='',$ctk='',$anggaran='',$jenis='',$kd_skpd=''){
        $lntahunang = $this->session->userdata('pcThang');       
		switch  ($bulan){
        case  1:
        $judul="JANUARI";
        break;
        case  2:
        $judul="FEBRUARI";
        break;
        case  3:
        $judul= "TRIWULAN I";
        break;
        case  4:
        $judul="APRIL";
        break;
        case  5:
        $judul= "MEI";
        break;
        case  6:
        $judul= "SEMESTER I";
        break;
        case  7:
        $judul= "JULI";
        break;
        case  8:
        $judul= "AGUSTUS";
        break;
        case  9:
        $judul= "TRIWULAN III";
        break;
        case  10:
        $judul= "OKTOBER";
        break;
        case  11:
        $judul= "NOVEMBER";
        break;
        case  12:
        $judul= "SEMESTER II";
        break;
    }
	if ($kd_skpd=='-'){                               
            $where="";            
        } else{
			$where="AND kd_skpd='$kd_skpd'";
		}
		
		$cRet ='<TABLE style="border-collapse:collapse;font-size:11px;font-family:Arial" width="100%" border="0" cellspacing="0" cellpadding="1" align=center>
					<TR>
						<TD  width="60%" valign="top" align="right" > Lampiran I : </TD>
						<TD width="40%"  align="left" >Peraturan Gubernur <br>Nomor : <br>Tanggal: </TD>
					</TR>
					<tr>
					</TABLE><br/>';
	$cRet .="<TABLE style=\"border-collapse:collapse;font-family:Arial\" width=\"100%\" border=\"1\" cellspacing=\"0\" cellpadding=\"1\" align=\"center\">
					<tr>
					<td rowspan=\"3\" align=\"center\" style=\"border-right:hidden\">
                        <img src=\"".base_url()."/image/logoHP.png\"  width=\"75\" height=\"100\" />
                        </td>
					<td align=\"center\" style=\"border-left:hidden;border-bottom:hidden\"><strong>PEMERINTAH KABUPATEN SANGGAU </strong></td></tr>
                    <tr><td align=\"center\" style=\"border-left:hidden;border-bottom:hidden;border-top:hidden\"><b>RINGKASAN LAPORAN REALISASI ANGGARAN </b></tr>
					<tr><td align=\"center\" style=\"border-left:hidden;border-top:hidden\" ><b>$judul</b></tr>
					</TABLE>";
			
		$cRet .="<table style=\"border-collapse:collapse;font-family:Arial;font-size:11px\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"3\" cellpadding=\"3\">
                <thead>
				<tr>
                    <td rowspan=\"2\" width=\"7%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>KD REK</b></td>
                    <td rowspan=\"2\" width=\"32%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>URAIAN</b></td>
                    <td colspan=\"2\" width=\"37%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>JUMLAH (Rp.)</b></td>
                    <td colspan=\"2\" width=\"23%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>BERTAMBAH/KURANG</b></td>
				</tr>
				<tr>
					<td width=\"19%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>ANGGARAN</b></td>
					<td width=\"18%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>REALISASI</b></td>
					<td width=\"18%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>(Rp)</b></td>
					<td width=\"5%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>%</b></td>
					</tr>
					<tr>
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >1</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >2</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >3</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >4</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >5</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >6</td> 
				</tr>
				</thead>";
				
			$sql = "SELECT 
					SUM(CASE WHEN kd_rek='4' THEN (nil_ang) ELSE 0 END) - SUM(CASE WHEN kd_rek='5' THEN (nil_ang) ELSE 0 END) as ang_surplus,
					SUM(CASE WHEN kd_rek='4' THEN (kredit-debet) ELSE 0 END) - SUM(CASE WHEN kd_rek='5' THEN (debet-kredit) ELSE 0 END) as nil_surplus
					FROM
					(SELECT LEFT(kd_rek5,1) as kd_rek, SUM(nilai) as nil_ang, SUM(kredit) as kredit,SUM(debet) as debet FROM data_jurnal($bulan,$anggaran) WHERE LEFT(kd_rek5,1) IN ('4','5') $where
					GROUP BY LEFT(kd_rek5,1)) a;
					";
					  $hasil = $this->db->query($sql);
                    foreach ($hasil->result() as $row)
                    {
					   $ang_surplus = $row->ang_surplus;
                       $nil_surplus = $row->nil_surplus;
					}
					$sisa_surplus = $ang_surplus-$nil_surplus;
					if(($ang_surplus==0) || ($ang_surplus=='')){
						$persen_surplus=0;
					} else{
					$persen_surplus = $nil_surplus/$ang_surplus;
					}
					$hasil->free_result();        
					if($ang_surplus<0){
						$ang_surplus1=$ang_surplus*-1;
						$a='(';
						$b=')';
					} else{
						$ang_surplus1=$ang_surplus;
						$a='';
						$b='';
					}
					if($nil_surplus<0){
						$nil_surplus1=$nil_surplus*-1;
						$c='(';
						$d=')';
					} else{
						$nil_surplus1=$nil_surplus;
						$c='';
						$d='';
					}
					if($sisa_surplus<0){
						$sisa_surplus1=$sisa_surplus*-1;
						$e='(';
						$f=')';
					} else{
						$sisa_surplus1=$sisa_surplus;
						$e='';
						$f='';
					}
			
			$sql = "SELECT 
					SUM(CASE WHEN kd_rek='61' THEN (nil_ang) ELSE 0 END) - SUM(CASE WHEN kd_rek='62' THEN (nil_ang) ELSE 0 END) as ang_netto,
					SUM(CASE WHEN kd_rek='61' THEN (kredit-debet) ELSE 0 END) - SUM(CASE WHEN kd_rek='62' THEN (debet-kredit) ELSE 0 END) as nil_netto
					FROM
					(SELECT LEFT(kd_rek5,2) as kd_rek, SUM(nilai) as nil_ang, SUM(kredit) as kredit,SUM(debet) as debet FROM data_jurnal($bulan,$anggaran) WHERE LEFT(kd_rek5,2) IN ('61','62') $where
					GROUP BY LEFT(kd_rek5,2)) a;
					";
					  $hasil = $this->db->query($sql);
                    foreach ($hasil->result() as $row)
                    {
					   $ang_netto = $row->ang_netto;
                       $nil_netto = $row->nil_netto;
					}
					$sisa_netto = $ang_netto-$nil_netto;
					if(($ang_netto==0) || ($ang_netto=='')){
						$persen_netto=0;
					} else{
					$persen_netto = $nil_netto/$ang_netto;
					}
					$hasil->free_result();  
					if($ang_netto<0){
						$ang_netto1=$ang_netto*-1;
						$g='(';
						$h=')';
					} else{
						$ang_netto1=$ang_netto;
						$g='';
						$h='';
					}
					if($nil_netto<0){
						$nil_netto1=$nil_netto*-1;
						$i='(';
						$j=')';
					} else{
						$nil_netto1=$nil_netto;
						$i='';
						$j='';
					}
					if($sisa_netto<0){
						$sisa_netto1=$sisa_netto*-1;
						$k='(';
						$l=')';
					} else{
						$sisa_netto1=$sisa_netto;
						$k='';
						$l='';
					}	
					
					$ang_silpa = $ang_surplus+$ang_netto;
					$nil_silpa = $nil_surplus+$nil_netto;
					$sisa_silpa = $ang_silpa-$nil_silpa;
					if($ang_silpa==0){
						$persen_silpa=0;
					}else{
					$persen_silpa = $nil_silpa/$ang_silpa;
					}
					if($ang_silpa<0){
						$ang_silpa1=$ang_silpa*-1;
						$m='(';
						$n=')';
					} else{
						$ang_silpa1=$ang_silpa;
						$m='';
						$n='';
					}
					if($nil_silpa<0){
						$nil_silpa1=$nil_silpa*-1;
						$o='(';
						$p=')';
					} else{
						$nil_silpa1=$nil_silpa;
						$o='';
						$p='';
					}
					if($sisa_silpa<0){
						$sisa_silpa1=$sisa_silpa*-1;
						$q='(';
						$r=')';
					} else{
						$sisa_silpa1=$sisa_silpa;
						$q='';
						$r='';
					}	
			$sql = "SELECT seq, kode, nama, kode1, kode2, kode3,kode4, jenis, spasi FROM map_lra_sap ORDER BY seq
					";
					$no=0;
					$tot_peg=0;
					$tot_brg=0;
					$tot_mod=0;
					$tot_bansos=0;
                    $hasil = $this->db->query($sql);
                    foreach ($hasil->result() as $row)
                    {
					   $no=$no+1;
					   $seq = $row->seq;
					   $kode = $row->kode;
                       $nama = $row->nama;
                       $kode1 = $row->kode1;
                       $kode2 = $row->kode2;
                       $kode3 = $row->kode3;
                       $kode4 = $row->kode4;
                       $jenis = $row->jenis;
                       $spasi = $row->spasi;
					   
					   if($kode1==' '){
						$kode1="'X'";
						}
						if($kode2==' '){
							$kode2="'XX'";
						}
						if($kode3==' '){
							$kode3="'XXX'";
						}
						if($kode4==' '){
							$kode4="'XXXXX'";
						}
					$sql = "SELECT SUM(nilai) as nil_ang, SUM($jenis) as nilai FROM data_jurnal($bulan,$anggaran) WHERE (LEFT(kd_rek5,1) IN ($kode1) or LEFT(kd_rek5,2) IN ($kode2) or LEFT(kd_rek5,3) IN ($kode3) or LEFT(kd_rek5,5) IN($kode4)) $where
					";
										
					
                    $hasil = $this->db->query($sql);
                    foreach ($hasil->result() as $row)
                    {
                       $nil_ang = $row->nil_ang;
					   $nilai = $row->nilai;
					}
					$sel = $nil_ang-$nilai;
					if(($nil_ang==0) || ($nil_ang=='')){
						$persen=0;
					} else{
					$persen = $nilai/$nil_ang;
					}
					 switch ($spasi) {
					 case 1:
                        $cRet .='<tr>
							   <td align="left" valign="top"><b>'.$kode.'</b></td> 
							   <td align="left"  valign="top"><b>'.$nama.'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($nil_ang, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($nilai, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($sel, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($persen, "2", ",", ".").'</b></td> 
							</tr>'; 
                        break;	
                    case 2:
                         $cRet .='<tr>
							   <td align="left" valign="top"><b>'.$kode.'</b></td> 
							   <td align="left"  valign="top"><b>&nbsp;&nbsp;'.$nama.'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($nil_ang, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($nilai, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($sel, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($persen, "2", ",", ".").'</b></td> 
							</tr>';
                        break;
					 case 3:
                         $cRet .='<tr>
							   <td align="left" valign="top">'.$kode.'</b></td> 
							   <td align="left"  valign="top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$nama.'</td> 
							   <td align="right" valign="top">'.number_format($nil_ang, "2", ",", ".").'</td> 
							   <td align="right" valign="top">'.number_format($nilai, "2", ",", ".").'</td> 
							   <td align="right" valign="top">'.number_format($sel, "2", ",", ".").'</td> 
							   <td align="right" valign="top">'.number_format($persen, "2", ",", ".").'</td> 
							</tr>';
                        break;
					case 4:
                       $cRet .='<tr>
							   <td align="left" valign="top" ><b>'.$kode.'</b></td> 
							   <td align="left"  valign="top"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$nama.'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($nil_ang, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($nilai, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($sel, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($persen, "2", ",", ".").'</b></td> 
							</tr>';
                        break;
					case 5:
                       $cRet .='<tr>
							   <td align="left" valign="top" ><b>'.$kode.'</b></td> 
							   <td align="right"  valign="top"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$nama.'</b></td> 
							   <td align="right" valign="top"><b>'.$a.''.number_format($ang_surplus1, "2", ",", ".").''.$b.'</b></td> 
							   <td align="right" valign="top"><b>'.$c.''.number_format($nil_surplus1, "2", ",", ".").''.$d.'</b></td> 
							   <td align="right" valign="top"><b>'.$e.''.number_format($sisa_surplus1, "2", ",", ".").''.$f.'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($persen_surplus, "2", ",", ".").'</b></td> 
							</tr>';
                        break;
					case 6;
                       $cRet .='<tr>
							   <td align="left" valign="top" ><b>'.$kode.'</b></td> 
							   <td align="right"  valign="top"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$nama.'</b></td> 
							   <td align="right" valign="top" ><b>'.$g.''.number_format($ang_netto1, "2", ",", ".").''.$h.'</b></td> 
							   <td align="right" valign="top" ><b>'.$i.''.number_format($nil_netto1, "2", ",", ".").''.$j.'</b></td> 
							   <td align="right" valign="top" ><b>'.$k.''.number_format($sisa_netto1, "2", ",", ".").''.$l.'</b></td> 
							   <td align="right" valign="top" ><b>'.number_format($persen_netto, "2", ",", ".").'</b></td> 
							</tr>';
                        break;
					case 7;
                       $cRet .='<tr>
							   <td align="left" valign="top" ><b>'.$kode.'</b></td> 
							   <td align="right"  valign="top"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$nama.'</b></td> 
							   <td align="right" valign="top" ><b>'.$m.''.number_format($ang_silpa1, "2", ",", ".").''.$n.'</b></td> 
							   <td align="right" valign="top" ><b>'.$o.''.number_format($nil_silpa1, "2", ",", ".").''.$p.'</b></td> 
							   <td align="right" valign="top" ><b>'.$q.''.number_format($sisa_silpa1, "2", ",", ".").''.$r.'</b></td> 
							   <td align="right" valign="top" ><b>'.number_format($persen_silpa, "2", ",", ".").'</b></td> 
							</tr>';
                        break;
					}
					}
			 
                      
		
			$cRet .="</table>";
			$data['prev']= $cRet;    
            $judul='PergubI_SAP ';
			switch ($ctk){
				case 0;
				echo ("<title>$judul</title>");
				echo $cRet;
				break;
				case 1;
				$this->tukd_model->_mpdf('',$cRet,10,10,10,'P');
				break;
				case 2;        
				header("Cache-Control: no-cache, no-store, must-revalidate");
				header("Content-Type: application/vnd.ms-excel");
				header("Content-Disposition: attachment; filename= $judul.xls");
				$this->load->view('anggaran/rka/perkadaII', $data);
				break;	
			}
		}
		
	function cetak_perkada_lampI_sap_sp2d($bulan='',$ctk='',$anggaran='',$jenis='',$kd_skpd=''){
        $lntahunang = $this->session->userdata('pcThang');       
		 switch  ($bulan){
        case  1:
        $judul="JANUARI";
        break;
        case  2:
        $judul="FEBRUARI";
        break;
        case  3:
        $judul= "TRIWULAN I";
        break;
        case  4:
        $judul="APRIL";
        break;
        case  5:
        $judul= "MEI";
        break;
        case  6:
        $judul= "SEMESTER I";
        break;
        case  7:
        $judul= "JULI";
        break;
        case  8:
        $judul= "AGUSTUS";
        break;
        case  9:
        $judul= "TRIWULAN III";
        break;
        case  10:
        $judul= "OKTOBER";
        break;
        case  11:
        $judul= "NOVEMBER";
        break;
        case  12:
        $judul= "SEMESTER II";
        break;
    }
		if ($kd_skpd=='-'){                               
            $where="";            
        } else{
			$where="AND kd_skpd='$kd_skpd'";
		}
			
		if($jenis==2){
			$tabel='data_sp2d';
		  }else if($jenis==3){
			$tabel='data_sp2d_lunas';
		  } else if($jenis==4){
			$tabel='data_sp2d_advice';
		  }

		$cRet ='<TABLE style="border-collapse:collapse;font-size:11px;font-family:Arial" width="100%" border="0" cellspacing="0" cellpadding="1" align=center>
					<TR>
						<TD  width="60%" valign="top" align="right" > Lampiran I : </TD>
						<TD width="40%"  align="left" >Peraturan Gubernur <br>Nomor : <br>Tanggal: </TD>
					</TR>
					<tr>
					</TABLE><br/>';
	$cRet .="<TABLE style=\"border-collapse:collapse;font-family:Arial\" width=\"100%\" border=\"1\" cellspacing=\"0\" cellpadding=\"1\" align=\"center\">
					<tr>
					<td rowspan=\"3\" align=\"center\" style=\"border-right:hidden\">
                        <img src=\"".base_url()."/image/logoHP.png\"  width=\"75\" height=\"100\" />
                        </td>
					<td align=\"center\" style=\"border-left:hidden;border-bottom:hidden\"><strong>PEMERINTAH KABUPATEN SANGGAU </strong></td></tr>
                    <tr><td align=\"center\" style=\"border-left:hidden;border-bottom:hidden;border-top:hidden\"><b>RINGKASAN LAPORAN REALISASI ANGGARAN </b></tr>
					<tr><td align=\"center\" style=\"border-left:hidden;border-top:hidden\" ><b>$judul</b></tr>
					</TABLE>";
			
		$cRet .="<table style=\"border-collapse:collapse;font-family:Arial;font-size:11px\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"3\" cellpadding=\"3\">
                <thead>
				<tr>
                    <td rowspan=\"2\" width=\"7%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>KD REK</b></td>
                    <td rowspan=\"2\" width=\"32%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>URAIAN</b></td>
                    <td colspan=\"2\" width=\"37%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>JUMLAH (Rp.)</b></td>
                    <td colspan=\"2\" width=\"23%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>BERTAMBAH/KURANG</b></td>
				</tr>
				<tr>
					<td width=\"19%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>ANGGARAN</b></td>
					<td width=\"18%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>REALISASI</b></td>
					<td width=\"18%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>(Rp)</b></td>
					<td width=\"5%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>%</b></td>
					</tr>
					<tr>
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >1</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >2</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >3</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >4</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >5</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >6</td> 
				</tr>
				</thead>";
				
			$sql = "SELECT 
					SUM(CASE WHEN kd_rek='4' THEN (nil_ang) ELSE 0 END) - SUM(CASE WHEN kd_rek='5' THEN (nil_ang) ELSE 0 END) as ang_surplus,
					SUM(CASE WHEN kd_rek='4' THEN (nilai) ELSE 0 END) - SUM(CASE WHEN kd_rek='5' THEN (nilai) ELSE 0 END) as nil_surplus
					FROM
					(SELECT LEFT(kd_rek5,1) as kd_rek, SUM(nil_ang) as nil_ang, SUM(nilai) as nilai FROM $tabel($bulan,$anggaran) WHERE LEFT(kd_rek5,1) IN ('4','5') $where
					GROUP BY LEFT(kd_rek5,1)) a;
					";
					  $hasil = $this->db->query($sql);
                    foreach ($hasil->result() as $row)
                    {
					   $ang_surplus = $row->ang_surplus;
                       $nil_surplus = $row->nil_surplus;
					}
					$sisa_surplus = $ang_surplus-$nil_surplus;
					if(($ang_surplus==0) || ($ang_surplus=='')){
						$persen_surplus=0;
					} else{
					$persen_surplus = $nil_surplus/$ang_surplus;
					}	
					$hasil->free_result();        
					if($ang_surplus<0){
						$ang_surplus1=$ang_surplus*-1;
						$a='(';
						$b=')';
					} else{
						$ang_surplus1=$ang_surplus;
						$a='';
						$b='';
					}
					if($nil_surplus<0){
						$nil_surplus1=$nil_surplus*-1;
						$c='(';
						$d=')';
					} else{
						$nil_surplus1=$nil_surplus;
						$c='';
						$d='';
					}
					if($sisa_surplus<0){
						$sisa_surplus1=$sisa_surplus*-1;
						$e='(';
						$f=')';
					} else{
						$sisa_surplus1=$sisa_surplus;
						$e='';
						$f='';
					}
			
			$sql = "SELECT 
					SUM(CASE WHEN kd_rek='61' THEN (nil_ang) ELSE 0 END) - SUM(CASE WHEN kd_rek='62' THEN (nil_ang) ELSE 0 END) as ang_netto,
					SUM(CASE WHEN kd_rek='61' THEN (nilai) ELSE 0 END) - SUM(CASE WHEN kd_rek='62' THEN (nilai) ELSE 0 END) as nil_netto
					FROM
					(SELECT LEFT(kd_rek5,2) as kd_rek, SUM(nil_ang) as nil_ang, SUM(nilai) as nilai FROM $tabel($bulan,$anggaran) WHERE LEFT(kd_rek5,2) IN ('61','62') $where
					GROUP BY LEFT(kd_rek5,2)) a;
					";
					  $hasil = $this->db->query($sql);
                    foreach ($hasil->result() as $row)
                    {
					   $ang_netto = $row->ang_netto;
                       $nil_netto = $row->nil_netto;
					}
					$sisa_netto = $ang_netto-$nil_netto;
					if(($ang_netto==0) || ($ang_netto=='')){
						$persen_netto=0;
					} else{
					$persen_netto = $nil_netto/$ang_netto;
					}
					$hasil->free_result();  
					if($ang_netto<0){
						$ang_netto1=$ang_netto*-1;
						$g='(';
						$h=')';
					} else{
						$ang_netto1=$ang_netto;
						$g='';
						$h='';
					}
					if($nil_netto<0){
						$nil_netto1=$nil_netto*-1;
						$i='(';
						$j=')';
					} else{
						$nil_netto1=$nil_netto;
						$i='';
						$j='';
					}
					if($sisa_netto<0){
						$sisa_netto1=$sisa_netto*-1;
						$k='(';
						$l=')';
					} else{
						$sisa_netto1=$sisa_netto;
						$k='';
						$l='';
					}	
					
					$ang_silpa = $ang_surplus+$ang_netto;
					$nil_silpa = $nil_surplus+$nil_netto;
					$sisa_silpa = $ang_silpa-$nil_silpa;
					if($ang_silpa==0){
						$persen_silpa=0;
					}else{
					$persen_silpa = $nil_silpa/$ang_silpa;
					}
					if($ang_silpa<0){
						$ang_silpa1=$ang_silpa*-1;
						$m='(';
						$n=')';
					} else{
						$ang_silpa1=$ang_silpa;
						$m='';
						$n='';
					}
					if($nil_silpa<0){
						$nil_silpa1=$nil_silpa*-1;
						$o='(';
						$p=')';
					} else{
						$nil_silpa1=$nil_silpa;
						$o='';
						$p='';
					}
					if($sisa_silpa<0){
						$sisa_silpa1=$sisa_silpa*-1;
						$q='(';
						$r=')';
					} else{
						$sisa_silpa1=$sisa_silpa;
						$q='';
						$r='';
					}	
			$sql = "SELECT seq, kode, nama, kode1, kode2, kode3,kode4, jenis, spasi FROM map_lra_sap ORDER BY seq
					";
					$no=0;
					$tot_peg=0;
					$tot_brg=0;
					$tot_mod=0;
					$tot_bansos=0;
                    $hasil = $this->db->query($sql);
                    foreach ($hasil->result() as $row)
                    {
					   $no=$no+1;
					   $seq = $row->seq;
					   $kode = $row->kode;
                       $nama = $row->nama;
                       $kode1 = $row->kode1;
                       $kode2 = $row->kode2;
                       $kode3 = $row->kode3;
                       $kode4 = $row->kode4;
                       //$jenis = $row->jenis;
                       $spasi = $row->spasi;
					   
					   if($kode1==''){
						$kode1="'X'";
						}
						if($kode2==''){
							$kode2="'XX'";
						}
						if($kode3==''){
							$kode3="'XXX'";
						}
						if($kode4==''){
							$kode4="'XXXXX'";
						}
					$sql = "SELECT SUM(nil_ang) as nil_ang, SUM(nilai) as nilai FROM $tabel($bulan,$anggaran) WHERE (LEFT(kd_rek5,1) IN ($kode1) or LEFT(kd_rek5,2) IN ($kode2) or LEFT(kd_rek5,3) IN ($kode3) or LEFT(kd_rek5,5) IN($kode4)) $where
					";
										
					
                    $hasil = $this->db->query($sql);
                    foreach ($hasil->result() as $row)
                    {
                       $nil_ang = $row->nil_ang;
					   $nilai = $row->nilai;
					}
					$sel = $nil_ang-$nilai;
					if(($nil_ang==0) || ($nil_ang=='')){
						$persen=0;
					} else{
					$persen = $nilai/$nil_ang;
					}
					 switch ($spasi) {
					 case 1:
                        $cRet .='<tr>
							   <td align="left" valign="top"><b>'.$kode.'</b></td> 
							   <td align="left"  valign="top"><b>'.$nama.'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($nil_ang, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($nilai, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($sel, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($persen, "2", ",", ".").'</b></td> 
							</tr>'; 
                        break;	
                    case 2:
                         $cRet .='<tr>
							   <td align="left" valign="top"><b>'.$kode.'</b></td> 
							   <td align="left"  valign="top"><b>&nbsp;&nbsp;'.$nama.'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($nil_ang, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($nilai, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($sel, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($persen, "2", ",", ".").'</b></td> 
							</tr>';
                        break;
					 case 3:
                         $cRet .='<tr>
							   <td align="left" valign="top">'.$kode.'</b></td> 
							   <td align="left"  valign="top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$nama.'</td> 
							   <td align="right" valign="top">'.number_format($nil_ang, "2", ",", ".").'</td> 
							   <td align="right" valign="top">'.number_format($nilai, "2", ",", ".").'</td> 
							   <td align="right" valign="top">'.number_format($sel, "2", ",", ".").'</td> 
							   <td align="right" valign="top">'.number_format($persen, "2", ",", ".").'</td> 
							</tr>';
                        break;
					case 4:
                       $cRet .='<tr>
							   <td align="left" valign="top" ><b>'.$kode.'</b></td> 
							   <td align="left"  valign="top"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$nama.'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($nil_ang, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($nilai, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($sel, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($persen, "2", ",", ".").'</b></td> 
							</tr>';
                        break;
					case 5:
                       $cRet .='<tr>
							   <td align="left" valign="top" ><b>'.$kode.'</b></td> 
							   <td align="right"  valign="top"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$nama.'</b></td> 
							   <td align="right" valign="top"><b>'.$a.''.number_format($ang_surplus1, "2", ",", ".").''.$b.'</b></td> 
							   <td align="right" valign="top"><b>'.$c.''.number_format($nil_surplus1, "2", ",", ".").''.$d.'</b></td> 
							   <td align="right" valign="top"><b>'.$e.''.number_format($sisa_surplus1, "2", ",", ".").''.$f.'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($persen_surplus, "2", ",", ".").'</b></td> 
							</tr>';
                        break;
					case 6;
                       $cRet .='<tr>
							   <td align="left" valign="top" ><b>'.$kode.'</b></td> 
							   <td align="right"  valign="top"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$nama.'</b></td> 
							   <td align="right" valign="top" ><b>'.$g.''.number_format($ang_netto1, "2", ",", ".").''.$h.'</b></td> 
							   <td align="right" valign="top" ><b>'.$i.''.number_format($nil_netto1, "2", ",", ".").''.$j.'</b></td> 
							   <td align="right" valign="top" ><b>'.$k.''.number_format($sisa_netto1, "2", ",", ".").''.$l.'</b></td> 
							   <td align="right" valign="top" ><b>'.number_format($persen_netto, "2", ",", ".").'</b></td> 
							</tr>';
                        break;
					case 7;
                       $cRet .='<tr>
							   <td align="left" valign="top" ><b>'.$kode.'</b></td> 
							   <td align="right"  valign="top"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$nama.'</b></td> 
							   <td align="right" valign="top" ><b>'.$m.''.number_format($ang_silpa1, "2", ",", ".").''.$n.'</b></td> 
							   <td align="right" valign="top" ><b>'.$o.''.number_format($nil_silpa1, "2", ",", ".").''.$p.'</b></td> 
							   <td align="right" valign="top" ><b>'.$q.''.number_format($sisa_silpa1, "2", ",", ".").''.$r.'</b></td> 
							   <td align="right" valign="top" ><b>'.number_format($persen_silpa, "2", ",", ".").'</b></td> 
							</tr>';
                        break;
					}
					}
			 
                      
		
			$cRet .="</table>";
			$data['prev']= $cRet;    
            $judul='PerbugI ';
			switch ($ctk){
				case 0;
				echo ("<title>$judul</title>");
				echo $cRet;
				break;
				case 1;
				$this->tukd_model->_mpdf('',$cRet,10,10,10,'P');
				break;
				case 2;        
				header("Cache-Control: no-cache, no-store, must-revalidate");
				header("Content-Type: application/vnd.ms-excel");
				header("Content-Disposition: attachment; filename= $judul.xls");
				$this->load->view('anggaran/rka/perkadaII', $data);
				break;	
			}
		}
		
	function cetak_perkada_lampI_permen_spj($bulan='',$ctk='',$anggaran='',$jenis='',$kd_skpd=''){
        $lntahunang = $this->session->userdata('pcThang');       
		 switch  ($bulan){
        case  1:
        $judul="JANUARI";
        break;
        case  2:
        $judul="FEBRUARI";
        break;
        case  3:
        $judul= "TRIWULAN I";
        break;
        case  4:
        $judul="APRIL";
        break;
        case  5:
        $judul= "MEI";
        break;
        case  6:
        $judul= "SEMESTER I";
        break;
        case  7:
        $judul= "JULI";
        break;
        case  8:
        $judul= "AGUSTUS";
        break;
        case  9:
        $judul= "TRIWULAN III";
        break;
        case  10:
        $judul= "OKTOBER";
        break;
        case  11:
        $judul= "NOVEMBER";
        break;
        case  12:
        $judul= "SEMESTER II";
        break;
    }
		if ($kd_skpd=='-'){                               
            $where="";            
        } else{
			$where="AND kd_skpd='$kd_skpd'";
		}
		
		$cRet ='<TABLE style="border-collapse:collapse;font-size:11px;font-family:Arial" width="100%" border="0" cellspacing="0" cellpadding="1" align=center>
					<TR>
						<TD  width="60%" valign="top" align="right" > Lampiran I : </TD>
						<TD width="40%"  align="left" >Peraturan Gubernur <br>Nomor : <br>Tanggal: </TD>
					</TR>
					<tr>
					</TABLE><br/>';
	$cRet .="<TABLE style=\"border-collapse:collapse;font-family:Arial\" width=\"100%\" border=\"1\" cellspacing=\"0\" cellpadding=\"1\" align=\"center\">
					<tr>
					<td rowspan=\"3\" align=\"center\" style=\"border-right:hidden\">
                        <img src=\"".base_url()."/image/logoHP.png\"  width=\"75\" height=\"100\" />
                        </td>
					<td align=\"center\" style=\"border-left:hidden;border-bottom:hidden\"><strong>PEMERINTAH KABUPATEN SANGGAU </strong></td></tr>
                    <tr><td align=\"center\" style=\"border-left:hidden;border-bottom:hidden;border-top:hidden\"><b>RINGKASAN LAPORAN REALISASI ANGGARAN </b></tr>
					<tr><td align=\"center\" style=\"border-left:hidden;border-top:hidden\" ><b>$judul</b></tr>
					</TABLE>";
			
		$cRet .="<table style=\"border-collapse:collapse;font-family:Arial;font-size:11px\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"3\" cellpadding=\"3\">
                <thead>
				<tr>
                    <td rowspan=\"2\" width=\"7%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>KD REK</b></td>
                    <td rowspan=\"2\" width=\"32%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>URAIAN</b></td>
                    <td colspan=\"2\" width=\"37%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>JUMLAH (Rp.)</b></td>
                    <td colspan=\"2\" width=\"23%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>BERTAMBAH/KURANG</b></td>
				</tr>
				<tr>
					<td width=\"19%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>ANGGARAN</b></td>
					<td width=\"18%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>REALISASI</b></td>
					<td width=\"18%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>(Rp)</b></td>
					<td width=\"5%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>%</b></td>
					</tr>
					<tr>
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >1</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >2</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >3</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >4</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >5</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >6</td> 
				</tr>
				</thead>";
				
			$sql = "SELECT 
					SUM(CASE WHEN kd_rek='4' THEN (nil_ang) ELSE 0 END) - SUM(CASE WHEN kd_rek='5' THEN (nil_ang) ELSE 0 END) as ang_surplus,
					SUM(CASE WHEN kd_rek='4' THEN (kredit-debet) ELSE 0 END) - SUM(CASE WHEN kd_rek='5' THEN (debet-kredit) ELSE 0 END) as nil_surplus
					FROM
					(SELECT LEFT(kd_rek5,1) as kd_rek, SUM(nilai) as nil_ang, SUM(kredit) as kredit,SUM(debet) as debet FROM data_jurnal($bulan,$anggaran) WHERE LEFT(kd_rek5,1) IN ('4','5') $where
					GROUP BY LEFT(kd_rek5,1)) a;
					";
					  $hasil = $this->db->query($sql);
                    foreach ($hasil->result() as $row)
                    {
					   $ang_surplus = $row->ang_surplus;
                       $nil_surplus = $row->nil_surplus;
					}
					$sisa_surplus = $ang_surplus-$nil_surplus;
						if(($ang_surplus==0) || ($ang_surplus=='')){
						$persen_surplus=0;
					} else{
					$persen_surplus = $nil_surplus/$ang_surplus;
					}	
										$hasil->free_result();        
					if($ang_surplus<0){
						$ang_surplus1=$ang_surplus*-1;
						$a='(';
						$b=')';
					} else{
						$ang_surplus1=$ang_surplus;
						$a='';
						$b='';
					}
					if($nil_surplus<0){
						$nil_surplus1=$nil_surplus*-1;
						$c='(';
						$d=')';
					} else{
						$nil_surplus1=$nil_surplus;
						$c='';
						$d='';
					}
					if($sisa_surplus<0){
						$sisa_surplus1=$sisa_surplus*-1;
						$e='(';
						$f=')';
					} else{
						$sisa_surplus1=$sisa_surplus;
						$e='';
						$f='';
					}
			
			$sql = "SELECT 
					SUM(CASE WHEN kd_rek='61' THEN (nil_ang) ELSE 0 END) - SUM(CASE WHEN kd_rek='62' THEN (nil_ang) ELSE 0 END) as ang_netto,
					SUM(CASE WHEN kd_rek='61' THEN (kredit-debet) ELSE 0 END) - SUM(CASE WHEN kd_rek='62' THEN (debet-kredit) ELSE 0 END) as nil_netto
					FROM
					(SELECT LEFT(kd_rek5,2) as kd_rek, SUM(nilai) as nil_ang, SUM(kredit) as kredit,SUM(debet) as debet FROM data_jurnal($bulan,$anggaran) WHERE LEFT(kd_rek5,2) IN ('61','62') $where
					GROUP BY LEFT(kd_rek5,2)) a;
					";
					  $hasil = $this->db->query($sql);
                    foreach ($hasil->result() as $row)
                    {
					   $ang_netto = $row->ang_netto;
                       $nil_netto = $row->nil_netto;
					}
					$sisa_netto = $ang_netto-$nil_netto;
					if(($ang_netto==0) || ($ang_netto=='')){
						$persen_netto=0;
					} else{
					$persen_netto = $nil_netto/$ang_netto;
					}
					$hasil->free_result();  
					if($ang_netto<0){
						$ang_netto1=$ang_netto*-1;
						$g='(';
						$h=')';
					} else{
						$ang_netto1=$ang_netto;
						$g='';
						$h='';
					}
					if($nil_netto<0){
						$nil_netto1=$nil_netto*-1;
						$i='(';
						$j=')';
					} else{
						$nil_netto1=$nil_netto;
						$i='';
						$j='';
					}
					if($sisa_netto<0){
						$sisa_netto1=$sisa_netto*-1;
						$k='(';
						$l=')';
					} else{
						$sisa_netto1=$sisa_netto;
						$k='';
						$l='';
					}	
					
					$ang_silpa = $ang_surplus+$ang_netto;
					$nil_silpa = $nil_surplus+$nil_netto;
					$sisa_silpa = $ang_silpa-$nil_silpa;
					if($ang_silpa==0){
						$persen_silpa=0;
					}else{
					$persen_silpa = $nil_silpa/$ang_silpa;
					}
					if($ang_silpa<0){
						$ang_silpa1=$ang_silpa*-1;
						$m='(';
						$n=')';
					} else{
						$ang_silpa1=$ang_silpa;
						$m='';
						$n='';
					}
					if($nil_silpa<0){
						$nil_silpa1=$nil_silpa*-1;
						$o='(';
						$p=')';
					} else{
						$nil_silpa1=$nil_silpa;
						$o='';
						$p='';
					}
					if($sisa_silpa<0){
						$sisa_silpa1=$sisa_silpa*-1;
						$q='(';
						$r=')';
					} else{
						$sisa_silpa1=$sisa_silpa;
						$q='';
						$r='';
					}	
			$sql = "SELECT seq, kode, nama, kode1, kode2, kode3,kode4, jenis, spasi FROM map_lra_permen ORDER BY seq
					";
					$no=0;
					$tot_peg=0;
					$tot_brg=0;
					$tot_mod=0;
					$tot_bansos=0;
                    $hasil = $this->db->query($sql);
                    foreach ($hasil->result() as $row)
                    {
					   $no=$no+1;
					   $seq = $row->seq;
					   $kode = $row->kode;
                       $nama = $row->nama;
                       $kode1 = $row->kode1;
                       $kode2 = $row->kode2;
                       $kode3 = $row->kode3;
                       $kode4 = $row->kode4;
                       $jenis = $row->jenis;
                       $spasi = $row->spasi;
					   
					   if($kode1==''){
						$kode1="'X'";
						}
						if($kode2==''){
							$kode2="'XX'";
						}
						if($kode3==''){
							$kode3="'XXX'";
						}
						if($kode4==''){
							$kode4="'XXXXX'";
						}
					$sql = "SELECT SUM(nilai) as nil_ang, SUM($jenis) as nilai FROM data_jurnal($bulan,$anggaran) WHERE (LEFT(kd_rek5,1) IN ($kode1) or LEFT(kd_rek5,2) IN ($kode2) or LEFT(kd_rek5,3) IN ($kode3) or LEFT(kd_rek5,5) IN($kode4)) $where
					";
										
					
                    $hasil = $this->db->query($sql);
                    foreach ($hasil->result() as $row)
                    {
                       $nil_ang = $row->nil_ang;
					   $nilai = $row->nilai;
					}
					$sel = $nil_ang-$nilai;
					if(($nil_ang==0) || ($nil_ang=='')){
						$persen=0;
					} else{
					$persen = $nilai/$nil_ang;
					}
					 switch ($spasi) {
					 case 1:
                        $cRet .='<tr>
							   <td align="left" valign="top"><b>'.$kode.'</b></td> 
							   <td align="left"  valign="top"><b>'.$nama.'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($nil_ang, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($nilai, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($sel, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($persen, "2", ",", ".").'</b></td> 
							</tr>'; 
                        break;	
                    case 2:
                         $cRet .='<tr>
							   <td align="left" valign="top"><b>'.$kode.'</b></td> 
							   <td align="left"  valign="top"><b>&nbsp;&nbsp;'.$nama.'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($nil_ang, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($nilai, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($sel, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($persen, "2", ",", ".").'</b></td> 
							</tr>';
                        break;
					 case 3:
                         $cRet .='<tr>
							   <td align="left" valign="top">'.$kode.'</b></td> 
							   <td align="left"  valign="top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$nama.'</td> 
							   <td align="right" valign="top">'.number_format($nil_ang, "2", ",", ".").'</td> 
							   <td align="right" valign="top">'.number_format($nilai, "2", ",", ".").'</td> 
							   <td align="right" valign="top">'.number_format($sel, "2", ",", ".").'</td> 
							   <td align="right" valign="top">'.number_format($persen, "2", ",", ".").'</td> 
							</tr>';
                        break;
					case 4:
                       $cRet .='<tr>
							   <td align="left" valign="top" ><b>'.$kode.'</b></td> 
							   <td align="left"  valign="top"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$nama.'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($nil_ang, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($nilai, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($sel, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($persen, "2", ",", ".").'</b></td> 
							</tr>';
                        break;
					case 5:
                       $cRet .='<tr>
							   <td align="left" valign="top" ><b>'.$kode.'</b></td> 
							   <td align="right"  valign="top"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$nama.'</b></td> 
							   <td align="right" valign="top"><b>'.$a.''.number_format($ang_surplus1, "2", ",", ".").''.$b.'</b></td> 
							   <td align="right" valign="top"><b>'.$c.''.number_format($nil_surplus1, "2", ",", ".").''.$d.'</b></td> 
							   <td align="right" valign="top"><b>'.$e.''.number_format($sisa_surplus1, "2", ",", ".").''.$f.'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($persen_surplus, "2", ",", ".").'</b></td> 
							</tr>';
                        break;
					case 6;
                       $cRet .='<tr>
							   <td align="left" valign="top" ><b>'.$kode.'</b></td> 
							   <td align="right"  valign="top"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$nama.'</b></td> 
							   <td align="right" valign="top" ><b>'.$g.''.number_format($ang_netto1, "2", ",", ".").''.$h.'</b></td> 
							   <td align="right" valign="top" ><b>'.$i.''.number_format($nil_netto1, "2", ",", ".").''.$j.'</b></td> 
							   <td align="right" valign="top" ><b>'.$k.''.number_format($sisa_netto1, "2", ",", ".").''.$l.'</b></td> 
							   <td align="right" valign="top" ><b>'.number_format($persen_netto, "2", ",", ".").'</b></td> 
							</tr>';
                        break;
					case 7;
                       $cRet .='<tr>
							   <td align="left" valign="top" ><b>'.$kode.'</b></td> 
							   <td align="right"  valign="top"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$nama.'</b></td> 
							   <td align="right" valign="top" ><b>'.$m.''.number_format($ang_silpa1, "2", ",", ".").''.$n.'</b></td> 
							   <td align="right" valign="top" ><b>'.$o.''.number_format($nil_silpa1, "2", ",", ".").''.$p.'</b></td> 
							   <td align="right" valign="top" ><b>'.$q.''.number_format($sisa_silpa1, "2", ",", ".").''.$r.'</b></td> 
							   <td align="right" valign="top" ><b>'.number_format($persen_silpa, "2", ",", ".").'</b></td> 
							</tr>';
                        break;
					}
					}
			 
                      
		
			$cRet .="</table>";
			$data['prev']= $cRet;    
            $judul='PergubI_PERMEN ';
			switch ($ctk){
				case 0;
				echo ("<title>$judul</title>");
				echo $cRet;
				break;
				case 1;
				$this->tukd_model->_mpdf('',$cRet,10,10,10,'P');
				break;
				case 2;        
				header("Cache-Control: no-cache, no-store, must-revalidate");
				header("Content-Type: application/vnd.ms-excel");
				header("Content-Disposition: attachment; filename= $judul.xls");
				$this->load->view('anggaran/rka/perkadaII', $data);
				break;	
			}
		}
		
	function cetak_perkada_lampI_permen_sp2d($bulan='',$ctk='',$anggaran='',$jenis='', $kd_skpd=''){
        $lntahunang = $this->session->userdata('pcThang');       
		 switch  ($bulan){
        case  1:
        $judul="JANUARI";
        break;
        case  2:
        $judul="FEBRUARI";
        break;
        case  3:
        $judul= "TRIWULAN I";
        break;
        case  4:
        $judul="APRIL";
        break;
        case  5:
        $judul= "MEI";
        break;
        case  6:
        $judul= "SEMESTER I";
        break;
        case  7:
        $judul= "JULI";
        break;
        case  8:
        $judul= "AGUSTUS";
        break;
        case  9:
        $judul= "TRIWULAN III";
        break;
        case  10:
        $judul= "OKTOBER";
        break;
        case  11:
        $judul= "NOVEMBER";
        break;
        case  12:
        $judul= "SEMESTER II";
        break;
    }
		
		if ($kd_skpd=='-'){                               
            $where="";            
        } else{
			$where="AND kd_skpd='$kd_skpd'";
		}
		
		if($jenis==2){
			$tabel='data_sp2d';
		  }else if($jenis==3){
			$tabel='data_sp2d_lunas';
		  } else if($jenis==4){
			$tabel='data_sp2d_advice';
		  }

		
		$cRet ='<TABLE style="border-collapse:collapse;font-size:11px;font-family:Arial" width="100%" border="0" cellspacing="0" cellpadding="1" align=center>
					<TR>
						<TD  width="60%" valign="top" align="right" > Lampiran I : </TD>
						<TD width="40%"  align="left" >Peraturan Gubernur <br>Nomor : <br>Tanggal: </TD>
					</TR>
					</TABLE><br/>';
	$cRet .="<TABLE style=\"border-collapse:collapse;font-family:Arial\" width=\"100%\" border=\"1\" cellspacing=\"0\" cellpadding=\"1\" align=\"center\">
					<tr>
					<td rowspan=\"3\" align=\"center\" style=\"border-right:hidden\">
                        <img src=\"".base_url()."/image/logoHP.png\"  width=\"75\" height=\"100\" />
                        </td>
					<td align=\"center\" style=\"border-left:hidden;border-bottom:hidden\"><strong>PEMERINTAH KABUPATEN SANGGAU </strong></td></tr>
                    <tr><td align=\"center\" style=\"border-left:hidden;border-bottom:hidden;border-top:hidden\"><b>RINGKASAN LAPORAN REALISASI ANGGARAN </b></tr>
					<tr><td align=\"center\" style=\"border-left:hidden;border-top:hidden\" ><b>$judul</b></tr>
					</TABLE>";
			
		$cRet .="<table style=\"border-collapse:collapse;font-family:Arial;font-size:11px\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"3\" cellpadding=\"3\">
                <thead>
				<tr>
                    <td rowspan=\"2\" width=\"7%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>KD REK</b></td>
                    <td rowspan=\"2\" width=\"32%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>URAIAN</b></td>
                    <td colspan=\"2\" width=\"37%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>JUMLAH (Rp.)</b></td>
                    <td colspan=\"2\" width=\"23%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>BERTAMBAH/KURANG</b></td>
				</tr>
				<tr>
					<td width=\"19%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>ANGGARAN</b></td>
					<td width=\"18%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>REALISASI</b></td>
					<td width=\"18%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>(Rp)</b></td>
					<td width=\"5%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>%</b></td>
					</tr>
					<tr>
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >1</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >2</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >3</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >4</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >5</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >6</td> 
				</tr>
				</thead>";
				
			$sql = "SELECT 
					SUM(CASE WHEN kd_rek='4' THEN (nil_ang) ELSE 0 END) - SUM(CASE WHEN kd_rek='5' THEN (nil_ang) ELSE 0 END) as ang_surplus,
					SUM(CASE WHEN kd_rek='4' THEN (nilai) ELSE 0 END) - SUM(CASE WHEN kd_rek='5' THEN (nilai) ELSE 0 END) as nil_surplus
					FROM
					(SELECT LEFT(kd_rek5,1) as kd_rek, SUM(nil_ang) as nil_ang, SUM(nilai) as nilai FROM $tabel($bulan,$anggaran) WHERE LEFT(kd_rek5,1) IN ('4','5') $where
					GROUP BY LEFT(kd_rek5,1)) a;
					";
					  $hasil = $this->db->query($sql);
                    foreach ($hasil->result() as $row)
                    {
					   $ang_surplus = $row->ang_surplus;
                       $nil_surplus = $row->nil_surplus;
					}
					$sisa_surplus = $ang_surplus-$nil_surplus;
						if(($ang_surplus==0) || ($ang_surplus=='')){
						$persen_surplus=0;
					} else{
					$persen_surplus = $nil_surplus/$ang_surplus;
					}	
					$hasil->free_result();        
					if($ang_surplus<0){
						$ang_surplus1=$ang_surplus*-1;
						$a='(';
						$b=')';
					} else{
						$ang_surplus1=$ang_surplus;
						$a='';
						$b='';
					}
					if($nil_surplus<0){
						$nil_surplus1=$nil_surplus*-1;
						$c='(';
						$d=')';
					} else{
						$nil_surplus1=$nil_surplus;
						$c='';
						$d='';
					}
					if($sisa_surplus<0){
						$sisa_surplus1=$sisa_surplus*-1;
						$e='(';
						$f=')';
					} else{
						$sisa_surplus1=$sisa_surplus;
						$e='';
						$f='';
					}
			
			$sql = "SELECT 
					SUM(CASE WHEN kd_rek='61' THEN (nil_ang) ELSE 0 END) - SUM(CASE WHEN kd_rek='62' THEN (nil_ang) ELSE 0 END) as ang_netto,
					SUM(CASE WHEN kd_rek='61' THEN (nilai) ELSE 0 END) - SUM(CASE WHEN kd_rek='62' THEN (nilai) ELSE 0 END) as nil_netto
					FROM
					(SELECT LEFT(kd_rek5,2) as kd_rek, SUM(nil_ang) as nil_ang, SUM(nilai) as nilai FROM $tabel($bulan,$anggaran) WHERE LEFT(kd_rek5,2) IN ('61','62')  $where
					GROUP BY LEFT(kd_rek5,2)) a;
					";
					  $hasil = $this->db->query($sql);
                    foreach ($hasil->result() as $row)
                    {
					   $ang_netto = $row->ang_netto;
                       $nil_netto = $row->nil_netto;
					}
					$sisa_netto = $ang_netto-$nil_netto;
					if(($ang_netto==0) || ($ang_netto=='')){
						$persen_netto=0;
					} else{
					$persen_netto = $nil_netto/$ang_netto;
					}
					$hasil->free_result();  
					if($ang_netto<0){
						$ang_netto1=$ang_netto*-1;
						$g='(';
						$h=')';
					} else{
						$ang_netto1=$ang_netto;
						$g='';
						$h='';
					}
					if($nil_netto<0){
						$nil_netto1=$nil_netto*-1;
						$i='(';
						$j=')';
					} else{
						$nil_netto1=$nil_netto;
						$i='';
						$j='';
					}
					if($sisa_netto<0){
						$sisa_netto1=$sisa_netto*-1;
						$k='(';
						$l=')';
					} else{
						$sisa_netto1=$sisa_netto;
						$k='';
						$l='';
					}	
					
					$ang_silpa = $ang_surplus+$ang_netto;
					$nil_silpa = $nil_surplus+$nil_netto;
					$sisa_silpa = $ang_silpa-$nil_silpa;
					if($ang_silpa==0){
						$persen_silpa=0;
					}else{
					$persen_silpa = $nil_silpa/$ang_silpa;
					}
					if($ang_silpa<0){
						$ang_silpa1=$ang_silpa*-1;
						$m='(';
						$n=')';
					} else{
						$ang_silpa1=$ang_silpa;
						$m='';
						$n='';
					}
					if($nil_silpa<0){
						$nil_silpa1=$nil_silpa*-1;
						$o='(';
						$p=')';
					} else{
						$nil_silpa1=$nil_silpa;
						$o='';
						$p='';
					}
					if($sisa_silpa<0){
						$sisa_silpa1=$sisa_silpa*-1;
						$q='(';
						$r=')';
					} else{
						$sisa_silpa1=$sisa_silpa;
						$q='';
						$r='';
					}	
			$sql = "SELECT seq, kode, nama, kode1, kode2, kode3,kode4, jenis, spasi FROM map_lra_permen ORDER BY seq
					";
					$no=0;
					$tot_peg=0;
					$tot_brg=0;
					$tot_mod=0;
					$tot_bansos=0;
                    $hasil = $this->db->query($sql);
                    foreach ($hasil->result() as $row)
                    {
					   $no=$no+1;
					   $seq = $row->seq;
					   $kode = $row->kode;
                       $nama = $row->nama;
                       $kode1 = $row->kode1;
                       $kode2 = $row->kode2;
                       $kode3 = $row->kode3;
                       $kode4 = $row->kode4;
                       //$jenis = $row->jenis;
                       $spasi = $row->spasi;
					   
					   if($kode1==''){
						$kode1="'X'";
						}
						if($kode2==''){
							$kode2="'XX'";
						}
						if($kode3==''){
							$kode3="'XXX'";
						}
						if($kode4==''){
							$kode4="'XXXXX'";
						}
					$sql = "SELECT SUM(nil_ang) as nil_ang, SUM(nilai) as nilai FROM $tabel($bulan,$anggaran) WHERE (LEFT(kd_rek5,1) IN ($kode1) or LEFT(kd_rek5,2) IN ($kode2) or LEFT(kd_rek5,3) IN ($kode3) or LEFT(kd_rek5,5) IN($kode4))  $where
					";
										
					
                    $hasil = $this->db->query($sql);
                    foreach ($hasil->result() as $row)
                    {
                       $nil_ang = $row->nil_ang;
					   $nilai = $row->nilai;
					}
					$sel = $nil_ang-$nilai;
					if(($nil_ang==0) || ($nil_ang=='')){
						$persen=0;
					} else{
					$persen = $nilai/$nil_ang;
					}
					 switch ($spasi) {
					 case 1:
                        $cRet .='<tr>
							   <td align="left" valign="top"><b>'.$kode.'</b></td> 
							   <td align="left"  valign="top"><b>'.$nama.'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($nil_ang, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($nilai, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($sel, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($persen, "2", ",", ".").'</b></td> 
							</tr>'; 
                        break;	
                    case 2:
                         $cRet .='<tr>
							   <td align="left" valign="top"><b>'.$kode.'</b></td> 
							   <td align="left"  valign="top"><b>&nbsp;&nbsp;'.$nama.'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($nil_ang, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($nilai, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($sel, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($persen, "2", ",", ".").'</b></td> 
							</tr>';
                        break;
					 case 3:
                         $cRet .='<tr>
							   <td align="left" valign="top">'.$kode.'</b></td> 
							   <td align="left"  valign="top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$nama.'</td> 
							   <td align="right" valign="top">'.number_format($nil_ang, "2", ",", ".").'</td> 
							   <td align="right" valign="top">'.number_format($nilai, "2", ",", ".").'</td> 
							   <td align="right" valign="top">'.number_format($sel, "2", ",", ".").'</td> 
							   <td align="right" valign="top">'.number_format($persen, "2", ",", ".").'</td> 
							</tr>';
                        break;
					case 4:
                       $cRet .='<tr>
							   <td align="left" valign="top" ><b>'.$kode.'</b></td> 
							   <td align="left"  valign="top"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$nama.'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($nil_ang, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($nilai, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($sel, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($persen, "2", ",", ".").'</b></td> 
							</tr>';
                        break;
					case 5:
                       $cRet .='<tr>
							   <td align="left" valign="top" ><b>'.$kode.'</b></td> 
							   <td align="right"  valign="top"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$nama.'</b></td> 
							   <td align="right" valign="top"><b>'.$a.''.number_format($ang_surplus1, "2", ",", ".").''.$b.'</b></td> 
							   <td align="right" valign="top"><b>'.$c.''.number_format($nil_surplus1, "2", ",", ".").''.$d.'</b></td> 
							   <td align="right" valign="top"><b>'.$e.''.number_format($sisa_surplus1, "2", ",", ".").''.$f.'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($persen_surplus, "2", ",", ".").'</b></td> 
							</tr>';
                        break;
					case 6;
                       $cRet .='<tr>
							   <td align="left" valign="top" ><b>'.$kode.'</b></td> 
							   <td align="right"  valign="top"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$nama.'</b></td> 
							   <td align="right" valign="top" ><b>'.$g.''.number_format($ang_netto1, "2", ",", ".").''.$h.'</b></td> 
							   <td align="right" valign="top" ><b>'.$i.''.number_format($nil_netto1, "2", ",", ".").''.$j.'</b></td> 
							   <td align="right" valign="top" ><b>'.$k.''.number_format($sisa_netto1, "2", ",", ".").''.$l.'</b></td> 
							   <td align="right" valign="top" ><b>'.number_format($persen_netto, "2", ",", ".").'</b></td> 
							</tr>';
                        break;
					case 7;
                       $cRet .='<tr>
							   <td align="left" valign="top" ><b>'.$kode.'</b></td> 
							   <td align="right"  valign="top"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$nama.'</b></td> 
							   <td align="right" valign="top" ><b>'.$m.''.number_format($ang_silpa1, "2", ",", ".").''.$n.'</b></td> 
							   <td align="right" valign="top" ><b>'.$o.''.number_format($nil_silpa1, "2", ",", ".").''.$p.'</b></td> 
							   <td align="right" valign="top" ><b>'.$q.''.number_format($sisa_silpa1, "2", ",", ".").''.$r.'</b></td> 
							   <td align="right" valign="top" ><b>'.number_format($persen_silpa, "2", ",", ".").'</b></td> 
							</tr>';
                        break;
					}
					}
			 
                      
		
			$cRet .="</table>";
			$data['prev']= $cRet;    
            $judul='PergubI_PERMEN ';
			switch ($ctk){
				case 0;
				echo ("<title>$judul</title>");
				echo $cRet;
				break;
				case 1;
				$this->tukd_model->_mpdf('',$cRet,10,10,10,'P');
				break;
				case 2;        
				header("Cache-Control: no-cache, no-store, must-revalidate");
				header("Content-Type: application/vnd.ms-excel");
				header("Content-Disposition: attachment; filename= $judul.xls");
				$this->load->view('anggaran/rka/perkadaII', $data);
				break;	
			}
		}
	
function cetak_perkada_lampII($bulan='',$ctk='',$anggaran='',$kd_skpd='',$jenis='',$tglttd='', $ttd=''){
        $lntahunang = $this->session->userdata('pcThang');       
		switch  ($bulan){
        case  1:
        $judul="JANUARI";
        break;
        case  2:
        $judul="FEBRUARI";
        break;
        case  3:
        $judul= "MARET";
        break;
        case  4:
        $judul="APRIL";
        break;
        case  5:
        $judul= "MEI";
        break;
        case  6:
        $judul= "JUNI";
        break;
        case  7:
        $judul= "JULI";
        break;
        case  8:
        $judul= "AGUSTUS";
        break;
        case  9:
        $judul= "SEPTEMBER";
        break;
        case  10:
        $judul= "OKTOBER";
        break;
        case  11:
        $judul= "NOVEMBER";
        break;
        case  12:
        $judul= "DESEMBER";
        break;
    }
		$where= "WHERE kd_skpd='$kd_skpd'";	
		$tanggal = $tglttd == '-' ? '' : 'Sanggau, '.$this->tukd_model->tanggal_format_indonesia($tglttd) ;
	if($ttd=='-'){
		$nama='';
		$pangkat='';
		$jabatan='';
		$nip='';
	}else{
	$ttd=str_replace("abc"," ",$ttd);
	$sqlsc="SELECT nama,jabatan,pangkat FROM ms_ttd where nip='$ttd' AND kode='PA' and kd_skpd='1.20.00.00'";
                 $sqlsclient=$this->db->query($sqlsc);
                 foreach ($sqlsclient->result() as $rowttd)
                {
                    $nama = $rowttd->nama;
                    $jabatan = $rowttd->jabatan;
                    $pangkat = $rowttd->pangkat;
                    $nip = 'NIP. '.$ttd;
                } 
	}
		$cRet ='<TABLE style="border-collapse:collapse;font-size:11px;font-family:Arial" width="100%" border="0" cellspacing="0" cellpadding="1" align=center>
					<TR>
						<TD  width="60%" valign="top" align="right" > Lampiran II : </TD>
						<TD width="40%"  align="left" >Peraturan Gubernur <br>Nomor : <br>Tanggal: </TD>
					</TR>
					</TABLE><br/>';
	$cRet .="<TABLE style=\"border-collapse:collapse;font-family:Arial\" width=\"100%\" border=\"1\" cellspacing=\"0\" cellpadding=\"1\" align=\"center\">
					<tr>
					<td rowspan=\"4\" align=\"center\" style=\"border-right:hidden\">
                        <img src=\"".base_url()."/image/logoHP.png\"  width=\"75\" height=\"100\" />
                        </td>
					<td align=\"center\" style=\"border-left:hidden;border-bottom:hidden\"><strong>PEMERINTAH KABUPATEN SANGGAU </strong></td></tr>
                    <tr><td align=\"center\" style=\"border-left:hidden;border-bottom:hidden;border-top:hidden\"><b>RINCIAN LAPORAN REALISASI ANGGARAN MENURUT URUSAN PEMERINTAHAN DAERAH,ORGANISASI, </b></tr>
                    <tr><td align=\"center\" style=\"border-left:hidden;border-bottom:hidden;border-top:hidden\"><b>PENDAPATAN, BELANJA DAN PEMBIAYAAN</b></tr>
                    <tr><td align=\"center\" style=\"border-left:hidden;border-bottom:hidden;border-top:hidden\"><b>TAHUN ANGGARAN $lntahunang </b></tr>
					</TABLE>";
			
		$cRet .="<table style=\"border-collapse:collapse;font-family:Arial;font-size:11px\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"3\" cellpadding=\"3\">
                <thead>
				<tr>
                    <td rowspan=\"2\" width=\"7%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>KD REK</b></td>
                    <td rowspan=\"2\" width=\"25%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>URAIAN</b></td>
                    <td colspan=\"2\" width=\"45%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>JUMLAH (Rp.)</b></td>
                    <td colspan=\"2\" width=\"15%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>BERTAMBAH(BERKURANG)</b></td>
                    <td rowspan=\"2\" width=\"5%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>DASAR HUKUM</b></td>
				</tr>
				<tr>
					<td width=\"15%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>ANGGARAN</b></td>
					<td width=\"15%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>REALISASI</b></td>
					<td width=\"15%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>Rp.</b></td>
					<td width=\"15%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>%</b></td>
					</tr>
					<tr>
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >1</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >2</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >3</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >4</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >5=(4-3)</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >6)</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >7</td> 
				</tr>
				</thead>";
				
				$sql="SELECT kd_kegiatan,kd_rek,nm_rek,anggaran,sd_bulan_ini FROM realisasi_jurnal_pend($bulan,$anggaran) $where AND LEN(kd_rek)<='$jenis' ORDER BY kd_kegiatan,kd_rek";
					$hasil = $this->db->query($sql);
                    foreach ($hasil->result() as $row)
                    {
					   $kd_kegiatan = $row->kd_kegiatan;
					   $kd_rek = $row->kd_rek;
                       $nm_rek = $row->nm_rek;
                       $nil_ang = $row->anggaran;
                       $sd_bulan_ini = $row->sd_bulan_ini;
					   $sisa=$sd_bulan_ini-$nil_ang;
					   $persen = empty($nil_ang) || $nil_ang == 0 ? 0 :$sd_bulan_ini/$nil_ang;
					   $sisa1 = $sisa<0 ? $sisa*-1 :$sisa;
					   $a = $sisa<0 ? '(' :'';
					   $b = $sisa<0 ? ')' :'';
					   $leng=strlen($kd_rek);
					   switch ($leng) {
					   case 3:
					   $cRet .='<tr>
							   <td align="left" valign="top">'.$this->dotrek($kd_rek).'</td> 
							   <td align="left"  valign="top">'.$nm_rek.'</td> 
							   <td align="right" valign="top">'.number_format($nil_ang, "2", ",", ".").'</td> 
							   <td align="right" valign="top">'.number_format($sd_bulan_ini, "2", ",", ".").'</td> 
							   <td align="right" valign="top">'.$a.' '.number_format($sisa1, "2", ",", ".").' '.$b.'</td> 
							   <td align="right" valign="top">'.number_format($persen, "2", ",", ".").'</td> 
							   <td align="right" valign="top"></td> 
							</tr>';
					   break;
					   case 5:
					   $cRet .='<tr>
							   <td align="left" valign="top">'.$this->dotrek($kd_rek).'</td> 
							   <td align="left"  valign="top">'.$nm_rek.'</td> 
							   <td align="right" valign="top">'.number_format($nil_ang, "2", ",", ".").'</td> 
							   <td align="right" valign="top">'.number_format($sd_bulan_ini, "2", ",", ".").'</td> 
							   <td align="right" valign="top">'.$a.' '.number_format($sisa1, "2", ",", ".").' '.$b.'</td> 
							   <td align="right" valign="top">'.number_format($persen, "2", ",", ".").'</td> 
							   <td align="right" valign="top"></td> 
							</tr>';
					   break;
					   case 7:
					   $cRet .='<tr>
							   <td align="left" valign="top">'.$this->dotrek($kd_rek).'</td> 
							   <td align="left"  valign="top">'.$nm_rek.'</td> 
							   <td align="right" valign="top">'.number_format($nil_ang, "2", ",", ".").'</td> 
							   <td align="right" valign="top">'.number_format($sd_bulan_ini, "2", ",", ".").'</td> 
							   <td align="right" valign="top">'.$a.' '.number_format($sisa1, "2", ",", ".").' '.$b.'</td> 
							   <td align="right" valign="top">'.number_format($persen, "2", ",", ".").'</td> 
							   <td align="right" valign="top"></td> 
							</tr>';
					   break;
					   default:
					    $cRet .='<tr>
							   <td align="left" valign="top"><b>'.$this->dotrek($kd_rek).'</b></td> 
							   <td align="left"  valign="top"><b>'.$nm_rek.'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($nil_ang, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($sd_bulan_ini, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.$a.' '.number_format($sisa1, "2", ",", ".").' '.$b.'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($persen, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b></td> 
							</tr>';
					   break;
					   }
					}
					$hasil->free_result();  
					
					$sql="SELECT SUM(anggaran) anggaran ,SUM(sd_bulan_ini) sd_bulan_ini FROM realisasi_jurnal_pend($bulan,$anggaran) $where AND LEN(kd_rek)='3'";
					$hasil = $this->db->query($sql);
                    foreach ($hasil->result() as $row)
                    {
					   
                       $nil_ang = $row->anggaran;
                       $sd_bulan_ini = $row->sd_bulan_ini;
					   $sisa=$sd_bulan_ini-$nil_ang;
					   $persen = empty($nil_ang) || $nil_ang == 0 ? 0 :$sd_bulan_ini/$nil_ang;
					   $sisa1 = $sisa<0 ? $sisa*-1 :$sisa;
					   $a = $sisa<0 ? '(' :'';
					   $b = $sisa<0 ? ')' :'';

					   $cRet .='<tr>
							   <td align="left" valign="top"></td> 
							   <td align="left"  valign="top"><b>JUMLAH PENDAPATAN</b></td> 
							   <td align="right" valign="top"><b>'.number_format($nil_ang, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($sd_bulan_ini, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.$a.' '.number_format($sisa1, "2", ",", ".").' '.$b.'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($persen, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b></td> 
							</tr>';
					}
					$hasil->free_result(); 
					
					$sql="SELECT SUM(anggaran) anggaran ,SUM(sd_bulan_ini) sd_bulan_ini FROM realisasi_jurnal_objek($bulan,$anggaran) $where AND LEN(kd_rek)='3'";
					$hasil = $this->db->query($sql);
                    foreach ($hasil->result() as $row)
                    {
					   
                       $nil_ang1 = $row->anggaran;
                       $sd_bulan_ini1 = $row->sd_bulan_ini;
					   $sisa1=$sd_bulan_ini1-$nil_ang1;
					   $persen1 = empty($nil_ang1) || $nil_ang1 == 0 ? 0 :$sd_bulan_ini1/$nil_ang1;
					   $sisa11 = $sisa1<0 ? $sisa1*-1 :$sisa1;
					   $a = $sisa<0 ? '(' :'';
					   $b = $sisa<0 ? ')' :'';

					   $cRet .='<tr>
							   <td align="left" valign="top"></td> 
							   <td align="left"  valign="top"><b>BELANJA DAERAH</b></td> 
							   <td align="right" valign="top"><b>'.number_format($nil_ang1, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($sd_bulan_ini1, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.$a.' '.number_format($sisa11, "2", ",", ".").' '.$b.'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($persen1, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b></td> 
							</tr>';
					}
					$hasil->free_result(); 
					
					$sql="SELECT kd_kegiatan,kd_rek,nm_rek,anggaran,sd_bulan_ini FROM realisasi_jurnal_rinci($bulan,$anggaran) $where AND LEN(kd_rek)<='$jenis' ORDER BY kd_kegiatan,kd_rek";
					$hasil = $this->db->query($sql);
                    foreach ($hasil->result() as $row)
                    {
					   $kd_kegiatan = $row->kd_kegiatan;
					   $kd_rek = $row->kd_rek;
                       $nm_rek = $row->nm_rek;
                       $nil_ang = $row->anggaran;
                       $sd_bulan_ini = $row->sd_bulan_ini;
					   $sisa=$sd_bulan_ini-$nil_ang;
					   $persen = empty($nil_ang) || $nil_ang == 0 ? 0 :$sd_bulan_ini/$nil_ang;
					   $sisa1 = $sisa<0 ? $sisa*-1 :$sisa;
					   $a = $sisa<0 ? '(' :'';
					   $b = $sisa<0 ? ')' :'';

					   $leng=strlen($kd_rek);
					   switch ($leng) {
					   case 3:
					   $cRet .='<tr>
							   <td align="left" valign="top">'.$this->dotrek($kd_rek).'</td> 
							   <td align="left"  valign="top">'.$nm_rek.'</td> 
							   <td align="right" valign="top">'.number_format($nil_ang, "2", ",", ".").'</td> 
							   <td align="right" valign="top">'.number_format($sd_bulan_ini, "2", ",", ".").'</td> 
							   <td align="right" valign="top">'.$a.' '.number_format($sisa1, "2", ",", ".").' '.$b.'</td> 
							   <td align="right" valign="top">'.number_format($persen, "2", ",", ".").'</td> 
							   <td align="right" valign="top"></td> 
							</tr>';
					   break;
					   case 5:
					   $cRet .='<tr>
							   <td align="left" valign="top">'.$this->dotrek($kd_rek).'</td> 
							   <td align="left"  valign="top">'.$nm_rek.'</td> 
							   <td align="right" valign="top">'.number_format($nil_ang, "2", ",", ".").'</td> 
							   <td align="right" valign="top">'.number_format($sd_bulan_ini, "2", ",", ".").'</td> 
							   <td align="right" valign="top">'.$a.' '.number_format($sisa1, "2", ",", ".").' '.$b.'</td> 
							   <td align="right" valign="top">'.number_format($persen, "2", ",", ".").'</td> 
							   <td align="right" valign="top"></td> 
							</tr>';
					   break;
					   case 7:
					   $cRet .='<tr>
							   <td align="left" valign="top">'.$this->dotrek($kd_rek).'</td> 
							   <td align="left"  valign="top">'.$nm_rek.'</td> 
							   <td align="right" valign="top">'.number_format($nil_ang, "2", ",", ".").'</td> 
							   <td align="right" valign="top">'.number_format($sd_bulan_ini, "2", ",", ".").'</td> 
							   <td align="right" valign="top">'.$a.' '.number_format($sisa1, "2", ",", ".").' '.$b.'</td> 
							   <td align="right" valign="top">'.number_format($persen, "2", ",", ".").'</td> 
							   <td align="right" valign="top"></td> 
							</tr>';
					   break;
					   default:
					    $cRet .='<tr>
							   <td align="left" valign="top"><b></b></td> 
							   <td align="left"  valign="top"><b>'.$nm_rek.'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($nil_ang, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($sd_bulan_ini, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.$a.' '.number_format($sisa1, "2", ",", ".").' '.$b.'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($persen, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b></td> 
							</tr>';
					   break;
					   }
					}
					$hasil->free_result();  
					$cRet .='<tr>
							   <td align="left" valign="top"></td> 
							   <td align="left"  valign="top"><b>JUMLAH BELANJA</b></td> 
							   <td align="right" valign="top"><b>'.number_format($nil_ang1, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($sd_bulan_ini1, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b>'.$a.' '.number_format($sisa11, "2", ",", ".").' '.$b.'</b></td> 
							   <td align="right" valign="top"><b>'.number_format($persen1, "2", ",", ".").'</b></td> 
							   <td align="right" valign="top"><b></td> 
							</tr>';
			$cRet .="</table>";
			$cRet .="<table style=\"border-collapse:collapse;font-family:Arial;font-size:12px\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\">
				<tr>
                    <td width=\"50%\" align=\"center\">&nbsp;</td>
                    <td width=\"50%\" align=\"center\"></td>
				</tr>
				<tr>
                    <td width=\"50%\" align=\"center\">&nbsp;</td>
                    <td width=\"50%\" align=\"center\">$tanggal<br>$jabatan<br><br><br><br><br><b><u>$nama</u></b><br>$pangkat<br>$nip
					</td>
				</tr>
				</table>";
			$data['prev']= $cRet;    
            $judul='PergubII ';
			switch ($ctk){
				case 0;
				echo ("<title>$judul</title>");
				echo $cRet;
				break;
				case 1;
				$this->tukd_model->_mpdf('',$cRet,10,10,10,'L');
				break;
				case 2;        
				header("Cache-Control: no-cache, no-store, must-revalidate");
				header("Content-Type: application/vnd.ms-excel");
				header("Content-Disposition: attachment; filename= $judul.xls");
				$this->load->view('anggaran/rka/perkadaII', $data);
				break;	
			}
		}
		
	
	
}