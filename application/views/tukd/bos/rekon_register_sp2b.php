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
                width: 700            
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
    
		
        function cetak_bos(ctk)
        {
			var bulan   =  document.getElementById('bulan1').value;
			var ctglttd = $('#tgl_ttd').datebox('getValue');
			var  ttd = $('#ttd').combogrid('getValue');
		    ttd = ttd.split(" ").join("123456789");
			var url    = "<?php echo site_url(); ?>/tukd_bos/cetak_regsp2b_baru";  
            
			
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
        
        /*
        function cetak_kapitasi(ctk)
        {
			var bulan   =  document.getElementById('bulan1').value;
			var ctglttd = $('#tgl_ttd').datebox('getValue');
			var  ttd = $('#ttd').combogrid('getValue');
		    ttd = ttd.split(" ").join("123456789");
			var url    = "<?php echo site_url(); ?>/tukd_bos/cetak_regsp2b_kapitasi";  
            
			
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
        */

    </script>

    <STYLE TYPE="text/css"> 
		 input.right{ 
         text-align:right; 
         } 
	</STYLE> 

</head>
<body>

<div id="content">



<h3>CETAK REGISTER SP2B DAN SPB</h3>
<div id="accordion">
    
    <p align="right">         
        <table id="sp2d" title="Cetak Buku Besar" style="width:872px;height:300px;" >  
		
        <tr >
			<td width="20%" height="40" ><B>BULAN</B></td>
			<td>
            <select id="bulan1" name="bulan1">
            <option value="3">TRIWULAN I</option><option value="6">TRIWULAN II</option>
            <option value="9">TRIWULAN III</option><option value="12">TRIWULAN IV</option>
            </select>
            </td>
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
		
		
		<tr >
			<td colspan="2" align="center">
			<a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetak_bos(0);">Cetak Reg. SP2B Dana Bos</a>
			<a class="easyui-linkbutton" iconCls="icon-pdf" plain="true" onclick="javascript:cetak_bos(1);">Cetak Reg. SP2B Dana Bos</a>			
			</td>
		</tr>
       <!-- <tr >
			<td colspan="2" align="center">
			<a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetak_kapitasi(0);">Cetak Reg. SP2B Kapitasi</a>
			<a class="easyui-linkbutton" iconCls="icon-pdf" plain="true" onclick="javascript:cetak_kapitasi(1);">Cetak Reg. SP2B Kapitasi</a>			
			</td>
		</tr>	-->	
        </table>                      
    </p> 
    

</div>
</div>

 	
</body>

</html>