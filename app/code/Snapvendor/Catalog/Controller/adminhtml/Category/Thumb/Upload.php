<?php
namespace Snapvendor\Catalog\Controller\adminhtml\Category\Thumb;
use Magento\Framework\Controller\ResultFactory;
 
class Upload extends \Magento\Backend\App\Action
{
 protected $imageUploader;
 
 public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Catalog\Model\ImageUploader $imageUploader
 ) {
        parent::__construct($context);
        $this->imageUploader = $imageUploader;
 }
 
 protected function _isAllowed()
 {
     return $this->_authorization->isAllowed('Magento_Catalog::categories');
 }
 
 public function execute()
 {
     try {
            $result = $this->imageUploader->saveFileToTmpDir('image_thumb');
 
            $result['cookie'] = [
                'name' => $this->_getSession()->getName(),
                'value' => $this->_getSession()->getSessionId(),
                'lifetime' => $this->_getSession()->getCookieLifetime(),
                'path' => $this->_getSession()->getCookiePath(),
                'domain' => $this->_getSession()->getCookieDomain(),
         ];
     } catch (\Exception $e) {
            $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
     }
     return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($result);
 }
}