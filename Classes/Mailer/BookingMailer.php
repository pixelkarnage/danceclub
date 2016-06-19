<?php
namespace \PlanT\Danceclub\Mailer;

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
class BookingMailer extends AbstractMailer
{

    /**
     * Delivers registration confirmation mails.
     *
     * @param Registration $registration
     * @return bool
     */
    public function deliverRegistrationConfirmation(Booking $booking, EventGroup $eventGroup)
    {
        /*$settings = ConfigurationUtility::getTyposcriptConfiguration()['registration.']['confirmationEmail.'];
        $this->prepareMailConfiguration($settings);
        if (!$this->mailConfigurationAllowsSendingEmails($settings)) {
            return FALSE;
        }*/

        $body = $this->renderEmailTemplate(
            'Attendee.html',
            [
                'booking' => $booking,
                'eventGroup' => $eventGroup
            ]
        );
        $mail = $this->createMailMessage();
        $mail->setFrom('info@plan-t.ch');

        $mail->setTo([$booking->getEmail() => $booking->getName()]);
        $mail->setSubject('Kursbuchung im '.$eventGroup->getTitle());
        $mail->setBody($body, 'text/html');
        $mail->send()
        /*if () {
            $registration->setConfirmationSentAt(time());
            $this->registrationRepository->update($registration);
        }

        $instructor = $registration->getWorkshopDate()->getInstructor();
        if (!$instructor) {
            return;
        }*/

        $body = $this->renderEmailTemplate(
            'Teacher.html',
            [
                'booking' => $booking,
                'eventGroup' => $eventGroup
            ]
        );
        $mail = $this->createMailMessage();
        $mail->setFrom('info@plan-t.ch');
        $mail->setTo('info@plan-t.ch');
        $mail->setSubject('Buchung im '.$eventGroup->getTitle());
        $mail->setBody($body, 'text/html');
        $mail->send();
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
    
    /**
     * Prepare mail configuration by setting defaults from either
     * install tool or typoscript.
     *
     * @param array &$config Configuration to eventually adapt
     * @return void
     */
    public function prepareMailConfiguration(&$config)
    {
        /*/ Configuration from install tool
        $mailConfig = ConfigurationUtility::getMailConfiguration();

        // Default configuration from typscript
        $defaultConfig = ConfigurationUtility::getTyposcriptConfiguration()['registration.'];

        if (empty($config['mailFromName'])) {
            if (!empty($defaultConfig['mailFromName'])) {
                $config['mailFromName'] = $defaultConfig['mailFromName'];
            } else {
                $config['mailFromName'] = $mailConfig['defaultMailFromName'];
            }
        }
        if (empty($config['mailFromAddress'])) {
            if (!empty($defaultConfig['mailFromAddress'])) {
                $config['mailFromAddress'] = $defaultConfig['mailFromAddress'];
            } else {
                $config['mailFromAddress'] = $mailConfig['defaultMailFromAddress'];
            }
        }*/
    }

}