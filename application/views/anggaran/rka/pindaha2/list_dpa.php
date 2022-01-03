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
        
	kode = '<?php echo $kode_skpd; ?>';
   
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
		
		
        $(function(){  
	       $('#dg_ckeg').edatagrid({
				url           : '<?php echo base_url(); ?>/index.php/rka/cs_kegi/'+kode,
                 idField      : 'id',
                 toolbar      : "#toolbar",              
                 rownumbers   : "true", 
                 fitColumns   : "true",
                 singleSelect : "true",
			 	onSelect:function(rowIndex,rowData){							
    				},
				columns:[[
	                {field:'id',
					 title:'id',
					 width:10,
                     hidden:true
					},
					{field:'kd_kegiatan',
					 title:'Rekening',
					 width:12,
					 align:'left'	
					}
				]]
			});
		
		});			
		
		
		
		$(function(){  
            $('#ttd1').combogrid({  
                panelWidth:400,  
                idField:'nip_ppkd',  
                textField:'nama_ppkd',  
                mode:'remote',
                url:'<?php echo base_url(); ?>index.php/rka/load_bendahara_ppkd',  
                columns:[[  
                    {field:'nip_ppkd',title:'NIP',width:200},  
                    {field:'nama_ppkd',title:'Nama',width:400}    
                ]]  
            });          
         });
		 
		 
		 
		
		 
		 
		 $(function(){  
            $('#ttd2').combogrid({  
                panelWidth:400,  
                idField:'nip',  
                textField:'nama',  
                mode:'remote',
                url:'<?php echo base_url(); ?>index.php/rka/load_ttd_unit/'+kode,  
                columns:[[  
                    {field:'nip',title:'NIP',width:200},  
                    {field:'nama',title:'Nama',width:400}    
                ]]  
            });          
         });
		
		
		

		});	

		
	function cek($cetak,$ckdskpd,$ckdgiat){
         //var ckdskpd = $kegiatan->kd_skpd;
         //var cgiat = $kegiatan->kd_skpd;
         
         var cell = document.getElementById('cell').value;          
         if ($('input[name="chkpa"]:checked').val()=='1'){
            var cpa = 1;
         } else{
            var cpa = 0;
         }              

         if($ckdgiat=='semua'){
            $ckdskpd = kode;
			$('#dg_ckeg').datagrid('selectAll');
			var rows = $('#dg_ckeg').datagrid('getSelections'); 
			for(var p=0;p<rows.length;p++){
				$ckdgiat  = rows[p].kd_kegiatan;
				url="<?php echo site_url(); ?>/rka/preview_dpa221/"+$ckdskpd+'/'+$ckdgiat+'/'+$cetak+'/'+cpa+'/'+cell+'/Report DPA-2.2.1 -'+$ckdgiat+'.pdf'
				openWindow( url );
			}
		 }else{
			url="<?php echo site_url(); ?>/rka/preview_dpa221/"+$ckdskpd+'/'+$ckdgiat+'/'+$cetak+'/'+cpa+'/'+cell+'/Report DPA-2.2.1 -'+$ckdgiat
			openWindow( url );
		} 
          
        /*url="<?php echo site_url(); ?>/rka/preview_dpa221/"+$ckdskpd+'/'+$ckdgiat+'/'+$cetak+'/'+cpa+'/'+cell+'/Report DPA-2.2.1 -'+$ckdgiat
        openWindow( url );*/
    }
    
		
		
		


 function openWindow( url ){
         //var ckdskpd = document.getElementById('skpd').value;//$('#skpd').combogrid('getValue');
         //var ckdskpd = cnoskpd.split("/").join("123456789");
           var  ctglttd = $('#tgl_ttd').datebox('getValue');
		   var  ttd = $('#ttd1').combogrid('getValue');
		   var  ttd_2 = $('#ttd2').combogrid('getValue');
           var ttd1 = ttd.split(" ").join("a");
		   var ttd2 = ttd_2.split(" ").join("a");
		   
		   if (ttd=='' || ctglttd==''){
		   alert("Penanda tangan 1 atau tanggal Tanda tangan tidak boleh kosong");
		   } else {
            lc = '?tgl_ttd='+ctglttd+'&ttd1='+ttd1+'&ttd2='+ttd2+'';
			window.open(url+lc,'_blank');
			window.focus();
			}
		  
     } 
	 
	 function alltrim(kata){
	 //alert(kata);
		b = (kata.split(' ').join(''));
		c = (b.replace( /\s/g, ""));
		return c
	 
	 }
	 

  
   </script>

	<div id="content">        
    	<h1><?php echo $page_title; ?><span><a href="<?php echo site_url(); ?>/rka/dpa221">Kembali</a></span></h1>
       
        
        <?php echo form_close(); ?>   
		
		<?php if (  $this->session->flashdata('notify') <> "" ) : ?>
        <div class="success"><?php echo $this->session->flashdata('notify'); ?></div>
        <?php endif; ?>
    
		
		<tr>
		<td colspan="4">
                <div id="div_bend">
                        <table style="width:100%;" border="0">
                            <td width="20%">PPKD</td>
                            <td width="1%">:</td>
                            <td><input type="text" id="ttd1" style="width: 100px;" /> 
                            </td> 
							
							<td width="20%">PA</td>
                            <td width="1%">:</td>
                            <td><input type="text" id="ttd2" style="width: 100px;" /> 
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
                
                <td><input type="checkbox" name="chkpa" id="chkpa" value="1" /> Pengguna Anggaran
                </td>
                <td>&ensp;&ensp;Ukuran Baris  : &nbsp;<input type="number" id="cell" name="cell" style="width: 50px; border:1" value="2" /> &nbsp;&nbsp;</td>
                <td>&nbsp;</td>

            </tr>
        <div>  
            <tr>
                <td>Cetak Semua ke PDF<a class="easyui-linkbutton" plain="true" onclick="javascript:cek(3,'','semua');return false">                    
                    <img src="<?php echo base_url(); ?>assets/images/icon/down_pdf.png" width="25" height="23" title="cetak"/></a>
                </td>
            </tr>
        </div>	
        <div style="display:none">
			<table id="dg_ckeg"  style="width:875px;height:370px;"> 
			</table> 
		</div>	
		
	
		
	 
        <table class="narrow">
        	<tr>
                <th>Kode Kegiatan</th>
                <th>Nama Kegiatan</th>
                <th>Aksi</th>
            </tr>
            <?php foreach($list->result() as $kegiatan) : ?>
            <tr>
                <td><?php echo $kegiatan->giat; ?></td>
                <td><?php echo $kegiatan->nm_kegiatan; ?></td>
                <td>
                    <a class="easyui-linkbutton" plain="true" onclick="javascript:cek(0,'<?php echo $kegiatan->kd_skpd; ?>','<?php echo $kegiatan->giat; ?>');return false" >
                    <img src="<?php echo base_url(); ?>assets/images/icon/print.png" width="25" height="23" title="preview"/></a>
                    <a class="easyui-linkbutton" plain="true" onclick="javascript:cek(1,'<?php echo $kegiatan->kd_skpd; ?>','<?php echo $kegiatan->giat; ?>');return false">                    
                    <img src="<?php echo base_url(); ?>assets/images/icon/print_pdf.png" width="25" height="23" title="cetak"/></a>
					<a class="easyui-linkbutton" plain="true" onclick="javascript:cek(2,'<?php echo $kegiatan->kd_skpd; ?>','<?php echo $kegiatan->giat; ?>');return false">                    
                    <img src="<?php echo base_url(); ?>assets/images/icon/excel.jpg" width="25" height="23" title="cetak"/></a>

                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php echo $this->pagination->create_links(); ?> <span class="totalitem">Total Item <?php echo $this->rka_model->get_count($this->uri->segment(3)); ?></span>
        <div class="clear"></div>
	</div>