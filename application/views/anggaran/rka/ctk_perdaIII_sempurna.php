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
                {field:'kd_skpd',title:'Kode Unit',width:100},  
                {field:'nm_skpd',title:'Nama Unit',width:700}    
            ]],
            onSelect:function(rowIndex,rowData){
				skpd = rowData.kd_skpd;
                $("#nmskpd").attr("value",rowData.nm_skpd);
           $(function(){
            $('#ttd1').combogrid({  
                panelWidth:500,  
                url: '<?php echo base_url(); ?>/index.php/rka/load_ttd_agr/'+skpd,  
                    idField:'nip',  
                    textField:'nama',
                    mode:'remote',  
                    fitColumns:true
                });
				
				 $('#ttd2').combogrid({  
                panelWidth:500,  
                url: '<?php echo base_url(); ?>/index.php/rka/load_ttd_agr/'+skpd,  
                    idField:'nip',  
                    textField:'nama',
                    mode:'remote',  
                    fitColumns:true
                });
				
				
           });
		   
		   
				}  
            });

				 
		 
		 $(function(){  
            $('#ttd2').combogrid({  
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
		
		 
		

		});	

	function cek($cetak,$jns){
         var ckdskpd = $('#cunit').combogrid('getValue');        
         if ($jns=='skpd'){
             var ckdskpd = ckdskpd.substring(0,7);       
         }
           

 	          url="<?php echo site_url(); ?>/rka/preview_perdaIII_sempurna/"+ckdskpd+'/'+$cetak+'/Lampiran III Perda Penyempurnaan '+ckdskpd;

        openWindow( url,$jns );
    }
    
  
 function openWindow( url,$jns ){
        var ckdskpd = $('#cunit').combogrid('getValue');
        var ctglttd = $('#tgl_ttd').datebox('getValue');
		var ckdunit = $('#cunit').combogrid('getValue');  
        var status1 = document.getElementById('status1').value;
        var status2 = document.getElementById('status2').value;    

           if ($jns != 'all')
           { 
                if (ckdunit=='' ){
                    alert("Kode Unit Tidak Boleh Kosong"); 
                return;
                }
           }

            
            lc = '/'+ctglttd+'/';
			window.open(url+lc+status1+'/'+status2,'_blank');
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
if($url==base_url("/index.php/rka/ctk_perdaIII_sempurna")){
    $hidden="hidden";
}else{
    $hidden="";
} 

 ?>
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
							<td width="20%">Unit</td>
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
        <td colspan="3">
                <div id="div_bend">
                        <table <?php echo "$hidden"; ?> style="width:100%;" border="0">
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
                </div>
        </td> 
        </tr>	
		
	
 		<tr>



        <table class="narrow">


		
   
        
        <tr>
           <td width="10%">Cetak</td>
            <td> 
                    <a class="easyui-linkbutton" plain="true" onclick="javascript:cek(0,'skpd');return false" >
                    <img src="<?php echo base_url(); ?>assets/images/icon/print.png" width="25" height="23" title="preview"/></a>
                    <a class="easyui-linkbutton" plain="true" onclick="javascript:cek(1,'skpd');return false">                    
                    <img src="<?php echo base_url(); ?>assets/images/icon/print_pdf.png" width="25" height="23" title="cetak"/></a>
                    <a class="easyui-linkbutton" plain="true" onclick="javascript:cek(2,'skpd');return false">                    
                    <img src="<?php echo base_url(); ?>assets/images/icon/excel.jpg" width="25" height="23" title="cetak"/></a>
           </td>    
        </tr>
        

        </table>        
        <div class="clear"></div>
	</div>