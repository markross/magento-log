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

class EbayEnterprise_MageLog_Helper_Config
{
	const MAGELOG_DEV_LOG_ACTIVE = 'dev/log/active';
	const MAGELOG_DEV_LOG_FILE = 'dev/log/file';
	const MAGELOG_DEV_LOG_EXCEPTION_FILE = 'dev/log/exception_file';
	const MAGELOG_DEV_LOG_LOG_LEVEL = 'dev/log/log_level';
	const MAGELOG_DEV_LOG_ENABLE_EMAIL_LOGGING = 'dev/log/enable_email_logging';
	const MAGELOG_DEV_LOG_LOGGING_EMAIL_ADDRESS = 'dev/log/logging_email_address';
	const MAGELOG_DEV_LOG_EMAIL_LOGGING_LEVEL = 'dev/log/email_logging_level';
	const MAGELOG_DEV_LOG_FROM_EMAIL = 'trans_email/ident_general/email';
	const APP_NAME = 'meta_data/context/app_name';
	const APP_CONTEXT = 'meta_data/context/app_context';
	const DATA_CENTER = 'meta_data/context/data_center';
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
	 * Retrieve the logger context app name.
	 *
	 * @param mixed $store
	 * @return string
	 */
	public function getAppName($store=null)
	{
		return Mage::getStoreConfig(self::APP_NAME, $store);
	}
	/**
	 * Retrieve the logger app context.
	 *
	 * @param mixed $store
	 * @return string
	 */
	public function getAppContext($store=null)
	{
		return Mage::getStoreConfig(self::APP_CONTEXT, $store);
	}
	/**
	 * Retrieve the logger app context.
	 *
	 * @param mixed $store
	 * @return string
	 */
	public function getDataCenter($store=null)
	{
		return Mage::getStoreConfig(self::DATA_CENTER, $store);
	}
}
