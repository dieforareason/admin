<div class="container">
		<div class="row">
			<div class="span12">
				<h1>Daftar Banner</h1><br />
				<div class="row">
					<!--sidebar menu -->
					<?php echo $this->load->view('template/admin/sidebar'); ?>
					<!--end sidebar menu -->
					<!-- table, content, etc -->
					<div class="span9">
						<div class=""><!-- basic tabs menu -->
							<ul class="nav nav-tabs">
								<li class="active"><a href="<?php echo base_url(); ?>administrator/banner/">Daftar Banner</a></li>
							</ul>
						</div><!-- basic tabs menu -->
						<h5>Tambahkan Lagi Banner</h5>
							<div class="well"><!-- div well & form -->
							<form class="form-horizontal" action="<?php echo base_url(); ?>administrator/submit_tambah_banner" method="POST" enctype="multipart/form-data">
							<fieldset>
								<div class="control-group"><!-- default input text -->
									<label class="control-label" for="input01">Gambar Banner</label>
									<div class="controls">
										<input type="file" class="input" id="input01" name="gambar_banner">
										<?php echo $error; ?>
									</div>
									
								</div><!-- default input text -->
							</fieldset>
								<div class="form-actions"><!-- button action -->
									<button type="submit" class="btn btn-primary">Tambah</button>
									<button type="reset" class="btn">Reset</button>
								</div>
							</form>
						</div><!-- div without well class & form -->
						<?php if($this->session->flashdata('info')) { ?>
							<div class="alert alert-info">  
									<a class="close" data-dismiss="alert">x</a>  
									<strong>Info! </strong><?php echo $this->session->flashdata('info'); ?>  
							</div>
						<?php } ?>						
						<h5>Daftar Banner, diurutkan berdasarkan data dimutahirkan.</h5><br />
							<table class="table table-striped table-bordered"><!-- table default style -->
								<thead>
									<th>No</th>
									<th>Gambar</th>
									<th>Status</th>
									<th>Aksi</th>
								</thead>
								<tr>
								<?php $no=1; 
									foreach($banner->result() as $row){ 
								?>
									<td><?php echo $no; ?></td>
									<td>
										<!--mulai div modal untuk tampilkan gambar penuh -->
										<div id="example<?php echo $no;?>" class="modal hide fade in"  > 
											
										<div class="modal-header">  
											<a class="close" data-dismiss="modal">x</a>  
											<h4>Gambar lebih besar</h4>  
										</div>  
										<div class="modal-body">  
											<img src="<?php echo base_url(); ?>upload/banner/<?php echo $row->file_name; ?>" alt="">          
										</div>  
										<div class="modal-footer">    
											<a href="#" class="btn" data-dismiss="modal">Close</a>  
										</div> 
										
										</div>
										<!--end div modal untuk tampilkan gambar penuh -->
										<a href="">
											<img  width="220px" src="<?php echo base_url(); ?>upload/banner/<?php echo $row->file_name; ?>" alt="">
										<!-- panggil modal -->
										<p><a data-toggle="modal" href="#example<?php echo $no;?>" class="btn btn-primary btn-small">Lebih besar</a></p>  
										<!-- end panggil modal -->
										</a>
									</td>
									<td>
										<?php if($row->status == TRUE){ ?>
										Tampil<br/>
										<a title="Ubah jadi sembunyi" href="<?php echo base_url(); ?>administrator/edit_status_banner/<?php echo $row->id;?>/<?php echo $row->status; ?>">Ubah jadi sembunyi)</a>
										<?php }else{ ?>
										Sembunyi<br/>
											<a title="Ubah jadi tampil" href="<?php echo base_url(); ?>administrator/edit_status_banner/<?php echo $row->id;?>/<?php echo $row->status; ?>">(Ubah jadi tampil)</a>
										<?php } ?>
									</td>
									<td>
										<a href="#" onClick="if(confirm('Anda yakin HAPUS data ini? ')){document.location='<?php echo base_url()?>administrator/hapus_banner/<?php echo $row->id; ?>'}" title="Hapus Banner" >
											<i class="icon-trash"></i> Delete
										</a>
									</td>
								</tr>
							<?php 
								$no++;
								} 
							?>
							</table><!-- table default style -->
								
							<div class="pagination">
								<ul>
									<?php echo $this->pagination->create_links(); ?>
								</ul>
							</div>
								
					</div>
					<!-- table, content, etc -->
				</div>
				
				<div class="row">
				
				</div>
				
			</div>
		</div>
		