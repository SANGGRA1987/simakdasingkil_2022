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
    var cetakk='';
    
     $(document).ready(function() {
            $("#accordion").accordion();            
            $( "#dialog-modal" ).dialog({
                height: 400,
                width: 800            
            });
             //get_skpd()         
             $("#perskpd").hide();      
        });   
    
	$(function(){
	$('#sskpd').combogrid({  
		panelWidth:630,  
		idField:'kd_skpd',  
		textField:'kd_skpd',  
		mode:'remote',
		url:'<?php echo base_url(); ?>index.php/rka/skpdbp',  
		columns:[[  
			{field:'kd_skpd',title:'Kode SKPD',width:100},  
			{field:'nm_skpd',title:'Nama SKPD',width:500}    
		]],
		onSelect:function(rowIndex,rowData){
			kdskpd = rowData.kd_skpd;
			$("#nmskpd").attr("value",rowData.nm_skpd);
			 
		}  
		}); 
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
        		url:'<?php echo base_url(); ?>index.php/rka/skpdbp',
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
			var nip		= nip;
            if(cetakk=='1'){
                var skpd   = kdskpd; 			    
            }else{
                var skpd   = '-'; 			
            }
            
			var bulan   =  document.getElementById('bulan1').value;
			var ctglttd = $('#tgl_ttd').datebox('getValue');
			var  ttd = $('#ttd').combogrid('getValue');
		    ttd = ttd.split(" ").join("123456789");			
            var atas   =  document.getElementById('atas').value;
			var bawah   =  document.getElementById('bawah').value;
			var kanan   =  document.getElementById('kanan').value;
			var kiri   =  document.getElementById('kiri').value;
 	

			var url    = "<?php echo site_url(); ?>/tukd/cetak_dak_global";  
			if(bulan==0){
			alert('Pilih Bulan dulu')
			exit()
			}
			if(ctglttd==''){
			alert('Pilih Tanggal tanda tangan dulu')
			exit()
			}
			if(ttd==''){
			alert('Pilih Bendahara Pengeluaran dulu')
			exit()
			}
			//+$cetak+"/"+atas+"/"+bawah+"/"+kiri+"/"+kanan;
			window.open(url+'/'+skpd+'/'+bulan+'/'+ctk+'/'+ttd+'/'+ctglttd+'/'+atas+'/'+bawah+'/'+kiri+'/'+kanan+'/DAK FISIK', '_blank');
			window.focus();
        }
        
    function cetak_skpd(ctk)
        {
			var nip		= nip;
            if(cetakk=='1'){
                var skpd   = kdskpd; 			    
            }else{
                var skpd   = '-'; 			
            }
            
			var bulan   =  document.getElementById('bulan1').value;
			var ctglttd = $('#tgl_ttd').datebox('getValue');
			var  ttd = $('#ttd').combogrid('getValue');
		    ttd = ttd.split(" ").join("123456789");			
            var atas   =  document.getElementById('atas').value;
			var bawah   =  document.getElementById('bawah').value;
			var kanan   =  document.getElementById('kanan').value;
			var kiri   =  document.getElementById('kiri').value;
 	

			var url    = "<?php echo site_url(); ?>/tukd/cetak_dak_global_non";  
			if(bulan==0){
			alert('Pilih Bulan dulu')
			exit()
			}
			if(ctglttd==''){
			alert('Pilih Tanggal tanda tangan dulu')
			exit()
			}
			if(ttd==''){
			alert('Pilih Bendahara Pengeluaran dulu')
			exit()
			}
			//+$cetak+"/"+atas+"/"+bawah+"/"+kiri+"/"+kanan;
			window.open(url+'/'+skpd+'/'+bulan+'/'+ctk+'/'+ttd+'/'+ctglttd+'/'+atas+'/'+bawah+'/'+kiri+'/'+kanan+'/DAK NON FISIK', '_blank');
			window.focus();
        }
        
    function opt(val){        
        cetakk = val; 
        if (cetakk=='0'){
			$("#perskpd").hide();			
        }else{
            $("#perskpd").show();
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



<h3>CETAK DAFTAR REALISASI DAK SKPD</h3>
<div id="accordion">
    
    <p align="right">         
    
        <table id="sp2d" title="Cetak Buku Besar" style="width:922px;height:200px;" >  		        
        <tr>
            <td width="100%" colspan="2">
               <table style="width:100%;" border="0">
					<tr>
					<td><input type="radio" name="cetak" value="0" onclick="opt(this.value)" /><b>Semua SKPD</b></td>
					</tr>
					<!--<tr>
					<td><input type="radio" name="cetak" value="1" id="status" onclick="opt(this.value)" /><b>Per SKPD</b>
						<div id="perskpd">
                        <table>
                            <tr >
                    			<td ><B>SKPD</B></td>
                    			<td ><input id="sskpd" name="sskpd" style="width: 100px;" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="nmskpd" name="nmskpd" style="width: 400px; border:0;" /></td>
                    		</tr>
                        </table> 
						</div>
					</td>
					</tr>-->
            </table>            
            </td>            
        </tr>       
        <tr >
			<td width="20%" height="40" ><B>BULAN</B></td>
			<td>
            <?php echo $this->rka_model->combo_bulan('bulan1','onchange="javascript:validate1();"'); ?>                      
            </td onclick="return confirm('hapus data yang telah diinput?')">
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
							<td width="20%">Penanda Tanggan</td>
                            <td><input type="text" id="ttd" style="width: 200px;" /> &nbsp;&nbsp;
							<input type="nama" id="nama" readonly="true" style="width: 200px;border:0" /> 
							
                            </td> 
                        </table>
                </div>
        </td> 
		</tr>
		
		<!--<tr>
		<td colspan="4">
                <div id="div_bend2">
                        <table style="width:100%;" border="0">
							<td width="20%">Pengguna Anggaran</td>
                            <td><input type="text" id="ttd2" style="width: 200px;" /> &nbsp;&nbsp;
							<input type="nama2" id="nama2" readonly="true" style="width: 200px;border:0" /> 
							
                            </td> 
                        </table>
                </div>
        </td> 
		</tr>-->

     		<tr >
    			<td colspan='2'width="100%" height="40" ><strong>Ukuran Margin Untuk Cetakan PDF (Milimeter)</strong></td>
    		</tr>
    		<tr >
    			<td colspan='2'> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    			Kiri  : &nbsp;<input type="number" id="kiri" name="kiri" style="width: 50px; border:1" value="15" /> &nbsp;&nbsp;
    			Kanan : &nbsp;<input type="number" id="kanan" name="kanan" style="width: 50px; border:1" value="15" /> &nbsp;&nbsp;
    			Atas  : &nbsp;<input type="number" id="atas" name="atas" style="width: 50px; border:1" value="15" /> &nbsp;&nbsp;
    			Bawah : &nbsp;<input type="number" id="bawah" name="bawah" style="width: 50px; border:1" value="15" /> &nbsp;&nbsp;
    			</td>
    		</tr>
		


		<tr >
			<td colspan="2" align="center">
			<a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetak(0);">Cetak (DAK FISIK)</a>
			<a class="easyui-linkbutton" iconCls="icon-pdf" plain="true" onclick="javascript:cetak(1);">Cetak Pdf (DAK FISIK)</a>
            <a class="easyui-linkbutton" iconCls="icon-excel" plain="true" onclick="javascript:cetak(2);">Cetak Excel (DAK FISIK)</a>
			</td>
		</tr>
        <tr >
			<td colspan="2" align="center">
			<a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetak_skpd(0);">Cetak (DAK NON FISIK)</a>
			<a class="easyui-linkbutton" iconCls="icon-pdf" plain="true" onclick="javascript:cetak_skpd(1);">Cetak Pdf (DAK NON FISIK)</a>
            <a class="easyui-linkbutton" iconCls="icon-excel" plain="true" onclick="javascript:cetak_skpd(2);">Cetak Excel (DAK NON FISIK)</a>
			</td>
		</tr>
		
        </table>                      
    </p> 
    

</div>
</div>

 	
</body>

</html>