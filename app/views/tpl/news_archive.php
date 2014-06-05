<div class="col-xs-9">
	<div class="row">
		<? if ($pagination): ?>
		<section class="col-xs-12"><?=$pagination?></section>
		<? endif; ?>
		<? if (count($articles)): ?>
		<? foreach($articles as $article): ?>
		<article class="col-xs-12">
			<?=get_excerpt($article)?>
		</article>
		<? endforeach; ?>
		<? else: ?>
		<div class="col-xs-12">We could not find any articles.</div>
		<? endif; ?>
	</div>
</div>
<? $this->load->view('components/page_sidebar'); ?>