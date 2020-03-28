<?php 
$h = $d_visit->row();
// log_r($h);
 ?>
<div class="row">
	<div class="col-md-12">
		<table class="table">
			<tr>
				<td>Outlet</td>
				<td>:</td>
				<td>
					<?php echo get_data('outlet','id_outlet',$h->id_outlet,'outlet') ?>
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
		  			$id_user = $this->session->userdata('id_user');
		  			$detail = $this->db->query("SELECT * FROM visit as va, check_detail as cd where cd.id=va.id_detail_check and cd.id_check='$bd->id_check' and va.id_visit_outlet='$h->id_visit_outlet' ");
		  			// log_r($this->db->last_query());
		  			foreach ($detail->result() as $rw): 
		  				if ($rw->pilihan_check == 1) {
		  					$ya = 'checked';
		  					$tidak = '';
		  				} elseif ($rw->pilihan_check == 0 and $rw->pilihan_check != '') {
		  					$tidak = 'checked';
		  					$ya = '';
		  				} elseif ($rw->pilihan_check == '') {
		  					$tidak = '';
		  					$ya = '';
		  				}
		  				?>
		  				<tr>
							<td><?php echo $rw->detail ?></td>
							<td>:</td>
							<td>
								<label><input type="radio" name="pilihan_<?php echo $rw->id_detail_check ?>"  value="1"data-toggle="modal" data-target="#ya_<?php echo $rw->id_detail_check ?>" <?php echo $ya ?>> Ya </label>					
								<label><input type="radio" name="pilihan_<?php echo $rw->id_detail_check ?>"  value="0"data-toggle="modal" data-target="#tidak_<?php echo $rw->id_detail_check ?>" <?php echo $tidak ?>> Tidak</label>	
								&nbsp;&nbsp;&nbsp;&nbsp;
								<?php if ($rw->foto != '' && $rw->pilihan_check == 0): ?>
									<a href="image/visit/<?php echo $rw->foto ?>" target="_blank">
										<img src="image/visit/<?php echo $rw->foto ?>" style="width: 100px;">
									</a>
								<?php endif ?>

								<!-- Modal -->
								<div id="ya_<?php echo $rw->id_detail_check ?>" class="modal fade" role="dialog">
								  <div class="modal-dialog">

								    <!-- Modal content-->
								    <div class="modal-content">
								      <div class="modal-header">
								        <button type="button" class="close" data-dismiss="modal">&times;</button>
								        <h4 class="modal-title">Yakin Akan simpan ini ?</h4>
								      </div>
								      <div class="modal-body">
								        <form action="app/simpan_form_visit/<?php echo $rw->id_detail_check.'/'.$this->uri->segment(3) ?>" method="post">
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
								<div id="tidak_<?php echo $rw->id_detail_check ?>" class="modal fade" role="dialog">
								  <div class="modal-dialog">

								    <!-- Modal content-->
								    <div class="modal-content">
								      <div class="modal-header">
								        <button type="button" class="close" data-dismiss="modal">&times;</button>
								        <h4 class="modal-title">Yakin Akan simpan ini ?</h4>
								      </div>
								      <div class="modal-body">
								        <form action="app/simpan_form_visit/<?php echo $rw->id_detail_check.'/'.$this->uri->segment(3) ?>" method="post" enctype="multipart/form-data">
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

<a href="app/selesai_visit_outlet/<?php echo $this->uri->segment(3) ?>" class="btn btn-warning">SELESAI</a>