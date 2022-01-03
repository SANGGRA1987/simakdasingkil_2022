<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
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
	var krit = '';
                    
     $(document).ready(function() {
            $("#accordion").accordion();            
            $( "#dialog-modal" ).dialog({
            height: 1000,
            width: 1000,
            modal: true,
            autoOpen:false,
        });       
        $("#spm_gu").hide();        
     });    
     
  
     $(function(){        
		$('#tglspm1').datebox({  
			required:true,
			formatter :function(date){
			var y = date.getFullYear();
			var m = date.getMonth()+1;
			var d = date.getDate();
			return y+'-'+(m<10?('0'+m):m)+'-'+(d<10?('0'+d):d);
			//return y+'-'+m+'-'+d;
			}
		});

        $('#ttd').combogrid({  
            panelWidth:700,  
            url: '<?php echo base_url(); ?>/index.php/tukd_verif/pilih_ttd_penguji',  
            idField:'nip',  
            textField:'nip',
            mode:'remote',  
            fitColumns:true,  
            columns:[[    
            {field:'nip',title:'NIP',width:200},
            {field:'nama',title:'Nama',width:400}
            ]],  
            onSelect:function(rowIndex,rowData){
             $("#nm_ttd").attr("value",rowData.nama);
            }   
        });
		
		$('#ttd1').combogrid({  
            panelWidth:700,  
            url: '<?php echo base_url(); ?>/index.php/tukd_verif/pilih_ttd_kabid',  
            idField:'nip',  
            textField:'nip',
            mode:'remote',  
            fitColumns:true,  
            columns:[[    
            {field:'nip',title:'NIP',width:200},
            {field:'nama',title:'Nama',width:400}
            ]],  
            onSelect:function(rowIndex,rowData){
             $("#nm_ttd1").attr("value",rowData.nama);
            }   
        });
        
    });
    
    $(function(){ 
     $('#dg').edatagrid({
        url: '<?php echo base_url(); ?>/index.php/tukd_verif/load_verif_spp_ls_barang_jasa',
        idField:'id',            
        rownumbers:"true", 
        fitColumns:"true",
        singleSelect:"true",
        autoRowHeight:"false",
        loadMsg:"Tunggu Sebentar....!!",
		pagination:"true",
        nowrap:"true",                        
        columns:[[
            {field:'no_spp',title:'NO. SPM',width:90,align:"left"},
			{field:'tgl_spp',title:'Tgl SPM',width:20,align:"center"},
            {field:'nilai',title:'Nilai',width:40,align:"right"}
        ]],
        onSelect:function(rowIndex,rowData){
			no_sppedit = rowData.no_spp;
			tgl_terima = rowData.tgl_spp;
			tot_spm    = rowData.nilai;
			getedit(no_sppedit,tgl_terima,tot_spm);
        },
        onDblClickRow:function(rowIndex,rowData){
           lcidx = rowIndex;
           judul = 'Edit Data'; 
           edit_data();   
        }
        
        });               
    });
 
    function getedit(no_sppedit,tgl_terima,tot_spm){
            kosongkan(); 
            $("#sppedit").attr("value",no_sppedit);               
            $("#tglspp").attr("value",tgl_terima);
			$("#nilaispm").attr("value",tot_spm);          
            document.getElementById('spm1').checked = true;
            document.getElementById('spm2').checked = true;
            document.getElementById('spm3').checked = true;
            document.getElementById('spm4').checked = true;
            document.getElementById('spm5').checked = true; 
			document.getElementById('spm6').checked = true;
			document.getElementById('spm7').checked = true;
			document.getElementById('spm8').checked = true;
			document.getElementById('spm9').checked = true;
			document.getElementById('spm10').checked = true;
			document.getElementById('spm11').checked = true;
			document.getElementById('spm12').checked = true;
			document.getElementById('spm13').checked = true;
			document.getElementById('spm14').checked = false;
			document.getElementById('spm15').checked = true;
			document.getElementById('spm16').checked = false;
			document.getElementById('spm17').checked = true;
			document.getElementById('spm18').checked = false;
			document.getElementById('spm19').checked = false;
            $("#spm_gu").show();                               
        } 
    
    function kosongkan(){
		$("#sppedit").attr("value",'');
		$("#tglspp").attr("value",'');
		$("#nilaispm").attr("value",0);
		$("#nm_ttd").attr("value",'');
		$("#catatan1").attr("value",''); 
		$("#catatan2").attr("value",''); 
		$("#catatan3").attr("value",'');		
    }
    
    
      function edit_data(){
        lcstatus = 'edit';
        judul = 'Verifikasi SPP';
        $("#dialog-modal").dialog({ title: judul });
        $("#dialog-modal").dialog('open');
     }  

     $(function(){ 
		$('#dg').edatagrid({
		  url: '<?php echo base_url(); ?>/index.php/tukd_verif/load_verif_spp_ls_barang_jasa',
		  queryParams:({kriteria_init:krit})
		});        
	   });
	 
	 function cari(){
     var kriteria = document.getElementById("txtcari").value; 
        $(function(){ 
            $('#dg').edatagrid({
           url: '<?php echo base_url(); ?>/index.php/tukd_verif/load_verif_spp_ls_barang_jasa',
         queryParams:({cari:kriteria})
        });        
     });
    } 
	
	function keluar2(){
        $("#dialog-modal").dialog('close');
    }    
    
    function openWindow(url) {
        var kode = document.getElementById('sppedit').value;
        var no = kode.split("/").join("123456789");
		ctglttd = $('#tglspm1').datebox('getValue');
		var ttd_ = $('#ttd').combogrid('getValue');
	    var ttd = ttd_.split(" ").join("123456789");
		var ttd1_ = $('#ttd1').combogrid('getValue');
	    var ttd1 = ttd1_.split(" ").join("123456789");
		var cat1 = document.getElementById('catatan1').value;
		var catatan1 = cat1.split(" ").join("123456789");
		var cat2 = document.getElementById('catatan2').value;
		var catatan2 = cat2.split(" ").join("123456789");
		var cat3 = document.getElementById('catatan3').value;
		var catatan3 = cat3.split(" ").join("123456789");
		var dspm1 = document.getElementById('spm1').checked; 
		var dspm2 = document.getElementById('spm2').checked; 
		var dspm3 = document.getElementById('spm3').checked; 
		var dspm4 = document.getElementById('spm4').checked; 
		var dspm5 = document.getElementById('spm5').checked; 
		var dspm6 = document.getElementById('spm6').checked; 
		var dspm7 = document.getElementById('spm7').checked;
		var dspm8 = document.getElementById('spm8').checked; 
		var dspm9 = document.getElementById('spm9').checked; 
		var dspm10 = document.getElementById('spm10').checked; 
		var dspm11 = document.getElementById('spm11').checked; 
		var dspm12 = document.getElementById('spm12').checked; 
		var dspm13 = document.getElementById('spm13').checked; 
		var dspm14 = document.getElementById('spm14').checked; 
		var dspm15 = document.getElementById('spm15').checked; 
		var dspm16 = document.getElementById('spm16').checked;  
		var dspm17 = document.getElementById('spm17').checked; 
		var dspm18 = document.getElementById('spm18').checked; 
		var dspm19 = document.getElementById('spm19').checked;   
		
		lc = '?no='+no+'&ctglttd='+ctglttd+'&ttd='+ttd+'&ttd1='+ttd1+'&catatan1='+catatan1+'&catatan2='+catatan2+'&catatan3='+catatan3+'&dspm1='+dspm1+'&dspm2='+dspm2+'&dspm3='+dspm3+'&dspm4='+dspm4+'&dspm5='+dspm5+'&dspm6='+dspm6+'&dspm7='+dspm7+'&dspm8='+dspm8+'&dspm9='+dspm9+'&dspm10='+dspm10+'&dspm11='+dspm11+'&dspm12='+dspm12+'&dspm13='+dspm13+'&dspm14='+dspm14+'&dspm15='+dspm15+'&dspm16='+dspm16+'&dspm17='+dspm17+'&dspm18='+dspm18+'&dspm19='+dspm19+'&LSBJ='+'LSBJ';
				
        window.open(url+lc,'_blank');
		window.focus();
    }     
       
   </script>

