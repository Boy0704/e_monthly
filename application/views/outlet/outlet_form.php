
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">Outlet <?php echo form_error('outlet') ?></label>
            <input type="text" class="form-control" name="outlet" id="outlet" placeholder="Outlet" value="<?php echo $outlet; ?>" />
        </div>
	    
	    <div class="form-group">
            <label for="int">Cabang <?php echo form_error('id_cabang') ?></label>
            <!-- <input type="text" class="form-control" name="id_cabang" id="id_cabang" placeholder="Id Cabang" value="<?php echo $id_cabang; ?>" /> -->
            <select name="id_cabang" class="form-control">
                <option value="<?php echo $id_cabang ?>"><?php echo $id_cabang ?></option>
                <?php foreach ($this->db->get('cabang')->result() as $key => $value): ?>
                    <option value="<?php echo $value->id_cabang ?>"><?php echo $value->cabang ?></option>
                <?php endforeach ?>
                
            </select>
        </div>
        <div class="form-group">
            <label for="alamat">Alamat <?php echo form_error('alamat') ?></label>
            <textarea class="form-control" rows="3" name="alamat" id="alamat" placeholder="Alamat"><?php echo $alamat; ?></textarea>
        </div>
	    <input type="hidden" name="id_outlet" value="<?php echo $id_outlet; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('outlet') ?>" class="btn btn-default">Cancel</a>
	</form>
   