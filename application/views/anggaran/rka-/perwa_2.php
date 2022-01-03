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
    var giat = '';
    var nomor= '';
    var judul= '';
    var cid = 0;
    var lcidx = 0;
    var lcstatus = '';
    var ctk = '';
        
   
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
		
		
		
		$('#cunit').combogrid({  
            panelWidth:700,  
            idField:'kd_skpd',  
            textField:'kd_skpd',  
            mode:'remote',
            url:'<?php echo base_url(); ?>index.php/rka/skpd',  
            columns:[[  
                {field:'kd_skpd',title:'Kode UNIT',width:100},  
                {field:'nm_skpd',title:'Nama UNIT',width:700}    
            ]],
            onSelect:function(rowIndex,rowData){
				skpd = rowData.kd_skpd;
                $("#nmskpd").attr("value",rowData.nm_skpd); 
                $(function(){
				    $('#ttd2').combogrid({  
                        panelWidth:500,  
                        url: '<?php echo base_url(); ?>/index.php/rka/load_ttd_unit/'+skpd,  
                        idField:'nip',  
                        textField:'nama',
                        mode:'remote',  
                        fitColumns:true
                    });
									
                });
            }
        });


		$(function(){  
            $('#ttd1').combogrid({  
                panelWidth:400,  
                idField:'nip',  
                textField:'nama',  
                mode:'remote',
                url:'<?php echo base_url(); ?>index.php/rka/load_ttd_agr',  
                columns:[[  
                    {field:'nip',title:'NIP',width:200},  
                    {field:'nama',title:'Nama',width:400}    
                ]]  
            });          
         });

				 
		 
		 $(function(){  
            $('#ttd2').combogrid({  
                panelWidth:400,  
                idField:'nip',  
                textField:'nama',  
                mode:'remote',
                url:'<?php echo base_url(); ?>index.php/rka/load_ttd_unit',  
                columns:[[  
                    {field:'nip',title:'NIP',width:200},  
                    {field:'nama',title:'Nama',width:400}    
                ]]  
            });          
         });
		
		
		

		});	

	function cek($cetak){
         var ckdskpd = $('#cunit').combogrid('getValue');
         var ctglttd = $('#tgl_ttd').datebox('getValue');
		 var cell = document.getElementById('cell').value;
            url="<?php echo site_url(); ?>/rka/preview_perwa2/"+ckdskpd+'/'+$cetak+'/'+cell+'/'+ctglttd+'/Lampiran-II-Perwa'
          
         window.open(url,'_blank');
        window.focus();
    }
    
 

	 
	 function alltrim(kata){
	 //alert(kata);
		b = (kata.split(' ').join(''));
		c = (b.replace( /\s/g, ""));
		return c
	 
	 }
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

		<td colspan="4">
                <div id="div_bend">
                        <table style="width:100%;" border="0">							
							<!--	<td width="20%">PPKD</td>
                            <td width="1%">:</td>
                            <td><input type="text" id="ttd1" style="width: 200px;" /> 
                            </td> 
                        
						<td width="10%">PA</td>
                            <td width="1%">:</td>
                            <td><input type="text" id="ttd2" style="width: 200px;" /> 
                            </td> -->
                        </table>
                </div>
        </td> 


		</tr>

           <tr>
                
           <!--      <td><input type="checkbox" name="chkpa" id="chkpa" value="1" /> Pengguna Anggaran
                </td>
                <td>&ensp;</td>
                <td>&nbsp;</td>
                <td><input type="checkbox" name="chkcover" id="chkcover" value="1" /> Cetak Cover
                </td>-->
                <td>&ensp;&ensp;Ukuran Baris  : &nbsp;<input type="number" id="cell" name="cell" style="width: 50px; border:1" value="1" /> &nbsp;&nbsp;</td>
                <td>&nbsp;</td>
 
				<td>&ensp;</td>
                <td>&nbsp;</td>

            </tr>
        
		<tr>
        	
        <table class="narrow">


		
        <tr>
           <td width="10%">Pilih Cetak</td>
           <td> 
                    
                    <a class="easyui-linkbutton" plain="true" onclick="javascript:cek(0);return false" >
                    <img src="<?php echo base_url(); ?>assets/images/icon/print.png" width="25" height="23" title="preview"/></a>
                    <a class="easyui-linkbutton" plain="true" onclick="javascript:cek(1);return false">                    
                    <img src="<?php echo base_url(); ?>assets/images/icon/print_pdf.png" width="25" height="23" title="cetak"/></a>
                    <a class="easyui-linkbutton" plain="true" onclick="javascript:cek(2);return false">                    
                    <img src="<?php echo base_url(); ?>assets/images/icon/excel.jpg" width="25" height="23" title="cetak"/></a>
          </td>    
        </tr>
        
 
<!--
        <tr>
           <td width="10%">Cetak Cover</td>
            <td> 
                    <a class="easyui-linkbutton" plain="true" onclick="javascript:cek(0,'cover');return false" >
                    <img src="<?php echo base_url(); ?>assets/images/icon/print.png" width="25" height="23" title="preview"/></a>
                    <a class="easyui-linkbutton" plain="true" onclick="javascript:cek(1,'cover');return false">                    
                    <img src="<?php echo base_url(); ?>assets/images/icon/print_pdf.png" width="25" height="23" title="cetak"/></a>
           </td>    
        </tr>
--> 
        </table>        
        <div class="clear"></div>
	</div>