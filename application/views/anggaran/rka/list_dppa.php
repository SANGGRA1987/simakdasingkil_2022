

	<div id="content">        
    	<h1><?php echo $page_title; ?><span><a href="<?php echo site_url(); ?>/rka/dppa221">Kembali</a></span></h1>

		
	 
        <table class="narrow">
        	<tr>
            	<th>Kode skpd</th>
                <th>Kode urusan</th>
                <th>Kode Kegiatan</th>
                <th>Nama Kegiatan</th>
                <th>Aksi</th>
            </tr>
            <?php foreach($list->result() as $kegiatan) : ?>
            <tr>
            	<td><?php echo $kegiatan->kd_skpd; ?></td>
                <td><?php echo $kegiatan->kd_urusan; ?></td>
                <td><?php echo $kegiatan->giat; ?></td>
                <td><?php echo $kegiatan->nm_kegiatan; ?></td>
                <td><a href="<?php echo site_url(); ?>/rka/preview_dppa221/<?php echo $kegiatan->kd_skpd; ?>/<?php echo $kegiatan->giat; ?>/<?php echo '1';?>"target='_blank'><img src="<?php echo base_url(); ?>assets/images/icon/print_pdf.png" width="25" height="23" title="cetak"/></a>
                    <a href="<?php echo site_url(); ?>/rka/preview_dppa221/<?php echo $kegiatan->kd_skpd; ?>/<?php echo $kegiatan->giat; ?>/<?php echo '2';?>"><img src="<?php echo base_url(); ?>assets/images/icon/excel.jpg" width="25" height="23" title="cetak"/></a></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php echo $this->pagination->create_links(); ?> <span class="totalitem">Total Item <?php echo $this->rka_model->get_count($this->uri->segment(3)); ?></span>
        <div class="clear"></div>
	</div>