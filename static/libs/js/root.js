function Ajaxrequest(){
    return siteUrl + '/gm-request.php';
}

function startLoadbar() {
    $(".gamemonetize-page-loadbar")
        .show()
        .width((50 + Math.random() * 30) + "%");
}

function stopLoadbar() {
    $(".gamemonetize-page-loadbar")
        .width("100%")
        .delay(200)
        .fadeOut(400, function() {
            $(this).width("0");
        });
}

$(document).on('click', '*[data-href]', function(e) {
    e.preventDefault();
    startLoadbar();
    document.location.href=$(this).attr('data-href');
    $(document).scrollTop(0);
});

function Loadlink(link) {
    return document.location.href=link;
}