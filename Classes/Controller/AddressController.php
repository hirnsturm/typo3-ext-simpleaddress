<?php

namespace Sle\Simpleaddress\Controller;

use Sle\Simpleaddress\Service\GoogleMapsApiV3Services;
use Sle\Simpleaddress\Service\ViewService;
use TYPO3\CMS\Core\Log\Logger;
use TYPO3\CMS\Core\Log\LogManager;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Mvc\View\ViewInterface;
use TYPO3\CMS\Fluid\View\StandaloneView;

/***
 *
 * This file is part of the "Simple-Address" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2017 Steve Lenz <kontakt@steve-lenz.de>
 *
 ***/

/**
 * AddressController
 */
class AddressController extends ActionController
{

    /**
     * @param ViewInterface $view
     */
    protected function initializeView(ViewInterface $view)
    {
        $this->view->assignMultiple([
            'pid'            => $GLOBALS['TSFE']->id,
            'cObjectData'    => $this->configurationManager->getContentObject()->data,
            'sysLanguageUid' => $GLOBALS['TSFE']->sys_language_uid,
        ]);
    }

    /**
     * action show
     *
     * @return void
     */
    public function showAction()
    {
        $this->view
            ->assign('settings', $this->settings)
            ->assign('mapConfig', $this->loadMapConfiguration());
    }

    /**
     *
     * @return JSON-String
     */
    private function loadMapConfiguration()
    {
        $point = [];

        $view = $this->getStandaloneView();

        $point['title'] = $this->settings['flexform']['address']['fn'];
        $point['content'] = $view->assignMultiple([
            'data' => $this->settings['flexform'],
        ])->render();

        if ('' !== $this->settings['flexform']['googleMaps']['latitude'] &&
            '' !== $this->settings['flexform']['googleMaps']['longitude']
        ) {
            $point['lat'] = floatval($this->settings['flexform']['googleMaps']['latitude']);
            $point['lng'] = floatval($this->settings['flexform']['googleMaps']['longitude']);
        } else {
            $coords = GoogleMapsApiV3Services::getGeoCoding(
                $this->settings['flexform']['address']['location'],
                $this->settings['flexform']['address']['postal-code'],
                $this->settings['flexform']['address']['street-address-name'],
                $this->settings['flexform']['address']['street-address-number']
            );
            if (isset($coords['results'][0]['geometry']['location'])) {
                $point['lat'] = floatval($coords['results'][0]['geometry']['location']['lat']);
                $point['lng'] = floatval($coords['results'][0]['geometry']['location']['lng']);
            } else {
                /** @var Logger $logger */
                $logger = GeneralUtility::makeInstance(LogManager::class)->getLogger(__CLASS__);
                $logger->error($coords['error_message'], (array)$coords);
            }
        }

        $this->settings['mapConfig']['center'] = [
            'lat' => $point['lat'],
            'lng' => $point['lng'],
        ];

        $mapConfig = [
            'mapConfig' => $this->settings['mapConfig'],
            'points'    => [$point],
        ];

        foreach ($this->settings['flexform']['googleMaps']['mapOptions'] as $key => $val) {
            $mapConfig['mapConfig'][$key] = $val;
        }

        return json_encode($mapConfig, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
    }

    /**
     * @return object|StandaloneView
     */
    private function getStandaloneView()
    {
        $frameworkConfig = $this->configurationManager->getConfiguration(
            ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK
        );

        $viewPaths = [
            'templateRootPaths' => $this->getViewProperty($frameworkConfig, 'templateRootPaths'),
            'layoutRootPaths'   => $this->getViewProperty($frameworkConfig, 'layoutRootPaths'),
            'partialRootPaths'  => $this->getViewProperty($frameworkConfig, 'partialRootPaths'),
        ];

        /** @var StandaloneView $view */
        return ViewService::getStandaloneViewObject($viewPaths, 'Address/GoogleMapsInfoWindow');
    }

}
