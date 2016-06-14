<?php
namespace PlanT\Danceclub\Tests\Unit\Controller;
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
 * Test case for class PlanT\Danceclub\Controller\EventGroupController.
 *
 * @author Samuel Scherer <samuel.scherer@protonmail.ch>
 */
class EventGroupControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{

	/**
	 * @var \PlanT\Danceclub\Controller\EventGroupController
	 */
	protected $subject = NULL;

	public function setUp()
	{
		$this->subject = $this->getMock('PlanT\\Danceclub\\Controller\\EventGroupController', array('redirect', 'forward', 'addFlashMessage'), array(), '', FALSE);
	}

	public function tearDown()
	{
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function showActionAssignsTheGivenEventGroupToView()
	{
		$eventGroup = new \PlanT\Danceclub\Domain\Model\EventGroup();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('eventGroup', $eventGroup);

		$this->subject->showAction($eventGroup);
	}
}