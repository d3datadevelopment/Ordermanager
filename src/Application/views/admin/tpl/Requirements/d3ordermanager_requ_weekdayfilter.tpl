[{block name="ordermanager_admin_requ_weekdayfilter"}]
    <dl class="[{$blActionRestriction}]">
        [{include file="d3ordermanager_activeswitch.tpl" oActionRequ=$oRequ blActionRestriction=$blActionRestriction readonly=$readonly}]
        <dd>
            [{if $oView->isEditMode()}]
                [{block name="ordermanager_admin_requ_weekdayfilter_editor"}]
                    <label for="RequWeekdayType">[{oxmultilang ident="D3_ORDERMANAGER_REQU_WEEKDAYS_IF1"}]</label>
                    <SELECT id="RequWeekdayType" class="editinput" name="value[sWeekdaysType]" size="1" [{$blActionRestriction}] [{$readonly}]>
                        [{foreach from=$oRequ->getTypeList() key="type" item="translation"}]
                            <option value="[{$type}]" [{if $edit->getValue('sWeekdaysType') == $type}]selected[{/if}]>[{oxmultilang ident=$translation}]</option>
                        [{/foreach}]
                    </SELECT>
                    <label for="RequWeekdays">[{oxmultilang ident="D3_ORDERMANAGER_REQU_WEEKDAYS_IF2"}]</label>
                    <input type="hidden" name="value[sWeekdayDays]" value="">
                    <SELECT id="RequWeekdays" class="editinput" name="value[sWeekdayDays][]" id="sWeekDays" size="7" multiple [{$blActionRestriction}] [{$readonly}]>
                        [{foreach from=$oRequ->getWeekdayList() item="translIdent" key="weekdayAbbr"}]
                            <option value="[{$weekdayAbbr}]" [{if is_array($edit->getValue('sWeekdayDays')) && in_array($weekdayAbbr, $edit->getValue('sWeekdayDays'))}]selected[{/if}]>[{oxmultilang ident=$translIdent}]</option>
                        [{/foreach}]
                    </SELECT>
                    [{oxmultilang ident="D3_ORDERMANAGER_REQU_WEEKDAYS_IF3"}]<br>
                    [{oxmultilang ident="D3_ORDERMANAGER_REQU_MULTIPLE"}]<br>
                    <input type="button" href="#" onclick="selectAllListElems(document.getElementById('RequWeekdays')); return false;" value="[{oxmultilang ident="D3_GENERAL_ORDERMANAGER_SELECT_ALL"}]" [{$blActionRestriction}] [{$readonly}]> <input type="button" href="#" onclick="selectNoListElems(document.getElementById('RequWeekdays')); return false;" value="[{oxmultilang ident="D3_GENERAL_ORDERMANAGER_SELECT_NONE"}]" [{$blActionRestriction}] [{$readonly}]>
                [{/block}]
            [{else}]
                [{block name="ordermanager_admin_requ_weekdayfilter_viewer"}]
                    <label for="RequWeekdayType">[{oxmultilang ident="D3_ORDERMANAGER_REQU_WEEKDAYS_IF1"}]</label>
                    [{foreach from=$oRequ->getTypeList() key="type" item="translation"}]
                        [{if $edit->getValue('sWeekdaysType') == $type}]
                            [{oxmultilang ident=$translation}]
                        [{/if}]
                    [{/foreach}]
                    <label for="RequWeekdays">[{oxmultilang ident="D3_ORDERMANAGER_REQU_WEEKDAYS_IF2"}]</label>
                    <ul>
                        [{foreach from=$oRequ->getWeekdayList() item="translIdent" key="weekdayAbbr"}]
                            [{if is_array($edit->getValue('sWeekdayDays')) && in_array($weekdayAbbr, $edit->getValue('sWeekdayDays'))}]
                                <li>[{oxmultilang ident=$translIdent}]</li>
                            [{/if}]
                        [{/foreach}]
                    </ul>
                    [{oxmultilang ident="D3_ORDERMANAGER_REQU_WEEKDAYS_IF3"}]
                [{/block}]
            [{/if}]
            [{oxinputhelp ident="D3_ORDERMANAGER_REQU_WEEKDAYS_DESC"}]
        </dd>
        <div class="spacer"></div>
    </dl>
[{/block}]
