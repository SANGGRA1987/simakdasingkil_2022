<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Fungsi Model
 */ 
 
 
class cetak_rka_model extends CI_Model {
public $ppkd = "4.02.02";
public $ppkd1 = "4.02.02.02";
public $keu1 = "4.02.02.01";
 
public $kdbkad="5-02.0-00.0-00.02.01";
   
  
public $ppkd_lama = "4.02.02";
public $ppkd1_lama = "4.02.02.02"; 
    function __construct()
    { 
        parent::__construct(); 
    }  

    function preview_rka_skpd_penetapan($tgl_ttd,$ttd1,$ttd2,$id,$cetak,$detail,$tanggal_ttd,$doc,$gaji){
        $sqlsc="SELECT tgl_rka,provinsi,kab_kota,daerah,thn_ang FROM sclient where kd_skpd='$id'";
        $sqlsclient=$this->db->query($sqlsc);
        foreach ($sqlsclient->result() as $rowsc){
                    $tgl=$rowsc->tgl_rka;
                    $kab     = $rowsc->kab_kota;
                    $daerah  = $rowsc->daerah;
                    $thn     = $rowsc->thn_ang;
        }

        $sqldns="SELECT a.kd_urusan as kd_u,left(b.kd_bidang_urusan,1) as header, LEFT(a.kd_skpd,20) as kd_org,b.nm_bidang_urusan as nm_u,a.kd_skpd as kd_sk,
                a.nm_skpd as nm_sk FROM ms_skpd a INNER JOIN ms_bidang_urusan b
                 ON a.kd_urusan=b.kd_bidang_urusan WHERE  kd_skpd='$id'";
        $sqlskpd=$this->db->query($sqldns);
        foreach ($sqlskpd->result() as $rowdns){
                    $kd_urusan=$rowdns->kd_u;                    
                    $nm_urusan= $rowdns->nm_u;
                    $kd_skpd  = $rowdns->kd_sk;
                    $nm_skpd  = $rowdns->nm_sk;
                    $header  = $rowdns->header;
                    $kd_org = $rowdns->kd_org;
        } 
        if($doc=='RKA'){
            $rka="RENCANA KERJA DAN ANGGARAN";
        }else{
            $rka="DOKUMEN PELAKSANAAN ANGGARAN";
        }
        $cRet='';
        $cRet .="<table style='border-collapse:collapse;font-size:12px' width='100%' align='center' border='1' cellspacing='0' cellpadding='0'>
                    <tr> 
                         <td colspan='1' width='80%' align='center'><strong>$rka <br> SATUAN KERJA PERANGKAT DAERAH</strong></td>
                         <td colspan='1' width='20%' rowspan='4' align='center'><strong>$doc - SKPD</strong></td>
                    </tr>
                    <tr>
                         <td colspan='1' align='center'><strong>$kab <br>TAHUN ANGGARAN $thn</strong> </td>
                    </tr>
                </table>";

        $cRet .="<table style='border-collapse:collapse;font-size:12px' width='100%' align='left' border='1' cellpadding='5px'>
                    <tr>
                        <td style='border-right:none'> Organisasi</td>
                        <td style='border-left:none'>: $kd_skpd - $nm_skpd</td>
                    </tr>
                    <tr>
                        <td colspan='2' bgcolor='#CCCCCC'> &nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan='2' align='center'><strong>Ringkasan Anggaran Pendapatan dan Belanja<br>Satuan Kerja Perangkat Daerah </strong></td>
                    </tr>
                </table>";
        $cRet .= "<table style='border-collapse:collapse;font-size:12px' width='100%' align='center' border='1' cellspacing='0' cellpadding='5px'>
                     <thead>                       
                        <tr><td bgcolor='#CCCCCC' width='10%' align='center'><b>KODE REKENING</b></td>                            
                            <td bgcolor='#CCCCCC' width='70%' align='center'><b>URAIAN</b></td>
                            <td bgcolor='#CCCCCC' width='20%' align='center'><b>JUMLAH(Rp.)</b></td></tr>
                     </thead>
                     
                        <tr><td style='vertical-align:top;border-top: none;border-bottom: none;' width='10%' align='center'>1</td>                            
                            <td style='vertical-align:top;border-top: none;border-bottom: none;' width='70%' align='center'>2</td>
                            <td style='vertical-align:top;border-top: none;border-bottom: none;' width='20%' align='center'>3</td>
                        </tr>

                ";

        if($detail=='detail'){
            $rincian="  UNION ALL 

                        SELECT a.kd_rek4 AS kd_rek,a.nm_rek4 AS nm_rek ,
                        SUM(b.nilai) AS nilai FROM ms_rek4 a INNER JOIN trdrka b ON a.kd_rek4=LEFT(b.kd_rek6,(len(a.kd_rek4)))
                        where left(b.kd_rek6,1)='4' and left(b.kd_skpd,20)=left('$id',20)  
                        GROUP BY a.kd_rek4, a.nm_rek4  
                        UNION ALL 

                        SELECT a.kd_rek5 AS kd_rek,a.nm_rek5 AS nm_rek ,
                        SUM(b.nilai) AS nilai FROM ms_rek5 a INNER JOIN trdrka b ON a.kd_rek5=LEFT(b.kd_rek6,(len(a.kd_rek5)))
                        where left(b.kd_rek6,1)='4' and left(b.kd_skpd,20)=left('$id',20) 
                        GROUP BY a.kd_rek5, a.nm_rek5 
                        UNION ALL 

                        SELECT a.kd_rek6 AS kd_rek,a.nm_rek6 AS nm_rek ,
                        SUM(b.nilai) AS nilai FROM ms_rek6 a INNER JOIN trdrka b ON a.kd_rek6=LEFT(b.kd_rek6,(len(a.kd_rek6)))
                        where left(b.kd_rek6,1)='4' and left(b.kd_skpd,20)=left('$id',20) 
                        GROUP BY a.kd_rek6, a.nm_rek6";
        }else{ $rincian='';}
        
        $sql1="SELECT a.kd_rek1 AS kd_rek, a.nm_rek1 AS nm_rek ,SUM(b.nilai) AS nilai FROM ms_rek1 a 
                INNER JOIN trdrka b ON a.kd_rek1=LEFT(b.kd_rek6,(len(a.kd_rek1))) where left(b.kd_rek6,1)='4' 
                and left(b.kd_skpd,20)=left('$id',20) GROUP BY a.kd_rek1, a.nm_rek1 

                UNION ALL 

                SELECT a.kd_rek2 AS kd_rek,a.nm_rek2 AS nm_rek ,SUM(b.nilai) AS nilai FROM ms_rek2 a INNER JOIN trdrka b 
                ON a.kd_rek2=LEFT(b.kd_rek6,(len(a.kd_rek2))) where left(b.kd_rek6,1)='4' and left(b.kd_skpd,20)=left('$id',20) 
                GROUP BY a.kd_rek2,a.nm_rek2 

                UNION ALL 

                SELECT a.kd_rek3 AS kd_rek,a.nm_rek3 AS nm_rek, SUM(b.nilai) AS nilai FROM ms_rek3 a INNER JOIN trdrka b ON a.kd_rek3=LEFT(b.kd_rek6,(len(a.kd_rek3)))
                where left(b.kd_rek6,1)='4' and left(b.kd_skpd,20)=left('$id',20) 
                GROUP BY a.kd_rek3, a.nm_rek3 
                $rincian
                ORDER BY kd_rek";
                 
        $query = $this->db->query($sql1);
        if ($query->num_rows() > 0){                                  
            foreach ($query->result() as $row){
                    $coba1=$this->support->dotrek($row->kd_rek);
                    $coba2=$row->nm_rek;
                    $coba3= number_format($row->nilai,"2",",",".");
                   
                    $cRet.= " <tr>
                                <td style='vertical-align:top;border-top: solid 1px black;border-bottom: none;' width='10%' align='left'>&nbsp;$coba1</td>                                     
                                <td style='vertical-align:top;border-top: solid 1px black;border-bottom: none;' width='70%'>&nbsp;$coba2</td>
                                <td style='vertical-align:top;border-top: solid 1px black;border-bottom: none;' width='20%' align='right'>&nbsp;$coba3</td>
                             </tr>";                     
            }
        }else{
                $cRet .= " <tr>
                            <td style='vertical-align:top;border-top: solid 1px black;border-bottom: none;' width='10%' align='left'>4</td>                                     
                            <td style='vertical-align:top;border-top: solid 1px black;border-bottom: none;' width='70%'>PENDAPATAN</td>
                            <td style='vertical-align:top;border-top: solid 1px black;border-bottom: none;' width='20%' align='right'>".number_format(0,"2",",",".")."</td>
                          </tr>";
                    
                
        }                                 
                
        $sqltp="SELECT SUM(nilai) AS totp FROM trdrka WHERE LEFT(kd_rek6,1)='4' and left(kd_skpd,20)=left('$id',20)";
        $sqlp=$this->db->query($sqltp);
        foreach ($sqlp->result() as $rowp){

            $coba4=number_format($rowp->totp,"2",",",".");
            $cob1=$rowp->totp;
                   
            $cRet    .= "<tr>
                            <td style='vertical-align:top;border-top: solid 1px black;border-bottom: none;' width='10%' align='left'></td>                                     
                            <td style='vertical-align:top;border-top: solid 1px black;border-bottom: none;' width='70%' align='right'>Jumlah Pendapatan</td>
                            <td style='vertical-align:top;border-top: solid 1px black;border-bottom: none;' width='20%' align='right'>$coba4</td>
                        </tr>
                        <tr>
                            <td style='vertical-align:top;border-top: solid 1px black;border-bottom: none;' width='10%' align='left'></td>                                     
                            <td style='vertical-align:top;border-top: solid 1px black;border-bottom: none;' width='70%'>&nbsp;</td>
                            <td style='vertical-align:top;border-top: solid 1px black;border-bottom: none;' width='20%' align='right'></td>
                        </tr>";
        }

        if($gaji==1){
            $aktifkanGaji="and right(b.kd_sub_kegiatan,10) <> '01.2.02.01' ";
        }else{
            $aktifkanGaji="";
        }

        if($detail=='detail'){
            $rincian="  UNION ALL 
                        SELECT a.kd_rek4 AS kd_rek,a.kd_rek4 AS rek,a.nm_rek4 AS nm_rek ,SUM(b.nilai) AS nilai FROM ms_rek4 a 
                        INNER JOIN trdrka b ON a.kd_rek4=LEFT(b.kd_rek6,(len(a.kd_rek4))) WHERE LEFT(kd_rek6,1)='5' AND left(b.kd_skpd,20)=left('$id',20) $aktifkanGaji
                        GROUP BY a.kd_rek4, a.nm_rek4 
                        UNION ALL 
                        SELECT a.kd_rek5 AS kd_rek,a.kd_rek5 AS rek,a.nm_rek5 AS nm_rek ,SUM(b.nilai) AS nilai FROM ms_rek5 a 
                        INNER JOIN trdrka b ON a.kd_rek5=LEFT(b.kd_rek6,(len(a.kd_rek5))) WHERE LEFT(kd_rek6,1)='5' AND left(b.kd_skpd,20)=left('$id',20) $aktifkanGaji
                        GROUP BY a.kd_rek5, a.nm_rek5 
                        UNION ALL 
                        SELECT a.kd_rek6 AS kd_rek,a.kd_rek6 AS rek,a.nm_rek6 AS nm_rek ,SUM(b.nilai) AS nilai FROM ms_rek6 a 
                        INNER JOIN trdrka b ON a.kd_rek6=b.kd_rek6 WHERE LEFT(b.kd_rek6,1)='5' AND left(b.kd_skpd,20)=left('$id',20) $aktifkanGaji
                        GROUP BY a.kd_rek6, a.nm_rek6";
        }else{ $rincian='';}     
                $sql2="SELECT a.kd_rek1 AS kd_rek, a.kd_rek1 AS rek, a.nm_rek1 AS nm_rek ,SUM(b.nilai) AS nilai FROM ms_rek1 a 
                        INNER JOIN trdrka b ON a.kd_rek1=LEFT(b.kd_rek6,(len(a.kd_rek1))) WHERE LEFT(kd_rek6,1)='5' AND left(b.kd_skpd,20)=left('$id',20) $aktifkanGaji
                        GROUP BY a.kd_rek1, a.nm_rek1 
                        UNION ALL 
                        SELECT a.kd_rek2 AS kd_rek,a.kd_rek2 AS rek,a.nm_rek2 AS nm_rek ,SUM(b.nilai) AS nilai FROM ms_rek2 a 
                        INNER JOIN trdrka b ON a.kd_rek2=LEFT(b.kd_rek6,(len(a.kd_rek2))) WHERE LEFT(kd_rek6,1)='5' AND left(b.kd_skpd,20)=left('$id',20) $aktifkanGaji
                        GROUP BY a.kd_rek2,a.nm_rek2 
                        UNION ALL 
                        SELECT a.kd_rek3 AS kd_rek,a.kd_rek3 AS rek,a.nm_rek3 AS nm_rek ,SUM(b.nilai) AS nilai FROM ms_rek3 a 
                        INNER JOIN trdrka b ON a.kd_rek3=LEFT(b.kd_rek6,(len(a.kd_rek3))) WHERE LEFT(kd_rek6,1)='5' AND left(b.kd_skpd,20)=left('$id',20) $aktifkanGaji
                        GROUP BY a.kd_rek3, a.nm_rek3 
                        $rincian
                        ORDER BY kd_rek
                        ";
                 
                 $query1 = $this->db->query($sql2);
                 foreach ($query1->result() as $row1)
                {
                    $coba5=$this->support->dotrek($row1->rek);
                    $coba6=$row1->nm_rek;
                    $coba7= number_format($row1->nilai,"2",",",".");
                   
                     $cRet    .= " <tr><td style='vertical-align:top;' width='10%' align='left'>&nbsp;$coba5</td>                                     
                                     <td style='vertical-align:top;' width='70%'>&nbsp;$coba6</td>
                                     <td style='vertical-align:top;' width='20%' align='right'>&nbsp;$coba7</td></tr>";
                }

                if($gaji==1){
                    $aktifkanGaji="and right(kd_sub_kegiatan,10) <> '01.2.02.01' ";
                }else{
                    $aktifkanGaji="";
                }     

                $sqltb="SELECT SUM(nilai) AS totb FROM trdrka WHERE LEFT(kd_rek6,1)='5' and left(kd_skpd,20)=left('$id',20) $aktifkanGaji";
                $sqlb=$this->db->query($sqltb);
                foreach ($sqlb->result() as $rowb)
                {
                   $coba8=number_format($rowb->totb,"2",",",".");
                    $cob=$rowb->totb;
                    $cRet    .= " <tr><td style='vertical-align:top;' width='10%' align='left'></td>                                     
                                     <td style='vertical-align:top;' width='70%' align='right'>Jumlah Belanja</td>
                                     <td style='vertical-align:top;' width='20%' align='right'>$coba8</td></tr>";
                 }
                    $cRet    .= " <tr><td style='vertical-align:top;' width='10%' align='left'></td>                                     
                                     <td style='vertical-align:top;' width='70%' align='right'></td>
                                     <td style='vertical-align:top;' width='20%' align='right'>&nbsp;</td></tr>";

                  
                  $surplus=$cob1-$cob; 
                    $cRet    .= " <tr>                                     
                                     <td colspan='2' style='vertical-align:top;border-top: solid 1px black;' align='right' width='70%'>Surplus/Defisit</td>
                                     <td style='vertical-align:top;border-top: solid 1px black;' width='20%' align='right'>".$this->rka_model->angka($surplus)."</td></tr>"; 

                    
                $sqltpm="SELECT isnull(SUM(nilai),0) AS totb FROM trdrka WHERE LEFT(kd_rek6,1)='6' and left(kd_skpd,20)=left('$id',20)";
                $sqltpm=$this->db->query($sqltpm);
                foreach ($sqltpm->result() as $rowtpm)
                {
                   $coba12=number_format($rowtpm->totb,"2",",",".");
                    $cobtpm=$rowtpm->totb;
                    if($cobtpm>0){
                    $cRet    .= " <tr><td style='vertical-align:top;' width='10%' align='left'></td>                                     
                                     <td style='vertical-align:top;' width='70%' align='right'></td>
                                     <td style='vertical-align:top;' width='20%' align='right'>&nbsp;</td></tr>";

                        $cRet    .= "<tr>
                                        <td style='vertical-align:top;' width='10%' align='left'>6</td>                                     
                                         <td style='vertical-align:top;' width='70%'>Pembiayaan</td>
                                         <td style='vertical-align:top;' width='20%' align='right'>$coba12</td>
                                    </tr>";
                        if($detail=='detail'){
                            $rincian="  UNION ALL 
                                        SELECT a.kd_rek4 AS kd_rek,a.kd_rek4 AS rek,a.nm_rek4 AS nm_rek ,SUM(b.nilai) AS nilai FROM ms_rek4 a 
                                        INNER JOIN trdrka b ON a.kd_rek4=LEFT(b.kd_rek6,(len(a.kd_rek4))) WHERE LEFT(kd_rek6,2)='61' AND left(b.kd_skpd,20)=left('$id',20) 
                                        GROUP BY a.kd_rek4, a.nm_rek4 
                                        UNION ALL 
                                        SELECT a.kd_rek5 AS kd_rek,a.kd_rek5 AS rek,a.nm_rek5 AS nm_rek ,SUM(b.nilai) AS nilai FROM ms_rek5 a 
                                        INNER JOIN trdrka b ON a.kd_rek5=LEFT(b.kd_rek6,(len(a.kd_rek5))) WHERE LEFT(kd_rek6,2)='61' AND left(b.kd_skpd,20)=left('$id',20) 
                                        GROUP BY a.kd_rek5, a.nm_rek5 
                                        UNION ALL 
                                        SELECT a.kd_rek6 AS kd_rek,a.kd_rek6 AS rek,a.nm_rek6 AS nm_rek ,SUM(b.nilai) AS nilai FROM ms_rek6 a 
                                        INNER JOIN trdrka b ON a.kd_rek6=b.kd_rek6 WHERE LEFT(b.kd_rek6,2)='61' AND left(b.kd_skpd,20)=left('$id',20) 
                                        GROUP BY a.kd_rek6, a.nm_rek6 ";
                        }else{$rincian='';}

                        $sqlpm="
                        SELECT a.kd_rek2 AS kd_rek,a.kd_rek2 AS rek,a.nm_rek2 AS nm_rek ,SUM(b.nilai) AS nilai FROM ms_rek2 a 
                        INNER JOIN trdrka b ON a.kd_rek2=LEFT(b.kd_rek6,(len(a.kd_rek2))) WHERE LEFT(kd_rek6,2)='61' AND left(b.kd_skpd,20)=left('$id',20) GROUP BY a.kd_rek2,a.nm_rek2 
                        UNION ALL 
                        SELECT a.kd_rek3 AS kd_rek,a.kd_rek3 AS rek,a.nm_rek3 AS nm_rek ,SUM(b.nilai) AS nilai FROM ms_rek3 a 
                        INNER JOIN trdrka b ON a.kd_rek3=LEFT(b.kd_rek6,(len(a.kd_rek3))) WHERE LEFT(kd_rek6,2)='61' AND left(b.kd_skpd,20)=left('$id',20) 
                        GROUP BY a.kd_rek3, a.nm_rek3 
                        $rincian
                        ORDER BY kd_rek
                        ";
                 
                         $querypm = $this->db->query($sqlpm);
                         foreach ($querypm->result() as $rowpm)
                        {
                            $coba9=$this->support->dotrek($rowpm->rek);
                            $coba10=$rowpm->nm_rek;
                            $coba11= number_format($rowpm->nilai,"2",",",".");
                           
                             $cRet    .= " <tr><td style='vertical-align:top;border-top: solid 1px black;' width='10%' align='left'>$coba9</td>                                     
                                             <td style='vertical-align:top;border-top: solid 1px black;' width='70%'>$coba10</td>
                                             <td style='vertical-align:top;border-top: solid 1px black;' width='20%' align='right'>$coba11</td></tr>";
                        } 


                        $sqltpm="SELECT SUM(nilai) AS totb FROM trdrka WHERE LEFT(kd_rek6,2)='61' and left(kd_skpd,20)=left('$id',20)";
                                            $sqltpm=$this->db->query($sqltpm);
                                         foreach ($sqltpm->result() as $rowtpm)
                                        {
                                           $coba12=number_format($rowtpm->totb,"2",",",".");
                                            $cobtpm=$rowtpm->totb;
                                            $cRet    .= " <tr><td style='vertical-align:top;border-top: solid 1px black;' width='10%' align='left'></td>                                     
                                                             <td style='vertical-align:top;border-top: solid 1px black;' width='70%' align='right'>Jumlah Penerimaan Pembiayaan</td>
                                                             <td style='vertical-align:top;border-top: solid 1px black;' width='20%' align='right'>$coba12</td></tr>";
                                         } 

                        if($detail=='detail'){
                            $rincian="  UNION ALL 
                                        SELECT a.kd_rek4 AS kd_rek,a.kd_rek4 AS rek,a.nm_rek4 AS nm_rek ,SUM(b.nilai) AS nilai FROM ms_rek4 a 
                                        INNER JOIN trdrka b ON a.kd_rek4=LEFT(b.kd_rek6,(len(a.kd_rek4))) WHERE LEFT(kd_rek6,2)='62' AND left(b.kd_skpd,20)=left('$id',20) 
                                        GROUP BY a.kd_rek4, a.nm_rek4 
                                        UNION ALL 
                                        SELECT a.kd_rek5 AS kd_rek,a.kd_rek5 AS rek,a.nm_rek5 AS nm_rek ,SUM(b.nilai) AS nilai FROM ms_rek5 a 
                                        INNER JOIN trdrka b ON a.kd_rek5=LEFT(b.kd_rek6,(len(a.kd_rek5))) WHERE LEFT(kd_rek6,2)='62' AND left(b.kd_skpd,20)=left('$id',20) 
                                        GROUP BY a.kd_rek5, a.nm_rek5 
                                        UNION ALL 
                                        SELECT a.kd_rek6 AS kd_rek,a.kd_rek6 AS rek,a.nm_rek6 AS nm_rek ,SUM(b.nilai) AS nilai FROM ms_rek6 a 
                                        INNER JOIN trdrka b ON a.kd_rek6=b.kd_rek6 WHERE LEFT(b.kd_rek6,2)='62' AND left(b.kd_skpd,20)=left('$id',20) 
                                        GROUP BY a.kd_rek6, a.nm_rek6 ";
                        }else{$rincian='';}

                        $sqlpk="
                        SELECT a.kd_rek2 AS kd_rek,a.kd_rek2 AS rek,a.nm_rek2 AS nm_rek ,SUM(b.nilai) AS nilai FROM ms_rek2 a 
                        INNER JOIN trdrka b ON a.kd_rek2=LEFT(b.kd_rek6,(len(a.kd_rek2))) WHERE LEFT(kd_rek6,2)='62' AND left(b.kd_skpd,20)=left('$id',20) GROUP BY a.kd_rek2,a.nm_rek2 
                        UNION ALL 
                        SELECT a.kd_rek3 AS kd_rek,a.kd_rek3 AS rek,a.nm_rek3 AS nm_rek ,SUM(b.nilai) AS nilai FROM ms_rek3 a 
                        INNER JOIN trdrka b ON a.kd_rek3=LEFT(b.kd_rek6,(len(a.kd_rek3))) WHERE LEFT(kd_rek6,2)='62' AND left(b.kd_skpd,20)=left('$id',20) 
                        GROUP BY a.kd_rek3, a.nm_rek3 
                        $rincian
                        ORDER BY kd_rek";
                 
                         $querypk= $this->db->query($sqlpk);
                         foreach ($querypk->result() as $rowpk){
                            $coba9=$this->support->dotrek($rowpk->rek);
                            $coba10=$rowpk->nm_rek;
                            $coba11= number_format($rowpk->nilai,"2",",",".");
                           
                             $cRet    .= " <tr><td style='vertical-align:top;border-top: solid 1px black;' width='10%' align='left'>$coba9</td>                                     
                                             <td style='vertical-align:top;border-top: solid 1px black;' width='70%'>$coba10</td>
                                             <td style='vertical-align:top;border-top: solid 1px black;' width='20%' align='right'>$coba11</td></tr>";
                        } 


                        $sqltpk="SELECT SUM(nilai) AS totb FROM trdrka WHERE LEFT(kd_rek6,2)='62' and left(kd_skpd,20)=left('$id',20)";
                    $sqltpk=$this->db->query($sqltpk);
                 foreach ($sqltpk->result() as $rowtpk)
                {
                   $cobatpk=number_format($rowtpk->totb,"2",",",".");
                    $cobtpk=$rowtpk->totb;
                    $cRet    .= " <tr><td style='vertical-align:top;border-top: solid 1px black;' width='10%' align='left'></td>                                     
                                     <td style='vertical-align:top;border-top: solid 1px black;' width='70%' align='right'>Jumlah Pengeluaran Pembiayaan</td>
                                     <td style='vertical-align:top;border-top: solid 1px black;' width='20%' align='right'>$cobatpk</td></tr>";
                 }
    
                $pnetto=$cobtpm-$cobtpk;
                    $cRet    .= " <tr>                                     
                                     <td colspan='2' style='vertical-align:top;border-top: solid 1px black;' align='right' width='70%'>Pembiayaan Netto</td>
                                     <td style='vertical-align:top;border-top: solid 1px black;' width='20%' align='right'>".$this->rka_model->angka($pnetto)."</td></tr></table>";                                                      
                    

                    } /*end if pembiayaan 0*/

                } 
                  
                $cRet    .= "</table>";
        if($ttd1!='tanpa'){
            $sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab, pangkat as pangkat FROM ms_ttd WHERE kode in ('PA','KPA') AND id='$ttd1' ";
            $sqlttd=$this->db->query($sqlttd1);
            foreach ($sqlttd->result() as $rowttd){
                        $nip=$rowttd->nip;  
                        $pangkat=$rowttd->pangkat;  
                        $nama= $rowttd->nm;
                        $jabatan  = $rowttd->jab;
            }
                    

            $cRet.="<table width='100%' style='border-collapse:collapse;font-size:12px'>
                        <tr>
                            <td width='50%' align='center'>

                            </td>
                            <td width='50%' align='center'>
                                <br>$daerah, $tanggal_ttd <br>
                                $jabatan 
                                <br><br>
                                <br><br>
                                <br><br>
                                <b>$nama</b><br>
                                <u>$nip</u>
                            </td>

                        </tr>
                    </table>";    
        }
       
        $data['prev']= $cRet;    
        $judul         = 'RKA SKPD';
        switch($cetak) { 
        case 1;
             $this->master_pdf->_mpdf('',$cRet,10,10,10,'0');
        break;
        case 2;        
            header("Cache-Control: no-cache, no-store, must-revalidate");
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename= $judul.xls");
            //$this->load->view('anggaran/rka/perkadaII', $data);
        break;
        case 3;     
            header("Cache-Control: no-cache, no-store, must-revalidate");
            header("Content-Type: application/vnd.ms-word");
            header("Content-Disposition: attachment; filename= $judul.doc");
            $this->load->view('anggaran/rka/perkadaII', $data);
        break;
        case 0;
        echo ("<title>RKA SKPD</title>");
        echo($cRet);
        break;
        }
                
    } 

