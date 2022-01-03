<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller master data kegiatan
 */

class Tukd_bos extends CI_Controller {

	function __contruct()
	{	
		parent::__construct();
  
	}
	
	function sp2b()
    {
        $data['page_title']= 'SP2B';
        $this->template->set('title', 'SP2B');   
        $this->template->load('template','tukd/bos/sp2b',$data); 
    }
    
    function register_sp2b(){
        $data['page_title']= 'SP2B';
        $this->template->set('title', 'SP2B');   
        $this->template->load('template','tukd/bos/register_sp2b',$data) ; 
    }
    
    function load_sp3b_bos(){
		 $result = array();
        $row = array();
      	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	    $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	    $offset = ($page-1)*$rows;
       $kriteria = '';
        $kriteria = $this->input->post('cari');
		$and= '';
		$where= '';
		//$id  = $this->session->userdata('pcUser');        
        //$where =" AND kd_skpd IN (SELECT kd_skpd FROM user_bud WHERE user_id='$id') ";
        if ($kriteria <> ''){                               
            $and=" AND (upper(no_sp3b) like upper('%$kriteria%') or upper(number_sp2b) like '%$kriteria%' or upper(no_sp2b) like '%$kriteria%' or upper(kd_skpd) like '%$kriteria%')";            
			$where=" where (upper(no_sp3b) like upper('%$kriteria%') or upper(number_sp2b) like '%$kriteria%' or upper(no_sp2b) like '%$kriteria%' or upper(kd_skpd) like '%$kriteria%')";            
        }
        
        $sql = "SELECT count(*) as tot from trhsp3b_bos $where";
        $query1 = $this->db->query($sql);
        $total = $query1->row();
		
        
        $sql = " SELECT TOP $rows *,(SELECT a.nm_skpd FROM ms_skpd_bos a where a.kd_skpd=b.kd_skpd) as nm_skpd FROM trhsp3b_bos b WHERE  
		no_sp3b NOT IN (SELECT TOP $offset no_sp3b FROM trhsp3b_bos $where order by tgl_sp3b, no_sp3b) $and
		order by tgl_sp3b, no_sp3b";
        $query1 = $this->db->query($sql);  
        $result = array(); 
        $ii = 0;
        foreach($query1->result_array() as $resulte) { 
        $row[] = array(
			'id' => $ii,
			'kd_skpd'    => $resulte['kd_skpd'],      
			'nm_skpd'    => $resulte['nm_skpd'],                          
			'ket'   => $resulte['keterangan'],
			'no_lpj'   => $resulte['no_lpj'],
			'no_sp3b'   => $resulte['no_sp3b'],
			'tgl_sp3b'      => $resulte['tgl_sp3b'],
			'no_sp2b'   => $resulte['no_sp2b'],
			'tgl_sp2b'      => $resulte['tgl_sp2b'],
			'status'      => $resulte['status'],												
			'status_bud'      => $resulte['status_bud'],
            'skpd'    => $resulte['skpd'],												
			);
			$ii++;
        }
		 $result["total"] = $total->tot;
        $result["rows"] = $row; 
        echo json_encode($result);
       $query1->free_result();
		
	}
    
    function no_urut_sp2b(){
    $query1 = $this->db->query("select COUNT(number_sp2b) as nomor from trhsp3b_bos where number_sp2b not in ('0')");
	    $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
			$urut = $resulte['nomor'];
            $result = array(
                        'id' => $ii,        
                        'no_urut' => $urut+1
                        );
                        $ii++;
        }
		
