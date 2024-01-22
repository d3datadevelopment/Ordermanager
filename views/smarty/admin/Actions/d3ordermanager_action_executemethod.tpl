[{block name="ordermanager_admin_action_executemethod"}]
    <dl class="[{$blActionRestriction}]">
        [{include file="@d3ordermanager/admin/inc/d3ordermanager_activeswitch.tpl" oActionRequ=$oAction blActionRestriction=$blActionRestriction readonly=$readonly}]
        <dd>
            [{if $oView->isEditMode()}]
                [{block name="ordermanager_admin_action_executemethod_editor"}]
                    <label for="ActionOrderExecuteMethodName">[{oxmultilang ident="D3_ORDERMANAGER_ACTION_ORDEREXECUTEMETHOD_NAME"}]</label>
                    <input id="ActionOrderExecuteMethodName" type="text" name="value[sActionExecuteMethod_name]" size="30" maxlength="50" value="[{$edit->getValue('sActionExecuteMethod_name')}]" [{$blActionRestriction}] [{$readonly}]>
                [{/block}]
            [{else}]
                [{block name="ordermanager_admin_action_executemethod_viewer"}]
                    [{oxmultilang ident="D3_ORDERMANAGER_ACTION_ORDEREXECUTEMETHOD_NAME"}] [{$edit->getValue('sActionExecuteMethod_name')}]
                [{/block}]
            [{/if}]
            [{oxinputhelp ident="D3_ORDERMANAGER_ACTION_ORDEREXECUTEMETHOD_DESC"}]
        </dd>
        <div class="spacer"></div>
    </dl>
[{/block}]