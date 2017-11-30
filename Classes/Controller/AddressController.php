<?php
namespace Sle\Simpleaddress\Controller;

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
class AddressController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * addressRepository
     *
     * @var \Sle\Simpleaddress\Domain\Repository\AddressRepository
     * @inject
     */
    protected $addressRepository = null;

    /**
     * action show
     *
     * @param \Sle\Simpleaddress\Domain\Model\Address $address
     * @return void
     */
    public function showAction(\Sle\Simpleaddress\Domain\Model\Address $address)
    {
        $this->view->assign('address', $address);
    }
}
