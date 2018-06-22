<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function()
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'Sle.Simpleaddress',
            'Address',
            'Address',
            'EXT:simpleaddress/Resources/Public/Icons/user_plugin_address.svg'
        );

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('simpleaddress', 'Configuration/TypoScript', 'Simple-Address');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_simpleaddress_domain_model_address', 'EXT:simpleaddress/Resources/Private/Language/locallang_csh_tx_simpleaddress_domain_model_address.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_simpleaddress_domain_model_address');

    }
);

/**
 * Register FlexForms
 */
$flexFormFile = 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/Address.xml';
$pluginSignature = strtolower(str_replace('_', '', $_EXTKEY) . '_address');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'layout,select_key,pages,recursive';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    $pluginSignature,
    $flexFormFile
);

/** @var \TYPO3\CMS\Core\Imaging\IconRegistry $iconRegistry */
$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
$iconRegistry->registerIcon(
    'ext-simpleaddress-ext-icon',
    \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
    ['source' => 'EXT:simpleaddress/Resources/Public/Icons/user_plugin_address.svg']
);
