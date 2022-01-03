<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>easyui/themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>easyui/themes/icon.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>easyui/demo/demo.css">
	<script type="text/javascript" src="<?php echo base_url(); ?>easyui/jquery-1.8.0.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>easyui/jquery.easyui.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>easyui/jquery.edatagrid.js"></script>
    
    <link href="<?php echo base_url(); ?>easyui/jquery-ui.css" rel="stylesheet" type="text/css"/>
    <script src="<?php echo base_url(); ?>easyui/jquery-ui.min.js"></script>
   
    <script type="text/javascript"> 
    var nip='';
	var kdskpd='';
	var kdrek5='';
	var ctk = 1;
    

    
	$(function(){

		$('#skpd').combogrid({  
           panelWidth:700,  
           idField:'kd_skpd',  
           textField:'kd_skpd',  
           mode:'remote',
           url:'<?php echo base_url(); ?>index.php/tatausaha/reg_lpjrekonController/skpd',  
           columns:[[  
               {field:'kd_skpd',title:'Kode SKPD',width:160},  
               {field:'nm_skpd',title:'Nama SKPD',width:510}    
           ]], 
           onSelect:function(rowIndex,rowData){
               kode = rowData.kd_skpd;               
               $("#nmskpd").attr("value",rowData.nm_skpd);
			validate_kegi(kode);
           }  
         });

                 
        $('#dcetak').datebox({  
            required:true,
            formatter :function(date){
            	var y = date.getFullYear();
            	var m = date.getMonth()+1;
            	var d = date.getDate();
            	return y+'-'+m+'-'+d;
            }
        }); 
        
        $('#dcetak_ttd').datebox({  
            required:true,
            formatter :function(date){
            	var y = date.getFullYear();
            	var m = date.getMonth()+1;
            	var d = date.getDate();
            	return y+'-'+m+'-'+d;
            }
        }); 
        
        $('#dcetak2').datebox({  
            required:true,
            formatter :function(date){
            	var y = date.getFullYear();
            	var m = date.getMonth()+1;
            	var d = date.getDate();
            	return y+'-'+m+'-'+d;
            }
        });
		
		$('#bulan').combogrid({  
                   panelWidth:120,
                   panelHeight:300,  
                   idField:'bln',  
                   textField:'nm_bulan',  
                   mode:'remote',
                   url:'<?php echo base_url(); ?>index.php/tatausaha/reg_lpjrekonController/bulan',  
                   columns:[[ 
                       {field:'nm_bulan',title:'Nama Bulan',width:700}    
                   ]],
					onSelect:function(rowIndex,rowData){
						bulan = rowData.nm_bulan;
						$("#bulan").attr("value",rowData.nm_bulan);
					}
               });
		
        
        $('#ttd').combogrid({  
		panelWidth:500,  
		url: '<?php echo base_url(); ?>/index.php/tatausaha/reg_lpjrekonController/load_ttd/BUD',  
			idField:'nip',                    
			textField:'nama',
			mode:'remote',  
			fitColumns:true,  
			columns:[[  
				{field:'nip',title:'NIP',width:60},  
				{field:'nama',title:'NAMA',align:'left',width:100}								
			]],
			onSelect:function(rowIndex,rowData){
			nip = rowData.nip;
			
			}   
		});
	});
		 $(document).ready(function() { 
      //get_skpd();                                                            
    		 cdate = '<?php echo date("Y-m-d"); ?>';
		 $("#dcetak").datebox("setValue",cdate);
        $("#dcetak2").datebox("setValue",cdate);

	  }); 
	 function validate_kegi(kode){
           $(function(){
		 $('#kg').combogrid({  
                panelWidth:500,  
                url: '<?php echo base_url(); ?>/index.php/tatausaha/reg_lpjrekonController/pgiat/'+kode,  			
                    idField:'kd_kegiatan',  
                    textField:'kd_kegiatan',
                    mode:'remote',  
                    fitColumns:true,                       
                    columns:[[  
                        {field:'kd_kegiatan',title:'Kode',width:30},  
                        {field:'nm_kegiatan',title:'Nama',align:'left',width:70}                          
                    ]],
                    onSelect:function(rowIndex,rowData){
                    kegi   = rowData.kd_kegiatan;
                    nmkegi = rowData.nm_kegiatan;
                    $("#nm_kg").attr("value",rowData.nm_kegiatan);

					validate_rek(kegi);
                    }    
                });
                
		       });
        }
    
	 function validate_rek(cgiat){
           $(function(){
        $('#kdrek5').combogrid({  
		panelWidth:630,  
		idField:'kd_rek5',  
		textField:'kd_rek5',  
		mode:'remote',
		url:'<?php echo base_url(); ?>/index.php/tatausaha/reg_lpjrekonController/ld_rek/'+cgiat,  
		columns:[[  
			{field:'kd_rek5',title:'Kode Rekening',width:100},  
			{field:'nm_rek5',title:'Nama Rekening',width:500}    
		]],
		onSelect:function(rowIndex,rowData){
			rekening = rowData.kd_rek5;
			//$("#kdrek5").attr("value",rowData.kd_rek5);
			$("#nmrek5").attr("value",rowData.nm_rek5);
		}  
		}); 
		
				       });
        }
	
    function get_skpd()
        {
        
        	$.ajax({
        		url:'<?php echo base_url(); ?>index.php/tatausaha/reg_lpjrekonController/config_skpd',
        		type: "POST",
        		dataType:"json",                         
        		success:function(data){
        								$("#sskpd").attr("value",data.kd_skpd);
        								$("#nmskpd").attr("value",data.nm_skpd);
                                        $("#skpd").attr("value",data.kd_skpd);
        								kdskpd = data.kd_skpd;
                                               
        							  }                                     
        	});  
        }



  function opt(val){        
        ctk = val; 
        if (ctk=='2'){
		//$("#div_skpd").hide();
		options = { percent: 0 };
		selectedEffect = "clip";
		$( "#div_skpd" ).hide( selectedEffect, options, 1000 );
        } else if (ctk=='1'){
//            $("#div_skpd").show();
			$( "#div_skpd" ).show( selectedEffect, options, 1000 );
            } else {
            exit();
        }                 
    }    

