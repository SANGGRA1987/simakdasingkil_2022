<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class register_sp2dController extends CI_Controller {

	function __construct()
	{	 
		parent::__construct();
		$this->load->model('master_model','master_model');	
	}  
	
	
    function index(){ 
		$data['page_title']= 'CETAK REGISTER';
        $this->template->set('title', 'CETAK REGISTER');   		
		$this->template->load('template','tukd/register/jml_sp2d',$data) ; 			        

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


	
    function cetak_reg_sp2d_count($lcskpd='',$ctk=''){
		
        $nomor = str_replace('123456789',' ',$this->uri->segment(6));
		$tanggal_ttd = $this->tanggal_format_indonesia($this->uri->segment(7));
        $atas = $this->uri->segment(8);
        $bawah = $this->uri->segment(9);
        $kiri = $this->uri->segment(10);
        $kanan = $this->uri->segment(11);
		$jns_bp = $this->uri->segment(12);
        
		$lcskpdd = substr($lcskpd,0,7).".00";   
        if($lcskpd!='-'){     
		$skpd = $this->tukd_model->get_nama($lcskpd,'nm_skpd','ms_skpd','kd_skpd');}else{		  
		$skpd='Keseluruhan';}
        $sqlsc="SELECT distinct tgl_rka,provinsi,kab_kota,daerah,thn_ang FROM sclient";
                 $sqlsclient=$this->db->query($sqlsc);
                 foreach ($sqlsclient->result() as $rowsc)
                 {
                    $kab     = $rowsc->kab_kota;
                    $prov     = $rowsc->provinsi;
                    $daerah  = $rowsc->daerah;
                    $thn     = $rowsc->thn_ang;
                 }
		
        $sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab,pangkat FROM ms_ttd where nip = '$nomor' and kode='bud'";
                 $sqlttd=$this->db->query($sqlttd1);
                 foreach ($sqlttd->result() as $rowttd)
                {
                    $nip1=$rowttd->nip;                    
                    $nama1= $rowttd->nm;
                    $jabatan1  = $rowttd->jab;
                    $pangkat1  = $rowttd->pangkat;
                }
		
			$cRet ='<TABLE style="border-collapse:collapse; font-size:14px" width="100%" border="0" cellspacing="0" cellpadding="1" align=center>
					<TR>
						<TD align="center" ><b>'.$kab.' </TD>
					</TR>
					<tr></tr>
                    <TR>
						<TD align="center" ><b>REGISTER SP2D<br>
					</TR>
					</TABLE><br/>';

			$cRet .='<TABLE style="border-collapse:collapse; font-size:14px" width="100%" border="1" cellspacing="2" cellpadding="2" align="center">
					 <thead>
					 <TR>
                        <TD rowspan="2" width="80" bgcolor="#CCCCCC" align="center" ><b>No.</b></TD>
                        <TD colspan="2" width="90"  bgcolor="#CCCCCC" align="center" ><b>SKPD</b></TD>
						<TD colspan="2" width="150" bgcolor="#CCCCCC" align="center" ><b>SPP</b></TD>
						<TD colspan="2" width="150" bgcolor="#CCCCCC" align="center" ><b>SPM</b></TD>
						<TD colspan="2" width="150" bgcolor="#CCCCCC" align="center" ><b>SP2D</b></TD>
						<TD colspan="2" width="150" bgcolor="#CCCCCC" align="center" ><b>SPP : SPM</b></TD>
						<TD colspan="2" width="150" bgcolor="#CCCCCC" align="center" ><b>SPM : SP2D</b></TD>
					 </TR>
					 <TR>
                        <TD width="90"  bgcolor="#CCCCCC" align="center" ><b>Kode SKPD</b></TD>
						<TD width="150"  bgcolor="#CCCCCC" align="center" ><b>Nama SKPD</b></TD>	
						<TD width="150" bgcolor="#CCCCCC" align="center" ><b>Total SPP</b></TD>
						<TD width="150" bgcolor="#CCCCCC" align="center" ><b>Jumlah Nilai SPP</br>(Rp)</b></TD>
						<TD width="150" bgcolor="#CCCCCC" align="center" ><b>Total SPM</b></TD>
						<TD width="150" bgcolor="#CCCCCC" align="center" ><b>Jumlah Nilai SPM</br>(Rp)</b></TD>
						<TD width="150" bgcolor="#CCCCCC" align="center" ><b>Total SP2D</b></TD>
						<TD width="150" bgcolor="#CCCCCC" align="center" ><b>Jumlah Nilai SP2D</br>(Rp)</b></TD>
						<TD width="150" bgcolor="#CCCCCC" align="center" ><b>Total</b></TD>
						<TD width="150" bgcolor="#CCCCCC" align="center" ><b>Jumlah Nilai</br>(Rp)</b></TD>
						<TD width="150" bgcolor="#CCCCCC" align="center" ><b>Total</b></TD>
						<TD width="150" bgcolor="#CCCCCC" align="center" ><b>Jumlah Nilai</br>(Rp)</b></TD>
					 </TR>
					 </thead>
					 ';
			
                    
                    
                    $query = $this->db->query("SELECT x.kd_skpd,a.nm_skpd,sum(x.jm_spp) as spp,sum(x.nil_spp) as n_spp,sum(x.jm_spm) as spm,sum(x.nil_spm) as n_spm,sum(x.jm_sp2d) as sp2d,sum(x.nil_sp2d) as n_sp2d,
							sum(x.jm_spp_spm) as sl_spp_spm,sum(x.nil_sl_spp_spm) as n_spp_spm,sum(x.jm_spm_sp2d) as sl_spm_sp2d,sum(x.nil_sl_spm_sp2d) as n_spm_sp2d from (
							select kd_skpd,sum(jml_spp) jm_spp,sum(q.total_spp) as nil_spp,sum(q.jml_spm) as jm_spm,sum(q.total_spm) as nil_spm,sum(q.jml_sp2d) as jm_sp2d,sum(q.total_sp2d) as nil_sp2d 
							, sum(jml_spp-jml_spm) as jm_spp_spm,sum(q.total_spp)-sum(q.total_spm) nil_sl_spp_spm, sum(jml_spm-jml_sp2d) as jm_spm_sp2d 
							,sum(q.total_spm)-sum(q.total_sp2d) nil_sl_spm_sp2d from (
							select a.kd_skpd,COUNT(a.no_spp) as jml_spp,sum(b.nilai) as total_spp,'' as jml_spm,0 as total_spm,'' as jml_sp2d,0 as total_sp2d from trhspp a 
							inner join trdspp b on a.no_spp=b.no_spp and a.kd_skpd=b.kd_skpd 
							where a.kd_skpd+a.no_spp not in (select kd_skpd+no_spp from trhsp2d where sp2d_batal='1')
							and a.kd_skpd+a.no_spp in (select distinct kd_skpd+no_spp from trdspp) 
							group by a.kd_skpd
							union all
							select a.kd_skpd as kd_skpd,'' as jml_spp,0 as total_spp,COUNT(a.no_spm) as jml_spm,sum(c.nilai) as total_spm,'' as jml_sp2d,0 as total_sp2d 
							from trhspm a INNER JOIN trhspp b on a.no_spp=b.no_spp inner JOIN trdspp c on b.no_spp=c.no_spp
							where a.kd_skpd+a.no_spp+a.no_spm not in (select kd_skpd+no_spp+no_spm from trhsp2d where sp2d_batal='1') 
							and a.kd_skpd+a.no_spp in (select distinct kd_skpd+no_spp from trdspp) 
							group by a.kd_skpd
							union all
							select a.kd_skpd,'' as jml_spp,0 as total_spp,'' as jml_spm,0 as total_spm,COUNT(a.no_sp2d) as jml_sp2d,sum(d.nilai) as total_sp2d 
							from trhsp2d a inner join trhspm b on a.no_spm=b.no_spm 
							INNER JOIN trhspp c on b.no_spp=c.no_spp 
							INNER JOIN trdspp d on c.no_spp=d.no_spp
							where a.kd_skpd+a.no_spp+a.no_spm not in (select kd_skpd+no_spp+no_spm from trhsp2d where sp2d_batal='1') 
							group by a.kd_skpd
							) q
							group by q.kd_skpd 
							) x left join ms_skpd a
							on x.kd_skpd=a.kd_skpd
							group by x.kd_skpd,a.nm_skpd
							order by x.kd_skpd");  
                    
				$lcno=0;
				foreach ($query->result() as $row) {
                    $kd_skpd = $row->kd_skpd; 
                    $nm_skpd = $row->nm_skpd; 
                    $spp = $row->spp; 
                    $n_spp = $row->n_spp; 
                    $spm = $row->spm; 
                    $n_spm = $row->n_spm; 
                    $sp2d = $row->sp2d; 
                    $n_sp2d = $row->n_sp2d; 
                    $sl_spp_spm = $row->sl_spp_spm; 
                    $n_spp_spm = $row->n_spp_spm; 
                    $sl_spm_sp2d = $row->sl_spm_sp2d; 
                    $n_spm_sp2d = $row->n_spm_sp2d; 
					$lcno = $lcno + 1;
					 
							$cRet.='<TR>
                                <TD width="80" valign="top" align="center">'.$lcno.'</TD>
								<TD width="80" valign="top" align="left">'.$kd_skpd.'</TD>
								<TD width="90" valign="top"  align="left">'.$nm_skpd.'</TD>
								<TD width="90" valign="top"  align="center">'.$spp.'</TD>
								<TD width="150" valign="top"  align="right">'.number_format($n_spp,'2','.',',').'</TD>	
								<TD width="90" valign="top"  align="center">'.$spm.'</TD>
								<TD width="150" valign="top"  align="right">'.number_format($n_spm,'2','.',',').'</TD>	
								<TD width="90" valign="top"  align="center">'.$sp2d.'</TD>
								<TD width="150" valign="top"  align="right">'.number_format($n_sp2d,'2','.',',').'</TD>	
								<TD width="90" valign="top"  align="center">'.$sl_spp_spm.'</TD>
								<TD width="150" valign="top"  align="right">'.number_format($n_spp_spm,'2','.',',').'</TD>	
								<TD width="90" valign="top"  align="center">'.$sl_spm_sp2d.'</TD>
								<TD width="150" valign="top"  align="right">'.number_format($n_spm_sp2d,'2','.',',').'</TD>	
							 </TR>';	
						}
					$query = $this->db->query("SELECT '' as kd_skpd,'' as nm_skpd,sum(x.jm_spp) as spp,sum(x.nil_spp) as n_spp,sum(x.jm_spm) as spm,sum(x.nil_spm) as n_spm,sum(x.jm_sp2d) as sp2d,sum(x.nil_sp2d) as n_sp2d,
						sum(x.jm_spp_spm) as sl_spp_spm,sum(x.nil_sl_spp_spm) as n_spp_spm,sum(x.jm_spm_sp2d) as sl_spm_sp2d,sum(x.nil_sl_spm_sp2d) as n_spm_sp2d from (
						select sum(jml_spp) jm_spp,sum(q.total_spp) as nil_spp,sum(q.jml_spm) as jm_spm,sum(q.total_spm) as nil_spm,sum(q.jml_sp2d) as jm_sp2d,sum(q.total_sp2d) as nil_sp2d 
						, sum(jml_spp-jml_spm) as jm_spp_spm,sum(q.total_spp)-sum(q.total_spm) nil_sl_spp_spm, sum(jml_spm-jml_sp2d) as jm_spm_sp2d 
						,sum(q.total_spm)-sum(q.total_sp2d) nil_sl_spm_sp2d from (
						select a.kd_skpd,COUNT(a.no_spp) as jml_spp,sum(a.nilai) as total_spp,'' as jml_spm,0 as total_spm,'' as jml_sp2d,0 as total_sp2d from trhspp a 
						inner join trdspp b on a.no_spp=b.no_spp and a.kd_skpd=b.kd_skpd 
						where a.kd_skpd+a.no_spp not in (select kd_skpd+no_spp from trhsp2d where sp2d_batal='1')
						and a.kd_skpd+a.no_spp in (select distinct kd_skpd+no_spp from trdspp) 
						group by a.kd_skpd
						union all
						select a.kd_skpd as kd_skpd,'' as jml_spp,0 as total_spp,COUNT(no_spm) as jml_spm,sum(c.nilai) as total_spm,'' as jml_sp2d,0 as total_sp2d 
						from trhspm a INNER JOIN trhspp b on a.no_spp=b.no_spp inner JOIN trdspp c on b.no_spp=c.no_spp
						where a.kd_skpd+a.no_spp+a.no_spm not in (select kd_skpd+no_spp+no_spm from trhsp2d where sp2d_batal='1') 
						and a.kd_skpd+a.no_spp in (select distinct kd_skpd+no_spp from trdspp) 
						group by a.kd_skpd
						union all
						select a.kd_skpd as kd_skpd,'' as jml_spp,0 as total_spp,'' as jml_spm,0 as total_spm,COUNT(no_sp2d) as jml_sp2d,sum(d.nilai) as total_sp2d 
						from trhsp2d a inner join trhspm b on a.no_spm=b.no_spm 
						INNER JOIN trhspp c on b.no_spp=c.no_spp 
						INNER JOIN trdspp d on c.no_spp=d.no_spp
						where a.kd_skpd+a.no_spp+a.no_spm not in (select kd_skpd+no_spp+no_spm from trhsp2d where sp2d_batal='1') 
						group by a.kd_skpd
						) q
						) x");  
                    
				$lcno=0;
				foreach ($query->result() as $row) {
                    $kd_skpd = $row->kd_skpd; 
                    $nm_skpd = $row->nm_skpd; 
                    $spp = $row->spp; 
                    $n_spp = $row->n_spp; 
                    $spm = $row->spm; 
                    $n_spm = $row->n_spm; 
                    $sp2d = $row->sp2d; 
                    $n_sp2d = $row->n_sp2d; 
                    $sl_spp_spm = $row->sl_spp_spm; 
                    $n_spp_spm = $row->n_spp_spm; 
                    $sl_spm_sp2d = $row->sl_spm_sp2d; 
                    $n_spm_sp2d = $row->n_spm_sp2d; 
					$lcno = $lcno + 1;
					 
							$cRet.='<TR>
								<TD colspan="3" width="90" valign="top"  align="center"><b>JUMLAH</b></TD>
								<TD width="90" valign="top"  align="center"><b>'.$spp.'</b></TD>
								<TD width="150" valign="top"  align="right"><b>'.number_format($n_spp,'2','.',',').'</b></TD>	
								<TD width="90" valign="top"  align="center"><b>'.$spm.'</b></TD>
								<TD width="150" valign="top"  align="right"><b>'.number_format($n_spm,'2','.',',').'</b></TD>	
								<TD width="90" valign="top"  align="center"><b>'.$sp2d.'</b></TD>
								<TD width="150" valign="top"  align="right"><b>'.number_format($n_sp2d,'2','.',',').'</b></TD>	
								<TD width="90" valign="top"  align="center"><b>'.$sl_spp_spm.'</b></TD>
								<TD width="150" valign="top"  align="right"><b>'.number_format($n_spp_spm,'2','.',',').'</b></TD>	
								<TD width="90" valign="top"  align="center"><b>'.$sl_spm_sp2d.'</b></TD>
								<TD width="150" valign="top"  align="right"><b>'.number_format($n_spm_sp2d,'2','.',',').'</b></TD>	
							 </TR>';	
						}

			$cRet .='</TABLE>';
			
				$cRet .='<TABLE style="font-size:14px;" width="100%" align="center">
					<TR>
						<TD width="50%" align="center" ><b>&nbsp;</TD>
						<TD width="50%" align="center" ><b>&nbsp;</TD>
					</TR>
                    <TR>
						<TD width="50%" align="center" ></TD>
						<TD width="50%" align="center" >'.$daerah.', '.$tanggal_ttd.'</TD>
					</TR>
                    <TR>
						<TD width="50%" align="center" ></TD>
						<TD width="50%" align="center" >'.$jabatan1.'</TD>
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
						<TD width="50%" align="center" ></TD>
						<TD width="50%" align="center" ><b><u>'.$nama1.'</u></b><br>'.$pangkat1.'</TD>
					</TR>
                    <TR>
						<TD width="50%" align="center" ></TD>
						<TD width="50%" align="center" >'.$nip1.'</TD>
					</TR>
					</TABLE><br/>';

			
			$data['prev']= 'REGISTER SP2D';
             switch ($ctk)
        {
            case 0;
			echo ("<title>REGISTER SP2D</title>");
				echo $cRet;
				break;
            case 1;
				//$this->_mpdf('',$cRet,10,10,10,10,1,'');
				$this->_mpdf_margin('',$cRet,10,10,10,'L',0,'',$atas,$bawah,$kiri,$kanan);
               //$this->_mpdf_margin('',$cRet,10,10,10,'L',0,'',$atas,$bawah,$kiri,$kanan);
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