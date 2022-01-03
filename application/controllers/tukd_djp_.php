<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class tukd_djp extends CI_Controller {

	function __contruct()
	{	
		parent::__construct();
  
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
    
    
    function cetak_csv1($nbulan=''){                        
        ob_start();
        $thn = $this->session->userdata('pcThang');
        
        if(strlen($nbulan)==2){
            $nbulan=$nbulan;
        }else{
            $nbulan='0'.$nbulan;
        }
        
        $cRet ='';
        $data ='';
        $satker ='992012';       
        $par_rek_pot = "('2130101','2130201','2130301','2130401','2130501')"; 
                              
        $filenamee = $thn.$nbulan.$satker."01";                                 
                        
		$sql="
SELECT x.* FROM(
SELECT z.kd_skpd as SKPD,z.TAHUN,z.KDSATKER,z.KDPEMDA,z.KDURUSAN,z.URAIANURUSAN,
z.KDKELURUSAN,z.URAIANKELURUSAN,z.KDORG,z.URAIANORG,z.NOSP2D,z.NOSPM,z.JNSSP2D,z.TGLSP2D,
z.NILAI,z.NPWPBUD,z.NPWPBENDAHARA,z.NPWPREKANAN,z.KET,z.NAMAREKANAN
FROM(
SELECT left(d.kd_skpd,7)+'.00' as kd_skpd,
'$thn' TAHUN,
'992012' KDSATKER,
'1409' KDPEMDA,
CASE WHEN SUBSTRING(d.kd_skpd,1,4) is null then SUBSTRING(d.kd_skpd,1,4) else SUBSTRING(d.kd_skpd,1,4) end AS KDURUSAN,
CASE WHEN SUBSTRING(d.kd_skpd,1,4) is null then 
(select nm_urusan from dbo.ms_urusan where kd_urusan=SUBSTRING(d.kd_skpd,1,4)) else
(select nm_urusan from dbo.ms_urusan where kd_urusan=SUBSTRING(d.kd_skpd,1,4)) end AS URAIANURUSAN,
CASE WHEN SUBSTRING(d.kd_skpd,1,4) is null then SUBSTRING(d.kd_skpd,1,4) else SUBSTRING(d.kd_skpd,1,4) end AS KDKELURUSAN,
CASE WHEN SUBSTRING(d.kd_skpd,1,4) is null then 
(select nm_urusan from dbo.ms_urusan where kd_urusan=SUBSTRING(d.kd_skpd,1,4)) else
(select nm_urusan from dbo.ms_urusan where kd_urusan=SUBSTRING(d.kd_skpd,1,4)) end AS URAIANKELURUSAN,
CASE WHEN SUBSTRING(d.kd_skpd,6,2) is null then SUBSTRING(d.kd_skpd,6,2) else SUBSTRING(d.kd_skpd,6,2) end AS KDORG,
(select nm_org from ms_organisasi where kd_org=left(d.kd_skpd,7)) AS URAIANORG,
RTRIM(d.no_sp2d) NOSP2D,
RTRIM(d.no_spm) NOSPM,
d.jns_spp JNSSP2D,
REPLACE(d.tgl_sp2d,'-','') TGLSP2D,
d.nilai NILAI,
'001919422701000' NPWPBUD,
( SELECT REPLACE(REPLACE(REPLACE(npwp, '.', ''),'-',''),' ','') FROM MS_SKPD WHERE KD_SKPD=left(d.kd_skpd,7)+'.00') NPWPBENDAHARA,
REPLACE(REPLACE(REPLACE(d.npwp, '.', ''),'-',''),' ','') NPWPREKANAN,
RTRIM(REPLACE(REPLACE(d.keperluan, CHAR(13), ''),CHAR(10),'')) KET,
RTRIM(d.nmrekan) NAMAREKANAN
FROM trdspp a 
INNER JOIN trhsp2d d on a.no_spp = d.no_spp AND a.kd_skpd=d.kd_skpd
WHERE MONTH(d.tgl_sp2d)='$nbulan' and (d.sp2d_batal is null or d.sp2d_batal<>'1') 
GROUP BY left(d.kd_skpd,7),SUBSTRING(d.kd_skpd,1,4),SUBSTRING(d.kd_skpd,6,2),
d.no_sp2d,d.no_spm,d.jns_spp,d.tgl_sp2d,d.nilai,d.npwp,d.keperluan,d.nmrekan

UNION ALL

SELECT left(a.kd_skpd,7)+'.00' as kd_skpd,
'$thn' TAHUN,
'992012' KDSATKER,
'1409' KDPEMDA,
CASE WHEN SUBSTRING(a.kd_skpd,1,4) is null then SUBSTRING(a.kd_skpd,1,4) else SUBSTRING(a.kd_skpd,1,4) end AS KDURUSAN,
CASE WHEN SUBSTRING(a.kd_skpd,1,4) is null then 
(select nm_urusan from dbo.ms_urusan where kd_urusan=SUBSTRING(a.kd_skpd,1,4)) else
(select nm_urusan from dbo.ms_urusan where kd_urusan=SUBSTRING(a.kd_skpd,1,4)) end AS URAIANURUSAN,
CASE WHEN SUBSTRING(a.kd_skpd,1,4) is null then SUBSTRING(a.kd_skpd,1,4) else SUBSTRING(a.kd_skpd,1,4) end AS KDKELURUSAN,
CASE WHEN SUBSTRING(a.kd_skpd,1,4) is null then 
(select nm_urusan from dbo.ms_urusan where kd_urusan=SUBSTRING(a.kd_skpd,1,4)) else
(select nm_urusan from dbo.ms_urusan where kd_urusan=SUBSTRING(a.kd_skpd,1,4)) end AS URAIANKELURUSAN,
CASE WHEN SUBSTRING(a.kd_skpd,6,2) is null then SUBSTRING(a.kd_skpd,6,2) else SUBSTRING(a.kd_skpd,6,2) end AS KDORG,
(select nm_org from ms_organisasi where kd_org=left(a.kd_skpd,7)) AS URAIANORG,
RTRIM(a.no_sp2b) NOSP2D,
RTRIM(a.no_sp2b) NOSPM,
'0' JNSSP2D,
REPLACE(a.tgl_sp2b,'-','') TGLSP2D,
sum(b.nilai) NILAI,
'001919422701000' NPWPBUD,
( SELECT REPLACE(REPLACE(REPLACE(npwp, '.', ''),'-',''),' ','') FROM MS_SKPD WHERE KD_SKPD=left(a.kd_skpd,7)+'.00') NPWPBENDAHARA,
REPLACE(REPLACE(REPLACE('', '.', ''),'-',''),' ','') NPWPREKANAN,
RTRIM(REPLACE(REPLACE(a.keterangan+'(SP2B)', CHAR(13), ''),CHAR(10),'')) KET,
RTRIM('') NAMAREKANAN
from trhsp3b a inner join trsp3b b on b.no_sp3b=a.no_sp3b and b.kd_skpd=a.kd_skpd
where MONTH(a.tgl_sp2b)='$nbulan' and b.nilai<>0
group by a.kd_skpd,a.no_sp2b,a.tgl_sp2b,a.keterangan

UNION ALL

SELECT left(a.kd_skpd,7)+'.00' as kd_skpd,
'$thn' TAHUN,
'992012' KDSATKER,
'1409' KDPEMDA,
CASE WHEN SUBSTRING(a.kd_skpd,1,4) is null then SUBSTRING(a.kd_skpd,1,4) else SUBSTRING(a.kd_skpd,1,4) end AS KDURUSAN,
CASE WHEN SUBSTRING(a.kd_skpd,1,4) is null then 
(select nm_urusan from dbo.ms_urusan where kd_urusan=SUBSTRING(a.kd_skpd,1,4)) else
(select nm_urusan from dbo.ms_urusan where kd_urusan=SUBSTRING(a.kd_skpd,1,4)) end AS URAIANURUSAN,
CASE WHEN SUBSTRING(a.kd_skpd,1,4) is null then SUBSTRING(a.kd_skpd,1,4) else SUBSTRING(a.kd_skpd,1,4) end AS KDKELURUSAN,
CASE WHEN SUBSTRING(a.kd_skpd,1,4) is null then 
(select nm_urusan from dbo.ms_urusan where kd_urusan=SUBSTRING(a.kd_skpd,1,4)) else
(select nm_urusan from dbo.ms_urusan where kd_urusan=SUBSTRING(a.kd_skpd,1,4)) end AS URAIANKELURUSAN,
CASE WHEN SUBSTRING(a.kd_skpd,6,2) is null then SUBSTRING(a.kd_skpd,6,2) else SUBSTRING(a.kd_skpd,6,2) end AS KDORG,
(select nm_org from ms_organisasi where kd_org=left(a.kd_skpd,7)) AS URAIANORG,
RTRIM(a.no_sp2b) NOSP2D,
RTRIM(a.no_sp2b) NOSPM,
'0' JNSSP2D,
REPLACE(a.tgl_sp2b,'-','') TGLSP2D,
sum(b.nilai) NILAI,
'001919422701000' NPWPBUD,
( SELECT REPLACE(REPLACE(REPLACE(npwp, '.', ''),'-',''),' ','') FROM MS_SKPD_BOS WHERE KD_SKPD=a.kd_skpd) NPWPBENDAHARA,
REPLACE(REPLACE(REPLACE('', '.', ''),'-',''),' ','') NPWPREKANAN,
RTRIM(REPLACE(REPLACE(a.keterangan+'(SP2B)', CHAR(13), ''),CHAR(10),'')) KET,
RTRIM('') NAMAREKANAN
from trhsp3b_bos a inner join trsp3b_bos b on b.no_sp3b=a.no_sp3b and b.kd_skpd=a.kd_skpd
where MONTH(a.tgl_sp2b)='$nbulan' and b.nilai<>0
group by a.kd_skpd,a.no_sp2b,a.tgl_sp2b,a.keterangan

)z left join (
SELECT left(b.kd_skpd,7)+'.00' as kd_skpd, b.no_sp2d, SUM(a.nilai) nil_pot FROM trdstrpot a INNER JOIN trhstrpot b
ON a.no_bukti=b.no_bukti AND a.kd_skpd=b.kd_skpd
WHERE RTRIM(a.kd_rek5) IN $par_rek_pot 
GROUP BY left(b.kd_skpd,7),b.no_sp2d
)x on x.kd_skpd=z.kd_skpd and x.no_sp2d = z.NOSP2D
group by z.kd_skpd,z.TAHUN,z.KDSATKER,z.KDPEMDA,z.KDURUSAN,z.URAIANURUSAN,
z.KDKELURUSAN,z.URAIANKELURUSAN,z.KDORG,z.URAIANORG,z.NOSP2D,z.NOSPM,z.JNSSP2D,z.TGLSP2D,
z.NILAI,z.NPWPBUD,z.NPWPBENDAHARA,z.NPWPREKANAN,z.KET,z.NAMAREKANAN
)x where x.NOSP2D <> '' and x.NILAI IS NOT NULL ORDER BY x.NOSP2D";

//and left(d.kd_skpd,7)='1.02.01'
                $sql_query = $this->db->query($sql);              
				foreach ($sql_query->result_array() as $row){
				$nilai  = strval($row['NILAI']);
                $nilai  = str_replace(".00","",$nilai);
                $nilai  = str_replace(".",",",$nilai);
                $npwpBUD = '\''.$row['NPWPBUD'];                
                $npwpSKPD = '\''.$row['NPWPBENDAHARA'];
                $npwpRekan= '\''.$row['NPWPREKANAN']; 
                    
                if($nilai==''){
                    $nilai = 0;
                }
                
                    $data = $row['TAHUN'].';'.$row['KDSATKER'].';'.$row['KDPEMDA'].';'.$row['KDURUSAN'].';'.$row['URAIANURUSAN'].';'.$row['KDKELURUSAN'].';'.$row['URAIANKELURUSAN'].';'.$row['KDORG'].';'.$row['URAIANORG'].';'.strval($row['NOSP2D']).';'.$row['NOSPM'].';'.$row['JNSSP2D'].';'.$row['TGLSP2D'].';'.$nilai.';'.$npwpBUD.';'.$npwpSKPD.';'.$npwpRekan.';'.preg_replace('~[\n]+~', '', $row['KET']).';'.$row['NAMAREKANAN']."\n";                                                      
                
                echo $data;                        
                header("Cache-Control: no-cache, no-store");                                
                header("Content-Type: application/csv");                
                header("Content-Disposition: attachement; filename=$filenamee.csv");                                 
                
                }              
}


    function cetak_csv2($nbulan=''){                        
        ob_start();
        $thn = $this->session->userdata('pcThang');
        
        if(strlen($nbulan)==2){
            $nbulan=$nbulan;
        }else{
            $nbulan='0'.$nbulan;
        }
        
        $cRet ='';
        $data ='';
        $satker ='992012';       
        $par_rek_pot = "('2130101','2130201','2130301','2130401','2130501')";       
        $filenamee = $thn.$nbulan.$satker."02";                                 
                  
		$sql="

select 
y.kd_skpd as SKPD,y.TAHUN,y.KDSATKER,y.KDURUSAN,y.KDKELURUSAN,y.KDORG,y.NOSP2D,
y.KDAKUN,y.URAIANAKUN,y.KDKELAKUN,y.URAIANKELAKUN,y.KDJNSAKUN,y.URAIANJNSAKUN,
y.KDOBJAKUN,y.URAIANOBJAKUN,y.KDRINCIOBJAKUN,URAIANRINCIOBJAKUN,y.NILAIBELANJA
 from (
select x.*  from (
SELECT left(a.kd_skpd,7)+'.00' as kd_skpd,
'$thn' TAHUN,
'992012' KDSATKER,
'1409' KDPEMDA,
CASE WHEN SUBSTRING(a.kd_skpd,1,4) is null then SUBSTRING(a.kd_skpd,1,4) else SUBSTRING(a.kd_skpd,1,4) end AS KDURUSAN,
CASE WHEN SUBSTRING(a.kd_skpd,1,4) is null then SUBSTRING(a.kd_skpd,1,4) else SUBSTRING(a.kd_skpd,1,4) end AS KDKELURUSAN,
CASE WHEN SUBSTRING(a.kd_skpd,6,2) is null then SUBSTRING(a.kd_skpd,6,2) else SUBSTRING(a.kd_skpd,6,2) end AS KDORG,
a.no_sp2d NOSP2D,a.no_spp,b.kd_rek5,
SUBSTRING(b.kd_rek5,1,1) AS KDAKUN,(SELECT DISTINCT nm_rek1 FROM ms_rek1 WHERE kd_rek1=SUBSTRING(b.kd_rek5,1,1)) AS URAIANAKUN,
SUBSTRING(b.kd_rek5,2,1) AS KDKELAKUN,(SELECT DISTINCT nm_rek2 FROM ms_rek2 WHERE kd_rek2=SUBSTRING(b.kd_rek5,1,2)) AS URAIANKELAKUN,
SUBSTRING(b.kd_rek5,3,1) AS KDJNSAKUN,(SELECT DISTINCT nm_rek3 FROM ms_rek3 WHERE kd_rek3=SUBSTRING(b.kd_rek5,1,3)) AS URAIANJNSAKUN,
SUBSTRING(b.kd_rek5,4,2) AS KDOBJAKUN,(SELECT DISTINCT nm_rek4 FROM ms_rek4 WHERE kd_rek4=SUBSTRING(b.kd_rek5,1,5)) AS URAIANOBJAKUN,
SUBSTRING(b.kd_rek5,6,2) AS KDRINCIOBJAKUN,(SELECT DISTINCT nm_rek5 FROM ms_rek5 WHERE kd_rek5=b.kd_rek5) AS URAIANRINCIOBJAKUN,
sum(b.nilai) as NILAIBELANJA
from trhsp2d a 
inner join trdspp b on b.kd_skpd=a.kd_skpd and a.no_spp=b.no_spp
where MONTH(a.tgl_sp2d)='$nbulan' and (a.sp2d_batal is null or a.sp2d_batal<>'1')  
group by left(a.kd_skpd,7),SUBSTRING(a.kd_skpd,1,4),SUBSTRING(a.kd_skpd,6,2),a.no_sp2d,a.no_spp,b.kd_rek5

UNION ALL

SELECT left(a.kd_skpd,7)+'.00' as kd_skpd,
'$thn' TAHUN,
'992012' KDSATKER,
'1409' KDPEMDA,
CASE WHEN SUBSTRING(a.kd_skpd,1,4) is null then SUBSTRING(a.kd_skpd,1,4) else SUBSTRING(a.kd_skpd,1,4) end AS KDURUSAN,
CASE WHEN SUBSTRING(a.kd_skpd,1,4) is null then SUBSTRING(a.kd_skpd,1,4) else SUBSTRING(a.kd_skpd,1,4) end AS KDKELURUSAN,
CASE WHEN SUBSTRING(a.kd_skpd,6,2) is null then SUBSTRING(a.kd_skpd,6,2) else SUBSTRING(a.kd_skpd,6,2) end AS KDORG,
a.no_sp2b NOSP2D,b.no_sp3b,b.kd_rek5,
SUBSTRING(b.kd_rek5,1,1) AS KDAKUN,(SELECT DISTINCT nm_rek1 FROM ms_rek1 WHERE kd_rek1=SUBSTRING(b.kd_rek5,1,1)) AS URAIANAKUN,
SUBSTRING(b.kd_rek5,2,1) AS KDKELAKUN,(SELECT DISTINCT nm_rek2 FROM ms_rek2 WHERE kd_rek2=SUBSTRING(b.kd_rek5,1,2)) AS URAIANKELAKUN,
SUBSTRING(b.kd_rek5,3,1) AS KDJNSAKUN,(SELECT DISTINCT nm_rek3 FROM ms_rek3 WHERE kd_rek3=SUBSTRING(b.kd_rek5,1,3)) AS URAIANJNSAKUN,
SUBSTRING(b.kd_rek5,4,2) AS KDOBJAKUN,(SELECT DISTINCT nm_rek4 FROM ms_rek4 WHERE kd_rek4=SUBSTRING(b.kd_rek5,1,5)) AS URAIANOBJAKUN,
SUBSTRING(b.kd_rek5,6,2) AS KDRINCIOBJAKUN,(SELECT DISTINCT nm_rek5 FROM ms_rek5 WHERE kd_rek5=b.kd_rek5) AS URAIANRINCIOBJAKUN,
sum(b.nilai) as NILAIBELANJA
from trhsp3b a inner join trsp3b b on b.no_sp3b=a.no_sp3b and b.kd_skpd=a.kd_skpd
where MONTH(a.tgl_sp2b)='$nbulan' and b.nilai<>0
group by a.kd_skpd,a.no_sp2b,b.no_sp3b,b.kd_rek5,b.nilai

UNION ALL

SELECT left(a.kd_skpd,7)+'.00' as kd_skpd,
'$thn' TAHUN,
'992012' KDSATKER,
'1409' KDPEMDA,
CASE WHEN SUBSTRING(a.kd_skpd,1,4) is null then SUBSTRING(a.kd_skpd,1,4) else SUBSTRING(a.kd_skpd,1,4) end AS KDURUSAN,
CASE WHEN SUBSTRING(a.kd_skpd,1,4) is null then SUBSTRING(a.kd_skpd,1,4) else SUBSTRING(a.kd_skpd,1,4) end AS KDKELURUSAN,
CASE WHEN SUBSTRING(a.kd_skpd,6,2) is null then SUBSTRING(a.kd_skpd,6,2) else SUBSTRING(a.kd_skpd,6,2) end AS KDORG,
a.no_sp2b NOSP2D,b.no_sp3b,b.kd_rek5,
SUBSTRING(b.kd_rek5,1,1) AS KDAKUN,(SELECT DISTINCT nm_rek1 FROM ms_rek1 WHERE kd_rek1=SUBSTRING(b.kd_rek5,1,1)) AS URAIANAKUN,
SUBSTRING(b.kd_rek5,2,1) AS KDKELAKUN,(SELECT DISTINCT nm_rek2 FROM ms_rek2 WHERE kd_rek2=SUBSTRING(b.kd_rek5,1,2)) AS URAIANKELAKUN,
SUBSTRING(b.kd_rek5,3,1) AS KDJNSAKUN,(SELECT DISTINCT nm_rek3 FROM ms_rek3 WHERE kd_rek3=SUBSTRING(b.kd_rek5,1,3)) AS URAIANJNSAKUN,
SUBSTRING(b.kd_rek5,4,2) AS KDOBJAKUN,(SELECT DISTINCT nm_rek4 FROM ms_rek4 WHERE kd_rek4=SUBSTRING(b.kd_rek5,1,5)) AS URAIANOBJAKUN,
SUBSTRING(b.kd_rek5,6,2) AS KDRINCIOBJAKUN,(SELECT DISTINCT nm_rek5 FROM ms_rek5 WHERE kd_rek5=b.kd_rek5) AS URAIANRINCIOBJAKUN,
sum(b.nilai) as NILAIBELANJA
from trhsp3b_bos a inner join trsp3b_bos b on b.no_sp3b=a.no_sp3b and b.kd_skpd=a.kd_skpd
where MONTH(a.tgl_sp2b)='$nbulan' and b.nilai<>0
group by a.kd_skpd,a.no_sp2b,b.no_sp3b,b.kd_rek5,b.nilai


)x
)y order by y.NOSP2D
";

                $sql_query = $this->db->query($sql);              
				foreach ($sql_query->result_array() as $row) {
				    $nilai  = strval($row['NILAIBELANJA']);
                    $nilai  = str_replace(".00","",$nilai);
                    $nilai  = str_replace(".",",",$nilai);
                    
                    if($nilai==''){
                    $nilai = 0;
                    }
                       
                    $data = $row['TAHUN'].';'.$row['KDSATKER'].';'.$row['KDURUSAN'].';'.$row['KDKELURUSAN'].';'.$row['KDORG'].';'.$row['NOSP2D'].';'.$row['KDAKUN'].';'.$row['URAIANAKUN'].';'.$row['KDKELAKUN'].';'.$row['URAIANKELAKUN'].';'.$row['KDJNSAKUN'].';'.$row['URAIANJNSAKUN'].';'.$row['KDOBJAKUN'].';'.$row['URAIANOBJAKUN'].';'.$row['KDRINCIOBJAKUN'].';'.$row['URAIANRINCIOBJAKUN'].';'.$nilai."\n";                                                      
                
                echo $data;                        
                header("Cache-Control: no-cache, no-store");                                
                header("Content-Type: application/csv");                
                header("Content-Disposition: attachement; filename=$filenamee.csv");                                 
                
                }
                            			
		
}

    function cetak_csv3($nbulan=''){                        
        ob_start();
        $thn = $this->session->userdata('pcThang');
        
        if(strlen($nbulan)==2){
            $nbulan=$nbulan;
        }else{
            $nbulan='0'.$nbulan;
        }
        
        $cRet ='';
        $data ='';
        $satker ='992012';       
        $par_rek_pot = "('2130101','2130201','2130301','2130401','2130501')";       
        $filenamee = $thn.$nbulan.$satker."03";                                 
                  
		$sql="
SELECT x.* FROM(
SELECT z.kd_skpd as SKPD,z.TAHUN,z.KDSATKER,z.KDURUSAN,z.KDKELURUSAN,z.KDORG,
z.NOSP2D,
CASE WHEN x.kd_rek5='2130101' then '411121'
     WHEN x.kd_rek5='2130201' then '411122'
     WHEN x.kd_rek5='2130301' then '411211'
     WHEN x.kd_rek5='2130401' then '411124'
     WHEN x.kd_rek5='2130501' then '411128'
END AS KDPAJAK,
x.nil_pot NILAIPAJAK
FROM(
SELECT left(d.kd_skpd,7)+'.00' as kd_skpd,
'$thn' TAHUN,
'992012' KDSATKER,
'1409' KDPEMDA,
CASE WHEN SUBSTRING(d.kd_skpd,1,4) is null then SUBSTRING(d.kd_skpd,1,4) else SUBSTRING(d.kd_skpd,1,4) end AS KDURUSAN,
CASE WHEN SUBSTRING(d.kd_skpd,1,4) is null then 
(select nm_urusan from dbo.ms_urusan where kd_urusan=SUBSTRING(d.kd_skpd,1,4)) else
(select nm_urusan from dbo.ms_urusan where kd_urusan=SUBSTRING(d.kd_skpd,1,4)) end AS URAIANURUSAN,
CASE WHEN SUBSTRING(d.kd_skpd,1,4) is null then SUBSTRING(d.kd_skpd,1,4) else SUBSTRING(d.kd_skpd,1,4) end AS KDKELURUSAN,
CASE WHEN SUBSTRING(d.kd_skpd,1,4) is null then 
(select nm_urusan from dbo.ms_urusan where kd_urusan=SUBSTRING(d.kd_skpd,1,4)) else
(select nm_urusan from dbo.ms_urusan where kd_urusan=SUBSTRING(d.kd_skpd,1,4)) end AS URAIANKELURUSAN,
CASE WHEN SUBSTRING(d.kd_skpd,6,2) is null then SUBSTRING(d.kd_skpd,6,2) else SUBSTRING(d.kd_skpd,6,2) end AS KDORG,
(select nm_org from ms_organisasi where kd_org=left(d.kd_skpd,7)) AS URAIANORG,
RTRIM(d.no_sp2d) NOSP2D
FROM trdspp a 
INNER JOIN trhsp2d d on a.no_spp = d.no_spp AND a.kd_skpd=d.kd_skpd
WHERE MONTH(d.tgl_sp2d)='$nbulan' and (d.sp2d_batal is null or d.sp2d_batal<>'1') 
GROUP BY left(d.kd_skpd,7),SUBSTRING(d.kd_skpd,1,4),SUBSTRING(d.kd_skpd,6,2),
d.no_sp2d
)z left join (
SELECT left(b.kd_skpd,7)+'.00' as kd_skpd, b.no_sp2d, a.kd_rek5, SUM(a.nilai) nil_pot FROM trdstrpot a INNER JOIN trhstrpot b
ON a.no_bukti=b.no_bukti AND a.kd_skpd=b.kd_skpd
WHERE RTRIM(a.kd_rek5) IN $par_rek_pot 
GROUP BY left(b.kd_skpd,7),b.no_sp2d,a.kd_rek5
)x on x.kd_skpd=z.kd_skpd and rtrim(x.no_sp2d) = rtrim(z.NOSP2D)
group by z.kd_skpd,z.TAHUN,z.KDSATKER,z.KDPEMDA,z.KDURUSAN,z.URAIANURUSAN,
z.KDKELURUSAN,z.URAIANKELURUSAN,z.KDORG,z.URAIANORG,z.NOSP2D,x.kd_rek5,x.nil_pot
)x where x.NOSP2D <> '' and x.NILAIPAJAK IS NOT NULL 
";

                $sql_query = $this->db->query($sql);              
				foreach ($sql_query->result_array() as $row) {
				$nilai  = strval($row['NILAIPAJAK']);
                $nilai  = str_replace(".00","",$nilai);
                $nilai  = str_replace(".",",",$nilai);
                
                if($nilai==''){
                    $nilai = 0;
                }
                        
                    $data = $row['TAHUN'].';'.$row['KDSATKER'].';'.$row['KDURUSAN'].';'.$row['KDKELURUSAN'].';'.$row['KDORG'].';'.$row['NOSP2D'].';'.$row['KDPAJAK'].';'.$nilai."\n";                                                      
                
                echo $data;                        
                header("Cache-Control: no-cache, no-store");                                
                header("Content-Type: application/csv");                
                header("Content-Disposition: attachement; filename=$filenamee.csv");                                 
                
                }
} 

    function cetak_csv4($nbulan=''){                        
        ob_start();
        $thn = $this->session->userdata('pcThang');
        
        if(strlen($nbulan)==2){
            $nbulan=$nbulan;
        }else{
            $nbulan='0'.$nbulan;
        }
        
        $cRet ='';
        $data ='';
        $satker ='992012';       
        $par_rek_pot = "('2130101','2130201','2130301','2130401','2130501')";       
        $filenamee = $thn.$nbulan.$satker."04";                                 
                  
		$sql="SELECT 
b.no_bukti,
'$thn' TAHUN,
'992012' KDSATKER,
'1409' KDPEMDA,
CASE WHEN SUBSTRING(b.kd_skpd,1,4) is null then SUBSTRING(b.kd_skpd,1,4) else SUBSTRING(b.kd_skpd,1,4) end AS KDURUSAN,
CASE WHEN SUBSTRING(b.kd_skpd,1,4) is null then 
(select nm_urusan from dbo.ms_urusan where kd_urusan=SUBSTRING(b.kd_skpd,1,4)) else
(select nm_urusan from dbo.ms_urusan where kd_urusan=SUBSTRING(b.kd_skpd,1,4)) end AS URAIANURUSAN,
CASE WHEN SUBSTRING(b.kd_skpd,1,4) is null then SUBSTRING(b.kd_skpd,1,4) else SUBSTRING(b.kd_skpd,1,4) end AS KDKELURUSAN,
CASE WHEN SUBSTRING(b.kd_skpd,1,4) is null then 
(select nm_urusan from dbo.ms_urusan where kd_urusan=SUBSTRING(b.kd_skpd,1,4)) else
(select nm_urusan from dbo.ms_urusan where kd_urusan=SUBSTRING(b.kd_skpd,1,4)) end AS URAIANKELURUSAN,
CASE WHEN SUBSTRING(b.kd_skpd,6,2) is null then SUBSTRING(b.kd_skpd,6,2) else SUBSTRING(b.kd_skpd,6,2) end AS KDORG,
(select nm_org from ms_organisasi where kd_org=left(b.kd_skpd,7)) AS URAIANORG,
b.no_sp2d NOSP2D,
CASE WHEN a.kd_rek5='2130101' then '411121'
     WHEN a.kd_rek5='2130201' then '411122'
     WHEN a.kd_rek5='2130301' then '411211'
     WHEN a.kd_rek5='2130401' then '411124'
     WHEN a.kd_rek5='2130501' then '411128'
END AS KDPAJAK, 
a.nilai NILAIPAJAK,
b.no_nnt NTPN
FROM trdstrpot a JOIN trhstrpot b ON a.no_bukti = b.no_bukti and a.kd_skpd=b.kd_skpd
WHERE month(b.tgl_bukti)='$nbulan'
AND RTRIM(a.kd_rek5) IN $par_rek_pot
";

                $sql_query = $this->db->query($sql);              
				foreach ($sql_query->result_array() as $row) {
				$nilai  = strval($row['NILAIPAJAK']);
                $nilai  = str_replace(".00","",$nilai);
                if($nilai==''){
                    $nilai = 0;
                }
                        
                    $data = $row['TAHUN'].';'.$row['KDSATKER'].';'.$row['KDURUSAN'].';'.$row['KDKELURUSAN'].';'.$row['KDORG'].';'.$row['NOSP2D'].';'.$row['KDPAJAK'].';'.$nilai.';'.$row['NTPN']."\n";                                                      
                
                echo $data;                        
                header("Cache-Control: no-cache, no-store");                                
                header("Content-Type: application/csv");                
                header("Content-Disposition: attachement; filename=$filenamee.csv");                                 
                
                }
}    

   
}