[{block name="ordermanager_admin_action_setsendednowdate"}]
    <dl class="[{$blActionRestriction}]">
        [{include file="@d3ordermanager/admin/inc/d3ordermanager_activeswitch.tpl" oActionRequ=$oAction blActionRestriction=$blActionRestriction readonly=$readonly}]
        <dd>
            [{if $oView->isEditMode()}]
                [{block name="ordermanager_admin_action_setsendednowdate_editor"}]
                [{/block}]
            [{else}]
                [{block name="ordermanager_admin_action_setsendednowdate_viewer"}]
                [{/block}]
            [{/if}]
            [{oxinputhelp ident="D3_ORDERMANAGER_ACTION_ORDERSETSENDEDNOW_DESC"}]
        </dd>
        <div class="spacer"></div>
    </dl>
[{/block}]