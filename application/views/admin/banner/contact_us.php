<div class="container">
		<div class="row">
			<div class="span12">
				<h1>Daftar Contact Us</h1><br />
				<div class="row">
					<!--sidebar menu -->
					<?php echo $this->load->view('template/admin/sidebar'); ?>
					<!--end sidebar menu -->
					<!-- table, content, etc -->
					<div class="span9">
						<div class=""><!-- basic tabs menu -->
						<?php if($this->session->flashdata('info')) { ?>
							<div class="alert alert-info">  
									<a class="close" data-dismiss="alert">x</a>  
									<strong>Info! </strong><?php echo $this->session->flashdata('info'); ?>  
							</div>
						<?php } ?>
							<ul class="nav nav-tabs">
								<li class="active"><a href="<?php echo base_url(); ?>administrator/contact_us/">Contact Us</a></li>
							</ul>
						</div><!-- basic tabs menu -->
						<h5>Daftar Contact, diurutkan berdasarkan data termutakhir.</h5><br />
						<h5>Semua Contact berjumlah sebanyak: <?php echo $count; ?> record(s).</h5><br />
						<a href="#" onClick="if(confirm('Anda yakin HAPUS SELURUH DATA Contact us? ')){document.location='<?php echo base_url()?>administrator/hapus_contact_all/'}" title="Hapus Seluruhnya." >
											<i class="icon-exclamation-sign"></i> 
											Hapus Seluruhnya
										</a>
							 <!-- CSS and JS for table fixed header -->
							<table id="mytable" class="table table-striped table-bordered table-fixed-header"><!-- table default style -->
								<thead class="header">
									<th>No</th>
									<th>Nama Pengirim</th>
									<th>Email</th>
									<th>Deskripsi</th>
									<th>Tanggal Pengiriman</th>
									<th>Aksi</th>
								</thead>
								<tbody>
								<tr>
								<?php $no=1; 
									foreach($contact_us->result() as $row){ 
								?>
									<td><?php echo $this->session->userdata('row')+$no; ?></td>
									<td><?php echo ucwords($row->nama_pengirim); ?></td>
									<td><?php echo $row->email; ?></td>
									
									<td>
										<!--mulai div modal untuk tampilkan gambar penuh -->
										<div id="example1<?php echo $no;?>" class="modal hide fade in"  > 
											
										<div class="modal-header">  
											<a class="close" data-dismiss="modal">x</a>  
											<h4>Deksripsi Selengkapnya</h4>  
										</div>  
										<div class="modal-body">  
											<?php echo $row->deskripsi; ?>
										</div>  
										<div class="modal-footer">    
											<a href="#" class="btn" data-dismiss="modal">Close</a>  
										</div> 
										
										</div>
										<!--end div modal untuk tampilkan gambar penuh -->
										
										<?php echo substr(($row->deskripsi),0,50); ?>...     	
										<!-- panggil modal -->
										<p><a data-toggle="modal" href="#example1<?php echo $no;?>" class="btn btn-primary btn-small">Selengkapnya</a></p>  
										<!-- end panggil modal -->
									</td>
									<td><?php echo $row->created_at; ?></td>
									<td>
										<a href="#" onClick="if(confirm('Anda yakin HAPUS data ini? ')){document.location='<?php echo base_url()?>administrator/hapus_contact/<?php echo $row->id; ?>'}" title="Hapus" >
											<i class="icon-trash"></i> Hapus
										</a> 
									</td>
								</tr>
								</tbody>
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
		