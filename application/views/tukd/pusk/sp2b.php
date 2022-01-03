<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
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
   
    var no_sp3b   = ''; 
    var no_lpjx   = '';
    var kode     = '';
    var spd      = '';
    var st_12    = 'edit';
    var nidx     = 100
    var spd2     = '';
    var spd3     = '';
    var spd4     = '';
    var lcstatus = '';
    var skpdd    = '';
    var tahun_anggaran ='';
    
    $(document).ready(function() {
            $("#accordion").accordion();
            $("#lockscreen").hide();                        
            $("#frm").hide();
            $( "#dialog-modal").dialog({
            height: 250,
            width: 550,
            modal: true,
            autoOpen:false
        });
        $( "#dialog-modal-tr").dialog({
            height: 320,
            width: 500,
            modal: true,
            autoOpen:false
        });
		get_tahun();
		$("#div1").hide();
		
		$("#loading").dialog({
				resizable: false,
				width:200,
				height:130,
				modal: true,
				draggable:false,
				autoOpen:false,    
				closeOnEscape:false
				});
		
        });
   
    
    $(function(){

   	     $('#dd').datebox({  
            required:true,
            formatter :function(date){
            	var y = date.getFullYear();
            	var m = date.getMonth()+1;
            	var d = date.getDate();
            	return y+'-'+m+'-'+d;
            }
        });
        
		$('#dd_sp2b').datebox({  
            required:true,
            formatter :function(date){
            	var y = date.getFullYear();
            	var m = date.getMonth()+1;
            	var d = date.getDate();
            	return y+'-'+m+'-'+d;
            }
        });
        
        $('#dd1').datebox({  
            required:true,
            formatter :function(date){
            	var y = date.getFullYear();
            	var m = date.getMonth()+1;
            	var d = date.getDate();
            	return y+'-'+m+'-'+d;
            }
        });
        
        
        $('#dd2').datebox({  
            required:true,
            formatter :function(date){
            	var y = date.getFullYear();
            	var m = date.getMonth()+1;
            	var d = date.getDate();
            	return y+'-'+m+'-'+d;
            }
        });

	$('#nosp2d').combogrid({
           panelWidth:255,  
           idField:'no_sp2d',  
           textField:'no_sp2d',  
           mode:'remote',
           //url:'<?php echo base_url(); ?>index.php/tukd/load_sp2d_lpj_tu',
           //url:'<?php echo base_url(); ?>index.php/rka/load_trskpd/'+kode,             
           columns:[[  
               {field:'no_sp2d',title:'NO SP2D',width:150},
               {field:'tgl_cair',title:'Tgl Pencairan',width:100}  
           ]],
        });
      $('#sp2d').combogrid({
           panelWidth:255,  
           idField:'no_sp2d',  
           textField:'no_sp2d',  
           mode:'remote',
           queryParams:({kode:kode}),
           url:'<?php echo base_url(); ?>index.php/tukd/load_sp2d_lpj_tu',
           //url:'<?php echo base_url(); ?>index.php/rka/load_trskpd/'+kode,             
           columns:[[  
               {field:'no_sp2d',title:'NO SP2D',width:150},
               {field:'tgl_cair',title:'Tgl Pencairan',width:100}  
           ]],  
           onSelect:function(rowIndex,rowData){
			   $("#tgl_sp2d").attr("value",rowData.tgl_cair);
			   //detail_trans_kosong();
			   //load_data();
           }
        });
		
		$('#ttd1').combogrid({  
                panelWidth:600,  
                idField:'nip',  
                textField:'nip',  
                mode:'remote',
                url:'<?php echo base_url(); ?>index.php/tukd/load_ttd/BUD',  
                columns:[[  
                    {field:'nip',title:'NIP',width:200},
                    {field:'nama',title:'Nama',width:400}
                ]],  
           onSelect:function(rowIndex,rowData){
               $("#nm_ttd1").attr("value",rowData.nama);
           } 
            });
		
		$('#dn').combogrid({  
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
               kode = rowData.kd_skpd ;
			   v_ats_beban = '3'
				$("#nmskpd").attr("value",rowData.nm_skpd.toUpperCase());
				$('#sp2d').combogrid({url:'<?php echo base_url(); ?>index.php/tukd/sp2d_tu_list',
                                   queryParams:({kode:kode,v_ats_beban:v_ats_beban})
                                   });				
				
           }  
           });
		
		$('#tgl_ttd').datebox({  
            required:true,
            formatter :function(date){
            	var y = date.getFullYear();
            	var m = date.getMonth()+1;
            	var d = date.getDate();
            	return y+'-'+m+'-'+d;
            }
        }); 
			
         
            $('#ttd2').combogrid({  
                panelWidth:600,  
                idField:'nip',  
                textField:'nip',  
                mode:'remote',
                url:'<?php echo base_url(); ?>index.php/tukd/load_ttd/PA',  
                columns:[[  
                    {field:'nip',title:'NIP',width:200},
                    {field:'nama',title:'Nama',width:400}
                ]],  
           onSelect:function(rowIndex,rowData){
               $("#nm_ttd2").attr("value",rowData.nama);
           } 
            });
		
        	
		$('#cspp').combogrid({  
                panelWidth:500,  
                //url: '<?php echo base_url(); ?>/index.php/tukd/load_lpj_up',  
                    idField:'no_sp2b',                    
                    textField:'no_sp2b',
                    mode:'remote',  
                    fitColumns:true,  
                    columns:[[  
                        {field:'no_sp2b',title:'NO SP3B',width:60},                          
                        {field:'tgl_sp2b',title:'Tanggal',width:60} 
                          
                    ]],
                    onSelect:function(rowIndex,rowData){
                    nomer = rowData.no_lpj;
                    kode = rowData.kd_skpd;
					pilih_giat(nomer);
                    //jns = rowData.jns_spp;
                    //val_ttd(kode);
                    }   
                });
                
          $('#spp').edatagrid({
			rowStyler:function(index,row){
				if (row.status_bud==1){
				   return 'background-color:#03d3ff;';
				}
			},
    		url: '<?php echo base_url(); ?>/index.php/tukd_pusk/load_sp3b_fktp',
            idField:'id',            
            rownumbers:"true", 
            fitColumns:"true",
            singleSelect:"true",
            autoRowHeight:"false",
            loadMsg:"Tunggu Sebentar....!!",
            pagination:"true",
            nowrap:"true",  
            columns:[[
        	    {field:'no_sp3b',
        		title:'SP3B',
        		width:50},
                {field:'tgl_sp3b',
        		title:'Tanggal SP3B',
        		width:40},
                {field:'nm_skpd',
        		title:'Nama SKPD',
        		width:160,
                align:"left"},
                {field:'no_sp2b',
        		title:'SP2B',
        		width:50,
                align:"left"},
                {field:'tgl_sp2b',
        		title:'Tanggal SP2B',
        		width:40,
                align:"left"},
				{field:'status',
				title:'Status',
				width:5,
				align:"left",
				hidden:"true"
				}
            ]],
            onSelect:function(rowIndex,rowData){
              nomer_sp3b     = rowData.no_sp3b; 
      			  tglsp3b	= rowData.tgl_sp3b;
      			  nomer_sp2b  = rowData.no_sp2b;  
      			  no_sp3b = rowData.no_sp3b; 
      			  tglsp2b	= rowData.tgl_sp2b;
              kode      = rowData.kd_skpd;
              nmskpd    = rowData.nm_skpd;
              skpdd      = rowData.skpd;              
              cket		= rowData.ket;
              status_lpj= rowData.status;              
              lpj		= rowData.no_lpj;
              st		= rowData.status_bud;
              bulan    = rowData.bulan;
              $("#bulan").attr('value',bulan);                
              no_lpjx   = lpj;                          
              get(nomer_sp3b,tglsp3b,nomer_sp2b,tglsp2b,kode,nmskpd,cket,status_lpj,lpj,st);
              detail_trans_3();
             // load_sum_lpj(); 
              lcstatus = 'edit';                                       
            },
            onDblClickRow:function(rowIndex,rowData){
              nomer_sp3b     = rowData.no_sp3b; 
              tglsp3b = rowData.tgl_sp3b;
              nomer_sp2b  = rowData.no_sp2b;  
              no_sp3b = rowData.no_sp3b; 
              tglsp2b = rowData.tgl_sp2b;
              kode      = rowData.kd_skpd;
              nmskpd    = rowData.nm_skpd;
              skpdd      = rowData.skpd;              
              cket    = rowData.ket;
              status_lpj= rowData.status;              
              lpj   = rowData.no_lpj;
              st    = rowData.status_bud;              
              no_lpjx   = lpj;
              load_data_sp3b(nomer_sp3b,skpdd); 
              load_sum_lpj(nomer_sp3b,skpdd);                        
              get(nomer_sp3b,tglsp3b,nomer_sp2b,tglsp2b,kode,nmskpd,cket,status_lpj,lpj,st);
              
             // detail_trans_3();
              //load_sum_lpj(); 
              lcstatus = 'edit';  
              section1();
              

        

             
            }/* end dblclik*/
        });
                
              var nlpj      = no_lpjx;          			  

			
   	});
    
    function load_data_sp3b(nomer_sp3b,skpdd){
          $('#dg1').edatagrid({
              url: '<?php echo base_url(); ?>/index.php/tukd_pusk/load_dtrsp3b_blud',
               queryParams:({ no:nomer_sp3b,skpd: skpdd}),
                       idField:'idx',
                       toolbar:"#toolbar",              
                       rownumbers:"true", 
                       autoRowHeight:"false",
                       singleSelect:"true",
                       nowrap:"false",
                 columns:[[
                      {field:'id',
                  title:'ID',       
                      hidden:"true"},
                      {field:'no_lpj',
                  title:'No LPJ',       
                      hidden:"true"},
              {field:'tgl_lpj',
                  title:'Tanggal',        
                      hidden:"true"},
              {field:'kd_kegiatan',
                  title:'Kegiatan',       
                      hidden:"true"}, 
                      {field:'no_bukti',
                  title:'Nomor Bukti',
                      width:80},
                    {field:'kd_rek5',
                  title:'Rekening', align:'center',
                      width:100},
                    {field:'kd_rek7',
                  title:'Rekening Rinci', align:'center',
                      width:100},
                      {field:'nm_rek',
                  title:'Nama Rekening',
                      width:400},                
                      {field:'nilai',
                  title:'Nilai',
                      align:'right',
                      width:100}
                      
                  ]]
                  }); 
    }    

    function get_nomor_sp2b()
        {
        	$.ajax({
        		url:'<?php echo base_url(); ?>index.php/tukd_pusk/no_urut_sp2b',
        		type: "POST",
        		dataType:"json",                         
        		success:function(data){
        								$("#no_sp2b").attr("value",data.no_urut);
        							  }                                     
        	});  
        }       
        
    function val_ttd(dns){
           $(function(){
            $('#ttd').combogrid({  
                panelWidth:500,  
                url: '<?php echo base_url(); ?>/index.php/tukd/pilih_ttd/'+dns,  
                    idField:'nip',                    
                    textField:'nama',
                    mode:'remote',  
                    fitColumns:true,  
                    columns:[[  
                        {field:'nip',title:'NIP',width:60},  
                        {field:'nama',title:'NAMA',align:'left',width:100}
                            ]],
                    onSelect:function(rowIndex,rowData){
                    nip = rowData.nip;
                    }   
                });
           });              
         }
         

    /*
    function get_skpd()
        {
        	$.ajax({
        		url:'<?php echo base_url(); ?>index.php/rka/config_skpd',
        		type: "POST",
        		dataType:"json",                         
        		success:function(data){
        								$("#dn").attr("value",data.kd_skpd);
        								$("#nmskpd").attr("value",data.nm_skpd);
                                            kode   = data.kd_skpd;
                                            validate_spd(kode);
        							  }                                     
        	});  
        }         
    */
   function get_tahun() {
        	$.ajax({
        		url:'<?php echo base_url(); ?>index.php/tukd/config_tahun',
        		type: "POST",
        		dataType:"json",                         
        		success:function(data){
        			tahun_anggaran = data;
        			}                                     
        	});
             
        } 
    
    
	    function get(nomer_sp3b,tglsp3b,nomer_sp2b,tglsp2b,kode,nmskpd,cket,status_lpj,lpj,st){
        
        if(st=='1'){
            var nox = nomer_sp2b.split("/");
            var nox1 = nox[0];var nox2 = nox[1];var nox3 = nox[2];var nox4 = nox[3];
            var hasil = "/"+nox2+"/"+nox3+"/"+nox4;
            
            $("#no_sp2b").attr("value",nox1);
            $("#no_simpan_sp2b").attr("value",nomer_sp2b);
            $("#no_sp2b_tambahan").attr("value",hasil);
        }else{
            get_nomor_sp2b();
            nomer_sp2b_tmbh = "/SP2B/"+kode+"/"+tahun_anggaran;            
            $("#no_sp2b_tambahan").attr("value",nomer_sp2b_tmbh);
            	    
        }
        
        $("#no_sp3b").attr("value",nomer_sp3b);
        $("#no_simpan_sp3b").attr("value",nomer_sp3b);
        $("#cspp").combogrid("setValue",nomer_sp3b);
    		$("#dn").combogrid("setValue",kode);
    		$("#nmskpd").attr("Value",nmskpd);		
    		$("#dd").datebox("setValue",tglsp3b);
    		$("#dd_sp2b").datebox("setValue",tglsp2b);
    		$("#tgl_sp2d").attr("Value",'');	
            $("#hidd_sp2d").attr("Value",lpj);
    		$("#sp2d").combogrid("setValue",lpj);
    		$("#keterangan").attr("Value",cket);

        tombol(st);           
        }
	

        
		
        function kosong(){
        $("#no_lpj").attr("value",'');
        $("#no_simpan").attr("value",'');
        $("#tgl_sp2d").attr("value",'');
        $("#dd").datebox("setValue",'');
        $("#sp2d").combogrid("setValue",'');
      $("#keterangan").attr("value",'');
	  $("#no_lpj").focus();
	  $("#rektotal").attr("value",0)
        
        $('#save').linkbutton('enable');
		

        st_12 = 'baru';
        detail_trans_kosong();


        lcstatus = 'tambah'
        }

		
    function getRowIndex(target){  
			var tr = $(target).closest('tr.datagrid-row');  
			return parseInt(tr.attr('datagrid-row-index'));  
		} 
       
    
    function cetak(){

        var no_sp2bb = document.getElementById('no_sp2b').value;
        var no_sp3b = document.getElementById('no_sp3b').value;
        var no_sp2bc = document.getElementById('no_sp2b_tambahan').value;
        var no_sp2bd = no_sp2bb + no_sp2bc;
        $("#cspp").combogrid("setValue",no_sp3b);
        $("#dialog-modal").dialog('open');


    } 
    
    function pilih_giat(nomer){
		$('#giat_print').combogrid({  
                panelWidth:600,  
                idField:'kd_kegiatan',  
                textField:'kd_kegiatan',  
                mode:'remote',
                url:'<?php echo base_url(); ?>index.php/tukd/load_giat_lpj', 
				queryParams:({ lpj:nomer }),
                columns:[[  
                    {field:'kd_kegiatan',title:'NIP',width:200},
                    {field:'nm_kegiatan',title:'Nama',width:400}
                ]]
            });
	}
	
	
    function keluar(){
        $("#dialog-modal").dialog('close');
    } 
    
    
    function keluar_no(){
        $("#dialog-modal-tr").dialog('close');
    }
      
    
    function cari(){
     var kriteria = document.getElementById("txtcari").value; 
        $(function(){ 
            $('#spp').edatagrid({
	       url: '<?php echo base_url(); ?>/index.php/tukd_pusk/load_sp3b_fktp',
         queryParams:({cari:kriteria})
        });        
     });
    }
    
     
    function section1(){
         $(document).ready(function(){    
             $('#section1').click();
         });
     }
     
    
    function section4(){
         $(document).ready(function(){    
             $('#section4').click();                                               
         });
     }
     
     
     function section5(){
         $(document).ready(function(){    
             $("#dialog-modal-tr").click();                                               
         });
     }
     
    function tambah_no(){
        judul = 'Input Data No Transaksi';
        $("#dialog-modal-tr").dialog({ title: judul });
        $("#dialog-modal-tr").dialog('open');
        
        document.getElementById("no_spp").focus();
        
        if ( st_12 == 'baru' ){
        $("#no1").attr("value",'');
        $("#no2").attr("value",'');
        $("#no3").attr("value",'');
        $("#no4").attr("value",'');
        $("#no5").attr("value",'');
        }
     }
     
     function tambah_no2(){
        judul = 'Input Data No Transaksi';
        $("#dialog-modal-tr").dialog({ title: judul });
        $("#dialog-modal-tr").dialog('open');
        document.getElementById("no_spp").focus();
        
        if ( st_12 == 'baru' ){
        $("#no1").attr("value",'');
        $("#no2").attr("value",'');
        $("#no3").attr("value",'');
        $("#no4").attr("value",'');
        $("#no5").attr("value",'');
        }
     } 
     
     function cetakup(cetak){
		 
		var no_sp2b = $('#cspp').combogrid('getValue');           
		var no_sp2b = no_sp2b.split("/").join("abcdefghij");				
		var no_sp2b = no_sp2b.split(" ").join("123456789");				
		var skpd   = kode; 
		var ttd1   = $("#ttd1").combogrid('getValue');
		 
		if(ttd1==''){
			alert('Penandatangan tidak boleh kosong!');
			exit();
		}		
		var ttd_1 =ttd1.split(" ").join("a");
		//var ttd_2 =ttd2.split(" ").join("a");
		
			var url    = "<?php echo site_url(); ?>/tukd_pusk/cetak_sp2b_fktp";  
			window.open(url+'/'+ttd_1+'/'+skpd+'/'+cetak+'/'+no_sp2b, '_blank');
			window.focus();
		
     }	 
	 
     function simpan(){        
        var nlpj      = document.getElementById('no_lpj').value;
        var no_simpan = document.getElementById('no_simpan').value;
   		var b      	  = $('#dd').datebox('getValue'); 
   		var sp2d  	  = $('#sp2d').combogrid('getValue'); 
	    var tgl_sp2d  = document.getElementById('tgl_sp2d').value;
	    var nket      = document.getElementById('keterangan').value;
		var d1  	  = (b.split("-").join("/"));
		var d2  	  = (tgl_sp2d.split("-").join("/"));
		var d1		  = new Date(d1);
		var d2		  = new Date(d2);
		var timeDiff  = (d1.getTime() - d2.getTime());
		var diffDays  = (timeDiff / (1000 * 3600 * 24));
		var tahun_input = b.substring(0, 4);
		if (tahun_input != tahun_anggaran){
			alert('Tahun tidak sama dengan tahun Anggaran');
			exit();
		}
		
		if (diffDays>30){
			alert("Tanggal LPJ Melebihi Batas Satu Bulan");
			exit();
		}
		if (diffDays<0){
			alert("Tanggal LPJ Harus Lebih besar dari tanggal Pencairan SP2D");
			exit();
		}
		if (nlpj == ''){
			alert("No LPJ harus terisi");
			exit();
		}
		
		
		//simpan Anguz
		if ( lcstatus == 'tambah' ) {
			$(document).ready(function(){
               // alert(csql);
                $.ajax({
                    type: "POST",   
                    dataType : 'json',                 
                    data: ({no:nlpj,tabel:'trhlpj',field:'no_lpj'}),
                    url: '<?php echo base_url(); ?>/index.php/tukd/cek_simpan',
                    success:function(data){                        
                        status_cek = data.pesan;
						if(status_cek==1){
						alert("Nomor Telah Dipakai!");
						document.getElementById("nomor").focus();
						exit();
						} 
						if(status_cek==0){
						alert("Nomor Bisa dipakai");
			
			//-----
			
			$(document).ready(function(){
			$.ajax({
				type: "POST",       
				dataType : 'json',         
				 url      : "<?php  echo base_url(); ?>index.php/tukd/simpan_hlpj_tu",
				data     : ({nlpj:nlpj,tgllpj:b,ket:nket,tgl_sp2d:tgl_sp2d,sp2d:sp2d}),
				beforeSend:function(xhr){
                $("#loading").dialog('open');
					},
				success:function(data){
				status = data;
				if (status == '0'){
				   $("#loading").dialog('close');
				   alert('Gagal Simpan...!!');
				   exit();
				} else if (status !='0'){ 
				
		        $('#dg1').datagrid('selectAll');
				var rows = $('#dg1').datagrid('getSelections'); 
				for(var i=0;i<rows.length;i++){            
						cidx      = rows[i].idx;
						cnobukti1 = rows[i].no_bukti;
						ckdgiat   = rows[i].kdkegiatan;
						cnmgiat   = rows[i].nmkegiatan;
						ckdrek    = rows[i].kdrek5;
						cnmrek    = rows[i].nmrek5;
						cnilai    = angka(rows[i].nilai1);
						no        = i + 1 ; 
						if (i>0) {
							csql = csql+","+"('"+nlpj+"','"+cnobukti1+"','"+b+"','"+nket+"','"+ckdgiat+"','"+ckdrek+"','"+cnmrek+"','"+cnilai+"','"+kode+"')";
						} else {
							csql = "values('"+nlpj+"','"+cnobukti1+"','"+b+"','"+nket+"','"+ckdgiat+"','"+ckdrek+"','"+cnmrek+"','"+cnilai+"','"+kode+"')";                                            
							}                                             
						}   	                  
						$(document).ready(function(){
							//alert(csql);
							//exit();
							$.ajax({
								type: "POST",   
								dataType : 'json',                 
								data: ({nlpj:nlpj,sql:csql}),
								url: '<?php echo base_url(); ?>/index.php/tukd/simpan_lpj',
								success:function(data){                        
									status = data.pesan;   
									 if (status=='1'){
										$("#loading").dialog('close');
										alert('Data Berhasil Tersimpan...!!!');
										$("#no_simpan").attr("value",nlpj);
										lcstatus='edit';
										//$("#no_simpan").attr("value",cnokas);
									} else{ 
										$("#loading").dialog('close');
										lcstatus='tambah';
										alert('Detail Gagal Tersimpan...!!!');
									}                                             
								}
							});
							});            
						}
		//Akhir
				}
			});
		});
		//----
		 }
		}
		});
		});
		
		}
		//else
		 else{
			$(document).ready(function(){
               // alert(csql);
                $.ajax({
                    type: "POST",   
                    dataType : 'json',                 
                    data: ({no:nlpj,tabel:'trhlpj',field:'no_lpj'}),
                    url: '<?php echo base_url(); ?>/index.php/tukd/cek_simpan',
                    success:function(data){                        
                        status_cek = data.pesan;
						if(status_cek==1 && nlpj!=no_simpan){
						alert("Nomor Telah Dipakai!");
						exit();
						} 
						if(status_cek==0 || nlpj==no_simpan){
						alert("Nomor Bisa dipakai");
		//---------			
			$(document).ready(function(){
			$.ajax({
				type: "POST",       
				dataType : 'json',         
				url      : "<?php  echo base_url(); ?>index.php/tukd/update_hlpj_tu",
				data     : ({nlpj:nlpj,tgllpj:b,ket:nket,tgl_sp2d:tgl_sp2d,sp2d:sp2d,no_simpan:no_simpan}),
				beforeSend:function(xhr){
                $("#loading").dialog('open');
					},
				success:function(data){
				status = data;
				if (status=='0'){
				   $("#loading").dialog('close');
				   alert('Gagal Simpan...!!');
				   exit();
				} else if (status !='0'){ 
				
		        $('#dg1').datagrid('selectAll');
				var rows = $('#dg1').datagrid('getSelections'); 
				for(var i=0;i<rows.length;i++){            
						cidx      = rows[i].idx;
						cnobukti1 = rows[i].no_bukti;
						ckdgiat   = rows[i].kdkegiatan;
						cnmgiat   = rows[i].nmkegiatan;
						ckdrek    = rows[i].kdrek5;
						cnmrek    = rows[i].nmrek5;
						cnilai    = angka(rows[i].nilai1);
						no        = i + 1 ; 
						if (i>0) {
							csql = csql+","+"('"+nlpj+"','"+cnobukti1+"','"+b+"','"+nket+"','"+ckdgiat+"','"+ckdrek+"','"+cnmrek+"','"+cnilai+"','"+kode+"')";
						} else {
							csql = "values('"+nlpj+"','"+cnobukti1+"','"+b+"','"+nket+"','"+ckdgiat+"','"+ckdrek+"','"+cnmrek+"','"+cnilai+"','"+kode+"')";                                            
							}                                            
						}   	                  
						$(document).ready(function(){
							//alert(csql);
							//exit();
							$.ajax({
								type: "POST",   
								dataType : 'json',                 
								data: ({nlpj:nlpj,sql:csql,no_simpan:no_simpan}),
								url: '<?php echo base_url(); ?>/index.php/tukd/simpan_lpj_update',
								success:function(data){                        
									status = data.pesan;   
									 if (status=='1'){
										$("#loading").dialog('close');
										alert('Data Berhasil Tersimpan...!!!');
										$("#no_simpan").attr("value",nlpj);
										lcstatus='edit';
										//$("#no_simpan").attr("value",cnokas);
									} else{ 
										$("#loading").dialog('close');
										lcstatus='tambah';
										alert('Detail Gagal Tersimpan...!!!');
									}                                             
								}
							});
							});            
						}
		//Akhir
				}
			});
		});
		//-----
		}
			}
			});
		});
			
		}
	 }
		
	
    function dsimpan(){
        var a = document.getElementById('no_spp').value;
        $(function(){      
         $.ajax({
            type: 'POST',
            data: ({cno_spp:a}),
            dataType:"json",
            url:"<?php echo base_url(); ?>index.php/tukd/dsimpan_spp"            
         });
        });
    } 
    
    
    function detsimpan(){

        var a      = document.getElementById('no_spp').value; 
        var a_hide = document.getElementById('no_spp_hide').value; 
        
        $(document).ready(function(){      
           $.ajax({
           type     : 'POST',
           url      : "<?php  echo base_url(); ?>index.php/tukd/dsimpan_hapus",
           data     : ({cno_spp:a_hide,lcid:a,lcid_h:a_hide}),
           dataType : "json",
           success  : function(data){
                        status = data;
                        if (status=='0'){
                            alert('Gagal Hapus Detail Old');
                            exit();
                        } 
                        }
                        });
        });
        
        $('#dg1').datagrid('selectAll');
        var rows = $('#dg1').datagrid('getSelections');
        
        for(var i=0;i<rows.length;i++){            
            
            cidx      = rows[i].idx;
            cnobukti1 = rows[i].no_bukti;
            ckdgiat   = rows[i].kdkegiatan;
            cnmgiat   = rows[i].nmkegiatan;
            ckdrek    = rows[i].kdrek5;
            cnmrek    = rows[i].nmrek5;
            cnilai    = angka(rows[i].nilai1);
                       
            no        = i + 1 ;      
            
            $(document).ready(function(){      
            $.ajax({
            type     : 'POST',
            url      : "<?php  echo base_url(); ?>index.php/tukd/dsimpan",
            data     : ({cno_spp:a,cskpd:kode,cgiat:ckdgiat,crek:ckdrek,ngiat:cnmgiat,nrek:cnmrek,nilai:cnilai,kd:no,no_bukti1:cnobukti1}),
            dataType : "json"
        });
        });
        }
        $("#no_spp_hide").attr("Value",a) ;
        $('#dg1').edatagrid('unselectAll');
    } 
    
    

        
    
    function kembali(){
        $('#kem').click();
    }                
    
    
     function load_sum_lpj(no_lpjx,kode){          
        
        $(function(){      
         $.ajax({
            type: 'POST',
            url:"<?php echo base_url(); ?>index.php/tukd_pusk/jumlah_belanjasp3b",
            data:({no:no_lpjx,skpd:kode}),
            dataType:"json",
            success:function(data){ 
                $.each(data, function(i,n){
                    
                    $("#rektotal").attr('value',number_format(n['nilai'],2,'.',','));
                  //  $("#rektotal1").attr('value',number_format(n['rektotal'],2,'.',','));
                });
            }
         });
        });
    }
    
    
    function load_sum_tran(){                
        $(function(){      
         $.ajax({
            type: 'POST',
            data:({no_bukti:no_bukti}),
            url:"<?php echo base_url(); ?>index.php/tukd/load_sum_tran",
            dataType:"json",
            success:function(data){ 
                $.each(data, function(i,n){
                    //$("#rektotal").attr("value",n['rektotal']);
                    //$("#rektotal1").attr("value",n['rektotal1']);
                    $("#rektotal").attr('value',number_format(n['rektotal'],2,'.',','));
                    $("#rektotal1").attr('value',number_format(n['rektotal'],2,'.',','));

                });
            }
         });
        });
    }
   
   
    function tombol(status_lpj){
    if (status_lpj=='1') {
        document.getElementById("p1").innerHTML="SP3B SUDAH DI SETUJUI !!";
		document.getElementById("btcair").value="BATAL SETUJU";        
        $('#idcetak').linkbutton('enable');
     } else {
        document.getElementById("p1").innerHTML="";
		document.getElementById("btcair").value="SETUJU";
        $('#idcetak').linkbutton('disable');
	 }
    }	
    
        
    function openWindow(url)
    {
        var vnospp  =  $("#cspp").combogrid("getValue");
         
		        lc  =  "?nomerspp="+vnospp+"&kdskpd="+kode+"&jnsspp="+jns ;
        window.open(url+lc,'_blank');
        window.focus();
    }
    
        
    function detail_trans_3(){
        
        $(function(){
			$('#dg1').edatagrid({
				url: '<?php echo base_url(); ?>/index.php/tukd_pusk/select_data1_lpj_ag',
                queryParams:({ lpj:no_lpjx,kdskpd: kode }),
                 idField:'idx',
                 toolbar:"#toolbar",              
                 rownumbers:"true", 
                 fitColumns:false,
                 autoRowHeight:"false",
                 singleSelect:"true",
                 nowrap:"true",				 
				columns:[[
                     {field:'idx',
					 title:'idx',
					 width:100,
					 align:'left',
                     hidden:'true'
					 },
                    {field:'uraian',title:'Uraian',width:600,align:'right'},                                          
                    {field:'nilai',title:'Nilai',width:200,align:'right'}
				]]	
			});
		});
        }
        

        function detail_trans_kosong(){
        var no_kos = '' ;
        $(function(){
			$('#dg1').edatagrid({
				url: '<?php echo base_url(); ?>/index.php/tukd_pusk/select_data1_lpj_ag',
                queryParams:({ lpj:no_kos,kdskpd: kode }),
                 idField:'idx',
                 toolbar:"#toolbar",              
                 rownumbers:"true", 
                 fitColumns:false,
                 autoRowHeight:"false",
                 singleSelect:"true",
                 nowrap:"true",
                 columns:[[
                     {field:'idx',
					 title:'idx',
					 width:100,
					 align:'left',
                     hidden:'true'
					 },               
                    {field:'uraian',title:'Uraian',width:600,align:'right'},                                          
                    {field:'nilai',title:'Nilai',width:200,align:'right'}
				]]	
			});
		});
        }
    
   
    
    function hapus_detail(){
        
        var a          = document.getElementById('no_lpj').value;
        var rows       = $('#dg1').edatagrid('getSelected');
        var ctotal_lpj = document.getElementById('rektotal').value;
        
        bbukti      = rows.no_bukti;
        bkdrek      = rows.kdrek5;
        bkdkegiatan = rows.kdkegiatan;
        bnilai      = rows.nilai1;
        ctotal_lpj  = angka(ctotal_lpj) - angka(bnilai) ;
        
        var idx = $('#dg1').edatagrid('getRowIndex',rows);
        var tny = confirm('Yakin Ingin Menghapus Data, No Bukti :  '+bbukti+'  Rekening :  '+bkdrek+'  Nilai :  '+bnilai+' ?');
        
        if ( tny == true ) {
            
            $('#rektotal').attr('value',number_format(ctotal_lpj,2,'.',','));
            $('#dg1').datagrid('deleteRow',idx);     
            $('#dg1').datagrid('unselectAll');
              
             var urll = '<?php echo base_url(); ?>index.php/tukd/dsimpan_lpj';
             $(document).ready(function(){
             $.post(urll,({cnolpj:a,cnobukti:bbukti}),function(data){
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
        }     
    }
    
  function hhapus(){				
            var lpj = document.getElementById("no_lpj").value;     
            var urll= '<?php echo base_url(); ?>/index.php/tukd/hhapuslpj';             			    
         	if (spp !=''){
				var del=confirm('Anda yakin akan menghapus LPJ '+lpj+'  ?');
				if  (del==true){
					$(document).ready(function(){
                    $.post(urll,({no:lpj}),function(data){
                    status = data;                       
                    });
                    });				
				}
				} 
	}
  
    function hapus_detail_grid(){
        
        var a          = document.getElementById('no_lpj').value;
        var rows       = $('#dg1').edatagrid('getSelected');
        var ctotal_lpj = document.getElementById('rektotal').value;
        
        bbukti      = rows.no_bukti;
        bkdrek      = rows.kdrek5;
        bkdkegiatan = rows.kdkegiatan;
        bnilai      = rows.nilai1;
        ctotal_lpj  = angka(ctotal_lpj) - angka(bnilai) ;
        
        var idx = $('#dg1').edatagrid('getRowIndex',rows);
        var tny = confirm('Yakin Ingin Menghapus Data, No Bukti :  '+bbukti+'  Rekening :  '+bkdrek+'  Nilai :  '+bnilai+' ?');
        
        if ( tny == true ) {
            
            $('#rektotal').attr('value',number_format(ctotal_lpj,2,'.',','));
            $('#dg1').datagrid('deleteRow',idx);     
            $('#dg1').datagrid('unselectAll');
              
            // var urll = '<?php echo base_url(); ?>index.php/tukd/dsimpan_lpj';
//             $(document).ready(function(){
//             $.post(urll,({cnolpj:a,cnobukti:bbukti}),function(data){
//             status = data;
//                if (status=='0'){
//                    alert('Gagal Hapus..!!');
//                    exit();
//                } else {
//                    alert('Data Telah Terhapus..!!');
//                    exit();
//                }
//             });
//             });    
        }     
    }

	
  
    
    function load_data() {
		$('#dg1').datagrid('loadData', []);
        var no_sp2d      = $('#sp2d').combogrid('getValue') ;
        var kd_skpd      = $('#dn').combogrid('getValue') ;
        var ntotal_trans = 0;
        
        $(document).ready(function(){
            
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>/index.php/tukd/load_data_transaksi_lpj_tu',
                data: ({no_sp2d:no_sp2d,kdskpd:kd_skpd}),
                dataType:"json",
                success:function(data){                                          
                    $.each(data,function(i,n){                                    
                    xnobukti = n['no_bukti'];                                                                                        
                    xgiat    = n['kdkegiatan']; 
                    xkdrek5  = n['kdrek5'];
                    xnmrek5  = n['nmrek5'];
                    xnilai   = n['nilai1'];
                    
                    ntotal_trans = ntotal_trans + angka(xnilai) ;
                    
                    $('#dg1').edatagrid('appendRow',{no_bukti:xnobukti,kdkegiatan:xgiat,kdrek5:xkdrek5,nmrek5:xnmrek5,nilai1:xnilai,idx:i}); 
                    $('#dg1').edatagrid('unselectAll');
                    $('#rektotal').attr('value',number_format(ntotal_trans,2,'.',','));
                    });
                 }
            });
            });   
    }
	
	function cetaktu1(cetak)
        {
			var no_sp2d  = $('#nosp2d').combogrid('getValue');   
            var no_sp2d =no_sp2d.split("/").join("abcdefghij");
			var no_lpj = $('#cspp').combogrid('getValue');   
            var no_lpj = no_lpj.split("/").join("abcdefghij");				
			var skpd   = kode; 
			var ctglttd = $('#tgl_ttd').datebox('getValue');
			var ttd1   = $("#ttd1").combogrid('getValue');
			var ttd2   = $("#ttd2").combogrid('getValue'); 
			if(ctglttd==''){
			alert('Tanggal tidak boleh kosong!');
			exit();
			}
			if(ttd1==''){
				alert('Bendahara Pengeluaran tidak boleh kosong!');
				exit();
			}
			if(ttd2==''){
				alert('Pengguna Anggaran tidak boleh kosong!');
				exit();
			}
			var ttd_1 =ttd1.split(" ").join("a");
			var ttd_2 =ttd2.split(" ").join("a");
			var url    = "<?php echo site_url(); ?>/tukd/cetaklpjtu_ag";  
			window.open(url+'/'+no_sp2d+'/'+ttd_1+'/'+skpd+'/'+cetak+'/'+ctglttd+'/'+ttd_2+'/'+no_lpj+'/LPJ-TU', '_blank');
			window.focus();
        }
		
		function cetaktu2(cetak){
			var no_sp2d  = $('#nosp2d').combogrid('getValue');   
            var no_sp2d =no_sp2d.split("/").join("abcdefghij");
			var no_lpj = $('#cspp').combogrid('getValue');   
            var no_lpj = no_lpj.split("/").join("abcdefghij");	
			var skpd   = kode; 
			var ctglttd = $('#tgl_ttd').datebox('getValue');
			var ttd1   = $("#ttd1").combogrid('getValue');
			var ttd2   = $("#ttd2").combogrid('getValue'); 
			if(ctglttd==''){
			alert('Tanggal tidak boleh kosong!');
			exit();
			}
			if(ttd1==''){
				alert('Bendahara Pengeluaran tidak boleh kosong!');
				exit();
			}
			if(ttd2==''){
				alert('Pengguna Anggaran tidak boleh kosong!');
				exit();
			}
			var ttd_1 =ttd1.split(" ").join("a");
			var ttd_2 =ttd2.split(" ").join("a");
			var url    = "<?php echo site_url(); ?>/tukd/cetaklpjtusptb";  
			window.open(url+'/'+no_sp2d+'/'+ttd_1+'/'+skpd+'/'+cetak+'/'+ctglttd+'/'+ttd_2+'/'+no_lpj+'/LPJ-TU', '_blank');
			window.focus();
        }
	
	function setuju(){
		var cap=document.getElementById("btcair").value;
		if (cap=='SETUJU'){
			simpan_setuju();
			
		}else{
			batal_setuju();
		}
	}
	
	function simpan_setuju(){
		var no_sp3bb = document.getElementById('no_sp3b').value;
        var no_sp2bb = document.getElementById('no_sp2b').value;
        var no_sp2bc = document.getElementById('no_sp2b_tambahan').value;
        var no_sp2bd = no_sp2bb+no_sp2bc;
        var tgl      = $('#dd_sp2b').datebox('getValue');
		$(function(){      
			 $.ajax({
				type: 'POST',
				data: ({no_sp3b:no_sp3bb,kd_skpd:kode,tgl_sah:tgl,no_sp2b:no_sp2bd,number_sp2b:no_sp2bb}),
				dataType:"json",
				url:"<?php echo base_url(); ?>index.php/tukd_pusk/setuju_sp3b",
				success:function(data){
					if (data = 2){
						alert('SP3B telah disetujui');
						document.getElementById("p1").innerHTML="SP3B SUDAH DISETUJUI!!";
						document.getElementById("btcair").value="BATAL SETUJU";
                        $('#idcetak').linkbutton('enable');
					}
				}
			 });
			});
	}
	
	function batal_setuju(){
		var no_sp3bb = document.getElementById('no_sp3b').value;
        var no_sp2bb = document.getElementById('no_sp2b').value;
        var no_sp2bc = document.getElementById('no_sp2b_tambahan').value;
        var no_sp2bd = no_sp2bb+no_sp2bc;
        var tgl      = $('#dd').datebox('getValue');
		$(function(){      
			 $.ajax({
				type: 'POST',
				data: ({no_sp3b:no_sp3bb,kd_skpd:kode,tgl_sah:tgl,no_sp2b:no_sp2bd}),
				dataType:"json",
				url:"<?php echo base_url(); ?>index.php/tukd_pusk/batalsetuju_sp3b",
				success:function(data){
					if (data = 2){
						alert('SP3B telah dibatalkan');
						document.getElementById("p1").innerHTML="SP3B TELAH DIBATALKAN!!";
						document.getElementById("btcair").value="SETUJU";
                        $('#idcetak').linkbutton('disable');
                        $("#no_sp2b").attr("value",'');
                        $("#no_simpan_sp2b").attr("value",'');
                        $("#no_sp2b_tambahan").attr("value",'');
                        section4();
					}
				}
			 });
			});
	}

  function cetaksp3b(ctk)
        { 
      var nosp3b = document.getElementById('no_sp3b').value;//$('#cmb_sp3b').combogrid('getValue');
      nosp3b = nosp3b.split("/").join("hhh");
      var skpd   = $('#dn').combogrid('getValue'); 
      var bulan   =  document.getElementById('bulan').value;
      var ctglttd = $('#dd').datebox('getValue');
      var pusk = $('#dn').combogrid('getValue');        
      var  ttd2 = $('#ttd1').combogrid('getValue');
        ttd2 = ttd2.split(" ").join("123456789");
      var atas   =  "15";
      var bawah   =  "15";
      var kanan   =  "15";
      var kiri   =  "15";
      var sp3b = "Cetak SP3B";

      var url    = "<?php echo site_url(); ?>/tukd_pusk/cetak_sp3b_blud";  
      if(bulan==0){
      alert('Pilih Bulan dulu')
      exit()
      }
      if(ctglttd==''){
      alert('Pilih Tanggal tanda tangan dulu')
      exit()
      }     
      if(ttd2==''){
      alert('Pilih Pengguna Anggaran dulu')
      exit()
      }
      if(pusk==''){
      alert('Pilih FKTP dulu')
      exit()
      }
      
      window.open(url+'/'+skpd+'/'+bulan+'/'+ctk+'/'+pusk+'/'+ttd2+'/'+ctglttd+'/'+atas+'/'+bawah+'/'+kiri+'/'+kanan+'/'+nosp3b+'/'+sp3b, '_blank');
      window.focus();
        }	
	function validate_jenis() {
		var jns   =  document.getElementById('jenis').value;
		 if (jns=='2') {
			$("#div1").show();
		} else {
			$("#div1").hide();
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
<div id="accordion" style="width:970px;height=1000px;" >
<h3><a href="#" id="section4" onclick="javascript:$('#spp').edatagrid('reload')">List SP3B </a></h3>
<div>
    <p align="right">  
        <a class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="javascript:cari();">Cari</a>
        <input type="text" value="" id="txtcari"/>
        <table id="spp" title="List SP3B" style="width:910px;height:450px;" >  
        </table>
		<font color="blue"><b>*) Warna biru menunjukkan sudah disetujui oleh Perbendaharaan</b></font> 
    </p> 
</div>

<h3><a href="#" id="section1">Input SP2B</a></h3>

   <div  style="height: 350px;">
   <p id="p1" style="font-size: x-large;color: red;"></p>
   <p>

<fieldset style="width:850px;height:650px;border-color:white;border-style:hidden;border-spacing:0;padding:0;">            
<table border='0' style="font-size:11px" >
	
   <INPUT TYPE="button" name="btback" id="btback" VALUE="KEMBALI" ONCLICK="javascript:section4();" style="height:40px;width:120px">			   	 
   <INPUT TYPE="button" name="btcair" id="btcair" VALUE="SETUJU" ONCLICK="setuju()" style="height:40px;width:120px">		
	
   <tr style="border-bottom-style:hidden;border-spacing:0px;padding:3px 3px 3px 3px;border-collapse:collapse;">
   <td  width='20%'>No SP2B</td>
   <td width='80%'><input type="text" name="no_sp2b" id="no_sp2b" style="width:50px" /> <input type="text" name="no_sp2b_tambahan" id="no_sp2b_tambahan" style="width:189px" readonly="true" />
   <input type="hidden" name="no_simpan_sp2b" id="no_simpan_sp2b" style="width:225px" disabled />
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   Tanggal SP2B 
   &nbsp;<input id="dd_sp2b" name="dd_sp2b" type="text" style="width:95px"/>
   </td>
   </tr>
   <tr style="border-bottom-style:hidden;border-spacing:0px;padding:3px 3px 3px 3px;border-collapse:collapse;">
   <td  width='20%'>No SP3B</td>
   <td width='80%'><input type="text" name="no_sp3b" id="no_sp3b" style="width:250px" readonly="true"/> 
   <input type="hidden" name="no_simpan_sp3b" id="no_simpan_sp3b" style="width:225px" disabled />
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   Tanggal SP3B
   &nbsp;<input id="dd" name="dd" type="text" style="width:95px"/>
   </td>
   	<tr style="border-bottom-style:hidden;border-spacing:0px;padding:3px 3px 3px 3px;border-collapse:collapse;">
   <td width='20%'>SKPD</td>
   <td width="80%">     
        <input id="dn" name="dn"  readonly="true" style="width:110px; border: 0; " />
        <input id="bulan" name="bulan"  hidden readonly="true" style="width:110px; border: 0; " />
        &nbsp; <input id="nmskpd" name="nmskpd"  readonly="true" style="width:480px; border: 0; " />                   
        </td> 
	</tr>
   <tr style="border-bottom-style:hidden;border-spacing:0px;padding:3px 3px 3px 3px;border-collapse:collapse;">
   <td  width='20%'>No. LPJ JKN</td>
   <td width='80%'><input type="text" name="sp2d" id="sp2d"  style="width:225px" disabled />
   <input type="hidden" name="hidd_sp2d" id="hidd_sp2d"  style="width:225px" />
	  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="tgl_sp2d" name="tgl_sp2d" type="text" style="width:95px;border:0" />
   </td>
   </tr>  
  <tr>
  
   
      <td width='20%'  style="border-right-style:hidden;border-bottom-style:hidden;border-spacing:0px;padding:3px 3px 3px 3px;border-collapse:collapse;">KETERANGAN</td>
     <td width='31%' style="border-bottom-style:hidden;border-spacing:0px;padding:3px 3px 3px 3px;border-collapse:collapse;"><textarea name="keterangan" id="keterangan" style="width: 400px; height: 150px"></textarea></td>
  
  </tr>
   
   
   
 <tr style="border-bottom-style:hidden;border-spacing:0px;padding:3px 3px 3px 3px;border-collapse:collapse;">
 
   <td width='20%'></td>
   <td width="80%">&nbsp;</td> 
 <tr style="height: 30px;">
	<td colspan="4">
		<div align="right">
			<a class="easyui-linkbutton" id="idcetak" iconCls="icon-print" plain="true" onclick="javascript:cetak();">Cetak</a>
		</div>
	</td>
 </tr>
		
  </table>
   
        <table id="dg1" title="LPJ JKN" style="width:900%;height:200px;" >  
        </table>
        
         
        <table border='0' style="width:100%;height:5%;"> 
             <td width='34%'></td>
             <td width='28%'><input class="right" type="hidden" name="rektotal1" id="rektotal1"  style="width:140px" align="right" readonly="true" ></td>
             <td width='10%'><B>Total Saldo</B></td>
             <td width='28%'><input class="right" type="text" name="rektotal" id="rektotal"  style="width:200px" align="right" readonly="true" ></td>
        </table>

   </p>

</fieldset>     
</div>
</div>
</div> 
			<div id="loading" title="Loading...">
			<table align="center">
			<tr align="center"><td><img id="search1" height="50px" width="50px" src="<?php echo base_url();?>/image/loadingBig.gif"  /></td></tr>
			<tr><td>Loading...</td></tr>
			</table>
			</div>

<div id="dialog-modal" title="CETAK SP2B">	  
    <fieldset>
        <table>
            <tr>            
                <td width="200px" >NO SP2B:</td>
                <td><input id="cspp" name="cspp" style="width: 200px;" /></td>
            </tr>
            <tr >
				<td>Penandatangan:</td>
				<td><input type="text" id="ttd1" style="width:200px" /></td>&nbsp;&nbsp;
				<td><input type="text" id="nm_ttd1" readonly="true" style="width:150px;border:0" /></td>
			</tr>			
			<tr>
				<td colspan="3">
					<div id="div1">
						<table style="width:100%;" border="0">
							<td width="200px"></td>
							<td><input id="giat_print" style="width: 200px;"/></td>
						</table>
					</div>
				</td>
			</tr>
        </table>  
    </fieldset>
	<div>
	</div>
	
	<a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetaksp3b(0);">Cetak Layar</a>
	<br/>
	<a class="easyui-linkbutton" iconCls="icon-pdf" plain="true" onclick="javascript:cetaksp3b(1);">Cetak PDF</a>      
    <a class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:keluar();">Keluar</a>
</div>

 	
<div id="dialog-modal-tr" title="">
    <p class="validateTips">Pilih Nomor Transaksi</p> 
    <fieldset>
    <table align="center" style="width:100%;" border="1">
            
            <tr>
                <td>1. No Transaksi</td>
                <td></td>
                <td><input id="no1" name="no1" style="width: 320px;" />  </td>                            
            </tr>
            
            <tr>
                <td>2. No Transaksi</td>
                <td></td>
                <td><input id="no2" name="no2" style="width: 320px;" />  </td>                            
            </tr>
            
            <tr>
                <td>3. No Transaksi</td>
                <td></td>
                <td><input id="no3" name="no3" style="width: 320px;" />  </td>                            
            </tr>
            
            <tr>
                <td>4. No Transaksi</td>
                <td></td>
                <td><input id="no4" name="no4" style="width: 320px;" />  </td>                            
            </tr>
            
            <tr>
                <td>5. No Transaksi</td>
                <td></td>
                <td><input id="no5" name="no5" style="width: 320px;" />  </td>                            
            </tr>
            
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>                            
            </tr>
            
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>                            
            </tr>
            
            <tr>
                <td colspan="3" align="center"><a class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:detail_trans_2();">Pilih</a>
		        <a class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:keluar_no();">Kembali</a>
                </td>                
            </tr>
        
    </table>       
    </fieldset>
</div>
</body>
</html>