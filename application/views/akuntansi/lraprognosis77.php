

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
	<style>   
  
    #tagih {
        position: relative;
        width: 922px;
        height: 50px;
        padding: 0.4em;
    }  
    </style>
    <script type="text/javascript">
	var kdskpd='';
	var ctk = '';
   $(document).ready(function() {
      $("#spasi").attr("value",0);
        }); 
    
     $(function(){ 
        
      
      
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
		
		$('#sskpd').combogrid({  
			panelWidth:900,  
			idField:'kd_skpd',  
			textField:'kd_skpd',  
			mode:'remote',
			url:'<?php echo base_url(); ?>index.php/akuntansi/skpd',  
			columns:[[  
				{field:'kd_skpd',title:'Kode SKPD',width:180},  
				{field:'nm_skpd',title:'Nama SKPD',width:700}    
			]],
			onSelect:function(rowIndex,rowData){
				kdskpd = rowData.kd_skpd;
				$("#nmskpd").attr("value",rowData.nm_skpd);
				$("#skpd").attr("value",rowData.kd_skpd);
			   
			}  
			});        
      
    
      $('#ttd').combogrid({  
        panelWidth:500,  
        url:'<?php echo base_url(); ?>index.php/akuntansi/load_ttd',      
          idField:'nip',                    
          textField:'nama',
          mode:'remote',  
          fitColumns:true,  
          columns:[[  
            {field:'nip',title:'NIP',width:180},  
            {field:'nama',title:'NAMA',align:'left',width:300}                
          ]],
          onSelect:function(rowIndex,rowData){
          nip = rowData.nip;
          
          }   
        });   
      
       });
	   
	   $(function(){
			$("#tagih").hide();
		}); 
    
	   function opt(val){        
			ctk = val; 
			if (ctk=='1'){
				$("#tagih").hide();
				$('#ttd').combogrid({  
					panelWidth:500,  
					url:'<?php echo base_url(); ?>index.php/akuntansi/load_ttd_keu',      
					  idField:'nip',                    
					  textField:'nama',
					  mode:'remote',  
					  fitColumns:true,  
					  columns:[[  
						{field:'nip',title:'NIP',width:180},  
						{field:'nama',title:'NAMA',align:'left',width:300}                
					  ]],
					  onSelect:function(rowIndex,rowData){
					  nip = rowData.nip;
					  
					  }   
				});
			} else if (ctk=='2'){
				$("#tagih").show();
				$('#ttd').combogrid({  
					panelWidth:500,  
					url:'<?php echo base_url(); ?>index.php/akuntansi/load_ttd',      
					  idField:'nip',                    
					  textField:'nama',
					  mode:'remote',  
					  fitColumns:true,  
					  columns:[[  
						{field:'nip',title:'NIP',width:180},  
						{field:'nama',title:'NAMA',align:'left',width:300}                
					  ]],
					  onSelect:function(rowIndex,rowData){
					  nip = rowData.nip;
					  
					  }   
				});
			} else {
				exit();
			}                 
		} 
     
     function openWindow( url ){
	 if(ctk==''){
			alert("Pilih KESELURUHAN atau SKPD Terlebih Dahulu");
			return;
		}
       var apbd = document.getElementById('APBD').value;  
        ctglttd = $('#tgl_ttd').datebox('getValue');
        var spasi =document.getElementById('spasi').value;
		var ctgl1 = document.getElementById("bulan").value;  
		var ttd1 = $('#ttd').combogrid('getValue'); 
		if(ttd1==''){
			ttd="-";
		}else{
			ttd=ttd1.split(' ').join('abc');
		}
		
		if (ctk=='1'){
			skpd =  '-';
		}else{
			skpd =  kdskpd;
		}
	  
         lc = '?tgl1='+ctgl1+'&tgl_ttd='+ctglttd+'&spasi='+spasi+'&apbd='+apbd+'&ttd='+ttd+'&ctk='+ctk+'&skpd='+skpd;
        
         window.open(url+lc,'_blank');
         window.focus();
         
     }  
     
    
    
    
  
   </script>


<div id="content1" align="center"> 
    <h3 align="center"><b>CETAK LAPORAN REALISASI ANGGARAN ( LRA ) TRIWULAN / SEMESTER </b> </h3>
    
     <table align="center" style="width:100%;" border="0">
            <tr><td width="922px" colspan="2"><input type="radio" name="cetak" value="1" onclick="opt(this.value)" /><b>KESELURUHAN</b></td></tr>
			<tr>
				<td width="922px" colspan="2"><input type="radio" name="cetak" value="2" onclick="opt(this.value)" /><b>PER SKPD</b>
					<div id="tagih">
						<table style="width:100%;" border="0">
							<tr >
								<td width="20%" height="10%" ><b>SKPD</b></td>
								<td width="80%"><input id="sskpd" name="sskpd" style="width: 150px;" />&nbsp;&nbsp;<input id="nmskpd" name="nmskpd" style="width: 550px; border:0;" readonly /></td>
								</tr>
						</table> 
					</div>
				</td>           
            <tr>
                <td colspan="3">
                
                <div id="div_periode">
                        <table style="width:100%;" border="0">
                            <td width="20%">BULAN</td>
                            <td width="1%">:</td>
                            <td width="79%"><select  name="bulan" id="bulan" >
								 <option value="3">Triwulan 1 </option>
								 <option value="6">Semester 1</option>
								 <option value="9">Triwulan 3</option>
								 <option value="12">Semester 2 </option>
							   </select> 
                            </td>
                        </table>
                </div>
                </td>
            </tr>
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
                <td colspan="3">
                <div id="div_bend">
                        <table style="width:100%;" border="0">
                            <td width="20%">JENIS APBD</td>
                            <td width="1%">:</td>
                            <td><select  name="APBD" id="APBD" >
               <option value="0">PENYUSUNAN</option>
			   <option value="2">PENYEMPURNAAN</option>
               <option value="1" >PERUBAHAN</option> 
                          </select>
                            </td> 
                        </table>
                </div>
                </td> 
            </tr>
			<tr>
                <td colspan="3">
                
                <div id="div_periode">
                        <table style="width:100%;" border="0">
                              <td width="20%">PENANDATANGANAN</td>
                                <td width="1%">:</td>
                            <td width="79%"><input type="text" id="ttd" style="width: 200px;" /> 
                            </td>
                        </table>
                </div>
                </td>
            </tr>
              
        
       <tr>
                <td colspan="3">
                <div>
                        <table style="width:100%;" border="0">
                            <td width="20%">ENTER TTD</td>
                            <td width="1%">:</td>
                            <td><input type="text" id="spasi" style="width: 50px;" /> 
                            </td> 
                        </table>
                </div>
                </td> 
            </tr>
            <td colspan="3">&nbsp;</td>
            </tr>            
            <tr>
                <td colspan="3" align="center">
                <a href="<?php echo site_url(); ?>/akuntansi/cetak_lra77_skpd_prognosis/1" class="easyui-linkbutton" iconCls="icon-pdf" plain="true" onclick="javascript:openWindow(this.href);return false">Cetak</a>
         <a href="<?php echo site_url(); ?>/akuntansi/cetak_lra77_skpd_prognosis/2" class="easyui-linkbutton" iconCls="icon-excel" plain="true" onclick="javascript:openWindow(this.href);return false">Excell</a>
                </td>                
            </tr>
        </table>  
            
  
</div>  
