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
 * Test case for class \PlanT\Danceclub\Domain\Model\Event.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Samuel Scherer <trashcash@gmail.com>
 */
class EventTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
	/**
	 * @var \PlanT\Danceclub\Domain\Model\Event
	 */
	protected $subject = NULL;

	public function setUp()
	{
		$this->subject = new \PlanT\Danceclub\Domain\Model\Event();
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
	public function getdescriptionReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getdescription()
		);
	}

	/**
	 * @test
	 */
	public function setdescriptionForStringSetsdescription()
	{
		$this->subject->setdescription('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'description',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getBookableReturnsInitialValueForBool()
	{
		$this->assertSame(
			FALSE,
			$this->subject->getBookable()
		);
	}

	/**
	 * @test
	 */
	public function setBookableForBoolSetsBookable()
	{
		$this->subject->setBookable(TRUE);

		$this->assertAttributeEquals(
			TRUE,
			'bookable',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getPriceReturnsInitialValueForFloat()
	{
		$this->assertSame(
			0.0,
			$this->subject->getPrice()
		);
	}

	/**
	 * @test
	 */
	public function setPriceForFloatSetsPrice()
	{
		$this->subject->setPrice(3.14159265);

		$this->assertAttributeEquals(
			3.14159265,
			'price',
			$this->subject,
			'',
			0.000000001
		);
	}

	/**
	 * @test
	 */
	public function getForcePartnerReturnsInitialValueForBool()
	{
		$this->assertSame(
			FALSE,
			$this->subject->getForcePartner()
		);
	}

	/**
	 * @test
	 */
	public function setForcePartnerForBoolSetsForcePartner()
	{
		$this->subject->setForcePartner(TRUE);

		$this->assertAttributeEquals(
			TRUE,
			'forcePartner',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getMaxBookingsReturnsInitialValueForInt()
	{	}

	/**
	 * @test
	 */
	public function setMaxBookingsForIntSetsMaxBookings()
	{	}

	/**
	 * @test
	 */
	public function getMinBookingsReturnsInitialValueForInt()
	{	}

	/**
	 * @test
	 */
	public function setMinBookingsForIntSetsMinBookings()
	{	}

	/**
	 * @test
	 */
	public function getDiscoJokeyReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getDiscoJokey()
		);
	}

	/**
	 * @test
	 */
	public function setDiscoJokeyForStringSetsDiscoJokey()
	{
		$this->subject->setDiscoJokey('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'discoJokey',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getTeachersReturnsInitialValueForFrontendUser()
	{
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->subject->getTeachers()
		);
	}

	/**
	 * @test
	 */
	public function setTeachersForObjectStorageContainingFrontendUserSetsTeachers()
	{
		$teacher = new \TYPO3\CMS\Extbase\Domain\Model\FrontendUser();
		$objectStorageHoldingExactlyOneTeachers = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$objectStorageHoldingExactlyOneTeachers->attach($teacher);
		$this->subject->setTeachers($objectStorageHoldingExactlyOneTeachers);

		$this->assertAttributeEquals(
			$objectStorageHoldingExactlyOneTeachers,
			'teachers',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function addTeacherToObjectStorageHoldingTeachers()
	{
		$teacher = new \TYPO3\CMS\Extbase\Domain\Model\FrontendUser();
		$teachersObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('attach'), array(), '', FALSE);
		$teachersObjectStorageMock->expects($this->once())->method('attach')->with($this->equalTo($teacher));
		$this->inject($this->subject, 'teachers', $teachersObjectStorageMock);

		$this->subject->addTeacher($teacher);
	}

	/**
	 * @test
	 */
	public function removeTeacherFromObjectStorageHoldingTeachers()
	{
		$teacher = new \TYPO3\CMS\Extbase\Domain\Model\FrontendUser();
		$teachersObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('detach'), array(), '', FALSE);
		$teachersObjectStorageMock->expects($this->once())->method('detach')->with($this->equalTo($teacher));
		$this->inject($this->subject, 'teachers', $teachersObjectStorageMock);

		$this->subject->removeTeacher($teacher);

	}

	/**
	 * @test
	 */
	public function getTypeReturnsInitialValueForType()
	{
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->subject->getType()
		);
	}

	/**
	 * @test
	 */
	public function setTypeForObjectStorageContainingTypeSetsType()
	{
		$type = new \PlanT\Danceclub\Domain\Model\Type();
		$objectStorageHoldingExactlyOneType = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$objectStorageHoldingExactlyOneType->attach($type);
		$this->subject->setType($objectStorageHoldingExactlyOneType);

		$this->assertAttributeEquals(
			$objectStorageHoldingExactlyOneType,
			'type',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function addTypeToObjectStorageHoldingType()
	{
		$type = new \PlanT\Danceclub\Domain\Model\Type();
		$typeObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('attach'), array(), '', FALSE);
		$typeObjectStorageMock->expects($this->once())->method('attach')->with($this->equalTo($type));
		$this->inject($this->subject, 'type', $typeObjectStorageMock);

		$this->subject->addType($type);
	}

	/**
	 * @test
	 */
	public function removeTypeFromObjectStorageHoldingType()
	{
		$type = new \PlanT\Danceclub\Domain\Model\Type();
		$typeObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('detach'), array(), '', FALSE);
		$typeObjectStorageMock->expects($this->once())->method('detach')->with($this->equalTo($type));
		$this->inject($this->subject, 'type', $typeObjectStorageMock);

		$this->subject->removeType($type);

	}

	/**
	 * @test
	 */
	public function getLocationReturnsInitialValueForVenue()
	{
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->subject->getLocation()
		);
	}

	/**
	 * @test
	 */
	public function setLocationForObjectStorageContainingVenueSetsLocation()
	{
		$location = new \PlanT\Danceclub\Domain\Model\Venue();
		$objectStorageHoldingExactlyOneLocation = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$objectStorageHoldingExactlyOneLocation->attach($location);
		$this->subject->setLocation($objectStorageHoldingExactlyOneLocation);

		$this->assertAttributeEquals(
			$objectStorageHoldingExactlyOneLocation,
			'location',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function addLocationToObjectStorageHoldingLocation()
	{
		$location = new \PlanT\Danceclub\Domain\Model\Venue();
		$locationObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('attach'), array(), '', FALSE);
		$locationObjectStorageMock->expects($this->once())->method('attach')->with($this->equalTo($location));
		$this->inject($this->subject, 'location', $locationObjectStorageMock);

		$this->subject->addLocation($location);
	}

	/**
	 * @test
	 */
	public function removeLocationFromObjectStorageHoldingLocation()
	{
		$location = new \PlanT\Danceclub\Domain\Model\Venue();
		$locationObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('detach'), array(), '', FALSE);
		$locationObjectStorageMock->expects($this->once())->method('detach')->with($this->equalTo($location));
		$this->inject($this->subject, 'location', $locationObjectStorageMock);

		$this->subject->removeLocation($location);

	}
}
