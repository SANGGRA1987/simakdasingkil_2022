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
    var cid = 0;
                    
     $(document).ready(function() {
            $("#accordion").accordion();
            $("#lockscreen").hide();                        
            $("#frm").hide();
            $( "#dialog-modal" ).dialog({
            height: 200,
            width: 700,
            modal: true,
            autoOpen:false
        });
        });    
     
     $(function(){ 
     $('#dg').edatagrid({
		url: '<?php echo base_url(); ?>/index.php/rka/load_spd',
        idField:'id',            
        rownumbers:"true", 
        fitColumns:"true",
        singleSelect:"true",
        autoRowHeight:"false",
        loadMsg:"Tunggu Sebentar....!!",
        pagination:"true",
        nowrap:"true",                       
        columns:[[
    	    {field:'no_spd',
    		title:'Nomor SPD',
    		width:50},
            {field:'tgl_spd',
    		title:'Tanggal',
    		width:30},
            {field:'nm_skpd',
    		title:'Nama SKPD',
    		width:100,
            align:"left"},
            {field:'jns_beban',
    		title:'Jenis Beban',
    		width:50,
            align:"center"}
        ]],
        onSelect:function(rowIndex,rowData){
          nomor = rowData.no_spd;
          tgl   = rowData.tgl_spd;
          kode  = rowData.kd_skpd;
          nama  = rowData.nm_skpd;
          bulan1= rowData.bulan_awal;
          bulan2= rowData.bulan_akhir;
          jns   = rowData.jns_beban; 
          get(nomor,tgl,kode,nama,bulan1,bulan2,jns);   
          load_detail();                                   
        },
        onDblClickRow:function(rowIndex,rowData){
            section2();   
        }
    });
    
        $('#tanggal').datebox({  
            required:true,
            formatter :function(date){
            	var y = date.getFullYear();
            	var m = date.getMonth()+1;
            	var d = date.getDate();
            	return y+'-'+m+'-'+d;
            }
        });
    
        $('#skpd').combogrid({  
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
               kode = rowData.kd_skpd;               
               $("#nmskpd").attr("value",rowData.nm_skpd);
               $('#giat').combogrid({url:'<?php echo base_url(); ?>index.php/rka/load_trskpd/'+kode});                 
           }  
       });
                     
        $('#giat').combogrid({  
           panelWidth:700,  
           idField:'kd_kegiatan',  
           textField:'kd_kegiatan',  
           mode:'remote',
           url:'<?php echo base_url(); ?>index.php/rka/load_trskpd/'+kode,             
           columns:[[  
               {field:'kd_kegiatan',title:'Kode Kegiatan',width:140},  
               {field:'nm_kegiatan',title:'Nama Kegiatan',width:700}    
           ]],  
           onSelect:function(rowIndex,rowData){
               giat = rowData.kd_kegiatan;
               $("#nmgiat").attr("value",rowData.nm_kegiatan);     
               document.getElementById('nilai').focus();                                        
           }  
        });
        
        $('#dg1').edatagrid({  
            toolbar:'#toolbar',
            rownumbers:"true", 
            fitColumns:"true",
            singleSelect:"true",
            autoRowHeight:"false",
            loadMsg:"Tunggu Sebentar....!!",            
            nowrap:"true",
            onSelect:function(rowIndex,rowData){                    
                    idx = rowIndex;
            },                                                     
            columns:[[
                {field:'id',
        		title:'ID',    		
                hidden:"true"},
        	    {field:'no_spd',
        		title:'Nomor SPD',    		
                hidden:"true"},                
                {field:'kd_kegiatan',
        		title:'Kode Kegiatan',
        		width:30},
                {field:'nm_kegiatan',
        		title:'Nama Kegiatan',
        		width:70},
                {field:'nilai',
        		title:'Nilai Rupiah',
        		width:30,
                align:"right"}
            ]]
        });      
    });        

    function load_detail(){        
       var nomor = document.getElementById("nomor").value;        
           $(document).ready(function(){
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>/index.php/rka/load_dspd',
                data: ({no:nomor}),
                dataType:"json",
                success:function(data){                                   
                                $.each(data,function(i,n){
                                cid = n['id'];    
                                cno = n['no_spd'];                                                                    
                                cgiat = n['kd_kegiatan'];
                                cnm = n['nm_kegiatan'];
                                cnil = n['nilai'];                                
                                $('#dg1').datagrid('appendRow',{id:cid,no_spd:cno,kd_kegiatan:cgiat,nm_kegiatan:cnm,nilai:cnil});                         
                                });            
                }
            });
           });      
           $('#dg1').edatagrid('reload');                
    }
 
     function section1(){
         $(document).ready(function(){    
             $('#section1').click();                                               
         });
     }
     function section2(){
         $(document).ready(function(){    
             $('#section2').click();                                               
         });         
     }
       
     
    function get(nomor,tgl,kode,nama,bulan1,bulan2,jns){
        $("#nomor").attr("value",nomor);
        $("#tanggal").datebox("setValue",tgl);
        $("#skpd").combogrid("setValue",kode);
        $("#nmskpd").attr("value",nama);
        $("#bulan1").attr("value",bulan1);
        $("#bulan2").attr("value",bulan2);
        $("#jenis").attr("value",jns);        
    }
    
    function kosong(){
        $("#nomor").attr("value",'');
        $("#tanggal").datebox("setValue",'');
        $("#skpd").combogrid("setValue",'');
        $("#nmskpd").attr("value",'');
        $("#bulan1").attr("value",'');
        $("#bulan2").attr("value",'');
        $("#jenis").attr("value",'');
        var kode = '';
        var nomor = '';
        $('#giat').combogrid('setValue','');
        $('#nilai').attr('value','0');
        
    }
    
    function cari(){
    var kriteria = document.getElementById("txtcari").value; 
    $(function(){ 
     $('#dg').edatagrid({
		url: '<?php echo base_url(); ?>/index.php/rka/load_spd',
        queryParams:({cari:kriteria})
        });        
     });
    }
    
    function validate1(){
        var bln1 = document.getElementById('bulan1').value;
        $("#bulan2").attr("value",bln1);
    }
    function validate2(){
        var bln1 = document.getElementById('bulan1').value;
        var bln2 = document.getElementById('bulan2').value;
        if (bln2 < bln1){
            alert('Bulan Sampai dengan tidak bisa lebih kecil dari Bulan awal');
            $("#bulan2").attr("value",bln1);   
        }        
    }
    function append_save(){        
        var nama = document.getElementById('nmgiat').value;
        var nil = document.getElementById('nilai').value;
        var giat = $('#giat').combogrid('getValue');                         
        if (giat != '' && nil != 0) {
            cid = cid + 1;            
            $('#dg1').datagrid('appendRow',{id:cid,no_spd:nomor,kd_kegiatan:giat,nm_kegiatan:nama,nilai:nil});  
                      
        }    
        $('#giat').combogrid('setValue','');
        $('#nilai').attr('value','0');
    }
    
    function tes(){
       $('#dg1').edatagrid({    
         onSelect:function(rowIndex,rowData){
                    alert(rowData.id+'-'+rowData.no_spd+'-'+rowData.kd_kegiatan+rowData.nm_kegiatan+rowData.nilai);
            }
       });
    }       
    
    function tambah(){
        $("#dialog-modal").dialog('open');
    }
    function keluar(){
        $("#dialog-modal").dialog('close');
    }    
    function hapus_giat(){
         $('#dg1').datagrid('deleteRow',idx);     
    }
    function simpan_spd(){
        
        
    }
    </script>

