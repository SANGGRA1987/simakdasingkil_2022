<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class target_angkasController extends CI_Controller {

	function __construct()
	{	 
		parent::__construct();
		$this->load->model('public_model','Mpublic');	
	}  
	
	
    function index(){ 
        $data['page_title']= 'Target Anggaran Kas';
        $this->template->set('title', 'Target Anggaran Kas');   
        $this->template->load('template','tukd/transaksi/target_angkas',$data) ; 		        

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
					<TD align="center" ><b>PEMERINTAH '.strtoupper($kab).'</TD>
					</TR>					
                    <TR>
						<TD align="center" ><b>REKAPITULASI DATA TARGET (ANGGARAN KAS) DAN REALISASI TAHUN ANGGARAN '.$thn.'<br> '.strtoupper($namaskpd).'</TD>
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
				(select sum(nilai) from trdrka WHERE kd_skpd=c.kd_skpd and left(kd_rek6,2)=c.rek) as rka from (
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
				select kd_skpd, bulan, left(kd_rek6,2) rek, sum(nilai) nilai from trdskpd_ro 
				a inner join (select kd_subkegiatan from trdrka where kd_skpd='$nskpd' GROUP BY kd_subkegiatan) b on a.kd_subkegiatan=b.kd_subkegiatan
				WHERE left(kd_rek6,1)='5' and kd_skpd='$nskpd' GROUP BY left(kd_rek6,2), kd_skpd, bulan ) a GROUP BY  kd_skpd,rek ) c  ORDER BY rek
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

            //realisasi
          $query_realbtlc = $this->db->query("SELECT *, (select nm_rek2 from ms_rek2 WHERE kd_rek2=c.rek) nama,
				(select sum(nilai) from trdrka WHERE kd_skpd=c.kd_skpd and left(kd_rek6,2)=c.rek) as pagu from (
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

				select a.kd_skpd, month(b.tgl_bukti) bulan, left(kd_rek6,2) rek, sum(nilai) nilai from
				trdtransout a left join trhtransout b on b.kd_skpd=a.kd_skpd and a.no_bukti=b.no_bukti
				where a.kd_skpd='$nskpd' 
				group by a.kd_skpd,month(b.tgl_bukti),left(kd_rek6,2)


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
			$cRet .="</table>";
 
	

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
						(select sum(nilai_ubah) from trdrka WHERE kd_skpd=c.kd_skpd and left(kd_rek6,2)=c.rek) as rka from (
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
						select kd_skpd, bulan, left(kd_rek6,2) rek, sum(nilai_ubah) nilai from trdskpd_ro 
						a inner join (select kd_subkegiatan from trdrka where kd_skpd='$nskpd' GROUP BY kd_subkegiatan) b on a.kd_subkegiatan=b.kd_subkegiatan
						WHERE left(kd_rek6,1)='5' and kd_skpd='$nskpd' GROUP BY left(kd_rek6,2), kd_skpd, bulan ) a GROUP BY  kd_skpd,rek ) c  ORDER BY rek
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

            //realisasi
          $query_realbtlz = $this->db->query("SELECT *, (select nm_rek2 from ms_rek2 WHERE kd_rek2=c.rek) nama,
					(select sum(nilai) from trdrka WHERE kd_skpd=c.kd_skpd and left(kd_rek6,2)=c.rek) as pagu from (
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

					select a.kd_skpd, month(b.tgl_bukti) bulan, left(kd_rek6,2) rek, sum(nilai) nilai from
					trdtransout a left join trhtransout b on b.kd_skpd=a.kd_skpd and a.no_bukti=b.no_bukti
					where a.kd_skpd='$nskpd' 
					group by a.kd_skpd,month(b.tgl_bukti),left(kd_rek6,2)


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
			echo ("<title>DATA TARGET ANGGARAN KAS</title>");
				echo $cRet;
				break;
            case 1;
				$this->Mpublic->_mpdf('',$cRet,10,10,10,'L',1,'');
               break;
			case 2;       
				header("Cache-Control: no-cache, no-store, must-revalidate");
				header("Content-Type: application/vnd.ms-excel");
				header("Content-Disposition: attachment; filename=TARGET_ANGKAS_$nskpd.xls");
            
            $this->load->view('anggaran/rka/perkadaII', $data);
			break;   
		}
	}


		


}	