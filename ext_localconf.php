<?php
defined('TYPO3_MODE') or die();

$_EXTCONF = unserialize($_EXTCONF);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addUserTSConfig('
	options.saveDocNew.tt_address = 1
');


if($_EXTCONF['activatePiBase'] == 1) {
  \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPItoST43(
    $_EXTKEY,
    'pi1/class.tx_ttaddress_pi1.php',
    '_pi1',
    'list_type',
    1
  );
}

if (TYPO3_MODE === 'BE') {
    $settings = \TYPO3\TtAddress\Utility\SettingsUtility::getSettings();
    if ($settings->isStoreBackwardsCompatName()) {
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][] =
            'TYPO3\\TtAddress\\Hooks\\DataHandler\\BackwardsCompatibilityNameFormat';
    }
}

/* ===========================================================================
  Custom cache, done with the caching framework
=========================================================================== */
if (!is_array($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['cache_ttaddress_category'])) {
  $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['cache_ttaddress_category'] = array();
}

/* ===========================================================================
  Hooks
=========================================================================== */
if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('realurl')) {
  $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/realurl/class.tx_realurl_autoconfgen.php']['extensionConfiguration']['tt_address'] =
    'TYPO3\\TtAddress\\Hooks\\RealUrlAutoConfiguration->addTtAddressConfig';
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:' . $_EXTKEY . '/Configuration/TSconfig/NewContentElementWizard.ts">');

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
  "TYPO3." . $_EXTKEY,
  'ListView',
  array (
    'Address' => 'list,show'
  ),
  array (
    'Address' => 'list'
  ),
  \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_PLUGIN
);

// Register evaluations for TCA
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tce']['formevals']['TYPO3\\TtAddress\\Evaluation\\TelephoneEvaluation'] = '';
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tce']['formevals']['TYPO3\\TtAddress\\Evaluation\\LatitudeEvaluation'] = '';
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tce']['formevals']['TYPO3\\TtAddress\\Evaluation\\LongitudeEvaluation'] = '';
