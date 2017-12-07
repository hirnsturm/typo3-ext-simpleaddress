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
     * @param array $viewPaths
     * @param string $template Path to the template (e.g.: 'Address/GoogleMapsInfoWindow')
     * @param string $format
     * @return object|StandaloneView
     */
    public static function getStandaloneViewObject(array $viewPaths, $template, $format = 'html')
    {
        /** @var ObjectManager $om */
        $om = GeneralUtility::makeInstance(ObjectManager::class);
        /** @var  $view */
        $view = $om->get(StandaloneView::class);
        $view->setFormat($format);
        $view->setTemplateRootPaths($viewPaths['templateRootPaths']);
        $view->setPartialRootPaths($viewPaths['partialRootPaths']);
        $view->setLayoutRootPaths($viewPaths['layoutRootPaths']);
        $view->setTemplate($template);

        return $view;
    }

}
