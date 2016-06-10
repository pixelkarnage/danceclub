<?php

namespace PlanT\Danceclub\Tests\Unit\Domain\Model;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2016 Samuel Scherer <trashcash@gmail.com>, plan-T
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
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
 * Test case for class \PlanT\Danceclub\Domain\Model\Booking.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Samuel Scherer <samuel.scherer@protonmail.ch>
 */
class BookingTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
	/**
	 * @var \PlanT\Danceclub\Domain\Model\Booking
	 */
	protected $subject = NULL;

	public function setUp()
	{
		$this->subject = new \PlanT\Danceclub\Domain\Model\Booking();
	}

	public function tearDown()
	{
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function getNameReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getName()
		);
	}

	/**
	 * @test
	 */
	public function setNameForStringSetsName()
	{
		$this->subject->setName('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'name',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getEmailReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getEmail()
		);
	}

	/**
	 * @test
	 */
	public function setEmailForStringSetsEmail()
	{
		$this->subject->setEmail('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'email',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getDanceStyleReturnsInitialValueForInt()
	{	}

	/**
	 * @test
	 */
	public function setDanceStyleForIntSetsDanceStyle()
	{	}

	/**
	 * @test
	 */
	public function getStudentReturnsInitialValueForBool()
	{
		$this->assertSame(
			FALSE,
			$this->subject->getStudent()
		);
	}

	/**
	 * @test
	 */
	public function setStudentForBoolSetsStudent()
	{
		$this->subject->setStudent(TRUE);

		$this->assertAttributeEquals(
			TRUE,
			'student',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getCommentReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getComment()
		);
	}

	/**
	 * @test
	 */
	public function setCommentForStringSetsComment()
	{
		$this->subject->setComment('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'comment',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getAmountReturnsInitialValueForFloat()
	{
		$this->assertSame(
			0.0,
			$this->subject->getAmount()
		);
	}

	/**
	 * @test
	 */
	public function setAmountForFloatSetsAmount()
	{
		$this->subject->setAmount(3.14159265);

		$this->assertAttributeEquals(
			3.14159265,
			'amount',
			$this->subject,
			'',
			0.000000001
		);
	}

	/**
	 * @test
	 */
	public function getInvoiceAmountReturnsInitialValueForFloat()
	{
		$this->assertSame(
			0.0,
			$this->subject->getInvoiceAmount()
		);
	}

	/**
	 * @test
	 */
	public function setInvoiceAmountForFloatSetsInvoiceAmount()
	{
		$this->subject->setInvoiceAmount(3.14159265);

		$this->assertAttributeEquals(
			3.14159265,
			'invoiceAmount',
			$this->subject,
			'',
			0.000000001
		);
	}

	/**
	 * @test
	 */
	public function getCanceledReturnsInitialValueForBool()
	{
		$this->assertSame(
			FALSE,
			$this->subject->getCanceled()
		);
	}

	/**
	 * @test
	 */
	public function setCanceledForBoolSetsCanceled()
	{
		$this->subject->setCanceled(TRUE);

		$this->assertAttributeEquals(
			TRUE,
			'canceled',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getEventsReturnsInitialValueForEvent()
	{
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->subject->getEvents()
		);
	}

	/**
	 * @test
	 */
	public function setEventsForObjectStorageContainingEventSetsEvents()
	{
		$event = new \PlanT\Danceclub\Domain\Model\Event();
		$objectStorageHoldingExactlyOneEvents = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$objectStorageHoldingExactlyOneEvents->attach($event);
		$this->subject->setEvents($objectStorageHoldingExactlyOneEvents);

		$this->assertAttributeEquals(
			$objectStorageHoldingExactlyOneEvents,
			'events',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function addEventToObjectStorageHoldingEvents()
	{
		$event = new \PlanT\Danceclub\Domain\Model\Event();
		$eventsObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('attach'), array(), '', FALSE);
		$eventsObjectStorageMock->expects($this->once())->method('attach')->with($this->equalTo($event));
		$this->inject($this->subject, 'events', $eventsObjectStorageMock);

		$this->subject->addEvent($event);
	}

	/**
	 * @test
	 */
	public function removeEventFromObjectStorageHoldingEvents()
	{
		$event = new \PlanT\Danceclub\Domain\Model\Event();
		$eventsObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('detach'), array(), '', FALSE);
		$eventsObjectStorageMock->expects($this->once())->method('detach')->with($this->equalTo($event));
		$this->inject($this->subject, 'events', $eventsObjectStorageMock);

		$this->subject->removeEvent($event);

	}
}
