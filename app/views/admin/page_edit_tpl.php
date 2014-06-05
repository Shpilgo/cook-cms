<section>
	<h2><?=$header?></h2>
	<?=((isset($message)) ? $message : '')?>
	<? if (count($item)): ?>
	<?=form_open()?>
		<div class="input-group">
			<span class="input-group-addon" style="min-width: 150px;"><?=lang('parent')?></span>
			<?=form_dropdown('parent_id', $pages_no_parents, $this->input->post('parent_id') ? $this->input->post('parent_id') : $item->parent_id, 'class="form-control"')?>
		</div>
		<br>
		<div class="input-group">
			<span class="input-group-addon" style="min-width: 150px;"><?=lang('template')?></span>
			<?=form_dropdown('template', $templates_list, $this->input->post('template') ? $this->input->post('template') : $item->template, 'class="form-control"')?>
		</div>
		<br>
		<div class="input-group">
			<span class="input-group-addon" style="min-width: 150px;"><?=lang('title')?></span>
			<?=form_input(array('class' => 'form-control', 'name' => 'title', 'value' => $item->title, 'id' => 'to_link'))?>
		</div>
		<br>
		<div class="input-group">
			<span class="input-group-addon" style="min-width: 150px;"><?=lang('slug')?></span>
			<?=form_input(array('class' => 'form-control', 'name' => 'slug', 'value' => $item->slug, 'id' => 'link'))?>
		</div>
		<br>
		<div class="input-group">
			<span class="input-group-addon" style="min-width: 150px;"><?=lang('body')?></span>
			<?=form_textarea(array('class' => 'form-control tinymce', 'name' => 'body', 'value' => $item->body))?>
		</div>
		<br>
		<?=form_submit(array('class' => 'btn btn-primary', 'value' => lang('btn_save')))?> <?=btn_cancel('admin/'.$c_name, lang('btn_cancel'))?>
	<?=form_close()?>
	<? endif; ?>
</section>