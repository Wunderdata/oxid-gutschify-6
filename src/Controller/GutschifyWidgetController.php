<?php
/**
 * Widget controller for displaying Gutschify embedded home content
 *
 * @package Gutschify
 * @author Gutschify Team
 */

class GutschifyWidgetController extends oxWidget
{
    /**
     * @var string Template name
     */
    protected $_sThisTemplate = 'gutschify_widget.tpl';

    /**
     * Renders the widget
     *
     * @return string Template name
     */
    public function render()
    {
        parent::render();

        // Check if module is active before rendering
        $oModule = oxNew('oxModule');
        if (!$oModule->load('gutschify') || !$oModule->isActive()) {
            // Module not active, set flag and return template name (as per contract)
            $this->_aViewData['gutschify_module_inactive'] = true;
            $this->_aViewData['gutschify_content'] = '';
            $this->_aViewData['gutschify_error'] = '';
            $this->_aViewData['gutschify_widget_title'] = '';
            return $this->_sThisTemplate;
        }

        $config = $this->getConfig();
        
        // Get module settings using getShopConfVar with module prefix
        $baseUrl = $config->getShopConfVar('gutschify_base_url', null, 'module:gutschify');
        $organizationId = $config->getShopConfVar('organization_id', null, 'module:gutschify');
        $collectionSlug = $config->getShopConfVar('collection_slug', null, 'module:gutschify');
        if (empty($collectionSlug)) {
            $collectionSlug = 'default';
        }
        $widgetTitle = $config->getShopConfVar('widget_title', null, 'module:gutschify');
        $cacheEnabled = $config->getShopConfVar('cache_enabled', null, 'module:gutschify');
        $cacheTtl = $config->getShopConfVar('cache_ttl', null, 'module:gutschify');
        
        // Handle boolean and defaults
        $cacheEnabled = ($cacheEnabled === '1' || $cacheEnabled === true || $cacheEnabled === 'true');
        if (empty($cacheTtl)) {
            $cacheTtl = 3600;
        } else {
            $cacheTtl = (int)$cacheTtl;
        }

        $content = '';
        $error = '';

        // Validate configuration
        if (empty($baseUrl) || empty($organizationId)) {
            $error = 'Gutschify module is not properly configured. Please set Base URL and Organization ID in module settings.';
        } else {
            try {
                require_once __DIR__ . '/../Service/GutschifyService.php';
                require_once __DIR__ . '/../Exception/GutschifyException.php';
                
                $service = new GutschifyService();
                $content = $service->fetchEmbeddedHome(
                    $baseUrl,
                    $organizationId,
                    $collectionSlug,
                    $cacheEnabled,
                    $cacheTtl
                );
            } catch (GutschifyException $e) {
                $error = 'Failed to load Gutschify content: ' . $e->getMessage();
            } catch (Exception $e) {
                $error = 'An unexpected error occurred: ' . $e->getMessage();
            }
        }

        // Pass data to template
        $this->_aViewData['gutschify_content'] = $content;
        $this->_aViewData['gutschify_error'] = $error;
        $this->_aViewData['gutschify_widget_title'] = $widgetTitle;

        return $this->_sThisTemplate;
    }
}

