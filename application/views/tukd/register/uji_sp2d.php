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
    
    var kode = '';
    var giat = '';
    var nomor= '';
    var judul= '';
    var cid = 0;
    var lcidx = 0;
    var lcstatus = '';
                    
     $(document).ready(function() {
            $("#accordion").accordion();            
            $( "#dialog-modal" ).dialog({
            height: 350,
            width: 600,
            modal: true,
            autoOpen:false
        });
        });
    $(document).ready(function() {
            $("#accordion").accordion();            
            $( "#dialog-modalcetak" ).dialog({
            height: 350,
            width: 600,
            modal: true,
            autoOpen:false
        });
        });    
     
     $(function(){  
        
     $('#kode_s').combogrid({  
       panelWidth:500,  
       idField:'kd_skpd',  
       textField:'kd_skpd',  
       mode:'remote',
       url:'<?php echo base_url(); ?>index.php/master/ambil_skpd',  
       columns:[[  
           {field:'kd_skpd',title:'Kode SKPD',width:100},  
           {field:'nm_skpd',title:'Nama SKPD',width:400}    
       ]],  
       onSelect:function(rowIndex,rowData){
           $("#nm_u").attr("value",rowData.nm_skpd.toUpperCase());
          // $("#kode").attr("value",rowData.kd_urusan.toUpperCase()+'.');                
       }  
     });

     $('#ttd').combogrid({  
		panelWidth:500,  
		url: '<?php echo base_url(); ?>/index.php/tukd/load_ttd/BUD',  
			idField:'nip',                    
			textField:'nip',
			mode:'remote',  
			fitColumns:true,  
			columns:[[  
				{field:'nip',title:'NIP',width:60},  
				{field:'nama',title:'NAMA',align:'left',width:100}								
			]],
			onSelect:function(rowIndex,rowData){
				nip = rowData.nip;
				nama = rowData.nama;
				$("#nm_ttd").attr("value",nama.toUpperCase());
			}   
		});

		$('#dsp2d_1').datebox({  
            required:true,
            formatter :function(date){
            	var y = date.getFullYear();
            	var m = date.getMonth()+1;
            	var d = date.getDate();
            	return y+'-'+m+'-'+d;
            }
        });

        $('#dsp2d_2').datebox({  
            required:true,
            formatter :function(date){
            	var y = date.getFullYear();
            	var m = date.getMonth()+1;
            	var d = date.getDate();
            	return y+'-'+m+'-'+d;
            }
        });     
        
        
     $('#dg').edatagrid({
		url: '<?php echo base_url(); ?>/index.php/bud/load_sp2d_Uji',
        idField:'no_uji',            
        rownumbers:"true", 
        fitColumns:"true",
        singleSelect:"true",
        autoRowHeight:"false",
        loadMsg:"Tunggu Sebentar....!!",
        pagination:"true",
        nowrap:"true",                       
        columns:[[
            {title:'',
            width:5,
            checkbox:"true"},
            {field:'no_uji',
    		title:'No Advis Penguji',
    		width:30,
            align:"center"},
    	    {field:'tgl_uji',
    		title:'Tanggal Penguji',
    		width:20,
            align:"center"},
            {field:'nilai',
    		title:'Total Nilai',
    		width:50,align:"center"}
        ]],
        onSelect:function(rowIndex,rowData){
          nouji = rowData.no_uji; 
          $("#nouji").attr("value",nouji);   
          id = rowIndex;  
                                       
        },
        onDblClickRow:function(rowIndex,rowData){
            }      
        });
       
    });        

 
    
    function get(kd_s,kd_u,nm_u) {
        
        $("#kode").attr("value",kd_u);
        $("#kode_s").combogrid("setValue",kd_s);
        $("#nama").attr("value",nm_u);   
                       
    }
       
    function kosong(){
        $("#no_uji").attr("value",'');
        $("#dsp2d_1").datebox("setValue",'');
        $("#dsp2d_2").datebox("setValue",'');
    }
    
    
    function cari(){
    var kriteria = document.getElementById("txtcari").value; 
    $(function(){ 
     $('#dg').edatagrid({
		url: '<?php echo base_url(); ?>/index.php/bud/load_sp2d_Uji',
        queryParams:({cari:kriteria})
        });        
     });
    }
    
       function simpan_uji(){
       
        var cnomor_uji = document.getElementById('no_uji').value;
        var dsp2d1 = $('#dsp2d_1').datebox('getValue');
        var dsp2d2 = $('#dsp2d_2').datebox('getValue');

        if (dsp2d1 > dsp2d2) {
            alert('Tanggal Awal Harus Lebih Kecil !!! ');
            exit();
        }

                
        if (cnomor_uji==''){
            alert('Masukan No Uji Advis !!!');
            exit();
        } 
        if (dsp2d1==''){
            alert('Tanggal Awal Tidak Boleh Kosong');
            exit();
        }
        if (dsp2d2==''){
            alert('Tanggal Awal Tidak Boleh Kosong');
            exit();
        }
        
        if(lcstatus=='tambah'){ 
            
        	$(document).ready(function(){
        		$.ajax({
        			type: "POST",
        			url: '<?php echo base_url(); ?>/index.php/bud/cek_simpan_uji',
        			data: ({nomor:cnomor_uji,tgl1:dsp2d1,tgl2:dsp2d2}),
        			dataType:"json",
        			success:function(data){
        				status = data.pesan;
        				if (status == '1') {
        					alert('Data Penguji Untuk No '+cnomor_uji+' Sudah Terpakai, Silahkan Ganti No Lain !!!');
        					exit();
        				} else {
        					$.ajax({
        						type: "POST",
        						url: '<?php echo base_url(); ?>/index.php/bud/simpan_penguji',
        						data: ({nomor:cnomor_uji,tgl1:dsp2d1,tgl2:dsp2d2}),
        						dataType:"json",
        						success:function(data){

                                    if (data.hasil == '1') {
        							alert('No '+cnomor_uji+' Berhasil Di Simpan !!!');
        							$("#dialog-modal").dialog('close');
        							$('#dg').edatagrid('reload'); 
                                } else {
                                    alert('Data SP2D Tidak Ada !!!');
                                    $('#dg').edatagrid('reload'); 
                                    }

        						}
        					});


        				}
        			}
        		});
        	});   
           
        } else {

        	lcquery = "UPDATE ms_unit SET nm_unit='"+cnama+"',kd_skpd='"+ckode_s+"' where kd_unit='"+ckode+"'";

        	$(document).ready(function(){
        		$.ajax({
        			type: "POST",
        			url: '<?php echo base_url(); ?>/index.php/master/update_master',
        			data: ({st_query:lcquery}),
        			dataType:"json",
        			success:function(data){
        				status = data;
        				if (status=='0'){
        					alert('Gagal Simpan..!!');
        					exit();
        				}else{
        					alert('Data Tersimpan..!!');
        					exit();
        				}
        			}
        		});
        	});


        }

    } 
    
      function edit_data(){
        lcstatus = 'edit';
        judul = 'Edit Data Unit';
        $("#dialog-modal").dialog({ title: judul });
        $("#dialog-modal").dialog('open');
        document.getElementById("kode").disabled=true;
        }

        function cetak(){
            var nom=document.getElementById("nouji").value;
            $("").attr("value",nom);
            $("#dialog-modalcetak").dialog('open');
        }

        function openWindow(url) {
            var ckode = document.getElementById('nouji').value; 
            var ttd = $("#ttd").combogrid("getValue"); 
            window.open(url+'/'+ckode+'/'+ttd+'/daftar_penguji', '_blank');
            window.focus();
        }    
        
    
     function tambah(){
        lcstatus = 'tambah';
        judul = 'Input Data Daftar Penguji';
        $("#dialog-modal").dialog({ title: judul });
        kosong();
        $("#dialog-modal").dialog('open');
        // document.getElementById("kode").disabled=false;
        // document.getElementById("kode").focus();
        } 
     function keluar(){
        $("#dialog-modal").dialog('close');
        $("#dialog-modalcetak").dialog('close');
     }    
    
     function hapus(){
        var ckode = document.getElementById('nouji').value;
        if (ckode == '') {
            alert('Silahkan Pilih No Yang Mau Dihapus !!!');
        } else {

            var urll= '<?php echo base_url(); ?>/index.php/bud/hapus_uji';                             
            if (ckode !=''){
                var del=confirm('Anda yakin akan menghapus No '+ckode+'  ?');
                if  (del==true){
                    $(document).ready(function(){
                        $.post(urll,({nomor:ckode}),function(data){
                            alert('Berhasil Dihapus');
                            $('#dg').edatagrid('reload');    
                        });
                    });
                }
            } else {

                alert('Gagal Dihapus');    
            }
        }
    } 
    
       
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
  
    
  
   </script>

