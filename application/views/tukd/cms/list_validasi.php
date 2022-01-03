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
    
	<style>    
    #tagih {
        position: relative;
        width: 500px;
        height: 70px;
        padding: 0.4em;
    }  
    </style>
    <script type="text/javascript">
    
     var  zno_upload = '';  
     var kodeval = ''; 
    
     $(document).ready(function() {
            $("#accordion").accordion();            
            $( "#dialog-modal" ).dialog({
                height: 450,
                width: 920,
                modal: true,
                autoOpen:false                
            });              
             
        });    
        
    $(function(){                
      $('#dg').edatagrid({
		rowStyler:function(index,row){        
        if ((row.status_validasix==1)){
		   return 'background-color:#B0E0E6';
        }        
		},
		url: '<?php echo base_url(); ?>/index.php/tukd_cms/load_listbelum_validasi',
        idField:'id',            
        rownumbers:"true", 
        fitColumns:"true",
        autoRowHeight:"false",
        loadMsg:"Tunggu Sebentar....!!",
        pagination:"true",
        columns:[[    	    
			{field:'no_voucher',
    		title:'No.',
    		width:7},
            {field:'tgl_voucher',
    		title:'TGL Trans.',
    		width:15},
            {field:'no_bukti',
    		title:'No.',
    		width:7},
            {field:'tgl_validasi',
    		title:'TGL Validasi',
    		width:15},
            {field:'kd_skpd',
    		title:'SKPD',
    		width:13,
            align:"center"},
            {field:'ket',
    		title:'Keterangan',
    		width:25,
            align:"left"},
			{field:'total',
    		title:'Nilai Pengeluaran',            
    		width:25,
            align:"right"},            
            {field:'no_upload',
    		title:'STT',
    		width:5,
            align:"center",hidden:true},
			{field:'status_upload',
    		title:'STT',
    		width:5,
            align:"center",hidden:true},            
			{field:'tgl_upload',
    		title:'STT',
    		width:5,
            align:"center",hidden:true},
			{field:'status_validasi',
    		title:'STT',
    		width:5,
            align:"center"},
            {field:'ck',
    		checkbox:'true'},
            {field:'rekening_awal',
    		title:'Rek Bend',
    		width:10,
            align:"left",hidden:true},
            {field:'nm_rekening_tujuan',
    		title:'Nama Rek',
    		width:10,
            align:"left",hidden:true},
            {field:'rekening_tujuan',
    		title:'Rek Tujuan',
    		width:10,
            align:"left",hidden:true},
            {field:'bank_tujuan',
    		title:'Bank Tujuan',
    		width:10,
            align:"left",hidden:true},
            {field:'ket_tujuan',
    		title:'Ket. Tujuan',
    		width:10,
            align:"left",hidden:true},
            {field:'status_pot',
    		title:'POT',
    		width:10,
            align:"left",hidden:true},
            {field:'bersih',
    		title:'Bersih',            
    		width:10,
            align:"right",hidden:true},
            {field:'jns_spp',
    		title:'JNS SPP',            
    		width:10,
            align:"left",hidden:true}
        ]],
        onSelect:function(rowIndex,rowData){                                                      
          skdvoucher    = rowData.no_voucher; 
          stglvoucher   = rowData.tgl_voucher;         
          skdskpd       = rowData.kd_skpd;
          stotal        = rowData.total;        
          //get(skdvoucher,stglvoucher,skdskpd,stotal);
          
          if(rowData.status_validasix==1){
            alert('sudah di validasi');
            bersih_list();
            exit();
          }          
          load_total_sub();
        },
        onDblClickRow:function(rowIndex,rowData){                                       
        }
    }); });
    
    $(function(){
    $('#dg2').edatagrid({
		idField:'id',            
        toolbar:'#toolbar',
            rownumbers:"true", 
            fitColumns:"true",            
            autoRowHeight:"false",
            singleSelect:"true",
            nowrap:"true",
            loadMsg:"Tunggu Sebentar....!!",                               
        columns:[[    	    
			{field:'no_voucher',
    		title:'No.',
    		width:8,hidden:true},
            {field:'tgl_voucher',
    		title:'TGL Trans.',
    		width:15,hidden:true},
            {field:'no_bku',
    		title:'No. BKU',
    		width:10},
            {field:'tgl_validasi',
    		title:'TGL BKU',
    		width:13},
            {field:'kd_skpd',
    		title:'SKPD',
    		width:13,
            align:"center"},
            {field:'ket',
    		title:'Keterangan',
    		width:60,
            align:"left"},
			{field:'total',
    		title:'Nilai Pengeluaran',            
    		width:20,
            align:"right"},            
            {field:'no_upload',
    		title:'STT',
    		width:5,
            align:"center",hidden:true},
			{field:'status_upload',
    		title:'STT',
    		width:5,
            align:"center",hidden:true},            
			{field:'tgl_upload',
    		title:'STT',
    		width:5,
            align:"center",hidden:true},
			{field:'status_validasi',
    		title:'STT',
    		width:5,
            align:"center",hidden:true},            
            {field:'rekening_awal',
    		title:'Rek Bend',
    		width:10,
            align:"left",hidden:true},
            {field:'nm_rekening_tujuan',
    		title:'Nama Rek',
    		width:10,
            align:"left",hidden:true},
            {field:'rekening_tujuan',
    		title:'Rek Tujuan',
    		width:10,
            align:"left",hidden:true},
            {field:'bank_tujuan',
    		title:'Bank Tujuan',
    		width:10,
            align:"left",hidden:true},
            {field:'ket_tujuan',
    		title:'Ket. Tujuan',
    		width:10,
            align:"left",hidden:true},
            {field:'status_pot',
    		title:'POT',
    		width:10,
            align:"left",hidden:true}                     
            ]],
        onSelect:function(rowIndex,rowData){                                                                       
        },
        onDblClickRow:function(rowIndex,rowData){                                       
        }
    }); 
    
    $('#skpd_val').combogrid({  
           panelWidth:700,  
           idField:'kd_skpd',  
           textField:'kd_skpd',  
           mode:'remote',
           url:'<?php echo base_url(); ?>index.php/tukd/skpd_2',  
           columns:[[  
               {field:'kd_skpd',title:'Kode SKPD',width:100},  
               {field:'nm_skpd',title:'Nama SKPD',width:700}    
           ]],  
           onSelect:function(rowIndex,rowData){
               kodeval = rowData.kd_skpd;               
               $("#nmskpd_val").attr("value",rowData.nm_skpd.toUpperCase());   
               load_sisa_bank(kodeval); 
               get_nourut(kodeval);     
               get_nourutbku(kodeval);        
                       
           }  
        });
    
    $(function(){
    $('#tglvoucher').datebox({  
            required:true,
            formatter :function(date){
            	var y = date.getFullYear();
            	var m = date.getMonth()+1;
            	var d = date.getDate();    
            	return y+'-'+m+'-'+d;
            }
        });
    });
    
    $(function(){    
    $('#tglvalidasi').datebox({  
            required:true,
            formatter :function(date){
            	var y = date.getFullYear();
            	var m = date.getMonth()+1;
            	var d = date.getDate();    
            	return y+'-'+m+'-'+d;
            }
        });
    });
    
    $(function(){    
    $('#tglvalidasi_trans').datebox({  
            required:true,
            formatter :function(date){
            	var y = date.getFullYear();
            	var m = date.getMonth()+1;
            	var d = date.getDate();    
            	return y+'-'+m+'-'+d;
            }
        });
    });
       
    });
        
    
