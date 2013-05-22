<?php
/**
 * @category  TrueAction
 * @package   TrueAction_AdvanceLog
 * @copyright Copyright (c) 2013 True Action (http://www.trueaction.com)
 */
class TrueAction_AdvanceLog_Test_Helper_DataTest extends EcomDev_PHPUnit_Test_Case
{
	protected $_helper;

	/**
	 * setUp method
	 **/
	public function setUp()
	{
		parent::setUp();
		$this->_helper = $this->_getHelper();
		Mage::app()->getConfig()->reinit(); // re-initialize config to get fresh loaded data
	}

	/**
	 * Get helper instantiated object.
	 *
	 * @return TrueAction_AdvanceLog_Helper_Data
	 */
	protected function _getHelper()
	{
		if (!$this->_helper) {
			$this->_helper = Mage::helper('trueaction_advancelog');
		}
		return $this->_helper;
	}

	public function providerStoreView()
	{
		foreach (Mage::app()->getStores(true) as $storeView) {
			if ($storeView->getCode() !== 'admin') {
				return array(array($storeView));
			}
		}
	}

	/**
	 * testing isActive method
	 *
	 * @test
	 * @loadFixture loadConfig.yaml
	 * @dataProvider providerStoreView
	 */
	public function isActive($store=null)
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
	public function getSystemLogFile($store=null)
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
	public function getExceptionLogFile($store=null)
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
	public function getLogLevel($store=null)
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
	public function isEnableEmailLogging($store=null)
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
	public function getLoggingEmailAddress($store=null)
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
	public function getEmailLoggingLevel($store=null)
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
	public function getFromEmail($store=null)
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
	public function getLogFile()
	{
		$this->assertSame(
			Mage::getBaseDir('var') . '/log/system.log',
			$this->_getHelper()->getLogFile()
		);
	}
}
