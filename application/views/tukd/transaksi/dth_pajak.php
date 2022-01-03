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
    var nip='';
    var kdskpd='';
    var kdrek5='';
    

    
    $(function(){
        $("#hide3").hide();
        $("#period1").attr("Value",'');
        $("#period2").attr("Value",'');        
        
        $('#sskpd').combogrid({  
                panelWidth:700,  
                idField:'kd_skpd',  
                textField:'kd_skpd',  
                mode:'remote',
                url:'<?php echo base_url(); ?>index.php/tukd/kode_skpd', //skpduser',  
                columns:[[  
                    {field:'kd_skpd',title:'Kode SKPD',width:170},  
                    {field:'nm_skpd',title:'Nama SKPD',width:500}    
                ]],
                onSelect:function(rowIndex,rowData){         
                    skpd = rowData.kd_skpd;
                    $("#nmskpd").attr("value",rowData.nm_skpd);
                }
        });

        $('#tgl_ttd').datebox({  
            required:true,
            formatter :function(date){
                var y = date.getFullYear();
                var m = date.getMonth()+1;
                var d = date.getDate();
                return y+'-'+m+'-'+d;
            }
        }); 
        $('#period1').datebox({  
            required:true,
            formatter :function(date){
                var y = date.getFullYear();
                var m = date.getMonth()+1;
                var d = date.getDate();
                return y+'-'+m+'-'+d;
            }
        });
        $('#period2').datebox({  
            required:true,
            formatter :function(date){
                var y = date.getFullYear();
                var m = date.getMonth()+1;
                var d = date.getDate();
                return y+'-'+m+'-'+d;
            }
        });            
        $('#ttd2').combogrid({  
            panelWidth:600,  
            idField:'nip',  
            textField:'nip',  
            mode:'remote',
            url:'<?php echo base_url(); ?>index.php/tukd/load_ttd/BUD',  
            columns:[[  
                {field:'nip',title:'NIP',width:200},
                {field:'nama',title:'Nama',width:400}
            ]],  
            onSelect:function(rowIndex,rowData){
                $("#nm_ttd2").attr("value",rowData.nama);
            } 
           }); 
    });
        function validate1(){
            var bln1 = document.getElementById('bulan1').value;
            
        }   

        function runEffect(){
            var allskpd   = document.getElementById('allskpd').checked;
            var allperiod = document.getElementById('allperiod').checked;

            if (allskpd==true){
               $(function(){
                    $("#hide").hide();                
               });
            }else{
                $(function(){
                    $("#sskpd").combogrid('setValue','');
                    $("#hide").show();                
               });
            }

            if (allperiod==true){
               $(function(){    /*periode*/
                    $("#bulan").attr("setValue",'');
                    $("#hide2").hide();
                    $("#hide3").show();                
               });
            }else{
                $(function(){   /*bulan*/
                    $("#period1").datebox("setValue",'');
                    $("#period2").datebox("setValue",'');
                    $("#hide3").hide();
                    $("#hide2").show();                
               });
            }

        } 

        function cetak(jenis=''){
            var allskpd   = document.getElementById('allskpd').checked;
            var allperiod = document.getElementById('allperiod').checked;
            var skpd    = $("#sskpd").combogrid('getValue');
            var period1 = $('#period1').datebox('getValue');
            var period2 = $('#period2').datebox('getValue');
            var bulan   = document.getElementById('bulan1').value;            
            var ctglttd = $('#tgl_ttd').datebox('getValue');
            var ttd2    = $("#ttd2").combogrid('getValue');   
            var ttd_2   = ttd2.split(" ").join("AsDfghJklxu");

            if(allskpd==false && skpd==''){
                alert('SKPD Harap diIsi');
                exit();
            }else if(allskpd==true){
                skpd="-";
            }

            if(allperiod==false && (bulan=='')){
                alert('Bulan Harap di isi');
                exit();
            }else if(allperiod==true && (period1==''||period2=='')){
                alert('Periode Harap di isi');
                exit();
            }else if(allperiod==false){
                period1="-";
                period2="-";
            }else if(allperiod==true){
                bulan="-";
            }

            if(ctglttd==''){
                alert('Tanggal tidak boleh kosong!');
                exit();
            }else if(ttd2==''){
                alert('Penandatangan tidak boleh kosong!');
                exit();
            }
            var xxx     = ttd2+"/"+ctglttd+"/"+bulan+"/"+period1+"/"+period2+"/"+skpd+"/"+jenis;
            var url     = "<?php echo site_url(); ?>/tukd/pajak_dth/"+xxx;
            window.open(url); 
            window.focus();        

        }

        function cetak2(jenis=''){
            var allskpd   = document.getElementById('allskpd').checked;
            var allperiod = document.getElementById('allperiod').checked;
            var skpd    = $("#sskpd").combogrid('getValue');
            var period1 = $('#period1').datebox('getValue');
            var period2 = $('#period2').datebox('getValue');
            var bulan   = document.getElementById('bulan1').value;            
            var ctglttd = $('#tgl_ttd').datebox('getValue');
            var ttd2    = $("#ttd2").combogrid('getValue');   
            var ttd_2   = ttd2.split(" ").join("AsDfghJklxu");

            if(allskpd==false && skpd==''){
                alert('SKPD Harap diIsi');
                exit();
            }else if(allskpd==true){
                skpd="-";
            }

            if(allperiod==false && (bulan=='')){
                alert('Bulan Harap di isi');
                exit();
            }else if(allperiod==true && (period1==''||period2=='')){
                alert('Periode Harap di isi');
                exit();
            }else if(allperiod==false){
                period1="-";
                period2="-";
            }else if(allperiod==true){
                bulan="-";
            }

            if(ctglttd==''){
                alert('Tanggal tidak boleh kosong!');
                exit();
            }else if(ttd2==''){
                alert('Penandatangan tidak boleh kosong!');
                exit();
            }
            var xxx     = ttd2+"/"+ctglttd+"/"+bulan+"/"+period1+"/"+period2+"/"+skpd+"/"+jenis;
            var url     = "<?php echo site_url(); ?>/tukd/pajak_dth_/"+xxx;
            window.open(url); 
            window.focus();        

        }
        
    </script>

    <STYLE TYPE="text/css"> 
         input.right{ 
         text-align:right; 
         } 
    </STYLE> 

