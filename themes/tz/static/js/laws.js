$(document).ready(function() {
    
    // +1
    $('.ajax-rate').live('click',function(){
        var url = $(this).attr('href');
        var id = $(this).parents('.ajax-post').attr('id');
        var doo = $(this).attr('do');
        $.post(url, {
            'id' : id,
            'do' : doo
        }, function(json){
            if (!json.error) {
                $('#'+json.params.id).find('.ajax-rating').text(json.rating);
                if (doo == 'plus') {
                    $('#'+json.params.id).find('.ajax-plus').empty().removeClass('plus-odin').addClass('plus-odin-voted');
                    $('#'+json.params.id).find('.ajax-minus').empty().removeClass('plus-odin').addClass('minus-odin-disabled');
                } else if (doo == 'minus') {
                    $('#'+json.params.id).find('.ajax-plus').empty().removeClass('plus-odin').addClass('plus-odin-disabled');
                    $('#'+json.params.id).find('.ajax-minus').empty().removeClass('plus-odin').addClass('minus-odin-voted');
                }
            } else {
                switch (json.error) {
                    case 1:
                        alert("Вы не можете голосовать за свои законопроекты.");
                        break;
                    case 2:
                        alert("Вы уже проголосовали");
                        break;
                    case 3:
                        $('#ajax-rating-non-reg').show();
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
        $.post(url,{
            'id':id
        }, function(json){
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
        $.post(url,{
            'id':id, 
            'ajax': true
        }, function(json){
            if(!json.error) {
                $('#'+json.params.id).remove();
            }
        },'json');
        return false;
    });
});