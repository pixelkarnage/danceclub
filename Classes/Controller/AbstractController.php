<?php
namespace PlanT\Danceclub\Controller;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2014 Samuel Scherer <trashcash@gmail.com>, plan-T
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

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Backend\Utility\BackendUtility as BackendUtilityCore;

use PlanT\Danceclub\Domain\Model\EventGroup;
use PlanT\Danceclub\Domain\Model\Event;
use PlanT\Danceclub\Domain\Model\Booking;

use HDNET\Calendarize\Domain\Model\Index;

/**
 * AbstractController
 */
class AbstractController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * eventGroupRepository
     * 
     * @var \PlanT\Danceclub\Domain\Repository\EventGroupRepository
     * @inject
     */
    protected $eventGroupRepository = NULL;

    /**
     * eventGroupRepository
     * 
     * @var \PlanT\Danceclub\Domain\Repository\EventRepository
     * @inject
     */
    protected $eventRepository = NULL;

   
    /**
     * indexRepository from Calendarize
     * 
     * @var HDNET\Calendarize\Domain\Repository\IndexRepository
     * @inject
     */
    protected $indexRepository = NULL;

    /**
     * bookingRepository
     * 
     * @var \PlanT\Danceclub\Domain\Repository\BookingRepository
     * @inject
     */
    protected $bookingRepository = NULL;

    /**
     * @var \PlanT\Danceclub\Mailer\BookingMailer
     * @inject
     */
    protected $bookingMailer = NULL;
   
    /**
     * Page uid
     *
     * @var int
     */
    protected $pageUid = 0;

    /**
     * Function will be called before every other action
     *
     * @return void
     */
    public function initializeAction()
    {
        $this->pageUid = (int)\TYPO3\CMS\Core\Utility\GeneralUtility::_GET('id');

        if (TYPO3_MODE === 'BE') {
            $this->setTsConfig();
        }

        parent::initializeAction();
    }

    /**
     * Returns all Dance Style Options of the Booking object
     * 
     * @return array 
     */
    public function getDanceStyleOptions()
    {
        return $GLOBALS['TCA']['tx_danceclub_domain_model_booking']['columns']['dance_style']['config']['items'];
    }

    /**
     * Get all Dates and Times for each event in a given Event object 
     * 
     * @param array $events
     * @return array HDNET\Calendarize\Domain\Model\Index
     */
    public function getEventOccurences($events)
    {
        // Get all Occurence Data from Calendarize
        // (even if its only one event it comes in a QueryResult Container)
        foreach ($events as $event){
            $allEventDates[] = $this->indexRepository->findByEvent($event);
        }
        return $allEventDates;
    }

    /**
     * Set the TsConfig configuration for the extension
     *
     * @return void
     */
    protected function setTsConfig()
    {
        $tsConfig = BackendUtilityCore::getPagesTSconfig($this->pageUid);
        if (isset($tsConfig['tx_danceclub.']['module.']) && is_array($tsConfig['tx_danceclub.']['module.'])) {
            $this->tsConfiguration = $tsConfig['tx_danceclub.']['module.'];
        }
    }
}