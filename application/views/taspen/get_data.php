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

	function rekal(){		
        var x = document.getElementById('kebutuhan_bulan').value;
        
        if(x==''){
            alert('Pilih Bulan');
            document.getElementById('load').style.visibility='hidden';
            exit();
        }else{
        document.getElementById('load').style.visibility='visible';
		$(function(){      
		 $.ajax({
			type: 'POST',
			data: ({nomor:'1'}),
			dataType:"json",
			url:"<?php echo base_url(); ?>index.php/tukd/proses_taspen",
			success:function(data){
				if (data == '1'){
					alert('BERHASIL DIPROSES');
				}else{
					alert('GAGAL DIPROSES');					
				}
				document.getElementById('load').style.visibility='hidden';
			}
		 });
		});
        }
	}

    </script>

</head>
<body>

<div id="content">

<div id="accordion">
<h3>TASPEN AMBIL DATA</h3>
    <div>
    <p >         
        <table id="sp2d" title="Taspen" style="width:870px;height:300px;" >  
		<tr>
            <td><b>BULAN</b> &nbsp;<select  name="kebutuhan_bulan" id="kebutuhan_bulan" style="width:200px;" >
     <option value="">...Pilih Kebutuhan Bulan... </option>
     <option value="1" >1 | Januari</option>
     <option value="2">2 | Februari</option>
     <option value="3">3 | Maret</option>
     <option value="4">4 | April</option>
     <option value="5">5 | Mei</option>
     <option value="6">6 | Juni</option>
     <option value="7">7 | Juli</option>
     <option value="8">8 | Agustus</option>
     <option value="9">9 | September</option>
     <option value="10">10 | Oktober</option>
     <option value="11">11 | November</option>
     <option value="12">12 | Desember</option>
   </select></td>
        </tr>
        <tr >
			<td width="100%" align="center"> <INPUT TYPE="button" VALUE="PROSES" style="height:40px;width:100px" onclick="rekal()" >
			</td>
		</tr>
		<tr height="70%" >
			<td align="center" style="visibility:hidden" >	<DIV id="load" > <IMG SRC="<?php echo base_url(); ?>assets/images/mapping.gif" WIDTH="270" HEIGHT="40" BORDER="0" ALT=""></DIV></td>
		</tr>
        </table>                      
    </p> 
    </div>
</div>
</div>
</body>
</html>