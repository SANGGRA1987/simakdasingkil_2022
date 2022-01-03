<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class pmk extends CI_Controller {

public $ppkd = "4.02.01";
public $ppkd1 = "4.02.01.00";

    function __contruct()
    {   
        parent::__construct();
    }
    function hal105() 
    {
        $data['page_title']= 'DALAM PROSES PERBAIKAN <BR> HALAMAN 105';
        $this->template->set('title', 'HALAMAN 105');   
        $this->template->load('template','pmk/hal105',$data) ; 
    }
    function hal107() 
    {
        $data['page_title']= 'DALAM PROSES PERBAIKAN <BR> HALAMAN 107';
        $this->template->set('title', 'HALAMAN 107');   
        $this->template->load('template','pmk/hal107',$data) ; 
    }
    function hal109() 
    {
        $data['page_title']= 'DALAM PROSES PERBAIKAN <BR> HALAMAN 111';
        $this->template->set('title', 'HALAMAN 111');   
        $this->template->load('template','pmk/hal111',$data) ; 
    }

    function hal111() 
    {
        $data['page_title']= 'DALAM PROSES PERBAIKAN <BR> HALAMAN 109';
        $this->template->set('title', 'HALAMAN 109');   
        $this->template->load('template','pmk/hal109',$data) ; 
    }
    function hal115() 
    {
        $data['page_title']= 'DALAM PROSES PERBAIKAN <BR> HALAMAN 115';
        $this->template->set('title', 'HALAMAN 115');   
        $this->template->load('template','pmk/hal115',$data) ; 
    }
    function hal117() 
    {
        $data['page_title']= 'DALAM PROSES PERBAIKAN <BR>HALAMAN 117';
        $this->template->set('title', 'HALAMAN 117');   
        $this->template->load('template','pmk/hal117',$data) ;  
    }
    function hal125() 
    {
        $data['page_title']= 'DALAM PROSES PERBAIKAN <BR>HALAMAN 126';
        $this->template->set('title', 'HALAMAN 125');   
        $this->template->load('template','pmk/hal125',$data) ; 
    }

function halaman115(){


    $tbl =" <table width='100%' border='0' cellpadding='0' cellspacing='0'  >
                <tr align='center' >
                    <td colspan='9' style='padding: 25px;'> LAPORAN PEMENUHAN INDIKATOR LAYANAN PENDIDIKAN</td>
                </tr>

            </table>";
    $tbl.=" <table width='100%' border='1' cellpadding='0' cellspacing='0' >
                <thead>
                 <tr align='center' >
                    <td rowspan='2'>No</td>
                    <td rowspan='2'>Kegiatan</td>
                    <td rowspan='2'>OPD</td>
                    <td rowspan='2'>Anggaran</td>
                    <td rowspan='2'>Realiasi</td>
                    <td rowspan='2'>Penyerapan</td>
                    <td colspan='3' align='center' style='padding: 5px;'>Output</td>
                 </tr>
                 <tr align='center'>
                    <td style='padding: 5px;'>Uraian</td>
                    <td>Target</td>
                    <td>Capaian</td>
                 </tr>
            </thead>
                 <tr align='center'>
                    <td>(a)</td>
                    <td>(b)</td>
                    <td>(c)</td>
                    <td>(d)</td>
                    <td>(e)</td>
                    <td>(f)=(e)/(d)</td>
                    <td>(g)</td>
                    <td>(h)</td>
                    <td>(i)</td>
                 </tr>
                 <tr align='center'>
                    <td>&nbsp;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                 </tr>
            
            ";

    $sql="SELECT * from (
        select b.kd_program kode, (select nm_program from m_prog WHERE kd_program=b.kd_program) kegiatan,a.kd_skpd, sum(nilai) nilai, 0 fortot, '' uraian, ''target, ''capaian  from trdrka a 
        INNER JOIN m_giat b on a.kd_kegiatan=b.kd_kegiatan GROUP BY b.kd_program,a.kd_skpd
        UNION all
        select b.kd_kegiatan kode, b.nm_kegiatan kegiatan, a.kd_skpd, sum(nilai) nilai, sum(nilai) fortot, c.tu_capai urian, c.tk_capai target, c.tk_kel capai  from trdrka a 
        INNER JOIN m_giat b on a.kd_kegiatan=b.kd_kegiatan 
        INNER JOIN trskpd c on a.kd_kegiatan=c.kd_kegiatan
        GROUP BY b.kd_kegiatan,  b.nm_kegiatan,a.kd_skpd,c.tu_capai,c.tk_capai,c.tk_kel

        ) x WHERE kd_skpd= '1.01.01.00' order by kode";
    $i=1;
    $total=0;
    $exe=$this->db->query($sql);
    foreach($exe->result() as $a){

        $kegiatan=$a->kegiatan;
        $kd_skpd=$a->kd_skpd;
        $nilai=$a->nilai;
        $uraian=$a->uraian;
        $target=$a->target;
        $capaian=$a->capaian;
        $jml=$a->fortot;
        $total=$total+$jml;

        $tbl .="<tr align='center'>
                    <td>".$i."</td>
                    <td align='left'>".$kegiatan."</td>
                    <td>".$kd_skpd."</td>
                    <td align='right'>".$nilai."</td>
                    <td>-</td>
                    <td>-</td>
                    <td>".$uraian."</td>
                    <td>".$target."</td>
                    <td>".$capaian."</td>
                 </tr>
                 ";
        $i++;


    }

    $tbl .=" <tr align='center'>
                    <td colspan='2'>Jumlah</td>
                    <td></td>
                    <td>Rp. $total</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
              </tr></table>";
            echo($tbl);


}

