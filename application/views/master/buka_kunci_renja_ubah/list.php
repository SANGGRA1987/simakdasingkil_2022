<div id="content">
    	<h1><?php echo $page_title; ?> </h1>
		<?php echo form_open('master/cari_user', array('class' => 'basic')); ?>
		<!--Karakter yang di cari :&nbsp;&nbsp;&nbsp;<input type="text" name="pencarian" id="pencarian" value="<?php echo set_value('text'); ?>" />
        <input type='submit' name='cari' value='cari' class='btn' />-->
        <?php echo form_close(); ?>
		<?php if (  $this->session->flashdata('notify') <> "" ) : ?>
			<div class="success"><?php echo $this->session->flashdata('notify'); ?></div>
        <?php endif; ?>
    
        <table class="narrow">
        	<tr>
                <th>Kode SKPD</th>
				<th>Nama SKPD</th>
				<th>Aksi Perubahan</th>
            </tr>
            <?php foreach($list->result() as $user) : ?>
            <tr>
				<td><?php echo $user->kd_skpd; ?></td>
				<td><?php echo $user->nm_skpd; ?></td>
		    <?php if (  $user->kunci_ubah != "2" ) : ?>	
                <td>Kunci User Perubahan&nbsp;
                <a href="<?php echo site_url(); ?>/master/tombol_kunci_renja2_ubah/<?php echo $user->kd_skpd; ?>" title="Kunci Inputan User Renja Perubahan"><img src="<?php echo base_url(); ?>assets/images/icon/kunci.ico" /></a>
            <?php endif; ?>
            <?php if (  $user->kunci_ubah == "2" ) : ?>
                <td>Buka User Perubahan&nbsp;
                <a href="<?php echo site_url(); ?>/master/tombol_buka_renja_ubah/<?php echo $user->kd_skpd; ?>" title="Buka Inputan User Renja Perubahan"><img src="<?php echo base_url(); ?>assets/images/icon/unlock.ico" /></a>
            <?php endif; ?>     
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <div class="clear"></div>
		  <table>
        <tr align="center">
 
               <center>
                <a href="<?php echo site_url(); ?>/master/tombol_kunci_inputan_semua_ubah/<?php echo '1';?>"  class="easyui-linkbutton" plain="true" onclick="javascript:openWindow(this.href);return false"><img src="<?php echo base_url(); ?>assets/images/icon/kunci.ico"  width="25" height="15" title="cetak">Kunci Login Keseluruhan Inputan Perubahan</a></center>
                </td>               
            </tr>
       
        </table>
	</div>