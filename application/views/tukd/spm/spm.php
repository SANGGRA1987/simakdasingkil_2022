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
    
    var nl           = 0;
	var tnl          = 0;
	var idx          = 0;
	var tidx         = 0;
	var oldRek       = 0;
    var rek          = 0;
    var lcstatus     = '';
    var jumlah_pajak = 0;
    var pidx         = 0;
    
    $(function(){

      $(document).ready(function() {
        $("#dialog-batal").dialog({
        height: 300,
        width: 700,
        modal: true,
        autoOpen:false
        });
   /* get_skpd2();
        seting_tombol();*/
    });
   	    

        $('#dd').datebox({  
            required:true,
            formatter :function(date){
            	var y = date.getFullYear();
            	var m = date.getMonth()+1;
            	var d = date.getDate();
				return y+'-'+(m<10?('0'+m):m)+'-'+(d<10?('0'+d):d);
				},
			onSelect: function(date){
				
            $("#kebutuhan_bulan").attr("Value",(date.getMonth()+1));
            }
        });
        


        $('#cspm').combogrid({  
                panelWidth:500,  
                url: '<?php echo base_url(); ?>/index.php/xtukd_ppkd/pilih_spm',  
                    idField    : 'no_spm',                    
                    textField  : 'no_spm',
                    mode       : 'remote',  
                    fitColumns : true,  
                    columns:[[  
                        {field:'no_spm',title:'SPM',width:60},  
                        {field:'kd_skpd',title:'SKPD',align:'left',width:60},
                        {field:'no_spp',title:'SPP',width:60} 
                    ]],
                    onSelect:function(rowIndex,rowData){
                    kode = rowData.no_spm;
                    skpd = rowData.kd_skpd;
                    //val_ttd(skpd);
                    }   
                });

        
                
        $('#bank1').combogrid({  
                panelWidth:200,  
                url: '<?php echo base_url(); ?>/index.php/xtukd_ppkd/config_bank2',  
                    idField:'kd_bank',  
                    textField:'kd_bank',
                    mode:'remote',  
                    fitColumns:true,  
                    columns:[[  
                           {field:'kd_bank',title:'Kd Bank',width:40},  
                           {field:'nama_bank',title:'Nama',width:140}
                       ]],  
                    onSelect:function(rowIndex,rowData){
                    //$("#kode").attr("value",rowData.kode);
                    $("#nama_bank").attr("value",rowData.nama_bank);
                    }   
                });
				
/* 		$('#cc').combobox({
					url:'<?php echo base_url(); ?>/index.php/xtukd_ppkd/load_jenis_beban',
					valueField:'id',
					textField:'text',
					onSelect:function(rowIndex,rowData){
					validate_tombol();
                    }
				}); */

        $('#spm').edatagrid({
        		url: '<?php echo base_url(); ?>/index.php/xtukd_ppkd/load_spm',
                idField       : 'id',            
                rownumbers    : "true", 
                fitColumns    : "true",
                singleSelect  : "true",
                autoRowHeight : "false",
                loadMsg       : "Tunggu Sebentar....!!",
                pagination    : "true",
                nowrap        : "true",                       
                columns:[[
            	    {field:'no_spm',
            		title:'Nomor SPM',
            		width:70},
                    {field:'tgl_spm',
            		title:'Tanggal',
            		width:30},
                    {field:'kd_skpd',
            		title:' SKPD',
            		width:30,
                    align:"left"},
                    {field:'keperluan',
            		title:'Keterangan',
            		width:140,
                    align:"left"}
                ]],
                onSelect:function(rowIndex,rowData){
                  urut   = rowData.urut;
                  no_spm   = rowData.no_spm;
                  no_spp   = rowData.no_spp;
                  skpd     = rowData.kd_skpd;         
                  tgs      = rowData.tgl_spm;
                  st       =  rowData.status;
                  jns      = rowData.jns_spp;
                  jns_bbn  = rowData.jns_beban;
                  nospd    = rowData.no_spd;
                  tgspp    = rowData.tgl_spp;
                  cnpwp    = rowData.npwp;
                  nbl      = rowData.bulan;
                  ckep     = rowData.keperluan;
                  bank     = rowData.bank;
                  crekan   = rowData.nmrekan;
                  cnorek   = rowData.no_rek;
                  cnmskpd  = rowData.nm_skpd;
                  csp2d_batal  = rowData.sp2d_batal;
                  cket_batal  = rowData.ket_batal;
                  getspm(urut,no_spm,no_spp,tgs,st,jns,skpd,nospd,tgspp,cnpwp,nbl,ckep,bank,crekan,cnorek,cnmskpd,jns_bbn,csp2d_batal,cket_batal);  
                  detail();
                  lcstatus = 'edit';   
                },
                onDblClickRow:function(rowIndex,rowData,st){
                    section2();   
                }
            });
            
            
            
            $('#nospp').combogrid({  
                panelWidth : 500,  
                url        : '<?php echo base_url(); ?>/index.php/xtukd_ppkd/nospp_2',  
                idField    : 'no_spp',                    
                textField  : 'no_spp',
                mode       : 'remote',  
                fitColumns : true,  
                columns:[[  
                        {field:'no_spp',title:'No',width:60},  
                        {field:'kd_skpd',title:'SKPD',align:'left',width:80} 
                    ]],
                     onSelect:function(rowIndex,rowData){
                        no_spp = rowData.no_spp;         
                        skpd   = rowData.kd_skpd;
                        sp     = rowData.no_spd;          
                        bl     = rowData.bulan;
                        tg     = rowData.tgl_spp;
                        jns    = rowData.jns_spp;
                        jns_bbn= rowData.jns_beban;
                        kep    = rowData.keperluan;
                        np     = rowData.npwp;
                        rekan  = rowData.nmrekan;
                        bk     = rowData.bank;
                        ning   = rowData.no_rek;
                        nm     = rowData.nm_skpd;        
                        get(no_spp,skpd,sp,tg,bl,jns,kep,np,rekan,bk,ning,nm,jns_bbn);
                        detail();
						
                    }  
                });
                
                
                $('#dg').edatagrid({
                    url           : '<?php echo base_url(); ?>/index.php/xtukd_ppkd/select_data1',
                    autoRowHeight : "true",
                    idField       : 'id',
                    toolbar       : "#toolbar",              
                    rownumbers    : "true", 
                    fitColumns    : false,
                    singleSelect  : "true"
                    });
            
                
                $('#rekpajak').combogrid({  
                   panelWidth : 700,  
                   idField    : 'kd_rek5',  
                   textField  : 'kd_rek5',  
                   mode       : 'remote',
                   url        : '<?php echo base_url(); ?>index.php/xtukd_ppkd/rek_pot',  
                   columns:[[  
                       {field:'kd_rek5',title:'Kode Rekening',width:100},  
                       {field:'nm_rek5',title:'Nama Rekening',width:700}    
                   ]],  
                   onSelect:function(rowIndex,rowData){
                       $("#nmrekpajak").attr("value",rowData.nm_rek5);
                   }  
                   });
                   
                   
    			$('#dgpajak').edatagrid({
    			     url            : '<?php echo base_url(); ?>/index.php/xtukd_ppkd/pot',
                     idField        : 'id',
                     toolbar        : "#toolbar",              
                     rownumbers     : "true", 
                     fitColumns     : false,
                     autoRowHeight  : "true",
                     singleSelect   : false,
                     columns:[[
                        {field:'id',title:'id',width:100,align:'left',hidden:'true'}, 
                        {field:'kd_trans',title:'Rek. Trans',width:100,align:'left'},			
                        {field:'kd_rek5',title:'Rekening',width:100,align:'left'},			
    					{field:'nm_rek5',title:'Nama Rekening',width:317},
    					{field:'nilai',title:'Nilai',width:100,align:"right"},
                        {field:'hapus',title:'Hapus',width:100,align:"center",
                        formatter:function(value,rec){ 
                        return '<img src="<?php echo base_url(); ?>/assets/images/icon/edit_remove.png" onclick="javascript:hapus_detail();" />';
                        }
                        }
        			]]	
        			});
					
				$('#ttd1').combogrid({  
					panelWidth:600,  
					idField:'nip',  
					textField:'nip',  
					mode:'remote',
					url:'<?php echo base_url(); ?>index.php/xtukd_ppkd/load_ttd/BK',  
					columns:[[  
						{field:'nip',title:'NIP',width:200},  
						{field:'nama',title:'Nama',width:400}    
					]],
                    onSelect:function(rowIndex,rowData){
                    $("#nmttd1").attr("value",rowData.nama);
                    }  
				});          
        
				$('#ttd2').combogrid({  
					panelWidth:600,  
					idField:'nip',  
					textField:'nip',  
					mode:'remote',
					url:'<?php echo base_url(); ?>index.php/xtukd_ppkd/load_ttd/PPK',  
					columns:[[  
						{field:'nip',title:'NIP',width:200},  
						{field:'nama',title:'Nama',width:400}    
					]],
                    onSelect:function(rowIndex,rowData){
                    $("#nmttd2").attr("value",rowData.nama);
                    }  
				});
				
				$('#ttd3').combogrid({  
					panelWidth:600,  
					idField:'nip',  
					textField:'nip',  
					mode:'remote',
					url:'<?php echo base_url(); ?>index.php/xtukd_ppkd/load_ttd/PA',  
					columns:[[  
						{field:'nip',title:'NIP',width:200},  
						{field:'nama',title:'Nama',width:400}    
					]],
                    onSelect:function(rowIndex,rowData){
                    $("#nmttd3").attr("value",rowData.nama);
                    }  
				});
				
				$('#ttd4').combogrid({  
					panelWidth:600,  
					idField:'nip',  
					textField:'nip',  
					mode:'remote',
					url:'<?php echo base_url(); ?>index.php/xtukd_ppkd/load_ttd/PPKD',  
					columns:[[  
						{field:'nip',title:'NIP',width:200},  
						{field:'nama',title:'Nama',width:400}    
					]],
                    onSelect:function(rowIndex,rowData){
                    $("#nmttd4").attr("value",rowData.nama);
                    }  
				});	
					
					
				
					
					
					
   	    });

           
       
        
        function detail(){
        $(function(){
			$('#dg').edatagrid({
				url: '<?php echo base_url(); ?>/index.php/xtukd_ppkd/select_data1',
                queryParams:({spp:no_spp}),
                 idField:'idx',
                 toolbar:"#toolbar",              
                 rownumbers:"true", 
                 fitColumns:false,
                 autoRowHeight:"true",
                 singleSelect:false,
                 onLoadSuccess:function(data){                      
                      load_sum_spm();
                      },                                  			 				 
                 columns:[[
	                {field:'ck',
					 title:'ck',
					 checkbox:true,
					 hidden:true},                     
                     {field:'kdkegiatan',
					 title:'Kegiatan',
					 width:150,
					 align:'left'
					},
					{field:'kdrek5',
					 title:'Rekening',
					 width:70,
					 align:'left'
					},
					{field:'nmrek5',
					 title:'Nama Rekening',
					 width:350					 
					},                    
                    {field:'nilai1',
					 title:'Nilai',
					 width:170,
                     align:'right'
                     }
				]]	
			});
		});
        }
        
        
        
        function detail1(){
        $(function(){
            var no_spp='';
			$('#dg').edatagrid({
				url: '<?php echo base_url(); ?>/index.php/xtukd_ppkd/select_data1',
                queryParams:({spp:no_spp}),
                 idField:'idx',
                 toolbar:"#toolbar",              
                 rownumbers:"true", 
                 fitColumns:false,
                 autoRowHeight:"true",
                 singleSelect:false,                          			 				 
                 columns:[[
	                {field:'ck',
					 title:'ck',
					 checkbox:true,
					 hidden:true},                     
                     {field:'kdkegiatan',
					 title:'Kegiatan',
					 width:150,
					 align:'left'
					},
					{field:'kdrek5',
					 title:'Rekening',
					 width:70,
					 align:'left'
					},
					{field:'nmrek5',
					 title:'Nama Rekening',
					 width:400					 
					},                    
                    {field:'nilai1',
					 title:'Nilai',
					 width:100,
                     align:'right'
                     }
				]]	
			});
		});
        }
              

        function get(no_spp,kd_skpd,no_spd,tgl_spp,bulan,jns_spp,keperluan,npwp,rekanan,bank,rekening,nm_skpd,jns_bbn){
            $("#nospp").attr("value",no_spp);
    		$("#nospp1").attr("value",no_spp);
            $("#dn").attr("value",kd_skpd);
            $("#tgl_spp").attr("value",tgl_spp);
            $("#sp").attr("value",no_spd);
            $("#kebutuhan_bulan").attr("Value",bulan);
            $("#ketentuan").attr("Value",keperluan);
            $("#jns_beban").attr("Value",jns_spp);
            $("#npwp").attr("Value",npwp);
            $("#rekanan").attr("Value",rekanan);
             $("#bank1").combogrid("setValue",bank);
            $("#rekening").attr("Value",rekening);
            $("#nmskpd").attr("Value",nm_skpd);
			//validate_jenis_edit(jns_bbn);
			validate_rek_trans(no_spp);
			$("#bank1").combogrid('disable');

        }
                  
        
        function getspm(urut,no_spm,no_spp,tgl_spm,status,jns_spp,kd_skpd,nospd,tgspp,npwp,bulan,keperluan,bank,rekanan,rekening,nm_skpd,jns_bbn,sp2d_batal,ket_batal){
            $("#no_spm").attr("value",no_spm);
            $("#no_spm_hide").attr("value",no_spm);
            $("#nospp").combogrid("setValue",no_spp);
            $("#dd").datebox("setValue",tgl_spm);
            $("#dd_spm").attr("value",urut);
            $("#jns_beban").attr("Value",jns_spp);
            $("#dn").attr("Value",kd_skpd);
            $("#sp").attr("value",nospd);   
            $("#tgl_spp").attr("value",tgspp);
            $("#npwp").attr("Value",npwp);
            $("#kebutuhan_bulan").attr("Value",bulan);
            $("#ketentuan").attr("Value",keperluan);
            $("#bank1").combogrid("setValue",bank);
            $("#rekanan").attr("Value",rekanan);
            $("#rekening").attr("Value",rekening);
            $("#nmskpd").attr("Value",nm_skpd);
            $("#ket_batal").attr("Value",ket_batal);
			tampil_potongan();          
            load_sum_pot();
			//validate_jenis_edit(jns_bbn);
        status_batal(sp2d_batal);
            tombol(status);  
			
        }
		
        function status_batal($status1){
          //alert($status1);
        if($status1=='1'){
            $('#save').linkbutton('disable');
            $('#del').linkbutton('disable');
      $('#save-pot').linkbutton('disable');
            $('#del-pot').linkbutton('disable');
      $('#edit-ket').linkbutton('enable');
            $('#batal').linkbutton('enable');
      $('#del1').linkbutton('enable');
      //$('#batal').linkbutton('disable'); 
      //$('#del1').linkbutton('disable');               
      $('#cetak').linkbutton('disable'); 
            document.getElementById("p2").innerHTML="SPP - SPM dalam Status Batal";
        }else{
            document.getElementById("p2").innerHTML="";
        }        
    }
        
        function kosong(){

            lcstatus = 'tambah';    
            cdate    = '<?php echo date("Y-m-d"); ?>';
            $("#no_spm").attr("value",'');
            $("#no_spm_hide").attr("value",'');
            $("#spm_pot").attr("value",'');
            $("#dd").datebox("setValue",cdate);
            $("#nospp").combogrid("setValue",'');       
            $("#dn").attr("value",'');
            $("#dd_spm").attr("value",'');
            $("#sp").attr("value",'');        
            $("#tgl_spp").attr("value",'');
            $("#kebutuhan_bulan").attr("Value",'');
            $("#ketentuan").attr("Value",'');
            $("#jns_beban").attr("Value",'');
            $("#npwp").attr("Value",'');
            $("#rekanan").attr("Value",'');
             $("#bank1").combogrid("setValue",'');
            $("#rekening").attr("Value",'');
            $("#nmskpd").attr("Value",'');
            detail1();
            $("#nospp").combogrid("clear");
            tombolnew();
            $("#totalrekpajak").attr("value",0);
            document.getElementById("p1").innerHTML="";
            document.getElementById("p2").innerHTML="";
            //$('#rnospm').linkbutton('enable');
            
        }
        

    $(document).ready(function() {
            $("#accordion").accordion();
            $("#lockscreen").hide();                        
            $("#frm").hide();
            $("#dialog-modal").dialog({
            height: 320,
            width: 700,
            modal: true,
            autoOpen:false
    });
			get_tahun();
			get_username();


    });
       
    
    function cetak(){
        var nom=document.getElementById("no_spm").value;
        $("#cspm").combogrid("setValue",nom);
        $("#dialog-modal").dialog('open');
    } 
    
    
    function keluar(){
        $("#dialog-modal").dialog('close');
    }   
    
    function get_tahun() {
        	$.ajax({
        		url:'<?php echo base_url(); ?>index.php/xtukd_ppkd/config_tahun',
        		type: "POST",
        		dataType:"json",                         
        		success:function(data){
        			tahun_anggaran = data;
        			}                                     
        	});
             
        }
    function cari(){
     var kriteria = document.getElementById("txtcari").value; 
        $(function(){ 
            $('#spm').edatagrid({
	       url: '<?php echo base_url(); ?>/index.php/xtukd_ppkd/load_spm',
         queryParams:({cari:kriteria})
        });        
     });
    }
        
    
    function simpan_spm(){        
    
        var a1      = document.getElementById('no_spm').value;
        var a1_hide = document.getElementById('no_spm_hide').value;
        var a1_dd   = document.getElementById('dd_spm').value;
        var b1      = $('#dd').datebox('getValue'); 
        var b       = document.getElementById('tgl_spp').value;      
        var c       = document.getElementById('jns_beban').value; 
        var d       = document.getElementById('kebutuhan_bulan').value;
        var e       = document.getElementById('ketentuan').value;
        var f       = document.getElementById('rekanan').value;
        var g       = $("#bank1").combogrid("getValue") ; 
        var h       = document.getElementById('npwp').value;
        var i       = document.getElementById('rekening').value;
        var j       = document.getElementById('nmskpd').value;
        var k       = document.getElementById('dn').value;
        var l       = document.getElementById('sp').value;
        var m       = document.getElementById('rekspm1').value; 
        var cc      = document.getElementById('cc').value;
		var last_update =  tox_tanggal();

		var tahun_input = b1.substring(0, 4);
		if (tahun_input != tahun_anggaran){
			alert('Tahun tidak sama dengan tahun Anggaran');
			exit();
		}
		if (a1==""){
		alert ("No SPM Tidak Boleh Kosong");
		exit();
		}
		if (b>b1){
		alert("Tanggal SMP tidak boleh lebih kecil dari tanggal SPP");
		exit();
		}
        if (lcstatus=='tambah') { 

            lcinsert = " ( no_spm,     tgl_spm,   no_spp,       kd_skpd,  nm_skpd,  tgl_spp,  bulan,   no_spd,  keperluan, username, last_update, status, jns_spp, jenis_beban,  bank,     nmrekan,  no_rek,   npwp,    nilai, urut  ) ";
            lcvalues = " ( '"+a1+"',   '"+b1+"',  '"+no_spp+"', '"+k+"',  '"+j+"',  '"+b+"',  '"+d+"', '"+l+"', '"+e+"','"+usernm+"','"+last_update+"','0','"+c+"', '"+cc+"',  '"+g+"',  '"+f+"',  '"+i+"',  '"+h+"', '"+m+"', '"+a1_dd+"' ) ";           

            $(document).ready(function(){
                $.ajax({
                    type     : "POST",
                    url      : '<?php echo base_url(); ?>/index.php/xtukd_ppkd/simpan_tukd',
                    data     : ({tabel:'trhspm',kolom:lcinsert,nilai:lcvalues,cid:'no_spm',lcid:a1,tagih:no_spp}),
                    dataType : "json",
                    success  : function(data){
                        status = data;
                        if (status=='0'){
                            alert('Gagal Simpan..!!');
                            exit();
                        } else if(status=='1'){
                                  alert('Nomor SPM Sudah Terpakai...!!!,  Ganti Nomor SPM...!!!');
                                  exit();
                               } else {
                                  alert('Data Tersimpan..!!');
                                  lcstatus = 'edit';
                                  exit();
                               }
                    }
                });
            });   
           
        } else {
            
            lcquery = " UPDATE trhspm SET no_spm='"+a1+"',  tgl_spm='"+b1+"',  no_spp='"+no_spp+"', kd_skpd='"+k+"',  nm_skpd='"+j+"', tgl_spp='"+b+"',  bulan='"+d+"',   no_spd='"+l+"',  keperluan='"+e+"',username='"+usernm+"', last_update='"+last_update+"',  status='0',  jns_spp='"+c+"', jenis_beban='"+cc+"',  bank='"+g+"',  nmrekan='"+f+"',  no_rek='"+i+"',  npwp='"+h+"',  nilai='"+m+"' where no_spm='"+a1_hide+"'  "; 
            lcquery2 = " UPDATE trspmpot SET no_spm='"+a1+"'where no_spm='"+a1_hide+"'  "; 

            $(document).ready(function(){
            $.ajax({
                type     : "POST",
                url      : '<?php echo base_url(); ?>/index.php/xtukd_ppkd/update_spm',
                data     : ({st_query:lcquery,tabel:'trhspm',cid:'no_spm',lcid:a1,lcid_h:a1_hide,st_query2:lcquery2}),
                dataType : "json",
                success  : function(data){
                           status=data ;
                        
                        if ( status=='1' ){
                            alert('Nomor SPM Sudah Terpakai...!!!,  Ganti Nomor SPM...!!!');
                            exit();
                        }
                        
                        if ( status=='2' ){
                            alert('Data Tersimpan...!!!');
                            lcstatus = 'edit';
                            exit();
                        }
                        
                        if ( status=='0' ){
                            alert('Gagal Simpan...!!!');
                            exit();
                        }
                    }
            });
            });
            }
            $("#no_spm_hide").attr("Value",a1);
        }
        
    
    function simpan(reke,nrek){		
		var spm = document.getElementById('no_spm').value;
		var cskpd =document.getElementById('dn').value;
        
        $(function(){      
            $.ajax({
            type: 'POST',
            data: ({cskpd:cskpd,spm:spm,kd_rek5:reke,nmrek:nrek}),
            dataType:"json",
            url:'<?php echo base_url(); ?>/index.php/xtukd_ppkd/pot_simpan'
         });
        });
		}
        
        
    function psimpan(reke,nrek,nilai,ket){		
		var spm = document.getElementById('no_spm').value;
		var cskpd =document.getElementById('dn').value;
        $(function(){      
            $.ajax({
            type: 'POST',
            data: ({cskpd:cskpd,spm:spm,kd_rek5:reke,nmrek:nrek,nilai:nilai,ket:ket}),
            dataType:"json",
            url:'<?php echo base_url(); ?>/index.php/xtukd_ppkd/potsimpan'
         });
        });
		}
     
          
    function hhapus(){				
            var spm = document.getElementById("no_spm").value;
            var urll= '<?php echo base_url(); ?>/index.php/xtukd_ppkd/hapus_spm';             			    
         	if (spm !=''){
				var del=confirm('Anda yakin akan menghapus SPM '+spm+'  ?');
				if  (del==true){
					$(document).ready(function(){
                    $.post(urll,({no:spm,spp:no_spp}),function(data){
                    status = data;
                    });
                    });
				}
				} 
		}
        
        
    function phapus(){				
            var spm = document.getElementById("no_spm").value;
            var rek=getSelections();                       
            var urll= '<?php echo base_url(); ?>/index.php/xtukd_ppkd/hapus_pot';             			    
         	if (spm !=''){
				var del=confirm('Anda yakin akan menghapus rek '+rek+'  ?');
				if  (del==true){
					$(document).ready(function(){
                    $.post(urll,({no:spm,rek:rek}),function(data){
                    status = data;
                        
                    });
                    });
				
				}
				} 
		}  
         

    function getSelections(idx){
			var ids = [];
			var rows = $('#pot').edatagrid('getSelections');
			for(var i=0;i<rows.length;i++){
				ids.push(rows[i].kd_rek5);
			}
			return ids.join(':');
	}
    
        
    function load_sum_spm(){           
        $(function(){      
         $.ajax({
            type: 'POST',
            data:({spp:no_spp}),
            url:"<?php echo base_url(); ?>index.php/xtukd_ppkd/load_sum_spm",
            dataType:"json",
            success:function(data){ 
                $.each(data, function(i,n){
                    $("#rekspm").attr("value",n['rekspm']);
                    $("#rekspm1").attr("value",n['rekspm1']);
                });
            }
         });
        });
    }         
        
    
    function load_sum_pot(){                
		var spm = document.getElementById('no_spm').value;              
        $(function(){      
         $.ajax({
            type      : 'POST',
            data      : ({spm:spm}),
            url       : "<?php echo base_url(); ?>index.php/xtukd_ppkd/load_sum_pot",
            dataType  : "json",
            success   : function(data){ 
                $.each(data, function(i,n){
                    //$("#totalrekpajak").attr("value",number_format(n['rektotal'],2,'.',','));
                    $("#totalrekpajak").attr("value",n['rektotal']);
                });
            }
         });
        });
    }
     
     
     function section1(){
         $(document).ready(function(){    
             $('#section1').click();                                               
         });
     }
     
     
     function section2(){
         $(document).ready(function(){    
             $('#section2').click();
			 
			  $('#top_img').click();
			});
     }
     
     
     function section3(){
         $(document).ready(function(){    
             $('#section3').click();                                               
         });
     }
     
     
      function tombol(st){ 
      //alert(st); 
        if (st==1){
            $('#save').linkbutton('disable');
            $('#del').linkbutton('disable');
      $('#save-pot').linkbutton('disable');
            $('#del-pot').linkbutton('disable');
      $('#edit-ket').linkbutton('enable');
            $('#batal').linkbutton('disable');
            //$('#rnospm').linkbutton('disable');
            document.getElementById("p1").innerHTML="Sudah di Buat SP2D!!";
         } else {
             //$('#save').linkbutton('enable');
             //$('#del').linkbutton('enable');
       $('#save-pot').linkbutton('enable');
             $('#del-pot').linkbutton('enable');
       $('#edit-ket').linkbutton('disable');
             $('#batal').linkbutton('enable');
             //$('#rnospm').linkbutton('enable');
       
            document.getElementById("p1").innerHTML="";
         }
    }

    /*function tombol(st){  
        
            $('#save').linkbutton('disable');
            $('#del').linkbutton('disable');
      $('#save-pot').linkbutton('disable');
            $('#del-pot').linkbutton('disable');
            $('#cetak').linkbutton('disable');
  }*/
	
    
    function tombolnew(){  
   /*$('#save').linkbutton('disable');
     $('#del').linkbutton('disable');
   $('#save-pot').linkbutton('disable');
   $('#del-pot').linkbutton('disable');*/
  //$('#edit-ket').linkbutton('disable');

    $('#save').linkbutton('enable');
     $('#del').linkbutton('enable');
   $('#save-pot').linkbutton('enable'); 
   $('#del-pot').linkbutton('enable');
   $('#edit-ket').linkbutton('enable');
    }

    
     
    
    function openWindow( url )
        {
		var kode	= $("#cspm").combogrid("getValue") ;
		var no 		= kode.split("/").join("123456789");
		var ttd 	= $("#ttd1").combogrid("getValue") ;
		var ttd1 	= ttd.split(" ").join("123456789");
		var ttd_2 	= $("#ttd2").combogrid("getValue") ;
		var ttd2 	= ttd_2.split(" ").join("123456789");
		var ttd_3 	= $("#ttd3").combogrid("getValue") ;
		var ttd3 	= ttd_3.split(" ").join("123456789");
		var ttd_4 	= $("#ttd4").combogrid("getValue") ;
		var ttd4 	= ttd_4.split(" ").join("123456789");
		var tglspm = $('#dd').datebox('getValue');
		var baris   = document.getElementById("baris").value;
		
		if(ttd==''){
			alert("Pilih Bendahara Pengeluaran Terlebih Dahulu!");
			exit();
		}
		if(ttd_2==''){
			alert("Pilih PPK Terlebih Dahulu!");
			exit();
		}
		if(ttd_3==''){
			alert("Pilih Pengguna Anggaran Terlebih Dahulu!");
			exit();
		}
		if(ttd_4==''){
			alert("Pilih PPKD Terlebih Dahulu!");
			exit();
		}
		window.open(url+'/'+no+'/'+skpd+'/'+jns+'/'+ttd1+'/'+ttd2+'/'+ttd3+'/'+ttd4+'/'+tglspm+'/'+baris, '_blank');
        window.focus();
        }
        
    function cek(){
        var lcno = document.getElementById('no_spm').value;
            if ( lcno !='' ) {
               section3();  
               $("#totalrekpajak").attr("value",0);  
               $("#nilairekpajak").attr("value",0);  
               tampil_potongan();          
               load_sum_pot();
               $("#rekpajak").combogrid("setValue",'');
               $("#nmrekpajak").attr("value",'');
               
            } else {
                alert('Nomor SPM Tidak Boleh kosong')
                document.getElementById('no_spm').focus();
                exit();
            }
    }    
    
    
    function append_save() {
			var no_spm_pot      = document.getElementById('no_spm').value;
            $('#dgpajak').datagrid('selectAll');
            var rows  = $('#dgpajak').datagrid('getSelections');
            jgrid     = rows.length ; 
            var kd_trans    = $("#rektrans").combogrid("getValue") ;
            var rek_pajak    = $("#rekpajak").combogrid("getValue") ;
            var nm_rek_pajak = document.getElementById("nmrekpajak").value ;
            var nilai_pajak  = document.getElementById("nilairekpajak").value ;
            var nil_pajak    = angka(nilai_pajak);
            var dinas        = document.getElementById('dn').value;
            var vnospm       = document.getElementById('no_spm').value;
            var cket         = '0' ;
            
            var jumlah_pajak = document.getElementById('totalrekpajak').value ;   
                jumlah_pajak = angka(jumlah_pajak);        
            if(no_spm_pot==''){
				alert("Isi No SPM Terlebih Dahulu...!!!");
                exit();
			}
			if(kd_trans==''){
				alert("Isi Rekening Transaksi Terlebih Dahulu...!!!");
                exit();
			}
            if ( rek_pajak == '' ){
                alert("Isi Rekening Pajak Terlebih Dahulu...!!!");
                exit();
                }
            
            if ( nilai_pajak == 0 ){
                alert("Isi Nilai Terlebih Dahulu...!!!");
                exit();
                }
            
            pidx = jgrid + 1 ;

            $('#dgpajak').edatagrid('appendRow',{kd_rek5:rek_pajak,kd_trans:kd_trans,nm_rek5:nm_rek_pajak,nilai:nilai_pajak,id:pidx});
            $(document).ready(function(){      
                $.ajax({
                type     : 'POST',
                url      : "<?php  echo base_url(); ?>index.php/xtukd_ppkd/dsimpan_pot_ar",
                data     : ({cskpd:dinas,spm:vnospm,kd_rek5:rek_pajak,nmrek:nm_rek_pajak,nilai:nil_pajak,ket:cket,kd_trans:kd_trans}),
                dataType : "json"
                });
            });
            
            $("#rekpajak").combogrid("setValue",'');
            $("#nmrekpajak").attr("value",'');
            $("#nilairekpajak").attr("value",0);
            jumlah_pajak = jumlah_pajak + nil_pajak ;
            $("#totalrekpajak").attr('value',number_format(jumlah_pajak,2,'.',','));
            validate_rekening();
    
    }


    function validate_rekening() {
           
           $('#dgpajak').datagrid('selectAll');
           var rows = $('#dgpajak').datagrid('getSelections');
                
           frek  = '' ;
           rek5  = '' ;
           for ( var p=0; p < rows.length; p++ ) { 
           rek5 = rows[p].kd_rek5;                                       
           if ( p > 0 ){   
                  frek = frek+','+rek5;
              } else {
                  frek = rek5;
              }
           }
           
           $(function(){
           $('#rekpajak').combogrid({  
                   panelWidth  : 700,  
                   idField     : 'kd_rek5',  
                   textField   : 'kd_rek5',  
                   mode        : 'remote',
                   url         : '<?php echo base_url(); ?>index.php/xtukd_ppkd/rek_pot', 
                   queryParams :({kdrek:frek}), 
                   columns:[[  
                       {field:'kd_rek5',title:'Kode Rekening',width:100},  
                       {field:'nm_rek5',title:'Nama Rekening',width:700}    
                   ]],  
                   onSelect:function(rowIndex,rowData){
                       $("#nmrekpajak").attr("value",rowData.nm_rek5.toUpperCase());
                   }  
                   });
                   });
          $('#dgpajak').datagrid('unselectAll');         
    }
    
    
    function hapus_detail(){
        
        var vnospm        = document.getElementById('no_spm').value;
        var dinas         = document.getElementById('dn').value;
        
        var rows          = $('#dgpajak').edatagrid('getSelected');
        var ctotalpotspm  = document.getElementById('totalrekpajak').value ;
        
        bkdrek            = rows.kd_rek5;
        bnilai            = rows.nilai;
        
        var idx = $('#dgpajak').edatagrid('getRowIndex',rows);
        var tny = confirm('Yakin Ingin Menghapus Data, Rekening : '+bkdrek+'  Nilai :  '+bnilai+' ?');
        
        if ( tny == true ) {
            
            $('#dgpajak').datagrid('deleteRow',idx);     
            $('#dgpajak').datagrid('unselectAll');
              
             var urll = '<?php  echo base_url(); ?>index.php/xtukd_ppkd/dsimpan_pot_delete_ar';
             $(document).ready(function(){
             $.post(urll,({cskpd:dinas,spm:vnospm,kd_rek5:bkdrek}),function(data){
             status = data;
                if (status=='0'){
                    alert('Gagal Hapus..!!');
                    exit();
                } else {
                    alert('Data Telah Terhapus..!!');
                    exit();
                }
             });
             });    
             
             ctotalpotspm = angka(ctotalpotspm) - angka(bnilai) ;
             $("#totalrekpajak").attr("Value",number_format(ctotalpotspm,2,'.',','));
             validate_rekening();
             }     
        }
        
        
    function tampil_potongan () {
        
            var vnospm = document.getElementById('no_spm').value ;
        
            $(function(){
			$('#dgpajak').edatagrid({
				url: '<?php echo base_url(); ?>/index.php/xtukd_ppkd/pot',
                queryParams    : ({ spm:vnospm }),
                idField       : 'id',
                toolbar       : "#toolbar",              
                rownumbers    : "true", 
                fitColumns    : false,
                autoRowHeight : "false",
                singleSelect  : "true",
                nowrap        : "true",
      			columns       :
                     [[
                        {field:'id',title:'id',width:100,align:'left',hidden:'true'}, 
                        {field:'kd_trans',title:'Rek. Trans',width:100,align:'left'},			
                        {field:'kd_rek5',title:'Rekening',width:100,align:'left'},			
    					{field:'nm_rek5',title:'Nama Rekening',width:317},
    					{field:'nilai',title:'Nilai',width:100,align:"right"},
                        {field:'hapus',title:'Hapus',width:100,align:"center",
                        formatter:function(value,rec){ 
                        return '<img src="<?php echo base_url(); ?>/assets/images/icon/edit_remove.png" onclick="javascript:hapus_detail();" />';
                        }
                        }
        			]]	
                  });
		    });
    }


