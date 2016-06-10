<?php
/**
 * BookingRequestValidator
 */
namespace PlanT\Danceclub\Validation\Validator;

use TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator;
use TYPO3\CMS\Extbase\Validation\Validator\ConjunctionValidator;
use TYPO3\CMS\Extbase\Validation\ValidatorResolver;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use PlanT\Danceclub\Domain\Model\Booking;
use PlanT\Danceclub\Domain\Model\Event;

/**
 * BookingRequestValidator
 */
class NewBookingValidator extends TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator
{
    /**
    * Booking repository
    *
    * @var \NAMESPACE\Extname\Domain\Repository\BookingRepository
    * @inject
    */
    protected $bookingRepository;

    /**
    * Event repository
    *
    * @var \NAMESPACE\Extname\Domain\Repository\EventRepository
    * @inject
    */
    protected $eventRepository;


    /**
     * Check the passed Object
     *
     * @param $newBooking PlanT\Danceclub\Domain\Model\Booking
     * @return void
     */
    protected function isValid(PlanT\Danceclub\Domain\Model\Booking $newBooking)
    {
        print_r('iwasherer');

        $bookingData = $this->request->getArgument('newBooking');
        if (is_numeric($this->request->getArgument('eventGroup')) && !empty($this->request->getArgument('eventGroup'))){
            $eventGroup = $this->eventGroupRepository->findByUid($this->request->getArgument('eventGroup'));
            if($eventGroup && $eventGroup->getActivateBooking()==true) {
                $eventUids = $bookingData['events']['__identity'];
                if(!empty($eventUids)){
                    foreach ($eventUids as $eventUid){
                        if (is_numeric($eventUid)){
                            $event = $this->eventRepository->findByUid($eventUid);
                            if ($event->getEventGroup()->current()->getUid() == $eventGroup->getUid()) {
                            } else {
                                $this->result->forProperty('events', addError(new Error('Your event ('.$event->getName().') is part of '.$event->getEventGroup()->current()->getName().' and not '.$eventGroup->getName(), time()));
                                return false;
                            }
                        } else {
                            $this->result->forProperty('events', addError(new Error('The selected Event is not a valid for this eventgroup.',time()));
                            return false;
                        }
                    }
                } else {
                    $this->result->forProperty('events', addError(new Error('No events have been selected ...', time()));
                    print_r('i was herer');
                    return false;
                }
            } else {
                $this->result->forProperty('events', addError(new Error('Booking is disabled for '.$eventGroup->getName(), time()));
                return false;
            }
        } else {
            $this->result->forProperty('events', addError(new Error('Ahhh, we have a problem! Try again.', time()));
            return false;
        }
        return ture
    }
}
