# How to Use the Gutschify Widget

## Overview

The Gutschify widget displays the embedded home page from your Gutschify service. Once activated, you can add it to any OXID template.

## Configuration

Before using the widget, make sure to configure it in the admin panel:

1. Go to **Extensions → Modules**
2. Click on **"Gutschify Embedded Home Widget"**
3. Go to the **Settings** tab
4. Configure:
   - **Gutschify Base URL**: `https://gutschify.xxiii.tools` (or your Gutschify instance)
   - **Organization ID**: Your organization UUID
   - **Collection Slug**: The collection to display (default: `default`)
   - **Widget Title** (optional): Custom title for the widget
   - **Enable Caching**: Enable/disable caching
   - **Cache Time-to-Live**: Cache duration in seconds (default: 3600)
5. Click **Save**

## Using the Widget in Templates

### Method 1: Using Smarty Widget Syntax

Add the widget to any Smarty template using:

```smarty
[{widget name="gutschify_widget"}]
```

### Method 2: Using oxWidget Controller

You can also instantiate the widget controller directly:

```smarty
[{oxwidget cl="GutschifyWidgetController" nocookie=1}]
```

### Example: Adding to Homepage

To add the widget to your homepage, edit your theme's `index.tpl`:

```smarty
<div class="gutschify-container">
    [{widget name="gutschify_widget"}]
</div>
```

### Example: Adding to Category Page

To add the widget to category pages, edit `category.tpl`:

```smarty
[{block name="category_main"}]
    <!-- Your existing category content -->
    
    [{widget name="gutschify_widget"}]
[{/block}]
```

### Example: Adding to Article Page

To add the widget to product/article pages, edit `details.tpl`:

```smarty
[{block name="details_main"}]
    <!-- Your existing product details -->
    
    [{widget name="gutschify_widget"}]
[{/block}]
```

## Widget Template

The widget uses the template at:
`gutschify/views/widget/gutschify_widget.tpl`

This template displays:
- The fetched HTML content from Gutschify
- Error messages if content cannot be loaded
- A wrapper div with class `gutschify-widget` for styling

## Styling

You can style the widget using CSS:

```css
.gutschify-widget {
    margin: 20px 0;
    padding: 20px;
}

.gutschify-widget-error {
    color: #ff0000;
    padding: 10px;
    background: #ffeeee;
}
```

## Troubleshooting

### Widget Not Displaying

1. **Check Configuration**: Make sure the module is activated and configured correctly
2. **Check Base URL**: Verify the Gutschify base URL is correct and accessible
3. **Check Organization ID**: Ensure the organization ID is valid
4. **Check Cache**: Clear OXID cache if content is not updating
5. **Check Logs**: Look for errors in `log/oxideshop.log`

### Content Not Loading

1. **Network Issues**: Check if the Gutschify service is accessible
2. **CORS Issues**: Ensure CORS is configured on the Gutschify service
3. **SSL Issues**: Check SSL certificate if using HTTPS
4. **Timeout**: Increase timeout in `GutschifyService.php` if needed

## Advanced Usage

### Loading Different Collections

You can create multiple widget instances with different collections by:

1. Creating a custom widget controller that extends `GutschifyWidgetController`
2. Overriding the collection slug in the controller
3. Using the custom controller in your templates

### Caching

The widget supports caching to improve performance:
- Enable caching in module settings
- Set cache TTL (time-to-live) in seconds
- Cache is stored in OXID's compile directory
- Cache is automatically cleared when module settings change

## Support

For issues or questions:
- Email: support@gutschify.xxiii.tools
- URL: https://gutschify.xxiii.tools

