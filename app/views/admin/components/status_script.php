<script type="text/javascript">
$(document).ready(function(){
	
	$(document).on('click', '.click-'+c_name+'-not-active, .click-'+c_name+'-active', function() {
		var id = $(this).attr('data-id');
		if ($(this).hasClass('click-'+c_name+'-active')) {
			$(this).parent().children('.'+c_name+'-active').removeClass('btn-default').addClass('btn-success').removeClass('click-'+c_name+'-active').addClass('disabled');
			$(this).parent().children('.'+c_name+'-not-active').removeClass('btn-danger').addClass('btn-default').removeClass('disabled').addClass('click-'+c_name+'-not-active');
			$.post( '/admin/'+c_name+'/ajax/'+id, { status: 1 }, function( data ) {
				// console.log('active');
			}, "json");
		} else {
			$(this).parent().children('.'+c_name+'-active').removeClass('btn-success').addClass('btn-default').removeClass('disabled').addClass('click-'+c_name+'-active');
			$(this).parent().children('.'+c_name+'-not-active').removeClass('btn-default').addClass('btn-danger').removeClass('click-'+c_name+'-not-active').addClass('disabled');
			$.post( '/admin/'+c_name+'/ajax/'+id, { status: 0 }, function( data ) {
				// console.log('not active');
			}, "json");
		}
	});
	
});
</script>