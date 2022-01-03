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
	    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>prettify/prettify.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>bootstrap/bootstrap-progressbar-3.1.0.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>js/confirm/confirm.css">
    <script type='text/javascript' src="<?php echo base_url();?>prettify/prettify.min.js"></script>
    <script type='text/javascript' src="<?php echo base_url();?>bootstrap/bootstrap-progressbar.js"></script>
    <script type='text/javascript' src="<?php echo base_url();?>js/confirm/confirm.js"></script>
  <style>  
        /* awesome bootstrap style setup - thanks */
        .bs-sidebar.affix { position: static; }
        .bs-sidenav { margin-top: 30px; margin-bottom: 30px; padding-top: 10px; padding-bottom: 10px; text-shadow: 0 1px 0 #fff; background-color: #f7f5fa; border-radius: 5px; }
        .bs-sidenav strong { text-transform: uppercase; }
        .bs-sidebar .nav > li > a { display: block; color: #716b7a; padding: 5px 20px; }
        .bs-sidebar .nav > li > a:hover, .bs-sidebar .nav > li > a:focus { text-decoration: none; background-color: #e5e3e9; border-right: 1px solid #dbd8e0; }
        .bs-sidebar .nav > .active > a, .bs-sidebar .nav > .active:hover > a, .bs-sidebar .nav > .active:focus > a { font-weight: bold; color: #563d7c; background-color: transparent; border-right: 1px solid #563d7c; }
        .bs-sidebar .nav .nav { display: none; margin-bottom: 8px; }
        .bs-sidebar .nav .nav > li > a { padding-top: 3px; padding-bottom: 3px; padding-left: 30px; font-size: 90%; }
        .bs-example { position: relative; padding: 45px 15px 15px; margin: 0 -15px 0px; background-color: #fafafa; box-shadow: inset 0 3px 6px rgba(0,0,0,.05); border-color: #e5e5e5 #eee #eee; border-style: solid; border-width: 1px 0; }
        .bs-example:after { content: "Proses Penghitungan"; position: absolute; top:  15px; left: 15px; font-size: 12px; font-weight: bold; color: #bbb; text-transform: uppercase; letter-spacing: 1px; }
        .bs-example + .highlight { margin: -15px -15px 15px; border-radius: 0; border-width: 0 0 1px; }
        .highlight { padding: 9px 14px; margin-bottom: 14px; background-color: #f7f7f9; border: 1px solid #e1e1e8; border-radius: 4px; }
        .highlight pre { padding: 0; margin-top: 0; margin-bottom: 0; background-color: transparent; border: 0; white-space: nowrap; }
        .highlight pre code { font-size: inherit; color: #333; }
        .highlight pre .lineno { display: inline-block; width: 22px; padding-right: 5px; margin-right: 10px; text-align: right; color: #bebec5; }
        .bs-docs-section + .bs-docs-section { padding-top: 40px; }
        .bs-callout { margin: 20px 0; padding: 15px 30px 15px 15px; border-left: 5px solid #eee; }
        .bs-callout h4 { margin-top: 0; }
        .bs-callout p:last-child { margin-bottom: 0; }
        .bs-callout code, .bs-callout .highlight { background-color: #fff; }
        .bs-callout-danger { background-color: #fcf2f2; border-color: #dFb5b4; }
        .bs-callout-warning { background-color: #fefbed; border-color: #f1e7bc; }
        .bs-callout-info { background-color: #f0f7fd; border-color: #d0e3f0; }

        .progress .progress-bar.six-sec-ease-in-out { -webkit-transition: width 6s ease-in-out; -moz-transition: width 6s ease-in-out; -ms-transition: width 6s ease-in-out; -o-transition: width 6s ease-in-out; transition: width 6s ease-in-out; }
        .progress.vertical .progress-bar.six-sec-ease-in-out { -webkit-transition: height 6s ease-in-out; -moz-transition: height 6s ease-in-out; -ms-transition: height 6s ease-in-out; -o-transition: height 6s ease-in-out; transition: height 6s ease-in-out; }
        .progress.wide { width: 60px; }
        .bs-example.vertical { height: 250px; }

        pre, code {
            font-weight: bold;
            font-size: 12px;
        }
        code {
            word-break: break-all;
            white-space: normal;
        }
        pre {
        overflow: auto;
        }
        pre code {
            white-space: pre;
            overflow: auto;
            word-wrap: normal;
        }
        pre code span {
            word-break: break-all;
        }
        .hll { background-color: #515151 }
        .c { color: #999999 } /* Comment */
        .err { color: #f2777a } /* Error */
        .k { color: #cc99cc } /* Keyword */
        .l { color: #f99157 } /* Literal */
        .n { color: #cccccc } /* Name */
        .o { color: #66cccc } /* Operator */
        .p { color: #cccccc } /* Punctuation */
        .cm { color: #999999 } /* Comment.Multiline */
        .cp { color: #999999 } /* Comment.Preproc */
        .c1 { color: #999999 } /* Comment.Single */
        .cs { color: #999999 } /* Comment.Special */
        .gd { color: #f2777a } /* Generic.Deleted */
        .ge { font-style: italic } /* Generic.Emph */
        .gh { color: #cccccc; font-weight: bold } /* Generic.Heading */
        .gi { color: #99cc99 } /* Generic.Inserted */
        .gp { color: #999999; font-weight: bold } /* Generic.Prompt */
        .gs { font-weight: bold } /* Generic.Strong */
        .gu { color: #66cccc; font-weight: bold } /* Generic.Subheading */
        .kc { color: #cc99cc } /* Keyword.Constant */
        .kd { color: #cc99cc } /* Keyword.Declaration */
        .kn { color: #66cccc } /* Keyword.Namespace */
        .kp { color: #cc99cc } /* Keyword.Pseudo */
        .kr { color: #cc99cc } /* Keyword.Reserved */
        .kt { color: #ffcc66 } /* Keyword.Type */
        .ld { color: #99cc99 } /* Literal.Date */
        .m { color: #f99157 } /* Literal.Number */
        .s { color: #99cc99 } /* Literal.String */
        .na { color: #6699cc } /* Name.Attribute */
        .nb { color: #cccccc } /* Name.Builtin */
        .nc { color: #ffcc66 } /* Name.Class */
        .no { color: #f2777a } /* Name.Constant */
        .nd { color: #66cccc } /* Name.Decorator */
        .ni { color: #cccccc } /* Name.Entity */
        .ne { color: #f2777a } /* Name.Exception */
        .nf { color: #6699cc } /* Name.Function */
        .nl { color: #cccccc } /* Name.Label */
        .nn { color: #ffcc66 } /* Name.Namespace */
        .nx { color: #6699cc } /* Name.Other */
        .py { color: #cccccc } /* Name.Property */
        .nt { color: #66cccc } /* Name.Tag */
        .nv { color: #f2777a } /* Name.Variable */
        .ow { color: #66cccc } /* Operator.Word */
        .w { color: #cccccc } /* Text.Whitespace */
        .mf { color: #f99157 } /* Literal.Number.Float */
        .mh { color: #f99157 } /* Literal.Number.Hex */
        .mi { color: #f99157 } /* Literal.Number.Integer */
        .mo { color: #f99157 } /* Literal.Number.Oct */
        .sb { color: #99cc99 } /* Literal.String.Backtick */
        .sc { color: #cccccc } /* Literal.String.Char */
        .sd { color: #999999 } /* Literal.String.Doc */
        .s2 { color: #99cc99 } /* Literal.String.Double */
        .se { color: #f99157 } /* Literal.String.Escape */
        .sh { color: #99cc99 } /* Literal.String.Heredoc */
        .si { color: #f99157 } /* Literal.String.Interpol */
        .sx { color: #99cc99 } /* Literal.String.Other */
        .sr { color: #99cc99 } /* Literal.String.Regex */
        .s1 { color: #99cc99 } /* Literal.String.Single */
        .ss { color: #99cc99 } /* Literal.String.Symbol */
        .bp { color: #cccccc } /* Name.Builtin.Pseudo */
        .vc { color: #f2777a } /* Name.Variable.Class */
        .vg { color: #f2777a } /* Name.Variable.Global */
        .vi { color: #f2777a } /* Name.Variable.Instance */
        .il { color: #f99157 } /* Literal.Number.Integer.Long */

        @media screen and (min-width: 768px) {
            .bs-example { margin-left: 0; margin-right: 0; background-color: #fff; border-width: 1px; border-color: #ddd; border-radius: 4px 4px 0 0; box-shadow: none; }
            .bs-example + .prettyprint, .bs-example + .highlight { margin-top: -1px; margin-left: 0; margin-right: 0; border-width: 1px; border-bottom-left-radius: 4px; border-bottom-right-radius: 4px; }
        }

        @media screen and (min-width: 992px) {
            .bs-sidebar .nav > .active > ul { display: block; }
            .bs-sidebar.affix, .bs-sidebar.affix-bottom { width: 213px; }
            .bs-sidebar.affix { position: fixed; top: 60px; }
            .bs-sidebar.affix-bottom { position: absolute; }
            .bs-sidebar.affix-bottom .bs-sidenav, .bs-sidebar.affix .bs-sidenav { margin-top: 0; margin-bottom: 0; }
        }

        @media screen and (min-width: 1200px) {
            .bs-sidebar.affix-bottom, .bs-sidebar.affix { width: 263px; }
        }

		.styled-select select {
		   background: transparent;
		   width: 268px;
		   padding: 5px;
		   font-size: 12px;
		   line-height: 1;
		   border: 1px;
		   border-radius: 1px;
		   height: 30px;
		   }


  
    #tagih {
        position: relative;
        width: 922px;
        height: 100px;
        padding: 0.4em;
    }  
    </style>
    <script type="text/javascript"> 
    var nip='';
	var kdskpd='';
	var kdrek5='';
    var nmx='';
    var nmbulan='';
    var pilihttd='';
    
    window.onbeforeunload = confirmclose;
	function confirmclose(){
	choice="Anda yakin untuk menutup Halaman ini?";
	return choice;
	}
	
     $(document).ready(function() {
            $("#accordion").accordion();            
            $( "#dialog-modal" ).dialog({
                height: 100,
                width: 922            
            }); 

		/*$('#bulan').combogrid({  
           panelWidth:120,
           panelHeight:300,  
           idField:'bln',  
           textField:'nm_bulan',  
           mode:'remote',
           url:'<?php echo base_url(); ?>index.php/rka/bulan',  
           columns:[[ 
               {field:'nm_bulan',title:'Nama Bulan',width:700} 
           ]],
		   onSelect:function(rowIndex,rowData){
				kosongkan();
				$('#cetak0').linkbutton('disable');
				$('#cetak1').linkbutton('disable');
				$('#cetak2').linkbutton('disable');
				$('#cetak3').linkbutton('disable');
    			document.getElementById('isidata').innerHTML = "";
    			bln = rowData.bln;
				AddItems('Penghitungan Realisasi Bulan '+bln+'!','','0');
				AddItems('Loading......................','','0');
				hit_record2(bln);
				
    			}   
	   });*/
       
       
       $('#sskpd').combogrid({  
		panelWidth:630,  
		idField:'kd_skpd',  
		textField:'kd_skpd',  
		mode:'remote',
		url:'<?php echo base_url(); ?>index.php/akuntansi/skpd_new',  
		columns:[[  
			{field:'kd_skpd',title:'Kode SKPD',width:100},  
			{field:'nm_skpd',title:'Nama SKPD',width:500}    
		]],
		onSelect:function(rowIndex,rowData){
			kdskpd = rowData.kd_skpd;
            nmx = rowData.nm_skpd;
			$("#nmskpd").attr("value",rowData.nm_skpd);
			//$("#skpd").attr("value",rowData.kd_skpd);			
		}  
		}); 

		          $('#bulan').combogrid({  
                   panelWidth:100,
                   panelHeight:300,  
                   idField:'bulan',  
                   textField:'nm_bulan',  
                   mode:'remote',
                   url:'<?php echo base_url(); ?>index.php/rka/bulan',
                   columns:[[ 
                       {field:'nm_bulan',title:'Nama Bulan',width:120}
                   ]],
					onSelect:function(rowIndex,rowData){
						bulan = rowData.bln;
                        nmbln = rowData.nm_bulan;
						$("#nmbulan").attr("value",rowData.nm_bulan);
					}
               });  
        
                $('#bulanctk').combogrid({  
                   panelWidth:100,
                   panelHeight:300,  
                   idField:'bulan',  
                   textField:'nm_bulan',  
                   mode:'remote',
                   url:'<?php echo base_url(); ?>index.php/rka/bulan',
                   columns:[[ 
                       {field:'nm_bulan',title:'Nama Bulan',width:120}
                   ]],
					onSelect:function(rowIndex,rowData){
						bulanctk = rowData.bln;
						$("#nmbulanctk").attr("value",rowData.nm_bulan);
					}
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
       
   });


function mapping_llpe(){

    if(kdskpd==""){
        alert("Pilih SKPD");
        exit();
    }
    

    AddItems('Penghitungan LPE '+nmx+' Sampai dengan Bulan '+nmbln+' TA 2017!','','0');
	AddItems('Loading......................','','0');
	hit_record2(bulan);

 
}


function kosongkan(){
	$('.progress-bar').attr({'aria-valuetransitiongoal': 0});
	$('.progress-bar').progressbar({display_text: 'fill'});
	$('.h-default-themed .progress-bar').progressbar();
	}
		
function isi_list(bulan){
			var c=rec-1;
			if (rec>0){
			var b = 20;
			var z = Math.round(rec/b);
			var q = z+1;
			//alert(z);
			satuan = 100/q;
				var a=0;
				var akhir =0;
				for (var i=1;i<=q ;i++ )
				{
					  setTimeout(function(){
							ambil_apbd_wsdl(a,c,bulan,b,akhir);
							a=a+b;;
					  },1*i);
				}
			}else{
				alert('Data Tidak Ditemukan');
			}
		}		
		
function ambil_apbd_wsdl(baris,ahir,bulan,interval,rrrrr){
			
            var isi='';
			var lim='0';
			rrrrr = baris+interval;
            var kodeskpd = kdskpd;
			
            //AddItems('Pengiriman data '+(baris+1)+' dari '+(ahir+1)+'','','0');					
			$(document).ready(function(){
				$.ajax({
					type: "POST",
					url: '<?php echo base_url(); ?>/index.php/akuntansi/proses_mapping_lpe_konsols',
					data: ({cbaris:baris,bulan:bulan,jumbaris:ahir,lim:lim,sel:interval,kodeskpd:kodeskpd}),
					dataType:"json",
					success:function(data){
					if (data = 1){
					AddItems('Selesai... 100% ','','1');
					}else{
					AddItems('Gagal...','','1');   
					}
					
					if(rrrrr>=ahir){
					   
					$('#cetak0').linkbutton('enable');
					$('#cetak1').linkbutton('enable');
					$('#cetak2').linkbutton('enable');
					$('#cetak3').linkbutton('enable');
                    
					}							
					}
				});
			});        		
		
		}		
		
function hit_record2(bulan){
			posisi=0;
				sukses=0;
				gagal=0;
				current=0;
				aa=0;
                
            var cbulan = $('#bulan').datebox('getValue');
           	var a='1';
			var skpd=0;
			$(document).ready(function(){
				$.ajax({
					type: "POST",
					url: '<?php echo base_url(); ?>/index.php/akuntansi/jum_record_lpe_konsols',
					data: ({skpd37:kdskpd,bulan:bulan}),
					dataType:"json",
					success:function(data){
						//alert(data.jumlah);
						$.each(data, function(i,n){
                        rec=n['jumlah'];
						});					
                        AddItems('Sedang Proses Pemutahiran Data... harap tunggu...!','','0');                        
                        isi_list(bulan);

					}
				});
			}); 
      		
		}
		
function AddItems(isi,pesan,tambah)
		{
		
			//progress bar
			if (tambah=='1'){
				posisi=posisi+satuan;
				$('.progress-bar').attr({'aria-valuetransitiongoal': posisi});
				$('.progress-bar').progressbar({display_text: 'fill'});
				$('.h-default-themed .progress-bar').progressbar();
			}
				
			
			//=============================================================
			var mySel = document.getElementById("isidata"); 
            var myOption; 

            myOption = document.createElement("Option"); 
            myOption.text = isi; 
            myOption.value = isi; 
			if(pesan!=''){
				if (tambah=='1'){
					gagal=gagal+1;
		        }
				myOption.style = 'color:red;font-family:courier new;'; 
			}else{
				if (tambah=='1'){
					sukses=sukses+1;
				}
	            myOption.style = 'color:white;font-family:courier new;'; 			
	            //myOption.style = 'color:green;font-family:courier new;'; 			
			}
			mySel.add(myOption);			
			bawah();
		}

		function bawah() {
			var objDiv = document.getElementById("isidata");
			objDiv.scrollTop = objDiv.scrollHeight;
			return false;
		}
        
        
        function runEffect() {        
			$('#qttd2')._propAttr('checked',false);
		    pilihttd = "1";  	
		};  
		
		function runEffect2() {        
			$('#qttd')._propAttr('checked',false);
            pilihttd = "2";
		};
		
    	function cetaklo(ctk)
        {
			/*var txt;
			var r = confirm("Pilih [OKE] untuk Cetak menggunakan Tanda Tangan");
			if (r == true) {
			txt = "1";
			} else {
			txt = "0";
			}*/	
			
            var initx = pilihttd;            
            var ctglttd = $('#tgl_ttd1').datebox('getValue'); 
            
            
            var cetak =ctk;           	
			var url    = "<?php echo site_url(); ?>/akuntansi/cetak_lo_konsol_gab_real";	  
			window.open(url+'/'+cetak+'/'+initx+'/'+ctglttd, '_blank');			
			window.focus();
        }
					
        function cetaklpegab_pemkotlalu(ctk)
        {
            var initx = pilihttd;            
            var ctglttd = $('#tgl_ttd1').datebox('getValue'); 
            
            var cbulan = $('#bulanctk').datebox('getValue');
            var cetak =ctk;           	
			var url    = "<?php echo site_url(); ?>/akuntansi/cetak_lpe_gab_konsol_pemkot_lalu";	  
			window.open(url+'/'+bulanctk+'/'+cetak+'/'+initx+'/'+ctglttd, '_blank');			
			window.focus();
        }
					
        function cetaklpegab_pemkotlalu1(ctk)
        {
            var initx = pilihttd;            
            var ctglttd = $('#tgl_ttd1').datebox('getValue'); 
            
            var cbulan = $('#bulanctk').datebox('getValue');
            var cetak =ctk;           	
			var url    = "<?php echo site_url(); ?>/akuntansi/cetak_lpe_gab_konsol_pemkot_lalu_calk";	  
			window.open(url+'/'+bulanctk+'/'+cetak+'/'+initx+'/'+ctglttd, '_blank');			
			window.focus();
        }
        
        function cetaklpegab_pemkotrinci(ctk)
        {
            var initx = pilihttd;            
            var ctglttd = $('#tgl_ttd1').datebox('getValue'); 
            var cbulan = $('#bulanctk').datebox('getValue');
            var cetak =ctk;           	
			var url    = "<?php echo site_url(); ?>/akuntansi/cetak_lpe_gab_konsol_rinci_lalu";	  
			window.open(url+'/'+bulanctk+'/'+cetak+'/'+initx+'/'+ctglttd, '_blank');			
			window.focus();
        }	
        
        function cetaklpegab_pemkotrinci1(ctk)
        {
            var initx = pilihttd;            
            var ctglttd = $('#tgl_ttd1').datebox('getValue'); 
            var cbulan = $('#bulanctk').datebox('getValue');
            var cetak =ctk;           	
			var url    = "<?php echo site_url(); ?>/akuntansi/cetak_lpe_gab_konsol_rinci_lalu_calk";	  
			window.open(url+'/'+bulanctk+'/'+cetak+'/'+initx+'/'+ctglttd, '_blank');			
			window.focus();
        }	
        
		function cetaklpegab_konsol(ctk)
        {
            var cbulan = $('#bulanctk').datebox('getValue');
            var cetak =ctk;           	
			var url    = "<?php echo site_url(); ?>/akuntansi/cetak_lpe_gab_konsol";	  
			window.open(url+'/'+bulanctk+'/'+cetak, '_blank');
			window.focus();
        }	
        
        function cetaklpegab_konsol2(ctk)
        {
            var cbulan = $('#bulanctk').datebox('getValue');
            var cetak =ctk;           	
			var url    = "<?php echo site_url(); ?>/akuntansi/cetak_lpe_gab_konsol_pemkot1";	  
			window.open(url+'/'+bulanctk+'/'+cetak, '_blank');
			window.focus();
        }
        
        function cetaklpegab_konsol_rinci(ctk)
        {
            var cbulan = $('#bulanctk').datebox('getValue');
            var cetak =ctk;           	
			var url    = "<?php echo site_url(); ?>/akuntansi/cetak_lpe_gab_konsol_rinci";	  
			window.open(url+'/'+bulanctk+'/'+cetak, '_blank');
			window.focus();
        }	
     	
         function cetaklpegab_konsol_rinci2(ctk)
        {
            var cbulan = $('#bulanctk').datebox('getValue');
            var cetak =ctk;           	
			var url    = "<?php echo site_url(); ?>/akuntansi/cetak_lpe_gab_konsol_rinci2";	  
			window.open(url+'/'+bulanctk+'/'+cetak, '_blank');
			window.focus();
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



<h3>LAPORAN LPE PEMKOT GABUNGAN</h3>       
<div id="accordion">
    
    <p align="right">         
        <table id="sp2d" title="Cetak" style="width:920px;height:200px;" >          
        
		<!--<tr>
                            <td width="10%">BULAN</td>
                            <td width="50%"><input id="bulan" name="bulan" style="width: 100px;" /></td>
                            <td width="40%">														
                            </td>
		</tr>-->
        <tr>
                <td colspan="3" align="left">SKPD <input id="sskpd" name="sskpd" style="width: 150px;" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="nmskpd" name="nmskpd" style="width: 500px; border:0;" /></td>
        </tr>
        
        <tr>
                <td colspan="2">
                <div id="div_periode">
                        <table style="width:100%;" border="0">
                            <td width="22px" height="40%">BULAN</td>
                            <td width="900px"><input id="bulan" style="width: 120px;" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="nmbulan" style="width: 120px; border:0;" /></td>
        </tr>
                            </td>
                        </table>
                </div>         
        
		<tr>
                <td colspan="3" align="center"><INPUT TYPE="button" VALUE="POSTING LPE SKPD" style="height:40px;width:180px" onclick="mapping_llpe()" ></td>
        </tr>
                <td colspan="2">
                <div id="div_periode">
                        <table style="width:100%;" border="0">
                            <tr>
                            <td width="120px" height="40%">Cetak Bulan</td>
                            <td width="900px"><input id="bulanctk" style="width: 120px;" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="nmbulanctk" style="width: 120px; border:0;" /></td>
                            </tr>
                            </td>
                        </table>
                </div>        
        <tr>
                <td>
                <input id="qttd2" name="qttd2" type="checkbox" value="2" onclick="javascript:runEffect2();"/> Tanpa TTD 
                <input id="qttd" name="qttd" type="checkbox" value="1" onclick="javascript:runEffect();"/> Dengan TTD &nbsp;&nbsp;                               
                <input type="text" id="tgl_ttd1" style="width: 100px;" />
                </td>
        </tr>         
		
		<tr >
			<td align ='left'>PEMKOT KESELURUHAN (CALK) &nbsp;&nbsp;</td> 
			<td align ='left'>
			<a id="cetak0" class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetaklpegab_pemkotlalu1(0);">Cetak Layar</a>
			<a id="cetak0" class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetaklpegab_pemkotlalu1(1);">Cetak PDF</a>
            <a id="cetak1" class="easyui-linkbutton" disabled iconCls="icon-excel" plain="true" onclick="javascript:cetaklpegab_pemkotlalu1(2);">Cetak excel</a>
            <a id="cetak2" class="easyui-linkbutton" disabled iconCls="icon-word" plain="true" onclick="javascript:cetaklpegab_pemkotlalu1(3);">Cetak word</a></td>
		</tr>      
		
		<tr >
			<td align ='left'>PEMKOT KESELURUHAN &nbsp;&nbsp;</td> 
			<td align ='left'>
			<a id="cetak0" class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetaklpegab_pemkotlalu(0);">Cetak Layar</a>
			<a id="cetak0" class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetaklpegab_pemkotlalu(1);">Cetak PDF</a>
            <a id="cetak1" class="easyui-linkbutton" disabled iconCls="icon-excel" plain="true" onclick="javascript:cetaklpegab_pemkotlalu(2);">Cetak excel</a>
            <a id="cetak2" class="easyui-linkbutton" disabled iconCls="icon-word" plain="true" onclick="javascript:cetaklpegab_pemkotlalu(3);">Cetak word</a></td>
		</tr>		        
        <tr >
			<td align ='left'>PEMKOT KESELURUHAN RINCIAN (CALK) &nbsp;&nbsp;</td> 
			<td align ='left'>
			<a id="cetak0" class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetaklpegab_pemkotrinci1(0);">Cetak Layar</a>
			<a id="cetak0" class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetaklpegab_pemkotrinci1(1);">Cetak PDF</a>
            <a id="cetak1" class="easyui-linkbutton" disabled iconCls="icon-excel" plain="true" onclick="javascript:cetaklpegab_pemkotrinci1(2);">Cetak excel</a>
            <a id="cetak2" class="easyui-linkbutton" disabled iconCls="icon-word" plain="true" onclick="javascript:cetaklpegab_pemkotrinci1(3);">Cetak word</a></td>
		</tr>			        
        <tr >
			<td align ='left'>PEMKOT KESELURUHAN RINCIAN &nbsp;&nbsp;</td> 
			<td align ='left'>
			<a id="cetak0" class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetaklpegab_pemkotrinci(0);">Cetak Layar</a>
			<a id="cetak0" class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetaklpegab_pemkotrinci(1);">Cetak PDF</a>
            <a id="cetak1" class="easyui-linkbutton" disabled iconCls="icon-excel" plain="true" onclick="javascript:cetaklpegab_pemkotrinci(2);">Cetak excel</a>
            <a id="cetak2" class="easyui-linkbutton" disabled iconCls="icon-word" plain="true" onclick="javascript:cetaklpegab_pemkotrinci(3);">Cetak word</a></td>
		</tr>		
        <tr >
			<td align ='left'>PEMKOT GABUNGAN &nbsp;&nbsp;</td> 
			<td align ='left'>
			<a id="cetak0" class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetaklpegab_konsol2(0);">Cetak Layar</a>
			<a id="cetak0" class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetaklpegab_konsol2(1);">Cetak PDF</a>
            <a id="cetak1" class="easyui-linkbutton" disabled iconCls="icon-excel" plain="true" onclick="javascript:cetaklpegab_konsol2(2);">Cetak excel</a>
            <a id="cetak2" class="easyui-linkbutton" disabled iconCls="icon-word" plain="true" onclick="javascript:cetaklpegab_konsol2(3);">Cetak word</a></td>
		</tr>
		<tr >			
			<td align ='left'>PEMKOT GABUNGAN RINCIAN &nbsp;&nbsp;</td> 
			<td align ='left'>
			<a id="cetak0" class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetaklpegab_konsol_rinci2(0);">Cetak Layar</a>
			<a id="cetak0" class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetaklpegab_konsol_rinci2(1);">Cetak PDF</a>
            <a id="cetak1" class="easyui-linkbutton" disabled iconCls="icon-excel" plain="true" onclick="javascript:cetaklpegab_konsol_rinci2(2);">Cetak excel</a>
            <a id="cetak2" class="easyui-linkbutton" disabled iconCls="icon-word" plain="true" onclick="javascript:cetaklpegab_konsol_rinci2(3);">Cetak word</a></td>
		</tr>	
        
        <tr >			
			<td align ='left'>PER SKPD &nbsp;&nbsp;</td> 
			<td align ='left'>
			<a id="cetak0" class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetaklpegab_konsol(0);">Cetak Layar</a>
			<a id="cetak0" class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetaklpegab_konsol(1);">Cetak PDF</a>
            <a id="cetak1" class="easyui-linkbutton" disabled iconCls="icon-excel" plain="true" onclick="javascript:cetaklpegab_konsol(2);">Cetak excel</a>
            <a id="cetak2" class="easyui-linkbutton" disabled iconCls="icon-word" plain="true" onclick="javascript:cetaklpegab_konsol(3);">Cetak word</a></td>
		</tr>	
        
        <tr >			
			<td align ='left'>RINCIAN PER SKPD &nbsp;&nbsp;</td> 
			<td align ='left'>
			<a id="cetak0" class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetaklpegab_konsol_rinci(0);">Cetak Layar</a>
			<a id="cetak0" class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetaklpegab_konsol_rinci(1);">Cetak PDF</a>
            <a id="cetak1" class="easyui-linkbutton" disabled iconCls="icon-excel" plain="true" onclick="javascript:cetaklpegab_konsol_rinci(2);">Cetak excel</a>
            <a id="cetak2" class="easyui-linkbutton" disabled iconCls="icon-word" plain="true" onclick="javascript:cetaklpegab_konsol_rinci(3);">Cetak word</a></td>
		</tr>
        
        </table>   
		<div class="bs-example h-default-themed">
		<div class="progress progress-striped active">
			<div class="progress-bar" role="progressbar" aria-valuetransitiongoal="0" id="prog"></div>
		</div>
	
		<select name="isidata" id="isidata" multiple="multiple" style="width:100%;height:70px;background-color:#000000;border:0px" disabled>
		</select>		
		
		
		</div>
    </p> 
    

</div>

</div>

 	
</body>

</html>