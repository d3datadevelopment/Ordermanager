[{if !$oView->canGeneratePdfDocuments()}]
    [{assign var="blNoPdf" value="disabled"}]
[{else}]
    [{assign var="blNoPdf" value=""}]
[{/if}]

[{block name="ordermanager_admin_action_getpdfdocument"}]
    <dl class="[{$blActionRestriction}]">
        [{include file="d3ordermanager_activeswitch.tpl" oActionRequ=$oAction blActionRestriction=$blActionRestriction readonly=$readonly}]
        <dd>
            [{if $oView->isEditMode()}]
                [{block name="ordermanager_admin_action_getpdfdocument_editor"}]
                    [{block name="ordermanager_admin_action_getpdfdocument_editor_type"}]
                        [{foreach from=$oAction->getDocumentList() item="oDocument"}]
                            [{assign var="documentRequestId" value=$oAction->getDocumentRequestId($oDocument)}]
                            <input type="hidden" name="value[[{$documentRequestId}]]" value="0">
                            <input id="[{$documentRequestId}]" class="edittext ext_edittext" type="checkbox" name="value[[{$documentRequestId}]]" value='1' [{if $edit->getValue($documentRequestId) == 1}]checked[{/if}] [{$blActionRestriction}] [{$blNoPdf}] [{$readonly}]>
                            <label for="[{$documentRequestId}]">[{oxmultilang ident=$oDocument->getTitleIdent()}]</label><br>
                        [{/foreach}]
                    [{/block}]
                    <hr>
                    [{block name="ordermanager_admin_action_getpdfdocument_editor_send"}]
                        <input type="hidden" name="value[blActionOrderPdfDocumentSendAttach]" value="0">
                        <input id="blActionOrderPdfDocumentSendAttach" class="edittext ext_edittext" type="checkbox" name="value[blActionOrderPdfDocumentSendAttach]" value='1' [{if $edit->getValue('blActionOrderPdfDocumentSendAttach') == 1}]checked[{/if}] [{$blActionRestriction}] [{$blNoPdf}] [{$readonly}]>
                        <label for="blActionOrderPdfDocumentSendAttach">[{oxmultilang ident="D3_ORDERMANAGER_ACTION_ORDERGETPDFDOCUMENTATTACH"}]</label> [{oxinputhelp ident="D3_ORDERMANAGER_ACTION_ORDERGETPDFDOCUMENTATTACH_DESC"}]<br>
                        <input type="hidden" name="value[blActionOrderPdfDocumentSendSave]" value="0">
                        <input id="blActionOrderPdfDocumentSendSave" class="edittext ext_edittext" type="checkbox" name="value[blActionOrderPdfDocumentSendSave]" value='1' [{if $edit->getValue('blActionOrderPdfDocumentSendSave') == 1}]checked[{/if}] [{$blActionRestriction}] [{$blNoPdf}] [{$readonly}]>
                        <label for="blActionOrderPdfDocumentSendSave">[{oxmultilang ident="D3_ORDERMANAGER_ACTION_ORDERGETPDFDOCUMENTFILESAVE"}]</label> [{$edit->getShopDir()}]<label for="sActionOrderPdfDocumentSaveDir" style="position: absolute; left: -2000px">[{oxmultilang ident="D3_ORDERMANAGER_ACTION_ORDERGETPDFDOCUMENT"}]</label>
                        <input id="sActionOrderPdfDocumentSaveDir" type="text" size="30" maxlength="50" name="value[sActionOrderPdfDocumentSaveDir]" value="[{$edit->getValue('sActionOrderPdfDocumentSaveDir')}]" [{$blActionRestriction}] [{$blNoPdf}] [{$readonly}]>
                    [{/block}]
                [{/block}]
            [{else}]
                [{block name="ordermanager_admin_action_getpdfdocument_viewer"}]
                    [{block name="ordermanager_admin_action_getpdfdocument_viewer_type"}]
                        [{foreach from=$oAction->getDocumentList() item="oDocument"}]
                            [{assign var="documentRequestId" value=$oAction->getDocumentRequestId($oDocument)}]
                            [{if $edit->getValue($documentRequestId) == 1}]
                                <input id="[{$documentRequestId}]" class="edittext ext_edittext" type="checkbox" name="value[[{$documentRequestId}]]" value='1' checked [{$blActionRestriction}] [{$blNoPdf}] [{$readonly}]>
                                <label for="[{$documentRequestId}]">[{oxmultilang ident=$oDocument->getTitleIdent()}]</label><br>
                            [{/if}]
                        [{/foreach}]
                    [{/block}]
                    <hr>
                    [{block name="ordermanager_admin_action_getpdfdocument_viewer_send"}]
                        [{if $edit->getValue('blActionOrderPdfDocumentSendAttach') == 1}]
                            <input id="blActionOrderPdfDocumentSendAttach" class="edittext ext_edittext" type="checkbox" name="value[blActionOrderPdfDocumentSendAttach]" value='1' checked [{$blActionRestriction}] [{$blNoPdf}] [{$readonly}]>
                            <label for="blActionOrderPdfDocumentSendAttach">[{oxmultilang ident="D3_ORDERMANAGER_ACTION_ORDERGETPDFDOCUMENTATTACH"}]</label> [{oxinputhelp ident="D3_ORDERMANAGER_ACTION_ORDERGETPDFDOCUMENTATTACH_DESC"}]<br>
                        [{/if}]
                        [{if $edit->getValue('blActionOrderPdfDocumentSendSave') == 1}]
                            <input id="blActionOrderPdfDocumentSendSave" class="edittext ext_edittext" type="checkbox" name="value[blActionOrderPdfDocumentSendSave]" value='1' checked [{$blActionRestriction}] [{$blNoPdf}] [{$readonly}]>
                            <label for="blActionOrderPdfDocumentSendSave">[{oxmultilang ident="D3_ORDERMANAGER_ACTION_ORDERGETPDFDOCUMENTFILESAVE"}]</label>
                            [{$edit->getShopDir()}][{$edit->getValue('sActionOrderPdfDocumentSaveDir')}]
                        [{/if}]
                    [{/block}]
                [{/block}]
            [{/if}]
            [{oxinputhelp ident="D3_ORDERMANAGER_ACTION_ORDERGETPDFDOCUMENT_DESC"}]
        </dd>
        <div class="spacer"></div>
    </dl>
[{/block}]