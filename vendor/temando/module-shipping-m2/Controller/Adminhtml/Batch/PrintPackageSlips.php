<?php
/**
 * Refer to LICENSE.txt distributed with the Temando Shipping module for notice of license
 */
namespace Temando\Shipping\Controller\Adminhtml\Batch;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Sales\Controller\Adminhtml\Order\Pdfshipments;

/**
 * Temando Batch PrintPackageSlips Action
 *
 * @package Temando\Shipping\Controller
 * @author  Sebastian Ertner <sebastian.ertner@temando.com>
 * @license https://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link    https://www.temando.com/
 */
class PrintPackageSlips extends Pdfshipments
{
    /**
     * Authorization level
     */
    const ADMIN_RESOURCE = 'Temando_Shipping::batches';

    /**
     * Check ACL.
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return (
            $this->_authorization->isAllowed(static::ADMIN_RESOURCE) &&
            $this->_authorization->isAllowed('Magento_Sales::ship') &&
            $this->_authorization->isAllowed('Magento_Sales::shipment')
        );
    }

    /**
     * Execute action.
     *
     * @return ResponseInterface|Redirect
     */
    public function execute()
    {
        $orderIds = $this->getRequest()->getParam('order_ids');
        $orderIds = explode(',', $orderIds);

        return $this->packageSlipsMassAction($orderIds);
    }

    /**
     * Prepare download response.
     *
     * @param int[] $orderIds
     * @return ResponseInterface|Redirect
     */
    private function packageSlipsMassAction(array $orderIds)
    {
        $shipmentsCollection = $this->shipmentCollectionFactory
            ->create()
            ->setOrderFilter(['in' => $orderIds]);
        if (!$shipmentsCollection->getSize()) {
            $this->messageManager->addErrorMessage(__('There are no printable documents related to selected orders.'));
            return $this->resultRedirectFactory->create()->setPath($this->_redirect->getRefererUrl());
        }

        try {
            $fileName = sprintf(
                'packingslip-%s-%s.pdf',
                $this->getRequest()->getParam('batch_id'),
                $this->dateTime->date('Y-m-d_H-i-s')
            );

            $response = $this->fileFactory->create(
                $fileName,
                $this->pdfShipment->getPdf($shipmentsCollection->getItems())->render(),
                DirectoryList::VAR_DIR,
                'application/pdf'
            );
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('There was a error creating package slip pdf.'));
            return $this->resultRedirectFactory->create()->setPath($this->_redirect->getRefererUrl());
        }

        return $response;
    }
}
