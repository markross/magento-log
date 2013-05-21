<?php
/**
 * @category   TrueAction
 * @package    TrueAction_AdvanceLog
 * @copyright  Copyright (c) 2012 True Action Network (http://www.trueaction.com)
 */
class TrueAction_AdvanceLog_Test_Model_StreamTest extends EcomDev_PHPUnit_Test_Case
{
	protected $_stream;

	/**
	 * setUp method
	 **/
	public function setUp()
	{
		parent::setUp();
		$this->_stream = Mage::getModel('advancelog/stream');
		Mage::app()->getConfig()->reinit(); // re-initialize config to get fresh loaded data
	}

	/**
	 *
	 * @test
	 * @loadFixture loadConfig.yaml
	 */
	public function testWhenLogLevelIsEmerg()
	{
		// Create log empty file
		file_put_contents(Mage::getBaseDir('var') . '/log/unit_test.log', '');

		// Testing level 0 - EMERG
		Mage::log(
			'TESTING......', // log content
			Zend_Log::EMERG, // Log level
			'unit_test.log'  // log file
		);

		$this->assertNotEmpty(
			file_get_contents(Mage::getBaseDir('var') . '/log/unit_test.log')
		);
	}

	/**
	 *
	 * @test
	 * @loadFixture loadConfig.yaml
	 */
	public function testWhenLogLevelIsAlert()
	{
		// Create log empty file
		file_put_contents(Mage::getBaseDir('var') . '/log/unit_test.log', '');

		// Testing level 1 - ALERT
		Mage::log(
			'TESTING......', // log content
			Zend_Log::ALERT, // Log level
			'unit_test.log'  // log file
		);

		$this->assertNotEmpty(
			file_get_contents(Mage::getBaseDir('var') . '/log/unit_test.log')
		);
	}

	/**
	 *
	 * @test
	 * @loadFixture loadConfig.yaml
	 */
	public function testWhenLogLevelIsCrit()
	{
		// Create log empty file
		file_put_contents(Mage::getBaseDir('var') . '/log/unit_test.log', '');

		// Testing level 2 - CRIT
		Mage::log(
			'TESTING......', // log content
			Zend_Log::CRIT, // Log level
			'unit_test.log'  // log file
		);

		$this->assertNotEmpty(
			file_get_contents(Mage::getBaseDir('var') . '/log/unit_test.log')
		);
	}

	/**
	 *
	 * @test
	 * @loadFixture loadConfig.yaml
	 */
	public function testWhenLogLevelIsErr()
	{
		// Create log empty file
		file_put_contents(Mage::getBaseDir('var') . '/log/unit_test.log', '');

		// Testing level 3 - ERR
		Mage::log(
			'TESTING......', // log content
			Zend_Log::ERR, // Log level
			'unit_test.log'  // log file
		);

		$this->assertNotEmpty(
			file_get_contents(Mage::getBaseDir('var') . '/log/unit_test.log')
		);
	}

	/**
	 *
	 * @test
	 * @loadFixture loadConfig.yaml
	 */
	public function testWhenLogLevelIsWarn()
	{
		// Create log empty file
		file_put_contents(Mage::getBaseDir('var') . '/log/unit_test.log', '');

		// Testing level 4 - WARN
		Mage::log(
			'TESTING......', // log content
			Zend_Log::WARN, // Log level
			'unit_test.log'  // log file
		);

		$this->assertEmpty(
			file_get_contents(Mage::getBaseDir('var') . '/log/unit_test.log')
		);
	}

	/**
	 *
	 * @test
	 * @loadFixture loadConfig.yaml
	 */
	public function testWhenLogLevelIsNotice()
	{
		// Create log empty file
		file_put_contents(Mage::getBaseDir('var') . '/log/unit_test.log', '');

		// Testing level 5 - NOTICE
		Mage::log(
			'TESTING......', // log content
			Zend_Log::NOTICE, // Log level
			'unit_test.log'  // log file
		);

		$this->assertEmpty(
			file_get_contents(Mage::getBaseDir('var') . '/log/unit_test.log')
		);
	}

	/**
	 *
	 * @test
	 * @loadFixture loadConfig.yaml
	 */
	public function testWhenLogLevelIsInfo()
	{
		// Create log empty file
		file_put_contents(Mage::getBaseDir('var') . '/log/unit_test.log', '');

		// Testing level 6 - INFO
		Mage::log(
			'TESTING......', // log content
			Zend_Log::INFO, // Log level
			'unit_test.log'  // log file
		);

		$this->assertEmpty(
			file_get_contents(Mage::getBaseDir('var') . '/log/unit_test.log')
		);
	}

	/**
	 *
	 * @test
	 * @loadFixture loadConfig.yaml
	 */
	public function testWhenLogLevelIsDebug()
	{
		// Create log empty file
		file_put_contents(Mage::getBaseDir('var') . '/log/unit_test.log', '');

		// Testing level 7 - DEBUG
		Mage::log(
			'TESTING......', // log content
			Zend_Log::DEBUG, // Log level
			'unit_test.log'  // log file
		);

		$this->assertEmpty(
			file_get_contents(Mage::getBaseDir('var') . '/log/unit_test.log')
		);
	}
}
