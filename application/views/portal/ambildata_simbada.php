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
    
    <link href="<?php echo base_url(); ?>easyui/jquery-ui.css" rel="stylesheet" type="text/css"/>
    <script src="<?php echo base_url(); ?>easyui/jquery-ui.min.js"></script>
  <style>    
    #tagih {
        position: relative;
        width: 900px;
        height: 100px;
        padding: 0.4em;
    }  
    </style>
    <script type="text/javascript"> 
    var nip='';
	var kdskpd='';
	var kdrek5='';
    var pilihttd='';
    var hsl='';
    
     $(document).ready(function() {
            $("#accordion").accordion();            
            $( "#dialog-modal" ).dialog({
                height: 450,
                width: 850,
                modal: true,
                autoOpen:false,            
            });             
            $( "#dialog-modal-simakda" ).dialog({
                height: 470,
                width: 950,
                modal: true,
                autoOpen:false,            
            }); 
            $('#tgl_ttd1').datebox({  
            required:true,
            formatter :function(date){
            	var y = date.getFullYear();
            	var m = date.getMonth()+1;
            	var d = date.getDate();
            	return y+'-'+m+'-'+d;
            }
        });
        
     $(function(){
            
        $('#dg_view_portal').edatagrid({
        //url: '<?php echo base_url(); ?>/index.php/service_portal/load_getdata',
        idField:'id',            
		singleSelect:"true",
		autoRowHeight:"false",
		loadMsg:"Harap Tunggu, Sedang Proses....!!",
		pagination:"true",
		//nowrap:"true",  
        frozenColumns:[[
            {field:'id',
    		title:'No',
            align:"center"},
            {field:'id_urusan',
    		title:'id_urusan',
            align:"center"},
            {field:'kode_urusan',
    		title:'kode_urusan',
            align:"left"},
            {field:'urusan',
    		title:'urusan',
            align:"center"},
        ]],                                            
        columns:[[
    	    
            {field:'id_bidang',
    		title:'id_bidang',
            align:"left"},
            {field:'kode_bidang',
    		title:'kode_bidang',
            align:"left"},
            {field:'bidang',
    		title:'bidang',
            align:"left"},
            {field:'id_program',
    		title:'id_program',
            align:"left"},
            {field:'kode_program',
    		title:'kode_program',
            align:"left"},
            {field:'program',
    		title:'program',
            align:"left"},
            {field:'id_kegiatan',
    		title:'id_kegiatan',
            align:"left"},
            {field:'kode_kegiatan',
    		title:'kode_kegiatan',
            align:"left"},
            {field:'kegiatan',
    		title:'kegiatan',
            align:"left"}
			
        ]]/*,		
        onSelect:function(rowIndex,rowData){
                                     
        },
        onDblClickRow:function(rowIndex,rowData){
             
        }*/
        });	});	
     
    $(function(){ 
                $('#dg_view_portal').edatagrid({
	           	url: '<?php echo base_url(); ?>/index.php/service_portal/load_getdata'
                });        
                }); 
        
    $(function(){
            
        $('#dg_view_simakda').edatagrid({
        //url: '<?php echo base_url(); ?>/index.php/service_portal/load_getdata_simakda',
        idField:'id',            
		singleSelect:"true",
		autoRowHeight:"false",
		loadMsg:"Harap Tunggu, Sedang Proses....!!",
		pagination:"true",
		//nowrap:"true",  
        frozenColumns:[[
            {field:'id',
    		title:'No',
            align:"center"},
            {field:'id_urusan',
    		title:'id_urusan',
            align:"center"},
            {field:'kode_urusan',
    		title:'kode_urusan',
            align:"left"},
            {field:'urusan',
    		title:'urusan',
            align:"center"},
        ]],                                            
        columns:[[
    	    
            {field:'id_bidang',
    		title:'id_bidang',
            align:"left"},
            {field:'kode_bidang',
    		title:'kode_bidang',
            align:"left"},
            {field:'bidang',
    		title:'bidang',
            align:"left"},
            {field:'id_program',
    		title:'id_program',
            align:"left"},
            {field:'kode_program',
    		title:'kode_program',
            align:"left"},
            {field:'program',
    		title:'program',
            align:"left"},
            {field:'id_kegiatan',
    		title:'id_kegiatan',
            align:"left"},
            {field:'kode_kegiatan',
    		title:'kode_kegiatan',
            align:"left"},
            {field:'kegiatan',
    		title:'kegiatan',
            align:"left"}
			
        ]]/*,		
        onSelect:function(rowIndex,rowData){
                                     
        },
        onDblClickRow:function(rowIndex,rowData){
             
        }*/
        });	});	
    
    $('#hid').combogrid({            
            url:"<?php echo base_url(); ?>index.php/service_portal/request_data_query",
            panelWidth:505,
            idField:'query_id',
            textField:'query_id',
            mode:'remote',
            columns:[[
                {field:'source_data',title:'Sumber Data',width:100},
                {field:'name',title:'Judul',width:400}
            ]],
            onSelect:function(rowIndex,rowData){
            $("#hjudul").attr("Value",rowData.name);
            $("#hket").attr("Value",rowData.description);     
            cek_link(rowData.query_id);                                 
          }
        });
    
    $('#hlokasi').combogrid({            
            url:"<?php echo base_url(); ?>index.php/service_portal/ld_lokasi",
            panelWidth:400,
            idField:'kd_lokasi',
            textField:'nm_lokasi',
            mode:'remote',
            columns:[[
                {field:'nm_lokasi',title:'Lokasi',width:380}
            ]],
            onSelect:function(rowIndex,rowData){
            }
        });
        
    $('#p').progressbar({
        value: 0
    });    
            
        });   
	
    function cek_link(query_id){
        var cek = query_id;
        
        if(cek=="d82c8d1619ad8176d665453cfb2e55f0"){
            
        }else{
            alert("Keperluan Data RBI SIMBADA");
            exit();
        }
    }
    
    function get_setprog(){
        $(function(){
            
        $('#dg_view_simakda').edatagrid({
        idField:'id',            
		singleSelect:"true",
		autoRowHeight:"false",
		loadMsg:"Harap Tunggu, Sedang Proses....!!",
		pagination:"true",
		//nowrap:"true",  
        frozenColumns:[[
            {field:'id',
    		title:'No',
            align:"center"},
            {field:'id_urusan',
    		title:'id_urusan',
            align:"center"},
            {field:'kode_urusan',
    		title:'kode_urusan',
            align:"left"},
            {field:'urusan',
    		title:'urusan',
            align:"center"},
        ]],                                            
        columns:[[
    	    
            {field:'id_bidang',
    		title:'id_bidang',
            align:"left"},
            {field:'kode_bidang',
    		title:'kode_bidang',
            align:"left"},
            {field:'bidang',
    		title:'bidang',
            align:"left"},
            {field:'id_program',
    		title:'id_program',
            align:"left"},
            {field:'kode_program',
    		title:'kode_program',
            align:"left"},
            {field:'program',
    		title:'program',
            align:"left"},
            {field:'id_kegiatan',
    		title:'id_kegiatan',
            align:"left"},
            {field:'kode_kegiatan',
    		title:'kode_kegiatan',
            align:"left"},
            {field:'kegiatan',
    		title:'kegiatan',
            align:"left"}
			
        ]]
        });	});	
    }
    
    function get_setrenja(){
        $(function(){
            
        $('#dg_view_simakda').edatagrid({
        idField:'id',            
		singleSelect:"true",
		autoRowHeight:"false",
		loadMsg:"Harap Tunggu, Sedang Proses....!!",
		pagination:"true",
		//nowrap:"true",  
        frozenColumns:[[
            {field:'id',
    		title:'No',
            align:"center"},
            {field:'kode_urusan',
    		title:'kode_urusan',
            align:"center"},
            {field:'urusan',
    		title:'urusan',
            align:"center"},
        ]],                                            
        columns:[[
    	    
            {field:'kode_bidang',
    		title:'kode_bidang',
            align:"left"},
            {field:'bidang',
    		title:'bidang',
            align:"left"},
            {field:'kode_skpd',
    		title:'kode_skpd',
            align:"left"},
            {field:'skpd',
    		title:'skpd',
            align:"left"},            
            {field:'id_program',
    		title:'id_program',
            align:"left"},
            {field:'kode_program',
    		title:'kode_program',
            align:"left"},
            {field:'program',
    		title:'program',
            align:"left"},
            {field:'id_kegiatan',
    		title:'id_kegiatan',
            align:"left"},
            {field:'kode_kegiatan',
    		title:'kode_kegiatan',
            align:"left"},
            {field:'kegiatan',
    		title:'kegiatan',
            align:"left"}
			
        ]]
        });	});	
    }
    
    
    function cetak($ctk)
        {
			
            var initx = pilihttd;            
            var ctglttd = $('#tgl_ttd1').datebox('getValue'); 
            
            var cetak =$ctk;                      
			var url    = "<?php echo site_url(); ?>/akuntansi/ctk_lpsal";	  
			window.open(url+'/'+cetak+'/'+initx+'/'+ctglttd, '_blank');
			window.focus();
        }  
            
    function ambildata(){
    document.getElementById('load').style.visibility='visible';                       
    var parkey = $('#hid').combogrid('getValue');
    var parth1 = document.getElementById('htahun1').value;
    var parth2 = document.getElementById('htahun2').value;    
    var parlokasi = $('#hlokasi').combogrid('getValue');
     
    alert(parlokasi); 
            
    $(function(){      
		 $.ajax({
			type: 'POST',			
			dataType:"json",
			url:"<?php echo base_url(); ?>index.php/service_portal/request_data_simbada/"+parkey+"/"+parlokasi+"/"+parth1+"/"+parth2,            
			success:function(data){			 
			 status = data;             
                        if (status=='1'){
                            hsl = 'Berhasil';  
                            document.getElementById('load').style.visibility='hidden';                                                     
                        } else {
                            hsl = 'Gagal';
                        } 
                    
                    alert(hsl);                
            }
		 });
		});    
    
    }
    
    function lihatdata(){
      var url    = "<?php echo site_url(); ?>/service_portal/cetak_rbi";	  
	  window.open(url, '_blank');  
      
    }
    
    function tutup(){
        var url    = "<?php echo site_url(); ?>/service_portal/ambil_data";	  
		window.open(url, '_self');
    }
    
    function prosess(){
        var elem = document.getElementById("myBar2");   
        var width = 1;
        var id = setInterval(frame, 20);
    
    $(function(){      
		 $.ajax({
			type: 'POST',			
			dataType:"json",
			url:"<?php echo base_url(); ?>index.php/service_portal/getInsert",
			success:function(data){				
			}

		 });
		});
    
    function frame() {
    if (width >= 100) {
      clearInterval(id);
      var hsl = "Berhasil";
      document.getElementById("hasil").value=hsl;      
    } else {
      width++; 
      elem.style.width = width + '%'; 
    }
    }
    }
    
    function hapus(){
        var urll = '<?php echo base_url(); ?>index.php/service_portal/hapus';
        var kriteria= '';
        var tny = confirm('Yakin Ingin Menghapus Data');        
        if (tny==true){
        $(document).ready(function(){
        $.ajax({url:urll,
                 dataType:'json',
                 type: "POST",    
                 data:({no:kriteria}),
                 success:function(data){
                    
                    status = data.pesan;
                        if (status=='1'){
                            hsl = 'Berhasil';                                                       
                        } else {
                            hsl = 'Gagal';
                        } 
                    
                    document.getElementById("hasil2").value=hsl;
                    
                $(function(){ 
                $('#dg_view_simakda').edatagrid({
	           	url: '<?php echo base_url(); ?>/index.php/service_portal/load_getdata_simakda',
                queryParams:({no:kriteria})
                });        
                }); 
                     
                 }
                 
                });           
        });
        }     
    }
    
    </script>

    <STYLE TYPE="text/css"> 
		 input.right{ 
         text-align:right; 
         } 
        
        
        #myProgress2 {
             width: 100%;
             background-color: #ddd;
        }

        #myBar2 {
            width: 1%;
            height: 30px;
            background-color: #1E90FF;
        }
	</STYLE> 

