$(document).ready(
	function() 
	{
		// $('.add-id').on('click', function()	
		// {
		// 	$('.add-edit-form').show();
		// }
		// );
		$('#users').on('click', function()
		{
			$("input[name='users-tab']").val('1');
			$("input[name='posts-tab']").val('');
			$("input[name='categories-tab']").val('');				
		});
		$('#posts').on('click', function()
		{
			$('input:hidden[name="users-tab"]').val('1');
			$('input:hidden[name="posts-tab"]').val('');
			$('input:hidden[name="categories-tab"]').val('');		
		});
		if ($('.modal-window').attr('reload')==1)
		{
			 // location.reload();
		}

	}

);