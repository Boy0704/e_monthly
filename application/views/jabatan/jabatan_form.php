
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">Jabatan <?php echo form_error('jabatan') ?></label>
            <input type="text" class="form-control" name="jabatan" id="jabatan" placeholder="Jabatan" value="<?php echo $jabatan; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Kategori <?php echo form_error('kategori') ?></label>
            <input type="text" class="form-control" name="kategori" id="kategori" placeholder="Kategori" value="<?php echo $kategori; ?>" />
        </div>
	    <input type="hidden" name="id_jabatan" value="<?php echo $id_jabatan; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('jabatan') ?>" class="btn btn-default">Cancel</a>
	</form>
   