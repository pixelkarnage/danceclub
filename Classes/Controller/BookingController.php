<?php
namespace PlanT\Danceclub\Controller;

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

use \TYPO3\CMS\Core\Utility\GeneralUtility;
use \TYPO3\CMS\Extbase\Persistence\QueryInterface;

/**
 * BookingController
 */
class BookingController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * bookingRepository
     * 
     * @var \PlanT\Danceclub\Domain\Repository\BookingRepository
     * @inject
     */
    protected $bookingRepository = NULL;
    
    /**
     * action new
     * 
     * @param \PlanT\Danceclub\Domain\Model\Booking $newBooking
     * @ignorevalidation $newBooking
     * @return void
     */
    public function createAction(\PlanT\Danceclub\Domain\Model\Booking $newBooking = NULL)
    {
        //$this->request->getArguments();
        //$this->request->getArgument('variable');

        \TYPO3\CMS\Core\Utility\DebugUtility::debug($this->request->getArguments());

        //$this->bookingRepository->add($newBooking);
        $this->redirect('show', 'EventGroup');
    }
    
    /**
     * action create
     * 
     * @param \PlanT\Danceclub\Domain\Model\Booking $newBooking
     * @return void
     */
    public function depAction(\PlanT\Danceclub\Domain\Model\Booking $newBooking)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See <a href="http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain" target="_blank">Wiki</a>', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);

        $this->request->getArguments();
        $this->request->getArgument('variable');

        $this->bookingRepository->add($newBooking);
        $this->redirect('list');
    }
}