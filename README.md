eBay Enterprise Mage Logger
-------
`Mage::log` itself does not let the developer set loglevels or have much control of notifications from logs. This module lets us set two levels of notification in the Magento admin – one for email notifications and the other for logfile messages. Everything below the latter loglevel gets ignored entirely, which means we can safely leave `DEBUG` statements in the code.
