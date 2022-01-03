<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 */
class Sp2d extends CI_Controller
{
	
	function __contruct(){	 
		parent::__construct();
    
	}

	function input_sp2d(){
        $data['page_title']= 'INPUT SP2D';
        $this->template->set('title', 'INPUT SP2D LS');   
        $this->template->load('template','tukd/sp2d/input_sp2d',$data) ; 
    }
    function no_urut_sp2d(){
        $skpd     = $this->input->post('skpd');
        $bln      = $this->input->post('bln');
        $jns      = $this->input->post('jns');
        if($jns==1 || $jns==2 || $jns==3 ){                                      
            $q = $this->db->query(" SELECT MAX(nokas)+1 AS nomor FROM(
                SELECT urut AS nokas FROM trhsp2d WHERE kd_skpd='$skpd' AND jns_spp='jns'
                )zzz
             ");
        }else{
            $q = $this->db->query(" SELECT MAX(nokas)+1 AS nomor FROM(
                SELECT urut AS nokas FROM trhsp2d WHERE kd_skpd='$skpd' AND (jns_spp='4' or jns_spp='5' or jns_spp='6' or jns_spp='8') 
                )zzz
             ");
        }
        $h = array();
        foreach($q->result_array() as $h)
        if (empty($h['nomor'])){
            $h = array('nomor' => '000001');
        }elseif(strlen($h['nomor'])==1){
            $h = array('nomor' => '00000'.$h['nomor']);
        }elseif(strlen($h['nomor'])==2){
            $h = array('nomor' => '0000'.$h['nomor']);
        }elseif(strlen($h['nomor'])==3){
            $h = array('nomor' => '000'.$h['nomor']);
        }elseif(strlen($h['nomor'])==4){
            $h = array('nomor' => '00'.$h['nomor']);
        }elseif(strlen($h['nomor'])==5){
            $h = array('nomor' => '0'.$h['nomor']);
        }else{
            $h = array('nomor' => $h['nomor']);
        }                         
                             
        echo json_encode($h);  
    }

    function cek_status_sp2d(){
      $skpd           = $this->input->post('skpd');
      $nomor_sp2d     = $this->input->post('nomor');

      $status_bud = $this->tukd_model->get_nama($nomor_sp2d,'status_bud','trhsp2d','no_sp2d');
      $no_kas_bud = $this->tukd_model->get_nama($nomor_sp2d,'no_kas_bud','trhsp2d','no_sp2d');
      $status_terima = $this->tukd_model->get_nama($nomor_sp2d,'status_terima','trhsp2d','no_sp2d');
      $nm_skpd = $this->tukd_model->get_nama($skpd,'nm_skpd','ms_skpd','kd_skpd');
      
      $dataSp2d = array('status_bud' => $status_bud,
                        'no_kas_bud' => $no_kas_bud,
                        'status_terima' => $status_terima,
                        'nm_skpd' => $nm_skpd
                         );
      echo json_encode($dataSp2d);
    }

    function hapus_sp2d(){
      $skpd           = $this->input->post('skpd');
      $nomor_sp2d     = $this->input->post('nomor');
      $no_spm         = $this->tukd_model->get_nama($nomor_sp2d,'no_spm','trhsp2d','no_sp2d');

      $sql = "DELETE FROM trhsp2d WHERE no_sp2d = '$nomor_sp2d'";
      $query = $this->db->query($sql);

      $sql2 = "DELETE FROM config_valspm WHERE no_spm = '$no_spm'";
      $this->db->query($sql2);

      $sql3 = "UPDATE trhspm SET status = '0' WHERE no_spm = '$no_spm'";
      $this->db->query($sql3);

      if ($query) {
          $sp2d = array('pesan' => '1');
      } else {
          $sp2d = array('pesan' => '0');
      }    
      echo json_encode($sp2d);
    }

