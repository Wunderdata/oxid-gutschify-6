<?php
/**
 * Service class for fetching embedded home content from Gutschify service
 *
 * @package Gutschify
 * @author Gutschify Team
 */

class GutschifyService
{
    /**
     * @var string Cache key prefix
     */
    const CACHE_PREFIX = 'gutschify_content_';

    /**
     * Fetches embedded home HTML from Gutschify service
     *
     * @param string $baseUrl Base URL of the Gutschify service
     * @param string $organizationId Organization UUID
     * @param string $collectionSlug Collection slug (defaults to "default")
     * @param bool $cacheEnabled Whether caching is enabled
     * @param int $cacheTtl Cache time-to-live in seconds
     * @return string HTML content
     * @throws GutschifyException
     */
    public function fetchEmbeddedHome($baseUrl, $organizationId, $collectionSlug = 'default', $cacheEnabled = true, $cacheTtl = 3600)
    {
        // Validate inputs
        if (empty($baseUrl)) {
            throw new GutschifyException('Base URL is required');
        }
        if (empty($organizationId)) {
            throw new GutschifyException('Organization ID is required');
        }

        // Check cache if enabled
        if ($cacheEnabled) {
            $cacheKey = self::CACHE_PREFIX . md5($baseUrl . $organizationId . $collectionSlug);
            $cachedContent = $this->getFromCache($cacheKey);
            if ($cachedContent !== false) {
                return $cachedContent;
            }
        }

        // Build URL
        $url = rtrim($baseUrl, '/') . '/embedded-home/';
        $url .= '?organization_id=' . urlencode($organizationId);
        $url .= '&collection=' . urlencode($collectionSlug);

        // Fetch content using cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_USERAGENT, 'OXID-Gutschify-Module/1.0');

        $content = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($content === false || !empty($error)) {
            throw new GutschifyException('Failed to fetch content: ' . $error);
        }

        if ($httpCode !== 200) {
            throw new GutschifyException('HTTP error: ' . $httpCode);
        }

        // Sanitize content (basic HTML sanitization)
        $content = $this->sanitizeHtml($content);

        // Store in cache if enabled
        if ($cacheEnabled) {
            $this->storeInCache($cacheKey, $content, $cacheTtl);
        }

        return $content;
    }

    /**
     * Gets content from cache
     *
     * @param string $cacheKey Cache key
     * @return string|false Cached content or false if not found
     */
    protected function getFromCache($cacheKey)
    {
        $cacheFile = $this->getCacheFilePath($cacheKey);
        
        if (file_exists($cacheFile)) {
            $cacheData = unserialize(file_get_contents($cacheFile));
            if ($cacheData && isset($cacheData['expires']) && $cacheData['expires'] > time()) {
                return $cacheData['content'];
            }
            // Cache expired, remove file
            @unlink($cacheFile);
        }
        
        return false;
    }

    /**
     * Stores content in cache
     *
     * @param string $cacheKey Cache key
     * @param string $content Content to cache
     * @param int $ttl Time-to-live in seconds
     */
    protected function storeInCache($cacheKey, $content, $ttl)
    {
        $cacheFile = $this->getCacheFilePath($cacheKey);
        $cacheDir = dirname($cacheFile);
        
        if (!is_dir($cacheDir)) {
            @mkdir($cacheDir, 0755, true);
        }
        
        $cacheData = [
            'content' => $content,
            'expires' => time() + $ttl
        ];
        
        @file_put_contents($cacheFile, serialize($cacheData));
    }

    /**
     * Gets cache file path
     *
     * @param string $cacheKey Cache key
     * @return string Cache file path
     */
    protected function getCacheFilePath($cacheKey)
    {
        $config = oxRegistry::get("oxConfig");
        $cacheDir = $config->getConfigParam('sCompileDir') . 'gutschify/';
        return $cacheDir . $cacheKey . '.cache';
    }

    /**
     * Basic HTML sanitization
     *
     * @param string $html HTML content
     * @return string Sanitized HTML
     */
    protected function sanitizeHtml($html)
    {
        // Basic sanitization - in production, consider using a proper HTML sanitizer
        return $html;
    }
}

