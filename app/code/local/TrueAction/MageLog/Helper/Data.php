<?php
/**
 * @category   TrueAction
 * @package    TrueAction_MageLog
 * @copyright  Copyright (c) 2013 True Action Network (http://www.trueaction.com)
 */

class TrueAction_MageLog_Helper_Data extends Mage_Core_Helper_Abstract
{
	const MAGELOG_DEV_LOG_ACTIVE = 'dev/log/active';
	const MAGELOG_DEV_LOG_FILE = 'dev/log/file';
	const MAGELOG_DEV_LOG_EXCEPTION_FILE = 'dev/log/exception_file';
	const MAGELOG_DEV_LOG_LOG_LEVEL = 'dev/log/log_level';
	const MAGELOG_DEV_LOG_ENABLE_EMAIL_LOGGING = 'dev/log/enable_email_logging';
	const MAGELOG_DEV_LOG_LOGGING_EMAIL_ADDRESS = 'dev/log/logging_email_address';
	const MAGELOG_DEV_LOG_EMAIL_LOGGING_LEVEL = 'dev/log/email_logging_level';
	const MAGELOG_DEV_LOG_FROM_EMAIL = 'trans_email/ident_general/email';

	/**
	 * isActive method
	 */
	public function isActive($store=null)
	{
		return Mage::getStoreConfigFlag (
			self::MAGELOG_DEV_LOG_ACTIVE,
			$store
		);
	}

	/**
	 * getSystemLogFile method
	 */
	public function getSystemLogFile($store=null)
	{
		return Mage::getStoreConfig (
			self::MAGELOG_DEV_LOG_FILE,
			$store
		);
	}

	/**
	 * getExceptionLogFile method
	 */
	public function getExceptionLogFile($store=null)
	{
		return Mage::getStoreConfig (
			self::MAGELOG_DEV_LOG_EXCEPTION_FILE,
			$store
		);
	}

	/**
	 * getLogLevel method
	 */
	public function getLogLevel($store=null)
	{
		return (int) Mage::getStoreConfig (
			self::MAGELOG_DEV_LOG_LOG_LEVEL,
			$store
		);
	}

	/**
	 * isEnableEmailLogging method
	 */
	public function isEnableEmailLogging($store=null)
	{
		return Mage::getStoreConfigFlag (
			self::MAGELOG_DEV_LOG_ENABLE_EMAIL_LOGGING,
			$store
		);
	}

	/**
	 * getLoggingEmailAddress method
	 */
	public function getLoggingEmailAddress($store=null)
	{
		return Mage::getStoreConfig (
			self::MAGELOG_DEV_LOG_LOGGING_EMAIL_ADDRESS,
			$store
		);
	}

	/**
	 * getEmailLoggingLevel method
	 */
	public function getEmailLoggingLevel($store=null)
	{
		return (int) Mage::getStoreConfig (
			self::MAGELOG_DEV_LOG_EMAIL_LOGGING_LEVEL,
			$store
		);
	}

	/**
	 * getFromEmail method
	 */
	public function getFromEmail($store=null)
	{
		return Mage::getStoreConfig (
			self::MAGELOG_DEV_LOG_FROM_EMAIL,
			$store
		);
	}

	public function getLogFile()
	{
		return Mage::getBaseDir('var') .
			DS .
			'log' .
			DS .
			$this->getSystemLogFile();
	}
}
