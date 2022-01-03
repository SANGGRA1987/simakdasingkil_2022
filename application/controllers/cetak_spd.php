<?php if (!defined('BASEPATH'))
 exit('No direct script access allowed');

class cetak_spd extends CI_Controller{

    function __construct()
    {
        parent::__construct();
    }

 
    function  tanggal_format_indonesia2($tgl){
        $tanggal  =  substr($tgl,7,2);
        $bulan  = $this-> getBulan(substr($tgl,5,2));
        $tahun  =  substr($tgl,0,4);
        return  $tanggal.' '.$bulan.' '.$tahun;
 
    }  
    

    function  tanggal_format_indonesia($tgl){
        $tanggal  =  substr($tgl,8,2);
        $bulan  = $this-> getBulan(substr($tgl,5,2));
        $tahun  =  substr($tgl,0,4);
        return  $tanggal.' '.$bulan.' '.$tahun;

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
    function right($value, $count){
    return substr($value, ($count*-1));
    }

    function left($string, $count){
    return substr($string, 0, $count);
    }

    function  dotrek($rek){
                $nrek=strlen($rek);
                switch ($nrek) {
                case 1:
                $rek = $this->left($rek,1);                             
                 break;
                case 2:
                    $rek = $this->left($rek,1).'.'.substr($rek,1,1);                                
                 break;
                case 3:
                    $rek = $this->left($rek,1).'.'.substr($rek,1,1).'.'.substr($rek,2,1);                               
                 break;
                 case 4:
                    $rek = $this->left($rek,1).'.'.substr($rek,1,1).'.'.substr($rek,2,1).'.'.substr($rek,3,2);                               
                 break;
                case 5:
                    $rek = $this->left($rek,1).'.'.substr($rek,1,1).'.'.substr($rek,2,1).'.'.substr($rek,3,2);                              
                break;
                case 7:
                    $rek = $this->left($rek,1).'.'.substr($rek,1,1).'.'.substr($rek,2,1).'.'.substr($rek,3,2).'.'.substr($rek,5,2);                             
                break;
                default:
                $rek = "";  
                }
                return $rek;
    }    
    function cetak_lampiran_spd1(){       
        $print = $this->uri->segment(3);
        $tnp_no = $this->uri->segment(4);
        $jns =  $this->uri->segment(8);
        $ttp = $this->input->post('tglttp');
        $nip_ppkd = $this->input->post('nip_ppkd');  
        $nama_ppkd = $this->input->post('nama_ppkd');       
        $jabatan_ppkd = $this->input->post('jabatan_ppkd'); 
        $pangkat_ppkd = $this->input->post('pangkat_ppkd');     
        $lntahunang = $this->session->userdata('pcThang');       
        $lcnospd = $this->input->post('nomor1');
        $lkd_skpd=$this->rka_model->get_nama($lcnospd,'kd_skpd','trhspd','no_spd');
        $ldtgl_spd=$this->rka_model->get_nama($lcnospd,'tgl_spd','trhspd','no_spd');
        $stsubah=$this->rka_model->get_nama($lkd_skpd,'status_ubah','trhrka','kd_skpd');
        //$field = $this->get_status($ldtgl_spd,$lkd_skpd); 

        if($jns=='61'){
            $wherex ="and left(kd_rek6,2)='61'";
            $judulxx='PENGELUARAN PEMBIAYAAN';
        } else{
             $wherex ="";
             $judulxx='BELANJA';
        }         
        
        $csxsql=$this->db->query("SELECT case when statu=1 and status_sempurna=1 and status_ubah=1 then 'nilai_ubah' 
                       when statu=1 and status_sempurna=1 and status_ubah=0 then 'nilai_sempurna' 
                       when statu=1 and status_sempurna=0 and status_ubah=0 then 'nilai'
                       else 'nilai' end as anggaran from trhrka")->row();
        $field = $csxsql->anggaran;               
        
        
        $csql = "SELECT (SELECT no_dpa FROM trhrka WHERE kd_skpd = a.kd_skpd) AS no_dpa,
                (SELECT SUM($field) FROM trdrka WHERE kd_sub_kegiatan IN(SELECT kd_subkegiatan FROM trdspd WHERE no_spd=a.no_spd)
                 AND left(kd_skpd,20) = left(a.kd_skpd,20) $wherex) jm_ang,
                (SELECT SUM(total_hasil) as total FROM trhspd WHERE kd_skpd = a.kd_skpd AND jns_beban=a.jns_beban AND 
                tgl_spd<=a.tgl_spd AND no_spd<>a.no_spd) AS jm_spdlalu,
                (select sum(nilai_final) as nilai from trdspd f where f.no_spd=a.no_spd) AS jm_spdini,a.jns_beban,a.bulan_awal,a.bulan_akhir,kd_skpd
                FROM trhspd a WHERE a.no_spd = '$lcnospd'";
                        
        $hasil = $this->db->query($csql);
        $data1 = $hasil->row();
        $periode1 = $this->rka_model->getBulan($data1->bulan_awal);
        $periode2 = $this->rka_model->getBulan($data1->bulan_akhir);
        $jnsspd = $data1->jns_beban;
        $lnsisa = $data1->jm_ang - $data1->jm_spdlalu - $data1->jm_spdini;
        $lkd_skpd =$data1->kd_skpd;
        $ljns_beban =$data1->jns_beban;
        
        $skpdd = substr($lkd_skpd,20);
        
        $selaku='';
        if ($nip_ppkd=='19700502 199003 1 005'){
            $selaku="SELAKU KUASA";
        } else {
            $selaku="SELAKU";
        }
        
        if ($ljns_beban=='62')
        {
            $nm_beban="PENGELUARAN PEMBIAYAAN";
            $satudig='62';
        } else if ($ljns_beban=='5')
        {
            $nm_beban="BELANJA";
            $satudig='5';           
        } else if ($ljns_beban=='52')
        {
            $nm_beban="BELANJA";
            $satudig='5';
        }else
            {
                $nm_beban="-";
            };
            
        $nospd_cetak= $lcnospd;
        $tahun=$this->tukd_model->get_sclient('thn_ang','sclient');
                
        if ($tnp_no=='1'){
        $con_dpn='903/';
        
        $con_blk_btl='/PEMBIAYAAN/BKD/'.$tahun;
        $con_blk_bl='/BELANJA/BKD/'.$tahun;              
    
            ($ljns_beban=='51') ?  $nospd_cetak=$con_dpn."&emsp;&emsp;&emsp;".$con_blk_btl:$nospd_cetak=$con_dpn."&emsp;&emsp;&emsp;".$con_blk_bl;
            }   
        
            
        
        $cRet = '';


        $font = 12;
        $font1 = $font-1;
        

        $cRet .="<table style='border-collapse:collapse;font-weight:bold;font-family:Times New Roman; font-size:12 px;' width='100%' align='center' border='0' cellspacing='0' cellpadding='1'>               
                    <tr>
                        <td width='18%' align='left'>LAMPIRAN SPD NOMOR </td>
                        <td width='72%' align='left'>: $nospd_cetak</td>
                    </tr>
                    <tr>
                        <td colspan=2 width='100%' align='left'>$nm_beban<BR></td>
                    </tr>
                    <tr>
                        <td align='left'> PERIODE BULAN </td><td align='left'>: $periode1 s/d $periode2 $tahun</td>
                    </tr>
                    <tr>
                        <td align='left'>TAHUN ANGGARAN </td><td align='left'>: $lntahunang</td>
                    </tr>
                </table>";
        $cRet .="
           <table style='border-collapse:collapse;font-family:Times New Roman; font-size:$font px;' width='100%' align='center' border='1' cellspacing='0' cellpadding='4'>               
                <tr>
                    <td width='3%' align='center' style='font-weight:bold;'>No.<br>Urut        </td>
                    <td width='17%' align='center' style='font-weight:bold;'>Nomor DPA-/DPPA-SKPD        </td>
                    <td width='28%' align='center' style='font-weight:bold;'>URAIAN      </td>
                    <td width='11%' align='center' style='font-weight:bold;'>ANGGARAN(Rp.)       </td>
                    <td width='10%' align='center' style='font-weight:bold;'>AKUMULASI PADA SPD SEBELUMNYA (Rp.)    </td>
                    <td width='10%' align='center' style='font-weight:bold;'>JUMLAH PADA SPD PERIODE INI (Rp.)</td>
                    <td width='10%' align='center' style='font-weight:bold;'>JUMLAH DANA s/d SPD INI (Rp.)</td>
                    <td width='11%' align='center' style='font-weight:bold;'>SISA ANGGARAN (Rp.)</td>
                </tr>";
            
            $sql="      SELECT '0' no_urut, kd_skpd kode, (select nm_skpd from ms_skpd where kd_skpd=o.kd_skpd) uraian, sum(anggaran) anggaran, sum(spd_lalu) spd_lalu, sum(nilai) nilai from(
                        SELECT b.kd_skpd, rtrim(a.kd_subkegiatan)kode,c.nm_sub_kegiatan,
                        isnull((SELECT SUM(nilai) FROM trdrka WHERE kd_sub_kegiatan = a.kd_subkegiatan AND left(kd_skpd,20)=left(b.kd_skpd,20)),0) AS anggaran,
                        isnull((SELECT SUM(nilai_final) FROM trdspd c LEFT JOIN trhspd d ON c.no_spd=d.no_spd
                        WHERE c.kd_kegiatan = a.kd_kegiatan AND left(d.kd_skpd,20)=left(b.kd_skpd,20) AND c.no_spd <> a.no_spd 
                        AND d.tgl_spd<=b.tgl_spd AND d.jns_beban = b.jns_beban),0) AS spd_lalu,
                        a.nilai FROM trdspd a LEFT JOIN trhspd b ON a.no_spd=b.no_spd  inner join trskpd c on a.kd_subkegiatan=c.kd_sub_kegiatan
                        WHERE  a.no_spd = '$lcnospd') o GROUP BY kd_skpd
                        ";
            $isi=$this->db->query($sql)->row();

              $cRet .="<tr>
                            <td align='center'></td>
                            <td >$isi->kode</td>
                            <td >$isi->uraian</td>
                            <td align='right' >".number_format($isi->anggaran,"2",",",".")."&nbsp;</td>
                            <td align='right' >".number_format($isi->spd_lalu,"2",",",".")."&nbsp;</td>
                            <td align='right' >".number_format($isi->nilai,"2",",",".")."&nbsp;</td>
                            <td align='right' >".number_format($isi->spd_lalu+$isi->nilai,"2",",",".")."&nbsp;</td>
                            <td align='right' >".number_format($isi->anggaran - $isi->spd_lalu - $isi->nilai,"2",",",".")."&nbsp;</td>
                        </tr>";                                            
        
                $sql = " SELECT * from (

                        --sub kegiatan
                        ( SELECT ('')no_urut,rtrim(a.kd_subkegiatan)kode,c.nm_sub_kegiatan uraian,
                        isnull((SELECT SUM($field) FROM trdrka WHERE kd_sub_kegiatan = a.kd_subkegiatan AND left(kd_skpd,20)=left(b.kd_skpd,20)),0) AS anggaran,
                        isnull((SELECT SUM(nilai_final) FROM trdspd c LEFT JOIN trhspd d ON c.no_spd=d.no_spd
                        WHERE c.kd_kegiatan = a.kd_kegiatan AND left(d.kd_skpd,20)=left(b.kd_skpd,20) AND c.no_spd <> a.no_spd 
                        AND d.tgl_spd<=b.tgl_spd AND d.jns_beban = b.jns_beban),0) AS spd_lalu,
                        a.nilai FROM trdspd a LEFT JOIN trhspd b ON a.no_spd=b.no_spd  inner join trskpd c on a.kd_subkegiatan=c.kd_sub_kegiatan
                                WHERE  a.no_spd = '$lcnospd')                                                                        
                        union all 

                        --kegiatan                               
                        select (ROW_NUMBER() OVER (ORDER BY left(kode,12)))no_urut, left(kode,12) kode, (select nm_kegiatan from ms_kegiatan where kd_kegiatan=left(kode,12)) uraian, sum(anggaran) anggaran, sum(spd_lalu) lalu, sum(nilai) nilai from(
                        SELECT ('')no_urut,rtrim(a.kd_subkegiatan)kode,c.nm_sub_kegiatan,
                        isnull((SELECT SUM(nilai) FROM trdrka WHERE kd_sub_kegiatan = a.kd_subkegiatan AND left(kd_skpd,20)=left(b.kd_skpd,20)),0) AS anggaran,
                        isnull((SELECT SUM(nilai_final) FROM trdspd c LEFT JOIN trhspd d ON c.no_spd=d.no_spd
                        WHERE c.kd_kegiatan = a.kd_kegiatan AND left(d.kd_skpd,20)=left(b.kd_skpd,20) AND c.no_spd <> a.no_spd 
                        AND d.tgl_spd<=b.tgl_spd AND d.jns_beban = b.jns_beban),0) AS spd_lalu,
                        a.nilai FROM trdspd a LEFT JOIN trhspd b ON a.no_spd=b.no_spd  inner join trskpd c on a.kd_subkegiatan=c.kd_sub_kegiatan
                        WHERE  a.no_spd = '$lcnospd') kegiatan GROUP BY left(kode,12)

                        union all

                        --program
                        select ('')no_urut, left(kode,7) kode, (select nm_program from ms_program where kd_program=left(kode,7)) uraian, sum(anggaran) anggaran, sum(lalu) lalu, sum(nilai) nilai from(
                        select  left(kode,12) kode, (select nm_kegiatan from ms_kegiatan where kd_kegiatan=left(kode,12)) uraian, sum(anggaran) anggaran, sum(spd_lalu) lalu, sum(nilai) nilai from(
                        SELECT ('')no_urut,rtrim(a.kd_subkegiatan)kode,c.nm_sub_kegiatan,
                        isnull((SELECT SUM(nilai) FROM trdrka WHERE kd_sub_kegiatan = a.kd_subkegiatan AND left(kd_skpd,20)=left(b.kd_skpd,20)),0) AS anggaran,
                        isnull((SELECT SUM(nilai_final) FROM trdspd c LEFT JOIN trhspd d ON c.no_spd=d.no_spd
                        WHERE c.kd_kegiatan = a.kd_kegiatan AND left(d.kd_skpd,20)=left(b.kd_skpd,20) AND c.no_spd <> a.no_spd 
                        AND d.tgl_spd<=b.tgl_spd AND d.jns_beban = b.jns_beban),0) AS spd_lalu,
                        a.nilai FROM trdspd a LEFT JOIN trhspd b ON a.no_spd=b.no_spd  inner join trskpd c on a.kd_subkegiatan=c.kd_sub_kegiatan
                        WHERE  a.no_spd = '$lcnospd') kegiatan GROUP BY left(kode,12)) program GROUP BY left(kode,7)

                        union all

                        --urusan
                        select '' urut, left(kode,4) kode, (select nm_bidang_urusan from ms_bidang_urusan where kd_bidang_urusan=left(kode,4)) uraian, sum(anggaran) anggaran, sum(lalu) lalu, sum(nilai) nilai from(
                        select ('')no_urut, left(kode,7) kode, (select nm_program from ms_program where kd_program=left(kode,7)) uraian, sum(anggaran) anggaran, sum(lalu) lalu, sum(nilai) nilai from(
                        select  left(kode,12) kode, (select nm_kegiatan from ms_kegiatan where kd_kegiatan=left(kode,12)) uraian, sum(anggaran) anggaran, sum(spd_lalu) lalu, sum(nilai) nilai from(
                        SELECT ('')no_urut,rtrim(a.kd_subkegiatan)kode,c.nm_sub_kegiatan,
                        isnull((SELECT SUM(nilai) FROM trdrka WHERE kd_sub_kegiatan = a.kd_subkegiatan AND left(kd_skpd,20)=left(b.kd_skpd,20)),0) AS anggaran,
                        isnull((SELECT SUM(nilai_final) FROM trdspd c LEFT JOIN trhspd d ON c.no_spd=d.no_spd
                        WHERE c.kd_kegiatan = a.kd_kegiatan AND left(d.kd_skpd,20)=left(b.kd_skpd,20) AND c.no_spd <> a.no_spd 
                        AND d.tgl_spd<=b.tgl_spd AND d.jns_beban = b.jns_beban),0) AS spd_lalu,
                        a.nilai FROM trdspd a LEFT JOIN trhspd b ON a.no_spd=b.no_spd  inner join trskpd c on a.kd_subkegiatan=c.kd_sub_kegiatan
                        WHERE  a.no_spd = '$lcnospd') kegiatan GROUP BY left(kode,12)) program GROUP BY left(kode,7)) urusan GROUP BY left(kode,4)

                                ) zt order by kode, no_urut"; 

   
                    
                    $hasil = $this->db->query($sql);
                    $lcno = 0;
                    $lntotal = 0;
                    $jtotal_spd = 0;
                    foreach ($hasil->result() as $row)
                    {
                       $lcno = $lcno + 1;
                       $lcsisa = $row->anggaran - $row->spd_lalu - $row->nilai;
                       $total_spd=$row->spd_lalu + $row->nilai;
                       if ($row->no_urut=='0') {
                        $lcno_urut='';
                       } else {
                           $lcno_urut=$row->no_urut;
                       };
                       $kode=$row->kode;
                       $lenkode = strlen($kode);
                       

                           if ($lenkode == 12){
                                $bold = 'font-weight:bold;';
                                $fontr = $font1;
                           }else{
                                $bold = '';
                                $fontr = $font;
                           }
 
                            if($lenkode==18){
                                $jtotal_spd = $jtotal_spd + $total_spd;
                            }

                        
                $cRet .="<tr>
                            <td align='center' style='$bold font-size:$fontr px'>$lcno_urut</td>
                            <td style='$bold font-size:$fontr px'>$kode</td>
                            <td style='$bold font-size:$fontr px'>$row->uraian</td>
                            <td align='right' style='$bold font-size:$fontr px'>".number_format($row->anggaran,"2",",",".")."&nbsp;</td>
                            <td align='right' style='$bold font-size:$fontr px'>".number_format($row->spd_lalu,"2",",",".")."&nbsp;</td>
                            <td align='right' style='$bold font-size:$fontr px'>".number_format($row->nilai,"2",",",".")."&nbsp;</td>
                            <td align='right' style='$bold font-size:$fontr px'>".number_format($total_spd,"2",",",".")."&nbsp;</td>
                            <td align='right' style='$bold font-size:$fontr px'>".number_format($lcsisa,"2",",",".")."&nbsp;</td>
                        </tr>";    
                        
                    }
                $cRet .="<tr>
                            <td align='right'  colspan='3'>JUMLAH &nbsp;&nbsp;&nbsp;</td>
                            <td align='right' style='font-size:$font1 px'>".number_format($data1->jm_ang,"2",",",".")."&nbsp;</td>
                            <td align='right' style='font-size:$font1 px'>".number_format($data1->jm_spdlalu,"2",",",".")."&nbsp;</td>
                            <td align='right' style='font-size:$font1 px'>".number_format($data1->jm_spdini,"2",",",".")."&nbsp;</td>
                            <td align='right' style='font-size:$font1 px'>".number_format($jtotal_spd,"2",",",".")."&nbsp; </td>
                            <td align='right' style='font-size:$font1 px'>".number_format($lnsisa,"2",",",".")."&nbsp;</td>
                        </tr>";         

                $cRet .="</table>";
        

    
        $init_tgl = $this->tanggal_format_indonesia($ldtgl_spd);

            $cRet .=" <table style='border-collapse:collapse;font-weight: bold;font-family: arial; font-size:12px' width='100%' align='center' border='0' cellspacing='0' cellpadding='1'>
        <tr>
                <td width='50%' align='right' colspan='2'>&nbsp;
                </td>               
                <td width='50%'  align='center'><br>Ditetapkan di Pontianak &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;</td>
                </td>
            </tr>
        <tr >
                <td align='right' colspan='2'>&nbsp;
                </td>   
                <td  text-indent: 50px; align='center'>Pada tanggal : $init_tgl &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                </td>
            </tr>   
        <tr >
                <td width='40%' align='right'>&nbsp;</td>
                <td width='60%'  align='center' colspan='2'>PEJABAT PENGELOLA KEUANGAN DAERAH<br>$selaku BENDAHARA UMUM DAERAH<BR>&nbsp;<br>&nbsp;<br>&nbsp;</td>
                </td>
            </tr>   
        <tr >
                <td align='right'>&nbsp;</td>
                <td  align='center' colspan='2'><u>$nama_ppkd</u></td>
                </td>
            </tr>
                <!--<tr >
                <td align='right'>&nbsp;</td>
                <td align='center' colspan='2'>$pangkat_ppkd</td>
                </td>
            </tr>-->
        <tr >
                <td  align='right'>&nbsp;</td>
                <td align='center' colspan='2'>NIP. $nip_ppkd</td>
                </td>
            </tr>           

        </table>";
            //echo $cRet;

        $data['prev']= $cRet;  

        $hasil->free_result();
        if ($print==1){
            $this->master_pdf->_mpdf('',$cRet,10,10,10,1,'','','',5);
        } else{
        echo $cRet;
        }
        
        
        
        
    }   

