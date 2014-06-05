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
			<span class="input-group-addon" style="min-width: 150px;"><?=lang('link')?></span>
			<?=form_input(array('class' => 'form-control', 'name' => 'link', 'value' => $item->link))?>
		</div>
		<br>
		<div class="input-group">
			<span class="input-group-addon" style="min-width: 150px;"><?=lang('parent')?></span>
			<?=form_dropdown('parent_id', $parents, $item->parent_id, 'class="form-control"')?>
		</div>
		<br>
		<?=form_submit(array('class' => 'btn btn-primary', 'value' => lang('btn_save')))?> <?=btn_cancel('admin/'.$c_name, lang('btn_cancel'))?>
	<?=form_close()?>
	<? endif; ?>
</section>