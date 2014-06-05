<section>
	<h2><?=lang('header')?></h2>
	<div id="message" class="" style="display: none;"></div>
	<table class="table table-striped">
		<? if (count($roles) && count($functionals)): ?>
		<?=form_open('', array('id' => 'role_functional'))?>
		<thead>
			<tr>
				<th></th>
				<? foreach($functionals as $functional): ?>
				<th class="table-functional-header"><p class="text-rotate"><?=$functional->name?></p></th>
				<? endforeach; ?>
				<th style="width: 70px;"></th>
			</tr>
		</thead>
		<tbody>
			<? foreach($roles as $role): ?>
			<tr>
				<td><?=$role->name?></td>
				<? foreach($functionals as $functional): ?>
				<td style="text-align: center;"><?=form_checkbox(array('class' => 'role-functional', 'data-role-id' => $role->id, 'data-functional-id' => $functional->id, 'value' => '', 'checked' => (isset($role_functional[$role->id][$functional->id])) ? 'checked' : ''))?></td>
				<? endforeach; ?>
				<td>
					<button type="button" class="btn btn-default btn-xs click-role-functional-all"><i class="glyphicon glyphicon-ok"></i></button>
					<button type="button" class="btn btn-default btn-xs click-role-functional-none"><i class="glyphicon glyphicon-remove"></i></button>
				</td>
			</tr>
			<? endforeach; ?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="<?=(count($functionals) + 2)?>"><?=form_submit(array('class' => 'btn btn-primary click-role-functional', 'value' => 'Save'))?></td>
			</tr>
		</tfoot>
		<?=form_close()?>
		<? else: ?>
		<tbody>
			<tr>
				<td><?=lang('no_results')?></td>
			</tr>
		</tbody>
		<? endif; ?>
	</table>
</section>

<script>
$(function() {
	
	$('.click-role-functional').on('click',function(e) {
		e.preventDefault();
		var functional_user_role = [];
		$.each($('.role-functional'), function( key, value ) {
			if ($(value).prop('checked')) {
				functional_user_role.push({
					functional_id: $(value).attr('data-functional-id'),
					user_role_id: $(value).attr('data-role-id')
				});
			}
		});
		$.post( '/admin/'+c_name+'/ajax', {
			functional_user_role: functional_user_role
		}, function(data) {
			if (data.status == 'success') {
				var atr = {};
				atr.message = '<?=lang('status_success')?>';
				atr.type = 'success';
				make_message(atr);
			} else {
				var atr = {};
				atr.message = '<?=lang('status_error')?>';
				atr.type = 'danger';
				make_message(atr);
			}
		}, "json");
	});
	
	$(document).on('click', '.click-role-functional-all', function(e) {
		e.preventDefault();
		$(this).parents('tr').children().find('input[type="checkbox"]').prop('checked', 'checked');
	});
	
	$(document).on('click', '.click-role-functional-none', function(e) {
		e.preventDefault();
		$(this).parents('tr').children().find('input[type="checkbox"]').prop('checked', '');
	});
	
});
</script>

<?$this->load->view('admin/components/status_script')?>