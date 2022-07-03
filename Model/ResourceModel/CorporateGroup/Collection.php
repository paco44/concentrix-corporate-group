<?php
/**
 * @author      Francisco Espinosa <paco_espinosa.21@outlook.com>
 * @copyright   Copyright © Concentrix. All rights reserved. 
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Concentrix\CorporateGroup\Model\ResourceModel\CorporateGroup;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 */
class Collection extends AbstractCollection
{
	/**
     * Initialize Corporate Group Collection
     *
     * @return void
     */
	public function _construct()
	{
		$this->_init("Concentrix\CorporateGroup\Model\CorporateGroup","Concentrix\CorporateGroup\Model\ResourceModel\CorporateGroup");
	}
}