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
  <style>    
    #tagih {
        position: relative;
        width: 922px;
        height: 100px;
        padding: 0.4em;
    }  
    </style>
    <script type="text/javascript"> 
    var nip='';
	var kdskpd='';
	var kdrek5='';
	var bulan='';
    
     $(document).ready(function() {
            $("#accordion").accordion();            
            $( "#dialog-modal" ).dialog({
                height: 100,
                width: 922            
            });  
        });   
    $(function(){
	$('#sskpd').combogrid({  
			panelWidth:900,  
			idField:'kd_skpd',  
			textField:'kd_skpd',  
			mode:'remote',
			url:'<?php echo base_url(); ?>index.php/akuntansi/skpd',  
			columns:[[  
				{field:'kd_skpd',title:'Kode SKPD',width:180},  
				{field:'nm_skpd',title:'Nama SKPD',width:700}    
			]],
			onSelect:function(rowIndex,rowData){
				kdskpd = rowData.kd_skpd;
				$("#nmskpd").attr("value",rowData.nm_skpd);
				$("#skpd").attr("value",rowData.kd_skpd);
			   
			}  
			});
	});
	
        
     
    function submit(){
        if (ctk==''){
            alert('Pilih Jenis Cetakan');
            exit();
        }
        document.getElementById("frm_ctk").submit();    
    }
        
    $(function(){
   	    //$("#status").attr("option",false);
        $("#kode_skpd").hide();
   	});   
     
	function opt(val){        
        ctk = val; 
        if (ctk=='1'){
		   $("#kode_skpd").hide();
        } else if (ctk=='2'){
			$("#kode_skpd").show();
        } else {
            exit();
        }                                 
    } 
	/*function pilihx(pilihx){        
        pilihan = 1; 		
    }*/
    function cetak($pilih){
			var pilih =$pilih;
			var dcetak = $('#dcetak').datebox('getValue');      
			var dcetak2 = $('#dcetak2').datebox('getValue'); 
			cbulan = $('#bulan').combogrid('getValue');
			var skpd = kdskpd; 
			
			if(ctk==1){
					if(cbulan==''){
						alert('Pilih Bulan terlebih dahulu!');
						exit();
					}
					urll ='<?php echo base_url(); ?>index.php/akuntansi/cetak_lo/'+cbulan+'/-/1'; 					
			}else{
				if(kdskpd==''){
					alert('Pilih Kode SKPD terlebih dahulu!');
					exit();
				}
				if(cbulan==''){
					alert('Pilih Bulan terlebih dahulu!');
					exit();
				}
					urll ='<?php echo base_url(); ?>index.php/akuntansi/cetak_lo_skpd/'+cbulan+'/-/'+kdskpd+'/1'; 
			}  
    			window.open(urll+'/'+pilih, '_blank');
    			window.focus();
            
        }
	
	$(function(){ 
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
		  
		  $('#dcetak').datebox({  
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
		  
		  });
    
		function runEffect() {
        var selectedEffect = 'blind';            
        var options = {};                      
        $( "#tagih" ).toggle( selectedEffect, options, 500 );
        };
        
      // function pilih() {
       // op = '1';       
      // };   
     
        
    
    </script>

    <STYLE TYPE="text/css"> 
		 input.right{ 
         text-align:right; 
         } 
	</STYLE> 

</head>
<body>

<div id="content">



<h3>CETAK LAPORAN OPERASIONAL</h3>       
<div id="accordion">
    
    <p align="right">         
    <table id="sp2d" title="Cetak" style="width:922px;height:200px;" > 
        <tr><td width="922px" colspan="2"><input type="radio" name="cetak" value="1" onclick="opt(this.value)" /><b>Keseluruhan</b></td></tr>
       <tr><td width="922px" colspan="2"><input type="radio" name="cetak" value="2" id="status" onclick="opt(this.value)" /><b>Per SKPD</b>
                    <div id="kode_skpd">
                        <table style="width:100%;" border="0">
                            <tr >
                    			<td width="22px" height="40%" ><B>SKPD&nbsp;&nbsp;</B></td>
                    			<td width="900px"><input id="sskpd" name="sskpd" style="width: 200px;" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="nmskpd" name="nmskpd" style="width: 500px; border:0;" /></td>
                    		</tr>
                        </table> 
                    </div>
        </td>
      </tr>
		<tr>
			<td width="20%" height="40" ><input type="radio" name="pilihan" value="1" /><B>BULAN</B></td>
			<td width="80%"><input type="text" id="bulan" style="width: 100px;" /></td>
		</tr>
		 <tr>
			<td hidden width="20%" height="40" ><input type="radio" name="pilihan" value="2" /><B>PERIODE</B></td>
			<td hidden width="80%"><input id="dcetak" name="dcetak" type="text"  style="width:155px" />&nbsp;&nbsp;s/d&nbsp;&nbsp;<input id="dcetak2" name="dcetak2" type="text"  style="width:155px" /></td>
		</tr>
       <!-- <tr>
                <td colspan="2">
                <div id="div_periode">
                        <table style="width:100%;" border="0">
                            <td width="22px" height="40%"><B>Bulan</B></td>
                            <td width="900px"><input type="text" id="bulan" style="width: 100px;" /> 
                            </td>
                        </table>
                </div>
                </td>
            </tr>!-->
        
		<tr >
			<td colspan="2"><a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetak(1);">Cetak</a>
            <a class="easyui-linkbutton" iconCls="icon-excel" plain="true" onclick="javascript:cetak(2);">Cetak excel</a>
            <a class="easyui-linkbutton" iconCls="icon-word" plain="true" onclick="javascript:cetak(3);">Cetak word</a></td>
		</tr>
		
    </table>                      
    </p> 
    

</div>

</div>

 	
</body>

</html>