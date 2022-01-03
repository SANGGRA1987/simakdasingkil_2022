

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>easyui/themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>easyui/themes/icon.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>easyui/demo/demo.css">
	<script type="text/javascript" src="<?php echo base_url(); ?>easyui/jquery-1.8.0.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>easyui/jquery.easyui.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>easyui/jquery.edatagrid.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/autoCurrency.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/numberFormat.js"></script>
    
    
    <link href="<?php echo base_url(); ?>easyui/jquery-ui.css" rel="stylesheet" type="text/css"/>
    <script src="<?php echo base_url(); ?>easyui/jquery-ui.min.js"></script>
    <script type="text/javascript">
   
     $(function(){ 
        
        	$('#tgl1').combogrid({  
                   panelWidth:120,
                   panelHeight:300,  
                   idField:'bln',  
                   textField:'nm_bulan',  
                   mode:'remote',
                   url:'<?php echo base_url(); ?>index.php/rka/bulan',  
                   columns:[[ 
                       {field:'nm_bulan',title:'Nama Bulan',width:700}    
                   ]],
					onSelect:function(rowIndex,rowData){
						bulan = rowData.nm_bulan;
						$("#tgl1").attr("value",rowData.nm_bulan);
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
      
    });        

     $(function(){
    	$('#ttd').combogrid({  
    		panelWidth:500,  
    		url: '<?php echo base_url(); ?>/index.php/tukd/load_ttd_bud',  
    			idField:'nip',                    
    			textField:'nama',
    			mode:'remote',  
    			fitColumns:true,  
    			columns:[[  
    				{field:'nip',title:'NIP',width:60},  
    				{field:'nama',title:'NAMA',align:'left',width:100}								
    			]],
    			onSelect:function(rowIndex,rowData){
    			nip = rowData.nip;
    			
    			}   
    		});
       });
    
        
     function openWindow( url ){
      
        ctglttd = $('#tgl_ttd').datebox('getValue');
         cttd = $('#ttd').combogrid('getValue');
         cttd = cttd.split(" ").join("a");
            ctgl1 = $('#tgl1').combogrid('getValue');
          
            lc = '?tgl1='+ctgl1+'&tgl_ttd='+ctglttd+'&ttd='+cttd;
        
         window.open(url+lc,'_blank');
         window.focus();        
     }  
     
  
   </script>
<div id="content1" align="center"> 
    <h3 align="center"><b>Laporan Realisasi Pengeluaran</b></h3>
    
     <table align="center" style="width:100%;" border="0">
            
           
            <tr>
                <td colspan="3">
                
                <div id="div_periode">
                        <table style="width:100%;" border="0">
                            <td width="20%">PERIODE</td>
                            <td width="1%">:</td>
                            <td width="79%"><input type="text" id="tgl1" style="width: 100px;" /> 
                            </td>
                        </table>
                </div>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                <div id="div_bend">
                        <table style="width:100%;" border="0">
                            <td width="20%">TANGGAL TTD</td>
                            <td width="1%">:</td>
                            <td><input type="text" id="tgl_ttd" style="width: 100px;" /> 
                            </td> 
                        </table>
                </div>
                </td> 
            </tr>
            <tr>
                <td colspan="3">
                <div id="div_bend">
                        <table style="width:100%;" border="0">
                            <td width="20%">TTD</td>
                            <td width="1%">:</td>
                            <td><input type="text" id="ttd" style="width: 100px;" /> 
                            </td> 
                        </table>
                </div>
                </td> 
            </tr>
            <td colspan="3">&nbsp;</td>
            </tr>            
            <tr>
                <td colspan="3" align="center">
                <a href="<?php echo site_url(); ?>/tukd/cetak_real_pengeluaran_jns/0/" class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:openWindow(this.href);return false">Cetak Layar</a>
                 &nbsp;
                <a href="<?php echo site_url(); ?>/tukd/cetak_real_pengeluaran_jns/1/" class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:openWindow(this.href);return false">Cetak PDF</a>
                 &nbsp;   
                <a href="<?php echo site_url(); ?>/tukd/cetak_real_pengeluaran_jns/2/" class="easyui-linkbutton" iconCls="icon-excel" plain="true" onclick="javascript:openWindow(this.href);return false">Cetak Excel</a>
                 &nbsp;                
                </td>                
            </tr>
        </table>  
            
  
</div>	
