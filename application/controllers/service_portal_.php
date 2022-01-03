<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class service_portal extends CI_Controller {

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
    
    function ambil_data()
    {
        $data['page_title']= 'DATA PORTAL';
        $this->template->set('title', 'DATA PORTAL');   
        $this->template->load('template','portal/ambildata',$data) ; 
    }  
    
    function ambil_data_simbada()
    {
        $data['page_title']= 'DATA PORTAL SIMBADA';
        $this->template->set('title', 'DATA PORTAL SIMBADA');   
        $this->template->load('template','portal/ambildata_simbada',$data) ; 
    } 
    
    function view_data(){
        $curl = curl_init();
        $par1 = urlencode("getData");
        $par2 = urlencode("8e296a067a37563370ded05f5a3bf3ec");
        $apikey = "0D610BE3B91DF2B2EDC5EC71787AFA26";
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://portaldata.pontianakkota.go.id/api/v1",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "app=$par1&query_id=$par2",
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded;charset=UTF-8",
                "Accept: application/json",
                "x-api-key: $apikey",),));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            
            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                
                $tabel = "sipp_proggiat_temp";
                $kolom = "(id_urusan,kode_urusan,urusan,id_bidang,kode_bidang,bidang,id_program,kode_program,program,id_kegiatan,kode_kegiatan,kegiatan)";                
                $sql = "delete from $tabel";					
				$this->db->query($sql);
               
                $result = json_decode($response);                
                $json = $result->data;
                $data = json_encode($json);
                $data = json_decode($data);                
                
                $json_row = $result->total_data;
                print_r($data);
                    
            }   
           
	}
    
    function request_data(){
        $parkey = $this->uri->segment(3);
        $parth = $this->uri->segment(4);
        $parskpd = $this->uri->segment(5);
        
        $curl = curl_init();
        $par1 = urlencode("getData");
        //$par2 = urlencode("4e732ced3463d06de0ca9a15b6153677");
        $par2 = urlencode($parkey);
        $par3 = urlencode($parth);
        $par4 = urlencode($parskpd);
        $apikey = "0D610BE3B91DF2B2EDC5EC71787AFA26";
        
        if($parskpd==""){
            curl_setopt_array($curl, array(
            CURLOPT_URL => "http://bebas.pontianakkota.online/api/v1",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "app=$par1&query_id=$par2",
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded;charset=UTF-8",
                "Accept: application/json",
                "x-api-key: $apikey",),));
        }else{
            curl_setopt_array($curl, array(
            CURLOPT_URL => "http://bebas.pontianakkota.online/api/v1",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "app=$par1&query_id=$par2&params[tahun]=$par3&params[kode_skpd]=$par4",
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded;charset=UTF-8",
                "Accept: application/json",
                "x-api-key: $apikey",),));
        }
        
        
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            
            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                                
                if($parkey=="4e732ced3463d06de0ca9a15b6153677"){                
                $tabel = "sipp_proggiat_temp";
                $kolom = "(id_urusan,kode_urusan,urusan,id_bidang,kode_bidang,bidang,id_program,kode_program,program,id_kegiatan,kode_kegiatan,kegiatan)";                
                $sql = "delete from $tabel";					
				$this->db->query($sql);
               
                $result = json_decode($response);                
                $json = $result->data;
                $data = json_encode($json);
                $data = json_decode($data);                
                
                $json_row = $result->total_data;
                
                $jm = $json_row;					
					for ($i = 0; $i < $jm; $i++) {
                                                
			        $nilai = "(
                    '".$data[$i]->id_urusan."',
                    '".$data[$i]->kode_urusan."',
                    '".$data[$i]->urusan."',
                    '".$data[$i]->id_bidang."',
                    '".$data[$i]->kode_bidang."',
                    '".$data[$i]->bidang."',
                    '".$data[$i]->id_program."',
                    '".$data[$i]->kode_program."',
                    '".str_replace("'","",$data[$i]->program)."',
                    '".$data[$i]->id_kegiatan."',
                    '".$data[$i]->kode_kegiatan."',
                    '".str_replace("'","",$data[$i]->kegiatan)."')";	
                    
                    $sql = "insert into $tabel $kolom values $nilai";					
					$asg = $this->db->query($sql);                    											
                    //print_r($nilai);                                                                                                        
					}
                    
                    if(!$asg){                        
                            echo '2';
                        }else{
                            if($i==$jm){
                            echo '1';   
                            }
                        }
                    
                
                    }else{
                        
                $tabel = "sipp_renja_temp";
                $kolom = "(id,kode_urusan,urusan,kode_bidang,bidang,kode_skpd,skpd,kode_program,program,kode_kegiatan,kegiatan,fisik_nonfisik,baru_lanjutan,catatan,sasaran_kegiatan,lokasi_kegiatan,apbd_kab,apbd_dak,apbd_prov,apbn,partisipasi_masyarakat,swasta,pagu_sebelumnya,tu_prog,tk_prog,tu_mas,tk_mas,tu,tk,tu_has,tk_has,tahun,date_create,date_update)";                
                $sql = "delete from $tabel where tahun='$parth' and kode_skpd='$parskpd'";					
				$this->db->query($sql);
               
                $result = json_decode($response);                
                $json = $result->data;
                $data = json_encode($json);
                $data = json_decode($data);                
                
                $json_row = $result->total_data;
                
                $jm = $json_row;					
					for ($i = 0; $i < $jm; $i++) {
                    
                    if(is_null($data[$i]->apbd_kab)){$n_apbd_kab = 0;}else{$n_apbd_kab = $data[$i]->apbd_kab;}
                    if(is_null($data[$i]->apbd_dak)){$n_apbd_dak = 0;}else{$n_apbd_dak = $data[$i]->apbd_dak;}
                    if(is_null($data[$i]->apbd_prov)){$n_apbd_prov=0;}else{$n_apbd_prov = $data[$i]->apbd_prov;}
                    
                    if(is_null($data[$i]->apbn)){$n_apbn=0;}else{$n_apbn = $data[$i]->apbn;}
                    if(is_null($data[$i]->partisipasi_masyarakat)){$n_partisipasi_masyarakat=0;}else{$n_partisipasi_masyarakat = $data[$i]->partisipasi_masyarakat;}
                    if(is_null($data[$i]->swasta)){$n_swasta=0;}else{$n_swasta = $data[$i]->swasta;}
                    if(is_null($data[$i]->pagu_sebelumnya)){$n_pagu_sebelumnya=0;}else{$n_pagu_sebelumnya = $data[$i]->pagu_sebelumnya;}
                                                
			        $nilai = "(
                    '".$data[$i]->id."',
                    '".$data[$i]->kode_urusan."',
                    '".$data[$i]->urusan."',
                    '".$data[$i]->kode_bidang."',
                    '".$data[$i]->bidang."',
                    '".$data[$i]->kode_skpd."',
                    '".$data[$i]->skpd."',                  
                    '".$data[$i]->kode_program."',
                    '".str_replace("'","",$data[$i]->program)."',              
                    '".$data[$i]->kode_kegiatan."',
                    '".str_replace("'","",$data[$i]->kegiatan)."',
                    
                    '".$data[$i]->fisik_nonfisik."',
                    '".$data[$i]->baru_lanjutan."',
                    '".$data[$i]->catatan."',
                    '".$data[$i]->sasaran_kegiatan."',
                    '".$data[$i]->lokasi_kegiatan."',
                    '".$n_apbd_kab."',
                    '".$n_apbd_dak."',
                    '".$n_apbd_prov."',
                    '".$n_apbn."',
                    '".$n_partisipasi_masyarakat."',
                    '".$n_swasta."',
                    '".$n_pagu_sebelumnya."',
                    '".$data[$i]->tu_prog."',
                    '".$data[$i]->tk_prog."',
                    '".$data[$i]->tu_mas."',
                    '".$data[$i]->tk_mas."',
                    '".$data[$i]->tu."',
                    '".$data[$i]->tk."',
                    '".$data[$i]->tu_has."',
                    '".$data[$i]->tk_has."',
                    '".$data[$i]->tahun."',
                    '".$data[$i]->date_create."',
                    '".$data[$i]->date_update."'
                    
                    
                    )";	
                    
                    $sql = "insert into $tabel $kolom values $nilai";					
					$asg = $this->db->query($sql);                    											
                    //print_r($nilai);                                                                                 
					}
                    if(!$asg){                        
                            echo '2';
                        }else{
                            if($jm==$i){
                            echo '1';   
                        }
                        }        
                    }
                
                //berhasil
                    
                    
                    
            }   
           
	}
    
    function request_data_simbada(){
        /*$parkey = "d82c8d1619ad8176d665453cfb2e55f0";//$this->uri->segment(3);
        $parlokasi = "12.26.09.11.01";//$this->uri->segment(4);
        $partahun1 = "0000";//$this->uri->segment(5);
        $partahun2 = "2018";//$this->uri->segment(6);*/
        
        $parkey = $this->uri->segment(3);
        $parlokasi = $this->uri->segment(4);
        $partahun1 = $this->uri->segment(5);
        $partahun2 = $this->uri->segment(6);
        
                
        $curl = curl_init();
        $par1 = urlencode("getData");
        //$par2 = urlencode("4e732ced3463d06de0ca9a15b6153677");
        $par2 = urlencode($parkey);
        $par3 = urlencode($parlokasi);
        $par4 = urlencode($partahun1);
        $par5 = urlencode($partahun2);
        
        $apikey = "0D610BE3B91DF2B2EDC5EC71787AFA26";
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://bebas.pontianakkota.online/api/v1",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "app=$par1&query_id=$par2&params[kodelokasi]=$par3&params[filter_tahun]=$par4&params[filter_tahun2]=$par5",
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded;charset=UTF-8",
                "Accept: application/json",
                "x-api-key: $apikey",),));        
        
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            
            if ($err) {
                echo "cURL Error #:" . $err;
            } else {$tabel = "simbada_rbi";
                $kolom = "(kodebarang,uraian_kodebarang,jlh_barang,jlh_harga,beb_penyusutan,akum_penyusutan,nilai_buku,kd_lokasi)";                
                $sql = "delete from $tabel where kd_lokasi='$parlokasi'";					
				$this->db->query($sql);
               
                $result = json_decode($response);                
                $json = $result->data;
                $data = json_encode($json);
                $data = json_decode($data);                
                
                $json_row = $result->total_data;
                
                $jm = $json_row;					
					for ($i = 0; $i < $jm; $i++) {
                                                
			        $nilai = "(
                    '".$data[$i]->kodebarang."',
                    '".$data[$i]->uraian_kodebarang."',
                    '".$data[$i]->jlh_barang."',
                    '".$data[$i]->jlh_harga."',
                    '".$data[$i]->beb_penyusutan."',
                    '".$data[$i]->akum_penyusutan."',
                    '".$data[$i]->nilai_buku."',
                    '".$parlokasi."')";	
                    
                    $sql = "insert into $tabel $kolom values $nilai";					
					$asg = $this->db->query($sql);                    											
                    //print_r($nilai);                                                                                                        
					}
                    
                    if(!$asg){                        
                            echo '2';
                        }else{
                            if($i==$jm){
                            echo '1';   
                            }
                        }
                    
                    
                    
                    
            }   
           
	}
    
        function request_data_simbada_lokasi(){
        $parkey = "a1d0c6e83f027327d8461063f4ac58a6";        
                
        $curl = curl_init();
        $par1 = urlencode("getData");
        $par2 = urlencode($parkey);
        
        $apikey = "0D610BE3B91DF2B2EDC5EC71787AFA26";
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://bebas.pontianakkota.online/api/v1",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "app=$par1&query_id=$par2",
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded;charset=UTF-8",
                "Accept: application/json",
                "x-api-key: $apikey",),));        
        
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            
            if ($err) {
                echo "cURL Error #:" . $err;
            } else {$tabel = "simbada_lokasi";
                $kolom = "(kd_lokasi,nm_lokasi)";                
                $sql = "delete from $tabel";					
				$this->db->query($sql);
               
                $result = json_decode($response);                
                $json = $result->data;
                $data = json_encode($json);
                $data = json_decode($data);                
                
                $json_row = $result->total_data;
                
                $jm = $json_row;					
					for ($i = 0; $i < $jm; $i++) {
                                                
			        $nilai = "(
                    '".$data[$i]->kodelokasi."',
                    '".$data[$i]->uraian."')";	
                    
                    $sql = "insert into $tabel $kolom values $nilai";					
					$asg = $this->db->query($sql);                    											
                    //print_r($nilai);                                                                                                        
					}
                    
                    if(!$asg){                        
                            echo '2';
                        }else{
                            if($i==$jm){
                            echo '1';   
                            }
                        }
                    
            }   
           
	}
    
    function ld_lokasi() {
        
        $sql = "select 
                kd_lokasi,nm_lokasi from simbada_lokasi where len(kd_lokasi)='14' order by kd_lokasi";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kd_lokasi' => $resulte['kd_lokasi'],  
                        'nm_lokasi' => $resulte['nm_lokasi']
                        );
                        $ii++;
        }
           
        echo json_encode($result);
            
    }
    
     function cetak_rbi(){
		$kd_skpd = $this->session->userdata('kdskpd');        
        //$this->tanggal_format_indonesia($tgl);       
         $cRet = '';
         $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"1\" cellpadding=\"1\">
			<tr>
                <td align=\"center\" colspan=\"16\" style=\"font-size:14px;border: solid 1px white;\"><b>RBI SIMBADA</b></td>
            </tr>
             <tr>
                <td align=\"left\" colspan=\"12\" style=\"font-size:12px;border: solid 1px white;\">&nbsp;</td>
                <td align=\"left\" colspan=\"4\" style=\"font-size:12px;border: solid 1px white;\"></td>
            </tr>
             </table>";            
            
           $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\">";
           $cRet .="<tr>
                    <td valign=\"top\" align=\"center\" width=\"2%\" style=\"font-size:11px;border:solid 1px black;\">NO</td>
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\">LOKASI</td>                    
                    <td valign=\"top\" align=\"center\" width=\"8%\" style=\"font-size:11px;border:solid 1px black;\">KODE BARANG</td>
                    <td valign=\"top\" align=\"center\" width=\"30%\" style=\"font-size:11px;border:solid 1px black;\">URAIAN</td>
                    <td valign=\"top\" align=\"center\" width=\"5%\" style=\"font-size:11px;border:solid 1px black;\">JUMLAH BARANG</td>                                        
                    <td valign=\"top\" align=\"center\" width=\"15%\" style=\"font-size:11px;border:solid 1px black;\">JUMLAH HARGA</td>                    
                    <td valign=\"top\" align=\"center\" width=\"15%\" style=\"font-size:11px;border:solid 1px black;\">NILAI BEBAN PENYESUSUTAN</td>                    
                    <td valign=\"top\" align=\"center\" width=\"15%\" style=\"font-size:11px;border:solid 1px black;\">NILAI AKUM PENYUSUTAN</td>                                       
                    <td valign=\"top\" align=\"center\" width=\"15%\" style=\"font-size:11px;border:solid 1px black;\">NILAI BUKU</td>                                     
                    </tr>
                    "; 
           $no = 0;     
           $sqld = "SELECT a.*,b.nm_lokasi from simbada_rbi a left join simbada_lokasi b on b.kd_lokasi=a.kd_lokasi ";               
           $hasild = $this->db->query($sqld);    
           foreach ($hasild->result() as $rowd)
                    {
            $no = $no+1;
            $cRet .="<tr>
                    <td valign=\"top\" align=\"center\" width=\"2%\" style=\"font-size:11px;border-left:solid 1px black;border-right:solid 1px black;\">".$no."</td>
                    <td valign=\"top\" align=\"left\" width=\"10%\" style=\"font-size:11px;border-left:solid 1px black;border-right:solid 1px black;\">".$rowd->nm_lokasi."</td>                    
                    <td valign=\"top\" align=\"left\" width=\"8%\" style=\"font-size:11px;border-left:solid 1px black;border-right:solid 1px black;\">".$rowd->kodebarang."</td>
                    <td valign=\"top\" align=\"left\" width=\"30%\" style=\"font-size:11px;border-left:solid 1px black;border-right:solid 1px black;\">".$rowd->uraian_kodebarang."</td>
                    <td valign=\"top\" align=\"left\" width=\"5%\" style=\"font-size:11px;border-left:solid 1px black;border-right:solid 1px black;\">".$rowd->jlh_barang."</td>                                        
                    <td valign=\"top\" align=\"right\" width=\"15%\" style=\"font-size:11px;border-left:solid 1px black;border-right:solid 1px black;\">".$rowd->jlh_harga."</td>                    
                    <td valign=\"top\" align=\"right\" width=\"15%\" style=\"font-size:11px;border-left:solid 1px black;border-right:solid 1px black;\">".$rowd->beb_penyusutan."</td>                    
                    <td valign=\"top\" align=\"right\" width=\"15%\" style=\"font-size:11px;border-left:solid 1px black;border-right:solid 1px black;\">".$rowd->akum_penyusutan."</td>                                       
                    <td valign=\"top\" align=\"right\" width=\"15%\" style=\"font-size:11px;border-left:solid 1px black;border-right:solid 1px black;\">".$rowd->nilai_buku."</td>                    
                    
                    </tr>
                    ";              
                    }
                         
            $cRet .="
                                                                 
            </table>";    
            
        $data['prev']= $cRet;    
        echo $cRet;
                
    }
    
    
    function request_data_rkpd(){
        $curl = curl_init();
        $par1 = urlencode("getData");
        $par2 = urlencode("8e296a067a37563370ded05f5a3bf3ec");
        $apikey = "0D610BE3B91DF2B2EDC5EC71787AFA26";
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://bebas.pontianakkota.online/api/v1",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "app=$par1&query_id=$par2",
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded;charset=UTF-8",
                "Accept: application/json",
                "x-api-key: $apikey",),));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            
            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                
                $tabel = "sipp_renja_temp";
                $kolom = "(id,kode_urusan,urusan,kode_bidang,bidang,kode_skpd,skpd,kode_program,program,kode_kegiatan,kegiatan,fisik_nonfisik,baru_lanjutan,catatan,sasaran_kegiatan,lokasi_kegiatan,apbd_kab,apbd_dak,apbd_prov,apbn,partisipasi_masyarakat,swasta,pagu_sebelumnya,tu_prog,tk_prog,tu_mas,tk_mas,tu,tk,tu_has,tk_has,tahun,date_create,date_update)";                
                $sql = "delete from $tabel";					
				$this->db->query($sql);
               
                $result = json_decode($response);                
                $json = $result->data;
                $data = json_encode($json);
                $data = json_decode($data);                
                
                $json_row = $result->total_data;
                
                $n_apbd_kab = 0;$n_apbd_dak = 0;$n_apbd_prov=0;
                $n_apbn = 0;$n_partisipasi_masyarakat = 0;
                $n_swasta = 0;$n_pagu_sebelumnya = 0;
                
                $jm = $json_row;					
					for ($i = 0; $i < $jm; $i++) {
                    
                    if(is_null($data[$i]->apbd_kab)){$n_apbd_kab = 0;}else{$n_apbd_kab = $data[$i]->apbd_kab;}
                    if(is_null($data[$i]->apbd_dak)){$n_apbd_dak = 0;}else{$n_apbd_dak = $data[$i]->apbd_dak;}
                    if(is_null($data[$i]->apbd_prov)){$n_apbd_prov=0;}else{$n_apbd_prov = $data[$i]->apbd_prov;}
                    
                    if(is_null($data[$i]->apbn)){$n_apbn=0;}else{$n_apbn = $data[$i]->apbd_prov;}
                    if(is_null($data[$i]->partisipasi_masyarakat)){$n_partisipasi_masyarakat=0;}else{$n_partisipasi_masyarakat = $data[$i]->apbd_prov;}
                    if(is_null($data[$i]->swasta)){$n_swasta=0;}else{$n_swasta = $data[$i]->apbd_prov;}
                    if(is_null($data[$i]->pagu_sebelumnya)){$n_pagu_sebelumnya=0;}else{$n_pagu_sebelumnya = $data[$i]->apbd_prov;}
                   
			        $nilai = "(
                    
                    '".$data[$i]->id."',
                    '".$data[$i]->urusan."',
                    '".$data[$i]->kode_bidang."',
                    '".$data[$i]->bidang."',
                    '".$data[$i]->kode_program."',
                    '".$data[$i]->program."',
                    '".$data[$i]->kode_kegiatan."',
                    '".$data[$i]->kegiatan."',
                    '".$data[$i]->kode_skpd."',
                    '".$data[$i]->skpd."',
                    '".$data[$i]->kecamatan."',
                    '".$data[$i]->id_evrkpd."',
                    '".$data[$i]->id_mus_ppas."',
                    '".$data[$i]->kode_kecamatan."',
                    '".$data[$i]->id_urusan."',                    
                    '".$data[$i]->id_bidang."',
                    '".$data[$i]->id_program."',
                    '".$data[$i]->id_kegiatan."',
                    '".$data[$i]->kegiatan_lainnya."',
                    '".$data[$i]->fisik_nonfisik."',
                    '".$data[$i]->baru_lanjutan."',
                    '".$data[$i]->catatan."',
                    '".$data[$i]->sasaran_kegiatan."',
                    '".$data[$i]->lokasi_kegiatan."',
                    '".$n_apbd_kab."',
                    '".$n_apbd_dak."',
                    '".$n_apbd_prov."',
                    '".$n_apbn."',
                    '".$n_partisipasi_masyarakat."',
                    '".$n_swasta."',
                    '".$n_pagu_sebelumnya."',
                    '".$data[$i]->hasprog_tolakukur."',
                    '".$data[$i]->hasprog_target."',
                    '".$data[$i]->kegmasukan_tolakukur."',
                    '".$data[$i]->kegmasukan_target."',
                    '".$data[$i]->keg_tolakukur."',
                    '".$data[$i]->keg_target."',
                    '".$data[$i]->haskeg_tolakukur."',
                    '".$data[$i]->haskeg_target."',
                    '".$data[$i]->id_skpd."',
                    '".$data[$i]->sah."',
                    '".$data[$i]->tahun."',
                    '".$data[$i]->is_evaluate."',
                    '".$data[$i]->date_evaluate."',
                    '".$data[$i]->date_sah."',
                    '".$data[$i]->date_create."',
                    '".$data[$i]->date_update."')";	
                    
                    $sql = "insert into $tabel $kolom values $nilai";					
					$asg = $this->db->query($sql);
                  
					}
                
                //berhasil
                    if($asg){
                        echo '1';
                    }else{
                        echo '2';
                    }
                    
            }   
           
	}
    
    function request_data_query(){
        $curl = curl_init();
        $par1 = urlencode("getQuery");
        $par2 = urlencode("4e732ced3463d06de0ca9a15b6153677");
        $apikey = "0D610BE3B91DF2B2EDC5EC71787AFA26";
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://bebas.pontianakkota.online/api/v1",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            //CURLOPT_POSTFIELDS => "app=$par1&query_id=$par2",
            CURLOPT_POSTFIELDS => "app=$par1",            
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded;charset=UTF-8",
                "Accept: application/json",
                "x-api-key: $apikey",),));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            
            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                
                
                
                $result = json_decode($response);                
                $json = $result->data;
                $dec = json_encode($json);
                
                print_r($dec);
                
            }   
           
	}    
    
    function load_getdata_prog() {
        $result = array();
        $row = array();
      	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	    $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 5000;
	    $offset = ($page-1)*$rows;        
        $tabel = "sipp_proggiat_temp";
        $sql = "SELECT count(id_urusan) as total from $tabel" ;
        $query1 = $this->db->query($sql);
        $total = $query1->row();
       	$result["total"] = $total->total; 
        $query1->free_result();		
        
		$sql = "SELECT TOP $rows 
        id_urusan,kode_urusan,urusan,id_bidang,kode_bidang,bidang,id_program,kode_program,program,id_kegiatan,kode_kegiatan,kegiatan FROM $tabel 
        where (id_urusan+kode_urusan+urusan+id_bidang+kode_bidang+bidang+id_program+kode_program+program+id_kegiatan+kode_kegiatan+kegiatan) 
        not in (select TOP $offset id_urusan+kode_urusan+urusan+id_bidang+kode_bidang+bidang+id_program+kode_program+program+id_kegiatan+kode_kegiatan+kegiatan from $tabel )";
        
		$query1 = $this->db->query($sql); 
        $ii = 1;
        foreach($query1->result_array() as $resulte)
        { 
           
            $row[] = array(  
                        'id' => $ii,  
                        'id_urusan' => $resulte['id_urusan'],
                        'kode_urusan' => $resulte['kode_urusan'],
                        'urusan' => $resulte['urusan'],
                        'id_bidang' => $resulte['id_bidang'],
                        'kode_bidang' => $resulte['kode_bidang'],
                        'bidang' => $resulte['bidang'],
                        'id_program' => $resulte['id_program'],
                        'kode_program' => $resulte['kode_program'],                        
                        'program' => $resulte['program'],
                        'id_kegiatan' => $resulte['id_kegiatan'],
                        'kode_kegiatan' => $resulte['kode_kegiatan'],
                        'kegiatan' => $resulte['kegiatan'],
                        'kode_urusan' => $resulte['kode_urusan'],
                        'kode_urusan' => $resulte['kode_urusan']                        
                        
                        );
                        $ii++;
        }
       $result["rows"] = $row; 
       echo json_encode($result);
        
	}
    
    function load_getdata_renja() {
        $result = array();
        $row = array();
      	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	    $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 5000;
	    $offset = ($page-1)*$rows;        
        $tabel = "sipp_renja_temp";
        $parth = $this->input->post('th');
        $parskpd = $this->input->post('skpd');
        $where = "";
        $and  = "";
        
        if($parskpd<>""){
            $where = "where tahun='$parth' and kode_skpd='$parskpd'";
            $and = "and tahun='$parth' and kode_skpd='$parskpd'";
        }
        
        
        $sql = "SELECT count(id) as total from $tabel $where" ;
        $query1 = $this->db->query($sql);
        $total = $query1->row();
       	$result["total"] = $total->total; 
        $query1->free_result();		
        
		$sql = "SELECT TOP $rows 
        id,kode_urusan,urusan,kode_bidang,bidang,kode_skpd,skpd,kode_program,program,kode_kegiatan,kegiatan,fisik_nonfisik,baru_lanjutan,catatan,sasaran_kegiatan,lokasi_kegiatan,apbd_kab,apbd_dak,apbd_prov,apbn,partisipasi_masyarakat,swasta,pagu_sebelumnya,tu_prog,tk_prog,tu_mas,tk_mas,tu,tk,tu_has,tk_has,tahun,date_create,date_update FROM $tabel 
        where (id+kode_urusan+urusan+kode_bidang+bidang+kode_skpd+skpd+kode_program+program+kode_kegiatan+kegiatan+fisik_nonfisik+baru_lanjutan+catatan+sasaran_kegiatan+lokasi_kegiatan+apbd_kab+apbd_dak+apbd_prov+apbn+partisipasi_masyarakat+swasta+pagu_sebelumnya+tu_prog+tk_prog+tu_mas+tk_mas+tu+tk+tu_has+tk_has+tahun+date_create+date_update) 
        not in (select TOP $offset id+kode_urusan+urusan+kode_bidang+bidang+kode_skpd+skpd+kode_program+program+kode_kegiatan+kegiatan+fisik_nonfisik+baru_lanjutan+catatan+sasaran_kegiatan+lokasi_kegiatan+apbd_kab+apbd_dak+apbd_prov+apbn+partisipasi_masyarakat+swasta+pagu_sebelumnya+tu_prog+tk_prog+tu_mas+tk_mas+tu+tk+tu_has+tk_has+tahun+date_create+date_update from $tabel $where)
         $and";
        
		$query1 = $this->db->query($sql); 
        $ii = 1;
        foreach($query1->result_array() as $resulte)
        { 
           
            $row[] = array(  
                        'id' => $ii,  
                        'id_urusan' => $resulte['id'],
                        'kode_urusan' => $resulte['kode_urusan'],
                        'urusan' => $resulte['urusan'],
                        'kode_bidang' => $resulte['kode_bidang'],
                        'bidang' => $resulte['bidang'],
                        'kode_skpd' => $resulte['kode_skpd'],
                        'skpd' => $resulte['skpd'],                        
                        'kode_program' => $resulte['kode_program'],
                        'program' => $resulte['program'],
                        'kode_kegiatan' => $resulte['kode_kegiatan'],
                        'kegiatan' => $resulte['kegiatan'],
                        'fisik_nonfisik' => $resulte['fisik_nonfisik'],
                        'baru_lanjutan' => $resulte['baru_lanjutan'],
                        'catatan' => $resulte['catatan'],
                        'sasaran_kegiatan' => $resulte['sasaran_kegiatan'],
                        'lokasi_kegiatan' => $resulte['lokasi_kegiatan'],
                        'apbd_kab' => $resulte['apbd_kab'],
                        'apbd_dak' => $resulte['apbd_dak'],
                        'apbd_prov' => $resulte['apbd_prov'],
                        'apbn' => $resulte['apbn'],
                        'partisipasi_masyarakat' => $resulte['partisipasi_masyarakat'],
                        'swasta' => $resulte['swasta'],
                        'pagu_sebelumnya' => $resulte['pagu_sebelumnya'],
                        'tu_prog' => $resulte['tu_prog'],
                        'tk_prog' => $resulte['tk_prog'],
                        'tu_mas' => $resulte['tu_mas'],                       
                        'tk_mas' => $resulte['tk_mas'],
                        'tu' => $resulte['tu'],
                        'tk' => $resulte['tk'],
                        'tu_has' => $resulte['tu_has'],
                        'tk_has' => $resulte['tk_has'],
                        'tahun' => $resulte['tahun'],
                        'date_create' => $resulte['date_create'],
                        'date_update' => $resulte['date_update'],                        
                        );
                        $ii++;
        }
       $result["rows"] = $row; 
       echo json_encode($result);
        
	}
    
    function getInsert(){
        
        $tabel = "sipp_proggiat_temp";
        $tabel_tujuan = "sipp_proggiat";
        $msg = array();
        
        $sql = "delete from $tabel_tujuan";
        $asg = $this->db->query($sql);
        
        if($asg){        
        $sql = "insert into $tabel_tujuan select * from $tabel";
        $asg = $this->db->query($sql);

		if ($asg){
            $msg = array('pesan'=>'1');
            echo json_encode($msg);
            } else {
            $msg = array('pesan'=>'0');
            echo json_encode($msg);
            exit();
        }     
        }else{
            $msg = array('pesan'=>'0');
            echo json_encode($msg);
            exit();
        }   
    }
    
    function hapus(){
        
        $nomor = $this->input->post('no');
        $tabel = "sipp_proggiat";
        $msg = array();
        $sql = "delete from $tabel";
        $asg = $this->db->query($sql);

		if ($asg){
            $msg = array('pesan'=>'1');
            echo json_encode($msg);
            } else {
            $msg = array('pesan'=>'0');
            echo json_encode($msg);
            exit();
        }        
    }
   
}