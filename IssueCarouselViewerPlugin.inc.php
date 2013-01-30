<?php

/**
 * @file issueCarouselViewerPlugin.inc.php
 *
 * Copyright (c) 2013 Projecte Ictineo (www.projecteictineo.com)
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class IssueCarouselViewerPlugin
 * @ingroup plugins_generic_issueCarousel
 *
 * @brief viewer component for issueCarousel plugin
 *
 */

// $Id$


import('pages.issue.IssueHandler');

class IssueCarouselViewerPlugin extends IssueHandler {
  function IssueCarouselViewerPlugin() {
    parent::Handler();
  }

  function carousel() {

    $this->validate();
    $this->setupTemplate();

    $journal =& Request::getJournal();
    $issueDao =& DAORegistry::getDAO('IssueDAO');
    $rangeInfo = Handler::getRangeInfo('issues');

    $publishedIssuesIterator = $issueDao->getPublishedIssues($journal->getId(), $rangeInfo);

    import('classes.file.PublicFileManager');
    $publicFileManager = new PublicFileManager();
    $coverPagePath = Request::getBaseUrl() . '/';
    $coverPagePath .= $publicFileManager->getJournalFilesPath($journal->getId()) . '/';

    $templateMgr =& TemplateManager::getManager();
    $templateMgr->assign('coverPagePath', $coverPagePath);
    $templateMgr->assign('locale', Locale::getLocale());
    $templateMgr->assign_by_ref('issues', $publishedIssuesIterator);
    $templateMgr->assign('helpTopicId', 'user.currentAndArchives');
    $templateMgr->display(Request::getBaseUrl() . '/' . $this->getPluginPath() . '/carousel.tpl');
  }
}

?>
