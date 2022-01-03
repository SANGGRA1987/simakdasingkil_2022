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
		var kode='';

		$(document).ready(function() {
			$("#accordion").accordion();            
			$( "#dialog-modal" ).dialog({
				height: 100,
				width: 922            
			});             
		}); 

		$(function(){
			$('#sskpd').combogrid({  
				panelWidth:630,  
				idField:'kd_skpd',  
				textField:'kd_skpd',  
				mode:'remote',
				url:'<?php echo base_url(); ?>index.php/tukd/skpd_2',  
				columns:[[  
				{field:'kd_skpd',title:'Kode SKPD',width:100},  
				{field:'nm_skpd',title:'Nama SKPD',width:500}    
				]],
				onSelect:function(rowIndex,rowData){
					kdskpd = rowData.kd_skpd;
					$("#nmskpd").attr("value",rowData.nm_skpd);
					$("#skpd").attr("value",rowData.kd_skpd);

				}  
			}); 
		});

		$(function(){
   	    //$("#status").attr("option",false);
   	    $("#kode_skpd").hide();
   	});
		$(function(){
			$('#tgl_ttd').datebox({  
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
                   ]] 
               });

			$('#ttd').combogrid({  
				panelWidth:500,  
				url: '<?php echo base_url(); ?>/index.php/tukd/load_ttd/BUD',  
				idField:'nip',                    
				textField:'nip',
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

			$('#org').combogrid({  
				panelWidth:630,  
				idField:'kd_org',  
				textField:'kd_org',  
				mode:'remote',
				url:'<?php echo base_url(); ?>index.php/akuntansi/list_org',  
				columns:[[  
				{field:'kd_org',title:'Kode SKPD',width:100},  
				{field:'nm_org',title:'Nama SKPD',width:500}    
				]],
				onSelect:function(rowIndex,rowData){
					kd_org = rowData.kd_org;
					$("#nm_org").attr("value",rowData.nm_org);
					$("#org").attr("value",rowData.kd_org);

				}  
			});
		});

		$(function(){
			$('#dcetak').datebox({  
				required:true,
				formatter :function(date){
					var y = date.getFullYear();
					var m = date.getMonth()+1;
					var d = date.getDate();
					return y+'-'+m+'-'+d;
				}
			});
		});

		$(function(){
			$('#dcetak2').datebox({  
				required:true,
				formatter :function(date){
					var y = date.getFullYear();
					var m = date.getMonth()+1;
					var d = date.getDate();
					return y+'-'+m+'-'+d;
				}
			});
		});

	function validate_ttd(){
		$(function(){
			$('#ttd').combogrid({  
				panelWidth:500,  
				url: '<?php echo base_url(); ?>/index.php/tukd/load_ttd/PA',  
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
	}  

	$(function(){
			//$("#status").attr("option",false);
			$("#kode_skpd").hide();
			$("#kode_org").hide();
		}); 

   function cetak(cetak)
   {
   	var bulan = $('#bulan').combogrid('getValue');  
   	var anggaran = document.getElementById("anggaran").value;
   	var ttd = $('#ttd').combogrid('getValue');     
   	var ctglttd = $('#tgl_ttd').datebox('getValue');

   	if(ctglttd==''){
   		alert('Silahkan Pilih Tanggal Penandatanganan');
   	}

   	if(ttd==''){
   		alert('Silahkan Pilih Penandatanganan');
   	}

   	var url    = "<?php echo site_url(); ?>/bud/trlra_bulanan";

   	window.open(url+'/'+bulan+'/'+anggaran+'/'+ctglttd+'/'+ttd+'/'+cetak+'/lra_bulanan_transaksi');
   	window.focus();
   }

   function cetak2(pilih)
   {
   	var bulan = document.getElementById("bulan").value;  
   	var anggaran = document.getElementById("anggaran").value;  
   	var jenis = document.getElementById("jenis").value;
   	var ttd1 = $('#ttd').combogrid('getValue');     
   	var  ctglttd = $('#tgl_ttd').datebox('getValue');
   	if(ctglttd==''){
   		ctglttd="-";
   	}
   	if(ttd1==''){
   		ttd="-";
   	}else{
   		ttd=ttd1.split(' ').join('abc');
   	}
   	var skpd   = '-';
   	if (ctk=='2'){
   		var skpd   = kdskpd; 			
   	}

   	if(jenis==1){
   		var url    = "<?php echo site_url(); ?>/lamp_perda/cetak_lamp_semester_permen_spj"; 
   	} else{
   		var url    = "<?php echo site_url(); ?>/lamp_perda/cetak_lamp_semester_permen_sp2d"; 
   	}
   	window.open(url+'/'+bulan+'/'+pilih+'/'+anggaran+'/'+jenis+'/'+skpd+'/'+ctglttd+'/'+ttd, '_blank');
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


		<h3>CETAK LAPORAN REALISASI ANGGARAN TRANSAKSI BULANAN</h3>
		<div id="accordion">

			<p align="center">         
				<table id="sp2d" width="100%" border="0">  
					<!-- <tr><td width="922px" colspan="2"><input type="radio" name="cetak" value="1" onclick="opt(this.value)" /><b>SKPD</b></td></tr> -->
            <!-- <tr>
            	<td width="20%"> Periode</td> 
            	<td width="70%" style="padding: 3px;"><select  name="bulan" id="bulan" >
            		<option value="3">Triwulan 1 </option>
            		<option value="6">Semester 1</option>
            		<option value="9">Triwulan 3</option>
            		<option value="12">Semester 2 </option>
            	</select></td> 
            </tr> -->
            <tr>
            	<td width="20%"> Periode</td> 
            	<td width="80%" style="padding: 10px;"><input type="text" id="bulan" style="width: 100px;" /></td> 
            </tr>
            <tr>
            	<td> Anggaran</td> 
            	<td style="padding: 3px;"><select  name="anggaran" id="anggaran" >
            		<option value="1">Penyusunan</option>
            		<option value="2">Pergeseran</option>
            		<option value="3">Perubahan</option>
            	</select></td>
            </tr>
            	<tr>
            		<td>Tanggal TTD</td>
            		<td style="padding: 10px;"><input type="text" id="tgl_ttd" style="width: 150px;" /> </td> 
            	</tr>
            	<tr>
            		<td>Penandatanganan</td>
            		<td style="padding: 10px;"><input type="text" id="ttd" style="width: 200px;" /> </td> 
            	</tr>
            	<tr>
            		<td> </td> 
            		<td align="left"> 
            			<a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetak(0);">Layar</a>
            			<a class="easyui-linkbutton" iconCls="icon-pdf" plain="true" onclick="javascript:cetak(1);">PDF</a>
            			<a class="easyui-linkbutton" iconCls="icon-excel" plain="true" onclick="javascript:cetak(2);">excel</a>
            		</td>
            	</tr>
            </table>                      
        </p> 
    </div> 
</div>


</body>

</html>