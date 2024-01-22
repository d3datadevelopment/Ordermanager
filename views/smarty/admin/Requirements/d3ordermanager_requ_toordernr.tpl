[{block name="ordermanager_admin_requ_toordernr"}]
    <dl class="[{$blActionRestriction}]">
        [{include file="@d3ordermanager/admin/inc/d3ordermanager_activeswitch.tpl" oActionRequ=$oRequ blActionRestriction=$blActionRestriction readonly=$readonly}]
        <dd>
            [{if $oView->isEditMode()}]
                [{block name="ordermanager_admin_requ_toordernr_editor"}]
                    <label for="sToOrderNrValue" style="position: absolute; left: -2000px">[{oxmultilang ident="D3_ORDERMANAGER_REQU_TOORDERNR"}]</label>
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