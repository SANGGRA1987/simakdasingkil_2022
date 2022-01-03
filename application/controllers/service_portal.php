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
    
    function ambil_data_1()
    {
        $data['page_title']= 'DATA PORTAL';
        $this->template->set('title', 'DATA PORTAL');   
        $this->template->load('template','portal/ambildata1',$data) ; 
    }  
    
    function ambil_data_2()
    {
        $data['page_title']= 'DATA PORTAL';
        $this->template->set('title', 'DATA PORTAL');   
        $this->template->load('template','portal/ambildata2',$data) ; 
    }
      function ambil_data_3()
    {
        $data['page_title']= 'DATA PORTAL';
        $this->template->set('title', 'DATA PORTAL');   
        $this->template->load('template','portal/ambildata3',$data) ; 
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
        $par2 = urlencode("4e732ced3463d06de0ca9a15b6153677");
        $apikey = "5602D887AED47DF2CC8E6CBF3A54DB78";
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://portaldata.pontianakkota.go.id/api/v1",
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
                
                //$tabel = "sipp_proggiat_temp";
                //$kolom = "(id_urusan,kode_urusan,urusan,id_bidang,kode_bidang,bidang,id_program,kode_program,program,id_kegiatan,kode_kegiatan,kegiatan)";                
                //$sql = "delete from $tabel";					
				//$this->db->query($sql);
               
                $result = json_decode($response);                
                $json = $result->data;
                $data = json_encode($json);
                $data = json_decode($data);                
                
                $json_row = $result->total_data;
                print_r($data);
                    
            }   
           
	}
    
        function request_data11(){
        $parkey = $this->uri->segment(3);
        $parth = $this->uri->segment(4);
        $parskpd = $this->uri->segment(5);
        
        $curl = curl_init();
        $par1 = urlencode("getData");
        $par2 = urlencode("44f683a84163b3523afe57c2e008bc8c");
        //$par2 = urlencode($parkey);
        $par3 = urlencode($parth);
        $par4 = urlencode($parskpd);
        $apikey = "0D610BE3B91DF2B2EDC5EC71787AFA26";
        
        if($parskpd==""){
            curl_setopt_array($curl, array(
            //CURLOPT_URL => "http://bebas.pontianakkota.online/api/v1",
            CURLOPT_URL => "http://portaldata.pontianakkota.go.id/api/v1",
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
            //CURLOPT_URL => "http://bebas.pontianakkota.online/api/v1",
            CURLOPT_URL => "http://portaldata.pontianakkota.go.id/api/v1",
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
        
        $l = json_decode($response);
        $json_row = $l->total_data;
        echo $json_row;
        }    
    
    function request_data11_(){
        $parkey = $this->uri->segment(3);
        $parth = $this->uri->segment(4);
        $parskpd = "";//$this->uri->segment(5);
        
        $curl = curl_init();
        $par1 = urlencode("getData");
        $par2 = urlencode("44f683a84163b3523afe57c2e008bc8c");
        //$par2 = urlencode($parkey);
        $par3 = "2020";
        $par4 = "01.03.01";
        $apikey = "0D610BE3B91DF2B2EDC5EC71787AFA26";
        
        if($parskpd==""){
            curl_setopt_array($curl, array(
            //CURLOPT_URL => "http://bebas.pontianakkota.online/api/v1",
            CURLOPT_URL => "http://portaldata.pontianakkota.go.id/api/v1",
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
            //CURLOPT_URL => "http://bebas.pontianakkota.online/api/v1",
            CURLOPT_URL => "http://portaldata.pontianakkota.go.id/api/v1",
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
        
        $l = json_decode($response);
        $s = json_encode($l);
        $json_row = $l->total_data;
        echo $s;
        }
        
    function request_data11_prog(){
        $parskpd = $this->uri->segment(3);
        
        $curl = curl_init();
        $par1 = urlencode("getData");
        $par2 = urlencode("44f683a84163b3523afe57c2e008bc8c");
        //$par2 = urlencode($parkey);
        $apikey = "0D610BE3B91DF2B2EDC5EC71787AFA26";
        $tabel = "sipp_proggiat_temp";
        $sql = "delete from $tabel where kode_skpd='$parskpd'";					
	    $this->db->query($sql);
        
        curl_setopt_array($curl, array(
            //CURLOPT_URL => "http://bebas.pontianakkota.online/api/v1",
            CURLOPT_URL => "http://portaldata.pontianakkota.go.id/api/v1",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "app=$par1&query_id=$par2&params[kode_skpd]=$parskpd",
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
        
                $kolom = "(kode_urusan,urusan,kode_bidang,bidang,kode_program,program,kode_kegiatan,kegiatan,kode_skpd,skpd)";                
                
                $result = json_decode($response);              
                $json = $result->data;
                $data = json_encode($json);
                $data = json_decode($data);                
                
                $json_row = $result->total_data;
                
                $jm = $json_row;					
					for ($i = 0; $i < $jm; $i++) {
                                                
			        $nilai = "(
                    '".$data[$i]->kode_urusan."',
                    '".$data[$i]->urusan."',
                    '".$data[$i]->kode_bidang."',
                    '".$data[$i]->bidang."',
                    '".$data[$i]->kode_program."',
                    '".str_replace("'","",$data[$i]->program)."',
                    '".$data[$i]->kode_kegiatan."',
                    '".str_replace("'","",$data[$i]->kegiatan)."',
                    '".$data[$i]->kode_skpd."',
                    '".$data[$i]->skpd."')";	
                    
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
        }    
    
    function request_simpan_prog(){
        $parskpd = $this->uri->segment(3);
        $initskpd = substr($parskpd,1,7).".00";
        
        $this->db->query("delete from m_giat where substring(kd_kegiatan,6,10)='$initskpd'");
        
        $query = "insert into m_giat
select kd_kegiatan,kd_program,52 as jns_kegiatan,null as permen,kegiatan from(
select kd_program,program,kd_skpd,kd_kegiatan,kegiatan, null as permen from(
select 
right(kode_skpd,7)kd_skpd,
kode_bid+'.'+right(kode_skpd,7)+'.'+'00'+'.'+kode_prog kd_program,
program,
kode_bid+'.'+right(kode_skpd,7)+'.'+'00'+'.'+kode_prog+'.'+kode_giatx kd_kegiatan,kegiatan,
hasil
from (

select *,case when kode_urusan+'.'+kode_bidang = '4.08' and left(kode_skpd,5) != '04.08' then 'rutin' else 'bukan'
end as hasil,
case when kode_urusan+'.'+kode_bidang = '4.08' and left(kode_skpd,5) != '04.08' 
then substring(kode_skpd,2,4)
when kode_urusan+'.'+kode_bidang = '4.01' and left(kode_skpd,5) != '04.01' 
then substring(kode_skpd,2,4)
when kode_urusan+'.'+kode_bidang = '4.01' and left(kode_skpd,5) = '04.08' 
then substring(kode_skpd,2,4)
when kode_urusan+'.'+kode_bidang = '4.0.01'
then substring(kode_skpd,2,4) else kode_urusan+'.'+kode_bidang end as kode_bid,
case when len(kode_program) = 1 then '0'+kode_program 
when len(kode_program) = 2 then kode_program else '99' end as kode_prog,
case when len(kode_kegiatan) = 1 then '00'+kode_kegiatan 
when len(kode_kegiatan) = 2 then '0'+kode_kegiatan
when len(kode_kegiatan) = 3 then kode_kegiatan else '999' end as kode_giatx
from sipp_proggiat_temp
where right(kode_skpd,7)=left('$initskpd',7)

)x
)x
group by kd_kegiatan,kd_program,program,kd_skpd,kegiatan
)x
order by kd_kegiatan";
        $hsl = $this->db->query($query);
        if ($hsl){
            
            $this->db->query("delete from m_prog where kd_skpd='$initskpd'");
            $query2 = "insert into m_prog
select kd_program,program,kd_skpd,null as lpermen from(
select kd_program,program,kd_skpd,kd_kegiatan,kegiatan, null as permen from(
select 
right(kode_skpd,7)+'.00'kd_skpd,
kode_bid+'.'+right(kode_skpd,7)+'.'+'00'+'.'+kode_prog kd_program,
program,
kode_bid+'.'+right(kode_skpd,7)+'.'+'00'+'.'+kode_prog+'.'+kode_giatx kd_kegiatan,kegiatan,
hasil
from (

select *,case when kode_urusan+'.'+kode_bidang = '4.08' and left(kode_skpd,5) != '04.08' then 'rutin' else 'bukan'
end as hasil,
case when kode_urusan+'.'+kode_bidang = '4.08' and left(kode_skpd,5) != '04.08' 
then substring(kode_skpd,2,4)
when kode_urusan+'.'+kode_bidang = '4.01' and left(kode_skpd,5) != '04.01' 
then substring(kode_skpd,2,4)
when kode_urusan+'.'+kode_bidang = '4.01' and left(kode_skpd,5) = '04.08' 
then substring(kode_skpd,2,4)
when kode_urusan+'.'+kode_bidang = '4.0.01'
then substring(kode_skpd,2,4) else kode_urusan+'.'+kode_bidang end as kode_bid,
case when len(kode_program) = 1 then '0'+kode_program 
when len(kode_program) = 2 then kode_program else '99' end as kode_prog,
case when len(kode_kegiatan) = 1 then '00'+kode_kegiatan 
when len(kode_kegiatan) = 2 then '0'+kode_kegiatan
when len(kode_kegiatan) = 3 then kode_kegiatan else '999' end as kode_giatx
from sipp_proggiat_temp
where right(kode_skpd,7)=left('$initskpd',7)
)x
)x
where len(kd_kegiatan)='22'
group by kd_kegiatan,kd_program,program,kd_skpd,kegiatan
)x
group by kd_program,program,kd_skpd
order by kd_program";
            
          $hsl2 = $this->db->query($query2);  
          if($hsl2){
            echo '1';
          }else{
            echo '2';
          }  
            
            
        }else{
            echo '0';
        }
    }
        
   function request_data11_renja(){
        //$parkey = $this->uri->segment(3);
        $parth = $this->uri->segment(3);
        $parskpd = $this->uri->segment(4);
        
        $curl = curl_init();
        $par1 = urlencode("getData");
        $par2 = urlencode("2838023a778dfaecdc212708f721b788");
        //$par2 = urlencode($parkey);
        $par3 = $parth;
        $par4 = $parskpd;
        $apikey = "0D610BE3B91DF2B2EDC5EC71787AFA26";
        $tabel = "sipp_renja_temp";
        
        curl_setopt_array($curl, array(
            //CURLOPT_URL => "http://bebas.pontianakkota.online/api/v1",
            CURLOPT_URL => "http://portaldata.pontianakkota.go.id/api/v1",
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
        
        
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            
            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
        
                        
                
                $kolom = "(id,kode_urusan,urusan,kode_bidang,bidang,kode_skpd,skpd,kode_program,program,kode_kegiatan,kegiatan,fisik_nonfisik,baru_lanjutan,catatan,sasaran_kegiatan,lokasi_kegiatan,apbd_kab,apbd_prov,apbn,partisipasi_masyarakat,swasta,pagu_sebelumnya,tu_prog,tk_prog,tu_mas,tk_mas,tu,tk,tu_has,tk_has,tahun,date_create,date_update)";                
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
                    //if(is_null($data[$i]->apbd_dak)){$n_apbd_dak = 0;}else{$n_apbd_dak = $data[$i]->apbd_dak;}
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
                    '".$n_apbd_prov."',
                    '".$n_apbn."',
                    '".$n_partisipasi_masyarakat."',
                    '".$n_swasta."',
                    '".$n_pagu_sebelumnya."',
                    '".str_replace("'","",str_replace("&#039;","",$data[$i]->tu_prog))."',
                    '".str_replace("'","",str_replace("&#039;","",$data[$i]->tk_prog))."',
                    '".str_replace("'","",str_replace("&#039;","",$data[$i]->tu_mas))."',
                    '".str_replace("'","",str_replace("&#039;","",$data[$i]->tk_mas))."',
                    '".str_replace("'","",str_replace("&#039;","",$data[$i]->tu))."',
                    '".str_replace("'","",str_replace("&#039;","",$data[$i]->tk))."',
                    '".str_replace("'","",str_replace("&#039;","",$data[$i]->tu_has))."',
                    '".str_replace("'","",str_replace("&#039;","",$data[$i]->tk_has))."',
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
        }     
    
   function request_simpan_renja(){
        $parskpd = $this->uri->segment(3);
        $initskpd = substr($parskpd,1,7).".00";
        
        $this->db->query("delete from trskpd where kd_skpd='$initskpd'");
        
        $query = "insert into trskpd
select * from(
select 
right(kode_skpd,7)+'.00'+'.'+kode_bid+'.'+right(kode_skpd,7)+'.'+'00'+'.'+kode_prog+'.'+kode_giatx kd_gabungan,
kode_bid+'.'+right(kode_skpd,7)+'.'+'00'+'.'+kode_prog+'.'+kode_giatx kd_kegiatan,
kode_bid+'.'+right(kode_skpd,7)+'.'+'00'+'.'+kode_prog kd_program,
kode_bid as kd_urusan,
right(kode_skpd,7)+'.00' kd_skpd,
skpd as nm_skpd,
kode_bid+'.'+right(kode_skpd,7)+'.'+'00'+'.'+kode_prog+'.'+kode_giatx kd_kegiatan1,
kegiatan as nm_kegiatan,
'52' as jns_kegiatan,
kode_bid+'.'+right(kode_skpd,7)+'.'+'00'+'.'+kode_prog kd_program1,
program as nm_program,
null as indika,
null as tu,
null as tk,
sasaran_kegiatan as sasaran_giat,
null as sumber_dana,
null as waktu_giat,
null as tk_kwt,
null as kd_pptk,
null as kd_comp,
null as kontrak,
null as jns_keg,
tu_prog as tu_capai,
tu_prog as tu_capai_sempurna,
tu_prog as tu_capai_ubah,
tu_mas as tu_mas,
tu_mas as tu_mas_sempurna,
tu_mas as tu_mas_ubah,
tu as tu_kel,
tu as tu_kel_sempurna,
tu as tu_kel_ubah,
tu_has as tu_has,
tu_has as tu_has_sempurna,
tu_has as tu_has_ubah,
tk_prog as tk_capai,
tk_prog as tk_capai_sempurna,
tk_prog as tk_capai_ubah,
tk_mas as tk_mas,
tk_mas as tk_mas_sempurna,
tk_mas as tk_mas_ubah,
tk as tk_kel,
tk as tk_kel_sempurna,
tk as tk_kel_ubah,
tk_has as tk_has,
tk_has as tk_has_sempurna,
tk_has as tk_has_ubah,
null as alasan,
null as username,
null as latar_belakang,
0 as triw1,
0 as triw1_sempurna,
0 as triw1_ubah,
0 as triw2,
0 as triw2_sempurna,
0 as triw2_ubah,
0 as triw3,
0 as triw3_sempurna,
0 as triw3_ubah,
0 as triw4,
0 as triw4_sempurna,
0 as triw4_ubah,
0 as total,
0 as total_sempurna,
0 as total_ubah,
null as lokasi,
1 as status_keg,
null as lanjut,
pagu_sebelumnya as ang_lalu,
null as username1,
null as last_update,
apbd_kab+apbd_prov+apbd_dak+apbn as rancang,
null as kd_subkegiatan,
null as nm_subkegiatan,
null as kd_bidsubkegiatan,
0 as triw1_sempurna_2,
0 as triw2_sempurna_2,
0 as triw3_sempurna_2,
0 as triw4_sempurna_2,
0 as total_sempurna_2,
0 as triw1_sempurna_final,
0 as triw2_sempurna_final,
0 as triw3_sempurna_final,
0 as triw4_sempurna_final,
0 as total_sempurna_final

from (

select *,case when kode_urusan+'.'+kode_bidang = '4.08' and left(kode_skpd,5) != '04.08' then 'rutin' else 'bukan'
end as hasil,
case when kode_urusan+'.'+kode_bidang = '4.08' and left(kode_skpd,5) != '04.08' 
then substring(kode_skpd,2,4)
when kode_urusan+'.'+kode_bidang = '4.01' and left(kode_skpd,5) != '04.01' 
then substring(kode_skpd,2,4)
when kode_urusan+'.'+kode_bidang = '4.01' and left(kode_skpd,5) = '04.08' 
then substring(kode_skpd,2,4)
when kode_urusan+'.'+kode_bidang = '4.0.01'
then substring(kode_skpd,2,4) else kode_urusan+'.'+kode_bidang end as kode_bid,
case when len(kode_program) = 1 then '0'+kode_program 
when len(kode_program) = 2 then kode_program else '99' end as kode_prog,
case when len(kode_kegiatan) = 1 then '00'+kode_kegiatan 
when len(kode_kegiatan) = 2 then '0'+kode_kegiatan
when len(kode_kegiatan) = 3 then kode_kegiatan else '999' end as kode_giatx
from sipp_renja_temp


)x


) x
where kd_skpd='$initskpd'

";
    $sql = $this->db->query($query);
    if($sql){
        echo '1';
    }else{
        echo '2';
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
            //CURLOPT_URL => "http://bebas.pontianakkota.online/api/v1",
            CURLOPT_URL => "http://portaldata.pontianakkota.go.id/api/v1",
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
            //CURLOPT_URL => "http://bebas.pontianakkota.online/api/v1",
            CURLOPT_URL => "http://portaldata.pontianakkota.go.id/api/v1",
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
                                
                if($parkey=="44f683a84163b3523afe57c2e008bc8c"){                
                $tabel = "sipp_proggiat_temp";
                $kolom = "(id_urusan,kode_urusan,urusan,id_bidang,kode_bidang,bidang,id_program,kode_program,program,id_kegiatan,kode_kegiatan,kegiatan,kode_skpd,skpd)";                
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
                    '".str_replace("'","",$data[$i]->kegiatan)."',
                    '".$data[$i]->kode_skpd."',
                    '".$data[$i]->skpd."')";	
                    
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
            //CURLOPT_URL => "http://bebas.pontianakkota.online/api/v1",
            CURLOPT_URL => "http://portaldata.pontianakkota.go.id/api/v1",
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
                    
                    $n_a = str_replace(",","",$data[$i]->jlh_barang);
                    $n_b = str_replace(",","",$data[$i]->jlh_harga);
                    $n_c = str_replace(",","",$data[$i]->beb_penyusutan);
                    $n_d = str_replace(",","",$data[$i]->akum_penyusutan);
                    $n_e = str_replace(",","",$data[$i]->nilai_buku);
                                                
			        $nilai = "(
                    '".$data[$i]->kodebarang."',
                    '".$data[$i]->uraian_kodebarang."',
                    '".$n_a."',
                    '".$n_b."',
                    '".$n_c."',
                    '".$n_d."',
                    '".$n_e."',
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
    
    function request_data_simbada_view(){
        $parkey = "d82c8d1619ad8176d665453cfb2e55f0";//$this->uri->segment(3);
        $parlokasi = "12.26.09.07.01";//$this->uri->segment(4);
        $partahun1 = "2018";//$this->uri->segment(5);
        $partahun2 = "2018";//$this->uri->segment(6);
        /*
        $parkey = $this->uri->segment(3);
        $parlokasi = $this->uri->segment(4);
        $partahun1 = $this->uri->segment(5);
        $partahun2 = $this->uri->segment(6);
        */
                
        $curl = curl_init();
        $par1 = urlencode("getData");
        //$par2 = urlencode("4e732ced3463d06de0ca9a15b6153677");
        $par2 = urlencode($parkey);
        $par3 = urlencode($parlokasi);
        $par4 = urlencode($partahun1);
        $par5 = urlencode($partahun2);
        
        $apikey = "0D610BE3B91DF2B2EDC5EC71787AFA26";
        
        curl_setopt_array($curl, array(
            //CURLOPT_URL => "http://bebas.pontianakkota.online/api/v1",
            CURLOPT_URL => "http://portaldata.pontianakkota.go.id/api/v1",
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
                    
                    $n_a = str_replace(",","",$data[$i]->jlh_barang);
                    $n_b = str_replace(",","",$data[$i]->jlh_harga);
                    $n_c = str_replace(",","",$data[$i]->beb_penyusutan);
                    $n_d = str_replace(",","",$data[$i]->akum_penyusutan);
                    $n_e = str_replace(",","",$data[$i]->nilai_buku);
                    
                    /*$n_a = $data[$i]->jlh_barang;
                    $n_b = $data[$i]->jlh_harga;
                    $n_c = $data[$i]->beb_penyusutan;
                    $n_d = $data[$i]->akum_penyusutan;
                    $n_e = $data[$i]->nilai_buku;*/                                                
                                                
			        $nilai = "(
                    '".$data[$i]->kodebarang."',
                    '".$data[$i]->uraian_kodebarang."',
                    '".$n_a."',
                    '".$n_b."',
                    '".$n_c."',
                    '".$n_d."',
                    '".$n_e."',
                    '".$parlokasi."')";	
                    
                    //$sql = "insert into $tabel $kolom values $nilai";					
					//$asg = $this->db->query($sql);                    											
                    print_r($nilai);                                                                                                        
					}
                    /*
                    if(!$asg){                        
                            echo '2';
                        }else{
                            if($i==$jm){
                            echo '1';   
                            }
                        } 
                     */                      
            }   
           
	}
        
        function request_data_simbada_lokasi(){
        $parkey = "a1d0c6e83f027327d8461063f4ac58a6";        
                
        $curl = curl_init();
        $par1 = urlencode("getData");
        $par2 = urlencode($parkey);
        
        $apikey = "0D610BE3B91DF2B2EDC5EC71787AFA26";
        
        curl_setopt_array($curl, array(
            //CURLOPT_URL => "http://bebas.pontianakkota.online/api/v1",
            CURLOPT_URL => "http://portaldata.pontianakkota.go.id/api/v1",
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
                <td align=\"center\" colspan=\"16\" style=\"font-size:14px;border: solid 1px white;\"><b>SIMBADA</b></td>
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
    
     function cetak_prog(){
        $kd_skpd = $this->session->userdata('kdskpd');  
        $parskpd = $this->uri->segment(3);
        
        $param = "";
        $param_nama = "";
        if($parskpd<>""){
            $param = "where kode_skpd='$parskpd'";
            
            $init = substr($parskpd,1,7).".00";
            $param_nama = $this->tukd_model->get_nama($init,'nm_skpd','ms_skpd','kd_skpd');
        }
              
        //$this->tanggal_format_indonesia($tgl);       
         $cRet = '';
         echo ("<title>Program Kegiatan</title>");
         $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"1\" cellpadding=\"1\">
            <tr>
                <td align=\"center\" colspan=\"16\" style=\"font-size:14px;border: solid 1px white;\"><b>DAFTAR PROGRAM KEGIATAN<br/>".$param_nama."</b></td>
            </tr>
             <tr>
                <td align=\"left\" colspan=\"12\" style=\"font-size:12px;border: solid 1px white;\">&nbsp;</td>
                <td align=\"left\" colspan=\"4\" style=\"font-size:12px;border: solid 1px white;\"></td>
            </tr>
             </table>";            
            
           $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\">";
           $cRet .="<tr>
                    <td valign=\"top\" align=\"center\" width=\"3%\" style=\"font-size:11px;border:solid 1px black;\">NO</td>
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\">SKPD</td>
                    <td valign=\"top\" align=\"center\" width=\"3%\" style=\"font-size:11px;border:solid 1px black;\">KODE</td>                    
                    <td valign=\"top\" align=\"center\" width=\"8%\" style=\"font-size:11px;border:solid 1px black;\">URUSAN</td>
                    <td valign=\"top\" align=\"center\" width=\"3%\" style=\"font-size:11px;border:solid 1px black;\">KODE</td>                                        
                    <td valign=\"top\" align=\"center\" width=\"8%\" style=\"font-size:11px;border:solid 1px black;\">BIDANG</td>                
                    <td valign=\"top\" align=\"center\" width=\"3%\" style=\"font-size:11px;border:solid 1px black;\">KODE</td>                                       
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\">PROGRAM</td>     
                    <td valign=\"top\" align=\"center\" width=\"3%\" style=\"font-size:11px;border:solid 1px black;\">KODE</td>                                       
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\">KEGIATAN</td>                                     
                    </tr>
                    "; 
           $no = 0;     
           $sqld = "SELECT a.* from sipp_proggiat_temp a $param order by kode_kegiatan,kode_skpd,kode_urusan,kode_bidang,kode_program";               
           $hasild = $this->db->query($sqld);    
           foreach ($hasild->result() as $rowd)
                    {
            $no = $no+1;
            
            
            $cRet .="<tr>
                    <td valign=\"top\" align=\"center\" width=\"2%\" style=\"font-size:11px;border:solid 1px black;\">".$no."</td>
                    <td valign=\"top\" align=\"center\" width=\"3%\" style=\"font-size:11px;border:solid 1px black;\">".$rowd->skpd."</td>
                    <td valign=\"top\" align=\"center\" width=\"3%\" style=\"font-size:11px;border:solid 1px black;\">".$rowd->kode_urusan."</td>                    
                    <td valign=\"top\" align=\"left\" width=\"8%\" style=\"font-size:11px;border:solid 1px black;\">".$rowd->urusan."</td>
                    <td valign=\"top\" align=\"center\" width=\"3%\" style=\"font-size:11px;border:solid 1px black;\">".$rowd->kode_bidang."</td>                                        
                    <td valign=\"top\" align=\"left\" width=\"8%\" style=\"font-size:11px;border:solid 1px black;\">".$rowd->bidang."</td>                          
                    <td valign=\"top\" align=\"center\" width=\"3%\" style=\"font-size:11px;border:solid 1px black;\">".$rowd->kode_program."</td>                                       
                    <td valign=\"top\" align=\"left\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\">".$rowd->program."</td>                 
                    <td valign=\"top\" align=\"center\" width=\"3%\" style=\"font-size:11px;border:solid 1px black;\">".$rowd->kode_kegiatan."</td>                                       
                    <td valign=\"top\" align=\"left\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\">".$rowd->kegiatan."</td>
                    </tr>
                    ";              
                    }
                         
            $cRet .="
                                                                 
            </table>";    
            
        $data['prev']= $cRet;    
        echo $cRet;
                
    }

     function cetak_prog_cek(){
		$kd_skpd = $this->session->userdata('kdskpd');  
        $parskpd = $this->uri->segment(3);
        
        $param = "";
        $param_nama = "";
        if($parskpd<>""){
            $param = "where kode_skpd='$parskpd'";
            
            $init = substr($parskpd,1,7).".00";
            $param_nama = $this->tukd_model->get_nama($init,'nm_skpd','ms_skpd','kd_skpd');
        }
              
        //$this->tanggal_format_indonesia($tgl);       
         $cRet = '';
         echo ("<title>Program Kegiatan</title>");
         $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"1\" cellpadding=\"1\">
			<tr>
                <td align=\"center\" colspan=\"16\" style=\"font-size:14px;border: solid 1px white;\"><b>CEK DAFTAR PROGRAM KEGIATAN<br/>".$param_nama."</b></td>
            </tr>
             <tr>
                <td align=\"left\" colspan=\"12\" style=\"font-size:12px;border: solid 1px white;\">&nbsp;</td>
                <td align=\"left\" colspan=\"4\" style=\"font-size:12px;border: solid 1px white;\"></td>
            </tr>
             </table>";            
            
           $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\">";
           $cRet .="<tr>
                    <td valign=\"top\" align=\"center\" width=\"3%\" style=\"font-size:11px;border:solid 1px black;\">NO</td>
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\">KEGIATAN SIMAKDA</td>
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\">KEGIATAN SIPP</td>                                        
                    <td valign=\"top\" align=\"center\" width=\"25%\" style=\"font-size:11px;border:solid 1px black;\">NAMA PROGRAM</td>                
                    <td valign=\"top\" align=\"center\" width=\"30%\" style=\"font-size:11px;border:solid 1px black;\">NAMA KEGIATAN</td>
                    <td valign=\"top\" align=\"center\" width=\"3%\" style=\"font-size:11px;border:solid 1px black;\">HASIL</td>                                   
                    </tr>
                    "; 
           $no = 0;     
           $sqld = "

select v.* from(
select case when z.kd_kegiatan_simakda=z.kd_kegiatan_sipp then 'sama' else 'ashiap' end as hasil, z.* from(
select (select kd_kegiatan from m_giat where nm_kegiatan=x.nm_kegiatan and substring(kd_kegiatan,6,7)=substring(x.kd_kegiatan,6,7)) kd_kegiatan_simakda,x.kd_kegiatan as kd_kegiatan_sipp,x.nm_program,x.nm_kegiatan from(
select 
right(kode_skpd,7)+'.00'+'.'+kode_bid+'.'+right(kode_skpd,7)+'.'+'00'+'.'+kode_prog+'.'+kode_giatx kd_gabungan,
kode_bid+'.'+right(kode_skpd,7)+'.'+'00'+'.'+kode_prog+'.'+kode_giatx kd_kegiatan,
kode_bid+'.'+right(kode_skpd,7)+'.'+'00'+'.'+kode_prog kd_program,
kode_bid as kd_urusan,
right(kode_skpd,7)+'.00' kd_skpd,
skpd as nm_skpd,
kode_bid+'.'+right(kode_skpd,7)+'.'+'00'+'.'+kode_prog+'.'+kode_giatx kd_kegiatan1,
kegiatan as nm_kegiatan,
'52' as jns_kegiatan,
kode_bid+'.'+right(kode_skpd,7)+'.'+'00'+'.'+kode_prog kd_program1,
program as nm_program,
null as indika,
null as tu,
null as tk,
sasaran_kegiatan as sasaran_giat,
null as sumber_dana,
null as waktu_giat,
null as tk_kwt,
null as kd_pptk,
null as kd_comp,
null as kontrak,
null as jns_keg,
tu_prog as tu_capai,
tu_prog as tu_capai_sempurna,
tu_prog as tu_capai_ubah,
tu_mas as tu_mas,
tu_mas as tu_mas_sempurna,
tu_mas as tu_mas_ubah,
tu as tu_kel,
tu as tu_kel_sempurna,
tu as tu_kel_ubah,
tu_has as tu_has,
tu_has as tu_has_sempurna,
tu_has as tu_has_ubah,
tk_prog as tk_capai,
tk_prog as tk_capai_sempurna,
tk_prog as tk_capai_ubah,
tk_mas as tk_mas,
tk_mas as tk_mas_sempurna,
tk_mas as tk_mas_ubah,
tk as tk_kel,
tk as tk_kel_sempurna,
tk as tk_kel_ubah,
tk_has as tk_has,
tk_has as tk_has_sempurna,
tk_has as tk_has_ubah,
null as alasan,
null as username,
null as latar_belakang,
0 as triw1,
0 as triw1_sempurna,
0 as triw1_ubah,
0 as triw2,
0 as triw2_sempurna,
0 as triw2_ubah,
0 as triw3,
0 as triw3_sempurna,
0 as triw3_ubah,
0 as triw4,
0 as triw4_sempurna,
0 as triw4_ubah,
0 as total,
0 as total_sempurna,
0 as total_ubah,
null as lokasi,
1 as status_keg,
null as lanjut,
pagu_sebelumnya as ang_lalu,
null as username1,
null as last_update,
apbd_kab+apbd_prov+apbd_dak+apbn as rancang,
null as kd_subkegiatan,
null as nm_subkegiatan,
null as kd_bidsubkegiatan,
0 as triw1_sempurna_2,
0 as triw2_sempurna_2,
0 as triw3_sempurna_2,
0 as triw4_sempurna_2,
0 as total_sempurna_2,
0 as triw1_sempurna_final,
0 as triw2_sempurna_final,
0 as triw3_sempurna_final,
0 as triw4_sempurna_final,
0 as total_sempurna_final

from (

select *,case when kode_urusan+'.'+kode_bidang = '4.08' and left(kode_skpd,5) != '04.08' then 'rutin' else 'bukan'
end as hasil,
case when kode_urusan+'.'+kode_bidang = '4.08' and left(kode_skpd,5) != '04.08' 
then substring(kode_skpd,2,4)
when kode_urusan+'.'+kode_bidang = '4.01' and left(kode_skpd,5) != '04.01' 
then substring(kode_skpd,2,4)
when kode_urusan+'.'+kode_bidang = '4.01' and left(kode_skpd,5) = '04.08' 
then substring(kode_skpd,2,4)
when kode_urusan+'.'+kode_bidang = '4.0.01'
then substring(kode_skpd,2,4) else kode_urusan+'.'+kode_bidang end as kode_bid,
case when len(kode_program) = 1 then '0'+kode_program 
when len(kode_program) = 2 then kode_program else '99' end as kode_prog,
case when len(kode_kegiatan) = 1 then '00'+kode_kegiatan 
when len(kode_kegiatan) = 2 then '0'+kode_kegiatan
when len(kode_kegiatan) = 3 then kode_kegiatan else '999' end as kode_giatx
from sipp_renja_temp
)x)x
where x.kd_skpd='$init')z)v
order by v.hasil,v.kd_kegiatan_sipp";               
           $hasild = $this->db->query($sqld);    
           foreach ($hasild->result() as $rowd)
                    {
            $no = $no+1;
            
            
            $cRet .="<tr>
                    <td valign=\"top\" align=\"center\" width=\"2%\" style=\"font-size:11px;border:solid 1px black;\">".$no."</td>
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\">".$rowd->kd_kegiatan_simakda."</td>
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\">".$rowd->kd_kegiatan_sipp."</td>                    
                    <td valign=\"top\" align=\"left\" width=\"25%\" style=\"font-size:11px;border:solid 1px black;\">".$rowd->nm_program."</td>
                    <td valign=\"top\" align=\"left\" width=\"30%\" style=\"font-size:11px;border:solid 1px black;\">".$rowd->nm_kegiatan."</td>                                        
                    <td valign=\"top\" align=\"left\" width=\"3%\" style=\"font-size:11px;border:solid 1px black;\">".$rowd->hasil."</td>                                              
                    </tr>
                    ";              
                    }
                         
            $cRet .="
                                                                 
            </table>";    
            
        $data['prev']= $cRet;    
        echo $cRet;
    
    }

    function load_giat($kdskpd=""){
        $lccr='';        
        $lccr = $this->input->post('q');        
        $sql = "select v.* from(
select case when z.kd_kegiatan_simakda=z.kd_kegiatan_sipp then 'sama' else 'ashiap' end as hasil, z.* from(
select (select kd_kegiatan from m_giat where nm_kegiatan=x.nm_kegiatan and substring(kd_kegiatan,6,7)=substring(x.kd_kegiatan,6,7)) kd_kegiatan_simakda,x.kd_kegiatan as kd_kegiatan_sipp,x.nm_program,x.nm_kegiatan from(
select 
right(kode_skpd,7)+'.00'+'.'+kode_bid+'.'+right(kode_skpd,7)+'.'+'00'+'.'+kode_prog+'.'+kode_giatx kd_gabungan,
kode_bid+'.'+right(kode_skpd,7)+'.'+'00'+'.'+kode_prog+'.'+kode_giatx kd_kegiatan,
kode_bid+'.'+right(kode_skpd,7)+'.'+'00'+'.'+kode_prog kd_program,
kode_bid as kd_urusan,
right(kode_skpd,7)+'.00' kd_skpd,
skpd as nm_skpd,
kode_bid+'.'+right(kode_skpd,7)+'.'+'00'+'.'+kode_prog+'.'+kode_giatx kd_kegiatan1,
kegiatan as nm_kegiatan,
'52' as jns_kegiatan,
kode_bid+'.'+right(kode_skpd,7)+'.'+'00'+'.'+kode_prog kd_program1,
program as nm_program,
null as indika,
null as tu,
null as tk,
sasaran_kegiatan as sasaran_giat,
null as sumber_dana,
null as waktu_giat,
null as tk_kwt,
null as kd_pptk,
null as kd_comp,
null as kontrak,
null as jns_keg,
tu_prog as tu_capai,
tu_prog as tu_capai_sempurna,
tu_prog as tu_capai_ubah,
tu_mas as tu_mas,
tu_mas as tu_mas_sempurna,
tu_mas as tu_mas_ubah,
tu as tu_kel,
tu as tu_kel_sempurna,
tu as tu_kel_ubah,
tu_has as tu_has,
tu_has as tu_has_sempurna,
tu_has as tu_has_ubah,
tk_prog as tk_capai,
tk_prog as tk_capai_sempurna,
tk_prog as tk_capai_ubah,
tk_mas as tk_mas,
tk_mas as tk_mas_sempurna,
tk_mas as tk_mas_ubah,
tk as tk_kel,
tk as tk_kel_sempurna,
tk as tk_kel_ubah,
tk_has as tk_has,
tk_has as tk_has_sempurna,
tk_has as tk_has_ubah,
null as alasan,
null as username,
null as latar_belakang,
0 as triw1,
0 as triw1_sempurna,
0 as triw1_ubah,
0 as triw2,
0 as triw2_sempurna,
0 as triw2_ubah,
0 as triw3,
0 as triw3_sempurna,
0 as triw3_ubah,
0 as triw4,
0 as triw4_sempurna,
0 as triw4_ubah,
0 as total,
0 as total_sempurna,
0 as total_ubah,
null as lokasi,
1 as status_keg,
null as lanjut,
pagu_sebelumnya as ang_lalu,
null as username1,
null as last_update,
apbd_kab+apbd_prov+apbd_dak+apbn as rancang,
null as kd_subkegiatan,
null as nm_subkegiatan,
null as kd_bidsubkegiatan,
0 as triw1_sempurna_2,
0 as triw2_sempurna_2,
0 as triw3_sempurna_2,
0 as triw4_sempurna_2,
0 as total_sempurna_2,
0 as triw1_sempurna_final,
0 as triw2_sempurna_final,
0 as triw3_sempurna_final,
0 as triw4_sempurna_final,
0 as total_sempurna_final

from (

select *,case when kode_urusan+'.'+kode_bidang = '4.08' and left(kode_skpd,5) != '04.08' then 'rutin' else 'bukan'
end as hasil,
case when kode_urusan+'.'+kode_bidang = '4.08' and left(kode_skpd,5) != '04.08' 
then substring(kode_skpd,2,4)
when kode_urusan+'.'+kode_bidang = '4.01' and left(kode_skpd,5) != '04.01' 
then substring(kode_skpd,2,4)
when kode_urusan+'.'+kode_bidang = '4.01' and left(kode_skpd,5) = '04.08' 
then substring(kode_skpd,2,4)
when kode_urusan+'.'+kode_bidang = '4.0.01'
then substring(kode_skpd,2,4) else kode_urusan+'.'+kode_bidang end as kode_bid,
case when len(kode_program) = 1 then '0'+kode_program 
when len(kode_program) = 2 then kode_program else '99' end as kode_prog,
case when len(kode_kegiatan) = 1 then '00'+kode_kegiatan 
when len(kode_kegiatan) = 2 then '0'+kode_kegiatan
when len(kode_kegiatan) = 3 then kode_kegiatan else '999' end as kode_giatx
from sipp_renja_temp
)x)x
where x.kd_skpd='$kdskpd')z)v
order by v.hasil,v.kd_kegiatan_sipp
";   

        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;        
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'hasil' => $resulte['hasil'],  
                        'kd_kegiatan_simakda' => $resulte['kd_kegiatan_simakda'],
                        'kd_kegiatan_sipp' => $resulte['kd_kegiatan_sipp']      
                        );
                        $ii++;
        }           
           
        echo json_encode($result);
        $query1->free_result();


    } 
    function ubahkode($skpd= "", $simakda="", $sipp="")
    {

        $sql= "
        update a 
        set a.kd_kegiatan=b.kd_kegiatan_sipp,
        a.kd_program=left(b.kd_kegiatan_sipp,18) 
        from m_giat a
        left join(
        select kd_kegiatan,
        left('$sipp',4)+'.'+substring('$sipp',6,10)+'.'+substring('$sipp',17,2)+'.'+right('$sipp',3) kd_kegiatan_sipp
        from m_giat where kd_kegiatan='$simakda' and substring(kd_kegiatan,6,10)='$skpd')b 
        on b.kd_kegiatan=a.kd_kegiatan and substring(a.kd_kegiatan,6,10)=substring(b.kd_kegiatan,6,10)  
        where a.kd_kegiatan='$simakda' and substring(a.kd_kegiatan,6,10)='$skpd'


        update a set 
        a.kd_gabungan=b.kd_gabungan,
        a.kd_kegiatan=b.kd_kegiatan_sipp,
        a.kd_kegiatan1=b.kd_kegiatan_sipp,
        a.kd_program=left(b.kd_kegiatan_sipp,18),
        a.kd_program1=left(b.kd_kegiatan_sipp,18)
        from trskpd a
        left join(
        select c.kd_skpd+'.'+c.kd_kegiatan_sipp kd_gabungan,c.kd_skpd,c.kd_kegiatan_sipp,c.kd_kegiatan from(
        select c.kd_skpd,c.kd_kegiatan,
        left('$sipp',4)+'.'+substring('$sipp',6,10)+'.'+substring('$sipp',17,2)+'.'+right('$sipp',3) kd_kegiatan_sipp
        from trskpd c where c.kd_kegiatan='$simakda' and substring(c.kd_kegiatan,6,10)='$skpd')c
        )b on b.kd_kegiatan=a.kd_kegiatan and b.kd_skpd=a.kd_skpd
        where a.kd_kegiatan='$simakda' and substring(a.kd_kegiatan,6,10)='$skpd'


        update a set
        a.no_trdrka=b.no_trdrka_sipp,
        a.kd_kegiatan=b.kd_kegiatan_sipp
        from trdrka a
        left join(
        select 
        c.kd_skpd+'.'+c.kd_kegiatan_sipp+'.'+c.kd_rek5 no_trdrka_sipp,
        c.kd_skpd,c.kd_kegiatan_sipp,c.kd_kegiatan,c.kd_skpd+'.'+c.kd_kegiatan+'.'+c.kd_rek5 no_trdrka from(
        select c.kd_skpd,c.kd_kegiatan,c.kd_rek5,
        left('$sipp',4)+'.'+substring('$sipp',6,10)+'.'+substring('$sipp',17,2)+'.'+right('$sipp',3) kd_kegiatan_sipp
        from trdrka c where c.kd_kegiatan='$simakda' and substring(c.kd_kegiatan,6,10)='$skpd')c)b
        on b.no_trdrka=a.no_trdrka and b.kd_kegiatan=a.kd_kegiatan
        where a.kd_kegiatan='$simakda' and substring(a.kd_kegiatan,6,10)='$skpd'


        update a set
        a.no_trdrka=b.no_trdrka_sipp,
        a.kd_kegiatan=b.kd_kegiatan_sipp
        from trdpo a
        left join(
        select 
        c.kd_skpd+'.'+c.kd_kegiatan_sipp+'.'+c.kd_rek5 no_trdrka_sipp,
        c.kd_skpd,c.kd_kegiatan_sipp,c.kd_kegiatan,c.kd_skpd+'.'+c.kd_kegiatan+'.'+c.kd_rek5 no_trdrka from(
        select substring('$sipp',6,10) kd_skpd,c.kd_kegiatan,c.kd_rek5,
        left('$sipp',4)+'.'+substring('$sipp',6,10)+'.'+substring('$sipp',17,2)+'.'+right('$sipp',3) kd_kegiatan_sipp
        from trdpo c where c.kd_kegiatan='$simakda' and substring(c.kd_kegiatan,6,10)='$skpd')c)b
        on b.no_trdrka=a.no_trdrka and b.kd_kegiatan=a.kd_kegiatan
        where a.kd_kegiatan='$simakda' and substring(a.kd_kegiatan,6,10)='$skpd'

        update a set 
        a.kd_gabungan=b.kd_gabungan,
        a.kd_kegiatan=b.kd_kegiatan_sipp
        from trdskpd a
        left join(
        select c.kd_skpd+'.'+c.kd_kegiatan_sipp kd_gabungan,c.kd_skpd,c.kd_kegiatan_sipp,c.kd_kegiatan from(
        select c.kd_skpd,c.kd_kegiatan,
        left('$sipp',4)+'.'+substring('$sipp',6,10)+'.'+substring('$sipp',17,2)+'.'+right('$sipp',3) kd_kegiatan_sipp
        from trdskpd c where c.kd_kegiatan='$simakda' and substring(c.kd_kegiatan,6,10)='$skpd')c
        )b on b.kd_kegiatan=a.kd_kegiatan and b.kd_skpd=a.kd_skpd
        where a.kd_kegiatan='$simakda' and substring(a.kd_kegiatan,6,10)='$skpd'

    
        update a set 
        a.kd_gabungan=b.kd_gabungan,
        a.kd_kegiatan=b.kd_kegiatan_sipp
        from trdskpd_ro a
        left join(
        select c.kd_skpd+'.'+c.kd_kegiatan_sipp kd_gabungan,c.kd_skpd,c.kd_kegiatan_sipp,c.kd_kegiatan from(
        select c.kd_skpd,c.kd_kegiatan,
        left('$sipp',4)+'.'+substring('$sipp',6,10)+'.'+substring('$sipp',17,2)+'.'+right('$sipp',3) kd_kegiatan_sipp
        from trdskpd_ro c where c.kd_kegiatan='$simakda' and substring(c.kd_kegiatan,6,10)='$skpd')c
        )b on b.kd_kegiatan=a.kd_kegiatan and b.kd_skpd=a.kd_skpd
        where a.kd_kegiatan='$simakda' and substring(a.kd_kegiatan,6,10)='$skpd'
        ";

        $asg = $this->db->query($sql);
        if (!($asg)){
           $msg = array('pesan'=>'0');
           echo json_encode($msg);
       }  else {
           $msg = array('pesan'=>'1');
           echo json_encode($msg);
       }
    }
    
    function cetak_renja_baru(){
        $kd_skpd = $this->session->userdata('kdskpd'); 
        $parskpd = $this->uri->segment(3);
        
        $param = "";
        $param_nama = "";
        if($parskpd<>""){
            $param = "where kode_skpd='$parskpd'";
            
            $init = substr($parskpd,1,7).".00";
            $param_nama = $this->tukd_model->get_nama($init,'nm_skpd','ms_skpd','kd_skpd');
        }
               
        //$this->tanggal_format_indonesia($tgl);       
         $cRet = '';
         echo ("<title>RENJA</title>");
         $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"1\" cellpadding=\"1\">
            <tr>
                <td align=\"center\" colspan=\"16\" style=\"font-size:14px;border: solid 1px white;\"><b>RENJA SIPP<br/>".$param_nama."</b></td>
            </tr>
             <tr>
                <td align=\"left\" colspan=\"12\" style=\"font-size:12px;border: solid 1px white;\">&nbsp;</td>
                <td align=\"left\" colspan=\"4\" style=\"font-size:12px;border: solid 1px white;\"></td>
            </tr>
             </table>";            
            
           $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\">";
           $cRet .="<tr>
                    <td valign=\"top\" align=\"center\" width=\"3%\" style=\"font-size:11px;border:solid 1px black;\">NO</td>
                    <td valign=\"top\" align=\"center\" width=\"3%\" style=\"font-size:11px;border:solid 1px black;\">TAHUN</td>                    
                    <td valign=\"top\" align=\"center\" width=\"7%\" style=\"font-size:11px;border:solid 1px black;\">SKPD</td>      
                    <td valign=\"top\" align=\"center\" width=\"5%\" style=\"font-size:11px;border:solid 1px black;\">KODE</td>                    
                    <td valign=\"top\" align=\"center\" width=\"7%\" style=\"font-size:11px;border:solid 1px black;\">KEGIATAN</td>
                    <td valign=\"top\" align=\"center\" width=\"7%\" style=\"font-size:11px;border:solid 1px black;\">SASARAN KEG</td>                    
                    <td valign=\"top\" align=\"center\" width=\"7%\" style=\"font-size:11px;border:solid 1px black;\">LOKASI</td>                    
                    <td valign=\"top\" align=\"center\" width=\"9%\" style=\"font-size:11px;border:solid 1px black;\">APBD</td>                                       
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\">T-U PROG</td>
                    <td valign=\"top\" align=\"center\" width=\"5%\" style=\"font-size:11px;border:solid 1px black;\">T-K PROG</td>
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\">T-U MAS</td>
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\">T-K MAS</td>
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\">T-U</td>
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\">T-K</td>
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\">T-U HAS</td>
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\">T-K HAS</td>                    
                    </tr>
                    "; 
           $no = 0;$jmlh5=0;$jmlh4=0;$jmlh3=0;$jmlh2=0;$jmlh1=0;     
           $sqld = "SELECT a.* from sipp_renja_temp a $param order by kegiatan";               
           $hasild = $this->db->query($sqld);    
           foreach ($hasild->result() as $rowd)
                    {
            $no = $no+1;
            $kode_keg = strlen($rowd->kode_kegiatan);

            if($kode_keg==1){
                $kode_keg = "00".$rowd->kode_kegiatan;
            }else if($kode_keg==2){
                $kode_keg = "0".$rowd->kode_kegiatan;
            }else{
                $kode_keg = $rowd->kode_kegiatan;
            }            
            $cRet .="<tr>
                    <td valign=\"top\" align=\"center\" width=\"3%\" style=\"font-size:11px;border:solid 1px black;\">".$no."</td>
                    <td valign=\"top\" align=\"center\" width=\"3%\" style=\"font-size:11px;border:solid 1px black;\">".$rowd->tahun."</td>                    
                    <td valign=\"top\" align=\"center\" width=\"7%\" style=\"font-size:11px;border:solid 1px black;\">".$rowd->skpd."</td>      
                    <td valign=\"top\" align=\"center\" width=\"5%\" style=\"font-size:11px;border:solid 1px black;\">".$kode_keg."</td>                    
                    <td valign=\"top\" align=\"left\" width=\"7%\" style=\"font-size:11px;border:solid 1px black;\">".$rowd->kegiatan."</td>
                    <td valign=\"top\" align=\"center\" width=\"7%\" style=\"font-size:11px;border:solid 1px black;\">".$rowd->sasaran_kegiatan."</td>                    
                    <td valign=\"top\" align=\"center\" width=\"7%\" style=\"font-size:11px;border:solid 1px black;\">".$rowd->lokasi_kegiatan."</td>                    
                    <td valign=\"top\" align=\"right\" width=\"9%\" style=\"font-size:11px;border:solid 1px black;\">".number_format($rowd->apbd_kab,2)."</td>                                       
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\">".$rowd->tu_prog."</td>
                    <td valign=\"top\" align=\"center\" width=\"5%\" style=\"font-size:11px;border:solid 1px black;\">".$rowd->tk_prog."</td>
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\">".$rowd->tu_mas."</td>
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\">".$rowd->tk_mas."</td>
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\">".$rowd->tu."</td>
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\">".$rowd->tk."</td>
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\">".$rowd->tu_has."</td>
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\">".$rowd->tk_has."</td>
                    </tr>
                    ";              
                    $jmlh1=$jmlh1+$rowd->apbd_kab;
                    }
                   $cRet .="
                    <tr>
                    <td valign=\"top\" align=\"center\" width=\"3%\" style=\"font-size:11px;border:solid 1px black;\"></td>                  
                    <td valign=\"top\" colspan=\"8\" align=\"center\" width=\"7%\" style=\"font-size:11px;border:solid 1px black;\">Jumlah</td>                    
                    <td valign=\"top\" align=\"right\" width=\"5%\" style=\"font-size:11px;border:solid 1px black;\">".number_format($jmlh1,2)."</td>                                       
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\"></td>
                    <td valign=\"top\" align=\"center\" width=\"5%\" style=\"font-size:11px;border:solid 1px black;\"></td>
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\"></td>
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\"></td>
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\"></td>
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\"></td>
                    </tr>
                    <tr>
                    <td valign=\"top\" align=\"center\" width=\"3%\" style=\"font-size:11px;border:solid 1px black;\"></td>                  
                    <td valign=\"top\" colspan=\"8\" align=\"center\" width=\"7%\" style=\"font-size:11px;border:solid 1px black;\">Total</td>                    
                    <td valign=\"top\" colspan=\"5\" align=\"right\" width=\"5%\" style=\"font-size:11px;border:solid 1px black;\">".number_format($jmlh1,2)."</td>
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\"></td>
                    <td valign=\"top\" align=\"center\" width=\"5%\" style=\"font-size:11px;border:solid 1px black;\"></td>
                    
                    </tr>
                    ";
                         
            $cRet .="
                                                                 
            </table>";    
            
        $data['prev']= $cRet;    
        echo $cRet;
                
    }

    function cetak_renja(){
		$kd_skpd = $this->session->userdata('kdskpd'); 
        $parskpd = $this->uri->segment(3);
        
        $param = "";
        $param_nama = "";
        if($parskpd<>""){
            $param = "where kode_skpd='$parskpd'";
            
            $init = substr($parskpd,1,7).".00";
            $param_nama = $this->tukd_model->get_nama($init,'nm_skpd','ms_skpd','kd_skpd');
        }
               
        //$this->tanggal_format_indonesia($tgl);       
         $cRet = '';
         echo ("<title>RENJA</title>");
         $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"1\" cellpadding=\"1\">
			<tr>
                <td align=\"center\" colspan=\"16\" style=\"font-size:14px;border: solid 1px white;\"><b>RENJA SIPP<br/>".$param_nama."</b></td>
            </tr>
             <tr>
                <td align=\"left\" colspan=\"12\" style=\"font-size:12px;border: solid 1px white;\">&nbsp;</td>
                <td align=\"left\" colspan=\"4\" style=\"font-size:12px;border: solid 1px white;\"></td>
            </tr>
             </table>";            
            
           $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\">";
           $cRet .="<tr>
                    <td valign=\"top\" align=\"center\" width=\"3%\" style=\"font-size:11px;border:solid 1px black;\">NO</td>
                    <td valign=\"top\" align=\"center\" width=\"3%\" style=\"font-size:11px;border:solid 1px black;\">TAHUN</td>                    
                    <td valign=\"top\" align=\"center\" width=\"5%\" style=\"font-size:11px;border:solid 1px black;\">SKPD</td>      
                    <td valign=\"top\" align=\"center\" width=\"3%\" style=\"font-size:11px;border:solid 1px black;\">KODE</td>                    
                    <td valign=\"top\" align=\"center\" width=\"7%\" style=\"font-size:11px;border:solid 1px black;\">KEGIATAN</td>
                    <td valign=\"top\" align=\"center\" width=\"3%\" style=\"font-size:11px;border:solid 1px black;\">FISIK</td>
                    <td valign=\"top\" align=\"center\" width=\"3%\" style=\"font-size:11px;border:solid 1px black;\">BARU</td>                                        
                    <td valign=\"top\" align=\"center\" width=\"7%\" style=\"font-size:11px;border:solid 1px black;\">SASARAN KEG</td>                    
                    <td valign=\"top\" align=\"center\" width=\"7%\" style=\"font-size:11px;border:solid 1px black;\">LOKASI</td>                    
                    <td valign=\"top\" align=\"center\" width=\"5%\" style=\"font-size:11px;border:solid 1px black;\">APBD</td>                                       
                    <td valign=\"top\" align=\"center\" width=\"5%\" style=\"font-size:11px;border:solid 1px black;\">DAK</td> 
                    <td valign=\"top\" align=\"center\" width=\"5%\" style=\"font-size:11px;border:solid 1px black;\">PROV</td>                    
                    <td valign=\"top\" align=\"center\" width=\"5%\" style=\"font-size:11px;border:solid 1px black;\">APBN</td>   
                    <td valign=\"top\" align=\"center\" width=\"5%\" style=\"font-size:11px;border:solid 1px black;\">PAGU SBLM</td>
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\">T-U PROG</td>
                    <td valign=\"top\" align=\"center\" width=\"5%\" style=\"font-size:11px;border:solid 1px black;\">T-K PROG</td>
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\">T-U MAS</td>
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\">T-K MAS</td>
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\">T-U</td>
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\">T-K</td>
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\">T-U HAS</td>
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\">T-K HAS</td>                    
                    </tr>
                    "; 
           $no = 0;$jmlh5=0;$jmlh4=0;$jmlh3=0;$jmlh2=0;$jmlh1=0;     
           $sqld = "SELECT a.* from sipp_renja_temp a $param order by kegiatan";               
           $hasild = $this->db->query($sqld);    
           foreach ($hasild->result() as $rowd)
                    {
            $no = $no+1;
            
            
            $cRet .="<tr>
                    <td valign=\"top\" align=\"center\" width=\"3%\" style=\"font-size:11px;border:solid 1px black;\">".$no."</td>
                    <td valign=\"top\" align=\"center\" width=\"3%\" style=\"font-size:11px;border:solid 1px black;\">".$rowd->tahun."</td>                    
                    <td valign=\"top\" align=\"center\" width=\"5%\" style=\"font-size:11px;border:solid 1px black;\">".$rowd->skpd."</td>      
                    <td valign=\"top\" align=\"center\" width=\"3%\" style=\"font-size:11px;border:solid 1px black;\">".$rowd->kode_kegiatan."</td>                    
                    <td valign=\"top\" align=\"left\" width=\"7%\" style=\"font-size:11px;border:solid 1px black;\">".$rowd->kegiatan."</td>
                    <td valign=\"top\" align=\"center\" width=\"3%\" style=\"font-size:11px;border:solid 1px black;\">".$rowd->fisik_nonfisik."</td>
                    <td valign=\"top\" align=\"center\" width=\"3%\" style=\"font-size:11px;border:solid 1px black;\">".$rowd->baru_lanjutan."</td>                                        
                    <td valign=\"top\" align=\"center\" width=\"7%\" style=\"font-size:11px;border:solid 1px black;\">".$rowd->sasaran_kegiatan."</td>                    
                    <td valign=\"top\" align=\"center\" width=\"7%\" style=\"font-size:11px;border:solid 1px black;\">".$rowd->lokasi_kegiatan."</td>                    
                    <td valign=\"top\" align=\"right\" width=\"5%\" style=\"font-size:11px;border:solid 1px black;\">".number_format($rowd->apbd_kab,2)."</td>                                       
                    <td valign=\"top\" align=\"right\" width=\"5%\" style=\"font-size:11px;border:solid 1px black;\">".number_format($rowd->apbd_dak,2)."</td> 
                    <td valign=\"top\" align=\"right\" width=\"5%\" style=\"font-size:11px;border:solid 1px black;\">".number_format($rowd->apbd_prov,2)."</td>                    
                    <td valign=\"top\" align=\"right\" width=\"5%\" style=\"font-size:11px;border:solid 1px black;\">".number_format($rowd->apbn,2)."</td>   
                    <td valign=\"top\" align=\"right\" width=\"5%\" style=\"font-size:11px;border:solid 1px black;\">".number_format($rowd->pagu_sebelumnya,2)."</td>
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\">".$rowd->tu_prog."</td>
                    <td valign=\"top\" align=\"center\" width=\"5%\" style=\"font-size:11px;border:solid 1px black;\">".$rowd->tk_prog."</td>
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\">".$rowd->tu_mas."</td>
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\">".$rowd->tk_mas."</td>
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\">".$rowd->tu."</td>
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\">".$rowd->tk."</td>
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\">".$rowd->tu_has."</td>
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\">".$rowd->tk_has."</td>
                    </tr>
                    ";              
                    $jmlh1=$jmlh1+$rowd->apbd_kab;
                    $jmlh2=$jmlh2+$rowd->apbd_dak;
                    $jmlh3=$jmlh3+$rowd->apbd_prov;
                    $jmlh4=$jmlh4+$rowd->apbn;
                    $jmlh5=$jmlh5+$rowd->pagu_sebelumnya;    
                    }
                   $cRet .="
                    <tr>
                    <td valign=\"top\" align=\"center\" width=\"3%\" style=\"font-size:11px;border:solid 1px black;\"></td>                  
                    <td valign=\"top\" colspan=\"8\" align=\"center\" width=\"7%\" style=\"font-size:11px;border:solid 1px black;\">Jumlah</td>                    
                    <td valign=\"top\" align=\"right\" width=\"5%\" style=\"font-size:11px;border:solid 1px black;\">".number_format($jmlh1,2)."</td>                                       
                    <td valign=\"top\" align=\"right\" width=\"5%\" style=\"font-size:11px;border:solid 1px black;\">".number_format($jmlh2,2)."</td> 
                    <td valign=\"top\" align=\"right\" width=\"5%\" style=\"font-size:11px;border:solid 1px black;\">".number_format($jmlh3,2)."</td>                    
                    <td valign=\"top\" align=\"right\" width=\"5%\" style=\"font-size:11px;border:solid 1px black;\">".number_format($jmlh4,2)."</td>   
                    <td valign=\"top\" align=\"right\" width=\"5%\" style=\"font-size:11px;border:solid 1px black;\">".number_format($jmlh5,2)."</td>
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\"></td>
                    <td valign=\"top\" align=\"center\" width=\"5%\" style=\"font-size:11px;border:solid 1px black;\"></td>
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\"></td>
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\"></td>
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\"></td>
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\"></td>
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\"></td>
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\"></td>
                    </tr>
                    <tr>
                    <td valign=\"top\" align=\"center\" width=\"3%\" style=\"font-size:11px;border:solid 1px black;\"></td>                  
                    <td valign=\"top\" colspan=\"8\" align=\"center\" width=\"7%\" style=\"font-size:11px;border:solid 1px black;\">Total</td>                    
                    <td valign=\"top\" colspan=\"5\" align=\"right\" width=\"5%\" style=\"font-size:11px;border:solid 1px black;\">".number_format($jmlh1+$jmlh2+$jmlh3+$jmlh4+$jmlh5,2)."</td>
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\"></td>
                    <td valign=\"top\" align=\"center\" width=\"5%\" style=\"font-size:11px;border:solid 1px black;\"></td>
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\"></td>
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\"></td>
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\"></td>
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\"></td>
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\"></td>
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\"></td>
                    </tr>
                    ";
                         
            $cRet .="
                                                                 
            </table>";    
            
        $data['prev']= $cRet;    
        echo $cRet;
                
    }

    
    function cetak_renja_trskpd(){
        $kd_skpd = $this->session->userdata('kdskpd'); 
        $parskpd = $this->uri->segment(3);
        
        $param = "";
        $param_nama = "";
        if($parskpd<>""){
            $param = "where kode_skpd='$parskpd'";
            
            $init = substr($parskpd,1,7).".00";
            $param_nama = $this->tukd_model->get_nama($init,'nm_skpd','ms_skpd','kd_skpd');
        }
               
        //$this->tanggal_format_indonesia($tgl);       
         $cRet = '';
         echo ("<title>RENJA</title>");
         $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"1\" cellpadding=\"1\">
            <tr>
                <td align=\"center\" colspan=\"16\" style=\"font-size:14px;border: solid 1px white;\"><b>RENJA SIMAKDA<br/>".$param_nama."</b></td>
            </tr>
             <tr>
                <td align=\"left\" colspan=\"12\" style=\"font-size:12px;border: solid 1px white;\">&nbsp;</td>
                <td align=\"left\" colspan=\"4\" style=\"font-size:12px;border: solid 1px white;\"></td>
            </tr>
             </table>";            
            
           $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\">";
           $cRet .="<tr>
                    <td valign=\"top\" align=\"center\" width=\"3%\" style=\"font-size:11px;border:solid 1px black;\">NO</td>
                    <td valign=\"top\" align=\"center\" width=\"3%\" style=\"font-size:11px;border:solid 1px black;\">TAHUN</td>                    
                    <td valign=\"top\" align=\"center\" width=\"7%\" style=\"font-size:11px;border:solid 1px black;\">SKPD</td>      
                    <td valign=\"top\" align=\"center\" width=\"5%\" style=\"font-size:11px;border:solid 1px black;\">KODE</td>                    
                    <td valign=\"top\" align=\"center\" width=\"7%\" style=\"font-size:11px;border:solid 1px black;\">KEGIATAN</td>
                    <td valign=\"top\" align=\"center\" width=\"7%\" style=\"font-size:11px;border:solid 1px black;\">SASARAN KEG</td>                    
                    <td valign=\"top\" align=\"center\" width=\"7%\" style=\"font-size:11px;border:solid 1px black;\">LOKASI</td>                    
                    <td valign=\"top\" align=\"center\" width=\"9%\" style=\"font-size:11px;border:solid 1px black;\">APBD</td>
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\">T-U PROG</td>
                    <td valign=\"top\" align=\"center\" width=\"5%\" style=\"font-size:11px;border:solid 1px black;\">T-K PROG</td>
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\">T-U MAS</td>
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\">T-K MAS</td>
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\">T-U</td>
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\">T-K</td>
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\">T-U HAS</td>
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\">T-K HAS</td>                    
                    </tr>
                    "; 
           $no = 0;$jmlh5=0;$jmlh4=0;$jmlh3=0;$jmlh2=0;$jmlh1=0;     
           $sqld = "SELECT 
'2020' tahun,
nm_skpd skpd,
right(kd_kegiatan,3) kode_kegiatan,
nm_kegiatan kegiatan,
sasaran_giat sasaran_kegiatan,
lokasi lokasi_kegiatan,
total,
tu_capai tu_prog,
tk_capai tk_prog,
tu_mas,
tk_mas,
tu_kel tu,
tk_kel tk,
tu_has,
tk_has
from trskpd a where kd_skpd='$init' order by a.nm_kegiatan";               
           $hasild = $this->db->query($sqld);    
           foreach ($hasild->result() as $rowd)
                    {
            $no = $no+1;
            
            
            $cRet .="<tr>
                    <td valign=\"top\" align=\"center\" width=\"3%\" style=\"font-size:11px;border:solid 1px black;\">".$no."</td>
                    <td valign=\"top\" align=\"center\" width=\"3%\" style=\"font-size:11px;border:solid 1px black;\">".$rowd->tahun."</td>                    
                    <td valign=\"top\" align=\"center\" width=\"7%\" style=\"font-size:11px;border:solid 1px black;\">".$rowd->skpd."</td>      
                    <td valign=\"top\" align=\"center\" width=\"5%\" style=\"font-size:11px;border:solid 1px black;\">".$rowd->kode_kegiatan."</td>                    
                    <td valign=\"top\" align=\"left\" width=\"7%\" style=\"font-size:11px;border:solid 1px black;\">".$rowd->kegiatan."</td>
                    <td valign=\"top\" align=\"center\" width=\"7%\" style=\"font-size:11px;border:solid 1px black;\">".$rowd->sasaran_kegiatan."</td>                    
                    <td valign=\"top\" align=\"center\" width=\"7%\" style=\"font-size:11px;border:solid 1px black;\">".$rowd->lokasi_kegiatan."</td>                    
                    <td valign=\"top\" align=\"right\" width=\"9%\" style=\"font-size:11px;border:solid 1px black;\">".number_format($rowd->total,2)."</td>
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\">".$rowd->tu_prog."</td>
                    <td valign=\"top\" align=\"center\" width=\"5%\" style=\"font-size:11px;border:solid 1px black;\">".$rowd->tk_prog."</td>
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\">".$rowd->tu_mas."</td>
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\">".$rowd->tk_mas."</td>
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\">".$rowd->tu."</td>
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\">".$rowd->tk."</td>
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\">".$rowd->tu_has."</td>
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\">".$rowd->tk_has."</td>
                    </tr>
                    ";              
                    $jmlh1=$jmlh1+$rowd->total;    
                    }
                   $cRet .="
                    <tr>
                    <td valign=\"top\" align=\"center\" width=\"3%\" style=\"font-size:11px;border:solid 1px black;\"></td>                  
                    <td valign=\"top\" colspan=\"8\" align=\"center\" width=\"7%\" style=\"font-size:11px;border:solid 1px black;\">Jumlah</td>                    
                    <td valign=\"top\" align=\"right\" width=\"5%\" style=\"font-size:11px;border:solid 1px black;\">".number_format($jmlh1,2)."</td>                                       
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\"></td>
                    <td valign=\"top\" align=\"center\" width=\"5%\" style=\"font-size:11px;border:solid 1px black;\"></td>
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\"></td>
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\"></td>
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\"></td>
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\"></td>
                    </tr>
                    <tr>
                    <td valign=\"top\" align=\"center\" width=\"3%\" style=\"font-size:11px;border:solid 1px black;\"></td>                  
                    <td valign=\"top\" colspan=\"8\" align=\"center\" width=\"7%\" style=\"font-size:11px;border:solid 1px black;\">Total</td>                    
                    <td valign=\"top\" colspan=\"5\" align=\"right\" width=\"5%\" style=\"font-size:11px;border:solid 1px black;\">".number_format($jmlh1,2)."</td>
                    <td valign=\"top\" align=\"center\" width=\"10%\" style=\"font-size:11px;border:solid 1px black;\"></td>
                    <td valign=\"top\" align=\"center\" width=\"5%\" style=\"font-size:11px;border:solid 1px black;\"></td>
                    </tr>
                    ";
                         
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
            //CURLOPT_URL => "http://bebas.pontianakkota.online/api/v1",
            CURLOPT_URL => "http://portaldata.pontianakkota.go.id/api/v1",
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
            //CURLOPT_URL => "http://bebas.pontianakkota.online/api/v1",
            CURLOPT_URL => "http://portaldata.pontianakkota.go.id/api/v1",
            
            
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
    
    function load_skpd() {
        $lccr='';        
        $lccr = $this->input->post('q');        
        $sql = "SELECT '0'+left(kd_skpd,7) kd_skpd,nm_skpd FROM ms_skpd WHERE right(kd_skpd,2)='00'";   

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
    function load_skpdx() {
        $lccr='';        
        $lccr = $this->input->post('q');        
        $sql = "SELECT kd_skpd,nm_skpd FROM ms_skpd WHERE right(kd_skpd,2)='00'";   

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
    
    
    function request_update_renjarka(){
        $parskpd = $this->uri->segment(3);
        $initskpd = substr($parskpd,1,7).".00";
        
        $query = "DECLARE @skpd varchar(25)
set @skpd = '$initskpd'

update c 

set 
c.lokasi=d.lokasi,
c.sasaran_giat=d.sasaran_giat,
c.tu_capai=d.tu_capai,
c.tu_capai_sempurna=d.tu_capai_sempurna,
c.tu_capai_ubah=d.tu_capai_ubah,
c.tu_mas=d.tu_mas,
c.tu_mas_sempurna=d.tu_mas_sempurna,
c.tu_mas_ubah=d.tu_mas_ubah,
c.tu_kel=d.tu_kel,
c.tu_kel_sempurna=d.tu_kel_sempurna,
c.tu_kel_ubah=d.tu_kel_ubah,
c.tu_has=d.tu_has,
c.tu_has_sempurna=d.tu_has_sempurna,
c.tu_has_ubah=d.tu_has_ubah,
c.tk_capai=d.tk_capai,
c.tk_capai_sempurna=d.tk_capai_sempurna,
c.tk_capai_ubah=d.tk_capai_ubah,
c.tk_mas=d.tk_mas,
c.tk_mas_sempurna=d.tk_mas_sempurna,
c.tk_mas_ubah=d.tk_mas_ubah,
c.tk_kel=d.tk_kel,
c.tk_kel_sempurna=d.tk_kel_sempurna,
c.tk_kel_ubah=d.tk_kel_ubah,
c.tk_has=d.tk_has,
c.tk_has_sempurna=d.tk_has_sempurna,
c.tk_has_ubah=d.tk_has_ubah,
c.ang_lalu=d.ang_lalu,
c.rancang=d.rancang

from trskpd c

left join (
select * from(
select 
right(kode_skpd,7)+'.00'+'.'+kode_bid+'.'+right(kode_skpd,7)+'.'+'00'+'.'+kode_prog+'.'+kode_giatx kd_gabungan,
kode_bid+'.'+right(kode_skpd,7)+'.'+'00'+'.'+kode_prog+'.'+kode_giatx kd_kegiatan,
kode_bid+'.'+right(kode_skpd,7)+'.'+'00'+'.'+kode_prog kd_program,
kode_bid as kd_urusan,
right(kode_skpd,7)+'.00' kd_skpd,
skpd as nm_skpd,
kode_bid+'.'+right(kode_skpd,7)+'.'+'00'+'.'+kode_prog+'.'+kode_giatx kd_kegiatan1,
kegiatan as nm_kegiatan,
'52' as jns_kegiatan,
kode_bid+'.'+right(kode_skpd,7)+'.'+'00'+'.'+kode_prog kd_program1,
program as nm_program,
null as indika,
null as tu,
null as tk,
sasaran_kegiatan as sasaran_giat,
null as sumber_dana,
null as waktu_giat,
null as tk_kwt,
null as kd_pptk,
null as kd_comp,
null as kontrak,
null as jns_keg,
tu_prog as tu_capai,
tu_prog as tu_capai_sempurna,
tu_prog as tu_capai_ubah,
tu_mas as tu_mas,
tu_mas as tu_mas_sempurna,
tu_mas as tu_mas_ubah,
tu as tu_kel,
tu as tu_kel_sempurna,
tu as tu_kel_ubah,
tu_has as tu_has,
tu_has as tu_has_sempurna,
tu_has as tu_has_ubah,
tk_prog as tk_capai,
tk_prog as tk_capai_sempurna,
tk_prog as tk_capai_ubah,
tk_mas as tk_mas,
tk_mas as tk_mas_sempurna,
tk_mas as tk_mas_ubah,
tk as tk_kel,
tk as tk_kel_sempurna,
tk as tk_kel_ubah,
tk_has as tk_has,
tk_has as tk_has_sempurna,
tk_has as tk_has_ubah,
null as alasan,
null as username,
null as latar_belakang,
0 as triw1,
0 as triw1_sempurna,
0 as triw1_ubah,
0 as triw2,
0 as triw2_sempurna,
0 as triw2_ubah,
0 as triw3,
0 as triw3_sempurna,
0 as triw3_ubah,
0 as triw4,
0 as triw4_sempurna,
0 as triw4_ubah,
0 as total,
0 as total_sempurna,
0 as total_ubah,
lokasi_kegiatan as lokasi,
1 as status_keg,
null as lanjut,
pagu_sebelumnya as ang_lalu,
null as username1,
null as last_update,
apbd_kab+apbd_prov+apbd_dak+apbn as rancang,
null as kd_subkegiatan,
null as nm_subkegiatan,
null as kd_bidsubkegiatan,
0 as triw1_sempurna_2,
0 as triw2_sempurna_2,
0 as triw3_sempurna_2,
0 as triw4_sempurna_2,
0 as total_sempurna_2,
0 as triw1_sempurna_final,
0 as triw2_sempurna_final,
0 as triw3_sempurna_final,
0 as triw4_sempurna_final,
0 as total_sempurna_final

from (

select *,case when kode_urusan+'.'+kode_bidang = '4.08' and left(kode_skpd,5) != '04.08' then 'rutin' else 'bukan'
end as hasil,
case when kode_urusan+'.'+kode_bidang = '4.08' and left(kode_skpd,5) != '04.08' 
then substring(kode_skpd,2,4)
when kode_urusan+'.'+kode_bidang = '4.01' and left(kode_skpd,5) != '04.01' 
then substring(kode_skpd,2,4)
when kode_urusan+'.'+kode_bidang = '4.01' and left(kode_skpd,5) = '04.08' 
then substring(kode_skpd,2,4)
when kode_urusan+'.'+kode_bidang = '4.0.01'
then substring(kode_skpd,2,4) else kode_urusan+'.'+kode_bidang end as kode_bid,
case when len(kode_program) = 1 then '0'+kode_program 
when len(kode_program) = 2 then kode_program else '99' end as kode_prog,
case when len(kode_kegiatan) = 1 then '00'+kode_kegiatan 
when len(kode_kegiatan) = 2 then '0'+kode_kegiatan
when len(kode_kegiatan) = 3 then kode_kegiatan else '999' end as kode_giatx
from sipp_renja_temp
)x
) x
where x.kd_kegiatan in 
(select kd_kegiatan from m_giat where substring(kd_kegiatan,6,10) = @skpd group by kd_kegiatan ) 
)d on d.kd_kegiatan=c.kd_kegiatan and d.kd_skpd=c.kd_skpd
where c.kd_kegiatan in 
(select kd_kegiatan from m_giat where substring(kd_kegiatan,6,10) = @skpd group by kd_kegiatan)

";

        $sql = $this->db->query($query);
        if($sql){
            echo '1';
        }else{
            echo '2';
        }
     }

    function request_simpan_renja_rka(){
        $parskpd = $this->uri->segment(3);
        $initskpd = substr($parskpd,1,7).".00";
        
        //$this->db->query("delete from trskpd where kd_skpd='$initskpd'");
        
        $query = "update trskpd set total =
(select isnull(sum(nilai),0) from  trdrka where trdrka.kd_kegiatan =trskpd.kd_kegiatan),
total_sempurna =
(select isnull(sum(nilai_sempurna),0) from  trdrka where trdrka.kd_kegiatan =trskpd.kd_kegiatan),
total_ubah =
(select isnull(sum(nilai_ubah),0) from  trdrka where trdrka.kd_kegiatan =trskpd.kd_kegiatan)
where left(kd_skpd,7)=left('$initskpd',7)";
        
        
    $sql = $this->db->query($query);
    if($sql){
        echo '1';
    }else{
        echo '2';
    }
        
    }
    
     function request_simpan_renja_angkas(){
        $parskpd = $this->uri->segment(3);
        $initskpd = substr($parskpd,1,7).".00";
        
        //$this->db->query("delete from trskpd where kd_skpd='$initskpd'");
        
        $query = "update trskpd set triw1 =
(select isnull(sum(nilai),0) from  trdskpd_ro where kd_kegiatan =trskpd.kd_kegiatan and bulan in ('1','2','3')),
triw2 =
(select isnull(sum(nilai),0) from  trdskpd_ro where kd_kegiatan =trskpd.kd_kegiatan and bulan in ('4','5','6')),
triw3 =
(select isnull(sum(nilai),0) from  trdskpd_ro where kd_kegiatan =trskpd.kd_kegiatan and bulan in ('7','8','9')),
triw4 =
(select isnull(sum(nilai),0) from  trdskpd_ro where kd_kegiatan =trskpd.kd_kegiatan and bulan in ('10','11','12'))
where left(kd_skpd,7)=left('$initskpd',7)";
        
        
    $sql = $this->db->query($query);
    
    $this->db->query("update trskpd set 
triw1_sempurna=triw1,triw2_sempurna=triw2,triw3_sempurna=triw3,triw4_sempurna=triw4,
triw1_ubah=triw1,triw2_ubah=triw2,triw3_ubah=triw3,triw4_ubah=triw4
where left(kd_skpd,7)=left('$initskpd',7)");
    
    if($sql){
        echo '1';
    }else{
        echo '2';
    }
        
    }
    
   //akhir
}