;
(function ($, FRW, window, document, undefined) {
    'use strict';

    /*
     |--------------------------------------------------------------------------
     | On Ready
     |--------------------------------------------------------------------------
     */
    $(function () {
        //Get all the lessons
        $.ajax({url: "src/index.php", success: function(response){
            $('.lessons').empty();
            let lessons = JSON.parse(response);
            Object.entries(lessons).forEach(function(lesson){ 
                $('.lessons').append('<li><a href = "src/lesson.php?id=' + lesson[1][0] + '&title=' + lesson[1][1] + '" >' + lesson[1][1] + '</a></li>');
            }); 
        }});

        $('.sidenav').sidenav();
        $('.answers--content').hide();
        $('.answers--block').find("[data-index='1']").show();

        $('.question').on('click', function () {
            let index = $(this).data('index');
            $('.answers--content').hide();
            $('.answers--block').find("[data-index='" + index + "']").show();
        });

        $( ":input[name='search_text']" ).on('keypress', function(e){
            if (e.keyCode == 13) {
                $("#search__form").submit();
            }
        });
        $(".icon__close").on('click', function(){
            $( ":input[name='search_text']" ).val("");
            $("#search__form").submit();
        });
        //For Images
        $('.materialboxed').materialbox();
    });

}(jQuery, window, document));
