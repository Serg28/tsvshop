//<?
/**
 * ContactSettings
 *
 * <strong>1.0.x</strong> Plugin to add contacts system settings
 *
 * @category plugin
 * @version 1.0
 * @author Nicola Lambathakis (www.tattoocms.it) based on customSettings by Andchir <andchir@gmaail.com>
 * @internal @properties &settings=Settings;textarea;Site owner~site_owner||Site e-mail~site_mail||Site Copyright~site_copyright||Company name~company_name||Company IVA/VAT~company_iva||Company e-mail~company_mail||Company Phone~company_phone||Company Fax~company_fax||Company address~company_address||Icq~chat_icq||Msn~chat_msn||Facebook~social_facebook||Twitter~social_twitter||Googleplus~social_googleplus||Youtube~social_youtube||Linkedin~social_linkedin  &pname=title;text;
 * @internal @events OnSiteSettingsRender
 * @internal @modx_category Start Admin
 * @internal @installset base, sample
 */

/*
ContactSettings
author Nicola Lambathakis (www.tattoocms.it) based on customSettings by Andchir <andchir@gmaail.com>

/*
&settings=Settings;textarea;Site owner~site_owner||Site e-mail~site_mail||Site Copyright~site_copyright||Company name~company_name||Company IVA/VAT~company_iva||Company e-mail~company_mail||Company Phone~company_phone||Company Fax~company_fax||Company address~company_address||Icq~chat_icq||Msn~chat_msn||Facebook~social_facebook||Twitter~social_twitter||Googleplus~social_googleplus||Youtube~social_youtube||Linkedin~social_linkedin  &pname=title;text;
*/



$e = &$modx->Event;
$output = "";
if ($e->name == 'OnSiteSettingsRender'){
$settingsArr = !empty($settings) ? explode('||',$settings) : array('Example custom setting~custom_st_example');
$fname = !empty($pname) ? $pname : 'Contact Settings';
$output .= '</td></tr></table></div><div style="display: block;" class="tab-page" id="tabPage8"><h2 class="tab">'.$fname.'</h2><script type="text/javascript">tpSettings.addTabPage( document.getElementById( "tabPage8" ) );</script><table border="0" cellpadding="3" cellspacing="0"><tbody>';
foreach($settingsArr as $key => $st_row){
    $st_label_arr = explode('~',$st_row);
    $custom_st_label = trim($st_label_arr[0]);
    $custom_st_name = isset($st_label_arr[1]) ? $st_label_arr[1] : 'custom_st';
    $custom_st_value = isset($st_label_arr[1]) && isset($modx->config[$st_label_arr[1]]) ? trim($modx->config[$st_label_arr[1]]) : '';
 $output .= '<tr><td class="warning" nowrap="">'.$custom_st_label.'</td>
        <td><input type="text" value="'.$custom_st_value.'" name="'.$custom_st_name.'" style="width: 350px;" onchange="documentDirty=true;" /></td><td>placeholder: [('.$custom_st_name.')]</td></tr><tr><td colspan="2"><div class="split"/></td></tr>';
}
$output .= '</tbody></table>';
}
$e->output($output);
