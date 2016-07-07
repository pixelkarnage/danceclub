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
 * The repository for Events
 */
class EventRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
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
     * @param int $eventGroups id of record
     * @param var $types \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\PlanT\Danceclub\Domain\Model\Type>
     * @param bool $respectBookable if set to false, all records are shown, if set to true only bookable events will be shown
     * @param bool $respectEnableFields if set to false, hidden records are shown
     * @return \PlanT\Danceclub\Domain\Model\Event
     */
    public function findByEventGroups($eventGroups, $types = NULL, $respectBookable = false, $respectEnableFields = true)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->getQuerySettings()->setRespectSysLanguage(false);

        $constraints = array();
        $constraints[] = $query->contains('eventGroups', $eventGroups);

        if ($respectBookable == true) {
           $constraints[] = $query->equals('bookable', true); 
        }
        
        // if in() is empty the query will fail  
        if ($types != NULL) {
            $constrains[] = $query->in('types', explode(',', $types));
        }

        $query->matching($query->logicalAnd($constraints));

        /*/debug
        $parser = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Storage\\Typo3DbQueryParser');  
        $queryParts = $parser->parseQuery($query); 
        \TYPO3\CMS\Core\Utility\DebugUtility::debug($queryParts, 'Query');*/

        return $query->execute();
    }

    /**
     * find with a uid list
     *
     * @param array $uids uid of record
     * @return \PlanT\Danceclub\Domain\Model\Event
     */
    public function findAllByUid($uids)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectSysLanguage(FALSE);   
        $query->getQuerySettings()->setRespectStoragePage(FALSE);
       

        $query->matching($query->equals('uid', $uids));

        return $query->execute();
    }
}