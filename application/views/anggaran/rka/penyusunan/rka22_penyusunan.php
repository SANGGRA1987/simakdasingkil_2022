

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
    var ctk = '1';
        
    
     $(function(){ 
            $("#accordion").accordion();
             $("#nm_skpd").attr("value",'');
             $('#ttd1').combogrid();
             $('#ttd2').combogrid();
      

        $('#tgl_ttd').datebox({  
            required:true,
            formatter :function(date){
                var y = date.getFullYear();
                var m = date.getMonth()+1;
                var d = date.getDate();
                return y+'-'+m+'-'+d;
            }
        }); 
        
        
        $('#skpd').combogrid({  
            panelWidth:700,  
            idField:'kd_skpd',  
            textField:'kd_skpd',  
            mode:'remote',
            url:'<?php echo base_url(); ?>index.php/anggaran_murni/skpduser',  
            columns:[[  
                {field:'kd_skpd',title:'Kode SKPD',width:150},  
                {field:'nm_skpd',title:'Nama SKPD',width:700}    
            ]],
            onSelect:function(rowIndex,rowData){
                skpd = rowData.kd_skpd;
                $("#nmskpd").attr("value",rowData.nm_skpd);
                cetakbawah();
                ttd(skpd);
           
                }  
            });       
    });        

function ttd(kode){
           $(function(){
            $('#ttd1').combogrid({  
            panelWidth:500,  
            url: '<?php echo base_url(); ?>/index.php/rka_penetapan/load_tanda_tangan/'+kode,  
                idField:'id',                    
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
            
            
            $('#ttd2').combogrid({  
                panelWidth:400,  
                idField:'id',  
                textField:'nama',  
                mode:'remote',
                url:'<?php echo base_url(); ?>index.php/rka_penetapan/load_tanda_tangan/'+kode,  
                columns:[[  
                    {field:'nip',title:'NIP',width:200},  
                    {field:'nama',title:'Nama',width:400}    
                ]]  
            });   
                       });
}
     
    

    
    function cek(cetak){
        var  ctglttd= $('#tgl_ttd').datebox('getValue');
        var  ttd    = $('#ttd1').combogrid('getValue');
        var  ttd2   = $('#ttd2').combogrid('getValue');
        var  ckdskpd= $('#skpd').combogrid('getValue');
        var  doc    = document.getElementById('tipe_doc').value;

        url="<?php echo site_url(); ?>preview_belanja_penyusunan/"+ctglttd+'/'+ttd+'/'+ttd+'/'+ckdskpd+'/'+cetak+'/'+doc+'/'+doc+' Belanja Penyusunan-'+ckdskpd;
        
        if (ckdskpd=='' || ctglttd==''){
            alert("Pilih Nama SKPD Terlebih Dahulu")
        } else if (ttd==''){
            alert("Pilih Penandatangan Terlebih Dahulu")
        } else {
            window.open(url);
        }
    }
    
    function cetakbawah(){
        var ckdskpd = $('#skpd').combogrid('getValue');
        var doc     = document.getElementById('tipe_doc').value;

        url="<?php echo site_url(); ?>preview_belanja_penyusunan/2020-1-1/tanpa/tanpa/"+ckdskpd+'/0/'+doc+'/'+doc+' Belanja Penyusunan-'+ckdskpd;        
        if(ckdskpd!=''){
            document.getElementById('cetakan').innerHTML="<br><embed src='"+url+"' width='100%' height='600px'></embed>";
        }
    }
  
  
   </script>

<input type="text" name="tipe_doc" id="tipe_doc" value="<?php echo $jenis ?>" hidden> <!-- untuk cek rka atau dpa -->
<div id="content" align=""> 
<fieldset style="border-radius: 20px; border: 3px solid green;">
    <legend><h3><b>CETAK <?php echo $jenis ?> SKPD BELANJA</b></h3></legend>
    
    <table align="center" style="width:100%;" border="0">
        <tr> 
            <td width="20%">SKPD</td>
            <td width="1%">:</td>
            <td width="79%"><input id="skpd" name="skpd" style="width: 300px;" />
                <input type="text" id="nmskpd" readonly="true" style="width: 400px;border:0" />
            </td>
        </tr>
        <tr> 
            <td width="20%">TANGGAL TTD</td>
            <td width="1%">:</td>
            <td width="79%"><input type="text" id="tgl_ttd" style="width: 300px;" />
            </td>
        </tr>        
        <tr> 
            <td width="20%">Tanda tangan</td>
            <td width="1%">:</td>
            <td width="79%"><input type="text" id="ttd1" style="width: 300px;" /> 
            </td>
        </tr>    
        <tr hidden> 
            <td width="20%">TTD 2</td>
            <td width="1%">:</td>
            <td width="79%"><input type="text" id="ttd2" style="width: 300px;" /> 
            </td>
        </tr>   
        <tr> 
            <td width="20%">Cetak</td>
            <td width="1%"></td>
            <td width="79%">
                <a class="easyui-linkbutton" plain="true" onclick="javascript:cek(0);" >
                <img src="<?php echo base_url(); ?>assets/images/icon/print.png" width="25" height="23" title="cetak"/></a>
                <a class="easyui-linkbutton" plain="true" onclick="javascript:cek(1);">                    
                <img src="<?php echo base_url(); ?>assets/images/icon/print_pdf.png" width="25" height="23" title="cetak"/></a>

            </td>
        </tr>   
        </table>             
    </fieldset>
<label id="cetakan"></label>  
</div>  
