<?php
/**
 * @author      Francisco Espinosa <paco_espinosa.21@outlook.com>
 * @copyright   Copyright © Concentrix. All rights reserved. 
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Concentrix\CorporateGroup\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface CorporateGroupSearchResultInterface
 */
interface CorporateGroupSearchResultInterface extends SearchResultsInterface
{
    /**
     * @return \Concentrix\CorporateGroup\Api\Data\CorporateGroupInterface[]
     */
    public function getItems();

    /**
     * @param \Concentrix\CorporateGroup\Api\Data\CorporateGroupInterface[] $items
     * @return void
     */
    public function setItems(array $items);
}