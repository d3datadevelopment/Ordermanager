<dl class="[{$blActionRestriction}]">
    <dt>
        <input type="hidden" name="value[blCheckNotInFolder_status]" value="0">
        <input id="RequNotInFolder" class="edittext ext_edittext" type="checkbox" name="value[blCheckNotInFolder_status]" value='1' [{if $edit->getValue('blCheckNotInFolder_status') == 1}]checked[{/if}] [{$blActionRestriction}] [{$readonly}]>
        <label for="RequNotInFolder">[{oxmultilang ident="D3_ORDERMANAGER_REQU_NOTINFOLDER"}]</label>
    </dt>
    <dd>
        [{if $oView->isEditMode()}]
            <input type="hidden" name="value[sNotInFolderId]" value="">
            <SELECT class="editinput" name="value[sNotInFolderId][]" id="sNotInFolderId" multiple [{$blActionRestriction}] [{$readonly}]>
                [{foreach from=$oView->getItemFolders() key="field" item="color"}]
                    <option value="[{$field}]" [{if is_array($edit->getValue('sNotInFolderId')) && in_array($field, $edit->getValue('sNotInFolderId'))}]selected[{/if}] style="color: [{$color}];">[{oxmultilang ident=$field noerror=true}]</option>
                [{/foreach}]
            </SELECT><br>
            [{oxmultilang ident="D3_ORDERMANAGER_REQU_MULTIPLE"}]<br>
            <input type="button" href="#" onclick="selectAllListElems(document.getElementById('sNotInFolderId')); return false;" value="[{oxmultilang ident="D3_GENERAL_ORDERMANAGER_SELECT_ALL"}]" [{$blActionRestriction}] [{$readonly}]> <input type="button" href="#" onclick="selectNoListElems(document.getElementById('sNotInFolderId')); return false;" value="[{oxmultilang ident="D3_GENERAL_ORDERMANAGER_SELECT_NONE"}]" [{$blActionRestriction}] [{$readonly}]>
        [{else}]
            <ul>
                [{foreach from=$oView->getItemFolders() key="field" item="color"}]
                    [{if is_array($edit->getValue('sNotInFolderId')) && in_array($field, $edit->getValue('sNotInFolderId'))}]
                        <li>
                            [{oxmultilang ident=$field noerror=true}]
                        </li>
                    [{/if}]
                [{/foreach}]
            </ul>
        [{/if}]
        [{oxinputhelp ident="D3_ORDERMANAGER_REQU_NOTINFOLDER_DESC"}]
    </dd>
    <div class="spacer"></div>
</dl>