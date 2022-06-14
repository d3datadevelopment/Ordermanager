[{block name="ordermanager_admin_action_moveordertofolder"}]
    <dl class="[{$blActionRestriction}]">
        [{include file="d3ordermanager_activeswitch.tpl" oActionRequ=$oAction blActionRestriction=$blActionRestriction readonly=$readonly}]
        <dd>
            [{if $oView->isEditMode()}]
                [{block name="ordermanager_admin_action_moveordertofolder_editor"}]
                    <label for="sOrderFolder" style="position: absolute; left: -2000px">[{oxmultilang ident="D3_ORDERMANAGER_ACTION_ORDERMOVE2FOLDER"}]</label>
                    <SELECT id="sOrderFolder" class="editinput" name="value[sOrderFolder]" size="1" [{$blActionRestriction}] [{$readonly}]>
                        [{foreach from=$oView->getItemFolders() key="field" item="color"}]
                            <option value="[{$field}]" [{if $edit->getValue('sOrderFolder') == $field}]selected[{/if}] style="color: [{$color}];">[{oxmultilang ident=$field noerror=true}]</option>
                        [{/foreach}]
                    </SELECT>
                [{/block}]
            [{else}]
                [{block name="ordermanager_admin_action_moveordertofolder_viewer"}]
                    <ul>
                        [{foreach from=$oView->getItemFolders() key="field" item="color"}]
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