    function preview_pendapatan_penyusunan($tgl_ttd,$ttd1,$ttd2,$id,$cetak,$doc){
        
        $tanggal_ttd = $this->support->tanggal_format_indonesia($tgl_ttd);
        $sqldns="SELECT a.kd_urusan as kd_u,b.nm_bidang_urusan as nm_u,a.kd_skpd as kd_sk,a.nm_skpd as nm_sk FROM ms_skpd a INNER JOIN ms_bidang_urusan b ON a.kd_urusan=b.kd_bidang_urusan WHERE kd_skpd='$id'";
                 $sqlskpd=$this->db->query($sqldns);
                 foreach ($sqlskpd->result() as $rowdns)
                {
                    $kd_urusan=$rowdns->kd_u;                    
                    $nm_urusan= $rowdns->nm_u;
                    $kd_skpd  = $rowdns->kd_sk;
                    $nm_skpd  = $rowdns->nm_sk;
                }
        $sqldns="SELECT a.kd_urusan as kd_u,'' as header, LEFT(a.kd_skpd,20) as kd_org,b.nm_bidang_urusan as nm_u, a.kd_skpd as kd_sk,a.nm_skpd as nm_sk  FROM ms_skpd a INNER JOIN ms_bidang_urusan b ON a.kd_urusan=b.kd_bidang_urusan WHERE kd_skpd='$id'";
                 $sqlskpd=$this->db->query($sqldns);
                 foreach ($sqlskpd->result() as $rowdns)
                {
                    $kd_urusan=$rowdns->kd_u;                    
                    $nm_urusan= $rowdns->nm_u;
                    $kd_skpd  = $rowdns->kd_sk;
                    $nm_skpd  = $rowdns->nm_sk;
                    $header  = $rowdns->header;
                    $kd_org = $rowdns->kd_org;
                }


        $sqlsc="SELECT tgl_rka,provinsi,kab_kota,daerah,thn_ang FROM sclient where kd_skpd='$id'";
                 $sqlsclient=$this->db->query($sqlsc);
                 foreach ($sqlsclient->result() as $rowsc)
                {
                   
                    $tgl=$rowsc->tgl_rka;
                    $kab     = $rowsc->kab_kota;
                    $daerah  = $rowsc->daerah;
                    $thn     = $rowsc->thn_ang;
                }

        
        if($doc=='RKA'){
            $dokumen="RENCANA KERJA DAN ANGGARAN";
        }else{
            $dokumen="DOKUMEN PELAKSANAAN ANGGARAN";
        }
        $cRet='';
        $cRet .="<table style='border-collapse:collapse;font-size:14px' width='100%' align='center' border='1' cellspacing='0' cellpadding='4'>
                    <tr>  
                         <td width='80%' align='center'><strong>$dokumen <br /> SATUAN KERJA PERANGKAT DAERAH</strong></td>
                         <td width='20%' rowspan='2' align='center'><strong>$doc - <br />PENDAPATAN SKPD  </strong></td>
                    </tr>
                    <tr>
                         <td align='center'><strong>$kab <br /> TAHUN ANGGARAN $thn</strong> </td>
                    </tr>

                  </table>";
        $cRet .="<table style='border-collapse:collapse;font-size:12px' width='100%' align='left' border='1', cellpadding='5px'>
                    <tr>
                        <td width='20%' style='border-right:none'>Organisasi </td>
                        <td width='80%' style='border-left:none'>: $kd_org -".$this->rka_model->get_nama($id,'nm_skpd','ms_skpd','kd_skpd')."</td>
                    </tr>
                    <tr>
                        <td bgcolor='#CCCCCC' colspan='2'>&nbsp;</td>
                       
                    </tr>
                    <tr>
                        <td colspan='2' align='center'><strong>Ringkasan Anggaran Pendapatan Satuan Kerja Perangkat Daerah </strong></td>
                    </tr>
                </table>";
        $cRet .= "<table style='border-collapse:collapse;font-size:12px' width='100%' align='center' border='1' cellspacing='0' cellpadding='4'>
                     <thead>                       
                        <tr><td rowspan='2' bgcolor='#CCCCCC' width='10%' align='center'><b>Kode Rekening</b></td>                            
                            <td rowspan='2' bgcolor='#CCCCCC' width='40%' align='center'><b>Uraian</b></td>
                            <td colspan='3' bgcolor='#CCCCCC' width='30%' align='center'><b>Rincian Perhitungan</b></td>
                            <td rowspan='2' bgcolor='#CCCCCC' width='20%' align='center'><b>Jumlah(Rp.)</b></td></tr>
                        <tr>
                            <td width='8%' bgcolor='#CCCCCC' align='center'>Volume</td>
                            <td width='8%' bgcolor='#CCCCCC' align='center'>Satuan</td>
                            <td width='14%' bgcolor='#CCCCCC' align='center'>Tarif/harga</td>
                        </tr>    
                     </thead>
                    
                     
                        <tr><td style='vertical-align:top;border-top: none;border-bottom: none;' width='10%' align='center'>&nbsp;</td>                            
                            <td style='vertical-align:top;border-top: none;border-bottom: none;' width='40%'>&nbsp;</td>
                            <td style='vertical-align:top;border-top: none;border-bottom: none;' width='8%'>&nbsp;</td>
                            <td style='vertical-align:top;border-top: none;border-bottom: none;' width='8%'>&nbsp;</td>
                            <td style='vertical-align:top;border-top: none;border-bottom: none;' width='14%'>&nbsp;</td>
                            <td style='vertical-align:top;border-top: none;border-bottom: none;' width='20%'>&nbsp;</td></tr>
                        ";
                 $sql1="SELECT * FROM(
                        SELECT LEFT(a.kd_rek6,1)AS rek1,LEFT(a.kd_rek6,1)AS rek,b.nm_rek1 AS nama ,0 AS volume,' 'AS satuan, 0 AS harga,SUM(a.nilai) AS nilai,'1' AS id FROM trdrka a 
                        INNER JOIN ms_rek1 b ON LEFT(a.kd_rek6,1)=b.kd_rek1 WHERE LEFT(a.kd_rek6,1)='4' AND left(a.kd_skpd,20)=left('$id',20) GROUP BY LEFT(a.kd_rek6,1),nm_rek1 
                        UNION ALL 
                        SELECT LEFT(a.kd_rek6,2) AS rek1,LEFT(a.kd_rek6,2) AS rek,b.nm_rek2 AS nama, 0 AS volume,' 'AS satuan, 0 AS harga,SUM(a.nilai) AS nilai,'2' AS id 
                        FROM trdrka a INNER JOIN ms_rek2 b ON LEFT(a.kd_rek6,2)=b.kd_rek2 WHERE LEFT(a.kd_rek6,1)='4' AND left(a.kd_skpd,20)=left('$id',20) GROUP BY LEFT(a.kd_rek6,2),nm_rek2 
                        UNION ALL 
                        SELECT LEFT(a.kd_rek6,4) AS rek1,LEFT(a.kd_rek6,4) AS rek,b.nm_rek3 AS nama,0 AS volume,' 'AS satuan, 0 AS harga,SUM(a.nilai) AS nilai,'3' AS id 
                        FROM trdrka a INNER JOIN ms_rek3 b ON LEFT(a.kd_rek6,4)=b.kd_rek3 WHERE LEFT(a.kd_rek6,1)='4' AND left(a.kd_skpd,20)=left('$id',20) GROUP BY LEFT(a.kd_rek6,4),nm_rek3 
                        UNION ALL 
                        SELECT LEFT(a.kd_rek6,6) AS rek1,LEFT(a.kd_rek6,6) AS rek,b.nm_rek4 AS nama,0 AS volume,' 'AS satuan, 0 AS harga,SUM(a.nilai) AS nilai,'4' AS id 
                        FROM trdrka a INNER JOIN ms_rek4 b ON LEFT(a.kd_rek6,6)=b.kd_rek4 WHERE LEFT(a.kd_rek6,1)='4' AND left(a.kd_skpd,20)=left('$id',20) GROUP BY LEFT(a.kd_rek6,6),nm_rek4 
                        UNION ALL 
                        SELECT LEFT(a.kd_rek6,8) AS rek1,LEFT(a.kd_rek6,8) AS rek,b.nm_rek5 AS nama,0 AS volume,' 'AS satuan, 0 AS harga,SUM(a.nilai) AS nilai,'5' AS id 
                        FROM trdrka a INNER JOIN ms_rek5 b ON LEFT(a.kd_rek6,8)=b.kd_rek5 WHERE LEFT(a.kd_rek6,1)='4' AND left(a.kd_skpd,20)=left('$id',20) GROUP BY LEFT(a.kd_rek6,8),b.nm_rek5 
                        UNION ALL 
                        SELECT a.kd_rek6 AS rek1,a.kd_rek6 AS rek,b.nm_rek6 AS nama,0 AS volume,' 'AS satuan, 0 AS harga,SUM(a.nilai) AS nilai,'6' AS id 
                        FROM trdrka a INNER JOIN ms_rek6 b ON a.kd_rek6=b.kd_rek6 WHERE LEFT(a.kd_rek6,1)='4' AND left(a.kd_skpd,20)=left('$id',20) GROUP BY a.kd_rek6,b.nm_rek6 
                        UNION ALL 
                        SELECT RIGHT(a.no_trdrka,12) AS rek1,' 'AS rek,a.uraian AS nama,a.volume1 AS volume,a.satuan1 AS satuan, a.harga1 AS harga,a.total AS nilai,'7' AS id 
                        FROM trdpo a WHERE LEFT(a.no_trdrka,20)=left('$id',20)
                        AND SUBSTRING(no_trdrka,38,1)='4' 
                        ) a ORDER BY a.rek1,a.id";
                 
