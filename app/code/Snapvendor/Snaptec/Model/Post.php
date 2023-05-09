<?php
namespace Snapvendor\Snaptec\Model;
class Post extends \Magento\Framework\Model\AbstractModel
{
	protected function _construct()
	{
		$this->_init('Snapvendor\Snaptec\Model\ResourceModel\Post');
	}
}