function halaman117(){


    $tbl =" <table width='100%' border='0' cellpadding='0' cellspacing='0'  >
                <tr align='center' >
                    <td colspan='9' style='padding: 25px;'> LAPORAN PEMENUHAN INDIKATOR LAYANAN KESEHATAN</td>
                </tr>

            </table>";
    $tbl.=" <table width='100%' border='1' cellpadding='0' cellspacing='0' >
                <thead>
                 <tr align='center' >
                    <td rowspan='2'>No</td>
                    <td rowspan='2'>Kegiatan</td>
                    <td rowspan='2'>OPD</td>
                    <td rowspan='2'>Anggaran</td>
                    <td rowspan='2'>Realiasi</td>
                    <td rowspan='2'>Penyerapan</td>
                    <td colspan='3' align='center' style='padding: 5px;'>Output</td>
                 </tr>
                 <tr align='center'>
                    <td style='padding: 5px;'>Uraian</td>
                    <td>Target</td>
                    <td>Capaian</td>
                 </tr>
            </thead>
                 <tr align='center'>
                    <td>(a)</td>
                    <td>(b)</td>
                    <td>(c)</td>
                    <td>(d)</td>
                    <td>(e)</td>
                    <td>(f)=(e)/(d)</td>
                    <td>(g)</td>
                    <td>(h)</td>
                    <td>(i)</td>
                 </tr>
                 <tr align='center'>
                    <td>&nbsp;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                 </tr>
            
            ";

    $sql="SELECT * from (
        select b.kd_program kode, (select nm_program from m_prog WHERE kd_program=b.kd_program) kegiatan,a.kd_skpd, sum(nilai) nilai, 0 fortot, '' uraian, ''target, ''capaian  from trdrka a 
        INNER JOIN m_giat b on a.kd_kegiatan=b.kd_kegiatan GROUP BY b.kd_program,a.kd_skpd
        UNION all
        select b.kd_kegiatan kode, b.nm_kegiatan kegiatan, a.kd_skpd, sum(nilai) nilai, sum(nilai) fortot, c.tu_capai urian, c.tk_capai target, c.tk_kel capai  from trdrka a 
        INNER JOIN m_giat b on a.kd_kegiatan=b.kd_kegiatan 
        INNER JOIN trskpd c on a.kd_kegiatan=c.kd_kegiatan
        GROUP BY b.kd_kegiatan,  b.nm_kegiatan,a.kd_skpd,c.tu_capai,c.tk_capai,c.tk_kel

        ) x WHERE kd_skpd= '1.01.01.00' order by kode";
    $i=1;
    $total=0;
    $exe=$this->db->query($sql);
    foreach($exe->result() as $a){

        $kegiatan=$a->kegiatan;
        $kd_skpd=$a->kd_skpd;
        $nilai=$a->nilai;
        $uraian=$a->uraian;
        $target=$a->target;
        $capaian=$a->capaian;
        $jml=$a->fortot;
        $total=$total+$jml;

        $tbl .="<tr align='center'>
                    <td>".$i."</td>
                    <td align='left'>".$kegiatan."</td>
                    <td>".$kd_skpd."</td>
                    <td align='right'>".$nilai."</td>
                    <td>-</td>
                    <td>-</td>
                    <td>".$uraian."</td>
                    <td>".$target."</td>
                    <td>".$capaian."</td>
                 </tr>
                 ";
        $i++;


    }

    $tbl .=" <tr align='center'>
                    <td colspan='2'>Jumlah</td>
                    <td></td>
                    <td>Rp. $total</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
              </tr></table>";
            echo($tbl);


}


