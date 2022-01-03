<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class spd extends CI_Controller {

public $ppkd = "4.02.01";
public $ppkd1 = "4.02.01.00";

    function __contruct()
    {   
        parent::__construct();
    }
    
    function rp_minus($nilai){
        if($nilai<0){
            $nilai = $nilai * (-1);
            $nilai = '('.number_format($nilai,"2",",",".").')';    
        }else{
            $nilai = number_format($nilai,"2",",","."); 
        }
        
        return $nilai;
    }   

    function nvl($val, $replace){
        if( is_null($val) || $val === '' )  
            return $replace;
        else                                
            return $val;
    }   
 
    function persen($nilai,$nilai2){
            if($nilai != 0){
                $persen = $this->rp_minus((($nilai2 - $nilai)/$nilai)*100);
            }else{
                if($nilai2 == 0){
                    $persen = $this->rp_minus(0);
                }else{
                    $persen = $this->rp_minus(100);
                }
            } 
          return $persen;  
     }
 
    function get_status($tgl,$skpd){
        $n_status = '';
        $tanggal = $tgl;
        $sql = "select case when '$tanggal'>=tgl_dpa_ubah then 'nilai_ubah' 
                    when '$tanggal'>=tgl_dpa_sempurna then 'nilai_sempurna' 
                    when '$tanggal'<=tgl_dpa 
                    then 'nilai' else 'nilai' end as anggaran from trhrka where kd_skpd ='$skpd' ";
                    
       
        
        $q_trhrka = $this->db->query($sql);
        $num_rows = $q_trhrka->num_rows();
        
        foreach ($q_trhrka->result() as $r_trhrka){
             $n_status = $r_trhrka->anggaran;                   
        }    
        return $n_status;                         
    }
    
    function get_status2($skpd){
        $n_status = '';
        
        $sql = "select case when status_ubah='1' then 'nilai_ubah' 
                    when status_sempurna='1' then 'nilai_sempurna' 
                    when statu='1' 
                    then 'nilai' else 'nilai' end as anggaran from trhrka where kd_skpd ='$skpd'";
        
        $q_trhrka = $this->db->query($sql);
        $num_rows = $q_trhrka->num_rows();
        
        foreach ($q_trhrka->result() as $r_trhrka){
             $n_status = $r_trhrka->anggaran;                   
        }    
        return $n_status;                         
    }    

   function  tanggal_format_indonesia2($tgl){
        $tanggal  =  substr($tgl,7,2);
        $bulan  = $this-> getBulan(substr($tgl,5,2));
        $tahun  =  substr($tgl,0,4);
        return  $tanggal.' '.$bulan.' '.$tahun;

    }  
    

    function  tanggal_format_indonesia($tgl){
        $tanggal  =  substr($tgl,8,2);
        $bulan  = $this-> getBulan(substr($tgl,5,2));
        $tahun  =  substr($tgl,0,4);
        return  $tanggal.' '.$bulan.' '.$tahun;

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

    function  dotrek($rek){
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
                 case 4:
                    $rek = $this->left($rek,1).'.'.substr($rek,1,1).'.'.substr($rek,2,1).'.'.substr($rek,3,2);                               
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
	
	function skpduser_bp() {
        $lccr = $this->input->post('q');
        $id  = $this->session->userdata('pcUser');
        $sql = "SELECT kd_skpd,nm_skpd FROM ms_skpd where (upper(kd_skpd) like upper('%$lccr%') or upper(nm_skpd) like upper('%$lccr%')) and 
                kd_skpd IN (SELECT kd_skpd FROM user_bud WHERE user_id='$id' and right(kd_skpd,2)='00') order by kd_skpd ";
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
	
	//cetakan register spd//
	
	function cek_regis_spd_bud()
    {
        $data['page_title']= 'REGISTER SPD';
        $this->template->set('title', 'REGISTER SPD');   
        $this->template->load('template','anggaran/rka/cek_regis_spd_bud',$data) ; 
    }

    function cetak_spd_cover(){
        $print = $this->uri->segment(3);
        $tnp_no = $this->uri->segment(4);
        $jn_keg = $this->uri->segment(7);
        $tambah = $this->uri->segment(5) == '0' ? '' : $this->uri->segment(5);
        $lcnospd = $this->input->post('nomor1');                
        $nip_ppkd = $this->input->post('nip_ppkd');  
        $nama_ppkd = $this->input->post('nama_ppkd');       
        $jabatan_ppkd = $this->input->post('jabatan_ppkd'); 
        $pangkat_ppkd = $this->input->post('pangkat_ppkd');
        $client = $this->ClientModel->clientData();
        $kab = $client->kab_kota;
        $daerah = $client->daerah;
        $thn_ang = $this->session->userdata('pcThang');
        $kd_skpd =  $this->tukd_model->get_nama($lcnospd,'kd_skpd','trhspd','no_spd');
        $tgl_spd =  $this->tukd_model->get_nama($lcnospd,'tgl_spd','trhspd','no_spd');
        $nm_skpd =  $this->tukd_model->get_nama($kd_skpd,'nm_skpd','ms_skpd','kd_skpd');
        $no_dpa =  $this->tukd_model->get_nama($kd_skpd,'no_dpa','trhrka','kd_skpd');
        $nm_pa =  '..........';
        $nm_pa =  $this->tukd_model->get_nama($kd_skpd,'nama_pa','ms_skpd','kd_skpd');
        $bulan_awal =  1;
        $bulan_akhir =  $this->tukd_model->get_nama($lcnospd,'bulan_akhir','trhspd','no_spd');
        $nilai_spd =  $this->tukd_model->get_nama($lcnospd,'total','trhspd','no_spd');
        $n_status = $this->rka_model->status_anggaran($kd_skpd);
        $sql = "SELECT SUM($n_status) as nilai FROM trdrka WHERE kd_skpd = '$kd_skpd' AND left(kd_rek6,1) = '5' GROUP BY kd_skpd";
        $row = $this->db->query($sql)->row();
        $nilai_ang = $row->nilai;

        $sql2 = "SELECT SUM(total) as nilai FROM trhspd WHERE kd_skpd = '$kd_skpd' 
                AND tgl_spd < '$tgl_spd' AND YEAR(tgl_spd) = '$thn_ang' AND status = '1' 
                AND no_spd NOT IN ('$lcnospd')";
        $row2 = $this->db->query($sql2)->row();
        $spd_sebelum = $row2->nilai;

        $total_spd = $nilai_spd + $spd_sebelum;
        $belum_spd = $nilai_ang - $total_spd;

        switch ($bulan_akhir) {
            case '3':
                $tw = 'triwulan I ';
                break;
            case '6':
                $tw = 'triwulan II ';
                break;
            case '9':
                $tw = 'triwulan III ';
                break;
            case '12':
                $tw = 'triwulan IV ';
                break; 
            default:
                $tw = '-';
                break;
        }



        $cRet = '';

        $cRet .="    
        <table style=\"border-collapse:collapse;font-family: Arial; font-size:12px\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\">
            <tr>
                <td style = \"font-weight: none;text-align:center;padding-bottom:20px;\">
                    PEMERINTAH $kab <br>
                    PEJABAT PENGELOLA KEUANGAN DAERAH SELAKU BENDAHARA UMUM DAERAH <br>
                    NOMOR $lcnospd <br>
                    TENTANG <br>
                    SURAT PENYEDIAAN DANA ANGGARAN BELANJA DAERAH <br>
                    TAHUN ANGGARAN $thn_ang <br><br>
                    PPKD SELAKU BUD
                </td>
            </tr>
        </table> ";
        $cRet .="    
        <table style=\"border-collapse:collapse;font-family: Arial; font-size:12px\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\">
            <tr>
                <td width = \"18%\" valign = \"top\">Menimbang</td>
                <td width = \"2%\" valign = \"top\">:</td>
                <td width = \"80%\" align = \"justify\" colspan = \"2\">Bahwa untuk melaksanakan anggaran belanja sub kegiatan tahun anggaran 2021 berdasarkan DPA-SKPD dan
                anggaran kas yang telah ditetapkan, perlu disediakan pendanaan dengan menerbitkan Surat Penyediaan Dana (SPD);</td>
            </tr>
            <tr>
                <td width = \"18%\" valign = \"top\">Mengingat</td>
                <td width = \"2%\" valign = \"top\">:</td>
                <td width = \"3%\" valign = \"top\" style = \"padding:5px;\">1.</td>
                <td width = \"77%\" align = \"justify\" style = \"padding:5px;\">Peraturan Daerah Nomor 188.352/5/2020 tentang Penetapan APBD Kabupaten ".ucwords(strtolower($kab))." Tahun Anggaran $thn_ang;</td>
            </tr>
            <tr>
                <td width = \"18%\" valign = \"top\">&nbsp;</td>
                <td width = \"2%\" valign = \"top\">&nbsp;</td>
                <td width = \"3%\" valign = \"top\" style = \"padding:5px;\">2.</td>
                <td width = \"77%\" align = \"justify\" style = \"padding:5px;\">Peraturan Kepala Daerah Nomor 21 Tahun 2021 tentang Pergeseran Penjabaran APBD Kabupaten ".ucwords(strtolower($kab))." Tahun Anggaran $thn_ang;</td>
            </tr>
            <tr>
                <td width = \"18%\" valign = \"top\">&nbsp;</td>
                <td width = \"2%\" valign = \"top\">&nbsp;</td>
                <td width = \"3%\" valign = \"top\" style = \"padding:5px;\">3.</td>
                <td width = \"77%\" align = \"justify\" style = \"padding:5px;padding-bottom:20px;\">DPA-SKPD Kabupaten Aceh Singkil Nomor $no_dpa Tahun $thn_ang;</td>
            </tr>
            <tr>
                <td align = \"center\" colspan = \"4\">MEMUSTUSKAN</td>
            </tr>
            <tr>
                <td colspan=\"4\" style = \"text-align:justify;padding-bottom:20px;\">
                <p>
                    Berdasarkan Peraturan Daerah Kabupaten ".ucwords(strtolower($kab))." Nomor 188.352/5/2020, tanggal 28 Bulan 12 Tahun 2020 tentang Anggaran
                    Pendapatan dan Belanja Daerah Kabupaten ".ucwords(strtolower($kab))." Tahun Anggaran $thn_ang menetapkan/menyediakan kredit anggaran sebagai
                    berikut:
                </p>
                </td>
            </tr>
        </table> ";

        $cRet .="    
        <table style=\"border-collapse:collapse;font-family: Arial; font-size:12px\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\">
            <tr>
                <td style = \"width:5%\">1.</td>
                <td style = \"width:25%\" colspan = \"2\">Dasar penyediaan dana:</td>
                <td style = \"width:5%;text-align:center;\">&nbsp;</td>
                <td style = \"width:65%\">&nbsp;</td>
            </tr>
            <tr>
                <td style = \"width:5%\">&nbsp;</td>
                <td style = \"width:25%\" colspan = \"2\">DPA-SKPD</td>
                <td style = \"width:5%;text-align:center;\">:</td>
                <td style = \"width:65%\">$no_dpa</td>
            </tr>
            <tr>
                <td style = \"width:5%\">2.</td>
                <td style = \"width:25%\" colspan = \"2\">Ditujukan kepada SKPD</td>
                <td style = \"width:5%;text-align:center;\">:</td>
                <td style = \"width:65%\">$nm_skpd</td>
            </tr>
            <tr>
                <td style = \"width:5%\">3.</td>
                <td style = \"width:25%\" colspan = \"2\">Kepala SKPD</td>
                <td style = \"width:5%;text-align:center;\">:</td>
                <td style = \"width:65%\">$nm_pa</td>
            </tr>
            <tr>
                <td style = \"width:5%\" valign = \"top\">4.</td>
                <td style = \"width:25%\" valign = \"top\" colspan = \"2\">Jumlah Penyedia dana</td>
                <td style = \"width:5%;text-align:center;\" valign = \"top\">:</td>
                <td style = \"width:65%\">
                    Rp. ".number_format($nilai_spd,2)." <br>
                    <i>(".ucwords($this->rka_model->terbilang($nilai_spd))." Rupiah)</i>
                </td>
            </tr>
            <tr>
                <td style = \"width:5%\">5.</td>
                <td style = \"width:25%\" colspan = \"2\">Untuk Kebutuhan</td>
                <td style = \"width:5%;text-align:center;\">:</td>
                <td style = \"width:65%\">".$this->rka_model->getBulan($bulan_awal)." s/d ".$this->rka_model->getBulan($bulan_akhir)."</td>
            </tr>
            <tr>
                <td style = \"width:5%\">6.</td>
                <td style = \"width:25%\" colspan = \"2\">Ikhtisar penyediaan dana :</td>
                <td style = \"width:5%;text-align:center;\">&nbsp;</td>
                <td style = \"width:65%\">&nbsp;</td>
            </tr>
            <tr>
                <td style = \"width:5%\">&nbsp;</td>
                <td style = \"width:5%\" valign = \"top\">a.&nbsp;</td>
                <td style = \"width:20%\" valign = \"top\">Jumlah dana DPA-SKPD</td>
                <td style = \"width:5%;text-align:center;\" valign = \"top\">:</td>
                <td style = \"width:65%\" valign = \"top\">
                    Rp. ".number_format($nilai_ang,2)." <br>
                    <i>(".ucwords($this->rka_model->terbilang($nilai_ang))." Rupiah)</i>
                </td>
            </tr>
            <tr>
                <td style = \"width:5%\">&nbsp;</td>
                <td style = \"width:5%\" valign = \"top\">b.&nbsp;</td>
                <td style = \"width:20%\" valign = \"top\">Akumulasi SPD Sebelumnya</td>
                <td style = \"width:5%;text-align:center;\" valign = \"top\">:</td>
                <td style = \"width:65%\" valign = \"top\">
                    Rp. ".number_format($spd_sebelum,2)." <br>
                    <i>(".ucwords($this->rka_model->terbilang($spd_sebelum))." Rupiah)</i>
                </td>
            </tr>
            <tr>
                <td style = \"width:5%\">&nbsp;</td>
                <td style = \"width:5%\" valign = \"top\">c.&nbsp;</td>
                <td style = \"width:20%\" valign = \"top\">Jumlah dana yang di-SPD-kan saat ini</td>
                <td style = \"width:5%;text-align:center;\" valign = \"top\">:</td>
                <td style = \"width:65%\" valign = \"top\">
                    Rp. ".number_format($nilai_spd,2)." <br>
                    <i>(".ucwords($this->rka_model->terbilang($nilai_spd))." Rupiah)</i>
                </td>
            </tr>
            <tr>
                <td style = \"width:5%\">&nbsp;</td>
                <td style = \"width:5%\" valign = \"top\">d.&nbsp;</td>
                <td style = \"width:20%\" valign = \"top\">Sisa jumlah dana DPA-SKPD yang belum di-SPD-kan</td>
                <td style = \"width:5%;text-align:center;\" valign = \"top\">:</td>
                <td style = \"width:65%\" valign = \"top\">
                    Rp. ".number_format($belum_spd,2)." <br>
                    <i>(".ucwords($this->rka_model->terbilang($belum_spd))." Rupiah)</i>
                </td>
            </tr>
            <tr>
                <td style = \"width:5%\" style = \"padding-bottom:20px;\">7.</td>
                <td style = \"width:25%\" colspan = \"2\" style = \"padding-bottom:20px;\">Ketentuan-ketentuan lain</td>
                <td style = \"width:5%;text-align:center;\" style = \"padding-bottom:20px;\">:</td>
                <td style = \"width:65%\" style = \"padding-bottom:20px;\">SPD $tw $nm_skpd Tahun Anggaran $thn_ang</td>
            </tr>
        </table>";
        $cRet .="    
        <table style=\"border-collapse:collapse;font-family: Arial; font-size:12px\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\">
            <tr>
                <td width = \"30%\">&nbsp;</td>
                <td width = \"40%\">&nbsp;</td>
                <td width = \"30%\" valign = \"top\" align = \"center\">
                    Ditetapkan di $daerah <br>
                    Pada Tanggal ".$this->tukd_model->tanggal_format_indonesia($tgl_spd)." <br>
                    BENDAHARA UMUM DAERAH, <br><br><br><br><br><br><br>
                    <u>$nama_ppkd</u> <br>
                    NIP. $nip_ppkd
                </td>
            </tr>
            <tr>
                <td width = \"30%\" valign = \"top\" align = \"left\">
                    Tembusan disampaikan Kepada : <br>
                    1. Inspektur *); <br>
                    2. Arsip <br><br><br>
                    *) Coret yang tidak perlu
                </td>
                <td width = \"40%\" valign = \"top\" align = \"center\">&nbsp;</td>
                <td width = \"30%\" valign = \"top\" align = \"center\">&nbsp;</td>
            </tr>
        </table>";
        $data['prev']= $cRet;
        $this->rka_model->_mpdf_folio('',$cRet,10,10,10,'0');



    }
   
   function preview_cetak_spd_bud(){

        $cetak = $this->uri->segment(4);
        $data_triw = $this->uri->segment(5);
        $ttd1x = $this->uri->segment(6);
        $ttd1 = str_replace('x',' ',$ttd1x);
        $tgl2 = $this->uri->segment(7);
        $ttd_tgl = $this->tukd_model->tanggal_format_indonesia($tgl2);

        $sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab, pangkat as pangkat FROM ms_ttd WHERE nip='$ttd1'";
                 $sqlttd=$this->db->query($sqlttd1);
                 foreach ($sqlttd->result() as $rowttd)
                {
                    //$jdlnip1 = 'Menyetujui,';                    
                    $nip1=empty($rowttd->nip) ? '' : 'NIP.'.$rowttd->nip ;
                    $pangkat1=empty($rowttd->pangkat) ? '' : $rowttd->pangkat;
                    $nama1= empty($rowttd->nm) ? '' : $rowttd->nm;
                    $jabatan1  = empty($rowttd->jab) ? '': $rowttd->jab;
                }

        $sqlsc="SELECT tgl_rka,provinsi,kab_kota,daerah,thn_ang FROM sclient where kd_skpd='4.02.01.00'";
                 $sqlsclient=$this->db->query($sqlsc);
                 foreach ($sqlsclient->result() as $rowsc)
                {
                   
                    $tgl=$rowsc->tgl_rka;
                    $tanggal = $this->tanggal_format_indonesia($tgl);
                    $kab     = $rowsc->kab_kota;
                    $daerah  = $rowsc->daerah;
                    $thn     = $rowsc->thn_ang;
                }

        $awl='';
        $jdl='';

        if($data_triw=='1'){
            $awl='1';
            $jdl='TRIWULAN I';
        }else if($data_triw=='2'){
            $awl='4';
            $jdl='TRIWULAN II';
        }else if($data_triw=='3'){
            $awl='7';
            $jdl='TRIWULAN III';
        }else{
            $awl='10';
            $jdl='TRIWULAN IV';
        }

        $cRet='';
       $Xret1 = '';
       $Xret1.="<table style=\"font-size:30px;border-left:solid 0px black;border-top:solid 0px black;border-right:solid 0px black;\" width=\"100%\" border=\"0\">
                    <tr>
                        <td align=\"center\" colspan=\"5\" style=\"font-size:22px;border: solid 0px white;\"><b>LAPORAN REGISTER SPD<br>$jdl</b></td>                     
                    </tr>
                    <tr>
                        <td align=\"center\" colspan=\"5\" style=\"font-size:22px;border: solid 0px white;\"><b>&nbsp;</b></td>                     
                    </tr>
                 </table>";

       $Xret2 = '';
       $Xret3 = ''; 
       
       $Xret2.="<table style=\"border-collapse:collapse;font-size:14px;border-left:solid 1px black;border-top:solid 1px black;border-right:solid 1px black;\" width=\"100%\" border=\"0\">
                    ";
       $Xret3.= " 
                 </table>";
            $cRet .= $Xret1.$Xret2.$Xret3; 
        
        
        $font = 11;
        $font1 = $font - 1;
        
        $cRet .= "<table style=\"border-collapse:collapse;vertical-align:midle;font-size:15 px;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"1\">

                     <thead >                       
                        <tr>
                            <td bgcolor=\"#A9A9A9\" width=\"5%\" align=\"center \"><b>No</b></td>
                            <td bgcolor=\"#A9A9A9\" width=\"14%\" align=\"center \"><b>Kode SKPD</b></td>
                            <td bgcolor=\"#A9A9A9\" width=\"30%\" align=\"center\"><b>Nama SKPD</b></td>
                            <td bgcolor=\"#A9A9A9\" width=\"20%\" align=\"center\"><b>Belanaja Tidak Langsung<br>(Rp)</b></td>
                            <td bgcolor=\"#A9A9A9\" width=\"20%\" align=\"center\"><b>Belanja Langsung<br>(Rp)</b></td>
                             <td bgcolor=\"#A9A9A9\" width=\"20%\" align=\"center\"><b>Total<br>(Rp)</b></td>
                         </tr>
                     </thead>
                     
                   
                        ";

                $sql1="select kd_skpd,nm_skpd,sum(BTL) as BTL,sum(BL) as BL from
                        (
                        select kd_skpd,nm_skpd,total_hasil as BTL,0 as BL from trhspd
                        where bulan_awal ='$awl' and jns_beban ='51'
                        union
                        select kd_skpd,nm_skpd,0 as BL,total_hasil as BL from trhspd
                        where bulan_awal ='$awl' and jns_beban ='52'
                        )x
                        group by kd_skpd,nm_skpd
                        order by kd_skpd 
  
                        ";
  

                
                $query = $this->db->query($sql1);
                $ii=0;              
                foreach ($query->result() as $row)
                {
                    $skpd=rtrim($row->kd_skpd);
                    $nama=rtrim($row->nm_skpd);
                    $BL=($row->BL);
                    $nilai_BL = number_format($BL,2,',','.');
                    $BTL=($row->BTL);
                    $nilai_BTL = number_format($BTL,2,',','.');
                    $totalx=$BL+$BTL;
                     $total = number_format($totalx,2,',','.');
                    $ii++;
                   


                      $cRet    .= " <tr>
                                        <td align=\"center\" style=\"vertical-align:middle; \" >$ii</td>                                
                                        <td align=\"center\" style=\"vertical-align:middle; \" >$skpd</td>
                                        <td align=\"left\" style=\"vertical-align:middle; \" >$nama</td>
                                        <td align=\"right\" style=\"vertical-align:middle; \" >$nilai_BTL</td>
                                        <td align=\"right\" style=\"vertical-align:middle; \" >$nilai_BL</td>
                                        <td align=\"right\" style=\"vertical-align:middle; \" >$total</td>
                                        
 
                                    </tr> 
                                   
                                    ";
    
                }

                $sql2="SELECT sum(BTL) as btlx,sum(bl) as blx from
                        (
                        select sum(total_hasil) as BTL,0 as BL from trhspd where jns_beban ='51' and bulan_awal ='$awl'
                        union
                        select 0 BTL,sum(total_hasil) as  BL from trhspd where jns_beban ='52' and bulan_awal ='$awl'
                        )x
                        ";
  

                
                $query = $this->db->query($sql2);
               foreach ($query->result() as $rows)
                {
                    $BLx=($rows->blx);
                    $nilai_BLx = number_format($BLx,2,',','.');
                    $BTLx=($rows->btlx);
                    $nilai_BTLx = number_format($BTLx,2,',','.');
                    $totalx=$BLx+$BTLx;
                     $totalxx = number_format($totalx,2,',','.');
                    $ii++;
                   


                      $cRet    .= " <tr>
                                        <td align=\"right\" colspan=\"3\" style=\"vertical-align:middle; \" >TOTAL</td>
                                        <td align=\"right\" style=\"vertical-align:middle; \" >$nilai_BTLx</td>
                                        <td align=\"right\" style=\"vertical-align:middle; \" >$nilai_BLx</td>
                                        <td align=\"right\" style=\"vertical-align:middle; \" >$totalxx</td>
                                        
 
                                    </tr>
                                    ";
    
                }

 
        $cRet .="

                                    </table>
									<table style=\"border-collapse:collapse;vertical-align:midle;font-size:15 px;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"1\">
                                    <tr>
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>                                
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"left\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"left\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"center\" colspan=\"2\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>                                
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"left\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"left\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"center\" colspan=\"2\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>                                
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"left\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"left\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"center\" colspan=\"2\" style=\"vertical-align:middle; \" >$daerah, $ttd_tgl</td>
                                    </tr>
                                    <tr>
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>                                
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"left\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"left\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"center\" colspan=\"2\" style=\"vertical-align:middle; \" >$jabatan1</td>
                                    </tr>
                                    <tr>
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>                                
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"left\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"left\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"center\" colspan=\"2\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>                                
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"left\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"center\" colspan=\"2\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>                                
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"left\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"center\" colspan=\"2\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>                                
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"left\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"center\" colspan=\"2\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>                                
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"left\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"center\" colspan=\"2\" style=\"vertical-align:middle; \" ><b><u>$nama1</u></b></td>
                                    </tr>
                                    <tr>
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>                                
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"left\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"center\" colspan=\"2\" style=\"vertical-align:middle; \" >$nip1</td>
                                    </tr>
                                    
                             
       </table>
        ";
 
        $data['prev']= $cRet;    
        switch($cetak) {
        case 0;
               echo ("<title>Lap Regis SPD</title>");
                echo($cRet);
        break;
        case 1;
             $this->_mpdf('',$cRet,10,10,10,'1');
        break;
        case 2;        
            header("Cache-Control: no-cache, no-store, must-revalidate");
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename= cek_anggaran.xls");
            $this->load->view('anggaran/rka/perkadaII', $data);
        break;
        
        }    
    }

//end cetakan register spd//


//cetakan pembanding spd awal dan akhir//


function cek_pembanding_spd()
    {
        $data['page_title']= 'CETAK PERBANDINGAN SPD';
        $this->template->set('title', 'CETAK PERBANDINGAN SPD');   
        $this->template->load('template','anggaran/spd/cek_pembanding_spd',$data) ; 
    }
   
   function preview_cetak_spd_pembanding(){
        $cetak = $this->uri->segment(4);
        $data_triw = $this->uri->segment(5);
        $ttd1x = $this->uri->segment(6);
        $ttd1 = str_replace('x',' ',$ttd1x);
        $tgl2 = $this->uri->segment(7);
		$skp = $this->uri->segment(8);
        $ttd_tgl = $this->tukd_model->tanggal_format_indonesia($tgl2);

        $sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab, pangkat as pangkat FROM ms_ttd WHERE nip='$ttd1x' and kode='PA'";
                 $sqlttd=$this->db->query($sqlttd1);
                 foreach ($sqlttd->result() as $rowttd)
                {
                    //$jdlnip1 = 'Menyetujui,';                    
                    $nip1=empty($rowttd->nip) ? '' : 'NIP.'.$rowttd->nip ;
                    $pangkat1=empty($rowttd->pangkat) ? '' : $rowttd->pangkat;
                    $nama1= empty($rowttd->nm) ? '' : $rowttd->nm;
                    $jabatan1  = empty($rowttd->jab) ? '': $rowttd->jab;
                }

        $sqlsc="SELECT tgl_rka,provinsi,kab_kota,daerah,thn_ang FROM sclient where kd_skpd='$skp'";
                 $sqlsclient=$this->db->query($sqlsc);
                 foreach ($sqlsclient->result() as $rowsc)
                {
                   
                    $tgl=$rowsc->tgl_rka;
                    $tanggal = $this->tanggal_format_indonesia($tgl);
                    $kab     = $rowsc->kab_kota;
                    $daerah  = $rowsc->daerah;
                    $thn     = $rowsc->thn_ang;
                }
				
		$sqlscx="SELECT kd_skpd,nm_skpd FROM trhspd where kd_skpd='$skp'";
                 $sqlsclient=$this->db->query($sqlscx);
                 foreach ($sqlsclient->result() as $rowscw)
                {    
                    $skpd     = $rowscw->kd_skpd;
                    $nm_skpd  = $rowscw->nm_skpd;
                }

        $awl='';
        $jdl='';

        if($data_triw=='1'){
            $awl='1';
            $jdl='TRIWULAN I';
        }else if($data_triw=='2'){
            $awl='4';
            $jdl='TRIWULAN II';
        }else if($data_triw=='3'){
            $awl='7';
            $jdl='TRIWULAN III';
        }else{
            $awl='10';
            $jdl='TRIWULAN IV';
        }

        $cRet='';
       $Xret1 = '';
       $Xret1.="<table style=\"font-size:30px;border-left:solid 0px black;border-top:solid 0px black;border-right:solid 0px black;\" width=\"100%\" border=\"0\">
                    <tr>
                        <td align=\"center\" colspan=\"5\" style=\"font-size:22px;border: solid 0px white;\"><b>LAPORAN PERBANDINGAN NILAI SPD DAN SPD REVISI<br>$jdl</b></td>                     
                    </tr>
                    <tr>
                        <td align=\"center\" colspan=\"5\" style=\"font-size:22px;border: solid 0px white;\"><b>&nbsp;</b></td>                     
                    </tr>
                 </table>";

       $Xret2 = '';
       $Xret3 = ''; 
       
       $Xret2.="<table style=\"border-collapse:collapse;font-size:14px;border-left:solid 1px black;border-top:solid 1px black;border-right:solid 1px black;\" width=\"100%\" border=\"0\">
                    ";
       $Xret3.= " 
                 </table>";
            $cRet .= $Xret1.$Xret2.$Xret3; 
        
        
        $font = 11;
        $font1 = $font - 1;
        $cRet .= "<table style=\"border-collapse:collapse;vertical-align:midle;font-size:18px;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"1\">
				  <tr>
						<td><b>SKPD : $skpd - $nm_skpd<br></b></td>
				  </tr>
				  </table>";
        $cRet .= "<table style=\"border-collapse:collapse;vertical-align:midle;font-size:15 px;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"1\">

                     <thead >                       
                        <tr>
                            <td bgcolor=\"#A9A9A9\" align=\"center \"><b>No</b></td>
                            <td bgcolor=\"#A9A9A9\" align=\"center \"><b>Kode</b></td>
                            <td bgcolor=\"#A9A9A9\" align=\"center\"><b>Nama</b></td>
                            <td bgcolor=\"#A9A9A9\" align=\"center\"><b>Nilai SPD Awal<br>(Rp)</b></td>
                            <td bgcolor=\"#A9A9A9\" align=\"center\"><b>Nilai Perubahan<br>(Rp)</b></td>
                            <td bgcolor=\"#A9A9A9\" align=\"center\"><b>Selisih<br>(Rp)</b></td>
                         </tr>
						 <tr>
                            <td bgcolor=\"#A9A9A9\" width=\"5%\" align=\"center \"><b>1</b></td>
                            <td bgcolor=\"#A9A9A9\" width=\"10%\" align=\"center \"><b>2</b></td>
                            <td bgcolor=\"#A9A9A9\" width=\"40%\" align=\"center\"><b>3</b></td>
                            <td bgcolor=\"#A9A9A9\" width=\"15%\" align=\"center\"><b>4</b></td>
                            <td bgcolor=\"#A9A9A9\" width=\"15%\" align=\"center\"><b>5</b></td>
                             <td bgcolor=\"#A9A9A9\" width=\"15%\" align=\"center\"><b>6 = 5 - 4</b></td>
                         </tr>
                     </thead>
                     
                   
                        ";

                $sql1="SELECT *,nilai_final-nilai selisih from(
						select '1' as no, b.kd_skpd,a.kd_program kode,a.nm_program nama,sum(a.nilai) nilai,
						sum(a.nilai_final) nilai_final,b.jns_beban from 
						trdspd a left join trhspd b on a.no_spd = b.no_spd
						where b.bulan_awal ='$awl'
						group by b.kd_skpd,a.kd_program,a.nm_program,b.jns_beban
						union
						select '2' as no, b.kd_skpd,a.kd_subkegiatan kode,a.nm_subkegiatan nama,
						sum(a.nilai) nilai,sum(a.nilai_final) nilai_final,b.jns_beban from 
						trdspd a left join trhspd b on a.no_spd = b.no_spd
						where b.bulan_awal ='$awl'
						group by b.kd_skpd,a.kd_subkegiatan,a.nm_subkegiatan,b.jns_beban
						)x
						where kd_skpd ='$skp'
						order by kode
					  ";
  

                
                $query = $this->db->query($sql1);
                $ii=0;              
                foreach ($query->result() as $row)
                {
                    $kode=rtrim($row->kode);
                    $nama=rtrim($row->nama);
                    $nilai=($row->nilai);
                    $cno=($row->no);
                    $nilai_murni = number_format($nilai,2,',','.');
                    $nilaiak=($row->nilai_final);
                    $nilai_final = number_format($nilaiak,2,',','.');
					$sel=($row->selisih);
                    $nilai_selisih = number_format($sel,2,',','.');
                    $totalx=$nilai+$nilaiak;
                     $total = number_format($totalx,2,',','.');
                    $ii++;

                    if($cno=='1'){
                        $cRet    .= " <tr>
                                        <td align=\"center\" style=\"vertical-align:middle; \" ><b>$ii</b></td>                                
                                        <td align=\"LEFT\" style=\"vertical-align:middle; \" ><b>$kode</b></td>
                                        <td align=\"left\" style=\"vertical-align:middle; \" ><b>$nama</b></td>
                                        <td align=\"right\" style=\"vertical-align:middle; \" ><b>$nilai_murni</b></td>
                                        <td align=\"right\" style=\"vertical-align:middle; \" ><b>$nilai_final</b></td>
                                        <td align=\"right\" style=\"vertical-align:middle; \" ><b>$nilai_selisih</b></td> 
                                    </tr>                                    
                                    ";
                    }else{
                        $cRet    .= " <tr>
                                        <td align=\"center\" style=\"vertical-align:middle; \" >$ii</td>                                
                                        <td align=\"LEFT\" style=\"vertical-align:middle; \" >$kode</td>
                                        <td align=\"left\" style=\"vertical-align:middle; \" >$nama</td>
                                        <td align=\"right\" style=\"vertical-align:middle; \" >$nilai_murni</td>
                                        <td align=\"right\" style=\"vertical-align:middle; \" >$nilai_final</td>
                                        <td align=\"right\" style=\"vertical-align:middle; \" >$nilai_selisih</td> 
                                    </tr>                                    
                                    ";
                    }
    
                }

                $sql2="SELECT sum(BTL) as btlx,sum(bl) as blx from
                        (
                        select sum(total_hasil) as BTL,0 as BL from trhspd where jns_beban ='51' and bulan_awal ='$awl'
                        union
                        select 0 BTL,sum(total_hasil) as  BL from trhspd where jns_beban ='52' and bulan_awal ='$awl'
                        )x
                        ";

 
        $cRet .="

                                    </table>
									<table style=\"border-collapse:collapse;vertical-align:midle;font-size:15 px;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"1\">
                                    <tr>
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>                                
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"left\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"left\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"center\" colspan=\"2\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>                                
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"left\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"left\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"center\" colspan=\"2\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>                                
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"left\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"left\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"center\" colspan=\"2\" style=\"vertical-align:middle; \" >$daerah, $ttd_tgl</td>
                                    </tr>
                                    <tr>
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>                                
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"left\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"left\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"center\" colspan=\"2\" style=\"vertical-align:middle; \" >$jabatan1</td>
                                    </tr>
                                    <tr>
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>                                
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"left\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"left\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"center\" colspan=\"2\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>                                
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"left\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"center\" colspan=\"2\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>                                
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"left\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"center\" colspan=\"2\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>                                
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"left\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"center\" colspan=\"2\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>                                
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"left\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"center\" colspan=\"2\" style=\"vertical-align:middle; \" ><b><u>$nama1</u></b></td>
                                    </tr>
                                    <tr>
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>                                
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"left\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"center\" colspan=\"2\" style=\"vertical-align:middle; \" >$nip1</td>
                                    </tr>
                                    
                             
       </table>
        ";
 
        $data['prev']= $cRet;
        switch($cetak) {
        case 0;
               echo ("<title>Lap Regis SPD</title>");
                echo($cRet);
        break;
        case 1;
             $this->_mpdf('',$cRet,10,10,10,'1');
        break;
        case 2;        
            header("Cache-Control: no-cache, no-store, must-revalidate");
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename= cek_anggaran.xls");
            $this->load->view('anggaran/rka/perkadaII', $data);
        break;
        
        }    
    }
	
	function _mpdf($judul='',$isi='',$lMargin='',$rMargin='',$font=10,$orientasi='',$hal='',$tab='',$jdlsave='',$tMargin='') {
                

        ini_set("memory_limit","-1");
        $this->load->library('mpdf');
        //$this->mpdf->SetHeader('||Halaman {PAGENO} /{nb}');
        

        $this->mpdf->defaultheaderfontsize = 6; /* in pts */
        $this->mpdf->defaultheaderfontstyle = BI;   /* blank, B, I, or BI */
        $this->mpdf->defaultheaderline = 1;     /* 1 to include line below header/above footer */

        $this->mpdf->defaultfooterfontsize = 1; /* in pts */
        $this->mpdf->defaultfooterfontstyle = blank;    /* blank, B, I, or BI */
        $this->mpdf->defaultfooterline = 0; 
        $sa=1;
        $tes=0;
        if ($hal==''){
        $hal1=1;
        } 
        if($hal!==''){
        $hal1=$hal;
        }
        
        if ($tMargin=='' ){
            $tMargin=16;
        }
        
        if($lMargin==''){
            $lMargin=15;
        }

        if($rMargin==''){
            $rMargin=15;
        }
        
        
        $this->mpdf = new mPDF('utf-8', array(215,330),$size,'',$lMargin,$rMargin,$tMargin); //folio
        
        $mpdf->cacheTables = true;
        $mpdf->packTableData=true;
        $mpdf->simpleTables=true;
        $this->mpdf->AddPage($orientasi,'',$hal1,'1','off');
        if (!empty($tab)) $this->mpdf->SetTitle($tab); 
        if ($hal != 'no'){
            $this->mpdf->SetFooter("Halaman {PAGENO}  ");
        }
        if (!empty($judul)) $this->mpdf->writeHTML($judul);
        //$this->mpdf->simpleTables= true;     
        $this->mpdf->writeHTML($isi);         
        //$this->mpdf->Output('');
        $this->mpdf->Output($judul,'I');
    }
	
	
	function preview_cetak_spd_pembanding_rekap(){
        $kd_skpd = $this->session->userdata('kdskpd'); 
        $cetak = $this->uri->segment(4);
        $data_triw = $this->uri->segment(5);
        $ttd1x = $this->uri->segment(6);
        $ttd1 = str_replace('x',' ',$ttd1x);
        $tgl2 = $this->uri->segment(7);
	
        $ttd_tgl = $this->tukd_model->tanggal_format_indonesia($tgl2);

        $sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab, pangkat as pangkat FROM ms_ttd WHERE nip='$ttd1' and kode='PA'";
                 $sqlttd=$this->db->query($sqlttd1);
                 foreach ($sqlttd->result() as $rowttd)
                {
                    //$jdlnip1 = 'Menyetujui,';                    
                    $nip1=empty($rowttd->nip) ? '' : 'NIP.'.$rowttd->nip ;
                    $pangkat1=empty($rowttd->pangkat) ? '' : $rowttd->pangkat;
                    $nama1= empty($rowttd->nm) ? '' : $rowttd->nm;
                    $jabatan1  = empty($rowttd->jab) ? '': $rowttd->jab;
                }

        $sqlsc="SELECT tgl_rka,provinsi,kab_kota,daerah,thn_ang FROM sclient where kd_skpd='$kd_skpd'";
                 $sqlsclient=$this->db->query($sqlsc);
                 foreach ($sqlsclient->result() as $rowsc)
                {
                   
                    $tgl=$rowsc->tgl_rka;
                    $tanggal = $this->tanggal_format_indonesia($tgl);
                    $kab     = $rowsc->kab_kota;
                    $daerah  = $rowsc->daerah;
                    $thn     = $rowsc->thn_ang;
                }
				
		

        $awl='';
        $jdl='';

        if($data_triw=='1'){
            $awl='1';
            $jdl='TRIWULAN I';
        }else if($data_triw=='2'){
            $awl='4';
            $jdl='TRIWULAN II';
        }else if($data_triw=='3'){
            $awl='7';
            $jdl='TRIWULAN III';
        }else{
            $awl='10';
            $jdl='TRIWULAN IV';
        }

        $cRet='';
       $Xret1 = '';
       $Xret1.="<table style=\"font-size:30px;border-left:solid 0px black;border-top:solid 0px black;border-right:solid 0px black;\" width=\"100%\" border=\"0\">
                    <tr>
                        <td align=\"center\" colspan=\"5\" style=\"font-size:22px;border: solid 0px white;\"><b>LAPORAN REKAP SPD SELURUH SKPD<br>$jdl</b></td>                     
                    </tr>
                    <tr>
                        <td align=\"center\" colspan=\"5\" style=\"font-size:22px;border: solid 0px white;\"><b>&nbsp;</b></td>                     
                    </tr>
                 </table>";

       $Xret2 = '';
       $Xret3 = ''; 
       
       $Xret2.="<table style=\"border-collapse:collapse;font-size:14px;border-left:solid 1px black;border-top:solid 1px black;border-right:solid 1px black;\" width=\"100%\" border=\"0\">
                    ";
       $Xret3.= " 
                 </table>";
            $cRet .= $Xret1.$Xret2.$Xret3; 
        
        
        $font = 11;
        $font1 = $font - 1;
        $cRet .= "";
        $cRet .= "<table style=\"border-collapse:collapse;vertical-align:midle;font-size:15 px;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"1\">

                     <thead >                       
                        <tr>
                            <td bgcolor=\"#A9A9A9\" align=\"center \"><b>No</b></td>
                            <td bgcolor=\"#A9A9A9\" align=\"center \"><b>Kode</b></td>
                            <td bgcolor=\"#A9A9A9\" align=\"center\"><b>Nama</b></td>
							<td bgcolor=\"#A9A9A9\" align=\"center\"><b>Jenis</b></td>
                            <td bgcolor=\"#A9A9A9\" align=\"center\"><b>Nilai SPD Awal<br>(Rp)</b></td>
                            <td bgcolor=\"#A9A9A9\" align=\"center\"><b>Nilai Perubahan<br>(Rp)</b></td>
                            <td bgcolor=\"#A9A9A9\" align=\"center\"><b>Selisih<br>(Rp)</b></td>
                         </tr>
						 <tr>
                            <td bgcolor=\"#A9A9A9\" width=\"5%\" align=\"center \"><b>1</b></td>
                            <td bgcolor=\"#A9A9A9\" width=\"10%\" align=\"center \"><b>2</b></td>
                            <td bgcolor=\"#A9A9A9\" width=\"30%\" align=\"center\"><b>3</b></td>
                            <td bgcolor=\"#A9A9A9\" width=\"10%\" align=\"center\"><b>4</b></td>
							<td bgcolor=\"#A9A9A9\" width=\"15%\" align=\"center\"><b>5</b></td>
                            <td bgcolor=\"#A9A9A9\" width=\"15%\" align=\"center\"><b>6</b></td>
                             <td bgcolor=\"#A9A9A9\" width=\"15%\" align=\"center\"><b>7 = 6 - 5</b></td>
                         </tr>
                     </thead>
                     
                   
                        ";

                $sql1="
						select kd_skpd kode,nm_skpd nama,no_spd, total nilai,
						total_refisi nilai_final, total_refisi-total as selisih,
						case when jns_beban ='5' then 'Belanja' 
						when jns_beban ='4' then 'Pendapatan' else 'Pembiayaan' end as hasil
						from trhspd where bulan_awal ='$awl'
						order by kd_skpd,jns_beban
						
					  ";
  

                
                $query = $this->db->query($sql1);
                $ii=0;              
                foreach ($query->result() as $row)
                {
                    $kode=rtrim($row->kode);
                    $nama=rtrim($row->nama);
					$jns=rtrim($row->hasil);
                    $nilai=($row->nilai);
                    $nilai_murni = number_format($nilai,2,',','.');
                    $nilaiak=($row->nilai_final);
                    $nilai_final = number_format($nilaiak,2,',','.');
					$sel=($row->selisih);
                    $nilai_selisih = number_format($sel,2,',','.');
                    $totalx=$nilai+$nilaiak;
                     $total = number_format($totalx,2,',','.');
                    $ii++;
                   


                      $cRet    .= " <tr>
                                        <td align=\"center\" style=\"vertical-align:middle; \" >$ii</td>                                
                                        <td align=\"left\" style=\"vertical-align:middle; \" >$kode</td>
                                        <td align=\"left\" style=\"vertical-align:middle; \" >$nama</td>
										<td align=\"center\" style=\"vertical-align:middle; \" >$jns</td>
                                        <td align=\"right\" style=\"vertical-align:middle; \" >$nilai_murni</td>
                                        <td align=\"right\" style=\"vertical-align:middle; \" >$nilai_final</td>
                                        <td align=\"right\" style=\"vertical-align:middle; \" >$nilai_selisih</td>
                                        
 
                                    </tr> 
                                   
                                    ";
    
                }
 
                    $cRet .="

                                    </table>
									<table style=\"border-collapse:collapse;vertical-align:midle;font-size:15 px;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"1\">
                                    <tr>
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>                                
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"left\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"left\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"center\" colspan=\"2\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>                                
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"left\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"left\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"center\" colspan=\"2\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>                                
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"left\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"left\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"center\" colspan=\"2\" style=\"vertical-align:middle; \" >$daerah, $ttd_tgl</td>
                                    </tr>
                                    <tr>
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>                                
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"left\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"left\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"center\" colspan=\"2\" style=\"vertical-align:middle; \" >$jabatan1</td>
                                    </tr>
                                    <tr>
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>                                
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"left\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"left\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"center\" colspan=\"2\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>                                
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"left\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"center\" colspan=\"2\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>                                
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"left\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"center\" colspan=\"2\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>                                
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"left\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"center\" colspan=\"2\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>                                
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"left\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"center\" colspan=\"2\" style=\"vertical-align:middle; \" ><b><u>$nama1</u></b></td>
                                    </tr>
                                    <tr>
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>                                
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"center\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"left\" style=\"vertical-align:middle; \" >&nbsp;</td>
                                        <td align=\"center\" colspan=\"2\" style=\"vertical-align:middle; \" >$nip1</td>
                                    </tr>
                                    
                             
       </table>
        ";
 
        $data['prev']= $cRet;    
        switch($cetak) {
        case 0;
               echo ("<title>Lap Regis SPD</title>");
                echo($cRet);
        break;
        case 1;
             $this->_mpdf('',$cRet,10,10,10,'1');
        break;
        case 2;        
            header("Cache-Control: no-cache, no-store, must-revalidate");
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename= cek_anggaran.xls");
            $this->load->view('anggaran/rka/perkadaII', $data);
        break;
        
        }    
    }

//end cetakan pembanding spd awal dan akhir//	
	
//akhir
}
