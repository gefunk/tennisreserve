

$.fn.absoluteTop = function() {
    var o = $(this[0]); // It's your element
    return o.offset().top - $(window).scrollTop();
};

$.fn.absoluteLeft = function(){
    var o = $(this[0]);
    return o.offset().left - $(window).scrollTop();
}