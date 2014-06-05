<?$this->load->view('components/page_header')?>
<div class="container">
	<div class="row">
		<div class="col-xs-12">
			<br>
		</div>
		<!--<div class="col-xs-12">
			<a class="brand" href="<?/*=site_url('/')*/?>"><img src=""></a>
		</div>-->
		<div class="col-xs-12">
			<br>
		</div>
	</div>
	<nav class="navbar navbar-default" role="navigation">
		<div class="container-fluid">
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<?=get_menu($menu)?>
			</div>
		</div>
	</nav>
	<div class="row">
		<?=$this->load->view('tpl/'.$subview);?>
	</div>
</div>	
<?$this->load->view('components/page_footer')?>