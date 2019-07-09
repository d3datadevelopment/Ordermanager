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
            <label for="RequArticleContent[{$oRequ->getSlotId()}]Type">[{oxmultilang ident="D3_ORDERMANAGER_REQU_ARTICLECONTENT2"}]</label>
            <SELECT id="RequArticleContent[{$oRequ->getSlotId()}]Type" class="editinput" name="value[sArticleContent[{$oRequ->getSlotId()}]Type]" size="1" [{$blActionRestriction}] [{$readonly}]>
                <option value="oxartnum" [{if $edit->getValue($sTypeVarName) == 'oxartnum'}]selected[{/if}]>[{oxmultilang ident="D3_ORDERMANAGER_REQU_ARTCONTENTTYPE_ARTNUM"}]</option>
                <option value="oxtitle" [{if $edit->getValue($sTypeVarName) == 'oxtitle'}]selected[{/if}]>[{oxmultilang ident="D3_ORDERMANAGER_REQU_ARTCONTENTTYPE_TITLE"}]</option>
                <option value="oxshortdesc" [{if $edit->getValue($sTypeVarName) == 'oxshortdesc'}]selected[{/if}]>[{oxmultilang ident="D3_ORDERMANAGER_REQU_ARTCONTENTTYPE_SHORTDESC"}]</option>
                <option value="oxselvariant" [{if $edit->getValue($sTypeVarName) == 'oxselvariant'}]selected[{/if}]>[{oxmultilang ident="D3_ORDERMANAGER_REQU_ARTCONTENTTYPE_SELVARIANT"}]</option>
                <option value="oxpersparam" [{if $edit->getValue($sTypeVarName) == 'oxpersparam'}]selected[{/if}]>[{oxmultilang ident="D3_ORDERMANAGER_REQU_ARTCONTENTTYPE_PERSPARAM"}]</option>
                <option value="oxcatid" [{if $edit->getValue($sTypeVarName) == 'oxcatid'}]selected[{/if}]>[{oxmultilang ident="D3_ORDERMANAGER_REQU_ARTCONTENTTYPE_CATID"}]</option>
            </SELECT>:

            <label for="sArticleContentRegExp" style="position: absolute; left: -2000px">[{oxmultilang ident="sArticleContentRegExp"}]</label>
            <input id="sArticleContentRegExp" class="editinput" type="text" size="30" maxlength="100" name="value[sArticleContent[{$oRequ->getSlotId()}]RegExp]" value="[{$edit->getValue($sRegExpVarName)}]" [{$blActionRestriction}] [{$readonly}]>
        [{else}]
            <label for="RequArticleContent[{$oRequ->getSlotId()}]Type">[{oxmultilang ident="D3_ORDERMANAGER_REQU_ARTICLECONTENT2"}]</label>
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
        [{/if}]
        [{oxinputhelp ident="D3_ORDERMANAGER_REQU_ARTICLECONTENT2_DESC"}]
    </dd>
    <div class="spacer"></div>
</dl>