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
        
   
        $(function(){
        $('#tgl_ttd').datebox({  
            required:true,
            formatter :function(date){
                var y = date.getFullYear();
                var m = date.getMonth()+1;
                var d = date.getDate();
                return y+'-'+m+'-'+d;
            }
        });
        $('#dg').edatagrid();
         $('#jns_prio').combogrid();
        $('#program').combogrid();
        $('#cunit').combogrid({  
            panelWidth:700,  
            idField:'kd_skpd',  
            textField:'kd_skpd',  
            mode:'remote',
            url:'<?php echo base_url(); ?>index.php/perda/skpd_sinkron',  
            columns:[[  
                {field:'kd_skpd',title:'Kode Unit',width:100},  
                {field:'nm_skpd',title:'Nama Unit',width:700}    
            ]],
            onSelect:function(rowIndex,rowData){
                skpd = rowData.kd_skpd;
                program(skpd);
                tabel(skpd);
                $("#nmskpd").attr("value",rowData.nm_skpd);
           
           
                }  
            });
        });

                 
         
         $(function(){  
            $('#ttd').combogrid({  
                panelWidth:1000,  
                idField:'id',  
                textField:'nama',  
                mode:'remote',
                url:'<?php echo base_url(); ?>index.php/perda/ttd_sin',  
                columns:[[  
                    {field:'nip',title:'NIP',width:200},  
                    {field:'nama',title:'Nama',width:400},
                    {field:'jabatan',title:'jabatan',width:400}    
                ]]  
            });          
         });
        

                
        


    function program(kd_skpd){
         $(function(){  
            $('#program').combogrid({  
                panelWidth:800,  
                idField:'kd_program',  
                textField:'nm_program',  
                mode:'remote',
                url:'<?php echo base_url(); ?>index.php/perda/program_sin/'+kd_skpd,  
                columns:[[  
                    {field:'kd_program',title:'Kode Program',width:200},  
                    {field:'nm_program',title:'Nama Program',width:600}    
                ]]  
            }); 
            $('#jns_prio').combogrid({  
                panelWidth:810,  
                idField:'jns_prioritas',  
                textField:'nm_prioritas',  
                mode:'remote',
                url:'<?php echo base_url(); ?>index.php/perda/jenis_prioritas',  
                columns:[[
                {field:'jns_prioritas',title:'No',width:30},  
                    {field:'nm_prioritas',title:'Prioritas',width:800}    
                ]],
                 onSelect:function(rowIndex,rowData){
                    $("#nm_prio").attr("value",rowData.nm_prioritas);
                        simpan();
           
           
                }    
            });    

         });
    }

    function simpan(){
        var nm_prio =document.getElementById('nm_prio').value;
        var jns_prio = $('#jns_prio').combogrid('getValue');   
        var program = $('#program').combogrid('getValue');
        if((nm_prio=='' || jns_prio=='') || program=='' ){
            alert("Harap Lengkapi Isian");
        }   
        $(function(){   
            $.ajax({
                type     : "POST",
                dataType : "json",
                data     : ({nm_prio:nm_prio,jns_prio:jns_prio,program:program}),
                url      : '<?php echo base_url(); ?>/index.php/perda/simpan_mapping_sin/', 
                success  : function(data){
                    $('#dg').edatagrid('reload');
                    $('#jns_prio').combogrid('setValue',''); 
                    $('#program').combogrid('setValue',''); 
                    $('#nm_prio').attr('value',''); 
                    $('#jns_prio').combogrid('clear');
                    $('#program').combogrid('clear');
                    $('#cunit').combogrid('setValue',''); 
                }
                });
        });   
    }

        function tabel(skpd){
            $(function(){
            $("#dg").datagrid("unselectAll");
            $('#dg').edatagrid({
                url: '<?php echo base_url(); ?>/index.php/perda/tabel_sinkron/'+skpd,
                 idField:'id',
                 toolbar:"#toolbar",              
                 rownumbers:"true", 
                 singleSelect:"true",

                 columns:[[
                    {field:'kd_program',
                     title:'Kode',
                     width:150,
                     align:'left'
                    },
                    {field:'nm_program',
                     title:'Program Kegiatan',
                     width:500,
                     align:'left'
                    },                    
                    {field:'nm_prioritas',
                     title:'Prioritas',
                     width:500
                    }
                ]],
                onDblClickRow:function(isi,index){
                    $('#hapus').attr('value', index.kd_program);
                    hapus();
                }
            });
        });
        }  

        function cetak(dokumen){
            var anggaran =document.getElementById('anggaran').value;
            var ttd = $('#ttd').combogrid('getValue');
            var tgl = $('#tgl_ttd').datebox('getValue');
            if((anggaran=='' || tgl=='')|| ttd==''){
                alert("Lengkapi isian!"); exit();
            }
            var url="<?php echo base_url(); ?>/index.php/perda/cetak_sin/"+dokumen+"/"+anggaran+"/"+ttd+"/"+tgl+"/SINKRONISASI";
            window.open(url,'_blank');
        }
    
    function hapus(){
        var hapus =document.getElementById('hapus').value;
        var cek =confirm("Anda akan menghapus Kegiatan "+hapus+" ?");
        if(cek==false){
            exit();
        }
        $(function(){   
            $.ajax({
                type     : "POST",
                dataType : "json",
                data     : ({program:hapus}),
                url      : '<?php echo base_url(); ?>/index.php/perda/hapus_sinkron/', 
                success  : function(data){
                    $('#dg').edatagrid('reload');
                    $('#hapus').attr('value',''); 
                    $("#dg").datagrid("unselectAll");
                }
                });
        });   
    }


   </script>

    <div id="content">        
        <h1><?php echo $page_title; ?>&nbsp;&nbsp;&nbsp;&nbsp; 
       </h1>
        
        <?php echo form_close(); ?>   
        
        <?php if (  $this->session->flashdata('notify') <> "" ) : ?>
        <div class="success"><?php echo $this->session->flashdata('notify'); ?></div>
        <?php endif; ?>
    
        <input type="text" name="hapus" id="hapus" hidden>
        <td colspan="4">
                <div id="div_bend">
                        <table style="width:100%;" border="0"> 
                            <td width="20%">Unit</td>
                            <td width="1%">:</td>
                            <td><input type="text" id="cunit" style="width: 100px;" /> 
                            <td><input type="text" id="nmskpd" readonly="true" style="width: 605px;border:0" /></td>
                            </td> 
                        </table>
                </div>
        </td> 
        </tr>
        <tr>

        <td colspan="4">
                <div id="div_bend">
                        <table style="width:100%;" border="0">                          
                            <td width="20%">Program</td>
                            <td width="1%">:</td>
                            <td><input type="text" id="program" style="width: 500px;" /> 
                            </td> 
                        </table>
                </div>
        </td> 


        </tr>
        <td colspan="4">
                <div id="div_bend">
                        <table style="width:100%;" border="0">                          
                            <td width="20%">Jenis Prioritas</td>
                            <td width="1%">:</td>
                            <td><input type="text" hidden id="nm_prio" style="width: 100px;" /> 
                                <input type="text" id="jns_prio" style="width: 500px;" /> 
                            </td> 
                        </table>
                </div>
        </td> 

        
        </tr>   
        
        <tr>

            <table id="dg" title="Mapping Sinkronisasi" style="width:900px;height:300%"></table>  
