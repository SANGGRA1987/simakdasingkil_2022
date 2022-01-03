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
    
    var kdstatus = '';
    var kd = '';
                        
     $(document).ready(function() {
            $("#accordion").accordion();            
            $( "#dialog-modal" ).dialog({
            height: 420,
            width: 600,
            modal: true,
            autoOpen:false
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
                $("#ttd2").attr("value",rowData.nip);
                $("#nama2").attr("value",rowData.nama);
            }  
        });          
     });

    
    function cek_seluruh($cetak,$jns){
       var  ctglttd = $('#tgl_ttd').datebox('getValue');
        var status_triw = document.getElementById('triwulan').value;
        var  ttd2 = $('#ttd2').combogrid('getValue');
        var ttd = ttd2.split(" ").join("x");
        
         if(status_triw=='0'){
          alert('Pilih Triwulan Terlebih Dulu !');
         }else{
         
        url="<?php echo site_url(); ?>/rka/preview_cetak_spd_bud/seluruh/"+$cetak+'/'+status_triw+'/'+ttd+'/'+ctglttd+'/Report-Regis-SPD'
         
        openWindow( url,$jns );
    }
  }
    
 
 function openWindow( url,$jns ){
        
            lc = '';
      window.open(url+lc,'_blank');
      window.focus();
      
     }  
  
   </script>

</head>
<body>

<div id="content"> 
<h3 align="center"><u><b><a>CETAK REKAP SPD</a></b></u></h3>
    <div align="center">
    <p align="center">     
    <table style="width:820px;" border="0">
      <tr>
           <td width="10%">&nbsp;</td>
           <td width="1%">&nbsp;</td>
           <td> 
      </tr>
      <tr>
        <td style="height: 27px; width:290px;">Pilihan Triwulan</td>
        <td>:</td>
        <td>
    <select name="triwulan" id="triwulan" onchange="javascript:validate_skpd();" style="height: 27px; width:290px;">    
     <option value="0">...Pilih Triwulan... </option>   
     <option value="1">TRIWULAN I</option>
     <option value="2">TRIWULAN II</option>
     <option value="3">TRIWULAN III</option>
     <option value="4">TRIWULAN IV</option>
     </select>
 </td>
 </tr>
 <tr>
        <td style="height: 27px; width:290px;">Penandatangan</td>
        <td>: &nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td ><input id="ttd2" name="ttd2" style="width: 250px;" /><input id="nama2" name="nama2" style="width: 290px; border:0;" /></td>
 </tr>
    <tr>
            <td>TANGGAL TTD</td>
            <td>:  </td>
            <td><input type="text" id="tgl_ttd" style="width: 100px;" /> </td>
        </td> 
    </tr>
        <tr>
           <td width="10%">Cetak </td>
           <td width="1%">:</td>
           <td> 
                    <a class="easyui-linkbutton" plain="true" onclick="javascript:cek_seluruh(0,'skpd');return false" >
                    <img src="<?php echo base_url(); ?>assets/images/icon/print.png" width="25" height="23" title="preview"/></a>
                    <a class="easyui-linkbutton" plain="true" onclick="javascript:cek_seluruh(1,'skpd');return false">                    
                    <img src="<?php echo base_url(); ?>assets/images/icon/print_pdf.png" width="25" height="23" title="cetak"/></a>
                    <a class="easyui-linkbutton" plain="true" onclick="javascript:cek_seluruh(2,'skpd');return false">                    
                    <img src="<?php echo base_url(); ?>assets/images/icon/excel.jpg" width="25" height="23" title="cetak"/></a>
           </td>    
        </tr>        
        <tr>
        <td colspan="4">
        </td>
        </tr>

    </table>    
    
    </p> 
    </div>   
</div>

</body>

</html>