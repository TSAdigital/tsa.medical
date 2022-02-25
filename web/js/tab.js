$(function($){
    var storage = document.cookie.match(/nav-pos=(.+?);/);


    if (storage && storage[1] !== "#") {
        $('.nav-pos a[href="' + storage[1] + '"]').tab('show');
    }

    $('ul.nav li').on('click', function() {
        var id = $(this).find('a').attr('href');
        document.cookie = 'nav-pos=' + id;
    });
});