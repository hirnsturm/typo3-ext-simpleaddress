<?php

namespace Sle\Simpleaddress\Controller;

use Sle\Simpleaddress\Service\GoogleMapsApiV3Services;
use Sle\Simpleaddress\Service\ViewService;
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
        $mapConfig = [];
        // mapOptions from flexform
        foreach ($this->settings['flexform']['googleMaps']['mapOptions'] as $key => $val) {
            $mapConfig[$key] = $val;
        }
        unset($mapConfig['mapTypeId']);
        // load point
        $mapConfig['points'] = $this->getPoints();

        return json_encode($mapConfig, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
    }


    /**
     * @return string
     */
    private function getPoints()
    {
        /** @var StandaloneView $view */
        $view = ViewService::getStandaloneViewObject($this->extensionName, 'Address/GoogleMapsInfoWindow');

        $points['windowContent'] = $view->assignMultiple([
            $this->settings['flexform']['address'],
        ]);

        if ('' !== $this->settings['flexform']['googleMaps']['latitude'] &&
            '' !== $this->settings['flexform']['googleMaps']['longitude']
        ) {
            $points['lat'] = floatval($this->settings['flexform']['googleMaps']['latitude']);
            $points['lon'] = floatval($this->settings['flexform']['googleMaps']['longitude']);
        } else {
            $coords = GoogleMapsApiV3Services::getGeoCoding(
                $this->settings['flexform']['address']['location'],
                $this->settings['flexform']['address']['postal-code'],
                $this->settings['flexform']['address']['street-address-name'],
                $this->settings['flexform']['address']['street-address-number']
            );
            if (isset($coords['results'][0]['geometry']['location'])) {
                $points['lat'] = floatval($coords['results'][0]['geometry']['location']['lat']);
                $points['lon'] = floatval($coords['results'][0]['geometry']['location']['lng']);
            }
        }

        return $points;
    }

}
