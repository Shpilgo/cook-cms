<section>
	<h2><?=lang('header_order')?></h2>
	<p class="alert alert-info"><?=lang('order_info')?></p>
	<div id="message" class="" style="display: none;"></div>
	<div id="orderResult"></div>
	<?=form_submit(array('class' => 'btn btn-primary', 'id' => 'save', 'value' => lang('btn_save')))?>
</section>

<script>
$(function() {
	$.post('<?=site_url('admin/page/order_ajax')?>', {}, function(data){
		$('#orderResult').html(data);
	});
	
	$(document).on('click', '#save', function(e) {
		e.preventDefault();
		var oSortable = $('.sortable').nestedSortable('toArray');
		$('#orderResult').html('');
		$.post('<?=site_url('admin/page/order_ajax')?>', { sortable: oSortable }, function(data){
			$('#orderResult').html(data);
			var atr = {};
			atr.message = '<?=lang('status_success')?>';
			atr.type = 'success';
			make_message(atr);
		});
	});
});
</script>