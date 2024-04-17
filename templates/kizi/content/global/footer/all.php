{{FOOTER_ENGINE_ACCESS}}
<script>
    //gotop
    $(function() {
        var sT = $(window).scrollTop();
        if ($(window).scrollTop() != "0")
            $("#BackTop").fadeIn("slow");
        var scrollDiv = $("#BackTop");
        $(window).scroll(function() {
            if ($(window).scrollTop() == "0")
                $(scrollDiv).fadeOut("slow")
            else
                $(scrollDiv).fadeIn("slow")
        });
        $("#BackTop").click(function() {
            $("html, body").animate({
                scrollTop: 0
            }, "slow")
        });
    });
</script>

<script src="{{CONFIG_THEME_PATH}}/js/global.js"></script>
<script src="{{CONFIG_THEME_PATH}}/js/jquery.masnory.min.js"></script>
<script src="{{CONFIG_THEME_PATH}}/js/gamefree.js"></script>
<script src="{{CONFIG_SITE_URL}}/static/libs/js/jquery.form.min.js"></script>
<script src="{{CONFIG_SITE_URL}}/static/libs/js/root.js"></script>
<script src="{{CONFIG_THEME_PATH}}/js/general.js"></script>
<script src="{{CONFIG_THEME_PATH}}/js/index.js"></script>