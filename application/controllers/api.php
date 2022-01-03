<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class api extends CI_Controller {

	function __construct()
	{	
		parent::__construct();
  
	}


   function realisasi(){

        $tahun = $_GET["tahun"];
        $pass  = $_GET["pass"];
        $select= $_GET["select"];

        if($pass=='Simak123DaProv'){
            echo $this->service->api($tahun,$pass,$select);
        }else{
            $data[]=array('Respon'=>'Password salah');
            echo json_encode($data);
        }          
   }
   
}