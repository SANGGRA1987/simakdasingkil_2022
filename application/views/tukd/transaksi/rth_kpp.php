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
            $("#accordion").accordion();            
            $( "#dialog-modal" ).dialog({
                height: 400,
                width: 800            
            });
             //get_skpd();               
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
                url:'<?php echo base_url(); ?>index.php/tukd/load_ttd/BUD',  
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
    
		
        function cetak(ctk)
        {
			//var nip		= nip;
			//var skpd   = kdskpd; 
			var bulan   =  document.getElementById('bulan1').value;
			var ctglttd = $('#tgl_ttd').datebox('getValue');
			var  ttd = $('#ttd').combogrid('getValue');
		    ttd = ttd.split(" ").join("123456789");
			//var  ttd2 = $('#ttd2').combogrid('getValue');
		    //ttd2 = ttd2.split(" ").join("123456789");
			var url    = "<?php echo site_url(); ?>/tukd/cetak_rth";  
			
			if(ctglttd==''){
			alert('Pilih Tanggal tanda tangan dulu')
			exit()
			}
			if(ttd==''){
			alert('Pilih Penanda tangan dulu')
			exit()
			}
			
			window.open(url+'/'+bulan+'/'+ctk+'/'+ttd+'/'+ctglttd, '_blank');
			window.focus();
        }
        
        function cetak_skpd(ctk)
        {
			//var nip		= nip;
			//var skpd   = kdskpd; 
			var bulan   =  document.getElementById('bulan1').value;
			var ctglttd = $('#tgl_ttd').datebox('getValue');
			var  ttd = $('#ttd').combogrid('getValue');
		    ttd = ttd.split(" ").join("123456789");
			//var  ttd2 = $('#ttd2').combogrid('getValue');
		    //ttd2 = ttd2.split(" ").join("123456789");
			var url    = "<?php echo site_url(); ?>/tukd/cetak_rth_skpd_kpp";  
			
			if(ctglttd==''){
			alert('Pilih Tanggal tanda tangan dulu')
			exit()
			}
			if(ttd==''){
			alert('Pilih Penanda tangan dulu')
			exit()
			}
			
			window.open(url+'/'+bulan+'/'+ctk+'/'+ttd+'/'+ctglttd+'/RTH SKPD', '_blank');
			window.focus();
        }
        
        function cetak_djp1(ctk)
        {            
            var skpd ='-';
			var bulan   =  document.getElementById('bulan1').value;			
			var url    = "<?php echo site_url(); ?>/tukd_djp/cetak_csv1";  
			if(bulan==0){
			alert('Pilih Bulan dulu')
			exit()
			}
            
			window.open(url+'/'+bulan+'/CSV 01', '_blank');
			window.focus();
        }
        
        function cetak_djp2(ctk)
        {            
            var skpd ='-';
			var bulan   =  document.getElementById('bulan1').value;			
			var url    = "<?php echo site_url(); ?>/tukd_djp/cetak_csv2";  
			if(bulan==0){
			alert('Pilih Bulan dulu')
			exit()
			}
            
			window.open(url+'/'+bulan+'/CSV 02', '_blank');
			window.focus();
        }    

        function cetak_djp3(ctk)
        {            
            var skpd ='-';
			var bulan   =  document.getElementById('bulan1').value;			
			var url    = "<?php echo site_url(); ?>/tukd_djp/cetak_csv3";  
			if(bulan==0){
			alert('Pilih Bulan dulu')
			exit()
			}
            
			window.open(url+'/'+bulan+'/CSV 03', '_blank');
			window.focus();
        }
        
        function cetak_djp4(ctk)
        {            
            var skpd ='-';
			var bulan   =  document.getElementById('bulan1').value;			
			var url    = "<?php echo site_url(); ?>/tukd_djp/cetak_csv4";  
			if(bulan==0){
			alert('Pilih Bulan dulu')
			exit()
			}
            
			window.open(url+'/'+bulan+'/CSV 04', '_blank');
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



<h3>CETAK DAFTAR TRANSAKSI HARIAN</h3>
<div id="accordion">
    
    <p align="right">         
        <table id="sp2d" title="Cetak Buku Besar" style="width:922px;height:200px;" >  
		
        <tr >
			<td width="20%" height="40" ><B>BULAN</B></td>
			<td><?php echo $this->rka_model->combo_bulan('bulan1','onchange="javascript:validate1();"'); ?> </td onclick="return confirm('hapus data yang telah diinput?')">
		</tr>
		 <tr>
                <td colspan="4">
                <div id="div_tgl">
                        <table style="width:100%;" border="0">
                            <td width="20%">Tanggal TTD</td>
                            <td><input type="text" id="tgl_ttd" style="width: 100px;" /> 
                            </td> 
                        </table>
                </div>
                </td> 
            </tr>
		
		
		<tr>
		<td colspan="4">
                <div id="div_bend">
                        <table style="width:100%;" border="0">
							<td width="20%">Penanda tangan</td>
                            <td><input type="text" id="ttd" style="width: 200px;" /> &nbsp;&nbsp;
							<input type="nama" id="nama" readonly="true" style="width: 200px;border:0" /> 
							
                            </td> 
                        </table>
                </div>
        </td> 
		</tr>
		
		
		<!--<tr >
			<td colspan="2" align="center">
			<a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetak(0);">Cetak (KHUSUS SIKD SINERGI)</a>
			<a class="easyui-linkbutton" iconCls="icon-pdf" plain="true" onclick="javascript:cetak(1);">Cetak Pdf (KHUSUS SIKD SINERGI)</a>
			<a class="easyui-linkbutton" iconCls="icon-excel" plain="true" onclick="javascript:cetak(2);">Cetak excel (KHUSUS SIKD SINERGI)</a>
			</td>
		</tr>-->
		<tr >
			<td colspan="2" align="center">
			<a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetak_skpd(0);">Cetak (KHUSUS REKON SKPD)</a>
			<a class="easyui-linkbutton" iconCls="icon-pdf" plain="true" onclick="javascript:cetak_skpd(1);">Cetak Pdf (KHUSUS REKON SKPD)</a>
			<a class="easyui-linkbutton" iconCls="icon-excel" plain="true" onclick="javascript:cetak_skpd(2);">Cetak excel (KHUSUS REKON SKPD)</a>
			</td>
		</tr>
        <tr >
			<td colspan="2" align="center">*)Keperluan DJP (Data Rekon SKPD)
			<a class="easyui-linkbutton" iconCls="icon-excel" plain="true" onclick="javascript:cetak_djp1(0);">File.01 (Induk SP2D)</a>
			<a class="easyui-linkbutton" iconCls="icon-excel" plain="true" onclick="javascript:cetak_djp2(1);">File.02 (Rincian Belanja SP2D)</a>
            <a class="easyui-linkbutton" iconCls="icon-excel" plain="true" onclick="javascript:cetak_djp3(2);">File.03 (Rincian Pajak SP2D)</a>            
            <a class="easyui-linkbutton" iconCls="icon-excel" plain="true" onclick="javascript:cetak_djp4(3);">File.04 (Pajak & NTPN)</a>
			</td>
		</tr>
        </table>                      
    </p> 
    

</div>
</div>

 	
</body>

</html>