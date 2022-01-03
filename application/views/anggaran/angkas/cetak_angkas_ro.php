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
    var kode=''; 
    var kegiatan='';
	var xrekening ='';	
    var xnmkegiatan ='';
    var xkegiatan ='';
    var total_pic =0;
    var val_pil = 'pemda';
    var kode = 'xxx';

    $(document).ready(function() {
      $('#tgl_ttd').datebox({  
            required:true,
            formatter :function(date){
                var y = date.getFullYear();
                var m = date.getMonth()+1;
                var d = date.getDate();
                return y+'-'+m+'-'+d;
            }
        });
        get_ttd();
        $(".gr_skpd").hide(); 
        $("#accordion").accordion({});
        $('#ck').combogrid();
        $('#ttd1').combogrid();
        $('#ttd2').combogrid();
        
    });
  
      $(function(){
           
        $('#cc').combogrid({  
            panelWidth:700,  
            idField:'kd_skpd',  
            textField:'kd_skpd',  
            mode:'remote',
            url:'<?php echo base_url(); ?>index.php/rka_ro/skpduser',  
            columns:[[  
                {field:'kd_skpd',title:'Kode SKPD',width:100},  
                {field:'nm_skpd',title:'Nama SKPD',width:700}    
            ]],
            onSelect:function(rowIndex,rowData){
                kode = rowData.kd_skpd;
                nm = rowData.nm_skpd;
                $("#ck").combogrid("clear"); 
                $("#total_pic2").attr("value",'');
                $("#skpdd").attr("Value",nm);
                giat(kode);
                get_ttd();
            }  
        }); 
      });
       
     function giat(kode){
          $(function(){  
            $('#ck').combogrid({
                panelWidth:700,  
                idField:'kd_kegiatan',  
                textField:'kd_kegiatan',  
                mode:'remote',
                url:'<?php echo base_url(); ?>index.php/rka_ro/load_giat/'+kode,
                columns:[[  
                    {field:'kd_kegiatan',title:'Kode Kegiatan',width:150},  
                    {field:'nm_kegiatan',title:'Nama Kegiatan',width:520}    
               
                ]], 
                onSelect:function(rowIndex,rowData){
                    kegiatan=rowData.kd_kegiatan;
                    xkegiatan=rowData.kd_kegiatan;
                    xnmkegiatan=rowData.nm_kegiatan;
                    total=rowData.total;
                    total_pic = total;                    
                    skpdd=rowData.kd_skpd;
                    $("#jumlah").attr("value",total); 
                    $("#nm_giat").attr("value",xnmkegiatan);
                    $("#total_pic2").attr("value",total_pic);
                    tampil();
                }
            });      

                             
 
         }); 

     }

    function get_ttd(){
        $('#ttd1').combogrid({  
                    panelWidth:400,  
                    idField:'urut',  
                    textField:'nip',  
                    mode:'remote',
                    url:'<?php echo base_url(); ?>index.php/cetak_angkas/load_ttd_unit/'+kode,  
                    columns:[[  
                        {field:'nip',title:'NIP',width:200},  
                        {field:'nama',title:'Nama',width:400}    
                    ]],
                    onSelect:function(rowIndex,rowData){
                        $("#nm_ttd1").attr("value",rowData.nama); 
                    }
                });      

                $('#ttd2').combogrid({  
                    panelWidth:400,  
                    idField:'urut',  
                    textField:'nip',  
                    mode:'remote',
                    url:'<?php echo base_url(); ?>index.php/cetak_angkas/load_ttd_bud',  
                    columns:[[  
                        {field:'nip',title:'NIP',width:200},  
                        {field:'nama',title:'Nama',width:400}    
                    ]], 
                    onSelect:function(rowIndex,rowData){
                        $("#nm_ttd2").attr("value",rowData.nama);
                    }                     
                }); 
    }
    function tampil(){
        var jenis = document.getElementById('jenis').value;
        var skpd  = $("#cc").combogrid("getValue");
        var giat  = $("#ck").combogrid("getValue");
        var ttd1  = $("#ttd1").combogrid("getValue");
        var ttd2  = $("#ttd2").combogrid("getValue");
        var tgl   = $("#tgl_ttd").datebox("getValue");
        if((skpd != '' && giat!= '')){
            var url="<?php echo site_url(); ?>/cetak_angkas/cetak_angkas_ro/a/2020-01-01/1/1/"+jenis+"/"+skpd+"/"+giat+"/hidden/1";
            document.getElementById('tampil').innerHTML=
            "<embed src='"+url+"' width='100%' height='500px'>"; 
        }        
    }
    function cetak(ctk){
        var jenis = document.getElementById('jenis').value;
        var skpd  = $("#cc").combogrid("getValue");
        var giat  = $("#ck").combogrid("getValue");
        var ttd1  = $("#ttd1").combogrid("getValue");
        var ttd2  = $("#ttd2").combogrid("getValue");
        if((ttd1=='' || ttd2=='') || tgl=='' ){
            alert("Harap diisi semua!");exit();
        }
        var tgl   = $("#tgl_ttd").datebox("getValue");

        if(val_pil=='skpd'){
            var url="<?php echo site_url(); ?>/cetak_angkas/cetak_angkas_ro/66159202463fd4c312b063293b88f6063b28f0cc175b9c0f1b6a831c399e26977260c8102d29fcd525162d02eed4566b/"+tgl+"/"+ttd1+"/"+ttd2+"/"+jenis+"/"+skpd+"/"+giat+"/oke/"+ctk;
        }else{
            var url="<?php echo site_url(); ?>/cetak_angkas/cetak_angkas_pemda?tgl="+tgl+"&ttd1="+ttd1+"&ttd2="+ttd2+"&jenis="+jenis+"&cetak="+ctk;
        }
            
        window.open(url);
    }

    function pilihnya(){
        val_pil = $('input[name="pilih"]:checked').val();
        if(val_pil=='skpd'){
            $(".gr_skpd").show();
        }else{
            $(".gr_skpd").hide();
        }
    }
    </script>

