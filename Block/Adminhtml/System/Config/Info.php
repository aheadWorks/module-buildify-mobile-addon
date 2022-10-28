<?php
declare(strict_types=1);

namespace Aheadworks\BuildifyMobileAddon\Block\Adminhtml\System\Config;

use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\View\Helper\SecureHtmlRenderer;
use Aheadworks\BuildifyMobileAddon\ViewModel\System\Config\Info as ViewModel;

/**
 * Renderer for information
 */
class Info extends Field
{
    /**
     * @var ViewModel
     */
    private $viewModel;

    /**
     * Template path
     *
     * @var string
     */
    protected $_template = 'Aheadworks_BuildifyMobileAddon::system/config/info.phtml';

    /**
     * Info constructor.
     *
     * @param Context $context
     * @param ViewModel $viewModel
     * @param array $data
     * @param SecureHtmlRenderer|null $secureRenderer
     */
    public function __construct(
        Context $context,
        ViewModel $viewModel,
        array $data = [],
        ?SecureHtmlRenderer $secureRenderer = null
    ) {
        parent::__construct($context, $data, $secureRenderer);
        $this->viewModel = $viewModel;
    }

    /**
     * Render fieldset html
     *
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     */
    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $columns = $this->getRequest()->getParam('website') || $this->getRequest()->getParam('store') ? 5 : 4;
        return $this->_decorateRowHtml($element, "<td colspan='{$columns}'>" . $this->toHtml() . '</td>');
    }

    /**
     * Retrieve view model
     *
     * @return ViewModel
     */
    public function getViewModel()
    {
        return $this->viewModel;
    }
}
