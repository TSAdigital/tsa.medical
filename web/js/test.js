$(function($){
    var storage = document.cookie.match(/nav-pills=(.+?);/);


    if (storage && storage[1] !== "#") {
        $('.nav-pills a[href="' + storage[1] + '"]').tab('show');
    }

    $('ul.nav li').on('click', function() {
        var id = $(this).find('a').attr('href');
        document.cookie = 'nav-pills=' + id;
    });
});