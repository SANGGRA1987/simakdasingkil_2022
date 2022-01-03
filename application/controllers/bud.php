<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bud extends CI_Controller {
	function __contruct()
	{	 
		parent::__construct();
    
	}

	function uji_sp2d()
    {
        $data['page_title']= 'DAFTAR PENGUJI SP2D';
        $this->template->set('title', 'PENGUJI SP2D');   
        $this->template->load('template','tukd/register/uji_sp2d',$data) ; 
    }

    function lra_bulan_rekap()
    {
        $data['page_title']= 'DAFTAR PENGUJI SP2D';
        $this->template->set('title', 'PENGUJI SP2D');   
        $this->template->load('template','tukd/register/lra_tr_bulan',$data) ; 
    }

    function lra_bulan_rekap_rinci()
    {
        $data['page_title']= 'DAFTAR PENGUJI SP2D';
        $this->template->set('title', 'PENGUJI SP2D');   
        $this->template->load('template','tukd/register/uji_sp2d',$data) ; 
    }

    function cek_simpan_uji(){

        $nomor_uji  = $this->input->post('nomor');
        $tanggal1   = $this->input->post('tgl1');
        $tanggal2   = $this->input->post('tgl2');

        $sql = "SELECT COUNT(*) as jumlah FROM trduji_sp2d a WHERE a.tgl_sp2d BETWEEN '$tanggal1' AND '$tanggal2' OR ( a.no_uji = '$nomor_uji' )";
        $query = $this->db->query($sql)->row();
        $hasil = $query->jumlah;

        if ($hasil == '0') {
            $result = array('pesan' => '0');
        } else {
            $result = array('pesan' => '1');
        }

        echo json_encode($result);

    }

    function simpan_penguji()
    {
        $nomor_uji  = $this->input->post('nomor');
        $tanggal1   = $this->input->post('tgl1');
        $tanggal2   = $this->input->post('tgl2');
        $username   = $this->session->userdata('pcNama');
        $dataUji = '';
        $total = 0;


        $sql = "SELECT a.no_sp2d,a.tgl_sp2d,a.kd_skpd,a.nm_skpd,a.no_spm,a.nilai,b.sumber FROM trhsp2d a JOIN trdspp b ON a.no_spp = b.no_spp WHERE a.tgl_sp2d BETWEEN '$tanggal1' AND '$tanggal2' 
                GROUP BY a.no_sp2d,a.tgl_sp2d,a.kd_skpd,a.no_spm,a.nilai,a.nm_skpd,b.sumber ORDER BY a.tgl_sp2d";
        $query = $this->db->query($sql)->result_array();
        foreach ($query as $resulte) {
            $tgl_sp2d = $resulte['tgl_sp2d'];
            $no_sp2d = $resulte['no_sp2d'];
            $kd_skpd = $resulte['kd_skpd'];
            $nm_skpd = $resulte['nm_skpd'];
            $no_spm = $resulte['no_spm'];
            $nilai = $resulte['nilai'];
            $sumber = $resulte['sumber'];


            $data['no_uji'] = $nomor_uji;
            $data['tgl_sp2d'] = $tgl_sp2d;
            $data['tgl_uji'] = $tanggal2;
            $data['no_sp2d'] = $no_sp2d;
            $data['no_spm'] = $no_spm;
            $data['kd_skpd'] = $kd_skpd;
            $data['nm_skpd'] = $nm_skpd;
            $data['username'] = $username;
            $data['sumber'] = $sumber;
            $data['nilai'] = $nilai;

            $dataUji = $this->db->insert('trduji_sp2d',$data);
            $this->db->query("UPDATE trhsp2d SET no_uji = '$nomor_uji', tgl_uji = '$tanggal2' WHERE no_sp2d = '$no_sp2d'");
            $total = $total + $nilai;
        }

        $uji['no_uji'] = $nomor_uji;
        $uji['tgl_uji'] = $tanggal2;
        $uji['username'] = $username;
        $uji['nilai'] = $total;
        $dataUji = $this->db->insert('trhuji_sp2d',$uji);


        if ($dataUji) {
            $result = array('hasil' => '1' );
        } else {
            $result = array('hasil' => '0' );
        }

        echo json_encode($result);
    }

    function load_sp2d_Uji(){
        $result = array();
        $row = array();
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
        $offset = ($page-1)*$rows;
        $kriteria = '';
        $kriteria = $this->input->post('cari');
        $where ='';
        if ($kriteria <> ''){                                           
            $where="where (upper(no_uji) like upper('%$kriteria%') or tgl_uji like'%$kriteria%')";            
        }
             
        $sql = "SELECT count(*) as tot FROM trhuji_sp2d $where GROUP BY no_uji,tgl_uji" ;
        $query1 = $this->db->query($sql);
        $total = $query1->row();

        $sql = "SELECT top $rows no_uji, tgl_uji, nilai FROM trhuji_sp2d WHERE no_uji NOT IN (SELECT TOP $offset no_uji FROM trhuji_sp2d) AND (upper(no_uji) like upper('%$kriteria%')) GROUP BY no_uji,tgl_uji,nilai";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $row[] = array(
                        'id' => $ii,
                        'no_uji' => $resulte['no_uji'],        
                        'tgl_uji' => $this->tukd_model->tanggal_format_indonesia($resulte['tgl_uji']),
                        'nilai' => number_format($resulte['nilai'],2)                                                                                      
                        );
                        $ii++;
        }
           
        $result["total"] = $total->tot;
        $result["rows"] = $row; 
        echo json_encode($result);
           
    
    }

    function hapus_uji()
        {
            $nomor_uji  = $this->input->post('nomor');
            $hapus = $this->db->query("DELETE trhuji_sp2d WHERE no_uji = '$nomor_uji'");
            $hapus = $this->db->query("DELETE trduji_sp2d WHERE no_uji = '$nomor_uji'");
            if ( $hapus > 0 ) {
                echo '1'; 
            } else {
                echo '0';
            }
        }
    function trlra_bulanan(){
        $kd_skpd   = $this->session->userdata('kdskpd');
        $thn_ang   = $this->session->userdata('pcThang');
        $client    = $this->ClientModel->clientData();
        $kab       = $client->kab_kota;
        $daerah    = $client->daerah;
        $nm_skpd   =  $this->tukd_model->get_nama($kd_skpd,'nm_skpd','ms_skpd','kd_skpd');
        $bulan     = $this->uri->segment(3); // Periode Triwulan atau semester
        $sts_ang   = $this->uri->segment(4); // status anggaran
        $tgl_ttd   = $this->uri->segment(5); // Tanggal Tanda Tanggan
        $nip_ttd   = urldecode($this->uri->segment(6)); // NIP Tanda Tangan
        $nm_ttd   =  $this->tukd_model->get_nama($nip_ttd,'nama','ms_ttd','nip');
        $cetak     = $this->uri->segment(7); // Jenis Cetakan
        $cRet      = '';

        switch ($sts_ang) {
            case '1':
                $ang = 'Penyusunan';
                $nilai = 'nilai';
                break;
            case '2':
                $ang = 'Penyempurnaan';
                $nilai = 'nilai_sempurna';
                break;
            case '3':
                $ang = 'Perubahan';
                $nilai = 'nilai_ubah';
                break;   
            default:
                $ang = 'Penyusunan';
                $nilai = 'nilai';
                break;
        }

        switch ($bulan) {
            case '1':
                $judul = 'JANUARI';
                break;
            case '2':
                $judul = 'FEBRUARI';
                break;
            case '3':
                $judul = 'TRIWULAN 1';
                break;
            case '4':
                $judul = 'APRIL';
                break;
            case '5':
                $judul = 'MEI';
                break;
            case '6':
                $judul = 'SEMESTER 1';
                break;
            case '7':
                $judul = 'JULI';
                break;
            case '8':
                $judul = 'AGUSTUS';
                break;
            case '9':
                $judul = 'TRIWULAN 3';
                break;
            case '10':
                $judul = 'OKTOBER';
                break;
            case '11':
                $judul = 'NOVEMBER';
                break;
            case '12':
                $judul = 'SEMESTER 2';
                break;          
            default:
                $judul = '';
                break;
        }

        $cRet .="
        <table style=\"border-collapse:collapse;font-family:Arial;\" width=\"110%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
            <tr>
                <td style = \"font-size:14px;text-align:center;font-weight:bold;padding:3px;\">PEMERINTAH ".strtoupper($kab)."</td>
            </tr>
            <tr>
                <td style = \"font-size:14px;text-align:center;font-weight:bold;padding:3px;\">LAPORAN REALISASI ANGGARAN ".strtoupper($judul)."</td>
            </tr>
            <tr>
                <td style = \"font-size:14px;text-align:center;font-weight:bold;padding:3px;\">TAHUN ANGGARAN $thn_ang</td>
            </tr>
            <tr>
                <td style = \"font-size:14px;text-align:center;font-weight:bold;padding:3px;\">&nbsp;</td>
            </tr>
        </table>
        ";

        $cRet .="
        <table style=\"border-collapse:collapse;font-family:Arial;\" width=\"120%\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">
            <thead>
                <tr>
                  <th width = \"10%\" style = \"font-size:12px;padding:10px;background-color:#bbd0f0;\">Rekening</th>
                  <th width = \"28%\" style = \"font-size:12px;padding:10px;background-color:#bbd0f0;\">Uraian</th>
                  <th width = \"18%\" style = \"font-size:12px;padding:10px;background-color:#bbd0f0;\">Anggaran</th>
                  <th width = \"18%\" style = \"font-size:12px;padding:10px;background-color:#bbd0f0;\">Realisasi</th>
                  <th width = \"18%\" style = \"font-size:12px;padding:10px;background-color:#bbd0f0;\">Lebih/Kurang</th>
                  <th width = \"8%\" style = \"font-size:12px;padding:10px;background-color:#bbd0f0;\">(%)</th>
                </tr>
            </thead>";

        $sql = "
                SELECT
                    aa.kd_rek,
                    aa.kode_rekening,
                    aa.bold,
                    aa.uraian,
                    (ISNULL((SELECT SUM(nilai_sempurna) FROM trdrka WHERE LEFT(kd_rek6, LEN(aa.kd_rek)) = aa.kd_rek), 0)) as anggaran,
                    (
                        ISNULL((SELECT SUM(nilai) from trhtransout bb inner join trdtransout cc on bb.kd_skpd=cc.kd_skpd and bb.no_bukti=cc.no_bukti
                        WHERE LEFT(cc.kd_rek6,LEN(aa.kd_rek)) = aa.kd_rek AND MONTH(bb.tgl_bukti) <= '$bulan' AND YEAR(bb.tgl_bukti) = '$thn_ang'), 0)
                        +
                        ISNULL((SELECT SUM(total) from trhkasin_pkd dd inner join trdkasin_pkd ee on dd.no_sts=ee.no_sts and dd.kd_skpd=ee.kd_skpd
                        WHERE LEFT(ee.kd_rek5,LEN(aa.kd_rek)) = aa.kd_rek AND MONTH(dd.tgl_sts) <= '$bulan' AND YEAR(dd.tgl_sts) = '$thn_ang'), 0)
                        +
                        ISNULL((SELECT SUM(ff.nilai) FROM tr_terima_ppkd ff WHERE LEFT(ff.kd_rek5, LEN(aa.kd_rek)) = aa.kd_rek AND MONTH(ff.tgl_terima) <= '$bulan' 
                        AND YEAR(ff.tgl_terima) = '$thn_ang'), 0)   
                    ) as realisasi
                FROM
                    map_lra_transaksi aa";
        $query = $this->db->query($sql)->result_array();
        $no = 1;
        

        foreach ($query as $resulte) {
            $anggaran = 0;
            $realisasi = 0;
            $persen = 0;
            $kd_rek = $resulte['kode_rekening'];
            $anggaran = $resulte['anggaran'];
            $realisasi = $resulte['realisasi'];
            $bold = $resulte['bold'];
            $sisa = $anggaran - $realisasi;
            // $persen = ($realisasi / $anggaran) * 100;
            $persen=($anggaran!=0)?($realisasi/$anggaran) * 100:0;

            $cRet .="
                <tbody>
                    <tr>
                       <td style = \"font-size:12px;padding:5px;font-weight:$bold;\">$kd_rek</td>
                       <td style = \"font-size:12px;padding:5px;font-weight:$bold;\">".$resulte['uraian']."</td>
                       <td style = \"font-size:12px;padding:5px;font-weight:$bold;text-align:right;\">".number_format($anggaran,2)."</td>
                       <td style = \"font-size:12px;padding:5px;font-weight:$bold;text-align:right;\">".number_format($realisasi,2)."</td>
                       <td style = \"font-size:12px;padding:5px;font-weight:$bold;text-align:right;\">(".number_format($sisa,2).")</td>
                       <td style = \"font-size:12px;padding:5px;font-weight:$bold;text-align:center;\">".number_format($persen,2)."</td>
                    </tr>
                </tbody>
               ";
            $no++;
        }
        $cRet .="</table>";

        $cRet .="
            <table style=\"border-collapse:collapse;font-family:Arial;font-size:12px;\" width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                <tr>
                    <td height = \"30px\" width = \"50%\" style = \"text-align:center;\" colspan = \"2\">&nbsp;</td>
                </tr>
                <tr>
                    <td width = \"50%\">&nbsp;</td>
                    <td width = \"50%\" style = \"text-align:center;\">
                    $daerah, ".$this->tukd_model->tanggal_format_indonesia($tgl_ttd)." <br>
                    Mengetahui, <br>
                    Pengguna Anggaran <br><br><br><br><br><br>
                    <u> $nm_ttd </u> <br>
                    NIP. $nip_ttd
                    </td>
                </tr>
            </table>";

        $data['prev']= $cRet;    
        switch($cetak) {        
            case 0;
                echo $cRet;
            break;
                case 1;
                $this->tukd_model->_mpdf('',$cRet,10,10,10,'0');    
            break;
                case 2;        
                header("Cache-Control: no-cache, no-store, must-revalidate");
                header("Content-Type: application/vnd.ms-excel");
                header("Content-Disposition: attachment; filename= lra.xls");
                $this->load->view('anggaran/rka/perkadaII', $data);
            break;
        }
    }

    function ctk_subkeg_bud(){
        $client     = $this->ClientModel->clientData();
        $kab        = $client->kab_kota;
        $daerah     = $client->daerah;
        $thn_ang    = $this->session->userdata('pcThang');
        $bulan      = $this->uri->segment(3);
        $kd_skpd    = $this->uri->segment(4);
        $subkeg     = $this->uri->segment(5);
        $nip_ttd    = $this->uri->segment(6);
        $jns_ctk    = $this->uri->segment(7);
        $anggaran   = $this->uri->segment(8);
        $nmsubgiat  = $this->tukd_model->get_nama($subkeg,'nm_subkegiatan','m_sub_giat','kd_subkegiatan');
        $nm_skpd    = $this->tukd_model->get_nama($kd_skpd,'nm_skpd','ms_skpd','kd_skpd');
        $nm_bulan   = $this->tukd_model->getBulan($bulan);
        $program    = substr($subkeg, 0,7);
        $nm_program = $this->tukd_model->get_nama($program,'nm_program','m_program','kd_program');
        $kegiatan   = substr($subkeg, 0,12);
        $nm_giat    = $this->tukd_model->get_nama($kegiatan,'nm_kegiatan','m_giat','kd_kegiatan');
        $cRet       = "";


        /*$cRet .="
                <table style=\"border-collapse:collapse;font-weight:bold;font-family:Times New Roman; font-size:15px\" border=\"0\" width=\"100%\" align=\"center\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
                        <td style = \"width:20%;\" align = \"center\"><img src=\"./image/simakda.png\" height=\"70\"/></td>
                        <td style = \"text-align:center;\">
                            PEMERINTAH $kab <br>
                            ".strtoupper($nm_skpd)." <br>
                            TAHUN ANGGARAN $thn_ang
                        </td>
                        <td style = \"width:20%;\">&nbsp;</td>
                    </tr>
                </table>
                <hr>";*/
        $cRet.="<table style=\"border-collapse:collapse;font-size:12px;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"1\" cellpadding=\"4\">
                    <tr> 
                        <td style=\"vertical-align:top; border-top: none; border-bottom: none; border-left: none; border-right: none;\"  width=\"15%\" rowspan=\"3\" align=\"center\"><img src=\"./image/simakda.png\" height=\"70\"/></td>
                        <td width=\"85%\" align='left' style=\"vertical-align:top; border-top: none; border-bottom: none; border-left: none; border-right: none;\"><b>PEMERINTAH $kab</b></td>
                        </tr>
                    <tr> 
                        <td align='left' style=\"vertical-align:top;border-top: none;border-bottom: none;border-left: none;border-right: none;\"><b>".strtoupper($nm_skpd)."</b></td> 
                    </tr>
                    <tr> 
                        <td align='left' style=\"vertical-align:top;border-top: none;border-bottom: none;border-left: none;border-right: none;\"><b>TAHUN ANGGARAN $thn_ang</b></td> 
                    </tr>  
                    <tr> 
                        <td align='left' style=\"vertical-align:top;border-top: none;border-bottom: none;border-left: none;border-right: none;\">&nbsp;</td> 
                    </tr>                   
                ";
            $cRet.="</table>";

        $cRet .="
                <table style=\"border-collapse:collapse;font-family:Times New Roman;\" border=\"0\" width=\"100%\" align=\"center\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
                        <td style = \"padding:10px;font-weight:bold;text-align:center;font-size:13px;\">
                        KARTU KENDALI KEGIATAN <br>
                        Periode Bulan : $nm_bulan
                        </td>
                    </tr>
                </table>
                ";
        $cRet .="
                <table style=\"border-collapse:collapse;font-family:Times New Roman;\" border=\"0\" width=\"100%\" align=\"center\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
                        <td style = \"padding-top:10px;font-weight:none;text-align:left;font-size:11px;width:15%;\">SKPD</td>
                        <td style = \"padding-top:10px;font-weight:none;text-align:center;font-size:11px;width:5%;\">:</td>
                        <td style = \"padding-top:10px;font-weight:none;text-align:left;font-size:11px;width:80%;\">$kd_skpd - $nm_skpd</td>
                    </tr>
                    <tr>
                        <td style = \"font-weight:none;text-align:left;font-size:11px;width:15%;\">Nama Program</td>
                        <td style = \"font-weight:none;text-align:center;font-size:11px;width:5%;\">:</td>
                        <td style = \"font-weight:none;text-align:left;font-size:11px;width:80%;\">$program - ".ucwords(strtolower($nm_program))."</td>
                    </tr>
                    <tr>
                        <td style = \"font-weight:none;text-align:left;font-size:11px;width:15%;\">Nama Kegiatan</td>
                        <td style = \"font-weight:none;text-align:center;font-size:11px;width:5%;\">:</td>
                        <td style = \"font-weight:none;text-align:left;font-size:11px;width:80%;\">$kegiatan - $nm_giat</td>
                    </tr>
                    <tr>
                        <td style = \"font-weight:none;text-align:left;font-size:11px;width:15%;\">Nama Sub Kegiatan</td>
                        <td style = \"font-weight:none;text-align:center;font-size:11px;width:5%;\">:</td>
                        <td style = \"font-weight:none;text-align:left;font-size:11px;width:80%;\">$subkeg - $nmsubgiat</td>
                    </tr>
                    <tr>
                         <td>&nbsp;</td>
                         <td>&nbsp;</td>
                         <td>&nbsp;</td>
                    </tr>
                </table>
                ";
        $cRet .="
                <table style=\"border-collapse:collapse;font-family:Times New Roman;font-size:11px;text-align:center;\" border=\"1\" width=\"110%\" align=\"center\" cellspacing=\"0\" cellpadding=\"0\">
                    <thead>
                           <tr>
                                <th rowspan = \"2\" style = \"padding:5px;width:5%;\">No</th>
                                <th rowspan = \"2\" style = \"padding:5px;width:15%;\">Kode Rekening</th>
                                <th rowspan = \"2\" style = \"padding:5px;width:15%;\">Nama Rekening</th>
                                <th rowspan = \"2\" style = \"padding:5px;width:20%;\">Anggaran</th>
                                <th colspan = \"3\" style = \"padding:5px;width:40%;\">Realisasi Kegiatan</th>
                                <th rowspan = \"2\" style = \"padding:5px;width:20%;\">Sisa Pagu</th>
                           </tr>
                           <tr>
                                <th style = \"padding:5px;width:18%\">LS</th>
                                <th style = \"padding:5px;width:13%\">UP/GU</th>
                                <th style = \"padding:5px;width:13%\">TU</th>
                           </tr>
                       </thead>";
            $sql = "SELECT
                    kd_skpd,
                    kd_subkegiatan,
                    kd_rek6,
                    nm_rek6,
                    SUM ( nilai ) AS ang_murni,
                    SUM ( nilai_sempurna ) AS ang_sempurna,
                    SUM ( nilai_ubah ) AS ang_ubah,
                    (
                    SELECT SUM(aa.nilai) as nilai FROM (
                    SELECT SUM ( a.nilai ) as nilai FROM trdtransout a JOIN trhtransout b ON a.no_bukti = b.no_bukti AND a.kd_skpd = b.kd_skpd WHERE a.kd_skpd =
                    trdrka.kd_skpd AND a.kd_subkegiatan = trdrka.kd_subkegiatan AND a.kd_rek6 = trdrka.kd_rek6 AND b.jns_spp IN ('1','2') AND MONTH(b.tgl_bukti) <='$bulan'
                     UNION  
                   SELECT SUM(d.rupiah) as nilai    FROM trdkasin_pkd d INNER JOIN trhkasin_pkd e ON d.no_sts=e.no_sts AND d.kd_skpd=e.kd_skpd 
                   WHERE LEFT(d.kd_rek6,1)=5 AND e.kd_skpd = trdrka.kd_skpd AND d.kd_subkegiatan = trdrka.kd_subkegiatan  AND d.kd_rek5= trdrka.kd_rek6 AND MONTH(e.tgl_sts) <='$bulan' AND e.jns_trans IN ('1','2')
                   UNION
                   SELECT SUM(a.nilai) as nilai FROM trdinlain a INNER JOIN TRHINLAIN b ON a.kd_skpd=b.KD_SKPD and a.no_bukti=b.NO_BUKTI
                   WHERE  b.KD_SKPD = trdrka.kd_skpd  AND b.pengurang_belanja='1' and MONTH(b.tgl_bukti) <='$bulan' AND b.kd_subkegiatan = trdrka.kd_subkegiatan AND  a.kd_rek6 = trdrka.kd_rek6 AND b.jns_spp IN ('1','2')
                   ) aa
                    ) as real_up,
                    (
                    SELECT SUM(aa.nilai) as nilai FROM (
                    SELECT SUM ( a.nilai ) as nilai FROM trdtransout a JOIN trhtransout b ON a.no_bukti = b.no_bukti AND a.kd_skpd = b.kd_skpd WHERE a.kd_skpd =
                    trdrka.kd_skpd AND a.kd_subkegiatan = trdrka.kd_subkegiatan AND a.kd_rek6 = trdrka.kd_rek6 AND b.jns_spp IN ('3') AND MONTH(b.tgl_bukti) <='$bulan'
                     UNION  
                   SELECT SUM(d.rupiah) as nilai    FROM trdkasin_pkd d INNER JOIN trhkasin_pkd e ON d.no_sts=e.no_sts AND d.kd_skpd=e.kd_skpd 
                   WHERE LEFT(d.kd_rek6,1)=5 AND e.kd_skpd = trdrka.kd_skpd  AND d.kd_subkegiatan = trdrka.kd_subkegiatan AND d.kd_rek5= trdrka.kd_rek6 AND MONTH(e.tgl_sts) <='$bulan' AND e.jns_trans IN ('3')
                   UNION
                   SELECT SUM(a.nilai) as nilai FROM trdinlain a INNER JOIN TRHINLAIN b ON a.kd_skpd=b.KD_SKPD and a.no_bukti=b.NO_BUKTI
                   WHERE  b.KD_SKPD = trdrka.kd_skpd  AND b.pengurang_belanja='1' and MONTH(b.tgl_bukti) <='$bulan' AND  b.kd_subkegiatan = trdrka.kd_subkegiatan and a.kd_rek6 = trdrka.kd_rek6 AND b.jns_spp IN ('3')
                   ) aa
                    ) as real_tu,
                    (
                    SELECT SUM(aa.nilai) as nilai FROM (
                    SELECT SUM ( a.nilai ) as nilai FROM trdtransout a JOIN trhtransout b ON a.no_bukti = b.no_bukti AND a.kd_skpd = b.kd_skpd WHERE a.kd_skpd =
                    trdrka.kd_skpd AND a.kd_subkegiatan = trdrka.kd_subkegiatan AND a.kd_rek6 = trdrka.kd_rek6 AND b.jns_spp IN ('4','6','8') AND MONTH(b.tgl_bukti) <='$bulan'
                     UNION  
                   SELECT SUM(d.rupiah) as nilai    FROM trdkasin_pkd d INNER JOIN trhkasin_pkd e ON d.no_sts=e.no_sts AND d.kd_skpd=e.kd_skpd 
                   WHERE LEFT(d.kd_rek6,1)=5 AND e.kd_skpd = trdrka.kd_skpd  AND d.kd_subkegiatan = trdrka.kd_subkegiatan AND d.kd_rek5= trdrka.kd_rek6 AND MONTH(e.tgl_sts) <='$bulan' AND e.jns_trans IN ('4','6','8')
                   UNION
                   SELECT SUM(a.nilai) as nilai FROM trdinlain a INNER JOIN TRHINLAIN b ON a.kd_skpd=b.KD_SKPD and a.no_bukti=b.NO_BUKTI
                   WHERE  b.KD_SKPD = trdrka.kd_skpd  AND b.pengurang_belanja='1' and MONTH(b.tgl_bukti) <='$bulan' AND b.kd_subkegiatan = trdrka.kd_subkegiatan and a.kd_rek6 = trdrka.kd_rek6 AND b.jns_spp IN ('4','6','8')
                   ) aa
                    ) as real_ls
                FROM
                    trdrka 
                WHERE
                    kd_skpd = '$kd_skpd' 
                    AND kd_subkegiatan = '$subkeg'
                GROUP BY
                    kd_skpd,
                    kd_subkegiatan,
                    kd_rek6,
                    nm_rek6
                ORDER BY kd_rek6 
            ";

            $query = $this->db->query($sql)->result_array();
            $no = 1;
            $total_ang = 0;
            $total_ls = 0;
            $total_up = 0;
            $total_tu = 0;
            $total_sisa = 0;

            foreach ($query as $kendali) {
                if ($anggaran == 1) {
                    $ang = $kendali['ang_murni'];
                } else if($anggaran == 2) {
                    $ang = $kendali['ang_sempurna'];
                } else {
                    $ang = $kendali['ang_ubah'];
                }

                $kd_rek6 = $this->tukd_model->dotrek($kendali['kd_rek6']);
                $nm_rek6 = $kendali['nm_rek6'];
                $real_ls = $kendali['real_ls'];
                $real_up = $kendali['real_up'];
                $real_tu = $kendali['real_tu'];
                $sisa = $ang - ($real_ls + $real_up + $real_tu); 


                $cRet .="
                    <tr>
                        <td style = \"text-align:center;padding:5px;\">$no</td>
                        <td style = \"text-align:center;padding:5px;\">$kd_rek6</td>
                        <td style = \"text-align:left;padding:5px;\">$nm_rek6</td>
                        <td style = \"text-align:right;padding:5px;\">".number_format($ang,2)."</td>
                        <td style = \"text-align:right;padding:5px;\">".number_format($real_ls,2)."</td>
                        <td style = \"text-align:right;padding:5px;\">".number_format($real_up,2)."</td>
                        <td style = \"text-align:right;padding:5px;\">".number_format($real_tu,2)."</td>
                        <td style = \"text-align:right;padding:5px;\">".number_format($sisa,2)."</td>
                    </tr>
                ";
                $total_ang      = $total_ang + $ang;
                $total_ls       = $total_ls + $real_ls;
                $total_up       = $total_up + $real_up;
                $total_tu       = $total_tu + $real_tu;
                $total_sisa     = $total_sisa + $sisa;
                $no++;
            }

        $cRet .="
                    <tr>
                        <td colspan = \"3\" style = \"text-align:center;padding:10px;font-weight:bold;\">Total</td>
                        <td style = \"text-align:right;padding:10px;font-weight:bold;\">".number_format($total_ang,2)."</td>
                        <td style = \"text-align:right;padding:10px;font-weight:bold;\">".number_format($total_ls,2)."</td>
                        <td style = \"text-align:right;padding:10px;font-weight:bold;\">".number_format($total_up,2)."</td>
                        <td style = \"text-align:right;padding:10px;font-weight:bold;\">".number_format($total_tu,2)."</td>
                        <td style = \"text-align:right;padding:10px;font-weight:bold;\">".number_format($total_sisa,2)."</td>
                    </tr>
        ";
        $cRet .="</table>";

        
        $data['prev']= $cRet;
        switch ($jns_ctk) {
            case '0':
                echo $cRet;
                break;
            case '1':
                $this->rka_model->_mpdf_folio('',$cRet,10,10,10,'0');
                break;
        }
            
    }

    function cetak_uji(){
        $client = $this->ClientModel->clientData();
        $thn_ang = $this->session->userdata('pcThang');
        $kab = $client->kab_kota;
        $daerah = $client->daerah;
        $jns_ctk= $this->uri->segment(3); //jenis cetakan
        $nomor= $this->uri->segment(4); //Nomor
        $nip_ttd= $this->uri->segment(5); //Tanda Tangan
        $nm_ttd= $this->tukd_model->get_nama($nip_ttd,'nama','ms_ttd','nip');
        $tgl_uji= $this->tukd_model->get_nama($nomor,'tgl_uji','trhuji_sp2d','no_uji');
        $cRet = '';

        $cRet .="
        <table style=\"border-collapse:collapse;font-family:Arial Black;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
            <tr>
                <td style = \"text-align:center;width:15%\" rowspan = \"2\"><img src=\"".base_url()."/image/simakda.png\"  width=\"90\" height=\"100\" /></td>
                <td style = \"text-align:center;font-size:20px;font-weight:bold;\">PEMERINTAH $kab <br> DAFTAR PENGUJI</td>
                <td style = \"text-align:center;width:15%\" rowspan = \"2\">&nbsp;</td>
            </tr>
            <tr>
                <td style = \"text-align:center;font-size:15px;font-weight:bold;\">Nomor : $nomor, Tanggal : ".$this->tukd_model->tanggal_format_indonesia($tgl_uji)."</td>    
            </tr>
            <tr>
                <td width = \"15%\" style = \"padding-top:15px;\">Bank</td>
                <td colspan=\"2\" style = \"padding-top:15px;\">: BANK ACEH SYARIAH</td>
            </tr>
            <tr>
                <td width = \"15%\" style = \"padding-top:5px;\">No Rekening</td>
                <td colspan=\"2\" style = \"padding-top:5px;\">: 130.01.02.640005-5</td>
            </tr>
        </table>
        <hr>";

        $cRet .="
        <table style=\"border-collapse:collapse;font-family:Arial Black;\" width=\"120%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">
            <thead>
                <tr>
                    <th width = \"3%\" style = \"padding-top:5px;padding-bottom:5px;background-color:#bfd6cf;\" rowspan = \"2\">No</th>
                    <th width = \"8%\" style = \"padding-top:5px;padding-bottom:5px;background-color:#bfd6cf;\" rowspan = \"2\">Nomor SP2D</th>
                    <th width = \"8%\" style = \"padding-top:5px;padding-bottom:5px;background-color:#bfd6cf;\" rowspan = \"2\">Tanggal SP2D</th>
                    <th width = \"11%\" style = \"padding-top:5px;padding-bottom:5px;background-color:#bfd6cf;\" rowspan = \"2\">Nama SKPD</th>
                    <th width = \"10%\" style = \"padding-top:5px;padding-bottom:5px;background-color:#bfd6cf;\" rowspan = \"2\">Nama Bendahara/Pihak Penagih</th>
                    <th width = \"10%\" style = \"padding-top:5px;padding-bottom:5px;background-color:#bfd6cf;\" rowspan = \"2\">No. Rek / Bank / Bendahara / pihak ketiga / lainnya</th>
                    <th width = \"10%\" style = \"padding-top:5px;padding-bottom:5px;background-color:#bfd6cf;\" rowspan = \"2\">Jumlah Kotor</th>
                    <th width = \"40%\" style = \"padding-top:5px;padding-bottom:5px;background-color:#bfd6cf;\" colspan = \"7\">Potongan</th>
                    <th width = \"10%\" style = \"padding-top:5px;padding-bottom:5px;background-color:#bfd6cf;\" rowspan = \"2\">Jumlah Bersih</th>
                </tr>
                <tr>
                    <th style = \"text-align:center;background-color:#bfd6cf;\" width = \"5%\">PPN</th>
                    <th style = \"text-align:center;background-color:#bfd6cf;\" width = \"5%\">PPH</th>
                    <th style = \"text-align:center;background-color:#bfd6cf;\" width = \"5%\">IWP</th>
                    <th style = \"text-align:center;background-color:#bfd6cf;\" width = \"5%\">JKK</th>
                    <th style = \"text-align:center;background-color:#bfd6cf;\" width = \"5%\">JKM</th>
                    <th style = \"text-align:center;background-color:#bfd6cf;\" width = \"5%\">JK</th>
                    <th style = \"text-align:center;background-color:#bfd6cf;\" width = \"10%\">Lainnya</th>
                </tr>
            </thead>";
        $no = 1;
        $totalkotor = 0;
        $totalbersih = 0;
        $totalppn = 0;
        $totalpph = 0;
        $totaliwp = 0;
        $totaljkk = 0;
        $totaljkm = 0;
        $totaljk = 0;
        $totallain = 0;
        $sql = "SELECT a.* ,
                ( SELECT SUM ( nilai ) FROM trspmpot WHERE LEFT ( kd_rek6, 6 ) = '210105' AND no_spm = a.no_spm ) AS pph,
                ( SELECT SUM ( nilai ) FROM trspmpot WHERE kd_rek6 IN ('210101010001','210108010001') AND no_spm = a.no_spm ) AS iwp,   
                ( SELECT SUM ( nilai ) FROM trspmpot WHERE kd_rek6 IN ('210102010001') AND no_spm = a.no_spm ) AS jk,   
                ( SELECT SUM ( nilai ) FROM trspmpot WHERE kd_rek6 IN ('210103010001') AND no_spm = a.no_spm ) AS jkk,  
                ( SELECT SUM ( nilai ) FROM trspmpot WHERE kd_rek6 IN ('210104010001') AND no_spm = a.no_spm ) AS jkm,  
                ( SELECT SUM ( nilai ) FROM trspmpot WHERE kd_rek6 IN ('210106010001') AND no_spm = a.no_spm ) AS ppn,  
                ( SELECT SUM ( nilai ) FROM trspmpot WHERE kd_rek6 IN ('210109010001') AND no_spm = a.no_spm ) AS lainnya,  
                ( SELECT SUM ( nilai ) FROM trspmpot WHERE kd_rek6 IN ('210107010001') AND no_spm = a.no_spm ) AS tapera,
                ( SELECT nmrekan FROM trhsp2d WHERE no_sp2d = a.no_sp2d) AS nm_rekan,    
                ( SELECT no_rek FROM trhsp2d WHERE no_sp2d = a.no_sp2d) AS rekening    
                FROM trduji_sp2d a WHERE a.no_uji = '$nomor'";
        foreach ($this->db->query($sql)->result_array() as $result) {
            $nilKotor    = $result['nilai'];
            $totPotongan = $result['ppn'] + $result['pph'] + $result['iwp'] + $result['jkk'] + $result['jkm'] + $result['jk'] + $result['lainnya'];
            $nilBersih   = $nilKotor - $totPotongan;
            $totalkotor  = $totalkotor + $result['nilai'];
            $totalppn    = $totalppn + $result['ppn'];
            $totalpph    = $totalpph + $result['pph'];
            $totaliwp    = $totaliwp + $result['iwp'];
            $totaljkk    = $totaljkk + $result['jkk'];
            $totaljkm    = $totaljkm + $result['jkm'];
            $totaljk     = $totaljk + $result['jk'];
            $totallain   = $totallain + $result['lainnya'];
            $totalbersih   = $totalbersih + $nilBersih;

            $cRet .= "
                <tbody>
                    <tr>
                        <td style = \"text-align:center;padding:5px;\">$no</td>
                        <td style = \"text-align:left;padding:5px;\">".$result['no_sp2d']."</td>
                        <td style = \"text-align:center;padding:5px;\">".$this->tukd_model->tanggal_ind($result['tgl_sp2d'])."</td>
                        <td style = \"text-align:left;padding:5px;\">".ucwords($result['nm_skpd'])."</td>
                        <td style = \"text-align:left;padding:5px;\">".ucwords($result['nm_rekan'])."</td>
                        <td style = \"text-align:left;padding:5px;\">".$result['rekening']."</td>
                        <td style = \"text-align:right;padding:5px;\">".number_format($nilKotor)."</td>
                        <td style = \"text-align:right;padding:5px;\">".number_format($result['ppn'])."</td>
                        <td style = \"text-align:right;padding:5px;\">".number_format($result['pph'])."</td>
                        <td style = \"text-align:right;padding:5px;\">".number_format($result['iwp'])."</td>
                        <td style = \"text-align:right;padding:5px;\">".number_format($result['jkk'])."</td>
                        <td style = \"text-align:right;padding:5px;\">".number_format($result['jkm'])."</td>
                        <td style = \"text-align:right;padding:5px;\">".number_format($result['jk'])."</td>
                        <td style = \"text-align:right;padding:5px;\">".number_format($result['lainnya'])."</td>
                        <td style = \"text-align:right;padding:5px;\">".number_format($nilBersih)."</td>
                    </tr>
                </tbody>
            ";
            $no++;
        }

        $cRet .= "
                <tr>
                    <td colspan = \"6\" style = \"padding:10px;text-align:center;font-weight:bold;\">Total</td>
                    <td style = \"padding:10px;text-align:right;font-weight:bold;padding-right:5px;\">".number_format($totalkotor)."</td>
                    <td style = \"padding:10px;text-align:right;font-weight:bold;padding-right:5px;\">".number_format($totalppn)."</td>
                    <td style = \"padding:10px;text-align:right;font-weight:bold;padding-right:5px;\">".number_format($totalpph)."</td>
                    <td style = \"padding:10px;text-align:right;font-weight:bold;padding-right:5px;\">".number_format($totaliwp)."</td>
                    <td style = \"padding:10px;text-align:right;font-weight:bold;padding-right:5px;\">".number_format($totaljkk)."</td>
                    <td style = \"padding:10px;text-align:right;font-weight:bold;padding-right:5px;\">".number_format($totaljkm)."</td>
                    <td style = \"padding:10px;text-align:right;font-weight:bold;padding-right:5px;\">".number_format($totaljk)."</td>
                    <td style = \"padding:10px;text-align:right;font-weight:bold;padding-right:5px;\">".number_format($totallain)."</td>
                    <td style = \"padding:10px;text-align:right;font-weight:bold;padding-right:5px;\">".number_format($totalbersih)."</td>
                </tr>
        ";

        $cRet .= "</table>";

        $jumlah = "SELECT COUNT(*) as jumlah FROM trduji_sp2d WHERE no_uji = '$nomor'";
        $que = $this->db->query($jumlah)->row();
        $jumsp2d = $que->jumlah;

        $cRet .="
        <table style=\"border-collapse:collapse;font-family:Arial Black;font-size:12px;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\">
            <tr>
                <td colspan = \"4\" height>&nbsp;</td>
            </tr>
            <tr>
                <td width = \"20%\" style = \"padding:5px;font-weight:bold;\">Hari / Tanggal</td>
                <td width = \"20%\" style = \"padding:5px;font-weight:bold;\">: ".$this->tukd_model->hari_indo($tgl_uji)." / ".$this->tukd_model->tanggal_format_indonesia($tgl_uji)."</td>
                <td width = \"20%\" rowspan = \"7\" style = \"padding:5px;font-weight:bold;\">&nbsp;</td>
                <td width = \"40%\" rowspan = \"7\" style = \"text-align:center;padding:5px;font-weight:bold;\">
                    $daerah, ".$this->tukd_model->tanggal_format_indonesia($tgl_uji)." <br>
                    KEPALA BPKK <br><br><br><br><br><br><br>
                    <u> $nm_ttd </u> <br>
                    $nip_ttd
                </td>
            </tr>
            <tr>
                <td style = \"padding:5px;font-weight:bold;\">Jumlah SP2D</td>
                <td style = \"padding:5px;font-weight:bold;\">: $jumsp2d (".$this->tukd_model->terbilang_angka($jumsp2d).")</td>
            </tr>
            <tr>
                <td style = \"padding:5px;font-weight:bold;\">Jumlah Nilai SP2D</td>
                <td style = \"padding:5px;font-weight:bold;\">: Rp. ".number_format($totalkotor)."</td>
            </tr>
            <tr>
                <td style = \"padding:5px;font-weight:bold;\">&nbsp;</td>
                <td style = \"padding:5px;font-weight:bold;\">&nbsp;</td>
            </tr>
            <tr>
                <td style = \"padding:5px;font-weight:bold;\">&nbsp;</td>
                <td style = \"padding:5px;font-weight:bold;\">&nbsp;</td>
            </tr>
            <tr>
                <td style = \"padding:5px;font-weight:none;\">&nbsp;</td>
                <td style = \"padding:5px;font-weight:none;\">&nbsp;</td>
            </tr>
            <tr>
                <td style = \"padding:5px;font-weight:none;\">&nbsp;</td>
                <td style = \"padding:5px;font-weight:none;\">&nbsp;</td>
            </tr>
        </table>";      

        $time = date('d-m-Y H:i:s') ;
        $data['prev']= $cRet;
        switch ($jns_ctk) {
            case '1':
                echo $cRet;
                break;
            case '2':
                $this->_mpdf('',$cRet,10,10,10,'1',1,'');
                break;
            case '3':
                header("Cache-Control: no-cache, no-store, must-revalidate");
                header("Content-Type: application/vnd.ms-excel");
                header("Content-Disposition: attachment; filename=DAFTAR_PENGUJI_$time.xls");
                $this->load->view('anggaran/rka/perkadaII', $data);
                break;
            
            default:
                // code...
                break;
        }


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

        $this->mpdf = new mPDF('utf-8', array(210,330),$size); //folio
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