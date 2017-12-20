<dl class="[{$blActionRestriction}]">
    <dt>
        <input type="hidden" name="value[blActionCustFromGroup_status]" value="0">
        <input id="ActionCustRemoveFromGroup" class="edittext ext_edittext" type="checkbox" name="value[blActionCustFromGroup_status]" value='1' [{if $edit->getValue('blActionCustFromGroup_status') == 1}]checked[{/if}] [{$blActionRestriction}] [{$readonly}]>
        <label for="ActionCustRemoveFromGroup">[{oxmultilang ident="D3_ORDERMANAGER_ACTION_CUSTOMERREMOVEFROMGROUP"}]</label>
    </dt>
    <dd>
        [{if $oView->isEditMode()}]
            <input type="hidden" name="value[sCustRemoveGroup]" value="">
            <SELECT class="editinput" name="value[sCustRemoveGroup][]" id="sCustRemoveGroup" size="7" multiple [{$blActionRestriction}] [{$readonly}]>
                [{foreach from=$oView->getGroupsList() item="oGroup"}]
                    <option value="[{$oGroup->getId()}]" [{if is_array($edit->getValue('sCustRemoveGroup')) && in_array($oGroup->getId(), $edit->getValue('sCustRemoveGroup'))}]selected[{/if}]>[{$oGroup->getFieldData('oxtitle')}]</option>
                [{/foreach}]
            </SELECT><br>
            [{oxmultilang ident="D3_ORDERMANAGER_REQU_MULTIPLE"}]<br>
            [{if !$blActionRestriction}]
                <input type="button" onclick="selectAllListElems(document.getElementById('sCustRemoveGroup')); return false;" value="[{oxmultilang ident="D3_GENERAL_ORDERMANAGER_SELECT_ALL"}]" [{$readonly}]> <input type="button" href="#" onclick="selectNoListElems(document.getElementById('sCustRemoveGroup')); return false;" value="[{oxmultilang ident="D3_GENERAL_ORDERMANAGER_SELECT_NONE"}]" [{$readonly}]>
            [{/if}]
        [{else}]
            <ul>
                [{foreach from=$oView->getGroupsList() item="oGroup"}]
                    [{if is_array($edit->getValue('sCustRemoveGroup')) && in_array($oGroup->getId(), $edit->getValue('sCustRemoveGroup'))}]
                        <li>
                            [{$oGroup->getFieldData('oxtitle')}]
                        </li>
                    [{/if}]
                [{/foreach}]
            </ul>
        [{/if}]
        [{oxinputhelp ident="D3_ORDERMANAGER_ACTION_CUSTOMERREMOVEFROMGROUP_DESC"}]
    </dd>
    <div class="spacer"></div>
</dl>