</head>
<body>

<div id="content"> 
<h3 align="center"><u><b><a>INPUT DAFTAR PENGUJI </a></b></u></h3>
    <div align="center">
    <p align="center">     
    <table style="width:100%;" border="0">
        <tr>
	        <td width="10%" colspan="4">
		        <a class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:tambah()">Tambah</a>              
		        <a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetak()">Cetak</a>
                <a class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:hapus();">Hapus</a>
		        <a class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="javascript:cari();">Cari</a>
		        <input type="text" value="" id="txtcari" style="width:300px;"/>
		    </td>               
        </tr>
        <tr>
	        <td colspan="4">
		        <table id="dg" title="LISTING DATA UNIT" style="width:900px;height:440px;" > 
		        </table>
	        </td>
        </tr>
    </table>    
    
        
 
    </p> 
    </div>   
</div>

<div id="dialog-modal" title="">
    <p class="validateTips">Input No Advis Penguji</p> 
    <fieldset>
     <table align="center" style="width:100%;border: none;">
            <tr>
                <td width="30%" style="padding: 15px;">NO ADVICE PENGUJI</td>
                <td width="1%">:</td>
                <td><input type="text" id="no_uji" style="width:243px;" placeholder="Input No Uji Advice" autocomplete="off" /></td>  
            </tr>
            <tr>
                <td width="30%" style="padding: 15px;">PERIODE TANGGAL SP2D</td>
                <td width="1%">:</td>
                <td>
                	<input type="text" id="dsp2d_1" style="width:100px;"/>&nbsp;&nbsp; S/d &nbsp;&nbsp;
                	<input type="text" id="dsp2d_2" style="width:100px;"/>
                </td>  
            </tr>        
            <tr>
            <td colspan="3">&nbsp;</td>
            </tr>            
            <tr>
                <td colspan="3" align="center">
                <a class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:simpan_uji();">Simpan</a>
                <a class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:keluar();">Kembali</a>
                </td>                
            </tr>
        </table>       
    </fieldset>
