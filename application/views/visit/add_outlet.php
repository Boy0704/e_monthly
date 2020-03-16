
<form action="app/add_outlet_visit" method="POST">
<div class="row">
	<div class="col-md-12">
		<table class="table">
			<tr>
				<td>Outlet</td>
				<td>:</td>

				<td>
					<input type="hidden" name="outlet" value="<?php echo $this->session->userdata('outlet'); ?>">
					<input type="text" class="form-control" name="nama_outlet" value="<?php echo get_data('outlet','id_outlet',$this->session->userdata('outlet'),'outlet'); ?>" required="" readonly>
					<!-- <select name="outlet" class="form-control">
		                <option value="">--Pilih Outlet--</option>
		                <?php 
		                foreach ($this->db->get('outlet')->result() as $key => $value): ?>
		                    <option value="<?php echo $value->id_outlet ?>"><?php echo $value->outlet ?></option>
		                <?php endforeach ?>
		                
		            </select> -->
				</td>
				
			</tr>
			<tr>
				<td>Tanggal / Waktu</td>
				<td>:</td>
				<td>
					<input type="text" name="waktu" class="form-control" value="<?php echo get_waktu() ?>" readonly>
				</td>
			</tr>
			<tr>
				<td colspan="3">
					<button type="submit" class="btn btn-primary">ADD VISIT</button>
				</td>
			</tr>
		</table>
	</div>
</div>
</form>