

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
	var kdskpd='';
        
     $(document).ready(function() {
            
        });
    
     $(function(){ 
        
       $("#div_bulan").hide();
       $("#div_periode").hide(); 
      
       $('#tgl1').datebox({  
            required:true,
            formatter :function(date){
            	var y = date.getFullYear();
            	var m = date.getMonth()+1;
            	var d = date.getDate();
            	return y+'-'+m+'-'+d;
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
        
        $('#tgl2').datebox({  
            required:true,
            formatter :function(date){
            	var y = date.getFullYear();
            	var m = date.getMonth()+1;
            	var d = date.getDate();
            	return y+'-'+m+'-'+d;
            }
        });
    
      $('#sskpd').combogrid({  
			panelWidth:900,  
			idField:'kd_skpd',  
			textField:'kd_skpd',  
			mode:'remote',
			url:'<?php echo base_url(); ?>index.php/akuntansi/skpd',  
			columns:[[  
				{field:'kd_skpd',title:'Kode SKPD',width:180},  
				{field:'nm_skpd',title:'Nama SKPD',width:700}    
			]],
			onSelect:function(rowIndex,rowData){
				kdskpd = rowData.kd_skpd;
				$("#nmskpd").attr("value",rowData.nm_skpd);
				$("#skpd").attr("value",rowData.kd_skpd);
			    cek_ttd(kdskpd);
			}  
		}); 
       
       $('#bulan').combogrid({  
           panelWidth:120,
           panelHeight:300,  
           idField:'bln',  
           textField:'nm_bulan',  
           mode:'remote',
           url:'<?php echo base_url(); ?>index.php/rka/bulan',  
           columns:[[ 
               {field:'nm_bulan',title:'Nama Bulan',width:700}    
           ]] 
       });
              
      
    });        

     $(function(){
    	$('#ttd').combogrid({  
    		panelWidth:500,  
    		url: '<?php echo base_url(); ?>/index.php/tukd/list_ttd',  
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
	   
	   
	 
    
     function cetak(){
        $("#dialog-modal").dialog('close');
     } 
     
     function cek_ttd(kdskpd){ 
			$('#ttd1').combogrid({  
				panelWidth:500,  
				url:'<?php echo base_url(); ?>index.php/tukd/load_ttd_bku/pa/'+kdskpd,      
				  idField:'nip',                    
				  textField:'nip',
				  mode:'remote',  
				  fitColumns:true,  
				  columns:[[  
					{field:'nip',title:'NIP',width:180},  
					{field:'nama',title:'NAMA',align:'left',width:300}                
				  ]],
				  onSelect:function(rowIndex,rowData){
				  nip = rowData.nip;					  
				  }   
			});
			
			$('#ttd2').combogrid({  
				panelWidth:500,  
				url:'<?php echo base_url(); ?>index.php/tukd/load_ttd_bku/bk/'+kdskpd,      
				  idField:'nip',                    
				  textField:'nip',
				  mode:'remote',  
				  fitColumns:true,  
				  columns:[[  
					{field:'nip',title:'NIP',width:180},  
					{field:'nama',title:'NAMA',align:'left',width:300}                
				  ]],
				  onSelect:function(rowIndex,rowData){
				  nip = rowData.nip;					  
				  }   
			});          
	} 
     
     function openWindow( url ){
           var ckdskpd = $('#sskpd').combogrid('getValue');
		   var  ttd = $('#ttd1').combogrid('getValue');
           var ttd = ttd.split(" ").join("123456789");
		   var  ttd2 = $('#ttd2').combogrid('getValue');
           var ttd2 = ttd2.split(" ").join("123456789");

             ctglttd = $('#tgl_ttd').datebox('getValue');
         if(ctk==1){
            ctgl1 = $('#tgl1').datebox('getValue');
            ctgl2 = $('#tgl2').datebox('getValue');
            lc = '?kd_skpd='+ckdskpd+'&tgl1='+ctgl1+'&tgl2='+ctgl2+'&tgl_ttd='+ctglttd+'&ttd='+ttd+'&ttd2='+ttd2+'&cpilih=1'+'&ttd3='+ttd3;
         }else{
            cbulan = $('#bulan').combogrid('getValue');
            lc = '?kd_skpd='+ckdskpd+'&bulan='+cbulan+'&tgl_ttd='+ctglttd+'&ttd='+ttd+'&ttd2='+ttd2+'&cpilih=2'+'&ttd3='+ttd3;
         }
         window.open(url+lc,'_blank');
         window.focus();
         //window.open(url+'/'+ckdskpd+'/'+ctgl1+'/'+ctgl2+'/'+tglttd, '_blank');
         //'window.focus();
     }  
     
     function opt(val){        
        ctk = val; 
        if (ctk=='1'){
            $("#div_bulan").hide();
            $("#div_periode").show();
        } else if (ctk=='2'){
            $("#div_bulan").show();
            $("#div_periode").hide();
            } else {
            exit();
        }                 
    }     
    
    function coba(){
        var bln1 = $('#bulan1').combogrid('getValue');
        alert(bln1);
    }
	
	function cek($cetak){
		var  ttd = $('#ttd1').combogrid('getValue');
		var  ttd_2 = $('#ttd2').combogrid('getValue');
		//var  ttd_3 = $('#ttd3').combogrid('getValue');
		ctglttd = $('#tgl_ttd').datebox('getValue');
		cbulan = $('#bulan').combogrid('getValue');
		ctgl1 = $('#tgl1').datebox('getValue');
		ctgl2 = $('#tgl2').datebox('getValue');
	 
		var atas   =  document.getElementById('atas').value;
		var bawah   =  document.getElementById('bawah').value;
		var kanan   =  document.getElementById('kanan').value;
		var kiri   =  document.getElementById('kiri').value;
			
		url="<?php echo site_url(); ?>/tukd/cetak_bku_skpd/"+$cetak+"/"+atas+"/"+bawah+"/"+kiri+"/"+kanan;	
			
		if(ctk==''){
		alert("Pilih Periode atau Bulan Terlebih Dahulu");
		exit();
		} 
		else if (ctk==2 && cbulan==''){
		alert("Pilih Bulan Terlebih Dahulu")
		}
		else if (ctk==1 && ctgl1=='' && ctgl2==''){
		alert("Pilih Tanggal Periode Terlebih Dahulu")
		}
		else if (ctglttd==''){
		alert("Pilih Tanggal Tanda Tangan Terlebih Dahulu")
		}
		else if (ttd==''){
		alert("Pilih Penanda Tangan  Terlebih Dahulu")
		}
		else if (ttd_2==''){
		alert("Pilih Penanda Tangan  Terlebih Dahulu")
		}
		else {
		openWindow( url );
		}

	}
	
  
   </script>


<div id="content1" align="center"> 
    <h3 align="center"><b>CETAK LAPORAN BUKU KAS UMUM<br>
    (BKU)</b></h3>
    <fieldset style="width: 70%;">
     <table align="center" style="width:100%;" border="0">
            <tr>
                <td><input type="radio" name="cetak" value="1" onclick="opt(this.value)" />Periode &ensp;
                <input type="radio" name="cetak" value="2" id="status" onclick="opt(this.value)" />Bulan
                </td>
                <td>&ensp;</td>
                <td>&nbsp</td>
            </tr>
            <tr>
                <td colspan="3">&nbsp</td>
            </tr>
            <tr>
                <td colspan="3">
                <div id="div_skpd">
                        <table style="width:100%;" border="0">
							<tr >
								<td width="20%" height="10%" >SKPD</td>
								<td width="80%"><input id="sskpd" name="sskpd" style="width: 150px;" />&nbsp;&nbsp;<input id="nmskpd" name="nmskpd" style="width: 550px; border:0;" readonly /></td>
								</tr>
						</table> 
                </div>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                 <div id="div_bulan">
                        <table style="width:100%;" border="0">
                            <td width="20%">BULAN</td>
                            <td width="1%">:</td>
                            <td width="79%"><input id="bulan" name="bulan" style="width: 100px;" />
                            </td>
                        </table>
                </div>
                <div id="div_periode">
                        <table style="width:100%;" border="0">
                            <td width="20%">PERIODE</td>
                            <td width="1%">:</td>
                            <td width="79%"><input type="text" id="tgl1" style="width: 100px;" /> s.d. <input type="text" id="tgl2" style="width: 100px;" />
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
		<td colspan="4">
                <div id="div_bend">
                        <table style="width:100%;" border="0">
                            <tr>
							<td width="20%">Pengguna Anggaran</td>
                            <td width="1%">:</td>
                            <td><input type="text" id="ttd1" style="width: 200px;" /> 
                            </td> 
							</tr>
							
							<tr>
							<td width="20%">Bendahara Pengeluaran</td>
                            <td width="1%">:</td>
                            <td><input type="text" id="ttd2" style="width: 200px;" /> 
							
							<td hidden width="20%">Bendahara Pengeluaran Pembantu</td>
                            <td hidden width="1%">:</td>
                            <td hidden><input type="text" id="ttd3" style="width: 100px;" /> 
                            </td>
							</tr>	
                        </table>
                </div>
        </td> 
		</tr>
     		<tr >
    			<td colspan='2'width="100%" height="40" ><strong>Ukuran Margin Untuk Cetakan PDF (Milimeter)</strong></td>
    		</tr>
    		<tr >
    			<td colspan='2'> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    			Kiri  : &nbsp;<input type="number" id="kiri" name="kiri" style="width: 50px; border:1" value="15" /> &nbsp;&nbsp;
    			Kanan : &nbsp;<input type="number" id="kanan" name="kanan" style="width: 50px; border:1" value="15" /> &nbsp;&nbsp;
    			Atas  : &nbsp;<input type="number" id="atas" name="atas" style="width: 50px; border:1" value="15" /> &nbsp;&nbsp;
    			Bawah : &nbsp;<input type="number" id="bawah" name="bawah" style="width: 50px; border:1" value="15" /> &nbsp;&nbsp;
    			</td>
    		</tr>
		
			<tr>
            <td colspan="3">&nbsp;</td>
            </tr>            
            <tr>
                <td colspan="3" align="center">
				<!--<a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cek(0)">Cetak</a>-->
				<a class="easyui-linkbutton" iconCls="icon-pdf" plain="true" onclick="javascript:cek(1)">Cetak</a>
                </td>                
            </tr>
        </table>  
            
    </fieldset>  
</div>	
