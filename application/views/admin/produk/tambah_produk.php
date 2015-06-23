<div class="container">
		<div class="row">
			<div class="span12">
				<h1>Tambah Produk</h1><br />
				<div class="row">
				<!--sidebar menu -->
					<?php echo $this->load->view('template/admin/sidebar'); ?>
					<!--end sidebar menu -->	
					<!-- form, content, etc -->
					<div class="span9">
						<div class=""><!-- basic tabs menu -->
							<ul class="nav nav-tabs">
								<li ><a href="<?php echo base_url(); ?>administrator/produk/">Daftar Produk</a></li>
								<li class="active"><a href="<?php echo base_url(); ?>administrator/tambah_produk/">Tambah Produk</a></li>
								<li><a href="<?php echo base_url(); ?>administrator/kategori_produk/">Kategori Produk</a></li>
							</ul>
						</div><!-- basic tabs menu -->
						
						<div class="well"><!-- div well & form -->
							<form class="form-horizontal" action="<?php echo base_url(); ?>administrator/submit_tambah_produk" method="POST" enctype="multipart/form-data">
							<fieldset>
							<?php if(form_error('nama_produk') == FALSE){ ?>
									<div class="control-group"><!-- default input text -->
							<?php }else{ ?>
									<div class="control-group warning"><!-- warning -->
							<?php } ?>
								<label class="control-label" for="input01">Nama Produk</label>
								<div class="controls">
								<input placeholder="Ketik nama produk.." name="nama_produk" type="text" class="input" id="input01" value="<?php echo set_value('nama_produk'); ?>">
								<span class="help-inline"><?php echo form_error('nama_produk'); ?></span>
								</div>
								</div><!-- default input text -->
							<?php if(form_error('deskripsi') == FALSE) { ?>
								<div class="control-group"><!-- default input text -->
							<?php }else{ ?>
								<div class="control-group warning"><!-- warning -->
							<?php } ?>
									<label class="control-label" for="input02">Deksripsi</label>
									<div class="controls">
										<!-- start ini untuk wysi rich text editor -->
										<textarea placeholder="Masukan deskripsi produk.." name="deskripsi" style="width: 440px; height:340px;  rows="50" id="some-textarea"><?php echo set_value('deskripsi'); ?></textarea>
										<!-- end ini untuk wysi rich text editor -->	
										<span class="help-inline"><?php echo form_error('deskripsi'); ?></span>
									</div>
								</div><!-- default input text -->
								<div class="control-group"><!-- select option -->
									<label class="control-label" for="select01">Kategori</label>
									<div class="controls">
									  <select name="id_kategori" id="select01">
										<option value="">Pilih...</option>
										<?php foreach($kategori->result() as $row){ ?>
										<option value="<?php echo $row->id; ?>"<?php echo set_select('id_kategori', $row->id, (!empty($data) && $data == $row->id ? TRUE : FALSE )) ?>><?php echo ucwords($row->nama_kategori); ?></option>
										<?php } ?>
									  </select>
									 <span class="help-inline"><?php echo form_error('id_kategori'); ?></span>	
									</div>
								</div><!-- select option -->
								<div class="control-group"><!-- default input text -->
									<label class="control-label" for="input01">Gambar Produk</label>
									<div class="controls">
									<div class="alert alert-info">  
										<a class="close" data-dismiss="alert">x</a>  
										<strong>Info! </strong><br/>
										Gambar optimal pada resolusi 800x400 px<br/>
										Ukuran Maksimum file 1 MB, (disarankan ukuran dibawah 100kb)<br/>
										File yang diizinkan untuk upload .jpg, .jpeg, .png, .gif
									</div>
										<input type="file" class="input" id="input01" name="gambar_produk">
										 <span class="help-inline"><?php echo $error; ?></span>
									</div>
								</div><!-- default input text -->
							</fieldset>
								<div class="form-actions"><!-- button action -->
									<button type="submit" class="btn btn-primary">Simpan</button>
									<button class="btn">Batal</button>
								</div>
							</form>
						</div><!-- div without well class & form -->
						
					</div>
					<!-- form, content, etc -->
				</div>
			</div>
		</div>