<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title; ?></title>
<link rel="shortcut icon" href="<?php echo base_url(); ?>image/simakda.png" type="image/x-icon" />
<link href="<?php echo base_url(); ?>assets/style.css" rel="stylesheet" type="text/css" />
 <base href="<?php echo base_url();?>" />

  
  <style>

.label{
    font-family:Verdana, Arial, Helvetica, sans-serif;
    font-size:11px;
    color:#5a5a5a;
}
.tableBorder{
    border:solid 4px #5a5a5a;
    margin-top:10px;
    border-radius:10px; 
    /*box-shadow: 0px 0px 20px black;*/
}
.message{
    font-family:Verdana, Arial, Helvetica, sans-serif;
    font-size:14px;
    font-weight:bold;
    color:#5a5a5a;
}


.button {
  background-color: #5a5a5a; 
  border: none;
  color: white;
  padding: 10px 20px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 12px;
  margin: 4px 2px;
  cursor: pointer;
  border-radius: 10px;
}

.button:hover {
  background-color: #4CAF50; /* Green */
  color: white;
}
.button:active{
 top:0.1em;
}
@media all and (max-width:30em){
 .button{
  display:block;
  margin:0.4em auto;
 }
} 

</style>


</head>
<body>
<div id="wrapper">
    <div id="header">
        <div class="title"></div>
     
    </div>

    
    
    <?php echo $contents; ?>
    
    <div id="footer">
           <font color="white"><b>@ 2012 MSM Consultant</b></font>
        </div>

<div>
</body>
</html>