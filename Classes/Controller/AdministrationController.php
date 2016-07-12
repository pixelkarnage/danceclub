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

use TYPO3\CMS\Core\FormProtection\FormProtectionFactory;
use TYPO3\CMS\Core\Imaging\Icon;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Utility\HttpUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

use TYPO3\CMS\Backend\Utility\BackendUtility as BackendUtilityCore;
use TYPO3\CMS\Backend\Clipboard\Clipboard;
use TYPO3\CMS\Backend\Template\Components\ButtonBar;
use TYPO3\CMS\Backend\View\BackendTemplateView;

use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Mvc\View\ViewInterface;
use TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder;
use TYPO3\CMS\Extbase\Reflection\ObjectAccess;

use TYPO3\CMS\Lang\LanguageService;

/**
 * AdministrationController
 */
class AdministrationController extends \PlanT\Danceclub\Controller\AbstractController
{
    /**
     * BackendTemplateContainer
     *
     * @var BackendTemplateView
     */
    protected $view;

    /**
     * @var IconFactory
     */
    protected $iconFactory;

    /**
     * Backend Template Container
     *
     * @var BackendTemplateView
     */
    protected $defaultViewObjectName = BackendTemplateView::class;

    /**
     * Set up the doc header properly here
     *
     * @param ViewInterface $view
     */
    protected function initializeView(ViewInterface $view)
    {
        $this->iconFactory = GeneralUtility::makeInstance(IconFactory::class);
        /** @var BackendTemplateView $view */
        parent::initializeView($view);
        $view->getModuleTemplate()->getDocHeaderComponent()->setMetaInformation([]);

        $pageRenderer = $this->view->getModuleTemplate()->getPageRenderer();
        $pageRenderer->loadRequireJsModule('TYPO3/CMS/Backend/ClickMenu');

        $this->createMenu();
        $this->createButtons();
    }

    /**
     * Create menu
     *
     * @return void
     */
    protected function createMenu()
    {
        /** @var UriBuilder $uriBuilder */
        $uriBuilder = $this->objectManager->get(UriBuilder::class);
        $uriBuilder->setRequest($this->request);

        $menu = $this->view->getModuleTemplate()->getDocHeaderComponent()->getMenuRegistry()->makeMenu();
        $menu->setIdentifier('danceclub');

        $actions = [
            ['action' => 'index', 'label' => 'eventGroupListing'],
        ];

        foreach ($actions as $action) {
            $item = $menu->makeMenuItem()
                ->setTitle($this->getLanguageService()->sL('LLL:EXT:danceclub/Resources/Private/Language/locallang_be.xlf:administration.' . $action['label']))
                ->setHref($uriBuilder->reset()->uriFor($action['action'], [], 'Administration'))
                ->setActive($this->request->getControllerActionName() === $action['action']);
           //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($item);
           $menu->addMenuItem($item);

        }

        $this->view->getModuleTemplate()->getDocHeaderComponent()->getMenuRegistry()->addMenu($menu);
        $pageInfo = BackendUtilityCore::readPageAccess($this->pageUid, '');
        if (is_array($pageInfo)) {
            $this->view->getModuleTemplate()->getDocHeaderComponent()->setMetaInformation($pageInfo);
        }
    }

