[{block name="ordermanager_admin_requ_folderfilter"}]
    <dl class="[{$blActionRestriction}]">
        [{include file="d3ordermanager_activeswitch.tpl" oActionRequ=$oRequ blActionRestriction=$blActionRestriction readonly=$readonly}]
        <dd>
            [{if $oView->isEditMode()}]
                [{block name="ordermanager_admin_requ_folderfilter_editor"}]
                    <input type="hidden" name="value[sInFolderId]" value="">
                    <label for="sInFolderId" style="position: absolute; left: -2000px">[{oxmultilang ident="D3_ORDERMANAGER_REQU_INFOLDER"}]</label>
                    <SELECT class="editinput" name="value[sInFolderId][]" id="sInFolderId" multiple [{$blActionRestriction}] [{$readonly}]>
                        [{foreach from=$oView->getItemFolders() key="field" item="color"}]
                            <option value="[{$field}]" [{if is_array($edit->getValue('sInFolderId')) && in_array($field, $edit->getValue('sInFolderId'))}]selected[{/if}] style="color: [{$color}];">[{oxmultilang ident=$field noerror=true}]</option>
                        [{/foreach}]
                    </SELECT><br>
                    [{oxmultilang ident="D3_ORDERMANAGER_REQU_MULTIPLE"}]<br>
                    <input type="button" href="#" onclick="selectAllListElems(document.getElementById('sInFolderId')); return false;" value="[{oxmultilang ident="D3_GENERAL_ORDERMANAGER_SELECT_ALL"}]" [{$blActionRestriction}] [{$readonly}]> <input type="button" href="#" onclick="selectNoListElems(document.getElementById('sInFolderId')); return false;" value="[{oxmultilang ident="D3_GENERAL_ORDERMANAGER_SELECT_NONE"}]" [{$blActionRestriction}] [{$readonly}]>
                [{/block}]
            [{else}]
                [{block name="ordermanager_admin_requ_folderfilter_viewer"}]
                    <ul>
                        [{foreach from=$oView->getItemFolders() key="field" item="color"}]
                            [{if is_array($edit->getValue('sInFolderId')) && in_array($field, $edit->getValue('sInFolderId'))}]
                                <li>
                                    [{oxmultilang ident=$field noerror=true}]
                                </li>
                            [{/if}]
                        [{/foreach}]
                    </ul>
                [{/block}]
            [{/if}]
            [{oxinputhelp ident="D3_ORDERMANAGER_REQU_INFOLDER_DESC"}]
        </dd>
        <div class="spacer"></div>
    </dl>
[{/block}]