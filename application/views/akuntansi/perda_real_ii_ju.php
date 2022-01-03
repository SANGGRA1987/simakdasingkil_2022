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
    
     $(document).ready(function() {
            $("#accordion").accordion();            
            $( "#dialog-modal" ).dialog({
                height: 100,
                width: 922            
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
	
    function cetak($ctk)
        {
            var urusan = document.getElementById('urusan').value;
			var cetak =$ctk; 
			var dcetak = $('#dcetak').datebox('getValue');      
			var dcetak2 = $('#dcetak2').datebox('getValue');
			var url    = "<?php echo site_url(); ?>/akuntansi/cetak_perdaII_real_ju";	  
			window.open(url+'/'+cetak+'/'+dcetak+'/'+dcetak2+'/'+urusan, '_blank');
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



<h3>CETAK LAPORAN REALISASI APBD BERDASARKAN URUSAN PROGRAM, FUNGSI DAN PELAKSANA</h3>       
<div id="accordion">
    
    <p align="right">         
        <table id="sp2d" title="Cetak" style="width:922px;height:200px;" >          
        <tr >
			<td width="30%" height="40" ><B>JENIS URUSAN</B></td>
			<td width="70%">
				<select name="urusan" id="urusan" >
					<option value="1">Urusan Pelaksana</option>
					<option value="2">Urusan Program</option>
				</select>
			</td>
		</tr>
        <tr >
			<td width="30%" height="40" ><B>PERIODE</B></td>
			<td width="70%"><input id="dcetak" name="dcetak" type="text"  style="width:100px" />&nbsp;&nbsp;s/d&nbsp;&nbsp;<input id="dcetak2" name="dcetak2" type="text"  style="width:100px" /></td>
		</tr>
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