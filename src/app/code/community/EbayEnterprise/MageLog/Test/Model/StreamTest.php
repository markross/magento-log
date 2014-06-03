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


class EbayEnterprise_MageLog_Test_Model_StreamTest extends EcomDev_PHPUnit_Test_Case
{
	protected $_stream;

	/**
	 * setUp method
	 */
	public function setUp()
	{
		parent::setUp();

		// checking if var directory exists, if not, then create it
		if (!is_dir(Mage::getBaseDir('var'))) {
			umask(0);
			mkdir(Mage::getBaseDir('var'), 0777, true);
		}

		// checking if log directory exists, if not, then create it
		if (!is_dir(Mage::getBaseDir('log'))) {
			umask(0);
			mkdir(Mage::getBaseDir('log'), 0777, true);
		}

		// checking if var/log/system.log file exist, if not create it
		if (!file_exists(Mage::getBaseDir('log') . DS . 'system.log')) {
			file_put_contents(Mage::getBaseDir('log') . DS . 'system.log', '');
		}

		// checking if var/log/exception.log file exist, if not create it
		if (!file_exists(Mage::getBaseDir('log') . DS . 'exception.log')) {
			file_put_contents(Mage::getBaseDir('log') . DS . 'exception.log', '');
		}

		$this->_stream = Mage::getModel('magelog/stream');
	}

	/**
	 * @test
	 * @loadFixture loadConfig.yaml
	 */
	public function testConfig()
	{
		$this->assertSame('1', Mage::getStoreConfig('dev/log/active'));
		$this->assertSame('system.log', Mage::getStoreConfig('dev/log/file'));
		$this->assertSame('exception.log', Mage::getStoreConfig('dev/log/exception_file'));
		$this->assertSame('3', Mage::getStoreConfig('dev/log/log_level'));
		$this->assertSame('1', Mage::getStoreConfig('dev/log/enable_email_logging'));
		$this->assertSame('GabrielR@ebay.com', Mage::getStoreConfig('dev/log/logging_email_address'));
		$this->assertSame('2', Mage::getStoreConfig('dev/log/email_logging_level'));
		$this->assertSame('GabrielR@ebay.com', Mage::getStoreConfig('trans_email/ident_general/email'));
	}

	/**
	 * @test
	 * @loadFixture loadConfig.yaml
	 */
	public function testLogException()
	{
		// Note: we already tested 'exception.log' file exists in the config in unit test DataTest::testGetExceptionLogFile
		// empty file exception log
		file_put_contents(Mage::getBaseDir('log') . DS . 'exception.log', '');
		try{
			throw new Exception('Mage Log Exception Error');
		}catch(Exception $e){
			Mage::logException($e);
			$this->assertNotEmpty(
				file_get_contents(Mage::getBaseDir('log') . DS . 'exception.log')
			);
		}
	}

	/**
	 * @test
	 * @loadFixture loadConfig.yaml
	 */
	public function testWhenLogLevelIsEmerg()
	{
		// Create log empty file
		file_put_contents(Mage::getBaseDir('log') . DS . 'unit_test.log', '');

		// Testing level 0 - EMERG
		Mage::log(
			'TESTING......', // log content
			Zend_Log::EMERG, // Log level
			'unit_test.log'  // log file
		);

		$this->assertNotEmpty(
			file_get_contents(Mage::getBaseDir('log') . DS . 'unit_test.log')
		);
	}

	/**
	 * @test
	 * @loadFixture loadConfig.yaml
	 */
	public function testWhenLogLevelIsAlert()
	{
		// Create log empty file
		file_put_contents(Mage::getBaseDir('log') . DS . 'unit_test.log', '');

		// Testing level 1 - ALERT
		Mage::log(
			'TESTING......', // log content
			Zend_Log::ALERT, // Log level
			'unit_test.log'  // log file
		);

		$this->assertNotEmpty(
			file_get_contents(Mage::getBaseDir('log') . DS . 'unit_test.log')
		);
	}

	/**
	 * @test
	 * @loadFixture loadConfig.yaml
	 */
	public function testWhenLogLevelIsCrit()
	{
		// Create log empty file
		file_put_contents(Mage::getBaseDir('log') . DS . 'unit_test.log', '');

		// Testing level 2 - CRIT
		Mage::log(
			'TESTING......', // log content
			Zend_Log::CRIT, // Log level
			'unit_test.log'  // log file
		);

		$this->assertNotEmpty(
			file_get_contents(Mage::getBaseDir('log') . DS . 'unit_test.log')
		);
	}

	/**
	 * @test
	 * @loadFixture loadConfig.yaml
	 */
	public function testWhenLogLevelIsErr()
	{
		// Create log empty file
		file_put_contents(Mage::getBaseDir('log') . DS . 'unit_test.log', '');

		// Testing level 3 - ERR
		Mage::log(
			'TESTING......', // log content
			Zend_Log::ERR, // Log level
			'unit_test.log'  // log file
		);

		$this->assertNotEmpty(
			file_get_contents(Mage::getBaseDir('log') . DS . 'unit_test.log')
		);
	}

	/**
	 * @test
	 * @loadFixture loadConfig.yaml
	 */
	public function testWhenLogLevelIsWarn()
	{
		// Create log empty file
		file_put_contents(Mage::getBaseDir('log') . DS . 'unit_test.log', '');

		// Testing level 4 - WARN
		Mage::log(
			'TESTING......', // log content
			Zend_Log::WARN, // Log level
			'unit_test.log'  // log file
		);

		$this->assertEmpty(
			file_get_contents(Mage::getBaseDir('log') . DS . 'unit_test.log')
		);
	}

	/**
	 * @test
	 * @loadFixture loadConfig.yaml
	 */
	public function testWhenLogLevelIsNotice()
	{
		// Create log empty file
		file_put_contents(Mage::getBaseDir('log') . DS . 'unit_test.log', '');

		// Testing level 5 - NOTICE
		Mage::log(
			'TESTING......', // log content
			Zend_Log::NOTICE, // Log level
			'unit_test.log'  // log file
		);

		$this->assertEmpty(
			file_get_contents(Mage::getBaseDir('log') . DS . 'unit_test.log')
		);
	}

	/**
	 * @test
	 * @loadFixture loadConfig.yaml
	 */
	public function testWhenLogLevelIsInfo()
	{
		// Create log empty file
		file_put_contents(Mage::getBaseDir('log') . DS . 'unit_test.log', '');

		// Testing level 6 - INFO
		Mage::log(
			'TESTING......', // log content
			Zend_Log::INFO, // Log level
			'unit_test.log'  // log file
		);

		$this->assertEmpty(
			file_get_contents(Mage::getBaseDir('log') . DS . 'unit_test.log')
		);
	}

	/**
	 * @test
	 * @loadFixture loadConfig.yaml
	 */
	public function testWhenLogLevelIsDebug()
	{
		// Create log empty file
		file_put_contents(Mage::getBaseDir('log') . DS . 'unit_test.log', '');

		// Testing level 7 - DEBUG
		Mage::log(
			'TESTING......', // log content
			Zend_Log::DEBUG, // Log level
			'unit_test.log'  // log file
		);

		$this->assertEmpty(
			file_get_contents(Mage::getBaseDir('log') . DS . 'unit_test.log')
		);
	}
}
