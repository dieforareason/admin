<div class="container">
		<div class="row">
			<div class="span12">
				<h1>Profil</h1><br />
				<div class="row">
				<!--sidebar menu -->
					<?php echo $this->load->view('template/admin/sidebar'); ?>
					<!--end sidebar menu -->	
					<!-- form, content, etc -->
					<div class="span9">
						<div class=""><!-- basic tabs menu -->
							<ul class="nav nav-tabs">
							<?php 
							foreach($menuprofil as $row) {  
							if($this->uri->segment(3) == ($row->kategori_profil) || $this->uri->segment(4) == ($row->kategori_profil)){
							?>
								<li class="active">
							<?php }else{ ?>
								<li >
							<?php } ?>
								<a href="<?php echo base_url(); ?>administrator/profil/<?php echo $row->kategori_profil; ?>"><?php echo ucwords($row->keterangan); ?></a></li>
							<?php }//endforeach ?>
							</ul>
						</div><!-- basic tabs menu -->
						<?php if($this->session->flashdata('info')) { ?>
							<div class="alert alert-info">  
									<a class="close" data-dismiss="alert">x</a>  
									<strong>Info! </strong><?php echo $this->session->flashdata('info'); ?>  
							</div>
						<?php } ?>
						<div class="well"><!-- div well & form -->
							<form class="form-horizontal" action="<?php echo base_url(); ?>administrator/submit_edit_profil/<?php echo $profil->kategori_profil; ?>" method="POST" enctype="multipart/form-data">
							<fieldset>
							<?php if(form_error('deskripsi') == FALSE) { ?>
								<div class="control-group"><!-- default input text -->
							<?php }else{ ?>
								<div class="control-group warning"><!-- warning -->
							<?php } ?>
									<label class="control-label" for="input02">Deksripsi <?php echo ucwords($profil->keterangan); ?></label>
									<div class="controls">
										<!-- start ini untuk wysi rich text editor -->
										<input type="hidden" name="id" value="<?php echo $profil->id; ?>">
										<input type="hidden" name="kategori_profil" value="<?php echo $profil->kategori_profil; ?>">
										<textarea name="deskripsi" style="width: 440px; height:340px; " cols="20" id="some-textarea"><?php echo $profil->deskripsi; ?></textarea>
										<!-- end ini untuk wysi rich text editor -->	
										<span class="help-inline"><?php echo form_error('deskripsi'); ?></span>
									</div>
								</div><!-- default input text -->
							</fieldset>
								<div class="form-actions"><!-- button action -->
									<button type="submit" class="btn btn-primary">Simpan</button>
								</div>
							</form>
						</div><!-- div without well class & form -->
						
					</div>
					<!-- form, content, etc -->
				</div>
			</div>
		</div>