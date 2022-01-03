

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
    
    var kode = '1.02.01.00';
    var giat = '';
    var nomor= '';
    var judul= '';
    var cid = 0;
    var lcidx = 0;
    var lcstatus = '';
    var ctk = '';
     
      $(document).ready(function() {            
                        
        });
     
     $(function(){ 
        
       $("#div_bulan").hide();
       $("#div_periode").hide(); 
      
       $('#tgl1').datebox({  
            required:true,
            formatter :function(date){
            	var y = date.getFullYear();
            	var m = date.getMonth()+1;
            	var d = date.getDate();
            	return y+'-'+m+'-'+d;
            }
        });  
        
        $('#tgl_ttd').datebox({  
            required:true,
            formatter :function(date){
            	var y = date.getFullYear();
            	var m = date.getMonth()+1;
            	var d = date.getDate();
            	return y+'-'+m+'-'+d;
            }
        }); 
        
        $('#tgl2').datebox({  
            required:true,
            formatter :function(date){
            	var y = date.getFullYear();
            	var m = date.getMonth()+1;
            	var d = date.getDate();
            	return y+'-'+m+'-'+d;
            }
        });    
       
       $('#bulan').combogrid({  
           panelWidth:120,
           panelHeight:300,  
           idField:'bln',  
           textField:'nm_bulan',  
           mode:'remote',
           url:'<?php echo base_url(); ?>index.php/rka/bulan',  
           columns:[[ 
               {field:'nm_bulan',title:'Nama Bulan',width:700}    
           ]] 
       });
              
      
    });        
            
	   $(function(){  
            $('#ttd1').combogrid({  
                panelWidth:600,  
                idField:'nip',  
                textField:'nip',  
                mode:'remote',
                url:'<?php echo base_url(); ?>index.php/tukd/load_ttd_dinkes',  
                columns:[[  
                    {field:'nip',title:'NIP',width:200},  
                    {field:'nama',title:'Nama',width:400}    
                ]]  
            });          
         });		 
     
     $(function(){  
            $('#rek_dinkes').combogrid({  
                panelWidth:540,  
                idField:'kd_rek5',  
                textField:'kd_rek5',  
                mode:'remote',
                url:'<?php echo base_url(); ?>index.php/tukd/load_rekpend/'+kode,  
                columns:[[  
                    {field:'kd_rek5',title:'Kode',width:100},  
                    {field:'nm_rek5',title:'Nama Rekening',width:400}    
                ]],              
                onSelect:function(rowIndex,rowData){
                   nm = rowData.nm_rek5;               
                   $("#nmrek_dinkes").attr("value",nm)
               }   
            });          
         });
        
     function cetak(){
        $("#dialog-modal").dialog('close');
     } 
     
     function cetak( pilih ){
        var ckdskpd = "1.02.01.00";
        var reke = $('#rek_dinkes').combogrid('getValue');
        var  ctglttd = $('#tgl_ttd').datebox('getValue');
        var  ttd = $('#ttd1').combogrid('getValue');
        var ttd = ttd.split(" ").join("ab");
        var url    = "<?php echo site_url(); ?>/tukd/cetak_rekap_terimapusk"; 
		
         if(ctk==1){
            ctgl1 = $('#tgl1').datebox('getValue');
            ctgl2 = $('#tgl2').datebox('getValue');
            
            if(ctgl1=='' || ctgl2==''){
                alert('Pilih Tanggal Terlebih dahulu');
                return;
            }
            lc = '/'+pilih+'?kd_skpd='+ckdskpd+'&tgl1='+ctgl1+'&tgl2='+ctgl2+'&tgl_ttd='+ctglttd+'&ttd='+ttd+'&reke='+reke+'&cpilih=1';
         }else{
            
            cbulan = $('#bulan').combogrid('getValue');
		    if(cbulan==''){
                alert('Bulan belum diisi');
                return;		      
		    }
            lc = '/'+pilih+'?kd_skpd='+ckdskpd+'&bulan='+cbulan+'&tgl_ttd='+ctglttd+'&ttd='+ttd+'&reke='+reke+'&cpilih=2';

         }
         
         window.open(url+lc,'_blank');
         window.focus();
     }  
     
     function opt(val){        
        ctk = val; 
        if (ctk=='1'){
            $("#div_bulan").hide();
            $("#div_periode").show();
        } else if (ctk=='2'){
            $("#div_bulan").show();
            $("#div_periode").hide();
            } else {
            exit();
        }                 
    }     
    
    function coba(){
        var bln1 = $('#bulan1').combogrid('getValue');
        alert(bln1);
    }
  
   </script>


<div id="content1" align="center"> 
    <h3 align="center"><b>REKAP PENERIMAAN PUSKESMAS</b></h3>
    <fieldset style="width: 70%;">
     <table align="center" style="width:100%;" border="0">
            <tr>
                <td><input type="radio" name="cetak" value="1" onclick="opt(this.value)" />Periode &ensp;
                <input type="radio" name="cetak" value="2" id="status" onclick="opt(this.value)" />Bulan
                </td>
                <td>&ensp;</td>
                <td>&nbsp</td>
            </tr>
            <tr>
                <td colspan="3">&nbsp</td>
            </tr>
            <tr>
                <td colspan="3">
                 <div id="div_bulan">
                        <table style="width:100%;" border="0">
                            <td width="20%">BULAN</td>
                            <td width="1%">:</td>
                            <td width="79%"><input id="bulan" name="bulan" style="width: 100px;" />
                            </td>
                        </table>
                </div>
                <div id="div_periode">
                        <table style="width:100%;" border="0">
                            <td width="20%">PERIODE</td>
                            <td width="1%">:</td>
                            <td width="79%"><input type="text" id="tgl1" style="width: 100px;" /> s.d. <input type="text" id="tgl2" style="width: 100px;" />
                            </td>
                        </table>
                </div>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                <div id="div_bend">
                        <table style="width:100%;" border="0">
                            <td width="20%">REKENING</td>
                            <td width="1%">:</td>
                            <td><input type="text" id="rek_dinkes" style="width: 100px;" /> &nbsp;<input type="text" id="nmrek_dinkes" style="width: 350px; border:none;" /> 
                            </td> 
                        </table>
                </div>
                </td> 
            </tr>
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
                            <td width="20%">Pengguna Anggaran</td>
                            <td width="1%">:</td>
                            <td><select type="text" id="ttd1" style="width: 100px;" /> 
                            </td>
                             </table> 
                             </div>
			</tr>
            <tr>
                <td colspan="3" align="center">
						<a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetak(0);">CETAK LAYAR</a>
						<a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetak(1);">CETAK PDF</a>

                <!--<a href="<?php echo site_url(); ?>/tukd/cetak_spjterima2/0" class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetak(this.href);return false">Cetak</a>
                <a href="<?php echo site_url(); ?>/tukd/cetak_spjterima2/1" class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetak(this.href);return false">Cetak PDF</a>
                -->
				</td>                
            </tr>
        </table>  
            
    </fieldset>  
</div>	
