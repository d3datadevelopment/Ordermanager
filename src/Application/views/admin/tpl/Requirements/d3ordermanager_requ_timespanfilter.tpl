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
                    <label for="RequTimespan[{$oRequ->getSlotId()}]Unit" style="position: absolute; left: -2000px">[{oxmultilang ident="RequTimespanUnit"}]</label>
                    <SELECT id="RequTimespan[{$oRequ->getSlotId()}]Unit" class="editinput" name="value[sTimespan[{$oRequ->getSlotId()}]Unit]" size="1" [{$blActionRestriction}] [{$readonly}]>
                        <option value="minute" [{if $edit->getValue($sUnitVarName) == 'minute'}]selected[{/if}]>[{oxmultilang ident="D3_ORDERMANAGER_REQU_TIMESPAN_MINUTE"}]</option>
                        <option value="hour" [{if $edit->getValue($sUnitVarName) == 'hour'}]selected[{/if}]>[{oxmultilang ident="D3_ORDERMANAGER_REQU_TIMESPAN_HOUR"}]</option>
                        <option value="day" [{if $edit->getValue($sUnitVarName) == 'day'}]selected[{/if}]>[{oxmultilang ident="D3_ORDERMANAGER_REQU_TIMESPAN_DAY"}]</option>
                    </SELECT>
                    <label for="RequTimespan[{$oRequ->getSlotId()}]Type">[{oxmultilang ident="D3_ORDERMANAGER_REQU_TIMESPAN_AFTER"}]</label>
                    <SELECT id="RequTimespan[{$oRequ->getSlotId()}]Type" class="editinput" name="value[sTimespan[{$oRequ->getSlotId()}]Type]" size="1" [{$blActionRestriction}] [{$readonly}]>
                        <option value="orderdate" [{if $edit->getValue($sTypeVarName) == 'orderdate'}]selected[{/if}]>[{oxmultilang ident="D3_ORDERMANAGER_REQU_TIMESPAN_ORDERDATE"}]</option>
                        <option value="deldate" [{if $edit->getValue($sTypeVarName) == 'deldate'}]selected[{/if}]>[{oxmultilang ident="D3_ORDERMANAGER_REQU_TIMESPAN_DELDATE"}]</option>
                        <option value="paiddate" [{if $edit->getValue($sTypeVarName) == 'paiddate'}]selected[{/if}]>[{oxmultilang ident="D3_ORDERMANAGER_REQU_TIMESPAN_PAIDDATE"}]</option>
                    </SELECT>
                [{/block}]
            [{else}]
                [{block name="ordermanager_admin_requ_timespanfilter_viewer"}]
                    <label for="RequTimespan[{$oRequ->getSlotId()}]Min">[{oxmultilang ident="D3_ORDERMANAGER_REQU_TIMESPAN_MINIMUM"}]</label>
                    [{$edit->getValue($sValueVarName)}]
                    [{if $edit->getValue($sUnitVarName) == 'minute'}]
                        [{oxmultilang ident="D3_ORDERMANAGER_REQU_TIMESPAN_MINUTE"}]
                    [{elseif $edit->getValue($sUnitVarName) == 'hour'}]
                        [{oxmultilang ident="D3_ORDERMANAGER_REQU_TIMESPAN_HOUR"}]
                    [{elseif $edit->getValue($sUnitVarName) == 'day'}]
                        [{oxmultilang ident="D3_ORDERMANAGER_REQU_TIMESPAN_DAY"}]
                    [{/if}]
                    <label for="RequTimespan[{$oRequ->getSlotId()}]Type">[{oxmultilang ident="D3_ORDERMANAGER_REQU_TIMESPAN_AFTER"}]</label>
                    [{if $edit->getValue($sTypeVarName) == 'orderdate'}]
                        [{oxmultilang ident="D3_ORDERMANAGER_REQU_TIMESPAN_ORDERDATE"}]
                    [{elseif $edit->getValue($sTypeVarName) == 'deldate'}]
                        [{oxmultilang ident="D3_ORDERMANAGER_REQU_TIMESPAN_DELDATE"}]
                    [{elseif $edit->getValue($sTypeVarName) == 'paiddate'}]
                        [{oxmultilang ident="D3_ORDERMANAGER_REQU_TIMESPAN_PAIDDATE"}]
                    [{/if}]
                [{/block}]
            [{/if}]
            [{oxinputhelp ident="D3_ORDERMANAGER_REQU_TIMESPAN_DESC"}]
        </dd>
        <div class="spacer"></div>
    </dl>
[{/block}]