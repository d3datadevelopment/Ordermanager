<dl class="[{$blActionRestriction}]">
    <dt>
        <input type="hidden" name="value[blCheckDelivery_status]" value="0">
        <input id="RequDelivery" class="edittext ext_edittext" type="checkbox" name="value[blCheckDelivery_status]" value='1' [{if $edit->getValue('blCheckDelivery_status') == 1}]checked[{/if}] [{$blActionRestriction}] [{$readonly}]>
        <label for="RequDelivery">[{oxmultilang ident="D3_ORDERMANAGER_REQU_DELIVERY"}]</label>
    </dt>
    <dd>
        [{if $oView->isEditMode()}]
            <input type="hidden" name="value[sDeliveryId]" value="">
            <label for="sDeliveryId" style="position: absolute; left: -2000px">[{oxmultilang ident="sDeliveryId"}]</label>
            <SELECT class="editinput" name="value[sDeliveryId][]" id="sDeliveryId" size="5" multiple [{$blActionRestriction}] [{$readonly}]>
                [{foreach from=$oView->getDeliveryList() item="oDelivery"}]
                    <option value="[{$oDelivery->getId()}]" [{if is_array($edit->getValue('sDeliveryId')) && in_array($oDelivery->getId(), $edit->getValue('sDeliveryId'))}]selected[{/if}]>[{$oDelivery->getFieldData('oxtitle')}]</option>
                [{/foreach}]
            </SELECT><br>
            [{oxmultilang ident="D3_ORDERMANAGER_REQU_MULTIPLE"}]<br>
            <input type="button" href="#" onclick="selectAllListElems(document.getElementById('sDeliveryId')); return false;" value="[{oxmultilang ident="D3_GENERAL_ORDERMANAGER_SELECT_ALL"}]" [{$blActionRestriction}] [{$readonly}]> <input type="button" href="#" onclick="selectNoListElems(document.getElementById('sDeliveryId')); return false;" value="[{oxmultilang ident="D3_GENERAL_ORDERMANAGER_SELECT_NONE"}]" [{$blActionRestriction}] [{$readonly}]>
        [{else}]
            <ul>
                [{foreach from=$oView->getDeliveryList() item="oDelivery"}]
                    [{if is_array($edit->getValue('sDeliveryId')) && in_array($oDelivery->getId(), $edit->getValue('sDeliveryId'))}]
                        <li>
                            [{$oDelivery->getFieldData('oxtitle')}]
                        </li>
                    [{/if}]
                [{/foreach}]
            </ul>
        [{/if}]
        [{oxinputhelp ident="D3_ORDERMANAGER_REQU_DELIVERY_DESC"}]
    </dd>
    <div class="spacer"></div>
</dl>