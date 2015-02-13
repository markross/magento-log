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
 * Ignoring code coverage for this class because all it mainly deals with creating
 * log directory and log files.
 * @codeCoverageIgnore
 */
class EbayEnterprise_MageLog_Model_Logger_File
{
	const DEFAULT_LOG_FILE = 'system.log';
	const LOG_DIRECTORY = 'log';

	/** @var EbayEnterprise_MageLog_Helper_Config $_config */
	protected $_config;

	public function __construct()
	{
		$this->_config = Mage::helper('ebayenterprise_magelog/config');
	}
	/**
	 * Get the default log file fall-back when no file is explicitly specified.
	 * @param  string $file
	 * @return string
	 */
	public function getFallbackFile($file)
	{
		if (empty($file)) {
			$file = $this->_config->getSystemLogFile();
		}
		return empty($file) ? static::DEFAULT_LOG_FILE : $file;
	}
	/**
	 * Get the log file if doesn't exits create it.
	 * @param  string $file
	 * @return string
	 */
	public function getLogAbsolutePath($file)
	{
		$logDir  = Mage::getBaseDir('var') . DS . static::LOG_DIRECTORY;
		$logFile = $logDir . DS . $file;
		$this->_createLogDirectory($logDir)
			->_createLogFile($logFile);
		return $logFile;
	}
	/**
	 * Create the log directory and assigned it the proper permission
	 * if it doesn't already exists.
	 * @param  string $logDir
	 * @return self
	 */
	protected function _createLogDirectory($logDir)
	{
		if (!is_dir($logDir)) {
			mkdir($logDir);
			chmod($logDir, 0777);
		}
		return $this;
	}
	/**
	 * Create the log file and assigned it the proper permission if
	 * it doesn't already exists.
	 * @param  string $logFile
	 * @return self
	 */
	protected function _createLogFile($logFile)
	{
		if (!file_exists($logFile)) {
			file_put_contents($logFile, '');
			chmod($logFile, 0777);
		}
		return $this;
	}
}
