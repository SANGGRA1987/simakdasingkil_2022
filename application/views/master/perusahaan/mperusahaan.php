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
            height: 500,
            width: 700,
            modal: true,
            autoOpen:false
        });
        });    
     
     $(function(){ 
     
     // no_urut();   
     
     $('#nmbank').combogrid({  
       panelWidth:500,  
       idField:'kode',  
       textField:'kode',  
       mode:'remote',
       url:'<?php echo base_url(); ?>index.php/master/ambil_bank',  
       columns:[[  
           {field:'kode',title:'Kode Bank',width:100},  
           {field:'nama',title:'Nama Bank',width:400}    
       ]],  
       onSelect:function(rowIndex,rowData){
           $("#nmbank").attr("value",rowData.kode.toUpperCase());
		   $("#nm_b").attr("value",rowData.nama.toUpperCase());
          // $("#kode").attr("value",rowData.kd_urusan.toUpperCase()+'.');                
       }  
     });
	 
	 $('#dg').edatagrid({
		url: '<?php echo base_url(); ?>/index.php/master/load_perusahaan',
        idField:'id',            
        rownumbers:"true", 
        fitColumns:"true",
        singleSelect:"true",
        autoRowHeight:"false",
        loadMsg:"Tunggu Sebentar....!!",
        pagination:"true",
        nowrap:"true",                       
        columns:[[
			{field:'kd_perusahaan',
    		title:'Kode',
    		width:20,
            align:"left"},
            {field:'nama_perusahaan',
    		title:'Nama',
    		width:30,
            align:"left"},
            {field:'bentuk',
    		title:'Bentuk',
    		width:10,
            align:"center"},
			{field:'alamat',
    		title:'Alamat',
    		width:20,
            align:"left"}
        ]],
        onSelect:function(rowIndex,rowData){
          kd_perusahaan = rowData.kd_perusahaan;
          nm = rowData.nama_perusahaan;
          bent = rowData.bentuk;
          almt = rowData.alamat;
          pim = rowData.pimpinan;
          nmb = rowData.kode;
		  rek = rowData.rekening;
		  npwp = rowData.npwp;
          get(kd_perusahaan,nm,bent,almt,pim,nmb,rek,npwp); 
          lcidx = rowIndex;  
                                       
        },
        onDblClickRow:function(rowIndex,rowData){
           lcidx = rowIndex;
           judul = 'Edit Data Penandatangan'; 
           edit_data();   
        }
        
        });
       
    });        

 
    
    function get(kd_perusahaan,nm,bent,almt,pim,nmb,rek,npwp) {        
        $("#kd_perusahaan").attr("value",kd_perusahaan);
        $("#nm").attr("value",nm); 
        $("#bent").combobox("setValue",bent);
        $("#almt").attr("value",almt);
        $("#pim").attr("value",pim);
        $("#nmbank").combogrid("setValue",nmb);
		$("#rek").attr("value",rek);
		$("#npwp").attr("value",npwp);
		
    }
       
    function kosong(){
        $("#kd_perusahaan").attr("value",'');
        $("#nm").attr("value",''); 
        $("#bent").combobox("setValue",'');
        $("#almt").attr("value",'');
        $("#pim").attr("value",'');
        $("#nm_b").attr("value",'');
        $("#nmb").combogrid("setValue",'');
		$("#rek").attr("value",'');
		$("#npwp").attr("value",'');
		$("#nm_skpd").attr("value",'');
        no_urut();
    }
    
    
    function cari(){
    var kriteria = document.getElementById("txtcari").value; 
    $(function(){ 
     $('#dg').edatagrid({
		url: '<?php echo base_url(); ?>/index.php/master/load_perusahaan',
        queryParams:({cari:kriteria})
        });        
     });
    }

    function no_urut() {
        $.ajax({
            url:'<?php echo base_url(); ?>index.php/master/no_urut',
            type: "POST",
            dataType:"json",                         
            success:function(data){
                nourut = data.no_urutan;
                $("#kd_perusahaan").attr("value",nourut);
            }                                     
        });
    }
    
       function simpan_perusahaan(){
        var ckd_perusahaan = document.getElementById('kd_perusahaan').value;
        var cnm = document.getElementById('nm').value;
        var cbentuk =  $('#bent').combobox('getValue');
        var calmt = document.getElementById('almt').value;
        var cpim = document.getElementById('pim').value;
        var cnmb = $('#nmbank').combogrid('getValue');
		var crek = document.getElementById('rek').value;
		var cnpwp = document.getElementById('npwp').value;
                
        if (ckd_perusahaan==''){
            alert('Kode Perusahaan  Tidak Boleh Kosong');
            exit();
        } 
        if (cnm==''){
            alert('Nama  Tidak Boleh Kosong');
            exit();
        }
        if (cnmb==''){
            alert('Kode  Tidak Boleh Kosong');
            exit();
        }

        
        if(lcstatus=='tambah'){ 
            
            lcinsert = "(kode,nama,bentuk,alamat,pimpinan,bank,rekening,npwp)";
            lcvalues = "('"+ckd_perusahaan+"','"+cnm+"','"+cbentuk+"','"+calmt+"','"+cpim+"','"+cnmb+"','"+crek+"','"+cnpwp+"')";
            
            $(document).ready(function(){
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url(); ?>/index.php/master/simpan_master_perusahaan',
                    data: ({tabel:'ms_perusahaan',kolom:lcinsert,nilai:lcvalues,cid:'kode',lcid:ckd_perusahaan}),
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
            
            lcquery = "UPDATE ms_perusahaan SET nama='"+cnm+"',bentuk='"+cbentuk+"',alamat='"+calmt+"',pimpinan='"+cpim+"',bank='"+cnmb+"',rekening='"+crek+"',npwp='"+cnpwp+"' where kode='"+ckd_perusahaan+"'";

            $(document).ready(function(){
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>/index.php/master/update_master_perusahaan',
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
        judul = 'Edit Data Penandatangan';
        $("#dialog-modal").dialog({ title: judul });
        $("#dialog-modal").dialog('open');
        document.getElementById("kd_perusahaan").disabled=true;
        }    
        
    
     function tambah(){
        lcstatus = 'tambah';
        judul = 'Input Data Penandatangan';
        $("#dialog-modal").dialog({ title: judul });
        kosong();
        $("#dialog-modal").dialog('open');
        document.getElementById("kd_perusahaan").disabled=false;
        document.getElementById("kd_perusahaan").focus();
        } 
     function keluar(){
        $("#dialog-modal").dialog('close');
     }    
    
     function hapus(){
        var ckd_perusahaan = document.getElementById('kd_perusahaan').value;
        
        var urll = '<?php echo base_url(); ?>index.php/master/hapus_master_perusahaan';
        $(document).ready(function(){
         $.post(urll,({tabel:'ms_perusahaan',cnid:ckd_perusahaan,cid:'kode'}),function(data){
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
<h3 align="center"><u><b><a>INPUTAN MASTER PERUSAHAAN</a></b></u></h3>
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
        <table id="dg" title="LISTING DATA PERUSAHAAN" style="width:900px;height:365px;" >  
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
                <td width="30%">KODE PERUSAHAAN</td>
                <td width="1%">:</td>
                <td><input type="text" id="kd_perusahaan" style="width:100px;"/ readonly="true"></td>  
            </tr>            
            <tr>
                <td width="30%">NAMA </td>
                <td width="1%">:</td>
                <td><input type="text" id="nm" style="width:360px;"/></td>  
            </tr>
            
            <tr>
                <td width="30%">ALAMAT </td>
                <td width="1%">:</td>
                <td><input type="text" id="almt" style="width:360px;"/></td>  
            </tr>
			<tr>
                <td width="30%">PIMPINAN </td>
                <td width="1%">:</td>
                <td><input type="text" id="pim" style="width:360px;"/></td>  
            </tr>
            <tr>
                <td width="30%">BANK</td>
                <td width="1%">:</td>
                <td><input type="text" id="nmbank" style="width:100px;"/><input type="text" id="nm_b" style="width:100px;"/></td>  
            </tr> 
            <tr>
                <td width="30%">Bentuk</td>
                <td width="1%">:</td>
                <td><input id="bent" style="width:100px;" class="easyui-combobox" data-options="
            		valueField: 'value',
            		textField: 'label',
            		data: [{
            			label: '',
            			value: ''
            		},{
            			label: 'PT',
            			value: 'PT'
            		},{
            			label: 'CV',
            			value: 'CV'
            		},{
            			label: 'Firma',
            			value: 'Firma'
            		},{
            			label: 'Lain-lain',
            			value: 'Lain-lain'
            		}]"/>
                </td>  
            </tr>
			<tr>
                <td width="30%">Rekening </td>
                <td width="1%">:</td>
                <td><input type="text" id="rek" style="width:360px;"/></td>  
            </tr>
			<tr>
                <td width="30%">NPWP </td>
                <td width="1%">:</td>
                <td><input type="text" id="npwp" style="width:360px;"/></td>  
            </tr>
            
            <tr>
            <td colspan="3">&nbsp;</td>
            </tr>            
            <tr>
                <td colspan="3" align="center"><a class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:simpan_perusahaan();">Simpan</a>
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