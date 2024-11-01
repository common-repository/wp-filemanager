<?php
if ( ! defined( 'ABSPATH' ) )
	die();
if (!@include_once("auth.inc.php"))
 include_once("auth.inc.php");

if (!isset($_GET['sortby'])) $_GET['sortby']	= "filename";
if (!isset($_GET['order'])) $_GET['order']	= "asc";
if (function_exists('get_option') && get_option('wp_fileman_home') == '')
{
	print "<div><h1><b><a href='admin.php?page=wpfileman' style='color:red;'>Please configure the Plugin</a></b></h1></div>";
}
else
{
	print "<div><h1><b>Wordpress FileManager</b></h1></div>";
}
print "<table class='menu' cellpadding=2 cellspacing=0>";
 print "<tr>";
  if ($AllowCreateFolder) print "<td align='center' valign='bottom'><a href='" . wp_nonce_url("$base_url&amp;path=".htmlentities(rawurlencode($wp_fileman_path))."&amp;action=create&amp;type=directory", 'create_directory') . "'><img src='" .WP_PLUGIN_URL . "/wp-filemanager/icon/newfolder.gif' width=20 height=22 alt='$StrMenuCreateFolder' border=0>&nbsp;$StrMenuCreateFolder</a></td>";
  if ($AllowCreateFile) print "<td align='center' valign='bottom'><a href='" . wp_nonce_url("$base_url&amp;path=".htmlentities(rawurlencode($wp_fileman_path))."&amp;action=create&amp;type=file", 'create_file') . "'><img src='" .WP_PLUGIN_URL . "/wp-filemanager/icon/newfile.gif' width=20 height=22 alt='$StrMenuCreateFile' border=0>&nbsp;$StrMenuCreateFile</a></td>";
  if ($AllowUpload) print "<td align='center' valign='bottom'><a href='" . wp_nonce_url("$base_url&amp;path=".htmlentities(rawurlencode($wp_fileman_path))."&amp;action=upload", 'upload_file') . "'><img src='" .WP_PLUGIN_URL . "/wp-filemanager/icon/upload.gif' width=20 height=22 alt='$StrMenuUploadFiles' border=0>&nbsp;$StrMenuUploadFiles</a></td>";
  if ($phpfm_auth) print "<td align='center' valign='bottom'><a href='$base_url&amp;action=logout'><img src='" .WP_PLUGIN_URL . "/wp-filemanager/icon/logout.gif' width=20 height=22 alt='$StrMenuLogOut' border=0>&nbsp;$StrMenuLogOut</a></td>";
 print "</tr>";
print "</table><br />";

