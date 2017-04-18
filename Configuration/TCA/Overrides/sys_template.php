<?php
defined('TYPO3_MODE') or die();

$_EXTKEY = 'tt_address';
$extConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY]);

// Add static templates
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript/', 'Addresses (Extbase/Fluid)');

// Old templates; to be removed soonish
if($extConf['activatePiBase'] == 1) {
  \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript/pi1/', 'Addresses (deprecated)');
  \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript/old/', 'Addresses (!!!old, only use if you need to!!!)');
}
