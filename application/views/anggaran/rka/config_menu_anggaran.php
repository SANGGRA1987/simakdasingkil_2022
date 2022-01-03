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
            height: 240,
            width: 600,
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
   	});
	
	  $(function(){ 
     $('#dg').edatagrid({
       // url: '<?php echo base_url(); ?>/index.php/rka/load_konfig_menu_anggaran',
        idField:'id',            
        rownumbers:"true", 
        fitColumns:"true",
        singleSelect:"true",
        autoRowHeight:"false",
        loadMsg:"Tunggu Sebentar....!!",
        nowrap:"true",                       
        columns:[[
            {field:'kd_skpd',
            title:'Kode',
            width:20,
            align:"center"},
            {field:'nm_skpd',
            title:'Nama',
            width:50,
            align:"left"},
            {field:'id_user',
            title:'User',
            width:30,
            hidden:true,
            align:"center"}

        ]],
        onSelect:function(rowIndex,rowData){
          vno = rowData.no_konfig;
          vjenis_anggaran   = rowData.jenis_anggaran;
          vjudul = rowData.judul_ag;
          vnomor = rowData.nomor;
          vtanggal = rowData.tanggal;
          vlampiran = rowData.lampiran;
          lcidx = rowIndex;
          visi=rowData.isi;
          vdaerah=rowData.daerah;
          get(vno,vjenis_anggaran,vjudul,vnomor,vtanggal,vlampiran,visi,vdaerah);   
                                       
        },
        onDblClickRow:function(rowIndex,rowData){
           lcidx = rowIndex;
           judul = 'Edit Data ANGGARAN'; 
           edit_data();   
        }
        
        });
        
         
              
       

      
    });       
            

    function validate_skpd(){
    
    var jns_ang = document.getElementById('jns_anggaran').value;
    //alert(jns_ang);

    if(jns_ang==0){
        alert('Jenis Anggaran Salah !');
    }else{

    

        $(function(){ 
     $('#dg').edatagrid({
        url: '<?php echo base_url(); ?>/index.php/rka/load_konfig_menu_anggaran/'+jns_ang,
        idField:'id',            
        rownumbers:"true", 
        fitColumns:"true",
        singleSelect:"true",
        autoRowHeight:"false",
        loadMsg:"Tunggu Sebentar....!!",
        nowrap:"true",                       
        columns:[[
            {field:'kd_skpd',
            title:'Kode',
            width:20,
            align:"center"},
            {field:'nm_skpd',
            title:'Nama',
            width:50,
            align:"left"},
            {field:'id_user',
            title:'User',
            width:30,
            hidden:true,
            align:"center"}

        ]],
        onSelect:function(rowIndex,rowData){
          vuser = rowData.id_user;
          vkd_skpd   = rowData.kd_skpd;
          //alert(vkd_skpd);
          vnm_skpd = rowData.nm_skpd;
          
          get(vuser,vkd_skpd,vnm_skpd);   
                                       
        },
        onDblClickRow:function(rowIndex,rowData){
           lcidx = rowIndex;
           judul = 'Edit Data ANGGARAN'; 
           edit_data();   
        }
        
        });

      
    });   
    }    
            
} 
          
 
	function get(vuser,vkd_skpd,vnm_skpd){
        $("#user_id").attr("value",vuser);
		//$("#jns_anggaran").attr("value",vjenis_anggaran);
        $("#kode_skpd").attr("value",vkd_skpd);
        $("#nama_skpd").attr("value",vnm_skpd);
                               
    }
    
    function kosong(){
		cdate = '<?php echo date("Y-m-d"); ?>';
        $("#no").attr("value",'');
         $("#jns_anggaran").attr("value",'');
        $("#judul_lamp").attr("value",'');
        $("#nomor_lamp").attr("value",'');
        $("#tanggal_lamp").attr("value",'');
        $("#jns_lamp").attr("value",'');
        $("#txtdaerah").attr("value",'');
        $("#isilam").attr("value",'');   
    }
    
  
       function hapus(){
        //alert(lcstatus);
        var cno = document.getElementById('no').value;
		 $(document).ready(function(){
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url(); ?>/index.php/master/hapus_master',
                    data: ({tabel:'trkonfig_anggaran',cid:'no_konfig',cnid:cno}),
                    dataType:"json",
                    success:function(data){
                        status = data;
                        if (status=='0'){
                            alert('Gagal Hapus..!!');
                            exit();
                        }else if(status=='1'){
                            alert('Data Berhasil Dihapus..!!');
							$('#dg').edatagrid('reload');
							$("#dialog-modal").dialog('close');
                            exit();
                        }else{
                            alert('Gagal Hapus..!!');
                            exit();
                        }
                    }
                });
            });  
	   }
    
    
	
       function simpan(){
        //alert(lcstatus);
        var cno = document.getElementById('no').value;
        var cjns_anggaran = document.getElementById('jns_anggaran').value;
        var cjudul_lamp = document.getElementById('judul_lamp').value;
        var cnomor_lamp = document.getElementById('nomor_lamp').value;
        var ctanggal_lamp = document.getElementById('tanggal_lamp').value;
        var cjns_lamp = document.getElementById('jns_lamp').value;
        var cisi = document.getElementById('isilam').value;  
        var cdaerah = document.getElementById('txtdaerah').value;  		
        
		if (cjns_anggaran=='0'){
            alert('JENIS ANGGARAN Tidak Boleh Kosong');
            exit();
        } 
        if (cjns_lamp=='0'){
            alert('JENIS LAMPIRAN Tidak Boleh Kosong');
            exit();
        }
        if (cjudul_lamp==''){
            alert(' JUDUL LAMPIRAN Tidak Boleh Kosong');
            exit();
        }
        
        if(lcstatus=='tambah'){ 
            
            lcinsert = "(jenis_anggaran, judul, nomor, tanggal, lampiran, isi, daerah)";
            lcvalues = "('"+cjns_anggaran+"','"+cjudul_lamp+"','"+cnomor_lamp+"','"+ctanggal_lamp+"','"+cjns_lamp+"','"+cisi+"','"+cdaerah+"')";

            $(document).ready(function(){
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url(); ?>/index.php/master/simpan_master',
                    data: ({tabel:'trkonfig_anggaran',kolom:lcinsert,nilai:lcvalues,cid:'no_konfig',lcid:cno}),
                    dataType:"json",
                    success:function(data){
                        status = data;
                        if (status=='0'){
                            alert('Gagal Simpan..!!');
                            exit();
                        }else if(status=='1'){
                            alert('Data Sudah Ada..!!');
                            exit();
                        }else{
                            alert('Data Tersimpan..!!');
                            exit();
                        }
                    }
                });
            });    
         
          } else{
            
            lcquery = "UPDATE trkonfig_anggaran SET jenis_anggaran='"+cjns_anggaran+"',judul='"+cjudul_lamp+"',nomor='"+cnomor_lamp+"',tanggal='"+ctanggal_lamp
			+"',lampiran='"+cjns_lamp+"',isi='"+cisi+"',daerah='"+cdaerah+"' where no_konfig='"+cno+"'";
            //alert(lcquery);
            $(document).ready(function(){
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>/index.php/master/update_master',
                data: ({st_query:lcquery}),
                dataType:"json",
                success:function(data){
                        status = data;
                        if (status=='0'){
                            alert('Gagal Simpan..!!');
                            exit();
                        }else{
                            alert('Data Tersimpan..!!');
                            exit();
                        }
                    }
            });
            });
                        
        }        
       // alert("Data Berhasil disimpan");
	   
        $("#dialog-modal").dialog('close');
        
        //section1();
		} 
    
      function edit_data(){
        lcstatus = 'edit';
        judul = 'Edit Menu Inputan Murni ';
        $("#dialog-modal").dialog({ title: judul });
        $("#dialog-modal").dialog('open');
        document.getElementById("no").disabled=true;
        }    
        
    
     function tambah(){
        lcstatus = 'tambah';
        judul = 'Input Data';
        $("#dialog-modal").dialog({ title: judul });
        kosong();
        $("#dialog-modal").dialog('open');
        document.getElementById("no").disabled=false;
        document.getElementById("no").focus();
        } 
     function keluar(){
        $("#dialog-modal").dialog('close');
     }    

    
       

  // Created by Tox
    
  
   </script>

