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

    	function cek($cetak,$jns){
            var ckdskpd = $jns;        
c

            if($jns=='all'){
                url="<?php echo site_url(); ?>/rka/preview_perdaunit_III_all/"+ckdskpd+'/'+$cetak+'/'+ckttd+'/Lampiran III - '+ckdskpd;
               
            }else{
                url="<?php echo site_url(); ?>/rka/preview_perdaunit_III/"+ckdskpd+'/'+$cetak+'/'+ckttd+'/Lampiran III - '+ckdskpd;
            }
    
  
            openWindow( url,$jns );
        }

        function openWindow( url,$jns ){
            var  ctglttd = $('#tgl_ttd').datebox('getValue');
        
            if (ctglttd == ''){ 
                alert("Tanggal Tidak Boleh Kosong"); 
                return;
            }

            lc = '?tgl_ttd='+ctglttd+'';    
            window.open(url+lc,'_blank');
			window.focus();        		  
         } 
    </script>


	<div id="content">      
    	<h1><?php echo $page_title; ?> </h1>
        <?php echo form_open('rka/cari_perdaunitIII', array('class' => 'basic')); ?>
		Karakter yang di cari :&nbsp;&nbsp;&nbsp;<input type="text" name="nm_skpd" id="nm_skpd" value="<?php echo set_value('text'); ?>" />
        <input type='submit' name='cari' value='cari' class='btn' />
        <?php echo form_close(); ?>   
		
		<?php if (  $this->session->flashdata('notify') <> "" ) : ?>
        <div class="success"><?php echo $this->session->flashdata('notify'); ?></div>
        <?php endif; ?>


      		<td colspan="3">         
                    <table style="width:100%;" border="0">
                        <td width="15%">TANGGAL TTD</td>
                        <td width="1%">:</td>
                        <td><input type="text" id="tgl_ttd" style="width: 100px;" /> 
                        </td> 
                    </table>
            </td> 
 
       		<td colspan="3">         
                    <table style="width:100%;" border="0">
                        <td width="15%">Cetak Semua</td>
                        <td width="1%">:</td>
                        <td>
                            <a class="easyui-linkbutton" plain="true" onclick="javascript:cek(0,'all');return false" >
                            <img src="<?php echo base_url(); ?>assets/images/icon/print.png" width="25" height="23" title="preview"/></a>
                            <a class="easyui-linkbutton" plain="true" onclick="javascript:cek(1,'all');return false">                    
                            <img src="<?php echo base_url(); ?>assets/images/icon/print_pdf.png" width="25" height="23" title="cetak"/></a>
                        </td>
                        <td><input type="checkbox" name="chkttd" id="chkttd" value="1" checked="checked" /> Penandatanganan di SKPD Terakhir
                    </table>
            </td> 
 
        <table class="narrow"  >
        	<tr>
 	            <th >Kode SKPD </th>            	
                <th >Nama SKPD</th>                
                <th  >Aksi</th>
            </tr>
            <?php foreach($list->result() as $skpd) : ?>
            <tr>                
                <td ><?php echo $skpd->kd_skpd; ?></td>            	
                <td ><?php echo $skpd->nm_skpd; ?></td>  
                <td >                     
                    <a class="easyui-linkbutton" plain="true" onclick="javascript:cek(0,'<?php echo $skpd->kd_skpd; ?>');return false" >
                    <img src="<?php echo base_url(); ?>assets/images/icon/print.png" width="25" height="23" title="preview"/></a>
                    <a class="easyui-linkbutton" plain="true" onclick="javascript:cek(1,'<?php echo $skpd->kd_skpd; ?>');return false">                    
                    <img src="<?php echo base_url(); ?>assets/images/icon/print_pdf.png" width="25" height="23" title="cetak"/></a>
                </td>    
            </tr>
            <?php endforeach; ?>
        </table>
        <?php echo $this->pagination->create_links(); ?> <span class="totalitem">Total Item <?php echo $total_rows ; ?></span>
        <div class="clear"></div>
	</div>