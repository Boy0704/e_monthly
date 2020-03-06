<div class="row">
	<div class="col-md-12">

		<a href="app/add_visit" class="btn btn-primary">Add Visit Outlet</a> <br><br>

		<table class="table table-bordered" id="example1">
			<thead>
				<tr>
					<th>No.</th>
					<th>Outlet</th>
					<th>User</th>
					<th>Approve</th>
					<th>Option</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$no = 1;
				$visit='';
				if ($this->session->userdata('level') == 1) {
					$sql = "SELECT * FROM visit  GROUP BY group_visit order by date DESC";
					$visit = $this->db->query($sql);
				} elseif($this->session->userdata('level') > 1 and $this->session->userdata('status_approve') == 0) {
					$id_user = $this->session->userdata('id_user');
					$outlet = $this->session->userdata('outlet');
					$sql = "SELECT * FROM visit WHERE id_user='$id_user' and id_outlet='$outlet'  GROUP BY group_visit order by date DESC";
					$visit = $this->db->query($sql);
				} elseif($this->session->userdata('level') > 1 and $this->session->userdata('status_approve') == 1) {
					$outlet = $this->session->userdata('outlet');
					$group_approve = $this->session->userdata('level');
					$sql = "SELECT * FROM approve WHERE outlet='$outlet' and group_approve='$group_approve' order by id_approve DESC";
					$visit = $this->db->query($sql);
				}
				foreach ($visit->result() as $rw) {
				 ?>
				<tr>
					<td><?php echo $no; ?></td>
					<td><?php echo get_data('outlet','id_outlet',$rw->id_outlet,'outlet'); ?></td>
					<td><?php echo get_data('user','id_user',$rw->id_user,'nama'); ?></td>
					<td><?php echo $retVal = ($rw->approve == 1) ? '<span class="label label-success">ya</span>' : '<span class="label label-warning">tidak</span>' ; ?></td>
					<td>
						<a href="app/detail_visit_outlet/<?php echo $rw->group_visit ?>" class="label label-info">Detail</a>
					</td>
				</tr>
			<?php $no++;} ?>
			</tbody>
		</table>
	</div>
</div>