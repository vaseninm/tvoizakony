$(document).ready(function() {
    $(document).delegate('.ajax-add-comment', 'click', function(){
        var form = $('.ajax-answer-example').html();
        var parent = $(this).attr('parent');
        if (!(parent > 0)) parent = 0;
        if ($(this).next('.ajax-form-after').length == 0) {
            if (parent == 0) {
                $(this).parent().siblings('.ajax-comments').append(form);
            } else {
                var div = $(this).parents('.ajax-comment');
                $(form).insertAfter(div).find('input[name=parent]').attr('value', parent);
            }
            div.next().find('textarea[name=text]').focus();
            $(this).parent().hide();
        } 
       
        return false;
    });
    $(document).delegate('.ajax-comment-form', 'submit', function(){
        var url = $(this).attr('action');
        var parent = $(this).find('input[name=parent]').attr('value');
        divform = $(this).parent('.ajax-form-after');
        $.post(url, {
            'form': $(this).serialize()
        }, function (json) {
            if (json.error) {
                alert('Error Unknown'); 
            } else {
                var prevdiv = divform.prev();
                divform.replaceWith(json.html);
                if (parent == 0) {
                    $('.ajax-add-comment-not-parent').show();
                } else {
                    var level = prevdiv.attr('level');
                    $.each(prevdiv.nextAll(), function(key, value) {
                        if ($(value).attr('level') == level) {
                            var currentid = prevdiv.next().insertBefore(value).attr('id');
                            document.location.href = '#' + currentid;
                            return false;
                        };
                    });
                    prevdiv.find('.ajax-add-comment').parent().show();
                }
                $(".ajax-comments-count").text($(".ajax-comments-count").text() * 1 + 1);
            }
        }, 'json');
        return false;
    });
    $(document).delegate('a.ajax-tags', 'click', function(){
        $(this).siblings('p.ajax-tags').toggle();
        return false;
    });
    $(document).delegate('.ajax-comment-cancel', 'click', function(){
        $(this).parents('.ajax-form-after').prev().find('.ajax-add-comment').parent().show();
        $(this).parents('.ajax-form-after').remove();
        return false;
    });
    $(document).delegate('.ajax-delete-comment', 'click', function(){
        var commentid = $(this).attr('comment');
        var url = $(this).attr('href');
        var divid = $(this).parents('.ajax-comment').attr('id'); 
        $.post(url, {
            'commentid': commentid,
            'divid': divid
        }, function (json){
            if (json.error) {
                alert('Unknown error');
            } else {
                $('#'+json.divid).replaceWith(json.html);
            }
        }, 'json');
        return false;
    });
});