<?php if ( !defined('API_PILOT') ) exit(); ?>
<script type="text/javascript" src="<?php echo $config['site_url'];?>/static/libs/api/swfobject/swfobject.js"></script>
<script type="text/javascript">
    // For version detection, set to min. required Flash Player version, or 0 (or 0.0.0), for no version detection.
    var swfVersionStr = "11.7";
    // To use express install, set to expressInstall.swf, otherwise the empty string.
    var xiSwfUrlStr = "<?php echo $config['site_url'];?>/static/libs/api/swfobject/expressInstall.swf";
    var params = {};
    params.quality = "high";
    params.allowscriptaccess = "always";
    params.allowfullscreen = "false";
    params.wmode = "direct";
    //params.wmode = "transparent";
    swfobject.embedSWF(
        "<?php echo $get_game_data['file'];?>", "api_game_embed",
        "100%", "100%",
        swfVersionStr, xiSwfUrlStr, params);
    // JavaScript enabled so display the api_game_embed div in case it is not replaced with a swf object.
    swfobject.createCSS("#api_game_embed", "");
</script>

<div id="api_game_embed">
    <div style="margin-top:50px;text-align:center;">
        <a href="https://get.adobe.com/flashplayer/" target="_blank" rel="nofollow noopener"><img src="<?php echo $config['site_url'];?>/static/adobe-flashplayer.png"></a>
    </div>
</div>