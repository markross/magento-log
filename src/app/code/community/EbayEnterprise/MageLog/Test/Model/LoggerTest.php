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


class EbayEnterprise_MageLog_Test_Model_LoggerTest extends EcomDev_PHPUnit_Test_Case
{
	public function providerLoggerLogMethod()
	{
		return [
			['This a sample log message', Zend_Log::NOTICE, '', false, ['key_1' => 'Key 1', 'key_2' => 'Key 2']],
		];
	}
	/**
	 * Test the EbayEnterprise_MageLog_Model_Logger::log method for
	 * the scenario where log message can't be logged.
	 * @param  string $message
	 * @param  integer $level
	 * @param  string $file
	 * @param  bool $forceLog
	 * @param  array $context
	 * @dataProvider providerLoggerLogMethod
	 */
	public function testLoggerLogMethodNotLoggable($message, $level, $file, $forceLog, array $context)
	{
		$isNotLoggable = true;
		$logger = $this->getModelMock('ebayenterprise_magelog/logger', ['_isNotLoggable']);
		$logger->expects($this->once())
			->method('_isNotLoggable')
			->will($this->returnValue($isNotLoggable));

		$this->assertNull($logger->log($message, $level, $file, $forceLog, $context));
	}
	/**
	 * Test the EbayEnterprise_MageLog_Model_Logger::log method for
	 * the scenario where we can log messages.
	 * @param  string $message
	 * @param  integer $level
	 * @param  string $file
	 * @param  bool $forceLog
	 * @param  array $context
	 * @dataProvider providerLoggerLogMethod
	 */
	public function testLoggerLogMethod($message, $level, $file, $forceLog, array $context)
	{
		$stream = $this->getModelMockBuilder('ebayenterprise_magelog/stream')
			// see EbayEnterprise_MageLog_Model_Stream::__construct method, it calls the parent
			// Zend_Log_Writer_Stream::__construct method which causes 'Zend_Log_Exception' to be
			// thrown, when the log file doesn't exists.
			->disableOriginalConstructor()
			->setMethods(null)
			->getMock();
		$this->replaceByMock('model', 'ebayenterprise_magelog/stream', $stream);

		$logFile = 'system.log';
		// Mocking this class in order to prevent it from creating log directory and log files.
		$file = $this->getModelMock('ebayenterprise_magelog/logger_file', ['_createLogDirectory', '_createLogFile', 'getFallbackFile']);
		$file->expects($this->any())
			->method('_createLogDirectory')
			->will($this->returnSelf());
		$file->expects($this->once())
			->method('_createLogFile')
			->will($this->returnSelf());
		$file->expects($this->once())
			->method('getFallbackFile')
			->will($this->returnValue($logFile));

		// Mocking this class in order to prevent it from logging actual messages to the log file system
		$log = $this->getModelMock('ebayenterprise_magelog/logger_log', ['log']);
		$log->expects($this->any())
			->method('log')
			->with($this->identicalTo($message), $this->identicalTo($level), $this->identicalTo($context));
		$this->replaceByMock('model', 'ebayenterprise_magelog/logger_log', $log);

		$logger = Mage::getModel('ebayenterprise_magelog/logger');
		EcomDev_Utils_Reflection::setRestrictedPropertyValue($logger, '_file', $file);

		$this->assertSame($logger, $logger->log($message, $level, $file, $forceLog, $context));
	}
	public function providerLoggerLogExceptionMethod()
	{
		$e = new Exception('Test Exception');
		return [
			[$e, ['key_1' => 'Key 1', 'key_2' => 'Key 2']],
		];
	}
	/**
	 * Test the EbayEnterprise_MageLog_Model_Logger::logException method for
	 * the scenario where logging exception messages can't be logged.
	 * @param  Exception $exception
	 * @param  array $context
	 * @dataProvider providerLoggerLogExceptionMethod
	 */
	public function testLoggerLogExceptionMethodNotLoggable(Exception $exception, array $context)
	{
		$isNotLoggable = true;
		$logger = $this->getModelMock('ebayenterprise_magelog/logger', ['_isNotLoggableException']);
		$logger->expects($this->once())
			->method('_isNotLoggableException')
			->will($this->returnValue($isNotLoggable));

		$this->assertNull($logger->logException($exception, $context));
	}
	/**
	 * Test the EbayEnterprise_MageLog_Model_Logger::logException method for
	 * the scenario where logging exception messages can be logged.
	 * @param  Exception $exception
	 * @param  array $context
	 * @dataProvider providerLoggerLogExceptionMethod
	 */
	public function testLoggerLogExceptionMethod(Exception $exception, array $context)
	{
		$logFile = 'exception.log';
		$context = ['exception' => $exception];
		$logger = Mage::getModel('ebayenterprise_magelog/logger');

		$config = $this->getHelperMock('ebayenterprise_magelog/config', ['getExceptionLogFile']);
		$config->expects($this->any())
			->method('getExceptionLogFile')
			->will($this->returnValue($logFile));
		EcomDev_Utils_Reflection::setRestrictedPropertyValue($logger, '_config', $config);

		$this->assertSame($logger, $logger->logException($exception, $context));
	}
}
