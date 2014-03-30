<?php
/**
 * Provide a list of legal Zend_Log log levels to the Magento Admin for configuration.
 *
 * @see       Zend_Log
 * @category  EbayEnterprise
 * @package   EbayEnterprise_MageLog
 * @copyright Copyright (c) 2014 eBay Enterprise (http://ebayenterprise.com)
 */
class EbayEnterprise_MageLog_Model_System_Config_Source_Log_Levels
{
	/**
	 * Retrieve Zend_Log constants as log levels for Magento Admin.
	 *
	 * @return array
	 */
	public function toOptionArray()
	{
		$r = new ReflectionClass('Zend_Log');
		$results = array();
		foreach($r->getConstants() as $label => $value) {
			$results[] = array(
				'value' => $value,
				'label' => $label
			);
		}
		return $results;
	}
}
