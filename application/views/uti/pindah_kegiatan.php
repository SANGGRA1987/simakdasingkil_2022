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
    
    var kode = '';
    var kods = '';
    var giat = '';
    var nomor= '';
    var judul= '';
    var cid = 0;
    var lcidx = 0;
    var lcstatus = '';
    var ctk = '';        
   
        $(function(){
        
        $('#cunit').combogrid({  
            panelWidth:700,  
            idField:'kd_skpd',  
            textField:'kd_skpd',  
            mode:'remote',
            url:'<?php echo base_url(); ?>index.php/uti/skpduser_sipp',  
            columns:[[  
                {field:'kd_skpd',title:'Kode SKPD',width:100},  
                {field:'nm_skpd',title:'Nama SKPD',width:700}    
            ]],
            onSelect:function(rowIndex,rowData){
                $("#nmskpd").attr("value",rowData.nm_skpd);  
                kods = rowData.kd_skpd;
                validate_ttd(kods);
				$("#kd_baru").combogrid("setValue",'');
				$("#kd_baru").combogrid("setValue",'');                
            }});
			
			
			$(function(){
        $('#kd_baru').combogrid({  
        panelWidth:630,  
        idField:'kd_baru',  
        textField:'kd_baru',  
        mode:'remote',
        url:'<?php echo base_url(); ?>/index.php/uti/kegiatan_fix/-',  
         columns:[[  
                    {field:'kd_baru',title:'Kode',width:200},  
                    {field:'nm_baru',title:'Nama',width:400}    
                ]],
                onSelect:function(rowIndex,rowData){
            $("#nm_baru").attr("value",rowData.nm_baru);		
			
			
        }  
        }); 
        
                       });
      
        }); 
        

		function validate_ttd(kods){
           $(function(){
        $('#kd_lama').combogrid({  
        panelWidth:630,  
        idField:'kd_lama',  
        textField:'kd_lama',  
        mode:'remote',
        url:'<?php echo base_url(); ?>/index.php/uti/kegiatan_sipp/'+kods,  
         columns:[[  
                    {field:'kd_lama',title:'Kode',width:200},  
                    {field:'nm_lama',title:'Nama',width:400}    
                ]],
                onSelect:function(rowIndex,rowData){
            $("#nm_lama").attr("value",rowData.nm_lama);
			$("#kd_baru").combogrid("setValue",rowData.nm_lama);
			muncul_master(kods);
			
        }  
        }); 
        
                       });
        }

		function muncul_master(kods){
			
			$(function(){
        $('#kd_baru').combogrid({  
        panelWidth:630,  
        idField:'kd_baru',  
        textField:'kd_baru',  
        mode:'remote',
        url:'<?php echo base_url(); ?>/index.php/uti/kegiatan_fix/'+kods,  
         columns:[[  
                    {field:'kd_baru',title:'Kode',width:200},  
                    {field:'nm_baru',title:'Nama',width:400}    
                ]],
                onSelect:function(rowIndex,rowData){
            $("#nm_baru").attr("value",rowData.nm_baru);		
			
			
        }  
        }); 
        
                       });
        }
		
		
		
		       function simpandata(){
				   
                         
    var kode_baru =  $('#kd_baru').combogrid('getValue');
	var kode_lama =  $('#kd_lama').combogrid('getValue');	
    
	
	$(function(){      
		 $.ajax({
			type: 'POST',			
			dataType:"json",
			url:"<?php echo base_url(); ?>index.php/uti/request_simpan_pemindahan/"+kode_baru+"/"+kode_lama,            
			success:function(data){			 
			 status = data;             
                        if (status=='1'){
                            hsl = 'Berhasil';                                                       
                        } else {
                            hsl = 'Gagal';
                        } 
                    
                    alert(hsl);                
            }
		 });
		});    
    
    }
		
		
  
     function alltrim(kata){
     //alert(kata);
        b = (kata.split(' ').join(''));
        c = (b.replace( /\s/g, ""));
        return c
     
     }
             function runEffect() {        
            $('#chkpa')._propAttr('checked',false);     
        };  
        
        function runEffect2() {        
            $('#chkppkd')._propAttr('checked',false);
        };
        
   </script>

    <div id="content">        
        <h1><?php echo $page_title; ?>&nbsp;&nbsp;&nbsp;&nbsp; 
       </h1>
        
        <?php echo form_close(); ?>   
        
        <?php if (  $this->session->flashdata('notify') <> "" ) : ?>
        <div class="success"><?php echo $this->session->flashdata('notify'); ?></div>
        <?php endif; ?>
    
        
        <td colspan="4">
                <div id="div_bend">
                        <table style="width:100%;" border="0"> 
                            <td width="20%">SKPD</td>
                            <td width="1%">:</td>
                            <td><input type="text" id="cunit" style="width: 100px;" /> 
                            <td><input type="text" id="nmskpd" readonly="true" style="width: 605px;border:0" /></td>
                            </td> 
                        </table>
                </div>
        </td> 
		
		<td colspan="4">
                <div id="div_bend">
                        <table style="width:100%;" border="0"> 
                            <td width="20%">KEGIATAN LAMA</td>
                            <td width="1%">:</td>
                            <td><input type="text" id="kd_lama" style="width: 200px;" /> 
                            <td><input type="text" id="nm_lama" readonly="true" style="width: 605px;border:0" /></td>
                            </td> 
                        </table>
                </div>
        </td> 
		<td colspan="4">
                <div id="div_bend">
                        <table style="width:100%;" border="0"> 
                            <td width="20%">KEGIATAN BARU</td>
                            <td width="1%">:</td>
                            <td><input type="text" id="kd_baru" style="width: 200px;" /> 
                            <td><input type="text" id="nm_baru" readonly="true" style="width: 605px;border:0" /></td>
                            </td> 
                        </table>
                </div>
        </td> 
        

        
       
            
        <tr>



        <table class="narrow">


     
      
	  <tr>
            <td></td>
            <td></td>
            <td align="left">
            <br />
            <a class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:simpandata();">Simpan Data Renja</a>              
            </td>
        </tr>
 
        </table>        
        <div class="clear"></div>
    </div>