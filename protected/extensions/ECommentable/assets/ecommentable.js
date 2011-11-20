$(document).ready(function() {
    $(document).delegate('.ajax-add-comment', 'click', function(){
        var form = $('.ajax-answer-example').html();
        var parent = $(this).attr('parent');
        if (!(parent > 0)) parent = 0;
        if ($(this).next('.ajax-form-after').length == 0) {
            $(form).insertAfter(this).find('input[name=parent]').attr('value', parent);
            $(this).hide();
        } 
       
        return false;
    });
    $(document).delegate('.ajax-comment-form', 'submit', function(){
        var url = $(this).attr('action');
        divform = $(this).parent('.ajax-form-after');
        $.post(url, {
            'form': $(this).serialize()
        }, function (json) {
            if (json.error) {
                alert('Error Unknown'); 
            } else {
                divform.empty().html(json.html);
            }
        }, 'json');
        return false;
    }) 
});