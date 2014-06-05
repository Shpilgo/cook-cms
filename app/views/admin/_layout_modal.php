<?$this->load->view('admin/components/page_header')?>
<div class="modal show bs-modal-sm">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<? $this->load->view($subview) ?>
			<div class="modal-footer">
				&copy;  <?=date('Y')?> <?=$meta_title?>
			</div>
		</div>
	</div>
</div>
<?$this->load->view('admin/components/page_footer')?>