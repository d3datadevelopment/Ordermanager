[{block name="ordermanager_admin_requ_trackcodefilter"}]
    <dl class="[{$blActionRestriction}]">
        <dt>
            <input type="hidden" name="value[blCheckTrackcode_status]" value="0">
            <input id="RequTrackcode" class="edittext ext_edittext" type="checkbox" name="value[blCheckTrackcode_status]" value='1' [{if $edit->getValue('blCheckTrackcode_status') == 1}]checked[{/if}] [{$blActionRestriction}] [{$readonly}]>
            <label for="RequTrackcode">[{oxmultilang ident="D3_ORDERMANAGER_REQU_TRACKCODE"}]</label>
        </dt>
        <dd>
            [{if $oView->isEditMode()}]
                [{block name="ordermanager_admin_requ_trackcodefilter_editor"}]
                [{/block}]
            [{else}]
                [{block name="ordermanager_admin_requ_trackcodefilter_viewer"}]
                [{/block}]
            [{/if}]
            [{oxinputhelp ident="D3_ORDERMANAGER_REQU_TRACKCODE_DESC"}]
        </dd>
        <div class="spacer"></div>
    </dl>
[{/block}]