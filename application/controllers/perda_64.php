<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Perda_64 extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('login_model');
		$this->client_logon = $this->session->userdata('logged');
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
	
function cetak_lra_pemkot_64_ro($bulan='',$ctk='',$anggaran='',$jenis='',$kd_skpd='',$ttd='',$tanggal_ttd='',$ttdperda='',$label=''){
        $lntahunang = $this->session->userdata('pcThang');
        $ttd1 = str_replace('n',' ',$ttdperda);
               
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
        
      if($label=='1'){
        $label = 'UNAUDITED';
        }else if($label=='2'){
        $label = 'AUDITED';
        }else{
        $label = '&nbsp;';
        }  
        

	$cRet="<TABLE style=\"border-collapse:collapse;font-size:12px;font-family:Bookman Old Style\" width=\"570%\" border=\"1\" cellspacing=\"0\" cellpadding=\"1\" align=\"center\">
					<tr>
					<td rowspan=\"4\" align=\"center\" style=\"border-right:hidden\">
                        <img src=\"".base_url()."/image/logoHP.png\"  width=\"75\" height=\"100\" />
                        </td>
					<td align=\"center\" style=\"border-left:hidden;border-bottom:hidden\"><strong>PEMERINTAH KABUPATEN SANGGAU </strong></td></tr>
                    <tr><td align=\"center\" style=\"border-left:hidden;border-bottom:hidden;border-top:hidden\"><b>LAPORAN REALISASI ANGGARAN PENDAPATAN DAN BELANJA </b></tr>
					<tr><td align=\"center\" style=\"border-left:hidden;border-top:hidden\" ><b>UNTUK TAHUN YANG BERAKHIR SAMPAI DENGAN $judul TAHUN $lntahunang</b></tr>
					<tr><td align=\"center\" style=\"border-left:hidden;border-top:hidden\" ><b>$label</b></tr>
					</TABLE>";
			
		$cRet .="<table style=\"border-collapse:collapse;font-family:Arial;font-size:11px\" width=\"570%\" align=\"center\" border=\"1\" cellspacing=\"3\" cellpadding=\"3\">
                <thead>
				<tr>
                    <td rowspan=\"2\" width=\"7%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>KD REK</b></td>
                    <td rowspan=\"2\" width=\"32%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>URAIAN</b></td>
                    <td colspan=\"2\" width=\"37%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>PEMKOT</b></td>						
					<TD colspan=\"2\" width=\"37%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>DINAS PENDIDIKAN DAN KEBUDAYAAN</b></TD>
					<TD colspan=\"2\" width=\"37%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>DINAS KESEHATAN</b></TD>
					<TD colspan=\"2\" width=\"37%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>DINAS PEKERJAAN UMUM DAN PENATAAN RUANG</b></TD>
					<TD colspan=\"2\" width=\"37%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>DINAS PERUMAHAN RAKYAT DAN KAWASAN PEMUKIMAN</b></TD>
					<TD colspan=\"2\" width=\"37%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>SATUAN POLISI PAMONG PRAJA</b></TD>
					<TD colspan=\"2\" width=\"37%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>DINAS PENANGGULANGAN KEBAKARAN DAN BENCANA</b></TD>
					<TD colspan=\"2\" width=\"37%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>KANTOR KESATUAN BANGSA DAN SOSIAL POLITIK</b></TD>
					<TD colspan=\"2\" width=\"37%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>DINAS SOSIAL</b></TD>
					<TD colspan=\"2\" width=\"37%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>DINAS PENGENDALIAN PENDUDUK, KB, PEMBERDAYAAN PEREMPUAN DAN PERLINDUNGAN ANAK</b></TD>
					<TD colspan=\"2\" width=\"37%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>DINAS PANGAN, PERTANIAN DAN PERIKANAN</b></TD>
					<TD colspan=\"2\" width=\"37%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>DINAS LINGKUNGAN HIDUP</b></TD>
					<TD colspan=\"2\" width=\"37%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>DINAS KEPENDUDUKAN DAN PENCATATAN SIPIL</b></TD>
					<TD colspan=\"2\" width=\"37%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>DINAS PERHUBUNGAN</b></TD>
					<TD colspan=\"2\" width=\"37%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>DINAS KOMUNIKASI INFORMATIKA</b></TD>
					<TD colspan=\"2\" width=\"37%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>DINAS KOPERASI, USAHA MIKRO DAN PERDAGANGAN</b></TD>
					<TD colspan=\"2\" width=\"37%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>DINAS PENANAMAN MODAL, TENAGA KERJA DAN PELAYANAN TERPADU SATU PINTU</b></TD>
					<TD colspan=\"2\" width=\"37%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>DINAS KEPEMUDAAN, OLAHRAGA DAN PARIWISATA</b></TD>
					<TD colspan=\"2\" width=\"37%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>DINAS PERPUSTAKAAN</b></TD>
					<TD colspan=\"2\" width=\"37%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>BADAN PERENCANAAN PEMBANGUNAN DAERAH</b></TD>
					<TD colspan=\"2\" width=\"37%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>PPKD</b></TD>
					<TD colspan=\"2\" width=\"37%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>BADAN KEUANGAN</b></TD>
					<TD colspan=\"2\" width=\"37%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>BADAN KEPEGAWAIAN DAN PENGEMBANGAN SUMBER DAYA MANUSIA</b></TD>
					<TD colspan=\"2\" width=\"37%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>DEWAN PERWAKILAN RAKYAT DAERAH</b></TD>
					<TD colspan=\"2\" width=\"37%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>SEKRETARIAT DPRD</b></TD>
					<TD colspan=\"2\" width=\"37%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>SEKRETARIAT DAERAH</b></TD>
					<TD colspan=\"2\" width=\"37%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>INSPEKTORAT</b></TD>
					<TD colspan=\"2\" width=\"37%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>KEC. PTK TENGGARA</b></TD>
					<TD colspan=\"2\" width=\"37%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>KEC. PTK SELATAN</b></TD>
					<TD colspan=\"2\" width=\"37%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>KEC. PTK TIMUR</b></TD>
					<TD colspan=\"2\" width=\"37%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>KEC. PTK KOTA</b></TD>
					<TD colspan=\"2\" width=\"37%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>KEC. PTK BARAT</b></TD>
					<TD colspan=\"2\" width=\"37%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>KEC. PTK UTARA</b></TD>
				</tr>
				<tr>
					<td width=\"19%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>ANGGARAN</b></td>
					<td width=\"18%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>REALISASI</b></td>
					<td width=\"19%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>ANGGARAN</b></td>
					<td width=\"18%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>REALISASI</b></td>
					<td width=\"19%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>ANGGARAN</b></td>
					<td width=\"18%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>REALISASI</b></td>
					<td width=\"19%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>ANGGARAN</b></td>
					<td width=\"18%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>REALISASI</b></td>
					<td width=\"19%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>ANGGARAN</b></td>
					<td width=\"18%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>REALISASI</b></td>
					<td width=\"19%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>ANGGARAN</b></td>
					<td width=\"18%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>REALISASI</b></td>
					<td width=\"19%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>ANGGARAN</b></td>
					<td width=\"18%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>REALISASI</b></td>
					<td width=\"19%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>ANGGARAN</b></td>
					<td width=\"18%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>REALISASI</b></td>
					<td width=\"19%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>ANGGARAN</b></td>
					<td width=\"18%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>REALISASI</b></td>
					<td width=\"19%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>ANGGARAN</b></td>
					<td width=\"18%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>REALISASI</b></td>
					<td width=\"19%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>ANGGARAN</b></td>
					<td width=\"18%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>REALISASI</b></td>
					<td width=\"19%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>ANGGARAN</b></td>
					<td width=\"18%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>REALISASI</b></td>
					<td width=\"19%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>ANGGARAN</b></td>
					<td width=\"18%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>REALISASI</b></td>
					<td width=\"19%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>ANGGARAN</b></td>
					<td width=\"18%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>REALISASI</b></td>
					<td width=\"19%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>ANGGARAN</b></td>
					<td width=\"18%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>REALISASI</b></td>
					<td width=\"19%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>ANGGARAN</b></td>
					<td width=\"18%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>REALISASI</b></td>
					<td width=\"19%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>ANGGARAN</b></td>
					<td width=\"18%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>REALISASI</b></td>
					<td width=\"19%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>ANGGARAN</b></td>
					<td width=\"18%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>REALISASI</b></td>
					<td width=\"19%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>ANGGARAN</b></td>
					<td width=\"18%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>REALISASI</b></td>
					<td width=\"19%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>ANGGARAN</b></td>
					<td width=\"18%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>REALISASI</b></td>
					<td width=\"19%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>ANGGARAN</b></td>
					<td width=\"18%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>REALISASI</b></td>
					<td width=\"19%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>ANGGARAN</b></td>
					<td width=\"18%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>REALISASI</b></td>
					<td width=\"19%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>ANGGARAN</b></td>
					<td width=\"18%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>REALISASI</b></td>
					<td width=\"19%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>ANGGARAN</b></td>
					<td width=\"18%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>REALISASI</b></td>
					<td width=\"19%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>ANGGARAN</b></td>
					<td width=\"18%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>REALISASI</b></td>
					<td width=\"19%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>ANGGARAN</b></td>
					<td width=\"18%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>REALISASI</b></td>
					<td width=\"19%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>ANGGARAN</b></td>
					<td width=\"18%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>REALISASI</b></td>
					<td width=\"19%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>ANGGARAN</b></td>
					<td width=\"18%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>REALISASI</b></td>
					<td width=\"19%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>ANGGARAN</b></td>
					<td width=\"18%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>REALISASI</b></td>
					<td width=\"19%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>ANGGARAN</b></td>
					<td width=\"18%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>REALISASI</b></td>
					<td width=\"19%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>ANGGARAN</b></td>
					<td width=\"18%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>REALISASI</b></td>
					<td width=\"19%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>ANGGARAN</b></td>
					<td width=\"18%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>REALISASI</b></td>
					<td width=\"19%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>ANGGARAN</b></td>
					<td width=\"18%\" align=\"center\" bgcolor=\"#CCCCCC\" ><b>REALISASI</b></td>
				</tr>
				<tr>
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >1</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >2</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >3</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >4</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >5</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >6</td>
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >7</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >8</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >9</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >10</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >11</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >12</td>
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >13</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >14</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >15</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >16</td>
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >17</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >18</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >19</td>   
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >20</td>
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >21</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >22</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >23</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >24</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >25</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >26</td>
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >27</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >28</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >29</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >30</td>
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >31</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >32</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >33</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >34</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >35</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >36</td>
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >37</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >38</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >39</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >40</td>
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >41</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >42</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >43</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >44</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >45</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >46</td>
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >47</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >48</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >49</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >50</td>
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >51</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >52</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >53</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >54</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >55</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >56</td>
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >57</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >58</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >59</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >60</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >61</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >62</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >63</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >64</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >65</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >66</td>
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >67</td> 
                   <td align=\"center\" bgcolor=\"#CCCCCC\" >68</td>       
				</tr>
				</thead>";
					
					$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>4<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>PENDAPATAN<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                 </tr>";	                   	
               
                $sql4="
                select z.kode,z.nama,z.anggaran,z.reali,z.anggaran_1_01_01,
				z.reali_1_01_01,
				z.anggaran_1_02_01,
				z.reali_1_02_01,
				z.anggaran_1_03_01,
				z.reali_1_03_01,
				z.anggaran_1_04_01,
				z.reali_1_04_01,
				z.anggaran_1_05_01,
				z.reali_1_05_01,
				z.anggaran_1_05_02,
				z.reali_1_05_02,
				z.anggaran_1_05_03,
				z.reali_1_05_03,
				z.anggaran_1_06_01,
				z.reali_1_06_01,
				z.anggaran_2_02_01,
				z.reali_2_02_01,
				z.anggaran_2_03_01,
				z.reali_2_03_01,
				z.anggaran_2_05_01,
				z.reali_2_05_01,
				z.anggaran_2_06_01,
				z.reali_2_06_01,
				z.anggaran_2_09_01,
				z.reali_2_09_01,
				z.anggaran_2_10_01,
				z.reali_2_10_01,
				z.anggaran_2_11_01,
				z.reali_2_11_01,
				z.anggaran_2_12_01,
				z.reali_2_12_01,
				z.anggaran_2_13_01,
				z.reali_2_13_01,
				z.anggaran_2_17_01,
				z.reali_2_17_01,
				z.anggaran_4_01_01,
				z.reali_4_01_01,
				z.anggaran_4_02_01,
				z.reali_4_02_01,
				z.anggaran_4_02_02,
				z.reali_4_02_02,
				z.anggaran_4_03_01,
				z.reali_4_03_01,
				z.anggaran_4_05_01,
				z.reali_4_05_01,
				z.anggaran_5_02_01,
				z.reali_5_02_01,
				z.anggaran_5_01_01,
				z.reali_5_01_01,
				z.anggaran_4_06_01,
				z.reali_4_06_01,
				z.anggaran_4_08_01,
				z.reali_4_08_01,
				z.anggaran_4_08_02,
				z.reali_4_08_02,
				z.anggaran_4_08_03,
				z.reali_4_08_03,
				z.anggaran_4_08_04,
				z.reali_4_08_04,
				z.anggaran_4_08_05,
				z.reali_4_08_05,
				z.anggaran_4_08_06,
				z.reali_4_08_06 from (
                SELECT left(a.kd_rek5,2) as kode,b.nm_rek2 as nama,sum(a.nilai_angg) as anggaran,sum(a.nilai_real) as reali,
				sum(nilai_ang_1_01_01) as anggaran_1_01_01,
				sum(nilai_real_1_01_01) as reali_1_01_01,
				sum(nilai_ang_1_02_01) as anggaran_1_02_01,
				sum(nilai_real_1_02_01) as reali_1_02_01,
				sum(nilai_ang_1_03_01) as anggaran_1_03_01,
				sum(nilai_real_1_03_01) as reali_1_03_01,
				sum(nilai_ang_1_04_01) as anggaran_1_04_01,
				sum(nilai_real_1_04_01) as reali_1_04_01,
				sum(nilai_ang_1_05_01) as anggaran_1_05_01,
				sum(nilai_real_1_05_01) as reali_1_05_01,
				sum(nilai_ang_1_05_02) as anggaran_1_05_02,
				sum(nilai_real_1_05_02) as reali_1_05_02,
				sum(nilai_ang_1_05_03) as anggaran_1_05_03,
				sum(nilai_real_1_05_03) as reali_1_05_03,
				sum(nilai_ang_1_06_01) as anggaran_1_06_01,
				sum(nilai_real_1_06_01) as reali_1_06_01,
				sum(nilai_ang_2_02_01) as anggaran_2_02_01,
				sum(nilai_real_2_02_01) as reali_2_02_01,
				sum(nilai_ang_2_03_01) as anggaran_2_03_01,
				sum(nilai_real_2_03_01) as reali_2_03_01,
				sum(nilai_ang_2_05_01) as anggaran_2_05_01,
				sum(nilai_real_2_05_01) as reali_2_05_01,
				sum(nilai_ang_2_06_01) as anggaran_2_06_01,
				sum(nilai_real_2_06_01) as reali_2_06_01,
				sum(nilai_ang_2_09_01) as anggaran_2_09_01,
				sum(nilai_real_2_09_01) as reali_2_09_01,
				sum(nilai_ang_2_10_01) as anggaran_2_10_01,
				sum(nilai_real_2_10_01) as reali_2_10_01,
				sum(nilai_ang_2_11_01) as anggaran_2_11_01,
				sum(nilai_real_2_11_01) as reali_2_11_01,
				sum(nilai_ang_2_12_01) as anggaran_2_12_01,
				sum(nilai_real_2_12_01) as reali_2_12_01,
				sum(nilai_ang_2_13_01) as anggaran_2_13_01,
				sum(nilai_real_2_13_01) as reali_2_13_01,
				sum(nilai_ang_2_17_01) as anggaran_2_17_01,
				sum(nilai_real_2_17_01) as reali_2_17_01,
				sum(nilai_ang_4_01_01) as anggaran_4_01_01,
				sum(nilai_real_4_01_01) as reali_4_01_01,
				sum(nilai_ang_4_02_01) as anggaran_4_02_01,
				sum(nilai_real_4_02_01) as reali_4_02_01,
				sum(nilai_ang_4_02_02) as anggaran_4_02_02,
				sum(nilai_real_4_02_02) as reali_4_02_02,
				sum(nilai_ang_4_03_01) as anggaran_4_03_01,
				sum(nilai_real_4_03_01) as reali_4_03_01,
				sum(nilai_ang_4_05_01) as anggaran_4_05_01,
				sum(nilai_real_4_05_01) as reali_4_05_01,
				sum(nilai_ang_5_02_01) as anggaran_5_02_01,
				sum(nilai_real_5_02_01) as reali_5_02_01,
				sum(nilai_ang_5_01_01) as anggaran_5_01_01,
				sum(nilai_real_5_01_01) as reali_5_01_01,
				sum(nilai_ang_4_06_01) as anggaran_4_06_01,
				sum(nilai_real_4_06_01) as reali_4_06_01,
				sum(nilai_ang_4_08_01) as anggaran_4_08_01,
				sum(nilai_real_4_08_01) as reali_4_08_01,
				sum(nilai_ang_4_08_02) as anggaran_4_08_02,
				sum(nilai_real_4_08_02) as reali_4_08_02,
				sum(nilai_ang_4_08_03) as anggaran_4_08_03,
				sum(nilai_real_4_08_03) as reali_4_08_03,
				sum(nilai_ang_4_08_04) as anggaran_4_08_04,
				sum(nilai_real_4_08_04) as reali_4_08_04,
				sum(nilai_ang_4_08_05) as anggaran_4_08_05,
				sum(nilai_real_4_08_05) as reali_4_08_05,
				sum(nilai_ang_4_08_06) as anggaran_4_08_06,
				sum(nilai_real_4_08_06) as reali_4_08_06 FROM realisasi_rekap_opd( $bulan,$anggaran,$lntahunang) a
                inner join ms_rek2_64 b on b.kd_rek2 = left(a.kd_rek5,2)                
                where left(a.kd_rek5,1)='4' 
                group by left(a.kd_rek5,2),b.nm_rek2
                union all
                SELECT left(a.kd_rek5,3) as kode,b.nm_rek3 as nama,sum(a.nilai_angg) as anggaran,sum(a.nilai_real) as reali,
				sum(nilai_ang_1_01_01) as anggaran_1_01_01,
				sum(nilai_real_1_01_01) as reali_1_01_01,
				sum(nilai_ang_1_02_01) as anggaran_1_02_01,
				sum(nilai_real_1_02_01) as reali_1_02_01,
				sum(nilai_ang_1_03_01) as anggaran_1_03_01,
				sum(nilai_real_1_03_01) as reali_1_03_01,
				sum(nilai_ang_1_04_01) as anggaran_1_04_01,
				sum(nilai_real_1_04_01) as reali_1_04_01,
				sum(nilai_ang_1_05_01) as anggaran_1_05_01,
				sum(nilai_real_1_05_01) as reali_1_05_01,
				sum(nilai_ang_1_05_02) as anggaran_1_05_02,
				sum(nilai_real_1_05_02) as reali_1_05_02,
				sum(nilai_ang_1_05_03) as anggaran_1_05_03,
				sum(nilai_real_1_05_03) as reali_1_05_03,
				sum(nilai_ang_1_06_01) as anggaran_1_06_01,
				sum(nilai_real_1_06_01) as reali_1_06_01,
				sum(nilai_ang_2_02_01) as anggaran_2_02_01,
				sum(nilai_real_2_02_01) as reali_2_02_01,
				sum(nilai_ang_2_03_01) as anggaran_2_03_01,
				sum(nilai_real_2_03_01) as reali_2_03_01,
				sum(nilai_ang_2_05_01) as anggaran_2_05_01,
				sum(nilai_real_2_05_01) as reali_2_05_01,
				sum(nilai_ang_2_06_01) as anggaran_2_06_01,
				sum(nilai_real_2_06_01) as reali_2_06_01,
				sum(nilai_ang_2_09_01) as anggaran_2_09_01,
				sum(nilai_real_2_09_01) as reali_2_09_01,
				sum(nilai_ang_2_10_01) as anggaran_2_10_01,
				sum(nilai_real_2_10_01) as reali_2_10_01,
				sum(nilai_ang_2_11_01) as anggaran_2_11_01,
				sum(nilai_real_2_11_01) as reali_2_11_01,
				sum(nilai_ang_2_12_01) as anggaran_2_12_01,
				sum(nilai_real_2_12_01) as reali_2_12_01,
				sum(nilai_ang_2_13_01) as anggaran_2_13_01,
				sum(nilai_real_2_13_01) as reali_2_13_01,
				sum(nilai_ang_2_17_01) as anggaran_2_17_01,
				sum(nilai_real_2_17_01) as reali_2_17_01,
				sum(nilai_ang_4_01_01) as anggaran_4_01_01,
				sum(nilai_real_4_01_01) as reali_4_01_01,
				sum(nilai_ang_4_02_01) as anggaran_4_02_01,
				sum(nilai_real_4_02_01) as reali_4_02_01,
				sum(nilai_ang_4_02_02) as anggaran_4_02_02,
				sum(nilai_real_4_02_02) as reali_4_02_02,
				sum(nilai_ang_4_03_01) as anggaran_4_03_01,
				sum(nilai_real_4_03_01) as reali_4_03_01,
				sum(nilai_ang_4_05_01) as anggaran_4_05_01,
				sum(nilai_real_4_05_01) as reali_4_05_01,
				sum(nilai_ang_5_02_01) as anggaran_5_02_01,
				sum(nilai_real_5_02_01) as reali_5_02_01,
				sum(nilai_ang_5_01_01) as anggaran_5_01_01,
				sum(nilai_real_5_01_01) as reali_5_01_01,
				sum(nilai_ang_4_06_01) as anggaran_4_06_01,
				sum(nilai_real_4_06_01) as reali_4_06_01,
				sum(nilai_ang_4_08_01) as anggaran_4_08_01,
				sum(nilai_real_4_08_01) as reali_4_08_01,
				sum(nilai_ang_4_08_02) as anggaran_4_08_02,
				sum(nilai_real_4_08_02) as reali_4_08_02,
				sum(nilai_ang_4_08_03) as anggaran_4_08_03,
				sum(nilai_real_4_08_03) as reali_4_08_03,
				sum(nilai_ang_4_08_04) as anggaran_4_08_04,
				sum(nilai_real_4_08_04) as reali_4_08_04,
				sum(nilai_ang_4_08_05) as anggaran_4_08_05,
				sum(nilai_real_4_08_05) as reali_4_08_05,
				sum(nilai_ang_4_08_06) as anggaran_4_08_06,
				sum(nilai_real_4_08_06) as reali_4_08_06 FROM realisasi_rekap_opd( $bulan,$anggaran,$lntahunang) a
                inner join ms_rek3_64 b on b.kd_rek3 = left(a.kd_rek5,3)                
                where left(a.kd_rek5,1)='4' 
                group by left(a.kd_rek5,3),b.nm_rek3
                union all
                SELECT left(a.kd_rek5,5) as kode,b.nm_rek4_64 as nama,sum(a.nilai_angg) as anggaran,sum(a.nilai_real) as reali,
				sum(nilai_ang_1_01_01) as anggaran_1_01_01,
				sum(nilai_real_1_01_01) as reali_1_01_01,
				sum(nilai_ang_1_02_01) as anggaran_1_02_01,
				sum(nilai_real_1_02_01) as reali_1_02_01,
				sum(nilai_ang_1_03_01) as anggaran_1_03_01,
				sum(nilai_real_1_03_01) as reali_1_03_01,
				sum(nilai_ang_1_04_01) as anggaran_1_04_01,
				sum(nilai_real_1_04_01) as reali_1_04_01,
				sum(nilai_ang_1_05_01) as anggaran_1_05_01,
				sum(nilai_real_1_05_01) as reali_1_05_01,
				sum(nilai_ang_1_05_02) as anggaran_1_05_02,
				sum(nilai_real_1_05_02) as reali_1_05_02,
				sum(nilai_ang_1_05_03) as anggaran_1_05_03,
				sum(nilai_real_1_05_03) as reali_1_05_03,
				sum(nilai_ang_1_06_01) as anggaran_1_06_01,
				sum(nilai_real_1_06_01) as reali_1_06_01,
				sum(nilai_ang_2_02_01) as anggaran_2_02_01,
				sum(nilai_real_2_02_01) as reali_2_02_01,
				sum(nilai_ang_2_03_01) as anggaran_2_03_01,
				sum(nilai_real_2_03_01) as reali_2_03_01,
				sum(nilai_ang_2_05_01) as anggaran_2_05_01,
				sum(nilai_real_2_05_01) as reali_2_05_01,
				sum(nilai_ang_2_06_01) as anggaran_2_06_01,
				sum(nilai_real_2_06_01) as reali_2_06_01,
				sum(nilai_ang_2_09_01) as anggaran_2_09_01,
				sum(nilai_real_2_09_01) as reali_2_09_01,
				sum(nilai_ang_2_10_01) as anggaran_2_10_01,
				sum(nilai_real_2_10_01) as reali_2_10_01,
				sum(nilai_ang_2_11_01) as anggaran_2_11_01,
				sum(nilai_real_2_11_01) as reali_2_11_01,
				sum(nilai_ang_2_12_01) as anggaran_2_12_01,
				sum(nilai_real_2_12_01) as reali_2_12_01,
				sum(nilai_ang_2_13_01) as anggaran_2_13_01,
				sum(nilai_real_2_13_01) as reali_2_13_01,
				sum(nilai_ang_2_17_01) as anggaran_2_17_01,
				sum(nilai_real_2_17_01) as reali_2_17_01,
				sum(nilai_ang_4_01_01) as anggaran_4_01_01,
				sum(nilai_real_4_01_01) as reali_4_01_01,
				sum(nilai_ang_4_02_01) as anggaran_4_02_01,
				sum(nilai_real_4_02_01) as reali_4_02_01,
				sum(nilai_ang_4_02_02) as anggaran_4_02_02,
				sum(nilai_real_4_02_02) as reali_4_02_02,
				sum(nilai_ang_4_03_01) as anggaran_4_03_01,
				sum(nilai_real_4_03_01) as reali_4_03_01,
				sum(nilai_ang_4_05_01) as anggaran_4_05_01,
				sum(nilai_real_4_05_01) as reali_4_05_01,
				sum(nilai_ang_5_02_01) as anggaran_5_02_01,
				sum(nilai_real_5_02_01) as reali_5_02_01,
				sum(nilai_ang_5_01_01) as anggaran_5_01_01,
				sum(nilai_real_5_01_01) as reali_5_01_01,
				sum(nilai_ang_4_06_01) as anggaran_4_06_01,
				sum(nilai_real_4_06_01) as reali_4_06_01,
				sum(nilai_ang_4_08_01) as anggaran_4_08_01,
				sum(nilai_real_4_08_01) as reali_4_08_01,
				sum(nilai_ang_4_08_02) as anggaran_4_08_02,
				sum(nilai_real_4_08_02) as reali_4_08_02,
				sum(nilai_ang_4_08_03) as anggaran_4_08_03,
				sum(nilai_real_4_08_03) as reali_4_08_03,
				sum(nilai_ang_4_08_04) as anggaran_4_08_04,
				sum(nilai_real_4_08_04) as reali_4_08_04,
				sum(nilai_ang_4_08_05) as anggaran_4_08_05,
				sum(nilai_real_4_08_05) as reali_4_08_05,
				sum(nilai_ang_4_08_06) as anggaran_4_08_06,
				sum(nilai_real_4_08_06) as reali_4_08_06 FROM realisasi_rekap_opd( $bulan,$anggaran,$lntahunang) a
                inner join ms_rek4_64 b on b.kd_rek4_64 = left(a.kd_rek5,5)                
                where left(a.kd_rek5,1)='4' 
                group by left(a.kd_rek5,5),b.nm_rek4_64
                union all
                SELECT a.kd_rek5 as kode,b.nm_rek64 as nama,sum(a.nilai_angg) as anggaran,sum(a.nilai_real) as reali,
				sum(nilai_ang_1_01_01) as anggaran_1_01_01,
				sum(nilai_real_1_01_01) as reali_1_01_01,
				sum(nilai_ang_1_02_01) as anggaran_1_02_01,
				sum(nilai_real_1_02_01) as reali_1_02_01,
				sum(nilai_ang_1_03_01) as anggaran_1_03_01,
				sum(nilai_real_1_03_01) as reali_1_03_01,
				sum(nilai_ang_1_04_01) as anggaran_1_04_01,
				sum(nilai_real_1_04_01) as reali_1_04_01,
				sum(nilai_ang_1_05_01) as anggaran_1_05_01,
				sum(nilai_real_1_05_01) as reali_1_05_01,
				sum(nilai_ang_1_05_02) as anggaran_1_05_02,
				sum(nilai_real_1_05_02) as reali_1_05_02,
				sum(nilai_ang_1_05_03) as anggaran_1_05_03,
				sum(nilai_real_1_05_03) as reali_1_05_03,
				sum(nilai_ang_1_06_01) as anggaran_1_06_01,
				sum(nilai_real_1_06_01) as reali_1_06_01,
				sum(nilai_ang_2_02_01) as anggaran_2_02_01,
				sum(nilai_real_2_02_01) as reali_2_02_01,
				sum(nilai_ang_2_03_01) as anggaran_2_03_01,
				sum(nilai_real_2_03_01) as reali_2_03_01,
				sum(nilai_ang_2_05_01) as anggaran_2_05_01,
				sum(nilai_real_2_05_01) as reali_2_05_01,
				sum(nilai_ang_2_06_01) as anggaran_2_06_01,
				sum(nilai_real_2_06_01) as reali_2_06_01,
				sum(nilai_ang_2_09_01) as anggaran_2_09_01,
				sum(nilai_real_2_09_01) as reali_2_09_01,
				sum(nilai_ang_2_10_01) as anggaran_2_10_01,
				sum(nilai_real_2_10_01) as reali_2_10_01,
				sum(nilai_ang_2_11_01) as anggaran_2_11_01,
				sum(nilai_real_2_11_01) as reali_2_11_01,
				sum(nilai_ang_2_12_01) as anggaran_2_12_01,
				sum(nilai_real_2_12_01) as reali_2_12_01,
				sum(nilai_ang_2_13_01) as anggaran_2_13_01,
				sum(nilai_real_2_13_01) as reali_2_13_01,
				sum(nilai_ang_2_17_01) as anggaran_2_17_01,
				sum(nilai_real_2_17_01) as reali_2_17_01,
				sum(nilai_ang_4_01_01) as anggaran_4_01_01,
				sum(nilai_real_4_01_01) as reali_4_01_01,
				sum(nilai_ang_4_02_01) as anggaran_4_02_01,
				sum(nilai_real_4_02_01) as reali_4_02_01,
				sum(nilai_ang_4_02_02) as anggaran_4_02_02,
				sum(nilai_real_4_02_02) as reali_4_02_02,
				sum(nilai_ang_4_03_01) as anggaran_4_03_01,
				sum(nilai_real_4_03_01) as reali_4_03_01,
				sum(nilai_ang_4_05_01) as anggaran_4_05_01,
				sum(nilai_real_4_05_01) as reali_4_05_01,
				sum(nilai_ang_5_02_01) as anggaran_5_02_01,
				sum(nilai_real_5_02_01) as reali_5_02_01,
				sum(nilai_ang_5_01_01) as anggaran_5_01_01,
				sum(nilai_real_5_01_01) as reali_5_01_01,
				sum(nilai_ang_4_06_01) as anggaran_4_06_01,
				sum(nilai_real_4_06_01) as reali_4_06_01,
				sum(nilai_ang_4_08_01) as anggaran_4_08_01,
				sum(nilai_real_4_08_01) as reali_4_08_01,
				sum(nilai_ang_4_08_02) as anggaran_4_08_02,
				sum(nilai_real_4_08_02) as reali_4_08_02,
				sum(nilai_ang_4_08_03) as anggaran_4_08_03,
				sum(nilai_real_4_08_03) as reali_4_08_03,
				sum(nilai_ang_4_08_04) as anggaran_4_08_04,
				sum(nilai_real_4_08_04) as reali_4_08_04,
				sum(nilai_ang_4_08_05) as anggaran_4_08_05,
				sum(nilai_real_4_08_05) as reali_4_08_05,
				sum(nilai_ang_4_08_06) as anggaran_4_08_06,
				sum(nilai_real_4_08_06) as reali_4_08_06 FROM realisasi_rekap_opd( $bulan,$anggaran,$lntahunang) a
                inner join ms_rek5 b on b.kd_rek64 = a.kd_rek5                
                where left(a.kd_rek5,1)='4' 
                group by a.kd_rek5,b.nm_rek64
                )z order by kode,nama
                ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil    = $row4->reali;
					$angnil = $row4->anggaran;
					$angnil_1_01_01  = $row4->anggaran_1_01_01;
					$nil_1_01_01  = $row4->reali_1_01_01;
					$angnil_1_02_01  = $row4->anggaran_1_02_01;
					$nil_1_02_01  = $row4->reali_1_02_01;
					$angnil_1_03_01  = $row4->anggaran_1_03_01;
					$nil_1_03_01  = $row4->reali_1_03_01;
					$angnil_1_04_01  = $row4->anggaran_1_04_01;
					$nil_1_04_01  = $row4->reali_1_04_01;
					$angnil_1_05_01  = $row4->anggaran_1_05_01;
					$nil_1_05_01  = $row4->reali_1_05_01;
					$angnil_1_05_02  = $row4->anggaran_1_05_02;
					$nil_1_05_02  = $row4->reali_1_05_02;
					$angnil_1_05_03  = $row4->anggaran_1_05_03;
					$nil_1_05_03  = $row4->reali_1_05_03;
					$angnil_1_06_01  = $row4->anggaran_1_06_01;
					$nil_1_06_01  = $row4->reali_1_06_01;
					$angnil_2_02_01  = $row4->anggaran_2_02_01;
					$nil_2_02_01  = $row4->reali_2_02_01;
					$angnil_2_03_01  = $row4->anggaran_2_03_01;
					$nil_2_03_01  = $row4->reali_2_03_01;
					$angnil_2_05_01  = $row4->anggaran_2_05_01;
					$nil_2_05_01  = $row4->reali_2_05_01;
					$angnil_2_06_01  = $row4->anggaran_2_06_01;
					$nil_2_06_01  = $row4->reali_2_06_01;
					$angnil_2_09_01  = $row4->anggaran_2_09_01;
					$nil_2_09_01  = $row4->reali_2_09_01;
					$angnil_2_10_01  = $row4->anggaran_2_10_01;
					$nil_2_10_01  = $row4->reali_2_10_01;
					$angnil_2_11_01  = $row4->anggaran_2_11_01;
					$nil_2_11_01  = $row4->reali_2_11_01;
					$angnil_2_12_01  = $row4->anggaran_2_12_01;
					$nil_2_12_01  = $row4->reali_2_12_01;
					$angnil_2_13_01  = $row4->anggaran_2_13_01;
					$nil_2_13_01  = $row4->reali_2_13_01;
					$angnil_2_17_01  = $row4->anggaran_2_17_01;
					$nil_2_17_01  = $row4->reali_2_17_01;
					$angnil_4_01_01  = $row4->anggaran_4_01_01;
					$nil_4_01_01  = $row4->reali_4_01_01;
					$angnil_4_02_01  = $row4->anggaran_4_02_01;
					$nil_4_02_01  = $row4->reali_4_02_01;
					$angnil_4_02_02  = $row4->anggaran_4_02_02;
					$nil_4_02_02  = $row4->reali_4_02_02;
					$angnil_4_03_01  = $row4->anggaran_4_03_01;
					$nil_4_03_01  = $row4->reali_4_03_01;
					$angnil_4_05_01  = $row4->anggaran_4_05_01;
					$nil_4_05_01  = $row4->reali_4_05_01;
					$angnil_5_02_01  = $row4->anggaran_5_02_01;
					$nil_5_02_01  = $row4->reali_5_02_01;
					$angnil_5_01_01  = $row4->anggaran_5_01_01;
					$nil_5_01_01  = $row4->reali_5_01_01;
					$angnil_4_06_01  = $row4->anggaran_4_06_01;
					$nil_4_06_01  = $row4->reali_4_06_01;
					$angnil_4_08_01  = $row4->anggaran_4_08_01;
					$nil_4_08_01  = $row4->reali_4_08_01;
					$angnil_4_08_02  = $row4->anggaran_4_08_02;
					$nil_4_08_02  = $row4->reali_4_08_02;
					$angnil_4_08_03  = $row4->anggaran_4_08_03;
					$nil_4_08_03  = $row4->reali_4_08_03;
					$angnil_4_08_04  = $row4->anggaran_4_08_04;
					$nil_4_08_04  = $row4->reali_4_08_04;
					$angnil_4_08_05  = $row4->anggaran_4_08_05;
					$nil_4_08_05  = $row4->reali_4_08_05;
					$angnil_4_08_06  = $row4->anggaran_4_08_06;
					$nil_4_08_06  = $row4->reali_4_08_06;
					
					$angnilai =  number_format($angnil, "2", ",", ".");
					$nilai  =  number_format($nil, "2", ",", ".");
					$angnil_1_01_01  =  number_format($angnil_1_01_01, "2", ",", ".");
					$nil_1_01_01  =  number_format($nil_1_01_01, "2", ",", ".");
					$angnil_1_02_01  =  number_format($angnil_1_02_01, "2", ",", ".");
					$nil_1_02_01  =  number_format($nil_1_02_01, "2", ",", ".");
					$angnil_1_03_01  =  number_format($angnil_1_03_01, "2", ",", ".");
					$nil_1_03_01  =  number_format($nil_1_03_01, "2", ",", ".");
					$angnil_1_04_01  =  number_format($angnil_1_04_01, "2", ",", ".");
					$nil_1_04_01  =  number_format($nil_1_04_01, "2", ",", ".");
					$angnil_1_05_01  =  number_format($angnil_1_05_01, "2", ",", ".");
					$nil_1_05_01  =  number_format($nil_1_05_01, "2", ",", ".");
					$angnil_1_05_02  =  number_format($angnil_1_05_02, "2", ",", ".");
					$nil_1_05_02  =  number_format($nil_1_05_02, "2", ",", ".");
					$angnil_1_05_03  =  number_format($angnil_1_05_03, "2", ",", ".");
					$nil_1_05_03  =  number_format($nil_1_05_03, "2", ",", ".");
					$angnil_1_06_01  =  number_format($angnil_1_06_01, "2", ",", ".");
					$nil_1_06_01  =  number_format($nil_1_06_01, "2", ",", ".");
					$angnil_2_02_01  =  number_format($angnil_2_02_01, "2", ",", ".");
					$nil_2_02_01  =  number_format($nil_2_02_01, "2", ",", ".");
					$angnil_2_03_01  =  number_format($angnil_2_03_01, "2", ",", ".");
					$nil_2_03_01  =  number_format($nil_2_03_01, "2", ",", ".");
					$angnil_2_05_01  =  number_format($angnil_2_05_01, "2", ",", ".");
					$nil_2_05_01  =  number_format($nil_2_05_01, "2", ",", ".");
					$angnil_2_06_01  =  number_format($angnil_2_06_01, "2", ",", ".");
					$nil_2_06_01  =  number_format($nil_2_06_01, "2", ",", ".");
					$angnil_2_09_01  =  number_format($angnil_2_09_01, "2", ",", ".");
					$nil_2_09_01  =  number_format($nil_2_09_01, "2", ",", ".");
					$angnil_2_10_01  =  number_format($angnil_2_10_01, "2", ",", ".");
					$nil_2_10_01  =  number_format($nil_2_10_01, "2", ",", ".");
					$angnil_2_11_01  =  number_format($angnil_2_11_01, "2", ",", ".");
					$nil_2_11_01  =  number_format($nil_2_11_01, "2", ",", ".");
					$angnil_2_12_01  =  number_format($angnil_2_12_01, "2", ",", ".");
					$nil_2_12_01  =  number_format($nil_2_12_01, "2", ",", ".");
					$angnil_2_13_01  =  number_format($angnil_2_13_01, "2", ",", ".");
					$nil_2_13_01  =  number_format($nil_2_13_01, "2", ",", ".");
					$angnil_2_17_01  =  number_format($angnil_2_17_01, "2", ",", ".");
					$nil_2_17_01  =  number_format($nil_2_17_01, "2", ",", ".");
					$angnil_4_01_01  =  number_format($angnil_4_01_01, "2", ",", ".");
					$nil_4_01_01  =  number_format($nil_4_01_01, "2", ",", ".");
					$angnil_4_02_01  =  number_format($angnil_4_02_01, "2", ",", ".");
					$nil_4_02_01  =  number_format($nil_4_02_01, "2", ",", ".");
					$angnil_4_02_02  =  number_format($angnil_4_02_02, "2", ",", ".");
					$nil_4_02_02  =  number_format($nil_4_02_02, "2", ",", ".");
					$angnil_4_03_01  =  number_format($angnil_4_03_01, "2", ",", ".");
					$nil_4_03_01  =  number_format($nil_4_03_01, "2", ",", ".");
					$angnil_4_05_01  =  number_format($angnil_4_05_01, "2", ",", ".");
					$nil_4_05_01  =  number_format($nil_4_05_01, "2", ",", ".");
					$angnil_5_02_01  =  number_format($angnil_5_02_01, "2", ",", ".");
					$nil_5_02_01  =  number_format($nil_5_02_01, "2", ",", ".");
					$angnil_5_01_01  =  number_format($angnil_5_01_01, "2", ",", ".");
					$nil_5_01_01  =  number_format($nil_5_01_01, "2", ",", ".");
					$angnil_4_06_01  =  number_format($angnil_4_06_01, "2", ",", ".");
					$nil_4_06_01  =  number_format($nil_4_06_01, "2", ",", ".");
					$angnil_4_08_01  =  number_format($angnil_4_08_01, "2", ",", ".");
					$nil_4_08_01  =  number_format($nil_4_08_01, "2", ",", ".");
					$angnil_4_08_02  =  number_format($angnil_4_08_02, "2", ",", ".");
					$nil_4_08_02  =  number_format($nil_4_08_02, "2", ",", ".");
					$angnil_4_08_03  =  number_format($angnil_4_08_03, "2", ",", ".");
					$nil_4_08_03  =  number_format($nil_4_08_03, "2", ",", ".");
					$angnil_4_08_04  =  number_format($angnil_4_08_04, "2", ",", ".");
					$nil_4_08_04  =  number_format($nil_4_08_04, "2", ",", ".");
					$angnil_4_08_05  =  number_format($angnil_4_08_05, "2", ",", ".");
					$nil_4_08_05  =  number_format($nil_4_08_05, "2", ",", ".");
					$angnil_4_08_06  =  number_format($angnil_4_08_06, "2", ",", ".");
					$nil_4_08_06  =  number_format($nil_4_08_06, "2", ",", ".");
					
                    
                   if(strlen("$no")<6){
                    $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai<b></td>
									 <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_1_01_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_1_01_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_1_02_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_1_02_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_1_03_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_1_03_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_1_04_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_1_04_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_1_05_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_1_05_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_1_05_02<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_1_05_02<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_1_05_03<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_1_05_03<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_1_06_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_1_06_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_2_02_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_2_02_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_2_03_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_2_03_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_2_05_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_2_05_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_2_06_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_2_06_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_2_09_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_2_09_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_2_10_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_2_10_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_2_11_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_2_11_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_2_12_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_2_12_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_2_13_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_2_13_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_2_17_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_2_17_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_4_01_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_4_01_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_4_02_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_4_02_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_4_02_02<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_4_02_02<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_4_03_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_4_03_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_4_05_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_4_05_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_5_02_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_5_02_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_5_01_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_5_01_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_4_06_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_4_06_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_4_08_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_4_08_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_4_08_02<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_4_08_02<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_4_08_03<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_4_08_03<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_4_08_04<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_4_08_04<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_4_08_05<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_4_08_05<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_4_08_06<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_4_08_06<b></td>
                                 </tr>";
                             }else
                             {
					$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">$no</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\">$nama</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nilai</td>
									 <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_1_01_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_1_01_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_1_02_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_1_02_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_1_03_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_1_03_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_1_04_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_1_04_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_1_05_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_1_05_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_1_05_02</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_1_05_02</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_1_05_03</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_1_05_03</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_1_06_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_1_06_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_2_02_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_2_02_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_2_03_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_2_03_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_2_05_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_2_05_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_2_06_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_2_06_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_2_09_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_2_09_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_2_10_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_2_10_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_2_11_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_2_11_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_2_12_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_2_12_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_2_13_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_2_13_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_2_17_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_2_17_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_4_01_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_4_01_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_4_02_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_4_02_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_4_02_02</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_4_02_02</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_4_03_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_4_03_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_4_05_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_4_05_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_5_02_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_5_02_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_5_01_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_5_01_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_4_06_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_4_06_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_4_08_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_4_08_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_4_08_02</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_4_08_02</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_4_08_03</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_4_08_03</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_4_08_04</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_4_08_04</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_4_08_05</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_4_08_05</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_4_08_06</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_4_08_06</td>
                                 </tr>";
                             }
               }
               		$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                 </tr>";
								 
						$angnil4=0;
						$nil4=0;	
						$angnil4_1_01_01=0;
						$nil4_1_01_01=0;
						$angnil4_1_02_01=0;
						$nil4_1_02_01=0;
						$angnil4_1_03_01=0;
						$nil4_1_03_01=0;
						$angnil4_1_04_01=0;
						$nil4_1_04_01=0;
						$angnil4_1_05_01=0;
						$nil4_1_05_01=0;
						$angnil4_1_05_02=0;
						$nil4_1_05_02=0;
						$angnil4_1_05_03=0;
						$nil4_1_05_03=0;
						$angnil4_1_06_01=0;
						$nil4_1_06_01=0;
						$angnil4_2_02_01=0;
						$nil4_2_02_01=0;
						$angnil4_2_03_01=0;
						$nil4_2_03_01=0;
						$angnil4_2_05_01=0;
						$nil4_2_05_01=0;
						$angnil4_2_06_01=0;
						$nil4_2_06_01=0;
						$angnil4_2_09_01=0;
						$nil4_2_09_01=0;
						$angnil4_2_10_01=0;
						$nil4_2_10_01=0;
						$angnil4_2_11_01=0;
						$nil4_2_11_01=0;
						$angnil4_2_12_01=0;
						$nil4_2_12_01=0;
						$angnil4_2_13_01=0;
						$nil4_2_13_01=0;
						$angnil4_2_17_01=0;
						$nil4_2_17_01=0;
						$angnil4_4_01_01=0;
						$nil4_4_01_01=0;
						$angnil4_4_02_01=0;
						$nil4_4_02_01=0;
						$angnil4_4_02_02=0;
						$nil4_4_02_02=0;
						$angnil4_4_03_01=0;
						$nil4_4_03_01=0;
						$angnil4_4_05_01=0;
						$nil4_4_05_01=0;
						$angnil4_5_02_01=0;
						$nil4_5_02_01=0;
						$angnil4_5_01_01=0;
						$nil4_5_01_01=0;
						$angnil4_4_06_01=0;
						$nil4_4_06_01=0;
						$angnil4_4_08_01=0;
						$nil4_4_08_01=0;
						$angnil4_4_08_02=0;
						$nil4_4_08_02=0;
						$angnil4_4_08_03=0;
						$nil4_4_08_03=0;
						$angnil4_4_08_04=0;
						$nil4_4_08_04=0;
						$angnil4_4_08_05=0;
						$nil4_4_08_05=0;
						$angnil4_4_08_06=0;
						$nil4_4_08_06=0;								 
								 
                    $sql4="
                select z.kode,z.nama,z.anggaran,z.reali,z.anggaran_1_01_01,
				z.reali_1_01_01,
				z.anggaran_1_02_01,
				z.reali_1_02_01,
				z.anggaran_1_03_01,
				z.reali_1_03_01,
				z.anggaran_1_04_01,
				z.reali_1_04_01,
				z.anggaran_1_05_01,
				z.reali_1_05_01,
				z.anggaran_1_05_02,
				z.reali_1_05_02,
				z.anggaran_1_05_03,
				z.reali_1_05_03,
				z.anggaran_1_06_01,
				z.reali_1_06_01,
				z.anggaran_2_02_01,
				z.reali_2_02_01,
				z.anggaran_2_03_01,
				z.reali_2_03_01,
				z.anggaran_2_05_01,
				z.reali_2_05_01,
				z.anggaran_2_06_01,
				z.reali_2_06_01,
				z.anggaran_2_09_01,
				z.reali_2_09_01,
				z.anggaran_2_10_01,
				z.reali_2_10_01,
				z.anggaran_2_11_01,
				z.reali_2_11_01,
				z.anggaran_2_12_01,
				z.reali_2_12_01,
				z.anggaran_2_13_01,
				z.reali_2_13_01,
				z.anggaran_2_17_01,
				z.reali_2_17_01,
				z.anggaran_4_01_01,
				z.reali_4_01_01,
				z.anggaran_4_02_01,
				z.reali_4_02_01,
				z.anggaran_4_02_02,
				z.reali_4_02_02,
				z.anggaran_4_03_01,
				z.reali_4_03_01,
				z.anggaran_4_05_01,
				z.reali_4_05_01,
				z.anggaran_5_02_01,
				z.reali_5_02_01,
				z.anggaran_5_01_01,
				z.reali_5_01_01,
				z.anggaran_4_06_01,
				z.reali_4_06_01,
				z.anggaran_4_08_01,
				z.reali_4_08_01,
				z.anggaran_4_08_02,
				z.reali_4_08_02,
				z.anggaran_4_08_03,
				z.reali_4_08_03,
				z.anggaran_4_08_04,
				z.reali_4_08_04,
				z.anggaran_4_08_05,
				z.reali_4_08_05,
				z.anggaran_4_08_06,
				z.reali_4_08_06 from (
                SELECT left(a.kd_rek5,1) as kode,b.nm_rek1 as nama,sum(a.nilai_angg) as anggaran,sum(a.nilai_real) as reali,
				sum(nilai_ang_1_01_01) as anggaran_1_01_01,
				sum(nilai_real_1_01_01) as reali_1_01_01,
				sum(nilai_ang_1_02_01) as anggaran_1_02_01,
				sum(nilai_real_1_02_01) as reali_1_02_01,
				sum(nilai_ang_1_03_01) as anggaran_1_03_01,
				sum(nilai_real_1_03_01) as reali_1_03_01,
				sum(nilai_ang_1_04_01) as anggaran_1_04_01,
				sum(nilai_real_1_04_01) as reali_1_04_01,
				sum(nilai_ang_1_05_01) as anggaran_1_05_01,
				sum(nilai_real_1_05_01) as reali_1_05_01,
				sum(nilai_ang_1_05_02) as anggaran_1_05_02,
				sum(nilai_real_1_05_02) as reali_1_05_02,
				sum(nilai_ang_1_05_03) as anggaran_1_05_03,
				sum(nilai_real_1_05_03) as reali_1_05_03,
				sum(nilai_ang_1_06_01) as anggaran_1_06_01,
				sum(nilai_real_1_06_01) as reali_1_06_01,
				sum(nilai_ang_2_02_01) as anggaran_2_02_01,
				sum(nilai_real_2_02_01) as reali_2_02_01,
				sum(nilai_ang_2_03_01) as anggaran_2_03_01,
				sum(nilai_real_2_03_01) as reali_2_03_01,
				sum(nilai_ang_2_05_01) as anggaran_2_05_01,
				sum(nilai_real_2_05_01) as reali_2_05_01,
				sum(nilai_ang_2_06_01) as anggaran_2_06_01,
				sum(nilai_real_2_06_01) as reali_2_06_01,
				sum(nilai_ang_2_09_01) as anggaran_2_09_01,
				sum(nilai_real_2_09_01) as reali_2_09_01,
				sum(nilai_ang_2_10_01) as anggaran_2_10_01,
				sum(nilai_real_2_10_01) as reali_2_10_01,
				sum(nilai_ang_2_11_01) as anggaran_2_11_01,
				sum(nilai_real_2_11_01) as reali_2_11_01,
				sum(nilai_ang_2_12_01) as anggaran_2_12_01,
				sum(nilai_real_2_12_01) as reali_2_12_01,
				sum(nilai_ang_2_13_01) as anggaran_2_13_01,
				sum(nilai_real_2_13_01) as reali_2_13_01,
				sum(nilai_ang_2_17_01) as anggaran_2_17_01,
				sum(nilai_real_2_17_01) as reali_2_17_01,
				sum(nilai_ang_4_01_01) as anggaran_4_01_01,
				sum(nilai_real_4_01_01) as reali_4_01_01,
				sum(nilai_ang_4_02_01) as anggaran_4_02_01,
				sum(nilai_real_4_02_01) as reali_4_02_01,
				sum(nilai_ang_4_02_02) as anggaran_4_02_02,
				sum(nilai_real_4_02_02) as reali_4_02_02,
				sum(nilai_ang_4_03_01) as anggaran_4_03_01,
				sum(nilai_real_4_03_01) as reali_4_03_01,
				sum(nilai_ang_4_05_01) as anggaran_4_05_01,
				sum(nilai_real_4_05_01) as reali_4_05_01,
				sum(nilai_ang_5_02_01) as anggaran_5_02_01,
				sum(nilai_real_5_02_01) as reali_5_02_01,
				sum(nilai_ang_5_01_01) as anggaran_5_01_01,
				sum(nilai_real_5_01_01) as reali_5_01_01,
				sum(nilai_ang_4_06_01) as anggaran_4_06_01,
				sum(nilai_real_4_06_01) as reali_4_06_01,
				sum(nilai_ang_4_08_01) as anggaran_4_08_01,
				sum(nilai_real_4_08_01) as reali_4_08_01,
				sum(nilai_ang_4_08_02) as anggaran_4_08_02,
				sum(nilai_real_4_08_02) as reali_4_08_02,
				sum(nilai_ang_4_08_03) as anggaran_4_08_03,
				sum(nilai_real_4_08_03) as reali_4_08_03,
				sum(nilai_ang_4_08_04) as anggaran_4_08_04,
				sum(nilai_real_4_08_04) as reali_4_08_04,
				sum(nilai_ang_4_08_05) as anggaran_4_08_05,
				sum(nilai_real_4_08_05) as reali_4_08_05,
				sum(nilai_ang_4_08_06) as anggaran_4_08_06,
				sum(nilai_real_4_08_06) as reali_4_08_06 FROM realisasi_rekap_opd( $bulan,$anggaran,$lntahunang) a  
                inner join ms_rek1_64 b on b.kd_rek1 = left(a.kd_rek5,1)                
                where left(a.kd_rek5,1)='4' 
                group by left(a.kd_rek5,1),b.nm_rek1               
                )z order by kode,nama
                ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil4    = $row4->reali;
					$angnil4 = $row4->anggaran;
					$angnil4_1_01_01  =  $row4->anggaran_1_01_01;
					$nil4_1_01_01   =  $row4->reali_1_01_01;
					$angnil4_1_02_01  =  $row4->anggaran_1_02_01;
					$nil4_1_02_01   =  $row4->reali_1_02_01;
					$angnil4_1_03_01  =  $row4->anggaran_1_03_01;
					$nil4_1_03_01   =  $row4->reali_1_03_01;
					$angnil4_1_04_01  =  $row4->anggaran_1_04_01;
					$nil4_1_04_01   =  $row4->reali_1_04_01;
					$angnil4_1_05_01  =  $row4->anggaran_1_05_01;
					$nil4_1_05_01   =  $row4->reali_1_05_01;
					$angnil4_1_05_02  =  $row4->anggaran_1_05_02;
					$nil4_1_05_02   =  $row4->reali_1_05_02;
					$angnil4_1_05_03  =  $row4->anggaran_1_05_03;
					$nil4_1_05_03   =  $row4->reali_1_05_03;
					$angnil4_1_06_01  =  $row4->anggaran_1_06_01;
					$nil4_1_06_01   =  $row4->reali_1_06_01;
					$angnil4_2_02_01  =  $row4->anggaran_2_02_01;
					$nil4_2_02_01   =  $row4->reali_2_02_01;
					$angnil4_2_03_01  =  $row4->anggaran_2_03_01;
					$nil4_2_03_01   =  $row4->reali_2_03_01;
					$angnil4_2_05_01  =  $row4->anggaran_2_05_01;
					$nil4_2_05_01   =  $row4->reali_2_05_01;
					$angnil4_2_06_01  =  $row4->anggaran_2_06_01;
					$nil4_2_06_01   =  $row4->reali_2_06_01;
					$angnil4_2_09_01  =  $row4->anggaran_2_09_01;
					$nil4_2_09_01   =  $row4->reali_2_09_01;
					$angnil4_2_10_01  =  $row4->anggaran_2_10_01;
					$nil4_2_10_01   =  $row4->reali_2_10_01;
					$angnil4_2_11_01  =  $row4->anggaran_2_11_01;
					$nil4_2_11_01   =  $row4->reali_2_11_01;
					$angnil4_2_12_01  =  $row4->anggaran_2_12_01;
					$nil4_2_12_01   =  $row4->reali_2_12_01;
					$angnil4_2_13_01  =  $row4->anggaran_2_13_01;
					$nil4_2_13_01   =  $row4->reali_2_13_01;
					$angnil4_2_17_01  =  $row4->anggaran_2_17_01;
					$nil4_2_17_01   =  $row4->reali_2_17_01;
					$angnil4_4_01_01  =  $row4->anggaran_4_01_01;
					$nil4_4_01_01   =  $row4->reali_4_01_01;
					$angnil4_4_02_01  =  $row4->anggaran_4_02_01;
					$nil4_4_02_01   =  $row4->reali_4_02_01;
					$angnil4_4_02_02  =  $row4->anggaran_4_02_02;
					$nil4_4_02_02   =  $row4->reali_4_02_02;
					$angnil4_4_03_01  =  $row4->anggaran_4_03_01;
					$nil4_4_03_01   =  $row4->reali_4_03_01;
					$angnil4_4_05_01  =  $row4->anggaran_4_05_01;
					$nil4_4_05_01   =  $row4->reali_4_05_01;
					$angnil4_5_02_01  =  $row4->anggaran_5_02_01;
					$nil4_5_02_01   =  $row4->reali_5_02_01;
					$angnil4_5_01_01  =  $row4->anggaran_5_01_01;
					$nil4_5_01_01   =  $row4->reali_5_01_01;
					$angnil4_4_06_01  =  $row4->anggaran_4_06_01;
					$nil4_4_06_01   =  $row4->reali_4_06_01;
					$angnil4_4_08_01  =  $row4->anggaran_4_08_01;
					$nil4_4_08_01   =  $row4->reali_4_08_01;
					$angnil4_4_08_02  =  $row4->anggaran_4_08_02;
					$nil4_4_08_02   =  $row4->reali_4_08_02;
					$angnil4_4_08_03  =  $row4->anggaran_4_08_03;
					$nil4_4_08_03   =  $row4->reali_4_08_03;
					$angnil4_4_08_04  =  $row4->anggaran_4_08_04;
					$nil4_4_08_04   =  $row4->reali_4_08_04;
					$angnil4_4_08_05  =  $row4->anggaran_4_08_05;
					$nil4_4_08_05   =  $row4->reali_4_08_05;
					$angnil4_4_08_06  =  $row4->anggaran_4_08_06;
					$nil4_4_08_06   =  $row4->reali_4_08_06;
					
					$angnilai4  =  number_format($angnil4,"2",".",",");
					$nilai4  =  number_format($nil4,"2",".",",");
					$angnilai4_1_01_01     =    number_format($angnil4_1_01_01,"2",".",",");
					$nilai4_1_01_01     =    number_format($nil4_1_01_01,"2",".",",");
					$angnilai4_1_02_01     =    number_format($angnil4_1_02_01,"2",".",",");
					$nilai4_1_02_01     =    number_format($nil4_1_02_01,"2",".",",");
					$angnilai4_1_03_01     =    number_format($angnil4_1_03_01,"2",".",",");
					$nilai4_1_03_01     =    number_format($nil4_1_03_01,"2",".",",");
					$angnilai4_1_04_01     =    number_format($angnil4_1_04_01,"2",".",",");
					$nilai4_1_04_01     =    number_format($nil4_1_04_01,"2",".",",");
					$angnilai4_1_05_01     =    number_format($angnil4_1_05_01,"2",".",",");
					$nilai4_1_05_01     =    number_format($nil4_1_05_01,"2",".",",");
					$angnilai4_1_05_02     =    number_format($angnil4_1_05_02,"2",".",",");
					$nilai4_1_05_02     =    number_format($nil4_1_05_02,"2",".",",");
					$angnilai4_1_05_03     =    number_format($angnil4_1_05_03,"2",".",",");
					$nilai4_1_05_03     =    number_format($nil4_1_05_03,"2",".",",");
					$angnilai4_1_06_01     =    number_format($angnil4_1_06_01,"2",".",",");
					$nilai4_1_06_01     =    number_format($nil4_1_06_01,"2",".",",");
					$angnilai4_2_02_01     =    number_format($angnil4_2_02_01,"2",".",",");
					$nilai4_2_02_01     =    number_format($nil4_2_02_01,"2",".",",");
					$angnilai4_2_03_01     =    number_format($angnil4_2_03_01,"2",".",",");
					$nilai4_2_03_01     =    number_format($nil4_2_03_01,"2",".",",");
					$angnilai4_2_05_01     =    number_format($angnil4_2_05_01,"2",".",",");
					$nilai4_2_05_01     =    number_format($nil4_2_05_01,"2",".",",");
					$angnilai4_2_06_01     =    number_format($angnil4_2_06_01,"2",".",",");
					$nilai4_2_06_01     =    number_format($nil4_2_06_01,"2",".",",");
					$angnilai4_2_09_01     =    number_format($angnil4_2_09_01,"2",".",",");
					$nilai4_2_09_01     =    number_format($nil4_2_09_01,"2",".",",");
					$angnilai4_2_10_01     =    number_format($angnil4_2_10_01,"2",".",",");
					$nilai4_2_10_01     =    number_format($nil4_2_10_01,"2",".",",");
					$angnilai4_2_11_01     =    number_format($angnil4_2_11_01,"2",".",",");
					$nilai4_2_11_01     =    number_format($nil4_2_11_01,"2",".",",");
					$angnilai4_2_12_01     =    number_format($angnil4_2_12_01,"2",".",",");
					$nilai4_2_12_01     =    number_format($nil4_2_12_01,"2",".",",");
					$angnilai4_2_13_01     =    number_format($angnil4_2_13_01,"2",".",",");
					$nilai4_2_13_01     =    number_format($nil4_2_13_01,"2",".",",");
					$angnilai4_2_17_01     =    number_format($angnil4_2_17_01,"2",".",",");
					$nilai4_2_17_01     =    number_format($nil4_2_17_01,"2",".",",");
					$angnilai4_4_01_01     =    number_format($angnil4_4_01_01,"2",".",",");
					$nilai4_4_01_01     =    number_format($nil4_4_01_01,"2",".",",");
					$angnilai4_4_02_01     =    number_format($angnil4_4_02_01,"2",".",",");
					$nilai4_4_02_01     =    number_format($nil4_4_02_01,"2",".",",");
					$angnilai4_4_02_02     =    number_format($angnil4_4_02_02,"2",".",",");
					$nilai4_4_02_02     =    number_format($nil4_4_02_02,"2",".",",");
					$angnilai4_4_03_01     =    number_format($angnil4_4_03_01,"2",".",",");
					$nilai4_4_03_01     =    number_format($nil4_4_03_01,"2",".",",");
					$angnilai4_4_05_01     =    number_format($angnil4_4_05_01,"2",".",",");
					$nilai4_4_05_01     =    number_format($nil4_4_05_01,"2",".",",");
					$angnilai4_5_02_01     =    number_format($angnil4_5_02_01,"2",".",",");
					$nilai4_5_02_01     =    number_format($nil4_5_02_01,"2",".",",");
					$angnilai4_5_01_01     =    number_format($angnil4_5_01_01,"2",".",",");
					$nilai4_5_01_01     =    number_format($nil4_5_01_01,"2",".",",");
					$angnilai4_4_06_01     =    number_format($angnil4_4_06_01,"2",".",",");
					$nilai4_4_06_01     =    number_format($nil4_4_06_01,"2",".",",");
					$angnilai4_4_08_01     =    number_format($angnil4_4_08_01,"2",".",",");
					$nilai4_4_08_01     =    number_format($nil4_4_08_01,"2",".",",");
					$angnilai4_4_08_02     =    number_format($angnil4_4_08_02,"2",".",",");
					$nilai4_4_08_02     =    number_format($nil4_4_08_02,"2",".",",");
					$angnilai4_4_08_03     =    number_format($angnil4_4_08_03,"2",".",",");
					$nilai4_4_08_03     =    number_format($nil4_4_08_03,"2",".",",");
					$angnilai4_4_08_04     =    number_format($angnil4_4_08_04,"2",".",",");
					$nilai4_4_08_04     =    number_format($nil4_4_08_04,"2",".",",");
					$angnilai4_4_08_05     =    number_format($angnil4_4_08_05,"2",".",",");
					$nilai4_4_08_05     =    number_format($nil4_4_08_05,"2",".",",");
					$angnilai4_4_08_06     =    number_format($angnil4_4_08_06,"2",".",",");
					$nilai4_4_08_06     =    number_format($nil4_4_08_06,"2",".",",");

					
                    
               $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>JUMLAH $nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai4<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai4<b></td>
									 <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai4_1_01_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai4_1_01_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai4_1_02_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai4_1_02_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai4_1_03_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai4_1_03_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai4_1_04_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai4_1_04_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai4_1_05_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai4_1_05_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai4_1_05_02<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai4_1_05_02<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai4_1_05_03<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai4_1_05_03<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai4_1_06_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai4_1_06_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai4_2_02_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai4_2_02_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai4_2_03_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai4_2_03_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai4_2_05_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai4_2_05_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai4_2_06_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai4_2_06_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai4_2_09_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai4_2_09_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai4_2_10_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai4_2_10_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai4_2_11_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai4_2_11_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai4_2_12_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai4_2_12_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai4_2_13_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai4_2_13_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai4_2_17_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai4_2_17_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai4_4_01_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai4_4_01_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai4_4_02_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai4_4_02_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai4_4_02_02<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai4_4_02_02<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai4_4_03_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai4_4_03_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai4_4_05_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai4_4_05_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai4_5_02_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai4_5_02_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai4_5_01_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai4_5_01_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai4_4_06_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai4_4_06_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai4_4_08_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai4_4_08_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai4_4_08_02<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai4_4_08_02<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai4_4_08_03<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai4_4_08_03<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai4_4_08_04<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai4_4_08_04<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai4_4_08_05<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai4_4_08_05<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai4_4_08_06<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai4_4_08_06<b></td>
                                 </tr>";
                   }   
                   
                   $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                 </tr>";
                      
                   	$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>5<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>BELANJA<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                 </tr>";	                   	
               
                                  $sql4="
                select z.kode,z.nama,z.anggaran,z.reali,z.anggaran_1_01_01,
				z.reali_1_01_01,
				z.anggaran_1_02_01,
				z.reali_1_02_01,
				z.anggaran_1_03_01,
				z.reali_1_03_01,
				z.anggaran_1_04_01,
				z.reali_1_04_01,
				z.anggaran_1_05_01,
				z.reali_1_05_01,
				z.anggaran_1_05_02,
				z.reali_1_05_02,
				z.anggaran_1_05_03,
				z.reali_1_05_03,
				z.anggaran_1_06_01,
				z.reali_1_06_01,
				z.anggaran_2_02_01,
				z.reali_2_02_01,
				z.anggaran_2_03_01,
				z.reali_2_03_01,
				z.anggaran_2_05_01,
				z.reali_2_05_01,
				z.anggaran_2_06_01,
				z.reali_2_06_01,
				z.anggaran_2_09_01,
				z.reali_2_09_01,
				z.anggaran_2_10_01,
				z.reali_2_10_01,
				z.anggaran_2_11_01,
				z.reali_2_11_01,
				z.anggaran_2_12_01,
				z.reali_2_12_01,
				z.anggaran_2_13_01,
				z.reali_2_13_01,
				z.anggaran_2_17_01,
				z.reali_2_17_01,
				z.anggaran_4_01_01,
				z.reali_4_01_01,
				z.anggaran_4_02_01,
				z.reali_4_02_01,
				z.anggaran_4_02_02,
				z.reali_4_02_02,
				z.anggaran_4_03_01,
				z.reali_4_03_01,
				z.anggaran_4_05_01,
				z.reali_4_05_01,
				z.anggaran_5_02_01,
				z.reali_5_02_01,
				z.anggaran_5_01_01,
				z.reali_5_01_01,
				z.anggaran_4_06_01,
				z.reali_4_06_01,
				z.anggaran_4_08_01,
				z.reali_4_08_01,
				z.anggaran_4_08_02,
				z.reali_4_08_02,
				z.anggaran_4_08_03,
				z.reali_4_08_03,
				z.anggaran_4_08_04,
				z.reali_4_08_04,
				z.anggaran_4_08_05,
				z.reali_4_08_05,
				z.anggaran_4_08_06,
				z.reali_4_08_06 from (
                SELECT left(a.kd_rek5,2) as kode,b.nm_rek2 as nama,sum(a.nilai_angg) as anggaran,sum(a.nilai_real) as reali,
				sum(nilai_ang_1_01_01) as anggaran_1_01_01,
				sum(nilai_real_1_01_01) as reali_1_01_01,
				sum(nilai_ang_1_02_01) as anggaran_1_02_01,
				sum(nilai_real_1_02_01) as reali_1_02_01,
				sum(nilai_ang_1_03_01) as anggaran_1_03_01,
				sum(nilai_real_1_03_01) as reali_1_03_01,
				sum(nilai_ang_1_04_01) as anggaran_1_04_01,
				sum(nilai_real_1_04_01) as reali_1_04_01,
				sum(nilai_ang_1_05_01) as anggaran_1_05_01,
				sum(nilai_real_1_05_01) as reali_1_05_01,
				sum(nilai_ang_1_05_02) as anggaran_1_05_02,
				sum(nilai_real_1_05_02) as reali_1_05_02,
				sum(nilai_ang_1_05_03) as anggaran_1_05_03,
				sum(nilai_real_1_05_03) as reali_1_05_03,
				sum(nilai_ang_1_06_01) as anggaran_1_06_01,
				sum(nilai_real_1_06_01) as reali_1_06_01,
				sum(nilai_ang_2_02_01) as anggaran_2_02_01,
				sum(nilai_real_2_02_01) as reali_2_02_01,
				sum(nilai_ang_2_03_01) as anggaran_2_03_01,
				sum(nilai_real_2_03_01) as reali_2_03_01,
				sum(nilai_ang_2_05_01) as anggaran_2_05_01,
				sum(nilai_real_2_05_01) as reali_2_05_01,
				sum(nilai_ang_2_06_01) as anggaran_2_06_01,
				sum(nilai_real_2_06_01) as reali_2_06_01,
				sum(nilai_ang_2_09_01) as anggaran_2_09_01,
				sum(nilai_real_2_09_01) as reali_2_09_01,
				sum(nilai_ang_2_10_01) as anggaran_2_10_01,
				sum(nilai_real_2_10_01) as reali_2_10_01,
				sum(nilai_ang_2_11_01) as anggaran_2_11_01,
				sum(nilai_real_2_11_01) as reali_2_11_01,
				sum(nilai_ang_2_12_01) as anggaran_2_12_01,
				sum(nilai_real_2_12_01) as reali_2_12_01,
				sum(nilai_ang_2_13_01) as anggaran_2_13_01,
				sum(nilai_real_2_13_01) as reali_2_13_01,
				sum(nilai_ang_2_17_01) as anggaran_2_17_01,
				sum(nilai_real_2_17_01) as reali_2_17_01,
				sum(nilai_ang_4_01_01) as anggaran_4_01_01,
				sum(nilai_real_4_01_01) as reali_4_01_01,
				sum(nilai_ang_4_02_01) as anggaran_4_02_01,
				sum(nilai_real_4_02_01) as reali_4_02_01,
				sum(nilai_ang_4_02_02) as anggaran_4_02_02,
				sum(nilai_real_4_02_02) as reali_4_02_02,
				sum(nilai_ang_4_03_01) as anggaran_4_03_01,
				sum(nilai_real_4_03_01) as reali_4_03_01,
				sum(nilai_ang_4_05_01) as anggaran_4_05_01,
				sum(nilai_real_4_05_01) as reali_4_05_01,
				sum(nilai_ang_5_02_01) as anggaran_5_02_01,
				sum(nilai_real_5_02_01) as reali_5_02_01,
				sum(nilai_ang_5_01_01) as anggaran_5_01_01,
				sum(nilai_real_5_01_01) as reali_5_01_01,
				sum(nilai_ang_4_06_01) as anggaran_4_06_01,
				sum(nilai_real_4_06_01) as reali_4_06_01,
				sum(nilai_ang_4_08_01) as anggaran_4_08_01,
				sum(nilai_real_4_08_01) as reali_4_08_01,
				sum(nilai_ang_4_08_02) as anggaran_4_08_02,
				sum(nilai_real_4_08_02) as reali_4_08_02,
				sum(nilai_ang_4_08_03) as anggaran_4_08_03,
				sum(nilai_real_4_08_03) as reali_4_08_03,
				sum(nilai_ang_4_08_04) as anggaran_4_08_04,
				sum(nilai_real_4_08_04) as reali_4_08_04,
				sum(nilai_ang_4_08_05) as anggaran_4_08_05,
				sum(nilai_real_4_08_05) as reali_4_08_05,
				sum(nilai_ang_4_08_06) as anggaran_4_08_06,
				sum(nilai_real_4_08_06) as reali_4_08_06 FROM realisasi_rekap_opd( $bulan,$anggaran,$lntahunang) a
                inner join ms_rek2_64 b on b.kd_rek2 = left(a.kd_rek5,2)                
                where left(a.kd_rek5,1)='5' 
                group by left(a.kd_rek5,2),b.nm_rek2
                union all
                SELECT left(a.kd_rek5,3) as kode,b.nm_rek3 as nama,sum(a.nilai_angg) as anggaran,sum(a.nilai_real) as reali,
				sum(nilai_ang_1_01_01) as anggaran_1_01_01,
				sum(nilai_real_1_01_01) as reali_1_01_01,
				sum(nilai_ang_1_02_01) as anggaran_1_02_01,
				sum(nilai_real_1_02_01) as reali_1_02_01,
				sum(nilai_ang_1_03_01) as anggaran_1_03_01,
				sum(nilai_real_1_03_01) as reali_1_03_01,
				sum(nilai_ang_1_04_01) as anggaran_1_04_01,
				sum(nilai_real_1_04_01) as reali_1_04_01,
				sum(nilai_ang_1_05_01) as anggaran_1_05_01,
				sum(nilai_real_1_05_01) as reali_1_05_01,
				sum(nilai_ang_1_05_02) as anggaran_1_05_02,
				sum(nilai_real_1_05_02) as reali_1_05_02,
				sum(nilai_ang_1_05_03) as anggaran_1_05_03,
				sum(nilai_real_1_05_03) as reali_1_05_03,
				sum(nilai_ang_1_06_01) as anggaran_1_06_01,
				sum(nilai_real_1_06_01) as reali_1_06_01,
				sum(nilai_ang_2_02_01) as anggaran_2_02_01,
				sum(nilai_real_2_02_01) as reali_2_02_01,
				sum(nilai_ang_2_03_01) as anggaran_2_03_01,
				sum(nilai_real_2_03_01) as reali_2_03_01,
				sum(nilai_ang_2_05_01) as anggaran_2_05_01,
				sum(nilai_real_2_05_01) as reali_2_05_01,
				sum(nilai_ang_2_06_01) as anggaran_2_06_01,
				sum(nilai_real_2_06_01) as reali_2_06_01,
				sum(nilai_ang_2_09_01) as anggaran_2_09_01,
				sum(nilai_real_2_09_01) as reali_2_09_01,
				sum(nilai_ang_2_10_01) as anggaran_2_10_01,
				sum(nilai_real_2_10_01) as reali_2_10_01,
				sum(nilai_ang_2_11_01) as anggaran_2_11_01,
				sum(nilai_real_2_11_01) as reali_2_11_01,
				sum(nilai_ang_2_12_01) as anggaran_2_12_01,
				sum(nilai_real_2_12_01) as reali_2_12_01,
				sum(nilai_ang_2_13_01) as anggaran_2_13_01,
				sum(nilai_real_2_13_01) as reali_2_13_01,
				sum(nilai_ang_2_17_01) as anggaran_2_17_01,
				sum(nilai_real_2_17_01) as reali_2_17_01,
				sum(nilai_ang_4_01_01) as anggaran_4_01_01,
				sum(nilai_real_4_01_01) as reali_4_01_01,
				sum(nilai_ang_4_02_01) as anggaran_4_02_01,
				sum(nilai_real_4_02_01) as reali_4_02_01,
				sum(nilai_ang_4_02_02) as anggaran_4_02_02,
				sum(nilai_real_4_02_02) as reali_4_02_02,
				sum(nilai_ang_4_03_01) as anggaran_4_03_01,
				sum(nilai_real_4_03_01) as reali_4_03_01,
				sum(nilai_ang_4_05_01) as anggaran_4_05_01,
				sum(nilai_real_4_05_01) as reali_4_05_01,
				sum(nilai_ang_5_02_01) as anggaran_5_02_01,
				sum(nilai_real_5_02_01) as reali_5_02_01,
				sum(nilai_ang_5_01_01) as anggaran_5_01_01,
				sum(nilai_real_5_01_01) as reali_5_01_01,
				sum(nilai_ang_4_06_01) as anggaran_4_06_01,
				sum(nilai_real_4_06_01) as reali_4_06_01,
				sum(nilai_ang_4_08_01) as anggaran_4_08_01,
				sum(nilai_real_4_08_01) as reali_4_08_01,
				sum(nilai_ang_4_08_02) as anggaran_4_08_02,
				sum(nilai_real_4_08_02) as reali_4_08_02,
				sum(nilai_ang_4_08_03) as anggaran_4_08_03,
				sum(nilai_real_4_08_03) as reali_4_08_03,
				sum(nilai_ang_4_08_04) as anggaran_4_08_04,
				sum(nilai_real_4_08_04) as reali_4_08_04,
				sum(nilai_ang_4_08_05) as anggaran_4_08_05,
				sum(nilai_real_4_08_05) as reali_4_08_05,
				sum(nilai_ang_4_08_06) as anggaran_4_08_06,
				sum(nilai_real_4_08_06) as reali_4_08_06 FROM realisasi_rekap_opd( $bulan,$anggaran,$lntahunang) a
                inner join ms_rek3_64 b on b.kd_rek3 = left(a.kd_rek5,3)                
                where left(a.kd_rek5,1)='5' 
                group by left(a.kd_rek5,3),b.nm_rek3
                union all
                SELECT left(a.kd_rek5,5) as kode,b.nm_rek4_64 as nama,sum(a.nilai_angg) as anggaran,sum(a.nilai_real) as reali,
				sum(nilai_ang_1_01_01) as anggaran_1_01_01,
				sum(nilai_real_1_01_01) as reali_1_01_01,
				sum(nilai_ang_1_02_01) as anggaran_1_02_01,
				sum(nilai_real_1_02_01) as reali_1_02_01,
				sum(nilai_ang_1_03_01) as anggaran_1_03_01,
				sum(nilai_real_1_03_01) as reali_1_03_01,
				sum(nilai_ang_1_04_01) as anggaran_1_04_01,
				sum(nilai_real_1_04_01) as reali_1_04_01,
				sum(nilai_ang_1_05_01) as anggaran_1_05_01,
				sum(nilai_real_1_05_01) as reali_1_05_01,
				sum(nilai_ang_1_05_02) as anggaran_1_05_02,
				sum(nilai_real_1_05_02) as reali_1_05_02,
				sum(nilai_ang_1_05_03) as anggaran_1_05_03,
				sum(nilai_real_1_05_03) as reali_1_05_03,
				sum(nilai_ang_1_06_01) as anggaran_1_06_01,
				sum(nilai_real_1_06_01) as reali_1_06_01,
				sum(nilai_ang_2_02_01) as anggaran_2_02_01,
				sum(nilai_real_2_02_01) as reali_2_02_01,
				sum(nilai_ang_2_03_01) as anggaran_2_03_01,
				sum(nilai_real_2_03_01) as reali_2_03_01,
				sum(nilai_ang_2_05_01) as anggaran_2_05_01,
				sum(nilai_real_2_05_01) as reali_2_05_01,
				sum(nilai_ang_2_06_01) as anggaran_2_06_01,
				sum(nilai_real_2_06_01) as reali_2_06_01,
				sum(nilai_ang_2_09_01) as anggaran_2_09_01,
				sum(nilai_real_2_09_01) as reali_2_09_01,
				sum(nilai_ang_2_10_01) as anggaran_2_10_01,
				sum(nilai_real_2_10_01) as reali_2_10_01,
				sum(nilai_ang_2_11_01) as anggaran_2_11_01,
				sum(nilai_real_2_11_01) as reali_2_11_01,
				sum(nilai_ang_2_12_01) as anggaran_2_12_01,
				sum(nilai_real_2_12_01) as reali_2_12_01,
				sum(nilai_ang_2_13_01) as anggaran_2_13_01,
				sum(nilai_real_2_13_01) as reali_2_13_01,
				sum(nilai_ang_2_17_01) as anggaran_2_17_01,
				sum(nilai_real_2_17_01) as reali_2_17_01,
				sum(nilai_ang_4_01_01) as anggaran_4_01_01,
				sum(nilai_real_4_01_01) as reali_4_01_01,
				sum(nilai_ang_4_02_01) as anggaran_4_02_01,
				sum(nilai_real_4_02_01) as reali_4_02_01,
				sum(nilai_ang_4_02_02) as anggaran_4_02_02,
				sum(nilai_real_4_02_02) as reali_4_02_02,
				sum(nilai_ang_4_03_01) as anggaran_4_03_01,
				sum(nilai_real_4_03_01) as reali_4_03_01,
				sum(nilai_ang_4_05_01) as anggaran_4_05_01,
				sum(nilai_real_4_05_01) as reali_4_05_01,
				sum(nilai_ang_5_02_01) as anggaran_5_02_01,
				sum(nilai_real_5_02_01) as reali_5_02_01,
				sum(nilai_ang_5_01_01) as anggaran_5_01_01,
				sum(nilai_real_5_01_01) as reali_5_01_01,
				sum(nilai_ang_4_06_01) as anggaran_4_06_01,
				sum(nilai_real_4_06_01) as reali_4_06_01,
				sum(nilai_ang_4_08_01) as anggaran_4_08_01,
				sum(nilai_real_4_08_01) as reali_4_08_01,
				sum(nilai_ang_4_08_02) as anggaran_4_08_02,
				sum(nilai_real_4_08_02) as reali_4_08_02,
				sum(nilai_ang_4_08_03) as anggaran_4_08_03,
				sum(nilai_real_4_08_03) as reali_4_08_03,
				sum(nilai_ang_4_08_04) as anggaran_4_08_04,
				sum(nilai_real_4_08_04) as reali_4_08_04,
				sum(nilai_ang_4_08_05) as anggaran_4_08_05,
				sum(nilai_real_4_08_05) as reali_4_08_05,
				sum(nilai_ang_4_08_06) as anggaran_4_08_06,
				sum(nilai_real_4_08_06) as reali_4_08_06 FROM realisasi_rekap_opd( $bulan,$anggaran,$lntahunang) a
                inner join ms_rek4_64 b on b.kd_rek4_64 = left(a.kd_rek5,5)                
                where left(a.kd_rek5,1)='5' 
                group by left(a.kd_rek5,5),b.nm_rek4_64
                union all
                SELECT a.kd_rek5 as kode,b.nm_rek64 as nama,sum(a.nilai_angg) as anggaran,sum(a.nilai_real) as reali,
				sum(nilai_ang_1_01_01) as anggaran_1_01_01,
				sum(nilai_real_1_01_01) as reali_1_01_01,
				sum(nilai_ang_1_02_01) as anggaran_1_02_01,
				sum(nilai_real_1_02_01) as reali_1_02_01,
				sum(nilai_ang_1_03_01) as anggaran_1_03_01,
				sum(nilai_real_1_03_01) as reali_1_03_01,
				sum(nilai_ang_1_04_01) as anggaran_1_04_01,
				sum(nilai_real_1_04_01) as reali_1_04_01,
				sum(nilai_ang_1_05_01) as anggaran_1_05_01,
				sum(nilai_real_1_05_01) as reali_1_05_01,
				sum(nilai_ang_1_05_02) as anggaran_1_05_02,
				sum(nilai_real_1_05_02) as reali_1_05_02,
				sum(nilai_ang_1_05_03) as anggaran_1_05_03,
				sum(nilai_real_1_05_03) as reali_1_05_03,
				sum(nilai_ang_1_06_01) as anggaran_1_06_01,
				sum(nilai_real_1_06_01) as reali_1_06_01,
				sum(nilai_ang_2_02_01) as anggaran_2_02_01,
				sum(nilai_real_2_02_01) as reali_2_02_01,
				sum(nilai_ang_2_03_01) as anggaran_2_03_01,
				sum(nilai_real_2_03_01) as reali_2_03_01,
				sum(nilai_ang_2_05_01) as anggaran_2_05_01,
				sum(nilai_real_2_05_01) as reali_2_05_01,
				sum(nilai_ang_2_06_01) as anggaran_2_06_01,
				sum(nilai_real_2_06_01) as reali_2_06_01,
				sum(nilai_ang_2_09_01) as anggaran_2_09_01,
				sum(nilai_real_2_09_01) as reali_2_09_01,
				sum(nilai_ang_2_10_01) as anggaran_2_10_01,
				sum(nilai_real_2_10_01) as reali_2_10_01,
				sum(nilai_ang_2_11_01) as anggaran_2_11_01,
				sum(nilai_real_2_11_01) as reali_2_11_01,
				sum(nilai_ang_2_12_01) as anggaran_2_12_01,
				sum(nilai_real_2_12_01) as reali_2_12_01,
				sum(nilai_ang_2_13_01) as anggaran_2_13_01,
				sum(nilai_real_2_13_01) as reali_2_13_01,
				sum(nilai_ang_2_17_01) as anggaran_2_17_01,
				sum(nilai_real_2_17_01) as reali_2_17_01,
				sum(nilai_ang_4_01_01) as anggaran_4_01_01,
				sum(nilai_real_4_01_01) as reali_4_01_01,
				sum(nilai_ang_4_02_01) as anggaran_4_02_01,
				sum(nilai_real_4_02_01) as reali_4_02_01,
				sum(nilai_ang_4_02_02) as anggaran_4_02_02,
				sum(nilai_real_4_02_02) as reali_4_02_02,
				sum(nilai_ang_4_03_01) as anggaran_4_03_01,
				sum(nilai_real_4_03_01) as reali_4_03_01,
				sum(nilai_ang_4_05_01) as anggaran_4_05_01,
				sum(nilai_real_4_05_01) as reali_4_05_01,
				sum(nilai_ang_5_02_01) as anggaran_5_02_01,
				sum(nilai_real_5_02_01) as reali_5_02_01,
				sum(nilai_ang_5_01_01) as anggaran_5_01_01,
				sum(nilai_real_5_01_01) as reali_5_01_01,
				sum(nilai_ang_4_06_01) as anggaran_4_06_01,
				sum(nilai_real_4_06_01) as reali_4_06_01,
				sum(nilai_ang_4_08_01) as anggaran_4_08_01,
				sum(nilai_real_4_08_01) as reali_4_08_01,
				sum(nilai_ang_4_08_02) as anggaran_4_08_02,
				sum(nilai_real_4_08_02) as reali_4_08_02,
				sum(nilai_ang_4_08_03) as anggaran_4_08_03,
				sum(nilai_real_4_08_03) as reali_4_08_03,
				sum(nilai_ang_4_08_04) as anggaran_4_08_04,
				sum(nilai_real_4_08_04) as reali_4_08_04,
				sum(nilai_ang_4_08_05) as anggaran_4_08_05,
				sum(nilai_real_4_08_05) as reali_4_08_05,
				sum(nilai_ang_4_08_06) as anggaran_4_08_06,
				sum(nilai_real_4_08_06) as reali_4_08_06 FROM realisasi_rekap_opd( $bulan,$anggaran,$lntahunang) a  
                inner join ms_rek5 b on b.kd_rek64 = a.kd_rek5                       
                where left(a.kd_rek5,1)='5' 
                group by a.kd_rek5,b.nm_rek64
                )z order by kode,nama
                ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil    = $row4->reali;
					$angnil = $row4->anggaran;
					$angnil_1_01_01  = $row4->anggaran_1_01_01;
					$nil_1_01_01  = $row4->reali_1_01_01;
					$angnil_1_02_01  = $row4->anggaran_1_02_01;
					$nil_1_02_01  = $row4->reali_1_02_01;
					$angnil_1_03_01  = $row4->anggaran_1_03_01;
					$nil_1_03_01  = $row4->reali_1_03_01;
					$angnil_1_04_01  = $row4->anggaran_1_04_01;
					$nil_1_04_01  = $row4->reali_1_04_01;
					$angnil_1_05_01  = $row4->anggaran_1_05_01;
					$nil_1_05_01  = $row4->reali_1_05_01;
					$angnil_1_05_02  = $row4->anggaran_1_05_02;
					$nil_1_05_02  = $row4->reali_1_05_02;
					$angnil_1_05_03  = $row4->anggaran_1_05_03;
					$nil_1_05_03  = $row4->reali_1_05_03;
					$angnil_1_06_01  = $row4->anggaran_1_06_01;
					$nil_1_06_01  = $row4->reali_1_06_01;
					$angnil_2_02_01  = $row4->anggaran_2_02_01;
					$nil_2_02_01  = $row4->reali_2_02_01;
					$angnil_2_03_01  = $row4->anggaran_2_03_01;
					$nil_2_03_01  = $row4->reali_2_03_01;
					$angnil_2_05_01  = $row4->anggaran_2_05_01;
					$nil_2_05_01  = $row4->reali_2_05_01;
					$angnil_2_06_01  = $row4->anggaran_2_06_01;
					$nil_2_06_01  = $row4->reali_2_06_01;
					$angnil_2_09_01  = $row4->anggaran_2_09_01;
					$nil_2_09_01  = $row4->reali_2_09_01;
					$angnil_2_10_01  = $row4->anggaran_2_10_01;
					$nil_2_10_01  = $row4->reali_2_10_01;
					$angnil_2_11_01  = $row4->anggaran_2_11_01;
					$nil_2_11_01  = $row4->reali_2_11_01;
					$angnil_2_12_01  = $row4->anggaran_2_12_01;
					$nil_2_12_01  = $row4->reali_2_12_01;
					$angnil_2_13_01  = $row4->anggaran_2_13_01;
					$nil_2_13_01  = $row4->reali_2_13_01;
					$angnil_2_17_01  = $row4->anggaran_2_17_01;
					$nil_2_17_01  = $row4->reali_2_17_01;
					$angnil_4_01_01  = $row4->anggaran_4_01_01;
					$nil_4_01_01  = $row4->reali_4_01_01;
					$angnil_4_02_01  = $row4->anggaran_4_02_01;
					$nil_4_02_01  = $row4->reali_4_02_01;
					$angnil_4_02_02  = $row4->anggaran_4_02_02;
					$nil_4_02_02  = $row4->reali_4_02_02;
					$angnil_4_03_01  = $row4->anggaran_4_03_01;
					$nil_4_03_01  = $row4->reali_4_03_01;
					$angnil_4_05_01  = $row4->anggaran_4_05_01;
					$nil_4_05_01  = $row4->reali_4_05_01;
					$angnil_5_02_01  = $row4->anggaran_5_02_01;
					$nil_5_02_01  = $row4->reali_5_02_01;
					$angnil_5_01_01  = $row4->anggaran_5_01_01;
					$nil_5_01_01  = $row4->reali_5_01_01;
					$angnil_4_06_01  = $row4->anggaran_4_06_01;
					$nil_4_06_01  = $row4->reali_4_06_01;
					$angnil_4_08_01  = $row4->anggaran_4_08_01;
					$nil_4_08_01  = $row4->reali_4_08_01;
					$angnil_4_08_02  = $row4->anggaran_4_08_02;
					$nil_4_08_02  = $row4->reali_4_08_02;
					$angnil_4_08_03  = $row4->anggaran_4_08_03;
					$nil_4_08_03  = $row4->reali_4_08_03;
					$angnil_4_08_04  = $row4->anggaran_4_08_04;
					$nil_4_08_04  = $row4->reali_4_08_04;
					$angnil_4_08_05  = $row4->anggaran_4_08_05;
					$nil_4_08_05  = $row4->reali_4_08_05;
					$angnil_4_08_06  = $row4->anggaran_4_08_06;
					$nil_4_08_06  = $row4->reali_4_08_06;
					
					
					$angnilai  =  number_format($angnil,"2",".",",");
					$nilai  =  number_format($nil,"2",".",",");
					$angnil_1_01_01  =  number_format($angnil_1_01_01,"2",".",",");
					$nil_1_01_01  =  number_format($nil_1_01_01,"2",".",",");
					$angnil_1_02_01  =  number_format($angnil_1_02_01,"2",".",",");
					$nil_1_02_01  =  number_format($nil_1_02_01,"2",".",",");
					$angnil_1_03_01  =  number_format($angnil_1_03_01,"2",".",",");
					$nil_1_03_01  =  number_format($nil_1_03_01,"2",".",",");
					$angnil_1_04_01  =  number_format($angnil_1_04_01,"2",".",",");
					$nil_1_04_01  =  number_format($nil_1_04_01,"2",".",",");
					$angnil_1_05_01  =  number_format($angnil_1_05_01,"2",".",",");
					$nil_1_05_01  =  number_format($nil_1_05_01,"2",".",",");
					$angnil_1_05_02  =  number_format($angnil_1_05_02,"2",".",",");
					$nil_1_05_02  =  number_format($nil_1_05_02,"2",".",",");
					$angnil_1_05_03  =  number_format($angnil_1_05_03,"2",".",",");
					$nil_1_05_03  =  number_format($nil_1_05_03,"2",".",",");
					$angnil_1_06_01  =  number_format($angnil_1_06_01,"2",".",",");
					$nil_1_06_01  =  number_format($nil_1_06_01,"2",".",",");
					$angnil_2_02_01  =  number_format($angnil_2_02_01,"2",".",",");
					$nil_2_02_01  =  number_format($nil_2_02_01,"2",".",",");
					$angnil_2_03_01  =  number_format($angnil_2_03_01,"2",".",",");
					$nil_2_03_01  =  number_format($nil_2_03_01,"2",".",",");
					$angnil_2_05_01  =  number_format($angnil_2_05_01,"2",".",",");
					$nil_2_05_01  =  number_format($nil_2_05_01,"2",".",",");
					$angnil_2_06_01  =  number_format($angnil_2_06_01,"2",".",",");
					$nil_2_06_01  =  number_format($nil_2_06_01,"2",".",",");
					$angnil_2_09_01  =  number_format($angnil_2_09_01,"2",".",",");
					$nil_2_09_01  =  number_format($nil_2_09_01,"2",".",",");
					$angnil_2_10_01  =  number_format($angnil_2_10_01,"2",".",",");
					$nil_2_10_01  =  number_format($nil_2_10_01,"2",".",",");
					$angnil_2_11_01  =  number_format($angnil_2_11_01,"2",".",",");
					$nil_2_11_01  =  number_format($nil_2_11_01,"2",".",",");
					$angnil_2_12_01  =  number_format($angnil_2_12_01,"2",".",",");
					$nil_2_12_01  =  number_format($nil_2_12_01,"2",".",",");
					$angnil_2_13_01  =  number_format($angnil_2_13_01,"2",".",",");
					$nil_2_13_01  =  number_format($nil_2_13_01,"2",".",",");
					$angnil_2_17_01  =  number_format($angnil_2_17_01,"2",".",",");
					$nil_2_17_01  =  number_format($nil_2_17_01,"2",".",",");
					$angnil_4_01_01  =  number_format($angnil_4_01_01,"2",".",",");
					$nil_4_01_01  =  number_format($nil_4_01_01,"2",".",",");
					$angnil_4_02_01  =  number_format($angnil_4_02_01,"2",".",",");
					$nil_4_02_01  =  number_format($nil_4_02_01,"2",".",",");
					$angnil_4_02_02  =  number_format($angnil_4_02_02,"2",".",",");
					$nil_4_02_02  =  number_format($nil_4_02_02,"2",".",",");
					$angnil_4_03_01  =  number_format($angnil_4_03_01,"2",".",",");
					$nil_4_03_01  =  number_format($nil_4_03_01,"2",".",",");
					$angnil_4_05_01  =  number_format($angnil_4_05_01,"2",".",",");
					$nil_4_05_01  =  number_format($nil_4_05_01,"2",".",",");
					$angnil_5_02_01  =  number_format($angnil_5_02_01,"2",".",",");
					$nil_5_02_01  =  number_format($nil_5_02_01,"2",".",",");
					$angnil_5_01_01  =  number_format($angnil_5_01_01,"2",".",",");
					$nil_5_01_01  =  number_format($nil_5_01_01,"2",".",",");
					$angnil_4_06_01  =  number_format($angnil_4_06_01,"2",".",",");
					$nil_4_06_01  =  number_format($nil_4_06_01,"2",".",",");
					$angnil_4_08_01  =  number_format($angnil_4_08_01,"2",".",",");
					$nil_4_08_01  =  number_format($nil_4_08_01,"2",".",",");
					$angnil_4_08_02  =  number_format($angnil_4_08_02,"2",".",",");
					$nil_4_08_02  =  number_format($nil_4_08_02,"2",".",",");
					$angnil_4_08_03  =  number_format($angnil_4_08_03,"2",".",",");
					$nil_4_08_03  =  number_format($nil_4_08_03,"2",".",",");
					$angnil_4_08_04  =  number_format($angnil_4_08_04,"2",".",",");
					$nil_4_08_04  =  number_format($nil_4_08_04,"2",".",",");
					$angnil_4_08_05  =  number_format($angnil_4_08_05,"2",".",",");
					$nil_4_08_05  =  number_format($nil_4_08_05,"2",".",",");
					$angnil_4_08_06  =  number_format($angnil_4_08_06,"2",".",",");
					$nil_4_08_06  =  number_format($nil_4_08_06,"2",".",",");
					
                    
                   if(strlen("$no")<6){
                    $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai<b></td>
									 <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_1_01_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_1_01_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_1_02_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_1_02_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_1_03_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_1_03_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_1_04_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_1_04_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_1_05_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_1_05_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_1_05_02<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_1_05_02<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_1_05_03<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_1_05_03<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_1_06_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_1_06_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_2_02_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_2_02_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_2_03_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_2_03_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_2_05_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_2_05_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_2_06_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_2_06_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_2_09_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_2_09_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_2_10_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_2_10_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_2_11_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_2_11_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_2_12_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_2_12_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_2_13_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_2_13_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_2_17_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_2_17_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_4_01_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_4_01_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_4_02_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_4_02_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_4_02_02<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_4_02_02<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_4_03_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_4_03_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_4_05_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_4_05_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_5_02_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_5_02_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_5_01_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_5_01_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_4_06_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_4_06_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_4_08_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_4_08_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_4_08_02<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_4_08_02<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_4_08_03<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_4_08_03<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_4_08_04<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_4_08_04<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_4_08_05<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_4_08_05<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_4_08_06<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_4_08_06<b></td>
                                 </tr>";
                             }else
                             {
					$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">$no</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\">$nama</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nilai</td>
									 <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_1_01_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_1_01_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_1_02_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_1_02_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_1_03_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_1_03_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_1_04_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_1_04_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_1_05_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_1_05_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_1_05_02</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_1_05_02</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_1_05_03</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_1_05_03</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_1_06_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_1_06_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_2_02_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_2_02_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_2_03_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_2_03_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_2_05_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_2_05_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_2_06_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_2_06_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_2_09_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_2_09_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_2_10_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_2_10_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_2_11_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_2_11_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_2_12_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_2_12_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_2_13_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_2_13_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_2_17_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_2_17_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_4_01_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_4_01_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_4_02_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_4_02_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_4_02_02</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_4_02_02</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_4_03_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_4_03_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_4_05_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_4_05_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_5_02_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_5_02_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_5_01_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_5_01_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_4_06_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_4_06_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_4_08_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_4_08_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_4_08_02</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_4_08_02</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_4_08_03</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_4_08_03</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_4_08_04</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_4_08_04</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_4_08_05</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_4_08_05</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_4_08_06</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_4_08_06</td>
                                 </tr>";
                             }
               }
               
                		$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                 </tr>";
                 

                      
                   	$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>5<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>TRANSFER<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                 </tr>";	                   	
               
                                  $sql4="
                select z.kode,z.nama,z.anggaran,z.reali,z.anggaran_1_01_01,
				z.reali_1_01_01,
				z.anggaran_1_02_01,
				z.reali_1_02_01,
				z.anggaran_1_03_01,
				z.reali_1_03_01,
				z.anggaran_1_04_01,
				z.reali_1_04_01,
				z.anggaran_1_05_01,
				z.reali_1_05_01,
				z.anggaran_1_05_02,
				z.reali_1_05_02,
				z.anggaran_1_05_03,
				z.reali_1_05_03,
				z.anggaran_1_06_01,
				z.reali_1_06_01,
				z.anggaran_2_02_01,
				z.reali_2_02_01,
				z.anggaran_2_03_01,
				z.reali_2_03_01,
				z.anggaran_2_05_01,
				z.reali_2_05_01,
				z.anggaran_2_06_01,
				z.reali_2_06_01,
				z.anggaran_2_09_01,
				z.reali_2_09_01,
				z.anggaran_2_10_01,
				z.reali_2_10_01,
				z.anggaran_2_11_01,
				z.reali_2_11_01,
				z.anggaran_2_12_01,
				z.reali_2_12_01,
				z.anggaran_2_13_01,
				z.reali_2_13_01,
				z.anggaran_2_17_01,
				z.reali_2_17_01,
				z.anggaran_4_01_01,
				z.reali_4_01_01,
				z.anggaran_4_02_01,
				z.reali_4_02_01,
				z.anggaran_4_02_02,
				z.reali_4_02_02,
				z.anggaran_4_03_01,
				z.reali_4_03_01,
				z.anggaran_4_05_01,
				z.reali_4_05_01,
				z.anggaran_5_02_01,
				z.reali_5_02_01,
				z.anggaran_5_01_01,
				z.reali_5_01_01,
				z.anggaran_4_06_01,
				z.reali_4_06_01,
				z.anggaran_4_08_01,
				z.reali_4_08_01,
				z.anggaran_4_08_02,
				z.reali_4_08_02,
				z.anggaran_4_08_03,
				z.reali_4_08_03,
				z.anggaran_4_08_04,
				z.reali_4_08_04,
				z.anggaran_4_08_05,
				z.reali_4_08_05,
				z.anggaran_4_08_06,
				z.reali_4_08_06 from (
                SELECT left(a.kd_rek5,2) as kode,b.nm_rek2 as nama,sum(a.nilai_angg) as anggaran,sum(a.nilai_real) as reali,
				sum(nilai_ang_1_01_01) as anggaran_1_01_01,
				sum(nilai_real_1_01_01) as reali_1_01_01,
				sum(nilai_ang_1_02_01) as anggaran_1_02_01,
				sum(nilai_real_1_02_01) as reali_1_02_01,
				sum(nilai_ang_1_03_01) as anggaran_1_03_01,
				sum(nilai_real_1_03_01) as reali_1_03_01,
				sum(nilai_ang_1_04_01) as anggaran_1_04_01,
				sum(nilai_real_1_04_01) as reali_1_04_01,
				sum(nilai_ang_1_05_01) as anggaran_1_05_01,
				sum(nilai_real_1_05_01) as reali_1_05_01,
				sum(nilai_ang_1_05_02) as anggaran_1_05_02,
				sum(nilai_real_1_05_02) as reali_1_05_02,
				sum(nilai_ang_1_05_03) as anggaran_1_05_03,
				sum(nilai_real_1_05_03) as reali_1_05_03,
				sum(nilai_ang_1_06_01) as anggaran_1_06_01,
				sum(nilai_real_1_06_01) as reali_1_06_01,
				sum(nilai_ang_2_02_01) as anggaran_2_02_01,
				sum(nilai_real_2_02_01) as reali_2_02_01,
				sum(nilai_ang_2_03_01) as anggaran_2_03_01,
				sum(nilai_real_2_03_01) as reali_2_03_01,
				sum(nilai_ang_2_05_01) as anggaran_2_05_01,
				sum(nilai_real_2_05_01) as reali_2_05_01,
				sum(nilai_ang_2_06_01) as anggaran_2_06_01,
				sum(nilai_real_2_06_01) as reali_2_06_01,
				sum(nilai_ang_2_09_01) as anggaran_2_09_01,
				sum(nilai_real_2_09_01) as reali_2_09_01,
				sum(nilai_ang_2_10_01) as anggaran_2_10_01,
				sum(nilai_real_2_10_01) as reali_2_10_01,
				sum(nilai_ang_2_11_01) as anggaran_2_11_01,
				sum(nilai_real_2_11_01) as reali_2_11_01,
				sum(nilai_ang_2_12_01) as anggaran_2_12_01,
				sum(nilai_real_2_12_01) as reali_2_12_01,
				sum(nilai_ang_2_13_01) as anggaran_2_13_01,
				sum(nilai_real_2_13_01) as reali_2_13_01,
				sum(nilai_ang_2_17_01) as anggaran_2_17_01,
				sum(nilai_real_2_17_01) as reali_2_17_01,
				sum(nilai_ang_4_01_01) as anggaran_4_01_01,
				sum(nilai_real_4_01_01) as reali_4_01_01,
				sum(nilai_ang_4_02_01) as anggaran_4_02_01,
				sum(nilai_real_4_02_01) as reali_4_02_01,
				sum(nilai_ang_4_02_02) as anggaran_4_02_02,
				sum(nilai_real_4_02_02) as reali_4_02_02,
				sum(nilai_ang_4_03_01) as anggaran_4_03_01,
				sum(nilai_real_4_03_01) as reali_4_03_01,
				sum(nilai_ang_4_05_01) as anggaran_4_05_01,
				sum(nilai_real_4_05_01) as reali_4_05_01,
				sum(nilai_ang_5_02_01) as anggaran_5_02_01,
				sum(nilai_real_5_02_01) as reali_5_02_01,
				sum(nilai_ang_5_01_01) as anggaran_5_01_01,
				sum(nilai_real_5_01_01) as reali_5_01_01,
				sum(nilai_ang_4_06_01) as anggaran_4_06_01,
				sum(nilai_real_4_06_01) as reali_4_06_01,
				sum(nilai_ang_4_08_01) as anggaran_4_08_01,
				sum(nilai_real_4_08_01) as reali_4_08_01,
				sum(nilai_ang_4_08_02) as anggaran_4_08_02,
				sum(nilai_real_4_08_02) as reali_4_08_02,
				sum(nilai_ang_4_08_03) as anggaran_4_08_03,
				sum(nilai_real_4_08_03) as reali_4_08_03,
				sum(nilai_ang_4_08_04) as anggaran_4_08_04,
				sum(nilai_real_4_08_04) as reali_4_08_04,
				sum(nilai_ang_4_08_05) as anggaran_4_08_05,
				sum(nilai_real_4_08_05) as reali_4_08_05,
				sum(nilai_ang_4_08_06) as anggaran_4_08_06,
				sum(nilai_real_4_08_06) as reali_4_08_06 FROM realisasi_rekap_opd( $bulan,$anggaran,$lntahunang) a
                inner join ms_rek2_64 b on b.kd_rek2 = left(a.kd_rek5,2)                
                where left(a.kd_rek5,1)='6' 
                group by left(a.kd_rek5,2),b.nm_rek2
                union all
                SELECT left(a.kd_rek5,3) as kode,b.nm_rek3 as nama,sum(a.nilai_angg) as anggaran,sum(a.nilai_real) as reali,
				sum(nilai_ang_1_01_01) as anggaran_1_01_01,
				sum(nilai_real_1_01_01) as reali_1_01_01,
				sum(nilai_ang_1_02_01) as anggaran_1_02_01,
				sum(nilai_real_1_02_01) as reali_1_02_01,
				sum(nilai_ang_1_03_01) as anggaran_1_03_01,
				sum(nilai_real_1_03_01) as reali_1_03_01,
				sum(nilai_ang_1_04_01) as anggaran_1_04_01,
				sum(nilai_real_1_04_01) as reali_1_04_01,
				sum(nilai_ang_1_05_01) as anggaran_1_05_01,
				sum(nilai_real_1_05_01) as reali_1_05_01,
				sum(nilai_ang_1_05_02) as anggaran_1_05_02,
				sum(nilai_real_1_05_02) as reali_1_05_02,
				sum(nilai_ang_1_05_03) as anggaran_1_05_03,
				sum(nilai_real_1_05_03) as reali_1_05_03,
				sum(nilai_ang_1_06_01) as anggaran_1_06_01,
				sum(nilai_real_1_06_01) as reali_1_06_01,
				sum(nilai_ang_2_02_01) as anggaran_2_02_01,
				sum(nilai_real_2_02_01) as reali_2_02_01,
				sum(nilai_ang_2_03_01) as anggaran_2_03_01,
				sum(nilai_real_2_03_01) as reali_2_03_01,
				sum(nilai_ang_2_05_01) as anggaran_2_05_01,
				sum(nilai_real_2_05_01) as reali_2_05_01,
				sum(nilai_ang_2_06_01) as anggaran_2_06_01,
				sum(nilai_real_2_06_01) as reali_2_06_01,
				sum(nilai_ang_2_09_01) as anggaran_2_09_01,
				sum(nilai_real_2_09_01) as reali_2_09_01,
				sum(nilai_ang_2_10_01) as anggaran_2_10_01,
				sum(nilai_real_2_10_01) as reali_2_10_01,
				sum(nilai_ang_2_11_01) as anggaran_2_11_01,
				sum(nilai_real_2_11_01) as reali_2_11_01,
				sum(nilai_ang_2_12_01) as anggaran_2_12_01,
				sum(nilai_real_2_12_01) as reali_2_12_01,
				sum(nilai_ang_2_13_01) as anggaran_2_13_01,
				sum(nilai_real_2_13_01) as reali_2_13_01,
				sum(nilai_ang_2_17_01) as anggaran_2_17_01,
				sum(nilai_real_2_17_01) as reali_2_17_01,
				sum(nilai_ang_4_01_01) as anggaran_4_01_01,
				sum(nilai_real_4_01_01) as reali_4_01_01,
				sum(nilai_ang_4_02_01) as anggaran_4_02_01,
				sum(nilai_real_4_02_01) as reali_4_02_01,
				sum(nilai_ang_4_02_02) as anggaran_4_02_02,
				sum(nilai_real_4_02_02) as reali_4_02_02,
				sum(nilai_ang_4_03_01) as anggaran_4_03_01,
				sum(nilai_real_4_03_01) as reali_4_03_01,
				sum(nilai_ang_4_05_01) as anggaran_4_05_01,
				sum(nilai_real_4_05_01) as reali_4_05_01,
				sum(nilai_ang_5_02_01) as anggaran_5_02_01,
				sum(nilai_real_5_02_01) as reali_5_02_01,
				sum(nilai_ang_5_01_01) as anggaran_5_01_01,
				sum(nilai_real_5_01_01) as reali_5_01_01,
				sum(nilai_ang_4_06_01) as anggaran_4_06_01,
				sum(nilai_real_4_06_01) as reali_4_06_01,
				sum(nilai_ang_4_08_01) as anggaran_4_08_01,
				sum(nilai_real_4_08_01) as reali_4_08_01,
				sum(nilai_ang_4_08_02) as anggaran_4_08_02,
				sum(nilai_real_4_08_02) as reali_4_08_02,
				sum(nilai_ang_4_08_03) as anggaran_4_08_03,
				sum(nilai_real_4_08_03) as reali_4_08_03,
				sum(nilai_ang_4_08_04) as anggaran_4_08_04,
				sum(nilai_real_4_08_04) as reali_4_08_04,
				sum(nilai_ang_4_08_05) as anggaran_4_08_05,
				sum(nilai_real_4_08_05) as reali_4_08_05,
				sum(nilai_ang_4_08_06) as anggaran_4_08_06,
				sum(nilai_real_4_08_06) as reali_4_08_06 FROM realisasi_rekap_opd( $bulan,$anggaran,$lntahunang) a
                inner join ms_rek3_64 b on b.kd_rek3 = left(a.kd_rek5,3)                
                where left(a.kd_rek5,1)='6' 
                group by left(a.kd_rek5,3),b.nm_rek3
                union all
                SELECT left(a.kd_rek5,5) as kode,b.nm_rek4_64 as nama,sum(a.nilai_angg) as anggaran,sum(a.nilai_real) as reali,
				sum(nilai_ang_1_01_01) as anggaran_1_01_01,
				sum(nilai_real_1_01_01) as reali_1_01_01,
				sum(nilai_ang_1_02_01) as anggaran_1_02_01,
				sum(nilai_real_1_02_01) as reali_1_02_01,
				sum(nilai_ang_1_03_01) as anggaran_1_03_01,
				sum(nilai_real_1_03_01) as reali_1_03_01,
				sum(nilai_ang_1_04_01) as anggaran_1_04_01,
				sum(nilai_real_1_04_01) as reali_1_04_01,
				sum(nilai_ang_1_05_01) as anggaran_1_05_01,
				sum(nilai_real_1_05_01) as reali_1_05_01,
				sum(nilai_ang_1_05_02) as anggaran_1_05_02,
				sum(nilai_real_1_05_02) as reali_1_05_02,
				sum(nilai_ang_1_05_03) as anggaran_1_05_03,
				sum(nilai_real_1_05_03) as reali_1_05_03,
				sum(nilai_ang_1_06_01) as anggaran_1_06_01,
				sum(nilai_real_1_06_01) as reali_1_06_01,
				sum(nilai_ang_2_02_01) as anggaran_2_02_01,
				sum(nilai_real_2_02_01) as reali_2_02_01,
				sum(nilai_ang_2_03_01) as anggaran_2_03_01,
				sum(nilai_real_2_03_01) as reali_2_03_01,
				sum(nilai_ang_2_05_01) as anggaran_2_05_01,
				sum(nilai_real_2_05_01) as reali_2_05_01,
				sum(nilai_ang_2_06_01) as anggaran_2_06_01,
				sum(nilai_real_2_06_01) as reali_2_06_01,
				sum(nilai_ang_2_09_01) as anggaran_2_09_01,
				sum(nilai_real_2_09_01) as reali_2_09_01,
				sum(nilai_ang_2_10_01) as anggaran_2_10_01,
				sum(nilai_real_2_10_01) as reali_2_10_01,
				sum(nilai_ang_2_11_01) as anggaran_2_11_01,
				sum(nilai_real_2_11_01) as reali_2_11_01,
				sum(nilai_ang_2_12_01) as anggaran_2_12_01,
				sum(nilai_real_2_12_01) as reali_2_12_01,
				sum(nilai_ang_2_13_01) as anggaran_2_13_01,
				sum(nilai_real_2_13_01) as reali_2_13_01,
				sum(nilai_ang_2_17_01) as anggaran_2_17_01,
				sum(nilai_real_2_17_01) as reali_2_17_01,
				sum(nilai_ang_4_01_01) as anggaran_4_01_01,
				sum(nilai_real_4_01_01) as reali_4_01_01,
				sum(nilai_ang_4_02_01) as anggaran_4_02_01,
				sum(nilai_real_4_02_01) as reali_4_02_01,
				sum(nilai_ang_4_02_02) as anggaran_4_02_02,
				sum(nilai_real_4_02_02) as reali_4_02_02,
				sum(nilai_ang_4_03_01) as anggaran_4_03_01,
				sum(nilai_real_4_03_01) as reali_4_03_01,
				sum(nilai_ang_4_05_01) as anggaran_4_05_01,
				sum(nilai_real_4_05_01) as reali_4_05_01,
				sum(nilai_ang_5_02_01) as anggaran_5_02_01,
				sum(nilai_real_5_02_01) as reali_5_02_01,
				sum(nilai_ang_5_01_01) as anggaran_5_01_01,
				sum(nilai_real_5_01_01) as reali_5_01_01,
				sum(nilai_ang_4_06_01) as anggaran_4_06_01,
				sum(nilai_real_4_06_01) as reali_4_06_01,
				sum(nilai_ang_4_08_01) as anggaran_4_08_01,
				sum(nilai_real_4_08_01) as reali_4_08_01,
				sum(nilai_ang_4_08_02) as anggaran_4_08_02,
				sum(nilai_real_4_08_02) as reali_4_08_02,
				sum(nilai_ang_4_08_03) as anggaran_4_08_03,
				sum(nilai_real_4_08_03) as reali_4_08_03,
				sum(nilai_ang_4_08_04) as anggaran_4_08_04,
				sum(nilai_real_4_08_04) as reali_4_08_04,
				sum(nilai_ang_4_08_05) as anggaran_4_08_05,
				sum(nilai_real_4_08_05) as reali_4_08_05,
				sum(nilai_ang_4_08_06) as anggaran_4_08_06,
				sum(nilai_real_4_08_06) as reali_4_08_06 FROM realisasi_rekap_opd( $bulan,$anggaran,$lntahunang) a
                inner join ms_rek4_64 b on b.kd_rek4_64 = left(a.kd_rek5,5)                
                where left(a.kd_rek5,1)='6' 
                group by left(a.kd_rek5,5),b.nm_rek4_64
                union all
                SELECT a.kd_rek5 as kode,b.nm_rek64 as nama,sum(a.nilai_angg) as anggaran,sum(a.nilai_real) as reali,
				sum(nilai_ang_1_01_01) as anggaran_1_01_01,
				sum(nilai_real_1_01_01) as reali_1_01_01,
				sum(nilai_ang_1_02_01) as anggaran_1_02_01,
				sum(nilai_real_1_02_01) as reali_1_02_01,
				sum(nilai_ang_1_03_01) as anggaran_1_03_01,
				sum(nilai_real_1_03_01) as reali_1_03_01,
				sum(nilai_ang_1_04_01) as anggaran_1_04_01,
				sum(nilai_real_1_04_01) as reali_1_04_01,
				sum(nilai_ang_1_05_01) as anggaran_1_05_01,
				sum(nilai_real_1_05_01) as reali_1_05_01,
				sum(nilai_ang_1_05_02) as anggaran_1_05_02,
				sum(nilai_real_1_05_02) as reali_1_05_02,
				sum(nilai_ang_1_05_03) as anggaran_1_05_03,
				sum(nilai_real_1_05_03) as reali_1_05_03,
				sum(nilai_ang_1_06_01) as anggaran_1_06_01,
				sum(nilai_real_1_06_01) as reali_1_06_01,
				sum(nilai_ang_2_02_01) as anggaran_2_02_01,
				sum(nilai_real_2_02_01) as reali_2_02_01,
				sum(nilai_ang_2_03_01) as anggaran_2_03_01,
				sum(nilai_real_2_03_01) as reali_2_03_01,
				sum(nilai_ang_2_05_01) as anggaran_2_05_01,
				sum(nilai_real_2_05_01) as reali_2_05_01,
				sum(nilai_ang_2_06_01) as anggaran_2_06_01,
				sum(nilai_real_2_06_01) as reali_2_06_01,
				sum(nilai_ang_2_09_01) as anggaran_2_09_01,
				sum(nilai_real_2_09_01) as reali_2_09_01,
				sum(nilai_ang_2_10_01) as anggaran_2_10_01,
				sum(nilai_real_2_10_01) as reali_2_10_01,
				sum(nilai_ang_2_11_01) as anggaran_2_11_01,
				sum(nilai_real_2_11_01) as reali_2_11_01,
				sum(nilai_ang_2_12_01) as anggaran_2_12_01,
				sum(nilai_real_2_12_01) as reali_2_12_01,
				sum(nilai_ang_2_13_01) as anggaran_2_13_01,
				sum(nilai_real_2_13_01) as reali_2_13_01,
				sum(nilai_ang_2_17_01) as anggaran_2_17_01,
				sum(nilai_real_2_17_01) as reali_2_17_01,
				sum(nilai_ang_4_01_01) as anggaran_4_01_01,
				sum(nilai_real_4_01_01) as reali_4_01_01,
				sum(nilai_ang_4_02_01) as anggaran_4_02_01,
				sum(nilai_real_4_02_01) as reali_4_02_01,
				sum(nilai_ang_4_02_02) as anggaran_4_02_02,
				sum(nilai_real_4_02_02) as reali_4_02_02,
				sum(nilai_ang_4_03_01) as anggaran_4_03_01,
				sum(nilai_real_4_03_01) as reali_4_03_01,
				sum(nilai_ang_4_05_01) as anggaran_4_05_01,
				sum(nilai_real_4_05_01) as reali_4_05_01,
				sum(nilai_ang_5_02_01) as anggaran_5_02_01,
				sum(nilai_real_5_02_01) as reali_5_02_01,
				sum(nilai_ang_5_01_01) as anggaran_5_01_01,
				sum(nilai_real_5_01_01) as reali_5_01_01,
				sum(nilai_ang_4_06_01) as anggaran_4_06_01,
				sum(nilai_real_4_06_01) as reali_4_06_01,
				sum(nilai_ang_4_08_01) as anggaran_4_08_01,
				sum(nilai_real_4_08_01) as reali_4_08_01,
				sum(nilai_ang_4_08_02) as anggaran_4_08_02,
				sum(nilai_real_4_08_02) as reali_4_08_02,
				sum(nilai_ang_4_08_03) as anggaran_4_08_03,
				sum(nilai_real_4_08_03) as reali_4_08_03,
				sum(nilai_ang_4_08_04) as anggaran_4_08_04,
				sum(nilai_real_4_08_04) as reali_4_08_04,
				sum(nilai_ang_4_08_05) as anggaran_4_08_05,
				sum(nilai_real_4_08_05) as reali_4_08_05,
				sum(nilai_ang_4_08_06) as anggaran_4_08_06,
				sum(nilai_real_4_08_06) as reali_4_08_06 FROM realisasi_rekap_opd( $bulan,$anggaran,$lntahunang) a  
                inner join ms_rek5 b on b.kd_rek64 = a.kd_rek5                       
                where left(a.kd_rek5,1)='6' 
                group by a.kd_rek5,b.nm_rek64
                )z order by kode,nama
                ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil    = $row4->reali;
					$angnil = $row4->anggaran;
					$angnil_1_01_01  = $row4->anggaran_1_01_01;
					$nil_1_01_01  = $row4->reali_1_01_01;
					$angnil_1_02_01  = $row4->anggaran_1_02_01;
					$nil_1_02_01  = $row4->reali_1_02_01;
					$angnil_1_03_01  = $row4->anggaran_1_03_01;
					$nil_1_03_01  = $row4->reali_1_03_01;
					$angnil_1_04_01  = $row4->anggaran_1_04_01;
					$nil_1_04_01  = $row4->reali_1_04_01;
					$angnil_1_05_01  = $row4->anggaran_1_05_01;
					$nil_1_05_01  = $row4->reali_1_05_01;
					$angnil_1_05_02  = $row4->anggaran_1_05_02;
					$nil_1_05_02  = $row4->reali_1_05_02;
					$angnil_1_05_03  = $row4->anggaran_1_05_03;
					$nil_1_05_03  = $row4->reali_1_05_03;
					$angnil_1_06_01  = $row4->anggaran_1_06_01;
					$nil_1_06_01  = $row4->reali_1_06_01;
					$angnil_2_02_01  = $row4->anggaran_2_02_01;
					$nil_2_02_01  = $row4->reali_2_02_01;
					$angnil_2_03_01  = $row4->anggaran_2_03_01;
					$nil_2_03_01  = $row4->reali_2_03_01;
					$angnil_2_05_01  = $row4->anggaran_2_05_01;
					$nil_2_05_01  = $row4->reali_2_05_01;
					$angnil_2_06_01  = $row4->anggaran_2_06_01;
					$nil_2_06_01  = $row4->reali_2_06_01;
					$angnil_2_09_01  = $row4->anggaran_2_09_01;
					$nil_2_09_01  = $row4->reali_2_09_01;
					$angnil_2_10_01  = $row4->anggaran_2_10_01;
					$nil_2_10_01  = $row4->reali_2_10_01;
					$angnil_2_11_01  = $row4->anggaran_2_11_01;
					$nil_2_11_01  = $row4->reali_2_11_01;
					$angnil_2_12_01  = $row4->anggaran_2_12_01;
					$nil_2_12_01  = $row4->reali_2_12_01;
					$angnil_2_13_01  = $row4->anggaran_2_13_01;
					$nil_2_13_01  = $row4->reali_2_13_01;
					$angnil_2_17_01  = $row4->anggaran_2_17_01;
					$nil_2_17_01  = $row4->reali_2_17_01;
					$angnil_4_01_01  = $row4->anggaran_4_01_01;
					$nil_4_01_01  = $row4->reali_4_01_01;
					$angnil_4_02_01  = $row4->anggaran_4_02_01;
					$nil_4_02_01  = $row4->reali_4_02_01;
					$angnil_4_02_02  = $row4->anggaran_4_02_02;
					$nil_4_02_02  = $row4->reali_4_02_02;
					$angnil_4_03_01  = $row4->anggaran_4_03_01;
					$nil_4_03_01  = $row4->reali_4_03_01;
					$angnil_4_05_01  = $row4->anggaran_4_05_01;
					$nil_4_05_01  = $row4->reali_4_05_01;
					$angnil_5_02_01  = $row4->anggaran_5_02_01;
					$nil_5_02_01  = $row4->reali_5_02_01;
					$angnil_5_01_01  = $row4->anggaran_5_01_01;
					$nil_5_01_01  = $row4->reali_5_01_01;
					$angnil_4_06_01  = $row4->anggaran_4_06_01;
					$nil_4_06_01  = $row4->reali_4_06_01;
					$angnil_4_08_01  = $row4->anggaran_4_08_01;
					$nil_4_08_01  = $row4->reali_4_08_01;
					$angnil_4_08_02  = $row4->anggaran_4_08_02;
					$nil_4_08_02  = $row4->reali_4_08_02;
					$angnil_4_08_03  = $row4->anggaran_4_08_03;
					$nil_4_08_03  = $row4->reali_4_08_03;
					$angnil_4_08_04  = $row4->anggaran_4_08_04;
					$nil_4_08_04  = $row4->reali_4_08_04;
					$angnil_4_08_05  = $row4->anggaran_4_08_05;
					$nil_4_08_05  = $row4->reali_4_08_05;
					$angnil_4_08_06  = $row4->anggaran_4_08_06;
					$nil_4_08_06  = $row4->reali_4_08_06;
					
					
					$angnilai  =  number_format($angnil,"2",".",",");
					$nilai  =  number_format($nil,"2",".",",");
					$angnil_1_01_01  =  number_format($angnil_1_01_01,"2",".",",");
					$nil_1_01_01  =  number_format($nil_1_01_01,"2",".",",");
					$angnil_1_02_01  =  number_format($angnil_1_02_01,"2",".",",");
					$nil_1_02_01  =  number_format($nil_1_02_01,"2",".",",");
					$angnil_1_03_01  =  number_format($angnil_1_03_01,"2",".",",");
					$nil_1_03_01  =  number_format($nil_1_03_01,"2",".",",");
					$angnil_1_04_01  =  number_format($angnil_1_04_01,"2",".",",");
					$nil_1_04_01  =  number_format($nil_1_04_01,"2",".",",");
					$angnil_1_05_01  =  number_format($angnil_1_05_01,"2",".",",");
					$nil_1_05_01  =  number_format($nil_1_05_01,"2",".",",");
					$angnil_1_05_02  =  number_format($angnil_1_05_02,"2",".",",");
					$nil_1_05_02  =  number_format($nil_1_05_02,"2",".",",");
					$angnil_1_05_03  =  number_format($angnil_1_05_03,"2",".",",");
					$nil_1_05_03  =  number_format($nil_1_05_03,"2",".",",");
					$angnil_1_06_01  =  number_format($angnil_1_06_01,"2",".",",");
					$nil_1_06_01  =  number_format($nil_1_06_01,"2",".",",");
					$angnil_2_02_01  =  number_format($angnil_2_02_01,"2",".",",");
					$nil_2_02_01  =  number_format($nil_2_02_01,"2",".",",");
					$angnil_2_03_01  =  number_format($angnil_2_03_01,"2",".",",");
					$nil_2_03_01  =  number_format($nil_2_03_01,"2",".",",");
					$angnil_2_05_01  =  number_format($angnil_2_05_01,"2",".",",");
					$nil_2_05_01  =  number_format($nil_2_05_01,"2",".",",");
					$angnil_2_06_01  =  number_format($angnil_2_06_01,"2",".",",");
					$nil_2_06_01  =  number_format($nil_2_06_01,"2",".",",");
					$angnil_2_09_01  =  number_format($angnil_2_09_01,"2",".",",");
					$nil_2_09_01  =  number_format($nil_2_09_01,"2",".",",");
					$angnil_2_10_01  =  number_format($angnil_2_10_01,"2",".",",");
					$nil_2_10_01  =  number_format($nil_2_10_01,"2",".",",");
					$angnil_2_11_01  =  number_format($angnil_2_11_01,"2",".",",");
					$nil_2_11_01  =  number_format($nil_2_11_01,"2",".",",");
					$angnil_2_12_01  =  number_format($angnil_2_12_01,"2",".",",");
					$nil_2_12_01  =  number_format($nil_2_12_01,"2",".",",");
					$angnil_2_13_01  =  number_format($angnil_2_13_01,"2",".",",");
					$nil_2_13_01  =  number_format($nil_2_13_01,"2",".",",");
					$angnil_2_17_01  =  number_format($angnil_2_17_01,"2",".",",");
					$nil_2_17_01  =  number_format($nil_2_17_01,"2",".",",");
					$angnil_4_01_01  =  number_format($angnil_4_01_01,"2",".",",");
					$nil_4_01_01  =  number_format($nil_4_01_01,"2",".",",");
					$angnil_4_02_01  =  number_format($angnil_4_02_01,"2",".",",");
					$nil_4_02_01  =  number_format($nil_4_02_01,"2",".",",");
					$angnil_4_02_02  =  number_format($angnil_4_02_02,"2",".",",");
					$nil_4_02_02  =  number_format($nil_4_02_02,"2",".",",");
					$angnil_4_03_01  =  number_format($angnil_4_03_01,"2",".",",");
					$nil_4_03_01  =  number_format($nil_4_03_01,"2",".",",");
					$angnil_4_05_01  =  number_format($angnil_4_05_01,"2",".",",");
					$nil_4_05_01  =  number_format($nil_4_05_01,"2",".",",");
					$angnil_5_02_01  =  number_format($angnil_5_02_01,"2",".",",");
					$nil_5_02_01  =  number_format($nil_5_02_01,"2",".",",");
					$angnil_5_01_01  =  number_format($angnil_5_01_01,"2",".",",");
					$nil_5_01_01  =  number_format($nil_5_01_01,"2",".",",");
					$angnil_4_06_01  =  number_format($angnil_4_06_01,"2",".",",");
					$nil_4_06_01  =  number_format($nil_4_06_01,"2",".",",");
					$angnil_4_08_01  =  number_format($angnil_4_08_01,"2",".",",");
					$nil_4_08_01  =  number_format($nil_4_08_01,"2",".",",");
					$angnil_4_08_02  =  number_format($angnil_4_08_02,"2",".",",");
					$nil_4_08_02  =  number_format($nil_4_08_02,"2",".",",");
					$angnil_4_08_03  =  number_format($angnil_4_08_03,"2",".",",");
					$nil_4_08_03  =  number_format($nil_4_08_03,"2",".",",");
					$angnil_4_08_04  =  number_format($angnil_4_08_04,"2",".",",");
					$nil_4_08_04  =  number_format($nil_4_08_04,"2",".",",");
					$angnil_4_08_05  =  number_format($angnil_4_08_05,"2",".",",");
					$nil_4_08_05  =  number_format($nil_4_08_05,"2",".",",");
					$angnil_4_08_06  =  number_format($angnil_4_08_06,"2",".",",");
					$nil_4_08_06  =  number_format($nil_4_08_06,"2",".",",");
					
                    
                   if(strlen("$no")<6){
                    $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai<b></td>
									 <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_1_01_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_1_01_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_1_02_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_1_02_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_1_03_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_1_03_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_1_04_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_1_04_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_1_05_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_1_05_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_1_05_02<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_1_05_02<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_1_05_03<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_1_05_03<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_1_06_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_1_06_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_2_02_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_2_02_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_2_03_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_2_03_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_2_05_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_2_05_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_2_06_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_2_06_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_2_09_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_2_09_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_2_10_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_2_10_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_2_11_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_2_11_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_2_12_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_2_12_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_2_13_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_2_13_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_2_17_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_2_17_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_4_01_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_4_01_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_4_02_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_4_02_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_4_02_02<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_4_02_02<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_4_03_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_4_03_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_4_05_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_4_05_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_5_02_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_5_02_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_5_01_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_5_01_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_4_06_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_4_06_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_4_08_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_4_08_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_4_08_02<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_4_08_02<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_4_08_03<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_4_08_03<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_4_08_04<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_4_08_04<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_4_08_05<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_4_08_05<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_4_08_06<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_4_08_06<b></td>
                                 </tr>";
                             }else
                             {
					$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">$no</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\">$nama</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nilai</td>
									 <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_1_01_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_1_01_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_1_02_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_1_02_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_1_03_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_1_03_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_1_04_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_1_04_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_1_05_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_1_05_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_1_05_02</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_1_05_02</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_1_05_03</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_1_05_03</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_1_06_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_1_06_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_2_02_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_2_02_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_2_03_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_2_03_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_2_05_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_2_05_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_2_06_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_2_06_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_2_09_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_2_09_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_2_10_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_2_10_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_2_11_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_2_11_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_2_12_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_2_12_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_2_13_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_2_13_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_2_17_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_2_17_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_4_01_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_4_01_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_4_02_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_4_02_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_4_02_02</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_4_02_02</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_4_03_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_4_03_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_4_05_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_4_05_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_5_02_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_5_02_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_5_01_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_5_01_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_4_06_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_4_06_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_4_08_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_4_08_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_4_08_02</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_4_08_02</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_4_08_03</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_4_08_03</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_4_08_04</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_4_08_04</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_4_08_05</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_4_08_05</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_4_08_06</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_4_08_06</td>
                                 </tr>";
                             }
               }	              
                		$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                 </tr>";			 
				 
				$angnil5=0;
				$nil5=0;
				$angnil5_1_01_01=0;
				$nil5_1_01_01=0;
				$angnil5_1_02_01=0;
				$nil5_1_02_01=0;
				$angnil5_1_03_01=0;
				$nil5_1_03_01=0;
				$angnil5_1_04_01=0;
				$nil5_1_04_01=0;
				$angnil5_1_05_01=0;
				$nil5_1_05_01=0;
				$angnil5_1_05_02=0;
				$nil5_1_05_02=0;
				$angnil5_1_05_03=0;
				$nil5_1_05_03=0;
				$angnil5_1_06_01=0;
				$nil5_1_06_01=0;
				$angnil5_2_02_01=0;
				$nil5_2_02_01=0;
				$angnil5_2_03_01=0;
				$nil5_2_03_01=0;
				$angnil5_2_05_01=0;
				$nil5_2_05_01=0;
				$angnil5_2_06_01=0;
				$nil5_2_06_01=0;
				$angnil5_2_09_01=0;
				$nil5_2_09_01=0;
				$angnil5_2_10_01=0;
				$nil5_2_10_01=0;
				$angnil5_2_11_01=0;
				$nil5_2_11_01=0;
				$angnil5_2_12_01=0;
				$nil5_2_12_01=0;
				$angnil5_2_13_01=0;
				$nil5_2_13_01=0;
				$angnil5_2_17_01=0;
				$nil5_2_17_01=0;
				$angnil5_4_01_01=0;
				$nil5_4_01_01=0;
				$angnil5_4_02_01=0;
				$nil5_4_02_01=0;
				$angnil5_4_02_02=0;
				$nil5_4_02_02=0;
				$angnil5_4_03_01=0;
				$nil5_4_03_01=0;
				$angnil5_4_05_01=0;
				$nil5_4_05_01=0;
				$angnil5_5_02_01=0;
				$nil5_5_02_01=0;
				$angnil5_5_01_01=0;
				$nil5_5_01_01=0;
				$angnil5_4_06_01=0;
				$nil5_4_06_01=0;
				$angnil5_4_08_01=0;
				$nil5_4_08_01=0;
				$angnil5_4_08_02=0;
				$nil5_4_08_02=0;
				$angnil5_4_08_03=0;
				$nil5_4_08_03=0;
				$angnil5_4_08_04=0;
				$nil5_4_08_04=0;
				$angnil5_4_08_05=0;
				$nil5_4_08_05=0;
				$angnil5_4_08_06=0;
				$nil5_4_08_06=0;

				$sql4="
                select z.kode,z.nama,z.anggaran,z.reali,z.anggaran_1_01_01,
				z.reali_1_01_01,
				z.anggaran_1_02_01,
				z.reali_1_02_01,
				z.anggaran_1_03_01,
				z.reali_1_03_01,
				z.anggaran_1_04_01,
				z.reali_1_04_01,
				z.anggaran_1_05_01,
				z.reali_1_05_01,
				z.anggaran_1_05_02,
				z.reali_1_05_02,
				z.anggaran_1_05_03,
				z.reali_1_05_03,
				z.anggaran_1_06_01,
				z.reali_1_06_01,
				z.anggaran_2_02_01,
				z.reali_2_02_01,
				z.anggaran_2_03_01,
				z.reali_2_03_01,
				z.anggaran_2_05_01,
				z.reali_2_05_01,
				z.anggaran_2_06_01,
				z.reali_2_06_01,
				z.anggaran_2_09_01,
				z.reali_2_09_01,
				z.anggaran_2_10_01,
				z.reali_2_10_01,
				z.anggaran_2_11_01,
				z.reali_2_11_01,
				z.anggaran_2_12_01,
				z.reali_2_12_01,
				z.anggaran_2_13_01,
				z.reali_2_13_01,
				z.anggaran_2_17_01,
				z.reali_2_17_01,
				z.anggaran_4_01_01,
				z.reali_4_01_01,
				z.anggaran_4_02_01,
				z.reali_4_02_01,
				z.anggaran_4_02_02,
				z.reali_4_02_02,
				z.anggaran_4_03_01,
				z.reali_4_03_01,
				z.anggaran_4_05_01,
				z.reali_4_05_01,
				z.anggaran_5_02_01,
				z.reali_5_02_01,
				z.anggaran_5_01_01,
				z.reali_5_01_01,
				z.anggaran_4_06_01,
				z.reali_4_06_01,
				z.anggaran_4_08_01,
				z.reali_4_08_01,
				z.anggaran_4_08_02,
				z.reali_4_08_02,
				z.anggaran_4_08_03,
				z.reali_4_08_03,
				z.anggaran_4_08_04,
				z.reali_4_08_04,
				z.anggaran_4_08_05,
				z.reali_4_08_05,
				z.anggaran_4_08_06,
				z.reali_4_08_06 from (
                SELECT ''as kode,'' as nama,sum(a.nilai_angg) as anggaran,sum(a.nilai_real) as reali,
				sum(nilai_ang_1_01_01) as anggaran_1_01_01,
				sum(nilai_real_1_01_01) as reali_1_01_01,
				sum(nilai_ang_1_02_01) as anggaran_1_02_01,
				sum(nilai_real_1_02_01) as reali_1_02_01,
				sum(nilai_ang_1_03_01) as anggaran_1_03_01,
				sum(nilai_real_1_03_01) as reali_1_03_01,
				sum(nilai_ang_1_04_01) as anggaran_1_04_01,
				sum(nilai_real_1_04_01) as reali_1_04_01,
				sum(nilai_ang_1_05_01) as anggaran_1_05_01,
				sum(nilai_real_1_05_01) as reali_1_05_01,
				sum(nilai_ang_1_05_02) as anggaran_1_05_02,
				sum(nilai_real_1_05_02) as reali_1_05_02,
				sum(nilai_ang_1_05_03) as anggaran_1_05_03,
				sum(nilai_real_1_05_03) as reali_1_05_03,
				sum(nilai_ang_1_06_01) as anggaran_1_06_01,
				sum(nilai_real_1_06_01) as reali_1_06_01,
				sum(nilai_ang_2_02_01) as anggaran_2_02_01,
				sum(nilai_real_2_02_01) as reali_2_02_01,
				sum(nilai_ang_2_03_01) as anggaran_2_03_01,
				sum(nilai_real_2_03_01) as reali_2_03_01,
				sum(nilai_ang_2_05_01) as anggaran_2_05_01,
				sum(nilai_real_2_05_01) as reali_2_05_01,
				sum(nilai_ang_2_06_01) as anggaran_2_06_01,
				sum(nilai_real_2_06_01) as reali_2_06_01,
				sum(nilai_ang_2_09_01) as anggaran_2_09_01,
				sum(nilai_real_2_09_01) as reali_2_09_01,
				sum(nilai_ang_2_10_01) as anggaran_2_10_01,
				sum(nilai_real_2_10_01) as reali_2_10_01,
				sum(nilai_ang_2_11_01) as anggaran_2_11_01,
				sum(nilai_real_2_11_01) as reali_2_11_01,
				sum(nilai_ang_2_12_01) as anggaran_2_12_01,
				sum(nilai_real_2_12_01) as reali_2_12_01,
				sum(nilai_ang_2_13_01) as anggaran_2_13_01,
				sum(nilai_real_2_13_01) as reali_2_13_01,
				sum(nilai_ang_2_17_01) as anggaran_2_17_01,
				sum(nilai_real_2_17_01) as reali_2_17_01,
				sum(nilai_ang_4_01_01) as anggaran_4_01_01,
				sum(nilai_real_4_01_01) as reali_4_01_01,
				sum(nilai_ang_4_02_01) as anggaran_4_02_01,
				sum(nilai_real_4_02_01) as reali_4_02_01,
				sum(nilai_ang_4_02_02) as anggaran_4_02_02,
				sum(nilai_real_4_02_02) as reali_4_02_02,
				sum(nilai_ang_4_03_01) as anggaran_4_03_01,
				sum(nilai_real_4_03_01) as reali_4_03_01,
				sum(nilai_ang_4_05_01) as anggaran_4_05_01,
				sum(nilai_real_4_05_01) as reali_4_05_01,
				sum(nilai_ang_5_02_01) as anggaran_5_02_01,
				sum(nilai_real_5_02_01) as reali_5_02_01,
				sum(nilai_ang_5_01_01) as anggaran_5_01_01,
				sum(nilai_real_5_01_01) as reali_5_01_01,
				sum(nilai_ang_4_06_01) as anggaran_4_06_01,
				sum(nilai_real_4_06_01) as reali_4_06_01,
				sum(nilai_ang_4_08_01) as anggaran_4_08_01,
				sum(nilai_real_4_08_01) as reali_4_08_01,
				sum(nilai_ang_4_08_02) as anggaran_4_08_02,
				sum(nilai_real_4_08_02) as reali_4_08_02,
				sum(nilai_ang_4_08_03) as anggaran_4_08_03,
				sum(nilai_real_4_08_03) as reali_4_08_03,
				sum(nilai_ang_4_08_04) as anggaran_4_08_04,
				sum(nilai_real_4_08_04) as reali_4_08_04,
				sum(nilai_ang_4_08_05) as anggaran_4_08_05,
				sum(nilai_real_4_08_05) as reali_4_08_05,
				sum(nilai_ang_4_08_06) as anggaran_4_08_06,
				sum(nilai_real_4_08_06) as reali_4_08_06 FROM realisasi_rekap_opd( $bulan,$anggaran,$lntahunang) a  
                inner join ms_rek1_64 b on b.kd_rek1 = left(a.kd_rek5,1)                
                where left(a.kd_rek5,1) in ('5','6')             
                )z order by kode,nama
                ";
						                 
                
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil5    = $row4->reali;
					$angnil5 = $row4->anggaran;
					$angnil5_1_01_01  =  $row4->anggaran_1_01_01;
					$nil5_1_01_01   =  $row4->reali_1_01_01;
					$angnil5_1_02_01  =  $row4->anggaran_1_02_01;
					$nil5_1_02_01   =  $row4->reali_1_02_01;
					$angnil5_1_03_01  =  $row4->anggaran_1_03_01;
					$nil5_1_03_01   =  $row4->reali_1_03_01;
					$angnil5_1_04_01  =  $row4->anggaran_1_04_01;
					$nil5_1_04_01   =  $row4->reali_1_04_01;
					$angnil5_1_05_01  =  $row4->anggaran_1_05_01;
					$nil5_1_05_01   =  $row4->reali_1_05_01;
					$angnil5_1_05_02  =  $row4->anggaran_1_05_02;
					$nil5_1_05_02   =  $row4->reali_1_05_02;
					$angnil5_1_05_03  =  $row4->anggaran_1_05_03;
					$nil5_1_05_03   =  $row4->reali_1_05_03;
					$angnil5_1_06_01  =  $row4->anggaran_1_06_01;
					$nil5_1_06_01   =  $row4->reali_1_06_01;
					$angnil5_2_02_01  =  $row4->anggaran_2_02_01;
					$nil5_2_02_01   =  $row4->reali_2_02_01;
					$angnil5_2_03_01  =  $row4->anggaran_2_03_01;
					$nil5_2_03_01   =  $row4->reali_2_03_01;
					$angnil5_2_05_01  =  $row4->anggaran_2_05_01;
					$nil5_2_05_01   =  $row4->reali_2_05_01;
					$angnil5_2_06_01  =  $row4->anggaran_2_06_01;
					$nil5_2_06_01   =  $row4->reali_2_06_01;
					$angnil5_2_09_01  =  $row4->anggaran_2_09_01;
					$nil5_2_09_01   =  $row4->reali_2_09_01;
					$angnil5_2_10_01  =  $row4->anggaran_2_10_01;
					$nil5_2_10_01   =  $row4->reali_2_10_01;
					$angnil5_2_11_01  =  $row4->anggaran_2_11_01;
					$nil5_2_11_01   =  $row4->reali_2_11_01;
					$angnil5_2_12_01  =  $row4->anggaran_2_12_01;
					$nil5_2_12_01   =  $row4->reali_2_12_01;
					$angnil5_2_13_01  =  $row4->anggaran_2_13_01;
					$nil5_2_13_01   =  $row4->reali_2_13_01;
					$angnil5_2_17_01  =  $row4->anggaran_2_17_01;
					$nil5_2_17_01   =  $row4->reali_2_17_01;
					$angnil5_4_01_01  =  $row4->anggaran_4_01_01;
					$nil5_4_01_01   =  $row4->reali_4_01_01;
					$angnil5_4_02_01  =  $row4->anggaran_4_02_01;
					$nil5_4_02_01   =  $row4->reali_4_02_01;
					$angnil5_4_02_02  =  $row4->anggaran_4_02_02;
					$nil5_4_02_02   =  $row4->reali_4_02_02;
					$angnil5_4_03_01  =  $row4->anggaran_4_03_01;
					$nil5_4_03_01   =  $row4->reali_4_03_01;
					$angnil5_4_05_01  =  $row4->anggaran_4_05_01;
					$nil5_4_05_01   =  $row4->reali_4_05_01;
					$angnil5_5_02_01  =  $row4->anggaran_5_02_01;
					$nil5_5_02_01   =  $row4->reali_5_02_01;
					$angnil5_5_01_01  =  $row4->anggaran_5_01_01;
					$nil5_5_01_01   =  $row4->reali_5_01_01;
					$angnil5_4_06_01  =  $row4->anggaran_4_06_01;
					$nil5_4_06_01   =  $row4->reali_4_06_01;
					$angnil5_4_08_01  =  $row4->anggaran_4_08_01;
					$nil5_4_08_01   =  $row4->reali_4_08_01;
					$angnil5_4_08_02  =  $row4->anggaran_4_08_02;
					$nil5_4_08_02   =  $row4->reali_4_08_02;
					$angnil5_4_08_03  =  $row4->anggaran_4_08_03;
					$nil5_4_08_03   =  $row4->reali_4_08_03;
					$angnil5_4_08_04  =  $row4->anggaran_4_08_04;
					$nil5_4_08_04   =  $row4->reali_4_08_04;
					$angnil5_4_08_05  =  $row4->anggaran_4_08_05;
					$nil5_4_08_05   =  $row4->reali_4_08_05;
					$angnil5_4_08_06  =  $row4->anggaran_4_08_06;
					$nil5_4_08_06   =  $row4->reali_4_08_06;
					
					$angnilai5  =  number_format($angnil5,"2",".",",");
					$nilai5  =  number_format($nil5,"2",".",",");
					$angnilai5_1_01_01     =    number_format($angnil5_1_01_01,"2",".",",");
					$nilai5_1_01_01     =    number_format($nil5_1_01_01,"2",".",",");
					$angnilai5_1_02_01     =    number_format($angnil5_1_02_01,"2",".",",");
					$nilai5_1_02_01     =    number_format($nil5_1_02_01,"2",".",",");
					$angnilai5_1_03_01     =    number_format($angnil5_1_03_01,"2",".",",");
					$nilai5_1_03_01     =    number_format($nil5_1_03_01,"2",".",",");
					$angnilai5_1_04_01     =    number_format($angnil5_1_04_01,"2",".",",");
					$nilai5_1_04_01     =    number_format($nil5_1_04_01,"2",".",",");
					$angnilai5_1_05_01     =    number_format($angnil5_1_05_01,"2",".",",");
					$nilai5_1_05_01     =    number_format($nil5_1_05_01,"2",".",",");
					$angnilai5_1_05_02     =    number_format($angnil5_1_05_02,"2",".",",");
					$nilai5_1_05_02     =    number_format($nil5_1_05_02,"2",".",",");
					$angnilai5_1_05_03     =    number_format($angnil5_1_05_03,"2",".",",");
					$nilai5_1_05_03     =    number_format($nil5_1_05_03,"2",".",",");
					$angnilai5_1_06_01     =    number_format($angnil5_1_06_01,"2",".",",");
					$nilai5_1_06_01     =    number_format($nil5_1_06_01,"2",".",",");
					$angnilai5_2_02_01     =    number_format($angnil5_2_02_01,"2",".",",");
					$nilai5_2_02_01     =    number_format($nil5_2_02_01,"2",".",",");
					$angnilai5_2_03_01     =    number_format($angnil5_2_03_01,"2",".",",");
					$nilai5_2_03_01     =    number_format($nil5_2_03_01,"2",".",",");
					$angnilai5_2_05_01     =    number_format($angnil5_2_05_01,"2",".",",");
					$nilai5_2_05_01     =    number_format($nil5_2_05_01,"2",".",",");
					$angnilai5_2_06_01     =    number_format($angnil5_2_06_01,"2",".",",");
					$nilai5_2_06_01     =    number_format($nil5_2_06_01,"2",".",",");
					$angnilai5_2_09_01     =    number_format($angnil5_2_09_01,"2",".",",");
					$nilai5_2_09_01     =    number_format($nil5_2_09_01,"2",".",",");
					$angnilai5_2_10_01     =    number_format($angnil5_2_10_01,"2",".",",");
					$nilai5_2_10_01     =    number_format($nil5_2_10_01,"2",".",",");
					$angnilai5_2_11_01     =    number_format($angnil5_2_11_01,"2",".",",");
					$nilai5_2_11_01     =    number_format($nil5_2_11_01,"2",".",",");
					$angnilai5_2_12_01     =    number_format($angnil5_2_12_01,"2",".",",");
					$nilai5_2_12_01     =    number_format($nil5_2_12_01,"2",".",",");
					$angnilai5_2_13_01     =    number_format($angnil5_2_13_01,"2",".",",");
					$nilai5_2_13_01     =    number_format($nil5_2_13_01,"2",".",",");
					$angnilai5_2_17_01     =    number_format($angnil5_2_17_01,"2",".",",");
					$nilai5_2_17_01     =    number_format($nil5_2_17_01,"2",".",",");
					$angnilai5_4_01_01     =    number_format($angnil5_4_01_01,"2",".",",");
					$nilai5_4_01_01     =    number_format($nil5_4_01_01,"2",".",",");
					$angnilai5_4_02_01     =    number_format($angnil5_4_02_01,"2",".",",");
					$nilai5_4_02_01     =    number_format($nil5_4_02_01,"2",".",",");
					$angnilai5_4_02_02     =    number_format($angnil5_4_02_02,"2",".",",");
					$nilai5_4_02_02     =    number_format($nil5_4_02_02,"2",".",",");
					$angnilai5_4_03_01     =    number_format($angnil5_4_03_01,"2",".",",");
					$nilai5_4_03_01     =    number_format($nil5_4_03_01,"2",".",",");
					$angnilai5_4_05_01     =    number_format($angnil5_4_05_01,"2",".",",");
					$nilai5_4_05_01     =    number_format($nil5_4_05_01,"2",".",",");
					$angnilai5_5_02_01     =    number_format($angnil5_5_02_01,"2",".",",");
					$nilai5_5_02_01     =    number_format($nil5_5_02_01,"2",".",",");
					$angnilai5_5_01_01     =    number_format($angnil5_5_01_01,"2",".",",");
					$nilai5_5_01_01     =    number_format($nil5_5_01_01,"2",".",",");
					$angnilai5_4_06_01     =    number_format($angnil5_4_06_01,"2",".",",");
					$nilai5_4_06_01     =    number_format($nil5_4_06_01,"2",".",",");
					$angnilai5_4_08_01     =    number_format($angnil5_4_08_01,"2",".",",");
					$nilai5_4_08_01     =    number_format($nil5_4_08_01,"2",".",",");
					$angnilai5_4_08_02     =    number_format($angnil5_4_08_02,"2",".",",");
					$nilai5_4_08_02     =    number_format($nil5_4_08_02,"2",".",",");
					$angnilai5_4_08_03     =    number_format($angnil5_4_08_03,"2",".",",");
					$nilai5_4_08_03     =    number_format($nil5_4_08_03,"2",".",",");
					$angnilai5_4_08_04     =    number_format($angnil5_4_08_04,"2",".",",");
					$nilai5_4_08_04     =    number_format($nil5_4_08_04,"2",".",",");
					$angnilai5_4_08_05     =    number_format($angnil5_4_08_05,"2",".",",");
					$nilai5_4_08_05     =    number_format($nil5_4_08_05,"2",".",",");
					$angnilai5_4_08_06     =    number_format($angnil5_4_08_06,"2",".",",");
					$nilai5_4_08_06     =    number_format($nil5_4_08_06,"2",".",",");


			   
               $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>JUMLAH BELANJA & TRANSFER<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai5<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai5<b></td>
									 <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai5_1_01_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai5_1_01_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai5_1_02_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai5_1_02_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai5_1_03_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai5_1_03_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai5_1_04_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai5_1_04_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai5_1_05_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai5_1_05_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai5_1_05_02<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai5_1_05_02<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai5_1_05_03<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai5_1_05_03<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai5_1_06_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai5_1_06_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai5_2_02_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai5_2_02_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai5_2_03_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai5_2_03_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai5_2_05_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai5_2_05_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai5_2_06_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai5_2_06_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai5_2_09_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai5_2_09_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai5_2_10_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai5_2_10_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai5_2_11_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai5_2_11_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai5_2_12_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai5_2_12_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai5_2_13_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai5_2_13_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai5_2_17_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai5_2_17_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai5_4_01_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai5_4_01_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai5_4_02_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai5_4_02_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai5_4_02_02<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai5_4_02_02<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai5_4_03_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai5_4_03_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai5_4_05_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai5_4_05_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai5_5_02_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai5_5_02_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai5_5_01_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai5_5_01_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai5_4_06_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai5_4_06_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai5_4_08_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai5_4_08_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai5_4_08_02<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai5_4_08_02<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai5_4_08_03<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai5_4_08_03<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai5_4_08_04<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai5_4_08_04<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai5_4_08_05<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai5_4_08_05<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai5_4_08_06<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai5_4_08_06<b></td>
                                 </tr>";
                   }   
                 
					$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                 </tr>";
								 
					$no 	= '';
					$nama   = 'SURPLUS/(DEFISIT)';                      
					$nilsurplus    = $nil4 - $nil5;
					$angnilsurplus = $angnil4 - $angnil5;
					$nilsurplus_1_01_01 = $nil4_1_01_01 - $nil5_1_01_01;
					$angnilsurplus_1_01_01 = $angnil4_1_01_01 - $angnil5_1_01_01;
					$angnilsurplus_1_02_01 = $angnil4_1_02_01 - $angnil5_1_02_01;
					$nilsurplus_1_02_01 = $nil4_1_02_01 - $nil5_1_02_01;
					$nilsurplus_1_03_01 = $nil4_1_03_01 - $nil5_1_03_01;
					$angnilsurplus_1_03_01 = $angnil4_1_03_01 - $angnil5_1_03_01;
					$angnilsurplus_1_04_01 = $angnil4_1_04_01 - $angnil5_1_04_01;
					$nilsurplus_1_04_01 = $nil4_1_04_01 - $nil5_1_04_01;
					$nilsurplus_1_05_01 = $nil4_1_05_01 - $nil5_1_05_01;
					$angnilsurplus_1_05_01 = $angnil4_1_05_01 - $angnil5_1_05_01;
					$angnilsurplus_1_05_02 = $angnil4_1_05_02 - $angnil5_1_05_02;
					$nilsurplus_1_05_02 = $nil4_1_05_02 - $nil5_1_05_02;
					$nilsurplus_1_05_03 = $nil4_1_05_03 - $nil5_1_05_03;
					$angnilsurplus_1_05_03 = $angnil4_1_05_03 - $angnil5_1_05_03;
					$angnilsurplus_1_06_01 = $angnil4_1_06_01 - $angnil5_1_06_01;
					$nilsurplus_1_06_01 = $nil4_1_06_01 - $nil5_1_06_01;
					$nilsurplus_2_02_01 = $nil4_2_02_01 - $nil5_2_02_01;
					$angnilsurplus_2_02_01 = $angnil4_2_02_01 - $angnil5_2_02_01;
					$angnilsurplus_2_03_01 = $angnil4_2_03_01 - $angnil5_2_03_01;
					$nilsurplus_2_03_01 = $nil4_2_03_01 - $nil5_2_03_01;
					$nilsurplus_2_05_01 = $nil4_2_05_01 - $nil5_2_05_01;
					$angnilsurplus_2_05_01 = $angnil4_2_05_01 - $angnil5_2_05_01;
					$angnilsurplus_2_06_01 = $angnil4_2_06_01 - $angnil5_2_06_01;
					$nilsurplus_2_06_01 = $nil4_2_06_01 - $nil5_2_06_01;
					$nilsurplus_2_09_01 = $nil4_2_09_01 - $nil5_2_09_01;
					$angnilsurplus_2_09_01 = $angnil4_2_09_01 - $angnil5_2_09_01;
					$angnilsurplus_2_10_01 = $angnil4_2_10_01 - $angnil5_2_10_01;
					$nilsurplus_2_10_01 = $nil4_2_10_01 - $nil5_2_10_01;
					$nilsurplus_2_11_01 = $nil4_2_11_01 - $nil5_2_11_01;
					$angnilsurplus_2_11_01 = $angnil4_2_11_01 - $angnil5_2_11_01;
					$angnilsurplus_2_12_01 = $angnil4_2_12_01 - $angnil5_2_12_01;
					$nilsurplus_2_12_01 = $nil4_2_12_01 - $nil5_2_12_01;
					$nilsurplus_2_13_01 = $nil4_2_13_01 - $nil5_2_13_01;
					$angnilsurplus_2_13_01 = $angnil4_2_13_01 - $angnil5_2_13_01;
					$angnilsurplus_2_17_01 = $angnil4_2_17_01 - $angnil5_2_17_01;
					$nilsurplus_2_17_01 = $nil4_2_17_01 - $nil5_2_17_01;
					$nilsurplus_4_01_01 = $nil4_4_01_01 - $nil5_4_01_01;
					$angnilsurplus_4_01_01 = $angnil4_4_01_01 - $angnil5_4_01_01;
					$angnilsurplus_4_02_01 = $angnil4_4_02_01 - $angnil5_4_02_01;
					$nilsurplus_4_02_01 = $nil4_4_02_01 - $nil5_4_02_01;
					$nilsurplus_4_02_02 = $nil4_4_02_02 - $nil5_4_02_02;
					$angnilsurplus_4_02_02 = $angnil4_4_02_02 - $angnil5_4_02_02;
					$angnilsurplus_4_03_01 = $angnil4_4_03_01 - $angnil5_4_03_01;
					$nilsurplus_4_03_01 = $nil4_4_03_01 - $nil5_4_03_01;
					$nilsurplus_4_05_01 = $nil4_4_05_01 - $nil5_4_05_01;
					$angnilsurplus_4_05_01 = $angnil4_4_05_01 - $angnil5_4_05_01;
					$angnilsurplus_5_02_01 = $angnil4_5_02_01 - $angnil5_5_02_01;
					$nilsurplus_5_02_01 = $nil4_5_02_01 - $nil5_5_02_01;
					$angnilsurplus_5_01_01 = $angnil4_5_01_01 - $angnil5_5_01_01;
					$nilsurplus_5_01_01 = $nil4_5_01_01 - $nil5_5_01_01;
					$nilsurplus_4_06_01 = $nil4_4_06_01 - $nil5_4_06_01;
					$angnilsurplus_4_06_01 = $angnil4_4_06_01 - $angnil5_4_06_01;
					$angnilsurplus_4_08_01 = $angnil4_4_08_01 - $angnil5_4_08_01;
					$nilsurplus_4_08_01 = $nil4_4_08_01 - $nil5_4_08_01;
					$nilsurplus_4_08_02 = $nil4_4_08_02 - $nil5_4_08_02;
					$angnilsurplus_4_08_02 = $angnil4_4_08_02 - $angnil5_4_08_02;
					$angnilsurplus_4_08_03 = $angnil4_4_08_03 - $angnil5_4_08_03;
					$nilsurplus_4_08_03 = $nil4_4_08_03 - $nil5_4_08_03;
					$nilsurplus_4_08_04 = $nil4_4_08_04 - $nil5_4_08_04;
					$angnilsurplus_4_08_04 = $angnil4_4_08_04 - $angnil5_4_08_04;
					$angnilsurplus_4_08_05 = $angnil4_4_08_05 - $angnil5_4_08_05;
					$nilsurplus_4_08_05 = $nil4_4_08_05 - $nil5_4_08_05;
					$nilsurplus_4_08_06 = $nil4_4_08_06 - $nil5_4_08_06;
					$angnilsurplus_4_08_06 = $angnil4_4_08_06 - $angnil5_4_08_06;
					
				 
					 if ($angnilsurplus < 0){
                    	$axz1="("; $angnilsurplus=$angnilsurplus*-1; $axz2=")";}
                    else {
                    	$axz1=""; $axz2="";}

                    if ($nilsurplus < 0){
                    	$bxz1="("; $nilsurplus=$nilsurplus*-1; $bxz2=")";}
                    else {
                    	$bxz1=""; $bxz2="";}
						
					if($nilsurplus_1_01_01<0){
					  $azx1="("; $nilsurplus_1_01_01=$nilsurplus_1_01_01*-1; $azx2=")";}  
					  else{ 
					  $azx1=""; $azx2="";}
					  
					if($angnilsurplus_1_01_01<0){
					  $bzx1="("; $angnilsurplus_1_01_01=$angnilsurplus_1_01_01*-1; $bzx2=")";}  
					  else {
					  $bzx1=""; $bzx2="";}
					  
					if($nilsurplus_1_02_01< 0){
					  $ac1="("; $nilsurplus_1_02_01 = $nilsurplus_1_02_01*-1; $ac2=")";}  
					  else {
					  $ac1=""; $ac2="";}
					  
					if($angnilsurplus_1_02_01< 0){
					  $bc1="("; $angnilsurplus_1_02_01 = $angnilsurplus_1_02_01*-1; $bc2=")";}
					  else { 
					  $bc1=""; $bc2="";}
					  
					if($nilsurplus_1_03_01< 0){
					  $av1="("; $nilsurplus_1_03_01 = $nilsurplus_1_03_01*-1; $av2=")";}  
					  else {
					  $av1=""; $av2="";}
					  
					if($angnilsurplus_1_03_01< 0){
					  $bv1="("; $angnilsurplus_1_03_01 = $angnilsurplus_1_03_01*-1; $bv2=")";}  
					  else {
					  $bv1=""; $bv2="";}
					  
					if($nilsurplus_1_04_01< 0){
					  $ab1="("; $nilsurplus_1_04_01 = $nilsurplus_1_04_01*-1; $ab2=")";}  
					  else { 
					  $ab1=""; $ab2="";}
					  
					if($angnilsurplus_1_04_01< 0){
					  $bb1="("; $angnilsurplus_1_04_01 = $angnilsurplus_1_04_01*-1; $bb2=")";}
					  else { 
					  $bb1=""; $bb2="";}
					  
					if($nilsurplus_1_05_01< 0){ 
					 $an1="("; $nilsurplus_1_05_01 = $nilsurplus_1_05_01*-1; $an2=")";} 
					 else { 
					 $an1=""; $an2="";}
					 
					if($angnilsurplus_1_05_01< 0){ 
					 $bn1="("; $angnilsurplus_1_05_01 = $angnilsurplus_1_05_01*-1; $bn2=")";}  
					 else {
					 $bn1=""; $bn2="";}
					 
					if($nilsurplus_1_05_02< 0){
					  $am1="("; $nilsurplus_1_05_02 = $nilsurplus_1_05_02*-1; $am2=")";}  
					  else { 
					  $am1=""; $am2="";}
					  
					if($angnilsurplus_1_05_02< 0){
					  $bm1="("; $angnilsurplus_1_05_02 = $angnilsurplus_1_05_02*-1; $bm2=")";}  
					  else {
					  $bm1=""; $bm2="";}
					  
					if($nilsurplus_1_05_03< 0){ 
					 $aa1="("; $nilsurplus_1_05_03 = $nilsurplus_1_05_03*-1; $aa2=")";}  
					 else {
					 $aa1=""; $aa2="";}
					 
					if($angnilsurplus_1_05_03< 0){ 
					 $ba1="("; $angnilsurplus_1_05_03 = $angnilsurplus_1_05_03*-1; $ba2=")";}  
					 else {
					 $ba1=""; $ba2="";}
					 
					if($nilsurplus_1_06_01< 0){
					  $as1="("; $nilsurplus_1_06_01 = $nilsurplus_1_06_01*-1; $as2=")";}  
					  else {
					  $as1=""; $as2="";}
					  
					if($angnilsurplus_1_06_01< 0){
					  $bs1="("; $angnilsurplus_1_06_01 = $angnilsurplus_1_06_01*-1; $bs2=")";}
					  else {
					  $bs1=""; $bs2="";}
					  
					if($nilsurplus_2_02_01< 0){
					  $ad1="("; $nilsurplus_2_02_01 = $nilsurplus_2_02_01*-1; $ad2=")";}  
					  else { 
					  $ad1=""; $ad2="";}
					  
					if($angnilsurplus_2_02_01< 0){
					  $bd1="("; $angnilsurplus_2_02_01 = $angnilsurplus_2_02_01*-1; $bd2=")";}
					  else {
					  $bd1=""; $bd2="";}
					  
					if($nilsurplus_2_03_01< 0){
					  $af1="("; $nilsurplus_2_03_01 = $nilsurplus_2_03_01*-1; $af2=")";}
					  else {
					  $af1=""; $af2="";}
					  
					if($angnilsurplus_2_03_01< 0){
					  $bf1="("; $angnilsurplus_2_03_01 = $angnilsurplus_2_03_01*-1; $bf2=")";}  
					  else { 
					  $bf1=""; $bf2="";}
					  
					if($nilsurplus_2_05_01< 0){
					  $ag1="("; $nilsurplus_2_05_01 = $nilsurplus_2_05_01*-1; $ag2=")";}
					  else {
					  $ag1=""; $ag2="";}
					  
					if($angnilsurplus_2_05_01< 0){
					  $bg1="("; $angnilsurplus_2_05_01 = $angnilsurplus_2_05_01*-1; $bg2=")";}  
					  else {
					  $bg1=""; $bg2="";}
					  
					if($nilsurplus_2_06_01< 0){
					  $ah1="("; $nilsurplus_2_06_01 = $nilsurplus_2_06_01*-1; $ah2=")";}
					  else { 
					  $ah1=""; $ah2="";}
					  
					if($angnilsurplus_2_06_01< 0){
					  $bh1="("; $angnilsurplus_2_06_01 = $angnilsurplus_2_06_01*-1; $bh2=")";}  
					  else {
					  $bh1=""; $bh2="";}
					  
					if($nilsurplus_2_09_01< 0){ 
					$aj1="("; $nilsurplus_2_09_01 = $nilsurplus_2_09_01*-1; $aj2=")";} 
					 else { 
					 $aj1=""; $aj2="";}
					 
					if($angnilsurplus_2_09_01< 0){
					  $bj1="("; $angnilsurplus_2_09_01 = $angnilsurplus_2_09_01*-1; $bj2=")";}  
					  else {
					  $bj1=""; $bj2="";}
					  
					if($nilsurplus_2_10_01< 0){
					  $ak1="("; $nilsurplus_2_10_01 = $nilsurplus_2_10_01*-1; $ak2=")";}  
					  else { 
					  $ak1=""; $ak2="";}
					  
					if($angnilsurplus_2_10_01< 0){
					  $bk1="("; $angnilsurplus_2_10_01 = $angnilsurplus_2_10_01*-1; $bk2=")";}  
					  else {
					  $bk1=""; $bk2="";}
					  
					if($nilsurplus_2_11_01< 0){
					  $al1="("; $nilsurplus_2_11_01 = $nilsurplus_2_11_01*-1; $al2=")";} 
					  else {
					  $al1=""; $al2="";}
					  
					if($angnilsurplus_2_11_01< 0){ 
					 $bl1="("; $angnilsurplus_2_11_01 = $angnilsurplus_2_11_01*-1; $bl2=")";} 
					 else {
					 $bl1=""; $bl2="";}
					 
					if($nilsurplus_2_12_01< 0){ 
					 $aq1="("; $nilsurplus_2_12_01 = $nilsurplus_2_12_01*-1; $aq2=")";}  
					 else { 
					 $aq1=""; $aq2="";}
					 
					if($angnilsurplus_2_12_01< 0){ 
					 $bq1="("; $angnilsurplus_2_12_01 = $angnilsurplus_2_12_01*-1; $bq2=")";} 
					 else {
					 $bq1=""; $bq2="";}
					 
					if($nilsurplus_2_13_01< 0){
					  $aw1="("; $nilsurplus_2_13_01 = $nilsurplus_2_13_01*-1; $aw2=")";}
					  else {
					  $aw1=""; $aw2="";}
					  
					if($angnilsurplus_2_13_01< 0){
					  $bw1="("; $angnilsurplus_2_13_01 = $angnilsurplus_2_13_01*-1; $bw2=")";}
					  else {
					  $bw1=""; $bw2="";}
					  
					if($nilsurplus_2_17_01< 0){
					  $ae1="("; $nilsurplus_2_17_01 = $nilsurplus_2_17_01*-1; $ae2=")";}  
					  else { 
					  $ae1=""; $ae2="";}
					  
					if($angnilsurplus_2_17_01< 0){
					  $be1="("; $angnilsurplus_2_17_01 = $angnilsurplus_2_17_01*-1; $be2=")";}
					  else {
					  $be1=""; $be2="";}
					  
					if($nilsurplus_4_01_01< 0){
					  $ar1="("; $nilsurplus_4_01_01 = $nilsurplus_4_01_01*-1; $ar2=")";}
					  else {
					  $ar1=""; $ar2="";}
					  
					if($angnilsurplus_4_01_01< 0){
					  $br1="("; $angnilsurplus_4_01_01 = $angnilsurplus_4_01_01*-1; $br2=")";}
					  else {
					  $br1=""; $br2="";}
					  
					if($nilsurplus_4_02_01< 0){
					  $at1="("; $nilsurplus_4_02_01 = $nilsurplus_4_02_01*-1; $at2=")";}
					  else {
					  $at1=""; $at2="";}
					  
					if($angnilsurplus_4_02_01< 0){ 
					 $bt1="("; $angnilsurplus_4_02_01 = $angnilsurplus_4_02_01*-1; $bt2=")";} 
					 else {
					 $bt1=""; $bt2="";}
					 
					if($nilsurplus_4_02_02< 0){
					  $ay1="("; $nilsurplus_4_02_02 = $nilsurplus_4_02_02*-1; $ay2=")";} 
					  else { 
					  $ay1=""; $ay2="";}
					  
					if($angnilsurplus_4_02_02< 0){ 
					 $by1="("; $angnilsurplus_4_02_02 = $angnilsurplus_4_02_02*-1; $by2=")";} 
					 else { 
					 $by1=""; $by2="";}
					 
					if($nilsurplus_4_03_01< 0){ 
					 $au1="("; $nilsurplus_4_03_01 = $nilsurplus_4_03_01*-1; $au2=")";}
					 else {  
					 $au1=""; $au2="";}
					 
					if($angnilsurplus_4_03_01< 0){ 
					 $bu1="("; $angnilsurplus_4_03_01 = $angnilsurplus_4_03_01*-1; $bu2=")";}
					 else { 
					 $bu1=""; $bu2="";}
					 
					if($nilsurplus_4_05_01< 0){ 
					 $ai1="("; $nilsurplus_4_05_01 = $nilsurplus_4_05_01*-1; $ai2=")";} 
					 else {
					 $ai1=""; $ai2="";}
					 
					if($angnilsurplus_4_05_01< 0){ 
					 $bi1="("; $angnilsurplus_4_05_01 = $angnilsurplus_4_05_01*-1; $bi2=")";}
					 else { 
					 $bi1=""; $bi2="";}
					 
					if($nilsurplus_5_02_01< 0){ 
					 $ao1="("; $nilsurplus_5_02_01 = $nilsurplus_5_02_01*-1; $ao2=")";}
					 else {
					 $ao1=""; $ao2="";}
					 
					if($angnilsurplus_5_02_01< 0){
					  $bo1="("; $angnilsurplus_5_02_01 = $angnilsurplus_5_02_01*-1; $bo2=")";} 
					  else {  
					  $bo1=""; $bo2="";}
					  
					if($nilsurplus_5_01_01< 0){
					  $za1="("; $nilsurplus_5_01_01 = $nilsurplus_5_01_01*-1; $za2=")";}
					  else {
					  $za1=""; $za2="";}
					  
					if($angnilsurplus_5_01_01< 0){
					  $zb1="("; $angnilsurplus_5_01_01 = $angnilsurplus_5_01_01*-1; $zb2=")";}
					  else { 
					  $zb1=""; $zb2="";}
					  
					if($nilsurplus_4_06_01< 0){
					  $xa1="("; $nilsurplus_4_06_01 = $nilsurplus_4_06_01*-1; $xa2=")";}
					  else { 
					  $xa1=""; $xa2="";}
					  
					if($angnilsurplus_4_06_01< 0){
					  $xb1="("; $angnilsurplus_4_06_01 = $angnilsurplus_4_06_01*-1; $xb2=")";} 
					  else { 
					  $xb1=""; $xb2="";}
					  
					if($nilsurplus_4_08_01< 0){
					  $ca1="("; $nilsurplus_4_08_01 = $nilsurplus_4_08_01*-1; $ca2=")";} 
					  else { 
					  $ca1=""; $ca2="";}
					  
					if($angnilsurplus_4_08_01< 0){
					  $cb1="("; $angnilsurplus_4_08_01 = $angnilsurplus_4_08_01*-1; $cb2=")";} 
					  else {
					  $cb1=""; $cb2="";}
					  
					if($nilsurplus_4_08_02< 0){
					  $va1="("; $nilsurplus_4_08_02 = $nilsurplus_4_08_02*-1; $va2=")";}
					  else {
					  $va1=""; $va2="";}
					  
					if($angnilsurplus_4_08_02< 0){
					  $vb1="("; $angnilsurplus_4_08_02 = $angnilsurplus_4_08_02*-1; $vb2=")";}
					  else { 
					  $vb1=""; $vb2="";}
					  
					if($nilsurplus_4_08_03< 0){ 
					 $na1="("; $nilsurplus_4_08_03 = $nilsurplus_4_08_03*-1; $na2=")";}
					 else { 
					 $na1=""; $na2="";}
					 
					if($angnilsurplus_4_08_03< 0){
					  $nb1="("; $angnilsurplus_4_08_03 = $angnilsurplus_4_08_03*-1; $nb2=")";}
					  else {  
					  $nb1=""; $nb2="";}
					  
					if($nilsurplus_4_08_04< 0){
					  $ma1="("; $nilsurplus_4_08_04 = $nilsurplus_4_08_04*-1; $ma2=")";}
					  else {
					  $ma1=""; $ma2="";}
					  
					if($angnilsurplus_4_08_04< 0){ 
					 $mb1="("; $angnilsurplus_4_08_04 = $angnilsurplus_4_08_04*-1; $mb2=")";}
					 else {
					 $mb1=""; $mb2="";}
					 
					if($nilsurplus_4_08_05< 0){ 
					 $sa1="("; $nilsurplus_4_08_05 = $nilsurplus_4_08_05*-1; $sa2=")";} 
					 else { 
					 $sa1=""; $sa2="";}
					 
					if($angnilsurplus_4_08_05< 0){ 
					 $sb1="("; $angnilsurplus_4_08_05 = $angnilsurplus_4_08_05*-1; $sb2=")";} 
					 else { 
					 $sb1=""; $sb2="";}
					 
					if($nilsurplus_4_08_06< 0){ 
					 $da1="("; $nilsurplus_4_08_06 = $nilsurplus_4_08_06*-1; $da2=")";}
					 else {
					 $da1=""; $da2="";}
					 
					if($angnilsurplus_4_08_06< 0){ 
					 $db1="("; $angnilsurplus_4_08_06 = $angnilsurplus_4_08_06*-1; $db2=")";}
					 else { 
					 $db1=""; $db2="";}

                    $nilai    = number_format($nilsurplus,"2",".",",");
                    $angnilai = number_format($angnilsurplus,"2",".",",");
					$angnilai_1_01_01	= number_format($angnilsurplus_1_01_01,"2",".",",");
					$nilai_1_01_01	= number_format($nilsurplus_1_01_01,"2",".",",");
					$angnilai_1_02_01     =    number_format($angnilsurplus_1_02_01,"2",".",",");
					$nilai_1_02_01     =    number_format($nilsurplus_1_02_01,"2",".",",");
					$angnilai_1_03_01     =    number_format($angnilsurplus_1_03_01,"2",".",",");
					$nilai_1_03_01     =    number_format($nilsurplus_1_03_01,"2",".",",");
					$angnilai_1_04_01     =    number_format($angnilsurplus_1_04_01,"2",".",",");
					$nilai_1_04_01     =    number_format($nilsurplus_1_04_01,"2",".",",");
					$angnilai_1_05_01     =    number_format($angnilsurplus_1_05_01,"2",".",",");
					$nilai_1_05_01     =    number_format($nilsurplus_1_05_01,"2",".",",");
					$angnilai_1_05_02     =    number_format($angnilsurplus_1_05_02,"2",".",",");
					$nilai_1_05_02     =    number_format($nilsurplus_1_05_02,"2",".",",");
					$angnilai_1_05_03     =    number_format($angnilsurplus_1_05_03,"2",".",",");
					$nilai_1_05_03     =    number_format($nilsurplus_1_05_03,"2",".",",");
					$angnilai_1_06_01     =    number_format($angnilsurplus_1_06_01,"2",".",",");
					$nilai_1_06_01     =    number_format($nilsurplus_1_06_01,"2",".",",");
					$angnilai_2_02_01     =    number_format($angnilsurplus_2_02_01,"2",".",",");
					$nilai_2_02_01     =    number_format($nilsurplus_2_02_01,"2",".",",");
					$angnilai_2_03_01     =    number_format($angnilsurplus_2_03_01,"2",".",",");
					$nilai_2_03_01     =    number_format($nilsurplus_2_03_01,"2",".",",");
					$angnilai_2_05_01     =    number_format($angnilsurplus_2_05_01,"2",".",",");
					$nilai_2_05_01     =    number_format($nilsurplus_2_05_01,"2",".",",");
					$angnilai_2_06_01     =    number_format($angnilsurplus_2_06_01,"2",".",",");
					$nilai_2_06_01     =    number_format($nilsurplus_2_06_01,"2",".",",");
					$angnilai_2_09_01     =    number_format($angnilsurplus_2_09_01,"2",".",",");
					$nilai_2_09_01     =    number_format($nilsurplus_2_09_01,"2",".",",");
					$angnilai_2_10_01     =    number_format($angnilsurplus_2_10_01,"2",".",",");
					$nilai_2_10_01     =    number_format($nilsurplus_2_10_01,"2",".",",");
					$angnilai_2_11_01     =    number_format($angnilsurplus_2_11_01,"2",".",",");
					$nilai_2_11_01     =    number_format($nilsurplus_2_11_01,"2",".",",");
					$angnilai_2_12_01     =    number_format($angnilsurplus_2_12_01,"2",".",",");
					$nilai_2_12_01     =    number_format($nilsurplus_2_12_01,"2",".",",");
					$angnilai_2_13_01     =    number_format($angnilsurplus_2_13_01,"2",".",",");
					$nilai_2_13_01     =    number_format($nilsurplus_2_13_01,"2",".",",");
					$angnilai_2_17_01     =    number_format($angnilsurplus_2_17_01,"2",".",",");
					$nilai_2_17_01     =    number_format($nilsurplus_2_17_01,"2",".",",");
					$angnilai_4_01_01     =    number_format($angnilsurplus_4_01_01,"2",".",",");
					$nilai_4_01_01     =    number_format($nilsurplus_4_01_01,"2",".",",");
					$angnilai_4_02_01     =    number_format($angnilsurplus_4_02_01,"2",".",",");
					$nilai_4_02_01     =    number_format($nilsurplus_4_02_01,"2",".",",");
					$angnilai_4_02_02     =    number_format($angnilsurplus_4_02_02,"2",".",",");
					$nilai_4_02_02     =    number_format($nilsurplus_4_02_02,"2",".",",");
					$angnilai_4_03_01     =    number_format($angnilsurplus_4_03_01,"2",".",",");
					$nilai_4_03_01     =    number_format($nilsurplus_4_03_01,"2",".",",");
					$angnilai_4_05_01     =    number_format($angnilsurplus_4_05_01,"2",".",",");
					$nilai_4_05_01     =    number_format($nilsurplus_4_05_01,"2",".",",");
					$angnilai_5_02_01     =    number_format($angnilsurplus_5_02_01,"2",".",",");
					$nilai_5_02_01     =    number_format($nilsurplus_5_02_01,"2",".",",");
					$angnilai_5_01_01     =    number_format($angnilsurplus_5_01_01,"2",".",",");
					$nilai_5_01_01     =    number_format($nilsurplus_5_01_01,"2",".",",");
					$angnilai_4_06_01     =    number_format($angnilsurplus_4_06_01,"2",".",",");
					$nilai_4_06_01     =    number_format($nilsurplus_4_06_01,"2",".",",");
					$angnilai_4_08_01     =    number_format($angnilsurplus_4_08_01,"2",".",",");
					$nilai_4_08_01     =    number_format($nilsurplus_4_08_01,"2",".",",");
					$angnilai_4_08_02     =    number_format($angnilsurplus_4_08_02,"2",".",",");
					$nilai_4_08_02     =    number_format($nilsurplus_4_08_02,"2",".",",");
					$angnilai_4_08_03     =    number_format($angnilsurplus_4_08_03,"2",".",",");
					$nilai_4_08_03     =    number_format($nilsurplus_4_08_03,"2",".",",");
					$angnilai_4_08_04     =    number_format($angnilsurplus_4_08_04,"2",".",",");
					$nilai_4_08_04     =    number_format($nilsurplus_4_08_04,"2",".",",");
					$angnilai_4_08_05     =    number_format($angnilsurplus_4_08_05,"2",".",",");
					$nilai_4_08_05     =    number_format($nilsurplus_4_08_05,"2",".",",");
					$angnilai_4_08_06     =    number_format($angnilsurplus_4_08_06,"2",".",",");
					$nilai_4_08_06     =    number_format($nilsurplus_4_08_06,"2",".",",");
                   
                   $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$axz1$angnilai$axz2</b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$bxz1$nilai$bxz2</b></td>
									 <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$bzx1$angnilai_1_01_01$bzx2</b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$azx1$nilai_1_01_01$azx2</b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$bc1$angnilai_1_02_01$bc2</b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$ac1$nilai_1_02_01$ac2</b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$bv1$angnilai_1_03_01$bv2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$av1$nilai_1_03_01$av2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$bb1$angnilai_1_04_01$bb2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$ab1$nilai_1_04_01$ab2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$bn1$angnilai_1_05_01$bn2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$an1$nilai_1_05_01$an2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$bm1$angnilai_1_05_02$bm2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$am1$nilai_1_05_02$am2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$ba1$angnilai_1_05_03$ba2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$aa1$nilai_1_05_03$aa2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$bs1$angnilai_1_06_01$bs2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$as1$nilai_1_06_01$as2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$bd1$angnilai_2_02_01$bd2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$ad1$nilai_2_02_01$ad2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$bf1$angnilai_2_03_01$bf2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$af1$nilai_2_03_01$af2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$bg1$angnilai_2_05_01$bg2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$ag1$nilai_2_05_01$ag2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$bh1$angnilai_2_06_01$bh2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$ah1$nilai_2_06_01$ah2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$bj1$angnilai_2_09_01$bj2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$aj1$nilai_2_09_01$aj2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$bk1$angnilai_2_10_01$bk2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$ak1$nilai_2_10_01$ak2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$bl1$angnilai_2_11_01$bl2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$al1$nilai_2_11_01$al2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$bq1$angnilai_2_12_01$bq2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$aq1$nilai_2_12_01$aq2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$bw1$angnilai_2_13_01$bw2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$aw1$nilai_2_13_01$aw2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$be1$angnilai_2_17_01$be2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$ae1$nilai_2_17_01$ae2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$br1$angnilai_4_01_01$br2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$ar1$nilai_4_01_01$ar2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$bt1$angnilai_4_02_01$bt2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$at1$nilai_4_02_01$at2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$by1$angnilai_4_02_02$by2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$ay1$nilai_4_02_02$ay2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$bu1$angnilai_4_03_01$bu2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$au1$nilai_4_03_01$au2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$bi1$angnilai_4_05_01$bi2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$ai1$nilai_4_05_01$ai2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$bo1$angnilai_5_02_01$bo2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$ao1$nilai_5_02_01$ao2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$zb1$angnilai_5_01_01$zb2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$za1$nilai_5_01_01$za2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$xb1$angnilai_4_06_01$xb2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$xa1$nilai_4_06_01$xa2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$cb1$angnilai_4_08_01$cb2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$ca1$nilai_4_08_01$ca2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$vb1$angnilai_4_08_02$vb2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$va1$nilai_4_08_02$va2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nb1$angnilai_4_08_03$nb2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$na1$nilai_4_08_03$na2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$mb1$angnilai_4_08_04$mb2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$ma1$nilai_4_08_04$ma2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$sb1$angnilai_4_08_05$sb2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$sa1$nilai_4_08_05$sa2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$db1$angnilai_4_08_06$db2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$da1$nilai_4_08_06$da2<b></td>
                                 </tr>";        								 


								 
					$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                 </tr>";								 
								 
					$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>7</b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>PEMBIAYAAN</b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                 </tr>";
					
		$sql4="
                select z.kode,z.nama,z.anggaran,z.reali,z.anggaran_1_01_01,
				z.reali_1_01_01,
				z.anggaran_1_02_01,
				z.reali_1_02_01,
				z.anggaran_1_03_01,
				z.reali_1_03_01,
				z.anggaran_1_04_01,
				z.reali_1_04_01,
				z.anggaran_1_05_01,
				z.reali_1_05_01,
				z.anggaran_1_05_02,
				z.reali_1_05_02,
				z.anggaran_1_05_03,
				z.reali_1_05_03,
				z.anggaran_1_06_01,
				z.reali_1_06_01,
				z.anggaran_2_02_01,
				z.reali_2_02_01,
				z.anggaran_2_03_01,
				z.reali_2_03_01,
				z.anggaran_2_05_01,
				z.reali_2_05_01,
				z.anggaran_2_06_01,
				z.reali_2_06_01,
				z.anggaran_2_09_01,
				z.reali_2_09_01,
				z.anggaran_2_10_01,
				z.reali_2_10_01,
				z.anggaran_2_11_01,
				z.reali_2_11_01,
				z.anggaran_2_12_01,
				z.reali_2_12_01,
				z.anggaran_2_13_01,
				z.reali_2_13_01,
				z.anggaran_2_17_01,
				z.reali_2_17_01,
				z.anggaran_4_01_01,
				z.reali_4_01_01,
				z.anggaran_4_02_01,
				z.reali_4_02_01,
				z.anggaran_4_02_02,
				z.reali_4_02_02,
				z.anggaran_4_03_01,
				z.reali_4_03_01,
				z.anggaran_4_05_01,
				z.reali_4_05_01,
				z.anggaran_5_02_01,
				z.reali_5_02_01,
				z.anggaran_5_01_01,
				z.reali_5_01_01,
				z.anggaran_4_06_01,
				z.reali_4_06_01,
				z.anggaran_4_08_01,
				z.reali_4_08_01,
				z.anggaran_4_08_02,
				z.reali_4_08_02,
				z.anggaran_4_08_03,
				z.reali_4_08_03,
				z.anggaran_4_08_04,
				z.reali_4_08_04,
				z.anggaran_4_08_05,
				z.reali_4_08_05,
				z.anggaran_4_08_06,
				z.reali_4_08_06 from (
                SELECT left(a.kd_rek5,2) as kode,b.nm_rek2 as nama,sum(a.nilai_angg) as anggaran,sum(a.nilai_real) as reali,
				sum(nilai_ang_1_01_01) as anggaran_1_01_01,
				sum(nilai_real_1_01_01) as reali_1_01_01,
				sum(nilai_ang_1_02_01) as anggaran_1_02_01,
				sum(nilai_real_1_02_01) as reali_1_02_01,
				sum(nilai_ang_1_03_01) as anggaran_1_03_01,
				sum(nilai_real_1_03_01) as reali_1_03_01,
				sum(nilai_ang_1_04_01) as anggaran_1_04_01,
				sum(nilai_real_1_04_01) as reali_1_04_01,
				sum(nilai_ang_1_05_01) as anggaran_1_05_01,
				sum(nilai_real_1_05_01) as reali_1_05_01,
				sum(nilai_ang_1_05_02) as anggaran_1_05_02,
				sum(nilai_real_1_05_02) as reali_1_05_02,
				sum(nilai_ang_1_05_03) as anggaran_1_05_03,
				sum(nilai_real_1_05_03) as reali_1_05_03,
				sum(nilai_ang_1_06_01) as anggaran_1_06_01,
				sum(nilai_real_1_06_01) as reali_1_06_01,
				sum(nilai_ang_2_02_01) as anggaran_2_02_01,
				sum(nilai_real_2_02_01) as reali_2_02_01,
				sum(nilai_ang_2_03_01) as anggaran_2_03_01,
				sum(nilai_real_2_03_01) as reali_2_03_01,
				sum(nilai_ang_2_05_01) as anggaran_2_05_01,
				sum(nilai_real_2_05_01) as reali_2_05_01,
				sum(nilai_ang_2_06_01) as anggaran_2_06_01,
				sum(nilai_real_2_06_01) as reali_2_06_01,
				sum(nilai_ang_2_09_01) as anggaran_2_09_01,
				sum(nilai_real_2_09_01) as reali_2_09_01,
				sum(nilai_ang_2_10_01) as anggaran_2_10_01,
				sum(nilai_real_2_10_01) as reali_2_10_01,
				sum(nilai_ang_2_11_01) as anggaran_2_11_01,
				sum(nilai_real_2_11_01) as reali_2_11_01,
				sum(nilai_ang_2_12_01) as anggaran_2_12_01,
				sum(nilai_real_2_12_01) as reali_2_12_01,
				sum(nilai_ang_2_13_01) as anggaran_2_13_01,
				sum(nilai_real_2_13_01) as reali_2_13_01,
				sum(nilai_ang_2_17_01) as anggaran_2_17_01,
				sum(nilai_real_2_17_01) as reali_2_17_01,
				sum(nilai_ang_4_01_01) as anggaran_4_01_01,
				sum(nilai_real_4_01_01) as reali_4_01_01,
				sum(nilai_ang_4_02_01) as anggaran_4_02_01,
				sum(nilai_real_4_02_01) as reali_4_02_01,
				sum(nilai_ang_4_02_02) as anggaran_4_02_02,
				sum(nilai_real_4_02_02) as reali_4_02_02,
				sum(nilai_ang_4_03_01) as anggaran_4_03_01,
				sum(nilai_real_4_03_01) as reali_4_03_01,
				sum(nilai_ang_4_05_01) as anggaran_4_05_01,
				sum(nilai_real_4_05_01) as reali_4_05_01,
				sum(nilai_ang_5_02_01) as anggaran_5_02_01,
				sum(nilai_real_5_02_01) as reali_5_02_01,
				sum(nilai_ang_5_01_01) as anggaran_5_01_01,
				sum(nilai_real_5_01_01) as reali_5_01_01,
				sum(nilai_ang_4_06_01) as anggaran_4_06_01,
				sum(nilai_real_4_06_01) as reali_4_06_01,
				sum(nilai_ang_4_08_01) as anggaran_4_08_01,
				sum(nilai_real_4_08_01) as reali_4_08_01,
				sum(nilai_ang_4_08_02) as anggaran_4_08_02,
				sum(nilai_real_4_08_02) as reali_4_08_02,
				sum(nilai_ang_4_08_03) as anggaran_4_08_03,
				sum(nilai_real_4_08_03) as reali_4_08_03,
				sum(nilai_ang_4_08_04) as anggaran_4_08_04,
				sum(nilai_real_4_08_04) as reali_4_08_04,
				sum(nilai_ang_4_08_05) as anggaran_4_08_05,
				sum(nilai_real_4_08_05) as reali_4_08_05,
				sum(nilai_ang_4_08_06) as anggaran_4_08_06,
				sum(nilai_real_4_08_06) as reali_4_08_06 FROM realisasi_rekap_opd( $bulan,$anggaran,$lntahunang) a
                inner join ms_rek2_64 b on b.kd_rek2 = left(a.kd_rek5,2)                
                where left(a.kd_rek5,2)='71' 
                group by left(a.kd_rek5,2),b.nm_rek2
                union all
                SELECT left(a.kd_rek5,3) as kode,b.nm_rek3 as nama,sum(a.nilai_angg) as anggaran,sum(a.nilai_real) as reali,
				sum(nilai_ang_1_01_01) as anggaran_1_01_01,
				sum(nilai_real_1_01_01) as reali_1_01_01,
				sum(nilai_ang_1_02_01) as anggaran_1_02_01,
				sum(nilai_real_1_02_01) as reali_1_02_01,
				sum(nilai_ang_1_03_01) as anggaran_1_03_01,
				sum(nilai_real_1_03_01) as reali_1_03_01,
				sum(nilai_ang_1_04_01) as anggaran_1_04_01,
				sum(nilai_real_1_04_01) as reali_1_04_01,
				sum(nilai_ang_1_05_01) as anggaran_1_05_01,
				sum(nilai_real_1_05_01) as reali_1_05_01,
				sum(nilai_ang_1_05_02) as anggaran_1_05_02,
				sum(nilai_real_1_05_02) as reali_1_05_02,
				sum(nilai_ang_1_05_03) as anggaran_1_05_03,
				sum(nilai_real_1_05_03) as reali_1_05_03,
				sum(nilai_ang_1_06_01) as anggaran_1_06_01,
				sum(nilai_real_1_06_01) as reali_1_06_01,
				sum(nilai_ang_2_02_01) as anggaran_2_02_01,
				sum(nilai_real_2_02_01) as reali_2_02_01,
				sum(nilai_ang_2_03_01) as anggaran_2_03_01,
				sum(nilai_real_2_03_01) as reali_2_03_01,
				sum(nilai_ang_2_05_01) as anggaran_2_05_01,
				sum(nilai_real_2_05_01) as reali_2_05_01,
				sum(nilai_ang_2_06_01) as anggaran_2_06_01,
				sum(nilai_real_2_06_01) as reali_2_06_01,
				sum(nilai_ang_2_09_01) as anggaran_2_09_01,
				sum(nilai_real_2_09_01) as reali_2_09_01,
				sum(nilai_ang_2_10_01) as anggaran_2_10_01,
				sum(nilai_real_2_10_01) as reali_2_10_01,
				sum(nilai_ang_2_11_01) as anggaran_2_11_01,
				sum(nilai_real_2_11_01) as reali_2_11_01,
				sum(nilai_ang_2_12_01) as anggaran_2_12_01,
				sum(nilai_real_2_12_01) as reali_2_12_01,
				sum(nilai_ang_2_13_01) as anggaran_2_13_01,
				sum(nilai_real_2_13_01) as reali_2_13_01,
				sum(nilai_ang_2_17_01) as anggaran_2_17_01,
				sum(nilai_real_2_17_01) as reali_2_17_01,
				sum(nilai_ang_4_01_01) as anggaran_4_01_01,
				sum(nilai_real_4_01_01) as reali_4_01_01,
				sum(nilai_ang_4_02_01) as anggaran_4_02_01,
				sum(nilai_real_4_02_01) as reali_4_02_01,
				sum(nilai_ang_4_02_02) as anggaran_4_02_02,
				sum(nilai_real_4_02_02) as reali_4_02_02,
				sum(nilai_ang_4_03_01) as anggaran_4_03_01,
				sum(nilai_real_4_03_01) as reali_4_03_01,
				sum(nilai_ang_4_05_01) as anggaran_4_05_01,
				sum(nilai_real_4_05_01) as reali_4_05_01,
				sum(nilai_ang_5_02_01) as anggaran_5_02_01,
				sum(nilai_real_5_02_01) as reali_5_02_01,
				sum(nilai_ang_5_01_01) as anggaran_5_01_01,
				sum(nilai_real_5_01_01) as reali_5_01_01,
				sum(nilai_ang_4_06_01) as anggaran_4_06_01,
				sum(nilai_real_4_06_01) as reali_4_06_01,
				sum(nilai_ang_4_08_01) as anggaran_4_08_01,
				sum(nilai_real_4_08_01) as reali_4_08_01,
				sum(nilai_ang_4_08_02) as anggaran_4_08_02,
				sum(nilai_real_4_08_02) as reali_4_08_02,
				sum(nilai_ang_4_08_03) as anggaran_4_08_03,
				sum(nilai_real_4_08_03) as reali_4_08_03,
				sum(nilai_ang_4_08_04) as anggaran_4_08_04,
				sum(nilai_real_4_08_04) as reali_4_08_04,
				sum(nilai_ang_4_08_05) as anggaran_4_08_05,
				sum(nilai_real_4_08_05) as reali_4_08_05,
				sum(nilai_ang_4_08_06) as anggaran_4_08_06,
				sum(nilai_real_4_08_06) as reali_4_08_06 FROM realisasi_rekap_opd( $bulan,$anggaran,$lntahunang) a
                inner join ms_rek3_64 b on b.kd_rek3 = left(a.kd_rek5,3)                
                where left(a.kd_rek5,2)='71' 
                group by left(a.kd_rek5,3),b.nm_rek3
                union all
                SELECT left(a.kd_rek5,5) as kode,b.nm_rek4_64 as nama,sum(a.nilai_angg) as anggaran,sum(a.nilai_real) as reali,
				sum(nilai_ang_1_01_01) as anggaran_1_01_01,
				sum(nilai_real_1_01_01) as reali_1_01_01,
				sum(nilai_ang_1_02_01) as anggaran_1_02_01,
				sum(nilai_real_1_02_01) as reali_1_02_01,
				sum(nilai_ang_1_03_01) as anggaran_1_03_01,
				sum(nilai_real_1_03_01) as reali_1_03_01,
				sum(nilai_ang_1_04_01) as anggaran_1_04_01,
				sum(nilai_real_1_04_01) as reali_1_04_01,
				sum(nilai_ang_1_05_01) as anggaran_1_05_01,
				sum(nilai_real_1_05_01) as reali_1_05_01,
				sum(nilai_ang_1_05_02) as anggaran_1_05_02,
				sum(nilai_real_1_05_02) as reali_1_05_02,
				sum(nilai_ang_1_05_03) as anggaran_1_05_03,
				sum(nilai_real_1_05_03) as reali_1_05_03,
				sum(nilai_ang_1_06_01) as anggaran_1_06_01,
				sum(nilai_real_1_06_01) as reali_1_06_01,
				sum(nilai_ang_2_02_01) as anggaran_2_02_01,
				sum(nilai_real_2_02_01) as reali_2_02_01,
				sum(nilai_ang_2_03_01) as anggaran_2_03_01,
				sum(nilai_real_2_03_01) as reali_2_03_01,
				sum(nilai_ang_2_05_01) as anggaran_2_05_01,
				sum(nilai_real_2_05_01) as reali_2_05_01,
				sum(nilai_ang_2_06_01) as anggaran_2_06_01,
				sum(nilai_real_2_06_01) as reali_2_06_01,
				sum(nilai_ang_2_09_01) as anggaran_2_09_01,
				sum(nilai_real_2_09_01) as reali_2_09_01,
				sum(nilai_ang_2_10_01) as anggaran_2_10_01,
				sum(nilai_real_2_10_01) as reali_2_10_01,
				sum(nilai_ang_2_11_01) as anggaran_2_11_01,
				sum(nilai_real_2_11_01) as reali_2_11_01,
				sum(nilai_ang_2_12_01) as anggaran_2_12_01,
				sum(nilai_real_2_12_01) as reali_2_12_01,
				sum(nilai_ang_2_13_01) as anggaran_2_13_01,
				sum(nilai_real_2_13_01) as reali_2_13_01,
				sum(nilai_ang_2_17_01) as anggaran_2_17_01,
				sum(nilai_real_2_17_01) as reali_2_17_01,
				sum(nilai_ang_4_01_01) as anggaran_4_01_01,
				sum(nilai_real_4_01_01) as reali_4_01_01,
				sum(nilai_ang_4_02_01) as anggaran_4_02_01,
				sum(nilai_real_4_02_01) as reali_4_02_01,
				sum(nilai_ang_4_02_02) as anggaran_4_02_02,
				sum(nilai_real_4_02_02) as reali_4_02_02,
				sum(nilai_ang_4_03_01) as anggaran_4_03_01,
				sum(nilai_real_4_03_01) as reali_4_03_01,
				sum(nilai_ang_4_05_01) as anggaran_4_05_01,
				sum(nilai_real_4_05_01) as reali_4_05_01,
				sum(nilai_ang_5_02_01) as anggaran_5_02_01,
				sum(nilai_real_5_02_01) as reali_5_02_01,
				sum(nilai_ang_5_01_01) as anggaran_5_01_01,
				sum(nilai_real_5_01_01) as reali_5_01_01,
				sum(nilai_ang_4_06_01) as anggaran_4_06_01,
				sum(nilai_real_4_06_01) as reali_4_06_01,
				sum(nilai_ang_4_08_01) as anggaran_4_08_01,
				sum(nilai_real_4_08_01) as reali_4_08_01,
				sum(nilai_ang_4_08_02) as anggaran_4_08_02,
				sum(nilai_real_4_08_02) as reali_4_08_02,
				sum(nilai_ang_4_08_03) as anggaran_4_08_03,
				sum(nilai_real_4_08_03) as reali_4_08_03,
				sum(nilai_ang_4_08_04) as anggaran_4_08_04,
				sum(nilai_real_4_08_04) as reali_4_08_04,
				sum(nilai_ang_4_08_05) as anggaran_4_08_05,
				sum(nilai_real_4_08_05) as reali_4_08_05,
				sum(nilai_ang_4_08_06) as anggaran_4_08_06,
				sum(nilai_real_4_08_06) as reali_4_08_06 FROM realisasi_rekap_opd( $bulan,$anggaran,$lntahunang) a
                inner join ms_rek4_64 b on b.kd_rek4_64 = left(a.kd_rek5,5)                
                where left(a.kd_rek5,2)='71'
                group by left(a.kd_rek5,5),b.nm_rek4_64
                union all
                SELECT a.kd_rek5 as kode,b.nm_rek64 as nama,sum(a.nilai_angg) as anggaran,sum(a.nilai_real) as reali,
				sum(nilai_ang_1_01_01) as anggaran_1_01_01,
				sum(nilai_real_1_01_01) as reali_1_01_01,
				sum(nilai_ang_1_02_01) as anggaran_1_02_01,
				sum(nilai_real_1_02_01) as reali_1_02_01,
				sum(nilai_ang_1_03_01) as anggaran_1_03_01,
				sum(nilai_real_1_03_01) as reali_1_03_01,
				sum(nilai_ang_1_04_01) as anggaran_1_04_01,
				sum(nilai_real_1_04_01) as reali_1_04_01,
				sum(nilai_ang_1_05_01) as anggaran_1_05_01,
				sum(nilai_real_1_05_01) as reali_1_05_01,
				sum(nilai_ang_1_05_02) as anggaran_1_05_02,
				sum(nilai_real_1_05_02) as reali_1_05_02,
				sum(nilai_ang_1_05_03) as anggaran_1_05_03,
				sum(nilai_real_1_05_03) as reali_1_05_03,
				sum(nilai_ang_1_06_01) as anggaran_1_06_01,
				sum(nilai_real_1_06_01) as reali_1_06_01,
				sum(nilai_ang_2_02_01) as anggaran_2_02_01,
				sum(nilai_real_2_02_01) as reali_2_02_01,
				sum(nilai_ang_2_03_01) as anggaran_2_03_01,
				sum(nilai_real_2_03_01) as reali_2_03_01,
				sum(nilai_ang_2_05_01) as anggaran_2_05_01,
				sum(nilai_real_2_05_01) as reali_2_05_01,
				sum(nilai_ang_2_06_01) as anggaran_2_06_01,
				sum(nilai_real_2_06_01) as reali_2_06_01,
				sum(nilai_ang_2_09_01) as anggaran_2_09_01,
				sum(nilai_real_2_09_01) as reali_2_09_01,
				sum(nilai_ang_2_10_01) as anggaran_2_10_01,
				sum(nilai_real_2_10_01) as reali_2_10_01,
				sum(nilai_ang_2_11_01) as anggaran_2_11_01,
				sum(nilai_real_2_11_01) as reali_2_11_01,
				sum(nilai_ang_2_12_01) as anggaran_2_12_01,
				sum(nilai_real_2_12_01) as reali_2_12_01,
				sum(nilai_ang_2_13_01) as anggaran_2_13_01,
				sum(nilai_real_2_13_01) as reali_2_13_01,
				sum(nilai_ang_2_17_01) as anggaran_2_17_01,
				sum(nilai_real_2_17_01) as reali_2_17_01,
				sum(nilai_ang_4_01_01) as anggaran_4_01_01,
				sum(nilai_real_4_01_01) as reali_4_01_01,
				sum(nilai_ang_4_02_01) as anggaran_4_02_01,
				sum(nilai_real_4_02_01) as reali_4_02_01,
				sum(nilai_ang_4_02_02) as anggaran_4_02_02,
				sum(nilai_real_4_02_02) as reali_4_02_02,
				sum(nilai_ang_4_03_01) as anggaran_4_03_01,
				sum(nilai_real_4_03_01) as reali_4_03_01,
				sum(nilai_ang_4_05_01) as anggaran_4_05_01,
				sum(nilai_real_4_05_01) as reali_4_05_01,
				sum(nilai_ang_5_02_01) as anggaran_5_02_01,
				sum(nilai_real_5_02_01) as reali_5_02_01,
				sum(nilai_ang_5_01_01) as anggaran_5_01_01,
				sum(nilai_real_5_01_01) as reali_5_01_01,
				sum(nilai_ang_4_06_01) as anggaran_4_06_01,
				sum(nilai_real_4_06_01) as reali_4_06_01,
				sum(nilai_ang_4_08_01) as anggaran_4_08_01,
				sum(nilai_real_4_08_01) as reali_4_08_01,
				sum(nilai_ang_4_08_02) as anggaran_4_08_02,
				sum(nilai_real_4_08_02) as reali_4_08_02,
				sum(nilai_ang_4_08_03) as anggaran_4_08_03,
				sum(nilai_real_4_08_03) as reali_4_08_03,
				sum(nilai_ang_4_08_04) as anggaran_4_08_04,
				sum(nilai_real_4_08_04) as reali_4_08_04,
				sum(nilai_ang_4_08_05) as anggaran_4_08_05,
				sum(nilai_real_4_08_05) as reali_4_08_05,
				sum(nilai_ang_4_08_06) as anggaran_4_08_06,
				sum(nilai_real_4_08_06) as reali_4_08_06 FROM realisasi_rekap_opd( $bulan,$anggaran,$lntahunang) a
                inner join ms_rek5 b on b.kd_rek64 = a.kd_rek5                             
                where left(a.kd_rek5,2)='71'
                group by a.kd_rek5,b.nm_rek64
                )z order by kode,nama
                ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil    = $row4->reali;
					$angnil = $row4->anggaran;
					$angnil_1_01_01  = $row4->anggaran_1_01_01;
					$nil_1_01_01  = $row4->reali_1_01_01;
					$angnil_1_02_01  = $row4->anggaran_1_02_01;
					$nil_1_02_01  = $row4->reali_1_02_01;
					$angnil_1_03_01  = $row4->anggaran_1_03_01;
					$nil_1_03_01  = $row4->reali_1_03_01;
					$angnil_1_04_01  = $row4->anggaran_1_04_01;
					$nil_1_04_01  = $row4->reali_1_04_01;
					$angnil_1_05_01  = $row4->anggaran_1_05_01;
					$nil_1_05_01  = $row4->reali_1_05_01;
					$angnil_1_05_02  = $row4->anggaran_1_05_02;
					$nil_1_05_02  = $row4->reali_1_05_02;
					$angnil_1_05_03  = $row4->anggaran_1_05_03;
					$nil_1_05_03  = $row4->reali_1_05_03;
					$angnil_1_06_01  = $row4->anggaran_1_06_01;
					$nil_1_06_01  = $row4->reali_1_06_01;
					$angnil_2_02_01  = $row4->anggaran_2_02_01;
					$nil_2_02_01  = $row4->reali_2_02_01;
					$angnil_2_03_01  = $row4->anggaran_2_03_01;
					$nil_2_03_01  = $row4->reali_2_03_01;
					$angnil_2_05_01  = $row4->anggaran_2_05_01;
					$nil_2_05_01  = $row4->reali_2_05_01;
					$angnil_2_06_01  = $row4->anggaran_2_06_01;
					$nil_2_06_01  = $row4->reali_2_06_01;
					$angnil_2_09_01  = $row4->anggaran_2_09_01;
					$nil_2_09_01  = $row4->reali_2_09_01;
					$angnil_2_10_01  = $row4->anggaran_2_10_01;
					$nil_2_10_01  = $row4->reali_2_10_01;
					$angnil_2_11_01  = $row4->anggaran_2_11_01;
					$nil_2_11_01  = $row4->reali_2_11_01;
					$angnil_2_12_01  = $row4->anggaran_2_12_01;
					$nil_2_12_01  = $row4->reali_2_12_01;
					$angnil_2_13_01  = $row4->anggaran_2_13_01;
					$nil_2_13_01  = $row4->reali_2_13_01;
					$angnil_2_17_01  = $row4->anggaran_2_17_01;
					$nil_2_17_01  = $row4->reali_2_17_01;
					$angnil_4_01_01  = $row4->anggaran_4_01_01;
					$nil_4_01_01  = $row4->reali_4_01_01;
					$angnil_4_02_01  = $row4->anggaran_4_02_01;
					$nil_4_02_01  = $row4->reali_4_02_01;
					$angnil_4_02_02  = $row4->anggaran_4_02_02;
					$nil_4_02_02  = $row4->reali_4_02_02;
					$angnil_4_03_01  = $row4->anggaran_4_03_01;
					$nil_4_03_01  = $row4->reali_4_03_01;
					$angnil_4_05_01  = $row4->anggaran_4_05_01;
					$nil_4_05_01  = $row4->reali_4_05_01;
					$angnil_5_02_01  = $row4->anggaran_5_02_01;
					$nil_5_02_01  = $row4->reali_5_02_01;
					$angnil_5_01_01  = $row4->anggaran_5_01_01;
					$nil_5_01_01  = $row4->reali_5_01_01;
					$angnil_4_06_01  = $row4->anggaran_4_06_01;
					$nil_4_06_01  = $row4->reali_4_06_01;
					$angnil_4_08_01  = $row4->anggaran_4_08_01;
					$nil_4_08_01  = $row4->reali_4_08_01;
					$angnil_4_08_02  = $row4->anggaran_4_08_02;
					$nil_4_08_02  = $row4->reali_4_08_02;
					$angnil_4_08_03  = $row4->anggaran_4_08_03;
					$nil_4_08_03  = $row4->reali_4_08_03;
					$angnil_4_08_04  = $row4->anggaran_4_08_04;
					$nil_4_08_04  = $row4->reali_4_08_04;
					$angnil_4_08_05  = $row4->anggaran_4_08_05;
					$nil_4_08_05  = $row4->reali_4_08_05;
					$angnil_4_08_06  = $row4->anggaran_4_08_06;
					$nil_4_08_06  = $row4->reali_4_08_06;
					
					
					$angnilai  =  number_format($angnil,"2",".",",");
					$nilai  =  number_format($nil,"2",".",",");
					$angnil_1_01_01  =  number_format($angnil_1_01_01,"2",".",",");
					$nil_1_01_01  =  number_format($nil_1_01_01,"2",".",",");
					$angnil_1_02_01  =  number_format($angnil_1_02_01,"2",".",",");
					$nil_1_02_01  =  number_format($nil_1_02_01,"2",".",",");
					$angnil_1_03_01  =  number_format($angnil_1_03_01,"2",".",",");
					$nil_1_03_01  =  number_format($nil_1_03_01,"2",".",",");
					$angnil_1_04_01  =  number_format($angnil_1_04_01,"2",".",",");
					$nil_1_04_01  =  number_format($nil_1_04_01,"2",".",",");
					$angnil_1_05_01  =  number_format($angnil_1_05_01,"2",".",",");
					$nil_1_05_01  =  number_format($nil_1_05_01,"2",".",",");
					$angnil_1_05_02  =  number_format($angnil_1_05_02,"2",".",",");
					$nil_1_05_02  =  number_format($nil_1_05_02,"2",".",",");
					$angnil_1_05_03  =  number_format($angnil_1_05_03,"2",".",",");
					$nil_1_05_03  =  number_format($nil_1_05_03,"2",".",",");
					$angnil_1_06_01  =  number_format($angnil_1_06_01,"2",".",",");
					$nil_1_06_01  =  number_format($nil_1_06_01,"2",".",",");
					$angnil_2_02_01  =  number_format($angnil_2_02_01,"2",".",",");
					$nil_2_02_01  =  number_format($nil_2_02_01,"2",".",",");
					$angnil_2_03_01  =  number_format($angnil_2_03_01,"2",".",",");
					$nil_2_03_01  =  number_format($nil_2_03_01,"2",".",",");
					$angnil_2_05_01  =  number_format($angnil_2_05_01,"2",".",",");
					$nil_2_05_01  =  number_format($nil_2_05_01,"2",".",",");
					$angnil_2_06_01  =  number_format($angnil_2_06_01,"2",".",",");
					$nil_2_06_01  =  number_format($nil_2_06_01,"2",".",",");
					$angnil_2_09_01  =  number_format($angnil_2_09_01,"2",".",",");
					$nil_2_09_01  =  number_format($nil_2_09_01,"2",".",",");
					$angnil_2_10_01  =  number_format($angnil_2_10_01,"2",".",",");
					$nil_2_10_01  =  number_format($nil_2_10_01,"2",".",",");
					$angnil_2_11_01  =  number_format($angnil_2_11_01,"2",".",",");
					$nil_2_11_01  =  number_format($nil_2_11_01,"2",".",",");
					$angnil_2_12_01  =  number_format($angnil_2_12_01,"2",".",",");
					$nil_2_12_01  =  number_format($nil_2_12_01,"2",".",",");
					$angnil_2_13_01  =  number_format($angnil_2_13_01,"2",".",",");
					$nil_2_13_01  =  number_format($nil_2_13_01,"2",".",",");
					$angnil_2_17_01  =  number_format($angnil_2_17_01,"2",".",",");
					$nil_2_17_01  =  number_format($nil_2_17_01,"2",".",",");
					$angnil_4_01_01  =  number_format($angnil_4_01_01,"2",".",",");
					$nil_4_01_01  =  number_format($nil_4_01_01,"2",".",",");
					$angnil_4_02_01  =  number_format($angnil_4_02_01,"2",".",",");
					$nil_4_02_01  =  number_format($nil_4_02_01,"2",".",",");
					$angnil_4_02_02  =  number_format($angnil_4_02_02,"2",".",",");
					$nil_4_02_02  =  number_format($nil_4_02_02,"2",".",",");
					$angnil_4_03_01  =  number_format($angnil_4_03_01,"2",".",",");
					$nil_4_03_01  =  number_format($nil_4_03_01,"2",".",",");
					$angnil_4_05_01  =  number_format($angnil_4_05_01,"2",".",",");
					$nil_4_05_01  =  number_format($nil_4_05_01,"2",".",",");
					$angnil_5_02_01  =  number_format($angnil_5_02_01,"2",".",",");
					$nil_5_02_01  =  number_format($nil_5_02_01,"2",".",",");
					$angnil_5_01_01  =  number_format($angnil_5_01_01,"2",".",",");
					$nil_5_01_01  =  number_format($nil_5_01_01,"2",".",",");
					$angnil_4_06_01  =  number_format($angnil_4_06_01,"2",".",",");
					$nil_4_06_01  =  number_format($nil_4_06_01,"2",".",",");
					$angnil_4_08_01  =  number_format($angnil_4_08_01,"2",".",",");
					$nil_4_08_01  =  number_format($nil_4_08_01,"2",".",",");
					$angnil_4_08_02  =  number_format($angnil_4_08_02,"2",".",",");
					$nil_4_08_02  =  number_format($nil_4_08_02,"2",".",",");
					$angnil_4_08_03  =  number_format($angnil_4_08_03,"2",".",",");
					$nil_4_08_03  =  number_format($nil_4_08_03,"2",".",",");
					$angnil_4_08_04  =  number_format($angnil_4_08_04,"2",".",",");
					$nil_4_08_04  =  number_format($nil_4_08_04,"2",".",",");
					$angnil_4_08_05  =  number_format($angnil_4_08_05,"2",".",",");
					$nil_4_08_05  =  number_format($nil_4_08_05,"2",".",",");
					$angnil_4_08_06  =  number_format($angnil_4_08_06,"2",".",",");
					$nil_4_08_06  =  number_format($nil_4_08_06,"2",".",",");
					

                   if(strlen("$no")<6){
                    $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai<b></td>
									 <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_1_01_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_1_01_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_1_02_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_1_02_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_1_03_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_1_03_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_1_04_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_1_04_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_1_05_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_1_05_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_1_05_02<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_1_05_02<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_1_05_03<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_1_05_03<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_1_06_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_1_06_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_2_02_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_2_02_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_2_03_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_2_03_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_2_05_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_2_05_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_2_06_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_2_06_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_2_09_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_2_09_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_2_10_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_2_10_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_2_11_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_2_11_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_2_12_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_2_12_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_2_13_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_2_13_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_2_17_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_2_17_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_4_01_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_4_01_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_4_02_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_4_02_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_4_02_02<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_4_02_02<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_4_03_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_4_03_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_4_05_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_4_05_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_5_02_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_5_02_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_5_01_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_5_01_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_4_06_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_4_06_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_4_08_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_4_08_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_4_08_02<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_4_08_02<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_4_08_03<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_4_08_03<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_4_08_04<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_4_08_04<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_4_08_05<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_4_08_05<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_4_08_06<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_4_08_06<b></td>
                                 </tr>";
                             }else
                             {
					$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">$no</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\">$nama</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nilai</td>
									 <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_1_01_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_1_01_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_1_02_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_1_02_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_1_03_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_1_03_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_1_04_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_1_04_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_1_05_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_1_05_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_1_05_02</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_1_05_02</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_1_05_03</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_1_05_03</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_1_06_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_1_06_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_2_02_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_2_02_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_2_03_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_2_03_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_2_05_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_2_05_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_2_06_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_2_06_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_2_09_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_2_09_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_2_10_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_2_10_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_2_11_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_2_11_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_2_12_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_2_12_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_2_13_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_2_13_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_2_17_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_2_17_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_4_01_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_4_01_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_4_02_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_4_02_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_4_02_02</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_4_02_02</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_4_03_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_4_03_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_4_05_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_4_05_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_5_02_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_5_02_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_5_01_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_5_01_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_4_06_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_4_06_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_4_08_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_4_08_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_4_08_02</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_4_08_02</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_4_08_03</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_4_08_03</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_4_08_04</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_4_08_04</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_4_08_05</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_4_08_05</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_4_08_06</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_4_08_06</td>
                                 </tr>";
                             }
               }

					$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                 </tr>";

							$angnil61_1_01_01=0;
							$nil61_1_01_01=0;
							$angnil61_1_02_01=0;
							$nil61_1_02_01=0;
							$angnil61_1_03_01=0;
							$nil61_1_03_01=0;
							$angnil61_1_04_01=0;
							$nil61_1_04_01=0;
							$angnil61_1_05_01=0;
							$nil61_1_05_01=0;
							$angnil61_1_05_02=0;
							$nil61_1_05_02=0;
							$angnil61_1_05_03=0;
							$nil61_1_05_03=0;
							$angnil61_1_06_01=0;
							$nil61_1_06_01=0;
							$angnil61_2_02_01=0;
							$nil61_2_02_01=0;
							$angnil61_2_03_01=0;
							$nil61_2_03_01=0;
							$angnil61_2_05_01=0;
							$nil61_2_05_01=0;
							$angnil61_2_06_01=0;
							$nil61_2_06_01=0;
							$angnil61_2_09_01=0;
							$nil61_2_09_01=0;
							$angnil61_2_10_01=0;
							$nil61_2_10_01=0;
							$angnil61_2_11_01=0;
							$nil61_2_11_01=0;
							$angnil61_2_12_01=0;
							$nil61_2_12_01=0;
							$angnil61_2_13_01=0;
							$nil61_2_13_01=0;
							$angnil61_2_17_01=0;
							$nil61_2_17_01=0;
							$angnil61_4_01_01=0;
							$nil61_4_01_01=0;
							$angnil61_4_02_01=0;
							$nil61_4_02_01=0;
							$angnil61_4_02_02=0;
							$nil61_4_02_02=0;
							$angnil61_4_03_01=0;
							$nil61_4_03_01=0;
							$angnil61_4_05_01=0;
							$nil61_4_05_01=0;
							$angnil61_5_02_01=0;
							$nil61_5_02_01=0;
							$angnil61_5_01_01=0;
							$nil61_5_01_01=0;
							$angnil61_4_06_01=0;
							$nil61_4_06_01=0;
							$angnil61_4_08_01=0;
							$nil61_4_08_01=0;
							$angnil61_4_08_02=0;
							$nil61_4_08_02=0;
							$angnil61_4_08_03=0;
							$nil61_4_08_03=0;
							$angnil61_4_08_04=0;
							$nil61_4_08_04=0;
							$angnil61_4_08_05=0;
							$nil61_4_08_05=0;
							$angnil61_4_08_06=0;
							$nil61_4_08_06=0;

								 
				$sql4="
                select z.kode,z.nama,z.anggaran,z.reali,z.anggaran_1_01_01,
				z.reali_1_01_01,
				z.anggaran_1_02_01,
				z.reali_1_02_01,
				z.anggaran_1_03_01,
				z.reali_1_03_01,
				z.anggaran_1_04_01,
				z.reali_1_04_01,
				z.anggaran_1_05_01,
				z.reali_1_05_01,
				z.anggaran_1_05_02,
				z.reali_1_05_02,
				z.anggaran_1_05_03,
				z.reali_1_05_03,
				z.anggaran_1_06_01,
				z.reali_1_06_01,
				z.anggaran_2_02_01,
				z.reali_2_02_01,
				z.anggaran_2_03_01,
				z.reali_2_03_01,
				z.anggaran_2_05_01,
				z.reali_2_05_01,
				z.anggaran_2_06_01,
				z.reali_2_06_01,
				z.anggaran_2_09_01,
				z.reali_2_09_01,
				z.anggaran_2_10_01,
				z.reali_2_10_01,
				z.anggaran_2_11_01,
				z.reali_2_11_01,
				z.anggaran_2_12_01,
				z.reali_2_12_01,
				z.anggaran_2_13_01,
				z.reali_2_13_01,
				z.anggaran_2_17_01,
				z.reali_2_17_01,
				z.anggaran_4_01_01,
				z.reali_4_01_01,
				z.anggaran_4_02_01,
				z.reali_4_02_01,
				z.anggaran_4_02_02,
				z.reali_4_02_02,
				z.anggaran_4_03_01,
				z.reali_4_03_01,
				z.anggaran_4_05_01,
				z.reali_4_05_01,
				z.anggaran_5_02_01,
				z.reali_5_02_01,
				z.anggaran_5_01_01,
				z.reali_5_01_01,
				z.anggaran_4_06_01,
				z.reali_4_06_01,
				z.anggaran_4_08_01,
				z.reali_4_08_01,
				z.anggaran_4_08_02,
				z.reali_4_08_02,
				z.anggaran_4_08_03,
				z.reali_4_08_03,
				z.anggaran_4_08_04,
				z.reali_4_08_04,
				z.anggaran_4_08_05,
				z.reali_4_08_05,
				z.anggaran_4_08_06,
				z.reali_4_08_06 from (
                SELECT left(a.kd_rek5,2) as kode,b.nm_rek2 as nama,sum(a.nilai_angg) as anggaran,sum(a.nilai_real) as reali,
				sum(nilai_ang_1_01_01) as anggaran_1_01_01,
				sum(nilai_real_1_01_01) as reali_1_01_01,
				sum(nilai_ang_1_02_01) as anggaran_1_02_01,
				sum(nilai_real_1_02_01) as reali_1_02_01,
				sum(nilai_ang_1_03_01) as anggaran_1_03_01,
				sum(nilai_real_1_03_01) as reali_1_03_01,
				sum(nilai_ang_1_04_01) as anggaran_1_04_01,
				sum(nilai_real_1_04_01) as reali_1_04_01,
				sum(nilai_ang_1_05_01) as anggaran_1_05_01,
				sum(nilai_real_1_05_01) as reali_1_05_01,
				sum(nilai_ang_1_05_02) as anggaran_1_05_02,
				sum(nilai_real_1_05_02) as reali_1_05_02,
				sum(nilai_ang_1_05_03) as anggaran_1_05_03,
				sum(nilai_real_1_05_03) as reali_1_05_03,
				sum(nilai_ang_1_06_01) as anggaran_1_06_01,
				sum(nilai_real_1_06_01) as reali_1_06_01,
				sum(nilai_ang_2_02_01) as anggaran_2_02_01,
				sum(nilai_real_2_02_01) as reali_2_02_01,
				sum(nilai_ang_2_03_01) as anggaran_2_03_01,
				sum(nilai_real_2_03_01) as reali_2_03_01,
				sum(nilai_ang_2_05_01) as anggaran_2_05_01,
				sum(nilai_real_2_05_01) as reali_2_05_01,
				sum(nilai_ang_2_06_01) as anggaran_2_06_01,
				sum(nilai_real_2_06_01) as reali_2_06_01,
				sum(nilai_ang_2_09_01) as anggaran_2_09_01,
				sum(nilai_real_2_09_01) as reali_2_09_01,
				sum(nilai_ang_2_10_01) as anggaran_2_10_01,
				sum(nilai_real_2_10_01) as reali_2_10_01,
				sum(nilai_ang_2_11_01) as anggaran_2_11_01,
				sum(nilai_real_2_11_01) as reali_2_11_01,
				sum(nilai_ang_2_12_01) as anggaran_2_12_01,
				sum(nilai_real_2_12_01) as reali_2_12_01,
				sum(nilai_ang_2_13_01) as anggaran_2_13_01,
				sum(nilai_real_2_13_01) as reali_2_13_01,
				sum(nilai_ang_2_17_01) as anggaran_2_17_01,
				sum(nilai_real_2_17_01) as reali_2_17_01,
				sum(nilai_ang_4_01_01) as anggaran_4_01_01,
				sum(nilai_real_4_01_01) as reali_4_01_01,
				sum(nilai_ang_4_02_01) as anggaran_4_02_01,
				sum(nilai_real_4_02_01) as reali_4_02_01,
				sum(nilai_ang_4_02_02) as anggaran_4_02_02,
				sum(nilai_real_4_02_02) as reali_4_02_02,
				sum(nilai_ang_4_03_01) as anggaran_4_03_01,
				sum(nilai_real_4_03_01) as reali_4_03_01,
				sum(nilai_ang_4_05_01) as anggaran_4_05_01,
				sum(nilai_real_4_05_01) as reali_4_05_01,
				sum(nilai_ang_5_02_01) as anggaran_5_02_01,
				sum(nilai_real_5_02_01) as reali_5_02_01,
				sum(nilai_ang_5_01_01) as anggaran_5_01_01,
				sum(nilai_real_5_01_01) as reali_5_01_01,
				sum(nilai_ang_4_06_01) as anggaran_4_06_01,
				sum(nilai_real_4_06_01) as reali_4_06_01,
				sum(nilai_ang_4_08_01) as anggaran_4_08_01,
				sum(nilai_real_4_08_01) as reali_4_08_01,
				sum(nilai_ang_4_08_02) as anggaran_4_08_02,
				sum(nilai_real_4_08_02) as reali_4_08_02,
				sum(nilai_ang_4_08_03) as anggaran_4_08_03,
				sum(nilai_real_4_08_03) as reali_4_08_03,
				sum(nilai_ang_4_08_04) as anggaran_4_08_04,
				sum(nilai_real_4_08_04) as reali_4_08_04,
				sum(nilai_ang_4_08_05) as anggaran_4_08_05,
				sum(nilai_real_4_08_05) as reali_4_08_05,
				sum(nilai_ang_4_08_06) as anggaran_4_08_06,
				sum(nilai_real_4_08_06) as reali_4_08_06 FROM realisasi_rekap_opd( $bulan,$anggaran,$lntahunang) a
                inner join ms_rek2_64 b on b.kd_rek2 = left(a.kd_rek5,2)                
                where left(a.kd_rek5,2)='71' 
                group by left(a.kd_rek5,2),b.nm_rek2
                )z order by kode,nama
                ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil61    = $row4->reali;
					$angnil61 = $row4->anggaran;
					$angnil61_1_01_01  = $row4->anggaran_1_01_01;
					$nil61_1_01_01  = $row4->reali_1_01_01;
					$angnil61_1_02_01  = $row4->anggaran_1_02_01;
					$nil61_1_02_01  = $row4->reali_1_02_01;
					$angnil61_1_03_01  = $row4->anggaran_1_03_01;
					$nil61_1_03_01  = $row4->reali_1_03_01;
					$angnil61_1_04_01  = $row4->anggaran_1_04_01;
					$nil61_1_04_01  = $row4->reali_1_04_01;
					$angnil61_1_05_01  = $row4->anggaran_1_05_01;
					$nil61_1_05_01  = $row4->reali_1_05_01;
					$angnil61_1_05_02  = $row4->anggaran_1_05_02;
					$nil61_1_05_02  = $row4->reali_1_05_02;
					$angnil61_1_05_03  = $row4->anggaran_1_05_03;
					$nil61_1_05_03  = $row4->reali_1_05_03;
					$angnil61_1_06_01  = $row4->anggaran_1_06_01;
					$nil61_1_06_01  = $row4->reali_1_06_01;
					$angnil61_2_02_01  = $row4->anggaran_2_02_01;
					$nil61_2_02_01  = $row4->reali_2_02_01;
					$angnil61_2_03_01  = $row4->anggaran_2_03_01;
					$nil61_2_03_01  = $row4->reali_2_03_01;
					$angnil61_2_05_01  = $row4->anggaran_2_05_01;
					$nil61_2_05_01  = $row4->reali_2_05_01;
					$angnil61_2_06_01  = $row4->anggaran_2_06_01;
					$nil61_2_06_01  = $row4->reali_2_06_01;
					$angnil61_2_09_01  = $row4->anggaran_2_09_01;
					$nil61_2_09_01  = $row4->reali_2_09_01;
					$angnil61_2_10_01  = $row4->anggaran_2_10_01;
					$nil61_2_10_01  = $row4->reali_2_10_01;
					$angnil61_2_11_01  = $row4->anggaran_2_11_01;
					$nil61_2_11_01  = $row4->reali_2_11_01;
					$angnil61_2_12_01  = $row4->anggaran_2_12_01;
					$nil61_2_12_01  = $row4->reali_2_12_01;
					$angnil61_2_13_01  = $row4->anggaran_2_13_01;
					$nil61_2_13_01  = $row4->reali_2_13_01;
					$angnil61_2_17_01  = $row4->anggaran_2_17_01;
					$nil61_2_17_01  = $row4->reali_2_17_01;
					$angnil61_4_01_01  = $row4->anggaran_4_01_01;
					$nil61_4_01_01  = $row4->reali_4_01_01;
					$angnil61_4_02_01  = $row4->anggaran_4_02_01;
					$nil61_4_02_01  = $row4->reali_4_02_01;
					$angnil61_4_02_02  = $row4->anggaran_4_02_02;
					$nil61_4_02_02  = $row4->reali_4_02_02;
					$angnil61_4_03_01  = $row4->anggaran_4_03_01;
					$nil61_4_03_01  = $row4->reali_4_03_01;
					$angnil61_4_05_01  = $row4->anggaran_4_05_01;
					$nil61_4_05_01  = $row4->reali_4_05_01;
					$angnil61_5_02_01  = $row4->anggaran_5_02_01;
					$nil61_5_02_01  = $row4->reali_5_02_01;
					$angnil61_5_01_01  = $row4->anggaran_5_01_01;
					$nil61_5_01_01  = $row4->reali_5_01_01;
					$angnil61_4_06_01  = $row4->anggaran_4_06_01;
					$nil61_4_06_01  = $row4->reali_4_06_01;
					$angnil61_4_08_01  = $row4->anggaran_4_08_01;
					$nil61_4_08_01  = $row4->reali_4_08_01;
					$angnil61_4_08_02  = $row4->anggaran_4_08_02;
					$nil61_4_08_02  = $row4->reali_4_08_02;
					$angnil61_4_08_03  = $row4->anggaran_4_08_03;
					$nil61_4_08_03  = $row4->reali_4_08_03;
					$angnil61_4_08_04  = $row4->anggaran_4_08_04;
					$nil61_4_08_04  = $row4->reali_4_08_04;
					$angnil61_4_08_05  = $row4->anggaran_4_08_05;
					$nil61_4_08_05  = $row4->reali_4_08_05;
					$angnil61_4_08_06  = $row4->anggaran_4_08_06;
					$nil61_4_08_06  = $row4->reali_4_08_06;
					
					
					$angnilai61  =  number_format($angnil61,"2",".",",");
					$nilai61  =  number_format($nil61,"2",".",",");
					$angnilai61_1_01_01     =    number_format($angnil61_1_01_01,"2",".",",");
					$nilai61_1_01_01     =    number_format($nil61_1_01_01,"2",".",",");
					$angnilai61_1_02_01     =    number_format($angnil61_1_02_01,"2",".",",");
					$nilai61_1_02_01     =    number_format($nil61_1_02_01,"2",".",",");
					$angnilai61_1_03_01     =    number_format($angnil61_1_03_01,"2",".",",");
					$nilai61_1_03_01     =    number_format($nil61_1_03_01,"2",".",",");
					$angnilai61_1_04_01     =    number_format($angnil61_1_04_01,"2",".",",");
					$nilai61_1_04_01     =    number_format($nil61_1_04_01,"2",".",",");
					$angnilai61_1_05_01     =    number_format($angnil61_1_05_01,"2",".",",");
					$nilai61_1_05_01     =    number_format($nil61_1_05_01,"2",".",",");
					$angnilai61_1_05_02     =    number_format($angnil61_1_05_02,"2",".",",");
					$nilai61_1_05_02     =    number_format($nil61_1_05_02,"2",".",",");
					$angnilai61_1_05_03     =    number_format($angnil61_1_05_03,"2",".",",");
					$nilai61_1_05_03     =    number_format($nil61_1_05_03,"2",".",",");
					$angnilai61_1_06_01     =    number_format($angnil61_1_06_01,"2",".",",");
					$nilai61_1_06_01     =    number_format($nil61_1_06_01,"2",".",",");
					$angnilai61_2_02_01     =    number_format($angnil61_2_02_01,"2",".",",");
					$nilai61_2_02_01     =    number_format($nil61_2_02_01,"2",".",",");
					$angnilai61_2_03_01     =    number_format($angnil61_2_03_01,"2",".",",");
					$nilai61_2_03_01     =    number_format($nil61_2_03_01,"2",".",",");
					$angnilai61_2_05_01     =    number_format($angnil61_2_05_01,"2",".",",");
					$nilai61_2_05_01     =    number_format($nil61_2_05_01,"2",".",",");
					$angnilai61_2_06_01     =    number_format($angnil61_2_06_01,"2",".",",");
					$nilai61_2_06_01     =    number_format($nil61_2_06_01,"2",".",",");
					$angnilai61_2_09_01     =    number_format($angnil61_2_09_01,"2",".",",");
					$nilai61_2_09_01     =    number_format($nil61_2_09_01,"2",".",",");
					$angnilai61_2_10_01     =    number_format($angnil61_2_10_01,"2",".",",");
					$nilai61_2_10_01     =    number_format($nil61_2_10_01,"2",".",",");
					$angnilai61_2_11_01     =    number_format($angnil61_2_11_01,"2",".",",");
					$nilai61_2_11_01     =    number_format($nil61_2_11_01,"2",".",",");
					$angnilai61_2_12_01     =    number_format($angnil61_2_12_01,"2",".",",");
					$nilai61_2_12_01     =    number_format($nil61_2_12_01,"2",".",",");
					$angnilai61_2_13_01     =    number_format($angnil61_2_13_01,"2",".",",");
					$nilai61_2_13_01     =    number_format($nil61_2_13_01,"2",".",",");
					$angnilai61_2_17_01     =    number_format($angnil61_2_17_01,"2",".",",");
					$nilai61_2_17_01     =    number_format($nil61_2_17_01,"2",".",",");
					$angnilai61_4_01_01     =    number_format($angnil61_4_01_01,"2",".",",");
					$nilai61_4_01_01     =    number_format($nil61_4_01_01,"2",".",",");
					$angnilai61_4_02_01     =    number_format($angnil61_4_02_01,"2",".",",");
					$nilai61_4_02_01     =    number_format($nil61_4_02_01,"2",".",",");
					$angnilai61_4_02_02     =    number_format($angnil61_4_02_02,"2",".",",");
					$nilai61_4_02_02     =    number_format($nil61_4_02_02,"2",".",",");
					$angnilai61_4_03_01     =    number_format($angnil61_4_03_01,"2",".",",");
					$nilai61_4_03_01     =    number_format($nil61_4_03_01,"2",".",",");
					$angnilai61_4_05_01     =    number_format($angnil61_4_05_01,"2",".",",");
					$nilai61_4_05_01     =    number_format($nil61_4_05_01,"2",".",",");
					$angnilai61_5_02_01     =    number_format($angnil61_5_02_01,"2",".",",");
					$nilai61_5_02_01     =    number_format($nil61_5_02_01,"2",".",",");
					$angnilai61_5_01_01     =    number_format($angnil61_5_01_01,"2",".",",");
					$nilai61_5_01_01     =    number_format($nil61_5_01_01,"2",".",",");
					$angnilai61_4_06_01     =    number_format($angnil61_4_06_01,"2",".",",");
					$nilai61_4_06_01     =    number_format($nil61_4_06_01,"2",".",",");
					$angnilai61_4_08_01     =    number_format($angnil61_4_08_01,"2",".",",");
					$nilai61_4_08_01     =    number_format($nil61_4_08_01,"2",".",",");
					$angnilai61_4_08_02     =    number_format($angnil61_4_08_02,"2",".",",");
					$nilai61_4_08_02     =    number_format($nil61_4_08_02,"2",".",",");
					$angnilai61_4_08_03     =    number_format($angnil61_4_08_03,"2",".",",");
					$nilai61_4_08_03     =    number_format($nil61_4_08_03,"2",".",",");
					$angnilai61_4_08_04     =    number_format($angnil61_4_08_04,"2",".",",");
					$nilai61_4_08_04     =    number_format($nil61_4_08_04,"2",".",",");
					$angnilai61_4_08_05     =    number_format($angnil61_4_08_05,"2",".",",");
					$nilai61_4_08_05     =    number_format($nil61_4_08_05,"2",".",",");
					$angnilai61_4_08_06     =    number_format($angnil61_4_08_06,"2",".",",");
					$nilai61_4_08_06     =    number_format($nil61_4_08_06,"2",".",",");
                    

                    $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b><b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>JUMLAH $nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai61<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai61<b></td>
									 <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai61_1_01_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai61_1_01_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai61_1_02_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai61_1_02_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai61_1_03_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai61_1_03_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai61_1_04_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai61_1_04_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai61_1_05_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai61_1_05_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai61_1_05_02<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai61_1_05_02<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai61_1_05_03<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai61_1_05_03<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai61_1_06_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai61_1_06_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai61_2_02_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai61_2_02_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai61_2_03_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai61_2_03_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai61_2_05_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai61_2_05_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai61_2_06_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai61_2_06_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai61_2_09_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai61_2_09_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai61_2_10_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai61_2_10_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai61_2_11_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai61_2_11_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai61_2_12_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai61_2_12_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai61_2_13_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai61_2_13_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai61_2_17_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai61_2_17_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai61_4_01_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai61_4_01_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai61_4_02_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai61_4_02_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai61_4_02_02<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai61_4_02_02<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai61_4_03_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai61_4_03_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai61_4_05_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai61_4_05_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai61_5_02_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai61_5_02_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai61_5_01_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai61_5_01_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai61_4_06_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai61_4_06_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai61_4_08_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai61_4_08_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai61_4_08_02<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai61_4_08_02<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai61_4_08_03<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai61_4_08_03<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai61_4_08_04<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai61_4_08_04<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai61_4_08_05<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai61_4_08_05<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai61_4_08_06<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai61_4_08_06<b></td>
                                 </tr>";								 
				}
							$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                 </tr>";
				
		$sql4="
                select z.kode,z.nama,z.anggaran,z.reali,z.anggaran_1_01_01,
				z.reali_1_01_01,
				z.anggaran_1_02_01,
				z.reali_1_02_01,
				z.anggaran_1_03_01,
				z.reali_1_03_01,
				z.anggaran_1_04_01,
				z.reali_1_04_01,
				z.anggaran_1_05_01,
				z.reali_1_05_01,
				z.anggaran_1_05_02,
				z.reali_1_05_02,
				z.anggaran_1_05_03,
				z.reali_1_05_03,
				z.anggaran_1_06_01,
				z.reali_1_06_01,
				z.anggaran_2_02_01,
				z.reali_2_02_01,
				z.anggaran_2_03_01,
				z.reali_2_03_01,
				z.anggaran_2_05_01,
				z.reali_2_05_01,
				z.anggaran_2_06_01,
				z.reali_2_06_01,
				z.anggaran_2_09_01,
				z.reali_2_09_01,
				z.anggaran_2_10_01,
				z.reali_2_10_01,
				z.anggaran_2_11_01,
				z.reali_2_11_01,
				z.anggaran_2_12_01,
				z.reali_2_12_01,
				z.anggaran_2_13_01,
				z.reali_2_13_01,
				z.anggaran_2_17_01,
				z.reali_2_17_01,
				z.anggaran_4_01_01,
				z.reali_4_01_01,
				z.anggaran_4_02_01,
				z.reali_4_02_01,
				z.anggaran_4_02_02,
				z.reali_4_02_02,
				z.anggaran_4_03_01,
				z.reali_4_03_01,
				z.anggaran_4_05_01,
				z.reali_4_05_01,
				z.anggaran_5_02_01,
				z.reali_5_02_01,
				z.anggaran_5_01_01,
				z.reali_5_01_01,
				z.anggaran_4_06_01,
				z.reali_4_06_01,
				z.anggaran_4_08_01,
				z.reali_4_08_01,
				z.anggaran_4_08_02,
				z.reali_4_08_02,
				z.anggaran_4_08_03,
				z.reali_4_08_03,
				z.anggaran_4_08_04,
				z.reali_4_08_04,
				z.anggaran_4_08_05,
				z.reali_4_08_05,
				z.anggaran_4_08_06,
				z.reali_4_08_06 from (
                SELECT left(a.kd_rek5,2) as kode,b.nm_rek2 as nama,sum(a.nilai_angg) as anggaran,sum(a.nilai_real) as reali,
				sum(nilai_ang_1_01_01) as anggaran_1_01_01,
				sum(nilai_real_1_01_01) as reali_1_01_01,
				sum(nilai_ang_1_02_01) as anggaran_1_02_01,
				sum(nilai_real_1_02_01) as reali_1_02_01,
				sum(nilai_ang_1_03_01) as anggaran_1_03_01,
				sum(nilai_real_1_03_01) as reali_1_03_01,
				sum(nilai_ang_1_04_01) as anggaran_1_04_01,
				sum(nilai_real_1_04_01) as reali_1_04_01,
				sum(nilai_ang_1_05_01) as anggaran_1_05_01,
				sum(nilai_real_1_05_01) as reali_1_05_01,
				sum(nilai_ang_1_05_02) as anggaran_1_05_02,
				sum(nilai_real_1_05_02) as reali_1_05_02,
				sum(nilai_ang_1_05_03) as anggaran_1_05_03,
				sum(nilai_real_1_05_03) as reali_1_05_03,
				sum(nilai_ang_1_06_01) as anggaran_1_06_01,
				sum(nilai_real_1_06_01) as reali_1_06_01,
				sum(nilai_ang_2_02_01) as anggaran_2_02_01,
				sum(nilai_real_2_02_01) as reali_2_02_01,
				sum(nilai_ang_2_03_01) as anggaran_2_03_01,
				sum(nilai_real_2_03_01) as reali_2_03_01,
				sum(nilai_ang_2_05_01) as anggaran_2_05_01,
				sum(nilai_real_2_05_01) as reali_2_05_01,
				sum(nilai_ang_2_06_01) as anggaran_2_06_01,
				sum(nilai_real_2_06_01) as reali_2_06_01,
				sum(nilai_ang_2_09_01) as anggaran_2_09_01,
				sum(nilai_real_2_09_01) as reali_2_09_01,
				sum(nilai_ang_2_10_01) as anggaran_2_10_01,
				sum(nilai_real_2_10_01) as reali_2_10_01,
				sum(nilai_ang_2_11_01) as anggaran_2_11_01,
				sum(nilai_real_2_11_01) as reali_2_11_01,
				sum(nilai_ang_2_12_01) as anggaran_2_12_01,
				sum(nilai_real_2_12_01) as reali_2_12_01,
				sum(nilai_ang_2_13_01) as anggaran_2_13_01,
				sum(nilai_real_2_13_01) as reali_2_13_01,
				sum(nilai_ang_2_17_01) as anggaran_2_17_01,
				sum(nilai_real_2_17_01) as reali_2_17_01,
				sum(nilai_ang_4_01_01) as anggaran_4_01_01,
				sum(nilai_real_4_01_01) as reali_4_01_01,
				sum(nilai_ang_4_02_01) as anggaran_4_02_01,
				sum(nilai_real_4_02_01) as reali_4_02_01,
				sum(nilai_ang_4_02_02) as anggaran_4_02_02,
				sum(nilai_real_4_02_02) as reali_4_02_02,
				sum(nilai_ang_4_03_01) as anggaran_4_03_01,
				sum(nilai_real_4_03_01) as reali_4_03_01,
				sum(nilai_ang_4_05_01) as anggaran_4_05_01,
				sum(nilai_real_4_05_01) as reali_4_05_01,
				sum(nilai_ang_5_02_01) as anggaran_5_02_01,
				sum(nilai_real_5_02_01) as reali_5_02_01,
				sum(nilai_ang_5_01_01) as anggaran_5_01_01,
				sum(nilai_real_5_01_01) as reali_5_01_01,
				sum(nilai_ang_4_06_01) as anggaran_4_06_01,
				sum(nilai_real_4_06_01) as reali_4_06_01,
				sum(nilai_ang_4_08_01) as anggaran_4_08_01,
				sum(nilai_real_4_08_01) as reali_4_08_01,
				sum(nilai_ang_4_08_02) as anggaran_4_08_02,
				sum(nilai_real_4_08_02) as reali_4_08_02,
				sum(nilai_ang_4_08_03) as anggaran_4_08_03,
				sum(nilai_real_4_08_03) as reali_4_08_03,
				sum(nilai_ang_4_08_04) as anggaran_4_08_04,
				sum(nilai_real_4_08_04) as reali_4_08_04,
				sum(nilai_ang_4_08_05) as anggaran_4_08_05,
				sum(nilai_real_4_08_05) as reali_4_08_05,
				sum(nilai_ang_4_08_06) as anggaran_4_08_06,
				sum(nilai_real_4_08_06) as reali_4_08_06 FROM realisasi_rekap_opd( $bulan,$anggaran,$lntahunang) a
                inner join ms_rek2_64 b on b.kd_rek2 = left(a.kd_rek5,2)                
                where left(a.kd_rek5,2)='72' 
                group by left(a.kd_rek5,2),b.nm_rek2
                union all
                SELECT left(a.kd_rek5,3) as kode,b.nm_rek3 as nama,sum(a.nilai_angg) as anggaran,sum(a.nilai_real) as reali,
				sum(nilai_ang_1_01_01) as anggaran_1_01_01,
				sum(nilai_real_1_01_01) as reali_1_01_01,
				sum(nilai_ang_1_02_01) as anggaran_1_02_01,
				sum(nilai_real_1_02_01) as reali_1_02_01,
				sum(nilai_ang_1_03_01) as anggaran_1_03_01,
				sum(nilai_real_1_03_01) as reali_1_03_01,
				sum(nilai_ang_1_04_01) as anggaran_1_04_01,
				sum(nilai_real_1_04_01) as reali_1_04_01,
				sum(nilai_ang_1_05_01) as anggaran_1_05_01,
				sum(nilai_real_1_05_01) as reali_1_05_01,
				sum(nilai_ang_1_05_02) as anggaran_1_05_02,
				sum(nilai_real_1_05_02) as reali_1_05_02,
				sum(nilai_ang_1_05_03) as anggaran_1_05_03,
				sum(nilai_real_1_05_03) as reali_1_05_03,
				sum(nilai_ang_1_06_01) as anggaran_1_06_01,
				sum(nilai_real_1_06_01) as reali_1_06_01,
				sum(nilai_ang_2_02_01) as anggaran_2_02_01,
				sum(nilai_real_2_02_01) as reali_2_02_01,
				sum(nilai_ang_2_03_01) as anggaran_2_03_01,
				sum(nilai_real_2_03_01) as reali_2_03_01,
				sum(nilai_ang_2_05_01) as anggaran_2_05_01,
				sum(nilai_real_2_05_01) as reali_2_05_01,
				sum(nilai_ang_2_06_01) as anggaran_2_06_01,
				sum(nilai_real_2_06_01) as reali_2_06_01,
				sum(nilai_ang_2_09_01) as anggaran_2_09_01,
				sum(nilai_real_2_09_01) as reali_2_09_01,
				sum(nilai_ang_2_10_01) as anggaran_2_10_01,
				sum(nilai_real_2_10_01) as reali_2_10_01,
				sum(nilai_ang_2_11_01) as anggaran_2_11_01,
				sum(nilai_real_2_11_01) as reali_2_11_01,
				sum(nilai_ang_2_12_01) as anggaran_2_12_01,
				sum(nilai_real_2_12_01) as reali_2_12_01,
				sum(nilai_ang_2_13_01) as anggaran_2_13_01,
				sum(nilai_real_2_13_01) as reali_2_13_01,
				sum(nilai_ang_2_17_01) as anggaran_2_17_01,
				sum(nilai_real_2_17_01) as reali_2_17_01,
				sum(nilai_ang_4_01_01) as anggaran_4_01_01,
				sum(nilai_real_4_01_01) as reali_4_01_01,
				sum(nilai_ang_4_02_01) as anggaran_4_02_01,
				sum(nilai_real_4_02_01) as reali_4_02_01,
				sum(nilai_ang_4_02_02) as anggaran_4_02_02,
				sum(nilai_real_4_02_02) as reali_4_02_02,
				sum(nilai_ang_4_03_01) as anggaran_4_03_01,
				sum(nilai_real_4_03_01) as reali_4_03_01,
				sum(nilai_ang_4_05_01) as anggaran_4_05_01,
				sum(nilai_real_4_05_01) as reali_4_05_01,
				sum(nilai_ang_5_02_01) as anggaran_5_02_01,
				sum(nilai_real_5_02_01) as reali_5_02_01,
				sum(nilai_ang_5_01_01) as anggaran_5_01_01,
				sum(nilai_real_5_01_01) as reali_5_01_01,
				sum(nilai_ang_4_06_01) as anggaran_4_06_01,
				sum(nilai_real_4_06_01) as reali_4_06_01,
				sum(nilai_ang_4_08_01) as anggaran_4_08_01,
				sum(nilai_real_4_08_01) as reali_4_08_01,
				sum(nilai_ang_4_08_02) as anggaran_4_08_02,
				sum(nilai_real_4_08_02) as reali_4_08_02,
				sum(nilai_ang_4_08_03) as anggaran_4_08_03,
				sum(nilai_real_4_08_03) as reali_4_08_03,
				sum(nilai_ang_4_08_04) as anggaran_4_08_04,
				sum(nilai_real_4_08_04) as reali_4_08_04,
				sum(nilai_ang_4_08_05) as anggaran_4_08_05,
				sum(nilai_real_4_08_05) as reali_4_08_05,
				sum(nilai_ang_4_08_06) as anggaran_4_08_06,
				sum(nilai_real_4_08_06) as reali_4_08_06 FROM realisasi_rekap_opd( $bulan,$anggaran,$lntahunang) a
                inner join ms_rek3_64 b on b.kd_rek3 = left(a.kd_rek5,3)                
                where left(a.kd_rek5,2)='72' 
                group by left(a.kd_rek5,3),b.nm_rek3
                union all
                SELECT left(a.kd_rek5,5) as kode,b.nm_rek4_64 as nama,sum(a.nilai_angg) as anggaran,sum(a.nilai_real) as reali,
				sum(nilai_ang_1_01_01) as anggaran_1_01_01,
				sum(nilai_real_1_01_01) as reali_1_01_01,
				sum(nilai_ang_1_02_01) as anggaran_1_02_01,
				sum(nilai_real_1_02_01) as reali_1_02_01,
				sum(nilai_ang_1_03_01) as anggaran_1_03_01,
				sum(nilai_real_1_03_01) as reali_1_03_01,
				sum(nilai_ang_1_04_01) as anggaran_1_04_01,
				sum(nilai_real_1_04_01) as reali_1_04_01,
				sum(nilai_ang_1_05_01) as anggaran_1_05_01,
				sum(nilai_real_1_05_01) as reali_1_05_01,
				sum(nilai_ang_1_05_02) as anggaran_1_05_02,
				sum(nilai_real_1_05_02) as reali_1_05_02,
				sum(nilai_ang_1_05_03) as anggaran_1_05_03,
				sum(nilai_real_1_05_03) as reali_1_05_03,
				sum(nilai_ang_1_06_01) as anggaran_1_06_01,
				sum(nilai_real_1_06_01) as reali_1_06_01,
				sum(nilai_ang_2_02_01) as anggaran_2_02_01,
				sum(nilai_real_2_02_01) as reali_2_02_01,
				sum(nilai_ang_2_03_01) as anggaran_2_03_01,
				sum(nilai_real_2_03_01) as reali_2_03_01,
				sum(nilai_ang_2_05_01) as anggaran_2_05_01,
				sum(nilai_real_2_05_01) as reali_2_05_01,
				sum(nilai_ang_2_06_01) as anggaran_2_06_01,
				sum(nilai_real_2_06_01) as reali_2_06_01,
				sum(nilai_ang_2_09_01) as anggaran_2_09_01,
				sum(nilai_real_2_09_01) as reali_2_09_01,
				sum(nilai_ang_2_10_01) as anggaran_2_10_01,
				sum(nilai_real_2_10_01) as reali_2_10_01,
				sum(nilai_ang_2_11_01) as anggaran_2_11_01,
				sum(nilai_real_2_11_01) as reali_2_11_01,
				sum(nilai_ang_2_12_01) as anggaran_2_12_01,
				sum(nilai_real_2_12_01) as reali_2_12_01,
				sum(nilai_ang_2_13_01) as anggaran_2_13_01,
				sum(nilai_real_2_13_01) as reali_2_13_01,
				sum(nilai_ang_2_17_01) as anggaran_2_17_01,
				sum(nilai_real_2_17_01) as reali_2_17_01,
				sum(nilai_ang_4_01_01) as anggaran_4_01_01,
				sum(nilai_real_4_01_01) as reali_4_01_01,
				sum(nilai_ang_4_02_01) as anggaran_4_02_01,
				sum(nilai_real_4_02_01) as reali_4_02_01,
				sum(nilai_ang_4_02_02) as anggaran_4_02_02,
				sum(nilai_real_4_02_02) as reali_4_02_02,
				sum(nilai_ang_4_03_01) as anggaran_4_03_01,
				sum(nilai_real_4_03_01) as reali_4_03_01,
				sum(nilai_ang_4_05_01) as anggaran_4_05_01,
				sum(nilai_real_4_05_01) as reali_4_05_01,
				sum(nilai_ang_5_02_01) as anggaran_5_02_01,
				sum(nilai_real_5_02_01) as reali_5_02_01,
				sum(nilai_ang_5_01_01) as anggaran_5_01_01,
				sum(nilai_real_5_01_01) as reali_5_01_01,
				sum(nilai_ang_4_06_01) as anggaran_4_06_01,
				sum(nilai_real_4_06_01) as reali_4_06_01,
				sum(nilai_ang_4_08_01) as anggaran_4_08_01,
				sum(nilai_real_4_08_01) as reali_4_08_01,
				sum(nilai_ang_4_08_02) as anggaran_4_08_02,
				sum(nilai_real_4_08_02) as reali_4_08_02,
				sum(nilai_ang_4_08_03) as anggaran_4_08_03,
				sum(nilai_real_4_08_03) as reali_4_08_03,
				sum(nilai_ang_4_08_04) as anggaran_4_08_04,
				sum(nilai_real_4_08_04) as reali_4_08_04,
				sum(nilai_ang_4_08_05) as anggaran_4_08_05,
				sum(nilai_real_4_08_05) as reali_4_08_05,
				sum(nilai_ang_4_08_06) as anggaran_4_08_06,
				sum(nilai_real_4_08_06) as reali_4_08_06 FROM realisasi_rekap_opd( $bulan,$anggaran,$lntahunang) a
                inner join ms_rek4_64 b on b.kd_rek4_64 = left(a.kd_rek5,5)                
                where left(a.kd_rek5,2)='72' 
                group by left(a.kd_rek5,5),b.nm_rek4_64
                union all
                SELECT a.kd_rek5 as kode,b.nm_rek64 as nama,sum(a.nilai_angg) as anggaran,sum(a.nilai_real) as reali,
				sum(nilai_ang_1_01_01) as anggaran_1_01_01,
				sum(nilai_real_1_01_01) as reali_1_01_01,
				sum(nilai_ang_1_02_01) as anggaran_1_02_01,
				sum(nilai_real_1_02_01) as reali_1_02_01,
				sum(nilai_ang_1_03_01) as anggaran_1_03_01,
				sum(nilai_real_1_03_01) as reali_1_03_01,
				sum(nilai_ang_1_04_01) as anggaran_1_04_01,
				sum(nilai_real_1_04_01) as reali_1_04_01,
				sum(nilai_ang_1_05_01) as anggaran_1_05_01,
				sum(nilai_real_1_05_01) as reali_1_05_01,
				sum(nilai_ang_1_05_02) as anggaran_1_05_02,
				sum(nilai_real_1_05_02) as reali_1_05_02,
				sum(nilai_ang_1_05_03) as anggaran_1_05_03,
				sum(nilai_real_1_05_03) as reali_1_05_03,
				sum(nilai_ang_1_06_01) as anggaran_1_06_01,
				sum(nilai_real_1_06_01) as reali_1_06_01,
				sum(nilai_ang_2_02_01) as anggaran_2_02_01,
				sum(nilai_real_2_02_01) as reali_2_02_01,
				sum(nilai_ang_2_03_01) as anggaran_2_03_01,
				sum(nilai_real_2_03_01) as reali_2_03_01,
				sum(nilai_ang_2_05_01) as anggaran_2_05_01,
				sum(nilai_real_2_05_01) as reali_2_05_01,
				sum(nilai_ang_2_06_01) as anggaran_2_06_01,
				sum(nilai_real_2_06_01) as reali_2_06_01,
				sum(nilai_ang_2_09_01) as anggaran_2_09_01,
				sum(nilai_real_2_09_01) as reali_2_09_01,
				sum(nilai_ang_2_10_01) as anggaran_2_10_01,
				sum(nilai_real_2_10_01) as reali_2_10_01,
				sum(nilai_ang_2_11_01) as anggaran_2_11_01,
				sum(nilai_real_2_11_01) as reali_2_11_01,
				sum(nilai_ang_2_12_01) as anggaran_2_12_01,
				sum(nilai_real_2_12_01) as reali_2_12_01,
				sum(nilai_ang_2_13_01) as anggaran_2_13_01,
				sum(nilai_real_2_13_01) as reali_2_13_01,
				sum(nilai_ang_2_17_01) as anggaran_2_17_01,
				sum(nilai_real_2_17_01) as reali_2_17_01,
				sum(nilai_ang_4_01_01) as anggaran_4_01_01,
				sum(nilai_real_4_01_01) as reali_4_01_01,
				sum(nilai_ang_4_02_01) as anggaran_4_02_01,
				sum(nilai_real_4_02_01) as reali_4_02_01,
				sum(nilai_ang_4_02_02) as anggaran_4_02_02,
				sum(nilai_real_4_02_02) as reali_4_02_02,
				sum(nilai_ang_4_03_01) as anggaran_4_03_01,
				sum(nilai_real_4_03_01) as reali_4_03_01,
				sum(nilai_ang_4_05_01) as anggaran_4_05_01,
				sum(nilai_real_4_05_01) as reali_4_05_01,
				sum(nilai_ang_5_02_01) as anggaran_5_02_01,
				sum(nilai_real_5_02_01) as reali_5_02_01,
				sum(nilai_ang_5_01_01) as anggaran_5_01_01,
				sum(nilai_real_5_01_01) as reali_5_01_01,
				sum(nilai_ang_4_06_01) as anggaran_4_06_01,
				sum(nilai_real_4_06_01) as reali_4_06_01,
				sum(nilai_ang_4_08_01) as anggaran_4_08_01,
				sum(nilai_real_4_08_01) as reali_4_08_01,
				sum(nilai_ang_4_08_02) as anggaran_4_08_02,
				sum(nilai_real_4_08_02) as reali_4_08_02,
				sum(nilai_ang_4_08_03) as anggaran_4_08_03,
				sum(nilai_real_4_08_03) as reali_4_08_03,
				sum(nilai_ang_4_08_04) as anggaran_4_08_04,
				sum(nilai_real_4_08_04) as reali_4_08_04,
				sum(nilai_ang_4_08_05) as anggaran_4_08_05,
				sum(nilai_real_4_08_05) as reali_4_08_05,
				sum(nilai_ang_4_08_06) as anggaran_4_08_06,
				sum(nilai_real_4_08_06) as reali_4_08_06 FROM realisasi_rekap_opd( $bulan,$anggaran,$lntahunang) a
                inner join ms_rek5 b on b.kd_rek64 = a.kd_rek5                        
                where left(a.kd_rek5,2)='72' 
                group by a.kd_rek5,b.nm_rek64
                )z order by kode,nama
                ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil    = $row4->reali;
					$angnil = $row4->anggaran;
					$angnil_1_01_01  = $row4->anggaran_1_01_01;
					$nil_1_01_01  = $row4->reali_1_01_01;
					$angnil_1_02_01  = $row4->anggaran_1_02_01;
					$nil_1_02_01  = $row4->reali_1_02_01;
					$angnil_1_03_01  = $row4->anggaran_1_03_01;
					$nil_1_03_01  = $row4->reali_1_03_01;
					$angnil_1_04_01  = $row4->anggaran_1_04_01;
					$nil_1_04_01  = $row4->reali_1_04_01;
					$angnil_1_05_01  = $row4->anggaran_1_05_01;
					$nil_1_05_01  = $row4->reali_1_05_01;
					$angnil_1_05_02  = $row4->anggaran_1_05_02;
					$nil_1_05_02  = $row4->reali_1_05_02;
					$angnil_1_05_03  = $row4->anggaran_1_05_03;
					$nil_1_05_03  = $row4->reali_1_05_03;
					$angnil_1_06_01  = $row4->anggaran_1_06_01;
					$nil_1_06_01  = $row4->reali_1_06_01;
					$angnil_2_02_01  = $row4->anggaran_2_02_01;
					$nil_2_02_01  = $row4->reali_2_02_01;
					$angnil_2_03_01  = $row4->anggaran_2_03_01;
					$nil_2_03_01  = $row4->reali_2_03_01;
					$angnil_2_05_01  = $row4->anggaran_2_05_01;
					$nil_2_05_01  = $row4->reali_2_05_01;
					$angnil_2_06_01  = $row4->anggaran_2_06_01;
					$nil_2_06_01  = $row4->reali_2_06_01;
					$angnil_2_09_01  = $row4->anggaran_2_09_01;
					$nil_2_09_01  = $row4->reali_2_09_01;
					$angnil_2_10_01  = $row4->anggaran_2_10_01;
					$nil_2_10_01  = $row4->reali_2_10_01;
					$angnil_2_11_01  = $row4->anggaran_2_11_01;
					$nil_2_11_01  = $row4->reali_2_11_01;
					$angnil_2_12_01  = $row4->anggaran_2_12_01;
					$nil_2_12_01  = $row4->reali_2_12_01;
					$angnil_2_13_01  = $row4->anggaran_2_13_01;
					$nil_2_13_01  = $row4->reali_2_13_01;
					$angnil_2_17_01  = $row4->anggaran_2_17_01;
					$nil_2_17_01  = $row4->reali_2_17_01;
					$angnil_4_01_01  = $row4->anggaran_4_01_01;
					$nil_4_01_01  = $row4->reali_4_01_01;
					$angnil_4_02_01  = $row4->anggaran_4_02_01;
					$nil_4_02_01  = $row4->reali_4_02_01;
					$angnil_4_02_02  = $row4->anggaran_4_02_02;
					$nil_4_02_02  = $row4->reali_4_02_02;
					$angnil_4_03_01  = $row4->anggaran_4_03_01;
					$nil_4_03_01  = $row4->reali_4_03_01;
					$angnil_4_05_01  = $row4->anggaran_4_05_01;
					$nil_4_05_01  = $row4->reali_4_05_01;
					$angnil_5_02_01  = $row4->anggaran_5_02_01;
					$nil_5_02_01  = $row4->reali_5_02_01;
					$angnil_5_01_01  = $row4->anggaran_5_01_01;
					$nil_5_01_01  = $row4->reali_5_01_01;
					$angnil_4_06_01  = $row4->anggaran_4_06_01;
					$nil_4_06_01  = $row4->reali_4_06_01;
					$angnil_4_08_01  = $row4->anggaran_4_08_01;
					$nil_4_08_01  = $row4->reali_4_08_01;
					$angnil_4_08_02  = $row4->anggaran_4_08_02;
					$nil_4_08_02  = $row4->reali_4_08_02;
					$angnil_4_08_03  = $row4->anggaran_4_08_03;
					$nil_4_08_03  = $row4->reali_4_08_03;
					$angnil_4_08_04  = $row4->anggaran_4_08_04;
					$nil_4_08_04  = $row4->reali_4_08_04;
					$angnil_4_08_05  = $row4->anggaran_4_08_05;
					$nil_4_08_05  = $row4->reali_4_08_05;
					$angnil_4_08_06  = $row4->anggaran_4_08_06;
					$nil_4_08_06  = $row4->reali_4_08_06;
					
					
					$angnilai  =  number_format($angnil,"2",".",",");
					$nilai  =  number_format($nil,"2",".",",");
					$angnil_1_01_01  =  number_format($angnil_1_01_01,"2",".",",");
					$nil_1_01_01  =  number_format($nil_1_01_01,"2",".",",");
					$angnil_1_02_01  =  number_format($angnil_1_02_01,"2",".",",");
					$nil_1_02_01  =  number_format($nil_1_02_01,"2",".",",");
					$angnil_1_03_01  =  number_format($angnil_1_03_01,"2",".",",");
					$nil_1_03_01  =  number_format($nil_1_03_01,"2",".",",");
					$angnil_1_04_01  =  number_format($angnil_1_04_01,"2",".",",");
					$nil_1_04_01  =  number_format($nil_1_04_01,"2",".",",");
					$angnil_1_05_01  =  number_format($angnil_1_05_01,"2",".",",");
					$nil_1_05_01  =  number_format($nil_1_05_01,"2",".",",");
					$angnil_1_05_02  =  number_format($angnil_1_05_02,"2",".",",");
					$nil_1_05_02  =  number_format($nil_1_05_02,"2",".",",");
					$angnil_1_05_03  =  number_format($angnil_1_05_03,"2",".",",");
					$nil_1_05_03  =  number_format($nil_1_05_03,"2",".",",");
					$angnil_1_06_01  =  number_format($angnil_1_06_01,"2",".",",");
					$nil_1_06_01  =  number_format($nil_1_06_01,"2",".",",");
					$angnil_2_02_01  =  number_format($angnil_2_02_01,"2",".",",");
					$nil_2_02_01  =  number_format($nil_2_02_01,"2",".",",");
					$angnil_2_03_01  =  number_format($angnil_2_03_01,"2",".",",");
					$nil_2_03_01  =  number_format($nil_2_03_01,"2",".",",");
					$angnil_2_05_01  =  number_format($angnil_2_05_01,"2",".",",");
					$nil_2_05_01  =  number_format($nil_2_05_01,"2",".",",");
					$angnil_2_06_01  =  number_format($angnil_2_06_01,"2",".",",");
					$nil_2_06_01  =  number_format($nil_2_06_01,"2",".",",");
					$angnil_2_09_01  =  number_format($angnil_2_09_01,"2",".",",");
					$nil_2_09_01  =  number_format($nil_2_09_01,"2",".",",");
					$angnil_2_10_01  =  number_format($angnil_2_10_01,"2",".",",");
					$nil_2_10_01  =  number_format($nil_2_10_01,"2",".",",");
					$angnil_2_11_01  =  number_format($angnil_2_11_01,"2",".",",");
					$nil_2_11_01  =  number_format($nil_2_11_01,"2",".",",");
					$angnil_2_12_01  =  number_format($angnil_2_12_01,"2",".",",");
					$nil_2_12_01  =  number_format($nil_2_12_01,"2",".",",");
					$angnil_2_13_01  =  number_format($angnil_2_13_01,"2",".",",");
					$nil_2_13_01  =  number_format($nil_2_13_01,"2",".",",");
					$angnil_2_17_01  =  number_format($angnil_2_17_01,"2",".",",");
					$nil_2_17_01  =  number_format($nil_2_17_01,"2",".",",");
					$angnil_4_01_01  =  number_format($angnil_4_01_01,"2",".",",");
					$nil_4_01_01  =  number_format($nil_4_01_01,"2",".",",");
					$angnil_4_02_01  =  number_format($angnil_4_02_01,"2",".",",");
					$nil_4_02_01  =  number_format($nil_4_02_01,"2",".",",");
					$angnil_4_02_02  =  number_format($angnil_4_02_02,"2",".",",");
					$nil_4_02_02  =  number_format($nil_4_02_02,"2",".",",");
					$angnil_4_03_01  =  number_format($angnil_4_03_01,"2",".",",");
					$nil_4_03_01  =  number_format($nil_4_03_01,"2",".",",");
					$angnil_4_05_01  =  number_format($angnil_4_05_01,"2",".",",");
					$nil_4_05_01  =  number_format($nil_4_05_01,"2",".",",");
					$angnil_5_02_01  =  number_format($angnil_5_02_01,"2",".",",");
					$nil_5_02_01  =  number_format($nil_5_02_01,"2",".",",");
					$angnil_5_01_01  =  number_format($angnil_5_01_01,"2",".",",");
					$nil_5_01_01  =  number_format($nil_5_01_01,"2",".",",");
					$angnil_4_06_01  =  number_format($angnil_4_06_01,"2",".",",");
					$nil_4_06_01  =  number_format($nil_4_06_01,"2",".",",");
					$angnil_4_08_01  =  number_format($angnil_4_08_01,"2",".",",");
					$nil_4_08_01  =  number_format($nil_4_08_01,"2",".",",");
					$angnil_4_08_02  =  number_format($angnil_4_08_02,"2",".",",");
					$nil_4_08_02  =  number_format($nil_4_08_02,"2",".",",");
					$angnil_4_08_03  =  number_format($angnil_4_08_03,"2",".",",");
					$nil_4_08_03  =  number_format($nil_4_08_03,"2",".",",");
					$angnil_4_08_04  =  number_format($angnil_4_08_04,"2",".",",");
					$nil_4_08_04  =  number_format($nil_4_08_04,"2",".",",");
					$angnil_4_08_05  =  number_format($angnil_4_08_05,"2",".",",");
					$nil_4_08_05  =  number_format($nil_4_08_05,"2",".",",");
					$angnil_4_08_06  =  number_format($angnil_4_08_06,"2",".",",");
					$nil_4_08_06  =  number_format($nil_4_08_06,"2",".",",");
					
                    
                   if(strlen("$no")<6){
                    $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai<b></td>
									 <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_1_01_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_1_01_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_1_02_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_1_02_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_1_03_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_1_03_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_1_04_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_1_04_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_1_05_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_1_05_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_1_05_02<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_1_05_02<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_1_05_03<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_1_05_03<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_1_06_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_1_06_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_2_02_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_2_02_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_2_03_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_2_03_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_2_05_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_2_05_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_2_06_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_2_06_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_2_09_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_2_09_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_2_10_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_2_10_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_2_11_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_2_11_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_2_12_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_2_12_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_2_13_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_2_13_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_2_17_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_2_17_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_4_01_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_4_01_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_4_02_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_4_02_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_4_02_02<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_4_02_02<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_4_03_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_4_03_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_4_05_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_4_05_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_5_02_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_5_02_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_5_01_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_5_01_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_4_06_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_4_06_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_4_08_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_4_08_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_4_08_02<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_4_08_02<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_4_08_03<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_4_08_03<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_4_08_04<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_4_08_04<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_4_08_05<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_4_08_05<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnil_4_08_06<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nil_4_08_06<b></td>
                                 </tr>";
                             }else
                             {
					$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">$no</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\">$nama</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nilai</td>
									 <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_1_01_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_1_01_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_1_02_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_1_02_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_1_03_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_1_03_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_1_04_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_1_04_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_1_05_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_1_05_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_1_05_02</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_1_05_02</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_1_05_03</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_1_05_03</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_1_06_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_1_06_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_2_02_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_2_02_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_2_03_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_2_03_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_2_05_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_2_05_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_2_06_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_2_06_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_2_09_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_2_09_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_2_10_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_2_10_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_2_11_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_2_11_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_2_12_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_2_12_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_2_13_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_2_13_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_2_17_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_2_17_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_4_01_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_4_01_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_4_02_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_4_02_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_4_02_02</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_4_02_02</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_4_03_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_4_03_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_4_05_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_4_05_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_5_02_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_5_02_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_5_01_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_5_01_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_4_06_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_4_06_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_4_08_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_4_08_01</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_4_08_02</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_4_08_02</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_4_08_03</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_4_08_03</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_4_08_04</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_4_08_04</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_4_08_05</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_4_08_05</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnil_4_08_06</td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nil_4_08_06</td>
                                 </tr>";
                             }
               }

							$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                 </tr>";


							$angnil62_1_01_01=0;
							$nil62_1_01_01=0;
							$angnil62_1_02_01=0;
							$nil62_1_02_01=0;
							$angnil62_1_03_01=0;
							$nil62_1_03_01=0;
							$angnil62_1_04_01=0;
							$nil62_1_04_01=0;
							$angnil62_1_05_01=0;
							$nil62_1_05_01=0;
							$angnil62_1_05_02=0;
							$nil62_1_05_02=0;
							$angnil62_1_05_03=0;
							$nil62_1_05_03=0;
							$angnil62_1_06_01=0;
							$nil62_1_06_01=0;
							$angnil62_2_02_01=0;
							$nil62_2_02_01=0;
							$angnil62_2_03_01=0;
							$nil62_2_03_01=0;
							$angnil62_2_05_01=0;
							$nil62_2_05_01=0;
							$angnil62_2_06_01=0;
							$nil62_2_06_01=0;
							$angnil62_2_09_01=0;
							$nil62_2_09_01=0;
							$angnil62_2_10_01=0;
							$nil62_2_10_01=0;
							$angnil62_2_11_01=0;
							$nil62_2_11_01=0;
							$angnil62_2_12_01=0;
							$nil62_2_12_01=0;
							$angnil62_2_13_01=0;
							$nil62_2_13_01=0;
							$angnil62_2_17_01=0;
							$nil62_2_17_01=0;
							$angnil62_4_01_01=0;
							$nil62_4_01_01=0;
							$angnil62_4_02_01=0;
							$nil62_4_02_01=0;
							$angnil62_4_02_02=0;
							$nil62_4_02_02=0;
							$angnil62_4_03_01=0;
							$nil62_4_03_01=0;
							$angnil62_4_05_01=0;
							$nil62_4_05_01=0;
							$angnil62_5_02_01=0;
							$nil62_5_02_01=0;
							$angnil62_5_01_01=0;
							$nil62_5_01_01=0;
							$angnil62_4_06_01=0;
							$nil62_4_06_01=0;
							$angnil62_4_08_01=0;
							$nil62_4_08_01=0;
							$angnil62_4_08_02=0;
							$nil62_4_08_02=0;
							$angnil62_4_08_03=0;
							$nil62_4_08_03=0;
							$angnil62_4_08_04=0;
							$nil62_4_08_04=0;
							$angnil62_4_08_05=0;
							$nil62_4_08_05=0;
							$angnil62_4_08_06=0;
							$nil62_4_08_06=0;
								 
				$sql4="
                select z.kode,z.nama,z.anggaran,z.reali,z.anggaran_1_01_01,
				z.reali_1_01_01,
				z.anggaran_1_02_01,
				z.reali_1_02_01,
				z.anggaran_1_03_01,
				z.reali_1_03_01,
				z.anggaran_1_04_01,
				z.reali_1_04_01,
				z.anggaran_1_05_01,
				z.reali_1_05_01,
				z.anggaran_1_05_02,
				z.reali_1_05_02,
				z.anggaran_1_05_03,
				z.reali_1_05_03,
				z.anggaran_1_06_01,
				z.reali_1_06_01,
				z.anggaran_2_02_01,
				z.reali_2_02_01,
				z.anggaran_2_03_01,
				z.reali_2_03_01,
				z.anggaran_2_05_01,
				z.reali_2_05_01,
				z.anggaran_2_06_01,
				z.reali_2_06_01,
				z.anggaran_2_09_01,
				z.reali_2_09_01,
				z.anggaran_2_10_01,
				z.reali_2_10_01,
				z.anggaran_2_11_01,
				z.reali_2_11_01,
				z.anggaran_2_12_01,
				z.reali_2_12_01,
				z.anggaran_2_13_01,
				z.reali_2_13_01,
				z.anggaran_2_17_01,
				z.reali_2_17_01,
				z.anggaran_4_01_01,
				z.reali_4_01_01,
				z.anggaran_4_02_01,
				z.reali_4_02_01,
				z.anggaran_4_02_02,
				z.reali_4_02_02,
				z.anggaran_4_03_01,
				z.reali_4_03_01,
				z.anggaran_4_05_01,
				z.reali_4_05_01,
				z.anggaran_5_02_01,
				z.reali_5_02_01,
				z.anggaran_5_01_01,
				z.reali_5_01_01,
				z.anggaran_4_06_01,
				z.reali_4_06_01,
				z.anggaran_4_08_01,
				z.reali_4_08_01,
				z.anggaran_4_08_02,
				z.reali_4_08_02,
				z.anggaran_4_08_03,
				z.reali_4_08_03,
				z.anggaran_4_08_04,
				z.reali_4_08_04,
				z.anggaran_4_08_05,
				z.reali_4_08_05,
				z.anggaran_4_08_06,
				z.reali_4_08_06 from (
                SELECT left(a.kd_rek5,2) as kode,b.nm_rek2 as nama,sum(a.nilai_angg) as anggaran,sum(a.nilai_real) as reali,
				sum(nilai_ang_1_01_01) as anggaran_1_01_01,
				sum(nilai_real_1_01_01) as reali_1_01_01,
				sum(nilai_ang_1_02_01) as anggaran_1_02_01,
				sum(nilai_real_1_02_01) as reali_1_02_01,
				sum(nilai_ang_1_03_01) as anggaran_1_03_01,
				sum(nilai_real_1_03_01) as reali_1_03_01,
				sum(nilai_ang_1_04_01) as anggaran_1_04_01,
				sum(nilai_real_1_04_01) as reali_1_04_01,
				sum(nilai_ang_1_05_01) as anggaran_1_05_01,
				sum(nilai_real_1_05_01) as reali_1_05_01,
				sum(nilai_ang_1_05_02) as anggaran_1_05_02,
				sum(nilai_real_1_05_02) as reali_1_05_02,
				sum(nilai_ang_1_05_03) as anggaran_1_05_03,
				sum(nilai_real_1_05_03) as reali_1_05_03,
				sum(nilai_ang_1_06_01) as anggaran_1_06_01,
				sum(nilai_real_1_06_01) as reali_1_06_01,
				sum(nilai_ang_2_02_01) as anggaran_2_02_01,
				sum(nilai_real_2_02_01) as reali_2_02_01,
				sum(nilai_ang_2_03_01) as anggaran_2_03_01,
				sum(nilai_real_2_03_01) as reali_2_03_01,
				sum(nilai_ang_2_05_01) as anggaran_2_05_01,
				sum(nilai_real_2_05_01) as reali_2_05_01,
				sum(nilai_ang_2_06_01) as anggaran_2_06_01,
				sum(nilai_real_2_06_01) as reali_2_06_01,
				sum(nilai_ang_2_09_01) as anggaran_2_09_01,
				sum(nilai_real_2_09_01) as reali_2_09_01,
				sum(nilai_ang_2_10_01) as anggaran_2_10_01,
				sum(nilai_real_2_10_01) as reali_2_10_01,
				sum(nilai_ang_2_11_01) as anggaran_2_11_01,
				sum(nilai_real_2_11_01) as reali_2_11_01,
				sum(nilai_ang_2_12_01) as anggaran_2_12_01,
				sum(nilai_real_2_12_01) as reali_2_12_01,
				sum(nilai_ang_2_13_01) as anggaran_2_13_01,
				sum(nilai_real_2_13_01) as reali_2_13_01,
				sum(nilai_ang_2_17_01) as anggaran_2_17_01,
				sum(nilai_real_2_17_01) as reali_2_17_01,
				sum(nilai_ang_4_01_01) as anggaran_4_01_01,
				sum(nilai_real_4_01_01) as reali_4_01_01,
				sum(nilai_ang_4_02_01) as anggaran_4_02_01,
				sum(nilai_real_4_02_01) as reali_4_02_01,
				sum(nilai_ang_4_02_02) as anggaran_4_02_02,
				sum(nilai_real_4_02_02) as reali_4_02_02,
				sum(nilai_ang_4_03_01) as anggaran_4_03_01,
				sum(nilai_real_4_03_01) as reali_4_03_01,
				sum(nilai_ang_4_05_01) as anggaran_4_05_01,
				sum(nilai_real_4_05_01) as reali_4_05_01,
				sum(nilai_ang_5_02_01) as anggaran_5_02_01,
				sum(nilai_real_5_02_01) as reali_5_02_01,
				sum(nilai_ang_5_01_01) as anggaran_5_01_01,
				sum(nilai_real_5_01_01) as reali_5_01_01,
				sum(nilai_ang_4_06_01) as anggaran_4_06_01,
				sum(nilai_real_4_06_01) as reali_4_06_01,
				sum(nilai_ang_4_08_01) as anggaran_4_08_01,
				sum(nilai_real_4_08_01) as reali_4_08_01,
				sum(nilai_ang_4_08_02) as anggaran_4_08_02,
				sum(nilai_real_4_08_02) as reali_4_08_02,
				sum(nilai_ang_4_08_03) as anggaran_4_08_03,
				sum(nilai_real_4_08_03) as reali_4_08_03,
				sum(nilai_ang_4_08_04) as anggaran_4_08_04,
				sum(nilai_real_4_08_04) as reali_4_08_04,
				sum(nilai_ang_4_08_05) as anggaran_4_08_05,
				sum(nilai_real_4_08_05) as reali_4_08_05,
				sum(nilai_ang_4_08_06) as anggaran_4_08_06,
				sum(nilai_real_4_08_06) as reali_4_08_06 FROM realisasi_rekap_opd( $bulan,$anggaran,$lntahunang) a
                inner join ms_rek2_64 b on b.kd_rek2 = left(a.kd_rek5,2)                
                where left(a.kd_rek5,2)='72' 
                group by left(a.kd_rek5,2),b.nm_rek2
                )z order by kode,nama
                ";
						                 
				$query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil62    = $row4->reali;
					$angnil62 = $row4->anggaran;
					$angnil62_1_01_01  = $row4->anggaran_1_01_01;
					$nil62_1_01_01  = $row4->reali_1_01_01;
					$angnil62_1_02_01  = $row4->anggaran_1_02_01;
					$nil62_1_02_01  = $row4->reali_1_02_01;
					$angnil62_1_03_01  = $row4->anggaran_1_03_01;
					$nil62_1_03_01  = $row4->reali_1_03_01;
					$angnil62_1_04_01  = $row4->anggaran_1_04_01;
					$nil62_1_04_01  = $row4->reali_1_04_01;
					$angnil62_1_05_01  = $row4->anggaran_1_05_01;
					$nil62_1_05_01  = $row4->reali_1_05_01;
					$angnil62_1_05_02  = $row4->anggaran_1_05_02;
					$nil62_1_05_02  = $row4->reali_1_05_02;
					$angnil62_1_05_03  = $row4->anggaran_1_05_03;
					$nil62_1_05_03  = $row4->reali_1_05_03;
					$angnil62_1_06_01  = $row4->anggaran_1_06_01;
					$nil62_1_06_01  = $row4->reali_1_06_01;
					$angnil62_2_02_01  = $row4->anggaran_2_02_01;
					$nil62_2_02_01  = $row4->reali_2_02_01;
					$angnil62_2_03_01  = $row4->anggaran_2_03_01;
					$nil62_2_03_01  = $row4->reali_2_03_01;
					$angnil62_2_05_01  = $row4->anggaran_2_05_01;
					$nil62_2_05_01  = $row4->reali_2_05_01;
					$angnil62_2_06_01  = $row4->anggaran_2_06_01;
					$nil62_2_06_01  = $row4->reali_2_06_01;
					$angnil62_2_09_01  = $row4->anggaran_2_09_01;
					$nil62_2_09_01  = $row4->reali_2_09_01;
					$angnil62_2_10_01  = $row4->anggaran_2_10_01;
					$nil62_2_10_01  = $row4->reali_2_10_01;
					$angnil62_2_11_01  = $row4->anggaran_2_11_01;
					$nil62_2_11_01  = $row4->reali_2_11_01;
					$angnil62_2_12_01  = $row4->anggaran_2_12_01;
					$nil62_2_12_01  = $row4->reali_2_12_01;
					$angnil62_2_13_01  = $row4->anggaran_2_13_01;
					$nil62_2_13_01  = $row4->reali_2_13_01;
					$angnil62_2_17_01  = $row4->anggaran_2_17_01;
					$nil62_2_17_01  = $row4->reali_2_17_01;
					$angnil62_4_01_01  = $row4->anggaran_4_01_01;
					$nil62_4_01_01  = $row4->reali_4_01_01;
					$angnil62_4_02_01  = $row4->anggaran_4_02_01;
					$nil62_4_02_01  = $row4->reali_4_02_01;
					$angnil62_4_02_02  = $row4->anggaran_4_02_02;
					$nil62_4_02_02  = $row4->reali_4_02_02;
					$angnil62_4_03_01  = $row4->anggaran_4_03_01;
					$nil62_4_03_01  = $row4->reali_4_03_01;
					$angnil62_4_05_01  = $row4->anggaran_4_05_01;
					$nil62_4_05_01  = $row4->reali_4_05_01;
					$angnil62_5_02_01  = $row4->anggaran_5_02_01;
					$nil62_5_02_01  = $row4->reali_5_02_01;
					$angnil62_5_01_01  = $row4->anggaran_5_01_01;
					$nil62_5_01_01  = $row4->reali_5_01_01;
					$angnil62_4_06_01  = $row4->anggaran_4_06_01;
					$nil62_4_06_01  = $row4->reali_4_06_01;
					$angnil62_4_08_01  = $row4->anggaran_4_08_01;
					$nil62_4_08_01  = $row4->reali_4_08_01;
					$angnil62_4_08_02  = $row4->anggaran_4_08_02;
					$nil62_4_08_02  = $row4->reali_4_08_02;
					$angnil62_4_08_03  = $row4->anggaran_4_08_03;
					$nil62_4_08_03  = $row4->reali_4_08_03;
					$angnil62_4_08_04  = $row4->anggaran_4_08_04;
					$nil62_4_08_04  = $row4->reali_4_08_04;
					$angnil62_4_08_05  = $row4->anggaran_4_08_05;
					$nil62_4_08_05  = $row4->reali_4_08_05;
					$angnil62_4_08_06  = $row4->anggaran_4_08_06;
					$nil62_4_08_06  = $row4->reali_4_08_06;
					
					
					$angnilai62 =  number_format($angnil62,"2",".",",");
					$nilai62  =  number_format($nil62,"2",".",",");
					$angnilai62_1_01_01     =    number_format($angnil62_1_01_01,"2",".",",");
					$nilai62_1_01_01     =    number_format($nil62_1_01_01,"2",".",",");
					$angnilai62_1_02_01     =    number_format($angnil62_1_02_01,"2",".",",");
					$nilai62_1_02_01     =    number_format($nil62_1_02_01,"2",".",",");
					$angnilai62_1_03_01     =    number_format($angnil62_1_03_01,"2",".",",");
					$nilai62_1_03_01     =    number_format($nil62_1_03_01,"2",".",",");
					$angnilai62_1_04_01     =    number_format($angnil62_1_04_01,"2",".",",");
					$nilai62_1_04_01     =    number_format($nil62_1_04_01,"2",".",",");
					$angnilai62_1_05_01     =    number_format($angnil62_1_05_01,"2",".",",");
					$nilai62_1_05_01     =    number_format($nil62_1_05_01,"2",".",",");
					$angnilai62_1_05_02     =    number_format($angnil62_1_05_02,"2",".",",");
					$nilai62_1_05_02     =    number_format($nil62_1_05_02,"2",".",",");
					$angnilai62_1_05_03     =    number_format($angnil62_1_05_03,"2",".",",");
					$nilai62_1_05_03     =    number_format($nil62_1_05_03,"2",".",",");
					$angnilai62_1_06_01     =    number_format($angnil62_1_06_01,"2",".",",");
					$nilai62_1_06_01     =    number_format($nil62_1_06_01,"2",".",",");
					$angnilai62_2_02_01     =    number_format($angnil62_2_02_01,"2",".",",");
					$nilai62_2_02_01     =    number_format($nil62_2_02_01,"2",".",",");
					$angnilai62_2_03_01     =    number_format($angnil62_2_03_01,"2",".",",");
					$nilai62_2_03_01     =    number_format($nil62_2_03_01,"2",".",",");
					$angnilai62_2_05_01     =    number_format($angnil62_2_05_01,"2",".",",");
					$nilai62_2_05_01     =    number_format($nil62_2_05_01,"2",".",",");
					$angnilai62_2_06_01     =    number_format($angnil62_2_06_01,"2",".",",");
					$nilai62_2_06_01     =    number_format($nil62_2_06_01,"2",".",",");
					$angnilai62_2_09_01     =    number_format($angnil62_2_09_01,"2",".",",");
					$nilai62_2_09_01     =    number_format($nil62_2_09_01,"2",".",",");
					$angnilai62_2_10_01     =    number_format($angnil62_2_10_01,"2",".",",");
					$nilai62_2_10_01     =    number_format($nil62_2_10_01,"2",".",",");
					$angnilai62_2_11_01     =    number_format($angnil62_2_11_01,"2",".",",");
					$nilai62_2_11_01     =    number_format($nil62_2_11_01,"2",".",",");
					$angnilai62_2_12_01     =    number_format($angnil62_2_12_01,"2",".",",");
					$nilai62_2_12_01     =    number_format($nil62_2_12_01,"2",".",",");
					$angnilai62_2_13_01     =    number_format($angnil62_2_13_01,"2",".",",");
					$nilai62_2_13_01     =    number_format($nil62_2_13_01,"2",".",",");
					$angnilai62_2_17_01     =    number_format($angnil62_2_17_01,"2",".",",");
					$nilai62_2_17_01     =    number_format($nil62_2_17_01,"2",".",",");
					$angnilai62_4_01_01     =    number_format($angnil62_4_01_01,"2",".",",");
					$nilai62_4_01_01     =    number_format($nil62_4_01_01,"2",".",",");
					$angnilai62_4_02_01     =    number_format($angnil62_4_02_01,"2",".",",");
					$nilai62_4_02_01     =    number_format($nil62_4_02_01,"2",".",",");
					$angnilai62_4_02_02     =    number_format($angnil62_4_02_02,"2",".",",");
					$nilai62_4_02_02     =    number_format($nil62_4_02_02,"2",".",",");
					$angnilai62_4_03_01     =    number_format($angnil62_4_03_01,"2",".",",");
					$nilai62_4_03_01     =    number_format($nil62_4_03_01,"2",".",",");
					$angnilai62_4_05_01     =    number_format($angnil62_4_05_01,"2",".",",");
					$nilai62_4_05_01     =    number_format($nil62_4_05_01,"2",".",",");
					$angnilai62_5_02_01     =    number_format($angnil62_5_02_01,"2",".",",");
					$nilai62_5_02_01     =    number_format($nil62_5_02_01,"2",".",",");
					$angnilai62_5_01_01     =    number_format($angnil62_5_01_01,"2",".",",");
					$nilai62_5_01_01     =    number_format($nil62_5_01_01,"2",".",",");
					$angnilai62_4_06_01     =    number_format($angnil62_4_06_01,"2",".",",");
					$nilai62_4_06_01     =    number_format($nil62_4_06_01,"2",".",",");
					$angnilai62_4_08_01     =    number_format($angnil62_4_08_01,"2",".",",");
					$nilai62_4_08_01     =    number_format($nil62_4_08_01,"2",".",",");
					$angnilai62_4_08_02     =    number_format($angnil62_4_08_02,"2",".",",");
					$nilai62_4_08_02     =    number_format($nil62_4_08_02,"2",".",",");
					$angnilai62_4_08_03     =    number_format($angnil62_4_08_03,"2",".",",");
					$nilai62_4_08_03     =    number_format($nil62_4_08_03,"2",".",",");
					$angnilai62_4_08_04     =    number_format($angnil62_4_08_04,"2",".",",");
					$nilai62_4_08_04     =    number_format($nil62_4_08_04,"2",".",",");
					$angnilai62_4_08_05     =    number_format($angnil62_4_08_05,"2",".",",");
					$nilai62_4_08_05     =    number_format($nil62_4_08_05,"2",".",",");
					$angnilai62_4_08_06     =    number_format($angnil62_4_08_06,"2",".",",");
					$nilai62_4_08_06     =    number_format($nil62_4_08_06,"2",".",",");
					
                    

                    $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b><b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>JUMLAH $nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai62<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai62<b>
									 </td><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai62_1_01_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai62_1_01_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai62_1_02_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai62_1_02_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai62_1_03_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai62_1_03_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai62_1_04_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai62_1_04_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai62_1_05_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai62_1_05_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai62_1_05_02<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai62_1_05_02<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai62_1_05_03<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai62_1_05_03<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai62_1_06_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai62_1_06_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai62_2_02_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai62_2_02_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai62_2_03_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai62_2_03_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai62_2_05_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai62_2_05_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai62_2_06_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai62_2_06_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai62_2_09_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai62_2_09_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai62_2_10_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai62_2_10_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai62_2_11_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai62_2_11_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai62_2_12_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai62_2_12_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai62_2_13_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai62_2_13_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai62_2_17_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai62_2_17_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai62_4_01_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai62_4_01_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai62_4_02_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai62_4_02_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai62_4_02_02<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai62_4_02_02<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai62_4_03_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai62_4_03_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai62_4_05_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai62_4_05_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai62_5_02_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai62_5_02_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai62_5_01_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai62_5_01_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai62_4_06_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai62_4_06_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai62_4_08_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai62_4_08_01<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai62_4_08_02<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai62_4_08_02<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai62_4_08_03<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai62_4_08_03<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai62_4_08_04<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai62_4_08_04<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai62_4_08_05<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai62_4_08_05<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai62_4_08_06<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai62_4_08_06<b></td>
                                 </tr>";				
				}
							$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                 </tr>";			

					$no 	= '';
					$nama   = 'PEMBIAYAAN NETTO';                      
					$nilnetto    = $nil61 - $nil62;
					$angnilnetto = $angnil61 - $angnil62;
					$angnilnetto_1_01_01 = $angnil61_1_01_01 - $angnil62_1_01_01;
					$nilnetto_1_01_01 = $nil61_1_01_01 - $nil62_1_01_01;
					$angnilnetto_1_02_01 = $angnil61_1_02_01 - $angnil62_1_02_01;
					$nilnetto_1_02_01 = $nil61_1_02_01 - $nil62_1_02_01;
					$angnilnetto_1_03_01 = $angnil61_1_03_01 - $angnil62_1_03_01;
					$nilnetto_1_03_01 = $nil61_1_03_01 - $nil62_1_03_01;
					$angnilnetto_1_04_01 = $angnil61_1_04_01 - $angnil62_1_04_01;
					$nilnetto_1_04_01 = $nil61_1_04_01 - $nil62_1_04_01;
					$angnilnetto_1_05_01 = $angnil61_1_05_01 - $angnil62_1_05_01;
					$nilnetto_1_05_01 = $nil61_1_05_01 - $nil62_1_05_01;
					$angnilnetto_1_05_02 = $angnil61_1_05_02 - $angnil62_1_05_02;
					$nilnetto_1_05_02 = $nil61_1_05_02 - $nil62_1_05_02;
					$angnilnetto_1_05_03 = $angnil61_1_05_03 - $angnil62_1_05_03;
					$nilnetto_1_05_03 = $nil61_1_05_03 - $nil62_1_05_03;
					$angnilnetto_1_06_01 = $angnil61_1_06_01 - $angnil62_1_06_01;
					$nilnetto_1_06_01 = $nil61_1_06_01 - $nil62_1_06_01;
					$angnilnetto_2_02_01 = $angnil61_2_02_01 - $angnil62_2_02_01;
					$nilnetto_2_02_01 = $nil61_2_02_01 - $nil62_2_02_01;
					$angnilnetto_2_03_01 = $angnil61_2_03_01 - $angnil62_2_03_01;
					$nilnetto_2_03_01 = $nil61_2_03_01 - $nil62_2_03_01;
					$angnilnetto_2_05_01 = $angnil61_2_05_01 - $angnil62_2_05_01;
					$nilnetto_2_05_01 = $nil61_2_05_01 - $nil62_2_05_01;
					$angnilnetto_2_06_01 = $angnil61_2_06_01 - $angnil62_2_06_01;
					$nilnetto_2_06_01 = $nil61_2_06_01 - $nil62_2_06_01;
					$angnilnetto_2_09_01 = $angnil61_2_09_01 - $angnil62_2_09_01;
					$nilnetto_2_09_01 = $nil61_2_09_01 - $nil62_2_09_01;
					$angnilnetto_2_10_01 = $angnil61_2_10_01 - $angnil62_2_10_01;
					$nilnetto_2_10_01 = $nil61_2_10_01 - $nil62_2_10_01;
					$angnilnetto_2_11_01 = $angnil61_2_11_01 - $angnil62_2_11_01;
					$nilnetto_2_11_01 = $nil61_2_11_01 - $nil62_2_11_01;
					$angnilnetto_2_12_01 = $angnil61_2_12_01 - $angnil62_2_12_01;
					$nilnetto_2_12_01 = $nil61_2_12_01 - $nil62_2_12_01;
					$angnilnetto_2_13_01 = $angnil61_2_13_01 - $angnil62_2_13_01;
					$nilnetto_2_13_01 = $nil61_2_13_01 - $nil62_2_13_01;
					$angnilnetto_2_17_01 = $angnil61_2_17_01 - $angnil62_2_17_01;
					$nilnetto_2_17_01 = $nil61_2_17_01 - $nil62_2_17_01;
					$angnilnetto_4_01_01 = $angnil61_4_01_01 - $angnil62_4_01_01;
					$nilnetto_4_01_01 = $nil61_4_01_01 - $nil62_4_01_01;
					$angnilnetto_4_02_01 = $angnil61_4_02_01 - $angnil62_4_02_01;
					$nilnetto_4_02_01 = $nil61_4_02_01 - $nil62_4_02_01;
					$angnilnetto_4_02_02 = $angnil61_4_02_02 - $angnil62_4_02_02;
					$nilnetto_4_02_02 = $nil61_4_02_02 - $nil62_4_02_02;
					$angnilnetto_4_03_01 = $angnil61_4_03_01 - $angnil62_4_03_01;
					$nilnetto_4_03_01 = $nil61_4_03_01 - $nil62_4_03_01;
					$angnilnetto_4_05_01 = $angnil61_4_05_01 - $angnil62_4_05_01;
					$nilnetto_4_05_01 = $nil61_4_05_01 - $nil62_4_05_01;
					$angnilnetto_5_02_01 = $angnil61_5_02_01 - $angnil62_5_02_01;
					$nilnetto_5_02_01 = $nil61_5_02_01 - $nil62_5_02_01;
					$angnilnetto_5_01_01 = $angnil61_5_01_01 - $angnil62_5_01_01;
					$nilnetto_5_01_01 = $nil61_5_01_01 - $nil62_5_01_01;
					$angnilnetto_4_06_01 = $angnil61_4_06_01 - $angnil62_4_06_01;
					$nilnetto_4_06_01 = $nil61_4_06_01 - $nil62_4_06_01;
					$angnilnetto_4_08_01 = $angnil61_4_08_01 - $angnil62_4_08_01;
					$nilnetto_4_08_01 = $nil61_4_08_01 - $nil62_4_08_01;
					$angnilnetto_4_08_02 = $angnil61_4_08_02 - $angnil62_4_08_02;
					$nilnetto_4_08_02 = $nil61_4_08_02 - $nil62_4_08_02;
					$angnilnetto_4_08_03 = $angnil61_4_08_03 - $angnil62_4_08_03;
					$nilnetto_4_08_03 = $nil61_4_08_03 - $nil62_4_08_03;
					$angnilnetto_4_08_04 = $angnil61_4_08_04 - $angnil62_4_08_04;
					$nilnetto_4_08_04 = $nil61_4_08_04 - $nil62_4_08_04;
					$angnilnetto_4_08_05 = $angnil61_4_08_05 - $angnil62_4_08_05;
					$nilnetto_4_08_05 = $nil61_4_08_05 - $nil62_4_08_05;
					$angnilnetto_4_08_06 = $angnil61_4_08_06 - $angnil62_4_08_06;
					$nilnetto_4_08_06 = $nil61_4_08_06 - $nil62_4_08_06;
					

                    if ($nilnetto==0){
                        $tmp=1;
                    }else{
                        $tmp=$nilnetto;
                    }
					
				if ($nilnetto_1_01_01==0){
				   $tmp=1;                     
				   }else{ 
				   $tmp=$nilnetto_1_01_01;                    
				   }
				   
				if ($nilnetto_1_02_01==0){ 
				  $tmp=1;                     
				  }else{ 
				  $tmp=$nilnetto_1_02_01;   
				  }
				  
				if ($nilnetto_1_03_01==0){
				   $tmp=1;                    
				   }else{        
				   $tmp=$nilnetto_1_03_01;
				   }
				   
				if ($nilnetto_1_04_01==0){ 
				  $tmp=1;                    
				  }else{          
				  $tmp=$nilnetto_1_04_01; 
				  }
				  
				if ($nilnetto_1_05_01==0){
				   $tmp=1;                     
				   }else{               
				   $tmp=$nilnetto_1_05_01;  
				   }
				   
				if ($nilnetto_1_05_02==0){  
				 $tmp=1;                    
				 }else{                         
				 $tmp=$nilnetto_1_05_02;  
				 }
				 
				if ($nilnetto_1_05_03==0){   
				$tmp=1;                    
				 }else{                       
				 $tmp=$nilnetto_1_05_03; 
				 }
				 
				if ($nilnetto_1_06_01==0){  
				 $tmp=1;                   
				 }else{                        
				 $tmp=$nilnetto_1_06_01;   
				 }
				 
				if ($nilnetto_2_02_01==0){ 
				  $tmp=1;                    
				  }else{                       
				  $tmp=$nilnetto_2_02_01;   
				  }
				  
				if ($nilnetto_2_03_01==0){ 
				  $tmp=1;                    
				  }else{                        
				  $tmp=$nilnetto_2_03_01;    
				  }
				  
				if ($nilnetto_2_05_01==0){ 
				  $tmp=1;                     
				  }else{                         
				  $tmp=$nilnetto_2_05_01;    
				  }
				  
				if ($nilnetto_2_06_01==0){ 
				  $tmp=1;                   
				  }else{                  
				  $tmp=$nilnetto_2_06_01;     
				  }
				  
				if ($nilnetto_2_09_01==0){
				   $tmp=1;                    
				   }else{                         
				   $tmp=$nilnetto_2_09_01;  
				   }
				   
				if ($nilnetto_2_10_01==0){ 
				  $tmp=1;                    
				  }else{                  
				  $tmp=$nilnetto_2_10_01;
				  }
				  
				if ($nilnetto_2_11_01==0){  
				 $tmp=1;                   
				 }else{                         
				 $tmp=$nilnetto_2_11_01;    
				 }
				 
				if ($nilnetto_2_12_01==0){ 
				  $tmp=1;                    
				  }else{                        
				  $tmp=$nilnetto_2_12_01;  
				  }
				  
				if ($nilnetto_2_13_01==0){ 
				  $tmp=1;                     
				  }else{                      
				  $tmp=$nilnetto_2_13_01;                
				  }
				  
				if ($nilnetto_2_17_01==0){ 
				  $tmp=1;                   
				  }else{                       
				  $tmp=$nilnetto_2_17_01; 
				  }
				  
				if ($nilnetto_4_01_01==0){   
				$tmp=1;                   
				  }else{                       
				  $tmp=$nilnetto_4_01_01;  
				  }
				  
				if ($nilnetto_4_02_01==0){
				   $tmp=1;                    
				   }else{                        
				   $tmp=$nilnetto_4_02_01;  
				   }
				   
				if ($nilnetto_4_02_02==0){ 
				  $tmp=1;                    
				  }else{                     
				  $tmp=$nilnetto_4_02_02;
				  }
				  
				if ($nilnetto_4_03_01==0){ 
				  $tmp=1;                    
				  }else{                       
				  $tmp=$nilnetto_4_03_01; 
				  }
				  
				if ($nilnetto_4_05_01==0){  
				 $tmp=1;                    
				 }else{                        
				 $tmp=$nilnetto_4_05_01;          
				 }
				 
				if ($nilnetto_5_02_01==0){ 
				  $tmp=1;                  
				  }else{                       
				  $tmp=$nilnetto_5_02_01;  
				  }
				  
				if ($nilnetto_5_01_01==0){  
				 $tmp=1;                    
				 }else{                      
				 $tmp=$nilnetto_5_01_01;      
				 }
				 
				if ($nilnetto_4_06_01==0){   
				$tmp=1;                    
				 }else{                       
				 $tmp=$nilnetto_4_06_01;    
				 }
				 
				if ($nilnetto_4_08_01==0){ 
				  $tmp=1;                   
				  }else{                      
				  $tmp=$nilnetto_4_08_01;  
				  }
				  
				if ($nilnetto_4_08_02==0){  
				 $tmp=1;                  
				 }else{                      
				 $tmp=$nilnetto_4_08_02; 
				 }
				 
				if ($nilnetto_4_08_03==0){  
				 $tmp=1;                  
				 }else{                        
				 $tmp=$nilnetto_4_08_03;  
				 }
				 
				if ($nilnetto_4_08_04==0){  
				 $tmp=1;                   
				 }else{                      
				 $tmp=$nilnetto_4_08_04; 
				 }
				 
				if ($nilnetto_4_08_05==0){  
				 $tmp=1;                    
				 }else{                       
				 $tmp=$nilnetto_4_08_05;   
				 }
				 
				if ($nilnetto_4_08_06==0){  
				 $tmp=1;                  
				 }else{                      
				 $tmp=$nilnetto_4_08_06;   
				 }
				 
				if ($angnilnetto < 0){
                    	$ax1="("; $angnilnetto=$angnilnetto*-1; $ax2=")";}
                    else {
                    	$ax1=""; $ax2="";}

                    if ($nilnetto < 0){
                    	$bx1="("; $nilnetto=$nilnetto*-1; $bx2=")";}
                    else {
                    	$bx1=""; $bx2="";}
						
					if($nilnetto_1_01_01<0){
					  $az1="("; $nilnetto_1_01_01=$nilnetto_1_01_01*-1; $az2=")";}  
					  else{ 
					  $az1=""; $az2="";}
					  
					if($angnilnetto_1_01_01<0){
					  $bz1="("; $angnilnetto_1_01_01=$angnilnetto_1_01_01*-1; $bz2=")";}  
					  else {
					  $bz1=""; $bz2="";}
					  
					if($nilnetto_1_02_01< 0){
					  $ac1="("; $nilnetto_1_02_01 = $nilnetto_1_02_01*-1; $ac2=")";}  
					  else {
					  $ac1=""; $ac2="";}
					  
					if($angnilnetto_1_02_01< 0){
					  $bc1="("; $angnilnetto_1_02_01 = $angnilnetto_1_02_01*-1; $bc2=")";}
					  else { 
					  $bc1=""; $bc2="";}
					  
					if($nilnetto_1_03_01< 0){
					  $av1="("; $nilnetto_1_03_01 = $nilnetto_1_03_01*-1; $av2=")";}  
					  else {
					  $av1=""; $av2="";}
					  
					if($angnilnetto_1_03_01< 0){
					  $bv1="("; $angnilnetto_1_03_01 = $angnilnetto_1_03_01*-1; $bv2=")";}  
					  else {
					  $bv1=""; $bv2="";}
					  
					if($nilnetto_1_04_01< 0){
					  $ab1="("; $nilnetto_1_04_01 = $nilnetto_1_04_01*-1; $ab2=")";}  
					  else { 
					  $ab1=""; $ab2="";}
					  
					if($angnilnetto_1_04_01< 0){
					  $bb1="("; $angnilnetto_1_04_01 = $angnilnetto_1_04_01*-1; $bb2=")";}
					  else { 
					  $bb1=""; $bb2="";}
					  
					if($nilnetto_1_05_01< 0){ 
					 $an1="("; $nilnetto_1_05_01 = $nilnetto_1_05_01*-1; $an2=")";} 
					 else { 
					 $an1=""; $an2="";}
					 
					if($angnilnetto_1_05_01< 0){ 
					 $bn1="("; $angnilnetto_1_05_01 = $angnilnetto_1_05_01*-1; $bn2=")";}  
					 else {
					 $bn1=""; $bn2="";}
					 
					if($nilnetto_1_05_02< 0){
					  $am1="("; $nilnetto_1_05_02 = $nilnetto_1_05_02*-1; $am2=")";}  
					  else { 
					  $am1=""; $am2="";}
					  
					if($angnilnetto_1_05_02< 0){
					  $bm1="("; $angnilnetto_1_05_02 = $angnilnetto_1_05_02*-1; $bm2=")";}  
					  else {
					  $bm1=""; $bm2="";}
					  
					if($nilnetto_1_05_03< 0){ 
					 $aa1="("; $nilnetto_1_05_03 = $nilnetto_1_05_03*-1; $aa2=")";}  
					 else {
					 $aa1=""; $aa2="";}
					 
					if($angnilnetto_1_05_03< 0){ 
					 $ba1="("; $angnilnetto_1_05_03 = $angnilnetto_1_05_03*-1; $ba2=")";}  
					 else {
					 $ba1=""; $ba2="";}
					 
					if($nilnetto_1_06_01< 0){
					  $as1="("; $nilnetto_1_06_01 = $nilnetto_1_06_01*-1; $as2=")";}  
					  else {
					  $as1=""; $as2="";}
					  
					if($angnilnetto_1_06_01< 0){
					  $bs1="("; $angnilnetto_1_06_01 = $angnilnetto_1_06_01*-1; $bs2=")";}
					  else {
					  $bs1=""; $bs2="";}
					  
					if($nilnetto_2_02_01< 0){
					  $ad1="("; $nilnetto_2_02_01 = $nilnetto_2_02_01*-1; $ad2=")";}  
					  else { 
					  $ad1=""; $ad2="";}
					  
					if($angnilnetto_2_02_01< 0){
					  $bd1="("; $angnilnetto_2_02_01 = $angnilnetto_2_02_01*-1; $bd2=")";}
					  else {
					  $bd1=""; $bd2="";}
					  
					if($nilnetto_2_03_01< 0){
					  $af1="("; $nilnetto_2_03_01 = $nilnetto_2_03_01*-1; $af2=")";}
					  else {
					  $af1=""; $af2="";}
					  
					if($angnilnetto_2_03_01< 0){
					  $bf1="("; $angnilnetto_2_03_01 = $angnilnetto_2_03_01*-1; $bf2=")";}  
					  else { 
					  $bf1=""; $bf2="";}
					  
					if($nilnetto_2_05_01< 0){
					  $ag1="("; $nilnetto_2_05_01 = $nilnetto_2_05_01*-1; $ag2=")";}
					  else {
					  $ag1=""; $ag2="";}
					  
					if($angnilnetto_2_05_01< 0){
					  $bg1="("; $angnilnetto_2_05_01 = $angnilnetto_2_05_01*-1; $bg2=")";}  
					  else {
					  $bg1=""; $bg2="";}
					  
					if($nilnetto_2_06_01< 0){
					  $ah1="("; $nilnetto_2_06_01 = $nilnetto_2_06_01*-1; $ah2=")";}
					  else { 
					  $ah1=""; $ah2="";}
					  
					if($angnilnetto_2_06_01< 0){
					  $bh1="("; $angnilnetto_2_06_01 = $angnilnetto_2_06_01*-1; $bh2=")";}  
					  else {
					  $bh1=""; $bh2="";}
					  
					if($nilnetto_2_09_01< 0){ 
					$aj1="("; $nilnetto_2_09_01 = $nilnetto_2_09_01*-1; $aj2=")";} 
					 else { 
					 $aj1=""; $aj2="";}
					 
					if($angnilnetto_2_09_01< 0){
					  $bj1="("; $angnilnetto_2_09_01 = $angnilnetto_2_09_01*-1; $bj2=")";}  
					  else {
					  $bj1=""; $bj2="";}
					  
					if($nilnetto_2_10_01< 0){
					  $ak1="("; $nilnetto_2_10_01 = $nilnetto_2_10_01*-1; $ak2=")";}  
					  else { 
					  $ak1=""; $ak2="";}
					  
					if($angnilnetto_2_10_01< 0){
					  $bk1="("; $angnilnetto_2_10_01 = $angnilnetto_2_10_01*-1; $bk2=")";}  
					  else {
					  $bk1=""; $bk2="";}
					  
					if($nilnetto_2_11_01< 0){
					  $al1="("; $nilnetto_2_11_01 = $nilnetto_2_11_01*-1; $al2=")";} 
					  else {
					  $al1=""; $al2="";}
					  
					if($angnilnetto_2_11_01< 0){ 
					 $bl1="("; $angnilnetto_2_11_01 = $angnilnetto_2_11_01*-1; $bl2=")";} 
					 else {
					 $bl1=""; $bl2="";}
					 
					if($nilnetto_2_12_01< 0){ 
					 $aq1="("; $nilnetto_2_12_01 = $nilnetto_2_12_01*-1; $aq2=")";}  
					 else { 
					 $aq1=""; $aq2="";}
					 
					if($angnilnetto_2_12_01< 0){ 
					 $bq1="("; $angnilnetto_2_12_01 = $angnilnetto_2_12_01*-1; $bq2=")";} 
					 else {
					 $bq1=""; $bq2="";}
					 
					if($nilnetto_2_13_01< 0){
					  $aw1="("; $nilnetto_2_13_01 = $nilnetto_2_13_01*-1; $aw2=")";}
					  else {
					  $aw1=""; $aw2="";}
					  
					if($angnilnetto_2_13_01< 0){
					  $bw1="("; $angnilnetto_2_13_01 = $angnilnetto_2_13_01*-1; $bw2=")";}
					  else {
					  $bw1=""; $bw2="";}
					  
					if($nilnetto_2_17_01< 0){
					  $ae1="("; $nilnetto_2_17_01 = $nilnetto_2_17_01*-1; $ae2=")";}  
					  else { 
					  $ae1=""; $ae2="";}
					  
					if($angnilnetto_2_17_01< 0){
					  $be1="("; $angnilnetto_2_17_01 = $angnilnetto_2_17_01*-1; $be2=")";}
					  else {
					  $be1=""; $be2="";}
					  
					if($nilnetto_4_01_01< 0){
					  $ar1="("; $nilnetto_4_01_01 = $nilnetto_4_01_01*-1; $ar2=")";}
					  else {
					  $ar1=""; $ar2="";}
					  
					if($angnilnetto_4_01_01< 0){
					  $br1="("; $angnilnetto_4_01_01 = $angnilnetto_4_01_01*-1; $br2=")";}
					  else {
					  $br1=""; $br2="";}
					  
					if($nilnetto_4_02_01< 0){
					  $at1="("; $nilnetto_4_02_01 = $nilnetto_4_02_01*-1; $at2=")";}
					  else {
					  $at1=""; $at2="";}
					  
					if($angnilnetto_4_02_01< 0){ 
					 $bt1="("; $angnilnetto_4_02_01 = $angnilnetto_4_02_01*-1; $bt2=")";} 
					 else {
					 $bt1=""; $bt2="";}
					 
					if($nilnetto_4_02_02< 0){
					  $ay1="("; $nilnetto_4_02_02 = $nilnetto_4_02_02*-1; $ay2=")";} 
					  else { 
					  $ay1=""; $ay2="";}
					  
					if($angnilnetto_4_02_02< 0){ 
					 $by1="("; $angnilnetto_4_02_02 = $angnilnetto_4_02_02*-1; $by2=")";} 
					 else { 
					 $by1=""; $by2="";}
					 
					if($nilnetto_4_03_01< 0){ 
					 $au1="("; $nilnetto_4_03_01 = $nilnetto_4_03_01*-1; $au2=")";}
					 else {  
					 $au1=""; $au2="";}
					 
					if($angnilnetto_4_03_01< 0){ 
					 $bu1="("; $angnilnetto_4_03_01 = $angnilnetto_4_03_01*-1; $bu2=")";}
					 else { 
					 $bu1=""; $bu2="";}
					 
					if($nilnetto_4_05_01< 0){ 
					 $ai1="("; $nilnetto_4_05_01 = $nilnetto_4_05_01*-1; $ai2=")";} 
					 else {
					 $ai1=""; $ai2="";}
					 
					if($angnilnetto_4_05_01< 0){ 
					 $bi1="("; $angnilnetto_4_05_01 = $angnilnetto_4_05_01*-1; $bi2=")";}
					 else { 
					 $bi1=""; $bi2="";}
					 
					if($nilnetto_5_02_01< 0){ 
					 $ao1="("; $nilnetto_5_02_01 = $nilnetto_5_02_01*-1; $ao2=")";}
					 else {
					 $ao1=""; $ao2="";}
					 
					if($angnilnetto_5_02_01< 0){
					  $bo1="("; $angnilnetto_5_02_01 = $angnilnetto_5_02_01*-1; $bo2=")";} 
					  else {  
					  $bo1=""; $bo2="";}
					  
					if($nilnetto_5_01_01< 0){
					  $za1="("; $nilnetto_5_01_01 = $nilnetto_5_01_01*-1; $za2=")";}
					  else {
					  $za1=""; $za2="";}
					  
					if($angnilnetto_5_01_01< 0){
					  $zb1="("; $angnilnetto_5_01_01 = $angnilnetto_5_01_01*-1; $zb2=")";}
					  else { 
					  $zb1=""; $zb2="";}
					  
					if($nilnetto_4_06_01< 0){
					  $xa1="("; $nilnetto_4_06_01 = $nilnetto_4_06_01*-1; $xa2=")";}
					  else { 
					  $xa1=""; $xa2="";}
					  
					if($angnilnetto_4_06_01< 0){
					  $xb1="("; $angnilnetto_4_06_01 = $angnilnetto_4_06_01*-1; $xb2=")";} 
					  else { 
					  $xb1=""; $xb2="";}
					  
					if($nilnetto_4_08_01< 0){
					  $ca1="("; $nilnetto_4_08_01 = $nilnetto_4_08_01*-1; $ca2=")";} 
					  else { 
					  $ca1=""; $ca2="";}
					  
					if($angnilnetto_4_08_01< 0){
					  $cb1="("; $angnilnetto_4_08_01 = $angnilnetto_4_08_01*-1; $cb2=")";} 
					  else {
					  $cb1=""; $cb2="";}
					  
					if($nilnetto_4_08_02< 0){
					  $va1="("; $nilnetto_4_08_02 = $nilnetto_4_08_02*-1; $va2=")";}
					  else {
					  $va1=""; $va2="";}
					  
					if($angnilnetto_4_08_02< 0){
					  $vb1="("; $angnilnetto_4_08_02 = $angnilnetto_4_08_02*-1; $vb2=")";}
					  else { 
					  $vb1=""; $vb2="";}
					  
					if($nilnetto_4_08_03< 0){ 
					 $na1="("; $nilnetto_4_08_03 = $nilnetto_4_08_03*-1; $na2=")";}
					 else { 
					 $na1=""; $na2="";}
					 
					if($angnilnetto_4_08_03< 0){
					  $nb1="("; $angnilnetto_4_08_03 = $angnilnetto_4_08_03*-1; $nb2=")";}
					  else {  
					  $nb1=""; $nb2="";}
					  
					if($nilnetto_4_08_04< 0){
					  $ma1="("; $nilnetto_4_08_04 = $nilnetto_4_08_04*-1; $ma2=")";}
					  else {
					  $ma1=""; $ma2="";}
					  
					if($angnilnetto_4_08_04< 0){ 
					 $mb1="("; $angnilnetto_4_08_04 = $angnilnetto_4_08_04*-1; $mb2=")";}
					 else {
					 $mb1=""; $mb2="";}
					 
					if($nilnetto_4_08_05< 0){ 
					 $sa1="("; $nilnetto_4_08_05 = $nilnetto_4_08_05*-1; $sa2=")";} 
					 else { 
					 $sa1=""; $sa2="";}
					 
					if($angnilnetto_4_08_05< 0){ 
					 $sb1="("; $angnilnetto_4_08_05 = $angnilnetto_4_08_05*-1; $sb2=")";} 
					 else { 
					 $sb1=""; $sb2="";}
					 
					if($nilnetto_4_08_06< 0){ 
					 $da1="("; $nilnetto_4_08_06 = $nilnetto_4_08_06*-1; $da2=")";}
					 else {
					 $da1=""; $da2="";}
					 
					if($angnilnetto_4_08_06< 0){ 
					 $db1="("; $angnilnetto_4_08_06 = $angnilnetto_4_08_06*-1; $db2=")";}
					 else { 
					 $db1=""; $db2="";}

                    $nilai    = number_format($nilnetto,"2",".",",");
                    $angnilai = number_format($angnilnetto,"2",".",",");
					$angnilai_1_01_01	= number_format($angnilnetto_1_01_01,"2",".",",");
					$nilai_1_01_01	= number_format($nilnetto_1_01_01,"2",".",",");
					$angnilai_1_02_01     =    number_format($angnilnetto_1_02_01,"2",".",",");
					$nilai_1_02_01     =    number_format($nilnetto_1_02_01,"2",".",",");
					$angnilai_1_03_01     =    number_format($angnilnetto_1_03_01,"2",".",",");
					$nilai_1_03_01     =    number_format($nilnetto_1_03_01,"2",".",",");
					$angnilai_1_04_01     =    number_format($angnilnetto_1_04_01,"2",".",",");
					$nilai_1_04_01     =    number_format($nilnetto_1_04_01,"2",".",",");
					$angnilai_1_05_01     =    number_format($angnilnetto_1_05_01,"2",".",",");
					$nilai_1_05_01     =    number_format($nilnetto_1_05_01,"2",".",",");
					$angnilai_1_05_02     =    number_format($angnilnetto_1_05_02,"2",".",",");
					$nilai_1_05_02     =    number_format($nilnetto_1_05_02,"2",".",",");
					$angnilai_1_05_03     =    number_format($angnilnetto_1_05_03,"2",".",",");
					$nilai_1_05_03     =    number_format($nilnetto_1_05_03,"2",".",",");
					$angnilai_1_06_01     =    number_format($angnilnetto_1_06_01,"2",".",",");
					$nilai_1_06_01     =    number_format($nilnetto_1_06_01,"2",".",",");
					$angnilai_2_02_01     =    number_format($angnilnetto_2_02_01,"2",".",",");
					$nilai_2_02_01     =    number_format($nilnetto_2_02_01,"2",".",",");
					$angnilai_2_03_01     =    number_format($angnilnetto_2_03_01,"2",".",",");
					$nilai_2_03_01     =    number_format($nilnetto_2_03_01,"2",".",",");
					$angnilai_2_05_01     =    number_format($angnilnetto_2_05_01,"2",".",",");
					$nilai_2_05_01     =    number_format($nilnetto_2_05_01,"2",".",",");
					$angnilai_2_06_01     =    number_format($angnilnetto_2_06_01,"2",".",",");
					$nilai_2_06_01     =    number_format($nilnetto_2_06_01,"2",".",",");
					$angnilai_2_09_01     =    number_format($angnilnetto_2_09_01,"2",".",",");
					$nilai_2_09_01     =    number_format($nilnetto_2_09_01,"2",".",",");
					$angnilai_2_10_01     =    number_format($angnilnetto_2_10_01,"2",".",",");
					$nilai_2_10_01     =    number_format($nilnetto_2_10_01,"2",".",",");
					$angnilai_2_11_01     =    number_format($angnilnetto_2_11_01,"2",".",",");
					$nilai_2_11_01     =    number_format($nilnetto_2_11_01,"2",".",",");
					$angnilai_2_12_01     =    number_format($angnilnetto_2_12_01,"2",".",",");
					$nilai_2_12_01     =    number_format($nilnetto_2_12_01,"2",".",",");
					$angnilai_2_13_01     =    number_format($angnilnetto_2_13_01,"2",".",",");
					$nilai_2_13_01     =    number_format($nilnetto_2_13_01,"2",".",",");
					$angnilai_2_17_01     =    number_format($angnilnetto_2_17_01,"2",".",",");
					$nilai_2_17_01     =    number_format($nilnetto_2_17_01,"2",".",",");
					$angnilai_4_01_01     =    number_format($angnilnetto_4_01_01,"2",".",",");
					$nilai_4_01_01     =    number_format($nilnetto_4_01_01,"2",".",",");
					$angnilai_4_02_01     =    number_format($angnilnetto_4_02_01,"2",".",",");
					$nilai_4_02_01     =    number_format($nilnetto_4_02_01,"2",".",",");
					$angnilai_4_02_02     =    number_format($angnilnetto_4_02_02,"2",".",",");
					$nilai_4_02_02     =    number_format($nilnetto_4_02_02,"2",".",",");
					$angnilai_4_03_01     =    number_format($angnilnetto_4_03_01,"2",".",",");
					$nilai_4_03_01     =    number_format($nilnetto_4_03_01,"2",".",",");
					$angnilai_4_05_01     =    number_format($angnilnetto_4_05_01,"2",".",",");
					$nilai_4_05_01     =    number_format($nilnetto_4_05_01,"2",".",",");
					$angnilai_5_02_01     =    number_format($angnilnetto_5_02_01,"2",".",",");
					$nilai_5_02_01     =    number_format($nilnetto_5_02_01,"2",".",",");
					$angnilai_5_01_01     =    number_format($angnilnetto_5_01_01,"2",".",",");
					$nilai_5_01_01     =    number_format($nilnetto_5_01_01,"2",".",",");
					$angnilai_4_06_01     =    number_format($angnilnetto_4_06_01,"2",".",",");
					$nilai_4_06_01     =    number_format($nilnetto_4_06_01,"2",".",",");
					$angnilai_4_08_01     =    number_format($angnilnetto_4_08_01,"2",".",",");
					$nilai_4_08_01     =    number_format($nilnetto_4_08_01,"2",".",",");
					$angnilai_4_08_02     =    number_format($angnilnetto_4_08_02,"2",".",",");
					$nilai_4_08_02     =    number_format($nilnetto_4_08_02,"2",".",",");
					$angnilai_4_08_03     =    number_format($angnilnetto_4_08_03,"2",".",",");
					$nilai_4_08_03     =    number_format($nilnetto_4_08_03,"2",".",",");
					$angnilai_4_08_04     =    number_format($angnilnetto_4_08_04,"2",".",",");
					$nilai_4_08_04     =    number_format($nilnetto_4_08_04,"2",".",",");
					$angnilai_4_08_05     =    number_format($angnilnetto_4_08_05,"2",".",",");
					$nilai_4_08_05     =    number_format($nilnetto_4_08_05,"2",".",",");
					$angnilai_4_08_06     =    number_format($angnilnetto_4_08_06,"2",".",",");
					$nilai_4_08_06     =    number_format($nilnetto_4_08_06,"2",".",",");
                   
                   $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$ax1$angnilai$ax2</b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$bx1$nilai$bx2</b></td>
									 <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$bz1$angnilai_1_01_01$bz2</b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$az1$nilai_1_01_01$az2</b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$bc1$angnilai_1_02_01$bc2</b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$ac1$nilai_1_02_01$ac2</b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$bv1$angnilai_1_03_01$bv2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$av1$nilai_1_03_01$av2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$bb1$angnilai_1_04_01$bb2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$ab1$nilai_1_04_01$ab2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$bn1$angnilai_1_05_01$bn2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$an1$nilai_1_05_01$an2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$bm1$angnilai_1_05_02$bm2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$am1$nilai_1_05_02$am2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$ba1$angnilai_1_05_03$ba2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$aa1$nilai_1_05_03$aa2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$bs1$angnilai_1_06_01$bs2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$as1$nilai_1_06_01$as2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$bd1$angnilai_2_02_01$bd2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$ad1$nilai_2_02_01$ad2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$bf1$angnilai_2_03_01$bf2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$af1$nilai_2_03_01$af2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$bg1$angnilai_2_05_01$bg2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$ag1$nilai_2_05_01$ag2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$bh1$angnilai_2_06_01$bh2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$ah1$nilai_2_06_01$ah2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$bj1$angnilai_2_09_01$bj2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$aj1$nilai_2_09_01$aj2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$bk1$angnilai_2_10_01$bk2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$ak1$nilai_2_10_01$ak2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$bl1$angnilai_2_11_01$bl2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$al1$nilai_2_11_01$al2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$bq1$angnilai_2_12_01$bq2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$aq1$nilai_2_12_01$aq2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$bw1$angnilai_2_13_01$bw2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$aw1$nilai_2_13_01$aw2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$be1$angnilai_2_17_01$be2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$ae1$nilai_2_17_01$ae2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$br1$angnilai_4_01_01$br2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$ar1$nilai_4_01_01$ar2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$bt1$angnilai_4_02_01$bt2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$at1$nilai_4_02_01$at2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$by1$angnilai_4_02_02$by2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$ay1$nilai_4_02_02$ay2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$bu1$angnilai_4_03_01$bu2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$au1$nilai_4_03_01$au2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$bi1$angnilai_4_05_01$bi2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$ai1$nilai_4_05_01$ai2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$bo1$angnilai_5_02_01$bo2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$ao1$nilai_5_02_01$ao2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$zb1$angnilai_5_01_01$zb2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$za1$nilai_5_01_01$za2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$xb1$angnilai_4_06_01$xb2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$xa1$nilai_4_06_01$xa2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$cb1$angnilai_4_08_01$cb2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$ca1$nilai_4_08_01$ca2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$vb1$angnilai_4_08_02$vb2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$va1$nilai_4_08_02$va2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nb1$angnilai_4_08_03$nb2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$na1$nilai_4_08_03$na2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$mb1$angnilai_4_08_04$mb2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$ma1$nilai_4_08_04$ma2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$sb1$angnilai_4_08_05$sb2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$sa1$nilai_4_08_05$sa2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$db1$angnilai_4_08_06$db2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$da1$nilai_4_08_06$da2<b></td>
                                 </tr>";        								 


								 
					$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                 </tr>";												 
								 
					$no 	= '';
					$nama   = 'SISA LEBIH PEMBIYAAN ANGGARAN TAHUN BERKENAAN (SILPA)';  					
					$angnilsilpa  = ($angnil4 + $angnil61)  -  ($angnil5 + $angnil62);
					$nilsilpa  = ($nil4 + $nil61)  -  ($nil5 + $nil62); 					
					$angnilsilpa_1_01_01  = ($angnil4_1_01_01 + $angnil61_1_01_01)  -  ($angnil5_1_01_01 + $angnil62_1_01_01);
					$nilsilpa_1_01_01  = ($nil4_1_01_01 + $nil61_1_01_01)  -  ($nil5_1_01_01 + $nil62_1_01_01);
					$angnilsilpa_1_02_01  = ($angnil4_1_02_01 + $angnil61_1_02_01)  -  ($angnil5_1_02_01 + $angnil62_1_02_01);
					$nilsilpa_1_02_01  = ($nil4_1_02_01 + $nil61_1_02_01)  -  ($nil5_1_02_01 + $nil62_1_02_01);
					$angnilsilpa_1_03_01  = ($angnil4_1_03_01 + $angnil61_1_03_01)  -  ($angnil5_1_03_01 + $angnil62_1_03_01);
					$nilsilpa_1_03_01  = ($nil4_1_03_01 + $nil61_1_03_01)  -  ($nil5_1_03_01 + $nil62_1_03_01);
					$angnilsilpa_1_04_01  = ($angnil4_1_04_01 + $angnil61_1_04_01)  -  ($angnil5_1_04_01 + $angnil62_1_04_01);
					$nilsilpa_1_04_01  = ($nil4_1_04_01 + $nil61_1_04_01)  -  ($nil5_1_04_01 + $nil62_1_04_01);
					$angnilsilpa_1_05_01  = ($angnil4_1_05_01 + $angnil61_1_05_01)  -  ($angnil5_1_05_01 + $angnil62_1_05_01);
					$nilsilpa_1_05_01  = ($nil4_1_05_01 + $nil61_1_05_01)  -  ($nil5_1_05_01 + $nil62_1_05_01);
					$angnilsilpa_1_05_02  = ($angnil4_1_05_02 + $angnil61_1_05_02)  -  ($angnil5_1_05_02 + $angnil62_1_05_02);
					$nilsilpa_1_05_02  = ($nil4_1_05_02 + $nil61_1_05_02)  -  ($nil5_1_05_02 + $nil62_1_05_02);
					$angnilsilpa_1_05_03  = ($angnil4_1_05_03 + $angnil61_1_05_03)  -  ($angnil5_1_05_03 + $angnil62_1_05_03);
					$nilsilpa_1_05_03  = ($nil4_1_05_03 + $nil61_1_05_03)  -  ($nil5_1_05_03 + $nil62_1_05_03);
					$angnilsilpa_1_06_01  = ($angnil4_1_06_01 + $angnil61_1_06_01)  -  ($angnil5_1_06_01 + $angnil62_1_06_01);
					$nilsilpa_1_06_01  = ($nil4_1_06_01 + $nil61_1_06_01)  -  ($nil5_1_06_01 + $nil62_1_06_01);
					$angnilsilpa_2_02_01  = ($angnil4_2_02_01 + $angnil61_2_02_01)  -  ($angnil5_2_02_01 + $angnil62_2_02_01);
					$nilsilpa_2_02_01  = ($nil4_2_02_01 + $nil61_2_02_01)  -  ($nil5_2_02_01 + $nil62_2_02_01);
					$angnilsilpa_2_03_01  = ($angnil4_2_03_01 + $angnil61_2_03_01)  -  ($angnil5_2_03_01 + $angnil62_2_03_01);
					$nilsilpa_2_03_01  = ($nil4_2_03_01 + $nil61_2_03_01)  -  ($nil5_2_03_01 + $nil62_2_03_01);
					$angnilsilpa_2_05_01  = ($angnil4_2_05_01 + $angnil61_2_05_01)  -  ($angnil5_2_05_01 + $angnil62_2_05_01);
					$nilsilpa_2_05_01  = ($nil4_2_05_01 + $nil61_2_05_01)  -  ($nil5_2_05_01 + $nil62_2_05_01);
					$angnilsilpa_2_06_01  = ($angnil4_2_06_01 + $angnil61_2_06_01)  -  ($angnil5_2_06_01 + $angnil62_2_06_01);
					$nilsilpa_2_06_01  = ($nil4_2_06_01 + $nil61_2_06_01)  -  ($nil5_2_06_01 + $nil62_2_06_01);
					$angnilsilpa_2_09_01  = ($angnil4_2_09_01 + $angnil61_2_09_01)  -  ($angnil5_2_09_01 + $angnil62_2_09_01);
					$nilsilpa_2_09_01  = ($nil4_2_09_01 + $nil61_2_09_01)  -  ($nil5_2_09_01 + $nil62_2_09_01);
					$angnilsilpa_2_10_01  = ($angnil4_2_10_01 + $angnil61_2_10_01)  -  ($angnil5_2_10_01 + $angnil62_2_10_01);
					$nilsilpa_2_10_01  = ($nil4_2_10_01 + $nil61_2_10_01)  -  ($nil5_2_10_01 + $nil62_2_10_01);
					$angnilsilpa_2_11_01  = ($angnil4_2_11_01 + $angnil61_2_11_01)  -  ($angnil5_2_11_01 + $angnil62_2_11_01);
					$nilsilpa_2_11_01  = ($nil4_2_11_01 + $nil61_2_11_01)  -  ($nil5_2_11_01 + $nil62_2_11_01);
					$angnilsilpa_2_12_01  = ($angnil4_2_12_01 + $angnil61_2_12_01)  -  ($angnil5_2_12_01 + $angnil62_2_12_01);
					$nilsilpa_2_12_01  = ($nil4_2_12_01 + $nil61_2_12_01)  -  ($nil5_2_12_01 + $nil62_2_12_01);
					$angnilsilpa_2_13_01  = ($angnil4_2_13_01 + $angnil61_2_13_01)  -  ($angnil5_2_13_01 + $angnil62_2_13_01);
					$nilsilpa_2_13_01  = ($nil4_2_13_01 + $nil61_2_13_01)  -  ($nil5_2_13_01 + $nil62_2_13_01);
					$angnilsilpa_2_17_01  = ($angnil4_2_17_01 + $angnil61_2_17_01)  -  ($angnil5_2_17_01 + $angnil62_2_17_01);
					$nilsilpa_2_17_01  = ($nil4_2_17_01 + $nil61_2_17_01)  -  ($nil5_2_17_01 + $nil62_2_17_01);
					$angnilsilpa_4_01_01  = ($angnil4_4_01_01 + $angnil61_4_01_01)  -  ($angnil5_4_01_01 + $angnil62_4_01_01);
					$nilsilpa_4_01_01  = ($nil4_4_01_01 + $nil61_4_01_01)  -  ($nil5_4_01_01 + $nil62_4_01_01);
					$angnilsilpa_4_02_01  = ($angnil4_4_02_01 + $angnil61_4_02_01)  -  ($angnil5_4_02_01 + $angnil62_4_02_01);
					$nilsilpa_4_02_01  = ($nil4_4_02_01 + $nil61_4_02_01)  -  ($nil5_4_02_01 + $nil62_4_02_01);
					$angnilsilpa_4_02_02  = ($angnil4_4_02_02 + $angnil61_4_02_02)  -  ($angnil5_4_02_02 + $angnil62_4_02_02);
					$nilsilpa_4_02_02  = ($nil4_4_02_02 + $nil61_4_02_02)  -  ($nil5_4_02_02 + $nil62_4_02_02);
					$angnilsilpa_4_03_01  = ($angnil4_4_03_01 + $angnil61_4_03_01)  -  ($angnil5_4_03_01 + $angnil62_4_03_01);
					$nilsilpa_4_03_01  = ($nil4_4_03_01 + $nil61_4_03_01)  -  ($nil5_4_03_01 + $nil62_4_03_01);
					$angnilsilpa_4_05_01  = ($angnil4_4_05_01 + $angnil61_4_05_01)  -  ($angnil5_4_05_01 + $angnil62_4_05_01);
					$nilsilpa_4_05_01  = ($nil4_4_05_01 + $nil61_4_05_01)  -  ($nil5_4_05_01 + $nil62_4_05_01);
					$angnilsilpa_5_02_01  = ($angnil4_5_02_01 + $angnil61_5_02_01)  -  ($angnil5_5_02_01 + $angnil62_5_02_01);
					$nilsilpa_5_02_01  = ($nil4_5_02_01 + $nil61_5_02_01)  -  ($nil5_5_02_01 + $nil62_5_02_01);
					$angnilsilpa_5_01_01  = ($angnil4_5_01_01 + $angnil61_5_01_01)  -  ($angnil5_5_01_01 + $angnil62_5_01_01);
					$nilsilpa_5_01_01  = ($nil4_5_01_01 + $nil61_5_01_01)  -  ($nil5_5_01_01 + $nil62_5_01_01);
					$angnilsilpa_4_06_01  = ($angnil4_4_06_01 + $angnil61_4_06_01)  -  ($angnil5_4_06_01 + $angnil62_4_06_01);
					$nilsilpa_4_06_01  = ($nil4_4_06_01 + $nil61_4_06_01)  -  ($nil5_4_06_01 + $nil62_4_06_01);
					$angnilsilpa_4_08_01  = ($angnil4_4_08_01 + $angnil61_4_08_01)  -  ($angnil5_4_08_01 + $angnil62_4_08_01);
					$nilsilpa_4_08_01  = ($nil4_4_08_01 + $nil61_4_08_01)  -  ($nil5_4_08_01 + $nil62_4_08_01);
					$angnilsilpa_4_08_02  = ($angnil4_4_08_02 + $angnil61_4_08_02)  -  ($angnil5_4_08_02 + $angnil62_4_08_02);
					$nilsilpa_4_08_02  = ($nil4_4_08_02 + $nil61_4_08_02)  -  ($nil5_4_08_02 + $nil62_4_08_02);
					$angnilsilpa_4_08_03  = ($angnil4_4_08_03 + $angnil61_4_08_03)  -  ($angnil5_4_08_03 + $angnil62_4_08_03);
					$nilsilpa_4_08_03  = ($nil4_4_08_03 + $nil61_4_08_03)  -  ($nil5_4_08_03 + $nil62_4_08_03);
					$angnilsilpa_4_08_04  = ($angnil4_4_08_04 + $angnil61_4_08_04)  -  ($angnil5_4_08_04 + $angnil62_4_08_04);
					$nilsilpa_4_08_04  = ($nil4_4_08_04 + $nil61_4_08_04)  -  ($nil5_4_08_04 + $nil62_4_08_04);
					$angnilsilpa_4_08_05  = ($angnil4_4_08_05 + $angnil61_4_08_05)  -  ($angnil5_4_08_05 + $angnil62_4_08_05);
					$nilsilpa_4_08_05  = ($nil4_4_08_05 + $nil61_4_08_05)  -  ($nil5_4_08_05 + $nil62_4_08_05);
					$angnilsilpa_4_08_06  = ($angnil4_4_08_06 + $angnil61_4_08_06)  -  ($angnil5_4_08_06 + $angnil62_4_08_06);
					$nilsilpa_4_08_06  = ($nil4_4_08_06 + $nil61_4_08_06)  -  ($nil5_4_08_06 + $nil62_4_08_06);

					if ($angnilsilpa < 0){
                    	$ax1="("; $angnilsilpa=$angnilsilpa*-1; $ax2=")";}
                    else {
                    	$ax1=""; $ax2="";}

                    if ($nilsilpa < 0){
                    	$bx1="("; $nilsilpa=$nilsilpa*-1; $bx2=")";}
                    else {
                    	$bx1=""; $bx2="";}
						
					if($nilsilpa_1_01_01<0){
					  $az1="("; $nilsilpa_1_01_01=$nilsilpa_1_01_01*-1; $az2=")";}  
					  else{ 
					  $az1=""; $az2="";}
					  
					if($angnilsilpa_1_01_01<0){
					  $bz1="("; $angnilsilpa_1_01_01=$angnilsilpa_1_01_01*-1; $bz2=")";}  
					  else {
					  $bz1=""; $bz2="";}
					  
					if($nilsilpa_1_02_01< 0){
					  $ac1="("; $nilsilpa_1_02_01 = $nilsilpa_1_02_01*-1; $ac2=")";}  
					  else {
					  $ac1=""; $ac2="";}
					  
					if($angnilsilpa_1_02_01< 0){
					  $bc1="("; $angnilsilpa_1_02_01 = $angnilsilpa_1_02_01*-1; $bc2=")";}
					  else { 
					  $bc1=""; $bc2="";}
					  
					if($nilsilpa_1_03_01< 0){
					  $av1="("; $nilsilpa_1_03_01 = $nilsilpa_1_03_01*-1; $av2=")";}  
					  else {
					  $av1=""; $av2="";}
					  
					if($angnilsilpa_1_03_01< 0){
					  $bv1="("; $angnilsilpa_1_03_01 = $angnilsilpa_1_03_01*-1; $bv2=")";}  
					  else {
					  $bv1=""; $bv2="";}
					  
					if($nilsilpa_1_04_01< 0){
					  $ab1="("; $nilsilpa_1_04_01 = $nilsilpa_1_04_01*-1; $ab2=")";}  
					  else { 
					  $ab1=""; $ab2="";}
					  
					if($angnilsilpa_1_04_01< 0){
					  $bb1="("; $angnilsilpa_1_04_01 = $angnilsilpa_1_04_01*-1; $bb2=")";}
					  else { 
					  $bb1=""; $bb2="";}
					  
					if($nilsilpa_1_05_01< 0){ 
					 $an1="("; $nilsilpa_1_05_01 = $nilsilpa_1_05_01*-1; $an2=")";} 
					 else { 
					 $an1=""; $an2="";}
					 
					if($angnilsilpa_1_05_01< 0){ 
					 $bn1="("; $angnilsilpa_1_05_01 = $angnilsilpa_1_05_01*-1; $bn2=")";}  
					 else {
					 $bn1=""; $bn2="";}
					 
					if($nilsilpa_1_05_02< 0){
					  $am1="("; $nilsilpa_1_05_02 = $nilsilpa_1_05_02*-1; $am2=")";}  
					  else { 
					  $am1=""; $am2="";}
					  
					if($angnilsilpa_1_05_02< 0){
					  $bm1="("; $angnilsilpa_1_05_02 = $angnilsilpa_1_05_02*-1; $bm2=")";}  
					  else {
					  $bm1=""; $bm2="";}
					  
					if($nilsilpa_1_05_03< 0){ 
					 $aa1="("; $nilsilpa_1_05_03 = $nilsilpa_1_05_03*-1; $aa2=")";}  
					 else {
					 $aa1=""; $aa2="";}
					 
					if($angnilsilpa_1_05_03< 0){ 
					 $ba1="("; $angnilsilpa_1_05_03 = $angnilsilpa_1_05_03*-1; $ba2=")";}  
					 else {
					 $ba1=""; $ba2="";}
					 
					if($nilsilpa_1_06_01< 0){
					  $as1="("; $nilsilpa_1_06_01 = $nilsilpa_1_06_01*-1; $as2=")";}  
					  else {
					  $as1=""; $as2="";}
					  
					if($angnilsilpa_1_06_01< 0){
					  $bs1="("; $angnilsilpa_1_06_01 = $angnilsilpa_1_06_01*-1; $bs2=")";}
					  else {
					  $bs1=""; $bs2="";}
					  
					if($nilsilpa_2_02_01< 0){
					  $ad1="("; $nilsilpa_2_02_01 = $nilsilpa_2_02_01*-1; $ad2=")";}  
					  else { 
					  $ad1=""; $ad2="";}
					  
					if($angnilsilpa_2_02_01< 0){
					  $bd1="("; $angnilsilpa_2_02_01 = $angnilsilpa_2_02_01*-1; $bd2=")";}
					  else {
					  $bd1=""; $bd2="";}
					  
					if($nilsilpa_2_03_01< 0){
					  $af1="("; $nilsilpa_2_03_01 = $nilsilpa_2_03_01*-1; $af2=")";}
					  else {
					  $af1=""; $af2="";}
					  
					if($angnilsilpa_2_03_01< 0){
					  $bf1="("; $angnilsilpa_2_03_01 = $angnilsilpa_2_03_01*-1; $bf2=")";}  
					  else { 
					  $bf1=""; $bf2="";}
					  
					if($nilsilpa_2_05_01< 0){
					  $ag1="("; $nilsilpa_2_05_01 = $nilsilpa_2_05_01*-1; $ag2=")";}
					  else {
					  $ag1=""; $ag2="";}
					  
					if($angnilsilpa_2_05_01< 0){
					  $bg1="("; $angnilsilpa_2_05_01 = $angnilsilpa_2_05_01*-1; $bg2=")";}  
					  else {
					  $bg1=""; $bg2="";}
					  
					if($nilsilpa_2_06_01< 0){
					  $ah1="("; $nilsilpa_2_06_01 = $nilsilpa_2_06_01*-1; $ah2=")";}
					  else { 
					  $ah1=""; $ah2="";}
					  
					if($angnilsilpa_2_06_01< 0){
					  $bh1="("; $angnilsilpa_2_06_01 = $angnilsilpa_2_06_01*-1; $bh2=")";}  
					  else {
					  $bh1=""; $bh2="";}
					  
					if($nilsilpa_2_09_01< 0){ 
					$aj1="("; $nilsilpa_2_09_01 = $nilsilpa_2_09_01*-1; $aj2=")";} 
					 else { 
					 $aj1=""; $aj2="";}
					 
					if($angnilsilpa_2_09_01< 0){
					  $bj1="("; $angnilsilpa_2_09_01 = $angnilsilpa_2_09_01*-1; $bj2=")";}  
					  else {
					  $bj1=""; $bj2="";}
					  
					if($nilsilpa_2_10_01< 0){
					  $ak1="("; $nilsilpa_2_10_01 = $nilsilpa_2_10_01*-1; $ak2=")";}  
					  else { 
					  $ak1=""; $ak2="";}
					  
					if($angnilsilpa_2_10_01< 0){
					  $bk1="("; $angnilsilpa_2_10_01 = $angnilsilpa_2_10_01*-1; $bk2=")";}  
					  else {
					  $bk1=""; $bk2="";}
					  
					if($nilsilpa_2_11_01< 0){
					  $al1="("; $nilsilpa_2_11_01 = $nilsilpa_2_11_01*-1; $al2=")";} 
					  else {
					  $al1=""; $al2="";}
					  
					if($angnilsilpa_2_11_01< 0){ 
					 $bl1="("; $angnilsilpa_2_11_01 = $angnilsilpa_2_11_01*-1; $bl2=")";} 
					 else {
					 $bl1=""; $bl2="";}
					 
					if($nilsilpa_2_12_01< 0){ 
					 $aq1="("; $nilsilpa_2_12_01 = $nilsilpa_2_12_01*-1; $aq2=")";}  
					 else { 
					 $aq1=""; $aq2="";}
					 
					if($angnilsilpa_2_12_01< 0){ 
					 $bq1="("; $angnilsilpa_2_12_01 = $angnilsilpa_2_12_01*-1; $bq2=")";} 
					 else {
					 $bq1=""; $bq2="";}
					 
					if($nilsilpa_2_13_01< 0){
					  $aw1="("; $nilsilpa_2_13_01 = $nilsilpa_2_13_01*-1; $aw2=")";}
					  else {
					  $aw1=""; $aw2="";}
					  
					if($angnilsilpa_2_13_01< 0){
					  $bw1="("; $angnilsilpa_2_13_01 = $angnilsilpa_2_13_01*-1; $bw2=")";}
					  else {
					  $bw1=""; $bw2="";}
					  
					if($nilsilpa_2_17_01< 0){
					  $ae1="("; $nilsilpa_2_17_01 = $nilsilpa_2_17_01*-1; $ae2=")";}  
					  else { 
					  $ae1=""; $ae2="";}
					  
					if($angnilsilpa_2_17_01< 0){
					  $be1="("; $angnilsilpa_2_17_01 = $angnilsilpa_2_17_01*-1; $be2=")";}
					  else {
					  $be1=""; $be2="";}
					  
					if($nilsilpa_4_01_01< 0){
					  $ar1="("; $nilsilpa_4_01_01 = $nilsilpa_4_01_01*-1; $ar2=")";}
					  else {
					  $ar1=""; $ar2="";}
					  
					if($angnilsilpa_4_01_01< 0){
					  $br1="("; $angnilsilpa_4_01_01 = $angnilsilpa_4_01_01*-1; $br2=")";}
					  else {
					  $br1=""; $br2="";}
					  
					if($nilsilpa_4_02_01< 0){
					  $at1="("; $nilsilpa_4_02_01 = $nilsilpa_4_02_01*-1; $at2=")";}
					  else {
					  $at1=""; $at2="";}
					  
					if($angnilsilpa_4_02_01< 0){ 
					 $bt1="("; $angnilsilpa_4_02_01 = $angnilsilpa_4_02_01*-1; $bt2=")";} 
					 else {
					 $bt1=""; $bt2="";}
					 
					if($nilsilpa_4_02_02< 0){
					  $ay1="("; $nilsilpa_4_02_02 = $nilsilpa_4_02_02*-1; $ay2=")";} 
					  else { 
					  $ay1=""; $ay2="";}
					  
					if($angnilsilpa_4_02_02< 0){ 
					 $by1="("; $angnilsilpa_4_02_02 = $angnilsilpa_4_02_02*-1; $by2=")";} 
					 else { 
					 $by1=""; $by2="";}
					 
					if($nilsilpa_4_03_01< 0){ 
					 $au1="("; $nilsilpa_4_03_01 = $nilsilpa_4_03_01*-1; $au2=")";}
					 else {  
					 $au1=""; $au2="";}
					 
					if($angnilsilpa_4_03_01< 0){ 
					 $bu1="("; $angnilsilpa_4_03_01 = $angnilsilpa_4_03_01*-1; $bu2=")";}
					 else { 
					 $bu1=""; $bu2="";}
					 
					if($nilsilpa_4_05_01< 0){ 
					 $ai1="("; $nilsilpa_4_05_01 = $nilsilpa_4_05_01*-1; $ai2=")";} 
					 else {
					 $ai1=""; $ai2="";}
					 
					if($angnilsilpa_4_05_01< 0){ 
					 $bi1="("; $angnilsilpa_4_05_01 = $angnilsilpa_4_05_01*-1; $bi2=")";}
					 else { 
					 $bi1=""; $bi2="";}
					 
					if($nilsilpa_5_02_01< 0){ 
					 $ao1="("; $nilsilpa_5_02_01 = $nilsilpa_5_02_01*-1; $ao2=")";}
					 else {
					 $ao1=""; $ao2="";}
					 
					if($angnilsilpa_5_02_01< 0){
					  $bo1="("; $angnilsilpa_5_02_01 = $angnilsilpa_5_02_01*-1; $bo2=")";} 
					  else {  
					  $bo1=""; $bo2="";}
					  
					if($nilsilpa_5_01_01< 0){
					  $za1="("; $nilsilpa_5_01_01 = $nilsilpa_5_01_01*-1; $za2=")";}
					  else {
					  $za1=""; $za2="";}
					  
					if($angnilsilpa_5_01_01< 0){
					  $zb1="("; $angnilsilpa_5_01_01 = $angnilsilpa_5_01_01*-1; $zb2=")";}
					  else { 
					  $zb1=""; $zb2="";}
					  
					if($nilsilpa_4_06_01< 0){
					  $xa1="("; $nilsilpa_4_06_01 = $nilsilpa_4_06_01*-1; $xa2=")";}
					  else { 
					  $xa1=""; $xa2="";}
					  
					if($angnilsilpa_4_06_01< 0){
					  $xb1="("; $angnilsilpa_4_06_01 = $angnilsilpa_4_06_01*-1; $xb2=")";} 
					  else { 
					  $xb1=""; $xb2="";}
					  
					if($nilsilpa_4_08_01< 0){
					  $ca1="("; $nilsilpa_4_08_01 = $nilsilpa_4_08_01*-1; $ca2=")";} 
					  else { 
					  $ca1=""; $ca2="";}
					  
					if($angnilsilpa_4_08_01< 0){
					  $cb1="("; $angnilsilpa_4_08_01 = $angnilsilpa_4_08_01*-1; $cb2=")";} 
					  else {
					  $cb1=""; $cb2="";}
					  
					if($nilsilpa_4_08_02< 0){
					  $va1="("; $nilsilpa_4_08_02 = $nilsilpa_4_08_02*-1; $va2=")";}
					  else {
					  $va1=""; $va2="";}
					  
					if($angnilsilpa_4_08_02< 0){
					  $vb1="("; $angnilsilpa_4_08_02 = $angnilsilpa_4_08_02*-1; $vb2=")";}
					  else { 
					  $vb1=""; $vb2="";}
					  
					if($nilsilpa_4_08_03< 0){ 
					 $na1="("; $nilsilpa_4_08_03 = $nilsilpa_4_08_03*-1; $na2=")";}
					 else { 
					 $na1=""; $na2="";}
					 
					if($angnilsilpa_4_08_03< 0){
					  $nb1="("; $angnilsilpa_4_08_03 = $angnilsilpa_4_08_03*-1; $nb2=")";}
					  else {  
					  $nb1=""; $nb2="";}
					  
					if($nilsilpa_4_08_04< 0){
					  $ma1="("; $nilsilpa_4_08_04 = $nilsilpa_4_08_04*-1; $ma2=")";}
					  else {
					  $ma1=""; $ma2="";}
					  
					if($angnilsilpa_4_08_04< 0){ 
					 $mb1="("; $angnilsilpa_4_08_04 = $angnilsilpa_4_08_04*-1; $mb2=")";}
					 else {
					 $mb1=""; $mb2="";}
					 
					if($nilsilpa_4_08_05< 0){ 
					 $sa1="("; $nilsilpa_4_08_05 = $nilsilpa_4_08_05*-1; $sa2=")";} 
					 else { 
					 $sa1=""; $sa2="";}
					 
					if($angnilsilpa_4_08_05< 0){ 
					 $sb1="("; $angnilsilpa_4_08_05 = $angnilsilpa_4_08_05*-1; $sb2=")";} 
					 else { 
					 $sb1=""; $sb2="";}
					 
					if($nilsilpa_4_08_06< 0){ 
					 $da1="("; $nilsilpa_4_08_06 = $nilsilpa_4_08_06*-1; $da2=")";}
					 else {
					 $da1=""; $da2="";}
					 
					if($angnilsilpa_4_08_06< 0){ 
					 $db1="("; $angnilsilpa_4_08_06 = $angnilsilpa_4_08_06*-1; $db2=")";}
					 else { 
					 $db1=""; $db2="";}


                    $nilaisilpa    = number_format($nilsilpa,"2",".",",");
                    $angnilaisilpa = number_format($angnilsilpa,"2",".",",");
					$angnilaisilpa_1_01_01	= number_format($angnilsilpa_1_01_01,"2",".",",");
					$nilaisilpa_1_01_01	= number_format($nilsilpa_1_01_01,"2",".",",");
					$angnilaisilpa_1_02_01     =    number_format($angnilsilpa_1_02_01,"2",".",",");
					$nilaisilpa_1_02_01     =    number_format($nilsilpa_1_02_01,"2",".",",");
					$angnilaisilpa_1_03_01     =    number_format($angnilsilpa_1_03_01,"2",".",",");
					$nilaisilpa_1_03_01     =    number_format($nilsilpa_1_03_01,"2",".",",");
					$angnilaisilpa_1_04_01     =    number_format($angnilsilpa_1_04_01,"2",".",",");
					$nilaisilpa_1_04_01     =    number_format($nilsilpa_1_04_01,"2",".",",");
					$angnilaisilpa_1_05_01     =    number_format($angnilsilpa_1_05_01,"2",".",",");
					$nilaisilpa_1_05_01     =    number_format($nilsilpa_1_05_01,"2",".",",");
					$angnilaisilpa_1_05_02     =    number_format($angnilsilpa_1_05_02,"2",".",",");
					$nilaisilpa_1_05_02     =    number_format($nilsilpa_1_05_02,"2",".",",");
					$angnilaisilpa_1_05_03     =    number_format($angnilsilpa_1_05_03,"2",".",",");
					$nilaisilpa_1_05_03     =    number_format($nilsilpa_1_05_03,"2",".",",");
					$angnilaisilpa_1_06_01     =    number_format($angnilsilpa_1_06_01,"2",".",",");
					$nilaisilpa_1_06_01     =    number_format($nilsilpa_1_06_01,"2",".",",");
					$angnilaisilpa_2_02_01     =    number_format($angnilsilpa_2_02_01,"2",".",",");
					$nilaisilpa_2_02_01     =    number_format($nilsilpa_2_02_01,"2",".",",");
					$angnilaisilpa_2_03_01     =    number_format($angnilsilpa_2_03_01,"2",".",",");
					$nilaisilpa_2_03_01     =    number_format($nilsilpa_2_03_01,"2",".",",");
					$angnilaisilpa_2_05_01     =    number_format($angnilsilpa_2_05_01,"2",".",",");
					$nilaisilpa_2_05_01     =    number_format($nilsilpa_2_05_01,"2",".",",");
					$angnilaisilpa_2_06_01     =    number_format($angnilsilpa_2_06_01,"2",".",",");
					$nilaisilpa_2_06_01     =    number_format($nilsilpa_2_06_01,"2",".",",");
					$angnilaisilpa_2_09_01     =    number_format($angnilsilpa_2_09_01,"2",".",",");
					$nilaisilpa_2_09_01     =    number_format($nilsilpa_2_09_01,"2",".",",");
					$angnilaisilpa_2_10_01     =    number_format($angnilsilpa_2_10_01,"2",".",",");
					$nilaisilpa_2_10_01     =    number_format($nilsilpa_2_10_01,"2",".",",");
					$angnilaisilpa_2_11_01     =    number_format($angnilsilpa_2_11_01,"2",".",",");
					$nilaisilpa_2_11_01     =    number_format($nilsilpa_2_11_01,"2",".",",");
					$angnilaisilpa_2_12_01     =    number_format($angnilsilpa_2_12_01,"2",".",",");
					$nilaisilpa_2_12_01     =    number_format($nilsilpa_2_12_01,"2",".",",");
					$angnilaisilpa_2_13_01     =    number_format($angnilsilpa_2_13_01,"2",".",",");
					$nilaisilpa_2_13_01     =    number_format($nilsilpa_2_13_01,"2",".",",");
					$angnilaisilpa_2_17_01     =    number_format($angnilsilpa_2_17_01,"2",".",",");
					$nilaisilpa_2_17_01     =    number_format($nilsilpa_2_17_01,"2",".",",");
					$angnilaisilpa_4_01_01     =    number_format($angnilsilpa_4_01_01,"2",".",",");
					$nilaisilpa_4_01_01     =    number_format($nilsilpa_4_01_01,"2",".",",");
					$angnilaisilpa_4_02_01     =    number_format($angnilsilpa_4_02_01,"2",".",",");
					$nilaisilpa_4_02_01     =    number_format($nilsilpa_4_02_01,"2",".",",");
					$angnilaisilpa_4_02_02     =    number_format($angnilsilpa_4_02_02,"2",".",",");
					$nilaisilpa_4_02_02     =    number_format($nilsilpa_4_02_02,"2",".",",");
					$angnilaisilpa_4_03_01     =    number_format($angnilsilpa_4_03_01,"2",".",",");
					$nilaisilpa_4_03_01     =    number_format($nilsilpa_4_03_01,"2",".",",");
					$angnilaisilpa_4_05_01     =    number_format($angnilsilpa_4_05_01,"2",".",",");
					$nilaisilpa_4_05_01     =    number_format($nilsilpa_4_05_01,"2",".",",");
					$angnilaisilpa_5_02_01     =    number_format($angnilsilpa_5_02_01,"2",".",",");
					$nilaisilpa_5_02_01     =    number_format($nilsilpa_5_02_01,"2",".",",");
					$angnilaisilpa_5_01_01     =    number_format($angnilsilpa_5_01_01,"2",".",",");
					$nilaisilpa_5_01_01     =    number_format($nilsilpa_5_01_01,"2",".",",");
					$angnilaisilpa_4_06_01     =    number_format($angnilsilpa_4_06_01,"2",".",",");
					$nilaisilpa_4_06_01     =    number_format($nilsilpa_4_06_01,"2",".",",");
					$angnilaisilpa_4_08_01     =    number_format($angnilsilpa_4_08_01,"2",".",",");
					$nilaisilpa_4_08_01     =    number_format($nilsilpa_4_08_01,"2",".",",");
					$angnilaisilpa_4_08_02     =    number_format($angnilsilpa_4_08_02,"2",".",",");
					$nilaisilpa_4_08_02     =    number_format($nilsilpa_4_08_02,"2",".",",");
					$angnilaisilpa_4_08_03     =    number_format($angnilsilpa_4_08_03,"2",".",",");
					$nilaisilpa_4_08_03     =    number_format($nilsilpa_4_08_03,"2",".",",");
					$angnilaisilpa_4_08_04     =    number_format($angnilsilpa_4_08_04,"2",".",",");
					$nilaisilpa_4_08_04     =    number_format($nilsilpa_4_08_04,"2",".",",");
					$angnilaisilpa_4_08_05     =    number_format($angnilsilpa_4_08_05,"2",".",",");
					$nilaisilpa_4_08_05     =    number_format($nilsilpa_4_08_05,"2",".",",");
					$angnilaisilpa_4_08_06     =    number_format($angnilsilpa_4_08_06,"2",".",",");
					$nilaisilpa_4_08_06     =    number_format($nilsilpa_4_08_06,"2",".",",");
                   
                   $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$ax1$angnilaisilpa$ax2</b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$bx1$nilaisilpa$bx2</b></td>
									 <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$bz1$angnilaisilpa_1_01_01$bz2</b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$az1$nilaisilpa_1_01_01$az2</b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$bc1$angnilaisilpa_1_02_01$bc2</b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$ac1$nilaisilpa_1_02_01$ac2</b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$bv1$angnilaisilpa_1_03_01$bv2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$av1$nilaisilpa_1_03_01$av2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$bb1$angnilaisilpa_1_04_01$bb2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$ab1$nilaisilpa_1_04_01$ab2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$bn1$angnilaisilpa_1_05_01$bn2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$an1$nilaisilpa_1_05_01$an2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$bm1$angnilaisilpa_1_05_02$bm2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$am1$nilaisilpa_1_05_02$am2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$ba1$angnilaisilpa_1_05_03$ba2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$aa1$nilaisilpa_1_05_03$aa2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$bs1$angnilaisilpa_1_06_01$bs2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$as1$nilaisilpa_1_06_01$as2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$bd1$angnilaisilpa_2_02_01$bd2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$ad1$nilaisilpa_2_02_01$ad2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$bf1$angnilaisilpa_2_03_01$bf2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$af1$nilaisilpa_2_03_01$af2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$bg1$angnilaisilpa_2_05_01$bg2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$ag1$nilaisilpa_2_05_01$ag2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$bh1$angnilaisilpa_2_06_01$bh2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$ah1$nilaisilpa_2_06_01$ah2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$bj1$angnilaisilpa_2_09_01$bj2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$aj1$nilaisilpa_2_09_01$aj2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$bk1$angnilaisilpa_2_10_01$bk2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$ak1$nilaisilpa_2_10_01$ak2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$bl1$angnilaisilpa_2_11_01$bl2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$al1$nilaisilpa_2_11_01$al2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$bq1$angnilaisilpa_2_12_01$bq2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$aq1$nilaisilpa_2_12_01$aq2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$bw1$angnilaisilpa_2_13_01$bw2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$aw1$nilaisilpa_2_13_01$aw2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$be1$angnilaisilpa_2_17_01$be2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$ae1$nilaisilpa_2_17_01$ae2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$br1$angnilaisilpa_4_01_01$br2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$ar1$nilaisilpa_4_01_01$ar2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$bt1$angnilaisilpa_4_02_01$bt2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$at1$nilaisilpa_4_02_01$at2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$by1$angnilaisilpa_4_02_02$by2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$ay1$nilaisilpa_4_02_02$ay2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$bu1$angnilaisilpa_4_03_01$bu2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$au1$nilaisilpa_4_03_01$au2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$bi1$angnilaisilpa_4_05_01$bi2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$ai1$nilaisilpa_4_05_01$ai2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$bo1$angnilaisilpa_5_02_01$bo2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$ao1$nilaisilpa_5_02_01$ao2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$zb1$angnilaisilpa_5_01_01$zb2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$za1$nilaisilpa_5_01_01$za2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$xb1$angnilaisilpa_4_06_01$xb2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$xa1$nilaisilpa_4_06_01$xa2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$cb1$angnilaisilpa_4_08_01$cb2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$ca1$nilaisilpa_4_08_01$ca2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$vb1$angnilaisilpa_4_08_02$vb2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$va1$nilaisilpa_4_08_02$va2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nb1$angnilaisilpa_4_08_03$nb2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$na1$nilaisilpa_4_08_03$na2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$mb1$angnilaisilpa_4_08_04$mb2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$ma1$nilaisilpa_4_08_04$ma2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$sb1$angnilaisilpa_4_08_05$sb2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$sa1$nilaisilpa_4_08_05$sa2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$db1$angnilaisilpa_4_08_06$db2<b></td>
									<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$da1$nilaisilpa_4_08_06$da2<b></td>
                                 </tr>";        								 
 
             
			  
        $cRet .=       " </table>";
        $data['prev']= $cRet;
		 $cRet         .= "</table>";
		 
             if($ttd=="1"){
                
                $sqlsc="SELECT tgl_rka,provinsi,kab_kota,daerah,thn_ang FROM sclient where kd_skpd='4.02.01.00'";
                 $sqlsclient=$this->db->query($sqlsc);
                 foreach ($sqlsclient->result() as $rowsc)
                {
                    $kab     = $rowsc->kab_kota;
                    $daerah  = $rowsc->daerah;
                   
                }		 
	       }
		   
		 if($ttd=="1"){                                
                
                $sqlttd1="SELECT nama as nm,nip as nip, jabatan as jab,pangkat FROM ms_ttd where nip='$ttd1' and (kode ='agr' or kode='wk')";
                
                 $sqlttd=$this->db->query($sqlttd1);
                 foreach ($sqlttd->result() as $rowttd)
                {
                    $nip=$rowttd->nip;                    
                    $nama= $rowttd->nm;
                    $jabatan  = $rowttd->jab;
                    $pangkat  = $rowttd->pangkat;
                }                                
              }
              
                  if($ttd1!='1'){
                    $xx="<u>";
                    $xy="</u>";
                    $nipxx=$nip;
				    $nipx="NIP. ";
                }else{
                    $xx="";
                    $xy="";
                    $nipxx="";
				    $nipx="";
                } 	

 $cRet .='<TABLE style="border-collapse:collapse; font-size:13px; font-family: Bookman Old Style;"  width="500%" border="0" cellspacing="0" cellpadding="0" align=center>
					<TR>
						<TD width="400%" align="center" ><b>&nbsp;</TD>
					</TR>
					<TR>
						<TD width="400%" align="center" ><b>&nbsp;</TD>
					</TR>
                    <TR>
						<TD width="400%" align="center" >'.$daerah.', '.$this->tanggal_format_indonesia($tanggal_ttd).'</TD>
					</TR>
					
                    <TR>
						<TD width="400%" align="center" ><b>'.$jabatan.'</b></TD>
					</TR>
                    <TR>
						<TD width="400%" align="center" ><b>&nbsp;</TD>
					</TR>
					<TR>
						<TD width="400%" align="center" ><b>&nbsp;</TD>
					</TR>
					<TR>
						<TD width="400%" align="center" ><b>&nbsp;</TD>
					</TR>
                    <TR>
						<TD width="400%" align="center" ><b>&nbsp;</TD>
					</TR>                    
                    <TR>
						<TD width="400%" align="center" >'.$xx.'<b>'.$nama.'</b>'.$xy.'</TD>
					</TR>
                    <TR>
						<TD width="400%" align="center" >'.$nipx.''.$nipxx.'</TD>
					</TR>
					</TABLE><br/>';

            
			$data['prev']= $cRet;    
            $judul='LRA_PERMEN 64';
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
	

	
	

}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */