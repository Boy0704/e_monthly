<?php 
$h = $d_visit->row();
 ?>
<div class="row">
	<div class="col-md-12">
		<table class="table">
			<tr>
				<td>Outlet</td>
				<td>:</td>
				<td>
					<select name="outlet" class="form-control">
		                <option value="<?php echo $id_outlet ?>"><?php echo get_data('outlet','id_outlet',$h->id_outlet,'outlet') ?></option>
		                <?php foreach ($this->db->get('outlet')->result() as $key => $value): ?>
		                    <option value="<?php echo $value->id_outlet ?>"><?php echo $value->outlet ?></option>
		                <?php endforeach ?>
		                
		            </select>
				</td>
			</tr>
			<tr>
				<td>Tanggal / Waktu</td>
				<td>:</td>
				<td>
					<?php echo $h->date ?>
				</td>
			</tr>
		</table>
	</div>
</div>

<?php 
$b = $d_visit->result();
foreach ($b as $bd): ?>

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