</head>
<body>

<div id="content">



<h3>SUMBER DATA PORTAL SIMBADA</h3>       
<div id="accordion">
    
    <p align="right">         
        <table id="sp2d" title="Request" style="width:900px;height:300px;">          
        <tr>
            <td>ID Sumber Data</td>
            <td></td>
            <td>&nbsp;<input style="width: 412px;" id="hid" readonly="true"/></td>
        </tr>
        <tr>
            <td>Judul</td>
            <td></td>
            <td><textarea rows="2" cols="60" id="hjudul" style="width: 400px;" readonly="true"></textarea></td>
        </tr>        
        <tr>
            <td>Keterangan</td>
            <td></td>
            <td><textarea rows="3" cols="60" id="hket" style="width: 400px;" readonly="true"></textarea></td>
        </tr>
        <tr>
            <td>Parameter [kodelokasi]</td>
            <td></td>
            <td><input style="width: 200px;" id="hlokasi" /></td>
        </tr>
        <tr>
            <td>Parameter [filter_tahun]</td>
            <td></td>
            <td><input style="width: 200px;" id="htahun1" /></td>
        </tr>
        <tr>
            <td>Parameter [filter_tahun2]</td>
            <td></td>
            <td><input style="width: 200px;" id="htahun2" /></td>
        </tr>
        <tr>
            <td>Request ke PORTAL</td>
            <td></td>
            <td align="left">
            <a class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:ambildata();">Ambil dan Simpan Data</a>        
             </td>
        </tr>
        <tr >
            <td colspan="2" ></td>
			<td align="center" style="visibility:hidden" >	<DIV id="load" > <IMG SRC="<?php echo base_url(); ?>assets/images/loading.gif" WIDTH="400" HEIGHT="20" BORDER="0" ALT=""></DIV></td>
		</tr>        
        <tr>
            <td>Request ke SIMAKDA</td>
            <td></td>
            <td align="left"><a class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:lihatdata();">Lihat Data</a></td>
        </tr>                	
        </table>                      
    </p> 
    

