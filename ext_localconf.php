<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'PlanT.' . $_EXTKEY,
	'Danceclub',
	array(
		'DanceClub' => 'show,showLatest,createBooking',
		
	),
	// non-cacheable actions
	array(
		'DanceClub' => '',
	)
);
