<?php
/**
 * @author      Francisco Espinosa <paco_espinosa.21@outlook.com>
 * @copyright   Copyright © Concentrix. All rights reserved. 
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Concentrix\CorporateGroup\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class CorporateGroup
 */
class CorporateGroup extends AbstractDb
{
	 /**
     * Initialize Corporate Group Resource Model
     *
     * @return void
     */
	public function _construct()
	{
		$this->_init("concentrix_corporate_group","entity_id");
	}
}