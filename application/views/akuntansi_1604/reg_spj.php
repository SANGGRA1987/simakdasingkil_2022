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
            height: 550,
            width: 800,
            modal: true,
            autoOpen:false
        });
        });    
     
     $(function(){ 
        $('#kode').combogrid({  
           panelWidth:700,  
           idField:'kd_skpd',  
           textField:'kd_skpd',  
           mode:'remote',
           url:'<?php echo base_url(); ?>index.php/rka/skpd',  
           columns:[[  
               {field:'kd_skpd',title:'Kode SKPD',width:100},  
               {field:'nm_skpd',title:'Nama SKPD',width:700}    
           ]],  
           onSelect:function(rowIndex,rowData){
               kd = rowData.kd_skpd;               
               $("#nmskpd").attr("value",rowData.nm_skpd.toUpperCase());                
           }  
       });
	   
        $('#tgl_terima').datebox({  
            required:true,
            formatter :function(date){
            	var y = date.getFullYear();
            	var m = date.getMonth()+1;
            	var d = date.getDate();
            	return y+'-'+m+'-'+d;
            },
            onSelect: function(date){
		      jaka = date.getFullYear()+"-"+(date.getMonth()+1)+"-"+date.getDate();
	       }
        });
		
		$('#tgldpasempurna').datebox({  
            required:true,
            formatter :function(date){
            	var y = date.getFullYear();
            	var m = date.getMonth()+1;
            	var d = date.getDate();
            	return y+'-'+m+'-'+d;
            },
            onSelect: function(date){
		      jaka = date.getFullYear()+"-"+(date.getMonth()+1)+"-"+date.getDate();
	       }
        });
		
         $('#tgldppa').datebox({  
            required:true,
            formatter :function(date){
            	var y = date.getFullYear();
            	var m = date.getMonth()+1;
            	var d = date.getDate();
            	return y+'-'+m+'-'+d;
            },
            onSelect: function(date){
		      jaka = date.getFullYear()+"-"+(date.getMonth()+1)+"-"+date.getDate();
	       }
        });
		
		
     $('#dg').edatagrid({
     //url: '<?php echo base_url(); ?>/index.php/akuntansi/load_reg_spj',
       idField:'id',            
		rownumbers:"true", 
		fitColumns:"true",
		singleSelect:"true",
		autoRowHeight:"false",
		loadMsg:"Harap Tunggu, Sedang Proses Perhitungan Seluruh SKPD....!!",
		pagination:"true",
		nowrap:"true",            
        rowStyler: function(index,row){
        if (row.total > 0 && row.total < 9){
          return 'background-color:#FFD700;';
        }else if (row.total == 0){
          return 'background-color:#F08080;';
        }else if (row.total == 9){
          return 'background-color:#90EE90;';
        }
        },                           
        columns:[[
            {field:'kd_skpd',
    		title:'SKPD',
    		width:3,
            align:"center"},
    	    {field:'real_gj',
    		title:'Gaji',
    		width:6,
            align:"right"},
            {field:'real_up',
    		title:'UP/GU/TU',
    		width:6,
            align:"right"},
            {field:'real_brg',
    		title:'LS Barang & Jasa',
    		width:6,
			align:"right"},
            {field:'real_bku',
    		title:'Saldo BKU',
    		width:5,
			align:"right"},
            {field:'real_spj',
    		title:'Saldo SPJ',
    		width:5,
			align:"right"},
			{field:'tgl_terima',
    		title:'Tgl Terima',
    		width:3,
			align:"center"},
            {field:'bulan',
    		title:'BLN',
    		width:1,
			align:"center"}
			
        ]],
		
        onSelect:function(rowIndex,rowData){
          ckd_skpd = rowData.kd_skpd;
          ctgl_terima = rowData.tgl_terima;
		  
          ck_gj  = rowData.gj;
          ck_up  = rowData.up;
          ck_brg = rowData.brg;
          ck_bku = rowData.bku;
          ck_spj = rowData.spj;
          ck_bank = rowData.bank;
          ck_tunai = rowData.tunai;
          ck_pajak = rowData.pajak;
          ck_cp = rowData.cp;
          
          creal_gj = rowData.real_gj;                              
          creal_up = rowData.real_up;                    
          creal_brg = rowData.real_brg;
          creal_bku = rowData.real_bku;
          creal_spj = rowData.real_spj;
          creal_bank = rowData.real_bank;
          creal_tunai = rowData.real_tunai;
          creal_pajak = rowData.real_pajak;
		  creal_cp = rowData.real_cp;          
          cket = rowData.ket;          
		  
          get(ckd_skpd,ctgl_terima,ck_gj,ck_up,ck_brg,ck_bku,ck_spj,ck_bank,ck_tunai,ck_pajak,ck_cp,creal_gj,creal_up,creal_brg,creal_bku,creal_spj,creal_bank,creal_tunai,creal_pajak,creal_cp,cket); 
          lcidx = rowIndex;                           
        },
        onDblClickRow:function(rowIndex,rowData){
           lcidx = rowIndex;
           judul = 'Edit Register SPJ'; 
           edit_data();   
        }
        });		
		
    });        

	function validate1(){
        var bln1 = document.getElementById('bulan1').value;
			$('#dg').edatagrid({url:'<?php echo base_url(); ?>/index.php/akuntansi/load_reg_spj/'+bln1
                                   });
		
	}
	
	
    function get(ckd_skpd,ctgl_terima,ck_gj,ck_up,ck_brg,ck_bku,ck_spj,ck_bank,ck_tunai,ck_pajak,ck_cp,creal_gj,creal_up,creal_brg,creal_bku,creal_spj,creal_bank,creal_tunai,creal_pajak,creal_cp,cket){

        $("#kode").combogrid("setValue",ckd_skpd);
        $("#tgl_terima").datebox("setValue",ctgl_terima);
        $("#real_gj").attr("value",creal_gj);
        $("#real_up").attr("value",creal_up);
        $("#real_brg").attr("value",creal_brg);
        $("#real_bku").attr("value",creal_bku);        
        $("#real_spj").attr("value",creal_spj);
        $("#real_bank").attr("value",creal_bank);
        $("#real_tunai").attr("value",creal_tunai);
        $("#real_pajak").attr("value",creal_pajak);
        $("#real_cp").attr("value",creal_cp);
        
        if (ck_gj==1){ $("#gj").attr("checked",true); } else { $("#gj").attr("checked",false);}		
		if (ck_up==1){ $("#up").attr("checked",true); } else { $("#up").attr("checked",false);}
        if (ck_brg==1){ $("#brg").attr("checked",true); } else { $("#ck_brg").attr("checked",false);}
        if (ck_bku==1){ $("#bku").attr("checked",true); } else { $("#bku").attr("checked",false);}
		if (ck_spj==1){ $("#spj").attr("checked",true); } else { $("#spj").attr("checked",false);}
        if (ck_bank==1){ $("#bank").attr("checked",true); } else { $("#bank").attr("checked",false);}
        if (ck_tunai==1){ $("#tunai").attr("checked",true); } else { $("#tunai").attr("checked",false);}
        if (ck_pajak==1){ $("#pajak").attr("checked",true); } else { $("#pajak").attr("checked",false);}
        if (ck_cp==1){ $("#cp").attr("checked",true); } else { $("#cp").attr("checked",false);}
        $("#ket").attr("value",cket);
		
	}
  
    function kosong(){
        $("#kode").combogrid("setValue",'');
	    $("#nmskpd").attr("value",'')		
    }
    
    function cari(){
    var kriteria = document.getElementById("txtcari").value; 
	var bln1 = document.getElementById('bulan1').value;
    $(function(){ 
     $('#dg').edatagrid({
		url: '<?php echo base_url(); ?>/index.php/akuntansi/load_reg_spj/'+bln1,
        queryParams:({cari:kriteria})
        });        
     });
    }
    
    function reload_reg_spj(){
    var bln1 = document.getElementById('bulan1').value;    
    
    if(bln1 == '0' || bln1 == '' ){
        alert('Bulan Belum Dipilih');
        exit();
    }
    
    $(function(){ 
     $('#dg').edatagrid({
		url: '<?php echo base_url(); ?>/index.php/akuntansi/reload_reg_spj',
        queryParams:({init_bln:bln1})
        });        
     });
    }
	
       function simpan_pengesahan(){
		var cbulan = document.getElementById('bulan1').value;
        var ckd = $('#kode').combogrid('getValue');
		var ctgl_terima = $('#tgl_terima').datebox('getValue');
        
		var real_gj = angka(document.getElementById('real_gj').value);
        var real_up = angka(document.getElementById('real_up').value);
        var real_brg = angka(document.getElementById('real_brg').value);
        var real_bku = angka(document.getElementById('real_bku').value);
        var real_spj = angka(document.getElementById('real_spj').value);
        var real_bank = angka(document.getElementById('real_bank').value);
        var real_tunai = angka(document.getElementById('real_tunai').value);
        var real_pajak = angka(document.getElementById('real_pajak').value);
        var real_cp = angka(document.getElementById('real_cp').value);

        var cgj = document.getElementById('gj').checked;
        if (cgj==false){ cgj=0; }else{ cgj=1; }
        
        var cup = document.getElementById('up').checked;
        if (cup==false){ cup=0; }else{ cup=1; }
        
        var cbrg = document.getElementById('brg').checked;
        if (cbrg==false){ cbrg=0; }else{ cbrg=1; }        

		var cbku = document.getElementById('bku').checked;
        if (cbku==false){ cbku=0; }else{ cbku=1; }
        
        var cspj = document.getElementById('spj').checked;
        if (cspj==false){ cspj=0; }else{ cspj=1; }
        
		var cbank = document.getElementById('bank').checked;
        if (cbank==false){ cbank=0; }else{ cbank=1; }
		
        var ctunai = document.getElementById('tunai').checked;
        if (ctunai==false){ ctunai=0; }else{ ctunai=1; }		
        
		var cpajak = document.getElementById('pajak').checked;
        if (cpajak==false){ cpajak=0; }else{ cpajak=1; }
		
		var ccp = document.getElementById('cp').checked;
        if (ccp==false){ ccp=0; }else{ ccp=1; }
		
		tot=cgj+cup+cbrg+cspj+cbku+cbank+ctunai+cpajak+ccp;		
        var cket = document.getElementById('ket').value;
        
        if(tot==0){
            if(cket==''){
              alert('Keterangan Tidak Boleh Kosong, Jika tidak ada yang dicentang');
              exit();    
            }            
        }
        
        if (ctgl_terima==''){
            alert('Tanggal Tidak Boleh Kosong');
            exit();
        }
         
            $(document).ready(function(){
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url(); ?>/index.php/akuntansi/simpan_pengesahan',
                    data: ({tabel:'trhsah_spj',kdskpd:ckd,tgl_terima:ctgl_terima,bulan:cbulan,gj:cgj,up:cup,brg:cbrg,bku:cbku,spj:cspj,bank:cbank,tunai:ctunai,pajak:cpajak,cp:ccp,real_gj:real_gj,real_up:real_up,real_brg:real_brg,real_bku:real_bku,real_spj:real_spj,real_bank:real_bank,real_tunai:real_tunai,real_pajak:real_pajak,real_cp:real_cp,ket:cket}),
                    dataType:"json",
                    success:function(data){
                    status = data;
                    if(status=='0'){
                       alert('Data Berhasil Gagal');
                    } else{
					   alert("Data Berhasil disimpan");                       		               							
					}
                }
                });
            });		
    } 
    
      function edit_data(){
        lcstatus = 'edit';
        judul = 'Edit Data Pengesahan SPJ';
        $("#dialog-modal").dialog({ title: judul });
        $("#dialog-modal").dialog('open');
        document.getElementById("kode").disabled=true;
        }    
		
     function keluar(){
        $("#dialog-modal").dialog('close');
		lcstatus = 'edit';
     }    
      
    function addCommas(nStr)
    {
    	nStr += '';
    	x = nStr.split(',');
        x1 = x[0];
    	x2 = x.length > 1 ? ',' + x[1] : '';
    	var rgx = /(\d+)(\d{3})/;
    	while (rgx.test(x1)) {
    		x1 = x1.replace(rgx, '$1' + '.' + '$2');
    	}
    	return x1 + x2;
    }
    
     function delCommas(nStr)
    {
    	nStr += ' ';
    	x2 = nStr.length;
        var x=nStr;
        var i=0;
    	while (i<x2) {
    		x = x.replace(',','');
            i++;
    	}
    	return x;
    }
  
    function cetak(ctk)
        {
			var cbulan = document.getElementById('bulan1').value;
			if(cbulan==''){
			alert('Bulan tidak boleh kosong!');
			exit();
			}
			var url = "<?php echo site_url(); ?>/akuntansi/ctk_register_spj";  
			window.open(url+'/'+cbulan+'/'+ctk, '_blank');
			window.focus();
        }
  
   </script>

