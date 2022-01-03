<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sb extends CI_Controller {

	function __contruct(){	
		parent::__construct();
	}    
	
    function insert_sb(){

        $headers = array('Content-Type: application/json',); 
        $init_url = "http://sisb.pontianakkota.go.id/api/standar_biaya/?kode_rek=all&tahun=2020&type=json";
        
            $headers = array('Content-Type: application/json',); 
            $ch = curl_init();
            
            curl_setopt($ch, CURLOPT_URL, $init_url);
            curl_setopt($ch, CURLOPT_POST, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );

            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
            $result = curl_exec($ch);
            curl_close($ch);

            //echo $result;
            $data4  = json_decode($result);
            //print_r($child[0]->text); 

            $jsonrow = 200;
              
                                 
                    for ($j = 0; $j < $jsonrow; $j++) {

            $data2 = $data4[$j]->children;
            $data1 = json_encode($data2);
            $datav = json_decode($data1);

            $jsonkrow = 200;                    
            for ($k = 0; $k < $jsonkrow; $k++) { 
            $data9 = $datav[$k]->children;
            $data91 = json_encode($data9);
            $datan = json_decode($data91);

            $jsonkrow = 200;                    
            for ($l = 0; $l < $jsonkrow; $l++) { 
            $data9a = $datan[$l]->children;
            $data91a = json_encode($data9a);
            $data = json_decode($data91a);

            //echo $result;
            $besaran = 0;
            $tabel = "ms_sisb";
            $kolom = "(id_standar_biaya,kode_rek,id_parent,id,header,level,numbering,text,satuan,besaran,tahun)";

            $json_row = 200;
              
                $jm = $json_row;                    
                    for ($i = 0; $i < $jm; $i++) {
                     
                    if(strval($data[$i]->besaran)==''){
                        $besaran = 0;
                    }else{
                        $besaran = $data[$i]->besaran;                        
                    }    

                    $nilai = "(
                    '".$data[$i]->id_standar_biaya."',
                    '".$data[$i]->kode_rek."',
                    '".$data[$i]->id_parent."',
                    '".$data[$i]->id."',
                    '".str_replace("'","",$data[$i]->header)."',
                    '".$data[$i]->level."',
                    '".$data[$i]->numbering."',
                    '".str_replace("'","",$data[$i]->text)."',
                    '".$data[$i]->satuan."',
                    '".$besaran."',
                    '".$data[$i]->tahun."')";    
                    
                    $sql = "insert into $tabel $kolom values $nilai";                 
                    $asg = $this->db->query($sql);
                                                                                
                    //print_r($nilai);                                                                                 
                    }}}}
        
    }

    function ambil_sb1($init=''){

        if($init==''){
            $init_url = "http://sisb.pontianakkota.go.id/api/standar_biaya/?kode_rek=all&tahun=2020&type=json";
        }else{
            $init_url = "http://sisb.pontianakkota.go.id/api/standar_biaya/?kode_rek=".$init."&tahun=2020&type=json";
        }
        
       $headers = array('Content-Type: application/json',); 
              
       
       
            $ch = curl_init();
            
            curl_setopt($ch, CURLOPT_URL, $init_url);
            curl_setopt($ch, CURLOPT_POST, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );

            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
            $result = curl_exec($ch);
            curl_close($ch);

            //echo $result;
            $child  = json_decode($result);
            $child2 = json_encode($result);
            $child3 = json_decode($child2);
            //echo $child2->child; 

           if($child){
            echo $child3;
           }else{
            $init_url = "http://sisb.pontianakkota.go.id/api/standar_biaya/?kode_rek=all&tahun=2020&type=json";
        
            $headers = array('Content-Type: application/json',); 
              
       
       
            $ch = curl_init();
            
            curl_setopt($ch, CURLOPT_URL, $init_url);
            curl_setopt($ch, CURLOPT_POST, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );

            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
            $result = curl_exec($ch);
            curl_close($ch);

            //echo $result;

            $child2 = json_encode($result);
            $child3 = json_decode($child2);
              
            echo $child3; 
           }                                 
    }
    
    function ambil_sb1_filter($id=''){
       //$id='51108030101'; 
       $id = $this->input->post('id');
       
       $headers = array('Content-Type: application/json',); 
              
       $init_url = "http://sisb.pontianakkota.go.id/api/standar_biaya/?kode_rek=".$id."&tahun=2020&type=row";
       
        	$ch = curl_init();
            
            curl_setopt($ch, CURLOPT_URL, $init_url);
            curl_setopt($ch, CURLOPT_POST, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );

            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
            $result = curl_exec($ch);
            curl_close($ch);

            $child  = json_decode($result);    
            $child2 = json_encode($result);
            $child3 = json_decode($child2);
            //echo $child->saruan;  
            echo $child3;          
                   
    }
    
}