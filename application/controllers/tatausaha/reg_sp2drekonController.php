<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class reg_sp2drekonController extends CI_Controller {

	function __construct()
	{	 
		parent::__construct();
		$this->load->model('public_model','Mpublic');	
	}  
	
	
    function index(){ 
        $data['page_title']= 'REGISTER S P 2 D';
        $this->template->set('title', 'REGISTER TERBIT CAIR SP2D');   
        $this->template->load('template','tukd/register/rekon_sp2d',$data) ; 		        

    }	

  function skpd() {
    $skpd = $this->session->userdata('kdskpd');
    $lccr = $this->input->post('q');

    if ($lccr == '') {
      $where = '';
    } else {
      $where = "WHERE upper(kd_skpd) like upper('%$lccr%') or upper(nm_skpd) like upper('%$lccr%')";
    }

    $sql = "SELECT kd_skpd,nm_skpd FROM ms_skpd $where";
    $query1 = $this->db->query($sql);  
    $result = array();
    $ii = 0;
    foreach($query1->result_array() as $resulte)
    { 

      $result[] = array(
        'id' => $ii,        
        'kd_skpd' => $resulte['kd_skpd'],  
        'nm_skpd' => $resulte['nm_skpd'],  

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
	
	
  
  function cetak_register_persp2d_baru($dcetak='',$ttd='',$skpd='',$tstatus='',$dcetak2='',$cetak=1, $pilihan='',$tglttd=''){ //Tox
	$print = $cetak;    
	 $tahun  = $this->session->userdata('pcThang');
    $sqlsc="SELECT tgl_rka,provinsi,kab_kota,daerah,thn_ang FROM sclient";
                 $sqlsclient=$this->db->query($sqlsc);
                 foreach ($sqlsclient->result() as $rowsc)
                {
                    $kab     = $rowsc->kab_kota;
                    $daerah  = $rowsc->daerah;
                   
                }
                
        $kd ='';
        $a ='';
        $nama ='';
		$where2='';	
        
			switch ($pilihan){
                        case '1': //SEMUA
							$where3 ="";
                            $ket3 ="PER JANUARI S/D DESEMBER";                            
                            break;
                        case '2': //BULAN
                           $where3=" and MONTH(tgl_sp2d)='$dcetak' ";
                           $nm_bulanawal = $this->Mpublic->getBulan_kasda($dcetak);
                           $ket3 ="PER BULAN ".$nm_bulanawal;
                            break;
						case '3': //PERIODE
                           $where3= " and ( tgl_sp2d between '$dcetak' and '$dcetak2') ";
                           $n_tglawal1   = $this->Mpublic->tanggal_format_indonesia_kasda2($dcetak);
		                   $n_tglawal2   = $this->Mpublic->tanggal_format_indonesia_kasda2($dcetak2);                                                      
                           $ket3 ="PER ".$n_tglawal1." S/D ".$n_tglawal2;
                            break;
                      }		
						   
            $ket4="";
            $init = $skpd;
            if ($init <> '--'){                               
                $sk = $this->db->query("select nm_skpd from ms_skpd where kd_skpd='$init'")->row();
                $ket4 = 'SKPD : '.$sk->nm_skpd;                        
            }              
                          
		
        $cRet = "<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"1\" cellpadding=\"1\">";
        $cRet .="<thead>
        <tr>
            <td align=\"center\" style=\"font-size:14px;border: solid 1px white;border-bottom:solid 1px white;\" colspan=\"12\"><b>PEMERINTAH ".strtoupper($kab)."</b></td>            
        </tr>
        <tr>            
            <td align=\"center\" style=\"font-size:14px;border: solid 1px white;border-bottom:solid 1px white;\" colspan=\"12\"><b>REGISTER SP2D TERBIT DAN CAIR TAHUN ANGGARAN $tahun</b></td>
        </tr>
        <tr>            
            <td align=\"center\" style=\"font-size:14px;border: solid 1px white;border-bottom:solid 1px white;\" colspan=\"12\"><b>$ket3</b></td>
        </tr>
		
        <tr>            
            <td align=\"left\" style=\"font-size:14px;border: solid 1px white;border-bottom:solid 1px black;\" colspan=\"12\"><b>$ket4</b></td>
        </tr>		
		
        <tr>
            <td style=\"font-size:12px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"5%\" rowspan=\"2\"><b>No.<br>Urut</b></td>
            <td style=\"font-size:12px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"95%\" colspan=\"11\"><b>SP2D</td>
        </tr>  
        <tr>
         <td style=\"font-size:12px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"10%\" ><b>NO. SPM</b></td>
			   <td style=\"font-size:12px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"5%\" ><b>TANGGAL TERBIT</b></td>
         <td style=\"font-size:12px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"5%\" ><b>TANGGAL ADVICE</b></td>
         <td style=\"font-size:12px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"10%\" ><b>NO. ADVICE</b></td>         
         <td style=\"font-size:12px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"5%\" ><b>TANGGAL CAIR</b></td>            
         <td style=\"font-size:12px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"10%\" ><b>NO. SP2D</b></td>
         <td style=\"font-size:12px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"10%\" ><b>URAIAN</b></td>
         <td style=\"font-size:12px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"10%\" ><b>UP</b></td>
         <td style=\"font-size:12px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"10%\" ><b>GU</b></td>
         <td style=\"font-size:12px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"10%\" ><b>TU</b></td>
         <td style=\"font-size:12px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"10%\" ><b>LS </b></td>
        </tr> 
        <tr>
            <td style=\"font-size:12px\" align=\"center\" width=\"5%\"><b>1</b></td>
            <td style=\"font-size:12px\" align=\"center\" width=\"10%\"><b>2</b></td>
            <td style=\"font-size:12px\" align=\"center\" width=\"5\"><b>3</b></td>
            <td style=\"font-size:12px\" align=\"center\" width=\"5\"><b>4</b></td>
            <td style=\"font-size:12px\" align=\"center\" width=\"10%\"><b>5</b></td>
            <td style=\"font-size:12px\" align=\"center\" width=\"5%\"><b>6</b></td>
            <td style=\"font-size:12px\" align=\"center\" width=\"10%\"><b>7</b></td>
            <td style=\"font-size:12px\" align=\"center\" width=\"10%\"><b>8</b></td>
            <td style=\"font-size:12px\" align=\"center\" width=\"10%\"><b>9</b></td>
            <td style=\"font-size:12px\" align=\"center\" width=\"10%\"><b>10</b></td>
            <td style=\"font-size:12px\" align=\"center\" width=\"10%\"><b>11</b></td>
            <td style=\"font-size:12px\" align=\"center\" width=\"10%\"><b>12</b></td>
          </tr>        
          </thead>
          ";
        //$skpd = $this->uri->segment(3); 
        $kriteria = '';
        $kriteria = $skpd;
        $where ="where (c.sp2d_batal IS NULL  OR c.sp2d_batal !=1) ";
        if ($kriteria <> '--'){                               
            $where=" where  (c.sp2d_batal IS NULL  OR c.sp2d_batal !=1) and a.kd_skpd = '$kriteria' ";            
        }       
              
        $sql = "select tgl_sp2d,no_spm,tgl_kas_bud,no_sp2d,keperluan,
        (select top 1 no_uji from trduji where no_sp2d=x.no_sp2d) no_advice,
        (select top 1 tgl_uji from trduji where no_sp2d=x.no_sp2d) tgl_advice,
        sum(up) up,sum(gu) gu,sum(tu) tu, sum(ls) ls
				from(
				SELECT b.no_spp,a.no_spm,b.tgl_sp2d,b.tgl_kas_bud,b.no_sp2d,
				b.keperluan,b.jenis_beban,b.urut,
				(case when b.jns_spp=1 then b.nilai else 0  end)up,
				(case when b.jns_spp=2 then b.nilai else 0  end)gu,
				(case when b.jns_spp=3 then b.nilai else 0  end)tu,
				(case when b.jns_spp in ('4','5','6') then b.nilai else 0  end)ls
				FROM TRHSPM a inner JOIN TRHSP2D b ON a.no_spm=b.no_spm 
				inner join TRHSPP c on a.no_spp=c.no_spp
				inner join TRDSPP d on c.no_spp=d.no_spp and a.kd_skpd=b.kd_skpd
				$where $where3
				group by b.jenis_beban,b.tgl_kas_bud,b.no_spp,a.no_spm,a.kd_skpd,a.tgl_spm,b.tgl_sp2d,b.no_sp2d,b.keperluan,b.jns_spp,b.nilai,b.urut,left(kd_rek6,3)
				)x
				group by urut,tgl_kas_bud,tgl_sp2d,no_sp2d,keperluan,no_spm
				order by urut";
                $hasil = $this->db->query($sql);
                $lcno = 0;
                $t_up= 0;
                $t_gu=0;
                $t_tu=0;
                $t_ls=0;
                foreach ($hasil->result() as $row)
                {
                    $spm= $row->no_spm;
                    $tgl_cair=$row->tgl_kas_bud;
                    $sp2d= $row->no_sp2d;
                    $tgl_sp2d=$row->tgl_sp2d;
                    $kkeperluan= $row->keperluan;
                    $n_up= $row->up;
                    $n_gu= $row->gu;
                    $n_tu= $row->tu;
                    $n_ls= $row->ls;                    
                    $t_up= $t_up+$n_up;
                    $t_gu= $t_gu+$n_gu;
                    $t_tu= $t_tu+$n_tu;
                    $t_ls=$t_ls+$n_ls;
                    $noad= $row->no_advice; 
                    $tglad= $row->tgl_advice;                    
                    $lcno = $lcno + 1;
                    
                    if(strlen($tgl_cair)>"3"){
                         $cRet .=  "<tr>
                                <td align=\"center\" style=\"font-size:12px\">$lcno</td>
                                <td align=\"left\" style=\"font-size:12px\">$spm</td>
                                <td align=\"left\" style=\"font-size:12px\">".$this->Mpublic->tanggal_indonesia($tgl_sp2d)."</td>
                                <td align=\"left\" style=\"font-size:12px\">".$this->Mpublic->tanggal_indonesia($tglad)."</td>
                                <td align=\"left\" style=\"font-size:12px\">$noad</td>
                                <td align=\"left\" style=\"font-size:12px\">".$this->Mpublic->tanggal_indonesia($tgl_cair)."</td>
                                <td align=\"left\" style=\"font-size:12px\">$sp2d</td>
                                <td align=\"left\" style=\"font-size:12px\">$kkeperluan</td>
                                <td align=\"right\" style=\"font-size:12px\">".number_format($n_up,"2",",",".")."</td>
                                <td align=\"right\" style=\"font-size:12px\">".number_format($n_gu,"2",",",".")."</td>
                                <td align=\"right\" style=\"font-size:12px\">".number_format($n_tu,"2",",",".")."</td>
                                <td align=\"right\" style=\"font-size:12px\">".number_format($n_ls,"2",",",".")."</td>
                              </tr>  "; 
                    }else{
                        $cRet .=  "<tr>
                                <td align=\"center\" bgcolor=\"#FFA07A\" style=\"font-size:12px\">$lcno</td>
                                <td align=\"left\" style=\"font-size:12px\">$spm</td>
                                <td align=\"left\" style=\"font-size:12px\">".$this->Mpublic->tanggal_indonesia($tgl_sp2d)."</td>
                                <td align=\"left\" style=\"font-size:12px\">".$this->Mpublic->tanggal_indonesia($tglad)."</td>
                                <td align=\"left\" style=\"font-size:12px\">$noad</td>
                                <td align=\"left\" style=\"font-size:12px\">".$this->Mpublic->tanggal_indonesia($tgl_cair)."</td>
                                <td align=\"left\" bgcolor=\"#FFA07A\" style=\"font-size:12px\">$sp2d</td>
                                <td align=\"left\" style=\"font-size:12px\">$kkeperluan</td>
                                <td align=\"right\" style=\"font-size:12px\">".number_format($n_up,"2",",",".")."</td>
                                <td align=\"right\" style=\"font-size:12px\">".number_format($n_gu,"2",",",".")."</td>
                                <td align=\"right\" style=\"font-size:12px\">".number_format($n_tu,"2",",",".")."</td>
                                <td align=\"right\" style=\"font-size:12px\">".number_format($n_ls,"2",",",".")."</td>
                              </tr>  ";
                    }
                     
                   
                }

                    $cRet .=  "<tr  style=\"font-size:12px;font-weight:bold;\">
                                <td align=\"right\" style=\"font-size:12px\" colspan=8><b>Jumlah</b></td>
                                <td align=\"right\" style=\"font-size:12px\"><b>".number_format($t_up,"2",",",".")."</b></td>
                                <td align=\"right\" style=\"font-size:12px\"><b>".number_format($t_gu,"2",",",".")."</b></td>
                                <td align=\"right\" style=\"font-size:12px\"><b>".number_format($t_tu,"2",",",".")."</b></td>
                                <td align=\"right\" style=\"font-size:12px\"><b>".number_format($t_ls,"2",",",".")."</b></td>
                              </tr>  "; 
                   
				
        $cRet .="</table>";
		
		$nip = str_replace('a',' ',$ttd);
		 $sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab,pangkat FROM ms_ttd where nip='$nip' AND kode='BUD'";
                 $sqlttd=$this->db->query($sqlttd1);
                 foreach ($sqlttd->result() as $rowttd)
                {
                    $nip=$rowttd->nip;                    
                    $nama= $rowttd->nm;
                    $jabatan  = $rowttd->jab;
                    $pangkat  = $rowttd->pangkat;
                }
		$tanggal_ttd = date('d-m-Y');		
		$cRet .='<TABLE style="border-collapse:collapse; font-size:12px" width="100%" border="0" cellspacing="0" cellpadding="0" align=center>
					<TR>
						<TD width="50%" align="center" ><b>&nbsp;</TD>
						<TD width="50%" align="center" ><b>&nbsp;</TD>
					</TR>
					<TR>
						<TD width="50%" align="center" ><b>&nbsp;</TD>
						<TD width="50%" align="center" ><b>&nbsp;</TD>
					</TR>
                    <TR>
						<TD width="50%" align="center" ><b>&nbsp;</TD>
						<TD align="center" >'.$daerah.', '.$this->Mpublic->tanggal_format_indonesia($tglttd).'</TD>
					</TR>
					
                    <TR>
						<TD width="50%" align="center" ><b>&nbsp;</TD>
						<TD align="center" >'.$jabatan.'</TD>
					</TR>
                    <TR>
						<TD width="50%" align="center" ><b>&nbsp;</TD>
						<TD width="50%" align="center" ><b>&nbsp;</TD>
					</TR>
					<TR>
						<TD width="50%" align="center" ><b>&nbsp;</TD>
						<TD width="50%" align="center" ><b>&nbsp;</TD>
					</TR>
					<TR>
						<TD width="50%" align="center" ><b>&nbsp;</TD>
						<TD width="50%" align="center" ><b>&nbsp;</TD>
					</TR>
                    <TR>
						<TD width="50%" align="center" ><b>&nbsp;</TD>
						<TD align="center" ><b><u>'.$nama.'</u></b><br>'.$pangkat.'</TD>
					</TR>
                    <TR>
						<TD width="50%" align="center" ><b>&nbsp;</TD>
						<TD align="center" >'.$nip.'</TD>
					</TR>
					</TABLE><br/>';
		
        $data['prev']= $cRet;    
		if ($print==1){
				$this->rka_model->_mpdf_folio('',$cRet,10,10,10,'1'); 

		} else{
		echo ("<title>REGISTER SP2D</title>");
  	    echo $cRet;
		}
		//echo("$cRet");   
    }
	

function cetak_user($cetak=0){ 
    $print = $cetak; 

    $cRet = "<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"1\" cellpadding=\"1\">";
    $cRet .="<thead> 
    <tr>
      <td style=\"font-size:12px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"30%\" ><b>user id</b></td>
        <td style=\"font-size:12px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"70%\" ><b>kd_skpd</b></td>
    </tr>         
    </thead>
    ";       
      
    $sql = "SELECT id_user FROM [user] ORDER BY id_user";
        $hasil = $this->db->query($sql);
        foreach ($hasil->result() as $row)
        {
            $id_user= $row->id_user;

              $sql2 = "select kd_skpd from ms_skpd ORDER BY kd_skpd";
            $hasil2 = $this->db->query($sql2);
            foreach ($hasil2->result() as $row2)
            {
               $kd_skpd= $row2->kd_skpd;
               $cRet .=  "<tr>
                  <td align=\"center\" style=\"font-size:12px\">$id_user</td>
                  <td align=\"left\" style=\"font-size:12px\">$kd_skpd</td>
              </tr>  "; 
            }      
        }        
      
    $cRet .="</table>";

    $data['prev']= $cRet;          
    header("Cache-Control: no-cache, no-store, must-revalidate");
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=Register_SPD.xls");
    $this->load->view('anggaran/rka/perdaIII', $data);
  }
	
	
}	