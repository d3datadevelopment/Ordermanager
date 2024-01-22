[{block name="ordermanager_admin_action_custaddtogroup"}]
    <dl class="[{$blActionRestriction}]">
        [{include file="@d3ordermanager/admin/inc/d3ordermanager_activeswitch.tpl" oActionRequ=$oAction blActionRestriction=$blActionRestriction readonly=$readonly}]
        <dd>
            [{if $oView->isEditMode()}]
                [{block name="ordermanager_admin_action_custaddtogroup_editor"}]
                    <input type="hidden" name="value[sCustAddGroup]" value="">
                    <label for="sCustAddGroup" style="position: absolute; left: -2000px">[{oxmultilang ident="D3_ORDERMANAGER_ACTION_CUSTOMERADD2GROUP"}]</label>
                    <SELECT class="editinput" name="value[sCustAddGroup][]" id="sCustAddGroup" size="7" multiple [{$blActionRestriction}] [{$readonly}]>
                        [{foreach from=$oView->getGroupsList() item="oGroup"}]
                            <option value="[{$oGroup->getId()}]" [{if is_array($edit->getValue('sCustAddGroup')) && in_array($oGroup->getId(), $edit->getValue('sCustAddGroup'))}]selected[{/if}]>[{$oGroup->getFieldData('oxtitle')}]</option>
                        [{/foreach}]
                    </SELECT><br>
                    [{oxmultilang ident="D3_ORDERMANAGER_REQU_MULTIPLE"}]<br>
                    [{if !$blActionRestriction}]
                        <input type="button" href="#" onclick="selectAllListElems(document.getElementById('sCustAddGroup')); return false;" value="[{oxmultilang ident="D3_GENERAL_ORDERMANAGER_SELECT_ALL"}]" [{$readonly}]> <input type="button" href="#" onclick="selectNoListElems(document.getElementById('sCustAddGroup')); return false;" value="[{oxmultilang ident="D3_GENERAL_ORDERMANAGER_SELECT_NONE"}]" [{$readonly}]>
                    [{/if}]
                [{/block}]
            [{else}]
                [{block name="ordermanager_admin_action_custaddtogroup_viewer"}]
                    <ul>
                        [{foreach from=$oView->getGroupsList() item="oGroup"}]
                            [{if is_array($edit->getValue('sCustAddGroup')) && in_array($oGroup->getId(), $edit->getValue('sCustAddGroup'))}]
                                <li>
                                    [{$oGroup->getFieldData('oxtitle')}]
                                </li>
                            [{/if}]
                        [{/foreach}]
                    </ul>
                [{/block}]
            [{/if}]
            [{oxinputhelp ident="D3_ORDERMANAGER_ACTION_CUSTOMERADD2GROUP_DESC"}]
        </dd>
        <div class="spacer"></div>
    </dl>
[{/block}]