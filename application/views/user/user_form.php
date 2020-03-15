
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">Nama <?php echo form_error('nama') ?></label>
            <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama" value="<?php echo $nama; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Username <?php echo form_error('username') ?></label>
            <input type="text" class="form-control" name="username" id="username" placeholder="Username" value="<?php echo $username; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Password <?php echo form_error('password') ?></label>
            <input type="text" class="form-control" name="password" id="password" placeholder="Password" value="<?php echo $password; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Level <?php echo form_error('level') ?></label>
            <!-- <input type="text" class="form-control" name="level" id="level" placeholder="Level" value="<?php echo $level; ?>" /> -->
            <select name="level" class="form-control">
                <option value="<?php echo $level ?>"><?php echo $level ?></option>
                <?php foreach ($this->db->get('group_user')->result() as $key => $value): ?>
                    <option value="<?php echo $value->id_group ?>"><?php echo $value->nama_group ?></option>
                <?php endforeach ?>
                
            </select>
        </div>
	    <div class="form-group">
            <label for="int">Approve <?php echo form_error('approve') ?></label>
            <!-- <input type="text" class="form-control" name="approve" id="approve" placeholder="Approve" value="<?php echo $approve; ?>" /> -->
            <select name="approve" class="form-control">
                <option value="<?php echo $approve ?>"><?php echo $approve ?></option>
                <?php foreach ($this->db->get('group_user')->result() as $key => $value): ?>
                    <option value="<?php echo $value->id_group ?>"><?php echo $value->nama_group ?></option>
                <?php endforeach ?>
                
            </select>
        </div>
	    <div class="form-group">
            <label for="int">Jabatan <?php echo form_error('jabatan') ?></label>
            <!-- <input type="text" class="form-control" name="jabatan" id="jabatan" placeholder="Jabatan" value="<?php echo $jabatan; ?>" /> -->
            <select name="jabatan" class="form-control">
                <option value="<?php echo $jabatan ?>"><?php echo $jabatan ?></option>
                <?php foreach ($this->db->get('jabatan')->result() as $key => $value): ?>
                    <option value="<?php echo $value->id_jabatan ?>"><?php echo $value->jabatan ?></option>
                <?php endforeach ?>
                
            </select>
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
            <select name="outlet[]" class="form-control select2" multiple="multiple" data-placeholder="Select a Outlet"
                        style="width: 100%;">
                <option value="<?php echo $outlet ?>" selected><?php echo $outlet ?></option>
                <?php foreach ($this->db->get('outlet')->result() as $key => $value): ?>
                    <option value="<?php echo $value->id_outlet ?>"><?php echo $value->outlet ?></option>
                <?php endforeach ?>
                
            </select>

            <!-- <div class="form-group">
                <label>Multiple</label>
                <select class="form-control select2" multiple="multiple" data-placeholder="Select a State"
                        style="width: 100%;">
                  <option>Alabama</option>
                  <option>Alaska</option>
                  <option>California</option>
                  <option>Delaware</option>
                  <option>Tennessee</option>
                  <option>Texas</option>
                  <option>Washington</option>
                </select>
              </div> -->
        </div>
	    <input type="hidden" name="id_user" value="<?php echo $id_user; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('user') ?>" class="btn btn-default">Cancel</a>
	</form>
   