<?php

namespace Born\OrderController\Controller\Guestorderhistory;

class Index extends \Magento\Framework\App\Action\Action {

	protected $_resultPageFactory;
	protected $_orderCollectionFactory;
	protected $_resultJsonFactory;

	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $resultPageFactory,
		\Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory,
		\Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
	) {

		$this->_resultPageFactory = $resultPageFactory;

		$this->_orderCollectionFactory = $orderCollectionFactory;

		$this->_resultJsonFactory = $resultJsonFactory;


		parent::__construct($context);
	}

	public function execute() {


		/*
		// Abdullah Radwan

		$resultPage = $this->_resultPageFactory->create();

		return $resultPage;
		*/

		$result = $this->_resultJsonFactory->create();

		$jsonData = $this->getGuestOrders();

		return $result->setData($jsonData);
		
	}

    public function getGuestOrders() {

    	$orders = array();

    	foreach($this->getGuestOrderCollection() as $ikey => $collection) {

			$orders[$ikey]['id'] = $collection->getId();

			$orders[$ikey]['order_incremental_id'] = $collection->getIncrementId();

			$orders[$ikey]['status'] = $collection->getStatus();

			$orders[$ikey]['sub_total'] = $collection->getSubtotal();

			$orders[$ikey]['total'] = $collection->getGrandTotal();

			$allVisibleItems = $collection->getAllVisibleItems();

			$items = array();

			foreach($allVisibleItems as $jkey => $item) {

				$items[$jkey]['sku'] = $item->getSku();

				$items[$jkey]['item_id'] = $item->getItemId();

				$items[$jkey]['price'] = $item->getRowTotal();

			}

			$orders[$ikey]['items'] = $items;
    	}

    	return $orders;
    }


	public function getGuestOrderCollection() {

		$orderCollecion = $this->_orderCollectionFactory->create()->addFieldToSelect('*');

		//print_r($orderCollecion->getData());

		/*
		// Abdullah Radwan 

		$customerId = $this->getRequest()->getParam('customer_id');

		if($customerId) {

			$orderCollecion->addFieldToFilter('customer_id', array('eq' => $customerId));
		}
		*/

		$orderId = $this->getRequest()->getParam('order_id');

		if($orderId) {

			$orderCollecion->addFieldToFilter('entity_id', array('eq' => $orderId));
		}

		$orderCollecion->addAttributeToFilter('customer_is_guest', ['eq' => 1]);

		$limit = $this->getRequest()->getParam('limit');

		if ($limit != 'all'){

			$orderCollecion->getSelect()->limit( (int) $limit );
		}

		return $orderCollecion;
	}
}