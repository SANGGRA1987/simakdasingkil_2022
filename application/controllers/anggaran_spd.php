<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class anggaran_spd extends CI_Controller {

public $ppkd = "5-02.0-00.0-00.02";
public $ppkd1 = "5-02.0-00.0-00.02.0000";
 
    function __construct()
    {     
        parent::__construct();
		
		$this->load->model('master_ttd');
		$this->load->model('anggaran_spd_model');
    }      
 
    function spd_belanja(){
        $data['jenis']="belanja";
        $data['page_title']= 'INPUT SPD BELANJA';
        $this->template->set('title', 'INPUT SPD BELANJA');   
        $this->template->load('template','anggaran/spd/spd_belanja',$data) ; 
    }

    function spd_pembiayaan(){
        $data['jenis']="pembiayaan";
        $data['page_title']= 'INPUT SPD PEMBIAYAAN';
        $this->template->set('title', 'INPUT SPD PEMBIAYAAN');   
        $this->template->load('template','anggaran/spd/spd_belanja',$data) ; 
    } 

    function spd_belanja_revisi(){
        $data['page_title']= 'INPUT SPD BELANJA REVISI';
        $this->template->set('title', 'INPUT SPD BELANJA REVISI');   
        $this->template->load('template','anggaran/spd/spd_belanja_revisi',$data) ; 
    }    

    function spd_pembiayaan_revisi(){
        $data['page_title']= 'INPUT SPD PEMBIAYAAN REVISI';
        $this->template->set('title', 'INPUT SPD PEMBIAYAAN REVISI');   
        $this->template->load('template','anggaran/spd/spd_pembiayaan_revisi',$data) ; 
    } 

    function skpduser_bp() {
        $lccr = $this->input->post('q');
        $result=$this->master_model->skpduser($lccr);
           
        echo json_encode($result);
    }

    function bln_spdakhir(){
        $kdskpd = $this->input->post('skpd');
        $jns = $this->input->post('jenis');
        $result=$this->anggaran_spd_model->bln_spdakhir($kdskpd,$jns);
        echo ($result);
    }
   
    function load_spd_bl($kriteria='') {
        $id      = $this->session->userdata('pcUser');
        $kd_skpd = $this->session->userdata('kdskpd');
        $beban = $this->input->post('jenis'); 
        $result  =$this->anggaran_spd_model->load_spd_bl($kriteria,$kd_skpd,$id,$beban);                  
        echo ($result);    
    }

    function load_ttd_bud(){
        echo $this->master_ttd->load_ttd_bud();                
    }
    
    function load_skpd_bp(){          
        echo $this->master_ttd->load_skpd_bp();

    }
    function load_skpd_bp_pemb(){          
        echo $this->master_ttd->load_skpd_bp_pemb();

    }

    function jumlah_detail_angkas_spd_baru(){ /*cek selisih angkas*/
        $skp      = $this->input->post('skp');
        $jn       = $this->input->post('jn');
        echo $this->anggaran_spd_model->jumlah_detail_angkas_spd_baru($skp,$jn);
    }  

    /*function config_spd_nomor(){
        $skpd      = $this->input->post('skpd');
        $bln      = $this->input->post('bln');
        echo $this->anggaran_spd_model->config_spd_nomor($skpd,$bln);
    }*/

    function config_spd_nomor(){
        $skpd      = $this->input->post('skpd');
        $bln      = $this->input->post('bln');                                                
        $q = $this->db->query("SELECT MAX(nokas)+1 AS nomor FROM(
                            SELECT urut AS nokas FROM trhspd WHERE kd_skpd='$skpd' AND month(tgl_spd)='$bln'
                            )zzz
                         ");
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

    function load_tot_dspd_bl($jenis='',$skpd='',$awal='',$ahir='',$nospd='',$tgl1=''){
        echo $this->anggaran_spd_model->load_tot_dspd_bl($jenis,$skpd,$awal,$ahir,$nospd,$tgl1);
    }

    function load_bendahara_p(){
        $kdskpd = $this->input->post('kode');
        echo $this->master_ttd->load_bendahara_p($kdskpd);
    }
    
    function load_dspd_bl($jenis='',$skpd='',$awal='',$ahir='',$nospd='',$cbln1=''){
        $tgl = $this->input->post('tgl');
        $cbln1 = $this->input->post('cbln1');
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
        $offset = ($page-1)*$rows;
        $kriteria = $this->input->post('cari');
        echo $this->anggaran_spd_model->load_dspd_bl($jenis,$skpd,$awal,$ahir,$nospd,$cbln1,$tgl,$page,$rows,$offset,$kriteria); 
    }

    function cek_simpan_spd(){
        $nomor   = $this->input->post('no');
        $skpd    = $this->input->post('skpd');
        $awal    = $this->input->post('awal');   
        $akhir    = $this->input->post('akhir');
        echo $this->anggaran_spd_model->cek_simpan_spd($nomor,$skpd,$awal,$akhir);
    } 

       function simpan_spd(){
        $tabel  = $this->input->post('tabel');
        $idx    = $this->input->post('cidx');
        $nomor  = $this->input->post('no');
        $cno_u  = $this->input->post('cno_u');
        $nomor2  = $this->input->post('no2');
        $mode_tox= $this->input->post('mode_tox');
        $tgl    = $this->input->post('tgl');
        $skpd   = $this->input->post('skpd');
        $nmskpd = $this->input->post('nmskpd');
        $bend   = $this->input->post('bend');
        $bln1   = $this->input->post('bln1');
        $bln2   = $this->input->post('bln2');
        $ketentuan  = $this->input->post('ketentuan');
        $pengajuan  = $this->input->post('pengajuan');
        $jenis      = $this->input->post('jenis');
        $jenis_spp  = $this->input->post('jns_spp');
        $total      = $this->input->post('total');
        $csql       = $this->input->post('sql');        
        $usernm     = $this->session->userdata('pcNama');    
        $update     = date('Y-m-d H:i:s');    
        $msg = array();                
        // Simpan Header //
        if ($tabel == 'trhspd') {
            if ($mode_tox=='tambah'){

                $sql = "INSERT into  $tabel (no_spd,tgl_spd,kd_skpd,nm_skpd,jns_beban,bulan_awal,bulan_akhir,total,klain,kd_bkeluar,username,tglupdate,jns_spp,total_hasil,urut) 
                        values('$nomor','$tgl','$skpd', rtrim('$nmskpd'),'$jenis','$bln1','$bln2','$total', rtrim('$ketentuan'),'$bend','$usernm','$update','$jenis_spp','$total','$cno_u')";
                $asg = $this->db->query($sql);
                if (!($asg)){
                    $msg = array('pesan'=>'0');
                    echo json_encode($msg);
                    exit();
                } else {
                        $msg = array('pesan'=>'1');
                        echo json_encode($msg);
                }          

            } else if($mode_tox=='edit'){
                $sql = "UPDATE $tabel set 
                    no_spd='$nomor',tgl_spd='$tgl',kd_skpd='$skpd',nm_skpd=rtrim('$nmskpd'),
                    jns_beban='$jenis',bulan_awal='$bln1',bulan_akhir='$bln2',total='$total',total_hasil='$total',klain=rtrim('$ketentuan'),kd_bkeluar='$bend',username='$usernm',tglupdate='$update',jns_spp='$jenis_spp'
                    where no_spd='$nomor2' ";
                $asg = $this->db->query($sql);
                if (!($asg)){
                    $msg = array('pesan'=>'0');
                    echo json_encode($msg);
                    exit();
                } else {
                        $msg = array('pesan'=>'1');
                        echo json_encode($msg);
                }          
                
            }
            
        } else if ($tabel == 'trdspd') {
            
            // Simpan Detail //                       
                $sql = "delete from  $tabel where no_spd='$nomor2'";
                $asg = $this->db->query($sql);
                if (!($asg)){
                   $msg= array('pesan'=>'0');
                   echo json_encode($msg);
                   exit();
                } else {
                    $sql = "INSERT into  $tabel(no_spd,kd_kegiatan,nm_kegiatan,kd_rek5,nm_rek5,kd_program,nm_program,nilai,nilai_final,kd_subkegiatan,nm_subkegiatan)";                        
                    $asg = $this->db->query($sql.$csql);
                    if (!($asg)){
                        $msg = array('pesan'=>'0');
                        echo json_encode($msg);
                        exit();
                    }  else {
                        $msg = array('pesan'=>'1');
                        echo json_encode($msg);
                    }
                }                                                             
        }        
    }

    function hapus_spd(){
        $nomor = $this->input->post('no');
        echo $this->anggaran_spd_model->hapus_spd($nomor);           
    } 

    function load_dspd_ag_bl() {            
        $no = $this->input->post('no');
        $jenis = $this->input->post('jenis');
        $skpd = $this->input->post('skpd');
        $dskpd = substr($skpd,0,20);
        $tgl = $this->input->post('tgl');
        $cbln1 = $this->input->post('cbln1');
        $rows='';
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
        $offset = ($page-1)*$rows;
        $kriteria = $this->input->post('cari');
        echo $this->anggaran_spd_model->load_dspd_ag_bl($no,$jenis,$skpd,$dskpd,$tgl,$cbln1,$page,$rows,$offset,$kriteria);
    }

    function load_spd_bl_angkas() {
        $kd_skpd = $this->session->userdata('kdskpd'); 
        $result = array();
        $row = array();
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
        $offset = ($page-1)*$rows;        
        $kriteria = $this->input->post('cari');
        $beban = $this->input->post('beban');  
        $id  = $this->session->userdata('pcUser');  
        echo $this->anggaran_spd_model->load_spd_bl_angkas($kd_skpd,$page, $rows,$offset,$kriteria,$id,$beban);    
    }

    function update_sts_spd(){
        $no_spd      = $this->input->post('no');
        $ckd_skpd     = $this->input->post('kd_skpd');
        $csts        = $this->input->post('status_spd');
        echo $this->anggaran_spd_model->update_sts_spd($no_spd, $ckd_skpd,$csts);            
        
    }

    function cek_simpan(){ /*untuk cek appakah ada spd di tabel trhspp*/
        $nomor    = $this->input->post('no');
        $tabel   = $this->input->post('tabel');
        $field    = $this->input->post('field'); /*trhspp*/
        echo $this->anggaran_spd_model->cek_simpan($nomor,$tabel,$field);       
    }
}
