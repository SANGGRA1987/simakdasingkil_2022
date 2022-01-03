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
            height: 450,
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
           url:'<?php echo base_url(); ?>index.php/rka/skpd',  
           columns:[[  
               {field:'kd_skpd',title:'Kode SKPD',width:100},  
               {field:'nm_skpd',title:'Nama SKPD',width:700}    
           ]],  
           onSelect:function(rowIndex,rowData){
               kd = rowData.kd_skpd;               
               $("#nmskpd").attr("value",rowData.nm_skpd.toUpperCase());                
           }  
       });
        $('#tglrka').datebox({  
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
		url: '<?php echo base_url(); ?>/index.php/rka/load_pengesahan_dpa',
        idField:'id',            
        rownumbers:"true", 
        fitColumns:"true",
        singleSelect:"true",
        autoRowHeight:"false",
        loadMsg:"Tunggu Sebentar....!!",
        nowrap:"true",                       
        columns:[[
            {field:'kd_skpd',
    		title:'Kode SKPD',
    		width:2,
            align:"center"},
    	    {field:'nm_skpd',
    		title:'Nama SKPD',
    		width:7,
            align:"center"},
            {field:'status_rancangx',
            title:'Rancang',
            width:1,
            align:"center"},
            {field:'statusx',
            title:'Murni',
            width:1,
            align:"center"},
            {field:'status_sempurnax',
            title:'Pergeseran',
            width:1,
            align:"center"},
            {field:'status_ubahx',
            title:'Perubahan',
            width:1,
            align:"center"}
        ]],
		
        onSelect:function(rowIndex,rowData){
          ckd_skpd = rowData.kd_skpd;
          csts_dpa = rowData.statu;
          csts_rka = rowData.status_rancang;
          csts_dpa_sempurna = rowData.status_sempurna;
          csts_dppa = rowData.status_ubah;
		  cno_dpa = rowData.no_dpa;
          cno_rka = rowData.no_dpa;
		  cno_dpa_sempurna = rowData.no_dpa_sempurna;
          ctgl_dpa_sempurna = rowData.tgl_dpa_sempurna;
          ctgl_dpa = rowData.tgl_dpa;
          ctgl_rka = rowData.tgl_dpa_rancang;
          cno_dppa = rowData.no_dpa_ubah;
		  ctgl_dppa = rowData.tgl_dpa_ubah;
          get(ckd_skpd,csts_rka,csts_dpa,csts_dppa,cno_rka,cno_dpa,ctgl_rka,ctgl_dpa,cno_dppa,ctgl_dppa,csts_dpa_sempurna,cno_dpa_sempurna,ctgl_dpa_sempurna); 
          lcidx = rowIndex;                           
        },
        onDblClickRow:function(rowIndex,rowData){
           lcidx = rowIndex;
           judul = 'Edit Pengesahan DPA & DPPA'; 
           edit_data();   
        }
        });		
		
    });        

    function get(ckd_skpd,csts_rka,csts_dpa,csts_dppa,cno_rka,cno_dpa,ctgl_rka,ctgl_dpa,cno_dppa,ctgl_dppa,csts_dpa_sempurna,cno_dpa_sempurna,ctgl_dpa_sempurna){
	
        $("#kode").combogrid("setValue",ckd_skpd);
       
        if (csts_rka==1){            
            $("#stsrka").attr("checked",true);
        } else {
            $("#stsrka").attr("checked",false);
        }

        if (csts_dpa==1){            
            $("#stsdpa").attr("checked",true);
        } else {
            $("#stsdpa").attr("checked",false);
        }
		
		if (csts_dpa_sempurna==1){            
            $("#stsdpasempurna").attr("checked",true);
        } else {
            $("#stsdpasempurna").attr("checked",false);
        }
		
        if (csts_dppa==1){            
            $("#stsdppa").attr("checked",true);
        } else {
            $("#stsdppa").attr("checked",false);
        }			
		
        $("#dpa").attr("value",cno_dpa);
        $("#rkaa").attr("value",cno_rka);
        $("#tgldpa").datebox("setValue",ctgl_dpa);
        $("#tglrka").datebox("setValue",ctgl_rka);
		$("#dpasempurna").attr("value",cno_dpa_sempurna);
        $("#tgldpasempurna").datebox("setValue",ctgl_dpa_sempurna);
        $("#dppa").attr("value",cno_dppa);
        $("#tgldppa").datebox("setValue",ctgl_dppa);			
    }
  
    function kosong(){
        $("#kode").combogrid("setValue",'');
	    $("#nmskpd").attr("value",'')
        $("#stsrka").attr("checked",false);
		$("#stsdpa").attr("checked",false);
		$("#stsdpasempurna").attr("checked",false);
		$("#stsdppa").attr("checked",false);		
        $("#dpa").attr("value",'');
        $("#rkaa").attr("value",'');
        $("#tgldpa").datebox("setValue",'');
        $("#tglrka").datebox("setValue",'');
		$("#dpasempurna").attr("value",'');
        $("#tgldpasempurna").datebox("setValue",'');
        $("#dppa").attr("value",'');
        $("#tgldppa").datebox("setValue",'');
    }
    
    function cari(){
    var kriteria = document.getElementById("txtcari").value; 
    $(function(){ 
     $('#dg').edatagrid({
		url: '<?php echo base_url(); ?>/index.php/rka/load_pengesahan_dpa',
        queryParams:({cari:kriteria})
        });        
     });
    }
	
       function simpan_pengesahan(){
        var ckd = $('#kode').combogrid('getValue');
		var cst1 = document.getElementById('stsdpa').checked;
        if (cst1==false){
           cst1=0;
        }else{
            cst1=1;
        }
        var cst4 = document.getElementById('stsrka').checked;
        if (cst4==false){
           cst4=0;
        }else{
            cst4=1;
        }

		var cst3 = document.getElementById('stsdpasempurna').checked;
        if (cst3==false){
           cst3=0;
        }else{
            cst3=1;
        }
//		alert("add");

		var cst2 = document.getElementById('stsdppa').checked;
        if (cst2==false){
           cst2=0;
        }else{
            cst2=1;
        }

        var ctgl4 = $('#tglrka').datebox('getValue');
        var cno1 = document.getElementById('dpa').value;
		var ctgl1 = $('#tgldpa').datebox('getValue');
		var cno3 = document.getElementById('dpasempurna').value;
		var ctgl3 = $('#tgldpasempurna').datebox('getValue');
        var cno2 = document.getElementById('dppa').value;
        var ctgl2 = $('#tgldppa').datebox('getValue');
        if (ckd==''){
            alert('SKPD Tidak Boleh Kosong');
            exit();
        }
		
            $(document).ready(function(){
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url(); ?>/index.php/rka/simpan_pengesahan',
                    data: ({tabel:'trhrka',kdskpd:ckd,stdpa:cst1,stdppa:cst2,no:cno1,tgl:ctgl1,no2:cno2,tgl2:ctgl2,stsempurna:cst3,no3:cno3,tgl3:ctgl3,strka:cst4,tgl4:ctgl4}),
                    dataType:"json"
                });
            });

        alert("Data Berhasil disimpan");
        $("#dialog-modal").dialog('close');
        $('#dg').edatagrid('reload');
		
    } 
    
      function edit_data(){
        lcstatus = 'edit';
        judul = 'Edit Data Pengesahan DPA & DPPA';
        $("#dialog-modal").dialog({ title: judul });
        $("#dialog-modal").dialog('open');
        document.getElementById("kode").disabled=true;
        }    
		
     function keluar(){
        $("#dialog-modal").dialog('close');
		lcstatus = 'edit';
     }    
	
    function add_data(){
        lcstatus = 'add';
        judul = 'Tambah Data Pengesahan DPA & DPPA';
        $("#dialog-modal").dialog({ title: judul });
        $("#dialog-modal").dialog('open');
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
<h3 align="center"><u><b><a>PENGESAHAN DPA & DPPA</a></b></u></h3>
    <div align="center">
    <p align="center">     
    <table style="width:400px;" border="0">
        <tr>
        <td width="5%"><a class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:add_data();">Tambah</a></td>	
        <td width="5%"><a class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="javascript:cari();">Cari</a></td>
        <td><input type="text" value="" id="txtcari" style="width:300px;"/></td>
        <td style="color: red;">*) Ket : " v " = Telah di Sahkan || " - " = Belum di Sahkan</td>

        </tr>
        <tr>
        <td colspan="4">
        <table id="dg" title="LISTING DATA PENGESAHAN" style="width:900px;height:500px;" >  
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
                <td width="30%">SKPD</td>
                <td width="1%">:</td>
                <td><input  type="text" disabled id="kode" style="width:100px;"/></td>
            </tr>
            <tr>
                <td width="30%">Nama SKPD</td>
                <td width="1%">:</td>
                <td><input type="text" disabled id="nmskpd" style="border:0;width:270px;"/></td>
            </tr> 
			<tr>
            <td width="30%">Pengesahan RKA</td>
            <td width="1%">:</td>
            <td><input type="checkbox" id="stsrka"  onclick="javascript:runEffect();"/></td>
            </tr>
            <tr>
			<td width="30%">Pengesahan DPA</td>
			<td width="1%">:</td>
			<td><input type="checkbox" id="stsdpa"  onclick="javascript:runEffect();"/></td>
			</tr>
			<tr>
			<td width="30%">Pengesahan Pergeseran</td>
			<td width="1%">:</td>
			<td><input type="checkbox" id="stsdpasempurna"  onclick="javascript:runEffect();"/></td>
			</tr>
			<tr>
			<td width="30%">Pengesahan DPPA</td>
			<td width="1%">:</td>
			<td><input type="checkbox" id="stsdppa"  onclick="javascript:runEffect();"/></td>
			</tr>
            <tr>
                <td width="30%">NO. RKA</td>
                <td width="1%">:</td>
                <td><input type="text" id="rkaa" style="width:100px;"/></td>  
            </tr>
            <tr>
                <td width="30%">TGL RKA</td>
                <td width="1%">:</td>
                <td><input type="text" id="tglrka" style="width:100px;"/></td>  
            </tr>
            <tr>
                <td width="30%">NO. DPA</td>
                <td width="1%">:</td>
                <td><input type="text" id="dpa" style="width:100px;"/></td>  
            </tr>
            <tr>
                <td width="30%">TGL DPA</td>
                <td width="1%">:</td>
                <td><input type="text" id="tgldpa" style="width:100px;"/></td>  
            </tr>
			<tr>
                <td width="30%">NO. DPA PERGESERAN</td>
                <td width="1%">:</td>
                <td><input type="text" id="dpasempurna" style="width:100px;"/></td>  
            </tr>
			
            <tr>
                <td width="30%">TGL DPA PERGESERAN</td>
                <td width="1%">:</td>
                <td><input type="text" id="tgldpasempurna" style="width:100px;"/></td>  
            </tr>
            <tr>
                <td width="30%">No. DPPA</td>
                <td width="1%">:</td>
                <td><input type="text" id="dppa" style="width:100px;"/></td> 				
            </tr>
			
            <tr>
                <td width="30%">TGL DPPA</td>
                <td width="1%">:</td>
                <td><input type="text" id="tgldppa" style="width:100px;"/></td>  
            </tr>
			             
            
            <tr>
            <td colspan="5">&nbsp;</td>
            </tr>            
            <tr>
                <td colspan="5" align="center"><a class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:simpan_pengesahan();">Simpan</a>
                <a class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:keluar();">Kembali</a>
                </td>                
            </tr>
        </table>       
    </fieldset>
</div>

</body>

</html>