

	<div id="content">      
    	<h1><?php echo $page_title; ?>&nbsp;&nbsp;&nbsp;&nbsp; 
       </h1>
 
		<?php if (  $this->session->flashdata('notify') <> "" ) : ?>
        <div class="success"><?php echo $this->session->flashdata('notify'); ?></div>
        <?php endif; ?>
    
        <table class="narrow"><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
    
            url="<?php echo site_url(); ?>/rka/preview_perdaV_sempurna/"+ckdskpd+'/'+$cetak+'/Lampiran V Pergeseran - '+ckdskpd;
    
            openWindow( url,$jns );
        }

        function openWindow( url,$jns ){
            var status1 = document.getElementById('status1').value;
            var status2 = document.getElementById('status2').value;             
            var  ctglttd = $('#tgl_ttd').datebox('getValue');
        
            if (ctglttd == ''){ 
                alert("Tanggal Tidak Boleh Kosong"); 
                return;
            }

            lc = '/'+ctglttd+'';    
            window.open(url+lc+'/'+status1+'/'+status2,'_blank');
			window.focus();        		  
         } 

    </script>

<?php 
    $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    if($url==base_url("/index.php/rka/perda_V_sempurna")){
        $hidden="hidden";
    }else{
        $hidden="";
    } 
?>

      		<td colspan="3">         
                    <table style="width:100%;" border="0">
                        <td width="20%">TANGGAL TTD</td>
                        <td width="1%">:</td>
                        <td><input type="text" id="tgl_ttd" style="width: 100px;" /> 
                        </td> 
                    </table>
                    <table <?php echo "$hidden"; ?> style="width:100%;" border="0">
                        <td width="20%">Perbandingan Status Anggaran</td>
                            <td >: <select id="status1">
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
                                </select> &nbsp;<strong><b>:</b></strong>
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
 	            <th>Pilihan </th>            	
                <th>Aksi</th>
            </tr>
            <tr>                

            <tr>                
                <td><?php echo 'FUNGSI'; ?></td>            	

                <td >                     
                    <a class="easyui-linkbutton" plain="true" onclick="javascript:cek(0,'FUNGSI');return false" >
                    <img src="<?php echo base_url(); ?>assets/images/icon/print.png" width="25" height="23" title="preview"/></a>
                    <a class="easyui-linkbutton" plain="true" onclick="javascript:cek(1,'FUNGSI');return false">                    
                    <img src="<?php echo base_url(); ?>assets/images/icon/print_pdf.png" width="25" height="23" title="cetak"/></a>
                </td>    
            </tr>

        </table>
 
        <div class="clear"></div>
	</div>