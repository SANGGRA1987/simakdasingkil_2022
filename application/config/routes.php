<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "welcome";
//PENYUSUNAN

//$route['tambah_rka_penyusunan'] 				= "anggaran_murni/tambah_rka_penyusunan"; //OK
$route['tambah_rka_pergeseran'] 				= "anggaran_geserController/tambah_rka_geser"; //OK
//$route['tambah_rka_perubahan'] 					= "anggaran_murni/tambah_rka_ubah"; //OK
//$route['rka_skpd_penyusunan'] 					= "rka_rancang/rka0_penyusunan"; //OK
//$route['preview_rka0_penyusunan/(:any)'] 		= "rka_rancang/preview_rka0_penyusunan/"; //OK

// DPA PERGESERAN
$route['cetak-dpa-rekap-geser'] 				= "dpa_geser/cetak_dpa_rekap_geserController/cetak_dpa_rekap_geser/DPA";
$route['cetak-dpa-pendapatan-geser'] 			= "dpa_geser/cetak_dpa_pendapatan_geserController/cetak_dpa_pendapatan_geser/DPA";
$route['cetak-dpa-belanja-geser'] 				= "dpa_geser/cetak_dpa_belanja_geserController/cetak_dpa_belanja_geser/DPA";
$route['cetak-dpa-rincianbelanja-geser'] 		= "dpa_geser/cetak_dpa_rincianbelanja_geserController/rincianbelanja_geser/DPA"; 

$route['cetak-bud-registerbastbud'] 			= "tatausaha/register_bast_budController/index";
$route['cetak-bud-reg_sp2d'] 					= "tatausaha/register_sp2dController/index";
$route['cetak-bud-realisasi_penerimaan'] 		= "tatausaha/realisasi_penerimaanController/index";

$route['cetak-dth-global'] 						= "tatausaha/dth_globalController/index";
$route['cetak-bud-registerlpj'] 				= "tatausaha/register_lpjController/index";
$route['cetak-bud-targetangkas'] 				= "tatausaha/target_angkasController/index";
$route['cetak-bud-regsp2drekon'] 				= "tatausaha/reg_sp2drekonController/index";
$route['cetak-bud-regmodalrekon'] 				= "tatausaha/reg_modalrekonController/index";
$route['cetak-bud-reglpjrekon'] 				= "tatausaha/reg_lpjrekonController/index";
$route['cetak-bud-rekapkas'] 				    = "tatausaha/rekap_kasController/index";
$route['cetak-bud-realisasidau'] 			    = "tatausaha/realisasi_dauController/index";
$route['cetak-bud-reg-spp-spm-sp2d'] 			= "tatausaha/register_sppspmsp2dController/index";


//= "tukd/bud/register_bast_budController/index";
 
//"tukd/cek_tukd/cek_realisasi_anggaran";
// $route['cetak-dpa-belanja-geser'] 				= "cetak_rka/rka_belanja_geser/DPA"; //OK asl



//$route['default_controller'] = "welcome";
$route['index'] = "index";
$route['login'] = "login";
$route['logout'] = "logout";
$route['404_override'] = '';


/* End of file routes.php */
/* Location: ./application/config/routes.php */