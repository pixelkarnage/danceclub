<?php
namespace PlanT\Danceclub\ViewHelpers\Be;

/*
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

use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;
use TYPO3\CMS\Core\Utility\GeneralUtility;
/**
 * A view helper for creating edit on click links.
 */
class IssueCommandViewHelper extends AbstractTagBasedViewHelper
{
    /**
     * @var string
     */
    protected $tagName = 'a';
    /**
     * Arguments initialization.
     */
    public function initializeArguments()
    {
        $this->registerUniversalTagAttributes();
    }
    /**
     * Returns a link with a command to TYPO3 Core Engine (tce_db.php).
     *
     * @see DocumentTemplate::issueCommand()
     *
     * @param string     $parameters
     * @param string|int $redirectUrl
     *
     * @return string
     */
    public function render($parameters, $redirectUrl = '')
    {
        // Needed in 7.x and 8.x
        $parameters = '&id='.intval(GeneralUtility::_GP('id')).'&'.$parameters;
        $href = BackendUtility::getLinkToDataHandlerAction($parameters, $redirectUrl);
        $this->tag->addAttribute('href', $href);
        $this->tag->setContent($this->renderChildren());
        $this->tag->forceClosingTag(true);
        return $this->tag->render();
    }
}
