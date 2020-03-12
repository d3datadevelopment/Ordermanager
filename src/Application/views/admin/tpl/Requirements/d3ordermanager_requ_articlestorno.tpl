[{block name="ordermanager_admin_requ_articlestorno"}]
    <dl class="[{$blActionRestriction}]">
        <dt>
            <input type="hidden" name="value[blCheckArticlestorno_status]" value="0">
            <input id="RequArticleStorno" class="edittext ext_edittext" type="checkbox" name="value[blCheckArticlestorno_status]" value='1' [{if $edit->getValue('blCheckArticlestorno_status') == 1}]checked[{/if}] [{$blActionRestriction}] [{$readonly}]>
            <label for="RequArticleStorno">[{oxmultilang ident="D3_ORDERMANAGER_REQU_ARTICLESTORNO"}]</label>
        </dt>
        <dd>
            [{if $oView->isEditMode()}]
                [{block name="ordermanager_admin_requ_articlestorno_editor"}]
                [{/block}]
            [{else}]
                [{block name="ordermanager_admin_requ_articlestorno_viewer"}]
                [{/block}]
            [{/if}]
            [{oxinputhelp ident="D3_ORDERMANAGER_REQU_ARTICLESTORNO_DESC"}]
        </dd>
        <div class="spacer"></div>
    </dl>
[{/block}]