print "<table class='index' cellpadding=0 cellspacing=0>";
 print "<tr>";
  print "<td class='iheadline' colspan=4 align='center' height=21>";
   print "<font class='iheadline'>$StrIndexOf&nbsp;".wp_fileman_get_linked_path($wp_fileman_path,$base_url)."</font>";
  print "</td>";
 print "</tr>";
 print "<tr>";
  print "<td>&nbsp;</td>";
  print "<td class='fbborder' valign='top'>";



  if ($open = @opendir($home_directory.$wp_fileman_path))
  {
   for($i=0;($directory = @readdir($open)) != FALSE;$i++)
    if (is_dir($home_directory.$wp_fileman_path.$directory) && $directory != "." && $directory != ".." && !wp_fileman_is_hidden_directory($home_directory.$wp_fileman_path.$directory))
      $directories[$i] = array($directory,$directory);
   closedir($open);

   if (isset($directories))
   {
    sort($directories);
    @reset($directories);
   }
  }

  print "<table class='directories' width=250 cellpadding=1 cellspacing=0>";
   print "<tr>";
    print "<td class='bold' width=20>&nbsp;</td>";
    print "<td class='bold'>&nbsp;$StrFolderNameShort</td>";
    if ($AllowRename) print "<td class='bold' width=20 align='center'>$StrRenameShort</td>";
    if ($AllowDelete) print "<td class='bold' width=20 align='center'>$StrDeleteShort</td>";
   print "</tr>";
   print "<tr>";
    print "<td width=20><a href='$base_url&amp;path=".htmlentities(rawurlencode($wp_fileman_path))."'><img src='" .WP_PLUGIN_URL . "/wp-filemanager/icon/folder.gif' width=20 height=22 alt='$StrOpenFolder' border=0></a></td>";
    print "<td>&nbsp;<a href='$base_url'>.</a></td>";
    print "<td width=20>&nbsp;</td>";
    print "<td width=20>&nbsp;</td>";
   print "</tr>";
   print "<tr>";
    print "<td width=20><a href='$base_url&amp;path=".htmlentities(rawurlencode(dirname($wp_fileman_path)))."/'><img src='" .WP_PLUGIN_URL . "/wp-filemanager/icon/folder.gif' width=20 height=22 alt='$StrOpenFolder' border=0></a></td>";
    print "<td>&nbsp;<a href='$base_url&amp;path=".htmlentities(rawurlencode(dirname($wp_fileman_path)))."/'>..</a></td>";
    print "<td width=20>&nbsp;</td>";
    print "<td width=20>&nbsp;</td>";
   print "</tr>";
  if (isset($directories)) foreach($directories as $directory)
  {
   print "<tr>";
    print "<td width=20><a href='$base_url&amp;path=".htmlentities(rawurlencode($wp_fileman_path.$directory[0]))."/'><img src='" .WP_PLUGIN_URL . "/wp-filemanager/icon/folder.gif' width=20 height=22 alt='$StrOpenFolder' border=0></a></td>";
    print "<td>&nbsp;<a href='$base_url&amp;path=".htmlentities(rawurlencode($wp_fileman_path.$directory[0]))."/'>".htmlentities($directory[0])."</a></td>";
    if ($AllowRename) print "<td width=20><a href='" . wp_nonce_url("$base_url&amp;path=".htmlentities(rawurlencode($wp_fileman_path))."&amp;directory_name=".htmlentities(rawurlencode($directory[0]))."/&amp;action=rename", 'rename_dir_' . basename(stripslashes($directory[0]))) . "'><img src='" . WP_PLUGIN_URL . "/wp-filemanager/icon/rename.gif' width=20 height=22 alt='$StrRenameFolder' border=0></a></td>";
    if ($AllowDelete) print "<td width=20><a href='" . wp_nonce_url("$base_url&amp;path=".htmlentities(rawurlencode($wp_fileman_path))."&amp;directory_name=".htmlentities(rawurlencode($directory[0]))."/&amp;action=delete", 'remove_dir_' . htmlentities(rawurlencode($directory[0]))) . "'><img src='" . WP_PLUGIN_URL . "/wp-filemanager/icon/delete.gif' width=20 height=22 alt='$StrDeleteFolder' border=0></a></td>";
   print "</tr>";
  }
   print "<tr><td colspan=4>&nbsp;</td></tr>";
  print "</table>";

  print "</td>";
  print "<td>&nbsp;</td>";
  print "<td valign='top'>";



  if ($open = @opendir($home_directory.$wp_fileman_path))
  {
   for($i=0;($file = @readdir($open)) != FALSE;$i++)
    if (is_file($home_directory.$wp_fileman_path.$file) && !wp_fileman_is_hidden_file($home_directory.$wp_fileman_path.$file))
    {
     $icon = wp_fileman_get_icon($file);
     $filesize = filesize($home_directory.$wp_fileman_path.$file);
     $permissions = decoct(fileperms($home_directory.$wp_fileman_path.$file)%01000);
     $modified = filemtime($home_directory.$wp_fileman_path.$file);
     $extension = "";
     $files[$i] = array(
                         "icon"        => $icon,
                         "filename"    => $file,
                         "filesize"    => $filesize,
                         "permissions" => $permissions,
                         "modified"    => $modified,
                         "extension"   => $extension,
                       );
    }
   closedir($open);

   if (isset($files))
   {
    @usort($files, "wp_fileman_compare_filedata");
    @reset($files);
   }
  }

  print "<table class='files' width=500 cellpadding=1 cellspacing=0>";
   print "<tr>";
    print "<td class='bold' width=20>&nbsp;</td>";
    print "<td class='bold'>&nbsp;<a href='$base_url&amp;path=".htmlentities(rawurlencode($wp_fileman_path))."&amp;sortby=filename&amp;order=".wp_fileman_get_opposite_order("filename", $_GET['order'])."'>$StrFileNameShort</a></td>";
    print "<td class='bold' width=60 align='center'><a href='$base_url&amp;path=".htmlentities(rawurlencode($wp_fileman_path))."&amp;sortby=filesize&amp;order=".wp_fileman_get_opposite_order("filesize", $_GET['order'])."'>$StrFileSizeShort</a></td>";
    if ($AllowView) print "<td class='bold' width=20 align='center'>$StrViewShort</td>";
    if ($AllowEdit) print "<td class='bold' width=20 align='center'>$StrEditShort</td>";
    if ($AllowRename) print "<td class='bold' width=20 align='center'>$StrRenameShort</td>";
    if ($AllowDownload) print "<td class='bold' width=20 align='center'>$StrDownloadShort</td>";
    if ($AllowDelete) print "<td class='bold' width=20 align='center'>$StrDeleteShort</td>";
   print "</tr>";
  if (isset($files)) foreach($files as $file)
  {
   $file['filesize'] = wp_fileman_get_better_filesize($file['filesize']);
   $file['modified'] = date($ModifiedFormat, $file['modified']);
	
   print "<tr>";
    print "<td width=20><img src='" . WP_PLUGIN_URL . "/wp-filemanager/icon/".$file['icon']."' width=20 height=22 border=0 alt='$StrFile'></td>";
	$f_nm = explode('.',htmlentities($file['filename']));
	print "<td>&nbsp;".$f_nm[0];
	if ($ShowExtension) print "." . $f_nm[1];
	print "</td>";
    print "<td width=60 align='right'>".$file['filesize']."</td>";
    if ($AllowView && wp_fileman_is_viewable_file($file['filename'])) print "<td width=20><a href='" . wp_nonce_url("$base_url&amp;path=".htmlentities(rawurlencode($wp_fileman_path))."&amp;filename=".htmlentities(rawurlencode($file['filename']))."&amp;action=view&amp;size=100", 'view_file_' . htmlentities(rawurlencode($file['filename']))) . "'><img src='" . WP_PLUGIN_URL . "/wp-filemanager/icon/view.gif' width=20 height=22 alt='$StrViewFile' border=0></a></td>";
    else if ($AllowView) print "<td width=20>&nbsp;</td>";
    if ($AllowEdit && wp_fileman_is_editable_file($file['filename'])) print "<td width=20><a href='" . wp_nonce_url("$base_url&amp;path=".htmlentities(rawurlencode($wp_fileman_path))."&amp;filename=".htmlentities(rawurlencode($file['filename']))."&amp;action=edit", 'edit_file_' . htmlentities(rawurlencode($file['filename']))) . "'><img src='" . WP_PLUGIN_URL . "/wp-filemanager/icon/edit.gif' width=20 height=22 alt='$StrEditFile' border=0></a></td>";
	else if ($AllowEdit) print "<td width=20>&nbsp;</td>";
    if ($AllowRename) print "<td width=20><a href='" . wp_nonce_url("$base_url&amp;path=".htmlentities(rawurlencode($wp_fileman_path))."&amp;filename=".htmlentities(rawurlencode($file['filename']))."&amp;action=rename", 'rename_file_' . htmlentities(rawurlencode($file['filename']))) . "'><img src='" . WP_PLUGIN_URL . "/wp-filemanager/icon/rename.gif' width=20 height=22 alt='$StrRenameFile' border=0></a></td>";
    if ($AllowDownload) print "<td width=20><a href='" . wp_nonce_url("$base_url&amp;path=".htmlentities(rawurlencode($wp_fileman_path))."&amp;filename=".htmlentities(rawurlencode($file['filename']))."&amp;action=download", 'download_file') . "'><img src='" . WP_PLUGIN_URL . "/wp-filemanager/icon/download.gif' width=20 height=22 alt='$StrDownloadFile' border=0></a></td>";
    if ($AllowDelete) print "<td width=20><a href='" . wp_nonce_url("$base_url&amp;path=".htmlentities(rawurlencode($wp_fileman_path))."&amp;filename=".htmlentities(rawurlencode($file['filename']))."&amp;action=delete", 'delete_file') . "'><img src='" . WP_PLUGIN_URL . "/wp-filemanager/icon/delete.gif' width=20 height=22 alt='$StrDeleteFile' border=0></a></td>";
   print "</tr>";

  }
   print "<tr><td colspan=9>&nbsp;</td></tr>";
  print "</table>";


  print "</td>";
 print "</tr>";
print "</table>";
?>
