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
                        <option value="deldate" [{if $edit->getValue('sNotSetDateType') == 'deldate'}]selected[{/if}]>[{oxmultilang ident="D3_ORDERMANAGER_REQU_NOTSETDATE_DELDATE"}]</option>
                        <option value="paiddate" [{if $edit->getValue('sNotSetDateType') == 'paiddate'}]selected[{/if}]>[{oxmultilang ident="D3_ORDERMANAGER_REQU_NOTSETDATE_PAIDDATE"}]</option>
                    </SELECT>
                [{/block}]
            [{else}]
                [{block name="ordermanager_admin_requ_datenotset_viewer"}]
                    [{if $edit->getValue('sNotSetDateType') == 'deldate'}]
                        [{oxmultilang ident="D3_ORDERMANAGER_REQU_NOTSETDATE_DELDATE"}]
                    [{elseif $edit->getValue('sNotSetDateType') == 'paiddate'}]
                        [{oxmultilang ident="D3_ORDERMANAGER_REQU_NOTSETDATE_PAIDDATE"}]
                    [{/if}]
                [{/block}]
            [{/if}]
            [{oxinputhelp ident="D3_ORDERMANAGER_REQU_NOTSETDATE_DESC"}]
        </dd>
        <div class="spacer"></div>
    </dl>
[{/block}]