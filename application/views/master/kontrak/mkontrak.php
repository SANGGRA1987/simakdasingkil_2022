<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>   
   
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>easyui/themes/default/easyui.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>easyui/themes/icon.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>easyui/demo/demo.css"/>
	<script type="text/javascript" src="<?php echo base_url(); ?>easyui/jquery-1.8.0.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>easyui/jquery.easyui.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>easyui/jquery.edatagrid.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/autoCurrency.js"></script>    
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/numberFormat.js"></script>
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
            height: 600,
            width: 700,
            modal: true,
            autoOpen:false
        });
        });    
     
     $(function(){ 
        
     $('#usaha').combogrid({  
       panelWidth:700,  
       idField:'kd_perusahaan',  
       textField:'kd_perusahaan',  
       mode:'remote',
       url:'<?php echo base_url(); ?>index.php/master/ambil_perusahaan',  
       columns:[[  
           {field:'kd_perusahaan',title:'Kode',width:100},  
           {field:'nama_perusahaan',title:'Nama',width:200},
		   {field:'alamat',title:'Alamat',width:200},
		   {field:'pimpinan',title:'Pimpinan',width:200}	   
       ]],  
       onSelect:function(rowIndex,rowData){
           $("#nm_nm").attr("value",rowData.nama_perusahaan.toUpperCase());
		   $("#nm_b").attr("value",rowData.bentuk.toUpperCase());
		   $("#nm_a").attr("value",rowData.alamat.toUpperCase());
		   $("#nm_p").attr("value",rowData.pimpinan.toUpperCase());
		   $("#nm_k").attr("value",rowData.kode.toUpperCase());
		   $("#nm_r").attr("value",rowData.rekening.toUpperCase());
           $("#nm_n").attr("value",rowData.npwp.toUpperCase());
		   $("#kd_skpd").attr("value",rowData.kd_skpd.toUpperCase());
		   $("#nm_skpd").attr("value",rowData.nm_skpd.toUpperCase());
		   get_subkegiatan();
		} 
		 
     }); 
     
     $('#dg').edatagrid({
		url: '<?php echo base_url(); ?>/index.php/master/load_kontrak',
        idField:'id',            
        rownumbers:"true", 
        fitColumns:"true",
        singleSelect:"true",
        autoRowHeight:"false",
        loadMsg:"Tunggu Sebentar....!!",
        pagination:"true",
        nowrap:"true",                       
        columns:[[
    	    {field:'no_kontrak',
    		title:'No Kontrak',
    		width:20,
            align:"left"},
            {field:'kd_subkegiatan',
    		title:'Kode Subkegiatan',
    		width:10,
            align:"left"},
            {field:'nama_proyek',
    		title:'Nama Proyek',
    		width:30,
            align:"left"},
            {field:'lokasi',
    		title:'Lokasi',
    		width:10,
            align:"left"},
			{field:'nilai_kontrak',
    		title:'Nilai Kontrak',
    		width:15,
            align:"right"}
        ]],
        onSelect:function(rowIndex,rowData){
			no_kontrak = rowData.no_kontrak;
			kp = rowData.kd_perusahaan;
			kg = rowData.kd_subkegiatan;
			np = rowData.nama_proyek;
			lokasi = rowData.lokasi;
			nikon = rowData.nilai_kontrak;
			cnama_perus = rowData.nama_perusahaan;
			cbent = rowData.bentuk;
			calamat = rowData.alamat;
			cpimp = rowData.pimpinan;
			ckode = rowData.kode;
			crek = rowData.rekening;
			cnpwp = rowData.npwp;
			ckdskpd = rowData.kd_skpd;
			cnmskpd = rowData.nm_skpd;
          get(no_kontrak,kp,kg,np,lokasi,nikon,cnama_perus,cbent,calamat,cpimp,ckode,crek,cnpwp,ckdskpd,cnmskpd); 
          lcidx = rowIndex;  
                                       
        },
        onDblClickRow:function(rowIndex,rowData){
           lcidx = rowIndex;
           judul = 'Edit Master PENANDATANGAN'; 
           edit_data();   
        }
        
        });
       
    });        
	
	function get_subkegiatan(){
		var ckd_skpd = document.getElementById('kd_skpd').value;
		$('#kgiat').combogrid({  
		   panelWidth:650,  
		   idField:'kd_subkegiatan',  
		   textField:'kd_subkegiatan',  
		   mode:'remote',
		   url:'<?php echo base_url(); ?>index.php/master/ambil_kegiatan_kontrak',
		   data: ({lc_kdskpd:ckd_skpd}),  
		   columns:[[  
			   {field:'kd_subkegiatan',title:'Kode Subkegiatan',width:150},  
			   {field:'nm_subkegiatan',title:'Nama Subkegiatan',width:500}    
		   ]],  
		   onSelect:function(rowIndex,rowData){
			   $("#nm_keg").attr("value",rowData.nm_subkegiatan.toUpperCase());              
		   }  
		 });
	}
 
    
    function get(no_kontrak,kp,kg,np,lokasi,nikon,cnama_perus,cbent,calamat,cpimp,ckode,crek,cnpwp,ckdskpd,cnmskpd) {        
        $("#no_kontrak").attr("value",no_kontrak);
		$("#kp").combobox("setValue",kp);
        $("#kg").combobox("setValue",kg); 
        $("#np").attr("value",np);
        $("#lokasi").attr("value",lokasi);
        $("#nikon").attr("setValue",nikon);		
		$("#nm_nm").attr("value",cnama_perus);
		$("#nm_b").attr("value",cbent);
		$("#nm_a").attr("value",calamat);
		$("#nm_p").attr("value",cpimp);
		$("#nm_k").attr("value",ckode);
		$("#nm_r").attr("value",crek);
		$("#nm_n").attr("value",cnpwp);
		$("#kd_skpd").attr("value",ckdskpd);
		$("#nm_skpd").attr("value",cnmskpd);
		
    }
       
    function kosong(){
        $("#no_kontrak").attr("value",'');
		$("#kp").combobox("setValue",'');
		$("#nm_nm").attr("value",'');
		$("#nm_b").attr("value",'');
		$("#nm_a").attr("value",'');
		$("#nm_p").attr("value",'');
		$("#nm_k").attr("value",'');
		$("#nm_r").attr("value",'');
		$("#nm_n").attr("value",'');
        $("#kg").combobox("setValue",'');
		$("#nm_keg").attr("value",'');
        $("#np").attr("value",'');
        $("#lokasi").attr("value",'');
        $("#nikon").attr("value",'');
		$("#kd_skpd").attr("value",'');
		$("#nm_skpd").attr("value",'');
    }
    
    
    function cari(){
    var kriteria = document.getElementById("txtcari").value; 
    $(function(){ 
     $('#dg').edatagrid({
		url: '<?php echo base_url(); ?>/index.php/master/load_kontrak',
        queryParams:({cari:kriteria})
        });        
     });
    }
    
    function simpan_kontrak(){
        var cno_kontrak = document.getElementById('no_kontrak').value;
        var ckp =  $('#usaha').combogrid('getValue');
        var ckg = $('#kgiat').combobox('getValue');
		var cnp = document.getElementById('np').value;
		var clokasi = document.getElementById('lokasi').value;
		var cnikon = angka(document.getElementById('nikon').value);
		
        if (cno_kontrak==''){
            alert('Nomor Kontrak  Tidak Boleh Kosong');
            exit();
        } 
        if (cnp==''){
            alert('Nama Proyek Tidak Boleh Kosong');
            exit();
        }
        if (cnikon==''){
            alert('Nilai Kontrak Tidak Boleh Kosong');
            exit();
        }

        
        if(lcstatus=='tambah'){ 
            
            lcinsert = "(no_kontrak,kd_perusahaan,kd_subkegiatan,nama_proyek,lokasi,nilai_kontrak)";
            lcvalues = "('"+cno_kontrak+"','"+ckp+"','"+ckg+"','"+cnp+"','"+clokasi+"','"+cnikon+"')";
            
            $(document).ready(function(){
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url(); ?>/index.php/master/simpan_master_kontrak',
                    data: ({tabel:'ms_kontrak',kolom:lcinsert,nilai:lcvalues,cid:'no_kontrak',lcid:cno_kontrak}),
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
           
        } else {
            
            lcquery = "UPDATE ms_kontrak SET kd_perusahaan='"+ckp+"',kd_subkegiatan='"+ckg+"',nama_proyek='"+cnp+"',lokasi='"+clokasi+"',nilai_kontrak='"+cnikon+"' where no_kontrak='"+cno_kontrak+"'";

            $(document).ready(function(){
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>/index.php/master/update_master_kontrak',
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
        
        alert("Data Berhasil disimpan");
        $("#dialog-modal").dialog('close');
        $('#dg').edatagrid('reload'); 

    } 
    
      function edit_data(){
        lcstatus = 'edit';
        judul = 'Edit Data Kontrak';
        $("#dialog-modal").dialog({ title: judul });
        $("#dialog-modal").dialog('open');
        document.getElementById("no_kontrak").disabled=true;
        }    
        
    
     function tambah(){
        lcstatus = 'tambah';
        judul = 'Input Data Kontrak';
        $("#dialog-modal").dialog({ title: judul });
        kosong();
        $("#dialog-modal").dialog('open');
        document.getElementById("no_kontrak").disabled=false;
        document.getElementById("no_kontrak").focus();
        } 
		
     function keluar(){
        $("#dialog-modal").dialog('close');
     }    
    
     function hapus(){
        var cno_kontrak = document.getElementById('no_kontrak').value;
        
        var urll = '<?php echo base_url(); ?>index.php/master/hapus_master_kontrak';
        $(document).ready(function(){
         $.post(urll,({tabel:'ms_kontrak',cnid:cno_kontrak,cid:'no_kontrak'}),function(data){
            status = data;
            if (status=='0'){
                alert('Gagal Hapus..!!');
                exit();
            } else {
                $('#dg').datagrid('deleteRow',lcidx);   
                alert('Data Berhasil Dihapus..!!');
                exit();
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
  
    
  
   </script>

</head>
<body>

<div id="content"> 
<h3 align="center"><u><b><a>INPUTAN MASTER KONTRAK</a></b></u></h3>
    <div align="center">
    <p align="center">     
    <table style="width:400px;" border="0">
        <tr>
        <td width="10%">
        <a class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:tambah()">Tambah</a></td>               
        
        <td width="5%"><a class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="javascript:cari();">Cari</a></td>
        <td><input type="text" value="" id="txtcari" style="width:300px;"/></td>
        </tr>
        <tr>
        <td colspan="4">
        <table id="dg" title="LISTING DATA KONTRAK" style="width:900px;height:365px;" >  
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
                <td width="30%">NO KONTRAK</td>
                <td width="1%">:</td>
                <td><input type="text" id="no_kontrak" style="width:360px;"/></td>  
            </tr>            
            <tr>
                <td width="30%">KODE PERUSAHAAN </td>
                <td width="1%">:</td>
                <td><input type="text" id="usaha" style="width:300px;"/></td>  
            </tr>
			<tr>
                <td width="30%">NAMA PERUSAHAAN</td>
                <td width="1%"></td>
                <td><input type="text" id="nm_nm" style="width:360px;" disabled/></td>  
            </tr>
			<tr>
                <td width="30%">BENTUK</td>
                <td width="1%"></td>
                <td><input type="text" id="nm_b" style="width:360px;" disabled/></td>  
            </tr>
			<tr>
                <td width="30%">ALAMAT</td>
                <td width="1%"></td>
                <td><input type="text" id="nm_a" style="width:360px;" disabled/></td>  
            </tr>
			<tr>
                <td width="30%">PIMPINAN</td>
                <td width="1%"></td>
                <td><input type="text" id="nm_p" style="width:360px;" disabled/></td>  
            </tr>
			<tr>
                <td width="30%">KODE BANK</td>
                <td width="1%"></td>
                <td><input type="text" id="nm_k" style="width:360px;" disabled/></td>  
            </tr>
			<tr>
                <td width="30%">REKENING</td>
                <td width="1%"></td>
                <td><input type="text" id="nm_r" style="width:360px;" disabled/></td>  
            </tr>
			<tr>
                <td width="30%">NPWP</td>
                <td width="1%"></td>
                <td><input type="text" id="nm_n" style="width:360px;" disabled/></td>  
            </tr>
			<tr>
                <td width="30%">KODE SKPD</td>
                <td width="1%"></td>
                <td><input type="text" id="kd_skpd" style="width:360px;" disabled/></td>  
            </tr>
			<tr>
                <td width="30%"></td>
                <td width="1%"></td>
                <td><input type="text" id="nm_skpd" style="width:360px;" disabled/></td>  
            </tr>
            <tr>
                <td width="30%">KODE SUBKEGIATAN</td>
                <td width="1%">:</td>
                <td><input type="text" id="kgiat" style="width:150px;"/></td>  
            </tr> 
            <tr>
                <td width="30%">NAMA KEGIATAN</td>
                <td width="1%"></td>
                <td><input type="text" id="nm_keg" style="width:360px;"/></td>  
            </tr> 
            
			<tr>
                <td width="30%">NAMA PROYEK </td>
                <td width="1%">:</td>
                <td><input type="text" id="np" style="width:360px;"/></td>  
            </tr>
			<tr>
                <td width="30%">LOKASI </td>
                <td width="1%">:</td>
                <td><input type="text" id="lokasi" style="width:360px;"/></td>  
            </tr>
			<tr>
                <td width="30%">NILAI KONTRAK </td>
                <td width="1%">:</td>
                <td><input type="text" id="nikon" style="width:150px;" onkeypress="return(currencyFormat(this,',','.',event))"/></td>  
            </tr>
            
            <tr>
            <td colspan="3">&nbsp;</td>
            </tr>            
            <tr>
                <td colspan="3" align="center"><a class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:simpan_kontrak();">Simpan</a>
		        <a class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:hapus();">Hapus</a>
                <a class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:keluar();">Kembali</a>
                </td>                
            </tr>
        </table>       
    </fieldset>
</div>

<!---->
</body>

</html>