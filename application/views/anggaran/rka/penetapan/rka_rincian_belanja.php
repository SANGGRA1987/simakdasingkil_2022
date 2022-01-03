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
  


</head>
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
        
        var skpd="<?php  
                        {$skpd = $this->session->userdata('type');} 
                        if($skpd=='1'){
                            echo $skpd= $this->uri->segment(3); 
                        }else{
                            echo $skpd = $this->session->userdata('kdskpd');
                        }?>";
        
        
        
        $(function(){  
            $('#ttd1').combogrid({  
                panelWidth:800,  
                idField:'id',  
                textField:'nip',  
                mode:'remote',
                url:'<?php echo base_url(); ?>index.php/cetak_rka/load_tanda_tangan/'+skpd,  
                columns:[[  
                    {field:'nip',title:'NIP',width:200},  
                    {field:'nama',title:'Nama',width:400},
                    {field:'jabatan',title:'Jabatan',width:400} 
                ]]  
            });          
         });
         
         
         
        
         
         
         $(function(){  
            $('#ttd2').combogrid({  
                panelWidth:400,  
                idField:'id',  
                textField:'nip',  
                mode:'remote',
                url:'<?php echo base_url(); ?>index.php/cetak_rka/load_tanda_tangan/'+skpd,  
                columns:[[  
                    {field:'nip',title:'NIP',width:200},  
                    {field:'nama',title:'Nama',width:400}    
                ]]  
            });          
         });
        
        
        

        }); 

    

 function openWindow( url ){

           var  ctglttd = $('#tgl_ttd').datebox('getValue');
           var  ttd = $('#ttd1').combogrid('getValue');
           var  ttd_2 = "ss";
           var ttd1 = ttd.split(" ").join("a");
           var ttd2 = "sdsdwqefDSdfdR";
           var jns_an = "<?php echo $jenis ?>";
           var atas   =  document.getElementById('atas').value;
           var bawah   =  document.getElementById('bawah').value;
           var kiri   =  document.getElementById('kiri').value;
           var kanan   =  document.getElementById('kanan').value;

           if (ttd=='' || ctglttd==''){
           alert("Penanda tangan 1 atau tanggal Tanda tangan tidak boleh kosong");
           } else {
            l1 = '/'+atas+'/'+bawah+'/'+kiri+'/'+kanan+'/'+jns_an;
            l1 = l1.trim();
            lc = '?tgl_ttd='+ctglttd+'&ttd1='+ttd1+'&ttd2='+ttd2+'';
            window.open(url+l1+lc,'_blank');
            window.focus();
            }
          
     } 
     

</script>
<body>

<div id="content"> 
<h1>DAFTAR KEGIATAN</h1>

    <table width="100%" cellpadding="5">
        <tr>
            <td width="10%">Penandatangan</td>
            <td width="90%">: <input type="text" name="ttd1" id="ttd1"></td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td>: <input type="text" name="tgl_ttd" id="tgl_ttd"></td>
        </tr>
       
        <tr>
            <td></td>
            <td>Kiri  : &nbsp;<input type="number" id="kiri" name="kiri" style="width: 50px; border:1" value="15" /> &nbsp;&nbsp;
                Kanan : &nbsp;<input type="number" id="kanan" name="kanan" style="width: 50px; border:1" value="15" /> &nbsp;&nbsp;
                Atas  : &nbsp;<input type="number" id="atas" name="atas" style="width: 50px; border:1" value="15" /> &nbsp;&nbsp;
                Bawah : &nbsp;<input type="number" id="bawah" name="bawah" style="width: 50px; border:1" value="15" /></td>
        </tr>
    </table>
<br>
    <table width="100%">
        <tr>
            <td bgcolor="#cccccc" width="15%" align="center">KODE KEGIATAN</td>
            <td bgcolor="#cccccc" width="60%" align="center">NAMA KEGIATAN</td>
            <td bgcolor="#cccccc" width="25%" align="center">#</td>
        </tr>
    <?php $sql=$this->db->query("SELECT left(a.kd_sub_kegiatan,12) giat, (select nm_kegiatan from ms_kegiatan where kd_kegiatan=left(a.kd_sub_kegiatan,12) ) nm_kegiatan from trdrka a  where kd_skpd='$skpd' AND left(kd_rek6,1)='5'  GROUP BY
left(a.kd_sub_kegiatan,12)"); 
        foreach($sql->result() as $abc) :
    ?>
        <tr>
            <td width="15%" align="center"><?php echo $abc->giat; ?></td>
            <td width="60%" align="left"><?php echo $abc->nm_kegiatan; ?></td>
            <td width="25%" align="center"> 
                <a href="<?php echo site_url(); ?>preview_rka221_penyusunan/<?php echo $skpd ?>/<?php echo $abc->giat; ?>/<?php echo '0';?> "class="button" plain="true" onclick="javascript:openWindow(this.href);return false"><img src="<?php echo base_url(); ?>assets/images/icon/print.png"  width="25" height="23" title="cetak"></a> 
                <a href="<?php echo site_url(); ?>preview_rka221_penyusunan/<?php echo $skpd ?>/<?php echo $abc->giat; ?>/<?php echo '1';?> "class="button" plain="true" onclick="javascript:openWindow(this.href);return false"><img src="<?php echo base_url(); ?>assets/images/icon/print_pdf.png"  width="25" height="23" title="cetak"></a>
                <a href="<?php echo site_url(); ?>preview_rka221_penyusunan/<?php echo $skpd ?>/<?php echo $abc->giat; ?>/<?php echo '2';?> "class="button" plain="true" onclick="javascript:openWindow(this.href);return false"><img src="<?php echo base_url(); ?>assets/images/icon/excel.jpg"  width="25" height="23" title="cetak"></a>
                <a href="<?php echo site_url(); ?>preview_rka221_penyusunan/<?php echo $skpd ?>/<?php echo $abc->giat; ?>/<?php echo '3';?> "class="button" plain="true" onclick="javascript:openWindow(this.href);return false"><img src="<?php echo base_url(); ?>assets/images/icon/word.jpg"  width="25" height="23" title="cetak"></a>
            </td>
        </tr>
    <?php endforeach; ?>
    </table>
</div>

</body>

</html>