[{block name="ordermanager_admin_requ_notingroup"}]
    <dl class="[{$blActionRestriction}]">
        <dt>
            <input type="hidden" name="value[blCheckNotInGroup_status]" value="0">
            <input id="RequNotInGroup" class="edittext ext_edittext" type="checkbox" name="value[blCheckNotInGroup_status]" value='1' [{if $edit->getValue('blCheckNotInGroup_status') == 1}]checked[{/if}] [{$blActionRestriction}] [{$readonly}]>
            <label for="RequNotInGroup">[{oxmultilang ident="D3_ORDERMANAGER_REQU_NOTINGROUP"}]</label>
        </dt>
        <dd>
            [{if $oView->isEditMode()}]
                [{block name="ordermanager_admin_requ_notingroup_editor"}]
                    <input type="hidden" name="value[sCustNotInGroupId]" value="">
                    <label for="sCustNotInGroupId" style="position: absolute; left: -2000px">[{oxmultilang ident="D3_ORDERMANAGER_REQU_NOTINGROUP"}]</label>
                    <SELECT class="editinput" name="value[sCustNotInGroupId][]" id="sCustNotInGroupId" size="5" multiple [{$blActionRestriction}] [{$readonly}]>
                        [{foreach from=$oView->getGroupsList() item="oGroup"}]
                            <option value="[{$oGroup->getId()}]" [{if is_array($edit->getValue('sCustNotInGroupId')) && in_array($oGroup->getId(), $edit->getValue('sCustNotInGroupId'))}]selected[{/if}]>[{$oGroup->getFieldData('oxtitle')}]</option>
                        [{/foreach}]
                    </SELECT><br>
                    [{oxmultilang ident="D3_ORDERMANAGER_REQU_MULTIPLE"}]<br>
                    <input type="button" href="#" onclick="selectAllListElems(document.getElementById('sCustNotInGroupId')); return false;" value="[{oxmultilang ident="D3_GENERAL_ORDERMANAGER_SELECT_ALL"}]" [{$blActionRestriction}] [{$readonly}]> <input type="button" href="#" onclick="selectNoListElems(document.getElementById('sCustNotInGroupId')); return false;" value="[{oxmultilang ident="D3_GENERAL_ORDERMANAGER_SELECT_NONE"}]" [{$blActionRestriction}] [{$readonly}]>
                [{/block}]
            [{else}]
                [{block name="ordermanager_admin_requ_notingroup_viewer"}]
                    <ul>
                        [{foreach from=$oView->getGroupsList() item="oGroup"}]
                            [{if is_array($edit->getValue('sCustNotInGroupId')) && in_array($oGroup->getId(), $edit->getValue('sCustNotInGroupId'))}]
                                <li>
                                    [{$oGroup->getFieldData('oxtitle')}]
                                </li>
                            [{/if}]
                        [{/foreach}]
                    </ul>
                [{/block}]
            [{/if}]
            [{oxinputhelp ident="D3_ORDERMANAGER_REQU_NOTINGROUP_DESC"}]
        </dd>
        <div class="spacer"></div>
    </dl>
[{/block}]