/*  function validate_jenis_edit($jns_bbn){
        var beban   = document.getElementById('jns_beban').value;
		$('#cc').combobox({url:'<?php echo base_url(); ?>/index.php/xtukd_ppkd/load_jenis_beban/'+beban,
		});

		$('#cc').combobox('setValue', jns_bbn);
	} */

function inputnomor(){    
        var nomorspm = document.getElementById('no_spm').value;
        $("#spm_pot").attr("value",nomorspm);
     }

function get_spm(){
      var jenis_ls = document.getElementById('jns_beban').value;
      var skpdspm = document.getElementById('dn').value;
      var nospp =  $('#nospp').combogrid('getValue') ;
            var nospm = document.getElementById("no_spm_hide").value;
            
      if(nospp==''){
        alert('Pilih terlebih dahulu No SPP');
        return;
      }
      var jns ="";var $jns2 = '';
      $("#no_spm").attr("value",'');
      if(jenis_ls==4){
        
        var no = nospp.includes("BTL");
        if(no){
          $("#no_spm").attr("value",'');
          jns = "BTL";
        }else{
          $("#no_spm").attr("value",'');
          jns = 'GJ';
        }
        
        //alert(JSON.stringify(rows));  
        
      }else if(jenis_ls==6 || jenis_ls==5){
        jns = "LS";
      }else if(jenis_ls==1){
        jns = "UP";
      }else if(jenis_ls==2){
        jns = "GU";
      }else if(jenis_ls==3){
        jns = "TU";
      }
      
      if(jenis_ls==5){
        jns2 ='BTL';
      }else{
        jns2 ='BL';
      }       
      
          $.ajax({
            url:'<?php echo base_url(); ?>index.php/tukd/config_spm/'+jns2,
            type: "POST",
            dataType:"json",   
                data     : ({nospm1:nospm}),
            success:function(data){
              no_spm = data.nomor;
          var inisial = no_spm + "/SPM/"+jns+"/"+jns2+"/"+skpdspm+"/"+tahun_anggaran;
          $("#no_spm").attr("value",inisial);
          $("#spm_pot").attr("value",inisial);
          $("#dd_spm").attr("value",no_spm);
                    
              }                                     
          });
        } 

