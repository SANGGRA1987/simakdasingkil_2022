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
  <style>    
    #tagih {
        position: relative;
        width: 900px;
        height: 100px;
        padding: 0.4em;
    }  
    </style>
    <script type="text/javascript"> 
    
    </script>

    <STYLE TYPE="text/css"> 
		 input.right{ 
         text-align:right; 
         } 
         
         
         #myProgress {
             width: 100%;
             background-color: #ddd;
        }

        #myBar {
            width: 1%;
            height: 30px;
            background-color: #1E90FF;
        }
        
        #myProgress2 {
             width: 100%;
             background-color: #ddd;
        }

        #myBar2 {
            width: 1%;
            height: 30px;
            background-color: #1E90FF;
        }
	</STYLE> 

</head>
<body>

<div id="content">
<?php 
$sql="select top 100 *, case when status='1' then 'Online' else 'Offline' end as stat from [user] order by his_login desc";
$exe=$this->db->query($sql);
$no=1;
 ?>  
 <br><br>
<center><strong>LOG AKTIVITAS </strong></center>
<br><br>
 <table width="100%" cellpadding="0" cellspacing="0">
<tr>
    <td bgcolor="#cccccc"><center><strong>#</td>
	<td bgcolor="#cccccc"><center><strong>USERNAME</td>
	<td bgcolor="#cccccc"><center><strong>STATUS</td>
	<td bgcolor="#cccccc"><center><strong>LAST LOGIN</td>
	<td bgcolor="#cccccc"><center><strong>LAST LOGOUT</td>
</tr>	
<?php foreach($exe->result() as $a) : ?>
<tr>
    <td><center><?= $no  ?></td>
	<td><?= $a->user_name  ?></td>
	<td><center><?= $a->stat  ?></td>
	<td><center><?= $a->his_login  ?></td>
	<td><center><?= $a->his_logout  ?></td>
</tr>

<?php $no++; endforeach ; ?>
 </table>      
</div>    
 	
</body>

</html>