  $(document).ready(function(){
    $('.sidenav').sidenav();

    $('.question').on('click', function() {
        $('#answers--block').removeClass('hiddendiv');
        $('#answers--block').prev().html("");
        $('.question-title').html($(this).data('question'));
        $('.answer').html($(this).data('answer'));
    })

  });