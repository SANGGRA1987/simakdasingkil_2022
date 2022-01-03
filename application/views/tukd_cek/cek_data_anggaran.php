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
     
 


    
    function cek_seluruh($cetak,$jns){
        var status_ang = document.getElementById('jns_anggaran').value;
         //var status_ang = '3';
         
        url="<?php echo site_url(); ?>/cek_tukd/preview_cetakan_cek_data_anggaran/seluruh/"+$cetak+'/'+status_ang+'/Report-cek-anggaran'
         
        openWindow( url,$jns );
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
<h3 align="center"><u><b><a>CEK NILAI ANGGARAN DAN REALISASI</a></b></u></h3>
    <div align="center">
    <p align="center">     
    <table style="width:800px;" border="0">
      <tr>
           <td width="20%">&nbsp;</td>
           <td width="1%">&nbsp;</td>
           <td> 
      </tr>
      <tr>
        <td>Pilih Jenis Anggaran</td>
        <td>:</td>
        <td>
    <select name="jns_anggaran" id="jns_anggaran" onchange="javascript:validate_skpd();" style="height: 27px; width:190px;">    
     <option value="0">...Pilih Jenis... </option>   
     <option value="1">NILAI MURNI</option>
     <option value="2">NILAI PERGESERAN</option>
     <option value="3">NILAI PERUBAHAN</option>
     </select>
 </td>
 </tr>
        <tr>
           <td width="20%">Cetak Laporan Realisasi</td>
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