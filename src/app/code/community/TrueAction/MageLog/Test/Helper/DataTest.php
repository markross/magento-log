<?php
/**
 * @category  TrueAction
 * @package   TrueAction_MageLog
 * @copyright Copyright (c) 2013 True Action (http://www.trueaction.com)
 */
class TrueAction_MageLog_Test_Helper_DataTest extends EcomDev_PHPUnit_Test_Case
{
	protected $_helper;

	/**
	 * setUp method
	 */
	public function setUp()
	{
		parent::setUp();
		$this->_helper = $this->_getHelper();
	}

	/**
	 * Get helper instantiated object.
	 *
	 * @return TrueAction_MageLog_Helper_Data
	 */
	protected function _getHelper()
	{
		if (!$this->_helper) {
			$this->_helper = Mage::helper('trueaction_magelog');
		}
		return $this->_helper;
	}

	public function providerStoreView()
	{
		return array(array(null));
	}

	/**
	 * testing isActive method
	 *
	 * @test
	 * @loadFixture loadConfig.yaml
	 * @dataProvider providerStoreView
	 */
	public function testIsActive($store=null)
	{
		$this->assertTrue(
			$this->_getHelper()->isActive($store)
		);
	}

	/**
	 * testing getSystemLogFile method
	 *
	 * @test
	 * @loadFixture loadConfig.yaml
	 * @dataProvider providerStoreView
	 */
	public function testGetSystemLogFile($store=null)
	{
		$this->assertSame(
			'system.log',
			$this->_getHelper()->getSystemLogFile($store)
		);
	}

	/**
	 * testing getExceptionLogFile method
	 *
	 * @test
	 * @loadFixture loadConfig.yaml
	 * @dataProvider providerStoreView
	 */
	public function testGetExceptionLogFile($store=null)
	{
		$this->assertSame(
			'exception.log',
			$this->_getHelper()->getExceptionLogFile($store)
		);
	}

	/**
	 * testing getLogLevel method
	 *
	 * @test
	 * @loadFixture loadConfig.yaml
	 * @dataProvider providerStoreView
	 */
	public function testGetLogLevel($store=null)
	{
		$this->assertSame(
			3,
			$this->_getHelper()->getLogLevel($store)
		);
	}

	/**
	 * testing isEnableEmailLogging method
	 *
	 * @test
	 * @loadFixture loadConfig.yaml
	 * @dataProvider providerStoreView
	 */
	public function testIsEnableEmailLogging($store=null)
	{
		$this->assertTrue(
			$this->_getHelper()->isEnableEmailLogging($store)
		);
	}

	/**
	 * testing getLoggingEmailAddress method
	 *
	 * @test
	 * @loadFixture loadConfig.yaml
	 * @dataProvider providerStoreView
	 */
	public function testGetLoggingEmailAddress($store=null)
	{
		$this->assertSame(
			'GabrielR@TrueAction.com',
			$this->_getHelper()->getLoggingEmailAddress($store)
		);
	}

	/**
	 * testing getEmailLoggingLevel method
	 *
	 * @test
	 * @loadFixture loadConfig.yaml
	 * @dataProvider providerStoreView
	 */
	public function testGetEmailLoggingLevel($store=null)
	{
		$this->assertSame(
			2,
			$this->_getHelper()->getEmailLoggingLevel($store)
		);
	}

	/**
	 * testing getFromEmail method
	 *
	 * @test
	 * @loadFixture loadConfig.yaml
	 * @dataProvider providerStoreView
	 */
	public function testGetFromEmail($store=null)
	{
		$this->assertSame(
			'GabrielR@trueaction.com',
			$this->_getHelper()->getFromEmail($store)
		);
	}

	/**
	 * testing getLogFile method
	 *
	 * @test
	 * @loadFixture loadConfig.yaml
	 */
	public function testGetLogFile()
	{
		$this->assertSame(
			Mage::getBaseDir('log') . DS . 'system.log',
			$this->_getHelper()->getLogFile()
		);
	}
}
