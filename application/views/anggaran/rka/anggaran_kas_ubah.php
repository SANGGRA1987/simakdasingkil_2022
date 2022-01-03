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
   
    <script>
    var kode='';
    var kegiatan='';
		

     $(document).ready(function() {
            $("#accordion").accordion();
            $("#kegi").hide();
        });
  
      $(function(){
        $('#cc').combogrid({  
            panelWidth:700,  
            idField:'kd_skpd',  
            textField:'kd_skpd',  
            mode:'remote',
            url:'<?php echo base_url(); ?>index.php/rka/skpduser',  
            columns:[[  
                {field:'kd_skpd',title:'Kode SKPD',width:100},  
                {field:'nm_skpd',title:'Nama SKPD',width:700}    
            ]],
            onSelect:function(rowIndex,rowData){
                $("#kegi").hide();
                kode = rowData.kd_skpd;
                $("#ck").combogrid("clear"); 
                giat(kode);  
                setTimeout(tampil,5000);
                rek('');

            }  
        }); 
      });
      
      
      $(function(){ 
           $('#ck').combogrid({
                panelWidth:700,  
                idField:'kd_kegiatan',  
                textField:'kd_kegiatan',  
                mode:'remote',
                url:'<?php echo base_url(); ?>index.php/rka/load_giat',  
                columns:[[  
                    {field:'kd_kegiatan',title:'Kode Kegiatan',width:130},  
                    {field:'nm_kegiatan',title:'Nama Kegiatan',width:570}    
                ]] 
            });          
         }); 
     
     $(function(){ 
     $('#dg').edatagrid({
		url: '<?php echo base_url(); ?>/index.php/rka/select_rka',
        idField:'id',
        toolbar:"#toolbar",              
        rownumbers:"true", 
        fitColumns:"true",
        singleSelect:"true",
        columns:[[
    	    {field:'kd_rek5',
    		title:'Kode Rekening',
    		width:50},
            {field:'nm_rek5',
    		title:'Nama Rekening',
    		width:200},
            {field:'nilai_ubah',
    		title:'Nilai Perubahan',
    		width:100,
            align:"right"}
        ]]
    });
    });

     function tampil(){
        $("#kegi").show();
     }
     function giat(kode){
            //alert(''+kode);
            
          $(function(){  
            $('#ck').combogrid({
                panelWidth:700,  
                idField:'kd_kegiatan',  
                textField:'kd_kegiatan',  
                mode:'remote',
                url:'<?php echo base_url(); ?>index.php/rka/load_giat/'+kode,
                columns:[[  
                    {field:'kd_kegiatan',title:'Kode Kegiatan',width:150},  
                    {field:'nm_kegiatan',title:'Nama Kegiatan',width:550}    
                ]], 
                onSelect:function(rowIndex,rowData){
                    kegiatan=rowData.kd_kegiatan;
                    total=rowData.total_ubah;
                    skpdd=rowData.kd_skpd;
                    $("#jumlah").attr("value",total);
                    $("#skpdd").attr("value",skpdd);    
                    rek(kegiatan);
                    anggkas_keg();  
//					get_realisasi_triw(kegiatan); 					
                }
            });          
            
         }); 
     }
      function anggkas_keg(){
       var a = $('#cc').combogrid('getValue');
       var b =  $('#ck').combogrid('getValue');
       
       //semester I
        
        $(function(){      
         $.ajax({
            type: 'POST',
            data:({skpd:a,keg:b}),
            url:"<?php echo base_url(); ?>index.php/rka/get_realisasi_keg_sms1",
            dataType:"json",
            success:function(data){ 
                $.each(data, function(i,n){
                    $("#realtriw1").attr("value",n['nrealisasi']);
                });
            }
         });
        });
      
       //semester II
        
        $(function(){      
         $.ajax({
            type: 'POST',
            data:({skpd:a,keg:b}),
            url:"<?php echo base_url(); ?>index.php/rka/get_realisasi_keg_sms2",
            dataType:"json",
            success:function(data){ 
                $.each(data, function(i,n){
                    $("#realtriw2").attr("value",n['nrealisasi']);
                });
            }
         });
        }); 
        
      //semester III
        
        $(function(){      
         $.ajax({
            type: 'POST',
            data:({skpd:a,keg:b}),
            url:"<?php echo base_url(); ?>index.php/rka/get_realisasi_keg_sms3",
            dataType:"json",
            success:function(data){ 
                $.each(data, function(i,n){
                    $("#realtriw3").attr("value",n['nrealisasi']);
                });
            }
         });
        });          
        
      //semester IV
        
        $(function(){      
         $.ajax({
            type: 'POST',
            data:({skpd:a,keg:b}),
            url:"<?php echo base_url(); ?>index.php/rka/get_realisasi_keg_sms4",
            dataType:"json",
            success:function(data){ 
                $.each(data, function(i,n){
                    $("#realtriw4").attr("value",n['nrealisasi']);
                });
            }
         });
        });          

    } 
 
	function rek(kegiatan){
        $(function(){  
            $('#dg').edatagrid({
    		  url: '<?php echo base_url(); ?>/index.php/rka/select_rka/'+kegiatan
            });
        });
        load();                
      }
     
     function section1(){
         $(document).ready(function(){    
             $('#section1').click();                                               
         });
     }
     function section2(){
		 if(kegiatan==''){
            alert('Kode Kegiatan Belum dipilih');
            return;   
         }

         $(document).ready(function(){    
             $('#section2').click();                                               
         });
         kosongkan();
         load();
     }
     

    
	function hitung(){    
        var jumlah = angka(document.getElementById('jumlah').value);
        var a = angka(document.getElementById('jan').value);
        var b = angka(document.getElementById('feb').value);
        var c = angka(document.getElementById('mar').value); 
        var d = angka(document.getElementById('apr').value);
        var e = angka(document.getElementById('mei').value);
        var f = angka(document.getElementById('jun').value);
        var g = angka(document.getElementById('jul').value);
        var h = angka(document.getElementById('ags').value);
        var i = angka(document.getElementById('sep').value); 
        var j = angka(document.getElementById('okt').value);
        var k = angka(document.getElementById('nov').value);
        var l = angka(document.getElementById('des').value);  
           
        tr1=eval(a+'+'+b+'+'+c);
        tr2=eval(d+'+'+e+'+'+f);
        tr3=eval(g+'+'+h+'+'+i);
        tr4=eval(j+'+'+k+'+'+l);
        
        atr2=tr1+tr2;
        atr3=tr1+tr2+tr3;
        atr4=tr1+tr2+tr3+tr4;        
        
        $("#tr1").attr("value",number_format(tr1,2,'.',',')); 
        $("#tr2").attr("value",number_format(tr2,2,'.',','));
        $("#tr3").attr("value",number_format(tr3,2,'.',','));
        $("#tr4").attr("value",number_format(tr4,2,'.',','));

        $("#atr2").attr("value",number_format(atr2,2,'.',','));
        $("#atr3").attr("value",number_format(atr3,2,'.',','));
        $("#atr4").attr("value",number_format(atr4,2,'.',','));
        
        kas=tr1+tr2+tr3+tr4;
        $("#kas").attr("value",number_format(kas,2,'.',','));
        selisih=jumlah-kas;
        $("#selisih").attr("value",number_format(selisih,2,'.',','));
//        if (selisih < 0){
//            alert('Total Anggaran Kas lebih Besar Dari Anggaran Kegiatan....!!!!');        
//        }
        
     }
     
     
	function bagi(){
        var total = angka(document.getElementById('jumlah').value);
		var tot   = angka(document.getElementById('jumlah').value);
		var rata=Math.floor(total/12);
		var trata = rata*12;
		var selisih = total-trata;

        $("#jan").attr("value",number_format(rata,2,'.',','));
        $("#feb").attr("value",number_format(rata,2,'.',','));
        $("#mar").attr("value",number_format(rata,2,'.',','));
        $("#apr").attr("value",number_format(rata,2,'.',','));
        $("#mei").attr("value",number_format(rata,2,'.',','));
        $("#jun").attr("value",number_format(rata,2,'.',','));
        $("#jul").attr("value",number_format(rata,2,'.',','));
        $("#ags").attr("value",number_format(rata,2,'.',','));
        $("#sep").attr("value",number_format(rata,2,'.',','));
        $("#okt").attr("value",number_format(rata,2,'.',','));
        $("#nov").attr("value",number_format(rata,2,'.',','));
        $("#des").attr("value",number_format(rata,2,'.',','));
        $("#tr1").attr("value",number_format(rata*3,2,'.',','));
        $("#tr2").attr("value",number_format(rata*3,2,'.',','));
        $("#tr3").attr("value",number_format(rata*3,2,'.',','));
        $("#tr4").attr("value",number_format(rata*3,2,'.',','));
        $("#atr2").attr("value",number_format(rata*6,2,'.',','));
        $("#atr3").attr("value",number_format(rata*9,2,'.',','));
        $("#atr4").attr("value",number_format(rata*12,2,'.',','));
        $("#kas").attr("value",number_format(trata,2,'.',','));
        $("#selisih").attr("value",number_format(selisih,2,'.',','));		
	}

    function kosongkan(){
        $("#jan").attr("value",number_format(0,2,'.',','));
        $("#feb").attr("value",number_format(0,2,'.',','));
        $("#mar").attr("value",number_format(0,2,'.',','));
        $("#apr").attr("value",number_format(0,2,'.',','));
        $("#mei").attr("value",number_format(0,2,'.',','));
        $("#jun").attr("value",number_format(0,2,'.',','));
        $("#jul").attr("value",number_format(0,2,'.',','));
        $("#ags").attr("value",number_format(0,2,'.',','));
        $("#sep").attr("value",number_format(0,2,'.',','));
        $("#okt").attr("value",number_format(0,2,'.',','));
        $("#nov").attr("value",number_format(0,2,'.',','));
        $("#des").attr("value",number_format(0,2,'.',','));
        $("#tr1").attr("value",number_format(0,2,'.',','));
        $("#tr2").attr("value",number_format(0,2,'.',','));
        $("#tr3").attr("value",number_format(0,2,'.',','));
        $("#tr4").attr("value",number_format(0,2,'.',','));
        $("#atr1").attr("value",number_format(0,2,'.',','));
        $("#atr2").attr("value",number_format(0,2,'.',','));
        $("#atr3").attr("value",number_format(0,2,'.',','));
		$("#atr4").attr("value",number_format(0,2,'.',','));
        $("#kas").attr("value",number_format(0,2,'.',','));
        $("#selisih").attr("value",number_format(0,2,'.',','));
     }      
 
	
     function simpan(){

        var a = angka(document.getElementById('jan').value);
        var b = angka(document.getElementById('feb').value);
        var c = angka(document.getElementById('mar').value); 
        var d = angka(document.getElementById('apr').value);
        var e = angka(document.getElementById('mei').value);
        var f = angka(document.getElementById('jun').value);
        var g = angka(document.getElementById('jul').value);
        var h = angka(document.getElementById('ags').value);
        var i = angka(document.getElementById('sep').value); 
        var j = angka(document.getElementById('okt').value);
        var k = angka(document.getElementById('nov').value);
        var l = angka(document.getElementById('des').value);  
        var m = angka(document.getElementById('tr1').value);
        var n = angka(document.getElementById('tr2').value);
        var o = angka(document.getElementById('tr3').value);
        var p = angka(document.getElementById('tr4').value);
		
        var nselisih = angka(document.getElementById('selisih').value);
        /*
        var ntr1 = angka(document.getElementById('tr1').value);
        var ntr2 = angka(document.getElementById('atr2').value);
        var ntr3 = angka(document.getElementById('atr3').value);
        var ntr4 = angka(document.getElementById('atr4').value);
        
        var nrtr1 = angka(document.getElementById('rtr1').value);
        var nrtr2 = angka(document.getElementById('rtr2').value);
        var nrtr3 = angka(document.getElementById('rtr3').value);
        var nrtr4 = angka(document.getElementById('rtr4').value);
        */
        var realtw1 = angka(document.getElementById('realtriw1').value);
        var realtw2 = angka(document.getElementById('realtriw2').value);
        var realtw3 = angka(document.getElementById('realtriw3').value);
        var realtw4 = angka(document.getElementById('realtriw4').value);

        
        if(nselisih<0){
            alert('Pembagian Anggaran Melebihi Total Anggaran...!!!');
            return;
        }
        
		if(nselisih>0){
            alert('Masih ada sisa Anggaran yang belum dibagi...!!!');
            return;
        }		

        if(m<realtw1){
            alert('nilai anggaran kas kurang dari nilai realisasi di Triwulan 1');
            return;
        }
        if(n<realtw2){
            alert('nilai anggaran kas kurang dari nilai realisasi di Triwulan 2');
            return;
        }
        if(o<realtw3){
            alert('nilai anggaran kas kurang dari nilai realisasi di Triwulan 3');
            return;
        }
        if(p<realtw4){
            alert('nilai anggaran kas kurang dari nilai realisasi di Triwulan 4');
            return;
        } 
/*
        switch (true) {
            case (ntr1 < nrtr1) :
                alert('Nilai Anggaran Kas Triw I lebih kecil dari Realisasi Triw I...!!!');
                return;
            break;
            case (ntr2 < nrtr2) :
                alert('Nilai Akumulasi Anggaran Kas Triw II lebih kecil dari Akum. Realisasi Triw II...!!!');
                return;
            break;
            case (ntr3 < nrtr3) :
                alert('Nilai Akumulasi Anggaran Kas Triw III lebih kecil dari Akum. Realisasi Triw III...!!!');
                return;
            break;
            case (ntr4 < nrtr4) :
                alert('Nilai Akumulasi Anggaran Kas Triw IV lebih kecil dari Akum. Realisasi Triw IV...!!!');
                return;
            break;
        }       
 */       
             
        
        $(function(){      
         $.ajax({
            type: 'POST',
            data: ({csts:'susun',cskpda:kode,cskpd:skpdd,cgiat:kegiatan,jan:a,feb:b,mar:c,apr:d,mei:e,jun:f,jul:g,ags:h,sep:i,okt:j,nov:k,des:l,tr1:m,tr2:n,tr3:o,tr4:p}),
            dataType:"json",
            url:"<?php echo base_url(); ?>index.php/rka/simpan_trskpd_ubah",
            success:function(data){
                if (data = 1){
                    alert('Data Berhasil Tersimpan...!!!');
                }else{
                    alert('Data Gagal Berhasil Tersimpan...!!!');
                }
            }
         });
        });
    }

    
    function load(){ 
        
        $(function(){      
         $.ajax({
            type: 'POST',
            data:({p:kegiatan,jns:'susun'}),
            url:"<?php echo base_url(); ?>index.php/rka/load_trdskpd_ubah",
            dataType:"json",
            success:function(data){ 
                $.each(data, function(i,n){
                    bulan = n['bulan'];
                     switch (bulan) {
                        case '1':
                             $("#jan").attr("value",n['nilai']);
                        break;
                        case '2':
                             $("#feb").attr("value",n['nilai']);
                        break;
                        case '3':
                             $("#mar").attr("value",n['nilai']);
                        break;
                        case '4':
                             $("#apr").attr("value",n['nilai']);
                        break;
                        case '5':
                             $("#mei").attr("value",n['nilai']);
                        break;
                        case '6':
                             $("#jun").attr("value",n['nilai']);
                        break;
                        case '7':
                             $("#jul").attr("value",n['nilai']);
                        break;
                        case '8':
                             $("#ags").attr("value",n['nilai']);
                        break;
                        case '9':
                             $("#sep").attr("value",n['nilai']);
                        break;
                        case '10':
                             $("#okt").attr("value",n['nilai']);
                        break;
                        case '11':
                             $("#nov").attr("value",n['nilai']);
                        break;
                        case '12':
                             $("#des").attr("value",n['nilai']);
                        break;
                     }
                     hitung();
                });
            }
         });
        });
    }
	
	function enter(ckey,_cid,_id){
        if (ckey==13 || ckey==9){    	       	       	    	   
        	   document.getElementById(_cid).focus();            
        	   ck = document.getElementById(_id).value;
               if(ck==0){
                   document.getElementById(_id).value = number_format(0,2,'.',',');
               }
            }     
       
    }  
   </script>