function cari(){
    var kdskpd = $('#skpd_val').combogrid('getValue');
    var kriteria = $('#tglvoucher').datebox('getValue');
    
    if(kriteria=='' || kriteria==null){
        alert('Tanggal Transaksi Belum dipilih !');
        exit();
    }
    
        $(function(){ 
        $('#dg').edatagrid({
		    url: '<?php echo base_url(); ?>/index.php/tukd_cms/load_list_validasi',
            queryParams:({cari:kriteria,skpd:kdskpd})
            });        
        });
    }		
    
function get_nourut(kodeval)
        {
            var kodeval = kodeval;
        	$.ajax({
        		url:'<?php echo base_url(); ?>index.php/tukd_cms/no_urut_validasicms/'+kodeval,
        		type: "POST",
        		dataType:"json",                         
        		success:function(data){
        								$("#no_validasi").attr("value",data.no_urut);
        							  }                                     
        	});  
        }    

function get_nourutbku(kodeval)
        {
            var kodeval = kodeval;
        	$.ajax({
        		url:'<?php echo base_url(); ?>index.php/tukd_cms/no_urut_validasibku/'+kodeval,
        		type: "POST",
        		dataType:"json",                         
        		success:function(data){
        								$("#no_bku").attr("value",data.no_urut);
        							  }                                     
        	});  
        }    

    
