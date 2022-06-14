[{block name="ordermanager_admin_requ_timespanfilter"}]
    <dl class="[{$blActionRestriction}]">
        <dt>
            <input type="hidden" name="value[blCheckTimespan[{$oRequ->getSlotId()}]_status]" value="0">
            [{assign var="sStatusVarName" value="blCheckTimespan"|cat:$oRequ->getSlotId()|cat:"_status"}]
            <input id="RequTimespan[{$oRequ->getSlotId()}]" class="edittext ext_edittext" type="checkbox" name="value[blCheckTimespan[{$oRequ->getSlotId()}]_status]" value='1' [{if $edit->getValue($sStatusVarName) == 1}]checked[{/if}] [{$blActionRestriction}] [{$readonly}]>
            <label for="RequTimespan[{$oRequ->getSlotId()}]">[{oxmultilang ident="D3_ORDERMANAGER_REQU_TIMESPAN"}] ([{$oRequ->getSlotId()}])</label>
        </dt>
        <dd>
            [{assign var="sValueVarName" value="sTimespan"|cat:$oRequ->getSlotId()|cat:"Value"}]
            [{assign var="sUnitVarName" value="sTimespan"|cat:$oRequ->getSlotId()|cat:"Unit"}]
            [{assign var="sTypeVarName" value="sTimespan"|cat:$oRequ->getSlotId()|cat:"Type"}]
            [{if $oView->isEditMode()}]
                [{block name="ordermanager_admin_requ_timespanfilter_editor"}]
                    <label for="RequTimespan[{$oRequ->getSlotId()}]Min">[{oxmultilang ident="D3_ORDERMANAGER_REQU_TIMESPAN_MINIMUM"}]</label>
                    <input id="RequTimespan[{$oRequ->getSlotId()}]Min" style="text-align: right;" class="edittext ext_edittext" type="text" size="4" maxlength="3" name="value[sTimespan[{$oRequ->getSlotId()}]Value]" value='[{$edit->getValue($sValueVarName)}]' [{$blActionRestriction}] [{$readonly}]>
                    <label for="RequTimespan[{$oRequ->getSlotId()}]Unit" style="position: absolute; left: -2000px">[{oxmultilang ident="D3_ORDERMANAGER_REQU_TIMESPAN"}]</label>
                    <SELECT id="RequTimespan[{$oRequ->getSlotId()}]Unit" class="editinput" name="value[sTimespan[{$oRequ->getSlotId()}]Unit]" size="1" [{$blActionRestriction}] [{$readonly}]>
                        [{foreach from=$oRequ->getUnitList() key="type" item="translation"}]
                            <option value="[{$type}]" [{if $edit->getValue($sUnitVarName) == $type}]selected[{/if}]>[{oxmultilang ident=$translation}]</option>
                        [{/foreach}]
                    </SELECT>
                    <label for="RequTimespan[{$oRequ->getSlotId()}]Type">[{oxmultilang ident="D3_ORDERMANAGER_REQU_TIMESPAN_AFTER"}]</label>
                    <SELECT id="RequTimespan[{$oRequ->getSlotId()}]Type" class="editinput" name="value[sTimespan[{$oRequ->getSlotId()}]Type]" size="1" [{$blActionRestriction}] [{$readonly}]>
                        [{foreach from=$oRequ->getTypeList() key="type" item="translation"}]
                            <option value="[{$type}]" [{if $edit->getValue($sUnitVarName) == $type}]selected[{/if}]>[{oxmultilang ident=$translation}]</option>
                        [{/foreach}]
                    </SELECT>
                [{/block}]
            [{else}]
                [{block name="ordermanager_admin_requ_timespanfilter_viewer"}]
                    <label for="RequTimespan[{$oRequ->getSlotId()}]Min">[{oxmultilang ident="D3_ORDERMANAGER_REQU_TIMESPAN_MINIMUM"}]</label>
                    [{$edit->getValue($sValueVarName)}]
                    [{foreach from=$oRequ->getUnitList() key="type" item="translation"}]
                        [{if $edit->getValue($sUnitVarName) == $type}]
                            [{oxmultilang ident=$translation}]
                        [{/if}]
                    [{/foreach}]
                    <label for="RequTimespan[{$oRequ->getSlotId()}]Type">[{oxmultilang ident="D3_ORDERMANAGER_REQU_TIMESPAN_AFTER"}]</label>
                    [{foreach from=$oRequ->getTypeList() key="type" item="translation"}]
                        [{if $edit->getValue($sTypeVarName) == $type}]
                            [{oxmultilang ident=$translation}]
                        [{/if}]
                    [{/foreach}]
                [{/block}]
            [{/if}]
            [{oxinputhelp ident="D3_ORDERMANAGER_REQU_TIMESPAN_DESC"}]
        </dd>
        <div class="spacer"></div>
    </dl>
[{/block}]
