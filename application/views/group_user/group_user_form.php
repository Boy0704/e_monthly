
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">Nama Group <?php echo form_error('nama_group') ?></label>
            <input type="text" class="form-control" name="nama_group" id="nama_group" placeholder="Nama Group" value="<?php echo $nama_group; ?>" />
        </div>
	    <input type="hidden" name="id_group" value="<?php echo $id_group; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('group_user') ?>" class="btn btn-default">Cancel</a>
	</form>
   