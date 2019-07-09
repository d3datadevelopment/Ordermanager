<dl class="[{$blActionRestriction}]">
    <dt>
        <input type="hidden" name="value[blCheckInFolder_status]" value="0">
        <input id="RequInFolder" class="edittext ext_edittext" type="checkbox" name="value[blCheckInFolder_status]" value='1' [{if $edit->getValue('blCheckInFolder_status') == 1}]checked[{/if}] [{$blActionRestriction}] [{$readonly}]>
        <label for="RequInFolder">[{oxmultilang ident="D3_ORDERMANAGER_REQU_INFOLDER"}]</label>
    </dt>
    <dd>
        [{if $oView->isEditMode()}]
            <input type="hidden" name="value[sInFolderId]" value="">
            <label for="sInFolderId" style="position: absolute; left: -2000px">[{oxmultilang ident="sInFolderId"}]</label>
            <SELECT class="editinput" name="value[sInFolderId][]" id="sInFolderId" multiple [{$blActionRestriction}] [{$readonly}]>
                [{foreach from=$oView->getItemFolders() key="field" item="color"}]
                    <option value="[{$field}]" [{if is_array($edit->getValue('sInFolderId')) && in_array($field, $edit->getValue('sInFolderId'))}]selected[{/if}] style="color: [{$color}];">[{oxmultilang ident=$field noerror=true}]</option>
                [{/foreach}]
            </SELECT><br>
            [{oxmultilang ident="D3_ORDERMANAGER_REQU_MULTIPLE"}]<br>
            <input type="button" href="#" onclick="selectAllListElems(document.getElementById('sInFolderId')); return false;" value="[{oxmultilang ident="D3_GENERAL_ORDERMANAGER_SELECT_ALL"}]" [{$blActionRestriction}] [{$readonly}]> <input type="button" href="#" onclick="selectNoListElems(document.getElementById('sInFolderId')); return false;" value="[{oxmultilang ident="D3_GENERAL_ORDERMANAGER_SELECT_NONE"}]" [{$blActionRestriction}] [{$readonly}]>
        [{else}]
            <ul>
                [{foreach from=$oView->getItemFolders() key="field" item="color"}]
                    [{if is_array($edit->getValue('sInFolderId')) && in_array($field, $edit->getValue('sInFolderId'))}]
                        <li>
                            [{oxmultilang ident=$field noerror=true}]
                        </li>
                    [{/if}]
                [{/foreach}]
            </ul>
        [{/if}]
        [{oxinputhelp ident="D3_ORDERMANAGER_REQU_INFOLDER_DESC"}]
    </dd>
    <div class="spacer"></div>
</dl>