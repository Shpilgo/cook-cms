<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?=$meta_title?></title>
		<!-- Bootstrap -->
		<link href="/apis/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="/apis/datepicker/css/datepicker.css" rel="stylesheet">
		<link href="/css/styles-admin.css" rel="stylesheet">
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="/apis/jquery.js"></script>
		<script src="/apis/jquery.validate.min.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="/apis/bootstrap/js/bootstrap.min.js"></script>
		<? if (isset($sortable) && $sortable === TRUE) : ?>
		<script src="/apis/jquery-ui-1.10.4.custom/js/jquery-ui-1.10.4.custom.min.js"></script>
		<script src="/apis/jquery.mjs.nestedSortable.js"></script>
		<? endif; ?>
		<script src="/apis/datepicker/js/bootstrap-datepicker.js"></script>
		<script type="text/javascript" src="/apis/tinymce/tinymce.min.js"></script>
		<script type="text/javascript">
			tinymce.init({
				selector: ".tinymce",
				plugins: "preview code image",
				image_list: [
					{title: 'My image 1', value: 'http://elysium-cms.local/img/logo-elisium.png'}
				],
				toolbar: "undo redo | cut copy paste | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | image | removeformat code",
				menubar : false
			});
			
			$(function() {
				$('.datepicker').datepicker({
					format: 'yyyy-mm-dd'
				});
			});
			
			<? if (isset($c_name)): ?>
				var c_name = '<?=$c_name?>';
				var delete_confirm = '<?=$delete_confirm?>';
			<? endif; ?>
			
		</script>
		<script src="/js/scripts-admin.js"></script>
	</head>
	<body>