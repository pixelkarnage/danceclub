<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'PlanT.' . $_EXTKEY,
	'Danceclub',
	array(
		'DanceClub' => 'show,showLatest,createBooking',
		'Administration' => 'index,newEventGroup,newEvent,newBooking,newType,newVenue',
		
	),
	// non-cacheable actions
	array(
		'DanceClub' => '',
		'Administration' => '',
	)
);

$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
$danceclubIcons = array("danceclub-calendar-o", "danceclub-envelope", "danceclub-envelope-o", "danceclub-check", "danceclub-check-square", "danceclub-check-square-o", "danceclub-archive", "danceclub-sign-in", "danceclub-map-o", "danceclub-tag");

foreach ($danceclubIcons as $danceclubIcon) {
	$iconRegistry->registerIcon(
		$danceclubIcon,
		\TYPO3\CMS\Core\Imaging\IconProvider\FontawesomeIconProvider::class,
		array('name' => substr($danceclubIcon, 10))
		);
}