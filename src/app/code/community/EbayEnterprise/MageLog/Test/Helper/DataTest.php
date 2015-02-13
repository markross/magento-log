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
use Psr\Log\LogLevel;

class EbayEnterprise_MageLog_Test_Helper_DataTest extends EcomDev_PHPUnit_Test_Case
{
	/** @var EbayEnterprise_MageLog_Helper_Data $_helper */
	protected $_helper;

	public function setUp()
	{
		parent::setUp();
		$this->_helper = Mage::helper('ebayenterprise_magelog');
	}
	/**
	 * Provide arguments for testing log methods.
	 */
	public function provideLogMethodArguments()
	{
		return [
			['This a sample log message', ['key_1' => 'Key 1', 'key_2' => 'Key 2'], LogLevel::EMERGENCY, 'emergency'],
			['This a sample log message', ['key_1' => 'Key 1', 'key_2' => 'Key 2'], LogLevel::ALERT, 'alert'],
			['This a sample log message', ['key_1' => 'Key 1', 'key_2' => 'Key 2'], LogLevel::CRITICAL, 'critical'],
			['This a sample log message', ['key_1' => 'Key 1', 'key_2' => 'Key 2'], LogLevel::ERROR, 'error'],
			['This a sample log message', ['key_1' => 'Key 1', 'key_2' => 'Key 2'], LogLevel::WARNING, 'warning'],
			['This a sample log message', ['key_1' => 'Key 1', 'key_2' => 'Key 2'], LogLevel::NOTICE, 'notice'],
			['This a sample log message', ['key_1' => 'Key 1', 'key_2' => 'Key 2'], LogLevel::INFO, 'info'],
			['This a sample log message', ['key_1' => 'Key 1', 'key_2' => 'Key 2'], LogLevel::DEBUG, 'debug'],
		];
	}
	/**
	 * Test that we have a method for each Psr\Log\LogLevel const and that each calls log with the right const.
	 * @param string $message
	 * @param array $context
	 * @dataProvider provideLogMethodArguments
	 */
	public function testLogMethods($message, $context, $level, $method)
	{
		$logger = $this->getHelperMock('ebayenterprise_magelog/data', ['log']);
		$logger->expects($this->once())
			->method('log')
			->with(
				$this->identicalTo($level),
				$this->identicalTo($message),
				$this->identicalTo($context)
			)
			->will($this->returnSelf());
		$logger->$method($message, $context);
	}
	public function providerLog()
	{
		return [
			[LogLevel::EMERGENCY, 'This a sample log message', ['key_1' => 'Key 1', 'key_2' => 'Key 2']],
		];
	}
	/**
	 * Test the method EbayEnterprise_MageLog_Helper_Data::log when invoked
	 * will call the EbayEnterprise_MageLog_Model_Logger::log passing the proper
	 * parameters.
	 * @param int $level
	 * @param string $message
	 * @param array $context
	 * @dataProvider providerLog
	 */
	public function testLog($level, $message, array $context)
	{
		$file = '';
		$forceLog = false;
		$logger = $this->getModelMock('ebayenterprise_magelog/logger', ['log']);
		$logger->expects($this->once())
			->method('log')
			->with(
				$this->identicalTo($message),
				$this->identicalTo(Zend_Log::EMERG),
				$this->identicalTo($file),
				$this->identicalTo($forceLog),
				$this->identicalTo($context)
			)
			->will($this->returnSelf());
		$this->replaceByMock('model', 'ebayenterprise_magelog/logger', $logger);
		EcomDev_Utils_Reflection::setRestrictedPropertyValue($this->_helper, '_logger', null);
		$this->assertSame($this->_helper, $this->_helper->log($level, $message, $context));
	}
	public function providerLogException()
	{
		$e = new Exception('Test Exception');
		return [
			[$e, ['key_1' => 'Key 1', 'key_2' => 'Key 2']],
		];
	}
	/**
	 * Test the method EbayEnterprise_MageLog_Helper_Data::logException when invoked
	 * will call the EbayEnterprise_MageLog_Model_Logger::logException passing the proper
	 * parameters.
	 * @param Exception $exception
	 * @param array $context
	 * @dataProvider providerLogException
	 */
	public function testLogException(Exception $exception, array $context)
	{
		$logger = $this->getModelMock('ebayenterprise_magelog/logger', ['logException']);
		$logger->expects($this->once())
			->method('logException')
			->with($this->identicalTo($exception), $this->identicalTo($context))
			->will($this->returnSelf());
		$this->replaceByMock('model', 'ebayenterprise_magelog/logger', $logger);
		EcomDev_Utils_Reflection::setRestrictedPropertyValue($this->_helper, '_logger', null);
		$this->assertSame($this->_helper, $this->_helper->logException($exception, $context));
	}
}
