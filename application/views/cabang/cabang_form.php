
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">Cabang <?php echo form_error('cabang') ?></label>
            <input type="text" class="form-control" name="cabang" id="cabang" placeholder="Cabang" value="<?php echo $cabang; ?>" />
        </div>
	    <input type="hidden" name="id_cabang" value="<?php echo $id_cabang; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('cabang') ?>" class="btn btn-default">Cancel</a>
	</form>
   