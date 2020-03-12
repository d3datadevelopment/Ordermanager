[{block name="ordermanager_admin_requ_executemethodfilter"}]
    <dl class="[{$blActionRestriction}]">
        <dt>
            <input type="hidden" name="value[blCheckExecuteMethod_status]" value="0">
            <input id="RequExecuteMethod" class="edittext ext_edittext" type="checkbox" name="value[blCheckExecuteMethod_status]" value='1' [{if $edit->getValue('blCheckExecuteMethod_status') == 1}]checked[{/if}] [{$readonly}] [{$blActionRestriction}] [{$blActionRestriction}]>
            <label for="RequExecuteMethod">[{oxmultilang ident="D3_ORDERMANAGER_REQU_ORDEREXECUTEMETHOD"}]</label>
        </dt>
        <dd>
            [{if $oView->isEditMode()}]
                [{block name="ordermanager_admin_requ_executemethodfilter_editor"}]
                    <label for="RequOrderExecuteMethodName">[{oxmultilang ident="D3_ORDERMANAGER_REQU_ORDEREXECUTEMETHOD_NAME"}]</label> <input id="RequOrderExecuteMethodName" type="text" name="value[sRequirementExecuteMethod_name]" size="30" maxlength="50" value="[{$edit->getValue('sRequirementExecuteMethod_name')}]" [{$blActionRestriction}] [{$readonly}]>
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