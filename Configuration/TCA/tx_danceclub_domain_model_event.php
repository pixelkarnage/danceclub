<?php
return array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:danceclub/Resources/Private/Language/locallang_db.xlf:tx_danceclub_domain_model_event',
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
		'enablecolumns' => array(),
		'searchFields' => 'name,description,bookable,price,force_partner,max_bookings,min_bookings,disco_jokey,teachers,types,venues,event_groups,',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('danceclub') . 'Resources/Public/Icons/tx_danceclub_domain_model_event.png'
	),
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, name, description, bookable, price, force_partner, max_bookings, min_bookings, disco_jokey, teachers, types, venues, event_groups',
	),
	'types' => array(
		'1' => array('showitem' => '--div--;LLL:EXT:danceclub/Resources/Private/Language/locallang_db.xlf:tx_danceclub_domain_model_event.tab.general, name, disco_jokey, price, description;;;richtext:rte_transform[mode=ts_links],
			--div--;LLL:EXT:danceclub/Resources/Private/Language/locallang_db.xlf:tx_danceclub_domain_model_event.tab.links, event_groups, types, teachers, venues, 
			--div--;LLL:EXT:danceclub/Resources/Private/Language/locallang_db.xlf:tx_danceclub_domain_model_event.tab.partner, bookable, force_partner, max_bookings, min_bookings,'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
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
				'foreign_table' => 'tx_danceclub_domain_model_event',
				'foreign_table_where' => 'AND tx_danceclub_domain_model_event.pid=###CURRENT_PID### AND tx_danceclub_domain_model_event.sys_language_uid IN (-1,0)',
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
			'label' => 'LLL:EXT:danceclub/Resources/Private/Language/locallang_db.xlf:tx_danceclub_domain_model_event.name',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'description' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:danceclub/Resources/Private/Language/locallang_db.xlf:tx_danceclub_domain_model_event.description',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim',
				'wizards' => array(
					'RTE' => array(
						'icon' => 'wizard_rte2.gif',
						'notNewRecords'=> 1,
						'RTEonly' => 1,
						'module' => array(
							'name' => 'wizard_rich_text_editor',
							'urlParameters' => array(
								'mode' => 'wizard',
								'act' => 'wizard_rte.php'
							)
						),
						'title' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:bodytext.W.RTE',
						'type' => 'script'
					)
				)
			),
		),
		'bookable' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:danceclub/Resources/Private/Language/locallang_db.xlf:tx_danceclub_domain_model_event.bookable',
			'config' => array(
				'type' => 'check',
				'default' => 0
			)
		),
		'price' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:danceclub/Resources/Private/Language/locallang_db.xlf:tx_danceclub_domain_model_event.price',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'double2'
			)
		),
		'force_partner' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:danceclub/Resources/Private/Language/locallang_db.xlf:tx_danceclub_domain_model_event.force_partner',
			'config' => array(
				'type' => 'check',
				'default' => 0
			)
		),
		'max_bookings' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:danceclub/Resources/Private/Language/locallang_db.xlf:tx_danceclub_domain_model_event.max_bookings',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			)
		),
		'min_bookings' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:danceclub/Resources/Private/Language/locallang_db.xlf:tx_danceclub_domain_model_event.min_bookings',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			)
		),
		'disco_jokey' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:danceclub/Resources/Private/Language/locallang_db.xlf:tx_danceclub_domain_model_event.disco_jokey',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'teachers' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:danceclub/Resources/Private/Language/locallang_db.xlf:tx_danceclub_domain_model_event.teachers',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectMultipleSideBySide',
				'foreign_table' => 'fe_users',
				'foreign_table_where' => 'ORDER BY fe_users.name ASC',
				'MM' => 'tx_danceclub_event_frontenduser_mm',
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
							'table' => 'fe_users',
							'pid' => '###CURRENT_PID###',
							'setValue' => 'prepend'
						),
					),
				),
			),
		),
		'types' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:danceclub/Resources/Private/Language/locallang_db.xlf:tx_danceclub_domain_model_event.types',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectMultipleSideBySide',
				'foreign_table' => 'tx_danceclub_domain_model_type',
				'foreign_table_where' => 'ORDER BY tx_danceclub_domain_model_type.event_type ASC',
				'MM' => 'tx_danceclub_event_type_mm',
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
							'table' => 'tx_danceclub_domain_model_type',
							'pid' => '###CURRENT_PID###',
							'setValue' => 'prepend'
						),
					),
				),
			),
		),
		'event_groups' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:danceclub/Resources/Private/Language/locallang_db.xlf:tx_danceclub_domain_model_event.event_groups',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectMultipleSideBySide',
				'foreign_table' => 'tx_danceclub_domain_model_eventgroup',
				'foreign_table_where' => 'ORDER BY tx_danceclub_domain_model_eventgroup.crdate DESC',
				'MM' => 'tx_danceclub_event_eventgroup_mm',
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
							'table' => 'tx_danceclub_domain_model_eventgroup',
							'pid' => '###CURRENT_PID###',
							'setValue' => 'prepend'
						),
					),
				),
			),
		),

		'venues' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:danceclub/Resources/Private/Language/locallang_db.xlf:tx_danceclub_domain_model_event.venues',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectMultipleSideBySide',
				'foreign_table' => 'tx_danceclub_domain_model_venue',
				'foreign_table_where' => 'ORDER BY tx_danceclub_domain_model_venue.name ASC',
				'MM' => 'tx_danceclub_event_venue_mm',
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
							'table' => 'tx_danceclub_domain_model_venue',
							'pid' => '###CURRENT_PID###',
							'setValue' => 'prepend'
						),
					),
				),
			),
		),
		
	),
);

