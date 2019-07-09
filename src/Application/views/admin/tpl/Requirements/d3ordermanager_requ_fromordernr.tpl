<dl class="[{$blActionRestriction}]">
    <dt>
        <input type="hidden" name="value[blCheckFromOrderNr_status]" value="0">
        <input id="RequFromOrderNr" class="edittext ext_edittext" type="checkbox" name="value[blCheckFromOrderNr_status]" value='1' [{if $edit->getValue('blCheckFromOrderNr_status') == 1}]checked[{/if}] [{$blActionRestriction}] [{$readonly}]>
        <label for="RequFromOrderNr">[{oxmultilang ident="D3_ORDERMANAGER_REQU_FROMORDERNR"}]</label>
    </dt>
    <dd>
        [{if $oView->isEditMode()}]
            <label for="sFromOrderNrValue" style="position: absolute; left: -2000px">[{oxmultilang ident="sFromOrderNrValue"}]</label>
            <input id="sFromOrderNrValue" style="text-align: right;" class="edittext ext_edittext" type="text" size="8" maxlength="10" name="value[sFromOrderNrValue]" value='[{$edit->getValue('sFromOrderNrValue')}]' [{$blActionRestriction}] [{$readonly}]>
        [{else}]
            [{$edit->getValue('sFromOrderNrValue')}]
        [{/if}]
        [{oxinputhelp ident="D3_ORDERMANAGER_REQU_FROMORDERNR_DESC"}]
    </dd>
    <div class="spacer"></div>
</dl>