        echo json_encode($result);
    	$query1->free_result();   
    }
    
    function load_sum_lpj($lpj='',$pusk='') {

    $lpj = $this->input->post('lpj');//"900/45.A/UPTD Pusk.Kec.Ptk Tenggara/I/2017";
    $pusk = $this->input->post('kode');//"1.02.01.45";
    $result = array();
    $cek_skpd_jkn = $this->db->query("select b.kd_skpd,b.bulan from trhsp3b_bos a left join trhlpj_bos b on b.kd_skpd = a.kd_skpd and a.no_lpj = b.no_lpj
        where a.no_lpj='$lpj' and a.kd_skpd='$pusk'")->row();    
    $hasil_skpd_jkn = $cek_skpd_jkn->kd_skpd;
    $hasil_bulan_jkn = $cek_skpd_jkn->bulan;
    
    if($hasil_bulan_jkn==6){
            $intbulan1 = '1';
            $intbulan2 = '6';
            $intbulan3 = "('6')";
        }else if($hasil_bulan_jkn==12){
            $intbulan1 = '7';
            $intbulan2 = '12';
            $intbulan3 = "('6','12')";
        }
      
        if($hasil_bulan_jkn==6){
            
            $n = $this->db->query("select ISNULL(sld_awal,0)+ISNULL(sld_awal_tunai,0)+ISNULL(sld_awal_pajak,0) as sld_awal from ms_skpd_bos where kd_skpd='$hasil_skpd_jkn'")->row();            
            $nilai_saldo = $n->sld_awal;
        }else{
              $sql1=$this->db->query("  SELECT ISNULL(SUM(terima-keluar),0) as nilai FROM (
                    select ISNULL(sld_awal, 0) + ISNULL(sld_awal_tunai, 0) + ISNULL(selisih_sld_tunai, 0) + ISNULL(selisih_sld_bank, 0) as terima, 0 keluar from ms_skpd_bos where kd_skpd='$hasil_skpd_jkn'
                    UNION ALL
                    SELECT nilai terima, 0 keluar from TRHINLAIN_BOS WHERE kd_skpd='$hasil_skpd_jkn' AND MONTH(TGL_BUKTI)<'$intbulan1' AND JNS_BEBAN='11'
                    UNION ALL
                    SELECT 0 terima, nilai keluar from TRHOUTLAIN_BOS WHERE kd_skpd='$hasil_skpd_jkn' AND MONTH(TGL_BUKTI)<'$intbulan1' AND JNS_BEBAN IN ('12','14')
                    UNION ALL
                    SELECT 0 terima, b.nilai keluar FROM trhtransout_bos a INNER JOIN trdtransout_bos b 
                    ON a.kd_skpd = b.kd_skpd and a.no_bukti=b.no_bukti 
                    WHERE a.kd_skpd='$hasil_skpd_jkn' AND MONTH(a.tgl_kas)<'$intbulan1'  
                    )a 
                    ")->row();    
            $nilai_saldo = $sql1->nilai;          
                     
        }       
                
        $sql = " SELECT sum(a.terima) terima,sum(a.keluar) keluar FROM (
                SELECT SUM(z.terima-z.keluar) terima, 0 keluar from(
                SELECT nilai terima, 0 keluar from TRHINLAIN_BOS WHERE kd_skpd='$hasil_skpd_jkn' AND MONTH(TGL_BUKTI)>='$intbulan1' AND MONTH(TGL_BUKTI)<='$intbulan2' AND JNS_BEBAN='11' 
                UNION ALL
                SELECT 0 terima, nilai keluar from TRHOUTLAIN_BOS WHERE kd_skpd='$hasil_skpd_jkn' AND MONTH(TGL_BUKTI)>='$intbulan1' AND MONTH(TGL_BUKTI)<='$intbulan2' AND JNS_BEBAN IN ('12','14')
                )z
                UNION ALL
                SELECT 0 terima, sum(b.nilai) keluar FROM trhtransout_bos a INNER JOIN trdtransout_bos b 
                ON a.kd_skpd = b.kd_skpd and a.no_bukti=b.no_bukti 
                WHERE a.kd_skpd='$hasil_skpd_jkn' AND MONTH(a.tgl_kas)>='$intbulan1' and MONTH(a.tgl_kas)<='$intbulan2'                                    
                ) a";              
                
		$hasil = $this->db->query($sql);
		$lcno=0;
		$sisa=$nilai_saldo;        
		$jumlah_terima=0;
		$jumlah_keluar=0;
        $row = array();
       foreach ($hasil->result_array() as $rows){
		 $terima = $rows['terima'];
		 $keluar = $rows['keluar'];
         
		 $sisa=$sisa+$terima-$keluar;         		                
        }   
            $row[] = array(                         						
                        'idx' => '01',
                        'csaldo_awal' => $nilai_saldo,
                        'cterima' => $terima,
                        'ckeluar' => $keluar,
                        'cjumlah' => $sisa 						                         
                        );                                
           
           echo json_encode($row);     
    }
    
    function select_data1_lpj_ag($lpj='',$pusk='') {

    $lpj = $this->input->post('lpj');
    $pusk = $this->input->post('kdskpd');
    $result = array();
    $cek_skpd_jkn = $this->db->query("select b.kd_skpd,b.bulan from trhsp3b_bos a left join trhlpj_bos b on b.kd_skpd = a.kd_skpd and a.no_lpj = b.no_lpj
        where a.no_lpj='$lpj' and a.kd_skpd='$pusk'")->row();    
    $hasil_skpd_jkn = $cek_skpd_jkn->kd_skpd;
    $hasil_bulan_jkn = $cek_skpd_jkn->bulan;
    
    if($hasil_bulan_jkn==6){
            $intbulan1 = '1';
            $intbulan2 = '6';
            $intbulan3 = "('6')";
        }else if($hasil_bulan_jkn==12){
            $intbulan1 = '7';
            $intbulan2 = '12';
            $intbulan3 = "('6','9')";
        }
            
        if($hasil_bulan_jkn==6){
            
            $n = $this->db->query("select ISNULL(sld_awal,0)+ISNULL(sld_awal_tunai,0)+ISNULL(sld_awal_pajak,0) as sld_awal from ms_skpd_bos where kd_skpd='$hasil_skpd_jkn'")->row();            
            $nilai_saldo = $n->sld_awal;
        }else{
              $sql1=$this->db->query("  SELECT ISNULL(SUM(terima-keluar),0) as nilai FROM (
                    select ISNULL(sld_awal, 0) + ISNULL(sld_awal_tunai, 0) + ISNULL(selisih_sld_tunai, 0) + ISNULL(selisih_sld_bank, 0) as terima, 0 keluar from ms_skpd_bos where kd_skpd='$hasil_skpd_jkn'
                    UNION ALL
                    SELECT nilai terima, 0 keluar from TRHINLAIN_BOS WHERE kd_skpd='$hasil_skpd_jkn' AND MONTH(TGL_BUKTI)<'$intbulan1' AND JNS_BEBAN='11'
                    UNION ALL
                    SELECT 0 terima, nilai keluar from TRHOUTLAIN_BOS WHERE kd_skpd='$hasil_skpd_jkn' AND MONTH(TGL_BUKTI)<'$intbulan1' AND JNS_BEBAN IN ('12','14')
                    UNION ALL
                    SELECT 0 terima, b.nilai keluar FROM trhtransout_bos a INNER JOIN trdtransout_bos b 
                    ON a.kd_skpd = b.kd_skpd and a.no_bukti=b.no_bukti 
                    WHERE a.kd_skpd='$hasil_skpd_jkn' AND MONTH(a.tgl_kas)<'$intbulan1'  
                    )a 
                    ")->row();    
            $nilai_saldo = $sql1->nilai;          
                     
        }          
                
        $sql = "  SELECT sum(a.terima) terima,sum(a.keluar) keluar FROM (
                SELECT SUM(z.terima-z.keluar) terima, 0 keluar from(
                SELECT nilai terima, 0 keluar from TRHINLAIN_BOS WHERE kd_skpd='$hasil_skpd_jkn' AND MONTH(TGL_BUKTI)>='$intbulan1' AND MONTH(TGL_BUKTI)<='$intbulan2' AND JNS_BEBAN='11' 
                UNION ALL
                SELECT 0 terima, nilai keluar from TRHOUTLAIN_BOS WHERE kd_skpd='$hasil_skpd_jkn' AND MONTH(TGL_BUKTI)>='$intbulan1' AND MONTH(TGL_BUKTI)<='$intbulan2' AND JNS_BEBAN IN ('12','14')
                )z
                UNION ALL
                SELECT 0 terima, sum(b.nilai) keluar FROM trhtransout_bos a INNER JOIN trdtransout_bos b 
                ON a.kd_skpd = b.kd_skpd and a.no_bukti=b.no_bukti 
                WHERE a.kd_skpd='$hasil_skpd_jkn' AND MONTH(a.tgl_kas)>='$intbulan1' and MONTH(a.tgl_kas)<='$intbulan2'                                    
                ) a ";        
                
                
		$hasil = $this->db->query($sql);
		$lcno=0;
		$sisa=$nilai_saldo;        
		$jumlah_terima=0;
		$jumlah_keluar=0;
       foreach ($hasil->result_array() as $rows){
		 $terima = $rows['terima'];
		 $keluar = $rows['keluar'];
		 
		 $sisa=$sisa+$terima-$keluar;         		                
        }   
            $row[] = array(                         						
                        'idx' => '01',
                        'uraian'  => 'Saldo Awal',   
                        'nilai'   => number_format($nilai_saldo,2),                              						                         
                        ); 
            $row[] = array(                         						
                        'idx' => '02',
                        'uraian'  => 'Kas Lainnya',   
                        'nilai'   => number_format($terima,2),                              						                         
                        );
            $row[] = array(                         						
                        'idx' => '03',
                        'uraian'  => 'Belanja',   
                        'nilai'   => number_format($keluar,2),                              						                         
                        );                                       
           
           echo json_encode($row);     
    }
    
    function setuju_sp3b() {
    $sp3b = $this->input->post('no_sp3b');
    $sp2b = $this->input->post('no_sp2b');
    $number_sp2b = $this->input->post('number_sp2b');
    $tgl_sah = $this->input->post('tgl_sah');
    $kdskpd = $this->input->post('kd_skpd');
	$sql = "UPDATE trhsp3b_bos SET number_sp2b='$number_sp2b',status_bud='1',tgl_sp2b='$tgl_sah',no_sp2b='$sp2b' WHERE no_sp3b='$sp3b' AND kd_skpd='$kdskpd'";
	$asg = $this->db->query($sql);  
	if ($asg > 0){  	
                    echo '2';
                    exit();
               } else {
                    echo '0';
                    exit();
               }
	}
    
    function batalsetuju_sp3b() {
    $sp3b = $this->input->post('no_sp3b');
    $sp2b = $this->input->post('no_sp2b');
    $tgl_sah = $this->input->post('tgl_sah');
    $kdskpd = $this->input->post('kd_skpd');
    $number_sp2b = $this->input->post('number_sp2b');
	$sql = "UPDATE trhsp3b_bos SET number_sp2b='0',status_bud='0',tgl_sp2b='',no_sp2b='' WHERE no_sp3b='$sp3b' AND kd_skpd='$kdskpd'";
	$asg = $this->db->query($sql);  
	if ($asg > 0){  	
                    echo '2';
                    exit();
               } else {
                    echo '0';
                    exit();
               }
	}


       function cetak_sp2b_bos(){        
        $nomor1 = str_replace('abcdefghij','/',$this->uri->segment(6));
        $nomorsp2b  = str_replace('123456789',' ',$nomor1);
        $pusk  = $this->uri->segment(4);
        $lcskpd = substr($pusk,0,7).".00";
        $ttd1   = str_replace('a',' ',$this->uri->segment(3));  
        $ctk = $this->uri->segment(5);
        
        $ketsaldo = ''; 
        $nilai_saldo = 0;                                       
        
        $skpd = $this->tukd_model->get_nama($lcskpd,'nm_skpd','ms_skpd','kd_skpd');
        $nmpusk = $this->tukd_model->get_nama($pusk,'nm_skpd','ms_skpd_bos','kd_skpd');        
        $sqlsc="SELECT tgl_rka,provinsi,kab_kota,daerah,thn_ang FROM sclient WHERE kd_skpd='$lcskpd'";
                 $sqlsclient=$this->db->query($sqlsc);
                 foreach ($sqlsclient->result() as $rowsc)
                 {
                    $kab     = $rowsc->kab_kota;
                    $prov     = $rowsc->provinsi;
                    $daerah  = $rowsc->daerah;
                    $thn     = $rowsc->thn_ang;
                 }
        $sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab,pangkat FROM ms_ttd where nip='$ttd1' and kode='BUD'";
                 $sqlttd=$this->db->query($sqlttd1);
                 foreach ($sqlttd->result() as $rowttd)
                {
                    $nip=$rowttd->nip;                    
                    $nama= $rowttd->nm;
                    $jabatan  = "Selaku ".$rowttd->jab;
                    $pangkat  = $rowttd->pangkat;
                }       
                
        $tgll = $this->db->query("select tgl_sp2b,no_lpj,no_sp3b,tgl_sp3b,bulan from trhsp3b_bos where no_sp2b='$nomorsp2b' and kd_skpd='$pusk'")->row();            
            $tgl_sp2b = $tgll->tgl_sp2b;
            $tgl_sp2b = $this->tukd_model->tanggal_format_indonesia($tgl_sp2b);
            $no_lpjj =  $tgll->no_lpj;
            $no_sp3bb = $tgll->no_sp3b;
            $tgl_sp3b = $tgll->tgl_sp3b;
            $tgl_sp3b = $this->tukd_model->tanggal_format_indonesia($tgl_sp3b);
            $nbulan   = $tgll->bulan;
            
        if($nbulan==6){
            $intbulan1 = '1';
            $intbulan2 = '6';
            $intbulan3 = "('6')";
        }if($nbulan==12){
            $intbulan1 = '7';
            $intbulan2 = '12';
            $intbulan3 = "('6','9')";
        }
    
            
            if($nbulan==6){
            
            $n = $this->db->query("select ISNULL(sld_awal,0)+ISNULL(sld_awal_tunai,0)+ISNULL(sld_awal_pajak,0) as sld_awal from ms_skpd_bos where kd_skpd='$pusk'")->row();            
            $nilai_saldo = $n->sld_awal;
            }else{            
              $sql1=$this->db->query("                     
                    SELECT ISNULL(SUM(terima-keluar),0) as nilai FROM (
                    select ISNULL(sld_awal,0)+ISNULL(sld_awal_tunai,0)+ISNULL(sld_awal_pajak,0) as terima, 0 keluar from ms_skpd_bos where kd_skpd='$pusk'
                    UNION ALL
                    SELECT nilai terima, 0 keluar from TRHINLAIN_BOS WHERE kd_skpd='$pusk' AND MONTH(TGL_BUKTI)<'$intbulan1' AND JNS_BEBAN='11'
                    UNION ALL
                    SELECT 0 terima, nilai keluar from TRHOUTLAIN_BOS WHERE kd_skpd='$pusk' AND MONTH(TGL_BUKTI)<'$intbulan1' AND JNS_BEBAN IN ('12','14')
                    UNION ALL
                    SELECT 0 terima, b.nilai keluar FROM trhtransout_bos a INNER JOIN trdtransout_bos b 
                    ON a.kd_skpd = b.kd_skpd and a.no_bukti=b.no_bukti 
                    WHERE a.kd_skpd='$pusk' AND MONTH(a.tgl_kas)<'$intbulan1'  
                    )a 
                    ")->row();    
            $nilai_saldo = $sql1->nilai;          
                    
            }     
            
            $cRet ='
            <br><br><br>
            
            <TABLE style="border-collapse:collapse; font-size:14px" width="100%" border="0" cellspacing="0" cellpadding="1" align=center>
                    <TR>
                        <TD align="center" style="font-size:16px;"><b>PEMERINTAH KABUPATEN SANGGAU</b>                                                          
                        </TD>
                    </TR>
                    <TR>
                        <TD align="center" style="font-size:19px;"><b>BADAN KEUANGAN DAERAH (BKD)</b>                                                            
                        </TD>
                    </TR>   
                    <TR>
                        <TD align="center" style="font-size:11px;"><b>Jalan Letnan Jendral Sutoyo. Telp / Fax (0561) 732509 / 741641</b>                         
                        </TD>
                    </TR>
                    <TR>
                        <TD align="center" style="font-size:11px;"><b>KABUPATEN SANGGAU - 81147</b>                         
                        </TD>
                    </TR>               
                    </TABLE><br>';          
            $cRet .='<TABLE style="border-collapse:collapse; border-top:none; border-top:solid 1px black;  border-left:solid 1px black; border-right:solid 1px black; border-bottom:solid 1px black; font-size:13px;" width="100%">
                    <TR>
                        <TD colspan="3" style="border-right:solid 1px black;"><br></TD>
                        <TD align="center" width="51%" rowspan="3"><b>SURAT PENGESAHAN BELANJA (SPB) <br/>DINAS PENDIDIKAN</b></TD>                 
                    </TR>
                    <TR>
                        <TD align="left" width="9%">Nomor SP2B </TD>                        
                        <TD align="left" width="1%">: </TD>
                        <TD align="left" width="46%" style="border-right:solid 1px black;">'.$no_sp3bb.'</TD>
                        </TR>
                    <TR>
                        <TD align="left" width="9%">Tanggal</TD>                        
                        <TD align="left" width="1%">: </TD>
                        <TD align="left" width="46%" style="border-right:solid 1px black;">'.$tgl_sp3b.'</TD>                        
                    </TR>
                    <TR>
                        <TD align="left" width="9%">OPD</TD>                       
                        <TD align="left" width="1%">: </TD>
                        <TD align="left" width="46%" style="border-right:solid 1px black;">'.$skpd.'</TD>
                        <TD align="left" width="51%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tanggal &nbsp;&nbsp;&nbsp; : '.$tgl_sp2b.'</TD>
                    </TR>   
                    <TR>
                        <TD align="left" width="9%">Satuan Pendidikan</TD>                      
                        <TD align="left" width="1%">: </TD>
                        <TD align="left" width="40%" style="border-right:solid 1px black;">'.$nmpusk.'</TD>
                        <TD align="left" width="50%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nomor &nbsp;&nbsp;&nbsp;&nbsp;  : '.$nomorsp2b.'</TD>
                    </TR>
                    <TR>
                        <TD align="left" width="9%"></TD>                      
                        <TD align="left" width="1%"></TD>
                        <TD align="left" width="40%" style="border-right:solid 1px black;"></TD>
                        <TD align="left" width="50%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Keperluan : '.$this->tukd_model->getSemester($nbulan).' Tahun '.$thn.'</TD>
                    </TR>
                    <TR>
                        <TD colspan="3" style="border-right:solid 1px black;"><br></TD>
                        <TD ><br></TD>
                    </TR>
                                                                                                
                    </TABLE>';          
                    
                    $sql = " SELECT sum(a.terima) terima,sum(a.keluar) keluar FROM (
                SELECT SUM(z.terima-z.keluar) terima, 0 keluar from(
                SELECT nilai terima, 0 keluar from TRHINLAIN_BOS WHERE kd_skpd='$pusk' AND MONTH(TGL_BUKTI)>='$intbulan1' AND MONTH(TGL_BUKTI)<='$intbulan2' AND JNS_BEBAN='11' 
                UNION ALL
                SELECT 0 terima, nilai keluar from TRHOUTLAIN_BOS WHERE kd_skpd='$pusk' AND MONTH(TGL_BUKTI)>='$intbulan1' AND MONTH(TGL_BUKTI)<='$intbulan2' AND JNS_BEBAN IN ('12','14')
                )z
                UNION ALL
                SELECT 0 terima, sum(b.nilai) keluar FROM trhtransout_bos a INNER JOIN trdtransout_bos b 
                ON a.kd_skpd = b.kd_skpd and a.no_bukti=b.no_bukti 
                WHERE a.kd_skpd='$pusk' AND MONTH(a.tgl_kas)>='$intbulan1' and MONTH(a.tgl_kas)<='$intbulan2'                                    
                ) a "; 
                
        $hasil = $this->db->query($sql);
        $lcno=0;
        $sisa=$nilai_saldo;             
       foreach ($hasil->result() as $row){
         $terima = $row->terima;
         $keluar = $row->keluar;         
         $sisa=$sisa+$terima-$keluar;         
         $terima1 = empty($terima) || $terima == 0 ? '' :number_format($terima,'2','.',',');
         $keluar1 = empty($keluar) || $keluar == 0 ? '' :number_format($keluar,'2','.',',');
        }
        
     
                        
            $cRet .='<TABLE style="border-collapse:collapse; border-top:none; border-left:solid 1px black; border-right:solid 1px black; border-bottom:solid 1px black; font-size:13px;" width="100%">
                    <TR>
                        <TD align="left" width="100%" colspan="3"><br></TD>                     
                    </TR>
                    <TR>
                        <TD align="left" width="100%" colspan="3">Telah disahkan belanja sejumlah :</TD>                        
                    </TR>   
                    <TR>
                        <TD align="left" width="10%"></TD>                      
                        <TD align="left" width="25%">1. &nbsp; Saldo </TD>                     
                        <TD align="left" width="65%">Rp. '.number_format($nilai_saldo+$terima,'2','.',',').'</TD>                       
                    </TR>
                    <TR>
                        <TD align="left" width="10%"></TD>                      
                        <TD align="left" width="25%">3. &nbsp; Belanja</TD>                     
                        <TD align="left" width="65%">Rp. '.number_format($keluar,'2','.',',').'</TD>                        
                    ';

            $sql_belanja_peg = $this->db->query("
                SELECT kode,case when kode='511' then 'Belanja Pegawai' when kode='512' then 'Belanja Barang dan Jasa' when kode='525' then 'Belanja Modal' end as nama, ISNULL(SUM(keluar),0) as nilai FROM (
                SELECT left(b.kd_rek5,3) kode, sum(b.nilai) keluar FROM trhtransout_bos a INNER JOIN trdtransout_bos b 
                ON a.kd_skpd = b.kd_skpd and a.no_bukti=b.no_bukti 
                WHERE a.kd_skpd='$pusk' AND MONTH(a.tgl_kas)>='$intbulan1' and MONTH(a.tgl_kas)<='$intbulan2' group by left(b.kd_rek5,3)) a group by kode");
                foreach ($sql_belanja_peg->result() as $row)
                {
       
                    $cRet .='<TR>
                        <TD align="left" width="10%"></TD>                      
                        <TD align="left" width="25%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- '.$row->nama.'</TD>                     
                        <TD align="left" width="65%">Rp. '.number_format($row->nilai,'2','.',',').'</TD>                     
                    </TR>'; 
                }                           

            $cRet .='</TR>    
                    <TR>
                        <TD align="left" width="10%"></TD>                      
                        <TD align="left" width="25%">4. &nbsp; Saldo Akhir</TD>                     
                        <TD align="left" width="65%">Rp. '.number_format($sisa,'2','.',',').'</TD>                      
                    </TR>   
                    <TR>
                        <TD align="left" width="100%" colspan="3"><br></TD>                                                                     
                    </TR>
                    </TABLE><br>';  
        
                                                
            $cRet .='<TABLE style="font-size:13px;" width="100%" align="center">
                    <TR>
                        <TD width="50%" align="center" ></TD>
                        <TD width="50%" align="center" >Sanggau, '.$tgl_sp2b.'</TD>
                    </TR>
                    <TR>
                        <TD width="50%" align="center" ></TD>
                        <TD width="50%" align="center" >'.$jabatan.' <br>'.$pangkat.'</TD>
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
                        <TD width="50%" align="center" ></TD>
                        <TD width="50%" align="center" ><b><u>'.$nama.'</u></b><br>'.$pangkat.'</TD>
                    </TR>
                    <TR>
                        <TD width="50%" align="center" ></TD>
                        <TD width="50%" align="center" >'.$nip.'</TD>
                    </TR>
                    </TABLE><br/>';

        $atas='5';
        $bawah='5';
         $kiri='5';   
         $kanan='5';

            $data['prev']= $cRet;
             switch ($ctk)
        {
            case 0;
            echo ("<title>SURAT SPB</title>");
                echo $cRet;
                break;
            case 1;
                //$this->_mpdf('',$cRet,10,10,10,10,1,'');
                $this->_mpdf_margin('',$cRet,10,10,10,'P',0,'',$atas,$bawah,$kiri,$kanan);               
               break;
        }
    }
    
    
    function cetak_regsp2b($nbulan='',$ctk='',$ttd='', $tgl=''){
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
                    $nama= $rowttd->nm;
                    $jabatan  = $rowttd->jab;
                    $pangkat  = $rowttd->pangkat;
                }
       
		 if($nbulan==3){
            $intbulan1 = '1';
            $intbulan2 = '3';
            $intbulan3 = "('1')";
            $init_nama = "TRIWULAN I";
        }else if($nbulan==6){
            $intbulan1 = '4';
            $intbulan2 = '6';
            $intbulan3 = "('3')";
            $init_nama = "TRIWULAN II";
        }else if($nbulan==9){
            $intbulan1 = '7';
            $intbulan2 = '9';
            $intbulan3 = "('3','6')";
            $init_nama = "TRIWULAN III";
        }else if($nbulan==12){
            $intbulan1 = '10';
            $intbulan2 = '12';
            $intbulan3 = "('3','6','9')";
            $init_nama = "TRIWULAN IV";
        }
        
        
			$cRet ='<TABLE style="border-collapse:collapse; font-size:12px" width="100%" border="0" cellspacing="0" cellpadding="1" align=center>
					<TR>
						<TD align="center" ><b>PEMERINTAH KABUPATEN SANGGAU</TD>
					</TR>
					<TR>
						<TD align="center" ><b>REGISTER SPB DAN SP2B (KAS DILUAR REKENING KAS UMUM DAERAH)</TD>
					</TR>
                    <TR>
						<TD align="center" ><b></TD>
					</TR>
                    <TR>
					<TD align="center" ><b>'.strtoupper($init_nama).' '.$thn.'</TD>
					</TR>
					</TABLE><br/>';			

			$cRet .='<TABLE style="border-collapse:collapse; font-size:11px" width="100%" border="1" cellspacing="0" cellpadding="3" align=center>
					 <thead>
					 <TR>
						<TD rowspan="2" bgcolor="#CCCCCC" align="center" >NO.</TD>
                        <TD rowspan="2" bgcolor="#CCCCCC" align="center" >SATUAN PENDIDIKAN</TD>
						<TD colspan="2" bgcolor="#CCCCCC" align="center" >NO LPJ</TD>
						<TD colspan="2" bgcolor="#CCCCCC" align="center" >SP3B</TD>
						<TD rowspan="2" bgcolor="#CCCCCC" align="center" >SP2B</TD>
						<TD rowspan="2" bgcolor="#CCCCCC" align="center" >SALDO AWAL</TD>
                        <TD rowspan="2" bgcolor="#CCCCCC" align="center" >KAS LAINNYA</TD>
                        <TD rowspan="2" bgcolor="#CCCCCC" align="center" >BELANJA</TD>
                        <TD rowspan="2" bgcolor="#CCCCCC" align="center" >SALDO AKHIR</TD>
					 </TR>
					 <TR>
                        <TD bgcolor="#CCCCCC" align="center" >NOMOR</TD>
						<TD bgcolor="#CCCCCC" align="center" >TANGGAL</TD>						
						<TD bgcolor="#CCCCCC" align="center" >NOMOR</TD>
						<TD bgcolor="#CCCCCC" align="center" >TANGGAL</TD>
					 </TR>
					 </thead>
					 ';
		    
              
			$query = $this->db->query("select a.kd_skpd,(select nm_skpd from ms_skpd_bos where kd_skpd=a.kd_skpd) nm_skpd,
            a.no_lpj,a.no_sp2b,a.tgl_sp2b,a.no_sp3b,a.tgl_sp3b,isnull(total,0) belanja
            from trhsp3b_bos a where a.bulan='$nbulan' order by kd_skpd");
			$no=0;
			$tot_saldo=0;
			   foreach ($query->result() as $row) {
				$no=$no+1;
				$kd_skpd = $row->kd_skpd; 
				$nm_skpd = $row->nm_skpd;                   
				$no_lpj = $row->no_lpj;                   
				$no_sp2b = $row->no_sp2b;                   
				$tgl_sp2b = $row->tgl_sp2b;
				$no_sp3b =$row->no_sp3b;
				$tgl_sp3b=$row->tgl_sp3b;
				$tot_bel=$row->belanja;
				
            if($nbulan==3){
            $n = $this->db->query("select ISNULL(sld_awal, 0) + ISNULL(sld_awal_tunai, 0) + ISNULL(selisih_sld_tunai, 0) + ISNULL(selisih_sld_bank, 0) as sld_awal from ms_skpd_bos where kd_skpd='$kd_skpd'")->row();                        
            $nilai_saldo = $n->sld_awal;
            }else{            
              $sql1=$this->db->query("                     
                    SELECT ISNULL(SUM(terima-keluar),0) as nilai FROM (
                    select ISNULL(sld_awal, 0) + ISNULL(sld_awal_tunai, 0) + ISNULL(selisih_sld_tunai, 0) + ISNULL(selisih_sld_bank, 0) as terima, 0 keluar from ms_skpd_bos where kd_skpd='$kd_skpd'
                    UNION ALL
                    SELECT nilai terima, 0 keluar from TRHINLAIN_BOS WHERE kd_skpd='$kd_skpd' AND MONTH(TGL_BUKTI)<'$intbulan1' AND JNS_BEBAN='11'
                    UNION ALL
                    SELECT 0 terima, nilai keluar from TRHOUTLAIN_BOS WHERE kd_skpd='$kd_skpd' AND MONTH(TGL_BUKTI)<'$intbulan1' AND JNS_BEBAN IN ('12','14')
                    UNION ALL
                    SELECT 0 terima, b.nilai keluar FROM trhtransout_bos a INNER JOIN trdtransout_bos b 
                    ON a.kd_skpd = b.kd_skpd and a.no_bukti=b.no_bukti 
                    WHERE a.kd_skpd='$kd_skpd' AND MONTH(a.tgl_kas)<'$intbulan1'  
                    )a 
                    ")->row();                                                      
            $nilai_saldo = $sql1->nilai;                    
            }     
            
            $sql3=$this->db->query("                     
                    SELECT ISNULL(SUM(terima-keluar),0) as nilai FROM (
                    SELECT nilai terima, 0 keluar from TRHINLAIN_BOS WHERE kd_skpd='$kd_skpd' AND MONTH(TGL_BUKTI)>='$intbulan1' AND MONTH(TGL_BUKTI)<='$intbulan2' AND JNS_BEBAN='11'
                    UNION ALL
                    SELECT 0 terima, nilai keluar from TRHOUTLAIN_BOS WHERE kd_skpd='$kd_skpd' AND MONTH(TGL_BUKTI)>='$intbulan1' AND MONTH(TGL_BUKTI)<='$intbulan2' AND JNS_BEBAN IN ('12','14')
                    )a 
                    ")->row();  $nilai_pendapatan = $sql3->nilai;         
            
            $saldo_akhirr = ($nilai_saldo+$nilai_pendapatan)-$tot_bel;
            $tot_saldo = $tot_saldo + $saldo_akhirr;
                            
                $nilai_saldo1  = empty($nilai_saldo) || $nilai_saldo == 0 ? number_format(0,"2",",",".") :number_format($nilai_saldo,"2",",",".");                    
                $nilai_pendapatan1  = empty($nilai_pendapatan) || $nilai_pendapatan == 0 ? number_format(0,"2",",",".") :number_format($nilai_pendapatan,"2",",",".");
                $tot_bel1  = empty($tot_bel) || $tot_bel == 0 ? number_format(0,"2",",",".") :number_format($tot_bel,"2",",",".");	
				$saldo_akhirr1  = empty($saldo_akhirr) || $saldo_akhirr == 0 ? number_format(0,"2",",",".") :number_format($saldo_akhirr,"2",",",".");	
				                  
                $cRet .="<tr>
						<td valign=\"top\" align=\"center\">$no </td>
						<td valign=\"top\" align=\"left\">$nm_skpd </td>
						<td valign=\"top\" align=\"center\">$no_lpj </td>
						<td valign=\"top\" align=\"center\">$no_sp2b </td>
						<td valign=\"top\" align=\"center\">$tgl_sp2b </td>
						<td valign=\"top\" align=\"center\">$no_sp3b </td>
						<td valign=\"top\" align=\"center\">$tgl_sp3b </td>
                        <td valign=\"top\" align=\"right\">$nilai_saldo1</td>
                        <td valign=\"top\" align=\"right\">$nilai_pendapatan1</td>
                        <td valign=\"top\" align=\"right\">$tot_bel1</td>
						<td valign=\"top\" align=\"right\">$saldo_akhirr1</td>
						</tr>";
                        
				}	
				$cRet .="<tr>
						<td valign=\"top\" align=\"center\" colspan=\"10\"><b> TOTAL </b></td>
						<td valign=\"top\" align=\"right\"><b> ".number_format($tot_saldo,"2",",",".")."</b> &nbsp;</td>
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
        
        $atas='3';
        $bawah='3';
         $kiri='3';   
         $kanan='3';
        
			$data['prev']= $cRet;
             switch ($ctk)
        {
            case 0;
			echo ("<title>REGISTER SP2B $init_nama</title>");
				echo $cRet;
				break;
            case 1;
				$this->_mpdf_margin('',$cRet,10,10,10,'L',0,'',$atas,$bawah,$kiri,$kanan);  
               break;
			case 2;        
				header("Cache-Control: no-cache, no-store, must-revalidate");
				header("Content-Type: application/vnd.ms-excel");
				header("Content-Disposition: attachment; filename=RTH_$nbulan.xls");
            
            $this->load->view('anggaran/rka/perkadaII', $data);
			break;   
		}
	}
    
     function cetak_regsp2b_kapitasi($nbulan='',$ctk='',$ttd='', $tgl=''){
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
                    $nama= $rowttd->nm;
                    $jabatan  = $rowttd->jab;
                    $pangkat  = $rowttd->pangkat;
                }
       
		 if($nbulan==3){
            $intbulan1 = '1';
            $intbulan2 = '3';
            $intbulan3 = "('1')";
            $init_nama = "TRIWULAN I";
        }else if($nbulan==6){
            $intbulan1 = '4';
            $intbulan2 = '6';
            $intbulan3 = "('3')";
            $init_nama = "TRIWULAN II";
        }else if($nbulan==9){
            $intbulan1 = '7';
            $intbulan2 = '9';
            $intbulan3 = "('3','6')";
            $init_nama = "TRIWULAN III";
        }else if($nbulan==12){
            $intbulan1 = '10';
            $intbulan2 = '12';
            $intbulan3 = "('3','6','9')";
            $init_nama = "TRIWULAN IV";
        }
        
        
			$cRet ='<TABLE style="border-collapse:collapse; font-size:12px" width="100%" border="0" cellspacing="0" cellpadding="1" align=center>
					<TR>
						<TD align="center" ><b>PEMERINTAH KABUPATEN SANGGAU</TD>
					</TR>
					<TR>
						<TD align="center" ><b>REGISTER SP2B DAN SP3B (KAS DILUAR REKENING KAS UMUM DAERAH)</TD>
					</TR>
                    <TR>
						<TD align="center" ><b></TD>
					</TR>
                    <TR>
					<TD align="center" ><b>'.strtoupper($init_nama).' '.$thn.'</TD>
					</TR>
					</TABLE><br/>';			

			$cRet .='<TABLE style="border-collapse:collapse; font-size:11px" width="100%" border="1" cellspacing="0" cellpadding="3" align=center>
					 <thead>
					 <TR>
						<TD rowspan="2" bgcolor="#CCCCCC" align="center" >NO.</TD>
                        <TD rowspan="2" bgcolor="#CCCCCC" align="center" >SATUAN PENDIDIKAN</TD>
						<TD colspan="2" bgcolor="#CCCCCC" align="center" >NO LPJ</TD>
						<TD colspan="2" bgcolor="#CCCCCC" align="center" >SP3B</TD>
						<TD rowspan="2" bgcolor="#CCCCCC" align="center" >SP2B</TD>
						<TD rowspan="2" bgcolor="#CCCCCC" align="center" >SALDO AWAL</TD>
                        <TD rowspan="2" bgcolor="#CCCCCC" align="center" >PENDAPATAN</TD>
                        <TD rowspan="2" bgcolor="#CCCCCC" align="center" >BELANJA</TD>
                        <TD rowspan="2" bgcolor="#CCCCCC" align="center" >SALDO AKHIR</TD>
					 </TR>
					 <TR>
                        <TD bgcolor="#CCCCCC" align="center" >NOMOR</TD>
						<TD bgcolor="#CCCCCC" align="center" >TANGGAL</TD>						
						<TD bgcolor="#CCCCCC" align="center" >NOMOR</TD>
						<TD bgcolor="#CCCCCC" align="center" >TANGGAL</TD>
					 </TR>
					 </thead>
					 ';
		    
              
			$query = $this->db->query("select a.kd_skpd,(select nm_skpd from ms_skpd_jkn where kd_skpd=a.kd_skpd) nm_skpd,
            a.no_lpj,a.no_sp2b,a.tgl_sp2b,a.no_sp3b,a.tgl_sp3b,isnull(total,0) belanja
            from trhsp3b a where a.bulan='$nbulan' order by kd_skpd");
			$no=0;
			$tot_saldo=0;
			   foreach ($query->result() as $row) {
				$no=$no+1;
				$kd_skpd = $row->kd_skpd; 
				$nm_skpd = $row->nm_skpd;                   
				$no_lpj = $row->no_lpj;                   
				$no_sp2b = $row->no_sp2b;                   
				$tgl_sp2b = $row->tgl_sp2b;
				$no_sp3b =$row->no_sp3b;
				$tgl_sp3b=$row->tgl_sp3b;
				$tot_bel=$row->belanja;
				
            if($nbulan==3){
            $n = $this->db->query("select ISNULL(sld_awal, 0) + 0 + 0 + 0 as sld_awal from ms_skpd_jkn where kd_skpd='$kd_skpd'")->row();                        
            $nilai_saldo = $n->sld_awal;
            }else{            
              $sql1=$this->db->query("                     
                    SELECT ISNULL(SUM(terima-keluar),0) as nilai FROM (
                    select ISNULL(sld_awal, 0) + 0 + 0 +  0 as terima, 0 keluar from ms_skpd_jkn where kd_skpd='$kd_skpd'
                    UNION ALL
                    SELECT nilai terima, 0 keluar from TRHINLAIN_pusk WHERE kd_skpd='$kd_skpd' AND MONTH(TGL_BUKTI)<'$intbulan1' AND JNS_BEBAN='8'
                    UNION ALL
                    SELECT 0 terima, nilai keluar from TRHOUTLAIN_pusk WHERE kd_skpd='$kd_skpd' AND MONTH(TGL_BUKTI)<'$intbulan1' AND JNS_BEBAN IN ('12','14')
                    UNION ALL
                    SELECT 0 terima, b.nilai keluar FROM trhtransout_pusk a INNER JOIN trdtransout_pusk b 
                    ON a.kd_skpd = b.kd_skpd and a.no_bukti=b.no_bukti 
                    WHERE a.kd_skpd='$kd_skpd' AND MONTH(a.tgl_kas)<'$intbulan1'  
                    )a 
                    ")->row();                                                      
            $nilai_saldo = $sql1->nilai;                    
            }     
            
            $sql3=$this->db->query("                     
                    SELECT ISNULL(SUM(terima-keluar),0) as nilai FROM (
                    SELECT nilai terima, 0 keluar from TRHINLAIN_pusk WHERE kd_skpd='$kd_skpd' AND MONTH(TGL_BUKTI)>='$intbulan1' AND MONTH(TGL_BUKTI)<='$intbulan2' AND JNS_BEBAN='8'
                    UNION ALL
                    SELECT 0 terima, nilai keluar from TRHOUTLAIN_pusk WHERE kd_skpd='$kd_skpd' AND MONTH(TGL_BUKTI)>='$intbulan1' AND MONTH(TGL_BUKTI)<='$intbulan2' AND JNS_BEBAN IN ('12','14')
                    )a 
                    ")->row();  $nilai_pendapatan = $sql3->nilai;         
            
            $saldo_akhirr = ($nilai_saldo+$nilai_pendapatan)-$tot_bel;
            $tot_saldo = $tot_saldo + $saldo_akhirr;
                            
                $nilai_saldo1  = empty($nilai_saldo) || $nilai_saldo == 0 ? number_format(0,"2",",",".") :number_format($nilai_saldo,"2",",",".");                    
                $nilai_pendapatan1  = empty($nilai_pendapatan) || $nilai_pendapatan == 0 ? number_format(0,"2",",",".") :number_format($nilai_pendapatan,"2",",",".");
                $tot_bel1  = empty($tot_bel) || $tot_bel == 0 ? number_format(0,"2",",",".") :number_format($tot_bel,"2",",",".");	
				$saldo_akhirr1  = empty($saldo_akhirr) || $saldo_akhirr == 0 ? number_format(0,"2",",",".") :number_format($saldo_akhirr,"2",",",".");	
				                  
                $cRet .="<tr>
						<td valign=\"top\" align=\"center\">$no </td>
						<td valign=\"top\" align=\"left\">$nm_skpd </td>
						<td valign=\"top\" align=\"left\">$no_lpj </td>
						<td valign=\"top\" align=\"center\">$no_sp2b </td>
						<td valign=\"top\" align=\"center\">$tgl_sp2b </td>
						<td valign=\"top\" align=\"center\">$no_sp3b </td>
						<td valign=\"top\" align=\"center\">$tgl_sp3b </td>
                        <td valign=\"top\" align=\"right\">$nilai_saldo1</td>
                        <td valign=\"top\" align=\"right\">$nilai_pendapatan1</td>
                        <td valign=\"top\" align=\"right\">$tot_bel1</td>
						<td valign=\"top\" align=\"right\">$saldo_akhirr1</td>
						</tr>";
                        
				}	
				$cRet .="<tr>
						<td valign=\"top\" align=\"center\" colspan=\"10\"><b> TOTAL </b></td>
						<td valign=\"top\" align=\"right\"><b> ".number_format($tot_saldo,"2",",",".")."</b> &nbsp;</td>
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
        
        $atas='3';
        $bawah='3';
         $kiri='3';   
         $kanan='3';
        
			$data['prev']= $cRet;
             switch ($ctk)
        {
            case 0;
			echo ("<title>REGISTER SP2B $init_nama</title>");
				echo $cRet;
				break;
            case 1;
				$this->_mpdf_margin('',$cRet,10,10,10,'L',0,'',$atas,$bawah,$kiri,$kanan);  
               break;
			case 2;        
				header("Cache-Control: no-cache, no-store, must-revalidate");
				header("Content-Type: application/vnd.ms-excel");
				header("Content-Disposition: attachment; filename=RTH_$nbulan.xls");
            
            $this->load->view('anggaran/rka/perkadaII', $data);
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
    
    function cetak_regsp2b_baru($nbulan='',$ctk='',$ttd='', $tgl=''){
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
                    $nama= $rowttd->nm;
                    $jabatan  = $rowttd->jab;
                    $pangkat  = $rowttd->pangkat;
                }
       
		 if($nbulan==3){
            $intbulan1 = '1';
            $intbulan2 = '3';
            $intbulan3 = "('1')";
            $init_nama = "TRIWULAN I";
        }else if($nbulan==6){
            $intbulan1 = '4';
            $intbulan2 = '6';
            $intbulan3 = "('3')";
            $init_nama = "TRIWULAN II";
        }else if($nbulan==9){
            $intbulan1 = '7';
            $intbulan2 = '9';
            $intbulan3 = "('3','6')";
            $init_nama = "TRIWULAN III";
        }else if($nbulan==12){
            $intbulan1 = '10';
            $intbulan2 = '12';
            $intbulan3 = "('3','6','9')";
            $init_nama = "TRIWULAN IV";
        }
        
        
			$cRet ='<TABLE style="border-collapse:collapse; font-size:12px" width="100%" border="0" cellspacing="0" cellpadding="1" align=center>
					<TR>
						<TD align="center" ><b>PEMERINTAH KABUPATEN SANGGAU</TD>
					</TR>
					<TR>
						<TD align="center" ><b>REGISTER SP2B DAN SPB (KAS DILUAR REKENING KAS UMUM DAERAH)</TD>
					</TR>
                    <TR>
						<TD align="center" ><b></TD>
					</TR>
                    <TR>
					<TD align="center" ><b>'.strtoupper($init_nama).' '.$thn.'</TD>
					</TR>
					</TABLE><br/>';			

			$cRet .='<TABLE style="border-collapse:collapse; font-size:11px" width="100%" border="1" cellspacing="0" cellpadding="3" align=center>
					 <thead>
					 <TR>
						<TD rowspan="2" bgcolor="#CCCCCC" align="center" >NO.</TD>
                        <TD rowspan="2" bgcolor="#CCCCCC" align="center" >SATUAN PENDIDIKAN</TD>
						<TD rowspan="2" bgcolor="#CCCCCC" align="center" >NO. REKENING</TD>
						<TD rowspan="2" bgcolor="#CCCCCC" align="center" >NO. LPJ</TD>
						<TD colspan="2" bgcolor="#CCCCCC" align="center" >SP2B</TD>
						<TD colspan="2" bgcolor="#CCCCCC" align="center" >SP3B</TD>
						<TD rowspan="2" bgcolor="#CCCCCC" align="center" >SALDO AWAL</TD>
                        <TD rowspan="2" bgcolor="#CCCCCC" align="center" >JUMLAH PENDAPATAN</TD>
                        <TD rowspan="2" bgcolor="#CCCCCC" align="center" >JUMLAH BELANJA</TD>
                        <TD rowspan="2" bgcolor="#CCCCCC" align="center" >SALDO AKHIR</TD>
					 </TR>
					 <TR>
						<TD bgcolor="#CCCCCC" align="center" >NOMOR</TD>
						<TD bgcolor="#CCCCCC" align="center" >TANGGAL</TD>
						<TD bgcolor="#CCCCCC" align="center" >NOMOR</TD>
						<TD bgcolor="#CCCCCC" align="center" >TANGGAL</TD>
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
		    
              
			$query = $this->db->query("select a.kd_skpd,(select nm_skpd from ms_skpd_bos where kd_skpd=a.kd_skpd) nm_skpd,
            a.no_lpj,a.no_sp2b,a.tgl_sp2b,a.no_sp3b,a.tgl_sp3b,isnull(total,0) belanja
            from trhsp3b_bos a where a.bulan='$nbulan' order by kd_skpd");
			$no=0;
			$tot_saldo=0;
			   foreach ($query->result() as $row) {
				$no=$no+1;
				$kd_skpd = $row->kd_skpd; 
				$nm_skpd = $row->nm_skpd;                   
				$no_lpj = $row->no_lpj;                   
				$no_sp2b = $row->no_sp2b;                   
				$tgl_sp2b = $row->tgl_sp2b;
				$no_sp3b =$row->no_sp3b;
				$tgl_sp3b=$row->tgl_sp3b;
				$tot_bel=$row->belanja;
				
            if($nbulan==3){
            $n = $this->db->query("select ISNULL(sld_awal, 0) + ISNULL(sld_awal_tunai, 0) + ISNULL(selisih_sld_tunai, 0) + ISNULL(selisih_sld_bank, 0) as sld_awal from ms_skpd_bos where kd_skpd='$kd_skpd'")->row();                        
            $nilai_saldo = $n->sld_awal;
            }else{            
              $sql1=$this->db->query("                     
                    SELECT ISNULL(SUM(terima-keluar),0) as nilai FROM (
                    select ISNULL(sld_awal, 0) + ISNULL(sld_awal_tunai, 0) + ISNULL(selisih_sld_tunai, 0) + ISNULL(selisih_sld_bank, 0) as terima, 0 keluar from ms_skpd_bos where kd_skpd='$kd_skpd'
                    UNION ALL
                    SELECT nilai terima, 0 keluar from TRHINLAIN_BOS WHERE kd_skpd='$kd_skpd' AND MONTH(TGL_BUKTI)<'$intbulan1' AND JNS_BEBAN='11'
                    UNION ALL
                    SELECT 0 terima, nilai keluar from TRHOUTLAIN_BOS WHERE kd_skpd='$kd_skpd' AND MONTH(TGL_BUKTI)<'$intbulan1' AND JNS_BEBAN IN ('12','14')
                    UNION ALL
                    SELECT 0 terima, b.nilai keluar FROM trhtransout_bos a INNER JOIN trdtransout_bos b 
                    ON a.kd_skpd = b.kd_skpd and a.no_bukti=b.no_bukti 
                    WHERE a.kd_skpd='$kd_skpd' AND MONTH(a.tgl_kas)<'$intbulan1'  
                    )a 
                    ")->row();                                                      
            $nilai_saldo = $sql1->nilai;                    
            }     
            
            $sql3=$this->db->query("                     
                    SELECT ISNULL(SUM(terima-keluar),0) as nilai FROM (
                    SELECT nilai terima, 0 keluar from TRHINLAIN_BOS WHERE kd_skpd='$kd_skpd' AND MONTH(TGL_BUKTI)>='$intbulan1' AND MONTH(TGL_BUKTI)<='$intbulan2' AND JNS_BEBAN='11'
                    UNION ALL
                    SELECT 0 terima, nilai keluar from TRHOUTLAIN_BOS WHERE kd_skpd='$kd_skpd' AND MONTH(TGL_BUKTI)>='$intbulan1' AND MONTH(TGL_BUKTI)<='$intbulan2' AND JNS_BEBAN IN ('12','14')
                    )a 
                    ")->row();  $nilai_pendapatan = $sql3->nilai;         
            
            $saldo_akhirr = ($nilai_saldo+$nilai_pendapatan)-$tot_bel;
            $tot_saldo = $tot_saldo + $saldo_akhirr;
                            
                $nilai_saldo1  = empty($nilai_saldo) || $nilai_saldo == 0 ? number_format(0,"2",",",".") :number_format($nilai_saldo,"2",",",".");                    
                $nilai_pendapatan1  = empty($nilai_pendapatan) || $nilai_pendapatan == 0 ? number_format(0,"2",",",".") :number_format($nilai_pendapatan,"2",",",".");
                $tot_bel1  = empty($tot_bel) || $tot_bel == 0 ? number_format(0,"2",",",".") :number_format($tot_bel,"2",",",".");	
				$saldo_akhirr1  = empty($saldo_akhirr) || $saldo_akhirr == 0 ? number_format(0,"2",",",".") :number_format($saldo_akhirr,"2",",",".");	
				                  
                $cRet .="<tr>
						<td valign=\"top\" align=\"center\">$no </td>
						<td valign=\"top\" align=\"left\">$nm_skpd </td>
						<td valign=\"top\" align=\"center\"></td>
						<td valign=\"top\" align=\"center\">$no_lpj </td>
						<td valign=\"top\" align=\"center\">$no_sp2b </td>
						<td valign=\"top\" align=\"center\">$tgl_sp2b </td>
						<td valign=\"top\" align=\"center\">$no_sp3b </td>
						<td valign=\"top\" align=\"center\">$tgl_sp3b </td>
                        <td valign=\"top\" align=\"right\">$nilai_saldo1</td>
                        <td valign=\"top\" align=\"right\">$nilai_pendapatan1</td>
                        <td valign=\"top\" align=\"right\">$tot_bel1</td>
						<td valign=\"top\" align=\"right\">$saldo_akhirr1</td>
						</tr>";
                        
				}	
				$cRet .="<tr>
						<td valign=\"top\" align=\"center\" colspan=\"11\"><b> TOTAL </b></td>
						<td valign=\"top\" align=\"right\"><b> ".number_format($tot_saldo,"2",",",".")."</b> &nbsp;</td>
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
        
        $atas='3';
        $bawah='3';
         $kiri='3';   
         $kanan='3';
        
			$data['prev']= $cRet;
             switch ($ctk)
        {
            case 0;
			echo ("<title>REGISTER SP2B $init_nama</title>");
				echo $cRet;
				break;
            case 1;
				$this->_mpdf_margin('',$cRet,10,10,10,'L',0,'',$atas,$bawah,$kiri,$kanan);  
               break;
			case 2;        
				header("Cache-Control: no-cache, no-store, must-revalidate");
				header("Content-Type: application/vnd.ms-excel");
				header("Content-Disposition: attachment; filename=RTH_$nbulan.xls");
            
            $this->load->view('anggaran/rka/perkadaII', $data);
			break;   
		}
	}
	
	
	function register_sp2b_rekon(){
        $data['page_title']= 'REGISTER SP2B';
        $this->template->set('title', 'REGISTER SP2B');   
        $this->template->load('template','tukd/bos/rekon_register_sp2b',$data) ; 
    }
    
}    

?>