# Quick Start: Using the Gutschify Widget

## Step 1: Configure the Module

1. Go to **Extensions → Modules**
2. Click on **"Gutschify Embedded Home Widget"**
3. Go to the **Settings** tab
4. Fill in:
   - **Gutschify Base URL**: `https://gutschify.xxiii.tools`
   - **Organization ID**: `2239249b-7fc8-450e-952d-f4eb11b755c2` (your UUID)
   - **Collection Slug**: `default` (or your collection name)
5. Click **Save**

## Step 2: Add Widget to a Template

Add this line to any Smarty template where you want the widget to appear:

```smarty
[{oxid_include_widget cl="GutschifyWidgetController"}]
```

### Examples

**Homepage (`start.tpl`):**
```smarty
[{block name="content_main"}]
    <div class="gutschify-container">
        [{oxid_include_widget cl="GutschifyWidgetController"}]
    </div>
[{/block}]
```

**Category Page (`category.tpl`):**
```smarty
[{block name="category_main"}]
    <!-- Your category content -->
    
    [{oxid_include_widget cl="GutschifyWidgetController"}]
[{/block}]
```

**Product Details Page (`details.tpl`):**
```smarty
[{block name="details_main"}]
    <!-- Your product details -->
    
    [{oxid_include_widget cl="GutschifyWidgetController"}]
[{/block}]
```

**CMS Page:**
If you're editing a CMS page in the admin, you can add the widget code directly in the content editor.

## Step 3: Clear Cache

After adding the widget to a template:
1. Clear OXID cache: `rm -rf tmp/*` (or use admin cache clear)
2. Refresh your frontend page

## That's It! 🎉

The widget will now display your Gutschify embedded home content with:
- Promotional tiles
- Wheel of fortune
- All configured collections

## Troubleshooting

**Widget not showing?**
- Make sure the module is **activated**
- Check that **Organization ID** is configured
- Clear cache: `rm -rf tmp/*`
- Check browser console for errors

**Content not loading?**
- Verify the **Base URL** is correct
- Check that the **Organization ID** is valid
- Ensure the **Collection Slug** exists
- Check `log/oxideshop.log` for errors

