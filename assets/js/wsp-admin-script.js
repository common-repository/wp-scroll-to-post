(function($){

	// USE STRICT
	"use strict";
 
	$.each(wspAdminScript.wspIdsOfColorPicker, function( index, value ) {
		$(value).wpColorPicker();
	});

	//==================================================
	$('.add').on('click', function(){
		var npstp_tr_sl = $('tr.wab-add-row-tr').length;
		var npstp_tr = '<tr class="wab-add-row-tr">'+
					'<td style="vertical-align: top;">'+(npstp_tr_sl+1)+'</td>'+
					'<td class="wab_name" style="vertical-align: top;"><input type="text" name="wab_name[]" class="wab_name" placeholder="Alert Bar Name"></td>'+
					'<td class="wab_description" style="vertical-align: top;"><textarea name="wab_description[]" class="wab_description" cols="50" rows="1"></textarea></td>'+
					'<td class="wab_bg_color" style="vertical-align: top;">'+
						'<input class="wab-wp-color" type="text" name="wab_bg_color[]" id="wab_bg_color_'+(npstp_tr_sl+1)+'">'+
						'<div id="colorpicker"></div>'+
					'</td>'+
					'<td style="vertical-align: top; text-align:center;"><a href="#" class="dashicons dashicons-no delete">&nbsp;</a></td></tr>';
		$('.wab-add-row-tbody').append(npstp_tr);

		$.each([ '#wab_bg_color_' + (npstp_tr_sl+1) ], function( index, value ) {
			$(value).wpColorPicker();
		});
	});

	//==================================================
	$('tbody.wab-add-row-tbody').delegate('.delete', 'click', function(){
		var npstp_tr_sl = $('tr.wab-add-row-tr').length;
		if(npstp_tr_sl>1){
			$(this).parent().parent().remove();
		}
	});

	//====================================================
	$('.wab-closebtn').on('click', function(){
		this.parentElement.style.display='none';
	});

})(jQuery);