

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
     
      $(document).ready(function() {            
             get_skpd(); 
             cekskpd();              
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
        
        $('#tgl2').datebox({  
            required:true,
            formatter :function(date){
            	var y = date.getFullYear();
            	var m = date.getMonth()+1;
            	var d = date.getDate();
            	return y+'-'+m+'-'+d;
            }
        });
    
      //$('#skpd').combogrid({  
//           panelWidth:700,  
//           idField:'kd_skpd',  
//           textField:'kd_skpd',  
//           mode:'remote',
//           url:'<?php echo base_url(); ?>index.php/rka/config_skpd_2',  
//           columns:[[  
//               {field:'kd_skpd',title:'Kode SKPD',width:100},  
//               {field:'nm_skpd',title:'Nama SKPD',width:700}    
//           ]],  
//           onSelect:function(rowIndex,rowData){
//               kode = rowData.kd_skpd;               
//               $("#nmskpd").attr("value",rowData.nm_skpd.toUpperCase());
//               $('#rek').combogrid({url:'<?php echo base_url(); ?>index.php/tukd/ambil_rek_tetap/'+kode});                 
//           }  
//       });
       
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
    	$('#ttd').combogrid({  
    		panelWidth:500,  
    		url: '<?php echo base_url(); ?>/index.php/tukd/list_ttd',  
    			idField:'nip',                    
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
       });
	   $(function(){  
            $('#ttd1').combogrid({  
                panelWidth:600,  
                idField:'nip',  
                textField:'nip',  
                mode:'remote',
                url:'<?php echo base_url(); ?>index.php/tukd/load_ttd/pa',  
                columns:[[  
                    {field:'nip',title:'NIP',width:200},  
                    {field:'nama',title:'Nama',width:400}    
                ]]  
            });          
         });
		 
		 $(function(){  
            $('#ttd2').combogrid({  
                panelWidth:600,  
                idField:'nip',  
                textField:'nip',  
                mode:'remote',
                url:'<?php echo base_url(); ?>index.php/tukd/load_ttd/bp',  
                columns:[[  
                    {field:'nip',title:'NIP',width:200},  
                    {field:'nama',title:'Nama',width:400}    
                ]]  
            });          
         });
    
    function get_skpd()
        {
        
        	$.ajax({
        		url:'<?php echo base_url(); ?>index.php/rka/config_skpd',
        		type: "POST",
        		dataType:"json",                         
        		success:function(data){
        								$("#skpd").attr("value",data.kd_skpd);
        								$("#nmskpd").attr("value",data.nm_skpd);
                                        kdskpd = data.kd_skpd; 
        								kdskpd = data.kd_skpd;
                                        kode=data.kd_skpd;
                                        vskpd = kdskpd.substring(8,10);
                                        if(vskpd=='00' || vskpd=='01'){ 
                                             
                                        }else{
                                            document.getElementById("jnsctk").options[0] = null;
                                        } 
        							  }                                     
        	});  
        }
   
        function ttd1(){  
            var ckdskpd = $("#sskpd2").combogrid("getValue");
            $('#ttd1').combogrid({  
                panelWidth:600,  
                idField:'nip',  
                textField:'nip',  
                mode:'remote',
                url:'<?php echo base_url(); ?>index.php/tukd/load_ttd/pa', 
                queryParams: ({kdskpd:ckdskpd}), 
                columns:[[  
                    {field:'nip',title:'NIP',width:200},  
                    {field:'nama',title:'Nama',width:400}    
                ]]  
            });          
        }

 
		 function ttd2(){ 
            var ckdskpd = $("#sskpd2").combogrid("getValue");
            $('#ttd2').combogrid({  
                panelWidth:600,  
                idField:'nip',  
                textField:'nip',  
                mode:'remote',
                url:'<?php echo base_url(); ?>index.php/tukd/load_ttd/bp',
                queryParams: ({kdskpd:ckdskpd}),  
                columns:[[  
                    {field:'nip',title:'NIP',width:200},  
                    {field:'nama',title:'Nama',width:400}    
                ]]  
            }); 
        }; 
                   
        function cekskpd(){
			$('#sskpd2').combogrid({  
            panelWidth:700,  
            idField:'kd_skpd',  
            textField:'kd_skpd',  
            mode:'remote',
            url:'<?php echo base_url(); ?>index.php/tukd/skpd__pend',
            //queryParams: ({kdskpd:kdskpd2}),
            columns:[[  
                {field:'kd_skpd',title:'Kode SKPD',width:100},  
                {field:'nm_skpd',title:'Nama SKPD',width:700}
             ]],       
            onSelect:function(rowIndex,rowData){
				skpd = rowData.kd_skpd;
                $("#sskpd2").attr("value",rowData.kd_skpd);
                $("#nmskpd").attr("value",rowData.nm_skpd);
                ttd1();
                ttd2();
            }
            });
         }        


     function cetak( pilih ){
         var ckdskpd = $("#sskpd2").combogrid("getValue");
        var  ctglttd = $('#tgl_ttd').datebox('getValue');
        var  ttd = $('#ttd1').combogrid('getValue');
        var ttd = ttd.split(" ").join("123456789");
        var  ttd2 = $('#ttd2').combogrid('getValue');
        var ttd2 = ttd2.split(" ").join("123456789");
        var jnsctk = document.getElementById('jnsctk').value;
		var ctgl1 = $('#tgl1').datebox('getValue');
        var ctgl2 = $('#tgl2').datebox('getValue');
		
        if(ctgl1=='' || ctgl2==''){
                alert('Pilih Tanggal Terlebih dahulu');
                return;
            }
			
		var url    = "<?php echo site_url(); ?>/tukd/cetak_rincian_sts"; 
            lc = '/'+pilih+'?kd_skpd='+ckdskpd+'&tgl1='+ctgl1+'&tgl2='+ctgl2+'&tgl_ttd='+ctglttd+'&ttd='+ttd+'&ttd2='+ttd2+'&cpilih=2'+'&jnsctk='+jnsctk;
         window.open(url+lc,'_blank');
         window.focus();
     }  
	 
	 
	 
	 function cetak2( pilih ){
         var ckdskpd = $("#sskpd2").combogrid("getValue");
        var  ctglttd = $('#tgl_ttd').datebox('getValue');
        var  ttd = $('#ttd1').combogrid('getValue');
        var ttd = ttd.split(" ").join("123456789");
        var  ttd2 = $('#ttd2').combogrid('getValue');
        var ttd2 = ttd2.split(" ").join("123456789");
        var jnsctk = document.getElementById('jnsctk').value;
		var ctgl1 = $('#tgl1').datebox('getValue');
        var ctgl2 = $('#tgl2').datebox('getValue');
		
        if(ctgl1=='' || ctgl2==''){
                alert('Pilih Tanggal Terlebih dahulu');
                return;
            }
			
		var url    = "<?php echo site_url(); ?>/tukd/cetak_reg_kasda2"; 
		
         if(ctk==1){
			if(ckdskpd==''){
				alert("Pilih keseluruhan dahulu");
			}
			ckdskpd='-';
			
            lc = '/'+pilih+'?kd_skpd='+ckdskpd+'&tgl1='+ctgl1+'&tgl2='+ctgl2+'&tgl_ttd='+ctglttd+'&ttd='+ttd+'&ttd2='+ttd2+'&cpilih=1'+'&jnsctk='+jnsctk;
         }else{
            lc = '/'+pilih+'?kd_skpd='+ckdskpd+'&tgl1='+ctgl1+'&tgl2='+ctgl2+'&tgl_ttd='+ctglttd+'&ttd='+ttd+'&ttd2='+ttd2+'&cpilih=2'+'&jnsctk='+jnsctk;

         }
         window.open(url+lc,'_blank');
         window.focus();
     }
     
     function opt(val){        
        ctk = val; 
        if (ctk=='1'){
            $("#div_skpd").hide();
        } else if (ctk=='2'){
            $("#div_skpd").show();
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
    <h3 align="center"><b>SPJ PENDAPATAN</b></h3>
    <fieldset style="width: 70%;">
     <table align="center" style="width:100%;" border="0">
           
         
            <tr>
                <td colspan="3">
                <div id="div_skpd">
                        <table style="width:100%;" border="0">
                            <td width="20%">SKPD</td>
                            <td width="1%">:</td>
                            <td width="79%"><input type="hidden" id="skpd" name="skpd" style="width: 100px;" />
                             <input id="sskpd2" name="sskpd2" style="width:100px;border: 0;" />
                            <input type="text" id="nmskpd" readonly="true" style="width: 400px;border:0" />
                            </td>
                        </table>
                </div>
                </td>
            </tr>
            <tr>
                <td colspan="3">
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
            <tr style="display: none;">
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

            <tr style="display: none;">
                <td colspan="3">
                <div id="div_bend">
                        <table style="width:100%;" border="0">
                            <td width="20%">Jenis Cetakkan</td>
                            <td width="1%">:</td>
                            <td><select name="jnsctk" id="jnsctk" style="height: 27px;width: 200px;" > 
                                <option value="1" >Global</option>
                                <option value="2" >SKPD</option>
                            </td> 
                        </table>
                </div>
                </td> 
            </tr>

			<tr style="display: none;">
		<td colspan="4">
                <div id="div_bend">
                        <table style="width:100%;" border="0">
                            <td width="20%">Pengguna Anggaran</td>
                            <td width="1%">:</td>
                            <td><select type="text" id="ttd1" style="width: 100px;" /> 
                            </td> 
							
							<td width="20%">Bendahara Penerimaan</td>
                            <td width="1%">:</td>
                            <td><input type="text" id="ttd2" style="width: 100px;" /> 
                            </td> 
                        </table>
                </div>
        </td> 
		</tr>
		
		<tr>
                <td colspan="3">
                        <table style="width:100%;" border="0">
                            <td width="20%"></td>
                            <td width="1%">:</td>
                            <td width="79%"><a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetak(0);">CETAK LAYAR</a>
						<a class="easyui-linkbutton" iconCls="icon-pdf" plain="true" onclick="javascript:cetak(1);">CETAK PDF</a>
						<a class="easyui-linkbutton" iconCls="icon-excel" plain="true" onclick="javascript:cetak(2);">CETAK EXCEL</a>
                            </td>
                        </table>
                </td>
       
			
        </table>  
            
    </fieldset>  
</div>	
