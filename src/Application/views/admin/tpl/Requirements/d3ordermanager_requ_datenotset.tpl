[{block name="ordermanager_admin_requ_datenotset"}]
    <dl class="[{$blActionRestriction}]">
        <dt>
            <input type="hidden" name="value[blCheckNotSetDate_status]" value="0">
            <input id="RequNotSetDate" class="edittext ext_edittext" type="checkbox" name="value[blCheckNotSetDate_status]" value='1' [{if $edit->getValue('blCheckNotSetDate_status') == 1}]checked[{/if}] [{$blActionRestriction}] [{$readonly}]>
            <label for="RequNotSetDate">[{oxmultilang ident="D3_ORDERMANAGER_REQU_NOTSETDATE"}]</label>
        </dt>
        <dd>
            [{if $oView->isEditMode()}]
                [{block name="ordermanager_admin_requ_datenotset_editor"}]
                    <label for="RequNotSetDateType" style="position: absolute; left: -2000px">[{oxmultilang ident="D3_ORDERMANAGER_REQU_NOTSETDATE"}]</label>
                    <SELECT id="RequNotSetDateType" class="editinput" name="value[sNotSetDateType]" size="1" [{$blActionRestriction}] [{$readonly}]>
                        [{foreach from=$oRequ->getTypeList() key="type" item="translation"}]
                            <option value="[{$type}]" [{if $edit->getValue('sNotSetDateType') == $type}]selected[{/if}]>[{oxmultilang ident=$translation}]</option>
                        [{/foreach}]
                    </SELECT>
                [{/block}]
            [{else}]
                [{block name="ordermanager_admin_requ_datenotset_viewer"}]
                    [{foreach from=$oRequ->getTypeList() key="type" item="translation"}]
                        [{if $edit->getValue('sNotSetDateType') == $type}]
                            [{oxmultilang ident=$translation}]
                        [{/if}]
                    [{/foreach}]
                [{/block}]
            [{/if}]
            [{oxinputhelp ident="D3_ORDERMANAGER_REQU_NOTSETDATE_DESC"}]
        </dd>
        <div class="spacer"></div>
    </dl>
[{/block}]