</div>

</div>

<div id="dialog-modal" title="Preview Data">
    <fieldset>
     <table align="center" style="width:100%;" border="0">
            <tr>
                <td colspan="3"><table id="dg_view_portal" title="" style="width:800px;height:300px;" ></table> </td>                  
            </tr>
            
            <tr>
                <td><br /></td>
                <td><br /></td>
                <td><br /></td>  
            </tr>
            <tr>
            <td></td>
            <td></td>
            <td align="left">
            <a class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:tutup();">Kembali</a>
            <a class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:prosess();">Proses Simpan ke SIMAKDA</a>&nbsp;Status :&nbsp;<input type="text" id="hasil" name="hasil" style="border:0;width: 100px;" readonly="true"/>
            &nbsp;&nbsp;&nbsp;&nbsp;<div id="myProgress2" class="easyui-progressbar" style="width:400px;">
                <div id="myBar2" >
                </div></div> 
            </td>
            
        </tr>
    </table>
    </fieldset>            
</div>  

<div id="dialog-modal-simakda" title="Lihat Data">
    <fieldset>
     <table align="center" style="width:100%;" border="0">
            <tr>
                <td colspan="3"><input type="text" id="judul_lihat" style="border: none; width: 400px;" /></td>
            </tr>
            <tr>
                <td colspan="3"><table id="dg_view_simakda" title="" style="width:900px;height:330px;" ></table> </td>                  
            </tr>
            
            <tr>
                <td><br /></td>
                <td><br /></td>
                <td><br /></td>  
            </tr>
            <tr>
            <td></td>
            <td></td>
            <td align="left">
            <a class="easyui-linkbutton" id="kmbl" iconCls="icon-undo" plain="true" onclick="javascript:tutup();">Kembali</a>            
            <!--<a class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:hapus();">Hapus Data SIMAKDA</a>&nbsp;Status :&nbsp;<input type="text" id="hasil2" name="hasil2" style="border:0;width: 100px;" readonly="true"/>                        
            -->
            </td>
            
        </tr>
    </table>
    </fieldset>            
</div>    
 	
</body>

</html>