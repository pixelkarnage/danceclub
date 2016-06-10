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
use TYPO3\CMS\Extbase\Error\Error;
use TYPO3\CMS\Extbase\Error\Result;

use PlanT\Danceclub\Domain\Model\Event;
use PlanT\Danceclub\Domain\Model\Booking;

use HDNET\Calendarize\Domain\Model\Index;

/**
 * DanceClubController
 */
class DanceClubController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
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
     * Initializes the current action
     *
     * @return void
     */
    public function initializeAction() {

    }

    /**
     * initialize create action
     *
     * @return void
     */
    public function initializeCreateBookingAction() {
        //$this->request->getArgument('eventGroup');
        //$propertyMappingConfiguration = $this->arguments['newBooking']->getPropertyMappingConfiguration();
        //$propertyMappingConfiguration->forProperty('events')->allowAllProperties();
        //$propertyMappingConfiguration->forProperty('0')->allowAllProperties();
        //$propertyMappingConfiguration->allowProperties('events');
        //$propertyMappingConfiguration->allowProperties('0');
        //$propertyMappingConfiguration->setTypeConverterOption('TYPO3\CMS\Extbase\Property\TypeConverter\PersistentObjectConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\PersistentObjectConverter::CONFIGURATION_CREATION_ALLOWED, TRUE);
        //$propertyMappingConfiguration->skipUnknownProperties();
        //$propertyMappingConfiguration->allowProperties('events');
        //$propertyMappingConfiguration->forProperty('*');
      // $this->arguments['newBooking']->getPropertyMappingConfiguration()->skipProperties('events');
      // $this->arguments['newBooking']->getPropertyMappingConfiguration()->allowCreationForSubProperty('events');
       //$this->arguments['newBooking']->getPropertyMappingConfiguration()->forProperty('events.*')->allowAllProperties();

        $this->arguments['newBooking']->getPropertyMappingConfiguration()->skipProperties('events');

        //$typeConverter = $this->arguments['newBooking']->getPropertyMappingConfiguration()->getTypeConverter();
        //$this->arguments['newBooking']->getPropertyMappingConfiguration()->setTypeConverterOption($typeConverter, 'mapUnknownProperties', true);
       //var_dump( $this->arguments['newBooking']->getPropertyMappingConfiguration());
       //var_dump($typeConverter);
       //var_dump($this->request->getArguments());

       /*if($this->request->hasArgument('newBooking')) {
            $newBooking = $this->request->getArgument('newBooking');
            $propertyMappingConfiguration = $this->arguments->getArgument('newBooking')->getPropertyMappingConfiguration();

            if(!empty($newBooking['events'])) {
                $propertyMappingConfiguration->forProperty('events')->allowAllProperties();
                $propertyMappingConfiguration->allowModificationForSubProperty('events');

                foreach($newBooking['events'] as $positionIndex => $positionPropertyArray) {
                    $propertyPath = 'events.' . $positionIndex;  
                    $propertyMappingConfiguration->forProperty($propertyPath)->allowAllProperties();
                    $propertyMappingConfiguration->allowCreationForSubProperty($propertyPath);
                    $propertyMappingConfiguration->allowModificationForSubProperty($propertyPath);
                } // end foreach
            } // end if(!empty)
        } // end if(request->hasArgument)*/

        //print_r($newBooking);
    }

    /**
     * Initialize stuff
     * 
     * @return void
     */
    protected function initializeActionMethodValidators() {
        if ($this->actionMethodName == 'creatBookingAction') {
            parent::initializeActionMethodValidators();
            
            $newBooking = $this->arguments['newBooking'];
            
            $validator = $newBooking->getValidator();

            $NewBookingValidator = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('PlanT\Danceclub\Domain\Validation\Validator\NewBookingValidator',
            array('options' => ''));
            $validator->addValidator($NewBookingValidator);
        }
    }

    /**
     * This showAction shows the Information and Booking-Form for a by Flexform chosen eventGroup
     * 
     * @param \PlanT\Danceclub\Domain\Model\Booking $newBooking
     * @return void
     */
    public function showAction(\PlanT\Danceclub\Domain\Model\Booking $newBooking = NULL) {
        // Get the eventGroup and all events of that eventGroup
        $eventGroup = $this->eventGroupRepository->findAllByUid($this->settings['eventgroup']);
        $events = $this->eventRepository->findBookableByEventGroups($this->settings['eventgroup'], $this->settings['eventtypes'], true);

        // Pass all Data to Fluid 
        $multipleArray = Array(
            'eventGroup' => $eventGroup->getFirst(), 
            'events' => $events, 
            'danceStyleOptions' => $this->getDanceStyleOptions(), 
            'eventDates' => $this->getEventOccurences($events),
            'booking' => $newBooking
            );
        
        $this->view->assignMultiple($multipleArray);
    }

    /**
     * This Action shows the most recent eventGroup that is active, and 
     *
     * @param \PlanT\Danceclub\Domain\Model\Booking $newBooking
     * @return void
     */
    public function showLatestAction(\PlanT\Danceclub\Domain\Model\Booking $newBooking = NULL) {
        // Get the most recent EventGroup and its Events
        $eventGroup = $this->eventGroupRepository->findLatest();
        $events = $this->eventRepository->findBookableByEventGroups($eventGroup->getFirst()->getUid(), $this->settings['eventtypes'], true);

        // Pass all Data to Fluid 
        $multipleArray = Array(
            'eventGroup' => $eventGroup->getFirst(), 
            'events' => $events, 
            'danceStyleOptions' => $this->getDanceStyleOptions(), 
            'eventDates' => $this->getEventOccurences($events),
            'booking' => $newBooking
            );
        
        $this->view->assignMultiple($multipleArray);
    }

    /**
     * Create a new Booking from FE Input
     * 
     * @param \PlanT\Danceclub\Domain\Model\Booking $newBooking
     * @validate $newBooking \PlanT\Danceclub\Domain\Validation\Validator\NewBookingValidator
     * @return void
     */
    public function createBookingAction(\PlanT\Danceclub\Domain\Model\Booking $newBooking)
    {
        $bookingData = $this->request->getArgument('newBooking');
        foreach ($bookingData['events']['__identity'] as $eventUid){
            $event = $this->eventRepository->findByUid($eventUid);
            //print_r($event->getPrice());
            $newBooking->increaseAmount($event->getPrice());
            $newBooking->increaseInvoiceAmount($event->getPrice());
            $newBooking->addEvent($event);
        }

        if(count($bookingData['events']['__identity']) > 1) {
            $newBooking->applyReductionAmount(0.9);
            $newBooking->applyReductionInvoiceAmount(0.9); 
        }
        
        $this->bookingRepository->add($newBooking);
        //var_dump();

        $multipleArray = Array(
            'booking' => $newBooking
            //'error' => $error
            );
        
        $this->view->assignMultiple($multipleArray);
        //$this->redirect('show', 'EventGroup', 'danceclub', null, $pageUid=null, '');
    }
    
    /**
     * Get all Dates and Times for each event in a given Event object 
     * 
     * @param  $events
     * @return array HDNET\Calendarize\Domain\Model\Index
     */
    public function getEventOccurences($events)
    {
        // Get all Occurence Data from Calendarize
        foreach ($events as $event){
            $allEventDates[] = $this->indexRepository->findByEvent($event);
        }
        return $allEventDates;
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
     * action create
     * 
     * @param \PlanT\Danceclub\Domain\Model\Booking $newBooking
     * @return void
     *
    public function depAction(\PlanT\Danceclub\Domain\Model\Booking $newBooking)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See <a href="http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain" target="_blank">Wiki</a>', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);

        $this->request->getArguments();
        $this->request->getArgument('variable');

        $this->bookingRepository->add($newBooking);
        $this->redirect('list');
    }*/

}