<div class="row">
	<div class="col-md-12">

		<table class="table table-bordered" id="example1">
			<thead>
				<tr>
					<th>No.</th>
					<th>ID ATM</th>
					<th>Date</th>
					<th>User</th>
					<th>Progress Approve</th>
					<th>Dilihat</th>
					<th>Status</th>
					<th>Option</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$no = 1;
				$visit = $data;
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
						<?php echo $retVal = ($rw->progress != 0) ? '<span class="label label-success">Done</span>' : '<span class="label label-warning">On Progress</span>' ; ?>
					</td>
					
					<td>
						<a href="app/detail_visit_atm/<?php echo $rw->group_visit ?>" class="label label-info">Detail</a>

						<?php 
						//bisa edit untuk admin cabang
						if ($this->session->userdata('level')=='10' and $this->uri->segment(4) == 'on_progress') {
							$cek = $this->db->get_where('header_visit_atm', array('group_visit'=>$rw->group_visit,'id_user'=>$this->session->userdata('id_user')));
							if ($cek->num_rows() > 0) {
								$id_visit_atm = $cek->row()->id_visit_atm;
								?>
								<a href="app/add_visit_form_atm/<?php echo $id_visit_atm ?>" class="label label-success">Edit</a>
								<?php
							}
							
						}
						 ?>
					</td>
				</tr>
			<?php $no++;} ?>
			</tbody>
		</table>
	</div>
</div>