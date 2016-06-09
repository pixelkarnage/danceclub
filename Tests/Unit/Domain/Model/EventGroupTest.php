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
 * Test case for class \PlanT\Danceclub\Domain\Model\EventGroup.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Samuel Scherer <trashcash@gmail.com>
 */
class EventGroupTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
	/**
	 * @var \PlanT\Danceclub\Domain\Model\EventGroup
	 */
	protected $subject = NULL;

	public function setUp()
	{
		$this->subject = new \PlanT\Danceclub\Domain\Model\EventGroup();
	}

	public function tearDown()
	{
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function getTitleReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getTitle()
		);
	}

	/**
	 * @test
	 */
	public function setTitleForStringSetsTitle()
	{
		$this->subject->setTitle('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'title',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getSubtitleReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getSubtitle()
		);
	}

	/**
	 * @test
	 */
	public function setSubtitleForStringSetsSubtitle()
	{
		$this->subject->setSubtitle('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'subtitle',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getActivateBookingReturnsInitialValueForBool()
	{
		$this->assertSame(
			FALSE,
			$this->subject->getActivateBooking()
		);
	}

	/**
	 * @test
	 */
	public function setActivateBookingForBoolSetsActivateBooking()
	{
		$this->subject->setActivateBooking(TRUE);

		$this->assertAttributeEquals(
			TRUE,
			'activateBooking',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getDescriptionReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getDescription()
		);
	}

	/**
	 * @test
	 */
	public function setDescriptionForStringSetsDescription()
	{
		$this->subject->setDescription('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'description',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getClosedBookingMessageReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getClosedBookingMessage()
		);
	}

	/**
	 * @test
	 */
	public function setClosedBookingMessageForStringSetsClosedBookingMessage()
	{
		$this->subject->setClosedBookingMessage('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'closedBookingMessage',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getConfirmBookingMessageReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getConfirmBookingMessage()
		);
	}

	/**
	 * @test
	 */
	public function setConfirmBookingMessageForStringSetsConfirmBookingMessage()
	{
		$this->subject->setConfirmBookingMessage('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'confirmBookingMessage',
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
