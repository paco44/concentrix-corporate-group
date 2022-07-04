# Concentrix Corporate Group
Concentrix code challenge!

## Overview
Concentrix Corporate Groups Module for **Magento 2.4** is designed to manage corporate groups through a rest API and link them with customers.


## Installation

**Composer** (recommended)

In the root directory of magento, execute the following command:

`composer require concentrix/module-corporate-group`

If there are any problems trying to install this package, update to the latest version of composer

`composer self-update --2`


**Git**

On the main page of the repository, click the "Code" button and clone the repository via git, or click "Download Zip" to download the module and add it to Magento manually in **app/code/Concentrix/CorporateGroup** directory

In both cases (composer or git), execute the following command in the root directory of magento:

`bin/magento s:up`

This should be enough for the module to start working correctly, although in a few cases, it will be necessary to deploy the static content. This can be done with the following command:


`bin/magento setup:static-content:deploy -f`


## How to consume the API
Since this web API is exposed to anonymous users, it can be accessed without the need for a token or authentication of any kind.

The urls must be formed in the following way:

`http://<magento_url>/rest/all/{endpoint}`

For the definition of the endpoints of this web API in a visual way, you can access the **Swagger UI** of Magento at:

`http://<magento_url>/swagger/#/concentrixCorporateGroupCorporateGroupRepositoryV1`

![Swagger api definition](/swagger.png)

To consume the API, you can either download a REST client (such as Postman or Insomnia) to make the corresponding requests, or you can perform a direct **curl** command. (You can even run it directly from **Swagger UI!**)

![REST client request example](/insomnia.png)

**Curl example**

```curl
curl -X 'POST' \
  'http://magento2.test/rest/all/V1/concentrix/corporate-groups' \
  -H 'accept: application/json' \
  -H 'Content-Type: application/json' \
  -d '{
  "corporateGroup": {
    "internal_code": "string",
    "name": "string",
    "email": "string",
    "telephone": "string"
  }
}'
```

## Manage corporate groups

There are 4 main endpoints:

| Description | Method | Endpoint |
| --- | --- | --- |
| Create a new corporate group | POST |`V1/concentrix/corporate-groups`|
| Get a corporate group | GET |`V1/concentrix/corporate-groups/{internalCode}`|
| Delete a corporate group | PUT |`V1/concentrix/corporate-groups`|
| Search corporate group(s) | GET |`V1/concentrix/corporate-groups`|

### 1. Create a new corporate group
**V1/concentrix/corporate-groups** `POST`


**Request example**

```json
{
  "corporateGroup": {
    "internal_code": "unique_code",
    "name": "Test Group Name or Label",
    "email": "test@concentrix.com",
    "telephone": "+525512345678"
  }
}
```

### 2. Get a corporate group
**V1/concentrix/corporate-groups/{internalCode}** `GET`


**Request example**

There is no request body for this, the **internal_code** must be passed by URL


### 3. Delete a corporate group
**V1/concentrix/corporate-groups** `PUT`


For this endpoint, I didn't use the `DELETE` method because of a bug I couldn't resolve :( sorry 

**Request example**

```json
{
  "internalCode": "unique_code"
}
```

### 4. Search corporate group(s)
**V1/concentrix/corporate-groups** `GET`


There is no request body for this, the URL must conform to a couple of `SearchCriteria` parameters (more details in **Swagger UI** of your Magento instance)

V1/concentrix/corporate-groups?searchCriteria%5BfilterGroups%5D%5B0%5D%5Bfilters%5D%5B0%5D%5Bfield%5D={**field_name**}&searchCriteria%5BfilterGroups%5D%5B0%5D%5Bfilters%5D%5B0%5D%5Bvalue%5D={**value**}


**Example (To search by phone)**

V1/concentrix/corporate-groups?searchCriteria%5BfilterGroups%5D%5B0%5D%5Bfilters%5D%5B0%5D%5Bfield%5D=**telephone**&searchCriteria%5BfilterGroups%5D%5B0%5D%5Bfilters%5D%5B0%5D%5Bvalue%5D=**+525512345678**

## Bind customer group to a customer

There are also 2 additional endpoints to link a client to a business group:

| Description | Method | Endpoint |
| --- | --- | --- |
| Link a corporate group to a customer by customer id | POST |`V1/concentrix/corporate-groups/link-customer-by-id`|
| Link a business group to a customer using the customer's email | POST |`V1/concentrix/corporate-groups/link-customer-by-email`|

### 1. Link a corporate group to a customer by customer ID
**V1/concentrix/corporate-groups/link-customer-by-id** `POST`


**Request example**

```json
{
  "internalCode": "unique_code",
  "customerId": 1
}
```

### 2. Link a corporate group to a customer by customer email
**V1/concentrix/corporate-groups/link-customer-by-email** `POST`


**Request example**

```json
{
  "internalCode": "unique_code",
  "customerEmail": "example@concentrix.com"
}
```
It is also possible to link a customer with an existing corporate group through the Magento administrator, going to **Customers > All Customers** then clicking on the customer of your choice and going to the **Account Information** tab

![REST client request example](/customer_admin.png)

That's it!
