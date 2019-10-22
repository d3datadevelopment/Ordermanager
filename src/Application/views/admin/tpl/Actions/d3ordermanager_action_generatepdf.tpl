[{if !$oView->canGeneratePdf()}]
    [{assign var="blNoPdf" value="disabled"}]
[{else}]
    [{assign var="blNoPdf" value=""}]
[{/if}]

[{block name="ordermanager_admin_action_generatepdf"}]
    <dl class="[{$blActionRestriction}]">
        <dt>
            <input type="hidden" name="value[blActionOrderGeneratePdf_status]" value="0">
            <input id="ActionOrderGeneratePdf" class="edittext ext_edittext" type="checkbox" name="value[blActionOrderGeneratePdf_status]" value='1' [{if $edit->getValue('blActionOrderGeneratePdf_status') == 1}]checked[{/if}] [{$blActionRestriction}] [{$blNoPdf}] [{$readonly}]>
            <label for="ActionOrderGeneratePdf">[{oxmultilang ident="D3_ORDERMANAGER_ACTION_ORDERGENERATEPDF"}][{if !$oView->canGeneratePdf()}] <b>[{oxmultilang ident="D3_ORDERMANAGER_ACTION_ORDERGENERATEPDF_NOPDF"}]</b>[{/if}]</label>
        </dt>
        <dd>
            [{if $oView->isEditMode()}]
                [{block name="ordermanager_admin_action_generatepdf_editor"}]
                    [{block name="ordermanager_admin_action_generatepdf_editor_type"}]
                        <input type="hidden" name="value[blActionOrderPdfTypeInvoice]" value="0">
                        <input id="blActionOrderPdfTypeInvoice" class="edittext ext_edittext" type="checkbox" name="value[blActionOrderPdfTypeInvoice]" value='1' [{if $edit->getValue('blActionOrderPdfTypeInvoice') == 1}]checked[{/if}] [{$blActionRestriction}] [{$blNoPdf}] [{$readonly}]>
                        <label for="blActionOrderPdfTypeInvoice">[{oxmultilang ident="D3_ORDERMANAGER_ACTION_ORDERGENERATEPDFINVOICE"}]</label><br>
                        <input type="hidden" name="value[blActionOrderPdfTypeDelnote]" value="0">
                        <input id="blActionOrderPdfTypeDelnote" class="edittext ext_edittext" type="checkbox" name="value[blActionOrderPdfTypeDelnote]" value='1' [{if $edit->getValue('blActionOrderPdfTypeDelnote') == 1}]checked[{/if}] [{$blActionRestriction}] [{$blNoPdf}] [{$readonly}]>
                        <label for="blActionOrderPdfTypeDelnote">[{oxmultilang ident="D3_ORDERMANAGER_ACTION_ORDERGENERATEPDFDELNOTE"}]</label>
                    [{/block}]
                    <hr>
                    [{block name="ordermanager_admin_action_generatepdf_editor_send"}]
                        <input type="hidden" name="value[blActionOrderPdfSendAttach]" value="0">
                        <input id="blActionOrderPdfSendAttach" class="edittext ext_edittext" type="checkbox" name="value[blActionOrderPdfSendAttach]" value='1' [{if $edit->getValue('blActionOrderPdfSendAttach') == 1}]checked[{/if}] [{$blActionRestriction}] [{$blNoPdf}] [{$readonly}]>
                        <label for="blActionOrderPdfSendAttach">[{oxmultilang ident="D3_ORDERMANAGER_ACTION_ORDERGENERATEPDFATTACH"}]</label> [{oxinputhelp ident="D3_ORDERMANAGER_ACTION_ORDERGENERATEPDFATTACH_DESC"}]<br>
                        <input type="hidden" name="value[blActionOrderPdfSendSave]" value="0">
                        <input id="blActionOrderPdfSendSave" class="edittext ext_edittext" type="checkbox" name="value[blActionOrderPdfSendSave]" value='1' [{if $edit->getValue('blActionOrderPdfSendSave') == 1}]checked[{/if}] [{$blActionRestriction}] [{$blNoPdf}] [{$readonly}]>
                        <label for="blActionOrderPdfSendSave">[{oxmultilang ident="D3_ORDERMANAGER_ACTION_ORDERGENERATEPDFFILESAVE"}]</label> [{$edit->getShopDir()}]<label for="sActionOrderPdfSaveDir" style="position: absolute; left: -2000px">[{oxmultilang ident="sActionOrderPdfSaveDir"}]</label>
                        <input id="sActionOrderPdfSaveDir" type="text" size="30" maxlength="50" name="value[sActionOrderPdfSaveDir]" value="[{$edit->getValue('sActionOrderPdfSaveDir')}]" [{$blActionRestriction}] [{$blNoPdf}] [{$readonly}]>
                    [{/block}]
                [{/block}]
            [{else}]
                [{block name="ordermanager_admin_action_generatepdf_viewer"}]
                    [{block name="ordermanager_admin_action_generatepdf_viewer_type"}]
                        [{if $edit->getValue('blActionOrderPdfTypeInvoice') == 1}]
                            <input id="blActionOrderPdfTypeInvoice" class="edittext ext_edittext" type="checkbox" name="value[blActionOrderPdfTypeInvoice]" value='1' checked [{$blActionRestriction}] [{$blNoPdf}] [{$readonly}]>
                            <label for="blActionOrderPdfTypeInvoice">[{oxmultilang ident="D3_ORDERMANAGER_ACTION_ORDERGENERATEPDFINVOICE"}]</label><br>
                        [{/if}]
                        [{if $edit->getValue('blActionOrderPdfTypeDelnote') == 1}]
                            <input id="blActionOrderPdfTypeDelnote" class="edittext ext_edittext" type="checkbox" name="value[blActionOrderPdfTypeDelnote]" value='1' checked [{$blActionRestriction}] [{$blNoPdf}] [{$readonly}]>
                            <label for="blActionOrderPdfTypeDelnote">[{oxmultilang ident="D3_ORDERMANAGER_ACTION_ORDERGENERATEPDFDELNOTE"}]</label>
                        [{/if}]
                    [{/block}]
                    <hr>
                    [{block name="ordermanager_admin_action_generatepdf_viewer_send"}]
                        [{if $edit->getValue('blActionOrderPdfSendAttach') == 1}]
                            <input id="blActionOrderPdfSendAttach" class="edittext ext_edittext" type="checkbox" name="value[blActionOrderPdfSendAttach]" value='1' checked [{$blActionRestriction}] [{$blNoPdf}] [{$readonly}]>
                            <label for="blActionOrderPdfSendAttach">[{oxmultilang ident="D3_ORDERMANAGER_ACTION_ORDERGENERATEPDFATTACH"}]</label> [{oxinputhelp ident="D3_ORDERMANAGER_ACTION_ORDERGENERATEPDFATTACH_DESC"}]<br>
                        [{/if}]
                        [{if $edit->getValue('blActionOrderPdfSendSave') == 1}]
                            <input id="blActionOrderPdfSendSave" class="edittext ext_edittext" type="checkbox" name="value[blActionOrderPdfSendSave]" value='1' checked [{$blActionRestriction}] [{$blNoPdf}] [{$readonly}]>
                            <label for="blActionOrderPdfSendSave">[{oxmultilang ident="D3_ORDERMANAGER_ACTION_ORDERGENERATEPDFFILESAVE"}]</label>
                            [{$edit->getShopDir()}][{$edit->getValue('sActionOrderPdfSaveDir')}]
                        [{/if}]
                    [{/block}]
                [{/block}]
            [{/if}]
            [{oxinputhelp ident="D3_ORDERMANAGER_ACTION_ORDERGENERATEPDF_DESC"}]
        </dd>
        <div class="spacer"></div>
    </dl>
[{/block}]