[{block name="ordermanager_admin_action_moveordertofolder"}]
    <dl class="[{$blActionRestriction}]">
        <dt>
            <input type="hidden" name="value[blActionOrder2Folder_status]" value="0">
            <input id="ActionMove2Folder" class="edittext ext_edittext" type="checkbox" name="value[blActionOrder2Folder_status]" value='1' [{if $edit->getValue('blActionOrder2Folder_status') == 1}]checked[{/if}] [{$blActionRestriction}] [{$readonly}]>
            <label for="ActionMove2Folder">[{oxmultilang ident="D3_ORDERMANAGER_ACTION_ORDERMOVE2FOLDER"}]</label>
        </dt>
        <dd>
            [{if $oView->isEditMode()}]
                [{block name="ordermanager_admin_action_moveordertofolder_editor"}]
                    <label for="sOrderFolder" style="position: absolute; left: -2000px">[{oxmultilang ident="D3_ORDERMANAGER_ACTION_ORDERMOVE2FOLDER"}]</label>
                    <SELECT id="sOrderFolder" class="editinput" name="value[sOrderFolder]" size="1" [{$blActionRestriction}] [{$readonly}]>
                        [{foreach from=$oView->getOrderFolders() key="field" item="color"}]
                            <option value="[{$field}]" [{if $edit->getValue('sOrderFolder') == $field}]selected[{/if}] style="color: [{$color}];">[{oxmultilang ident=$field noerror=true}]</option>
                        [{/foreach}]
                    </SELECT>
                [{/block}]
            [{else}]
                [{block name="ordermanager_admin_action_moveordertofolder_viewer"}]
                    <ul>
                        [{foreach from=$oView->getOrderFolders() key="field" item="color"}]
                            [{if $edit->getValue('sOrderFolder') == $field}]
                                <li>
                                    [{oxmultilang ident=$field noerror=true}]
                                </li>
                            [{/if}]
                        [{/foreach}]
                    </ul>
                [{/block}]
            [{/if}]
            [{oxinputhelp ident="D3_ORDERMANAGER_ACTION_ORDERMOVE2FOLDER_DESC"}]
        </dd>
        <div class="spacer"></div>
    </dl>
[{/block}]
