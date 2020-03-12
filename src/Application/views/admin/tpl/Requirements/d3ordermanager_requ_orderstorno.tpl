[{block name="ordermanager_admin_requ_orderstorno"}]
    <dl class="[{$blActionRestriction}]">
        <dt>
            <input type="hidden" name="value[blCheckOrderstorno_status]" value="0">
            <input id="RequOrderStorno" class="edittext ext_edittext" type="checkbox" name="value[blCheckOrderstorno_status]" value='1' [{if $edit->getValue('blCheckOrderstorno_status') == 1}]checked[{/if}] [{$blActionRestriction}] [{$readonly}]>
            <label for="RequOrderStorno">[{oxmultilang ident="D3_ORDERMANAGER_REQU_ORDERSTORNO"}]</label>
        </dt>
        <dd>
            [{if $oView->isEditMode()}]
                [{block name="ordermanager_admin_requ_orderstorno_editor"}]
                [{/block}]
            [{else}]
                [{block name="ordermanager_admin_requ_orderstorno_viewer"}]
                [{/block}]
            [{/if}]
            [{oxinputhelp ident="D3_ORDERMANAGER_REQU_ORDERSTORNO_DESC"}]
        </dd>
        <div class="spacer"></div>
    </dl>
[{/block}]