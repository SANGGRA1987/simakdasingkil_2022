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

    });

	function cek($cetak){
		
        url="<?php echo site_url(); ?>/rka/preview_perda1_sempurna/"+$cetak;
        openWindow( url);
    }
        
    function openWindow( url){
        var status1 = document.getElementById('status1').value;
        var status2 = document.getElementById('status2').value; 
        var  ctglttd = $('#tgl_ttd').datebox('getValue');
        if (ctglttd == '')
        { 
            alert("Tanggal Tidak Boleh Kosong"); 
            return;
        }
        if ($('input[name="chkrinci"]:checked').val()=='1'){
          var crinci = 1;
         } else{
            var crinci = 0;
         }
        lc = '/'+ctglttd+'/'+crinci+'';
        window.open(url+lc+'/'+status1+'/'+status2,'_blank');
        window.focus();
		  
     } 
	 
	 function alltrim(kata){
	 //alert(kata);
		b = (kata.split(' ').join(''));
		c = (b.replace( /\s/g, ""));
		return c
	 
	 }
 
   </script>
<?php 
$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
if($url==base_url("/index.php/rka/perda_1_sempurnax")){
    $hidden="";
}else{
    $hidden="hidden";
}
 ?>
	<div id="content">      

    	<h1><?php echo $page_title; ?>&nbsp;&nbsp;&nbsp;&nbsp;<br /> <br />
  		<td colspan="3">         
                        <table style="width:100%;" border="0">
                            <td width="20%">TANGGAL TTD</td>
                            <td width="1%">:</td>
                            <td><input type="text" id="tgl_ttd" style="width: 100px;" /> 
                            </td> 
                        </table>
        </td> 
        <td colspan="3">         
                        <table <?php echo "$hidden"; ?>  border="0">
                            <td width="20%">Perbandingan Status Anggaran</td>
                            <td > : <select id="status1">
                                        <option value="nilai" selected>Nilai Murni</option>
                                        <option value="nilai_sempurna">Nilai Pergeseran Berjalan</option>
                                        <option value="nilai_geser1">Nilai Pergeseran 1</option>
                                        <option value="nilai_geser2">Nilai Pergeseran 2</option>
                                        <option value="nilai_geser3">Nilai Pergeseran 3</option>
                                        <option value="nilai_geser4">Nilai Pergeseran 4</option>
                                        <option value="nilai_geser5">Nilai Pergeseran 5</option>
                                        <option value="nilai_geser6">Nilai Pergeseran 6</option>
                                        <option value="nilai_geser7">Nilai Pergeseran 7</option>
                                        <option value="nilai_geser8">Nilai Pergeseran 8</option>
                                        <option value="nilai_ubah">Nilai Perubahan</option>
                                </select> <b><strong> : </strong></b>
                                <select id="status2">
                                        <option value="nilai" >Nilai Murni</option>
                                        <option value="nilai_sempurna" selected>Nilai Pergeseran Berjalan</option>
                                        <option value="nilai_geser1">Nilai Pergeseran 1</option>
                                        <option value="nilai_geser2">Nilai Pergeseran 2</option>
                                        <option value="nilai_geser3">Nilai Pergeseran 3</option>
                                        <option value="nilai_geser4">Nilai Pergeseran 4</option>
                                        <option value="nilai_geser5">Nilai Pergeseran 5</option>
                                        <option value="nilai_geser6">Nilai Pergeseran 6</option>
                                        <option value="nilai_geser7">Nilai Pergeseran 7</option>
                                        <option value="nilai_geser8">Nilai Pergeseran 8</option>
                                        <option value="nilai_ubah">Nilai Perubahan</option>
                                </select>                                
                            </td>

                        </table>
        </td> 
        <tr>
                <td><input type="checkbox" name="chkrinci" id="chkrinci" value="1" /> Cetak Rincian
                </td>
                <td>&ensp;</td>
                <td>&nbsp</td>
            </tr>

        <tr>
            <td> 
                    <a class="easyui-linkbutton" plain="true" onclick="javascript:cek(0,'all');return false" >
                    <img src="<?php echo base_url(); ?>assets/images/icon/print.png" width="25" height="23" title="preview"/></a>
                    <a class="easyui-linkbutton" plain="true" onclick="javascript:cek(1,'all');return false">                    
                    <img src="<?php echo base_url(); ?>assets/images/icon/print_pdf.png" width="25" height="23" title="cetak"/></a>
                    <a class="easyui-linkbutton" plain="true" onclick="javascript:cek(2,'all');return false">                    
                    <img src="<?php echo base_url(); ?>assets/images/icon/excel.jpg" width="25" height="23" title="excel"/></a>
        </tr>

        
       </h1>
<!--     
	 <?php echo form_open('rka/cari_perda1', array('class' => 'basic')); ?>
		Karakter yang di cari :&nbsp;&nbsp;&nbsp;<input type="text" name="nm_org" id="nm_org" value="<?php echo set_value('text'); ?>" />
        <input type='submit' name='cari' value='cari' class='btn' />
        <?php echo form_close(); ?>   
		
		<?php if (  $this->session->flashdata('notify') <> "" ) : ?>
        <div class="success"><?php echo $this->session->flashdata('notify'); ?></div>
        <?php endif; ?>
    
        <table class="narrow">
        	<tr>
 	            <th>Kode SKPD </th>            	
                <th>Nama SKPD</th>                
                <th>Aksi</th>
            </tr>
            <?php foreach($list->result() as $skpd) : ?>
            <tr>                
                <td><?php echo $skpd->kd_org; ?></td>            	
                <td><?php echo $skpd->nm_org; ?></td>  
                <td>                     
                    <a href="<?php echo site_url(); ?>/rka/preview_perda1_skpd/<?php echo $skpd->kd_org;?>/<?php echo '0';?>" ><img src="<?php echo base_url(); ?>assets/images/icon/print.png" width="25" height="23" title="cetak" /></a>
                    <a href="<?php echo site_url(); ?>/rka/preview_perda1_skpd/<?php echo $skpd->kd_org; ?>/<?php echo '1';?>" target='_blank'><img src="<?php echo base_url(); ?>assets/images/icon/print_pdf.png" width="25" height="23" title="cetak"/></a>
                    <a href="<?php echo site_url(); ?>/rka/preview_perda1_skpd/<?php echo $skpd->kd_org; ?>/<?php echo '2';?>"><img src="<?php echo base_url(); ?>assets/images/icon/excel.jpg" width="25" height="23" title="cetak"/></a></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php echo $this->pagination->create_links(); ?> <span class="totalitem">Total Item <?php echo $total_rows ; ?></span>
        <div class="clear"></div> -->
<h1>
		</div>
