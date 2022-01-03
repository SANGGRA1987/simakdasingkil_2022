<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sb extends CI_Controller {

	function __contruct(){	
		parent::__construct();
	}    
	
    function cek_standart($init=''){
       $jm=0; 
       $sql = "select sum(c.jm_sb) jm_sb,sum(c.jm_sh) jm_sh,sum(c.jm_sab) jm_sab from(
		select count(*)jm_sb,0 jm_sh,0 jm_sab from mssisb where kode_rek_rinci not in 
		(select kode_rek_rinci from mssish) and left(kode_rek_rinci,7)='$init'
		UNION ALL
		select 0 jm_sb,count(*)jm_sh,0 jm_sab from mssish where kode_rek_rinci not in 
		(select kode_rek_rinci from mssisb) and left(kode_rek_rinci,7)='$init'
		UNION ALL
		select 0 jm_sb,0 jm_sh,count(*) jm_sab from mssab where kode_rek_rinci not in 
		(select kode_rek_rinci from mssisb) and left(kode_rek_rinci,7)='$init'
		)c";                   
        
        $query1 = $this->db->query($sql)->row();
        $sb = $query1->jm_sb;
        $sh = $query1->jm_sh;
		$sab = $query1->jm_sab;
        
        if($sh>0){
            $jm=1;
        }else{
            if($sb>0){
                $jm=2;
            }else{
                if($sab>0){
					$jm=3;
				}else{
					$jm=0;
				}
            }
        }
        
        echo $jm;
    }
    
    function select_sisb($init='') {
        $header1 = substr($init,0,7);
        $header2 = substr($init,0,9);
        $header3 = substr($init,0,11);
        $sql = "select top 1 uraian from mssisb where kode_rek_rinci='$header1' 
                union all
                select top 1 '- '+uraian from mssisb where kode_rek_rinci='$header2'
                union all
                select top 1 '-- '+uraian from mssisb where kode_rek_rinci='$header3'
                ";                   
        
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        {
            
            $result[] = array(
                        'id' => $ii,        
                        'uraian' => $resulte['uraian']                            

                        );
                        $ii++;
        }
           
           echo json_encode($result);
            $query1->free_result();
    }
    
    function select_sisb_all() {
       $sql = "select top 426 kode_rek_rinci,uraian,satuan,besaran from mssisb order by kode_rek_rinci
                ";                   
        
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii=0;
        foreach($query1->result_array() as $resulte)
        {
            
            $result[] = array(
                        'id' => $ii, 
                        'kode' => $resulte['kode_rek_rinci'],        
                        'uraian' => $resulte['uraian'],
                        'satuan' => $resulte['satuan'],
                        'besaran' => $resulte['besaran']                                  

                        );
                        $ii++;
        }
           
          echo json_encode($result);
        
    }

    function select_sish_all() {
       $sql = "select top 355 kode_rek_rinci,uraian,satuan,besaran from mssish order by kode_rek_rinci
                ";                   
        
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii=0;
        foreach($query1->result_array() as $resulte)
        {
            
            $result[] = array(
                        'id' => $ii, 
                        'kode' => $resulte['kode_rek_rinci'],        
                        'uraian' => $resulte['uraian'],
                        'satuan' => $resulte['satuan'],
                        'besaran' => $resulte['besaran']                                  

                        );
                        $ii++;
        }
           
          echo json_encode($result);
        
    }

    function select_sish($init='') {
        $header1 = substr($init,0,7);
        $sql = "select top 1 nm_rek5 as uraian from ms_rek5 where kd_rek5='$header1' 
                ";                   
        
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        {
            
            $result[] = array(
                        'id' => $ii,        
                        'uraian' => $resulte['uraian']                            

                        );
                        $ii++;
        }
           
           echo json_encode($result);
            $query1->free_result();
    }
	
    
    function ambil_sisb($init='') {
        $lccr = $this->input->post('q');
        
        if($init==''){
            $sql = "SELECT top 200 kode_rek_rinci kode, header, uraian text,satuan,besaran FROM mssisb where left(kode_rek_rinci,1)='5' and (upper(header) like upper('%$lccr%') or upper(uraian) like upper('%$lccr%')) order by kode_rek_rinci";
        }else{

           $sqll = "SELECT count(*) jm FROM mssisb where left(kode_rek_rinci,7)='$init'";
            $cek = $this->db->query($sqll);
            $cek2 = $cek->row();
            $jm = $cek2->jm;
         
           if($jm==0){
            $sql = "SELECT top 200 kode_rek_rinci kode, header, uraian text,satuan,besaran FROM mssisb where left(kode_rek_rinci,1)='5' and (upper(header) like upper('%$lccr%') or upper(uraian) like upper('%$lccr%')) order by kode_rek_rinci";
            }else{ 

            if($init=='5110806'){
                $top = "top 30";    
             }else{
                $top = "top ".$jm; 
             }

             $sql = "SELECT $top kode_rek_rinci kode, header, uraian text,satuan,besaran FROM mssisb where left(kode_rek_rinci,7)='$init' and (upper(header) like upper('%$lccr%') or upper(uraian) like upper('%$lccr%')) order by kode_rek_rinci";           
            }
        }

        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kode' => $resulte['kode'],  
                        'header' => $resulte['header'],
                        'text' => $resulte['text'],
                        'satuan' => $resulte['satuan'],
                        'besaran' => $resulte['besaran']
                        );
                        $ii++;
        }
        //echo $jm;   
        echo json_encode($result);
           
    }

    function ambil_sish($init='') {
        $lccr = $this->input->post('q');
        
        if($init==''){
            $sql = "SELECT top 200 kode_rek_rinci kode, header, uraian text,satuan,besaran FROM mssish where left(kode_rek_rinci,1)='5' and (upper(header) like upper('%$lccr%') or upper(uraian) like upper('%$lccr%')) order by kode_rek_rinci";
        }else{

           $sqll = "SELECT count(*) jm FROM mssish where left(kode_rek_rinci,7)='$init'";
            $cek = $this->db->query($sqll);
            $cek2 = $cek->row();
            $jm = $cek2->jm;
         
           if($jm==0){
            $sql = "SELECT top 200 kode_rek_rinci kode, header, uraian text,satuan,besaran FROM mssish where left(kode_rek_rinci,1)='5' and (upper(header) like upper('%$lccr%') or upper(uraian) like upper('%$lccr%')) order by kode_rek_rinci";
            }else{ 

            if($init=='5110806'){
                $top = "top 30";    
             }else{
                $top = "top ".$jm; 
             }

             $sql = "SELECT $top kode_rek_rinci kode, header, uraian text,satuan,besaran FROM mssish where left(kode_rek_rinci,7)='$init' and (upper(header) like upper('%$lccr%') or upper(uraian) like upper('%$lccr%')) order by kode_rek_rinci";           
            }
        }

        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kode' => $resulte['kode'],  
                        'header' => $resulte['header'],
                        'text' => $resulte['text'],
                        'satuan' => $resulte['satuan'],
                        'besaran' => $resulte['besaran']
                        );
                        $ii++;
        }
        //echo $jm;   
        echo json_encode($result);
           
    }
    
    function ambil_siasb($init='') {
        $lccr = $this->input->post('q');
        
        if($init==''){
            $sql = "SELECT top 200 kode_rek_rinci kode, header, uraian text,satuan,besaran FROM mssab where left(kode_rek_rinci,1)='5' and (upper(header) like upper('%$lccr%') or upper(uraian) like upper('%$lccr%')) order by kode_rek_rinci";
        }else{

           $sqll = "SELECT count(*) jm FROM mssab where left(kode_rek_rinci,7)='$init'";
            $cek = $this->db->query($sqll);
            $cek2 = $cek->row();
            $jm = $cek2->jm;
         
           if($jm==0){
            $sql = "SELECT top 200 kode_rek_rinci kode, header, uraian text,satuan,besaran FROM mssab where left(kode_rek_rinci,1)='5' and (upper(header) like upper('%$lccr%') or upper(uraian) like upper('%$lccr%')) order by kode_rek_rinci";
            }else{ 

            if($init=='5110806'){
                $top = "top 30";    
             }else{
                $top = "top ".$jm; 
             }

             $sql = "SELECT $top kode_rek_rinci kode, header, uraian text,satuan,besaran FROM mssab where left(kode_rek_rinci,7)='$init' and (upper(header) like upper('%$lccr%') or upper(uraian) like upper('%$lccr%')) order by kode_rek_rinci";           
            }
        }

        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kode' => $resulte['kode'],  
                        'header' => $resulte['header'],
                        'text' => $resulte['text'],
                        'satuan' => $resulte['satuan'],
                        'besaran' => $resulte['besaran']
                        );
                        $ii++;
        }
        //echo $jm;   
        echo json_encode($result);
           
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
            //echo $child->satuan;  
            echo $child3;          
                   
    }
	
	function ambil_asb1_filter($id=''){
       //$id='524040202'; 
       $id = $this->input->post('id');
       
       $headers = array('Content-Type: application/json',); 
              
       $init_url = "http://sisb.pontianakkota.go.id/api/asb/?kode_rek=".$id."&type=row";
       
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
            echo $child3;  
            //echo $child[0]->uraian;          
                   
    }

    function ambil_asb1_2($id=''){
       //$id='524040202'; 
       $id = $this->input->post('id');
       
       $headers = array('Content-Type: application/json',); 
              
       $init_url = "http://sisb.pontianakkota.go.id/api/asb/?kode_rek=all&type=json";
       
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
            echo $child3;  
            //echo $child[0]->uraian;          
                   
    }
    
}