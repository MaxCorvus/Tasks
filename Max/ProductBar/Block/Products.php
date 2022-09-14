<?php

declare(strict_types=1);

namespace Max\ProductBar\Block;

use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Template;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Catalog\Model\Product\Attribute\Source\Status;
use Psr\Log\LoggerInterface;

class Products extends Template
{
    /**
     * Small image value.
     *
     * @var string
     */
    const SMALL_IMAGE = 'small_image';

    /**
     * @var CollectionFactory
     */
    private $productCollectionFactory;

    /**
     * @var PriceCurrencyInterface
     */
    private $priceCurrency;

    protected $productVisibility;

    protected $productStatus;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param Template\Context $context
     * @param CollectionFactory $collection
     * @param PriceCurrencyInterface $priceCurrency
     * @param LoggerInterface $logger
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        CollectionFactory $collection,
        PriceCurrencyInterface $priceCurrency,
        Status $productStatus,
        Visibility $productVisibility,
        LoggerInterface $logger,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->productCollectionFactory = $collection;
        $this->priceCurrency = $priceCurrency;
        $this->productStatus = $productStatus;
        $this->productVisibility = $productVisibility;
        $this->logger = $logger;
    }

    /**
     * @return false|\Magento\Framework\DataObject[]
     */
    public function getProducts()
    {
        try {
            $collection = $this->productCollectionFactory->create();
            $collection->addFilter('type_id', 'simple');
            $collection->addAttributeToSelect('price');
            $collection->addAttributeToSelect('product_url');
            $collection->addAttributeToSelect('name');
            $collection->addAttributeToSelect('small_image');
            $collection->addAttributeToFilter('status', ['in' => $this->productStatus->getVisibleStatusIds()]);
            $collection->setVisibility($this->productVisibility->getVisibleInSiteIds());
            $collection->getSelect()->orderRand()->limit(3);

            return $collection->getItems();
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
            return false;
        }
    }

    /**
     * @param $product
     * @return false|string
     */
    public function getSmallImageUrl($product)
    {
        try {
            return $this->getMediaUrl() . $product->getSmallImage();
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
            return false;
        }
    }

    /**
     * @param $price
     * @return string
     */
    public function getFormatPrice($price)
    {
        return $this->priceCurrency->format($price, true, 2);
    }

    /**
     * @return string
     */
    public function getMediaUrl()
    {
        return $this->_urlBuilder->getBaseUrl(['_type' => UrlInterface::URL_TYPE_MEDIA]) . 'catalog/product';
    }
}
