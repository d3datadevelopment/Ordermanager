[{block name="ordermanager_admin_action_setpaiddate"}]
    <dl class="[{$blActionRestriction}]">
        <dt>
            <input type="hidden" name="value[blActionOrderSetPaidNow_status]" value="0">
            <input id="ActionOrderSetPaidNow" class="edittext ext_edittext" type="checkbox" name="value[blActionOrderSetPaidNow_status]" value='1' [{if $edit->getValue('blActionOrderSetPaidNow_status') == 1}]checked[{/if}] [{$blActionRestriction}] [{$readonly}]>
            <label for="ActionOrderSetPaidNow">[{oxmultilang ident="D3_ORDERMANAGER_ACTION_ORDERSETPAIDNOW"}]</label>
        </dt>
        <dd>
            [{if $oView->isEditMode()}]
                [{block name="ordermanager_admin_action_setpaiddate_editor"}]
                [{/block}]
            [{else}]
                [{block name="ordermanager_admin_action_setpaiddate_viewer"}]
                [{/block}]
            [{/if}]
            [{oxinputhelp ident="D3_ORDERMANAGER_ACTION_ORDERSETPAIDNOW_DESC"}]
        </dd>
        <div class="spacer"></div>
    </dl>
[{/block}]