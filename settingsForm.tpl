{**
 * settingsForm.tpl
 *
 * Copyright (c) 2013 Projecte Ictineo (www.projecteictineo.com)
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * issue Carousel plugin settings
 *
 * $Id$
 *}
{strip}
{assign var="pageTitle" value="plugins.generic.issuecarousel.displayName"}
{include file="common/header.tpl"}
{/strip}
<div id="webFeedSettings">
<div id="description">{translate key="plugins.generic.issuecarousel.description"}</div>

<div class="separator">&nbsp;</div>

<h3>{translate key="plugins.generic.issuecarousel.settings"}</h3>

<form method="post" action="{plugin_url path="settings"}">
{include file="common/formErrors.tpl"}

<table width="100%" class="data">
	<tr valign="top">
		<td width="10%" class="label" align="right"><input type="radio" name="customCovers" id="customCovers" value="custom" {if $customCovers eq "custom"}checked="checked" {/if}/></td>
		<td width="90%" class="value">{translate key="plugins.generic.issuecarousel.settings.custom"}</td>
	</tr>
	<tr valign="top">
		<td width="10%" class="label" align="right"><input type="radio" name="customCovers" id="defaultCovers" value="generic" {if $customCovers eq "generic"}checked="checked" {/if}/></td>
		<td width="90%" class="value">{translate key="plugins.generic.issuecarousel.settings.generic"}</td>
	</tr>
</table>

<br/>

<input type="submit" name="save" class="button defaultButton" value="{translate key="common.save"}"/> <input type="button" class="button" value="{translate key="common.cancel"}" onclick="history.go(-1)"/>
</form>

<p><span class="formRequired">{translate key="common.requiredField"}</span></p>
</div>
{include file="common/footer.tpl"}
