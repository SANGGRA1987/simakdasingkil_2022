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
    var pilihttd='';
        
	$(document).ready(function() {
            $("#accordion").accordion();            
            $( "#dialog-modal" ).dialog({
                height: 100,
                width: 922            
            });  
            
            $('#tgl_ttd1').datebox({  
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
	  $('#sskpd').combogrid({  
		panelWidth:630,  
		idField:'kd_skpd',  
		textField:'kd_skpd',  
		mode:'remote',
		url:'<?php echo base_url(); ?>index.php/akuntansi/skpd_new',  
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
	
	//cdate = '<?php echo date("Y-m-d"); ?>';

   $(function(){
            $('#ttdx1').combogrid({  
                panelWidth:180,  
                url: '<?php echo base_url(); ?>/index.php/lamp_perda/load_ttd_perda',  
                    idField:'nip',                    
                    textField:'nama',
                    mode:'remote',  
                    fitColumns:true,  
                    columns:[[  
                        {field:'nama',title:'NAMA',align:'left',width:170}  
                    ]],
                    onSelect:function(rowIndex,rowData){
                    nip = rowData.nip; 
                    }
                       
                });
                
           });              
	 
	$(function(){
			//$("#status").attr("option",false);
			$("#kode_skpd").hide();
		});  
		function opt(val){  
        ctk = val; 
        if (ctk=='1'){
			$("#kode_skpd").hide();
        }  else {
		   $("#kode_skpd").show();
        }          
    }
    
    
    function runEffect() {        
			$('#qttd2')._propAttr('checked',false);
		    pilihttd = "1";  	
		};  
		
		function runEffect2() {        
			$('#qttd')._propAttr('checked',false);
            pilihttd = "2";
		};
    
	

      	function cetak2(pilih)
        {   
           
			var url    = "<?php echo site_url(); ?>/perda/cetak_perda_lampI_permen_spj_akun/12/0/3/1/-/1/2018-12-24/19611019n198412n1n002"; 
			window.open(url, '_blank');
			window.focus();
        }		
		
        
        function cetak3(pilih)
        {   
           
			var url    = "<?php echo site_url(); ?>/perda/cetak_perda_lampI_sp2dterbit/12/0/3/1/-/1/2018-12-24/19611019n198412n1n002"; 
			window.open(url, '_blank');
			window.focus();
        }
        
        function cetak4(pilih)
        {   
           
			var url    = "<?php echo site_url(); ?>/perda/cetak_perda_lampI_sppterbit/12/0/3/1/-/1/2018-12-24/19611019n198412n1n002"; 
			window.open(url, '_blank');
			window.focus();
        }
        
        function cetak5(pilih)
        {   
           
			var url    = "<?php echo site_url(); ?>/perda/cetak_lra_pemkot_spj_akunn_64/12/0/3/1/-/1/2018-12-24/19611019n198412n1n002"; 
			window.open(url, '_blank');
			window.focus();
        }		
		
        
        function cetak6(pilih)
        {   
           
			var url    = "<?php echo site_url(); ?>/perda/cetak_lra_pemkot_sp2d_akunn_64/12/0/3/1/-/1/2018-12-24/19611019n198412n1n002"; 
			window.open(url, '_blank');
			window.focus();
        }
        
        function cetak7(pilih)
        {   
           
			var url    = "<?php echo site_url(); ?>/perda/cetak_lra_pemkot_spp_akunn_64/12/0/3/1/-/1/2018-12-24/19611019n198412n1n002"; 
			window.open(url, '_blank');
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


<h3>CETAK LRA (SP2D)</h3>
<div id="accordion">

    <p align="center">         
        <table id="sp2d" title="" width="100%" border="0">  
		<!--
	<tr>
	<td width="20%"> Periode</td> 
	<td width="70%" style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;"><select  name="bulan" id="bulan" >
     <option value="1">Januari</option>
     <option value="2">Februari</option>
     <option value="3">Maret</option>
     <option value="4">April </option>
     <option value="5">Mei </option>
     <option value="6">Juni </option>
     <option value="7">Juli </option>
     <option value="8">Agustus </option>
     <option value="9">September </option>
     <option value="10">Oktober </option>
     <option value="11">Nopember </option>
     <option value="12">Desember </option>
   </select></td> 
   </tr>
   <tr>
   <td> Anggaran</td> 
	<td style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;">
    <input type="hidden" name="jenis" id="jenis" value="1" />
    <select  name="anggaran" id="anggaran" >
     <option value="1">Penyusunan</option>
    
     <option value="3">Perubahan</option>
   </select></td>
	</tr>
	
        <tr>    
                <td width="15%">TTD</td>
                <td><input type="text" id="ttdx1" style="width: 200px;" /> 
                </td>  
        </tr>
                               
        <tr>
                <td colspan="2">
                <input id="qttd2" name="qttd2" type="checkbox" value="2" onclick="javascript:runEffect2();"/> Tanpa TTD 
                <input id="qttd" name="qttd" type="checkbox" value="1" onclick="javascript:runEffect();"/> Dengan TTD &nbsp;&nbsp;                               
                <input type="text" id="tgl_ttd1" style="width: 100px;" />
                </td>
        </tr>     -->   
		
		<tr >
			<td>REALISASI (LRA)</td> 
			<td align="left"> 
            <a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetak2(0);">Layar (13)</a>
            <a class="easyui-linkbutton" iconCls="icon-pdf" plain="true" onclick="javascript:cetak2(1);">PDF (13)</a>
            <a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetak5(2);">Layar (64)</a>
			<a class="easyui-linkbutton" iconCls="icon-pdf" plain="true" onclick="javascript:cetak5(2);">PDF (64)</a>			
            </td>
		</tr>
		<tr >
			<td>SP2D TERBIT</td> 
			<td align="left"> 
            <a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetak3(0);">Layar (13)</a>
            <a class="easyui-linkbutton" iconCls="icon-pdf" plain="true" onclick="javascript:cetak3(1);">PDF (13)</a>
            <a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetak6(0);">Layar (64)</a>
            <a class="easyui-linkbutton" iconCls="icon-pdf" plain="true" onclick="javascript:cetak6(1);">PDF (64)</a>            
            </td>
		</tr>
		<tr >
			<td>SP2D TERBIT DAN SPP BELUM SP2D</td> 
			<td align="left"> 
            <a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetak4(0);">Layar (13)</a>
            <a class="easyui-linkbutton" iconCls="icon-pdf" plain="true" onclick="javascript:cetak4(1);">PDF (13)</a>
            <a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetak7(0);">Layar (64)</a>
            <a class="easyui-linkbutton" iconCls="icon-pdf" plain="true" onclick="javascript:cetak7(1);">PDF (64)</a>

            </td>
		</tr>        
        </table>                      
    </p> 
  </div> 
</div>

 	
</body>

</html>