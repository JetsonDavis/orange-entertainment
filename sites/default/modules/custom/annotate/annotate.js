$(document).ready(function(){
	$('.form-checkbox').change(function(){
		var x = $(this).attr("class");
		var y = $(this).attr("value");
		//alert('Changed ' + x + ' ' + y)
	$.ajax({
  		type: 'POST',
 		url: "checkbox_callback",
  		data: {node: x, value:y},

});
	});
});