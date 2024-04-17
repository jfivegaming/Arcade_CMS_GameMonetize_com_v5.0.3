    // 
    function __upGame_rx8(id) {
        $.ajax({
            url: Ajaxrequest() + '?t=gameplayed',
            type: 'POST',
            data: "gid=" + id
        });
    }
    
    /* FULLSCREEN FUNC */
    function initFullScreen(fscreenToThis) {
        if (BigScreen.enabled) {
            BigScreen.request($(fscreenToThis)[0]);
        } else {
            alert("This browser doesn't support full screen");
        }
    }

    function __sGame() {
        $('.gmDisplay').show();
        $('._Ad-game').remove();
    }

    var __AdRNum = 6; // seconds to remove ads
    function __AdRemoveCount() {
        if (__AdRNum!=0){
            __AdRNum-=1
            $('.rAdNum').text(__AdRNum);
        } else {
            $('.__r-Ad-1').css('display', 'none');
            $('.__r-Ad-2').css('display', 'inherit');
            $('._removeAd').attr('onclick', '__sGame()');
            $('._removeAd').attr('disabled', false);
            return false;
        }
        window.setTimeout(function(){ __AdRemoveCount() }, 1000);
    }

    function __adCountD() {
        if (__AdNum!=0){
            __AdNum-=1
            $('.Adnum').text(__AdNum);
        } else {
            __sGame();
            return false;
        }
        window.setTimeout(function(){ __adCountD() }, 1000);
    } 

    function __sendReport(gid) {
        swal({   
            title: "",
            text: "¿Tell us, what is your problem?",
            imageUrl: siteUrl+"/templates/modern/image/icon-color/worker.png",
            type: "input",
            showCancelButton: true,   
            closeOnConfirm: false,  
            animation: "slide-from-top",   
            inputPlaceholder: "Write the problem here in detail..."
        }, function(inputValue){   
            if (inputValue === false) return false;      
            if (inputValue === "") {     
                swal.showInputError("You need to write something!");     
                return false   
            }
            
            $.ajax({
                url: Ajaxrequest() + '?t=send_report',
                type: 'POST',
                data: "gid=" + gid + "&report=" + inputValue,
                success: function(data) {
                    if (data.status == 200) {
                        swal("", data.success_message, "success");
                    } else {
                        swal("", data.error_message, "error");
                    }
                }
            }); 
        });
        
    }

$(function () { 
    /* SEARCH AREA */
    $('#search-data-form').ajaxForm({
        url: Ajaxrequest() + '?t=search',
        type: 'POST',
        success: function(data) {
            startLoadbar();
            Loadlink(data.redirect_url);
            stopLoadbar();
        }, 
        error: function() {
            console.log('Connection failed!');
        }
    });

    /* FULLSCREEN BUTTON */
    $(document).on('click', '.initFullScreen', function(){
        initFullScreen($(this).attr('data-fullscreen-item'));
    });

    $(document).on('click', '#report-btn', function(){
        var gid_sR2 = $(this).attr('data-report');
        __sendReport(gid_sR2);
    });

    /* SHARE BUTTONS */
    $(document).on('click', '#share-btn', function(e){
        e.preventDefault();
        var Dragon__socialURl_r2 = $(this).attr('data-share-url');
        window.open(
            ''+Dragon__socialURl_r2+'',
            'Share',
            'toolbar=0, status=0, width=650, height=450'
        );
    });

    /* OVERLAY TOGGLE */
    $(document).on('click', '.overlay-toggle', function(e){
        e.preventDefault();
        var data_target = $(this).attr('data-target');
        $(data_target).toggleClass('overlay-open');
        $('body').toggleClass('state-overlay-open');
        $(data_target).attr('data-status', function(_, attr){
            return attr == 'closed' ? 'opened':'closed';
        });
    });

    $(document).on('click', '.overlay-wrapper', function(e){
        if (e.target == this) {
            $(this).toggleClass('overlay-open');
            $('body').toggleClass('state-overlay-open');
            $(this).attr('data-status', function(_, attr){
                return attr == 'closed' ? 'opened':'closed';
            });
        }
    });

});

(function (i, s, o, g, r, a, m) {
    i['GoogleAnalyticsObject'] = r;
    i[r] = i[r] || function () {
            (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date();
    a = s.createElement(o), m = s.getElementsByTagName(o)[0];
    a.async = 1;
    a.src = g;
    m.parentNode.insertBefore(a, m)
})(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');
(function () {
    ga('create', 'UA-154497915-1', 'auto');
    ga('send', 'pageview');
})();

(function (a, b, c) {
   var d = a.getElementsByTagName(b)[0];
   a.getElementById(c) || (a = a.createElement(b), a.id = c, a.src = "https://api.gamemonetize.com/cms_api.js?" + new Date().valueOf(), d.parentNode.insertBefore(a, d))
})(document, "script", "gamemonetize-cms"); 