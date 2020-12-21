[{block name="ordermanager_admin_requ_weekdayfilter"}]
    <dl class="[{$blActionRestriction}]">
        [{include file="d3ordermanager_activeswitch.tpl" oActionRequ=$oRequ blActionRestriction=$blActionRestriction readonly=$readonly}]
        <dd>
            [{if $oView->isEditMode()}]
                [{block name="ordermanager_admin_requ_weekdayfilter_editor"}]
                    <label for="RequWeekdayType">[{oxmultilang ident="D3_ORDERMANAGER_REQU_WEEKDAYS_IF1"}]</label>
                    <SELECT id="RequWeekdayType" class="editinput" name="value[sWeekdaysType]" size="1" [{$blActionRestriction}] [{$readonly}]>
                        <option value="orderdate" [{if $edit->getValue('sWeekdaysType') == 'orderdate'}]selected[{/if}]>[{oxmultilang ident="D3_ORDERMANAGER_REQU_WEEKDAYS_ORDERDATE"}]</option>
                        <option value="deldate" [{if $edit->getValue('sWeekdaysType') == 'deldate'}]selected[{/if}]>[{oxmultilang ident="D3_ORDERMANAGER_REQU_WEEKDAYS_DELDATE"}]</option>
                        <option value="paiddate" [{if $edit->getValue('sWeekdaysType') == 'paiddate'}]selected[{/if}]>[{oxmultilang ident="D3_ORDERMANAGER_REQU_WEEKDAYS_PAIDDATE"}]</option>
                    </SELECT>
                    <label for="RequWeekdays">[{oxmultilang ident="D3_ORDERMANAGER_REQU_WEEKDAYS_IF2"}]</label>
                    <input type="hidden" name="value[sWeekdayDays]" value="">
                    <SELECT id="RequWeekdays" class="editinput" name="value[sWeekdayDays][]" id="sWeekDays" size="7" multiple [{$blActionRestriction}] [{$readonly}]>
                        <option value="Mon" [{if is_array($edit->getValue('sWeekdayDays')) && in_array('Mon', $edit->getValue('sWeekdayDays'))}]selected[{/if}]>[{oxmultilang ident="D3_ORDERMANAGER_REQU_WEEKDAYS_MONDAY"}]</option>
                        <option value="Tue" [{if is_array($edit->getValue('sWeekdayDays')) && in_array('Tue', $edit->getValue('sWeekdayDays'))}]selected[{/if}]>[{oxmultilang ident="D3_ORDERMANAGER_REQU_WEEKDAYS_TUESDAY"}]</option>
                        <option value="Wed" [{if is_array($edit->getValue('sWeekdayDays')) && in_array('Wed', $edit->getValue('sWeekdayDays'))}]selected[{/if}]>[{oxmultilang ident="D3_ORDERMANAGER_REQU_WEEKDAYS_WEDNESDAY"}]</option>
                        <option value="Thu" [{if is_array($edit->getValue('sWeekdayDays')) && in_array('Thu', $edit->getValue('sWeekdayDays'))}]selected[{/if}]>[{oxmultilang ident="D3_ORDERMANAGER_REQU_WEEKDAYS_THURSDAY"}]</option>
                        <option value="Fri" [{if is_array($edit->getValue('sWeekdayDays')) && in_array('Fri', $edit->getValue('sWeekdayDays'))}]selected[{/if}]>[{oxmultilang ident="D3_ORDERMANAGER_REQU_WEEKDAYS_FRIDAY"}]</option>
                        <option value="Sat" [{if is_array($edit->getValue('sWeekdayDays')) && in_array('Sat', $edit->getValue('sWeekdayDays'))}]selected[{/if}]>[{oxmultilang ident="D3_ORDERMANAGER_REQU_WEEKDAYS_SATURDAY"}]</option>
                        <option value="Sun" [{if is_array($edit->getValue('sWeekdayDays')) && in_array('Sun', $edit->getValue('sWeekdayDays'))}]selected[{/if}]>[{oxmultilang ident="D3_ORDERMANAGER_REQU_WEEKDAYS_SUNDAY"}]</option>
                    </SELECT>
                    [{oxmultilang ident="D3_ORDERMANAGER_REQU_WEEKDAYS_IF3"}]<br>
                    [{oxmultilang ident="D3_ORDERMANAGER_REQU_MULTIPLE"}]<br>
                    <input type="button" href="#" onclick="selectAllListElems(document.getElementById('RequWeekdays')); return false;" value="[{oxmultilang ident="D3_GENERAL_ORDERMANAGER_SELECT_ALL"}]" [{$blActionRestriction}] [{$readonly}]> <input type="button" href="#" onclick="selectNoListElems(document.getElementById('RequWeekdays')); return false;" value="[{oxmultilang ident="D3_GENERAL_ORDERMANAGER_SELECT_NONE"}]" [{$blActionRestriction}] [{$readonly}]>
                [{/block}]
            [{else}]
                [{block name="ordermanager_admin_requ_weekdayfilter_viewer"}]
                    <label for="RequWeekdayType">[{oxmultilang ident="D3_ORDERMANAGER_REQU_WEEKDAYS_IF1"}]</label>
                    [{if $edit->getValue('sWeekdaysType') == 'orderdate'}]
                        [{oxmultilang ident="D3_ORDERMANAGER_REQU_WEEKDAYS_ORDERDATE"}]
                    [{elseif $edit->getValue('sWeekdaysType') == 'deldate'}]
                        [{oxmultilang ident="D3_ORDERMANAGER_REQU_WEEKDAYS_DELDATE"}]
                    [{elseif $edit->getValue('sWeekdaysType') == 'paiddate'}]
                        [{oxmultilang ident="D3_ORDERMANAGER_REQU_WEEKDAYS_PAIDDATE"}]
                    [{/if}]
                    <label for="RequWeekdays">[{oxmultilang ident="D3_ORDERMANAGER_REQU_WEEKDAYS_IF2"}]</label>
                    <ul>
                        [{if is_array($edit->getValue('sWeekdayDays')) && in_array('Mon', $edit->getValue('sWeekdayDays'))}]
                            <li>[{oxmultilang ident="D3_ORDERMANAGER_REQU_WEEKDAYS_MONDAY"}]</li>
                        [{/if}]
                        [{if is_array($edit->getValue('sWeekdayDays')) && in_array('Tue', $edit->getValue('sWeekdayDays'))}]
                            <li>[{oxmultilang ident="D3_ORDERMANAGER_REQU_WEEKDAYS_TUESDAY"}]</li>
                        [{/if}]
                        [{if is_array($edit->getValue('sWeekdayDays')) && in_array('Wed', $edit->getValue('sWeekdayDays'))}]
                            <li>[{oxmultilang ident="D3_ORDERMANAGER_REQU_WEEKDAYS_WEDNESDAY"}]</li>
                        [{/if}]
                        [{if is_array($edit->getValue('sWeekdayDays')) && in_array('Thu', $edit->getValue('sWeekdayDays'))}]
                            <li>[{oxmultilang ident="D3_ORDERMANAGER_REQU_WEEKDAYS_THURSDAY"}]</li>
                        [{/if}]
                        [{if is_array($edit->getValue('sWeekdayDays')) && in_array('Fri', $edit->getValue('sWeekdayDays'))}]
                            <li>[{oxmultilang ident="D3_ORDERMANAGER_REQU_WEEKDAYS_FRIDAY"}]</li>
                        [{/if}]
                        [{if is_array($edit->getValue('sWeekdayDays')) && in_array('Sat', $edit->getValue('sWeekdayDays'))}]
                            <li>[{oxmultilang ident="D3_ORDERMANAGER_REQU_WEEKDAYS_SATURDAY"}]</li>
                        [{/if}]
                        [{if is_array($edit->getValue('sWeekdayDays')) && in_array('Sun', $edit->getValue('sWeekdayDays'))}]
                            <li>[{oxmultilang ident="D3_ORDERMANAGER_REQU_WEEKDAYS_SUNDAY"}]</li>
                        [{/if}]
                    </ul>
                    [{oxmultilang ident="D3_ORDERMANAGER_REQU_WEEKDAYS_IF3"}]
                [{/block}]
            [{/if}]
            [{oxinputhelp ident="D3_ORDERMANAGER_REQU_WEEKDAYS_DESC"}]
        </dd>
        <div class="spacer"></div>
    </dl>
[{/block}]