{**
 * archive.tpl
 *
 * Copyright (c) 2003-2011 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * Issue Archive.
 *
 * $Id$
 *}
<div id="carrouselWrapper">
 <div class="width">
 <div id="cWrapper">
{assign var=first value="first"}
{iterate from=issues item=issue}
	<div class="cItem">
    <div class="cNum">
      {$issue->getVolume()|escape} / {$issue->getNumber()|escape}
    </div>
    <div class="cLogo">
      <a href="{url page="issue" op="view" path=$issue->getBestIssueId($courrentJournal)}">
        <img src="{$coverPagePath|escape}{if $customCovers == 'custom'}{$issue->getVolume()|escape}-{$issue->getNumber()|escape}-{$locale|escape}.png{else}{if $issue->getFileName($locale) eq ""}/covers/default.png{else}{$issue->getFileName($locale)|escape}{/if}{/if}" 
        {if $issue->getCoverPageAltText($locale) != ''} alt="{$issue->getCoverPageAltText($locale)|escape}"{else} alt="{translate key="issue.coverPage.altText"}"{/if} />
      </a>
    </div>
    <div class="cText">
    {if $first eq "first"}
      {translate key="plugins.generic.issuecarousel.current"}
      {assign var=first value='nofirst'}
    {/if}
    </div>
 </div><!-- /citem -->
{/iterate}

 </div>
           <div id="cArrowLeft" class="cArrow">
                <img src="/ojs-mbrpapers/plugins/themes/papers/img/arrowLeft.jpg">
            </div>
            <div id="cArrowRight" class="cArrow">
                <img src="/ojs-mbrpapers/plugins/themes/papers/img/arrowRight.jpg">
            </div>
   
 </div>
{* if !$issues->wasEmpty()}
	{page_info iterator=$issues}&nbsp;&nbsp;&nbsp;&nbsp;
	{page_links anchor="issues" name="issues" iterator=$issues}
{else}
	{translate key="current.noCurrentIssueDesc"}
{/if *}
</div>

