<?php
/**
 * Copyright (c) 2013-2014 eBay Enterprise, Inc.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @copyright   Copyright (c) 2013-2014 eBay Enterprise, Inc. (http://www.ebayenterprise.com/)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class EbayEnterprise_MageLog_Test_Helper_ContextTest extends EcomDev_PHPUnit_Test_Case
{
	/** @var EbayEnterprise_MageLog_Helper_Context */
	protected $_context;

	public function setUp()
	{
		parent::setUp();
		$this->_context = Mage::helper('ebayenterprise_magelog/context');

		// suppressing the real session from starting
		$session = $this->getModelMockBuilder('core/session')
			->disableOriginalConstructor()
			->setMethods(null)
			->getMock();
		$this->replaceByMock('singleton', 'core/session', $session);
	}

	public function providerGetMetaData()
	{
		return [
			['EbayEnterprise_MageLog_Model_SomeClass', ['rom_request_url' => 'amqp://localhost'], null, 'test-system-log'],
			['EbayEnterprise_MageLog_Model_SomeClass', [], new Exception('This is a test'), 'test-exception-log'],
		];
	}

	/**
	 * @param  string $className
	 * @param  array $data
	 * @param  Exception $e
	 * @param  string $case the test case
	 * @dataProvider providerGetMetaData
	 * @loadFixture
	 */
	public function testGetMetaData($className, $data, $exception, $case)
	{
		$context = $this->_context->getMetaData($className, $data, $exception);
		if (!$exception) {
			$this->assertSame($this->expected($case)->getData(), $context);
		} else {
			$this->assertArrayHasKey('exception_class', $context);
			$this->assertArrayHasKey('exception_message', $context);
			$this->assertArrayHasKey('exception_stacktrace', $context);
		}
	}
}
