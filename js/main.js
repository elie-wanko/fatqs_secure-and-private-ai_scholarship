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
    });

}(jQuery, window, document));
