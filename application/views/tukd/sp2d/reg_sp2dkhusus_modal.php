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
	var xjenis='';
    
     $(document).ready(function() {
            $("#accordion").accordion();            
            $( "#dialog-modal" ).dialog({
                height: 400,
                width: 800            
            });             
			$("#perskpd").hide();						
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
			
			$('#tgl_ttd').datebox({  
				required:true,
				formatter :function(date){
					var y = date.getFullYear();
					var m = date.getMonth()+1;
					var d = date.getDate();
					return y+'-'+m+'-'+d;
				}
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
            
            $('#tgl_per1').datebox({  
				required:true,
				formatter :function(date){
					var y = date.getFullYear();
					var m = date.getMonth()+1;
					var d = date.getDate();
					return y+'-'+m+'-'+d;
				}
			});

			$('#tgl_per2').datebox({  
				required:true,
				formatter :function(date){
					var y = date.getFullYear();
					var m = date.getMonth()+1;
					var d = date.getDate();
					return y+'-'+m+'-'+d;
				}
			});
			
			$('#skpd').combogrid({  
				panelWidth:630,  
				idField:'kd_skpd',  
				textField:'kd_skpd',  
				mode:'remote',
				url:'<?php echo base_url(); ?>index.php/tukd/kode_organisasi',  
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
		
	function opt(val){                 
        xjenis = val;
        if (val=='0'){
			$("#perskpd").hide();			
            $('#skpd').combogrid('setValue','');
            document.getElementById('nmskpd').value=''; 
        }else if (val=='1'){
			$("#perskpd").show();			
        } else{
			exit();
		}                 
    }    
 	
        function cetak(tipectak)
        {
			var cetk       = xjenis;
			var no_halaman = document.getElementById('no_halaman').value;			
			var spasi      = document.getElementById('spasi').value; 			
			var ctglttd    = $('#tgl_ttd').datebox('getValue');
			var ttd        = $('#ttd').combogrid('getValue');
		        ttd        = ttd.split(" ").join("123456789");
			var url        = "<?php echo site_url(); ?>/tukd/ctk_rekap_sp2dmodal";	
            var tgl_per1   = $('#tgl_per1').datebox('getValue');
			var tgl_per2   = $('#tgl_per2').datebox('getValue');
            var sp2d_pay   = document.getElementById('sp2d_pay').value;
            
            if(skpdd==''){
				alert('Pilih SKPD dulu')
				exit()
			}
            
            if(cetk=='1'){
              var skpdd = $('#skpd').combogrid('getValue');  
            }else{
              var skpdd ='non';  
            }
            
            if(ctglttd==''){
				alert('Pilih Tanggal dulu')
				exit()
			}
                        
			 	window.open(url+'/'+tipectak+'/'+ttd+'/'+ctglttd+'/'+cetk+'/'+no_halaman+'/'+spasi+'/'+skpdd+'/'+tgl_per1+'/'+tgl_per2+'/'+sp2d_pay, '_blank');
				window.focus();
        }
         
         	
        function cetak2(tipectak)
        {
			var cetk       = xjenis;
			var no_halaman = document.getElementById('no_halaman').value;			
			var spasi      = document.getElementById('spasi').value; 			
			var ctglttd    = $('#tgl_ttd').datebox('getValue');
			var ttd        = $('#ttd').combogrid('getValue');
		        ttd        = ttd.split(" ").join("123456789");
			var url        = "<?php echo site_url(); ?>/tukd/ctk_rekap_sp2dmodalrinci";	
            var tgl_per1   = $('#tgl_per1').datebox('getValue');
			var tgl_per2   = $('#tgl_per2').datebox('getValue');
            var sp2d_pay   = document.getElementById('sp2d_pay').value;
            
            if(skpdd==''){
				alert('Pilih SKPD dulu')
				exit()
			}
            
            if(cetk=='1'){
              var skpdd = $('#skpd').combogrid('getValue');  
            }else{
              var skpdd ='non';  
            }
            
            if(ctglttd==''){
				alert('Pilih Tanggal dulu')
				exit()
			}
                        
			 	window.open(url+'/'+tipectak+'/'+ttd+'/'+ctglttd+'/'+cetk+'/'+no_halaman+'/'+spasi+'/'+skpdd+'/'+tgl_per1+'/'+tgl_per2+'/'+sp2d_pay, '_blank');
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

<h3>REKAP REGISTER SP2D (BELANJA MODAL)</h3>
<div id="accordion">
    
    <p align="right">         
        <table border="0" id="sp2d" title="REG. SP2D (BELANJA MODAL)" style="width:920px;height:200px;" >
		<tr>
			<td colspan="0">
				<table style="width:100%;" border="0">
					<tr>
                    <td><input type="radio" name="cetak" value="0" id="status" onclick="opt(this.value)" /><b>Keseluruhan</b></td>    
                    </tr>
                    <tr>
					<td><input type="radio" name="cetak" value="1" id="status" onclick="opt(this.value)" /><b>Per SKPD</b>
						<div id="perskpd">
                        <table>
                            <tr >
                    			<td ><B>SKPD</B></td>
                    			<td ><input id="skpd" name="skpd" style="width: 100px;" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="nmskpd" name="nmskpd" style="width: 300px; border:0;" /></td>
                    		</tr>
                        </table> 
						</div>
					</td>
					</tr>
															
				</table>
			</td>
		</tr>	        
        <tr >
			<td colspan="4">
                <div id="div_tgl">
                        <table style="width:100%;" border="0">
                            <td width="20%">Periode</td>
                            <td><input type="text" id="tgl_per1" style="width: 100px;" /> s/d <input type="text" id="tgl_per2" style="width: 100px;" /></td>
                        </table>
                </div>
            </td> 
		</tr>	
        <tr >
			<td colspan="4">
                <div id="div_tgl">
                        <table style="width:100%;" border="0">
                            <td width="20%">Jenis</td>
                            <td><select id="sp2d_pay"><option value="1">SP2D Terbit</option><option value="2">SP2D Lunas/Cair</option></select></td>
                        </table>
                </div>
            </td> 
		</tr>	
        <tr >
			<td colspan="4">
                <div id="div_tgl">
                        <table style="width:100%;" border="0">
                            <td width="20%">Tanggal Cetak</td>
                            <td><input type="text" id="tgl_ttd" style="width: 100px;" /></td>
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
			<td>
				<table style="width:100%;" border="0">
					<td width="20%">No. Halaman</td>
					<td><input type="number" id="no_halaman" style="width: 100px;" value="1"/></td>                       
                </table>
			</td>
		</tr>
		<tr>
			<td>
				<table style="width:100%;" border="0">
					<td width="20%">Spasi</td>
					<td><input type="number" id="spasi" style="width: 100px;" value="1"/></td>                       
                </table>
			</td>
		</tr>
		<tr >
			<td colspan="2" align="center">
			<a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetak(0);">Cetak Rekap</a>
			<a class="easyui-linkbutton" iconCls="icon-pdf" plain="true" onclick="javascript:cetak(1);">Cetak Rekap (Pdf)</a>
            <a class="easyui-linkbutton" iconCls="icon-excel" plain="true" onclick="javascript:cetak(2);">Cetak Rekap (Excel)</a>			
            </td>
		</tr>
		<tr >
			<td colspan="2" align="center">
			<a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetak2(0);">Cetak Rincian</a>
			<a class="easyui-linkbutton" iconCls="icon-pdf" plain="true" onclick="javascript:cetak2(1);">Cetak Rincian (Pdf)</a>
            <a class="easyui-linkbutton" iconCls="icon-excel" plain="true" onclick="javascript:cetak2(2);">Cetak Rincian (Excel)</a>			
            </td>
		</tr>
        </table>                      
    </p> 
    

</div>
</div>
</body>
</html>