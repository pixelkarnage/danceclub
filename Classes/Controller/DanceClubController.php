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

/**
 * DanceClubController
 */
class DanceClubController extends \PlanT\Danceclub\Controller\AbstractController
{
    /**
     * This showAction shows the Information and Booking-Form for a by Flexform chosen eventGroup or the latest EventGroup
     * 
     * @param \PlanT\Danceclub\Domain\Model\Booking $newBooking
     * @param bool $showLatestFlag 
     * @return void
     */
    public function showAction(\PlanT\Danceclub\Domain\Model\Booking $newBooking = NULL, $showLatestFlag = false) 
    {
        if ($showLatestFlag == false) 
        {
            // Get the eventGroup and all events of that eventGroup
            $eventGroup = $this->eventGroupRepository->findAllByUid($this->settings['eventgroup']);
            $events = $this->eventRepository->findByEventGroups($this->settings['eventgroup'], $this->settings['eventtypes'], true, true);
        } else {
            // Get the most recent EventGroup and its Events
            $eventGroup = $this->eventGroupRepository->findLatest();
            $events = $this->eventRepository->findByEventGroups($eventGroup->getFirst()->getUid(), $this->settings['eventtypes'], true, true);
        }        

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
    public function showLatestAction(\PlanT\Danceclub\Domain\Model\Booking $newBooking = NULL) 
    {
        $this->showAction($newBooking, true);
    }

    /**
     * Create a new Booking from FE Input
     * 
     * @param \PlanT\Danceclub\Domain\Model\Booking $newBooking
     * @return void
     */
    public function createBookingAction(\PlanT\Danceclub\Domain\Model\Booking $newBooking)
    {
        foreach ($newBooking->getEvents() as $event){
            $newBooking->increaseAmountBy($event->getPrice());
            $newBooking->increaseInvoiceAmountBy($event->getPrice());
        }

        if (is_numeric($this->request->getArgument('eventGroup')) && !empty($this->request->getArgument('eventGroup'))){
            $eventGroup = $this->eventGroupRepository->findByUid($this->request->getArgument('eventGroup'));
            
            if(count($newBooking->getEvents()) > 1)
            {
                // TODO implement a ReductionSettings System
                //$reductionSettings = eventGroup->getReductionSettings();
                //$newBooking->amountReductionBy($reducitonSettings->getPercentage());
                // Or something like that ...
                // For now let's give 10% discount
                $newBooking->amountReductionBy(0.9);
                $newBooking->invoiceAmountReductionBy(0.9);   
            }
        }

        $this->bookingRepository->add($newBooking);
        $this->bookingMailer->deliverBookingConfirmation($newBooking, $eventGroup);

        $multipleArray = Array(
            'booking' => $newBooking,
            'danceStyleOptions' => $this->getDanceStyleOptions(),
            'eventGroup' => $eventGroup
            );
        
        $this->view->assignMultiple($multipleArray);
    }
}