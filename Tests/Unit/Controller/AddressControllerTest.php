<?php
namespace Sle\Simpleaddress\Tests\Unit\Controller;

/**
 * Test case.
 *
 * @author Steve Lenz <kontakt@steve-lenz.de>
 */
class AddressControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \Sle\Simpleaddress\Controller\AddressController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\Sle\Simpleaddress\Controller\AddressController::class)
            ->setMethods(['redirect', 'forward', 'addFlashMessage'])
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenAddressToView()
    {
        $address = new \Sle\Simpleaddress\Domain\Model\Address();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('address', $address);

        $this->subject->showAction($address);
    }
}
