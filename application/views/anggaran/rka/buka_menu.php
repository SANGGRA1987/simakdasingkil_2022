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
            height: 250,
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

        $('#tgldpasempurna_final').datebox({  
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
		url: '<?php echo base_url(); ?>/index.php/utilitas/load_buka_menu',
        idField:'id',            
        rownumbers:"true", 
        fitColumns:"true",
        singleSelect:"true",
        autoRowHeight:"false",
        loadMsg:"Tunggu Sebentar....!!",
        nowrap:"true",                       
        columns:[[
            {field:'id_user',
    		title:'User',
    		width:1,
            hidden:true,
            align:"center"},
			{field:'kd_skpd',
    		title:'Kode SKPD',
    		width:1,
            hidden:true,
            align:"center"},
    	    {field:'nama',
    		title:'Nama SKPD',
    		width:5,
            align:"left"},
            {field:'rka',
            title:'Input RKA / DPA',
            width:1,
            align:"center"},
            {field:'angkas',
            title:'Inputan Ang. Kas',
            width:1,
            align:"center"},
			{field:'has',
            title:'Anggaran Kas',
            width:1,
			hidden:true,
            align:"center"}
        ]],
		
        onSelect:function(rowIndex,rowData){
          ckd_skpd = rowData.kd_skpd;
          crka = rowData.rka;
          cangkas = rowData.angkas;
		  chas = rowData.has;
		  cangkasx = rowData.angkasx;
		  
		  crkax = rowData.rkax;
          
		  get(ckd_skpd,crka,cangkas,chas,crkax,cangkasx); 
          lcidx = rowIndex;                           
        },
        onDblClickRow:function(rowIndex,rowData){
           lcidx = rowIndex;
           judul = 'Edit Menu'; 
           edit_data();   
        }
        });		
		
    });        

    function get(ckd_skpd,crka,cangkas,chas,crkax,cangkasx) {
		
		
		
        $("#kode").combogrid("setValue",ckd_skpd);
       
        if (crkax==1){            
            $("#stsrka").attr("checked",true);
        } else {
            $("#stsrka").attr("checked",false);
        }

        if (cangkasx==1){            
            $("#stsangkas").attr("checked",true);
        } else {
            $("#stsangkas").attr("checked",false);
        }
		
					
					
    }
  
    function kosong(){
        $("#kode").combogrid("setValue",'');
	    $("#nmskpd").attr("value",'')
        $("#stsrka").attr("checked",false);
		$("#stsangkas").attr("checked",false);
		
    }
    
    function cari(){
    var kriteria = document.getElementById("txtcari").value; 
    $(function(){ 
     $('#dg').edatagrid({
		url: '<?php echo base_url(); ?>/index.php/utilitas/load_buka_menu',
        queryParams:({cari:kriteria})
        });        
     });
    }
	
       function simpan_pengesahan(){
        var ckd = $('#kode').combogrid('getValue');
		var cst1 = document.getElementById('stsangkas').checked;
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

		
            $(document).ready(function(){
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url(); ?>/index.php/rka/simpan_buka_menu',
                    data: ({tabel:'trhrka',kdskpd:ckd,stdpa:cst1,strka:cst1}),
                    dataType:"json"
                });
            });

        alert("Data Berhasil disimpan");
        $("#dialog-modal").dialog('close');
        $('#dg').edatagrid('reload');
		
    } 
    
      function edit_data(){
        lcstatus = 'edit';
        judul = 'Edit Data Menu';
        $("#dialog-modal").dialog({ title: judul });
        $("#dialog-modal").dialog('open');
        document.getElementById("kode").disabled=true;
        }    
		
     function keluar(){
        $("#dialog-modal").dialog('close');
		lcstatus = 'edit';
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
<h3 align="center"><u><b><a>DAFTAR MENU AKTIF/NONAKTIF INPUTAN ANGGARAN</a></b></u></h3>
    <div align="center">
    <p align="center">     
    <table style="width:400px;" border="0">
        <tr>
        <td style="color: red;">*) Ket : " v " = Telah di Sahkan || " - " = Belum di Sahkan</td>

        </tr>
        <tr>
        <td colspan="4">
        <table id="dg" title="LIST MENU AKTIF / NONAKTIF" style="width:900px;height:500px;" >  
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
            <td width="30%">Aktifkan Menu Input RKA</td>
            <td width="1%">:</td>
            <td><input type="checkbox" id="stsrka"  onclick="javascript:runEffect();"/></td>
            </tr>
            <tr>
			<td width="30%">Aktifkan Menu Input Anggaran Kas</td>
			<td width="1%">:</td>
			<td><input type="checkbox" id="stsangkas"  onclick="javascript:runEffect();"/></td>
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