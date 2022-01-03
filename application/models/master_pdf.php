<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Fungsi Model
 */ 

class master_pdf extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function _mpdf($judul='',$isi='',$lMargin=10,$rMargin=10,$font='',$orientasi='',$hal='', $fonsize='') {
                

        ini_set("memory_limit","-1M");
        ini_set("MAX_EXECUTION_TIME","-1");
        $this->load->library('mpdf');

        $this->mpdf->defaultheaderfontsize = 10;    /* in pts */
        $this->mpdf->defaultheaderfontstyle = I;    /* blank, B, I, or BI */
        $this->mpdf->defaultheaderline = 1;     /* 1 to include line below header/above footer */

        $this->mpdf->defaultfooterfontsize = 3; /* in pts */
        $this->mpdf->defaultfooterfontstyle = I;    /* blank, B, I, or BI */
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

        $this->mpdf->AddPage($orientasi,'',$hal,'1','off');
        if ($hal==''){
            $this->mpdf->SetFooter("");
        }
        else{
            $this->mpdf->SetFooter("Printed on Simakda || Halaman {PAGENO}  ");
        }
        if (!empty($judul)) $this->mpdf->writeHTML($judul);
        $this->mpdf->writeHTML($isi);         
        $this->mpdf->Output();
    }


     function _mpdf_margin($judul='',$isi='',$lMargin=10,$rMargin=10,$font='',$orientasi='',$hal='', $fonsize='',$atas='', $bawah='', $kiri='', $kanan='') {

        ini_set("memory_limit","-1M");
        ini_set("MAX_EXECUTION_TIME","-1");
        $this->load->library('mpdf');        
        $this->mpdf->defaultheaderfontsize = 10;    /* in pts */
        $this->mpdf->defaultheaderfontstyle = I;    /* blank, B, I, or BI */
        $this->mpdf->defaultheaderline = 1;     /* 1 to include line below header/above footer */

        $this->mpdf->defaultfooterfontsize = 3; /* in pts */
        $this->mpdf->defaultfooterfontstyle = I;    /* blank, B, I, or BI */
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
}