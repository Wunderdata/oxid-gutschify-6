[{* Gutschify Widget Template for OXID 6.x *}]
[{if !$gutschify_module_inactive}]
    [{if $gutschify_widget_title}]
        <h3 class="gutschify-widget-title">[{$gutschify_widget_title}]</h3>
    [{/if}]

    [{if $gutschify_error}]
        <div class="gutschify-widget-error" style="padding: 20px; background: #fee; border: 1px solid #fcc; color: #c00;">
            <p><strong>Error:</strong> [{$gutschify_error}]</p>
        </div>
    [{elseif $gutschify_content}]
        <div class="gutschify-widget">
            [{$gutschify_content}]
        </div>
    [{else}]
        <div class="gutschify-widget-error" style="padding: 20px; background: #fee; border: 1px solid #fcc; color: #c00;">
            <p>Content could not be loaded.</p>
        </div>
    [{/if}]
[{/if}]

