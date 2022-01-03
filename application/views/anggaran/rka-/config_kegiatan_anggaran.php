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
        $('#kode').combogrid({  
           panelWidth:700,  
           idField:'kd_skpd',  
           textField:'kd_skpd',  
           mode:'remote',
           url:'<?php echo base_url(); ?>index.php/rka/skpduser_ang',  
           columns:[[  
               {field:'kd_skpd',title:'Kode SKPD',width:100},  
               {field:'nm_skpd',title:'Nama SKPD',width:700}    
           ]],  
           onSelect:function(rowIndex,rowData){
                kd = rowData.kd_skpd;
                nm = rowData.nm_skpd;
                akses = rowData.akses; 
                userx = rowData.id_user;              
               $("#nmskpd").attr("value",rowData.nm_skpd.toUpperCase());
               kdstatus = '1';
                $(function(){ 
                $('#dg').edatagrid({
                  url: '<?php echo base_url(); ?>/index.php/rka/load_konfig_kegiatan_anggaran',
                    queryParams:({kriteria_init:kdstatus, kriteria_skpd:kd})
                });        
               });
                                     
           }  
       });
     
       
       
        
        
        
     $('#dg').edatagrid({
        url: '<?php echo base_url(); ?>/index.php/rka/load_konfig_kegiatan_anggaran',
        idField:'id',            
        rownumbers:"true", 
        fitColumns:"true",
        singleSelect:"true",
        autoRowHeight:"false",
        loadMsg:"Tunggu Sebentar....!!",
        nowrap:"true",                       
        rowStyler: function(index,row){
        if (row.hasil == 'aktif'){
          return 'background-color:#99CCFF;';
        }else{
          return 'background-color:#FF9966;';  
        }
        },
        columns:[[
            {field:'kd_kegiatan',
            title:'Kegiatan',
            width:2,
            align:"left"},
            {field:'nm_kegiatan',
            title:'Nama Kegiatan',
            width:5,
            align:"left"},
            {field:'hasil',
            title:'Hasil',
            width:2,
            align:"center"}
        ]],
        
        onSelect:function(rowIndex,rowData){
          ckd_giat = rowData.kd_kegiatan;
          cnm_giat = rowData.nm_kegiatan;
          cstatus_keg = rowData.status_keg;
          lcidx = rowIndex;                           
        },
        onDblClickRow:function(rowIndex,rowData){
          cstatus_keg = rowData.status_keg;
          ckd_giat = rowData.kd_kegiatan;
          cnm_giat = rowData.nm_kegiatan;
           edit_data(cstatus_keg,ckd_giat,cnm_giat);                
        }
        });     
        
    });        
    
    function addCommas(nStr)
    {
        nStr += '';
        x = nStr.split(',');
        x1 = x[0];
        x2 = x.length > 1 ? ',' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + '.' + '$2');
        }
        return x1 + x2;
    }
    
     function delCommas(nStr)
    {
        nStr += ' ';
        x2 = nStr.length;
        var x=nStr;
        var i=0;
        while (i<x2) {
            x = x.replace(',','');
            i++;
        }
        return x;
    }
  
    
    function edit_data(cstatus_keg,ckd_giat,cnm_giat){
        var stat_keg = cstatus_keg;
        var skpd = kd;
        //alert(skpd);
        if(stat_keg=='1'){
            var set='0';
            var aktf='Non-Aktifkan';
        }else{
            var set='1';
            var aktf='Aktifkan';
        }

         var del=confirm('Anda yakin akan '+aktf+' kegiatan "'+cnm_giat+'"?');
                if  (del==true){
                    $('#dg').edatagrid({
                             url: '<?php echo base_url(); ?>/index.php/rka/tnonaktif_giat/'+skpd+'/'+ckd_giat+'/'+set,
                             idField:'id',
                             toolbar:"#toolbar",              
                             rownumbers:"true", 
                             fitColumns:"true",
                             singleSelect:"true"
                        });
                    alert('Berhasil '+aktf+' Kegiatan  !');
                
                }else{
                    alert(''+aktf+' Kegiatan dibatalkan !');
                }

        } 
 
 function tombolx(){
    
    var cskpd = kd;
    var cnm = nm;
    var cuserx = userx;
    //var skpd2   = document.getElementById('kode').value;
    var cakses = akses;
    if(cakses=='1'){
            var set='0';
            var aktf='Non-Aktifkan';
    }else{
            var set='1';
            var aktf='Aktifkan';
        }
        
        if(cskpd !='1.02.01.00'){
        alert('Untuk Sementara Hanya Dinas Kesehatan yang Bisa Mengaktifkan Menu Inputan !')
    }else{
    
    var del=confirm('Anda yakin akan '+aktf+' Inputan "'+cnm+'"?');
                if  (del==true){
                    $('#dg').edatagrid({
                             url: '<?php echo base_url(); ?>/index.php/rka/tnonaktif_inputan/'+cuserx+'/'+set,
                             idField:'id',
                             toolbar:"#toolbar",              
                             rownumbers:"true", 
                             fitColumns:"true",
                             singleSelect:"true"
                        });
                    alert('Berhasil '+aktf+' Inputan  !');
                
                }else{
                    alert(''+aktf+' Inputan dibatalkan !');
                }
                }
 }
  
   </script>

</head>
<body>

<div id="content"> 
<h3 align="center"><u><b><a>CONFIG KEGIATAN ANGGARAN</a></b></u></h3>
    <div align="center">
    <p align="center">     
    <table style="width:400px;" border="0">
        <tr>
                <td width="10%">SKPD</td>
                <td width="1%">:</td>
                <td colspan="2">&nbsp;&nbsp;<input  type="text" id="kode" style="width:100px;"/></td>                
        </tr>
        <tr>
                <td width="10%">Nama SKPD</td>
                <td width="1%">:</td>
                <td colspan="2">&nbsp;&nbsp;<input type="text" id="nmskpd" style="border:0;width:550px;" readonly="true"/></td>
        </tr>
        <tr>
                <td width="10%">&nbsp;</td>
                <td width="1%">&nbsp;</td>
                <td colspan="2">&nbsp;&nbsp;</td>
        </tr>
         <tr>
                <td width="10%">&nbsp;</td>
                <td width="1%">&nbsp;</td>
                <td colspan="2"><input id="ctk" type="submit" name="submit" value="BUKA TUTUP INPUTAN" onclick="javascript:tombolx();"/></td>
        </tr>

        <tr>
                <td width="10%">&nbsp;</td>
                <td width="1%">&nbsp;</td>
                <td style="color: red;" colspan="2">*>note: "Selama Kegiatan Non Aktif Maka Kegiatan Tak Bisa Digunakan Untuk Transaksi !"</td>
        </tr>           
                
        <tr>
        <td colspan="4">
        <table id="dg" title="LISTING DATA KEGIATAN" style="width:900px;height:500px;" >  
        </table>
        </td>
        </tr>

    </table>    
    
    </p> 
    </div>   
</div>

</body>

</html>