</head>
<body>



<div id="content"> 
   
<div id="accordion">
<h3><a href="#" id="section1">List SPD</a></h3>
    <div>
    <p>         
        <a class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:section2();kosong();load_detail();">Tambah</a>               
        <a class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="javascript:cari();">Cari</a>
        <input type="text" value="" id="txtcari"/>
        <table id="dg" title="List SPD" style="width:870px;height:450px;" >  
        </table>
                  
        
    </p> 
    </div>   

<h3><a href="#" id="section2">S P D</a></h3>
   <div  style="height: 350px;">
   <p>       
        <table align="center" style="width:100%;">
            <tr>
                <td>No. S P D</td>
                <td colspan="3"><input type="text" id="nomor" style="width: 200px;" onclick="javascript:select();"/></td>     
            </tr>            
            <tr>
                <td>Tanggal SPD</td>
                <td colspan="3"><input type="text" id="tanggal" style="width: 140px;" /></td>
            </tr>
            <tr>
                <td>S K P D</td>
                <td><input id="skpd" name="skpd" style="width: 140px;" /></td>
                <td colspan="2">Nama SKPD : <input type="text" id="nmskpd" style="border:0;width: 450px;" readonly="true"/></td>
                                
            </tr>
            <tr>
                <td>Bendahara</td>
                <td colspan="3"><input type="text" id="bendahara"/></td>                
            </tr>            
            <tr>
                <td>Kebutuhan Bulan</td>
                <td colspan="3"><?php echo $this->rka_model->combo_bulan('bulan1','onchange="javascript:validate1();"'); ?> s/d <?php echo $this->rka_model->combo_bulan('bulan2','onchange="javascript:validate2();"'); ?></td>                
            </tr>
            <tr>
                <td>Ketentuan Lain</td>
                <td colspan="3"><input type="text" id="ketentuan"/></td>
            </tr>
            <tr>
                <td>Jenis Pengajuan</td>
                <td colspan="3"><input type="text" id="pengajuan"/></td>
            </tr>
            <tr>
                <td>Atas Beban</td>
                <td colspan="3"><?php echo $this->rka_model->combo_beban('jenis'); ?></td>
            </tr>
            <tr>
                <td colspan="4"><a class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:simpan_spd();">Simpan</a>
		            <a class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="">Hapus</a>
  		            <a class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:section1();">Kembali</a></td>                
            </tr>
        </table>          
        <table id="dg1" title="Kegiatan S P D" style="width:870px;height:350px;" >  
        </table>  
        <div id="toolbar">
    		<a class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:tambah();">Tambah Kegiatan</a>
    		<a class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:hapus_giat();">Hapus Kegiatan</a>    		
        </div>
        
                
   </p>
   </div>
       


</div>

</div>


<div id="dialog-modal" title="Input Kegiatan">
    <p class="validateTips">Semua Inputan Harus Di Isi.</p> 
    <fieldset>
    <table>
        <tr>
            <td width="110px">Kode Kegiatan:</td>
            <td><input id="giat" name="giat" style="width: 200px;" /></td>
        </tr>
        <tr>
            <td width="110px">Nama Kegiatan:</td>
            <td><input type="text" id="nmgiat" readonly="true" style="border:0;width: 400px;"/></td>
        </tr>
        <tr> 
           <td width="110px">Nilai:</td>
           <td><input type="text" id="nilai" /></td>
        </tr>
    </table>  
    </fieldset>
    <a class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:append_save();">Simpan</a>
	<a class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:keluar();">Keluar</a>  
</div>


    

  	
</body>

</html>