</head>
<body>

<div id="content"> 
<div id="accordion">
<h3 align="center"><u><b><a href="#" id="section1">KONFIGURASI INPUTAN MENU ANGGARAN</a></b></u></h3>
    <div>
    <p align="right">         
        <a color='red'>*) Pilih Jenis Anggaran :</a>               
        <!--<a class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:hapus();">Hapus</a>
        <a class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="javascript:cari();"></a>-->
        <tr>
    <select name="jns_anggaran" id="jns_anggaran" onchange="javascript:validate_skpd();" style="height: 27px; width:190px;">    
     <option value="0">...Pilih Jenis... </option>   
     <option value="1">Murni</option>
     <option value="2">Pergeseran</option>
     <option value="3">Perubahan</option>
     </select>
 </td>
 </tr>
        <table id="dg" title="LIST KODE / NAMA SKPD" style="width:870px;height:450px;" >  
        </table>
 
    </p> 
    </div>   

</div>

</div>


<div id="dialog-modal" title="">
    <fieldset>
     <table align="center" style="width:100%;" border="0">
	        <tr>
                <td >USER ID.</td>
                <td>:</td>
                <td>&nbsp;<input type="text" id="user_id" style="width: 200px;" readonly /></td>  
            </tr>            
            <tr>
                <td>KODE SKPD</td>
                <td>:</td>
                <td>&nbsp;<input type="text" id="kode_skpd" style="width: 200px;"/></td>  
            </tr>
            <tr>
                <td>NAMA SKPD</td>
                <td>:</td>
                <td>&nbsp;<input type="text" id="nama_skpd" style="width: 400px;"/></td>  
            </tr>
            <tr>
                <td>JENIS ANGGARAN</td>
                <td>:</td>
                <td>
                <select name="jns_menu" id="jns_menu" onchange="javascript:validate_jenis();" style="height: 27px; width:190px;">    
                    <option value="0">...Pilih Jenis... </option>   
                    <option value="1">Penyusunan</option>
                    <option value="2">Murni</option>
                </select>
               </td>  
            </tr>  
			<tr>
                <td colspan="3" align="center">
				<a class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:hapus();section1();">Hapus</a>
				<a class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:simpan();$('#dg').edatagrid('reload');">Simpan</a>
		        <a class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:keluar();">Kembali</a>
                </td>                
            </tr>
        </table>       
    </fieldset>
</div>


  	
</body>

</html>