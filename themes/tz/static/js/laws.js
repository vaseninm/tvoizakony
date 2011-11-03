$(document).ready(function() {
    
    // +1
    $('.ajax-plus-odin').live('click',function(){
        var url = $(this).attr('href');
        var id = $(this).parents('.ajax-post').attr('id');
        $.post(url, {
            'id' : id
        }, function(json){
            if (!json.error) {
                $('#'+json.params.id).find('.ajax-rating').text(json.rating);
				$('#'+json.params.id).find('.ajax-vote').empty().addClass('plus-odin-voted');
            } else {
                switch (json.error) {
                    case 1:
                        alert("Вы не можете голосовать за свои законопроекты.");
                        break;
                    case 2:
                        alert("Вы уже проголосовали");
                        break;
                    case 3:
						$('#ajax-rating-non-reg').show(); //Вот  это раскомментить
						//alert('Вы не зарегистрированы'); // а это удалить
						break;
                }
            }
        }, 'json');
        return false;
    });
    
    //set status
    $('a[class^=ajax-setstatus-]').live('click', function() {
        var url = $(this).attr('href');
        var id = $(this).parents('.ajax-post').attr('id');
        $.post(url,{'id':id}, function(json){
            if(!json.error) {
                $('#'+json.params.id).find('a[class^=ajax-setstatus-]').parent().hide();
                $('#'+json.params.id).find('.ajax-setstatus-' + json.approve).parent().show();
            }
        },'json');
        return false;
    });
	
	// search hint
	$('#ajax-search-hint').click(function(){
		var text = $(this).text();
		$('#ajax-search').attr('value', text);
		return false;
	});
	
	// close non reg div
	$('#ajax-rating-non-reg-close').click(function () {
		$('#ajax-rating-non-reg').hide();
		return false;
	});
	
	// delete laws
	$('.ajax-delete').click(function() {
		var url = $(this).attr('href');
        var id = $(this).parents('.ajax-post').attr('id');
        $.post(url,{'id':id, 'ajax': true}, function(json){
            if(!json.error) {
                $('#'+json.params.id).remove();
            }
        },'json');
        return false;
	});
});