    function load_sp2d() {
      $result = array();
      $row = array();
      $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
      $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
      $offset = ($page-1)*$rows;
      $id  = $this->session->userdata('pcUser');
      $cariskpd = $this->input->post('cariskpd');
      $kriteria = $this->input->post('cari');
      $where = '';
      $where2 = '';
        

        if ($cariskpd <> '' && $kriteria == '') {
        	$where = "AND kd_skpd = '$cariskpd' ";
          $where2 = "WHERE kd_skpd = '$cariskpd' ";
        } else if($cariskpd <> '' && $kriteria <> ''){
        	$where = "AND kd_skpd = '$cariskpd' AND (upper(no_sp2d) like upper('%$kriteria%') or tgl_sp2d like '%$kriteria%' or upper(keperluan) like upper('%$kriteria%'))";
          $where2 = "WHERE kd_skpd = '$cariskpd' AND (upper(no_sp2d) like upper('%$kriteria%') or tgl_sp2d like '%$kriteria%' or upper(keperluan) like upper('%$kriteria%'))";
        } else if($cariskpd == '' && $kriteria <> ''){
        	$where = "AND (upper(no_sp2d) like upper('%$kriteria%') or tgl_sp2d like '%$kriteria%' or upper(keperluan) like upper('%$kriteria%'))";
          $where2 = "WHERE (upper(no_sp2d) like upper('%$kriteria%') or tgl_sp2d like '%$kriteria%' or upper(keperluan) like upper('%$kriteria%'))";
        } else {
        	$where = '';
          $where2 = '';
        }
        
        $sql = "SELECT count(*) as tot from (select a.* from trhsp2d a inner join trhspp b on a.no_spp=b.no_spp and a.kd_skpd=b.kd_skpd inner join trhspd c on a.no_spd=c.no_spd) z $where2" ;
        $query1 = $this->db->query($sql);
        $total = $query1->row();
        
        $sql = "SELECT TOP $rows * FROM 
                (select a.* , '' as jns_spd FROM trhsp2d a 
                inner join trhspp b on a.no_spp=b.no_spp and a.kd_skpd=b.kd_skpd) z 
                WHERE z.no_sp2d NOT IN(SELECT TOP $offset no_sp2d from trhsp2d WHERE kd_skpd = '$cariskpd' $where order by tgl_sp2d,no_sp2d) $where ORDER by z.tgl_sp2d,z.urut";
        // print_r($sql);die();
        $query1 = $this->db->query($sql);  
        $result = array(); 
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           if ($resulte['status_terima']=='1'){
				$s='Sudah Diterima';
			}else{
				$s='Belum Diterima';			
			}

			if ($resulte['status_bud']=='1'){
				$s_bud='Sudah Cair';
			}else{
				$s_bud='Belum Cair';			
			}

			switch ($resulte['jns_spp']) {
				case '1':
					$jenis = 'Uang Persediaan (UP)';
					break;
				case '2':
					$jenis = 'Ganti Uang Persediaan (GU)';
					break;
				case '3':
					$jenis = 'Tambah Uang (TU)';
					break;
				case '4':
					$jenis = 'Langsung (LS) - Gaji';
					break;
				case '5':
					$jenis = '';
					break;
				case '6':
					$jenis = 'Langsung (LS) - Barang dan Jasa';
					break;
				case '7':
					$jenis = '';
					break;
				case '8':
					$jenis = 'Langsung (LS) - Pihak Ketiga Lainnya';
					break;
				default:
					$jenis = '';
					break;
			}

            $row[] = array(
                        'id' => $ii,
                        'no_sp2d' => $resulte['no_sp2d'],
                        'tgl_sp2d' => $resulte['tgl_sp2d'],
                        'no_spm' => $resulte['no_spm'],
                        'tgl_spm' => $resulte['tgl_spm'],        
                        'no_spp' => $resulte['no_spp'],
                        'tgl_spp' => $resulte['tgl_spp'],
                        'kd_skpd' => $resulte['kd_skpd'],
                        'nm_skpd' => $resulte['nm_skpd'],    
                        'jns_spp' => $resulte['jns_spp'],
                        'keperluan' => $resulte['keperluan'],
                        'bulan' => $resulte['bulan'],
                        'no_spd' => $resulte['no_spd'],
                        'bank' => $resulte['bank'],
                        'nmrekan' => $resulte['nmrekan'],
                        'no_rek' => $resulte['no_rek'],
                        'npwp' => $resulte['npwp'],
                        'bud_sts' => $resulte['status_bud'],
                        'sp2d_batal' => $resulte['sp2d_batal'],
                        'jenis_beban' => $resulte['jenis_beban'],
                        'status' =>$s,                                                                           
                        'status_bud' =>$s_bud,
                        'nokasbud' =>$resulte['no_kas_bud'],						
                        'dkasbud' =>$resulte['tgl_kas_bud'],							
                        'jns_spd' =>$resulte['jns_spd'],
                        'urut' =>$resulte['urut'],
                        'nilai' =>number_format($resulte['nilai'],2),
                        'jenis' =>$jenis

                        );
                        $ii++;
        }
           
