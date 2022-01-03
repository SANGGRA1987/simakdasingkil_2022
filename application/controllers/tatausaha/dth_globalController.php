<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class dth_globalController extends CI_Controller {

	function __construct()
	{	 
		parent::__construct();
		$this->load->model('public_model','public_model');	
	}  
	
	
    function index(){ 
        $data['page_title']= 'CETAK DTH';
        $this->template->set('title', 'CETAK DTH');   		
		$this->template->load('template','tukd/transaksi/dth_global',$data) ; 			        

    }	


    function load_ttd_bud(){
      $kd_skpd = $this->session->userdata('kdskpd'); 
      $kdskpd = substr($kd_skpd,0,7);
      $sql = "SELECT * FROM ms_ttd WHERE kode='bud'";

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

   function skpd() {
        $lccr = $this->input->post('q');
        $sql = "SELECT kd_skpd,nm_skpd,'' jns FROM ms_skpd where upper(kd_skpd) like upper('%$lccr%') or upper(nm_skpd) like upper('%$lccr%') order by kd_skpd ";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kd_skpd' => $resulte['kd_skpd'],  
                        'nm_skpd' => $resulte['nm_skpd'],
                        'jns' => $resulte['jns']
                        );
                        $ii++;
        }
           
        echo json_encode($result);
            $query1->free_result();
    }


    function cetak_dth_global2($lcskpd='',$nbulan='',$ctk=''){
        $nomor = str_replace('123456789',' ',$this->uri->segment(6));
		$tanggal_ttd = $this->public_model->tanggal_format_indonesia($this->uri->segment(7));
        $atas = $this->uri->segment(8);
        $bawah = $this->uri->segment(9);
        $kiri = $this->uri->segment(10);
        $kanan = $this->uri->segment(11);
		$jns_bp = $this->uri->segment(12);
        
        if($lcskpd=='-'){
            $lcskpdd = "-";       
            $skpd = "-";
            $skpdx = "";
            $par_rek_pot = "where kd_rek5 in ('2110901','2110101','2110201','2110301','2110501','2110601','2110701','2110801','2130101','2130201','2130301','2130401','2130501')";				
        }else{
            $skpdx = "where kd_skpd='$lcskpd'";
            $lcskpdd = substr($lcskpd,0,7).".00";   
            $skpd = $this->public_model->get_nama($lcskpd,'nm_skpd','ms_skpd','kd_skpd');
            $par_rek_pot = "and kd_rek5 in ('2110901','2110101','2110201','2110301','2110501','2110601','2110701','2110801','2130101','2130201','2130301','2130401','2130501')";
				
        }
        		     		
        $sqlsc="SELECT top 1 tgl_rka,provinsi,kab_kota,daerah,thn_ang FROM sclient ";
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
						<TD align="center" ><b>'.$prov.' </TD>
					</TR>
					<tr></tr>
                    <TR>
						<TD align="center" ><b>DAFTAR TRANSAKSI HARIAN BELANJA DAERAH (DTH) <br>
											BULAN '.strtoupper($this->public_model->getBulan($nbulan)).' '.$thn.'</TD>
					</TR>
					</TABLE><br/>';
            
            
            if($lcskpd<>'-'){
            
			$cRet .='<TABLE style="border-collapse:collapse; font-size:14px" width="100%">
					 <TR>
						<TD align="left" width="20%" >SKPD</TD>
						<TD align="left" width="100%" >: '.$lcskpd.' '.$skpd.'</TD>
					 </TR>';
			
			$cRet .='		 </TABLE>';
            }
                
			$cRet .='<TABLE style="border-collapse:collapse; font-size:14px" width="100%" border="1" cellspacing="2" cellpadding="2" align="center">
					 <thead>
					 <TR>
                        <TD rowspan="2" width="40" bgcolor="#CCCCCC" align="center" >No.</TD>
						<TD rowspan="2" width="160" bgcolor="#CCCCCC" align="center" >SKPD</TD>
                        <TD colspan="2" width="90"  bgcolor="#CCCCCC" align="center" >SPM/SPD</TD>
						<TD colspan="2" width="150"  bgcolor="#CCCCCC" align="center" >SP2D </TD>
						<TD rowspan="2" width="150" bgcolor="#CCCCCC" align="center" >Akun Belanja</TD>
						<TD colspan="3" width="110" bgcolor="#CCCCCC" align="center" >Potongan Pajak</TD>
						<TD rowspan="2" width="150" bgcolor="#CCCCCC" align="center" >NPWP</TD>
						<TD rowspan="2" width="150" bgcolor="#CCCCCC" align="center" >Nama Rekanan</TD>
						<TD rowspan="2" width="150" bgcolor="#CCCCCC" align="center" >Ket</TD>
						<TD rowspan="2" width="50" bgcolor="#CCCCCC" align="center" >NTPN</TD>
					 </TR>
					 <TR>
                        <TD width="90"  bgcolor="#CCCCCC" align="center" >No. SPM</TD>
						<TD width="150"  bgcolor="#CCCCCC" align="center" >Nilai Belanja(Rp)</TD>						
						<TD width="150"  bgcolor="#CCCCCC" align="center" >No. SP2D </TD>
						<TD width="150" bgcolor="#CCCCCC" align="center" >Nilai Belanja (Rp)</TD>
						<TD width="110" bgcolor="#CCCCCC" align="center" >Akun Potongan</TD>
						<TD width="150" bgcolor="#CCCCCC" align="center" >Jenis</TD>
						<TD width="150" bgcolor="#CCCCCC" align="center" >jumlah (Rp)</TD>
					 </TR>
					 </thead>
					 ';
			
				$query = $this->db->query("select * from data_dth($nbulan) $skpdx 
					ORDER BY kd_skpd,no_sp2d,urut,kode_belanja,kd_rek5");  
                    
				$lcno=0;
				$tot_nilai=0;
				$tot_nilai_belanja=0;
				$tot_nilai_pot=0;
				foreach ($query->result() as $row) {
                    $no_spm = $row->no_spm; 
                    $nilai = $row->nil_spm;    
					$nilai_belanja =$row->nil_sp2d;
                    $no_sp2d = $row->no_sp2d;
                    $jns_spp = $row->jns_spp;
					if($jns_spp=='2'){
					$nilai_belanja =$nilai;	
					}
                    $kode_belanja=$row->kode_belanja;
                    $kd_rek5 = $row->kd_rek5;
                    $jenis_pajak = $row->jns_pajak;
                    $nilai_pot = $row->nil_pot;
                    $npwp = $row->npwp;
                    $nmrekan  = $row->nmrekan;
                    $ket  = $row->ket;
                    $nm_skpdd = $row->nm_skpd;
                    $no_nnt  = $row->no_nnt;
					$banyak  = ($row->banyak_sp2d)+1;
					if (($row->urut)==1){
						   $lcno = $lcno + 1;
					   } 
					
					if($kd_rek5=='2130301'){
						$kd_rek5='411211';
						$jenis_pajak='PPn';
					}
					if($kd_rek5=='2130101'){
						$kd_rek5='411121';
						$jenis_pajak='PPh 21';
					}
					if($kd_rek5=='2130201'){
						$kd_rek5='411122';
						$jenis_pajak='PPh 22';
					}
					if($kd_rek5=='2130401'){
						$kd_rek5='411124';
						$jenis_pajak='PPh 23';
					}
					if($kd_rek5=='2130501'){
						$kd_rek5='411128';
						$jenis_pajak='PPh 4';
					}
					if($kd_rek5=='2130601'){
						$kd_rek5='411128';
						$jenis_pajak='PPh 4 Ayat (2)';
					}
                    //potongan
                    if($kd_rek5=='2110101'){
						$kd_rek5='2110101';
						$jenis_pajak='Taspen';
					}
                    if($kd_rek5=='2110201'){
						$kd_rek5='2110201';
						$jenis_pajak='Askes';
					}
                    if($kd_rek5=='2110501'){
						$kd_rek5='2110501';
						$jenis_pajak='Taperum';
					}
                    if($kd_rek5=='2110701'){
						$kd_rek5='2110701';
						$jenis_pajak='IWP';
					}
                    if($kd_rek5=='2110301'){
						$kd_rek5='2110301';
						$jenis_pajak='PPh Pusat';
					}
                    
					if (($row->urut)==1){
							$cRet.='<TR>
                                <TD width="40" valign="top" align="center">'.$lcno.'</TD>
								<TD width="190" valign="top" align="left">'.$nm_skpdd.'</TD>
								<TD width="90" valign="top" >'.$no_spm.'</TD>
								<TD width="150" valign="top" align="right" >'.number_format($nilai,'2','.',',').'</TD>								
								<TD width="150" valign="top" >'.$no_sp2d.'</TD>
								<TD width="150" valign="top" align="right" >'.number_format($nilai_belanja,'2','.',',').'</TD>
								<TD width="110" align="right" ></TD>
								<TD width="150" align="left" ></TD>
								<TD width="150" align="left" ></TD>
								<TD width="150" align="left" ></TD>
								<TD width="150" align="left" ></TD>
								<TD width="150" align="left" ></TD>
								<TD width="150" align="left" ></TD>			
                                <TD width="150" align="right" ></TD>					
							 </TR>';	
						}else if (($row->urut)==2){
							$cRet.='<TR>
                                <TD width="40" align="right" style="border-top:hidden;"></TD>
								<TD width="190" align="left" style="border-top:hidden;"></TD>
                                <TD width="150" align="right" style="border-top:hidden;"></TD>
								<TD width="150" align="left" style="border-top:hidden;"></TD>
								<TD width="150" align="left" style="border-top:hidden;"></TD>
								<TD width="150" align="left" style="border-top:hidden;"></TD>
								<TD width="110" valign="top" align="left"  style="border-top:hidden;">'.$kode_belanja.'</TD>
								<TD width="150" valign="top" align="center"  style="border-top:hidden;">'.$kd_rek5.'</TD>
								<TD width="150" valign="top" align="left"  style="border-top:hidden;">'.$jenis_pajak.'</TD>
								<TD width="150" valign="top" align="right" style="border-top:hidden;" >'.number_format($nilai_pot,'2','.',',').'</TD>
								<TD width="150" valign="top" align="left"  style="border-top:hidden;">'.$npwp.'</TD>
								<TD width="150" valign="top" align="left"  style="border-top:hidden;">'.$nmrekan.'</TD>
								<TD style="border-top:hidden;" width="150" valign="top" align="left" >'.$ket.'</TD>
								<TD style="border-top:hidden;" width="50" valign="top" align="left" >'.$no_nnt.'</TD>
							 </TR>';							
						}
				$tot_nilai=$tot_nilai+$nilai;
				$tot_nilai_belanja=$tot_nilai_belanja+$nilai_belanja;
				$tot_nilai_pot=$tot_nilai_pot+$nilai_pot;
				}
			$cRet .='<TR>
                        <TD width="40"  bgcolor="#CCCCCC" align="center" ></TD>
                        <TD width="170"  bgcolor="#CCCCCC" align="center" >Total</TD>                        
                        <TD width="50" bgcolor="#CCCCCC" align="center" ></TD>
                        <TD width="90"  bgcolor="#CCCCCC" align="right" >'.number_format($tot_nilai,'2','.',',').'</TD>
                        <TD width="90"  bgcolor="#CCCCCC" align="center" ></TD>
                        <TD width="90"  bgcolor="#CCCCCC" align="right" >'.number_format($tot_nilai_belanja,'2','.',',').'</TD>
                        <TD width="50"  bgcolor="#CCCCCC" align="center" ></TD>
						<TD width="150"  bgcolor="#CCCCCC" align="center" ></TD>						
						<TD width="150"  bgcolor="#CCCCCC" align="center" ></TD>
						<TD width="150" bgcolor="#CCCCCC" align="right" >'.number_format($tot_nilai_pot,'2','.',',').'</TD>
						<TD width="150" bgcolor="#CCCCCC" align="center" ></TD>
						<TD width="150" bgcolor="#CCCCCC" align="center" ></TD>
						<TD width="150" bgcolor="#CCCCCC" align="center" ></TD>
						<TD width="50" bgcolor="#CCCCCC" align="center" ></TD>
					 </TR>';
			

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
						<TD width="50%" align="center" ><b><u></u></b><br></TD>
						<TD width="50%" align="center" ><b><u>'.$nama1.'</u></b><br>'.$pangkat1.'</TD>
					</TR>
                    <TR>
						<TD width="50%" align="center" ></TD>
						<TD width="50%" align="center" >'.$nip1.'</TD>
					</TR>
					</TABLE><br/>';
			
			$data['prev']= 'DTH';
            $judulDTH = "DTH Bulan ".strtoupper($this->public_model->getBulan($nbulan))." ".$thn;
            
             switch ($ctk)
        {
            case 0;
			echo ("<title>DTH</title>");
				echo $cRet;
				break;
            case 1;
				//$this->_mpdf('',$cRet,10,10,10,10,1,'');
				$this->_mpdf_margin('',$cRet,10,10,10,'L',0,'',$atas,$bawah,$kiri,$kanan);
               //$this->_mpdf_margin('',$cRet,10,10,10,'L',0,'',$atas,$bawah,$kiri,$kanan);
			   break;
            case 2;
                 $datax['prev']= $cRet;
			     header("Cache-Control: no-cache, no-store, must-revalidate");
                 header("Content-Type: application/vnd.ms-excel");
                 header("Content-Disposition: attachment; filename= $judulDTH.xls");
            
                 $this->load->view('anggaran/rka/perkadaII', $datax);
				break;   
		}
	}
	
   function cetak_dth_global_skpd($lcskpd='',$nbulan='',$ctk=''){
        $nomor = str_replace('123456789',' ',$this->uri->segment(7));
		$tanggal_ttd = $this->public_model->tanggal_format_indonesia($this->uri->segment(8));
        $atas = $this->uri->segment(9);
        $bawah = $this->uri->segment(10);
        $kiri = $this->uri->segment(11);
        $kanan = $this->uri->segment(12);
		$jns_bp = $this->uri->segment(13);
        		
        if($lcskpd!='-'){     
			$skpd = $this->public_model->get_nama($lcskpd,'nm_skpd','ms_skpd','kd_skpd');
		}else{		  
			$skpd='Keseluruhan';
		}
        $sqlsc="SELECT top 1 tgl_rka,provinsi,kab_kota,daerah,thn_ang FROM sclient ";
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
            $cRet = '';
            $cRet.="<TABLE style=\"border-collapse:collapse;font-size:12px;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"1\" cellpadding=\"4\">
                    <TR> 
                        <td style=\"vertical-align:top; border-top: none; border-bottom: none; border-left: none; border-right: none;\"  width=\"15%\" rowspan=\"3\" align=\"center\"><img src=\"./image/simakda.png\" height=\"70\"/></td>
                        <td width=\"85%\" align='left' style=\"vertical-align:top; border-top: none; border-bottom: none; border-left: none; border-right: none;\"><b>PEMERINTAH $kab</b></td>
                        </TR>
                    <TR> 
                        <td align='left' style=\"vertical-align:top;border-top: none;border-bottom: none;border-left: none;border-right: none;\"><b>".sTRtoupper($skpd)."</b></td> 
                    </TR>
                    <TR> 
                        <td align='left' style=\"vertical-align:top;border-top: none;border-bottom: none;border-left: none;border-right: none;\"><b>TAHUN ANGGARAN $thn</b></td> 
                    </TR>  
                    <TR> 
                        <td align='left' style=\"vertical-align:top;border-top: none;border-bottom: none;border-left: none;border-right: none;\">&nbsp;</td> 
                    </TR>                   
                ";
            $cRet.="</TABLE>";
		
			$cRet .='<TABLE style="border-collapse:collapse; font-size:14px" width="100%" border="0" cellspacing="0" cellpadding="1" align=center>
                    <TR>
						<TD align="center" ><b>DAFTAR TRANSAKSI HARIAN BELANJA DAERAH (DTH)<b></TD>
					</TR>
					<TR>
						<TD align="center" ><b>Periode : '.strtoupper($this->public_model->getBulan($nbulan)).' '.$thn.'</b></TD>
					</TR>
					</TABLE><br/>';

			/*$cRet .='<TABLE style="border-collapse:collapse; font-size:12px" width="100%">
					 <TR>
						<TD align="left" width="10%" >SKPD</TD>
						<TD align="left" width="90%" >: '.$lcskpd.' '.$skpd.'</TD>
					 </TR>';
			
			$cRet .='		 </TABLE>';*/

			$cRet .='<TABLE style="border-collapse:collapse; font-size:12px" width="100%" border="1" cellspacing="2" cellpadding="2" align="center">
					 <thead>
					 <TR>
                        <TD rowspan="2" width="80" bgcolor="#CCCCCC" align="center" ><b>No.</b></TD>
						<TD rowspan="2" width="80" bgcolor="#CCCCCC" align="center" ><b>SKPD</b></TD>
                        <TD colspan="2" width="90"  bgcolor="#CCCCCC" align="center" ><b>SPM/SPD</b></TD>
						<TD colspan="2" width="150"  bgcolor="#CCCCCC" align="center" ><b>SP2D </b></TD>
						<TD rowspan="2" width="150" bgcolor="#CCCCCC" align="center" ><b>Akun Belanja</b></TD>
						<TD colspan="3" width="150" bgcolor="#CCCCCC" align="center" ><b>Potongan Pajak</b></TD>
						<TD rowspan="2" width="150" bgcolor="#CCCCCC" align="center" ><b>NPWP</b></TD>
						<TD rowspan="2" width="150" bgcolor="#CCCCCC" align="center" ><b>Nama Rekanan</b></TD>
						<TD rowspan="2" width="150" bgcolor="#CCCCCC" align="center" ><b>Ket</b></TD>
						<TD rowspan="2" width="50" bgcolor="#CCCCCC" align="center" ><b>NTPN</b></TD>
					 </TR>
					 <TR>
                        <TD width="90"  bgcolor="#CCCCCC" align="center" ><b>No. SPM</b></TD>
						<TD width="150"  bgcolor="#CCCCCC" align="center" ><b>Nilai Belanja(Rp)</b></TD>						
						<TD width="150"  bgcolor="#CCCCCC" align="center" ><b>No. SP2D </b></TD>
						<TD width="150" bgcolor="#CCCCCC" align="center" ><b>Nilai Belanja (Rp)</b></TD>
						<TD width="150" bgcolor="#CCCCCC" align="center" ><b>Akun Potongan</b></TD>
						<TD width="150" bgcolor="#CCCCCC" align="center" ><b>Jenis</b></TD>
						<TD width="150" bgcolor="#CCCCCC" align="center" ><b>jumlah (Rp)</b></TD>
					 </TR>
					 </thead>
					 ';
			
				//$par_rek_pot = "('2110101','2110201','2110301','2110302','2110303','2110304','2110305','2110401','2110501','2110601','2110701','2110702','2110801','2110802')";
				//$par_rek_pot = "('2110901','2110101','2110201','2110301','2110501','2110601','2110701','2110801','2130101','2130201','2130301','2130401','2130501')";
				
				
				$par_rek_pot = "'2101'";
        
                if($lcskpd=='-'){                     
	                    $query = $this->db->query("SELECT z.urut,z.kd_skpd,
							(select nm_skpd from ms_skpd where  kd_skpd=z.kd_skpd) as nm_skpd,
							z.no_spm,sum(z.nilai_sp2d) as nilai_spm,z.no_sp2d,sum(z.nilai_sp2d) as nilai_sp2d,sum(z.banyak_sp2d) as banyak_spm,sum(z.banyak_sp2d) as banyak_sp2d,sum(z.nil_pot) as nil_pot,z.no_bukti,z.kode_belanja,z.kd_rek6,z.jns_pajak,z.npwp,z.nmrekan,z.ket,z.jns_spp,z.no_nnt FROM(
							SELECT  '1' as urut,d.kd_skpd, '' nm_skpd, d.no_spm, sum(0) nilai_spm, d.no_sp2d, SUM(a.nilai) as nilai_sp2d,0 banyak_spm,count(DISTINCT no_sp2d) as banyak_sp2d, 0 nil_pot,
							'' no_bukti, '' kode_belanja,'' kd_rek6,'' jns_pajak,'' npwp,'' nmrekan,'' ket,'' jns_spp,'' no_nnt 
							FROM trdspp a inner join  
							trhsp2d d on a.kd_skpd=d.kd_skpd and a.no_spp=d.no_spp
							WHERE MONTH(d.tgl_sp2d)='$nbulan' and (d.sp2d_batal is null or d.sp2d_batal<>'1')
							GROUP BY d.kd_skpd,d.no_spm,d.no_sp2d
							union all
							SELECT '2' as urut,b.kd_skpd,'' nm_skpd,'' no_spm,0 nilai_spm, b.no_sp2d, 0 nilai_sp2d, 0 banyak_spm, 0 banyak_sp2d, SUM(a.nilai) nil_pot, 
							b.no_bukti, a.kd_rek_trans as kode_belanja,RTRIM(a.kd_rek6) as kd_rek6,a.nm_rek6 as  jns_pajak,b.npwp,'' as nmrekan,'No Set: '+a.no_bukti as ket,'' jns_spp,a.ntpn as no_nnt
							FROM trdstrpot a INNER JOIN trhstrpot b ON a.no_bukti=b.no_bukti AND a.kd_skpd=b.kd_skpd   
							LEFT JOIN trhsp2d c on c.no_sp2d=b.no_sp2d and c.kd_skpd=b.kd_skpd 
							WHERE MONTH(c.tgl_sp2d)='$nbulan' and (c.sp2d_batal is null or c.sp2d_batal<>'1') AND left(RTRIM(a.kd_rek6),4) = $par_rek_pot          
							GROUP BY b.kd_skpd,b.no_sp2d,b.no_bukti,b.kd_subkegiatan,a.kd_rek_trans,a.kd_rek6,a.nm_rek6,b.npwp,a.no_bukti, a.ntpn
							)z
							GROUP BY z.urut,z.kd_skpd,z.no_spm,z.no_sp2d,z.no_bukti,z.kode_belanja,z.kd_rek6,z.jns_pajak,z.npwp,z.nmrekan,z.ket,z.jns_spp,z.no_nnt
							ORDER BY z.kd_skpd,z.no_sp2d,z.urut,z.kode_belanja,z.kd_rek6");
                }else{
	            	$query = $this->db->query("SELECT z.urut,z.kd_skpd,
						(select nm_skpd from ms_skpd where kd_skpd=z.kd_skpd) as nm_skpd,
						z.no_spm,sum(z.nilai_sp2d) as nilai_spm,z.no_sp2d,sum(z.nilai_sp2d) as nilai_sp2d,sum(z.banyak_sp2d) as banyak_spm,sum(z.banyak_sp2d) as banyak_sp2d,sum(z.nil_pot) as nil_pot,z.no_bukti,z.kode_belanja,z.kd_rek6,z.jns_pajak,z.npwp,z.nmrekan,z.ket,z.jns_spp,z.no_nnt FROM(
						SELECT  '1' as urut,d.kd_skpd, '' nm_skpd, d.no_spm, sum(0) nilai_spm, d.no_sp2d, SUM(a.nilai) as nilai_sp2d,0 banyak_spm,count(DISTINCT no_sp2d) as banyak_sp2d, 0 nil_pot,
						'' no_bukti, '' kode_belanja,'' kd_rek6,'' jns_pajak,'' npwp,'' nmrekan,'' ket,'' jns_spp,'' no_nnt 
						FROM trdspp a 
						INNER JOIN trhsp2d d on a.no_spp = d.no_spp AND a.kd_skpd=d.kd_skpd
						WHERE MONTH(d.tgl_sp2d)='$nbulan' and d.kd_skpd='$lcskpd' and (d.sp2d_batal is null or d.sp2d_batal<>'1')
						GROUP BY d.kd_skpd,d.no_spm,d.no_sp2d
						union all
						SELECT '2' as urut,b.kd_skpd,'' nm_skpd,'' no_spm,0 nilai_spm, b.no_sp2d, 0 nilai_sp2d, 0 banyak_spm, 0 banyak_sp2d, SUM(a.nilai) nil_pot, 
						b.no_bukti, a.kd_rek_trans as kode_belanja,RTRIM(a.kd_rek6) as kd_rek6,a.nm_rek6 as  jns_pajak,b.npwp,'' as nmrekan,'No Set: '+a.no_bukti as ket,'' jns_spp,a.ntpn as no_nnt
						FROM trdstrpot a INNER JOIN trhstrpot b ON a.no_bukti=b.no_bukti AND a.kd_skpd=b.kd_skpd   
						LEFT JOIN trhsp2d c on c.no_sp2d=b.no_sp2d and c.kd_skpd=b.kd_skpd 
						WHERE MONTH(b.tgl_bukti)='$nbulan' and a.kd_skpd='$lcskpd' and (c.sp2d_batal is null or c.sp2d_batal<>'1') AND left(RTRIM(a.kd_rek6),4) = $par_rek_pot          
						GROUP BY b.kd_skpd,b.no_sp2d,b.no_bukti,b.kd_subkegiatan,a.kd_rek_trans,a.kd_rek6,a.nm_rek6,b.npwp,a.no_bukti,a.ntpn
						)z
						GROUP BY z.urut,z.kd_skpd,z.no_spm,z.no_sp2d,z.no_bukti,z.kode_belanja,z.kd_rek6,z.jns_pajak,z.npwp,z.nmrekan,z.ket,z.jns_spp,z.no_nnt
						ORDER BY z.kd_skpd,z.no_sp2d,z.urut,z.kode_belanja,z.kd_rek6");  
            }
                                    
				$lcno=0;
				$tot_nilai=0;
				$tot_nilai_belanja=0;
				$tot_nilai_pot=0;
				foreach ($query->result() as $row) {
                    $no_spm = $row->no_spm; 
                    $nilai = $row->nilai_spm;    
					$nilai_belanja =$row->nilai_sp2d;
                    $no_sp2d = $row->no_sp2d;
                    $jns_spp = $row->jns_spp;
					if($jns_spp=='2'){
					$nilai_belanja =$nilai;	
					}
                    $kode_belanja=$row->kode_belanja;
                    $kd_rek5 = $row->kd_rek6;
                    $jenis_pajak = $row->jns_pajak;
                    $nilai_pot = $row->nil_pot;
                    $npwp = $row->npwp;
                    $nmrekan  = $row->nmrekan;
                    $ket  = $row->ket;
                    $kd_skpdd = $row->kd_skpd;
                    $no_nnt  = $row->no_nnt;
					$banyak  = ($row->banyak_sp2d)+1;
					if (($row->urut)==1){
						   $lcno = $lcno + 1;
					   } 
					
					if (($row->urut)==1){
							$cRet.='<TR>
                                <TD width="80" valign="top" align="center">'.$lcno.'</TD>
								<TD width="80" valign="top" align="center">'.$kd_skpdd.'</TD>
								<TD width="90" valign="top" >'.$no_spm.'</TD>
								<TD width="150" valign="top" align="right" >'.number_format($nilai,'2','.',',').'</TD>								
								<TD width="150" valign="top" >'.$no_sp2d.'</TD>
								<TD width="150" valign="top" align="right" >'.number_format($nilai_belanja,'2','.',',').'</TD>
								<TD width="150" align="right" ></TD>
								<TD width="150" align="left" ></TD>
								<TD width="150" align="left" ></TD>
								<TD width="150" align="left" ></TD>
								<TD width="150" align="left" ></TD>
								<TD width="150" align="left" ></TD>
								<TD width="150" align="left" ></TD>			
                                <TD width="150" align="right" ></TD>					
							 </TR>';	
						} else{
							$cRet.='<TR>
                                <TD width="150" align="right" style="border-top:hidden;"></TD>
								<TD width="150" align="left" style="border-top:hidden;"></TD>
                                <TD width="150" align="right" style="border-top:hidden;"></TD>
								<TD width="150" align="left" style="border-top:hidden;"></TD>
								<TD width="150" align="left" style="border-top:hidden;"></TD>
								<TD width="150" align="left" style="border-top:hidden;"></TD>
								<TD width="150" valign="top" align="left"  style="border-top:hidden;">'.$kode_belanja.'</TD>
								<TD width="150" valign="top" align="center"  style="border-top:hidden;">'.$kd_rek5.'</TD>
								<TD width="150" valign="top" align="left"  style="border-top:hidden;">'.$jenis_pajak.'</TD>
								<TD width="150" valign="top" align="right" style="border-top:hidden;" >'.number_format($nilai_pot,'2','.',',').'</TD>
								<TD width="150" valign="top" align="left"  style="border-top:hidden;">'.$npwp.'</TD>
								<TD width="150" valign="top" align="left"  style="border-top:hidden;">'.$nmrekan.'</TD>
								<TD style="border-top:hidden;" width="150" valign="top" align="left" >'.$ket.'</TD>
								<TD style="border-top:hidden;" width="50" valign="top" align="left" >'.$no_nnt.'</TD>
							 </TR>';							
						}
				$tot_nilai=$tot_nilai+$nilai;
				$tot_nilai_belanja=$tot_nilai_belanja+$nilai_belanja;
				$tot_nilai_pot=$tot_nilai_pot+$nilai_pot;
				}
                
			$cRet .='<TR>
                        <TD width="90"  bgcolor="#CCCCCC" align="center" ><b>Total</b></TD>
                        <TD width="90"  bgcolor="#CCCCCC" align="center" ><b></b></TD>                        
                        <TD width="50" bgcolor="#CCCCCC" align="center" ><b></b></TD>
                        <TD width="90"  bgcolor="#CCCCCC" align="right" ><b>'.number_format($tot_nilai_belanja,'2','.',',').'</b></TD>
                        <TD width="90"  bgcolor="#CCCCCC" align="center" ><b></b></TD>
                        <TD width="90"  bgcolor="#CCCCCC" align="right" ><b>'.number_format($tot_nilai_belanja,'2','.',',').'</b></TD>
                        <TD width="90"  bgcolor="#CCCCCC" align="center" ><b></b></TD>
						<TD width="150"  bgcolor="#CCCCCC" align="center" ><b></b></TD>						
						<TD width="150"  bgcolor="#CCCCCC" align="center" ><b></b></TD>
						<TD width="150" bgcolor="#CCCCCC" align="right" ><b>'.number_format($tot_nilai_pot,'2','.',',').'</b></TD>
						<TD width="150" bgcolor="#CCCCCC" align="center" ><b></b></TD>
						<TD width="150" bgcolor="#CCCCCC" align="center" ><b></b></TD>
						<TD width="150" bgcolor="#CCCCCC" align="center" ><b></b></TD>
						<TD width="50" bgcolor="#CCCCCC" align="center" ><b></b></TD>
					 </TR>';
			

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

			
			//$data['prev']= 'DTH';
			
			  $data['prev']= $cRet;
			  $data['sikap'] = 'preview';
			  $judul='DTH'.$lcskpd.' '.$skpd;
			
             switch ($ctk){
				case 0;
				echo ("<title>DTH (SKPD)</title>");
				echo $cRet;
				break;
				case 1;
				//$this->_mpdf('',$cRet,10,10,10,10,1,'');
				$this->public_model->_mpdf_margin('',$cRet,10,10,10,'L',0,'',$atas,$bawah,$kiri,$kanan);
				//$this->_mpdf_margin('',$cRet,10,10,10,'L',0,'',$atas,$bawah,$kiri,$kanan);
				break;
				case 2;     
				header("Cache-Control: no-cache, no-store, must-revalidate");
				header("Content-Type: application/vnd.ms-excel");
				header("Content-Disposition: attachment; filename=$judul.xls");

				$this->load->view('anggaran/rka/perkadaII', $data);
				break;    
			}
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

    
    function cetak_targetangkas($nskpd='',$ctk='',$ttd='', $tgl=''){
        $nip = str_replace('123456789',' ',$ttd);
		$tanggal_ttd = $this->tukd_model->tanggal_format_indonesia($tgl);
        $sqlsc="SELECT tgl_rka,provinsi,kab_kota,daerah,thn_ang FROM sclient";
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
                    $namax= $rowttd->nm;
                    $jabatan  = $rowttd->jab;
                    $pangkat  = $rowttd->pangkat;
                }       
        
        $sql_nmskpd1="SELECT nm_skpd FROM ms_skpd where kd_skpd='$nskpd'";
                 $sql_nmskpd2=$this->db->query($sql_nmskpd1);
                 foreach ($sql_nmskpd2->result() as $rowttd)
                {
                    $namaskpd= $rowttd->nm_skpd;                    
                }                                    
            		
			$cRet ='<TABLE style="font-size:14px" width="100%" border="0" align="center">
					<TR>
					<TD align="center" ><b>PEMERINTAH KOTA '.strtoupper($daerah).'</TD>
					</TR>					
                    <TR>
						<TD align="center" ><b>REKAPITULASI DATA TARGET (ANGGARAN KAS) DAN REALISASI TAHUN ANGGARAN '.$thn.'<br> '.$namaskpd.'</TD>
					</TR>
                    <TR>
					<TD align="left" >&nbsp;</TD>
					</TR>					                    
                    </TABLE>';			


      $cRet .='<TABLE style="border-collapse:collapse; font-size:12px" width="100%" border="1" cellspacing="0" cellpadding="3" align=center>
           <thead>
           <TR>
            <TD bgcolor="#CCCCCC" align="center" >Uraian</TD>                        
            <TD colspan="13" bgcolor="#CCCCCC" align="center" >Anggaran Kas Murni</TD>
           </TR>
                     </thead>';
                     
            $cRet .='          
       
           ';

$query_targetbtl = $this->db->query("SELECT *, (select nm_rek2 from ms_rek2 WHERE kd_rek2=c.rek) nama,
(select sum(nilai) from trdrka WHERE left(kd_skpd,7)=left(c.kd_skpd,7) and left(kd_rek5,2)=c.rek) as rka from (
SELECT kd_skpd,rek,
sum(case when a.bulan='1' then a.nilai else 0 end) as target_jan,
sum(case when a.bulan<='2' then a.nilai else 0 end) as target_feb,
sum(case when a.bulan<='3' then a.nilai else 0 end )as target_mar,
sum(case when a.bulan<='4' then a.nilai else 0 end) as target_apr,
sum(case when a.bulan<='5' then a.nilai else 0 end) as target_mei,
sum(case when a.bulan<='6' then a.nilai else 0 end) as target_jun,
sum(case when a.bulan<='7' then a.nilai else 0 end) as target_jul,
sum(case when a.bulan<='8' then a.nilai else 0 end) as target_ags,
sum(case when a.bulan<='9' then a.nilai else 0 end) as target_sept,
sum(case when a.bulan<='10' then a.nilai else 0 end) as target_okt,
sum(case when a.bulan<='11' then a.nilai else 0 end) as target_nov,
sum(case when a.bulan<='12' then a.nilai else 0 end) as target_des from (
select left(kd_skpd,7) kd_skpd, bulan, left(kd_rek5,2) rek, sum(nilai) nilai from trdskpd_ro 
a inner join (select kd_kegiatan from trdrka GROUP BY kd_kegiatan) b on a.kd_kegiatan=b.kd_kegiatan
WHERE left(kd_rek5,1)='5' and left(kd_skpd,7)=left('$nskpd',7) GROUP BY left(kd_rek5,2), left(kd_skpd,7), bulan ) a GROUP BY  kd_skpd,rek ) c  ORDER BY rek
");

      $no=0;
         foreach ($query_targetbtl->result() as $row) {
        $no=$no+1;
        $kd_skpd = $row->kd_skpd; 
        $rka = $row->rka;
        $rek = $row->rek;
        $nama = $row->nama;

                $target_jan = $row->target_jan;
                $target_feb = $row->target_feb;
                $target_mar = $row->target_mar;
                $target_apr = $row->target_apr;
                $target_mei = $row->target_mei;
                $target_jun = $row->target_jun;
                $target_jul = $row->target_jul;
                $target_ags = $row->target_ags;
                $target_sept = $row->target_sept;
                $target_okt = $row->target_okt;
                $target_nov = $row->target_nov;
                $target_des = $row->target_des;
                       
        $cRet .="
                            <TR>
                        <TD rowspan='2' align='center' >$nama</TD>                        
                        <TD rowspan='2' align='center' >Pagu (Rp.)</TD>
                        <TD colspan='12' align='center' >B U L A N</TD>                        
           </TR>  
           <TR>
                        <TD align='center' >Jan</TD>
                        <TD align='center' >Feb</TD>            
                        <TD align='center' >Mar</TD>
                        <TD align='center' >Apr</TD>                        
                        <TD align='center' >Mei</TD>                        
                        <TD align='center' >Jun</TD>
                        <TD align='center' >Jul</TD>
                        <TD align='center' >Agst</TD>
                        <TD align='center' >Sept</TD>
                        <TD align='center' >Okt</TD>
                        <TD align='center' >Nov</TD>
                        <TD align='center' >Des</TD>                        
           </TR>  

            <tr>
            <td valign=\"top\" align=\"center\"> Target </td>                        
            <td valign=\"top\" align=\"center\"> ".number_format($rka,"2",",",".")." </td>       
            <td valign=\"top\" align=\"right\"> ".number_format($target_jan,"2",",",".")." &nbsp;</td>
            <td valign=\"top\" align=\"right\"> ".number_format($target_feb,"2",",",".")." &nbsp;</td>
                        <td valign=\"top\" align=\"right\"> ".number_format($target_mar,"2",",",".")." &nbsp;</td>
                        <td valign=\"top\" align=\"right\"> ".number_format($target_apr,"2",",",".")." &nbsp;</td>
                        <td valign=\"top\" align=\"right\"> ".number_format($target_mei,"2",",",".")." &nbsp;</td>
                        <td valign=\"top\" align=\"right\"> ".number_format($target_jun,"2",",",".")." &nbsp;</td>
                        <td valign=\"top\" align=\"right\"> ".number_format($target_jul,"2",",",".")." &nbsp;</td>
                        <td valign=\"top\" align=\"right\"> ".number_format($target_ags,"2",",",".")." &nbsp;</td>
                        <td valign=\"top\" align=\"right\"> ".number_format($target_sept,"2",",",".")." &nbsp;</td>
                        <td valign=\"top\" align=\"right\"> ".number_format($target_okt,"2",",",".")." &nbsp;</td>
                        <td valign=\"top\" align=\"right\"> ".number_format($target_nov,"2",",",".")." &nbsp;</td>
                        <td valign=\"top\" align=\"right\"> ".number_format($target_des,"2",",",".")." &nbsp;</td>
            </tr>"  ;

            /*realisasi*/
          $query_realbtlc = $this->db->query("SELECT *, (select nm_rek2 from ms_rek2 WHERE kd_rek2=c.rek) nama,
(select sum(nilai) from trdrka WHERE left(kd_skpd,7)=left(c.kd_skpd,7) and left(kd_rek5,2)=c.rek) as pagu from (
SELECT kd_skpd,rek,
sum(case when a.bulan='1' then a.nilai else 0 end) as target_jan,
sum(case when a.bulan<='2' then a.nilai else 0 end) as target_feb,
sum(case when a.bulan<='3' then a.nilai else 0 end )as target_mar,
sum(case when a.bulan<='4' then a.nilai else 0 end) as target_apr,
sum(case when a.bulan<='5' then a.nilai else 0 end) as target_mei,
sum(case when a.bulan<='6' then a.nilai else 0 end) as target_jun,
sum(case when a.bulan<='7' then a.nilai else 0 end) as target_jul,
sum(case when a.bulan<='8' then a.nilai else 0 end) as target_ags,
sum(case when a.bulan<='9' then a.nilai else 0 end) as target_sept,
sum(case when a.bulan<='10' then a.nilai else 0 end) as target_okt,
sum(case when a.bulan<='11' then a.nilai else 0 end) as target_nov,
sum(case when a.bulan<='12' then a.nilai else 0 end) as target_des from (

select left(a.kd_skpd,7) kd_skpd, month(b.tgl_bukti) bulan, left(kd_rek5,2) rek, sum(nilai) nilai from
trdtransout a left join trhtransout b on b.kd_skpd=a.kd_skpd and a.no_bukti=b.no_bukti
where left(a.kd_skpd,7)=left('$nskpd',7) 
group by left(a.kd_skpd,7),month(b.tgl_bukti),left(kd_rek5,2)


) a WHERE rek='$rek' GROUP BY  kd_skpd,rek ) c ");

                $no=0;
                   foreach ($query_realbtlc->result() as $rowx) {
                  $no=$no+1;
                  $kd_skpd = $rowx->kd_skpd; 
                  $xtarget_jan = $rowx->target_jan;
                $xtarget_feb = $rowx->target_feb;
                $xtarget_mar = $rowx->target_mar;
                $xtarget_apr = $rowx->target_apr;
                $xtarget_mei = $rowx->target_mei;
                $xtarget_jun = $rowx->target_jun;
                $xtarget_jul = $rowx->target_jul;
                $xtarget_ags = $rowx->target_ags;
                $xtarget_sept = $rowx->target_sept;
                $xtarget_okt = $rowx->target_okt;
                $xtarget_nov = $rowx->target_nov;
                $xtarget_des = $rowx->target_des;



            $cRet .="<tr>
            <td valign=\"top\" align=\"center\"> Realisasi </td>                        
            <td valign=\"top\" align=\"center\"> </td>       
            <td valign=\"top\" align=\"right\"> ".number_format($xtarget_jan,"2",",",".")." &nbsp;</td>
            <td valign=\"top\" align=\"right\"> ".number_format($xtarget_feb,"2",",",".")." &nbsp;</td>
                        <td valign=\"top\" align=\"right\"> ".number_format($xtarget_mar,"2",",",".")." &nbsp;</td>
                        <td valign=\"top\" align=\"right\"> ".number_format($xtarget_apr,"2",",",".")." &nbsp;</td>
                        <td valign=\"top\" align=\"right\"> ".number_format($xtarget_mei,"2",",",".")." &nbsp;</td>
                        <td valign=\"top\" align=\"right\"> ".number_format($xtarget_jun,"2",",",".")." &nbsp;</td>
                        <td valign=\"top\" align=\"right\"> ".number_format($xtarget_jul,"2",",",".")." &nbsp;</td>
                        <td valign=\"top\" align=\"right\"> ".number_format($xtarget_ags,"2",",",".")." &nbsp;</td>
                        <td valign=\"top\" align=\"right\"> ".number_format($xtarget_sept,"2",",",".")." &nbsp;</td>
                        <td valign=\"top\" align=\"right\"> ".number_format($xtarget_okt,"2",",",".")." &nbsp;</td>
                        <td valign=\"top\" align=\"right\"> ".number_format($xtarget_nov,"2",",",".")." &nbsp;</td>
                        <td valign=\"top\" align=\"right\"> ".number_format($xtarget_des,"2",",",".")." &nbsp;</td>
            </tr>"  ;    

            }                    
        } 

                
              $cRet .="<tr>
            <td valign=\"top\" style=\"border-left:none;border-right:none;\" align=\"center\">&nbsp;</td>                        
            <td valign=\"top\" style=\"border-left:none;border-right:none;\" align=\"center\">&nbsp;</td>       
            <td valign=\"top\" style=\"border-left:none;border-right:none;\" align=\"right\">&nbsp;</td>
            <td valign=\"top\" style=\"border-left:none;border-right:none;\" align=\"right\">&nbsp;</td>
                        <td valign=\"top\" style=\"border-left:none;border-right:none;\" align=\"right\">&nbsp;</td>
                        <td valign=\"top\" style=\"border-left:none;border-right:none;\" align=\"right\">&nbsp;</td>
                        <td valign=\"top\" style=\"border-left:none;border-right:none;\" align=\"right\">&nbsp;</td>
                        <td valign=\"top\" style=\"border-left:none;border-right:none;\" align=\"right\">&nbsp;</td>
                        <td valign=\"top\" style=\"border-left:none;border-right:none;\" align=\"right\">&nbsp;</td>
                        <td valign=\"top\" style=\"border-left:none;border-right:none;\" align=\"right\">&nbsp;</td>
                        <td valign=\"top\" style=\"border-left:none;border-right:none;\" align=\"right\">&nbsp;</td>
                        <td valign=\"top\" style=\"border-left:none;border-right:none;\" align=\"right\">&nbsp;</td>
                        <td valign=\"top\" style=\"border-left:none;border-right:none;\" align=\"right\">&nbsp;</td>
                        <td valign=\"top\" style=\"border-left:none;border-right:none;\" align=\"right\">&nbsp;</td>
            </tr>"  ;                        
        

      $cRet .='<TABLE style="border-collapse:collapse; font-size:12px" width="100%" border="1" cellspacing="0" cellpadding="3" align=center>
           <thead>
           <TR>
            <TD bgcolor="#CCCCCC" align="center" >Uraian</TD>                        
            <TD colspan="13" bgcolor="#CCCCCC" align="center" >Anggaran Kas Perubahan</TD>
           </TR>
                     </thead>';
                     
            $cRet .='          
       
           ';

$query_targetbtlx = $this->db->query("SELECT *, (select nm_rek2 from ms_rek2 WHERE kd_rek2=c.rek) nama,
(select sum(nilai_ubah) from trdrka WHERE left(kd_skpd,7)=left(c.kd_skpd,7) and left(kd_rek5,2)=c.rek) as rka from (
SELECT kd_skpd,rek,
sum(case when a.bulan='1' then a.nilai else 0 end) as target_jan,
sum(case when a.bulan<='2' then a.nilai else 0 end) as target_feb,
sum(case when a.bulan<='3' then a.nilai else 0 end )as target_mar,
sum(case when a.bulan<='4' then a.nilai else 0 end) as target_apr,
sum(case when a.bulan<='5' then a.nilai else 0 end) as target_mei,
sum(case when a.bulan<='6' then a.nilai else 0 end) as target_jun,
sum(case when a.bulan<='7' then a.nilai else 0 end) as target_jul,
sum(case when a.bulan<='8' then a.nilai else 0 end) as target_ags,
sum(case when a.bulan<='9' then a.nilai else 0 end) as target_sept,
sum(case when a.bulan<='10' then a.nilai else 0 end) as target_okt,
sum(case when a.bulan<='11' then a.nilai else 0 end) as target_nov,
sum(case when a.bulan<='12' then a.nilai else 0 end) as target_des from (
select left(kd_skpd,7) kd_skpd, bulan, left(kd_rek5,2) rek, sum(nilai_ubah) nilai from trdskpd_ro 
a inner join (select kd_kegiatan from trdrka GROUP BY kd_kegiatan) b on a.kd_kegiatan=b.kd_kegiatan
WHERE left(kd_rek5,1)='5' and left(kd_skpd,7)=left('$nskpd',7) GROUP BY left(kd_rek5,2), left(kd_skpd,7), bulan ) a GROUP BY  kd_skpd,rek ) c  ORDER BY rek
");

      $no=0;
         foreach ($query_targetbtlx->result() as $row) {
        $no=$no+1;
        $kd_skpd = $row->kd_skpd; 
        $rka = $row->rka;
        $rek = $row->rek;
        $nama = $row->nama;

                $target_jan = $row->target_jan;
                $target_feb = $row->target_feb;
                $target_mar = $row->target_mar;
                $target_apr = $row->target_apr;
                $target_mei = $row->target_mei;
                $target_jun = $row->target_jun;
                $target_jul = $row->target_jul;
                $target_ags = $row->target_ags;
                $target_sept = $row->target_sept;
                $target_okt = $row->target_okt;
                $target_nov = $row->target_nov;
                $target_des = $row->target_des;
                       
        $cRet .="
                            <TR>
                        <TD rowspan='2' align='center' >$nama</TD>                        
                        <TD rowspan='2' align='center' >Pagu (Rp.)</TD>
                        <TD colspan='12' align='center' >B U L A N</TD>                        
           </TR>  
           <TR>
                        <TD align='center' >Jan</TD>
                        <TD align='center' >Feb</TD>            
                        <TD align='center' >Mar</TD>
                        <TD align='center' >Apr</TD>                        
                        <TD align='center' >Mei</TD>                        
                        <TD align='center' >Jun</TD>
                        <TD align='center' >Jul</TD>
                        <TD align='center' >Agst</TD>
                        <TD align='center' >Sept</TD>
                        <TD align='center' >Okt</TD>
                        <TD align='center' >Nov</TD>
                        <TD align='center' >Des</TD>                        
           </TR>  

            <tr>
            <td valign=\"top\" align=\"center\"> Target </td>                        
            <td valign=\"top\" align=\"center\"> ".number_format($rka,"2",",",".")." </td>       
            <td valign=\"top\" align=\"right\"> ".number_format($target_jan,"2",",",".")." &nbsp;</td>
            <td valign=\"top\" align=\"right\"> ".number_format($target_feb,"2",",",".")." &nbsp;</td>
                        <td valign=\"top\" align=\"right\"> ".number_format($target_mar,"2",",",".")." &nbsp;</td>
                        <td valign=\"top\" align=\"right\"> ".number_format($target_apr,"2",",",".")." &nbsp;</td>
                        <td valign=\"top\" align=\"right\"> ".number_format($target_mei,"2",",",".")." &nbsp;</td>
                        <td valign=\"top\" align=\"right\"> ".number_format($target_jun,"2",",",".")." &nbsp;</td>
                        <td valign=\"top\" align=\"right\"> ".number_format($target_jul,"2",",",".")." &nbsp;</td>
                        <td valign=\"top\" align=\"right\"> ".number_format($target_ags,"2",",",".")." &nbsp;</td>
                        <td valign=\"top\" align=\"right\"> ".number_format($target_sept,"2",",",".")." &nbsp;</td>
                        <td valign=\"top\" align=\"right\"> ".number_format($target_okt,"2",",",".")." &nbsp;</td>
                        <td valign=\"top\" align=\"right\"> ".number_format($target_nov,"2",",",".")." &nbsp;</td>
                        <td valign=\"top\" align=\"right\"> ".number_format($target_des,"2",",",".")." &nbsp;</td>
            </tr>"  ;

            /*realisasi*/
          $query_realbtlz = $this->db->query("SELECT *, (select nm_rek2 from ms_rek2 WHERE kd_rek2=c.rek) nama,
(select sum(nilai) from trdrka WHERE left(kd_skpd,7)=left(c.kd_skpd,7) and left(kd_rek5,2)=c.rek) as pagu from (
SELECT kd_skpd,rek,
sum(case when a.bulan='1' then a.nilai else 0 end) as target_jan,
sum(case when a.bulan<='2' then a.nilai else 0 end) as target_feb,
sum(case when a.bulan<='3' then a.nilai else 0 end )as target_mar,
sum(case when a.bulan<='4' then a.nilai else 0 end) as target_apr,
sum(case when a.bulan<='5' then a.nilai else 0 end) as target_mei,
sum(case when a.bulan<='6' then a.nilai else 0 end) as target_jun,
sum(case when a.bulan<='7' then a.nilai else 0 end) as target_jul,
sum(case when a.bulan<='8' then a.nilai else 0 end) as target_ags,
sum(case when a.bulan<='9' then a.nilai else 0 end) as target_sept,
sum(case when a.bulan<='10' then a.nilai else 0 end) as target_okt,
sum(case when a.bulan<='11' then a.nilai else 0 end) as target_nov,
sum(case when a.bulan<='12' then a.nilai else 0 end) as target_des from (

select left(a.kd_skpd,7) kd_skpd, month(b.tgl_bukti) bulan, left(kd_rek5,2) rek, sum(nilai) nilai from
trdtransout a left join trhtransout b on b.kd_skpd=a.kd_skpd and a.no_bukti=b.no_bukti
where left(a.kd_skpd,7)=left('$nskpd',7) 
group by left(a.kd_skpd,7),month(b.tgl_bukti),left(kd_rek5,2)


) a WHERE rek='$rek' GROUP BY  kd_skpd,rek ) c ");

                $no=0;
                   foreach ($query_realbtlz->result() as $rowx) {
                  $no=$no+1;
                  $kd_skpd = $rowx->kd_skpd; 
                  $xtarget_jan = $rowx->target_jan;
                $xtarget_feb = $rowx->target_feb;
                $xtarget_mar = $rowx->target_mar;
                $xtarget_apr = $rowx->target_apr;
                $xtarget_mei = $rowx->target_mei;
                $xtarget_jun = $rowx->target_jun;
                $xtarget_jul = $rowx->target_jul;
                $xtarget_ags = $rowx->target_ags;
                $xtarget_sept = $rowx->target_sept;
                $xtarget_okt = $rowx->target_okt;
                $xtarget_nov = $rowx->target_nov;
                $xtarget_des = $rowx->target_des;



            $cRet .="<tr>
            <td valign=\"top\" align=\"center\"> Realisasi </td>                        
            <td valign=\"top\" align=\"center\"> </td>       
            <td valign=\"top\" align=\"right\"> ".number_format($xtarget_jan,"2",",",".")." &nbsp;</td>
            <td valign=\"top\" align=\"right\"> ".number_format($xtarget_feb,"2",",",".")." &nbsp;</td>
                        <td valign=\"top\" align=\"right\"> ".number_format($xtarget_mar,"2",",",".")." &nbsp;</td>
                        <td valign=\"top\" align=\"right\"> ".number_format($xtarget_apr,"2",",",".")." &nbsp;</td>
                        <td valign=\"top\" align=\"right\"> ".number_format($xtarget_mei,"2",",",".")." &nbsp;</td>
                        <td valign=\"top\" align=\"right\"> ".number_format($xtarget_jun,"2",",",".")." &nbsp;</td>
                        <td valign=\"top\" align=\"right\"> ".number_format($xtarget_jul,"2",",",".")." &nbsp;</td>
                        <td valign=\"top\" align=\"right\"> ".number_format($xtarget_ags,"2",",",".")." &nbsp;</td>
                        <td valign=\"top\" align=\"right\"> ".number_format($xtarget_sept,"2",",",".")." &nbsp;</td>
                        <td valign=\"top\" align=\"right\"> ".number_format($xtarget_okt,"2",",",".")." &nbsp;</td>
                        <td valign=\"top\" align=\"right\"> ".number_format($xtarget_nov,"2",",",".")." &nbsp;</td>
                        <td valign=\"top\" align=\"right\"> ".number_format($xtarget_des,"2",",",".")." &nbsp;</td>
            </tr>"  ;    

            }                    
        } 
                

				
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
						<TD align="center" ><b><u>'.$namax.'</u></b><br>'.$pangkat.'</TD>
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
			echo ("<title>DATA TERGET ANGGARAN KAS</title>");
				echo $cRet;
				break;
            case 1;
				$this->_mpdf('',$cRet,10,10,10,'L',1,'');
               break;
			case 2;        
				header("Cache-Control: no-cache, no-store, must-revalidate");
				header("Content-Type: application/vnd.ms-excel");
				header("Content-Disposition: attachment; filename=DTH_$nbulan.xls");
            
            $this->load->view('anggaran/rka/perkadaII', $data);
			break;   
		}
	}


}	