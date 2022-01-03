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
            height: 300,
            width: 550,
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
		url: '<?php echo base_url(); ?>/index.php/rka/load_config_menu',
        idField:'id',            
        rownumbers:"true", 
        fitColumns:"true",
        singleSelect:"true",
        autoRowHeight:"false",
        loadMsg:"Tunggu Sebentar....!!",
        nowrap:"true",                       
        columns:[[
    	    {field:'id_user',
    		title:'USER',
    		width:25,
            hidden:true,
            align:"left"},
            {field:'nama',
            title:'NAMA',
            width:60,
            align:"center"},
            {field:'stat',
    		title:'MENU INPUT',
    		width:40,
            align:"center"},
            {field:'status',
            title:'status',
            width:40,
            align:"center"}

        ]],
        onSelect:function(rowIndex,rowData){
          vnama = rowData.nama;
          vid   = rowData.id_user;
          vstatus = rowData.status;
          
          get(vnama,vid,vstatus);   
                                       
        },
        onDblClickRow:function(rowIndex,rowData){

           lcidx = rowIndex;
           judul = 'Edit Data ANGGARAN'; 
           edit_data();   
        }
        
        });
        
         
              
       

      
    });        
 
	function get(vnama,vid,vstatus){
        $("#user_txt").attr("value",vnama);
		$("#stat_txt").attr("value",vstatus);
        $("#id_txt").attr("value",vid);
        //alert(vstatus);
        if(vstatus==0){
            $('#chkrancang')._propAttr('checked',true);
            $('#chkmurni')._propAttr('checked',false);
        }else{
            $('#chkrancang')._propAttr('checked',false);
            $('#chkmurni')._propAttr('checked',true);
        }


                               
    }
    
    function kosong(){  
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
        var vidx = document.getElementById('id_txt').value;
        var vstat = document.getElementById('stat_txt').value;
        var vstatx = document.getElementById('chkrancang').value;

        alert(vstatx);

            //lcinsert = "(jenis_anggaran, judul, nomor, tanggal, lampiran, isi, daerah)";
            //lcvalues = "('"+cjns_anggaran+"','"+cjudul_lamp+"','"+cnomor_lamp+"','"+ctanggal_lamp+"','"+cjns_lamp+"','"+cisi+"','"+cdaerah+"')";
   

            $(document).ready(function(){
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url(); ?>/index.php/rka/simpan_config_menu',
                    data: ({tabel:'config_menu',vidx:vidx,vstat:vstat,vstatx:vstatx}),
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
         
              
       // alert("Data Berhasil disimpan");
	   
        $("#dialog-modal").dialog('close');
        
        //section1();
		} 
    
      function edit_data(){
        lcstatus = 'edit';
        judul = 'Edit Menu yang Akan ditampilkan !';
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

     function validate_jenis(){
        var jns_ang = document.getElementById('jns_anggaran').value;
        $(function(){ 
                $('#dg').edatagrid({
                  url: '<?php echo base_url(); ?>/index.php/rka/load_config_menu',
                  queryParams:({kriteria_init:jns_ang})
                });        
               });
     }


      function runEffect(stat) {
            if(stat==0){        
                 $('#chkrancang')._propAttr('checked',true);
                 $('#chkmurni')._propAttr('checked',false);
            }
            else{
                $('#chkrancang')._propAttr('checked',false);
                $('#chkmurni')._propAttr('checked',true);
            }    
        };  

        function runEffect2(stat2) {
            if(stat2==1){        
                 $('#chkgeser1')._propAttr('checked',true);
                 $('#chkgeser2')._propAttr('checked',false);
            }
            else{
                $('#chkgeser1')._propAttr('checked',false);
                $('#chkgeser2')._propAttr('checked',true);
            }    
        };     

    
       

  // Created by Tox
    
  
   </script>

</head>
<body>

<div id="content"> 
<div id="accordion">
<h3 align="center"><u><b><a href="#" id="section1">KONFIGURASI MENU INPUT</a></b></u></h3>
    <div>
    <p align="left" >
        <a>&nbsp;&ensp;*) Pilih Jenis Anggaran Terlebih Dahulu</a>   
    </p>
    <p align="right"> 
        <a><select name="jns_anggaran" id="jns_anggaran" onchange="javascript:validate_jenis();" style="height: 27px; width:190px;">    
     <option value="0">...Pilih Jenis... </option>   
     <option value="1">Penyusunan</option>
     <option value="2">Pergeseran</option>
     </select></a>
        <!--<a class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:tambah()">Tambah</a>               
        <!--<a class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:hapus();">Hapus</a>
        <a class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="javascript:cari();">Cari</a>
        <input type="text" value="" id="txtcari"/>-->
        <table id="dg" title="LIST KONFIGURASI MENU TAMPIL" style="width:870px;height:450px;" >  
        </table>
 
    </p> 
    </div>   

</div>

</div>


<div id="dialog-modal" title="">
    <fieldset>
     <table align="center" style="width:100%;" border="0">
            <tr>
                <td>&nbsp;&ensp;</td>
            </tr>
            <tr>
                <td>USER</td>
                <td>:</td>
                <td>&nbsp;<input type="text" id="user_txt" disabled style="width: 400px;"/></td>  
            </tr>
            <tr>
                <td>&nbsp;<input type="text" id="stat_txt" hidden style="width: 400px;"/></td>  
                <td>&nbsp;<input type="text" id="id_txt" hidden style="width: 400px;"/></td>
            </tr>
            <tr>
                <td colspan="3">*)CENTANG MENU YANG INGIN DIPILIH SEBAGAI MENU AKTIF</td>
            </tr>
            <tr>
                <td>&nbsp;&ensp;</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td>&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;
                    <input type="checkbox" name="chkrancang" id="chkrancang" value="0" onclick="javascript:runEffect(0);"/>RANCANG
                    &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;<input type="checkbox" name="chkmurni" id="chkmurni" value="1" onclick="javascript:runEffect(1);"/>MURNI</td>
            </tr>

            <!--<tr>
                <td></td>
                <td></td>
                <td>&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;
                    <input type="checkbox" name="chkgeser1" id="chkgeser1" value="0" onclick="javascript:runEffect2(1);"/>PERGESERAN I
                    &ensp;&ensp;&ensp;<input type="checkbox" name="chkgeser2" id="chkgeser2" value="1" onclick="javascript:runEffect2(2);"/>PERGESERAN II</td>
            </tr>-->

            <tr>
                <td>&ensp;</td>
             </tr>

            <tr>
                <td colspan="3" align="center">
				<a class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:simpan();$('#dg').edatagrid('reload');">Simpan</a>
		        <a class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:keluar();">Kembali</a>
                </td>                
            </tr>
        </table>       
    </fieldset>
</div>


  	
</body>

</html>