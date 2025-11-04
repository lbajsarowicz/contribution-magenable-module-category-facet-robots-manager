<?php

declare(strict_types=1);

namespace Magenable\CategoryFacetRobotsManager\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class ConfigProvider
{
    public const CONFIG_ENABLED = 'magenable_category_facet_robots_manager/general/enabled';
    public const CONFIG_IGNORE_PARAMS = 'magenable_category_facet_robots_manager/general/ignore_params';
    public const CONFIG_META_TAG_CONTENT = 'magenable_category_facet_robots_manager/general/meta_tag_content';

    private ScopeConfigInterface $scopeConfig;

    public function __construct(
        ScopeConfigInterface $scopeConfig,
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    public function moduleIsEnabled(): bool
    {
        return (bool)$this->scopeConfig->getValue(
            self::CONFIG_ENABLED,
            ScopeInterface::SCOPE_STORES
        );
    }

    public function getIgnoreParams(): string
    {
        return $this->scopeConfig->getValue(
            self::CONFIG_IGNORE_PARAMS,
            ScopeInterface::SCOPE_STORES
        );
    }

    public function getMetaTagContent(): string
    {
        return $this->scopeConfig->getValue(
            self::CONFIG_META_TAG_CONTENT,
            ScopeInterface::SCOPE_STORES
        );
    }
}
