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
                    
     $(document).ready(function() {
            $("#accordion").accordion();            
            $( "#dialog-modal" ).dialog({
            height: 565,
            width: 750,
            modal: true,
            autoOpen:false,
        });
        });    
     
  
        $(function(){
   	     $('#tgl_con').datebox({  
            required:true,
            formatter :function(date){
            	var y = date.getFullYear();
            	var m = date.getMonth()+1;
            	var d = date.getDate();
				return y+'-'+(m<10?('0'+m):m)+'-'+(d<10?('0'+d):d);
            	//return y+'-'+m+'-'+d;
            }
        });
        
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
        
        
        $('#tglspm2').datebox({  
            required:true,
            formatter :function(date){
            	var y = date.getFullYear();
            	var m = date.getMonth()+1;
            	var d = date.getDate();
				return y+'-'+(m<10?('0'+m):m)+'-'+(d<10?('0'+d):d);
            	//return y+'-'+m+'-'+d;
            }
        });
        
   	});
	
    $(function(){ 
     $('#dg').edatagrid({
		url: '<?php echo base_url(); ?>/index.php/tukd/load_validasi_spm',
        idField:'id',            
        rownumbers:"true", 
        fitColumns:"true",
        singleSelect:"true",
        autoRowHeight:"false",
        loadMsg:"Tunggu Sebentar....!!",
        nowrap:"true",                       
        columns:[[
    	    {field:'nm_skpd',
    		title:'SKPD',
    		width:50,
            align:"left"},
            {field:'no_spm',
            title:'no. SPM',
            width:30,
            align:"center"},
            {field:'sttval',
            title:'Status',
            width:20,
            align:"center"}
            

        ]],
        onSelect:function(rowIndex,rowData){
                    kd_skpdedit= rowData.kd_skpd;
                    nm_skpdedit= rowData.nm_skpd;
                    no_spmedit = rowData.no_spm;
                    no_sppedit = rowData.no_spp;
                    nmrekanedit = rowData.nmrekan;
                    pimpinanedit = rowData.pimpinan;
                    no_rekedit = rowData.no_rek;
                    npwpedit = rowData.npwp;
                    bankedit = rowData.bank;
                    keperluanedit = rowData.keperluan;
                    no_tagihedit = rowData.no_tagih;
                    ketedit = rowData.ket;
                    ket_bastedit = rowData.ket_bast;
                    
                    tgl_terima = rowData.tgl_terima;
                    tgl_setuju = rowData.tgl_setuju;
                    ket_val = rowData.ket_val;
                    stt_validasi = rowData.stt_validasi;
                    
                    getedit(kd_skpdedit,nm_skpdedit,no_spmedit,no_sppedit,pimpinanedit,no_rekedit,npwpedit,bankedit,keperluanedit,nmrekanedit,no_tagihedit,ketedit,ket_bastedit,tgl_terima,tgl_setuju,ket_val,stt_validasi)
            
                                       
        },
        onDblClickRow:function(rowIndex,rowData){

           lcidx = rowIndex;
           judul = 'Edit Data ANGGARAN'; 
           edit_data();   
        }
        
        });
            

        $('#bankedit').combogrid({  
        panelWidth:250,  
        url: '<?php echo base_url(); ?>/index.php/tukd/config_bank2',  
        idField:'kd_bank',  
        textField:'nama_bank',
        mode:'remote',  
        fitColumns:true,  
            columns:[[  
                {field:'kd_bank',title:'Kd Bank',width:70},  
                {field:'nama_bank',title:'Nama',width:180}
                ]],  
            onSelect:function(rowIndex,rowData){
//$("#nama_bank").attr("value",rowData.nama_bank);
                    }   
            });   
        });

       
 
	function getedit(kd_skpdedit,nm_skpdedit,no_spmedit,no_sppedit,pimpinanedit,no_rekedit,npwpedit,bankedit,keperluanedit,nmrekanedit,no_tagihedit,ketedit,ket_bastedit,tgl_terima,tgl_setuju,ket_val,stt_validasi){
            kosongkan(); 
            $("#kdskpdedit").attr("Value",kd_skpdedit);
            $("#nmskpdedit").attr("Value",nm_skpdedit);
            $("#spmedit").attr("value",no_spmedit);
            $("#sppedit").attr("value",no_sppedit);
            $("#norekedit").attr("value",no_rekedit);
            $("#pimpinanedit").attr("value",pimpinanedit);
            $("#npwpedit").attr("value",npwpedit);
            $("#rekanedit").attr("value",nmrekanedit);
            $("#keperluanedit").attr("value",keperluanedit);  
            $("#bankedit").combogrid("setValue",bankedit);
            $("#no_tagihedit").attr("value",no_tagihedit);
            $("#ketedit").attr("value",ketedit); 
            $("#ket_bastedit").attr("value",ket_bastedit);   
            
            $("#tglspm1").datebox("setValue",tgl_terima);
            $("#tglspm2").datebox("setValue",tgl_setuju);
            $("#ketspm").attr("value",ket_val); 
            $("#sttspm").attr("value",stt_validasi);   
            
                               
        } 
    
    function cek_skpd(init){
        var init_sp2d = init;
        $(function(){
            $('#sskpd').combogrid({  
            panelWidth:700,  
            idField:'kd_skpd',  
            textField:'kd_skpd',  
            mode:'remote',
            url:'<?php echo base_url(); ?>index.php/tukd/skpd_sp2d_2/'+init_sp2d,  
            columns:[[  
                {field:'kd_skpd',title:'Kode SKPD',width:100},  
                {field:'nm_skpd',title:'Nama SKPD',width:700}    
            ]],
            onSelect:function(rowIndex,rowData){
                xskpd = rowData.kd_skpd;
                $("#nmskpd").attr("value",rowData.nm_skpd);
                validate_jenis();                
            }
            });
            });
    }

    function kosongkan(){
            $("#kdskpdedit").attr("Value",'');
            $("#nmskpdedit").attr("Value",'');
            $("#spmedit").attr("value",'');
            $("#sppedit").attr("value",'');
            $("#norekedit").attr("value",'');
            $("#pimpinanedit").attr("value",'');
            $("#npwpedit").attr("value",'');
            $("#rekanedit").attr("value",'');
            $("#keperluanedit").attr("value",'');  
            $("#bankedit").combogrid("setValue",'');
            $("#no_tagihedit").attr("value",'');
            $("#ketedit").attr("value",''); 
            $("#ket_bastedit").attr("value",''); 
    }
	
    
      function edit_data(){
        lcstatus = 'edit';
        judul = 'Terima SPP & SPM !';
        $("#dialog-modal").dialog({ title: judul });
        $("#dialog-modal").dialog('open');
        document.getElementById("no").disabled=true;
        }    
        
    
    function jenis_sp2d(){
        var jns_ang = document.getElementById('jns_anggaran').value;
        cek_skpd(jns_ang);        
     }

     function validate_jenis(){
        var jns_ang = document.getElementById('jns_anggaran').value;
        var sskpd = xskpd;
        var krit = '';


        $(function(){ 
                $('#dg').edatagrid({
                  url: '<?php echo base_url(); ?>/index.php/tukd/load_validasi_spm/'+sskpd+'/'+jns_ang,
                  queryParams:({kriteria_init:krit})
                });        
               });
     }


      

        function perbaiki_data(){
        var kdskpd = document.getElementById('kdskpdedit').value;
        var spmedit = document.getElementById('spmedit').value;
        var tglterima = $('#tglspm1').datebox('getValue');
        var tglsetuju = $('#tglspm2').datebox('getValue');
        var ketspm  = document.getElementById('ketspm').value; 
        var statusspm = document.getElementById('sttspm').value;
        
        if(tglterima==''){
            alert('Tanggal Terima SPM belum dipilih');
            exit();
        }
        
        if(ketspm==''){
            alert('Keterangan SPM belum diisi');
            exit();
        }
        
        if(statusspm=='0'){
            alert('Status SPM belum dipilih');
            exit();
        }
        
       
     
     
        $(function(){      
         $.ajax({
            type: 'POST',
            data: ({kdskpd:kdskpd,spmedit:spmedit,tglterima:tglterima,tglsetuju:tglsetuju,ketspm:ketspm,statusspm:statusspm}),
            dataType:"json",
            url:"<?php echo base_url(); ?>index.php/tukd/simpan_validasi_spm",
            success:function(asg3){
                if (asg3==2){                               
                    alert('Data Gagal Tersimpan');
                    document.getElementById('spmedit').value=asg3;                  
                }else{                  
                    document.getElementById('spmedit').value=asg3;
                    alert('Data Berhasil Tersimpan');
                   keluar2();
                   validate_jenis();
                }
            }
         });
        });        
        }
        

        function keluar2(){
        $("#dialog-modal").dialog('close');
    }     
    
    function openWindow(url) {
        var kode = document.getElementById('spmedit').value;
        var no =kode.split("/").join("123456789");
        window.open(url+'/'+no+'/PERKIRAAN SP2D', '_blank');
        window.focus();
    }
    
     function cek2($cetak,$jxx){
        
        urlx='';
        //alert($jxx);
        if($jxx<=1){
        urlx="<?php echo site_url(); ?>/tukd/preview_cetakan_val_spm/"+$cetak+'/Report-val'
        }else{
            //alert('x');
        urlx="<?php echo site_url(); ?>/tukd/preview_cetakan_val_sp2d/"+$cetak+'/Report-SP2D'    
        }
        openWindows( urlx );
    }
        
        
        function openWindows( urlx ){
        
            lc = '';
      window.open(urlx+lc,'_blank');
      window.focus();
      
     }  
  
   </script>

