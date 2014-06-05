<section>
	<h2><?=$header?></h2>
	<?=((isset($message)) ? $message : '')?>
	<? if (count($item)): ?>
	<?=form_open()?>
		<div class="input-group">
			<span class="input-group-addon" style="min-width: 150px;"><?=lang('name')?></span>
			<?=form_input(array('class' => 'form-control', 'name' => 'name', 'value' => $item->name))?>
		</div>
		<br>
		<div class="input-group">
			<span class="input-group-addon" style="min-width: 150px;"><?=lang('role')?></span>
			<?=form_dropdown('role_id', $user_roles, $item->role_id, 'class="form-control"')?>
		</div>
		<br>
		<div class="input-group">
			<span class="input-group-addon" style="min-width: 150px;"><?=lang('email')?></span>
			<?=form_input(array('class' => 'form-control', 'name' => 'email', 'value' => $item->email))?>
		</div>
		<br>
		<div class="input-group">
			<span class="input-group-addon" style="min-width: 150px;"><?=lang('password')?></span>
			<?=form_password(array('class' => 'form-control', 'name' => 'password'))?>
		</div>
		<br>
		<div class="input-group">
			<span class="input-group-addon" style="min-width: 150px;"><?=lang('password_confirm')?></span>
			<?=form_password(array('class' => 'form-control', 'name' => 'password_confirm'))?>
		</div>
		<br>
		<?=form_submit(array('class' => 'btn btn-primary', 'value' => lang('btn_save')))?> <?=btn_cancel('admin/'.$c_name, lang('btn_cancel'))?>
	<?=form_close()?>
	<? endif; ?>
</section>