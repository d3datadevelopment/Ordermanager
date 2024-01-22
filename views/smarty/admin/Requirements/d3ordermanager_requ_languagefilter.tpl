[{block name="ordermanager_admin_requ_languagefilter"}]
    <dl class="[{$blActionRestriction}]">
        [{include file="@d3ordermanager/admin/inc/d3ordermanager_activeswitch.tpl" oActionRequ=$oRequ blActionRestriction=$blActionRestriction readonly=$readonly}]
        <dd>
            [{if $oView->isEditMode()}]
                [{block name="ordermanager_admin_requ_languagefilter_editor"}]
                    <input type="hidden" name="value[sInLanguageId]" value="">
                    <label for="sInLanguageId" style="position: absolute; left: -2000px">[{oxmultilang ident="D3_ORDERMANAGER_REQU_LANGUAGE"}]</label>
                    <SELECT class="editinput" name="value[sInLanguageId][]" id="sInLanguageId" multiple [{$blActionRestriction}] [{$readonly}]>
                        [{foreach from=$oView->getLanguageList() item="oLang"}]
                            <option value="[{$oLang->id}]" [{if is_array($edit->getValue('sInLanguageId')) && in_array($oLang->id, $edit->getValue('sInLanguageId'))}]selected[{/if}]>[{$oLang->name}]</option>
                        [{/foreach}]
                    </SELECT><br>
                    [{oxmultilang ident="D3_ORDERMANAGER_REQU_MULTIPLE"}]<br>
                    <input type="button" href="#" onclick="selectAllListElems(document.getElementById('sInLanguageId')); return false;" value="[{oxmultilang ident="D3_GENERAL_ORDERMANAGER_SELECT_ALL"}]" [{$blActionRestriction}] [{$readonly}]> <input type="button" href="#" onclick="selectNoListElems(document.getElementById('sInLanguageId')); return false;" value="[{oxmultilang ident="D3_GENERAL_ORDERMANAGER_SELECT_NONE"}]" [{$blActionRestriction}] [{$readonly}]>
                [{/block}]
            [{else}]
                [{block name="ordermanager_admin_requ_languagefilter_viewer"}]
                    <ul>
                        [{foreach from=$oView->getLanguageList() item="oLang"}]
                            [{if is_array($edit->getValue('sInLanguageId')) && in_array($oLang->id, $edit->getValue('sInLanguageId'))}]
                                <li>
                                    [{$oLang->name}]
                                </li>
                            [{/if}]
                        [{/foreach}]
                    </ul>
                [{/block}]
            [{/if}]
            [{oxinputhelp ident="D3_ORDERMANAGER_REQU_LANGUAGE_DESC"}]
        </dd>
        <div class="spacer"></div>
    </dl>
[{/block}]