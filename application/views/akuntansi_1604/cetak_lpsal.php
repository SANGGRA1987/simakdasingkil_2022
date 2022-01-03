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
  <style>    
    #tagih {
        position: relative;
        width: 922px;
        height: 100px;
        padding: 0.4em;
    }  
    </style>
    <script type="text/javascript"> 
    var nip='';
	var kdskpd='';
	var kdrek5='';
    var pilihttd='';
    
     $(document).ready(function() {
            $("#accordion").accordion();            
            $( "#dialog-modal" ).dialog({
                height: 100,
                width: 922            
            });             
            
            $('#tgl_ttd1').datebox({  
            required:true,
            formatter :function(date){
            	var y = date.getFullYear();
            	var m = date.getMonth()+1;
            	var d = date.getDate();
            	return y+'-'+m+'-'+d;
            }
        });
            
        });   
    
	function hit($hit){
		var ht = $hit;
		if(ht=="1"){
		document.getElementById('load').style.visibility='visible';
		$(function(){      
		 $.ajax({
			type: 'POST',			
			dataType:"json",
			url:"<?php echo base_url(); ?>index.php/akuntansi/hitung_lpsal",
			success:function(data){
				if (data = 1){
					document.getElementById('load').style.visibility='hidden';
					alert('Penghitungan Selesai');
					//$('#cetak0').linkbutton('enable');
					$('#cetak1').linkbutton('enable');
					$('#cetak2').linkbutton('enable');					
				}
			}

		 });
		});
		}
	}
	
	/*function cet($hit){
		var ht = $hit;
		if(ht=="1"){		
			$('#cetak0').linkbutton('enable');
			$('#cetak1').linkbutton('enable');
			$('#cetak2').linkbutton('enable');									
		}				
	}*/
	
    function runEffect() {        
			$('#qttd2')._propAttr('checked',false);
		    pilihttd = "1";  	
		};  
		
		function runEffect2() {        
			$('#qttd')._propAttr('checked',false);
            pilihttd = "2";
		};
    
    function cetak($ctk)
        {
			
			/*var txt;
			var r = confirm("Pilih [OKE] untuk Cetak menggunakan Tanda Tangan");
			if (r == true) {
			txt = "1";
			} else {
			txt = "0";
			}*/
			
            var initx = pilihttd;            
            var ctglttd = $('#tgl_ttd1').datebox('getValue'); 
            
            var cetak =$ctk;                      
			var url    = "<?php echo site_url(); ?>/akuntansi/ctk_lpsal";	  
			window.open(url+'/'+cetak+'/'+initx+'/'+ctglttd, '_blank');
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



<h3>CETAK LAPORAN PERUBAHAN SALDO ANGGARAN LEBIH </h3>       
<div id="accordion">
    
    <p align="right">         
        <table id="sp2d" title="Cetak" style="width:922px;height:200px;">          
        <tr >
			<td colspan="2" align="center">			
			<a class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:hit(1);">Perhitungan Kembali LPSAL</a>
            </td>
		</tr>        
		<tr >
			<td colspan="2" align="center">
			<br/>
            </td>
		</tr>    
        <tr>
                <td>
                <input id="qttd2" name="qttd2" type="checkbox" value="2" onclick="javascript:runEffect2();"/> Tanpa TTD 
                <input id="qttd" name="qttd" type="checkbox" value="1" onclick="javascript:runEffect();"/> Dengan TTD &nbsp;&nbsp;                               
                <input type="text" id="tgl_ttd1" style="width: 100px;" />
                </td>
        </tr>        
		    
		<tr >
			<td colspan="2">
			<a id="cetak0" class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetak(0);">Cetak Layar</a>	
			<a id="cetak0" class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetak(1);">Cetak PDF</a>
            <a id="cetak1" class="easyui-linkbutton" iconCls="icon-excel" disabled plain="true" onclick="javascript:cetak(2);">Cetak excel</a>
            <a id="cetak2" class="easyui-linkbutton" iconCls="icon-word" disabled plain="true" onclick="javascript:cetak(3);">Cetak word</a></td>
		</tr>
		<tr height="70%" >
			<td colspan="2" align="center"><br/></td>
		</tr>		
		<tr height="70%" >
			<td colspan="2" align="center" style="visibility:hidden" >	
			<DIV id="load" > <b>Sedang Proses Perhitungan</b><IMG SRC="<?php echo base_url(); ?>assets/images/loading.gif" WIDTH="300" HEIGHT="50" BORDER="0" ALT=""></DIV></td>
		</tr>		
        </table>                      
    </p> 
    

</div>

</div>

 	
</body>

</html>