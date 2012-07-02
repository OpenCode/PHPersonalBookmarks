/*
 * PHP Personal Bookmaks
 *
 * Copyright 2012, fitorec
 * Dual licensed under the MIT or GPL Version 2 licenses.
 *
 * Description: filters logic
 * last-change: 2012/07/02 08:39:51
 *
 */
$(function() {
//extracted the table from the DOM, to work only with a branch of the DOM
	$tableSort = $('#tab_container_table').find('table.tablesorter');
//responsible for implementing the filter.
	var filter = function (value, pos){
		$tableSort.find('tbody tr').each(function() {
			$(this).hide();
			if( $($(this).find('td')[pos]).text().toLowerCase().indexOf(value.toLowerCase()) >= 0)
				$(this).show(1000);
		});
	}//end filter fuction
//event handler, which triggered the filter function.
	$tableSort.find('input[name^=filter_]').keyup(function(){
		var filters = ['filter_url','filter_description','filter_tag'],
		name=$(this).attr('name');
		if( pos = $.inArray(name, filters) >= 0){
			filter($(this).val(),pos+1);
		}
	});//end eventHandler
});
