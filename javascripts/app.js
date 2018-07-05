$(document).ready(
	function() 
	{
		// $('.add-id').on('click', function()	
		// {
		// 	$('.add-edit-form').show();
		// }
		// );
		$('.box').on('click', function()
		{
			$(this).find('.subcategory').show();			
		},
		function()
		{
			$(this).find('.subcategory').hide();
		}
		);
	}

);