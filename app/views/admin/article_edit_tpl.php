<section>
	<h2><?=$header?></h2>
	<?=((isset($message)) ? $message : '')?>
	<? if (count($item)): ?>
	<?=form_open('', array('enctype' => 'multipart/form-data'))?>
		<div class="input-group">
			<span class="input-group-addon" style="min-width: 150px;"><?=lang('pub_date')?></span>
			<?=form_input(array('class' => 'form-control datepicker', 'name' => 'pubdate', 'value' => $item->pubdate))?>
		</div>
		<br>
		<div class="input-group">
			<span class="input-group-addon" style="min-width: 150px;"><?=lang('title')?></span>
			<?=form_input(array('class' => 'form-control', 'name' => 'title', 'value' => $item->title))?>
		</div>
		<br>
		<div class="input-group">
			<span class="input-group-addon" style="min-width: 150px;"><?=lang('slug')?></span>
			<?=form_input(array('class' => 'form-control', 'name' => 'slug', 'value' => $item->slug))?>
		</div>
		<br>
		<div class="input-group">
			<span class="input-group-addon" style="min-width: 150px;"><?=lang('body')?></span>
			<?=form_textarea(array('class' => 'form-control tinymce', 'name' => 'body', 'value' => $item->body))?>
		</div>
		<br>
		<div class="input-group">
			<span class="input-group-addon" style="min-width: 150px;"><?=lang('add_image')?></span>
			<?=form_upload(array('class' => 'form-control', 'name' => 'images[]', 'accept' => 'image/jpeg,image/png,image/gif', 'multiple' => 'true'))?>
		</div>
		<br>
		<?=form_submit(array('class' => 'btn btn-primary', 'value' => lang('btn_save')))?> <?=btn_cancel('admin/'.$c_name, lang('btn_cancel'))?>
	<?=form_close()?>
	<? endif; ?>
</section>
<section class="img-list">
	<? if (count($item) && isset($item->images) && count($item->images)): ?>
		<? foreach ($item->images as $image): ?>
		<div class="img-list-block">
			<img src="/images/thumbs/small/<?=$image->file_name?>.<?=$image->ext?>" class="img-thumbnail img-ajax-loader img-small">
			<a href="#" class="btn btn-sm btn-danger img-remove click-remove-image" data-id="<?=$item->id?>" data-type="<?=$c_name?>" data-image-id="<?=$image->image_id?>"><i class="glyphicon glyphicon-remove"></i></a>
		</div>
		<? endforeach; ?>
	<? endif; ?>
</section>