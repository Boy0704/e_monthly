<div class="row">
	<div class="col-md-12">
		<table class="table">
			<tr>
				<td>Outlet</td>
				<td>:</td>
				<td>
					<select name="outlet" class="form-control">
		                <option value="">--Pilih Outlet--</option>
		                <?php foreach ($this->db->get('outlet')->result() as $key => $value): ?>
		                    <option value="<?php echo $value->id_outlet ?>"><?php echo $value->outlet ?></option>
		                <?php endforeach ?>
		                
		            </select>
				</td>
			</tr>
		</table>
	</div>
</div>

<?php 
foreach ($variable as $key => $value): ?>

<div class="row">
	<div class="col-md-12">
		<table class="table">
			<tr>
				<td>Outlet</td>
				<td>:</td>
				<td>
					<select name="outlet" class="form-control">
		                <option value="">--Pilih Outlet--</option>
		                <?php foreach ($this->db->get('outlet')->result() as $key => $value): ?>
		                    <option value="<?php echo $value->id_outlet ?>"><?php echo $value->outlet ?></option>
		                <?php endforeach ?>
		                
		            </select>
				</td>
			</tr>
		</table>
	</div>
</div>


<?php endforeach ?>