</head>
<body>

<div id="content"> 
<h3 align="center"><u><b><a>REGISTER SPJ</a></b></u></h3>
    <div align="center">
    <p align="center">     
    <table style="width:400px;" border="0">
        <tr>
        	
        <td width="50%" colspan="4"><b>SKPD</b>&nbsp;&nbsp;<input id="kode" style="width:100px;"/>&nbsp;&nbsp;<b>BULAN</b>&nbsp;&nbsp;
		<?php echo $this->rka_model->combo_bulan('bulan1','onchange="javascript:validate1();"'); ?>&nbsp;
        <a class="easyui-linkbutton" iconCls="icon-ok" plain="true" onclick="javascript:reload_reg_spj();">Perbaharui Data Pengesahan SPJ</a>
        <a class="easyui-linkbutton" iconCls="icon-ok" plain="true" onclick="javascript:validate1();">Refesh</a>        
        </td>
        </tr>
        <td align="right" colspan="4">
        <input type="text" value="" id="txtcari" style="width:270px;"/> 
		<a class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="javascript:cari();">Cari</a>&nbsp;&nbsp;
		<a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetak(1);"></a>
		<!--<a class="easyui-linkbutton" iconCls="icon-pdf" plain="true" onclick="javascript:cetak(2);"></a>-->
		<a class="easyui-linkbutton" iconCls="icon-excel" plain="true" onclick="javascript:cetak(3);"></a>
		</td>
        <tr>        
        </tr>
        <tr>
        <td colspan="4"><b>Ket. Warna : <font color="red">Merah = Centang:Kosong</font>, <font color="gold">Kuning = Centang:Belum Semua</font>, <font color="green">Hijau = Centang:Sudah Semua</font> </b></td>
        </tr>
        <tr>
        <td colspan="4">
        <table id="dg" title="LISTING DATA PENGESAHAN" style="width:900px;height:500px;" >  
        </table>
        </td>
        </tr>
    </table>    
    
    </p> 
    </div>   
