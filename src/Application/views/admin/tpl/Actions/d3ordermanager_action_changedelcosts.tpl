[{block name="ordermanager_admin_action_changedelcost"}]
    <dl class="[{$blActionRestriction}]">
        [{include file="d3ordermanager_activeswitch.tpl" oActionRequ=$oAction blActionRestriction=$blActionRestriction readonly=$readonly}]
        <dd>
            [{if $oView->isEditMode()}]
                [{block name="ordermanager_admin_action_changedelcost_editor"}]
                    <input id="ActionOrderChangeDelCostsValue" type="text" style="text-align: right;" name="value[sActionChangeDelCostValue]" size="10" maxlength="50" value="[{if $edit->getValue('sActionChangeDelCostValue')}][{$edit->getValue('sActionChangeDelCostValue')}][{else}]0.00[{/if}]" [{$blActionRestriction}] [{$readonly}]> <label for="ActionOrderChangeDelCostsValue">[{oxmultilang ident="D3_ORDERMANAGER_ACTION_GENERALORDERCURR"}]</label>
                [{/block}]
            [{else}]
                [{block name="ordermanager_admin_action_changedelcost_viewer"}]
                    [{if $edit->getValue('sActionChangeDelCostValue')}][{$edit->getValue('sActionChangeDelCostValue')}][{else}]0.00[{/if}] [{oxmultilang ident="D3_ORDERMANAGER_ACTION_GENERALORDERCURR"}]
                [{/block}]
            [{/if}]
            [{oxinputhelp ident="D3_ORDERMANAGER_ACTION_ORDERCHANGEDELCOSTS_DESC"}]
        </dd>
        <div class="spacer"></div>
    </dl>
[{/block}]