    function get_status2($skpd){
        $n_status = '';
        
        $sql = "SELECT case when statu='1' and status_sempurna='1' and status_ubah='1' then 'nilai_ubah' 
                    when statu='1' and status_sempurna='1' then 'nilai_sempurna' 
                    when statu='1' 
                    then 'nilai' else 'nilai' end as anggaran from trhrka where kd_skpd ='$skpd'";
        
        $q_trhrka = $this->db->query($sql);
        $num_rows = $q_trhrka->num_rows();
        
        foreach ($q_trhrka->result() as $r_trhrka){
             $n_status = $r_trhrka->anggaran;                   
        }    
        return $n_status;   
        //$n_status;                      
    }   

    function cetak_otor_spd(){
        
        $print = $this->uri->segment(3);
        $tnp_no = $this->uri->segment(4);
        $jn_keg = $this->uri->segment(7);
        $tambah = $this->uri->segment(5) == '0' ? '' : $this->uri->segment(5);
        $lcnospd = $this->input->post('nomor1');                
        $nip_ppkd = $this->input->post('nip_ppkd');  
        $nama_ppkd = $this->input->post('nama_ppkd');       
        $jabatan_ppkd = $this->input->post('jabatan_ppkd'); 
        $pangkat_ppkd = $this->input->post('pangkat_ppkd');         
        $csql2 = "SELECT nm_skpd,kd_skpd,tgl_spd,total_hasil as total,bulan_awal,bulan_akhir,jns_beban,kd_bkeluar from trhspd where no_spd = '$lcnospd'  ";
        $hasil1 = $this->db->query($csql2);
        $trh1 = $hasil1->row();
        $ldtgl_spd = $trh1->tgl_spd;
        $ldtgl_spd2 = $trh1->tgl_spd;
        $jmlspdini = number_format(($trh1->total),2,',','.');
        if($trh1->total==0){
        $biljmlini = 'nol Rupiah';
            }else{
            $biljmlini = $this->tukd_model->terbilang(($trh1->total));     
            }
        $lckdskpd = $trh1->kd_skpd;
        $blnini = $this->rka_model->getBulan($trh1->bulan_awal);
        $blnsd = $this->rka_model->getBulan($trh1->bulan_akhir);
        $lcnmskpd = $trh1->nm_skpd;
        $ljns_beban =$trh1->jns_beban;
        $lcnipbk = $trh1->kd_bkeluar;
        
        if ($lcnipbk<>''){         
            $sqlttd1="SELECT nama as nm FROM ms_ttd WHERE id='$lcnipbk' ";
                 $sqlttd=$this->db->query($sqlttd1);
                 foreach ($sqlttd->result() as $rowttd)
                {
                    $nama1= empty($rowttd->nm) ? '' : $rowttd->nm;
                }
        }
        else{
                    $nama1= '';
        }
 
        
        $nospd_cetak=$lcnospd;
        if ($tnp_no=='1'){
        $con_dpn='903/';
        $tahun=$this->session->userdata('pcThang');
        $con_blk_btl='/PEMBIAYAAN/BKD/'.$tahun;
        $con_blk_bl='/BELANJA/BKD/'.$tahun;     

    
            ($ljns_beban=='6') ?  $nospd_cetak=$con_dpn."&emsp;&emsp;&emsp;".$con_blk_btl:$nospd_cetak=$con_dpn."&emsp;&emsp;&emsp;".$con_blk_bl;
            }   
        
        // jumlah anggaran
        $n_status = $this->get_status2($lckdskpd);
        
        if($jn_keg=='6'){
        $csql1 = "SELECT SUM($n_status) AS jumlah FROM trdrka WHERE kd_sub_kegiatan IN 
                  (SELECT kd_subkegiatan FROM trdspd WHERE no_spd = '$lcnospd') and left(kd_rek6,1)='6'";
        }else{
            $csql1 = "SELECT SUM($n_status) AS jumlah FROM trdrka WHERE kd_sub_kegiatan IN 
                  (SELECT kd_subkegiatan FROM trdspd WHERE no_spd = '$lcnospd') and left(kd_rek6,1)='5'";
        }                  
                  
        $hasil1 = $this->db->query($csql1);
        $trh2 = $hasil1->row();
        $jmldpa = number_format(ceil($trh2->jumlah),2,',','.');
        
        
        //spd lalu
        $sql = "SELECT sum(total_hasil) as jm_spd_l from trhspd where no_spd<>'$lcnospd' 
                and tgl_spd<='$ldtgl_spd' and kd_skpd='$lckdskpd' and jns_beban='$ljns_beban'";
        $hasil = $this->db->query($sql);
        $trh = $hasil->row();
        $jmlspdlalu = number_format($trh->jm_spd_l,2,',','.');
        
        $csql = "SELECT thn_ang,provinsi,kab_kota,daerah from sclient";
        $hasil = $this->db->query($csql);
        $trh3 = $hasil->row();
        $jmlsisa = number_format(($trh2->jumlah - $trh->jm_spd_l),2,',','.');;
        $jmlsisa2 = number_format(($trh2->jumlah - ($trh->jm_spd_l + $trh1->total)),2,',','.');
        $jmlsisa3 = $trh2->jumlah - ($trh->jm_spd_l + $trh1->total);
        $bilsisa = $this->tukd_model->terbilang($jmlsisa3);

            $njns='';
        if($ljns_beban=='6'){
            $njns = 'Pembiayaan';
        }else {
            $njns = 'Belanja';
        }
        
        $xx = 'Bahwa untuk melaksanakan Anggaran '.$njns.' Tahun Anggaran '.$trh3->thn_ang.' berdasarkan Anggaran Kas yang telah
                ditetapkan, perlu disediakan dengan menerbitkan Surat Penyediaan Dana (SPD); ';
            
        $xx2 = '1. Peraturan Daerah KABUPATEN SANGGAU Nomor. 9 Tahun 2016 tentang APBD KABUPATEN SANGGAU Tahun Anggaran '.$trh3->thn_ang.'.';
        $xx3 = '2. Peraturan WaliKABUPATEN SANGGAU Nomor. 95 Tahun 2016 tentang Penjabaran APBD KABUPATEN SANGGAU Tahun Anggaran '.$trh3->thn_ang.'.';
        $xx4 = '3. DPA-SKPD '.$lcnmskpd.' KABUPATEN SANGGAU (Daftar nomor terlampir)';   
        $cRet = '';
        $cRet .="
        
        <table style='border-collapse:collapse;font-weight: bold;font-family: Times New Roman; font-size:12px' width='100%' align='center' border='0' cellspacing='0' cellpadding='2'>
            <tr>
                <td style='font-size:14px;' align='center'>PEMERINTAH KABUPATEN SANGGAU <br> </td>
            <tr>
            <tr>
                <td align='center'>PEJABAT PENGELOLA KEUANGAN DAERAH SELAKU BENDAHARA UMUM DAERAH <br> </td>
            <tr>
            <td align='center'>NOMOR : $nospd_cetak  <br></td></tr>
             <tr>
            <td align='center'>TENTANG</td></tr>
             <tr>
            <td align='center'>SURAT PENYEDIAAN DANA ANGGARAN BELANJA DAERAH TAHUN ANGGARAN $trh3->thn_ang</td></tr>
            <tr>
            <td align='center'>PPKD SELAKU BENDAHARA UMUM DAERAH</td></tr>
        </table>";
        
        

        $font=10;
 
        $cRet .="<br/><table style='border-collapse:collapse;font-family: Times New Roman;; font-size:$font px' width='100%' align='center' border='0' cellspacing='0' cellpadding='1'>
                <tr>
                    <td width='3%' align='right' valign='top'>&nbsp;</td>
                    <td width='13%' align='left' valign='top' ><strong>Menimbang</strong></td>
                    <td width='5%' align='right' valign='top'>:</td>
                    <td width='70%' align='justify' colspan='2' rowspan='2' valign='top' >$xx</td>
                </tr>               
                <tr>
                    <td align='right' valign='top'>&nbsp;</td>
                    <td align='left' valign='top' >&nbsp;</td>
                    <td align='right' valign='top'>&nbsp;</td>
                </tr>
                <tr>
                    <td width='3%' align='right' valign='top'>&nbsp;</td>
                    <td width='13%' align='left' valign='top' ><strong>Mengingat</strong></td>
                    <td width='5%' align='right' valign='top'>:</td>
                    <td width='70%' align='justify' colspan='2' valign='top' >$xx2</td>
                </tr>
                
                <tr>
                    <td width='3%' align='right' valign='top'>&nbsp;</td>
                    <td width='13%' align='left' valign='top' ><strong></strong></td>
                    <td width='5%' align='right' valign='top'></td>
                    <td width='70%' align='justify' colspan='2' valign='top' >$xx3</td>
                </tr>
                
                <tr>
                    <td width='3%' align='right' valign='top'>&nbsp;</td>
                    <td width='13%' align='left' valign='top' ><strong></strong></td>
                    <td width='5%' align='right' valign='top'></td>
                    <td width='79%' align='justify' colspan='2'  valign='top' >$xx4 ssss</td>
                </tr>
                

        ";
        
        
        
        $selaku='';
        if ($nip_ppkd=='19700502 199003 1 005'){
            $selaku="SELAKU KUASA";
        } else {
            $selaku="SELAKU";
        }
        $kolom1 = '';

            

        $cRet .="</table>";
        
        $cRet .="        
        <table style='border-collapse:collapse;font-family: arial; font-size:12px' width='100%' align='center' border='0' cellspacing='0' cellpadding='4'>
        
            <tr>
                <td colspan='7' align='center' valign='top' width='100%'  style='font-size:12px'> 
                    <strong>M E M U T U S K A N :<strong>&nbsp;
                </td>
            </tr>
            <tr>
                <td width='10%'  style='font-size:12px' align='right'>&nbsp;
                </td>
                <td colspan='6' align='left' valign='top' width='90%'  style='font-size:12px'></td>
            </tr>
            <tr>
                <td width='10%'  style='font-size:12px' align='right'>&nbsp;</td>
                <td width='3%'   style='font-size:12px'>1.</td>
                <td width='35%'  style='font-size:12px'>Ditujukan kepada SKPD</td>
                <td  width='2%' style='font-size:12px'>:</td>
                <td  width='50%' colspan='3'   style='font-size:12px'>$lckdskpd - $lcnmskpd</td>
            </tr>
            <tr>
                <td style='font-size:12px' align='right'>&nbsp;</td>
                <td style='font-size:12px' valign='top'>2.</td>
                <td style='font-size:12px' valign='top'>Bendahara Pengeluaran / Pengeluaran Pembantu </td>
                <td  style='font-size:12px' valign='top'>:</td>
                <td  colspan='3' style='font-size:12px' valign='top'>$nama1</td>
            </tr>
            <tr>
                <td rowspan='2'  style='font-size:12px' valign='top' align='right'>&nbsp;</td>
                <td rowspan='2' style='font-size:12px' valign='top'>3.</td>
                <td rowspan='2' style='font-size:12px' valign='top'>Jumlah Penyediaan dana</td>
                <td rowspan='2' style='font-size:12px' valign='top'>:</td>
                <td width='4%' style='font-size:12px'>Rp. <br></td>
                <td width='20%' align='right' style='font-size:12px'>  $jmlspdini</td>
                <td width='26%'></td>
            </tr>
            <tr>
                <td  colspan='3' style='font-size:12px'><i>(terbilang: $biljmlini)</i></td>
            </tr>
            <tr>
                <td  style='font-size:12px' align='right'>&nbsp;</td>
                <td style='font-size:12px'>4.</td>
                <td style='font-size:12px'>Untuk Kebutuhan / Jenis Beban</td>
                <td  style='font-size:12px'>:</td>
                <td  colspan='3'   style='font-size:12px'>$tambah Bulan $blnini s.d Bulan $blnsd $trh3->thn_ang / $njns</td>
            </tr>
            <tr>
                <td style='font-size:12px' align='right'>&nbsp;</td>
                <td style='font-size:12px'>5.</td>
                <td style='font-size:12px'><u><strong>IKHTISAR PENYEDIAAN DANA : </strong></u></td>
                <td  style='font-size:12px'></td>
                <td  colspan='3'   style='font-size:12px'></td>
            </tr>
            <tr>
                <td style='font-size:12px'>&nbsp;</td>
                <td style='font-size:12px' valign='top'>&nbsp;</td>
                <td style='font-size:12px' valign='top'>a. Jumlah dana DPA-SKPD/DPPA-SKPD/DPAL</td>
                <td style='font-size:12px' valign='top'>:</td>
                <td style='font-size:12px'>Rp. <br></td>
                <td align='right' style='font-size:12px'>  $jmldpa</td>
                <td ></td>
                
            </tr>
            <tr>
                <td  style='font-size:12px'>&nbsp;</td>
                <td  style='font-size:12px' valign='top'>&nbsp;</td>
                <td  style='font-size:12px;' valign='top'>b. Akumulasi SPD sebelumnya</td>
                <td  style='font-size:12px' valign='top'>:</td>
                <td style='font-size:12px;border-bottom: solid 1px black;'>Rp. <br></td>
                <td align='right' style='font-size:12px;border-bottom: solid 1px black;'>  $jmlspdlalu</td>
                <td ></td>

                </tr>
            <tr>
                <td style='font-size:12px'>&nbsp;</td>
                <td style='font-size:12px' valign='top'>&nbsp;</td>
                <td style='font-size:12px' valign='top'>c. Sisa dana yang belum di-SPD-kan</td>
                <td  style='font-size:12px' valign='top'>:</td>
                <td style='font-size:12px'>Rp. <br></td>
                <td align='right' style='font-size:12px'>  $jmlsisa</td>
                <td ></td>
            </tr>
           <tr>
                <td style='font-size:12px'>&nbsp;</td>
                <td style='font-size:12px' valign='top'>&nbsp;</td>
                <td style='font-size:12px' valign='top'>d. Jumlah dana yang di-SPD-kan saat ini</td>
                <td style='font-size:12px;' valign='top'>:</td>
                <td style='font-size:12px;border-bottom: solid 1px black;'>Rp. <br></td>
                <td align='right' style='font-size:12px;border-bottom: solid 1px black;'>  $jmlspdini</td>
                <td ></td>

            </tr>
            <tr>
                <td rowspan='2'  style='font-size:12px'>&nbsp;</td>
                <td rowspan='2'  style='font-size:12px' valign='top'>&nbsp;</td>
                <td rowspan='2'  style='font-size:12px' valign='top'>e. Sisa jumlah dana DPA yang belum di-SPD-kan</td>
                <td rowspan='2'  style='font-size:12px' valign='top'>:</td>
                <td style='font-size:12px;border-bottom: solid 2px black;'>Rp. <br></td>
                <td align='right' style='font-size:12px;border-bottom: solid 2px black;'>  $jmlsisa2 <br></td>
                <td ></td>
 
            </tr>
            <tr>
                <td  colspan='3' style='font-size:12px'><i>(terbilang: $bilsisa)</i></td>
            </tr>
            <tr> 
                <td style='font-size:12px'>&nbsp;</td>
                <td style='font-size:12px' align='right' valign='top'>6.</td>
                <td style='font-size:12px' valign='top'>Ketentuan-ketentuan lain</td>
                <td style='font-size:12px' valign='top'>:</td>
                <td  colspan='3' align='justify' style='font-size:12px'>Terhadap cara memperoleh, menggunakan dan mempertanggung- jawabkan
uang yang dimaksud tetap berpedoman pada Peraturan Perundang-Undangan
yang berlaku
                </td>
            </tr>           
            </table>";
             // CETAKAN TANDA TANGAN by Tox
             
             $init_tgl = $this->tanggal_format_indonesia($ldtgl_spd);
             $init_tgl2 = $this->tanggal_format_indonesia($ldtgl_spd2);
             
            $cRet .="
    <table style='border-collapse:collapse;font-weight:none;font-family: arial; font-size:12px' width='100%' align='center' border='0' cellspacing='0' cellpadding='2'>
        <tr>
            <td width='50%' align='right' colspan='2'>&nbsp;</td>               
            <td width='50%'  align='left'><br>Ditetapkan di Pontianak</td>
        </tr>
        <tr>
            <td align='right' colspan='2'>&nbsp;</td>   
            <td  text-indent: 50px; align='left'><u>Pada tanggal : $init_tgl2 &nbsp;<u></td>
        </tr>   
        <tr>
            <td width='40%' align='right'>&nbsp;</td>
            <td width='60%'  align='center' colspan='2'>PEJABAT PENGELOLA KEUANGAN DAERAH<br>$selaku BENDAHARA UMUM DAERAH<BR>&nbsp;<br>&nbsp;<br>&nbsp;</td>
        </tr>   
        <tr>
            <td align='right'>&nbsp;</td>
            <td  align='center' colspan='2'><u>$nama_ppkd</u></td>
        </tr>
        <tr >
            <td align='right'>&nbsp;</td>
            <td align='center' colspan='2'>$pangkat_ppkd</td>
        </tr>
        <tr >
            <td  align='right'>&nbsp;</td>
            <td align='center' colspan='2'>NIP. $nip_ppkd</td>
        </tr>           
        </table>";
        $data['prev']= $cRet;
      
        if ($print==1){
            // $this->rka_model->_mpdf_folio('',$cRet,10,10,10,'0');
            $this->master_pdf->_mpdf('',$cRet,10,10,10,'0','no','','',30);

        } else{
          echo $cRet;
        }

}





}