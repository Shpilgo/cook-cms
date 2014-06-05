<section>
	<h2><?=lang('header')?></h2>
	<?=btn_add('admin/'.$c_name.'/edit/', lang('btn_add'))?>
	<table class="table table-striped">
		<thead>
			<tr>
				<th><?=lang('title')?></th>
				<th><?=lang('pub_date')?></th>
				<th width="105px"></th>
			</tr>
		</thead>
		<tbody>
			<? if (count($items)): ?>
			<? foreach($items as $item): ?>
			<tr>
				<td><?=anchor('admin/'.$c_name.'/edit/'.$item->id, $item->title)?></td>
				<td><?=$item->pubdate?></td>
				<td><?=btn_edit('admin/'.$c_name.'/edit/'.$item->id)?> <?=btn_delete('admin/'.$c_name.'/delete/'.$item->id)?></td>
			</tr>
			<? endforeach; ?>
			<tr><td colspan="3"><?=$paging?></td></tr>
			<? else: ?>
			<tr>
				<td colspan="3"><?=lang('no_results')?></td>
			</tr>
			<? endif; ?>
		</tbody>
	</table>
</section>