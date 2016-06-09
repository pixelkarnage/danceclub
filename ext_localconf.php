<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'PlanT.' . $_EXTKEY,
	'Danceclub',
	array(
		'EventGroup' => 'show,showLatest,createBooking',
		
	),
	// non-cacheable actions
	array(
		'EventGroup' => '',
	)
);
