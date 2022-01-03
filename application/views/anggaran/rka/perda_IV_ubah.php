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
    
            url="<?php echo site_url(); ?>/rka/preview_perdaIV_ubah/"+ckdskpd+'/'+$cetak+'/Lampiran_IV_Perubahan_'+ckdskpd;
    
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
    	<h1><?php echo $page_title; ?>&nbsp;&nbsp;&nbsp;&nbsp; 
       </h1>
 
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
    
        <table class="narrow">
        	<tr>
 	            <th>Pilihan </th>            	
                <th>Aksi</th>
            </tr>
            <tr>                
            <tr>                
                <td><?php echo 'CETAK'; ?></td>            	

                <td >                     
                    <a class="easyui-linkbutton" plain="true" onclick="javascript:cek(0,'SKPD');return false" >
                    <img src="<?php echo base_url(); ?>assets/images/icon/print.png" width="25" height="23" title="preview"/></a>
                    <a class="easyui-linkbutton" plain="true" onclick="javascript:cek(1,'SKPD');return false">                    
                    <img src="<?php echo base_url(); ?>assets/images/icon/print_pdf.png" width="25" height="23" title="cetak"/></a>
                    <a class="easyui-linkbutton" plain="true" onclick="javascript:cek(2,'SKPD');return false">                    
                    <img src="<?php echo base_url(); ?>assets/images/icon/excel.jpg" width="25" height="23" title="cetak"/></a>

                </td>    


            </tr>
            <!--<tr>                
                <td><?php echo 'UNIT'; ?></td>            	
                <td >                     
                    <a class="easyui-linkbutton" plain="true" onclick="javascript:cek(0,'UNIT');return false" >
                    <img src="<?php echo base_url(); ?>assets/images/icon/print.png" width="25" height="23" title="preview"/></a>
                    <a class="easyui-linkbutton" plain="true" onclick="javascript:cek(1,'UNIT');return false">                    
                    <img src="<?php echo base_url(); ?>assets/images/icon/print_pdf.png" width="25" height="23" title="cetak"/></a>
                    <a class="easyui-linkbutton" plain="true" onclick="javascript:cek(2,'UNIT');return false">                    
                    <img src="<?php echo base_url(); ?>assets/images/icon/excel.jpg" width="25" height="23" title="cetak"/></a>

                </td>    

            </tr>-->
        </table>
 
        <div class="clear"></div>
	</div>