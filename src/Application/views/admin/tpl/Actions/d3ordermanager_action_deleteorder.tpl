[{block name="ordermanager_admin_action_deleteorder"}]
    <dl class="[{$blActionRestriction}]">
        <dt>
            <input type="hidden" name="value[blActionOrderDelete_status]" value="0">
            <input id="ActionOrderDelete" class="edittext ext_edittext" type="checkbox" name="value[blActionOrderDelete_status]" value='1' [{if $edit->getValue('blActionOrderDelete_status') == 1}]checked[{/if}] [{$blActionRestriction}] [{$readonly}]>
            <label for="ActionOrderDelete">[{oxmultilang ident="D3_ORDERMANAGER_ACTION_ORDERDELETE"}]</label>
        </dt>
        <dd>
            [{if $oView->isEditMode()}]
                [{block name="ordermanager_admin_action_deleteorder_editor"}]
                [{/block}]
            [{else}]
                [{block name="ordermanager_admin_action_deleteorder_viewer"}]
                [{/block}]
            [{/if}]
            [{oxinputhelp ident="D3_ORDERMANAGER_ACTION_ORDERDELETE_DESC"}]
        </dd>
        <div class="spacer"></div>
    </dl>
[{/block}]