</head>
<body>



<div id="content"> 
   
<div id="accordion">
<h3><a href="#" id="section1">Anggaran Kas Perubahan</a></h3>
   <div  style="height: 350px;">
   <p>
        <h3>S K P D&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="cc" name="skpd" style="width: 400px;"/> </h3>
        <div id="kegi"><h3>KEGIATAN&nbsp;&nbsp;&nbsp;<input id="ck" name="kegiatan" style="width: 400px;" /> </h3>
        </div>
        <br /><input id="s" type="submit" name="submit" value="Input Anggaran Kas Perubahan" onclick="javascript:section2();"/><br /><br />
        
        
        <table id="dg" title="Rekening Rencana Kegiatan Anggaran" style="width:870px;height:350px;" >  
        </table>  
   </p>
    </div>
    
<h3><a href="#" id="section2"></a></h3>
    <div>
    <p>
    <div class="result">
        <table align="center">
            <tr>
                <td><b>Total Anggaran Perubahan</td>
                <td width="30%"><input type="decimal" disabled="true" id="jumlah" name="jumlah" style="text-align: right;" ></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td><b>Januari</td>
                <td><input type="decimal" id="jan" name="jan" value="0" onclick="javascript:select();" onkeyup="javascript:hitung();" style="text-align: right;"  onkeypress="javascript:enter(event.keyCode,'feb','jan');return(currencyFormat(this,',','.',event))"/></td>
                <td><b>April</td>
                <td><input type="decimal" id="apr" name="apr" value="0"  onclick="javascript:select();" onkeyup="javascript:hitung();" style="text-align: right;" onkeypress="javascript:enter(event.keyCode,'mei','apr');return(currencyFormat(this,',','.',event))"/></td>
            </tr>
            <tr>
                <td><b>Februari</td>
                <td><input type="decimal" id="feb" name="feb" value="0" onclick="javascript:select();" onkeyup="javascript:hitung();" style="text-align: right;" onkeypress="javascript:enter(event.keyCode,'mar','feb');return(currencyFormat(this,',','.',event))"/></td>
                <td><b>Mei</td>
                <td><input type="decimal" id="mei" name="mei" value="0"  onclick="javascript:select();" onkeyup="javascript:hitung();" style="text-align: right;" onkeypress="javascript:enter(event.keyCode,'jun','mei');return(currencyFormat(this,',','.',event))"/></td>
            </tr>
            <tr>
                <td><b>Maret</td>
                <td><input type="decimal" id="mar" name="mar" value="0" onclick="javascript:select();" onkeyup="javascript:hitung();" style="text-align: right;" onkeypress="javascript:enter(event.keyCode,'apr','mar');return(currencyFormat(this,',','.',event))" /></td>
                <td><b>Juni</td>
                <td><input type="decimal" id="jun" name="jun" value="0"  onclick="javascript:select();" onkeyup="javascript:hitung();" style="text-align: right;" onkeypress="javascript:enter(event.keyCode,'jul','jun');return(currencyFormat(this,',','.',event))"/></td>
            </tr>
            <tr>
                <td><b>Triwulan I</td>
                <td><input type="decimal" disabled="true" align="right" id="tr1" name="tr1" style="text-align: right;" onkeypress="javascript:return(currencyFormat(this,',','.',event))"/></td>
                <td><b>Triwulan II</td>
                <td><input type="decimal" disabled="true" align="right" id="tr2" name="tr2" style="text-align: right;" onkeypress="javascript:return(currencyFormat(this,',','.',event))"/></td>
            </tr>
            <tr>
                <td><b>Realisasi Keg. I</td>
                <td><input type="decimal" disabled="true" align="right" id="realtriw1" name="realtriw1" style="text-align: right;"/></td>
                <td><b>Realisasi Keg. II</td>
                <td><input type="decimal" disabled="true" align="right" id="realtriw2" name="realtriw2" style="text-align: right;"/></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td hidden><b>Akum. Triwulan II</td>
                <td hidden><input type="decimal" disabled="true" align="right" id="atr2" name="atr2" style="text-align: right;" onkeypress="javascript:return(currencyFormat(this,',','.',event))"/></td>
            </tr>
            <tr>
                <td hidden><b>Realisasi Triw. I</td>
                <td hidden><input type="decimal" disabled="true" align="right" id="rtr1" name="rtr1" style="text-align: right;" onkeypress="javascript:return(currencyFormat(this,',','.',event))"/></td>
                <td hidden><b>Akum. Realisasi Triw. II</td>
                <td hidden><input type="decimal" disabled="true" align="right" id="rtr2" name="rtr2" style="text-align: right;" onkeypress="javascript:return(currencyFormat(this,',','.',event))"/></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td><b>Juli</td>
                <td><input type="decimal" id="jul" name="jul" value="0" onclick="javascript:select();" onkeyup="javascript:hitung();" style="text-align: right;" onkeypress="javascript:enter(event.keyCode,'ags','jul');return(currencyFormat(this,',','.',event))"/></td>
                <td><b>Oktober</td>
                <td><input type="decimal" id="okt" name="okt" value="0" onclick="javascript:select();" onkeyup="javascript:hitung();" style="text-align: right;" onkeypress="javascript:enter(event.keyCode,'nov','okt');return(currencyFormat(this,',','.',event))"/></td>
            </tr>
            <tr>
                <td><b>Agustus</td>
                <td><input type="decimal" id="ags" name="ags" value="0" onclick="javascript:select();" onkeyup="javascript:hitung();" style="text-align: right;" onkeypress="javascript:enter(event.keyCode,'sep','ags');return(currencyFormat(this,',','.',event))"/></td>
                <td><b>November</td>
                <td><input type="decimal" id="nov" name="nov" value="0" onclick="javascript:select();" onkeyup="javascript:hitung();" style="text-align: right;" onkeypress="javascript:enter(event.keyCode,'des','nov');return(currencyFormat(this,',','.',event))"/></td>
            </tr>
            <tr>
                <td><b>September</td>
                <td><input type="decimal" id="sep" name="sep" value="0" onclick="javascript:select();" onkeyup="javascript:hitung();" style="text-align: right;" onkeypress="javascript:enter(event.keyCode,'okt','sep');return(currencyFormat(this,',','.',event))"/></td>
                <td><b>Desember</td>
                <td><input type="decimal" id="des" name="des" value="0" onclick="javascript:select();" onkeyup="javascript:hitung();" style="text-align: right;" onkeypress="javascript:enter(event.keyCode,'nov','des');javascript:return(currencyFormat(this,',','.',event))"/></td>
            </tr>
            <tr>
                <td><b>Triwulan III</td>
                <td><input type="decimal" disabled="true" id="tr3" name="tr3" style="text-align: right;" onkeypress="javascript:return(currencyFormat(this,',','.',event))"/></td>
                <td><b>Triwulan IV</td>
                <td><input type="decimal" disabled="true" id="tr4" name="tr4" style="text-align: right;" onkeypress="javascript:return(currencyFormat(this,',','.',event))"/></td>
            </tr>
            <tr>
                <td><b>Realisasi Keg. III</td>
                <td><input type="decimal" disabled="true" align="right" id="realtriw3" name="realtriw3" style="text-align: right;"/></td>
                <td><b>Realisasi Keg. IV</td>
                <td><input type="decimal" disabled="true" align="right" id="realtriw4" name="realtriw4" style="text-align: right;"/></td>
            </tr>
            <tr>
                <td hidden><b>Akum. Triwulan III</td>
                <td hidden><input type="decimal" disabled="true" id="atr3" name="atr3" style="text-align: right;" onkeypress="javascript:return(currencyFormat(this,',','.',event))"/></td>
                <td hidden><b>Akum. Triwulan IV</td>
                <td hidden><input type="decimal" disabled="true" id="atr4" name="atr4" style="text-align: right;" onkeypress="javascript:return(currencyFormat(this,',','.',event))"/></td>
            </tr>
            <tr>
                <td hidden><b>Akum. Realisasi Triw. III</td>
                <td hidden><input type="decimal" disabled="true" id="rtr3" name="rtr3" style="text-align: right;" onkeypress="javascript:return(currencyFormat(this,',','.',event))"/></td>
                <td hidden><b>Akum. Realisasi Triw. IV</td>
                <td hidden><input type="decimal" disabled="true" id="rtr4" name="rtr4" style="text-align: right;" onkeypress="javascript:return(currencyFormat(this,',','.',event))"/></td>
            </tr>            
            <tr>
                <td>&nbsp;</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td><b>Total Anggaran Kas Perubahan</td>
                <td><input type="decimal" disabled="true" id="kas" name="kas" style="text-align: right;" onkeypress="javascript:return(currencyFormat(this,',','.',event))"/></td>
                <td><b>Selisih</td>
                <td><input type="decimal" disabled="true" id="selisih" name="selisih" style="text-align: right;" onkeypress="javascript:return(currencyFormat(this,',','.',event))"/></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="4"><input type="submit" name="submit" id="submit" value="Simpan" onclick="javascript:simpan();"/>
                    <input type="submit" name="submit" value="Kosongkan" onclick="javascript:kosongkan();"/>
                    <input type="submit" name="submit" value="Bagi Rata" onclick="javascript:bagi();"/>
                    <input type="submit" name="submit" value="Kembali" onclick="javascript:section1();"/></td>
            </tr>             
        </table>
        </div>
    </p> 
    </div>   

</div>

</div>  	
</body>

</html>