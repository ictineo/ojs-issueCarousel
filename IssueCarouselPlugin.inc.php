<?php

/**
 * @file IssueCarouselPlugin.inc.php
 *
 * Copyright (c) 2013 Projecte Ictineo (www.projecteictineo.com)
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class IssueCarouselPlugin
 * @ingroup plugins_generic_issueCarousel
 *
 * @brief issueCarousel plugin class
 */

// $Id$

// TODO CLEAR THE CODE!
//

import('lib.pkp.classes.plugins.GenericPlugin');

class IssueCarouselPlugin extends GenericPlugin {
	function register($category, $path) {
		if (parent::register($category, $path)) {
			if ($this->getEnabled()) {
				HookRegistry::register('TemplateManager::display',array(&$this, 'callbackAddLinks'));
//				HookRegistry::register('TemplateManager::display',array(&$this, 'callbackAppendCarousel'));
				//HookRegistry::register('PluginRegistry::loadCategory', array(&$this, 'callbackLoadCategory'));
//				HookRegistry::register('Templates::Index::journal',array(&$this, 'test'));
				HookRegistry::register('Templates::Index::issueCarousel',array(&$this, 'callbackInsertCarousel'));
			}
			return true;
		}
		return false;
	}

	/**
	 * Get the display name of this plugin
	 * @return string
	 */
	function getDisplayName() {
		return Locale::translate('plugins.generic.issuecarousel.displayName');
	}

	/**
	 * Get the description of this plugin
	 * @return string
	 */
	function getDescription() {
		return Locale::translate('plugins.generic.issuecarousel.description');
	}
  
	/**
	 * Get the name of the settings file to be installed on new journal
	 * creation.
	 * @return string
	 */
	function getContextSpecificPluginSettingsFile() {
		return $this->getPluginPath() . '/settings.xml';
	}


  function callbackInsertCarousel($hookName, $params) {
      $smarty = &$params[1];
      $output = &$params[2];
      $journal = &Request::getJournal();
      $issueDao =& DAORegistry::getDAO('IssueDAO');
      $rangeInfo = Handler::getRangeInfo('issues');

      $customCovers = (string) $this->getSetting($journal->getId(), 'customCovers');
      
      $publishedIssuesIterator = $issueDao->getPublishedIssues($journal->getId(), $rangeInfo);

      import('classes.file.PublicFileManager');
      $publicFileManager = new PublicFileManager();

      $coverPagePath = Request::getBaseUrl() . '/';
      if($customCovers == 'custom') {
        $coverPagePath .= $publicFileManager->getJournalFilesPath($journal->getId()) . '/covers/';
      } else { 
        $coverPagePath .= $publicFileManager->getJournalFilesPath($journal->getId()) . '/';
      }
      $templateMgr =& TemplateManager::getManager();
      $templateMgr->assign('coverPagePath', $coverPagePath);
      $templateMgr->assign('customCovers', $customCovers);
      $templateMgr->assign('locale', Locale::getLocale());
      $templateMgr->assign_by_ref('issues', $publishedIssuesIterator);
      $templateMgr->assign('helpTopicId', 'user.correntAndArchives');
      $templateMgr->display($this->getTemplatePath() .  'templates/carousel.tpl');
/*
      $journalId = $journal->getJournalId();
      $journalPath = $journal->getPath();
      $piwikSiteId = $this->getSetting($journalId, 'piwikSiteId');
        $output =   '<h1> TEEEESSSSSTTT</h1>';
 */
    return false;
  }

	/**
	 * Register as a block and gateway plugin, even though this is a generic plugin.
	 * This will allow the plugin to behave as a block and gateway plugin
	 * @param $hookName string
	 * @param $args array
	 */
	function callbackLoadCategory($hookName, $args) {
		$category =& $args[0];
		$plugins =& $args[1];
		$this->import('IssueCarouselViewerPlugin');
		$viewerPlugin = new IssueCarouselViewerPlugin($this->getName());
		return false;
	}

	function callbackAddLinks($hookName, $args) {
			$templateManager =& $args[0];
			$requestedPage = Request::getRequestedPage();

      // if we have a journal selected, append feed meta-links into the header
      $additionalHeadData = $templateManager->get_template_vars('additionalHeadData');
      $init = "<script type='text/javascript' src='".Request::getBaseUrl() . '/'. $this->getPluginPath()."/js/init.js'></script>"; 
      $carouselLib = "<script type='text/javascript' src='".Request::getBaseUrl() . '/'. $this->getPluginPath()."/js/carouFredSel/jquery.carouFredSel.js'></script>"; 
      //MBR: $templateManager->assign('additionalHeadData', $additionalHomeData."\n\t".$carouselLib."\n\t".$init);

		return false;
	}
  function callbackAppendCarousel($hookName, $args) {
    if ($this->getEnabled()) {
      $templateManager =& $args[0];
      $additionalHomeContent = $templateManager->get_template_vars('additionalHomeContent');
      $additionalHomeContent .= '<h1> TESTTTTTT2</h1>';
      $templateManager->assign('additionalHomeContent', $additionalHomeContent);
      //$templateManager->assign('additionalHomeContent', $additionalHomeContent);
      return false;


    } 
  }


	/**
	 * Display verbs for the management interface.
	 */
	function getManagementVerbs() {
		$verbs = array();
		if ($this->getEnabled()) {
			$verbs[] = array('settings', Locale::translate('plugins.generic.issuecarousel.settings'));
		}
		return parent::getManagementVerbs($verbs);
	}

 	/*
 	 * Execute a management verb on this plugin
 	 * @param $verb string
 	 * @param $args array
	 * @param $message string Location for the plugin to put a result msg
 	 * @return boolean
 	 */
	function manage($verb, $args, &$message) {
		if (!parent::manage($verb, $args, $message)) return false;

		switch ($verb) {
			case 'settings':
				$journal =& Request::getJournal();

//				Locale::requireComponents(array(LOCALE_COMPONENT_APPLICATION_COMMON,  LOCALE_COMPONENT_PKP_MANAGER));
				$templateMgr =& TemplateManager::getManager();
				$templateMgr->register_function('plugin_url', array(&$this, 'smartyPluginUrl'));

				$this->import('SettingsForm');
				$form = new SettingsForm($this, $journal->getId());

				if (Request::getUserVar('save')) {
					$form->readInputData();
					if ($form->validate()) {
						$form->execute();
						Request::redirect(null, null, 'plugins');
						return false;
					} else {
						$form->display();
					}
				} else {
					$form->initData();
					$form->display();
				}
				return true;
			default:
				// Unknown management verb
				assert(false);
				return false;
		}
	}
}

?>
