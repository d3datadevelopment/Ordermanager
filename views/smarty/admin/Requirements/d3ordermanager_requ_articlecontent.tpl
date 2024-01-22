[{block name="ordermanager_admin_requ_articlecontent"}]
    <dl class="[{$blActionRestriction}]">
        <dt>
            <input type="hidden" name="value[blCheckOrderArticle[{$oRequ->getSlotId()}]_status]" value="0">
            [{assign var="sStatusVarName" value="blCheckOrderArticle"|cat:$oRequ->getSlotId()|cat:"_status"}]
            <input id="RequArticleContent[{$oRequ->getSlotId()}]" class="edittext ext_edittext" type="checkbox" name="value[blCheckOrderArticle[{$oRequ->getSlotId()}]_status]" value='1' [{if $edit->getValue($sStatusVarName) == 1}]checked[{/if}] [{$blActionRestriction}] [{$readonly}]>
            <label for="RequArticleContent[{$oRequ->getSlotId()}]">[{oxmultilang ident="D3_ORDERMANAGER_REQU_ARTICLECONTENT"}] ([{$oRequ->getSlotId()}])</label>
        </dt>
        <dd>
            [{assign var="sRegExpVarName" value="sArticleContent"|cat:$oRequ->getSlotId()|cat:"RegExp"}]
            [{assign var="sTypeVarName" value="sArticleContent"|cat:$oRequ->getSlotId()|cat:"Type"}]
            [{if $oView->isEditMode()}]
                [{block name="ordermanager_admin_requ_articlecontent_editor"}]
                    <label for="RequArticleContent[{$oRequ->getSlotId()}]Type">[{oxmultilang ident="D3_ORDERMANAGER_REQU_ARTICLECONTENT2"}]</label>
                    <SELECT id="RequArticleContent[{$oRequ->getSlotId()}]Type" class="editinput" name="value[sArticleContent[{$oRequ->getSlotId()}]Type]" size="1" [{$blActionRestriction}] [{$readonly}]>
                        [{foreach from=$oRequ->getTypeList() key="type" item="translation"}]
                            <option value="[{$type}]" [{if $edit->getValue($sTypeVarName) == $type}]selected[{/if}]>[{oxmultilang ident=$translation}]</option>
                        [{/foreach}]
                    </SELECT>:

                    <label for="sArticleContentRegExp" style="position: absolute; left: -2000px">[{oxmultilang ident="D3_ORDERMANAGER_REQU_ARTICLECONTENT"}]</label>
                    <input id="sArticleContentRegExp" class="editinput" type="text" size="30" maxlength="100" name="value[sArticleContent[{$oRequ->getSlotId()}]RegExp]" value="[{$edit->getValue($sRegExpVarName)}]" [{$blActionRestriction}] [{$readonly}]>
                [{/block}]
            [{else}]
                [{block name="ordermanager_admin_requ_articlecontent_viewer"}]
                    <label for="RequArticleContent[{$oRequ->getSlotId()}]Type">[{oxmultilang ident="D3_ORDERMANAGER_REQU_ARTICLECONTENT2"}]</label>
                    [{foreach from=$oRequ->getTypeList() key="type" item="translation"}]
                        [{if $edit->getValue($sTypeVarName) == $type}]
                            [{oxmultilang ident=$translation}]
                        [{/if}]
                    [{/foreach}]
                    : [{$edit->getValue($sRegExpVarName)}]
                [{/block}]
            [{/if}]
            [{oxinputhelp ident="D3_ORDERMANAGER_REQU_ARTICLECONTENT2_DESC"}]
        </dd>
        <div class="spacer"></div>
    </dl>
[{/block}]
