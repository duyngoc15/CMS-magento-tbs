<?php
namespace Snapvendor\Snaptec\Model\ResourceModel\Post;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init('Snapvendor\Snaptec\Model\Post', 'Snapvendor\Snaptec\Model\ResourceModel\Post');
	}

}