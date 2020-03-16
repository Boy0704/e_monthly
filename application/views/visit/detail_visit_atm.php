<?php 
$id_user = '';
$group_visit=$this->uri->segment(3);
$sql = "SELECT * FROM header_visit_atm as hv, visit_atm as va where hv.id_visit_atm=va.id_visit_atm and va.group_visit='$group_visit' GROUP BY hv.id_user ";
$data = $this->db->query($sql)->result();
// log_r($this->db->last_query());
foreach ($data as $dt) {
	$id_outlet = get_data('atm','no_id',$dt->no_id,'outlet');
 ?>
<div class="row">
	<div class="col-md-12">
		<a href="#view<?php echo $dt->id_user ?>" class="btn btn-info btn-block" data-toggle="collapse">Outlet : <?php echo get_data('outlet','id_outlet',$id_outlet,'outlet') ?> | User : <?php echo get_data('user','id_user',$dt->id_user,'nama') ?> | <?php echo $retVal = ($dt->approve == 1) ? '<span class="label label-success">Sudah di Approve</span>' : '<span class="label label-warning">Belum di approve</span>' ; ?></a>
		  <div id="view<?php echo $dt->id_user ?>" class="collapse" >
		  
		   <div class="row">
				<div class="col-md-12">
					<table class="table">
						<tr>
							<td>ID ATM</td>
							<td>:</td>
							<td>
								<?php echo $dt->no_id ?>
							</td>
						</tr>
						<tr>
							<td>Nama ATM</td>
							<td>:</td>
							<td>
								<?php echo get_data('atm','no_id',$dt->no_id,'nama_atm') ?>
							</td>
						</tr>
						<tr>
							<td>Tanggal / Waktu</td>
							<td>:</td>
							<td>
								<?php echo $dt->date ?>
							</td>
						</tr>
					</table>
				</div>
			</div>

			<?php 
			$this->db->where('id_check', 3);
			$b = $this->db->get('check_header')->result();
			foreach ($b as $bd) { ?>

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-info">
					  <div class="panel-heading"><?php echo $bd->judul ?></div>
					  <div class="panel-body">
					  		
					  		<table class="table">
					  			<?php 
					  			$ya = '';
					  			$tidak = '';
					  			$detail = $this->db->query("SELECT * FROM visit_atm as va, check_detail as cd where cd.id=va.id_detail_check and cd.id_check=3 and va.id_visit_atm='$dt->id_visit_atm' ");
					  			// log_r($this->db->last_query());
					  			foreach ($detail->result() as $rw){
					  				?>
					  				<tr>
										<td><?php echo $rw->detail ?></td>
										<td>:</td>
										<td>
											<?php echo $retVal = ($rw->pilihan_check == 1) ? 'ya' : 'tidak' ; ?>


										</td>

										
										
									</tr>
					  			<?php } ?>

					  			
								
							</table>
							
					  </div>
					</div>

				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-info">
					  <div class="panel-heading">Foto ATM</div>
					  <div class="panel-body">
					  		
					  		<table class="table">
					  			<tr>
					  				<td>Foto 1 :</td>
					  				<td><img src="image/visit/<?php echo $dt->foto1 ?>" style="width: 100px;"></td>
					  				<td><?php echo $dt->ket1 ?></td>
					  			</tr>
					  			<tr>
					  				<td>Foto 2 :</td>
					  				<td><img src="image/visit/<?php echo $dt->foto2 ?>" style="width: 100px;"></td>
					  				<td><?php echo $dt->ket2 ?></td>
					  			</tr>
					  		</table>
					  </div>
					</div>
				</div>
			</div>

			<?php } ?>

			<div class="row">
				<?php 
				if (cek_approval($dt->id_user, $this->session->userdata('level')) == 'ya' and $dt->approve==0) {
					?>
					<div class="col-md-4"><a href="#" class="btn btn-success" data-toggle="modal" data-target="#komentar_<?php echo $dt->id_visit_atm ?>">Rechecking</a></div>
					<?php
				}
				 ?>
				

				<!-- Modal -->
				<div id="komentar_<?php echo $dt->id_visit_atm ?>" class="modal fade" role="dialog">
				  <div class="modal-dialog">

				    <!-- Modal content-->
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal">&times;</button>
				        <h4 class="modal-title">Berikan Komentar !</h4>
				      </div>
				      <div class="modal-body">
				        <form action="app/simpan_approve_atm/<?php echo $rw->id_visit_atm ?>" method="post" enctype="multipart/form-data">
				        	<textarea class="form-control" rows="3" cols="90" name="komentar" required=""></textarea>
				        	<?php 
				        	if ($this->session->userdata('level') == 10) {
				        		if (cek_prg_atm($dt->id_user,$dt->group_visit) == 1) {
				        		?>
				        		<input type="hidden" name="progress" value="1">
				        		<input type="submit" name="simpan" class="btn btn-success btn-sm" value="SIMPAN">
				        		<?php
				        		} else {
				        		?>
				        		<input type="hidden" name="progress" value="1">
				        		<input type="submit" name="simpan_edit" class="btn btn-warning btn-sm" value="SIMPAN & EDIT VISIT">
				        		<?php
				        		}
				        	} else{
				        	 ?>
				        	<input type="hidden" name="progress" value="0">
				        	<input type="submit" name="simpan" class="btn btn-success btn-sm" value="SIMPAN" style="display: none;">
				        	<input type="submit" name="simpan_edit" class="btn btn-warning btn-sm" value="SIMPAN & EDIT VISIT">
				        	<?php } ?>
				        </form>
				      </div>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				      </div>
				    </div>

				  </div>
				</div>
			</div>
		  
		  </div>
	</div>

</div>
<hr>
<?php } ?>