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

class EbayEnterprise_MageLog_Test_Helper_ConfigTest extends EcomDev_PHPUnit_Test_Case
{
	const HELPER = 'ebayenterprise_magelog/config';
	/**
	 * Provide null as the store view. This is slightly better than not providing
	 * anything because it lets you know that these configuration values can change
	 * at the store view level, but we don't currently test that.
	 */
	public function provideStoreView()
	{
		return [[null]];
	}
	/**
	 * Test that the configuration returns the expected isActive value from the fixture.
	 *
	 * @loadFixture loadConfig.yaml
	 * @dataProvider provideStoreView
	 */
	public function testIsActive($store=null)
	{
		$this->assertSame(true, Mage::helper(self::HELPER)->isActive($store));
	}
	/**
	 * Test that the configuration returns the expected system.log file name from the fixture.
	 *
	 * @loadFixture loadConfig.yaml
	 * @dataProvider provideStoreView
	 */
	public function testGetSystemLogFile($store=null)
	{
		$this->assertSame('systemdotlog', Mage::helper(self::HELPER)->getSystemLogFile($store));
	}
	/**
	 * Test that the configuration returns the expected exception.log file name from the fixture.
	 *
	 * @loadFixture loadConfig.yaml
	 * @dataProvider provideStoreView
	 */
	public function testGetExceptionLogFile($store=null)
	{
		$this->assertSame('exceptiondotlog', Mage::helper(self::HELPER)->getExceptionLogFile($store));
	}
	/**
	 * Test that the configuration returns the expected log level from the fixture.
	 *
	 * @loadFixture loadConfig.yaml
	 * @dataProvider provideStoreView
	 */
	public function testGetLogLevel($store=null)
	{
		$this->assertSame(3, Mage::helper(self::HELPER)->getLogLevel($store));
	}
	/**
	 * Test that the configuration returns the value from the fixture on whether or not email logging is enabled.
	 *
	 * @loadFixture loadConfig.yaml
	 * @dataProvider provideStoreView
	 */
	public function testIsEnableEmailLogging($store=null)
	{
		$this->assertTrue(Mage::helper(self::HELPER)->isEnableEmailLogging($store));
	}
	/**
	 * Test that the configuration returns the expected logging target email address from the fixture.
	 *
	 * @loadFixture loadConfig.yaml
	 * @dataProvider provideStoreView
	 */
	public function testGetLoggingEmailAddress($store=null)
	{
		$this->assertSame('nobody@example.com', Mage::helper(self::HELPER)->getLoggingEmailAddress($store));
	}
	/**
	 * Test that the configuration returns the expected email loglevel from the fixture.
	 *
	 * @loadFixture loadConfig.yaml
	 * @dataProvider provideStoreView
	 */
	public function testGetEmailLoggingLevel($store=null)
	{
		$this->assertSame(2, Mage::helper(self::HELPER)->getEmailLoggingLevel($store));
	}
	/**
	 * Test that the configuration returns the expected "from" email address from the fixture.
	 *
	 * @loadFixture loadConfig.yaml
	 * @dataProvider provideStoreView
	 */
	public function testGetFromEmail($store=null)
	{
		$this->assertSame('nobody@example.com', Mage::helper(self::HELPER)->getFromEmail($store));
	}
	/**
	 * Test that the configuration returns the expected path to the system log file.
	 *
	 * @loadFixture loadConfig.yaml
	 */
	public function testGetLogFile()
	{
		$this->assertSame(Mage::getBaseDir('log') . DS . 'systemdotlog', Mage::helper(self::HELPER)->getLogFile());
	}
}

