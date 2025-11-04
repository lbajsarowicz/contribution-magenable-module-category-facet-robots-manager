<?php
namespace Magenable\CategoryFacetRobotsManager\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\View\Page\Config as PageConfig;
use Magento\Framework\App\Request\Http as HttpRequest;
use Magenable\CategoryFacetRobotsManager\Model\ConfigProvider;
use Magento\Framework\Event\Observer;

class AddRobotsMeta implements ObserverInterface
{
    private ConfigProvider $configProvider;
    private HttpRequest $request;
    private PageConfig $pageConfig;

    public function __construct(
        ConfigProvider $configProvider,
        HttpRequest $request,
        PageConfig $pageConfig,
    ) {
        $this->configProvider = $configProvider;
        $this->request = $request;
        $this->pageConfig = $pageConfig;
    }

    public function execute(Observer $observer): void
    {
        if (!$this->configProvider->moduleIsEnabled()) {
            return;
        }

        $ignoreParams = explode(',', $this->configProvider->getIgnoreParams());
        foreach ($ignoreParams as $k => $ignoreParam) {
            $ignoreParams[$k] = trim($ignoreParam);
        }

        $requestParams = $this->request->getParams();

        unset($requestParams['id']);
        foreach ($requestParams as $k => $v) {
            if (in_array($k, $ignoreParams)) {
                unset($requestParams[$k]);
            }
        }

        if (empty($requestParams)) {
            return;
        }

        $this->pageConfig->setRobots($this->configProvider->getMetaTagContent());
    }
}