</head>
<body>

<div id="content"> 
<div id="accordion">
<h3 align="center"><u><b><a href="#" id="section1">VALIDASI TERIMA SPP & SPM</a></b></u></h3>
    <div>
    <p align="left" >
        <a>&nbsp;&ensp;*) Pilih SKPD dan Jenis Beban terlebih Dahulu !</a>   
    </p>
    <table>    
    <tr>
        <td>Pilih Jenis Beban</td>
        <td>:</td>
        <td>    
            <select name="jns_anggaran" id="jns_anggaran" onchange="javascript:jenis_sp2d();" style="height: 27px; width:160px;">    
            <option value="0">...Pilih Jenis... </option>   
            <option value="1">UP</option>
            <option value="2">GU</option>
            <option value="3">TU</option>
            <option value="4">LS Gaji</option>
            <option value="5">LS PPKD</option>
            <option value="6">LS Barang Jasa</option>
            </select>
        </td>
    </tr>
    <tr>
        <td >S K P D&nbsp;&nbsp;&nbsp;&nbsp;&ensp;&nbsp;&ensp;&nbsp;&ensp;&nbsp;&nbsp;&nbsp;</td>
        <td>:&nbsp;</td>
        <td>&nbsp;<input id="sskpd" name="sskpd" style="width:160px;border: 0;" />
        <input id="nmskpd" name="nmskpd" readonly="true" style="width: 500px; border:0;  " /></td>
    </tr>

        <tr>
           <td width="10%">Cetak List Antrian SPM</td>
           <td width="1%">:</td>
           <td width="40%"> 
                    <a class="easyui-linkbutton" plain="true" onclick="javascript:cek2(0,'1');return false" >
                    <img src="<?php echo base_url(); ?>assets/images/icon/print.png" width="25" height="23" title="preview"/></a>
                    <a class="easyui-linkbutton" plain="true" onclick="javascript:cek2(1,'1');return false">                    
                    <img src="<?php echo base_url(); ?>assets/images/icon/print_pdf.png" width="25" height="23" title="cetak"/></a>
                    <a class="easyui-linkbutton" plain="true" onclick="javascript:cek2(2,'1');return false">                    
                    <img src="<?php echo base_url(); ?>assets/images/icon/excel.jpg" width="25" height="23" title="cetak"/></a>
           </td>    
        </tr>
        <tr>
           <td width="10%">Cetak List SP2D</td>
           <td width="1%">:</td>
           <td width="40%"> 
                    <a class="easyui-linkbutton" plain="true" onclick="javascript:cek2(0,'2');return false" >
                    <img src="<?php echo base_url(); ?>assets/images/icon/print.png" width="25" height="23" title="preview"/></a>
                    <a class="easyui-linkbutton" plain="true" onclick="javascript:cek2(1,'2');return false">                    
                    <img src="<?php echo base_url(); ?>assets/images/icon/print_pdf.png" width="25" height="23" title="cetak"/></a>
                    <a class="easyui-linkbutton" plain="true" onclick="javascript:cek2(2,'2');return false">                    
                    <img src="<?php echo base_url(); ?>assets/images/icon/excel.jpg" width="25" height="23" title="cetak"/></a>
           </td>    
        </tr>
    </table>
        


        <!--<a class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:tambah()">Tambah</a>               
        <a class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:hapus();">Hapus</a>
        <a class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="javascript:cari();">Cari</a>
        <input type="text" value="" id="txtcari"/>-->
        <table id="dg" title="LIST SPM YANG BELUM DI SP2D-KAN" style="width:870px;height:450px;" >  
        </table>
 
     
    </div>   

