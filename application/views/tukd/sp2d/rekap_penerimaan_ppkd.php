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
    
     $(document).ready(function() {
        
        $("#div_bulan").hide();
       $("#div_periode").hide(); 
       
            $("#accordion").accordion();            
            $( "#dialog-modal" ).dialog({
                height: 400,
                width: 800            
            });
             get_skpd();               
        });   
    
	$(function(){
//	$('#sskpd').combogrid({  
//		panelWidth:630,  
//		idField:'kd_skpd',  
//		textField:'kd_skpd',  
//		mode:'remote',
//		url:'<?php echo base_url(); ?>index.php/tukd/skpd_2',  
//		columns:[[  
//			{field:'kd_skpd',title:'Kode SKPD',width:100},  
//			{field:'nm_skpd',title:'Nama SKPD',width:500}    
//		]],
//		onSelect:function(rowIndex,rowData){
//			kdskpd = rowData.kd_skpd;
//			$("#nmskpd").attr("value",rowData.nm_skpd);
//			$("#skpd").attr("value",rowData.kd_skpd);
//           
//		}  
//		}); 
	});
	$(function(){  
            $('#ttd').combogrid({  
                panelWidth:600,  
                idField:'nip',  
                textField:'nip',  
                mode:'remote',
                url:'<?php echo base_url(); ?>index.php/tukd/load_ttd_ppkd/BUD',  
                columns:[[  
                    {field:'nip',title:'NIP',width:200},
                    {field:'nama',title:'Nama',width:400}
                ]],  
           onSelect:function(rowIndex,rowData){
               $("#nama").attr("value",rowData.nama);
           } 
            });          
         });
    
		$(function(){  
            $('#ttd2').combogrid({  
                panelWidth:600,  
                idField:'nip',  
                textField:'nip',  
                mode:'remote',
                url:'<?php echo base_url(); ?>index.php/tukd/load_ttd/PA',  
                columns:[[  
                    {field:'nip',title:'NIP',width:200},
                    {field:'nama',title:'Nama',width:400}
                ]],  
           onSelect:function(rowIndex,rowData){
               $("#nama2").attr("value",rowData.nama);
           } 
            });          
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
        
        $('#tgl1').datebox({  
            required:true,
            formatter :function(date){
            	var y = date.getFullYear();
            	var m = date.getMonth()+1;
            	var d = date.getDate();
            	return y+'-'+m+'-'+d;
            }
        });
        
        $('#tgl2').datebox({  
            required:true,
            formatter :function(date){
            	var y = date.getFullYear();
            	var m = date.getMonth()+1;
            	var d = date.getDate();
            	return y+'-'+m+'-'+d;
            }
        });
        
        
		}); 
    function validate1(){
        var bln1 = document.getElementById('bulan1').value;
        
    }
    
    function get_skpd()
        {
        
        	$.ajax({
        		url:'<?php echo base_url(); ?>index.php/rka/config_skpd',
        		type: "POST",
        		dataType:"json",                         
        		success:function(data){
        								$("#sskpd").attr("value",data.kd_skpd);
        								$("#nmskpd").attr("value",data.nm_skpd);
                                       // $("#skpd").attr("value",rowData.kd_skpd);
        								kdskpd = data.kd_skpd;
                                        
        							  }                                     
        	});
             
        }
    
		function opt(val){        
        ctk = val; 
        if (ctk=='1'){
            $("#div_bulan").hide();
            $("#div_periode").show();
        } else if (ctk=='2'){
            $("#div_bulan").show();
            $("#div_periode").hide();
            } else {
            exit();
        }                 
    }  
    
        function cetak(cetk)
        {
			var no_halaman = document.getElementById('no_halaman').value;
			var bln1 = document.getElementById('bulan1').value;
			var spasi  = document.getElementById('spasi').value; 
			var ctglttd = $('#tgl_ttd').datebox('getValue');
			
             if (ctk=='1'){
                 var ctglttd1 = $('#tgl1').datebox('getValue');
                 var ctglttd2 = $('#tgl2').datebox('getValue');
                }else{
                  var ctglttd1 = 'x';
                  var ctglttd2 = 'y';   
                }
            
            
            
            var  ttd = $('#ttd').combogrid('getValue');
		    ttd = ttd.split(" ").join("123456789");
			var url    = "<?php echo site_url(); ?>/tukd/ctk_rekap_penerimaan_ppkd";  
			var bln = bln1;
            
			if(ctglttd==''){
			alert('Pilih Tanggal dulu')
			exit()
			}
			if(ttd==''){
			ttd='1';
			}
            
            
			
			window.open(url+'/'+bln+'/'+cetk+'/'+ttd+'/'+ctglttd+'/'+no_halaman+'/'+spasi+'/'+ctglttd1+'/'+ctglttd2+'/'+ctk+'/REKAP PENERIMAAN', '_blank');
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



<h3>REKAP KAS PENERIMAAN</h3>
 
            
<div id="accordion">
    
    <p align="right">         
        <table border="0" id="sp2d" title="Cetak Buku Kas Pembantu Pengeluaran" style="width:870px;height:600px;" >
		<!--<tr>
			<td colspan="4">
				<table style="width:100%;" border="0">
					<td width="20%">Cetak</td>
					<td >
						<select name="jenis" id="jenis">    
						 <option value="0"> GAJI </option> 
						 <option value="1"> NON GAJI</option>
					</td>
				</table>
			</td>
		</tr>-->
        <tr>
                <td><input type="radio" name="cetak" value="1" onclick="opt(this.value)" />Periode &ensp;
                <input type="radio" name="cetak" value="2" id="status" onclick="opt(this.value)" />Bulan
                </td>
                <td>&ensp;</td>
                <td>&nbsp</td>
            </tr>
        <tr >
			<td colspan="4">
                <div id="div_bulan">
                        <table style="width:100%;" border="0">
                            <td width="20%">Periode</td>
                            <td><?php echo $this->rka_model->combo_bulan('bulan1','onchange="javascript:validate1();"'); ?> 
                            </td> 
                        </table>
                </div>
                <div id="div_periode">
                        <table style="width:100%;" border="0">
                            <td width="20%">Bulan</td>
                           <td><input type="text" id="tgl1" style="width: 100px;" />s/d<input type="text" id="tgl2" style="width: 100px;" /></td>
                        </table>
                </div>
            </td> 
		</tr>
		<tr>
		<td colspan="4">
                <div id="div_bend">
                        <table style="width:100%;" border="0">
							<td width="20%">Kuasa BUD</td>
                            <td><input type="text" id="ttd" style="width: 200px;" /> &nbsp;&nbsp;
							<input type="nama" id="nama" readonly="true" style="width: 200px;border:0" /> 
							
                            </td> 
                        </table>
                </div>
        </td> 
		</tr>
        <tr>
		<td colspan="4">
                <div id="div_bend">
                        <table style="width:100%;" border="0">
							<td width="20%">Tanggal TTD</td>
                            <td><input type="text" id="tgl_ttd" style="width: 100px;" />							
                            </td> 
                        </table>
                </div>
        </td> 
		</tr>
		<tr>
			<td>
				<table style="width:100%;" border="0">
					<td width="20%">No. Halaman</td>
					<td><input type="number" id="no_halaman" style="width: 100px;" value="1"/></td>
                    <td width="20%">Spasi</td>
					<td><input type="number" id="spasi" style="width: 100px;" value="1"/></td>                        
                </table>
			</td>
		</tr>
	
		<tr >
			<td colspan="2" align="center">
			<a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetak(0);">Cetak</a>
			<a class="easyui-linkbutton" iconCls="icon-pdf" plain="true" onclick="javascript:cetak(1);">Cetak Pdf</a>
			</td>
		</tr>
		
        </table>                      
    </p> 
    

</div>
</div>

 	
</body>

</html>