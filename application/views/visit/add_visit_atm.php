<?php 
$h = $d_visit->row();
// log_r($h);
 ?>
<div class="row">
	<div class="col-md-12">
		<table class="table">
			<tr>
				<td>ID ATM</td>
				<td>:</td>
				<td>
					<?php echo $h->no_id ?>
				</td>
			</tr>
			<tr>
				<td>Nama ATM</td>
				<td>:</td>
				<td>
					<?php echo get_data('atm','no_id',$h->no_id,'nama_atm') ?>
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
$this->db->where('id_check', 3);
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
		  			$detail = $this->db->query("SELECT * FROM visit_atm as va, check_detail as cd where cd.id=va.id_detail_check and cd.id_check=3 and va.id_visit_atm='$h->id_visit_atm' ");

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
								        <form action="app/simpan_form_visit_atm/<?php echo $rw->id_detail_check.'/'.$rw->id_visit_atm ?>" method="post">
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
								        <form action="app/simpan_form_visit_atm/<?php echo $rw->id_detail_check.'/'.$rw->id_visit_atm ?>" method="post">
								        	<input type="hidden" name="pilihan" value="0">
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


<div class="row">
	<div class="col-md-12">
		<div class="panel panel-info">
		  <div class="panel-heading">Foto ATM</div>
		  <div class="panel-body">
		  	<form action="app/simpan_foto_atm/<?php echo $this->uri->segment(3) ?>" method="POST" enctype="multipart/form-data">
			
			<div class="form-group">
				<label>Foto Dalam</label>
				<input type="file" name="foto1" class="form-control" >
				<?php 
				if ($h->foto1 == '') {
					echo "*) <i>Tidak ada foto</i>";
				} else {
				 ?>
				<p>*) Foto Sebelumnya :</p>
				<img src="image/visit/<?php echo $h->foto1 ?>" style="width: 100px;">
				<?php } ?>
			</div>

			<div class="form-group">
				<label>Keterangan</label>
				<textarea class="form-control" name="ket1" required=""><?php echo $retVal = ($h->ket1 != '') ? $h->ket1 : '' ; ?></textarea>
			</div>

			<div class="form-group">
				<label>Foto Luar</label>
				<input type="file" name="foto2" class="form-control" >
				<?php 
				if ($h->foto2 == '') {
					echo "*) <i>Tidak ada foto</i>";
				} else {
				 ?>
				<p>*) Foto Sebelumnya :</p>
				<img src="image/visit/<?php echo $h->foto2 ?>" style="width: 100px;">
				<?php } ?>
			</div>

			<div class="form-group">
				<label>Keterangan</label>
				<textarea class="form-control" name="ket2" required=""><?php echo $retVal = ($h->ket2 != '') ? $h->ket2 : '' ; ?></textarea>
			</div>

			<div class="form-group">
				<button type="submit" class="btn btn-info">Simpan</button>
			</div>
			</form>
		  </div>
	</div>
</div>

<a href="app/selesai_visit_atm/<?php echo $this->uri->segment(3) ?>" class="btn btn-warning">SELESAI</a>