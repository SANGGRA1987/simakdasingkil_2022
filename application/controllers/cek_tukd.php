<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller master data kegiatan
 */

class cek_tukd extends CI_Controller {

public $ppkd = "4.02.01";
public $ppkd1 = "4.02.01.00";

    function __contruct()
    {   
        parent::__construct();
  
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
    



    function cek_realisasi_anggaran()
    {
        $data['page_title']= 'Laporan Pembanding Anggaran dan Realisasi';
        $this->template->set('title', 'Laporan Pembanding Anggaran dan Realisasi');   
        $this->template->load('template','tukd_cek/cek_realisasi_anggaran',$data) ; 
   }
   
   



    function preview_cetakan_cek_realisasi(){
 //       $id = $this->uri->segment(3);
        $cetak = $this->uri->segment(4);
 //       $status_ang = $this->uri->segment(5);

/*
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
  */   
        
        $cRet='';
       $Xret1 = '';
       $Xret1.="<table style=\"font-size:30px;border-left:solid 0px black;border-top:solid 0px black;border-right:solid 0px black;\" width=\"100%\" border=\"0\">
                    <tr>
                        <td align=\"center\" colspan=\"5\" style=\"font-size:22px;border: solid 0px white;\"><b>LAPORAN PERBANDINGAN<br>NILAI ANGGARAN DAN NILAI REALISASI</b></td>                     
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
        
        $cRet .= "<table style=\"border-collapse:collapse;vertical-align:top;font-size:15 px;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"1\">

                     <thead >                       
                        <tr>
                            <td bgcolor=\"#A9A9A9\" width=\"20%\" align=\"center \"><b>Kode Kegiatan</b></td>
                            <td bgcolor=\"#A9A9A9\" width=\"15%\" align=\"center\"><b>Kode Rekening</b></td>
                            <td bgcolor=\"#A9A9A9\" width=\"15%\" align=\"center\"><b>Nilai Anggaran</b></td>
                            <td bgcolor=\"#A9A9A9\" width=\"15%\" align=\"center\"><b>Nilai SPP</b></td>
                            <td bgcolor=\"#A9A9A9\" width=\"15%\" align=\"center\"><b>Nilai TRANS UP</b></td>
                            <td bgcolor=\"#A9A9A9\" width=\"20%\" align=\"center\"><b>Selisih</b></td>
                         </tr>
                     </thead>
                     
                   
                        ";
           

                $sql1="select * from(
                       select *,total=nilai-spp-trans_up from(
                       select a.kd_kegiatan,a.kd_rek5,sum(a.nilai_ubah) [nilai],
                       isnull((select sum(b.nilai) from trdspp b join trhspp e on b.no_spp=e.no_spp and b.kd_skpd=e.kd_skpd
where a.kd_kegiatan=b.kd_kegiatan and a.kd_rek5=b.kd_rek5 and (e.sp2d_batal<>'1' or sp2d_batal is null)),0) [spp],
isnull((select sum(nilai) from trdtransout c join trhtransout d on c.no_bukti=d.no_bukti 
and c.kd_skpd=d.kd_skpd where a.kd_kegiatan=c.kd_kegiatan and a.kd_rek5=c.kd_rek5 and d.jns_spp='1'
and c.no_bukti not in (select no_bukti from trlpj where a.kd_kegiatan=kd_kegiatan and a.kd_rek5=kd_rek5)
),0) [trans_up]
from trdrka a group by a.kd_kegiatan,a.kd_rek5
)gb where (gb.spp<>0 or trans_up<>0)
)jj where total <0 order by kd_kegiatan
  
                        ";
  

                
                $query = $this->db->query($sql1);
                 //$query = $this->skpd_model->getAllc();
                                 
                foreach ($query->result() as $row)
                {
                    $giat=rtrim($row->kd_kegiatan);
                    $rek5=rtrim($row->kd_rek5);
                    $anggaran=rtrim($row->nilai);
                    $nilai_angx = number_format($anggaran,2,',','.');
                    $spp=($row->spp);
                    $nilai_spp = number_format($spp,2,',','.');
                    $nilup=($row->trans_up);
                    $nilai_up = number_format($nilup,2,',','.');
                    $totalselisih=($row->total);
                    $nilai_selisih = number_format($totalselisih,2,',','.');


                      $cRet    .= " <tr>                                
                                        <td align=\"center\" style=\"vertical-align:middle; \" >$giat</td>
                                        <td align=\"left\" style=\"vertical-align:middle; \" >$rek5</td>
                                        <td align=\"right\" style=\"vertical-align:middle; \" >$nilai_angx</td>
                                        <td align=\"right\" style=\"vertical-align:middle; \" >$nilai_spp</td>
                                        <td align=\"right\" style=\"vertical-align:middle; \" >$nilai_up</td>
                                        <td align=\"right\" style=\"vertical-align:middle; \" >$nilai_selisih</td>
                                    </tr> 
                                   
                                    ";
    
                }

 
        $cRet .="</table>";
 
        $data['prev']= $cRet;    
        //$this->_mpdf('',$cRet,10,10,10,0);
        //$this->template->load('template','master/fungsi/list_preview',$data);
        switch($cetak) {
        case 0;
               echo ("<title>Lap Perbandingan Anggaran dan Realisasi</title>");
                echo($cRet);
  
 //           $this->template->load('template','anggaran/rka/perkadaII',$data);
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

 function cek_data_anggaran()
    {
        $data['page_title']= 'Cek Data Anggaran';
        $this->template->set('title', 'Cek Data Anggaran');   
        $this->template->load('template','tukd_cek/cek_data_anggaran',$data) ; 
   }



function preview_cetakan_cek_data_anggaran(){



        $cetak = $this->uri->segment(4);
        $data_ang = $this->uri->segment(5);

        $jdl='';
        if($data_ang=='1'){
            $jdl=' ';
        }else if($data_ang=='2'){
            $jdl=' PERGESERAN ';
        }else if($data_ang=='3'){
            $jdl=' PERUBAHAN ';
        }

        $cRet='';
       $Xret1 = '';
       $Xret1.="<table style=\"font-size:30px;border-left:solid 0px black;border-top:solid 0px black;border-right:solid 0px black;\" width=\"100%\" border=\"0\">
                    <tr>
                        <td align=\"center\" colspan=\"7\" style=\"font-size:22px;border: solid 0px white;\"><b>LAPORAN PERBANDINGAN<br>NILAI ANGGARAN $jdl DAN NILAI ANGGARAN KAS</b></td>                     
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
        
        $cRet .= "<table style=\"border-collapse:collapse;vertical-align:middle;font-size:15 px;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"1\">

                     <thead >                       
                        <tr>
                            <td bgcolor=\"#A9A9A9\" width=\"3%\" align=\"center \"><b>no</b></td>
                            <td bgcolor=\"#A9A9A9\" width=\"17%\" align=\"center \"><b>Kode Kegiatan</b></td>
                            <td bgcolor=\"#A9A9A9\" width=\"12%\" align=\"center \"><b>Nama Kegiatan</b></td>
                            <td bgcolor=\"#A9A9A9\" width=\"11%\" align=\"center\"><b>Nilai TRSKPD</b></td>
                            <td bgcolor=\"#A9A9A9\" width=\"11%\" align=\"center\"><b>Nilai TRDRKA</b></td>
                            <td bgcolor=\"#A9A9A9\" width=\"11%\" align=\"center\"><b>Nilai TRDPO</b></td>
                            <td bgcolor=\"#A9A9A9\" width=\"11%\" align=\"center\"><b>Nilai<br>ANGKAS TRSKPD</b></td>
                            <td bgcolor=\"#A9A9A9\" width=\"11%\" align=\"center\"><b>Nilai<br>ANGKAS TRDSKPD</b></td>
                            <td bgcolor=\"#A9A9A9\" width=\"10%\" align=\"center\"><b>Ket</b></td>
                         </tr>
                     </thead>
                     
                   
                        ";
           
        $stt='';
        if($data_ang=='1'){
            $stt='';
        }else if($data_ang=='2'){
            $stt='_sempurna';
        }else if($data_ang=='3'){
            $stt='_ubah';
        }

                $sql1="select *,b.nm_kegiatan from(
                    select x.kd_kegiatan,x.trskpd,x.trdrka,x.trdpo,x.angkas_trskpd,x.angkas_trdskpd,

                    case
                    when x.trdrka != x.trdpo then 'selisih trdrka dan trdpo'   
                    when x.trdrka != x.angkas_trdskpd then 'selisih trdrka dan angkas trdskpd'                    
                    when x.trskpd != x.trdrka then 'selisih trskpd dan trdrka'
                    when x.trskpd != x.angkas_trskpd then 'selisih trskpd dan angkas trskpd'
                    when x.trskpd != x.angkas_trdskpd then 'selisih trskpd dan angkas trdskpd'
                    when x.trdrka != x.angkas_trskpd then 'selisih trdrka dan angkas trskpd'                  
                    when x.angkas_trskpd != x.angkas_trdskpd then 'selisih angkas trskpd dan angkas trdskpd'
                    ELSE 'sama' end as hasil
                    from(
                    select z.kd_kegiatan as kd_kegiatan,isnull(sum(z.total),0) as trskpd,isnull(sum(z.nilai),0) as trdrka
                    ,isnull(sum(z.trdpo),0) as trdpo,isnull(sum(z.angkas_trskpd),0) as angkas_trskpd,
                                         isnull(sum(z.angkas_trdskpd),0) as angkas_trdskpd
                    from(
                    select kd_kegiatan, total".$stt." as total, 0 as nilai,0 as trdpo,
                    triw1".$stt."+triw2".$stt."+triw3".$stt."+triw4".$stt." as angkas_trskpd,0 as angkas_trdskpd from trskpd
                    UNION
                    select kd_kegiatan,0 as total, sum(nilai".$stt.") as nilai,0 as trdpo,
                                        0 as angkas_trskpd,0 as angkas_trdskpd from trdrka
                    group by kd_kegiatan
                                        UNION
                    select kd_kegiatan,0 as total, 0 as nilai,sum(total".$stt.") as trdpo,
                                        0 as angkas_trskpd,0 as angkas_trdskpd from trdpo
                    group by kd_kegiatan
                    UNION
                    select kd_kegiatan,0 as total, 0 as nilai,0 as trdpo,
                                        0 as angkas_trskpd,sum(nilai".$stt.") as angkas_trdskpd from trdskpd
                    group by kd_kegiatan
                    )z
                    group by z.kd_kegiatan
                    )x
                    )y
                    left join m_giat b on y.kd_kegiatan =b.kd_kegiatan
                    where y.hasil like 'selisih%'
                    order by hasil,y.kd_kegiatan  
  
                        ";
  

                
                $query = $this->db->query($sql1);
                 //$query = $this->skpd_model->getAllc();
                 $ii = 0;                
                foreach ($query->result() as $row)
                {
                    $giat=rtrim($row->kd_kegiatan);
                    $nm=rtrim($row->nm_kegiatan);
                    $trskpd=rtrim($row->trskpd);
                    $nilai_trskpd = number_format($trskpd,2,',','.');
                    $trdrka=($row->trdrka);
                    $nilai_trdrka = number_format($trdrka,2,',','.');
                    $trdpo=($row->trdpo);
                    $nilai_trdpo = number_format($trdpo,2,',','.');
                    $angkas_trskpd=($row->angkas_trskpd);
                    $nilai_angkas_trskpd = number_format($angkas_trskpd,2,',','.');
                    $angkas_trdskpd=($row->angkas_trdskpd);
                    $nilai_angkas_trdskpd = number_format($angkas_trdskpd,2,',','.');
                    $hasil=rtrim($row->hasil);
                     $ii++;

                      $cRet    .= " <tr>
                                         <td align=\"center\" style=\"vertical-align:middle; \" >$ii</td>                                
                                        <td align=\"center\" style=\"vertical-align:middle; \" >$giat</td>
                                        <td align=\"center\" style=\"vertical-align:middle; \" >$nm</td>
                                        <td align=\"right\" style=\"vertical-align:middle; \" >$nilai_trskpd</td>
                                        <td align=\"right\" style=\"vertical-align:middle; \" >$nilai_trdrka</td>
                                        <td align=\"right\" style=\"vertical-align:middle; \" >$nilai_trdpo</td>
                                        <td align=\"right\" style=\"vertical-align:middle; \" >$nilai_angkas_trskpd</td>
                                        <td align=\"right\" style=\"vertical-align:middle; \" >$nilai_angkas_trdskpd</td>
                                        <td align=\"center\" style=\"vertical-align:middle; \" >$hasil</td>
                                    </tr> 
                                   
                                    ";
    
                }

 
        $cRet .="</table>";
 
        $data['prev']= $cRet;    
        //$this->_mpdf('',$cRet,10,10,10,0);
        //$this->template->load('template','master/fungsi/list_preview',$data);
        switch($cetak) {
        case 0;
               echo ("<title>Lap Perbandingan Anggaran dan Realisasi</title>");
                echo($cRet);
  
 //           $this->template->load('template','anggaran/rka/perkadaII',$data);
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
    
    function preview_cetakan_cek_realisasi_baru(){
 //       $id = $this->uri->segment(3);
        $cetak = $this->uri->segment(4);
 //       $status_ang = $this->uri->segment(5);


        
        $cRet='';
       $Xret1 = '';
       $Xret1.="<table style=\"font-size:30px;border-left:solid 0px black;border-top:solid 0px black;border-right:solid 0px black;\" width=\"100%\" border=\"0\">
                    <tr>
                        <td align=\"center\" colspan=\"5\" style=\"font-size:22px;border: solid 0px white;\"><b>LAPORAN PERBANDINGAN<br>NILAI ANGGARAN DAN NILAI REALISASI</b></td>                     
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
        
        $cRet .= "<table style=\"border-collapse:collapse;vertical-align:top;font-size:15 px;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"1\">

                     <thead >                       
                        <tr>
                            <td bgcolor=\"#A9A9A9\" width=\"3%\" align=\"center \"><b>No</b></td>
                            <td bgcolor=\"#A9A9A9\" width=\"10%\" align=\"center \"><b>Kode Kegiatan</b></td>
                            <td bgcolor=\"#A9A9A9\" width=\"5%\" align=\"center\"><b>Kode Rekening</b></td>
                            <td bgcolor=\"#A9A9A9\" width=\"15%\" align=\"center\"><b>Nama Rekening</b></td>
                            <td bgcolor=\"#A9A9A9\" width=\"10%\" align=\"center\"><b>Realiasi</b></td>
                            <td bgcolor=\"#A9A9A9\" width=\"10%\" align=\"center\"><b>Murni</b></td>
                            <td bgcolor=\"#A9A9A9\" width=\"10%\" align=\"center\"><b>Pergeseran</b></td>
                            <td bgcolor=\"#A9A9A9\" width=\"10%\" align=\"center\"><b>Ubah</b></td>
                            <td bgcolor=\"#A9A9A9\" width=\"10%\" align=\"center\"><b>sisa murni</b></td>
                            <td bgcolor=\"#A9A9A9\" width=\"10%\" align=\"center\"><b>sisa pergeseran</b></td>
                            <td bgcolor=\"#A9A9A9\" width=\"10%\" align=\"center\"><b>sisa ubah</b></td>
                         </tr>
                     </thead>
                     
                   
                        ";
           
                $idd = 0;
                $sql1="select * from(
                    SELECT z.kd_kegiatan,z.kd_rek5,z.nm_rek5,sum(isnull(z.lalu,0)) lalu,sum(isnull(z.sp2d,0)) sp2d,
sum(isnull(z.anggaran,0)) anggaran,sum(isnull(z.nilai_sempurna,0)) nilai_sempurna,sum(isnull(z.nilai_uba,0)) nilai_uba,
sum(isnull(z.anggaran,0))-sum(isnull(z.lalu,0)) sisa,sum(isnull(z.nilai_sempurna,0))-sum(isnull(z.lalu,0)) sisa2,sum(isnull(z.nilai_uba,0))-sum(isnull(z.lalu,0)) sisa3
 from(
SELECT a.kd_kegiatan,a.kd_rek5,a.nm_rek5,
            (SELECT SUM(nilai) FROM 
                        (
                        SELECT
                            SUM (isnull(c.nilai,0)) as nilai
                        FROM
                            trdtransout c
                        LEFT JOIN trhtransout d ON c.no_bukti = d.no_bukti
                        AND c.kd_skpd = d.kd_skpd
                        WHERE
                        c.kd_kegiatan = a.kd_kegiatan
                        AND left(d.kd_skpd,7) = left(a.kd_skpd,7)
                        AND c.kd_rek5 = a.kd_rek5   AND d.jns_spp='1'                   
                        UNION ALL
                        SELECT
                            SUM (isnull(c.nilai,0)) as nilai
                        FROM
                            trdtransout c
                        LEFT JOIN trhtransout d ON c.no_bukti = d.no_bukti
                        AND c.kd_skpd = d.kd_skpd
                        WHERE
                        c.kd_kegiatan = a.kd_kegiatan
                        AND left(d.kd_skpd,7) = left(a.kd_skpd,7)
                        AND c.kd_rek5 = a.kd_rek5  AND d.panjar='3' AND d.jns_spp in ('4','6')
                        UNION ALL
                        SELECT
                            SUM (isnull(c.nilai,0)) as nilai
                        FROM
                            trdtransout_cmsbank c
                        LEFT JOIN trhtransout_cmsbank d ON c.no_voucher = d.no_voucher
                        AND c.kd_skpd = d.kd_skpd and c.username=d.username
                        WHERE
                        c.kd_kegiatan = a.kd_kegiatan
                        AND left(d.kd_skpd,7) = left(a.kd_skpd,7)
                        AND c.kd_rek5 = a.kd_rek5
                        AND c.no_voucher <> 'x'
                        AND d.jns_spp='1' AND d.status_validasi='0'
                        UNION ALL
                        SELECT SUM(isnull(x.nilai,0)) as nilai FROM trdspp x
                        INNER JOIN trhspp y 
                        ON x.no_spp=y.no_spp AND x.kd_skpd=y.kd_skpd
                        WHERE
                        x.kd_kegiatan = a.kd_kegiatan
                        AND left(x.kd_skpd,7) = left(a.kd_skpd,7)
                        AND x.kd_rek5 = a.kd_rek5
                        AND y.jns_spp IN ('3','4','5','6')
                        AND (sp2d_batal IS NULL or sp2d_batal ='' or sp2d_batal='0')
                        UNION ALL
                        SELECT SUM(isnull(nilai,0)) as nilai FROM trdtagih t 
                        INNER JOIN trhtagih u 
                        ON t.no_bukti=u.no_bukti AND t.kd_skpd=u.kd_skpd
                        WHERE 
                        t.kd_kegiatan = a.kd_kegiatan
                        AND u.kd_skpd = a.kd_skpd
                        AND t.kd_rek = a.kd_rek5
                        AND u.no_bukti 
                        NOT IN (select no_tagih FROM trhspp WHERE kd_skpd=a.kd_skpd )
                        )r) AS lalu,
                        0 AS sp2d,nilai AS anggaran,nilai_sempurna as nilai_sempurna, nilai_ubah AS nilai_uba                       
                        FROM trdrka a )z 
                        group by z.kd_kegiatan,z.kd_rek5,z.nm_rek5
                        )x
                        where (x.sisa < 0 or x.sisa2 <0 or x.sisa3 <0)
                        order by sisa3

  
                        ";
  

                
                $query = $this->db->query($sql1);
                 //$query = $this->skpd_model->getAllc();
                                 
                foreach ($query->result() as $row)
                {
                    $idd=$idd+1;
                    $giat=rtrim($row->kd_kegiatan);
                    $rek5=rtrim($row->kd_rek5);
                    $nmrek5=rtrim($row->nm_rek5);
                    $lalu=rtrim($row->lalu);
                    $nilai_lalu = number_format($lalu,2,',','.');
                    $sp2d=($row->sp2d);
                    $nilai_sp2d = number_format($sp2d,2,',','.');
                    $anggaran=($row->anggaran);
                    $nilai_anggaran = number_format($anggaran,2,',','.');
                    $sempu=($row->nilai_sempurna);
                    $nilai_sempu = number_format($sempu,2,',','.');
                    $ubah=($row->nilai_uba);
                    $nilai_ubah = number_format($ubah,2,',','.');
                    $sisa=($row->sisa);
                    $nilai_sisa = number_format($sisa,2,',','.');
                    $sisa2=($row->sisa2);
                    $nilai_sisa2 = number_format($sisa2,2,',','.');
                    $sisa3=($row->sisa3);
                    $nilai_sisa3 = number_format($sisa3,2,',','.');


                      $cRet    .= " <tr>                                
                                        
                                        <td align=\"left\" style=\"vertical-align:middle; \" >$idd</td>
                                        <td align=\"left\" style=\"vertical-align:middle; \" >$giat</td>
                                        <td align=\"left\" style=\"vertical-align:middle; \" >$rek5</td>
                                        <td align=\"left\" style=\"vertical-align:middle; \" >$nmrek5</td>
                                        <td align=\"right\" style=\"vertical-align:middle; \" >$nilai_lalu</td>
                                        <td align=\"right\" style=\"vertical-align:middle; \" >$nilai_anggaran</td>
                                        <td align=\"right\" style=\"vertical-align:middle; \" >$nilai_sempu</td>
                                        <td align=\"right\" style=\"vertical-align:middle; \" >$nilai_ubah</td>
                                        <td align=\"right\" style=\"vertical-align:middle; \" >$nilai_sisa</td>
                                        <td align=\"right\" style=\"vertical-align:middle; \" >$nilai_sisa2</td>
                                        <td align=\"right\" style=\"vertical-align:middle; \" >$nilai_sisa3</td>
                                    </tr> 
                                   
                                    ";
    
                }

 
        $cRet .="</table>";
 
        $data['prev']= $cRet;    
        //$this->_mpdf('',$cRet,10,10,10,0);
        //$this->template->load('template','master/fungsi/list_preview',$data);
        switch($cetak) {
        case 0;
               echo ("<title>Lap Perbandingan Anggaran dan Realisasi</title>");
                echo($cRet);
  
 //           $this->template->load('template','anggaran/rka/perkadaII',$data);
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
    
    

    function _mpdf($judul='',$isi='',$lMargin=10,$rMargin=10,$font='',$orientasi='',$hal='', $fonsize='') {
                

        ini_set("memory_limit","-1M");
        ini_set("MAX_EXECUTION_TIME","-1");
        $this->load->library('mpdf');
        //$this->mpdf->SetHeader('||Halaman {PAGENO} /{nb}');
        
        
        $this->mpdf->defaultheaderfontsize = 10;    /* in pts */
        $this->mpdf->defaultheaderfontstyle = I;    /* blank, B, I, or BI */
        $this->mpdf->defaultheaderline = 1;     /* 1 to include line below header/above footer */

        $this->mpdf->defaultfooterfontsize = 3; /* in pts */
        $this->mpdf->defaultfooterfontstyle = I;    /* blank, B, I, or BI */
        $this->mpdf->defaultfooterline = 1; 
        $sa=1;
        $tes=0;
        if ($hal==''){
        $hal1=1;
        } 
        if($hal!==''){
        $hal1=$hal;
        }
        if ($fonsize==''){
        $size=12;
        }else{
        $size=$fonsize;
        } 
        
        $this->mpdf = new mPDF('utf-8', array(215,330),$size); //folio
                            //$this->mpdf->useOddEven = 1;                      

        $this->mpdf->AddPage($orientasi,'',$hal,'1','off');
        if ($hal==''){
            $this->mpdf->SetFooter("");
        }
        else{
            $this->mpdf->SetFooter("Printed on Simakda || Halaman {PAGENO}  ");
        }
        if (!empty($judul)) $this->mpdf->writeHTML($judul);
        $this->mpdf->writeHTML($isi);         
        $this->mpdf->Output();
    }



function cek_data_realisasi_sp2d()
    {
        $data['page_title']= 'Laporan Pembanding Anggaran, SP2D dan Realisasi';
        $this->template->set('title', 'Laporan Pembanding Anggaran, SP2D dan Realisasi');   
        $this->template->load('template','tukd_cek/cek_data_realisasi_sp2d',$data) ; 
   }

   function preview_cek_data_realisasi_sp2d(){



        $cetak = $this->uri->segment(4);
        $bulan = $this->uri->segment(5);
        $ang = $this->uri->segment(6);

        $bulany  = $this-> getBulan($bulan);
        $bulanx  = $this-> getBulan(1);
        $tahun = $this->session->userdata('pcThang');   

       if($ang=='nilai'){
           $ang_judul = 'Anggaran Murni';
       }else if($ang=='nilai_sempurna'){
           $ang_judul = 'Anggaran Pergeseran';
       }else{
           $ang_judul = 'Anggaran Perubahan';
       } 

       $cRet='';
       $Xret1 = '';
       $Xret1.="<table style=\"font-size:30px;border-left:solid 0px black;border-top:solid 0px black;border-right:solid 0px black;\" width=\"100%\" border=\"0\">
                    <tr>
                        <td align=\"center\" colspan=\"7\" style=\"font-size:22px;border: solid 0px white;\"><b>PEMERINTAH KABUPATEN SANGGAU<br>LAPORAN REALISASI<br>".strtoupper($bulanx)." - ".strtoupper($bulany)." <br>TAHUN ".$tahun."</b></td>                     
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
        
        $cRet .= "<table style=\"border-collapse:collapse;vertical-align:middle;font-size:15 px;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"1\">

                     <thead >                       
                        <tr>
                            <td bgcolor=\"#A9A9A9\" width=\"3%\" align=\"center \"><b>No</b></td>
                            <td bgcolor=\"#A9A9A9\" width=\"9%\" align=\"center \"><b>Kode SKPD</b></td>
                            <td bgcolor=\"#A9A9A9\" width=\"20%\" align=\"center \"><b>Nama SKPD</b></td>
                            <td bgcolor=\"#A9A9A9\" width=\"15%\" align=\"center\"><b>".$ang_judul."</b></td>
                            <td bgcolor=\"#A9A9A9\" width=\"15%\" align=\"center\"><b>SP2D</b></td>
                            <td bgcolor=\"#A9A9A9\" width=\"10%\" align=\"center\"><b>%</b></td>
                            <td bgcolor=\"#A9A9A9\" width=\"15%\" align=\"center\"><b>SPJ</b></td>
                            <td bgcolor=\"#A9A9A9\" width=\"10%\" align=\"center\"><b>%</b></td>
                         </tr>
                         <tr>
                            <td bgcolor=\"#A9A9A9\" width=\"3%\" align=\"center \"><b>1</b></td>
                            <td bgcolor=\"#A9A9A9\" width=\"9%\" align=\"center \"><b>2</b></td>
                            <td bgcolor=\"#A9A9A9\" width=\"20%\" align=\"center \"><b>3</b></td>
                            <td bgcolor=\"#A9A9A9\" width=\"15%\" align=\"center\"><b>4</b></td>
                            <td bgcolor=\"#A9A9A9\" width=\"15%\" align=\"center\"><b>5</b></td>
                            <td bgcolor=\"#A9A9A9\" width=\"10%\" align=\"center\"><b>6</b></td>
                            <td bgcolor=\"#A9A9A9\" width=\"15%\" align=\"center\"><b>7</b></td>
                            <td bgcolor=\"#A9A9A9\" width=\"10%\" align=\"center\"><b>8</b></td>
                         </tr>
                     </thead>
                     
                   
                        ";
           
   

                $sql1="select 
left(z.kd_skpd,7)+'.00' as kode_skpd,q.nm_skpd,
isnull(sum(f.nilai_ang),0) as ang_nilai,
isnull(sum(v.nilai_sp2d),0) as sp2d_nilai,
isnull(sum(z.spj_nilai),0) as spj_nilai,
isnull(sum(z.lra),0) as lra_rek,
isnull(sum(z.lra_input),0) as lra_rek_input,
sum(z.lra)+sum(z.lra_input) as tt_lra,
(sum(z.spj_nilai)-sum(z.lra)) as selisih
from (
                select a.kd_skpd,sum(gaji_lalu)+sum(gaji_ini)+sum(brg_lalu)+sum(brg_ini)+sum(up_lalu)+sum(up_ini)+sum(jkn) as spj_nilai,isnull(sum(lra_rek_4),0) as lra,isnull(sum(lra_rek_4_input),0) as lra_input,isnull(sum(jkn),0) as jkn_s from
                (
                select  a.kd_skpd, 0 as gaji_ini, 0 as brg_ini, isnull(a.nilai,0) as up_ini, 0 as gaji_lalu, 0 as brg_lalu, 0 as up_lalu, 0 as lra_rek_4,0 as lra_rek_4_input, 0 as jkn from trdtransout a join trhtransout b on a.no_bukti=b.no_bukti and a.kd_skpd=b.kd_skpd
                where MONTH(b.tgl_bukti)='$bulan' and jns_spp in (1,2,3) 
                union all
                select  a.kd_skpd, 0 as gaji_ini, 0 as brg_ini, 0 as up_ini, 0 as gaji_lalu, 0 as brg_lalu, 0 as up_lalu, 0 as lra_rek_4,0 as lra_rek_4_input, 0 as jkn from trdinlain a join TRHINLAIN b on a.no_bukti=b.no_bukti and a.kd_skpd=b.kd_skpd
                where MONTH(b.TGL_BUKTI)='$bulan' and b.pengurang_belanja=1
                union all
                select a.kd_skpd, isnull(a.nilai,0) as gaji_ini, 0 as brg_ini, 0 as up_ini, 0 as gaji_lalu, 0 as brg_lalu, 0 as up_lalu, 0 as lra_rek_4,0 as lra_rek_4_input, 0 as jkn from trdtransout a join trhtransout b on a.no_bukti=b.no_bukti and a.kd_skpd=b.kd_skpd
                where MONTH(b.tgl_bukti)='$bulan' and jns_spp in (4)
                union all
                select  a.kd_skpd, isnull(a.rupiah*-1,0) as gaji_ini, 0 as brg_ini, 0 as up_ini, 0 as gaji_lalu, 0 as brg_lalu, 0 as up_lalu, 0 as lra_rek_4,0 as lra_rek_4_input, 0 as jkn from trdkasin_pkd a join trhkasin_pkd b on a.no_sts=b.no_sts and a.kd_skpd=b.kd_skpd
                where MONTH(b.tgl_sts)='$bulan' and b.jns_cp in (1) and b.pot_khusus<>0
                union all
                select a.kd_skpd, 0 as gaji_ini, isnull(a.nilai,0) as brg_ini, 0 as up_ini, 0 as gaji_lalu, 0 as brg_lalu, 0 as up_lalu, 0 as lra_rek_4,0 as lra_rek_4_input, 0 as jkn from trdtransout a join trhtransout b on a.no_bukti=b.no_bukti and a.kd_skpd=b.kd_skpd
                where MONTH(b.tgl_bukti)='$bulan' and jns_spp in (6)
                union all
                select a.kd_skpd, 0 as gaji_ini, isnull(a.nilai,0) as brg_ini, 0 as up_ini, 0 as gaji_lalu, 0 as brg_lalu, 0 as up_lalu, 0 as lra_rek_4,0 as lra_rek_4_input, 0 as jkn from trdtransout a join trhtransout b on a.no_bukti=b.no_bukti and a.kd_skpd=b.kd_skpd
                where MONTH(b.tgl_bukti)='$bulan' and jns_spp in (5) and LEFT(a.kd_rek5,3) in ('514','515','518')
                union all
                select  a.kd_skpd, 0 as gaji_ini, isnull(a.rupiah*-1,0) as brg_ini, 0 as up_ini, 0 as gaji_lalu, 0 as brg_lalu, 0 as up_lalu, 0 as lra_rek_4,0 as lra_rek_4_input, 0 as jkn from trdkasin_pkd a join trhkasin_pkd b on a.no_sts=b.no_sts and a.kd_skpd=b.kd_skpd
                where MONTH(b.tgl_sts)='$bulan' and b.jns_cp in (2) and b.pot_khusus<>0
                union all
                select a.kd_skpd, 0 as gaji_ini, 0 as brg_ini, 0 as up_ini, 0 as gaji_lalu, 0 as brg_lalu, isnull(a.nilai,0) as up_lalu, 0 as lra_rek_4,0 as lra_rek_4_input, 0 as jkn from trdtransout a join trhtransout b on a.no_bukti=b.no_bukti and a.kd_skpd=b.kd_skpd
                where MONTH(b.tgl_bukti)<'$bulan' and jns_spp in (1,2,3)
                union all
                select a.kd_skpd, 0 as gaji_ini, 0 as brg_ini, 0 as up_ini, 0 as gaji_lalu, 0 as brg_lalu, isnull(a.nilai*-1,0) as up_lalu, 0 as lra_rek_4,0 as lra_rek_4_input, 0 as jkn from trdinlain a join TRHINLAIN b on a.no_bukti=b.no_bukti and a.kd_skpd=b.kd_skpd
                where MONTH(b.TGL_BUKTI)<='$bulan' and b.pengurang_belanja=1
                union all
                select a.kd_skpd, 0 as gaji_ini, 0 as brg_ini, 0 as up_ini, isnull(a.nilai,0) as gaji_lalu, 0 as brg_lalu, 0 as up_lalu, 0 as lra_rek_4,0 as lra_rek_4_input, 0 as jkn from trdtransout a join trhtransout b on a.no_bukti=b.no_bukti and a.kd_skpd=b.kd_skpd
                where MONTH(b.tgl_bukti)<'$bulan' and jns_spp in (4)
                union all
                select a.kd_skpd, 0 as gaji_ini, 0 as brg_ini, 0 as up_ini, isnull(a.rupiah*-1,0) as gaji_lalu, 0 as brg_lalu, 0 as up_lalu, 0 as lra_rek_4,0 as lra_rek_4_input, 0 as jkn from trdkasin_pkd a join trhkasin_pkd b on a.no_sts=b.no_sts and a.kd_skpd=b.kd_skpd
                where MONTH(b.tgl_sts)<'$bulan' and b.jns_cp in (1) and b.pot_khusus<>0
                union all
                select a.kd_skpd, 0 as gaji_ini, 0 as brg_ini, 0 as up_ini, 0 as gaji_lalu, isnull(a.nilai,0) as brg_lalu, 0 as up_lalu, 0 as lra_rek_4,0 as lra_rek_4_input, 0 as jkn from trdtransout a join trhtransout b on a.no_bukti=b.no_bukti and a.kd_skpd=b.kd_skpd
                where MONTH(b.tgl_bukti)<'$bulan' and jns_spp in (6)
                union all
                select a.kd_skpd, 0 as gaji_ini, 0 as brg_ini, 0 as up_ini, 0 as gaji_lalu, isnull(a.nilai,0) as brg_lalu, 0 as up_lalu, 0 as lra_rek_4,0 as lra_rek_4_input, 0 as jkn from trdtransout a join trhtransout b on a.no_bukti=b.no_bukti and a.kd_skpd=b.kd_skpd
                where MONTH(b.tgl_bukti)<'$bulan' and jns_spp in (5) and LEFT(a.kd_rek5,3) in ('514','515','518')
                union all
                select a.kd_skpd, 0 as gaji_ini, 0 as brg_ini, 0 as up_ini, 0 as gaji_lalu, isnull(a.rupiah*-1,0) as brg_lalu, 0 as up_lalu, 0 as lra_rek_4,0 as lra_rek_4_input, 0 as jkn from trdkasin_pkd a join trhkasin_pkd b on a.no_sts=b.no_sts and a.kd_skpd=b.kd_skpd
                where MONTH(b.tgl_sts)<'$bulan' and b.jns_cp in (2) and b.pot_khusus<>0
                union all
                select a.kd_skpd, 0 as gaji_ini, 0 as brg_ini, 0 as up_ini, 0 as gaji_lalu, 0 as brg_lalu, 0 as up_lalu, isnull(sum(b.debet)-sum(b.kredit),0) as lra_rek_4,0 as lra_rek_4_input, 0 as jkn from trhju_pkd a inner join trdju_pkd b on a.kd_skpd=b.kd_unit and a.no_voucher=b.no_voucher where YEAR(a.tgl_voucher)='$tahun' and MONTH(a.tgl_voucher)<='$bulan' and LEFT(b.kd_rek5,1) in ('5')  and a.tabel='0'
                group by a.kd_skpd
                union all
                select a.kd_skpd, 0 as gaji_ini, 0 as brg_ini, 0 as up_ini, 0 as gaji_lalu, 0 as brg_lalu, 0 as up_lalu, 0 as lra_rek_4, isnull(sum(b.debet)-sum(b.kredit),0) as lra_rek_4_input, 0 as jkn from trhju_pkd a inner join trdju_pkd b on a.kd_skpd=b.kd_unit and a.no_voucher=b.no_voucher where YEAR(a.tgl_voucher)='$tahun' and MONTH(a.tgl_voucher)<='$bulan' and LEFT(b.kd_rek5,1) in ('5')  and a.tabel='1'
                group by a.kd_skpd
                 union all 
                 select a.kd_skpd,0 as gaji_ini, 0 as brg_ini, 0 as up_ini, 0 as gaji_lalu, 0 as brg_lalu, 0 as up_lalu, 0 as lra_rek_4,0 as lra_rek_4_input,  isnull(sum(a.nilai),0) as jkn from trdtransout_pusk a join trhtransout_pusk b on a.no_bukti=b.no_bukti and a.kd_skpd=b.kd_skpd where MONTH(b.tgl_bukti)<='$bulan'
                 group by a.kd_skpd) a 
                group by kd_skpd
                ) z 
                left join
                ms_skpd q on left(z.kd_skpd,7)+'.00'=q.kd_skpd
                left join 
                (
                select LEFT(a.kd_skpd,7)+'.00' as skpd,sum(a.nilai) as nilai_sp2d from trdspp a left join trhsp2d b on b.kd_skpd=a.kd_skpd and a.no_spp=b.no_spp 
                where LEFT(a.kd_rek5,1) in ('5','1','6') and (b.sp2d_batal IS NULL or b.sp2d_batal ='' or b.sp2d_batal='0') and MONTH(b.tgl_sp2d)<='$bulan'
                group by LEFT(a.kd_skpd,7)
                )v on v.skpd=z.kd_skpd
                left join 
                (
                select LEFT(a.kd_skpd,7)+'.00' as skpd,sum(a.$ang) as nilai_ang from trdrka a where LEFT(a.kd_rek5,1)='5'
                group by LEFT(a.kd_skpd,7)
                )f on f.skpd=z.kd_skpd
                where right(q.kd_skpd,2)='00'
                group by left(z.kd_skpd,7),q.nm_skpd
                order by left(z.kd_skpd,7)
                ";
                
                $query = $this->db->query($sql1);                
                 //$query = $this->skpd_model->getAllc();
                 $ii = 0;        
                 $anggaran_t = 0;
                 $sp2d_t = 0;
                 $real_t = 0;
                foreach ($query->result() as $row)
                {
                    $skpd=rtrim($row->kode_skpd);
                    $nm=rtrim($row->nm_skpd);
                    $anggaranx=rtrim($row->ang_nilai);
                    $anggaran = number_format($anggaranx,2,',','.');
                    $sp2dx=rtrim($row->sp2d_nilai);
                    $sp2d = number_format($sp2dx,2,',','.');
                    $realx=rtrim($row->spj_nilai);
                    $real = number_format($realx,2,',','.');

                    $anggaran_t=$anggaran_t+$anggaranx;    
                    $sp2d_t=$sp2d_t+$sp2dx;
                    $real_t=$real_t+$realx;

                    if ($sp2dx==0){
                        $per1=0;
                    }else{
                    $per1   = ($sp2dx!=0)?($sp2dx / $anggaranx ) * 100:0;
                    }
                    $persen1 = number_format($per1,2,',','.');

                    if ($realx==0){
                        $per2=0;
                    }else{
                    $per2   = ($realx!=0)?($realx / $sp2dx ) * 100:0;
                    }
                    $persen2 = number_format($per2,2,',','.');

                    $ii++;

                      $cRet    .= " <tr>
                                         <td align=\"center\" style=\"vertical-align:middle; \" >$ii</td>                                
                                        <td align=\"center\" style=\"vertical-align:middle; \" >$skpd</td>
                                        <td align=\"left\" style=\"vertical-align:middle; \" >$nm</td>
                                        <td align=\"right\" style=\"vertical-align:middle; \" >$anggaran</td>
                                        <td align=\"right\" style=\"vertical-align:middle; \" >$sp2d</td>
                                        <td align=\"right\" style=\"vertical-align:middle; \" >$persen1</td>
                                        <td align=\"right\" style=\"vertical-align:middle; \" >$real</td>
                                        <td align=\"right\" style=\"vertical-align:middle; \" >$persen2</td>
                                    </tr> 
                                    ";
                      

    
                }

                if ($sp2d_t==0){
                    $per1_t=0;
                }else{
                    $per1_t    = ($sp2d_t!=0)?($sp2d_t / $anggaran_t ) * 100:0;
                }
                    $persen1_t = number_format($per1_t,2,',','.');

                if ($real_t==0){
                    $per2_t=0;
                }else{
                    $per2_t    = ($real_t!=0)?($real_t / $sp2d_t ) * 100:0;
                }
                    $persen2_t = number_format($per2_t,2,',','.');

                $cRet    .= " 
                    <tr>
                    <td colspan=\"3\" align=\"center\" style=\"vertical-align:middle; \" >TOTAL</td>                                
                    <td align=\"right\" style=\"vertical-align:middle; \" >".number_format($anggaran_t,2,',','.')."</td>
                    <td align=\"right\" style=\"vertical-align:middle; \" >".number_format($sp2d_t,2,',','.')."</td>
                    <td align=\"right\" style=\"vertical-align:middle; \" >$persen1_t</td>
                    <td align=\"right\" style=\"vertical-align:middle; \" >".number_format($real_t,2,',','.')."</td>
                    <td align=\"right\" style=\"vertical-align:middle; \" >$persen2_t</td>
                    </tr> 
                    ";

 
        $cRet .="</table>";
 
        $data['prev']= $cRet;    
        //$this->_mpdf('',$cRet,10,10,10,0);
        //$this->template->load('template','master/fungsi/list_preview',$data);
        switch($cetak) {
        case 0;
               echo ("<title>Lap Perbandingan Anggaran dan Realisasi</title>");
                echo($cRet);
  
 //           $this->template->load('template','anggaran/rka/perkadaII',$data);
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
    
        
}