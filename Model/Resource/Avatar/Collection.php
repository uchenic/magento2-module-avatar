<?php 
namespace Maento\Avatar\Model\Resource\Avatar;
use \Magento\Framework\Model\Resource\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Magento\Avatar\Model\Avatar', 'Magento\Avatar\Model\Resource\Avatar');
    }

}
