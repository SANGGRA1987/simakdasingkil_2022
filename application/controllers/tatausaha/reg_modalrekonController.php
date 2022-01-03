<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class reg_modalrekonController extends CI_Controller {

	function __construct()
	{	 
		parent::__construct();
		$this->load->model('public_model','Mpublic');	
	}  
	
	
    function index(){ 
        $data['page_title']= 'REGISTER S P 2 D';
        $this->template->set('title', 'REKAP MODAL');   
        $this->template->load('template','tukd/register/rekon_modal',$data) ; 		        

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
	
	
	  function cetak_register_persp2d_belanja_modal_baru($dcetak='',$ttd='',$skpd='',$tstatus='',$dcetak2='',$cetak=1, $pilihan='',$tglttd=''){ //Tox
			$print = $cetak;    
			$tahun  = $this->session->userdata('pcThang');
			$sqlsc="SELECT tgl_rka,provinsi,kab_kota,daerah,thn_ang FROM sclient";
                 $sqlsclient=$this->db->query($sqlsc);
                 foreach ($sqlsclient->result() as $rowsc)
                {
                    $kab     = $rowsc->kab_kota;
                    $daerah  = $rowsc->daerah;
                   
                }
			$sskpd = $this->uri->segment(6);

			$sqlsc="SELECT kd_skpd,upper(nm_skpd) nm_skpd FROM ms_skpd where kd_skpd ='$sskpd'";
                 $sqlsclient=$this->db->query($sqlsc);
                 foreach ($sqlsclient->result() as $rowsc)
                {
                    $kodexx  = $rowsc->kd_skpd;
                    $namaxx  = $rowsc->nm_skpd;
					$jedax=' - ';
					$awal='PADA SKPD ';
					 
                   
                }
        
		if($sskpd=='--'){
			$kodexx='';
			$namaxx='KESELURUHAN';
			$jedax='';
			$awal='';
			
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
                $ket4 = $sk->nm_skpd;                        
            }              
                          
		
        $cRet = "<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"1\" cellpadding=\"1\">";
        $cRet .="
        <tr>
            <td align=\"center\" style=\"font-size:14px;border: solid 1px white;border-bottom:solid 1px white;\" colspan=\"9\"><b>PEMERINTAH ".strtoupper($kab)."</b></td>            
        </tr>
        <tr>            
            <td align=\"center\" style=\"font-size:14px;border: solid 1px white;border-bottom:solid 1px white;\" colspan=\"9\"><b>REKAP BELANDA MODAL TAHUN ANGGARAN $tahun</b></td>
        </tr>
        <tr>            
            <td align=\"center\" style=\"font-size:14px;border: solid 1px white;\" colspan=\"9\"><b>$ket3</b></td>
        </tr>
        <tr>            
            <td align=\"center\" style=\"font-size:14px;border: solid 1px white;border-bottom:solid 1px black;\" colspan=\"9\"><b>$awal $kodexx $jedax $namaxx</b></td>
        </tr> <br><br></table>";
		
        $cRet .= "<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"1\" cellpadding=\"1\">";
        $cRet .="		
		<thead>
        <tr>
            <td style=\"font-size:10px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"4%\" rowspan=\"3\"><b>No.<br>Urut</b></td>
            <td style=\"font-size:10px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"90%\" colspan=\"8\"><b>SP2D</td>
        </tr>  
        <tr>
            <td style=\"font-size:10px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"5%\" rowspan=\"2\"><b>TANGGAL TERBIT</b></td>
            <td style=\"font-size:10px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"10%\" rowspan=\"2\"><b>NO. SPM</b></td>
			<td style=\"font-size:10px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"15%\" rowspan=\"2\"><b>NO. SP2D</b></td>
			<td style=\"font-size:10px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"22%\" rowspan=\"2\"><b>URAIAN</b></td>
			<td style=\"font-size:10px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"44%\" colspan=\"4\"><b>BELANJA LANGSUNG</b></td>

        </tr>  
        <tr>

            <td style=\"font-size:10px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"11%\" ><b>UP</b></td>
            <td style=\"font-size:10px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"11%\" ><b>GU</b></td>
			<td style=\"font-size:10px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"11%\" ><b>LS</b></td>
			<td style=\"font-size:10px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"11%\" ><b>JUMLAH</b></td> 			
        </tr>
         
          </thead>
          <tr>
            <td style=\"font-size:10px\" align=\"center\" ><b>1</b></td>
            <td style=\"font-size:10px\" align=\"center\" ><b>2</b></td>
            <td style=\"font-size:10px\" align=\"center\" ><b>3</b></td>
            <td style=\"font-size:10px\" align=\"center\" ><b>4</b></td>
            <td style=\"font-size:10px\" align=\"center\" ><b>5</b></td>
            <td style=\"font-size:10px\" align=\"center\" ><b>6</b></td>
            <td style=\"font-size:10px\" align=\"center\" ><b>7</b></td>
            <td style=\"font-size:10px\" align=\"center\" ><b>8</b></td>
            <td style=\"font-size:10px\" align=\"center\" ><b>9</b></td>
          </tr>";
        //$skpd = $this->uri->segment(3); 
        $kriteria = '';
        $kriteria = $skpd;
        $where ="where (c.sp2d_batal IS NULL  OR c.sp2d_batal !=1) ";
        if ($kriteria <> '--'){                               
            $where=" where  (c.sp2d_batal IS NULL  OR c.sp2d_batal !=1) and a.kd_skpd = '$kriteria' ";            
        }       
              
        $sql = "select tgl_sp2d,no_spm,no_sp2d,keperluan,sum(up) up,
				sum(gu) gu,sum(ls) ls,urut
				from(
				SELECT b.no_spp,a.no_spm,b.tgl_sp2d,b.tgl_kas_bud,b.no_sp2d,b.keperluan,b.jenis_beban,b.urut,
				(case when b.jns_spp=1 and left(d.kd_rek6,2) = '52' then b.nilai else 0  end)up,
				(case when b.jns_spp=2 and left(d.kd_rek6,2) = '52' then b.nilai else 0  end)gu,
				(case when b.jns_spp=6 and left(d.kd_rek6,2) = '52' then b.nilai else 0  end)ls
				FROM TRHSPM a inner JOIN TRHSP2D b ON a.no_spm=b.no_spm 
				inner join TRHSPP c on a.no_spp=c.no_spp
				inner join TRDSPP d on c.no_spp=d.no_spp and a.kd_skpd=b.kd_skpd
				$where $where3 and b.jns_spp in ('1','2','6')
				group by b.jenis_beban,b.tgl_kas_bud,b.no_spp,a.no_spm,a.kd_skpd,
				a.tgl_spm,b.tgl_sp2d,b.no_sp2d,b.keperluan,b.jns_spp,b.nilai,b.urut,left(kd_rek6,2)
				)x
				where up+gu+ls <> 0
				group by urut,tgl_kas_bud,tgl_sp2d,no_sp2d,keperluan,no_spm
				order by urut";
				
                $hasil = $this->db->query($sql);
                $lcno = 0;
					$t_up= 0;
                    $t_gu=0;
                    $t_ls=0;
					$t_jum=0;
					
                foreach ($hasil->result() as $row)
                {
                    $spm= $row->no_spm;
                    $sp2d= $row->no_sp2d;
                    $tgl_sp2d=$row->tgl_sp2d;
                    $kkeperluan= $row->keperluan;
                    $n_up= $row->up;
                    $n_gu= $row->gu;
                    $n_ls= $row->ls;
					$juml= $row->up+$row->gu+$row->ls;
					$t_up= $t_up+$n_up;
                    $t_gu= $t_gu+$n_gu;
                    $t_ls= $t_ls+$n_ls;
					$t_jum=$t_jum+$juml;
                                        
                    $lcno = $lcno + 1;
                    
                    $cRet .=  "<tr>
                                <td align=\"center\" style=\"font-size:12px\">$lcno</td>
                                <td align=\"left\" style=\"font-size:12px\">".$this->Mpublic->tanggal_indonesia($tgl_sp2d)."</td>
                                <td align=\"left\" style=\"font-size:12px\">$spm</td>
                                <td align=\"left\" style=\"font-size:12px\">$sp2d</td>
                                <td align=\"left\" style=\"font-size:12px\">$kkeperluan</td>
                                <td align=\"right\" style=\"font-size:12px\">".number_format($n_up,"2",",",".")."</td>
                                <td align=\"right\" style=\"font-size:12px\">".number_format($n_gu,"2",",",".")."</td>
                                <td align=\"right\" style=\"font-size:12px\">".number_format($n_ls,"2",",",".")."</td>
								<td align=\"right\" style=\"font-size:12px\">".number_format($juml,"2",",",".")."</td>
                              </tr>  "; 
                   
                }

                    $cRet .=  "<tr  style=\"font-size:12px;font-weight:bold;\">
                                <td align=\"right\" style=\"font-size:12px\" colspan=\"5\"> Jumlah</td>
                                <td align=\"right\" style=\"font-size:12px\">".number_format($t_up,"2",",",".")."</td>
                                <td align=\"right\" style=\"font-size:12px\">".number_format($t_gu,"2",",",".")."</td>
                                <td align=\"right\" style=\"font-size:12px\">".number_format($t_ls,"2",",",".")."</td>
                                <td align=\"right\" style=\"font-size:12px\">".number_format($t_jum,"2",",",".")."</td>
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
	//	$tanggal_ttd = date('d-m-Y');		
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
	

	
    function cetak_register_persp2d($dcetak='',$ttd='',$skpd='',$tstatus='',$dcetak2='',$cetak=1,$jenis='',$urut='', $pilihan=''){ //Tox
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
             switch ($tstatus){
                        case '1': //SP2D Keluar
						$where2='';
                        $ket1='BERDASARKAN SP2D TERBIT';
                            break;
                        case '2': //SP2D lunas
							$where2=" and status_bud=1 ";
                            $ket1='BERDASARKAN SP2D LUNAS';
                            break;
                        case '3': //SP2D Advice
                            $where2=" and no_sp2d in (select no_sp2d from trhuji a inner join trduji b on a.no_uji=b.no_uji) ";
                            $ket1='BERDASARKAN SP2D ADVICE';
                            break;
                        case '4': //SP2D belum Bayar
                           $where2=" and no_sp2d in (select no_sp2d from trhuji a inner join trduji b on a.no_uji=b.no_uji) and status_bud <> 1 ";
                           $ket1='BERDASARKAN SP2D BELUM CAIR';
                            break;                       
					    case '5': //Belum Advice
                           $where2=" and no_sp2d NOT IN (select no_sp2d from trhuji a inner join trduji b on a.no_uji=b.no_uji) ";
                           $ket1='BERDASARKAN SP2D BELUM ADVICE';
                            break;     
                        case '6': //SP2D batal
							$where2=" and b.sp2d_batal=1";
                            $ket1='BERDASARKAN SP2D YANG DIBATALKAN';
                            break;                      
                    }       
                    
			 switch ($jenis){
                        case '1': //BL
						$where4="AND b.jns_spp in ('6')";
                        $ket2 = "BELANJA LANGSUNG";
                            break;
                        case '2': //BTL
							$where4=" AND b.jns_spp in ('4','5')";
                            $ket2 = "BELANJA TIDAK LANGSUNG";
                            break;
                        case '3': //gaji
                            $where4=" AND b.jns_spp='4' and b.jenis_beban in ('1','2') and d.kd_rek5 in ('5110101','5110102','5110103','5110104','5110105','5110106','5110107','5110108','5110110','5110111','5110112','5110113','5110114','5110115')";
                            $ket2 = "BELANJA TIDAK LANGSUNG (GAJI)";
                            break;
                        case '4': //non gaji
                            $where4=" AND a.jns_spp in ('4','5') and a.jenis_beban in ('9','2','3') and d.kd_rek5 not in ('5110101','5110102','5110103','5110104','5110105','5110106','5110107','5110108','5110110','5110111','5110112','5110113','5110114','5110115')";
                            $ket2 = "BELANJA TIDAK LANGSUNG (NON GAJI)";
                            break;
                        case '5': //non gaji
                            $where4=" AND b.jns_spp in ('1','2','3','4','5','6')";
                            $ket2 = "KESELURUHAN";
                            break;
                       case '6': //GAJI KHUSUS
                            $where4=" AND b.jns_spp in ('4','5') AND d.kd_rek5 IN ('5110116','5110101','5110102','5110103','5110104','5110105','5110106','5110107','5110108')";
                            $ket2 = "GAJI KHUSUS";
                            break;
                        case '7': //UP
						$where4="AND b.jns_spp in ('1','2')";
                        $ket2 = "UP/GU";
                            break;
                        case '7': //TU
							$where4=" AND b.jns_spp in ('3')";
                            $ket2 = "TU";
                            break;    
                        }
					  
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
						   
			switch ($urut){
							case '1': //BL
							$order="ORDER BY cast(b.urut as int)";
								break;
							case '2': //BTL
							$order="ORDER BY cast(b.urut as int)";							
								break;
                            case '3': //BL
							$order="ORDER BY cast(b.urut as int)";
								break;
							case '4': //BL
							$order="ORDER BY cast(b.urut as int)";
								break;
							    
						  }
            
            $ket4="";
            $init = $skpd;
            if ($init <> '--'){                               
                $sk = $this->db->query("select nm_skpd from ms_skpd where kd_skpd='$init'")->row();
                $ket4 = $sk->nm_skpd;                        
            }              
                          
		
        $cRet = "<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"1\" cellpadding=\"1\">";
        $cRet .="<thead>
        <tr>
            <td align=\"center\" style=\"font-size:14px;border: solid 1px white;border-bottom:solid 1px white;\" colspan=\"10\"><b>PEMERINTAH ".strtoupper($kab)."</b></td>            
        </tr>
        <tr>            
            <td align=\"center\" style=\"font-size:14px;border: solid 1px white;border-bottom:solid 1px white;\" colspan=\"10\"><b>REGISTER SP2D TAHUN ANGGARAN $tahun</b></td>
        </tr>
        <tr>            
            <td align=\"center\" style=\"font-size:14px;border: solid 1px white;border-bottom:solid 1px black;\" colspan=\"10\"><b> $ket2 $ket3 <br/> $ket1<br/>$ket4</b></td>
        </tr>
        <tr>
            <td style=\"font-size:10px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"3%\" rowspan=\"3\"><b>No.<br>Urut</b></td>
            <td style=\"font-size:10px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"40%\" colspan=\"9\"><b>SP2D</td>
        </tr>  
        <tr>
            <td style=\"font-size:10px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"3%\" rowspan=\"2\"><b>TANGGAL</b></td>
			<td style=\"font-size:10px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"3%\" rowspan=\"2\"><b>NAMA SKPD</b></td>
            <td style=\"font-size:10px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"3%\" rowspan=\"2\"><b>No. SP2D</b></td>
            <td style=\"font-size:10px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"10%\" rowspan=\"2\"><b>URAIAN</b>
            <td style=\"font-size:10px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"5%\" rowspan=\"2\"><b>UP</b></td>
            <td style=\"font-size:10px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"5%\" rowspan=\"2\"><b>GU</b></td>
            <td style=\"font-size:10px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"5%\" rowspan=\"2\"><b>TU</b></td>
            <td style=\"font-size:10px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"10%\" colspan=\"2\"><b>LS</b></td>
        </tr>  
        <tr>
            <td style=\"font-size:10px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"5%\" ><b>GAJI/ BTL</b></td>
            <td style=\"font-size:10px\" bgcolor=\"#CCCCCC\" align=\"center\" width=\"5%\" ><b>Barang <br>& Jasa</b></td>           
        </tr>
         
          </thead>
          <tr>
            <td style=\"font-size:10px\" align=\"center\" ><b>1</b></td>
            <td style=\"font-size:10px\" align=\"center\" ><b>2</b></td>
            <td style=\"font-size:10px\" align=\"center\" ><b>3</b></td>
            <td style=\"font-size:10px\" align=\"center\" ><b>4</b></td>
            <td style=\"font-size:10px\" align=\"center\" ><b>5</b></td>
            <td style=\"font-size:10px\" align=\"center\" ><b>6</b></td>
            <td style=\"font-size:10px\" align=\"center\" ><b>7</b></td>
            <td style=\"font-size:10px\" align=\"center\" ><b>8</b></td>
            <td style=\"font-size:10px\" align=\"center\" ><b>9</b></td>
            <td style=\"font-size:10px\" align=\"center\" ><b>10</b></td>
                      </tr>";
        //$skpd = $this->uri->segment(3); 
        $kriteria = '';
        $kriteria = $skpd;
        $where ="where (b.sp2d_batal IS NULL  OR b.sp2d_batal !=1) ";
        if ($kriteria <> '--'){                               
            $where=" where  (b.sp2d_batal IS NULL OR b.sp2d_batal !=1) and left(a.kd_skpd,7) =left('$kriteria',7) ";            
        }       
   /*           
        $sql = "SELECT sum(d.nilai),a.no_spm,a.kd_skpd,a.tgl_spm,b.tgl_sp2d,b.no_sp2d,b.keperluan,
				(case when a.jns_spp=1 then b.nilai else 0  end)up,
        (case when a.jns_spp=2 then b.nilai else 0  end)gu,
				(case when a.jns_spp=3 then b.nilai else 0  end)tu,
				(case when a.jns_spp in (4,5) then b.nilai else 0  end)gaji,
				(case when a.jns_spp=6 then b.nilai else 0  end)ls
				 FROM TRHSPM a inner JOIN TRHSP2D b ON a.no_spm=b.no_spm 
				  inner join TRHSPp c on a.no_spp=c.no_spp
          inner join TRDSPP d on c.no_spp=d.no_spp and a.kd_skpd=b.kd_skpd
          $where $where2 $where4 $where3
          group by a.no_spm,a.kd_skpd,a.tgl_spm,b.tgl_sp2d,b.no_sp2d,b.keperluan,a.jns_spp,b.nilai,b.urut
				  $order";
 */                 
        $sql = "SELECT a.no_spm,a.nm_skpd,left(a.kd_skpd,7) kd_skpd,a.tgl_spm,b.tgl_sp2d,b.no_sp2d,b.keperluan,
				(case when a.jns_spp=1 then b.nilai else 0  end)up,
				(case when a.jns_spp=2 then b.nilai else 0  end)gu,
				(case when a.jns_spp=3 then b.nilai else 0  end)tu,
				(case when a.jns_spp in (4,5) then b.nilai else 0  end)gaji,
				(case when a.jns_spp=6 then b.nilai else 0  end)ls
				 FROM TRHSPM a inner JOIN TRHSP2D b ON a.no_spm=b.no_spm 
				  inner join TRHSPP c on a.no_spp=c.no_spp
          inner join TRDSPP d on c.no_spp=d.no_spp and left(a.kd_skpd,7)=left(b.kd_skpd,7)
          $where $where2 $where4 $where3
          group by a.no_spm,left(a.kd_skpd,7),a.tgl_spm,b.tgl_sp2d,b.no_sp2d,b.keperluan,a.jns_spp,b.nilai,b.urut,a.nm_skpd
          $order ";
          
                $hasil = $this->db->query($sql);
                $lcno = 0;
				 $t_up= 0;
                    $t_gu=0;
                    $t_tu=0;
                    $t_gaji=0;
                    $t_ls=0;
                foreach ($hasil->result() as $row)
                {
                    $spm= $row->no_spm;
                    $tgl_spm=$row->tgl_spm;
                    $sp2d= $row->no_sp2d;
					$nm_spk=$row->nm_skpd;
                    $tgl_sp2d=$row->tgl_sp2d;
                    $kkeperluan= $row->keperluan;
                    $n_up= $row->up;
                    $n_gu= $row->gu;
                    $n_tu= $row->tu;
                    $n_gaji= $row->gaji;
                    $n_ls= $row->ls;
                    $t_up= $t_up+$n_up;
                    $t_gu= $t_gu+$n_gu;
                    $t_tu= $t_tu+$n_tu;
                    $t_gaji=$t_gaji+$n_gaji;
                    $t_ls= $t_ls+$n_ls;
                                        
                    $lcno = $lcno + 1;
                    
                    $cRet .=  "<tr>
                                <td align=\"center\" style=\"font-size:12px\">$lcno</td>
                                <td align=\"center\" style=\"font-size:12px\">".$this->Mpublic->tanggal_indonesia($tgl_sp2d)."</td>
                                <td align=\"left\" style=\"font-size:12px\">$nm_spk</td>
                                <td align=\"center\" style=\"font-size:12px\">$sp2d</td>
                                <td align=\"left\" style=\"font-size:12px\">$kkeperluan</td>
                                <td align=\"right\" style=\"font-size:12px\">".number_format($n_up,"2",",",".")."</td>
                                <td align=\"right\" style=\"font-size:12px\">".number_format($n_gu,"2",",",".")."</td>
                                <td align=\"right\" style=\"font-size:12px\">".number_format($n_tu,"2",",",".")."</td>
                                <td align=\"right\" style=\"font-size:12px\">".number_format($n_gaji,"2",",",".")."</td>
                                <td align=\"right\" style=\"font-size:12px\">".number_format($n_ls,"2",",",".")."</td>
                              </tr>  "; 
                   
                }

                    $cRet .=  "<tr  style=\"font-size:12px;font-weight:bold;\">
                                <td align=\"center\" style=\"font-size:12px\" colspan=5> Jumlah</td>
                                <td align=\"right\" style=\"font-size:12px\">".number_format($t_up,"2",",",".")."</td>
                                <td align=\"right\" style=\"font-size:12px\">".number_format($t_gu,"2",",",".")."</td>
                                <td align=\"right\" style=\"font-size:12px\">".number_format($t_tu,"2",",",".")."</td>
                                <td align=\"right\" style=\"font-size:12px\">".number_format($t_gaji,"2",",",".")."</td>
                                <td align=\"right\" style=\"font-size:12px\">".number_format($t_ls,"2",",",".")."</td>
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
						<TD align="center" >'.$daerah.', '.$tanggal_ttd.'</TD>
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

		} else if($print=="2"){
         header("Cache-Control: no-cache, no-store, must-revalidate");
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename= Register_SP2D.xls");
            
            $this->load->view('anggaran/rka/perkadaII', $data);
         }else{
		echo ("<title>REGISTER SP2D</title>");
  	    echo $cRet;
		}
		//echo("$cRet");   
    }
 	


	
}	