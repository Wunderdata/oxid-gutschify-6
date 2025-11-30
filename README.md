# Gutschify Module for OXID eShop 6.x

This module displays the Gutschify embedded home page as a configurable widget/block in your OXID eShop 6.x store.

## Features

- Display Gutschify promotional tiles and wheel of fortune
- Configurable collection selection
- Caching support for improved performance
- Error handling with graceful degradation
- Easy configuration via OXID admin panel

## Requirements

- OXID eShop 6.x
- PHP 7.4 or lower
- cURL extension enabled

## Installation

### Manual Installation

1. Copy the module files to your OXID installation:
   ```bash
   cp -r oxid-gutschify-6/* /path/to/oxid/source/modules/gutschify/
   ```

2. Clear OXID cache:
   ```bash
   rm -rf /path/to/oxid/tmp/*
   ```

3. **Register the module configuration (required for OXID 6 PE/EE editions):**
   
   In OXID 6 Professional and Enterprise editions (e.g., v6.5.5), the module won't appear in the admin without registering it first via the OXID console:
   
   ```bash
   cd /path/to/oxid
   php vendor/bin/oe-console oe:module:install-configuration source/modules/gutschify/ \
     && vendor/bin/oe-console oe:module:apply-configuration \
     && rm -rf source/tmp/*
   ```
   
   > **Note:** For OXID CE (Community Edition), this step may not be required - the module should appear automatically after copying the files.

4. Log in to OXID Admin Panel

5. Navigate to **Extensions → Modules**

6. Find "Gutschify Embedded Home Widget" in the module list

7. Click **Activate** to activate the module

8. Click on the module name to configure settings

## Configuration

After installation, configure the module in **Extensions → Modules → Gutschify → Settings**:

### Required Settings

- **gutschify_base_url**: Base URL of the Gutschify service (e.g., `https://gutschify.xxiii.tools`)
- **organization_id**: Your organization UUID from Gutschify

### Optional Settings

- **collection_slug**: Collection slug to display (defaults to "default")
- **widget_title**: Optional title to display above the widget
- **cache_enabled**: Enable/disable caching (default: enabled)
- **cache_ttl**: Cache time-to-live in seconds (default: 3600)

## Usage

### Adding the Widget to a Page

1. In OXID Admin, navigate to **Content → CMS Pages** (or your content management area)

2. Edit the page where you want to add the widget

3. Add the widget using the widget selector or by adding:
   ```
   [{oxid_widget ident="gutschify" widget="gutschify_widget"}]
   ```

4. Save the page

### Widget Placement

The widget can be placed in:
- CMS pages
- Category pages
- Article pages
- Homepage
- Any template that supports widgets

## Troubleshooting

### Widget Not Displaying

1. Check that the module is activated in **Extensions → Modules**
2. Verify module settings are configured correctly
3. Check OXID error logs: `log/oxideshop.log`
4. Clear OXID cache: `rm -rf tmp/*`

### Content Not Loading

1. Verify `gutschify_base_url` is correct and accessible
2. Check that `organization_id` is valid
3. Ensure the collection slug exists for your organization
4. Check network connectivity from your server to Gutschify service

### Cache Issues

If you see stale content:
1. Disable caching temporarily in module settings
2. Clear OXID cache: `rm -rf tmp/*`
3. Clear Gutschify cache: `rm -rf tmp/gutschify/*`

## File Structure

```
gutschify/
├── metadata.php                    # Module metadata
├── README.md                       # This file
├── src/
│   ├── Controller/
│   │   └── GutschifyWidgetController.php
│   ├── Service/
│   │   └── GutschifyService.php
│   └── Exception/
│       └── GutschifyException.php
└── views/
    └── widget/
        └── gutschify_widget.tpl
```

## Development

### Running Tests

```bash
# Install PHPUnit (if not already installed)
composer require --dev phpunit/phpunit:^5.7

# Run tests
vendor/bin/phpunit

# Note: Tests require OXID environment or proper mocking of OXID classes
```

### Test Structure

The test suite includes 14 test cases covering:
- ✅ Input validation (empty base URL, empty organization ID)
- ✅ URL construction (with/without trailing slash, custom collection slug)
- ✅ Cache functionality (enabled/disabled, expiration, TTL)
- ✅ Error handling (HTTP errors, network timeouts, connection errors)
- ✅ Default parameters (collection slug defaults to "default")
- ✅ HTML sanitization
- ✅ Cache file path generation

**Note:** Some tests are marked as incomplete because they require:
- Mocking of OXID classes (oxConfig, oxRegistry) - OXID 6.x uses static calls
- cURL mocking or test HTTP server - for actual HTTP request testing
- OXID environment setup - for full integration testing

**Why fewer working tests than OXID 7.x?**
OXID 6.x uses static method calls (`oxConfig::getInstance()`) and direct file system access, which are harder to mock than OXID 7.x's dependency injection. The test structure is complete, but full execution requires either:
1. An actual OXID 6.x environment, or
2. Advanced mocking techniques for static classes

See `tests/Unit/Service/GutschifyServiceTest.php` for complete test structure.

## Support

For support and questions:
- Email: support@gutschify.xxiii.tools
- Website: https://gutschify.xxiii.tools

## License

MIT License

## Changelog

### Version 1.0.0
- Initial release
- Support for OXID 6.x
- Configurable collection selection
- Caching support