function halaman111(){

        $tbl="<table width='100%' cellspacing='0' border='0' cellpadding='0'>
                <tr align='center'> 
                    <td width='95%' colspan='5'  style='padding: 20px'><b>LAPORAN BELANJA INFRASTRUKTUR DAERAH <br> YANG BERSUMBER DARI DANA TRANSFER UMUM <br> KABUPATEN SANGGAU <br> TAHUN ANGGARAN 2019</b></td>
                </tr>
                <tr> 
                    <td width='5%' align='center'>I</td>
                    <td width='95%' colspan='4' style='padding: 5px'>Penerimaan dari dana transfer umum</td>
                </tr>
                <tr>
                    <td width='5%' ></td>
                    <td width='30%'> a. DAU <br> b. DBH <br>Jumlah Penerimaan</td>
                    <td width='5%'>: <br>:<br></td>
                    <td width='60%'>Rp.<br>Rp.<br>Rp.</td>
                </tr>
                <tr> 
                    <td width='5%' align='center'>II</td>
                    <td width='95%' colspan='4' style='padding: 5px'>Pengurang</td>
                </tr>
                <tr>
                    <td width='5%'></td>
                    <td width='30%'>a. DAU tambahan <br> b. DBH earmarked <br>Jumlah Pengurangan</td>
                    <td width='5%'>: <br>:<br></td>
                    <td width='60%'>Rp.<br>Rp.<br>Rp.</td>
                </tr>
                <tr> 
                    <td width='5%' align='center'>III</td>
                    <td width='95%' colspan='4' style='padding: 5px'>Pengurang</td>
                </tr>
                <tr>
                    <td width='5%'></td>
                    <td width='30%'>Transfer Umum yang Diperhitungkan</td>
                    <td width='5%'>: </td>
                    <td width='60%'>Rp.</td>
                </tr>
                <tr> 
                    <td width='95%' colspan='5'  style='padding: 10px'></td>
                </tr>


            </table>";


        $tbl.="<table width='100%' cellspacing='0' border='1' cellpading='0'>
                <thead>
                <tr align='center'>
                    <td rowspan='3'>No</td>
                    <td rowspan='3'>Belanja</td>
                    <td colspan='5'style='padding: 5px'>Belanja Infrastruktur</td>
                </tr>
                <tr align='center'>
                    <td colspan='2' style='padding: 5px'>Output</td>
                    <td colspan='2'>Sumber Pendanaan</td>
                    <td rowspan='2'>Jumlah</td>
                </tr>
                 <tr align='center'>
                    <td style='padding: 5px'>Volume</td>
                    <td>Satuan</td>
                    <td>DAU</td>
                    <td>DBH</td>
                </tr>
                </thead>";

         $sql="SELECT top 5 * from (
                SELECT  a.kd_kegiatan,    a.kd_rek5,    a.volume1 volume, a.satuan1 satuan,
                    ( SELECT sumber FROM trdrka WHERE kd_kegiatan = a.kd_kegiatan and kd_rek5=a.kd_rek5
                    ) dau,  '' dbh, SUM(a.total) nilai FROM   trdpo a inner join trdrka b on a.kd_kegiatan=b.kd_kegiatan 
                GROUP BY a.kd_kegiatan, a.kd_rek5, a.volume1, a.satuan1
                union all

                select a.kd_kegiatan, ''kd_rek5, 0 volume, ''satuan, ''dau, ''dbh, sum(a.nilai) nilai from trdrka a 
                inner join trskpd b on a.kd_kegiatan=b.kd_kegiatan and a.kd_skpd=b.kd_skpd
                GROUP BY a.kd_kegiatan
                )oke ORDER BY kd_kegiatan, kd_rek5";

        $i=1;
        $total=0;
        $exe=$this->db->query($sql);
        foreach($exe->result() as $a){
            $kegiatan=$a->kd_kegiatan;
            $kd_rek5 =$a->kd_rek5;
            $volume  =$a->volume;
            $satuan  =$a->satuan;
            $dau     =$a->dau;
            $dbh     =$a->dbh;
            $nilai   =$a->nilai;
            $total   =$total+$nilai;

            $tbl .="<tr>
                        <td align='center'>$i</td>
                        <td>$kegiatan ||  $kd_rek5 </td>
                        <td align='center'>$volume</td>
                        <td align='center'>$satuan</td>
                        <td>$dau</td>
                        <td>$dbh</td>
                        <td align='right'>$nilai</td>                      
                    </tr>";
            $i++;
        }

            $tbl .="<tr>
                        <td colspan='2' align='left'>Jumlah Belanja Infrastruktur</td>
                        <td colspan='2' align='center'></td>
                        <td>Rp.</td>
                        <td>Rp.</td>
                        <td>Rp.  $total</td>                      
                    </tr>";
            $tbl .="<tr>
                        <td colspan='2' align='left'>Persentase Belanja Infrastruktur Terhadap I Transfer ke Daerah yang I penggunaannya bersifat umum </td>
                        <td colspan='2' align='center'></td>
                        <td></td>
                        <td></td>
                        <td></td>                     
                    </tr>";
            $tbl .="<tr>
                        <td colspan='7' align='left' style='border:0'>Demikian laporan ini dibuat sebenarnya.</td>                  
                    </tr>";
            $tbl .="<tr>
                        <td colspan='4' align='left' style='border:0'></td>
                        <td colspan='3' align='center' style='border:0'>
                                Sanggau, 23 Mei 2020 <br>
                                WALIKABUPATEN SANGGAU <br><br><br><br><br>
                                YAHYA ARROHMAN
                        </td>             
                    </tr>                   
                    ";

        $tbl.="</table>";

         echo($tbl);
}



	function halaman125(){

		$judul="LAPORAN PEMANFAATAN SEMENTARA DAN PENGANGGARAN KEMBALI <br>";
		$judul.="SISA DANA BAGI HASIL SUMBER DAYA ALAM KEHUTANAN DANA REBOISASI";
	    $tbl="<table width='100%' border='0' cellspacing='0' cellpadding='0'>
	            <tr align='center'>
	                <td style='padding:20px'>$judul</td>
	            </tr>
	            <tr align='left'>
	                <td style='padding:20px'>
	                   KOTA: PONTIANAK
	                </td>
	            </tr>
	        </table>";
	    $tbl.="<table width='100%' border='1' cellspacing='0' cellpadding='0'>
	            <thead>
	            <tr align='center'>
	                <td rowspan='2'>No</td>
	                <td rowspan='2'>Jenis Dana</td>
	                <td rowspan='2'>Jumlah Sisa</td>
	                <td colspan='2'>Pemanfaatan</td>
	                <td rowspan='2'>Sisa</td>
	                <td rowspan='2'>Penganggaran Kembali</td>
	            </tr> 
	            
	            <tr align='center'>
	                <td>Kegiatan</td>
	                <td>Nilai</td>
	            </tr> 
	            </thead>
	            <tr align='center'>
	            	<td>-</td>
	                <td>-</td>
	                <td>-</td>
	                <td>-</td>
	                <td>-</td>
	                <td>-</td>
	                <td>-</td>
	            </tr>";


	        /*================isi=============*/

	    $tbl.=" <tr align='center'>
	                <td colspan='2'>Total</td>
	                <td>-</td>
	                <td>-</td>
	                <td>-</td>
	                <td>-</td>
	                <td>-</td>
	            </tr>
	        </table>";
	    $tbl.="<table width='100%' border='0' cellspacing='0' cellpadding='0'>
	            <tr align='center'>
	                <td width='60%'></td>
	                <td width='40%' style='padding: 20px'>
	                    Sanggau, 23 Mei 2019 <br>
	                    Walikota KABUPATEN SANGGAU <br>
	                    <br>
	                    <br>
	                    <br>
	                    <br>
	                    <br>
	                    YAHYA ARROHMAN
	                </td>
	            </tr>
	        </table>";

	    echo($tbl);
	}


    function halaman109(){
        $judul="DAFTAR RINCIAN JUMLAH DAN REALISASI PEMBAYARAN GAJI PPPK DAERAH PEMERINTAH DAERAH <br>";
        $judul.="KABUPATEN SANGGAU <br>";
        $judul.="BULAN 12 TAHUN 2019";

        $tbl="<table border='0' width='100%' cellspacing='0' cellpadding='0'>
                <tr>
                    <td align='center' style='padding: 25px';>$judul</td>
                </tr>
            </table>";

        $tbl.="<table border='1' width='100%' cellspacing='0' cellpadding='0'>
        <thead>
                    <tr>
                        <td rowspan='2' align='center' style='padding: 25px'>No</td>
                        <td rowspan='2' align='center'>Golongan</td>
                        <td rowspan='2' align='center'>Jumlah Pegawai</td>
                        <td rowspan='2' align='center'>Gaji Pokok</td>
                        <td rowspan='2' align='center'>Tunjangan Keluarga</td>
                        <td colspan='2' align='center'>Tunjangan Jabatan</td>
                        <td rowspan='2' align='center'>Tunjangan Umum</td>
                        <td rowspan='2' align='center'>Tunjangan PPh</td>
                        <td rowspan='2' align='center'>Tunjangan Beras</td>
                        <td rowspan='2' align='center'>Tunjangan Lainnya</td>
                        <td rowspan='2' align='center'>Lain-lain</td>
                        <td rowspan='2' align='center'>Gaji Kotor</td>
                        <td rowspan='2' align='center'>TPP/TUKIN</td>
                        <td rowspan='2' align='center'>Total Penghasilan</td>
                    </tr>
                    <tr>
                        <td align='center'>Struktural</td>
                        <td align='center'>Fungsional</td>
                    </tr>
        </thead>
                    <tr>
                        <td align='center'>(1)</td>
                        <td align='center'>(2)</td>
                        <td align='center'>(3)</td>
                        <td align='center'>(4)</td>
                        <td align='center'>(5)</td>
                        <td align='center'>(6)</td>
                        <td align='center'>(7)</td>
                        <td align='center'>(8)</td>
                        <td align='center'>(9)</td>
                        <td align='center'>(10)</td>
                        <td align='center'>(11)</td>
                        <td align='center'>(12)</td>
                        <td align='center'>(13)</td>
                        <td align='center'>(14)</td>
                        <td align='center'>(15)</td>
                    </tr>
        ";
                $tbl.="<tr>
                        <td align='right'>&nbsp;</td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                    </tr>";


                $tbl.="<tr>
                        <td colspan='2' align='center'>JUMLAH</td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                    </tr>";
                $tbl.="<tr>
                        <td colspan='10' style='border:0;'> </td>
                        <td colspan='5' align='center' style='border:0; padding:20px'> 
                            Sanggau, 23 Mei 2020 <br>
                            Kepala BPKAD <br> <br> <br> <br>
                            YAHYA ARROHMAN


                        </td>

                    </tr>";



        $tbl.="</table>";

        echo "$tbl";
    }

