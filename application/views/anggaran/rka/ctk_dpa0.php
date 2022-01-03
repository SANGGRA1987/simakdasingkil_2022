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
            panelWidth:800,  
            idField:'kd_skpd',  
            textField:'kd_skpd',  
            mode:'remote',
            url:'<?php echo base_url(); ?>index.php/rka/skpduser',  
            columns:[[  
                {field:'kd_skpd',title:'Kode SKPD',width:180},  
                {field:'nm_skpd',title:'Nama SKPD',width:600}    
            ]],
            onSelect:function(rowIndex,rowData){
                $("#nmskpd").attr("value",rowData.nm_skpd);  
                kods = rowData.kd_skpd;
                validate_ttd(kods);
                cek_status(kods);
                cek_status_angkas(kods);                
            }});

				 
		 
		 $(function(){  
            $('#ttd2').combogrid({  
                panelWidth:700,  
                idField:'nip',  
                textField:'nama',  
                mode:'remote',
                url:'<?php echo base_url(); ?>index.php/rka/load_ttd_agr',  
                columns:[[  
                    {field:'nip',title:'NIP',width:200},  
                    {field:'nama',title:'Nama',width:500}    
                ]]  
            });          
         });
		 
		 $(function(){  
            $('#ttd_sekda').combogrid({  
                panelWidth:700,  
                idField:'nip',  
                textField:'nama',  
                mode:'remote',
                url:'<?php echo base_url(); ?>index.php/rka/load_ttd_sekda',  
                columns:[[  
                    {field:'nip',title:'NIP',width:200},  
                    {field:'nama',title:'Nama',width:500}    
                ]]  
            });          
         });

			
		});	
        
        
        function validate_ttd(kods){
			$(function(){
				$('#ttd1').combogrid({  
				panelWidth:630,  
				idField:'nip',  
				textField:'nama',  
				mode:'remote',
				url:'<?php echo base_url(); ?>/index.php/rka/load_ttd_unit_pa/'+kods,  
				 columns:[[  
							{field:'nip',title:'NIP',width:200},  
							{field:'nama',title:'Nama',width:400}    
						]]
				});
			});
		}



    function cek_status(kods){
            $kd_skpd = kods;
            $rek = '0';
            $stat_ang ='murni';
            
            $.ajax({
                url:'<?php echo base_url(); ?>index.php/rka/config_header_rinci',
                type: "POST",
                dataType:"json",
                data      : ({kdskpd:$kd_skpd,rekk:$rek,angg:$stat_ang}),                         
                success:function(data){
                                        sta    = data.hasil;
                                        tombol(sta);
                                      }                                     
            });        
       }



       function cek_status_angkas(kods){
            $kd_skpd = kods;
            $rek = '0';
            $stat_ang ='murni';
            $.ajax({
                url:'<?php echo base_url(); ?>index.php/rka/config_angkas_anggaran',
                type: "POST",
                dataType:"json",
                data      : ({kdskpd:$kd_skpd,rekk:$rek,angg:$stat_ang}),                         
                success:function(data){
                                        stax    = data.hasilx;
                                        tombol2(stax);
                                      }                                     
            });        
       }


    function tombol(sta){  
    if (sta>'0'){
            document.getElementById("stathead").innerHTML="Ada Rincian dan Header yang Berbeda ! Silahkan Cek Kembali !";
            status_data = '1';
            
     }else{
            document.getElementById("stathead").innerHTML="";
            status_data = '0';

     }
 }

 function tombol2(stax){  
    if (stax>'0'){
            document.getElementById("stathead_ang").innerHTML="Ada Anggaran Kas yang Belum sesuai ! Silahkan Cek Kembali !";
            status_data_ang = '1';
            
     }else{
            document.getElementById("stathead_ang").innerHTML="";
            status_data_ang = '0';

     }
 }

	function cek($cetak,$jns){
           var crinci = 0;            
           var stat_ang = status_data_ang;
           var stat_rinci = status_data;
           var ckdunit = $('#cunit').combogrid('getValue'); 
         
      		if((stat_ang=='1') || (stat_rinci=='1')){
				var cet=confirm('Anda Yakin Akan Tetap Mencetak ?');
				if  (cet==true){
					 if ($jns == 'cover'){
						url="<?php echo site_url(); ?>/rka/preview_coverdpa0/"+ckdunit+'/'+$cetak+'/Report Cover DPA-SKPD'
					 }else if($jns == 'unit'){
						url="<?php echo site_url(); ?>/rka/preview_dpa0/"+ckdunit+'/'+$cetak+'/'+crinci+'/Report DPA-SKPD'
					 }else{
					 	url="<?php echo site_url(); ?>/rka/setuju_dpa0/"+ckdunit+'/'+$cetak+'/Persetujuan DPA-SKPD'
					 }          
					openWindow( url,$jns ); 
				}
			}else{        
				if ($jns == 'cover'){
					url="<?php echo site_url(); ?>/rka/preview_coverdpa0/"+ckdunit+'/'+$cetak+'/Report Cover DPA-SKPD'
				 }else if($jns == 'unit'){
					url="<?php echo site_url(); ?>/rka/preview_dpa0/"+ckdunit+'/'+$cetak+'/'+crinci+'/Report DPA-SKPD'
				 }else{
				 	url="<?php echo site_url(); ?>/rka/setuju_dpa0/"+ckdunit+'/'+$cetak+'/Persetujuan DPA-SKPD'
				 } 
				 openWindow( url,$jns ); 
            }
 
	}

    
    
 
    function openWindow( url,$jns){
        var pilihnya = $('input[name="pilihnya"]:checked').val(); 
        var ckdskpd = kods;
        var ctglttd = $('#tgl_ttd').datebox('getValue');
        var ckdunit = $('#cunit').combogrid('getValue');     
        var ttd_2 = $('#ttd2').combogrid('getValue');
        var ttd2 = ttd_2.split(" ").join("x");
        var ttd_1 = $('#ttd1').combogrid('getValue');
        var ttd1 = ttd_1.split(" ").join("x");
        var ttd_sekda_3 = $('#ttd_sekda').combogrid('getValue');
        var ttd_sekda = ttd_sekda_3.split(" ").join("x");
           
			if ($jns != 'all')
			{ 
				if (ckdunit=='' ){
					alert("Kode Unit Tidak Boleh Kosong"); 
				return;
				}
			}
			if (ttd_2=='' ){
				alert("Tanda Tangan PPKD/SEKDA Tidak Boleh Kosong"); 
				return;
			}
			if (ttd_1=='' ){
				alert("Tanda Tangan PA Tidak Boleh Kosong"); 
				return;
			}
           
			if ($('input[name="chkpa"]:checked').val()=='1'){
			var cttx = 1;
			}
			if ($('input[name="chkppkd"]:checked').val()=='1'){
			var cttx = 2;
			}
            
            //lc = '/'+ctglttd+'/'+ttd2+'/'+cttx+'/'+ttd1+'';
			lc = '/'+ctglttd+'/'+ttd2+'/'+cttx+'/'+ttd1+'/'+ttd_sekda+'?pilih='+pilihnya;
			window.open(url+lc,'_blank');
			window.focus();
		  
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
    
		<p id="stathead" style="font-size: x-large;color: red;"></p>
        <p id="stathead_ang" style="font-size: x-large;color: red;"></p><br />
		<td colspan="4">
                <div id="div_bend">
                        <table style="width:100%;" border="0"> 
							<td width="20%">SKPD</td>
                            <td width="1%">:</td>
                            <td><input type="text" id="cunit" style="width: 180px;" /> 
                            <td><input type="text" id="nmskpd" readonly="true" style="width: 500px;border:0" /></td>
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
                <div id="div_radio">
                    <table style="width:100%;" border="0" hidden>
                        <td width="20%">PILIH PENANDA TANGAN</td>
                        <td>:</td>
                        <!--<td width="80%"><input type="radio" name="cetak" value="1" id="PA" onclick="opt(this.value)" />TTD PA  &ensp;
                                        <input type="radio" name="cetak" value="2" id="PPKD" onclick="opt(this.value)" />TTD PPKD &ensp;
                        </td>-->
                        <td><input type="checkbox" name="chkpa" id="chkpa" value="1"  onclick="javascript:runEffect2();"/>TTD PA</td>
                        <td><input type="checkbox" name="chkppkd" id="chkppkd" value="1" checked="checked" onclick="javascript:runEffect();"/>TTD PKKD</td>
                        <td>&ensp;</td>
                </table>
                </div>
        </td> 
        </tr>
        
        
		<tr>
    
    	<td colspan="4">
                <div id="div_bend">
                        <table style="width:100%;" border="0">							
							  <td width="20%">TTD PPKD</td>
                                <td width="1%">:</td>
                            <td><input type="text" id="ttd2" style="width: 200px;" /> 
                            </td> 
                        </table>
                </div>
        </td> 
        <tr>
        <td colspan="4">
                <div id="div_bend">
                        <table style="width:100%;" border="0">                          
                            <td width="20%">TTD PA</td>
                            <td width="1%">:</td>
                            <td><input name="text" type="text" id="ttd1" style="width: 200px;" /></td>
                            <td>&ensp;</td> 
                        </table>
                </div>
        </td> 
		<td colspan="4">
                <div id="div_bend">
                        <table style="width:100%;" border="0">							
							  <td width="20%">TTD SEKDA</td>
                                <td width="1%">:</td>
                            <td><input type="text" id="ttd_sekda" style="width: 200px;" /> 
                            </td> 
                        </table>
                </div>
        </td>
		<td colspan="4"> 
        
            <table style="width:100%;" border="0">							
                    <td width="20%"> </td>
                    <td width="1%"></td>
                <td>
                    <input type="radio" name="pilihnya" value="normal" checked="true"> Angkas
                    <input type="radio" name="pilihnya" value="kosong" style="margin-left: 24px;" > Kosong
                    <input type="radio" name="pilihnya" value="bulanan" style="margin-left: 24px;" > Perbulan
                    <input type="radio" name="pilihnya" value="triwulan" style="margin-left: 24px;" > Triwulan
                </td> 
            </table>
                 
        </td>
		</tr>
	   
		<tr>

       

        <table class="narrow">


		
        <tr>
           <td width="20%">Cetak</td>
           <td> 
                    
                    <!--<a class="easyui-linkbutton" plain="true" onclick="javascript:cek(0,'unit');return false" >
                    <img src="<?php echo base_url(); ?>assets/images/icon/print.png" width="25" height="23" title="preview"/></a>-->
                    
                    <a class="easyui-linkbutton" plain="true" onclick="javascript:cek(1,'unit');return false">                    
                    <img src="<?php echo base_url(); ?>assets/images/icon/print_pdf.png" width="25" height="23" title="cetak"/></a>
   
           </td>    
        </tr>
        
        <!--<tr>
           <td width="10%">Cetak SKPD</td>
            <td> 
                    <a class="easyui-linkbutton" plain="true" onclick="javascript:cek(0,'skpd');return false" >
                    <img src="<?php echo base_url(); ?>assets/images/icon/print.png" width="25" height="23" title="preview"/></a>
                    <a class="easyui-linkbutton" plain="true" onclick="javascript:cek(1,'skpd');return false">                    
                    <img src="<?php echo base_url(); ?>assets/images/icon/print_pdf.png" width="25" height="23" title="cetak"/></a>
           </td>    
        </tr>-->
 
        <tr>
           <td width="20%">Cetak Cover</td>
            <td> 
                    <!--<a class="easyui-linkbutton" plain="true" onclick="javascript:cek(0,'cover');return false" >
                    <img src="<?php echo base_url(); ?>assets/images/icon/print.png" width="25" height="23" title="preview"/></a>-->
                    <a class="easyui-linkbutton" plain="true" onclick="javascript:cek(1,'cover');return false">                    
                    <img src="<?php echo base_url(); ?>assets/images/icon/print_pdf.png" width="25" height="23" title="cetak"/></a>
           </td>    
        </tr>
		
		 <tr>
           <td width="20%">Cetak Persetujuan</td>
            <td> 
                    <!--<a class="easyui-linkbutton" plain="true" onclick="javascript:cek(0,'setuju');return false" >
                    <img src="<?php echo base_url(); ?>assets/images/icon/print.png" width="25" height="23" title="preview"/></a>-->
                    <a class="easyui-linkbutton" plain="true" onclick="javascript:cek(1,'setuju');return false">                    
                    <img src="<?php echo base_url(); ?>assets/images/icon/print_pdf.png" width="25" height="23" title="cetak"/></a>
           </td>    
        </tr>
 
        </table>        
        <div class="clear"></div>
	</div>