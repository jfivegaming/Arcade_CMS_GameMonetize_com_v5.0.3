{{FOOTER_ENGINE_ACCESS}}
{{CP}}
{{CMS}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script src="{{CONFIG_THEME_PATH}}/js/jquery.masnory.min.js"></script>
<script src="{{CONFIG_THEME_PATH}}/js/gamefree.js"></script>
<script src="{{CONFIG_SITE_URL}}/static/libs/js/jquery.form.min.js"></script>
<script src="{{CONFIG_SITE_URL}}/static/libs/js/root.js"></script>
<script src="{{CONFIG_THEME_PATH}}/js/general.js"></script>
<script src="{{CONFIG_THEME_PATH}}/js/libs/toast.min.js"></script>
<script src="{{CONFIG_THEME_PATH}}/js/index.js"></script>


<script>
$(function() {
    $(".searchbox").keyup(function() {
        var searchid = $(this).val();
        var dataString = 'search=' + searchid;
       	$(".pagination").hide();

        $.ajax({
            type: "POST",
            url: "{{CONFIG_SITE_URL}}/search.php",
            data: dataString,
            cache: true,
            success: function(html) {
                $("._manage--games-list").html(html).show();
            }
        });
    });
});
</script>