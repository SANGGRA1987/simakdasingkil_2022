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
		url:'<?php echo base_url(); ?>index.php/rka/skpd',  
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
	   $('#rek3').combogrid({  
		panelWidth:630,  
		idField:'kd_rek3',  
		textField:'kd_rek3',  
		mode:'remote',
		url:'<?php echo base_url(); ?>index.php/tukd/load_rek3_penyu_lamp_aset/',  
		columns:[[  
			{field:'kd_rek3',title:'Kode Rekening',width:100},  
			{field:'nm_rek3',title:'Nama Rekening',width:500}    
		]],
		onSelect:function(rowIndex,rowData){
			rekening = rowData.kd_rek3;
			//$("#kdrek5").attr("value",rowData.kd_rek5);
			$("#nmrek3").attr("value",rowData.nm_rek3);
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
	
	//cdate = '<?php echo date("Y-m-d"); ?>';
 function validate_ttd(){
   $(function(){
            $('#ttd').combogrid({  
                panelWidth:500,  
                url: '<?php echo base_url(); ?>/index.php/tukd/pilih_ttd/'+kdskpd,  
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


		function cetak(ctk)
        {
			//var ttd    = nip;                           
            //var ttd1 =ttd.split(" ").join("a"); 
			var skpd   = kdskpd; 
			
			var url    = "<?php echo site_url(); ?>/tukd/ctk_amortisasi";  
			window.open(url+'/'+kdskpd+'/'+ctk, '_blank');
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


<h3>CETAK AMORTISASI ASET TIDAK BERWUJUD</h3>
<div id="accordion">

    
    <p align="right">         
        <table id="sp2d" title="Cetak Buku Besar" style="width:922px;height:200px;" >  
		<tr >
			<td width="20%" height="40" ><B>SKPD</B></td>
			<td width="80%"><input id="sskpd" name="sskpd" style="width: 150px;" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="nmskpd" name="nmskpd" style="width: 500px; border:0;" /></td>
		</tr>
		<!--
		<tr >
			<td width="20%" height="40" ><B>REKENING OBJEK</B></td>
			<td width="80%"><input id="rek3" name="rek3" style="width: 150px;" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="nmrek3" name="nmrek3" style="width: 500px; border:0;" /></td>
		</tr>

		
		<tr >
			<td width="20%" height="40" ><B>PENANDA TANGAN</B></td>
			<td width="80%"><input id="ttd" name="ttd" type="text"  style="width:230px" /></td>
		</tr>-->
		<tr >
			
			<td colspan="2" width="80%"> 
            <a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetak(0);">Cetak</a>
            <a class="easyui-linkbutton" iconCls="icon-pdf" plain="true" onclick="javascript:cetak(1);">Cetak</a>
            <a class="easyui-linkbutton" iconCls="icon-excel" plain="true" onclick="javascript:cetak(2);">Cetak excel</a>
            <a class="easyui-linkbutton" iconCls="icon-word" plain="true" onclick="javascript:cetak(3);">Cetak word</a></td>
			</td>
		</tr>
		<tr >
			<td ></td>
			<td ></td>
		</tr>
        </table>                      
    </p> 
   
</div>
</div>

 	
</body>

</html>