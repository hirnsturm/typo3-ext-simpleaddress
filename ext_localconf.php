<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function()
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'Sle.Simpleaddress',
            'Address',
            [
                'Address' => 'show'
            ],
            // non-cacheable actions
            [
                'Address' => ''
            ]
        );

    // wizards
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        'mod {
            wizards.newContentElement.wizardItems.plugins {
                elements {
                    address {
                        icon = ' . \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('simpleaddress') . 'Resources/Public/Icons/user_plugin_address.svg
                        title = LLL:EXT:simpleaddress/Resources/Private/Language/locallang_db.xlf:tx_simpleaddress_domain_model_address
                        description = LLL:EXT:simpleaddress/Resources/Private/Language/locallang_db.xlf:tx_simpleaddress_domain_model_address.description
                        tt_content_defValues {
                            CType = list
                            list_type = simpleaddress_address
                        }
                    }
                }
                show = *
            }
       }'
    );
    }
);