<hr >
        <table class="narrow">

        <tr>
           <td width="10%">Tanggal</td>
           <td> <input type="text" id="tgl_ttd" name="">
           </td>    
        </tr>
        <tr>
           <td width="10%">Penandatangan</td>
           <td> <input type="" id="ttd" name="">
           </td>    
        </tr>       
        <tr>
           <td width="10%">Cetak Sinkronisasi</td>
           <td> 
                    
                    <a class="easyui-linkbutton" plain="true" onclick="javascript:cetak(1)" >
                    <img src="<?php echo base_url(); ?>assets/images/icon/print.png" width="25" height="23" title="preview"/></a>
                    <button class="easyui-linkbutton" plain="true" onclick="javascript:cetak(3)" style=" cursor: pointer;">  EXCEL   </button>
                    <a class="easyui-linkbutton" plain="true" onclick="javascript:cetak(2)">                    
                    <img src="<?php echo base_url(); ?>assets/images/icon/print_pdf.png" width="25" height="23" title="cetak"/></a>                    
                     &nbsp;&nbsp;&nbsp;&nbsp;<select id="anggaran">
                        <option value=''>PILIH JENIS ANGGARAN</option>
                        <option value='nilai'>Murni</option>
                         <option value='nilai_sempurna'>Pergeseran</option>
                          <option value='nilai_ubah'>Perubahan</option>
                    </select>
           </td>    
        </tr>


        </table>        
        <div class="clear"></div>
        <br><br><br><br><br><br>
    </div>