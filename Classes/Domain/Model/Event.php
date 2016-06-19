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
 * Event
 */
class Event extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * name your event.
     * 
     * @var string
     * @validate NotEmpty
     */
    protected $name = '';
    
    /**
     * Describe your event.
     * 
     * @var string
     */
    protected $description = '';
    
    /**
     * Is this event Canceled?
     * 
     * @var bool
     */
    protected $canceled = FALSE;

    /**
     * Is this event Bookable?
     * 
     * @var bool
     */
    protected $bookable = FALSE;
    
    /**
     * set a participation fee.
     * 
     * @var float
     */
    protected $price = 0.0;
    
    /**
     * only accept booking with a dance partner.
     * 
     * @var bool
     */
    protected $forcePartner = FALSE;
    
    /**
     * maximum participants
     * 
     * @var int
     */
    protected $maxBookings = 0;
    
    /**
     * minimum participants
     * 
     * @var int
     */
    protected $minBookings = 0;
    
    /**
     * The DJ for this Event, if there is any known.
     * 
     * @var string
     */
    protected $discoJokey = '';
    
    /**
     * Personel teaching at this event
     * 
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FrontendUser>
     */
    protected $teachers = NULL;
    
    /**
     * Type of event. (Practica, Milonga etc)
     * 
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\PlanT\Danceclub\Domain\Model\Type>
     */
    protected $types = NULL;
    
    /**
     * The place it shall happen
     * 
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\PlanT\Danceclub\Domain\Model\Venue>
     */
    protected $venues = NULL;
    
     /**
     * Event Groups
     * 
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\PlanT\Danceclub\Domain\Model\EventGroup>
     */
    protected $eventGroups = NULL;
    

    /**
     * __construct
     */
    public function __construct()
    {
        //Do not remove the next line: It would break the functionality
        $this->initStorageObjects();
    }
    
    /**
     * Initializes all ObjectStorage properties
     * Do not modify this method!
     * It will be rewritten on each save in the extension builder
     * You may modify the constructor of this class instead
     * 
     * @return void
     */
    protected function initStorageObjects()
    {
        $this->teachers = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->types = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->venues = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->eventGroups = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }
    
    /**
     * Returns the name
     * 
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Sets the name
     * 
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
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
     * Returns the canceled
     * 
     * @return boolean $canceled
     */
    public function getCanceled()
    {
        return $this->canceled;
    }
    
    /**
     * Sets the canceled
     * 
     * @param boolean $canceled
     * @return void
     */
    public function setCanceled($canceled)
    {
        $this->canceled = $canceled;
    }
    
    /**
     * Returns the boolean state of canceled
     * 
     * @return boolean
     */
    public function isCanceled()
    {
        return $this->canceled;
    }
    
    /**
     * Returns the bookable
     * 
     * @return boolean $bookable
     */
    public function getBookable()
    {
        return $this->bookable;
    }
    
    /**
     * Sets the bookable
     * 
     * @param boolean $bookable
     * @return void
     */
    public function setBookable($bookable)
    {
        $this->bookable = $bookable;
    }
    
    /**
     * Returns the boolean state of bookable
     * 
     * @return boolean
     */
    public function isBookable()
    {
        return $this->bookable;
    }
    
    /**
     * Returns the price
     * 
     * @return float $price
     */
    public function getPrice()
    {
        return $this->price;
    }
    
    /**
     * Sets the price
     * 
     * @param float $price
     * @return void
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }
    
    /**
     * Returns the forcePartner
     * 
     * @return boolean $forcePartner
     */
    public function getForcePartner()
    {
        return $this->forcePartner;
    }
    
    /**
     * Sets the forcePartner
     * 
     * @param boolean $forcePartner
     * @return void
     */
    public function setForcePartner($forcePartner)
    {
        $this->forcePartner = $forcePartner;
    }
    
    /**
     * Returns the boolean state of forcePartner
     * 
     * @return boolean
     */
    public function isForcePartner()
    {
        return $this->forcePartner;
    }
    
    /**
     * Returns the maxBookings
     * 
     * @return integer $maxBookings
     */
    public function getMaxBookings()
    {
        return $this->maxBookings;
    }
    
    /**
     * Sets the maxBookings
     * 
     * @param integer $maxBookings
     * @return void
     */
    public function setMaxBookings($maxBookings)
    {
        $this->maxBookings = $maxBookings;
    }
    
    /**
     * Returns the minBookings
     * 
     * @return integer $minBookings
     */
    public function getMinBookings()
    {
        return $this->minBookings;
    }
    
    /**
     * Sets the minBookings
     * 
     * @param integer $minBookings
     * @return void
     */
    public function setMinBookings($minBookings)
    {
        $this->minBookings = $minBookings;
    }
    
    /**
     * Returns the discoJokey
     * 
     * @return string $discoJokey
     */
    public function getDiscoJokey()
    {
        return $this->discoJokey;
    }
    
    /**
     * Sets the discoJokey
     * 
     * @param string $discoJokey
     * @return void
     */
    public function setDiscoJokey($discoJokey)
    {
        $this->discoJokey = $discoJokey;
    }
    
    /**
     * Adds a FrontendUser
     * 
     * @param \TYPO3\CMS\Extbase\Domain\Model\FrontendUser $teacher
     * @return void
     */
    public function addTeacher(\TYPO3\CMS\Extbase\Domain\Model\FrontendUser $teacher)
    {
        $this->teachers->attach($teacher);
    }
    
    /**
     * Removes a FrontendUser
     * 
     * @param \TYPO3\CMS\Extbase\Domain\Model\FrontendUser $teacherToRemove The FrontendUser to be removed
     * @return void
     */
    public function removeTeacher(\TYPO3\CMS\Extbase\Domain\Model\FrontendUser $teacherToRemove)
    {
        $this->teachers->detach($teacherToRemove);
    }
    
    /**
     * Returns the teachers
     * 
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FrontendUser> $teachers
     */
    public function getTeachers()
    {
        return $this->teachers;
    }
    
    /**
     * Sets the teachers
     * 
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FrontendUser> $teachers
     * @return void
     */
    public function setTeachers(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $teachers)
    {
        $this->teachers = $teachers;
    }
    
    /**
     * Adds a Types
     * 
     * @param \PlanT\Danceclub\Domain\Model\Type $types
     * @return void
     */
    public function addTypes(\PlanT\Danceclub\Domain\Model\Type $types)
    {
        $this->types->attach($types);
    }
    
    /**
     * Removes a Types
     * 
     * @param \PlanT\Danceclub\Domain\Model\Type $typesToRemove The Type to be removed
     * @return void
     */
    public function removeTypes(\PlanT\Danceclub\Domain\Model\Type $typesToRemove)
    {
        $this->types->detach($typesToRemove);
    }
    
    /**
     * Returns the types
     * 
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\PlanT\Danceclub\Domain\Model\Type> $types
     */
    public function getTypes()
    {
        return $this->types;
    }
    
    /**
     * Sets the types
     * 
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\PlanT\Danceclub\Domain\Model\Type> $types
     * @return void
     */
    public function setTypes(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $types)
    {
        $this->types = $types;
    }
    
    /**
     * Adds a Venues
     * 
     * @param \PlanT\Danceclub\Domain\Model\Venue $venues
     * @return void
     */
    public function addVenues(\PlanT\Danceclub\Domain\Model\Venue $venues)
    {
        $this->venues->attach($venues);
    }
    
    /**
     * Removes a venues
     * 
     * @param \PlanT\Danceclub\Domain\Model\Venue $venuesToRemove The Venue to be removed
     * @return void
     */
    public function removeVenues(\PlanT\Danceclub\Domain\Model\Venue $venuesToRemove)
    {
        $this->venues->detach($locationToRemove);
    }
    
    /**
     * Returns the venues
     * 
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\PlanT\Danceclub\Domain\Model\Venue> $venues
     */
    public function getVenues()
    {
        return $this->venues;
    }
    
    /**
     * Sets the venues
     * 
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\PlanT\Danceclub\Domain\Model\Venue> $venues
     * @return void
     */
    public function setVenues(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $venues)
    {
        $this->venues = $venues;
    }

    /**
     * Adds a EventGroup
     * 
     * @param \PlanT\Danceclub\Domain\Model\EventGroup $event_groups
     * @return void
     */
    public function addEventGroups(\PlanT\Danceclub\Domain\Model\EventGroup $eventGroups)
    {
        $this->eventGroups->attach($eventGroups);
    }
    
    /**
     * Removes a eventGroup
     * 
     * @param \PlanT\Danceclub\Domain\Model\EventGroup $eventGroupsToRemove The Event to be removed
     * @return void
     */
    public function removeEventGroups(\PlanT\Danceclub\Domain\Model\EventGroup $eventGroupToRemove)
    {
        $this->eventGroups->detach($eventGroupToRemove);
    }
    
    /**
     * Returns the eventGroups
     * 
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\PlanT\Danceclub\Domain\Model\EventGroup> $eventGroups
     */
    public function getEventGroup()
    {
        return $this->eventGroups;
    }
    
    /**
     * Sets the event_groups
     * 
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\PlanT\Danceclub\Domain\Model\EventGroup> $eventGroups
     * @return void
     */
    public function setEventGroup(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $eventGroups)
    {
        $this->eventGroups = $eventGroups;
    }
}