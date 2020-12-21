[{block name="ordermanager_admin_requ_mailregexpfilter"}]
    <dl class="[{$blActionRestriction}]">
        [{include file="d3ordermanager_activeswitch.tpl" oActionRequ=$oRequ blActionRestriction=$blActionRestriction readonly=$readonly}]
        <dd>
            [{if $oView->isEditMode()}]
                [{block name="ordermanager_admin_requ_mailregexpfilter_editor"}]
                    <label for="sMailValue" style="position: absolute; left: -2000px">[{oxmultilang ident="D3_ORDERMANAGER_REQU_MAILREGEXP"}]</label>
                    <input id="sMailValue" class="edittext ext_edittext" type="text" size="50" maxlength="100" name="value[sMailValue]" value='[{if $edit->getValue('sMailValue')}][{$edit->getValue('sMailValue')}][{/if}]' [{$blActionRestriction}] [{$readonly}]>
                [{/block}]
            [{else}]
                [{block name="ordermanager_admin_requ_mailregexpfilter_viewer"}]
                    [{$edit->getValue('sMailValue')}]
                [{/block}]
            [{/if}]
            [{oxinputhelp ident="D3_ORDERMANAGER_REQU_MAILREGEXP_DESC"}]
        </dd>
        <div class="spacer"></div>
    </dl>
[{/block}]