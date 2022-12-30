(function ($) {
	'use_strict';
	// Equal Height
	$(window).on('load', 'resize', function (event) {
		$('.match-height').matchHeight({
			byRow: true,
		});
	});

	// tool tips
	$(function () {
		$('[data-toggle="tooltip"]').tooltip()
	})

	$messagePoint = $('#mp_modal');
	// Messages module
	var Messaging = {
		showMessage: function ($title, $msg, $function) {
			$messagePoint.find('#mp_modal').text($title);
			$messagePoint.find('.modal-body').text($msg);
			return $messagePoint.modal('show').on('hidden.bs.modal', $function).promise();
		}
	}

	function reload2home(time = 5000) {
		setTimeout(function () { // wait for 5 secs(2)
			location.reload(); // then reload the page.(3)
		}, time);
	}

	function processHttpRequests(url, data, re) {
		if (url && data) {
			return $.ajax({
				url: url,
				data: data,
				cache: false,
				type: 'post',
				dataType: re
			}).promise();
		}
	}



	$('#toggler').on('click', function (e) {
		e.preventDefault();
		if ($('#' + $(this).data('toggle')).is(':visible')) {
			$('#' + $(this).data('toggle')).removeClass('d-block').addClass('d-none');
		} else {
			$('#' + $(this).data('toggle')).removeClass('d-none').addClass('d-block');
		}
	});
	
	$('.focus-area-s').on('click', function (e) {
		e.preventDefault();
		console.log($(this).find('.focus-area-desc'));
		$(this).find('.focus-area-desc').toggleClass('d-none');
	});
})(jQuery);