        $result["total"] = $total->tot;
        $result["rows"] = $row; 
        echo json_encode($result);
       $query1->free_result();	   
	}

	function skpd_sp2d() {
	    $idx = $this->session->userdata('pcUser');	
        $sql = "SELECT b.kd_skpd,b.nm_skpd FROM trhspm b where status != 1 and b.kd_skpd in (select kd_skpd from user_bud where user_id='$idx')
        group by b.kd_skpd,b.nm_skpd        
        order by b.kd_skpd";
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

	function nospm_sp2d($skkpd=''){
		$id  = $this->session->userdata('pcUser');        
        $lccr = $this->input->post('q');
		$tanggal=date("d");
		$bulan=date("m");
		if($bulan<10){
			$bulan = str_replace("0","",$bulan);
			$bulan = $bulan-1;
		}
		
    $sql = "SELECT a.no_spm, a.tgl_spm, a.no_spp, a.tgl_spp, a.kd_skpd,a.nm_skpd,a.jns_spp,
     a.keperluan, a.bulan, a.no_spd, a.bank, a.nmrekan, a.no_rek, a.npwp,
     (case when jns_beban='51' then 'BTL' else 'BL' end)jns_spd  FROM trhspm a inner join trhspd b on a.no_spd =b.no_spd inner join config_valspm c on a.no_spm=c.no_spm 
    where a.status = '0' and c.status = '1' AND a.kd_skpd IN (SELECT kd_skpd FROM user_bud WHERE user_id='$id')
    AND a.kd_skpd='$skkpd' and (upper(a.no_spm) like upper('%$lccr%') or upper(a.kd_skpd) like upper('%$lccr%')) order by a.kd_skpd,a.no_spm";//no_spm not in (select no_spm from trhsp2d where no_spm<>'$lccr') and
	
	// print_r($sql);die();
		$query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte){ 
            $result[] = array(
                        'id' => $ii,
                        'no_spm' => $resulte['no_spm'],
                        'tgl_spm' => $resulte['tgl_spm'],        
                        'no_spp' => $resulte['no_spp'],
                        'tgl_spp' => $resulte['tgl_spp'],
                        'kd_skpd' => $resulte['kd_skpd'],
                        'nm_skpd' => $resulte['nm_skpd'],    
                        'jns_spp' => $resulte['jns_spp'],
                        'keperluan' => $resulte['keperluan'],
                        'bulan' => $resulte['bulan'],
                        'no_spd' => $resulte['no_spd'],
						'jns_spd' => $resulte['jns_spd'],
                        'bank' => $resulte['bank'],
                        'nmrekan' => $resulte['nmrekan'],
                        'no_rek' => $resulte['no_rek'],
                        'npwp' => $resulte['npwp']
                        );
                        $ii++;
        }
           
        echo json_encode($result);
    	 $query1->free_result();   
	}

	function cariskpd() {      
		$sql = "SELECT b.kd_skpd,b.nm_skpd FROM trhsp2d b GROUP BY b.kd_skpd,b.nm_skpd ORDER BY b.kd_skpd";
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

	function cetak_sp2d(){
	$client = $this->ClientModel->clientData();
	$thn_ang = $this->session->userdata('pcThang');
    $kab = $client->kab_kota;
    $daerah = $client->daerah;
	$nomor = str_replace('-','/',$this->uri->segment(3));
	$cRet = '';
	$skpd = $this->uri->segment(4);
	$ttd_bud = urldecode($this->uri->segment(5));
	$nm_skpd = $this->rka_model->get_nama($skpd,'nm_skpd','ms_skpd','kd_skpd');
	$nm_ttd = $this->rka_model->get_nama($ttd_bud,'nama','ms_ttd','nip');
	$jns = $this->rka_model->get_nama($nomor,'jns_spp','trhsp2d','no_sp2d');
	$no_spp = $this->rka_model->get_nama($nomor,'no_spp','trhsp2d','no_sp2d');
	$no_spm = $this->rka_model->get_nama($nomor,'no_spm','trhsp2d','no_sp2d');
	$tgl_sp2d = $this->rka_model->get_nama($nomor,'tgl_sp2d','trhsp2d','no_sp2d');
	$tgl_spm = $this->rka_model->get_nama($nomor,'tgl_spm','trhsp2d','no_sp2d');
	$nilai_sp2d = $this->rka_model->get_nama($nomor,'nilai','trhsp2d','no_sp2d');
	$keperluan = $this->rka_model->get_nama($nomor,'keperluan','trhsp2d','no_sp2d');
	$nmrekan = $this->rka_model->get_nama($nomor,'nmrekan','trhsp2d','no_sp2d');
	$bank = $this->rka_model->get_nama($nomor,'bank','trhsp2d','no_sp2d');
	$no_rek = $this->rka_model->get_nama($nomor,'no_rek','trhsp2d','no_sp2d');
	$npwp = $this->rka_model->get_nama($nomor,'npwp','trhsp2d','no_sp2d');
	$nm_bank = $this->rka_model->get_nama($bank,'nama','ms_bank','kode');
	$query = "SELECT nip,nama FROM ms_ttd WHERE kd_skpd = '$skpd' AND kode = 'BK'";
	$sql = $this->db->query($query)->row();
	$nip_bk = $sql->nip;
	$nama_bk = $sql->nama;
	$nama = 'Bendahara Pengeluaran SKPD '.$nm_skpd.' ('.$nama_bk.')';
    $npwpBend = $this->rka_model->get_nama($skpd,'npwp','ms_skpd','kd_skpd');
    $rekBend = $this->rka_model->get_nama($skpd,'rekening','ms_skpd','kd_skpd');
    $bankBend = $this->rka_model->get_nama($skpd,'bank','ms_skpd','kd_skpd');
    $nmBend = $this->rka_model->get_nama($skpd,'bend_pengeluaran','ms_skpd','kd_skpd');
    $nmbankBend = $this->rka_model->get_nama($bankBend,'nama','ms_bank','kode');
    $kd_sub_kegiatan = $this->rka_model->get_nama($no_spp,'kd_subkegiatan','trhspp','no_spp');
    $status_anggaran = $this->tukd_model->status_anggaran($skpd);
    $sqlAng = $this->db->query("SELECT SUM($status_anggaran) as anggaran FROM trdrka WHERE kd_skpd = '$skpd' AND kd_subkegiatan = '$kd_sub_kegiatan'")->row();
    $pagu = $sqlAng->anggaran;
    



	switch ($jns) {
		case '1':
            $npwp_Bend = $npwpBend;
            $rek_Bend = $rekBend;
            $bank_Bend = $bankBend;
            $nm_Bend = $nmBend;
            $nmbank_Bend = $nmbankBend;
            $pagu_anggaran = 0;
			break;
		case '2':
			$npwp_Bend = $npwpBend;
            $rek_Bend = $rekBend;
            $bank_Bend = $bankBend;
            $nm_Bend = $nmBend;
            $nmbank_Bend = $nmbankBend;
            $pagu_anggaran = 0;
			break;
		case '3':
			$npwp_Bend = $npwpBend;
            $rek_Bend = $rekBend;
            $bank_Bend = $bankBend;
            $nm_Bend = $nmBend;
            $nmbank_Bend = $nmbankBend;
            $pagu_anggaran = $pagu;
			break;
		case '4':
			$npwp_Bend = $npwp;
            $rek_Bend = $no_rek;
            $bank_Bend = $bank;
            $nm_Bend = $nmrekan;
            $nmbank_Bend = $nm_bank;
            $pagu_anggaran = $pagu;
			break;
		case '5':
			$npwp_Bend = $npwp;
            $rek_Bend = $no_rek;
            $bank_Bend = $bank;
            $nm_Bend = $nmrekan;
            $nmbank_Bend = $nm_bank;
            $pagu_anggaran = $pagu;
			break;
		case '6':
			$npwp_Bend = $npwp;
            $rek_Bend = $no_rek;
            $bank_Bend = $bank;
            $nm_Bend = $nmrekan;
            $nmbank_Bend = $nm_bank;
            $pagu_anggaran = $pagu;
			break;
		case '7':
			$npwp_Bend = $npwp;
            $rek_Bend = $no_rek;
            $bank_Bend = $bank;
            $nm_Bend = $nmrekan;
            $nmbank_Bend = $nm_bank;
            $pagu_anggaran = $pagu;
			break;
		case '8':
			$npwp_Bend = $npwp;
            $rek_Bend = $no_rek;
            $bank_Bend = $bank;
            $nm_Bend = $nmrekan;
            $nmbank_Bend = $nm_bank;
            $pagu_anggaran = $pagu;
			break;
		default:
			$npwp_Bend = '';
            $rek_Bend = '';
            $bank_Bend = '';
            $nm_Bend = '';
            $nmbank_Bend = '';
            $pagu_anggaran = 0;
			break;
	}

	$cRet .="
		<table style=\"border-collapse:collapse;font-family:Arial Black;\" width=\"110%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">
			<tr>
              <td width = \"50%\" style = \"padding:10px;font-weight:bold;font-size:14px;padding-top:5px;padding-bottom:5px;\" align = \"center\" rowspan = \"2\">PEMERINTAH ".strtoupper($kab)."</td>
              <td width = \"50%\" style = \"padding:10px;border-bottom:none;font-weight:bold;font-size:14px;padding-top:5px;padding-bottom:5px;\" align = \"center\">SURAT PERINTAH PENCAIRAN DANA <br>(SP2D)</td>
			</tr>
			<tr>
              <td width = \"50%\" style = \"padding:10px;border-top:none;font-size:11px;font-weight:bold\" align = \"center\">Nomor : $nomor</td>
			</tr>
			<tr>
              <td width = \"50%\" style=\"padding:10px;padding-top:5px;padding-bottom:5px;\">
              	<table width = \"100%\" style = \"border:none;font-size:11px;\">
              		<tr>
                       <td>No SPM</td>
                       <td>:</td>
                       <td>$no_spm</td>
              		</tr>
              		<tr>
                       <td>Tanggal</td>
                       <td>:</td>
                       <td>".$this->tukd_model->tanggal_format_indonesia($tgl_spm)."</td>
              		</tr>
              		<tr>
                       <td>Nama SKPD</td>
                       <td>:</td>
                       <td>".ucwords($nm_skpd)."</td>
              		</tr>
              	</table>
              </td>
              <td width = \"50%\" style = \"border:1px solid;padding:10px;padding-top:5px;padding-bottom:5px;\">
              	<table width = \"100%\" style = \"border:none;font-size:11px;\">
              		<tr>
                       <td>Dari</td>
                       <td>:</td>
                       <td>BUD/Kuasa BUD</td>
              		</tr>
              		<tr>
                       <td width = \"35%\">Tahun Anggaran</td>
                       <td width = \"3%\">:</td>
                       <td>$thn_ang</td>
              		</tr>
              	</table>
              </td>
			</tr>
			<tr>
               <td colspan = \"2\" style = \"border:1px solid;padding:10px;font-size:11px;padding-top:5px;padding-bottom:5px;\">
               		Bank Pengirim : BANK ACEH SYARIAH <br>
               		Hendaklah mencairkan / memindahbukukan dari baki Rekening Nomor 13001026400055 <br>
               		Uang Sebesar Rp. ".number_format($nilai_sp2d,2)."
               </td>
			</tr>
			<tr>
               <td colspan = \"2\" style = \"border:1px solid;padding:10px;padding-top:5px;padding-bottom:5px;\">
               		<table style =\"border:none;font-size:11px;\" width = \"100%\">
               		   <tr>
                           <td width = \"20%\">Kepada</td>
                           <td width = \"2%\">:</td>
                           <td>$nm_Bend</td>
               		   </tr>
               		   <tr>
                           <td width = \"20%\">NPWP</td>
                           <td width = \"2%\">:</td>
                           <td>$npwp_Bend</td>
               		   </tr>
               		   <tr>
                           <td width = \"20%\">No. Rekening</td>
                           <td width = \"2%\">:</td>
                           <td>$rek_Bend</td>
               		   </tr>
               		   <tr>
                           <td width = \"20%\">Bank Penerima</td>
                           <td width = \"2%\">:</td>
                           <td>$nmbank_Bend</td>
               		   </tr>
               		   <tr>
                           <td width = \"20%\">Keperluan Untuk</td>
                           <td width = \"2%\">:</td>
                           <td>".$keperluan."</td>
               		   </tr>
                       <tr>
                           <td width = \"20%\">Pagu Anggaran</td>
                           <td width = \"2%\">:</td>
                           <td>Rp. ".number_format($pagu_anggaran,2)."</td>
                       </tr>
               		</table>
               </td>
			</tr>
		</table>
	";

	$cRet .="
		<table style=\"border-collapse:collapse;font-family:Arial Black;font-size:11px;\" width=\"110%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">
			<thead>
				<tr>
                   <th width = \"5%\" style = \"padding:3px;\">No.</th>
                   <th width = \"20%\" style = \"padding:3px;\">Kode Kegiatan</th>
                   <th width = \"50%\" style = \"padding:3px;\">Uraian</th>
                   <th width = \"25%\" style = \"padding:3px;\">Jumlah (Rp.)</th>
				</tr>
			</thead>
		
	";

	$no = 1;
	$sp2d = "
			SELECT * FROM (
                    SELECT LEFT ( a.kd_subkegiatan, 12 ) AS kode, 
                    ( SELECT nm_kegiatan FROM m_kegiatan WHERE kd_kegiatan = LEFT ( a.kd_subkegiatan, 12 ) ) AS nm_kode,
                    SUM ( a.nilai ) AS nilai FROM trdspp a
                    WHERE a.no_spp = '$no_spp' GROUP BY LEFT ( a.kd_subkegiatan, 12 ) 
                    UNION ALL
                    SELECT a.kd_subkegiatan AS kode,
                    ( SELECT nm_subkegiatan FROM ms_sub_kegiatan WHERE kd_subkegiatan = a.kd_subkegiatan ) AS nm_kode, 
                    SUM ( a.nilai ) AS nilai 
                    FROM trdspp a WHERE a.no_spp = '$no_spp' GROUP BY a.kd_subkegiatan 
                    UNION ALL 
                    SELECT a.kd_subkegiatan + '.' + a.kd_rek6 AS kode,
                    a.nm_rek6 AS nm_kode,
                    a.nilai as nilai
                    FROM trdspp a WHERE a.no_spp = '$no_spp') AS aa ORDER BY aa.kode
	";

	if ($jns == '1') {
		$up = "SELECT * FROM trdspp WHERE no_spp = '$no_spp'";
		$dataup = $this->db->query($up)->row();

		$cRet .="
				  <tr>
				    <td align = \"center\" style = \"font-weight:none;padding:2px;padding-left:5px;\">$no</td>
				    <td align = \"left\" style = \"font-weight:none;padding:2px;padding-left:5px;\">".$this->tukd_model->dotrek($dataup->kd_rek6)."</td>
				    <td align = \"left\" style = \"font-weight:none;padding:2px;padding-left:5px;\">".ucwords($dataup->nm_rek6)." (Uang Persediaan)</td>
				    <td align = \"right\" style = \"font-weight:none;padding:2px;padding-left:5px;\">Rp. ".number_format($dataup->nilai,2)."</td>
				  </tr>
		";
	} else if($jns == '2'){
		$cRet .="";
	} else {
	foreach ($this->db->query($sp2d)->result_array() as $data) {
		$kode_rekening = $data['kode'];
		$nama_rekening = $data['nm_kode'];
		$nilai = $data['nilai'];

		$aa = str_replace('.','',$kode_rekening);

		if (strlen($aa)==22) {
			$bold = 'none';
			$kd_rekening = substr($aa, -12);
		} else {
			$bold = 'bold';
			$kd_rekening = $aa;
		}

		$cRet .="
				  <tr>
				    <td align = \"center\" style = \"font-weight:$bold;padding:2px;padding-left:5px;\">$no</td>
				    <td align = \"left\" style = \"font-weight:$bold;padding:2px;padding-left:5px;\">".$this->tukd_model->dotrek($kd_rekening)."</td>
				    <td align = \"left\" style = \"font-weight:$bold;padding:2px;padding-left:5px;\">".ucwords($nama_rekening)."</td>
				    <td align = \"right\" style = \"font-weight:$bold;padding:2px;padding-left:5px;\">Rp. ".number_format($nilai,2)."</td>
				  </tr>
		";

		$no++;


	}
}


	$cRet .="
			<thead>
				<tr>
					<th colspan = \"3\" align = \"right\" style = \"padding:5px;\">JUMLAH</th>
					<th align = \"right\" style = \"padding:5px;\">Rp. ".number_format($nilai_sp2d,2)."</th>
				</tr>
			</thead>
	";
	$cRet .="
			<thead>
				<tr>
					<th colspan = \"4\" align = \"left\" style = \"padding:3px;\">Potongan - Potongan :</th>
				</tr>
			</thead>
	";
	$cRet .="</table>";

	$cRet .="
		<table style=\"border-collapse:collapse;font-family:Arial Black;font-size:11px;\" width=\"110%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">
			<thead>
				<tr>
					<th align = \"center\" style = \"padding:3px;\" width = \"5%\">No.</th>
					<th align = \"center\" style = \"padding:3px;\" width = \"45%\">Uraian (No. Rekening)</th>
					<th align = \"center\" style = \"padding:3px;\" width = \"30%\">Jumlah (Rp.)</th>
					<th align = \"center\" style = \"padding:3px;\" width = \"20%\">Keterangan</th>
				</tr>
			</thead>
	";
	$noo = 1;
	$tot_pot = 0;
	$pot = "SELECT * FROM trspmpot WHERE no_spm = '$no_spm' and (pot='1' or pot='')";

	foreach ($this->db->query($pot)->result_array() as $rowPot) {

		$cRet .="
			<tbody>
				<tr>
					<td align = \"center\" style = \"padding:3px;\">$noo</td>
					<td align = \"left\" style = \"padding:3px;\">".$rowPot['nm_rek6']."</td>
					<td align = \"right\" style = \"padding:3px;\">".number_format($rowPot['nilai'],2)."</td>
					<td align = \"left\" style = \"padding:3px;\"></td>
				</tr>
			</tbody>

		";
		$noo++;
		$tot_pot = $tot_pot + $rowPot['nilai'];
	}

		$cRet .="
			<thead>
				<tr>
					<th colspan = \"2\" align = \"right\" style = \"padding:3px;\">JUMLAH</th>
					<th align = \"right\" style = \"padding:3px;\">Rp. ".number_format($tot_pot,2)."</th>
					<th align = \"left\" style = \"padding:3px;\"></th>
				</tr>
			</thead>

		";

		$cRet .="
				<tr>
					<td colspan = \"4\" align = \"left\" style = \"padding:3px;\"> <b>Informasi : </b><i>(tidak mengurangi jumlah pembayaran SP2D)</i></td>
				</tr>
		";
	
	$cRet .="</table>";
	$cRet .="
		<table style=\"border-collapse:collapse;font-family:Arial Black;font-size:11px;\" width=\"110%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">
			<thead>
				<tr>
					<th align = \"center\" style = \"padding:3px;\" width = \"5%\">No.</th>
					<th align = \"center\" style = \"padding:3px;\" width = \"45%\">Uraian (No. Rekening)</th>
					<th align = \"center\" style = \"padding:3px;\" width = \"30%\">Jumlah (Rp.)</th>
					<th align = \"center\" style = \"padding:3px;\" width = \"20%\">Keterangan</th>
				</tr>
			</thead>
	";
	$nt = 1;
        $tot_tdkpot = 0;
        $tdkpot = "SELECT * FROM trspmpot WHERE no_spm = '$no_spm' and pot='0'";

        foreach ($this->db->query($tdkpot)->result_array() as $rowTdkPot) {

            $cRet .= "
            <tbody>
                <tr>
                    <td align = \"center\" style = \"padding:3px;\">$nt</td>
                    <td align = \"left\" style = \"padding:3px;\">" . $rowTdkPot['nm_rek6'] . "</td>
                    <td align = \"right\" style = \"padding:3px;\">" . number_format($rowTdkPot['nilai'], 2) . "</td>
                    <td align = \"left\" style = \"padding:3px;\"></td>
                </tr>
            </tbody>

        ";
            $nt++;
            $tot_tdkpot = $tot_tdkpot + $rowTdkPot['nilai'];
        }
        $cRet .= "
            <thead>
                <tr>
                    <th colspan = \"2\" align = \"right\" style = \"padding:3px;\">JUMLAH</th>
                    <th align = \"right\" style = \"padding:3px;\">Rp. " . number_format($tot_tdkpot, 2) . "</th>
                    <th align = \"left\" style = \"padding:3px;\"></th>
                </tr>
            </thead>
            <tr>
                <td colspan = \"4\" align = \"left\" style = \"padding:3px;\"> <b>SP2D yang Dibayarkan </b></td>
            </tr>

        ";
	$cRet .="</table>";
	$netto = $nilai_sp2d - $tot_pot;
	$cRet .="
		<table style=\"border-collapse:collapse;font-family:Arial Black;font-size:11px;\" width=\"110%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">
				<tr>
					<td align = \"left\" style = \"padding:3px;\" width = \"50%\">Jumlah yang Diminta (Bruto)</td>
					<td align = \"left\" style = \"padding:3px;\" width = \"50%\">Rp. ".number_format($nilai_sp2d,2)."</td>
				</tr>
				<tr>
					<td align = \"left\" style = \"padding:3px;\" width = \"50%\">Jumlah Potongan</td>
					<td align = \"left\" style = \"padding:3px;\" width = \"50%\">Rp. ".number_format($tot_pot + $tot_tdkpot,2)."</td>
				</tr>
				<tr>
					<td align = \"left\" style = \"padding:3px;\" width = \"50%\">Jumlah Netto</td>
					<td align = \"left\" style = \"padding:3px;\" width = \"50%\">Rp. ".number_format($netto,2)."</td>
				</tr>
				<tr>
					<td align = \"left\" style = \"padding:3px;\" width = \"50%\">Jumlah yang Dibayarkan</td>
					<td align = \"left\" style = \"padding:3px;\" width = \"50%\">Rp. ".number_format($nilai_sp2d,2)."</td>
				</tr>
				<tr>
					<td align = \"left\" style = \"padding:3px;\" colspan = \"2\"><b>Uang Sejumlah : </b><i>".ucwords($this->tukd_model->terbilang($nilai_sp2d))."</i></td>
				</tr>
				<tr>
					<td align = \"left\" style = \"padding:3px;border-right:none;\">
					Lembar 1  :	<b>Bank Yang Ditunjuk</b><br>
					Lembar 2  :	<b>Pengguna Anggaran/Kuasa Pengguna Anggaran</b><br>
					Lembar 3  :	<b>Arsip Kuasa BUD</b><br>
					Lembar 4  :	<b>Pihak Penerima</b>
					</td>
					<td align = \"center\" style = \"padding:3px;border-left:none;\">
					$daerah, ".$this->tukd_model->tanggal_format_indonesia($tgl_sp2d)."<br>
					<b>Kuasa Bendahara Umum Daerah</b><br><br><br><br><br><br>
					<u>$nm_ttd</u><br>
					NIP . $ttd_bud

					</td>
				</tr>
	";
	$cRet .="</table>";



	$data['prev']= $cRet;
    $this->_mpdf('',$cRet,10,10,10,'0',1,'');

	}

    function _mpdf($judul='',$isi='',$lMargin=10,$rMargin=10,$font='',$orientasi='',$hal='', $fonsize='') {


            ini_set("memory_limit","-1M");
            ini_set("MAX_EXECUTION_TIME","-1");
            $this->load->library('mpdf');
        //$this->mpdf->SetHeader('||Halaman {PAGENO} /{nb}');


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
                            //$this->mpdf->useOddEven = 1;                      

        $this->mpdf->AddPage($orientasi,'',$hal,'1','off');
        if ($hal==''){
            $this->mpdf->SetFooter("Printed on Simakda ||  ");
        }
        else{
            $this->mpdf->SetFooter("Printed on Simakda || Halaman {PAGENO}  ");
        }
        if (!empty($judul)) $this->mpdf->writeHTML($judul);
        $this->mpdf->writeHTML($isi);         
        $this->mpdf->Output();

    }
}