<dl class="[{$blActionRestriction}]">
    <dt>
        <input type="hidden" name="value[blCheckCurrency_status]" value="0">
        <input id="RequCurrency" class="edittext ext_edittext" type="checkbox" name="value[blCheckCurrency_status]" value='1' [{if $edit->getValue('blCheckCurrency_status') == 1}]checked[{/if}] [{$blActionRestriction}] [{$readonly}]>
        <label for="RequCurrency">[{oxmultilang ident="D3_ORDERMANAGER_REQU_CURRENCY"}]</label>
    </dt>
    <dd>
        [{if $oView->isEditMode()}]
            <input class="editinput" type="text" size="4" maxlength="5" name="value[sCurrencyISOValue]" value="[{$edit->getValue('sCurrencyISOValue')}]" [{$blActionRestriction}] [{$readonly}]>
        [{else}]
            [{$edit->getValue('sCurrencyISOValue')}]
        [{/if}]
        [{oxinputhelp ident="D3_ORDERMANAGER_REQU_CURRENCY_DESC"}]
    </dd>
    <div class="spacer"></div>
</dl>