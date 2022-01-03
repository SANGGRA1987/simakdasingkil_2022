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
	$(function(){ 
		$("#load").hide();  


	});
    function bek(){

	    var ket = document.getElementById('ket').value;
	    var tahun = document.getElementById('tahun').value;     

	    $(function(){ 
	    	$("#tombol").hide();
	    	$("#load").show();     
			 $.ajax({
				type: 'POST',			
				dataType:"json",
				url:"<?php echo base_url(); ?>index.php/utilitas/backupsimakda/"+ket+"/"+tahun,            
				success:function(data){			 
				 status = data;             

	                    alert("berhasil"); 
	                    $("#load").hide();
	                    $("#tombol").show();                
	            }
			 });
			});    
    
    }



</script>
<style type="text/css">
.loader {
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite; /* Safari */
  animation: spin 2s linear infinite;
}

/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}	

</style>
<body>

<div id="content" align="center">
	BACKUP
<fieldset> Tahun
<select type="text" id="tahun"> 
<option value="2019">2019</option>
<option value="2020" selected>2020</option>
<option value="2021">2021</option>
<option value="2022">2022</option>
</select>		Keterangan
<input type="text" name="ket" id="ket" placeholder="opsional">
<div  id="load" class="loader"></div>
<button id="tombol" onclick="javascript:bek();">backup</button>


</fieldset>
           
</div>    
 	
</body>

</html>