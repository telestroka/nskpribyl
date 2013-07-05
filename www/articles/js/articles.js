$(function () {
	$('form[name="addcomment"]').submit(function (event) {
		event.preventDefault();
		var $form = $(this),
				data = {
					'text':$form.find('textarea[name="text"]').val(),
					'item':$form.find('input[name="item"]').val(),
					'key':$form.find('input[name="key"]').val()
				};

		$.post($form.attr('action'), data,function (data) {
			$form.find('.alert').html('');
			if (data.success) {
				$form.hide();
				$form.next().show();
			} else {
				var error = 'Ошибка. ';
				$.each(data.errors, function (key, value) {
					if (key == 'form') {
						$form.find('.alert:last').html(error + value);
					} else {
						$form.find('*[name="' + key + '"]').next('.alert').html(error + value);
					}
				});
			}
		}).error(function (param) {
		console.log(param);
					$form.find('.alert:last').html('При отправке комментария произошла ошибка.');
				});
	});

	$('form[name="add"]').submit(function (event) {
		event.preventDefault();
		var $form = $(this),
				data = {
					'text':$form.find('textarea[name="text"]').val(),
					'key':$form.find('input[name="key"]').val()
				};

		$.post($form.attr('action'), data,function (data) {
			$form.find('.alert').html('');
			if (data.success) {
				$form.hide();
				$form.next().show();
			} else {
				var error = 'Ошибка. ';
				$.each(data.errors, function (key, value) {
					if (key == 'form') {
						$form.find('.alert:last').html(error + value);
					} else {
						$form.find('*[name="' + key + '"]').next('.alert').html(error + value);
					}
				});
			}
		}).error(function () {
					$form.find('.alert:last').html('При отправке темы произошла ошибка.');
				});
	});
});