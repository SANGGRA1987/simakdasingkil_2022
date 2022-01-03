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
	 var kode1 = '';
    var giat = '';
    var nomor= '';
    var judul= '';
    var cid = 0;
    var lcidx = 0;
    var lcstatus = '';
    var kd_k = '';
	
                    
     $(document).ready(function() {
            $("#accordion").accordion();            
            $( "#dialog-modal" ).dialog({
            height: 350,
            width: 650,
            modal: true,
            autoOpen:false
        });
        });    
     
     $(function(){  
        
     $('#kode_p').combogrid({  
       panelWidth:600,  
       idField:'kd_kegiatan',  
       textField:'kd_kegiatan',  
       mode:'remote',
       url:'<?php echo base_url(); ?>index.php/master/ambil_kegiatan2',  
       columns:[[  
           {field:'kd_kegiatan',title:'Kode Kegiatan',width:180},  
           {field:'nm_kegiatan',title:'Nama Kegiatan',width:400}    
       ]],  
       onSelect:function(rowIndex,rowData){
           kd_prog = rowData.kd_kegiatan;
		   
		   //$("#kd_progr").attr("value",rowData.kd_program.toUpperCase());
           $("#nm_u").attr("value",rowData.nm_kegiatan.toUpperCase());

			 muncul();  
           
                          
       }  
     });     
        
        
     $('#dg').edatagrid({
		url: '<?php echo base_url(); ?>/index.php/master/load_subkegiatan_all',
        idField:'id',            
        rownumbers:"true", 
        fitColumns:"true",
        singleSelect:"true",
        autoRowHeight:"false",
        loadMsg:"Tunggu Sebentar....!!",
        pagination:"true",
        nowrap:"true",                       
        columns:[[
            {field:'kd_subkegiatan',
    		title:'Kode SubKegiatan',
    		width:18,
            align:"center"},
    	    {field:'kd_kegiatan',
    		title:'Kode Kegiatan',
    		width:16,
            align:"center"},
            {field:'nm_subkegiatan',
    		title:'Nama SubKegiatan',
    		width:50},
            {field:'jns_kegiatan',
    		title:'Jenis Kegiatan',
    		width:15}
        ]],
        onSelect:function(rowIndex,rowData){
          kd_k = rowData.kd_subkegiatan;
          kd_p = rowData.kd_kegiatan;
          nm_k = rowData.nm_subkegiatan;
          jns = rowData.jns_kegiatan;
          get(kd_k,kd_p,nm_k,jns); 
          lcidx = rowIndex;  
                                       
        },
        onDblClickRow:function(rowIndex,rowData){
           lcidx = rowIndex;
           judul = 'Edit Data Kegiatan'; 
           edit_data();   
        }
        
        });
       
    });        

 
    
    function get(kd_k,kd_p,nm_k,jns) {
        
        $("#kode").attr("value",kd_k);
		$("#kode1").attr("value",kd_k);
        $("#kode_p").combogrid("setValue",kd_p);
        $("#nama").attr("value",nm_k);
        $("#jns_k").combobox("setValue",$.trim(jns));      
                       
    }
       
    function kosong(){
        $("#kode").attr("value",'');
        $("#kode1").attr("value",'');
        $("#kode_p").combogrid("setValue",'');
        $("#nama").attr("value",'');
        $("#jns_k").combobox("setValue",'')
    }
    
    function muncul(){
        var c_prog=kd_prog+'.';
        var c_keg=kd_k
		
        if(lcstatus=='tambah'){ 
            $("#kode").attr("value",c_prog);
        } else {
        $("#kode").attr("value",c_keg);		
        }     
    }
    
    
    function cari(){
    var kriteria = document.getElementById("txtcari").value; 
    $(function(){ 
     $('#dg').edatagrid({
		url: '<?php echo base_url(); ?>/index.php/master/load_subkegiatan_all',
        queryParams:({cari:kriteria})
        });        
     });
    }
    
       function simpan_skpd(){
       
        var ckode = document.getElementById('kode').value;
		 var ckode1 = document.getElementById('kode1').value;
        var ckode_p= $('#kode_p').combogrid('getValue');
        var cnama = document.getElementById('nama').value;
        var cjns = $('#jns_k').combobox('getValue');
                
        if (ckode==''){
            alert('Kode SUBKEGIATAN Tidak Boleh Kosong');
            exit();
        } 
        if (ckode_p==''){
            alert('Kode KEGIATAN Tidak Boleh Kosong');
            exit();
        } 
        if (cnama==''){
            alert('Nama SUBKEGIATAN Tidak Boleh Kosong');
            exit();
        }

        
        if(lcstatus=='tambah'){ 
            
            lcinsert = "(kd_subkegiatan,kd_kegiatan,nm_subkegiatan,jns_kegiatan)";
            lcvalues = "('"+$.trim(ckode)+"','"+$.trim(ckode_p)+"','"+$.trim(cnama)+"','"+$.trim(cjns)+"')";
            
            $(document).ready(function(){
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url(); ?>/index.php/master/simpan_master',
                    data: ({tabel:'m_sub_giat',kolom:lcinsert,nilai:lcvalues,cid:'kd_subkegiatan',lcid:ckode}),
                    dataType:"json",
                    success:function(data){
                        status = data;
                        if (status=='0'){
                            alert('Gagal Simpan..!!');
                            exit();
                        }else if(status=='1'){
                            alert('Data Sudah Ada..!!');
                            exit();
                        }else{
                            alert('Data Tersimpan..!!');
                            exit();
                        }
                    }
                });
            });   
           
        } else{
           


		   
            lcquery = "update_kegiatan_anggaran '"+$.trim(ckode1)+"','"+$.trim(ckode)+"','"+$.trim(ckode_p)+"','"+$.trim(cjns)+"','"+$.trim(cnama)+"'";
			
            $(document).ready(function(){
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>/index.php/master/update_master2',
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
        
        
       
        $("#dialog-modal").dialog('close');
        $('#dg').edatagrid('reload'); 

    } 
    
      function edit_data(){
        lcstatus = 'edit';
        judul = 'Edit Data Kegiatan';
        $("#dialog-modal").dialog({ title: judul });
        $("#dialog-modal").dialog('open');
		document.getElementById("kode").focus();
		//document.getElementById("kode").disabled=true;
		//$("#kode").attr("disabled");
		var ckode = document.getElementById('kode').value;
		 var ckode1 = document.getElementById('kode1').value;
        var ckode_p= $('#kode_p').combogrid('getValue');
        var cnama = document.getElementById('nama').value;

		
		if (ckode_p.substring(0, 10)=='0.00.00.00'){
		$("#kode_p").combogrid("disable"); 		
		$("#kode").attr('disabled',true);

		}else
	  {
  $("#kode_p").combogrid("enable"); 		
		$("#kode").attr('disabled',false);

		  
	  }
		tombol(1);
        }    
        
    
     function tambah(){
        lcstatus = 'tambah';
        judul = 'Input Data Kegiatan';
        $("#dialog-modal").dialog({ title: judul });
        kosong();
        $("#dialog-modal").dialog('open');
        document.getElementById("kode").disabled=false;
        $("#kode_p").combogrid("enable");
		document.getElementById("kode_p").focus();
		tombol(0);

        
		} 
		
     function keluar(){
        $("#dialog-modal").dialog('close');
        lcstatus = 'edit';
     }    
    
     function hapus(){
        var ckode = document.getElementById('kode').value;
//		cek data
			$(document).ready(function(){
               // alert(csql);
                $.ajax({
                    type: "POST",   
                    dataType : 'json',                 
                    data: ({no:ckode,tabel:'trskpd',field:'kd_subkegiatan'}),
                    url: '<?php echo base_url(); ?>/index.php/rka/cek_data',
                    success:function(data){                        
                        status_cek = data.pesan;
						if(status_cek==1 ){
						alert("Kode Kegiatan Telah Dipakai dan tidak bisa di Hapus!");
						exit();
						}
						
						if(status_cek==0 ){

								var urll = '<?php echo base_url(); ?>index.php/master/hapus_master';
								$(document).ready(function(){
								 $.post(urll,({tabel:'m_sub_giat',cnid:ckode,cid:'kd_subkegiatan'}),function(data){
									status = data;
									if (status=='0'){
										alert('Gagal Hapus..!!');
										exit();
									} else {
										$('#dg').datagrid('deleteRow',lcidx);   
										alert('Data Berhasil Dihapus..!!');	 	
										 $("#dialog-modal").dialog('close');
										exit();
									}
								 });
								});

						}		
					}
				});
	});
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
      
    function tombol(tanda_tox){  
     if (tanda_tox==1){
	 $('#save').linkbutton('enable');
     $('#del').linkbutton('enable');
	 } else
	 {
	 $('#save').linkbutton('enable');
     $('#del').linkbutton('disable');
		 
	 }		 
    }
      function print_layar(){  
		url = '<?php echo base_url(); ?>index.php/master/cetak_kegiatan';
		window.open(url,'_blank');
        window.focus();	  
    }
    
  
   </script>

</head>
<body>

<div id="content"> 
<h3 align="center"><u><b><a>INPUTAN MASTER SUBKEGIATAN</a></b></u></h3>
    <div align="center">
    <p align="center">     
    <table style="width:400px;" border="0">
        <tr>
        <td width="10%">
        <a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:print_layar()">Print</a>
        <a class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:tambah()">Tambah</a></td>               
        
        <td width="5%"><a class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="javascript:cari();">Cari</a></td>
        <td><input type="text" value="" id="txtcari" style="width:300px;"/></td>
        </tr>
        <tr>
        <td colspan="4">
        <table id="dg" title="LISTING DATA SUBKEGIATAN" style="width:900px;height:440px;" >  
        </table>
        </td>
        </tr>
    </table>    
 
    </p> 
    </div>   
</div>

<div id="dialog-modal" title="">
    <p class="validateTips">Semua Inputan Harus Di Isi.</p> 
    <fieldset>
     <table align="center" style="width:100%;" border="0">
            <tr>
                <td width="30%">KODE KEGIATAN</td>
                <td width="1%">:</td>
                <td><input type="text" id="kode_p" readonly="true" style="width:180px;"/></td>  
            </tr>
            <tr>
                <td width="30%">NAMA KEGIATAN</td>
                <td width="1%">:</td>
                <td><input type="text" readonly="true" id="nm_u" style="width:350px;"/></td>  
            </tr> 
           <tr>
                <td width="30%">KODE SUBKEGIATAN</td>
                <td width="1%">:</td>
                <td><input type="text" enable="true" id="kode" style="width:180px;"/><input type="text" enable="true" id="kode1" style="width:130px;" hidden /></td>  
            </tr>
                       
            <tr>
                <td width="30%">NAMA SUBKEGIATAN</td>
                <td width="1%">:</td>
                <td><textarea name="nama" id="nama" enable="true" cols="50" rows="1" ></textarea></td>  
            </tr>
            <tr>
                <td width="30%">JENIS</td>
                <td width="1%">:</td>
                <td><input id="jns_k" style="width:250px;" class="easyui-combobox" data-options="
            		valueField: 'value',
            		textField: 'label',
            		data: [{
            			label: '',
            			value: ''
            		},{
            			label: 'PENDAPATAN',
            			value: '4'
            		},{
            			label: 'BELANJA TIDAK LANGSUNG',
            			value: '51'
            		},{
            			label: 'BELANJA LANGSUNG',
            			value: '52'
            		}]"/>
                </td>  
                
            </tr>
            
            <tr>
            <td colspan="3">&nbsp;</td>
            </tr>            
            <tr>
                <td colspan="3" align="center"><a id="save" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:simpan_skpd(); $('#dg').edatagrid('reload'); ">Simpan</a>
		        <a id ="del" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:hapus();">Hapus</a>
                <a id="back" class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:keluar();">Kembali</a>
                </td>                
            </tr>
        </table>       
    </fieldset>
</div>

</body>

</html>