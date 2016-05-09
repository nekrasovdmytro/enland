/**
 * Created by nekrasov on 08.05.16.
 */


$(function(){
    espeak_iframe = $('<iframe/>', {
        'src':'',
        'style':'display:none'
    });

    showplate = $('<div/>', {
        'id' : 'showword'
    }).css({"display":"none","position":"fixed", "left":"0px", "top":"0px", "padding":"15px", "opacity":"0.8", width:"100%", "background":"#ccc", "color":"#000", "font-size":"35px"});

    $('body').append(espeak_iframe);
    $('body').append(showplate);

    $('.talk').click(function(){
        currentTalkEl = $(this);

        text = currentTalkEl.attr('text');
        data = {"text" : text};
        currentTalkEl.css("opacity", "0.5");
        showplate.hide();

        var request = $.ajax({
                method: "POST",
                url: "/talk/add",
                data: JSON.stringify(data),
                contentType: "application/json",
        });

        request.done(function( msg ) {
            showplate.text(text);
            showplate.show();
            currentTalkEl.css("opacity", "1");
            espeak_iframe.attr('src', '/mp3/' + msg.file);
            setTimeout("showplate.hide();", 3000);
        });

        request.fail(function( msg ) {
            console.log(msg)
        });
    })
})
