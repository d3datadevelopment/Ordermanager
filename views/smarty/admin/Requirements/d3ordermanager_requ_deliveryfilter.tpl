[{block name="ordermanager_admin_requ_deliveryfilter"}]
    <dl class="[{$blActionRestriction}]">
        [{include file="@d3ordermanager/admin/inc/d3ordermanager_activeswitch.tpl" oActionRequ=$oRequ blActionRestriction=$blActionRestriction readonly=$readonly}]
        <dd>
            [{if $oView->isEditMode()}]
                [{block name="ordermanager_admin_requ_deliveryfilter_editor"}]
                    <input type="hidden" name="value[sDeliveryId]" value="">
                    <label for="sDeliveryId" style="position: absolute; left: -2000px">[{oxmultilang ident="D3_ORDERMANAGER_REQU_DELIVERY"}]</label>
                    <SELECT class="editinput" name="value[sDeliveryId][]" id="sDeliveryId" size="5" multiple [{$blActionRestriction}] [{$readonly}]>
                        [{foreach from=$oView->getDeliverySetList() item="oDeliverySet"}]
                            <option value="[{$oDeliverySet->getId()}]" [{if is_array($edit->getValue('sDeliveryId')) && in_array($oDeliverySet->getId(), $edit->getValue('sDeliveryId'))}]selected[{/if}]>[{$oDeliverySet->getFieldData('oxtitle')}]</option>
                        [{/foreach}]
                    </SELECT><br>
                    [{oxmultilang ident="D3_ORDERMANAGER_REQU_MULTIPLE"}]<br>
                    <input type="button" href="#" onclick="selectAllListElems(document.getElementById('sDeliveryId')); return false;" value="[{oxmultilang ident="D3_GENERAL_ORDERMANAGER_SELECT_ALL"}]" [{$blActionRestriction}] [{$readonly}]> <input type="button" href="#" onclick="selectNoListElems(document.getElementById('sDeliveryId')); return false;" value="[{oxmultilang ident="D3_GENERAL_ORDERMANAGER_SELECT_NONE"}]" [{$blActionRestriction}] [{$readonly}]>
                [{/block}]
            [{else}]
                [{block name="ordermanager_admin_requ_deliveryfilter_viewer"}]
                    <ul>
                        [{foreach from=$oView->getDeliverySetList() item="oDeliverySet"}]
                            [{if is_array($edit->getValue('sDeliveryId')) && in_array($oDeliverySet->getId(), $edit->getValue('sDeliveryId'))}]
                                <li>
                                    [{$oDeliverySet->getFieldData('oxtitle')}]
                                </li>
                            [{/if}]
                        [{/foreach}]
                    </ul>
                [{/block}]
            [{/if}]
            [{oxinputhelp ident="D3_ORDERMANAGER_REQU_DELIVERY_DESC"}]
        </dd>
        <div class="spacer"></div>
    </dl>
[{/block}]