function halaman107(){
        $judul="DAFTAR RINCIAN JUMLAH DAN REALISASI PEMBAYARAN GAJI PNS DAERAH PEMERINTAH DAERAH ";
        $judul.="KABUPATEN SANGGAU <br>";
        $judul.="BULAN 12 TAHUN 2019";

        $tbl="<table border='0' width='100%' cellspacing='0' cellpadding='0'>
                <tr>
                    <td align='center' style='padding: 25px';>$judul</td>
                </tr>
            </table>";

        $tbl.="<table border='1' width='100%' cellspacing='0' cellpadding='0'>
        <thead>
                    <tr>
                        <td rowspan='2' align='center' style='padding: 25px'>No</td>
                        <td rowspan='2' align='center'>Golongan</td>
                        <td rowspan='2' align='center'>Jumlah Pegawai</td>
                        <td rowspan='2' align='center'>Gaji Pokok</td>
                        <td rowspan='2' align='center'>Tunjangan Keluarga</td>
                        <td colspan='2' align='center'>Tunjangan Jabatan</td>
                        <td rowspan='2' align='center'>Tunjangan Umum</td>
                        <td rowspan='2' align='center'>Tunjangan PPh</td>
                        <td rowspan='2' align='center'>Tunjangan Beras</td>
                        <td rowspan='2' align='center'>Tunjangan Lainnya</td>
                        <td rowspan='2' align='center'>Lain-lain</td>
                        <td rowspan='2' align='center'>Gaji Kotor</td>
                        <td rowspan='2' align='center'>TPP/TUKIN</td>
                        <td rowspan='2' align='center'>Total Penghasilan</td>
                    </tr>
                    <tr>
                        <td align='center'>Struktural</td>
                        <td align='center'>Fungsional</td>
                    </tr>
        </thead>
                    <tr>
                        <td align='center'>(1)</td>
                        <td align='center'>(2)</td>
                        <td align='center'>(3)</td>
                        <td align='center'>(4)</td>
                        <td align='center'>(5)</td>
                        <td align='center'>(6)</td>
                        <td align='center'>(7)</td>
                        <td align='center'>(8)</td>
                        <td align='center'>(9)</td>
                        <td align='center'>(10)</td>
                        <td align='center'>(11)</td>
                        <td align='center'>(12)</td>
                        <td align='center'>(13)</td>
                        <td align='center'>(14)</td>
                        <td align='center'>(15)</td>
                    </tr>
        ";
                $tbl.="<tr>
                        <td align='right'>&nbsp;</td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                    </tr>";
                $tbl.="<tr>
                        <td align='right'>1</td>
                        <td align='left'>Pelaksana</td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                    </tr>";
                $tbl.="<tr>
                        <td align='right'></td>
                        <td align='left'>a. Golongan IV</td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                    </tr>";
                $tbl.="<tr>
                        <td align='right'>&nbsp;</td>
                        <td align='left'>b. Golongan III</td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                    </tr>";
                $tbl.="<tr>
                        <td align='right'>&nbsp;</td>
                        <td align='left'>c. Golongan II</td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                    </tr>";

                $tbl.="<tr>
                        <td colspan='2' align='center'>JUMLAH</td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                        <td align='right'></td>
                    </tr>";
                $tbl.="<tr>
                        <td colspan='10' style='border:0;'> </td>
                        <td colspan='5' align='center' style='border:0; padding:20px'> 
                            Sanggau, 23 Mei 2020 <br>
                            Kepala BPKAD <br> <br> <br> <br>
                            YAHYA ARROHMAN


                        </td>

                    </tr>";



        $tbl.="</table>";

        echo "$tbl";
    }


    function halaman105(){
        $judul="LAPORAN KEGIATAN PENGELOLAAN SANITASI LINGKUNGAN <br>";
        $judul.="SEMESTER: 1/11 TAHUN ANGGARAN 2019 <br>";
        $judul.="KABUPATEN SANGGAU";

        $tbl="<table width='100%' border='0' cellpadding='0' cellspacing='0'>
                <tr>
                    <td align='center' style='padding:20px'>$judul</td>
                </tr>
            </table>";

        $tbl.="<table width='100%' border='1' cellpadding='0' cellspacing='0'>
                <thead>
                <tr>
                    <td rowspan='2' align='center'>No</td>
                    <td rowspan='2' align='center'>Kegiatan</td>
                    <td rowspan='2' align='center'>Sumber Dana</td>
                    <td rowspan='2' align='center'>Anggaran</td>
                    <td rowspan='2' align='center'>Realisasi</td>
                    <td rowspan='2' align='center'>Penyerapan</td>
                    <td colspan='3' align='center'>Output</td>
                </tr>
                <tr>
                    <td align='center'>Uraian</td>
                    <td align='center'>Target</td>
                    <td align='center'>Capaian</td>
                </tr>
                <thead>
                <tr>
                    <td align='center'>(a)</td>
                    <td align='center'>(b)</td>
                    <td align='center'>(c)</td>
                    <td align='center'>(d)</td>
                    <td align='center'>(e)</td>
                    <td align='center'>(f)</td>
                    <td align='center'>(g)</td>
                    <td align='center'>(h)</td>
                    <td align='center'>(i)</td>
                </tr>";

        $tbl.="<tr>
                    <td align='center'>&nbsp;</td>
                    <td align='center'>&nbsp;</td>
                    <td align='center'>&nbsp;</td>
                    <td align='center'>&nbsp;</td>
                    <td align='center'>&nbsp;</td>
                    <td align='center'>&nbsp;</td>
                    <td align='center'>&nbsp;</td>
                    <td align='center'>&nbsp;</td>
                    <td align='center'>&nbsp;</td>
                </tr>";

        $tbl.="<tr>
                    <td colspan='2' align='center'>TOTAL</td>
                    <td align='center'>&nbsp;</td>
                    <td align='right'>&nbsp;</td>
                    <td align='right'>&nbsp;</td>
                    <td align='right'>&nbsp;</td>
                    <td align='center'>&nbsp;</td>
                    <td align='center'>&nbsp;</td>
                    <td align='center'>&nbsp;</td>
                </tr>";

        $penutup="<p> &emsp; Dengan ini menyatakan bahwa saya bertanggung jawab penuh atas
                kebenaran Laporan ini dan bukti-bukti realisasi yang tercantum dalam
                laporan ini, disimpan sesuai dengan ketentuan yang berlaku untuk
                kelengkapan administrasi dan keperluan pemeriksaan aparat pengawas
                fungsional.<p>
                &emsp; Demikian laporan ini dibuat dengan sebenarnya . ";
        $tbl.="<tr>
                    <td colspan='9' align='left' style='padding:20px; border:0px'>$penutup</td>
              </tr>";
        $tbl.="<tr>
                    <td colspan='5' align='center' style='border:0px'></td>
                    <td colspan='4' align='center' style='border:0px'>Sanggau, 23 Mei 2019 <br>
                        WALIKABUPATEN SANGGAU <br><br><br><br>
                        YAHYA ARROHMAN
                    </td>
                </tr>";                
        $tbl.="</table>";
            echo "$tbl";
    }


}