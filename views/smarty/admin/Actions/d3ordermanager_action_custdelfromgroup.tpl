[{block name="ordermanager_admin_action_custdelfromgroup"}]
    <dl class="[{$blActionRestriction}]">
        [{include file="@d3ordermanager/admin/inc/d3ordermanager_activeswitch.tpl" oActionRequ=$oAction blActionRestriction=$blActionRestriction readonly=$readonly}]
        <dd>
            [{if $oView->isEditMode()}]
                [{block name="ordermanager_admin_action_custdelfromgroup_editor"}]
                    <input type="hidden" name="value[sCustRemoveGroup]" value="">
                    <label for="sCustRemoveGroup" style="position: absolute; left: -2000px">[{oxmultilang ident="D3_ORDERMANAGER_ACTION_CUSTOMERREMOVEFROMGROUP"}]</label>
                    <SELECT class="editinput" name="value[sCustRemoveGroup][]" id="sCustRemoveGroup" size="7" multiple [{$blActionRestriction}] [{$readonly}]>
                        [{foreach from=$oView->getGroupsList() item="oGroup"}]
                            <option value="[{$oGroup->getId()}]" [{if is_array($edit->getValue('sCustRemoveGroup')) && in_array($oGroup->getId(), $edit->getValue('sCustRemoveGroup'))}]selected[{/if}]>[{$oGroup->getFieldData('oxtitle')}]</option>
                        [{/foreach}]
                    </SELECT><br>
                    [{oxmultilang ident="D3_ORDERMANAGER_REQU_MULTIPLE"}]<br>
                    [{if !$blActionRestriction}]
                        <input type="button" href="#" onclick="selectAllListElems(document.getElementById('sCustRemoveGroup')); return false;" value="[{oxmultilang ident="D3_GENERAL_ORDERMANAGER_SELECT_ALL"}]" [{$readonly}]> <input type="button" href="#" onclick="selectNoListElems(document.getElementById('sCustRemoveGroup')); return false;" value="[{oxmultilang ident="D3_GENERAL_ORDERMANAGER_SELECT_NONE"}]" [{$readonly}]>
                    [{/if}]
                [{/block}]
            [{else}]
                [{block name="ordermanager_admin_action_custdelfromgroup_viewer"}]
                    <ul>
                        [{foreach from=$oView->getGroupsList() item="oGroup"}]
                            [{if is_array($edit->getValue('sCustRemoveGroup')) && in_array($oGroup->getId(), $edit->getValue('sCustRemoveGroup'))}]
                                <li>
                                    [{$oGroup->getFieldData('oxtitle')}]
                                </li>
                            [{/if}]
                        [{/foreach}]
                    </ul>
                [{/block}]
            [{/if}]
            [{oxinputhelp ident="D3_ORDERMANAGER_ACTION_CUSTOMERREMOVEFROMGROUP_DESC"}]
        </dd>
        <div class="spacer"></div>
    </dl>
[{/block}]