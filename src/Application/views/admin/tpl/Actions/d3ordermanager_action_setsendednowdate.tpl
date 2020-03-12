[{block name="ordermanager_admin_action_setsendednowdate"}]
    <dl class="[{$blActionRestriction}]">
        <dt>
            <input type="hidden" name="value[blActionOrderSetSendedNow_status]" value="0">
            <input id="ActionOrderSetSendedNow" class="edittext ext_edittext" type="checkbox" name="value[blActionOrderSetSendedNow_status]" value='1' [{if $edit->getValue('blActionOrderSetSendedNow_status') == 1}]checked[{/if}] [{$blActionRestriction}] [{$readonly}]>
            <label for="ActionOrderSetSendedNow">[{oxmultilang ident="D3_ORDERMANAGER_ACTION_ORDERSETSENDEDNOW"}]</label>
        </dt>
        <dd>
            [{if $oView->isEditMode()}]
                [{block name="ordermanager_admin_action_setsendednowdate_editor"}]
                [{/block}]
            [{else}]
                [{block name="ordermanager_admin_action_setsendednowdate_viewer"}]
                [{/block}]
            [{/if}]
            [{oxinputhelp ident="D3_ORDERMANAGER_ACTION_ORDERSETSENDEDNOW_DESC"}]
        </dd>
        <div class="spacer"></div>
    </dl>
[{/block}]