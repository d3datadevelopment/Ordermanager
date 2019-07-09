<dl class="[{$blActionRestriction}]">
    <dt>
        <input type="hidden" name="value[blCheckLanguage_status]" value="0">
        <input id="RequLanguage" class="edittext ext_edittext" type="checkbox" name="value[blCheckLanguage_status]" value='1' [{if $edit->getValue('blCheckLanguage_status') == 1}]checked[{/if}] [{$blActionRestriction}] [{$readonly}]>
        <label for="RequLanguage">[{oxmultilang ident="D3_ORDERMANAGER_REQU_LANGUAGE"}]</label>
    </dt>
    <dd>
        [{if $oView->isEditMode()}]
            <input type="hidden" name="value[sInLanguageId]" value="">
            <label for="sInLanguageId" style="position: absolute; left: -2000px">[{oxmultilang ident="sInLanguageId"}]</label>
            <SELECT class="editinput" name="value[sInLanguageId][]" id="sInLanguageId" multiple [{$blActionRestriction}] [{$readonly}]>
                [{foreach from=$oView->getLanguageList() item="oLang"}]
                    <option value="[{$oLang->id}]" [{if is_array($edit->getValue('sInLanguageId')) && in_array($oLang->id, $edit->getValue('sInLanguageId'))}]selected[{/if}]>[{$oLang->name}]</option>
                [{/foreach}]
            </SELECT><br>
            [{oxmultilang ident="D3_ORDERMANAGER_REQU_MULTIPLE"}]<br>
            <input type="button" href="#" onclick="selectAllListElems(document.getElementById('sInLanguageId')); return false;" value="[{oxmultilang ident="D3_GENERAL_ORDERMANAGER_SELECT_ALL"}]" [{$blActionRestriction}] [{$readonly}]> <input type="button" href="#" onclick="selectNoListElems(document.getElementById('sInLanguageId')); return false;" value="[{oxmultilang ident="D3_GENERAL_ORDERMANAGER_SELECT_NONE"}]" [{$blActionRestriction}] [{$readonly}]>
        [{else}]
            <ul>
                [{foreach from=$oView->getLanguageList() item="oLang"}]
                    [{if is_array($edit->getValue('sInLanguageId')) && in_array($oLang->id, $edit->getValue('sInLanguageId'))}]
                        <li>
                            [{$oLang->name}]
                        </li>
                    [{/if}]
                [{/foreach}]
            </ul>
        [{/if}]
        [{oxinputhelp ident="D3_ORDERMANAGER_REQU_LANGUAGE_DESC"}]
    </dd>
    <div class="spacer"></div>
</dl>