<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class realisasi_dauController extends CI_Controller {

	function __construct()
	{	 
		parent::__construct();
		$this->load->model('public_model','Mpublic');	
	}  
	
	
    function index(){ 
        $data['page_title']= 'REALISASI DAU';
        $this->template->set('title', 'REALISASI DAU');   
        $this->template->load('template','tukd/realisasi/realisasi_dau',$data) ;  		        

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

      
      function load_skpd_camat(){
        //$kd_skpd = $this->session->userdata('kdskpd'); 		
		$sql = "select 'X' as kd_skpd,'CETAK SELURUH' as nm_skpd
				union ALL
				select kd_skpd,nm_skpd from ms_skpd";
//where LEFT (kd_skpd,4)='7.01'";

        $mas = $this->db->query($sql);
        $result = array();
        $ii = 0;        
        foreach($mas->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kd_skpd' => $resulte['kd_skpd'],  
                        'nm_skpd' => $resulte['nm_skpd']
                        );
                        $ii++;
        }           
           
        echo json_encode($result);
        $mas->free_result();
    	   
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

     function cetak_realisasi_dau($nbulan='',$ctk='',$ttd='', $tgl=''){
        $nip = str_replace('123456789',' ',$ttd);
		$tanggal_ttd = $this->tukd_model->tanggal_format_indonesia($tgl);
        $sqlsc="SELECT top 1 tgl_rka,provinsi,kab_kota,daerah,thn_ang FROM sclient";
                 $sqlsclient=$this->db->query($sqlsc);
                 foreach ($sqlsclient->result() as $rowsc)
                 {
                    $kab     = $rowsc->kab_kota;
                    $prov     = $rowsc->provinsi;
                    $daerah  = $rowsc->daerah;
                    $thn     = $rowsc->thn_ang;
                 }
        $sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab,pangkat FROM ms_ttd where nip='$nip' AND kode='BUD'";
                 $sqlttd=$this->db->query($sqlttd1);
                 foreach ($sqlttd->result() as $rowttd)
                {
                    $nip=$rowttd->nip;                    
                    $nama= $rowttd->nm;
                    $jabatan  = $rowttd->jab;
                    $pangkat  = $rowttd->pangkat;
                }
       
		
			$cRet ='<TABLE style="border-collapse:collapse; font-size:14px" width="100%" border="0" cellspacing="0" cellpadding="1" align=center>
					<TR>
						<TD align="center" ><b>REALISASI DANA DAU</TD>
					</TR>
					<tr></tr>
                    <TR>
					<TD align="center" ><b>PEMERINTAH '.strtoupper($kab).'</TD>
					</TR>
					</TABLE><br/>';			

			$cRet .='<TABLE style="border-collapse:collapse; font-size:12px" width="100%" border="1" cellspacing="0" cellpadding="3" align=center>
					 <thead>
					 <TR>
						<TD bgcolor="#CCCCCC" align="center" >No.</TD>
                        <TD bgcolor="#CCCCCC" align="center" >KODE SKPD / BUD</TD>
						<TD bgcolor="#CCCCCC" align="center" >NAMA SKPD </TD>
						<TD bgcolor="#CCCCCC" align="center" >KODE SUB KEGIATAN</TD>
						<TD bgcolor="#CCCCCC" align="center" >NAMA</TD>
						<TD bgcolor="#CCCCCC" align="center" >KODE REKENING</TD>
						<TD bgcolor="#CCCCCC" align="center" >NAMA REKENING</TD>
						<TD bgcolor="#CCCCCC" align="center" >ANGGARAN</TD>
                        <TD bgcolor="#CCCCCC" align="center" >REALISASI</TD>                        
                        <TD bgcolor="#CCCCCC" align="center" >%</TD>
                    </TR>
					 <TR>
                        <TD bgcolor="#CCCCCC" align="center" >1</TD>
						<TD bgcolor="#CCCCCC" align="center" >2</TD>						
						<TD bgcolor="#CCCCCC" align="center" >3</TD>
						<TD bgcolor="#CCCCCC" align="center" >4</TD>
                        <TD bgcolor="#CCCCCC" align="center" >5</TD>
                        <TD bgcolor="#CCCCCC" align="center" >6</TD>
                        <TD bgcolor="#CCCCCC" align="center" >7</TD>
                        <TD bgcolor="#CCCCCC" align="center" >8</TD>
                        <TD bgcolor="#CCCCCC" align="center" >9</TD>                        
                        <TD bgcolor="#CCCCCC" align="center" >10</TD>
					 </TR>
					 </thead>
					 ';
		
/* 			$query = $this->db->query("select x.kd_skpd,x.nm_skpd,x.kd_subkegiatan,x.nm_subkegiatan,x.kd_rek6,x.nm_rek6,x.nilai,
									(select isnull(sum(nilai),0) from trdtransout where kd_subkegiatan =x.kd_subkegiatan and kd_rek6=x.kd_rek6) as realisasi
									 from trdrka x where LEFT(x.kd_skpd,4)='7.01'
									and x.sumber like '%Dana Alokasi Umum%'
									order by kd_subkegiatan"); */

			$query = $this->db->query("select x.kd_skpd,x.nm_skpd,x.kd_subkegiatan,x.nm_subkegiatan,x.kd_rek6,x.nm_rek6,isnull(x.nilai,0)nilai,
									isnull((select sum(nilai) from trdtransout where kd_subkegiatan =x.kd_subkegiatan and kd_rek6=x.kd_rek6),0) as realisasi
									 from trdrka x where 
									 x.sumber like '%Dana Alokasi Umum%'
									order by kd_subkegiatan");            
			$no=0;
			
			$tot_agr=0;
			$tot_real=0;
			
			   foreach ($query->result() as $row) {
				$no=$no+1;
				$kd_skpd = $row->kd_skpd; 
				$nm_skpd = $row->nm_skpd;                   
				$kd_kegiatan = $row->kd_subkegiatan;                   
				$nm_kegiatan = $row->nm_subkegiatan;                   
				$kd_rek5 = $row->kd_rek6;
				$nm_rek5 =$row->nm_rek6;
				$agx=$row->nilai;
				$realx=$row->realisasi;
                $tot_agr=$tot_agr+$agx;
                $tot_real=$tot_real+$realx;
                
                if($realx==0){
                    $persen = number_format(0,"2",",",".");
                }else{
					if($agx==0){
						 $perse =0;//$realx*100;
					}else{
						$perse = $realx/$agx*100;
					}
                    
                    $persen  = empty($realx) || $realx == 0 ? number_format(0,"2",",",".") :number_format($perse,"2",",",".");	
				   
                }
                $anggaran  = empty($agx) || $agx == 0 ? number_format(0,"2",",",".") :number_format($agx,"2",",",".");	
				$realisasi  = empty($realx) || $realx == 0 ? number_format(0,"2",",",".") :number_format($realx,"2",",",".");
                
                $tot_agrx  = empty($tot_agr) || $tot_agr == 0 ? number_format(0,"2",",",".") :number_format($tot_agr,"2",",",".");	
				$tot_realx  = empty($tot_real) || $tot_real == 0 ? number_format(0,"2",",",".") :number_format($tot_real,"2",",",".");	
				
                 
                     
				$cRet .="<tr>
						<td valign=\"top\" align=\"center\"> $no </td>
						<td valign=\"top\" align=\"left\"> $kd_skpd </td>
						<td valign=\"top\" align=\"left\"> $nm_skpd </td>
						<td valign=\"top\" align=\"left\"> $kd_kegiatan</td>
						<td valign=\"top\" align=\"left\"> $nm_kegiatan </td>
						<td valign=\"top\" align=\"left\"> $kd_rek5 </td>
						<td valign=\"top\" align=\"left\"> $nm_rek5 </td>
                        <td valign=\"top\" align=\"right\"> $anggaran </td>
						<td valign=\"top\" align=\"right\"> $realisasi </td>
                        <td valign=\"top\" align=\"right\"> $persen </td>
						</tr>"  ;
                        
				}	
				$cRet .="<tr>
						<td colspan=\"7\" valign=\"top\" align=\"right\"> TOTAL </td>
                        <td valign=\"top\" align=\"right\"> $tot_agrx </td>
						<td valign=\"top\" align=\"right\"> $tot_realx </td>
                        <td valign=\"top\" align=\"right\">  </td>
						</tr>"  ;
				   
			
				
			$cRet .='</TABLE>';
			
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
             switch ($ctk)
        {
            case 0;
			echo ("<title>realisasi_dau</title>");
				echo $cRet;
				break;
            case 1;
				$this->Mpublic->_mpdf('',$cRet,10,10,10,'P',1,'');
               break;
			case 2;        
				header("Cache-Control: no-cache, no-store, must-revalidate");
				header("Content-Type: application/vnd.ms-excel");
				header("Content-Disposition: attachment; filename=DAU_$nbulan.xls");
            
            $this->load->view('anggaran/rka/perkadaII', $data);
			break;   
		}
	}
 
 
     function cetak_monitoring_dau($nbulan='',$ctk='',$ttd='', $tgl=''){
        $nip = str_replace('123456789',' ',$ttd);
		$tanggal_ttd = $this->tukd_model->tanggal_format_indonesia($tgl);
        $sqlsc="SELECT top 1 tgl_rka,provinsi,kab_kota,daerah,thn_ang FROM sclient";
                 $sqlsclient=$this->db->query($sqlsc);
                 foreach ($sqlsclient->result() as $rowsc)
                 {
                    $kab     = $rowsc->kab_kota;
                    $prov     = $rowsc->provinsi;
                    $daerah  = $rowsc->daerah;
                    $thn     = $rowsc->thn_ang;
                 }
        $sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab,pangkat FROM ms_ttd where nip='$nip' AND kode='BUD'";
                 $sqlttd=$this->db->query($sqlttd1);
                 foreach ($sqlttd->result() as $rowttd)
                {
                    $nip=$rowttd->nip;                    
                    $nama= $rowttd->nm;
                    $jabatan  = $rowttd->jab;
                    $pangkat  = $rowttd->pangkat;
                }
       
		
			$cRet ='<TABLE style="border-collapse:collapse; font-size:14px" width="100%" border="0" cellspacing="0" cellpadding="1" align=center>
					<TR>
						<TD align="center" ><b>MONITORING DANA DAU</TD>
					</TR>
					<tr></tr>
                    <TR>
					<TD align="center" ><b>PEMERINTAH '.strtoupper($kab).'</TD>
					</TR>
					</TABLE><br/>';			

			$cRet .='<TABLE style="border-collapse:collapse; font-size:12px" width="100%" border="1" cellspacing="0" cellpadding="3" align=center>
					 <thead>
					 <TR>
						<TD bgcolor="#CCCCCC" align="center" >No.</TD>
                        <TD bgcolor="#CCCCCC" align="center" >KODE SKPD / BUD</TD>
						<TD bgcolor="#CCCCCC" align="center" >NAMA SKPD </TD>
                        <TD bgcolor="#CCCCCC" align="center" >NO SPP</TD>
						<TD bgcolor="#CCCCCC" align="center" >TANGGAL</TD>						
						<TD bgcolor="#CCCCCC" align="center" >SUB KEGIATAN</TD>
						<TD bgcolor="#CCCCCC" align="center" >REKENING</TD>
						<TD bgcolor="#CCCCCC" align="center" >NILAI SPP</TD>
                        <TD bgcolor="#CCCCCC" align="center" >NO SP2D</TD>
                        <TD bgcolor="#CCCCCC" align="center" >TANGGAL TERBIT</TD>
                        <TD bgcolor="#CCCCCC" align="center" >TANGGAL CAIR</TD>
                        <TD bgcolor="#CCCCCC" align="center" >TANGGAL SPJ</TD>                        
                    </TR>
					 <TR>
                        <TD bgcolor="#CCCCCC" align="center" >1</TD>
						<TD bgcolor="#CCCCCC" align="center" >2</TD>						
						<TD bgcolor="#CCCCCC" align="center" >3</TD>
						<TD bgcolor="#CCCCCC" align="center" >4</TD>
                        <TD bgcolor="#CCCCCC" align="center" >5</TD>
                        <TD bgcolor="#CCCCCC" align="center" >6</TD>
                        <TD bgcolor="#CCCCCC" align="center" >7</TD>
                        <TD bgcolor="#CCCCCC" align="center" >8</TD>
                        <TD bgcolor="#CCCCCC" align="center" >9</TD>
                        <TD bgcolor="#CCCCCC" align="center" >10</TD>
                        <TD bgcolor="#CCCCCC" align="center" >11</TD>
                        <TD bgcolor="#CCCCCC" align="center" >12</TD>
                        
					 </TR>
					 </thead>
					 ';



					$query = $this->db->query("select k.*,

					(select top 1 f.tgl_bukti from trhtransout f
					left join trdtransout g on g.kd_skpd=f.kd_skpd and g.no_bukti=f.no_bukti
					where f.no_sp2d=k.no_sp2d) tgl_spj
					from(
					select a.kd_skpd,a.nm_skpd,a.tgl_spp,a.no_spp,b.kd_subkegiatan,b.nm_subkegiatan,b.kd_rek6,b.nm_rek6,b.nilai nilai_spp,
					d.no_sp2d,d.tgl_sp2d,d.tgl_kas_bud as tgl_cair_sp2d
					from trhspp a 
					left join trdspp b on b.kd_skpd=a.kd_skpd and b.no_spp=a.no_spp
					left join (
					select kd_skpd,no_spp,tgl_sp2d,no_sp2d,tgl_kas_bud from trhsp2d 
					) d on d.kd_skpd=a.kd_skpd and d.no_spp=a.no_spp 
					where b.sumber like '%Dana Alokasi Umum%'
					)k 
					group by
					k.kd_skpd,k.nm_skpd,k.tgl_spp,k.no_spp,k.kd_subkegiatan,k.nm_subkegiatan,k.kd_rek6,k.nm_rek6,k.nilai_spp,
					k.no_sp2d,k.tgl_sp2d,k.tgl_cair_sp2d
					order by k.kd_skpd,k.tgl_spp");


            
			$no=0;
			$tot_spp=0;
			
               foreach ($query->result() as $row) {
				$no=$no+1;
				$kd_skpd = $row->kd_skpd; 
				$nm_skpd = $row->nm_skpd;                   
				$kd_kegiatan = $row->kd_subkegiatan;                   
				$nm_kegiatan = $row->nm_subkegiatan;                   
				$kd_rek5 = $row->kd_rek6;
				$nm_rek5 =$row->nm_rek6;
                $nospp =$row->no_spp;
				$agx=$row->nilai_spp;
                $tglspp=$row->tgl_spp;
				$tglsp2d=$row->tgl_sp2d;	
				$nosp2d=$row->no_sp2d;
                $sp2dcair=$row->tgl_cair_sp2d;
                $spj=$row->tgl_spj;
                $tot_spp=$tot_spp+$agx;
                
                $nilaispp  = empty($agx) || $agx == 0 ? number_format(0,"2",",",".") :number_format($agx,"2",",",".");
                $tot_sppx  = empty($tot_spp) || $tot_spp == 0 ? number_format(0,"2",",",".") :number_format($tot_spp,"2",",",".");	
				                      
				$cRet .="<tr>
						<td valign=\"top\" align=\"center\"> $no </td>
						<td valign=\"top\" align=\"left\"> $kd_skpd </td>
						<td valign=\"top\" align=\"left\"> $nm_skpd </td>                        
						<td valign=\"top\" align=\"left\"> $nospp </td> 
						<td valign=\"top\" align=\"center\"> ".$this->Mpublic->tanggal_indonesia($tglspp)." </td> 
						<td valign=\"top\" align=\"left\"> $nm_kegiatan </td>
						<td valign=\"top\" align=\"left\"> $nm_rek5 </td>
                        <td valign=\"top\" align=\"right\"> $nilaispp </td>                                             
						<td valign=\"top\" align=\"left\"> $nosp2d</td>
                        <td valign=\"top\" align=\"left\"> ".$this->Mpublic->tanggal_indonesia($tglsp2d)."</td>                          
						<td valign=\"top\" align=\"left\"> ".$this->Mpublic->tanggal_indonesia($sp2dcair)."</td>
                        <td valign=\"top\" align=\"left\"> ".$this->Mpublic->tanggal_indonesia($spj)."</td>
						</tr>"  ;
                        
				}	
				$cRet .="<tr>
                            <td colspan=\"7\" valign=\"top\" align=\"right\"> TOTAL </td>
						    <td valign=\"top\" align=\"right\"> $tot_sppx </td>
				            <td colspan=\"4\" valign=\"top\" align=\"center\">  </td>
                        </tr>"  ;
				   
			
				
			$cRet .='</TABLE>';
			
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
             switch ($ctk)
        {
            case 0;
			echo ("<title>monitoring_dau</title>");
				echo $cRet;
				break;
            case 1;
				$this->Mpublic->_mpdf('',$cRet,10,10,10,'P',1,'');
               break;
			case 2;        
				header("Cache-Control: no-cache, no-store, must-revalidate");
				header("Content-Type: application/vnd.ms-excel");
				header("Content-Disposition: attachment; filename=DAU_$nbulan.xls");
            
            $this->load->view('anggaran/rka/perkadaII', $data);
			break;   
		}
	}
    
      function cetak_realisasik_dau($nbulan='',$ctk='',$ttd='', $tgl=''){
        $nip = str_replace('123456789',' ',$ttd);
		$tanggal_ttd = $this->Mpublic->tanggal_format_indonesia($tgl);
        $sqlsc="SELECT top 1 tgl_rka,provinsi,kab_kota,daerah,thn_ang FROM sclient";
                 $sqlsclient=$this->db->query($sqlsc);
                 foreach ($sqlsclient->result() as $rowsc)
                 {
                    $kab     = $rowsc->kab_kota;
                    $prov     = $rowsc->provinsi;
                    $daerah  = $rowsc->daerah;
                    $thn     = $rowsc->thn_ang;
                 }
        $sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab,pangkat FROM ms_ttd where nip='$nip' AND kode='BUD'";
                 $sqlttd=$this->db->query($sqlttd1);
                 foreach ($sqlttd->result() as $rowttd)
                {
                    $nip=$rowttd->nip;                    
                    $nama= $rowttd->nm;
                    $jabatan  = $rowttd->jab;
                    $pangkat  = $rowttd->pangkat;
                }
       
		
			$cRet ='<TABLE style="border-collapse:collapse; font-size:14px" width="100%" border="0" cellspacing="0" cellpadding="1" align=center>
					<TR>
						<TD align="center" ><b>REALISASI DANA DAU</TD>
					</TR>
					<tr></tr>
                    <TR>
					<TD align="center" ><b>PEMERINTAH '.strtoupper($kab).'</TD>
					</TR>
					</TABLE><br/>';			

			$cRet .='<TABLE style="border-collapse:collapse; font-size:12px" width="100%" border="1" cellspacing="0" cellpadding="3" align=center>
					 <thead>
					 <TR>
						<TD bgcolor="#CCCCCC" align="center" >No.</TD>
                        <TD bgcolor="#CCCCCC" align="center" >KODE SKPD / BUD</TD>
						<TD bgcolor="#CCCCCC" align="center" >NAMA SKPD </TD>
						<TD bgcolor="#CCCCCC" align="center" >KODE KEGIATAN</TD>
						<TD bgcolor="#CCCCCC" align="center" >NAMA</TD>
						<TD bgcolor="#CCCCCC" align="center" >ANGGARAN</TD>
                        <TD bgcolor="#CCCCCC" align="center" >REALISASI</TD>                        
                        <TD bgcolor="#CCCCCC" align="center" >%</TD>
                    </TR>
					 <TR>
                        <TD bgcolor="#CCCCCC" align="center" >1</TD>
						<TD bgcolor="#CCCCCC" align="center" >2</TD>						
						<TD bgcolor="#CCCCCC" align="center" >3</TD>
						<TD bgcolor="#CCCCCC" align="center" >4</TD>
                        <TD bgcolor="#CCCCCC" align="center" >5</TD>
                        <TD bgcolor="#CCCCCC" align="center" >6</TD>
                        <TD bgcolor="#CCCCCC" align="center" >7</TD>
                        <TD bgcolor="#CCCCCC" align="center" >8</TD>
					 </TR>
					 </thead>
					 ';
		
			$query = $this->db->query("select x.kd_skpd,x.nm_skpd,x.kd_subkegiatan,x.nm_subkegiatan,isnull(sum(x.nilai),0) nilai,
						isnull((select sum(nilai) from trdtransout where kd_subkegiatan = x.kd_subkegiatan ),0) as realisasi
						 from trdrka x where 
						x.sumber like '%Dana Alokasi Umum%'
						GROUP BY x.kd_skpd,x.nm_skpd,x.kd_subkegiatan,x.nm_subkegiatan
						order by kd_subkegiatan");
            
			$no=0;
			$tot_ang=0;
			$tot_real=0;
			   foreach ($query->result() as $row) {
				$no=$no+1;
				$kd_skpd = $row->kd_skpd; 
				$nm_skpd = $row->nm_skpd;                   
				$kd_kegiatan = $row->kd_subkegiatan;                   
				$nm_kegiatan = $row->nm_subkegiatan;      
				$agx=$row->nilai;
				$realx=$row->realisasi;
                
                $tot_ang=$tot_ang+$agx;
                $tot_real=$tot_real+$realx;	
              
                if($realx==0){
                    $persen = number_format(0,"2",",",".");
                }else{ 
					if($agx==0){
						$perse = 0;//$realx/$agx*100;
					}else{
						$perse = $realx/$agx*100;
					}
                    
                    $persen  = empty($realx) || $realx == 0 ? number_format(0,"2",",",".") :number_format($perse,"2",",",".");	
				   
                }
                $anggaran  = empty($agx) || $agx == 0 ? number_format(0,"2",",",".") :number_format($agx,"2",",",".");	
				$realisasi  = empty($realx) || $realx == 0 ? number_format(0,"2",",",".") :number_format($realx,"2",",",".");	
				
                $tot_anggaran  = empty($tot_ang) || $tot_ang == 0 ? number_format(0,"2",",",".") :number_format($tot_ang,"2",",",".");	
				$tot_realisasi  = empty($tot_real) || $tot_real == 0 ? number_format(0,"2",",",".") :number_format($tot_real,"2",",",".");
                 
                     
				$cRet .="<tr>
						<td valign=\"top\" align=\"center\"> $no </td>
						<td valign=\"top\" align=\"left\"> $kd_skpd </td>
						<td valign=\"top\" align=\"left\"> $nm_skpd </td>
						<td valign=\"top\" align=\"left\"> $kd_kegiatan</td>
						<td valign=\"top\" align=\"left\"> $nm_kegiatan </td>
                        <td valign=\"top\" align=\"right\"> $anggaran </td>
						<td valign=\"top\" align=\"right\"> $realisasi </td>
                        <td valign=\"top\" align=\"right\"> $persen </td>
						</tr>"  ;
                        
				}	
				$cRet .="<tr>
						<td colspan=\"5\" valign=\"top\" align=\"center\"> Total </td>
						<td valign=\"top\" align=\"right\"> $tot_anggaran </td>
						<td valign=\"top\" align=\"right\"> $tot_realisasi </td>
                        <td valign=\"top\" align=\"left\">  </td>
						</tr>"  ;
				   
			
				
			$cRet .='</TABLE>';
			
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
             switch ($ctk)
        {
            case 0;
			echo ("<title>realisasi_dau</title>");
				echo $cRet;
				break;
            case 1;
				$this->Mpublic->_mpdf('',$cRet,10,10,10,'P',1,'');
               break;
			case 2;        
				header("Cache-Control: no-cache, no-store, must-revalidate");
				header("Content-Type: application/vnd.ms-excel");
				header("Content-Disposition: attachment; filename=DAU_$nbulan.xls");
            
            $this->load->view('anggaran/rka/perkadaII', $data);
			break;   
		}
	}
 
    
    function cetak_monitoring_sp2d_dau($nbulan='',$ctk='',$ttd='', $tgl=''){
        $nip = str_replace('123456789',' ',$ttd);
        $skpdx = $this->uri->segment(4);
        
        if($skpdx=='X'){
            $where="";
        }else{
            $where="and z.kd_skpd = '$skpdx'";
        }
		$tanggal_ttd = $this->Mpublic->tanggal_format_indonesia($tgl);
        $sqlsc="SELECT top 1 tgl_rka,provinsi,kab_kota,daerah,thn_ang FROM sclient";
                 $sqlsclient=$this->db->query($sqlsc);
                 foreach ($sqlsclient->result() as $rowsc)
                 {
                    $kab     = $rowsc->kab_kota;
                    $prov     = $rowsc->provinsi;
                    $daerah  = $rowsc->daerah;
                    $thn     = $rowsc->thn_ang;
                 }
        $sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab,pangkat FROM ms_ttd where nip='$nip' AND kode='BUD'";
                 $sqlttd=$this->db->query($sqlttd1);
                 foreach ($sqlttd->result() as $rowttd)
                {
                    $nip=$rowttd->nip;                    
                    $nama= $rowttd->nm;
                    $jabatan  = $rowttd->jab;
                    $pangkat  = $rowttd->pangkat;
                }
       
		
			$cRet ='<TABLE style="border-collapse:collapse; font-size:14px" width="100%" border="0" cellspacing="0" cellpadding="1" align=center>
					<TR>
						<TD align="center" ><b>MONITORING SP2D DANA DAU</TD>
					</TR>
					<tr></tr>
                    <TR>
					<TD align="center" ><b>PEMERINTAH '.strtoupper($kab).'</TD>
					</TR>
					</TABLE><br/>';			

			$cRet .='<TABLE style="border-collapse:collapse; font-size:12px" width="100%" border="1" cellspacing="0" cellpadding="3" align=center>
					 <thead>
					 <TR>
						<TD bgcolor="#CCCCCC" align="center" >No.</TD>
                        <TD bgcolor="#CCCCCC" align="center" >KODE SKPD</TD>
						<TD bgcolor="#CCCCCC" align="center" >NAMA SKPD </TD>
                        <TD bgcolor="#CCCCCC" align="center" >NO SPP</TD>
						<TD bgcolor="#CCCCCC" align="center" >TANGGAL</TD>						
						<TD bgcolor="#CCCCCC" align="center" >NILAI SPP</TD>
						<TD bgcolor="#CCCCCC" align="center" >NO SP2D</TD>
						<TD bgcolor="#CCCCCC" align="center" >TANGGAL</TD>
                        <TD bgcolor="#CCCCCC" align="center" >NILAI SP2D</TD>
                                             
                    </TR>
					 <TR>
                        <TD bgcolor="#CCCCCC" align="center" >1</TD>
						<TD bgcolor="#CCCCCC" align="center" >2</TD>						
						<TD bgcolor="#CCCCCC" align="center" >3</TD>
						<TD bgcolor="#CCCCCC" align="center" >4</TD>
                        <TD bgcolor="#CCCCCC" align="center" >5</TD>
                        <TD bgcolor="#CCCCCC" align="center" >6</TD>
                        <TD bgcolor="#CCCCCC" align="center" >7</TD>
                        <TD bgcolor="#CCCCCC" align="center" >8</TD>
                        <TD bgcolor="#CCCCCC" align="center" >9</TD>
                        
					 </TR>
					 </thead>
					 ';
		
			$query = $this->db->query("select*from(select a.kd_skpd,a.nm_skpd,a.no_spp,a.tgl_spp,a.nilai,a.urut,isnull(b.no_sp2d,'-') no_s2pd,(select top 1 sumber from trdspp where no_spp=a.no_spp)sumber,
								isnull(b.tgl_sp2d,a.tgl_spp) tgl_sp2d,isnull(b.nilai,0) as nilai_sp2d from trhspp a left join trhsp2d b
								on a.no_spp=b.no_spp and a.kd_skpd = b.kd_skpd )z
								where z.sumber like '%Dana Alokasi Umum%' $where
								order by z.kd_skpd,z.urut
								");
            
			$no=0;
			
			$totNilspp=0;
			$totNilsp2d=0;
            
			   foreach ($query->result() as $row) {
				$no=$no+1;
				$kd_skpd = $row->kd_skpd; 
				$nm_skpd = $row->nm_skpd;                   
				$no_spp = $row->no_spp;                   
				$tgl_spp = $row->tgl_spp;                   
				$nilai = $row->nilai;
				$no_s2pd =$row->no_s2pd;
                $tgl_sp2d =$row->tgl_sp2d;
				$nilai_sp2d=$row->nilai_sp2d;
                $totNilspp=$totNilspp+$nilai;
                $totNilsp2d=$totNilsp2d+$nilai_sp2d;
                                
                $nilaispp  = empty($nilai) || $nilai == 0 ? number_format(0,"2",",",".") :number_format($nilai,"2",",",".");	
                $nilaisp2d  = empty($nilai_sp2d) || $nilai_sp2d == 0 ? number_format(0,"2",",",".") :number_format($nilai_sp2d,"2",",",".");
                
                $totspp  = empty($totNilspp) || $totNilspp == 0 ? number_format(0,"2",",",".") :number_format($totNilspp,"2",",",".");	
                $totsp2d  = empty($totNilsp2d) || $totNilsp2d == 0 ? number_format(0,"2",",",".") :number_format($totNilsp2d,"2",",",".");
				                      
				$cRet .="<tr>
						<td valign=\"top\" align=\"center\"> $no </td>
						<td valign=\"top\" align=\"center\"> $kd_skpd </td>
						<td valign=\"top\" align=\"left\"> $nm_skpd </td>                        
						<td valign=\"top\" align=\"right\"> $no_spp </td> 
						<td valign=\"top\" align=\"center\"> ".$this->Mpublic->tanggal_indonesia($tgl_spp)." </td> 
						<td valign=\"top\" align=\"right\"> $nilaispp </td>
						<td valign=\"top\" align=\"left\"> $no_s2pd </td>
                        <td valign=\"top\" align=\"center\">".$this->Mpublic->tanggal_indonesia( $tgl_sp2d)." </td>                                             
						<td valign=\"top\" align=\"right\"> $nilaisp2d</td>
						</tr>"  ;
                        
				}	
				$cRet .="<tr>
						<td colspan=\"5\" valign=\"right\" align=\"right\"> Total SPP </td>
						<td valign=\"top\" align=\"right\">$totspp</td>
						<td colspan=\"2\"  valign=\"right\" align=\"right\">Total SP2D</td>                        
						<td valign=\"top\" align=\"right\">$totsp2d</td>
						</tr>"  ;
				   
			
				
			$cRet .='</TABLE>';
			
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
             switch ($ctk)
        {
            case 0;
			echo ("<title>monitoring_SP2D</title>");
				echo $cRet;
				break;
            case 1;
				$this->Mpublic->_mpdf('',$cRet,10,10,10,'P',1,'');
               break;
			case 2;        
				header("Cache-Control: no-cache, no-store, must-revalidate");
				header("Content-Type: application/vnd.ms-excel");
				header("Content-Disposition: attachment; filename=monitoring_SP2D.xls");
            
            $this->load->view('anggaran/rka/perkadaII', $data);
			break;   
		}
	}
      
  
	
}	