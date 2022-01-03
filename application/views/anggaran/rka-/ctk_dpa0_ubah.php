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
         
         /* 
          $(document).ready(function() {

          $("#div_ttd1").hide();
          document.getElementById("PA").checked = true;
          });
        */
   
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
            url:'<?php echo base_url(); ?>index.php/rka/skpduser',  
            columns:[[  
                {field:'kd_skpd',title:'Kode SKPD',width:100},  
                {field:'nm_skpd',title:'Nama SKPD',width:700}    
            ]],
            onSelect:function(rowIndex,rowData){
                $("#nmskpd").attr("value",rowData.nm_skpd);  
                kods = rowData.kd_skpd;
                validate_ttd(kods);    
                //alert(kods);            
            }});

				

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


    function validate_ttd(kods){
           $(function(){
        $('#ttd1').combogrid({  
        panelWidth:630,  
        idField:'ttd1',  
        textField:'nama',  
        mode:'remote',
        url:'<?php echo base_url(); ?>/index.php/rka/load_ttd_unit_pa/'+kods,  
         columns:[[  
                    {field:'nip',title:'NIP',width:200},  
                    {field:'nama',title:'Nama',width:400}    
                ]],
                onSelect:function(rowIndex,rowData){
            nippax = rowData.nip;
           // alert(nippax);
            //$("#kdrek5").attr("value",rowData.kd_rek5);
            $("#nippa").attr("value",rowData.nip);
        }  
        }); 
        
                       });
        }

	function cek($cetak,$jns){
         if ($('input[name="chkrinci"]:checked').val()=='1'){
            var crinci = 1;
         } else{
            var crinci = 0;
         }

       


         if ($jns == 'unit'){
            var ckdskpd = kods;
            var ckdskpd = ckdskpd.substring(0,7);  
         }
         
         if ($jns == 'cover'){
            url="<?php echo site_url(); ?>/rka/preview_coverdppa0/"+ckdskpd+'/'+$cetak+'/Report-Cover-DPA-0'
         }else{
            url="<?php echo site_url(); ?>/rka/preview_dpa0_ubah/"+ckdskpd+'/'+$cetak+'/'+crinci+'/Report-DPA-0-Perubahan'
         } 
         
        openWindow( url,$jns );
    }


    
 
 function openWindow( url,$jns ){
            var ckdskpd = kods;
           var  ctglttd = $('#tgl_ttd').datebox('getValue');
		   var ckdunit = $('#cunit').combogrid('getValue');     
           var  ttd_2 = $('#ttd2').combogrid('getValue');
		   var ttd2 = ttd_2.split(" ").join("x");
           var  ttd_1 = document.getElementById('nippa').value;
           var ttd1 = ttd_1.split(" ").join("x");;
           
           if ((ttd_2=='' ) || (ttd_1=='' )){
                    alert("Harap isi penandatangan"); 
                return;
                }


           if ($jns != 'all') { 
                if (ckdunit=='' ){
                    alert("Kode Unit Tidak Boleh Kosong"); 
                return;
                }
        }


              

        if ($('input[name="chkpa"]:checked').val()=='1'){
            var cttx = 1;
         }
         if ($('input[name="chkppkd"]:checked').val()=='1'){
            var cttx = 2;
         }
         //  alert(ttdxx);
           /*
		   if (ttd=='' || ctglttd=='' ){
		   alert("Penanda tangan 1 atau tanggal Tanda tangan tidak boleh kosong");
		   } else {
            lc = '?tgl_ttd='+ctglttd+'&ttd1='+ttd1+'&ttd2='+ttd2+'';
			window.open(url+lc,'_blank');
			window.focus();
			}*/
            

            lc = '/'+ctglttd+'/'+ttd1+'/'+cttx+'/'+ttd2;
			window.open(url+lc,'_blank');
			window.focus();
		  
     } 
	 
	 function alltrim(kata){
	 //alert(kata);
		b = (kata.split(' ').join(''));
		c = (b.replace( /\s/g, ""));
		return c
	 
	 }


     function opt(val){
        var pettd = val;        
        ctk = val; 
        if (ctk=='2'){
        //$("#div_skpd").hide();
        options = { percent: 0 };
        selectedEffect = "clip";
        $( "#div_ttd1" ).show( selectedEffect, options, 1000 );
        $( "#div_ttd2" ).hide( selectedEffect, options, 1000 );
        } else if (ctk=='1'){
//            $("#div_skpd").show();
            $( "#div_ttd2" ).show( selectedEffect, options, 1000 );
            $( "#div_ttd1" ).hide( selectedEffect, options, 1000 );
            } else {
            exit();
        }                 
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
                    <table style="width:100%;" border="0">
                        <td width="20%">PILIH PENANDA TANGAN</td>
                        <td>:</td>
                        <!--<td width="80%"><input type="radio" name="cetak" value="1" id="PA" onclick="opt(this.value)" />TTD PA  &ensp;
                                        <input type="radio" name="cetak" value="2" id="PPKD" onclick="opt(this.value)" />TTD PPKD &ensp;
                        </td>-->
                        <td><input type="checkbox" name="chkpa" id="chkpa" value="1" checked="checked" onclick="javascript:runEffect2();"/>TTD PA</td>
                        <td><input type="checkbox" name="chkppkd" id="chkppkd" value="1" onclick="javascript:runEffect();"/>TTD PKKD</td>
                        <td>&ensp;</td>
                </table>
                </div>
        </td> 
        </tr>

		<tr>
        <td colspan="4">
                <div id="div_ttd2">
                        <table style="width:100%;" border="0">                          
                            <td width="20%">TTD PA</td>
                            <td width="1%">:</td>
                            <td><input type="text" id="ttd1" style="width: 200px;" /> 
                            </td>
                            <input type="text" id="nippa" hidden ="true" style="width: 200px;" /> </td>
                            <td>&ensp;</td> 
                        </table>
                </div>
        </td> 		</tr>
	   
		<tr>
        
		<td colspan="4">
                <div id="div_ttd1">
                        <table style="width:100%;" border="0">							
							<td width="20%">TTD</td>
                            <td width="1%">:</td>
                            <td><input type="text" id="ttd2" style="width: 200px;" /> 
                            </td>
                            <td>&ensp;</td> 
                        </table>
                </div>
        </td> 


		</tr>
			<tr>
                <td><input type="checkbox" name="chkrinci" id="chkrinci" value="1" /> Cetak Rincian
                </td>
                <td>&ensp;</td>
                <td>&nbsp</td>
            </tr>
		<tr>



        <table class="narrow">


		
        <tr>
           <td width="10%">Cetak</td>
           <td> 
                    
                    <a class="easyui-linkbutton" plain="true" onclick="javascript:cek(0,'unit');return false" >
                    <img src="<?php echo base_url(); ?>assets/images/icon/print.png" width="25" height="23" title="preview"/></a>
                    <a class="easyui-linkbutton" plain="true" onclick="javascript:cek(1,'unit');return false">                    
                    <img src="<?php echo base_url(); ?>assets/images/icon/print_pdf.png" width="25" height="23" title="cetak"/></a>
                    <a class="easyui-linkbutton" plain="true" onclick="javascript:cek(2,'unit');return false">                    
                    <img src="<?php echo base_url(); ?>assets/images/icon/excel.jpg" width="25" height="23" title="excel"/></a>
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
           <td width="10%">Cetak Cover</td>
            <td> 
                    <a class="easyui-linkbutton" plain="true" onclick="javascript:cek(0,'cover');return false" >
                    <img src="<?php echo base_url(); ?>assets/images/icon/print.png" width="25" height="23" title="preview"/></a>
                    <a class="easyui-linkbutton" plain="true" onclick="javascript:cek(1,'cover');return false">                    
                    <img src="<?php echo base_url(); ?>assets/images/icon/print_pdf.png" width="25" height="23" title="cetak"/></a>
           </td>    
        </tr>
 
        </table>        
        <div class="clear"></div>
	</div>