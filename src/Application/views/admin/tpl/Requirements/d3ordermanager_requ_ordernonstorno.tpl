[{block name="ordermanager_admin_requ_ordernonstorno"}]
    <dl class="[{$blActionRestriction}]">
        <dt>
            <input type="hidden" name="value[blCheckOrderNostorno_status]" value="0">
            <input id="RequOrderNoStorno" class="edittext ext_edittext" type="checkbox" name="value[blCheckOrderNostorno_status]" value='1' [{if $edit->getValue('blCheckOrderNostorno_status') == 1}]checked[{/if}] [{$blActionRestriction}] [{$readonly}]>
            <label for="RequOrderNoStorno">[{oxmultilang ident="D3_ORDERMANAGER_REQU_ORDERNOSTORNO"}]</label>
        </dt>
        <dd>
            [{if $oView->isEditMode()}]
                [{block name="ordermanager_admin_requ_ordernonstorno_editor"}]
                [{/block}]
            [{else}]
                [{block name="ordermanager_admin_requ_ordernonstorno_viewer"}]
                [{/block}]
            [{/if}]
            [{oxinputhelp ident="D3_ORDERMANAGER_REQU_ORDERNOSTORNO_DESC"}]
        </dd>
        <div class="spacer"></div>
    </dl>
[{/block}]