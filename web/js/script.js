$(".tab-pane").bind("DOMSubtreeModified", function(){
    if($("#tab1").find('.invalid-feedback').text().length > 0) {
        $(".tab-1").html('<sup><i class="fas fa-exclamation-circle text-danger"></i></sup>');
    }else{
        $(".tab-1").html('');
    }
    if($("#tab2").find('.invalid-feedback').text().length > 0) {
        $(".tab-2").html('<sup><i class="fas fa-exclamation-circle text-danger"></i></sup>');
    }else{
        $(".tab-2").html('');
    }
});