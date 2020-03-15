<div class="row">
	<div class="col-md-12">

		<a href="app/add_visit_atm" class="btn btn-primary">Add Visit ATM</a> <br><br>

		<table class="table table-bordered" id="example1">
			<thead>
				<tr>
					<th>No.</th>
					<th>ID ATM</th>
					<th>Date</th>
					<th>User</th>
					<th>Option</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$no = 1;
				if ($this->session->userdata('level') == 1) {
					$sql = "SELECT * FROM header_visit_atm GROUP BY group_visit  order by date DESC";
					$visit = $this->db->query($sql);
				} elseif( $this->session->userdata('level') == 2 or $this->session->userdata('level')== 3 or $this->session->userdata('level') == 4 or $this->session->userdata('level') == 6 or $this->session->userdata('level') == 7 ) {
					$id_user = $this->session->userdata('id_user');
					$outlet = $this->session->userdata('outlet');
					$sql = "SELECT * FROM header_visit_atm WHERE no_id IN (SELECT no_id FROM atm WHERE outlet IN ($outlet)) GROUP BY group_visit order by date DESC";
					$visit = $this->db->query($sql);
				
				} else {
					$sql = "SELECT * FROM header_visit_atm GROUP BY group_visit order by date DESC";
					$visit = $this->db->query($sql);
				}
				// log_r($this->db->last_query());
				foreach ($visit->result() as $rw) {
				 ?>
				<tr>
					<td><?php echo $no; ?></td>
					<td><?php echo $rw->no_id.' - '.get_data('atm','no_id',$rw->no_id,'nama_atm'); ?></td>
					<td><?php echo $rw->date ?></td>
					<td><?php echo get_data('user','id_user',$rw->id_user,'nama'); ?></td>
					
					<td>
						<a href="app/detail_visit_atm/<?php echo $rw->group_visit ?>" class="label label-info">Detail</a>
					</td>
				</tr>
			<?php $no++;} ?>
			</tbody>
		</table>
	</div>
</div>