                $query = $this->db->query($sql1);
                  if ($query->num_rows() > 0){                                  
               
                                                 
                foreach ($query->result() as $row)
                {
                    $rek=$row->rek;
                    $reke=$this->support->dotrek($rek);
                    $uraian=$row->nama;
                    $volum=$row->volume;
                    $sat=$row->satuan;
                    $hrg= empty($row->harga) || $row->harga == 0 ? '' :number_format($row->harga,2,',','.');
                    $nila= number_format($row->nilai,"2",",",".");
                   
                        
                    if($reke!=' '){
                        $volum = '';
                    }
                    
                     $cRet    .= " <tr><td style='vertical-align:top;' width='10%' align='left'>$reke</td>                                     
                                     <td style='vertical-align:top;' width='40%'>$uraian</td>
                                     <td style='vertical-align:top;' width='8%'>$volum</td>
                                     <td style='vertical-align:top;' width='8%'>$sat</td>
                                     <td style='vertical-align:top;' width='14%' align='right'>$hrg</td>
                                     <td style='vertical-align:top;' width='20%' align='right'>$nila</td></tr>
                                     ";
                }
                      }else{
                     $cRet    .= " <tr><td style='vertical-align:top;' width='10%' align='left'>4</td>                                     
                                     <td style='vertical-align:top;' width='40%'>PENDAPATAN</td>
                                     <td style='vertical-align:top;' width='8%'></td>
                                     <td style='vertical-align:top;' width='8%'></td>
                                     <td style='vertical-align:top;' width='14%' align='right'></td>
                                     <td style='vertical-align:top;' width='20%' align='right'>".number_format(0,"2",",",".")."</td></tr>
                                     ";
                    
                }


                   $cRet .= "<tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td align='right'>&nbsp;</td>
                             </tr>";
                 $sqltp="SELECT SUM(nilai) AS totp FROM trdrka WHERE LEFT(kd_rek6,1)='4' AND left(kd_skpd,20)=left('$id',20)";
                    $sqlp=$this->db->query($sqltp);
                 foreach ($sqlp->result() as $rowp)
                {
                   $totp=number_format($rowp->totp,"2",",",".");
                   
                    $cRet    .=" <tr><td style='vertical-align:top;border-top: solid 1px black;' width='10%' align='left'>&nbsp;</td>                                     
                                     <td style='vertical-align:top;border-top: solid 1px black;' width='40%'>Jumlah Pendapatan</td>
                                     <td style='vertical-align:top;border-top: solid 1px black;' width='8%'>&nbsp;</td>
                                     <td style='vertical-align:top;border-top: solid 1px black;' width='8%'>&nbsp;</td>
                                     <td style='vertical-align:top;border-top: solid 1px black;' width='14%' align='right'>&nbsp;</td>
                                     <td style='vertical-align:top;border-top: solid 1px black;' width='20%' align='right'>$totp</td></tr>";
                 }
            
        $cRet    .= "</table>";

        if($ttd1!='tanpa'){ /*end tanpa tanda tangan*/
        $sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab, pangkat FROM ms_ttd WHERE kd_skpd= '$id' AND kode in ('PA','KPA') AND id='$ttd1'  ";
                 $sqlttd1=$this->db->query($sqlttd1);
                 foreach ($sqlttd1->result() as $rowttd)
                {
                    $nip=$rowttd->nip;                    
                    $nama= $rowttd->nm;
                    $jabatan  = $rowttd->jab;
                    $pangkat  = $rowttd->pangkat;
                }
                
        $cRet .="<table style='border-collapse:collapse; font-size:12px' width='100%' align='center' border='1' cellspacing='0' cellpadding='4'>
                    <tr>
                        <td width='50%' align='center' style='border-right: none' ><br>

                        </td>
                        <td align='center' style='border-left: none'><br>
                            $daerah ,$tanggal_ttd<br>
                            $jabatan, <br>
                            <br><br>
                            <br><br>
                            <br><br>
                            <b>$nama</b><br>
                            $pangkat<br>
                            NIP. $nip 
                        </td>
                    </tr>
                   </table>";
         $cRet .= "<table style='border-collapse:collapse; font-size:12px' width='100%' align='center' border='1' cellspacing='0' cellpadding='4'><tr>
                                <td width='100%' align='left' colspan='6'>Keterangan :</td>
                            </tr>";
                  $cRet .= "<tr>
                                 <td width='100%' align='left' colspan='6'>Tanggal Pembahasan :</td>
                            </tr>";
                  $cRet .= "<tr>
                                <td width='100%' align='left' colspan='6'>Catatan Hasil Pembahasan :</td>
                            </tr>";
                  $cRet .= "<tr>
                                <td width='100%' align='left' colspan='6'>1.</td>
                            </tr>";
                  $cRet .= "<tr>
                                <td width='100%' align='left' colspan='6'>2.</td>
                            </tr>";
                  $cRet .= "<tr>
                                <td width='100%' align='left' colspan='6'>Dst</td>
                            </tr>";
                  $cRet .= "<tr>
                                <td width='100%' align='center' colspan='6'>Tim Anggaran Pemerintah Daerah</td>
                            </tr>";
                         
        $cRet    .= "</table>";
       $cRet    .="<table style='border-collapse:collapse; font-size:12px' width='100%' align='center' border='1' cellspacing='0' cellpadding='4'>
                    <tr>
                         <td width='10%' align='center'>No </td>
                         <td width='30%'  align='center'>Nama</td>
                         <td width='20%'  align='center'>NIP</td>
                         <td width='20%'  align='center'>Jabatan</td>
                         <td width='20%'  align='center'>Tandatangan</td>
                    </tr>";
                    $sqltim="SELECT nama as nama,nip as nip,jabatan as jab FROM tapd where kd_skpd='$id' order by no";
                     $sqltapd = $this->db->query($sqltim);
                  if ($sqltapd->num_rows() > 0){
                    
                    $no=1;
                    foreach ($sqltapd->result() as $rowtim)
                    {
                        $no=$no;                    
                        $nama= $rowtim->nama;
                        $nip= $rowtim->nip;
                        $jabatan  = $rowtim->jab;
                        $cRet .="<tr>
                         <td width='5%' align='left'>$no </td>
                         <td width='20%'  align='left'>$nama</td>
                         <td width='20%'  align='left'>$nip</td>
                         <td width='35%'  align='left'>$jabatan</td>
                         <td width='20%'  align='left'></td>
                    </tr>"; 
                    $no=$no+1;              
                  }}
                    else{
                        $cRet .="<tr>
                         <td width='5%' align='left'> &nbsp; </td>
                         <td width='20%'  align='left'></td>
                         <td width='20%'  align='left'></td>
                         <td width='35%'  align='left'></td>
                         <td width='20%'  align='left'></td>
                        </tr>"; 
                    }

        $cRet .=       " </table>";
        } /*end tanpa tanda tangan*/




