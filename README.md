# eBay Enterprise Mage Logger

Copyright © 2014 eBay Enterprise

`Mage::log` itself does not let the developer set loglevels or have much control of notifications from logs. This module lets us set two levels of notification in the Magento admin – one for email notifications and the other for logfile messages. Everything below the latter loglevel gets ignored entirely, which means we can safely leave `DEBUG` statements in the code.

Licensed under the terms of the Open Software License v. 3.0 (OSL-3.0). See [LICENSE.md](LICENSE.md) or http://opensource.org/licenses/OSL-3.0 for the full text of the license.
