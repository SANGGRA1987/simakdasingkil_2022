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
	//$('#sskpd').combogrid({  
//		panelWidth:630,  
//		idField:'kd_skpd',  
//		textField:'kd_skpd',  
//		mode:'remote',
//		url:'<?php echo base_url(); ?>index.php/akuntansi/skpd',  
//		columns:[[  
//			{field:'kd_skpd',title:'Kode SKPD',width:100},  
//			{field:'nm_skpd',title:'Nama SKPD',width:500}    
//		]],
//		onSelect:function(rowIndex,rowData){
//			kdskpd = rowData.kd_skpd;
//			$("#nmskpd").attr("value",rowData.nm_skpd);
//			$("#skpd").attr("value",rowData.kd_skpd);
//			//validate_giat();
//		}  
//		});

		$('#skpd').combogrid({  
           panelWidth:700,  
           idField:'kd_skpd',  
           textField:'kd_skpd',  
           mode:'remote',
           url:'<?php echo base_url(); ?>index.php/tukd/skpd_2',  
           columns:[[  
               {field:'kd_skpd',title:'Kode SKPD',width:100},  
               {field:'nm_skpd',title:'Nama SKPD',width:700}    
           ]], 
           onSelect:function(rowIndex,rowData){
               kode = rowData.kd_skpd; 
              // bend(kode);               
               $("#nmskpd").attr("value",rowData.nm_skpd);
               //$('#giat').combogrid({url:'<?php echo base_url(); ?>index.php/rka/load_trskpd',
                        //             queryParams:({kode:kode})
                        //             });
			
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
                   url:'<?php echo base_url(); ?>index.php/rka/bulan',  
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
		url: '<?php echo base_url(); ?>/index.php/tukd/load_ttd/BUD',  
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
                url: '<?php echo base_url(); ?>/index.php/tukd/pgiat/'+kode,  			
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
		url:'<?php echo base_url(); ?>/index.php/tukd/ld_rek/'+cgiat,  
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
        		url:'<?php echo base_url(); ?>index.php/rka/config_skpd',
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

	
	function cetak_register_persp2d(cetak){
			var cetak =cetak;           	
			var dcetak = $('#dcetak').datebox('getValue');      
			var dcetak2 = $('#dcetak2').datebox('getValue');      
			var tstatus = 1; 
			var jenis = 5; 
			var urut = 1; 
			var ttd    = nip;                           
			var ttd1 =ttd.split(" ").join("a"); 
			var skpd   = '--';
			var cbulan = $('#bulan').combogrid('getValue');
			if (ctk=='1'){
			var skpd   = kode;
			dengan=0; 			
			}
			
			dengan=0;

			if(pilihan=='1'){
				if(dengan==0){
				var url    = "<?php echo site_url(); ?>/tukd/cetak_reg_efisiensi_sp2d"; 
				} else {
				var url    = "<?php echo site_url(); ?>/tukd/cetak_reg_efisiensi_sp2d"; 
				}
				window.open(url+'/-/'+ttd1+'/'+skpd+'/'+tstatus+'/-/'+cetak+'/1');
				window.focus();				
			} else if (pilihan=='2'){
				if(cbulan==''){
					alert('Pilih Bulan terlebih dahulu!');
					exit();
				}
				
				if (dengan==0){
				var url    = "<?php echo site_url(); ?>/tukd/cetak_reg_efisiensi_sp2d"; 
				} else {
				var url    = "<?php echo site_url(); ?>/tukd/cetak_reg_efisiensi_sp2d"; 
				}
				window.open(url+'/'+cbulan+'/'+ttd1+'/'+skpd+'/'+tstatus+'/-/'+cetak+'/2');
				window.focus();
				
			}else if(pilihan=='3'){
			var url    = "<?php echo site_url(); ?>/tukd/cetak_reg_efisiensi_sp2d"; 
			window.open(url+'/'+dcetak+'/'+ttd1+'/'+skpd+'/'+tstatus+'/'+dcetak2+'/'+cetak+'/3');
			window.focus();
			}
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

<h3>CETAK REGISTER EFISIENSI SP2D</h3>
    <div>
    <p align="right">         
        <table id="sp2d" title="CETAK EFISIENSI SP2D" style="width:870px;height:300px;" >
		<tr>
                <td colspan="2"><input type="radio" name="cetak" value="1" onclick="opt(this.value)" />PER-SKPD &ensp;
                <input type="radio" name="cetak" value="2" id="status" onclick="opt(this.value)" />KESELURUHAN
                </td>
                
            </tr>		
		<tr >
			<td colspan="2">
			<div id="div_skpd">
				<table style="width:100%;" border="0">
				<tr>
				<td width="20%" height="40" ><B>SKPD</B></td>
				<td width="80%"><input id="skpd" name="skpd" style="width: 100px;border: 0;" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="nmskpd" name="nmskpd" readonly="true" style="width: 500px; border:0;" /></td>
				</tr>
				</table>
			</div>
			</td>
		</tr>
		<tr >
			<td colspan = "2" width="20%" height="40" ><input type="radio" name="pilihan" value="1" onclick="pilih(this.value)"/><B>KESELURUHAN</B></td>
		</tr>
		<tr> 
			<td width="20%" height="40" ><input type="radio" name="pilihan" value="2" onclick="pilih(this.value)"/><B>BULAN</B></td>
			<td width="80%"><input type="text" id="bulan" style="width: 100px;" /></td>
		</tr>
		<tr>
			<td width="20%" height="40" ><input type="radio" name="pilihan" value="3" onclick="pilih(this.value)"/><B>PERIODE</B></td>
			<td width="80%"><input id="dcetak" name="dcetak" type="text"  style="width:155px" />&nbsp;&nbsp;s/d&nbsp;&nbsp;<input id="dcetak2" name="dcetak2" type="text"  style="width:155px" /></td>
		</tr>
		<!--<tr>
			<td width="20%" height="40" ><B>Jenis</B></td>
			<td width="80%">			
				<select name="jenis" id="jenis" style="width:200px;">
				 <option value="7">UP/GU</option>
                 <option value="8">TU</option>
                 <option value="1">BL</option>
				 <option value="2">BTL</option>
				 <option value="3">BTL (Gaji)</option>
				 <option value="4">BTL (Non Gaji)</option>
				 <option value="5">SELURUH</option>
				 <option value="6">Cetak Gaji Khusus</option>                 
                </select>
			</td>
		</tr>-->
		<!--<tr>
			<td width="20%" height="40" ><B>STATUS</B></td>
			<td width="80%">			
				<select name="tstatus" id="tstatus" style="width:200px;">
				 <option value="1">SP2D TERBIT</option>
				 <option value="2">SP2D LUNAS</option>
				 <option value="3">SP2D ADVICE</option>
				 <option value="4">SP2D BELUM CAIR</option>
				 <option value="5">SP2D BELUM ADVICE</option>
                 <option value="6">SP2D DIBATALKAN</option>
				 </select>
		</td>-->
		</tr>        
		<tr>
			<td width="20%" height="40" ><B>PENANDATANGAN</B></td>
			<td width="80%"><input id="ttd" name="ttd" type="text"  style="width:230px" /></td>
		</tr>
		<!--<tr>
			<td width="20%" height="40" ><B>ANGGARAN</B></td>
			<td width="80%">			
				<select name="anggaran" id="anggaran" style="width:200px;">
				 <option value="1">MURNI</option>
				 <option value="2">PENYEMPURNAAN</option>
				 <option value="3">PERUBAHAN</option>
				 </select>
		</td>
		</tr>-->
		<!--<tr>
			<td width="20%" height="40" ><B>URUTAN</B></td>
			<td width="80%">			
				<select name="urut" id="urut" style="width:200px;">
				 <option value="1">NO SP2D</option>
				 <option value="2">NO KAS</option>
				 </select>
		</td>
		</tr> -->      

		<!--<tr>            
            <td>&nbsp;</td>
            <td><input type="checkbox" id="dengan">Tampilkan No Kasda</td>
        </tr>-->
        	<tr>            
            <td>&nbsp;</td>
            <td>TANGGAL TTD   <input id="dcetak_ttd" name="dcetak_ttd" type="text"  style="width:155px" /></td>
        </tr>
		<!--<tr >
			<td width="20%" height="40" ><B>Register SPM/SP2D</B></td>
			<td width="80%"> <a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetak_register_sp2d(2);">Cetak Layar</a>
			<a class="easyui-linkbutton" iconCls="icon-pdf" plain="true" onclick="javascript:cetak_register_sp2d(1);">Cetak Pdf</a>
			</td>
		</tr>-->
		<tr >
			<td width="20%" height="40" ><B>CETAK REGISTER</B></td>
			<td width="80%"> <a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetak_register_persp2d(0);">Cetak Layar</a>
			<a class="easyui-linkbutton" iconCls="icon-pdf" plain="true" onclick="javascript:cetak_register_persp2d(1);">Cetak Pdf</a>
			<a class="easyui-linkbutton" iconCls="icon-excel" plain="true" onclick="javascript:cetak_register_persp2d(2);">Cetak excel</a>
            </td>
		<!--</tr>		<tr >
			<td width="20%" height="40" ><B>Realisasi </B></td>
			<td width="80%"> <a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetak_realisasi_sp2d(2);">Cetak Layar</a>
			<a class="easyui-linkbutton" iconCls="icon-pdf" plain="true" onclick="javascript:cetak_realisasi_sp2d(1);">Cetak Pdf</a>
			</td>
			
		</tr>
		<tr >
			<td width="20%" height="40" ><B>Rekap Register SKPD</B></td>
			<td width="80%"> <a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetak_register_rekap(2);">Cetak Layar</a>
			<a class="easyui-linkbutton" iconCls="icon-pdf" plain="true" onclick="javascript:cetak_register_rekap(1);">Cetak Pdf</a>
			</td>
		</tr>
        <tr >
			<td width="20%" height="40" ><B>Cetak Seluruh Register</B></td>
			<td width="80%"> <a class="easyui-linkbutton" iconCls="icon-pdf" plain="true" onclick="javascript:cetak_register_sp2d_seluruh();">Cetak Pdf</a>
			
			</td>
		</tr>
		<tr >
			<td width="20%" height="40" ><B>Gaji Bulanan PNS </B></td>
			<td width="80%"> <a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetak_register_sp2d_baru3(2);">Cetak Layar</a>
			<a class="easyui-linkbutton" iconCls="icon-pdf" plain="true" onclick="javascript:cetak_register_sp2d_baru3(1);">Cetak Pdf</a>
			</td>
			
		</tr>  -->      
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