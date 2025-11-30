# Using Gutschify Widget with Visual CMS

The Gutschify module now includes a Visual CMS widget that allows you to easily add Gutschify content to your CMS pages using the Visual CMS drag-and-drop editor.

## Prerequisites

1. **Visual CMS Module** must be installed and activated
2. **Gutschify Module** must be installed and activated
3. Module settings must be configured (Base URL and Organization ID)

### OXID PE/EE Users: Register Module First

For OXID 6 Professional and Enterprise editions (e.g., v6.5.5), the module must be registered via console before it appears in the admin:

```bash
cd /path/to/oxid
php vendor/bin/oe-console oe:module:install-configuration source/modules/gutschify/ \
  && vendor/bin/oe-console oe:module:apply-configuration \
  && rm -rf source/tmp/*
```

> **Note:** OXID CE (Community Edition) users can skip this step.

## Configuration

Before using the widget, configure the module settings:

1. Go to **Extensions → Modules**
2. Click on **"Gutschify Embedded Home Widget"**
3. Go to the **Settings** tab
4. Configure:
   - **Gutschify Base URL**: `https://gutschify.xxiii.tools` (or your Gutschify instance)
   - **Organization ID**: Your organization UUID
   - **Collection Slug**: Default collection (can be overridden per widget)
   - **Widget Title** (optional): Default title for widgets
   - **Enable Caching**: Enable/disable caching
   - **Cache Time-to-Live**: Cache duration in seconds
5. Click **Save**

## Using the Widget in Visual CMS

### Step 1: Open Visual CMS Editor

1. Navigate to **Content → CMS Pages** in OXID Admin
2. Edit an existing page or create a new one
3. If Visual CMS is enabled, you'll see the Visual CMS editor interface

### Step 2: Add the Widget

1. In the Visual CMS editor, click the **"+"** button or drag a widget area
2. Look for **"Gutschify Widget"** in the widget list
3. Click on it to add it to your page

### Step 3: Configure Widget Options

When you add the widget, you can configure:

- **Collection Slug**: Override the default collection for this specific widget instance
  - Leave empty to use the module default
  - Example: `default`, `summer-sale`, `winter-promo`
  
- **Widget Title** (optional): Custom title to display above the widget
  - Leave empty to use the module default or no title
  - Example: "Special Offers", "Win Prizes!"

### Step 4: Position and Style

- Drag the widget to position it anywhere on the page
- Use Visual CMS grid system to control column width
- Widget respects Visual CMS styling and grid settings

### Step 5: Save and Preview

1. Click **Save** in the Visual CMS editor
2. View the page in the frontend to see your Gutschify content

## Widget Features

✅ **Drag & Drop**: Easy placement in Visual CMS editor  
✅ **Per-Widget Configuration**: Different collections per widget instance  
✅ **Custom Titles**: Optional title for each widget  
✅ **Grid Integration**: Works with Visual CMS grid system  
✅ **Caching**: Respects module cache settings  
✅ **Error Handling**: Graceful error messages if content can't be loaded  

## Example Use Cases

### Multiple Collections on One Page

You can add multiple Gutschify widgets to the same page, each showing a different collection:

1. Add first widget → Set Collection Slug to `summer-sale`
2. Add second widget → Set Collection Slug to `winter-promo`
3. Position them side by side or stacked

### Homepage with Custom Title

1. Add widget to homepage
2. Set Widget Title to "Win Amazing Prizes!"
3. Widget will display with your custom title

## Troubleshooting

**Widget not appearing in Visual CMS widget list?**
- Ensure Visual CMS module is activated
- Ensure Gutschify module is activated
- Clear OXID cache: `rm -rf tmp/*`
- Check that the shortcode file exists at: `modules/gutschify/visualcms/shortcodes/gutschify.php`

**Widget showing error message?**
- Verify module settings (Base URL and Organization ID)
- Check that the Collection Slug exists in your Gutschify account
- Check browser console and OXID logs for errors
- Verify network connectivity to Gutschify service

**Widget not loading content?**
- Check cache settings - try disabling cache temporarily
- Verify Organization ID is correct
- Ensure Collection Slug matches an existing collection
- Check `log/oxideshop.log` for detailed error messages

## Technical Details

### File Structure

The Visual CMS widget is located at:
```
modules/gutschify/visualcms/shortcodes/gutschify.php
```

### Shortcode Class

The widget uses the class `gutschify_shortcode` which extends `VisualEditorShortcode` from the Visual CMS module.

### Translation Strings

Widget labels are translated using language files:
- `Application/translations/de/gutschify_lang.php` (German)
- `Application/translations/en/gutschify_lang.php` (English)

## Comparison: Visual CMS vs Regular Widget

| Feature | Visual CMS Widget | Regular Widget |
|---------|------------------|----------------|
| Editor | Drag & drop visual editor | Code/Smarty syntax |
| Configuration | Per-widget instance | Module-wide settings |
| Ease of Use | Very easy for non-technical users | Requires template editing |
| Flexibility | High - multiple instances per page | Single instance per template |
| Placement | Visual positioning | Template-based |

## Migration from Regular Widget

If you're currently using the regular widget (`[{oxid_include_widget cl="GutschifyWidgetController"}]`), you can:

1. Keep using it - both methods work simultaneously
2. Migrate to Visual CMS widget for easier management
3. Use both - regular widget in templates, Visual CMS widget in CMS pages

