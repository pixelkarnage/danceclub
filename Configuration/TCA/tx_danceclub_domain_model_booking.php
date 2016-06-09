<?php
return array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:danceclub/Resources/Private/Language/locallang_db.xlf:tx_danceclub_domain_model_booking',
		'label' => 'name',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'default_sortby' => 'ORDER BY crdate DESC',
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,

		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(

		),
		'searchFields' => 'name,email,dance_style,student,comment,amount,invoice_amount,canceled,events,',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('danceclub') . 'Resources/Public/Icons/tx_danceclub_domain_model_booking.png'
	),
	'interface' => array(
		'showRecordFieldList' => 'name, email, dance_style, student, comment, amount, invoice_amount, canceled, events',
	),
	'types' => array(
		'1' => array('showitem' => '--div--;LLL:EXT:danceclub/Resources/Private/Language/locallang_db.xlf:tx_danceclub_domain_model_booking.tab.personal, canceled, student, name, email, dance_style, comment,
			--div--;LLL:EXT:danceclub/Resources/Private/Language/locallang_db.xlf:tx_danceclub_domain_model_booking.tab.finance, amount, invoice_amount,
			--div--;LLL:EXT:danceclub/Resources/Private/Language/locallang_db.xlf:tx_danceclub_domain_model_booking.tab.events, events'),
	),
	'palettes' => array(
		'1' => array('showitem' => ','),
	),
	'columns' => array(
	
		'sys_language_uid' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xlf:LGL.default_value', 0)
				),
			),
		),
		'l10n_parent' => array(
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => array(
					array('', 0),
				),
				'foreign_table' => 'tx_danceclub_domain_model_booking',
				'foreign_table_where' => 'AND tx_danceclub_domain_model_booking.pid=###CURRENT_PID### AND tx_danceclub_domain_model_booking.sys_language_uid IN (-1,0)',
			),
		),
		'l10n_diffsource' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),

		't3ver_label' => array(
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'max' => 255,
			)
		),

		'name' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:danceclub/Resources/Private/Language/locallang_db.xlf:tx_danceclub_domain_model_booking.name',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'email' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:danceclub/Resources/Private/Language/locallang_db.xlf:tx_danceclub_domain_model_booking.email',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'dance_style' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:danceclub/Resources/Private/Language/locallang_db.xlf:tx_danceclub_domain_model_booking.dance_style',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => array(
					array('LLL:EXT:danceclub/Resources/Private/Language/locallang_db.xlf:tx_danceclub_domain_model_booking.dance_style.0', 0),
					array('LLL:EXT:danceclub/Resources/Private/Language/locallang_db.xlf:tx_danceclub_domain_model_booking.dance_style.1', 1),
					array('LLL:EXT:danceclub/Resources/Private/Language/locallang_db.xlf:tx_danceclub_domain_model_booking.dance_style.2', 2)
				),
				'size' => 1,
				'maxitems' => 1,
				'eval' => ''
			),
		),
		'student' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:danceclub/Resources/Private/Language/locallang_db.xlf:tx_danceclub_domain_model_booking.student',
			'config' => array(
				'type' => 'check',
				'default' => 0
			)
		),
		'comment' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:danceclub/Resources/Private/Language/locallang_db.xlf:tx_danceclub_domain_model_booking.comment',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			)
		),
		'amount' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:danceclub/Resources/Private/Language/locallang_db.xlf:tx_danceclub_domain_model_booking.amount',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'double2'
			)
		),
		'invoice_amount' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:danceclub/Resources/Private/Language/locallang_db.xlf:tx_danceclub_domain_model_booking.invoice_amount',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'double2'
			)
		),
		'canceled' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:danceclub/Resources/Private/Language/locallang_db.xlf:tx_danceclub_domain_model_booking.canceled',
			'config' => array(
				'type' => 'check',
				'default' => 0
			)
		),
		'events' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:danceclub/Resources/Private/Language/locallang_db.xlf:tx_danceclub_domain_model_booking.events',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectMultipleSideBySide',
				'foreign_table' => 'tx_danceclub_domain_model_event',
				'foreign_table_where' => 'AND tx_danceclub_domain_model_event.bookable = 1 ORDER BY tx_danceclub_domain_model_event.crdate DESC',
				'MM' => 'tx_danceclub_booking_event_mm',
				'size' => 10,
				'autoSizeMax' => 30,
				'maxitems' => 9999,
				'multiple' => 0,
				'wizards' => array(
					'_PADDING' => 1,
					'_VERTICAL' => 1,
					'edit' => array(
						'module' => array(
							'name' => 'wizard_edit',
						),
						'type' => 'popup',
						'title' => 'Edit',
						'icon' => 'edit2.gif',
						'popup_onlyOpenIfSelected' => 1,
						'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
						),
					'add' => Array(
						'module' => array(
							'name' => 'wizard_add',
						),
						'type' => 'script',
						'title' => 'Create new',
						'icon' => 'add.gif',
						'params' => array(
							'table' => 'tx_danceclub_domain_model_event',
							'pid' => '###CURRENT_PID###',
							'setValue' => 'prepend'
						),
					),
				),
			),
		),
		
	),
);