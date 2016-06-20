<?php
namespace PlanT\Danceclub\Mailer;

/**
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use TYPO3\CMS\Core\Mail\MailMessage;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;


/**
 * Abstract mailer class.
 *
 */
abstract class AbstractMailer
{

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
     * @inject
     */
    protected $persistenceManager;

    /**
     * @var \TYPO3\CMS\Extbase\Object\ObjectManager
     * @inject
     */
    protected $objectManager;

    /**
     * @var array
     */
    protected $settings = array();

    /**
     * Initializes the current action
     *
     * @return void
     */
    public function initialize() {
        $configurationManager = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');
        $this->settings = $configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS,'danceclub', '');
        $this->settings = $this->settings['booking'];
    }

    /**
     * @param string $locale ISO 2 char locale code.
     * @return void
     */
    public function setLanguage($locale)
    {
        $GLOBALS['BE_USER']->uc['lang'] = $locale;
    }

    /**
     * Renders a fluid standalone view.
     *
     * @param string $template Path to template, including filename
     * @param array $locals Array of variables to assign to the template
     * @return string The rendered view
     */
    protected function renderEmailTemplate($template, $locals = [])
    {
        $mailView = $this->objectManager->get(StandaloneView::class);
        $basePath = GeneralUtility::getFileAbsFileName($this->settings['confirmationEmail']['templateRootPath']);
        if (!substr($basePath, -1, 1) == '/') {
            $basePath .= '/';
        }
        //print_r($basePath);
        $mailView->setTemplatePathAndFilename($basePath . $template);
        $mailView->setFormat('html');
        $mailView->getRequest()->setControllerExtensionName('DanceClub');
        $mailView->assignMultiple($locals);
        return trim($mailView->render());
    }

    /**
     * Shorthand for getting a new mail message instance.
     *
     * @return \TYPO3\CMS\Core\Mail\MailMessage
     */
    protected function createMailMessage()
    {
        return $this->objectManager->get(MailMessage::class);
    }

    /**
     * Helper to get a label from the language file by given key.
     *
     * @param string $key
     * @return string
     */
    protected function getLanguageLabel($key)
    {
        // LocalizationUtility respects $GLOBALS['BE_USER']->uc['lang'] if not in FE context.
        return LocalizationUtility::translate($key, 'danceclub');
    }
}