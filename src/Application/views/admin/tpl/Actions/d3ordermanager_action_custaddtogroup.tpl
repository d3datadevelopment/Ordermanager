<dl class="[{$blActionRestriction}]">
    <dt>
        <input type="hidden" name="value[blActionCust2Group_status]" value="0">
        <input id="ActionCustAdd2Group" class="edittext ext_edittext" type="checkbox" name="value[blActionCust2Group_status]" value='1' [{if $edit->getValue('blActionCust2Group_status') == 1}]checked[{/if}] [{$blActionRestriction}] [{$readonly}]>
        <label for="ActionCustAdd2Group">[{oxmultilang ident="D3_ORDERMANAGER_ACTION_CUSTOMERADD2GROUP"}]</label>
    </dt>
    <dd>
        [{if $oView->isEditMode()}]
            <input type="hidden" name="value[sCustAddGroup]" value="">
            <label for="sCustAddGroup" style="position: absolute; left: -2000px">[{oxmultilang ident="sCustAddGroup"}]</label>
            <SELECT class="editinput" name="value[sCustAddGroup][]" id="sCustAddGroup" size="7" multiple [{$blActionRestriction}] [{$readonly}]>
                [{foreach from=$oView->getGroupsList() item="oGroup"}]
                    <option value="[{$oGroup->getId()}]" [{if is_array($edit->getValue('sCustAddGroup')) && in_array($oGroup->getId(), $edit->getValue('sCustAddGroup'))}]selected[{/if}]>[{$oGroup->getFieldData('oxtitle')}]</option>
                [{/foreach}]
            </SELECT><br>
            [{oxmultilang ident="D3_ORDERMANAGER_REQU_MULTIPLE"}]<br>
            [{if !$blActionRestriction}]
                <input type="button" href="#" onclick="selectAllListElems(document.getElementById('sCustAddGroup')); return false;" value="[{oxmultilang ident="D3_GENERAL_ORDERMANAGER_SELECT_ALL"}]" [{$readonly}]> <input type="button" href="#" onclick="selectNoListElems(document.getElementById('sCustAddGroup')); return false;" value="[{oxmultilang ident="D3_GENERAL_ORDERMANAGER_SELECT_NONE"}]" [{$readonly}]>
            [{/if}]
        [{else}]
            <ul>
                [{foreach from=$oView->getGroupsList() item="oGroup"}]
                    [{if is_array($edit->getValue('sCustAddGroup')) && in_array($oGroup->getId(), $edit->getValue('sCustAddGroup'))}]
                        <li>
                            [{$oGroup->getFieldData('oxtitle')}]
                        </li>
                    [{/if}]
                [{/foreach}]
            </ul>
        [{/if}]
        [{oxinputhelp ident="D3_ORDERMANAGER_ACTION_CUSTOMERADD2GROUP_DESC"}]
    </dd>
    <div class="spacer"></div>
</dl>