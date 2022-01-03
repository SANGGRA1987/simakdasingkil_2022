<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller master data kegiatan
 */

class Tukd_pusk extends CI_Controller {

	function __contruct()
	{	
		parent::__construct();
  
	}
	 
	function sp2b() 
    {
        $data['page_title']= 'SP2B';
        $this->template->set('title', 'SP2B');   
        $this->template->load('template','tukd/pusk/sp2b',$data) ; 
    }	 
	
	function load_sp3b_fktp(){
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
        
        $sql = "SELECT count(*) as tot from trhsp3b $where";
        $query1 = $this->db->query($sql);
        $total = $query1->row();
		
        
        $sql = " SELECT TOP $rows *,(SELECT a.nm_skpd FROM ms_skpd a where a.kd_skpd=b.kd_skpd) as nm_skpd FROM trhsp3b_blud b WHERE  
		no_sp3b NOT IN (SELECT TOP $offset no_sp3b FROM trhsp3b_blud $where order by tgl_sp3b, no_sp3b) $and
		order by tgl_sp3b, no_sp3b";
        $query1 = $this->db->query($sql);  
        $result = array(); 
        $ii = 0;
        foreach($query1->result_array() as $resulte) { 
        $row[] = array(
			'id' => $ii,
			'kd_skpd'    => $resulte['kd_skpd'],      
			'nm_skpd'    => substr($resulte['nm_skpd'],16,70),                          
			'ket'   => $resulte['keterangan'],
			'no_lpj'   => $resulte['no_lpj'],
			'no_sp3b'   => $resulte['no_sp3b'],
			'tgl_sp3b'      => $resulte['tgl_sp3b'],
			'no_sp2b'   => $resulte['no_sp2b'],
			'tgl_sp2b'      => $resulte['tgl_sp2b'],
			'status'      => $resulte['status'],
            'bulan' =>intval($resulte['bulan']),												
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
    $query1 = $this->db->query("select COUNT(number_sp2b) as nomor from trhsp3b where number_sp2b not in ('0')");
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
    	
    function select_data1_lpj_ag($lpj='',$pusk='') {

    $lpj = $this->input->post('lpj');
    $pusk = $this->input->post('kdskpd');
    $result = array();
    $cek_skpd_jkn = $this->db->query("select b.kd_skpd,b.bulan from trhsp3b a left join trhlpj_pusk b on b.kd_skpd = a.kd_skpd and a.no_lpj = b.no_lpj
        where a.no_lpj='$lpj' and a.kd_skpd='$pusk'")->row();    
    $hasil_skpd_jkn = $cek_skpd_jkn->kd_skpd;
    $hasil_bulan_jkn = $cek_skpd_jkn->bulan;
    
     if($hasil_bulan_jkn==1){
            
            $n = $this->db->query("select ISNULL(sld_awal,0) as sld_awal from ms_skpd_jkn where kd_skpd='$pusk'")->row();            
            $nilai_saldo = $n->sld_awal;
        }else{
              $sql1=$this->db->query(" SELECT ISNULL(SUM(terima-keluar),0) as nilai FROM(
                    select SUM(nilai) as terima,0 keluar from TRHINLAIN_PUSK WHERE KD_SKPD='$pusk' AND jns_beban not in ('10') AND MONTH(TGL_BUKTI)<'$hasil_bulan_jkn'
                    UNION ALL
                    select ISNULL(SUM(sld_awal),0) as terima,0 keluar from ms_skpd_jkn WHERE KD_SKPD='$pusk'
                    UNION ALL                   
                    select 0 terima,SUM(nilai) keluar from TRHOUTLAIN_PUSK WHERE KD_SKPD='$pusk' AND MONTH(TGL_BUKTI)<'$hasil_bulan_jkn'
                    UNION ALL                   
                    select 0 terima,SUM(nilai) keluar from trhtransout_pusk a join
                    trdtransout_pusk b on b.no_bukti = a.no_bukti and a.kd_skpd = b.kd_skpd
                    where a.kd_skpd='$pusk' and month(a.tgl_bukti)<'$hasil_bulan_jkn'    
                    
                    ) a
                    ")->row();    
            $nilai_saldo = $sql1->nilai;          
                     
        }       
                
        $sql = " SELECT * FROM (
                SELECT nilai terima, 0 keluar from TRHINLAIN_PUSK WHERE kd_skpd='$pusk' AND jns_beban not in ('10') AND MONTH(TGL_BUKTI)='$hasil_bulan_jkn'
                UNION ALL
                SELECT 0 terima, nilai keluar from TRHOUTLAIN_PUSK WHERE kd_skpd='$pusk' AND MONTH(TGL_BUKTI)='$hasil_bulan_jkn'
                UNION ALL
                SELECT 0 terima, b.nilai keluar FROM trhtransout_pusk a INNER JOIN trdtransout_pusk b 
                ON a.kd_skpd = b.kd_skpd and a.no_bukti=b.no_bukti 
                WHERE a.kd_skpd='$pusk' AND MONTH(a.tgl_kas)='$hasil_bulan_jkn'                 
                ) a ";        
                
                
		$hasil = $this->db->query($sql);
		$lcno=0;
		$sisa=$nilai_saldo;        
		$jumlah_terima=0;
		$jumlah_keluar=0;
       foreach ($hasil->result_array() as $rows){
		 $terima = $rows['terima'];
		 $keluar = $rows['keluar'];
		 $jumlah_terima=$jumlah_terima+$terima;
		 $jumlah_keluar=$jumlah_keluar+$keluar;
		 $sisa=$sisa+$terima-$keluar;         		                
        }   
            $row[] = array(                         						
                        'idx' => '01',
                        'uraian'  => 'Saldo Awal',   
                        'nilai'   => number_format($nilai_saldo,2),                              						                         
                        ); 
            $row[] = array(                         						
                        'idx' => '02',
                        'uraian'  => 'Pendapatan',   
                        'nilai'   => number_format($jumlah_terima,2),                              						                         
                        );
            $row[] = array(                         						
                        'idx' => '03',
                        'uraian'  => 'Belanja',   
                        'nilai'   => number_format($jumlah_keluar,2),                              						                         
                        );                                       
           
           echo json_encode($row);     
    }
	
    
    function load_sum_lpj($lpj='',$pusk='') {

    $lpj = $this->input->post('lpj');//"900/45.A/UPTD Pusk.Kec.Ptk Tenggara/I/2017";
    $pusk = $this->input->post('kode');//"1.02.01.45";
    $result = array();
    $cek_skpd_jkn = $this->db->query("select b.kd_skpd,b.bulan from trhsp3b a left join trhlpj_pusk b on b.kd_skpd = a.kd_skpd and a.no_lpj = b.no_lpj
        where a.no_lpj='$lpj' and a.kd_skpd='$pusk'")->row();    
    $hasil_skpd_jkn = $cek_skpd_jkn->kd_skpd;
    $hasil_bulan_jkn = $cek_skpd_jkn->bulan;
    //if($hasil_skpd_jkn!=""){
    //}    
         if($hasil_bulan_jkn==1){
            
            $n = $this->db->query("select ISNULL(sld_awal,0) as sld_awal from ms_skpd_jkn where kd_skpd='$pusk'")->row();            
            $nilai_saldo = $n->sld_awal;
        }else{
              $sql1=$this->db->query(" SELECT ISNULL(SUM(terima-keluar),0) as nilai FROM(
                    select SUM(nilai) as terima,0 keluar from TRHINLAIN_PUSK WHERE KD_SKPD='$pusk' AND jns_beban not in ('10') AND MONTH(TGL_BUKTI)<'$hasil_bulan_jkn'
                    UNION ALL
                    select ISNULL(SUM(sld_awal),0) as terima,0 keluar from ms_skpd_jkn WHERE KD_SKPD='$pusk'
                    UNION ALL                   
                    select 0 terima,SUM(nilai) keluar from TRHOUTLAIN_PUSK WHERE KD_SKPD='$pusk' AND MONTH(TGL_BUKTI)<'$hasil_bulan_jkn'
                    UNION ALL                   
                    select 0 terima,SUM(nilai) keluar from trhtransout_pusk a join
                    trdtransout_pusk b on b.no_bukti = a.no_bukti and a.kd_skpd = b.kd_skpd
                    where a.kd_skpd='$pusk' and month(a.tgl_bukti)<'$hasil_bulan_jkn'    
                    
                    ) a
                    ")->row();    
            $nilai_saldo = $sql1->nilai;          
                     
        }       
                
        $sql = " SELECT * FROM (
                SELECT nilai terima, 0 keluar from TRHINLAIN_PUSK WHERE kd_skpd='$pusk' AND jns_beban not in ('10') AND MONTH(TGL_BUKTI)='$hasil_bulan_jkn'
                UNION ALL
                SELECT 0 terima, nilai keluar from TRHOUTLAIN_PUSK WHERE kd_skpd='$pusk' AND MONTH(TGL_BUKTI)='$hasil_bulan_jkn'
                UNION ALL
                SELECT 0 terima, b.nilai keluar FROM trhtransout_pusk a INNER JOIN trdtransout_pusk b 
                ON a.kd_skpd = b.kd_skpd and a.no_bukti=b.no_bukti 
                WHERE a.kd_skpd='$pusk' AND MONTH(a.tgl_kas)='$hasil_bulan_jkn'                 
                ) a ";        
                
		$hasil = $this->db->query($sql);
		$lcno=0;
		$sisa=$nilai_saldo;        
		$jumlah_terima=0;
		$jumlah_keluar=0;
        $row = array();
       foreach ($hasil->result_array() as $rows){
		 $terima = $rows['terima'];
		 $keluar = $rows['keluar'];
         
		 $jumlah_terima=$jumlah_terima+$terima;
		 $jumlah_keluar=$jumlah_keluar+$keluar;
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
    
    function setuju_sp3b() {
    $sp3b = $this->input->post('no_sp3b');
    $sp2b = $this->input->post('no_sp2b');
    $number_sp2b = $this->input->post('number_sp2b');
    $tgl_sah = $this->input->post('tgl_sah');
    $kdskpd = $this->input->post('kd_skpd');
	$sql = "UPDATE trhsp3b SET number_sp2b='$number_sp2b',status_bud='1',tgl_sp2b='$tgl_sah',no_sp2b='$sp2b' WHERE no_sp3b='$sp3b' AND kd_skpd='$kdskpd'";
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
	$sql = "UPDATE trhsp3b SET number_sp2b='0',status_bud='0',tgl_sp2b='',no_sp2b='' WHERE no_sp3b='$sp3b' AND kd_skpd='$kdskpd'";
	$asg = $this->db->query($sql);  
	if ($asg > 0){  	
                    echo '2';
                    exit();
               } else {
                    echo '0';
                    exit();
               }
	}
    
    function cetak_sp2b_fktp(){        
        $nomor1 = str_replace('abcdefghij','/',$this->uri->segment(6));
        $nomorsp2b  = str_replace('123456789',' ',$nomor1);
		$pusk  = $this->uri->segment(4);
        $lcskpd = substr($pusk,0,7).".00";
        $ttd1   = str_replace('a',' ',$this->uri->segment(3));        
		$ctk    =   $this->uri->segment(5);
        
		$ketsaldo = ''; 
		$nilai_saldo = 0;                				        
        
        $skpd = $this->tukd_model->get_nama($lcskpd,'nm_skpd','ms_skpd','kd_skpd');
		$nmpusk = $this->tukd_model->get_nama($pusk,'nm_bidang','ms_bidang','kd_bidskpd');        
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
		        
        $tgll = $this->db->query("select tgl_sp2b,no_lpj,no_sp3b,tgl_sp3b,bulan from trhsp3b where no_sp2b='$nomorsp2b' and kd_skpd='$pusk'")->row();            
            $tgl_sp2b = $tgll->tgl_sp2b;
            $tgl_sp2b = $this->tukd_model->tanggal_format_indonesia($tgl_sp2b);
            $no_lpjj =  $tgll->no_lpj;
            $no_sp3bb = $tgll->no_sp3b;
            $tgl_sp3b = $tgll->tgl_sp3b;
            $tgl_sp3b = $this->tukd_model->tanggal_format_indonesia($tgl_sp3b);
            $nbulan   = $tgll->bulan;
            
            if($nbulan==1){
			$ketsaldo = "Awal";
            $n = $this->db->query("select ISNULL(sld_awal,0) as sld_awal from ms_skpd_jkn where kd_skpd='$pusk'")->row();            
            $nilai_saldo = $n->sld_awal;
		      }else{
			$ketsaldo = "Lalu";			
		    $n = $this->db->query("SELECT ISNULL(SUM(terima-keluar),0) as nilai FROM(
                    select SUM(nilai) as terima,0 keluar from TRHINLAIN_PUSK WHERE KD_SKPD='$pusk' AND jns_beban not in ('10') AND MONTH(TGL_BUKTI)<'$nbulan'
                    UNION ALL
                    select ISNULL(SUM(sld_awal),0) as terima,0 keluar from ms_skpd_jkn WHERE KD_SKPD='$pusk'
                    UNION ALL                   
                    select 0 terima,SUM(nilai) keluar from TRHOUTLAIN_PUSK WHERE KD_SKPD='$pusk' AND MONTH(TGL_BUKTI)<'$nbulan'
                    UNION ALL                   
                    select 0 terima,SUM(nilai) keluar from trhtransout_pusk a join
                    trdtransout_pusk b on b.no_bukti = a.no_bukti and a.kd_skpd = b.kd_skpd
                    where a.kd_skpd='$pusk' and month(a.tgl_bukti)<'$nbulan'    
                    
                    ) a")->row();            
            $nilai_saldo = $n->nilai;
		    
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
                        <TD align="center" width="51%" rowspan="3"><b>SURAT PENGESAHAN <br>PENDAPATAN DAN BELANJA (SP2B)</b></TD>					
					</TR>
                    <TR>
						<TD align="left" width="3%">Nomor SP3B </TD>						
                        <TD align="left" width="1%">: </TD>
                        <TD align="left" width="46%" style="border-right:solid 1px black;">'.$no_sp3bb.'</TD>
                        </TR>
                    <TR>
						<TD align="left" width="3%">Tanggal</TD>						
                        <TD align="left" width="1%">: </TD>
                        <TD align="left" width="46%" style="border-right:solid 1px black;">'.$tgl_sp3b.'</TD>                        
					</TR>
                    <TR>
						<TD align="left" width="3%">SKPD</TD>						
                        <TD align="left" width="1%">: </TD>
                        <TD align="left" width="46%" style="border-right:solid 1px black;">'.$skpd.'</TD>
                        <TD align="left" width="51%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nomor &nbsp;&nbsp;: '.$nomorsp2b.'</TD>
					</TR>	
                    <TR>
						<TD align="left" width="3%">FKTP</TD>						
                        <TD align="left" width="1%">: </TD>
                        <TD align="left" width="46%" style="border-right:solid 1px black;">'.$nmpusk.'</TD>
                        <TD align="left" width="51%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tanggal : '.$tgl_sp2b.'</TD>
					</TR>
                    <TR>
						<TD colspan="3" style="border-right:solid 1px black;"><br></TD>
                        <TD ><br></TD>
					</TR>
                    																			
					</TABLE>';			
                    
                    $sql = " SELECT * FROM (
				SELECT nilai terima, 0 keluar from TRHINLAIN_PUSK WHERE kd_skpd='$pusk' AND MONTH(TGL_BUKTI)='$nbulan' AND jns_beban not in ('10')
				UNION ALL
				SELECT 0 terima, nilai keluar from TRHOUTLAIN_PUSK WHERE kd_skpd='$pusk' AND MONTH(TGL_BUKTI)='$nbulan'
				UNION ALL
				SELECT 0 terima, b.nilai keluar FROM trhtransout_pusk a INNER JOIN trdtransout_pusk b 
				ON a.kd_skpd = b.kd_skpd and a.no_bukti=b.no_bukti 
				WHERE a.kd_skpd='$pusk' AND MONTH(a.tgl_kas)='$nbulan'                 
				) a ";
		$hasil = $this->db->query($sql);
		$lcno=0;
		$sisa=$nilai_saldo;        
		$jumlah_terima=0;
		$jumlah_keluar=0;
       foreach ($hasil->result() as $row){
		 $terima = $row->terima;
		 $keluar = $row->keluar;
		 $jumlah_terima=$jumlah_terima+$terima;
		 $jumlah_keluar=$jumlah_keluar+$keluar;
		 $sisa=$sisa+$terima-$keluar;         
		 $terima1 = empty($terima) || $terima == 0 ? '' :number_format($terima,'2','.',',');
		 $keluar1 = empty($keluar) || $keluar == 0 ? '' :number_format($keluar,'2','.',',');
        }
        
        
        //$sql_rtgs = $this->db->query("SELECT nilai from TRHOUTLAIN_PUSK WHERE kd_skpd='$pusk' AND MONTH(TGL_BUKTI)='$nbulan'")->row();
        //$nilai_rtgs = $sql_rtgs->nilai;                     
                    		
            	$cRet .='<TABLE style="border-collapse:collapse; border-top:none; border-left:solid 1px black; border-right:solid 1px black; border-bottom:solid 1px black; font-size:13px;" width="100%">
					<TR>
						<TD align="left" >Untuk bulan : <b>'.strtoupper($this->tukd_model->getBulan($nbulan)).'</b></TD>						
						<TD align="left" >Tahun Anggaran : <b>'.$thn.'</b></TD>						
					</TR>					
					</TABLE>';	
                        
			$cRet .='<TABLE style="border-collapse:collapse; border-top:none; border-left:solid 1px black; border-right:solid 1px black; border-bottom:solid 1px black; font-size:13px;" width="100%">
					<TR>
						<TD align="left" width="100%" colspan="3"><br></TD>						
					</TR>
                    <TR>
						<TD align="left" width="100%" colspan="3">Telah disahkan pendapatan dan belanja dana kapitasi JKN sejumlah :</TD>						
					</TR>	
					<TR>
						<TD align="left" width="10%"></TD>						
						<TD align="left" width="25%">1. &nbsp; Saldo '.$ketsaldo.'</TD>						
						<TD align="left" width="65%">Rp. '.number_format($nilai_saldo,'2','.',',').'</TD>						
					</TR>
					<TR>
						<TD align="left" width="10%"></TD>						
						<TD align="left" width="25%">2. &nbsp; Pendapatan</TD>						
						<TD align="left" width="65%">Rp. '.number_format($jumlah_terima,'2','.',',').'</TD>						
					</TR>	
					<TR>
						<TD align="left" width="10%"></TD>						
						<TD align="left" width="25%">3. &nbsp; Belanja</TD>						
						<TD align="left" width="65%">Rp. '.number_format($jumlah_keluar,'2','.',',').'</TD>						
					</TR>	
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

			$data['prev']= 'SP2B';
             switch ($ctk)
        {
            case 0;
			echo ("<title>SURAT SP2B</title>");
				echo $cRet;
				break;
            case 1;
				//$this->_mpdf('',$cRet,10,10,10,10,1,'');
				$this->_mpdf_margin('',$cRet,10,10,10,'P',0,'',$atas,$bawah,$kiri,$kanan);               
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

    function load_dtrsp3b_blud() {           
        $kriteria = $this->input->post('no');        
        $skpd = $this->input->post('skpd');//$this->session->userdata('kdskpd');
        
        $sql = "SELECT a.*, left(a.kd_rek5,7) as rek, (select nm_rek5 from ms_rek5_blud where kd_rek5 = left(a.kd_rek5,7)) as nm_rek, a.nm_rek5
        from trsp3b_blud a where a.no_sp3b = '$kriteria' and left(a.kd_skpd,7)=left('$skpd',7) order by a.no_sp3b";
        
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'no_sp3b' => $resulte['no_sp3b'],
                        'no_lpj' => $resulte['no_lpj'],
                        'no_bukti' => $resulte['no_bukti'],
                        'kd_skpd' => $resulte['kd_skpd'],
                        'kd_rek5' => $resulte['rek'],
                        'kd_rek7' => $resulte['kd_rek5'],
                        'nm_rek7' => $resulte['nm_rek5'],
                        'nm_rek' => $resulte['nm_rek'],
                        //'nilai' =>  number_format($resulte['nilai'],2,'.',','),
                        'nilai' => $resulte['nilai'],
                        'kd_kegiatan' => $resulte['kd_kegiatan']
                        );
                        $ii++;
        }
           
        echo json_encode($result);
           
    }  
    function jumlah_belanjasp3b() {           
        $kriteria = $this->input->post('no');        
        $skpd = $this->input->post('skpd');//$this->session->userdata('kdskpd');
        
        $sql = "SELECT a.*, left(a.kd_rek5,7) as rek, (select nm_rek5 from ms_rek5_blud where kd_rek5 = left(a.kd_rek5,7)) as nm_rek, a.nm_rek5
        from trsp3b_blud a where a.no_sp3b = '$kriteria' and left(a.kd_skpd,7)=left('$skpd',7) order by a.no_sp3b";
        
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        $nilai=0;
        foreach($query1->result_array() as $resulte)
        { 
            
            $nilai=$nilai+$resulte['nilai'];
        }
            $result[] = array(
                        'nilai' => $nilai
                        );           
        echo json_encode($result);
           
    }    

    function cetak_sp3b_blud($lcskpd='',$nbulan='',$ctk=''){
        $pusk = $this->uri->segment(6);
        $nip2 = str_replace('123456789',' ',$this->uri->segment(7));
        $ketsaldo = ''; 
        $tanggal_ttd = $this->tukd_model->tanggal_format_indonesia($this->uri->segment(8));
        $atas = $this->uri->segment(9);
        $bawah = $this->uri->segment(10);
        $kiri = $this->uri->segment(11);
        $kanan = $this->uri->segment(12);   
        $nosp3b = str_replace('hhh','/',$this->uri->segment(13));
        $sp3b = $this->uri->segment(14);
        $nilai_saldo = 0;        
        
  $nilai_saldo = 0;        
        $saldo=0;
        $n_saldo=0;
        
            
            $n = $this->db->query("SELECT ISNULL(saldo_lalu,0) as sld_awal from ms_skpd_blud where kd_skpd='$pusk'")->row();            
            $saldo = $n->sld_awal;
        
              $sql1=$this->db->query(" SELECT sum(isnull(c.terima,0))-sum(isnull(c.keluar,0)) nilai from(
                SELECT
                case when left(a.kd_rek5,1)=4 then SUM (isnull(a.nilai,0)) end as terima,
                case when left(a.kd_rek5,1)=5 then SUM (isnull(a.nilai,0)) end as keluar
                FROM
                trsp3b_blud a left join trhsp3b_blud b
                on a.kd_skpd=b.kd_skpd and a.no_sp3b=b.no_sp3b 
                WHERE b.kd_skpd = '$pusk'
                AND month(b.tgl_sp3b) < '$nbulan'
                group by left(a.kd_rek5,1))c
                    ")->row();    
            $nilai_saldo = $sql1->nilai;
            $n_saldo = $sql1->nilai;    
                 
        
        if($nbulan==1){
                $nilai_saldo = $saldo; 
                $ketsaldo = "Awal";
        }else{
                $nilai_saldo = $saldo+$n_saldo; 
                $ketsaldo = "Lalu";    
        }
             
        
        $skpd = $this->tukd_model->get_nama($lcskpd,'nm_skpd','ms_skpd','kd_skpd');
        $nmpusk = $this->tukd_model->get_nama($pusk,'nm_bidang','ms_bidang','kd_bidskpd');
        $cekno_lpjj = $this->db->query("select no_lpj from trhsp3b_blud where no_sp3b='$nosp3b'")->row();
        $no_lpjj = $cekno_lpjj->no_lpj;
          $sqlsc="SELECT tgl_rka,provinsi,kab_kota,daerah,thn_ang FROM sclient WHERE kd_skpd=left('$lcskpd',7)+'.00'";
                 $sqlsclient=$this->db->query($sqlsc);
                 foreach ($sqlsclient->result() as $rowsc)
                 {
                    $kab     = $rowsc->kab_kota;
                    $prov     = $rowsc->provinsi;
                    $daerah  = $rowsc->daerah;
                    $thn     = $rowsc->thn_ang;
                 }
        //$thn=$this->userdata->session('pcThang');
        $sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab,pangkat FROM ms_ttd where nip='$nip2'";
                 $sqlttd=$this->db->query($sqlttd1);
                 foreach ($sqlttd->result() as $rowttd)
                {
                    $nip=$rowttd->nip;                    
                    $nama= $rowttd->nm;
                    $jabatan  = $rowttd->jab;
                    $pangkat  = $rowttd->pangkat;
                }       
            
            $cRet ='<TABLE style="border-collapse:collapse; font-size:14px" width="100%" border="1" cellspacing="0" cellpadding="1" align=center>
                    <TR>
                        <TD align="center" ><B><br>
                                                PEMERINTAH KABUPATEN SANGGAU <br>
                                                BADAN KEUANGAN DAERAH (BKD)</b><br>
                                                Jl. Letnan Jendral Sutoyo, Telp/Fax (0561) 732509 / 741641 <br>KABUPATEN SANGGAU <br><br>
                                                                
                        </TD>
                    </TR>                   
                    </TABLE>';          
            $cRet .='<TABLE style="border-collapse:collapse; border-top:none; border-left:solid 1px black; border-right:solid 1px black; border-bottom:solid 1px black; font-size:13px;" width="100%">
                    <TR>
                        <TD align="left" width="50%" >
                            <table style="font-size:13px">
                                <tr>
                                    <td>No SP3B</td>
                                    <td>:</td>
                                    <td>'.$nosp3b.'</td>
                                </tr>
                                <tr>
                                    <td>Tanggal</td>
                                    <td>:</td>
                                    <td>'.$tanggal_ttd.'</td>
                                </tr>
                                <tr>
                                    <td>SKPD</td>
                                    <td>:</td>
                                    <td>Dinas Kesehatan</td>
                                </tr>
                                <tr>
                                    <td>BLUD</td>
                                    <td>:</td>
                                    <td>'.$nmpusk.'</td>
                                </tr>
                            </table>
                        </TD> 
                        <TD style="border-left:solid 1px black;" width="50%" ><center><b>SURAT PENGESAHAN <br>PENDAPATAN DAN BELANJA BLUD</b></center> 
                            <table style="font-size:13px">
                                <tr>
                                    <td>&nbsp;&nbsp;</td>
                                    <td>No SP2B</td>
                                    <td>:</td>
                                    <td>'.str_replace('SP3B','SP2B',$nosp3b).'</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;&nbsp;</td>
                                    <td>Tanggal</td>
                                    <td>:</td>
                                    <td>'.$tanggal_ttd.'</td>
                                </tr>
                            </table>
                        </TD>                    
                    </TR> 

                    </TABLE>';              
            
        $sql="SELECT sum(isnull(c.terima,0)) terima,sum(isnull(c.keluar,0)) keluar from(
                SELECT
                case when left(kd_rek5,1)=4 then SUM (isnull(nilai,0)) end as terima,
                case when left(kd_rek5,1)=5 then SUM (isnull(nilai,0)) end as keluar
                FROM
                trsp3b_blud
                WHERE kd_skpd = '$pusk'
                AND no_sp3b = '$nosp3b'
                group by left(kd_rek5,1))c";
            $exe=$this->db->query($sql)->row();
            $pendapatan=$exe->terima;
            $belanja=$exe->keluar;
            $saldo=$nilai_saldo+$pendapatan-$belanja;
            $cRet .='<TABLE style="border-collapse:collapse; border-top:none; border-left:solid 1px black; border-right:solid 1px black; border-bottom:solid 1px black; font-size:13px;" width="100%">
                    <TR>
                        <TD align="left" >Untuk bulan : <b>'.strtoupper($this->tukd_model->getBulan($nbulan)).'</b></TD>                        
                        <TD align="left" >Tahun Anggaran : <b>'.$thn.'</b></TD>                     
                    </TR>                   
                    </TABLE>';                              
            $cRet .='<TABLE style="border-collapse:collapse; border-top:none; border-left:solid 1px black; border-right:solid 1px black; border-bottom:solid 1px black; font-size:13px;" width="100%">
                    <TR>
                        <TD align="left" width="100%" colspan="3">Telah disahkan pendapatan dan dana BLUD sejumlah :</TD>                      
                    </TR>   
                    <TR>
                        <TD align="left" width="10%"></TD>                      
                        <TD align="left" width="25%">1. &nbsp; Saldo '.$ketsaldo.'</TD>                     
                        <TD align="left" width="65%">Rp. '.number_format($nilai_saldo,'2','.',',').'</TD>                       
                    </TR>
                    <TR>
                        <TD align="left" width="10%"></TD>                      
                        <TD align="left" width="25%">2. &nbsp; Pendapatan</TD>                      
                        <TD align="left" width="65%">Rp. '.number_format($pendapatan,'2','.',',').'</TD>                     
                    </TR>   
                    <TR>
                        <TD align="left" width="10%"></TD>                      
                        <TD align="left" width="25%">3. &nbsp; Belanja</TD>                     
                        <TD align="left" width="65%">Rp. '.number_format($belanja,'2','.',',').'</TD>                     
                    </TR>   
                    <TR>
                        <TD align="left" width="10%"></TD>                      
                        <TD align="left" width="25%">4. &nbsp; Saldo Akhir</TD>                     
                        <TD align="left" width="65%">Rp. '.number_format($saldo,'2','.',',').'</TD>                      
                    </TR>   
                    </TABLE>';  

 
       
                                                
            $cRet .='<TABLE style="font-size:13px;" width="100%" align="center">
                    <TR>
                        <TD width="50%" align="center" ></TD>
                        <TD width="50%" align="center" >Sanggau, '.$tanggal_ttd.'</TD>
                    </TR>
                    <TR>
                        <TD width="50%" align="center" ></TD>
                        <TD width="50%" align="center" >'.$jabatan.'</TD>
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

            $data['prev']= 'SP3B';
             switch ($ctk)
        {
            case 0;
            echo ("<title>SURAT SP3B</title>");
                echo $cRet;
                break;
            case 1;
                //$this->_mpdf('',$cRet,10,10,10,10,1,'');
                $this->_mpdf_margin('',$cRet,10,10,10,'P',0,'',$atas,$bawah,$kiri,$kanan);
               //$this->_mpdf_margin('',$cRet,10,10,10,'L',0,'',$atas,$bawah,$kiri,$kanan);
               break;
        }
    }    	
}