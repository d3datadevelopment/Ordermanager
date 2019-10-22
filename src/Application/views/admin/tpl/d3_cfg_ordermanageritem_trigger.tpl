[{include file="headitem.tpl" title="GENERAL_ADMIN_TITLE"|oxmultilangassign}]

<script type="text/javascript">
<!--
    [{if $updatelist == 1}]
        UpdateList('[{$oxid}]');
    [{/if}]

    function UpdateList( sID)
    {
        let oSearch = parent.list.document.getElementById("search");
        oSearch.oxid.value=sID;
        oSearch.fnc.value='';
        oSearch.submit();
    }

    function EditThis( sID)
    {
        let oTransfer = document.getElementById("transfer");
        oTransfer.oxid.value=sID;
        oTransfer.cl.value='[{$oViewConf->getActiveClassName()}]';
        oTransfer.submit();

        let oSearch = parent.list.document.getElementById("search");
        oSearch.actedit.value = 0;
        oSearch.oxid.value=sID;
        oSearch.submit();
    }

    function _groupExp(el)
    {
        let _cur = el.parentNode;

        if (_cur.className === "exp") _cur.className = "";
        else _cur.className = "exp";
    }

    function ChangeLstrt()
    {
        let oSearch = document.getElementById("search");
        if (document.search != null && document.search.lstrt != null)
            oSearch.lstrt.value=0;
    }
//-->
</script>

