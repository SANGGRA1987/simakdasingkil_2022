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
        width: 500px;
        height: 70px;
        padding: 0.4em;
    }  
    </style>
    <script type="text/javascript"> 
    var nip='';
    var xnip='';
    
     $(document).ready(function() {
            
            $("#accordion").accordion();            
            $( "#dialog-modal" ).dialog({
                height: 400,
                width: 800            
            }); 
                     
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

	});
     
     $(function(){  
        $('#ttd2').combogrid({  
            panelWidth:400,  
            idField:'nip',  
            textField:'nip',  
            mode:'remote',
            url:'<?php echo base_url(); ?>index.php/rka/load_ttd_bud',  
            columns:[[  
                {field:'nip',title:'NIP',width:200},  
                {field:'nama',title:'Nama',width:400}    
            ]],
            onSelect:function(rowIndex,rowData){
                xnip = nip;
                $("#ttd2").attr("value",rowData.nip);
                $("#nama2").attr("value",rowData.nama);
            }  
        });          
     });

      $(document).ready(function(){                
        kosong()                                             
     });

    
    function kosong(){
       $("#ttd2").combogrid("setValue",'');                   
    }

    function cek($cet){           
            
            var xxx = $('#ttd2').combogrid('getValue');
             
            if (xxx==''){
                alert('Pilih TTD Terlebih Dahulu');
                exit();
                }else{
                   cetak($cet);   
                }
           
    }
   
   function cetak($ctk)
        {
            var cetak  =$ctk;
			var cell = document.getElementById('cell').value;            
			
			if(cetak==2){
				url="<?php echo site_url(); ?>/rka/preview_anggaran_kas_simpatik/"+cetak+'/'+cell+'/Report_Anggaran_Kas_Simpatik.xls';
			}else{
	           url="<?php echo site_url(); ?>/rka/preview_anggaran_kas_simpatik/"+cetak+'/'+cell+'/Report_Anggaran_Kas_Simpatik';
			}
               openWindow( url );			
        }
     
     function runEffect() {
        var selectedEffect = 'blind';            
        var options = {};                      
        $( "#tagih" ).toggle( selectedEffect, options, 500 );
        };
        
      function pilih() {
       op = '1';       
      };   
        
    function openWindow( url ){
           var  ctglttd = $('#tgl_ttd').datebox('getValue');        
           var  ttdx = $('#ttd2').combogrid('getValue');
		   var ttd2 = ttdx.split(" ").join("a");
             lc = '?tgl_ttd='+ctglttd+'&ttd2='+ttd2+'';
			window.open(url+lc,'_blank');
			window.focus();
		  
     } 

	 function alltrim(kata){
	 //alert(kata);
		b = (kata.split(' ').join(''));
		c = (b.replace( /\s/g, ""));
		return c
	 
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



<h3>CETAK ANGGARAN KAS SIMPATIK</h3>
<div id="accordion">
    
    <p align="right">         
        <table id="sp2d" title="Cetak" style="width:922px;height:200px;" >  
        <tr >
			<td width="20%" height="40" ><B>Pemutahiran</B></td>
			<td width="80%"><select>
            <option value="">Pemutahiran ke-1</option>
            <option value="">Pemutahiran ke-2</option>
            <option value="">Pemutahiran ke-3</option>
            <option value="">Pemutahiran ke-4</option>
            <option value="">Pemutahiran ke-5</option>
            <option value="">Pemutahiran ke-6</option>
            <option value="">Pemutahiran ke-7</option>
            <option value="">Pemutahiran ke-8</option>
            <option value="">Pemutahiran ke-9</option>
            <option value="">Pemutahiran ke-10</option>
            <option value="">Pemutahiran ke-11</option>
            <option value="">Pemutahiran ke-12</option>
            </select></td>
		</tr>        
         <tr >
			<td width="20%" height="40" ><B>Penandatangan 2</B></td>
			<td width="80%"><input id="ttd2" name="ttd2" style="width: 200px;" />&nbsp;<input id="nama2" name="nama2" style="width: 400px; border:0;" /></td>
		</tr>
		<tr>
            <td width="20%">TANGGAL TTD</td>
            <td><input type="text" id="tgl_ttd" style="width: 100px;" /> </td>
        </td> 
		</tr>        
		<tr>
            <td width="40%" colspan="2">&ensp;&ensp;Ukuran Baris  : &nbsp;<input type="number" id="cell" name="cell" style="width: 50px; border:1" value="1" /> &nbsp;&nbsp;</td>
		</tr>
		<tr >
			<td colspan="2"><a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cek(0);">Cetak</a>
            <a class="easyui-linkbutton" iconCls="icon-pdf" plain="true" onclick="javascript:cek(1);">Cetak PDF</a>
            <a class="easyui-linkbutton" iconCls="icon-excel" plain="true" onclick="javascript:cek(2);">Cetak excel</a>
            <a class="easyui-linkbutton" iconCls="icon-word" plain="true" onclick="javascript:cek(3);">Cetak word</a></td>
		</tr>
		
        </table>                      
    </p> 
    

</div>

</div>

 	
</body>

</html>