</div>

</div>


<div id="dialog-modal" title="">
    <fieldset>
     <table align="center" style="width:100%;" border="0">
            <tr>
            <td width="110px">Kode SKPD</td>
            <td>:<input id="kdskpdedit" name="kdskpdedit" style="width: 100px;" readonly="true"/><input id="nmskpdedit" name="nmskpdedit" style="width: 400px;"readonly="true" /></td>
        </tr>
        <tr>
            <td width="110px">NO Tagih</td>
            <td>:<input id="no_tagihedit" name="no_tagihedit" style="width: 220px;" readonly="true"/></td>
        </tr>
        <tr>
            <td width="110px">NO SPM</td>
            <td>:<input id="spmedit" name="spmedit" style="width: 220px;" readonly="true"/></td>
        </tr>
        <tr>
            <td width="110px">NO SPP</td>
            <td>:<input id="sppedit" name="sppedit" style="width: 220px;" readonly="true"/></td>
        </tr>
         <tr>
            <td width="110px">Rekanan</td>
            <td>:<input id="rekanedit" name="rekanedit" style="width: 400px;" /></td>
        </tr>
       <tr>
            <td width="110px">Pimpinan</td>
            <td>:<input id="pimpinanedit" name="pimpinanedit" style="width: 220px;" /></td>
        </tr>
        <tr>
            <td width="110px">no rek</td>
            <td>:<input id="norekedit" name="norekedit" style="width: 220px;"/></td>
        </tr>
        <tr>
            <td width="110px">NPWP</td>
            <td>:<input id="npwpedit" name="npwpedit" style="width: 220px;"/>
        Bank
            :<input id="bankedit" name="bankedit" style="width: 130px;" />
        </td>
    </tr>
            <td width="110px">Keperluan</td>
            <td><textarea name="keperluanedit" id="keperluanedit" rows="2" style="width: 500px;"></textarea></td>
        </tr>
        <tr>
            <td width="110px">Ket. BAST</td>
            <td><textarea name="ket_bastedit" id="ket_bastedit" rows="2" style="width: 500px;"></textarea></td>
        </tr>
        
        </table>


        <table bgcolor="#AABBBB" width="92%">
        <tr>
        <td colspan="2" align="center">
        <a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:openWindow('<?php echo site_url(); ?>/tukd/cetak_perkiraan_sp2d');return false;">Cetak Perkiraan SP2D</a>         
        <a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:openWindow('<?php echo site_url(); ?>/tukd/cetak_lamp_perkiraan_sp2d');return false;">Cetak Lampiran Perkiraan SP2D</a></td>                 
        </tr>        
        <tr>        
        <td>Kontrol SPM :</td>
        <td>
                <table>
                    <tr>
                        <td>Tanggal Terima</td>
                        <td>: <input id="tglspm1" name="tglspm1" style="width: 100px;" /></td>
                        <td rowspan="2"><textarea placeholder="Keterangan Kontrol SPM" name="ketspm" id="ketspm" rows="3" style="width: 300px;"></textarea></td>
                    </tr>
                    <tr>
                        <td>Tanggal Disetujui</td>
                        <td>: <input id="tglspm2" name="tglspm2" style="width: 100px;" /></td>                        
                    </tr>
                </table>           
              </td>        
        </tr> 
        <tr>        
        <td>Status&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</td>
        <td>
                <table>
                    <tr>
                        <td><select id="sttspm" name="sttspm" style="width: 250px;">
                                <option value="0">...STATUS SPM...</option>                                
                                <option value="1">BERKAS LENGKAP DAN DISETUJUI</option>
                                <option value="2">BERKAS SPP SPM DITUNDA</option>
                                <option value="3">BERKAS SPP SPM DIBATALKAN</option>
                            </select> 
                        </td>
                        <td>
                        &nbsp;<a class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:perbaiki_data();">Simpan Terima SPM</a>
                        &nbsp;<a class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:keluar2();">Keluar</a>
                    </td>
                    </tr>                    
                </table>           
              </td>        
        </tr>            
        <tr>
        </tr>
        </table>
  </fieldset>
</div>

  	
</body>

</html>