//copy



function validate_rek_trans(no_spp) {
        var nospp_pot = document.getElementById('nospp1').value;
           $(function(){
			   $('#rektrans').combogrid({  
					panelWidth:600,  
					idField:'kd_rek5',  
					textField:'kd_rek5',  
					mode:'remote',
                    url  : '<?php echo base_url(); ?>index.php/xtukd_ppkd/rek_pot_trans', 
                   queryParams :({nospp_pot:nospp_pot}), 

					columns:[[  
						{field:'kd_rek5',title:'NIP',width:200},  
						{field:'nm_rek5',title:'Nama',width:400}    
					]],
                    onSelect:function(rowIndex,rowData){
                    $("#nmrektrans").attr("value",rowData.nm_rek5);
                    }  
				});
			   });
           
     
}	

   function tox_tanggal() {
  now = new Date();
  year = "" + now.getFullYear();
  month = "" + (now.getMonth() + 1); if (month.length == 1) { month = "0" + month; }
  day = "" + now.getDate(); if (day.length == 1) { day = "0" + day; }
  hour = "" + now.getHours(); if (hour.length == 1) { hour = "0" + hour; }
  minute = "" + now.getMinutes(); if (minute.length == 1) { minute = "0" + minute; }
  second = "" + now.getSeconds(); if (second.length == 1) { second = "0" + second; }
  return year + "-" + month + "-" + day + " " + hour + ":" + minute + ":" + second;
}

     function get_username() {
        	$.ajax({
        		url:'<?php echo base_url(); ?>index.php/xtukd_ppkd/config_nm_user',
        		type: "POST",
        		dataType:"json",                         
        		success:function(data){
        			usernm = data;
        			}                                     
        	});
             
        }


     //copy




     function form_batal(){
        $("#no_spm_batal").attr('disabled',true);
        $("#no_spp_batal").attr('disabled',true);   
    document.getElementById("no_spm_batal").value= document.getElementById("no_spm").value;
    $("#no_spp_batal").attr("value",$('#nospp').combogrid('getValue'));   
        
        $("#dialog-batal").dialog('open');
    } 
 
    function keluar_batal(){
        $("#dialog-batal").dialog('close');
    }   
  
    function batal(){
        var no_spm      = document.getElementById("no_spm_batal").value;
        var no_spp = document.getElementById("no_spp_batal").value;
        var ket = document.getElementById("ket_batal").value;
    var beban   = document.getElementById('jns_beban').value;
    
      if (no_spp !=''){
      var del=confirm('Anda yakin akan Membatalkan SPM: '+no_spm+'  ?');
      if  (del==true){
        /*ini untuk delete
        $(document).ready(function(){
                $.post(urll,({no:sp2d,spm:no_spm}),function(data){
                status = data;
                spm_combo(); */
        if (ket==''){ 
            alert('Keterangan harus diisi');
          exit(); 
        }
                
                
            $(document).ready(function(){
            $.ajax({
                type     : "POST",
                url      : '<?php echo base_url(); ?>/index.php/tukd/batal_spp',
                data     : ({nospp:no_spp,ket:ket,jns_spp:beban}),
                dataType : "json",
                success  : function(data){
                           status=data ;
                        if ( status=='1' ){
              keluar_batal();
                            alert('SPP - SPM Berhasil Dibatalkan');
                        }else{
              keluar_batal();  
                            alert('SPP - SPM Gagal Dibatalkan');       
                        }
                    }
            });
            });     
      }
    } 
  }
     
    </script>
    
    <STYLE TYPE="text/css"> 
        input.right{ 
        text-align:right; 
        } 
    </STYLE> 