</div>
<div id="dialog-modalcetak" title="">
    <p class="validateTips">Input No Advis Penguji</p> 
    <fieldset>
     <table align="center" style="width:100%;border: none;">
            <tr>
                <td width="30%" style="padding: 15px;">NO ADVICE PENGUJI</td>
                <td width="1%">:</td>
                <td><input type="text" id="nouji" style="width:243px;" autocomplete="off" readonly="true" /></td>  
            </tr>
            <tr>
                <td width="30%" style="padding: 15px;">TANDA TANGAN</td>
                <td width="1%">:</td>
                <td><input type="text" id="ttd" style="width:200px;"/><input type="text" id="nm_ttd" style="width:243px;" readonly="true" /></td>  
            </tr>         
            <tr>
            <td colspan="3">&nbsp;</td>
            </tr>            
            <tr>
                <td colspan="3" align="center">
                    <a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:openWindow('<?php echo site_url(); ?>/bud/cetak_uji/1');return false;">Cetak Layar</a>
                    <a class="easyui-linkbutton" iconCls="icon-pdf" plain="true" onclick="javascript:openWindow('<?php echo site_url(); ?>/bud/cetak_uji/2');return false;">Cetak PDF</a>
                    <a class="easyui-linkbutton" iconCls="icon-excel" plain="true" onclick="javascript:openWindow('<?php echo site_url(); ?>/bud/cetak_uji/3');return false;">Cetak Excel</a>
                    <a class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:keluar();">Kembali</a>
                </td>                
            </tr>
        </table>       
    </fieldset>
</div>
</body>

</html>