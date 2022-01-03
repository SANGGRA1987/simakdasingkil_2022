<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
ob_start();
class Allprint extends CI_Controller {
    function __contruct()
    {   
        parent::__construct();
    }
function export(){      
    $data['page_title']= 'DOWNLOAD';
    $this->template->set('title', 'DOWNLOAD');         
    $this->template->load('template','anggaran/rekap',$data) ;                     
}
    function  tanggal_format_indonesia($tgl)
    { 
        $tanggal  =  substr($tgl,8,2);
        $bulan  = $this-> getBulan(substr($tgl,5,2));
        $tahun  =  substr($tgl,0,4);
        return  $tanggal.' '.$bulan.' '.$tahun;
 
    }
 
    function  getBulan($bln){
        switch  ($bln) {
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

    function _mpdf_down($judul='',$nm_giat='',$isi='',$lMargin='',$rMargin='',$font=10,$orientasi='',$hal='',$tab='',$jdlsave='',$tMargin='') {
                

        ini_set("memory_limit","-1");
        $this->load->library('mpdf');
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
        
        $judulx = $judul.'-'.$nm_giat.'.pdf';
        $this->mpdf = new mPDF('utf-8', array(215,330),$size,'',$lMargin,$rMargin,$tMargin); //folio
        
        $mpdf->cacheTables = true;
        $mpdf->packTableData=true;
        $mpdf->simpleTables=true;
        $this->mpdf->AddPage($orientasi,'',$hal1,'1','off');
        if (!empty($tab)) $this->mpdf->SetTitle($tab); 
        if ($hal != 'no'){
            $this->mpdf->SetFooter("Printed on Simakda || Halaman {PAGENO}  ");
        }
        if (!empty($judulx)) $this->mpdf->writeHTML('');   
        $this->mpdf->writeHTML($isi);         
        $this->mpdf->Output($judulx,'D');
    }
    
    function _mpdf($judul='',$isi='',$lMargin='',$rMargin='',$font=10,$orientasi='',$hal='',$tab='',$jdlsave='',$tMargin='') {
                
        ini_set("memory_limit","-1");
        $this->load->library('mpdf');
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
            ///$this->mpdf->SetFooter("Halaman {PAGENO}  ");
           $this->mpdf->SetFooter("Printed on Simakda || Halaman {PAGENO}  ");
        }
        if (!empty($judul)) $this->mpdf->writeHTML($judul);
        //$this->mpdf->simpleTables= true;     
        $this->mpdf->writeHTML($isi);         
        //$this->mpdf->Output('');
        $this->mpdf->Output('');
    }
    
/*printall_rka221_murni*/
function printall_rka221_murni(){
       $id = $this->uri->segment(3);
       $id2 = substr($id,0,7);
       //$giat = $this->uri->segment(4);
       $cetak = $this->uri->segment(5);
       $chkpa = $this->uri->segment(6);
       $cell = $this->uri->segment(7); 
       
        $tgl2= $_REQUEST['tgl_ttd'];
        $ttd1x= $_REQUEST['ttd1'];
        $ttd2x= $_REQUEST['ttd2'];
        $ttd1=  str_replace('x',' ',$ttd1x);
        $ttd2=  str_replace('x',' ',$ttd2x);
        $tgl_ttd = $this->tukd_model->tanggal_format_indonesia($tgl2);

        $cRet   ="";
        $ini    ="SELECT trskpd.kd_kegiatan as kd_kegiatan ,m_giat.nm_kegiatan from trskpd
                    join m_giat on m_giat.kd_kegiatan=trskpd.kd_kegiatan 
                    WHERE left(trskpd.kd_skpd,7)='$id2' and left(trskpd.jns_kegiatan,1)='5' and
                    trskpd.total !=0 ORDER BY trskpd.kd_kegiatan
                    ";
        $itu    =$this->db->query($ini);

        foreach($itu->result() as $anu){
            $giat=$anu->kd_kegiatan;       
        
        $sql_trhrka="SELECT top 1 status_rancang,statu, tgl_dpa_rancang FROM trhrka where left(kd_skpd,7)=left('$id',7)";
         $sql_trhrka=$this->db->query($sql_trhrka);
         foreach ($sql_trhrka->result() as $rowsc)
        {                  
            $tgl_rancang= $rowsc->tgl_dpa_rancang;
            $status= $rowsc->status_rancang;

        }
            

            $judulrka = 'RENCANA KERJA DAN ANGGARAN';
            $n_trdrka  =   '';
            $kdrka ='RKA';


        if (strlen($id)>7){
            $sqldns="SELECT a.kd_urusan as kd_u,b.nm_urusan as nm_u,a.kd_skpd as kd_sk,a.nm_skpd as nm_sk FROM ms_skpd a INNER JOIN ms_urusan b ON a.kd_urusan=b.kd_urusan WHERE kd_skpd='$id'";
            $a = 'left(';
            $skpd = 'kd_skpd';
            $b = ',10)';             
        }else{
            $sqldns="SELECT a.kd_urusan as kd_u,b.nm_urusan as nm_u,a.kd_skpd as kd_sk,a.nm_skpd as nm_sk FROM ms_skpd a INNER JOIN ms_urusan b ON a.kd_urusan=b.kd_urusan WHERE left(kd_skpd,7)='$id'";
            $a = 'left(';
            $skpd = 'kd_skpd';
            $b = ',7)'; 
        }

         $sqlskpd=$this->db->query($sqldns);
         foreach ($sqlskpd->result() as $rowdns)
        {
           
            $kd_urusan=$rowdns->kd_u;                    
            $nm_urusan= $rowdns->nm_u;
            $kd_skpd  = $rowdns->kd_sk;
            $nm_skpd  = $rowdns->nm_sk;
        }
            
            $sqlorg="SELECT kd_org,nm_org FROM ms_organisasi WHERE kd_org=left('$id',7)";
                 $sqlorg1=$this->db->query($sqlorg);
                 foreach ($sqlorg1->result() as $rowdns)
                {
                   
                    $kd_org=$rowdns->kd_org;                    
                    $nm_org= $rowdns->nm_org;
                }


        $sqlurusan1="SELECT kd_urusan1,nm_urusan1 FROM ms_urusan1 WHERE kd_urusan1=left('$kd_urusan',1)";
                 $sqlskpd=$this->db->query($sqlurusan1);
                 foreach ($sqlskpd->result() as $rowdns)
                {
                   
                    $kd_urusan1=$rowdns->kd_urusan1;                    
                    $nm_urusan1= $rowdns->nm_urusan1;
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

      
      if($chkpa==0){
        $sqlttd1="SELECT TOP 1 nama as nm,nip as nip,jabatan as jab FROM ms_ttd where nip='$ttd1' and kode='agr'";
                 }else{
        $sqlttd1="SELECT TOP 1 nama as nm,nip as nip,jabatan as jab FROM ms_ttd where nip='$ttd2'";
                }
                 $sqlttd=$this->db->query($sqlttd1);
                 foreach ($sqlttd->result() as $rowttd)
                {
                    $nipx=$rowttd->nip;                    
                    $namax= $rowttd->nm;
                    $jabatanx  = $rowttd->jab;
                }
                 
         $sqlorg="SELECT left(a.kd_skpd,1)kd_urusan1,o.nm_urusan1,f.kd_urusan,f.nm_urusan,f.kd_urusan,a.kd_skpd,e.nm_skpd,a.kd_program,z.nm_program,a.kd_kegiatan,c.nm_kegiatan,SUM(d.nilai) AS nilai,a.tu_capai,a.tu_mas,a.tu_kel,a.tu_has,
                a.tk_capai,a.tk_mas,a.tk_kel,a.tk_has,a.lokasi,rtrim(d.sumber) [sumber] ,a.sasaran_giat,a.ang_lalu,a.waktu_giat FROM trskpd a 
                INNER JOIN m_giat c ON a.kd_kegiatan1=c.KD_KEGIATAN
                INNER JOIN trdrka d ON a.kd_kegiatan=d.kd_kegiatan
                INNER JOIN ms_skpd e ON a.kd_skpd=e.kd_skpd
                INNER JOIN m_prog z ON a.kd_program=z.kd_program
                                INNER JOIN ms_urusan1 o ON left(a.kd_skpd,1)=o.kd_urusan1
                INNER JOIN ms_urusan f ON a.kd_urusan=f.kd_urusan where a.kd_kegiatan='$giat'
                GROUP BY f.kd_urusan,
                f.nm_urusan,
                a.kd_skpd,
                e.nm_skpd,
                a.kd_program,
                z.nm_program,
                a.kd_kegiatan,
                c.nm_kegiatan,
                a.tu_capai,
                a.tu_mas,
                a.tu_kel,
                a.tu_has,
                a.tk_capai,
                a.tk_mas,
                a.tk_kel,
                a.tk_has,
                a.lokasi,
                d.sumber,
                a.sasaran_giat,
                a.ang_lalu,a.waktu_giat,o.nm_urusan1";
                 $sqlorg1=$this->db->query($sqlorg);
                 foreach ($sqlorg1->result() as $roworg)
                {
                    $kd_urusan=$roworg->kd_urusan;                    
                    $nm_urusan= $roworg->nm_urusan;
                    $kd_urusan1=$roworg->kd_urusan1;                    
                    $nm_urusan1= $roworg->nm_urusan1;
                    $kd_skpd  = $roworg->kd_skpd;
                    $nm_skpd  = $roworg->nm_skpd;
                    $kd_prog  = $roworg->kd_program;
                    $nm_prog  = $roworg->nm_program;
                    $kd_giat  = $roworg->kd_kegiatan;
                    $nm_giat  = $roworg->nm_kegiatan;
                    $lokasi  = $roworg->lokasi;
                    $tu_capai  = $roworg->tu_capai;
                    $tu_mas  = $roworg->tu_mas;
                    $tu_kel  = $roworg->tu_kel;
                    $tu_has  = $roworg->tu_has;
                    $tk_capai  = $roworg->tk_capai;
                    $tk_mas  = $roworg->tk_mas;
                    $tk_kel  = $roworg->tk_kel;
                    $tk_has  = $roworg->tk_has;
                    $sas_giat = $roworg->sasaran_giat;
                    $ang_lalu = $roworg->ang_lalu;
                    $wak_giat = $roworg->waktu_giat;
                    $sumber = $roworg->sumber;

                    
                }
        $kd_urusan= empty($roworg->kd_urusan) || ($roworg->kd_urusan) == '' ? '' : ($roworg->kd_urusan);
        $nm_urusan= empty($roworg->nm_urusan) || ($roworg->nm_urusan) == '' ? '' : ($roworg->nm_urusan);
        $kd_urusan1= empty($roworg->kd_urusan1) || ($roworg->kd_urusan1) == '' ? '' : ($roworg->kd_urusan1);
        $nm_urusan1= empty($roworg->nm_urusan1) || ($roworg->nm_urusan1) == '' ? '' : ($roworg->nm_urusan1);
        $nm_skpd= empty($roworg->nm_skpd) || ($roworg->nm_skpd) == '' ? '' : ($roworg->nm_skpd);
        $kd_prog= empty($roworg->kd_program) || ($roworg->kd_program) == '' ? '' : ($roworg->kd_program);
        $nm_prog= empty($roworg->nm_program) || ($roworg->nm_program) == '' ? '' : ($roworg->nm_program);
        $kd_giat= empty($roworg->kd_kegiatan) || ($roworg->kd_kegiatan) == '' ? '' : ($roworg->kd_kegiatan);
        $nm_giat= empty($roworg->nm_kegiatan) || ($roworg->nm_kegiatan) == '' ? '' : ($roworg->nm_kegiatan);
        $lokasi= empty($roworg->lokasi) || ($roworg->lokasi) == '' ? '' : ($roworg->lokasi);
        $tu_capai= empty($roworg->tu_capai) || ($roworg->tu_capai) == '' ? '' : ($roworg->tu_capai);
        $tu_mas= empty($roworg->tu_mas) || ($roworg->tu_mas) == '' ? '' : ($roworg->tu_mas);
        $tu_kel= empty($roworg->tu_kel) || ($roworg->tu_kel) == '' ? '' : ($roworg->tu_kel);
        $tu_has= empty($roworg->tu_has) || ($roworg->tu_has) == '' ? '' : ($roworg->tu_has);
        $tk_capai= empty($roworg->tk_capai) || ($roworg->tk_capai) == '' ? '' : ($roworg->tk_capai);
        $tk_mas= empty($roworg->tk_mas) || ($roworg->tk_mas) == '' ? '' : ($roworg->tk_mas);
        $tk_kel= empty($roworg->tk_kel) || ($roworg->tk_kel) == '' ? '' : ($roworg->tk_kel);
        $tk_has= empty($roworg->tk_has) || ($roworg->tk_has) == '' ? '' : ($roworg->tk_has);
        $sas_giat= empty($roworg->sasaran_giat) || ($roworg->sasaran_giat) == '' ? '' : ($roworg->sasaran_giat);
        $ang_lalu= empty($roworg->ang_lalu) || ($roworg->ang_lalu) == '' || ($roworg->ang_lalu) == 'Null' ? 0 : ($roworg->ang_lalu);
        $wak_giat= empty($roworg->waktu_giat) || ($roworg->waktu_giat) == '' || ($roworg->waktu_giat) == 'Null' ? '' : ($roworg->waktu_giat);
        $sumber= empty($roworg->sumber) || ($roworg->sumber) == '' || ($roworg->sumber) == 'Null' ? '' : ($roworg->sumber);
        $org = substr($kd_skpd,0,7);
        switch($sumber){
            case 'DAU';
                $sumber = 'Dana Alokasi Umum (DAU)';
            break;
            case 'PAD';
                $sumber = 'Pendapatan Asli Daerah (PAD)';
            break;            
            case 'DAK';
                $sumber = 'Dana Alokasi Khusus (DAK)';
            break;           
        }
        
  
       $sqltp="SELECT SUM(nilai) AS totb FROM trdrka WHERE kd_kegiatan='$giat' AND left(kd_skpd,7)=left('$id',7)";
                 $sqlb=$this->db->query($sqltp);
                 foreach ($sqlb->result() as $rowb)
                {
                   $totp  =number_format($rowb->totb,"2",",",".");
                   $totp1 =number_format($rowb->totb*1.1,"2",",",".");
                }
                $ang_lalu =number_format($roworg->ang_lalu,"2",",",".");

        $sqlsum="SELECT sumber,sumber_2,
                        case
                        when sumber is null and sumber_2 is null then ''
                        when sumber ='' and sumber_2 is not null then sumber_2
                        when sumber is null and sumber_2 is not null then sumber_2
                        when sumber=sumber_2 then sumber
                        when sumber_2 is null and sumber is not null then sumber
                        when sumber is not null and sumber_2 is not null then 
                        rtrim(sumber)+', '+rtrim(sumber_2) end as sumber_dana 
                        from(
                        select top 1 kd_kegiatan,sumber,
                        (select top 1 sumber from trdrka where kd_kegiatan ='$giat' and len(sumber) > 2
                        group by sumber
                        order by sumber desc) as sumber_2
                        from trdrka where kd_kegiatan ='$giat'
                        group by kd_kegiatan,sumber
                        order by sumber asc
                        )x
                        order by sumber";

                 $sqlsum=$this->db->query($sqlsum);
                 foreach ($sqlsum->result() as $rowbx)
                {
                    //$sumberxxx=$rowbx->sumber_dana;
                    $sumberxxx= empty($rowbx->sumber_dana) || ($rowbx->sumber_dana) == '' || ($rowbx->sumber_dana) == NULL ? '' : ($rowbx->sumber_dana);
                    //$sumberxxx = $rowbx->sumber_dana;
                }
                
        $k2 = substr($id,0,7);
        $k3 = substr($kd_prog,-2,2); 
        $k4 = substr($kd_giat,19,3);
       $cRet .="<table style=\"border-collapse:collapse;font-weight:bold;font-size:5px;border-left:solid 1px black;border-top:solid 1px black;border-right:solid 1px black; font-size:12;\" width=\"100%\" border=\"0\">
                    <tr>
                        <td width=\"20%\"><strong>&nbsp;Urusan Pemerintahan</strong></td>
                        <td width=\"3%\" align=\"center\">:</td>
                        <td colspan=\"7\" width=\"77%\"><strong>$kd_urusan - $nm_urusan</strong></td>
                    </tr>
                    <tr>
                        <td width=\"20%\"><strong>&nbsp;Organisasi</strong></td>
                        <td width=\"3%\" align=\"center\">:</td>
                        <td colspan=\"7\" width=\"77%\"> <strong>$org - $nm_org</strong></td>
                    </tr>
                    <tr>
                        <td width=\"20%\" align=\"left\">&nbsp;Program</td>
                        <td width=\"3%\" align=\"center\">:</td>
                        <td colspan=\"7\" width=\"77%\" align=\"left\">$kd_prog   - $nm_prog</td>
                    </tr>
                    <tr><td width=\"20%\" align=\"left\">&nbsp;Kegiatan</td>
                        <td width=\"3%\" align=\"center\">:</td>
                        <td colspan=\"7\" width=\"77%\" align=\"left\">$kd_giat   - $nm_giat</td>
                    </tr>
                    <tr><td width=\"20%\" align=\"left\">&nbsp;</td>
                        <td width=\"3%\" align=\"center\"></td>
                        <td colspan=\"7\" width=\"77%\" align=\"left\"></td>
                    </tr>
                    <tr><td width=\"20%\" align=\"left\">&nbsp;Waktu Pelaksanaan</td>
                        <td width=\"3%\" align=\"center\">:</td>
                        <td colspan=\"6\" width=\"77%\" align=\"left\">$wak_giat</td>
                    </tr>
                    <tr><td width=\"20%\" align=\"left\">&nbsp;Lokasi Kegiatan</td>
                        <td width=\"3%\" align=\"center\">:</td>
                        <td colspan=\"7\" width=\"77%\" align=\"left\">$lokasi</td>
                    </tr>   


                    <tr>
                        <td style=\"border-left:solid 1px black;\"  width=\"20%\" align=\"left\">&nbsp;Jumlah Tahun<br>&nbsp;n-1</td>
                        <td width=\"3%\" align=\"center\">:</td>
                        <td style=\"border-right:solid 1px black;\" colspan=\"7\" width=\"77%\" align=\"left\">Rp $ang_lalu</td>
                    </tr>
                    <tr>
                        <td style=\"border-left:solid 1px black;\"  width=\"20%\" align=\"left\">&nbsp;Jumlah Tahun<br>&nbsp;n 1</td>
                        <td width=\"3%\" align=\"center\">:</td>
                        <td style=\"border-right:solid 1px black;\" colspan=\"7\" width=\"77%\" align=\"left\">Rp $totp</td>
                    </tr>
                    <tr>
                        <td style=\"border-left:solid 1px black;\"  width=\"20%\" align=\"left\">&nbsp;Jumlah Tahun<br>&nbsp;n+1</td>
                        <td width=\"3%\" align=\"center\">:</td>
                        <td style=\"border-right:solid 1px black;\" colspan=\"7\" width=\"77%\" align=\"left\">Rp</td>
                    </tr>
                    <tr><td style=\"border-left:solid 1px black;\"  width=\"20%\" align=\"left\">&nbsp;</td>
                        <td width=\"3%\" align=\"center\"></td>
                        <td style=\"border-right:solid 1px black;\" colspan=\"7\" width=\"77%\" align=\"left\"></td>
                    </tr>
                    <tr><td style=\"border-left:solid 1px black;\"  width=\"20%\" align=\"left\">&nbsp;Waktu Pelaksanaan</td>
                        <td width=\"3%\" align=\"center\">:</td>
                        <td style=\"border-right:solid 1px black;\"  colspan=\"7\" width=\"77%\" align=\"left\">$wak_giat</td>                      
                    </tr>
                    <tr><td style=\"border-left:solid 1px black;\"  width=\"20%\" align=\"left\">&nbsp;Sumber Dana</td>
                        <td width=\"3%\" align=\"center\">:</td>
                        <td style=\"border-right:solid 1px black;\"  colspan=\"7\" width=\"77%\" align=\"left\">$sumberxxx</td>
                    </tr>

                </table>";         
 
        $cRet .= "<table style=\"border-collapse:collapse;font-weight:bold;font-size:5px;border-left:solid 1px black;border-top:solid 1px black;border-right:solid 1px black; font-size:12;\" width=\"100%\" border=\"1\">
                    <tr>
                        <td width=\"100%\" colspan=\"9\"  align=\"center\">Indikator & Tolak Ukur Kinerja Belanja langsung</td>
                    </tr>";
        $cRet .="<tr>
                 <td colspan=\"2\" align=\"center\">Indikator </td>
                 <td colspan=\"3\" align=\"center\">Tolak Ukur Kerja </td>
                 <td colspan=\"4\" align=\"center\">Target Kinerja </td>
                </tr>";       
/*        $cRet .=" <tr align=\"center\">
                    <td colspan=\"2\">Capaian Program </td>
                    <td colspan=\"3\">$tu_capai</td>
                    <td colspan=\"4\">$tk_capai</td>
                 </tr>";*/
        $cRet .=" <tr align=\"center\">
                    <td colspan=\"2\">Dampak Sasaran</td>
                    <td colspan=\"3\">$tu_capai</td>
                    <td colspan=\"4\">$tk_capai</td>
                 </tr>";
        $cRet .=" <tr align=\"center\">
                    <td colspan=\"2\">Hasil Program</td>
                    <td colspan=\"3\">$tu_has</td>
                    <td colspan=\"4\">$tk_has</td>
                  </tr>";
        $cRet .=" <tr align=\"center\">
                    <td colspan=\"2\">Keluaran Kegiatan</td>
                    <td colspan=\"3\">$tu_kel</td>
                    <td colspan=\"4\">$tk_kel</td>
                  </tr>";
        $cRet .= "<tr>
                    <td colspan=\"9\"  width=\"100%\" align=\"left\">Kelompok Sasaran Kegiatan : $sas_giat</td>
                </tr>";
        
        $cRet .= "<tr>
                        <td colspan=\"9\" align=\"center\">RINCIAN $judulrka BELANJA LANGSUNG <br>MENURUT PROGRAM DAN PER KEGIATAN SATUAN KERJA PERANGKAT DAERAH</td>
                  </tr>";
                    
        $cRet .="</table>";


        $cRet .= "<table style=\"border-collapse:collapse;font-size:12;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"$cell\">
                     <thead >                       
                        <tr><td rowspan=\"2\" width=\"10%\" align=\"center\"><b>KODE<br>REKENING</b></td>                            
                            <td rowspan=\"2\" width=\"40%\" align=\"center\"><b>Uraian</b></td>
                            <td colspan=\"4\" width=\"30%\" align=\"center\"><b>Rincian Perhitungan</b></td>
                            <td rowspan=\"2\" colspan=\"3\" width=\"20%\" align=\"center\"><b>Jumlah (Rp.)</b></td></tr>
                        <tr>
                            <td style=\"font-weight:bold;\" width=\"8%\" align=\"center\">Volume</td>
                            <td style=\"font-weight:bold;\" width=\"8%\" align=\"center\">Satuan</td>
                            <td colspan=\"2\" style=\"font-weight:bold;\" width=\"14%\" align=\"center\">Tarif / Harga</td>
                        </tr>                            
                        <tr><td style=\"vertical-align:top;border-top: none;border-bottom: solid 2px black;font-weight:bold;\" width=\"10%\" align=\"center\">1</td>                            
                            <td style=\"vertical-align:top;border-top: none;border-bottom: solid 2px black;font-weight:bold;\" width=\"40%\" align=\"center\">2</td>
                            <td style=\"vertical-align:top;border-top: none;border-bottom: solid 2px black;font-weight:bold;\" width=\"8%\" align=\"center\">3</td>
                            <td style=\"vertical-align:top;border-top: none;border-bottom: solid 2px black;font-weight:bold;\" width=\"8%\" align=\"center\">4</td>
                            <td colspan=\"2\" style=\"vertical-align:top;border-top: none;border-bottom: solid 2px black;font-weight:bold;\" width=\"14%\" align=\"center\">5</td>
                            <td colspan=\"3\" style=\"vertical-align:top;border-top: none;border-bottom: solid 2px black;font-weight:bold;\" width=\"20%\" align=\"center\">6 = (3 X 5)</td>
                        </tr>                     
                    </thead>
                     
                    <tfoot>
                        <tr>
                            <td style=\"border-top: solid 1px black; border-bottom: none;border-right: none;border-left: none;\" colspan=\"9\"></hr></td>
                         </tr>
                     </tfoot>   
                        ";

                 $sql1="SELECT * FROM(SELECT 0 header,0 no_po, LEFT(a.kd_rek5,1)AS rek1,LEFT(a.kd_rek5,1)AS rek,b.nm_rek1 AS nama ,0 AS volume,' 'AS satuan,
                        0 AS harga,SUM(a.nilai) AS nilai,0 AS volume2,' 'AS satuan2, 0 AS harga2,isnull(SUM(a.nilai_sempurna),0) AS nilai2,'1' AS id 
                        FROM trdrka a INNER JOIN ms_rek1 b ON LEFT(a.kd_rek5,1)=b.kd_rek1 WHERE a.nilai != 0 and a.kd_kegiatan='$giat' AND left(a.kd_skpd,7)=left('$id',7) 
                        GROUP BY LEFT(a.kd_rek5,1),nm_rek1 
                         UNION ALL 
                         SELECT 0 header, 0 no_po,LEFT(a.kd_rek5,2) AS rek1,LEFT(a.kd_rek5,2) AS rek,b.nm_rek2 AS nama,0 AS volume,' 'AS satuan,
                        0 AS harga,SUM(a.nilai) AS nilai,0 AS volume2,' 'AS satuan2, 0 AS harga2,isnull(SUM(a.nilai_sempurna),0) AS nilai2,'2' AS id 
                        FROM trdrka a INNER JOIN ms_rek2 b ON LEFT(a.kd_rek5,2)=b.kd_rek2 WHERE /*a.nilai != 0 and*/ a.kd_kegiatan='$giat'
                        and left(a.kd_skpd,7)=left('$id',7)  GROUP BY LEFT(a.kd_rek5,2),nm_rek2 
                         UNION ALL  
                         SELECT 0 header, 0 no_po, LEFT(a.kd_rek5,3) AS rek1,LEFT(a.kd_rek5,3) AS rek,b.nm_rek3 AS nama,0 AS volume,' 'AS satuan,
                        0 AS harga,SUM(a.nilai) AS nilai,0 AS volume2,' 'AS satuan2, 0 AS harga2,isnull(SUM(a.nilai_sempurna),0) AS nilai2,'3' AS id 
                        FROM trdrka a INNER JOIN ms_rek3 b ON LEFT(a.kd_rek5,3)=b.kd_rek3 WHERE /*a.nilai != 0 and*/ a.kd_kegiatan='$giat'
                        AND left(a.kd_skpd,7)=left('$id',7)  GROUP BY LEFT(a.kd_rek5,3),nm_rek3 
                         UNION ALL 
                         SELECT 0 header, 0 no_po, LEFT(a.kd_rek5,5) AS rek1,LEFT(a.kd_rek5,5) AS rek,b.nm_rek4 AS nama,0 AS volume,' 'AS satuan,
                        0 AS harga,SUM(a.nilai) AS nilai,0 AS volume2,' 'AS satuan2, 0 AS harga2,isnull(SUM(a.nilai_sempurna),0) AS nilai2,'4' AS id 
                        FROM trdrka a INNER JOIN ms_rek4 b ON LEFT(a.kd_rek5,5)=b.kd_rek4 WHERE /*a.nilai != 0 and*/ a.kd_kegiatan='$giat'
                        AND left(a.kd_skpd,7)=left('$id',7)  GROUP BY LEFT(a.kd_rek5,5),nm_rek4 
                         UNION ALL 
                         SELECT 0 header, 0 no_po, a.kd_rek5 AS rek1,RTRIM(a.kd_rek5) AS rek,b.nm_rek5 AS nama,0 AS volume,' 'AS satuan,
                        0 AS harga,SUM(a.nilai) AS nilai,0 AS volume2,' 'AS satuan2, 0 AS harga2,isnull(SUM(a.nilai_sempurna),0) AS nilai2,'5' AS id 
                        FROM trdrka a INNER JOIN ms_rek5 b ON a.kd_rek5=b.kd_rek5 WHERE /*a.nilai != 0 and*/ a.kd_kegiatan='$giat'
                        AND left(a.kd_skpd,7)=left('$id',7)  GROUP BY a.kd_rek5,b.nm_rek5
                         UNION ALL  
                         SELECT * FROM (SELECT  b.header,b.no_po,RIGHT(a.no_trdrka,7) AS rek1,' 'AS rek,b.uraian AS nama,0 AS volume,' ' AS satuan,
                        0 AS harga,SUM(a.total) AS nilai,0 AS volume2,' ' AS satuan2, 0 AS harga2,isnull(SUM(a.total_sempurna),0) AS nilai2,'6' AS id 
                        FROM trdpo a
                        LEFT JOIN trdpo b ON b.kode=a.kode AND b.header ='1' AND a.no_trdrka=b.no_trdrka 
                        WHERE LEFT(a.no_trdrka,7)=left('$id',7) AND SUBSTRING(a.no_trdrka,12,22)='$giat'
                        GROUP BY  RIGHT(a.no_trdrka,7),b.header,b.no_po,b.uraian)z WHERE header='1' and nilai <> 0
                        UNION ALL 
                        SELECT a. header,a.no_po,RIGHT(a.no_trdrka,7) AS rek1,' 'AS rek,a.uraian AS nama,a.volume1 AS volume,a.satuan1 AS satuan,
                        a.harga1 AS harga,a.total AS nilai,a.volume_sempurna1 AS volume2,a.satuan_sempurna1 AS satuan2, a.harga_sempurna1 AS harga2,
                        a.total_sempurna AS nilai2,'6' AS id FROM trdpo a  WHERE LEFT(a.no_trdrka,7)=left('$id',7) AND SUBSTRING(no_trdrka,12,22)='$giat' AND (header='0' or header is null) /*and a.total != 0*/
                        ) a ORDER BY a.rek1,a.id,a.no_po";
                $totbl = 0;
                $query = $this->db->query($sql1);

                foreach ($query->result() as $row)
                {
                    $rek=$row->rek;
                    $reke=$this->dotrek($rek);
                    $uraian=$row->nama;
                    $nopo = $row->no_po;
                //    $volum=$row->volume;
                    $sat=$row->satuan;
                    $hrg= empty($row->harga) || $row->harga == 0 ? '' :number_format($row->harga,2,',','.');
                    $volum= empty($row->volume) || $row->volume == 0 ? '' :$row->volume;

                    //$hrg=number_format($row->harga,"2",".",",");
                    $nila= empty($row->nilai) || $row->nilai == 0 ? '' :number_format($row->nilai,2,',','.');
                    $nilaibl = empty($row->nilai)  ? 0 : $row->nilai;
                    
                    if(strlen($row->rek1) <= '5' ){
                        $bold = 'font-weight:bold;';
                        $lbawah = 'border-bottom: solid 1px black;';
                        $latas = 'border-top: solid 1px black;';
                    }else{
                        $bold ='';
                        $lbawah = 'border-bottom: none;';
                        $latas = 'border-top: none;';
                    }

                    if(strlen($row->rek1) == '1' ){
                        $totbl = $totbl + $nilaibl;
                    }            
                    
                     $cRet    .= " <tr><td style=\"vertical-align:top;$bold $lbawah $latas \" width=\"10%\" align=\"left\">$reke</td>                                     
                                     <td style=\"vertical-align:top;$bold $lbawah $latas  \" width=\"40%\">&nbsp;$uraian</td>
                                     <td style=\"vertical-align:top;$bold $lbawah $latas \" width=\"8%\" align=\"right\">$volum</td>
                                     <td style=\"vertical-align:top;$bold $lbawah $latas \" width=\"8%\" align=\"center\">$sat</td>
                                     <td colspan=\"2\" style=\"vertical-align:top;$bold $lbawah $latas \" width=\"14%\" align=\"right\">$hrg</td>
                                     <td colspan=\"3\" style=\"vertical-align:top;$bold $lbawah $latas \" width=\"20%\" align=\"right\">$nila</td></tr>
                                     ";
                             
                }

                   $totbl=number_format($totbl,"2",",",".");
                   
                    $cRet    .=" <tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"40%\"><strong>JUMLAH BELANJA</strong></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"9%\">&nbsp;</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"9%\">&nbsp;</td>
                                     <td colspan=\"2\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"17%\" align=\"right\">&nbsp;</td>
                                     <td colspan=\"3\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><strong>$totbl</strong></td></tr>";

                             $cRet .="
                                        <tr>
                                        <td colspan=\"9\">
                                            <table border=\"0\" width=\"100%\" >
                                                <tr>
                                                    <td width=\"50%\" colspan=\"2\">&emsp;
                                                    <td width=\"10%\" >
                                                </tr>
                                                <tr>
                                                    <td width=\"10%\" align=\"left\">&nbsp;<br>&nbsp;
                                                        <br>&nbsp;
                                                        &nbsp;<br>
                                                        &nbsp;<br>
                                                        &nbsp;<br>
                                                        &nbsp;  
                                                    </td>
                                                    <td width=\"40%\" align=\"center\" valign=\"top\">&nbsp;
                                                    <br>&nbsp;
                                                    <p>&nbsp;</p>
                                                    <p>&nbsp;</p>
                                                    <br><b><ins>&nbsp;</ins></b>
                                                    <br>&nbsp;
                                                    <br>&nbsp;
                                                    </td>
                                                    <td width=\"10%\" align=\"left\" valign=\"top\">&nbsp;<br>&nbsp;
                                                        <br>&nbsp;
                                                        &nbsp;<br>
                                                        &nbsp;<br>
                                                        &nbsp;<br>
                                                        &nbsp;  
                                                    </td>
                                                    <td width=\"40%\" align=\"center\">$daerah, $tgl_ttd 
                                                    <br>Mengesahkan,
                                                    <br>$jabatanx
                                                    <p>&nbsp;</p>
                                                    <p>&nbsp;</p>
                                                    <p>&nbsp;</p>
                                                    <p>&nbsp;</p>
                                                    <br><b><u>$namax</u></b>
                                                    <br>$nipx
                                                   </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                            
                                    ";

   
        $qtriw = " SELECT distinct isnull( a.triw1,0) AS triw1,isnull( a.triw2,0) AS triw2,isnull( a.triw3,0) 
                                AS triw3,isnull( a.triw4,0) AS triw4  FROM trskpd a join trdrka b on a.kd_kegiatan=b.kd_kegiatan
                                WHERE a.kd_kegiatan='$giat' AND a.kd_skpd='$id'";
        $query = $this->db->query($qtriw);
        if ($query->num_rows() > 0){
            foreach ($query->result() as $triw){
                            $triw1=  empty($triw->triw1) ? 0 : $triw->triw1;
                            $triw2= empty($triw->triw2) ? 0 :$triw->triw2;
                            $triw3= empty($triw->triw3)  ? 0 :$triw->triw3;
                            $triw4= empty($triw->triw4) ? 0 :$triw->triw4;
                            $total = $triw1 + $triw2 + $triw3 + $triw4;
            }
        }else{
            $triw1=  0;
            $triw2= 0;
            $triw3= 0;
            $triw4= 0;
            $total = $triw1 + $triw2 + $triw3 + $triw4;                            
        }

        $triw1 = number_format($triw1,2,',','.');
        $triw2= number_format($triw2,2,',','.');
        $triw3= number_format($triw3,2,',','.');
        $triw4= number_format($triw4,2,',','.');
        $total = number_format($total,2,',','.');
        
        $tapdy = "";
        $tapdx ="
        
        
                     <tr>
                        <td style=\"border-right: solid 1px white;border-left: solid 1px black;border-top: solid 1px black;border-bottom: solid 1px black;\" align=\"left\">Keterangan</td>
                        <td style=\"border-right: solid 1px black;border-left: solid 1px black;border-top: solid 1px black;border-bottom: solid 1px black;\" colspan=\"8\" align=\"left\">:</td>
                     </tr>
                     <tr>
                        <td style=\"border-right: solid 1px white;border-left: solid 1px black;border-top: solid 1px black;border-bottom: solid 1px black;\" align=\"left\">Tanggal Pembahasan</td>
                        <td style=\"border-right: solid 1px black;border-left: solid 1px black;border-top: solid 1px black;border-bottom: solid 1px black;\" colspan=\"8\" align=\"left\">:</td>
                     </tr>
                     <tr>
                        <td style=\"border-right: solid 1px white;border-left: solid 1px black;border-top: solid 1px black;border-bottom: solid 1px black;\" align=\"left\">Catatan Hasil<br>pembahasan</td>
                        <td style=\"border-right: solid 1px black;border-left: solid 1px black;border-top: solid 1px black;border-bottom: solid 1px black;\" colspan=\"8\" align=\"left\">:</td>
                     </tr>
                     <tr>
                        <td style=\"border-right: solid 1px white;border-left: solid 1px black;border-top: solid 1px black;border-bottom: solid 1px black;\" align=\"left\">1.</td>
                        <td style=\"border-right: solid 1px black;border-left: solid 1px black;border-top: solid 1px black;border-bottom: solid 1px black;\" colspan=\"8\" align=\"left\">&nbsp;</td>
                     </tr>
                     <tr>
                        <td style=\"border-right: solid 1px white;border-left: solid 1px black;border-top: solid 1px black;border-bottom: solid 1px black;\" align=\"left\">2.</td>
                        <td style=\"border-right: solid 1px black;border-left: solid 1px black;border-top: solid 1px black;border-bottom: solid 1px black;\" colspan=\"8\" align=\"left\">&nbsp;</td>
                     </tr>
                     <tr>
                        <td style=\"border-right: solid 1px white;border-left: solid 1px black;border-top: solid 1px black;border-bottom: solid 1px black;\" align=\"left\">&nbsp;</td>
                        <td style=\"border-right: solid 1px black;border-left: solid 1px black;border-top: solid 1px black;border-bottom: solid 1px black;\" colspan=\"8\" align=\"left\">&nbsp;</td>
                     </tr>
                     <tr>
                        <td style=\"border-right: solid 1px white;border-left: solid 1px black;border-top: solid 1px black;border-bottom: solid 1px black;\" colspan=\"9\" align=\"center\">Tim Anggaran Pemerintah Daerah:</td>
                     </tr>
                     <tr>
                        <td style=\"border-right: solid 1px black;border-left: solid 1px black;border-top: solid 1px black;border-bottom: solid 1px black;\" align=\"center\">No</td>
                        <td style=\"border-right: solid 1px black;border-left: solid 1px black;border-top: solid 1px black;border-bottom: solid 1px black;\" colspan=\"2\" align=\"center\">Nama</td>
                        <td style=\"border-right: solid 1px black;border-left: solid 1px black;border-top: solid 1px black;border-bottom: solid 1px black;\" colspan=\"2\" align=\"center\">Nip</td>
                        <td style=\"border-right: solid 1px black;border-left: solid 1px black;border-top: solid 1px black;border-bottom: solid 1px black;\" colspan=\"2\" align=\"center\">Jabatan</td>
                        <td style=\"border-right: solid 1px black;border-left: solid 1px black;border-top: solid 1px black;border-bottom: solid 1px black;\" colspan=\"2\" align=\"center\">TTD</td>
                     </tr>
                     <tr>
                        <td style=\"border-right: solid 1px black;border-left: solid 1px black;border-top: solid 1px black;border-bottom: solid 1px black;\" align=\"center\">1</td>
                        <td style=\"border-right: solid 1px black;border-left: solid 1px black;border-top: solid 1px black;border-bottom: solid 1px black;\" colspan=\"2\" align=\"center\">&nbsp;</td>
                        <td style=\"border-right: solid 1px black;border-left: solid 1px black;border-top: solid 1px black;border-bottom: solid 1px black;\" colspan=\"2\" align=\"center\">&nbsp;</td>
                        <td style=\"border-right: solid 1px black;border-left: solid 1px black;border-top: solid 1px black;border-bottom: solid 1px black;\" colspan=\"2\" align=\"center\">&nbsp;</td>
                        <td style=\"border-right: solid 1px black;border-left: solid 1px black;border-top: solid 1px black;border-bottom: solid 1px black;\" colspan=\"2\" align=\"center\">&nbsp;</td>
                     </tr>
                     <tr>
                        <td style=\"border-right: solid 1px black;border-left: solid 1px black;border-top: solid 1px black;border-bottom: solid 1px black;\" align=\"center\">2</td>
                        <td style=\"border-right: solid 1px black;border-left: solid 1px black;border-top: solid 1px black;border-bottom: solid 1px black;\" colspan=\"2\" align=\"center\">&nbsp;</td>
                        <td style=\"border-right: solid 1px black;border-left: solid 1px black;border-top: solid 1px black;border-bottom: solid 1px black;\" colspan=\"2\" align=\"center\">&nbsp;</td>
                        <td style=\"border-right: solid 1px black;border-left: solid 1px black;border-top: solid 1px black;border-bottom: solid 1px black;\" colspan=\"2\" align=\"center\">&nbsp;</td>
                        <td style=\"border-right: solid 1px black;border-left: solid 1px black;border-top: solid 1px black;border-bottom: solid 1px black;\" colspan=\"2\" align=\"center\">&nbsp;</td>
                     </tr>
                     <tr>
                        <td style=\"border-right: solid 1px black;border-left: solid 1px black;border-top: solid 1px black;border-bottom: solid 1px black;\" align=\"center\">&nbsp;</td>
                        <td style=\"border-right: solid 1px black;border-left: solid 1px black;border-top: solid 1px black;border-bottom: solid 1px black;\" colspan=\"2\" align=\"center\">&nbsp;</td>
                        <td style=\"border-right: solid 1px black;border-left: solid 1px black;border-top: solid 1px black;border-bottom: solid 1px black;\" colspan=\"2\" align=\"center\">&nbsp;</td>
                        <td style=\"border-right: solid 1px black;border-left: solid 1px black;border-top: solid 1px black;border-bottom: solid 1px black;\" colspan=\"2\" align=\"center\">&nbsp;</td>
                        <td style=\"border-right: solid 1px black;border-left: solid 1px black;border-top: solid 1px black;border-bottom: solid 1px black;\" colspan=\"2\" align=\"center\">&nbsp;</td>
                     </tr>
        
        ";

        $cRet  .=" 
                     <tr>
                        <td style=\"border-right: solid 1px black;border-left: solid 1px black;border-top: solid 1px black;border-bottom: solid 1px black;\" colspan=\"9\" width=\"100%\" align=\"left\">&emsp;&emsp;&emsp;&emsp;Rencana Penarikan Dana per Triwulan</td>
                     </tr>

                     <tr>
                        <td style=\"border-right: solid 1px black;border-left: solid 1px black;border-top: solid 1px black;border-bottom: solid 1px black;\" colspan=\"9\" width=\"100%\" align=\"left\">&emsp;&emsp;&emsp;&emsp;
                            <table border=\"0\" width=\"100%\">
                                <tr>
                                    <td width=\"15%\" align=\"left\">&emsp;Triwulan I</td>
                                    <td width=\"10%\" align=\"left\">&emsp;Rp</td>                        
                                    <td width=\"10%\" align=\"right\">&emsp;$triw1</td>
                                    <td width=\"65%\" align=\"left\">&emsp;</td>

                                </tr>
                                <tr>
                                    <td align=\"left\">&emsp;Triwulan II</td>
                                    <td align=\"left\">&emsp;Rp</td>                        
                                    <td align=\"right\">&emsp;$triw2</td>
                                    <td align=\"left\">&emsp;</td>
            
                                </tr>
                                <tr>
                                    <td align=\"left\">&emsp;Triwulan III</td>
                                    <td align=\"left\">&emsp;Rp</td>                        
                                    <td align=\"right\">&emsp;$triw3</td>
                                    <td align=\"left\">&emsp;</td>
            
                                </tr>
                                <tr>
                                    <td align=\"left\">&emsp;Triwulan IV</td>
                                    <td align=\"left\">&emsp;Rp</td>                        
                                    <td style=\"border-bottom: solid 2px black;\" width=\"20%\" align=\"right\">&emsp;$triw4</td>
                                    <td align=\"left\">&emsp;</td>
            
                                </tr>
                                <tr>
                                    <td align=\"right\">&emsp;Jumlah</td>
                                    <td align=\"left\">&emsp;Rp</td>                        
                                    <td align=\"right\">&emsp;$total</td>
                                    <td align=\"left\">&emsp;</td>

                                </tr>                           
                            </table>
                        </td>
                     </tr>
                    
                    
                    $tapdy
                    
                </table>";  
            
            $cRet .="<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";

             }   
           // echo "$cRet";
            $this->_mpdf_down('','',$cRet,10,10,10,'0');                                                 
  
    } /*printall_rka221_murni*/

/*printall_dpa221*/
function printall_dpa221() { 
       $id = $this->uri->segment(3);
       $id2 = substr($id,0,7);
       //$giat = $this->uri->segment(4);
       $cetak = $this->uri->segment(5);
       $chkpa = $this->uri->segment(6);
       $cell = $this->uri->segment(7); 
       
        $tgl2= $_REQUEST['tgl_ttd'];
        $ttd1x= $_REQUEST['ttd1'];
        $ttd2x= $_REQUEST['ttd2'];
        $ttd1=  str_replace('x',' ',$ttd1x);
        $ttd2=  str_replace('x',' ',$ttd2x);
        $tgl_ttd = $this->tukd_model->tanggal_format_indonesia($tgl2);
        
        $cRet   ="";
        $ini    ="SELECT trskpd.kd_kegiatan as kd_kegiatan ,m_giat.nm_kegiatan from trskpd
                    join m_giat on m_giat.kd_kegiatan=trskpd.kd_kegiatan 
                    WHERE left(trskpd.kd_skpd,7)='$id2' and left(trskpd.jns_kegiatan,1)='5' and
                    trskpd.total !=0 ORDER BY trskpd.kd_kegiatan
                    ";
        $itu    =$this->db->query($ini);

        foreach($itu->result() as $anu){
            $giat=$anu->kd_kegiatan;

         $sql_trhrka="SELECT top 1 status_rancang,statu, tgl_dpa_rancang FROM trhrka where left(kd_skpd,7)=left('$id',7)";
         $sql_trhrka=$this->db->query($sql_trhrka);
         foreach ($sql_trhrka->result() as $rowsc)
        {                  
            $tgl_rancang= $rowsc->tgl_dpa_rancang;
            $status= $rowsc->status_rancang;

        }
            
            $judulrka = 'DOKUMEN PELAKSANAAN ANGGARAN';
            $n_trdrka = '';
            $kdrka ='DPA';
        


        
            $sqldns="SELECT a.kd_urusan as kd_u,b.nm_urusan as nm_u,a.kd_skpd as kd_sk,a.nm_skpd as nm_sk FROM ms_skpd a INNER JOIN ms_urusan b ON a.kd_urusan=b.kd_urusan WHERE kd_skpd=left('$id',7)+'.00'";
            $a = 'left(';
            $skpd = 'kd_skpd';
            $b = ',7)'; 
        

         $sqlskpd=$this->db->query($sqldns);
         foreach ($sqlskpd->result() as $rowdns)
        {
           
            $kd_urusan= $rowdns->kd_u;                    
            $nm_urusan= $rowdns->nm_u;
            $kd_skpd  = $rowdns->kd_sk;
            $nm_skpd  = $rowdns->nm_sk;
        }
            
            $sqlorg="SELECT kd_org,nm_org FROM ms_organisasi WHERE kd_org=left('$id',7)";
                 $sqlorg1=$this->db->query($sqlorg);
                 foreach ($sqlorg1->result() as $rowdns)
                {
                   
                    $kd_org=$rowdns->kd_org;                    
                    $nm_org= $rowdns->nm_org;
                }


        $sqlurusan1="SELECT kd_urusan1,nm_urusan1 FROM ms_urusan1 WHERE kd_urusan1=left('$kd_urusan',1)";
                 $sqlskpd=$this->db->query($sqlurusan1);
                 foreach ($sqlskpd->result() as $rowdns)
                {
                   
                    $kd_urusan1=$rowdns->kd_urusan1;                    
                    $nm_urusan1= $rowdns->nm_urusan1;
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

      
      if($chkpa==0){
        $sqlttd1="SELECT TOP 1 nama as nm,nip as nip,jabatan as jab FROM ms_ttd where nip='$ttd1' and kode ='agr'";
                 }else{
        $sqlttd1="SELECT TOP 1 nama as nm,nip as nip,jabatan as jab FROM ms_ttd where nip='$ttd2'";
                }
                 $sqlttd=$this->db->query($sqlttd1);
                 foreach ($sqlttd->result() as $rowttd)
                {
                    $nipx=$rowttd->nip;                    
                    $namax= $rowttd->nm;
                    $jabatanx  = $rowttd->jab;
                }
                 
         $sqlorg="SELECT f.kd_urusan,f.nm_urusan,a.kd_skpd,e.nm_skpd,a.kd_program,z.nm_program,a.kd_kegiatan,c.nm_kegiatan,SUM(d.nilai) AS nilai,a.tu_capai,a.tu_mas,a.tu_kel,a.tu_has,
                a.tk_capai,a.tk_mas,a.tk_kel,a.tk_has,a.lokasi,rtrim(d.sumber) [sumber] ,a.sasaran_giat,a.ang_lalu,a.waktu_giat FROM trskpd a 
                INNER JOIN m_giat c ON a.kd_kegiatan1=c.KD_KEGIATAN
                INNER JOIN trdrka d ON a.kd_kegiatan=d.kd_kegiatan
                INNER JOIN ms_skpd e ON a.kd_skpd=e.kd_skpd
                INNER JOIN m_prog z ON a.kd_program=z.kd_program
                INNER JOIN ms_urusan f ON a.kd_urusan=f.kd_urusan where a.kd_kegiatan='$giat'
                GROUP BY f.kd_urusan,
                f.nm_urusan,
                a.kd_skpd,
                e.nm_skpd,
                a.kd_program,
                z.nm_program,
                a.kd_kegiatan,
                c.nm_kegiatan,
                a.tu_capai,
                a.tu_mas,
                a.tu_kel,
                a.tu_has,
                a.tk_capai,
                a.tk_mas,
                a.tk_kel,
                a.tk_has,
                a.lokasi,
                d.sumber,
                a.sasaran_giat,
                a.ang_lalu,a.waktu_giat";
                 $sqlorg1=$this->db->query($sqlorg);
                 foreach ($sqlorg1->result() as $roworg)
                {
                    $kd_urusan=$roworg->kd_urusan;                    
                    $nm_urusan= $roworg->nm_urusan;
                    $kd_skpd  = $roworg->kd_skpd;
                    $nm_skpd  = $roworg->nm_skpd;
                    $kd_prog  = $roworg->kd_program;
                    $nm_prog  = $roworg->nm_program;
                    $kd_giat  = $roworg->kd_kegiatan;
                    $nm_giat  = $roworg->nm_kegiatan;
                    $lokasi  = $roworg->lokasi;
                    $tu_capai  = $roworg->tu_capai;
                    $tu_mas  = $roworg->tu_mas;
                    $tu_kel  = $roworg->tu_kel;
                    $tu_has  = $roworg->tu_has;
                    $tk_capai  = $roworg->tk_capai;
                    $tk_mas  = $roworg->tk_mas;
                    $tk_kel  = $roworg->tk_kel;
                    $tk_has  = $roworg->tk_has;
                    $sas_giat = $roworg->sasaran_giat;
                    $ang_lalu = number_format($roworg->ang_lalu,"2",",",".");
                    $wak_giat = $roworg->waktu_giat;
                    $sumber = $roworg->sumber;

                    
                }
        $kd_urusan= empty($roworg->kd_urusan) || ($roworg->kd_urusan) == '' ? '' : ($roworg->kd_urusan);
        $nm_urusan= empty($roworg->nm_urusan) || ($roworg->nm_urusan) == '' ? '' : ($roworg->nm_urusan);
        $kd_skpd= empty($roworg->kd_skpd) || ($roworg->kd_skpd) == '' ? '' : ($roworg->kd_skpd);
        $nm_skpd= empty($roworg->nm_skpd) || ($roworg->nm_skpd) == '' ? '' : ($roworg->nm_skpd);
        $kd_prog= empty($roworg->kd_program) || ($roworg->kd_program) == '' ? '' : ($roworg->kd_program);
        $nm_prog= empty($roworg->nm_program) || ($roworg->nm_program) == '' ? '' : ($roworg->nm_program);
        $kd_giat= empty($roworg->kd_kegiatan) || ($roworg->kd_kegiatan) == '' ? '' : ($roworg->kd_kegiatan);
        $nm_giat= empty($roworg->nm_kegiatan) || ($roworg->nm_kegiatan) == '' ? '' : ($roworg->nm_kegiatan);
        $lokasi= empty($roworg->lokasi) || ($roworg->lokasi) == '' ? '' : ($roworg->lokasi);
        $tu_capai= empty($roworg->tu_capai) || ($roworg->tu_capai) == '' ? '' : ($roworg->tu_capai);
        $tu_mas= empty($roworg->tu_mas) || ($roworg->tu_mas) == '' ? '' : ($roworg->tu_mas);
        $tu_kel= empty($roworg->tu_kel) || ($roworg->tu_kel) == '' ? '' : ($roworg->tu_kel);
        $tu_has= empty($roworg->tu_has) || ($roworg->tu_has) == '' ? '' : ($roworg->tu_has);
        $tk_capai= empty($roworg->tk_capai) || ($roworg->tk_capai) == '' ? '' : ($roworg->tk_capai);
        $tk_mas= empty($roworg->tk_mas) || ($roworg->tk_mas) == '' ? '' : ($roworg->tk_mas);
        $tk_kel= empty($roworg->tk_kel) || ($roworg->tk_kel) == '' ? '' : ($roworg->tk_kel);
        $tk_has= empty($roworg->tk_has) || ($roworg->tk_has) == '' ? '' : ($roworg->tk_has);
        $sas_giat= empty($roworg->sasaran_giat) || ($roworg->sasaran_giat) == '' ? '' : ($roworg->sasaran_giat);
        $ang_lalu= empty($roworg->ang_lalu) || ($roworg->ang_lalu) == '' || ($roworg->ang_lalu) == 'Null' ? 0 : ($roworg->ang_lalu);
        $wak_giat= empty($roworg->waktu_giat) || ($roworg->waktu_giat) == '' || ($roworg->waktu_giat) == 'Null' ? '' : ($roworg->waktu_giat);
        $sumber= empty($roworg->sumber) || ($roworg->sumber) == '' || ($roworg->sumber) == 'Null' ? '' : ($roworg->sumber);
        $org = substr($kd_skpd,0,7);
        switch($sumber){
            case 'DAU';
                $sumber = 'Dana Alokasi Umum (DAU)';
            break;
            case 'PAD';
                $sumber = 'Pendapatan Asli Daerah (PAD)';
            break;            
            case 'DAK';
                $sumber = 'Dana Alokasi Khusus (DAK)';
            break;           
        }
        
  
       $sqltp="SELECT SUM(nilai) AS totb FROM trdrka WHERE kd_kegiatan='$giat' AND left(kd_skpd,7)=left('$id',7)";
                 $sqlb=$this->db->query($sqltp);
                 foreach ($sqlb->result() as $rowb)
                {
                   $totp  =number_format($rowb->totb,"2",",",".");
                   $totp1 =number_format($rowb->totb*1.1,"2",",","."); 
                }  
                $ang_lalu =number_format($ang_lalu,"2",",",".");     
 
        $k2 = substr($id,0,7);
        $k3 = substr($kd_prog,-2,2);
        $k4 = substr($kd_giat,19,3);


     $cRet .="<table style=\"border-collapse:collapse;font-size:13;border-top: solid 1px black;border-right: solid 1px black;border-left: solid 1px black;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
                    <tr> <td style=\"border-collapse:collapse;\"  width=\"15%\" rowspan=\"2\" align=\"center\"></td>
                         <td style=\"border-RIGHT: solid 1px black;\" width=\"40%\" align=\"center\" rowspan=\"2\" ><strong>$judulrka<br>SATUAN KERJA PERANGKAT DAERAH</strong></td>
                         <td style=\"border-bottom: solid 1px black;\" width=\"26%\" align=\"center\" colspan=\"6\"><strong>NOMOR $kdrka SKPD</strong></td>
                         <td style=\"border-collapse:collapse;font-size:18;border-left: solid 1px black\" width=\"19%\" rowspan=\"4\" align=\"center\"><strong>FORMULIR <br>$kdrka - SKPD <br>2.2.1<br></strong></td>

                    </tr>

                    <tr>

                         <td style=\"border-right: solid 1px black;\" width=\"5%\" align=\"center\" ><strong>$kd_urusan</strong></td>
                         <td style=\"border-right: solid 1px black;\" width=\"5%\" align=\"center\"><strong>$k2</strong></td>
                         <td style=\"border-right: solid 1px black;\" width=\"5%\" align=\"center\"><strong>$k3</strong></td>
                         <td style=\"border-right: solid 1px black;\" width=\"5%\" align=\"center\"><strong>$k4</strong></td>
                         <td colspan=\"2\" style=\"border-left: solid 1px black;\" width=\"3%\" align=\"center\"><strong>5</strong></td>
                         
                    </tr>
                    <tr>
                         <td align=\"center\" colspan=\"8\" width=\"100%\" style=\"border-top: solid 1px black;\"><strong>$kab</strong> </td>
                    </tr>
                    <tr>
                         <td align=\"center\" colspan=\"8\" width=\"100%\" ><strong>TAHUN ANGGARAN $thn</strong></td>
                    </tr>

                  </table>";        
       
       $cRet .="<table style=\"border-collapse:collapse;font-weight:bold;font-size:5px;border-left:solid 1px black;border-top:solid 1px black;border-right:solid 1px black; font-size:12;\" width=\"100%\" border=\"0\">
                    <tr>
                        <td width=\"20%\"><strong>&nbsp;Urusan Pemerintahan</strong></td>
                        <td width=\"3%\" align=\"center\">:</td>
                        <td colspan=\"7\" width=\"77%\"><strong>$kd_urusan - $nm_urusan</strong></td>
                    </tr>
                    <tr>
                        <td width=\"20%\"><strong>&nbsp;Organisasi</strong></td>
                        <td width=\"3%\" align=\"center\">:</td>
                        <td colspan=\"7\" width=\"77%\"> <strong>$org - $nm_org</strong></td>
                    </tr>
                    <tr>
                        <td width=\"20%\" align=\"left\">&nbsp;Program</td>
                        <td width=\"3%\" align=\"center\">:</td>
                        <td colspan=\"7\" width=\"77%\" align=\"left\">$kd_prog   - $nm_prog</td>
                    </tr>
                    <tr><td width=\"20%\" align=\"left\">&nbsp;Kegiatan</td>
                        <td width=\"3%\" align=\"center\">:</td>
                        <td colspan=\"7\" width=\"77%\" align=\"left\">$kd_giat   - $nm_giat</td>
                    </tr>
                    <tr><td width=\"20%\" align=\"left\">&nbsp;</td>
                        <td width=\"3%\" align=\"center\"></td>
                        <td colspan=\"7\" width=\"77%\" align=\"left\"></td>
                    </tr>
                    <tr><td width=\"20%\" align=\"left\">&nbsp;Waktu Pelaksanaan</td>
                        <td width=\"3%\" align=\"center\">:</td>
                        <td colspan=\"6\" width=\"77%\" align=\"left\">$wak_giat</td>
                    </tr>
                    <tr><td width=\"20%\" align=\"left\">&nbsp;Lokasi Kegiatan</td>
                        <td width=\"3%\" align=\"center\">:</td>
                        <td colspan=\"7\" width=\"77%\" align=\"left\">$lokasi</td>
                    </tr>                      
                    <tr>
                        <td style=\"border-left:solid 1px black;\"  width=\"20%\" align=\"left\">&nbsp;Jumlah Tahun<br>&nbsp;n-1</td>
                        <td width=\"3%\" align=\"center\">: </td>
                        <td style=\"border-right:solid 1px black;\" colspan=\"7\" width=\"77%\" align=\"left\">Rp $ang_lalu</td>
                    </tr>
                    <tr>
                        <td style=\"border-left:solid 1px black;\"  width=\"20%\" align=\"left\">&nbsp;Jumlah Tahun<br>&nbsp;n 1</td>
                        <td width=\"3%\" align=\"center\">:</td>
                        <td style=\"border-right:solid 1px black;\" colspan=\"7\" width=\"77%\" align=\"left\">Rp $totp</td>
                    </tr>
                    <tr>
                        <td style=\"border-left:solid 1px black;\"  width=\"20%\" align=\"left\">&nbsp;Jumlah Tahun<br>&nbsp;n+1</td>
                        <td width=\"3%\" align=\"center\">:</td>
                        <td style=\"border-right:solid 1px black;\" colspan=\"7\" width=\"77%\" align=\"left\">Rp</td>
                    </tr>
                    <tr><td style=\"border-left:solid 1px black;\"  width=\"20%\" align=\"left\">&nbsp;</td>
                        <td width=\"3%\" align=\"center\"></td>
                        <td style=\"border-right:solid 1px black;\" colspan=\"7\" width=\"77%\" align=\"left\"></td>
                    </tr>
                    <tr><td style=\"border-left:solid 1px black;\"  width=\"20%\" align=\"left\">&nbsp;Waktu Pelaksanaan</td>
                        <td width=\"3%\" align=\"center\">:</td>
                        <td style=\"border-right:solid 1px black;\"  colspan=\"7\" width=\"77%\" align=\"left\">$wak_giat</td>                      
                    </tr>
                    <tr><td style=\"border-left:solid 1px black;\"  width=\"20%\" align=\"left\">&nbsp;Sumber Dana</td>
                        <td width=\"3%\" align=\"center\">:</td>
                        <td style=\"border-right:solid 1px black;\"  colspan=\"7\" width=\"77%\" align=\"left\">$sumber</td>
                    </tr>
                </table>";         
 
        $cRet .= "<table style=\"border-collapse:collapse;font-weight:bold;font-size:5px;border-left:solid 1px black;border-top:solid 1px black;border-right:solid 1px black; font-size:12;\" width=\"100%\" border=\"1\">
                    <tr>
                        <td width=\"100%\" colspan=\"9\"  align=\"center\">Indikator & Tolak Ukur Kinerja Belanja langsung</td>
                    </tr>";
        $cRet .="<tr>
                 <td colspan=\"2\" align=\"center\">Indikator </td>
                 <td colspan=\"3\" align=\"center\">Tolak Ukur Kerja </td>
                 <td colspan=\"4\" align=\"center\">Target Kinerja </td>
                </tr>";       
        $cRet .=" <tr align=\"center\">
                    <td colspan=\"2\">Capaian Program </td>
                    <td colspan=\"3\">$tu_capai</td>
                    <td colspan=\"4\">$tk_capai</td>
                 </tr>";
        $cRet .=" <tr align=\"center\">
                    <td colspan=\"2\">Masukan </td>
                    <td colspan=\"3\">$tu_mas</td>
                    <td colspan=\"4\">Rp. $totp </td>
                </tr>";
        $cRet .=" <tr align=\"center\">
                    <td colspan=\"2\">Keluaran </td>
                    <td colspan=\"3\">$tu_kel</td>
                    <td colspan=\"4\">$tk_kel</td>
                  </tr>";
        $cRet .=" <tr align=\"center\">
                    <td colspan=\"2\">Hasil </td>
                    <td colspan=\"3\">$tu_has</td>
                    <td colspan=\"4\">$tk_has</td>
                  </tr>";
        $cRet .= "<tr>
                    <td colspan=\"9\"  width=\"100%\" align=\"left\">Kelompok Sasaran Kegiatan : $sas_giat</td>
                </tr>";
        
        $cRet .= "<tr>
                        <td colspan=\"9\" align=\"center\">RINCIAN $judulrka BELANJA LANGSUNG <br>MENURUT PROGRAM DAN PER KEGIATAN SATUAN KERJA PERANGKAT DAERAH</td>
                  </tr>";
                    
        $cRet .="</table> ";

        $cRet .= "<table style=\"border-collapse:collapse;font-size:12;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"$cell\">
                     <thead >                       
                        <tr><td rowspan=\"2\" width=\"10%\" align=\"center\"><b>KODE REKENING</b></td>                            
                            <td rowspan=\"2\" width=\"30%\" align=\"center\"><b>Uraian</b></td>
                            <td colspan=\"4\" width=\"35%\" align=\"center\"><b>Rincian Perhitungan</b></td>
                            <td rowspan=\"2\" colspan=\"3\" width=\"25%\" align=\"center\"><b>Jumlah (Rp.)</b></td></tr>
                        <tr>
                            <td style=\"font-weight:bold;\" width=\"8%\" align=\"center\">Volume</td>
                            <td style=\"font-weight:bold;\" width=\"8%\" align=\"center\">Satuan</td>
                            <td colspan=\"2\" style=\"font-weight:bold;\" width=\"15%\" align=\"center\">Tarif / Harga</td>
                        </tr>                            
                        <tr><td style=\"vertical-align:top;border-top: none;border-bottom: solid 2px black;font-weight:bold;\" width=\"10%\" align=\"center\">1</td>                            
                            <td style=\"vertical-align:top;border-top: none;border-bottom: solid 2px black;font-weight:bold;\" width=\"30%\" align=\"center\">2</td>
                            <td style=\"vertical-align:top;border-top: none;border-bottom: solid 2px black;font-weight:bold;\" width=\"8%\" align=\"center\">3</td>
                            <td style=\"vertical-align:top;border-top: none;border-bottom: solid 2px black;font-weight:bold;\" width=\"8%\" align=\"center\">4</td>
                            <td colspan=\"2\" style=\"vertical-align:top;border-top: none;border-bottom: solid 2px black;font-weight:bold;\" width=\"19%\" align=\"center\">5</td>
                            <td colspan=\"3\" style=\"vertical-align:top;border-top: none;border-bottom: solid 2px black;font-weight:bold;\" width=\"25%\" align=\"center\">6 = (3 X 5)</td>
                        </tr>                     
                    </thead>
                    
                        ";

                 $sql1="SELECT * FROM(SELECT 0 header,0 no_po, LEFT(a.kd_rek5,1)AS rek1,LEFT(a.kd_rek5,1)AS rek,b.nm_rek1 AS nama ,0 AS volume,' 'AS satuan,
                        0 AS harga,SUM(a.nilai) AS nilai,0 AS volume2,' 'AS satuan2, 0 AS harga2,isnull(SUM(a.nilai_sempurna),0) AS nilai2,'1' AS id 
                        FROM trdrka a INNER JOIN ms_rek1 b ON LEFT(a.kd_rek5,1)=b.kd_rek1 WHERE a.nilai != 0 and a.kd_kegiatan='$giat' AND left(a.kd_skpd,7)=left('$id',7) 
                        GROUP BY LEFT(a.kd_rek5,1),nm_rek1 
                         UNION ALL 
                         SELECT 0 header, 0 no_po,LEFT(a.kd_rek5,2) AS rek1,LEFT(a.kd_rek5,2) AS rek,b.nm_rek2 AS nama,0 AS volume,' 'AS satuan,
                        0 AS harga,SUM(a.nilai) AS nilai,0 AS volume2,' 'AS satuan2, 0 AS harga2,isnull(SUM(a.nilai_sempurna),0) AS nilai2,'2' AS id 
                        FROM trdrka a INNER JOIN ms_rek2 b ON LEFT(a.kd_rek5,2)=b.kd_rek2 WHERE a.nilai != 0 and a.kd_kegiatan='$giat'
                        and left(a.kd_skpd,7)=left('$id',7)  GROUP BY LEFT(a.kd_rek5,2),nm_rek2 
                         UNION ALL  
                         SELECT 0 header, 0 no_po, LEFT(a.kd_rek5,3) AS rek1,LEFT(a.kd_rek5,3) AS rek,b.nm_rek3 AS nama,0 AS volume,' 'AS satuan,
                        0 AS harga,SUM(a.nilai) AS nilai,0 AS volume2,' 'AS satuan2, 0 AS harga2,isnull(SUM(a.nilai_sempurna),0) AS nilai2,'3' AS id 
                        FROM trdrka a INNER JOIN ms_rek3 b ON LEFT(a.kd_rek5,3)=b.kd_rek3 WHERE a.nilai != 0 and a.kd_kegiatan='$giat'
                        AND left(a.kd_skpd,7)=left('$id',7)  GROUP BY LEFT(a.kd_rek5,3),nm_rek3 
                         UNION ALL 
                         SELECT 0 header, 0 no_po, LEFT(a.kd_rek5,5) AS rek1,LEFT(a.kd_rek5,5) AS rek,b.nm_rek4 AS nama,0 AS volume,' 'AS satuan,
                        0 AS harga,SUM(a.nilai) AS nilai,0 AS volume2,' 'AS satuan2, 0 AS harga2,isnull(SUM(a.nilai_sempurna),0) AS nilai2,'4' AS id 
                        FROM trdrka a INNER JOIN ms_rek4 b ON LEFT(a.kd_rek5,5)=b.kd_rek4 WHERE a.nilai != 0 and a.kd_kegiatan='$giat'
                        AND left(a.kd_skpd,7)=left('$id',7)  GROUP BY LEFT(a.kd_rek5,5),nm_rek4 
                         UNION ALL 
                         SELECT 0 header, 0 no_po, a.kd_rek5 AS rek1,RTRIM(a.kd_rek5) AS rek,b.nm_rek5 AS nama,0 AS volume,' 'AS satuan,
                        0 AS harga,SUM(a.nilai) AS nilai,0 AS volume2,' 'AS satuan2, 0 AS harga2,isnull(SUM(a.nilai_sempurna),0) AS nilai2,'5' AS id 
                        FROM trdrka a INNER JOIN ms_rek5 b ON a.kd_rek5=b.kd_rek5 WHERE a.nilai != 0 and a.kd_kegiatan='$giat'
                        AND left(a.kd_skpd,7)=left('$id',7)  GROUP BY a.kd_rek5,b.nm_rek5
                         UNION ALL  
                         SELECT * FROM (SELECT  b.header,b.no_po,RIGHT(a.no_trdrka,7) AS rek1,' 'AS rek,b.uraian AS nama,0 AS volume,' ' AS satuan,
                        0 AS harga,SUM(a.total) AS nilai,0 AS volume2,' ' AS satuan2, 0 AS harga2,isnull(SUM(a.total_sempurna),0) AS nilai2,'6' AS id 
                        FROM trdpo a
                        LEFT JOIN trdpo b ON b.kode=a.kode AND b.header ='1' AND a.no_trdrka=b.no_trdrka 
                        WHERE LEFT(a.no_trdrka,7)=left('$id',7) AND SUBSTRING(a.no_trdrka,12,22)='$giat'
                        GROUP BY  RIGHT(a.no_trdrka,7),b.header,b.no_po,b.uraian)z WHERE header='1' and nilai <> 0
                        UNION ALL 
                        SELECT a. header,a.no_po,RIGHT(a.no_trdrka,7) AS rek1,' 'AS rek,a.uraian AS nama,a.volume1 AS volume,a.satuan1 AS satuan,
                        a.harga1 AS harga,a.total AS nilai,a.volume_sempurna1 AS volume2,a.satuan_sempurna1 AS satuan2, a.harga_sempurna1 AS harga2,
                        a.total_sempurna AS nilai2,'6' AS id FROM trdpo a  WHERE LEFT(a.no_trdrka,7)=left('$id',7) AND SUBSTRING(no_trdrka,12,22)='$giat' AND (header='0' or header is null) and a.total != 0
                        ) a ORDER BY a.rek1,a.id,a.no_po";
                $totbl = 0;
                $query = $this->db->query($sql1);

                foreach ($query->result() as $row)
                {
                    $rek=$row->rek;
                    $reke=$this->dotrek($rek);
                    $uraian=$row->nama;
                    $nopo = $row->no_po;
                //    $volum=$row->volume;
                    $sat=$row->satuan;
                    $hrg= empty($row->harga) || $row->harga == 0 ? '' :number_format($row->harga,2,',','.');
                    $volum= empty($row->volume) || $row->volume == 0 ? '' :$row->volume;

                    //$hrg=number_format($row->harga,"2",".",",");
                    $nila= empty($row->nilai) || $row->nilai == 0 ? '' :number_format($row->nilai,2,',','.');
                    $nilaibl = empty($row->nilai)  ? 0 : $row->nilai;
                    
                    if(strlen($row->rek1) <= '5' ){
                        $bold = 'font-weight:bold;';
                        $lbawah = 'border-bottom: solid 1px black;';
                        $latas = 'border-top: solid 1px black;';
                    }else{
                        $bold ='';
                        $lbawah = 'border-bottom: none;';
                        $latas = 'border-top: none;';
                    }

                    if(strlen($row->rek1) == '1' ){
                        $totbl = $totbl + $nilaibl;
                    }            
                    
                     $cRet    .= " <tr><td style=\"vertical-align:top;$bold $lbawah $latas \" width=\"10%\" align=\"left\">$reke</td>                                     
                                     <td style=\"vertical-align:top;$bold $lbawah $latas  \" width=\"30%\">&nbsp;$uraian</td>
                                     <td style=\"vertical-align:top;$bold $lbawah $latas \" width=\"8%\" align=\"right\">$volum</td>
                                     <td style=\"vertical-align:top;$bold $lbawah $latas \" width=\"8%\" align=\"center\">$sat</td>
                                     <td colspan=\"2\" style=\"vertical-align:top;$bold $lbawah $latas \" width=\"19%\" align=\"right\">$hrg</td>
                                     <td colspan=\"3\" style=\"vertical-align:top;$bold $lbawah $latas \" width=\"25%\" align=\"right\">$nila</td></tr>
                                     ";
                             
                }

                   $totbl=number_format($totbl,"2",",",".");
                   
                    $cRet    .=" <tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"10%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"30%\"><strong>JUMLAH BELANJA</strong></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"8%\">&nbsp;</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"8%\">&nbsp;</td>
                                     <td colspan=\"2\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"19%\" align=\"right\">&nbsp;</td>
                                     <td colspan=\"3\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"25%\" align=\"right\"><strong>$totbl</strong></td></tr>";

                             $cRet .="
                                        <tr>
                                        <td colspan=\"9\">
                                            <table border=\"0\" width=\"100%\" >
                                                <tr>
                                                    <td width=\"50%\" colspan=\"2\">&emsp;
                                                    <td width=\"10%\" >
                                                </tr>
                                                <tr>
                                                    <td width=\"10%\" align=\"left\">&nbsp;<br>&nbsp;
                                                        <br>&nbsp;
                                                        &nbsp;<br>
                                                        &nbsp;<br>
                                                        &nbsp;<br>
                                                        &nbsp;  
                                                    </td>
                                                    <td width=\"40%\" align=\"center\" valign=\"top\">&nbsp;
                                                    <br>&nbsp;
                                                    <p>&nbsp;</p>
                                                    <p>&nbsp;</p>
                                                    <br><b><ins>&nbsp;</ins></b>
                                                    <br>&nbsp;
                                                    <br>&nbsp;
                                                    </td>
                                                    <td width=\"10%\" align=\"left\" valign=\"top\">&nbsp;<br>&nbsp;
                                                        <br>&nbsp;
                                                        &nbsp;<br>
                                                        &nbsp;<br>
                                                        &nbsp;<br>
                                                        &nbsp;  
                                                    </td>
                                                    <td width=\"40%\" align=\"center\">$daerah, $tgl_ttd 
                                                    <br>Mengesahkan,
                                                    <br>$jabatanx
                                                    <p>&nbsp;</p>
                                                    <p>&nbsp;</p>
                                                    <p>&nbsp;</p>
                                                    <p>&nbsp;</p>
                                                    <br><b><u>$namax</u></b>
                                                    <br>$nipx
                                                   </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                            
                                    ";

   
        $qtriw = " SELECT distinct isnull( a.triw1,0) AS triw1,isnull( a.triw2,0) AS triw2,isnull( a.triw3,0) 
                                AS triw3,isnull( a.triw4,0) AS triw4  FROM trskpd a join trdrka b on a.kd_kegiatan=b.kd_kegiatan
                                WHERE a.kd_kegiatan='$giat' AND left(a.kd_skpd,7)=left('$id',7)";
        $query = $this->db->query($qtriw);
        if ($query->num_rows() > 0){
            foreach ($query->result() as $triw){
                            $triw1=  empty($triw->triw1) ? 0 : $triw->triw1;
                            $triw2= empty($triw->triw2) ? 0 :$triw->triw2;
                            $triw3= empty($triw->triw3)  ? 0 :$triw->triw3;
                            $triw4= empty($triw->triw4) ? 0 :$triw->triw4;
                            $total = $triw1 + $triw2 + $triw3 + $triw4;
            }
        }else{
            $triw1=  0;
            $triw2= 0;
            $triw3= 0;
            $triw4= 0;
            $total = $triw1 + $triw2 + $triw3 + $triw4;                            
        }

        $triw1 = number_format($triw1,2,',','.');
        $triw2= number_format($triw2,2,',','.');
        $triw3= number_format($triw3,2,',','.');
        $triw4= number_format($triw4,2,',','.');
        $total = number_format($total,2,',','.');

        $cRet  .=" 
                     <tr>
                        <td style=\"border-right: solid 1px black;border-left: solid 1px black;border-top: solid 1px black;border-bottom: solid 1px black;\" colspan=\"9\" width=\"100%\" align=\"left\">&emsp;&emsp;&emsp;&emsp;Rencana Penarikan Dana per Triwulan</td>
                     </tr>

                     <tr>
                        <td style=\"border-right: solid 1px black;border-left: solid 1px black;border-top: solid 1px black;border-bottom: solid 1px black;\" colspan=\"9\" width=\"100%\" align=\"left\">&emsp;&emsp;&emsp;&emsp;
                            <table border=\"0\" width=\"100%\">
                                <tr>
                                    <td width=\"15%\" align=\"left\">&emsp;Triwulan I</td>
                                    <td width=\"10%\" align=\"left\">&emsp;Rp</td>                        
                                    <td width=\"10%\" align=\"right\">&emsp;$triw1</td>
                                    <td width=\"65%\" align=\"left\">&emsp;</td>

                                </tr>
                                <tr>
                                    <td align=\"left\">&emsp;Triwulan II</td>
                                    <td align=\"left\">&emsp;Rp</td>                        
                                    <td align=\"right\">&emsp;$triw2</td>
                                    <td align=\"left\">&emsp;</td>
            
                                </tr>
                                <tr>
                                    <td align=\"left\">&emsp;Triwulan III</td>
                                    <td align=\"left\">&emsp;Rp</td>                        
                                    <td align=\"right\">&emsp;$triw3</td>
                                    <td align=\"left\">&emsp;</td>
            
                                </tr>
                                <tr>
                                    <td align=\"left\">&emsp;Triwulan IV</td>
                                    <td align=\"left\">&emsp;Rp</td>                        
                                    <td style=\"border-bottom: solid 2px black;\" width=\"20%\" align=\"right\">&emsp;$triw4</td>
                                    <td align=\"left\">&emsp;</td>
            
                                </tr>
                                <tr>
                                    <td align=\"right\">&emsp;Jumlah</td>
                                    <td align=\"left\">&emsp;Rp</td>                        
                                    <td align=\"right\">&emsp;$total</td>
                                    <td align=\"left\">&emsp;</td>

                                </tr>                           
                            </table>
                        </td>
                     </tr>

                </table>"; 
             $cRet .="<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
            } 
            //echo "$cRet";
            
           $this->_mpdf_down('','',$cRet,10,10,10,'0');                                                     
    }
/*printall_dpa221*/

  function ekspor(){
      $sql="SELECT  LEFT(a.kd_skpd,7) skpd,a.nm_skpd,left(a.kd_kegiatan,4) urusan,b.nm_urusan
          ,left(a.kd_kegiatan,18) program,c.nm_program,
          a.kd_kegiatan,a.nm_kegiatan,
          left(a.kd_rek5,1) rek1,d.nm_rek1,
          left(a.kd_rek5,2) rek2,e.nm_rek2,
          left(a.kd_rek5,3) rek3,f.nm_rek3,
          left(a.kd_rek5,5) rek4,g.nm_rek4,
          a.kd_rek5,a.nm_rek5,a.nilai, a.nilai_sempurna,a.nilai_ubah from trdrka a left join ms_urusan b
          on left(a.kd_kegiatan,4) = b.kd_urusan
          left join m_prog c on  left(a.kd_kegiatan,18) = c.kd_program
          left join ms_rek1 d on left(a.kd_rek5,1) = kd_rek1
          left join ms_rek2 e on left(a.kd_rek5,2) = kd_rek2
          left join ms_rek3 f on left(a.kd_rek5,3) = kd_rek3
          left join ms_rek4 g on left(a.kd_rek5,5) = kd_rek4
          order by a.no_trdrka";
       $data="";
      $exe=$this->db->query($sql);
      foreach($exe->result() as $a){
          $skpd       =$a->skpd;
          $nmskpd     =$a->nm_skpd;
          $urusan     =$a->urusan;
          $nmurusan   =$a->nm_urusan;
          $program    =$a->program;
          $nmprogram  =$a->nm_program;
          $giat       =$a->kd_kegiatan;
          $nmgiat     =$a->nm_kegiatan;
          $rek1       =$a->rek1;
          $nmrek1     =$a->nm_rek1;
          $rek2       =$a->rek2;
          $nmrek2     =$a->nm_rek2;
          $rek3       =$a->rek3;
          $nmrek3     =$a->nm_rek3;
          $rek4       =$a->rek4;
          $nmrek4     =$a->nm_rek4;
          $rek5       =$a->kd_rek5;
          $nmrek5     =$a->nm_rek5;
          $nilai      =$a->nilai;
          $nilai_s    =$a->nilai_sempurna;
          $nilai_u    =$a->nilai_ubah;



          $data.=$skpd.
                ";".$nmskpd.
                ";".$urusan.
                ";".$nmurusan.
                ";".$program.
                ";".$nmprogram.
                ";".$giat.
                ";".$nmgiat.
                ";".$rek1.
                ";".$nmrek1.
                ";".$rek2.
                ";".$nmrek2.
                ";".$rek3.
                ";".$nmrek3.
                ";".$rek4.
                ";".$nmrek4.
                ";".$rek5.
                ";".$nmrek5.
                ";".$nilai.
                ";".$nilai_s.
                ";".$nilai_u.
                "\n";
      }

        echo $data;
        header('Content-Type: application/csv');
        header('Content-Disposition: attachement; filename="APBD.csv"');       
  }
  function ekspor_realisasi(){
      $sql="SELECT LEFT(a.kd_skpd,7)skpd,a.nm_skpd,left(a.kd_kegiatan,4) urusan,b.nm_urusan
            ,left(a.kd_kegiatan,18) program,c.nm_program,
            a.kd_kegiatan,a.nm_kegiatan,
            left(a.kd_rek5,1)rek1,d.nm_rek1,
            left(a.kd_rek5,2)rek2,e.nm_rek2,
            left(a.kd_rek5,3)rek3,f.nm_rek3,
            left(a.kd_rek5,5)rek4,g.nm_rek4,
            a.kd_rek5,a.nm_rek5,a.nilai, a.nilai_sempurna,a.nilai_ubah, isnull(xxx.nilai,0) realisasi from trdrka a left join ms_urusan b
            on left(a.kd_kegiatan,4) = b.kd_urusan
            left join m_prog c on  left(a.kd_kegiatan,18) = c.kd_program
            left join ms_rek1 d on left(a.kd_rek5,1) = kd_rek1
            left join ms_rek2 e on left(a.kd_rek5,2) = kd_rek2
            left join ms_rek3 f on left(a.kd_rek5,3) = kd_rek3
            left join ms_rek4 g on left(a.kd_rek5,5) = kd_rek4
            left join 
            (select left(a.kd_skpd,7) s, a.kd_kegiatan, a.kd_rek5, sum(a.nilai) nilai 
            from trdspp a inner join trhspm b on left(a.kd_skpd,7)=left(b.kd_skpd,7) and a.no_spp=b.no_spp
            WHERE left(a.kd_rek5,1)=5
            GROUP BY left(a.kd_skpd,7), a.kd_kegiatan, a.kd_rek5) xxx on a.kd_rek5=xxx.kd_rek5 and a.kd_kegiatan=xxx.kd_kegiatan";
       $data="";
      $exe=$this->db->query($sql);
      foreach($exe->result() as $a){
          $skpd       =$a->skpd;
          $nmskpd     =$a->nm_skpd;
          $urusan     =$a->urusan;
          $nmurusan   =$a->nm_urusan;
          $program    =$a->program;
          $nmprogram  =$a->nm_program;
          $giat       =$a->kd_kegiatan;
          $nmgiat     =$a->nm_kegiatan;
          $rek1       =$a->rek1;
          $nmrek1     =$a->nm_rek1;
          $rek2       =$a->rek2;
          $nmrek2     =$a->nm_rek2;
          $rek3       =$a->rek3;
          $nmrek3     =$a->nm_rek3;
          $rek4       =$a->rek4;
          $nmrek4     =$a->nm_rek4;
          $rek5       =$a->kd_rek5;
          $nmrek5     =$a->nm_rek5;
          $nilai      =$a->nilai;
          $nilai_s    =$a->nilai_sempurna;
          $nilai_u    =$a->nilai_ubah;
          $realisasi  =$a->realisasi;



          $data.=$skpd.
                ";".$nmskpd.
                ";".$urusan.
                ";".$nmurusan.
                ";".$program.
                ";".$nmprogram.
                ";".$giat.
                ";".$nmgiat.
                ";".$rek1.
                ";".$nmrek1.
                ";".$rek2.
                ";".$nmrek2.
                ";".$rek3.
                ";".$nmrek3.
                ";".$rek4.
                ";".$nmrek4.
                ";".$rek5.
                ";".$nmrek5.
                ";".$nilai.
                ";".$nilai_s.
                ";".$nilai_u.
                ";".$realisasi.
                "\n";
      }

        echo $data;
        header('Content-Type: application/csv');
        header('Content-Disposition: attachement; filename="APBD_Realisasi.csv"');       
  }
} //end core of the core
