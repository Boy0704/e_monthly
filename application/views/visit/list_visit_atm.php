<div class="row">
	<div class="col-md-12">

		<a href="app/add_visit_atm" class="btn btn-primary">Add Visit ATM</a> <br><br>

		<table class="table table-bordered" id="example1">
			<thead>
				<tr>
					<th>No.</th>
					<th>ID ATM</th>
					<th>User</th>
					<th>Approve</th>
					<th>Option</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$no = 1;
				if ($this->session->userdata('level') == 1) {
					$sql = "SELECT * FROM visit_atm  GROUP BY group_visit order by date DESC";
					$visit = $this->db->query($sql);
				} elseif($this->session->userdata('level') > 1 and $this->session->userdata('status_approve') == 0) {
					$id_user = $this->session->userdata('id_user');
					$outlet = $this->session->userdata('outlet');
					$sql = "SELECT * FROM visit_atm WHERE id_user='$id_user' GROUP BY group_visit order by date DESC";
					$visit = $this->db->query($sql);
				} elseif($this->session->userdata('level') > 1 and $this->session->userdata('status_approve') == 1) {
					$outlet = $this->session->userdata('outlet');
					$group_approve = $this->session->userdata('level');
					$sql = "SELECT * FROM visit_atm ,approve WHERE visit_atm.id_user=approve.group_create and visit_atm.group_visit=approve.group_visit and approve.outlet='$outlet' and approve.group_approve='$group_approve' group by visit_atm.date order by approve.id_approve DESC";
					$visit = $this->db->query($sql);
					// log_r($this->db->last_query());
				}
				foreach ($visit->result() as $rw) {
				 ?>
				<tr>
					<td><?php echo $no; ?></td>
					<td><?php echo $rw->id_atm.' - '.get_data('atm','no_id',$rw->id_atm,'nama_atm'); ?></td>
					<td><?php echo get_data('user','id_user',$rw->id_user,'nama'); ?></td>
					<td><?php echo $retVal = ($rw->approve == 1) ? '<span class="label label-success">ya</span>' : '<span class="label label-warning">tidak</span>' ; ?></td>
					<td>
						<a href="app/detail_visit_atm/<?php echo $rw->group_visit ?>" class="label label-info">Detail</a>

						<?php 
						if ($this->session->userdata('status_approve') == 1) {
							?>
							<a href="#" class="label label-primary" data-toggle="modal" data-target="#approve_<?php echo $rw->id_approve ?>">Approve Now</a>

							<a href="app/edit_visit_atm/<?php echo $rw->id_approve ?>" class="label label-success" onclick="javasciprt: return confirm('Are You Sure ?')">Edit Visit</a>

							<!-- Modal -->
							<div id="approve_<?php echo $rw->id_approve ?>" class="modal fade" role="dialog">
							  <div class="modal-dialog">

							    <!-- Modal content-->
							    <div class="modal-content">
							      <div class="modal-header">
							        <button type="button" class="close" data-dismiss="modal">&times;</button>
							        <h4 class="modal-title">Yakin Akan approve ini ?</h4>
							      </div>
							      <div class="modal-body">
							        <form action="app/simpan_approve_atm/<?php echo $rw->id_approve ?>" method="post" enctype="multipart/form-data">
							        	<label>Approve</label>
							        	<input type="radio" name="approve" value="1"> Ya
							        	<input type="radio" name="approve" value="0"> Tidak <br>
							        	<label>Keterangan</label> <br>
							        	<textarea class="form-control" rows="3" cols="90" name="ket" required=""></textarea>
							        	<button type="submit" class="btn btn-success btn-block">SIMPAN</button>
							        </form>
							      </div>
							      <div class="modal-footer">
							        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							      </div>
							    </div>

							  </div>
							</div>

							<?php
						}
						 ?>

					</td>
				</tr>
			<?php $no++;} ?>
			</tbody>
		</table>
	</div>
</div>