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

  
   </script>

<style>
.button {
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
}

.button1 {background-color: #4CAF50;} /* Green */
.button2 {background-color: #008CBA;} /* Blue */
</style>
<script type="text/javascript">
    function download(oke) {

        if(oke==1){
            var url="<?php echo site_url(); ?>/allprint/ekspor/";
        }else{
            var url="<?php echo site_url(); ?>/allprint/ekspor_realisasi/";
        }

        window.open(url);
    }
</script>
</head>
<body>
<div id="content">
    <fieldset>
 <h1>DOWNLOAD EXCEL APBD</h1>
<p>Realisasi berdasarkan dari nilai SPM</p>

<button class="button button1" onclick="javascript:download(1)">Download</button>
<button class="button button2" onclick="javascript:download(2)">Download (Realisasi)</button>           

    </fieldset>


</div>


</body>