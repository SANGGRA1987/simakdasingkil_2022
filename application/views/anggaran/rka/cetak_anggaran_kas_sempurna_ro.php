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
        width: 500px;
        height: 70px;
        padding: 0.4em;
    }  
    </style>
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
       
       
	$('#sskpd').combogrid({  
		panelWidth:630,  
		idField:'kd_skpd',  
		textField:'kd_skpd',  
		mode:'remote',
		url:'<?php echo base_url(); ?>index.php/rka/skpduser',  
		columns:[[  
			{field:'kd_skpd',title:'Kode SKPD',width:100},  
			{field:'nm_skpd',title:'Nama SKPD',width:500}    
		]],
		onSelect:function(rowIndex,rowData){
			kdskpd = rowData.kd_skpd;
			$("#nmskpd").attr("value",rowData.nm_skpd);
			$("#skpd").attr("value",rowData.kd_skpd);
            $(function(){
                $('#ttd1').combogrid({  
                    panelWidth:500,  
                    url: '<?php echo base_url(); ?>/index.php/rka/load_ttd_unit/'+kdskpd,  
                        idField:'nip',  
                        textField:'nip',
                        mode:'remote',  
                        fitColumns:true
                });
            });
            
            $(function(){
                $('#tgiat').combogrid({  
                    panelWidth:500,  
                    url: '<?php echo base_url(); ?>/index.php/rka/load_giat/'+kdskpd,  
                        idField:'kd_kegiatan',  
                        textField:'kd_kegiatan',
                        mode:'remote',  
                        fitColumns:true,
                            columns:[[  
                                {field:'kd_kegiatan',title:'Kegiatan',width:200},  
                                {field:'nm_kegiatan',title:'Nama',width:400}    
                                    ]],
                            onSelect:function(rowIndex,rowData){
                                 $("#tgiat").attr("value",rowData.kd_kegiatan);
                                 $("#nmtgiat").attr("value",rowData.nm_kegiatan);
                            }  
                });
            });
		},
		onChange:function(rowIndex,rowData){
				$("#ttd1").combogrid("setValue",'');
			}			
		}); 
	});

  
	$(function(){  
        $('#ttd1').combogrid({  
            panelWidth:400,  
            idField:'nip',  
            textField:'nip',  
            mode:'remote',
            url:'<?php echo base_url(); ?>index.php/rka/load_ttd_unit',  
            columns:[[  
                {field:'nip',title:'NIP',width:200},  
                {field:'nama',title:'Nama',width:400}    
            ]],
            onSelect:function(rowIndex,rowData){
                $("#ttd1").attr("value",rowData.nip);
                $("#nama").attr("value",rowData.nama);
            }  
        });          
     });
     
     
     $(function(){  
        $('#ttd2').combogrid({  
            panelWidth:400,  
            idField:'nip',  
            textField:'nip',  
            mode:'remote',
            url:'<?php echo base_url(); ?>index.php/rka/load_ttd_bud',  
            columns:[[  
                {field:'nip',title:'NIP',width:200},  
                {field:'nama',title:'Nama',width:400}    
            ]],
            onSelect:function(rowIndex,rowData){
                $("#ttd2").attr("value",rowData.nip);
                $("#nama2").attr("value",rowData.nama);
            }  
        });          
     });

      $(document).ready(function(){                
        kosong()                                             
     });

    
    function kosong(){
        //$cekall = ;

        //if ($('input[name="all"]:checked').val()=='1'){
        if(document.getElementById("all").checked == true){
            $("#sskpd").combogrid("setValue",'');
            $("#ttd1").combogrid("setValue",'');
            $("#nmskpd").attr("value",'');
            $("#sskpd").combogrid('disable');
            //$("#nomor_urut").attr("disabled", true); 
        $(function(){
        $('#ttd1').combogrid({  
            panelWidth:400,  
            idField:'nip',  
            textField:'nip',  
            mode:'remote',
            url:'<?php echo base_url(); ?>index.php/rka/load_ppkd',  
            columns:[[  
                {field:'nip',title:'NIP',width:200},  
                {field:'nama',title:'Nama',width:400}    
            ]],  
            onSelect:function(rowIndex,rowData){
                $("#ttd1").attr("value",rowData.nip);
                $("#nama").attr("value",rowData.nama);
            }
        });
        });          
 
        }else{
            $("#sskpd").combogrid("setValue",'');
            $("#nmskpd").attr("value",'');
            $("#sskpd").combogrid('enable');
            
            $(function(){
            $('#ttd1').combogrid({  
                panelWidth:400,  
                idField:'nip',  
                textField:'nip',  
                mode:'remote',
                url:'<?php echo base_url(); ?>index.php/rka/load_ttd_unit',  
                columns:[[  
                    {field:'nip',title:'NIP',width:200},  
                    {field:'nama',title:'Nama',width:400}    
                ]],  
                onSelect:function(rowIndex,rowData){
                    $("#ttd1").attr("value",rowData.nip);
                    $("#nama").attr("value",rowData.nama);
                }
            });
            });          
            $("#ttd1").combogrid("setValue",'');
        } 
    }

    function cek($cet){
             
            if (document.getElementById("all").checked == true){
                var skpd = '0';
            }else{
                var skpd   = kdskpd;
            } 
            if (skpd==''){
                alert('Pilih SKPD Terlebih Dahulu');
                exit();
                }else{
                   cetak($cet);   
                }
           
    }

    function cek_ro($cet){
             
            if (document.getElementById("all").checked == true){
                var skpd = '0';
            }else{
                var skpd   = kdskpd;
            } 
            if (skpd==''){
                alert('Pilih SKPD Terlebih Dahulu');
                exit();
                }else{
                   cetak_ro($cet);   
                }
           
    }
   
   function cetak($ctk)
        {
            var cetak  =$ctk;
			var cell = document.getElementById('cell').value;
            if (document.getElementById("all").checked == true){
                var skpd = '0';
            }else{
                var skpd   = kdskpd;
            } 
			
			if(cetak==2){
				url="<?php echo site_url(); ?>/rka/preview_anggaran_kas_sempurna_ro/"+skpd+'/'+cetak+'/'+cell+'/Report_Anggaran_Kas_Sempurna'+skpd+'.xls';
			}else{
	           url="<?php echo site_url(); ?>/rka/preview_anggaran_kas_sempurna_ro/"+skpd+'/'+cetak+'/'+cell+'/Report_Anggaran_Kas_Sempurna'+skpd;
			}
            //var  ttd = $('#ttd1').combogrid('getValue');
            //var ttd1 = alltrim(ttd);
			//var url    = "<?php echo site_url(); ?>/rka/angaran_kas";	  
                openWindow( url );
			//window.open(url+'/'+skpd+'/'+cetak+'/Report Anggaran Kas - '+skpd+'/?ttd1='+ttd,'_blank');
        }

           function cetak_ro($ctk)
        {
            var cetak  =$ctk;
            var cell = document.getElementById('cell').value;
            if (document.getElementById("all").checked == true){
                var skpd = '0';
            }else{
                var skpd   = kdskpd;
            } 
            
            if(cetak==2){
                url="<?php echo site_url(); ?>/rka_ro/preview_cetakan_cek_anggaran_ro_detail/"+skpd+'/'+cetak+'/2/Report_Anggaran_Kas_Sempurna'+skpd+'.xls';
            }else{
               url="<?php echo site_url(); ?>/rka_ro/preview_cetakan_cek_anggaran_ro_detail/"+skpd+'/'+cetak+'/2/Report_Anggaran_Kas_Sempurna'+skpd;
            }
            //var  ttd = $('#ttd1').combogrid('getValue');
            //var ttd1 = alltrim(ttd);
            //var url    = "<?php echo site_url(); ?>/rka/angaran_kas";   
                openWindow( url );
            //window.open(url+'/'+skpd+'/'+cetak+'/Report Anggaran Kas - '+skpd+'/?ttd1='+ttd,'_blank');
        }
     
     function runEffect() {
        var selectedEffect = 'blind';            
        var options = {};                      
        $( "#tagih" ).toggle( selectedEffect, options, 500 );
        };
        
      function pilih() {
       op = '1';       
      };   
        
    function openWindow( url ){
           var  ctglttd = $('#tgl_ttd').datebox('getValue');
           var  ttd = $('#ttd1').combogrid('getValue');
           var  ttdx = $('#ttd2').combogrid('getValue');
           var  tgiatx = $('#tgiat').combogrid('getValue');
		   var ttd1 = ttd.split(" ").join("a");
           var ttd2 = ttdx.split(" ").join("a");
             lc = '?tgl_ttd='+ctglttd+'&ttd1='+ttd1+'&ttd2='+ttd2+'&tgiat='+tgiatx+'';
			window.open(url+lc,'_blank');
			window.focus();
		  
     } 

	 function alltrim(kata){
	 //alert(kata);
		b = (kata.split(' ').join(''));
		c = (b.replace( /\s/g, ""));
		return c
	 
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



<h3>CETAK ANGGARAN KAS RO PERGESERAN</h3>
<div id="accordion">
    
    <p align="right">         
        <table id="sp2d" title="Cetak" style="width:865px;height:200px;" >  
        <tr >
			<td width="20%" height="40" ><B>SKPD</B></td>
			<td width="80%"><input id="sskpd" name="sskpd" style="width: 150px;" />&nbsp;&nbsp;&nbsp;<input id="nmskpd" name="nmskpd" style="width: 500px; border:0;" /></td>
		</tr>
        <tr >
			<td width="20%" height="40" ><B>KEGIATAN</B></td>
			<td width="80%"><input id="tgiat" name="tgiat" style="width: 150px;" />&nbsp;&nbsp;&nbsp;<input id="nmtgiat" name="nmtgiat" style="width: 500px; border:0;" /></td>
		</tr>        
        <tr >
			<td width="20%" height="40" ><B>Penandatangan</B></td>
			<td width="80%"><input id="ttd1" name="ttd1" style="width: 200px;" /><input id="nama" name="nama" style="width: 500px; border:0;" /></td>
		</tr>
        <tr >
			<td width="20%" height="40" ><B>Penandatangan 2</B></td>
			<td width="80%"><input id="ttd2" name="ttd2" style="width: 200px;" /><input id="nama2" name="nama2" style="width: 500px; border:0;" /></td>
		</tr>
		<tr>
            <td width="20%">TANGGAL TTD</td>
            <td><input type="text" id="tgl_ttd" style="width: 100px;" /> </td>
        </td> 
		</tr>
        <tr>
            <td width="40%" colspan="2"><input hidden="true" type="checkbox" name="all" id="all" onclick="kosong();"/></td>        
 
			</tr>
		<tr>
            <td width="40%" colspan="2">&ensp;&ensp;Ukuran Baris  : &nbsp;<input type="number" id="cell" name="cell" style="width: 50px; border:1" value="1" /> &nbsp;&nbsp;</td>
		</tr>
		<tr >
			<td colspan="2"><a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cek(0);">Cetak</a>
            <a class="easyui-linkbutton" iconCls="icon-pdf" plain="true" onclick="javascript:cek(1);">Cetak PDF</a>
            <a class="easyui-linkbutton" iconCls="icon-excel" plain="true" onclick="javascript:cek(2);">Cetak excel</a>
            <a class="easyui-linkbutton" iconCls="icon-word" plain="true" onclick="javascript:cek(3);">Cetak word</a></td>
		</tr>


        <tr >
            <td colspan="2"><a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cek_ro(0);">Cek Selisih Data Anggaran Kas RO</a></td>
        </tr>
		
        </table>                      
    </p> 
    

</div>

</div>

 	
</body>

</html>