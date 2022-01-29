$(window).on('load', function (){
    let tab = $('.tab-pane').length
    let i = 1;
    let test = '';
    const table = function(data) {
        if ($("#tab" + data).find('.invalid-feedback').text().length > 0) {
            test = $(".tab-" + data).html('<sup><i class="fas fa-exclamation-circle text-danger"></i></sup>');
        } else {
            test = $(".tab-" + data).html('');
        }
        return test
    }
    while (i <= tab){
        table(i);
        i++
    }
    $("body").on("DOMSubtreeModified", ".tab-pane", function(){
        "use strict"
        table(1);
        table(2);
    });
});