;
(function ($, FRW, window, document, undefined) {
    'use strict';

    /*
     |--------------------------------------------------------------------------
     | On Ready
     |--------------------------------------------------------------------------
     */
    $(function () {
        $('.sidenav').sidenav();

        $('.question').on('click', function () {
            $('#answers--block').removeClass('hiddendiv');
            $('#answers--block').prev().html("");
            $('.question-title').html($(this).data('question'));
            $('.answer').html($(this).data('answer'));
        });

        $('#search_text').on('keypress', function(e){
            if (e.keyCode == 13) {
                console.log(e.keyCode)
            }
        });
    });

}(jQuery, window, document));
