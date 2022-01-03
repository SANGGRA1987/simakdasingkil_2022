

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
					}
               }); 
               });
               
      $(function(){
    $('#tgl7').combogrid({  
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
						bulan7 = rowData.nm_bulan;						
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
    
   
     
     function cetak( urlg ){
      
        ctglttd = $('#tgl_ttd').datebox('getValue');
        ctgl1 = $('#tgl1').combogrid('getValue');
        ctgl7 = $('#tgl7').combogrid('getValue');
        cttd = $('#ttd').combogrid('getValue');
         cttd = cttd.split(" ").join("a"); 
            lc = '?tgl1='+ctgl1+'&tgl_ttd='+ctglttd+'&ttd='+cttd+'&ttd7='+ctgl7;
         
         var url    = "<?php echo site_url(); ?>/tukd/cetak_kas_harian_rincibln_ppkd/"+urlg+"/"; 
         window.open(url+lc,'_blank');
         window.focus();
         
     }  
     
     function cetak_rinci( urlg ){
      
        ctglttd = $('#tgl_ttd').datebox('getValue');
        ctgl1 = $('#tgl1').combogrid('getValue');
        ctgl7 = $('#tgl7').combogrid('getValue');
        cttdx = $('#ttd').combogrid('getValue');
        cttd = cttdx.split(" ").join("a");
          
            lc = '?tgl1='+ctgl1+'&tgl_ttd='+ctglttd+'&ttd='+cttd+'&ttd7='+ctgl7;
         
         var url    = "<?php echo site_url(); ?>/tukd/cetak_kas_harian_arusrinci_bln/"+urlg+"/"; 
         window.open(url+lc,'_blank');
         window.focus();
         
     }  
     
    function cetak_cp( urlg ){
      
        ctglttd = $('#tgl_ttd').datebox('getValue');
        ctgl1 = $('#tgl1').combogrid('getValue');
        ctgl7 = $('#tgl7').combogrid('getValue');
        cttd = $('#ttd').combogrid('getValue');
         cttd = cttd.split(" ").join("a"); 
            lc = '?tgl1='+ctgl1+'&tgl_ttd='+ctglttd+'&ttd='+cttd+'&ttd7='+ctgl7;
         
         var url    = "<?php echo site_url(); ?>/tukd/cetak_kas_harian_rincibln_cp/"+urlg+"/"; 
         window.open(url+lc,'_blank');
         window.focus();
         
     } 
    
    
  
   </script>


<div id="content1" align="center"> 
    <h3 align="center"><b>BKU PPKD</b></h3>
    
     <table align="center" style="width:100%;" border="0">
            
           
            <tr>
                <td colspan="3">
                
                <div id="div_periode">
                        <table style="width:100%;" border="0">
                            <td width="20%">PERIODE</td>
                            <td width="1%">:</td>
                            <td width="79%"><input type="text" id="tgl1" style="width: 100px;" /> &nbsp;s/d&nbsp; <input type="text" id="tgl7" style="width: 100px;" />
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
                <td colspan="3" align="left">
                <a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetak(0);">Cetak Buku Kas Umum(Layar)</a>
                 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a class="easyui-linkbutton" iconCls="icon-pdf" plain="true" onclick="javascript:cetak(1);">Cetak  Buku Kas Umum(PDF)</a>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a class="easyui-linkbutton" iconCls="icon-excel" plain="true" onclick="javascript:cetak(2);">Cetak  Buku Kas Umum(Excel)</a>
                
                </td>                
            </tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
              <!--<tr>
                <td colspan="3" align="left">
                <a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetak_rinci(0);">Cetak Rincian Arus Kas(Layar)</a>
                 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a class="easyui-linkbutton" iconCls="icon-pdf" plain="true" onclick="javascript:cetak_rinci(1);">Cetak Rincian Arus Kas(PDF)</a>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a class="easyui-linkbutton" iconCls="icon-excel" plain="true" onclick="javascript:cetak_rinci(2);">Cetak Rincian Arus Kas(Excel)</a>
                
                </td>                
            </tr>
            <tr>
                <td colspan="3" align="left">
                <a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetak_cp(0);">Cetak CP(Layar)</a>
                 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a class="easyui-linkbutton" iconCls="icon-pdf" plain="true" onclick="javascript:cetak_cp(1);">Cetak CP(PDF)</a>
                 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a class="easyui-linkbutton" iconCls="icon-excel" plain="true" onclick="javascript:cetak_cp(2);">Cetak CP(Excel)</a>
                
                </td>                
            </tr>
            <!--<tr>
                <td colspan="3" align="left">
                <a href="<?php echo site_url(); ?>/tukd/cetak_kas_harian_rinci/0/" class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:openWindow(this.href);return false">Cetak Rincian (Layar)</a>
                 &nbsp;
                <a href="<?php echo site_url(); ?>/tukd/cetak_kas_harian_rinci/1/" class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:openWindow(this.href);return false">Cetak Rincian (PDF)</a>
                &nbsp;
                <a href="<?php echo site_url(); ?>/tukd/cetak_kas_harian_rinci/2/" class="easyui-linkbutton" iconCls="icon-excel" plain="true" onclick="javascript:openWindow(this.href);return false">Cetak Rincian (Excel)</a>
                
                </td>                
            </tr>-->
        </table>  
            
  
</div>	
