<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'PlanT.' . $_EXTKEY,
	'Danceclub',
	'Dance Club'
);

if (TYPO3_MODE === 'BE') {

	/**
	 * Registers a Backend Module
	 */
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
		'PlanT.' . $_EXTKEY,
		'web',	 // Make module a submodule of 'web'
		'danceclubadmin',	// Submodule key
		'',						// Position
		array(
			'Booking' => 'list, edit, new, update',
			'DanceClub' => 'list, edit, new, update',
			
		),
		array(
			'access' => 'user,group',
			'icon'   => 'EXT:' . $_EXTKEY . '/ext_icon.png',
			'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_danceclubadmin.xlf',
		)
	);

}

$pluginSignature = str_replace('_','',$_EXTKEY) . '_danceclub';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform_danceclub.xml');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Tango Club');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_danceclub_domain_model_event', 'EXT:danceclub/Resources/Private/Language/locallang_csh_tx_danceclub_domain_model_event.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_danceclub_domain_model_event');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_danceclub_domain_model_eventgroup', 'EXT:danceclub/Resources/Private/Language/locallang_csh_tx_danceclub_domain_model_eventgroup.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_danceclub_domain_model_eventgroup');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_danceclub_domain_model_booking', 'EXT:danceclub/Resources/Private/Language/locallang_csh_tx_danceclub_domain_model_booking.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_danceclub_domain_model_booking');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_danceclub_domain_model_venue', 'EXT:danceclub/Resources/Private/Language/locallang_csh_tx_danceclub_domain_model_venue.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_danceclub_domain_model_venue');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_danceclub_domain_model_type', 'EXT:danceclub/Resources/Private/Language/locallang_csh_tx_danceclub_domain_model_type.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_danceclub_domain_model_type');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::makeCategorizable(
    $_EXTKEY,
    'tx_danceclub_domain_model_eventgroup'
);
