<?php
/**
 * Visual CMS Shortcode for Gutschify Embedded Home Widget
 *
 * @package Gutschify
 * @author Gutschify Team
 */

use OxidEsales\VisualCmsModule\Application\Model\VisualEditorShortcode;
use OxidEsales\Eshop\Core\Registry;

class gutschify_shortcode extends VisualEditorShortcode
{
    /**
     * Widget title (language string)
     * @var string
     */
    protected $_sTitle = 'DD_VISUAL_EDITOR_SHORTCODE_GUTSCHIFY';

    /**
     * Widget background color in admin
     * @var string
     */
    protected $_sBackgroundColor = '#3498db';

    /**
     * Widget icon (FontAwesome class)
     * @var string
     */
    protected $_sIcon = 'fa-gift';

    /**
     * Shortcode name
     * @var string
     */
    protected $_sShortCode = 'gutschify';

    /**
     * Widget options
     * @var array
     */
    protected $_aOptions = [];

    /**
     * Install method - called when widget is initialized in admin
     * Sets up the widget options/fields for the Visual CMS editor
     */
    public function install()
    {
        $this->setShortCode(basename(__FILE__, '.php'));

        $oLang = Registry::getLang();
        $oConfig = $this->getConfig();

        // Get module settings for defaults
        $defaultCollectionSlug = $oConfig->getShopConfVar('collection_slug', null, 'module:gutschify');
        if (empty($defaultCollectionSlug)) {
            $defaultCollectionSlug = 'default';
        }

        $this->setOptions(
            array(
                'collection_slug' => array(
                    'type' => 'text',
                    'label' => $oLang->translateString('DD_VISUAL_EDITOR_WIDGET_GUTSCHIFY_COLLECTION'),
                    'placeholder' => $oLang->translateString('DD_VISUAL_EDITOR_WIDGET_GUTSCHIFY_COLLECTION_PLACEHOLDER'),
                    'value' => $defaultCollectionSlug,
                    'preview' => true,
                ),
                'widget_title' => array(
                    'type' => 'text',
                    'label' => $oLang->translateString('DD_VISUAL_EDITOR_WIDGET_GUTSCHIFY_TITLE'),
                    'placeholder' => $oLang->translateString('DD_VISUAL_EDITOR_WIDGET_GUTSCHIFY_TITLE_PLACEHOLDER'),
                    'required' => false,
                ),
            )
        );
    }

    /**
     * Parse method - called when shortcode is rendered in frontend
     *
     * @param string $sContent Reserved for widget content option
     * @param array $aParams Widget parameters
     * @return string Rendered HTML
     */
    public function parse($sContent = '', $aParams = array())
    {
        $oConfig = $this->getConfig();

        // Check if module is active
        $oModule = oxNew('oxModule');
        if (!$oModule->load('gutschify') || !$oModule->isActive()) {
            return '<div class="gutschify-widget-error" style="padding: 20px; background: #fee; border: 1px solid #fcc; color: #c00;">
                <p><strong>Error:</strong> Gutschify module is not active.</p>
            </div>';
        }

        // Get module settings
        $baseUrl = $oConfig->getShopConfVar('gutschify_base_url', null, 'module:gutschify');
        $organizationId = $oConfig->getShopConfVar('organization_id', null, 'module:gutschify');
        
        // Get collection slug from widget params or fall back to module default
        $collectionSlug = !empty($aParams['collection_slug']) 
            ? $aParams['collection_slug'] 
            : $oConfig->getShopConfVar('collection_slug', null, 'module:gutschify');
        
        if (empty($collectionSlug)) {
            $collectionSlug = 'default';
        }

        // Get widget title from params or module settings
        $widgetTitle = !empty($aParams['widget_title']) 
            ? $aParams['widget_title'] 
            : $oConfig->getShopConfVar('widget_title', null, 'module:gutschify');

        $cacheEnabled = $oConfig->getShopConfVar('cache_enabled', null, 'module:gutschify');
        $cacheTtl = $oConfig->getShopConfVar('cache_ttl', null, 'module:gutschify');
        
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
                // Load service classes if not already loaded
                if (!class_exists('GutschifyService')) {
                    $servicePath = __DIR__ . '/../../src/Service/GutschifyService.php';
                    if (file_exists($servicePath)) {
                        require_once $servicePath;
                    }
                }
                if (!class_exists('GutschifyException')) {
                    $exceptionPath = __DIR__ . '/../../src/Exception/GutschifyException.php';
                    if (file_exists($exceptionPath)) {
                        require_once $exceptionPath;
                    }
                }
                
                if (class_exists('GutschifyService')) {
                    $service = new GutschifyService();
                    $content = $service->fetchEmbeddedHome(
                        $baseUrl,
                        $organizationId,
                        $collectionSlug,
                        $cacheEnabled,
                        $cacheTtl
                    );
                } else {
                    $error = 'Gutschify service class could not be loaded.';
                }
            } catch (GutschifyException $e) {
                $error = 'Failed to load Gutschify content: ' . $e->getMessage();
            } catch (Exception $e) {
                $error = 'An unexpected error occurred: ' . $e->getMessage();
            }
        }

        // Build output
        $sOutput = '<div class="dd-shortcode-' . $this->getShortCode() . ' gutschify-widget">';
        
        if (!empty($widgetTitle)) {
            $sOutput .= '<h3 class="gutschify-widget-title">' . htmlspecialchars($widgetTitle, ENT_QUOTES, 'UTF-8') . '</h3>';
        }

        if (!empty($error)) {
            $sOutput .= '<div class="gutschify-widget-error" style="padding: 20px; background: #fee; border: 1px solid #fcc; color: #c00;">
                <p><strong>Error:</strong> ' . htmlspecialchars($error, ENT_QUOTES, 'UTF-8') . '</p>
            </div>';
        } elseif (!empty($content)) {
            $sOutput .= $content;
        } else {
            $sOutput .= '<div class="gutschify-widget-error" style="padding: 20px; background: #fee; border: 1px solid #fcc; color: #c00;">
                <p>Content could not be loaded.</p>
            </div>';
        }

        $sOutput .= '</div>';

        return $sOutput;
    }
}

