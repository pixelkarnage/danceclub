<?php
namespace PlanT\Danceclub\Domain\Model;

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
 * EventGroup
 */
class EventGroup extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * The name of the EventGroup
     * 
     * @var string
     * @validate NotEmpty
     */
    protected $title = '';
    
    /**
     * Subtitle
     * 
     * @var string
     * @validate NotEmpty
     */
    protected $subtitle = '';
    
    /**
     * Default is active. Enables booking of events.
     * 
     * @var bool
     */
    protected $activateBooking = FALSE;
    
    /**
     * description
     * 
     * @var string
     */
    protected $description = '';
    
    /**
     * Booking is closed Message.
     * 
     * @var string
     */
    protected $closedBookingMessage = '';
    
    /**
     * Confirmation Message for a booking
     * 
     * @var string
     */
    protected $confirmBookingMessage = '';

    /**
     * __construct
     */
    public function __construct()
    {
        //Do not remove the next line: It would break the functionality
        $this->initStorageObjects();
    }

    /**
     * Returns the title
     * 
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }
    
    /**
     * Sets the title
     * 
     * @param string $title
     * @return void
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }
    
    /**
     * Returns the subtitle
     * 
     * @return string $subtitle
     */
    public function getSubtitle()
    {
        return $this->subtitle;
    }
    
    /**
     * Sets the subtitle
     * 
     * @param string $subtitle
     * @return void
     */
    public function setSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;
    }
    
    /**
     * Returns the activateBooking
     * 
     * @return boolean $activateBooking
     */
    public function getActivateBooking()
    {
        return $this->activateBooking;
    }
    
    /**
     * Sets the activateBooking
     * 
     * @param boolean $activateBooking
     * @return void
     */
    public function setActivateBooking($activateBooking)
    {
        $this->activateBooking = $activateBooking;
    }
    
    /**
     * Returns the boolean state of activateBooking
     * 
     * @return boolean
     */
    public function isActivateBooking()
    {
        return $this->activateBooking;
    }
    
    /**
     * Returns the description
     * 
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }
    
    /**
     * Sets the description
     * 
     * @param string $description
     * @return void
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }
    
    /**
     * Returns the closedBookingMessage
     * 
     * @return string $closedBookingMessage
     */
    public function getClosedBookingMessage()
    {
        return $this->closedBookingMessage;
    }
    
    /**
     * Sets the closedBookingMessage
     * 
     * @param string $closedBookingMessage
     * @return void
     */
    public function setClosedBookingMessage($closedBookingMessage)
    {
        $this->closedBookingMessage = $closedBookingMessage;
    }
    
    /**
     * Returns the confirmBookingMessage
     * 
     * @return string $confirmBookingMessage
     */
    public function getConfirmBookingMessage()
    {
        return $this->confirmBookingMessage;
    }
    
    /**
     * Sets the confirmBookingMessage
     * 
     * @param string $confirmBookingMessage
     * @return void
     */
    public function setConfirmBookingMessage($confirmBookingMessage)
    {
        $this->confirmBookingMessage = $confirmBookingMessage;
    }
    

}