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

use \PlanT\Danceclub\Domain\Model\Booking;
use \PlanT\Danceclub\Domain\Model\Event;
use \PlanT\Danceclub\Domain\Model\EventGroup;
use TYPO3\CMS\Core\Utility\GeneralUtility;


/**
 * Registration mailer.
 *
 * Responsible for mails regarding bookings.
 */
class BookingMailer extends \PlanT\Danceclub\Mailer\AbstractMailer
{

    /**
     * Delivers registration confirmation mails.
     *
     * @param Registration $registration
     * @return bool
     */
    public function deliverBookingConfirmation(\PlanT\Danceclub\Domain\Model\Booking $booking, \PlanT\Danceclub\Domain\Model\EventGroup $eventGroup)
    {
        if (!$this->mailConfigurationAllowsSendingEmails($this->settings)) {
            return FALSE;
        }

        // Mail for the Attendee
        if($this->settings['confirmationEmail']['attendee']){
            $body = $this->renderEmailTemplate('Attendee.html', ['booking' => $booking,'eventGroup' => $eventGroup]);
            $mail = $this->createMailMessage();
            $mail->setFrom([$this->settings['mailFromAddress'] => $this->settings['mailFromName']);
            $mail->setTo([$booking->getEmail() => $booking->getName()]);
            $mail->setSubject($this->settings['confirmationEmail']['attendee']['subject'].' ('$eventGroup->getTitle().')');
            $mail->setBody($body, 'text/html');
            $mail->send(); 
        }
        
        // Mail for the Organizer
        if($this->settings['confirmationEmail']['organizer']){
            $body = $this->renderEmailTemplate('Organizer.html', ['booking' => $booking,'eventGroup' => $eventGroup]);
            $mail = $this->createMailMessage();
            $mail->setFrom([$this->settings['mailFromAddress'] => $this->settings['mailFromName']);
            $mail->setTo([$this->settings['mailFromAddress'] => $this->settings['mailFromName']);
            $mail->setSubject($this->settings['confirmationEmail']['organizer']['subject'].' ('$eventGroup->getTitle().')');
            $mail->setBody($body, 'text/html');
            $mail->send(); 
        }
    }
    
    /**
     * Helper method to check if the given configuration allows
     * sending emails.
     *
     * @api
     * @param array $configuration
     * @return bool
     */
    public function mailConfigurationAllowsSendingEmails($configuration)
    {
        return !empty($configuration['mailFromAddress']);
    }

}