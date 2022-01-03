<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 */
class Register extends CI_Controller
{
	
	function __contruct()
	{	 
		parent::__construct();
    
	} 

	function register_sp2d_bud_ctk(){

		$jns_cetak = $this->uri->segment(3); //pdf atau layar
		$cetakseluruh = $this->uri->segment(4); //cetakskpd
		$cetakperiode = $this->uri->segment(5); //cetakPeriode
		$periode1 = $this->uri->segment(6); //Periode1
		$periode2 = $this->uri->segment(7); //Periode2
		$bulan = $this->uri->segment(8); //bulan
		$ttd = urldecode($this->uri->segment(9)); //ttd
		$status = $this->uri->segment(10); //status sp2d

		$client = $this->ClientModel->clientData();
		$kab = $client->kab_kota;
		$daerah = $client->daerah;
		$cRet = '';
		$nm_skpd = '';
		$ta = '';

		if ($status == '1') {
			$judul = 'SP2D YANG SUDAH TERBIT';
			$cair = "(status_bud IS NULL OR status_bud = '1')";
		} else {
			$judul = 'SP2D YANG SUDAH CAIR';
			$cair = "status_bud = '1'";
		}

		if ($cetakperiode == '1') {
			$namaperiod = 'PERIODE : '.$this->tukd_model->tanggal_format_indonesia($periode1).' S/D '.$this->tukd_model->tanggal_format_indonesia($periode2);
			$periode = "tgl_sp2d >= '$periode1' AND tgl_sp2d <= '$periode2'";   
		} else {
			$namaperiod = 'BULAN : '.$this->tukd_model->getBulan($bulan);
			$ta = 'TAHUN ANGGARAN '.date('Y');  
			$periode = "MONTH(tgl_sp2d) = '$bulan'";   
		}

		if ($cetakseluruh == '1') {
			$kd_skpd = $this->uri->segment(11); //kd_skpd
			$nm_skpd = $this->tukd_model->get_nama($kd_skpd,'nm_skpd','ms_skpd','kd_skpd');
			$seluruh = "WHERE kd_skpd = '$kd_skpd' AND $cair AND $periode";
		} else {
			$nm_skpd = 'KESELURUHAN';
			$seluruh = "WHERE $cair AND $periode";
		}

		$cRet .= "
			<table style=\"border-collapse:collapse;font-family: Tahoma;font-size:16px;font-weight:bold;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\">
				<tr>
                    <td width = \"10%\" align = \"center\"><img src=\"./image/simakda.png\" weight=\"90\" height=\"100\"/></td>
                    <td style = \"text-align:center;\" >
                    	PEMERINTAH $kab <br>
                    	REGISTER $judul <br>
                    	".strtoupper($nm_skpd)." <br>
                    	".strtoupper($namaperiod)." <br>
                    	".$ta." <br>
                    </td>
                    <td width = \"10%\">&nbsp;</td>
				</tr>
			</table>
			<hr>
		";

		$cRet .= "
			<table style=\"border-collapse:collapse;font-family: Tahoma;font-size:12px;font-weight:bold;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"1\" cellpadding=\"1\">
				<thead>
					<tr>
                       <th style = \"width:5%;padding:10px;background-color:#abb9c2;\">No</th>
                       <th style = \"width:12%;padding:10px;background-color:#abb9c2;\">Tanggal SP2D</th>
                       <th style = \"width:18%;padding:10px;background-color:#abb9c2;\">Nama SKPD</th>
                       <th style = \"width:10%;padding:10px;background-color:#abb9c2;\">Jenis Beban</th>
                       <th style = \"width:20%;padding:10px;background-color:#abb9c2;\">No SP2D</th>
                       <th style = \"width:20%;padding:10px;background-color:#abb9c2;\">Uraian</th>
                       <th style = \"width:15%;padding:10px;background-color:#abb9c2;\">Nilai</th>
					</tr>
				</thead>";

		$sql = "SELECT * FROM trhsp2d $seluruh ORDER BY tgl_sp2d,no_sp2d,kd_skpd";
		$no = 1;
		$total = 0;
		// print_r($sql);die();
		foreach ($this->db->query($sql)->result_array() as $resulte) {

			switch ($resulte['jns_spp']) 
                    {
                        case '1': //UP
                            $jns='Uang Persediaan';
                            break;
                        case '2': //GU
                            $jns='Ganti Uang Persediaan';
                            break;
                        case '3': //TU
                            $jns='Tambah Uang';
                            break;
                        case '4': //LS gaji
                           $jns='Langsung (LS) gaji';
                            break;
                        case '5': //LS PPKD
                            $jns='Langsung (LS) PPKD';
                            break;
                        case '6': //LS barang dan jasa
                            $jns='Langsung (LS) barang & jasa';
                            break;
                        case '8': //LS Pihak Ketiga Lainnya
                            $jns='Langsung (LS) Pihak Ketiga Lainnya';
                            break;
                            
                    }
			
			$cRet .= "
				<tbody>
					<tr>
                        <td style = \"text-align:center;padding:5px;\">$no</td>
                        <td style = \"text-align:left;padding:5px;\">".$this->tukd_model->tanggal_format_indonesia($resulte['tgl_sp2d'])."</td>
                        <td style = \"text-align:left;padding:5px;\">".$resulte['nm_skpd']."</td>
                        <td style = \"text-align:left;padding:5px;\">".$jns."</td>
                        <td style = \"text-align:left;padding:5px;\">".$resulte['no_sp2d']."</td>
                        <td style = \"text-align:left;padding:5px;\">".$resulte['keperluan']."</td>
                        <td style = \"text-align:right;padding:5px;\">Rp. ".number_format($resulte['nilai'],2)."</td>
					</tr>
				</tbody>
			";
			$no++;
			$total = $total + $resulte['nilai'];
		}

		$cRet .= "
					<tr>
                       <td colspan = \"6\" style = \"font-weight:bold;padding:10px;text-align:center;font-size:14px;\">TOTAL NILAI</td>
                       <td style = \"font-weight:bold;padding:10px;text-align:right;font-size:14px;\">Rp. ".number_format($total,2)."</td>
					</tr>
		";
		$cRet .= "</table>";


		$data['prev']= $cRet;

		switch ($jns_cetak) {
			case '1':
		$this->tukd_model->_mpdf_F4('', $cRet, 5, 5, 10, '1');
				break;
			case '0':
		echo($cRet);
				break;
			default:
		echo($cRet);
				break;
		}

	}
}