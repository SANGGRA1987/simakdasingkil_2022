<?php  

class blud2simakda extends CI_Controller {

    function __construct() {
        parent::__construct();
    }


	function sp3b_blud(){

		/*data trhsp3b_blud*/
 		$result=json_decode($_POST['trhsp3b_blud'],true);
 		$result=json_encode($result);
 		$result1= (array) json_decode($result);

 		/*data trsp3b_blud*/
 		$result=json_decode($_POST['amp;trsp3b_blud'],true);
 		$result=json_encode($result);
 		$result2= (array) json_decode($result);


 		$bulan=$_POST['amp;bulan'];

		/*INSERT TRHSP3B ================================*/


		$this->db->query("DELETE trhsp3b_blud where bulan='$bulan'");
		foreach($result1 as $value){
			    $no_sp3b= $value->no_sp3b;
	            $no_sp3b= $value->no_sp3b;
	            $kd_skpd= $value->kd_skpd;
	            $keterangan= $value->keterangan;
	            $tgl_sp3b= $value->tgl_sp3b;
	            $status= $value->status;
	            $tgl_awal= $value->tgl_awal;
	            $tgl_akhir= $value->tgl_akhir; 
	            $no_lpj= $value->no_lpj;
	            $total= $value->total;
	            $skpd= $value->skpd;
	            $bulan= $value->bulan;
	            $tgl_update= $value->tgl_update;
	            $username= $value->username;
	            $status_bud= $value->status_bud;
	            $no_sp2b= $value->no_sp2b;
	            $tgl_sp2b= $value->tgl_sp2b;
	            $number_sp2b= $value->number_sp2b;

			$this->db->query("INSERT into
			 trhsp3b_blud (no_sp3b, kd_skpd, keterangan, tgl_sp3b, status, tgl_awal,tgl_akhir,
							no_lpj, total, skpd, bulan, tgl_update, username, status_bud, no_sp2b, tgl_sp2b, number_sp2b)

				values ('$no_sp3b','$kd_skpd','$keterangan','$tgl_sp3b','$status','$tgl_awal','$tgl_akhir','$no_lpj',
				    '$total','$skpd','$bulan','$tgl_update','$username','$status_bud','$no_sp2b','$tgl_sp2b','$number_sp2b')");
		}


		/*INSERT TRSP3B ================================*/

        
		$this->db->query("DELETE trsp3b_blud where month(tgl_sp3b)='$bulan'");

		foreach($result2 as $value){
	            $no_sp3b= $value->no_sp3b;
	            $no_bukti= $value->no_bukti;
	            $keterangan= $value->keterangan;
	            $tgl_sp3b= $value->tgl_sp3b;
	            $kd_rek5= $value->kd_rek5;
	            $nm_rek5= $value->nm_rek5;
	            $nilai= $value->nilai;
	            $kd_skpd= $value->kd_skpd;
	            $kd_kegiatan= $value->kd_kegiatan;
	            $no_lpj= $value->no_lpj;

			$this->db->query("INSERT into
			 trsp3b_blud (no_sp3b, no_bukti, keterangan, tgl_sp3b, kd_rek5, nm_rek5,nilai,
							kd_skpd, kd_kegiatan, no_lpj)

				values ('$no_sp3b','$no_bukti','$keterangan','$tgl_sp3b','$kd_rek5','$nm_rek5','$nilai','$kd_skpd',
				    '$kd_kegiatan','$no_lpj')");
		}

		echo json_encode(1);

	} /*end function*/


} /*end of end*/