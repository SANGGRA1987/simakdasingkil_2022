<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class service extends CI_Model{

     function api($tahun='',$pass='',$select=''){


         $data= array();

         switch ($select) {
             case 'total':
                 echo json_encode($this->total($tahun));  
                break;
             case 'akun':
                 echo json_encode($this->akun($tahun));  
                break;          
             case 'kelompok':
                 echo json_encode($this->kelompok($tahun));  
                break;
             case 'jenis':
                 echo json_encode($this->jenis($tahun));  
                break;  
             case 'objek':
                 echo json_encode($this->objek($tahun));  
                break;
             case 'ro':
                 echo json_encode($this->ro($tahun));  
                break;                  
             default:
                 $data[]=array('Respon'=>'Data tidak ditemukan');
                 echo json_encode($data);
                 break;
         }

     } 


    function total($tahun=''){
        $sql="SELECT left(a.kd_rek5,1) kd_rek5, sum(nilai_ubah) anggaran, isnull(sum(b.nilai),0) realisasi from simakda_$tahun.dbo.trdrka a left join (

                SELECT a.kd_skpd, a.kd_rek5, SUM (a.nilai) AS nilai FROM simakda_$tahun.dbo.trdtransout a
                JOIN simakda_$tahun.dbo.trhtransout b ON a.no_bukti = b.no_bukti AND a.kd_skpd = b.kd_skpd 
                WHERE jns_spp IN (1, 2, 3, 4, 5, 6) GROUP BY a.kd_skpd, a.kd_rek5
                
                UNION ALL
                
                SELECT a.kd_skpd, a.kd_rek5, SUM (a.nilai *- 1) AS nilai FROM simakda_$tahun.dbo.trdinlain a JOIN simakda_$tahun.dbo.trHINLAIN b 
                ON a.no_bukti = b.no_bukti AND a.kd_skpd = b.kd_skpd WHERE b.pengurang_belanja = 1 
                GROUP BY a.kd_skpd, a.kd_rek5
                    
                UNION ALL

                SELECT a.kd_skpd, a.kd_rek5, SUM (a.rupiah *- 1) AS nilai FROM simakda_$tahun.dbo.trdkasin_pkd a
                JOIN simakda_$tahun.dbo.trhkasin_pkd b ON a.no_sts = b.no_sts AND a.kd_skpd = b.kd_skpd
                WHERE b.jns_trans = 5 AND b.jns_cp IN (1) AND b.pot_khusus NOT IN ('0', '3')
                GROUP BY a.kd_skpd, a.kd_rek5

                UNION ALL
                SELECT a.kd_skpd, a.kd_rek5, SUM (a.rupiah *- 1) AS nilai FROM simakda_$tahun.dbo.trdkasin_pkd a
                JOIN simakda_$tahun.dbo.trhkasin_pkd b ON a.no_sts = b.no_sts AND a.kd_skpd = b.kd_skpd
                WHERE b.jns_trans = 5 AND b.jns_cp IN (2) GROUP BY a.kd_skpd, a.kd_rek5

                UNION ALL

                SELECT a.kd_skpd, a.kd_rek5, SUM (a.nilai) AS nilai
                FROM simakda_$tahun.dbo.trdtransout_blud a JOIN simakda_$tahun.dbo.trhtransout_blud b ON a.no_bukti = b.no_bukti
                AND a.kd_skpd = b.kd_skpd WHERE jns_spp IN (1, 2, 3, 4, 5, 6, 7)
                GROUP BY a.kd_skpd, a.kd_rek5

                ) b on a.kd_skpd=b.kd_skpd and a.kd_rek5=b.kd_rek5 where left(a.kd_rek5,1) <> 4
                GROUP BY left(a.kd_rek5,1) 

                UNION all 

                SELECT x.kd_rek,  x.nilai as anggaran, ISNULL(y.nilai,0) as realisasi FROM ( 
                SELECT a.kd_rek1 as kd_rek, a.lra as rek, a.nm_rek1 AS nm_rek ,SUM(b.nilai_ubah) AS nilai FROM ms_rek1 a 
                left join simakda_$tahun.dbo.trdrka b ON a.kd_rek1=LEFT(b.kd_rek5,(LEN(a.kd_rek1))) WHERE LEFT(a.kd_rek1,1)='4' 
                GROUP BY a.kd_rek1,a.lra, a.nm_rek1 ) x 
                LEFT JOIN (
                SELECT kd_rek,SUM(total) nilai FROM ( 
                select LEFT(kd_rek5,1) kd_rek, sum(nilai) total from simakda_$tahun.dbo.tr_terima where LEFT(kd_rek5,1)='4' AND MONTH(tgl_terima)<=12 
                group by LEFT(kd_rek5,1) 
                UNION ALL 
                SELECT LEFT(b.kd_rek5,1) kd_rek, sum(b.rupiah) total from simakda_$tahun.dbo.trhkasin_pkd a 
                inner join simakda_$tahun.dbo.trdkasin_pkd b on a.kd_skpd=b.kd_skpd and a.no_sts=b.no_sts where LEFT(kd_rek5,1)='4' and a.jns_trans='4'  AND kd_rek5<>'4141009' AND MONTH(tgl_sts)<=12 
                GROUP BY LEFT(kd_rek5,1) ) z 
                group by z.kd_rek ) y on x.kd_rek=y.kd_rek                 
                ";

        $exe=$this->db->query($sql);
        foreach($exe->result() as $a){
            $data[]=array(
                        'kd_rek5'     => $a->kd_rek5,
                        'anggaran'    => $a->anggaran,
                        'realisasi'     => $a->realisasi
            );
        }
        return $data;
    }

    function akun($tahun=''){
        $sql="SELECT left(a.kd_rek5,1) kd_rek5, sum(nilai_ubah) anggaran, isnull(sum(b.nilai),0) realisasi from simakda_$tahun.dbo.trdrka a left join (

                SELECT a.kd_skpd, a.kd_rek5, SUM (a.nilai) AS nilai FROM simakda_$tahun.dbo.trdtransout a
                JOIN simakda_$tahun.dbo.trhtransout b ON a.no_bukti = b.no_bukti AND a.kd_skpd = b.kd_skpd 
                WHERE jns_spp IN (1, 2, 3, 4, 5, 6) GROUP BY a.kd_skpd, a.kd_rek5
                
                UNION ALL
                
                SELECT a.kd_skpd, a.kd_rek5, SUM (a.nilai *- 1) AS nilai FROM simakda_$tahun.dbo.trdinlain a JOIN simakda_$tahun.dbo.trHINLAIN b 
                ON a.no_bukti = b.no_bukti AND a.kd_skpd = b.kd_skpd WHERE b.pengurang_belanja = 1 
                GROUP BY a.kd_skpd, a.kd_rek5
                    
                UNION ALL

                SELECT a.kd_skpd, a.kd_rek5, SUM (a.rupiah *- 1) AS nilai FROM simakda_$tahun.dbo.trdkasin_pkd a
                JOIN simakda_$tahun.dbo.trhkasin_pkd b ON a.no_sts = b.no_sts AND a.kd_skpd = b.kd_skpd
                WHERE b.jns_trans = 5 AND b.jns_cp IN (1) AND b.pot_khusus NOT IN ('0', '3')
                GROUP BY a.kd_skpd, a.kd_rek5

                UNION ALL
                SELECT a.kd_skpd, a.kd_rek5, SUM (a.rupiah *- 1) AS nilai FROM simakda_$tahun.dbo.trdkasin_pkd a
                JOIN simakda_$tahun.dbo.trhkasin_pkd b ON a.no_sts = b.no_sts AND a.kd_skpd = b.kd_skpd
                WHERE b.jns_trans = 5 AND b.jns_cp IN (2) GROUP BY a.kd_skpd, a.kd_rek5

                UNION ALL

                SELECT a.kd_skpd, a.kd_rek5, SUM (a.nilai) AS nilai
                FROM simakda_$tahun.dbo.trdtransout_blud a JOIN simakda_$tahun.dbo.trhtransout_blud b ON a.no_bukti = b.no_bukti
                AND a.kd_skpd = b.kd_skpd WHERE jns_spp IN (1, 2, 3, 4, 5, 6, 7)
                GROUP BY a.kd_skpd, a.kd_rek5

                ) b on a.kd_skpd=b.kd_skpd and a.kd_rek5=b.kd_rek5 where left(a.kd_rek5,1) <> 4
                GROUP BY left(a.kd_rek5,1) 

                UNION all 

                SELECT x.kd_rek,  x.nilai as anggaran, ISNULL(y.nilai,0) as realisasi FROM ( 
                SELECT a.kd_rek1 as kd_rek, a.lra as rek, a.nm_rek1 AS nm_rek ,SUM(b.nilai_ubah) AS nilai FROM ms_rek1 a 
                left join simakda_$tahun.dbo.trdrka b ON a.kd_rek1=LEFT(b.kd_rek5,(LEN(a.kd_rek1))) WHERE LEFT(a.kd_rek1,1)='4' 
                GROUP BY a.kd_rek1,a.lra, a.nm_rek1 ) x 
                LEFT JOIN (
                SELECT kd_rek,SUM(total) nilai FROM ( 
                select LEFT(kd_rek5,1) kd_rek, sum(nilai) total from simakda_$tahun.dbo.tr_terima where LEFT(kd_rek5,1)='4' AND MONTH(tgl_terima)<=12 
                group by LEFT(kd_rek5,1) 
                UNION ALL 
                SELECT LEFT(b.kd_rek5,1) kd_rek, sum(b.rupiah) total from simakda_$tahun.dbo.trhkasin_pkd a 
                inner join simakda_$tahun.dbo.trdkasin_pkd b on a.kd_skpd=b.kd_skpd and a.no_sts=b.no_sts where LEFT(kd_rek5,1)='4' and a.jns_trans='4'  AND kd_rek5<>'4141009' AND MONTH(tgl_sts)<=12 
                GROUP BY LEFT(kd_rek5,1) ) z 
                group by z.kd_rek ) y on x.kd_rek=y.kd_rek                 
                ";

        $exe=$this->db->query($sql);
        foreach($exe->result() as $a){
            $data[]=array(
                        'kd_rek5'     => $a->kd_rek5,
                        'anggaran'    => $a->anggaran,
                        'realisasi'     => $a->realisasi
            );
        }
        return $data;
   
    }

    function jenis($tahun=''){ /*rekening 2*/
        $sql="SELECT *, (select DISTINCT nm_rek2 from ms_rek2 where kd_rek2=left(yy.kd_rek5,2)) nm_rek from (

            SELECT left(a.kd_rek5,2) kd_rek5, sum(nilai_ubah) anggaran, isnull(sum(b.nilai),0) realisasi from simakda_$tahun.dbo.trdrka a left join (
                SELECT a.kd_skpd, a.kd_rek5, SUM (a.nilai) AS nilai FROM simakda_$tahun.dbo.trdtransout a
                JOIN simakda_$tahun.dbo.trhtransout b ON a.no_bukti = b.no_bukti AND a.kd_skpd = b.kd_skpd 
                WHERE jns_spp IN (1, 2, 3, 4, 5, 6) GROUP BY a.kd_skpd, a.kd_rek5
                
                UNION ALL
                
                SELECT a.kd_skpd, a.kd_rek5, SUM (a.nilai *- 1) AS nilai FROM simakda_$tahun.dbo.trdinlain a JOIN simakda_$tahun.dbo.trHINLAIN b 
                ON a.no_bukti = b.no_bukti AND a.kd_skpd = b.kd_skpd WHERE b.pengurang_belanja = 1 
                GROUP BY a.kd_skpd, a.kd_rek5
                    
                UNION ALL

                SELECT a.kd_skpd, a.kd_rek5, SUM (a.rupiah *- 1) AS nilai FROM simakda_$tahun.dbo.trdkasin_pkd a
                JOIN simakda_$tahun.dbo.trhkasin_pkd b ON a.no_sts = b.no_sts AND a.kd_skpd = b.kd_skpd
                WHERE b.jns_trans = 5 AND b.jns_cp IN (1) AND b.pot_khusus NOT IN ('0', '3')
                GROUP BY a.kd_skpd, a.kd_rek5

                UNION ALL
                SELECT a.kd_skpd, a.kd_rek5, SUM (a.rupiah *- 1) AS nilai FROM simakda_$tahun.dbo.trdkasin_pkd a
                JOIN simakda_$tahun.dbo.trhkasin_pkd b ON a.no_sts = b.no_sts AND a.kd_skpd = b.kd_skpd
                WHERE b.jns_trans = 5 AND b.jns_cp IN (2) GROUP BY a.kd_skpd, a.kd_rek5

                UNION ALL

                SELECT a.kd_skpd, a.kd_rek5, SUM (a.nilai) AS nilai
                FROM simakda_$tahun.dbo.trdtransout_blud a JOIN simakda_$tahun.dbo.trhtransout_blud b ON a.no_bukti = b.no_bukti
                AND a.kd_skpd = b.kd_skpd WHERE jns_spp IN (1, 2, 3, 4, 5, 6, 7)
                GROUP BY a.kd_skpd, a.kd_rek5

                ) b on a.kd_skpd=b.kd_skpd and a.kd_rek5=b.kd_rek5 where left(a.kd_rek5,1) <> 4
                GROUP BY left(a.kd_rek5,2) 

                UNION all 
                select left(kd_rek,2) kd_rek, sum(anggaran) anggaran, sum(realisasi) realisasi from (
                SELECT x.kd_rek,  x.nilai as anggaran, ISNULL(y.nilai,0) as realisasi FROM ( 
                                    SELECT a.kd_rek5 as kd_rek, SUM(a.nilai_ubah) AS nilai FROM simakda_$tahun.dbo.trdrka a  WHERE LEFT(a.kd_rek5,1)='4' 
                                    GROUP BY a.kd_rek5) x 
                                    LEFT JOIN (
                                        SELECT kd_rek,SUM(total) nilai FROM ( 
                                            select kd_rek5 kd_rek, sum(nilai) total from simakda_$tahun.dbo.tr_terima where LEFT(kd_rek5,1)='4' AND MONTH(tgl_terima)<=12
                                            group by kd_rek5
                                            UNION ALL 
                                            SELECT b.kd_rek5 kd_rek, sum(b.rupiah) total from simakda_$tahun.dbo.trhkasin_pkd a 
                                            inner join simakda_$tahun.dbo.trdkasin_pkd b on a.kd_skpd=b.kd_skpd and a.no_sts=b.no_sts where LEFT(kd_rek5,1)='4' and a.jns_trans='4'  AND kd_rek5<>'4141009' AND MONTH(tgl_sts)<=12 
                                            GROUP BY kd_rek5 ) z 
                                        group by z.kd_rek 
                                    ) y on x.kd_rek=y.kd_rek) xx GROUP BY left(kd_rek,2)

)yy ORDER BY kd_rek5

                ";

        $exe=$this->db->query($sql);
        foreach($exe->result() as $a){
            $data[]=array(
                        'kd_rek'     => $a->kd_rek5,
                        'nm_rek'     => $a->nm_rek,
                        'anggaran'    => $a->anggaran,
                        'realisasi'     => $a->realisasi
            );
        }
        return $data;
   
    }

    function kelompok($tahun=''){ /*rekening 3*/
        $sql="SELECT *, (select DISTINCT nm_rek3 from ms_rek3 where kd_rek3=left(yy.kd_rek5,3)) nm_rek from (

            SELECT left(a.kd_rek5,3) kd_rek5, sum(nilai_ubah) anggaran, isnull(sum(b.nilai),0) realisasi from simakda_$tahun.dbo.trdrka a left join (
                SELECT a.kd_skpd, a.kd_rek5, SUM (a.nilai) AS nilai FROM simakda_$tahun.dbo.trdtransout a
                JOIN simakda_$tahun.dbo.trhtransout b ON a.no_bukti = b.no_bukti AND a.kd_skpd = b.kd_skpd 
                WHERE jns_spp IN (1, 2, 3, 4, 5, 6) GROUP BY a.kd_skpd, a.kd_rek5
                
                UNION ALL
                
                SELECT a.kd_skpd, a.kd_rek5, SUM (a.nilai *- 1) AS nilai FROM simakda_$tahun.dbo.trdinlain a JOIN simakda_$tahun.dbo.trHINLAIN b 
                ON a.no_bukti = b.no_bukti AND a.kd_skpd = b.kd_skpd WHERE b.pengurang_belanja = 1 
                GROUP BY a.kd_skpd, a.kd_rek5
                    
                UNION ALL

                SELECT a.kd_skpd, a.kd_rek5, SUM (a.rupiah *- 1) AS nilai FROM simakda_$tahun.dbo.trdkasin_pkd a
                JOIN simakda_$tahun.dbo.trhkasin_pkd b ON a.no_sts = b.no_sts AND a.kd_skpd = b.kd_skpd
                WHERE b.jns_trans = 5 AND b.jns_cp IN (1) AND b.pot_khusus NOT IN ('0', '3')
                GROUP BY a.kd_skpd, a.kd_rek5

                UNION ALL
                SELECT a.kd_skpd, a.kd_rek5, SUM (a.rupiah *- 1) AS nilai FROM simakda_$tahun.dbo.trdkasin_pkd a
                JOIN simakda_$tahun.dbo.trhkasin_pkd b ON a.no_sts = b.no_sts AND a.kd_skpd = b.kd_skpd
                WHERE b.jns_trans = 5 AND b.jns_cp IN (2) GROUP BY a.kd_skpd, a.kd_rek5

                UNION ALL

                SELECT a.kd_skpd, a.kd_rek5, SUM (a.nilai) AS nilai
                FROM simakda_$tahun.dbo.trdtransout_blud a JOIN simakda_$tahun.dbo.trhtransout_blud b ON a.no_bukti = b.no_bukti
                AND a.kd_skpd = b.kd_skpd WHERE jns_spp IN (1, 2, 3, 4, 5, 6, 7)
                GROUP BY a.kd_skpd, a.kd_rek5

                ) b on a.kd_skpd=b.kd_skpd and a.kd_rek5=b.kd_rek5 where left(a.kd_rek5,1) <> 4
                GROUP BY left(a.kd_rek5,3) 

                UNION all 
                select left(kd_rek,3) kd_rek, sum(anggaran) anggaran, sum(realisasi) realisasi from (
                SELECT x.kd_rek,  x.nilai as anggaran, ISNULL(y.nilai,0) as realisasi FROM ( 
                                    SELECT a.kd_rek5 as kd_rek, SUM(a.nilai_ubah) AS nilai FROM simakda_$tahun.dbo.trdrka a  WHERE LEFT(a.kd_rek5,1)='4' 
                                    GROUP BY a.kd_rek5) x 
                                    LEFT JOIN (
                                        SELECT kd_rek,SUM(total) nilai FROM ( 
                                            select kd_rek5 kd_rek, sum(nilai) total from simakda_$tahun.dbo.tr_terima where LEFT(kd_rek5,1)='4' AND MONTH(tgl_terima)<=12
                                            group by kd_rek5
                                            UNION ALL 
                                            SELECT b.kd_rek5 kd_rek, sum(b.rupiah) total from simakda_$tahun.dbo.trhkasin_pkd a 
                                            inner join simakda_$tahun.dbo.trdkasin_pkd b on a.kd_skpd=b.kd_skpd and a.no_sts=b.no_sts where LEFT(kd_rek5,1)='4' and a.jns_trans='4'  AND kd_rek5<>'4141009' AND MONTH(tgl_sts)<=12 
                                            GROUP BY kd_rek5 ) z 
                                        group by z.kd_rek 
                                    ) y on x.kd_rek=y.kd_rek) xx GROUP BY left(kd_rek,3)

)yy ORDER BY kd_rek5

                ";

        $exe=$this->db->query($sql);
        foreach($exe->result() as $a){
            $data[]=array(
                        'kd_rek'     => $a->kd_rek5,
                        'nm_rek'     => $a->nm_rek,
                        'anggaran'    => $a->anggaran,
                        'realisasi'     => $a->realisasi
            );
        }
        return $data;
   
    }



    function objek($tahun=''){ /*rekening 4*/
        $sql="SELECT *, (select DISTINCT nm_rek4 from ms_rek4 where kd_rek4=left(yy.kd_rek5,5)) nm_rek from (

            SELECT left(a.kd_rek5,5) kd_rek5, sum(nilai_ubah) anggaran, isnull(sum(b.nilai),0) realisasi from simakda_$tahun.dbo.trdrka a left join (
                SELECT a.kd_skpd, a.kd_rek5, SUM (a.nilai) AS nilai FROM simakda_$tahun.dbo.trdtransout a
                JOIN simakda_$tahun.dbo.trhtransout b ON a.no_bukti = b.no_bukti AND a.kd_skpd = b.kd_skpd 
                WHERE jns_spp IN (1, 2, 3, 4, 5, 6) GROUP BY a.kd_skpd, a.kd_rek5
                
                UNION ALL
                
                SELECT a.kd_skpd, a.kd_rek5, SUM (a.nilai *- 1) AS nilai FROM simakda_$tahun.dbo.trdinlain a JOIN simakda_$tahun.dbo.trHINLAIN b 
                ON a.no_bukti = b.no_bukti AND a.kd_skpd = b.kd_skpd WHERE b.pengurang_belanja = 1 
                GROUP BY a.kd_skpd, a.kd_rek5
                    
                UNION ALL

                SELECT a.kd_skpd, a.kd_rek5, SUM (a.rupiah *- 1) AS nilai FROM simakda_$tahun.dbo.trdkasin_pkd a
                JOIN simakda_$tahun.dbo.trhkasin_pkd b ON a.no_sts = b.no_sts AND a.kd_skpd = b.kd_skpd
                WHERE b.jns_trans = 5 AND b.jns_cp IN (1) AND b.pot_khusus NOT IN ('0', '3')
                GROUP BY a.kd_skpd, a.kd_rek5

                UNION ALL
                SELECT a.kd_skpd, a.kd_rek5, SUM (a.rupiah *- 1) AS nilai FROM simakda_$tahun.dbo.trdkasin_pkd a
                JOIN simakda_$tahun.dbo.trhkasin_pkd b ON a.no_sts = b.no_sts AND a.kd_skpd = b.kd_skpd
                WHERE b.jns_trans = 5 AND b.jns_cp IN (2) GROUP BY a.kd_skpd, a.kd_rek5

                UNION ALL

                SELECT a.kd_skpd, a.kd_rek5, SUM (a.nilai) AS nilai
                FROM simakda_$tahun.dbo.trdtransout_blud a JOIN simakda_$tahun.dbo.trhtransout_blud b ON a.no_bukti = b.no_bukti
                AND a.kd_skpd = b.kd_skpd WHERE jns_spp IN (1, 2, 3, 4, 5, 6, 7)
                GROUP BY a.kd_skpd, a.kd_rek5

                ) b on a.kd_skpd=b.kd_skpd and a.kd_rek5=b.kd_rek5 where left(a.kd_rek5,1) <> 4
                GROUP BY left(a.kd_rek5,5) 

                UNION all 
                                select left(kd_rek,5) kd_rek, sum(anggaran) anggaran, sum(realisasi) realisasi from (
                SELECT x.kd_rek,  x.nilai as anggaran, ISNULL(y.nilai,0) as realisasi FROM ( 
                                    SELECT a.kd_rek5 as kd_rek, SUM(a.nilai_ubah) AS nilai FROM simakda_$tahun.dbo.trdrka a  WHERE LEFT(a.kd_rek5,1)='4' 
                                    GROUP BY a.kd_rek5) x 
                                    LEFT JOIN (
                                        SELECT kd_rek,SUM(total) nilai FROM ( 
                                            select kd_rek5 kd_rek, sum(nilai) total from simakda_$tahun.dbo.tr_terima where LEFT(kd_rek5,1)='4' AND MONTH(tgl_terima)<=12
                                            group by kd_rek5
                                            UNION ALL 
                                            SELECT b.kd_rek5 kd_rek, sum(b.rupiah) total from simakda_$tahun.dbo.trhkasin_pkd a 
                                            inner join simakda_$tahun.dbo.trdkasin_pkd b on a.kd_skpd=b.kd_skpd and a.no_sts=b.no_sts where LEFT(kd_rek5,1)='4' and a.jns_trans='4'  AND kd_rek5<>'4141009' AND MONTH(tgl_sts)<=12 
                                            GROUP BY kd_rek5 ) z 
                                        group by z.kd_rek 
                                    ) y on x.kd_rek=y.kd_rek) xx GROUP BY left(kd_rek,5)

)yy ORDER BY kd_rek5

                ";

        $exe=$this->db->query($sql);
        foreach($exe->result() as $a){
            $data[]=array(
                        'kd_rek'     => $a->kd_rek5,
                        'nm_rek'     => $a->nm_rek,
                        'anggaran'    => $a->anggaran,
                        'realisasi'     => $a->realisasi
            );
        }
        return $data;
   
    }



    function ro($tahun=''){ /*rekening 5*/
        $sql="SELECT *, (select DISTINCT nm_rek5 from ms_rek5 where kd_rek5=yy.kd_rek5) nm_rek from (

            SELECT left(a.kd_rek5,7) kd_rek5, sum(nilai_ubah) anggaran, isnull(sum(b.nilai),0) realisasi from simakda_$tahun.dbo.trdrka a left join (
                SELECT a.kd_skpd, a.kd_rek5, SUM (a.nilai) AS nilai FROM simakda_$tahun.dbo.trdtransout a
                JOIN simakda_$tahun.dbo.trhtransout b ON a.no_bukti = b.no_bukti AND a.kd_skpd = b.kd_skpd 
                WHERE jns_spp IN (1, 2, 3, 4, 5, 6) GROUP BY a.kd_skpd, a.kd_rek5
                
                UNION ALL
                
                SELECT a.kd_skpd, a.kd_rek5, SUM (a.nilai *- 1) AS nilai FROM simakda_$tahun.dbo.trdinlain a JOIN simakda_$tahun.dbo.trHINLAIN b 
                ON a.no_bukti = b.no_bukti AND a.kd_skpd = b.kd_skpd WHERE b.pengurang_belanja = 1 
                GROUP BY a.kd_skpd, a.kd_rek5
                    
                UNION ALL

                SELECT a.kd_skpd, a.kd_rek5, SUM (a.rupiah *- 1) AS nilai FROM simakda_$tahun.dbo.trdkasin_pkd a
                JOIN simakda_$tahun.dbo.trhkasin_pkd b ON a.no_sts = b.no_sts AND a.kd_skpd = b.kd_skpd
                WHERE b.jns_trans = 5 AND b.jns_cp IN (1) AND b.pot_khusus NOT IN ('0', '3')
                GROUP BY a.kd_skpd, a.kd_rek5

                UNION ALL
                SELECT a.kd_skpd, a.kd_rek5, SUM (a.rupiah *- 1) AS nilai FROM simakda_$tahun.dbo.trdkasin_pkd a
                JOIN simakda_$tahun.dbo.trhkasin_pkd b ON a.no_sts = b.no_sts AND a.kd_skpd = b.kd_skpd
                WHERE b.jns_trans = 5 AND b.jns_cp IN (2) GROUP BY a.kd_skpd, a.kd_rek5

                UNION ALL

                SELECT a.kd_skpd, a.kd_rek5, SUM (a.nilai) AS nilai
                FROM simakda_$tahun.dbo.trdtransout_blud a JOIN simakda_$tahun.dbo.trhtransout_blud b ON a.no_bukti = b.no_bukti
                AND a.kd_skpd = b.kd_skpd WHERE jns_spp IN (1, 2, 3, 4, 5, 6, 7)
                GROUP BY a.kd_skpd, a.kd_rek5

                ) b on a.kd_skpd=b.kd_skpd and a.kd_rek5=b.kd_rek5 where left(a.kd_rek5,1) <> 4
                GROUP BY left(a.kd_rek5,7) 

                UNION all 
                                select left(kd_rek,7) kd_rek, sum(anggaran) anggaran, sum(realisasi) realisasi from (
                SELECT x.kd_rek,  x.nilai as anggaran, ISNULL(y.nilai,0) as realisasi FROM ( 
                                    SELECT a.kd_rek5 as kd_rek, SUM(a.nilai_ubah) AS nilai FROM simakda_$tahun.dbo.trdrka a  WHERE LEFT(a.kd_rek5,1)='4' 
                                    GROUP BY a.kd_rek5) x 
                                    LEFT JOIN (
                                        SELECT kd_rek,SUM(total) nilai FROM ( 
                                            select kd_rek5 kd_rek, sum(nilai) total from simakda_$tahun.dbo.tr_terima where LEFT(kd_rek5,1)='4' AND MONTH(tgl_terima)<=12
                                            group by kd_rek5
                                            UNION ALL 
                                            SELECT b.kd_rek5 kd_rek, sum(b.rupiah) total from simakda_$tahun.dbo.trhkasin_pkd a 
                                            inner join simakda_$tahun.dbo.trdkasin_pkd b on a.kd_skpd=b.kd_skpd and a.no_sts=b.no_sts where LEFT(kd_rek5,1)='4' and a.jns_trans='4'  AND kd_rek5<>'4141009' AND MONTH(tgl_sts)<=12 
                                            GROUP BY kd_rek5 ) z 
                                        group by z.kd_rek 
                                    ) y on x.kd_rek=y.kd_rek) xx GROUP BY left(kd_rek,7)

)yy ORDER BY kd_rek5

                ";

        $exe=$this->db->query($sql);
        foreach($exe->result() as $a){
            $data[]=array(
                        'kd_rek'     => $a->kd_rek5,
                        'nm_rek'     => $a->nm_rek,
                        'anggaran'    => $a->anggaran,
                        'realisasi'     => $a->realisasi
            );
        }
        return $data;
   
    }





}