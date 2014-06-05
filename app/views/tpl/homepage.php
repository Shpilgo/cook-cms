<div class="col-xs-9">
	<div class="row">
		<div class="col-xs-12"><? if (isset($articles[0])) echo get_excerpt($articles[0]) ?></div>
		<div class="col-xs-8"><? if (isset($articles[1])) echo get_excerpt($articles[1]) ?></div>
		<div class="col-xs-4"><? if (isset($articles[2])) echo get_excerpt($articles[2]) ?></div>
	</div>
</div>
<? $this->load->view('components/page_sidebar'); ?>