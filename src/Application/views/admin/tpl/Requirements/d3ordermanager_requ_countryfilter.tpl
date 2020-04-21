[{block name="ordermanager_admin_requ_countryfilter"}]
    <dl class="[{$blActionRestriction}]">
        <dt>
            <input type="hidden" name="value[blCheckCountry_status]" value="0">
            <input id="RequCountry" class="edittext ext_edittext" type="checkbox" name="value[blCheckCountry_status]" value='1' [{if $edit->getValue('blCheckCountry_status') == 1}]checked[{/if}] [{$blActionRestriction}] [{$readonly}]>
            <label for="RequCountry">[{oxmultilang ident="D3_ORDERMANAGER_REQU_COUNTRY"}]</label>
        </dt>
        <dd>
            [{if $oView->isEditMode()}]
                [{block name="ordermanager_admin_requ_countryfilter_editor"}]
                    <input type="hidden" name="value[sCustCountryId]" value="">
                    <label for="sCustCountryId" style="position: absolute; left: -2000px">[{oxmultilang ident="D3_ORDERMANAGER_REQU_COUNTRY"}]</label>
                    <SELECT id="sCustCountryId" class="editinput" name="value[sCustCountryId][]" id="sCustCountryId" size="5" multiple [{$blActionRestriction}] [{$readonly}]>
                        [{foreach from=$oView->getCountryList() item="oCountry"}]
                            <option value="[{$oCountry->getId()}]" [{if is_array($edit->getValue('sCustCountryId')) && in_array($oCountry->getId(), $edit->getValue('sCustCountryId'))}]selected[{/if}]>[{$oCountry->getFieldData('oxtitle')}]</option>
                        [{/foreach}]
                    </SELECT><br>
                    [{oxmultilang ident="D3_ORDERMANAGER_REQU_MULTIPLE"}]<br>
                    <input type="button" onclick="selectAllListElems(document.getElementById('sCustCountryId')); return false;" value="[{oxmultilang ident="D3_GENERAL_ORDERMANAGER_SELECT_ALL"}]" [{$blActionRestriction}] [{$readonly}]> <input type="button" onclick="selectNoListElems(document.getElementById('sCustCountryId')); return false;" value="[{oxmultilang ident="D3_GENERAL_ORDERMANAGER_SELECT_NONE"}]" [{$blActionRestriction}] [{$readonly}]>
                [{/block}]
            [{else}]
                [{block name="ordermanager_admin_requ_countryfilter_viewer"}]
                    [{strip}]
                        <ul>
                            [{foreach from=$oView->getCountryList() item="oCountry"}]
                                [{if is_array($edit->getValue('sCustCountryId')) && in_array($oCountry->getId(), $edit->getValue('sCustCountryId'))}]
                                    <li>
                                        [{$oCountry->getFieldData('oxtitle')}]
                                    </li>
                                [{/if}]
                            [{/foreach}]
                        </ul>
                    [{/strip}]
                [{/block}]
            [{/if}]
            [{oxinputhelp ident="D3_ORDERMANAGER_REQU_COUNTRY_DESC"}]
        </dd>
        <div class="spacer"></div>
    </dl>
[{/block}]