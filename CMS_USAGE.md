# Using Gutschify Widget in CMS Pages

## Yes, you can use it via CMS! 🎉

OXID CMS pages support Smarty syntax, so you can add the widget directly in the CMS content editor.

## How to Add Widget to a CMS Page

### Step 1: Go to CMS Pages

1. Log in to OXID Admin Panel
2. Navigate to **Content → CMS Pages**
3. Either:
   - **Edit an existing page**, or
   - **Create a new page**

### Step 2: Add Widget Code

In the CMS content editor, add this code:

```smarty
[{oxid_include_widget cl="GutschifyWidgetController"}]
```

### Step 3: Save and View

1. Click **Save**
2. Visit the page in the frontend
3. The widget should appear!

## Example CMS Content

You can combine the widget with other content:

```html
<h2>Welcome to Our Shop</h2>
<p>Check out our special offers below:</p>

[{oxid_include_widget cl="GutschifyWidgetController"}]

<p>More content here...</p>
```

## Important Notes

### Smarty Processing Must Be Enabled

By default, OXID processes Smarty code in CMS content. If widgets don't work:

1. Go to **Settings → Shop Settings → Performance Options**
2. Make sure **"Deactivate Smarty for CMS content"** is **NOT** checked
3. If it's checked, uncheck it and save

### Configuration Required

Before the widget works, make sure:
- Module is **activated** (Extensions → Modules)
- **Organization ID** is configured in module settings
- **Base URL** is set correctly

## Advantages of Using CMS

✅ **No template editing required** - Non-technical users can add it  
✅ **Easy to update** - Change content without touching code  
✅ **Flexible placement** - Add anywhere in the page content  
✅ **Multiple pages** - Use the same widget on different pages  

## Troubleshooting

**Widget not showing in CMS?**
- Check that Smarty processing is enabled (see above)
- Verify module is activated
- Check that Organization ID is configured
- Clear cache: `rm -rf tmp/*`

**Widget code showing as text?**
- Smarty processing is disabled - enable it in shop settings

