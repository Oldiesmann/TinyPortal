<?php
/**
 * @package TinyPortal
 * @version 1.5.0
 * @author IchBin - http://www.tinyportal.net
 * @founder Bloc
 * @license MPL 2.0
 *
 * The contents of this file are subject to the Mozilla Public License Version 2.0
 * (the "License"); you may not use this package except in compliance with
 * the License. You may obtain a copy of the License at
 * http://www.mozilla.org/MPL/
 *
 * Copyright (C) 2018 - The TinyPortal Team
 *
 */

function template_main()
{
	global $context, $settings, $options, $txt, $scripturl, $modSettings, $boarddir, $boardurl;

	echo '
<div>
<script>
$(document).ready( function() {
var $clickme = $(".clickme"),
    $box = $(".box");

$box.hide();

$clickme.click( function(e) {
    $(this).text(($(this).text() === "Hide" ? "More" : "Hide")).next(".box").slideToggle();
    e.preventDefault();
});
});
</script>	
</div>';
	// setup the screen
	echo '
<div id="dl_adminbox" class="admin-area">
	<form accept-charset="', $context['character_set'], '"  name="dl_admin" action="'.$scripturl.'?action=tpmod;dl=admin" enctype="multipart/form-data" method="post" onsubmit="submitonce(this);">	';

	if($context['TPortal']['dlsub'] == 'admin')
	{
		echo '
		<div id="user-downloads" class="tborder dladmin bigger-width">
			<div class="catbg addborderleft" style="padding:0px;">
				<div class="float-items pos" style="width:14%;">x</div>
				<div class="float-items name" style="width:26%;">'.$txt['tp-dlname'].'</div>
				<div class="float-items title-admin-area" style="width:5%;">'.$txt['tp-dlicon'].'</div>
				<div class="float-items title-admin-area" style="width:14%;">'.$txt['tp-dlfiles'].'</div>
				<div class="float-items title-admin-area" style="width:14%;">'.$txt['tp-dlsubmitted'].'</div>
				<div class="float-items title-admin-area" style="width:14%;">'.$txt['tp-dledit'].'</div>
				<p class="clearthefloat"></p>
			</div>';
			// output all the categories, sort after childs
		if(isset($context['TPortal']['admcats']) && count( $context['TPortal']['admcats'] ) > 0)
		{
			foreach($context['TPortal']['admcats'] as $cat)
			{
				if($cat['parent'] == 0) {
					echo '
			<div class="windowbg addborder">
				<div class="adm-pos float-items" style="width:14%;">
				  <input name="tp_dlcatpos'.$cat['id'].'" size="2" type="text" value="'.$cat['pos'].'">
				</div>
				<div class="adm-name float-items" style="width:27%;">
				  <img src="' .$settings['tp_images_url'].'/TPboard.gif" alt="" align="top" border="0" style="margin: 0;" /> <a href="'.$cat['href'].'">'.$cat['name'].'</a>
				</div>
				<a href="" class="clickme">More</a>
			    <div class="box" style="width:55%;float:left;">
				  <div class="fullwidth-on-res-layout float-items" style="width:10%;">
				    <div id="show-on-respnsive-layout">'.$txt['tp-dlicon'].'</div>
				    ', !empty($cat['icon']) ? '<img src="'.$cat['icon'].'" alt="" />' : '', '
				  </div>
				  <div class="fullwidth-on-res-layout float-items" style="width:28%;">
				    <div id="show-on-respnsive-layout">'.$txt['tp-dlfiles'].'</div>
				    '.$cat['items'].'
				  </div>
				  <div class="fullwidth-on-res-layout float-items" style="width:28%;">
				    <div id="show-on-respnsive-layout">'.$txt['tp-dlsubmitted'].'</div>
				    '.$cat['submitted'].'
				  </div>
				  <div class="fullwidth-on-res-layout float-items" style="width:26%;">
				    <div id="show-on-respnsive-layout" style="word-break: break-all;">'.$txt['tp-dledit'].'</div>
					<a href="',$scripturl, '?action=tpmod;dl=cat', $cat['id'], '"><img title="'.$txt['tp-preview'].'" src="'.$settings['tp_images_url'].'/TPfilter.gif" alt="" /></a>
					<a href="'.$cat['href2'].'"><img title="'.$txt['tp-edit'].'" border="0" src="'.$settings['tp_images_url'].'/TPconfig_sm.gif" alt="'.$txt['tp-edit'].'"  /></a>
					<a href="'.$cat['href3'].'" onclick="javascript:return confirm(\''.$txt['tp-confirmdelete'].'\')"><img title="delete" border="0" src="'.$settings['tp_images_url'].'/TPdelete2.gif" alt=""  /></a>
				 </div>
				 <p class="clearthefloat"></p>
			   </div><p class="clearthefloat"></p>
			</div>';
				}
			}
		}
		echo '
				<div align="center" class="windowbg" style="padding:1%;"><input name="dlsend" type="submit" value="'.$txt['tp-submit'].'"></div>';
	} // Settings
	elseif($context['TPortal']['dlsub'] == 'adminsettings') {
		echo '
		<div id="dl-settings" class="tborder">
			<div class="titlebg" style="padding:1%;">
				<div>'.$txt['tp-dlsettings'].'</div>
			</div>
			<div class="windowbg2" style="padding:1%;">
				<div class="font-strong">'.$txt['tp-dlallowedtypes'].' :</div>
				<div>
					<input style="width: 95%;" name="tp_dl_allowed_types" type="text" value="'.$context['TPortal']['dl_allowed_types'].'">
				</div>
			</div>
			<div class="windowbg2" style="padding:1%;">
				<div class="font-strong">'.$txt['tp-dluselatest'].' :</div>
				<div>
					<input name="tp_dl_showrecent" type="radio" value="1" ', $context['TPortal']['dl_showlatest'] == '1' ? 'checked' : '', '> '.$txt['tp-yes'].'&nbsp;&nbsp;
					<input name="tp_dl_showrecent" type="radio" value="0" ', $context['TPortal']['dl_showlatest'] == '0' ? 'checked' : '', '> '.$txt['tp-sayno'].'
				</div>
			</div>
			<div class="windowbg2" style="padding:1%;">
				<div class="font-strong">'.$txt['tp-dlusestats'].' :</div>
				<div>
					<input name="tp_dl_showstats" type="radio" value="1" ', $context['TPortal']['dl_showstats'] == '1' ? 'checked' : '', '> '.$txt['tp-yes'].'&nbsp;&nbsp;
					<input name="tp_dl_showstats" type="radio" value="0" ', $context['TPortal']['dl_showstats'] == '0' ? 'checked' : '', '> '.$txt['tp-sayno'].'
				</div>
			</div>
			<div class="windowbg2" style="padding:1%;">
				<div class="font-strong">'.$txt['tp-dlwysiwyg'].' :</div>
				<div>
					<input name="tp_dl_wysiwyg" type="radio" value="" ', $context['TPortal']['dl_wysiwyg'] == '' ? 'checked' : '', '> '.$txt['tp-no'].'<br />
					<input name="tp_dl_wysiwyg" type="radio" value="html" ', $context['TPortal']['dl_wysiwyg'] == 'html' ? 'checked' : '', '> '.$txt['tp-yes'].', HTML<br />
					<input name="tp_dl_wysiwyg" type="radio" value="bbc" ', $context['TPortal']['dl_wysiwyg'] == 'bbc' ? 'checked' : '', '> '.$txt['tp-yes'].', BBC
				</div>
			</div>
			<div class="windowbg2" style="padding:1%;">
				<div class="font-strong">'.$txt['tp-dlusecategorytext'].' :</div>
				<div>
					<input name="tp_dl_showcategorytext" type="radio" value="1" ', $context['TPortal']['dl_showcategorytext'] == '1' ? 'checked' : '', '> '.$txt['tp-yes'].'&nbsp;&nbsp;
					<input name="tp_dl_showcategorytext" type="radio" value="0" ', $context['TPortal']['dl_showcategorytext'] == '0' ? 'checked' : '', '> '.$txt['tp-sayno'].'
				</div>
			</div>
			<div class="windowbg2" style="padding:1%;">
				<div class="font-strong">'.$txt['tp-dlusefeatured'].' :</div>
				<div>
					<input name="tp_dl_showfeatured" type="radio" value="1" ', $context['TPortal']['dl_showfeatured'] == '1' ? 'checked' : '', '> '.$txt['tp-yes'].'&nbsp;&nbsp;
					<input name="tp_dl_showfeatured" type="radio" value="0" ', $context['TPortal']['dl_showfeatured'] == '0' ? 'checked' : '', '> '.$txt['tp-sayno'].'
				</div>
			</div>
			<div class="windowbg2" style="padding:1%;">
				<div class="font-strong">'.$txt['tp-dlfeatured'].' :</div>
				<div>
					<select name="tp_dl_featured" size="7">';

				foreach($context['TPortal']['all_dlitems'] as $item)
				{
					echo '<option value="'.$item['id'].'"', $context['TPortal']['dl_featured'] == $item['id'] ? ' selected="selected"' : '', '>'.$item['name'].'</option>';
				}
				
				echo '
					</select>
				</div>
			</div>
			<div class="windowbg" style="padding:1%;">
				<div>
				   <div class="font-strong">'.$txt['tp-dlintrotext'].'</div>';
				
				if($context['TPortal']['dl_wysiwyg'] == 'html')
					TPwysiwyg( 'tp_dl_introtext', $context['TPortal']['dl_introtext'], true, 'qup_tp_dl_introtext', isset($context['TPortal']['usersettings']['wysiwyg']) ? $context['TPortal']['usersettings']['wysiwyg'] : 0 );
				elseif($context['TPortal']['dl_wysiwyg'] == 'bbc')
					TP_bbcbox( $context['TPortal']['editor_id'] );
				else
					echo '<textarea name="tp_dl_introtext" style="width: 99%; height: 300px;">'.$context['TPortal']['dl_introtext'].'</textarea>';
			
				echo '</div>
			</div>
			<div class="windowbg2" style="padding:1%;">
					<div class="font-strong">'.$txt['tp-dlusescreenshot'].' :</div>
					<div>
					 <input name="tp_dl_usescreenshot" type="radio" value="1" ', $context['TPortal']['dl_usescreenshot'] == '1' ? 'checked' : '', '> '.$txt['tp-yes'].'&nbsp;&nbsp;
					 <input name="tp_dl_usescreenshot" type="radio" value="0" ', $context['TPortal']['dl_usescreenshot'] == '0' ? 'checked' : '', '> '.$txt['tp-sayno'].'
			        </div>
			</div>
			<div class="windowbg2" style="padding:1%;">
				<div class="font-strong">'.$txt['tp-dlscreenshotsizes'].' :</div>
				<div>
					<input name="tp_dl_screenshotsize0" type="text" size="3" maxsize="3" value="'.$context['TPortal']['dl_screenshotsize'][0].'"> x <input name="tp_dl_screenshotsize1" type="text" size="3" maxsize="3" value="'.$context['TPortal']['dl_screenshotsize'][1].'"> px<br />
					<input name="tp_dl_screenshotsize2" type="text" size="3" maxsize="3" value="'.$context['TPortal']['dl_screenshotsize'][2].'"> x <input name="tp_dl_screenshotsize3" type="text" size="3" maxsize="3" value="'.$context['TPortal']['dl_screenshotsize'][3].'"> px<br />
					<input name="tp_dl_screenshotsize4" type="text" size="3" maxsize="3" value="'.$context['TPortal']['dl_screenshotsize'][4].'"> x <input name="tp_dl_screenshotsize5" type="text" size="3" maxsize="3" value="'.$context['TPortal']['dl_screenshotsize'][5].'"> px<br />
				</div>
			</div>
			<div class="windowbg2" style="padding:1%;">
				<div class="font-strong">'.$txt['tp-dlmustapprove'].' :</div>
				<div>
					<input name="tp_dl_approveonly" type="radio" value="1" ', $context['TPortal']['dl_approve'] == '1' ? 'checked' : '', '> '.$txt['tp-approveyes'].'&nbsp;&nbsp;
					<input name="tp_dl_approveonly" type="radio" value="0" ', $context['TPortal']['dl_approve'] == '0' ? 'checked' : '', '> '.$txt['tp-approveno'].'
				</div>
			</div>
			<div class="windowbg2" style="padding:1%;">
				<div class="font-strong">'.$txt['tp-dlcreatetopic'].' :</div>
				<div>
					<input name="tp_dl_createtopic" type="radio" value="1" ', $context['TPortal']['dl_createtopic'] == '1' ? 'checked' : '', '> '.$txt['tp-yes'].'&nbsp;&nbsp;
					<input name="tp_dl_createtopic" type="radio" value="0" ', $context['TPortal']['dl_createtopic'] == '0' ? 'checked' : '', '> '.$txt['tp-no'].'
				</div>
			</div>
			<div class="windowbg" style="padding:1%;">
				<div>
				  <h4 style="margin-bottom: 0;">'.$txt['tp-dlcreatetopicboards'].'</h4>
				 ', tp_hidepanel( 'dl_createboard' ), '
				 <div class="dl_perm" id="dl_createboard" ' , in_array( 'dl_createboard', $context['tp_panels'] ) ? ' style="display: none;"' : '', '>
					';
					$brds = explode( ",", $context['TPortal']['dl_createtopic_boards'] );
					foreach($context['TPortal']['boards'] as $brd)
						echo '<div class="perm"><input type="checkbox" value="'.$brd['id'].'" name="tp_dlboards'.$brd['id'].'" ', in_array( $brd['id'], $brds ) ? ' checked="checked"' : '', ' /> '.$brd['name'].'</div>';
				
					echo '<br style="clear: both;" />
				</div></div>
			</div>
			<div class="windowbg2" style="padding:1%;">
				<div class="font-strong">'.$txt['tp-dlallowedsize'].' :</div>
				<div>
					<input name="tp_dluploadsize" type="text" value="'.$context['TPortal']['dl_max_upload_size'].'"> Kb
				</div>
			</div>
			<div class="windowbg2" style="padding:1%;">
				<div class="font-strong">'.$txt['tp-dlshowlatest'].'</div>
				<div>
					<input name="tp_dlshowlatest" type="radio" value="1" ', $context['TPortal']['dl_showlatest'] == '1' ? 'checked' : '', '> '.$txt['tp-yes'].'&nbsp;&nbsp;
					<input name="tp_dlshowlatest" type="radio" value="0" ', $context['TPortal']['dl_showlatest'] == '0' ? 'checked' : '', '> '.$txt['tp-sayno'].'
				</div>
			</div>
			<div class="windowbg2" style="padding:1%;">
				<div class="font-strong">'.$txt['tp-dluseformat'].'</div>
				<div>
					<input name="tp_dl_fileprefix" type="radio" value="K" ', $context['TPortal']['dl_fileprefix'] == 'K' ? 'checked' : '', '> Kb<br />
					<input name="tp_dl_fileprefix" type="radio" value="M" ', $context['TPortal']['dl_fileprefix'] == 'M' ? 'checked' : '', '> Mb<br />
					<input name="tp_dl_fileprefix" type="radio" value="G" ', $context['TPortal']['dl_fileprefix'] == 'G' ? 'checked' : '', '> Gb<br />
				</div>
			</div>
			<div class="windowbg2" style="padding:1%;">
				<div class="font-strong">'.$txt['tp-dlvisualoptions'].'</div>
				<div>
					<input name="tp_dl_visual_options1" type="checkbox" value="left" ', isset($context['TPortal']['dl_left']) ? 'checked' : '', '> '.$txt['tp-leftbar'].'<br />
					<input name="tp_dl_visual_options2" type="checkbox" value="right" ', isset($context['TPortal']['dl_right']) ? 'checked' : '', '> '.$txt['tp-rightbar'].'<br />
					<input name="tp_dl_visual_options3" type="checkbox" value="center" ', isset($context['TPortal']['dl_center']) ? 'checked' : '', '> '.$txt['tp-centerbar'].'<br />
					<input name="tp_dl_visual_options4" type="checkbox" value="top" ', isset($context['TPortal']['dl_top']) ? 'checked' : '', '> '.$txt['tp-topbar'].'<br />
					<input name="tp_dl_visual_options5" type="checkbox" value="bottom" ', isset($context['TPortal']['dl_bottom']) ? 'checked' : '', '> '.$txt['tp-bottombar'].'<br />
					<input name="tp_dl_visual_options6" type="checkbox" value="lower" ', isset($context['TPortal']['dl_lower']) ? 'checked' : '', '> '.$txt['tp-lowerbar'].'<br />
					<input name="tp_dl_visual_options7" type="checkbox" value="showtop" ', isset($context['TPortal']['dl_showtop']) ? 'checked' : '', '> '.$txt['tp-showtop'].'<br />
					<input name="tp_dl_visual_options8" type="hidden" value="not">
				</div>
            </div>
            <div class="windowbg2" style="padding:1%;">
			   <div align="center">
				',$txt['tp-chosentheme'], ' 
				<select size="1" name="tp_dltheme">';
  					echo '<option value="0" ', $context['TPortal']['dlmanager_theme'] == '0' ? 'selected' : '', '>'.$txt['tp-noneicon'].'</option>';
				
				foreach($context['TPthemes'] as $them)
  					echo '<option value="'.$them['id'].'" ', $them['id'] == $context['TPortal']['dlmanager_theme'] ? 'selected' : '', '>'.$them['name'].'</option>';

				echo '
				</select>
			   </div>
			</div>
			<div align="center" class="windowbg" style="padding:1%;">
				<input type="hidden" name="dlsettings" value="1" />
				<input name="dlsend" type="submit" value="'.$txt['tp-submit'].'">
			</div>';
	}
	elseif(substr( $context['TPortal']['dlsub'], 0, 8 ) == 'admincat')
	{
		$mycat = substr( $context['TPortal']['dlsub'], 8 );
		// output any subcats
		echo '
		<div id="any-subcats" class="tborder bigger-width">
			<div class="catbg addborderleft" style="padding:0px;font-size:100%;">
				<div style="width:30%;" class="float-items pos">'.$txt['tp-dlname'].'</div>
				<div style="width:5%;" class="float-items title-admin-area">'.$txt['tp-dlicon'].'</div>
				<div style="width:19%;" class="float-items title-admin-area">'.$txt['tp-dlviews'].'</div>
				<div style="width:26%;" class="float-items title-admin-area">'.$txt['tp-dlfile'].'</div>
				<div style="width:9%;" class="float-items title-admin-area">'.$txt['tp-dlfilesize'].'</div>
				<p class="clearthefloat"></p>
			</div>';
		if(isset($context['TPortal']['admcats']) && count( $context['TPortal']['admcats'] ) > 0)
		{
			foreach($context['TPortal']['admcats'] as $cat)
			{
				if($cat['parent'] == $mycat)
					echo '
			  <div class="windowbg" style="padding-top:1%;">
			    <div class="fullwidth-on-res-layout float-items" style="width:30%;">
				  <div style="width:25%;" class="float-items">
				     <input name="tp_dlcatpos'.$cat['id'].'" size="2" type="text" value="'.$cat['pos'].'">
				     <input type="hidden" name="admineditcatval" value="'.$cat['parent'].'" />
				  </div>
				  <div style="width:71%;" class="float-items windowbg">
				    <img src="' .$settings['tp_images_url'].'/TPboard.gif" alt="" align="top" border="0" style="margin: 0;" /> <a href="'.$cat['href'].'">'.$cat['name'].'</a>
				  </div>
				  <p class="clearthefloat"></p>
			    </div>
			    <div style="width:5%;" class="fullwidth-on-res-layout float-items">
				   <div id="show-on-respnsive-layout">'.$txt['tp-dlicon'].'</div>
				   ', !empty($cat['icon']) ? '<img src="'.$cat['icon'].'" alt="" />' : '', '
			    </div>
			    <div style="width:20%;" class="fullwidth-on-res-layout float-items">	
			      <div id="show-on-respnsive-layout" style="word-break:break-all;">'.$txt['tp-dlviews'].'</div>
				  <div id="size-on-respnsive-layout"><div style="width:48%;" class="float-items windowbg" align="center"> 
				    '.$cat['items'].'
				  </div>
				  <div style="width:48%;" class="float-items windowbg" align="center">
				    '.$cat['submitted'].'
				  </div>
				  <p class="clearthefloat"></p>
			    </div></div>
				<div style="width:37%;" class="fullwidth-on-res-layout float-items">
				    <div id="show-on-respnsive-layout" style="margi-left:1%;">'.$txt['tp-dlfile'].'</div>
					<a href="',$scripturl, '?action=tpmod;dl=cat', $cat['id'], '"><img title="'.$txt['tp-preview'].'" src="'.$settings['tp_images_url'].'/TPfilter.gif" alt="" /></a>
					<a href="'.$cat['href2'].'"><img title="'.$txt['tp-edit'].'" border="0" src="'.$settings['tp_images_url'].'/TPconfig_sm.gif" alt="'.$txt['tp-edit'].'"  /></a>
					<a href="'.$cat['href3'].'" onclick="javascript:return confirm(\''.$txt['tp-confirmdelete'].'\')"><img title="delete" border="0" src="'.$settings['tp_images_url'].'/TPdelete.gif" alt=""  /></a>
				</div><p class="clearthefloat"></p>
			</div>';
			}
		}
// output any subcats files
		if(isset($context['TPortal']['dl_admitems']) && count( $context['TPortal']['dl_admitems'] ) > 0)
		{
			foreach($context['TPortal']['dl_admitems'] as $cat)
			{
				echo '
			<div id="up-file" class="windowbg2 bigger-width">
				<div style="width:30%;" class="fullwidth-on-res-layout float-items">
					<a href="',$scripturl, '?action=tpmod;dl=item', $cat['id'], '"><img title="'.$txt['tp-preview'].'" src="'.$settings['tp_images_url'].'/TPfilter.gif" alt="" /></a>
					<a href="'.$cat['href'].'">'.$cat['name'].'</a>
				</div>
				<div style="width:5.5%;" class="fullwidth-on-res-layout float-items">
				  <div id="show-on-respnsive-layout">'.$txt['tp-dlicon'].'</div>
				   ', !empty($cat['icon']) ? '<img src="'.$cat['icon'].'" alt="" />' : '', '
				</div>
			    <div class="fullwidth-on-res-layout float-items" style="width:19%;">
				   <div id="show-on-respnsive-layout" style="word-break:break-all;">'.$txt['tp-dlviews'].'</div>			
				   <div id="size-on-respnsive-layout"><div style="width:48%;" class="float-items" align="center">
				    '.$cat['views'].'
				   </div>
				   <div style="width:48%;" class="float-items" align="center">
				    '.$cat['downloads'].'
				   </div>
				   <p class="clearthefloat"></p></div>
			    </div>
			    <div class="fullwidth-on-res-layout float-items" style="width:26%;">
			      <div id="show-on-respnsive-layout">'.$txt['tp-dlfile'].'</div>
				  <div id="size-on-respnsive-layout"><div style="width:48%;word-break:break-all;" class="float-items">
				   '.$cat['file'].'
				  </div>
				  <div style="width:48%;" class="float-items">
				   by '.$cat['author'].'
				  </div>
				  <p class="clearthefloat"></p></div>
			    </div>
			    <div style="width:9.5%;" class="fullwidth-on-res-layout float-items">
				  <div id="show-on-respnsive-layout">'.$txt['tp-dlfilesize'].'</div>
				  '. $cat['filesize'].'kb
				</div>
				<p class="clearthefloat"></p>
			  </div>';
			}
		}
		echo '
				<div style="padding:1%;" align="center" class="windowbg3"><input name="dlsend" type="submit" value="'.$txt['tp-submit'].'"></div>';
	}
	elseif(substr( $context['TPortal']['dlsub'], 0, 9 ) == 'adminitem')
	{
		if(isset($context['TPortal']['dl_admitems']) && count( $context['TPortal']['dl_admitems'] ) > 0)
		{
			foreach($context['TPortal']['dl_admitems'] as $cat) {
				// Edit uploaded file 
				echo ' 
		<div class="tborder windowbg2" id="edit-up-item" style="word-break:break-all;">
		      <div style="border-bottom: 1px solid #ccc;">
				<div class="float-items" align="right" style="width:31%;">
					<a href="'.$scripturl.'?action=tpmod;dl=item'.$cat['id'].'">['.$txt['tp-preview'].']</a>
					'.$txt['tp-dluploadtitle'].'
				</div>
				<div class="float-items" style="width:65%;">
				  <input style="width: 30ex;max-width:98%!important;" name="dladmin_name'.$cat['id'].'" type="text" value="'.$cat['name'].'">
				</div>
			    <p class="clearthefloat"></p>
			 </div>
			 <div class="windowbg2" style="padding:1%;">
					<br />';

				if($context['TPortal']['dl_wysiwyg'] == 'html')
					TPwysiwyg( 'dladmin_text'.$cat['id'], $cat['description'], true, 'qup_dladmin_text', isset($context['TPortal']['usersettings']['wysiwyg']) ? $context['TPortal']['usersettings']['wysiwyg'] : 0 );
				elseif($context['TPortal']['dl_wysiwyg'] == 'bbc')
					TP_bbcbox( $context['TPortal']['editor_id'] );
				else
					echo '<textarea name="dladmin_text'.$cat['id'].'" style="width: 99%; height: 300px;max-width:98%!important;">'.$cat['description'].'</textarea>';

	
				echo '
			</div>
			<div style="border-bottom: 1px solid #ccc;">
				 <div class="windowbg2 float-items" align="right" style="width:31%;">'.$txt['tp-dluploadicon'].'</div>
				 <div class="windowbg2 float-items" style="width:65%;">
					<select size="1" name="dladmin_icon'.$cat['id'].'" onchange="dlcheck(this.value)">';

				echo '
						<option value="blank.gif">'.$txt['tp-noneicon'].'</option>';

				// output the icons
				$selicon = substr( $cat['icon'], strrpos( $cat['icon'], '/' ) + 1 );
				foreach($context['TPortal']['dlicons'] as $dlicon => $value)
					echo '
						<option ' , ($selicon == $value) ? 'selected="selected" ' : '', 'value="'.$value.'">'.$value.'</option>';

				echo '
					</select>
					<br /><br /><img name="dlicon" src="'.$cat['icon'].'" alt="" />
					<script type="text/javascript">
					function dlcheck(icon)
						{
							document.dlicon.src= "'.$boardurl.'/tp-downloads/icons/" + icon
						}
					</script>
				  </div><p class="clearthefloat"></p>
				</div>
				<div style="border-bottom: 1px solid #ccc;">
				 <div class="windowbg2 float-items" align="right" style="width:31%;">'.$txt['tp-dlviews'].':</div>
				 <div class="windowbg2 float-items" style="width:65%;">'.$cat['views'].' / '.$cat['downloads'].'</div>
				 <p class="clearthefloat"></p>
			    </div>
				<div style="border-bottom: 1px solid #ccc;">
				 <div class="windowbg2 float-items" align="right" style="width:31%;">'.$txt['tp-dlfilename'].'</div>
				 <div class="windowbg2 float-items" style="width:65%;">';
		if($cat['file'] == '- empty item -' || $cat['file'] == '- empty item - ftp') {	
			if($cat['file'] == '- empty item - ftp')
				echo '<div style="padding: 5px 0 5px 0; font-weight: bold;">'.$txt['tp-onlyftpstrays'].'</div>';
				
			echo '
					<select size="1" name="dladmin_file'.$cat['id'].'" style="max-width:100%;">
						<option value="">' . $txt['tp-noneicon'].'</option>';
					
			foreach($context['TPortal']['tp-downloads'] as $file)
			{
				if($cat['file'] == '- empty item - ftp')
				{
					// check the file against
					if(!in_array( $file['file'], $context['TPortal']['dl_allitems'] ))
		  				echo '
						<option value="'.$file['file'].'">'.$file['file'].' - '.$file['size'].'Kb</option>';
				}
				else
	  				echo '
				  		<option value="'.$file['file'].'">'.$file['file'].' - '.$file['size'].'Kb</option>';
			}
			echo '
					</select>';
		}
		else
			echo '<input name="dladmin_file'.$cat['id'].'" type="text" style="margin-bottom: 0.5em" value="'.$cat['file'].'">';

		echo '<br /><a href="'.$scripturl.'?action=tpmod;dl=get'.$cat['id'].'">['.$txt['tp-download'].']</a>
				</div><p class="clearthefloat"></p>
			</div>
			<div style="border-bottom: 1px solid #ccc;">
				<div class="windowbg2 float-items" align="right" style="width:31%;">'.$txt['tp-uploadnewfileexisting'].':</div>
				<div class="windowbg2 float-items" style="width:65%;">
					<input name="tp_dluploadfile_edit" style="width: 90%;" type="file" value="">
					<input name="tp_dluploadfile_editID" type="hidden" value="'.$cat['id'].'">
				</div><p class="clearthefloat"></p>
			</div>
			<div style="border-bottom: 1px solid #ccc;">
				<div class="windowbg2 float-items" align="right" style="width:31%;">&nbsp;</div>
				<div class="windowbg2 float-items" style="width:65%;"><input style="vertical-align: middle;" name="dladmin_delete'.$cat['id'].'" type="checkbox" value="ON" onclick="javascript:return confirm(\''.$txt['tp-confirm'].'\')"> <b>'.$txt['tp-dldelete'].'</b></div>
			    <p class="clearthefloat"></p>
			</div>	
			<div style="border-bottom: 1px solid #ccc;">
				<div class="windowbg2 float-items" align="right" style="width:31%;">&nbsp;</div>
				<div class="windowbg2 float-items" style="width:65%;">
				 <input name="dladmin_size'.$cat['id'].'" readonly type="text" value="'.($cat['filesize'] * 1024).'"> bytes
				</div><p class="clearthefloat"></p>
			</div>	
			<div style="border-bottom: 1px solid #ccc;">
				<div class="windowbg2 float-items" align="right" style="width:31%;">'.$txt['tp-uploadedby'].':</div>
				<div class="windowbg2 float-items" style="width:65%;">'.$context['TPortal']['admcurrent']['member'].'</div>
			    <p class="clearthefloat"></p>
			</div>	
			<div style="border-bottom: 1px solid #ccc;">	
					' , $cat['approved'] == '0' ? '
				<div class="windowbg2 float-items" align="right" style="width:31%;">
				  <img title="'.$txt['tp-approve'].'" border="0" src="'.$settings['tp_images_url'].'/TPthumbup.gif" alt="'.$txt['tp-dlapprove'].'"  /> 
				</div>
				<div class="windowbg2 float-items" style="width:65%;">
					<input style="vertical-align: middle;" name="dl_admin_approve'.$cat['id'].'" type="checkbox" value="ON"><b> '.$txt['tp-dlapprove'].'</b>
				</div>' : '', ' ';
			}
		}
		// any extra files?
		if(isset($cat['subitem']) && sizeof( $cat['subitem'] ) > 0)
		{
		echo '<p class="clearthefloat"></p>
		</div>
		<div style="border-bottom: 1px solid #ccc;">
				<div class="windowbg2 float-items" align="right" style="width:31%;">'.$txt['tp-dlmorefiles'].'</div>
				<div class="windowbg2 float-items" style="width:65%;">';
			foreach($cat['subitem'] as $sub)
			{
				echo '<div><b><a href="', $sub['href'], '">', $sub['name'], '</a></b> (', $sub['file'], ')
						', $sub['filesize'], ' &nbsp;&nbsp;<br /><input style="vertical-align: middle;" name="dladmin_delete'.$sub['id'].'" type="checkbox" value="ON" onclick="javascript:return confirm(\''.$txt['tp-confirm'].'\')"> '.$txt['tp-dldelete'].'
						&nbsp;&nbsp;<input style="vertical-align: middle;" name="dladmin_subitem'.$sub['id'].'" type="checkbox" value="0"> '.$txt['tp-dlattachloose'].'
						<br /><br /></div>';
			}
		echo '
				</div>';
		}
		// no, but maybe it can be a additional file itself?
		else
		{
			echo '<p class="clearthefloat"></p>
			 </div>
			 <div style="border-bottom: 1px solid #ccc;">
				<div class="windowbg2 float-items" align="right" style="width:31%;"><b>'.$txt['tp-dlmorefiles2'].'</b></div>
				<div class="windowbg2 float-items" style="width:65%;">
					<select size="1" name="dladmin_subitem'.$cat['id'].'" style="margin-top: 4px;">
						<option value="0" selected>'.$txt['tp-no'].'</option>';

		foreach($context['TPortal']['admitems'] as $subs) {
					echo '
						<option value="'.$subs['id'].'">'.$txt['tp-yes'].', '.$subs['name'].'</option>';
		}
		echo '
					</select>
			  </div>';

		}
		// which category?
		echo '<p class="clearthefloat"></p>
		   </div>
		   <div style="border-bottom: 1px solid #ccc;">
				<div class="windowbg2 float-items" align="right" style="width:31%;">'.$txt['tp-dluploadcategory'].'</div>
				<div class="windowbg2 float-items" style="width:65%;">
					<select size="1" name="dladmin_category'.$cat['id'].'" style="margin-top: 4px;max-width:100%;">';

		foreach($context['TPortal']['admuploadcats'] as $ucats) {
			echo '
						<option value="'.$ucats['id'].'" ', $ucats['id'] == abs( $cat['category'] ) ? 'selected' : '', '>', (!empty($ucats['indent']) ? str_repeat( "-", $ucats['indent'] ) : ''), ' '.$ucats['name'].'</option>';
		}
		echo '
					</select>
			   </div><p class="clearthefloat"></p>
		   </div>
		   <div style="border-bottom: 1px solid #ccc;">
				<div class="windowbg2 float-items" align="right" style="width:31%;">'.$txt['tp-uploadnewpic'].':</div>
				<div class="windowbg2 float-items" style="width:65%;">
					<input name="tp_dluploadpic_edit" style="width: 90%;" type="file" value="">
					<input name="tp_dluploadpic_editID" type="hidden" value="'.$cat['id'].'">
				</div>
			    <p class="clearthefloat"></p>
			</div>
			<div style="border-bottom: 1px solid #ccc;">
				<div class="windowbg2 float-items" align="right" style="width:31%;">'.$txt['tp-uploadnewpicexisting'].':</div>
				<div class="windowbg2 float-items" style="width:65%;">
					<input style="max-width:98%!important;" name="tp_dluploadpic_link" size="60" type="text" value="'.$cat['screenshot'].'"><br /><br />
					<div style="overflow: auto;">' , $cat['sshot'] != '' ? '<img src="'.$cat['sshot'].'" alt="" />' : '&nbsp;', '</div>
				</div>
			<p class="clearthefloat"></p>
		   </div>
		   <div class="windowbg" style="padding:1%;"><input name="dlsend" type="submit" value="'.$txt['tp-submit'].'"></div>
			';
	}
	// any submitted items? - submission
	elseif($context['TPortal']['dlsub'] == 'adminsubmission')
	{
		echo '
		<div id="any-submitted" class="tborder windowbg2 bigger-width">
			<div class="titlebg addborderleft">
				<div class="name float-items" style="width:18%;">'.$txt['tp-dlname'].'</div>
				<div class="title-admin-area float-items" style="width:18%;">'.$txt['tp-dlfilename'].'</div>
				<div class="title-admin-area float-items" style="width:18%;">'.$txt['tp-created'].'</div>
				<div class="title-admin-area float-items" style="width:18%;">'.$txt['tp-uploadedby'].'</div>
				<div class="title-admin-area float-items" style="width:17%;">'.$txt['tp-dlfilesize'].'</div>
				<p class="clearthefloat"></p>
			</div>';
		if(isset($context['TPortal']['dl_admitems']) && count( $context['TPortal']['dl_admitems'] ) > 0)
		{
			foreach($context['TPortal']['dl_admitems'] as $cat) {
				echo '
			<div style="border-bottom: 1px solid #ccc;">
				<div class="fullwidth-on-res-layout windowbg2 float-items" style="width:18%;"><a href="'.$cat['href'].'">'.$cat['name'].'</a></div>
				<div class="fullwidth-on-res-layout windowbg2 float-items" style="width:18%;">
				  <div id="show-on-respnsive-layout">'.$txt['tp-dlfilename'].'</div>
				  <div id="size-on-respnsive-layout" style="word-break:break-all;">'.$cat['file'].'</div>
				</div>
				<div class="fullwidth-on-res-layout windowbg2 float-items" style="width:18%;">
				   <div id="show-on-respnsive-layout">'.$txt['tp-created'].'</div>
				   <div id="size-on-respnsive-layout">'.$cat['date'].'</div>
				</div>
				<div class="fullwidth-on-res-layout windowbg2 float-items" style="width:18%;">
				   <div id="show-on-respnsive-layout">'.$txt['tp-uploadedby'].'</div>
				   '.$cat['author'].'
				</div>
				<div class="fullwidth-on-res-layout windowbg2 float-items" style="width:18%;">
				  <div id="show-on-respnsive-layout">'.$txt['tp-dlfilesize'].'</div>
				  '. $cat['filesize'].'kb
				</div>
				<p class="clearthefloat"></p>
			</div>';
			}
		}
	}
	// check out files FTP
	elseif($context['TPortal']['dlsub'] == 'adminftp')
	{
		echo '<div class="tborder"><div class="titlebg" style="padding: 1ex;">'.$txt['tp-ftpstrays'].'</div>
					<div class="windowbg" style="padding: 2ex;" class="smalltext">'.$txt['tp-assignftp'].'</div>
					<div class="windowbg2" style="padding: 5px;">';

		// alert if new files were added recently
		if(!empty($_GET['ftpcat']))
			echo '<div style="margin-bottom:1ex;text-align:center;border:dotted 2px red;padding:2ex;"><b><a href="'.$scripturl.'?action=tpmod;dl=admincat'.$_GET['ftpcat'].'">'.$txt['tp-adminftp_newfiles'].'</a></b><br /></div>';

		if(count( $context['TPortal']['tp-downloads'] ) > 0) {
			$ccount = 0;
			foreach($context['TPortal']['tp-downloads'] as $file) {
				if(!in_array( $file['file'], $context['TPortal']['dl_allitems'] ))
					echo '<div><input name="assign-ftp-checkbox'.$ccount.'" type="checkbox" value="'.$file['file'].'"> '.substr( $file['file'], 0, 40 ).'', strlen( $file['file'] ) > 40 ? '..' : '', '  ['.$file['size'].' Kb]  - <b><a href="'.$scripturl.'?action=tpmod;dl=upload;ftp='.$file['id'].'">'.$txt['tp-dlmakeitem'].'</a></b></div>';
					$ccount++;
			}
			echo '<div style="padding: 5px;max-width:100%;"><span class="smalltext">
			 '.$txt['tp-newcatassign'].' <input name="assign-ftp-newcat" type="text" value=""> ';
			// the parent category - or the one to use
				// which parent category?
				echo $txt['tp-assigncatparent'].'</span>
					<select size="1" name="assign-ftp-cat" style="margin-top: 4px;max-width:100%;">
						<option value="0" selected>'.$txt['tp-nocategory'].'</option>';
				if(count( $context['TPortal']['admuploadcats'] ) > 0)
				{
					foreach($context['TPortal']['admuploadcats'] as $ucats)
					{
							echo '
						<option value="'.$ucats['id'].'">', (!empty($ucats['indent']) ? str_repeat( "-", $ucats['indent'] ) : ''), ' '.$ucats['name'].'</option>';
					}
				}
				else
					echo '
						<option value="0">'.$txt['tp-none-'].'</option>';
			echo '
					</select><p class="clearthefloat"></p><br><hr /><br>';

			echo '<input name="ftpdlsend" type="submit" value="'.$txt['tp-submit'].'">
				  </div>';
		}
		echo '</div>';
	}
	elseif(substr( $context['TPortal']['dlsub'], 0, 12 ) == 'admineditcat')
	{
		if(isset($context['TPortal']['admcats']) && count( $context['TPortal']['admcats'] ) > 0)
		{
			foreach($context['TPortal']['admcats'] as $cat) {
				// edit category
				echo '
		<div id="editupcat" class="tborder"> 
				<div class="windowbg2" style="padding:1%;border-right:1px solid #ccc;">
					' , $txt['tp-dluploadtitle'], '<br />
					<input style="width: 30ex;" name="dladmin_name'.$cat['id'].'" type="text" value="'.$cat['name'].'">
					<br />' , $txt['tp-shortname'], '<br />
					<input style="width: 30ex;" name="dladmin_link'.$cat['id'].'" type="text" value="'.$cat['shortname'].'">
					<br />';

				if($context['TPortal']['dl_wysiwyg'] == 'html')
					TPwysiwyg( 'dladmin_text'.$cat['id'], html_entity_decode( $cat['description'], ENT_QUOTES ), true, 'qup_dladmin_text', isset($context['TPortal']['usersettings']['wysiwyg']) ? $context['TPortal']['usersettings']['wysiwyg'] : 0 );
				elseif($context['TPortal']['dl_wysiwyg'] == 'bbc')
					TP_bbcbox( $context['TPortal']['editor_id'] );
				else
					echo '<textarea name="dladmin_text'.$cat['id'].'" style="width: 99%; height: 300px;">'.html_entity_decode( $cat['description'], ENT_QUOTES ).'</textarea>';

			
				echo '
				</div>
				<div id="dl-editcat" class="windowbg2" style="padding:1%;max-width:100%;">
					<select style="max-width:100%;" size="1" name="dladmin_icon'.$cat['id'].'" onchange="dlcheck(this.value)">
						<option value="blank.gif" selected>'.$txt['tp-chooseicon'].'</option>
						<option value="blank.gif">'.$txt['tp-noneicon'].'</option>';

				// output the icons
				$selicon = substr( $cat['icon'], strrpos( $cat['icon'], '/' ) + 1 );
				foreach($context['TPortal']['dlicons'] as $dlicon => $value)
					echo '
						<option ', ($selicon == $value) ? 'selected="selected" ' : '', 'value="'.$value.'">'.$value.'</option>';

				echo '
					</select>
					<br /><br /><img name="dlicon" src="'.$cat['icon'].'" alt="" />
					<script type="text/javascript">
						function dlcheck(icon)
						{
							document.dlicon.src= "'.$boardurl.'/tp-downloads/icons/" + icon
						}
					</script>
				<br /><b>'.$txt['tp-dlparent'].':</b><br />';
				// which parent category?
				echo '
					<select size="1" name="dladmin_parent'.$cat['id'].'" style="margin-top: 4px;max-width:100%;">
						<option value="0" ', $cat['parent'] == 0 ? 'selected' : '', '>'.$txt['tp-nocategory'].'</option>';

				if(count( $context['TPortal']['admuploadcats'] ) > 0)
				{
					foreach($context['TPortal']['admuploadcats'] as $ucats)
					{
						if($ucats['id'] != $cat['id'])
						{
							echo '
						<option value="'.$ucats['id'].'" ', $ucats['id'] == $cat['parent'] ? 'selected' : '', '>', (!empty($ucats['indent']) ? str_repeat( "-", $ucats['indent'] ) : ''), ' '.$ucats['name'].'</option>';
						}
					}
				}
				else {
									echo '
						<option value="0">'.$txt['tp-none-'].'</option>';
				}

			}
			echo '
					</select><hr /><b>'.$txt['tp-dlaccess'].':</b>
					<div style="max-height: 30em; overflow: auto;">';

			// access groups
			// loop through and set membergroups
			if(!empty($cat['access']))
				$tg=explode(',',$cat['access']);
			else
				$tg=array();

			foreach($context['TPortal']['dlgroups'] as $mg)
			{
				if($mg['posts']=='-1' && $mg['id']!='1')
				{
					echo '
					<input name="dladmin_group'.$mg['id'].'" type="checkbox" value="'.$cat['id'].'"';
			 		if(in_array($mg['id'],$tg))
			 			echo ' checked';
			 		echo '> '.$mg['name'].' <br />';
		 		}
			}
   			// if none is chosen, have a control value
			echo '<br /></div><input type="checkbox" onclick="invertAll(this, this.form, \'dladmin_group\');" />'.$txt['tp-checkall'].'
					<input name="dladmin_group-2" type="hidden" value="'.$cat['id'].'">';

			echo '
		     	</div>';
		}
		echo '
				<div class="windowbg" style="padding:1%;"><input name="dlsend" type="submit" value="'.$txt['tp-submit'].'"></div>';
	}
	elseif($context['TPortal']['dlsub'] == 'adminaddcat')
	{
		// add category
		echo '
		<div id="dl-addcat" class="tborder">
				<div class="windowbg2" style="padding:1%;"><b>'.$txt['tp-title'].':</b> <input style="width: 70%;" name="newdladmin_name" type="text" value="">
					<br /><br /><b>'.$txt['tp-body'].':</b><br />';

				if($context['TPortal']['dl_wysiwyg'] == 'html')
					TPwysiwyg( 'newdladmin_text', '', true, 'qup_dladmin_text', isset($context['TPortal']['usersettings']['wysiwyg']) ? $context['TPortal']['usersettings']['wysiwyg'] : 0 );
				elseif($context['TPortal']['dl_wysiwyg'] == 'bbc')
					TP_bbcbox( $context['TPortal']['editor_id'] );
				else
					echo '<textarea name="newdladmin_text" style="width: 99%; height: 300px;"></textarea>';


			echo '</div>
			      <div class="windowbg2" style="padding:1%;"><b>'.$txt['tp-icon'].':</b>
					<select size="1" name="newdladmin_icon" onchange="dlcheck(this.value)">';

		echo '
				<option value="blank.gif" selected>'.$txt['tp-noneicon'].'</option>';

		// output the icons
		foreach($context['TPortal']['dlicons'] as $dlicon => $value)
			echo '
						<option value="'.$value.'">'.substr( $value, 0, strlen( $value ) - 4 ).'</option>';

		echo '
					</select>
					<br /><br /><img name="dlicon" src="'.$boardurl.'/tp-downloads/icons/blank.gif" alt="" />
				<script type="text/javascript">
					function dlcheck(icon)
					{
						document.dlicon.src= "'.$boardurl.'/tp-downloads/icons/" + icon
					}
				</script>
				<br /><br /><b>'.$txt['tp-dlparent'].':</b><br />';
		// which parent category?
		echo '
					<select size="1" name="newdladmin_parent" style="margin-top: 4px;max-width:100%;">
						<option value="0" selected>'.$txt['tp-nocategory'].'</option>';

		foreach($context['TPortal']['admuploadcats'] as $ucats) {
			echo '
			     		<option value="'.$ucats['id'].'">', (!empty($ucats['indent']) ? str_repeat( "-", $ucats['indent'] ) : ''), ' '.$ucats['name'].'</option>';
		}
		echo '
					</select><p class="clearthefloat"></p><br />
		<hr /><b>'.$txt['tp-dlaccess'].':</b><br />';

			// access groups
			// loop through and set membergroups
			if(!empty($cat['access']))
				$tg=explode(',',$cat['access']);
			else
				$tg=array();

			foreach($context['TPortal']['dlgroups'] as $mg)
			{
				if($mg['posts']=='-1' && $mg['id']!='1')
				{
					echo '
					<input name="newdladmin_group'.$mg['id'].'" type="checkbox" value="1"';
			 		if(in_array($mg['id'],$tg))
			 			echo ' checked';
			 		echo '> '.$mg['name'].' <br />';
		 		}
			}
   			// if none is chosen, have a control value
			echo '<br /><input type="checkbox" onclick="invertAll(this, this.form, \'newdladmin_group\');" />'.$txt['tp-checkall'].'
					<input name="dladmin_group-2" type="hidden" value="1">
			</div>';

		echo '
				<div class="windowbg" style="padding:1%;"><input name="newdlsend" type="submit" value="'.$txt['tp-submit'].'"></div>';
	}
	echo '
		</div>
	</form>
</div><p class="clearthefloat"></p>';
}

?>
