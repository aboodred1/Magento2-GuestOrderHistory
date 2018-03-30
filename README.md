# Magento2 Guest Order History Feature

This is a Magento 2 extension to get guest order history. The controller takes parameter(s) to query a single order and returns a json with information about order status, total, items (sku, item_id, price) and grand total.

# Installation:

- Download or clone this repo
- place Born Folder under Magento 2 app/code folder
- Run the following command: php bin/magento setup:upgrade

# How to get JSON guest order history:

Accessing the following URL, will allow you to list all guests order history:

http://magento.domain/ordercontroller/guestorderhistory/

Viewing one oder should be as follow:

http://magento.domain/ordercontroller/guestorderhistory/?order_id=1
