<dl class="[{$blActionRestriction}]">
    <dt>
        <input type="hidden" name="value[blActionOrderChangeDiscount_status]" value="0">
        <input id="ActionOrderChangeDiscount" class="edittext ext_edittext" type="checkbox" name="value[blActionOrderChangeDiscount_status]" value='1' [{if $edit->getValue('blActionOrderChangeDiscount_status') == 1}]checked[{/if}] [{$blActionRestriction}] [{$readonly}]>
        <label for="ActionOrderChangeDiscount">[{oxmultilang ident="D3_ORDERMANAGER_ACTION_ORDERCHANGEDISCOUNT"}]</label>
    </dt>
    <dd>
        [{if $oView->isEditMode()}]
            <input id="ActionOrderChangeDiscountValue" type="text" style="text-align: right;" name="value[sActionChangeDiscountValue]" size="10" maxlength="50" value="[{if $edit->getValue('sActionChangeDiscountValue')}][{$edit->getValue('sActionChangeDiscountValue')}][{else}]0.00[{/if}]" [{$blActionRestriction}] [{$readonly}]> <label for="ActionOrderChangeDiscountValue">[{oxmultilang ident="D3_ORDERMANAGER_ACTION_GENERALORDERCURR"}]</label>
        [{else}]
            [{if $edit->getValue('sActionChangeDiscountValue')}][{$edit->getValue('sActionChangeDiscountValue')}][{else}]0.00[{/if}] [{oxmultilang ident="D3_ORDERMANAGER_ACTION_GENERALORDERCURR"}]
        [{/if}]
        [{oxinputhelp ident="D3_ORDERMANAGER_ACTION_ORDERCHANGEDISCOUNT_DESC"}]
    </dd>
    <div class="spacer"></div>
</dl>