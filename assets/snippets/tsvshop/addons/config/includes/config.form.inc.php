<?php

$output.= '<div class="tab-page" id="ShopSalesMail">';
$output.= '<h2 class="tab">'.$shop_lang['config_form_mail'].'</h2>';


$output.='
<div class="notice">'.$shop_lang['config_mail_title'].'</div><br />
<table width="100%" class="formconfig">';

$output.= '<tr>
              <td nowrap class="warning">'.$shop_lang['config_smtpfromname_title'].'</td>
              <td ><input type="text" id="SmtpFromName" name="SmtpFromName" class="inputBox" value="' . $tsvshop['SmtpFromName'] . '"></td>
            </tr>
            <tr>
              <td width="200">&nbsp;</td>
              <td class="comment">'.$shop_lang['config_smtpfromname_intro'].'</td>
            </tr>
            <tr>
              <td colspan="2"><div class="split"></div></td>
            </tr>';

$output.= '<tr>
              <td nowrap class="warning">'.$shop_lang['config_smtpfromemail_title'].'</td>
              <td ><input type="text" id="SmtpFromEmail" name="SmtpFromEmail" class="inputBox" value="' . $tsvshop['SmtpFromEmail'] . '"></td>
            </tr>
            <tr>
              <td width="200">&nbsp;</td>
              <td class="comment">'.$shop_lang['config_smtpfromemail_intro'].'</td>
            </tr>
            <tr>
              <td colspan="2"><div class="split"></div></td>
            </tr>';
$output.= '<tr>
              <td nowrap class="warning">'.$shop_lang['config_smtpreplyemail_title'].'</td>
              <td ><input type="text" id="SmtpReplyEmail" name="SmtpReplyEmail" class="inputBox" value="' . $tsvshop['SmtpReplyEmail'] . '"></td>
            </tr>
            <tr>
              <td width="200">&nbsp;</td>
              <td class="comment">'.$shop_lang['config_smtpreplyemail_intro'].'</td>
            </tr>
            <tr>
              <td colspan="2"><div class="split"></div></td>
            </tr>';
$output.= '<tr>
              <td nowrap class="warning">'.$shop_lang['config_mailadmin_title'].'</td>
              <td ><input type="text" id="SubjectMailAdmin" name="SubjectMailAdmin" class="inputBox" value="' . $tsvshop['SubjectMailAdmin'] . '"></td>
            </tr>
            <tr>
              <td width="200">&nbsp;</td>
              <td class="comment">'.$shop_lang['config_mailadmin_intro'].'</td>
            </tr>
            <tr>
              <td colspan="2"><div class="split"></div></td>
            </tr>';
$output.= '<tr>
              <td nowrap class="warning">'.$shop_lang['config_mailuser_title'].'</td>
              <td ><input type="text" id="SubjectMailUser" name="SubjectMailUser" class="inputBox" value="' . $tsvshop['SubjectMailUser'] . '"></td>
            </tr>
            <tr>
              <td width="200">&nbsp;</td>
              <td class="comment">'.$shop_lang['config_mailuser_intro'].'</td>
            </tr>
            <tr>
              <td colspan="2"><div class="split"></div></td>
            </tr>';
$output.= '<tr>
              <td nowrap class="warning">'.$shop_lang['config_updatestatus_title'].'</td>
              <td ><input type="text" id="SubjectUpdateStatus" name="SubjectUpdateStatus" class="inputBox" value="' . $tsvshop['SubjectUpdateStatus'] . '"></td>
            </tr>
            <tr>
              <td width="200">&nbsp;</td>
              <td class="comment">'.$shop_lang['config_updatestatus_intro'].'</td>
            </tr>
            <tr>
              <td colspan="2"><div class="split"></div></td>
            </tr>';
$output.= '</table>';
$output.= '</div>';


$output.= '<div class="tab-page" id="ShopSalesSecurity">';
$output.= '<h2 class="tab">'.$shop_lang['config_form_security'].'</h2>';
$output.='<table width="100%" class="formconfig">';
$output.= '<tr>
              <td nowrap class="warning">'.$shop_lang['config_password_title'].'</td>
              <td ><input type="text" id="SecPassword" name="SecPassword" class="inputBox" value="' . $tsvshop['SecPassword'] . '"></td>
            </tr>
            <tr>
              <td width="200">&nbsp;</td>
              <td class="comment">'.$shop_lang['config_password_intro'].'</td>
            </tr>
            <tr>
              <td colspan="2"><div class="split"></div></td>
            </tr>';
           