function load_sisa_bank(kodeval){           
    var kodeval = kodeval;
        $(function(){      
         $.ajax({
            type: 'POST',
            url:"<?php echo base_url(); ?>index.php/tukd_cms/load_sisa_bank_cms_val/"+kodeval,
            dataType:"json",
            success:function(data){ 
                $.each(data, function(i,n){
                    $("#sisa_bank").attr("value",n['sisa']);                   
                });
            }
         });
        });
    }    
    
function bersih_list(){
    $('#dg').edatagrid('unselectAll');
    $("#total_trans").attr("value",number_format(0,2,'.',','));
    $('#dg').edatagrid('reload');
    var kodeval = $('#skpd_val').combogrid('getValue');
   
    load_sisa_bank(kodeval); 
    get_nourut(kodeval);     
    get_nourutbku(kodeval);
}    

function load_total_sub(){
    var hasil=0;
    var rows = $('#dg').datagrid('getSelections');     
		      for(var p=0;p<rows.length;p++){ 
		          
                  if(rows[p].jns_spp=='4' || rows[p].jns_spp=='6'){
                        hasil = hasil+angka(rows[p].bersih);
                    }else{
                        hasil = hasil+angka(rows[p].total);   
                    } 
                                                          
                   }
    $("#total_trans").attr("value",number_format(hasil,2,'.',','));                             
}
  
