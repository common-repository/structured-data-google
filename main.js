jQuery(document).ready(function($){
	console.log('Google structured data is ready');
	
	
	$('input[name="gsd_active"], input[name="local_business_active"]').on('change', function(){
		
		var $elm = $(this);
		var $elmToUpdate = $('#gsd-active');
		
		if ($elm.prop('checked')) {
			$elmToUpdate.addClass('active');
			return;
		}
		
		$elmToUpdate.removeClass('active');
		
	});
	
	
	
	$('input[name="default_website"]').on('change', function(){		
		
		var $elm = $(this);
		var $elmToUpdate = $('input[name="website_url"]');
		
		if ($elm.prop('checked')) {
			$elmToUpdate.prop('readonly', true);
			return;
		}
		
		$elmToUpdate.prop('readonly', false);
		
	});
	
	
});