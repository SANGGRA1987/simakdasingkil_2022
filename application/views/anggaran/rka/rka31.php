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
    var kods = '';
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
        
        
        

         
         $(function(){  
            $('#ttd2').combogrid({  
                panelWidth:400,  
                idField:'nip',  
                textField:'nama',  
                mode:'remote',
                url:'<?php echo base_url(); ?>index.php/rka/load_ttd_agr',  
                columns:[[  
                    {field:'nip',title:'NIP',width:200},  
                    {field:'nama',title:'Nama',width:400}    
                ]]  
            });          
         });

            
        }); 
        
        


    function cek($cetak){
       
         
            url="<?php echo site_url(); ?>/rka/preview_rka31/4.02.01.00/"+$cetak
         
         
        openWindow( url );
    }
    
 
 function openWindow(url){
          // var ckdskpd = kods;
           var  ctglttd = $('#tgl_ttd').datebox('getValue');
          // var ckdunit = $('#cunit').combogrid('getValue');     
           var  ttd_2 = $('#ttd2').combogrid('getValue');
           var ttd2 = ttd_2.split(" ").join("x");
           
            
            lc = '/'+ctglttd+'/'+ttd2+'/';
            //lc='/';
            window.open(url+lc,'_blank');
            window.focus();
          
     } 
     
     function alltrim(kata){
     //alert(kata);
        b = (kata.split(' ').join(''));
        c = (b.replace( /\s/g, ""));
        return c
     
     }
             function runEffect() {        
            $('#chkpa')._propAttr('checked',false);     
        };  
        
        function runEffect2() {        
            $('#chkppkd')._propAttr('checked',false);
        };
        
   </script>

    <div id="content">        
        <h1><?php echo $page_title; ?>&nbsp;&nbsp;&nbsp;&nbsp; 
       </h1>
        
        <?php echo form_close(); ?>   
        
        <?php if (  $this->session->flashdata('notify') <> "" ) : ?>
        <div class="success"><?php echo $this->session->flashdata('notify'); ?></div>
        <?php endif; ?>
    
 
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
                            <td width="20%">PPKD/ SEKDA</td>
                            <td width="1%">:</td>
                            <td><input type="text" id="ttd2" style="width: 200px;" /> 
                            </td> 
                        </table>
                </div>
        </td> 
     


        <table class="narrow">


        
        <tr>
           <td width="10%">Cetak</td>
           <td> 
                    
                    <a class="easyui-linkbutton" plain="true" onclick="javascript:cek(1);return false" >
                    <img src="<?php echo base_url(); ?>assets/images/icon/print_pdf.png" width="25" height="23" title="preview"/></a>
                    <a class="easyui-linkbutton" plain="true" onclick="javascript:cek(2);return false">                    
                    <img src="<?php echo base_url(); ?>assets/images/icon/excel.jpg" width="25" height="23" title="cetak"/></a>
           </td>    
        </tr>
        
 
        </table>        
        <div class="clear"></div>
    </div>