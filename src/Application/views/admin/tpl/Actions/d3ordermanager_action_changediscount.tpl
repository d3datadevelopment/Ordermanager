[{block name="ordermanager_admin_action_changediscount"}]
    <dl class="[{$blActionRestriction}]">
        [{include file="d3ordermanager_activeswitch.tpl" oActionRequ=$oAction blActionRestriction=$blActionRestriction readonly=$readonly}]
        <dd>
            [{if $oView->isEditMode()}]
                [{block name="ordermanager_admin_action_changediscount_editor"}]
                    <input id="ActionOrderChangeDiscountValue" type="text" style="text-align: right;" name="value[sActionChangeDiscountValue]" size="10" maxlength="50" value="[{if $edit->getValue('sActionChangeDiscountValue')}][{$edit->getValue('sActionChangeDiscountValue')}][{else}]0.00[{/if}]" [{$blActionRestriction}] [{$readonly}]> <label for="ActionOrderChangeDiscountValue">[{oxmultilang ident="D3_ORDERMANAGER_ACTION_GENERALORDERCURR"}]</label>
                [{/block}]
            [{else}]
                [{block name="ordermanager_admin_action_changediscount_viewer"}]
                    [{if $edit->getValue('sActionChangeDiscountValue')}][{$edit->getValue('sActionChangeDiscountValue')}][{else}]0.00[{/if}] [{oxmultilang ident="D3_ORDERMANAGER_ACTION_GENERALORDERCURR"}]
                [{/block}]
            [{/if}]
            [{oxinputhelp ident="D3_ORDERMANAGER_ACTION_ORDERCHANGEDISCOUNT_DESC"}]
        </dd>
        <div class="spacer"></div>
    </dl>
[{/block}]