$output.= '<tr>
              <td nowrap class="warning">'.$shop_lang['config_secfields_title'].'</td>
              <td ><select id="SecFields" multiple name="SecFields" size="5" class="inputBox">'.buildmultioptions($tsvshop['SecFields'], $tsvshop['sysfields']).'</td>
            </tr>
            <tr>
              <td width="200">&nbsp;</td>
              <td class="comment">'.$shop_lang['config_secfields_intro'].'</td>
            </tr>
            <tr>
              <td colspan="2"><div class="split"></div></td>
            </tr>';  
$output.= '</table>';
$output.= '</div>';


$output.= '<div class="tab-page" id="ShopSalesMain">';
$output.= '<h2 class="tab">'.$shop_lang['config_form_main'].'</h2>';
$output.='<table width="100%" class="formconfig">';

$output.= '<tr>
              <td nowrap class="warning">'.$shop_lang['config_typecat_title'].'</td>
              <td ><select name="TypeCat" id="TypeCat" size="1" class="inputBox">';
$output.= buildoptions($tsvshop['TypeCat'], $TypeCatArray);
$output.= '</select>
              </td>
            </tr>
            <tr>
              <td width="200">&nbsp;</td>
              <td class="comment">'.$shop_lang['config_typecat_intro'].'</td>
            </tr>
            <tr>
              <td colspan="2"><div class="split"></div></td>
            </tr>';
            
$output.= '<tr>
              <td nowrap class="warning">'.$shop_lang['config_id_title'].'</td>
              <td ><input type="text" id="CatRoot" name="CatRoot" class="inputBox" value="' . $tsvshop['CatRoot'] . '"></td>
            </tr>
            <tr>
              <td width="200">&nbsp;</td>
              <td class="comment">'.$shop_lang['config_id_intro'].'</td>
            </tr>
            <tr>
              <td colspan="2"><div class="split"></div></td>
            </tr>';

$output.= '<tr>
              <td nowrap class="warning">'.$shop_lang['config_valuta_title'].'</td>
              <td ><select name="MonetarySymbol" id="MonetarySymbol" size="1" class="inputBox">';
$output.= buildoptions($tsvshop['MonetarySymbol'], $MonetarySymbolArray);
$output.= '</select>
</td>
            </tr>
            <tr>
              <td width="200">&nbsp;</td>
              <td class="comment">'.$shop_lang['config_valuta_intro'].'</td>
            </tr>
            <tr>
              <td colspan="2"><div class="split"></div></td>
            </tr>';


$output.= '<tr>
              <td nowrap class="warning">'.$shop_lang['config_priceformat_title'].'</td>
              <td ><select id="PriceFormat" name="PriceFormat" size="1" class="inputBox">';
$output.= buildoptions($tsvshop['PriceFormat'], $PriceFormatArray);
$output.= '</select> 
</td>
            </tr>
            <tr>
              <td width="200">&nbsp;</td>
              <td class="comment">'.$shop_lang['config_priceformat_intro'].'</td>
            </tr>
            <tr>
              <td colspan="2"><div class="split"></div></td>
            </tr>';
$output.= '<tr>
              <td nowrap class="warning">'.$shop_lang['config_notice_title'].'</td>
              <td ><select id="DisplayNotice" name="DisplayNotice" size="1" class="inputBox">';
$output.= buildoptions($tsvshop['DisplayNotice'], $DisplayNoticeArray);
$output.= '</select>
</td>
            </tr>
            <tr>
              <td width="200">&nbsp;</td>
              <td class="comment">'.$shop_lang['config_notice_intro'].'</td>
            </tr>
            <tr>
              <td colspan="2"><div class="split"></div></td>
            </tr>';
$output.= '<tr>
              <td nowrap class="warning">'.$shop_lang['config_minsumma_title'].'</td>
              <td ><input type="text" id="MinimumOrder" name="MinimumOrder" size="7" class="inputBox" value="' . $tsvshop['MinimumOrder'] . '"></td>
            </tr>
            <tr>
              <td width="200">&nbsp;</td>
              <td class="comment">'.$shop_lang['config_minsumma_intro'].'</td>
            </tr>
            <tr>
              <td colspan="2"><div class="split"></div></td>
            </tr>';
            
            $output.= '<tr>
              <td nowrap class="warning">'.$shop_lang['config_status_title'].'</td>
              <td ><textarea id="StatusOrder" name="StatusOrder" size="1" class="inputBox">';
            $output.= $tsvshop['StatusOrder'];
            $output.= '</textarea> 
            </td>
            </tr>
            <tr>
              <td width="200">&nbsp;</td>
              <td class="comment">'.$shop_lang['config_status_intro'].'</td>
            </tr>
            <tr>
              <td colspan="2"><div class="split"></div></td>
            </tr>';
            
            
$output.= '</table>';
$output.= '</div>';
?>
