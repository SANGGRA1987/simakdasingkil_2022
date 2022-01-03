<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Fungsi Model
 */ 
 
class cetak_dpa_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
 
 
     function preview_dpa_skpd_pergeseran($tgl_ttd,$ttd1,$ttd2,$id,$cetak,$detail,$tanggal_ttd,$doc,$gaji, $status1, $status2){
        $sqlsc="SELECT tgl_rka,provinsi,kab_kota,daerah,thn_ang FROM sclient where kd_skpd='$id'";
        $sqlsclient=$this->db->query($sqlsc);
        foreach ($sqlsclient->result() as $rowsc){
                    $tgl=$rowsc->tgl_rka;
                    $kab     = $rowsc->kab_kota;
                    $daerah  = $rowsc->daerah;
                    $thn     = $rowsc->thn_ang;
        }

        $sqldns="SELECT a.kd_urusan as kd_u,b.header, LEFT(a.kd_skpd,20) as kd_org,b.nm_urusan as nm_u,a.kd_skpd as kd_sk,
				a.nm_skpd as nm_sk FROM ms_skpd a INNER JOIN ms_urusan b
				ON a.kd_urusan=b.kd_urusan WHERE kd_skpd='$id'";
        $sqlskpd=$this->db->query($sqldns);
        foreach ($sqlskpd->result() as $rowdns){
                    $kd_urusan=$rowdns->kd_u;                    
                    $nm_urusan= $rowdns->nm_u;
                    $kd_skpd  = $rowdns->kd_sk;
                    $nm_skpd  = $rowdns->nm_sk;
                    $header   = $rowdns->header;
                    $kd_org   = $rowdns->kd_org;
        } 

        if($status1=='nilai'){
            $status_anggaran1="";
        } else if($status1=='nilai_sempurna'){
            $status_anggaran1="_sempurna";
        } else{
            $status_anggaran1="_ubah";
        }

        if($status2=='nilai'){
            $status_anggaran2="";
            $doc='DPA';
            $rka="DOKUMEN PELAKSANAAN ANGGARAN";
        } else if($status2=='nilai_sempurna'){
            $rka="DOKUMEN PELAKSANAAN ANGGARAN";
            $status_anggaran2="_sempurna";
            $doc='DPA';
        } else{
            $status_anggaran2="_ubah";
            $rka="DOKUMEN PELAKSANAAN PERUBAHAN ANGGARAN";
            $doc='DPPA';
        }


        if($doc=='RKA'){
            $rka="RENCANA KERJA DAN ANGGARAN";
            $judul="Ringkasan Anggaran Pendapatan dan Belanja
                    <br> Satuan Kerja Perangkat Daerah";
            $tambahan="";
        }else{

            $nodpa=$this->db->query("SELECT * from trhrka where kd_skpd='$id'")->row()->no_dpa;
            $judul="Ringkasan Dokumen Pelaksanaan Anggaran Pendapatan dan Belanja Daerah
                    <br> Satuan Kerja Perangkat Daerah";
            $tambahan="<tr>
                        <td style='border-right:none'> No DPA</td>
                        <td style='border-left:none'>: $nodpa</td>
                    </tr>";
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
                    $tambahan
                    <tr>
                        <td style='border-right:none'> Organisasi</td>
                        <td style='border-left:none'>: $kd_skpd - $nm_skpd</td>
                    </tr>
                    <tr>
                        <td colspan='2' bgcolor='#CCCCCC'> &nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan='2' align='center'><strong>$judul </strong></td>
                    </tr>
                </table>";
        $cRet .= "<table style='border-collapse:collapse;font-size:12px' width='100%' align='center' border='1' cellspacing='0' cellpadding='5px'>
                     <thead>                       
                        <tr>
                            <td bgcolor='#CCCCCC' rowspan='2' width='15%' align='center'><b>KODE REKENING</b></td>                            
                            <td bgcolor='#CCCCCC' rowspan='2' width='25%' align='center'><b>URAIAN</b></td>
                            <td bgcolor='#CCCCCC' colspan='2' width='30%' align='center'><b>JUMLAH(Rp.)</b></td>
                            <td bgcolor='#CCCCCC' colspan='2' width='30%' align='center'><b>BERTAMBAH/BERKURANG </b></td>                            
                        </tr>
                        <tr>
                            <td bgcolor='#CCCCCC' width='15%' align='center'><b>SEBELUM PERGESERAN</b></td>                            
                            <td bgcolor='#CCCCCC' width='15%' align='center'><b>SESUDAH PERGESERAN</b></td>
                            <td bgcolor='#CCCCCC' width='15%' align='center'><b>(Rp.)</b></td>
                            <td bgcolor='#CCCCCC' width='15%' align='center'><b>%</b></td>                            
                        </tr>
                     </thead>
                     
                        <tr>
                            <td style='vertical-align:top;border-top: none;border-bottom: none;' width='15%' align='center'>1</td>                            
                            <td style='vertical-align:top;border-top: none;border-bottom: none;' width='25%' align='center'>2</td>
                            <td style='vertical-align:top;border-top: none;border-bottom: none;' width='15%' align='center'>3</td>
                            <td style='vertical-align:top;border-top: none;border-bottom: none;' width='15%' align='center'>4</td>                            
                            <td style='vertical-align:top;border-top: none;border-bottom: none;' width='15%' align='center'>5</td>
                            <td style='vertical-align:top;border-top: none;border-bottom: none;' width='15%' align='center'>6</td>
                        </tr>

                ";



        if($detail=='detail'){
            $rincian="  UNION ALL "."

                        SELECT a.kd_rek4 AS kd_rek,a.nm_rek4 AS nm_rek ,
                        isnull(SUM(b.nilai$status_anggaran1),0) AS nilai, isnull(SUM(b.nilai$status_anggaran2),0) AS nilai2 FROM ms_rek4 a INNER JOIN trdrka b ON a.kd_rek4=LEFT(b.kd_rek6,(len(a.kd_rek4)))
                        where left(b.kd_rek6,1)='4' and left(b.kd_skpd,17)=left('$id',17)  
                        GROUP BY a.kd_rek4, a.nm_rek4  
                        UNION ALL 

                        SELECT a.kd_rek5 AS kd_rek,a.nm_rek5 AS nm_rek ,
                        isnull(SUM(b.nilai$status_anggaran1),0) AS nilai, isnull(SUM(b.nilai$status_anggaran2),0) AS nilai2 FROM ms_rek5 a INNER JOIN trdrka b ON a.kd_rek5=LEFT(b.kd_rek6,(len(a.kd_rek5)))
                        where left(b.kd_rek6,1)='4' and left(b.kd_skpd,17)=left('$id',17) 
                        GROUP BY a.kd_rek5, a.nm_rek5 
                        UNION ALL 

                        SELECT a.kd_rek6 AS kd_rek,a.nm_rek6 AS nm_rek ,
                        isnull(SUM(b.nilai$status_anggaran1),0) AS nilai, isnull(SUM(b.nilai$status_anggaran2),0) AS nilai2 FROM ms_rek6 a INNER JOIN trdrka b ON a.kd_rek6=LEFT(b.kd_rek6,(len(a.kd_rek6)))
                        where left(b.kd_rek6,1)='4' and left(b.kd_skpd,17)=left('$id',17) 
                        GROUP BY a.kd_rek6, a.nm_rek6";
        }else{ $rincian='';}
        
        $sql1="SELECT a.kd_rek1 AS kd_rek, a.nm_rek1 AS nm_rek ,isnull(SUM(b.nilai$status_anggaran1),0) AS nilai, isnull(SUM(b.nilai$status_anggaran2),0) AS nilai2 FROM ms_rek1 a 
                INNER JOIN trdrka b ON a.kd_rek1=LEFT(b.kd_rek6,(len(a.kd_rek1))) where left(b.kd_rek6,1)='4' 
                and left(b.kd_skpd,17)=left('$id',17) GROUP BY a.kd_rek1, a.nm_rek1 

                UNION ALL 

                SELECT a.kd_rek2 AS kd_rek,a.nm_rek2 AS nm_rek ,isnull(SUM(b.nilai$status_anggaran1),0) AS nilai, isnull(SUM(b.nilai$status_anggaran2),0) AS nilai2 FROM ms_rek2 a INNER JOIN trdrka b 
                ON a.kd_rek2=LEFT(b.kd_rek6,(len(a.kd_rek2))) where left(b.kd_rek6,1)='4' and left(b.kd_skpd,17)=left('$id',17) 
                GROUP BY a.kd_rek2,a.nm_rek2 

                UNION ALL 

                SELECT a.kd_rek3 AS kd_rek,a.nm_rek3 AS nm_rek, isnull(SUM(b.nilai$status_anggaran1),0) AS nilai, isnull(SUM(b.nilai$status_anggaran2),0) AS nilai2 FROM ms_rek3 a INNER JOIN trdrka b ON a.kd_rek3=LEFT(b.kd_rek6,(len(a.kd_rek3)))
                where left(b.kd_rek6,1)='4' and left(b.kd_skpd,17)=left('$id',17) 
                GROUP BY a.kd_rek3, a.nm_rek3 
                $rincian
                ORDER BY kd_rek";
                 
        $query = $this->db->query($sql1);
        if ($query->num_rows() > 0){                                  
            foreach ($query->result() as $row){
                    $coba1=$this->support->dotrek($row->kd_rek);
                    $coba2=$row->nm_rek;
                    $coba3= number_format($row->nilai,"2",",",".");
                    $nilai4= number_format($row->nilai2,"2",",",".");
                    $selisih=$this->support->rp_minus($row->nilai2-$row->nilai);
                    if($row->nilai==0){
                         $persen=$this->support->rp_minus(0);
                    }else{
                        $persen=$this->support->rp_minus((($row->nilai2-$row->nilai)/$row->nilai)*100);
                    }

                    $cRet.= " <tr>
                                <td style='vertical-align:top;border-top: solid 1px black;border-bottom: none;'  align='left'>&nbsp;$coba1</td>                                     
                                <td style='vertical-align:top;border-top: solid 1px black;border-bottom: none;' >&nbsp;$coba2</td>
                                <td style='vertical-align:top;border-top: solid 1px black;border-bottom: none;'  align='right'>&nbsp;$coba3</td>
                                <td style='vertical-align:top;border-top: solid 1px black;border-bottom: none;'  align='right'>&nbsp;$nilai4</td>                                     
                                <td style='vertical-align:top;border-top: solid 1px black;border-bottom: none;'  align='right'>&nbsp;$selisih</td>
                                <td style='vertical-align:top;border-top: solid 1px black;border-bottom: none;'  align='right'>&nbsp;$persen</td>
                             </tr>";                     
            }
        }else{
                $cRet .= " <tr>
                            <td style='vertical-align:top;border-top: solid 1px black;border-bottom: none;'  align='left'>4</td>                                     
                            <td style='vertical-align:top;border-top: solid 1px black;border-bottom: none;' > PENDAPATAN </td>
                            <td style='vertical-align:top;border-top: solid 1px black;border-bottom: none;'  align='right'>".number_format(0,"2",",",".")."</td>
                            <td style='vertical-align:top;border-top: solid 1px black;border-bottom: none;'  align='right'>".number_format(0,"2",",",".")."</td>                                     
                            <td style='vertical-align:top;border-top: solid 1px black;border-bottom: none;'  align='right'>".number_format(0,"2",",",".")."</td>
                            <td style='vertical-align:top;border-top: solid 1px black;border-bottom: none;'  align='right'>".number_format(0,"2",",",".")."</td>
                          </tr>";
                    
                
        }                                 
                
        $sqltp="SELECT isnull(SUM(nilai$status_anggaran1),0) AS totp, isnull(SUM(nilai$status_anggaran2),0) AS totp1 FROM trdrka WHERE LEFT(kd_rek6,1)='4' and left(kd_skpd,17)=left('$id',17)";
        $sqlp=$this->db->query($sqltp);
        foreach ($sqlp->result() as $rowp){

            $coba4=number_format($rowp->totp,"2",",",".");
            $coba42=number_format($rowp->totp1,"2",",",".");
            $selisih=$this->support->rp_minus($rowp->totp1-$rowp->totp);
            if($rowp->totp1==0){
                $persen=number_format($rowp->totp,"2",",",".");
            }else{
                $persen=$this->support->rp_minus((($rowp->totp1-$rowp->totp)/$rowp->totp)*100);
            }

            $cob1=$rowp->totp;
            $total_pendapatan=$rowp->totp1;
                   
            $cRet    .= "<tr>
                            <td style='vertical-align:top;border-top: solid 1px black;border-bottom: none;'  align='left'></td>                                     
                            <td style='vertical-align:top;border-top: solid 1px black;border-bottom: none;'  align='right'>Jumlah Pendapatan</td>
                            <td style='vertical-align:top;border-top: solid 1px black;border-bottom: none;'  align='right'>$coba4</td>
                            <td style='vertical-align:top;border-top: solid 1px black;border-bottom: none;'  align='right'>$coba42</td>                                     
                            <td style='vertical-align:top;border-top: solid 1px black;border-bottom: none;'  align='right'>$selisih</td>
                            <td style='vertical-align:top;border-top: solid 1px black;border-bottom: none;'  align='right'>$persen</td>
                        </tr>
                        <tr>
                            <td style='vertical-align:top;border-top: solid 1px black;border-bottom: none;'  align='left'></td>                                     
                            <td style='vertical-align:top;border-top: solid 1px black;border-bottom: none;' >&nbsp;</td>
                            <td style='vertical-align:top;border-top: solid 1px black;border-bottom: none;'  align='right'></td>
                            <td style='vertical-align:top;border-top: solid 1px black;border-bottom: none;'  align='right'></td>                                     
                            <td style='vertical-align:top;border-top: solid 1px black;border-bottom: none;' >&nbsp;</td>
                            <td style='vertical-align:top;border-top: solid 1px black;border-bottom: none;'  align='right'></td>
                        </tr>";
        }

        if($gaji==1){
            $aktifkanGaji="and right(b.kd_subkegiatan,10) <> '01.2.02.01' ";
        }else{
            $aktifkanGaji="";
        }

        if($detail=='detail'){
            $rincian="  UNION ALL "." 
                        SELECT a.kd_rek4 AS kd_rek,a.kd_rek4 AS rek,a.nm_rek4 AS nm_rek ,isnull(SUM(b.nilai$status_anggaran1),0) AS nilai, isnull(sum(b.nilai$status_anggaran2),0) as nilai2 FROM ms_rek4 a 
                        INNER JOIN trdrka b ON a.kd_rek4=LEFT(b.kd_rek6,(len(a.kd_rek4))) WHERE LEFT(kd_rek6,1)='5' AND left(b.kd_skpd,17)=left('$id',17) $aktifkanGaji
                        GROUP BY a.kd_rek4, a.nm_rek4 
                        UNION ALL 
                        SELECT a.kd_rek5 AS kd_rek,a.kd_rek5 AS rek,a.nm_rek5 AS nm_rek ,isnull(SUM(b.nilai$status_anggaran1),0) AS nilai, isnull(sum(b.nilai$status_anggaran2),0) as nilai2 FROM ms_rek5 a 
                        INNER JOIN trdrka b ON a.kd_rek5=LEFT(b.kd_rek6,(len(a.kd_rek5))) WHERE LEFT(kd_rek6,1)='5' AND left(b.kd_skpd,17)=left('$id',17) $aktifkanGaji
                        GROUP BY a.kd_rek5, a.nm_rek5 
                        UNION ALL 
                        SELECT a.kd_rek6 AS kd_rek,a.kd_rek6 AS rek,a.nm_rek6 AS nm_rek ,isnull(SUM(b.nilai$status_anggaran1),0) AS nilai, isnull(sum(b.nilai$status_anggaran2),0) as nilai2 FROM ms_rek6 a 
                        INNER JOIN trdrka b ON a.kd_rek6=b.kd_rek6 WHERE LEFT(b.kd_rek6,1)='5' AND left(b.kd_skpd,17)=left('$id',17) $aktifkanGaji
                        GROUP BY a.kd_rek6, a.nm_rek6";
        }else{ $rincian='';}     
                $sql2="SELECT a.kd_rek1 AS kd_rek, a.kd_rek1 AS rek, a.nm_rek1 AS nm_rek ,isnull(SUM(b.nilai$status_anggaran1),0) AS nilai, isnull(sum(b.nilai$status_anggaran2),0) as nilai2 FROM ms_rek1 a 
                        INNER JOIN trdrka b ON a.kd_rek1=LEFT(b.kd_rek6,(len(a.kd_rek1))) WHERE LEFT(kd_rek6,1)='5' AND left(b.kd_skpd,17)=left('$id',17) $aktifkanGaji
                        GROUP BY a.kd_rek1, a.nm_rek1 
                        UNION ALL 
                        SELECT a.kd_rek2 AS kd_rek,a.kd_rek2 AS rek,a.nm_rek2 AS nm_rek ,isnull(SUM(b.nilai$status_anggaran1),0) AS nilai, isnull(sum(b.nilai$status_anggaran2),0) as nilai2 FROM ms_rek2 a 
                        INNER JOIN trdrka b ON a.kd_rek2=LEFT(b.kd_rek6,(len(a.kd_rek2))) WHERE LEFT(kd_rek6,1)='5' AND left(b.kd_skpd,17)=left('$id',17) $aktifkanGaji
                        GROUP BY a.kd_rek2,a.nm_rek2 
                        UNION ALL 
                        SELECT a.kd_rek3 AS kd_rek,a.kd_rek3 AS rek,a.nm_rek3 AS nm_rek ,isnull(SUM(b.nilai$status_anggaran1),0) AS nilai, isnull(sum(b.nilai$status_anggaran2),0) as nilai2 FROM ms_rek3 a 
                        INNER JOIN trdrka b ON a.kd_rek3=LEFT(b.kd_rek6,(len(a.kd_rek3))) WHERE LEFT(kd_rek6,1)='5' AND left(b.kd_skpd,17)=left('$id',17) $aktifkanGaji
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
                    $nilai5= number_format($row1->nilai2,"2",",",".");
                    $selisih=$this->support->rp_minus($row1->nilai2-$row1->nilai);
					if($row1->nilai==0){
						$persen=0;
					}else{
						$persen=$this->support->rp_minus((($row1->nilai2-$row1->nilai)/$row1->nilai)*100);	
					}
                   
                 //  $persen=99;
                     $cRet    .= " <tr>
                                     <td style='vertical-align:top;'  align='left'>&nbsp;$coba5</td>                                     
                                     <td style='vertical-align:top;' >&nbsp;$coba6</td>
                                     <td style='vertical-align:top;'  align='right'>&nbsp;$coba7</td>
                                     <td style='vertical-align:top;'  align='right'>&nbsp;$nilai5</td>                                     
                                     <td style='vertical-align:top;'  align='right'>&nbsp;$selisih</td>
                                     <td style='vertical-align:top;'  align='right'>&nbsp;$persen</td>
                                    </tr>";
                }

                if($gaji==1){
                    $aktifkanGaji="and right(kd_subkegiatan,10) <> '01.2.02.01' ";
                }else{
                    $aktifkanGaji="";
                }     

                $sqltb="SELECT SUM(nilai$status_anggaran1) AS totb, SUM(nilai$status_anggaran2) AS totb1 FROM trdrka WHERE LEFT(kd_rek6,1)='5' and left(kd_skpd,17)=left('$id',17) $aktifkanGaji";
                $sqlb=$this->db->query($sqltb);
                foreach ($sqlb->result() as $rowb)
                {
                   $coba8=number_format($rowb->totb,"2",",",".");
                   $coba81=number_format($rowb->totb1,"2",",",".");
                    $cob=$rowb->totb;
                    $selisih=$this->support->rp_minus($rowb->totb1-$rowb->totb);
                    $persen=$this->support->rp_minus((($rowb->totb1-$rowb->totb)/$rowb->totb)*100);
                    $total_belanja=$rowb->totb1;
                    $cRet    .= " <tr>
                                     <td style='vertical-align:top;'  align='left'></td>                                     
                                     <td style='vertical-align:top;'  align='right'>Jumlah Belanja</td>
                                     <td style='vertical-align:top;'  align='right'>$coba8</td>
                                     <td style='vertical-align:top;'  align='right'> $coba81</td>                                     
                                     <td style='vertical-align:top;'  align='right'> $selisih</td>
                                     <td style='vertical-align:top;'  align='right'>$persen</td>
                                </tr>";
                 }
                    $cRet    .= " <tr>
                                     <td style='vertical-align:top;'  align='left'></td>                                     
                                     <td style='vertical-align:top;'  align='right'></td>
                                     <td style='vertical-align:top;'  align='right'>&nbsp;</td>
                                     <td style='vertical-align:top;'  align='left'></td>                                     
                                     <td style='vertical-align:top;'  align='right'></td>
                                     <td style='vertical-align:top;'  align='right'>&nbsp;</td>
                                  </tr>";
                 
                  $surplus=$cob1-$cob;
                  $surplus2=$total_pendapatan-$total_belanja; 
                    
                    $cRet .= " <tr>   
                                    <td></td>                                 
                                     <td style='vertical-align:top;border-top: solid 1px black;' align='right'>Surplus/Defisit</td>
                                     <td style='vertical-align:top;border-top: solid 1px black;'  align='right'>".$this->rka_model->angka($surplus)."</td>
                                     <td style='vertical-align:top;border-top: solid 1px black;' align='right'>".$this->rka_model->angka($surplus2)."</td>                                 
                                     <td style='vertical-align:top;border-top: solid 1px black;' align='right'>".$this->support->rp_minus($surplus-$surplus2)."</td>
                                     <td style='vertical-align:top;border-top: solid 1px black;'  align='right'>".$this->support->rp_minus((($surplus-$surplus2)/$surplus2)*100)."</td>
                            </tr>"; 

                    
                $sqltpm="SELECT isnull(SUM(nilai$status_anggaran1),0) AS totb, isnull(SUM(nilai$status_anggaran2),0) AS totb2 FROM trdrka WHERE LEFT(kd_rek6,1)='6' and left(kd_skpd,17)=left('$id',17)";
                $sqltpm=$this->db->query($sqltpm);
                foreach ($sqltpm->result() as $rowtpm)
                {
                    $coba12=number_format($rowtpm->totb,"2",",",".");
                    $coba12x=number_format($rowtpm->totb2,"2",",",".");
                    $selisih=$this->support->rp_minus($rowtpm->totb2-$rowtpm->totb);
                    
                    $cobtpm=$rowtpm->totb;
                    if($cobtpm>0){
                        $persen=$this->support->rp_minus((($rowtpm->totb2-$rowtpm->totb)/$rowtpm->totb)*100);
                    $cRet    .= " <tr>
                                     <td style='vertical-align:top;'  align='left'></td>                                     
                                     <td style='vertical-align:top;'  align='right'></td>
                                     <td style='vertical-align:top;'  align='right'>&nbsp;</td>
                                     <td style='vertical-align:top;'  align='left'></td>                                     
                                     <td style='vertical-align:top;'  align='right'></td>
                                     <td style='vertical-align:top;'  align='right'>&nbsp;</td>
                                    </tr>";

                        $cRet    .= "<tr>
                                        <td style='vertical-align:top;'  align='left'>6</td>                                     
                                         <td style='vertical-align:top;' >Pembiayaan</td>
                                         <td style='vertical-align:top;'  align='right'>$coba12
                                     <td style='vertical-align:top;'  align='right'>$coba12x</td>                                     
                                     <td style='vertical-align:top;'  align='right'>$selisih</td>
                                     <td style='vertical-align:top;'  align='right'> $persen</td>
                                    </td>
                                    </tr>";
                        if($detail=='detail'){
                            $rincian="  UNION ALL "." 
                                        SELECT a.kd_rek4 AS kd_rek,a.kd_rek4 AS rek,a.nm_rek4 AS nm_rek ,SUM(b.nilai$status_anggaran1) AS nilai, SUM(b.nilai$status_anggaran2) AS nilai2 FROM ms_rek4 a 
                                        INNER JOIN trdrka b ON a.kd_rek4=LEFT(b.kd_rek6,(len(a.kd_rek4))) WHERE LEFT(kd_rek6,2)='61' AND left(b.kd_skpd,17)=left('$id',17) 
                                        GROUP BY a.kd_rek4, a.nm_rek4 
                                        UNION ALL 
                                        SELECT a.kd_rek5 AS kd_rek,a.kd_rek5 AS rek,a.nm_rek5 AS nm_rek ,SUM(b.nilai$status_anggaran1) AS nilai, SUM(b.nilai$status_anggaran2) AS nilai2 FROM ms_rek5 a 
                                        INNER JOIN trdrka b ON a.kd_rek5=LEFT(b.kd_rek6,(len(a.kd_rek5))) WHERE LEFT(kd_rek6,2)='61' AND left(b.kd_skpd,17)=left('$id',17) 
                                        GROUP BY a.kd_rek5, a.nm_rek5 
                                        UNION ALL 
                                        SELECT a.kd_rek6 AS kd_rek,a.kd_rek6 AS rek,a.nm_rek6 AS nm_rek ,SUM(b.nilai$status_anggaran1) AS nilai, SUM(b.nilai$status_anggaran2) AS nilai2 FROM ms_rek6 a 
                                        INNER JOIN trdrka b ON a.kd_rek6=b.kd_rek6 WHERE LEFT(b.kd_rek6,2)='61' AND left(b.kd_skpd,17)=left('$id',17) 
                                        GROUP BY a.kd_rek6, a.nm_rek6 ";
                        }else{$rincian='';}

                        $sqlpm="
                        SELECT a.kd_rek2 AS kd_rek,a.kd_rek2 AS rek,a.nm_rek2 AS nm_rek ,SUM(b.nilai$status_anggaran1) AS nilai, SUM(b.nilai$status_anggaran2) AS nilai2 FROM ms_rek2 a 
                        INNER JOIN trdrka b ON a.kd_rek2=LEFT(b.kd_rek6,(len(a.kd_rek2))) WHERE LEFT(kd_rek6,2)='61' AND left(b.kd_skpd,17)=left('$id',17) GROUP BY a.kd_rek2,a.nm_rek2 
                        UNION ALL 
                        SELECT a.kd_rek3 AS kd_rek,a.kd_rek3 AS rek,a.nm_rek3 AS nm_rek ,SUM(b.nilai$status_anggaran1) AS nilai, SUM(b.nilai$status_anggaran2) AS nilai2 FROM ms_rek3 a 
                        INNER JOIN trdrka b ON a.kd_rek3=LEFT(b.kd_rek6,(len(a.kd_rek3))) WHERE LEFT(kd_rek6,2)='61' AND left(b.kd_skpd,17)=left('$id',17) 
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
                            $nilai2= number_format($rowpm->nilai2,"2",",",".");
                            $selisih=$this->support->rp_minus($rowpm->nilai2-$rowpm->nilai);
                            $persen=$this->support->rp_minus((($rowpm->nilai2-$rowpm->nilai)/$rowpm->nilai)*100);
                           
                             $cRet    .= " <tr><td style='vertical-align:top;border-top: solid 1px black;'  align='left'>$coba9</td>                                     
                                             <td style='vertical-align:top;border-top: solid 1px black;' >$coba10</td>
                                             <td style='vertical-align:top;border-top: solid 1px black;'  align='right'>$coba11</td>
                                                <td style='vertical-align:top;border-top: solid 1px black;'  align='right'>$nilai2</td>                                     
                                             <td style='vertical-align:top;border-top: solid 1px black;'  align='right'>$selisih</td>
                                             <td style='vertical-align:top;border-top: solid 1px black;'  align='right'>$persen</td>
                                            </tr>";
                        } 


                        $sqltpm="SELECT SUM(nilai$status_anggaran1) AS totb, SUM(nilai$status_anggaran2) AS totb2 FROM trdrka WHERE LEFT(kd_rek6,2)='61' and left(kd_skpd,17)=left('$id',17)";
                                            $sqltpm=$this->db->query($sqltpm);
                                         foreach ($sqltpm->result() as $rowtpm)
                                        {
                                            $coba12=number_format($rowtpm->totb,"2",",",".");
                                            $nilai2=number_format($rowtpm->totb2,"2",",",".");
                                            $selisih=$this->support->rp_minus($rowtpm->totb2-$rowtpm->totb);
                                            $persen=$this->support->rp_minus((($rowtpm->totb2-$rowtpm->totb)/$rowtpm->totb)*100);
                                            $cobtpm=$rowtpm->totb;
                                            $cobtpm2=$rowtpm->totb2;
                                            $cRet    .= " <tr><td style='vertical-align:top;border-top: solid 1px black;'  align='left'></td>                                     
                                                             <td style='vertical-align:top;border-top: solid 1px black;'  align='right'>Jumlah Penerimaan Pembiayaan</td>
                                                             <td style='vertical-align:top;border-top: solid 1px black;'  align='right'>$coba12</td>
                                                    <td style='vertical-align:top;border-top: solid 1px black;'  align='right'>$nilai2</td>                                     
                                             <td style='vertical-align:top;border-top: solid 1px black;'  align='right'>$selisih</td>
                                             <td style='vertical-align:top;border-top: solid 1px black;'  align='right'>$persen</td>
                                                        </tr>";
                                         } 

                        if($detail=='detail'){
                            $rincian="  UNION ALL "." 
                                        SELECT a.kd_rek4 AS kd_rek,a.kd_rek4 AS rek,a.nm_rek4 AS nm_rek ,SUM(b.nilai$status_anggaran1) AS nilai, SUM(b.nilai$status_anggaran2) AS nilai2 FROM ms_rek4 a 
                                        INNER JOIN trdrka b ON a.kd_rek4=LEFT(b.kd_rek6,(len(a.kd_rek4))) WHERE LEFT(kd_rek6,2)='62' AND left(b.kd_skpd,17)=left('$id',17) 
                                        GROUP BY a.kd_rek4, a.nm_rek4 
                                        UNION ALL 
                                        SELECT a.kd_rek5 AS kd_rek,a.kd_rek5 AS rek,a.nm_rek5 AS nm_rek ,SUM(b.nilai$status_anggaran1) AS nilai, SUM(b.nilai$status_anggaran2) AS nilai2 FROM ms_rek5 a 
                                        INNER JOIN trdrka b ON a.kd_rek5=LEFT(b.kd_rek6,(len(a.kd_rek5))) WHERE LEFT(kd_rek6,2)='62' AND left(b.kd_skpd,17)=left('$id',17) 
                                        GROUP BY a.kd_rek5, a.nm_rek5 
                                        UNION ALL 
                                        SELECT a.kd_rek6 AS kd_rek,a.kd_rek6 AS rek,a.nm_rek6 AS nm_rek ,SUM(b.nilai$status_anggaran1) AS nilai, SUM(b.nilai$status_anggaran2) AS nilai2 FROM ms_rek6 a 
                                        INNER JOIN trdrka b ON a.kd_rek6=b.kd_rek6 WHERE LEFT(b.kd_rek6,2)='62' AND left(b.kd_skpd,17)=left('$id',17) 
                                        GROUP BY a.kd_rek6, a.nm_rek6 ";
                        }else{$rincian='';}

                        $sqlpk="
                        SELECT a.kd_rek2 AS kd_rek,a.kd_rek2 AS rek,a.nm_rek2 AS nm_rek ,SUM(b.nilai$status_anggaran1) AS nilai, SUM(b.nilai$status_anggaran2) AS nilai2 FROM ms_rek2 a 
                        INNER JOIN trdrka b ON a.kd_rek2=LEFT(b.kd_rek6,(len(a.kd_rek2))) WHERE LEFT(kd_rek6,2)='62' AND left(b.kd_skpd,17)=left('$id',17) GROUP BY a.kd_rek2,a.nm_rek2 
                        UNION ALL 
                        SELECT a.kd_rek3 AS kd_rek,a.kd_rek3 AS rek,a.nm_rek3 AS nm_rek ,SUM(b.nilai$status_anggaran1) AS nilai, SUM(b.nilai$status_anggaran2) AS nilai2 FROM ms_rek3 a 
                        INNER JOIN trdrka b ON a.kd_rek3=LEFT(b.kd_rek6,(len(a.kd_rek3))) WHERE LEFT(kd_rek6,2)='62' AND left(b.kd_skpd,17)=left('$id',17) 
                        GROUP BY a.kd_rek3, a.nm_rek3 
                        $rincian
                        ORDER BY kd_rek";
                 
                         $querypk= $this->db->query($sqlpk);
                         foreach ($querypk->result() as $rowpk){
                            $coba9=$this->support->dotrek($rowpk->rek);
                            $coba10=$rowpk->nm_rek;
                            $coba11= number_format($rowpk->nilai,"2",",",".");
                            $nilai2= number_format($rowpk->nilai2,"2",",",".");
                            $selisih=$this->support->rp_minus($rowpk->nilai2-$rowpk->nilai);
                            $persen=$this->support->rp_minus((($rowpk->nilai2-$rowpk->nilai)/$rowpk->nilai)*100);
                           
                             $cRet    .= " <tr><td style='vertical-align:top;border-top: solid 1px black;'  align='left'>$coba9</td>                                     
                                             <td style='vertical-align:top;border-top: solid 1px black;' >$coba10</td>
                                             <td style='vertical-align:top;border-top: solid 1px black;'  align='right'>$coba11</td>
                                             <td style='vertical-align:top;border-top: solid 1px black;'  align='right'>$nilai2</td>                                     
                                             <td style='vertical-align:top;border-top: solid 1px black;'  align='right'>$selisih</td>
                                             <td style='vertical-align:top;border-top: solid 1px black;'  align='right'>$persen</td>
                                             </tr>";
                        } 


                        $sqltpk="SELECT SUM(nilai$status_anggaran1) AS totb, SUM(nilai$status_anggaran2) AS totb2 FROM trdrka WHERE LEFT(kd_rek6,2)='62' and left(kd_skpd,17)=left('$id',17)";
                    $sqltpk=$this->db->query($sqltpk);
                 foreach ($sqltpk->result() as $rowtpk)
                {
                   $cobatpk=number_format($rowtpk->totb,"2",",",".");
                    $cobtpk=$rowtpk->totb;
                    $cobtpk2=$rowtpk->totb2;
                    $nilai2= number_format($rowtpk->totb2,"2",",",".");
                    $selisih=$this->support->rp_minus($rowtpk->totb2-$rowtpk->totb);
                    $persen=$this->support->rp_minus((($rowtpk->totb2-$rowtpk->totb)/$rowtpk->totb)*100);

                    $cRet    .= " <tr><td style='vertical-align:top;border-top: solid 1px black;'  align='left'></td>                                     
                                     <td style='vertical-align:top;border-top: solid 1px black;'  align='right'>Jumlah Pengeluaran Pembiayaan</td>
                                     <td style='vertical-align:top;border-top: solid 1px black;'  align='right'>$cobatpk</td>
                                     <td style='vertical-align:top;border-top: solid 1px black;'  align='right'>$nilai2</td>                                     
                                             <td style='vertical-align:top;border-top: solid 1px black;'  align='right'>$selisih</td>
                                             <td style='vertical-align:top;border-top: solid 1px black;'  align='right'>$persen</td>
                                             </tr>";
                 }
    
                $pnetto=$cobtpm-$cobtpk;
                $pnetto2=$cobtpm2-$cobtpk2;
                $selisih=$pnetto2-$pnetto;
                $persen=$this->support->rp_minus(($selisih/$pnetto2)*100);

                    $cRet    .= " <tr>                                     
                                     <td colspan='2' style='vertical-align:top;border-top: solid 1px black;' align='right' >Pembiayaan Netto</td>
                                     <td style='vertical-align:top;border-top: solid 1px black;'  align='right'>".$this->rka_model->angka($pnetto)."</td>
                                     <td style='vertical-align:top;border-top: solid 1px black;'  align='right'>".$this->rka_model->angka($pnetto2)."</td>                                     
                                             <td style='vertical-align:top;border-top: solid 1px black;'  align='right'>".$this->rka_model->angka($selisih)."</td>
                                             <td style='vertical-align:top;border-top: solid 1px black;'  align='right'>$persen</td>
                                             </tr></table>";                                                      
                    

                    } /*end if pembiayaan 0*/

                } 
               
                $cRet    .= "</table>";

                $angkas5=$this->db->query("SELECT  kd_skpd, 
                                                isnull(sum(case WHEN bulan=1 then nilai else 0 end ),0) as jan,
                                                isnull(sum(case WHEN bulan=2 then nilai else 0 end ),0) as feb,
                                                isnull(sum(case WHEN bulan=3 then nilai else 0 end ),0) as mar,
                                                isnull(sum(case WHEN bulan=4 then nilai else 0 end ),0) as apr,
                                                isnull(sum(case WHEN bulan=5 then nilai else 0 end ),0) as mei,
                                                isnull(sum(case WHEN bulan=6 then nilai else 0 end ),0) as jun,
                                                isnull(sum(case WHEN bulan=7 then nilai else 0 end ),0) as jul,
                                                isnull(sum(case WHEN bulan=8 then nilai else 0 end ),0) as ags,
                                                isnull(sum(case WHEN bulan=9 then nilai else 0 end ),0) as sept,
                                                isnull(sum(case WHEN bulan=10 then nilai else 0 end ),0) as okt,
                                                isnull(sum(case WHEN bulan=11 then nilai else 0 end ),0) as nov,
                                                isnull(sum(case WHEN bulan=12 then nilai else 0 end ),0) as des from (
                                                select bulan, left(kd_skpd,17)+'.0000' kd_skpd , sum(nilai$status_anggaran2) nilai from trdskpd_ro WHERE left(kd_rek6,1)='5' GROUP BY bulan, left(kd_skpd,17)
                                                ) okey where kd_skpd='$id' GROUP BY kd_skpd ")->row();
                $angkas4=$this->db->query(" 
                                                SELECT isnull(kd_skpd,'$id') kd_skpd, 
                                                isnull(sum(case WHEN bulan=1 then nilai else 0 end ),0) as jan,
                                                isnull(sum(case WHEN bulan=2 then nilai else 0 end ),0) as feb,
                                                isnull(sum(case WHEN bulan=3 then nilai else 0 end ),0) as mar,
                                                isnull(sum(case WHEN bulan=4 then nilai else 0 end ),0) as apr,
                                                isnull(sum(case WHEN bulan=5 then nilai else 0 end ),0) as mei,
                                                isnull(sum(case WHEN bulan=6 then nilai else 0 end ),0) as jun,
                                                isnull(sum(case WHEN bulan=7 then nilai else 0 end ),0) as jul,
                                                isnull(sum(case WHEN bulan=8 then nilai else 0 end ),0) as ags,
                                                isnull(sum(case WHEN bulan=9 then nilai else 0 end ),0) as sept,
                                                isnull(sum(case WHEN bulan=10 then nilai else 0 end ),0) as okt,
                                                isnull(sum(case WHEN bulan=11 then nilai else 0 end ),0) as nov,
                                                isnull(sum(case WHEN bulan=12 then nilai else 0 end ),0) as des from (
                                                select bulan, left(kd_skpd,17)+'.0000' kd_skpd , sum(nilai$status_anggaran2) nilai from trdskpd_ro WHERE left(kd_rek6,1)='4' GROUP BY bulan, left(kd_skpd,17)
                                                ) okey where kd_skpd='$id' GROUP BY kd_skpd
                                                union all 
                                                select '$id' kd_skpd, 0,0,0,0,0,0,0,0,0,0,0,0
                                                 ")->row();

               
  if($ttd1!='tanpa'){ 
            $sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab, pangkat as pangkat FROM ms_ttd WHERE  id='$ttd1' ";
            $sqlttd=$this->db->query($sqlttd1);
            foreach ($sqlttd->result() as $rowttd){
                        $nip=$rowttd->nip;  
                        $pangkat=$rowttd->pangkat;  
                        $nama= $rowttd->nm;
                        $jabatan  = $rowttd->jab;
            }
              
            $tambahan="<td rowspan='14' align='center' width='40%'>                                <br>$daerah, $tanggal_ttd <br>
                                $jabatan 
                                <br><br>
                                <br><br>
                                <br><br>
                                <b>$nama</b><br>
                                <u>$nip</u>
                        


                                </td>";
              
        }else{
            $tambahan="";
        }

                $cRet .="<table border='1' width='100%' cellpadding='5' cellspacing='5' style='border-collapse: collapse; font-size:12px'>
                            <tr>
                                <td colspan='2' align='center' width='30%'>Rencana Realisasi Penerimaan Per Bulan</td>
                                <td colspan='2' align='center' width='30%'>Rencana Penarikan Dana Per Bulan</td>
                                $tambahan
                            </tr>
                            <tr>
                                <td width='8%'>Januari</td>
                                <td width='7%' align='right'>".number_format($angkas4->jan,'2',',','.')."</td> 
                                <td width='8%'>Januari</td>
                                <td width='7%' align='right'>".number_format($angkas5->jan,'2',',','.')."</td>                                
                            </tr>
                            <tr>
                                <td width='8%'>Februari</td>
                                <td width='7%' align='right'>".number_format($angkas4->feb,'2',',','.')."</td> 
                                <td width='8%'>Februari</td>
                                <td width='7%' align='right'>".number_format($angkas5->feb,'2',',','.')."</td>                                 
                            </tr>
                            <tr>
                                <td width='8%'>Maret</td>
                                <td width='7%' align='right'>".number_format($angkas4->mar,'2',',','.')."</td> 
                                <td width='8%'>Maret</td>
                                <td width='7%' align='right'>".number_format($angkas5->mar,'2',',','.')."</td>                                
                            </tr>
                            <tr>
                                <td width='8%'>April</td>
                                <td width='7%' align='right'>".number_format($angkas4->apr,'2',',','.')."</td> 
                                <td width='8%'>April</td>
                                <td width='7%' align='right'>".number_format($angkas5->apr,'2',',','.')."</td>                                
                            </tr>
                            <tr>
                                <td width='8%'>Mei</td>
                                <td width='7%' align='right'>".number_format($angkas4->mei,'2',',','.')."</td> 
                                <td width='8%'>Mei</td>
                                <td width='7%' align='right'>".number_format($angkas5->mei,'2',',','.')."</td>                                 
                            </tr>
                            <tr>
                                <td width='8%'>Juni</td>
                                <td width='7%' align='right'>".number_format($angkas4->jun,'2',',','.')."</td> 
                                <td width='8%'>Juni</td>
                                <td width='7%' align='right'>".number_format($angkas5->jun,'2',',','.')."</td>                                 
                            </tr>
                            <tr>
                                <td width='8%'>Juli</td>
                                <td width='7%' align='right'>".number_format($angkas4->jul,'2',',','.')."</td> 
                                <td width='8%'>Juli</td>
                                <td width='7%' align='right'>".number_format($angkas5->jul,'2',',','.')."</td>                                 
                            </tr>
                            <tr>
                                <td width='8%'>Agustus</td>
                                <td width='7%' align='right'>".number_format($angkas4->ags,'2',',','.')."</td> 
                                <td width='8%'>Agustus</td>
                                <td width='7%' align='right'>".number_format($angkas5->ags,'2',',','.')."</td>                                 
                            </tr>
                            <tr>
                                <td width='8%'>September</td>
                                <td width='7%' align='right'>".number_format($angkas4->sept,'2',',','.')."</td> 
                                <td width='8%'>September</td>
                                <td width='7%' align='right'>".number_format($angkas5->sept,'2',',','.')."</td>                                 
                            </tr>
                            <tr>
                                <td width='8%'>Oktober</td>
                                <td width='7%' align='right'>".number_format($angkas4->okt,'2',',','.')."</td> 
                                <td width='8%'>Oktober</td>
                                <td width='7%' align='right'>".number_format($angkas5->okt,'2',',','.')."</td>                                 
                            </tr>
                            <tr>
                                <td width='8%'>November</td>
                                <td width='7%' align='right'>".number_format($angkas4->nov,'2',',','.')."</td> 
                                <td width='8%'>November</td>
                                <td width='7%' align='right'>".number_format($angkas5->nov,'2',',','.')."</td>                                 
                            </tr>
                            <tr>
                                <td width='8%'>Desember</td>
                                <td width='7%' align='right'>".number_format($angkas4->des,'2',',','.')."</td> 
                                <td width='8%'>Desember</td>
                                <td width='7%' align='right'>".number_format($angkas5->des,'2',',','.')."</td>                                 
                            </tr>
                            <tr>
                                <td width='8%'>Jumlah</td>
                                <td width='7%' align='right'>".number_format($angkas4->des+$angkas4->nov+$angkas4->jan+$angkas4->feb+$angkas4->mar+$angkas4->apr+$angkas4->mei+$angkas4->jun+$angkas4->jul+$angkas4->ags+$angkas4->sept+$angkas4->okt,'2',',','.')."</td> 
                                <td width='8%'>Jumlah</td>
                                <td width='7%' align='right'>".number_format($angkas5->des+$angkas5->nov+$angkas5->jan+$angkas5->feb+$angkas5->mar+$angkas5->apr+$angkas5->mei+$angkas5->jun+$angkas5->jul+$angkas5->ags+$angkas5->sept+$angkas5->okt,'2',',','.')."</td>                                 
                            </tr>

                        </table>";
              
        
       
        $data['prev']= $cRet;    
        $judul         = 'RKA SKPD';
        switch($cetak) { 
        case 1;
             $this->master_pdf->_mpdf('',$cRet,10,10,10,'1');
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





    function preview_pendapatan_pergeseran($tgl_ttd,$ttd1,$ttd2,$id,$cetak,$doc,$status_anggaran1, $status_anggaran2){
        
        $tanggal_ttd = $this->support->tanggal_format_indonesia($tgl_ttd);
        $sqldns="SELECT a.kd_urusan as kd_u,b.nm_urusan as nm_u,a.kd_skpd as kd_sk,a.nm_skpd as nm_sk FROM ms_skpd a INNER JOIN ms_urusan b ON a.kd_urusan=b.kd_urusan WHERE kd_skpd='$id'";
                 $sqlskpd=$this->db->query($sqldns);
                 foreach ($sqlskpd->result() as $rowdns)
                {
                    $kd_urusan=$rowdns->kd_u;                    
                    $nm_urusan= $rowdns->nm_u;
                    $kd_skpd  = $rowdns->kd_sk;
                    $nm_skpd  = $rowdns->nm_sk;
                }
        $sqldns="SELECT a.kd_urusan as kd_u,'' as header, LEFT(a.kd_skpd,22) as kd_org,b.nm_urusan as nm_u, a.kd_skpd as kd_sk,a.nm_skpd as nm_sk  FROM ms_skpd a INNER JOIN ms_urusan b ON a.kd_urusan=b.kd_urusan WHERE kd_skpd='$id'";
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
                if($status_anggaran1=='nilai'){
                    $status_anggaran1="";
                    $status_volume1="1";
                    $status_satuan1="1";         
                    $status_harga1="1";
                }else if($status_anggaran1=='nilai_sempurna'){
                    $status_anggaran1="_sempurna";
                    $status_harga1="_sempurna1";
                    $status_satuan1="_sempurna1";
                    $status_volume1="_sempurna1";
                }else{
                    $status_anggaran1="_ubah";
                    $status_harga1="_ubah1";
                    $status_satuan1="_ubah1";
                    $status_volume1="_ubah1";
                }

                if($status_anggaran2=='nilai'){
                    $dokumen="DOKUMEN PELAKSANAAN ANGGARAN";
                    $status_anggaran2="";
                    $doc="DPA";
                    $status_volume2="1";
                    $status_satuan2="1";         
                    $status_harga2="1";
                }else if($status_anggaran2=='nilai_sempurna'){
                    $dokumen="DOKUMEN PELAKSANAAN ANGGARAN";
                    $doc="DPA";
                    $status_anggaran2="_sempurna";
                    $status_harga2="_sempurna1";
                    $status_satuan2="_sempurna1";
                    $status_volume2="_sempurna1";
                }else{
                    $dokumen="DOKUMEN PELAKSANAAN PERUBAHAN ANGGARAN";
                    $doc="DPPA";
                    $status_anggaran2="_ubah";
                    $status_harga2="_ubah1";
                    $status_satuan2="_ubah1";
                    $status_volume2="_ubah1";
                }    

        
        if($doc=='RKA'){
            $dokumen="RENCANA KERJA DAN ANGGARAN";
            $tabeldpa="";
        }else{
            $nodpa=$this->db->query("SELECT * from trhrka where kd_skpd='$id'")->row()->no_dpa;
            $tabeldpa="<tr>
                        <td width='20%' style='border-right:none'>No $doc </td>
                        <td width='80%' style='border-left:none'>: $nodpa</td>
                    </tr>";
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
                    $tabeldpa
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
        $cRet .= "<table style='border-collapse:collapse;font-size:12px' width='100%' align='center' border='1' cellspacing='2' cellpadding='4'>
                     <thead>                       
                        <tr><td rowspan='3' bgcolor='#CCCCCC' width='10%' align='center'><b>Kode Rekening</b></td>                            
                            <td rowspan='3' bgcolor='#CCCCCC' width='15%' align='center'><b>Uraian</b></td>
                            <td colspan='4' bgcolor='#CCCCCC' width='28%' align='center'><b>Sebelum Pergeseran</b></td>
                            <td colspan='4' bgcolor='#CCCCCC' width='28%' align='center'><b>Setelah Pergeseran</b></td>
                            <td colspan='2' bgcolor='#CCCCCC' width='20%' align='center'><b>Bertambah/(Berkurang)</b></td>
                        </tr>
                        <tr>
                            <td align='center' width='21%' bgcolor='#CCCCCC' colspan='3'><b>Rincian Perhitungan</td>
                            <td align='center' width='12%' bgcolor='#CCCCCC' rowspan='2'><b>Jumlah</td>
                            <td align='center' width='21%' bgcolor='#CCCCCC' colspan='3'><b>Rincian Perhitungan</td>
                            <td align='center' width='11%' bgcolor='#CCCCCC' rowspan='2'><b>Jumlah</td>
                            <td align='center' width='10%' bgcolor='#CCCCCC' rowspan='2'><b>Rp.</td>
                            <td align='center' width='5%' bgcolor='#CCCCCC' rowspan='2'><b>%</td>
                        </tr>
                        <tr>
                            <td bgcolor='#CCCCCC' align='center'>Volume</td>
                            <td bgcolor='#CCCCCC' align='center'>Satuan</td>
                            <td bgcolor='#CCCCCC' align='center'>Tarif/harga</td>

                            <td bgcolor='#CCCCCC' align='center'>Tarif/harga</td>
                            <td bgcolor='#CCCCCC' align='center'>Volume</td>
                            <td bgcolor='#CCCCCC' align='center'>Satuan</td>
                        </tr>    
                     </thead>
                        ";



                  $sql1="SELECT * FROM(
                        SELECT '' header, LEFT(a.kd_rek6,1)AS rek1,LEFT(a.kd_rek6,1)AS rek,b.nm_rek1 AS nama ,0 AS volume,' 'AS satuan, 0 AS harga,0 AS volume2,' 'AS satuan2, 0 AS harga2,SUM(a.nilai$status_anggaran1) AS nilai, SUM(a.nilai$status_anggaran2) AS nilai2,'1' AS id FROM trdrka a 
                        INNER JOIN ms_rek1 b ON LEFT(a.kd_rek6,1)=b.kd_rek1 WHERE LEFT(a.kd_rek6,1)='4' AND left(a.kd_skpd,17)=left('$id',17) GROUP BY LEFT(a.kd_rek6,1),nm_rek1 
                        UNION ALL 
                        SELECT '' header, LEFT(a.kd_rek6,2) AS rek1,LEFT(a.kd_rek6,2) AS rek,b.nm_rek2 AS nama, 0 AS volume,' 'AS satuan, 0 AS harga,0 AS volume,' 'AS satuan, 0 AS harga,SUM(a.nilai$status_anggaran1) AS nilai, SUM(a.nilai$status_anggaran2) AS nilai2,'2' AS id 
                        FROM trdrka a INNER JOIN ms_rek2 b ON LEFT(a.kd_rek6,2)=b.kd_rek2 WHERE LEFT(a.kd_rek6,1)='4' AND left(a.kd_skpd,17)=left('$id',17) GROUP BY LEFT(a.kd_rek6,2),nm_rek2 
                        UNION ALL 
                        SELECT '' header, LEFT(a.kd_rek6,4) AS rek1,LEFT(a.kd_rek6,4) AS rek,b.nm_rek3 AS nama,0 AS volume,' 'AS satuan, 0 AS harga,0 AS volume,' 'AS satuan, 0 AS harga,SUM(a.nilai$status_anggaran1) AS nilai, SUM(a.nilai$status_anggaran2) AS nilai2,'3' AS id 
                        FROM trdrka a INNER JOIN ms_rek3 b ON LEFT(a.kd_rek6,4)=b.kd_rek3 WHERE LEFT(a.kd_rek6,1)='4' AND left(a.kd_skpd,17)=left('$id',17) GROUP BY LEFT(a.kd_rek6,4),nm_rek3 
                        UNION ALL 
                        SELECT '' header, LEFT(a.kd_rek6,6) AS rek1,LEFT(a.kd_rek6,6) AS rek,b.nm_rek4 AS nama,0 AS volume,' 'AS satuan, 0 AS harga,0 AS volume,' 'AS satuan, 0 AS harga,SUM(a.nilai$status_anggaran1) AS nilai, SUM(a.nilai$status_anggaran2) AS nilai2,'4' AS id 
                        FROM trdrka a INNER JOIN ms_rek4 b ON LEFT(a.kd_rek6,6)=b.kd_rek4 WHERE LEFT(a.kd_rek6,1)='4' AND left(a.kd_skpd,17)=left('$id',17) GROUP BY LEFT(a.kd_rek6,6),nm_rek4 
                        UNION ALL 
                        SELECT '' header, LEFT(a.kd_rek6,8) AS rek1,LEFT(a.kd_rek6,8) AS rek,b.nm_rek5 AS nama,0 AS volume,' 'AS satuan, 0 AS harga,0 AS volume,' 'AS satuan, 0 AS harga,SUM(a.nilai$status_anggaran1) AS nilai, SUM(a.nilai$status_anggaran2) AS nilai2,'5' AS id 
                        FROM trdrka a INNER JOIN ms_rek5 b ON LEFT(a.kd_rek6,8)=b.kd_rek5 WHERE LEFT(a.kd_rek6,1)='4' AND left(a.kd_skpd,17)=left('$id',17) GROUP BY LEFT(a.kd_rek6,8),b.nm_rek5 
                        UNION ALL 
                        SELECT '' header, a.kd_rek6 AS rek1,a.kd_rek6 AS rek,b.nm_rek6 AS nama,0 AS volume,' 'AS satuan, 0 AS harga,0 AS volume,' 'AS satuan, 0 AS harga,SUM(a.nilai$status_anggaran1) AS nilai, SUM(a.nilai$status_anggaran2) AS nilai2,'6' AS id 
                        FROM trdrka a INNER JOIN ms_rek6 b ON a.kd_rek6=b.kd_rek6 WHERE LEFT(a.kd_rek6,1)='4' AND left(a.kd_skpd,17)=left('$id',17) GROUP BY a.kd_rek6,b.nm_rek6 
                        UNION ALL 
                        SELECT cast(header as varchar) header, kd_rek6 AS rek1,' 'AS rek,a.uraian AS nama,a.volume$status_volume1 AS volume,a.satuan$status_satuan1 AS satuan, a.harga$status_harga1 AS harga, a.volume$status_volume2 AS volume2,a.satuan$status_satuan2 AS satuan2, a.harga$status_harga2 AS harga2, a.total$status_anggaran1 AS nilai, a.total$status_anggaran2 AS nilai, '7' AS id 
                        FROM trdpo a WHERE left(no_trdrka,17)=left('$id',17)
                        AND left(kd_rek6,1)='4'
                        ) a ORDER BY a.rek1,a.id";
                 
                $query = $this->db->query($sql1);
                  if ($query->num_rows() > 0){                                                                                   
                        foreach ($query->result() as $row)
                        {
                            $rek=$row->rek;
                            $rek1=$row->rek1;
                            $reke=$this->support->dotrek($rek);
                            $uraian=$row->nama;
                            $volum=$row->volume;
                            $volum2=$row->volume2;
                            $header=$row->header;
                            $sat=$row->satuan;
                            $sat2=$row->satuan2;

                            $hrg= empty($row->harga) || $row->harga == 0 ? '' :number_format($row->harga,2,',','.');
                            $hrg2= empty($row->harga) || $row->harga2 == 0 ? '' :number_format($row->harga2,2,',','.');
                            $nila= number_format($row->nilai,"2",",",".");
                            $nila2= number_format($row->nilai2,"2",",",".");
                            $selisih= $this->support->rp_minus($row->nilai2-$row->nilai);
                            if($row->nilai==0){
                                $persen=number_format(0,"2",",",".");
                            }else{
                                $persen=$this->support->rp_minus((($row->nilai2-$row->nilai)/$row->nilai)*100);
                            }
                            
                           
                                
                            if($reke!=' '){
                                $volum = '';
                            }
                            
                            if((strlen($rek1)< 14 || $header== '1') && $header!= '0'){
                                if($header== '1'){
                                 $cRet    .= " <tr>
                                                 <td style='vertical-align:top;' align='left'>$reke</td>                                     
                                                 <td colspan='12' style='vertical-align:top;'>:: $uraian</td>
                                                </tr>
                                             ";
                                }else{
                                 $cRet    .= " <tr>
                                                 <td style='vertical-align:top;'  align='left'>$reke</td>                                     
                                                 <td colspan='4' style='vertical-align:top;' >$uraian</td>
                                                 <td style='vertical-align:top;'  align='right'>$nila</td>
                                                 <td colspan='3' style='vertical-align:top;' ></td>
                                                 <td style='vertical-align:top;'  align='right'>$nila2</td>
                                                 <td style='vertical-align:top;'  align='right'>$selisih</td>
                                                 <td style='vertical-align:top;'  align='right'>$persen</td>
                                               </tr>
                                             ";                                    
                                }
                            }else{
                                 $cRet    .= " <tr><td style='vertical-align:top;'  align='left'>$reke</td>                                     
                                                 <td style='vertical-align:top;' >$uraian</td>
                                                 <td style='vertical-align:top;'>$volum</td>
                                                 <td style='vertical-align:top;'>$sat</td>
                                                 <td style='vertical-align:top;' align='right'>$hrg</td>
                                                 <td style='vertical-align:top;' align='right'>$nila</td>
                                                 <td style='vertical-align:top;'>$volum2</td>
                                                 <td style='vertical-align:top;'>$sat2</td>
                                                 <td style='vertical-align:top;' align='right'>$hrg2</td>
                                                 <td style='vertical-align:top;' align='right'>$nila2</td>
                                                 <td style='vertical-align:top;' align='right'>$selisih</td>
                                                 <td style='vertical-align:top;' align='right'>$persen</td>
                                                </tr>
                                             ";                                
                            }
                        

                  
                        } /*endforeach*/
                }else{
                     $cRet    .= " <tr><td style='vertical-align:top;' width='20%' align='left'>4</td>                                     
                                     <td style='vertical-align:top;' >PENDAPATAN</td>
                                     <td style='vertical-align:top;' ></td>
                                     <td style='vertical-align:top;' ></td>
                                     <td style='vertical-align:top;' align='right'></td>
                                     <td style='vertical-align:top;' align='right'>".number_format(0,"2",",",".")."</td>
                                     <td style='vertical-align:top;' align='right'>".number_format(0,"2",",",".")."</td>
                                     <td style='vertical-align:top;' align='right'>".number_format(0,"2",",",".")."</td>
                                     <td style='vertical-align:top;' align='right'>".number_format(0,"2",",",".")."</td>
                                     <td style='vertical-align:top;' align='right'>".number_format(0,"2",",",".")."</td>
                                     <td style='vertical-align:top;' align='right'>".number_format(0,"2",",",".")."</td>
                                     <td style='vertical-align:top;' align='right'>".number_format(0,"2",",",".")."</td>
                                    </tr>
                                     ";
                    
                } /*endif*/


                   $cRet .= "<tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td align='right'>&nbsp;</td>
                                <td align='right'>&nbsp;</td>
                                <td align='right'>&nbsp;</td>
                                <td align='right'>&nbsp;</td>
                                <td align='right'>&nbsp;</td>
                                <td align='right'>&nbsp;</td>
                                <td align='right'>&nbsp;</td>
                             </tr>";
                 $sqltp="SELECT SUM(nilai$status_anggaran1) AS totp, SUM(nilai$status_anggaran2) AS totp2  FROM trdrka WHERE LEFT(kd_rek6,1)='4' AND left(kd_skpd,22)=left('$id',22)";
                    $sqlp=$this->db->query($sqltp);
                 foreach ($sqlp->result() as $rowp)
                {
                   $totp=number_format($rowp->totp,"2",",",".");
                   $totp2=number_format($rowp->totp2,"2",",",".");
                   $selisih=$this->support->rp_minus($rowp->totp2-$rowp->totp);
				   if($rowp->totp==0){
					  $persen=0;  
				   }else{
					  $persen=$this->support->rp_minus((($rowp->totp2-$rowp->totp)/$rowp->totp)*100);  
				   }
                  
                   
                    $cRet    .=" <tr><td style='vertical-align:top;border-top: solid 1px black;'  align='left'>&nbsp;</td>                                     
                                     <td style='vertical-align:top;border-top: solid 1px black;' colspan='4' >Jumlah Pendapatan</td>
                                     <td style='vertical-align:top;border-top: solid 1px black;' align='right'>$totp</td>
                                     <td style='vertical-align:top;border-top: solid 1px black;' align='right' colspan='3'></td>
                                     <td style='vertical-align:top;border-top: solid 1px black;' align='right'>$totp2</td>
                                     <td style='vertical-align:top;border-top: solid 1px black;' align='right'>$selisih</td>
                                     <td style='vertical-align:top;border-top: solid 1px black;' align='right'>$persen</td>
                                </tr>";
                 }
            
        $cRet    .= "</table>";

       
        if($doc=='RKA'){
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
                      }
                    }else{
                        $cRet .="<tr>
                         <td width='5%' align='left'> &nbsp; </td>
                         <td width='20%'  align='left'></td>
                         <td width='20%'  align='left'></td>
                         <td width='35%'  align='left'></td>
                         <td width='20%'  align='left'></td>
                        </tr>"; 
                    }

        $cRet .=       " </table>";           
        }/*end tanpa tanda tangan*/
                         
        



        } else{ /*tipe dokumen*/
if($ttd1!='tanpa'){
            $sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab, pangkat as pangkat FROM ms_ttd WHERE kode in ('PA','KPA') AND id='$ttd1' ";
            $sqlttd=$this->db->query($sqlttd1);
            foreach ($sqlttd->result() as $rowttd){
                        $nip=$rowttd->nip;  
                        $pangkat=$rowttd->pangkat;  
                        $nama= $rowttd->nm;
                        $jabatan  = $rowttd->jab;
            }
                    
            $tambahan="<td rowspan='14' align='center' width='40%'>                                <br>$daerah, $tanggal_ttd <br>
                                $jabatan 
                                <br><br>
                                <br><br>
                                <br><br>
                                <b>$nama</b><br>
                                <u>$nip</u></td>";
              
        }else{
            $tambahan="";
        }
                $angkas5=$this->db->query("SELECT  kd_skpd, 
                                                isnull(sum(case WHEN bulan=1 then nilai else 0 end ),0) as jan,
                                                isnull(sum(case WHEN bulan=2 then nilai else 0 end ),0) as feb,
                                                isnull(sum(case WHEN bulan=3 then nilai else 0 end ),0) as mar,
                                                isnull(sum(case WHEN bulan=4 then nilai else 0 end ),0) as apr,
                                                isnull(sum(case WHEN bulan=5 then nilai else 0 end ),0) as mei,
                                                isnull(sum(case WHEN bulan=6 then nilai else 0 end ),0) as jun,
                                                isnull(sum(case WHEN bulan=7 then nilai else 0 end ),0) as jul,
                                                isnull(sum(case WHEN bulan=8 then nilai else 0 end ),0) as ags,
                                                isnull(sum(case WHEN bulan=9 then nilai else 0 end ),0) as sept,
                                                isnull(sum(case WHEN bulan=10 then nilai else 0 end ),0) as okt,
                                                isnull(sum(case WHEN bulan=11 then nilai else 0 end ),0) as nov,
                                                isnull(sum(case WHEN bulan=12 then nilai else 0 end ),0) as des from (
                                                select bulan, left(kd_skpd,17)+'.0000' kd_skpd , sum(nilai$status_anggaran2) nilai from trdskpd_ro WHERE left(kd_rek6,1)='5' GROUP BY bulan, left(kd_skpd,17)
                                                ) okey where kd_skpd='$id' GROUP BY kd_skpd ")->row();
                $angkas4=$this->db->query(" 
                                                SELECT isnull(kd_skpd,'$id') kd_skpd, 
                                                isnull(sum(case WHEN bulan=1 then nilai else 0 end ),0) as jan,
                                                isnull(sum(case WHEN bulan=2 then nilai else 0 end ),0) as feb,
                                                isnull(sum(case WHEN bulan=3 then nilai else 0 end ),0) as mar,
                                                isnull(sum(case WHEN bulan=4 then nilai else 0 end ),0) as apr,
                                                isnull(sum(case WHEN bulan=5 then nilai else 0 end ),0) as mei,
                                                isnull(sum(case WHEN bulan=6 then nilai else 0 end ),0) as jun,
                                                isnull(sum(case WHEN bulan=7 then nilai else 0 end ),0) as jul,
                                                isnull(sum(case WHEN bulan=8 then nilai else 0 end ),0) as ags,
                                                isnull(sum(case WHEN bulan=9 then nilai else 0 end ),0) as sept,
                                                isnull(sum(case WHEN bulan=10 then nilai else 0 end ),0) as okt,
                                                isnull(sum(case WHEN bulan=11 then nilai else 0 end ),0) as nov,
                                                isnull(sum(case WHEN bulan=12 then nilai else 0 end ),0) as des from (
                                                select bulan, left(kd_skpd,17)+'.0000' kd_skpd , sum(nilai$status_anggaran2) nilai from trdskpd_ro WHERE left(kd_rek6,1)='4' GROUP BY bulan, left(kd_skpd,17)
                                                ) okey where kd_skpd='$id' GROUP BY kd_skpd
                                                union all 
                                                select '$id' kd_skpd, 0,0,0,0,0,0,0,0,0,0,0,0
                                                 ")->row();
                $cRet .="<table border='1' width='100%' cellpadding='5' cellspacing='5' style='border-collapse: collapse; font-size:10px'>
                            <tr>
                                <td colspan='2' align='center' width='60%'>Rencana Realisasi Penerimaan Per Bulan</td>
                                $tambahan
                            </tr>
                            <tr>
                                <td width='30%'>Januari</td>
                                <td width='30%' align='right'>".number_format($angkas4->jan,'2',',','.')."</td>                                
                            </tr>
                            <tr>
                                <td width='30%'>Februari</td>
                                <td width='30%' align='right'>".number_format($angkas4->feb,'2',',','.')."</td>                                 
                            </tr>
                            <tr>
                                <td width='30%'>Maret</td>
                                <td width='30%' align='right'>".number_format($angkas4->mar,'2',',','.')."</td>                              
                            </tr>
                            <tr>
                                <td width='30%'>April</td>
                                <td width='30%' align='right'>".number_format($angkas4->apr,'2',',','.')."</td>                                
                            </tr>
                            <tr>
                                <td width='30%'>Mei</td>
                                <td width='30%' align='right'>".number_format($angkas4->mei,'2',',','.')."</td>                            
                            </tr>
                            <tr>
                                <td width='30%'>Juni</td>
                                <td width='30%' align='right'>".number_format($angkas4->jun,'2',',','.')."</td>                                 
                            </tr>
                            <tr>
                                <td width='30%'>Juli</td>
                                <td width='30%' align='right'>".number_format($angkas4->jul,'2',',','.')."</td>                                 
                            </tr>
                            <tr>
                                <td width='30%'>Agustus</td>
                                <td width='30%' align='right'>".number_format($angkas4->ags,'2',',','.')."</td>                                 
                            </tr>
                            <tr>
                                <td width='30%'>September</td>
                                <td width='30%' align='right'>".number_format($angkas4->sept,'2',',','.')."</td>                                  
                            </tr>
                            <tr>
                                <td width='30%'>Oktober</td>
                                <td width='30%' align='right'>".number_format($angkas4->okt,'2',',','.')."</td>                                  
                            </tr>
                            <tr>
                                <td width='30%'>November</td>
                                <td width='30%' align='right'>".number_format($angkas4->nov,'2',',','.')."</td>                                 
                            </tr>
                            <tr>
                                <td width='30%'>Desember</td>
                                <td width='30%' align='right'>".number_format($angkas4->des,'2',',','.')."</td>                                 
                            </tr>
                            <tr>
                                <td width='30%' align='right'>Jumlah</td>
                                <td width='30%' align='right'>".number_format($angkas4->des+$angkas4->nov+$angkas4->jan+$angkas4->feb+$angkas4->mar+$angkas4->apr+$angkas4->mei+$angkas4->jun+$angkas4->jul+$angkas4->ags+$angkas4->sept+$angkas4->okt,'2',',','.')."</td>                               
                            </tr>

                        </table>";
        } /*end else tipe dokumen*/




        $data['prev']= $cRet;
        switch($cetak) { 
        case 1;
             $this->master_pdf->_mpdf('',$cRet,10,10,10,'1');
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


    function preview_belanja_pergeseran($tgl_ttd,$ttd1,$ttd2,$id,$cetak,$doc,$status1,$status2){
        
        $tanggal_ttd = $this->support->tanggal_format_indonesia($tgl_ttd);
        $sqldns="SELECT a.kd_urusan as kd_u,'' as header, LEFT(a.kd_skpd,20) as kd_org,b.nm_urusan as nm_u, a.kd_skpd as kd_sk,a.nm_skpd as nm_sk  FROM ms_skpd a INNER JOIN ms_urusan b ON a.kd_urusan=b.kd_urusan WHERE kd_skpd='$id'";
                 $sqlskpd=$this->db->query($sqldns);
                 foreach ($sqlskpd->result() as $rowdns)
                {
                    $kd_urusan= $rowdns->kd_u;                    
                    $nm_urusan= $rowdns->nm_u;
                    $kd_skpd  = $rowdns->kd_sk;
                    $nm_skpd  = $rowdns->nm_sk;
                    $header   = $rowdns->header;
                    $kd_org   = $rowdns->kd_org;
                }
        $sqlsc="SELECT tgl_rka,provinsi,kab_kota,daerah,thn_ang FROM sclient where kd_skpd='$id'";
                 $sqlsclient=$this->db->query($sqlsc);
                 foreach ($sqlsclient->result() as $rowsc)
                {
                   
                    $tgl     = $rowsc->tgl_rka;
                    $kab     = $rowsc->kab_kota;
                    $daerah  = $rowsc->daerah;
                    $thn     = $rowsc->thn_ang;
                }

            $dokumen="DOKUMEN PELAKSANAAN ANGGARAN";
            $nama_tabel="Pergeseran";

            if($status1=='nilai'){
                $status_anggaran1="";
                $status_angkas1="";
            }else if($status1=='nilai_sempurna'){
                $status_anggaran1="2";
                $status_angkas1="_sempurna";
            }else {
                $status_anggaran1="3";
                $status_angkas1="_ubah";
            }

            if($status2=='nilai'){
                $status_anggaran2="";
                $status_angkas2="";
            }else if($status2=='nilai_sempurna'){
                $status_anggaran2="2";
                $status_angkas2="_sempurna";
            }else {
                $status_anggaran2="3";
                $status_angkas2="_ubah";
                $nama_tabel="Perubahan";
                $dokumen="DOKUMEN PELAKSANAAN PERUBAHAN ANGGARAN";
            }

        if($doc=='RKA'){
            $dokumen="RENCANA KERJA DAN ANGGARAN";
            $tabeldpa="";
        }else{
            
            $nodpa=$this->db->query("SELECT * from trhrka where kd_skpd='$id'")->row()->no_dpa;
            $tabeldpa="<tr>
                        <td width='20%' align='left' style='border-right:none'> No $doc</td>
                        <td width='80%' align='left' style='border-left:none'>: $nodpa</td>
                    </tr>";
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

        $ctk .="<table style='border-collapse:collapse;font-size:12px' width='100%' align='center' border='1' cellspacing='2' cellpadding='2'>
                $tabeldpa
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
                    <td align='center' colspan='7'><b>Sebelum $nama_tabel</td>
                    <td align='center' colspan='7'><b>Setelah $nama_tabel</td>                 
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
                    <td align='center'><b>16</td>
                    <td align='center'><b>17</td>
                    <td align='center'><b>18</td>
                    <td align='center'><b>19</td>
                    <td align='center'><b>20</td>
                    <td align='center'><b>21</td>
                    <td align='center'><b>22</td>
                </tr>
                </thead>
                <tr>
                    <td colspan='22' bgcolor='#cccccc'>&nbsp;</td>
                </tr>";
            $tot51=0;               $tot51_2=0;
            $tot52=0;               $tot52_2=0;
            $tot53=0;               $tot53_2=0;
            $tot54=0;               $tot54_2=0;
            $total=0;               $total_2=0;



        $sumber="";
        $sql=$this->db->query("SELECT urusan, bid_urusan, program, kegiatan, subgiat, nama, sumber, lokasi, sum(operasi$status_anggaran1) operasi, sum(modal$status_anggaran1) modal, sum(duga$status_anggaran1) duga, sum(trans$status_anggaran1) trans, sum(operasi$status_anggaran2) operasi2, sum(modal$status_anggaran2) modal2, sum(duga$status_anggaran2) duga2, sum(trans$status_anggaran2) trans2 from v_cetak_belanja where left(kd_skpd,17)=left('$id',17)
GROUP BY left(kd_skpd,17),urusan, bid_urusan, program, kegiatan, subgiat, nama, sumber, lokasi, urut
 ORDER BY urut
           ");
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
            $operasi2 =$a->operasi2;
            $modal2 =$a->modal2;
            $terduga2 =$a->duga2;
            $transfer2 =$a->trans2;
            $Jumlah=$operasi+$modal+$terduga+$transfer;
            $Jumlah2=$operasi2+$modal2+$terduga2+$transfer2;
            if($subgiat!=''){
                $tot51=0+$tot51+$operasi;
                $tot52=0+$tot52+$modal;
                $tot53=0+$tot53+$terduga;
                $tot54=0+$tot54+$transfer;
                $total=0+$total+$Jumlah;  

                $tot51_2=0+$tot51_2+$operasi2;
                $tot52_2=0+$tot52_2+$modal2;
                $tot53_2=0+$tot53_2+$terduga2;
                $tot54_2=0+$tot54_2+$transfer2;
                $total_2=0+$total_2+$Jumlah2;                
            }


        $ctk .="<tr>
                    <td align='center'>$urusan</td>
                    <td align='center'>$bid_urusan</td>
                    <td align='center'>$program</td>
                    <td align='center'>$giat</td>
                    <td align='center'>$subgiat</td>
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
                    <td align='left'></td>
                    <td align='right'>&nbsp;".number_format($operasi2,2,',','.')."</td>
                    <td align='right'>&nbsp;".number_format($modal2,2,',','.')."</td>
                    <td align='right'>&nbsp;".number_format($terduga2,2,',','.')."</td>
                    <td align='right'>&nbsp;".number_format($transfer2,2,',','.')."</td>
                    <td align='right'>&nbsp;".number_format($Jumlah2,2,',','.')."</td>
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
                    <td align='left'></td>
                    <td align='right'>".number_format($tot51_2,2,',','.')."</td>
                    <td align='right'>".number_format($tot52_2,2,',','.')."</td>
                    <td align='right'>".number_format($tot53_2,2,',','.')."</td>
                    <td align='right'>".number_format($tot54_2,2,',','.')."</td>
                    <td align='right'>".number_format($total_2,2,',','.')."</td>
                    <td align='left'></td>
                </tr>";
            $ctk .=  "</table>";
       
if($ttd1!='tanpa'){
            $sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab, pangkat as pangkat FROM ms_ttd WHERE  id='$ttd1' ";
            $sqlttd=$this->db->query($sqlttd1);
            foreach ($sqlttd->result() as $rowttd){
                        $nip=$rowttd->nip;  
                        $pangkat=$rowttd->pangkat;  
                        $nama= $rowttd->nm;
                        $jabatan  = $rowttd->jab;
            }
                    
            $tambahan="<td rowspan='14' align='center' width='40%'>                                <br>$daerah, $tanggal_ttd <br>
                                $jabatan 
                                <br><br>
                                <br><br>
                                <br><br>
                                <b>$nama</b><br>
                                <u>$nip</u></td>";
              
        }else{
            $tambahan="";
        }
                $angkas5=$this->db->query("SELECT  kd_skpd, 
                                                isnull(sum(case WHEN bulan=1 then nilai else 0 end ),0) as jan,
                                                isnull(sum(case WHEN bulan=2 then nilai else 0 end ),0) as feb,
                                                isnull(sum(case WHEN bulan=3 then nilai else 0 end ),0) as mar,
                                                isnull(sum(case WHEN bulan=4 then nilai else 0 end ),0) as apr,
                                                isnull(sum(case WHEN bulan=5 then nilai else 0 end ),0) as mei,
                                                isnull(sum(case WHEN bulan=6 then nilai else 0 end ),0) as jun,
                                                isnull(sum(case WHEN bulan=7 then nilai else 0 end ),0) as jul,
                                                isnull(sum(case WHEN bulan=8 then nilai else 0 end ),0) as ags,
                                                isnull(sum(case WHEN bulan=9 then nilai else 0 end ),0) as sept,
                                                isnull(sum(case WHEN bulan=10 then nilai else 0 end ),0) as okt,
                                                isnull(sum(case WHEN bulan=11 then nilai else 0 end ),0) as nov,
                                                isnull(sum(case WHEN bulan=12 then nilai else 0 end ),0) as des from (
                                                select bulan, left(kd_skpd,17)+'.0000' kd_skpd , sum(nilai$status_angkas2) nilai from trdskpd_ro WHERE left(kd_rek6,1)='5' GROUP BY bulan, left(kd_skpd,17)
                                                ) okey where kd_skpd='$id' GROUP BY kd_skpd ")->row();

                $ctk .="<table border='1' width='100%' cellpadding='5' cellspacing='5' style='border-collapse: collapse; font-size:12px'>
                            <tr>
                                <td colspan='2' align='center' width='60%'>Rencana Penarikan Dana per Bulan</td>
                                $tambahan
                            </tr>
                            <tr>
                                <td width='30%'>Januari</td>
                                <td width='30%' align='right'>".number_format($angkas5->jan,'2',',','.')."</td>                                
                            </tr>
                            <tr>
                                <td width='30%'>Februari</td>
                                <td width='30%' align='right'>".number_format($angkas5->feb,'2',',','.')."</td>                                 
                            </tr>
                            <tr>
                                <td width='30%'>Maret</td>
                                <td width='30%' align='right'>".number_format($angkas5->mar,'2',',','.')."</td>                              
                            </tr>
                            <tr>
                                <td width='30%'>April</td>
                                <td width='30%' align='right'>".number_format($angkas5->apr,'2',',','.')."</td>                                
                            </tr>
                            <tr>
                                <td width='30%'>Mei</td>
                                <td width='30%' align='right'>".number_format($angkas5->mei,'2',',','.')."</td>                            
                            </tr>
                            <tr>
                                <td width='30%'>Juni</td>
                                <td width='30%' align='right'>".number_format($angkas5->jun,'2',',','.')."</td>                                 
                            </tr>
                            <tr>
                                <td width='30%'>Juli</td>
                                <td width='30%' align='right'>".number_format($angkas5->jul,'2',',','.')."</td>                                 
                            </tr>
                            <tr>
                                <td width='30%'>Agustus</td>
                                <td width='30%' align='right'>".number_format($angkas5->ags,'2',',','.')."</td>                                 
                            </tr>
                            <tr>
                                <td width='30%'>September</td>
                                <td width='30%' align='right'>".number_format($angkas5->sept,'2',',','.')."</td>                                  
                            </tr>
                            <tr>
                                <td width='30%'>Oktober</td>
                                <td width='30%' align='right'>".number_format($angkas5->okt,'2',',','.')."</td>                                  
                            </tr>
                            <tr>
                                <td width='30%'>November</td>
                                <td width='30%' align='right'>".number_format($angkas5->nov,'2',',','.')."</td>                                 
                            </tr>
                            <tr>
                                <td width='30%'>Desember</td>
                                <td width='30%' align='right'>".number_format($angkas5->des,'2',',','.')."</td>                                 
                            </tr>
                            <tr>
                                <td width='30%' align='right'>Jumlah</td>
                                <td width='30%' align='right'>".number_format($angkas5->des+$angkas5->nov+$angkas5->jan+$angkas5->feb+$angkas5->mar+$angkas5->apr+$angkas5->mei+$angkas5->jun+$angkas5->jul+$angkas5->ags+$angkas5->sept+$angkas5->okt,'2',',','.')."</td>                               
                            </tr>

                        </table>";





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



}
