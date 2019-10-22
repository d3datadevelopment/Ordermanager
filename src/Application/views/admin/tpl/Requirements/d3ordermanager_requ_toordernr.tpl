[{block name="ordermanager_admin_requ_toordernr"}]
    <dl class="[{$blActionRestriction}]">
        <dt>
            <input type="hidden" name="value[blCheckToOrderNr_status]" value="0">
            <input id="RequToOrderNr" class="edittext ext_edittext" type="checkbox" name="value[blCheckToOrderNr_status]" value='1' [{if $edit->getValue('blCheckToOrderNr_status') == 1}]checked[{/if}] [{$blActionRestriction}] [{$readonly}]>
            <label for="RequToOrderNr">[{oxmultilang ident="D3_ORDERMANAGER_REQU_TOORDERNR"}]</label>
        </dt>
        <dd>
            [{if $oView->isEditMode()}]
                [{block name="ordermanager_admin_requ_toordernr_editor"}]
                    <label for="sToOrderNrValue" style="position: absolute; left: -2000px">[{oxmultilang ident="sToOrderNrValue"}]</label>
                    <input id="sToOrderNrValue" style="text-align: right;" class="edittext ext_edittext" type="text" size="8" maxlength="10" name="value[sToOrderNrValue]" value='[{$edit->getValue('sToOrderNrValue')}]' [{$blActionRestriction}] [{$readonly}]>
                [{/block}]
            [{else}]
                [{block name="ordermanager_admin_requ_toordernr_viewer"}]
                    [{$edit->getValue('sToOrderNrValue')}]
                [{/block}]
            [{/if}]
            [{oxinputhelp ident="D3_ORDERMANAGER_REQU_TOORDERNR_DESC"}]
        </dd>
        <div class="spacer"></div>
    </dl>
[{/block}]