function proses_validasi_db(){
    var kodeval = $('#skpd_val').combogrid('getValue');
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1;
    var yyyy = today.getFullYear();
    if(dd<10){
    dd='0'+dd;
    } 
    if(mm<10){
        mm='0'+mm;
    } 
    
    var gt_tglvalidasi = $('#tglvalidasi_trans').datebox('getValue');
    
    if(gt_tglvalidasi==''){
        alert('Tanggal validasi belum dipilih !');
        exit();
    }
    
    //var harini = yyyy+'-'+mm+'-'+dd;
    var harini = gt_tglvalidasi;
             
     var tot_transval = 0;     
     
     var n_bku = angka(document.getElementById('no_bku').value);
     var n_validasi = angka(document.getElementById('no_validasi').value);
     
    var x = $('#dg').datagrid('getSelected');     
    if(x==null){
        alert('List Data belum dipilih');
        exit();
    }
     
     if(n_bku==''){alert('Refresh App'); exit();}
     if(n_validasi==''){alert('Refresh App'); exit();}
     if(n_validasi=='NaN'){alert('Refresh App'); exit();}
     
     var sis_bank = angka(document.getElementById('sisa_bank').value);
               
     var rows = $('#dg').datagrid('getSelections');                                        
            for(var p=0;p<rows.length;p++){			 
                    
                    if(rows[p].jns_spp=='4' || rows[p].jns_spp=='6'){
                        tot_transval   = tot_transval+ angka(rows[p].bersih);
                    }else{
                        tot_transval   = tot_transval+ angka(rows[p].total);    
                    } 
                
            }              
      
                         
     if(tot_transval > sis_bank){
        alert('Total Transaksi melebihi Saldo Bank');
        exit();
     }                            
                         
     var r = confirm("Apakah data yang akan di-Validasi sudah benar ?");
     if (r == true) {
     
        var dskpd = '';                            
        var csql = '';
        var p=0; var nomorbku=0;
        var i=0;
        var j=1;
            //$('#dg').edatagrid('selectAll');        
            var rows = $('#dg').datagrid('getSelections'); 
            for(var p=0;p<rows.length;p++){			                                              
                    nomorbku = n_bku+i;                     
                    if(rows[p].status_pot==1){                        
                        i=i+2; 
                    }else{
                        i=i+1;
                    }                                                                                                                                          
                    cno_voucher   = rows[p].no_voucher;
                    ctgl_voucher  = rows[p].tgl_voucher;
                    cno_upload    = rows[p].no_upload;
                    cstt_upload   = rows[p].status_upload;                 
                    cskpd         = rows[p].kd_skpd;
                    cket          = rows[p].ket;                    
                    ctotal        = angka(rows[p].total);                    
                    crekening_awal     = rows[p].rekening_awal;                   
                    cnm_rekening_tujuan  = rows[p].nm_rekening_tujuan;
                    crekening_tujuan   = rows[p].rekening_tujuan;
                    cbank_tujuan  = rows[p].bank_tujuan;
                    cket_tujuan   = rows[p].ket_tujuan;   
                    
                    //if(cskpd.substr(0,7)=='4.08.03'){
                    //    dskpd = cskpd.substr(0,7)+'.00';                        
                    //}else{
                        dskpd = cskpd;
                    //} 
                    
              
                if (p>0) {
                csql = csql+","+"('"+cno_voucher+"','"+ctgl_voucher+"','"+cno_upload+"','"+crekening_awal+"','"+cnm_rekening_tujuan+"','"+crekening_tujuan+"','"+cbank_tujuan+"','"+cket_tujuan+"','"+ctotal+"','"+cskpd+"','"+dskpd+"','"+cstt_upload+"','"+harini+"','1','"+n_validasi+"','"+nomorbku+"')";
                } else {
                csql = "values('"+cno_voucher+"','"+ctgl_voucher+"','"+cno_upload+"','"+crekening_awal+"','"+cnm_rekening_tujuan+"','"+crekening_tujuan+"','"+cbank_tujuan+"','"+cket_tujuan+"','"+ctotal+"','"+cskpd+"','"+dskpd+"','"+cstt_upload+"','"+harini+"','1','"+n_validasi+"','"+nomorbku+"')";                                            
                }                                                            
			}
            //alert(csql);            
            $(document).ready(function(){               
                $.ajax({
                    type: "POST",   
                    dataType : 'json',                 
                    data: ({tabel:'trvalidasi_cmsbank',no:n_validasi,sql:csql,skpd:dskpd}),
                    url: '<?php echo base_url(); ?>/index.php/tukd_cms/simpan_validasicms',
                    success:function(data){                        
                        status = data.pesan;   
                         if (status=='1'){               
                            alert('Data Berhasil diproses...!!!');		                 
                            bersih_list();                                                                  					
                        } else{ 
                            alert('Data Gagal diproses...!!!');
                        }                                             
                    }
                });
                });           
                                  
            } else {
                alert('Silahkan Cek lagi, Pastikan Data Sudah Benar...');
            }            
        }                 
        
        function batal_open(){
            var skpd = $('#skpd_val').combogrid('getValue');
            var tgl = $('#tglvoucher').datebox('getValue');              
            $('#tglvalidasi').datebox('setValue',tgl);              
            
        $(function(){ 
        $('#dg2').edatagrid({
		    url: '<?php echo base_url(); ?>/index.php/tukd_cms/load_list_telahvalidasi',
            queryParams:({cari:tgl,skpd:skpd})
            });        
        });             
            
        $("#dialog-modal").dialog('open');    
        }
        
        function batal_close(){
            var today = '';
            var skpd = $('#skpd_val').combogrid('getValue');
            
            $(function(){ 
            $('#dg').edatagrid({
		    url: '<?php echo base_url(); ?>/index.php/tukd_cms/load_list_validasi_close',
            queryParams:({cari:today,skpd:skpd})
            });        
            });
            
            $("#dialog-modal").dialog('close');
               
        }
        
        function proses_batal(){
            var kodeval = $('#skpd_val').combogrid('getValue');
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth()+1;
            var yyyy = today.getFullYear();
                if(dd<10){
                    dd='0'+dd;
                } 
                if(mm<10){
                    mm='0'+mm;
                } 
            var today = yyyy+'-'+mm+'-'+dd;
            var paramtoday = $('#tglvalidasi').datebox('getValue');  
            
            var x = $('#dg2').datagrid('getSelected');     
            if(x==null){
                alert('List Data belum dipilih');
                exit();
            }
            
            var r = confirm("Apakah data yang akan di-Batalkan sudah benar ?");
            if (r == true) {
                 
            //if(today==paramtoday){
            
            var rows = $('#dg2').datagrid('getSelections'); 
            for(var p=0;p<rows.length;p++){			                                              
                    hno_voucher = rows[p].no_voucher;
                    htgl_valid  = rows[p].tgl_validasi;
                    hno_bukti   = rows[p].no_bku;
                    cskpd       = rows[p].kd_skpd;                     
            }
            
            $(document).ready(function(){               
                $.ajax({
                    type: "POST",   
                    dataType : 'json',                 
                    data: ({tabel:'trvalidasi_cmsbank',nobukti:hno_bukti,novoucher:hno_voucher,skpd:cskpd,tglvalid:htgl_valid}),
                    url: '<?php echo base_url(); ?>/index.php/tukd_cms/batal_validasicms',
                    success:function(data){                        
                        status = data.pesan;   
                         if (status=='1'){               
                            alert('Data Berhasil diproses...!!!');		
                            load_sisa_bank(kodeval); 
                            get_nourut(kodeval);     
                            get_nourutbku(kodeval);                 
                            batal_close();                                                                  					
                        } else{ 
                            alert('Data Gagal diproses...!!!');
                        }                                             
                    }
                });
                }); 
            
             
            
            /*}else{
                alert('Tanggal harus hari ini...');
                exit();
            }*/
            }else{
                alert('Silahkan cek Kembali...');
                exit();
            }
        }
    </script>

