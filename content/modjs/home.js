
$(document).ready(function() {
	window.onload = function(){
		var ctx = document.getElementById("canvas-stats").getContext("2d");
		window.myLine = new Chart(ctx).Line(datastats, {
			responsive: true
		});
	}
	
	$('#from_stat').datetimepicker({
		format: 'YYYY-MM-DD',
		showTodayButton: true,
		showClear: true,
		icons: {
			previous: 'icon-arrow-left8',
			next: 'icon-arrow-right8',
			today: 'icon-calendar3',
			clear: 'icon-bin',
		},
	});
	$("#from_stat").mask("9999-99-99");

	$('#to_stat').datetimepicker({
		format: 'YYYY-MM-DD',
		showTodayButton: true,
		showClear: true,
		icons: {
			previous: 'icon-arrow-left8',
			next: 'icon-arrow-right8',
			today: 'icon-calendar3',
			clear: 'icon-bin',
		},
	});
	$("#to_stat").mask("9999-99-99");

	$("#from_stat dates").on("dp.change",function (e) {
		$('#to_stat').data("DateTimePicker").minDate(e.date);
	});

	$("#to_stat").on("dp.change",function (e) {
		$('#from_stat').data("DateTimePicker").maxDate(e.date);
	});

	$('#clearDate').click(function() {
		$('#from_stat').data("DateTimePicker").minDate(false);
		$('#to_stat').data("DateTimePicker").maxDate(false);
		return false;
	});
});
