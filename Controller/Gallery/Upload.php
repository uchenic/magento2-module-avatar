<?php
/**
 *
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Avatar\Controller\Gallery;

use Magento\Framework\App\Filesystem\DirectoryList;


class Upload extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Framework\Controller\Result\RawFactory
     */
    protected $resultRawFactory;



    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\Controller\Result\RawFactory $resultRawFactory
     */
    public function __construct(\Magento\Framework\App\Action\Context $context,
                              
                                \Magento\Framework\Controller\Result\ForwardFactory $resultForwardFactory
                            
    )
    {
        $this->resultForwardFactory = $resultForwardFactory;
    
        parent::__construct($context);
    }


    /**
     * @return \Magento\Framework\Controller\Result\Raw
     */
    public function execute()
    {
        //try {
            $uploader = $this->_objectManager->create(
                'Magento\MediaStorage\Model\File\Uploader',
                ['fileId' => 'image']
            );
            $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
            /** @var \Magento\Framework\Image\Adapter\AdapterInterface $imageAdapter */
            $imageAdapter = $this->_objectManager->get('Magento\Framework\Image\AdapterFactory')->create();
            $uploader->addValidateCallback('catalog_product_image', $imageAdapter, 'validateUploadFile');
            $uploader->setAllowRenameFiles(true);
            $uploader->setFilesDispersion(true);
            /** @var \Magento\Framework\Filesystem\Directory\Read $mediaDirectory */
            $mediaDirectory = $this->_objectManager->get('Magento\Framework\Filesystem')
                ->getDirectoryRead(DirectoryList::MEDIA);
            //$config = $this->_objectManager->get('Magento\Catalog\Model\Product\Media\Config');
            $result = $uploader->save($mediaDirectory->getAbsolutePath('tmp/media/avatar'));//$config->getBaseTmpMediaPath()

            //move file and resize



            $model = $this->_objectManager->get('Magento\Avatar\Model\AvatarFactory')->create();
            //load user??
            // $model->load($customer_id);
            $model->setCustomer( $this->_objectManager->get('Magento\Customer\Model\Session')->getCustomerId());
            // $this->_customerSession->isLoggedIn()
            $model->setBaseFile($mediaDirectory->getAbsolutePath('tmp/media/avatar').$result['file']);
            // if($model->getId==null)
            // {
           
            
            // }
            $model->resize();
            $model->saveFile($mediaDirectory->getAbsolutePath('avatar/400/400'),$result['file']);
            $model->save();


            $this->_eventManager->dispatch(
                'customer_avatar_upload_image_after',
                ['result' => $result, 'action' => $this]
            );

            unset($result['tmp_name']);
            unset($result['path']);

            // $result['url'] = $this->_objectManager->get('Magento\Catalog\Model\Product\Media\Config')
            //     ->getTmpMediaUrl($result['file']);
            // $result['file'] = $result['file'] . '.tmp';
        // } catch (\Exception $e) {
        //     $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
        // }
        //echo json_encode($result);
        /** @var \Magento\Framework\Controller\Result\Raw $response */
        $response = $this->resultForwardFactory->create();
        // $response->setHeader('Content-type', 'text/plain');
        // $response->setContents(json_encode($result));
         return $response->redirect('/*/*/');
    }
}
