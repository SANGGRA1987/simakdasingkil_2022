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
    

    function cetak($ctk)
        {
            var cetak =$ctk;           	
			var url    = "<?php echo site_url(); ?>/akuntansi/rpt_neraca_ppkd";	  
			ctglttd = $('#tgl_ttd').datebox('getValue');
        
            ctgl1 =  cbulan = $('#bulan').combogrid('getValue');
          
            lc = '?tgl1='+ctgl1+'&tgl_ttd='+ctglttd;
			window.open(url+'/'+cetak+lc, '_blank');
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
                   ]] 
               }); 

	 $('#tgl_ttd').datebox({  
            required:true,
            formatter :function(date){
            	var y = date.getFullYear();
            	var m = date.getMonth()+1;
            	var d = date.getDate();
            	return y+'-'+m+'-'+d;
            }
        });	
			   
	$('#ttd').combogrid({  
					panelWidth:600,  
					idField:'nip',  
					textField:'nip',  
					mode:'remote',
					url:'<?php echo base_url(); ?>index.php/tukd/load_ttd/PA',  
					columns:[[  
						{field:'nip',title:'NIP',width:200},  
						{field:'nama',title:'Nama',width:400}    
					]],
                    onSelect:function(rowIndex,rowData){
                    $("#nmttd").attr("value",rowData.nama);
                    }  
  
				});
    $('#ttd2').combogrid({  
					panelWidth:600,  
					idField:'nip',  
					textField:'nip',  
					mode:'remote',
					url:'<?php echo base_url(); ?>index.php/tukd/load_ttd/PPK',  
					columns:[[  
						{field:'nip',title:'NIP',width:200},  
						{field:'nama',title:'Nama',width:400}    
					]],
                    onSelect:function(rowIndex,rowData){
                    $("#nmttd2").attr("value",rowData.nama);
                    }  
  
				});			   
		
		
		  });
		  
     function openWindow( url ){
      
        ctglttd = $('#tgl_ttd').datebox('getValue');
        
            ctgl1 =  cbulan = $('#bulan').combogrid('getValue');
          
            lc = '?tgl1='+ctgl1+'&tgl_ttd='+ctglttd;
        
         window.open(url+lc,'_blank');
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



<h3>CETAK NERACA PPKD</h3>       
<div id="accordion">
    
    <p align="right">         
        <table id="sp2d" title="Cetak" style="width:922px;height:200px;" >          
        
        <tr>
                <td colspan="1">
                
                <div id="div_periode">
                        <table style="width:816px;height:10px;"border="0">
                            <td width="20%">PERIODE</td>
                            <td width="1%">:</td>
                            <td width="79%"><input type="text" id="bulan" style="width: 100px;" /> 
                            </td>
                        </table>
                </div>
                </td>
            </tr>
		<tr>
                <td colspan="2">
                <div id="div_tgl">
                        <table style="width:100%;" border="0">
                            <td width="20%" height="40%">Tanggal TTD</td>
							<td width="1%">:</td>
                            <td width="79%"><input type="text" id="tgl_ttd" style="width: 100px;" /> 
                            </td>
                        </table>
                </div>
                </td>
            </tr>
        <tr>
                <td colspan="2">
                <div id="div_ttd">
                        <table style="width:100%;" border="0">
                            <td width="20%" height="40%">PA&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong></strong></td>
							<td width="1%">:</td>
                            <td width="79%"><input id="ttd" name="ttd" style="width: 170px;" />  &nbsp; &nbsp; &nbsp;  <input id="nmttd" name="nmttd" style="width: 170px;border:0" /> 
                            </td>
                        </table>
                        <table style="width:100%;" border="0">
                            <td width="20%" height="40%">PPK&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
							<td width="1%">:</td>
                            <td width="79%"><input id="ttd2" name="ttd" style="width: 170px;" />  &nbsp; &nbsp; &nbsp;  <input id="nmttd2" name="nmttd" style="width: 170px;border:0" /> 
                            </td>
                        </table>
                </div>
                </td>
        </tr>
		<tr >
			<td colspan="2"><a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetak(1);">Cetak</a>
             <a class="easyui-linkbutton" iconCls="icon-pdf" plain="true" onclick="javascript:cetak(2);">PDF</a>
            <a class="easyui-linkbutton" iconCls="icon-word" plain="true" onclick="javascript:cetak(3);">Cetak excel</a></td>
		</tr>
		
        </table>                      
    </p> 
    

</div>

</div>

 	
</body>

</html>