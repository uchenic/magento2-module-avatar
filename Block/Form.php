<?php

namespace Magento\Avatar\Block;

class Form extends \Magento\Framework\View\Element\Template {

	protected $_template = 'form.phtml';

	public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
      //  \Ashsmith\Blog\Model\Resource\Post\CollectionFactory $postCollectionFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
       
    }

    public function getFormActionUrl()
    {
        return $this->getUrl('/avatar/gallery/upload/');
    }
}