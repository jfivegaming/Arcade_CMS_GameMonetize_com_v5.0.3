function crlocal() {
    var a, b, c = window.navigator.language.toLowerCase();
    for (a = 0, b = s.length; b > a; a++)
        if (c.indexOf(s[a]) > -1) return s[a];
    return "en"
}

function getParam(a) {
    var b = new RegExp("(^|&)" + a + "=([^&]*)(&|$)", "i"),
        c = window.location.search.substr(1).match(b);
    return null != c ? unescape(c[2]) : null
}

function gethl() {
    var a = getParam("hl") || crlocal() || "en";
    return -1 == s.indexOf(a) ? "en" : a
}

function showCT(a) {
    var b, c, d, e, f = $("[lib]");
    for (b = 0, c = f.length; c > b; b++) d = $(f[b]), _lanAttr = d.attr("lib"), _lan = a[_lanAttr], _lan && ("title" == _lanAttr && (e = d.attr("title") || "", _lan = _lan.replace(/###/gi, e)), d.html(_lan))
}

function show() {
    if ("undefined" == typeof getComHl || !getComHl()) {
        var a, b, c, d = gethl();
        try {
            lanlib = JSON.parse(localStorage.lanlib)
        } catch (e) {
            lanlib = {}
        }
        a = (new Date).getTime(), b = localStorage.lanTime || 0, c = getParam("hl"), Object.keys(lanlib).length > 0 && 216e5 >= a - b && (c == localStorage.lanParam || !c) ? showCT(lanlib) : $.get("/Media/lan.lib/" + d + ".json?v=1.9.8", function(a) {
            var b;
            a = a || {}, Object.keys(a).length <= 0 || (localStorage.lanlib = JSON.stringify(a), localStorage.lanTime = (new Date).getTime(), localStorage.lanParam = d, window.lanlib = a, b = a, showCT(b))
        }, "json")
    }
}

function initGoTop() {
    _m && $("#footer").removeClass("fix"), $(window).scrollTop(), $(window).scrollTop() >= "760" && $("#BackTop").show();
    var b = $("#BackTop");
    $(window).scroll(function() {
        $(window).scrollTop() <= "760" ? $(b).hide() : $(b).show()
    }), $("#BackTop").click(function() {
        $("html,body").animate({
            scrollTop: 0
        }, 600)
    })
}

function IdxFuc() {
    var a = $(".post").eq(Math.floor($("#content").width() / 150) - 3).offset().left + 150,
        b = '<div id="pos-idx"><span>Advertisement</span>' + __Slots.render(isMobile ? _Slots.idx_m : _Slots.idx, 1) + "</div>";
    $(".catename").size() >= 1 ? $(".catename").after(b) : $("#content").prepend(b), $("#pos-idx").css("left", "").css("left", a - $("#pos-idx").offset().left), (adsbygoogle = window.adsbygoogle || []).push({})
}

function shuffle(a) {
    var b, c, d = a.length;
    if (d)
        for (; --d;) c = Math.floor(Math.random() * (d + 1)), b = a[c], a[c] = a[d], a[d] = b;
    return a
}

function checkCookieconsent() {
    localStorage.ckCookieconsent || location.href.indexOf("play/") > -1 || ($("body").append('<div id="cookieconsent" style="display:none;"><span>This website uses cookies to ensure you get the best experience on our website. <a href="//gamemonetize.com/privacypolicy" target="_blank">Learn more</a></span><a class="cc-btn">Got it!</a></div>'), $(".cc-btn").on("click", function() {
        localStorage.ckCookieconsent = !0, $("#cookieconsent").remove()
    }))
}

function gameSize() {
    var a = $(window).width(),
        b = $(".game-box"),
        c = b.attr("data-width"),
        d = b.attr("data-height"),
        e = c / d,
        f = b.attr("data-norate");
    0 == f ? b.css({
        width: c + "px",
        height: d + "px",
        position: "relative",
        "z-index": 0,
        top: 0,
        left: 0,
        "margin-left": "auto",
        "margin-right": "auto",
        "margin-top": 0
    }) : 1280 >= a ? (b.css({
        width: "680",
        height: 680 / e + "px",
        position: "relative",
        "z-index": 0,
        top: 0,
        left: 0,
        "margin-left": "auto",
        "margin-right": "auto",
        "margin-top": 0
    }), _Gameheight = Number(680 / e), _Gameheight = _Gameheight > 555 ? _Gameheight : 555) : (b.css({
        width: c,
        height: d,
        position: "relative",
        "z-index": 0,
        top: 0,
        left: 0,
        "margin-left": "auto",
        "margin-right": "auto",
        "margin-top": 0
    }), _Gameheight = Number(d), _Gameheight = _Gameheight > 555 ? _Gameheight : 555), $(".game-info").css("min-height", Number(_Gameheight) + 48 + "px")
}

function showGameBox() {
    var a = $("#loader_container").is(":visible");
    return a ? !1 : ($("html,body").animate({
        scrollTop: "240px"
    }, 800), $("#loader_container").hide(), $("#gameDiv").css({
        visibility: "visible",
        display: "block",
        height: "100%"
    }), void 0)
}

function ReplayGame() {
    var c, d, a = $("#gameframe");
    if (a.size()) try {
        ReloadReplayFrame()
    } catch (b) {} else c = $("#game-box"), c = c.size() ? c : $(".game-box"), d = c.html(), c.html(d)
}

function ReloadReplayFrame() {
    var a, b, c;
    reloadCont > 10 || (a = document.getElementById("gameframe"), b = a.contentDocument || a.contentWindow.document, b && (c = b.getElementsByTagName("iframe")[0], c && c.setAttribute("src", c.getAttribute("src"))), reloadCont++)
}

function GameFullscreen() {
	$('#header').css('z-index', '999');
    var b, c, d, e, f, g, h, i, j;
    $(".game-box").html(), b = $("#game-col").parent(), c = $(window).height(), d = '<div id="Boxshadow" style="height:' + c + 'px;"><div id="Close" onclick="CloseFullscreen();return false;">Close</div></div>', 
    e = $(".game-box"), f = $("#gameDiv"), g = f.offset().width, h = f.offset().height, i = 1.2 * (g / h), j = {
        height: c - 50,
        width: c + 300,
        position: "fixed",
        "z-index": 1112,
        top: "50%",
        left: "50%",
        "margin-left": -((c + 295) / 2),
        "margin-top": -((c - 50) / 2)
    }, e.css(j), hdiv = $("#Boxshadow"), hdiv.size() ? hdiv.css("height", c + "px") : b.append(d), FullScreen = !0, $(".go-game").hide()
}

function CloseFullscreen() {
	$('#header').css('z-index', '9999');
    var a = $("#gameDiv"),
        b = a.offset().width,
        c = a.offset().height;
    $("#Boxshadow").remove(), $("#Close").remove(), FullScreen = !1, $(".go-game").show(), $(".game-box").attr("style", "").css({
        width: b,
        height: c,
        "text-align": "center"
    })
}

console.log.apply(console, "\n %c %c %c  GameMonetize.com CMS - Free Arcade Script for Publishers!  %c  %c     powered by   https://www.gamemonetize.com/cms     %c %c %c %c,background: #9C0013; padding:5px 0;,background: #9C0013; padding:5px 0;,color: #FFFFFF; background: #030307; padding:5px 0;,background: #9C0013; padding:5px 0;,color: #FFFFFF;background: #DB0028; padding:5px 0;,background: #9C0013; padding:5px 0;,color: #ff2424; background: #9C0013; padding:5px 0;,color: #ff2424; background: #fff; padding:5px 0;,color: #ff2424; background: #fff; padding:5px 0;".split(","));
console.log(" %c %c %c  Get your own free arcade script with modern themes, thousands of HTML5 games and optimized UI to increase revenue!  %c %c %c", "background: #db0028", "background: #db0028", "color: #fff; background: #db0028;", "background: #db0028", "background: #db0028", "background: #ffffff");
var loadTime = window.performance.timing.domContentLoadedEventEnd- window.performance.timing.navigationStart; 
window.onload = function () {
    var loadTime = window.performance.timing.domContentLoadedEventEnd-window.performance.timing.navigationStart; 
    console.log(' Load time: 0.'+ loadTime);
}