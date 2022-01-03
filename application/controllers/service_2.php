<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Example
 *
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array.
 *
 * @package		CodeIgniter
 * @subpackage	Rest Server
 * @category	Controller
 * @author		Phil Sturgeon
 * @link		http://philsturgeon.co.uk/code/
*/

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH.'/libraries/REST_Controller.php';

class Service extends REST_Controller
{
	protected $builtInMethods;
	
	public function __construct()
	{
		parent::__construct();
		$this->__getMyMethods();
		
	}
    
    function program_get() {
        $skpd  = $this->get('skpd');
        $init  = $this->get('status');
        
        if($init=="susun"){
            $nilai = "nilai";
        }else{
            $nilai = "nilai_ubah";
        }
        
        if($skpd=='all'){
            $where = "";
        }else{
            $where = "where a.kd_skpd='$skpd'";
        }
        
        
        $sql = "SELECT left(a.kd_skpd,7)+'.00' as kd_skpd,a.kd_program,a.nm_program,isnull(sum(b.$nilai),0) as pagu FROM m_prog a left join trdrka b on left(b.kd_kegiatan,18)=a.kd_program
        $where
        group by  left(a.kd_skpd,7),a.kd_program,a.nm_program
        order by a.kd_program,a.nm_program ";
        $mas = $this->db->query($sql);
        $result = array();
        
        foreach($mas->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'ID_PROGRAM' => $resulte['kd_program'],  
                        'ID_SATKER' => $resulte['kd_skpd'],
                        'NAMA_PROGRAM' => $resulte['nm_program'],
                        'PAGU' => $resulte['pagu'],
                        );
                        
        }                      
        echo json_encode($result);

	}
    
    function kegiatan_get() {
        //$tahun = $this->get('tahun');
        $skpd  = $this->get('skpd');
        
        if($skpd=='all'){
            $where = "";
        }else{
            $where = "where a.kd_skpd='$skpd'";
        }
        
        
        $sql = "SELECT left(a.kd_skpd,7)+'.00' as kd_skpd,left(a.kd_kegiatan,18) as kd_program,a.kd_kegiatan,a.nm_kegiatan,isnull(sum(a.nilai),0) as pagu 
                from trdrka a 
                $where
                group by  left(a.kd_skpd,7),left(a.kd_kegiatan,18),a.kd_kegiatan,a.nm_kegiatan
                order by a.kd_kegiatan,a.nm_kegiatan";
        $mas = $this->db->query($sql);
        $result = array();
        
        foreach($mas->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'ID_PROGRAM' => $resulte['kd_program'],  
                        'ID_KEGIATAN' => $resulte['kd_kegiatan'],  
                        'ID_SATKER' => $resulte['kd_skpd'],
                        'NAMA_KEGIATAN' => $resulte['nm_kegiatan'],
                        'PAGU' => $resulte['pagu'],
                        );
                        
        }           
           
        echo json_encode($result);

	}
    
		
	/**
	 * 
	 * Analizes self methods using reflection
	 * @return Boolean
	 */
	private function __getMyMethods()
	{
		$reflection = new ReflectionClass($this);
		
		//get all methods
		$methods = $reflection->getMethods();
		$this->builtInMethods = array();
		
		//get properties for each method
		if(!empty($methods))
		{
			foreach ($methods as $method) {
				if(!empty($method->name))
				{
					$methodProp = new ReflectionMethod($this, $method->name);
					
					//saves all methods names found
					$this->builtInMethods['all'][] = $method->name;
					
					//saves all private methods names found
					if($methodProp->isPrivate()) 
					{
						$this->builtInMethods['private'][] = $method->name;
					}
					
					//saves all private methods names found					
					if($methodProp->isPublic()) 
					{
						$this->builtInMethods['public'][] = $method->name;
						
						// gets info about the method and saves them. These info will be used for the xmlrpc server configuration.
						// (only for public methods => avoids also all the public methods starting with '_')
						if(!preg_match('/^_/', $method->name, $matches))
						{
							//consider only the methods having "_" inside their name
							if(preg_match('/_/', $method->name, $matches))
							{	
								//don't consider the methods get_instance and validation_errors
								if($method->name != 'get_instance' AND $method->name != 'validation_errors')
								{
									// -method name: user_get becomes [GET] user
									$name_split = explode("_", $method->name);
									$this->builtInMethods['functions'][$method->name]['function'] = $name_split['0'].' [method: '.$name_split['1'].']';
									
									// -method DocString
									$this->builtInMethods['functions'][$method->name]['docstring'] =  $this->__extractDocString($methodProp->getDocComment());
								}
							}
						}
					}
				}
			}
		} else {
			return false;
		}
		return true;
	}
	
	/**
	 * 
	 * Manipulates a DocString and returns a readable string
	 * @param String $DocComment
	 * @return Array $_tmp
	 */
	private function __extractDocString($DocComment)
	{
		$split = preg_split("/\r\n|\n|\r/", $DocComment);
		$_tmp = array();
		foreach ($split as $id => $row)
		{
			//clean up: removes useless chars like new-lines, tabs and *
			$_tmp[] = trim($row, "* /\n\t\r");
		}			
		return trim(implode("\n",$_tmp));
	}

	public function API_get()
	{
		$this->response($this->builtInMethods, 200); // 200 being the HTTP response code
	}
	    
}