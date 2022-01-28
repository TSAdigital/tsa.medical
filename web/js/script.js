const table = function(data) {
    if ($("#tab"+data).find('.invalid-feedback').text().length <= 0) {
        $(".tab-"+data).html('');
    } else {
        $(".tab-"+data).html('<sup><i class="fas fa-exclamation-circle text-danger"></i></sup>');
    }
}
$(".tab-pane").bind("DOMSubtreeModified", function(){
    'use strict';
    table(1);
    table(2);
    table(3);
});
table(1);
table(2);
table(3);