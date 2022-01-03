<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('login_model');
		$this->client_logon = $this->session->userdata('logged');
	}
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 * 
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	function index()
	{

		$user=$this->session->userdata('pcNama');
		$type=$this->session->userdata('type');
		$cek=$this->db->query("SELECT count(user_name) ok from [user] where user_name='$user' and type='$type'")->row();

		if ($user=='' || $cek->ok == 0){
			$this->login_model->logout();
			redirect('/welcome/login');;
		}

		$this->template->set('title', 'SIMAKDA');
		if ($this->client_logon){
			$user              = $this->session->userdata('pcUser');
			$otoriname         = $this->session->userdata('pcOtoriName');
			$logintime         = $this->session->userdata('pcLoginTime');
		//$userlevel	  = $$this->session->userdata('pcUserlevel');
			$thn_ang	   = $this->session->userdata('pcThang');	
		//$jaka = $this->session->userdata('pcJaka');

		//$this->template->set('title', 'SIMAKDA');

			$this->template->load('template', 'home',$otoriname);
	       
        }
	 else
        {

	   redirect('/welcome/login');
	}
	}
	
	Public function login()
	{
	
		$client = $this->ClientModel->clientData();
		$kab = $client->kab_kota;
		$prov = $client->provinsi;
		$daerah = $client->daerah;
		$data['kab'] = $kab;	
		$data['prov'] = $prov;	
		$data['daerah'] = $daerah;
		if($_POST)
		{
		
		$user = $this->login_model->validate($_POST['username'], $_POST['password'],$_POST['pcthang']);
 
			if($user == TRUE)
			{
			
				   redirect('welcome');;
			}
			else
			{
			$this->template->set('title', 'SIMAKDA');
			
			$data['pesan'] = 'Username atau password salah!';
			$this->template->load('template_login', 'login',$data);
			}
 
		}
		else
		{
		
		$this->template->set('title', 'SIMAKDA');
		$this->template->load('template_login', 'login',$data);
		}
	}
 
	 Public function logout()
	{
		$this->login_model->logout();
		   redirect('/welcome/login');;
	}
 

	public function ceklogin(){
		$user=$this->session->userdata('pcNama');
		$cek=$this->db->query("SELECT count(user_name) ok from [user] where user_name='$user'")->row();
		if ($user=='' || $cek->ok == 0){
			$this->login_model->logout();
			redirect('/welcome/login');;
		}else{
			echo '0';
		}
	}

}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */