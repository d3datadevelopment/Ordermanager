[{block name="ordermanager_admin_requ_notinfolder"}]
    <dl class="[{$blActionRestriction}]">
        [{include file="@d3ordermanager/admin/inc/d3ordermanager_activeswitch.tpl" oActionRequ=$oRequ blActionRestriction=$blActionRestriction readonly=$readonly}]
        <dd>
            [{if $oView->isEditMode()}]
                [{block name="ordermanager_admin_requ_notinfolder_editor"}]
                    <input type="hidden" name="value[sNotInFolderId]" value="">
                    <label for="sNotInFolderId" style="position: absolute; left: -2000px">[{oxmultilang ident="D3_ORDERMANAGER_REQU_NOTINFOLDER"}]</label>
                    <SELECT class="editinput" name="value[sNotInFolderId][]" id="sNotInFolderId" multiple [{$blActionRestriction}] [{$readonly}]>
                        [{foreach from=$oView->getItemFolders() key="field" item="color"}]
                            <option value="[{$field}]" [{if is_array($edit->getValue('sNotInFolderId')) && in_array($field, $edit->getValue('sNotInFolderId'))}]selected[{/if}] style="color: [{$color}];">[{oxmultilang ident=$field noerror=true}]</option>
                        [{/foreach}]
                    </SELECT><br>
                    [{oxmultilang ident="D3_ORDERMANAGER_REQU_MULTIPLE"}]<br>
                    <input type="button" href="#" onclick="selectAllListElems(document.getElementById('sNotInFolderId')); return false;" value="[{oxmultilang ident="D3_GENERAL_ORDERMANAGER_SELECT_ALL"}]" [{$blActionRestriction}] [{$readonly}]> <input type="button" href="#" onclick="selectNoListElems(document.getElementById('sNotInFolderId')); return false;" value="[{oxmultilang ident="D3_GENERAL_ORDERMANAGER_SELECT_NONE"}]" [{$blActionRestriction}] [{$readonly}]>
                [{/block}]
            [{else}]
                [{block name="ordermanager_admin_requ_notinfolder_viewer"}]
                    <ul>
                        [{foreach from=$oView->getItemFolders() key="field" item="color"}]
                            [{if is_array($edit->getValue('sNotInFolderId')) && in_array($field, $edit->getValue('sNotInFolderId'))}]
                                <li>
                                    [{oxmultilang ident=$field noerror=true}]
                                </li>
                            [{/if}]
                        [{/foreach}]
                    </ul>
                [{/block}]
            [{/if}]
            [{oxinputhelp ident="D3_ORDERMANAGER_REQU_NOTINFOLDER_DESC"}]
        </dd>
        <div class="spacer"></div>
    </dl>
[{/block}]