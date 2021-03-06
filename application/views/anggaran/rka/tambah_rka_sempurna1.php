<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>easyui/themes/default/easyui.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>easyui/themes/icon.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>easyui/demo/demo.css" />
    <script type="text/javascript" src="<?php echo base_url(); ?>easyui/jquery-1.8.0.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>easyui/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>easyui/jquery.edatagrid.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/autoCurrency.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/numberFormat.js"></script>
    <link href="<?php echo base_url(); ?>easyui/jquery-ui.css" rel="stylesheet" type="text/css"/>
    <script src="<?php echo base_url(); ?>easyui/jquery-ui.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/shortcut.js"></script>
    
    <script type="text/javascript">
 
    var nl       = 0;
    var tnl      = 0;
    var idx      = 0;
    var tidx     = 0;
    var oldRek   = 0;
    var rek      = 0;
    var detIndex = 0;
    var kdrek    = '';
    var id       = 0;
    var status   = '0';
    var zfrek    = '';
    var zkdrek   = '';
    var status_apbd = '';
    var total_kas   = 0;
    
    
    shortcut.add("ctrl+m", function() {
        detsimpan();
    });
    
    $(document).ready(function() {
            $("#accordion").accordion();            
            $( "#dialog-modal" ).dialog({
                height: 450,
                width: 970,
                modal: true,
                autoOpen:false                
            });
            
            $("#dialog-modal-edit" ).dialog({
                height: 230,
                width: 970,
                modal: true,
                autoOpen:false                
            });
            //get_skpd();
            
            get_nilai_kua();
            
        });    
    
    $(document).ready(function(){
        $('#skpd').hide();
        $('#giat').hide();
    });
    

    $(function(){
             
           var mgiat = document.getElementById('giat').value; 
           $('#dg').edatagrid({
                url           : '<?php echo base_url(); ?>/index.php/rka/select_rka',
                 idField      : 'id',
                 toolbar      : "#toolbar",              
                 rownumbers   : "true", 
                 fitColumns   : "true",
                 singleSelect : "true",
                onSelect:function(rowIndex,rowData){                            
                    },
                columns:[[
                    {field:'id',
                     title:'id',
                     width:10,
                     hidden:true
                    },
                    {field:'kd_rek5',
                     title:'Rekening',
                     width:12,
                     align:'left'   
                    },
                    {field:'nm_rek5',
                     title:'Nama Rekening',
                     width:60
                    },

                    {field:'nilai_sempurna',
                     title:'Nilai Rek. Pergeseran',
                     width:30,
                     align:'right'
                     },
                    {field:'nilai',
                     title:'Nilai Penyusunan',
                     width:30,
                     align:'right'
                    },
                     {field:'rinci',
                      title:'Detail',
                      width:10,
                      align:'center', 
                      formatter:function(value,rec){
                            rek         = rec.kd_rek5
                            return ' <p onclick="javascript:section('+rec.kd_rek5+');">Rincian</p>';
                        }
                    }
                    /*
                    ,
                    {field:'hapus',title:'Hapus',width:10,align:"center",
                     formatter:function(value,rec){ 
                     return '<img src="<?php echo base_url(); ?>/assets/images/icon/edit_remove.png" onclick="javascript:hapus();" />';
                    }}
                    */
                ]]
            });
             
             
            $(function(){
            $('#rek5').combogrid({  
            panelWidth : 700,  
            idField    : 'kd_rek5',  
            textField  : 'kd_rek5',  
            mode       : 'remote',
            url        : '<?php echo base_url(); ?>index.php/rka/ambil_rekening5',  
            columns    : [[  
                {field:'kd_rek5',title:'Kode ',width:100},  
                {field:'nm_rek5',title:'Nama ',width:700}    
            ]],
            onSelect:function(rowIndex,rowData){
                kdrek = rowData.kd_rek5;
               validate_rek();
            }  
            }); 
            });
            
            
            $(function(){
            $("#sdana1").combogrid({
                panelWidth:300,
                idField   :'nm_sdana',
                textField :'nm_sdana',
                mode      :'remote',
                url       : '<?php echo base_url(); ?>index.php/rka/ambil_sdana',
                columns   : [[
                {field:'kd_sdana',title:'Kode',width:100},
                {field:'nm_sdana',title:'Sumber Dana',width:190}
                ]]
            });
            });
            
            
            $(function(){
            $("#sdana2").combogrid({
               panelWidth:300,
                idField   :'nm_sdana',
                textField :'nm_sdana',
                mode      :'remote',
                url       : '<?php echo base_url(); ?>index.php/rka/ambil_sdana',
                columns   : [[
                {field:'kd_sdana',title:'Kode',width:100},
                {field:'nm_sdana',title:'Sumber Dana',width:190}
                ]]
            });
            });
            
            
            $(function(){
            $("#sdana3").combogrid({
                panelWidth:300,
                idField   :'nm_sdana',
                textField :'nm_sdana',
                mode      :'remote',
                url       : '<?php echo base_url(); ?>index.php/rka/ambil_sdana',
                columns   : [[
                {field:'kd_sdana',title:'Kode',width:100},
                {field:'nm_sdana',title:'Sumber Dana',width:190}
                ]]
            });
            });
            
            
            $(function(){
            $("#sdana4").combogrid({
              panelWidth:300,
                idField   :'nm_sdana',
                textField :'nm_sdana',
                mode      :'remote',
                url       : '<?php echo base_url(); ?>index.php/rka/ambil_sdana',
                columns   : [[
                {field:'kd_sdana',title:'Kode',width:100},
                {field:'nm_sdana',title:'Sumber Dana',width:190}
                ]]
            });
            });

             $(function(){
            $('#sskpd').combogrid({  
            panelWidth:700,  
            idField:'kd_skpd',  
            textField:'kd_skpd',  
            mode:'remote',
            url:'<?php echo base_url(); ?>index.php/rka/skpduser',  
            columns:[[  
                {field:'kd_skpd',title:'Kode SKPD',width:100},  
                {field:'nm_skpd',title:'Nama SKPD',width:700}    
            ]],
            onSelect:function(rowIndex,rowData){
                
                skpd = rowData.kd_skpd;
                $("#nm_skpd").attr("value",rowData.nm_skpd);
               
                get_skpd(skpd,rowData.nm_skpd,rowData.statu);
                
                $("#kdgiat").combogrid("clear");
                $("#nmgiat").attr("value",'');
                $("#kdrek5").combogrid("setValue",'');
                $("#nmrek5").attr("value",'');
                
                
                //$("#kdrek5").combogrid("clear");
                document.getElementById('kdgiat').value    = '';
                document.getElementById('giat').value    = '';
                $("#kdrek5").combogrid("disable");
                
                //validate_combo();
                //validate_rekening();              
            }

            });
            });
            
        });
        
        function load_sum_rek_rka(c){                
        var a = document.getElementById('skpd').value;
        var b = document.getElementById('giat').value;
        $(function(){      
         $.ajax({
            type: 'POST',
            data:({skpd:a,keg:b,rek:c}),
            url:"<?php echo base_url(); ?>index.php/rka/load_sum_rek_rinci_rka",
            dataType:"json",
            success:function(data){ 
                $.each(data, function(i,n){
                    $("#rektotal_rka").attr("value",n['rektotal_rka_sempurna']);
                });
            }
         });
        });
    }


        
        
      function get_skpd(kd_s='',nm_s='',st_s='')
        {

                                        $("#sskpd").attr("value",kd_s);
                                        $("#nmskpd").attr("value",nm_s.toUpperCase());
                                        $("#skpd").attr("value",kd_s);
                                        
                                        kdskpd = kd_s;
                                        validate_giat();
                                        get_nilai_kua();
                                        get_realisasi();

                                        validate_rekening();
                                        $("#kdrek5").combogrid("disable");
                                        cek_status();
                                      }                                     

       function cek_status(){
            $kd_skpd = document.getElementById('skpd').value;
            $.ajax({
                url:'<?php echo base_url(); ?>index.php/rka/config_skpd2',
                type: "POST",
                dataType:"json",
                data      : ({kdskpd:$kd_skpd}),                         
                success:function(data){
                                        sta    = data.status_sem_final;
                                        tombol(sta);
                                      }                                     
            });        
       }
        
        function get_nilai_kua()
        {
            $kdskpd = document.getElementById('skpd').value;
            kdskpd = $kdskpd;
            
            $.ajax({
                
                url:'<?php echo base_url(); ?>index.php/rka/load_nilai_kua/'+kdskpd,
                
                type: "POST",
                dataType:"json",                         
                success:function(data){
                      $.each(data, function(i,n){
                        $("#nilai_kua").attr("Value",n['nilai']);
                        
                        $("#nilai_kua_ang").attr("Value",n['kua_terpakai_sempurna']);
                        //$("#sisa_nilai_kua").attr("Value",(n['nilai']-n['kua_terpakai']));
                        var n_kua  = n['nilai'] ;                
                        var n_kua_terpakai = n['kua_terpakai_sempurna'];
                        var n_sisa_kua = angka(n_kua) - angka(n_kua_terpakai) ;
                        $("#sisa_nilai_kua").attr("Value",number_format(n_sisa_kua,2,'.',','));
                        $("#sisa_kua2").attr("Value",number_format(n_sisa_kua,2,'.',','));   
                    });
                }
            });
        }
        
        function get_realisasi(){
            $kdskpd = document.getElementById('skpd').value;
            kdskpd = $kdskpd;
            
            $.ajax({
                
                url:'<?php echo base_url(); ?>index.php/rka/get_realisasi/'+kdskpd,
                
            type: "POST",
                dataType:"json",                         
                success:function(data){
                      $.each(data, function(i,n){
                            $("#total_realisasi").attr("Value",n['nrealisasi']);
                    });
                }
            });
        }
         
        
        function get_nilai_kua_rek(){
        var kua_rek = document.getElementById('nilairek').value;
            $.ajax({
                   
                url:'<?php echo base_url(); ?>index.php/rka/load_nilai_kua/'+kdskpd,
                type: "POST",
                dataType:"json",                         
                success:function(data){
                      $.each(data, function(i,n){
                        $("#nilai_kua").attr("Value",n['nilai']);
                        
                        $("#nilai_kua_ang").attr("Value",n['kua_terpakai_sempurna']);
                        //$("#sisa_nilai_kua").attr("Value",(n['nilai']-n['kua_terpakai']));
                        var n_kua  = n['nilai'] ;
                        var n_kua_terpakai = n['kua_terpakai_sempurna'];
                        var n_sisa_kua = angka(n_kua) - angka(n_kua_terpakai) ;
                        var n_sisa_kua_rek = n_sisa_kua + angka(kua_rek) ;
                        $("#nilai_kua_rek").attr("Value",kua_rek);
                        $("#sisa_kua2").attr("Value",number_format(n_sisa_kua,2,'.',','));
                        $("#total_sisa_kua_rek").attr("Value",number_format(n_sisa_kua_rek,2,'.',','));
                    });
                }
            });
        }
        
        function get_nilai_real_rek(){
            var kdskpd = document.getElementById('skpd').value;
            var kgiat = document.getElementById('giat').value;    
            //var kua_rek = document.getElementById('nilairek').value;
            var reke   = $("#kdrek5").combogrid("getValue");
            
            $.ajax({           
                url:'<?php echo base_url(); ?>index.php/rka/get_realisasi_rek/'+kdskpd,
                type: "POST",
                dataType:"json",  
                data      : ({skpd:kdskpd,keg:kgiat,rek5:reke}),                        
                success:function(data){
                      $.each(data, function(i,n){
                           $("#nreal_rek").attr("Value",n['nrealisasi']);
                           $("#n_realrek").attr("Value",n['nrealisasi']);
                    });
                }
            });
        } 
 
        function get_nilai_real_rek2(){
            var kdskpd = document.getElementById('skpd').value;
            var kgiat = document.getElementById('giat').value;    
            //var kua_rek = document.getElementById('nilairek').value;
            var reke   = $("#kdrek5").combogrid("getValue");

            
            $.ajax({           
                url:'<?php echo base_url(); ?>index.php/rka/get_realisasi_rek/'+kdskpd,
                type: "POST",
                dataType:"json",  
                data      : ({skpd:kdskpd,keg:kgiat,rek5:reke}),                        
                success:function(data){
                      $.each(data, function(i,n){
                           $("#n_realrek").attr("Value",n['nrealisasi']);
                    });
                }
            });
        } 
 
 
        function cek_kas(){
            var xxgiat = document.getElementById('giat').value;
            var xxskpd = document.getElementById('skpd').value;
            
            total_kas = 0;
            $("#cek_kas").attr("value",0);
            
            $.ajax({
               
               url       : '<?php echo base_url(); ?>/index.php/rka/cek_kas_sempurna',
               type      : 'POST',
               dataType  : 'json',
               data      : ({skpd:xxskpd,kegiatan:xxgiat}),
               success   : function(data) {
                
                    $.each(data, function(i,n){
                        var nilai_kas = n['nilai'];
                        total_kas = total_kas + angka(nilai_kas) ;
                        $("#cek_kas").attr("value",total_kas);
                    });
               }
            });
        }
        
        
        function cek_rek_susun(){
            var xxgiat = document.getElementById('giat').value;
            var xxskpd = document.getElementById('skpd').value;
            var xxrek5 = $("#kdrek5").combogrid("getValue");
          
            $.ajax({
               //ga ada
               url       : '<?php echo base_url(); ?>/index.php/rka/cek_rek5_hsempurna',
               type      : 'POST',
               dataType  : 'json',
               data      : ({skpd:xxskpd,kegiatan:xxgiat,rek5:xxrek5}),
               success   : function(data) {
                        $("#cek_rek5").attr("value",data);
               }
            });
        }

        
        function validate_giat(){
            $(function(){
            $('#kdgiat').combogrid({  
            panelWidth : 700,  
            idField    : 'kd_kegiatan',  
            textField  : 'kd_kegiatan',  
            mode       : 'remote',
            url        : '<?php echo base_url(); ?>index.php/rka/pgiat/'+kdskpd,  
            columns    : [[  
                {field:'kd_kegiatan',title:'Kode SKPD',width:150},  
                {field:'nm_kegiatan',title:'Nama Kegiatan',width:650},
                {field:'kd_skpd',title:'skpd',width:650}
            ]],
            onSelect:function(rowIndex,rowData){
                              
                kegiatan = rowData.kd_kegiatan;
                $("#nmgiat").attr("value",rowData.nm_kegiatan.toUpperCase());
                $("#skpdbp").attr("value",rowData.kd_skpd);
                $("#giat").attr("value",rowData.kd_kegiatan);
                $("#jnskegi").attr("value",rowData.jns_kegiatan);
                validate_combo();
                status_keg = rowData.status_keg;
                $("#kdrek5").combogrid("disable");
                $("#kdrek5").combogrid("setValue",'');
                
                
                document.getElementById('nilairek').value   = 0;
                document.getElementById('nilairekawal').value   = 0;
                document.getElementById('nmrek5').value     = '';
                $('#section1').click();
                tombol_keg(status_keg);
                kosongkan_header();
            },
            }); 
            });
        }
 
            
        
        function validate_rekening(){
            
            $("#dg").datagrid("unselectAll");
            $("#dg").datagrid("selectAll");
            
            var rows   = $("#dg").datagrid("getSelections");
            var jrows  = rows.length ;

            zfrek  = '';
            zkdrek = '';
            
            for (z=0;z<jrows;z++){
               zkdrek=rows[z].kd_rek5;                 
               if ( z == 0 ){
                   zfrek  = zkdrek ;
               } else {
                   zfrek  = zfrek+','+zkdrek ;
               }
            }          
            
            var jkegi = document.getElementById('jnskegi').value ;
            
           
            
            $('#kdrek5').combogrid({  
               panelWidth : 500,  
               idField    : 'kd_rek5',  
               textField  : 'kd_rek5',  
               mode       : 'remote',
               url        : '<?php echo base_url(); ?>index.php/master/ambil_rekening5_all_ar',  
               queryParams: ({reknotin:zfrek,jns_kegi:jkegi}),
               columns    : [[  
                   {field:'kd_rek5',title:'Kode Rekening',width:100},  
                   {field:'nm_rek5',title:'Nama Rekening',width:400}    
               ]],  
               onSelect:function(rowIndex,rowData){
                    kd_rek5 = rowData.kd_rek5;
                    $("#nmrek5").attr("value",rowData.nm_rek5.toUpperCase());
               },
               onLoadSuccess:function(data){
                    $("#nilairek").attr("value",0);
                    $("#nilairekawal").attr("value",0);
                   // $("#kdrek5").combogrid("enable");
               }  
             });     
        }
        

        
        function getSelections(idx){
            var ids = [];
            var rows = $('#dg').edatagrid('getSelections');
            for(var i=0;i<rows.length;i++){
                ids.push(rows[i].kd_rek5);
            }
            return ids.join(':');
        }

        
        function getSelections2(idx){
            var ids = [];
            var rows = $('#dg1').edatagrid('getSelections');
            for(var i=0;i<rows.length;i++){
                ids.push(rows[i].no_po);
            }
            return ids.join(':');
        }


        function getRowIndex(target){  
            var tr = $(target).closest('tr.datagrid-row');  
            return parseInt(tr.attr('datagrid-row-index'));  
        }  


        function refresh(){  
            $('#dg').datagrid('reload');
        } 

        function simpan(baru,lama,nilai,sdana){     
            var cgiat = document.getElementById('giat').value;
            var cskpd = document.getElementById('skpd').value;
            var cskpd2 = document.getElementById('skpdbp').value;
            if (lama==''){
                lama=baru;
            }
            
                $(function(){
                    $('#dg').edatagrid({
                         url: '<?php echo base_url(); ?>/index.php/rka/tsimpan/'+cskpd+'/'+cgiat+'/'+cskpd2+'/'+baru+'/'+lama+'/'+nilai+'/'+sdana,
                         idField:'id',
                         toolbar:"#toolbar",              
                         rownumbers:"true", 
                         fitColumns:"true",
                         singleSelect:"true",
                    });
                });
        }
        
                
        function validate_combo(){
            
            var cgiat = document.getElementById('giat').value;       
            $(function(){
            $('#dg').edatagrid({
                 url: '<?php echo base_url(); ?>/index.php/rka/select_rka/'+cgiat,
                 idField     : 'id',
                 toolbar     : "#toolbar",              
                 rownumbers  : "true", 
                 fitColumns  : "true",
                 singleSelect: "true",
                 showFooter  : true,
                 nowrap      : false,
                 onSelect:function(rowIndex,rowData){                           
                              
                              oldRek   = getSelections(getRowIndex(this));
                              vvkdrek  = rowData.kd_rek5;
                              vvnmrek  = rowData.nm_rek5;
                              vvnilai  = rowData.nilai_sempurna;
                              vvnilai2  = rowData.nilai;
                              vvsdana1 = rowData.sumber1_su.trim();
                              vvsdana2 = rowData.sumber2_su.trim();
                              vvsdana3 = rowData.sumber3_su.trim();
                              vvsdana4 = rowData.sumber4_su.trim();
                              vvnsdana1 = rowData.nsumber1_su;
                              vvnsdana2 = rowData.nsumber2_su;
                              vvnsdana3 = rowData.nsumber3_su;
                              vvnsdana4 = rowData.nsumber4_su;
                              vvnilaisusun =   angka(rowData.nilai);
                              $("#nilairek").attr("value",vvnilai);
                              $("#nilairekawal").attr("value",vvnilai);
                              $("#nilaimurni").attr("value",vvnilai2);
                              $("#nmrek5").attr("value",vvnmrek);
                              $("#kdrek5").combogrid("setValue",vvkdrek);
                              
                                $("#sdana1").combogrid("setValue",vvsdana1);
                                $("#sdana2").combogrid("setValue",vvsdana2);
                                $("#sdana3").combogrid("setValue",vvsdana3);
                                $("#sdana4").combogrid("setValue",vvsdana4);
                                $("#nilaisumber").attr("value",vvnsdana1);
                                $("#nilaisumber2").attr("value",vvnsdana2);
                                $("#nilaisumber3").attr("value",vvnsdana3);
                                $("#nilaisumber4").attr("value",vvnsdana4); 
                                

                              $("#cek_rek5").attr("value",vvnilaisusun);
                              status_k = rowData.status_keg;
                              cek_kas();
                              get_nilai_real_rek2();
                            //  alert('y');
                              tombol_keg(status_k); 
                              //alert('x');
                              
                              
                          },
                onLoadSuccess:function(data){
                            load_sum_rek();
                            load_sum_real();
                            cek_status_keg();         
                            
                          },
                columns:[[
                    {field:'id',
                     title:'id',
                     width:10,
                     hidden:true
                    },
                    {field:'kd_rek5',
                     title:'Rekening',
                     width:12,
                     align:'left'   
                    },
                    {field:'nm_rek5',
                     title:'Nama Rekening',
                     width:60
                    },

                    {field:'nilai_sempurna',
                     title:'Nilai Rek. Pergeseran',
                     width:30,
                     align:'right'
                     },
                    {field:'nilai',
                     title:'Nilai Penyusunan',
                     width:30,
                     align:'right'
                     },
                     {field:'rinci',
                      title:'Detail',
                      width:10,
                      align:'center', 
                      formatter:function(value,rec){
                            rek         = rec.kd_rek5
                            return ' <p onclick="javascript:section('+rec.kd_rek5+');">Rincian</p>';
                        }
                    }
                     /*
                     ,
                     {field:'hapus',title:'Hapus',width:10,align:"center",
                     formatter:function(value,rec){ 
                     return '<img src="<?php echo base_url(); ?>/assets/images/icon/edit_remove.png" onclick="javascript:hapus();" />';
                     }}
                     */
                ]]

            });
        });
        }

        
        function hitung(){    
        var tot = angka(document.getElementById('nilairek').value);
        var sdana1 = angka(document.getElementById('nilaisumber').value);
        var sdana2 = angka(document.getElementById('nilaisumber2').value);
        var sdana3 = angka(document.getElementById('nilaisumber3').value); 
        var sdana4 = angka(document.getElementById('nilaisumber4').value);
        

        tsd1=eval(sdana1+'+'+sdana2+'+'+sdana3+'+'+sdana4);
        $("#nilairek").attr("value",number_format(tsd1,2,'.',',')); 
                        
        
     }
        
        function validate_rek(){
            $(function(){
            $('#dg_rek').edatagrid({
                url          :  '<?php echo base_url(); ?>/index.php/rka/ld_rek/'+kegiatan+'/'+kdrek,
                idField      : 'id',                  
                rownumbers   : "true", 
                fitColumns   : "true",
                singleSelect : "true",
                showFooter   : true,
                nowrap       : false,                
                columns:[[
                    {field:'ck',
                     title:'ck',
                     checkbox:true,
                     hidden:true},
                    {field:'kd_rek5',
                     title:'Kode Rekening',
                     width:20,
                     align:'left'
                    },
                    {field:'nm_rek5',
                     title:'Nama Rekening',
                     width:80
                    }
                ]],
                    onClickRow:function(rowIndex, rowData){                                
                    rk    = rowData.kd_rek5;
                    nmrk  = rowData.nm_rek5;
                    nilai = 0;
                    sdana = 'PAD';                    
                    //simpan(rk,oldRek,nilai,sdana);   
                    }                       

            });
        });    
        }
        
        
        function hapus(){
                //cek_rek_susun();
               
                var rek5_susun = document.getElementById('cek_rek5').value ;  
                var nil_cek_kas = document.getElementById('cek_kas').value ;
                var nrekhapus = angka(document.getElementById('nilairek').value);
                var nkegsemp = angka(document.getElementById('rektotal').value);
                var nrealkegsemp = angka(document.getElementById('n_realkeg').value);
                var ncekreal = nkegsemp - nrekhapus;
              //  alert(ncekreal);
               // alert(nkegsemp);
               // alert(nrealkegsemp);

                if ( ncekreal < nrealkegsemp ) {
                    alert('ncekreal lebih kecil dari nrealkegsemp 1 < 3 Nilai Pergeseran Tidak Boleh lebih kecil dari Realisasi...!!!');
                    exit();
                }
                
                if ( nil_cek_kas > 0 ) {
                    alert('Rka Sudah di Buat Anggaran Kas...!!!, Hapus Dulu Anggaran Kas nya...!!!');
                    exit();
                }
                
                if ( rek5_susun > 0 ) {
                    alert('Rekening ini sudah ada di penetapan. Tidak bisa dihapus');
                    exit();
                }
                
                
                if ( status_apbd=='1' ){
                    alert("APBD TELAH DI SAHKAN...!!!  DATA TIDAK DAPAT DI HAPUS...!!!");
                    exit();
                }


                var cskpd2 = document.getElementById('skpdbp').value;          
                var cgiat = document.getElementById('giat').value;
                var cskpd = document.getElementById('skpd').value;
                var rek   = getSelections();
                if (rek !=''){
                var del=confirm('Anda yakin akan menghapus rekening '+rek+' ?');
                
                if  (del==true){
                    $(function(){
                        $('#dg').edatagrid({
                             url: '<?php echo base_url(); ?>/index.php/rka/thapus_sempurna/'+cskpd+'/'+cskpd2+'/'+cgiat+'/'+rek,
                             idField:'id',
                             toolbar:"#toolbar",              
                             rownumbers:"true", 
                             fitColumns:"true",
                             singleSelect:"true"
                        });
                    });
                    get_nilai_kua();
                    $("#kdrek5").combogrid("disable");
                    $("#kdrek5").combogrid("setValue",'');
                    $("#nilairek").attr("value",0);
                    $("#nilairekawal").attr("value",0);
                    document.getElementById('nmrek5').value = '';
                    $("#sdana1").combogrid("setValue",'');
                    $("#sdana2").combogrid("setValue",'');
                    $("#sdana3").combogrid("setValue",'');
                    $("#sdana4").combogrid("setValue",'');
                    
                    $("#dg").datagrid("unselectAll");
                    zfrek  = '';
                    zkdrek = '';
                    kosongkan_header();
                }
                
                }
        }


        function hapus_rinci(){
                  
                var cgiat = document.getElementById('giat').value;
                var cskpd = document.getElementById('skpd').value;
                var crek  = document.getElementById('reke').value;
                var norka = cskpd+'.'+cgiat+'.'+crek;
                var nopo  = document.getElementById('nopo').value;
                var urai  = document.getElementById('uraian').value;

                var total_awal = angka(document.getElementById('rektotal_rinci').value) ;
                var cek_po = document.getElementById('cek_po').value ;
                
                if ( cek_po == 1 ) {
                    alert('Rincian Penetapan Tidak Bisa Dihapus di Pergeseran');
                    exit();
                }

                var rows        = $('#dg1').edatagrid('getSelected');
                    urai        = rows.uraian ;
                var total_rinci = angka(rows.total) ;
                
                var cfm   = confirm("Hapus Uraian "+urai+" ?") ;
                
                if ( cfm == true ){

                    var idx   = $('#dg1').edatagrid('getRowIndex',rows);
                    $('#dg1').datagrid('deleteRow',idx);     
                    $('#dg1').datagrid('unselectAll');
                    
                    //var total_rincian = total_awal - total_rinci ;

                     var data = $('#dg1').datagrid('getData');
            var rows = data.rows;
            var total_rincian = 0;

            for (i=0; i < rows.length; i++) {
                total_rincian+=angka(rows[i].total_sempurna);
            }
                    $("#rektotal_rinci").attr("value",number_format(total_rincian,"2",'.',','));
                    
                   /* 
                    $(document).ready(function(){
                        $.ajax({
                               type     : 'POST',
                               dataType : 'json',
                               data     : ({vnorka:norka,vnopo:nopo}),
                               url      : '<?php echo base_url(); ?>index.php/rka/thapus_rinci_ar',
                               success  : function(data){
                                        st12=data;
                                        if ( st12=='0'){
                                            alert('Gagal Hapus...!!!');
                                        } else {
                                            section(crek);
                                            alert("Data Telah Terhapus...!!!");
                                        }
                               }    
                        });
                    });
                   */
                   alert('data berhasil dihilangkan, silahkan periksa kembali lalu simpan kembali !'); 
                }
            get_nilai_kua_rek(); 
            get_nilai_real_rek();   
        }
        
        
       

        function check_po(no){ 
        var cgiat = document.getElementById('giat').value;
        var cskpd = document.getElementById('skpd').value;
        var crek =  document.getElementById('reke').value;
        var norka  = cskpd+'.'+cgiat+'.'+crek;
          $.ajax({ 
                url:'<?php echo base_url(); ?>index.php/rka/cek_nopo_sempurna/'+norka+'/'+no,
                type: "POST",
                dataType:"json", 
                success:function(data){
                          //result = data;
                          $("#cek_po").attr("value",data);
                          $("#nopo").attr("value",no);
                    }

           }); 
        }  

        function detsimpan(){
         get_nilai_kua_rek();
         //get_nilai_real_rek();   
         $('#dg1').datagrid('unselectAll');    
        //var rektotal_rka  = angka(document.getElementById('rektotal_rka').value) ;
        var total_rinci  = angka(document.getElementById('rektotal_rinci').value) ;
        //alert(total_rinci)
        /*if (total_rinci!==0 && total_rinci!== rektotal_rka ){
            alert("Total Rincian Rekening tidak sama dengan Anggaran");
            exit();
            kosong();
            }
        */
        
        var cgiat = document.getElementById('giat').value;
        var cskpd = document.getElementById('skpd').value;
        var cskpd2 = document.getElementById('skpdbp').value;
        var crek =  document.getElementById('reke').value;
        var real_rek5 = angka(document.getElementById('nreal_rek').value);
        var norka  = cskpd+'.'+cgiat+'.'+crek;
        
        if ( cgiat=='' ){
            alert("Pilih Kegiatan Terlebih Dahulu...!!!");
            exit();
        }
        
        if ( crek=='' ){
            alert("Pilih Rekening Terlebih Dahulu...!!!");
            exit();
        }
        var total_rinci  = angka(document.getElementById('rektotal_rinci').value) ;

        var n_sisakua   = angka(document.getElementById('total_sisa_kua_rek').value) ;        
        var lcrek=crek.substr(0,1);           
        //alert(''+cgiat);

        if (( n_sisakua < total_rinci )&&(lcrek='5')){
            alert('Nilai Melebihi nilai KUA');
            exit();
        }
      
        if ((  total_rinci < real_rek5 )&&(lcrek='5')){
            alert('Nilai Anggaran kurang dari nilai Realisasi. Gagal Simpan');
            exit();
        }
        
        $('#dg1').datagrid('selectAll');
        var rows = $('#dg1').datagrid('getSelections');
        

        csql = " ";
        for(var i=0;i<rows.length;i++){     
            cheader   = rows[i].header;
            ckode     = rows[i].kode;
            curaian   = rows[i].uraian;
            curaian   = curaian.split("'").join("`");
            cvolume1  = rows[i].volume1;
            csatuan1  = rows[i].satuan1;
            cvolume2  = 0;
            csatuan2  = '';
            cvolume3  = 0;
            csatuan3  = '';
    /*      cvolume2  = rows[i].volume2;
            csatuan2  = rows[i].satuan2;
            cvolume3  = rows[i].volume3;
            csatuan3  = rows[i].satuan3; */
            cvolume   = rows[i].volume;
            charga1   = angka(rows[i].harga1);
            ctotal    = angka(rows[i].total);            
            cvolume_sempurna1  = rows[i].volume_sempurna1;
            csatuan_sempurna1  = rows[i].satuan_sempurna1;
            charga_sempurna1   = angka(rows[i].harga_sempurna1);
            ctotal_sempurna    = angka(rows[i].total_sempurna);            
            no        = i + 1 ;  
            

           
            if ( i > 0 ) {
                csql = csql+","+"('"+no+"','"+cheader+"','"+ckode+"','"+cgiat+"','"+crek+"','"+norka+"','"+curaian+"','"+cvolume1+"','"+csatuan1+"','"+charga1+"','"+ctotal+"','"+cvolume_sempurna1+"','"+csatuan_sempurna1+"','"+charga_sempurna1+"','"+ctotal_sempurna+"','"+cvolume2+"','"+csatuan2+"','"+cvolume2+"','"+csatuan2+"','"+cvolume3+"','"+csatuan3+"','"+cvolume3+"','"+csatuan3+"','"+cvolume+"','"+cvolume_sempurna1+"','"+cvolume_sempurna1+"','"+cvolume_sempurna1+"','"+cvolume3+"','"+cvolume_sempurna1+"','"+csatuan_sempurna1+"','"+csatuan_sempurna1+"','"+csatuan3+"','"+charga_sempurna1+"','"+charga_sempurna1+"','"+ctotal_sempurna+"','"+ctotal_sempurna+"')";
            } else {
                csql = "values('"+no+"','"+cheader+"','"+ckode+"','"+cgiat+"','"+crek+"','"+norka+"','"+curaian+"','"+cvolume1+"','"+csatuan1+"','"+charga1+"','"+ctotal+"','"+cvolume_sempurna1+"','"+csatuan_sempurna1+"','"+charga_sempurna1+"','"+ctotal_sempurna+"','"+cvolume2+"','"+csatuan2+"','"+cvolume2+"','"+csatuan2+"','"+cvolume3+"','"+csatuan3+"','"+cvolume3+"','"+csatuan3+"','"+cvolume+"','"+cvolume_sempurna1+"','"+cvolume_sempurna1+"','"+cvolume_sempurna1+"','"+cvolume3+"','"+cvolume_sempurna1+"','"+csatuan_sempurna1+"','"+csatuan_sempurna1+"','"+csatuan3+"','"+charga_sempurna1+"','"+charga_sempurna1+"','"+ctotal_sempurna+"','"+ctotal_sempurna+"')";                                            
            
            } 
            get_nilai_kua();
        }
        
        $(document).ready(function(){
                $.ajax({
                    type     : "POST",   
                    dataType : 'json',                 
                    data     : ({no:norka,sql:csql,skpd:cskpd,skpdbp:cskpd2,giat:cgiat,crek:crek}),
                    url      : '<?php echo base_url(); ?>/index.php/rka/tsimpan_rinci_jk_sempurna',
                    success  : function(data){                        
                        status = data.pesan; 
                         if (status=='1'){               
                            alert('Data Berhasil Tersimpan...!!!');
                        } else{ 
                            alert('Data Gagal Tersimpan...!!!');
                        }                                             
                    }
                });
                });  
                if (status=='1'){               
                            alert('Data Berhasil Tersimpan...!!!');
                        } else{ 
                            alert('Data Gagal Tersimpan...!!!');
                        }    
        $('#dg1').edatagrid('unselectAll');
        //$('#dg1').edatagrid('reload');
        get_nilai_kua();
        get_nilai_kua_rek();
        get_nilai_real_rek();
    }
        
    /*    
    $(function(){
            var mskpd = document.getElementById('skpd').value;
            var mgiat = document.getElementById('giat').value;
            $('#dg1').edatagrid({
                url: '<?php echo base_url(); ?>/index.php/rka/rka_rinci',
                 idField:'id',
                 toolbar:"#toolbar1",              
                 rownumbers:"true", 
                 fitColumns:false,
                 singleSelect:"true",
                 onAfterEdit:function(rowIndex, rowData, changes){                              
                             },
                 onSelect:function(rowIndex, rowData, changes){                         
                              detIndex=rowIndex;
                              po=rowData.no_po;
                              $("#noid").attr("value",detIndex);
                              $("#nopo").attr("value",po);  
                          },
                columns:[[
                    {field:'id',
                     title:'id',
                     width:20,
                     hidden:true,
                     editor:{type:"numberbox"}
                    },
                    {field:'no_po',
                     title:'no',
                     width:20,
                     hidden:true,
                     editor:{type:"numberbox"}
                    },
                    {field:'uraian',
                     title:'Uraian',
                     width:260,
                     editor:{type:"text"}
                    },
                    {field:'volume1',
                     title:'Vol 1',
                     width:35,
                     align:'right',
                     editor:{type:"numberbox",
                             options:{precision:0,groupSeparator:',',decimalSeparator:'.'}
                            } 
                     },
                    {field:'satuan1',
                     title:'Sat 1',
                     width:35,
                     align:'center',
                     editor:{type:"text"},
                     },
                    {field:'volume2',
                     title:'Vol 2',
                     width:35,
                     align:'right',
                     editor:{type:"numberbox",
                             options:{precision:0,groupSeparator:',',decimalSeparator:'.'}
                            } 
                     },
                    {field:'satuan2',
                     title:'Sat 2',
                     width:35,
                     align:'center',
                     editor:{type:"text"},
                     },
                    {field:'volume3',
                     title:'Vol 3',
                     width:35,
                     align:'right',
                     editor:{type:"numberbox",
                             options:{precision:0,groupSeparator:',',decimalSeparator:'.'}
                            } 
                     },
                    {field:'satuan3',
                     title:'Sat 3',
                     width:35,
                     align:'center',
                     editor:{type:"text"},
                     },
                    {field:'volume',
                     title:'T-Vol',
                     width:35,
                     align:'center'
                     },
                    {field:'harga1',
                     title:'Harga',
                     width:90,
                     align:'right',
                     editor:{type:"numberbox",
                             options:{precision:0,groupSeparator:',',decimalSeparator:'.'}
                            } 
                     },
                    {field:'total',
                     title:'Total',
                     width:130,
                     align:'right'
                     }
                ]]  
            
            });
        });
        */
        
        
            
        $(function(){
            var mskpd = document.getElementById('skpd').value;
            var mgiat = document.getElementById('giat').value;
            $('#dg1').edatagrid({
                 rowStyler:function(index,row){
                    if (row.header==1){
                    //return {class:'r1', style:{'color:#fff'}};
                        //return 'background-color:#6293BB;color:#fff;';
                       return 'color:red;font-weight:bold;';
                        //font-weight:bold;
                    }
                 },
                 url           : '<?php echo base_url(); ?>/index.php/rka/rka_rinci',
                 idField      : 'id',
                 toolbar      : "#toolbar1",              
                 rownumbers   : "true", 
                 fitColumns   : false,
                 singleSelect : "true",
                 onAfterEdit  : function(rowIndex, rowData, changes){                               
                                },
                 onSelect:function(rowIndex, rowData, changes){                         
                              detIndex=rowIndex;
                              po=rowData.no_po;
                              $("#noid").attr("value",detIndex);
                              $("#nopo").attr("value",po);  
                              
                          },
                columns:[[
                    {field:'id',
                     title:'id',
                     width:10,
                     hidden:true
                    },
                    {field:'header',
                     title:'Header',
                     width:20,
                     hidden:true
                    },
                    {field:'no_po',
                     title:'no',
                     width:20,
                     hidden:true
                    },
                    {field:'kode',
                     title:'kode',
                     width:40,
                     align:'left'
                     },
                    {field:'uraian',
                     title:'Uraian',
                     width:240
                    },
                    {field:'volume_sempurna1',
                     title:'Vol Sempurna',
                     width:100,
                     align:'right'
                     },
                    {field:'satuan_sempurna1',
                     title:'Sat Sempurna',
                     width:100,
                     align:'left'
                     },
                    {field:'harga_sempurna1',
                     title:'Harga Sempurna',
                     width:120,
                     align:'right'
                     },
                    {field:'total_sempurna',
                     title:'Total Sempurna',
                     width:160,
                     align:'right',
                     styler: function(value,row,index){
                                  return 'background-color:#d9e3fc;color:red;font-weight:bold;';
                            },
                     },
                    {field:'volume1',
                     title:'Volume',
                     width:50,
                     align:'right'
                     },
                    {field:'volume2',
                     title:'V 2',
                     width:35,
                     align:'right',
                     hidden:"true"
                     },
                    {field:'satuan1',
                     title:'Satuan',
                     width:50,
                     align:'left'
                     },
                    {field:'satuan2',
                     title:'S 2',
                     width:35,
                     align:'center',
                     hidden:true
                     },
                    {field:'volume3',
                     title:'V 3',
                     width:35,
                     align:'right',
                     hidden:true
                     },
                    {field:'satuan3',
                     title:'S 3',
                     width:35,
                     align:'center',
                     hidden:true
                     },
                    {field:'volume',
                     title:'T-VL',
                     width:50,
                     align:'center',
                     hidden:true
                     },
                    {field:'harga1',
                     title:'Harga',
                     width:150,
                     align:'right'
                     },
                    {field:'total',
                     title:'Total',
                     width:200,
                     align:'right',
                     styler: function(value,row,index){
                        return 'background-color:#d9e3fc;color:red;font-weight:bold;';
                     },
                     }
                ]]  
            });
        });
        

        $(document).ready(function() {
            $("#accordion").accordion();
        });
  
        
        function section(kdrek){
            

            var mskpd = document.getElementById('skpd').value;
            var mgiat = document.getElementById('giat').value;
            var a     = kdrek ;
            
            if ( mgiat=='' ){
                alert("Pilih Kegiatan Terlebih Dahulu...!!!");
            }
            
            if ( a=='' ){
                alert("Pilih Rekening Terlebih Dahulu...!!!");
            }
            

            $(document).ready(function(){
                
                 $("#reke").attr("value",a);            
                $('#section2').click();
                $(function(){
                    $('#dg1').edatagrid({
                         url          : '<?php echo base_url(); ?>/index.php/rka/rka_rinci/'+mskpd+'/'+mgiat+'/'+kdrek,
                         idField      : 'id',
                         toolbar      : "#toolbar1",              
                         rownumbers   : "true", 
                         fitColumns   : false,
                         title        : a,
                         singleSelect : "true",
                         onSelect     : function(rowIndex,rowData){
                                        stsheader    = rowData.header;
                                        if (stsheader==1){            
                                            $("#header_po_edit").attr("checked",true);
                                        } else {
                                            $("#header_po_edit").attr("checked",false);
                                        }
                                       $("#kode_edit").attr("value",rowData.kode) ;
                                       $("#uraian_edit").attr("value",rowData.uraian) ;
                                       $("#vol1_edit").attr("value",rowData.volume_sempurna1) ;
                                       $("#vol2_edit").attr("value",rowData.volume_sempurna2) ;
                                       $("#vol3_edit").attr("value",rowData.volume_sempurna3) ;
                                       $("#sat1_edit").attr("value",rowData.satuan_sempurna1) ;
                                       $("#sat2_edit").attr("value",rowData.satuan_sempurna2) ;
                                       $("#sat3_edit").attr("value",rowData.satuan_sempurna3) ;
                                       $("#harga_edit").attr("value",rowData.harga_sempurna1) ;
                                       $("#nopo_edit").attr("value",rowData.no_po) ;
                                       
                                       if (rowData.no_po == undefined || rowData.no_po == null) {
                                           check_po(0);         // do something 
                                       }else{
                                           check_po(rowData.no_po);                                        
                                       }
                                       
                                       var rows_e     = $('#dg1').edatagrid('getSelected');
                                       var idx_ins_e  = $('#dg1').edatagrid('getRowIndex',rows_e);
                                       
                                       
                                       var vol1_e  = rowData.volume_sempurna1 ;
                                       var vol2_e  = rowData.volume_sempurna2 ;
                                       var vol3_e  = rowData.volume_sempurna3 ;
                                       var harga_e = rowData.harga_sempurna1 ;
                                       
                                       if ( vol1_e == '' ){
                                            var vvol1_e = 1 ;
                                       } else {
                                            var vvol1_e = vol1_e ;
                                       }
                                       

                                       if ( vol2_e == '' ){
                                            var vvol2_e = 1 ;
                                       } else {
                                            var vvol2_e = vol2_e ;
                                       }
                                       

                                       if ( vol3_e == '' ){
                                            var vvol3_e = 1 ;
                                       } else {
                                            var vvol3_e = vol3_e ;
                                       }
                                       
                                       var ntotal_edit = vvol1_e * angka(harga_e) ;
                                       
                                       $("#noid_edit").attr("value",idx_ins_e);
                                       $("#total_edit").attr("value",ntotal_edit);
                                       get_nilai_real_rek();
                                       
                       },
                       onDblClickRow  : function(rowIndex,rowData){
                                        $("#dialog-modal-edit").dialog('open');
                                        document.getElementById('vol1_edit').focus() ;
                       },
                       /*onAfterEdit  : function(rowIndex, rowData, changes){                               
                                        urai = rowData.uraian;
                                        idx  = rowData.no_po;
                                        
                                        vol1=rowData.volume1;
                                        sat1=rowData.satuan1;
                                        har1=rowData.harga1;

                                        vol2=rowData.volume2;
                                        sat2=rowData.satuan2;

                                        vol3=rowData.volume3;
                                        sat3=rowData.satuan3;

                                        simpan_rincian(idx,urai,vol1,sat1,har1,vol2,sat2,vol3,sat3,kdrek);
                                     },*/
                        onLoadSuccess:function(data){
                                        load_sum_rek_rinci(kdrek);  
                                        load_sum_rek_rka(kdrek);
                                        get_nilai_kua_rek();
                                        get_nilai_real_rek();
                                     }
                    });
                });
                    
            });
        }

       function section1(){
         validate_combo();
         $(document).ready(function(){    
             $('#section1').click();                                               
         });
       }
       
       function section3(){
        // validate_combo();
         $(document).ready(function(){    
             $('#section3').click();                                               
         });
       }


    function load_sum_rek(){                
        var a = document.getElementById('skpd').value;
        var b = document.getElementById('giat').value;
        $(function(){      
         $.ajax({
            type: 'POST',
            data:({skpd:a,keg:b}),
            url:"<?php echo base_url(); ?>index.php/rka/load_sum_rek",
            dataType:"json",
            success:function(data){ 
                $.each(data, function(i,n){
                    $("#rektotal").attr("value",n['rektotal_sempurna']);
                });
            }
         });
        });
    }
    
    function load_sum_real(){                
        var a = document.getElementById('skpd').value;
        var b = document.getElementById('giat').value;
        $(function(){      
         $.ajax({
            type: 'POST',
            data:({skpd:a,keg:b}),
            url:"<?php echo base_url(); ?>index.php/rka/get_realisasi_keg",
            dataType:"json",
            success:function(data){ 
                $.each(data, function(i,n){
                    $("#n_realkeg").attr("value",n['nrealisasi']);
                });
            }
         });
        });
    }    

    function load_sum_rek_rinci(c){                
        var a = document.getElementById('skpd').value;
        var b = document.getElementById('giat').value;
        $(function(){      
         $.ajax({
            type: 'POST',
            data:({skpd:a,keg:b,rek:c}),
            url:"<?php echo base_url(); ?>index.php/rka/load_sum_rek_rinci_sempurna",
            dataType:"json",
            success:function(data){ 
                $.each(data, function(i,n){
                    $("#rektotal_rinci").attr("value",n['rektotal_rinci']);
                });
            }
         });
        });
    }
    
    
    function input(){
        $("#kdrek5").combogrid("setValue","");
        //$("#nilaimurni").combogrid("setValue","");
        var cek_giat = $("#kdgiat").combogrid('getValue');
        if ( cek_giat=='' ){
            alert('Pilih Kegiatan Terlebih Dahulu...!!!');
            exit();
        }
/*        
        if(nkegsemp < nrealkegsemp){
            alert('Nilai Penyempurnaan tidak boleh kurang dari realisasi!!!'); 
            exit();           
        }
*/        
        //$("#kdrek5").combogrid("setValue",'');
        $("#kdrek5").combogrid("enable");
        $("#kdrek5").combogrid("setValue",'');
        
        kosongkan_header();
        
        document.getElementById('nilaimurni').value    = 0;
        document.getElementById('nilairek').value    = 0;
        document.getElementById('nilairekawal').value    = 0;
        document.getElementById('nilairek').disabled = true;
        document.getElementById('nmrek5').value      = '';
        document.getElementById('nopo').value        = '';
        document.getElementById('n_realrek').value        = '0';
        
       validate_rekening();
    }
    


  
    function tambah(){
        get_nilai_kua();
        get_realisasi();
        load_sum_real();
        load_sum_rek();
        var skpd2   = document.getElementById('skpdbp').value;
        var skpd   = document.getElementById('skpd').value;
        var kegi   = $("#kdgiat").combogrid("getValue");
        var reke   = $("#kdrek5").combogrid("getValue");
        var nmrek5 = document.getElementById('nmrek5').value;
        var nrek   = angka(document.getElementById('nilairek').value) ;
        var sdana1 = $("#sdana1").combogrid("getValue");
        var sdana2 = $("#sdana2").combogrid("getValue");
        var sdana3 = $("#sdana3").combogrid("getValue");
        var sdana4 = $("#sdana4").combogrid("getValue");
        var ndana1   = angka(document.getElementById('nilaisumber').value) ;
        var ndana2   = angka(document.getElementById('nilaisumber2').value) ;
        var ndana3   = angka(document.getElementById('nilaisumber3').value) ;
        var ndana4   = angka(document.getElementById('nilaisumber4').value) ;
        var n_sisakua= angka(document.getElementById('sisa_nilai_kua').value) ;
        var real_t = angka(document.getElementById('total_realisasi').value);
        var real_keg = angka(document.getElementById('n_realkeg').value);
        var angg_keg = angka(document.getElementById('rektotal').value);
        var nrekawal = angka(document.getElementById('nilairekawal').value);
        var nmurni = angka(document.getElementById('nilaimurni').value);
        var nrealrek = angka(document.getElementById('n_realrek').value);
        var angg_cek =  angg_keg - (nrekawal-nrek);
        var akhir =  n_sisakua + nrekawal;
        var lkegi = kegi.length;
        var lreke = reke.length;
        lcrek=reke.substr(0,1);           
        lcrek1 = kegi.substr(16,6);


       if(lkegi!=22){
            alert('Digit Kode Kegiatan Salah!!!');
            return;
        }

        if(lreke!=7){
            alert('Digit Kode Rekening Salah!!!');
            return;
        }

        if (lcrek1!='00.002'){ 
    if (nrekawal!=nrek){
             alert('Nilai Tidak Sesuai Harap Periksa Rincian Terlebih dahulu !');
             return;
        }
        }

        if(( nrek > akhir )){
                alert('Nilai Anggaran Rekening Melebihi dari Sisa Plafond Cek Lagi');
                return;
            }

        if ( kegi == '' ){
            alert('Pilih Kode Kegiatan Terlebih Dahulu...!!!');
            exit();
        }
        if ( reke == '' ){
            alert('Pilih Rekening Terlebih Dahulu...!!!');
            exit();
        }
        lcrek=reke.substr(0,1);           
        
        lcrek1 = kegi.substr(16,5);
        
                 
        if(sdana1!=''){        
            switch (sdana1) {
                case sdana2:
                    alert('Ada Nama Sumber yg Sama!!!');
                    return;
                break;
                case sdana3:
                    alert('Ada Nama Sumber yg Sama!!!');
                    return;
                break;
                case sdana4:
                    alert('Ada Nama Sumber yg Sama!!!');
                    return;
                break;
            } 

        }

        if(sdana2!=''){                 
            switch (sdana2) {
                case sdana1:
                    alert('Ada Nama Sumber yg Sama!!!');
                    return;
                break;
                case sdana3:
                    alert('Ada Nama Sumber yg Sama!!!');
                    return;
                break;
                case sdana4:
                    alert('Ada Nama Sumber yg Sama!!!');
                    return;
                break;
            } 
        
        
        if(sdana3!=''){
            switch (sdana3) {
                case sdana2:
                    alert('Ada Nama Sumber yg Sama!!!');
                    return;
                break;
                case sdana1:
                    alert('Ada Nama Sumber yg Sama!!!');
                    return;
                break;
                case sdana4:
                    alert('Ada Nama Sumber yg Sama!!!');
                    return;
                break;
            } 
        }
        
        if(sdana4!=''){
            switch (sdana4) {
                case sdana2:
                    alert('Ada Nama Sumber yg Sama!!!');
                    return;
                break;
                case sdana3:
                    alert('Ada Nama Sumber yg Sama!!!');
                    return;
                break;
                case sdana1:
                    alert('Ada Nama Sumber yg Sama!!!');
                    return;
                break;
            }       
        }
        }
        
        
       
        if ((lcrek1!='00.51') & (lcrek1!='00.04')){
         /*
            if (( n_sisakua < nrek )&&(lcrek='5')){
                alert('Nilai Melebihi nilai KUA');
                exit();
            }
         */  
            if(( nrek < nrealrek )){
                alert('Nilai Anggaran Rekening Kurang dari nilai Realisasi Gagal Simpan');
                return;
            }              

        
            if(( angg_cek < real_keg )){
                alert('Nilai Anggaran Kegiatan Kurang dari nilai Realisasi Gagal Simpan');
                exit();
            }              
        }

        $("#dg").datagrid("selectAll");
        var rows = $("#dg").datagrid("getSelections");
        var jrow = rows.length - 1;
        jidx     = jrow + 1 ;
        
        $("#dg").edatagrid('appendRow',{kd_rek5:reke,nm_rek5:nmrek5,nilai:nrek});
        //$('#dg').datagrid('appendRow',{kd_kegiatan:xkdkegi,nm_kegiatan:xnmkegi,jns_kegiatan:xjns,lanjut:xljt});

        $(document).ready(function(){
        $.ajax({
           type     : "POST",
           dataType : "json",
           data     : ({kd_skpd:skpd,kd_skpd2:skpd2,kd_kegiatan:kegi,kd_rek5:reke,nilai:nrek,nilaimurni:nmurni,
                        dana1:sdana1,dana2:sdana2,dana3:sdana3,dana4:sdana4,
                        vdana1:ndana1,vdana2:ndana2,vdana3:ndana3,vdana4:ndana4}),
           url      : '<?php echo base_url(); ?>index.php/rka/tsimpan_sempurna', 
           success  : function(data){
                      st12 = data;
                      if ( st12 == '1' ){
                        alert("Data Tersimpan...!!!");
                        get_nilai_kua();
                        get_realisasi();
                        load_sum_real();
                        load_sum_rek();
                        

                      } else {
                        alert("Gagal Simpan...!!!");
                      }
                      }
        });
        });
        
        $("#dg").datagrid("unselectAll");
        validate_combo();
        $('#dg').datagrid('reload');
        $("#kdrek5").combogrid("disable");
        $("#kdrek5").combogrid("setValue",'');
        $("#nilairek").attr("value",0);
        $("#nilairekawal").attr("value",0);
        document.getElementById('nmrek5').value = '';
         
        kosongkan_header();
        get_nilai_kua();
        get_realisasi();
        load_sum_real();
        load_sum_rek();

    }
    
    
    function kosongkan_header(){
        $("#kdrek5").combogrid("disable");
        $("#kdrek5").combogrid("setValue",'');
        $("#nmrek5").attr("value",'');
        $("#sdana1").combogrid("setValue",'');
        $("#sdana2").combogrid("setValue",'');
        $("#sdana3").combogrid("setValue",'');
        $("#sdana4").combogrid("setValue",'');
        $("#nilaisumber").attr("value",0);
        $("#nilaisumber2").attr("value",0);
        $("#nilaisumber3").attr("value",0);
        $("#nilaisumber4").attr("value",0);
    }

    function btl(){
        //$("#kdrek5").combogrid("setValue",'');
        //$("#kdrek5").combogrid("setValue",'');
        $("#kdrek5").combogrid("disable");
        $("#sdana1").combogrid("setValue",'');
        $("#sdana2").combogrid("setValue",'');
        $("#sdana3").combogrid("setValue",'');
        $("#sdana4").combogrid("setValue",'');
        $("#nilaisumber").attr("value",0);
        $("#nilaisumber2").attr("value",0);
        $("#nilaisumber3").attr("value",0);
        $("#nilaisumber4").attr("value",0);  
        //$("#kdrek5").combogrid("disable");
        document.getElementById('nilairek').value = 0;
        document.getElementById('nilairekawal').value = 0;
        document.getElementById('nmrek5').value   = '';
        $("#dg").datagrid("unselectAll");
        
    }
    

    function keluar(){
        $("#dialog-modal").dialog('close');
        $('#dg_rek').datagrid('unselectAll');
        $('#dg').edatagrid('reload');
    } 
      

    function simpan_det_keg(){
        var a = document.getElementById('skpd').value;
        var aa = document.getElementById('skpdbp').value;
        var b = document.getElementById('giat').value;
        var cx = document.getElementById('lokasi').value;
        var c  = cx.split("'").join("`"); 
        var dx = document.getElementById('sasaran').value;
        var d  = dx.split("'").join("`");
        var ex = document.getElementById('wkeg').value;
        var e  = ex.split("'").join("`");
        var fx = document.getElementById('cp_tu').value;
        var f  = fx.split("'").join("`");
        var gx = document.getElementById('cp_ck').value;
        var g  = gx.split("'").join("`");
        var hx = document.getElementById('m_tu').value;
        var h  = hx.split("'").join("`");
        var ix = document.getElementById('m_ck').value; 
        var i  = ix.split("'").join("`");
        var jx = document.getElementById('k_tu').value;
        var j  = jx.split("'").join("`");
        var kx = document.getElementById('k_ck').value;
        var k  = kx.split("'").join("`");
        var lx = document.getElementById('h_tu').value;  
        var l  = lx.split("'").join("`");
        var mx = document.getElementById('h_ck').value;
        var m  = mx.split("'").join("`");
        var nx = document.getElementById('ttd').value;
        var n  = nx.split("'").join("`");
        var lalu = angka(document.getElementById('ang_lalu').value);
        if ( b=='' ){
            alert('Pilih Kegiatan Terlebih Dahulu...!!!');
            exit();
        }


        $(function(){      
         $.ajax({
            type: 'POST',
            data: ({skpd:a,skpdbp:aa,giat:b,lokasi:c,sasaran:d,wkeg:e,cp_tu:f,cp_ck:g,m_tu:h,m_ck:i,k_tu:j,k_ck:k,h_tu:l,h_ck:m,ttd:n,lalu:lalu}),
            dataType:"json",
            url:"<?php echo base_url(); ?>index.php/rka/simpan_det_keg_sempurna",
            success:function(data){ 
                    alert('Data Tersimpan');
                    }
         });
        });
    }




    function load_detail_keg(){                
        var a = document.getElementById('skpd').value;
        var b = document.getElementById('giat').value;
        $(function(){      
         $.ajax({
            type: 'POST',
            data:({skpd:a,keg:b}),
            url:"<?php echo base_url(); ?>index.php/rka/load_det_keg_sempurna",
            dataType:"json",
            success:function(data){ 
                $.each(data, function(i,n){
                    $("#ang_lalu").attr("value",n['ang_lalu']);
                    $("#lokasi").attr("value",n['lokasi']);
                    $("#sasaran").attr("value",n['sasaran']);
                    $("#wkeg").attr("value",n['wkeg']);
                    $("#ttd").attr("value",n['ttd']);
                    $("#cp_tu").attr("value",n['cp_tu']);
                    $("#m_tu").attr("value",n['m_tu']);
                    $("#k_tu").attr("value",n['k_tu']);
                    $("#h_tu").attr("value",n['h_tu']);
                    $("#cp_ck").attr("value",n['cp_ck']);
                    $("#m_ck").attr("value",n['m_ck']);
                    $("#k_ck").attr("value",n['k_ck']);
                    $("#h_ck").attr("value",n['h_ck']);
                });
            }
         });
        });
    }


        function insert(){
            $('#dg1').datagrid('insertRow',{
                index:detIndex,
                row:{uraian:''              
                    }
            });
            $('#dg1').datagrid('beginEdit',detIndex+1);     
        }   

        
        //DASAR HUKUM ==================================================================================================
        $(function(){ //load pertama
            var mskpd = document.getElementById('skpd').value;
            var mgiat = document.getElementById('giat').value;
            $('#dg2').edatagrid({
                url: '<?php echo base_url(); ?>/index.php/rka/rka_hukum/'+mskpd+'/'+mgiat,
                 idField:'id',
                 rownumbers:true, 
                 fitColumns:false,
                 singleSelect:false,
                 onLoadSuccess:function(data){
                                   selectall();      
                               },
                 columns:[[
                    {field:'kd_hukum',
                     title:'kode',
                     width:5,
                     hidden:true,
                     editor:{type:"text"}
                    },
                    {field:'nm_hukum',
                     title:'Dasar Hukum',
                     width:780,
                     editor:{type:"text"}
                    },
                    {field:'ck',
                     title:'ck',
                     width:5,
                     checkbox:true
                     }
                ]]  
            
            });
        });

    
    //load dasar hukum pada combo giat==========================================================
    var sell = new Array();
    var max  = 0;
    function getcek(){
        var ids = [];  
        var a=null;
        var rows = $('#dg2').edatagrid('getSelections');  
        for(var i=0; i<rows.length; i++){  
            a=rows[i].ck;
            max=i;
            if (a!=null){
                sell[i]=a-1;
            }else{
                sell[i]=1000;           
            }
        }  
    }
    
    function setcek(){
        for(var i=0; i<max+1; i++){ 
            if (sell[i]!=1000){
                selectRecord(sell[i]);
            }
        }       
    }


    function selectall(){
        max  = 0;
        $('#dg2').edatagrid('selectAll');
        getcek();
        Unselectall();
        setcek();
    }

    function Unselectall(){
        $('#dg2').edatagrid('unselectAll');
    }


    function selectRecord(rec){
        $('#dg2').edatagrid('selectRecord',rec);
    }
    
    function load_dhukum(){
        $(function(){
            var mskpd = document.getElementById('skpd').value;
            var mgiat = document.getElementById('giat').value;
            var mkdrek5 = $("#kdrek5").combogrid("getValue");
            //alert(mkdrek5);
            $('#dg2').edatagrid({
                url: '<?php echo base_url(); ?>/index.php/rka/rka_hukum/'+mskpd+'/'+mgiat+'/'+mkdrek5,
                 idField:'id',
                 rownumbers:true, 
                 fitColumns:false,
                 singleSelect:false,
                 columns:[[
                    {field:'kd_hukum',
                     title:'kode',
                     width:5,
                     hidden:true,
                     editor:{type:"text"}
                    },
                    {field:'nm_hukum',
                     title:'Dasar Hukum',
                     width:780,
                     editor:{type:"text"}
                    },
                    {field:'ck',
                     title:'ck',
                     width:5,
                     checkbox:true
                     }
                ]]  
            
            });
        });
        selectall();
    }


    function simpan_dhukum(){
        var ids = [];  
        var rows = $('#dg2').edatagrid('getSelections');  
        for(var i=0; i<rows.length; i++){  
            ids.push(rows[i].kd_hukum);
        }  
        hukum_cont(ids.join('||'));  
    }

    function hukum_cont(isi){
        var a = document.getElementById('skpd').value;
        var b = document.getElementById('giat').value;
        var mkdrek5 = $("#kdrek5").combogrid("getValue");
        //alert();
        $(function(){      
         $.ajax({
            type: 'POST',
            data: ({skpd:a,giat:b,cisi:isi,rek5:mkdrek5}),
            dataType:"json",
            url:"<?php echo base_url(); ?>index.php/rka/simpan_dhukum",
            success:function(data){ 
                    alert('Data Tersimpan');
                    }
         });
        });
    }
    
    function tombol(st){  
    
    if (st=='1'){
            $("#kdrek5").combogrid("disable");
            $('#add').linkbutton('disable');
            $('#input').linkbutton('disable');
            $('#btl').linkbutton('disable');
            $('#del').linkbutton('disable');
            $('#save').linkbutton('disable');
            $('#cancel').linkbutton('disable');
            $('#add1').linkbutton('disable');
            $('#del1').linkbutton('disable');
            $('#save1').linkbutton('disable');
            $('#cancel1').linkbutton('disable');
            $('#insert1').linkbutton('disable');
            $('#save2').linkbutton('disable');
            $('#save4').linkbutton('disable');
            document.getElementById("p1").innerHTML="APBD PERGESERAN TELAH DI - SAH - KAN...!!!";
            status_apbd = '1';
            
     } else {
            $('#add').linkbutton('enable');
            $('#input').linkbutton('enable');
            $('#btl').linkbutton('enable');
            $('#del').linkbutton('enable');
            $('#save').linkbutton('enable');
            $('#cancel').linkbutton('enable');
            $('#add1').linkbutton('enable');
            $('#del1').linkbutton('enable');
            $('#save1').linkbutton('enable');
            $('#cancel1').linkbutton('enable');
            $('#insert1').linkbutton('enable');
            $('#save2').linkbutton('enable');
            $('#save4').linkbutton('enable');
            
            document.getElementById("p1").innerHTML="";
            status_apbd = '0';
            
     }
    }
    
    
    function append_save() {
         
       
            var cgiat = document.getElementById('giat').value;
            var cskpd = document.getElementById('skpd').value;
            var crek  = document.getElementById('reke').value;
            var norka = cskpd+'.'+cgiat+'.'+crek;
            
            $("#dg1").datagrid("unselectAll");
            $('#dg1').datagrid('selectAll');
            var rows   = $('#dg1').datagrid('getSelections') ;
                jgrid  = rows.length ;
                
            var o       = document.getElementById('header_po').checked; 
            if ( o == false ){
                   o=0;
                }else{
                    o=1;
                }
            var kode_header = document.getElementById('kode_header').value;
            var uraian = document.getElementById('uraian').value;
            var vol1   = document.getElementById('vol1').value;
            if(uraian == ''){
                alert('Uraian Tidak Boleh Kosong!!');
                exit();
            }
            if(kode_header == ''){
                kode_header=1;
            }
            if ( vol1 == '' ){
                 volu1=1;
                 vol1=0;
            }else{
                volu1=vol1
            }
            var sat1 = document.getElementById('sat1').value;
            var vol2 = document.getElementById('vol2').value;
            if ( vol2 == '' ){
                 volu2=0;
            }else{
                volu2=vol2;
            }
            var sat2 = document.getElementById('sat2').value;
            var vol3 = document.getElementById('vol3').value;
            if ( vol3 == '' ){
                 volu3=0;
            }else{
                volu3=vol3;
            }
            var nilai  = document.getElementById('harga').value ;
            if ( nilai == '' ){
                var harga = 0;              
            }else {
                harga = angka(nilai);
            }
            
            var sat3   = document.getElementById('sat3').value;
            //var harga  = angka(nilai);
            
            var tvol   = volu1*volu2*volu3;
            var total  = volu1*harga;
            
            var fharga = number_format(harga,2,'.',',');           
            var ftotal = number_format(total,2,'.',',');           
            var total_awal  = angka(document.getElementById('rektotal_rinci').value) ;
            //var total_rinci = total + total_awal; 
            
            var n_sisakua   = angka(document.getElementById('total_sisa_kua_rek').value) ;
            var lcrek=crek.substr(0,1);           
            if (( n_sisakua < total_rinci )&&(lcrek='5')){
                alert('Nilai Melebihi nilai KUA');
                exit();
            }
            
            
            
            var id     = jgrid  ;
            
            $('#dg1').edatagrid('appendRow',{header:o,kode:kode_header,uraian:uraian,volume_sempurna1:vol1,satuan_sempurna1:sat1,tvolume_sempurna:tvol,harga_sempurna1:fharga,total_sempurna:ftotal,volume1:'0.00',satuan1:'',volume2:'0.00',satuan2:'',volume3:'0.00',volume:'0.00',satuan3:'',harga1:'0.00',id:id,total:'0.00'});
            $("#dg1").datagrid("unselectAll");
            

            var data = $('#dg1').datagrid('getData');
            var rows = data.rows;
            var total_rinci = 0;

            for (i=0; i < rows.length; i++) {
                total_rinci+=angka(rows[i].total_sempurna);
            }
           
            //alert(tvol);
            
            $("#rektotal_rinci").attr("value",number_format(total_rinci,2,'.',','));
            kosong();
            get_nilai_kua_rek();
            get_nilai_real_rek();
       }
       
       
       
       function insert_row() {
            var crek  = document.getElementById('reke').value;
            var rows     = $('#dg1').edatagrid('getSelected');
            var idx_ins  = $('#dg1').edatagrid('getRowIndex',rows);
                
            if ( idx_ins == -1){
                alert("Pilih Lokasi Insert Terlebih Dahulu...!!!") ;
                exit();
            }

            $('#dg1').datagrid('selectAll');
            var rows_grid = $('#dg1').datagrid('getSelections');
            for ( var i=idx_ins; i<rows_grid.length; i++ ) {            
                  $('#dg1').edatagrid('updateRow',{index:i,row:{id:i+1,no_po:i+1}});
            }
            $('#dg1').datagrid('unselectAll');
            
            var o       = document.getElementById('header_po').checked; 
            if ( o == false ){
                   o=0;
                }else{
                    o=1;
                }
            var kode_header = document.getElementById('kode_header').value;
            if (kode_header==''){
            kode_header = 1;
            }            
            var uraian = document.getElementById('uraian').value;
            if (uraian==''){
                alert('Isi Uraian Terlebih dahulu!');
                exit();
            }
            var vol1   = document.getElementById('vol1').value;
            if ( vol1 == '' ){
                 volu1=0;
            }else{
                volu1=vol1
            }
            var sat1 = document.getElementById('sat1').value;
            var vol2 = document.getElementById('vol2').value;
            if ( vol2 == '' ){
                 volu2=0;
            }else{
                volu2=vol2;
            }
            var sat2 = document.getElementById('sat2').value;
            var vol3 = document.getElementById('vol3').value;
            if ( vol3 == '' ){
                 volu3=0;
            }else{
                volu3=vol3;
            }
            var sat3   = document.getElementById('sat3').value;
            var nilai  = document.getElementById('harga').value;
            var harga  = angka(nilai) ;
            var tvol   = volu1*volu2*volu3;
            var total  = volu1*harga;
            
            var total_awal  = angka(document.getElementById('rektotal_rinci').value) ;
            //var total_rinci = total + total_awal; 
            
            var n_sisakua   = angka(document.getElementById('total_sisa_kua_rek').value) ;
            var lcrek=crek.substr(0,1);           
            if (( n_sisakua < total_rinci )&&(lcrek='5')){
                alert('Nilai Melebihi nilai KUA');
                exit();
            }
            
            harga = number_format(harga,2,'.',',');
            total = number_format(total,2,'.',',');
       
            $('#dg1').edatagrid('insertRow',{index:idx_ins,row:{header:o,kode:kode_header,uraian:uraian,volume_sempurna1:volu1,volume1:'0.00',satuan_sempurna1:sat1,harga_sempurna1:harga,total_sempurna:total,satuan1:' ',volume2:'0.00',satuan2:'',volume3:'0.00',volume:'0.00',satuan3:'',harga1:'0.00',id:id,total:'0.00',id:idx_ins,no_po:idx_ins}});
            $("#dg1").datagrid("unselectAll");
            
            var data = $('#dg1').datagrid('getData');
            var rows = data.rows;
            var total_rinci = 0;

            for (i=0; i < rows.length; i++) {
                total_rinci+=angka(rows[i].total_sempurna);
            }

            $("#rektotal_rinci").attr("value",number_format(total_rinci,2,'.',','));
            
            kosong();
            
    }
       
    
    function kosong(){
            $("#uraian").attr("value","");
            $("#vol1").attr("value","");
            $("#sat1").attr("value","");
            $("#vol2").attr("value","");
            $("#sat2").attr("value","");
            $("#vol3").attr("value","");
            $("#sat3").attr("value","");
            $("#harga").attr("value","");
            $("#no_po").attr("value","");
            document.getElementById('kode_header').focus();
            $("#header_po").attr("checked",false);                  

            
    }
        
    
    function enter(ckey,_cid){
        if (ckey==13)
            {                                  
               document.getElementById(_cid).focus();
               if(_cid=='uraian'){
                    var as_kdgiat = $("#kdgiat").combogrid("getValue") ;
                    var as_reke   = document.getElementById('reke').value ;
                    
                    if ( as_kdgiat=='' ){
                        alert('Pilih Kegiatan Terlebih Dahulu...!!!');
                        exit();
                    }
                    if ( as_reke=='' ){
                        alert("Pilih Rekening Terlebih Dahulu...!!!");
                        exit();
                    }
                    append_save();
               }
            }     
        }
        
      
     function standard_harga(){

        $("#dialog-modal").dialog("open");
        var crekening = document.getElementById('reke').value ;
        //alert(crekening);
        $('#dg_std').edatagrid({
        url: '<?php echo base_url(); ?>/index.php/master/load_daftar_harga_detail_ck',
        queryParams   : ({rekening:crekening}),
        idField       : 'id',
        rownumbers    : true, 
        fitColumns    : false,
        singleSelect  : false,
        columns       : [[{field:'id',        title:'id',           width:70, align:"left",hidden:"true"},
                          //{field:'no_urut',   title:'No Urut',      width:70, align:"left",hidden:"true"},
                          {field:'kd_rek5',   title:'Rekening',     width:80, align:"left",hidden:"true"},
                          {field:'uraian',    title:'Uraian',       width:510,align:"left"},
                          //{field:'merk',      title:'Merk',         width:100,align:"left"},
                          {field:'satuan',    title:'Satuan',       width:100,align:"left"},
                          {field:'harga',     title:'Harga',        width:150,align:"right"},
                          {field:'ck',        title:'ck',           checkbox:true}
                         ]]
        });
        selectall_std();         
     }   
     
     function kembali_std(){
        $("#section2").click();
        $("#dialog-modal").dialog("close");
     }

     var sell_std = new Array();
     var max_std  = 0;
      
     function getcek_std(){
        var ids   = [];  
        var a     = null;
        var rows  = $('#dg_std').edatagrid('getSelections');  
        for(var i=0; i<rows.length; i++){  
            a       = rows[i].ck;
            max_std = i;
            if (a!=null){
                sell_std[i]=a-1;
            }else{
                sell_std[i]=1000;           
            }
        }  
      }
    
     
     function setcek_std(){
        for(var i=0; i<max+1; i++){ 
            if (sell_std[i]!=1000){
                selectRecord_std(sell_std[i]);
            }
        }       
     }


     function selectall_std(){
        max_std = 0;
        $('#dg_std').edatagrid('selectAll');
        getcek_std();
        Unselectall_std();
        setcek_std();
     }

     
     function Unselectall_std(){
        $('#dg_std').edatagrid('unselectAll');
     }
     
     function selectRecord_std(rec){
        $('#dg_std').edatagrid('selectRecord',rec);
     }
     
     function pilih_std(){

        var ids  = [];  
        var rows = $('#dg_std').edatagrid('getSelections');  
        for(var i=0; i<rows.length; i++){  

            var urai_std  = rows[i].uraian;
            var satu_std  = rows[i].satuan;
            var harga_std = rows[i].harga;
            
            var vol1      = 1;
            var vol2      = '';
            var vol3      = '';
            var tvol      = vol1;

            var sat2      = '';
            var sat3      = '';
            
            var fharga    = number_format(harga_std,2,'.',',');
            var ftotal    = number_format(harga_std,2,'.',',');
            var total     = harga_std;
            
            $("#dg1").datagrid("unselectAll");
            $('#dg1').datagrid('selectAll');
            var rows_2 = $('#dg1').datagrid('getSelections') ;
                jgrid  = rows_2.length ;
           
            var id     = jgrid  ;
            
            $('#dg1').edatagrid('appendRow',{uraian:urai_std,volume1:vol1,satuan1:satu_std,volume2:vol2,satuan2:sat2,volume3:vol3,volume:tvol,satuan3:sat3,harga1:fharga,id:id,total:ftotal});
            $("#dg1").datagrid("unselectAll");
            
            var total_awal  = angka(document.getElementById('rektotal_rinci').value) ;
            var total_rinci = angka(total)
                total_rinci = total_rinci + total_awal; 
            
            $("#rektotal_rinci").attr("value",number_format(total_rinci,2,'.',','));
            kosong();
            $("#dialog-modal").dialog("close");
            
        }  
    }
    
    function kembali_edit(){
        $("#section2").click();
        $("#dialog-modal-edit").dialog("close");
    }
    
    
    function pilih_edit(){
            get_nilai_kua();
            var n_sisakuax   = angka(document.getElementById('total_sisa_kua_rek').value) ; 
            
            var o       = document.getElementById('header_po_edit').checked; 
                if ( o == false ){
                       o=0;
                    }else{
                        o=1;
                    }
            var kode_edit = document.getElementById('kode_edit').value;
            var uraian_edit = document.getElementById('uraian_edit').value;
            var vol1_edit   = document.getElementById('vol1_edit').value;
            if ( kode_edit == '' ){
                 kode_edit = 0;
            }
            if ( vol1_edit == '' ){
                 volu1_edit = 0;
            }else{
                volu1_edit  = vol1_edit;
            }
   
            var sat1_edit = document.getElementById('sat1_edit').value;
            var vol2_edit = document.getElementById('vol2_edit').value;
            
            if ( vol2_edit == '' ){
                 volu2_edit = 0 ;
            }else{
                volu2_edit  = vol2_edit;
            }
            
            var sat2_edit = document.getElementById('sat2_edit').value;
            var vol3_edit = document.getElementById('vol3_edit').value;
            
            if ( vol3_edit == '' ){
                 volu3_edit = 0 ;
            }else{
                volu3_edit = vol3_edit ;
            }
            
            var sat3_edit   = document.getElementById('sat3_edit').value;
            var nilai_edit  = document.getElementById('harga_edit').value ;
            
            var harga_edit  = angka(nilai_edit) ;
            var tvol_edit   = volu1_edit;
            var total_edit  = volu1_edit*harga_edit;

            var fharga_edit = number_format(harga_edit,2,'.',',');           
            var ftotal_edit = number_format(total_edit,2,'.',',');      
            
            if ( n_sisakuax < total_edit ){
                alert('Nilai Melebihi nilai KUA');
                exit();
            }      
            
            var idx_ins_edit  = document.getElementById('noid_edit').value;
            
            //$('#dg1').edatagrid('updateRow',{index:idx_ins_edit,row:{header:o,kode:kode_edit,uraian:uraian_edit,volume1:volu1_edit,satuan1:sat1_edit,volume2:volu2_edit,satuan2:sat2_edit,volume3:volu3_edit,volume:tvol_edit,satuan3:sat3_edit,harga1:fharga_edit,total:ftotal_edit}});
            $('#dg1').edatagrid('updateRow',{index:idx_ins_edit,row:{header:o,kode:kode_edit,uraian:uraian_edit,volume_sempurna1:volu1_edit,satuan_sempurna1:sat1_edit,volume_sempurna:tvol_edit,harga_sempurna1:fharga_edit,total_sempurna:ftotal_edit}});
            
            $("#dg1").datagrid("unselectAll");
            
            var total_pertama    = angka(document.getElementById('total_edit').value) ;
            //alert(total_pertama);
            var total_awal_edit  = angka(document.getElementById('rektotal_rinci').value) ;
            var total_rinci_edit = total_edit ;
                total_rinci_edit = total_rinci_edit + total_awal_edit - total_pertama ; 
                        
            $("#rektotal_rinci").attr("value",number_format(total_rinci_edit,2,'.',','));
            $("#dialog-modal-edit").dialog('close');
            //$("#dg1").datagrid("reload");

            kosong();
            
            //$("#dg1").datagrid("reload");
    
    }
    
    
     function copy_edit(){
            var kode_copy = document.getElementById('uraian_edit').value;
            var uraian_copy = document.getElementById('uraian_edit').value;
            var vol1_copy   = document.getElementById('vol1_edit').value;
            if ( vol1_copy == '' ){
                 volu1_copy = 1;
            }else{
                volu1_copy  = vol1_copy;
            }
            var sat1_copy = document.getElementById('sat1_edit').value;
            var vol2_copy = document.getElementById('vol2_edit').value;
            
            if ( vol2_copy == '' ){
                 volu2_copy = 1 ;
            }else{
                volu2_copy  = vol2_copy;
            }
            var sat2_copy = document.getElementById('sat2_edit').value;
            var vol3_copy = document.getElementById('vol3_edit').value;
            if ( vol3_copy == '' ){
                 volu3_copy = 1 ;
            }else{
                volu3_copy = vol3_copy ;
            }
            var sat3_copy   = document.getElementById('sat3_edit').value;
            var nilai_copy  = document.getElementById('harga_edit').value ;
            $("#dialog-modal-edit").dialog('close');
            kosong();
    }

    function paste_copy(){
            var uraian_copy = document.getElementById('uraian_edit').value;
            var vol1_copy   = document.getElementById('vol1_edit').value;
            if ( vol1_copy == '' ){
                 volu1_copy = 1;
            }else{
                volu1_copy  = vol1_copy;
            }
            var sat1_copy = document.getElementById('sat1_edit').value;
            var vol2_copy = document.getElementById('vol2_edit').value;
            
            if ( vol2_copy == '' ){
                 volu2_copy = 1 ;
            }else{
                volu2_copy  = vol2_copy;
            }
            var sat2_copy = document.getElementById('sat2_edit').value;
            var vol3_copy = document.getElementById('vol3_edit').value;
            if ( vol3_copy == '' ){
                 volu3_copy = 1 ;
            }else{
                volu3_copy = vol3_copy ;
            }
            var sat3_copy   = document.getElementById('sat3_edit').value;
            var nilai_copy  = document.getElementById('harga_edit').value ;
            $("#dialog-modal-edit").dialog('close');
            kosong();
            
            $("#kode_header").attr("value",kode_copy);
            $("#uraian").attr("value",uraian_copy);
            $("#vol1").attr("value",volu1_copy);
            $("#sat1").attr("value",sat1_copy);
            $("#vol2").attr("value",volu2_copy);
            $("#sat2").attr("value",sat2_copy);
            $("#vol3").attr("value",volu3_copy);
            $("#sat3").attr("value",sat3_copy);
            $("#harga").attr("value",nilai_copy);
            document.getElementById('harga').focus();
            
    }



    function cek_status_keg(){
        var a = document.getElementById('skpd').value;
        var b = document.getElementById('giat').value;
        if(a == 'undefined'){
            a = '';
            b = '';
        };
        $.ajax({
                url:'<?php echo base_url(); ?>index.php/rka/status_keg',
                type: "POST",
                dataType:"json",
                data      : ({kdskpd:a,keg:b}),                         
                success:function(data){
                                        sta    = data.status_keg;
                                        tombol_keg(sta);
                                      }                                     
            });        
       } 

     function tombol_keg(st){  
     if (st=='1'){   
        document.getElementById("id_aktif").innerHTML="Kegiatan Sudah Aktif";
        id_aktif.style.color="green";
     } else {
        document.getElementById("id_aktif").innerHTML="Kegiatan Tidak Aktif";
        id_aktif.style.color="red";
     }
    }


      function aktif_keg(){
        //var cno = document.getElementById('nomor').value;
        //var cno_hide = document.getElementById('nomor_hide').value;
        var cskpd = document.getElementById('skpd').value;
        var cgiat = document.getElementById('giat').value;
        //var status_keg_aktif=0;
        var status_cek=0;
        //$(document).ready(function(){
        var status_skrg = document.getElementById("id_aktif").innerHTML
        if(status_skrg=='Kegiatan Sudah Aktif'){
            status_keg_aktif=0; //jadi tidak aktif
        }else{
            status_keg_aktif=1; 
        }
        
        
        $(document).ready(function(){

            $.ajax({
                type: "POST",    
                dataType:'json',                            
                data: ({tabel:'trhspd',mode_tox:'edit',kdgiat:cgiat,status_keg1:status_keg_aktif,kd_skpd:cskpd}),
                url: '<?php echo base_url(); ?>/index.php/rka/update_status_keg',
                success:function(data){
                    status = data;
                    if (status=='5'){
                        alert('Data Gagal Tersimpan...!!!');                    
                    }else{ 
                        if (status=='1'){
                          //$('#dg').edatagrid('reload');
                           document.getElementById("id_aktif").innerHTML="Kegiatan Sudah Aktif";
                           //document.getElementById("p1").innerHTML="SPD AKTIF";
                           status_keg=1;
                           tombol_keg(status_keg);
                          //section1();
                        }else{
                            
                              //$('#dg').edatagrid('reload');
                               document.getElementById("id_aktif").innerHTML="Kegiatan Tidak Aktif";
                               //document.getElementById("p1").innerHTML="SPD NON AKTIF";
                              status_keg=0;
                               tombol_keg(status_keg);
                        //  section1();
                            
                        }
                    }
                }
            });
        });
        
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

   <?php echo $prev; ?><p id="p1" style="font-size: x-large;color: red;"></p><br />
   <table style="border-collapse:collapse;border-style:hidden;" width="100%" align="center" border="0" cellspacing="0" cellpadding="0">
   <tr style="border-style:hidden;">
   <td>S K P D&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <input id="sskpd" name="sskpd" style="width:170px;border: 0;" />
   
   &nbsp;&nbsp;<input id="nmskpd" name="nmskpd" readonly="true" style="width: 620px; border:0;  " /></td>
   </tr>
   <tr style="border-style:hidden;">
   <td>KEGIATAN&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="kdgiat" name="kdgiat" style="width:170px;" />  
   &nbsp;&nbsp;&nbsp;<input id="nmgiat" name="nmgiat" readonly="true" style="width:620px;border:0;background-color:transparent;color: black;" disabled="true"/>
   <input type="hidden" id="jnskegi" name="jnskegi" style="width:20px;" />
   <input type="hidden" id="skpdbp" name="skpdbp" style="width:20px;" /></td>
   </tr>
   </table>

<div id="accordion">



<h2><a href="#" id="section1" onclick="javascript:validate_combo()">Rekening Anggaran Pergeseran</a></h2>
   
   <div  style="height:700px;">      
   
       <table border='1'  style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;width:880px;border-style: ridge;" >
       
       <tr style="border-bottom-style:hidden;">
       <td colspan="5" style="border-bottom-style:hidden;"></td>
       </tr>
       
       <tr style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:110px;border-bottom-style:hidden;border-right-style:hidden;">REKENING</td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:770px;border-bottom-style:hidden;" colspan="4">   <input id="kdrek5" name="kdrek5" style="width:170px;" /><input type="hidden"  id="cek_rek5" name="cek_rek5" style="width:170px;"/> 
           <input id="nmrek5" name="nmrek5" readonly="true" style="width:570px;border:0;background-color:transparent;color:black;" disabled="true" />
       </td>
       </tr>
       
       <tr style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:110px;border-bottom-style:hidden;border-right-style:hidden;">SUMBER DANA</td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;"><input id="sdana1" name="sdana1" style="width:170px;"/></td>  
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;"><input id="sdana2" name="sdana2" style="width:170px;"/></td>  
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;"><input id="sdana3" name="sdana3" style="width:170px;"/></td> 
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:260px;border-bottom-style:hidden;"><input id="sdana4" name="sdana4" style="width:170px;"/></td> 
       </tr>
       <tr style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:110px;border-bottom-style:hidden;border-right-style:hidden;">NILAI S.DANA</td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;"><input id="nilaisumber" name="nilaisumber"  value='0.00' type="decimal" style="width:170px;text-align:right;" onkeyup="javascript:hitung();" onkeypress="javascript:return(currencyFormat(this,',','.',event))"/></td>  
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;"><input id="nilaisumber2" name="nilaisumber2" type="decimal" value='0.00'  style="width:170px;text-align:right;" onkeyup="javascript:hitung();" onkeypress="javascript:return(currencyFormat(this,',','.',event))"/></td>  
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;"><input id="nilaisumber3" name="nilaisumber3" type="decimal" value='0.00'  style="width:170px;text-align:right;" onkeyup="javascript:hitung();" onkeypress="javascript:return(currencyFormat(this,',','.',event))"/></td> 
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:260px;border-bottom-style:hidden;"><input id="nilaisumber4" type="decimal" disabled name="nilaisumber4" value='0.00' style="width:170px;text-align:right;" onkeyup="javascript:hitung();" onkeypress="javascript:return(currencyFormat(this,',','.',event))"/></td> 
       </tr>
       <tr style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:110px;border-bottom-style:hidden;border-right-style:hidden;">NILAI</td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;"><input id="nilairek" name="nilairek" disabled style="width:170px;text-align:right;" onkeypress="javascript:enter(event.keyCode,'add');return(currencyFormat(this,',','.',event))"/>
       <input type="hidden" id="cek_kas" name="cek_kas" style="width:170px;text-align:right;"/>
       <input type="hidden" id="nilairekawal" name="nilairekawal" value="0" style="width:170px;text-align:right;"/>
       <input type="hidden" id="nilaimurni" name="nilaimurni" value="0" style="width:170px;text-align:right;"/>
       </td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:600px;border-bottom-style:hidden;" colspan="3"></td>
       </tr>
       <tr style="border-bottom-style:hidden;">
       <td colspan="5" align="center" style="border-bottom-style:hidden;">
       <button id="input" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:input()">Tambah</button>
       <button id="btl" class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:btl()">Batal</button>
       <button id="delrek" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:hapus()">Hapus</button>
       <button id="add" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:tambah()">Simpan</button>
       <a class="easyui-linkbutton" iconCls="icon-ok" plain="true" onclick="javascript:aktif_keg();" align="left"><b id="id_aktif"></b></a>
       </td>
       </tr>
       <tr style="border-bottom-color:black;height:1px;" >
       <td colspan="5" style="border-bottom-color:black;height:1px;"></td>
       </tr>
       </table>
       
       <!--<table border='0' width="100%" >
       <tr>
       <td align='right'>
       <button id="add" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:tambah()">Tambah</button>
       <button id="del" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:hapus();">Hapus</button>
       <button id="save" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:$('#dg').edatagrid('addRow');">Simpan</button>
       <button id="cancel" class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:$('#dg').edatagrid('cancelRow')">Batal</button>
       </td>
       </tr>
       </table>-->
       
       <table id="dg" title="Input Rekening Kegiatan Anggaran Pergeseran" style="width:880px;height:400px;" >          
       </table>  
        <div id="toolbarx">
            &nbsp;&nbsp; <button type="hidden" class="easyui-linkbutton" iconCls="icon-reload" plain="true" onclick="javascript:refresh()">Refresh Tabel</button>
            <!--<button  class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:section3()">Hukum</button>
            <!--<button id="del" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:hapus();">Hapus</button>-->
            <!--<button id="save" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:$('#dg').edatagrid('addRow');">Simpan</button>-->
            <!--<button id="cancel" class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:$('#dg').edatagrid('cancelRow')">Batal</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-->
            <table style="width:880px;height:10px;border-style:hidden;" >
            <tr><td align="right">
            <!--<button id="reload" class="easyui-linkbutton" iconCls="icon-reload" plain="true" onclick="javascript:refresh();">Refresh Tabel</button>-->&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            <B>Total Pergeseran</B>&nbsp;&nbsp;<input class="right" type="text" name="rektotal" id="rektotal"  style="width:200px;text-align:right;"  readonly="true"/>
            </td></tr>
            <tr><td align="right">
            <button id="reload" class="easyui-linkbutton" iconCls="icon-reload" plain="true" onclick="javascript:get_nilai_kua();">Refresh Nilai KUA</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <B>Plafond (KUA-PPAS)</B>&nbsp;&nbsp;<input class="right" type="text" name="nilai_kua" id="nilai_kua"  style="width:200px;text-align:right;"  readonly="true"/>
            </td></tr>
            <tr><td align="right">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <B>Total Belanja</B>&nbsp;&nbsp;<input class="right" type="text" name="nilai_kua_ang" id="nilai_kua_ang"  style="width:200px;text-align:right;"  readonly="true"/>
            </td></tr>
            <tr><td align="right">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <B>Sisa Plafond (KUA-PPAS)</B>&nbsp;&nbsp;<input class="right" type="text" name="sisa_nilai_kua" id="sisa_nilai_kua"  style="width:200px;text-align:right;"  readonly="true"/>
            </td>
            </tr>
            <tr><td align="right">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <B>Total Realisasi</B>&nbsp;&nbsp;<input class="right" type="text" name="total_realisasi" id="total_realisasi"  value='0.00' style="width:200px;text-align:right;"  readonly="true"/>
            </td>
            </tr>
            <tr><td align="right">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <B>Realisasi Keg.</B>&nbsp;&nbsp;<input class="right" type="text" name="n_realkeg" id="n_realkeg"  value='0.00' style="width:200px;text-align:right;"  readonly="true"/>
            </td>
            </tr>
            <tr><td align="right">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <B>Realisasi Rek.</B>&nbsp;&nbsp;<input class="right" type="text" name="n_realrek" id="n_realrek"  value='999,999,999,999,999,999.00' style="width:200px;text-align:right;"  readonly="true"/>
            </td>
            </tr>
 
            </table>
        </div>
    </div>
    
<h3><a href="#" id="section2">Rincian Rekening Pergeseran</a></h3>
    
    <div>

       
        <table border='1' style="width:800px;">
        <tr style="border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
            <td colspan='8' style="border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;"><input type="hidden" id="noid" style="width: 200px;" /><input type="hidden" id="nopo" style="width: 200px;" /><input type="hidden" id="reke" style="width: 200px;" /></td>
       
        <tr style="border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
            <td style="border-right-style:hidden; border-bottom-style:hidden;border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;">Header</td>
            <td style="border-right-style:hidden; border-bottom-style:hidden;border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;">Kode</td>
            <td style="border-right-style:hidden; border-bottom-style:hidden;border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;">Uraian</td>
            <td style="border-right-style:hidden; border-bottom-style:hidden;border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;">Vol1</td>
            <td style="border-right-style:hidden; border-bottom-style:hidden;border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;">Sat1</td>
            <td style="border-bottom-style:hidden;border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;">Harga</td>
        </tr>
        <tr style="border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;">
            <td style="text-align:center; border-right-style:hidden; border-bottom-color:black;border-style-bottom:hidden;border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;"> <input type="checkbox" id="header_po" style="width: 30px;" onkeypress="javascript:enter(event.keyCode,'uraian');"/></td>
            <td style="text-align:center; border-right-style:hidden; border-bottom-color:black;border-style-bottom:hidden;border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;"> <input type="number" id="kode_header" style="width: 30px;" onkeypress="javascript:enter(event.keyCode,'kode_header');"/></td>
            <td style="text-align:center; border-right-style:hidden; border-bottom-color:black;border-style-bottom:hidden;border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;"> <input type="text" id="uraian" style="width: 400px;" onkeypress="javascript:enter(event.keyCode,'vol1');"/></td>
            <td style="border-right-style:hidden; border-bottom-color:black;border-style-bottom:hidden;border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;"><input type="number" id="vol1" style="width: 80px;" onkeypress="javascript:enter(event.keyCode,'sat1');"/></td>
            <td style="border-right-style:hidden; border-bottom-color:black;border-style-bottom:hidden;border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;"><input type="text" id="sat1" style="width: 90px;" onkeypress="javascript:enter(event.keyCode,'harga');"/></td>
            <td hidden="true" style="border-right-style:hidden; border-bottom-color:black;border-style-bottom:hidden;border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;"><input type="text" id="vol2" style="width: 90px;" onkeypress="javascript:enter(event.keyCode,'sat2');"/></td>
            <td hidden="true" style="border-right-style:hidden; border-bottom-color:black;border-style-bottom:hidden;border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;"><input type="text" id="sat2" style="width: 90px;" onkeypress="javascript:enter(event.keyCode,'vol3');"/></td>
            <td hidden="true" style="border-right-style:hidden; border-bottom-color:black;border-style-bottom:hidden;border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;"><input type="text" id="vol3" style="width: 90px;" onkeypress="javascript:enter(event.keyCode,'sat3');"/></td>
            <td hidden="true" style="border-right-style:hidden; border-bottom-color:black;border-style-bottom:hidden;border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;"><input type="text" id="sat3" style="width: 90px;" onkeypress="javascript:enter(event.keyCode,'harga');"/></td>
            <td style="border-spacing:3px ;padding:3px 3px 3px 3px;border-bottom-color:black;"><input type="text" id="harga" style="width: 175px; text-align: right;"  onkeypress="javascript:enter(event.keyCode,'uraian');return(currencyFormat(this,',','.',event))"/><input type="hidden" value="0" id="cek_po" name="cek_po"  style="width:170px;text-align:right;"/>
            </td>
        </tr> 
        <tr style="border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
            <td colspan='8' align="right" style="border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;border-left-style:hidden;border-right-style:hidden;">
            <i><b>Tekan Enter untuk Input</b></i>
            </td>
       
        </table>
        
        
        
        
        
        <table id="dg1"  style="width:875px;height:370px;"> 
        </table>  
        <table border='1' style="width:870px;">
        <tr style="border-style: hidden;">
        
        <td style="border-style: hidden;">
            <button id="add1" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:kosong();">Tambah</button>
            <button id="del1" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:hapus_rinci();">Hapus</button>
            <button id="save1" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:detsimpan();">Simpan</button>
            <button id="paste" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="javascript:paste_copy();">Paste</button>
            <button id="insert1" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="javascript:insert_row();">Insert</button>
            <button id="stdhrg" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="javascript:standard_harga();">Standart Harga</button>
            
        </td>
        
        <td align='right' style="border-style: hidden;">
        <B>Total</B>&nbsp;&nbsp;&nbsp;&nbsp;<input class="right" type="text" name="rektotal_rinci" id="rektotal_rinci"  style="width:200px" align="right" readonly="true" />
        </td>
          
        </tr>
        
        <tr>
        <td style="border-style: hidden;">
        <button class="easyui-linkbutton" iconCls="icon-back" plain="true" onclick="javascript:section1()">Kembali</button>
        <button class="easyui-linkbutton" iconCls="icon-reload" plain="true" onclick="javascript:get_nilai_kua()">REFRESH KUA</button>
        </td>
        <td align='right' style="border-style: hidden;">
        <B>Sisa KUA</B>&nbsp;&nbsp;&nbsp;&nbsp;<input class="right" type="text" name="sisa_kua2" id="sisa_kua2"  style="width:200px" align="right" readonly="true" />
        </td>
        </tr>
        <tr>
        <td style="border-style: hidden;"></td>
        <td align='right' style="border-style: hidden; width=50%">
        <B>Ang. Rekening</B>&nbsp;&nbsp;<input class="right" type="text" name="nilai_kua_rek" id="nilai_kua_rek"  style="width:200px" align="right" readonly="true" />

        </td>
        </tr>
        <tr>
        <td style="border-style: hidden;"></td>
        <td align='right' style="border-style: hidden; width=50%">
        <B>Sisa KUA + Rek.</B><input class="right" type="text" name="total_sisa_kua_rek" id="total_sisa_kua_rek"  style="width:200px" align="right" readonly="true" />

        </td>
        </tr>

        <tr>
        <td style="border-style: hidden;"></td>
        <td align='right' style="border-style: hidden; width=50%">
        <B>Realisasi Rek.</B><input class="right" type="text" value='999,999,999,999,999,999.00' name="nreal_rek" id="nreal_rek"  style="width:200px" align="right" readonly="true" />
        </td>
        </tr>
        </table>
        
        </table>
    </div>   


<h3><a href="#" id="section3" onclick="javascript:load_dhukum();" >Dasar Hukum</a></h3>

    <div>
        
        <table id="dg2" title="Input Dasar Hukum Per Kegiatan" style="width:870px;height:400px;" >  
        
        </table>  
        <div id="toolbar1xa">
            <button id="save2" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:simpan_dhukum();">Simpan</button>
            <button class="easyui-linkbutton" iconCls="icon-back" plain="true" onclick="javascript:section1()">Kembali</button>
        </div>

    </div>   

<h3><a href="#" id="section4" onclick="javascript:load_detail_keg();" >Detail Kegiatan Pergeseran</a></h3>
    <div>
    <fieldset style="width:100%;height:570px;border-color:black;border-style:hidden; border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;"> 
    <br />
    <table align="center" border='0' width="100%" style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;border-style:hidden;" >
    <tr style="border-spacing:0px ;padding:0px 0px 0px 0px;border-collapse:collapse;border-style:hidden;">
        <td style="border-spacing:0px ;padding:0px 0px 0px 0px;border-collapse:collapse;" ><b>Anggaran Tahun Lalu</b></td>
        <td colspan="3" style="border-spacing:0px ;padding:0px 0px 0px 0px;border-collapse:collapse;" > <input type="text" id="ang_lalu" style="width:190px;text-align: right;"  onkeypress="javascript:return(currencyFormat(this,',','.',event))"/></td>
    </tr>   <tr style="border-spacing:0px ;padding:0px 0px 0px 0px;border-collapse:collapse;border-style:hidden;">
        <td style="border-spacing:0px ;padding:0px 0px 0px 0px;border-collapse:collapse;" ><b>Lokasi</b></td>
        <td style="border-spacing:0px ;padding:0px 0px 0px 0px;border-collapse:collapse;" ><textarea id="lokasi" name="lokasi" rows='2' cols="40" ></textarea></td>
        <td style="border-spacing:0px ;padding:0px 0px 0px 0px;border-collapse:collapse;" >&nbsp;&nbsp;</td>
        <td style="border-spacing:0px ;padding:0px 0px 0px 0px;border-collapse:collapse;" ><b>Sasaran</b></td>
        <td style="border-spacing:0px ;padding:0px 0px 0px 0px;border-collapse:collapse;"><textarea id="sasaran" name="sasaran" rows='2' cols="40"></textarea></td>
    </tr>
    <tr style="border-spacing:0px ;padding:0px 0px 0px 0px;border-collapse:collapse;border-style:hidden;" >
        <td style="border-spacing:0px ;padding:0px 0px 0px 0px;border-collapse:collapse;" ><b>Waktu</b></td>
        <td style="border-spacing:0px ;padding:0px 0px 0px 0px;border-collapse:collapse;" ><textarea id="wkeg" name="wkeg" rows='2' cols="40" > </textarea></td>
        <td style="border-spacing:0px ;padding:0px 0px 0px 0px;border-collapse:collapse;" >&nbsp;&nbsp;</td>
        <td style="border-spacing:0px ;padding:0px 0px 0px 0px;border-collapse:collapse;" ><b>PPTK</b></td>
        <td style="border-spacing:0px ;padding:0px 0px 0px 0px;border-collapse:collapse;" > <?php echo $this->rka_model->combo_ttd(); ?></td>
    </tr>
    </table>
    <br/>    

    <table align="center" border='0' width="100%" style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;border-style:hidden;">
    <tr style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;border-style:hidden;" >
        <td style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;"><b>Indikator</b></td>
        <td style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;">&nbsp;&nbsp;</td>
        <td style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;" align="center"><b>Tolak Ukur</b></td>
        <td style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;">&nbsp;&nbsp;</td>
        <td style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;" align="center"><b>Capaian Kinerja</b></td>
    </tr>
    <tr style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;border-style:hidden;">
        <td style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;"><b>Capaian</b></td>
        <td style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;">&nbsp;&nbsp;</td>
        <td style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;" align="center"><textarea id="cp_tu" name="cp_tu" rows='2' cols="45" > </textarea></td>
        <td style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;">&nbsp;&nbsp;</td>
        <td style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;" align="center"><textarea id="cp_ck" name="cp_ck" rows='2' cols="45" > </textarea></td>
    </tr>
    <tr style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;border-style:hidden;" >
        <td style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;"><b>Masukan</b></td>
        <td style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;">&nbsp;&nbsp;</td>
        <td style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;" align="center"><textarea id="m_tu" name="m_tu" rows='2' cols="45"  > </textarea></td>
        <td style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;">&nbsp;&nbsp;</td>
        <td style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;" align="center"><textarea id="m_ck" name="m_ck" rows='2' cols="45"  > </textarea></td>
    </tr>
    <tr style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;border-style:hidden;" >
        <td style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;"><b>Keluaran</b></td>
        <td style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;">&nbsp;&nbsp;</td>
        <td style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;" align="center"><textarea id="k_tu" name="k_tu" rows='2' cols="45" > </textarea></td>
        <td style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;" >&nbsp;&nbsp;</td>
        <td style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;" align="center"><textarea id="k_ck" name="k_ck" rows='2' cols="45" > </textarea></td>
    </tr>
    <tr style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;border-style:hidden;" >
        <td style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;"><b>Hasil</b></td>
        <td style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;">&nbsp;&nbsp;</td>
        <td style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;" align="center"><textarea id="h_tu" name="h_tu" rows='2' cols="45" > </textarea></td>
        <td style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;">&nbsp;&nbsp;</td>
        <td style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;" align="center"><textarea id="h_ck" name="h_ck" rows='2' cols="45" > </textarea></td>
    </tr>
    </table>
        <div id="toolbar1xa" >
            <button id="save4" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:simpan_det_keg()">Simpan</button>
            <button class="easyui-linkbutton" iconCls="icon-back" plain="true" onclick="javascript:section1()">Kembali</button>
        </div>
    </fieldset>    
    </div>   
</div>


<div id="dialog-modal" title="">

    <p class="validateTips"></p> 
    <fieldset>        
    <table id="dg_std" title="Pilih Standard" style="width:930px;height:300px;">  
    </table>  
    
    <table style="width:930px;height:20px;" border="0">
        <tr>
        <td align="center" colspan='2'>&nbsp;</td>
        </tr>

        <tr>
        <td align="center" >
        <button class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:pilih_std();">Pilih</button>
        <button class="easyui-linkbutton" iconCls="icon-back" plain="true" onclick="javascript:kembali_std();">Kembali</button></td>
        </tr>
    </table>
    
    </fieldset>  
</div>


<div id="dialog-modal-edit" title="Edit Rincian Rekening Pergeseran">

    <p class="validateTips"></p> 
    
    <fieldset>        
    <table border='0' style="width:800px;">
        <tr style="border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
            <td colspan='8' style="border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;"><input type="hidden" id="noid_edit" style="width: 200px;" /><input type="hidden" id="nopo_edit" style="width: 200px;" /><input type="hidden" id="total_edit" style="width: 200px;" /><input type="hidden" id="reke" style="width: 200px;" /></td>


        <tr style="border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
            <td style="border-right-style:hidden; border-bottom-style:hidden;border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;">Header</td>
            <td style="border-right-style:hidden; border-bottom-style:hidden;border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;">Kode</td>
            <td style="border-right-style:hidden; border-bottom-style:hidden;border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;">Uraian</td>
            <td style="border-right-style:hidden; border-bottom-style:hidden;border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;">Vol1</td>
            <td style="border-right-style:hidden; border-bottom-style:hidden;border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;">Sat1</td>
            <td style="border-bottom-style:hidden;border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;">Harga</td>
        </tr>
        <tr style="border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;">
            <td style="text-align:center; border-right-style:hidden; border-bottom-color:black;border-style-bottom:hidden;border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;"> <input type="checkbox" id="header_po_edit" style="width: 50px;" onkeypress="javascript:enter(event.keyCode,'kode_edit');"/></td>
            <td style="text-align:center; border-right-style:hidden; border-bottom-color:black;border-style-bottom:hidden;border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;"> <input type="number" id="kode_edit" style="width: 50px;" onkeypress="javascript:enter(event.keyCode,'uraian');"/></td>
            <td style="text-align:center; border-right-style:hidden; border-bottom-color:black;border-style-bottom:hidden;border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;"> <input type="text" id="uraian_edit" style="width: 400px;" onkeypress="javascript:enter(event.keyCode,'vol1');"/></td>
            <td style="border-right-style:hidden; border-bottom-color:black;border-style-bottom:hidden;border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;"><input type="number" id="vol1_edit" style="width: 90px;" onkeypress="javascript:enter(event.keyCode,'sat1');"/></td>
            <td style="border-right-style:hidden; border-bottom-color:black;border-style-bottom:hidden;border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;"><input type="text" id="sat1_edit" style="width: 90px;" onkeypress="javascript:enter(event.keyCode,'harga');"/></td>
            <td hidden="true" style="border-right-style:hidden; border-bottom-color:black;border-style-bottom:hidden;border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;"><input type="text" id="vol2_edit" style="width: 90px;" onkeypress="javascript:enter(event.keyCode,'sat2');"/></td>
            <td hidden="true" style="border-right-style:hidden; border-bottom-color:black;border-style-bottom:hidden;border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;"><input type="text" id="sat2_edit" style="width: 90px;" onkeypress="javascript:enter(event.keyCode,'vol3');"/></td>
            <td hidden="true" style="border-right-style:hidden; border-bottom-color:black;border-style-bottom:hidden;border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;"><input type="text" id="vol3_edit" style="width: 90px;" onkeypress="javascript:enter(event.keyCode,'sat3');"/></td>
            <td hidden="true" style="border-right-style:hidden; border-bottom-color:black;border-style-bottom:hidden;border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;"><input type="text" id="sat3_edit" style="width: 90px;" onkeypress="javascript:enter(event.keyCode,'harga');"/></td>
            <td style="border-spacing:3px ;padding:3px 3px 3px 3px;border-bottom-color:black;"><input type="text" id="harga_edit" style="width: 175px; text-align: right;"  onkeypress="return(currencyFormat(this,',','.',event))"/>
            </td>
        </tr> 
        
        
        <tr>
        <td colspan="8">&nbsp;
        </td>
        </tr>

        <tr>
        <td colspan="8" align="center">
        <button class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:pilih_edit();">Simpan</button> &nbsp; &nbsp; &nbsp;
        <button class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="javascript:copy_edit();">Copy</button>
        </td>
        </tr>
        
    </table>
    </fieldset>  
</div>

</div>      
</body>
</html>