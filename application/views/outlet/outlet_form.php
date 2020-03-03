
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">Outlet <?php echo form_error('outlet') ?></label>
            <input type="text" class="form-control" name="outlet" id="outlet" placeholder="Outlet" value="<?php echo $outlet; ?>" />
        </div>
	    <div class="form-group">
            <label for="alamat">Alamat <?php echo form_error('alamat') ?></label>
            <textarea class="form-control" rows="3" name="alamat" id="alamat" placeholder="Alamat"><?php echo $alamat; ?></textarea>
        </div>
	    <input type="hidden" name="id_outlet" value="<?php echo $id_outlet; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('outlet') ?>" class="btn btn-default">Cancel</a>
	</form>
   