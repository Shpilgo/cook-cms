<div class="modal-header">
	<h3>Login</h3>
</div>
<div class="modal-body">
	<?=($this->session->flashdata('error')) ? $this->session->flashdata('error') : ''?>
	<?=validation_errors()?>
	<?=form_open()?>
		<?=form_input(array('class' => 'form-control', 'id' => 'email', 'name' => 'email', 'placeholder' => 'email'))?>
		<br>
		<?=form_password(array('class' => 'form-control', 'id' => 'password', 'name' => 'password', 'placeholder' => 'password'))?>
		<br>
		<?=form_submit(array('class' => 'btn btn-primary btn-block', 'id' => 'submit', 'name' => 'submit', 'value' => 'Log in'))?>
	<?=form_close()?>
</div>