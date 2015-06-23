<div class="container">
		<div class="row">
			<div class="span12">
				<h1>Edit Kategori</h1><br />
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
								<li ><a href="<?php echo base_url(); ?>administrator/produk/">Daftar Produk</a></li>
								<li><a href="<?php echo base_url(); ?>administrator/tambah_produk/">Tambah Produk</a></li>
								<li ><a href="<?php echo base_url(); ?>administrator/kategori_produk/">Kategori Produk</a></li>
								<li class="active"><a href="<?php echo base_url(); ?>administrator/edit_kategori_produk/<?php echo $edit_kategori->id; ?>">Edit Kategori Produk</a></li>
							</ul>
						</div><!-- basic tabs menu -->
						<h5>Tambahkan Lagi Kategori Produk</h5>
							<div class="well"><!-- div well & form -->
							<form class="form-horizontal" action="<?php echo base_url(); ?>administrator/submit_edit_kategori_produk" method="POST">
							<fieldset>
							<?php if(form_error('nama_kategori') == FALSE){ ?>
									<div class="control-group"><!-- default input text -->
							<?php }else{ ?>
									<div class="control-group warning"><!-- warning -->
							<?php } ?>
								<label class="control-label" for="input01">Nama Kategori</label>
								<div class="controls">
								<input placeholder="Nama Kategori" name="nama_kategori" type="text" class="input" id="input01" value="<?php echo $edit_kategori->nama_kategori; ?>">
								<input name="id" type="hidden" value="<?php echo $edit_kategori->id; ?>">
								<span class="help-inline"><?php echo form_error('nama_kategori'); ?></span>
								</div>
								</div><!-- default input text -->
							
								
							</fieldset>
								<div class="form-actions"><!-- button action -->
									<button type="submit" class="btn btn-primary">Edit</button>
									<button class="btn">Batal</button>
								</div>
							</form>
						</div><!-- div without well class & form -->	
						
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
		