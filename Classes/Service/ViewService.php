<?php

namespace Sle\Simpleaddress\Service;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Fluid\View\StandaloneView;

/**
 * Class ViewService
 *
 * @package Xima\Simpleaddress
 */
class ViewService
{

    /**
     * Creates and returns StandaloneView-Object for given template
     *
     * @param $extensionKey
     * @param string $template Path to the template (e.g.: 'Address/GoogleMapsInfoWindow')
     * @return object|StandaloneView
     */
    public static function getStandaloneViewObject($extensionKey, $template)
    {
        /** @var ObjectManager $om */
        $om = GeneralUtility::makeInstance(ObjectManager::class);

        /** @var  $view */
        $view = $om->get(StandaloneView::class);
        $view->setFormat('html');
        $view->setTemplateRootPaths(['EXT:/Resources/Private/Templates']);
        $view->setPartialRootPaths(['EXT:' . $extensionKey . '/Resources/Private/Partials']);
        $view->setLayoutRootPaths(['EXT:' . $extensionKey . '/Resources/Private/Layouts']);
        $view->setTemplate($template);

        return $view;
    }

}
