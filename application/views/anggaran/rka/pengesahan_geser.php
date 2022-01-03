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
            height: 600,
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
        $('#tgl_geser1').datebox({  
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
        
	   
        $('#tgl_geser2').datebox({  
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
		
		$('#tgl_geser3').datebox({  
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

        $('#tgl_geser4').datebox({  
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
		
         $('#tgl_geser5').datebox({  
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
         $('#tgl_geser6').datebox({  
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
         $('#tgl_geser7').datebox({  
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
         $('#tgl_geser8').datebox({  
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
    		width:1,
            hidden:true,
            align:"center"},
    	    {field:'nm_skpd',
    		title:'Nama SKPD',
    		width:6,
            align:"left"},
            {field:'status_geser1',
            title:'Geser1',
            width:1,
            align:"center"},
            {field:'status_geser2',
            title:'Geser2',
            width:1,
            align:"center"},
            {field:'status_geser3',
            title:'Geser3',
            width:1,
            align:"center"},
            {field:'status_geser4',
            title:'Geser4',
            width:1,
            align:"center"},
            {field:'status_geser5',
            title:'Geser5',
            width:1,
            align:"center"},
            {field:'status_geser6',
            title:'Geser6',
            width:1,
            align:"center"},
            {field:'status_geser7',
            title:'Geser7',
            width:1,
            align:"center"},
            {field:'status_geser8',
            title:'Geser8',
            width:1,
            align:"center"}
        ]],
		
        onSelect:function(rowIndex,rowData){
          ckd_skpd = rowData.kd_skpd;

          status_geser1=rowData.status_geser1;
          status_geser2=rowData.status_geser2;
          status_geser3=rowData.status_geser3;
          status_geser4=rowData.status_geser4;
          status_geser5=rowData.status_geser5;
          status_geser6=rowData.status_geser6;
          status_geser7=rowData.status_geser7;
          status_geser8=rowData.status_geser8;

          no_geser1=rowData.no_geser1;
          no_geser2=rowData.no_geser2;
          no_geser3=rowData.no_geser3;
          no_geser4=rowData.no_geser4;
          no_geser5=rowData.no_geser5;
          no_geser6=rowData.no_geser6;
          no_geser7=rowData.no_geser7;
          no_geser8=rowData.no_geser8;

          tgl_geser1=rowData.tgl_geser1;
          tgl_geser2=rowData.tgl_geser2;
          tgl_geser3=rowData.tgl_geser3;
          tgl_geser4=rowData.tgl_geser4;
          tgl_geser5=rowData.tgl_geser5;
          tgl_geser6=rowData.tgl_geser6;
          tgl_geser7=rowData.tgl_geser7;
          tgl_geser8=rowData.tgl_geser8;
          //alert(status_geser1);
          get(ckd_skpd,
            status_geser1,
            status_geser2,
            status_geser3,
            status_geser4,
            status_geser5,
            status_geser6,
            status_geser7,
            status_geser8,
            no_geser1,
            no_geser2,
            no_geser3,
            no_geser4,
            no_geser5,
            no_geser6,
            no_geser7,
            no_geser8,
            tgl_geser1,
            tgl_geser2,
            tgl_geser3,
            tgl_geser4,
            tgl_geser5,
            tgl_geser6,
            tgl_geser7,
            tgl_geser8); 
          lcidx = rowIndex;                           
        },
        onDblClickRow:function(rowIndex,rowData){
           lcidx = rowIndex;
           judul = 'Edit Pengesahan DPA & DPPA'; 
           edit_data();   
        }
        });		
		
    });        

    function get(ckd_skpd,
            status_geser1,
            status_geser2,
            status_geser3,
            status_geser4,
            status_geser5,
            status_geser6,
            status_geser7,
            status_geser8,
            no_geser1,
            no_geser2,
            no_geser3,
            no_geser4,
            no_geser5,
            no_geser6,
            no_geser7,
            no_geser8,
            tgl_geser1,
            tgl_geser2,
            tgl_geser3,
            tgl_geser4,
            tgl_geser5,
            tgl_geser6,
            tgl_geser7,
            tgl_geser8)
    {
	
        $("#kode").combogrid("setValue",ckd_skpd);
       
        if (status_geser1=='v'){            
            $("#status_geser1").attr("checked",true);
            document.getElementById('status_geser1').disabled = true;
        } else {
            $("#status_geser1").attr("checked",false);
            document.getElementById('status_geser1').disabled = false;
        }

        if (status_geser2=='v'){            
            $("#status_geser2").attr("checked",true);
            document.getElementById('status_geser2').disabled = true;
        } else {
            $("#status_geser2").attr("checked",false);
            document.getElementById('status_geser2').disabled = false;
        }

        if (status_geser3=='v'){            
            $("#status_geser3").attr("checked",true);
            document.getElementById('status_geser3').disabled = true;
        } else {
            $("#status_geser3").attr("checked",false);
            document.getElementById('status_geser3').disabled = false;
        }   

        if (status_geser4=='v'){            
            $("#status_geser4").attr("checked",true);
            document.getElementById('status_geser4').disabled = true;
        } else {
            $("#status_geser4").attr("checked",false);
            document.getElementById('status_geser4').disabled = false;
        }

        if (status_geser5=='v'){            
            $("#status_geser5").attr("checked",true);
            document.getElementById('status_geser5').disabled = true;
        } else {
            $("#status_geser5").attr("checked",false);
            document.getElementById('status_geser5').disabled = false;
        }

        if (status_geser6=='v'){            
            $("#status_geser6").attr("checked",true);
            document.getElementById('status_geser6').disabled = true;
        } else {
            $("#status_geser6").attr("checked",false);
            document.getElementById('status_geser6').disabled = false;
        }

        if (status_geser7=='v'){            
            $("#status_geser7").attr("checked",true);
            document.getElementById('status_geser7').disabled = true;
        } else {
            $("#status_geser7").attr("checked",false);
            document.getElementById('status_geser7').disabled = false;
        }

        if (status_geser8=='v'){            
            $("#status_geser8").attr("checked",true);
            document.getElementById('status_geser8').disabled = true;
        } else {
            $("#status_geser8").attr("checked",false);
            document.getElementById('status_geser8').disabled = false;
        }


        $("#no_geser1").attr("value",no_geser1);
        $("#no_geser2").attr("value",no_geser2);
        $("#no_geser3").attr("value",no_geser3);
        $("#no_geser4").attr("value",no_geser4);
        $("#no_geser5").attr("value",no_geser5);
        $("#no_geser6").attr("value",no_geser6);
        $("#no_geser7").attr("value",no_geser7);
        $("#no_geser8").attr("value",no_geser8);

        $("#tgl_geser1").datebox("setValue",tgl_geser1);
        $("#tgl_geser2").datebox("setValue",tgl_geser2);
        $("#tgl_geser3").datebox("setValue",tgl_geser3);
        $("#tgl_geser4").datebox("setValue",tgl_geser4);
        $("#tgl_geser5").datebox("setValue",tgl_geser5);
        $("#tgl_geser6").datebox("setValue",tgl_geser6);
        $("#tgl_geser7").datebox("setValue",tgl_geser7);
        $("#tgl_geser8").datebox("setValue",tgl_geser8);		
    }
  
    function kosong(){
        $("#no_geser1").attr("value","");
        $("#no_geser2").attr("value","");
        $("#no_geser3").attr("value","");
        $("#no_geser4").attr("value","");
        $("#no_geser5").attr("value","");
        $("#no_geser6").attr("value","");
        $("#no_geser7").attr("value","");
        $("#no_geser8").attr("value","");

        $("#tgl_geser1").datebox("setValue","");
        $("#tgl_geser2").datebox("setValue","");
        $("#tgl_geser3").datebox("setValue","");
        $("#tgl_geser4").datebox("setValue","");
        $("#tgl_geser5").datebox("setValue","");
        $("#tgl_geser6").datebox("setValue","");
        $("#tgl_geser7").datebox("setValue","");
        $("#tgl_geser8").datebox("setValue","");        
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
        var status_geser1 = document.getElementById('status_geser1').checked; /*1*/
        if (status_geser1==false){
           status_geser1=0;
        }else{
            status_geser1=1;
        }
        var status_geser2 = document.getElementById('status_geser2').checked; /*2*/
        if (status_geser2==false){
           status_geser2=0;
        }else{
            status_geser2=1;
        }
        var status_geser3 = document.getElementById('status_geser3').checked; /*3*/
        if (status_geser3==false){
           status_geser3=0;
        }else{
            status_geser3=1;
        }
        var status_geser4 = document.getElementById('status_geser4').checked; /*4*/
        if (status_geser4==false){
           status_geser4=0;
        }else{
            status_geser4=1;
        }
        var status_geser5 = document.getElementById('status_geser5').checked; /*5*/
        if (status_geser5==false){
           status_geser5=0;
        }else{
            status_geser5=1;
        }
        var status_geser6 = document.getElementById('status_geser6').checked; /*6*/
        if (status_geser6==false){
           status_geser6=0;
        }else{
            status_geser6=1;
        }
        var status_geser7 = document.getElementById('status_geser7').checked; /*7*/
        if (status_geser7==false){
           status_geser7=0;
        }else{
            status_geser7=1;
        }   
        var status_geser8 = document.getElementById('status_geser8').checked; /*8*/
        if (status_geser8==false){
           status_geser8=0;
        }else{
            status_geser8=1;
        }                                                       
        var no_geser1 = document.getElementById('no_geser1').value;
        var no_geser2 = document.getElementById('no_geser2').value;
        var no_geser3 = document.getElementById('no_geser3').value;
        var no_geser4 = document.getElementById('no_geser4').value;
        var no_geser5 = document.getElementById('no_geser5').value;
        var no_geser6 = document.getElementById('no_geser6').value;
        var no_geser7 = document.getElementById('no_geser7').value;
        var no_geser8 = document.getElementById('no_geser8').value;
                        

		var tgl_geser1 = $('#tgl_geser1').datebox('getValue');
        var tgl_geser2 = $('#tgl_geser2').datebox('getValue');
        var tgl_geser3 = $('#tgl_geser3').datebox('getValue');
        var tgl_geser4 = $('#tgl_geser4').datebox('getValue');
        var tgl_geser5 = $('#tgl_geser5').datebox('getValue');
        var tgl_geser6 = $('#tgl_geser6').datebox('getValue');
        var tgl_geser7 = $('#tgl_geser7').datebox('getValue');
        var tgl_geser8 = $('#tgl_geser8').datebox('getValue');


        if (ckd==''){
            alert('SKPD Tidak Boleh Kosong');
            exit();
        }
		
            $(document).ready(function(){
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url(); ?>/index.php/rka/simpan_pengesahan_geser',
                    data: ({tabel:'trhrka',
                        kdskpd:ckd,
                        status_geser1 : status_geser1,
                        status_geser2 : status_geser2,
                        status_geser3 : status_geser3,
                        status_geser4 : status_geser4,
                        status_geser5 : status_geser5,
                        status_geser6 : status_geser6,
                        status_geser7 : status_geser7,
                        status_geser8 : status_geser8,
                        no_geser1 : no_geser1,
                        no_geser2 : no_geser2,
                        no_geser3 : no_geser3,
                        no_geser4 : no_geser4,
                        no_geser5 : no_geser5,
                        no_geser6 : no_geser6,
                        no_geser7 : no_geser7,
                        no_geser8 : no_geser8,
                        tgl_geser1  : tgl_geser1,
                        tgl_geser2  : tgl_geser2,
                        tgl_geser3  : tgl_geser3,
                        tgl_geser4  : tgl_geser4,
                        tgl_geser5  : tgl_geser5,
                        tgl_geser6  : tgl_geser6,
                        tgl_geser7  : tgl_geser7,
                        tgl_geser8 : tgl_geser8

                    }),
                    dataType:"json",
             success:function(data){
                if (data == 1){
                    alert('Data Berhasil Tersimpan');
                }else{
                    alert('Data gagal tersimpan. PENGESAHAN HARUS URUT!');
                }
            }                   
                });
            });

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

     function tutup(){
        $('#tutup').hide();
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
<style type="text/css">
        code {
        font-family: Consolas, Monaco, Courier New, Courier, monospace;
        font-size: 12px;
        background-color: #f9f9f9;
        border: 1px solid #D0D0D0;
        color: #002166;
        display: block;
        margin: 14px 0 14px 0;
        padding: 12px 10px 12px 10px;
    }
</style>
</head>
<body>

<div id="content"> 
<h3 align="center"><u><b><a>PENGESAHAN DPA & DPPA </a></b></u></h3>
<code id="tutup">  <a class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:tutup();"></a> 
    <br><b>KHUSUS</b> pengesahan pergeseran <strong>DISINI</strong>, apabila sudah dicentang tidak bisa di kembalikan lagi.<br>
modul ini dikhususkan untuk menyimpan historikal dari tiap-tiap nilai pergeseran. <br>
untuk melihat tiap-tiap nilai dimasing-masing pergeseran pilih menu : <br>
<code><strong>UTILITY</strong> >> <strong>PENGESAHAN PERGESERAN</strong> >> <strong>Lampiran-lampiran</strong>
</code>

</code>    
    <div align="center">
    <p align="center">     
    <table style="width:400px;" border="0">
        <tr>
        <td hidden width="5%"><a class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:add_data();">Tambah</a></td>	
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
                <td><input type="text" disabled id="kode" style="width:100px;"/></td>
            </tr>
            <tr>
                <td width="30%">Nama SKPD</td>
                <td width="1%">:</td>
                <td><input type="text" disabled id="nmskpd" style="border:0;width:270px;"/></td>
            </tr> 
            <tr>
                <td colspan="3"><hr></td>
            </tr>            
			<tr>
            <td width="30%">Pengesahan Geser1</td>
            <td width="1%">:</td>
            <td><input type="checkbox" id="status_geser1"  onclick="javascript:runEffect();"/></td>
            </tr>
            <tr>
                <td width="30%">NO. Geser1</td>
                <td width="1%">:</td>
                <td><input type="text" id="no_geser1" style="width:100px;"/></td>  
            </tr>
            <tr>
                <td width="30%">TGL Geser1</td>
                <td width="1%">:</td>
                <td><input type="text" id="tgl_geser1" style="width:100px;"/></td>  
            </tr>
            <tr>
                <td colspan="3"><hr></td>
            </tr>
            <tr>
			<td width="30%">Pengesahan Geser2</td>
			<td width="1%">:</td>
			<td><input type="checkbox" id="status_geser2"  onclick="javascript:runEffect();"/></td>
			</tr>
            <tr>
                <td width="30%">NO. Geser2</td>
                <td width="1%">:</td>
                <td><input type="text" id="no_geser2" style="width:100px;"/></td>  
            </tr>
            <tr>
                <td width="30%">TGL Geser2</td>
                <td width="1%">:</td>
                <td><input type="text" id="tgl_geser2" style="width:100px;"/></td>  
            </tr>
            <tr>
                <td colspan="3"><hr></td>
            </tr>
			<tr>
			<td width="30%">Pengesahan Geser3</td>
			<td width="1%">:</td>
			<td><input type="checkbox" id="status_geser3"  onclick="javascript:runEffect();"/></td>
			</tr>
            <tr>
                <td width="30%">NO.  Geser3</td>
                <td width="1%">:</td>
                <td><input type="text" id="no_geser3" style="width:100px;"/></td>  
            </tr>
            
            <tr>
                <td width="30%">TGL  Geser3</td>
                <td width="1%">:</td>
                <td><input type="text" id="tgl_geser3" style="width:100px;"/></td>  
            </tr>
            <tr>
                <td colspan="3"><hr></td>
            </tr>
            <tr>
            <td width="30%">Pengesahan Geser4</td>
            <td width="1%">:</td>
            <td><input type="checkbox" id="status_geser4"  onclick="javascript:runEffect();"/></td>
            </tr>
            <tr>
                <td width="30%">NO. Geser4</td>
                <td width="1%">:</td>
                <td><input type="text" id="no_geser4" style="width:100px;"/></td>  
            </tr>            
            <tr>
                <td width="30%">TGL Geser4</td>
                <td width="1%">:</td>
                <td><input type="text" id="tgl_geser4" style="width:100px;"/></td>  
            </tr>

            <tr>
                <td colspan="3"><hr></td>
            </tr>
			<tr>
			<td width="30%">Pengesahan Geser5</td>
			<td width="1%">:</td>
			<td><input type="checkbox" id="status_geser5"  onclick="javascript:runEffect();"/></td>
			</tr>
            <tr>
                <td width="30%">No. Geser5</td>
                <td width="1%">:</td>
                <td><input type="text" id="no_geser5" style="width:100px;"/></td> 				
            </tr>
			
            <tr>
                <td width="30%">TGL Geser5</td>
                <td width="1%">:</td>
                <td><input type="text" id="tgl_geser5" style="width:100px;"/></td>  
            </tr>
            <tr>
                <td colspan="3"><hr></td>
            </tr>
            <tr>
            <td width="30%">Pengesahan Geser6</td>
            <td width="1%">:</td>
            <td><input type="checkbox" id="status_geser6"  onclick="javascript:runEffect();"/></td>
            </tr>
            <tr>
                <td width="30%">No. Geser6</td>
                <td width="1%">:</td>
                <td><input type="text" id="no_geser6" style="width:100px;"/></td>                
            </tr>
            
            <tr>
                <td width="30%">TGL Geser6</td>
                <td width="1%">:</td>
                <td><input type="text" id="tgl_geser6" style="width:100px;"/></td>  
            </tr>			             
            <tr>
                <td colspan="3"><hr></td>
            </tr>
            <tr>
            <td width="30%">Pengesahan Geser7</td>
            <td width="1%">:</td>
            <td><input type="checkbox" id="status_geser7"  onclick="javascript:runEffect();"/></td>
            </tr>
            <tr>
                <td width="30%">No. Geser7</td>
                <td width="1%">:</td>
                <td><input type="text" id="no_geser7" style="width:100px;"/></td>                
            </tr>
            
            <tr>
                <td width="30%">TGL Geser7</td>
                <td width="1%">:</td>
                <td><input type="text" id="tgl_geser7" style="width:100px;"/></td>  
            </tr>
            <tr>
                <td colspan="3"><hr></td>
            </tr>
            <tr>
            <td width="30%">Pengesahan Geser8</td>
            <td width="1%">:</td>
            <td><input type="checkbox" id="status_geser8"  onclick="javascript:runEffect();"/></td>
            </tr>
            <tr>
                <td width="30%">No. Geser8</td>
                <td width="1%">:</td>
                <td><input type="text" id="no_geser8" style="width:100px;"/></td>                
            </tr>
            
            <tr>
                <td width="30%">TGL Geser8</td>
                <td width="1%">:</td>
                <td><input type="text" id="tgl_geser8" style="width:100px;"/></td>  
            </tr>                        
            <tr>
            <td colspan="5">&nbsp;</td>
            </tr>  
                        <tr>
                <td colspan="3"><hr></td>
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