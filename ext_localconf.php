<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'PlanT.' . $_EXTKEY,
	'Danceclub',
	array(
		'DanceClub' => 'show,showLatest,createBooking',
		'Administration' => 'index,detail,newEventGroup,newEvent,newBooking,newType,newVenue',
		
	),
	// non-cacheable actions
	array(
		'DanceClub' => '',
		'Administration' => 'detail,newEventGroup,newEvent,newBooking,newType,newVenue',
	)
);

$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
$danceclubIcons = array( 
	array('identifier' => 'danceclub-calendar-o', 'name' => 'calendar-o'),
	array('identifier' => 'danceclub-envelope', 'name' => 'envelope'), 
	array('identifier' => 'danceclub-envelope-o', 'name' => 'envelope-o'),
	array('identifier' => 'danceclub-check', 'name' => 'check'), 
	array('identifier' => 'danceclub-check-square', 'name' => 'check-square'), 
	array('identifier' => 'danceclub-check-square-o', 'name' => 'check-square-o'),
	array('identifier' => 'danceclub-archive', 'name' => 'archive'),
	array('identifier' => 'danceclub-sign-in', 'name' => 'sign-in'),
	array('identifier' => 'danceclub-map-o', 'name' => 'map-o'),
	array('identifier' => 'danceclub-tag', 'name' => 'tag'),
	array('identifier' => 'danceclub-danceStyle-0', 'name' => 'transgender-alt'),
	array('identifier' => 'danceclub-danceStyle-1', 'name' => 'mars'),
	array('identifier' => 'danceclub-danceStyle-2', 'name' => 'venus'),
	array('identifier' => 'danceclub-google', 'name' => 'google'),
	array('identifier' => 'danceclub-cloud-upload', 'name' => 'cloud-upload'),
	array('identifier' => 'danceclub-fax', 'name' => 'fax'),
	array('identifier' => 'danceclub-plus', 'name' => 'plus'),
);

foreach ($danceclubIcons as $danceclubIcon) {
	$iconRegistry->registerIcon(
		$danceclubIcon['identifier'],
		\TYPO3\CMS\Core\Imaging\IconProvider\FontawesomeIconProvider::class,
		array('name' => $danceclubIcon['name'])
		);
}