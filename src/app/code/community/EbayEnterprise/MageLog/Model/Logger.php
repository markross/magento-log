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

class EbayEnterprise_MageLog_Model_Logger
{
	/** @var EbayEnterprise_MageLog_Helper_Config $_config */
	protected $_config;
	/** @var EbayEnterprise_MageLog_Model_Logger_Formatter $_formatter */
	protected $_formatter;
	/** @var EbayEnterprise_MageLog_Model_Logger_File $_file */
	protected $_file;
	/** @var array $_loggers */
	protected $_loggers = [];

	public function __construct()
	{
		$this->_config = Mage::helper('ebayenterprise_magelog/config');
		$this->_formatter = Mage::getModel('ebayenterprise_magelog/logger_formatter', PHP_EOL);
		$this->_file = Mage::getModel('ebayenterprise_magelog/logger_file');
	}
	/**
	 * Check if it is possible to log messages.
	 * @param  bool $forceLog
	 * @return bool
	 */
	protected function _isNotLoggable($forceLog=false)
	{
		return (!Mage::getConfig() || (!Mage::getIsDeveloperMode() && !$this->_config->isActive() && !$forceLog));
	}
	/**
	 * Check if it is possible to log exception messages.
	 * @return bool
	 */
	protected function _isNotLoggableException()
	{
		return !Mage::getConfig();
	}
	/**
	 * Get the default log level fall-back when no level is explicitly specified.
	 * @param  string $level
	 * @return string
	 */
	protected function _logLevelFallback($level)
	{
		return is_null($level) ? Zend_Log::DEBUG : $level;
	}
	/**
	 * Instantiate a new Zend_Log object passing in stream writer instance.
	 * @param  Zend_Log_Writer_Stream $stream
	 * @return Zend_Log
	 */
	protected function _getNewZenLog(Zend_Log_Writer_Stream $stream)
	{
		return Mage::getModel('ebayenterprise_magelog/logger_log', $stream);
	}
	/**
	 * Instantiate a new EbayEnterprise_MageLog_Model_Stream object passing
	 * in a file.
	 * @param  string $file
	 * @return EbayEnterprise_MageLog_Model_Stream
	 */
	protected function _getNewStream($file)
	{
		return Mage::getModel('ebayenterprise_magelog/stream', $this->_file->getLogAbsolutePath($file));
	}
	/**
	 * Setup the log configurations.
	 * @param  string $file
	 * @return self
	 */
	protected function _setupLog($file)
	{
		if (!isset($this->_loggers[$file])) {
			$stream = $this->_getNewStream($file)
				->setFormatter($this->_formatter);
			$this->_loggers[$file] = $this->_getNewZenLog($stream);
		}
		return $this;
	}
	/**
	 * Normalize a message.
	 * @param  mixed $message
	 * @return string
	 */
	protected function _normalizeMessage($message)
	{
		return (is_array($message) || is_object($message)) ? print_r($message, true) : $message;
	}
	/**
	 * Check if logging messages are possible.
	 * @param  string $file
	 * @return bool
	 */
	protected function _canLog($file)
	{
		return (isset($this->_loggers[$file]) && $this->_loggers[$file] !== null);
	}
	/**
	 * log facility (??)
	 *
	 * @param  string $message
	 * @param  integer $level
	 * @param  string $file
	 * @param  bool $forceLog
	 * @param  array $context
	 * @return self | null
	 */
	public function log($message, $level=null, $file='', $forceLog=false, array $context=[])
	{
		if ($this->_isNotLoggable($forceLog)) {
			return;
		}
		$file = $this->_file->getFallbackFile($file);
		$this->_setupLog($file);
		if ($this->_canLog($file)) {
			$msg = $this->_normalizeMessage($message);
			$lvl = $this->_logLevelFallback($level);
			$this->_loggers[$file]->log($msg, $lvl, $context);
		}
		return $this;
	}
	/**
	 * Write exception to log
	 *
	 * @param  Exception $e
	 * @param  array     $context
	 * @return self | null
	 */
	public function logException(Exception $e, array $context=[])
	{
		if ($this->_isNotLoggableException()) {
			return;
		}
		$file = $this->_config->getExceptionLogFile();
		$context['exception'] = $e;
		$this->log($e->getMessage(), Zend_Log::ERR, $file, false, $context);
		return $this;
	}
}
