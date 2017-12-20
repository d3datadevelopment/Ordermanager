<dl class="[{$blActionRestriction}]">
    <dt>
        <input type="hidden" name="value[blActionOrderStorno_status]" value="0">
        <input id="ActionOrderStorno" class="edittext ext_edittext" type="checkbox" name="value[blActionOrderStorno_status]" value='1' [{if $edit->getValue('blActionOrderStorno_status') == 1}]checked[{/if}] [{$blActionRestriction}] [{$readonly}]>
        <label for="ActionOrderStorno">[{oxmultilang ident="D3_ORDERMANAGER_ACTION_ORDERSTORNO"}]</label>
    </dt>
    <dd>
        [{if $oView->isEditMode()}]
        [{else}]
        [{/if}]
        [{oxinputhelp ident="D3_ORDERMANAGER_ACTION_ORDERSTORNO_DESC"}]
    </dd>
    <div class="spacer"></div>
</dl>