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


class EbayEnterprise_MageLog_Model_Stream extends Zend_Log_Writer_Stream
{
	const EMAIL_SUBJECT = ': logging error alert';

	/** @var EbayEnterprise_MageLog_Helper_Config $_config */
	protected $_config;

	public function __construct($streamOrUrl, $mode=null)
	{
		$streamOrUrl = $streamOrUrl ?: $this->_getConfig()->getLogFile();
		parent::__construct($streamOrUrl, $mode);
		$this->_formatter = $this->_getNewFormatter();
	}
	/**
	 * Get helper instantiated object.
	 *
	 * @return EbayEnterprise_MageLog_Helper_Config
	 */
	protected function _getConfig()
	{
		if (!$this->_config) {
			$this->_config = Mage::helper('ebayenterprise_magelog/config');
		}
		return $this->_config;
	}
	/**
	 * Get a new instance of formatter class
	 * @return EbayEnterprise_MageLog_Model_Logger_Formatter
	 */
	protected function _getNewFormatter()
	{
		return Mage::getModel('ebayenterprise_magelog/logger_formatter', null);
	}
	/**
	 * @see Zend_Log_Writer_Abstract::setFormatter
	 * Overriding this method mage Mage::log call this method
	 * to set Zend_Log_Formatter_Simple format, instead we want to use
	 * our custom one.
	 *
	 * @param  Zend_Log_Formatter_Interface $formatter
	 * @return Zend_Log_Writer_Abstract
	 */
	public function setFormatter(Zend_Log_Formatter_Interface $formatter)
	{
		$this->_formatter = $formatter;
		if (!$formatter instanceof EbayEnterprise_MageLog_Model_Logger_Formatter) {
			$this->_formatter = $this->_getNewFormatter();
		}
		return $this;
	}
	/**
	 * check if the priority level is less than or equal to the config email level logging.
	 * @param  array $event
	 * @return bool
	 */
	protected function _isEmailLevel($event)
	{
		return (isset($event['priority']) && $event['priority'] <= $this->_getConfig()->getEmailLoggingLevel());
	}
	/**
	 * check if logging e-mail address is configured in the backend
	 * @return bool
	 */
	protected function _hasValidEmail()
	{
		return (trim($this->_getConfig()->getLoggingEmailAddress()) !== '');
	}
	/**
	 * Is email logging send-able.
	 * @param  array $event
	 * @return bool
	 */
	protected function _isEmailSendable($event)
	{
		return ($this->_getConfig()->isEnableEmailLogging() && $this->_isEmailLevel($event) && $this->_hasValidEmail());
	}
	/**
	 * @see Zend_Log_Writer_Stream::_write
	 * @param array $event
	 * Overriding this method in order to send email logging if enabled in the backend.
	 */
	protected function _write($event)
	{
		// allow logging at the config level where the priority is less or equal to the admin config log level.
		if (isset($event['priority']) && $event['priority'] <= $this->_getConfig()->getLogLevel()) {
			parent::_write($event);
		}
		// proceed to send logging e-mail
		$this->_sendLoggingEmail($event);
	}
	/**
	 * send logging e-mail.
	 *
	 * @return void
	 */
	protected function _sendLoggingEmail($event)
	{
		if ($this->_isEmailSendable($event)) {
			$this->_logEmail($event);
		}
	}
	/**
	 * Instantiate a Zend_Mail email object, then set the to and from email.
	 * @return Zend_Mail
	 */
	protected function _getEmailInstance()
	{
		$mail = Mage::getModel('ebayenterprise_magelog/logger_email');
		$mail->setFrom($this->_getConfig()->getFromEmail())
			->addTo($this->_getConfig()->getLoggingEmailAddress());
		return $mail;
	}
	/**
	 * Instantiate a Zend_Log_Writer_Mail object, then set the subject and filter by priority.
	 * @param  array $event
	 * @return Zend_Log_Writer_Mail
	 */
	protected function _getLogEmailWriterInstance(array $event)
	{
		$writer = Mage::getModel('ebayenterprise_magelog/logger_writer', $this->_getEmailInstance());
		$writer->setSubjectPrependText($event['priorityName'] . static::EMAIL_SUBJECT);
		$writer->addFilter($event['priority']);
		return $writer;
	}
	/**
	 * Instantiate a Zend_Log object, then add the Zend_Log_Writer_Mail object
	 * and add priority filter and then log the message.
	 * @param  array $event
	 * @return self
	 */
	protected function _logEmail(array $event)
	{
		$writer = $this->_getLogEmailWriterInstance($event);
		$log = Mage::getModel('ebayenterprise_magelog/logger_log', $writer);
		$log->addFilter($event['priority']);
		$log->log($event['message'], $event['priority']);
		return $this;
	}
}
