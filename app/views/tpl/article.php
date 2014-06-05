<div class="col-xs-9">
	<div class="row">
		<div class="col-xs-12">
			<h2><?=$article->title?></h2>
			<p class="pubdate"><?=$article->pubdate?></p>
			<?=$article->body?>
		</div>
	</div>
</div>
<? $this->load->view('components/page_sidebar'); ?>