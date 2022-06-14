[{block name="ordermanager_admin_requ_executemethodfilter"}]
    <dl class="[{$blActionRestriction}]">
        [{include file="d3ordermanager_activeswitch.tpl" oActionRequ=$oRequ blActionRestriction=$blActionRestriction readonly=$readonly}]
        <dd>
            [{if $oView->isEditMode()}]
                [{block name="ordermanager_admin_requ_executemethodfilter_editor"}]
                    <label for="RequOrderExecuteMethodName">[{oxmultilang ident="D3_ORDERMANAGER_REQU_ORDEREXECUTEMETHOD_NAME"}]</label>
                    <input id="RequOrderExecuteMethodName" type="text" name="value[sRequirementExecuteMethod_name]" size="30" maxlength="50" value="[{$edit->getValue('sRequirementExecuteMethod_name')}]" [{$blActionRestriction}] [{$readonly}]>
                [{/block}]
            [{else}]
                [{block name="ordermanager_admin_requ_executemethodfilter_viewer"}]
                    [{oxmultilang ident="D3_ORDERMANAGER_REQU_ORDEREXECUTEMETHOD_NAME"}] [{$edit->getValue('sRequirementExecuteMethod_name')}]
                [{/block}]
            [{/if}]
            [{oxinputhelp ident="D3_ORDERMANAGER_REQU_ORDEREXECUTEMETHOD_DESC"}]
        </dd>
        <dd class="spacer"></dd>
    </dl>
[{/block}]
