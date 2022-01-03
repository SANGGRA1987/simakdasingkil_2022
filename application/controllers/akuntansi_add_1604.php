<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Akuntansi_add extends CI_Controller {

	function __contruct()
	{	
		parent::__construct();
  
	}
    
    
    
    function cetak_lra_skpd()
    {
        $data['page_title']= 'LRA SKPD';
        $this->template->set('title', 'LRA SKPD');   
        $this->template->load('template','akuntansi/cetak_lra_skpd',$data) ; 
    }    
    
    function cetak_lra($cbulan="", $pilih=1){
	$id  = $this->uri->segment(8);	
    $ag_tox  = $this->uri->segment(9);
    $thn = $this->session->userdata('pcThang');
	
    /*$sqlanggaran1="select case when statu=1 and status_sempurna=1 and status_ubah=1 and $cbulan>=month(tgl_dpa_ubah) then 2 
					   when statu=1 and status_sempurna=1 and status_ubah=1 and $cbulan>=month(tgl_dpa_sempurna) and $cbulan<month(tgl_dpa_ubah) then 1
					   when statu=1 and status_sempurna=1 and status_ubah=1 and $cbulan<month(tgl_dpa_sempurna) then 1
					   when statu=1 and status_sempurna=1 and status_ubah=0 and $cbulan>=month(tgl_dpa_sempurna) then 1 
					   when statu=1 and status_sempurna=1 and status_ubah=0 and $cbulan<month(tgl_dpa_sempurna) then 1
					   when statu=1 and status_sempurna=0 and status_ubah=0 and $cbulan>=month(tgl_dpa) then 1
					   else 1 end as anggaran from trhrka where kd_skpd='$id'";*/
                       
    $sqlanggaran1="select case when statu=1 and status_sempurna=1 and status_ubah=1 then 2 
					   when statu=1 and status_sempurna=1 and status_ubah=0 then 2
					   when statu=1 and status_sempurna=0 and status_ubah=0 then 1
					   else 1 end as anggaran from trhrka where kd_skpd='$id'";
                           
    $sqlanggaran=$this->db->query($sqlanggaran1);
	foreach ($sqlanggaran->result() as $rowttd)
        {
            $anggaran=$rowttd->anggaran;
        }

	//$ag_tox=$anggaran;
        $tgl =	$this->uri->segment(7);	 
        if($tgl=='-'){
            $ctgl_ttd='';
        }else{
            $ctgl_ttd = $this->tukd_model->tanggal_format_indonesia($tgl);
        }
        
        /*$ttd1 = str_replace('a',' ',$this->uri->segment(5));
        $ttd2 = str_replace('a',' ',$this->uri->segment(6));
        
        if($ttd1=='-'){
			$nip='';                    
			$namax= '';
			$jabatan  = '';
			$pangkat  = '';            
		}else{
		$sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab, pangkat FROM ms_ttd where nip='$ttd1' AND kode ='PA' and kd_skpd = '$id'";
		 $sqlttd=$this->db->query($sqlttd1);
		 foreach ($sqlttd->result() as $rowttd)
		{
			$nip=$rowttd->nip;                    
			$namax= $rowttd->nm;
			$jabatan  = $rowttd->jab;
			$pangkat  = $rowttd->pangkat;
		}
        
        }
		
		if($ttd2=='-'){
			$jdl2 = '';
			$nip2='';                    
			$nama2= '';
			$jabatan2  = '';
			$pangkat2  = '';
		}else{
			$sqlttd2="SELECT nama as nm2,nip as nip,jabatan as jab , pangkat FROM ms_ttd where nip='$ttd2' AND kode ='PPK' and kd_skpd = '$id'";
			$sqlttd2=$this->db->query($sqlttd2);
			foreach ($sqlttd2->result() as $rowttd2)
			{
				//$jdl2 = 'MENGETAHUI :';
				$nip2 = $rowttd2->nip;                    
				$nama2= $rowttd2->nm2;
				$jabatan2  = $rowttd2->jab;
				$pangkat2  = $rowttd2->pangkat;
			}
		}
        */
    //function cetak_lra(){
        $sql41="SELECT SUM(nilai_ang) as anggaran,SUM(real_spj) as nilai FROM data_realisasi_keg4( $cbulan,$ag_tox) WHERE left(kd_rek5,1)='4' and left(kd_skpd,7)=left('$id',7) ";
                    $query41 = $this->db->query($sql41);
                    $jmlp = $query41->row();
                    $jmlpendapatan = $jmlp->nilai;
                    $jmlangpendapatan = $jmlp->anggaran;
                    $jmlangpendapatan1= number_format($jmlp->anggaran,"2",",",".");
                    $jmlpendapatan1= number_format($jmlp->nilai,"2",",",".");
                    
					$real_pend = $jmlangpendapatan - $jmlpendapatan;
                    if ($real_pend < 0){
                    	$x001="("; $real_pendx=$real_pend*-1; $y001=")";}
                    else {
                    	$x001=""; $real_pendx=$real_pend; $y001="";}
                    $selisihpend = number_format($real_pendx,"2",",",".");
                    if ($jmlpendapatan==0){
                        $tmp001=1;
                    }else{
                        $tmp001=$jmlpendapatan;
                    }
					
                    $per001     = ($jmlangpendapatan!=0)?($jmlpendapatan / $jmlangpendapatan ) * 100:0; 
                    $persen001  = number_format($per001,"2",",",".");
					
        $sql51="SELECT SUM(nilai_ang) as angaran,SUM(real_spj)as nilai FROM data_realisasi_keg4( $cbulan,$ag_tox) WHERE left(kd_rek5,1)='5' and left(kd_skpd,7)=left('$id',7) ";
                    $query51 = $this->db->query($sql51);
                    $jmlb = $query51->row();
                    $jmlangbelanja = $jmlb->angaran;
                    $jmlbelanja = $jmlb->nilai;
                    $jmlbelanja1= number_format($jmlb->nilai,"2",",",".");
                    $jmlangbelanja1= number_format($jmlb->angaran,"2",",",".");
					
					$real_belanja = $jmlangbelanja - $jmlbelanja;
                    if ($real_belanja < 0){
                    	$x002="("; $real_belanjax=$real_belanja*-1; $y002=")";}
                    else {
                    	$x002=""; $real_belanjax=$real_belanja; $y002="";}
                    $selisihbelanja = number_format($real_belanjax,"2",",",".");
                    if ($jmlbelanja==0){
                        $tmp002=1;
                    }else{
                        $tmp002=$jmlbelanja;
                    }
					
                    $per002     = ($jmlangbelanja!=0)?($jmlbelanja / $jmlangbelanja ) * 100:0; 
                    $persen002  = number_format($per002,"2",",",".");
					
        $sql523="SELECT SUM(nilai_ang) as anggaran,SUM(real_spj) as nilai FROM data_realisasi_keg4( $cbulan,$ag_tox) WHERE left(kd_rek5,3)='523' and left(kd_skpd,7)=left('$id',7) ";
                    $query523 = $this->db->query($sql523);
                    $jmlbm = $query523->row();
                    $jmlbmbelanja = $jmlbm->nilai;
                    $jmlangbmbelanja = $jmlbm->anggaran;
                    $jmlbmbelanja1= number_format($jmlbmbelanja,"2",",",".");
                    $jmlangbmbelanja1= number_format($jmlangbmbelanja,"2",",",".");
        $sql61="SELECT SUM(nilai_ang) as anggaran,SUM(real_spj) as nilai FROM data_realisasi_keg4( $cbulan,$ag_tox) WHERE left(kd_rek5,2)='61' and left(kd_skpd,7)=left('$id',7) ";
                    $query61 = $this->db->query($sql61);
                    $jmlpm = $query61->row();
                    $jmlpmasuk = $jmlpm->nilai;
                    $jmlangpmasuk = $jmlpm->anggaran;
        $sql62="SELECT SUM(nilai_ang) as anggaran,SUM(real_spj) as nilai FROM data_realisasi_keg4( $cbulan,$ag_tox) WHERE left(kd_rek5,2)='62' and left(kd_skpd,7)=left('$id',7) ";
                    $query62 = $this->db->query($sql62);
                    $jmlpk = $query62->row();
                    $jmlpkeluar = $jmlpk->nilai;
                    $jmlangpkeluar = $jmlpk->anggaran;
        $surplus =  $jmlpendapatan- $jmlbelanja;
        $angsurplus = $jmlangpendapatan- $jmlangbelanja;        
        if ($surplus < 0){
                    	$x="("; $surplusx=$surplus*-1; $y=")";
                        }else {
                    	$x=""; $surplusx=$surplus; $y="";
                        }
        if ($angsurplus < 0){
                    	$e="("; $angsurplusx=$angsurplus*-1; $f=")";
                        }else {
                    	$e=""; $angsurplusx=$angsurplus; $f="";
                        }
        $surplus1= number_format($surplusx,"2",",",".");
        $angsurplus1= number_format($angsurplusx,"2",",",".");
		
		$real_surplus = $angsurplus - $surplus;
                    if ($real_surplus < 0){
                    	$x003="("; $real_surplusx=$real_surplus*-1; $y003=")";}
                    else {
                    	$x003=""; $real_surplusx=$real_surplus; $y003="";}
        $selisihsurplus = number_format($real_surplusx,"2",",",".");
                    if ($surplus==0){
                        $tmp003=1;
                    }else{
                        $tmp003=$surplus;
                    }
					
                    $per003     = ($angsurplus!=0)?($surplus / $angsurplus ) * 100:0; 
                    $persen003  = number_format($per003,"2",",",".");
		
        $biaya_net =  $jmlpmasuk- $jmlpkeluar;
        $angbiaya_net =  $jmlangpmasuk- $jmlangpkeluar;        
        if ($biaya_net < 0){
                    	$a="("; $biaya_netx=$biaya_net*-1; $b=")";
                        }else {
                    	$a=""; $biaya_netx=$biaya_net; $b="";
                        }
        if ($angbiaya_net < 0){
                    	$g="("; $angbiaya_netx=$angbiaya_net*-1; $h=")";
                        }else {
                    	$g=""; $angbiaya_netx=$angbiaya_net; $h="";
                        }
        $biaya_net1 =   number_format($biaya_netx,"2",",",".");
        $angbiaya_net1 =   number_format($angbiaya_netx,"2",",",".");
        $silpa= ($jmlpendapatan+$jmlpmasuk)-($jmlbelanja+$jmlpkeluar);
        $angsilpa= ($jmlangpendapatan+$jmlangpmasuk)-($jmlangbelanja+$jmlangpkeluar);                
        if ($silpa < 0){
                    	$c="("; $silpax=$silpa*-1; $d=")";
                        }else {
                    	$c=""; $silpax=$silpa; $d="";
                        }
        if ($angsilpa < 0){
                    	$i="("; $angsilpax=$angsilpa*-1; $j=")";
                        }else {
                    	$i=""; $angsilpax=$angsilpa; $j="";
                        }
        $silpa1 =number_format($silpax,"2",",","."); 
        $angsilpa1 =number_format($angsilpax,"2",",",".");
       $sqlsc="SELECT nm_skpd FROM ms_skpd where kd_skpd='$id' ";
                 $sqlsclient=$this->db->query($sqlsc);
                 foreach ($sqlsclient->result() as $rowsc)
                {
                   
                    $nmskpd  = $rowsc->nm_skpd;
                } 
        
		$nm_skpd	= strtoupper ($nmskpd);
        $jk=$this->rka_model->combo_skpd();
       
        $cRet='';
        
	 $modtahun= $thn%4;
	 
	 if ($modtahun = 0){
        $nilaibulan=".31 JANUARI.29 FEBRUARI.31 MARET.30 APRIL.31 MEI.30 JUNI.31 JULI.31 AGUSTUS.30 SEPTEMBER.31 OKTOBER.30 NOVEMBER.31 DESEMBER";}
            else {
        $nilaibulan=".31 JANUARI.28 FEBRUARI.31 MARET.30 APRIL.31 MEI.30 JUNI.31 JULI.31 AGUSTUS.30 SEPTEMBER.31 OKTOBER.30 NOVEMBER.31 DESEMBER";}
	 
	 $arraybulan=explode(".",$nilaibulan);
       
        $cRet .="<table style=\"font-size:13px; border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
                    <tr>
                         <td align=\"center\"><strong>PEMERINTAH KABUPATEN SANGGAU</strong></td>                         
                    </tr>
					<tr>
                         <td align=\"center\"><strong>$nm_skpd</strong></td>                         
                    </tr>					
                    <tr>
                         <td align=\"center\"><strong>LAPORAN REALISASI ANGGARAN PENDAPATAN DAN BELANJA </strong></td>
                    </tr>                    
                    <tr>
                         <td align=\"center\"><strong>UNTUK TAHUN YANG BERAKHIR SAMPAI DENGAN $arraybulan[$cbulan] $thn</strong></td>
                    </tr>
                    <tr>
                         <td align=\"center\">&nbsp;</td>
                    </tr>
                  </table>";        
        
        
        $cRet .= "<table style=\"font-size:12px; border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"4\">
                     <thead>                       
                        <tr>
                            <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>                             
                            <td bgcolor=\"#CCCCCC\" width=\"4%\" align=\"center\"><b>NO</b></td>                            
                            <td  bgcolor=\"#CCCCCC\" width=\"37%\" align=\"center\"><b>URAIAN</b></td>
                            <td bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>ANGGARAN</b></td>
                            <td bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>REALISASI</b></td>
                            <td  bgcolor=\"#CCCCCC\" width=\"15%\" align=\"center\" ><b>LEBIH</br>(KURANG)</b></td>
                            <td  bgcolor=\"#CCCCCC\" width=\"6%\" align=\"center\" ><b>%</b></td>   
                        </tr>
                        
                     </thead>
                     <tfoot>
                        <tr>
                            <td style=\"border: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>                           
                         </tr>
                     </tfoot>
                   
                     <tr>   
                            <td width=\"8%\" align=\"center\" style=\"border:none;\"></td> 
                            <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"4%\" align=\"center\">&nbsp;</td>                            
                            <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"37%\">&nbsp;</td>
                            <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"20%\">&nbsp;</td>
                            <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"20%\">&nbsp;</td>
                            <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"15%\">&nbsp;</td>
                            <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"6%\">&nbsp;</td>
                        </tr>";
               
                   $sql4="SELECT a.seq,a.nor,a.uraian,isnull(a.kode_1,'-') as kode_1,isnull(a.kode_2,'-') as kode_2,isnull(a.kode_3,'-') as kode_3,thn_m1 AS lalu FROM map_lra_skpd a 
				   GROUP BY a.seq,a.nor,a.uraian,isnull(a.kode_1,'-'),isnull(a.kode_2,'-'),isnull(a.kode_3,'-'),thn_m1 ORDER BY a.seq";
                // isnull(a.kode_1,\"'-'\")
                $query4 = $this->db->query($sql4);
                $no     = 0;                                  
               
                foreach ($query4->result() as $row4)
                {
                    
                    $nama      = $row4->uraian;   
                    $real_lalu = number_format($row4->lalu,"2",",",".");
                    $n         = $row4->kode_1;
					$n		   = ($n=="-"?"'-'":$n);
					$n2         = $row4->kode_2;
					$n2		   = ($n2=="-"?"'-'":$n2);
					$n3         = $row4->kode_3;
					$n3		   = ($n3=="-"?"'-'":$n3);

//                    $sql5   = "SELECT SUM(b.anggaran) as anggaran,SUM(b.real_spj) as nilai FROM data_realisasi( $bulan,$ag_tox) b LEFT JOIN ms_rek5 c ON b.kd_rek5=c.kd_rek5 WHERE c.map_lra1 IN (".$n.") ";
                    $sql5   = "SELECT SUM(b.nilai_ang) as anggaran,SUM(b.real_spj) as nilai FROM data_realisasi_keg4( $cbulan,$ag_tox) b WHERE left(kd_skpd,7)=left('$id',7) and (left(b.kd_rek5,3) in ($n) or left(b.kd_rek5,5) in ($n2) or left(b.kd_rek5,7) in ($n3))";
//					                    $sql5   = "SELECT SUM(b.anggaran) as anggaran,SUM(b.real_spj) as nilai FROM realisasi b LEFT JOIN ms_rek5 c ON b.kd_rek5=c.kd_rek5 WHERE c.map_lra1 IN (\"'.$n.'\") ";
                    $query5 = $this->db->query($sql5);
                    $trh    = $query5->row();
                    $nil    = $trh->nilai;
                    $angnil = $trh->anggaran;
                    
                    $real_s = $trh->anggaran - $trh->nilai;
                    if ($real_s < 0){
                    	$x1="("; $real_sx=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $real_sx=$real_s; $y1="";}
                    $selisih = number_format($real_sx,"2",",",".");
                    if ($trh->nilai==0){
                        $tmp=1;
                    }else{
                        $tmp=$trh->nilai;
                    }
                    $nilai    = number_format($trh->nilai,"2",",",".");
                    $angnilai = number_format($trh->anggaran,"2",",",".");
                    $per1     = ($angnil!=0)?($nil / $angnil ) * 100:0; 
                    $persen1  = number_format($per1,"2",",",".");
                    $no       = $no + 1;
                    switch ($row4->seq) {
                    case 5:
                         $cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td> 
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"4%\" align=\"center\">$no</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\">$nama&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"6%\" align=\"right\"></td>
                                 </tr>";
                        break;
					case 10:
                         $cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td> 
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"4%\" align=\"center\">$no</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\">&nbsp;&nbsp;&nbsp;&nbsp;$nama</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"6%\" align=\"right\"></td>
                                 </tr>";
                        break;					
					case 35:
                         $cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td> 
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"4%\" align=\"center\">$no</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\">$nama</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"6%\" align=\"right\"></td>
                                 </tr>";
                        break;
                    case 40:
                        $cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>  
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"4%\" align=\"center\">$no</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$nama</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$jmlangpendapatan1</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$jmlpendapatan1</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\">$x001$selisihpend$y001</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"6%\" align=\"right\">$persen001</td>
                                 </tr>";
                        break;
					case 45:
                         $cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td> 
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"4%\" align=\"center\">$no</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\">$nama</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"6%\" align=\"right\"></td>
                                 </tr>";
                        break;
                    case 50:
                         $cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td> 
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"4%\" align=\"center\">$no</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\">$nama</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"6%\" align=\"right\"></td>
                                 </tr>";
                        break;
					case 55:
                         $cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td> 
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"4%\" align=\"center\">$no</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\">&nbsp;&nbsp;&nbsp;&nbsp;$nama</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"6%\" align=\"right\"></td>
                                 </tr>";
                        break;
					case 70:
                         $cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td> 
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"4%\" align=\"center\">$no</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$nama</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\">$x1$selisih$y1</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"6%\" align=\"right\">$persen1</td>
                                 </tr>";
                        break;						
					case 75:
                         $cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td> 
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"4%\" align=\"center\">$no</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\">$nama</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"6%\" align=\"right\"></td>
                                 </tr>";
                        break;
					case 80:
                         $cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>    
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"4%\" align=\"center\">$no</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\">&nbsp;&nbsp;&nbsp;&nbsp;$nama</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"6%\" align=\"right\"></td>
                                 </tr>";
                        break;
					case 110:
                         $cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td> 
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"4%\" align=\"center\">$no</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$nama</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\">$x1$selisih$y1</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"6%\" align=\"right\">$persen1</td>
                                 </tr>";
                        break;						
					case 115:
                         $cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td> 
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"4%\" align=\"center\">$no</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\">$nama</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"6%\" align=\"right\"></td>
                                 </tr>";
                        break;	
                    case 120:
                        $cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td> 
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"4%\" align=\"center\">$no</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$nama</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$jmlangbelanja1</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$jmlbelanja1</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\">$x002$selisihbelanja$y002</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"6%\" align=\"right\">$persen002</td>
                                 </tr>";
                        break;
					case 125:
                         $cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td> 
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"4%\" align=\"center\">$no</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\">$nama</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"6%\" align=\"right\"></td>
                                 </tr>";
                        break;	
                    case 130:
                        $cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td> 
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"4%\" align=\"center\">$no</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$nama</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$e$angsurplus1$f</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$x$surplus1$y</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\">$x003$selisihsurplus$y003</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"6%\" align=\"right\">$persen003</td>
                                 </tr>";
                        break;
                   
                    default:
                    $cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td> 
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"4%\" align=\"center\">$no</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$nama</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\">$x1$selisih$y1</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"6%\" align=\"right\">$persen1</td>
                                 </tr>";
                }
                }
         $cRet .=       " </table>";
        $data['prev']= $cRet;
		 $cRet         .= "</table>";
		 
		 /*if($stt_ttd==1){
		 $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> Mengetahui,</td>
		 <td align=\"center\" width=\"50%\"> Sanggau, $ctgl_ttd </td>
		 </tr>		
		 <tr>
		 <td align=\"center\" width=\"50%\"> $jabatan </td>
		 <td align=\"center\" width=\"50%\"> $jabatan2 </td>
		 </tr>	
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		  <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> $namax</td>
		 <td align=\"center\" width=\"50%\"> $nama2 </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> NIP :$nip</td>
		 <td align=\"center\" width=\"50%\"> NIP :$nip2 </td>
		 </tr>
         </table>
		 ";}
         */
		$data['prev'] = $cRet;
        $data['sikap'] = 'preview';
        $judul  = ("LRA SKPD $id / $cbulan");
        $this->template->set('title', 'LRA SKPD $id / $cbulan');        
        switch($pilih) {       
        case 1;
			echo ("<title>LRA SKPD $cbulan</title>");
			 echo $cRet;
        break;
        case 0;
			$this->_mpdf_down('',$cRet,10,10,10,'0',0,'','LRA Ringkasan '.$id.'');
        break;
        case 2;        
            header("Cache-Control: no-cache, no-store, must-revalidate");
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename= $judul.xls");
            
            $this->load->view('anggaran/rka/perkadaII', $data);
        break;
        case 3;     
            header("Cache-Control: no-cache, no-store, must-revalidate");
            header("Content-Type: application/vnd.ms-word");
            header("Content-Disposition: attachment; filename= $judul.doc");
            $this->load->view('anggaran/rka/perkadaII', $data);
        break;
        } 
    }
    
	 function cetak_lra_bulan_jenis($cbulan='', $cetak='', $txt=''){
	        $txt="1";
			//$tanggalttd = $this->uri->segment(5);
            //$ttd1 = str_replace('a',' ',$this->uri->segment(6));
            //$ttd2 = str_replace('a',' ',$this->uri->segment(7));            
            $bulan = strtoupper($this->tukd_model->getBulan($cbulan));
			$skpd = $this->uri->segment(8);
            $ag_tox = $this->uri->segment(9);
			$sql1 = "SELECT nm_skpd FROM ms_skpd WHERE kd_skpd='$skpd'";
			$ivan = $this->db->query($sql1);
			$oioi = $ivan->row();
			$nmskpd = $oioi->nm_skpd;
			$realpend=0;
			$anggpend=0;
			
            /*$sqlanggaran1="select case when statu=1 and status_sempurna=1 and status_ubah=1 and $cbulan>=month(tgl_dpa_ubah) then 2 
					   when statu=1 and status_sempurna=1 and status_ubah=1 and $cbulan>=month(tgl_dpa_sempurna) and $cbulan<month(tgl_dpa_ubah) then 1
					   when statu=1 and status_sempurna=1 and status_ubah=1 and $cbulan<month(tgl_dpa_sempurna) then 1
					   when statu=1 and status_sempurna=1 and status_ubah=0 and $cbulan>=month(tgl_dpa_sempurna) then 1 
					   when statu=1 and status_sempurna=1 and status_ubah=0 and $cbulan<month(tgl_dpa_sempurna) then 1
					   when statu=1 and status_sempurna=0 and status_ubah=0 and $cbulan>=month(tgl_dpa) then 1
					   else 1 end as anggaran from trhrka where kd_skpd='$skpd'";*/
                       
            $sqlanggaran1="select case when statu=1 and status_sempurna=1 and status_ubah=1 then 2 
					   when statu=1 and status_sempurna=1 and status_ubah=0 then 2
					   when statu=1 and status_sempurna=0 and status_ubah=0 then 1
					   else 1 end as anggaran from trhrka where kd_skpd='$skpd'";                       
                       
    $sqlanggaran=$this->db->query($sqlanggaran1);
	foreach ($sqlanggaran->result() as $rowttd)
        {
            $anggaran=$rowttd->anggaran;
        }

	//$ag_tox=$anggaran;
    /*
    if($stt_ttd==1){ 
        $ctgl_ttd = $this->tukd_model->tanggal_format_indonesia($tanggalttd);
			$sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab FROM ms_ttd where kd_skpd='$skpd' and kode='PA' and nip ='$ttd1'";
            $sqlttd=$this->db->query($sqlttd1);
            foreach ($sqlttd->result() as $rowttd)
			
                {
                    $nip=$rowttd->nip;                    
                    $oioi= $rowttd->nm;
                    $jabatan = $rowttd->jab;
                }			
			
			$sqlttd2="SELECT nama as nm,nip as nip,jabatan as jab FROM ms_ttd where kd_skpd='$skpd' and kode='PPK' and nip ='$ttd2'";
            $ttd11=$this->db->query($sqlttd2);
			foreach ($ttd11->result() as $ivan)
			    {
                    $nip1=$ivan->nip;                    
                    $oioi1= $ivan->nm;
                    $jabatan1 = $ivan->jab;
                }
	}	*/	
       $sqlsc="SELECT tgl_rka,provinsi,kab_kota,daerah,thn_ang FROM sclient where kd_skpd='$skpd'";
                 $sqlsclient=$this->db->query($sqlsc);
                 foreach ($sqlsclient->result() as $rowsc)
                {
                   
                    $tgl=$rowsc->tgl_rka;
                    $tanggal = $this->tukd_model->tanggal_format_indonesia($tgl);
                    $kab     = $rowsc->kab_kota;
                    $daerah  = $rowsc->daerah;
                    $thn     = $rowsc->thn_ang;
                } 
           
        $bersih_skpd= str_replace(".", "", $skpd);
        $print_r = explode(".",$skpd);
        $ke1 = $print_r[0];
        $ke2 = $print_r[1];
        $ke3 = $print_r[2];        
        $ke4 = $print_r[3]; 
        $skkd = $ke1."/".$ke2."/".$ke3;   
            
        $cRet='';
        
        $modtahun= $thn%4;
	 
	 if ($modtahun = 0){
        $nilaibulan=".31 JANUARI.29 FEBRUARI.31 MARET.30 APRIL.31 MEI.30 JUNI.31 JULI.31 AGUSTUS.30 SEPTEMBER.31 OKTOBER.30 NOVEMBER.31 DESEMBER";}
            else {
        $nilaibulan=".31 JANUARI.28 FEBRUARI.31 MARET.30 APRIL.31 MEI.30 JUNI.31 JULI.31 AGUSTUS.30 SEPTEMBER.31 OKTOBER.30 NOVEMBER.31 DESEMBER";}
	 
	 $arraybulan=explode(".",$nilaibulan);
       
        $cRet .="<table font-size:13px; style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
                    <tr>
                         <td align=\"center\"><strong>PEMERINTAH KABUPATEN SANGGAU</strong></td>                         
                    </tr>
					 <tr>
                         <td align=\"center\"><strong>$nmskpd</strong></td>                         
                    </tr>
                    <tr>
                         <td align=\"center\"><strong>LAPORAN REALISASI ANGGARAN</strong></td>
                    </tr>                    
                    <tr>
                         <td align=\"center\"><strong>PER $arraybulan[$cbulan] $thn</strong></td>
                    </tr>
                    <tr>
                         <td align=\"center\">&nbsp;</td>
                    </tr>
                  </table>";        
        
        
        $cRet .= "<table style=\"font-size:12px; border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"4\">
                     <thead>                       
                        <tr>
                            <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>                        
                            <td bgcolor=\"#CCCCCC\" width=\"5%\" align=\"center\"><b>NO</b></td>                            
                            <td  bgcolor=\"#CCCCCC\" width=\"37%\" align=\"center\"><b>URAIAN</b></td>
                            <td bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>ANGGARAN</b></td>
                            <td bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>REALISASI</b></td>
                            <td  bgcolor=\"#CCCCCC\" width=\"15%\" align=\"center\" ><b>LEBIH</br>(KURANG)</b></td>
                            <td  bgcolor=\"#CCCCCC\" width=\"5%\" align=\"center\" ><b>%</b></td>   
                        </tr>
                        
                     </thead>
                     <tfoot>
                        <tr>
                            <td style=\"border: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>                           
                         </tr>
                     </tfoot>
						";
					
					$cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>4<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"><b>PENDAPATAN<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";	                   	
               
                $sql4="
                select z.kode,z.nama,z.anggaran,z.reali from (
                SELECT left(a.kd_rek5,2) as kode,b.nm_rek2 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4( $cbulan,$ag_tox) a
                inner join ms_rek2 b on b.kd_rek2 = left(a.kd_rek5,2)                
                where left(a.kd_rek5,1)='4' and left(kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_rek5,2),b.nm_rek2
                union all
                SELECT left(a.kd_rek5,3) as kode,b.nm_rek3 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4( $cbulan,$ag_tox) a
                inner join ms_rek3 b on b.kd_rek3 = left(a.kd_rek5,3)                
                where left(a.kd_rek5,1)='4' and left(kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_rek5,3),b.nm_rek3
                union all
                SELECT left(a.kd_rek5,5) as kode,b.nm_rek4 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4( $cbulan,$ag_tox) a
                inner join ms_rek4 b on b.kd_rek4 = left(a.kd_rek5,5)                
                where left(a.kd_rek5,1)='4' and left(kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_rek5,5),b.nm_rek4
                )z order by kode,nama
                ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil    = $row4->reali;
					$angnil = $row4->anggaran;
					
                    $real_s = $angnil - $nil;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil;
                    }

                    $nilai    = number_format($nil,"2",".",",");
                    $angnilai = number_format($angnil,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai=='' or $angnilai==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil/$angnil)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                   if(strlen("$no")<4){
                    $cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                             }else
                             {
					$cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>   
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">$no</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\">$nama</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\">$x1$selisih$y1</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\">$persen1</td>
                                 </tr>";
                             }
               }
               		$cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                 $nil4=0;   
                 $angnil4=0;
                    $sql4="
                select z.kode,z.nama,z.anggaran,z.reali from (
                SELECT left(a.kd_rek5,1) as kode,b.nm_rek1 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4( $cbulan,$ag_tox) a
                inner join ms_rek1 b on b.kd_rek1 = left(a.kd_rek5,1)                
                where left(a.kd_rek5,1)='4' and left(kd_skpd,7) = left('$skpd',7)
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
					
                    $real_s = $angnil4 - $nil4;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil4==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil4;
                    }

                    $nilai4    = number_format($nil4,"2",".",",");
                    $angnilai4 = number_format($angnil4,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai4=='' or $angnilai4==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil4/$angnil4)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                    
               $cRet    .= "<tr>
                                 <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                 <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"><b>JUMLAH $nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai4<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai4<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                   }   
                   
                   $cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>   
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                      
                   	$cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>5<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"><b>BELANJA<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";	                   	
               
                   $sql4="
                select z.kode,z.nama,sum(z.anggaran) as anggaran,sum(z.reali) as reali from (
                SELECT left(a.kd_rek5,2) as kode,b.nm_rek2 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4( $cbulan,$ag_tox) a
                inner join ms_rek2_64 b on b.kd_rek2 = left(a.kd_rek5,2)                
                where left(a.kd_rek5,1)='5' and left(kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_rek5,2),b.nm_rek2
                union all
                
                SELECT left(a.kd_rek5,3) as kode,b.nm_rek3 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4( $cbulan,$ag_tox) a
                inner join ms_rek3_64 b on b.kd_rek3 = left(a.kd_rek5,3)                
                where left(a.kd_rek5,1)='5' and left(kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_rek5,3),b.nm_rek3
                union all
                
                SELECT left(a.kd_rek5,5) as kode,b.nm_rek4_64 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4( $cbulan,$ag_tox) a
                inner join ms_rek4_64 b on b.kd_rek4_64 = left(a.kd_rek5,5)                
                where left(a.kd_rek5,1)='5' and left(kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_rek5,5),b.nm_rek4_64
                )z 
                group by kode,nama
                order by kode,nama
                ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil    = $row4->reali;
					$angnil = $row4->anggaran;
					
                    $real_s = $angnil - $nil;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil;
                    }

                    $nilai    = number_format($nil,"2",".",",");
                    $angnilai = number_format($angnil,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai=='' or $angnilai==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil/$angnil)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                   if(strlen("$no")<4){
                    $cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                             }else
                             {
					$cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">$no</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\">$nama</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\">$x1$selisih$y1</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\">$persen1</td>
                                 </tr>";
                             }
               }  
               
                		$cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                    
                    $sql4="
                select z.kd_skpd,z.kode,z.nama,sum(z.anggaran) as anggaran,sum(z.reali) as reali from (
                SELECT left(a.kd_skpd,7) as kd_skpd,left(a.kd_rek5,1) as kode,'BELANJA' as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4( $cbulan,$ag_tox) a
                where left(a.kd_rek5,1)='5' and left(a.kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_skpd,7),left(a.kd_rek5,1)       
                ) z
                group by z.kd_skpd,z.kode,z.nama
                order by z.kode,z.nama
                ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil5    = $row4->reali;
					$angnil5 = $row4->anggaran;                                     
                    
                    $real_s = $angnil5 - $nil5;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil5==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil5;
                    }

                    $nilai5    = number_format($nil5,"2",".",",");
                    $angnilai5 = number_format($angnil5,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai5=='' or $angnilai5==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil5/$angnil5)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                
               	$cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                     
                    
               $cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"><b>JUMLAH $nama <b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai5<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai5<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                   }   
                 
                  	$cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                 
                 $no 	= '';
					$nama   = 'SURPLUS/DEFISIT';                      
					$nil    = $nil4 - $nil5;
					$angnil = $angnil4 - $angnil5;
					
                    $real_s = $angnil - $nil;

                    if ($angnil < 0){
                    	$a1="("; $angnil=$angnil*-1; $a2=")";}
                    else {
                    	$a1=""; $a2="";}

                    if ($nil < 0){
                    	$b1="("; $nil=$nil*-1; $b2=")";}
                    else {
                    	$b1=""; $b2="";}

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil;
                    }

                    $nilai    = number_format($nil,"2",".",",");
                    $angnilai = number_format($angnil,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai=='' or $angnilai==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil/$angnil)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                   
                   $cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$a1$angnilai$a2<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$b1$nilai$b2<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";         
              
        $cRet .=       " </table>";
        $data['prev']= $cRet;
		 $cRet         .= "</table>";
		 /*
		 if($stt_ttd==1){
		 $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> Mengetahui,</td>
		 <td align=\"center\" width=\"50%\"> Sanggau, $ctgl_ttd </td>
		 </tr>		
		 <tr>
		 <td align=\"center\" width=\"50%\"> $jabatan </td>
		 <td align=\"center\" width=\"50%\"> $jabatan1 </td>
		 </tr>	
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		  <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> $oioi</td>
		 <td align=\"center\" width=\"50%\"> $oioi1 </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> NIP :$nip</td>
		 <td align=\"center\" width=\"50%\"> NIP :$nip1 </td>
		 </tr>
         </table>
		 ";}*/
         
		$data['prev'] = $cRet;
        $data['sikap'] = 'preview';
        $judul  = 'LAPORAN REALISASI ANGGARAN';
        $this->template->set('title', 'CETAK LAPORAN REALISASI ANGGARAN');        
        switch($cetak) {
		case 1;
			 echo ("<title>L R A</title>"); 
             echo $cRet;
        break;		
        case 0;
             //$this->tukd_model->_mpdf('',$cRet,10,10,10,'P');
             	$this->_mpdf_down('',$cRet,10,10,10,'0',0,'','LRA Akun Jenis'.$skpd.'');
        break;
        case 2;        
            header("Cache-Control: no-cache, no-store, must-revalidate");
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename= $judul.xls");
            
            $this->load->view('anggaran/rka/perkadaII', $data);
        break;
        case 3;     
            header("Cache-Control: no-cache, no-store, must-revalidate");
            header("Content-Type: application/vnd.ms-word");
            header("Content-Disposition: attachment; filename= $judul.doc");
            $this->load->view('anggaran/rka/perkadaII', $data);
        break;
        } 
    }


	 function cetak_lra_bulan_jenis_skpd($cbulan='', $cetak='', $txt=''){
	        $txt="1";
			$tanggalttd = $this->uri->segment(5);
            $ttd1 = str_replace('a',' ',$this->uri->segment(6));
            $ttd2 = str_replace('a',' ',$this->uri->segment(7));
            $ctgl_ttd = $this->tukd_model->tanggal_format_indonesia($tanggalttd);
            $bulan = strtoupper($this->tukd_model->getBulan($cbulan));
			$skpd = $this->session->userdata('kdskpd'); 
			$sql1 = "SELECT nm_skpd FROM ms_skpd WHERE kd_skpd='$skpd'";
			$ivan = $this->db->query($sql1);
			$oioi = $ivan->row();
			$nmskpd = $oioi->nm_skpd;
			$realpend=0;
			$anggpend=0;
			
            /*$sqlanggaran1="select case when statu=1 and status_sempurna=1 and status_ubah=1 and $cbulan>=month(tgl_dpa_ubah) then 2 
					   when statu=1 and status_sempurna=1 and status_ubah=1 and $cbulan>=month(tgl_dpa_sempurna) and $cbulan<month(tgl_dpa_ubah) then 1
					   when statu=1 and status_sempurna=1 and status_ubah=1 and $cbulan<month(tgl_dpa_sempurna) then 1
					   when statu=1 and status_sempurna=1 and status_ubah=0 and $cbulan>=month(tgl_dpa_sempurna) then 1 
					   when statu=1 and status_sempurna=1 and status_ubah=0 and $cbulan<month(tgl_dpa_sempurna) then 1
					   when statu=1 and status_sempurna=0 and status_ubah=0 and $cbulan>=month(tgl_dpa) then 1
					   else 1 end as anggaran from trhrka where kd_skpd='$skpd'";*/
                       
            $sqlanggaran1="select case when statu=1 and status_sempurna=1 and status_ubah=1 then 2 
					   when statu=1 and status_sempurna=1 and status_ubah=0 then 2
					   when statu=1 and status_sempurna=0 and status_ubah=0 then 1
					   else 1 end as anggaran from trhrka where kd_skpd='$skpd'";                       
                       
    $sqlanggaran=$this->db->query($sqlanggaran1);
	foreach ($sqlanggaran->result() as $rowttd)
        {
            $anggaran=$rowttd->anggaran;
        }

	$ag_tox=$anggaran;
            
			$sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab FROM ms_ttd where kd_skpd='$skpd' and kode='PA' and nip ='$ttd1'";
            $sqlttd=$this->db->query($sqlttd1);
            foreach ($sqlttd->result() as $rowttd)
			
                {
                    $nip=$rowttd->nip;                    
                    $oioi= $rowttd->nm;
                    $jabatan = $rowttd->jab;
                }			
			
			$sqlttd2="SELECT nama as nm,nip as nip,jabatan as jab FROM ms_ttd where kd_skpd='$skpd' and kode='PPK' and nip ='$ttd2'";
            $ttd11=$this->db->query($sqlttd2);
			foreach ($ttd11->result() as $ivan)
			    {
                    $nip1=$ivan->nip;                    
                    $oioi1= $ivan->nm;
                    $jabatan1 = $ivan->jab;
                }
			
       $sqlsc="SELECT tgl_rka,provinsi,kab_kota,daerah,thn_ang FROM sclient where kd_skpd='$skpd'";
                 $sqlsclient=$this->db->query($sqlsc);
                 foreach ($sqlsclient->result() as $rowsc)
                {
                   
                    $tgl=$rowsc->tgl_rka;
                    $tanggal = $this->tukd_model->tanggal_format_indonesia($tgl);
                    $kab     = $rowsc->kab_kota;
                    $daerah  = $rowsc->daerah;
                    $thn     = $rowsc->thn_ang;
                } 
           
        $bersih_skpd= str_replace(".", "", $skpd);
        $print_r = explode(".",$skpd);
        $ke1 = $print_r[0];
        $ke2 = $print_r[1];
        $ke3 = $print_r[2];        
        $ke4 = $print_r[3]; 
        $skkd = $ke1."/".$ke2."/".$ke3;   
            
        $cRet='';
        
     $modtahun= $thn%4;
	 
	 if ($modtahun = 0){
        $nilaibulan=".31 JANUARI.29 FEBRUARI.31 MARET.30 APRIL.31 MEI.30 JUNI.31 JULI.31 AGUSTUS.30 SEPTEMBER.31 OKTOBER.30 NOVEMBER.31 DESEMBER";}
            else {
        $nilaibulan=".31 JANUARI.28 FEBRUARI.31 MARET.30 APRIL.31 MEI.30 JUNI.31 JULI.31 AGUSTUS.30 SEPTEMBER.31 OKTOBER.30 NOVEMBER.31 DESEMBER";}
	 
	 $arraybulan=explode(".",$nilaibulan);
       
        $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
                    <tr>
                         <td align=\"center\"><strong>PEMERINTAH KABUPATEN SANGGAU</strong></td>                         
                    </tr>
					 <tr>
                         <td align=\"center\"><strong>$nmskpd</strong></td>                         
                    </tr>
                    <tr>
                         <td align=\"center\"><strong>LAPORAN REALISASI ANGGARAN</strong></td>
                    </tr>                    
                    <tr>
                         <td align=\"center\"><strong>PER $arraybulan[$cbulan] $thn</strong></td>
                    </tr>
                    <tr>
                         <td align=\"center\">&nbsp;</td>
                    </tr>
                  </table>";        
        
        
        $cRet .= "<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"4\">
                     <thead>                       
                        <tr><td bgcolor=\"#CCCCCC\" width=\"5%\" align=\"center\"><b>NO</b></td>                            
                            <td  bgcolor=\"#CCCCCC\" width=\"45%\" align=\"center\"><b>URAIAN</b></td>
                            <td bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>ANGGARAN</b></td>
                            <td bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>REALISASI</b></td>
                            <td  bgcolor=\"#CCCCCC\" width=\"15%\" align=\"center\" ><b>LEBIH</br>(KURANG)</b></td>
                            <td  bgcolor=\"#CCCCCC\" width=\"5%\" align=\"center\" ><b>%</b></td>   
                        </tr>
                        
                     </thead>
                     <tfoot>
                        <tr>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>                           
                         </tr>
                     </tfoot>
						";
					
					$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>4<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>PENDAPATAN<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";	                   	
               
                $sql4="
                select z.kode,z.nama,z.anggaran,z.reali from (
                SELECT left(a.kd_rek5,2) as kode,b.nm_rek2 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM Data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek2 b on b.kd_rek2 = left(a.kd_rek5,2)                
                where left(a.kd_rek5,1)='4' and a.kd_skpd='$skpd'
                group by left(a.kd_rek5,2),b.nm_rek2
                union all
                SELECT left(a.kd_rek5,3) as kode,b.nm_rek3 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM Data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek3 b on b.kd_rek3 = left(a.kd_rek5,3)                
                where left(a.kd_rek5,1)='4' and a.kd_skpd='$skpd'
                group by left(a.kd_rek5,3),b.nm_rek3
                union all
                SELECT left(a.kd_rek5,5) as kode,b.nm_rek4 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM Data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek4 b on b.kd_rek4 = left(a.kd_rek5,5)                
                where left(a.kd_rek5,1)='4' and a.kd_skpd='$skpd'
                group by left(a.kd_rek5,5),b.nm_rek4
                )z order by kode,nama
                ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil    = $row4->reali;
					$angnil = $row4->anggaran;
					
                    $real_s = $angnil - $nil;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil;
                    }

                    $nilai    = number_format($nil,"2",".",",");
                    $angnilai = number_format($angnil,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai=='' or $angnilai==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil/$angnil)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                   if(strlen("$no")<4){
                    $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                             }else
                             {
					$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">$no</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\">$nama</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\">$x1$selisih$y1</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\">$persen1</td>
                                 </tr>";
                             }
               }
               		$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                 $nil4=0;   
                 $angnil4=0;
                    $sql4="
                select z.kode,z.nama,z.anggaran,z.reali from (
                SELECT left(a.kd_rek5,1) as kode,b.nm_rek1 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM Data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek1 b on b.kd_rek1 = left(a.kd_rek5,1)                
                where left(a.kd_rek5,1)='4' and a.kd_skpd='$skpd'
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
					
                    $real_s = $angnil4 - $nil4;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil4==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil4;
                    }

                    $nilai4    = number_format($nil4,"2",".",",");
                    $angnilai4 = number_format($angnil4,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai4=='' or $angnilai4==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil4/$angnil4)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                    
               $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>JUMLAH $nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai4<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai4<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                   }   
                   
                   $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                      
                   	$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>5<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>BELANJA<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";	                   	
               
                   $sql4="
                select z.kode,z.nama,sum(z.anggaran) as anggaran,sum(z.reali) as reali from (
                SELECT left(a.kd_rek5,2) as kode,b.nm_rek2 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM Data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek2_64 b on b.kd_rek2 = left(a.kd_rek5,2)                
                where left(a.kd_rek5,1)='5' and a.kd_skpd='$skpd'
                group by left(a.kd_rek5,2),b.nm_rek2
                union all
                
                SELECT left(a.kd_rek5,3) as kode,b.nm_rek3 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM Data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek3_64 b on b.kd_rek3 = left(a.kd_rek5,3)                
                where left(a.kd_rek5,1)='5' and a.kd_skpd='$skpd'
                group by left(a.kd_rek5,3),b.nm_rek3
                union all
                
                SELECT left(a.kd_rek5,5) as kode,b.nm_rek4_64 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM Data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek4_64 b on b.kd_rek4_64 = left(a.kd_rek5,5)                
                where left(a.kd_rek5,1)='5' and a.kd_skpd='$skpd'
                group by left(a.kd_rek5,5),b.nm_rek4_64
                )z 
                group by kode,nama
                order by kode,nama
                ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil    = $row4->reali;
					$angnil = $row4->anggaran;
					
                    $real_s = $angnil - $nil;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil;
                    }

                    $nilai    = number_format($nil,"2",".",",");
                    $angnilai = number_format($angnil,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai=='' or $angnilai==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil/$angnil)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                   if(strlen("$no")<4){
                    $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                             }else
                             {
					$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">$no</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\">$nama</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\">$x1$selisih$y1</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\">$persen1</td>
                                 </tr>";
                             }
               }  
               
                		$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                    
                    $sql4="
                select z.kd_skpd,z.kode,z.nama,sum(z.anggaran) as anggaran,sum(z.reali) as reali from (
                SELECT left(a.kd_skpd,7) as kd_skpd,left(a.kd_rek5,1) as kode,'BELANJA' as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM Data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                where left(a.kd_rek5,1)='5' and a.kd_skpd='$skpd'
                group by left(a.kd_skpd,7),left(a.kd_rek5,1)       
                ) z
                group by z.kd_skpd,z.kode,z.nama
                order by z.kode,z.nama
                ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil5    = $row4->reali;
					$angnil5 = $row4->anggaran;                                     
                    
                    $real_s = $angnil5 - $nil5;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil5==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil5;
                    }

                    $nilai5    = number_format($nil5,"2",".",",");
                    $angnilai5 = number_format($angnil5,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai5=='' or $angnilai5==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil5/$angnil5)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                
               	$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                     
                    
               $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>JUMLAH $nama <b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai5<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai5<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                   }   
                 
                  	$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                 
                 $no 	= '';
					$nama   = 'SURPLUS/DEFISIT';                      
					$nil    = $nil4 - $nil5;
					$angnil = $angnil4 - $angnil5;
					
                    $real_s = $angnil - $nil;

                    if ($angnil < 0){
                    	$a1="("; $angnil=$angnil*-1; $a2=")";}
                    else {
                    	$a1=""; $a2="";}

                    if ($nil < 0){
                    	$b1="("; $nil=$nil*-1; $b2=")";}
                    else {
                    	$b1=""; $b2="";}

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil;
                    }

                    $nilai    = number_format($nil,"2",".",",");
                    $angnilai = number_format($angnil,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai=='' or $angnilai==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil/$angnil)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                   
                   $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$a1$angnilai$a2<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$b1$nilai$b2<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";         
              
        $cRet .=       " </table>";
        $data['prev']= $cRet;
		 $cRet         .= "</table>";
		 
		 if($txt==1){
		 $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> Mengetahui,</td>
		 <td align=\"center\" width=\"50%\"> Sanggau, $ctgl_ttd </td>
		 </tr>		
		 <tr>
		 <td align=\"center\" width=\"50%\"> $jabatan </td>
		 <td align=\"center\" width=\"50%\"> $jabatan1 </td>
		 </tr>	
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		  <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> $oioi</td>
		 <td align=\"center\" width=\"50%\"> $oioi1 </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> NIP :$nip</td>
		 <td align=\"center\" width=\"50%\"> NIP :$nip1 </td>
		 </tr>
         </table>
		 ";}
		$data['prev'] = $cRet;
        $data['sikap'] = 'preview';
        $judul  = 'LAPORAN REALISASI ANGGARAN';
        $this->template->set('title', 'CETAK LAPORAN REALISASI ANGGARAN');        
        switch($cetak) {
		case 1;
			 echo ("<title>L R A</title>"); 
             echo $cRet;
        break;		
        case 0;
             //$this->tukd_model->_mpdf('',$cRet,10,10,10,'P');
             	$this->_mpdf_down('',$cRet,10,10,10,'0',0,'','LRA Akun Jenis'.$skpd.'');
        break;
        case 2;        
            header("Cache-Control: no-cache, no-store, must-revalidate");
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename= $judul.xls");
            
            $this->load->view('anggaran/rka/perkadaII', $data);
        break;
        case 3;     
            header("Cache-Control: no-cache, no-store, must-revalidate");
            header("Content-Type: application/vnd.ms-word");
            header("Content-Disposition: attachment; filename= $judul.doc");
            $this->load->view('anggaran/rka/perkadaII', $data);
        break;
        } 
    }
    
     function cetak_lra_bulan_jenis_ang($cbulan='', $cetak='', $txt=''){
	        $txt="1";
			//$tanggalttd = $this->uri->segment(5);
            //$ttd1 = str_replace('a',' ',$this->uri->segment(6));
            //$ttd2 = str_replace('a',' ',$this->uri->segment(7));
            //$ctgl_ttd = $this->tukd_model->tanggal_format_indonesia($tanggalttd);
            $bulan = strtoupper($this->tukd_model->getBulan($cbulan));
			$skpd = $this->uri->segment(8);
            $ag_tox = $this->uri->segment(9);
			$sql1 = "SELECT nm_skpd FROM ms_skpd WHERE kd_skpd='$skpd'";
			$ivan = $this->db->query($sql1);
			$oioi = $ivan->row();
			$nmskpd = $oioi->nm_skpd;
			$realpend=0;
			$anggpend=0;
			
            /*$sqlanggaran1="select case when statu=1 and status_sempurna=1 and status_ubah=1 and $cbulan>=month(tgl_dpa_ubah) then 2 
					   when statu=1 and status_sempurna=1 and status_ubah=1 and $cbulan>=month(tgl_dpa_sempurna) and $cbulan<month(tgl_dpa_ubah) then 1
					   when statu=1 and status_sempurna=1 and status_ubah=1 and $cbulan<month(tgl_dpa_sempurna) then 1
					   when statu=1 and status_sempurna=1 and status_ubah=0 and $cbulan>=month(tgl_dpa_sempurna) then 1 
					   when statu=1 and status_sempurna=1 and status_ubah=0 and $cbulan<month(tgl_dpa_sempurna) then 1
					   when statu=1 and status_sempurna=0 and status_ubah=0 and $cbulan>=month(tgl_dpa) then 1
					   else 1 end as anggaran from trhrka where kd_skpd='$skpd'";*/
                       
             $sqlanggaran1="select case when statu=1 and status_sempurna=1 and status_ubah=1 then 2 
					   when statu=1 and status_sempurna=1 and status_ubah=0 then 2
					   when statu=1 and status_sempurna=0 and status_ubah=0 then 1
					   else 1 end as anggaran from trhrka where kd_skpd='$skpd'";
                                 
    $sqlanggaran=$this->db->query($sqlanggaran1);
	foreach ($sqlanggaran->result() as $rowttd)
        {
            $anggaran=$rowttd->anggaran;
        }

	//$ag_tox=$anggaran;
            /*
			$sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab FROM ms_ttd where kd_skpd='$skpd' and kode='PA' and nip='$ttd1'";
            $sqlttd=$this->db->query($sqlttd1);
            foreach ($sqlttd->result() as $rowttd)
			
                {
                    $nip=$rowttd->nip;                    
                    $oioi= $rowttd->nm;
                    $jabatan = $rowttd->jab;
                }			
			
			$sqlttd2="SELECT nama as nm,nip as nip,jabatan as jab FROM ms_ttd where kd_skpd='$skpd' and kode='PPK' and nip='$ttd2'";
            $ttd11=$this->db->query($sqlttd2);
			foreach ($ttd11->result() as $ivan)
			    {
                    $nip1=$ivan->nip;                    
                    $oioi1= $ivan->nm;
                    $jabatan1 = $ivan->jab;
                }
			*/
       $sqlsc="SELECT tgl_rka,provinsi,kab_kota,daerah,thn_ang FROM sclient where kd_skpd='$skpd'";
                 $sqlsclient=$this->db->query($sqlsc);
                 foreach ($sqlsclient->result() as $rowsc)
                {
                   
                    $tgl=$rowsc->tgl_rka;
                    $tanggal = $this->tukd_model->tanggal_format_indonesia($tgl);
                    $kab     = $rowsc->kab_kota;
                    $daerah  = $rowsc->daerah;
                    $thn     = $rowsc->thn_ang;
                } 
           
        $bersih_skpd= str_replace(".", "", $skpd);
        $print_r = explode(".",$skpd);
        $ke1 = $print_r[0];
        $ke2 = $print_r[1];
        $ke3 = $print_r[2];        
        $ke4 = $print_r[3]; 
        $skkd = $ke1."/".$ke2."/".$ke3;   
            
        $cRet='';
        
     $modtahun= $thn%4;
	 
	 if ($modtahun = 0){
        $nilaibulan=".31 JANUARI.29 FEBRUARI.31 MARET.30 APRIL.31 MEI.30 JUNI.31 JULI.31 AGUSTUS.30 SEPTEMBER.31 OKTOBER.30 NOVEMBER.31 DESEMBER";}
            else {
        $nilaibulan=".31 JANUARI.28 FEBRUARI.31 MARET.30 APRIL.31 MEI.30 JUNI.31 JULI.31 AGUSTUS.30 SEPTEMBER.31 OKTOBER.30 NOVEMBER.31 DESEMBER";}
	 
	 $arraybulan=explode(".",$nilaibulan);
        
        $cRet .="<table style=\"font-size:13px; border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
                    <tr>
                         <td align=\"center\"><strong>PEMERINTAH KABUPATEN SANGGAU</strong></td>                         
                    </tr>
					 <tr>
                         <td align=\"center\"><strong>$nmskpd</strong></td>                         
                    </tr>
                    <tr>
                         <td align=\"center\"><strong>LAPORAN REALISASI ANGGARAN </strong></td>
                    </tr>                    
                    <tr>
                         <td align=\"center\"><strong>PER $arraybulan[$cbulan] $thn</strong></td>
                    </tr>
                    <tr>
                         <td align=\"center\">&nbsp;</td>
                    </tr>
                  </table>";        
        
        
        $cRet .= "<table style=\"font-size:12px; border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"4\">
                     <thead>                       
                        <tr>
                            <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                            <td bgcolor=\"#CCCCCC\" width=\"5%\" align=\"center\"><b>NO</b></td>                            
                            <td  bgcolor=\"#CCCCCC\" width=\"37%\" align=\"center\"><b>URAIAN</b></td>
                            <td bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>ANGGARAN</b></td>
                            <td bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>REALISASI</b></td>
                            <td  bgcolor=\"#CCCCCC\" width=\"15%\" align=\"center\" ><b>LEBIH</br>(KURANG)</b></td>
                            <td  bgcolor=\"#CCCCCC\" width=\"5%\" align=\"center\" ><b>%</b></td>   
                        </tr>
                        
                     </thead>
                     <tfoot>
                        <tr>
                            <td style=\"border: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>                           
                         </tr>
                     </tfoot>
						";
					
					$cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>4<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"><b>PENDAPATAN<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";	                   	
               
                $sql4="
                select z.kode,z.nama,z.anggaran,z.reali from (
                SELECT left(a.kd_ang,2) as kode,b.nm_rek2 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4( $cbulan,$ag_tox) a
                inner join ms_rek2 b on b.kd_rek2 = left(a.kd_ang,2)                
                where left(a.kd_ang,1)='4' and left(kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_ang,2),b.nm_rek2
                union all
                SELECT left(a.kd_ang,3) as kode,b.nm_rek3 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4( $cbulan,$ag_tox) a
                inner join ms_rek3 b on b.kd_rek3 = left(a.kd_ang,3)                
                where left(a.kd_ang,1)='4' and left(kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_ang,3),b.nm_rek3
                union all
                SELECT left(a.kd_ang,5) as kode,b.nm_rek4 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4( $cbulan,$ag_tox) a
                inner join ms_rek4 b on b.kd_rek4 = left(a.kd_ang,5)                
                where left(a.kd_ang,1)='4' and left(kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_ang,5),b.nm_rek4
                )z order by kode,nama
                ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil    = $row4->reali;
					$angnil = $row4->anggaran;
					
                    $real_s = $angnil - $nil;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil;
                    }

                    $nilai    = number_format($nil,"2",".",",");
                    $angnilai = number_format($angnil,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai=='' or $angnilai==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil/$angnil)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                   if(strlen("$no")<4){
                    $cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                             }else
                             {
					$cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">$no</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\">$nama</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\">$x1$selisih$y1</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\">$persen1</td>
                                 </tr>";
                             }
               }
               		$cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                 $nil4=0;   
                 $angnil4=0;
                    $sql4="
                select z.kode,z.nama,z.anggaran,z.reali from (
                SELECT left(a.kd_ang,1) as kode,b.nm_rek1 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4( $cbulan,$ag_tox) a
                inner join ms_rek1 b on b.kd_rek1 = left(a.kd_ang,1)                
                where left(a.kd_ang,1)='4' and left(kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_ang,1),b.nm_rek1               
                )z order by kode,nama
                ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil4    = $row4->reali;
					$angnil4 = $row4->anggaran;
					
                    $real_s = $angnil4 - $nil4;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil4==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil4;
                    }

                    $nilai4    = number_format($nil4,"2",".",",");
                    $angnilai4 = number_format($angnil4,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai4=='' or $angnilai4==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil4/$angnil4)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                    
               $cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"><b>JUMLAH $nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai4<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai4<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                   }   
                   
                   $cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                      
                   	$cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>5<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"><b>BELANJA<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";	                   	
               
                   $sql4="
                select z.kode,z.nama,sum(z.anggaran) as anggaran,sum(z.reali) as reali from (
                SELECT left(a.kd_ang,2) as kode,b.nm_rek2 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4( $cbulan,$ag_tox) a
                inner join ms_rek2 b on b.kd_rek2 = left(a.kd_ang,2)                
                where left(a.kd_ang,1)='5' and left(kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_ang,2),b.nm_rek2
                union all
                
                SELECT left(a.kd_ang,3) as kode,b.nm_rek3 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4( $cbulan,$ag_tox) a
                inner join ms_rek3 b on b.kd_rek3 = left(a.kd_ang,3)                
                where left(a.kd_ang,1)='5' and left(kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_ang,3),b.nm_rek3
                union all
                
                SELECT left(a.kd_ang,5) as kode,b.nm_rek4 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4( $cbulan,$ag_tox) a
                inner join ms_rek4 b on b.kd_rek4 = left(a.kd_ang,5)                
                where left(a.kd_ang,1)='5' and left(kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_ang,5),b.nm_rek4
                )z 
                group by kode,nama
                order by kode,nama
                ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil    = $row4->reali;
					$angnil = $row4->anggaran;
					
                    $real_s = $angnil - $nil;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil;
                    }

                    $nilai    = number_format($nil,"2",".",",");
                    $angnilai = number_format($angnil,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai=='' or $angnilai==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil/$angnil)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                   if(strlen("$no")<4){
                    $cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>   
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                             }else
                             {
					$cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">$no</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\">$nama</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\">$x1$selisih$y1</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\">$persen1</td>
                                 </tr>";
                             }
               }  
               
                		$cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                    
                    $sql4="
                select z.kd_skpd,z.kode,z.nama,sum(z.anggaran) as anggaran,sum(z.reali) as reali from (
                SELECT left(a.kd_skpd,7) as kd_skpd,left(a.kd_ang,1) as kode,'BELANJA' as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4( $cbulan,$ag_tox) a
                where left(a.kd_ang,1)='5' and left(a.kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_skpd,7),left(a.kd_ang,1)       
                ) z
                group by z.kd_skpd,z.kode,z.nama
                order by z.kode,z.nama
                ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil5    = $row4->reali;
					$angnil5 = $row4->anggaran;                                     
                    
                    $real_s = $angnil5 - $nil5;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil5==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil5;
                    }

                    $nilai5    = number_format($nil5,"2",".",",");
                    $angnilai5 = number_format($angnil5,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai5=='' or $angnilai5==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil5/$angnil5)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                
               	$cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                     
                    
               $cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"><b>JUMLAH $nama <b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai5<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai5<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                   }   
                 
                  	$cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                 
                 $no 	= '';
					$nama   = 'SURPLUS/DEFISIT';                      
					$nil    = $nil4 - $nil5;
					$angnil = $angnil4 - $angnil5;
					
                    $real_s = $angnil - $nil;

                    if ($angnil < 0){
                    	$a1="("; $angnil=$angnil*-1; $a2=")";}
                    else {
                    	$a1=""; $a2="";}

                    if ($nil < 0){
                    	$b1="("; $nil=$nil*-1; $b2=")";}
                    else {
                    	$b1=""; $b2="";}

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil;
                    }

                    $nilai    = number_format($nil,"2",".",",");
                    $angnilai = number_format($angnil,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai=='' or $angnilai==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil/$angnil)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                   
                   $cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$a1$angnilai$a2<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$b1$nilai$b2<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";         
              
        $cRet .=       " </table>";
        $data['prev']= $cRet;
		 $cRet         .= "</table>";
		 /*
		 if($txt==1){
		 $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> Mengetahui,</td>
		 <td align=\"center\" width=\"50%\"> Sanggau, $ctgl_ttd </td>
		 </tr>		
		 <tr>
		 <td align=\"center\" width=\"50%\"> $jabatan</td>
		 <td align=\"center\" width=\"50%\"> $jabatan1 </td>
		 </tr>	
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		  <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> $oioi </td>
		 <td align=\"center\" width=\"50%\"> $oioi1 </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> NIP :$nip</td>
		 <td align=\"center\" width=\"50%\"> NIP :$nip1 </td>
		 </tr>
         </table>
		 ";}*/
		$data['prev'] = $cRet;
        $data['sikap'] = 'preview';
        $judul  = 'LAPORAN REALISASI ANGGARAN';
        $this->template->set('title', 'CETAK LAPORAN REALISASI ANGGARAN');        
        switch($cetak) {
		case 1;
			 echo ("<title>L R A</title>"); 
             echo $cRet;
        break;		
        case 0;
             //$this->tukd_model->_mpdf('',$cRet,10,10,10,'P');
             	$this->_mpdf_down('',$cRet,10,10,10,'0',0,'','LRA Akun Jenis'.$skpd.'');
        break;
        case 2;        
            header("Cache-Control: no-cache, no-store, must-revalidate");
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename= $judul.xls");
            
            $this->load->view('anggaran/rka/perkadaII', $data);
        break;
        case 3;     
            header("Cache-Control: no-cache, no-store, must-revalidate");
            header("Content-Type: application/vnd.ms-word");
            header("Content-Disposition: attachment; filename= $judul.doc");
            $this->load->view('anggaran/rka/perkadaII', $data);
        break;
        } 
    }
    
     function cetak_lra_bulan_jenis_ang_skpd($cbulan='', $cetak='', $txt=''){
	        $txt="1";
			$tanggalttd = $this->uri->segment(5);
            $ttd1 = str_replace('a',' ',$this->uri->segment(6));
            $ttd2 = str_replace('a',' ',$this->uri->segment(7));
            $ctgl_ttd = $this->tukd_model->tanggal_format_indonesia($tanggalttd);
            $bulan = strtoupper($this->tukd_model->getBulan($cbulan));
			$skpd = $this->session->userdata('kdskpd'); 
			$sql1 = "SELECT nm_skpd FROM ms_skpd WHERE kd_skpd='$skpd'";
			$ivan = $this->db->query($sql1);
			$oioi = $ivan->row();
			$nmskpd = $oioi->nm_skpd;
			$realpend=0;
			$anggpend=0;
			
            /*$sqlanggaran1="select case when statu=1 and status_sempurna=1 and status_ubah=1 and $cbulan>=month(tgl_dpa_ubah) then 2 
					   when statu=1 and status_sempurna=1 and status_ubah=1 and $cbulan>=month(tgl_dpa_sempurna) and $cbulan<month(tgl_dpa_ubah) then 1
					   when statu=1 and status_sempurna=1 and status_ubah=1 and $cbulan<month(tgl_dpa_sempurna) then 1
					   when statu=1 and status_sempurna=1 and status_ubah=0 and $cbulan>=month(tgl_dpa_sempurna) then 1 
					   when statu=1 and status_sempurna=1 and status_ubah=0 and $cbulan<month(tgl_dpa_sempurna) then 1
					   when statu=1 and status_sempurna=0 and status_ubah=0 and $cbulan>=month(tgl_dpa) then 1
					   else 1 end as anggaran from trhrka where kd_skpd='$skpd'";*/
            
            $sqlanggaran1="select case when statu=1 and status_sempurna=1 and status_ubah=1 then 2 
					   when statu=1 and status_sempurna=1 and status_ubah=0 then 2
					   when statu=1 and status_sempurna=0 and status_ubah=0 then 1
					   else 1 end as anggaran from trhrka where kd_skpd='$skpd'";                                   
                       
    $sqlanggaran=$this->db->query($sqlanggaran1);
	foreach ($sqlanggaran->result() as $rowttd)
        {
            $anggaran=$rowttd->anggaran;
        }

	$ag_tox=$anggaran;
            
			$sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab FROM ms_ttd where kd_skpd='$skpd' and kode='PA' and nip='$ttd1'";
            $sqlttd=$this->db->query($sqlttd1);
            foreach ($sqlttd->result() as $rowttd)
			
                {
                    $nip=$rowttd->nip;                    
                    $oioi= $rowttd->nm;
                    $jabatan = $rowttd->jab;
                }			
			
			$sqlttd2="SELECT nama as nm,nip as nip,jabatan as jab FROM ms_ttd where kd_skpd='$skpd' and kode='PPK' and nip='$ttd2'";
            $ttd11=$this->db->query($sqlttd2);
			foreach ($ttd11->result() as $ivan)
			    {
                    $nip1=$ivan->nip;                    
                    $oioi1= $ivan->nm;
                    $jabatan1 = $ivan->jab;
                }
			
       $sqlsc="SELECT tgl_rka,provinsi,kab_kota,daerah,thn_ang FROM sclient where kd_skpd='$skpd'";
                 $sqlsclient=$this->db->query($sqlsc);
                 foreach ($sqlsclient->result() as $rowsc)
                {
                   
                    $tgl=$rowsc->tgl_rka;
                    $tanggal = $this->tukd_model->tanggal_format_indonesia($tgl);
                    $kab     = $rowsc->kab_kota;
                    $daerah  = $rowsc->daerah;
                    $thn     = $rowsc->thn_ang;
                } 
           
        $bersih_skpd= str_replace(".", "", $skpd);
        $print_r = explode(".",$skpd);
        $ke1 = $print_r[0];
        $ke2 = $print_r[1];
        $ke3 = $print_r[2];        
        $ke4 = $print_r[3]; 
        $skkd = $ke1."/".$ke2."/".$ke3;   
            
        $cRet='';
        
        $modtahun= $thn%4;
	 
	 if ($modtahun = 0){
        $nilaibulan=".31 JANUARI.29 FEBRUARI.31 MARET.30 APRIL.31 MEI.30 JUNI.31 JULI.31 AGUSTUS.30 SEPTEMBER.31 OKTOBER.30 NOVEMBER.31 DESEMBER";}
            else {
        $nilaibulan=".31 JANUARI.28 FEBRUARI.31 MARET.30 APRIL.31 MEI.30 JUNI.31 JULI.31 AGUSTUS.30 SEPTEMBER.31 OKTOBER.30 NOVEMBER.31 DESEMBER";}
	 
	 $arraybulan=explode(".",$nilaibulan);
        
        $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
                    <tr>
                         <td align=\"center\"><strong>PEMERINTAH KABUPATEN SANGGAU</strong></td>                         
                    </tr>
					 <tr>
                         <td align=\"center\"><strong>$nmskpd</strong></td>                         
                    </tr>
                    <tr>
                         <td align=\"center\"><strong>LAPORAN REALISASI ANGGARAN </strong></td>
                    </tr>                    
                    <tr>
                         <td align=\"center\"><strong>PER $arraybulan[$cbulan] $thn</strong></td>
                    </tr>
                    <tr>
                         <td align=\"center\">&nbsp;</td>
                    </tr>
                  </table>";        
        
        
        $cRet .= "<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"4\">
                     <thead>                       
                        <tr><td bgcolor=\"#CCCCCC\" width=\"5%\" align=\"center\"><b>NO</b></td>                            
                            <td  bgcolor=\"#CCCCCC\" width=\"45%\" align=\"center\"><b>URAIAN</b></td>
                            <td bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>ANGGARAN</b></td>
                            <td bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>REALISASI</b></td>
                            <td  bgcolor=\"#CCCCCC\" width=\"15%\" align=\"center\" ><b>LEBIH</br>(KURANG)</b></td>
                            <td  bgcolor=\"#CCCCCC\" width=\"5%\" align=\"center\" ><b>%</b></td>   
                        </tr>
                        
                     </thead>
                     <tfoot>
                        <tr>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>                           
                         </tr>
                     </tfoot>
						";
					
					$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>4<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>PENDAPATAN<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";	                   	
               
                $sql4="
                select z.kode,z.nama,z.anggaran,z.reali from (
                SELECT left(a.kd_ang,2) as kode,b.nm_rek2 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek2 b on b.kd_rek2 = left(a.kd_ang,2)                
                where left(a.kd_ang,1)='4' and kd_skpd = '$skpd'
                group by left(a.kd_ang,2),b.nm_rek2
                union all
                SELECT left(a.kd_ang,3) as kode,b.nm_rek3 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek3 b on b.kd_rek3 = left(a.kd_ang,3)                
                where left(a.kd_ang,1)='4' and kd_skpd = '$skpd'
                group by left(a.kd_ang,3),b.nm_rek3
                union all
                SELECT left(a.kd_ang,5) as kode,b.nm_rek4 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek4 b on b.kd_rek4 = left(a.kd_ang,5)                
                where left(a.kd_ang,1)='4' and kd_skpd = '$skpd'
                group by left(a.kd_ang,5),b.nm_rek4
                )z order by kode,nama
                ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil    = $row4->reali;
					$angnil = $row4->anggaran;
					
                    $real_s = $angnil - $nil;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil;
                    }

                    $nilai    = number_format($nil,"2",".",",");
                    $angnilai = number_format($angnil,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai=='' or $angnilai==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil/$angnil)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                   if(strlen("$no")<4){
                    $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                             }else
                             {
					$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">$no</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\">$nama</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\">$x1$selisih$y1</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\">$persen1</td>
                                 </tr>";
                             }
               }
               		$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                 $nil4=0;   
                 $angnil4=0;
                    $sql4="
                select z.kode,z.nama,z.anggaran,z.reali from (
                SELECT left(a.kd_ang,1) as kode,b.nm_rek1 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek1 b on b.kd_rek1 = left(a.kd_ang,1)                
                where left(a.kd_ang,1)='4' and kd_skpd = '$skpd'
                group by left(a.kd_ang,1),b.nm_rek1               
                )z order by kode,nama
                ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil4    = $row4->reali;
					$angnil4 = $row4->anggaran;
					
                    $real_s = $angnil4 - $nil4;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil4==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil4;
                    }

                    $nilai4    = number_format($nil4,"2",".",",");
                    $angnilai4 = number_format($angnil4,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai4=='' or $angnilai4==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil4/$angnil4)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                    
               $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>JUMLAH $nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai4<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai4<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                   }   
                   
                   $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                      
                   	$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>5<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>BELANJA<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";	                   	
               
                   $sql4="
                select z.kode,z.nama,sum(z.anggaran) as anggaran,sum(z.reali) as reali from (
                SELECT left(a.kd_ang,2) as kode,b.nm_rek2 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek2 b on b.kd_rek2 = left(a.kd_ang,2)                
                where left(a.kd_ang,1)='5' and kd_skpd = '$skpd'
                group by left(a.kd_ang,2),b.nm_rek2
                union all
                
                SELECT left(a.kd_ang,3) as kode,b.nm_rek3 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek3 b on b.kd_rek3 = left(a.kd_ang,3)                
                where left(a.kd_ang,1)='5' and kd_skpd = '$skpd'
                group by left(a.kd_ang,3),b.nm_rek3
                union all
                
                SELECT left(a.kd_ang,5) as kode,b.nm_rek4 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek4 b on b.kd_rek4 = left(a.kd_ang,5)                
                where left(a.kd_ang,1)='5' and kd_skpd = '$skpd'
                group by left(a.kd_ang,5),b.nm_rek4
                )z 
                group by kode,nama
                order by kode,nama
                ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil    = $row4->reali;
					$angnil = $row4->anggaran;
					
                    $real_s = $angnil - $nil;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil;
                    }

                    $nilai    = number_format($nil,"2",".",",");
                    $angnilai = number_format($angnil,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai=='' or $angnilai==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil/$angnil)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                   if(strlen("$no")<4){
                    $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                             }else
                             {
					$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">$no</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\">$nama</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\">$x1$selisih$y1</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\">$persen1</td>
                                 </tr>";
                             }
               }  
               
                		$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                    
                    $sql4="
                select z.kd_skpd,z.kode,z.nama,sum(z.anggaran) as anggaran,sum(z.reali) as reali from (
                SELECT left(a.kd_skpd,7) as kd_skpd,left(a.kd_ang,1) as kode,'BELANJA' as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                where left(a.kd_ang,1)='5' and kd_skpd = '$skpd'
                group by left(a.kd_skpd,7),left(a.kd_ang,1)       
                ) z
                group by z.kd_skpd,z.kode,z.nama
                order by z.kode,z.nama
                ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil5    = $row4->reali;
					$angnil5 = $row4->anggaran;                                     
                    
                    $real_s = $angnil5 - $nil5;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil5==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil5;
                    }

                    $nilai5    = number_format($nil5,"2",".",",");
                    $angnilai5 = number_format($angnil5,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai5=='' or $angnilai5==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil5/$angnil5)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                
               	$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                     
                    
               $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>JUMLAH $nama <b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai5<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai5<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                   }   
                 
                  	$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                 
                 $no 	= '';
					$nama   = 'SURPLUS/DEFISIT';                      
					$nil    = $nil4 - $nil5;
					$angnil = $angnil4 - $angnil5;
					
                    $real_s = $angnil - $nil;

                    if ($angnil < 0){
                    	$a1="("; $angnil=$angnil*-1; $a2=")";}
                    else {
                    	$a1=""; $a2="";}

                    if ($nil < 0){
                    	$b1="("; $nil=$nil*-1; $b2=")";}
                    else {
                    	$b1=""; $b2="";}

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil;
                    }

                    $nilai    = number_format($nil,"2",".",",");
                    $angnilai = number_format($angnil,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai=='' or $angnilai==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil/$angnil)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                   
                   $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$a1$angnilai$a2<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$b1$nilai$b2<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";         
              
        $cRet .=       " </table>";
        $data['prev']= $cRet;
		 $cRet         .= "</table>";
		 
		 if($txt==1){
		 $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> Mengetahui,</td>
		 <td align=\"center\" width=\"50%\"> Sanggau, $ctgl_ttd </td>
		 </tr>		
		 <tr>
		 <td align=\"center\" width=\"50%\"> $jabatan</td>
		 <td align=\"center\" width=\"50%\"> $jabatan1 </td>
		 </tr>	
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		  <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> $oioi </td>
		 <td align=\"center\" width=\"50%\"> $oioi1 </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> NIP :$nip</td>
		 <td align=\"center\" width=\"50%\"> NIP :$nip1 </td>
		 </tr>
         </table>
		 ";}
		$data['prev'] = $cRet;
        $data['sikap'] = 'preview';
        $judul  = 'LAPORAN REALISASI ANGGARAN';
        $this->template->set('title', 'CETAK LAPORAN REALISASI ANGGARAN');        
        switch($cetak) {
		case 1;
			 echo ("<title>L R A</title>"); 
             echo $cRet;
        break;		
        case 0;
             //$this->tukd_model->_mpdf('',$cRet,10,10,10,'P');
             	$this->_mpdf_down('',$cRet,10,10,10,'0',0,'','LRA Akun Jenis'.$skpd.'');
        break;
        case 2;        
            header("Cache-Control: no-cache, no-store, must-revalidate");
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename= $judul.xls");
            
            $this->load->view('anggaran/rka/perkadaII', $data);
        break;
        case 3;     
            header("Cache-Control: no-cache, no-store, must-revalidate");
            header("Content-Type: application/vnd.ms-word");
            header("Content-Disposition: attachment; filename= $judul.doc");
            $this->load->view('anggaran/rka/perkadaII', $data);
        break;
        } 
    }
    
   function cetak_lra_bulan_rincian($cbulan='', $cetak='', $txt='', $ctgl_ttd=''){
	        $txt="1";
			//$tanggalttd = $this->uri->segment(5);
            //$ttd1 = str_replace('a',' ',$this->uri->segment(6));
            //$ttd2 = str_replace('a',' ',$this->uri->segment(7));
            //$ctgl_ttd = $this->tukd_model->tanggal_format_indonesia($tanggalttd);
            $bulan = strtoupper($this->tukd_model->getBulan($cbulan));
			$skpd = $this->uri->segment(8); 
            $ag_tox = $this->uri->segment(9); 
			$sql1 = "SELECT nm_skpd FROM ms_skpd WHERE kd_skpd='$skpd'";
			$ivan = $this->db->query($sql1);
			$oioi = $ivan->row();
			$nmskpd = $oioi->nm_skpd;
			$realpend=0;
			$anggpend=0;
			
            /*$sqlanggaran1="select case when statu=1 and status_sempurna=1 and status_ubah=1 and $cbulan>=month(tgl_dpa_ubah) then 2 
					   when statu=1 and status_sempurna=1 and status_ubah=1 and $cbulan>=month(tgl_dpa_sempurna) and $cbulan<month(tgl_dpa_ubah) then 1
					   when statu=1 and status_sempurna=1 and status_ubah=1 and $cbulan<month(tgl_dpa_sempurna) then 1
					   when statu=1 and status_sempurna=1 and status_ubah=0 and $cbulan>=month(tgl_dpa_sempurna) then 1 
					   when statu=1 and status_sempurna=1 and status_ubah=0 and $cbulan<month(tgl_dpa_sempurna) then 1
					   when statu=1 and status_sempurna=0 and status_ubah=0 and $cbulan>=month(tgl_dpa) then 1
					   else 1 end as anggaran from trhrka where kd_skpd='$skpd'";*/
                       
            $sqlanggaran1="select case when statu=1 and status_sempurna=1 and status_ubah=1 then 2 
					   when statu=1 and status_sempurna=1 and status_ubah=0 then 2
					   when statu=1 and status_sempurna=0 and status_ubah=0 then 1
					   else 1 end as anggaran from trhrka where kd_skpd='$skpd'";                       
                       
    $sqlanggaran=$this->db->query($sqlanggaran1);
	foreach ($sqlanggaran->result() as $rowttd)
        {
            $anggaran=$rowttd->anggaran;
        }

	//$ag_tox=$anggaran;
            /*
			$sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab FROM ms_ttd where kd_skpd='$skpd' and kode='PA' and nip='$ttd1'";
            $sqlttd=$this->db->query($sqlttd1);
            foreach ($sqlttd->result() as $rowttd)
			
                {
                    $nip=$rowttd->nip;                    
                    $oioi= $rowttd->nm;
                    $jabatan = $rowttd->jab;
                }			
			
			$sqlttd2="SELECT nama as nm,nip as nip,jabatan as jab FROM ms_ttd where kd_skpd='$skpd' and kode='PPK' and nip='$ttd2'";
            $ttd11=$this->db->query($sqlttd2);
			foreach ($ttd11->result() as $ivan)
			    {
                    $nip1=$ivan->nip;                    
                    $oioi1= $ivan->nm;
                    $jabatan1 = $ivan->jab;
                }
			*/
       $sqlsc="SELECT tgl_rka,provinsi,kab_kota,daerah,thn_ang FROM sclient where kd_skpd='$skpd'";
                 $sqlsclient=$this->db->query($sqlsc);
                 foreach ($sqlsclient->result() as $rowsc)
                {
                   
                    $tgl=$rowsc->tgl_rka;
                    $tanggal = $this->tukd_model->tanggal_format_indonesia($tgl);
                    $kab     = $rowsc->kab_kota;
                    $daerah  = $rowsc->daerah;
                    $thn     = $rowsc->thn_ang;
                } 
           
        $bersih_skpd= str_replace(".", "", $skpd);
        $print_r = explode(".",$skpd);
        $ke1 = $print_r[0];
        $ke2 = $print_r[1];
        $ke3 = $print_r[2];        
        $ke4 = $print_r[3]; 
        $skkd = $ke1."/".$ke2."/".$ke3;   
            
        $cRet='';
        
        $modtahun= $thn%4;
	 
	 if ($modtahun = 0){
        $nilaibulan=".31 JANUARI.29 FEBRUARI.31 MARET.30 APRIL.31 MEI.30 JUNI.31 JULI.31 AGUSTUS.30 SEPTEMBER.31 OKTOBER.30 NOVEMBER.31 DESEMBER";}
            else {
        $nilaibulan=".31 JANUARI.28 FEBRUARI.31 MARET.30 APRIL.31 MEI.30 JUNI.31 JULI.31 AGUSTUS.30 SEPTEMBER.31 OKTOBER.30 NOVEMBER.31 DESEMBER";}
	 
	 $arraybulan=explode(".",$nilaibulan);
        
        $cRet .="<table style=\"font-size:13px; border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
                    <tr>
                         <td align=\"center\"><strong>PEMERINTAH KABUPATEN SANGGAU</strong></td>                         
                    </tr>
					 <tr>
                         <td align=\"center\"><strong>$nmskpd</strong></td>                         
                    </tr>
                    <tr>
                         <td align=\"center\"><strong>LAPORAN REALISASI ANGGARAN</strong></td>
                    </tr>                    
                    <tr>
                         <td align=\"center\"><strong>PER $arraybulan[$cbulan] $thn</strong></td>
                    </tr>
                    <tr>
                         <td align=\"center\">&nbsp;</td>
                    </tr>
                  </table>";        
        
        
        $cRet .= "<table style=\"font-size:12px; border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"4\">
                     <thead>                       
                        <tr>
                            <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>    
                            <td bgcolor=\"#CCCCCC\" width=\"5%\" align=\"center\"><b>NO</b></td>                            
                            <td  bgcolor=\"#CCCCCC\" width=\"37%\" align=\"center\"><b>URAIAN</b></td>
                            <td bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>ANGGARAN</b></td>
                            <td bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>REALISASI</b></td>
                            <td  bgcolor=\"#CCCCCC\" width=\"15%\" align=\"center\" ><b>LEBIH</br>(KURANG)</b></td>
                            <td  bgcolor=\"#CCCCCC\" width=\"5%\" align=\"center\" ><b>%</b></td>   
                        </tr>
                        
                     </thead>
                     <tfoot>
                        <tr>
                            <td style=\"border: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>                           
                         </tr>
                     </tfoot>
						";
					
					$cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>4<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"><b>PENDAPATAN<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";	                   	
               
                $sql4="
                select z.kode,z.nama,z.anggaran,z.reali from (
                SELECT left(a.kd_rek5,2) as kode,b.nm_rek2 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4( $cbulan,$ag_tox) a
                inner join ms_rek2_64 b on b.kd_rek2 = left(a.kd_rek5,2)                
                where left(a.kd_rek5,1)='4' and left(kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_rek5,2),b.nm_rek2
                union all
                SELECT left(a.kd_rek5,3) as kode,b.nm_rek3 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4( $cbulan,$ag_tox) a
                inner join ms_rek3_64 b on b.kd_rek3 = left(a.kd_rek5,3)                
                where left(a.kd_rek5,1)='4' and left(kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_rek5,3),b.nm_rek3
                union all
                SELECT left(a.kd_rek5,5) as kode,b.nm_rek4_64 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4( $cbulan,$ag_tox) a
                inner join ms_rek4_64 b on b.kd_rek4_64 = left(a.kd_rek5,5)                
                where left(a.kd_rek5,1)='4' and left(kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_rek5,5),b.nm_rek4_64
                union all
                 SELECT left(a.kd_rek5,7) as kode,b.nm_rek64 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4( $cbulan,$ag_tox) a
                inner join ms_rek5 b on b.kd_rek5 = left(a.kd_rek5,7)                
                where left(a.kd_rek5,1)='4' and left(kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_rek5,7),b.nm_rek64
                )z order by kode,nama
                ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil    = $row4->reali;
					$angnil = $row4->anggaran;
					
                    $real_s = $angnil - $nil;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil;
                    }

                    $nilai    = number_format($nil,"2",".",",");
                    $angnilai = number_format($angnil,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai=='' or $angnilai==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil/$angnil)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                   if(strlen("$no")<6){
                    $cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                             }else
                             {
					$cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">$no</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\">$nama</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\">$x1$selisih$y1</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\">$persen1</td>
                                 </tr>";
                             }
               }
               		$cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                    $nil4=0;
                    $angnil4=0;
                    $sql4="
                select z.kode,z.nama,z.anggaran,z.reali from (
                SELECT left(a.kd_rek5,1) as kode,b.nm_rek1 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4( $cbulan,$ag_tox) a
                inner join ms_rek1 b on b.kd_rek1 = left(a.kd_rek5,1)                
                where left(a.kd_rek5,1)='4' and left(kd_skpd,7) = left('$skpd',7)
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
					
                    $real_s = $angnil4 - $nil4;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil4==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil4;
                    }

                    $nilai4    = number_format($nil4,"2",".",",");
                    $angnilai4 = number_format($angnil4,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai4=='' or $angnilai4==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil4/$angnil4)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                    
               $cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"><b>JUMLAH $nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai4<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai4<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                   }   
                   
                   $cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                      
                   	$cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>5<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"><b>BELANJA<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";	                   	
               
                   $sql4="
               select z.kode,z.nama,sum(z.anggaran) as anggaran,sum(z.reali) as reali from(
               
  SELECT left(a.kd_rek5,2) as kode,b.nm_rek2 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4($cbulan,$ag_tox) a
                inner join ms_rek2_64 b on b.kd_rek2 = left(a.kd_rek5,2)                        
                where left(a.kd_rek5,1)='5' and left(a.kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_rek5,2),b.nm_rek2                
 union all
 
 SELECT left(a.kd_rek5,2) as kode,b.nm_rek2 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_non4($cbulan,$ag_tox) a
                inner join ms_rek2_64 b on b.kd_rek2 = left(a.kd_rek5,2)                        
                where left(a.kd_rek5,1)='5' and left(a.kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_rek5,2),b.nm_rek2
 union all               
  SELECT left(a.kd_rek5,3) as kode,b.nm_rek3 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4($cbulan,$ag_tox) a
                inner join ms_rek3_64 b on b.kd_rek3 = left(a.kd_rek5,3)                        
                where left(a.kd_rek5,1)='5' and left(a.kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_rek5,3),b.nm_rek3                
 union all               
  SELECT left(a.kd_rek5,3) as kode,b.nm_rek3 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_non4($cbulan,$ag_tox) a
                inner join ms_rek3_64 b on b.kd_rek3 = left(a.kd_rek5,3)                        
                where left(a.kd_rek5,1)='5' and left(a.kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_rek5,3),b.nm_rek3 
 union all
                
  SELECT left(a.kd_rek5,5) as kode,b.nm_rek4_64 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4($cbulan,$ag_tox) a
                inner join ms_rek4_64 b on b.kd_rek4_64 = left(a.kd_rek5,5)                        
                where left(a.kd_rek5,1)='5' and left(a.kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_rek5,5),b.nm_rek4_64   
union all
                
  SELECT left(a.kd_rek5,5) as kode,b.nm_rek4_64 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_non4($cbulan,$ag_tox) a
                inner join ms_rek4_64 b on b.kd_rek4_64 = left(a.kd_rek5,5)                        
                where left(a.kd_rek5,1)='5' and left(a.kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_rek5,5),b.nm_rek4_64                             
 union all
                
  SELECT left(a.kd_rek5,7) as kode,b.nm_rek5 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4($cbulan,$ag_tox) a
                inner join ms_rek5 b on b.kd_rek64 = left(a.kd_rek5,7)                        
                where left(a.kd_rek5,1)='5' and left(a.kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_rek5,7),b.nm_rek5   
union all
                
  SELECT left(a.kd_rek5,7) as kode,b.nm_rek5 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_non4($cbulan,$ag_tox) a
                inner join ms_rek5 b on b.kd_rek64 = left(a.kd_rek5,7)                        
                where left(a.kd_rek5,1)='5' and left(a.kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_rek5,7),b.nm_rek5                
       ) z
                group by kode,nama
                order by kode,nama ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil    = $row4->reali;
					$angnil = $row4->anggaran;
					
                    $real_s = $angnil - $nil;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil;
                    }

                    $nilai    = number_format($nil,"2",".",",");
                    $angnilai = number_format($angnil,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai=='' or $angnilai==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil/$angnil)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                   if(strlen("$no")<6){
                    $cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                             }else
                             {
					$cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">$no</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\">$nama</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\">$x1$selisih$y1</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\">$persen1</td>
                                 </tr>";
                             }
               }  
               
                		$cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>   
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                    
                    $sql4="
                select z.kode,z.nama,sum(z.anggaran) as anggaran,sum(z.reali) as reali from (
                SELECT left(a.kd_rek5,1) as kode,b.nm_rek1 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4( $cbulan,$ag_tox) a
                inner join ms_rek1 b on b.kd_rek1 = left(a.kd_rek5,1)                
                where left(a.kd_rek5,1)='5' and left(kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_rek5,1),b.nm_rek1 
                union all
                SELECT left(a.kd_rek5,1) as kode,b.nm_rek1 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_non4( $cbulan,$ag_tox) a
                inner join ms_rek1 b on b.kd_rek1 = left(a.kd_rek5,1)                
                where left(a.kd_rek5,1)='5' and left(kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_rek5,1),b.nm_rek1
                )z group by kode,nama order by kode,nama
                ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil5    = $row4->reali;
					$angnil5 = $row4->anggaran;
					
                    $real_s = $angnil5 - $nil5;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil5==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil5;
                    }

                    $nilai5    = number_format($nil5,"2",".",",");
                    $angnilai5 = number_format($angnil5,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai5=='' or $angnilai5==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil5/$angnil5)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                
               	$cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                     
                    
               $cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"><b>JUMLAH $nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai5<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai5<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                   }   
                 
                  	$cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                 
                 $no 	= '';
					$nama   = 'SURPLUS/DEFISIT';                      
					$nil    = $nil4 - $nil5;
					$angnil = $angnil4 - $angnil5;
					
                    $real_s = $angnil - $nil;

                    if ($angnil < 0){
                    	$a1="("; $angnil=$angnil*-1; $a2=")";}
                    else {
                    	$a1=""; $a2="";}

                    if ($nil < 0){
                    	$b1="("; $nil=$nil*-1; $b2=")";}
                    else {
                    	$b1=""; $b2="";}

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil;
                    }

                    $nilai    = number_format($nil,"2",".",",");
                    $angnilai = number_format($angnil,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai=='' or $angnilai==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil/$angnil)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                   
                   $cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$a1$angnilai$a2<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$b1$nilai$b2<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";         
              
        $cRet .=       " </table>";
        $data['prev']= $cRet;
		 $cRet         .= "</table>";
		 /*
		 if($txt==1){
		 $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> Mengetahui,</td>
		 <td align=\"center\" width=\"50%\"> Sanggau, $ctgl_ttd </td>
		 </tr>		
		 <tr>
		 <td align=\"center\" width=\"50%\"> $jabatan </td>
		 <td align=\"center\" width=\"50%\"> $jabatan1 </td>
		 </tr>	
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		  <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> $oioi</td>
		 <td align=\"center\" width=\"50%\"> $oioi1</td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> NIP :$nip</td>
		 <td align=\"center\" width=\"50%\"> NIP :$nip1</td>
		 </tr>
         </table>
		 ";}*/
		$data['prev'] = $cRet;
        $data['sikap'] = 'preview';
        $judul  = 'LAPORAN REALISASI ANGGARAN';
        $this->template->set('title', 'CETAK LAPORAN REALISASI ANGGARAN');        
        switch($cetak) {
		case 1;
			 echo ("<title>L R A</title>"); 
             echo $cRet;
        break;		
        case 0;
             $this->_mpdf_down('',$cRet,10,10,10,'0',0,'','LRA Akun Rincian'.$skpd.'');
        break;
        case 2;        
            header("Cache-Control: no-cache, no-store, must-revalidate");
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename= $judul.xls");
            
            $this->load->view('anggaran/rka/perkadaII', $data);
        break;
        case 3;     
            header("Cache-Control: no-cache, no-store, must-revalidate");
            header("Content-Type: application/vnd.ms-word");
            header("Content-Disposition: attachment; filename= $judul.doc");
            $this->load->view('anggaran/rka/perkadaII', $data);
        break;
        } 
    }
    
   function cetak_lra_bulan_rincian_skpd($cbulan='', $cetak='', $txt='', $ctgl_ttd=''){
	        $txt="1";
			$tanggalttd = $this->uri->segment(5);
            $ttd1 = str_replace('a',' ',$this->uri->segment(6));
            $ttd2 = str_replace('a',' ',$this->uri->segment(7));
            $ctgl_ttd = $this->tukd_model->tanggal_format_indonesia($tanggalttd);
            $bulan = strtoupper($this->tukd_model->getBulan($cbulan));
			$skpd = $this->session->userdata('kdskpd'); 
			$sql1 = "SELECT nm_skpd FROM ms_skpd WHERE kd_skpd='$skpd'";
			$ivan = $this->db->query($sql1);
			$oioi = $ivan->row();
			$nmskpd = $oioi->nm_skpd;
			$realpend=0;
			$anggpend=0;
			
            /*$sqlanggaran1="select case when statu=1 and status_sempurna=1 and status_ubah=1 and $cbulan>=month(tgl_dpa_ubah) then 2 
					   when statu=1 and status_sempurna=1 and status_ubah=1 and $cbulan>=month(tgl_dpa_sempurna) and $cbulan<month(tgl_dpa_ubah) then 1
					   when statu=1 and status_sempurna=1 and status_ubah=1 and $cbulan<month(tgl_dpa_sempurna) then 1
					   when statu=1 and status_sempurna=1 and status_ubah=0 and $cbulan>=month(tgl_dpa_sempurna) then 1 
					   when statu=1 and status_sempurna=1 and status_ubah=0 and $cbulan<month(tgl_dpa_sempurna) then 1
					   when statu=1 and status_sempurna=0 and status_ubah=0 and $cbulan>=month(tgl_dpa) then 1
					   else 1 end as anggaran from trhrka where kd_skpd='$skpd'";*/
            
            $sqlanggaran1="select case when statu=1 and status_sempurna=1 and status_ubah=1 then 2 
					   when statu=1 and status_sempurna=1 and status_ubah=0 then 2
					   when statu=1 and status_sempurna=0 and status_ubah=0 then 1
					   else 1 end as anggaran from trhrka where kd_skpd='$skpd'";                       
                       
    $sqlanggaran=$this->db->query($sqlanggaran1);
	foreach ($sqlanggaran->result() as $rowttd)
        {
            $anggaran=$rowttd->anggaran;
        }

	$ag_tox=$anggaran;
            
			$sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab FROM ms_ttd where kd_skpd='$skpd' and kode='PA' and nip='$ttd1'";
            $sqlttd=$this->db->query($sqlttd1);
            foreach ($sqlttd->result() as $rowttd)
			
                {
                    $nip=$rowttd->nip;                    
                    $oioi= $rowttd->nm;
                    $jabatan = $rowttd->jab;
                }			
			
			$sqlttd2="SELECT nama as nm,nip as nip,jabatan as jab FROM ms_ttd where kd_skpd='$skpd' and kode='PPK' and nip='$ttd2'";
            $ttd11=$this->db->query($sqlttd2);
			foreach ($ttd11->result() as $ivan)
			    {
                    $nip1=$ivan->nip;                    
                    $oioi1= $ivan->nm;
                    $jabatan1 = $ivan->jab;
                }
			
       $sqlsc="SELECT tgl_rka,provinsi,kab_kota,daerah,thn_ang FROM sclient where kd_skpd='$skpd'";
                 $sqlsclient=$this->db->query($sqlsc);
                 foreach ($sqlsclient->result() as $rowsc)
                {
                   
                    $tgl=$rowsc->tgl_rka;
                    $tanggal = $this->tukd_model->tanggal_format_indonesia($tgl);
                    $kab     = $rowsc->kab_kota;
                    $daerah  = $rowsc->daerah;
                    $thn     = $rowsc->thn_ang;
                } 
           
        $bersih_skpd= str_replace(".", "", $skpd);
        $print_r = explode(".",$skpd);
        $ke1 = $print_r[0];
        $ke2 = $print_r[1];
        $ke3 = $print_r[2];        
        $ke4 = $print_r[3]; 
        $skkd = $ke1."/".$ke2."/".$ke3;   
            
        $cRet='';
        
        $modtahun= $thn%4;
	 
	 if ($modtahun = 0){
        $nilaibulan=".31 JANUARI.29 FEBRUARI.31 MARET.30 APRIL.31 MEI.30 JUNI.31 JULI.31 AGUSTUS.30 SEPTEMBER.31 OKTOBER.30 NOVEMBER.31 DESEMBER";}
            else {
        $nilaibulan=".31 JANUARI.28 FEBRUARI.31 MARET.30 APRIL.31 MEI.30 JUNI.31 JULI.31 AGUSTUS.30 SEPTEMBER.31 OKTOBER.30 NOVEMBER.31 DESEMBER";}
	 
	 $arraybulan=explode(".",$nilaibulan);
       
        $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
                    <tr>
                         <td align=\"center\"><strong>PEMERINTAH KABUPATEN SANGGAU</strong></td>                         
                    </tr>
					 <tr>
                         <td align=\"center\"><strong>$nmskpd</strong></td>                         
                    </tr>
                    <tr>
                         <td align=\"center\"><strong>LAPORAN REALISASI ANGGARAN</strong></td>
                    </tr>                    
                    <tr>
                         <td align=\"center\"><strong>PER $arraybulan[$cbulan] $thn</strong></td>
                    </tr>
                    <tr>
                         <td align=\"center\">&nbsp;</td>
                    </tr>
                  </table>";        
        
        
        $cRet .= "<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"4\">
                     <thead>                       
                        <tr><td bgcolor=\"#CCCCCC\" width=\"5%\" align=\"center\"><b>NO</b></td>                            
                            <td  bgcolor=\"#CCCCCC\" width=\"45%\" align=\"center\"><b>URAIAN</b></td>
                            <td bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>ANGGARAN</b></td>
                            <td bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>REALISASI</b></td>
                            <td  bgcolor=\"#CCCCCC\" width=\"15%\" align=\"center\" ><b>LEBIH</br>(KURANG)</b></td>
                            <td  bgcolor=\"#CCCCCC\" width=\"5%\" align=\"center\" ><b>%</b></td>   
                        </tr>
                        
                     </thead>
                     <tfoot>
                        <tr>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>                           
                         </tr>
                     </tfoot>
						";
					
					$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>4<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>PENDAPATAN<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";	                   	
               
                $sql4="
                select z.kode,z.nama,z.anggaran,z.reali from (
                SELECT left(a.kd_rek5,2) as kode,b.nm_rek2 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek2_64 b on b.kd_rek2 = left(a.kd_rek5,2)                
                where left(a.kd_rek5,1)='4' and kd_skpd = '$skpd'
                group by left(a.kd_rek5,2),b.nm_rek2
                union all
                SELECT left(a.kd_rek5,3) as kode,b.nm_rek3 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek3_64 b on b.kd_rek3 = left(a.kd_rek5,3)                
                where left(a.kd_rek5,1)='4' and kd_skpd = '$skpd'
                group by left(a.kd_rek5,3),b.nm_rek3
                union all
                SELECT left(a.kd_rek5,5) as kode,b.nm_rek4_64 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek4_64 b on b.kd_rek4_64 = left(a.kd_rek5,5)                
                where left(a.kd_rek5,1)='4' and kd_skpd = '$skpd'
                group by left(a.kd_rek5,5),b.nm_rek4_64
                union all
                 SELECT left(a.kd_rek5,7) as kode,b.nm_rek64 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek5 b on b.kd_rek5 = left(a.kd_rek5,7)                
                where left(a.kd_rek5,1)='4' and kd_skpd = '$skpd'
                group by left(a.kd_rek5,7),b.nm_rek64
                )z order by kode,nama
                ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil    = $row4->reali;
					$angnil = $row4->anggaran;
					
                    $real_s = $angnil - $nil;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil;
                    }

                    $nilai    = number_format($nil,"2",".",",");
                    $angnilai = number_format($angnil,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai=='' or $angnilai==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil/$angnil)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                   if(strlen("$no")<6){
                    $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                             }else
                             {
					$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">$no</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\">$nama</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\">$x1$selisih$y1</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\">$persen1</td>
                                 </tr>";
                             }
               }
               		$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                    $nil4=0;
                    $angnil4=0;
                    $sql4="
                select z.kode,z.nama,z.anggaran,z.reali from (
                SELECT left(a.kd_rek5,1) as kode,b.nm_rek1 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek1 b on b.kd_rek1 = left(a.kd_rek5,1)                
                where left(a.kd_rek5,1)='4' and kd_skpd = '$skpd'
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
					
                    $real_s = $angnil4 - $nil4;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil4==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil4;
                    }

                    $nilai4    = number_format($nil4,"2",".",",");
                    $angnilai4 = number_format($angnil4,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai4=='' or $angnilai4==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil4/$angnil4)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                    
               $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>JUMLAH $nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai4<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai4<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                   }   
                   
                   $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                      
                   	$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>5<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>BELANJA<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";	                   	
               
                   $sql4="
               select z.kode,z.nama,sum(z.anggaran) as anggaran,sum(z.reali) as reali from(
               
  SELECT left(a.kd_rek5,2) as kode,b.nm_rek2 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd($cbulan,$ag_tox) a
                inner join ms_rek2_64 b on b.kd_rek2 = left(a.kd_rek5,2)                        
                where left(a.kd_rek5,1)='5' and kd_skpd = '$skpd'
                group by left(a.kd_rek5,2),b.nm_rek2                
 union all
 
 SELECT left(a.kd_rek5,2) as kode,b.nm_rek2 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_non4_skpd($cbulan,$ag_tox) a
                inner join ms_rek2_64 b on b.kd_rek2 = left(a.kd_rek5,2)                        
                where left(a.kd_rek5,1)='5' and kd_skpd = '$skpd'
                group by left(a.kd_rek5,2),b.nm_rek2
 union all               
  SELECT left(a.kd_rek5,3) as kode,b.nm_rek3 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd($cbulan,$ag_tox) a
                inner join ms_rek3_64 b on b.kd_rek3 = left(a.kd_rek5,3)                        
                where left(a.kd_rek5,1)='5' and kd_skpd = '$skpd'
                group by left(a.kd_rek5,3),b.nm_rek3                
 union all               
  SELECT left(a.kd_rek5,3) as kode,b.nm_rek3 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_non4_skpd($cbulan,$ag_tox) a
                inner join ms_rek3_64 b on b.kd_rek3 = left(a.kd_rek5,3)                        
                where left(a.kd_rek5,1)='5' and kd_skpd = '$skpd'
                group by left(a.kd_rek5,3),b.nm_rek3 
 union all
                
  SELECT left(a.kd_rek5,5) as kode,b.nm_rek4_64 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd($cbulan,$ag_tox) a
                inner join ms_rek4_64 b on b.kd_rek4_64 = left(a.kd_rek5,5)                        
                where left(a.kd_rek5,1)='5' and kd_skpd = '$skpd'
                group by left(a.kd_rek5,5),b.nm_rek4_64   
union all
                
  SELECT left(a.kd_rek5,5) as kode,b.nm_rek4_64 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_non4_skpd($cbulan,$ag_tox) a
                inner join ms_rek4_64 b on b.kd_rek4_64 = left(a.kd_rek5,5)                        
                where left(a.kd_rek5,1)='5' and kd_skpd = '$skpd'
                group by left(a.kd_rek5,5),b.nm_rek4_64                             
 union all
                
  SELECT left(a.kd_rek5,7) as kode,b.nm_rek5 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd($cbulan,$ag_tox) a
                inner join ms_rek5 b on b.kd_rek64 = left(a.kd_rek5,7)                        
                where left(a.kd_rek5,1)='5' and kd_skpd = '$skpd'
                group by left(a.kd_rek5,7),b.nm_rek5   
union all
                
  SELECT left(a.kd_rek5,7) as kode,b.nm_rek5 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_non4_skpd($cbulan,$ag_tox) a
                inner join ms_rek5 b on b.kd_rek64 = left(a.kd_rek5,7)                        
                where left(a.kd_rek5,1)='5' and kd_skpd = '$skpd'
                group by left(a.kd_rek5,7),b.nm_rek5                
       ) z
                group by kode,nama
                order by kode,nama ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil    = $row4->reali;
					$angnil = $row4->anggaran;
					
                    $real_s = $angnil - $nil;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil;
                    }

                    $nilai    = number_format($nil,"2",".",",");
                    $angnilai = number_format($angnil,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai=='' or $angnilai==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil/$angnil)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                   if(strlen("$no")<6){
                    $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                             }else
                             {
					$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">$no</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\">$nama</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\">$x1$selisih$y1</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\">$persen1</td>
                                 </tr>";
                             }
               }  
               
                		$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                    
                    $sql4="
                select z.kode,z.nama,sum(z.anggaran) as anggaran,sum(z.reali) as reali from (
                SELECT left(a.kd_rek5,1) as kode,b.nm_rek1 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek1 b on b.kd_rek1 = left(a.kd_rek5,1)                
                where left(a.kd_rek5,1)='5' and kd_skpd = '$skpd'
                group by left(a.kd_rek5,1),b.nm_rek1 
                union all
                SELECT left(a.kd_rek5,1) as kode,b.nm_rek1 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_non4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek1 b on b.kd_rek1 = left(a.kd_rek5,1)                
                where left(a.kd_rek5,1)='5' and kd_skpd = '$skpd'
                group by left(a.kd_rek5,1),b.nm_rek1
                )z group by kode,nama order by kode,nama
                ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil5    = $row4->reali;
					$angnil5 = $row4->anggaran;
					
                    $real_s = $angnil5 - $nil5;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil5==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil5;
                    }

                    $nilai5    = number_format($nil5,"2",".",",");
                    $angnilai5 = number_format($angnil5,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai5=='' or $angnilai5==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil5/$angnil5)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                
               	$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                     
                    
               $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>JUMLAH $nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai5<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai5<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                   }   
                 
                  	$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                 
                 $no 	= '';
					$nama   = 'SURPLUS/DEFISIT';                      
					$nil    = $nil4 - $nil5;
					$angnil = $angnil4 - $angnil5;
					
                    $real_s = $angnil - $nil;

                    if ($angnil < 0){
                    	$a1="("; $angnil=$angnil*-1; $a2=")";}
                    else {
                    	$a1=""; $a2="";}

                    if ($nil < 0){
                    	$b1="("; $nil=$nil*-1; $b2=")";}
                    else {
                    	$b1=""; $b2="";}

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil;
                    }

                    $nilai    = number_format($nil,"2",".",",");
                    $angnilai = number_format($angnil,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai=='' or $angnilai==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil/$angnil)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                   
                   $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$a1$angnilai$a2<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$b1$nilai$b2<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";         
              
        $cRet .=       " </table>";
        $data['prev']= $cRet;
		 $cRet         .= "</table>";
		 
		 if($txt==1){
		 $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> Mengetahui,</td>
		 <td align=\"center\" width=\"50%\"> Sanggau, $ctgl_ttd </td>
		 </tr>		
		 <tr>
		 <td align=\"center\" width=\"50%\"> $jabatan </td>
		 <td align=\"center\" width=\"50%\"> $jabatan1 </td>
		 </tr>	
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		  <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> $oioi</td>
		 <td align=\"center\" width=\"50%\"> $oioi1</td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> NIP :$nip</td>
		 <td align=\"center\" width=\"50%\"> NIP :$nip1</td>
		 </tr>
         </table>
		 ";}
		$data['prev'] = $cRet;
        $data['sikap'] = 'preview';
        $judul  = 'LAPORAN REALISASI ANGGARAN';
        $this->template->set('title', 'CETAK LAPORAN REALISASI ANGGARAN');        
        switch($cetak) {
		case 1;
			 echo ("<title>L R A</title>"); 
             echo $cRet;
        break;		
        case 0;
             $this->tukd_model->_mpdf('',$cRet,10,10,10,'P');
        break;
        case 2;        
            header("Cache-Control: no-cache, no-store, must-revalidate");
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename= $judul.xls");
            
            $this->load->view('anggaran/rka/perkadaII', $data);
        break;
        case 3;     
            header("Cache-Control: no-cache, no-store, must-revalidate");
            header("Content-Type: application/vnd.ms-word");
            header("Content-Disposition: attachment; filename= $judul.doc");
            $this->load->view('anggaran/rka/perkadaII', $data);
        break;
        } 
    }

function cetak_lra_bulan_rincian_ang($cbulan='', $cetak='', $txt=''){
	        $txt="1";
			//$tanggalttd = $this->uri->segment(5);
            //$ttd1 = str_replace('a',' ',$this->uri->segment(6));
            //$ttd2 = str_replace('a',' ',$this->uri->segment(7));
            //$ctgl_ttd = $this->tukd_model->tanggal_format_indonesia($tanggalttd);
            $bulan = strtoupper($this->tukd_model->getBulan($cbulan));
			$skpd = $this->uri->segment(8); 
            $ag_tox = $this->uri->segment(9); 
			$sql1 = "SELECT nm_skpd FROM ms_skpd WHERE kd_skpd='$skpd'";
			$ivan = $this->db->query($sql1);
			$oioi = $ivan->row();
			$nmskpd = $oioi->nm_skpd;
			$realpend=0;
			$anggpend=0;
			
            /*$sqlanggaran1="select case when statu=1 and status_sempurna=1 and status_ubah=1 and $cbulan>=month(tgl_dpa_ubah) then 2 
					   when statu=1 and status_sempurna=1 and status_ubah=1 and $cbulan>=month(tgl_dpa_sempurna) and $cbulan<month(tgl_dpa_ubah) then 1
					   when statu=1 and status_sempurna=1 and status_ubah=1 and $cbulan<month(tgl_dpa_sempurna) then 1
					   when statu=1 and status_sempurna=1 and status_ubah=0 and $cbulan>=month(tgl_dpa_sempurna) then 1 
					   when statu=1 and status_sempurna=1 and status_ubah=0 and $cbulan<month(tgl_dpa_sempurna) then 1
					   when statu=1 and status_sempurna=0 and status_ubah=0 and $cbulan>=month(tgl_dpa) then 1
					   else 1 end as anggaran from trhrka where kd_skpd='$skpd'";*/
             
             $sqlanggaran1="select case when statu=1 and status_sempurna=1 and status_ubah=1 then 2 
					   when statu=1 and status_sempurna=1 and status_ubah=0 then 2
					   when statu=1 and status_sempurna=0 and status_ubah=0 then 1
					   else 1 end as anggaran from trhrka where kd_skpd='$skpd'";                       
                       
    $sqlanggaran=$this->db->query($sqlanggaran1);
	foreach ($sqlanggaran->result() as $rowttd)
        {
            $anggaran=$rowttd->anggaran;
        }

	//$ag_tox=$anggaran;
            /*
			$sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab FROM ms_ttd where kd_skpd='$skpd' and kode='PA' and nip='$ttd1'";
            $sqlttd=$this->db->query($sqlttd1);
            foreach ($sqlttd->result() as $rowttd)
			
                {
                    $nip=$rowttd->nip;                    
                    $oioi= $rowttd->nm;
                    $jabatan = $rowttd->jab;
                }			
			
			$sqlttd2="SELECT nama as nm,nip as nip,jabatan as jab FROM ms_ttd where kd_skpd='$skpd' and kode='PPK' and nip='$ttd2'";
            $ttd11=$this->db->query($sqlttd2);
			foreach ($ttd11->result() as $ivan)
			    {
                    $nip1=$ivan->nip;                    
                    $oioi1= $ivan->nm;
                    $jabatan1 = $ivan->jab;
                }
		  */	
       $sqlsc="SELECT tgl_rka,provinsi,kab_kota,daerah,thn_ang FROM sclient where kd_skpd='$skpd'";
                 $sqlsclient=$this->db->query($sqlsc);
                 foreach ($sqlsclient->result() as $rowsc)
                {
                   
                    $tgl=$rowsc->tgl_rka;
                    $tanggal = $this->tukd_model->tanggal_format_indonesia($tgl);
                    $kab     = $rowsc->kab_kota;
                    $daerah  = $rowsc->daerah;
                    $thn     = $rowsc->thn_ang;
                } 
           
        $bersih_skpd= str_replace(".", "", $skpd);
        $print_r = explode(".",$skpd);
        $ke1 = $print_r[0];
        $ke2 = $print_r[1];
        $ke3 = $print_r[2];        
        $ke4 = $print_r[3]; 
        $skkd = $ke1."/".$ke2."/".$ke3;   
            
        $cRet='';
        
        $modtahun= $thn%4;
	 
	 if ($modtahun = 0){
        $nilaibulan=".31 JANUARI.29 FEBRUARI.31 MARET.30 APRIL.31 MEI.30 JUNI.31 JULI.31 AGUSTUS.30 SEPTEMBER.31 OKTOBER.30 NOVEMBER.31 DESEMBER";}
            else {
        $nilaibulan=".31 JANUARI.28 FEBRUARI.31 MARET.30 APRIL.31 MEI.30 JUNI.31 JULI.31 AGUSTUS.30 SEPTEMBER.31 OKTOBER.30 NOVEMBER.31 DESEMBER";}
	 
	 $arraybulan=explode(".",$nilaibulan);
        
        $cRet .="<table style=\"font-size:13px; border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
                    <tr>
                         <td align=\"center\"><strong>PEMERINTAH KABUPATEN SANGGAU</strong></td>                         
                    </tr>
					 <tr>
                         <td align=\"center\"><strong>$nmskpd</strong></td>                         
                    </tr>
                    <tr>
                         <td align=\"center\"><strong>LAPORAN REALISASI ANGGARAN</strong></td>
                    </tr>                    
                    <tr>
                         <td align=\"center\"><strong>PER $arraybulan[$cbulan] $thn</strong></td>
                    </tr>
                    <tr>
                         <td align=\"center\">&nbsp;</td>
                    </tr>
                  </table>";        
        
        
        $cRet .= "<table style=\"font-size:12px; border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"4\">
                     <thead>                       
                        <tr>
                            <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>    
                            <td bgcolor=\"#CCCCCC\" width=\"5%\" align=\"center\"><b>NO</b></td>                            
                            <td  bgcolor=\"#CCCCCC\" width=\"37%\" align=\"center\"><b>URAIAN</b></td>
                            <td bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>ANGGARAN</b></td>
                            <td bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>REALISASI</b></td>
                            <td  bgcolor=\"#CCCCCC\" width=\"15%\" align=\"center\" ><b>LEBIH</br>(KURANG)</b></td>
                            <td  bgcolor=\"#CCCCCC\" width=\"5%\" align=\"center\" ><b>%</b></td>   
                        </tr>
                        
                     </thead>
                     <tfoot>
                        <tr>
                            <td style=\"border: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>                           
                         </tr>
                     </tfoot>
						";
					
					$cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>4<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"><b>PENDAPATAN<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";	                   	
               
                $sql4="
                select z.kode,z.nama,z.anggaran,z.reali from (
                SELECT left(a.kd_ang,2) as kode,b.nm_rek2 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4( $cbulan,$ag_tox) a
                inner join ms_rek2 b on b.kd_rek2 = left(a.kd_ang,2)                
                where left(a.kd_ang,1)='4' and left(kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_ang,2),b.nm_rek2
                union all
                SELECT left(a.kd_ang,3) as kode,b.nm_rek3 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4( $cbulan,$ag_tox) a
                inner join ms_rek3 b on b.kd_rek3 = left(a.kd_ang,3)                
                where left(a.kd_ang,1)='4' and left(kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_ang,3),b.nm_rek3
                union all
                SELECT left(a.kd_ang,5) as kode,b.nm_rek4 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4( $cbulan,$ag_tox) a
                inner join ms_rek4 b on b.kd_rek4 = left(a.kd_ang,5)                
                where left(a.kd_ang,1)='4' and left(kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_ang,5),b.nm_rek4
                union all
                 SELECT left(a.kd_ang,7) as kode,b.nm_rek64 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4( $cbulan,$ag_tox) a
                inner join ms_rek5 b on b.kd_rek5 = left(a.kd_ang,7)                
                where left(a.kd_ang,1)='4' and left(kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_ang,7),b.nm_rek64
                )z order by kode,nama
                ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil    = $row4->reali;
					$angnil = $row4->anggaran;
					
                    $real_s = $angnil - $nil;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil;
                    }

                    $nilai    = number_format($nil,"2",".",",");
                    $angnilai = number_format($angnil,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai=='' or $angnilai==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil/$angnil)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                   if(strlen("$no")<6){
                    $cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                             }else
                             {
					$cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">$no</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\">$nama</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\">$x1$selisih$y1</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\">$persen1</td>
                                 </tr>";
                             }
               }
               		$cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>   
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                    $nil4=0;
                    $angnil4=0;
                    $sql4="
                select z.kode,z.nama,z.anggaran,z.reali from (
                SELECT left(a.kd_rek5,1) as kode,b.nm_rek1 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4( $cbulan,$ag_tox) a
                inner join ms_rek1 b on b.kd_rek1 = left(a.kd_rek5,1)                
                where left(a.kd_rek5,1)='4' and left(kd_skpd,7) = left('$skpd',7)
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
					
                    $real_s = $angnil4 - $nil4;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil4==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil4;
                    }

                    $nilai4    = number_format($nil4,"2",".",",");
                    $angnilai4 = number_format($angnil4,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai4=='' or $angnilai4==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil4/$angnil4)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                    
               $cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"><b>JUMLAH $nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai4<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai4<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                   }   
                   
                   $cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                      
                   	$cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>5<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"><b>BELANJA<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";	                   	
               
                   $sql4="
               select z.kode,z.nama,sum(z.anggaran) as anggaran,sum(z.reali) as reali from(
               
  SELECT left(a.kd_ang,2) as kode,b.nm_rek2 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4( $cbulan,$ag_tox) a
                inner join ms_rek2 b on b.kd_rek2 = left(a.kd_ang,2)                        
                where left(a.kd_ang,1)='5' and left(a.kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_ang,2),b.nm_rek2                
 union all
               
  SELECT left(a.kd_ang,3) as kode,b.nm_rek3 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4( $cbulan,$ag_tox) a
                inner join ms_rek3 b on b.kd_rek3 = left(a.kd_ang,3)                        
                where left(a.kd_ang,1)='5' and left(a.kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_ang,3),b.nm_rek3                
 union all
                
  SELECT left(a.kd_ang,5) as kode,b.nm_rek4 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4( $cbulan,$ag_tox) a
                inner join ms_rek4 b on b.kd_rek4 = left(a.kd_ang,5)                        
                where left(a.kd_ang,1)='5' and left(a.kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_ang,5),b.nm_rek4               
 union all
 
                
  SELECT left(a.kd_ang,7) as kode,b.nm_rek5 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4( $cbulan,$ag_tox) a
                inner join ms_rek5 b on b.kd_rek5 = left(a.kd_ang,7)                        
                where left(a.kd_ang,1)='5' and left(a.kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_ang,7),b.nm_rek5   
                ) z
                group by kode,nama
                order by kode,nama ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil    = $row4->reali;
					$angnil = $row4->anggaran;
					
                    $real_s = $angnil - $nil;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil;
                    }

                    $nilai    = number_format($nil,"2",".",",");
                    $angnilai = number_format($angnil,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai=='' or $angnilai==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil/$angnil)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                   if(strlen("$no")<6){
                    $cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                             }else
                             {
					$cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">$no</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\">$nama</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\">$x1$selisih$y1</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\">$persen1</td>
                                 </tr>";
                             }
               }  
               
                		$cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                    
                    $sql4="
                select z.kode,z.nama,sum(z.anggaran) as anggaran,sum(z.reali) as reali from (
                SELECT left(a.kd_ang,1) as kode,b.nm_rek1 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4( $cbulan,$ag_tox) a
                inner join ms_rek1 b on b.kd_rek1 = left(a.kd_ang,1)                
                where left(a.kd_ang,1)='5' and left(kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_ang,1),b.nm_rek1 
                )z group by kode,nama order by kode,nama
                ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil5    = $row4->reali;
					$angnil5 = $row4->anggaran;
					
                    $real_s = $angnil5 - $nil5;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil5==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil5;
                    }

                    $nilai5    = number_format($nil5,"2",".",",");
                    $angnilai5 = number_format($angnil5,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai5=='' or $angnilai5==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil5/$angnil5)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                
               	$cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                     
                    
               $cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>   
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"><b>JUMLAH $nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai5<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai5<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                   }   
                 
                  	$cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                 
                 $no 	= '';
					$nama   = 'SURPLUS/DEFISIT';                      
					$nil    = $nil4 - $nil5;
					$angnil = $angnil4 - $angnil5;
					
                    $real_s = $angnil - $nil;

                    if ($angnil < 0){
                    	$a1="("; $angnil=$angnil*-1; $a2=")";}
                    else {
                    	$a1=""; $a2="";}

                    if ($nil < 0){
                    	$b1="("; $nil=$nil*-1; $b2=")";}
                    else {
                    	$b1=""; $b2="";}

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil;
                    }

                    $nilai    = number_format($nil,"2",".",",");
                    $angnilai = number_format($angnil,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai=='' or $angnilai==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil/$angnil)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                   
                   $cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$a1$angnilai$a2<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$b1$nilai$b2<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";         
              
        $cRet .=       " </table>";
        $data['prev']= $cRet;
		 $cRet         .= "</table>";
		 /*
		 if($txt==1){
		 $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> Mengetahui</td>
		 <td align=\"center\" width=\"50%\"> Sanggau, $ctgl_ttd </td>
		 </tr>		
		 <tr>
		 <td align=\"center\" width=\"50%\"> $jabatan </td>
		 <td align=\"center\" width=\"50%\"> $jabatan1 </td>
		 </tr>	
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		  <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> $oioi</td>
		 <td align=\"center\" width=\"50%\"> $oioi1</td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> NIP :$nip</td>
		 <td align=\"center\" width=\"50%\"> NIP :$nip1 </td>
		 </tr>
         </table>
		 ";}*/
		$data['prev'] = $cRet;
        $data['sikap'] = 'preview';
        $judul  = 'LAPORAN REALISASI ANGGARAN';
        $this->template->set('title', 'CETAK LAPORAN REALISASI ANGGARAN');        
        switch($cetak) {
		case 1;
			 echo ("<title>L R A</title>"); 
             echo $cRet;
        break;		
        case 0;
             $this->_mpdf_down('',$cRet,10,10,10,'0',0,'','LRA Akun Rincian format13 '.$skpd.'');
        break;
        case 2;        
            header("Cache-Control: no-cache, no-store, must-revalidate");
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename= $judul.xls");
            
            $this->load->view('anggaran/rka/perkadaII', $data);
        break;
        case 3;     
            header("Cache-Control: no-cache, no-store, must-revalidate");
            header("Content-Type: application/vnd.ms-word");
            header("Content-Disposition: attachment; filename= $judul.doc");
            $this->load->view('anggaran/rka/perkadaII', $data);
        break;
        } 
    }

function cetak_lra_bulan_rincian_ang_skpd($cbulan='', $cetak='', $txt=''){
	        $txt="1";
			$tanggalttd = $this->uri->segment(5);
            $ttd1 = str_replace('a',' ',$this->uri->segment(6));
            $ttd2 = str_replace('a',' ',$this->uri->segment(7));
            $ctgl_ttd = $this->tukd_model->tanggal_format_indonesia($tanggalttd);
            $bulan = strtoupper($this->tukd_model->getBulan($cbulan));
			$skpd = $this->session->userdata('kdskpd'); 
			$sql1 = "SELECT nm_skpd FROM ms_skpd WHERE kd_skpd='$skpd'";
			$ivan = $this->db->query($sql1);
			$oioi = $ivan->row();
			$nmskpd = $oioi->nm_skpd;
			$realpend=0;
			$anggpend=0;
			
            /*$sqlanggaran1="select case when statu=1 and status_sempurna=1 and status_ubah=1 and $cbulan>=month(tgl_dpa_ubah) then 2 
					   when statu=1 and status_sempurna=1 and status_ubah=1 and $cbulan>=month(tgl_dpa_sempurna) and $cbulan<month(tgl_dpa_ubah) then 1
					   when statu=1 and status_sempurna=1 and status_ubah=1 and $cbulan<month(tgl_dpa_sempurna) then 1
					   when statu=1 and status_sempurna=1 and status_ubah=0 and $cbulan>=month(tgl_dpa_sempurna) then 1 
					   when statu=1 and status_sempurna=1 and status_ubah=0 and $cbulan<month(tgl_dpa_sempurna) then 1
					   when statu=1 and status_sempurna=0 and status_ubah=0 and $cbulan>=month(tgl_dpa) then 1
					   else 1 end as anggaran from trhrka where kd_skpd='$skpd'";*/
                       
            $sqlanggaran1="select case when statu=1 and status_sempurna=1 and status_ubah=1 then 2 
					   when statu=1 and status_sempurna=1 and status_ubah=0 then 2
					   when statu=1 and status_sempurna=0 and status_ubah=0 then 1
					   else 1 end as anggaran from trhrka where kd_skpd='$skpd'";                       
                       
    $sqlanggaran=$this->db->query($sqlanggaran1);
	foreach ($sqlanggaran->result() as $rowttd)
        {
            $anggaran=$rowttd->anggaran;
        }

	$ag_tox=$anggaran;
            
			$sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab FROM ms_ttd where kd_skpd='$skpd' and kode='PA' and nip='$ttd1'";
            $sqlttd=$this->db->query($sqlttd1);
            foreach ($sqlttd->result() as $rowttd)
			
                {
                    $nip=$rowttd->nip;                    
                    $oioi= $rowttd->nm;
                    $jabatan = $rowttd->jab;
                }			
			
			$sqlttd2="SELECT nama as nm,nip as nip,jabatan as jab FROM ms_ttd where kd_skpd='$skpd' and kode='PPK' and nip='$ttd2'";
            $ttd11=$this->db->query($sqlttd2);
			foreach ($ttd11->result() as $ivan)
			    {
                    $nip1=$ivan->nip;                    
                    $oioi1= $ivan->nm;
                    $jabatan1 = $ivan->jab;
                }
			
       $sqlsc="SELECT tgl_rka,provinsi,kab_kota,daerah,thn_ang FROM sclient where kd_skpd='$skpd'";
                 $sqlsclient=$this->db->query($sqlsc);
                 foreach ($sqlsclient->result() as $rowsc)
                {
                   
                    $tgl=$rowsc->tgl_rka;
                    $tanggal = $this->tukd_model->tanggal_format_indonesia($tgl);
                    $kab     = $rowsc->kab_kota;
                    $daerah  = $rowsc->daerah;
                    $thn     = $rowsc->thn_ang;
                } 
           
        $bersih_skpd= str_replace(".", "", $skpd);
        $print_r = explode(".",$skpd);
        $ke1 = $print_r[0];
        $ke2 = $print_r[1];
        $ke3 = $print_r[2];        
        $ke4 = $print_r[3]; 
        $skkd = $ke1."/".$ke2."/".$ke3;   
            
        $cRet='';
        
        $modtahun= $thn%4;
	 
	 if ($modtahun = 0){
        $nilaibulan=".31 JANUARI.29 FEBRUARI.31 MARET.30 APRIL.31 MEI.30 JUNI.31 JULI.31 AGUSTUS.30 SEPTEMBER.31 OKTOBER.30 NOVEMBER.31 DESEMBER";}
            else {
        $nilaibulan=".31 JANUARI.28 FEBRUARI.31 MARET.30 APRIL.31 MEI.30 JUNI.31 JULI.31 AGUSTUS.30 SEPTEMBER.31 OKTOBER.30 NOVEMBER.31 DESEMBER";}
	 
	 $arraybulan=explode(".",$nilaibulan);
       
        $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
                    <tr>
                         <td align=\"center\"><strong>PEMERINTAH KABUPATEN SANGGAU</strong></td>                         
                    </tr>
					 <tr>
                         <td align=\"center\"><strong>$nmskpd</strong></td>                         
                    </tr>
                    <tr>
                         <td align=\"center\"><strong>LAPORAN REALISASI ANGGARAN</strong></td>
                    </tr>                    
                    <tr>
                         <td align=\"center\"><strong>PER $arraybulan[$cbulan] $thn</strong></td>
                    </tr>
                    <tr>
                         <td align=\"center\">&nbsp;</td>
                    </tr>
                  </table>";        
        
        
        $cRet .= "<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"4\">
                     <thead>                       
                        <tr><td bgcolor=\"#CCCCCC\" width=\"5%\" align=\"center\"><b>NO</b></td>                            
                            <td  bgcolor=\"#CCCCCC\" width=\"45%\" align=\"center\"><b>URAIAN</b></td>
                            <td bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>ANGGARAN</b></td>
                            <td bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>REALISASI</b></td>
                            <td  bgcolor=\"#CCCCCC\" width=\"15%\" align=\"center\" ><b>LEBIH</br>(KURANG)</b></td>
                            <td  bgcolor=\"#CCCCCC\" width=\"5%\" align=\"center\" ><b>%</b></td>   
                        </tr>
                        
                     </thead>
                     <tfoot>
                        <tr>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>                           
                         </tr>
                     </tfoot>
						";
					
					$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>4<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>PENDAPATAN<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";	                   	
               
                $sql4="
                select z.kode,z.nama,z.anggaran,z.reali from (
                SELECT left(a.kd_ang,2) as kode,b.nm_rek2 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek2 b on b.kd_rek2 = left(a.kd_ang,2)                
                where left(a.kd_ang,1)='4' and kd_skpd = '$skpd'
                group by left(a.kd_ang,2),b.nm_rek2
                union all
                SELECT left(a.kd_ang,3) as kode,b.nm_rek3 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek3 b on b.kd_rek3 = left(a.kd_ang,3)                
                where left(a.kd_ang,1)='4' and kd_skpd = '$skpd'
                group by left(a.kd_ang,3),b.nm_rek3
                union all
                SELECT left(a.kd_ang,5) as kode,b.nm_rek4 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek4 b on b.kd_rek4 = left(a.kd_ang,5)                
                where left(a.kd_ang,1)='4' and kd_skpd = '$skpd'
                group by left(a.kd_ang,5),b.nm_rek4
                union all
                 SELECT left(a.kd_ang,7) as kode,b.nm_rek64 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek5 b on b.kd_rek5 = left(a.kd_ang,7)                
                where left(a.kd_ang,1)='4' and kd_skpd = '$skpd'
                group by left(a.kd_ang,7),b.nm_rek64
                )z order by kode,nama
                ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil    = $row4->reali;
					$angnil = $row4->anggaran;
					
                    $real_s = $angnil - $nil;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil;
                    }

                    $nilai    = number_format($nil,"2",".",",");
                    $angnilai = number_format($angnil,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai=='' or $angnilai==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil/$angnil)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                   if(strlen("$no")<6){
                    $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                             }else
                             {
					$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">$no</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\">$nama</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\">$x1$selisih$y1</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\">$persen1</td>
                                 </tr>";
                             }
               }
               		$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                    $nil4=0;
                    $angnil4=0;
                    $sql4="
                select z.kode,z.nama,z.anggaran,z.reali from (
                SELECT left(a.kd_rek5,1) as kode,b.nm_rek1 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek1 b on b.kd_rek1 = left(a.kd_rek5,1)                
                where left(a.kd_rek5,1)='4' and kd_skpd = '$skpd'
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
					
                    $real_s = $angnil4 - $nil4;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil4==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil4;
                    }

                    $nilai4    = number_format($nil4,"2",".",",");
                    $angnilai4 = number_format($angnil4,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai4=='' or $angnilai4==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil4/$angnil4)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                    
               $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>JUMLAH $nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai4<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai4<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                   }   
                   
                   $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                      
                   	$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>5<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>BELANJA<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";	                   	
               
                   $sql4="
               select z.kode,z.nama,sum(z.anggaran) as anggaran,sum(z.reali) as reali from(
               
  SELECT left(a.kd_ang,2) as kode,b.nm_rek2 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek2 b on b.kd_rek2 = left(a.kd_ang,2)                        
                where left(a.kd_ang,1)='5' and kd_skpd = '$skpd'
                group by left(a.kd_ang,2),b.nm_rek2                
 union all
               
  SELECT left(a.kd_ang,3) as kode,b.nm_rek3 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek3 b on b.kd_rek3 = left(a.kd_ang,3)                        
                where left(a.kd_ang,1)='5' and kd_skpd = '$skpd'
                group by left(a.kd_ang,3),b.nm_rek3                
 union all
                
  SELECT left(a.kd_ang,5) as kode,b.nm_rek4 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek4 b on b.kd_rek4 = left(a.kd_ang,5)                        
                where left(a.kd_ang,1)='5' and kd_skpd = '$skpd'
                group by left(a.kd_ang,5),b.nm_rek4               
 union all
 
                
  SELECT left(a.kd_ang,7) as kode,b.nm_rek5 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek5 b on b.kd_rek5 = left(a.kd_ang,7)                        
                where left(a.kd_ang,1)='5' and kd_skpd = '$skpd'
                group by left(a.kd_ang,7),b.nm_rek5   
                ) z
                group by kode,nama
                order by kode,nama ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil    = $row4->reali;
					$angnil = $row4->anggaran;
					
                    $real_s = $angnil - $nil;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil;
                    }

                    $nilai    = number_format($nil,"2",".",",");
                    $angnilai = number_format($angnil,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai=='' or $angnilai==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil/$angnil)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                   if(strlen("$no")<6){
                    $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                             }else
                             {
					$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">$no</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\">$nama</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\">$x1$selisih$y1</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\">$persen1</td>
                                 </tr>";
                             }
               }  
               
                		$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                    
                    $sql4="
                select z.kode,z.nama,sum(z.anggaran) as anggaran,sum(z.reali) as reali from (
                SELECT left(a.kd_ang,1) as kode,b.nm_rek1 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek1 b on b.kd_rek1 = left(a.kd_ang,1)                
                where left(a.kd_ang,1)='5' and kd_skpd = '$skpd'
                group by left(a.kd_ang,1),b.nm_rek1 
                )z group by kode,nama order by kode,nama
                ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil5    = $row4->reali;
					$angnil5 = $row4->anggaran;
					
                    $real_s = $angnil5 - $nil5;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil5==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil5;
                    }

                    $nilai5    = number_format($nil5,"2",".",",");
                    $angnilai5 = number_format($angnil5,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai5=='' or $angnilai5==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil5/$angnil5)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                
               	$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                     
                    
               $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>JUMLAH $nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai5<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai5<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                   }   
                 
                  	$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                 
                 $no 	= '';
					$nama   = 'SURPLUS/DEFISIT';                      
					$nil    = $nil4 - $nil5;
					$angnil = $angnil4 - $angnil5;
					
                    $real_s = $angnil - $nil;

                    if ($angnil < 0){
                    	$a1="("; $angnil=$angnil*-1; $a2=")";}
                    else {
                    	$a1=""; $a2="";}

                    if ($nil < 0){
                    	$b1="("; $nil=$nil*-1; $b2=")";}
                    else {
                    	$b1=""; $b2="";}

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil;
                    }

                    $nilai    = number_format($nil,"2",".",",");
                    $angnilai = number_format($angnil,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai=='' or $angnilai==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil/$angnil)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                   
                   $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$a1$angnilai$a2<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$b1$nilai$b2<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";         
              
        $cRet .=       " </table>";
        $data['prev']= $cRet;
		 $cRet         .= "</table>";
		 
		 if($txt==1){
		 $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> Mengetahui</td>
		 <td align=\"center\" width=\"50%\"> Sanggau, $ctgl_ttd </td>
		 </tr>		
		 <tr>
		 <td align=\"center\" width=\"50%\"> $jabatan </td>
		 <td align=\"center\" width=\"50%\"> $jabatan1 </td>
		 </tr>	
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		  <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> $oioi</td>
		 <td align=\"center\" width=\"50%\"> $oioi1</td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> NIP :$nip</td>
		 <td align=\"center\" width=\"50%\"> NIP :$nip1 </td>
		 </tr>
         </table>
		 ";}
		$data['prev'] = $cRet;
        $data['sikap'] = 'preview';
        $judul  = 'LAPORAN REALISASI ANGGARAN';
        $this->template->set('title', 'CETAK LAPORAN REALISASI ANGGARAN');        
        switch($cetak) {
		case 1;
			 echo ("<title>L R A</title>"); 
             echo $cRet;
        break;		
        case 0;
             $this->tukd_model->_mpdf('',$cRet,10,10,10,'P');
        break;
        case 2;        
            header("Cache-Control: no-cache, no-store, must-revalidate");
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename= $judul.xls");
            
            $this->load->view('anggaran/rka/perkadaII', $data);
        break;
        case 3;     
            header("Cache-Control: no-cache, no-store, must-revalidate");
            header("Content-Type: application/vnd.ms-word");
            header("Content-Disposition: attachment; filename= $judul.doc");
            $this->load->view('anggaran/rka/perkadaII', $data);
        break;
        } 
    }


function cetak_lra_bulan_penjabaran($cbulan='', $cetak='', $txt=''){
	        $txt="1";
			//$tanggalttd = $this->uri->segment(5);
            //$ttd1 = str_replace('a',' ',$this->uri->segment(6));
            //$ttd2 = str_replace('a',' ',$this->uri->segment(7));
            //$ctgl_ttd = $this->tukd_model->tanggal_format_indonesia($tanggalttd);
            $bulan = strtoupper($this->tukd_model->getBulan($cbulan));
			$skpd = $this->uri->segment(8); 
            $ag_tox = $this->uri->segment(9);
			$sql1 = "SELECT nm_skpd FROM ms_skpd WHERE kd_skpd='$skpd'";
			$ivan = $this->db->query($sql1);
			$oioi = $ivan->row();
			$nmskpd = $oioi->nm_skpd;
			$realpend=0;
			$anggpend=0;
			
            $sqldns="SELECT a.kd_urusan as kd_u,b.nm_urusan as nm_u,a.kd_skpd as kd_sk,a.nm_skpd as nm_sk FROM ms_skpd a INNER JOIN ms_urusan b ON a.kd_urusan=b.kd_urusan WHERE kd_skpd='$skpd'";
                 $sqlskpd=$this->db->query($sqldns);
                 foreach ($sqlskpd->result() as $rowdns)
                {                  
                    $kd_urusan=$rowdns->kd_u;                    
                    $nm_urusan= $rowdns->nm_u;
                    $kd_skpd  = $rowdns->kd_sk;
                    $nm_skpd  = $rowdns->nm_sk;
                }
            
            /*$sqlanggaran1="select case when statu=1 and status_sempurna=1 and status_ubah=1 and $cbulan>=month(tgl_dpa_ubah) then 2 
					   when statu=1 and status_sempurna=1 and status_ubah=1 and $cbulan>=month(tgl_dpa_sempurna) and $cbulan<month(tgl_dpa_ubah) then 1
					   when statu=1 and status_sempurna=1 and status_ubah=1 and $cbulan<month(tgl_dpa_sempurna) then 1
					   when statu=1 and status_sempurna=1 and status_ubah=0 and $cbulan>=month(tgl_dpa_sempurna) then 1 
					   when statu=1 and status_sempurna=1 and status_ubah=0 and $cbulan<month(tgl_dpa_sempurna) then 1
					   when statu=1 and status_sempurna=0 and status_ubah=0 and $cbulan>=month(tgl_dpa) then 1
					   else 1 end as anggaran from trhrka where kd_skpd='$skpd'";*/
                       
             $sqlanggaran1="select case when statu=1 and status_sempurna=1 and status_ubah=1 then 2 
					   when statu=1 and status_sempurna=1 and status_ubah=0 then 2
					   when statu=1 and status_sempurna=0 and status_ubah=0 then 1
					   else 1 end as anggaran from trhrka where kd_skpd='$skpd'";                                 
                       
    $sqlanggaran=$this->db->query($sqlanggaran1);
	foreach ($sqlanggaran->result() as $rowttd)
        {
            $anggaran=$rowttd->anggaran;
        }

	//$ag_tox=$anggaran;
            /*
			$sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab FROM ms_ttd where kd_skpd='$skpd' and kode='PA' and nip='$ttd1'";
            $sqlttd=$this->db->query($sqlttd1);
            foreach ($sqlttd->result() as $rowttd)
			
                {
                    $nip=$rowttd->nip;                    
                    $oioi= $rowttd->nm;
                    $jabatan = $rowttd->jab;
                }			
			
			$sqlttd2="SELECT nama as nm,nip as nip,jabatan as jab FROM ms_ttd where kd_skpd='$skpd' and kode='PPK' and nip='$ttd2'";
            $ttd11=$this->db->query($sqlttd2);
			foreach ($ttd11->result() as $ivan)
			    {
                    $nip1=$ivan->nip;                    
                    $oioi1= $ivan->nm;
                    $jabatan1 = $ivan->jab;
                }
			*/
       $sqlsc="SELECT tgl_rka,provinsi,kab_kota,daerah,thn_ang FROM sclient where kd_skpd='$skpd'";
                 $sqlsclient=$this->db->query($sqlsc);
                 foreach ($sqlsclient->result() as $rowsc)
                {
                   
                    $tgl=$rowsc->tgl_rka;
                    $tanggal = $this->tukd_model->tanggal_format_indonesia($tgl);
                    $kab     = $rowsc->kab_kota;
                    $daerah  = $rowsc->daerah;
                    $thn     = $rowsc->thn_ang;
                } 
           
        $bersih_skpd= str_replace(".", "", $skpd);
        $print_r = explode(".",$skpd);
        $ke1 = $print_r[0];
        $ke2 = $print_r[1];
        $ke3 = $print_r[2];        
        $ke4 = $print_r[3]; 
        $skkd = $ke1."/".$ke2."/".$ke3;   
            
        $cRet='';
        
        $modtahun= $thn%4;
	 
	 if ($modtahun = 0){
        $nilaibulan=".31 JANUARI.29 FEBRUARI.31 MARET.30 APRIL.31 MEI.30 JUNI.31 JULI.31 AGUSTUS.30 SEPTEMBER.31 OKTOBER.30 NOVEMBER.31 DESEMBER";}
            else {
        $nilaibulan=".31 JANUARI.28 FEBRUARI.31 MARET.30 APRIL.31 MEI.30 JUNI.31 JULI.31 AGUSTUS.30 SEPTEMBER.31 OKTOBER.30 NOVEMBER.31 DESEMBER";}
	 
	 $arraybulan=explode(".",$nilaibulan);
       
        $cRet .="<table style=\"font-size:13px; border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
                    <tr>
                         <td align=\"center\"><strong>PEMERINTAH KABUPATEN SANGGAU</strong></td>                         
                    </tr>
					<tr>
                         <td align=\"center\"><strong>RINCIAN LAPORAN REALISASI ANGGARAN MENURUT URUSAN PEMERINTAHAN DAERAH, ORGANISASI<br/>
                                        PENDAPATAN, BELANJA DAN PEMBIAYAAN </strong></td>
                    </tr>                    
                    <tr>
                         <td align=\"center\"><strong>PER $arraybulan[$cbulan] TAHUN $thn</strong></td>
                    </tr>
                    <tr>
                         <td align=\"center\">&nbsp;</td>
                    </tr>
                  </table>";      
                    
        $cRet .="<table style=\"border-collapse:collapse; font-size:13px;\" width=\"100%\" align=\"left\" border=\"0\">
                    <tr>
						<td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                        <td width=\"2%\"></td>
                        <td width=\"20%\">Urusan Organisasi </td>
                        <td width=\"70%\">: $kd_urusan - $nm_urusan</td>
                    </tr>
                    <tr>
						<td></td>
                        <td></td>
                        <td>Organisasi</td>
                        <td>: $kd_skpd - $nm_skpd</td>
                    </tr>
                    </table>";
        
        $cRet .= "<table style=\"font-size:10px; border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"4\">
                     <thead>                       
                        <tr>
                            <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>    
                            <td bgcolor=\"#CCCCCC\" width=\"5%\" align=\"center\"><b>NO</b></td>                            
                            <td  bgcolor=\"#CCCCCC\" width=\"37%\" align=\"center\"><b>URAIAN</b></td>
                            <td bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>ANGGARAN</b></td>
                            <td bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>REALISASI</b></td>
                            <td  bgcolor=\"#CCCCCC\" width=\"15%\" align=\"center\" ><b>LEBIH</br>(KURANG)</b></td>
                            <td  bgcolor=\"#CCCCCC\" width=\"5%\" align=\"center\" ><b>%</b></td>   
                        </tr>
                        
                     </thead>
                     <tfoot>
                        <tr>
                            <td style=\"border: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>                           
                         </tr>
                     </tfoot>
						";
					
					$cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b><b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"><b><b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";	                   	
               $nil4=0;
               $angnil4=0;
               $sql4="
                select z.kode,z.nama,z.anggaran,z.reali from (
                SELECT left(a.kd_rek5,1) as kode,b.nm_rek1 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4( $cbulan,$ag_tox) a
                inner join ms_rek1 b on b.kd_rek1 = left(a.kd_rek5,1)                
                where left(a.kd_rek5,1)='4' and left(kd_skpd,7) = left('$skpd',7)
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
					
                    $real_s = $angnil4 - $nil4;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil4==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil4;
                    }

                    $nilai4    = number_format($nil4,"2",".",",");
                    $angnilai4 = number_format($angnil4,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai4=='' or $angnilai4==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil4/$angnil4)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                    
               $cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">4</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai4<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai4<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                   }   
                   
                   $cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                      
               
                $sql4="
                select z.kode,z.nama,z.anggaran,z.reali from (
                SELECT left(a.kd_rek5,2) as kode,b.nm_rek2 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4( $cbulan,$ag_tox) a
                inner join ms_rek2_64 b on b.kd_rek2 = left(a.kd_rek5,2)                
                where left(a.kd_rek5,1)='4' and left(kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_rek5,2),b.nm_rek2
                union all
                SELECT left(a.kd_rek5,3) as kode,b.nm_rek3 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4( $cbulan,$ag_tox) a
                inner join ms_rek3_64 b on b.kd_rek3 = left(a.kd_rek5,3)                
                where left(a.kd_rek5,1)='4' and left(kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_rek5,3),b.nm_rek3
                union all
                SELECT left(a.kd_rek5,5) as kode,b.nm_rek4_64 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4( $cbulan,$ag_tox) a
                inner join ms_rek4_64 b on b.kd_rek4_64 = left(a.kd_rek5,5)                
                where left(a.kd_rek5,1)='4' and left(kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_rek5,5),b.nm_rek4_64
                union all
                 SELECT left(a.kd_rek5,7) as kode,b.nm_rek64 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4( $cbulan,$ag_tox) a
                inner join ms_rek5 b on b.kd_rek5 = left(a.kd_rek5,7)                
                where left(a.kd_rek5,1)='4' and left(kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_rek5,7),b.nm_rek64
                )z order by kode,nama
                ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil    = $row4->reali;
					$angnil = $row4->anggaran;
					
                    $real_s = $angnil - $nil;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil;
                    }

                    $nilai    = number_format($nil,"2",".",",");
                    $angnilai = number_format($angnil,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai=='' or $angnilai==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil/$angnil)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                   if(strlen("$no")<6){
                    $cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                             }else
                             {
					$cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">$no</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\">$nama</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\">$x1$selisih$y1</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\">$persen1</td>
                                 </tr>";
                             }
               }
               		$cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>    
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                       
                        $sql4="
                select z.kode,z.nama,sum(z.anggaran) as anggaran,sum(z.reali) as reali from (
                SELECT left(a.kd_rek5,1) as kode,b.nm_rek1 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4( $cbulan,$ag_tox) a
                inner join ms_rek1 b on b.kd_rek1 = left(a.kd_rek5,1)                
                where left(a.kd_rek5,1)='5' and left(kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_rek5,1),b.nm_rek1    
                )z group by kode,nama order by kode,nama
                ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil5    = $row4->reali;
					$angnil5 = $row4->anggaran;
					
                    $real_s = $angnil5 - $nil5;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil5==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil5;
                    }

                    $nilai5    = number_format($nil5,"2",".",",");
                    $angnilai5 = number_format($angnil5,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai5=='' or $angnilai5==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil5/$angnil5)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                    
               $cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">5</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai5<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai5<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                   }   
                                      
                  	$cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";	                   	
               
                   $sql4=" select z.kode,z.nama,sum(z.anggaran) as anggaran,sum(z.reali) as reali from(
                   
  SELECT left(a.kd_rek5,2) as kode,b.nm_rek2 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4($cbulan,$ag_tox) a
                inner join ms_rek2_64 b on b.kd_rek2 = left(a.kd_rek5,2)                        
                where left(a.kd_rek5,2)='51' and left(a.kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_rek5,2),b.nm_rek2                
 union all
                   
  SELECT left(a.kd_rek5,3) as kode,b.nm_rek3 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4($cbulan,$ag_tox) a
                inner join ms_rek3_64 b on b.kd_rek3 = left(a.kd_rek5,3)                        
                where left(a.kd_rek5,2)='51' and left(a.kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_rek5,3),b.nm_rek3                
 union all
                
  SELECT left(a.kd_rek5,5) as kode,b.nm_rek4_64 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4($cbulan,$ag_tox) a
                inner join ms_rek4_64 b on b.kd_rek4_64 = left(a.kd_rek5,5)                        
                where left(a.kd_rek5,2)='51' and left(a.kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_rek5,5),b.nm_rek4_64               
 union all
  SELECT left(a.kd_rek5,7) as kode,b.nm_rek5 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4(  $cbulan,$ag_tox) a
                inner join ms_rek5 b on b.kd_rek64 = left(a.kd_rek5,7)                        
                where left(a.kd_rek5,2)='51' and left(a.kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_rek5,7),b.nm_rek5   
                ) z
                 group by kode,nama order by kode,nama
                ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil    = $row4->reali;
					$angnil = $row4->anggaran;
					
                    $real_s = $angnil - $nil;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil;
                    }

                    $nilai    = number_format($nil,"2",".",",");
                    $angnilai = number_format($angnil,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai=='' or $angnilai==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil/$angnil)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                   if(strlen("$no")<6){
                    $cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                             }else
                             {
					$cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">$no</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\">$nama</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\">$x1$selisih$y1</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\">$persen1</td>
                                 </tr>";
                             }
               }                                 	                                     
                
                $cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                
                 $sql4="
                select z.kode,z.nama,sum(z.anggaran) as anggaran,sum(z.reali) as reali from (
                SELECT left(a.kd_rek5,2) as kode,b.nm_rek2 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4( $cbulan,$ag_tox) a
                inner join ms_rek2_64 b on b.kd_rek2 = left(a.kd_rek5,2)                
                where left(a.kd_rek5,2)='52' and left(kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_rek5,2),b.nm_rek2     
                )z group by kode,nama order by kode,nama
                ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil52    = $row4->reali;
					$angnil52 = $row4->anggaran;
					
                    $real_s = $angnil52 - $nil52;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil52==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil52;
                    }

                    $nilai52    = number_format($nil52,"2",".",",");
                    $angnilai52 = number_format($angnil52,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai52=='' or $angnilai52==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil52/$angnil52)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                    
               $cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">52</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai52<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai52<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                   }   
                
                	$cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";	                   	
               
                   $sql4="
                select z.kd_kegiatan,z.kode,z.nama,sum(z.anggaran) as anggaran,sum(z.reali) as reali from(
            
 SELECT left(a.kd_kegiatan,18) as kd_kegiatan,'' as kode,b.nm_program as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4(  $cbulan,$ag_tox) a
                inner join m_prog b on b.kd_program = left(a.kd_kegiatan,18)                
                where left(a.kd_rek5,2)='52' and left(a.kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_kegiatan,18),b.nm_program
 union all  
                                  
 SELECT left(a.kd_kegiatan,21) as kd_kegiatan,'' as kode,b.nm_kegiatan as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4(  $cbulan,$ag_tox) a
                inner join m_giat b on b.kd_kegiatan = left(a.kd_kegiatan,21)                
                where left(a.kd_rek5,2)='52' and left(a.kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_kegiatan,21),b.nm_kegiatan
 union all 
                      
 SELECT left(a.kd_kegiatan,24) as kd_kegiatan,'' as kode,b.nm_kegiatan as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4( $cbulan,$ag_tox) a
                inner join m_giat b on b.kd_kegiatan = left(a.kd_kegiatan,24)                
                where left(a.kd_rek5,2)='52' and left(a.kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_kegiatan,24),b.nm_kegiatan
 union all
                
  SELECT left(a.kd_kegiatan,24) as kd_kegiatan,left(a.kd_rek5,3) as kode,b.nm_rek3 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4( $cbulan,$ag_tox) a
                inner join ms_rek3_64 b on b.kd_rek3 = left(a.kd_rek5,3)                        
                where left(a.kd_rek5,2)='52' and left(a.kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_kegiatan,24),a.nm_kegiatan,left(a.kd_rek5,3),b.nm_rek3                
 union all
                
  SELECT left(a.kd_kegiatan,24) as kd_kegiatan,left(a.kd_rek5,5) as kode,b.nm_rek4_64 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4( $cbulan,$ag_tox) a
                inner join ms_rek4_64 b on b.kd_rek4_64 = left(a.kd_rek5,5)                        
                where left(a.kd_rek5,2)='52' and left(a.kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_kegiatan,24),a.nm_kegiatan,left(a.kd_rek5,5),b.nm_rek4_64               
 union all
                            
  SELECT left(a.kd_kegiatan,24) as kd_kegiatan,left(a.kd_rek5,7) as kode,b.nm_rek5 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4( $cbulan,$ag_tox) a
                inner join ms_rek5 b on b.kd_rek64 = left(a.kd_rek5,7)                        
                where left(a.kd_rek5,2)='52' and left(a.kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_kegiatan,24),a.nm_kegiatan,left(a.kd_rek5,7),b.nm_rek5     
                ) z
                group by kd_kegiatan,kode,nama
                order by kd_kegiatan,kode,nama
                ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$keg 	= $row4->kd_kegiatan;
                    $no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil    = $row4->reali;
					$angnil = $row4->anggaran;
					
                    $real_s = $angnil - $nil;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil;
                    }

                    $nilai    = number_format($nil,"2",".",",");
                    $angnilai = number_format($angnil,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai=='' or $angnilai==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil/$angnil)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                   if($no==" "){
                    $cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>$keg<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                             }else
                             {
					$cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">$no</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\">$nama</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\">$x1$selisih$y1</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\">$persen1</td>
                                 </tr>";
                             }
               }                 
                 
                  	$cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                 
                 $no 	= '';
					$nama   = 'SURPLUS/DEFISIT';                      
					$nil    = $nil4 - $nil5;
					$angnil = $angnil4 - $angnil5;
					
                    $real_s = $angnil - $nil;

                    if ($angnil < 0){
                    	$a1="("; $angnil=$angnil*-1; $a2=")";}
                    else {
                    	$a1=""; $a2="";}

                    if ($nil < 0){
                    	$b1="("; $nil=$nil*-1; $b2=")";}
                    else {
                    	$b1=""; $b2="";}

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil;
                    }

                    $nilai    = number_format($nil,"2",".",",");
                    $angnilai = number_format($angnil,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai=='' or $angnilai==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil/$angnil)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                   
                   $cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$a1$angnilai$a2<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$b1$nilai$b2<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";         
              
        $cRet .=       " </table>";
        $data['prev']= $cRet;
		 $cRet         .= "</table>";
		 /*
		 if($txt==1){
		 $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> Mengetahui,</td>
		 <td align=\"center\" width=\"50%\"> Sanggau, $ctgl_ttd </td>
		 </tr>		
		 <tr>
		 <td align=\"center\" width=\"50%\"> $jabatan </td>
		 <td align=\"center\" width=\"50%\"> $jabatan1 </td>
		 </tr>	
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		  <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> $oioi </td>
		 <td align=\"center\" width=\"50%\"> $oioi1 </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> NIP :$nip</td>
		 <td align=\"center\" width=\"50%\"> NIP :$nip1</td>
		 </tr>
         </table>
		 ";}*/
		$data['prev'] = $cRet;
        $data['sikap'] = 'preview';
        $judul  = 'LAPORAN REALISASI ANGGARAN';
        $this->template->set('title', 'CETAK LAPORAN REALISASI ANGGARAN');        
        switch($cetak) {
		case 1;
			 echo ("<title>L R A</title>"); 
             echo $cRet;
        break;		
        case 0;
             $this->_mpdf_down('',$cRet,10,10,10,'0',0,'','LRA Penjabaran '.$skpd.'');
        break;
        case 2;        
            header("Cache-Control: no-cache, no-store, must-revalidate");
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename= $judul.xls");
            
            $this->load->view('anggaran/rka/perkadaII', $data);
        break;
        case 3;     
            header("Cache-Control: no-cache, no-store, must-revalidate");
            header("Content-Type: application/vnd.ms-word");
            header("Content-Disposition: attachment; filename= $judul.doc");
            $this->load->view('anggaran/rka/perkadaII', $data);
        break;
        } 
    }


function cetak_lra_bulan_penjabaran_skpd($cbulan='', $cetak='', $txt=''){
	        $txt="1";
			$tanggalttd = $this->uri->segment(5);
            $ttd1 = str_replace('a',' ',$this->uri->segment(6));
            $ttd2 = str_replace('a',' ',$this->uri->segment(7));
            $ctgl_ttd = $this->tukd_model->tanggal_format_indonesia($tanggalttd);
            $bulan = strtoupper($this->tukd_model->getBulan($cbulan));
			$skpd = $this->session->userdata('kdskpd'); 
			$sql1 = "SELECT nm_skpd FROM ms_skpd WHERE kd_skpd='$skpd'";
			$ivan = $this->db->query($sql1);
			$oioi = $ivan->row();
			$nmskpd = $oioi->nm_skpd;
			$realpend=0;
			$anggpend=0;
			
            $sqldns="SELECT a.kd_urusan as kd_u,b.nm_urusan as nm_u,a.kd_skpd as kd_sk,a.nm_skpd as nm_sk FROM ms_skpd a INNER JOIN ms_urusan b ON a.kd_urusan=b.kd_urusan WHERE kd_skpd='$skpd'";
                 $sqlskpd=$this->db->query($sqldns);
                 foreach ($sqlskpd->result() as $rowdns)
                {                  
                    $kd_urusan=$rowdns->kd_u;                    
                    $nm_urusan= $rowdns->nm_u;
                    $kd_skpd  = $rowdns->kd_sk;
                    $nm_skpd  = $rowdns->nm_sk;
                }
            
            /*$sqlanggaran1="select case when statu=1 and status_sempurna=1 and status_ubah=1 and $cbulan>=month(tgl_dpa_ubah) then 2 
					   when statu=1 and status_sempurna=1 and status_ubah=1 and $cbulan>=month(tgl_dpa_sempurna) and $cbulan<month(tgl_dpa_ubah) then 1
					   when statu=1 and status_sempurna=1 and status_ubah=1 and $cbulan<month(tgl_dpa_sempurna) then 1
					   when statu=1 and status_sempurna=1 and status_ubah=0 and $cbulan>=month(tgl_dpa_sempurna) then 1 
					   when statu=1 and status_sempurna=1 and status_ubah=0 and $cbulan<month(tgl_dpa_sempurna) then 1
					   when statu=1 and status_sempurna=0 and status_ubah=0 and $cbulan>=month(tgl_dpa) then 1
					   else 1 end as anggaran from trhrka where kd_skpd='$skpd'";*/
                       
            $sqlanggaran1="select case when statu=1 and status_sempurna=1 and status_ubah=1 then 2 
					   when statu=1 and status_sempurna=1 and status_ubah=0 then 2
					   when statu=1 and status_sempurna=0 and status_ubah=0 then 1
					   else 1 end as anggaran from trhrka where kd_skpd='$skpd'";                       
                       
                       
    $sqlanggaran=$this->db->query($sqlanggaran1);
	foreach ($sqlanggaran->result() as $rowttd)
        {
            $anggaran=$rowttd->anggaran;
        }

	$ag_tox=$anggaran;
            
			$sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab FROM ms_ttd where kd_skpd='$skpd' and kode='PA' and nip='$ttd1'";
            $sqlttd=$this->db->query($sqlttd1);
            foreach ($sqlttd->result() as $rowttd)
			
                {
                    $nip=$rowttd->nip;                    
                    $oioi= $rowttd->nm;
                    $jabatan = $rowttd->jab;
                }			
			
			$sqlttd2="SELECT nama as nm,nip as nip,jabatan as jab FROM ms_ttd where kd_skpd='$skpd' and kode='PPK' and nip='$ttd2'";
            $ttd11=$this->db->query($sqlttd2);
			foreach ($ttd11->result() as $ivan)
			    {
                    $nip1=$ivan->nip;                    
                    $oioi1= $ivan->nm;
                    $jabatan1 = $ivan->jab;
                }
			
       $sqlsc="SELECT tgl_rka,provinsi,kab_kota,daerah,thn_ang FROM sclient where kd_skpd='$skpd'";
                 $sqlsclient=$this->db->query($sqlsc);
                 foreach ($sqlsclient->result() as $rowsc)
                {
                   
                    $tgl=$rowsc->tgl_rka;
                    $tanggal = $this->tukd_model->tanggal_format_indonesia($tgl);
                    $kab     = $rowsc->kab_kota;
                    $daerah  = $rowsc->daerah;
                    $thn     = $rowsc->thn_ang;
                } 
           
        $bersih_skpd= str_replace(".", "", $skpd);
        $print_r = explode(".",$skpd);
        $ke1 = $print_r[0];
        $ke2 = $print_r[1];
        $ke3 = $print_r[2];        
        $ke4 = $print_r[3]; 
        $skkd = $ke1."/".$ke2."/".$ke3;   
            
        $cRet='';
        
        $modtahun= $thn%4;
	 
	 if ($modtahun = 0){
        $nilaibulan=".31 JANUARI.29 FEBRUARI.31 MARET.30 APRIL.31 MEI.30 JUNI.31 JULI.31 AGUSTUS.30 SEPTEMBER.31 OKTOBER.30 NOVEMBER.31 DESEMBER";}
            else {
        $nilaibulan=".31 JANUARI.28 FEBRUARI.31 MARET.30 APRIL.31 MEI.30 JUNI.31 JULI.31 AGUSTUS.30 SEPTEMBER.31 OKTOBER.30 NOVEMBER.31 DESEMBER";}
	 
	 $arraybulan=explode(".",$nilaibulan);
        
        $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
                    <tr>
                         <td align=\"center\"><strong>PEMERINTAH KABUPATEN SANGGAU</strong></td>                         
                    </tr>
					<tr>
                         <td align=\"center\"><strong>RINCIAN LAPORAN REALISASI ANGGARAN MENURUT URUSAN PEMERINTAHAN DAERAH, ORGANISASI<br/>
                                        PENDAPATAN, BELANJA DAN PEMBIAYAAN </strong></td>
                    </tr>                    
                    <tr>
                         <td align=\"center\"><strong>PER $arraybulan[$cbulan] TAHUN $thn</strong></td>
                    </tr>
                    <tr>
                         <td align=\"center\">&nbsp;</td>
                    </tr>
                  </table>";        
        $cRet .="<table style=\"border-collapse:collapse;font-size:13px;\" width=\"100%\" align=\"left\" border=\"0\">
                    <tr>
						<td width=\"5%\"></td>
                        <td width=\"20%\">Urusan Organisasi </td>
                        <td width=\"75%\">:$kd_urusan - $nm_urusan</td>
                    </tr>
                    <tr>
						<td></td>
                        <td>Organisasi</td>
                        <td>:$kd_skpd - $nm_skpd</td>
                    </tr>";
        
        $cRet .= "<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"4\">
                     <thead>                       
                        <tr><td bgcolor=\"#CCCCCC\" width=\"5%\" align=\"center\"><b>NO</b></td>                            
                            <td  bgcolor=\"#CCCCCC\" width=\"45%\" align=\"center\"><b>URAIAN</b></td>
                            <td bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>ANGGARAN</b></td>
                            <td bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>REALISASI</b></td>
                            <td  bgcolor=\"#CCCCCC\" width=\"15%\" align=\"center\" ><b>LEBIH</br>(KURANG)</b></td>
                            <td  bgcolor=\"#CCCCCC\" width=\"5%\" align=\"center\" ><b>%</b></td>   
                        </tr>
                        
                     </thead>
                     <tfoot>
                        <tr>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>                           
                         </tr>
                     </tfoot>
						";
					
					$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b><b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b><b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";	                   	
               $nil4=0;
               $angnil4=0;
               $sql4="
                select z.kode,z.nama,z.anggaran,z.reali from (
                SELECT left(a.kd_rek5,1) as kode,b.nm_rek1 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek1 b on b.kd_rek1 = left(a.kd_rek5,1)                
                where left(a.kd_rek5,1)='4' and kd_skpd = '$skpd'
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
					
                    $real_s = $angnil4 - $nil4;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil4==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil4;
                    }

                    $nilai4    = number_format($nil4,"2",".",",");
                    $angnilai4 = number_format($angnil4,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai4=='' or $angnilai4==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil4/$angnil4)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                    
               $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">4</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai4<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai4<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                   }   
                   
                   $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                      
               
                $sql4="
                select z.kode,z.nama,z.anggaran,z.reali from (
                SELECT left(a.kd_rek5,2) as kode,b.nm_rek2 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek2_64 b on b.kd_rek2 = left(a.kd_rek5,2)                
                where left(a.kd_rek5,1)='4' and kd_skpd = '$skpd'
                group by left(a.kd_rek5,2),b.nm_rek2
                union all
                SELECT left(a.kd_rek5,3) as kode,b.nm_rek3 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek3_64 b on b.kd_rek3 = left(a.kd_rek5,3)                
                where left(a.kd_rek5,1)='4' and kd_skpd = '$skpd'
                group by left(a.kd_rek5,3),b.nm_rek3
                union all
                SELECT left(a.kd_rek5,5) as kode,b.nm_rek4_64 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek4_64 b on b.kd_rek4_64 = left(a.kd_rek5,5)                
                where left(a.kd_rek5,1)='4' and kd_skpd = '$skpd'
                group by left(a.kd_rek5,5),b.nm_rek4_64
                union all
                 SELECT left(a.kd_rek5,7) as kode,b.nm_rek64 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek5 b on b.kd_rek5 = left(a.kd_rek5,7)                
                where left(a.kd_rek5,1)='4' and kd_skpd = '$skpd'
                group by left(a.kd_rek5,7),b.nm_rek64
                )z order by kode,nama
                ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil    = $row4->reali;
					$angnil = $row4->anggaran;
					
                    $real_s = $angnil - $nil;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil;
                    }

                    $nilai    = number_format($nil,"2",".",",");
                    $angnilai = number_format($angnil,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai=='' or $angnilai==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil/$angnil)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                   if(strlen("$no")<6){
                    $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                             }else
                             {
					$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">$no</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\">$nama</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\">$x1$selisih$y1</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\">$persen1</td>
                                 </tr>";
                             }
               }
               		$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                       
                        $sql4="
                select z.kode,z.nama,sum(z.anggaran) as anggaran,sum(z.reali) as reali from (
                SELECT left(a.kd_rek5,1) as kode,b.nm_rek1 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek1 b on b.kd_rek1 = left(a.kd_rek5,1)                
                where left(a.kd_rek5,1)='5' and kd_skpd = '$skpd'
                group by left(a.kd_rek5,1),b.nm_rek1    
                )z group by kode,nama order by kode,nama
                ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil5    = $row4->reali;
					$angnil5 = $row4->anggaran;
					
                    $real_s = $angnil5 - $nil5;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil5==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil5;
                    }

                    $nilai5    = number_format($nil5,"2",".",",");
                    $angnilai5 = number_format($angnil5,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai5=='' or $angnilai5==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil5/$angnil5)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                    
               $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">5</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai5<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai5<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                   }   
                                      
                  	$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";	                   	
               
                   $sql4=" select z.kode,z.nama,sum(z.anggaran) as anggaran,sum(z.reali) as reali from(
                   
  SELECT left(a.kd_rek5,2) as kode,b.nm_rek2 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd($cbulan,$ag_tox) a
                inner join ms_rek2_64 b on b.kd_rek2 = left(a.kd_rek5,2)                        
                where left(a.kd_rek5,2)='51' and a.kd_skpd = '$skpd'
                group by left(a.kd_rek5,2),b.nm_rek2                
 union all
                   
  SELECT left(a.kd_rek5,3) as kode,b.nm_rek3 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd($cbulan,$ag_tox) a
                inner join ms_rek3_64 b on b.kd_rek3 = left(a.kd_rek5,3)                        
                where left(a.kd_rek5,2)='51' and a.kd_skpd = '$skpd'
                group by left(a.kd_rek5,3),b.nm_rek3                
 union all
                
  SELECT left(a.kd_rek5,5) as kode,b.nm_rek4_64 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd($cbulan,$ag_tox) a
                inner join ms_rek4_64 b on b.kd_rek4_64 = left(a.kd_rek5,5)                        
                where left(a.kd_rek5,2)='51' and a.kd_skpd = '$skpd'
                group by left(a.kd_rek5,5),b.nm_rek4_64               
 union all
  SELECT left(a.kd_rek5,7) as kode,b.nm_rek5 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd(  $cbulan,$ag_tox) a
                inner join ms_rek5 b on b.kd_rek64 = left(a.kd_rek5,7)                        
                where left(a.kd_rek5,2)='51' and a.kd_skpd = '$skpd'
                group by left(a.kd_rek5,7),b.nm_rek5   
                ) z
                 group by kode,nama order by kode,nama
                ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil    = $row4->reali;
					$angnil = $row4->anggaran;
					
                    $real_s = $angnil - $nil;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil;
                    }

                    $nilai    = number_format($nil,"2",".",",");
                    $angnilai = number_format($angnil,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai=='' or $angnilai==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil/$angnil)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                   if(strlen("$no")<6){
                    $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                             }else
                             {
					$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">$no</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\">$nama</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\">$x1$selisih$y1</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\">$persen1</td>
                                 </tr>";
                             }
               }                                 	                                     
                
                $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                
                 $sql4="
                select z.kode,z.nama,sum(z.anggaran) as anggaran,sum(z.reali) as reali from (
                SELECT left(a.kd_rek5,2) as kode,b.nm_rek2 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek2_64 b on b.kd_rek2 = left(a.kd_rek5,2)                
                where left(a.kd_rek5,2)='52' and a.kd_skpd = '$skpd'
                group by left(a.kd_rek5,2),b.nm_rek2     
                )z group by kode,nama order by kode,nama
                ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil52    = $row4->reali;
					$angnil52 = $row4->anggaran;
					
                    $real_s = $angnil52 - $nil52;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil52==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil52;
                    }

                    $nilai52    = number_format($nil52,"2",".",",");
                    $angnilai52 = number_format($angnil52,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai52=='' or $angnilai52==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil52/$angnil52)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                    
               $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">52</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai52<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai52<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                   }   
                
                	$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";	                   	
               
                   $sql4="
                select z.kd_kegiatan,z.kode,z.nama,sum(z.anggaran) as anggaran,sum(z.reali) as reali from(
            
 SELECT left(a.kd_kegiatan,18) as kd_kegiatan,'' as kode,b.nm_program as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd(  $cbulan,$ag_tox) a
                inner join m_prog b on b.kd_program = left(a.kd_kegiatan,18)                
                where left(a.kd_rek5,2)='52' and a.kd_skpd = '$skpd'
                group by left(a.kd_kegiatan,18),b.nm_program
 union all  
                                  
 SELECT left(a.kd_kegiatan,21) as kd_kegiatan,'' as kode,b.nm_kegiatan as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd(  $cbulan,$ag_tox) a
                inner join m_giat b on b.kd_kegiatan = left(a.kd_kegiatan,21)                
                where left(a.kd_rek5,2)='52' and a.kd_skpd = '$skpd'
                group by left(a.kd_kegiatan,21),b.nm_kegiatan
 union all 
                      
 SELECT left(a.kd_kegiatan,24) as kd_kegiatan,'' as kode,b.nm_kegiatan as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join m_giat b on b.kd_kegiatan = left(a.kd_kegiatan,24)                
                where left(a.kd_rek5,2)='52' and a.kd_skpd = '$skpd'
                group by left(a.kd_kegiatan,24),b.nm_kegiatan
 union all
                
  SELECT left(a.kd_kegiatan,24) as kd_kegiatan,left(a.kd_rek5,3) as kode,b.nm_rek3 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek3_64 b on b.kd_rek3 = left(a.kd_rek5,3)                        
                where left(a.kd_rek5,2)='52' and a.kd_skpd = '$skpd'
                group by left(a.kd_kegiatan,24),a.nm_kegiatan,left(a.kd_rek5,3),b.nm_rek3                
 union all
                
  SELECT left(a.kd_kegiatan,24) as kd_kegiatan,left(a.kd_rek5,5) as kode,b.nm_rek4_64 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek4_64 b on b.kd_rek4_64 = left(a.kd_rek5,5)                        
                where left(a.kd_rek5,2)='52' and a.kd_skpd = '$skpd'
                group by left(a.kd_kegiatan,24),a.nm_kegiatan,left(a.kd_rek5,5),b.nm_rek4_64               
 union all
                            
  SELECT left(a.kd_kegiatan,24) as kd_kegiatan,left(a.kd_rek5,7) as kode,b.nm_rek5 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek5 b on b.kd_rek64 = left(a.kd_rek5,7)                        
                where left(a.kd_rek5,2)='52' and a.kd_skpd = '$skpd'
                group by left(a.kd_kegiatan,24),a.nm_kegiatan,left(a.kd_rek5,7),b.nm_rek5     
                ) z
                group by kd_kegiatan,kode,nama
                order by kd_kegiatan,kode,nama
                ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$keg 	= $row4->kd_kegiatan;
                    $no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil    = $row4->reali;
					$angnil = $row4->anggaran;
					
                    $real_s = $angnil - $nil;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil;
                    }

                    $nilai    = number_format($nil,"2",".",",");
                    $angnilai = number_format($angnil,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai=='' or $angnilai==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil/$angnil)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                   if($no==" "){
                    $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>$keg<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                             }else
                             {
					$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">$no</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\">$nama</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\">$x1$selisih$y1</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\">$persen1</td>
                                 </tr>";
                             }
               }                 
                 
                  	$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                 
                 $no 	= '';
					$nama   = 'SURPLUS/DEFISIT';                      
					$nil    = $nil4 - $nil5;
					$angnil = $angnil4 - $angnil5;
					
                    $real_s = $angnil - $nil;

                    if ($angnil < 0){
                    	$a1="("; $angnil=$angnil*-1; $a2=")";}
                    else {
                    	$a1=""; $a2="";}

                    if ($nil < 0){
                    	$b1="("; $nil=$nil*-1; $b2=")";}
                    else {
                    	$b1=""; $b2="";}

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil;
                    }

                    $nilai    = number_format($nil,"2",".",",");
                    $angnilai = number_format($angnil,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai=='' or $angnilai==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil/$angnil)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                   
                   $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$a1$angnilai$a2<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$b1$nilai$b2<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";         
              
        $cRet .=       " </table>";
        $data['prev']= $cRet;
		 $cRet         .= "</table>";
		 
		 if($txt==1){
		 $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> Mengetahui,</td>
		 <td align=\"center\" width=\"50%\"> Sanggau, $ctgl_ttd </td>
		 </tr>		
		 <tr>
		 <td align=\"center\" width=\"50%\"> $jabatan </td>
		 <td align=\"center\" width=\"50%\"> $jabatan1 </td>
		 </tr>	
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		  <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> $oioi </td>
		 <td align=\"center\" width=\"50%\"> $oioi1 </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> NIP :$nip</td>
		 <td align=\"center\" width=\"50%\"> NIP :$nip1</td>
		 </tr>
         </table>
		 ";}
		$data['prev'] = $cRet;
        $data['sikap'] = 'preview';
        $judul  = 'LAPORAN REALISASI ANGGARAN';
        $this->template->set('title', 'CETAK LAPORAN REALISASI ANGGARAN');        
        switch($cetak) {
		case 1;
			 echo ("<title>L R A</title>"); 
             echo $cRet;
        break;		
        case 0;
             $this->tukd_model->_mpdf('',$cRet,10,10,10,'P');
        break;
        case 2;        
            header("Cache-Control: no-cache, no-store, must-revalidate");
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename= $judul.xls");
            
            $this->load->view('anggaran/rka/perkadaII', $data);
        break;
        case 3;     
            header("Cache-Control: no-cache, no-store, must-revalidate");
            header("Content-Type: application/vnd.ms-word");
            header("Content-Disposition: attachment; filename= $judul.doc");
            $this->load->view('anggaran/rka/perkadaII', $data);
        break;
        } 
    }
    
     function cetak_lra_bulan_penjabaran_ang($cbulan='', $cetak='', $txt=''){
	        $txt="1";
			$tanggalttd = $this->uri->segment(5);
            //$ttd1 = str_replace('a',' ',$this->uri->segment(6));
            //$ttd2 = str_replace('a',' ',$this->uri->segment(7));
            //$ctgl_ttd = $this->tukd_model->tanggal_format_indonesia($tanggalttd);
            $bulan = strtoupper($this->tukd_model->getBulan($cbulan));
			$skpd = $this->uri->segment(8);
            $ag_tox = $this->uri->segment(9);
			$sql1 = "SELECT nm_skpd FROM ms_skpd WHERE kd_skpd='$skpd'";
			$ivan = $this->db->query($sql1);
			$oioi = $ivan->row();
			$nmskpd = $oioi->nm_skpd;
			$realpend=0;
			$anggpend=0;
			
            $sqldns="SELECT a.kd_urusan as kd_u,b.nm_urusan as nm_u,a.kd_skpd as kd_sk,a.nm_skpd as nm_sk FROM ms_skpd a INNER JOIN ms_urusan b ON a.kd_urusan=b.kd_urusan WHERE kd_skpd='$skpd'";
                 $sqlskpd=$this->db->query($sqldns);
                 foreach ($sqlskpd->result() as $rowdns)
                {                  
                    $kd_urusan=$rowdns->kd_u;                    
                    $nm_urusan= $rowdns->nm_u;
                    $kd_skpd  = $rowdns->kd_sk;
                    $nm_skpd  = $rowdns->nm_sk;
                }
            
            /*$sqlanggaran1="select case when statu=1 and status_sempurna=1 and status_ubah=1 and $cbulan>=month(tgl_dpa_ubah) then 2 
					   when statu=1 and status_sempurna=1 and status_ubah=1 and $cbulan>=month(tgl_dpa_sempurna) and $cbulan<month(tgl_dpa_ubah) then 2
					   when statu=1 and status_sempurna=1 and status_ubah=1 and $cbulan<month(tgl_dpa_sempurna) then 2
					   when statu=1 and status_sempurna=1 and status_ubah=0 and $cbulan>=month(tgl_dpa_sempurna) then 2 
					   when statu=1 and status_sempurna=1 and status_ubah=0 and $cbulan<month(tgl_dpa_sempurna) then 2
					   when statu=1 and status_sempurna=0 and status_ubah=0 and $cbulan>=month(tgl_dpa) then 1
					   else 1 end as anggaran from trhrka where kd_skpd='$skpd'";*/
                       
            $sqlanggaran1="select case when statu=1 and status_sempurna=1 and status_ubah=1 then 2 
					   when statu=1 and status_sempurna=1 and status_ubah=0 then 2
					   when statu=1 and status_sempurna=0 and status_ubah=0 then 1
					   else 1 end as anggaran from trhrka where kd_skpd='$skpd'";                       
                       
    $sqlanggaran=$this->db->query($sqlanggaran1);
	foreach ($sqlanggaran->result() as $rowttd)
        {
            $anggaran=$rowttd->anggaran;
        }

	//$ag_tox=$anggaran;
            
            /*
			$sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab FROM ms_ttd where kd_skpd='$skpd' and kode='PA' and nip='$ttd1'";
            $sqlttd=$this->db->query($sqlttd1);
            foreach ($sqlttd->result() as $rowttd)
			
                {
                    $nip=$rowttd->nip;                    
                    $oioi= $rowttd->nm;
                    $jabatan = $rowttd->jab;
                }			
			
			$sqlttd2="SELECT nama as nm,nip as nip,jabatan as jab FROM ms_ttd where kd_skpd='$skpd' and kode='PPK' and nip='$ttd2'";
            $ttd11=$this->db->query($sqlttd2);
			foreach ($ttd11->result() as $ivan)
			    {
                    $nip1=$ivan->nip;                    
                    $oioi1= $ivan->nm;
                    $jabatan1 = $ivan->jab;
                }
			*/
       $sqlsc="SELECT tgl_rka,provinsi,kab_kota,daerah,thn_ang FROM sclient where kd_skpd='$skpd'";
                 $sqlsclient=$this->db->query($sqlsc);
                 foreach ($sqlsclient->result() as $rowsc)
                {
                   
                    $tgl=$rowsc->tgl_rka;
                    $tanggal = $this->tukd_model->tanggal_format_indonesia($tgl);
                    $kab     = $rowsc->kab_kota;
                    $daerah  = $rowsc->daerah;
                    $thn     = $rowsc->thn_ang;
                } 
           
        $bersih_skpd= str_replace(".", "", $skpd);
        $print_r = explode(".",$skpd);
        $ke1 = $print_r[0];
        $ke2 = $print_r[1];
        $ke3 = $print_r[2];        
        $ke4 = $print_r[3]; 
        $skkd = $ke1."/".$ke2."/".$ke3;   
            
        $cRet='';
        
        $modtahun= $thn%4;
	 
	 if ($modtahun = 0){
        $nilaibulan=".31 JANUARI.29 FEBRUARI.31 MARET.30 APRIL.31 MEI.30 JUNI.31 JULI.31 AGUSTUS.30 SEPTEMBER.31 OKTOBER.30 NOVEMBER.31 DESEMBER";}
            else {
        $nilaibulan=".31 JANUARI.28 FEBRUARI.31 MARET.30 APRIL.31 MEI.30 JUNI.31 JULI.31 AGUSTUS.30 SEPTEMBER.31 OKTOBER.30 NOVEMBER.31 DESEMBER";}
	 
	 $arraybulan=explode(".",$nilaibulan);
     
        $cRet .="<table style=\"font-size:13px; border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
                    <tr>
                         <td align=\"center\"><strong>PEMERINTAH KABUPATEN SANGGAU</strong></td>                         
                    </tr>
					<tr>
                         <td align=\"center\"><strong>RINCIAN LAPORAN REALISASI ANGGARAN MENURUT URUSAN PEMERINTAHAN DAERAH, ORGANISASI<br/>
                                        PENDAPATAN, BELANJA DAN PEMBIAYAAN </strong></td>
                    </tr>                    
                    <tr>
                         <td align=\"center\"><strong>PER $arraybulan[$cbulan] TAHUN $thn</strong></td>
                    </tr>
                    <tr>
                         <td align=\"center\">&nbsp;</td>
                    </tr>
                  </table>";      
                    
        $cRet .="<table style=\"border-collapse:collapse; font-size:13px;\" width=\"100%\" align=\"left\" border=\"0\">
                    <tr>
						<td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                        <td width=\"2%\"></td>
                        <td width=\"20%\">Urusan Organisasi </td>
                        <td width=\"70%\">: $kd_urusan - $nm_urusan</td>
                    </tr>
                    <tr>
						<td></td>
                        <td></td>
                        <td>Organisasi</td>
                        <td>: $kd_skpd - $nm_skpd</td>
                    </tr>
                    </table>";
        
        $cRet .= "<table style=\"font-size:10px; border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"4\">
                     <thead>                       
                        <tr>
                            <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                            <td bgcolor=\"#CCCCCC\" width=\"5%\" align=\"center\"><b>NO</b></td>                            
                            <td  bgcolor=\"#CCCCCC\" width=\"37%\" align=\"center\"><b>URAIAN</b></td>
                            <td bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>ANGGARAN</b></td>
                            <td bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>REALISASI</b></td>
                            <td  bgcolor=\"#CCCCCC\" width=\"15%\" align=\"center\" ><b>LEBIH</br>(KURANG)</b></td>
                            <td  bgcolor=\"#CCCCCC\" width=\"5%\" align=\"center\" ><b>%</b></td>   
                        </tr>                        
                     </thead>
                     <tfoot>
                        <tr>
                            <td style=\"border: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>                           
                         </tr>
                     </tfoot>
						";
					
					$cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b><b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"><b><b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";	                   	
               $nil4=0;
               $angnil4=0;
               $sql4="
                select z.kode,z.nama,z.anggaran,z.reali from (
                SELECT left(a.kd_ang,1) as kode,b.nm_rek1 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4( $cbulan,$ag_tox) a
                inner join ms_rek1 b on b.kd_rek1 = left(a.kd_ang,1)                
                where left(a.kd_ang,1)='4' and left(kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_ang,1),b.nm_rek1               
                )z order by kode,nama
                ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil4    = $row4->reali;
					$angnil4 = $row4->anggaran;
					
                    $real_s = $angnil4 - $nil4;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil4==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil4;
                    }

                    $nilai4    = number_format($nil4,"2",".",",");
                    $angnilai4 = number_format($angnil4,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai4=='' or $angnilai4==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil4/$angnil4)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                    
               $cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">4</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai4<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai4<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                   }   
                   
                   $cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                      
               
                $sql4="
                select z.kode,z.nama,z.anggaran,z.reali from (
                SELECT left(a.kd_ang,2) as kode,b.nm_rek2 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4( $cbulan,$ag_tox) a
                inner join ms_rek2 b on b.kd_rek2 = left(a.kd_ang,2)                
                where left(a.kd_ang,1)='4' and left(kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_ang,2),b.nm_rek2
                union all
                SELECT left(a.kd_ang,3) as kode,b.nm_rek3 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4( $cbulan,$ag_tox) a
                inner join ms_rek3 b on b.kd_rek3 = left(a.kd_ang,3)                
                where left(a.kd_ang,1)='4' and left(kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_ang,3),b.nm_rek3
                union all
                SELECT left(a.kd_ang,5) as kode,b.nm_rek4 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4( $cbulan,$ag_tox) a
                inner join ms_rek4 b on b.kd_rek4 = left(a.kd_ang,5)                
                where left(a.kd_ang,1)='4' and left(kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_ang,5),b.nm_rek4
                union all
                 SELECT left(a.kd_ang,7) as kode,b.nm_rek5 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4( $cbulan,$ag_tox) a
                inner join ms_rek5 b on b.kd_rek5 = left(a.kd_ang,7)                
                where left(a.kd_ang,1)='4' and left(kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_ang,7),b.nm_rek5
                )z order by kode,nama
                ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil    = $row4->reali;
					$angnil = $row4->anggaran;
					
                    $real_s = $angnil - $nil;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil;
                    }

                    $nilai    = number_format($nil,"2",".",",");
                    $angnilai = number_format($angnil,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai=='' or $angnilai==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil/$angnil)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                   if(strlen("$no")<6){
                    $cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                             }else
                             {
					$cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">$no</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\">$nama</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\">$x1$selisih$y1</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\">$persen1</td>
                                 </tr>";
                             }
               }
               		$cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>   
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                       
                        $sql4="
                select z.kode,z.nama,sum(z.anggaran) as anggaran,sum(z.reali) as reali from (
                SELECT left(a.kd_ang,1) as kode,b.nm_rek1 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4( $cbulan,$ag_tox) a
                inner join ms_rek1 b on b.kd_rek1 = left(a.kd_ang,1)                
                where left(a.kd_ang,1)='5' and left(kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_ang,1),b.nm_rek1    
                )z group by kode,nama order by kode,nama
                ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil5    = $row4->reali;
					$angnil5 = $row4->anggaran;
					
                    $real_s = $angnil5 - $nil5;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil5==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil5;
                    }

                    $nilai5    = number_format($nil5,"2",".",",");
                    $angnilai5 = number_format($angnil5,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai5=='' or $angnilai5==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil5/$angnil5)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                    
               $cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">5</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai5<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai5<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                   }   
                                      
                  	$cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";	                   	
               
                   $sql4=" select z.kode,z.nama,sum(z.anggaran) as anggaran,sum(z.reali) as reali from(
                   
  SELECT left(a.kd_ang,2) as kode,b.nm_rek2 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4($cbulan,$ag_tox) a
                inner join ms_rek2 b on b.kd_rek2 = left(a.kd_ang,2)                        
                where left(a.kd_ang,2)='51' and left(a.kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_ang,2),b.nm_rek2                
 union all
                    
  SELECT left(a.kd_ang,3) as kode,b.nm_rek3 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4( $cbulan,$ag_tox) a
                inner join ms_rek3 b on b.kd_rek3 = left(a.kd_ang,3)                        
                where left(a.kd_ang,2)='51' and left(a.kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_ang,3),b.nm_rek3                
 union all
                
  SELECT left(a.kd_ang,5) as kode,b.nm_rek4 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4( $cbulan,$ag_tox) a
                inner join ms_rek4 b on b.kd_rek4 = left(a.kd_ang,5)                        
                where left(a.kd_ang,2)='51' and left(a.kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_ang,5),b.nm_rek4               
 union all
                
  SELECT left(a.kd_ang,7) as kode,b.nm_rek5 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4( $cbulan,$ag_tox) a
                inner join ms_rek5 b on b.kd_rek5 = left(a.kd_ang,7)                        
                where left(a.kd_ang,2)='51' and left(a.kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_ang,7),b.nm_rek5   
                ) z
                 group by kode,nama order by kode,nama
                ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil    = $row4->reali;
					$angnil = $row4->anggaran;
					
                    $real_s = $angnil - $nil;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil;
                    }

                    $nilai    = number_format($nil,"2",".",",");
                    $angnilai = number_format($angnil,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai=='' or $angnilai==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil/$angnil)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                   if(strlen("$no")<6){
                    $cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>   
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                             }else
                             {
					$cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">$no</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\">$nama</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\">$x1$selisih$y1</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\">$persen1</td>
                                 </tr>";
                             }
               }                                 	                                     
                
                $cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                
                 $sql4="
                select z.kode,z.nama,sum(z.anggaran) as anggaran,sum(z.reali) as reali from (
                SELECT left(a.kd_ang,2) as kode,b.nm_rek2 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4( $cbulan,$ag_tox) a
                inner join ms_rek2 b on b.kd_rek2 = left(a.kd_ang,2)                
                where left(a.kd_ang,2)='52' and left(kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_ang,2),b.nm_rek2     
                )z group by kode,nama order by kode,nama
                ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil52    = $row4->reali;
					$angnil52 = $row4->anggaran;
					
                    $real_s = $angnil52 - $nil52;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil52==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil52;
                    }

                    $nilai52    = number_format($nil52,"2",".",",");
                    $angnilai52 = number_format($angnil52,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai52=='' or $angnilai52==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil52/$angnil52)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                    
               $cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">52</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai52<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai52<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                   }   
                
                	$cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";	                   	
               
                   $sql4="
                select z.kd_kegiatan,z.kode,z.nama,sum(z.anggaran) as anggaran,sum(z.reali) as reali from(
            
 SELECT left(a.kd_kegiatan,18) as kd_kegiatan,left(a.kd_kegiatan,18) as kode,b.nm_program as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4( $cbulan,$ag_tox) a
                inner join m_prog b on b.kd_program = left(a.kd_kegiatan,18)                
                where left(a.kd_ang,2)='52' and left(a.kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_kegiatan,18),b.nm_program
 union all  
                                  
 SELECT left(a.kd_kegiatan,21) as kd_kegiatan,left(a.kd_kegiatan,21) as kode,b.nm_kegiatan as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4( $cbulan,$ag_tox) a
                inner join m_giat b on b.kd_kegiatan = left(a.kd_kegiatan,21)                
                where left(a.kd_ang,2)='52' and left(a.kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_kegiatan,21),b.nm_kegiatan
 union all 
                     
 SELECT left(a.kd_kegiatan,24) as kd_kegiatan,left(a.kd_kegiatan,24) as kode,b.nm_kegiatan as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4( $cbulan,$ag_tox) a
                inner join m_giat b on b.kd_kegiatan = left(a.kd_kegiatan,24)                
                where left(a.kd_ang,2)='52' and left(a.kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_kegiatan,24),b.nm_kegiatan
 union all
                
  SELECT left(a.kd_kegiatan,24) as kd_kegiatan,left(a.kd_ang,3) as kode,b.nm_rek3 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4( $cbulan,$ag_tox) a
                inner join ms_rek3 b on b.kd_rek3 = left(a.kd_ang,3)                        
                where left(a.kd_ang,2)='52' and left(a.kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_kegiatan,24),a.nm_kegiatan,left(a.kd_ang,3),b.nm_rek3                
 union all
                
  SELECT left(a.kd_kegiatan,24) as kd_kegiatan,left(a.kd_ang,5) as kode,b.nm_rek4 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4( $cbulan,$ag_tox) a
                inner join ms_rek4 b on b.kd_rek4 = left(a.kd_ang,5)                        
                where left(a.kd_ang,2)='52' and left(a.kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_kegiatan,24),a.nm_kegiatan,left(a.kd_ang,5),b.nm_rek4               
 union all
                            
  SELECT left(a.kd_kegiatan,24) as kd_kegiatan,left(a.kd_ang,7) as kode,b.nm_rek5 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4( $cbulan,$ag_tox) a
                inner join ms_rek5 b on b.kd_rek5 = left(a.kd_ang,7)                        
                where left(a.kd_ang,2)='52' and left(a.kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_kegiatan,24),a.nm_kegiatan,left(a.kd_ang,7),b.nm_rek5     
                ) z
                group by kd_kegiatan,kode,nama
                order by kd_kegiatan,kode,nama
                ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$keg 	= $row4->kd_kegiatan;
                    $no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil    = $row4->reali;
					$angnil = $row4->anggaran;
					
                    $real_s = $angnil - $nil;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil;
                    }

                    $nilai    = number_format($nil,"2",".",",");
                    $angnilai = number_format($angnil,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai=='' or $angnilai==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil/$angnil)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                   if($no==" "){
                    $cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>$keg<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                             }else
                             {
					$cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">$no</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\">$nama</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\">$x1$selisih$y1</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\">$persen1</td>
                                 </tr>";
                             }
               }                 
                 
                  	$cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>   
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                 
                 $no 	= '';
					$nama   = 'SURPLUS/DEFISIT';                      
					$nil    = $nil4 - $nil5;
					$angnil = $angnil4 - $angnil5;
					
                    $real_s = $angnil - $nil;

                    if ($angnil < 0){
                    	$a1="("; $angnil=$angnil*-1; $a2=")";}
                    else {
                    	$a1=""; $a2="";}

                    if ($nil < 0){
                    	$b1="("; $nil=$nil*-1; $b2=")";}
                    else {
                    	$b1=""; $b2="";}

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil;
                    }

                    $nilai    = number_format($nil,"2",".",",");
                    $angnilai = number_format($angnil,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai=='' or $angnilai==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil/$angnil)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                   
                   $cRet    .= "<tr>
                                     <td width=\"8%\" align=\"center\" style=\"border:none;\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"37%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$a1$angnilai$a2<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$b1$nilai$b2<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";         
              
        $cRet .=       " </table>";
        $data['prev']= $cRet;
		 $cRet         .= "</table>";
		 /*
		 if($txt==1){
		 $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> Mengetahui,</td>
		 <td align=\"center\" width=\"50%\"> Sanggau, $ctgl_ttd </td>
		 </tr>		
		 <tr>
		 <td align=\"center\" width=\"50%\"> $jabatan </td>
		 <td align=\"center\" width=\"50%\"> $jabatan1 </td>
		 </tr>	
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		  <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> $oioi</td>
		 <td align=\"center\" width=\"50%\"> $oioi1 </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> NIP :$nip</td>
		 <td align=\"center\" width=\"50%\"> NIP :$nip1</td>
		 </tr>
         </table>
		 ";}*/
		$data['prev'] = $cRet;
        $data['sikap'] = 'preview';
        $judul  = 'LAPORAN REALISASI ANGGARAN';
        $this->template->set('title', 'CETAK LAPORAN REALISASI ANGGARAN');        
        switch($cetak) {
		case 1;
			 echo ("<title>L R A</title>"); 
             echo $cRet;
        break;		
        case 0;
             $this->_mpdf_down('',$cRet,10,10,10,'0',0,'','LRA Penjabaran format13 '.$skpd.'');
        break;
        case 2;        
            header("Cache-Control: no-cache, no-store, must-revalidate");
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename= $judul.xls");
            
            $this->load->view('anggaran/rka/perkadaII', $data);
        break;
        case 3;     
            header("Cache-Control: no-cache, no-store, must-revalidate");
            header("Content-Type: application/vnd.ms-word");
            header("Content-Disposition: attachment; filename= $judul.doc");
            $this->load->view('anggaran/rka/perkadaII', $data);
        break;
        } 
    }
    
     function cetak_lra_bulan_penjabaran_ang_skpd($cbulan='', $cetak='', $txt=''){
	        $txt="1";
			$tanggalttd = $this->uri->segment(5);
            $ttd1 = str_replace('a',' ',$this->uri->segment(6));
            $ttd2 = str_replace('a',' ',$this->uri->segment(7));
            $ctgl_ttd = $this->tukd_model->tanggal_format_indonesia($tanggalttd);
            $bulan = strtoupper($this->tukd_model->getBulan($cbulan));
			$skpd = $this->session->userdata('kdskpd'); 
			$sql1 = "SELECT nm_skpd FROM ms_skpd WHERE kd_skpd='$skpd'";
			$ivan = $this->db->query($sql1);
			$oioi = $ivan->row();
			$nmskpd = $oioi->nm_skpd;
			$realpend=0;
			$anggpend=0;
			
            $sqldns="SELECT a.kd_urusan as kd_u,b.nm_urusan as nm_u,a.kd_skpd as kd_sk,a.nm_skpd as nm_sk FROM ms_skpd a INNER JOIN ms_urusan b ON a.kd_urusan=b.kd_urusan WHERE kd_skpd='$skpd'";
                 $sqlskpd=$this->db->query($sqldns);
                 foreach ($sqlskpd->result() as $rowdns)
                {                  
                    $kd_urusan=$rowdns->kd_u;                    
                    $nm_urusan= $rowdns->nm_u;
                    $kd_skpd  = $rowdns->kd_sk;
                    $nm_skpd  = $rowdns->nm_sk;
                }
            
            $sqlanggaran1="select case when statu=1 and status_sempurna=1 and status_ubah=1 and $cbulan>=month(tgl_dpa_ubah) then 2 
					   when statu=1 and status_sempurna=1 and status_ubah=1 and $cbulan>=month(tgl_dpa_sempurna) and $cbulan<month(tgl_dpa_ubah) then 2
					   when statu=1 and status_sempurna=1 and status_ubah=1 and $cbulan<month(tgl_dpa_sempurna) then 2
					   when statu=1 and status_sempurna=1 and status_ubah=0 and $cbulan>=month(tgl_dpa_sempurna) then 2 
					   when statu=1 and status_sempurna=1 and status_ubah=0 and $cbulan<month(tgl_dpa_sempurna) then 2
					   when statu=1 and status_sempurna=0 and status_ubah=0 and $cbulan>=month(tgl_dpa) then 1
					   else 1 end as anggaran from trhrka where kd_skpd='$skpd'";
    $sqlanggaran=$this->db->query($sqlanggaran1);
	foreach ($sqlanggaran->result() as $rowttd)
        {
            $anggaran=$rowttd->anggaran;
        }

	$ag_tox=$anggaran;
            
			$sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab FROM ms_ttd where kd_skpd='$skpd' and kode='PA' and nip='$ttd1'";
            $sqlttd=$this->db->query($sqlttd1);
            foreach ($sqlttd->result() as $rowttd)
			
                {
                    $nip=$rowttd->nip;                    
                    $oioi= $rowttd->nm;
                    $jabatan = $rowttd->jab;
                }			
			
			$sqlttd2="SELECT nama as nm,nip as nip,jabatan as jab FROM ms_ttd where kd_skpd='$skpd' and kode='PPK' and nip='$ttd2'";
            $ttd11=$this->db->query($sqlttd2);
			foreach ($ttd11->result() as $ivan)
			    {
                    $nip1=$ivan->nip;                    
                    $oioi1= $ivan->nm;
                    $jabatan1 = $ivan->jab;
                }
			
       $sqlsc="SELECT tgl_rka,provinsi,kab_kota,daerah,thn_ang FROM sclient where kd_skpd='$skpd'";
                 $sqlsclient=$this->db->query($sqlsc);
                 foreach ($sqlsclient->result() as $rowsc)
                {
                   
                    $tgl=$rowsc->tgl_rka;
                    $tanggal = $this->tukd_model->tanggal_format_indonesia($tgl);
                    $kab     = $rowsc->kab_kota;
                    $daerah  = $rowsc->daerah;
                    $thn     = $rowsc->thn_ang;
                } 
           
        $bersih_skpd= str_replace(".", "", $skpd);
        $print_r = explode(".",$skpd);
        $ke1 = $print_r[0];
        $ke2 = $print_r[1];
        $ke3 = $print_r[2];        
        $ke4 = $print_r[3]; 
        $skkd = $ke1."/".$ke2."/".$ke3;   
            
        $cRet='';
        
        $modtahun= $thn%4;
	 
	 if ($modtahun = 0){
        $nilaibulan=".31 JANUARI.29 FEBRUARI.31 MARET.30 APRIL.31 MEI.30 JUNI.31 JULI.31 AGUSTUS.30 SEPTEMBER.31 OKTOBER.30 NOVEMBER.31 DESEMBER";}
            else {
        $nilaibulan=".31 JANUARI.28 FEBRUARI.31 MARET.30 APRIL.31 MEI.30 JUNI.31 JULI.31 AGUSTUS.30 SEPTEMBER.31 OKTOBER.30 NOVEMBER.31 DESEMBER";}
	 
	 $arraybulan=explode(".",$nilaibulan);
     
        $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
                    <tr>
                         <td align=\"center\"><strong>PEMERINTAH KABUPATEN SANGGAU</strong></td>                         
                    </tr>
					<tr>
                         <td align=\"center\"><strong>RINCIAN LAPORAN REALISASI ANGGARAN MENURUT URUSAN PEMERINTAHAN DAERAH, ORGANISASI<br/>
                                        PENDAPATAN, BELANJA DAN PEMBIAYAAN </strong></td>
                    </tr>                    
                    <tr>
                         <td align=\"center\"><strong>PER $arraybulan[$cbulan] TAHUN $thn</strong></td>
                    </tr>
                    <tr>
                         <td align=\"center\">&nbsp;</td>
                    </tr>
                  </table>";        
        $cRet .="<table style=\"border-collapse:collapse;font-size:13px;\" width=\"100%\" align=\"left\" border=\"0\">
                    <tr>
						<td width=\"5%\"></td>
                        <td width=\"20%\">Urusan Organisasi </td>
                        <td width=\"75%\">:$kd_urusan - $nm_urusan</td>
                    </tr>
                    <tr>
						<td></td>
                        <td>Organisasi</td>
                        <td>:$kd_skpd - $nm_skpd</td>
                    </tr>";
        
        $cRet .= "<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"4\">
                     <thead>                       
                        <tr><td bgcolor=\"#CCCCCC\" width=\"5%\" align=\"center\"><b>NO</b></td>                            
                            <td  bgcolor=\"#CCCCCC\" width=\"45%\" align=\"center\"><b>URAIAN</b></td>
                            <td bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>ANGGARAN</b></td>
                            <td bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>REALISASI</b></td>
                            <td  bgcolor=\"#CCCCCC\" width=\"15%\" align=\"center\" ><b>LEBIH</br>(KURANG)</b></td>
                            <td  bgcolor=\"#CCCCCC\" width=\"5%\" align=\"center\" ><b>%</b></td>   
                        </tr>
                        
                     </thead>
                     <tfoot>
                        <tr>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>                           
                         </tr>
                     </tfoot>
						";
					
					$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b><b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b><b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";	                   	
               $nil4=0;
               $angnil4=0;
               $sql4="
                select z.kode,z.nama,z.anggaran,z.reali from (
                SELECT left(a.kd_ang,1) as kode,b.nm_rek1 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek1 b on b.kd_rek1 = left(a.kd_ang,1)                
                where left(a.kd_ang,1)='4' and kd_skpd = '$skpd'
                group by left(a.kd_ang,1),b.nm_rek1               
                )z order by kode,nama
                ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil4    = $row4->reali;
					$angnil4 = $row4->anggaran;
					
                    $real_s = $angnil4 - $nil4;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil4==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil4;
                    }

                    $nilai4    = number_format($nil4,"2",".",",");
                    $angnilai4 = number_format($angnil4,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai4=='' or $angnilai4==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil4/$angnil4)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                    
               $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">4</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai4<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai4<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                   }   
                   
                   $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                      
               
                $sql4="
                select z.kode,z.nama,z.anggaran,z.reali from (
                SELECT left(a.kd_ang,2) as kode,b.nm_rek2 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek2 b on b.kd_rek2 = left(a.kd_ang,2)                
                where left(a.kd_ang,1)='4' and a.kd_skpd = '$skpd'
                group by left(a.kd_ang,2),b.nm_rek2
                union all
                SELECT left(a.kd_ang,3) as kode,b.nm_rek3 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek3 b on b.kd_rek3 = left(a.kd_ang,3)                
                where left(a.kd_ang,1)='4' and a.kd_skpd = '$skpd'
                group by left(a.kd_ang,3),b.nm_rek3
                union all
                SELECT left(a.kd_ang,5) as kode,b.nm_rek4 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek4 b on b.kd_rek4 = left(a.kd_ang,5)                
                where left(a.kd_ang,1)='4' and a.kd_skpd = '$skpd'
                group by left(a.kd_ang,5),b.nm_rek4
                union all
                 SELECT left(a.kd_ang,7) as kode,b.nm_rek5 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek5 b on b.kd_rek5 = left(a.kd_ang,7)                
                where left(a.kd_ang,1)='4' and a.kd_skpd = '$skpd'
                group by left(a.kd_ang,7),b.nm_rek5
                )z order by kode,nama
                ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil    = $row4->reali;
					$angnil = $row4->anggaran;
					
                    $real_s = $angnil - $nil;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil;
                    }

                    $nilai    = number_format($nil,"2",".",",");
                    $angnilai = number_format($angnil,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai=='' or $angnilai==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil/$angnil)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                   if(strlen("$no")<6){
                    $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                             }else
                             {
					$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">$no</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\">$nama</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\">$x1$selisih$y1</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\">$persen1</td>
                                 </tr>";
                             }
               }
               		$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                       
                        $sql4="
                select z.kode,z.nama,sum(z.anggaran) as anggaran,sum(z.reali) as reali from (
                SELECT left(a.kd_ang,1) as kode,b.nm_rek1 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek1 b on b.kd_rek1 = left(a.kd_ang,1)                
                where left(a.kd_ang,1)='5' and a.kd_skpd = '$skpd'
                group by left(a.kd_ang,1),b.nm_rek1    
                )z group by kode,nama order by kode,nama
                ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil5    = $row4->reali;
					$angnil5 = $row4->anggaran;
					
                    $real_s = $angnil5 - $nil5;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil5==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil5;
                    }

                    $nilai5    = number_format($nil5,"2",".",",");
                    $angnilai5 = number_format($angnil5,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai5=='' or $angnilai5==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil5/$angnil5)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                    
               $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">5</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai5<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai5<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                   }   
                                      
                  	$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";	                   	
               
                   $sql4=" select z.kode,z.nama,sum(z.anggaran) as anggaran,sum(z.reali) as reali from(
                   
  SELECT left(a.kd_ang,2) as kode,b.nm_rek2 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd($cbulan,$ag_tox) a
                inner join ms_rek2 b on b.kd_rek2 = left(a.kd_ang,2)                        
                where left(a.kd_ang,2)='51' and a.kd_skpd = '$skpd'
                group by left(a.kd_ang,2),b.nm_rek2                
 union all
                    
  SELECT left(a.kd_ang,3) as kode,b.nm_rek3 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek3 b on b.kd_rek3 = left(a.kd_ang,3)                        
                where left(a.kd_ang,2)='51' and a.kd_skpd = '$skpd'
                group by left(a.kd_ang,3),b.nm_rek3                
 union all
                
  SELECT left(a.kd_ang,5) as kode,b.nm_rek4 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek4 b on b.kd_rek4 = left(a.kd_ang,5)                        
                where left(a.kd_ang,2)='51' and a.kd_skpd = '$skpd'
                group by left(a.kd_ang,5),b.nm_rek4               
 union all
                
  SELECT left(a.kd_ang,7) as kode,b.nm_rek5 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek5 b on b.kd_rek5 = left(a.kd_ang,7)                        
                where left(a.kd_ang,2)='51' and a.kd_skpd = '$skpd'
                group by left(a.kd_ang,7),b.nm_rek5   
                ) z
                 group by kode,nama order by kode,nama
                ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil    = $row4->reali;
					$angnil = $row4->anggaran;
					
                    $real_s = $angnil - $nil;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil;
                    }

                    $nilai    = number_format($nil,"2",".",",");
                    $angnilai = number_format($angnil,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai=='' or $angnilai==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil/$angnil)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                   if(strlen("$no")<6){
                    $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                             }else
                             {
					$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">$no</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\">$nama</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\">$x1$selisih$y1</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\">$persen1</td>
                                 </tr>";
                             }
               }                                 	                                     
                
                $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                
                 $sql4="
                select z.kode,z.nama,sum(z.anggaran) as anggaran,sum(z.reali) as reali from (
                SELECT left(a.kd_ang,2) as kode,b.nm_rek2 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek2 b on b.kd_rek2 = left(a.kd_ang,2)                
                where left(a.kd_ang,2)='52' and a.kd_skpd = '$skpd'
                group by left(a.kd_ang,2),b.nm_rek2     
                )z group by kode,nama order by kode,nama
                ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil52    = $row4->reali;
					$angnil52 = $row4->anggaran;
					
                    $real_s = $angnil52 - $nil52;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil52==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil52;
                    }

                    $nilai52    = number_format($nil52,"2",".",",");
                    $angnilai52 = number_format($angnil52,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai52=='' or $angnilai52==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil52/$angnil52)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                    
               $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">52</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai52<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai52<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                   }   
                
                	$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";	                   	
               
                   $sql4="
                select z.kd_kegiatan,z.kode,z.nama,sum(z.anggaran) as anggaran,sum(z.reali) as reali from(
            
 SELECT left(a.kd_kegiatan,18) as kd_kegiatan,left(a.kd_kegiatan,18) as kode,b.nm_program as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join m_prog b on b.kd_program = left(a.kd_kegiatan,18)                
                where left(a.kd_ang,2)='52' and a.kd_skpd = '$skpd'
                group by left(a.kd_kegiatan,18),b.nm_program
 union all  
                                  
 SELECT left(a.kd_kegiatan,21) as kd_kegiatan,left(a.kd_kegiatan,21) as kode,b.nm_kegiatan as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join m_giat b on b.kd_kegiatan = left(a.kd_kegiatan,21)                
                where left(a.kd_ang,2)='52' and a.kd_skpd = '$skpd'
                group by left(a.kd_kegiatan,21),b.nm_kegiatan
 union all 
                     
 SELECT left(a.kd_kegiatan,24) as kd_kegiatan,left(a.kd_kegiatan,24) as kode,b.nm_kegiatan as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join m_giat b on b.kd_kegiatan = left(a.kd_kegiatan,24)                
                where left(a.kd_ang,2)='52' and a.kd_skpd = '$skpd'
                group by left(a.kd_kegiatan,24),b.nm_kegiatan
 union all
                
  SELECT left(a.kd_kegiatan,24) as kd_kegiatan,left(a.kd_ang,3) as kode,b.nm_rek3 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek3 b on b.kd_rek3 = left(a.kd_ang,3)                        
                where left(a.kd_ang,2)='52' and a.kd_skpd = '$skpd'
                group by left(a.kd_kegiatan,24),a.nm_kegiatan,left(a.kd_ang,3),b.nm_rek3                
 union all
                
  SELECT left(a.kd_kegiatan,24) as kd_kegiatan,left(a.kd_ang,5) as kode,b.nm_rek4 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek4 b on b.kd_rek4 = left(a.kd_ang,5)                        
                where left(a.kd_ang,2)='52' and a.kd_skpd = '$skpd'
                group by left(a.kd_kegiatan,24),a.nm_kegiatan,left(a.kd_ang,5),b.nm_rek4               
 union all
                            
  SELECT left(a.kd_kegiatan,24) as kd_kegiatan,left(a.kd_ang,7) as kode,b.nm_rek5 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek5 b on b.kd_rek5 = left(a.kd_ang,7)                        
                where left(a.kd_ang,2)='52' and a.kd_skpd = '$skpd'
                group by left(a.kd_kegiatan,24),a.nm_kegiatan,left(a.kd_ang,7),b.nm_rek5     
                ) z
                group by kd_kegiatan,kode,nama
                order by kd_kegiatan,kode,nama
                ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$keg 	= $row4->kd_kegiatan;
                    $no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil    = $row4->reali;
					$angnil = $row4->anggaran;
					
                    $real_s = $angnil - $nil;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil;
                    }

                    $nilai    = number_format($nil,"2",".",",");
                    $angnilai = number_format($angnil,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai=='' or $angnilai==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil/$angnil)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                   if($no==" "){
                    $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>$keg<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                             }else
                             {
					$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">$no</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\">$nama</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\">$x1$selisih$y1</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\">$persen1</td>
                                 </tr>";
                             }
               }                 
                 
                  	$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                 
                 $no 	= '';
					$nama   = 'SURPLUS/DEFISIT';                      
					$nil    = $nil4 - $nil5;
					$angnil = $angnil4 - $angnil5;
					
                    $real_s = $angnil - $nil;

                    if ($angnil < 0){
                    	$a1="("; $angnil=$angnil*-1; $a2=")";}
                    else {
                    	$a1=""; $a2="";}

                    if ($nil < 0){
                    	$b1="("; $nil=$nil*-1; $b2=")";}
                    else {
                    	$b1=""; $b2="";}

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil;
                    }

                    $nilai    = number_format($nil,"2",".",",");
                    $angnilai = number_format($angnil,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai=='' or $angnilai==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil/$angnil)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                   
                   $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$a1$angnilai$a2<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$b1$nilai$b2<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";         
              
        $cRet .=       " </table>";
        $data['prev']= $cRet;
		 $cRet         .= "</table>";
		 
		 if($txt==1){
		 $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> Mengetahui,</td>
		 <td align=\"center\" width=\"50%\"> Sanggau, $ctgl_ttd </td>
		 </tr>		
		 <tr>
		 <td align=\"center\" width=\"50%\"> $jabatan </td>
		 <td align=\"center\" width=\"50%\"> $jabatan1 </td>
		 </tr>	
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		  <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> $oioi</td>
		 <td align=\"center\" width=\"50%\"> $oioi1 </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> NIP :$nip</td>
		 <td align=\"center\" width=\"50%\"> NIP :$nip1</td>
		 </tr>
         </table>
		 ";}
		$data['prev'] = $cRet;
        $data['sikap'] = 'preview';
        $judul  = 'LAPORAN REALISASI ANGGARAN';
        $this->template->set('title', 'CETAK LAPORAN REALISASI ANGGARAN');        
        switch($cetak) {
		case 1;
			 echo ("<title>L R A</title>"); 
             echo $cRet;
        break;		
        case 0;
             $this->tukd_model->_mpdf('',$cRet,10,10,10,'P');
        break;
        case 2;        
            header("Cache-Control: no-cache, no-store, must-revalidate");
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename= $judul.xls");
            
            $this->load->view('anggaran/rka/perkadaII', $data);
        break;
        case 3;     
            header("Cache-Control: no-cache, no-store, must-revalidate");
            header("Content-Type: application/vnd.ms-word");
            header("Content-Disposition: attachment; filename= $judul.doc");
            $this->load->view('anggaran/rka/perkadaII', $data);
        break;
        } 
    }
  
  //perda
  function cetak_perda1_real($cetak='', $cbulan='', $txt=''){
	        $cbulan='12'; 
            $txt="1";
			$bulan = strtoupper($this->tukd_model->getBulan($cbulan));
			$skpd = $this->session->userdata('kdskpd'); 
			$sql1 = "SELECT nm_skpd FROM ms_skpd WHERE kd_skpd='$skpd'";
			$ivan = $this->db->query($sql1);
			$oioi = $ivan->row();
			$nmskpd = $oioi->nm_skpd;
			$realpend=0;
			$anggpend=0;
			
            $sqldns="SELECT a.kd_urusan as kd_u,b.nm_urusan as nm_u,a.kd_skpd as kd_sk,a.nm_skpd as nm_sk FROM ms_skpd a INNER JOIN ms_urusan b ON a.kd_urusan=b.kd_urusan WHERE kd_skpd='$skpd'";
                 $sqlskpd=$this->db->query($sqldns);
                 foreach ($sqlskpd->result() as $rowdns)
                {
                    $kd_urusan2=$rowdns->kd_u;                    
                    $nm_urusan2= $rowdns->nm_u;
                    $kd_skpd2  = $rowdns->kd_sk;
                    $nm_skpd2  = $rowdns->nm_sk;
                }
            
            $sqlanggaran1="select case when statu=1 and status_sempurna=1 and status_ubah=1 and $cbulan>=month(tgl_dpa_ubah) then 2 
					   when statu=1 and status_sempurna=1 and status_ubah=1 and $cbulan>=month(tgl_dpa_sempurna) and $cbulan<month(tgl_dpa_ubah) then 1
					   when statu=1 and status_sempurna=1 and status_ubah=1 and $cbulan<month(tgl_dpa_sempurna) then 1
					   when statu=1 and status_sempurna=1 and status_ubah=0 and $cbulan>=month(tgl_dpa_sempurna) then 1 
					   when statu=1 and status_sempurna=1 and status_ubah=0 and $cbulan<month(tgl_dpa_sempurna) then 1
					   when statu=1 and status_sempurna=0 and status_ubah=0 and $cbulan>=month(tgl_dpa) then 1
					   else 1 end as anggaran from trhrka where kd_skpd='$skpd'";
    $sqlanggaran=$this->db->query($sqlanggaran1);
	foreach ($sqlanggaran->result() as $rowttd)
        {
            $anggaran=$rowttd->anggaran;
        }

	$ag_tox=$anggaran;
            
			$sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab FROM ms_ttd where kd_skpd='$skpd' and kode='PA'";
            $sqlttd=$this->db->query($sqlttd1);
            foreach ($sqlttd->result() as $rowttd)
			
                {
                    $nip=$rowttd->nip;                    
                    $oioi= $rowttd->nm;
                    $jabatan = $rowttd->jab;
                }			
			
			$sqlttd2="SELECT nama as nm,nip as nip,jabatan as jab FROM ms_ttd where kd_skpd='$skpd' and kode='PT'";
            $ttd11=$this->db->query($sqlttd2);
			foreach ($ttd11->result() as $ivan)
			    {
                    $nip1=$ivan->nip;                    
                    $oioi1= $ivan->nm;
                    $jabatan1 = $ivan->jab;
                }
			
       $sqlsc="SELECT tgl_rka,provinsi,kab_kota,daerah,thn_ang FROM sclient where kd_skpd='$skpd'";
                 $sqlsclient=$this->db->query($sqlsc);
                 foreach ($sqlsclient->result() as $rowsc)
                {
                   
                    $tgl=$rowsc->tgl_rka;
                    $tanggal = $this->tukd_model->tanggal_format_indonesia($tgl);
                    $kab     = $rowsc->kab_kota;
                    $daerah  = $rowsc->daerah;
                    $thn     = $rowsc->thn_ang;
                } 
           
        $bersih_skpd= str_replace(".", "", $skpd);
        $print_r = explode(".",$skpd);
        $ke1 = $print_r[0];
        $ke2 = $print_r[1];
        $ke3 = $print_r[2];        
        $ke4 = $print_r[3]; 
        $skkd = $ke1."/".$ke2."/".$ke3;   
            
        $cRet='';
        
       
        $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
                    <tr>
                         <td align=\"center\"><strong>PEMERINTAH KABUPATEN SANGGAU</strong></td>                         
                    </tr>					
                    <tr>
                         <td align=\"center\"><strong>RINGKASAN REALISASI APBD</strong></td>
                    </tr>                    
                    <tr>
                         <td align=\"center\"><strong>TAHUN ANGGARAN $thn</strong></td>
                    </tr>
                    <tr>
                         <td align=\"center\">&nbsp;</td>
                    </tr>
                  </table><br/>";        
        
        
         $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"left\" border=\"0\">
                        <tr>
                            <td width=\"20%\">Urusan Organisasi </td>
                            <td width=\"80%\">: $kd_urusan2 - $nm_urusan2</td>
                        </tr>
                        <tr>
                            <td>Organisasi</td>
                            <td>: $kd_skpd2 - $nm_skpd2 </td>
                        </tr>
                    
                    </table>";    
        
        $cRet .= "<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"4\">
                     <thead>                       
                        <tr><td rowspan=\"2\" bgcolor=\"#CCCCCC\" width=\"5%\" align=\"center\"><b>NO</b></td>                            
                            <td rowspan=\"2\" bgcolor=\"#CCCCCC\" width=\"40%\" align=\"center\"><b>URAIAN</b></td>
                            <td colspan=\"2\" bgcolor=\"#CCCCCC\" width=\"40%\" align=\"center\"><b>JUMLAH</b></td>                            
                            <td rowspan=\"2\" bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\" ><b>LEBIH</br>(KURANG)</b></td>
                            <td rowspan=\"2\" bgcolor=\"#CCCCCC\" width=\"8%\" align=\"center\" ><b>%</b></td>   
                        </tr>  
                        <tr>
                            <td bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>ANGGARAN</b></td>                            
                            <td bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\" ><b>REALISASI</b></td>                            
                        </tr>                      
                     </thead>
                     <tfoot>
                        <tr>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>                           
                         </tr>
                     </tfoot>
						";
					
					$cRet    .= "                           
                         <tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>4<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"40%\"><b>PENDAPATAN<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"8%\" align=\"right\"></td>
                                 </tr>";	                   	
               
                $sql4="
                select z.kode,z.nama,z.anggaran,z.reali from (
                SELECT left(a.kd_ang,2) as kode,b.nm_rek2 as nama,sum(a.anggaran) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg2( $cbulan,$ag_tox) a
                inner join ms_rek2 b on b.kd_rek2 = left(a.kd_ang,2)                
                where left(a.kd_ang,1)='4' and left(kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_ang,2),b.nm_rek2
                union all
                SELECT left(a.kd_ang,3) as kode,b.nm_rek3 as nama,sum(a.anggaran) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg2( $cbulan,$ag_tox) a
                inner join ms_rek3 b on b.kd_rek3 = left(a.kd_ang,3)                
                where left(a.kd_ang,1)='4' and left(kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_ang,3),b.nm_rek3              
                )z order by kode,nama
                ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil    = $row4->reali;
					$angnil = $row4->anggaran;
					
                    $real_s = $angnil - $nil;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil;
                    }

                    $nilai    = number_format($nil,"2",".",",");
                    $angnilai = number_format($angnil,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai=='' or $angnilai==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil/$angnil)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                   if(strlen("$no")<4){
                    $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"40%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"8%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                             }else
                             {
					$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">$no</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"40%\">$nama</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$x1$selisih$y1</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"8%\" align=\"right\">$persen1</td>
                                 </tr>";
                             }
               }
               		$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"40%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"8%\" align=\"right\"></td>
                                 </tr>";
                 $nil4=0;   
                 $angnil4=0;
                    $sql4="
                select z.kode,z.nama,z.anggaran,z.reali from (
                SELECT left(a.kd_ang,1) as kode,b.nm_rek1 as nama,sum(a.anggaran) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg2( $cbulan,$ag_tox) a
                inner join ms_rek1 b on b.kd_rek1 = left(a.kd_ang,1)                
                where left(a.kd_ang,1)='4' and left(kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_ang,1),b.nm_rek1               
                )z order by kode,nama
                ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil4    = $row4->reali;
					$angnil4 = $row4->anggaran;
					
                    $real_s = $angnil4 - $nil4;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil4==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil4;
                    }

                    $nilai4    = number_format($nil4,"2",".",",");
                    $angnilai4 = number_format($angnil4,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai4=='' or $angnilai4==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil4/$angnil4)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                    
               $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"40%\"><b>JUMLAH $nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai4<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai4<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"8%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                   }   
                   
                   $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"40%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"8%\" align=\"right\"></td>
                                 </tr>";
                      
                   	$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>5<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"40%\"><b>BELANJA<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"8%\" align=\"right\"></td>
                                 </tr>";	                   	
               
                   $sql4="
                select z.kode,z.nama,sum(z.anggaran) as anggaran,sum(z.reali) as reali from (
                SELECT left(a.kd_ang,2) as kode,b.nm_rek2 as nama,0 as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg2( $cbulan,$ag_tox) a
                inner join ms_rek2 b on b.kd_rek2 = left(a.kd_ang,2)                
                where left(a.kd_ang,1)='5' and left(kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_ang,2),b.nm_rek2
                union all
                
                SELECT left(a.kd_ang,2) as kode,b.nm_rek2 as nama,sum(a.nilai_ang) as anggaran,0 as reali FROM data_realisasi_keg3( $cbulan,$ag_tox) a
                inner join ms_rek2 b on b.kd_rek2 = left(a.kd_ang,2)
                where left(a.kd_ang,1)='5' and left(kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_ang,2),b.nm_rek2
                
                union all
                
                SELECT left(a.kd_ang,3) as kode,b.nm_rek3 as nama,0 as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg2( $cbulan,$ag_tox) a
                inner join ms_rek3 b on b.kd_rek3 = left(a.kd_ang,3)                
                where left(a.kd_ang,1)='5' and left(kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_ang,3),b.nm_rek3
                union all
                
                SELECT left(a.kd_ang,3) as kode,b.nm_rek3 as nama,sum(a.nilai_ang) as anggaran,0 as reali FROM data_realisasi_keg3( $cbulan,$ag_tox) a
                inner join ms_rek3 b on b.kd_rek3 = left(a.kd_ang,3)                
                where left(a.kd_ang,1)='5' and left(kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_ang,3),b.nm_rek3
           
                )z 
                group by kode,nama
                order by kode,nama
                ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil    = $row4->reali;
					$angnil = $row4->anggaran;
					
                    $real_s = $angnil - $nil;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil;
                    }

                    $nilai    = number_format($nil,"2",".",",");
                    $angnilai = number_format($angnil,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai=='' or $angnilai==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil/$angnil)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                   if(strlen("$no")<4){
                    $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"40%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"8%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                             }else
                             {
					$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">$no</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"40%\">$nama</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$x1$selisih$y1</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"8%\" align=\"right\">$persen1</td>
                                 </tr>";
                             }
               }  
               
                		$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"40%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"8%\" align=\"right\"></td>
                                 </tr>";
                    
                    $sql4="
                select z.kd_skpd,z.kode,z.nama,sum(z.anggaran) as anggaran,sum(z.reali) as reali from (
                SELECT left(a.kd_skpd,7) as kd_skpd,left(a.kd_ang,1) as kode,'BELANJA' as nama,0 as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg2( $cbulan,$ag_tox) a
                where left(a.kd_ang,1)='5' and left(a.kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_skpd,7),left(a.kd_ang,1)       
                union all
                SELECT left(a.kd_skpd,7) as kd_skpd,left(a.kd_ang,1) as kode,'BELANJA' as nama,sum(nilai_ang) as anggaran,0 as reali FROM data_realisasi_keg3( $cbulan,$ag_tox) a
                where left(a.kd_ang,1)='5' and left(a.kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_skpd,7),left(a.kd_ang,1)) z
                group by z.kd_skpd,z.kode,z.nama
                order by z.kode,z.nama
                ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil5    = $row4->reali;
					$angnil5 = $row4->anggaran;                                     
                    
                    $real_s = $angnil5 - $nil5;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil5==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil5;
                    }

                    $nilai5    = number_format($nil5,"2",".",",");
                    $angnilai5 = number_format($angnil5,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai5=='' or $angnilai5==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil5/$angnil5)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                
               	$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"40%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"8%\" align=\"right\"></td>
                                 </tr>";
                     
                    
               $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"40%\"><b>JUMLAH $nama <b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai5<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai5<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"8%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                   }   
                 
                  	$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"40%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"8%\" align=\"right\"></td>
                                 </tr>";
                 
                 $no 	= '';
					$nama   = 'SURPLUS/DEFISIT';                      
					$nil    = $nil4 - $nil5;
					$angnil = $angnil4 - $angnil5;
					
                    $real_s = $angnil - $nil;

                    if ($angnil < 0){
                    	$a1="("; $angnil=$angnil*-1; $a2=")";}
                    else {
                    	$a1=""; $a2="";}

                    if ($nil < 0){
                    	$b1="("; $nil=$nil*-1; $b2=")";}
                    else {
                    	$b1=""; $b2="";}

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil;
                    }

                    $nilai    = number_format($nil,"2",".",",");
                    $angnilai = number_format($angnil,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai=='' or $angnilai==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil/$angnil)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                   
                   $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"40%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$a1$angnilai$a2<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$b1$nilai$b2<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"8%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";         
              
        $cRet .=       " </table>";
        $data['prev']= $cRet;
		 $cRet         .= "</table>";
		 
		 if($txt==1){
		 $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> </td>
		 <td align=\"center\" width=\"50%\"> Sanggau,31 Desember $thn </td>
		 </tr>		
		 <tr>
		 <td align=\"center\" width=\"50%\">  </td>
		 <td align=\"center\" width=\"50%\"> $jabatan </td>
		 </tr>	
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		  <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"></td>
		 <td align=\"center\" width=\"50%\"> $oioi </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> </td>
		 <td align=\"center\" width=\"50%\"> NIP :$nip </td>
		 </tr>
         </table>
		 ";}
		$data['prev'] = $cRet;
        $data['sikap'] = 'preview';
        $judul  = 'LAPORAN REALISASI ANGGARAN';
        $this->template->set('title', 'CETAK LAPORAN REALISASI ANGGARAN');        
        switch($cetak) {
		case 1;
			 $this->tukd_model->_mpdf('',$cRet,10,10,10,'P');
       	   //$this->_mpdf_down('',$cRet,10,10,10,'0',0,'','PERDA LRA '.$skpd.''); 
        break;		
        case 0;
            echo ("<title>L R A</title>"); 
             echo $cRet;            
        break;
        case 2;        
            header("Cache-Control: no-cache, no-store, must-revalidate");
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename= $judul.xls");
            
            $this->load->view('anggaran/rka/perkadaII', $data);
        break;
        case 3;     
            header("Cache-Control: no-cache, no-store, must-revalidate");
            header("Content-Type: application/vnd.ms-word");
            header("Content-Disposition: attachment; filename= $judul.doc");
            $this->load->view('anggaran/rka/perkadaII', $data);
        break;
        } 
    }
  
  function cetak_perdaII_real($cetak=0){
        //$cetak =   $this->uri->segment(3);           
        $sqlsc="SELECT tgl_rka,provinsi,kab_kota,daerah,thn_ang FROM sclient";
                 $sqlsclient=$this->db->query($sqlsc);
                 foreach ($sqlsclient->result() as $rowsc)
                {                   
                    $tgl=$rowsc->tgl_rka;
                    $tanggal = $this->tukd_model->tanggal_format_indonesia($tgl);
                    $kab     = $rowsc->kab_kota;
                    $daerah  = $rowsc->daerah;
                    $thn     = $rowsc->thn_ang;
                }
                
        $cRet  ='';
         if ($cetak <> 0) {
        $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
                    <tr>
                         <td rowspan=\"3\" align=\"left\" width=\"60%\"><strong></strong></td>
                         <td rowspan=\"3\" valign =\"top\" align=\"left\" width=\"10%\"><strong><h5>LAMPIRAN II  :</h6></strong></td>
                         <td colspan=\"2\" align=\"left\" width=\"30%\"><strong><h5>PERATURAN DAERAH</strong></h5></td>
                    </tr>
                    <tr> 
                         <td align=\"left\" width=\"10%\"><h5>NOMOR</h5></td><td width=\"20%\" align=\"left\" ><h5>:</h5></td>
                    </tr>
                    <tr>
                        <td style=\"border-bottom: solid 1px black;\" align=\"left\" width=\"10%\"><h5>TANGGAL</h5></td><td style=\"border-bottom: solid 1px black;\" align=\"left\" width=\"20%\"><h5>:</h5></td>
                    </tr>
                                         
                   
                  </table>"; 
            }  
        $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
                    <tr>
                         <td align=\"center\" width=\"100%\"><strong>$kab</strong></td>
                         
                    </tr>
                    <tr>
                         <td align=\"center\" width=\"100%\"><strong>REALISASI APBD </strong></td>
                    </tr>
                    
                    <tr>
                         <td align=\"center\" width=\"100%\"><strong>TAHUN ANGARAN $thn</strong></td>
                    </tr>

                  </table>";  
        
        $cRet .= "<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"4\">
                     <thead>                       
                        <tr><td rowspan=\"3\" bgcolor=\"#CCCCCC\" width=\"5%\" align=\"center\"><b>KODE</b></td>                            
                            <td rowspan=\"3\" bgcolor=\"#CCCCCC\" width=\"15%\" align=\"center\"><b>URUSAN PEMERINTAH DAERAH</b></td>
                            <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" bgcolor=\"#CCCCCC\" width=\"26%\" align=\"center\" colspan=\"4\"><b>PENDAPATAN</b></td>
                            <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" bgcolor=\"#CCCCCC\" width=\"54%\" align=\"center\" colspan=\"8\"><b>BELANJA</b></td>
                        </tr>
                        <tr>
 		                    <td rowspan=\"2\" width=\"7%\" bgcolor=\"#CCCCCC\" align=\"center\">SETELAH<br>PERUBAHAN</td>
                            <td rowspan=\"2\" width=\"7%\" bgcolor=\"#CCCCCC\" align=\"center\">REALISASI</td>
                            <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" colspan=\"2\" width=\"12%\" bgcolor=\"#CCCCCC\" align=\"center\">LEBIH(KURANG)</td>
                            <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\"colspan=\"3\" width=\"21%\" bgcolor=\"#CCCCCC\" align=\"center\">SETELAH PERUBAHAN</td>
                            <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\"colspan=\"3\" width=\"21%\" bgcolor=\"#CCCCCC\" align=\"center\">REALISASI</td>
                            <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\"colspan=\"2\" width=\"12%\" bgcolor=\"#CCCCCC\" align=\"center\">LEBIH</br>(KURANG)</td>
                        </tr>
                        <tr>
                             <td bgcolor=\"#CCCCCC\" width=\"7%\" align=\"center\" >(RP.)</td>
                             <td bgcolor=\"#CCCCCC\" width=\"5%\" align=\"center\" >%</td>
                             <td bgcolor=\"#CCCCCC\" width=\"7%\" align=\"center\" >Tidak Langsung</td>
                             <td bgcolor=\"#CCCCCC\" width=\"7%\" align=\"center\" >Langsung</td>
                             <td bgcolor=\"#CCCCCC\" width=\"7%\" align=\"center\" >Jumlah</td>
                             <td bgcolor=\"#CCCCCC\" width=\"7%\" align=\"center\" >Tidak Langsung</td>
                             <td bgcolor=\"#CCCCCC\" width=\"7%\" align=\"center\" >Langsung</td>
                             <td bgcolor=\"#CCCCCC\" width=\"7%\" align=\"center\" >Jumlah</td>
                             <td bgcolor=\"#CCCCCC\" width=\"7%\" align=\"center\" >(RP.)</td>
                             <td bgcolor=\"#CCCCCC\" width=\"5%\" align=\"center\" >%</td>
                        </tr>    
                     </thead>
                    
                     
                        <tr><td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"5%\" >&nbsp;</td>                            
                            <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"15%\">&nbsp;</td>
                            <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"7%\">&nbsp;</td>
                            <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"7%\">&nbsp;</td>
                            <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"7%\">&nbsp;</td>
                            <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"5%\">&nbsp;</td>
                            <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"7%\">&nbsp;</td>
                            <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"7%\">&nbsp;</td>
                            <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"7%\">&nbsp;</td>
                            <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"7%\">&nbsp;</td>
                            <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"7%\">&nbsp;</td>
                            <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"7%\">&nbsp;</td>
                            <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"7%\">&nbsp;</td>
                            <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"5%\">&nbsp;</td>
                        </tr>
                        ";
$sql1="select z.kode,z.kode2,z.nama,z.nilaiang_4,z.nilaireal_4,z.nilaiang_51,z.nilaireal_51,z.nilaiang_52,z.nilaireal_52 from (
select k.kd_urusan1 as kode,k.kd_urusan1 as kode2, k.nm_urusan1 as nama, 
(SELECT isnull(sum(a.nilai_ang),0) as nilai FROM data_realisasi_keg4( $cbulan,$ag_tox) a where left(a.kd_ang,1)='4' and left(kd_skpd,1) = k.kd_urusan1) as nilaiang_4,
(SELECT isnull(sum(a.real_spj),0) as nilai FROM data_realisasi_keg4( $cbulan,$ag_tox) a where left(a.kd_ang,1)='4' and left(kd_skpd,1) = k.kd_urusan1) as nilaireal_4,
(SELECT isnull(sum(a.nilai_ang),0) as nilai FROM data_realisasi_keg4( $cbulan,$ag_tox) a where left(a.kd_ang,2)='51' and left(kd_skpd,1) = k.kd_urusan1) as nilaiang_51,
(SELECT isnull(sum(a.real_spj),0) as nilai FROM data_realisasi_keg4( $cbulan,$ag_tox) a where left(a.kd_ang,2)='51' and left(kd_skpd,1) = k.kd_urusan1) as nilaireal_51,
(SELECT isnull(sum(a.nilai_ang),0) as nilai FROM data_realisasi_keg4($cbulan,$ag_tox) a where left(a.kd_ang,2)='52' and left(kd_skpd,1) = k.kd_urusan1) as nilaiang_52,
(SELECT isnull(sum(a.real_spj),0) as nilai FROM data_realisasi_keg4( $cbulan,$ag_tox) a where left(a.kd_ang,2)='52' and left(kd_skpd,1) = k.kd_urusan1) as nilaireal_52
from ms_urusan1 k GROUP BY k.kd_urusan1 ,k.nm_urusan1
union all
select k.kd_urusan as kode,k.kd_urusan as kode2, k.nm_urusan as nama, 
(SELECT isnull(sum(a.nilai_ang),0) as nilai FROM data_realisasi_keg4( $cbulan,$ag_tox) a where left(a.kd_ang,1)='4' and left(kd_subkegiatan,4) = k.kd_urusan) as nilaiang_4,
(SELECT isnull(sum(a.real_spj),0) as nilai FROM data_realisasi_keg4( $cbulan,$ag_tox) a where left(a.kd_ang,1)='4' and left(kd_subkegiatan,4) = k.kd_urusan) as nilaireal_4,
(SELECT isnull(sum(a.nilai_ang),0) as nilai FROM data_realisasi_keg4($cbulan,$ag_tox) a where left(a.kd_ang,2)='51' and left(kd_subkegiatan,4) = k.kd_urusan) as nilaiang_51,
(SELECT isnull(sum(a.real_spj),0) as nilai FROM data_realisasi_keg4( $cbulan,$ag_tox) a where left(a.kd_ang,2)='51' and left(kd_subkegiatan,4) = k.kd_urusan) as nilaireal_51,
(SELECT isnull(sum(a.nilai_ang),0) as nilai FROM data_realisasi_keg4( $cbulan,$ag_tox) a where left(a.kd_ang,2)='52' and left(kd_subkegiatan,4) = k.kd_urusan) as nilaiang_52,
(SELECT isnull(sum(a.real_spj),0) as nilai FROM data_realisasi_keg4( $cbulan,$ag_tox) a where left(a.kd_ang,2)='52' and left(kd_subkegiatan,4) = k.kd_urusan) as nilaireal_52
from ms_urusan k GROUP BY k.kd_urusan ,k.nm_urusan
union all
select left(k.kd_subkegiatan,12) as kode,substring(k.kd_subkegiatan,6,7) as kode2, c.nm_skpd as nama, 
(SELECT isnull(sum(a.nilai_ang),0) as nilai FROM data_realisasi_keg4($cbulan,$ag_tox) a where left(a.kd_ang,1)='4' and left(kd_subkegiatan,12) = left(k.kd_subkegiatan,12)) as nilaiang_4,
(SELECT isnull(sum(a.real_spj),0) as nilai FROM data_realisasi_keg4( $cbulan,$ag_tox) a where left(a.kd_ang,1)='4' and left(kd_subkegiatan,12) = left(k.kd_subkegiatan,12)) as nilaireal_4,
(SELECT isnull(sum(a.nilai_ang),0) as nilai FROM data_realisasi_keg4( $cbulan,$ag_tox) a where left(a.kd_ang,2)='51' and left(kd_subkegiatan,12) = left(k.kd_subkegiatan,12)) as nilaiang_51,
(SELECT isnull(sum(a.real_spj),0) as nilai FROM data_realisasi_keg4($cbulan,$ag_tox) a where left(a.kd_ang,2)='51' and left(kd_subkegiatan,12) = left(k.kd_subkegiatan,12)) as nilaireal_51,
(SELECT isnull(sum(a.nilai_ang),0) as nilai FROM data_realisasi_keg4($cbulan,$ag_tox) a where left(a.kd_ang,2)='52' and left(kd_subkegiatan,12) = left(k.kd_subkegiatan,12)) as nilaiang_52,
(SELECT sum(a.real_spj) as nilai FROM data_realisasi_keg4( $cbulan,$ag_tox) a where left(a.kd_ang,2)='52' and left(kd_subkegiatan,12) = left(k.kd_subkegiatan,12)) as nilaireal_52
from data_realisasi_keg4($cbulan,$ag_tox) k left join ms_skpd c on c.kd_skpd = k.kd_skpd
where RIGHT(c.kd_skpd,2)='00'
GROUP BY left(k.kd_subkegiatan,12),substring(k.kd_subkegiatan,6,7),c.nm_skpd
union all
select '0' as kode,'0' as kode2, 'JUMLAH' as nama, 
(SELECT isnull(sum(a.nilai_ang),0) as nilai FROM data_realisasi_keg4($cbulan,$ag_tox2) a where left(a.kd_ang,1)='4') as nilaiang_4,
(SELECT isnull(sum(a.real_spj),0) as nilai FROM data_realisasi_keg4($cbulan,$ag_tox) a where left(a.kd_ang,1)='4' ) as nilaireal_4,
(SELECT isnull(sum(a.nilai_ang),0) as nilai FROM data_realisasi_keg4($cbulan,$ag_tox) a where left(a.kd_ang,2)='51') as nilaiang_51,
(SELECT isnull(sum(a.real_spj),0) as nilai FROM data_realisasi_keg4($cbulan,$ag_tox) a where left(a.kd_ang,2)='51' ) as nilaireal_51,
(SELECT isnull(sum(a.nilai_ang),0) as nilai FROM data_realisasi_keg4($cbulan,$ag_tox) a where left(a.kd_ang,2)='52' ) as nilaiang_52,
(SELECT isnull(sum(a.real_spj),0) as nilai FROM data_realisasi_keg4($cbulan,$ag_tox) a where left(a.kd_ang,2)='52' ) as nilaireal_52
from ms_urusan1 k where k.kd_urusan1='1'
)z order by z.kode
";
                 
                $query = $this->db->query($sql1);                                 
                foreach ($query->result() as $row)
                {
                    $kode       =$row->kode;
                    $kode       =$row->kode;
                    $nama       =$row->nama;
                    $ang_4      =$row->nilaiang_4;                    
                    $real_4     =$row->nilaireal_4; 
                    $pend       =number_format($ang_4,"2",",",".");
                    $pend_real  =number_format($real_4,"2",",",".");
                    $selisih_4  = $real_4 - $ang_4;
                    if ($selisih_4 < 0){
                    	$x="(";
                    	$selisih_4=$selisih_4*-1;
                    	$y=")";}
                    else {
                    	$x="";
    	                $y="";}
                    $sel_4      = number_format($selisih_4,"2",",",".");  
                    $per_4      = ($selisih_4!=0)?($selisih_4 / $ang_4 ) * 100:0; 
                    $persen_4   = number_format($per_4);    
                    
                    $ang_51     =$row->nilaiang_51;                   
                    $real_btl   =$row->nilaireal_51;    
                    $ang_52     =$row->nilaiang_52;
                    $real_bl    =$row->nilaireal_52;
                    $jum_5      =$ang_51 + $ang_52;
                    $jum_5_real =$real_btl + $real_bl;
                    $btl        = number_format($ang_51,"2",",",".");
                    $bl         = number_format($ang_52,"2",",",".");
                    $jum        = number_format($jum_5,"2",",",".");
                    $btl_real   = number_format($real_btl,"2",",",".");
                    $bl_real    = number_format($real_bl,"2",",",".");
                    $jum_real   = number_format($jum_5_real,"2",",",".");
                    $selisih_5  = $jum_5_real - $jum_5 ;
                    if ($selisih_5 < 0){
                    	$x1="(";
                    	$selisih_5=$selisih_5*-1;
                    	$y1=")";}
                    else {
                    	$x1="";
    	                $y1="";}
                    $sel_5 = number_format($selisih_5,"2",",",".");  
                    $per_5   = ($selisih_5!=0)?($selisih_5 / $jum_5 ) * 100:0; 
                    $persen_5= number_format($per_5);    
                    
                     $cRet    .= "<tr>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" align=\"left\" width=\"5%\">$kode</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" align=\"left\" width=\"15%\">$nama</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" align=\"right\" width=\"7%\">$pend</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" align=\"right\" width=\"7%\">$pend_real</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" align=\"right\" width=\"7%\">$x$sel_4$y</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" align=\"right\" width=\"5%\">$persen_4</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" align=\"right\" width=\"7%\">$btl</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" align=\"right\" width=\"7%\">$bl</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" align=\"right\" width=\"7%\">$jum</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" align=\"right\" width=\"7%\">$btl_real</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" align=\"right\" width=\"7%\">$bl_real</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" align=\"right\" width=\"7%\">$jum_real</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" align=\"right\" width=\"7%\">$x1$sel_5$y1</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" align=\"right\" width=\"5%\">$persen_5</td>
                                </tr>
                                     ";
                
        
                  }  

        $cRet          .=       " </table>";
        $judul = 'Laporan Realisasi APBD  Lamp II';
        $data['prev']  = $cRet;
        $this->template->set('title', 'CETAK PERDA REALISASI LAMPIRAN II');
        switch($cetak) {        
        case 1;
             $this->tukd_model->_mpdf('',$cRet,10,10,10,'L');
        break;
        case 0;
              echo ("<title>L R A</title>"); 
             echo $cRet;
        break;
        case 2;        
            header("Cache-Control: no-cache, no-store, must-revalidate");
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename= $judul.xls");
            
            $this->load->view('anggaran/rka/perkadaII', $data);
        break;
        case 3;     
            header("Cache-Control: no-cache, no-store, must-revalidate");
            header("Content-Type: application/vnd.ms-word");
            header("Content-Disposition: attachment; filename= $judul.doc");
            $this->load->view('anggaran/rka/perkadaII', $data);
        break;
        }                
    }
    
  
   function cetak_perdaIII_real($cetak='', $urusan='', $cbulan='', $txt=''){
	        $txt="1";$cbulan='12';
			$bulan = strtoupper($this->tukd_model->getBulan($cbulan));
			$skpd = $this->session->userdata('kdskpd'); 
			$sql1 = "SELECT nm_skpd FROM ms_skpd WHERE kd_skpd='$skpd'";
			$ivan = $this->db->query($sql1);
			$oioi = $ivan->row();
			$nmskpd = $oioi->nm_skpd;
			$realpend=0;
			$anggpend=0;
		 
            $sqldns="SELECT b.kd_urusan as kd_u,b.nm_urusan as nm_u FROM ms_urusan b WHERE b.kd_urusan='$urusan'";
                 $sqlskpd=$this->db->query($sqldns);
                 foreach ($sqlskpd->result() as $rowdns)
                {                  
                    $kd_urusan=$rowdns->kd_u;                    
                    $nm_urusan= $rowdns->nm_u;                    
                }
            
            $sqlanggaran1="select case when statu=1 and status_sempurna=1 and status_ubah=1 and $cbulan>=month(tgl_dpa_ubah) then 2 
					   when statu=1 and status_sempurna=1 and status_ubah=1 and $cbulan>=month(tgl_dpa_sempurna) and $cbulan<month(tgl_dpa_ubah) then 1
					   when statu=1 and status_sempurna=1 and status_ubah=1 and $cbulan<month(tgl_dpa_sempurna) then 1
					   when statu=1 and status_sempurna=1 and status_ubah=0 and $cbulan>=month(tgl_dpa_sempurna) then 1 
					   when statu=1 and status_sempurna=1 and status_ubah=0 and $cbulan<month(tgl_dpa_sempurna) then 1
					   when statu=1 and status_sempurna=0 and status_ubah=0 and $cbulan>=month(tgl_dpa) then 1
					   else 1 end as anggaran from trhrka where kd_skpd='$skpd'";
    $sqlanggaran=$this->db->query($sqlanggaran1);
	foreach ($sqlanggaran->result() as $rowttd)
        {
            $anggaran=$rowttd->anggaran;
        }

	$ag_tox=$anggaran;
            
			$sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab FROM ms_ttd where kd_skpd='$skpd' and kode='PA'";
            $sqlttd=$this->db->query($sqlttd1);
            foreach ($sqlttd->result() as $rowttd)
			
                {
                    $nip=$rowttd->nip;                    
                    $oioi= $rowttd->nm;
                    $jabatan = $rowttd->jab;
                }			
			
			$sqlttd2="SELECT nama as nm,nip as nip,jabatan as jab FROM ms_ttd where kd_skpd='$skpd' and kode='PT'";
            $ttd11=$this->db->query($sqlttd2);
			foreach ($ttd11->result() as $ivan)
			    {
                    $nip1=$ivan->nip;                    
                    $oioi1= $ivan->nm;
                    $jabatan1 = $ivan->jab;
                }
			
       $sqlsc="SELECT tgl_rka,provinsi,kab_kota,daerah,thn_ang FROM sclient where kd_skpd='$skpd'";
                 $sqlsclient=$this->db->query($sqlsc);
                 foreach ($sqlsclient->result() as $rowsc)
                {
                   
                    $tgl=$rowsc->tgl_rka;
                    $tanggal = $this->tukd_model->tanggal_format_indonesia($tgl);
                    $kab     = $rowsc->kab_kota;
                    $daerah  = $rowsc->daerah;
                    $thn     = $rowsc->thn_ang;
                } 
           
        $bersih_skpd= str_replace(".", "", $skpd);
        $print_r = explode(".",$skpd);
        $ke1 = $print_r[0];
        $ke2 = $print_r[1];
        $ke3 = $print_r[2];        
        $ke4 = $print_r[3]; 
        $skkd = $ke1."/".$ke2."/".$ke3;   
            
        $cRet='';
        
       
        $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
                    <tr>
                         <td align=\"center\"><strong>PEMERINTAH KABUPATEN SANGGAU</strong></td>                         
                    </tr>
					<tr>
                         <td align=\"center\"><strong>RINCIAN APBD MENURUT URUSAN PEMERINTAHAN DAERAH, ORGANISASI<br/>
                                        PENDAPATAN, BELANJA DAN PEMBIAYAAN </strong></td>
                    </tr>                    
                    <tr>
                         <td align=\"center\"><strong>TAHUN ANGGARAN $thn</strong></td>
                    </tr>
                    <tr>
                         <td align=\"center\">&nbsp;</td>
                    </tr>
                  </table>";        
        $cRet .="<table style=\"border-collapse:collapse;font-size:13px;\" width=\"100%\" align=\"left\" border=\"0\">
                    <tr>
						<td width=\"5%\"></td>
                        <td width=\"20%\">Urusan Organisasi </td>
                        <td width=\"75%\">:$kd_urusan - $nm_urusan</td>
                    </tr>
                    <tr>
						<td></td>
                        <td>Organisasi</td>
                        <td>:$skpd - $nmskpd</td>
                    </tr>";
        
        $cRet .= "<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"4\">
                     <thead>                       
                        <tr><td rowspan=\"2\" bgcolor=\"#CCCCCC\" width=\"10%\" align=\"center\"><b>NO</b></td>                            
                            <td rowspan=\"2\" bgcolor=\"#CCCCCC\" width=\"35%\" align=\"center\"><b>URAIAN</b></td>
                            <td colspan=\"2\" bgcolor=\"#CCCCCC\" width=\"40%\" align=\"center\"><b>JUMLAH</b></td>                            
                            <td rowspan=\"2\" bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\" ><b>LEBIH</br>(KURANG)</b></td>
                            <td rowspan=\"2\" bgcolor=\"#CCCCCC\" width=\"8%\" align=\"center\" ><b>%</b></td>   
                        </tr>  
                        <tr>
                            <td bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>ANGGARAN</b></td>                            
                            <td bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\" ><b>REALISASI</b></td>                            
                        </tr>   
                        
                     </thead>
                     <tfoot>
                        <tr>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>                           
                         </tr>
                     </tfoot>
						";
					
					$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"10%\" align=\"left\"><b><b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"40%\"><b><b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";	                   	
               $nil4=0;
               $angnil4=0;
               $sql4="
                select z.kode,z.nama,z.anggaran,z.reali from (
                SELECT left(a.kd_ang,1) as kode,b.nm_rek1 as nama,sum(a.anggaran) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg2( $cbulan,$ag_tox) a
                inner join ms_rek1 b on b.kd_rek1 = left(a.kd_ang,1)                
                where left(a.kd_ang,1)='4' and left(kd_skpd,7) = left('$skpd',7) and left(a.kd_subkegiatan,4)='$urusan'
                group by left(a.kd_ang,1),b.nm_rek1               
                )z order by kode,nama
                ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil4    = $row4->reali;
					$angnil4 = $row4->anggaran;
					
                    $real_s = $angnil4 - $nil4;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil4==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil4;
                    }

                    $nilai4    = number_format($nil4,"2",".",",");
                    $angnilai4 = number_format($angnil4,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai4=='' or $angnilai4==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil4/$angnil4)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                    
               $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai4<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai4<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                   }   
                    
                      $sql4="
                select z.kd_subkegiatan,z.kode,z.nama,sum(z.anggaran) as anggaran,sum(z.reali) as reali from(
            ----program
 SELECT left(a.kd_subkegiatan,18) as kd_subkegiatan,'' as kode,b.nm_program as nama,0 as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg2($cbulan,$ag_tox) a
                inner join m_prog b on b.kd_program = left(a.kd_subkegiatan,18)                
                where left(a.kd_ang,1)='4' and left(a.kd_skpd,7) = left('$skpd',7) and left(a.kd_subkegiatan,4)='$urusan'
                group by left(a.kd_subkegiatan,18),b.nm_program
 union all     
 SELECT left(a.kd_subkegiatan,18) as kd_subkegiatan,'' as kode,b.nm_program as nama,sum(a.nilai_ang) as anggaran,0 as reali FROM data_realisasi_keg3($cbulan,$ag_tox) a
                inner join m_prog b on b.kd_program = left(a.kd_subkegiatan,18)                
                where left(a.kd_ang,1)='4' and left(a.kd_skpd,7) = left('$skpd',7) and left(a.kd_subkegiatan,4)='$urusan'
                group by left(a.kd_subkegiatan,18),b.nm_program
 union all  
            ----kegiatan                      
 SELECT left(a.kd_subkegiatan,21) as kd_subkegiatan,'' as kode,b.nm_kegiatan as nama,0 as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg2($cbulan,$ag_tox) a
                inner join m_giat b on b.kd_kegiatan = left(a.kd_subkegiatan,21)                
                where left(a.kd_ang,1)='4' and left(a.kd_skpd,7) = left('$skpd',7) and left(a.kd_subkegiatan,4)='$urusan'
                group by left(a.kd_subkegiatan,21),b.nm_kegiatan
 union all  
  SELECT left(a.kd_subkegiatan,21) as kd_subkegiatan,'' as kode,b.nm_kegiatan as nama,sum(a.nilai_ang) as anggaran,0 as reali FROM data_realisasi_keg3($cbulan,$ag_tox) a
                inner join m_giat b on b.kd_kegiatan = left(a.kd_subkegiatan,21)                
                where left(a.kd_ang,1)='4' and left(a.kd_skpd,7) = left('$skpd',7) and left(a.kd_subkegiatan,4)='$urusan'
                group by left(a.kd_subkegiatan,21),b.nm_kegiatan
 union all 
              ----sub keg        
 SELECT left(a.kd_subkegiatan,24) as kd_subkegiatan,'' as kode,b.nm_subkegiatan as nama,0 as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg2($cbulan,$ag_tox) a
                inner join m_sub_giat b on b.kd_subkegiatan = left(a.kd_subkegiatan,24)                
                where left(a.kd_ang,1)='4' and left(a.kd_skpd,7) = left('$skpd',7) and left(a.kd_subkegiatan,4)='$urusan'
                group by left(a.kd_subkegiatan,24),b.nm_subkegiatan
 union all                 
 SELECT left(a.kd_subkegiatan,24) as kd_subkegiatan,'' as kode,b.nm_subkegiatan as nama,sum(a.nilai_ang) as anggaran,0 as reali FROM data_realisasi_keg3($cbulan,$ag_tox) a
                inner join m_sub_giat b on b.kd_subkegiatan = left(a.kd_subkegiatan,24)                
                where left(a.kd_ang,1)='4' and left(a.kd_skpd,7) = left('$skpd',7) and left(a.kd_subkegiatan,4)='$urusan'
                group by left(a.kd_subkegiatan,24),b.nm_subkegiatan                          
                ) z
                group by kd_subkegiatan,kode,nama
                order by kd_subkegiatan,kode,nama
                ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$keg 	= $row4->kd_subkegiatan;
                    $no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil    = $row4->reali;
					$angnil = $row4->anggaran;
					
                    $real_s = $angnil - $nil;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil;
                    }

                    $nilai    = number_format($nil,"2",".",",");
                    $angnilai = number_format($angnil,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai=='' or $angnilai==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil/$angnil)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                   if($no==" "){
                    
                    $panjang = strlen($keg);
                    
                    if($panjang==24){
                        $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">$keg</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\">$nama</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\">$x1$selisih$y1</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\">$persen1</td>
                                 </tr>";
                    }else{
                        $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>$keg<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";    
                    }
                                        
                             }else
                             {
					$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">$no</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\">$nama</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\">$x1$selisih$y1</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\">$persen1</td>
                                 </tr>";
                             }
               }         
                       
                        $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";    
                       
                        $sql4="
                select z.kode,z.nama,sum(z.anggaran) as anggaran,sum(z.reali) as reali from (
                SELECT left(a.kd_ang,1) as kode,b.nm_rek1 as nama,0 as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg2( $cbulan,$ag_tox) a
                inner join ms_rek1 b on b.kd_rek1 = left(a.kd_ang,1)                
                where left(a.kd_ang,1)='5' and left(kd_skpd,7) = left('$skpd',7) and left(a.kd_subkegiatan,4)='$urusan'
                group by left(a.kd_ang,1),b.nm_rek1    
                union all
                SELECT left(a.kd_ang,1) as kode,b.nm_rek1 as nama,sum(a.nilai_ang) as anggaran,0 as reali FROM data_realisasi_keg3( $cbulan,$ag_tox) a
                inner join ms_rek1 b on b.kd_rek1 = left(a.kd_ang,1)                
                where left(a.kd_ang,1)='5' and left(kd_skpd,7) = left('$skpd',7) and left(a.kd_subkegiatan,4)='$urusan'
                group by left(a.kd_ang,1),b.nm_rek1            
                )z group by kode,nama order by kode,nama
                ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil5    = $row4->reali;
					$angnil5 = $row4->anggaran;
					
                    $real_s = $angnil5 - $nil5;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil5==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil5;
                    }

                    $nilai5    = number_format($nil5,"2",".",",");
                    $angnilai5 = number_format($angnil5,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai5=='' or $angnilai5==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil5/$angnil5)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                    
               $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai5<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai5<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                   }   
                                      
                  	$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";	                   	               
                
                   $sql4="
                select z.kode,z.nama,sum(z.anggaran) as anggaran,sum(z.reali) as reali from (
                SELECT left(a.kd_ang,2) as kode,b.nm_rek2 as nama,0 as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg2( $cbulan,$ag_tox) a
                inner join ms_rek2 b on b.kd_rek2 = left(a.kd_ang,2)                
                where left(a.kd_ang,2)='51' and left(kd_skpd,7) = left('$skpd',7) and left(a.kd_subkegiatan,4)='$urusan'
                group by left(a.kd_ang,2),b.nm_rek2     
                union all
                 SELECT left(a.kd_ang,2) as kode,b.nm_rek2 as nama,sum(a.nilai_ang) as anggaran,0 as reali FROM data_realisasi_keg3( $cbulan,$ag_tox) a
                inner join ms_rek2 b on b.kd_rek2 = left(a.kd_ang,2)                
                where left(a.kd_ang,2)='51' and left(kd_skpd,7) = left('$skpd',7) and left(a.kd_subkegiatan,4)='$urusan'
                group by left(a.kd_ang,2),b.nm_rek2         
                )z group by kode,nama order by kode,nama
                ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil52    = $row4->reali;
					$angnil52 = $row4->anggaran;
					
                    $real_s = $angnil52 - $nil52;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil52==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil52;
                    }

                    $nilai52    = number_format($nil52,"2",".",",");
                    $angnilai52 = number_format($angnil52,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai52=='' or $angnilai52==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil52/$angnil52)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                        
                        
                        $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai52<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai52<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                   }   
                                                   	
               
                   $sql4="
                select z.kd_subkegiatan,z.kode,z.nama,sum(z.anggaran) as anggaran,sum(z.reali) as reali from(
            ----program
 SELECT left(a.kd_subkegiatan,18) as kd_subkegiatan,'' as kode,b.nm_program as nama,0 as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg2( 12,2) a
                inner join m_prog b on b.kd_program = left(a.kd_subkegiatan,18)                
                where left(a.kd_ang,2)='51' and left(a.kd_skpd,7) = left('$skpd',7) and left(a.kd_subkegiatan,4)='$urusan'
                group by left(a.kd_subkegiatan,18),b.nm_program
 union all     
 SELECT left(a.kd_subkegiatan,18) as kd_subkegiatan,'' as kode,b.nm_program as nama,sum(a.nilai_ang) as anggaran,0 as reali FROM data_realisasi_keg3( 12,2) a
                inner join m_prog b on b.kd_program = left(a.kd_subkegiatan,18)                
                where left(a.kd_ang,2)='51' and left(a.kd_skpd,7) = left('$skpd',7) and left(a.kd_subkegiatan,4)='$urusan'
                group by left(a.kd_subkegiatan,18),b.nm_program
 union all  
            ----kegiatan                      
 SELECT left(a.kd_subkegiatan,21) as kd_subkegiatan,'' as kode,b.nm_kegiatan as nama,0 as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg2( 12,2) a
                inner join m_giat b on b.kd_kegiatan = left(a.kd_subkegiatan,21)                
                where left(a.kd_ang,2)='51' and left(a.kd_skpd,7) = left('$skpd',7) and left(a.kd_subkegiatan,4)='$urusan'
                group by left(a.kd_subkegiatan,21),b.nm_kegiatan
 union all  
  SELECT left(a.kd_subkegiatan,21) as kd_subkegiatan,'' as kode,b.nm_kegiatan as nama,sum(a.nilai_ang) as anggaran,0 as reali FROM data_realisasi_keg3( 12,2) a
                inner join m_giat b on b.kd_kegiatan = left(a.kd_subkegiatan,21)                
                where left(a.kd_ang,2)='51' and left(a.kd_skpd,7) = left('$skpd',7) and left(a.kd_subkegiatan,4)='$urusan'
                group by left(a.kd_subkegiatan,21),b.nm_kegiatan
 union all 
              ----sub keg        
 SELECT left(a.kd_subkegiatan,24) as kd_subkegiatan,'' as kode,b.nm_subkegiatan as nama,0 as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg2( 12,2) a
                inner join m_sub_giat b on b.kd_subkegiatan = left(a.kd_subkegiatan,24) and left(a.kd_subkegiatan,4)='$urusan'                
                where left(a.kd_ang,2)='51' and left(a.kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_subkegiatan,24),b.nm_subkegiatan
 union all                 
 SELECT left(a.kd_subkegiatan,24) as kd_subkegiatan,'' as kode,b.nm_subkegiatan as nama,sum(a.nilai_ang) as anggaran,0 as reali FROM data_realisasi_keg3( 12,2) a
                inner join m_sub_giat b on b.kd_subkegiatan = left(a.kd_subkegiatan,24) and left(a.kd_subkegiatan,4)='$urusan'               
                where left(a.kd_ang,2)='51' and left(a.kd_skpd,7) = left('$skpd',7)
                group by left(a.kd_subkegiatan,24),b.nm_subkegiatan                          
                ) z
                group by kd_subkegiatan,kode,nama
                order by kd_subkegiatan,kode,nama
                ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$keg 	= $row4->kd_subkegiatan;
                    $no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil    = $row4->reali;
					$angnil = $row4->anggaran;
					
                    $real_s = $angnil - $nil;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil;
                    }

                    $nilai    = number_format($nil,"2",".",",");
                    $angnilai = number_format($angnil,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai=='' or $angnilai==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil/$angnil)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                   if($no==" "){
                    
                    $panjang = strlen($keg);
                    
                    if($panjang==24){
                        $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">$keg</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\">$nama</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\">$x1$selisih$y1</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\">$persen1</td>
                                 </tr>";
                    }else{
                        $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>$keg<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                    }
                    
                             }else
                             {
					$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">$no</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\">$nama</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\">$x1$selisih$y1</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\">$persen1</td>
                                 </tr>";
                             }
               }         
               
               	$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                
                 $sql4="
                select z.kode,z.nama,sum(z.anggaran) as anggaran,sum(z.reali) as reali from (
                SELECT left(a.kd_ang,2) as kode,b.nm_rek2 as nama,0 as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg2( $cbulan,$ag_tox) a
                inner join ms_rek2 b on b.kd_rek2 = left(a.kd_ang,2)                
                where left(a.kd_ang,2)='52' and left(kd_skpd,7) = left('$skpd',7) and left(a.kd_subkegiatan,4)='$urusan'
                group by left(a.kd_ang,2),b.nm_rek2     
                union all
                 SELECT left(a.kd_ang,2) as kode,b.nm_rek2 as nama,sum(a.nilai_ang) as anggaran,0 as reali FROM data_realisasi_keg3( $cbulan,$ag_tox) a
                inner join ms_rek2 b on b.kd_rek2 = left(a.kd_ang,2)                
                where left(a.kd_ang,2)='52' and left(kd_skpd,7) = left('$skpd',7) and left(a.kd_subkegiatan,4)='$urusan'
                group by left(a.kd_ang,2),b.nm_rek2         
                )z group by kode,nama order by kode,nama
                ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil52    = $row4->reali;
					$angnil52 = $row4->anggaran;
					
                    $real_s = $angnil52 - $nil52;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil52==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil52;
                    }

                    $nilai52    = number_format($nil52,"2",".",",");
                    $angnilai52 = number_format($angnil52,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai52=='' or $angnilai52==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil52/$angnil52)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                    
               $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai52<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai52<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                   }                                         	
               
                   $sql4="
                select z.kd_subkegiatan,z.kode,z.nama,sum(z.anggaran) as anggaran,sum(z.reali) as reali from(
            ----program
 SELECT left(a.kd_subkegiatan,18) as kd_subkegiatan,'' as kode,b.nm_program as nama,0 as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg2($cbulan,$ag_tox) a
                inner join m_prog b on b.kd_program = left(a.kd_subkegiatan,18)                
                where left(a.kd_ang,2)='52' and left(a.kd_skpd,7) = left('$skpd',7) and left(a.kd_subkegiatan,4)='$urusan'
                group by left(a.kd_subkegiatan,18),b.nm_program
 union all     
 SELECT left(a.kd_subkegiatan,18) as kd_subkegiatan,'' as kode,b.nm_program as nama,sum(a.nilai_ang) as anggaran,0 as reali FROM data_realisasi_keg3($cbulan,$ag_tox) a
                inner join m_prog b on b.kd_program = left(a.kd_subkegiatan,18)                
                where left(a.kd_ang,2)='52' and left(a.kd_skpd,7) = left('$skpd',7) and left(a.kd_subkegiatan,4)='$urusan'
                group by left(a.kd_subkegiatan,18),b.nm_program
 union all  
            ----kegiatan                      
 SELECT left(a.kd_subkegiatan,21) as kd_subkegiatan,'' as kode,b.nm_kegiatan as nama,0 as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg2($cbulan,$ag_tox) a
                inner join m_giat b on b.kd_kegiatan = left(a.kd_subkegiatan,21)                
                where left(a.kd_ang,2)='52' and left(a.kd_skpd,7) = left('$skpd',7) and left(a.kd_subkegiatan,4)='$urusan'
                group by left(a.kd_subkegiatan,21),b.nm_kegiatan
 union all  
  SELECT left(a.kd_subkegiatan,21) as kd_subkegiatan,'' as kode,b.nm_kegiatan as nama,sum(a.nilai_ang) as anggaran,0 as reali FROM data_realisasi_keg3($cbulan,$ag_tox) a
                inner join m_giat b on b.kd_kegiatan = left(a.kd_subkegiatan,21)                
                where left(a.kd_ang,2)='52' and left(a.kd_skpd,7) = left('$skpd',7) and left(a.kd_subkegiatan,4)='$urusan'
                group by left(a.kd_subkegiatan,21),b.nm_kegiatan
 union all 
              ----sub keg        
 SELECT left(a.kd_subkegiatan,24) as kd_subkegiatan,'' as kode,b.nm_subkegiatan as nama,0 as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg2($cbulan,$ag_tox) a
                inner join m_sub_giat b on b.kd_subkegiatan = left(a.kd_subkegiatan,24)                
                where left(a.kd_ang,2)='52' and left(a.kd_skpd,7) = left('$skpd',7) and left(a.kd_subkegiatan,4)='$urusan'
                group by left(a.kd_subkegiatan,24),b.nm_subkegiatan
 union all                 
 SELECT left(a.kd_subkegiatan,24) as kd_subkegiatan,'' as kode,b.nm_subkegiatan as nama,sum(a.nilai_ang) as anggaran,0 as reali FROM data_realisasi_keg3($cbulan,$ag_tox) a
                inner join m_sub_giat b on b.kd_subkegiatan = left(a.kd_subkegiatan,24)                
                where left(a.kd_ang,2)='52' and left(a.kd_skpd,7) = left('$skpd',7) and left(a.kd_subkegiatan,4)='$urusan'
                group by left(a.kd_subkegiatan,24),b.nm_subkegiatan                          
                ) z
                group by kd_subkegiatan,kode,nama
                order by kd_subkegiatan,kode,nama
                ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$keg 	= $row4->kd_subkegiatan;
                    $no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil    = $row4->reali;
					$angnil = $row4->anggaran;
					
                    $real_s = $angnil - $nil;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil;
                    }

                    $nilai    = number_format($nil,"2",".",",");
                    $angnilai = number_format($angnil,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai=='' or $angnilai==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil/$angnil)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                   if($no==" "){
                    
                    $panjang = strlen($keg);
                    
                    if($panjang==24){
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">$keg</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\">$nama</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\">$x1$selisih$y1</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\">$persen1</td>
                                 </tr>";
                    }else{
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>$keg<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                    }
      
                   
                             }else
                             {
					$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">$no</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\">$nama</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\">$x1$selisih$y1</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\">$persen1</td>
                                 </tr>";
                             }
               }                 
                 
                  	$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                 
                 $no 	= '';
					$nama   = 'SURPLUS/DEFISIT';                      
					$nil    = $nil4 - $nil5;
					$angnil = $angnil4 - $angnil5;
					
                    $real_s = $angnil - $nil;

                    if ($angnil < 0){
                    	$a1="("; $angnil=$angnil*-1; $a2=")";}
                    else {
                    	$a1=""; $a2="";}

                    if ($nil < 0){
                    	$b1="("; $nil=$nil*-1; $b2=")";}
                    else {
                    	$b1=""; $b2="";}

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil;
                    }

                    $nilai    = number_format($nil,"2",".",",");
                    $angnilai = number_format($angnil,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai=='' or $angnilai==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil/$angnil)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                   
                   $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$a1$angnilai$a2<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$b1$nilai$b2<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";         
              
        $cRet .=       " </table>";
        $data['prev']= $cRet;
		 $cRet         .= "</table>";
		 
		 if($txt==1){
		 $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> </td>
		 <td align=\"center\" width=\"50%\"> Sanggau,31 Desember $thn </td>
		 </tr>		
		 <tr>
		 <td align=\"center\" width=\"50%\">  </td>
		 <td align=\"center\" width=\"50%\"> $jabatan </td>
		 </tr>	
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		  <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"></td>
		 <td align=\"center\" width=\"50%\"> $oioi </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> </td>
		 <td align=\"center\" width=\"50%\"> NIP :$nip </td>
		 </tr>
         </table>
		 ";}
		$data['prev'] = $cRet;
        $data['sikap'] = 'preview';
        $judul  = 'LAPORAN REALISASI ANGGARAN';
        $this->template->set('title', 'CETAK LAPORAN REALISASI ANGGARAN');        
        switch($cetak) {
		case 1;
			 echo ("<title>L R A</title>"); 
             echo $cRet;
        break;		
        case 0;
             //$this->tukd_model->_mpdf('',$cRet,10,10,10,'P');
             	$this->_mpdf_down('',$cRet,10,10,10,'0',0,'','PERDA III '.$nmskpd.'');
        break;
        case 2;        
            header("Cache-Control: no-cache, no-store, must-revalidate");
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename= $judul.xls");
            
            $this->load->view('anggaran/rka/perkadaII', $data);
        break;
        case 3;     
            header("Cache-Control: no-cache, no-store, must-revalidate");
            header("Content-Type: application/vnd.ms-word");
            header("Content-Disposition: attachment; filename= $judul.doc");
            $this->load->view('anggaran/rka/perkadaII', $data);
        break;
        } 
    }
  
  function skpd_urusan() {
		$kd_skpd = $this->session->userdata('kdskpd');
        $sql = "select LEFT(a.kd_subkegiatan,4) as kd_urusan,b.nm_urusan from trdrka a 
left join ms_urusan b on b.kd_urusan = LEFT(a.kd_subkegiatan,4)
where LEFT(a.kd_skpd,7)=left('$kd_skpd',7)
group by LEFT(a.kd_subkegiatan,4),b.nm_urusan order by LEFT(a.kd_subkegiatan,4)";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kd_urusan' => $resulte['kd_urusan'],  
                        'nm_urusan' => $resulte['nm_urusan'],  
                       
                        );
                        $ii++;
        }
           
        echo json_encode($result);
     $query1->free_result(); 	  
	}
  
  function _mpdf_down($judul='',$isi='',$lMargin=10,$rMargin=10,$font='',$orientasi='',$hal='', $fonsize='', $name='') {
                

        ini_set("memory_limit","-1M");
        ini_set("MAX_EXECUTION_TIME","-1");
        $this->load->library('mpdf');
		//$this->mpdf->SetHeader('||Halaman {PAGENO} /{nb}');
        
        
        $this->mpdf->defaultheaderfontsize = 6;	/* in pts */
        $this->mpdf->defaultheaderfontstyle = BI;	/* blank, B, I, or BI */
        $this->mpdf->defaultheaderline = 1; 	/* 1 to include line below header/above footer */

        $this->mpdf->defaultfooterfontsize = 6;	/* in pts */
        $this->mpdf->defaultfooterfontstyle = BI;	/* blank, B, I, or BI */
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
        $this->mpdf->AddPage($orientasi,'',$hal1,'1','off');
		$this->mpdf->SetFooter("Printed on Simakda || Halaman {PAGENO}  ");
        if (!empty($judul)) $this->mpdf->writeHTML($judul);
        $this->mpdf->writeHTML($isi);         
        $this->mpdf->Output($name,'D');
               
    }

   function cetak_lra_bulan_rincian_dinkes($cbulan='', $cetak='', $txt='', $ctgl_ttd=''){
	        $txt="1";
			$tanggalttd = $this->uri->segment(5);
            $ttd1 = str_replace('a',' ',$this->uri->segment(6));
            $ttd2 = str_replace('a',' ',$this->uri->segment(7));
            $ctgl_ttd = $this->tukd_model->tanggal_format_indonesia($tanggalttd);
            $bulan = strtoupper($this->tukd_model->getBulan($cbulan));
			$skpd = $this->session->userdata('kdskpd'); 
			$sql1 = "SELECT nm_skpd FROM ms_skpd WHERE kd_skpd='$skpd'";
			$ivan = $this->db->query($sql1);
			$oioi = $ivan->row();
			$nmskpd = $oioi->nm_skpd;
			$realpend=0;
			$anggpend=0;
			
            $sqlanggaran1="select case when statu=1 and status_sempurna=1 and status_ubah=1 and $cbulan>=month(tgl_dpa_ubah) then 2 
					   when statu=1 and status_sempurna=1 and status_ubah=1 and $cbulan>=month(tgl_dpa_sempurna) and $cbulan<month(tgl_dpa_ubah) then 1
					   when statu=1 and status_sempurna=1 and status_ubah=1 and $cbulan<month(tgl_dpa_sempurna) then 1
					   when statu=1 and status_sempurna=1 and status_ubah=0 and $cbulan>=month(tgl_dpa_sempurna) then 1 
					   when statu=1 and status_sempurna=1 and status_ubah=0 and $cbulan<month(tgl_dpa_sempurna) then 1
					   when statu=1 and status_sempurna=0 and status_ubah=0 and $cbulan>=month(tgl_dpa) then 1
					   else 1 end as anggaran from trhrka where kd_skpd='$skpd'";
    $sqlanggaran=$this->db->query($sqlanggaran1);
	foreach ($sqlanggaran->result() as $rowttd)
        {
            $anggaran=$rowttd->anggaran;
        }

	$ag_tox=$anggaran;
            
			$sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab FROM ms_ttd where kd_skpd='$skpd' and kode='PA' and nip='$ttd1'";
            $sqlttd=$this->db->query($sqlttd1);
            foreach ($sqlttd->result() as $rowttd)
			
                {
                    $nip=$rowttd->nip;                    
                    $oioi= $rowttd->nm;
                    $jabatan = $rowttd->jab;
                }			
			
			$sqlttd2="SELECT nama as nm,nip as nip,jabatan as jab FROM ms_ttd where kd_skpd='$skpd' and kode='PPK' and nip='$ttd2'";
            $ttd11=$this->db->query($sqlttd2);
			foreach ($ttd11->result() as $ivan)
			    {
                    $nip1=$ivan->nip;                    
                    $oioi1= $ivan->nm;
                    $jabatan1 = $ivan->jab;
                }
			
       $sqlsc="SELECT tgl_rka,provinsi,kab_kota,daerah,thn_ang FROM sclient where kd_skpd='$skpd'";
                 $sqlsclient=$this->db->query($sqlsc);
                 foreach ($sqlsclient->result() as $rowsc)
                {
                   
                    $tgl=$rowsc->tgl_rka;
                    $tanggal = $this->tukd_model->tanggal_format_indonesia($tgl);
                    $kab     = $rowsc->kab_kota;
                    $daerah  = $rowsc->daerah;
                    $thn     = $rowsc->thn_ang;
                } 
           
        $bersih_skpd= str_replace(".", "", $skpd);
        $print_r = explode(".",$skpd);
        $ke1 = $print_r[0];
        $ke2 = $print_r[1];
        $ke3 = $print_r[2];        
        $ke4 = $print_r[3]; 
        $skkd = $ke1."/".$ke2."/".$ke3;   
            
        $cRet='';
        
       
        $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
                    <tr>
                         <td align=\"center\"><strong>PEMERINTAH KABUPATEN SANGGAU</strong></td>                         
                    </tr>
					 <tr>
                         <td align=\"center\"><strong>$nmskpd</strong></td>                         
                    </tr>
                    <tr>
                         <td align=\"center\"><strong>LAPORAN REALISASI ANGGARAN</strong></td>
                    </tr>                    
                    <tr>
                         <td align=\"center\"><strong>PER 31 $bulan $thn</strong></td>
                    </tr>
                    <tr>
                         <td align=\"center\">&nbsp;</td>
                    </tr>
                  </table>";        
        
        
        $cRet .= "<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"4\">
                     <thead>                       
                        <tr><td bgcolor=\"#CCCCCC\" width=\"5%\" align=\"center\"><b>NO</b></td>                            
                            <td  bgcolor=\"#CCCCCC\" width=\"45%\" align=\"center\"><b>URAIAN</b></td>
                            <td bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>ANGGARAN</b></td>
                            <td bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>REALISASI</b></td>
                            <td  bgcolor=\"#CCCCCC\" width=\"15%\" align=\"center\" ><b>LEBIH</br>(KURANG)</b></td>
                            <td  bgcolor=\"#CCCCCC\" width=\"5%\" align=\"center\" ><b>%</b></td>   
                        </tr>
                        
                     </thead>
                     <tfoot>
                        <tr>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>                           
                         </tr>
                     </tfoot>
						";
					
					$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>4<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>PENDAPATAN<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";	                   	
               
                $sql4="
                select z.kode,z.nama,z.anggaran,z.reali from (
                SELECT left(a.kd_rek5,2) as kode,b.nm_rek2 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek2_64 b on b.kd_rek2 = left(a.kd_rek5,2)                
                where left(a.kd_rek5,1)='4' and kd_skpd in ('1.02.01.00','1.02.01.02','1.02.01.03','1.02.01.04','1.02.01.05',
				'1.02.01.06','1.02.01.07','1.02.01.08','1.02.01.09',
				'1.02.01.10','1.02.01.11','1.02.01.12','1.02.01.13',
				'1.02.01.14','1.02.01.15','1.02.01.16','1.02.01.17',
				'1.02.01.18','1.02.01.19','1.02.01.20','1.02.01.21',
				'1.02.01.22','1.02.01.23','1.02.01.24','1.02.01.25',
				'1.02.01.26','1.02.01.30','1.02.01.31','1.02.01.32',
				'1.02.01.33','1.02.01.34','1.02.01.35','1.02.01.36',
				'1.02.01.37','1.02.01.38','1.02.01.39','1.02.01.40',
				'1.02.01.41','1.02.01.42','1.02.01.43','1.02.01.44',
				'1.02.01.45','1.02.01.46','1.02.01.47','1.02.01.48',
				'1.02.01.49','1.02.01.50','1.02.01.51','1.02.01.52')
                group by left(a.kd_rek5,2),b.nm_rek2
                union all
                SELECT left(a.kd_rek5,3) as kode,b.nm_rek3 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek3_64 b on b.kd_rek3 = left(a.kd_rek5,3)                
                where left(a.kd_rek5,1)='4' and kd_skpd in ('1.02.01.00','1.02.01.02','1.02.01.03','1.02.01.04','1.02.01.05',
				'1.02.01.06','1.02.01.07','1.02.01.08','1.02.01.09',
				'1.02.01.10','1.02.01.11','1.02.01.12','1.02.01.13',
				'1.02.01.14','1.02.01.15','1.02.01.16','1.02.01.17',
				'1.02.01.18','1.02.01.19','1.02.01.20','1.02.01.21',
				'1.02.01.22','1.02.01.23','1.02.01.24','1.02.01.25',
				'1.02.01.26','1.02.01.30','1.02.01.31','1.02.01.32',
				'1.02.01.33','1.02.01.34','1.02.01.35','1.02.01.36',
				'1.02.01.37','1.02.01.38','1.02.01.39','1.02.01.40',
				'1.02.01.41','1.02.01.42','1.02.01.43','1.02.01.44',
				'1.02.01.45','1.02.01.46','1.02.01.47','1.02.01.48',
				'1.02.01.49','1.02.01.50','1.02.01.51','1.02.01.52')
                group by left(a.kd_rek5,3),b.nm_rek3
                union all
                SELECT left(a.kd_rek5,5) as kode,b.nm_rek4_64 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek4_64 b on b.kd_rek4_64 = left(a.kd_rek5,5)                
                where left(a.kd_rek5,1)='4' and kd_skpd in ('1.02.01.00','1.02.01.02','1.02.01.03','1.02.01.04','1.02.01.05',
				'1.02.01.06','1.02.01.07','1.02.01.08','1.02.01.09',
				'1.02.01.10','1.02.01.11','1.02.01.12','1.02.01.13',
				'1.02.01.14','1.02.01.15','1.02.01.16','1.02.01.17',
				'1.02.01.18','1.02.01.19','1.02.01.20','1.02.01.21',
				'1.02.01.22','1.02.01.23','1.02.01.24','1.02.01.25',
				'1.02.01.26','1.02.01.30','1.02.01.31','1.02.01.32',
				'1.02.01.33','1.02.01.34','1.02.01.35','1.02.01.36',
				'1.02.01.37','1.02.01.38','1.02.01.39','1.02.01.40',
				'1.02.01.41','1.02.01.42','1.02.01.43','1.02.01.44',
				'1.02.01.45','1.02.01.46','1.02.01.47','1.02.01.48',
				'1.02.01.49','1.02.01.50','1.02.01.51','1.02.01.52')
                group by left(a.kd_rek5,5),b.nm_rek4_64
                union all
                 SELECT left(a.kd_rek5,7) as kode,b.nm_rek64 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek5 b on b.kd_rek5 = left(a.kd_rek5,7)                
                where left(a.kd_rek5,1)='4' and kd_skpd in ('1.02.01.00','1.02.01.02','1.02.01.03','1.02.01.04','1.02.01.05',
				'1.02.01.06','1.02.01.07','1.02.01.08','1.02.01.09',
				'1.02.01.10','1.02.01.11','1.02.01.12','1.02.01.13',
				'1.02.01.14','1.02.01.15','1.02.01.16','1.02.01.17',
				'1.02.01.18','1.02.01.19','1.02.01.20','1.02.01.21',
				'1.02.01.22','1.02.01.23','1.02.01.24','1.02.01.25',
				'1.02.01.26','1.02.01.30','1.02.01.31','1.02.01.32',
				'1.02.01.33','1.02.01.34','1.02.01.35','1.02.01.36',
				'1.02.01.37','1.02.01.38','1.02.01.39','1.02.01.40',
				'1.02.01.41','1.02.01.42','1.02.01.43','1.02.01.44',
				'1.02.01.45','1.02.01.46','1.02.01.47','1.02.01.48',
				'1.02.01.49','1.02.01.50','1.02.01.51','1.02.01.52')
                group by left(a.kd_rek5,7),b.nm_rek64
                )z order by kode,nama
                ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil    = $row4->reali;
					$angnil = $row4->anggaran;
					
                    $real_s = $angnil - $nil;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil;
                    }

                    $nilai    = number_format($nil,"2",".",",");
                    $angnilai = number_format($angnil,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai=='' or $angnilai==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil/$angnil)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                   if(strlen("$no")<6){
                    $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                             }else
                             {
					$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">$no</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\">$nama</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\">$x1$selisih$y1</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\">$persen1</td>
                                 </tr>";
                             }
               }
               		$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                    $nil4=0;
                    $angnil4=0;
                    $sql4="
                select z.kode,z.nama,z.anggaran,z.reali from (
                SELECT left(a.kd_rek5,1) as kode,b.nm_rek1 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek1 b on b.kd_rek1 = left(a.kd_rek5,1)                
                where left(a.kd_rek5,1)='4' and kd_skpd in ('1.02.01.00','1.02.01.02','1.02.01.03','1.02.01.04','1.02.01.05',
				'1.02.01.06','1.02.01.07','1.02.01.08','1.02.01.09',
				'1.02.01.10','1.02.01.11','1.02.01.12','1.02.01.13',
				'1.02.01.14','1.02.01.15','1.02.01.16','1.02.01.17',
				'1.02.01.18','1.02.01.19','1.02.01.20','1.02.01.21',
				'1.02.01.22','1.02.01.23','1.02.01.24','1.02.01.25',
				'1.02.01.26','1.02.01.30','1.02.01.31','1.02.01.32',
				'1.02.01.33','1.02.01.34','1.02.01.35','1.02.01.36',
				'1.02.01.37','1.02.01.38','1.02.01.39','1.02.01.40',
				'1.02.01.41','1.02.01.42','1.02.01.43','1.02.01.44',
				'1.02.01.45','1.02.01.46','1.02.01.47','1.02.01.48',
				'1.02.01.49','1.02.01.50','1.02.01.51','1.02.01.52')
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
					
                    $real_s = $angnil4 - $nil4;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil4==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil4;
                    }

                    $nilai4    = number_format($nil4,"2",".",",");
                    $angnilai4 = number_format($angnil4,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai4=='' or $angnilai4==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil4/$angnil4)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                    
               $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>JUMLAH $nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai4<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai4<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                   }   
                   
                   $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                      
                   	$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>5<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>BELANJA<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";	                   	
               
                   $sql4="
               select z.kode,z.nama,sum(z.anggaran) as anggaran,sum(z.reali) as reali from(
               
  SELECT left(a.kd_rek5,2) as kode,b.nm_rek2 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd($cbulan,$ag_tox) a
                inner join ms_rek2_64 b on b.kd_rek2 = left(a.kd_rek5,2)                        
                where left(a.kd_rek5,1)='5' and a.kd_skpd in ('1.02.01.00','1.02.01.02','1.02.01.03','1.02.01.04','1.02.01.05',
				'1.02.01.06','1.02.01.07','1.02.01.08','1.02.01.09',
				'1.02.01.10','1.02.01.11','1.02.01.12','1.02.01.13',
				'1.02.01.14','1.02.01.15','1.02.01.16','1.02.01.17',
				'1.02.01.18','1.02.01.19','1.02.01.20','1.02.01.21',
				'1.02.01.22','1.02.01.23','1.02.01.24','1.02.01.25',
				'1.02.01.26','1.02.01.30','1.02.01.31','1.02.01.32',
				'1.02.01.33','1.02.01.34','1.02.01.35','1.02.01.36',
				'1.02.01.37','1.02.01.38','1.02.01.39','1.02.01.40',
				'1.02.01.41','1.02.01.42','1.02.01.43','1.02.01.44',
				'1.02.01.45','1.02.01.46','1.02.01.47','1.02.01.48',
				'1.02.01.49','1.02.01.50','1.02.01.51','1.02.01.52')
                group by left(a.kd_rek5,2),b.nm_rek2                
 union all
 
 SELECT left(a.kd_rek5,2) as kode,b.nm_rek2 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_non4_skpd($cbulan,$ag_tox) a
                inner join ms_rek2_64 b on b.kd_rek2 = left(a.kd_rek5,2)                        
                where left(a.kd_rek5,1)='5' and  a.kd_skpd in ('1.02.01.00','1.02.01.02','1.02.01.03','1.02.01.04','1.02.01.05',
				'1.02.01.06','1.02.01.07','1.02.01.08','1.02.01.09',
				'1.02.01.10','1.02.01.11','1.02.01.12','1.02.01.13',
				'1.02.01.14','1.02.01.15','1.02.01.16','1.02.01.17',
				'1.02.01.18','1.02.01.19','1.02.01.20','1.02.01.21',
				'1.02.01.22','1.02.01.23','1.02.01.24','1.02.01.25',
				'1.02.01.26','1.02.01.30','1.02.01.31','1.02.01.32',
				'1.02.01.33','1.02.01.34','1.02.01.35','1.02.01.36',
				'1.02.01.37','1.02.01.38','1.02.01.39','1.02.01.40',
				'1.02.01.41','1.02.01.42','1.02.01.43','1.02.01.44',
				'1.02.01.45','1.02.01.46','1.02.01.47','1.02.01.48',
				'1.02.01.49','1.02.01.50','1.02.01.51','1.02.01.52')
                group by left(a.kd_rek5,2),b.nm_rek2
 union all               
  SELECT left(a.kd_rek5,3) as kode,b.nm_rek3 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd($cbulan,$ag_tox) a
                inner join ms_rek3_64 b on b.kd_rek3 = left(a.kd_rek5,3)                        
                where left(a.kd_rek5,1)='5' and  a.kd_skpd in ('1.02.01.00','1.02.01.02','1.02.01.03','1.02.01.04','1.02.01.05',
				'1.02.01.06','1.02.01.07','1.02.01.08','1.02.01.09',
				'1.02.01.10','1.02.01.11','1.02.01.12','1.02.01.13',
				'1.02.01.14','1.02.01.15','1.02.01.16','1.02.01.17',
				'1.02.01.18','1.02.01.19','1.02.01.20','1.02.01.21',
				'1.02.01.22','1.02.01.23','1.02.01.24','1.02.01.25',
				'1.02.01.26','1.02.01.30','1.02.01.31','1.02.01.32',
				'1.02.01.33','1.02.01.34','1.02.01.35','1.02.01.36',
				'1.02.01.37','1.02.01.38','1.02.01.39','1.02.01.40',
				'1.02.01.41','1.02.01.42','1.02.01.43','1.02.01.44',
				'1.02.01.45','1.02.01.46','1.02.01.47','1.02.01.48',
				'1.02.01.49','1.02.01.50','1.02.01.51','1.02.01.52')
                group by left(a.kd_rek5,3),b.nm_rek3                
 union all               
  SELECT left(a.kd_rek5,3) as kode,b.nm_rek3 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_non4_skpd($cbulan,$ag_tox) a
                inner join ms_rek3_64 b on b.kd_rek3 = left(a.kd_rek5,3)                        
                where left(a.kd_rek5,1)='5' and  a.kd_skpd in ('1.02.01.00','1.02.01.02','1.02.01.03','1.02.01.04','1.02.01.05',
				'1.02.01.06','1.02.01.07','1.02.01.08','1.02.01.09',
				'1.02.01.10','1.02.01.11','1.02.01.12','1.02.01.13',
				'1.02.01.14','1.02.01.15','1.02.01.16','1.02.01.17',
				'1.02.01.18','1.02.01.19','1.02.01.20','1.02.01.21',
				'1.02.01.22','1.02.01.23','1.02.01.24','1.02.01.25',
				'1.02.01.26','1.02.01.30','1.02.01.31','1.02.01.32',
				'1.02.01.33','1.02.01.34','1.02.01.35','1.02.01.36',
				'1.02.01.37','1.02.01.38','1.02.01.39','1.02.01.40',
				'1.02.01.41','1.02.01.42','1.02.01.43','1.02.01.44',
				'1.02.01.45','1.02.01.46','1.02.01.47','1.02.01.48',
				'1.02.01.49','1.02.01.50','1.02.01.51','1.02.01.52')
                group by left(a.kd_rek5,3),b.nm_rek3 
 union all
                
  SELECT left(a.kd_rek5,5) as kode,b.nm_rek4_64 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd($cbulan,$ag_tox) a
                inner join ms_rek4_64 b on b.kd_rek4_64 = left(a.kd_rek5,5)                        
                where left(a.kd_rek5,1)='5' and  a.kd_skpd in ('1.02.01.00','1.02.01.02','1.02.01.03','1.02.01.04','1.02.01.05',
				'1.02.01.06','1.02.01.07','1.02.01.08','1.02.01.09',
				'1.02.01.10','1.02.01.11','1.02.01.12','1.02.01.13',
				'1.02.01.14','1.02.01.15','1.02.01.16','1.02.01.17',
				'1.02.01.18','1.02.01.19','1.02.01.20','1.02.01.21',
				'1.02.01.22','1.02.01.23','1.02.01.24','1.02.01.25',
				'1.02.01.26','1.02.01.30','1.02.01.31','1.02.01.32',
				'1.02.01.33','1.02.01.34','1.02.01.35','1.02.01.36',
				'1.02.01.37','1.02.01.38','1.02.01.39','1.02.01.40',
				'1.02.01.41','1.02.01.42','1.02.01.43','1.02.01.44',
				'1.02.01.45','1.02.01.46','1.02.01.47','1.02.01.48',
				'1.02.01.49','1.02.01.50','1.02.01.51','1.02.01.52')
                group by left(a.kd_rek5,5),b.nm_rek4_64   
union all
                
  SELECT left(a.kd_rek5,5) as kode,b.nm_rek4_64 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_non4_skpd($cbulan,$ag_tox) a
                inner join ms_rek4_64 b on b.kd_rek4_64 = left(a.kd_rek5,5)                        
                where left(a.kd_rek5,1)='5' and  a.kd_skpd in ('1.02.01.00','1.02.01.02','1.02.01.03','1.02.01.04','1.02.01.05',
				'1.02.01.06','1.02.01.07','1.02.01.08','1.02.01.09',
				'1.02.01.10','1.02.01.11','1.02.01.12','1.02.01.13',
				'1.02.01.14','1.02.01.15','1.02.01.16','1.02.01.17',
				'1.02.01.18','1.02.01.19','1.02.01.20','1.02.01.21',
				'1.02.01.22','1.02.01.23','1.02.01.24','1.02.01.25',
				'1.02.01.26','1.02.01.30','1.02.01.31','1.02.01.32',
				'1.02.01.33','1.02.01.34','1.02.01.35','1.02.01.36',
				'1.02.01.37','1.02.01.38','1.02.01.39','1.02.01.40',
				'1.02.01.41','1.02.01.42','1.02.01.43','1.02.01.44',
				'1.02.01.45','1.02.01.46','1.02.01.47','1.02.01.48',
				'1.02.01.49','1.02.01.50','1.02.01.51','1.02.01.52')
                group by left(a.kd_rek5,5),b.nm_rek4_64                             
 union all
                
  SELECT left(a.kd_rek5,7) as kode,b.nm_rek5 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd($cbulan,$ag_tox) a
                inner join ms_rek5 b on b.kd_rek64 = left(a.kd_rek5,7)                        
                where left(a.kd_rek5,1)='5' and  a.kd_skpd in ('1.02.01.00','1.02.01.02','1.02.01.03','1.02.01.04','1.02.01.05',
				'1.02.01.06','1.02.01.07','1.02.01.08','1.02.01.09',
				'1.02.01.10','1.02.01.11','1.02.01.12','1.02.01.13',
				'1.02.01.14','1.02.01.15','1.02.01.16','1.02.01.17',
				'1.02.01.18','1.02.01.19','1.02.01.20','1.02.01.21',
				'1.02.01.22','1.02.01.23','1.02.01.24','1.02.01.25',
				'1.02.01.26','1.02.01.30','1.02.01.31','1.02.01.32',
				'1.02.01.33','1.02.01.34','1.02.01.35','1.02.01.36',
				'1.02.01.37','1.02.01.38','1.02.01.39','1.02.01.40',
				'1.02.01.41','1.02.01.42','1.02.01.43','1.02.01.44',
				'1.02.01.45','1.02.01.46','1.02.01.47','1.02.01.48',
				'1.02.01.49','1.02.01.50','1.02.01.51','1.02.01.52')
                group by left(a.kd_rek5,7),b.nm_rek5   
union all
                
  SELECT left(a.kd_rek5,7) as kode,b.nm_rek5 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_non4_skpd($cbulan,$ag_tox) a
                inner join ms_rek5 b on b.kd_rek64 = left(a.kd_rek5,7)                        
                where left(a.kd_rek5,1)='5' and  a.kd_skpd in ('1.02.01.00','1.02.01.02','1.02.01.03','1.02.01.04','1.02.01.05',
				'1.02.01.06','1.02.01.07','1.02.01.08','1.02.01.09',
				'1.02.01.10','1.02.01.11','1.02.01.12','1.02.01.13',
				'1.02.01.14','1.02.01.15','1.02.01.16','1.02.01.17',
				'1.02.01.18','1.02.01.19','1.02.01.20','1.02.01.21',
				'1.02.01.22','1.02.01.23','1.02.01.24','1.02.01.25',
				'1.02.01.26','1.02.01.30','1.02.01.31','1.02.01.32',
				'1.02.01.33','1.02.01.34','1.02.01.35','1.02.01.36',
				'1.02.01.37','1.02.01.38','1.02.01.39','1.02.01.40',
				'1.02.01.41','1.02.01.42','1.02.01.43','1.02.01.44',
				'1.02.01.45','1.02.01.46','1.02.01.47','1.02.01.48',
				'1.02.01.49','1.02.01.50','1.02.01.51','1.02.01.52')
                group by left(a.kd_rek5,7),b.nm_rek5                
       ) z
                group by kode,nama
                order by kode,nama ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil    = $row4->reali;
					$angnil = $row4->anggaran;
					
                    $real_s = $angnil - $nil;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil;
                    }

                    $nilai    = number_format($nil,"2",".",",");
                    $angnilai = number_format($angnil,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai=='' or $angnilai==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil/$angnil)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                   if(strlen("$no")<6){
                    $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                             }else
                             {
					$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">$no</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\">$nama</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\">$x1$selisih$y1</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\">$persen1</td>
                                 </tr>";
                             }
               }  
               
                		$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                    
                    $sql4="
                select z.kode,z.nama,sum(z.anggaran) as anggaran,sum(z.reali) as reali from (
                SELECT left(a.kd_rek5,1) as kode,b.nm_rek1 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek1 b on b.kd_rek1 = left(a.kd_rek5,1)                
                where left(a.kd_rek5,1)='5' and  kd_skpd in ('1.02.01.00','1.02.01.02','1.02.01.03','1.02.01.04','1.02.01.05',
				'1.02.01.06','1.02.01.07','1.02.01.08','1.02.01.09',
				'1.02.01.10','1.02.01.11','1.02.01.12','1.02.01.13',
				'1.02.01.14','1.02.01.15','1.02.01.16','1.02.01.17',
				'1.02.01.18','1.02.01.19','1.02.01.20','1.02.01.21',
				'1.02.01.22','1.02.01.23','1.02.01.24','1.02.01.25',
				'1.02.01.26','1.02.01.30','1.02.01.31','1.02.01.32',
				'1.02.01.33','1.02.01.34','1.02.01.35','1.02.01.36',
				'1.02.01.37','1.02.01.38','1.02.01.39','1.02.01.40',
				'1.02.01.41','1.02.01.42','1.02.01.43','1.02.01.44',
				'1.02.01.45','1.02.01.46','1.02.01.47','1.02.01.48',
				'1.02.01.49','1.02.01.50','1.02.01.51','1.02.01.52')
                group by left(a.kd_rek5,1),b.nm_rek1 
                union all
                SELECT left(a.kd_rek5,1) as kode,b.nm_rek1 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_non4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek1 b on b.kd_rek1 = left(a.kd_rek5,1)                
                where left(a.kd_rek5,1)='5' and  kd_skpd in ('1.02.01.00','1.02.01.02','1.02.01.03','1.02.01.04','1.02.01.05',
				'1.02.01.06','1.02.01.07','1.02.01.08','1.02.01.09',
				'1.02.01.10','1.02.01.11','1.02.01.12','1.02.01.13',
				'1.02.01.14','1.02.01.15','1.02.01.16','1.02.01.17',
				'1.02.01.18','1.02.01.19','1.02.01.20','1.02.01.21',
				'1.02.01.22','1.02.01.23','1.02.01.24','1.02.01.25',
				'1.02.01.26','1.02.01.30','1.02.01.31','1.02.01.32',
				'1.02.01.33','1.02.01.34','1.02.01.35','1.02.01.36',
				'1.02.01.37','1.02.01.38','1.02.01.39','1.02.01.40',
				'1.02.01.41','1.02.01.42','1.02.01.43','1.02.01.44',
				'1.02.01.45','1.02.01.46','1.02.01.47','1.02.01.48',
				'1.02.01.49','1.02.01.50','1.02.01.51','1.02.01.52')
                group by left(a.kd_rek5,1),b.nm_rek1
                )z group by kode,nama order by kode,nama
                ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil5    = $row4->reali;
					$angnil5 = $row4->anggaran;
					
                    $real_s = $angnil5 - $nil5;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil5==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil5;
                    }

                    $nilai5    = number_format($nil5,"2",".",",");
                    $angnilai5 = number_format($angnil5,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai5=='' or $angnilai5==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil5/$angnil5)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                
               	$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                     
                    
               $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>JUMLAH $nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai5<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai5<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                   }   
                 
                  	$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                 
                 $no 	= '';
					$nama   = 'SURPLUS/DEFISIT';                      
					$nil    = $nil4 - $nil5;
					$angnil = $angnil4 - $angnil5;
					
                    $real_s = $angnil - $nil;

                    if ($angnil < 0){
                    	$a1="("; $angnil=$angnil*-1; $a2=")";}
                    else {
                    	$a1=""; $a2="";}

                    if ($nil < 0){
                    	$b1="("; $nil=$nil*-1; $b2=")";}
                    else {
                    	$b1=""; $b2="";}

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil;
                    }

                    $nilai    = number_format($nil,"2",".",",");
                    $angnilai = number_format($angnil,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai=='' or $angnilai==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil/$angnil)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                   
                   $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$a1$angnilai$a2<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$b1$nilai$b2<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";         
              
        $cRet .=       " </table>";
        $data['prev']= $cRet;
		 $cRet         .= "</table>";
		 
		 if($txt==1){
		 $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> Mengetahui,</td>
		 <td align=\"center\" width=\"50%\"> Sanggau, $ctgl_ttd </td>
		 </tr>		
		 <tr>
		 <td align=\"center\" width=\"50%\"> $jabatan </td>
		 <td align=\"center\" width=\"50%\"> $jabatan1 </td>
		 </tr>	
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		  <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> $oioi</td>
		 <td align=\"center\" width=\"50%\"> $oioi1</td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> NIP :$nip</td>
		 <td align=\"center\" width=\"50%\"> NIP :$nip1</td>
		 </tr>
         </table>
		 ";}
		$data['prev'] = $cRet;
        $data['sikap'] = 'preview';
        $judul  = 'LAPORAN REALISASI ANGGARAN';
        $this->template->set('title', 'CETAK LAPORAN REALISASI ANGGARAN');        
        switch($cetak) {
		case 1;
			 echo ("<title>L R A</title>"); 
             echo $cRet;
        break;		
        case 0;
             $this->tukd_model->_mpdf('',$cRet,10,10,10,'P');
        break;
        case 2;        
            header("Cache-Control: no-cache, no-store, must-revalidate");
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename= $judul.xls");
            
            $this->load->view('anggaran/rka/perkadaII', $data);
        break;
        case 3;     
            header("Cache-Control: no-cache, no-store, must-revalidate");
            header("Content-Type: application/vnd.ms-word");
            header("Content-Disposition: attachment; filename= $judul.doc");
            $this->load->view('anggaran/rka/perkadaII', $data);
        break;
        } 
    }	
function cetak_lra_bulan_rincian_ang_dinkes($cbulan='', $cetak='', $txt=''){
	        $txt="1";
			$tanggalttd = $this->uri->segment(5);
            $ttd1 = str_replace('a',' ',$this->uri->segment(6));
            $ttd2 = str_replace('a',' ',$this->uri->segment(7));
            $ctgl_ttd = $this->tukd_model->tanggal_format_indonesia($tanggalttd);
            $bulan = strtoupper($this->tukd_model->getBulan($cbulan));
			$skpd = $this->session->userdata('kdskpd'); 
			$sql1 = "SELECT nm_skpd FROM ms_skpd WHERE kd_skpd='$skpd'";
			$ivan = $this->db->query($sql1);
			$oioi = $ivan->row();
			$nmskpd = $oioi->nm_skpd;
			$realpend=0;
			$anggpend=0;
			
            $sqlanggaran1="select case when statu=1 and status_sempurna=1 and status_ubah=1 and $cbulan>=month(tgl_dpa_ubah) then 2 
					   when statu=1 and status_sempurna=1 and status_ubah=1 and $cbulan>=month(tgl_dpa_sempurna) and $cbulan<month(tgl_dpa_ubah) then 1
					   when statu=1 and status_sempurna=1 and status_ubah=1 and $cbulan<month(tgl_dpa_sempurna) then 1
					   when statu=1 and status_sempurna=1 and status_ubah=0 and $cbulan>=month(tgl_dpa_sempurna) then 1 
					   when statu=1 and status_sempurna=1 and status_ubah=0 and $cbulan<month(tgl_dpa_sempurna) then 1
					   when statu=1 and status_sempurna=0 and status_ubah=0 and $cbulan>=month(tgl_dpa) then 1
					   else 1 end as anggaran from trhrka where kd_skpd='$skpd'";
    $sqlanggaran=$this->db->query($sqlanggaran1);
	foreach ($sqlanggaran->result() as $rowttd)
        {
            $anggaran=$rowttd->anggaran;
        }

	$ag_tox=$anggaran;
            
			$sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab FROM ms_ttd where kd_skpd='$skpd' and kode='PA' and nip='$ttd1'";
            $sqlttd=$this->db->query($sqlttd1);
            foreach ($sqlttd->result() as $rowttd)
			
                {
                    $nip=$rowttd->nip;                    
                    $oioi= $rowttd->nm;
                    $jabatan = $rowttd->jab;
                }			
			
			$sqlttd2="SELECT nama as nm,nip as nip,jabatan as jab FROM ms_ttd where kd_skpd='$skpd' and kode='PPK' and nip='$ttd2'";
            $ttd11=$this->db->query($sqlttd2);
			foreach ($ttd11->result() as $ivan)
			    {
                    $nip1=$ivan->nip;                    
                    $oioi1= $ivan->nm;
                    $jabatan1 = $ivan->jab;
                }
			
       $sqlsc="SELECT tgl_rka,provinsi,kab_kota,daerah,thn_ang FROM sclient where kd_skpd='$skpd'";
                 $sqlsclient=$this->db->query($sqlsc);
                 foreach ($sqlsclient->result() as $rowsc)
                {
                   
                    $tgl=$rowsc->tgl_rka;
                    $tanggal = $this->tukd_model->tanggal_format_indonesia($tgl);
                    $kab     = $rowsc->kab_kota;
                    $daerah  = $rowsc->daerah;
                    $thn     = $rowsc->thn_ang;
                } 
           
        $bersih_skpd= str_replace(".", "", $skpd);
        $print_r = explode(".",$skpd);
        $ke1 = $print_r[0];
        $ke2 = $print_r[1];
        $ke3 = $print_r[2];        
        $ke4 = $print_r[3]; 
        $skkd = $ke1."/".$ke2."/".$ke3;   
            
        $cRet='';
        
       
        $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
                    <tr>
                         <td align=\"center\"><strong>PEMERINTAH KABUPATEN SANGGAU</strong></td>                         
                    </tr>
					 <tr>
                         <td align=\"center\"><strong>$nmskpd</strong></td>                         
                    </tr>
                    <tr>
                         <td align=\"center\"><strong>LAPORAN REALISASI ANGGARAN</strong></td>
                    </tr>                    
                    <tr>
                         <td align=\"center\"><strong>PER 31 $bulan $thn</strong></td>
                    </tr>
                    <tr>
                         <td align=\"center\">&nbsp;</td>
                    </tr>
                  </table>";        
        
        
        $cRet .= "<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"4\">
                     <thead>                       
                        <tr><td bgcolor=\"#CCCCCC\" width=\"5%\" align=\"center\"><b>NO</b></td>                            
                            <td  bgcolor=\"#CCCCCC\" width=\"45%\" align=\"center\"><b>URAIAN</b></td>
                            <td bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>ANGGARAN</b></td>
                            <td bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>REALISASI</b></td>
                            <td  bgcolor=\"#CCCCCC\" width=\"15%\" align=\"center\" ><b>LEBIH</br>(KURANG)</b></td>
                            <td  bgcolor=\"#CCCCCC\" width=\"5%\" align=\"center\" ><b>%</b></td>   
                        </tr>
                        
                     </thead>
                     <tfoot>
                        <tr>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>                           
                         </tr>
                     </tfoot>
						";
					
					$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>4<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>PENDAPATAN<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";	                   	
               
                $sql4="
                select z.kode,z.nama,z.anggaran,z.reali from (
                SELECT left(a.kd_ang,2) as kode,b.nm_rek2 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek2 b on b.kd_rek2 = left(a.kd_ang,2)                
                where left(a.kd_ang,1)='4' and  kd_skpd in ('1.02.01.00','1.02.01.02','1.02.01.03','1.02.01.04','1.02.01.05',
				'1.02.01.06','1.02.01.07','1.02.01.08','1.02.01.09',
				'1.02.01.10','1.02.01.11','1.02.01.12','1.02.01.13',
				'1.02.01.14','1.02.01.15','1.02.01.16','1.02.01.17',
				'1.02.01.18','1.02.01.19','1.02.01.20','1.02.01.21',
				'1.02.01.22','1.02.01.23','1.02.01.24','1.02.01.25',
				'1.02.01.26','1.02.01.30','1.02.01.31','1.02.01.32',
				'1.02.01.33','1.02.01.34','1.02.01.35','1.02.01.36',
				'1.02.01.37','1.02.01.38','1.02.01.39','1.02.01.40',
				'1.02.01.41','1.02.01.42','1.02.01.43','1.02.01.44',
				'1.02.01.45','1.02.01.46','1.02.01.47','1.02.01.48',
				'1.02.01.49','1.02.01.50','1.02.01.51','1.02.01.52')
                group by left(a.kd_ang,2),b.nm_rek2
                union all
                SELECT left(a.kd_ang,3) as kode,b.nm_rek3 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek3 b on b.kd_rek3 = left(a.kd_ang,3)                
                where left(a.kd_ang,1)='4' and  kd_skpd in ('1.02.01.00','1.02.01.02','1.02.01.03','1.02.01.04','1.02.01.05',
				'1.02.01.06','1.02.01.07','1.02.01.08','1.02.01.09',
				'1.02.01.10','1.02.01.11','1.02.01.12','1.02.01.13',
				'1.02.01.14','1.02.01.15','1.02.01.16','1.02.01.17',
				'1.02.01.18','1.02.01.19','1.02.01.20','1.02.01.21',
				'1.02.01.22','1.02.01.23','1.02.01.24','1.02.01.25',
				'1.02.01.26','1.02.01.30','1.02.01.31','1.02.01.32',
				'1.02.01.33','1.02.01.34','1.02.01.35','1.02.01.36',
				'1.02.01.37','1.02.01.38','1.02.01.39','1.02.01.40',
				'1.02.01.41','1.02.01.42','1.02.01.43','1.02.01.44',
				'1.02.01.45','1.02.01.46','1.02.01.47','1.02.01.48',
				'1.02.01.49','1.02.01.50','1.02.01.51','1.02.01.52')
                group by left(a.kd_ang,3),b.nm_rek3
                union all
                SELECT left(a.kd_ang,5) as kode,b.nm_rek4 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek4 b on b.kd_rek4 = left(a.kd_ang,5)                
                where left(a.kd_ang,1)='4' and  kd_skpd in ('1.02.01.00','1.02.01.02','1.02.01.03','1.02.01.04','1.02.01.05',
				'1.02.01.06','1.02.01.07','1.02.01.08','1.02.01.09',
				'1.02.01.10','1.02.01.11','1.02.01.12','1.02.01.13',
				'1.02.01.14','1.02.01.15','1.02.01.16','1.02.01.17',
				'1.02.01.18','1.02.01.19','1.02.01.20','1.02.01.21',
				'1.02.01.22','1.02.01.23','1.02.01.24','1.02.01.25',
				'1.02.01.26','1.02.01.30','1.02.01.31','1.02.01.32',
				'1.02.01.33','1.02.01.34','1.02.01.35','1.02.01.36',
				'1.02.01.37','1.02.01.38','1.02.01.39','1.02.01.40',
				'1.02.01.41','1.02.01.42','1.02.01.43','1.02.01.44',
				'1.02.01.45','1.02.01.46','1.02.01.47','1.02.01.48',
				'1.02.01.49','1.02.01.50','1.02.01.51','1.02.01.52')
                group by left(a.kd_ang,5),b.nm_rek4
                union all
                 SELECT left(a.kd_ang,7) as kode,b.nm_rek64 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek5 b on b.kd_rek5 = left(a.kd_ang,7)                
                where left(a.kd_ang,1)='4' and  kd_skpd in ('1.02.01.00','1.02.01.02','1.02.01.03','1.02.01.04','1.02.01.05',
				'1.02.01.06','1.02.01.07','1.02.01.08','1.02.01.09',
				'1.02.01.10','1.02.01.11','1.02.01.12','1.02.01.13',
				'1.02.01.14','1.02.01.15','1.02.01.16','1.02.01.17',
				'1.02.01.18','1.02.01.19','1.02.01.20','1.02.01.21',
				'1.02.01.22','1.02.01.23','1.02.01.24','1.02.01.25',
				'1.02.01.26','1.02.01.30','1.02.01.31','1.02.01.32',
				'1.02.01.33','1.02.01.34','1.02.01.35','1.02.01.36',
				'1.02.01.37','1.02.01.38','1.02.01.39','1.02.01.40',
				'1.02.01.41','1.02.01.42','1.02.01.43','1.02.01.44',
				'1.02.01.45','1.02.01.46','1.02.01.47','1.02.01.48',
				'1.02.01.49','1.02.01.50','1.02.01.51','1.02.01.52')
                group by left(a.kd_ang,7),b.nm_rek64
                )z order by kode,nama
                ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil    = $row4->reali;
					$angnil = $row4->anggaran;
					
                    $real_s = $angnil - $nil;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil;
                    }

                    $nilai    = number_format($nil,"2",".",",");
                    $angnilai = number_format($angnil,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai=='' or $angnilai==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil/$angnil)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                   if(strlen("$no")<6){
                    $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                             }else
                             {
					$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">$no</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\">$nama</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\">$x1$selisih$y1</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\">$persen1</td>
                                 </tr>";
                             }
               }
               		$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                    $nil4=0;
                    $angnil4=0;
                    $sql4="
                select z.kode,z.nama,z.anggaran,z.reali from (
                SELECT left(a.kd_rek5,1) as kode,b.nm_rek1 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek1 b on b.kd_rek1 = left(a.kd_rek5,1)                
                where left(a.kd_rek5,1)='4' and  kd_skpd in ('1.02.01.00','1.02.01.02','1.02.01.03','1.02.01.04','1.02.01.05',
				'1.02.01.06','1.02.01.07','1.02.01.08','1.02.01.09',
				'1.02.01.10','1.02.01.11','1.02.01.12','1.02.01.13',
				'1.02.01.14','1.02.01.15','1.02.01.16','1.02.01.17',
				'1.02.01.18','1.02.01.19','1.02.01.20','1.02.01.21',
				'1.02.01.22','1.02.01.23','1.02.01.24','1.02.01.25',
				'1.02.01.26','1.02.01.30','1.02.01.31','1.02.01.32',
				'1.02.01.33','1.02.01.34','1.02.01.35','1.02.01.36',
				'1.02.01.37','1.02.01.38','1.02.01.39','1.02.01.40',
				'1.02.01.41','1.02.01.42','1.02.01.43','1.02.01.44',
				'1.02.01.45','1.02.01.46','1.02.01.47','1.02.01.48',
				'1.02.01.49','1.02.01.50','1.02.01.51','1.02.01.52')
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
					
                    $real_s = $angnil4 - $nil4;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil4==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil4;
                    }

                    $nilai4    = number_format($nil4,"2",".",",");
                    $angnilai4 = number_format($angnil4,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai4=='' or $angnilai4==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil4/$angnil4)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                    
               $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>JUMLAH $nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai4<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai4<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                   }   
                   
                   $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                      
                   	$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>5<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>BELANJA<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";	                   	
               
                   $sql4="
               select z.kode,z.nama,sum(z.anggaran) as anggaran,sum(z.reali) as reali from(
               
  SELECT left(a.kd_ang,2) as kode,b.nm_rek2 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek2 b on b.kd_rek2 = left(a.kd_ang,2)                        
                where left(a.kd_ang,1)='5' and  kd_skpd in ('1.02.01.00','1.02.01.02','1.02.01.03','1.02.01.04','1.02.01.05',
				'1.02.01.06','1.02.01.07','1.02.01.08','1.02.01.09',
				'1.02.01.10','1.02.01.11','1.02.01.12','1.02.01.13',
				'1.02.01.14','1.02.01.15','1.02.01.16','1.02.01.17',
				'1.02.01.18','1.02.01.19','1.02.01.20','1.02.01.21',
				'1.02.01.22','1.02.01.23','1.02.01.24','1.02.01.25',
				'1.02.01.26','1.02.01.30','1.02.01.31','1.02.01.32',
				'1.02.01.33','1.02.01.34','1.02.01.35','1.02.01.36',
				'1.02.01.37','1.02.01.38','1.02.01.39','1.02.01.40',
				'1.02.01.41','1.02.01.42','1.02.01.43','1.02.01.44',
				'1.02.01.45','1.02.01.46','1.02.01.47','1.02.01.48',
				'1.02.01.49','1.02.01.50','1.02.01.51','1.02.01.52')
                group by left(a.kd_ang,2),b.nm_rek2                
 union all
               
  SELECT left(a.kd_ang,3) as kode,b.nm_rek3 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek3 b on b.kd_rek3 = left(a.kd_ang,3)                        
                where left(a.kd_ang,1)='5' and  kd_skpd in ('1.02.01.00','1.02.01.02','1.02.01.03','1.02.01.04','1.02.01.05',
				'1.02.01.06','1.02.01.07','1.02.01.08','1.02.01.09',
				'1.02.01.10','1.02.01.11','1.02.01.12','1.02.01.13',
				'1.02.01.14','1.02.01.15','1.02.01.16','1.02.01.17',
				'1.02.01.18','1.02.01.19','1.02.01.20','1.02.01.21',
				'1.02.01.22','1.02.01.23','1.02.01.24','1.02.01.25',
				'1.02.01.26','1.02.01.30','1.02.01.31','1.02.01.32',
				'1.02.01.33','1.02.01.34','1.02.01.35','1.02.01.36',
				'1.02.01.37','1.02.01.38','1.02.01.39','1.02.01.40',
				'1.02.01.41','1.02.01.42','1.02.01.43','1.02.01.44',
				'1.02.01.45','1.02.01.46','1.02.01.47','1.02.01.48',
				'1.02.01.49','1.02.01.50','1.02.01.51','1.02.01.52')
                group by left(a.kd_ang,3),b.nm_rek3                
 union all
                
  SELECT left(a.kd_ang,5) as kode,b.nm_rek4 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek4 b on b.kd_rek4 = left(a.kd_ang,5)                        
                where left(a.kd_ang,1)='5' and  kd_skpd in ('1.02.01.00','1.02.01.02','1.02.01.03','1.02.01.04','1.02.01.05',
				'1.02.01.06','1.02.01.07','1.02.01.08','1.02.01.09',
				'1.02.01.10','1.02.01.11','1.02.01.12','1.02.01.13',
				'1.02.01.14','1.02.01.15','1.02.01.16','1.02.01.17',
				'1.02.01.18','1.02.01.19','1.02.01.20','1.02.01.21',
				'1.02.01.22','1.02.01.23','1.02.01.24','1.02.01.25',
				'1.02.01.26','1.02.01.30','1.02.01.31','1.02.01.32',
				'1.02.01.33','1.02.01.34','1.02.01.35','1.02.01.36',
				'1.02.01.37','1.02.01.38','1.02.01.39','1.02.01.40',
				'1.02.01.41','1.02.01.42','1.02.01.43','1.02.01.44',
				'1.02.01.45','1.02.01.46','1.02.01.47','1.02.01.48',
				'1.02.01.49','1.02.01.50','1.02.01.51','1.02.01.52')
                group by left(a.kd_ang,5),b.nm_rek4               
 union all
 
                
  SELECT left(a.kd_ang,7) as kode,b.nm_rek5 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek5 b on b.kd_rek5 = left(a.kd_ang,7)                        
                where left(a.kd_ang,1)='5' and  kd_skpd in ('1.02.01.00','1.02.01.02','1.02.01.03','1.02.01.04','1.02.01.05',
				'1.02.01.06','1.02.01.07','1.02.01.08','1.02.01.09',
				'1.02.01.10','1.02.01.11','1.02.01.12','1.02.01.13',
				'1.02.01.14','1.02.01.15','1.02.01.16','1.02.01.17',
				'1.02.01.18','1.02.01.19','1.02.01.20','1.02.01.21',
				'1.02.01.22','1.02.01.23','1.02.01.24','1.02.01.25',
				'1.02.01.26','1.02.01.30','1.02.01.31','1.02.01.32',
				'1.02.01.33','1.02.01.34','1.02.01.35','1.02.01.36',
				'1.02.01.37','1.02.01.38','1.02.01.39','1.02.01.40',
				'1.02.01.41','1.02.01.42','1.02.01.43','1.02.01.44',
				'1.02.01.45','1.02.01.46','1.02.01.47','1.02.01.48',
				'1.02.01.49','1.02.01.50','1.02.01.51','1.02.01.52')
                group by left(a.kd_ang,7),b.nm_rek5   
                ) z
                group by kode,nama
                order by kode,nama ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil    = $row4->reali;
					$angnil = $row4->anggaran;
					
                    $real_s = $angnil - $nil;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil;
                    }

                    $nilai    = number_format($nil,"2",".",",");
                    $angnilai = number_format($angnil,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai=='' or $angnilai==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil/$angnil)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                   if(strlen("$no")<6){
                    $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                             }else
                             {
					$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">$no</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\">$nama</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\">$x1$selisih$y1</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\">$persen1</td>
                                 </tr>";
                             }
               }  
               
                		$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                    
                    $sql4="
                select z.kode,z.nama,sum(z.anggaran) as anggaran,sum(z.reali) as reali from (
                SELECT left(a.kd_ang,1) as kode,b.nm_rek1 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek1 b on b.kd_rek1 = left(a.kd_ang,1)                
                where left(a.kd_ang,1)='5' and  kd_skpd in ('1.02.01.00','1.02.01.02','1.02.01.03','1.02.01.04','1.02.01.05',
				'1.02.01.06','1.02.01.07','1.02.01.08','1.02.01.09',
				'1.02.01.10','1.02.01.11','1.02.01.12','1.02.01.13',
				'1.02.01.14','1.02.01.15','1.02.01.16','1.02.01.17',
				'1.02.01.18','1.02.01.19','1.02.01.20','1.02.01.21',
				'1.02.01.22','1.02.01.23','1.02.01.24','1.02.01.25',
				'1.02.01.26','1.02.01.30','1.02.01.31','1.02.01.32',
				'1.02.01.33','1.02.01.34','1.02.01.35','1.02.01.36',
				'1.02.01.37','1.02.01.38','1.02.01.39','1.02.01.40',
				'1.02.01.41','1.02.01.42','1.02.01.43','1.02.01.44',
				'1.02.01.45','1.02.01.46','1.02.01.47','1.02.01.48',
				'1.02.01.49','1.02.01.50','1.02.01.51','1.02.01.52')
                group by left(a.kd_ang,1),b.nm_rek1 
                )z group by kode,nama order by kode,nama
                ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil5    = $row4->reali;
					$angnil5 = $row4->anggaran;
					
                    $real_s = $angnil5 - $nil5;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil5==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil5;
                    }

                    $nilai5    = number_format($nil5,"2",".",",");
                    $angnilai5 = number_format($angnil5,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai5=='' or $angnilai5==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil5/$angnil5)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                
               	$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                     
                    
               $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>JUMLAH $nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai5<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai5<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                   }   
                 
                  	$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                 
                 $no 	= '';
					$nama   = 'SURPLUS/DEFISIT';                      
					$nil    = $nil4 - $nil5;
					$angnil = $angnil4 - $angnil5;
					
                    $real_s = $angnil - $nil;

                    if ($angnil < 0){
                    	$a1="("; $angnil=$angnil*-1; $a2=")";}
                    else {
                    	$a1=""; $a2="";}

                    if ($nil < 0){
                    	$b1="("; $nil=$nil*-1; $b2=")";}
                    else {
                    	$b1=""; $b2="";}

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil;
                    }

                    $nilai    = number_format($nil,"2",".",",");
                    $angnilai = number_format($angnil,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai=='' or $angnilai==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil/$angnil)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                   
                   $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$a1$angnilai$a2<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$b1$nilai$b2<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";         
              
        $cRet .=       " </table>";
        $data['prev']= $cRet;
		 $cRet         .= "</table>";
		 
		 if($txt==1){
		 $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> Mengetahui</td>
		 <td align=\"center\" width=\"50%\"> Sanggau, $ctgl_ttd </td>
		 </tr>		
		 <tr>
		 <td align=\"center\" width=\"50%\"> $jabatan </td>
		 <td align=\"center\" width=\"50%\"> $jabatan1 </td>
		 </tr>	
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		  <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> $oioi</td>
		 <td align=\"center\" width=\"50%\"> $oioi1</td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> NIP :$nip</td>
		 <td align=\"center\" width=\"50%\"> NIP :$nip1 </td>
		 </tr>
         </table>
		 ";}
		$data['prev'] = $cRet;
        $data['sikap'] = 'preview';
        $judul  = 'LAPORAN REALISASI ANGGARAN';
        $this->template->set('title', 'CETAK LAPORAN REALISASI ANGGARAN');        
        switch($cetak) {
		case 1;
			 echo ("<title>L R A</title>"); 
             echo $cRet;
        break;		
        case 0;
             $this->tukd_model->_mpdf('',$cRet,10,10,10,'P');
        break;
        case 2;        
            header("Cache-Control: no-cache, no-store, must-revalidate");
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename= $judul.xls");
            
            $this->load->view('anggaran/rka/perkadaII', $data);
        break;
        case 3;     
            header("Cache-Control: no-cache, no-store, must-revalidate");
            header("Content-Type: application/vnd.ms-word");
            header("Content-Disposition: attachment; filename= $judul.doc");
            $this->load->view('anggaran/rka/perkadaII', $data);
        break;
        } 
    }


   function cetak_lra_bulan_rincian_diknas($cbulan='', $cetak='', $txt='', $ctgl_ttd=''){
	        $txt="1";
			$tanggalttd = $this->uri->segment(5);
            $ttd1 = str_replace('a',' ',$this->uri->segment(6));
            $ttd2 = str_replace('a',' ',$this->uri->segment(7));
            $ctgl_ttd = $this->tukd_model->tanggal_format_indonesia($tanggalttd);
            $bulan = strtoupper($this->tukd_model->getBulan($cbulan));
			$skpd = $this->session->userdata('kdskpd'); 
			$sql1 = "SELECT nm_skpd FROM ms_skpd WHERE kd_skpd='$skpd'";
			$ivan = $this->db->query($sql1);
			$oioi = $ivan->row();
			$nmskpd = $oioi->nm_skpd;
			$realpend=0;
			$anggpend=0;
			
            $sqlanggaran1="select case when statu=1 and status_sempurna=1 and status_ubah=1 and $cbulan>=month(tgl_dpa_ubah) then 2 
					   when statu=1 and status_sempurna=1 and status_ubah=1 and $cbulan>=month(tgl_dpa_sempurna) and $cbulan<month(tgl_dpa_ubah) then 1
					   when statu=1 and status_sempurna=1 and status_ubah=1 and $cbulan<month(tgl_dpa_sempurna) then 1
					   when statu=1 and status_sempurna=1 and status_ubah=0 and $cbulan>=month(tgl_dpa_sempurna) then 1 
					   when statu=1 and status_sempurna=1 and status_ubah=0 and $cbulan<month(tgl_dpa_sempurna) then 1
					   when statu=1 and status_sempurna=0 and status_ubah=0 and $cbulan>=month(tgl_dpa) then 1
					   else 1 end as anggaran from trhrka where kd_skpd='$skpd'";
    $sqlanggaran=$this->db->query($sqlanggaran1);
	foreach ($sqlanggaran->result() as $rowttd)
        {
            $anggaran=$rowttd->anggaran;
        }

	$ag_tox=$anggaran;
            
			$sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab FROM ms_ttd where kd_skpd='$skpd' and kode='PA' and nip='$ttd1'";
            $sqlttd=$this->db->query($sqlttd1);
            foreach ($sqlttd->result() as $rowttd)
			
                {
                    $nip=$rowttd->nip;                    
                    $oioi= $rowttd->nm;
                    $jabatan = $rowttd->jab;
                }			
			
			$sqlttd2="SELECT nama as nm,nip as nip,jabatan as jab FROM ms_ttd where kd_skpd='$skpd' and kode='PPK' and nip='$ttd2'";
            $ttd11=$this->db->query($sqlttd2);
			foreach ($ttd11->result() as $ivan)
			    {
                    $nip1=$ivan->nip;                    
                    $oioi1= $ivan->nm;
                    $jabatan1 = $ivan->jab;
                }
			
       $sqlsc="SELECT tgl_rka,provinsi,kab_kota,daerah,thn_ang FROM sclient where kd_skpd='$skpd'";
                 $sqlsclient=$this->db->query($sqlsc);
                 foreach ($sqlsclient->result() as $rowsc)
                {
                   
                    $tgl=$rowsc->tgl_rka;
                    $tanggal = $this->tukd_model->tanggal_format_indonesia($tgl);
                    $kab     = $rowsc->kab_kota;
                    $daerah  = $rowsc->daerah;
                    $thn     = $rowsc->thn_ang;
                } 
           
        $bersih_skpd= str_replace(".", "", $skpd);
        $print_r = explode(".",$skpd);
        $ke1 = $print_r[0];
        $ke2 = $print_r[1];
        $ke3 = $print_r[2];        
        $ke4 = $print_r[3]; 
        $skkd = $ke1."/".$ke2."/".$ke3;   
            
        $cRet='';
        
       
        $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
                    <tr>
                         <td align=\"center\"><strong>PEMERINTAH KABUPATEN SANGGAU</strong></td>                         
                    </tr>
					 <tr>
                         <td align=\"center\"><strong>$nmskpd</strong></td>                         
                    </tr>
                    <tr>
                         <td align=\"center\"><strong>LAPORAN REALISASI ANGGARAN</strong></td>
                    </tr>                    
                    <tr>
                         <td align=\"center\"><strong>PER 31 $bulan $thn</strong></td>
                    </tr>
                    <tr>
                         <td align=\"center\">&nbsp;</td>
                    </tr>
                  </table>";        
        
        
        $cRet .= "<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"4\">
                     <thead>                       
                        <tr><td bgcolor=\"#CCCCCC\" width=\"5%\" align=\"center\"><b>NO</b></td>                            
                            <td  bgcolor=\"#CCCCCC\" width=\"45%\" align=\"center\"><b>URAIAN</b></td>
                            <td bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>ANGGARAN</b></td>
                            <td bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>REALISASI</b></td>
                            <td  bgcolor=\"#CCCCCC\" width=\"15%\" align=\"center\" ><b>LEBIH</br>(KURANG)</b></td>
                            <td  bgcolor=\"#CCCCCC\" width=\"5%\" align=\"center\" ><b>%</b></td>   
                        </tr>
                        
                     </thead>
                     <tfoot>
                        <tr>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>                           
                         </tr>
                     </tfoot>
						";
					
					$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>4<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>PENDAPATAN<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";	                   	
               
                $sql4="
                select z.kode,z.nama,z.anggaran,z.reali from (
                SELECT left(a.kd_rek5,2) as kode,b.nm_rek2 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek2_64 b on b.kd_rek2 = left(a.kd_rek5,2)                
                where left(a.kd_rek5,1)='4' and left(a.kd_skpd,7)=left('$skpd',7) 
                group by left(a.kd_rek5,2),b.nm_rek2
                union all
                SELECT left(a.kd_rek5,3) as kode,b.nm_rek3 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek3_64 b on b.kd_rek3 = left(a.kd_rek5,3)                
                where left(a.kd_rek5,1)='4' and left(a.kd_skpd,7)=left('$skpd',7) 
                group by left(a.kd_rek5,3),b.nm_rek3
                union all
                SELECT left(a.kd_rek5,5) as kode,b.nm_rek4_64 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek4_64 b on b.kd_rek4_64 = left(a.kd_rek5,5)                
                where left(a.kd_rek5,1)='4' and left(a.kd_skpd,7)=left('$skpd',7) 
                group by left(a.kd_rek5,5),b.nm_rek4_64
                union all
                 SELECT left(a.kd_rek5,7) as kode,b.nm_rek64 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek5 b on b.kd_rek5 = left(a.kd_rek5,7)                
                where left(a.kd_rek5,1)='4' and left(a.kd_skpd,7)=left('$skpd',7) 
                group by left(a.kd_rek5,7),b.nm_rek64
                )z order by kode,nama
                ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil    = $row4->reali;
					$angnil = $row4->anggaran;
					
                    $real_s = $angnil - $nil;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil;
                    }

                    $nilai    = number_format($nil,"2",".",",");
                    $angnilai = number_format($angnil,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai=='' or $angnilai==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil/$angnil)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                   if(strlen("$no")<6){
                    $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                             }else
                             {
					$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">$no</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\">$nama</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\">$x1$selisih$y1</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\">$persen1</td>
                                 </tr>";
                             }
               }
               		$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                    $nil4=0;
                    $angnil4=0;
                    $sql4="
                select z.kode,z.nama,z.anggaran,z.reali from (
                SELECT left(a.kd_rek5,1) as kode,b.nm_rek1 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek1 b on b.kd_rek1 = left(a.kd_rek5,1)                
                where left(a.kd_rek5,1)='4' and left(kd_skpd,7)=left('$skpd',7)  
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
					
                    $real_s = $angnil4 - $nil4;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil4==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil4;
                    }

                    $nilai4    = number_format($nil4,"2",".",",");
                    $angnilai4 = number_format($angnil4,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai4=='' or $angnilai4==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil4/$angnil4)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                    
               $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>JUMLAH $nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai4<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai4<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                   }   
                   
                   $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                      
                   	$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>5<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>BELANJA<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";	                   	
               
                   $sql4="
               select z.kode,z.nama,sum(z.anggaran) as anggaran,sum(z.reali) as reali from(
               
  SELECT left(a.kd_rek5,2) as kode,b.nm_rek2 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd($cbulan,$ag_tox) a
                inner join ms_rek2_64 b on b.kd_rek2 = left(a.kd_rek5,2)                        
                where left(a.kd_rek5,1)='5' and left(a.kd_skpd,7)=left('$skpd',7)  
                group by left(a.kd_rek5,2),b.nm_rek2                
 union all
 
 SELECT left(a.kd_rek5,2) as kode,b.nm_rek2 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_non4_skpd($cbulan,$ag_tox) a
                inner join ms_rek2_64 b on b.kd_rek2 = left(a.kd_rek5,2)                        
                where left(a.kd_rek5,1)='5' and  left(a.kd_skpd,7)=left('$skpd',7) 
                group by left(a.kd_rek5,2),b.nm_rek2
 union all               
  SELECT left(a.kd_rek5,3) as kode,b.nm_rek3 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd($cbulan,$ag_tox) a
                inner join ms_rek3_64 b on b.kd_rek3 = left(a.kd_rek5,3)                        
                where left(a.kd_rek5,1)='5' and  left(a.kd_skpd,7)=left('$skpd',7) 
                group by left(a.kd_rek5,3),b.nm_rek3                
 union all               
  SELECT left(a.kd_rek5,3) as kode,b.nm_rek3 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_non4_skpd($cbulan,$ag_tox) a
                inner join ms_rek3_64 b on b.kd_rek3 = left(a.kd_rek5,3)                        
                where left(a.kd_rek5,1)='5' and  left(a.kd_skpd,7)=left('$skpd',7) 
                group by left(a.kd_rek5,3),b.nm_rek3 
 union all
                
  SELECT left(a.kd_rek5,5) as kode,b.nm_rek4_64 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd($cbulan,$ag_tox) a
                inner join ms_rek4_64 b on b.kd_rek4_64 = left(a.kd_rek5,5)                        
                where left(a.kd_rek5,1)='5' and  left(a.kd_skpd,7)=left('$skpd',7) 
                group by left(a.kd_rek5,5),b.nm_rek4_64   
union all
                
  SELECT left(a.kd_rek5,5) as kode,b.nm_rek4_64 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_non4_skpd($cbulan,$ag_tox) a
                inner join ms_rek4_64 b on b.kd_rek4_64 = left(a.kd_rek5,5)                        
                where left(a.kd_rek5,1)='5' and  left(a.kd_skpd,7)=left('$skpd',7) 
                group by left(a.kd_rek5,5),b.nm_rek4_64                             
 union all
                
  SELECT left(a.kd_rek5,7) as kode,b.nm_rek5 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd($cbulan,$ag_tox) a
                inner join ms_rek5 b on b.kd_rek64 = left(a.kd_rek5,7)                        
                where left(a.kd_rek5,1)='5' and  left(a.kd_skpd,7)=left('$skpd',7) 
                group by left(a.kd_rek5,7),b.nm_rek5   
union all
                
  SELECT left(a.kd_rek5,7) as kode,b.nm_rek5 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_non4_skpd($cbulan,$ag_tox) a
                inner join ms_rek5 b on b.kd_rek64 = left(a.kd_rek5,7)                        
                where left(a.kd_rek5,1)='5' and  left(a.kd_skpd,7)=left('$skpd',7) 
                group by left(a.kd_rek5,7),b.nm_rek5                
       ) z
                group by kode,nama
                order by kode,nama ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil    = $row4->reali;
					$angnil = $row4->anggaran;
					
                    $real_s = $angnil - $nil;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil;
                    }

                    $nilai    = number_format($nil,"2",".",",");
                    $angnilai = number_format($angnil,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai=='' or $angnilai==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil/$angnil)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                   if(strlen("$no")<6){
                    $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                             }else
                             {
					$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">$no</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\">$nama</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\">$x1$selisih$y1</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\">$persen1</td>
                                 </tr>";
                             }
               }  
               
                		$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                    
                    $sql4="
                select z.kode,z.nama,sum(z.anggaran) as anggaran,sum(z.reali) as reali from (
                SELECT left(a.kd_rek5,1) as kode,b.nm_rek1 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek1 b on b.kd_rek1 = left(a.kd_rek5,1)                
                where left(a.kd_rek5,1)='5' and  left(a.kd_skpd,7)=left('$skpd',7) 
                group by left(a.kd_rek5,1),b.nm_rek1 
                union all
                SELECT left(a.kd_rek5,1) as kode,b.nm_rek1 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_non4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek1 b on b.kd_rek1 = left(a.kd_rek5,1)                
                where left(a.kd_rek5,1)='5' and  left(a.kd_skpd,7)=left('$skpd',7) 
                group by left(a.kd_rek5,1),b.nm_rek1
                )z group by kode,nama order by kode,nama
                ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil5    = $row4->reali;
					$angnil5 = $row4->anggaran;
					
                    $real_s = $angnil5 - $nil5;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil5==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil5;
                    }

                    $nilai5    = number_format($nil5,"2",".",",");
                    $angnilai5 = number_format($angnil5,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai5=='' or $angnilai5==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil5/$angnil5)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                
               	$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                     
                    
               $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>JUMLAH $nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai5<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai5<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                   }   
                 
                  	$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                 
                 $no 	= '';
					$nama   = 'SURPLUS/DEFISIT';                      
					$nil    = $nil4 - $nil5;
					$angnil = $angnil4 - $angnil5;
					
                    $real_s = $angnil - $nil;

                    if ($angnil < 0){
                    	$a1="("; $angnil=$angnil*-1; $a2=")";}
                    else {
                    	$a1=""; $a2="";}

                    if ($nil < 0){
                    	$b1="("; $nil=$nil*-1; $b2=")";}
                    else {
                    	$b1=""; $b2="";}

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil;
                    }

                    $nilai    = number_format($nil,"2",".",",");
                    $angnilai = number_format($angnil,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai=='' or $angnilai==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil/$angnil)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                   
                   $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$a1$angnilai$a2<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$b1$nilai$b2<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";         
              
        $cRet .=       " </table>";
        $data['prev']= $cRet;
		 $cRet         .= "</table>";
		 
		 if($txt==1){
		 $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> Mengetahui,</td>
		 <td align=\"center\" width=\"50%\"> Sanggau, $ctgl_ttd </td>
		 </tr>		
		 <tr>
		 <td align=\"center\" width=\"50%\"> $jabatan </td>
		 <td align=\"center\" width=\"50%\"> $jabatan1 </td>
		 </tr>	
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		  <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> $oioi</td>
		 <td align=\"center\" width=\"50%\"> $oioi1</td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> NIP :$nip</td>
		 <td align=\"center\" width=\"50%\"> NIP :$nip1</td>
		 </tr>
         </table>
		 ";}
		$data['prev'] = $cRet;
        $data['sikap'] = 'preview';
        $judul  = 'LAPORAN REALISASI ANGGARAN';
        $this->template->set('title', 'CETAK LAPORAN REALISASI ANGGARAN');        
        switch($cetak) {
		case 1;
			 echo ("<title>L R A</title>"); 
             echo $cRet;
        break;		
        case 0;
             $this->tukd_model->_mpdf('',$cRet,10,10,10,'P');
        break;
        case 2;        
            header("Cache-Control: no-cache, no-store, must-revalidate");
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename= $judul.xls");
            
            $this->load->view('anggaran/rka/perkadaII', $data);
        break;
        case 3;     
            header("Cache-Control: no-cache, no-store, must-revalidate");
            header("Content-Type: application/vnd.ms-word");
            header("Content-Disposition: attachment; filename= $judul.doc");
            $this->load->view('anggaran/rka/perkadaII', $data);
        break;
        } 
    }
	
	
	
function cetak_lra_bulan_rincian_ang_diknas($cbulan='', $cetak='', $txt=''){
	        $txt="1";
			$tanggalttd = $this->uri->segment(5);
            $ttd1 = str_replace('a',' ',$this->uri->segment(6));
            $ttd2 = str_replace('a',' ',$this->uri->segment(7));
            $ctgl_ttd = $this->tukd_model->tanggal_format_indonesia($tanggalttd);
            $bulan = strtoupper($this->tukd_model->getBulan($cbulan));
			$skpd = $this->session->userdata('kdskpd'); 
			$sql1 = "SELECT nm_skpd FROM ms_skpd WHERE kd_skpd='$skpd'";
			$ivan = $this->db->query($sql1);
			$oioi = $ivan->row();
			$nmskpd = $oioi->nm_skpd;
			$realpend=0;
			$anggpend=0;
			
            $sqlanggaran1="select case when statu=1 and status_sempurna=1 and status_ubah=1 and $cbulan>=month(tgl_dpa_ubah) then 2 
					   when statu=1 and status_sempurna=1 and status_ubah=1 and $cbulan>=month(tgl_dpa_sempurna) and $cbulan<month(tgl_dpa_ubah) then 1
					   when statu=1 and status_sempurna=1 and status_ubah=1 and $cbulan<month(tgl_dpa_sempurna) then 1
					   when statu=1 and status_sempurna=1 and status_ubah=0 and $cbulan>=month(tgl_dpa_sempurna) then 1 
					   when statu=1 and status_sempurna=1 and status_ubah=0 and $cbulan<month(tgl_dpa_sempurna) then 1
					   when statu=1 and status_sempurna=0 and status_ubah=0 and $cbulan>=month(tgl_dpa) then 1
					   else 1 end as anggaran from trhrka where kd_skpd='$skpd'";
    $sqlanggaran=$this->db->query($sqlanggaran1);
	foreach ($sqlanggaran->result() as $rowttd)
        {
            $anggaran=$rowttd->anggaran;
        }

	$ag_tox=$anggaran;
            
			$sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab FROM ms_ttd where kd_skpd='$skpd' and kode='PA' and nip='$ttd1'";
            $sqlttd=$this->db->query($sqlttd1);
            foreach ($sqlttd->result() as $rowttd)
			
                {
                    $nip=$rowttd->nip;                    
                    $oioi= $rowttd->nm;
                    $jabatan = $rowttd->jab;
                }			
			
			$sqlttd2="SELECT nama as nm,nip as nip,jabatan as jab FROM ms_ttd where kd_skpd='$skpd' and kode='PPK' and nip='$ttd2'";
            $ttd11=$this->db->query($sqlttd2);
			foreach ($ttd11->result() as $ivan)
			    {
                    $nip1=$ivan->nip;                    
                    $oioi1= $ivan->nm;
                    $jabatan1 = $ivan->jab;
                }
			
       $sqlsc="SELECT tgl_rka,provinsi,kab_kota,daerah,thn_ang FROM sclient where kd_skpd='$skpd'";
                 $sqlsclient=$this->db->query($sqlsc);
                 foreach ($sqlsclient->result() as $rowsc)
                {
                   
                    $tgl=$rowsc->tgl_rka;
                    $tanggal = $this->tukd_model->tanggal_format_indonesia($tgl);
                    $kab     = $rowsc->kab_kota;
                    $daerah  = $rowsc->daerah;
                    $thn     = $rowsc->thn_ang;
                } 
           
        $bersih_skpd= str_replace(".", "", $skpd);
        $print_r = explode(".",$skpd);
        $ke1 = $print_r[0];
        $ke2 = $print_r[1];
        $ke3 = $print_r[2];        
        $ke4 = $print_r[3]; 
        $skkd = $ke1."/".$ke2."/".$ke3;   
            
        $cRet='';
        
       
        $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
                    <tr>
                         <td align=\"center\"><strong>PEMERINTAH KABUPATEN SANGGAU</strong></td>                         
                    </tr>
					 <tr>
                         <td align=\"center\"><strong>$nmskpd</strong></td>                         
                    </tr>
                    <tr>
                         <td align=\"center\"><strong>LAPORAN REALISASI ANGGARAN</strong></td>
                    </tr>                    
                    <tr>
                         <td align=\"center\"><strong>PER 31 $bulan $thn</strong></td>
                    </tr>
                    <tr>
                         <td align=\"center\">&nbsp;</td>
                    </tr>
                  </table>";        
        
        
        $cRet .= "<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"4\">
                     <thead>                       
                        <tr><td bgcolor=\"#CCCCCC\" width=\"5%\" align=\"center\"><b>NO</b></td>                            
                            <td  bgcolor=\"#CCCCCC\" width=\"45%\" align=\"center\"><b>URAIAN</b></td>
                            <td bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>ANGGARAN</b></td>
                            <td bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>REALISASI</b></td>
                            <td  bgcolor=\"#CCCCCC\" width=\"15%\" align=\"center\" ><b>LEBIH</br>(KURANG)</b></td>
                            <td  bgcolor=\"#CCCCCC\" width=\"5%\" align=\"center\" ><b>%</b></td>   
                        </tr>
                        
                     </thead>
                     <tfoot>
                        <tr>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>                           
                         </tr>
                     </tfoot>
						";
					
					$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>4<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>PENDAPATAN<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";	                   	
               
                $sql4="
                select z.kode,z.nama,z.anggaran,z.reali from (
                SELECT left(a.kd_ang,2) as kode,b.nm_rek2 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek2 b on b.kd_rek2 = left(a.kd_ang,2)                
                where left(a.kd_ang,1)='4' and  left(kd_skpd,7)=left('$skpd',7) 
                group by left(a.kd_ang,2),b.nm_rek2
                union all
                SELECT left(a.kd_ang,3) as kode,b.nm_rek3 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek3 b on b.kd_rek3 = left(a.kd_ang,3)                
                where left(a.kd_ang,1)='4' and  left(kd_skpd,7)=left('$skpd',7) 
                group by left(a.kd_ang,3),b.nm_rek3
                union all
                SELECT left(a.kd_ang,5) as kode,b.nm_rek4 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek4 b on b.kd_rek4 = left(a.kd_ang,5)                
                where left(a.kd_ang,1)='4' and  left(kd_skpd,7)=left('$skpd',7) 
                group by left(a.kd_ang,5),b.nm_rek4
                union all
                 SELECT left(a.kd_ang,7) as kode,b.nm_rek64 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek5 b on b.kd_rek5 = left(a.kd_ang,7)                
                where left(a.kd_ang,1)='4' and  left(kd_skpd,7)=left('$skpd',7) 
                group by left(a.kd_ang,7),b.nm_rek64
                )z order by kode,nama
                ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil    = $row4->reali;
					$angnil = $row4->anggaran;
					
                    $real_s = $angnil - $nil;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil;
                    }

                    $nilai    = number_format($nil,"2",".",",");
                    $angnilai = number_format($angnil,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai=='' or $angnilai==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil/$angnil)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                   if(strlen("$no")<6){
                    $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                             }else
                             {
					$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">$no</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\">$nama</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\">$x1$selisih$y1</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\">$persen1</td>
                                 </tr>";
                             }
               }
               		$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                    $nil4=0;
                    $angnil4=0;
                    $sql4="
                select z.kode,z.nama,z.anggaran,z.reali from (
                SELECT left(a.kd_rek5,1) as kode,b.nm_rek1 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek1 b on b.kd_rek1 = left(a.kd_rek5,1)                
                where left(a.kd_rek5,1)='4' and  left(kd_skpd,7)=left('$skpd',7) 
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
					
                    $real_s = $angnil4 - $nil4;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil4==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil4;
                    }

                    $nilai4    = number_format($nil4,"2",".",",");
                    $angnilai4 = number_format($angnil4,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai4=='' or $angnilai4==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil4/$angnil4)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                    
               $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>JUMLAH $nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai4<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai4<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                   }   
                   
                   $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                      
                   	$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>5<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>BELANJA<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";	                   	
               
                   $sql4="
               select z.kode,z.nama,sum(z.anggaran) as anggaran,sum(z.reali) as reali from(
               
  SELECT left(a.kd_ang,2) as kode,b.nm_rek2 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek2 b on b.kd_rek2 = left(a.kd_ang,2)                        
                where left(a.kd_ang,1)='5' and  left(kd_skpd,7)=left('$skpd',7) 
                group by left(a.kd_ang,2),b.nm_rek2                
 union all
               
  SELECT left(a.kd_ang,3) as kode,b.nm_rek3 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek3 b on b.kd_rek3 = left(a.kd_ang,3)                        
                where left(a.kd_ang,1)='5' and  left(kd_skpd,7)=left('$skpd',7) 
                group by left(a.kd_ang,3),b.nm_rek3                
 union all
                
  SELECT left(a.kd_ang,5) as kode,b.nm_rek4 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek4 b on b.kd_rek4 = left(a.kd_ang,5)                        
                where left(a.kd_ang,1)='5' and  left(kd_skpd,7)=left('$skpd',7) 
                group by left(a.kd_ang,5),b.nm_rek4               
 union all
 
                
  SELECT left(a.kd_ang,7) as kode,b.nm_rek5 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek5 b on b.kd_rek5 = left(a.kd_ang,7)                        
                where left(a.kd_ang,1)='5' and  left(kd_skpd,7)=left('$skpd',7)  
                group by left(a.kd_ang,7),b.nm_rek5   
                ) z
                group by kode,nama
                order by kode,nama ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil    = $row4->reali;
					$angnil = $row4->anggaran;
					
                    $real_s = $angnil - $nil;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil;
                    }

                    $nilai    = number_format($nil,"2",".",",");
                    $angnilai = number_format($angnil,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai=='' or $angnilai==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil/$angnil)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                   if(strlen("$no")<6){
                    $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                             }else
                             {
					$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">$no</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\">$nama</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$angnilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\">$x1$selisih$y1</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\">$persen1</td>
                                 </tr>";
                             }
               }  
               
                		$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                    
                    $sql4="
                select z.kode,z.nama,sum(z.anggaran) as anggaran,sum(z.reali) as reali from (
                SELECT left(a.kd_ang,1) as kode,b.nm_rek1 as nama,sum(a.nilai_ang) as anggaran,sum(a.real_spj) as reali FROM data_realisasi_keg4_skpd( $cbulan,$ag_tox) a
                inner join ms_rek1 b on b.kd_rek1 = left(a.kd_ang,1)                
                where left(a.kd_ang,1)='5' and  left(kd_skpd,7)=left('$skpd',7) 
                group by left(a.kd_ang,1),b.nm_rek1 
                )z group by kode,nama order by kode,nama
                ";
						                 
                $query4 = $this->db->query($sql4);
                
                foreach ($query4->result() as $row4)
                {
					$no 	= $row4->kode;
					$nama   = $row4->nama;                      
					$nil5    = $row4->reali;
					$angnil5 = $row4->anggaran;
					
                    $real_s = $angnil5 - $nil5;

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil5==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil5;
                    }

                    $nilai5    = number_format($nil5,"2",".",",");
                    $angnilai5 = number_format($angnil5,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai5=='' or $angnilai5==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil5/$angnil5)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                
               	$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                     
                    
               $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>JUMLAH $nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$angnilai5<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai5<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";
                   }   
                 
                  	$cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                 </tr>";
                 
                 $no 	= '';
					$nama   = 'SURPLUS/DEFISIT';                      
					$nil    = $nil4 - $nil5;
					$angnil = $angnil4 - $angnil5;
					
                    $real_s = $angnil - $nil;

                    if ($angnil < 0){
                    	$a1="("; $angnil=$angnil*-1; $a2=")";}
                    else {
                    	$a1=""; $a2="";}

                    if ($nil < 0){
                    	$b1="("; $nil=$nil*-1; $b2=")";}
                    else {
                    	$b1=""; $b2="";}

                    if ($real_s < 0){
                    	$x1="("; $real_s=$real_s*-1; $y1=")";}
                    else {
                    	$x1=""; $y1="";}
                    
                    $selisih = number_format($real_s,"2",".",",");
                    
                    if ($nil==0){
                        $tmp=1;
                    }else{
                        $tmp=$nil;
                    }

                    $nilai    = number_format($nil,"2",".",",");
                    $angnilai = number_format($angnil,"2",".",",");
                    $per1     = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    
					if( $angnilai=='' or $angnilai==0){
					$persen1 = '';
					}else{
					$persen1 = ($nil/$angnil)*100;
					$persen1 = number_format($persen1,"1",".",",");

					}
                   
                   $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"left\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$a1$angnilai$a2<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$b1$nilai$b2<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>$x1$selisih$y1<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b>$persen1<b></td>
                                 </tr>";         
              
        $cRet .=       " </table>";
        $data['prev']= $cRet;
		 $cRet         .= "</table>";
		 
		 if($txt==1){
		 $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> Mengetahui</td>
		 <td align=\"center\" width=\"50%\"> Sanggau, $ctgl_ttd </td>
		 </tr>		
		 <tr>
		 <td align=\"center\" width=\"50%\"> $jabatan </td>
		 <td align=\"center\" width=\"50%\"> $jabatan1 </td>
		 </tr>	
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		  <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> $oioi</td>
		 <td align=\"center\" width=\"50%\"> $oioi1</td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> NIP :$nip</td>
		 <td align=\"center\" width=\"50%\"> NIP :$nip1 </td>
		 </tr>
         </table>
		 ";}
		$data['prev'] = $cRet;
        $data['sikap'] = 'preview';
        $judul  = 'LAPORAN REALISASI ANGGARAN';
        $this->template->set('title', 'CETAK LAPORAN REALISASI ANGGARAN');        
        switch($cetak) {
		case 1;
			 echo ("<title>L R A</title>"); 
             echo $cRet;
        break;		
        case 0;
             $this->tukd_model->_mpdf('',$cRet,10,10,10,'P');
        break;
        case 2;        
            header("Cache-Control: no-cache, no-store, must-revalidate");
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename= $judul.xls");
            
            $this->load->view('anggaran/rka/perkadaII', $data);
        break;
        case 3;     
            header("Cache-Control: no-cache, no-store, must-revalidate");
            header("Content-Type: application/vnd.ms-word");
            header("Content-Disposition: attachment; filename= $judul.doc");
            $this->load->view('anggaran/rka/perkadaII', $data);
        break;
        } 
    }


  
}    