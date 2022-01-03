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
    var kode='';
    
	$(document).ready(function() {
            $("#accordion").accordion();            
            $( "#dialog-modal" ).dialog({
                height: 100,
                width: 922            
            });             
        }); 

      $(function(){
	  $('#sskpd').combogrid({  
		panelWidth:630,  
		idField:'kd_skpd',  
		textField:'kd_skpd',  
		mode:'remote',
		url:'<?php echo base_url(); ?>index.php/rka/skpd',  
		columns:[[  
			{field:'kd_skpd',title:'Kode SKPD',width:100},  
			{field:'nm_skpd',title:'Nama SKPD',width:500}    
		]],
		onSelect:function(rowIndex,rowData){
			kdskpd = rowData.kd_skpd;
			$("#nmskpd").attr("value",rowData.nm_skpd);
			$("#skpd").attr("value",rowData.kd_skpd);
		}  
		});
	});
    
    $(function(){
   	    //$("#status").attr("option",false);
        $("#kode_skpd").hide();
   	});
	
    $(function(){
   	     $('#tgl_ttd').datebox({  
            required:true,
            formatter :function(date){
            	var y = date.getFullYear();
            	var m = date.getMonth()+1;
            	var d = date.getDate();
            	return y+'-'+m+'-'+d;
            }
        });
		
		$('#periode').datebox({  
            required:true,
            formatter :function(date){
            	var y = date.getFullYear();
            	var m = date.getMonth()+1;
            	var d = date.getDate();
            	return y+'-'+m+'-'+d;
            }
        });
		
		
		$('#ttd').combogrid({  
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
				   //$("#nama").attr("value",rowData.nama);
				   nip = rowData.nip; 
			   } 
        });
		
   	});

    
	
	//cdate = '<?php echo date("Y-m-d"); ?>';

	 
	$(function(){
			//$("#status").attr("option",false);
			$("#kode_skpd").hide();
		});  
		function opt(val){  
        ctk = val; 
        if (ctk=='1'){
			$("#kode_skpd").hide();
        }  else {
		   $("#kode_skpd").show();
        }          
    }

	function cetak(pilih)
        {
            //var bulan = document.getElementById("bulan").value;  
            var ttd1 = $('#ttd').combogrid('getValue');     
			var ctglttd = $('#tgl_ttd').datebox('getValue');
			var periode = $('#tgl_ttd').datebox('getValue');
			if(ctglttd==''){
				ctglttd="-";
			}
			if(ttd1==''){
				ttd="-";
			}else{
				ttd=ttd1.split(' ').join('abc');
			}
			if(periode==''){
				alert("Pilih Periode Tanggal terlebih dahulu");
			}
			var url    = "<?php echo site_url(); ?>/lamp_pmk/cetak_pend_skpd"; 
			skpd="-";
			window.open(url+'/'+periode+'/'+pilih+'/-/'+skpd+'/1/'+ctglttd+'/'+ttd+'/PENERIMAAN_SKPD', '_blank');
			window.focus();
        }
		
	function cetak2(pilih)
        {
            //var bulan = document.getElementById("bulan").value;  
            var ttd1 = $('#ttd').combogrid('getValue');     
			var ctglttd = $('#tgl_ttd').datebox('getValue');
			var periode = document.getElementById('bulan').value;
			if(ctglttd==''){
				ctglttd="-";
			}
			if(ttd1==''){
				ttd="-";
			}else{
				ttd=ttd1.split(' ').join('abc');
			}
			if(periode==''){
				alert("Pilih Periode Bulan terlebih dahulu");
			}
			var url    = "<?php echo site_url(); ?>/lamp_pmk/cetak_pend_skpd"; 
			skpd="-";
			window.open(url+'/'+periode+'/'+pilih+'/-/'+skpd+'/2/'+ctglttd+'/'+ttd+'/PENERIMAAN_SKPD', '_blank');
			window.focus();
        }
		
		function cetak3(pilih)
        {
            //var bulan = document.getElementById("bulan").value;  
            var ttd1 = $('#ttd').combogrid('getValue');     
			var ctglttd = $('#tgl_ttd').datebox('getValue');
			var periode = document.getElementById('bulan').value;
			var periode2 = document.getElementById('bulan_akhir').value;
			if(ctglttd==''){
				ctglttd="-";
			}
			if(ttd1==''){
				ttd="-";
			}else{
				ttd=ttd1.split(' ').join('abc');
			}
			if(periode==''){
				alert("Pilih Periode Bulan terlebih dahulu");
			}
			if(periode>periode2){
				alert("Periode Akhir Tak Bisa Lebih Kecil!");
			}else{
			var url    = "<?php echo site_url(); ?>/lamp_pmk/cetak_pend_skpd_bulan"; 
			skpd="-";
			window.open(url+'/'+periode+'/'+pilih+'/-/'+skpd+'/2/'+ctglttd+'/'+ttd+'/'+periode2+'/PENERIMAAN_SKPD', '_blank');
			window.focus();
            }
        }
        
        function cetak4(pilih)
        {
            //var bulan = document.getElementById("bulan").value;  
            var ttd1 = $('#ttd').combogrid('getValue');     
			var ctglttd = $('#tgl_ttd').datebox('getValue');
			var periode = document.getElementById('bulan').value;
			var periode2 = document.getElementById('bulan_akhir').value;
			if(ctglttd==''){
				ctglttd="-";
			}
			if(ttd1==''){
				ttd="-";
			}else{
				ttd=ttd1.split(' ').join('abc');
			}
			if(periode==''){
				alert("Pilih Periode Bulan terlebih dahulu");
			}
			if(periode>periode2){
				alert("Periode Akhir Tak Bisa Lebih Kecil!");
			}else{
			var url    = "<?php echo site_url(); ?>/lamp_pmk/cetak_pend_skpd_bulan_rinci"; 
			skpd="-";
			window.open(url+'/'+periode+'/'+pilih+'/-/'+skpd+'/2/'+ctglttd+'/'+ttd+'/'+periode2+'/PENERIMAAN_SKPD', '_blank');
			window.focus();
            }
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


<h3>CETAK LAPORAN PENERIMAAN SKPD</h3>
<div id="accordion">
    <p align="center">         
        <table id="sp2d" title="CETAK LAPORAN PENERIMAAN SKPD" width="100%" border="0">  
   <!-- <tr><td colspan="2"><input type="radio" name="status" value="1" onclick="opt(this.value)" /><b>Keseluruhan</b></td></tr>
	<tr><td colspan="2"><input type="radio" name="status" value="2" id="status" onclick="opt(this.value)" /><b>Per Unit</b>
                    <div id="kode_skpd">
                        <table style="width:100%;" border="0">
                            <tr >
                    			<td width="22px" height="40%" ><B>Unit&nbsp;&nbsp;</B></td>
                    			<td width="900px"><input id="sskpd" name="sskpd" style="width: 100px;" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="nmskpd" name="nmskpd" style="width: 670px; border:0;" /></td>
                    		</tr>
                        </table> 
                    </div>
        </td>
        </tr>	
		
	<tr>
	<td width="20%"> Periode</td> 
	<td width="70%" style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;"><select  name="bulan" id="bulan" >
     <option value="1">Januari</option>
     <option value="2">Februari</option>
     <option value="3">Maret</option>
     <option value="4">April </option>
     <option value="5">Mei </option>
     <option value="6">Juni </option>
     <option value="7">Juli </option>
     <option value="8">Agustus </option>
     <option value="9">September </option>
     <option value="10">Oktober </option>
     <option value="11">Nopember </option>
     <option value="12">Desember </option>
   </select></td> 
   </tr>
    -->
	<tr>
	<td>Periode Per Tanggal</td>
	<td><input type="text" id="periode" style="width: 150px;" /> </td> 
	</tr>
    <tr>
    <td>Periode Per Bulan</td>
    <td>
    <table style="width:50%;" border="0">
        <tr>					
					<td >
						<select name="bulan" id="bulan">    
						 <option value="1"> Januari </option> 
						 <option value="2"> Februari </option>
						 <option value="3"> Maret </option>
						 <option value="4"> April </option> 
						 <option value="5"> Mei </option>
						 <option value="6"> Juni </option>
						 <option value="7"> Juli </option> 
						 <option value="8"> Agustus </option>
						 <option value="9"> September </option>
						 <option value="10"> Oktober </option> 
						 <option value="11"> November </option>
						 <option value="12"> Desember </option> 
                         </select>
					</td>
                    <td>&nbsp; S/D</td>
                    <td>
                        <select name="bulan_akhir" id="bulan_akhir">    
						 <option value="1"> Januari </option> 
						 <option value="2"> Februari </option>
						 <option value="3"> Maret </option>
						 <option value="4"> April </option> 
						 <option value="5"> Mei </option>
						 <option value="6"> Juni </option>
						 <option value="7"> Juli </option> 
						 <option value="8"> Agustus </option>
						 <option value="9"> September </option>
						 <option value="10"> Oktober </option> 
						 <option value="11"> November </option>
						 <option value="12"> Desember </option> 
                         </select>
                    </td>
         </tr>           
				</table>
    
    </td>
    
    </tr>
	<tr>
	<td>Tanggal TTD</td>
	<td><input type="text" id="tgl_ttd" style="width: 150px;" /> </td> 
	</tr>
    <tr>
	<td>Penandatanganan</td>
	<td><input type="text" id="ttd" style="width: 200px;" /> </td> 
	</tr>
	
	<tr>
		<td> Cetak Pertanggal</td> 
		<td align="left"> 
		<a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetak(0);">Layar</a>
		<a class="easyui-linkbutton" iconCls="icon-pdf" plain="true" onclick="javascript:cetak(1);">PDF</a>
		<a class="easyui-linkbutton" iconCls="icon-excel" plain="true" onclick="javascript:cetak(2);">excel</a>
		</td>
	</tr>
	
	<tr>
		<td> Cetak Perbulan</td> 
		<td align="left"> 
		<a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetak2(0);">Layar</a>
		<a class="easyui-linkbutton" iconCls="icon-pdf" plain="true" onclick="javascript:cetak2(1);">PDF</a>
		<a class="easyui-linkbutton" iconCls="icon-excel" plain="true" onclick="javascript:cetak2(2);">excel</a>
		</td>
	</tr>
    <tr>
		<td> Cetak Periode s/d bulan</td> 
		<td align="left"> 
		<a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetak3(0);">Layar</a>
		<a class="easyui-linkbutton" iconCls="icon-pdf" plain="true" onclick="javascript:cetak3(1);">PDF</a>
		<a class="easyui-linkbutton" iconCls="icon-excel" plain="true" onclick="javascript:cetak3(2);">excel</a>
		</td>
	</tr>
    <tr>
		<td> Cetak Sub Rincian Periode s/d bulan</td> 
		<td align="left"> 
		<a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetak4(0);">Layar</a>
		<a class="easyui-linkbutton" iconCls="icon-pdf" plain="true" onclick="javascript:cetak4(1);">PDF</a>
		<a class="easyui-linkbutton" iconCls="icon-excel" plain="true" onclick="javascript:cetak4(2);">excel</a>
		</td>
	</tr>
        </table>                      
    </p> 
  </div> 
</div>

 	
</body>

</html>