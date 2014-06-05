<section>
	<h2><?=$header?></h2>
	<?=((isset($message)) ? $message : '')?>
	<?=form_open()?>
		<div class="input-group">
			<span class="input-group-addon" style="min-width: 150px;"><?=lang('name')?></span>
			<?=form_input(array('class' => 'form-control', 'name' => 'name', 'value' => $item->name))?>
		</div>
		<br>
		<?=form_submit(array('class' => 'btn btn-success', 'value' => lang('btn_save')))?> <?=btn_cancel('admin/'.$c_name, lang('btn_cancel'))?>
	<?=form_close()?>
</section>