</head>
<?php 
    if($jns_ang=='1'){
        $select1="selected";
        $select2="";
        $select3="";
    }else if($jns_ang=='2'){
        $select1="";
        $select2="selected";
        $select3="";
    }else{
        $select1="";
        $select2="";
        $select3="selected";
    }

 ?>
<body>


<div id="content" > 
   
<div id="accordion" >
<h3><a href="#" id="section1">CETAK ANGKAS RO</a></h3>
   <div  style="height: 800px;">
   <p><h3>
        <table style="border-style: none; border-bottom: none" width="100%">
            <tr>
                <td colspan="2">
                    <input type="radio" id="pemda" name="pilih" onChange="pilihnya()" value="pemda" checked>
                    <label for="pemda">Anggaran Kas Pemda</label> 
                    <input type="radio" id="skpd" name="pilih" onChange="pilihnya()" value="skpd" style="margin-left: 102px;">
                    <label for="skpd">Anggaran Kas SKPD</label> 
                </td>
            </tr>
          
            <tr class="gr_skpd">
                <td width="20%" style="border-style: none; border-bottom: none">
                    S K P D
                </td>
                <td style="border-style: none; border-bottom: none">
                    &nbsp;<input id="cc" name="skpd" style="width: 300px;"/> <input  id="skpdd" name="skpdd" style="width: 500px; border-style: none"/>
                </td>
            </tr>
            <tr class="gr_skpd">
                <td style="border-style: none; border-bottom: none">
                    KEGIATAN
                </td>
                <td style="border-style: none; border-bottom: none">
                    &nbsp;<input id="ck" name="kegiatan" style="width: 300px;" /> <input id="nm_giat" name="kegiatan" style="width: 500px; border-style: none" />
                </td>
            </tr>
       
            <tr>
                <td style="border-style: none; border-bottom: none">
                    ANGGARAN
                </td>
                <td style="border-style: none; border-bottom: none">
                    <SELECT id="jenis" style="width: 300px;">
                        <option value="nilai"          <?php echo $select1 ?>>Penyusunan</option>
                        <option value="nilai_sempurna" <?php echo $select2 ?>>Pergeseran</option>
                        <option value="nilai_ubah"     <?php echo $select3 ?>>Perubahan</option>
                    </SELECT> 
                </td>
            </tr>
            <tr>
                <td style="border-style: none; border-bottom: none">
                    Penandatangan
                </td>
                <td style="border-style: none; border-bottom: none">
                    &nbsp;<input id="ttd1" name="ttd1" style="width: 300px;"/> <input  id="nm_ttd1" name="nm_ttd1" style="width: 500px; border-style: none"/>
                </td>
            </tr>
            <tr>
                <td style="border-style: none; border-bottom: none">
                    Penandatangan 2
                </td>
                <td style="border-style: none; border-bottom: none">
                    &nbsp;<input id="ttd2" name="ttd2" style="width: 300px;" />  <input  id="nm_ttd2" name="nm_ttd2" style="width: 500px; border-style: none"/>
                </td>
            </tr>
            <tr>
                <td style="border-style: none; border-bottom: none">
                    Tanggal ttd
                </td>
                <td style="border-style: none; border-bottom: none">
                    &nbsp;<input id="tgl_ttd" style="width: 300px;" /> 
                </td>
            </tr>
            <tr>
                <td style="border-style: none; border-bottom: none"></td>
                <td style="border-style: none; border-bottom: none">&nbsp;
                   <button onclick="javascript:cetak(1);" class="easyui-linkbutton" iconCls="icon-print" plain="true" style="cursor: pointer; padding:10px">Cetak</button>
                   <button onclick="javascript:cetak(2);" class="easyui-linkbutton" iconCls="icon-pdf"   plain="true" style="cursor: pointer; padding:10px"> PDF</button>
                   <button onclick="javascript:cetak(3);" class="easyui-linkbutton" iconCls="icon-excel" plain="true" style="cursor: pointer; padding:10px"> Excel</button>
                </td>
            </tr>
        </table>
    </h3> 
   </p>
   </div>

<br><br><br><br><br><br><br><br><br><br>

</div> 
<label id="tampil"> 
</div> 	
</body>

</html>