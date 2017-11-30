<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function()
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'Sle.Simpleaddress',
            'Address',
            'Address'
        );

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('simpleaddress', 'Configuration/TypoScript', 'Simple-Address');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_simpleaddress_domain_model_address', 'EXT:simpleaddress/Resources/Private/Language/locallang_csh_tx_simpleaddress_domain_model_address.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_simpleaddress_domain_model_address');

    }
);
