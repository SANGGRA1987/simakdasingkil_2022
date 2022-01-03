<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Fungsi Model
 */ 

class angkas_ro_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
  
    function load_giat($skpd,$lccr) {

        /*untuk kunci gaji*/
        $tipe = $this->session->userdata('type');
        if($tipe==1){
            $status="";
        }else{
            $status="and status_keg='1'";
        }

        $sql = "SELECT a.kd_skpd,a.kd_subkegiatan,a.nm_subkegiatan,a.kd_program,a.nm_program,
        		(SELECT SUM(nilai)  FROM trdrka WHERE kd_subkegiatan=a.kd_subkegiatan and kd_skpd='$skpd')AS total,
                (SELECT SUM(nilai_sempurna)  FROM trdrka WHERE kd_subkegiatan=a.kd_subkegiatan and kd_skpd='$skpd')AS total_sempurna,
                (SELECT SUM(nilai_ubah)  FROM trdrka WHERE kd_subkegiatan=a.kd_subkegiatan and kd_skpd='$skpd')AS total_ubah FROM trskpd a  
                WHERE left(kd_skpd,20)=left('$skpd',20) $status AND (UPPER(kd_subkegiatan) LIKE UPPER('%$lccr%') OR UPPER(nm_subkegiatan) LIKE UPPER('%$lccr%')) order by a.kd_subkegiatan";                                              
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;        
        foreach($query1->result_array() as $resulte) {     
            $result[] = array(
                        'id' => $ii,        
                        'kd_kegiatan' => $resulte['kd_subkegiatan'],  
                        'kd_skpd' => $resulte['kd_skpd'],
                        'nm_kegiatan' => $resulte['nm_subkegiatan'],
                        'kd_program' => $resulte['kd_program'],  
                        'nm_program' => $resulte['nm_program'],
                        'total'       => number_format($resulte['total'],"2",".",","),
                        'total_sempurna'       => number_format($resulte['total_sempurna'],"2",".",","),
                        'total_ubah'  => number_format($resulte['total_ubah'],"2",".",",")   
                        );
                        $ii++;
        }            
        return $result;
           
    }


    function total_triwulan($status,$kd_subkegiatan,$skpd){ /*nilai angkas per triwulan*/
        $sqlx="SELECT kd_subkegiatan, sum(tw1) tw1, sum(tw2) tw2, sum(tw3) tw3, sum(tw4) tw4 from (
                select kd_subkegiatan,
                case when bulan BETWEEN 1 and 3 THEN sum(nilai) end as tw1,
                case when bulan BETWEEN 4 and 6 THEN sum(nilai) end as tw2,
                case when bulan BETWEEN 7 and 9 THEN sum(nilai) end as tw3,
                case when bulan BETWEEN 10 and 12 THEN sum(nilai) end as tw4
                from (
                select kd_skpd, kd_subkegiatan, bulan, sum($status) nilai from trdskpd_ro 
                GROUP BY kd_skpd,kd_subkegiatan, bulan)xx 
                WHERE kd_subkegiatan='$kd_subkegiatan' and kd_skpd='$skpd'
                GROUP BY kd_subkegiatan, bulan) yy GROUP BY kd_subkegiatan";
            $sql=$this->db->query($sqlx);

            $result = array();
            $ii = 0;
            foreach($sql->result_array() as $resulte)
            { 
                $result[] = array(
                                'id' => $ii,    
                                'kegiatan_kd' => $resulte['kd_subkegiatan'],    
                                'tw1' => number_format($resulte['tw1'],2,'.',','),                                              
                                'tw2' => number_format($resulte['tw2'],2,'.',','),                                             
                                'tw3' => number_format($resulte['tw3'],2,'.',','),                                            
                                'tw4' => number_format($resulte['tw4'],2,'.',',')                                              
                            );
                            $ii++;
            }
           
            return $result;

    }




    function load_trdskpd($kd_subkegiatan,$rekening,$status,$skpd){
        $sql = "SELECT bulan, $status nilai from trdskpd_ro where kd_skpd='$skpd' and kd_subkegiatan='$kd_subkegiatan' and kd_rek6='$rekening' order by bulan";
         $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 1;
        foreach($query1->result_array() as $resulte)
        {   
            $result[] = array(
                        'id' => $ii,        
                        'bulan' => $resulte['bulan'],
                        'nilai' => number_format($resulte['nilai'],2,'.',',')                                                              
                        );
                        $ii++;
        }     
        return $result;
   }


	function ambil_rek_angkas_ro($kegiatan,$skpd) {
        $sql = "SELECT x.kd_rek6,(select nm_rek6 from ms_rek6 where kd_rek6=x.kd_rek6) nm_rek5, 
                sum(nilai) nilai,sum(n_ro) n_ro,sum(nilai)-sum(n_ro)s_n_ro,
                sum(nilai_sempurna)nilai_sempurna,sum(ns_ro) ns_ro,sum(nilai_sempurna)-sum(ns_ro) as s_ns_ro,
                sum(nilai_ubah) nilai_ubah,sum(nu_ro) nu_ro,sum(nilai_ubah)-sum(nu_ro) s_nu_ro from(
                select kd_rek6, nilai,0 as n_ro,nilai_sempurna,0 as ns_ro,nilai_ubah,0 as nu_ro
                from trdrka where kd_subkegiatan ='$kegiatan' and kd_skpd='$skpd'
                union all
                select kd_rek6, 0 as nilai,sum(nilai) as n_ro,0 as nilai_sempurna,sum(nilai_sempurna) as ns_ro,
                0 as nilai_ubah,sum(nilai_ubah) as nu_ro
                from trdskpd_ro where kd_subkegiatan ='$kegiatan' and kd_skpd='$skpd'
                group by kd_rek6
                )x
                group by x.kd_rek6";                   
        
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte) {
            $result[] = array(
                        'id' => $ii,        
                        'kd_rek5' => $resulte['kd_rek6'],  
                        'nm_rek5' => $resulte['nm_rek5'],  
                        'nilai' => number_format($resulte['nilai'],"2",".",","),					/*nilai trdrka*/
                        'nilai_sempurna' => number_format($resulte['nilai_sempurna'],"2",".",","),	/*nilai geser trdrka*/
                        'nilai_ubah' => number_format($resulte['nilai_ubah'],"2",".",","),  	    /*nilai ubah trdrka*/                       
                        'n_ro' => number_format($resulte['n_ro'],"2",".",","),		 /*nilai angkas*/ 
                        'ns_ro' => number_format($resulte['ns_ro'],"2",".",","),	 /*nilai geser angkas*/
                        'nu_ro' => number_format($resulte['nu_ro'],"2",".",","),	 /*nilai ubah angkas*/
                        's_n_ro' => number_format($resulte['s_n_ro'],"2",".",","),	 /*selisih nilai murni*/
                        's_ns_ro' => number_format($resulte['s_ns_ro'],"2",".",","), /*selisih nilai geser*/
                        's_nu_ro' => number_format($resulte['s_nu_ro'],"2",".",",")  /*selisih nilai ubah*/                              

                        );
                        $ii++;
        }  
        return $result;

    }

   function simpan_trskpd_ro($cskpda,$status,$cskpd,$cskpd,$csubgiat,$crek5,$bln1,$bln2,$bln3,$bln4,$bln5,$bln6,$bln7,$bln8,$bln9,$bln10,$bln11,$bln12,$tr1,$tr2,$tr3,$tr4,$status,$user_name){
        $id  = $this->session->userdata('pcUser');
        $tabell = 'trdskpd_ro';
        $query_find = $this->db->query("SELECT * from $tabell where kd_skpd='$cskpd' and kd_subkegiatan='$csubgiat' and kd_rek6='$crek5'");
        $update = $query_find->num_rows();

       if($update > 0){    
                $kdGab = $cskpda.'.'.$csubgiat;

                for ($x = 1; $x <= 12; $x++) {
                    $bulan="bln$x";
                    switch ($status) {
                    	case 'murni':
                    				 $sql1 = "UPDATE $tabell set nilai='{$$bulan}',nilai_susun='{$$bulan}',nilai_sempurna='{$$bulan}',nilai_ubah={$$bulan} where kd_gabungan='$kdGab' and kd_rek6='$crek5' and bulan=$x";
                    		break;
                    	case 'geser':
                    				 $sql1 = "UPDATE $tabell set nilai_sempurna='{$$bulan}',nilai_ubah={$$bulan} where kd_gabungan='$kdGab' and kd_rek6='$crek5' and bulan=$x";
                    		break;
                    	case 'ubah':
                    				 $sql1 = "UPDATE $tabell set nilai_ubah={$$bulan} where kd_gabungan='$kdGab' and kd_rek6='$crek5' and bulan=$x";
                    		break;                    		
                    }
                    $asg = $this->db->query($sql1);
                }

                $sqltrskpd = " UPDATE trskpd set triw1=
                                (select sum(nilai) from trdskpd_ro where bulan in ('1','2','3') and kd_gabungan ='$kdGab' group by kd_gabungan),
                                triw1_sempurna=
                                (select sum(nilai_sempurna) from trdskpd_ro where bulan in ('1','2','3') and kd_gabungan ='$kdGab' group by kd_gabungan),
                                triw1_ubah=
                                (select sum(nilai_ubah) from trdskpd_ro where bulan in ('1','2','3') and kd_gabungan ='$kdGab' group by kd_gabungan),
                                triw2=
                                (select sum(nilai) from trdskpd_ro where bulan in ('4','5','6') and kd_gabungan ='$kdGab' group by kd_gabungan),
                                triw2_sempurna=
                                (select sum(nilai_sempurna) from trdskpd_ro where bulan in ('4','5','6') and kd_gabungan ='$kdGab' group by kd_gabungan),
                                triw2_ubah=
                                (select sum(nilai_ubah) from trdskpd_ro where bulan in ('4','5','6') and kd_gabungan ='$kdGab' group by kd_gabungan),
                                triw3=
                                (select sum(nilai) from trdskpd_ro where bulan in ('7','8','9') and kd_gabungan ='$kdGab' group by kd_gabungan),
                                triw3_sempurna=
                                (select sum(nilai_sempurna) from trdskpd_ro where bulan in ('7','8','9') and kd_gabungan ='$kdGab' group by kd_gabungan),
                                triw3_ubah=
                                (select sum(nilai_ubah) from trdskpd_ro where bulan in ('7','8','9') and kd_gabungan ='$kdGab' group by kd_gabungan),
                                triw4=
                                (select sum(nilai_ubah) from trdskpd_ro where bulan in ('10','11','12') and kd_gabungan ='$kdGab' group by kd_gabungan),
                                triw4_sempurna=
                                (select sum(nilai_sempurna) from trdskpd_ro where bulan in ('10','11','12') and kd_gabungan ='$kdGab' group by kd_gabungan),
                                triw4_ubah=
                                (select sum(nilai_ubah) from trdskpd_ro where bulan in ('10','11','12') and kd_gabungan ='$kdGab' group by kd_gabungan),
                                total_ubah=(select sum(nilai_ubah) from trdskpd_ro where kd_gabungan ='$kdGab' group by kd_gabungan),last_update=getdate(),username1='$id'
                                where kd_gabungan ='$kdGab'  ";
                $asg = $this->db->query($sqltrskpd);

                return '1';                            
        }else{
            $sql = "delete from $tabell where kd_skpd='$cskpd' and kd_subkegiatan='$csubgiat' and kd_rek6='$crek5'";
            $asg = $this->db->query($sql);
            if ($asg){                           
                $kdGab = $cskpd.'.'.$csubgiat;
				$cgiat=substr($csubgiat,0,12);	

                for ($x = 1; $x <= 12; $x++) {
                    $bulan="bln$x";
                    switch ($status) {
						case 'murni':
                    					$sql1 = "INSERT into $tabell values('$kdGab','$cgiat','$cskpd','$crek5',$x,{$$bulan},{$$bulan},{$$bulan},{$$bulan},'1','$csubgiat','','',0) ";                                        		# code...
							break;

						case 'geser':
                    					$sql1 = "INSERT into $tabell values('$kdGab','$cgiat','$cskpd','$crek5','$x','0','0','{$$bulan}','{$$bulan}','1','$csubgiat','','') ";                                        		# code...
							break;

						case 'ubah':
                    					$sql1 = "INSERT into $tabell values('$kdGab','$cgiat','$cskpd','$crek5','$x','0','0','0','{$$bulan}','1','$csubgiat','','') ";                                        		# code...
							break;							
                    }                    
                    $asg = $this->db->query($sql1); 
                }
   

                 $sqltrskpd = " UPDATE trskpd set triw1=
                                (select sum(nilai) from trdskpd_ro where bulan in ('1','2','3') and kd_gabungan ='$kdGab' group by kd_gabungan),
                                triw1_sempurna=
                                (select sum(nilai_sempurna) from trdskpd_ro where bulan in ('1','2','3') and kd_gabungan ='$kdGab' group by kd_gabungan),
                                triw1_ubah=
                                (select sum(nilai_ubah) from trdskpd_ro where bulan in ('1','2','3') and kd_gabungan ='$kdGab' group by kd_gabungan),
                                triw2=
                                (select sum(nilai) from trdskpd_ro where bulan in ('4','5','6') and kd_gabungan ='$kdGab' group by kd_gabungan),
                                triw2_sempurna=
                                (select sum(nilai_sempurna) from trdskpd_ro where bulan in ('4','5','6') and kd_gabungan ='$kdGab' group by kd_gabungan),
                                triw2_ubah=
                                (select sum(nilai_ubah) from trdskpd_ro where bulan in ('4','5','6') and kd_gabungan ='$kdGab' group by kd_gabungan),
                                triw3=
                                (select sum(nilai) from trdskpd_ro where bulan in ('7','8','9') and kd_gabungan ='$kdGab' group by kd_gabungan),
                                triw3_sempurna=
                                (select sum(nilai_sempurna) from trdskpd_ro where bulan in ('7','8','9') and kd_gabungan ='$kdGab' group by kd_gabungan),
                                triw3_ubah=
                                (select sum(nilai_ubah) from trdskpd_ro where bulan in ('7','8','9') and kd_gabungan ='$kdGab' group by kd_gabungan),
                                triw4=
                                (select sum(nilai_ubah) from trdskpd_ro where bulan in ('10','11','12') and kd_gabungan ='$kdGab' group by kd_gabungan),
                                triw4_sempurna=
                                (select sum(nilai_sempurna) from trdskpd_ro where bulan in ('10','11','12') and kd_gabungan ='$kdGab' group by kd_gabungan),
                                triw4_ubah=
                                (select sum(nilai_ubah) from trdskpd_ro where bulan in ('10','11','12') and kd_gabungan ='$kdGab' group by kd_gabungan),
                                total_ubah=(select sum(nilai_ubah) from trdskpd_ro where kd_gabungan ='$kdGab' group by kd_gabungan), last_update=getdate(),username1=$id
                                where kd_gabungan ='$kdGab' ";
                $asg = $this->db->query($sqltrskpd); 

                return '1';
            } else {
                return '0';
                exit();
            }
        }
    } 

    function realisasi_angkas_ro($skpd,$kegiatan,$rek5){

        $sql="SELECT SUM(CASE WHEN awal >='1' and akhir <= '3' then nilai ELSE 0 END) as triw1,
                    SUM(CASE WHEN awal >='4' and akhir <= '6' then nilai ELSE 0 END) as triw2,
                    SUM(CASE WHEN awal >='7' and akhir <= '9' then nilai ELSE 0 END) as triw3,
                    SUM(CASE WHEN awal >='10' and akhir <= '12' then nilai ELSE 0 END) as triw4
                     FROM 
                    (
                    select '1' as awal, '3' as akhir,left(b.kd_skpd,17)+'.0000' as kd_skpd,b.kd_rek6,a.kd_subkegiatan,sum(b.nilai) as nilai from trdrka a 
                    left join trdtransout b on b.kd_skpd = a.kd_skpd and b.kd_rek6 = a.kd_rek6 and b.kd_subkegiatan = a.kd_subkegiatan
                    left join trhsp2d c on c.no_sp2d = b.no_sp2d
                    left join trhtransout d on d.kd_skpd = b.kd_skpd and b.no_bukti = d.no_bukti
                    where month(d.tgl_bukti) in ('1','2','3') and b.kd_subkegiatan ='$kegiatan' and left(a.kd_skpd,17) =left('$skpd',17) and b.kd_rek6='$rek5'
                    group by left(b.kd_skpd,17),b.kd_rek6,a.kd_subkegiatan
                    union
                    select '4' as awal, '6' as akhir,left(b.kd_skpd,17)+'.0000' as kd_skpd,b.kd_rek6,a.kd_subkegiatan,sum(b.nilai) as nilai from trdrka a 
                    left join trdtransout b on b.kd_skpd = a.kd_skpd and b.kd_rek6 = a.kd_rek6 and b.kd_subkegiatan = a.kd_subkegiatan
                    left join trhsp2d c on c.no_sp2d = b.no_sp2d
                    left join trhtransout d on d.kd_skpd = b.kd_skpd and b.no_bukti = d.no_bukti
                    where month(d.tgl_bukti) in ('4','5','6') and b.kd_subkegiatan ='$kegiatan' and left(a.kd_skpd,17) =left('$skpd',17) and b.kd_rek6='$rek5'
                    group by left(b.kd_skpd,17),b.kd_rek6,a.kd_subkegiatan
                    union
                    select '7' as awal, '9' as akhir,left(b.kd_skpd,17)+'.0000' as kd_skpd,b.kd_rek6,a.kd_subkegiatan,sum(b.nilai) as nilai from trdrka a 
                    left join trdtransout b on b.kd_skpd = a.kd_skpd and b.kd_rek6 = a.kd_rek6 and b.kd_subkegiatan = a.kd_subkegiatan
                    left join trhsp2d c on c.no_sp2d = b.no_sp2d
                    left join trhtransout d on d.kd_skpd = b.kd_skpd and b.no_bukti = d.no_bukti
                    where month(d.tgl_bukti) in ('7','8','9') and b.kd_subkegiatan ='$kegiatan' and left(a.kd_skpd,17) =left('$skpd',17) and b.kd_rek6='$rek5'
                    group by left(b.kd_skpd,17),b.kd_rek6,a.kd_subkegiatan
                    union
                    select '10' as awal, '12' as akhir,left(b.kd_skpd,17)+'.0000' as kd_skpd,b.kd_rek6,a.kd_subkegiatan,sum(b.nilai) as nilai from trdrka a 
                    left join trdtransout b on b.kd_skpd = a.kd_skpd and b.kd_rek6 = a.kd_rek6 and b.kd_subkegiatan = a.kd_subkegiatan
                    left join trhsp2d c on c.no_sp2d = b.no_sp2d
                    left join trhtransout d on d.kd_skpd = b.kd_skpd and b.no_bukti = d.no_bukti
                    where month(d.tgl_bukti) in ('10','11','12') and b.kd_subkegiatan ='$kegiatan' and left(a.kd_skpd,17) =left('$skpd',17) and b.kd_rek6='$rek5'
                    group by left(b.kd_skpd,17),b.kd_rek6,a.kd_subkegiatan
                    )a";
        $query1 = $this->db->query($sql);
        
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
            $result[] = array(
                            'id' => $ii,        
                            'triw1' => number_format($resulte['triw1'],2,'.',','),                                              
                            'triw2' => number_format($resulte['triw2'],2,'.',','),                                             
                            'triw3' => number_format($resulte['triw3'],2,'.',','),                                            
                            'triw4' => number_format($resulte['triw4'],2,'.',',')                                              
                        );
                        $ii++;
        }
       
        return json_encode($result);

    }



}