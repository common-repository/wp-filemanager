<?php
if ( ! defined( 'ABSPATH' ) )
	die();
if (!@include_once(WP_PLUGIN_DIR . "/wp-filemanager/incl/auth.inc.php"))
{
 include_once(WP_PLUGIN_DIR . "/wp-filemanager/incl/auth.inc.php");
}
//echo "save called with path";
if ($AllowEdit && isset($_GET['save']) && isset($_POST['filename']))
{
	check_admin_referer('edit_save_file_' . $_POST['filename']);
	//echo "Save Edited file";
	$text = stripslashes($_POST['text']);
	if (!wp_fileman_is_valid_name(stripslashes($_POST['filename']))) 
	{
	print "<font color='#CC0000'>$StrFileInvalidName</font>";
	}
	else if ($fp = @fopen ($home_directory.$wp_fileman_path.stripslashes($_POST['filename']), "wb"))
	{
		@fwrite($fp, $text);
		@fclose($fp);
		print "<font color='#009900'>$StrSaveFileSuccess</font>";
	}
	else
		print "<font color='#CC0000'>$StrSaveFileFail</font>";
}
else if ($AllowEdit && isset($_GET['filename']))
{
	check_admin_referer('edit_file_' . $_GET['filename']);
	$file_name = explode('.',$_GET['filename']);
	if ($file_name[1] == 'js')
	{
		$file_name[1] = 'javascript';
	}
	print "<table class='index' width=800 cellpadding=0 cellspacing=0>";
	print "<tr>";
	print "<td class='iheadline' height=21>";
	print "<font class='iheadline'>&nbsp;$StrEditing \"".htmlentities($filename)."\"</font>";
	print "</td>";
	print "<td class='iheadline' align='right' height=21>";
	print "<font class='iheadline'><a href='$base_url&amp;path=".htmlentities(rawurlencode($wp_fileman_path))."'><img src='" . WP_PLUGIN_URL . "/wp-filemanager/icon/back.gif' border=0 alt='$StrBack'></a></font>";
	print "</td>";
	print "</tr>";
	print "<tr>";
	print "<td valign='top' colspan=2>";

	print "<center><br />";

	if ($fp = @fopen($home_directory.$wp_fileman_path.$filename, "rb"))
	{
		print "<form action='" . wp_nonce_url("$base_url&amp;output=edit&amp;save=true'",'edit_save_file_' . $filename) . "' method='post' id='edit_file'>";
		print "\n<textarea cols=120 rows=20 name='text' id='text' class='codepress " . $file_name[1] . "'>";
		if (filesize($home_directory.$wp_fileman_path.$filename) > 0 )
		{
			print htmlentities(fread($fp, filesize($home_directory.$wp_fileman_path.$filename)));
			@fclose ($fp);
		}
		print "</textarea>";

		print "<br /><br />";
		print "$StrFilename <input size=40 name='filename' value=\"".htmlentities($filename)."\">";

		print "<br /><br />";
		print "<input class='bigbutton' id='reset' type='reset' value='$StrRestoreOriginal'>&nbsp;<input class='bigbutton' type='submit' value='$StrSaveAndExit'>";

		print "<input type='hidden' name='path' value=\"".htmlentities($wp_fileman_path)."\">";
		print "</form>";
	}
	else
		print "<font color='#CC0000'>$StrErrorOpeningFile</font>";

	print "<br /><br /></center>";

	print "</td>";
	print "</tr>";
	print "</table>";
}
else
	print "<font color='#CC0000'>$StrAccessDenied</font>";
?>