<style type="text/css">
    fieldset{
        border: 1px inset black;
        background-color: #F0F0F0;
    }

    legend{
        font-weight: bold;
    }

    .groupExp dl dt{
        font-weight: normal;
        width: 40%;
        padding-left: 10px;
    }

    .groupExp dl dd {
        margin-left: 42%;
        padding-top: 5px;
    }

    .groupExp.disabled dl dt,
    .groupExp.disabled dl dd,
    .groupExp.disabled dl dd a,
    .groupExp.disabled .exp a.rc b,
    .groupExp.disabled a.rc b,
    .groupExp dl.disabled dt,
    .groupExp dl.disabled dd,
    .groupExp dl.disabled dd a {
        color: darkgrey;
    }

    .groupExp dl.disabled {
        border-top: none;

        background: #ffffe0; /* Old browsers */
        background: -moz-linear-gradient(top, #ffffe0 0%, #f0f0f0 100%); /* FF3.6+ */
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ffffe0), color-stop(100%,#f0f0f0)); /* Chrome,Safari4+ */
        background: -webkit-linear-gradient(top, #ffffe0 0%,#f0f0f0 100%); /* Chrome10+,Safari5.1+ */
        background: -o-linear-gradient(top, #ffffe0 0%,#f0f0f0 100%); /* Opera 11.10+ */
        background: -ms-linear-gradient(top, #ffffe0 0%,#f0f0f0 100%); /* IE10+ */
        background: linear-gradient(to bottom, #ffffe0 0%,#f0f0f0 100%); /* W3C */
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffe0', endColorstr='#f0f0f0',GradientType=0 ); /* IE6-9 */

    }

    .edittext select.editinput {
        width: auto;
    }

    details {
        margin: 0 0 15px;
        padding: 6px 9px 2px 18px;
        border: 1px solid silver;
        color: silver;
    }
    details summary {
        margin: 0 0 3px -12px;
        cursor: pointer;
    }
</style>

[{if $readonly}]
    [{assign var="readonly" value="readonly disabled"}]
[{else}]
    [{assign var="readonly" value=""}]
[{/if}]

<form name="transfer" id="transfer" action="[{$oViewConf->getSelfLink()}]" method="post">
    [{$oViewConf->getHiddenSid()}]
    <input type="hidden" name="oxid" value="[{$oxid}]">
    <input type="hidden" name="oxidCopy" value="[{$oxid}]">
    <input type="hidden" name="cl" value="[{$oViewConf->getActiveClassName()}]">
    <input type="hidden" name="editlanguage" value="[{$editlanguage}]">
</form>

<form name="myedit" id="myedit" action="[{$oViewConf->getSelfLink()}]" method="post" style="padding: 0;margin: 0;height:0;">
    [{$oViewConf->getHiddenSid()}]
    <input type="hidden" name="cl" value="[{$oViewConf->getActiveClassName()}]">
    <input type="hidden" name="fnc" value="">
    <input type="hidden" name="oxid" value="[{$oxid}]">
    <input type="hidden" name="voxid" value="[{$oxid}]">
    <input type="hidden" name="editval[[{$edit->d3GetFieldLongName('oxid')}]]" value="[{$oxid}]">

    <table style="padding: 0; border: none; width:98%;">
        [{if $edit->getId() && !$edit->getLicenseActive()}]
            <tr>
                <td style="vertical-align:top;" colspan="2">
                    <div class="extension_warning">[{oxmultilang ident="D3_ORDERMANAGER_ERROR_IEXECJOBSLIMIT"}]</div>
                </td>
            </tr>
        [{/if}]

        [{if $oView->triggersAreAllowed()}]
            [{assign var="blActionTriggersRestriction" value=""}]
        [{else}]
            [{assign var="blActionTriggersRestriction" value="readonly disabled"}]
            [{assign var="blRestricted" value=true}]
        [{/if}]

        [{if $oView->scriptsAreAllowed()}]
            [{assign var="blActionScriptsRestriction" value=""}]
        [{else}]
            [{assign var="blActionScriptsRestriction" value="readonly disabled"}]
            [{assign var="blRestricted" value=true}]
        [{/if}]

        <tr>
            <td style="vertical-align: top; padding-top:10px;padding-left:10px;">

                <details>
                    <summary>[{oxmultilang ident="D3_GENERAL_ORDERMANAGER_DESCRIPTION"}]</summary>
                    [{oxmultilang ident="d3tbclordermanager_items_trigger_desc"}]
                </details>

                <div class="groupExp">
                    <div class="">
                        <a class="rc" onclick="_groupExp(this); return false;" href="#">
                            <b>
                                [{oxmultilang ident="D3_ORDERMANAGER_MAIN_FIELDSET_CRONJOB"}]
                                [{if $edit->getFieldData('oxactive') == 1}]<i class="fa fa-check-circle d3fa-color-green"></i>[{/if}]
                            </b>
                        </a>

                        <div>
                            <dl>
                                <dt>
                                    <label for="MainActive">[{oxmultilang ident="D3_ORDERMANAGER_MAIN_ACTIVE"}]</label>
                                </dt>
                                <dd>
                                    <input type="hidden" name="editval[[{$edit->d3GetFieldLongName('oxactive')}]]" value='0'>
                                    <input id="MainActive" class="edittext" type="checkbox" name="editval[[{$edit->d3GetFieldLongName('oxactive')}]]" value='1' [{if $edit->getFieldData('oxactive') == 1}]checked[{/if}] [{$readonly}]>
                                    [{oxinputhelp ident="D3_ORDERMANAGER_MAIN_ACTIVE_DESC"}]
                                </dd>
                                <div class="spacer"></div>
                            </dl>
                        </div>

                        [{if $blUseTimeCheck}]
                            <div>
                                <dl>
                                    <dt>
                                        [{oxmultilang ident="D3_ORDERMANAGER_MAIN_ACTIVFROMTILL"}]&nbsp;
                                    </dt>
                                    <dd>
                                        <label for="MainActiveFrom">[{oxmultilang ident="D3_MODPROFILE_MAIN_ACTIVEFROM"}]</label>&nbsp;<input id="MainActiveFrom" type="text" class="editinput" size="27" name="editval[[{$edit->d3GetFieldLongName('oxactivefrom')}]]" value="[{$edit->getFieldData('oxactivefrom')|oxformdate}]" [{include file="help.tpl" helpid=article_vonbis}] [{$readonly}]><br>
                                        <label for="MainActiveTo">[{oxmultilang ident="D3_MODPROFILE_MAIN_ACTIVETO"}]</label>&nbsp;&nbsp;<input id="MainActiveTo" type="text" class="editinput" size="27" name="editval[[{$edit->d3GetFieldLongName('oxactiveto')}]]" value="[{$edit->getFieldData('oxactiveto')|oxformdate}]" [{include file="help.tpl" helpid=article_vonbis}] [{$readonly}]>
                                    </dd>
                                    <div class="spacer"></div>
                                </dl>
                            </div>
                        [{/if}]

                        <div>
                            <dl>
                                <dt>
                                    <label for="MainCJID">[{oxmultilang ident="D3_ORDERMANAGER_MAIN_CRONJOBID"}]</label>&nbsp;
                                </dt>
                                <dd>
                                    <input type="hidden" name="editval[[{$edit->d3GetFieldLongName('D3_CRONJOBID')}]]" value="0">
                                    <input id="MainCJID" type="text" size="5" maxlength="[{$edit->d3modprofile__d3_cronjobid->fldmax_length}]" class="edittext ext_edittext" name="editval[[{$edit->d3GetFieldLongName('D3_CRONJOBID')}]]" value="[{if $edit->getFieldData('D3_CRONJOBID')}][{$edit->getFieldData('D3_CRONJOBID')}][{else}]0[{/if}]" [{$readonly}]>
                                    [{oxinputhelp ident="D3_ORDERMANAGER_SET_CRON_JOB_DESC"}]
                                </dd>
                                <div class="spacer"></div>
                            </dl>
                        </div>

                        <div>
                            <dl class="[{$blActionScriptsRestriction}]">
                                <dt>
                                    <label for="MainCronPreExecScript">[{oxmultilang ident="D3_ORDERMANAGER_MAIN_PREEXECUTESCRIPT"}]</label>&nbsp;
                                </dt>
                                <dd>
                                    <input id="MainCronPreExecScript" type="text" class="edittext ext_edittext" name="value[sCronjobPreExecuteScript]" value="[{$edit->getValue('sCronjobPreExecuteScript')}]" [{$readonly}] [{$blActionScriptsRestriction}]>
                                    [{oxinputhelp ident="D3_ORDERMANAGER_MAIN_PREEXECUTESCRIPT_DESC"}]
                                </dd>
                                <div class="spacer"></div>
                            </dl>
                        </div>

                        <div>
                            <dl class="[{$blActionScriptsRestriction}]">
                                <dt>
                                    <label for="MainCronPostExecScript">[{oxmultilang ident="D3_ORDERMANAGER_MAIN_POSTEXECUTESCRIPT"}]</label>&nbsp;
                                </dt>
                                <dd>
                                    <input id="MainCronPostExecScript" type="text" class="edittext ext_edittext" name="value[sCronjobPostExecuteScript]" value="[{$edit->getValue('sCronjobPostExecuteScript')}]" [{$readonly}] [{$blActionScriptsRestriction}]>
                                    [{oxinputhelp ident="D3_ORDERMANAGER_MAIN_POSTEXECUTESCRIPT_DESC"}]
                                </dd>
                                <div class="spacer"></div>
                            </dl>
                        </div>

                    </div>
                </div>

                <div class="groupExp">
                    <div class="">
                        <a class="rc" onclick="_groupExp(this); return false;" href="#">
                            <b>
                                [{oxmultilang ident="D3_ORDERMANAGER_MAIN_FIELDSET_MANUALLY"}]
                                [{if $edit->getFieldData('D3_OM_EXECMANUALLY')}]<i class="fa fa-check-circle d3fa-color-green"></i>[{/if}]
                            </b>
                        </a>

                        <div>
                            <dl>
                                <dt>
                                    <label for="MainExecManually">[{oxmultilang ident="D3_ORDERMANAGER_MAIN_EXECMANUALLY"}]</label>&nbsp;
                                </dt>
                                <dd>
                                    <input type="hidden" name="editval[[{$edit->d3GetFieldLongName('D3_OM_EXECMANUALLY')}]]" value="0">
                                    <input id="MainExecManually" type="checkbox" class="edittext ext_edittext" name="editval[[{$edit->d3GetFieldLongName('D3_OM_EXECMANUALLY')}]]" value="1" [{if $edit->getFieldData('D3_OM_EXECMANUALLY')}]checked[{/if}] [{$readonly}]>
                                    [{oxinputhelp ident="D3_ORDERMANAGER_MAIN_EXECMANUALLY_DESC"}]
                                </dd>
                                <div class="spacer"></div>
                            </dl>
                        </div>

                        <div>
                            <dl class="[{$blActionScriptsRestriction}]">
                                <dt>
                                    <label for="MainManuallyPreExecScript">[{oxmultilang ident="D3_ORDERMANAGER_MAIN_PREEXECUTESCRIPT"}]</label>&nbsp;
                                </dt>
                                <dd>
                                    <input id="MainManuallyPreExecScript" type="text" class="edittext ext_edittext" name="value[sManuallyPreExecuteScript]" value="[{$edit->getValue('sManuallyPreExecuteScript')}]" [{$readonly}] [{$blActionScriptsRestriction}]>
                                    [{oxinputhelp ident="D3_ORDERMANAGER_MAIN_PREEXECUTESCRIPT_DESC"}]
                                </dd>
                                <div class="spacer"></div>
                            </dl>
                        </div>

                        <div>
                            <dl class="[{$blActionScriptsRestriction}]">
                                <dt>
                                    <label for="MainManuallyPostExecScript">[{oxmultilang ident="D3_ORDERMANAGER_MAIN_POSTEXECUTESCRIPT"}]</label>&nbsp;
                                </dt>
                                <dd>
                                    <input id="MainManuallyPostExecScript" type="text" class="edittext ext_edittext" name="value[sManuallyPostExecuteScript]" value="[{$edit->getValue('sManuallyPostExecuteScript')}]" [{$readonly}] [{$blActionScriptsRestriction}]>
                                    [{oxinputhelp ident="D3_ORDERMANAGER_MAIN_POSTEXECUTESCRIPT_DESC"}]
                                </dd>
                                <div class="spacer"></div>
                            </dl>
                        </div>

                        <div>
                            <dl>
                                <dt>
                                    <label for="MainExecManuallyMeetCondition">[{oxmultilang ident="D3_ORDERMANAGER_MAIN_EXECMANUALLYMEETCONDITION"}]</label>&nbsp;
                                </dt>
                                <dd>
                                    <input type="hidden" name="value[sManuallyExecMeetCondition]" value="0">
                                    <input id="MainExecManuallyMeetCondition" type="checkbox" class="edittext ext_edittext" name="value[sManuallyExecMeetCondition]" value="1" [{if $edit->getValue('sManuallyExecMeetCondition')}]checked[{/if}] [{$readonly}]>
                                    [{oxinputhelp ident="D3_ORDERMANAGER_MAIN_EXECMANUALLYMEETCONDITION_DESC"}]
                                </dd>
                                <div class="spacer"></div>
                            </dl>
                        </div>

                    </div>
                </div>

                <div class="groupExp">
                    <div class="">
                        <a class="rc" onclick="_groupExp(this); return false;" href="#">
                            <b>
                                [{oxmultilang ident="D3_ORDERMANAGER_MAIN_FIELDSET_AFTERORDERCOMPLETED"}]
                                [{if $edit->getFieldData('D3_OM_ORDERFINISHTRIGGERED')}]<i class="fa fa-check-circle d3fa-color-green"></i>[{/if}]
                            </b>
                        </a>

                        <div>
                            <dl class="[{$blActionTriggersRestriction}]">
                                <dt>
                                    <label for="MainExecOrderFinishTriggered">[{oxmultilang ident="D3_ORDERMANAGER_MAIN_EXECORDERFINISHTRIGGERED"}]</label>
                                </dt>
                                <dd>
                                    <input type="hidden" name="editval[[{$edit->d3GetFieldLongName('D3_OM_ORDERFINISHTRIGGERED')}]]" value="0" [{$blActionTriggersRestriction}]>
                                    <input id="MainExecOrderFinishTriggered" type="checkbox" class="edittext ext_edittext" name="editval[[{$edit->d3GetFieldLongName('D3_OM_ORDERFINISHTRIGGERED')}]]" value="1" [{if $edit->getFieldData('D3_OM_ORDERFINISHTRIGGERED')}]checked[{/if}] [{$readonly}] [{$blActionTriggersRestriction}]>
                                    [{oxinputhelp ident="D3_ORDERMANAGER_MAIN_EXECORDERFINISHTRIGGERED_DESC"}]
                                </dd>
                                <div class="spacer"></div>
                            </dl>
                        </div>

                        <div>
                            <dl class="[{$blActionScriptsRestriction}]">
                                <dt>
                                    <label for="MainFinishPreExecScript">[{oxmultilang ident="D3_ORDERMANAGER_MAIN_PREEXECUTESCRIPT"}]</label>&nbsp;
                                </dt>
                                <dd>
                                    <input id="MainFinishPreExecScript" type="text" class="edittext ext_edittext" name="value[sOrderFinishTriggeredPreExecuteScript]" value="[{$edit->getValue('sOrderFinishTriggeredPreExecuteScript')}]" [{$readonly}] [{$blActionScriptsRestriction}]>
                                    [{oxinputhelp ident="D3_ORDERMANAGER_MAIN_PREEXECUTESCRIPT_DESC"}]
                                </dd>
                                <div class="spacer"></div>
                            </dl>
                        </div>

                        <div>
                            <dl class="[{$blActionScriptsRestriction}]">
                                <dt>
                                    <label for="MainFinishPostExecScript">[{oxmultilang ident="D3_ORDERMANAGER_MAIN_POSTEXECUTESCRIPT"}]</label>&nbsp;
                                </dt>
                                <dd>
                                    <input id="MainFinishPostExecScript" type="text" class="edittext ext_edittext" name="value[sOrderFinishTriggeredPostExecuteScript]" value="[{$edit->getValue('sOrderFinishTriggeredPostExecuteScript')}]" [{$readonly}] [{$blActionScriptsRestriction}]>
                                    [{oxinputhelp ident="D3_ORDERMANAGER_MAIN_POSTEXECUTESCRIPT_DESC"}]
                                </dd>
                                <div class="spacer"></div>
                            </dl>
                        </div>

                    </div>
                </div>

                <div class="groupExp">
                    <div class="">
                        <a class="rc" onclick="_groupExp(this); return false;" href="#">
                            <b>
                                [{oxmultilang ident="D3_ORDERMANAGER_MAIN_FIELDSET_AFTERORDERSAVE"}]
                                [{if $edit->getFieldData('D3_OM_ORDERSAVETRIGGERED')}]<i class="fa fa-check-circle d3fa-color-green"></i>[{/if}]
                            </b>
                        </a>

                        <div>
                            <dl class="[{$blActionTriggersRestriction}]">
                                <dt>
                                    <label for="MainExecOrderFinishTriggered">[{oxmultilang ident="D3_ORDERMANAGER_MAIN_EXECORDERSAVETRIGGERED"}]</label>
                                </dt>
                                <dd>
                                    <input type="hidden" name="editval[[{$edit->d3GetFieldLongName('D3_OM_ORDERSAVETRIGGERED')}]]" value="0" [{$blActionTriggersRestriction}]>
                                    <input id="MainExecOrderFinishTriggered" type="checkbox" class="edittext ext_edittext" name="editval[[{$edit->d3GetFieldLongName('D3_OM_ORDERSAVETRIGGERED')}]]" value="1" [{if $edit->getFieldData('D3_OM_ORDERSAVETRIGGERED')}]checked[{/if}] [{$readonly}] [{$blActionTriggersRestriction}]>
                                    [{oxinputhelp ident="D3_ORDERMANAGER_MAIN_EXECORDERSAVETRIGGERED_DESC"}]
                                </dd>
                                <div class="spacer"></div>
                            </dl>
                        </div>

                        <div>
                            <dl class="[{$blActionScriptsRestriction}]">
                                <dt>
                                    <label for="MainSavePreExecScript">[{oxmultilang ident="D3_ORDERMANAGER_MAIN_PREEXECUTESCRIPT"}]</label>&nbsp;
                                </dt>
                                <dd>
                                    <input id="MainSavePreExecScript" type="text" class="edittext ext_edittext" name="value[sOrderSaveTriggeredPreExecuteScript]" value="[{$edit->getValue('sOrderSaveTriggeredPreExecuteScript')}]" [{$readonly}] [{$blActionScriptsRestriction}]>
                                    [{oxinputhelp ident="D3_ORDERMANAGER_MAIN_PREEXECUTESCRIPT_DESC"}]
                                </dd>
                                <div class="spacer"></div>
                            </dl>
                        </div>

                        <div>
                            <dl class="[{$blActionScriptsRestriction}]">
                                <dt>
                                    <label for="MainSavePostExecScript">[{oxmultilang ident="D3_ORDERMANAGER_MAIN_POSTEXECUTESCRIPT"}]</label>&nbsp;
                                </dt>
                                <dd>
                                    <input id="MainSavePostExecScript" type="text" class="edittext ext_edittext" name="value[sOrderSaveTriggeredPostExecuteScript]" value="[{$edit->getValue('sOrderSaveTriggeredPostExecuteScript')}]" [{$readonly}] [{$blActionScriptsRestriction}]>
                                    [{oxinputhelp ident="D3_ORDERMANAGER_MAIN_POSTEXECUTESCRIPT_DESC"}]
                                </dd>
                                <div class="spacer"></div>
                            </dl>
                        </div>

                    </div>
                </div>

                <table style="padding: 0; border: none;">
                    <tr>
                        <td class="edittext" colspan="2" style="padding-top: 20px;">
                            <span class="d3modcfg_btn icon d3color-green">
                                <button type="submit" class="edittext" name="saveArticle" onClick="document.myedit.fnc.value='save'" [{$readonly}]>
                                    <i class="fas fa-check-circle fa-inverse"></i>[{oxmultilang ident="D3_GENERAL_MODPROFILE_SAVE"}]
                                </button>
                            </span>
                        </td>
                    </tr>
                </table>
            </td>
<!-- Anfang rechte Seite -->
            <td class="edittext" style="text-align:left; vertical-align:top; height:99%;padding-left:5px;padding-bottom:30px;padding-top:10px;">
            </td>
<!-- Ende rechte Seite -->
        </tr>
    </table>
</form>

[{include file="d3_cfg_mod_inc.tpl"}]