<dl class="[{$blActionRestriction}]">
    <dt>
        <input type="hidden" name="value[blActionOrderAddFieldValue_status]" value="0">
        <input id="ActionOrderSetField" class="edittext ext_edittext" type="checkbox" name="value[blActionOrderAddFieldValue_status]" value='1' [{if $edit->getValue('blActionOrderAddFieldValue_status') == 1}]checked[{/if}] [{$blActionRestriction}] [{$readonly}]>
        <label for="ActionOrderSetField">[{oxmultilang ident="D3_ORDERMANAGER_ACTION_ORDERADDFIELDVALUE"}]</label>
    </dt>
    <dd>
        [{if $oView->isEditMode()}]
            <label for="ActionOrderSetFieldField">[{oxmultilang ident="D3_ORDERMANAGER_ACTION_ORDERADDFIELDVALUE_FIELD"}]</label> <input id="ActionOrderSetFieldField" type="text" name="value[sActionAddField_field]" size="30" maxlength="50" value="[{$edit->getValue('sActionAddField_field')}]" [{$blActionRestriction}] [{$readonly}]>
            [{oxinputhelp ident="D3_ORDERMANAGER_ACTION_ORDERADDFIELDVALUE_FIELD_DESC"}]<br>
            <label for="ActionOrderSetFieldValue">[{oxmultilang ident="D3_ORDERMANAGER_ACTION_ORDERADDFIELDVALUE_VALUE"}]</label> <input id="ActionOrderSetFieldValue" type="text" name="value[sActionAddField_value]" size="30" maxlength="50" value="[{$edit->getValue('sActionAddField_value')}]" [{$blActionRestriction}] [{$readonly}]>
            [{oxinputhelp ident="D3_ORDERMANAGER_ACTION_ORDERADDFIELDVALUE_DESC"}]<br>
        [{else}]
            [{oxmultilang ident="D3_ORDERMANAGER_ACTION_ORDERADDFIELDVALUE_FIELD"}] [{$edit->getValue('sActionAddField_field')}]<br>
            [{oxmultilang ident="D3_ORDERMANAGER_ACTION_ORDERADDFIELDVALUE_VALUE"}] [{$edit->getValue('sActionAddField_value')}]<br>
        [{/if}]
    </dd>
    <div class="spacer"></div>
</dl>