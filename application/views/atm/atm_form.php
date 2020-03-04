
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">ID ATM <?php echo form_error('no_id') ?></label>
            <input type="text" class="form-control" name="no_id" id="no_id" placeholder="No Id" value="<?php echo $no_id; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Nama Atm <?php echo form_error('nama_atm') ?></label>
            <input type="text" class="form-control" name="nama_atm" id="nama_atm" placeholder="Nama Atm" value="<?php echo $nama_atm; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Cabang <?php echo form_error('cabang') ?></label>
            <!-- <input type="text" class="form-control" name="cabang" id="cabang" placeholder="Cabang" value="<?php echo $cabang; ?>" /> -->
            <select name="cabang" class="form-control">
                <option value="<?php echo $cabang ?>"><?php echo $cabang ?></option>
                <?php foreach ($this->db->get('cabang')->result() as $key => $value): ?>
                    <option value="<?php echo $value->id_cabang ?>"><?php echo $value->cabang ?></option>
                <?php endforeach ?>
                
            </select>
        </div>
        <div class="form-group">
            <label for="int">Outlet <?php echo form_error('outlet') ?></label>
            <!-- <input type="text" class="form-control" name="outlet" id="outlet" placeholder="Outlet" value="<?php echo $outlet; ?>" /> -->
            <select name="outlet" class="form-control">
                <option value="<?php echo $outlet ?>"><?php echo $outlet ?></option>
                <?php foreach ($this->db->get('outlet')->result() as $key => $value): ?>
                    <option value="<?php echo $value->id_outlet ?>"><?php echo $value->outlet ?></option>
                <?php endforeach ?>
                
            </select>
        </div>
	    <div class="form-group">
            <label for="alamat">Alamat <?php echo form_error('alamat') ?></label>
            <textarea class="form-control" rows="3" name="alamat" id="alamat" placeholder="Alamat"><?php echo $alamat; ?></textarea>
        </div>
	    <input type="hidden" name="id_atm" value="<?php echo $id_atm; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('atm') ?>" class="btn btn-default">Cancel</a>
	</form>
   