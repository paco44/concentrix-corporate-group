<?php
/**
 * @author      Francisco Espinosa <paco_espinosa.21@outlook.com>
 * @copyright   Copyright © Concentrix. All rights reserved. 
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Concentrix\CorporateGroup\Model;

use Concentrix\CorporateGroup\Api\CorporateGroupRepositoryInterface;
use Concentrix\CorporateGroup\Model\CorporateGroupFactory;
use Concentrix\CorporateGroup\Model\ResourceModel\CorporateGroup\CollectionFactory;
use Concentrix\CorporateGroup\Api\Data\CorporateGroupSearchResultInterfaceFactory;
use Concentrix\CorporateGroup\Api\Data\CorporateGroupInterface;
use Concentrix\CorporateGroup\Model\ResourceModel\CorporateGroup\Collection;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\InputException;

/**
 * Class CorporateGroupRepository
 */
class CorporateGroupRepository implements CorporateGroupRepositoryInterface
{

    /**
     * Attribute Code Constant
     */
    const CORPORATE_GROUṔ_ATTRIBUTE_CODE = 'concentrix_corporate_group_attr';

    /**
     * @var CorporateGroupFactory
     */
    protected $_corporateGroupFactory;

    /**
     * @var CollectionFactory
     */
    protected $_corporateGroupCollectionFactory;

    /**
     * @var CorporateGroupSearchResultInterfaceFactory
     */
    protected $_searchResultFactory;

    /**
     * @var CustomerRepositoryInterface
     */
    protected $_customerRepositoryInterface;

    /**
     * CorporateGroupRepository constructor
     * 
     * @param CorporateGroupFactory $corporateGroupFactory
     * @param CollectionFactory $corporateGroupCollectionFactory
     * @param CorporateGroupSearchResultInterfaceFactory $searchResultFactory
     */
    public function __construct(
        CorporateGroupFactory $corporateGroupFactory,
        CollectionFactory $corporateGroupCollectionFactory,
        CorporateGroupSearchResultInterfaceFactory $searchResultFactory,
        CustomerRepositoryInterface $customerRepositoryInterface
    ) {
        $this->_corporateGroupFactory           = $corporateGroupFactory;
        $this->_corporateGroupCollectionFactory = $corporateGroupCollectionFactory;
        $this->_searchResultFactory             = $searchResultFactory;
        $this->_customerRepositoryInterface     = $customerRepositoryInterface;
    }

    /**
     * Fetch a corporate group by it's unique internal code
     * @param string $internalCode
     * @return \Concentrix\CorporateGroup\Api\Data\CorporateGroupInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getByInternalCode($internalCode)
    {
        $corporateGroup = $this->_corporateGroupFactory->create();
        $corporateGroup->getResource()->load($corporateGroup, $internalCode, "internal_code");
        if (!$corporateGroup->getEntityId()) 
        {
            throw new NoSuchEntityException(__('Unable to find Corporate Group with Internal Code "%1"', $internalCode));
        }

        return $corporateGroup;
    }

    /**
     * Create or update a corporate group. If successful, return an entity id
     * @param \Concentrix\CorporateGroup\Api\Data\CorporateGroupInterface $corporateGroup
     * @return string
     */
    public function save(CorporateGroupInterface $corporateGroup)
    {

        $this->validateFields($corporateGroup);
        $corporateGroup->getResource()->save($corporateGroup);

        return json_encode(["entity_id" => $corporateGroup->getEntityId()]);
    }

    /**
     * Delete a corporate group by it's unique internal code. If successful, returns true.
     * @param string $internalCode
     * @return boolean
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function delete($internalCode)
    {
        $corporateGroup = $this->getByInternalCode($internalCode);
        $corporateGroup->getResource()->delete($corporateGroup);
        return true;
    }

    /**
     * Link a corporate group to a customer by customer id. If successful, returns true.
     * @param string $internalCode
     * @param string $customerId
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @return boolean
     */
    public function linkToCustomerById($internalCode, $customerId)
    {
        $corporateGroup = $this->getByInternalCode($internalCode);
        $customer       = $this->_customerRepositoryInterface->getById($customerId);

        $customer->setCustomAttribute(self::CORPORATE_GROUṔ_ATTRIBUTE_CODE, $internalCode);
        $this->_customerRepositoryInterface->save($customer);
        return true;
    }

