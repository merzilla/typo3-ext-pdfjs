<?php
namespace JonathanHeilmann\Pdfjs\Controller;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2016 Jonathan Heilmann <mail@jonathan-heilmann.de>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use TYPO3\CMS\Extbase\Utility\ArrayUtility;

/**
 * Class PdfViewerController
 * @package JonathanHeilmann\Pdfjs\Controller
 */
class PdfViewerController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * @var array
     */
    protected $cObj = array();

    /**
     * @var \TYPO3\CMS\Core\Resource\FileRepository
     * @inject
     */
    protected $fileRepository = null;

	/**
	 * Initializes the current action
	 *
	 * @return void
	 */
	public function initializeAction()
	{
        $this->mergeSettingsFromFlexform();
	}

    /**
     * Show simple action for this controller.
     */
    public function showSimpleAction()
	{
        $this->cObj = $this->configurationManager->getContentObject()->data;
        $file = $this->getFile();

        $this->view->assign('cObj', $this->cObj);
        $this->view->assign('file', $file);
        $this->view->assign('settings', $this->settings);
    }

    /**
     * Show complete action for this controller.
     */
    public function showCompleteAction()
    {
        $this->cObj = $this->configurationManager->getContentObject()->data;
        $file = $this->getFile();

        $this->view->assign('cObj', $this->cObj);
        $this->view->assign('file', $file);
        $this->view->assign('settings', $this->settings);
    }

    /**
     * Merges settings from flexform into settings from typoscript
     */
    protected function mergeSettingsFromFlexform()
    {
        $this->settings = ArrayUtility::arrayMergeRecursiveOverrule($this->settings, $this->settings['flexform'], true, false);
    }

    /**
     * Get file to display
     *
     * @throws \TYPO3\CMS\Core\Resource\FileReference|\Exception
     */
    protected function getFile()
    {
        $files = $this->fileRepository->findByRelation('tt_content', 'file', (isset($this->cObj['_ORIG_uid']) ?: $this->cObj['uid']));
        if (isset($files[0]))
            /** @var \TYPO3\CMS\Core\Resource\FileReference $file */
            return $files[0];
        else
            throw new \Exception('No file available');
    }
}