    /**
     * Create the panel of buttons
     *
     * @return void
     */
    protected function createButtons()
    {
        $buttonBar = $this->view->getModuleTemplate()->getDocHeaderComponent()->getButtonBar();
        $uriBuilder = $this->objectManager->get(UriBuilder::class);
        $uriBuilder->setRequest($this->request);

        $buttons = [
            [
                'table' => 'tx_danceclub_domain_model_eventgroup',
                'label' => 'administration.newEventGroupRecord',
                'action' => 'newEventGroup'
            ],
            [
                'table' => 'tx_danceclub_domain_model_event',
                'label' => 'administration.newEventRecord',
                'action' => 'newEvent'
            ],
            [
                'table' => 'tx_danceclub_domain_model_booking',
                'label' => 'administration.newBookingRecord',
                'action' => 'newBooking'
            ],
            [
                'table' => 'tx_danceclub_domain_model_type',
                'label' => 'administration.newTypeRecord',
                'action' => 'newType'
            ],
            [
                'table' => 'tx_danceclub_domain_model_venue',
                'label' => 'administration.newVenueRecord',
                'action' => 'newVenue'
            ]
        ];
        foreach ($buttons as $key => $tableConfiguration) {
            if ($this->getBackendUser()->isAdmin() || GeneralUtility::inList($this->getBackendUser()->groupData['tables_modify'],
                    $tableConfiguration['table'])
            ) {
                $viewButton = $buttonBar->makeLinkButton()
                    ->setHref($uriBuilder->reset()->setRequest($this->request)->uriFor($tableConfiguration['action'],
                        [], 'Administration'))
                    ->setTitle($this->getLanguageService()->sL('LLL:EXT:danceclub/Resources/Private/Language/locallang_be.xlf:' . $tableConfiguration['label']))
                    ->setIcon($this->iconFactory->getIconForRecord($tableConfiguration['table'], [], Icon::SIZE_SMALL));
                $buttonBar->addButton($viewButton, ButtonBar::BUTTON_POSITION_LEFT, $key);
            }
        }

        /** @var Clipboard clipObj */
        $clipBoard = GeneralUtility::makeInstance(Clipboard::class);
        $clipBoard->initializeClipboard();
        $elFromTable = $clipBoard->elFromTable('tx_news_domain_model_news');
        if (!empty($elFromTable)) {
            $viewButton = $buttonBar->makeLinkButton()
                ->setHref($clipBoard->pasteUrl('', $this->pageUid))
                ->setOnClick('return ' . $clipBoard->confirmMsg('pages', BackendUtilityCore::getRecord('pages', $this->pageUid), 'into',
                        $elFromTable))
                ->setTitle($this->getLanguageService()->sL('LLL:EXT:lang/locallang_mod_web_list.xlf:clip_pasteInto'))
                ->setIcon($this->iconFactory->getIcon('actions-document-paste-into', ICON::SIZE_SMALL));
            $buttonBar->addButton($viewButton, ButtonBar::BUTTON_POSITION_LEFT, 4);
        }
    }

    /**
     * Main action for administration
     *
     * @return void
     */
    public function indexAction()
    {
        $eventGroups = $this->eventGroupRepository->findAllAsArray();
        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($eventGroups);
        foreach($eventGroups as $eventGroup){
            $totalBookingCount = 0;
            $events = $this->eventRepository->findByEventGroups($eventGroup, NULL, false, true);
            foreach($events as $event) {
                $bookingCount = $this->bookingRepository->findBookingCountByEvent($event);
                $event->setBookingCount($bookingCount);
                $totalBookingCount = $totalBookingCount+$bookingCount;
                //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($bookingCount);

            }

            $eventGroup->setQueryEvents($events);
            $eventGroup->setBookingCount($totalBookingCount);
         }

        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump(rawurlencode(BackendUtilityCore::getModuleUrl('web_danceclubadmin')));
        $assignedValues = [
            'eventGroups' => $eventGroups,
            'returnUrl' => rawurlencode(BackendUtilityCore::getModuleUrl('web_DanceclubDanceclubadmin'))
            //'events' => $events
            
        ];


        $this->view->assignMultiple($assignedValues);
    }

     /**
     * Detail action for administration
     *  
     * @param \PlanT\Danceclub\Domain\Model\Event $event
     * @param \PlanT\Danceclub\Domain\Model\EventGroup $eventGroup
     * @return void
     */
    public function detailAction(\PlanT\Danceclub\Domain\Model\Event $event, \PlanT\Danceclub\Domain\Model\EventGroup $eventGroup)
    {
        //rawurlencode(BackendUtilityCore::getModuleUrl('web_danceclubadmin')));
        $bookings = $this->bookingRepository->findBookingsOfEvent($event);

       // \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump(ksort();

        $assignedValues = [
            'eventGroup' => $eventGroup,
            'event' => $event,
            'eventDates' => $this->getEventOccurences($event),
            'bookings' => $this->splitBookingsByDanceStyle($bookings),
            'danceStyleOptions' => $this->getDanceStyleOptions(),
            'returnUrl' => rawurlencode(BackendUtilityCore::getModuleUrl('web_DanceclubDanceclubadmin'))
        ];

        $this->view->assignMultiple($assignedValues);
    }

