<?$this->load->view('admin/components/page_header')?>
	<nav class="navbar navbar-inverse" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="<?=site_url('/')?>"><?=$meta_title?></a>
			</div>
			<?=get_admin_menu($menu)?>
			<ul class="nav navbar-nav navbar-right">
				<? if ($this->session->userdata('id') == 1): ?>
				<li><?=anchor('admin/functional', 'functional')?></li>
				<? endif; ?>
				<li><?=anchor('admin/home', '<i class="glyphicon glyphicon-user"></i> '.$this->session->userdata('name'))?></li>
				<li><?=anchor('admin/user/logout', '<i class="glyphicon glyphicon-off"></i> '.lang('logout'))?></li>
			</ul>
		</div>
	</nav>
	
	<div class="container">
		<?=get_admin_breadcrumb($page)?>
		<? $this->load->view($subview) ?>
	</div>
<?$this->load->view('admin/components/page_footer')?>