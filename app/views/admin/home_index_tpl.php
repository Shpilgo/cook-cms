<section>
	<? if ($this->session->userdata('id') == 1): ?>
	<h2><?=lang('migration')?></h2>
	<p class="alert alert-<?=$migration_alert?>"><?=$migration_message?></p>
	<? endif; ?>
	<? if (count($currency_rates)): ?>
	<h2><?=lang('currencies')?></h2>
	<? foreach($currency_rates as $rate): ?>
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"><?=$rate['currency']?><span class="pull-right"><?=date('Y-m-d H:i:s',$rate['created'])?></span></h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-4">
						<div class="panel panel-info">
							<div class="panel-heading">
								<h3 class="panel-title"><?=lang('average')?></h3>
							</div>
							<div class="panel-body">
								<p><?=lang('ask')?>: <?=$rate['ask_average']?></p>
								<p><?=lang('bid')?>: <?=$rate['bid_average']?></p>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="panel panel-info">
							<div class="panel-heading">
								<h3 class="panel-title"><?=lang('ask_min')?></h3>
							</div>
							<div class="panel-body">
								<p><?=lang('ask')?>: <?=$rate['ask_min']?></p>
								<p><?=lang('bank')?>: <?=$rate['ask_min_bank']?></p>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="panel panel-info">
							<div class="panel-heading">
								<h3 class="panel-title"><?=lang('bid_max')?></h3>
							</div>
							<div class="panel-body">
								<p><?=lang('bid')?>: <?=$rate['bid_max']?></p>
								<p><?=lang('bank')?>: <?=$rate['bid_max_bank']?></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	<? endforeach; ?>
	<? endif; ?>
</section>