[{block name="ordermanager_admin_requ_currencyfilter"}]
    <dl class="[{$blActionRestriction}]">
        [{include file="d3ordermanager_activeswitch.tpl" oActionRequ=$oRequ blActionRestriction=$blActionRestriction readonly=$readonly}]
        <dd>
            [{if $oView->isEditMode()}]
                [{block name="ordermanager_admin_requ_currencyfilter_editor"}]
                    <label for="sCuurencyISOValue" style="position: absolute; left: -2000px">[{oxmultilang ident="D3_ORDERMANAGER_REQU_CURRENCY"}]</label>
                    <input id="sCuurencyISOValue" class="editinput" type="text" size="4" maxlength="5" name="value[sCurrencyISOValue]" value="[{$edit->getValue('sCurrencyISOValue')}]" [{$blActionRestriction}] [{$readonly}]>
                [{/block}]
            [{else}]
                [{block name="ordermanager_admin_requ_currencyfilter_viewer"}]
                    [{$edit->getValue('sCurrencyISOValue')}]
                [{/block}]
            [{/if}]
            [{oxinputhelp ident="D3_ORDERMANAGER_REQU_CURRENCY_DESC"}]
        </dd>
        <div class="spacer"></div>
    </dl>
[{/block}]