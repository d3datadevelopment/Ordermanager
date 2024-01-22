[{block name="ordermanager_admin_requ_fromordernr"}]
    <dl class="[{$blActionRestriction}]">
        [{include file="@d3ordermanager/admin/inc/d3ordermanager_activeswitch.tpl" oActionRequ=$oRequ blActionRestriction=$blActionRestriction readonly=$readonly}]
        <dd>
            [{if $oView->isEditMode()}]
                [{block name="ordermanager_admin_requ_fromordernr_editor"}]
                    <label for="sFromOrderNrValue" style="position: absolute; left: -2000px">[{oxmultilang ident="D3_ORDERMANAGER_REQU_FROMORDERNR"}]</label>
                    <input id="sFromOrderNrValue" style="text-align: right;" class="edittext ext_edittext" type="text" size="8" maxlength="10" name="value[sFromOrderNrValue]" value='[{$edit->getValue('sFromOrderNrValue')}]' [{$blActionRestriction}] [{$readonly}]>
                [{/block}]
            [{else}]
                [{block name="ordermanager_admin_requ_fromordernr_viewer"}]
                    [{$edit->getValue('sFromOrderNrValue')}]
                [{/block}]
            [{/if}]
            [{oxinputhelp ident="D3_ORDERMANAGER_REQU_FROMORDERNR_DESC"}]
        </dd>
        <div class="spacer"></div>
    </dl>
[{/block}]