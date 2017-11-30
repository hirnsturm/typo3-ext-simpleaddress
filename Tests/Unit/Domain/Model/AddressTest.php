<?php
namespace Sle\Simpleaddress\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Steve Lenz <kontakt@steve-lenz.de>
 */
class AddressTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \Sle\Simpleaddress\Domain\Model\Address
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \Sle\Simpleaddress\Domain\Model\Address();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function dummyTestToNotLeaveThisFileEmpty()
    {
        self::markTestIncomplete();
    }
}
