
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">Judul Check <?php echo form_error('id_check') ?></label>
            <!-- <input type="text" class="form-control" name="id_check" id="id_check" placeholder="Id Check" value="<?php echo $id_check; ?>" /> -->
            <select name="id_check" class="form-control">
                <option value="<?php echo $id_check ?>"><?php echo $id_check ?></option>
                <?php foreach ($this->db->get('check_header')->result() as $key => $value): ?>
                    <option value="<?php echo $value->id_check ?>"><?php echo $value->judul ?></option>
                <?php endforeach ?>
                
            </select>
        </div>
	    <div class="form-group">
            <label for="varchar">Detail <?php echo form_error('detail') ?></label>
            <input type="text" class="form-control" name="detail" id="detail" placeholder="Detail" value="<?php echo $detail; ?>" />
        </div>
	    <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('check_detail') ?>" class="btn btn-default">Cancel</a>
	</form>
   