function pilih(pilih){        
        pilihan = pilih; 
    }	

	 function callback() {
      setTimeout(function() {
        $( "#div_skpd" ).removeAttr( "style" ).hide().fadeIn();
      }, 1000 );
    };

        	
	function cetak_register_lpj(cetak){
			var cetak =cetak;
			var ttd    = nip;                           
			var ttd1 =ttd.split(" ").join("a");
			var cbulan = $('#bulan').combogrid('getValue');
			var skpd   = kode; 			
			var ctglttd = $('#dcetak_ttd').datebox('getValue');	
			if(ctglttd==''){
				alert('Pilih Tanggal tanda tangan dulu')
				exit()
			}
				var url    = "<?php echo site_url(); ?>/tatausaha/reg_lpjrekonController/cetak_register_lpjtu_baru"; 
				window.open(url+'/'+ttd1+'/'+skpd+'/'+cbulan+'/'+cetak+'/1/'+ctglttd);
				window.focus();				
        }
        
	function cetak_register_lpj1(cetak){
			var cetak =cetak;
			var ttd    = nip;                           
			var ttd1 =ttd.split(" ").join("a");
			var cbulan = $('#bulan').combogrid('getValue');
			var skpd   = kode; 	
			var ctglttd = $('#dcetak_ttd').datebox('getValue');	
			if(ctglttd==''){
				alert('Pilih Tanggal tanda tangan dulu')
				exit()
			}	
				var url    = "<?php echo site_url(); ?>/tatausaha/reg_lpjrekonController/cetak_register_lpjup_baru"; 
				window.open(url+'/'+ttd1+'/'+skpd+'/'+cbulan+'/'+cetak+'/1/'+ctglttd);
				window.focus();				
        }	
        	
    </script>

    <STYLE TYPE="text/css"> 
		 input.right{ 
         text-align:right; 
         } 
	</STYLE> 

</head>
<body>

<div id="content">

<div id="accordion">

<h3>CETAK REGISTER LPJ</h3>
    <div>
    <p align="right">         
        <table id="sp2d" title="Cetak KARTU KENDALI" style="width:870px;height:300px;" >		
		<tr >
			<td colspan="2">
			<div id="div_skpd">
				<table style="width:100%;" border="0">
				<tr>
				<td width="20%" height="40" ><B>SKPD</B></td>
				<td width="80%"><input id="skpd" name="skpd" style="width: 170px;border: 0;" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="nmskpd" name="nmskpd" readonly="true" style="width: 450px; border:0;" /></td>
				</tr>
				</table>
			</div>
			</td>
		</tr>
		<tr> 
			<td width="20%" height="40" ><B>BULAN</B></td>
			<td width="80%"><input type="text" id="bulan" style="width: 100px;" /></td>
		</tr>      
		<tr>
			<td width="20%" height="40" ><B>PENANDA TANGAN</B></td>
			<td width="80%"><input id="ttd" name="ttd" type="text"  style="width:230px" /></td>
		</tr>
        	<tr>            
            <td><b>Tanggal TTD</b></td>
            <td><input id="dcetak_ttd" name="dcetak_ttd" type="text"  style="width:110px" /></td>
        </tr>
		<tr >
			<td width="20%" height="40" ><B>Register LPJ TU</B></td>
			<td width="80%"> <a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetak_register_lpj(2);">Cetak Layar</a>
			<a class="easyui-linkbutton" iconCls="icon-pdf" plain="true" onclick="javascript:cetak_register_lpj(1);">Cetak Pdf</a>
			</td>
		</tr>
		<tr >
			<td width="20%" height="40" ><B>Register LPJ UP</B></td>
			<td width="80%"> <a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetak_register_lpj1(2);">Cetak Layar</a>
			<a class="easyui-linkbutton" iconCls="icon-pdf" plain="true" onclick="javascript:cetak_register_lpj1(1);">Cetak Pdf</a>
			</td>
		</tr>  	      
		<tr >
			<td >&nbsp;</td>
			<td >&nbsp;</td>
		</tr>
        </table>                      
    </p> 
    </div>
</div>
</div>

 	
</body>

</html>