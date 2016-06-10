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
 * Test case for class \PlanT\Danceclub\Domain\Model\Type.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Samuel Scherer <samuel.scherer@protonmail.ch>
 */
class TypeTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
	/**
	 * @var \PlanT\Danceclub\Domain\Model\Type
	 */
	protected $subject = NULL;

	public function setUp()
	{
		$this->subject = new \PlanT\Danceclub\Domain\Model\Type();
	}

	public function tearDown()
	{
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function getEventTypeReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getEventType()
		);
	}

	/**
	 * @test
	 */
	public function setEventTypeForStringSetsEventType()
	{
		$this->subject->setEventType('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'eventType',
			$this->subject
		);
	}
}