</head>
<body>

<div id="content">

<div id="">
 <h1 style="padding: 4px">DTH REKON PAJAK</h1>
    <fieldset>
 
    <p align="right">         
        <table id="sp2d" title="Cetak Buku Besar" style="width:922px;height:200px;" >  
        <tr >
            <td width="20%" height="40" ><B></B></td>
            <td><input type="checkbox" id="allskpd"  onclick="javascript:runEffect();"/> Cetak Keseluruhan SKPD<br>
                <input type="checkbox" id="allperiod"  onclick="javascript:runEffect();"/> Cetak Berdasarkan Periode
             </td>
        </tr>        
        <tr id="hide">
            <td width="20%" height="40" ><B>SKPD</B></td>
            <td width="80%"><input id="sskpd" name="sskpd" style="width: 200px;" readonly="true"  />&nbsp;&nbsp;<input id="nmskpd" name="nmskpd" style="width: 300px; border:0;" /></td>
        </tr>

        <tr id="hide2">
            <td width="20%" height="40" ><B>BULAN</B></td>
            <td><?php echo $this->rka_model->combo_bulan('bulan1','onchange="javascript:validate1();" style="width: 200px;"'); ?> </td>
        </tr>
        <tr id="hide3">
            <td width="20%" height="40" ><B>PERIODE</B></td>
            <td width="80%"><input id="period1" name="period1" style="width: 200px;" /> s/d <input id="period2" name="period2" style="width: 200px;" /></td>
        </tr>
        <tr >
            <td width="20%" height="40" ><B>TANGGAL TTD</B></td>
            <td width="80%"><input id="tgl_ttd" name="tgl_ttd" style="width: 200px;" /></td>
        </tr>
        <tr >
            <td width="20%" height="40" ><B>Penandatangan</B></td>
            <td width="80%">
                <input type="text" id="ttd2" style="width: 200px;" /> &nbsp;&nbsp;
                <input type="nm_ttd2" id="nm_ttd2" readonly="true" style="width: 200px;border:0" />
            </td>
        </tr>                
    
        <tr >
            <td colspan="2">Keperluan : 
            <a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetak(0);">Cetak KPP</a>
            <a class="easyui-linkbutton" iconCls="icon-excel" plain="true" onclick="javascript:cetak(2);">Cetak KPP</a><br/>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetak2(0);">Cetak KPPN</a>
            <a class="easyui-linkbutton" iconCls="icon-excel" plain="true" onclick="javascript:cetak2(2);">Cetak KPPN</a>
            </td>
        </tr>
        
        </table>                      
    </p> 
    

</div>
</fieldset>
</div>

    
</body>

</html>
