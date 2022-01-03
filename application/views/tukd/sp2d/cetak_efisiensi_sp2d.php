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

            $('#dcetak').datebox({  
            required:true,
            formatter :function(date){
              var y = date.getFullYear();
              var m = date.getMonth()+1;
              var d = date.getDate();
              return y+'-'+m+'-'+d;
            }
        }); 
        
        $('#dcetak_ttd').datebox({  
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


$('#ttd').combogrid({  
    panelWidth:500,  
    url: '<?php echo base_url(); ?>/index.php/tukd/load_ttd/BUD',  
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


            $(function(){
      $('#sskpd').combogrid({  
            panelWidth:700,  
            idField:'kd_skpd',  
            textField:'kd_skpd',  
            mode:'remote',
            url:'<?php echo base_url(); ?>index.php/rka/skpduser',  
            columns:[[  
                {field:'kd_skpd',title:'Kode SKPD',width:100},  
                {field:'nm_skpd',title:'Nama SKPD',width:700}    
            ]],
            onSelect:function(rowIndex,rowData){
                skpd = rowData.kd_skpd;
                $("#nm_skpd").attr("value",rowData.nm_skpd);
            }
            });
      });
        });    
     
 


    
    function cek_seluruh($cetak,$jns){
        var jns_pilihan = document.getElementById('jns_pilihan').value;
        var jns_hasil = document.getElementById('jns_hasil').value;
        var dcetak = $('#dcetak').datebox('getValue');      
        var dcetak2 = $('#dcetak2').datebox('getValue');
        var dcetak_ttd = $('#dcetak_ttd').datebox('getValue');      
        var ttd    = nip;                           
            var ttdx =ttd.split(" ").join("a");
         
         if(jns_pilihan=='0'){
            alert('PILIH JENIS PILIHAN TERLEBIH DAHULU !');
         }else
         {
          if(jns_pilihan=='1'){
          var pil='semua';
         }else{
          //alert(pil);
          var pil=skpd;
         }
         url="<?php echo site_url(); ?>/tukd/preview_cetakan_cek_efisiensi_sp2d/"+pil+'/'+$cetak+'/'+jns_pilihan+'/'+jns_hasil+'/'+dcetak+'/'+dcetak2+'/'+dcetak_ttd+'/'+ttdx+'/Report-cek-anggaran'
         
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
<h3 align="center"><u><b><a>CEK EFISIENSI S P 2 D</a></b></u></h3>
    <div align="center">
    <p align="center">     
    <table style="width:800px;" border="0">
      <tr>
           <td width="20%">&nbsp;</td>
           <td width="1%">&nbsp;</td>
           <td> 
      </tr>

      <tr>
        <td>Pilih Jenis</td>
        <td>:</td>
        <td>
    <select name="jns_pilihan" id="jns_pilihan" onchange="javascript:validate_skpd();" style="height: 27px; width:190px;">    
     <option value="0">...Pilih Jenis... </option>   
     <option value="1">CETAK SELURUH SKPD</option>
     <option value="2">CETAK PER-SKPD</option>
     </select>
 </td>
 </tr>
      <tr>
        <td width="20%" height="40" >S K P D</td>
        <td width="1%">:</td>
        <td>&nbsp;&nbsp;<input id="sskpd" name="sskpd" style="width: 100px;border: 0;" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="nm_skpd" name="nm_skpd" readonly="true" style="width: 450px; border:0;" /></td>
     </tr>
     <tr>
        <td>Pilih Hasil</td>
        <td>:</td>
        <td>
    <select name="jns_hasil" id="jns_hasil" onchange="javascript:validate_skpd();" style="height: 27px; width:190px;">       
     <option value="1">CETAK SELURUH</option>
     <option value="2">CETAK EFISIEN</option>
     <option value="2">CETAK NON-EFISIEN</option>
     </select>

     <tr>
      <td width="20%" height="40" >Periode</td>
        <td width="1%">:</td>
      <td>&nbsp;&nbsp;<input id="dcetak" name="dcetak" type="text"  style="width:155px" />&nbsp;&nbsp;s/d&nbsp;&nbsp;<input id="dcetak2" name="dcetak2" type="text"  style="width:155px" /></td>
    </tr>
    <tr>
      <td width="20%" height="40" >Penanda Tangan</td>
        <td width="1%">:</td>
      <td width="80%">&nbsp;&nbsp;<input id="ttd" name="ttd" type="text"  style="width:230px" /></td>
    </tr>
    <tr>            
        <td width="20%" height="40" >TGL TTTD</td>
        <td width="1%">:</td>
        <td>&nbsp;&nbsp;<input id="dcetak_ttd" name="dcetak_ttd" type="text"  style="width:155px" /></td>
        </tr>
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