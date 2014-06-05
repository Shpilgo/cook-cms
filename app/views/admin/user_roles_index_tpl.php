<section>
	<h2><?=lang('header')?></h2>
	<?=btn_add('admin/'.$c_name.'/edit/', lang('btn_add'))?>
	<table class="table table-striped">
		<thead>
			<tr>
				<th><?=lang('name')?></th>
				<th width="120px"><?=lang('status')?></th>
				<th width="120px"></th>
			</tr>
		</thead>
		<tbody>
			<? if (count($items)): ?>
			<? foreach($items as $item): ?>
			<tr>
				<td><?=$item->name?></td>
				<td><?=status_buttons($c_name, $item->status, $item->id)?></td>
				<td><?=btn_edit('admin/'.$c_name.'/edit/'.$item->id)?> <?=btn_delete('admin/'.$c_name.'/delete/'.$item->id)?></td>
			</tr>
			<? endforeach; ?>
			<? else: ?>
			<tr>
				<td colspan="3"><?=lang('no_results')?></td>
			</tr>
			<? endif; ?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="3"><?=$paging?></td>
			</tr>
		</tfoot>
	</table>
</section>

<?$this->load->view('admin/components/status_script')?>