    /**
     * Link a corporate group to a customer by customer email. If successful, returns true.
     * @param string $internalCode
     * @param string $customerEmail
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @return boolean
     */
    public function linkToCustomerByEmail($internalCode, $customerEmail)
    {
        $corporateGroup = $this->getByInternalCode($internalCode);
        $customer       = $this->_customerRepositoryInterface->get($customerEmail);

        $customer->setCustomAttribute(self::CORPORATE_GROUṔ_ATTRIBUTE_CODE, $internalCode);
        $this->_customerRepositoryInterface->save($customer);
        return true;
    }

    /**
     * Get a corporate group list from specific criteria
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Concentrix\CorporateGroup\Api\Data\CorporateGroupSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->_corporateGroupCollectionFactory->create();

        $this->addFiltersToCollection($searchCriteria, $collection);
        $this->addSortOrdersToCollection($searchCriteria, $collection);
        $this->addPagingToCollection($searchCriteria, $collection);

        $collection->load();

        return $this->buildSearchResult($searchCriteria, $collection);
    }

    /**
     * Helper function that adds filters to the collection.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @param \Concentrix\CorporateGroup\Model\ResourceModel\CorporateGroup\Collection $collection
     * @return void
     */
    private function addFiltersToCollection(
        SearchCriteriaInterface $searchCriteria, 
        Collection $collection)
    {
        foreach ($searchCriteria->getFilterGroups() as $filterGroup) 
        {
            $fields = $conditions = [];
            foreach ($filterGroup->getFilters() as $filter) 
            {
                $fields[] = $filter->getField();
                $conditions[] = [$filter->getConditionType() => $filter->getValue()];
            }

            $collection->addFieldToFilter($fields, $conditions);
        }
    }

    /**
     * Helper function that adds sort order to the collection.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @param \Concentrix\CorporateGroup\Model\ResourceModel\CorporateGroup\Collection $collection
     * @return void
     */
    private function addSortOrdersToCollection(
        SearchCriteriaInterface $searchCriteria, 
        Collection $collection)
    {
        foreach ((array) $searchCriteria->getSortOrders() as $sortOrder) 
        {
            $direction = $sortOrder->getDirection() == SortOrder::SORT_ASC ? 'asc' : 'desc';
            $collection->addOrder($sortOrder->getField(), $direction);
        }
    }

    /**
     * Helper function that adds paging to the collection.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @param \Concentrix\CorporateGroup\Model\ResourceModel\CorporateGroup\Collection $collection
     * @return void
     */
    private function addPagingToCollection(
        SearchCriteriaInterface $searchCriteria, 
        Collection $collection)
    {
        $collection->setPageSize($searchCriteria->getPageSize());
        $collection->setCurPage($searchCriteria->getCurrentPage());
    }

    /**
     * Helper function that build the search result
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @param \Concentrix\CorporateGroup\Model\ResourceModel\CorporateGroup\Collection $collection
     * @return \Concentrix\CorporateGroup\Api\Data\CorporateGroupSearchResultInterface
     */
    private function buildSearchResult(
        SearchCriteriaInterface $searchCriteria, 
        Collection $collection)
    {
        $searchResults = $this->_searchResultFactory->create();

        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }


    /**
     * Validate fields from a corporate group. If successful, returns true.
     * @param \Concentrix\CorporateGroup\Api\Data\CorporateGroupInterface $corporateGroup
     * @throws \Magento\Framework\Exception\InputException
     * @return boolean
     */
    private function validateFields(CorporateGroupInterface $corporateGroup)
    {
        if(!$corporateGroup->getInternalCode())
        {
            throw new InputException(__('Unable to save Corporate Group. "internal_code" field is required. Please, check and try again.'));
        }

        if(!$corporateGroup->getName())
        {
            throw new InputException(__('Unable to save Corporate Group. "name" field is required. Please, check and try again.'));
        }

        if(!$corporateGroup->getTelephone())
        {
            throw new InputException(__('Unable to save Corporate Group. "telephone" field is required. Please, check and try again.'));
        }

        if(!$corporateGroup->getEmail())
        {
            throw new InputException(__('Unable to save Corporate Group. "email" field is required. Please, check and try again.'));
        }

        else
        {
            if(!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $corporateGroup->getEmail()))
            {
                throw new InputException(__('Unable to save Corporate Group. "email" field is invalid. Please, check and try again.'));
            }
        }

        return true;
    }
}