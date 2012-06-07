/*
 * PHP Personal Bookmaks
 *
 * Copyright 2012, fitorec
 * Dual licensed under the MIT or GPL Version 2 licenses.
 *
 * Description: filters logic
 *
 */
$(function() {
	var filter = function (value, pos){
		$('.tablesorter tbody tr').each(function() {
			$(this).hide();
			if( $($(this).find('td')[pos]).text().indexOf(value) >= 0)
				$(this).show(1000);
		});
	}
	// filter inline to tags
	$('input[name="filter_tag"]').keyup(function() {
		filter($(this).val(),3);
	});
	// filter inline to descriptions
	$('input[name="filter_description"]').keyup(function() {
		filter($(this).val(),2);
	});
	// filter inline to URL
	$('input[name="filter_url"]').keyup(function() {
		filter($(this).val(),1);
	});
});
