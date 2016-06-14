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
 * Booking
 */
class Booking extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * The name of the Person booking
     * 
     * @var string
     * @validate NotEmpty
     */
    protected $name = '';
    
    /**
     * contact email
     * 
     * @var string
     * @validate EmailAddress
     */
    protected $email = '';
    
    /**
     * Follower/Leader/Both
     * 
     * @var int
     * @validate Integer
     */
    protected $danceStyle = 0;
    
    /**
     * student
     * 
     * @var bool
     * @validate Boolean
     */
    protected $student = FALSE;
    
    /**
     * User comment on his order/booking
     * 
     * @var string
     * @validate Text
     */
    protected $comment = '';
    
    /**
     * amount
     * 
     * @var float
     */
    protected $amount = 0.0;
    
    /**
     * How much is owed still
     * 
     * @var float
     */
    protected $invoiceAmount = 0.0;
    
    /**
     * This booking is canceled.
     * 
     * @var bool
     */
    protected $canceled = FALSE;
    
    /**
     * events
     * 
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\PlanT\Danceclub\Domain\Model\Event>
     * @validate NotEmpty
     */
    protected $events = NULL;
    
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
        $this->events = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
     * Returns the email
     * 
     * @return string $email
     */
    public function getEmail()
    {
        return $this->email;
    }
    
    /**
     * Sets the email
     * 
     * @param string $email
     * @return void
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }
    
    /**
     * Returns the danceStyle
     * 
     * @return integer $danceStyle
     */
    public function getDanceStyle()
    {
        return $this->danceStyle;
    }
    
    /**
     * Sets the danceStyle
     * 
     * @param integer $danceStyle
     * @return void
     */
    public function setDanceStyle($danceStyle)
    {
        $this->danceStyle = $danceStyle;
    }
    
    /**
     * Returns the student
     * 
     * @return boolean $student
     */
    public function getStudent()
    {
        return $this->student;
    }
    
    /**
     * Sets the student
     * 
     * @param boolean $student
     * @return void
     */
    public function setStudent($student)
    {
        $this->student = $student;
    }
    
    /**
     * Returns the boolean state of student
     * 
     * @return boolean
     */
    public function isStudent()
    {
        return $this->student;
    }
    
    /**
     * Returns the comment
     * 
     * @return string $comment
     */
    public function getComment()
    {
        return $this->comment;
    }
    
    /**
     * Sets the comment
     * 
     * @param string $comment
     * @return void
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }
    
    /**
     * Returns the amount
     * 
     * @return float $amount
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * increases the amount by $increase
     * 
     * @param float $increase
     * @return float $amount
     */
    public function increaseAmountBy($increase)
    {
        $this->amount = $this->amount + $increase;
        return $this->amount;
    }
    
    /**
     * Returns the amount
     * 
     * @param float $increase
     * @return float $amount
     */
    public function decreaseAmountBy($decrease)
    {
        $this->amount = $this->amount - $decrease;
        return $this->amount;
    }

    /**
     * Sets the amount
     * 
     * @param float $amount
     * @return void
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }
    
    /**
     * Returns the invoiceAmount
     * 
     * @return float $invoiceAmount
     */
    public function getInvoiceAmount()
    {
        return $this->invoiceAmount;
    }
   
    /**
     * increases the invoiceAmount by $increase
     * 
     * @param float $increase
     * @return float $invoiceAmount
     */
    public function increaseInvoiceAmountBy($increase)
    {
        $this->invoiceAmount = $this->invoiceAmount + $increase;
        return $this->invoiceAmount;
    }
    
    /**
     * Returns the invoiceAmount
     * 
     * @param float $increase
     * @return float $invoiceAmount
     */
    public function decreaseInvoiceAmountBy($decrease)
    {
        $this->invoiceAmount = $this->invoiceAmount + $decrease;
        return $this->invoiceAmount;
    }

    /**
     * Sets the invoiceAmount
     * 
     * @param float $invoiceAmount
     * @return void
     */
    public function setInvoiceAmount($invoiceAmount)
    {
        $this->invoiceAmount = $invoiceAmount;
    }

    /**
     * apply reduction
     * 
     * @param float $percentage in 0.x format
     * @return void
     */
    public function invoiceAmountReductionBy($percentage)
    {
        $this->invoiceAmount = $this->roundUpToAny($this->invoiceAmount*$percentage);
    }
    
    /**
     * Round upt to any Number
     * 
     * @param float $n
     * @param int $x
     * @return int
     */
    private function roundUpToAny($n,$x=5) 
    {
        return (round($n)%$x === 0) ? round($n) : round(($n+$x/2)/$x)*$x;
    }

    /**
     * apply reduction
     * 
     * @param float $percentage in 0.x format
     * @return void
     */
    public function amountReductionBy($percentage)
    {
        $this->amount = $this->roundUpToAny($this->amount*$percentage);
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
     * Adds a Event
     * 
     * @param \PlanT\Danceclub\Domain\Model\Event $event
     * @return void
     */
    public function addEvent(\PlanT\Danceclub\Domain\Model\Event $event)
    {
        $this->events->attach($event);
    }
    
    /**
     * Removes a Event
     * 
     * @param \PlanT\Danceclub\Domain\Model\Event $eventToRemove The Event to be removed
     * @return void
     */
    public function removeEvent(\PlanT\Danceclub\Domain\Model\Event $eventToRemove)
    {
        $this->events->detach($eventToRemove);
    }
    
    /**
     * Returns the events
     * 
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\PlanT\Danceclub\Domain\Model\Event> $events
     */
    public function getEvents()
    {
        return $this->events;
    }
    
    /**
     * Sets the events
     * 
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\PlanT\Danceclub\Domain\Model\Event> $events
     * @return void
     */
    public function setEvents(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $events)
    {
        $this->events = $events;
    }

}