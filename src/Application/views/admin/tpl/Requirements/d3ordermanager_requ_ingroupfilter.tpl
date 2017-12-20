<dl class="[{$blActionRestriction}]">
    <dt>
        <input type="hidden" name="value[blCheckInGroup_status]" value="0">
        <input id="RequInGroup" class="edittext ext_edittext" type="checkbox" name="value[blCheckInGroup_status]" value='1' [{if $edit->getValue('blCheckInGroup_status') == 1}]checked[{/if}] [{$blActionRestriction}] [{$readonly}]>
        <label for="RequInGroup">[{oxmultilang ident="D3_ORDERMANAGER_REQU_INGROUP"}]</label>
    </dt>
    <dd>
        [{if $oView->isEditMode()}]
            <input type="hidden" name="value[sCustInGroupId]" value="">
            <SELECT class="editinput" name="value[sCustInGroupId][]" id="sCustInGroupId" size="5" multiple [{$blActionRestriction}] [{$readonly}]>
                [{foreach from=$oView->getGroupsList() item="oGroup"}]
                    <option value="[{$oGroup->getId()}]" [{if is_array($edit->getValue('sCustInGroupId')) && in_array($oGroup->getId(), $edit->getValue('sCustInGroupId'))}]selected[{/if}]>[{$oGroup->getFieldData('oxtitle')}]</option>
                [{/foreach}]
            </SELECT><br>
            [{oxmultilang ident="D3_ORDERMANAGER_REQU_MULTIPLE"}]<br>
            <input type="button" href="#" onclick="selectAllListElems(document.getElementById('sCustInGroupId')); return false;" value="[{oxmultilang ident="D3_GENERAL_ORDERMANAGER_SELECT_ALL"}]" [{$blActionRestriction}] [{$readonly}]> <input type="button" href="#" onclick="selectNoListElems(document.getElementById('sCustInGroupId')); return false;" value="[{oxmultilang ident="D3_GENERAL_ORDERMANAGER_SELECT_NONE"}]" [{$blActionRestriction}] [{$readonly}]>
        [{else}]
            <ul>
                [{foreach from=$oView->getGroupsList() item="oGroup"}]
                    [{if is_array($edit->getValue('sCustInGroupId')) && in_array($oGroup->getId(), $edit->getValue('sCustInGroupId'))}]
                        <li>
                            [{$oGroup->getFieldData('oxtitle')}]
                        </li>
                    [{/if}]
                [{/foreach}]
            </ul>
        [{/if}]
        [{oxinputhelp ident="D3_ORDERMANAGER_REQU_INGROUP_DESC"}]
    </dd>
    <div class="spacer"></div>
</dl>