</head>
<body>

<div id="content">    
<div id="accordion">
<h3><a href="#" id="section1" >VALIDASI - DAFTAR TRANSAKSI NON TUNAI</a></h3>
    <div>
    <p align="center">         
    <table width="100%">
        <tr>
            <td><label><b><i>No Bukti</i></b></label> : 
            <input name="no_bku" type="text" id="no_bku" style="width:60px; border: 0;" readonly="true"/>  &nbsp; <label><b><i>No Validasi</i></b></label> :         
            <input name="no_validasi" type="text" id="no_validasi" style="width:60px; border: 0;"/>
            </td>
            <td>
            SKPD <input name="skpd_val" type="text" id="skpd_val" style="width:90px; border: 0;"/>
            <input name="nmskpd_valskpd_val" type="text" id="nmskpd_val" style="width:400px; border: 0;"/>
            </td>
        </tr>  
        <tr>
            <td><label><b>Tanggal</b></label> : 
            <input name="tglvoucher" type="text" id="tglvoucher" style="width:100px; border: 0;"/>            
            &nbsp; 
            <a class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="javascript:cari();">Cari</a>
            </td>
            <td align="right"><label><b>Aksi</b></label>:            
            <a class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:bersih_list();">Bersihkan List</a> &nbsp;
            <b>Tanggal</b> <input name="tglvalidasi_trans" type="text" id="tglvalidasi_trans" style="width:100px; border: 0;"/>
            <a class="easyui-linkbutton" iconCls="icon-ok" plain="true" onclick="javascript:proses_validasi_db();">Proses Validasi</a>  &nbsp;                                   
            <a class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:batal_open();">Batal</a> &nbsp;            
            </td>
        </tr>        
        </table>
        <table id="dg" title="List Data Transaksi" style="width:860px;height:390px;"  >  
        </table>
        <table width="100%" style="text-align: right;">
            <tr>
            <td><label><b>Total Transaksi</b></label> : 
            <input name="total_trans" type="text" id="total_trans" style="text-align:right; width:200px; border: 0;" readonly="true"/>            
            </td>
            </tr>
            <tr>
            <td><label><b>Sisa Saldo Bank</b></label> : 
            <input name="sisa_bank" type="text" id="sisa_bank" style="text-align:right; width:200px; border: 0;" readonly="true"/>            
            </td>
            </tr>        
        </table>
        <font><b>Note : Warna Putih belum divalidasi</b></font><br />
        <font color="blue"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        Warna Biru sudah divalidasi</b></font>
    </p> 
    </div>      
</div>
</div>

<div id="dialog-modal" title="List Data Validasi">
    <fieldset>
        <p>Tanggal Validasi : <input name="tglvalidasi" type="text" id="tglvalidasi" style="width:100px; border: 0;"/> </p>
        <table id="dg2" title="Data Transaksi - Telah Validasi" style="width:870px;height:280px;"  >  
        </table>
        <table width="100%" >
            <tr style="text-align: center;">
            <td>
            <a class="easyui-linkbutton" iconCls="icon-back" plain="true" onclick="javascript:batal_close();">Kembali</a> &nbsp;&nbsp;
            <a class="easyui-linkbutton" id="proses" iconCls="icon-add" plain="true" onclick="javascript:proses_batal();">Proses Batal</a> &nbsp;&nbsp;
            </td>
            </tr>
        </table>           
    </fieldset>  
</div>


</body>

</html>