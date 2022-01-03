<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class realisasi_penerimaanController extends CI_Controller {

	function __construct()
	{	 
		parent::__construct();
		$this->load->model('master_model','master_model');	
	}  
	
	
    function index(){ 
		$data['page_title']= 'CETAK REGISTER';
        $this->template->set('title', 'CETAK REGISTER');      
		$this->template->load('template','tukd/register/realisasi_penerimaan',$data) ;  			        

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


    function list_ttd() {
        $sql = "SELECT nip,nama,jabatan,kd_skpd FROM ms_ttd where kode='BUD' order by nama";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'nip' => $resulte['nip'],  
                        'nama' => $resulte['nama'],  
                        'jabatan' => $resulte['jabatan'],
                        'kd_skpd' => $resulte['kd_skpd']
                        );
                        $ii++;
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



  function cetak_lra_pendapatan($dcetak='',$ttd='',$dcetak2='', $jenisx=1,$atas='',$bawah='',$kiri='',$kanan=''){  
	  
	    $sqlsc="SELECT tgl_rka,provinsi,kab_kota,daerah,thn_ang FROM sclient";
                 $sqlsclient=$this->db->query($sqlsc);
                 foreach ($sqlsclient->result() as $rowsc)
                {
                    $kab     = $rowsc->kab_kota;
                    $daerah  = $rowsc->daerah;
                   
                }  
				
				
	$sql = "SELECT nip,nama,jabatan,kd_skpd FROM ms_ttd where kode='BUD' and nip='$ttd'";
        $query1 = $this->db->query($sql);  

        foreach($query1->result() as $rows)
        { 
           
		   $cnip     	= $rows->nip;
           $cnama  		= $rows->nama;
		   $cjabatan  	= $rows->jabatan;


        }				
	  
        //$id = $skpd;
    error_reporting(0);
    $cetak = $jenisx;
        $thn_ang = $this->session->userdata('pcThang');
    $tgl_ttd = $dcetak2;
        $cRet='';   
    $tgl  = explode("-",$dcetak2);
    $cbulan = $tgl[1];
        $lcperiode = $this->tukd_model->getBulan($tgl[1]);
    //$lcperiode = $this->tanggal_format_indonesia($sampaitgl);
       
        $cRet .=" <table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
                         <td align=\"center\" colspan=\"8\"><strong>KAS DAERAH</strong></td>                         
                    </tr>
          <tr>
                         <td align=\"center\" colspan=\"8\"><strong>$kab</strong></td>
                    </tr>
                    <tr>
                         <td align=\"center\" colspan=\"8\"><strong>LAPORAN REALISASI PENERIMAAN </strong></td>
                    </tr>                    
                    <tr>
                         <td align=\"center\" colspan=\"8\"><strong>SAMPAI TANGGAL ".$this->tanggal_format_indonesia($dcetak2)."</strong></td>
                    </tr>
                    <tr>
                         <td align=\"center\" colspan=\"8\">&nbsp;</td>
                    </tr>
          <tr>
                         <td align=\"center\" colspan=\"8\">&nbsp;</td>
                    </tr>
                  </table>";        
      
        $cRet .= "<table style=\"border-collapse:collapse; font-size:14px;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"2\" cellpadding=\"2\" >
                     <thead>                       
                        <tr><td bgcolor=\"#CCCCCC\" width=\"10%\" align=\"center\"><b>Kd</b></td>                            
                            <td  bgcolor=\"#CCCCCC\" width=\"18%\" align=\"center\"><b>URAIAN</b></td>
                            <td bgcolor=\"#CCCCCC\" width=\"14%\" align=\"center\"><b>Anggaran</b></td>
              <td bgcolor=\"#CCCCCC\" width=\"13%\" align=\"center\"><b>Bulan<br>lalu</b></td>
              <td bgcolor=\"#CCCCCC\" width=\"13%\" align=\"center\"><b>Bulan<br>ini</b></td>
              <td bgcolor=\"#CCCCCC\" width=\"13%\" align=\"center\"><b>Jumlah s/d <br>Bulan Ini</b></td>
              <td bgcolor=\"#CCCCCC\" width=\"5%\" align=\"center\"><b>%</b></td>
              <td bgcolor=\"#CCCCCC\" width=\"14%\" align=\"center\"><b>Sisa<br>Anggaran</b></td>
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
              <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                         </tr>
                     </tfoot>
                   
                     <tr>
              <td style=\"vertical-align:top;border-top: none;border-bottom: none;\">&nbsp;</td>                            
                            <td style=\"vertical-align:top;border-top: none;border-bottom: none;\">&nbsp;</td>
                            <td style=\"vertical-align:top;border-top: none;border-bottom: none;\">&nbsp;</td>
              <td style=\"vertical-align:top;border-top: none;border-bottom: none;\">&nbsp;</td>                            
                            <td style=\"vertical-align:top;border-top: none;border-bottom: none;\">&nbsp;</td>
                            <td style=\"vertical-align:top;border-top: none;border-bottom: none;\">&nbsp;</td>
              <td style=\"vertical-align:top;border-top: none;border-bottom: none;\">&nbsp;</td>
                            <td style=\"vertical-align:top;border-top: none;border-bottom: none;\">&nbsp;</td>
                     </tr>";
 
           $sql4="SELECT z.* FROM (
                SELECT  b.kd_rek1 AS kd_rek,b.nm_rek1 AS nm_rek,SUM(nilai_ubah) AS anggaran,
                isnull((SELECT SUM( c.rupiah) FROM trdkasin_ppkd c INNER JOIN trhkasin_ppkd d ON c.no_sts = d.no_sts WHERE LEFT(c.kd_rek6,1)='4' AND d.tgl_sts < '$dcetak'),0)+
                isnull((SELECT SUM( cc.nilai) FROM tr_terima_ppkd cc WHERE LEFT(cc.kd_rek5,1)='4' AND cc.tgl_terima < '$dcetak'),0) AS nilailalu,
                isnull((SELECT SUM( c.rupiah) FROM trdkasin_ppkd c INNER JOIN trhkasin_ppkd d ON c.no_sts = d.no_sts WHERE LEFT(c.kd_rek6,1)='4' AND  d.tgl_sts between '$dcetak' and '$dcetak2'),0)+
                isnull((SELECT SUM( cc.nilai) FROM tr_terima_ppkd cc WHERE LEFT(cc.kd_rek5,1)='4' AND cc.tgl_terima between '$dcetak' and '$dcetak2'),0) AS nilai
                FROM ms_rek1 b INNER JOIN trdrka a ON LEFT(a.kd_rek6,1)=b.kd_rek1 
                WHERE LEFT(b.kd_rek1,1) IN ('4')  GROUP BY b.kd_rek1 ,b.nm_rek1
                UNION ALL
                SELECT  b.kd_rek2 AS kd_rek,b.nm_rek2 AS nm_rek,SUM(nilai_ubah) AS anggaran,
                isnull((SELECT SUM( c.rupiah) FROM trdkasin_ppkd c INNER JOIN trhkasin_ppkd d ON c.no_sts = d.no_sts WHERE LEFT(c.kd_rek6,2)=b.kd_rek2 AND d.tgl_sts < '$dcetak'),0)+
                isnull((SELECT SUM( cc.nilai) FROM tr_terima_ppkd cc WHERE LEFT(cc.kd_rek5,2)=b.kd_rek2 AND cc.tgl_terima < '$dcetak'),0) AS nilailalu,
                isnull((SELECT SUM( c.rupiah) FROM trdkasin_ppkd c INNER JOIN trhkasin_ppkd d ON c.no_sts = d.no_sts WHERE LEFT(c.kd_rek6,2)=b.kd_rek2 AND d.tgl_sts between '$dcetak' and '$dcetak2'),0)+
                isnull((SELECT SUM( cc.nilai) FROM tr_terima_ppkd cc WHERE LEFT(cc.kd_rek5,2)=b.kd_rek2 AND cc.tgl_terima between '$dcetak' and '$dcetak2'),0) AS nilai
                FROM ms_rek2 b INNER JOIN trdrka a ON LEFT(a.kd_rek6,2)=b.kd_rek2 
                WHERE LEFT(b.kd_rek2,1) IN ('4')  GROUP BY b.kd_rek2 ,b.nm_rek2
                UNION ALL
                SELECT  b.kd_rek3 AS kd_rek,b.nm_rek3 AS nm_rek,SUM(nilai_ubah) AS anggaran,
                isnull((SELECT SUM( c.rupiah) FROM trdkasin_ppkd c INNER JOIN trhkasin_ppkd d ON c.no_sts = d.no_sts WHERE LEFT(c.kd_rek6,4)=b.kd_rek3 AND d.tgl_sts < '$dcetak'),0)+
                isnull((SELECT SUM( cc.nilai) FROM tr_terima_ppkd cc WHERE LEFT(cc.kd_rek5,4)=b.kd_rek3 AND cc.tgl_terima < '$dcetak'),0) AS nilailalu,
                isnull((SELECT SUM( c.rupiah) FROM trdkasin_ppkd c INNER JOIN trhkasin_ppkd d ON c.no_sts = d.no_sts WHERE LEFT(c.kd_rek6,4)=b.kd_rek3 AND d.tgl_sts between '$dcetak' and '$dcetak2'),0)+
                isnull((SELECT SUM( cc.nilai) FROM tr_terima_ppkd cc WHERE LEFT(cc.kd_rek5,4)=b.kd_rek3 AND cc.tgl_terima between '$dcetak' and '$dcetak2'),0) AS nilai
                FROM ms_rek3 b INNER JOIN trdrka a ON LEFT(a.kd_rek6,4)=b.kd_rek3 
                WHERE LEFT(b.kd_rek3,1) IN ('4')  GROUP BY b.kd_rek3 ,b.nm_rek3
                UNION ALL
                SELECT  b.kd_rek4 AS kd_rek,b.nm_rek4 AS nm_rek,SUM(nilai_ubah) AS anggaran,
                isnull((SELECT SUM( c.rupiah) FROM trdkasin_ppkd c INNER JOIN trhkasin_ppkd d ON c.no_sts = d.no_sts WHERE LEFT(c.kd_rek6,6)=b.kd_rek4 AND d.tgl_sts < '$dcetak'),0)+
                isnull((SELECT SUM( cc.nilai) FROM tr_terima_ppkd cc WHERE LEFT(cc.kd_rek5,6)=b.kd_rek4 AND cc.tgl_terima < '$dcetak'),0) AS nilailalu,
                isnull((SELECT SUM( c.rupiah) FROM trdkasin_ppkd c INNER JOIN trhkasin_ppkd d ON c.no_sts = d.no_sts WHERE LEFT(c.kd_rek6,6)=b.kd_rek4 AND d.tgl_sts between '$dcetak' and '$dcetak2'),0)+
                isnull((SELECT SUM( cc.nilai) FROM tr_terima_ppkd cc WHERE LEFT(cc.kd_rek5,6)=b.kd_rek4 AND cc.tgl_terima between '$dcetak' and '$dcetak2'),0) AS nilai
                FROM ms_rek4 b INNER JOIN trdrka a ON LEFT(a.kd_rek6,6)=b.kd_rek4 
                WHERE LEFT(b.kd_rek4,1) IN ('4')  GROUP BY b.kd_rek4 ,b.nm_rek4
                UNION ALL
                SELECT  b.kd_rek5 AS kd_rek,b.nm_rek5 AS nm_rek,SUM(nilai_ubah) AS anggaran,
                isnull((SELECT SUM( c.rupiah) FROM trdkasin_ppkd c INNER JOIN trhkasin_ppkd d ON c.no_sts = d.no_sts WHERE LEFT(c.kd_rek6,8)=b.kd_rek5 AND d.tgl_sts < '$dcetak'),0)+
                isnull((SELECT SUM( cc.nilai) FROM tr_terima_ppkd cc WHERE LEFT(cc.kd_rek5,8)=b.kd_rek5 AND cc.tgl_terima < '$dcetak'),0) AS nilailalu,
                isnull((SELECT SUM( c.rupiah) FROM trdkasin_ppkd c INNER JOIN trhkasin_ppkd d ON c.no_sts = d.no_sts WHERE LEFT(c.kd_rek6,8)=b.kd_rek5 AND d.tgl_sts between '$dcetak' and '$dcetak2'),0) +
                isnull((SELECT SUM( cc.nilai) FROM tr_terima_ppkd cc WHERE LEFT(cc.kd_rek5,8)=b.kd_rek5 AND cc.tgl_terima between '$dcetak' and '$dcetak2'),0) AS nilai
                FROM ms_rek5 b INNER JOIN trdrka a ON LEFT(a.kd_rek6,8)=b.kd_rek5 
                WHERE LEFT(b.kd_rek5,1) IN ('4')  GROUP BY b.kd_rek5 ,b.nm_rek5
                UNION ALL
                SELECT  b.kd_rek6 AS kd_rek,b.nm_rek6 AS nm_rek,SUM(nilai_ubah) AS anggaran,
                isnull((SELECT SUM( c.rupiah) FROM trdkasin_ppkd c INNER JOIN trhkasin_ppkd d ON c.no_sts = d.no_sts WHERE LEFT(c.kd_rek6,12)=b.kd_rek6 AND d.tgl_sts < '$dcetak'),0) +
                isnull((SELECT SUM( cc.nilai) FROM tr_terima_ppkd cc WHERE LEFT(cc.kd_rek5,12)=b.kd_rek6 AND cc.tgl_terima < '$dcetak'),0) AS nilailalu,
                isnull((SELECT SUM( c.rupiah) FROM trdkasin_ppkd c INNER JOIN trhkasin_ppkd d ON c.no_sts = d.no_sts WHERE LEFT(c.kd_rek6,12)=b.kd_rek6 AND d.tgl_sts between '$dcetak' and '$dcetak2'),0) +
                isnull((SELECT SUM( cc.nilai) FROM tr_terima_ppkd cc WHERE LEFT(cc.kd_rek5,12)=b.kd_rek6 AND cc.tgl_terima between '$dcetak' and '$dcetak2'),0) AS nilai
                FROM ms_rek6 b INNER JOIN trdrka a ON LEFT(a.kd_rek6,12)=b.kd_rek6
                WHERE LEFT(b.kd_rek6,1) IN ('4')  GROUP BY b.kd_rek6,b.nm_rek6
                ) z ORDER BY kd_rek";
        $query4 = $this->db->query($sql4);
                $totanggaran=0;
        $totnilai=0;
        $totnilailalu=0;
        $totsisa=0;
                $no=0;                                  
                foreach ($query4->result() as $row4)
                {
                    $kode=$row4->kd_rek;
          $kd=strlen($kode);
          $nama=$row4->nm_rek; 
          $anggaran=$row4->anggaran;
                    $anggaranx=number_format($anggaran,"2"); 
          
          if($row4->nilai == null){ $nilai = 0; }else{ $nilai = $row4->nilai; }
          if($row4->nilailalu == null){ $nilailalu = 0; }else{ $nilailalu = $row4->nilailalu; }
          
          $nilaix=number_format($nilai,"2"); 
          $nilailalux=number_format($nilailalu,"2"); 
          $nilaixx=number_format($nilai+$nilailalu,"2"); 
          $sisa=number_format($anggaran-($nilai+$nilailalu),"2"); 
          

                    $real_s =$nilai+$nilailalu ;
          $sisax   =$anggaran-($nilai+$nilailalu);
                    if ($sisax < 0){
                      $x1="("; $sisax=$sisax*-1; $y1=")";}
                    else {
                      $x1=""; $y1="";}
                    $selisih = number_format($sisax,"2",".",",");
                    if ($anggaran==0){
                        $tmp=1;
            $per1   = 100; 
                    }else{
                        $tmp=$anggaran;
            $per1   = ($real_s!=0)?($real_s / $tmp ) * 100:0; 
                    }
                    $persen1= number_format($per1,2);
          
          
          if($kd<=8){
             $cRet    .= "<tr>
 
                  <td style=\"vertical-align:top;border-top: none;border-bottom: none;\"><b>$kode</b></td>                            
                  <td style=\"vertical-align:top;border-top: none;border-bottom: none;\"><b>$nama</b></td>
                  <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" align=\"right\"><b>$anggaranx</b></td>
                  <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" align=\"right\"><b>$nilailalux</b></td>                            
                  <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" align=\"right\"><b>$nilaix</b></td>
                  <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" align=\"right\"><b>$nilaixx</b></td>
                  <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" align=\"right\"><b>$persen1</b></td>
                  <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" align=\"right\"><b>$x1$selisih$y1</b></td>

                                 </tr>";
			 
								 
          }else{
             $cRet    .= "<tr>
                  
                  <td style=\"vertical-align:top;border-top: none;border-bottom: none;\">$kode</td>                            
                  <td style=\"vertical-align:top;border-top: none;border-bottom: none;\">$nama</td>
                  <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" align=\"right\">$anggaranx</td>
                  <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" align=\"right\">$nilailalux</td>                            
                  <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" align=\"right\">$nilaix</td>
                  <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" align=\"right\">$nilaixx</td>
                  <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" align=\"right\">$persen1</td>
                  <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" align=\"right\">$x1$selisih$y1</td>
                                 </tr>";
            $totanggaran=$totanggaran+$anggaran;
            $totnilai=$totnilai+$nilai;
            $totnilailalu=$totnilailalu+$nilailalu;
            //$totsisa=$totsisa+$sisax;
            $totsisa = $totanggaran-($totnilailalu+$totnilai);
          }

			  } 

		if($bawah>=1){
			for($i=1;$i<$bawah;$i++){
				$cRet .="<tr>
							 <td style=\"vertical-align:top;border-top: none;border-bottom: none;\">&nbsp;</td>                            
							  <td style=\"vertical-align:top;border-top: none;border-bottom: none;\">&nbsp;</td>
							  <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" align=\"right\">&nbsp;</td>
							  <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" align=\"right\">&nbsp;</td>                            
							  <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" align=\"right\">&nbsp;</td>
							  <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" align=\"right\">&nbsp;</td>
							  <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" align=\"right\">&nbsp;</td>
							  <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" align=\"right\">&nbsp;</td>
						</tr>";
			}
		}

                              
          $totanggaranx=number_format($totanggaran,"2");
          $totnilaix=number_format($totnilai,"2");
          $totnilailalux=number_format($totnilailalu,"2");
          $totsisaxx=number_format($totnilai+$totnilailalu,"2");
          $totsisax=number_format($totsisa,"2");
          $totreal_s=$totnilai+$totnilailalu;
          $tmp=$totanggaran;
          $totper1   = ($totreal_s!=0)?($totreal_s / $tmp ) * 100:0; 
          $totpersen1= number_format($totper1,2);
         $cRet    .= "<tr>
            <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" align=\"left\"></td>                                     
                        <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" align=\"left\"><b>JUMLAH<b></td>
                        <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" align=\"right\"><b>$totanggaranx</b></td>
            <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" align=\"right\"><b>$totnilailalux</b></td>                            
            <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" align=\"right\"><b>$totnilaix</b></td>
            <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" align=\"right\"><b>$totsisaxx</b></td>
            <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" align=\"right\"><b>$totpersen1</b></td>
            <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" align=\"right\"><b>$totsisax</b></td>

                    </tr>";
					
					
					
        $cRet .= " </table><br>";
    $cRet.='<TABLE border="0" width="100%"  style="font-size:16px;">
          <TR>
            <TD  width="50%" align="center" ></TD>
            <TD  width="50%" align="center" >'.$this->tukd_model->get_sclient('daerah','sclient').', '.$this->tanggal_format_indonesia($dcetak2).'</TD>
          </TR>         
          <TR>
            <TD  width="50%" align="center" ><B></B></TD>
            <TD  width="50%" align="center" ><B>'.$cjabatan.'</B></TD> 
          </TR>         
          <TR>
            <TD  width="50%" align="center" >&nbsp;</TD>
            <TD  width="50%" align="center" >&nbsp;</TD> 
          </TR>         
          <TR>
            <TD  width="50%" align="center" >&nbsp;</TD>
            <TD  width="50%" align="center" >&nbsp;</TD> 
          </TR>         
          <TR>
            <TD  width="50%" align="center" >&nbsp;</TD>
            <TD  width="50%" align="center" >&nbsp;</TD> 
          </TR>         
          <TR>
            <TD  width="50%" align="center" >&nbsp;</TD>
            <TD  width="50%" align="center" >&nbsp;</TD> 
          </TR>    
          <TR>
            <TD  width="50%" align="center" ><B></B></TD>
            <TD  width="50%" align="center" ><B>'.$cnama.'</B></TD> 
          </TR> 		  
          <TR>
            <TD  width="50%" align="center" ></TD>
            <TD  width="50%" align="center" >NIP:'.$cnip.'</TD> 
          </TR>         
          </TABLE>
          ';
		  

        $data['prev']= $cRet;
        $data['sikap'] = 'preview';
        $judul  = 'LRA PENDAPATAN';
        $this->template->set('title', 'CETAK LRA PENDAPATAN');        
        switch($cetak) {       
        case 2;
           //  $this->tukd_model->_mpdf('',$cRet,5,5,5,'1');
		   
		   $this->_mpdf_margin('',$cRet,10,10,10,'L',0,'',$atas,$bawah,$kiri,$kanan);
        break;
        case 1;        
           $skpd = $this->session->userdata('kdskpd');
            header("Cache-Control: no-cache, no-store, must-revalidate");
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename= LRA Pendapatan-$lcperiode.xls");
      
       $this->load->view('anggaran/rka/perkadaII', $data);
        break;
        
        } 
        
                 
    }

	

 function _mpdf_margin($judul='',$isi='',$lMargin=10,$rMargin=10,$font='',$orientasi='',$hal='', $fonsize='',$atas='', $bawah='', $kiri='', $kanan='') {
                

        ini_set("memory_limit","-1M");
        ini_set("MAX_EXECUTION_TIME","-1");
        $this->load->library('mpdf');
		//$this->mpdf->SetHeader('||Halaman {PAGENO} /{nb}');
        
        
        $this->mpdf->defaultheaderfontsize = 10;	/* in pts */
        $this->mpdf->defaultheaderfontstyle = I;	/* blank, B, I, or BI */
        $this->mpdf->defaultheaderline = 1; 	/* 1 to include line below header/above footer */

        $this->mpdf->defaultfooterfontsize = 3;	/* in pts */
        $this->mpdf->defaultfooterfontstyle = I;	/* blank, B, I, or BI */
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
        $this->mpdf->AddPage($orientasi,'',$hal,'1','off',$kiri,$kanan,$atas,$bawah);
		if ($hal==''){
			$this->mpdf->SetFooter("");
		}
		else{
			$this->mpdf->SetFooter("Printed on Simakda SKPD || Halaman {PAGENO}  ");
		}
        if (!empty($judul)) $this->mpdf->writeHTML($judul);
        $this->mpdf->writeHTML($isi);         
        $this->mpdf->Output();
               
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

}	