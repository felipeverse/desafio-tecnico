function enableMasks() {
    $('.phone-ddd-mask').on('input', function() {
        $(".phone-ddd-mask").mask("(99) 99999-9999");
    });
}