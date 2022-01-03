<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 
 */

class cetak_angkas_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
  
    function cetak_angkas_ro_asl($tgl,$ttd1,$ttd2,$jenis,$skpd,$giat,$hit,$cret){

        $thn=$this->session->userdata('pcThang');
        $sql=$this->db->query("SELECT nm_skpd from ms_skpd WHERE kd_skpd='$skpd'")->row();
        $cetak="<table border='0', width='100%' style='font-size: 14px'>
                    <tr style='padding:10px'>
                        <td colspan='3' align='center'><b><BR> ANGGARAN KAS KEGIATAN MURNI<br> {$sql->nm_skpd} <br> TAHUN $thn <br></td>
                    </tr>
                </table>";
        $cetak.="<table style='border-collapse:collapse;font-size:12px' width='100%' align='center' border='1' cellspacing='0' cellpadding='2'>
                    <thead>
                    <tr>
                        <td width='8%' align='center' rowspan='2'  ><b>Kode</td>
                        <td width='12%'align='center' rowspan='2' ><b>Uraian</td>
                        <td width='8%' align='center' rowspan='2' ><b>Jumlah</td>
                        <td width='24%' align='center' colspan='3' ><b>Triwulan I (Rp).</td>
                        <td width='24%' align='center' colspan='3' ><b>Triwulan II (Rp).</td>
                        <td width='24%' align='center' colspan='3' ><b>Triwulan III (Rp).</td>
                        <td width='24%' align='center' colspan='3' ><b>Triwulan IV (Rp).</td>                        
                    </tr> 
                    <tr>
                        <td width='6%' align='center'><b>Jan</td>
                        <td width='6%' align='center'><b>Feb</td>
                        <td width='6%' align='center'><b>Mar</td>
                        <td width='6%' align='center'><b>Apr</td>
                        <td width='6%' align='center'><b>Mei</td>
                        <td width='6%' align='center'><b>Jun</td>
                        <td width='6%' align='center'><b>Jul</td>
                        <td width='6%' align='center'><b>Ags</td>
                        <td width='6%' align='center'><b>Sep</td>
                        <td width='6%' align='center'><b>Okt</td>
                        <td width='6%' align='center'><b>Nov</td>
                        <td width='6%' align='center'><b>Des</td>
                    </tr>
                    </thead>";

        $sql="
            SELECT kd_kegiatan+'.' giat, kd_rek6, (select nm_rek6 from ms_rek6 WHERE kd_rek6=xxx.kd_rek6) nm_rek, 
            sum(jan) jan, sum(feb) feb, sum(mar) mar, sum(apr) apr, sum(mei) mei, sum(jun) jun,
            sum(jul) jul, sum(ags) ags, sum(sep) sep, sum(okt) okt, sum(nov) nov, sum(des) des
            from (
            select kd_kegiatan, kd_rek6,
            case when bulan=1 then sum($jenis) else 0 end as jan,
            case when bulan=2 then sum($jenis) else 0 end as feb,
            case when bulan=3 then sum($jenis) else 0 end as mar,
            case when bulan=4 then sum($jenis) else 0 end as apr,
            case when bulan=5 then sum($jenis) else 0 end as mei,
            case when bulan=6 then sum($jenis) else 0 end as jun,
            case when bulan=7 then sum($jenis) else 0 end as jul,
            case when bulan=8 then sum($jenis) else 0 end as ags,
            case when bulan=9 then sum($jenis) else 0 end as sep,
            case when bulan=10 then sum($jenis) else 0 end as okt,
            case when bulan=11 then sum($jenis) else 0 end as nov,
            case when bulan=12 then sum($jenis) else 0 end as des from trdskpd_ro a inner join 
            (select kd_sub_kegiatan oke, kd_skpd from trdrka GROUP by kd_sub_kegiatan,kd_skpd) b 
            on b.oke=a.kd_kegiatan and a.kd_skpd=b.kd_skpd WHERE left(a.kd_skpd,20)=left('$skpd',20) and a.kd_kegiatan='$giat'
            GROUP BY kd_kegiatan, kd_rek6, bulan)xxx
            GROUP BY kd_kegiatan, kd_rek6
            UNION ALL
            SELECT kd_kegiatan giat, '' OKE, (select nm_sub_kegiatan from ms_sub_kegiatan WHERE kd_sub_kegiatan=xxx.kd_kegiatan) nm_giat, 
            isnull(sum(jan),0) jan, isnull(sum(feb),0) feb, isnull(sum(mar),0) mar, isnull(sum(apr),0) apr, isnull(sum(mei),0) mei, isnull(sum(jun),0) jun,
            isnull(sum(jul),0) jul, isnull(sum(ags),0) ags, isnull(sum(sep),0) sep, isnull(sum(okt),0) okt, isnull(sum(nov),0) nov, isnull(sum(des),0) des
            from (
            select kd_kegiatan,
            case when bulan=1 then sum($jenis) else 0 end as jan,
            case when bulan=2 then sum($jenis) else 0 end as feb,
            case when bulan=3 then sum($jenis) else 0 end as mar,
            case when bulan=4 then sum($jenis) else 0 end as apr,
            case when bulan=5 then sum($jenis) else 0 end as mei,
            case when bulan=6 then sum($jenis) else 0 end as jun,
            case when bulan=7 then sum($jenis) else 0 end as jul,
            case when bulan=8 then sum($jenis) else 0 end as ags,
            case when bulan=9 then sum($jenis) else 0 end as sep,
            case when bulan=10 then sum($jenis) else 0 end as okt,
            case when bulan=11 then sum($jenis) else 0 end as nov,
            case when bulan=12 then sum($jenis) else 0 end as des from trdskpd_ro a inner join 
            (select kd_sub_kegiatan oke, kd_skpd from trdrka GROUP by kd_sub_kegiatan,kd_skpd) b 
            on b.oke=a.kd_kegiatan and a.kd_skpd=b.kd_skpd WHERE left(a.kd_skpd,20)=left('$skpd',20) and a.kd_kegiatan='$giat'
            GROUP BY kd_kegiatan, bulan)xxx
            GROUP BY kd_kegiatan
            ORDER BY giat";
        $aa=0; $b=0; $c=0; $d=0; $e=0; $f=0; $g=0; $h=0; $i=0; $j=0; $k=0; $l=0; $tot=0;        
        $exe=$this->db->query($sql);
        foreach($exe->result() as $a){
            $giat   =$a->giat;
            $rek    =$a->kd_rek6;
            $nm_rek =$a->nm_rek;
            $jan    =$a->jan;
            $feb    =$a->feb;
            $mar    =$a->mar;
            $apr    =$a->apr;
            $mei    =$a->mei;
            $jun    =$a->jun;
            $jul    =$a->jul;
            $ags    =$a->ags;
            $sep    =$a->sep;
            $okt    =$a->okt;
            $nov    =$a->nov;
            $des    =$a->des;

            $jumlah1 =$jan+$feb+$mar+$apr+$mei+$jun+$jul+$ags+$sep+$okt+$nov+$des;
            if($rek==''){
                $aa=$aa+$jan; $g=$g+$jul;
                $b=$b+$feb; $h=$h+$ags;
                $c=$c+$mar; $i=$i+$sep;
                $d=$d+$apr; $j=$j+$okt;
                $e=$e+$mei; $k=$k+$nov;
                $f=$f+$jun; $l=$l+$des;
                $jumlah =$jan+$feb+$mar+$apr+$mei+$jun+$jul+$ags+$sep+$okt+$nov+$des;
                $tot    =$tot+$jumlah;                
            }



            $cetak.="
                    <tr>
                        <td>".$giat.$rek."</td>
                        <td>$nm_rek</td>
                        <td align='right'>".number_format($jumlah1,'2',',','.')."</td>
                        <td align='right'>".number_format($jan,'2',',','.')."</td>
                        <td align='right'>".number_format($feb,'2',',','.')."</td>
                        <td align='right'>".number_format($mar,'2',',','.')."</td>
                        <td align='right'>".number_format($apr,'2',',','.')."</td>
                        <td align='right'>".number_format($mei,'2',',','.')."</td>
                        <td align='right'>".number_format($jun,'2',',','.')."</td>
                        <td align='right'>".number_format($jul,'2',',','.')."</td>
                        <td align='right'>".number_format($ags,'2',',','.')."</td>
                        <td align='right'>".number_format($sep,'2',',','.')."</td>
                        <td align='right'>".number_format($okt,'2',',','.')."</td>
                        <td align='right'>".number_format($nov,'2',',','.')."</td>
                        <td align='right'>".number_format($des,'2',',','.')."</td>
                    </tr>";
        }
        $cetak.="   <tr>
                        <td colspan='2' align='center'><b>Total</td>
                        <td align='right'><b>".number_format($tot,'2',',','.')."</td>
                        <td align='right'><b>".number_format($aa,'2',',','.')."</td>
                        <td align='right'><b>".number_format($b,'2',',','.')."</td>
                        <td align='right'><b>".number_format($c,'2',',','.')."</td>
                        <td align='right'><b>".number_format($d,'2',',','.')."</td>
                        <td align='right'><b>".number_format($e,'2',',','.')."</td>
                        <td align='right'><b>".number_format($f,'2',',','.')."</td>
                        <td align='right'><b>".number_format($g,'2',',','.')."</td>
                        <td align='right'><b>".number_format($h,'2',',','.')."</td>
                        <td align='right'><b>".number_format($i,'2',',','.')."</td>
                        <td align='right'><b>".number_format($j,'2',',','.')."</td>
                        <td align='right'><b>".number_format($k,'2',',','.')."</td>
                        <td align='right'><b>".number_format($l,'2',',','.')."</td>
                    </tr>";
        $cetak.="   <tr>
                        <td colspan='2' align='center'><b>Total Triwulan</td>
                        <td align='right' ><b>".number_format($tot,'2',',','.')."</td>
                        <td align='center' colspan='3' ><b>".number_format($aa+$b+$c,'2',',','.')."</td>
                        <td align='center' colspan='3' ><b>".number_format($d+$e+$f,'2',',','.')."</td>
                        <td align='center' colspan='3' ><b>".number_format($g+$h+$i,'2',',','.')."</td>
                        <td align='center' colspan='3' ><b>".number_format($j+$k+$l,'2',',','.')."</td>
                    </tr>";
        $cetak.="</table>";

        if($hit!="hidden"){ /*if hidden*/
            $sql = "SELECT * from ms_ttd WHERE id='$ttd1'";
            $exe = $this->db->query($sql);
            foreach ($exe->result() as $a) {
                $nip    = $a->nip; 
                $nama   = $a->nama;
                $jabatan= $a->jabatan;
                $pangkat= $a->pangkat;
            }
            $sql = "SELECT * from ms_ttd WHERE id='$ttd2'";
            $exe = $this->db->query($sql);
            foreach ($exe->result() as $a) {
                $nip2    = $a->nip;
                $nama2   = $a->nama;
                $jabatan2= $a->jabatan;
                $pangkat2= $a->pangkat;
            }    

            $cetak.="<table width='100%' border='0' style='font-size: 12px'>
                        <tr>
                            <td width='50%' align='center'><br>
                                Mengetahui, <br>
                                $jabatan2
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <b><u>$nama2</u></b><br>
                                NIP. $nip2
                            </td>
                            <td width='50%' align='center'><br>
                                Sanggau, ".$this->support->tanggal_format_indonesia($tgl)." <br>
                                $jabatan
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <b><u>$nama</u></b><br>
                                NIP. $nip
                            </td>
                        </tr>

                    </table>";
        } /*end if hidden*/

        switch ($cret){
            case '1':
                echo ("<title>ANGKAS RO </title>");
                echo "$cetak";
                break;
            case '2':
                $this->master_pdf->_mpdf('',$cetak,10,10,10,'1');        
                break;
            case '3':
                header("Content-Type: application/vnd.ms-excel");
                header("Content-Disposition: attachment; filename= AngkasRO-$skpd.xls");
                echo "$cetak";
                break;            
        }

    }


    function cetak_angkas_ro($tgl,$ttd1,$ttd2,$jenis,$skpd,$subgiat,$hit,$cret){

        $thn=$this->session->userdata('pcThang');
        $sql=$this->db->query("SELECT nm_skpd from ms_skpd WHERE kd_skpd='$skpd'")->row();
        $cetak="<table border='0', width='100%' style='font-size: 14px'>
                    <tr style='padding:10px'>
                        <td colspan='3' align='center'><b><BR> ANGGARAN KAS KEGIATAN MURNI<br> {$sql->nm_skpd} <br> TAHUN $thn <br></td>
                    </tr>
                </table>";
        $cetak.="<table style='border-collapse:collapse;font-size:12px' width='100%' align='center' border='1' cellspacing='0' cellpadding='2'>
                    <thead>
                    <tr>
                        <td width='8%' align='center' rowspan='2'  ><b>Kode</td>
                        <td width='12%'align='center' rowspan='2' ><b>Uraian</td>
                        <td width='8%' align='center' rowspan='2' ><b>Jumlah</td>
                        <td width='24%' align='center' colspan='3' ><b>Triwulan I (Rp).</td>
                        <td width='24%' align='center' colspan='3' ><b>Triwulan II (Rp).</td>
                        <td width='24%' align='center' colspan='3' ><b>Triwulan III (Rp).</td>
                        <td width='24%' align='center' colspan='3' ><b>Triwulan IV (Rp).</td>                        
                    </tr> 
                    <tr>
                        <td width='6%' align='center'><b>Jan</td>
                        <td width='6%' align='center'><b>Feb</td>
                        <td width='6%' align='center'><b>Mar</td>
                        <td width='6%' align='center'><b>Apr</td>
                        <td width='6%' align='center'><b>Mei</td>
                        <td width='6%' align='center'><b>Jun</td>
                        <td width='6%' align='center'><b>Jul</td>
                        <td width='6%' align='center'><b>Ags</td>
                        <td width='6%' align='center'><b>Sep</td>
                        <td width='6%' align='center'><b>Okt</td>
                        <td width='6%' align='center'><b>Nov</td>
                        <td width='6%' align='center'><b>Des</td>
                    </tr>
                    </thead>";

        $sql="SELECT kd_subkegiatan+'.' giat, kd_rek6, (select nm_rek6 from ms_rek6 WHERE kd_rek6=xxx.kd_rek6) nm_rek, 
            sum(jan) jan, sum(feb) feb, sum(mar) mar, sum(apr) apr, sum(mei) mei, sum(jun) jun,
            sum(jul) jul, sum(ags) ags, sum(sep) sep, sum(okt) okt, sum(nov) nov, sum(des) des
            from (
            select kd_subkegiatan, kd_rek6,
            case when bulan=1 then sum($jenis) else 0 end as jan,
            case when bulan=2 then sum($jenis) else 0 end as feb,
            case when bulan=3 then sum($jenis) else 0 end as mar,
            case when bulan=4 then sum($jenis) else 0 end as apr,
            case when bulan=5 then sum($jenis) else 0 end as mei,
            case when bulan=6 then sum($jenis) else 0 end as jun,
            case when bulan=7 then sum($jenis) else 0 end as jul,
            case when bulan=8 then sum($jenis) else 0 end as ags,
            case when bulan=9 then sum($jenis) else 0 end as sep,
            case when bulan=10 then sum($jenis) else 0 end as okt,
            case when bulan=11 then sum($jenis) else 0 end as nov,
            case when bulan=12 then sum($jenis) else 0 end as des from trdskpd_ro a inner join 
            (select kd_subkegiatan oke, kd_skpd from trdrka GROUP by kd_subkegiatan,kd_skpd) b 
            on b.oke=a.kd_subkegiatan and a.kd_skpd=b.kd_skpd WHERE left(a.kd_skpd,17)=left('$skpd',17) and a.kd_subkegiatan='$subgiat'
            GROUP BY kd_subkegiatan, kd_rek6, bulan)xxx
            GROUP BY kd_subkegiatan, kd_rek6
            UNION ALL
            SELECT kd_subkegiatan giat, '' OKE, (select nm_subkegiatan from ms_sub_kegiatan WHERE kd_subkegiatan=xxx.kd_subkegiatan) nm_giat, 
            isnull(sum(jan),0) jan, isnull(sum(feb),0) feb, isnull(sum(mar),0) mar, isnull(sum(apr),0) apr, isnull(sum(mei),0) mei, isnull(sum(jun),0) jun,
            isnull(sum(jul),0) jul, isnull(sum(ags),0) ags, isnull(sum(sep),0) sep, isnull(sum(okt),0) okt, isnull(sum(nov),0) nov, isnull(sum(des),0) des
            from (
            select kd_subkegiatan,
            case when bulan=1 then sum($jenis) else 0 end as jan,
            case when bulan=2 then sum($jenis) else 0 end as feb,
            case when bulan=3 then sum($jenis) else 0 end as mar,
            case when bulan=4 then sum($jenis) else 0 end as apr,
            case when bulan=5 then sum($jenis) else 0 end as mei,
            case when bulan=6 then sum($jenis) else 0 end as jun,
            case when bulan=7 then sum($jenis) else 0 end as jul,
            case when bulan=8 then sum($jenis) else 0 end as ags,
            case when bulan=9 then sum($jenis) else 0 end as sep,
            case when bulan=10 then sum($jenis) else 0 end as okt,
            case when bulan=11 then sum($jenis) else 0 end as nov,
            case when bulan=12 then sum($jenis) else 0 end as des from trdskpd_ro a inner join 
            (select kd_subkegiatan oke, kd_skpd from trdrka GROUP by kd_subkegiatan,kd_skpd) b 
            on b.oke=a.kd_subkegiatan and a.kd_skpd=b.kd_skpd WHERE left(a.kd_skpd,17)=left('$skpd',17) and a.kd_subkegiatan='$subgiat'
            GROUP BY kd_subkegiatan, bulan)xxx
            GROUP BY kd_subkegiatan
            ORDER BY giat";
        $aa=0; $b=0; $c=0; $d=0; $e=0; $f=0; $g=0; $h=0; $i=0; $j=0; $k=0; $l=0; $tot=0;        
        $exe=$this->db->query($sql);
        foreach($exe->result() as $a){
            $subgiat   =$a->giat;
            $rek    =$a->kd_rek6;
            $nm_rek =$a->nm_rek;
            $jan    =$a->jan;
            $feb    =$a->feb;
            $mar    =$a->mar;
            $apr    =$a->apr;
            $mei    =$a->mei;
            $jun    =$a->jun;
            $jul    =$a->jul;
            $ags    =$a->ags;
            $sep    =$a->sep;
            $okt    =$a->okt;
            $nov    =$a->nov;
            $des    =$a->des;

            $jumlah1 =$jan+$feb+$mar+$apr+$mei+$jun+$jul+$ags+$sep+$okt+$nov+$des;
            if($rek==''){
                $aa=$aa+$jan; $g=$g+$jul;
                $b=$b+$feb; $h=$h+$ags;
                $c=$c+$mar; $i=$i+$sep;
                $d=$d+$apr; $j=$j+$okt;
                $e=$e+$mei; $k=$k+$nov;
                $f=$f+$jun; $l=$l+$des;
                $jumlah =$jan+$feb+$mar+$apr+$mei+$jun+$jul+$ags+$sep+$okt+$nov+$des;
                $tot    =$tot+$jumlah;                
            }



            $cetak.="
                    <tr>
                        <td>".$subgiat.$rek."</td>
                        <td>$nm_rek</td>
                        <td align='right'>".number_format($jumlah1,'2',',','.')."</td>
                        <td align='right'>".number_format($jan,'2',',','.')."</td>
                        <td align='right'>".number_format($feb,'2',',','.')."</td>
                        <td align='right'>".number_format($mar,'2',',','.')."</td>
                        <td align='right'>".number_format($apr,'2',',','.')."</td>
                        <td align='right'>".number_format($mei,'2',',','.')."</td>
                        <td align='right'>".number_format($jun,'2',',','.')."</td>
                        <td align='right'>".number_format($jul,'2',',','.')."</td>
                        <td align='right'>".number_format($ags,'2',',','.')."</td>
                        <td align='right'>".number_format($sep,'2',',','.')."</td>
                        <td align='right'>".number_format($okt,'2',',','.')."</td>
                        <td align='right'>".number_format($nov,'2',',','.')."</td>
                        <td align='right'>".number_format($des,'2',',','.')."</td>
                    </tr>";
        }
        $cetak.="   <tr>
                        <td colspan='2' align='center'><b>Total</td>
                        <td align='right'><b>".number_format($tot,'2',',','.')."</td>
                        <td align='right'><b>".number_format($aa,'2',',','.')."</td>
                        <td align='right'><b>".number_format($b,'2',',','.')."</td>
                        <td align='right'><b>".number_format($c,'2',',','.')."</td>
                        <td align='right'><b>".number_format($d,'2',',','.')."</td>
                        <td align='right'><b>".number_format($e,'2',',','.')."</td>
                        <td align='right'><b>".number_format($f,'2',',','.')."</td>
                        <td align='right'><b>".number_format($g,'2',',','.')."</td>
                        <td align='right'><b>".number_format($h,'2',',','.')."</td>
                        <td align='right'><b>".number_format($i,'2',',','.')."</td>
                        <td align='right'><b>".number_format($j,'2',',','.')."</td>
                        <td align='right'><b>".number_format($k,'2',',','.')."</td>
                        <td align='right'><b>".number_format($l,'2',',','.')."</td>
                    </tr>";
        $cetak.="   <tr>
                        <td colspan='2' align='center'><b>Total Triwulan</td>
                        <td align='right' ><b>".number_format($tot,'2',',','.')."</td>
                        <td align='center' colspan='3' ><b>".number_format($aa+$b+$c,'2',',','.')."</td>
                        <td align='center' colspan='3' ><b>".number_format($d+$e+$f,'2',',','.')."</td>
                        <td align='center' colspan='3' ><b>".number_format($g+$h+$i,'2',',','.')."</td>
                        <td align='center' colspan='3' ><b>".number_format($j+$k+$l,'2',',','.')."</td>
                    </tr>";
        $cetak.="</table>";

        if($hit!="hidden"){ /*if hidden*/
            $sql = "SELECT * from ms_ttd WHERE id='$ttd1'";
            $exe = $this->db->query($sql);
            foreach ($exe->result() as $a) {
                $nip    = $a->nip; 
                $nama   = $a->nama;
                $jabatan= $a->jabatan;
                $pangkat= $a->pangkat;
            }
            $sql = "SELECT * from ms_ttd WHERE id='$ttd2'";
            $exe = $this->db->query($sql);
            foreach ($exe->result() as $a) {
                $nip2    = $a->nip;
                $nama2   = $a->nama;
                $jabatan2= $a->jabatan;
                $pangkat2= $a->pangkat;
            }    

            $cetak.="<table width='100%' border='0' style='font-size: 12px'>
                        <tr>
                            <td width='50%' align='center'><br>
                                Mengetahui, <br>
                                $jabatan2
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <b><u>$nama2</u></b><br>
                                NIP. $nip2
                            </td>
                            <td width='50%' align='center'><br>
                                Sanggau, ".$this->support->tanggal_format_indonesia($tgl)." <br>
                                $jabatan
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <b><u>$nama</u></b><br>
                                NIP. $nip
                            </td>
                        </tr>

                    </table>";
        } /*end if hidden*/

        switch ($cret){
            case '1':
                echo ("<title>ANGKAS RO </title>");
                echo "$cetak";
                break;
            case '2':
			
		//	$judul='',$isi='',$lMargin=10,$rMargin=10,$font='',$orientasi='',$hal='', $fonsize=''
                $this->master_pdf->_mpdf('',$cetak,10,10,10,'1','','');        
                break;
            case '3':
                header("Content-Type: application/vnd.ms-excel");
                header("Content-Disposition: attachment; filename= AngkasRO-$skpd.xls");
                echo "$cetak";
                break;            
        }

    }


    function cetak_angkas_giat($tgl='',$ttd1='',$ttd2='',$jenis='',$skpd='',$ctk='',$hid=''){


        $thn=$this->session->userdata('pcThang');
        $sql=$this->db->query("SELECT nm_skpd from ms_skpd WHERE kd_skpd='$skpd'")->row();
        $cetak="<table border='0', width='100%' style='font-size: 14px'>
                    <tr style='padding:10px'>
                        <td colspan='3' align='center'><b><BR> ANGGARAN KAS KEGIATAN MURNI<br> {$sql->nm_skpd} <br> TAHUN $thn <br></td>
                    </tr>
                </table>";

        $cetak.="<table style='border-collapse: collapse; font-size:12px;' width='100%', border='1', cellspacing='0' cellpadding='2'>
                    <thead>
                    <tr>
                        <td width='8%' align='center' rowspan='2' ><b>Kode</td>
                        <td width='12%'align='center' rowspan='2' ><b>Uraian</td>
                        <td width='8%' align='center' rowspan='2' ><b>Jumlah</td>
                        <td width='24%' align='center' colspan='3' ><b>Triwulan I (Rp).</td>
                        <td width='24%' align='center' colspan='3' ><b>Triwulan II (Rp).</td>
                        <td width='24%' align='center' colspan='3' ><b>Triwulan III (Rp).</td>
                        <td width='24%' align='center' colspan='3' ><b>Triwulan IV (Rp).</td>                        
                    </tr> 
                    <tr>
                        <td width='6%' align='center'><b>Jan</td>
                        <td width='6%' align='center'><b>Feb</td>
                        <td width='6%' align='center'><b>Mar</td>
                        <td width='6%' align='center'><b>Apr</td>
                        <td width='6%' align='center'><b>Mei</td>
                        <td width='6%' align='center'><b>Jun</td>
                        <td width='6%' align='center'><b>Jul</td>
                        <td width='6%' align='center'><b>Ags</td>
                        <td width='6%' align='center'><b>Sep</td>
                        <td width='6%' align='center'><b>Okt</td>
                        <td width='6%' align='center'><b>Nov</td>
                        <td width='6%' align='center'><b>Des</td>
                    </tr>
                    </thead>";
            /*sub kegiatan*/
        $sql="
            SELECT kd_kegiatan giat, (select nm_sub_kegiatan from ms_sub_kegiatan WHERE kd_sub_kegiatan=xxx.kd_kegiatan) nm_giat, 
            isnull(sum(jan),0) jan, isnull(sum(feb),0) feb, isnull(sum(mar),0) mar, isnull(sum(apr),0) apr, isnull(sum(mei),0) mei, isnull(sum(jun),0) jun,
            isnull(sum(jul),0) jul, isnull(sum(ags),0) ags, isnull(sum(sep),0) sep, isnull(sum(okt),0) okt, isnull(sum(nov),0) nov, isnull(sum(des),0) des
            from (
            select kd_kegiatan,
            case when bulan=1 then sum(nilai) else 0 end as jan,
            case when bulan=2 then sum(nilai) else 0 end as feb,
            case when bulan=3 then sum(nilai) else 0 end as mar,
            case when bulan=4 then sum(nilai) else 0 end as apr,
            case when bulan=5 then sum(nilai) else 0 end as mei,
            case when bulan=6 then sum(nilai) else 0 end as jun,
            case when bulan=7 then sum(nilai) else 0 end as jul,
            case when bulan=8 then sum(nilai) else 0 end as ags,
            case when bulan=9 then sum(nilai) else 0 end as sep,
            case when bulan=10 then sum(nilai) else 0 end as okt,
            case when bulan=11 then sum(nilai) else 0 end as nov,
            case when bulan=12 then sum(nilai) else 0 end as des from trdskpd_ro a inner join 
            (select kd_sub_kegiatan oke, kd_skpd from trdrka GROUP by kd_sub_kegiatan,kd_skpd) b 
            on b.oke=a.kd_kegiatan and a.kd_skpd=b.kd_skpd WHERE left(a.kd_skpd,20)=left('$skpd',20)
            GROUP BY kd_kegiatan, bulan)xxx
            GROUP BY kd_kegiatan
            UNION all
            /*kegiatan*/
            SELECT kd_kegiatan giat, (select nm_kegiatan from ms_kegiatan WHERE kd_kegiatan=xxx.kd_kegiatan) nm_giat, 
            sum(jan) jan, sum(feb) feb, sum(mar) mar, sum(apr) apr, sum(mei) mei, sum(jun) jun,
            sum(jul) jul, sum(ags) ags, sum(sep) sep, sum(okt) okt, sum(nov) nov, sum(des) des
            from (
            select left(kd_kegiatan,12) kd_kegiatan,
            case when bulan=1 then sum(nilai) else 0 end as jan,
            case when bulan=2 then sum(nilai) else 0 end as feb,
            case when bulan=3 then sum(nilai) else 0 end as mar,
            case when bulan=4 then sum(nilai) else 0 end as apr,
            case when bulan=5 then sum(nilai) else 0 end as mei,
            case when bulan=6 then sum(nilai) else 0 end as jun,
            case when bulan=7 then sum(nilai) else 0 end as jul,
            case when bulan=8 then sum(nilai) else 0 end as ags,
            case when bulan=9 then sum(nilai) else 0 end as sep,
            case when bulan=10 then sum(nilai) else 0 end as okt,
            case when bulan=11 then sum(nilai) else 0 end as nov,
            case when bulan=12 then sum(nilai) else 0 end as des from trdskpd_ro a inner join 
            (select kd_sub_kegiatan oke, kd_skpd from trdrka GROUP by kd_sub_kegiatan,kd_skpd) b 
            on b.oke=a.kd_kegiatan and a.kd_skpd=b.kd_skpd WHERE left(a.kd_skpd,20)=left('$skpd',20)
            GROUP BY left(kd_kegiatan,12), bulan)xxx
            GROUP BY kd_kegiatan
            ORDER BY giat";
        $aa=0; $b=0; $c=0; $d=0; $e=0; $f=0; $g=0; $h=0; $i=0; $j=0; $k=0; $l=0; $tot=0;
        $exe=$this->db->query($sql);
        foreach($exe->result() as $a){
            $giat   =$a->giat;
            $nm_giat =$a->nm_giat;
            $jan    =$a->jan;
            $feb    =$a->feb;
            $mar    =$a->mar;
            $apr    =$a->apr;
            $mei    =$a->mei;
            $jun    =$a->jun;
            $jul    =$a->jul;
            $ags    =$a->ags;
            $sep    =$a->sep;
            $okt    =$a->okt;
            $nov    =$a->nov;
            $des    =$a->des;

            $aa=$aa+$jan; $g=$g+$jul;
            $b=$b+$feb; $h=$h+$ags;
            $c=$c+$mar; $i=$i+$sep;
            $d=$d+$apr; $j=$j+$okt;
            $e=$e+$mei; $k=$k+$nov;
            $f=$f+$jun; $l=$l+$des;

            $jumlah =$jan+$feb+$mar+$apr+$mei+$jun+$jul+$ags+$sep+$okt+$nov+$des;
            $tot    =$tot+$jumlah;
            $cetak.="
                    <tr>
                        <td>".$giat."</td>
                        <td>$nm_giat</td>
                        <td align='right'>".number_format($jumlah,'2',',','.')."</td>
                        <td align='right'>".number_format($jan,'2',',','.')."</td>
                        <td align='right'>".number_format($feb,'2',',','.')."</td>
                        <td align='right'>".number_format($mar,'2',',','.')."</td>
                        <td align='right'>".number_format($apr,'2',',','.')."</td>
                        <td align='right'>".number_format($mei,'2',',','.')."</td>
                        <td align='right'>".number_format($jun,'2',',','.')."</td>
                        <td align='right'>".number_format($jul,'2',',','.')."</td>
                        <td align='right'>".number_format($ags,'2',',','.')."</td>
                        <td align='right'>".number_format($sep,'2',',','.')."</td>
                        <td align='right'>".number_format($okt,'2',',','.')."</td>
                        <td align='right'>".number_format($nov,'2',',','.')."</td>
                        <td align='right'>".number_format($des,'2',',','.')."</td>
                    </tr>";
        }

        $cetak.="   <tr>
                        <td colspan='2' align='center'><b>Total</td>
                        <td align='right'><b>".number_format($tot,'2',',','.')."</td>
                        <td align='right'><b>".number_format($aa,'2',',','.')."</td>
                        <td align='right'><b>".number_format($b,'2',',','.')."</td>
                        <td align='right'><b>".number_format($c,'2',',','.')."</td>
                        <td align='right'><b>".number_format($d,'2',',','.')."</td>
                        <td align='right'><b>".number_format($e,'2',',','.')."</td>
                        <td align='right'><b>".number_format($f,'2',',','.')."</td>
                        <td align='right'><b>".number_format($g,'2',',','.')."</td>
                        <td align='right'><b>".number_format($h,'2',',','.')."</td>
                        <td align='right'><b>".number_format($i,'2',',','.')."</td>
                        <td align='right'><b>".number_format($j,'2',',','.')."</td>
                        <td align='right'><b>".number_format($k,'2',',','.')."</td>
                        <td align='right'><b>".number_format($l,'2',',','.')."</td>
                    </tr>";
        $cetak.="   <tr>
                        <td colspan='2' align='center'><b>Total Triwulan</td>
                        <td align='right' ><b>".number_format($tot,'2',',','.')."</td>
                        <td align='center' colspan='3' ><b>".number_format($aa+$b+$c,'2',',','.')."</td>
                        <td align='center' colspan='3' ><b>".number_format($d+$e+$f,'2',',','.')."</td>
                        <td align='center' colspan='3' ><b>".number_format($g+$h+$i,'2',',','.')."</td>
                        <td align='center' colspan='3' ><b>".number_format($j+$k+$l,'2',',','.')."</td>
                    </tr>";
        $cetak.="</table>";

        if($hid!="hidden"){
            $sql = "SELECT * from ms_ttd WHERE id='$ttd1'";
            $exe = $this->db->query($sql);
            foreach ($exe->result() as $a) {
                $nip    = $a->nip; 
                $nama   = $a->nama;
                $jabatan= $a->jabatan;
                $pangkat= $a->pangkat;
            }

            $sql = "SELECT * from ms_ttd WHERE id='$ttd2'";
            $exe = $this->db->query($sql);
            foreach ($exe->result() as $a) {
                $nip2    = $a->nip;
                $nama2   = $a->nama;
                $jabatan2= $a->jabatan;
                $pangkat2= $a->pangkat;
            } 

            $cetak.="<table width='100%' border='0' style='font-size:12px'>
                        <tr>
                            <td width='50%' align='center'><br>
                                Mengetahui, <br>
                                $jabatan2
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <b><u>$nama2</u></b><br>
                                NIP. $nip2
                            </td>
                            <td width='50%' align='center'><br>
                                Sanggau, ".$this->support->tanggal_format_indonesia($tgl)." <br>
                                $jabatan
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <b><u>$nama</u></b><br>
                                NIP. $nip
                            </td>
                        </tr>

                    </table>";
        }

        switch ($ctk){
            case '1':
                echo ("<title>ANGKAS RO </title>");
                echo "$cetak";
                break;
            case '2':
                $this->master_pdf->_mpdf('',$cetak,10,10,10,'1');        
                break;
            case '3':
                header("Content-Type: application/vnd.ms-excel");
                header("Content-Disposition: attachment; filename= AngkasRO-$skpd.xls");
                echo "$cetak";
                break;            
        }
    }

    function preview_cetakan_cek_anggaran($id,$cetak,$status_ang){
     
     if($status_ang=='nilai'){
        $status="PENYUSUNAN";
     }else if($status_ang=='nilai_sempurna'){
        $status="PERGESERAN";
     }else{
        $status="PERUBAHAN";
     }
        $nama=$this->db->query("select nm_skpd from ms_skpd where kd_skpd='$id'")->row();
        $cRet='';

       $cRet.="<table style='font-size:12px;border-left:solid 0px black;border-top:solid 0px black;border-right:solid 0px black;' width='100%' border='0'>
                    <tr>
                        <td align='center' colspan='5'><b>LAPORAN PERBANDINGAN<br>NILAI ANGGARAN DAN NILAI ANGGARAN KAS $status<br>{$nama->nm_skpd}</b></td>
                        
                    </tr>
                 </table>";



        
        $cRet .= "<table style='border-collapse:collapse;vertical-align:top;font-size:12 px;' width='100%' align='center' border='1' cellspacing='0' cellpadding='1'>

                     <thead >                       
                        <tr>
                            <td bgcolor='#A9A9A9' width='15%' align='center '><b>Kode Kegiatan</b></td>
                            <td bgcolor='#A9A9A9' width='50%' align='center'><b>Nama Kegiatan</b></td>
                            <td bgcolor='#A9A9A9' width='15%' align='center'><b>Nilai Anggaran</b></td>
                            <td bgcolor='#A9A9A9' width='15%' align='center'><b>Nilai Anggaran Kas</b></td>
                            <td bgcolor='#A9A9A9' width='5%' align='center'><b>Hasil</b></td>
                         </tr>
                     </thead>
                     
                   
                        ";


               $sql1="
                    SELECT a.giat kd_kegiatan, a.nama nm_kegiatan, a.nilai_ang, isnull(b.nilai_kas,0) nilai_kas,
                    CASE WHEN isnull(b.nilai_kas,0) = a.nilai_ang THEN 'SAMA' ELSE 'SELISIH' END AS hasil
                                 from (
                select kd_sub_kegiatan giat, nm_sub_kegiatan nama, sum($status_ang) nilai_ang

                 from trdrka where left(kd_skpd,20)=left('$id',20) GROUP BY kd_sub_kegiatan,nm_sub_kegiatan)
                a left join (
                select kd_subkegiatan giat, sum($status_ang) nilai_kas from trdskpd_ro where left(kd_skpd,20)=left('$id',20) GROUP BY kd_subkegiatan) b
                on a.giat=b.giat where isnull(b.nilai_kas,0) <> a.nilai_ang
                ORDER BY
                 hasil,a.giat

                ";
                
                $totnilai = 0; 
                $tnilai2 = 0;
                $tselisih = 0;
                $query = $this->db->query($sql1);
                                 
                foreach ($query->result() as $row)
                {
                    $giat=rtrim($row->kd_kegiatan);
                    $nm_giat=rtrim($row->nm_kegiatan);
                    $hasil=rtrim($row->hasil);
                    $nilai_ang=($row->nilai_ang);
                    $nilai_angx = number_format($nilai_ang,2,',','.');
                    $nilai_kas=($row->nilai_kas);
                    $nilai_kasx = number_format($nilai_kas,2,',','.');

                            if($hasil=='SAMA'){


                      $cRet    .= " <tr>                                
                                        <td align='center' style='vertical-align:middle; ' >$giat</td>
                                        <td align='left' style='vertical-align:middle; ' >$nm_giat</td>
                                        <td align='right' style='vertical-align:middle; ' >$nilai_ang</td>
                                        <td align='right' style='vertical-align:middle; ' >$nilai_kas</td>
                                        <td align='center' style='vertical-align:middle; ' >$hasil</td>
                                    </tr> 
                                   
                                    ";
    
                            }else{
                

                      $cRet    .= " <tr>                                
                                        <td bgcolor='#ff5d47' align='center' style='vertical-align:middle;' >$giat</td>
                                        <td bgcolor='#ff5d47' align='left' style='vertical-align:middle;' >$nm_giat</td>
                                        <td bgcolor='#ff5d47' align='right' style='vertical-align:middle;' >$nilai_ang</td>
                                        <td bgcolor='#ff5d47' align='right' style='vertical-align:middle;'>$nilai_kas</td>
                                        <td bgcolor='#ff5d47' align='center' style='vertical-align:middle;'>$hasil</td>
                                    </tr> 
                                   
                                    ";

                            }

                }

 
        $cRet .="</table>";
 
        $data['prev']= $cRet;    
        switch($cetak) {
        case 0;
               echo ("<title>Lap Perbandingan Anggaran</title>");
                echo($cRet);
        break;
        case 1;
             $this->master_pdf->_mpdf('',$cRet,10,10,10,'1');
        break;
        case 2;        
            header("Cache-Control: no-cache, no-store, must-revalidate");
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename= cek_anggaran.xls");
            $this->load->view('anggaran/rka/perkadaII', $data);
        break;
        
        }    
    }

    function cetak_angkas_pemda(){
        $tgl    = $_REQUEST['tgl'];
        $ttd1   = $_REQUEST['ttd1'];
        $ttd2   = $_REQUEST['ttd2'];
        $jenis  = $_REQUEST['jenis'];
        $cetak  = $_REQUEST['cetak'];

        $sclient = $this->db->query("SELECT top 1 provinsi,kab_kota,daerah,thn_ang from sclient")->row();

        $cRet = '';
        $cRet .="
            <table width='100%' style='font-weight:bold;margin-bottom: 24px;font-size:14px; font-family:arial;'>
                <tr>
                    <td align='center'>".$sclient->kab_kota."</td>
                </tr>
                <tr>
                    <td align='center'>ANGGARAN KAS</td>
                </tr>
                <tr>
                    <td align='center'>TAHUN ANGGARAN ".$sclient->thn_ang."</td>
                </tr>
            </table>
        ";

        $cRet .= "
            <table border='1' width='100%' style='border-collapse:collapse; font-size:11px; font-family:arial;'>
                <thead>
                <tr>
                    <td style='font-weight:bold;' align='center' rowspan='3' width='3%'>Kode Rekening</td>
                    <td style='font-weight:bold;' align='center' rowspan='3' width='12%'>Uraian</td>
                    <td style='font-weight:bold;' align='center' rowspan='3' width='5%'>Anggaran Tahun ini (Rp)</td>
                    <td style='font-weight:bold;' align='center' colspan='3'>Triwulan I</td>
                    <td style='font-weight:bold;' align='center' colspan='3'>Triwulan II</td>
                    <td style='font-weight:bold;' align='center' colspan='3'>Triwulan III</td>
                    <td style='font-weight:bold;' align='center' colspan='3'>Triwulan IV</td>
                </tr>
                <tr>
                    <td style='font-weight:bold;' align='center' colspan='3'>(Rp)</td>
                    <td style='font-weight:bold;' align='center' colspan='3'>(Rp)</td>
                    <td style='font-weight:bold;' align='center' colspan='3'>(Rp)</td>
                    <td style='font-weight:bold;' align='center' colspan='3'>(Rp)</td> 
                </tr>
                <tr>
                    <td style='font-weight:bold;' align='center' width='6%'>Jan</td>
                    <td style='font-weight:bold;' align='center' width='6%'>Feb</td>
                    <td style='font-weight:bold;' align='center' width='6%'>Mar</td>
                    <td style='font-weight:bold;' align='center' width='6%'>Apr</td> 
                    <td style='font-weight:bold;' align='center' width='6%'>Mei</td>
                    <td style='font-weight:bold;' align='center' width='6%'>Jun</td>
                    <td style='font-weight:bold;' align='center' width='6%'>Jul</td>
                    <td style='font-weight:bold;' align='center' width='6%'>Ags</td> 
                    <td style='font-weight:bold;' align='center' width='6%'>Sep</td>
                    <td style='font-weight:bold;' align='center' width='6%'>Okt</td>
                    <td style='font-weight:bold;' align='center' width='6%'>Nov</td>
                    <td style='font-weight:bold;' align='center' width='6%'>Des</td> 
                </tr>
                </thead>
        ";

        $cRet .="<tr>
                    <td colspan='15' style='font-weight:bold;' bgcolor='darkgray'> ALOKASI PENDAPATAN DAN PENERIMAAN PEMBIAYAAN </td>
                </tr> ";

        $sql_masuk = "SELECT * from(
            SELECT kode,nm_rek2 as nama,sum(jan) jan,sum(feb) feb,sum(mar) mar,sum(apr) apr,sum(mei) mei,sum(jun) jun,sum(jul) jul,sum(ags) ags,sum(sep) sep,sum(okt) okt,sum(nov) nov,sum(des) des from(
            SELECT left(kd_rek6,2) kode, 
            (CASE bulan WHEN 1 THEN sum(nilai) ELSE 0 END) jan,
            (CASE bulan WHEN 2 THEN sum(nilai) ELSE 0 END) feb,
            (CASE bulan WHEN 3 THEN sum(nilai) ELSE 0 END) mar,
            (CASE bulan WHEN 4 THEN sum(nilai) ELSE 0 END) apr,
            (CASE bulan WHEN 5 THEN sum(nilai) ELSE 0 END) mei,
            (CASE bulan WHEN 6 THEN sum(nilai) ELSE 0 END) jun,
            (CASE bulan WHEN 7 THEN sum(nilai) ELSE 0 END) jul,
            (CASE bulan WHEN 8 THEN sum(nilai) ELSE 0 END) ags,
            (CASE bulan WHEN 9 THEN sum(nilai) ELSE 0 END) sep,
            (CASE bulan WHEN 10 THEN sum(nilai) ELSE 0 END) okt,
            (CASE bulan WHEN 11 THEN sum(nilai) ELSE 0 END) nov,
            (CASE bulan WHEN 12 THEN sum(nilai) ELSE 0 END) des
            from trdskpd_ro where left(kd_rek6,1) =4 or left(kd_rek6,2)=61
            GROUP BY left(kd_rek6,2),bulan
            )pp inner join ms_rek2 mr2 on pp.kode=mr2.kd_rek2
            GROUP BY kode,nm_rek2
            union all 
            SELECT kode,nm_rek3 as nama,sum(jan) jan,sum(feb) feb,sum(mar) mar,sum(apr) apr,sum(mei) mei,sum(jun) jun,sum(jul) jul,sum(ags) ags,sum(sep) sep,sum(okt) okt,sum(nov) nov,sum(des) des from(
            SELECT left(kd_rek6,4) kode, 
            (CASE bulan WHEN 1 THEN sum(nilai) ELSE 0 END) jan,
            (CASE bulan WHEN 2 THEN sum(nilai) ELSE 0 END) feb,
            (CASE bulan WHEN 3 THEN sum(nilai) ELSE 0 END) mar,
            (CASE bulan WHEN 4 THEN sum(nilai) ELSE 0 END) apr,
            (CASE bulan WHEN 5 THEN sum(nilai) ELSE 0 END) mei,
            (CASE bulan WHEN 6 THEN sum(nilai) ELSE 0 END) jun,
            (CASE bulan WHEN 7 THEN sum(nilai) ELSE 0 END) jul,
            (CASE bulan WHEN 8 THEN sum(nilai) ELSE 0 END) ags,
            (CASE bulan WHEN 9 THEN sum(nilai) ELSE 0 END) sep,
            (CASE bulan WHEN 10 THEN sum(nilai) ELSE 0 END) okt,
            (CASE bulan WHEN 11 THEN sum(nilai) ELSE 0 END) nov,
            (CASE bulan WHEN 12 THEN sum(nilai) ELSE 0 END) des
            from trdskpd_ro where left(kd_rek6,1) =4 or left(kd_rek6,2)=61
            GROUP BY left(kd_rek6,4),bulan
            )pp inner join ms_rek3 mr3 on pp.kode=mr3.kd_rek3
            GROUP BY kode,nm_rek3
        )pend ORDER BY kode";
   
        $jjan =0;$jfeb =0;$jmar =0;$japr =0;$jmei =0;$jjun =0;$jjul =0;$jags =0;$jsep =0;$jokt =0;$jnov =0;$jdes =0; $jtotal =0;  
        $data = $this->db->query($sql_masuk); 
        foreach($data->result_array() as $row){
            $total = $row['jan']+$row['feb']+$row['mar']+$row['apr']+$row['mei']+$row['jun']+$row['jul']+$row['ags']+$row['sep']+$row['okt']+$row['nov']+$row['des'];
            if(strlen($row['kode'])!='2'){
                $style="";
                $kode = substr($row['kode'],0,1).'.'.substr($row['kode'],1,1).'.'.substr($row['kode'],2,2);
            }else{
                $style="style='font-weight:bold;'";
                $kode = substr($row['kode'],0,1).'.'.substr($row['kode'],1,1);
            }
            $jtotal = $jtotal+$total;
            $jjan = $jjan+$row['jan'];
            $jfeb = $jfeb+$row['feb'];
            $jmar = $jmar+$row['mar'];
            $japr = $japr+$row['apr'];
            $jmei = $jmei+$row['mei'];
            $jjun = $jjun+$row['jun'];
            $jjul = $jjul+$row['jul'];
            $jags = $jags+$row['ags'];
            $jsep = $jsep+$row['sep'];
            $jokt = $jokt+$row['okt'];
            $jnov = $jnov+$row['nov'];
            $jdes = $jdes+$row['des'];

            $cRet .="<tr>
                        <td $style>$kode</td>
                        <td $style>".$row['nama']."</td>
                        <td $style align='right'>".number_format($total,2)."</td>
                        <td $style align='right'>".number_format($row['jan'],2)."</td>
                        <td $style align='right'>".number_format($row['feb'],2)."</td>
                        <td $style align='right'>".number_format($row['mar'],2)."</td>
                        <td $style align='right'>".number_format($row['apr'],2)."</td> 
                        <td $style align='right'>".number_format($row['mei'],2)."</td>
                        <td $style align='right'>".number_format($row['jun'],2)."</td>
                        <td $style align='right'>".number_format($row['jul'],2)."</td>
                        <td $style align='right'>".number_format($row['ags'],2)."</td> 
                        <td $style align='right'>".number_format($row['sep'],2)."</td>
                        <td $style align='right'>".number_format($row['okt'],2)."</td>
                        <td $style align='right'>".number_format($row['nov'],2)."</td>
                        <td $style align='right'>".number_format($row['des'],2)."</td> 
                    </tr> ";
        }
        
        $cRet .="<tr>
                    <td style='font-weight:bold;' colspan='2'>JUMLAH PENDAPATAN DAN PENERIMAAN PEMBIAYAAN PER BULAN</td> 
                    <td style='font-weight:bold;' align='right'>".number_format($jtotal,2)."</td>
                    <td style='font-weight:bold;' align='right'>".number_format($jjan,2)."</td>
                    <td style='font-weight:bold;' align='right'>".number_format($jfeb,2)."</td>
                    <td style='font-weight:bold;' align='right'>".number_format($jmar,2)."</td>
                    <td style='font-weight:bold;' align='right'>".number_format($japr,2)."</td> 
                    <td style='font-weight:bold;' align='right'>".number_format($jmei,2)."</td>
                    <td style='font-weight:bold;' align='right'>".number_format($jjun,2)."</td>
                    <td style='font-weight:bold;' align='right'>".number_format($jjul,2)."</td>
                    <td style='font-weight:bold;' align='right'>".number_format($jags,2)."</td> 
                    <td style='font-weight:bold;' align='right'>".number_format($jsep,2)."</td>
                    <td style='font-weight:bold;' align='right'>".number_format($jokt,2)."</td>
                    <td style='font-weight:bold;' align='right'>".number_format($jnov,2)."</td>
                    <td style='font-weight:bold;' align='right'>".number_format($jdes,2)."</td> 
                </tr>
                <tr>
                    <td style='font-weight:bold;' colspan='2'>JUMLAH ALOKASI KAS YANG TERSEDIA DARI PENDAPATAN DAN PENERIMAAN PEMBIAYAAN PER TRIWULAN</td> 
                    <td style='font-weight:bold;' align='right'>".number_format($jtotal,2)."</td>
                    <td style='font-weight:bold;' align='right' colspan='3'>".number_format($jjan+$jfeb+$jmar,2)."</td> 
                    <td style='font-weight:bold;' align='right' colspan='3'>".number_format($japr+$jmei+$jjun,2)."</td>  
                    <td style='font-weight:bold;' align='right' colspan='3'>".number_format($jjul+$jags+$jsep,2)."</td> 
                    <td style='font-weight:bold;' align='right' colspan='3'>".number_format($jokt+$jnov+$jdes,2)."</td> 
                </tr>";

        $cRet .="<tr>
                    <td colspan='15'> &nbsp; </td>
                </tr> 
                <tr>
                    <td colspan='15' style='font-weight:bold;' bgcolor='darkgray'> ALOKASI BELANJA DAN PENGELUARAN PEMBIAYAAN </td>
                </tr>";

        $sql_keluar = "SELECT * from(
                    SELECT kode,nm_rek2 as nama,sum(jan) jan,sum(feb) feb,sum(mar) mar,sum(apr) apr,sum(mei) mei,sum(jun) jun,sum(jul) jul,sum(ags) ags,sum(sep) sep,sum(okt) okt,sum(nov) nov,sum(des) des from(
                    SELECT left(kd_rek6,2) kode, 
                    (CASE bulan WHEN 1 THEN sum(nilai) ELSE 0 END) jan,
                    (CASE bulan WHEN 2 THEN sum(nilai) ELSE 0 END) feb,
                    (CASE bulan WHEN 3 THEN sum(nilai) ELSE 0 END) mar,
                    (CASE bulan WHEN 4 THEN sum(nilai) ELSE 0 END) apr,
                    (CASE bulan WHEN 5 THEN sum(nilai) ELSE 0 END) mei,
                    (CASE bulan WHEN 6 THEN sum(nilai) ELSE 0 END) jun,
                    (CASE bulan WHEN 7 THEN sum(nilai) ELSE 0 END) jul,
                    (CASE bulan WHEN 8 THEN sum(nilai) ELSE 0 END) ags,
                    (CASE bulan WHEN 9 THEN sum(nilai) ELSE 0 END) sep,
                    (CASE bulan WHEN 10 THEN sum(nilai) ELSE 0 END) okt,
                    (CASE bulan WHEN 11 THEN sum(nilai) ELSE 0 END) nov,
                    (CASE bulan WHEN 12 THEN sum(nilai) ELSE 0 END) des
                    from trdskpd_ro where left(kd_rek6,1) =5 or left(kd_rek6,2)=62
                    GROUP BY left(kd_rek6,2),bulan
                    )pp inner join ms_rek2 mr2 on pp.kode=mr2.kd_rek2
                    GROUP BY kode,nm_rek2
                    union all 
                    SELECT kode,nm_rek3 as nama,sum(jan) jan,sum(feb) feb,sum(mar) mar,sum(apr) apr,sum(mei) mei,sum(jun) jun,sum(jul) jul,sum(ags) ags,sum(sep) sep,sum(okt) okt,sum(nov) nov,sum(des) des from(
                    SELECT left(kd_rek6,4) kode, 
                    (CASE bulan WHEN 1 THEN sum(nilai) ELSE 0 END) jan,
                    (CASE bulan WHEN 2 THEN sum(nilai) ELSE 0 END) feb,
                    (CASE bulan WHEN 3 THEN sum(nilai) ELSE 0 END) mar,
                    (CASE bulan WHEN 4 THEN sum(nilai) ELSE 0 END) apr,
                    (CASE bulan WHEN 5 THEN sum(nilai) ELSE 0 END) mei,
                    (CASE bulan WHEN 6 THEN sum(nilai) ELSE 0 END) jun,
                    (CASE bulan WHEN 7 THEN sum(nilai) ELSE 0 END) jul,
                    (CASE bulan WHEN 8 THEN sum(nilai) ELSE 0 END) ags,
                    (CASE bulan WHEN 9 THEN sum(nilai) ELSE 0 END) sep,
                    (CASE bulan WHEN 10 THEN sum(nilai) ELSE 0 END) okt,
                    (CASE bulan WHEN 11 THEN sum(nilai) ELSE 0 END) nov,
                    (CASE bulan WHEN 12 THEN sum(nilai) ELSE 0 END) des
                    from trdskpd_ro where left(kd_rek6,1) =5 or left(kd_rek6,2)=62
                    GROUP BY left(kd_rek6,4),bulan
                    )pp inner join ms_rek3 mr3 on pp.kode=mr3.kd_rek3
                    GROUP BY kode,nm_rek3
                )belj ORDER BY kode";
           
                $jbjan =0;$jbfeb =0;$jbmar =0;$jbapr =0;$jbmei =0;$jbjun =0;$jbjul =0;$jbags =0;$jbsep =0;$jbokt =0;$jbnov =0;$jbdes =0; $jbtotal =0;  
                $data = $this->db->query($sql_keluar); 
                foreach($data->result_array() as $rok){
                    $total = $rok['jan']+$rok['feb']+$rok['mar']+$rok['apr']+$rok['mei']+$rok['jun']+$rok['jul']+$rok['ags']+$rok['sep']+$rok['okt']+$rok['nov']+$rok['des'];
                    if(strlen($rok['kode'])!='2'){
                        $style="";
                        $kode = substr($rok['kode'],0,1).'.'.substr($rok['kode'],1,1).'.'.substr($rok['kode'],2,2);
                    }else{
                        $style="style='font-weight:bold;'";
                        $kode = substr($rok['kode'],0,1).'.'.substr($rok['kode'],1,1);
                    }
                    $jbtotal = $jbtotal+$total;
                    $jbjan = $jbjan+$rok['jan'];
                    $jbfeb = $jbfeb+$rok['feb'];
                    $jbmar = $jbmar+$rok['mar'];
                    $jbapr = $jbapr+$rok['apr'];
                    $jbmei = $jbmei+$rok['mei'];
                    $jbjun = $jbjun+$rok['jun'];
                    $jbjul = $jbjul+$rok['jul'];
                    $jbags = $jbags+$rok['ags'];
                    $jbsep = $jbsep+$rok['sep'];
                    $jbokt = $jbokt+$rok['okt'];
                    $jbnov = $jbnov+$rok['nov'];
                    $jbdes = $jbdes+$rok['des'];
        
                    $cRet .="<tr>
                                <td $style>$kode</td>
                                <td $style>".$rok['nama']."</td>
                                <td $style align='right'>".number_format($total,2)."</td>
                                <td $style align='right'>".number_format($rok['jan'],2)."</td>
                                <td $style align='right'>".number_format($rok['feb'],2)."</td>
                                <td $style align='right'>".number_format($rok['mar'],2)."</td>
                                <td $style align='right'>".number_format($rok['apr'],2)."</td> 
                                <td $style align='right'>".number_format($rok['mei'],2)."</td>
                                <td $style align='right'>".number_format($rok['jun'],2)."</td>
                                <td $style align='right'>".number_format($rok['jul'],2)."</td>
                                <td $style align='right'>".number_format($rok['ags'],2)."</td> 
                                <td $style align='right'>".number_format($rok['sep'],2)."</td>
                                <td $style align='right'>".number_format($rok['okt'],2)."</td>
                                <td $style align='right'>".number_format($rok['nov'],2)."</td>
                                <td $style align='right'>".number_format($rok['des'],2)."</td> 
                            </tr> ";
                }
                $ztotal = $jtotal-$jbtotal;
                $tri1   = ($jjan+$jfeb+$jmar)-($jbjan+$jbfeb+$jbmar);
                $tri2   = ($japr+$jmei+$jjun)-($jbapr+$jbmei+$jbjun);
                $tri3   = ($jjul+$jags+$jsep)-($jbjul+$jbags+$jbsep);
                $tri4   = ($jokt+$jnov+$jdes)-($jbokt+$jbnov+$jbdes);
                $ztotal = ($ztotal<0)?'('.number_format($ztotal*-1,2).')':number_format($ztotal,2);
                $tri1   = ($tri1<0)?'('.number_format($tri1*-1,2).')':number_format($tri1,2);
                $tri2   = ($tri2<0)?'('.number_format($tri2*-1,2).')':number_format($tri2,2);
                $tri3   = ($tri3<0)?'('.number_format($tri3*-1,2).')':number_format($tri3,2);
                $tri4   = ($tri4<0)?'('.number_format($tri4*-1,2).')':number_format($tri4,2);

                $cRet .="<tr>
                            <td style='font-weight:bold;' colspan='2'>JUMLAH BELANJA DAN PENGELUARAN PEMBIAYAAN PER BULAN</td> 
                            <td style='font-weight:bold;' align='right'>".number_format($jbtotal,2)."</td>
                            <td style='font-weight:bold;' align='right'>".number_format($jbjan,2)."</td>
                            <td style='font-weight:bold;' align='right'>".number_format($jbfeb,2)."</td>
                            <td style='font-weight:bold;' align='right'>".number_format($jbmar,2)."</td>
                            <td style='font-weight:bold;' align='right'>".number_format($jbapr,2)."</td> 
                            <td style='font-weight:bold;' align='right'>".number_format($jbmei,2)."</td>
                            <td style='font-weight:bold;' align='right'>".number_format($jbjun,2)."</td>
                            <td style='font-weight:bold;' align='right'>".number_format($jbjul,2)."</td>
                            <td style='font-weight:bold;' align='right'>".number_format($jbags,2)."</td> 
                            <td style='font-weight:bold;' align='right'>".number_format($jbsep,2)."</td>
                            <td style='font-weight:bold;' align='right'>".number_format($jbokt,2)."</td>
                            <td style='font-weight:bold;' align='right'>".number_format($jbnov,2)."</td>
                            <td style='font-weight:bold;' align='right'>".number_format($jbdes,2)."</td> 
                        </tr>
                        <tr>
                            <td style='font-weight:bold;' colspan='2'>JUMLAH ALOKASI KAS YANG TERSEDIA UNTUK BELANJA DAN PENGELUARAN PEMBIAYAAN PER TRIWULAN</td> 
                            <td style='font-weight:bold;' align='right'>".number_format($jbtotal,2)."</td>
                            <td style='font-weight:bold;' align='right' colspan='3'>".number_format($jbjan+$jbfeb+$jbmar,2)."</td> 
                            <td style='font-weight:bold;' align='right' colspan='3'>".number_format($jbapr+$jbmei+$jbjun,2)."</td>  
                            <td style='font-weight:bold;' align='right' colspan='3'>".number_format($jbjul+$jbags+$jbsep,2)."</td> 
                            <td style='font-weight:bold;' align='right' colspan='3'>".number_format($jbokt+$jbnov+$jbdes,2)."</td> 
                        </tr> 
                        <tr>
                            <td colspan='15'> &nbsp; </td>
                        </tr>
                        <tr>
                            <td bgcolor='darkgray' style='font-weight:bold;' colspan='2'>SISA KAS (JUMLAH ALOKASI KAS YANG TERSEDIA UNTUK PENGELUARAN SETELAH DIKURANGI BELANJA DAN PENGELUARAN PEMBIAYAAN PER TRIWULAN)</td> 
                            <td bgcolor='darkgray' style='font-weight:bold;' align='right'>$ztotal</td>
                            <td bgcolor='darkgray' style='font-weight:bold;' align='right' colspan='3'>$tri1</td> 
                            <td bgcolor='darkgray' style='font-weight:bold;' align='right' colspan='3'>$tri2</td>  
                            <td bgcolor='darkgray' style='font-weight:bold;' align='right' colspan='3'>$tri3</td> 
                            <td bgcolor='darkgray' style='font-weight:bold;' align='right' colspan='3'>$tri4</td> 
                        </tr> ";
        $cRet .=" </table>";
          
        $vttd1 = $this->db->query("SELECT * from ms_ttd WHERE id='$ttd1'")->row();
        $vttd2 = $this->db->query("SELECT * from ms_ttd WHERE id='$ttd2'")->row();

        $cRet.="<table width='100%' border='0' style='font-size: 12px'>
                    <tr>
                        <td width='50%' align='center'><br>
                            Mengetahui, <br>
                            ".$vttd2->jabatan."
                            <br><br><br><br><br><br>
                            <b><u>".$vttd2->nama."</u></b><br>
                            NIP. ".$vttd2->nip."
                        </td>
                        <td width='50%' align='center'><br>
                        ".$sclient->daerah.", ".$this->support->tanggal_format_indonesia($tgl)." <br>
                            ".$vttd1->jabatan."
                            <br><br><br><br><br><br>
                            <b><u>".$vttd1->nama."</u></b><br>
                            NIP. ".$vttd1->nip."
                        </td>
                    </tr> 
                </table>";
        switch ($cetak){
            case '1':
                echo ("<title>ANGKAS RO </title>");
                echo "$cRet";
                break;
            case '2':
			 
                $this->master_pdf->_mpdf('',$cRet,10,10,10,'1','','');        
                break;
            case '3':
                header("Content-Type: application/vnd.ms-excel");
                header("Content-Disposition: attachment; filename= AngkasRO-pemda.xls");
                echo "$cRet";
                break;            
        } 
    }
}