</head>
<body>



<div id="content">
<div id="accordion">
<h3><a href="#" id="section1" onclick="javascript:$('#spm').edatagrid('reload')">List SPM</a></h3>
    <div>
    <p align="right">         
        <a class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:kosong();section2();" >Tambah</a>
        <a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetak();">cetak</a>               
        <a class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="javascript:cari();">Cari</a>
        <input type="text" value="" id="txtcari"/>
        <table id="spm" title="List SPM" style="width:870px;height:450px;" >  
        </table>
    </p> 
    </div>

<h3><a href="#" id="section2" onclick="javascript:$('#dg').edatagrid('reload')" >Input SPM</a></h3>
   <div  style="height: 350px;">
   <p id="p2" style="font-size: x-large;color: red;"></p>
   <p id="p1" style="font-size: x-large;color: red;"></p>
   

<fieldset style="width:850px;height:850px;border-color:white;border-style:hidden;border-spacing:0;padding:0;">            
<table border='1' style="font-size:11px" >

 <tr style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;">
   <td style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;" >&nbsp;</td>
   <td style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;">&nbsp;</td>
   <td style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;">&nbsp;</td>
   <td style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;">&nbsp;</td>
 </tr>
 
 <tr style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;">
   <td style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;" >No SPM</td>
   <td style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;">&nbsp;<input type="text" name="no_spm" id="no_spm" style="width:200px;" onkeyup="this.value=this.value.toUpperCase(); javascript:inputnomor();"/>
   <a id="rnospm" class="tooltip easyui-linkbutton" iconCls="icon-reload" plain="true"  onclick="javascript:get_spm();"><span class="tooltiptext">Refresh No SPM</span></a>* No Otomatis<input type="hidden" name="no_spm_hide" id="no_spm_hide" onclick="javascript:select();"  style="width:200px;"/></td>
   <td style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;">Tgl SPM </td>
   <td style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;">&nbsp;&nbsp;<input id="dd" name="dd" type="text" style="width:100px;"/><input id="dd_spm" name="dd_spm" type="hidden" /></td></td>
 </tr>
 <tr style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;" >   
   <td width="8%" style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;">No SPP</td>
   <td style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;">&nbsp;<input id="nospp" name="nospp" style="width:350px;" />
     <input type="hidden" name="nospp1" id="nospp1" /></td>
   <td style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;">Tgl SPP </td>
   <td style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;">&nbsp;&nbsp;<input id="tgl_spp" name="tgl_spp" type="text" readonly="true" style="width:100px;" /></td>   
    </tr>
 <tr style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;">
   <td width='8%' style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;">SKPD</td>
   <td width="53%" style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;" >     
      &nbsp;<input id="dn" name="dn" style="width:200px" readonly="true"/></td> 
   <td width='8%' style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;">Bulan</td>
   <td width="31%" style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;" ><select  name="kebutuhan_bulan" id="kebutuhan_bulan" style="width:200px;" >
     <option value="">...Pilih Kebutuhan Bulan... </option>
     <option value="1" >1 | Januari</option>
     <option value="2">2 | Februari</option>
     <option value="3">3 | Maret</option>
     <option value="4">4 | April</option>
     <option value="5">5 | Mei</option>
     <option value="6">6 | Juni</option>
     <option value="7">7 | Juli</option>
     <option value="8">8 | Agustus</option>
     <option value="9">9 | September</option>
     <option value="10">10 | Oktober</option>
     <option value="11">11 | November</option>
     <option value="12">12 | Desember</option>
   </select></td> 
 </tr>
 <tr style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;">
   <td width='8%' style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;">&nbsp;</td>
   <td width='53%' style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;"><textarea name="nmskpd" id="nmskpd" cols="40" rows="1" style="border: 0;"  readonly="true"></textarea></td>
   <td width='8%' style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;">Keperluan</td>
   <td width='31%' style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;"><textarea name="ketentuan" id="ketentuan" cols="30" rows="1"></textarea></td>
 </tr>
 
 <tr style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;">
   <td width='8%' style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;">No SPD</td>
   <td style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;">&nbsp;<input id="sp" name="sp" style="width:200px" readonly="true"/></td>
   <td width='8%' style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;">Rekanan</td>
   <td style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;"><textarea id="rekanan" name="rekanan" cols="30" rows="1" readonly="true" > </textarea></td>
 </tr>
 
 <tr style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;">
   <td style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;">Beban</td>
   <td style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;"><select name="jns_beban" id="jns_beban" style="width:200px;" value="5" >     
     <option value="5">LS PPKD</option></select><input id="cc" name="dept" type=hidden value="3" >
      <td width="8%" style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;" >BANK</td>
   <td style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px">&nbsp;<input type="text" name="bank1" id="bank1"/>
    &nbsp;<input type ="input" readonly="true" style="border:hidden" id="nama_bank" name="nama_bank" style="width:150" /></td>
 </tr> 
 <tr style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;">
   <td width='8%' style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;">&nbsp;</td>
   <td width='53%' style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;">&nbsp;</td>
   <td width='8%' style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;">Rekening</td>
   <td width='31%' style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;">&nbsp;<input type="text" name="rekening" id="rekening"  value="" style="width:200px;" readonly="true" /></td>
 </tr>       
 <tr style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;">
   <td width='8%' style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;">&nbsp;</td>
   <td width='53%' style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;">&nbsp;</td>
   <td width='8%' style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;">NPWP</td>
   <td width='31%' style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;">&nbsp;<input type="text" name="npwp" id="npwp" value="" style="width:200px;" readonly="true"/></td>
 </tr>       

             <tr style="border-spacing: 3px;padding:3px 3px 3px 3px;">
               <td style="border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style: hidden;" >&nbsp;</td>
               <td style="border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style: hidden;">&nbsp;</td>
               <td style="border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style: hidden;">&nbsp;</td>
               <td style="border-spacing: 3px;padding:3px 3px 3px 3px;">&nbsp;</td>
             </tr>
             
             <tr style="border-bottom:black; border-spacing: 3px;padding:3px 3px 3px 3px;">
                <td colspan="4" align="right" style="border-bottom:black; border-spacing: 3px;padding:3px 3px 3px 3px;">
                <a id="l"  class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:kosong();">Baru</a>
                <a id="save" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:simpan_spm();">Simpan</a>
                <a id="del" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:hhapus();javascript:section1();">Hapus</a>
                <a id="batal" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:form_batal();">Batal SPM - SPP</a> 
            <!--    <a id="poto" class="easyui-linkbutton" iconCls="icon-redo" plain="true" onclick="javascript:cek();">Potongan</a> -->
                <a class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:section1();">Kembali</a>
                <a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetak();">cetak</a></td>                
            </tr>
  
            
    </table>
    <table id="dg" title=" Detail SPM" style="width:850%;height:250%;">  
    </table>
        
        <!--
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<B>Total</B>&nbsp;&nbsp;<input class="right" type="text" name="rekspm" id="rekspm"  style="width:140px" align="right" readonly="true" >
        <input class="right" type="hidden" name="rekspm1" id="rekspm1"  style="width:100px" align="right" readonly="true" >
        -->
        
        <table border='0' >
            
            <tr>
                <td width='400px'></td>
                <td width='220px'></td>
                <td width='240px'></td>
            </tr>
            
            <tr>
                <td></td>
                <td align='right'><B>Total</B></td>
                <td align="right"><input class="right" type="text" name="rekspm" id="rekspm"  style="width:200px" align="right" readonly="true" >
                    <input class="right" type="hidden" name="rekspm1" id="rekspm1"  style="width:100px" align="right" readonly="true" >
                </td>
            </tr>
        </table>
    </p>
	
	<!--dari sini -->
	<!--
	 <fieldset>
       <table border='0' style="font-size:11px"> 
           <tr>
                <td>No. SPM</td>
                <td>:</td>
                <td><input type="text" id="spm_pot"   name="spm_pot" style="width:200px;"/></td>
           </tr>
		   <tr>
                <td>Rekening Transaksi</td>
                <td>:</td>
                <td><input type="text" id="rektrans"   name="rektrans" style="width:200px;"/></td>
                <td><input type="text" id="nmrektrans" name="nmrektrans" style="width:400px;border:0px;"/></td>
           </tr>
           <tr>
                <td>Rekening Potongan</td>
                <td>:</td>
                <td><input type="text" id="rekpajak"   name="rekpajak" style="width:200px;"/></td>
                <td><input type="text" id="nmrekpajak" name="nmrekpajak" style="width:400px;border:0px;"/></td>
           </tr>
           <tr>
                <td align="left">Nilai</td>
                <td>:</td>
                <td><input type="text" id="nilairekpajak" name="nilairekpajak" style="width:200px;text-align:right;" onkeypress="return(currencyFormat(this,',','.',event))"/></td>
                <td></td>
           </tr>
           <tr>
             <td colspan="4" align="center" > 
                 <a id="save-pot" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:append_save();" >Simpan</a>
                 <a id="del-pot" class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:section2();" >Kembali</a>
             </td>
           </tr>
       </table>
       </fieldset>
       
      &nbsp;&nbsp; 
       
       <table id="dgpajak" title="List Potongan" style="width:850px;height:300px;">  
       </table>   
       
       <table border='0' style="font-size:11px;width:850px;height:30px;"> 
           <tr>
                <td width='50%'></td>
                <td width='20%' align="right">Total</td>
                <td width='30%'><input type="text" id="totalrekpajak" name="totalrekpajak" style="width:250px;text-align:right;"/></td>
           </tr>
       </table>
	
	
	
    </fieldset>
	
	<!--Sampai sini -->
    </div>

