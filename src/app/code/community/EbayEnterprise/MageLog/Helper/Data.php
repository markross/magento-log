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

/**
 * Provide self-contained logging methods that can easily be overridden and mocked.
 *
 * @category  EbayEnterprise
 * @package   EbayEnterprise_MageLog
 * @copyright Copyright (c) 2014 eBay Enterprise (http://ebayenterprise.com)
 */
class EbayEnterprise_MageLog_Helper_Data extends Mage_Core_Helper_Abstract {
	const MAGELOG_DEV_LOG_ACTIVE = 'dev/log/active';
	const MAGELOG_DEV_LOG_FILE = 'dev/log/file';
	const MAGELOG_DEV_LOG_EXCEPTION_FILE = 'dev/log/exception_file';
	const MAGELOG_DEV_LOG_LOG_LEVEL = 'dev/log/log_level';
	const MAGELOG_DEV_LOG_ENABLE_EMAIL_LOGGING = 'dev/log/enable_email_logging';
	const MAGELOG_DEV_LOG_LOGGING_EMAIL_ADDRESS = 'dev/log/logging_email_address';
	const MAGELOG_DEV_LOG_EMAIL_LOGGING_LEVEL = 'dev/log/email_logging_level';
	const MAGELOG_DEV_LOG_FROM_EMAIL = 'trans_email/ident_general/email';
	/**
	 * Determine whether logging is active.
	 *
	 * @param mixed $store
	 * @return bool true if logging is active
	 */
	public function isActive($store=null)
	{
		return Mage::getStoreConfigFlag(self::MAGELOG_DEV_LOG_ACTIVE, $store);
	}
	/**
	 * Retrieve the name of the configured system.log file.
	 *
	 * @param mixed $store
	 * @return string path to system.log
	 */
	public function getSystemLogFile($store=null)
	{
		return Mage::getStoreConfig(self::MAGELOG_DEV_LOG_FILE, $store);
	}
	/**
	 * Retrieve the name of the configured exception.log file.
	 *
	 * @param mixed $store
	 * @return string path to exception.log
	 */
	public function getExceptionLogFile($store=null)
	{
		return Mage::getStoreConfig(self::MAGELOG_DEV_LOG_EXCEPTION_FILE, $store);
	}
	/**
	 * Retrieve the minimum log level for writing to the log files.
	 *
	 * @see Zend_Log
	 * @param mixed $store
	 * @return int one of the Zend_Log consts
	 */
	public function getLogLevel($store=null)
	{
		return (int) Mage::getStoreConfig(self::MAGELOG_DEV_LOG_LOG_LEVEL, $store);
	}
	/**
	 * Determine whether email logging is enabled.
	 *
	 * @param mixed $store
	 * @return bool true if we should send emails for some log messages.
	 */
	public function isEnableEmailLogging($store=null)
	{
		return Mage::getStoreConfigFlag(self::MAGELOG_DEV_LOG_ENABLE_EMAIL_LOGGING, $store);
	}
	/**
	 * Retrieve the email address to which to send log messages.
	 *
	 * @param mixed $store
	 * @return string the email address.
	 */
	public function getLoggingEmailAddress($store=null)
	{
		return Mage::getStoreConfig(self::MAGELOG_DEV_LOG_LOGGING_EMAIL_ADDRESS, $store);
	}
	/**
	 * Retrieve the minimum log level for sending messages to email.
	 *
	 * @see Zend_Log
	 * @param mixed $store
	 * @return int one of the Zend_Log consts
	 */
	public function getEmailLoggingLevel($store=null)
	{
		return (int) Mage::getStoreConfig(self::MAGELOG_DEV_LOG_EMAIL_LOGGING_LEVEL, $store);
	}
	/**
	 * Retrieve the "From" email address for sending message to email.
	 *
	 * @param mixed $store
	 * @return string the email address
	 */
	public function getFromEmail($store=null)
	{
		return Mage::getStoreConfig(self::MAGELOG_DEV_LOG_FROM_EMAIL, $store);
	}
	/**
	 * Retrieve the path to the system.log file.
	 *
	 * @return string
	 */
	public function getLogFile()
	{
		return Mage::getBaseDir('log') . DS . $this->getSystemLogFile();
	}
	/**
	 * Log an exception object to the exception.log file.
	 *
	 * @param Exception any exception
	 * @return self
	 */
	public function logException(Exception $e)
	{
		Mage::logException($e);
		return $this;
	}
	/**
	 * The common _log function, does the formatting and calls the sender (Mage::log())
	 *
	 * @see vsprintf
	 * @param string message, a vsprintf-style message format
	 * @param level Log Priority level (based on Zend_Log levels)
	 * @param array argsArray, a vsprintf-style array of arguments
	 * @return self
	 */
	protected function _log($formatMessage, $level=Zend_Log::DEBUG, array $argsArray=null)
	{
		Mage::log(vsprintf($formatMessage, $argsArray), $level);
		return $this;
	}
	/**
	 * DEBUG level logger
	 *
	 * @example ($helper)->logDebug('[ %s ] %s yields code %d', array(__CLASS__, 'fooData', -1));
	 * @see vsprintf
	 * @param string message, a vsprintf-style message format
	 * @param array argsArray, a vsprintf-style array of arguments
	 * @return self
	 */
	public function logDebug($formatMessage, array $argsArray=null)
	{
		return $this->_log($formatMessage, Zend_Log::DEBUG, $argsArray);
	}
	/**
	 * INFO level logger
	 *
	 * @see vsprintf
	 * @param string message, a vsprintf-style message format
	 * @param array argsArray, a vsprintf-style array of arguments
	 * @return self
	 */
	public function logInfo($formatMessage, array $argsArray=null)
	{
		return $this->_log($formatMessage, Zend_Log::INFO, $argsArray);
	}
	/**
	 * NOTICE level logger
	 *
	 * @see vsprintf
	 * @param string message, a vsprintf-style message format
	 * @param array argsArray, a vsprintf-style array of arguments
	 * @return self
	 */
	public function logNotice($formatMessage, array $argsArray=null)
	{
		return $this->_log($formatMessage, Zend_Log::NOTICE, $argsArray);
	}
	/**
	 * WARN level logger
	 *
	 * @see vsprintf
	 * @param string message, a vsprintf-style message format
	 * @param array argsArray, a vsprintf-style array of arguments
	 * @return self
	 */
	public function logWarn($formatMessage, array $argsArray=null)
	{
		return $this->_log($formatMessage, Zend_Log::WARN, $argsArray);
	}
	/**
	 * ERR level logger
	 *
	 * @see vsprintf
	 * @param string message, a vsprintf-style message format
	 * @param array argsArray, a vsprintf-style array of arguments
	 * @return self
	 */
	public function logErr($formatMessage, array $argsArray=null)
	{
		return $this->_log($formatMessage, Zend_Log::ERR, $argsArray);
	}
	/**
	 * CRIT level logger
	 *
	 * @see vsprintf
	 * @param string message, a vsprintf-style message format
	 * @param array argsArray, a vsprintf-style array of arguments
	 * @return self
	 */
	public function logCrit($formatMessage, array $argsArray=null)
	{
		return $this->_log($formatMessage, Zend_Log::CRIT, $argsArray);
	}
	/**
	 * ALERT level logger
	 *
	 * @see vsprintf
	 * @param string message, a vsprintf-style message format
	 * @param array argsArray, a vsprintf-style array of arguments
	 * @return self
	 */
	public function logAlert($formatMessage, array $argsArray=null)
	{
		return $this->_log($formatMessage, Zend_Log::ALERT, $argsArray);
	}
	/**
	 * EMERG level logger
	 *
	 * @see vsprintf
	 * @param string message, a vsprintf-style message format
	 * @param array argsArray, a vsprintf-style array of arguments
	 * @return self
	 */
	public function logEmerg($formatMessage, array $argsArray=null)
	{
		return $this->_log($formatMessage, Zend_Log::EMERG, $argsArray);
	}
}
