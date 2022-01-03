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
        var bulanx = document.getElementById('bulan_cetak').value;
        var angx = document.getElementById('ang_cetak').value;
         
        url="<?php echo site_url(); ?>/cek_tukd/preview_cek_data_realisasi_sp2d/seluruh/"+$cetak+'/'+bulanx+'/'+angx+'/Report-cek-anggaran-sp2d'
         
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
<h3 align="center"><u><b><a>CEK NILAI ANGGARAN, SP2D DAN REALISASI</a></b></u></h3>
    <div align="center">
    <p align="center">     
    <table style="width:800px;" border="0">
      <tr>
           <td width="20%">&nbsp;</td>
           <td width="1%">&nbsp;</td>
           <td> 
      </tr>
      <tr>
        <td>Pilih Status Anggaran</td>
        <td>:</td>
        <td>
    <select name="ang_cetak" id="ang_cetak" style="height: 27px; width:190px;">    
     <option value="0">...Pilih Anggaran... </option>   
     <option value="nilai">Nilai Murni</option>
     <option value="nilai_sempurna">Nilai Pergeseran</option>
     <option value="nilai_ubah">Nilai Perubahan</option>     
     </select>
    </td>
    </tr>
      <tr>
        <td>Pilih Bulan</td>
        <td>:</td>
        <td>
    <select name="bulan_cetak" id="bulan_cetak" onchange="javascript:validate_skpd();" style="height: 27px; width:190px;">    
     <option value="0">...Pilih Bulan... </option>   
     <option value="1">JANUARI</option>
     <option value="2">FEBRUARI</option>
     <option value="3">MARET</option>
     <option value="4">APRIL</option>
     <option value="5">MEI</option>
     <option value="6">JUNI</option>
     <option value="7">JULI</option>
     <option value="8">AGUSTUS</option>
     <option value="9">SEPTEMBER</option>
     <option value="10">OKTOBER</option>
     <option value="11">NOVEMBER</option>
     <option value="12">DESEMBER</option>
     </select>
 </td>
 </tr>
        <tr>
           <td width="20%">Cetak Laporan</td>
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