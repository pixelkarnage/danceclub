<?php
namespace PlanT\Danceclub\Domain\Repository;

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
 * The repository for Bookings
 */
class BookingRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{

    /**
     * @var array
     */
    protected $defaultOrderings = array(
        'sorting' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
    );

    /**
     * Find by Evengroups
     *
     * @param int $event \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\PlanT\Danceclub\Domain\Model\Event>
     * @param bool $respectEnableFields if set to false, hidden records are shown
     * @return int
     */
    public function findBookingCountByEvent($event, $respectEnableFields = true)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->getQuerySettings()->setRespectSysLanguage(false);

        if($respectEnableFields == false) {
        	$query->getQuerySettings()->setIgnoreEnableFields(true)->setIncludeDeleted(false);
        }
       
        $constraints = array();
        $constraints[] = $query->equals('canceled', false);
        $constraints[] = $query->contains('events', $event);

        $query->matching($query->logicalAnd($constraints));

        return $query->count();
    }

    /**
     * Find by Evengroups
     *
     * @param int $eventGroup \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\PlanT\Danceclub\Domain\Model\EventGroup>
     * @param bool $respectEnableFields if set to false, hidden records are shown
     * @return int
     */
    public function findBookingsCountByEventGroup($eventGroup, $respectEnableFields = true)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->getQuerySettings()->setRespectSysLanguage(false);

        if($respectEnableFields == false) {
        	$query->getQuerySettings()->setIgnoreEnableFields(true)->setIncludeDeleted(false);
        }

        $constraints = array();
        $constraints[] = $query->equals('canceled', false);
        $constraints[] = $query->contains('eventGroups', $event);

        $query->matching($query->logicalAnd($constraints));

        return $query->count();
    }


}