</div>
</div> 

<div id="dialog-modal" title="CETAK SPM">
    <p class="validateTips">SILAHKAN PILIH SPM</p> 
    <fieldset>
    <table>

        <tr>
            <td width="110px">NO SPM:</td>
            <td><input id="cspm" name="cspm" style="width: 170px;" disabled /></td>
        </tr>
        <tr>
            <td width="110px">Bend. Pengeluaran:</td>
            <td><input id="ttd1" name="ttd1" style="width: 170px;" />  &nbsp; &nbsp; &nbsp;  <input id="nmttd1" name="nmttd1" style="width: 170px;border:0" /></td>
        </tr>
		<tr>
            <td width="110px">PPK:</td>
            <td><input id="ttd2" name="ttd2" style="width: 170px;" />  &nbsp; &nbsp; &nbsp;  <input id="nmttd2" name="nmttd2" style="width: 170px;border:0" /></td>
        </tr>
		<tr>
            <td width="110px">PA:</td>
            <td><input id="ttd3" name="ttd3" style="width: 170px;" />  &nbsp; &nbsp; &nbsp;  <input id="nmttd3" name="nmttd3" style="width: 170px;border:0" /></td>
        </tr>
		<tr>
            <td width="110px">PPKD:</td>
            <td><input id="ttd4" name="ttd4" style="width: 170px;" />  &nbsp; &nbsp; &nbsp;  <input id="nmttd4" name="nmttd4" style="width: 170px;border:0" /></td>
        </tr>
       
    </table>  
    </fieldset>
	<a href="<?php echo site_url(); ?>/xtukd_ppkd/cetak_spm/1 "class="easyui-linkbutton" iconCls="icon-pdf" plain="true" onclick="javascript:openWindow(this.href);return false;">SPM</a>
    <a href="<?php echo site_url(); ?>/xtukd_ppkd/cetakspm2/1 "class="easyui-linkbutton" iconCls="icon-pdf" plain="true" onclick="javascript:openWindow(this.href);return false;">Ringkasan</a>
	<a href="<?php echo site_url(); ?>/xtukd_ppkd/cetakspm1/1 "class="easyui-linkbutton" iconCls="icon-pdf" plain="true" onclick="javascript:openWindow(this.href);return false;">Pengantar</a>
    <a href="<?php echo site_url(); ?>/xtukd_ppkd/jawab_spm/1 "class="easyui-linkbutton" iconCls="icon-pdf" plain="true" onclick="javascript:openWindow(this.href);return false;">Tanggung Jawab SPM</a>
	<br/>
	
	<a href="<?php echo site_url(); ?>/xtukd_ppkd/cetak_spm/0 "class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:openWindow(this.href);return false;">SPM</a>
	<a href="<?php echo site_url(); ?>/xtukd_ppkd/cetakspm2/0 "class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:openWindow(this.href);return false;">Ringkasan</a>
	<a href="<?php echo site_url(); ?>/xtukd_ppkd/cetakspm1/0 "class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:openWindow(this.href);return false;">Pengantar</a>
	<a href="<?php echo site_url(); ?>/xtukd_ppkd/jawab_spm/0 "class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:openWindow(this.href);return false;">Tanggung Jawab SPM</a>
	<br/>
	<tr>
		<td colspan='4'> Baris SPM : &nbsp; <input type="number" id="baris" name="baris" style="width: 30px;border:0" value="10"/></td>
	</tr>   
	<tr>
		<td><a class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:keluar();">Keluar</a></td>  
	</tr>
</div>

<div id="dialog-batal" title="KETERANGAN PEMBATALAN SPM">
    <p class="validateTips">KETERANGAN PEMBATALAN SPM</p> 
    <fieldset>
    <table>
        <tr>
            <td width="110px">NO SPM:</td>
            <td><input id="no_spm_batal" name="no_spm_batal" style="width: 170px;" readonly="true"/></td>
        </tr>
        <tr>
            <td width="110px">NO SPP:</td>
            <td><input id="no_spp_batal" name="no_spp_batal" style="width: 170px;" readonly="true"/></td>
        </tr>
        <tr>
            <td width="110px">KETERANGAN PEMBATALAN SPM:</td>
            <td><textarea name="ket_batal" id="ket_batal" cols="70" rows="2" ></textarea></td>
        </tr>
    </table>  
    </fieldset>
    <a id="del1" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:batal();javascript:section1();">BATAL</a>
  <a class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:keluar_batal();">Keluar</a>  
</div>
</body>
</html>