[{block name="ordermanager_admin_requ_noarticlecontent"}]
    <dl class="[{$blActionRestriction}]">
        <dt>
            <input type="hidden" name="value[blCheckNoOrderArticle[{$oRequ->getSlotId()}]_status]" value="0">
            [{assign var="sStatusVarName" value="blCheckNoOrderArticle"|cat:$oRequ->getSlotId()|cat:"_status"}]
            <input id="RequNoArticleContent[{$oRequ->getSlotId()}]" class="edittext ext_edittext" type="checkbox" name="value[blCheckNoOrderArticle[{$oRequ->getSlotId()}]_status]" value='1' [{if $edit->getValue($sStatusVarName) == 1}]checked[{/if}] [{$blActionRestriction}] [{$readonly}]>
            <label for="RequNoArticleContent[{$oRequ->getSlotId()}]">[{oxmultilang ident="D3_ORDERMANAGER_REQU_NOARTICLECONTENT"}] ([{$oRequ->getSlotId()}])</label>
        </dt>
        <dd>
            [{assign var="sRegExpVarName" value="sNoArticleContent"|cat:$oRequ->getSlotId()|cat:"RegExp"}]
            [{assign var="sTypeVarName" value="sNoArticleContent"|cat:$oRequ->getSlotId()|cat:"Type"}]
            [{if $oView->isEditMode()}]
                [{block name="ordermanager_admin_requ_noarticlecontent_editor"}]
                    <label for="RequNoArticleContent[{$oRequ->getSlotId()}]Type">[{oxmultilang ident="D3_ORDERMANAGER_REQU_ARTICLECONTENT2"}]</label>
                    <SELECT id="RequNoArticleContent[{$oRequ->getSlotId()}]Type" class="editinput" name="value[sNoArticleContent[{$oRequ->getSlotId()}]Type]" size="1" [{$blActionRestriction}] [{$readonly}]>
                        <option value="oxartnum" [{if $edit->getValue($sTypeVarName) == 'oxartnum'}]selected[{/if}]>[{oxmultilang ident="D3_ORDERMANAGER_REQU_ARTCONTENTTYPE_ARTNUM"}]</option>
                        <option value="oxtitle" [{if $edit->getValue($sTypeVarName) == 'oxtitle'}]selected[{/if}]>[{oxmultilang ident="D3_ORDERMANAGER_REQU_ARTCONTENTTYPE_TITLE"}]</option>
                        <option value="oxshortdesc" [{if $edit->getValue($sTypeVarName) == 'oxshortdesc'}]selected[{/if}]>[{oxmultilang ident="D3_ORDERMANAGER_REQU_ARTCONTENTTYPE_SHORTDESC"}]</option>
                        <option value="oxselvariant" [{if $edit->getValue($sTypeVarName) == 'oxselvariant'}]selected[{/if}]>[{oxmultilang ident="D3_ORDERMANAGER_REQU_ARTCONTENTTYPE_SELVARIANT"}]</option>
                        <option value="oxpersparam" [{if $edit->getValue($sTypeVarName) == 'oxpersparam'}]selected[{/if}]>[{oxmultilang ident="D3_ORDERMANAGER_REQU_ARTCONTENTTYPE_PERSPARAM"}]</option>
                        <option value="oxcatid" [{if $edit->getValue($sTypeVarName) == 'oxcatid'}]selected[{/if}]>[{oxmultilang ident="D3_ORDERMANAGER_REQU_ARTCONTENTTYPE_CATID"}]</option>
                    </SELECT>:

                    <label for="sNoArticleContentRegExp" style="position: absolute; left: -2000px">[{oxmultilang ident="sNoArticleContentRegexp"}]</label>
                    <input id="sNoArticleContentRegExp" class="editinput" type="text" size="30" maxlength="100" name="value[sNoArticleContent[{$oRequ->getSlotId()}]RegExp]" value="[{$edit->getValue($sRegExpVarName)}]" [{$blActionRestriction}] [{$readonly}]>
                [{/block}]
            [{else}]
                [{block name="ordermanager_admin_requ_noarticlecontent_viewer"}]
                    <label for="RequNoArticleContent[{$oRequ->getSlotId()}]Type">[{oxmultilang ident="D3_ORDERMANAGER_REQU_ARTICLECONTENT2"}]</label>
                    [{if $edit->getValue($sTypeVarName) == 'oxartnum'}]
                        [{oxmultilang ident="D3_ORDERMANAGER_REQU_ARTCONTENTTYPE_ARTNUM"}]
                    [{/if}]
                    [{if $edit->getValue($sTypeVarName) == 'oxtitle'}]
                        [{oxmultilang ident="D3_ORDERMANAGER_REQU_ARTCONTENTTYPE_TITLE"}]
                    [{/if}]
                    [{if $edit->getValue($sTypeVarName) == 'oxshortdesc'}]
                        [{oxmultilang ident="D3_ORDERMANAGER_REQU_ARTCONTENTTYPE_SHORTDESC"}]
                    [{/if}]
                    [{if $edit->getValue($sTypeVarName) == 'oxselvariant'}]
                        [{oxmultilang ident="D3_ORDERMANAGER_REQU_ARTCONTENTTYPE_SELVARIANT"}]
                    [{/if}]
                    [{if $edit->getValue($sTypeVarName) == 'oxpersparam'}]
                        [{oxmultilang ident="D3_ORDERMANAGER_REQU_ARTCONTENTTYPE_PERSPARAM"}]
                    [{/if}]
                    [{if $edit->getValue($sTypeVarName) == 'oxcatid'}]
                        [{oxmultilang ident="D3_ORDERMANAGER_REQU_ARTCONTENTTYPE_CATID"}]
                    [{/if}]
                    : [{$edit->getValue($sRegExpVarName)}]
                [{/block}]
            [{/if}]
            [{oxinputhelp ident="D3_ORDERMANAGER_REQU_ARTICLECONTENT2_DESC"}]
        </dd>
        <div class="spacer"></div>
    </dl>
[{/block}]