
<form action="app/add_outlet_visit_atm" method="POST">
<div class="row">
	<div class="col-md-12">
		<table class="table">
			<tr>
				<td>ID ATM</td>
				<td>:</td>

				<td>
					<select name="id_atm" class="form-control" required="">
		                <option value="">--Pilih ID ATM--</option>
		                <?php 
		                $this->db->where('outlet', $this->session->userdata('outlet'));
		                foreach ($this->db->get('atm')->result() as $key => $value): ?>
		                    <option value="<?php echo $value->no_id ?>"><?php echo $value->no_id.' - '.$value->nama_atm ?></option>
		                <?php endforeach ?>
		                
		            </select>
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