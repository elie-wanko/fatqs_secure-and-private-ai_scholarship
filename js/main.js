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
            $('.answers--block').find("h5").hide();
        });

        $('#search_text').on('keypress', function(e){
            if (e.keyCode == 13) {
                console.log(e.keyCode)
            }
        });
    });

}(jQuery, window, document));
