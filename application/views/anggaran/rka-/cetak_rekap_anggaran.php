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
	var jns_bp='BPBOS';
    
     $(document).ready(function() {
            $("#accordion").accordion();            
            $( "#dialog-modal" ).dialog({
                height: 400,
                width: 800            
            });
             get_skpd();               
        });   
    
   $(function(){
	$('#skpd').combogrid({  
		panelWidth:450,  
		idField:'kd_skpd',  
		textField:'kd_skpd',  
		mode:'remote',
		url:'<?php echo base_url(); ?>index.php/tukd_bosda/skpd_bos',  
		columns:[[  
			{field:'kd_skpd',title:'Kode Satuan Pendidikan',width:150},  
			{field:'nm_skpd',title:'Nama Satuan Pendidikan',width:300}    
		]],
		onSelect:function(rowIndex,rowData){
			kdskpd = rowData.kd_skpd;			
			$("#nmskpd").attr("value",rowData.nm_skpd);
			$("#skpd").attr("value",rowData.kd_skpd);
		    load_ttd1(kdskpd);
		   
		}  
		}); 
	
	$('#bulan').combogrid({  
           panelWidth:120,
           panelHeight:300,  
           idField:'bln',  
           textField:'nm_bulan',  
           mode:'remote',
           url:'<?php echo base_url(); ?>index.php/rka/bulan',  
           columns:[[ 
               {field:'nm_bulan',title:'Nama Bulan',width:700}    
           ]] 
       });
		
	});

function load_ttd1(kdskpd){
	      var  kdskpd = kdskpd;
		  	
	$(function(){  
            $('#ttd3').combogrid({  
                panelWidth:600,  
                idField:'nip',  
                textField:'nip',  
                mode:'remote',
                url:'<?php echo base_url(); ?>index.php/tukd_bosda/load_ttd_bpp_ak/KSBOS/'+kdskpd,  
                columns:[[  
                    {field:'nip',title:'NIP',width:150},
                    {field:'nama',title:'Nama',width:400}
                ]],  
           onSelect:function(rowIndex,rowData){
               $("#nama3").attr("value",rowData.nama);
           } 
            });          
         });

    $(function(){  
            $('#ttd').combogrid({  
                panelWidth:600,  
                idField:'nip',  
                textField:'nip',  
                mode:'remote',
                url:'<?php echo base_url(); ?>index.php/tukd_bosda/load_ttd_bpp_ak/PABOS/'+kdskpd,  
                columns:[[  
                    {field:'nip',title:'NIP',width:150},
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
                url:'<?php echo base_url(); ?>index.php/tukd_bosda/load_ttd_bpp_ak/BPBOS/'+kdskpd,  
                columns:[[  
                    {field:'nip',title:'NIP',width:150},
                    {field:'nama',title:'Nama',width:400}
                ]],  
           onSelect:function(rowIndex,rowData){
               $("#nama2").attr("value",rowData.nama);
           } 
            });          
         });
		}
		
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
    
        
        
        function cetak_kegiatan(ctk)
        {
            var atas   =  document.getElementById('atas').value;
			var bawah   =  document.getElementById('bawah').value;
			var kanan   =  document.getElementById('kanan').value;
			var kiri   =  document.getElementById('kiri').value;		

			var url    = "<?php echo site_url(); ?>/rka/cetak_rekp_angg_pembanding";  
		
            var xx ='REKAP ANGGARAN';
			window.open(url+'/'+ctk+'/'+atas+'/'+bawah+'/'+kiri+'/'+kanan+'/'+jns_bp+'/'+xx, '_blank');
			window.focus();
        }

        function cetak_rekap(ctk)
        {
            var jns_ang = document.getElementById('jns_anggaran').value;
            var atas   =  document.getElementById('atas').value;
            var bawah   =  document.getElementById('bawah').value;
            var kanan   =  document.getElementById('kanan').value;
            var kiri   =  document.getElementById('kiri').value;        

            var url    = "<?php echo site_url(); ?>/rka/cetak_rekp_angg";  
        
            var xx ='REKAP ANGGARAN';
            window.open(url+'/'+ctk+'/'+atas+'/'+bawah+'/'+kiri+'/'+kanan+'/'+jns_ang+'/'+xx, '_blank');
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

<h3>CETAK REKAP ANGGARAN BELANJA</h3>
<div id="accordion">
    
    <p align="center">			           
     	<table>
          <tr>
    			<td align="center" width="100%" height="40" ><strong>Ukuran Margin Untuk Cetakan PDF (Milimeter)</strong></td>
    		</tr>
    		<tr >
    			<td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    			Kiri  : &nbsp;<input type="number" id="kiri" name="kiri" style="width: 50px; border:1" value="15" /> &nbsp;&nbsp;
    			Kanan : &nbsp;<input type="number" id="kanan" name="kanan" style="width: 50px; border:1" value="15" /> &nbsp;&nbsp;
    			Atas  : &nbsp;<input type="number" id="atas" name="atas" style="width: 50px; border:1" value="15" /> &nbsp;&nbsp;
    			Bawah : &nbsp;<input type="number" id="bawah" name="bawah" style="width: 50px; border:1" value="15" /> &nbsp;&nbsp;
    			</td>
    	</tr>
        <tr>
            <td align="center">&nbsp;</td>
        </tr>
        <tr>
            <td align="center">&nbsp;</td>
        </tr>
        <tr>
            <td align="center">Jenis Anggaran:
            <a><select name="jns_anggaran" id="jns_anggaran" onchange="javascript:validate_jenis();" style="height: 27px; width:190px;">     
     <option value="1">Murni</option>
     <option value="2">Pergeseran</option>
     <option value="3">Perubahan</option>
     </select></a></td>
        </tr>
		<tr>
            <td align="center">Cetak Rekap:
            <a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetak_rekap(0);">Cetak</a>
            <a class="easyui-linkbutton" iconCls="icon-pdf" plain="true" onclick="javascript:cetak_rekap(1);">Cetak Pdf</a>
            </td>
        </tr>
        <tr>
			<td align="center">Cetak Rekap Perbandingan:
			<a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetak_kegiatan(0);">Cetak</a>
			<a class="easyui-linkbutton" iconCls="icon-pdf" plain="true" onclick="javascript:cetak_kegiatan(1);">Cetak Pdf</a>
			</td>
		</tr>
        </table>
                          
    </p> 
    

</div>
</div>

 	
</body>

</html>