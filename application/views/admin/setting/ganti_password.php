<?php
$old_password = array(
	'name'	=> 'old_password',
	'id'	=> 'old_password',
	'value' => set_value('old_password'),
	'size' 	=> 30,
	'class' => 'input-large',
	'placeholder' => 'password lama..'
);
$new_password = array(
	'name'	=> 'new_password',
	'id'	=> 'new_password',
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size'	=> 30,
	'class' => 'input-large',
	'placeholder' => 'password baru..'
);
$confirm_new_password = array(
	'name'	=> 'confirm_new_password',
	'id'	=> 'confirm_new_password',
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size' 	=> 30,
	'class' => 'input-large',
	'placeholder' => 'konfirmasi password baru..'
);
?>
<div class="container">
		<div class="row">
			<div class="span12">
				<h1>Ganti Password</h1><br />
				<div class="row">
				<!--sidebar menu -->
					<?php echo $this->load->view('template/admin/sidebar'); ?>
					<!--end sidebar menu -->	
					<!-- form, content, etc -->
					<div class="span9">
					<?php if($this->session->flashdata('info')) { ?>
						<div class="alert alert-info">  
								<a class="close" data-dismiss="alert">x</a>  
								<strong>Info! </strong><?php echo $this->session->flashdata('info'); ?>  
						</div>
					<?php } ?>
						
						<div class="well"><!-- div well & form -->
							<form class="form-horizontal" action="<?php echo base_url(); ?>administrator/ganti_password" method="POST" >
							<fieldset>
								<?php if(form_error('old_password') == FALSE) { ?>
									<div class="control-group"><!-- default input text -->
								<?php }else{ ?>
									<div class="control-group warning"><!-- warning -->
								<?php } ?>
									<label class="control-label" for="input02"><?php echo form_label('Password Lama', $old_password['id']); ?></label>
									<div class="controls">
										<?php echo form_password($old_password); ?>
										 <span class="help-inline"><?php echo form_error($old_password['name']); ?><?php echo isset($errors[$old_password['name']])?$errors[$old_password['name']]:''; ?></span>
									</div>
								</div><!-- default input text -->
								
								<?php if(form_error('new_password') == FALSE) { ?>
									<div class="control-group"><!-- default input text -->
								<?php }else{ ?>
									<div class="control-group warning"><!-- warning -->
								<?php } ?>
									<label class="control-label" for="input02"><?php echo form_label('Password Baru', $new_password['id']); ?></label>
									<div class="controls">
										<?php echo form_password($new_password); ?>
										 <span class="help-inline"><?php echo form_error($new_password['name']); ?><?php echo isset($errors[$new_password['name']])?$errors[$new_password['name']]:''; ?></span>
									</div>
								</div><!-- default input text -->
								
								<?php if(form_error('confirm_new_password') == FALSE) { ?>
									<div class="control-group"><!-- default input text -->
								<?php }else{ ?>
									<div class="control-group warning"><!-- warning -->
								<?php } ?>
									<label class="control-label" for="input02"><?php echo form_label('Konfirmasi Password Baru', $confirm_new_password['id']); ?></label>
									<div class="controls">
										<?php echo form_password($confirm_new_password); ?>
										 <span class="help-inline"><?php echo form_error($confirm_new_password['name']); ?><?php echo isset($errors[$confirm_new_password['name']])?$errors[$confirm_new_password['name']]:''; ?></span>
									</div>
								</div><!-- default input text -->
								
							</fieldset>
								<div class="form-actions"><!-- button action -->
									<button type="submit" class="btn btn-primary">Simpan</button>
									<button class="btn">Batal</button>
								</div>
							</fieldset>
							</form>
						</div><!-- div without well class & form -->
						
					</div>
					<!-- form, content, etc -->
				</div>
				
				<div class="row">
				
				</div>
				
			</div>
		</div>