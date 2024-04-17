$(function(){

var popupHideDelay;
$(".submenu").mouseenter(function(e) {
    var self = $(this);
    var a = self.find("a:first-child");
    var s = self.find(".menupopup");
    s.removeClass("fn-hide");
    a.addClass("active");
    clearTimeout(popupHideDelay);
}).mouseleave(function() {
    var self = $(this);
    var a = self.find("a:first-child");
    var s = self.find(".menupopup");
    popupHideDelay = setTimeout(function() {
        s.addClass("fn-hide");
        a.removeClass("active");
    }, 10);
});
$(".menupopup").mouseenter(function() {
    clearTimeout(popupHideDelay);
}).mouseleave(function() {
    var self = this;
    popupHideDelay = setTimeout(function() {
        $(self).addClass("fn-hide");
    }, 10);
});
$(".menu li").mouseover(function(){
    $(this).find(".tooltip").removeClass("fn-hide");
})
$(".menu li").mouseout(function(){
    $(this).find(".tooltip").addClass("fn-hide");
})

})