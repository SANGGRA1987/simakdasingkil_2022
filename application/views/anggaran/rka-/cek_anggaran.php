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
           url:'<?php echo base_url(); ?>index.php/rka/skpduser',  
           columns:[[  
               {field:'kd_skpd',title:'Kode SKPD',width:100},  
               {field:'nm_skpd',title:'Nama SKPD',width:700}    
           ]],  
           onSelect:function(rowIndex,rowData){
               kd = rowData.kd_skpd;               
               $("#nmskpd").attr("value",rowData.nm_skpd.toUpperCase());                
           }  
       });
     
        $('#fstatus').combogrid({  
           panelWidth:160,  
           idField:'idx',  
           textField:'dstatus',  
           mode:'remote',
           url:'<?php echo base_url(); ?>index.php/rka/load_status_cek_anggaran',  
           columns:[[  
               {field:'dstatus',title:'Status',width:150}                   
           ]],  
           onSelect:function(rowIndex,rowData){
               kdstatus = rowData.idx;        
               
               $(function(){ 
                $('#dg').edatagrid({
		          url: '<?php echo base_url(); ?>/index.php/rka/load_cek_anggaran',
                    queryParams:({kriteria_init:kdstatus, kriteria_skpd:kd})
                });        
               });
                                                    
           }  
       });
	   
        $('#tgldpa').datebox({  
            required:true,
            formatter :function(date){
            	var y = date.getFullYear();
            	var m = date.getMonth()+1;
            	var d = date.getDate();
            	return y+'-'+m+'-'+d;
            },
            onSelect: function(date){
		      jaka = date.getFullYear()+"-"+(date.getMonth()+1)+"-"+date.getDate();
	       }
        });
		
		$('#tgldpasempurna').datebox({  
            required:true,
            formatter :function(date){
            	var y = date.getFullYear();
            	var m = date.getMonth()+1;
            	var d = date.getDate();
            	return y+'-'+m+'-'+d;
            },
            onSelect: function(date){
		      jaka = date.getFullYear()+"-"+(date.getMonth()+1)+"-"+date.getDate();
	       }
        });
		
         $('#tgldppa').datebox({  
            required:true,
            formatter :function(date){
            	var y = date.getFullYear();
            	var m = date.getMonth()+1;
            	var d = date.getDate();
            	return y+'-'+m+'-'+d;
            },
            onSelect: function(date){
		      jaka = date.getFullYear()+"-"+(date.getMonth()+1)+"-"+date.getDate();
	       }
        });
		
		
     $('#dg').edatagrid({
		url: '<?php echo base_url(); ?>/index.php/rka/load_cek_anggaran',
        idField:'id',            
        rownumbers:"true", 
        fitColumns:"true",
        singleSelect:"true",
        autoRowHeight:"false",
        loadMsg:"Tunggu Sebentar....!!",
        nowrap:"true",                       
        rowStyler: function(index,row){
        if (row.status_hasil == 'SAMA'){
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
            {field:'nilai_ang',
            title:'Nilai Anggaran',
            width:2,
            align:"right"},
            {field:'nilai_kas',
            title:'Nilai Perkiraan Kas',
            width:2,
            align:"right"},
            {field:'status_hasil',
            title:'Hasil',
            width:1,
            align:"center"}
        ]],
		
        onSelect:function(rowIndex,rowData){
          ckd_skpd = rowData.kd_skpd;
          csts_dpa = rowData.statu;
          csts_dpa_sempurna = rowData.status_sempurna;
          csts_dppa = rowData.status_ubah;
		  cno_dpa = rowData.no_dpa;
		  cno_dpa_sempurna = rowData.no_dpa_sempurna;
          ctgl_dpa_sempurna = rowData.tgl_dpa_sempurna;
          ctgl_dpa = rowData.tgl_dpa;
          cno_dppa = rowData.no_dpa_ubah;
		  ctgl_dppa = rowData.tgl_dpa_ubah;
          
          lcidx = rowIndex;                           
        },
        onDblClickRow:function(rowIndex,rowData){
           lcidx = rowIndex;
                          
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
  
    function cek($cetak,$jns){
         var ckdskpd = $('#kode').combogrid('getValue');
         var status_ang = $('#fstatus').combogrid('getValue');
         
        url="<?php echo site_url(); ?>/rka/preview_cetakan_cek_anggaran/"+ckdskpd+'/'+$cetak+'/'+status_ang+'/Report-cek-anggaran'
         
        openWindow( url,$jns );
    }
    
    function cek2($cetak,$jns){
         var ckdskpdx = 'seluruh';
         var status_ang = $('#fstatus').combogrid('getValue');
         
        url="<?php echo site_url(); ?>/rka/preview_cetakan_cek_anggaran_seluruh/"+ckdskpdx+'/'+$cetak+'/'+status_ang+'/Report-cek-anggaran'
         
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
<h3 align="center"><u><b><a>CEK NILAI ANGGARAN DAN ANGGARAN KAS</a></b></u></h3>
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
                <td colspan="2">&nbsp;&nbsp;<input type="text" id="nmskpd" style="border:0;width:550px;"/></td>
        </tr> 			
        <tr>
                <td width="10%">Status</td>
                <td width="1%">:</td>
                <td >&nbsp;&nbsp;<input type="text" id="fstatus" style="border:0;width:150px;"/></td>
                <td align="right" style="color: red;">*) Ket Hasil: " SAMA " = Telah Sesuai || " TIDAK " = Belum Sesuai</td>
        </tr>
         <tr>
           <td width="10%">Cetak Laporan</td>
           <td width="1%">:</td>
           <td> 
                    <a class="easyui-linkbutton" plain="true" onclick="javascript:cek(0,'skpd');return false" >
                    <img src="<?php echo base_url(); ?>assets/images/icon/print.png" width="25" height="23" title="preview"/></a>
                    <a class="easyui-linkbutton" plain="true" onclick="javascript:cek(1,'skpd');return false">                    
                    <img src="<?php echo base_url(); ?>assets/images/icon/print_pdf.png" width="25" height="23" title="cetak"/></a>
                    <a class="easyui-linkbutton" plain="true" onclick="javascript:cek(2,'skpd');return false">                    
                    <img src="<?php echo base_url(); ?>assets/images/icon/excel.jpg" width="25" height="23" title="cetak"/></a>
           </td>    
        </tr>
        <tr>
           <td width="10%">Cetak Laporan Keseluruhan</td>
           <td width="1%">:</td>
           <td> 
                    <a class="easyui-linkbutton" plain="true" onclick="javascript:cek2(0,'skpd');return false" >
                    <img src="<?php echo base_url(); ?>assets/images/icon/print.png" width="25" height="23" title="preview"/></a>
                    <a class="easyui-linkbutton" plain="true" onclick="javascript:cek2(1,'skpd');return false">                    
                    <img src="<?php echo base_url(); ?>assets/images/icon/print_pdf.png" width="25" height="23" title="cetak"/></a>
                    <a class="easyui-linkbutton" plain="true" onclick="javascript:cek2(2,'skpd');return false">                    
                    <img src="<?php echo base_url(); ?>assets/images/icon/excel.jpg" width="25" height="23" title="cetak"/></a>
           </td>    
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