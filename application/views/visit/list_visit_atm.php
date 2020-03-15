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
					<th>Progress Approve</th>
					<th>Dilihat</th>
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
						<div class="progress progress active">
			                <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="<?php echo prg_atm($rw->group_visit) ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo prg_atm($rw->group_visit) ?>%">
			                  <span><?php echo prg_atm($rw->group_visit) ?>%</span>
			                </div>
			              </div>

					</td>
					<td>
						<?php echo $retVal = ($rw->dilihat != '') ? '<span class="label label-success">'.$rw->dilihat.'</span>' : '<span class="label label-warning">Not View</span>' ; ?>
					</td>
					
					<td>
						<a href="app/detail_visit_atm/<?php echo $rw->group_visit ?>" class="label label-info">Detail</a>
					</td>
				</tr>
			<?php $no++;} ?>
			</tbody>
		</table>
	</div>
</div>