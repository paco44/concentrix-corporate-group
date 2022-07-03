<?php
/**
 * @author      Francisco Espinosa <paco_espinosa.21@outlook.com>
 * @copyright   Copyright © Concentrix. All rights reserved. 
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Concentrix\CorporateGroup\Api;

use Concentrix\CorporateGroup\Api\Data\CorporateGroupInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Interface for handling corporate groups
 */
interface CorporateGroupRepositoryInterface
{
    /**
     * Create or update a corporate group. If successful, return an entity id
     * @param \Concentrix\CorporateGroup\Api\Data\CorporateGroupInterface $corporateGroup
     * @return string
     */
    public function save(CorporateGroupInterface $corporateGroup);

    /**
     * Fetch a corporate group by it's unique internal code
     * @param string $internalCode
     * @return \Concentrix\CorporateGroup\Api\Data\CorporateGroupInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getByInternalCode($internalCode);

    /**
     * Delete a corporate group by it's unique internal code. If successful, returns true.
     * @param string $internalCode
     * @return boolean
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function delete($internalCode);

    /**
     * Get a corporate group list from specific criteria
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Concentrix\CorporateGroup\Api\Data\CorporateGroupSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);


    /**
     * Link a corporate group to a customer by customer id. If successful, returns true.
     * @param string $internalCode
     * @param string $customerId
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @return boolean
     */
    public function linkToCustomerById($internalCode, $customerId);

    /**
     * Link a corporate group to a customer by customer email. If successful, returns true.
     * @param string $internalCode
     * @param string $customerEmail
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @return boolean
     */
    public function linkToCustomerByEmail($internalCode, $customerEmail);


}