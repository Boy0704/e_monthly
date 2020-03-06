<?php 
$this->db->group_by('id_user');
$this->db->order_by('date', 'asc');
$data = $this->db->get('visit')->result();
foreach ($data as $dt) {
 ?>
<div class="row">
	<div class="col-md-12">
		<a href="#view<?php echo $dt->id_user ?>" class="btn btn-info btn-block" data-toggle="collapse">Outlet : <?php echo get_data('outlet','id_outlet',$dt->id_outlet,'outlet') ?> | User : <?php echo get_data('user','id_user',$dt->id_user,'nama') ?></a>
		  <div id="view<?php echo $dt->id_user ?>" class="collapse">
		    
		  <?php 
		  if ($dt->id_user != $this->session->userdata('id_user')) {
		   ?>

		   <div class="row">
				<div class="col-md-12">
					<table class="table">
						<tr>
							<td>Outlet</td>
							<td>:</td>
							<td>
								<?php echo get_data('outlet','id_outlet',$dt->id_outlet,'outlet') ?>
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
			$b = $this->db->get('check_header')->result();
			foreach ($b as $bd): ?>

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-info">
					  <div class="panel-heading"><?php echo $bd->judul ?></div>
					  <div class="panel-body">
					  		
					  		<table class="table">
					  			<?php 
					  			$ya = '';
					  			$tidak = '';
					  			$id_user = $dt->id_user;
					  			$date = $dt->date;
					  			$sql = "SELECT v.id_visit,v.pilihan_check,v.foto,cd.detail,v.keterangan FROM visit as v, check_detail as cd WHERE v.id_detail_check=cd.id and cd.id_check='$bd->id_check' and v.id_user='$id_user' and v.date='$date'";
					  			$detail = $this->db->query($sql);
					  			// log_r($this->db->last_query());
					  			foreach ($detail->result() as $rw): 
					  				
					  				?>
					  				<tr>
										<td><?php echo $rw->detail ?></td>
										<td>:</td>
										<td>
											<?php echo $retVal = ($rw->pilihan_check == 1) ? 'ya' : 'tidak' ; ?>


										</td>

										<td>
											<?php 
											if ($rw->foto != '') {
												?>
												<a href="image/visit/<?php echo $rw->foto ?>" target="_blank">
													<img src="image/visit/<?php echo $rw->foto ?>" style="width: 100px; height: 100px;">
												</a>
												<?php
											} else {
												echo "<i>Tidak ada foto</i>";
											}

											 ?>
											
										</td>
										<td>
											<?php echo $rw->keterangan ?>
										</td>
										
									</tr>
					  			<?php endforeach ?>
								
							</table>
							
					  </div>
					</div>

				</div>
			</div>


			<?php endforeach ?>

		  <?php } else { ?>
		  	
			<div class="row">
				<div class="col-md-12">
					<table class="table">
						<tr>
							<td>Outlet</td>
							<td>:</td>
							<td>
								<?php echo get_data('outlet','id_outlet',$dt->id_outlet,'outlet') ?>
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
			$b = $this->db->get('check_header')->result();
			foreach ($b as $bd): ?>

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-info">
					  <div class="panel-heading"><?php echo $bd->judul ?></div>
					  <div class="panel-body">
					  		
					  		<table class="table">
					  			<?php 
					  			$ya = '';
					  			$tidak = '';
					  			$id_user = $dt->id_user;
					  			$date = $dt->date;
					  			$sql = "SELECT v.id_visit,v.pilihan_check,v.foto,cd.detail FROM visit as v, check_detail as cd WHERE v.id_detail_check=cd.id and cd.id_check='$bd->id_check' and v.id_user='$id_user' and v.date='$date'";
					  			$detail = $this->db->query($sql);
					  			// log_r($this->db->last_query());
					  			foreach ($detail->result() as $rw): 
					  				if ($rw->pilihan_check == '1') {
					  					$ya = 'checked';
					  				} elseif ($rw->pilihan_check == '0') {
					  					$tidak = 'checked';
					  				} 
					  				?>
					  				<tr>
										<td><?php echo $rw->detail ?></td>
										<td>:</td>
										<td>
											<label><input type="radio" name="pilihan_<?php echo $rw->id_visit ?>"  value="1"data-toggle="modal" data-target="#ya_<?php echo $rw->id_visit ?>" <?php echo $ya ?>> Ya </label>					
											<label><input type="radio" name="pilihan_<?php echo $rw->id_visit ?>"  value="0"data-toggle="modal" data-target="#tidak_<?php echo $rw->id_visit ?>" <?php echo $tidak ?>> Tidak</label>	

											<!-- Modal -->
											<div id="ya_<?php echo $rw->id_visit ?>" class="modal fade" role="dialog">
											  <div class="modal-dialog">

											    <!-- Modal content-->
											    <div class="modal-content">
											      <div class="modal-header">
											        <button type="button" class="close" data-dismiss="modal">&times;</button>
											        <h4 class="modal-title">Yakin Akan simpan ini ?</h4>
											      </div>
											      <div class="modal-body">
											        <form action="app/simpan_form_visit/<?php echo $rw->id_visit.'/'.$this->uri->segment(3).'/'.$id_user ?>" method="post">
											        	<input type="hidden" name="pilihan" value="1">
											        	<button type="submit" class="btn btn-success btn-block">SIMPAN</button>
											        </form>
											      </div>
											      <div class="modal-footer">
											        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											      </div>
											    </div>

											  </div>
											</div>


											<!-- Modal -->
											<div id="tidak_<?php echo $rw->id_visit ?>" class="modal fade" role="dialog">
											  <div class="modal-dialog">

											    <!-- Modal content-->
											    <div class="modal-content">
											      <div class="modal-header">
											        <button type="button" class="close" data-dismiss="modal">&times;</button>
											        <h4 class="modal-title">Yakin Akan simpan ini ?</h4>
											      </div>
											      <div class="modal-body">
											        <form action="app/simpan_form_visit/<?php echo $rw->id_visit.'/'.$this->uri->segment(3).'/'.$id_user ?>" method="post" enctype="multipart/form-data">
											        	<input type="hidden" name="pilihan" value="0">
											        	<label>Foto</label>
											        	<input type="file" name="foto" class="form-control">
											        	<label>Keterangan</label>
											        	<textarea class="form-control" rows="3" name="ket" required=""></textarea>
											        	<button type="submit" class="btn btn-success btn-block">SIMPAN</button>
											        </form>
											      </div>
											      <div class="modal-footer">
											        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											      </div>
											    </div>

											  </div>
											</div>

										</td>
										
									</tr>
					  			<?php endforeach ?>
								
							</table>
							
					  </div>
					</div>

				</div>
			</div>


			<?php endforeach ?>
			<a href="app/selesai_visit_outlet/<?php echo get_data('user','id_user',$id_user,'approve').'/'.$id_user.'/'.$dt->group_visit.'/'.$dt->id_outlet; ?>" class="btn btn-warning">SELESAI</a>

		<?php } ?>

		  </div>
	</div>
</div>
<?php } ?>