</head>
<body>

<div id="content"> 
	<div id="accordion">
		<h3 align="center"><u><b><a href="#" id="section1">VERIFIKASI SPP LS BARANG JASA KONSULTASI</a></b></u></h3>
		<div>
		<p align="left" >  
		</p>
			<a class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="javascript:cari();">Cari</a>
			<input type="text" value="" id="txtcari" style="width: 500px;"/>
			<table id="dg" title="DAFTAR SPP LS BARANG JASA KONSULTASI" style="width:870px;height:500px;" >  
			</table>
		</div>
	</div>
</div>

<div id="dialog-modal" title="">
    <fieldset>
    <table align="center" style="width:100%;" border="0">    
    <p id="pcek" style="font-size: x-large;color: red;"></p>
    <tr>   
		<table align="center" style="width:100%;" border="0">
			<tr>
				<td width="100px">No SPM</td>
				<td>: <input id="sppedit" name="sppedit" style="width: 450px;" readonly="true"/></td>
			</tr>
			<tr>
				<td width="100px">Tgl SPM</td>
				<td>: <input id="tglspp" name="tglspp" style="width: 100px;" readonly="true"/></td>
			</tr>
			<tr>
				<td width="100px">Nilai</td>
				<td>: Rp. <input name="nilaispm" id="nilaispm" readonly style="border-style: none ;width: 200px;"></td>
			</tr> 
			<tr>
				<td width="100px">&nbsp;</td>
				<td>&nbsp;</td>
			</tr>     
		</table>		      
		<div id="spm_gu">
			<table width="100%">
				<tr><td><b>Kelengkapan dokumen Pengajuan SP2D LS Jasa Konsultansi dan sejenisnya</b></td>
					</tr>            
				<tr><td><input type="checkbox" name="spm1" id="spm1" value="1"/>Surat Pengantar SPM LS Pengadaan Barang dan Jasa</td>
					</tr>
				<tr><td><input type="checkbox" name="spm2" id="spm2" value="2"/>Surat Pernyataan Pengajuan SPM LS Pengadaan Barang dan Jasa (SPTJM-SPM)</td>
					</tr>
				<tr><td><input type="checkbox" name="spm3" id="spm3" value="3"/>Surat Penyediaan Dana/SPD</td>
					</tr>
				<tr><td><input type="checkbox" name="spm4" id="spm4" value="4"/>SPM LS Pengadaan Barang dan Jasa</td>
					</tr> 
				<tr><td><input type="checkbox" name="spm5" id="spm5" value="5"/>Kartu Pengawasan Kontrak/SPK</td>
					</tr>
				<tr><td><input type="checkbox" name="spm6" id="spm6" value="6"/>Berita acara pembayaran</td>
					</tr> 
				<tr><td><input type="checkbox" name="spm7" id="spm7" value="7"/>Elektronik billing pajak PPN dan PPh</td>
					</tr>
				<tr><td><input type="checkbox" name="spm8" id="spm8" value="8"/>Foto copy NPWP</td>
					</tr>
				<tr><td><input type="checkbox" name="spm9" id="spm9" value="9"/>Print out/foto copy rekening giro terbaru</td>
					</tr>
				<tr><td><input type="checkbox" name="spm10" id="spm10" value="10"/>Surat setoran/bukti setoran Infaq</td>
					</tr>
				<tr><td><input type="checkbox" name="spm11" id="spm11" value="11"/>Surat Pernyataan Verifikasi Kelengkapan dan Keabsahan Dokumen dan Lampiran SPP LS Pengadaan Barang dan Jasa yang ditandatangani oleh PPK SKPK</td>
					</tr>
				<tr><td><input type="checkbox" name="spm12" id="spm12" value="12"/>Format checklist kelengkapan dokumen yang ditandatangani oleh PPK SKPK</td>
					</tr>
				<tr><td>&nbsp;</td>
					</tr> 
				<tr><td><b>Setelah melakukan verifikasi dan penelitian terhadap kelengkapan dokumen tersebut di atas maka :</b></td>
					</tr>
				<tr><td>&nbsp;</td>
					</tr>
				<tr><td><b>1. Diverifikasi/diteliti oleh Penguji Tagihan</b></td>
					</tr>
				<tr><td><input type="checkbox" name="spm13" id="spm13" value="13"/>Berkas memenuhi persyaratan</td>
					</tr>
				<tr><td><input type="checkbox" name="spm14" id="spm14" value="14"/>Berkas tidak memenuhi persyaratan</td>
					</tr>				
				<tr><td>Catatan atas berkas :</td>
					</tr>
				<tr><td><textarea name="catatan1" id="catatan1" rows="2" style="width: 700px;"></textarea></td>
					</tr> 
				<tr><td><b>2. Diverifikasi/diteliti kembali oleh Kasubid</b></td>
					</tr>
				<tr><td><input type="checkbox" name="spm17" id="spm17" value="17"/>Penatausahaan dan Pengelolaan Kas</td>	
					</tr>
				<tr><td><input type="checkbox" name="spm18" id="spm18" value="18"/>Belanja Langsung</td>	
					</tr>
				<tr><td><input type="checkbox" name="spm19" id="spm19" value="19"/>Belanja Tidak Langsung</td>	
					</tr>
				<tr><td>&nbsp;</td>						
					</tr>					
				<tr><td><input type="checkbox" name="spm15" id="spm15" value="15"/>Berkas memenuhi persyaratan</td>	
					</tr>
				<tr><td><input type="checkbox" name="spm16" id="spm16" value="16"/>Berkas tidak memenuhi persyaratan</td>						
					</tr>	
				<tr><td>Catatan atas berkas :</td>
					</tr>
				<tr><td><textarea name="catatan2" id="catatan2" rows="2" style="width: 700px;"></textarea></td>
					</tr>				 
				<tr><td>Keterangan :</td>
					</tr>
				<tr><td><textarea name="catatan3" id="catatan3" rows="3" style="width: 700px;"></textarea></td>
					</tr>  
			</table>
		</div>
    </table>	   
  </fieldset>
  <table width="100%">
			<tr> 
				<td>
				<table>    
					<tr>
						<td>TTD Penguji</td>
						<td> : <input id="ttd" name="ttd" style="width: 200px;" />&nbsp;&nbsp;<input id="nm_ttd" name="nm_ttd" style="width: 400px;border: none;padding-left: 10px;" /></td>
					</tr>
				</table>           
				</td>       
			</tr> 
			<tr> 
				<td>
				<table>    
					<tr>
						<td>TTD Kasubid</td>
						<td> : <input id="ttd1" name="ttd1" style="width: 200px;" />&nbsp;&nbsp;<input id="nm_ttd1" name="nm_ttd1" style="width: 400px;border: none;padding-left: 10px;" /></td>
					</tr>
				</table>           
				</td>       
			</tr>
			<tr>
				<td>
				<table>
					<tr>
						<td>Tgl Cetak</td>
						<td> : <input id="tglspm1" name="tglspm1" style="width: 120px;" /></td>
					</tr>
				</table>           
				</td>
			</tr> 
		</table>
	<table>
		<td>
			<table>
				<tr>
					<td>        
					<a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:openWindow('<?php echo site_url(); ?>/tukd_verif/cetak_sppls_barang_jasa_konsultasi');return false;">Cetak</a>					
					</td>
					<td>
					<a class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:keluar2();">Keluar</a>
					</td>
				</tr>                    
			</table>           
		</td>
	</table>
</div>
    
</body>

</html>