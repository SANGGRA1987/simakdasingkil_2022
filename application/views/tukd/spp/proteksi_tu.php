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
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/autoCurrency.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/numberFormat.js"></script>
    
    <link href="<?php echo base_url(); ?>easyui/jquery-ui.css" rel="stylesheet" type="text/css"/>
    <script src="<?php echo base_url(); ?>easyui/jquery-ui.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
            $( "#dialog-modal" ).dialog({
            height: 200,
            width: 700,
            modal: true,
            autoOpen:false
        });
    });
    
    $(function(){ 
     $('#dg').edatagrid({
        url: '<?php echo base_url(); ?>/index.php/tukd/load_proteksitu',
        idField:'id',            
        rownumbers:"true", 
        fitColumns:"true",
        singleSelect:"true",
        autoRowHeight:"false",
        loadMsg:"Tunggu Sebentar....!!",
        columns:[[
    	    {field:'kd_skpd',
    		title:'SKPD',
    		width:13},
            {field:'nm_skpd',
    		title:'NAMA',
    		width:100},
            {field:'init_ket',
    		title:'Proteksi',
    		width:13,
            align:"center"}
        ]],
        onDblClickRow:function(rowIndex,rowData){           
            section2();   
            skpd    = rowData.kd_skpd;
            nmskpd  = rowData.nm_skpd;
            init_ket= rowData.init_ket;          
            init    = rowData.init;                      
            get_skpd(skpd,nmskpd,init_ket,init);
        }
        });
    });
        
    function section1(){
         $(document).ready(function(){    
             $('#section1').click();                                                           
         });
     }
     
     function get_skpd(skpd,nmskpd,init_ket,init){
        $("#skpd_edt").attr("value",skpd);
        $("#nmskpd_edt").attr("value",nmskpd);
        $("#init_edt").attr("value",init);        
     } 
     
     function simpan(){
        var vskpd   = document.getElementById('skpd_edt').value;
        var vnmskpd = document.getElementById('nmskpd_edt').value;
        var vinit   = document.getElementById('init_edt').value; 
        
         $(document).ready(function(){
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>/index.php/tukd/simpan_proteksitu',
                data: ({tabel:'ms_skpd_tu',skpd:vskpd,nmskpd:vnmskpd,init:vinit}),
                dataType:"json",
                success:function(data){
                    status = data;
                    if(status=='0'){
                       alert('Data Berhasil Gagal');
                    } else{
					   alert("Data Berhasil disimpan");                       
		               $('#dg').edatagrid('reload');
                       keluar();							
					}
                }
            });
        });
     }
     
     
     function section2(){
        $("#dialog-modal").dialog('open');
     }
     
     function keluar(){
        $("#dialog-modal").dialog('close');
     }     
    
    </script>

</head>
<body>
<div id="content"> 
   
<div id="accordion">
<h3><a href="#" id="section1">Proteksi SPP TU</a></h3>
  <table id="dg" title="List SKPD" style="width:870px;height:450px;" >  
  </table>
</div>
</div>

<div id="dialog-modal" title="Edit Proteksi">
    <fieldset>
    <table>
        <tr>
            <td width="110px">Kode SKPD</td>
            <td><input type="text" id="skpd_edt" readonly="true" style="width: 120px;" /></td>
        </tr>
        <tr>
            <td width="110px">Nama</td>
            <td><input type="text" id="nmskpd_edt" readonly="true" style="border:0;width: 500px;"/></td>
        </tr>
        <tr> 
           <td width="110px">Proteksi</td>
           <td>
           <select id="init_edt" name="init_edt">
                <option value="1">Ya</option>
                <option value="0">Tidak</option>
           </select>
           </td>
        </tr>
    </table>  
    </fieldset>
    <a class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:simpan();">Simpan</a>
	<a class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:keluar();">Keluar</a>  
</div>

</body>
</html>