    /**
     * Splits all Bookings By DanceStyle
     * 
     * @param array $bookings
     * @return array $splitBookings 
     */
    public function splitBookingsByDanceStyle($bookings)
    {
        if (!empty($bookings)) {
            foreach ($bookings as $booking) {
                switch ($booking->getDanceStyle()) {
                    // Switch the column order with the case numbering
                    case 0:
                        $splitBookings['1'][] = $booking;
                        break;
                    case 1:
                        $splitBookings['0'][] = $booking;
                        break;
                    case 2:
                        $splitBookings['2'][] = $booking;
                        break;
                }
            }
            ksort($splitBookings);
            return $splitBookings;
        }
        return '';
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
     * Returns the LanguageService
     *
     * @return LanguageService
     */
    protected function getLanguageService()
    {
        return $GLOBALS['LANG'];
    }

    /**
     * Get backend user
     *
     * @return \TYPO3\CMS\Core\Authentication\BackendUserAuthentication
     */
    protected function getBackendUser()
    {
        return $GLOBALS['BE_USER'];
    }

    /**
     * Redirect to form to create a eventGroup record
     *
     * @return void
     */
    public function newEventGroupAction()
    {
        $this->redirectToCreateNewRecord('tx_danceclub_domain_model_eventgroup');
    }

    /**
     * Redirect to form to create a event record
     *
     * @return void
     */
    public function newEventAction()
    {
        $this->redirectToCreateNewRecord('tx_danceclub_domain_model_event');
    }

    /**
     * Redirect to form to create a eventGroup record
     *
     * @return void
     */
    public function newBookingAction()
    {
        $this->redirectToCreateNewRecord('tx_danceclub_domain_model_booking');
    }

    /**
     * Redirect to form to create a type record
     *
     * @return void
     */
    public function newTypeAction()
    {
        $this->redirectToCreateNewRecord('tx_danceclub_domain_model_type');
    }

    /**
     * Redirect to form to create a venue record
     *
     * @return void
     */
    public function newVenueAction()
    {
        $this->redirectToCreateNewRecord('tx_danceclub_domain_model_venue');
    }

    /**
     * Redirect to tceform creating a new record
     *
     * @param string $table table name
     * @return void
     */
    private function redirectToCreateNewRecord($table)
    {
        $pid = $this->pageUid;
        if ($pid === 0) {
            if (isset($this->tsConfiguration['defaultPid.'])
                && is_array($this->tsConfiguration['defaultPid.'])
                && isset($this->tsConfiguration['defaultPid.'][$table])
            ) {
                $pid = (int)$this->tsConfiguration['defaultPid.'][$table];
            }
        }
        $returnUrl = 'index.php?M=danceclubadmin&id=' . $this->pageUid . $this->getToken();
        $url = BackendUtilityCore::getModuleUrl('record_edit', [
            'edit[' . $table . '][' . $pid . ']' => 'new',
            'returnUrl' => $returnUrl
        ]);
        HttpUtility::redirect($url);
    }

    

    /**
     * Get a CSRF token
     *
     * @param bool $tokenOnly Set it to TRUE to get only the token, otherwise including the &moduleToken= as prefix
     * @return string
     */
    protected function getToken($tokenOnly = false)
    {
        $token = FormProtectionFactory::get()->generateToken('moduleCall', 'web_DanceclubDanceclubadmin');
        if ($tokenOnly) {
            return $token;
        } else {
            return '&moduleToken=' . $token;
        }
    }

    /**
     * If defined in TsConfig with tx_news.module.redirectToPageOnStart = 123
     * and the current page id is 0, a redirect to the given page will be done
     *
     * @return void
     */
    protected function redirectToPageOnStart()
    {
        if ((int)$this->tsConfiguration['allowedPage'] > 0 && $this->pageUid !== (int)$this->tsConfiguration['allowedPage']) {
            $url = 'index.php?M=web_DanceclubDanceclubadmin&id=' . (int)$this->tsConfiguration['allowedPage'] . $this->getToken();
            HttpUtility::redirect($url);
        } elseif ($this->pageUid === 0 && (int)$this->tsConfiguration['redirectToPageOnStart'] > 0) {
            $url = 'index.php?M=web_DanceclubDanceclubadmin&id=' . (int)$this->tsConfiguration['redirectToPageOnStart'] . $this->getToken();
            HttpUtility::redirect($url);
        }
    }
}