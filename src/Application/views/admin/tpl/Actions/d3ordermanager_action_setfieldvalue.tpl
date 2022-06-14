[{block name="ordermanager_admin_action_setfieldvalue"}]
    <dl class="[{$blActionRestriction}]">
        [{include file="d3ordermanager_activeswitch.tpl" oActionRequ=$oAction blActionRestriction=$blActionRestriction readonly=$readonly}]
        <dd>
            [{if $oView->isEditMode()}]
                [{block name="ordermanager_admin_action_setfieldvalue_editor"}]
                    <label for="ActionOrderSetFieldField">[{oxmultilang ident="D3_ORDERMANAGER_ACTION_ORDERADDFIELDVALUE_FIELD"}]</label> <input id="ActionOrderSetFieldField" type="text" name="value[sActionAddField_field]" size="30" maxlength="50" value="[{$edit->getValue('sActionAddField_field')}]" [{$blActionRestriction}] [{$readonly}]>
                    [{oxinputhelp ident="D3_ORDERMANAGER_ACTION_ORDERADDFIELDVALUE_FIELD_DESC"}]<br>
                    <label for="ActionOrderSetFieldValue">[{oxmultilang ident="D3_ORDERMANAGER_ACTION_ORDERADDFIELDVALUE_VALUE"}]</label> <input id="ActionOrderSetFieldValue" type="text" name="value[sActionAddField_value]" size="30" maxlength="50" value="[{$edit->getValue('sActionAddField_value')}]" [{$blActionRestriction}] [{$readonly}]>
                    [{oxinputhelp ident="D3_ORDERMANAGER_ACTION_ORDERADDFIELDVALUE_DESC"}]<br>
                [{/block}]
            [{else}]
                [{block name="ordermanager_admin_action_setfieldvalue_viewer"}]
                    [{oxmultilang ident="D3_ORDERMANAGER_ACTION_ORDERADDFIELDVALUE_FIELD"}] [{$edit->getValue('sActionAddField_field')}]<br>
                    [{oxmultilang ident="D3_ORDERMANAGER_ACTION_ORDERADDFIELDVALUE_VALUE"}] [{$edit->getValue('sActionAddField_value')}]<br>
                [{/block}]
            [{/if}]
        </dd>
        <div class="spacer"></div>
    </dl>
[{/block}]