        $data['prev']= $cRet;
        switch($cetak) { 
        case 1;
             $this->master_pdf->_mpdf('',$cRet,10,10,10,'0');
        break;
        case 2;        
            header("Cache-Control: no-cache, no-store, must-revalidate");
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename= $judul.xls");
            //$this->load->view('anggaran/rka/perkadaII', $data);
        break;
        case 3;     
            header("Cache-Control: no-cache, no-store, must-revalidate");
            header("Content-Type: application/vnd.ms-word");
            header("Content-Disposition: attachment; filename= $judul.doc");
            $this->load->view('anggaran/rka/perkadaII', $data);
        break;
        case 0;
        echo ("<title>RKA SKPD</title>");
        echo($cRet);
        break;
        }         
    }

    function preview_belanja_penyusunan($tgl_ttd,$ttd1,$ttd2,$id,$cetak,$doc){
        
        $tanggal_ttd = $this->support->tanggal_format_indonesia($tgl_ttd);
        $sqldns="SELECT a.kd_urusan as kd_u,'' as header, LEFT(a.kd_skpd,20) as kd_org,b.nm_bidang_urusan as nm_u, a.kd_skpd as kd_sk,a.nm_skpd as nm_sk  FROM ms_skpd a INNER JOIN ms_bidang_urusan b ON a.kd_urusan=b.kd_bidang_urusan WHERE kd_skpd='$id'";
                 $sqlskpd=$this->db->query($sqldns);
                 foreach ($sqlskpd->result() as $rowdns)
                {
                    $kd_urusan=$rowdns->kd_u;                    
                    $nm_urusan= $rowdns->nm_u;
                    $kd_skpd  = $rowdns->kd_sk;
                    $nm_skpd  = $rowdns->nm_sk;
                    $header  = $rowdns->header;
                    $kd_org = $rowdns->kd_org;
                }
        $sqlsc="SELECT tgl_rka,provinsi,kab_kota,daerah,thn_ang FROM sclient where kd_skpd='$id'";
                 $sqlsclient=$this->db->query($sqlsc);
                 foreach ($sqlsclient->result() as $rowsc)
                {
                   
                    $tgl=$rowsc->tgl_rka;
                    $kab     = $rowsc->kab_kota;
                    $daerah  = $rowsc->daerah;
                    $thn     = $rowsc->thn_ang;
                }
        if($doc=='RKA'){
            $dokumen="RENCANA KERJA DAN ANGGARAN";
        }else{
            $dokumen="DOKUMEN PELAKSANAAN ANGGARAN";
        }

        $ctk ="<table style='border-collapse:collapse;font-size:12px' width='100%' align='center' border='1' cellspacing='0' cellpadding='5px'>
                <tr>
                    <td width='80%' align='center'><b> $dokumen <br> SATUAN KERJA PERANGKAT DAERAH</td>
                    <td rowspan='2' width='20%' align='center'><b>$doc - BELANJA SKPD</td>
                </tr>
                <tr>
                    <td width='80%' align='center'><b> Kota $daerah <br> Tahun Anggaran $thn</td>
                </tr>
              </table>";

        $ctk .="<table style='border-collapse:collapse;font-size:12px' width='100%' align='center' border='1' cellspacing='0' cellpadding='0'>
                <tr>
                    <td width='20%' align='left' style='border-right:none'> Organisasi</td>
                    <td width='80%' align='left' style='border-left:none'>: $kd_skpd - $nm_skpd</td>
                </tr>
                <tr>
                    <td width='100%' colspan='2' bgcolor='#cccccc' align='left'>&nbsp;</td>
                </tr>
                <tr>
                    <td colspan='2' align='center'><b>Rekapitulasi Anggaran Belanja Berdasarkan Program dan Kegiatan</td>
                </tr>
              </table>";

        $ctk .="<table style='border-collapse:collapse;font-size:10px' width='100%' align='center' border='1' cellspacing='0' cellpadding='4'>
                <thead>
                <tr>
                    <td align='center' colspan='5'><b>Kode</td>
                    <td align='center' rowspan='3'><b>Uraian</td>
                    <td align='center' rowspan='3'><b>Sumber Dana</td>
                    <td align='center' rowspan='3'><b>Lokasi</td>
                    <td align='center' colspan='7'><b>Jumlah</td>                
                </tr>
                <tr>
                    <td align='center' rowspan='2'><b>Urusan</td>
                    <td align='center' rowspan='2'><b>Sub Urusan</td>
                    <td align='center' rowspan='2'><b>Program</td>
                    <td align='center' rowspan='2'><b>Kegiatan</td>
                    <td align='center' rowspan='2'><b>Sub Kegiatan</td>
                    <td align='center' rowspan='2'><b>T-1</td>
                    <td align='center' colspan='5'><b>T</td>
                    <td align='center' rowspan='2'><b>T+1</td>
                </tr>
                <tr>
                    <td align='center'><b>Blj. Operasi</td>
                    <td align='center'><b>Blj. Modal</td>
                    <td align='center'><b>Blj. Tak Terduga</td>
                    <td align='center'><b>Blj. Transfer</td>
                    <td align='center'><b>Jumlah</td>
                </tr>
                <tr bgcolor='#cccccc'>
                    <td align='center'><b>1</td>
                    <td align='center'><b>2</td>
                    <td align='center'><b>3</td>
                    <td align='center'><b>4</td>
                    <td align='center'><b>5</td>
                    <td align='center'><b>6</td>
                    <td align='center'><b>7</td>
                    <td align='center'><b>8</td>
                    <td align='center'><b>9</td>
                    <td align='center'><b>10</td>
                    <td align='center'><b>11</td>
                    <td align='center'><b>12</td>
                    <td align='center'><b>13</td>
                    <td align='center'><b>14</td>
                    <td align='center'><b>15</td>
                </tr>
                </thead>
                <tr>
                    <td colspan='15' bgcolor='#cccccc'>&nbsp;</td>
                </tr>";
            $tot51=0;
            $tot52=0;
            $tot53=0;
            $tot54=0;
            $total=0;
        $sumber="";
        $sql=$this->db->query("SELECT * from v_cetak_belanja where kd_skpd='$kd_skpd' ORDER BY urut");
        foreach($sql->result() as $a){
            $urusan =$a->urusan;
            $bid_urusan =$a->bid_urusan;
            $program =$a->program;
            $giat =$a->kegiatan;
            $subgiat =$a->subgiat;
            $nama =$a->nama;
            $sumber =$a->sumber;
            $lokasi =$a->lokasi;
            $operasi =$a->operasi;
            $modal =$a->modal;
            $terduga =$a->duga;
            $transfer =$a->trans;
            $Jumlah=$operasi+$modal+$terduga+$transfer;
            if($subgiat!=''){
                $tot51=0+$tot51+$operasi;
                $tot52=0+$tot52+$modal;
                $tot53=0+$tot53+$terduga;
                $tot54=0+$tot54+$transfer;
                $total=0+$total+$Jumlah;                
            }


        $ctk .="<tr>
                    <td align='left'>$urusan</td>
                    <td align='left'>$bid_urusan</td>
                    <td align='left'>$program</td>
                    <td align='left'>$giat</td>
                    <td align='left'>$subgiat</td>
                    <td align='left'>$nama</td>
                    <td align='left'>$sumber</td>
                    <td align='left'>$lokasi</td>
                    <td align='left'></td>
                    <td align='right'>&nbsp;".number_format($operasi,2,',','.')."</td>
                    <td align='right'>&nbsp;".number_format($modal,2,',','.')."</td>
                    <td align='right'>&nbsp;".number_format($terduga,2,',','.')."</td>
                    <td align='right'>&nbsp;".number_format($transfer,2,',','.')."</td>
                    <td align='right'>&nbsp;".number_format($Jumlah,2,',','.')."</td>
                    <td align='left'></td>
                </tr>";
        }
        $ctk .="<tr>
                    <td align='right' colspan='8'> &nbsp; TOTAL &nbsp;</td>
                    <td align='left'></td>
                    <td align='right'>".number_format($tot51,2,',','.')."</td>
                    <td align='right'>".number_format($tot52,2,',','.')."</td>
                    <td align='right'>".number_format($tot53,2,',','.')."</td>
                    <td align='right'>".number_format($tot54,2,',','.')."</td>
                    <td align='right'>".number_format($total,2,',','.')."</td>
                    <td align='left'></td>
                </tr>";
            $ctk .=  "</table>";
        if($ttd1!='tanpa'){ /* tanpa tanda tangan*/
        $sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab, pangkat FROM ms_ttd WHERE kd_skpd= '$id' AND kode in ('PA','KPA') AND id='$ttd1'  ";
                 $sqlttd1=$this->db->query($sqlttd1);
                 foreach ($sqlttd1->result() as $rowttd)
                {
                    $nip=$rowttd->nip;                    
                    $nama= $rowttd->nm;
                    $jabatan  = $rowttd->jab;
                    $pangkat  = $rowttd->pangkat;
                }
                
        $sqlttd2="SELECT nama as nm,nip as nip,jabatan as jab, pangkat FROM ms_ttd WHERE kode in ('PA','KPA') AND id='$ttd2'  ";
                 $sqlttd2=$this->db->query($sqlttd2);
                 foreach ($sqlttd2->result() as $rowttd2)
                {
                    $nip2=$rowttd2->nip;                    
                    $nama2= $rowttd2->nm;
                    $jabatan2  = $rowttd2->jab;
                    $pangkat2  = $rowttd2->pangkat;
                }
        $ctk .="<table style='border-collapse:collapse; font-size:12px' width='100%' align='center' border='1' cellspacing='0' cellpadding='4'>
                    <thead>
                    <tr>
                        <td align='right' colspan='2' bgcolor='#cccccc'> &nbsp;</td>
                    </tr>
                    </thead>                 
                    <tr>
                        <td align='center' style='border-right: none' ><br> &nbsp;</td>
                        <td align='center' style='border-left: none'><br>
                            $daerah ,$tanggal_ttd<br>
                            $jabatan, <br>
                            <br><br>
                            <br><br>
                            <br><br>
                            <b>$nama</b><br>
                            NIP. $nip 
                        </td>
                    </tr>
                   </table>";
       
    
        } /*end tanpa tanda tangan*/  
        switch($cetak) { 
        case 1;
             $this->master_pdf->_mpdf('',$ctk,10,10,10,'1');
        break;
        case 2;        
            header("Cache-Control: no-cache, no-store, must-revalidate");
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename= $judul.xls");
            //$this->load->view('anggaran/rka/perkadaII', $data);
        break;
        case 3;     
            header("Cache-Control: no-cache, no-store, must-revalidate");
            header("Content-Type: application/vnd.ms-word");
            header("Content-Disposition: attachment; filename= $judul.doc");
            $this->load->view('anggaran/rka/perkadaII', $data);
        break;
        case 0;
        echo ("<title>RKA SKPD</title>");
        echo($ctk);
        break;
        }     
    }

    function preview_rka_pembiayaan_penetapan($tgl_ttd,$ttd1,$ttd2,$id,$cetak,$detail,$tanggal_ttd,$doc){

       
        $sqlsc="SELECT tgl_rka,provinsi,kab_kota,daerah,thn_ang FROM sclient where kd_skpd='$id'";
        $sqlsclient=$this->db->query($sqlsc);
        foreach ($sqlsclient->result() as $rowsc){
                    $tgl=$rowsc->tgl_rka;
                    $kab     = $rowsc->kab_kota;
                    $daerah  = $rowsc->daerah;
                    $thn     = $rowsc->thn_ang;
        }


        $sqldns="SELECT a.kd_urusan as kd_u,left(b.kd_bidang_urusan,1) as header, LEFT(a.kd_skpd,20) as kd_org,b.nm_bidang_urusan as nm_u,a.kd_skpd as kd_sk,
                a.nm_skpd as nm_sk FROM ms_skpd a INNER JOIN ms_bidang_urusan b
                 ON a.kd_urusan=b.kd_bidang_urusan WHERE  kd_skpd='$id'";
        $sqlskpd=$this->db->query($sqldns);
        foreach ($sqlskpd->result() as $rowdns){
                    $kd_urusan=$rowdns->kd_u;                    
                    $nm_urusan= $rowdns->nm_u;
                    $kd_skpd  = $rowdns->kd_sk;
                    $nm_skpd  = $rowdns->nm_sk;
                    $header  = $rowdns->header;
                    $kd_org = $rowdns->kd_org;
        }
        if($doc=='RKA'){
            $rka="RENCANA KERJA DAN ANGGARAN";
        }else{
            $rka="DOKUMEN PELAKSANAAN ANGGARAN";
        }
        $cRet='';
        $cRet .="<table style='border-collapse:collapse;font-size:12px' width='100%' align='center' border='1' cellspacing='0' cellpadding='0'>
                    <tr> 
                         <td width='80%' align='center'><strong>$rka <br> SATUAN KERJA PERANGKAT DAERAH</strong></td>
                         <td width='20%' rowspan='4' align='center'><strong> <br>$doc - PEMBIAYAAN SKPD</strong></td>
                    </tr>
                    <tr>
                         <td align='center'><strong>$kab <br>TAHUN ANGGARAN $thn</strong> </td>
                    </tr>
                </table>";

        $cRet .="<table style='border-collapse:collapse;font-size:12px' width='100%' align='left' border='1'>
                    <tr>
                        <td colspan='2' align='center'><strong>RINCIAN ANGGARAN PEMBIAYAAN DAERAH</strong></td>
                    </tr>                   
                    <tr>
                        <td> Organisasi</td>
                        <td>$kd_skpd - $nm_skpd</td>
                    </tr>

                </table>";
        $cRet .= "<table style='border-collapse:collapse;font-size:12px' width='100%' align='center' border='1' cellspacing='0' cellpadding='0'>
                     <thead>                       
                        <tr><td bgcolor='#CCCCCC' width='10%' align='center'><b>KODE REKENING</b></td>                            
                            <td bgcolor='#CCCCCC' width='70%' align='center'><b>URAIAN</b></td>
                            <td bgcolor='#CCCCCC' width='20%' align='center'><b>JUMLAH(Rp.)</b></td></tr>
                     </thead>
                     
                        <tr><td style='vertical-align:top;border-top: none;border-bottom: none;' width='10%' align='center'>1</td>                            
                            <td style='vertical-align:top;border-top: none;border-bottom: none;' width='70%' align='center'>2</td>
                            <td style='vertical-align:top;border-top: none;border-bottom: none;' width='20%' align='center'>3</td>
                        </tr>
                ";

                $sqltpm="SELECT isnull(SUM(nilai),0) AS totb FROM trdrka WHERE LEFT(kd_rek6,1)='6' and left(kd_skpd,20)=left('$id',20)";
                $sqltpm=$this->db->query($sqltpm);
                foreach ($sqltpm->result() as $rowtpm)
                {
                   $coba12=number_format($rowtpm->totb,"2",",",".");
                    $cobtpm=$rowtpm->totb;
                    if($cobtpm>0){
                    $cRet    .= " <tr><td style='vertical-align:top;border-top: solid 1px black;border-bottom: none;' width='10%' align='left'></td>                                     
                                     <td style='vertical-align:top;border-top: solid 1px black;border-bottom: none;' width='70%' align='right'></td>
                                     <td style='vertical-align:top;border-top: solid 1px black;border-bottom: none;' width='20%' align='right'>&nbsp;</td></tr>";

                        $cRet    .= "<tr>
                                        <td style='vertical-align:top;border-top: solid 1px black;border-bottom: none;' width='10%' align='left'>6</td>                                     
                                         <td style='vertical-align:top;border-top: solid 1px black;border-bottom: none;' width='70%'>Pembiayaan</td>
                                         <td style='vertical-align:top;border-top: solid 1px black;border-bottom: none;' width='20%' align='right'>$coba12</td>
                                    </tr>";
                        if($detail=='detail'){
                            $rincian="  UNION ALL 
                                        SELECT a.kd_rek4 AS kd_rek,a.kd_rek4 AS rek,a.nm_rek4 AS nm_rek ,SUM(b.nilai) AS nilai FROM ms_rek4 a 
                                        INNER JOIN trdrka b ON a.kd_rek4=LEFT(b.kd_rek6,(len(a.kd_rek4))) WHERE LEFT(kd_rek6,2)='61' AND left(b.kd_skpd,20)=left('$id',20) 
                                        GROUP BY a.kd_rek4, a.nm_rek4 
                                        UNION ALL 
                                        SELECT a.kd_rek5 AS kd_rek,a.kd_rek5 AS rek,a.nm_rek5 AS nm_rek ,SUM(b.nilai) AS nilai FROM ms_rek5 a 
                                        INNER JOIN trdrka b ON a.kd_rek5=LEFT(b.kd_rek6,(len(a.kd_rek5))) WHERE LEFT(kd_rek6,2)='61' AND left(b.kd_skpd,20)=left('$id',20) 
                                        GROUP BY a.kd_rek5, a.nm_rek5 
                                        UNION ALL 
                                        SELECT a.kd_rek6 AS kd_rek,a.kd_rek6 AS rek,a.nm_rek6 AS nm_rek ,SUM(b.nilai) AS nilai FROM ms_rek6 a 
                                        INNER JOIN trdrka b ON a.kd_rek6=b.kd_rek6 WHERE LEFT(b.kd_rek6,2)='61' AND left(b.kd_skpd,20)=left('$id',20) 
                                        GROUP BY a.kd_rek6, a.nm_rek6 ";
                        }else{$rincian='';}

                        $sqlpm="
                        SELECT a.kd_rek2 AS kd_rek,a.kd_rek2 AS rek,a.nm_rek2 AS nm_rek ,SUM(b.nilai) AS nilai FROM ms_rek2 a 
                        INNER JOIN trdrka b ON a.kd_rek2=LEFT(b.kd_rek6,(len(a.kd_rek2))) WHERE LEFT(kd_rek6,2)='61' AND left(b.kd_skpd,20)=left('$id',20) GROUP BY a.kd_rek2,a.nm_rek2 
                        UNION ALL 
                        SELECT a.kd_rek3 AS kd_rek,a.kd_rek3 AS rek,a.nm_rek3 AS nm_rek ,SUM(b.nilai) AS nilai FROM ms_rek3 a 
                        INNER JOIN trdrka b ON a.kd_rek3=LEFT(b.kd_rek6,(len(a.kd_rek3))) WHERE LEFT(kd_rek6,2)='61' AND left(b.kd_skpd,20)=left('$id',20) 
                        GROUP BY a.kd_rek3, a.nm_rek3 
                        $rincian
                        ORDER BY kd_rek
                        ";
                 
                         $querypm = $this->db->query($sqlpm);
                         foreach ($querypm->result() as $rowpm)
                        {
                            $coba9=$this->support->dotrek($rowpm->rek);
                            $coba10=$rowpm->nm_rek;
                            $coba11= number_format($rowpm->nilai,"2",",",".");
                           
                             $cRet    .= " <tr><td style='vertical-align:top;border-top: solid 1px black;border-bottom: none;' width='10%' align='left'>$coba9</td>                                     
                                             <td style='vertical-align:top;border-top: solid 1px black;border-bottom: none;' width='70%'>$coba10</td>
                                             <td style='vertical-align:top;border-top: solid 1px black;border-bottom: none;' width='20%' align='right'>$coba11</td></tr>";
                        } 

                                            $kosong    = " <tr><td style='vertical-align:top;border-top: solid 1px black;' width='10%' align='left'></td>                                     
                                                             <td style='vertical-align:top;border-top: solid 1px black;' width='70%' align='right'>&nbsp;</td>
                                                             <td style='vertical-align:top;border-top: solid 1px black;' width='20%' align='right'>&nbsp;</td></tr>";
                        $sqltpm="SELECT SUM(nilai) AS totb FROM trdrka WHERE LEFT(kd_rek6,2)='61' and left(kd_skpd,20)=left('$id',20)";
                                            $sqltpm=$this->db->query($sqltpm);
                                         foreach ($sqltpm->result() as $rowtpm)
                                        {
                                           $coba12=number_format($rowtpm->totb,"2",",",".");
                                            $cobtpm=$rowtpm->totb;
                                            $cRet    .= " $kosong <tr><td style='vertical-align:top;border-top: solid 1px black;border-bottom: none;' width='10%' align='left'></td>                                     
                                                             <td style='vertical-align:top;border-top: solid 1px black;border-bottom: none;' width='70%' align='right'>Jumlah Penerimaan Pembiayaan</td>
                                                             <td style='vertical-align:top;border-top: solid 1px black;border-bottom: none;' width='20%' align='right'>$coba12</td>
                                                             </tr>$kosong";
                                         } 

                        if($detail=='detail'){
                            $rincian="  UNION ALL 
                                        SELECT a.kd_rek4 AS kd_rek,a.kd_rek4 AS rek,a.nm_rek4 AS nm_rek ,SUM(b.nilai) AS nilai FROM ms_rek4 a 
                                        INNER JOIN trdrka b ON a.kd_rek4=LEFT(b.kd_rek6,(len(a.kd_rek4))) WHERE LEFT(kd_rek6,2)='62' AND left(b.kd_skpd,20)=left('$id',20) 
                                        GROUP BY a.kd_rek4, a.nm_rek4 
                                        UNION ALL 
                                        SELECT a.kd_rek5 AS kd_rek,a.kd_rek5 AS rek,a.nm_rek5 AS nm_rek ,SUM(b.nilai) AS nilai FROM ms_rek5 a 
                                        INNER JOIN trdrka b ON a.kd_rek5=LEFT(b.kd_rek6,(len(a.kd_rek5))) WHERE LEFT(kd_rek6,2)='62' AND left(b.kd_skpd,20)=left('$id',20) 
                                        GROUP BY a.kd_rek5, a.nm_rek5 
                                        UNION ALL 
                                        SELECT a.kd_rek6 AS kd_rek,a.kd_rek6 AS rek,a.nm_rek6 AS nm_rek ,SUM(b.nilai) AS nilai FROM ms_rek6 a 
                                        INNER JOIN trdrka b ON a.kd_rek6=b.kd_rek6 WHERE LEFT(b.kd_rek6,2)='62' AND left(b.kd_skpd,20)=left('$id',20) 
                                        GROUP BY a.kd_rek6, a.nm_rek6 ";
                        }else{$rincian='';}

                        $sqlpk="
                        SELECT a.kd_rek2 AS kd_rek,a.kd_rek2 AS rek,a.nm_rek2 AS nm_rek ,SUM(b.nilai) AS nilai FROM ms_rek2 a 
                        INNER JOIN trdrka b ON a.kd_rek2=LEFT(b.kd_rek6,(len(a.kd_rek2))) WHERE LEFT(kd_rek6,2)='62' AND left(b.kd_skpd,20)=left('$id',20) GROUP BY a.kd_rek2,a.nm_rek2 
                        UNION ALL 
                        SELECT a.kd_rek3 AS kd_rek,a.kd_rek3 AS rek,a.nm_rek3 AS nm_rek ,SUM(b.nilai) AS nilai FROM ms_rek3 a 
                        INNER JOIN trdrka b ON a.kd_rek3=LEFT(b.kd_rek6,(len(a.kd_rek3))) WHERE LEFT(kd_rek6,2)='62' AND left(b.kd_skpd,20)=left('$id',20) 
                        GROUP BY a.kd_rek3, a.nm_rek3 
                        $rincian
                        ORDER BY kd_rek";
                 
                         $querypk= $this->db->query($sqlpk);
                         foreach ($querypk->result() as $rowpk){
                            $coba9=$this->support->dotrek($rowpk->rek);
                            $coba10=$rowpk->nm_rek;
                            $coba11= number_format($rowpk->nilai,"2",",",".");
                           
                             $cRet    .= " <tr><td style='vertical-align:top;border-top: solid 1px black;' width='10%' align='left'>$coba9</td>                                     
                                             <td style='vertical-align:top;border-top: solid 1px black;' width='70%'>$coba10</td>
                                             <td style='vertical-align:top;border-top: solid 1px black;' width='20%' align='right'>$coba11</td></tr>";
                        } 


                        $sqltpk="SELECT SUM(nilai) AS totb FROM trdrka WHERE LEFT(kd_rek6,2)='62' and left(kd_skpd,20)=left('$id',20)";
                    $sqltpk=$this->db->query($sqltpk);
                 foreach ($sqltpk->result() as $rowtpk)
                {
                   $cobatpk=number_format($rowtpk->totb,"2",",",".");
                    $cobtpk=$rowtpk->totb;
                   
                    $cRet    .= "$kosong <tr><td style='vertical-align:top;border-top: solid 1px black;' width='10%' align='left'></td>                                     
                                     <td style='vertical-align:top;border-top: solid 1px black;' width='70%' align='right'>Jumlah Pengeluaran Pembiayaan</td>
                                     <td style='vertical-align:top;border-top: solid 1px black;' width='20%' align='right'>$cobatpk</td>
                                </tr>$kosong";
                 }
                                                    
                    

                    } /*end if pembiayaan 0*/

                } 
                  
                $cRet    .= "</table>";
        if($ttd1!='tanpa'){
            $sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab, pangkat as pangkat FROM ms_ttd WHERE kode in ('PA','KPA') AND id='$ttd1' ";
            $sqlttd=$this->db->query($sqlttd1);
            foreach ($sqlttd->result() as $rowttd){
                        $nip=$rowttd->nip;  
                        $pangkat=$rowttd->pangkat;  
                        $nama= $rowttd->nm;
                        $jabatan  = $rowttd->jab;
            }
                    

            $cRet.="<table width='100%' style='border-collapse:collapse;font-size:12px'>
                        <tr>
                            <td align='center'>

                            </td>
                            <td align='center'>
                                <br>$daerah, $tanggal_ttd <br>
                                Mengetahui, <br>
                                $jabatan 
                                <br><br>
                                <br><br>
                                <br><br>
                                <b>$nama</b><br>
                                <u>$nip</u>
                            </td>

                        </tr>
                    </table>";

        $cRet    .="<br><table style='border-collapse:collapse;font-size:12px' width='100%' align='center' border='1' cellspacing='0' cellpadding='4'>
                    <tr>
                         <td colspan='5' align='center'><strong>Tim Anggaran Pemerintah Daerah</strong> </td>
                         
                    </tr>
                    <tr>
                         <td width='10%' align='center'><strong>No</strong> </td>
                         <td width='30%'  align='center'><strong>Nama</strong></td>
                         <td width='20%'  align='center'><strong>NIP</strong></td>
                         <td width='20%'  align='center'><strong>Jabatan</strong></td>
                         <td width='20%'  align='center'><strong>Tanda Tangan</strong></td>
                    </tr>";
                    $sqltim="SELECT nama as nama,nip as nip,jabatan as jab FROM tapd order by no";
                    $sqltapd=$this->db->query($sqltim);
                    $no=1;
                    foreach ($sqltapd->result() as $rowtim)
                    {
                        $no=$no;                    
                        $nama= $rowtim->nama;
                        $nip= $rowtim->nip;
                        $jabatan  = $rowtim->jab;
                        $cRet .="<tr>
                                 <td width='5%' align='center'>$no </td>
                                 <td width='20%'  align='left'>$nama</td>
                                 <td width='20%'  align='left'>$nip</td>
                                 <td width='35%'  align='left'>$jabatan</td>
                                 <td width='20%'  align='left'></td>
                            </tr>"; 
                    $no=$no+1;              
                    }
                    
                    if($no<=4){ /*jika orangnya kurang dari 4 maka tambah kolom kosong*/
                        for ($i = $no; $i <= 4; $i++){
                            $cRet .="<tr>
                                         <td width='5%' align='center'>$i </td>
                                         <td width='20%'  align='left'>&nbsp; </td>
                                         <td width='20%'  align='left'>&nbsp; </td>
                                         <td width='35%'  align='left'>&nbsp; </td>
                                         <td width='20%'  align='left'></td>
                                    </tr>";     
                            }                                                   
                    } 

        $cRet    .= "</table>";                       
        }
     
        $data['prev']= $cRet;    
        $judul         = 'RKA SKPD';
        switch($cetak) { 
        case 1;
             $this->master_pdf->_mpdf('',$cRet,10,10,10,'0');
        break;
        case 2;        
            header("Cache-Control: no-cache, no-store, must-revalidate");
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename= $judul.xls");
        break;
        case 3;     
            header("Cache-Control: no-cache, no-store, must-revalidate");
            header("Content-Type: application/vnd.ms-word");
            header("Content-Disposition: attachment; filename= $judul.doc");
            $this->load->view('anggaran/rka/perkadaII', $data);
        break;
        case 0;
        echo ("<title>RKA SKPD</title>");
        echo($cRet);
        break;
        }           
    } 

     function preview_rka221_penyusunan($id,$giat,$cetak,$atas,$bawah,$kiri,$kanan,$tgl_ttd,$ttd1,$ttd2, $tanggal_ttd,$jns_an){


 

 
        $sqlsc="SELECT tgl_rka,provinsi,kab_kota,daerah,thn_ang FROM sclient where kd_skpd='$id'";
                 $sqlsclient=$this->db->query($sqlsc);
                 foreach ($sqlsclient->result() as $rowsc)
                {
                   
                    $tgl=$rowsc->tgl_rka;
                    $tanggal = '';
                    $kab     = $rowsc->kab_kota;
                    $daerah  = $rowsc->daerah;
                    $thn     = $rowsc->thn_ang;
                    $thn_lalu     = $rowsc->thn_ang-1;
                    $thn_depan     = $rowsc->thn_ang+1;
                }
        $sqlttd1="SELECT isnull(nama,'') as nm,isnull(nip,'') as nip,isnull(jabatan,'') as jab, isnull(pangkat,'') as pangkat FROM ms_ttd WHERE  id='$ttd1'   ";
                 $sqlttd=$this->db->query($sqlttd1);
                 foreach ($sqlttd->result() as $rowttd)
                {
                    $nip=$rowttd->nip; 
                    $pangkat=$rowttd->pangkat;
                    $nama= $rowttd->nm;
                    $jabatan  = $rowttd->jab;
                    $kuasa="";
                }
              
         $sqlttd2="SELECT nama as nm,nip as nip,jabatan as jab, pangkat as pangkat FROM ms_ttd WHERE  id='$ttd1' ";
                 $sqlttd2=$this->db->query($sqlttd2);
                 foreach ($sqlttd2->result() as $rowttd2)
                {
                    $nip2=$rowttd2->nip;
                    $pangkat2=$rowttd2->pangkat;
                    $nama2= $rowttd2->nm;
                    $jabatan2  = $rowttd2->jab;
                    
                }
        $sqlorg="SELECT *, left(kd_bidang_urusan,1) kd_urusan, (select nm_urusan from ms_urusan where kd_urusan=left(kd_bidang_urusan,1))  nm_urusan,
            (select nm_bidang_urusan from ms_bidang_urusan where kd_bidang_urusan=trskpd.kd_bidang_urusan) nm_bidang_urusan
          from trskpd where left(kd_sub_kegiatan,12)='$giat' and kd_skpd='$id'
                ";
                 $sqlorg1=$this->db->query($sqlorg);
                 foreach ($sqlorg1->result() as $roworg)
                {
                    $kd_urusan=$roworg->kd_urusan;                    
                    $nm_urusan= $roworg->nm_urusan;
                    $kd_bidang_urusan=$roworg->kd_bidang_urusan;                    
                    $nm_bidang_urusan= $roworg->nm_bidang_urusan;
                    $kd_skpd  = $roworg->kd_skpd;
                    $nm_skpd  = $roworg->nm_skpd;
                    $kd_prog  = $roworg->kd_program;
                    $nm_prog  = $roworg->nm_program;
                    $sasaran_prog  = $roworg->sasaran_program;
                    $capaian_prog  = $roworg->capaian_program;
                    $kd_giat  = $roworg->kd_kegiatan;
                    $nm_giat  = $roworg->nm_kegiatan;
                    $lokasi  = $roworg->lokasi;
                    $tu_capai  = $roworg->tu_capai;
                    $tu_capai_p  = $roworg->tu_capai_p;
                    $tu_mas  = $roworg->tu_mas;
                    $tu_mas_p  = $roworg->tu_mas_p;
                    $tu_kel  = $roworg->tu_kel;
                    $tu_kel_p  = $roworg->tu_kel_p;
                    $tu_has  = $roworg->tu_has;
                    $tu_has_p  = $roworg->tu_has_p;
                    $tk_capai  = $roworg->tk_capai;
                    $tk_mas  = $roworg->tk_mas;
                    $tk_kel  = $roworg->tk_kel;
                    $tk_has  = $roworg->tk_has;
                    $tk_capai_p  = $roworg->tk_capai_p;
                    $tk_mas_p  = $roworg->tk_mas_p;
                    $tk_kel_p  = $roworg->tk_kel_p;
                    $tk_has_p  = $roworg->tk_has_p;
                    $sas_giat = $roworg->sasaran_giat;
                    $ang_lalu = $roworg->ang_lalu;
                }


        $sqltp="SELECT SUM(nilai) AS totb FROM trdrka WHERE left(kd_rek6,1)='5' and left(kd_sub_kegiatan,12)='$giat' AND kd_skpd='$id'";
                 $sqlb=$this->db->query($sqltp);
                 foreach ($sqlb->result() as $rowb)
                {
                   $totp  =number_format($rowb->totb,"2",",",".");
                   $totp1 =number_format($rowb->totb*1.1,"2",",",".");
                }
        if($jns_an=="RKA"){
            $jenis_ang="RKA - RINCIAN BELANJA SKPD";
            $isi_="RENCANA KERJA DAN ANGGARAN <BR> SATUAN KERJA PERANGKAT DAERAH";
        }else{
            $jenis_ang="DPA - RINCIAN BELANJA SKPD";
            $isi_="DOKUMEN PELAKSANAAN ANGGARAN <BR> SATUAN KERJA PERANGKAT DAERAH";            
        }      
     
        $cRet='';
        $cRet .="<table style='border-collapse:collapse;font-size:12px' width='100%' align='center' border='1' cellspacing='0' cellpadding='4'>

                    <tr>
                        <td align='center'><strong>$isi_ </strong></td>
                        <td align='center' width='20%' rowspan='2'><strong>$jenis_ang</strong></td>
                    </tr>
                    <tr>
                        <td align='center' ><strong>$kab <BR> TAHUN ANGGARAN $thn</strong> </td>
                    </tr>
                  </table>";
        $cRet .="<table style='border-collapse:collapse;font-size:12px' width='100%' align='left' border='1'>
                        <tr>
                            <td width='20%' style='vertical-align:top;border-right: none;' align='left'>&nbsp;Urusan Pemerintahan</td>
                            <td width='5%'  style='vertical-align:top;border-left: none;border-right: none;' align='center'>:</td>
                            <td width='15%' style='vertical-align:top;border-left: none;border-right: none;' align='left'>$kd_urusan</td>
                            <td width='60%' style='vertical-align:top;border-left: none;' align='left'>$nm_urusan</td>
                        </tr>
                        <tr>
                            <td width='20%' style='vertical-align:top;border-right: none;' align='left'>&nbsp;Bidang Urusan</td>
                            <td width='5%'  style='vertical-align:top;border-left: none;border-right: none;' align='center'>:</td>
                            <td width='15%' style='vertical-align:top;border-left: none;border-right: none;' align='left'>$kd_bidang_urusan </td>
                            <td width='60%' style='vertical-align:top;border-left: none;' align='left'> $nm_bidang_urusan</td>
                        </tr>
                        <tr>
                            <td align='left' style='vertical-align:top;border-right: none;' align='left'>&nbsp;Program</td>
                            <td align='center' style='vertical-align:top;border-left: none;border-right: none;'>:</td>
                            <td align='left' style='vertical-align:top;border-left: none;border-right: none;'>$kd_prog</td>
                            <td align='left' style='vertical-align:top;border-left: none;'>$nm_prog</td>
                        </tr>
                        <tr>
                            <td align='left' style='vertical-align:top;border-right: none;' align='left'>&nbsp;Sasaran Program</td>
                            <td align='center' style='vertical-align:top;border-left: none;border-right: none;'>:</td>
                            <td colspan ='2' align='left' style='vertical-align:top;border-left: none;'>$sasaran_prog</td>
                        </tr>
                        <tr>
                            <td align='left' style='vertical-align:top;border-right: none;' align='left'>&nbsp;Capaian Program</td>
                            <td align='center' style='vertical-align:top;border-left: none;border-right: none;'>:</td>
                            <td colspan ='2' align='left' style='vertical-align:top;border-left: none;'>$capaian_prog</td>
                        </tr>
                        <tr>
                            <td align='left' style='vertical-align:top;border-right: none;' align='left'>&nbsp;Kegiatan</td>
                            <td align='center' style='vertical-align:top;border-left: none;border-right: none;'>:</td>
                            <td align='left' style='vertical-align:top;border-left: none;border-right: none;'>$kd_giat</td>
                            <td align='left' style='vertical-align:top;border-left: none;'>$nm_giat</td>
                        </tr>
                        <tr>
                            <td align='left' style='vertical-align:top;border-right: none;' align='left'>&nbsp;Organisasi</td>
                            <td align='center' style='vertical-align:top;border-left: none;border-right: none;'>:</td>
                            <td align='left' style='vertical-align:top;border-left: none;border-right: none;'>".substr($kd_skpd,0,20)."</td>
                            <td align='left' style='vertical-align:top;border-left: none;'>$nm_skpd</td>
                        </tr>
                        <tr>
                            <td align='left' style='vertical-align:top;border-right: none;' align='left'>&nbsp;Unit Organisasi</td>
                            <td align='center' style='vertical-align:top;border-left: none;border-right: none;'>:</td>
                            <td align='left' style='vertical-align:top;border-left: none;border-right: none;'>$kd_skpd</td>
                            <td align='left' style='vertical-align:top;border-left: none;'>$nm_skpd</td>
                        </tr>
                        <tr>
                            <td align='left' style='vertical-align:top;border-right: none;' align='left'>&nbsp;Alokasi Tahun $thn_lalu</td>
                            <td align='center' style='vertical-align:top;border-left: none;border-right: none;'>:</td>
                            <td colspan ='2'  align='left' style='vertical-align:top;border-left: none;'>Rp. ".number_format($ang_lalu,"2",",",".")." (<i>".$this->rka_model->terbilang($ang_lalu*1)." rupiah)</td>
                        </tr>
                        <tr>
                            <td align='left' style='vertical-align:top;border-right: none;' align='left'>&nbsp;Alokasi Tahun</td>
                            <td align='center' style='vertical-align:top;border-left: none;border-right: none;'>:</td>
                            <td colspan ='2' align='left' style='vertical-align:top;border-left: none;'>Rp. $totp (<i>".$this->rka_model->terbilang($rowb->totb*1)." rupiah)</td>
                        </tr>
                        <tr>
                            <td align='left' style='vertical-align:top;border-right: none;' align='left'>&nbsp;Alokasi Tahun $thn_depan</td>
                            <td align='center' style='vertical-align:top;border-left: none;border-right: none;'>:</td>
                            <td colspan ='2' align='left' style='vertical-align:top;border-left: none;'>Rp. $totp1 (<i>".$this->rka_model->terbilang($rowb->totb*1.1)." rupiah)</td>
                        </tr>
                        <tr>
                    <td colspan='4' bgcolor='#CCCCCC' width='100%' align='left'>&nbsp;</td>
                </tr>
                    </table>    
                        
                    ";
        $cRet .= "<table style='border-collapse:collapse;font-size:12px' width='100%' align='left' border='1'>
                    <tr>
                        <td colspan='3'  align='center' >Indikator & Tolak Ukur Kinerja Kegiatan</td>
                    </tr>";
        $cRet .="<tr>
                 <td width='20%'  align='center'>Indikator </td>
                 <td width='40%'  align='center'>Tolak Ukur Kerja </td>
                 <td width='40%'  align='center'>Target Kinerja </td>
                </tr>";             

        $cRet .=" <tr align='center' >
                    <td  style='white-space: pre-line;'>Capaian Kegiatan </td>
                    <td style='white-space: pre-line;'>".nl2br($tu_capai)."</td>
                    <td style='white-space: pre-line;'>".nl2br($tk_capai)."</td>
                 </tr>";
        $cRet .=" <tr align='center'>
                    <td style='white-space: pre-line;'>Masukan </td>
                    <td style='white-space: pre-line;'>".nl2br($tu_mas)."</td>
                    <td style='white-space: pre-line;'>Rp. $totp</td>
                </tr>";
        $cRet .=" <tr align='center'>
                    <td style='white-space: pre-line;'>Keluaran </td>
                    <td style='white-space: pre-line;'>".nl2br($tu_kel)."</td>
                    <td style='white-space: pre-line;'>".nl2br($tk_kel)."</td>
                  </tr>";
        $cRet .=" <tr align='center'>
                    <td style='white-space: pre-line;'>Hasil </td>
                    <td style='white-space: pre-line;'>".nl2br($tu_has)."</td>
                    <td style='white-space: pre-line;'>".nl2br($tk_has)."</td>
                  </tr>";
        $cRet .= "<tr>
                    <td colspan='3'   align='left'>Kelompok Sasaran Kegiatan : $sas_giat</td>
                </tr>";
        $cRet .= "<tr>
                    <td colspan='3'  align='left'>&nbsp;</td>
                </tr>"; 
                $cRet .= "<tr>
                    <td colspan='3' bgcolor='#CCCCCC'  align='left'>&nbsp;</td>
                </tr>";                
        
        $cRet .= "<tr>
                        <td colspan='5' align='center'>RINCIAN ANGGARAN BELANJA KEGIATAN SATUAN KERJA PERANGKAT DAERAH</td>
                  </tr>";
                    
        $cRet .="</table>";
//rincian sub kegiatan
                

               $sqlsub="SELECT a.kd_sub_kegiatan as kd_sub_kegiatan,b.nm_sub_kegiatan,b.sub_keluaran,b.lokasi,b.waktu_giat,b.waktu_giat2,b.keterangan FROM trdrka a
                left join trskpd b on a.kd_sub_kegiatan=b.kd_sub_kegiatan
                WHERE left(a.kd_sub_kegiatan,12)='$giat' AND a.kd_skpd='$id' AND b.kd_skpd='$id'
                group by a.kd_sub_kegiatan,b.nm_sub_kegiatan,b.sub_keluaran,b.lokasi,b.waktu_giat,b.waktu_giat2,b.keterangan order by a.kd_sub_kegiatan";
                 $sqlbsub=$this->db->query($sqlsub);
                 foreach ($sqlbsub->result() as $rowsub)
                {
                   $sub         =$rowsub->kd_sub_kegiatan;
                   $nm_sub      =$rowsub->nm_sub_kegiatan;
                   $sub_keluaran=$rowsub->sub_keluaran;
                   $lokasi      =$rowsub->lokasi;
                   $waktu_giat  =$rowsub->waktu_giat;
                   $waktu_giat2  =$rowsub->waktu_giat2;
                   $keterangan  =$rowsub->keterangan;


                    $sumber=$this->db->query("SELECT top 1 sumber+' '++isnull(sumber2,'')+' '++isnull(sumber3,'')+' '++isnull(sumber4,'') sumber from trdrka where kd_sub_kegiatan='$sub' and kd_skpd='$id'")->row();

                    /*untuk indikator sub Kegiatan*/
                    $cRet .="<table style='border-collapse:collapse;font-size:12px' width='100%' align='left' border='1'>
                        <tr>
                            <td width='20%' style='vertical-align:top;border-right: none;' align='left'>&nbsp;Sub Kegiatan</td>
                            <td width='5%'  style='vertical-align:top;border-left: none;border-right: none;' align='center'>:</td>
                            <td width='75%' colspan='3' style='vertical-align:top;border-left: none;' align='left'><b><i>$sub - $nm_sub</td>
                        </tr>
                        <tr>
                            <td width='20%' style='vertical-align:top;border-right: none;' align='left'>&nbsp;Sumber Dana</td>
                            <td width='5%'  style='vertical-align:top;border-left: none;border-right: none;' align='center'>:</td>
                            <td width='75%' colspan='3' style='vertical-align:top;border-left: none;' align='left'>$sumber->sumber</td>
                        </tr>
                        <tr>
                            <td width='20%' style='vertical-align:top;border-right: none;' align='left'>&nbsp;Lokasi</td>
                            <td width='5%'  style='vertical-align:top;border-left: none;border-right: none;' align='center'>:</td>
                            <td width='75%' colspan='3' style='vertical-align:top;border-left: none;' align='left'>$lokasi</td>
                        </tr>
                        <tr>
                            <td align='left' style='vertical-align:top;border-right: none;' align='left'>&nbsp;Keluaran Sub Kegiatan</td>
                            <td align='center' style='vertical-align:top;border-left: none;border-right: none;'>:</td>
                            <td align='left' colspan='3' style='vertical-align:top;border-left: none;'>$sub_keluaran</td>
                        </tr>
                        <tr>
                            <td align='left' style='vertical-align:top;border-right: none;' align='left'>&nbsp;Waktu Pelaksanaan</td>
                            <td align='center' style='vertical-align:top;border-left: none;border-right: none;'>:</td>
                            <td width='35%' style='vertical-align:top;border-left: none;border-right: none;' align='left'>Mulai:&nbsp;$waktu_giat</td>
                            <td width='10%' style='vertical-align:top;border-right: none;border-left: none;' align='left'>Sampai</td>
                            <td width='35%' style='vertical-align:top;border-left: none;' align='left'>:&nbsp;$waktu_giat2</td>
                        </tr>

                        <tr>
                            <td align='left' style='vertical-align:top;border-right: none;' align='left'>&nbsp;Keterangan</td>
                            <td align='center' style='vertical-align:top;border-left: none;border-right: none;'>:</td>
                            <td align='left' colspan='3' style='vertical-align:top;border-left: none;'>$keterangan</td>
                        </tr>
                    </table>    
                        
                    ";
/*untuk isi subkegiatan*/

                        $cRet .= "<table style='border-collapse:collapse;font-size:12px' width='100%' align='center' border='1' cellspacing='0' cellpadding='0'>
                                
                            <tr><td rowspan='2' bgcolor='#CCCCCC' width='10%' align='center'><b>Kode Rekening</b></td>                            
                                <td rowspan='2' bgcolor='#CCCCCC' width='40%' align='center'><b>Uraian</b></td>
                                <td colspan='4' bgcolor='#CCCCCC' width='30%' align='center'><b>Rincian Perhitungan</b></td>
                                <td rowspan='2' bgcolor='#CCCCCC' width='20%' align='center'><b>Jumlah(Rp.)</b></td></tr>
                            <tr>
                                <td width='8%' bgcolor='#CCCCCC' align='center'>Volume</td>
                                <td width='8%' bgcolor='#CCCCCC' align='center'>Satuan</td>
                                <td width='10%' bgcolor='#CCCCCC' align='center'>harga</td>
                                <td width='4%' bgcolor='#CCCCCC' align='center'>PPN</td>
                            </tr>    
                         

                         
                           <tr>
                                <td style='vertical-align:top;border-top: none;border-bottom: solid 1px black;' align='center' width='10%'>&nbsp;1</td>                            
                                <td style='vertical-align:top;border-top: none;border-bottom: solid 1px black;' align='center' width='40%'>&nbsp;2</td>
                                <td style='vertical-align:top;border-top: none;border-bottom: solid 1px black;' align='center' width='8%'>&nbsp;3</td>
                                <td style='vertical-align:top;border-top: none;border-bottom: solid 1px black;' align='center' width='8%'>&nbsp;4</td>
                                <td style='vertical-align:top;border-top: none;border-bottom: solid 1px black;' align='center' width='10%'>&nbsp;5</td>
                                <td style='vertical-align:top;border-top: none;border-bottom: solid 1px black;' align='center' width='4%'>&nbsp;6</td>
                                <td style='vertical-align:top;border-top: none;border-bottom: solid 1px black;' align='center' width='20%'>&nbsp;7</td>
                            </tr>
                            ";

                            $sql1="SELECT * FROM(SELECT 0 header,0 no_po, LEFT(a.kd_rek6,1)AS rek1,LEFT(a.kd_rek6,1)AS rek,b.nm_rek1 AS nama ,0 AS volume,' 'AS satuan,
                            0 AS harga,SUM(a.nilai) AS nilai,'1' AS id FROM trdrka a INNER JOIN ms_rek1 b ON LEFT(a.kd_rek6,1)=b.kd_rek1 WHERE a.kd_sub_kegiatan='$sub' AND a.kd_skpd='$id' 
                             GROUP BY LEFT(a.kd_rek6,1),nm_rek1 
                            UNION ALL 
                            SELECT 0 header, 0 no_po,LEFT(a.kd_rek6,2) AS rek1,LEFT(a.kd_rek6,2) AS rek,b.nm_rek2 AS nama,0 AS volume,' 'AS satuan,
                            0 AS harga,SUM(a.nilai) AS nilai,'2' AS id FROM trdrka a INNER JOIN ms_rek2 b ON LEFT(a.kd_rek6,2)=b.kd_rek2 WHERE a.kd_sub_kegiatan='$sub'
                            AND a.kd_skpd='$id' GROUP BY LEFT(a.kd_rek6,2),nm_rek2 
                            UNION ALL  
                            SELECT 0 header, 0 no_po, LEFT(a.kd_rek6,4) AS rek1,LEFT(a.kd_rek6,4) AS rek,b.nm_rek3 AS nama,0 AS volume,' 'AS satuan,
                            0 AS harga,SUM(a.nilai) AS nilai,'3' AS id FROM trdrka a INNER JOIN ms_rek3 b ON LEFT(a.kd_rek6,4)=b.kd_rek3 WHERE a.kd_sub_kegiatan='$sub'
                            AND a.kd_skpd='$id'  GROUP BY LEFT(a.kd_rek6,4),nm_rek3 
                            UNION ALL 
                            SELECT 0 header, 0 no_po, LEFT(a.kd_rek6,6) AS rek1,LEFT(a.kd_rek6,6) AS rek,b.nm_rek4 AS nama,0 AS volume,' 'AS satuan,
                            0 AS harga,SUM(a.nilai) AS nilai,'4' AS id FROM trdrka a INNER JOIN ms_rek4 b ON LEFT(a.kd_rek6,6)=b.kd_rek4 WHERE a.kd_sub_kegiatan='$sub'
                            AND a.kd_skpd='$id'  GROUP BY LEFT(a.kd_rek6,6),nm_rek4 
                            UNION ALL 
                            SELECT 0 header, 0 no_po, LEFT(a.kd_rek6,8) AS rek1,RTRIM(LEFT(a.kd_rek6,8)) AS rek,b.nm_rek5 AS nama,0 AS volume,' 'AS satuan,
                            0 AS harga,SUM(a.nilai) AS nilai,'5' AS id FROM trdrka a INNER JOIN ms_rek5 b ON LEFT(a.kd_rek6,8)=b.kd_rek5 WHERE a.kd_sub_kegiatan='$sub'
                            AND a.kd_skpd='$id'  GROUP BY LEFT(a.kd_rek6,8),b.nm_rek5
                            UNION ALL
                            SELECT 0 header, 0 no_po, a.kd_rek6 AS rek1,RTRIM(a.kd_rek6) AS rek,b.nm_rek6 AS nama,0 AS volume,' 'AS satuan,
                            0 AS harga,SUM(a.nilai) AS nilai,'6' AS id FROM trdrka a INNER JOIN ms_rek6 b ON a.kd_rek6=b.kd_rek6 WHERE a.kd_sub_kegiatan='$sub'
                            AND a.kd_skpd='$id'  GROUP BY a.kd_rek6,b.nm_rek6
                            ) a ORDER BY a.rek1,a.no_po

                            ";
                     
                    $query = $this->db->query($sql1);

                            $nilai_sub=0;
                            foreach ($query->result() as $row)
                            {
                                $rekx=$row->rek;
                                $rekex=$this->support->dotrek($rekx);
                                $uraianx=$row->nama;
                                $satx=$row->satuan;
                                $hrgx= empty($row->harga) || $row->harga == 0 ? '' :number_format($row->harga,2,',','.');
                                $volumx= empty($row->volume) || $row->volume == 0 ? '' :$row->volume;
                                $nilax= empty($row->nilai) || $row->nilai == 0 ? '' :number_format($row->nilai,2,',','.');

                               if($row->id=='6'){
                                     $nilai_sub= $nilai_sub+$row->nilai;
                               }
                                 $cRet    .= " <tr><td style='vertical-align:top;border-top: solid 1px black;' width='10%' align='left'>$rekex</td>                                     
                                                 <td style='vertical-align:top;border-top: solid 1px black;' width='40%'>$uraianx</td>
                                                 <td style='vertical-align:top;border-top: solid 1px black;' width='8%' align='right'>$volumx &nbsp;&nbsp;&nbsp;</td>
                                                 <td style='vertical-align:top;border-top: solid 1px black;' width='8%' align='center'>$satx</td>
                                                 <td style='vertical-align:top;border-top: solid 1px black;' width='14%' align='right'>$hrgx</td>
                                                 <td style='vertical-align:top;border-top: solid 1px black;'  align='right'></td>
                                                 <td style='vertical-align:top;border-top: solid 1px black;' width='20%' align='right'>$nilax</td></tr>
                                                 ";
                            }

                                             
                            
                                 $cRet    .= " <tr>
                                                 <td colspan='6' style='vertical-align:top;border-top: solid 1px black;'  align='right'>Jumlah SubKegiatan</td>
                                                 <td style='vertical-align:top;border-top: solid 1px black;' width='20%' align='right'>".number_format($nilai_sub,2,',','.')."</td></tr>
                                                 ";
                            $cRet .="</table>";
/*end untuk isi kegiatan*/

                    $groupSubKeluaran="
                    SELECT a.kd_lokasi, b.nm_lokasi, b.subkeluar from trdpo a 
                    inner join ms_lokasi b on a.kd_lokasi=b.kd_lokasi where left(no_trdrka,20)='$id' AND SUBSTRING(no_trdrka,22,15)='$sub'
                    group by a.kd_lokasi,b.nm_lokasi, b.subkeluar order by a.kd_lokasi";
                    $exc=$this->db->query($groupSubKeluaran);
                    foreach($exc->result() as $a){

                        $kd_lokasi=$a->kd_lokasi;
                        $nm_lokasi=$a->nm_lokasi;
                        $subkeluar=$a->subkeluar;

                        /*untuk Indikator rincian*/
                        $cRet .="<table style='border-collapse:collapse;font-size:12px' width='100%' align='left' border='1'>
                            <tr>
                                <td  colspan='5' align='center'>&nbsp;</td>
                            </tr>
                            <tr>
                                <td width='20%' style='vertical-align:top;border-right: none;' align='left'>&nbsp;Sub Kegiatan</td>
                                <td width='5%'  style='vertical-align:top;border-left: none;border-right: none;' align='center'>:</td>
                                <td width='75%' colspan='3' style='vertical-align:top;border-left: none;' align='left'>$sub - $nm_sub</td>
                            </tr>
                            <tr>
                                <td width='20%' style='vertical-align:top;border-right: none;' align='left'>&nbsp;Sumber Dana</td>
                                <td width='5%'  style='vertical-align:top;border-left: none;border-right: none;' align='center'>:</td>
                                <td width='75%' colspan='3' style='vertical-align:top;border-left: none;' align='left'>$sumber->sumber</td>
                            </tr>
                            <tr>
                                <td width='20%' style='vertical-align:top;border-right: none;' align='left'>&nbsp;Lokasi</td>
                                <td width='5%'  style='vertical-align:top;border-left: none;border-right: none;' align='center'>:</td>
                                <td width='75%' colspan='3' style='vertical-align:top;border-left: none;' align='left'>$nm_lokasi</td>
                            </tr>
                            <tr>
                                <td align='left' style='vertical-align:top;border-right: none;' align='left'>&nbsp;Sub Keluaran</td>
                                <td align='center' style='vertical-align:top;border-left: none;border-right: none;'>:</td>
                                <td align='left' colspan='3' style='vertical-align:top;border-left: none;'>$subkeluar</td>
                            </tr>
                            <tr>
                                <td align='left' style='vertical-align:top;border-right: none;' align='left'>&nbsp;Waktu Pelaksanaan</td>
                                <td align='center' style='vertical-align:top;border-left: none;border-right: none;'>:</td>
                                <td width='35%' style='vertical-align:top;border-left: none;border-right: none;' align='left'>Mulai:&nbsp;$waktu_giat</td>
                                <td width='10%' style='vertical-align:top;border-right: none;border-left: none;' align='left'>Sampai</td>
                                <td width='35%' style='vertical-align:top;border-left: none;' align='left'>:&nbsp;$waktu_giat2</td>
                            </tr>

                            <tr>
                                <td align='left' style='vertical-align:top;border-right: none;' align='left'>&nbsp;Keterangan</td>
                                <td align='center' style='vertical-align:top;border-left: none;border-right: none;'>:</td>
                                <td align='left' colspan='3' style='vertical-align:top;border-left: none;'>$keterangan</td>
                            </tr>
                        </table>    
                            
                        ";

                        /*isi*/
                        $cRet .= "<table style='border-collapse:collapse;font-size:12px' width='100%' align='center' border='1' cellspacing='0' cellpadding='0'>
                              <thead>                 
                            <tr><td rowspan='2' bgcolor='#CCCCCC' width='10%' align='center'><b>Kode Rekening</b></td>                            
                                <td rowspan='2' bgcolor='#CCCCCC' width='40%' align='center'><b>Uraian</b></td>
                                <td colspan='4' bgcolor='#CCCCCC' width='30%' align='center'><b>Rincian Perhitungan</b></td>
                                <td rowspan='2' bgcolor='#CCCCCC' width='20%' align='center'><b>Jumlah(Rp.)</b></td></tr>
                            <tr>
                                <td width='8%' bgcolor='#CCCCCC' align='center'>Volume</td>
                                <td width='8%' bgcolor='#CCCCCC' align='center'>Satuan</td>
                                <td width='10%' bgcolor='#CCCCCC' align='center'>harga</td>
                                <td width='4%' bgcolor='#CCCCCC' align='center'>PPN</td>
                            </tr>    
                         
                        </thead> 
                         
                           <tr>
                                <td style='vertical-align:top;border-top: none;border-bottom: solid 1px black;' align='center' width='10%'>&nbsp;1</td>                            
                                <td style='vertical-align:top;border-top: none;border-bottom: solid 1px black;' align='center' width='40%'>&nbsp;2</td>
                                <td style='vertical-align:top;border-top: none;border-bottom: solid 1px black;' align='center' width='8%'>&nbsp;3</td>
                                <td style='vertical-align:top;border-top: none;border-bottom: solid 1px black;' align='center' width='8%'>&nbsp;4</td>
                                <td style='vertical-align:top;border-top: none;border-bottom: solid 1px black;' align='center' width='10%'>&nbsp;5</td>
                                <td style='vertical-align:top;border-top: none;border-bottom: solid 1px black;' align='center' width='4%'>&nbsp;6</td>
                                <td style='vertical-align:top;border-top: none;border-bottom: solid 1px black;' align='center' width='20%'>&nbsp;7</td>
                            </tr>
                            ";

                            $sql1="SELECT * FROM(
                            SELECT 0 header, 0 no_po, a.kd_rek6 AS rek1,RTRIM(a.kd_rek6) AS rek,b.nm_rek6 AS nama,0 AS volume,' 'AS satuan,
                            0 AS harga,SUM(a.nilai) AS nilai,'6' AS id FROM trdrka a INNER JOIN ms_rek6 b ON a.kd_rek6=b.kd_rek6 WHERE a.kd_sub_kegiatan='$sub'
                            AND a.kd_skpd='$id' and a.kd_rek6 in (select right(no_trdrka,12) from trdpo where SUBSTRING(no_trdrka,22,15)='$sub' and LEFT(no_trdrka,20)='$id' and kd_lokasi='$kd_lokasi')  GROUP BY a.kd_rek6,b.nm_rek6
                            UNION ALL 
                            SELECT * FROM (SELECT  b.header,b.no_po,RIGHT(a.no_trdrka,12) AS rek1,' 'AS rek,b.uraian AS nama,0 AS volume,' ' AS satuan,
                            0 AS harga,SUM(a.total) AS nilai,'7' AS id 
                            FROM trdpo a
                            LEFT JOIN trdpo b ON b.kode=a.kode AND b.header ='1' AND a.no_trdrka=b.no_trdrka 
                            WHERE LEFT(a.no_trdrka,20)='$id' AND SUBSTRING(a.no_trdrka,22,15)='$sub'
                            and b.kd_lokasi='$kd_lokasi' GROUP BY  RIGHT(a.no_trdrka,12),b.header,b.no_po,b.uraian)z WHERE header='1'
                            UNION ALL
                            SELECT a. header,a.no_po,RIGHT(a.no_trdrka,12) AS rek1,' 'AS rek,a.uraian AS nama,a.volume1 AS volume,a.satuan1 AS satuan,
                            a.harga1 AS harga,a.total AS nilai,'8' AS id FROM trdpo a  WHERE LEFT(a.no_trdrka,20)='$id' and a.kd_lokasi='$kd_lokasi' AND SUBSTRING(a.no_trdrka,22,15)='$sub' AND (header='0' or header is null)
                            ) a ORDER BY a.rek1,a.no_po

                            ";
                          
                     
                    $query = $this->db->query($sql1);
                    $nilangsub=0;

                            foreach ($query->result() as $row)
                            {
                                $rek=$row->rek;
                                $reke=$this->support->dotrek($rek);
                                $uraian=$row->nama;
                                $sat=$row->satuan;
                                $hrg= empty($row->harga) || $row->harga == 0 ? '' :number_format($row->harga,2,',','.');
                                $volum= empty($row->volume) || $row->volume == 0 ? '' :$row->volume;
                                $nila= empty($row->nilai) || $row->nilai == 0 ? '' :number_format($row->nilai,2,',','.');

                                if ($row->id<'7'){
                               
                                 $cRet    .= " <tr><td style='vertical-align:top;border-top: solid 1px black;' width='10%' align='left'>$reke</td>                                     
                                                 <td style='vertical-align:top;border-top: solid 1px black;' width='40%'>$uraian</td>
                                                 <td style='vertical-align:top;border-top: solid 1px black;' width='8%' align='right'>$volum&nbsp;&nbsp;&nbsp;</td>
                                                 <td style='vertical-align:top;border-top: solid 1px black;' width='8%' align='center'>$sat</td>
                                                 <td style='vertical-align:top;border-top: solid 1px black;' width='14%' align='right'>$hrg</td>
                                                 <td style='vertical-align:top;border-top: solid 1px black;'  align='right'></td>
                                                 <td style='vertical-align:top;border-top: solid 1px black;' width='20%' align='right'></td></tr>
                                                 ";

                                             }else{
                                                $cRet    .= " <tr><td style='vertical-align:top;border-top: solid 1px black;' width='10%' align='left'>$reke</td>                                     
                                                 <td style='vertical-align:top;border-top: solid 1px black;' width='40%'>&nbsp;&nbsp;$uraian</td>
                                                 <td style='vertical-align:top;border-top: solid 1px black;' width='8%' align='right'>$volum&nbsp;&nbsp;&nbsp;</td>
                                                 <td style='vertical-align:top;border-top: solid 1px black;' width='8%' align='center'>$sat</td>
                                                 <td style='vertical-align:top;border-top: solid 1px black;' width='14%' align='right'>$hrg</td>
                                                 <td style='vertical-align:top;border-top: solid 1px black;'  align='right'></td>
                                                 <td style='vertical-align:top;border-top: solid 1px black;' width='20%' align='right'>$nila</td></tr>
                                                 ";
                                                 $nilangsub= $nilangsub+$row->nilai;        
                                             }
                                             
                            }
                               $rinci=$this->db->query("SELECT sum(total) jum from trdpo where LEFT(no_trdrka,20)='$id' AND SUBSTRING(no_trdrka,22,15)='$sub' and kd_lokasi='$kd_lokasi'")->row();     
                            $cRet    .=" 
                                        <tr>                                    
                                         <td colspan='6' align='right' style='vertical-align:top;border-top: solid 1px black;' width='40%'> Jumlah Rincian </td>
                                         <td style='vertical-align:top;border-top: solid 1px black;border-bottom: none;' width='20%' align='right'>".number_format($rinci->jum,2,',','.')."</td></tr>
                                         <tr>                                    
                                         <td colspan='7'  align='right' style='vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;' width='40%'>&nbsp;</td></tr>
                                         </table>";

                    } /*end groupSubKeluaran*/
                            $totsubKeluar=$this->db->query("SELECT sum(total) jum from trdpo where LEFT(no_trdrka,20)='$id' AND SUBSTRING(no_trdrka,22,15)='$sub'")->row();

                            $cRet    .="<table style='border-collapse:collapse;font-size:12px' width='100%' align='center' border='1' cellspacing='0' cellpadding='0'>  
                                        <tr>                                    
                                         <td colspan='6' align='right' style='vertical-align:top;border-top: solid 1px black;border-bottom: none;' width='40%'><i>Jumlah Anggaran Sub Kegiatan</td>
                                         <td style='vertical-align:top;border-top: solid 1px black;border-bottom: none;' width='20%' align='right'>".number_format($totsubKeluar->jum,2,',','.')."</td></tr>
                                         <tr>                                    
                                         <td colspan='7'  align='right' style='vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;' width='40%'>&nbsp;</td></tr>
                                         </table>";
                } /*end foreach untuk rincian subkegiatan*/

                


                        $cRet    .="<table style='border-collapse:collapse;font-size:12px' width='100%' align='center' border='1' cellspacing='0' cellpadding='0'> 
                                    

                                     <tr>                                    
                                     <td colspan='5' align='right' style='vertical-align:top;border-top: solid 1px black;border-bottom: none;' width='40%'>Jumlah Anggaran Kegiatan</td>
                                     <td style='vertical-align:top;border-top: solid 1px black;border-bottom: none;' width='20%' align='right'>$totp</td></tr>
                                     </table>";
        

                         $cRet .="<table style='border-collapse:collapse;font-size:12px' width='100%' align='center' border='1' cellspacing='0' cellpadding='4'>";

                 $kd_ttd=substr($id,18,2);
                 $kd_kepala=substr($id,0,7);
                 if ((($kd_ttd=='01') && ($kd_kepala!='1.20.03'))){
                             $cRet .="<tr>
                                <td width='100' align='center' colspan='6'>                           
                                <table border='0'>
                                    <tr>
                                    
                                        <td width='40%' align='center'>
       
                                        </td>
                                        <td width='20%' align='left'>&nbsp;<br>&nbsp;
                                            <br>&nbsp; 
                                            &nbsp;<br>
                                            &nbsp;<br>
                                            &nbsp;<br>
                                            &nbsp;  
                                            </td>
                                            <td width='40%' align='center'>$daerah,&nbsp;&nbsp;$tanggal_ttd
                                            <br>$jabatan2
                                            <br><br><br><br>
                                            <br><b><u>$nama2</u></b>
                                            <br>NIP. $nip2 
                                        </td>
                                    </tr>
                                </table>
                                </td>
                             </tr>";
                             } else {
                             $cRet .="<tr>
                                <td width='100' align='center' colspan='6'>                           
                                <table border='0'>
                                    <tr>
                                    
                                        <td width='40%' align='center'>
       
                                        </td>
                                        <td width='20%' align='left'>&nbsp;<br>&nbsp;
                                            <br>&nbsp; 
                                            &nbsp;<br>
                                            &nbsp;<br>
                                            &nbsp;<br>
                                            &nbsp;  
                                            </td>
                                            <td width='40%' align='center'>$daerah,&nbsp;&nbsp;$tanggal_ttd
                                            <br>$jabatan2
                                            <br><br><br><br>
                                            <br><b><u>$nama2</u></b>
                                            <br>NIP. $nip2 
                                        </td>
                                    </tr>
                                </table>
                                </td>
                             </tr>";
                             
                             }
                             
        if($jns_an=='DPA'){
            $hid="hidden";
        }else{
            $hid="";
        }
                  $cRet .= "<tr $hid>
                                <td width='100%' align='left' colspan='6' style='vertical-align:top;border-right: solid 1px black;border-left: solid 1px black;'>Keterangan :</td>
                            </tr>";
                  $cRet .= "<tr $hid>
                                 <td width='100%' align='left' colspan='6' style='vertical-align:top;border-right: solid 1px black;border-left: solid 1px black;'>Tanggal Pembahasan :</td>
                            </tr>";
                  $cRet .= "<tr $hid>
                                <td width='100%' align='left' colspan='6' style='vertical-align:top;border-right: solid 1px black;border-left: solid 1px black;'>Catatan Hasil Pembahasan :</td>
                            </tr>";
                  $cRet .= "<tr $hid>
                                <td width='100%' align='left' colspan='6' style='vertical-align:top;border-right: solid 1px black;border-left: solid 1px black;'>1.</td>
                            </tr>";
                  $cRet .= "<tr $hid>
                                <td width='100%' align='left' colspan='6' style='vertical-align:top;border-right: solid 1px black;border-left: solid 1px black;'>2.</td>
                            </tr>";
                  $cRet .= "<tr $hid>
                                <td width='100%' align='left' colspan='6' style='vertical-align:top;border-right: solid 1px black;border-left: solid 1px black;'>Dst</td>
                            </tr>";
                  $cRet .= "<tr $hid>
                                <td width='100%' align='center' colspan='6' style='vertical-align:top;border-right: solid 1px black;border-left: solid 1px black;border-top: solid 1px black;'>Tim Anggaran Pemerintah Daerah</td>
                            </tr>";
                  
                            
                 
                 
        
              
        $cRet    .= "</table>";
        if($jns_an=='DPA'){
            $hid="hidden";
        }else{
            $hid="";
        }
         $cRet    .="<table $hid style='border-collapse:collapse;' width='100%' align='center' border='1' cellspacing='0' cellpadding='4'>
                    <tr>
                         <td width='10%' align='center'>No </td>
                         <td width='30%'  align='center'>Nama</td>
                         <td width='20%'  align='center'>NIP</td>
                         <td width='20%'  align='center'>Jabatan</td>
                         <td width='20%'  align='center'>Tandatangan</td>
                    </tr>";
                    $sqltim="SELECT nama as nama,nip as nip,jabatan as jab FROM tapd where kd_skpd='$id' order by no";
                     $sqltapd = $this->db->query($sqltim);
                  if ($sqltapd->num_rows() > 0){
                    
                    $no=1;
                    foreach ($sqltapd->result() as $rowtim)
                    {
                        $no=$no;                    
                        $nama= $rowtim->nama;
                        $nip= $rowtim->nip;
                        $jabatan  = $rowtim->jab;
                        $cRet .="<tr>
                         <td width='5%' align='left'>$no </td>
                         <td width='20%'  align='left'>$nama</td>
                         <td width='20%'  align='left'>$nip</td>
                         <td width='35%'  align='left'>$jabatan</td>
                         <td width='20%'  align='left'></td>
                    </tr>"; 
                    $no=$no+1;              
                  }}
                    else{
                        $cRet .="<tr>
                         <td width='5%' align='left'> 1. </td>
                         <td width='20%'  align='left'></td>
                         <td width='20%'  align='left'></td>
                         <td width='35%'  align='left'></td>
                         <td width='20%'  align='left'></td>
                        </tr>
                        <tr>
                         <td width='5%' align='left'> 2. </td>
                         <td width='20%'  align='left'></td>
                         <td width='20%'  align='left'></td>
                         <td width='35%'  align='left'></td>
                         <td width='20%'  align='left'></td>
                        </tr>
                        <tr>
                         <td width='5%' align='left'> 3. </td>
                         <td width='20%'  align='left'></td>
                         <td width='20%'  align='left'></td>
                         <td width='35%'  align='left'></td>
                         <td width='20%'  align='left'></td>
                        </tr>
                        <tr>
                         <td width='5%' align='left'> 4. </td>
                         <td width='20%'  align='left'></td>
                         <td width='20%'  align='left'></td>
                         <td width='35%'  align='left'></td>
                         <td width='20%'  align='left'></td>
                        </tr>"; 
                    }

        $cRet .=       " </table>";
        $data['prev']= $cRet;    
        $judul='RKA-rincian_belanja_'.$id.'';
        switch($cetak) { 
        case 1; 

             $this->master_pdf->_mpdf_margin('',$cRet,$kanan,$kiri,10,'1','yes',$atas,$bawah);
        break;
        case 2;        
            header("Cache-Control: no-cache, no-store, must-revalidate");
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename= $judul.xls");
            echo $cRet;
        break;
        case 3;     
            header("Cache-Control: no-cache, no-store, must-revalidate");
            header("Content-Type: application/vnd.ms-word");
            header("Content-Disposition: attachment; filename= $judul.doc");
            echo $cRet;
        break;
        case 0;  
         echo ("<title>RKA Rincian Belanja</title>");
            echo($cRet);
        break;
        }
    }
}