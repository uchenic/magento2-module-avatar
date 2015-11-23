<?php 
namespace Magento\Avatar\Model;


//use Magento\Framework\DataObject\IdentityInterface;

class Avatar  extends \Magento\Framework\Model\AbstractModel //implements  IdentityInterface
{
    protected $_processor=null;

    protected $_imageFactory=null;
    protected $_width=400;
    protected $_height=400;
    protected $_filename;

	 function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\UrlInterface $urlBuilder,
        \Magento\Framework\Image\Factory $imageFactory,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = [])
    {
        $this->_urlBuilder = $urlBuilder;
        $this->_imageFactory = $imageFactory;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

        protected function _construct()
    {
        $this->_init('Magento\Avatar\Model\Resource\Avatar');
    }


    public function getImageProcessor()
    {
        if (!$this->_processor) {
            //$filename = $this->getBaseFile() ? $this->_mediaDirectory->getAbsolutePath($this->getBaseFile()) : null;
            $this->_processor = $this->_imageFactory->create($this->_filename);
        }
        $this->_processor->keepAspectRatio(true);
        $this->_processor->keepFrame(true);
        // $this->_processor->keepTransparency($this->_keepTransparency);
        // $this->_processor->constrainOnly($this->_constrainOnly);
        // $this->_processor->backgroundColor($this->_backgroundColor);
        // $this->_processor->quality($this->_quality);
        return $this->_processor;
    }

    public function getBaseFile()
    {
        return $this->_filename;
    }

    public function setBaseFile($file)
    {
        $this->_filename=$file;
        return 0;
    }

    /**
     * @see \Magento\Framework\Image\Adapter\AbstractAdapter
     * @return $this
     */
    public function resize()
    {
        // if ($this->getWidth() === null && $this->getHeight() === null) {
        //     return $this;
        // }
        $this->getImageProcessor()->resize($this->_width, $this->_height);
        return $this;
    }

    public function saveFile($path,$value)
    {
        $this->getImageProcessor()->save($path.$value);
        //save to model
       $this->setData('value', $value);
    }

    public function UploadAvatar($avatar)
    {
    	# code...
    }

    public function setCustomer($value)
    {
    	$this->setData('customer_id', $value);
    }

    public function GetAvatar($user)
    {
    	# code...
    }

}