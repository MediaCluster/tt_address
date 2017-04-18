<?php
$settings = \TYPO3\TtAddress\Utility\SettingsUtility::getSettings();

$version7 = \TYPO3\CMS\Core\Utility\GeneralUtility::compat_version('7.0');

return array(
    'ctrl' => array(
        'label' => 'name',
        'label_alt' => 'email',
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'sortby' => 'sorting',
        'default_sortby' => 'ORDER BY last_name, first_name, middle_name',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'prependAtCopy' => 'LLL:EXT:lang/locallang_general.xlf:LGL.prependAtCopy',
        'delete' => 'deleted',
        'title' => 'LLL:EXT:tt_address/Resources/Private/Language/locallang_tca.xlf:tt_address',
        'versioningWS' => true,
        'origUid' => 't3_origuid',
        'thumbnail' => 'image',
        'enablecolumns' => array(
            'disabled' => 'hidden'
        ),
        'iconfile' => $version7 ? 'EXT:tt_address/ext_icon.gif' : \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('tt_address') . 'ext_icon.gif',
        'searchFields' => 'name, first_name, middle_name, last_name, email',
        'dividers2tabs' => 1,
    ),
    'interface' => array(
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden,first_name,middle_name,last_name,address,building,room,city,zip,region,country,phone,fax,email,www,title,company,image'
    ),
    'columns' => array(
        'pid' => array(
            'label' => 'pid',
            'config' => array(
                'type' => 'passthrough'
            )
        ),
        'crdate' => array(
            'label' => 'crdate',
            'config' => array(
                'type' => 'passthrough',
            )
        ),
        'cruser_id' => array(
            'label' => 'cruser_id',
            'config' => array(
                'type' => 'passthrough'
            )
        ),
        'tstamp' => array(
            'label' => 'tstamp',
            'config' => array(
                'type' => 'passthrough',
            )
        ),
        'hidden' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
            'config' => array(
                'type' => 'check'
            )
        ),
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
                )
            )
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
                'foreign_table' => 'tt_address',
                'foreign_table_where' => 'AND tt_address.pid=###CURRENT_PID### AND tt_address.sys_language_uid IN (-1,0)',
            )
        ),
        'l10n_diffsource' => array(
            'config' => array(
                'type' => 'passthrough'
            )
        ),
        'gender' => array(
            'l10n_mode' => 'exclude',
            'l10n_display' => 'defaultAsReadonly',
            'label' => 'LLL:EXT:tt_address/Resources/Private/Language/locallang_tca.xlf:tt_address.gender',
            'config' => array(
                'type' => 'radio',
                'default' => 'm',
                'items' => array(
                    array('LLL:EXT:tt_address/Resources/Private/Language/locallang_tca.xlf:tt_address.gender.m', 'm'),
                    array('LLL:EXT:tt_address/Resources/Private/Language/locallang_tca.xlf:tt_address.gender.f', 'f')
                )
            )
        ),
        'title' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.title_person',
            'config' => array(
                'type' => 'input',
                'size' => '8',
                'eval' => 'trim',
                'max' => '255'
            )
        ),
        'name' => array(
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.name',
            'config' => array(
                'type' => 'input',
                'readOnly' => $settings->isReadOnlyNameField(),
                'size' => '40',
                'eval' => 'trim',
                'max' => '255'
            )
        ),
        'first_name' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:tt_address/Resources/Private/Language/locallang_tca.xlf:tt_address.first_name',
            'config' => array(
                'type' => 'input',
                'size' => '20',
                'eval' => 'trim',
                'max' => '255'
            )
        ),
        'middle_name' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:tt_address/Resources/Private/Language/locallang_tca.xlf:tt_address.middle_name',
            'config' => array(
                'type' => 'input',
                'size' => '20',
                'eval' => 'trim',
                'max' => '255'
            )
        ),
        'last_name' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:tt_address/Resources/Private/Language/locallang_tca.xlf:tt_address.last_name',
            'config' => array(
                'type' => 'input',
                'size' => '20',
                'eval' => 'trim',
                'max' => '255'
            )
        ),
        'birthday' => array(
            'l10n_mode' => 'exclude',
            'l10n_display' => 'defaultAsReadonly',
            'exclude' => 1,
            'label' => 'LLL:EXT:tt_address/Resources/Private/Language/locallang_tca.xlf:tt_address.birthday',
            'config' => array(
                'type' => 'input',
                'eval' => 'date',
                'size' => '8',
                'max' => '20'
            )
        ),
        'address' => array(
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.address',
            'config' => array(
                'type' => 'text',
                'cols' => '20',
                'rows' => '3'
            )
        ),
        'building' => array(
            'label' => 'LLL:EXT:tt_address/Resources/Private/Language/locallang_tca.xlf:tt_address.building',
            'config' => array(
                'type' => 'input',
                'eval' => 'trim',
                'size' => '20',
                'max' => '20'
            )
        ),
        'room' => array(
            'label' => 'LLL:EXT:tt_address/Resources/Private/Language/locallang_tca.xlf:tt_address.room',
            'config' => array(
                'type' => 'input',
                'eval' => 'trim',
                'size' => '5',
                'max' => '15'
            )
        ),
        'phone' => array(
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.phone',
            'config' => array(
                'type' => 'input',
                'eval' => 'TYPO3\\TtAddress\\Evaluation\\TelephoneEvaluation',
                'size' => '20',
                'max' => '30'
            )
        ),
        'fax' => array(
            'l10n_mode' => 'exclude',
            'l10n_display' => 'defaultAsReadonly',
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.fax',
            'config' => array(
                'type' => 'input',
                'size' => '20',
                'eval' => 'TYPO3\\TtAddress\\Evaluation\\TelephoneEvaluation',
                'max' => '30'
            )
        ),
        'mobile' => array(
            'l10n_mode' => 'exclude',
            'l10n_display' => 'defaultAsReadonly',
            'exclude' => 1,
            'label' => 'LLL:EXT:tt_address/Resources/Private/Language/locallang_tca.xlf:tt_address.mobile',
            'config' => array(
                'type' => 'input',
                'eval' => 'TYPO3\\TtAddress\\Evaluation\\TelephoneEvaluation',
                'size' => '20',
                'max' => '30'
            )
        ),
        'www' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.www',
            'config' => array(
                'type' => 'input',
                'eval' => 'trim',
                'size' => '20',
                'max' => '255',
                'softref' => 'typolink,url',
                'wizards' => array(
                    '_PADDING' => 2,
                    'link' => array(
                        'type' => 'popup',
                        'title' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:header_link_formlabel',
                        'icon' => $version7 ? 'EXT:backend/Resources/Public/Images/FormFieldWizard/wizard_link.gif' : 'link_popup.gif',
                        'module' => array(
                            'name' => $version7 ? 'wizard_link' : 'wizard_element_browser',
                            'urlParameters' => array(
                                'mode' => 'wizard',
                                'act' => 'url|page'
                            )
                        ),
                        'params' => array(
                            'blindLinkOptions' => 'mail,file,spec,folder',
                        ),
                        'JSopenParams' => 'height=300,width=500,status=0,menubar=0,scrollbars=1',
                    ),
                )
            )
        ),
        'email' => array(
            'l10n_mode' => 'exclude',
            'l10n_display' => 'defaultAsReadonly',
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.email',
            'config' => array(
                'type' => 'input',
                'size' => '20',
                'eval' => 'email',
                'max' => '255',
                'softref' => 'email'
            )
        ),
        'skype' => array(
            'l10n_mode' => 'exclude',
            'l10n_display' => 'defaultAsReadonly',
            'exclude' => 1,
            'label' => 'LLL:EXT:tt_address/Resources/Private/Language/locallang_tca.xlf:tt_address.skype',
            'config' => array(
                'type' => 'input',
                'size' => '20',
                'eval' => 'trim',
                'max' => '255',
                'placeholder' => 'johndoe'
            )
        ),
        'twitter' => array(
            'l10n_mode' => 'exclude',
            'l10n_display' => 'defaultAsReadonly',
            'exclude' => 1,
            'label' => 'LLL:EXT:tt_address/Resources/Private/Language/locallang_tca.xlf:tt_address.twitter',
            'config' => array(
                'type' => 'input',
                'size' => '20',
                'eval' => 'trim',
                'max' => '255',
                'placeholder' => '@johndoe'
            )
        ),
        'facebook' => array(
            'l10n_mode' => 'exclude',
            'l10n_display' => 'defaultAsReadonly',
            'exclude' => 1,
            'label' => 'LLL:EXT:tt_address/Resources/Private/Language/locallang_tca.xlf:tt_address.facebook',
            'config' => array(
                'type' => 'input',
                'size' => '20',
                'eval' => 'trim',
                'max' => '255',
                'placeholder' => '/johndoe'
            )
        ),
        'linkedin' => array(
            'l10n_mode' => 'exclude',
            'l10n_display' => 'defaultAsReadonly',
            'exclude' => 1,
            'label' => 'LLL:EXT:tt_address/Resources/Private/Language/locallang_tca.xlf:tt_address.linkedin',
            'config' => array(
                'type' => 'input',
                'size' => '20',
                'eval' => 'trim',
                'max' => '255',
                'placeholder' => 'johndoe'
            )
        ),
        'company' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:tt_address/Resources/Private/Language/locallang_tca.xlf:tt_address.organization',
            'config' => array(
                'type' => 'input',
                'eval' => 'trim',
                'size' => '20',
                'max' => '255'
            )
        ),
        'position' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:tt_address/Resources/Private/Language/locallang_tca.xlf:tt_address.position',
            'config' => array(
                'type' => 'input',
                'size' => '20',
                'eval' => 'trim',
                'max' => '255'
            )
        ),
        'city' => array(
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.city',
            'config' => array(
                'type' => 'input',
                'size' => '20',
                'eval' => 'trim',
                'max' => '255'
            )
        ),
        'zip' => array(
            'l10n_mode' => 'exclude',
            'l10n_display' => 'defaultAsReadonly',
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.zip',
            'config' => array(
                'type' => 'input',
                'eval' => 'trim',
                'size' => '10',
                'max' => '20'
            )
        ),
        'region' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:tt_address/Resources/Private/Language/locallang_tca.xlf:tt_address.region',
            'config' => array(
                'type' => 'input',
                'size' => '10',
                'eval' => 'trim',
                'max' => '255'
            )
        ),
        'country' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.country',
            'config' => array(
                'type' => 'input',
                'size' => '20',
                'eval' => 'trim',
                'max' => '128'
            )
        ),
        'image' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.image',
            'config' =>\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'image',
                array(
                    'maxitems' => 6,
                    'minitems' => 0,
                    'appearance' => array(
                        'createNewRelationLinkTitle' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:images.addFileReference'
                    ),
                    'foreign_types' => array(
                        '0' => array(
                            'showitem' => '
                              --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                              --palette--;;filePalette'
                        ),
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_TEXT => array(
                            'showitem' => '
                              --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                              --palette--;;filePalette'
                        ),
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => array(
                            'showitem' => '
                              --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                              --palette--;;filePalette'
                        ),
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_AUDIO => array(
                            'showitem' => '
                              --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                              --palette--;;filePalette'
                        ),
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_VIDEO => array(
                            'showitem' => '
                              --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                              --palette--;;filePalette'
                        ),
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_APPLICATION => array(
                            'showitem' => '
                              --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                              --palette--;;filePalette'
                        )
                    )
                ),
                $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
            )
        ),
        'description' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.description',
            'config' => array(
                'type' => 'text',
                'rows' => 5,
                'cols' => 48,
                'softref' => 'typolink_tag,url',
            )
        ),
        'categories' => array(
            'l10n_mode' => 'exclude',
            'l10n_display' => 'defaultAsReadonly',
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_tca.xlf:sys_category.categories',
            'config' => \TYPO3\CMS\Core\Category\CategoryRegistry::getTcaFieldConfiguration('tt_address')
        ),
        'latitude' => array(
            'l10n_mode' => 'exclude',
            'l10n_display' => 'defaultAsReadonly',
            'exclude' => 1,
            'label' => 'LLL:EXT:tt_address/Resources/Private/Language/locallang_tca.xlf:tt_address.latitude',
            'config' => array(
                'type' => 'input',
                'eval' => 'null,TYPO3\\TtAddress\\Evaluation\\LatitudeEvaluation',
                'default' => NULL
            )
        ),
        'longitude' => array(
            'l10n_mode' => 'exclude',
            'l10n_display' => 'defaultAsReadonly',
            'exclude' => 1,
            'label' => 'LLL:EXT:tt_address/Resources/Private/Language/locallang_tca.xlf:tt_address.longitude',
            'config' => array(
                'type' => 'input',
                'eval' => 'null,TYPO3\\TtAddress\\Evaluation\\LongitudeEvaluation',
                'default' => NULL
            )
        ),
    ),
    'types' => array(
        '0' => array('showitem' =>
            'sys_language_uid, l10n_parent, l10n_diffsource, hidden,
              --palette--;LLL:EXT:tt_address/Resources/Private/Language/locallang_tca.xlf:tt_address_palette.name;name,image, description,
             --div--;LLL:EXT:tt_address/Resources/Private/Language/locallang_tca.xlf:tt_address_tab.contact,
             --palette--;LLL:EXT:tt_address/Resources/Private/Language/locallang_tca.xlf:tt_address_palette.address;address,
             --palette--;LLL:EXT:tt_address/Resources/Private/Language/locallang_tca.xlf:tt_address_palette.building;building,
             --palette--;LLL:EXT:tt_address/Resources/Private/Language/locallang_tca.xlf:tt_address_palette.organization;organization,
             --palette--;LLL:EXT:tt_address/Resources/Private/Language/locallang_tca.xlf:tt_address_palette.contact;contact,
             --palette--;LLL:EXT:tt_address/Resources/Private/Language/locallang_tca.xlf:tt_address_palette.social;social,
             --div--;LLL:EXT:lang/locallang_tca.xlf:sys_category.tabs.category, categories
       ')
    ),
    'palettes' => array(
        'name' => array(
            'showitem' => 'name, --linebreak--,
							gender, title, --linebreak--,
							first_name, middle_name, --linebreak--,
							last_name',
            'canNotCollapse' => 1
        ),
        'organization' => array(
            'showitem' => 'position, company',
            'canNotCollapse' => 1
        ),
        'address' => array(
            'showitem' => 'address, --linebreak--,
							city, zip, region, --linebreak--,
							country,  --linebreak--,
							latitude, --linebreak--,
							longitude',
            'canNotCollapse' => 1
        ),
        'building' => array(
            'showitem' => 'building, room',
            'canNotCollapse' => 1
        ),
        'contact' => array(
            'showitem' => 'email, --linebreak--,
							phone, fax, --linebreak--,
							mobile, --linebreak--,
							www, --linebreak--,
							birthday',
            'canNotCollapse' => 1
        ),
        'social' => array(
            'showitem' => 'skype, --linebreak--,
							twitter, --linebreak--,
							facebook, --linebreak--,
							linkedin',
            'canNotCollapse' => 1
        ),
    )
);