</div>

<div id="dialog-modal" title="">
    <p class="validateTips">Semua Inputan Harus Di Isi.</p> 
    <fieldset>
     <table align="center" style="width:100%;" border="0">
			<tr>
                <td width="25%">SKPD</td>
                <td width="1%">:</td>
                <td><input id="kode" style="width:100px;"/><input type="text" id="nmskpd" style="border:0;width:500px;"/></td>
            </tr> 
			<tr>
                <td width="25%">TGL Terima</td>
                <td width="1%">:</td>
                <td><input type="text" id="tgl_terima" style="width:100px;" /></td>  
            </tr>
            <tr>
                <td width="100%" colspan="3"><hr /></td>
            </tr>
            <tr>
                <td width="25%"><b>Realisasi</b></td>
                <td width="1%"></td>
                <td></td>
            </tr>    
			<tr>
                <td width="25%">Gaji</td>
                <td width="1%">:</td>
                <td><input type="checkbox" id="gj" />&nbsp;&nbsp;<input type="text" id="real_gj" readonly="true" style="width:150px; text-align: right;" onkeypress="return(currencyFormat(this,',','.',event))"/></td>  
            </tr>
			<tr>
                <td width="25%">UP/GU/TU</td>
                <td width="1%">:</td>
                <td><input type="checkbox" id="up" />&nbsp;&nbsp;<input type="text" id="real_up" readonly="true" style="width:150px; text-align: right;" onkeypress="return(currencyFormat(this,',','.',event))"/></td>  
            </tr>
			<tr>
                <td width="25%">LS Barang dan Jasa</td>
                <td width="1%">:</td>
                <td><input type="checkbox" id="brg" />&nbsp;&nbsp;<input type="text" id="real_brg" readonly="true" style="width:150px; text-align: right;" onkeypress="return(currencyFormat(this,',','.',event))"/></td>  
            </tr>
            <tr>
                <td width="100%" colspan="3"><hr /></td>
            </tr>
			<tr>
                <td width="25%"><b>Saldo Akhir</b></td>
                <td width="1%"></td>
                <td></td>
            </tr>    			
            <tr>
			<td width="25%">BKU</td>
			<td width="1%">:</td>
			<td><input type="checkbox" id="bku" />&nbsp;&nbsp;<input type="text" id="real_bku" readonly="true" style="width:150px; text-align: right;" onkeypress="return(currencyFormat(this,',','.',event))"/></td>
			</tr>
			<tr>
			<td width="25%">SPJ</td>
			<td width="1%">:</td>
			<td><input type="checkbox" id="spj" />&nbsp;&nbsp;<input type="text" id="real_spj" readonly="true" style="width:150px; text-align: right;" onkeypress="return(currencyFormat(this,',','.',event))"/></td>
			</tr>
			<tr>
			<td width="25%">BP Bank</td>
			<td width="1%">:</td>
			<td><input type="checkbox" id="bank"  />&nbsp;&nbsp;<input type="text" id="real_bank" readonly="true" style="width:150px; text-align: right;" onkeypress="return(currencyFormat(this,',','.',event))"/></td>
			</tr>
  	        <tr>
			<td width="25%">BP Tunai</td>
			<td width="1%">:</td>
			<td><input type="checkbox" id="tunai"  />&nbsp;&nbsp;<input type="text" id="real_tunai" readonly="true" style="width:150px; text-align: right;" onkeypress="return(currencyFormat(this,',','.',event))"/></td>
			</tr>
			<tr>
			<td width="25%">BP Pajak (Terima-Setor)</td>
			<td width="1%">:</td>
			<td><input type="checkbox" id="pajak"  />&nbsp;&nbsp;<input type="text" id="real_pajak" readonly="true" style="width:150px; text-align: right;" onkeypress="return(currencyFormat(this,',','.',event))"/></td>
			</tr>
			<tr>
			<td width="25%">CP</td>
			<td width="1%">:</td>
			<td><input type="checkbox" id="cp"  />&nbsp;&nbsp;<input type="text" id="real_cp" readonly="true" style="width:150px; text-align: right;" onkeypress="return(currencyFormat(this,',','.',event))"/></td>
			</tr>
			<tr>
                <td width="25%">Keterangan</td>
                <td width="1%">:</td>
                <td><input type="text" id="ket" style="width:440px;"/></td>  
            </tr>			
            <tr>
            <td colspan="5">&nbsp;</td>
            </tr>            
            <tr>
                <td colspan="5" align="center"><a class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:simpan_pengesahan();">Simpan</a>
                <a class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:keluar();">Kembali</a>
                </td>                
            </tr>
        </table>       
    </fieldset>
</div>

</body>

</html>