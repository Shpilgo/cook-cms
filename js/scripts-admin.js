function make_message(atr) {
	atr.type = (atr.type) ? atr.type : 'info';
	atr.hide = (atr.hide) ? atr.hide : 5000;
	$('#message').attr('class', 'alert alert-'+atr.type).html(atr.message).show();
	setTimeout(function(){
		$('#message').hide();
	}, atr.hide);
}

function ru2lat(string) {
	string = $.trim(string).replace(/ +(?= )/g,'');
	var dictionary = { "А":"A","Б":"B","В":"V","Г":"G",
					"Д":"D","Е":"E","Ж":"J","З":"Z","И":"I",
					"Й":"Y","К":"K","Л":"L","М":"M","Н":"N",
					"О":"O","П":"P","Р":"R","С":"S","Т":"T",
					"У":"U","Ф":"F","Х":"H","Ц":"TS","Ч":"CH",
					"Ш":"SH","Щ":"SCH","Ъ":"","Ы":"YI","Ь":"",
					"Э":"E","Ю":"YU","Я":"YA","а":"a","б":"b",
					"в":"v","г":"g","д":"d","е":"e","ж":"j",
					"з":"z","и":"i","й":"y","к":"k","л":"l",
					"м":"m","н":"n","о":"o","п":"p","р":"r",
					"с":"s","т":"t","у":"u","ф":"f","х":"h",
					"ц":"ts","ч":"ch","ш":"sh","щ":"sch","ъ":"y",
					"ы":"yi","ь":"","э":"e","ю":"yu","я":"ya",
					' ':"-", "І":"I", "Ї":"YI", "і":"i", "ї":"yi"};
	return string.replace(/[\s\S]/g, function(x) {
		if (dictionary.hasOwnProperty(x)) {
			return dictionary[x];
		}
		return x;
	});
};

$(function() {
	
	$('.button-delete').on('click',function() {
		return confirm(delete_confirm);
	});
	
	$(document).on('click', '.click-remove-image', function() {
		$.post( '/admin/'+$(this).attr('data-type')+'/ajax_remove_image/'+$(this).attr('data-id'), { image: $(this).attr('data-image'), type: $(this).attr('data-type') }, function( data ) { }, "json");
		$(this).parent().remove();
	});
	
	$(document).on('keyup', '#to_link', function() {
		$('#link').tooltip('destroy');
		$('#link').tooltip({
			title: '<a href="javascript:void(0)" id="update_link">' + ru2lat($(this).val()) + '</a>',
			placement: 'bottom',
			trigger: 'focus',
			html: true,
			delay: { show: 0, hide: 0 },
			animation: false
		});
		$('#link').tooltip('show');
	});
	
	$(document).on('click', '#update_link', function() {
		$('#link').val($(this).html());
		$('#link').tooltip('destroy');
	});
	
});