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
        }); }); 
     
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
        }); }); 
    
    $('#xskpd').combogrid({            
            url:"<?php echo base_url(); ?>index.php/service_portal/load_skpdx",
            panelWidth:505,
            idField:'kd_skpd',
            textField:'kd_skpd',
            mode:'remote',
            columns:[[
                {field:'kd_skpd',title:'SKPD',width:100},
                {field:'nm_skpd',title:'SKPD',width:480}
            ]],
            onSelect:function(rowIndex,rowData){
                kdskpd = rowData.kd_skpd;
                simakda(kdskpd);     
          }
        });


 
    function simakda(kdskpd){
        $(function(){

            $('#kdsimakda').combogrid({            
            url:'<?php echo base_url(); ?>index.php/service_portal/load_giat/'+kdskpd,
            panelWidth:505,
            idField:'kd_kegiatan_simakda',
            textField:'kd_kegiatan_simakda',
            mode:'remote',
            columns:[[
                {field:'kd_kegiatan_simakda',title:'Kode kegiatan SIMAKDA',width:150},
                {field:'kd_kegiatan_sipp',title:'Kode kegiatan SIPP',width:150},
                {field:'hasil',title:'Hasil',width:150}
            ]],
            onSelect:function(rowIndex,rowData){
                sipp = rowData.kd_kegiatan_sipp;
                $("#kdsipp").attr("value",rowData.kd_kegiatan_sipp.toUpperCase());                                
            }
            });
        });
    }
      
    $('#p').progressbar({
        value: 0
    });    
            
        });   
    
    
    function cek_link(query_id){
        var cek = query_id;
        
        if(cek=="4e732ced3463d06de0ca9a15b6153677" || cek=="02e74f10e0327ad868d138f2b4fdd6f0"){
            
        }else{
            alert("Keperluan Data Master Program Kegiatan dan Renja (SIPP)");
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
        }); }); 
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
        }); }); 
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
    var parskpd = $('#hskpd').combogrid('getValue');        
    $(function(){      
         $.ajax({
            type: 'POST',           
            dataType:"json",
            url:"<?php echo base_url(); ?>index.php/service_portal/request_data11_prog/"+parskpd,            
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
    
       function simpandata(){

        alert("cek");
    /*document.getElementById('load').style.visibility='visible';                       
     var parskpd = $('#hskpd').combogrid('getValue');       
    $(function(){      
         $.ajax({
            type: 'POST',           
            dataType:"json",
            url:"<?php echo base_url(); ?>index.php/service_portal/request_simpan_prog/"+parskpd,            
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
    */
    }
    
    function simakdasipp(){

        var skpd = $("#xskpd").combogrid("getValue");
        var simakda = $("#kdsimakda").combogrid("getValue");
        var sipp = document.getElementById('kdsipp').value; 

        $(function(){      
         $.ajax({
                type: 'POST',           
                dataType:"json",
                url:"<?php echo base_url(); ?>index.php/service_portal/ubahkode/"+skpd+"/"+simakda+"/"+sipp,            
                success:function(data){          
                  status = data.pesan; 
                         if (status=='1'){               
                            alert('Data Berhasil Tersimpan...!!!');
                        } else{ 
                            alert('Data Gagal Tersimpan...!!!');
                        }                  
                }
             });
        });  
    }

    function inputgiat()
    {
        var skpd = $("#xskpd").combogrid("getValue");

        $(function(){      
         $.ajax({
                type: 'POST',           
                dataType:"json",
                url:"<?php echo base_url(); ?>index.php/service_portal/inputkegiatan/"+skpd,            
                success:function(data){          
                  status = data.pesan; 
                         if (status=='1'){               
                            alert('Data Berhasil Tersimpan...!!!');
                        } else{ 
                            alert('Data Gagal Tersimpan...!!!');
                        }                  
                }
             });
        });  
    }
    function inputprogram()
    {
        var skpd = $("#xskpd").combogrid("getValue");

        $(function(){      
         $.ajax({
                type: 'POST',           
                dataType:"json",
                url:"<?php echo base_url(); ?>index.php/service_portal/inputprog/"+skpd,            
                success:function(data){          
                  status = data.pesan; 
                         if (status=='1'){               
                            alert('Data Berhasil Tersimpan...!!!');
                        } else{ 
                            alert('Data Gagal Tersimpan...!!!');
                        }                  
                }
             });
        });  
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
    
    function lihatdata_prog(){
        var url    = "<?php echo site_url(); ?>/service_portal/cetak_program";  
        window.open(url, '_blank');
        window.focus();         
    }
    
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
    
    function cekkodekegiatan()
    {
        var parskpd =  $('#xskpd').combogrid('getValue');
        var url    = "<?php echo site_url(); ?>/service_portal/lihatkode1/"+parskpd;  
        window.open(url, '_blank');
        window.focus(); 
    }

    function lihatdata_prog(){
        var parskpd =  $('#xskpd').combogrid('getValue');
        
        var url    = "<?php echo site_url(); ?>/service_portal/cetak_prog/"+parskpd;  
        window.open(url, '_blank');
        window.focus();         
    }
    
    function lihatdata_renja(){
        var url    = "<?php echo site_url(); ?>/service_portal/cetak_renja";  
        window.open(url, '_blank');
        window.focus();         
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

<h3><center>Ubah Kode Kegiatan di Simakda ke SIPP</center></h3>       
<div id="">
    <p align="right">         
        <table id="sp2d" title="Request" >          
        <tr>
            <td>SKPD</td>
            <td></td>
            <td><input type="text" style="width: 200px;" name="xskpd" id="xskpd"></td>
        </tr>

        <tr>
            <td>Ubah Kode Kegiatan dari Simakda</td>
            <td></td>
            <td>
                <input style="width: 200px;" id="kdsimakda" /> Ubah ke  
                <input style="width: 200px;" id="kdsipp" disabled="true" /> 
                <a class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="javascript:simakdasipp();">Ubah
                </a> 
            </td>
        </tr>

        <tr>
            <td colspan="5" align="center">
                <a class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="javascript:inputgiat()">Insert Kegiatan dari SIPP</a>
                <a class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="javascript:inputprogram()">Insert Program dari SIPP</a>
            </td>
        </tr>

       <!--  <tr>

            <td colspan="5" align="center">
               Insert trskpd dari data SIPP
            </td>
        </tr>

        <tr>
            <td>Ubah Kode Kegiatan dari Simakda</td>
            <td></td>
            <td>
                <input style="width: 200px;" id="kdsimakda" /> Ubah ke  
                <input style="width: 200px;" id="kdsipp" disabled="true" /> 
            </td>
        </tr>





        <a class="easyui-linkbutton" iconCls="icon-edit" plain="true">Insert trskpd dari SIPP</a>
        <tr>
            <td>Cek Kesesuaian Kode Kegiatan Simakda dan SIPP</td>
            <td></td>
            <td align="left">
            <br />
            <a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cekkodekegiatan();">Lihat Kode Kegiatan</a>

            </td>
        </tr>    -->
                    	
        </table>

        <table>
            <tr>
                <td>okekeke</td>
            </tr>
        </table>                      
    </p> 
</div>

</body>

</html>