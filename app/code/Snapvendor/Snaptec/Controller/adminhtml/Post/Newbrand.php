<?php

namespace Snapvendor\Snaptec\Controller\Adminhtml\Post;
use Magento\Framework\App\Action\HttpGetActionInterface as HttpGetActionInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\Result\PageFactory;

class Newbrand extends Action implements  HttpGetActionInterface
{
	protected $resultPageFactory = false;

	public function __construct(
		Context $context,
		PageFactory $resultPageFactory
	)
	{
		parent::__construct($context);
		$this->resultPageFactory = $resultPageFactory;
	}

	public function execute()
	{
		$resultRedirect = $this->resultPageFactory->create(ResultFactory::TYPE_REDIRECT);
		$resultPage = $this->resultPageFactory->create();
		$resultPage->getConfig()->getTitle()->set((__('Add New Brand')));
		return $resultPage;
	}
}
