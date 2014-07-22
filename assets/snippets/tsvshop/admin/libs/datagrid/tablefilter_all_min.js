 /*------------------------------------------------------------------------
	- HTML Table Filter Generator v2.1
	- By Max Guglielmi (tablefilter.free.fr)
	- Licensed under the MIT License
--------------------------------------------------------------------------
Copyright (c) 2009-2011 Max Guglielmi

Permission is hereby granted, free of charge, to any person obtaining
a copy of this software and associated documentation files (the
"Software"), to deal in the Software without restriction, including
without limitation the rights to use, copy, modify, merge, publish,
distribute, sublicense, and/or sell copies of the Software, and to
permit persons to whom the Software is furnished to do so, subject to
the following conditions:

The above copyright notice and this permission notice shall be included
in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY
CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT,
TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE
SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
--------------------------------------------------------------------------
	- Special credit to: 
	Cedric Wartel, cnx.claude@free.fr, Florent Hirchy, Váry Péter, 
	Anthony Maes, Nuovella Williams, Fuggerbit, Venkata Seshagiri Rao 
	Raya, Piepiax, Manuel Kern for active contribution and/or inspiration
------------------------------------------------------------------------*/

function setFilterGrid(id)
{if(arguments.length==0)return;eval('tf_'+id+' = new TF(arguments[0],arguments[1],arguments[2]);'+'tf_'+id+'.AddGrid();');return window['tf_'+id];}
window['tf_isNotIE']=!(/msie|MSIE/.test(navigator.userAgent));tf_AddEvent(window,(tf_isNotIE||(typeof window.addEventListener=='function')?'DOMContentLoaded':'load'),initFilterGrid);function initFilterGrid()
{if(!document.getElementsByTagName)return;var tbls=tf_Tag(document,'table'),config;for(var i=0;i<tbls.length;i++)
{var cTbl=tbls[i],cTblId=cTbl.getAttribute('id');if(tf_HasClass(cTbl,'filterable')&&cTblId)
{if(tf_IsObj(cTblId+'_config'))
config=window[cTblId+'_config'];else
config=undefined;window[cTblId+'_isUnob']=true;setFilterGrid(cTblId,config);}}}
var TF=function(id)
{if(arguments.length==0)return;this.id=id;this.version='2.1';this.tbl=tf_Id(id);this.startRow=undefined;this.refRow=null;this.headersRow=null;this.fObj=null;this.nbFilterableRows=null;this.nbRows=null;this.nbCells=null;this.hasGrid=false;this.enableModules=false;if(this.tbl!=null&&this.tbl.nodeName.tf_LCase()=='table'&&this.GetRowsNb())
{if(arguments.length>1)
{for(var i=0;i<arguments.length;i++)
{var argtype=typeof arguments[i];switch(argtype.tf_LCase())
{case'number':this.startRow=arguments[i];break;case'object':this.fObj=arguments[i];break;}}}
var f=!this.fObj?{}:this.fObj;this.refRow=this.startRow==undefined?2:(this.startRow+1);try{this.nbCells=this.GetCellsNb(this.refRow)}
catch(e){this.nbCells=this.GetCellsNb(0)}
this.basePath=f.base_path!=undefined?f.base_path:'../assets/snippets/tsvshop/admin/libs/datagrid/';this.fltTypeInp='input';this.fltTypeSlc='select';this.fltTypeMulti='multiple';this.fltTypeCheckList='checklist';this.fltTypeNone='none';this.fltCol=[];for(var i=0;i<this.nbCells;i++){if(this['col'+i]==undefined)
this['col'+i]=(f['col_'+i]==undefined)?this.fltTypeInp:f['col_'+i].tf_LCase();this.fltCol.push(this['col'+i]);}
this.publicMethods=f.public_methods!=undefined?f.public_methods:false;this.fltGrid=f.grid==false?false:true;this.gridLayout=f.grid_layout?true:false;this.hasGridWidthsRow=false;this.gridColElms=[];this.sourceTblHtml=null;if(this.gridLayout){if(this.tbl.outerHTML==undefined)tf_SetOuterHtml();this.sourceTblHtml=this.tbl.outerHTML;}
this.filtersRowIndex=f.filters_row_index!=undefined?f.filters_row_index>1?1:f.filters_row_index:0;if(this.gridLayout)this.filtersRowIndex=1;this.fltCellTag=f.filters_cell_tag!=undefined?(f.filters_cell_tag!='th'?'td':'th'):'td';this.fltIds=[];this.fltElms=[];this.searchArgs=null;this.tblData=[];this.validRowsIndex=null;this.fltGridEl=null;this.isFirstLoad=true;this.infDiv=null;this.lDiv=null;this.rDiv=null;this.mDiv=null;this.contDiv=null;this.infDivCssClass=f.inf_div_css_class!=undefined?f.inf_div_css_class:'inf';this.lDivCssClass=f.left_div_css_class!=undefined?f.left_div_css_class:'ldiv';this.rDivCssClass=f.right_div_css_class!=undefined?f.right_div_css_class:'rdiv';this.mDivCssClass=f.middle_div_css_class!=undefined?f.middle_div_css_class:'mdiv';this.contDivCssClass=f.content_div_css_class!=undefined?f.content_div_css_class:'cont';this.stylesheet=f.stylesheet!=undefined?f.stylesheet:this.basePath+'filtergrid.css';this.stylesheetId=this.id+'_style';this.fltsRowCssClass=f.flts_row_css_class!=undefined?f.flts_row_css_class:'fltrow';this.enableIcons=f.enable_icons!=undefined?f.enable_icons:true;this.alternateBgs=f.alternate_rows?true:false;this.hasColWidth=f.col_width?true:false;this.colWidth=this.hasColWidth?f.col_width:null;this.fixedHeaders=f.fixed_headers?true:false;this.tBodyH=f.tbody_height?f.tbody_height:200;this.fltCssClass=f.flt_css_class!=undefined?f.flt_css_class:'flt';this.fltMultiCssClass=f.flt_multi_css_class!=undefined?f.flt_multi_css_class:'flt_multi';this.fltSmallCssClass=f.flt_small_css_class!=undefined?f.flt_small_css_class:'flt_s';this.singleFltCssClass=f.single_flt_css_class!=undefined?f.single_flt_css_class:'single_flt';this.isStartBgAlternate=true;this.rowBgEvenCssClass=f.even_row_css_class!=undefined?f.even_row_css_class:'even';this.rowBgOddCssClass=f.odd_row_css_class!=undefined?f.odd_row_css_class:'odd';this.enterKey=f.enter_key==false?false:true;this.isModFilterFn=f.mod_filter_fn?true:false;this.modFilterFn=this.isModFilterFn?f.mod_filter_fn:null;this.onBeforeFilter=tf_IsFn(f.on_before_filter)?f.on_before_filter:null;this.onAfterFilter=tf_IsFn(f.on_after_filter)?f.on_after_filter:null;this.matchCase=f.match_case?true:false;this.exactMatch=f.exact_match?true:false;this.refreshFilters=f.refresh_filters?true:false;this.activeFlt=null;this.activeFilterId=null;this.hasColOperation=f.col_operation?true:false;this.colOperation=null;this.hasVisibleRows=f.rows_always_visible?true:false;this.visibleRows=this.hasVisibleRows?f.rows_always_visible:[];this.searchType=f.search_type!=undefined?f.search_type:'include';this.isExternalFlt=f.external_flt_grid?true:false;this.externalFltTgtIds=f.external_flt_grid_ids!=undefined?f.external_flt_grid_ids:null;this.externalFltEls=[];this.execDelay=f.exec_delay?parseInt(f.exec_delay):100;this.status=f.status?true:false;this.onFiltersLoaded=tf_IsFn(f.on_filters_loaded)?f.on_filters_loaded:null;this.singleSearchFlt=f.single_search_filter?true:false;this.onRowValidated=tf_IsFn(f.on_row_validated)?f.on_row_validated:null;this.customCellDataCols=f.custom_cell_data_cols?f.custom_cell_data_cols:[];this.customCellData=tf_IsFn(f.custom_cell_data)?f.custom_cell_data:null;this.inpWatermark=f.input_watermark!=undefined?f.input_watermark:'';this.inpWatermarkCssClass=f.input_watermark_css_class!=undefined?f.input_watermark_css_class:'fltWatermark';this.isInpWatermarkArray=f.input_watermark!=undefined?(tf_IsArray(f.input_watermark)?true:false):false;this.toolBarTgtId=f.toolbar_target_id!=undefined?f.toolbar_target_id:null;this.helpInstructions=(f.help_instructions!=undefined)?f.help_instructions:null;this.popUpFilters=f.popup_filters!=undefined?f.popup_filters:false;if(this.popUpFilters)(!this.gridLayout)?this.filtersRowIndex=0:this.filtersRowIndex=1;this.markActiveColumns=f.mark_active_columns!=undefined?f.mark_active_columns:false;this.activeColumnsCssClass=f.active_columns_css_class!=undefined?f.active_columns_css_class:'activeHeader';this.onBeforeActiveColumn=tf_IsFn(f.on_before_active_column)?f.on_before_active_column:null;this.onAfterActiveColumn=tf_IsFn(f.on_after_active_column)?f.on_after_active_column:null;this.displayAllText=f.display_all_text!=undefined?f.display_all_text:'';this.enableEmptyOption=f.enable_empty_option?true:false;this.emptyText=f.empty_text!=undefined?f.empty_text:'(Empty)';this.enableNonEmptyOption=f.enable_non_empty_option?true:false;this.nonEmptyText=f.non_empty_text!=undefined?f.non_empty_text:'(Non empty)';this.onSlcChange=f.on_change==false?false:true;this.sortSlc=f.sort_select==false?false:true;this.isSortNumAsc=f.sort_num_asc?true:false;this.sortNumAsc=this.isSortNumAsc?f.sort_num_asc:null;this.isSortNumDesc=f.sort_num_desc?true:false;this.sortNumDesc=this.isSortNumDesc?f.sort_num_desc:null;this.slcFillingMethod=f.slc_filling_method!=undefined?f.slc_filling_method:'createElement';this.fillSlcOnDemand=f.fill_slc_on_demand?true:false;this.activateSlcTooltip=f.activate_slc_tooltip!=undefined?f.activate_slc_tooltip:'Click to activate';this.multipleSlcTooltip=f.multiple_slc_tooltip!=undefined?f.multiple_slc_tooltip:'Use Ctrl key for multiple selections';this.hasCustomSlcOptions=f.custom_slc_options&&tf_IsObj(f.custom_slc_options)?true:false;this.customSlcOptions=f.custom_slc_options!=undefined?f.custom_slc_options:null;this.onBeforeOperation=tf_IsFn(f.on_before_operation)?f.on_before_operation:null;this.onAfterOperation=tf_IsFn(f.on_after_operation)?f.on_after_operation:null;this.checkListDiv=[];this.checkListDivCssClass=f.div_checklist_css_class!=undefined?f.div_checklist_css_class:'div_checklist';this.checkListCssClass=f.checklist_css_class!=undefined?f.checklist_css_class:'flt_checklist';this.checkListItemCssClass=f.checklist_item_css_class!=undefined?f.checklist_item_css_class:'flt_checklist_item';this.checkListSlcItemCssClass=f.checklist_selected_item_css_class!=undefined?f.checklist_selected_item_css_class:'flt_checklist_slc_item';this.activateCheckListTxt=f.activate_checklist_text!=undefined?f.activate_checklist_text:'Click to load data';this.emOperator=f.empty_operator!=undefined?f.empty_operator:'[empty]';this.nmOperator=f.nonempty_operator!=undefined?f.nonempty_operator:'[nonempty]';this.orOperator=f.or_operator!=undefined?f.or_operator:'||';this.anOperator=f.and_operator!=undefined?f.and_operator:'&&';this.grOperator=f.greater_operator!=undefined?f.greater_operator:'>';this.lwOperator=f.lower_operator!=undefined?f.lower_operator:'<';this.leOperator=f.lower_equal_operator!=undefined?f.lower_equal_operator:'<=';this.geOperator=f.greater_equal_operator!=undefined?f.greater_equal_operator:'>=';this.dfOperator=f.different_operator!=undefined?f.different_operator:'!';this.lkOperator=f.like_operator!=undefined?f.like_operator:'*';this.eqOperator=f.equal_operator!=undefined?f.equal_operator:'=';this.stOperator=f.start_with_operator!=undefined?f.start_with_operator:'{';this.enOperator=f.end_with_operator!=undefined?f.end_with_operator:'}';this.curExp=f.cur_exp!=undefined?f.cur_exp:'^[¥£€$]';this.separator=f.separator!=undefined?f.separator:',';this.rowsCounter=f.rows_counter?true:false;this.statusBar=f.status_bar?f.status_bar:false;this.loader=f.loader?true:false;this.displayBtn=f.btn?true:false;this.btnText=f.btn_text!=undefined?f.btn_text:(!this.enableIcons?'Go':'');this.btnCssClass=f.btn_css_class!=undefined?f.btn_css_class:(!this.enableIcons?'btnflt':'btnflt_icon');this.btnReset=f.btn_reset?true:false;this.btnResetCssClass=f.btn_reset_css_class!=undefined?f.btn_reset_css_class:'reset';this.paging=f.paging?true:false;this.hasResultsPerPage=f.results_per_page?true:false;this.btnPageCssClass=f.paging_btn_css_class!=undefined?f.paging_btn_css_class:'pgInp';this.pagingSlc=null;this.resultsPerPage=null;this.resultsPerPageSlc=null;this.isPagingRemoved=false;this.nbVisibleRows=0;this.nbHiddenRows=0;this.startPagingRow=0;this.nbPages=0;this.currentPageNb=1;this.sort=f.sort?true:false;this.isSortEnabled=false;this.sorted=false;this.sortConfig=f.sort_config!=undefined?f.sort_config:{};this.sortConfig.name=this.sortConfig['name']!=undefined?f.sort_config.name:'sortabletable';this.sortConfig.src=this.sortConfig['src']!=undefined?f.sort_config.src:this.basePath+'sortabletable.js';this.sortConfig.adapterSrc=this.sortConfig['adapter_src']!=undefined?f.sort_config.adapter_src:this.basePath+'tfAdapter.sortabletable.js';this.sortConfig.initialize=this.sortConfig['initialize']!=undefined?f.sort_config.initialize:function(o){if(o.SetSortTable)o.SetSortTable();};this.sortConfig.sortTypes=this.sortConfig['sort_types']!=undefined?f.sort_config.sort_types:[];this.sortConfig.sortCol=this.sortConfig['sort_col']!=undefined?f.sort_config.sort_col:null;this.sortConfig.asyncSort=this.sortConfig['async_sort']!=undefined?true:false;this.sortConfig.triggerIds=this.sortConfig['sort_trigger_ids']!=undefined?f.sort_config.sort_trigger_ids:[];this.selectable=f.selectable!=undefined?f.selectable:false;this.editable=f.editable!=undefined?f.editable:false;this.ezEditTableConfig=f.ezEditTable_config!=undefined?f.ezEditTable_config:{};this.ezEditTableConfig.name=this.ezEditTableConfig['name']!=undefined?f.ezEditTable_config.name:'ezedittable';this.ezEditTableConfig.src=this.ezEditTableConfig['src']!=undefined?f.ezEditTable_config.src:this.basePath+'ezEditTable/ezEditTable.js';this.ezEditTableConfig.loadStylesheet=this.ezEditTableConfig['loadStylesheet']!=undefined?f.ezEditTable_config.loadStylesheet:false;this.ezEditTableConfig.stylesheet=this.ezEditTableConfig['stylesheet']!=undefined?f.ezEditTable_config.stylesheet:this.basePath+'ezEditTable/ezEditTable.css';this.ezEditTableConfig.stylesheetName=this.ezEditTableConfig['stylesheetName']!=undefined?f.ezEditTable_config.stylesheetName:'ezEditTableCss';this.onKeyUp=f.on_keyup?true:false;this.onKeyUpDelay=f.on_keyup_delay!=undefined?f.on_keyup_delay:900;this.isUserTyping=null;this.onKeyUpTimer=undefined;this.highlightKeywords=f.highlight_keywords?true:false;this.highlightCssClass=f.highlight_css_class!=undefined?f.highlight_css_class:'keyword';this.defaultDateType=f.default_date_type!=undefined?f.default_date_type:'DMY';this.thousandsSeparator=f.thousands_separator!=undefined?f.thousands_separator:',';this.decimalSeparator=f.decimal_separator!=undefined?f.decimal_separator:'.';this.hasColNbFormat=f.col_number_format?true:false;this.colNbFormat=this.hasColNbFormat?f.col_number_format:null;this.hasColDateType=f.col_date_type?true:false;this.colDateType=this.hasColDateType?f.col_date_type:null;this.msgFilter=f.msg_filter!=undefined?f.msg_filter:'Filtering data...';this.msgPopulate=f.msg_populate!=undefined?f.msg_populate:'Populating filter...';this.msgPopulateCheckList=f.msg_populate_checklist!=undefined?f.msg_populate_checklist:'Populating list...';this.msgChangePage=f.msg_change_page!=undefined?f.msg_change_page:'Collecting paging data...';this.msgClear=f.msg_clear!=undefined?f.msg_clear:'Clearing filters...';this.msgChangeResults=f.msg_change_results!=undefined?f.msg_change_results:'Changing results per page...';this.msgResetValues=f.msg_reset_grid_values!=undefined?f.msg_reset_grid_values:'Re-setting filters values...';this.msgResetPage=f.msg_reset_page!=undefined?f.msg_reset_page:'Re-setting page...';this.msgResetPageLength=f.msg_reset_page_length!=undefined?f.msg_reset_page_length:'Re-setting page length...';this.msgSort=f.msg_sort!=undefined?f.msg_sort:'Sorting data...';this.msgLoadExtensions=f.msg_load_extensions!=undefined?f.msg_load_extensions:'Loading extensions...';this.msgLoadThemes=f.msg_load_themes!=undefined?f.msg_load_themes:'Loading theme(s)...';this.prfxTf='TF';this.prfxFlt='flt';this.prfxValButton='btn';this.prfxInfDiv='inf_';this.prfxLDiv='ldiv_';this.prfxRDiv='rdiv_';this.prfxMDiv='mdiv_';this.prfxContentDiv='cont_';this.prfxCheckListDiv='chkdiv_';this.prfxSlcPages='slcPages_';this.prfxSlcResults='slcResults_';this.prfxSlcResultsTxt='slcResultsTxt_';this.prfxBtnNextSpan='btnNextSpan_';this.prfxBtnPrevSpan='btnPrevSpan_';this.prfxBtnLastSpan='btnLastSpan_';this.prfxBtnFirstSpan='btnFirstSpan_';this.prfxBtnNext='btnNext_';this.prfxBtnPrev='btnPrev_';this.prfxBtnLast='btnLast_';this.prfxBtnFirst='btnFirst_';this.prfxPgSpan='pgspan_';this.prfxPgBeforeSpan='pgbeforespan_';this.prfxPgAfterSpan='pgafterspan_';this.prfxCounter='counter_';this.prfxTotRows='totrows_span_';this.prfxTotRowsTxt='totRowsTextSpan_';this.prfxResetSpan='resetspan_';this.prfxLoader='load_';this.prfxStatus='status_';this.prfxStatusSpan='statusSpan_';this.prfxStatusTxt='statusText_';this.prfxCookieFltsValues='tf_flts_';this.prfxCookiePageNb='tf_pgnb_';this.prfxCookiePageLen='tf_pglen_';this.prfxMainTblCont='gridCont_';this.prfxTblCont='tblCont_';this.prfxHeadTblCont='tblHeadCont_';this.prfxHeadTbl='tblHead_';this.prfxGridFltTd='_td_';this.prfxGridTh='tblHeadTh_';this.prfxHelpSpan='helpSpan_';this.prfxHelpDiv='helpDiv_';this.prfxPopUpSpan='popUpSpan_';this.prfxPopUpDiv='popUpDiv_';this.hasStoredValues=false;this.rememberGridValues=f.remember_grid_values?true:false;this.fltsValuesCookie=this.prfxCookieFltsValues+this.id;this.rememberPageNb=this.paging&&f.remember_page_number?true:false;this.pgNbCookie=this.prfxCookiePageNb+this.id;this.rememberPageLen=this.paging&&f.remember_page_length?true:false;this.pgLenCookie=this.prfxCookiePageLen+this.id;this.cookieDuration=f.set_cookie_duration?parseInt(f.set_cookie_duration):100000;this.hasExtensions=f.extensions?true:false;this.extensions=(this.hasExtensions)?f.extensions:null;this.enableDefaultTheme=f.enable_default_theme?true:false;this.hasThemes=(f.enable_default_theme||(f.themes&&tf_IsObj(f.themes)))?true:false;this.themes=(this.hasThemes)?f.themes:null;this.themesPath=f.themes_path!=undefined?f.themes_path:this.basePath+'TF_Themes/';this.hasBindScript=f.bind_script?true:false;this.bindScript=(this.hasBindScript)?f.bind_script:null;var o=this;this.Evt={name:{filter:'Filter',populateselect:'Populate',populatechecklist:'PopulateCheckList',changepage:'ChangePage',clear:'Clear',changeresultsperpage:'ChangeResults',resetvalues:'ResetValues',resetpage:'ResetPage',resetpagelength:'ResetPageLength',sort:'Sort',loadextensions:'LoadExtensions',loadthemes:'LoadThemes'},_DetectKey:function(e)
{if(!o.enterKey)return;var evt=e||window.event;if(evt)
{var key=(evt.charCode)?evt.charCode:((evt.keyCode)?evt.keyCode:((evt.which)?evt.which:0));if(key=='13')
{o._Filter();tf_CancelEvent(evt);tf_StopEvent(evt);}else{o.isUserTyping=true;window.clearInterval(o.onKeyUpTimer);o.onKeyUpTimer=undefined;}}},_OnKeyUp:function(e)
{if(!o.onKeyUp)return;var evt=e||window.event;var key=(evt.charCode)?evt.charCode:((evt.keyCode)?evt.keyCode:((evt.which)?evt.which:0));o.isUserTyping=false;if(key!=13&&key!=9&&key!=27&&key!=38&&key!=40)
{function filter()
{window.clearInterval(o.onKeyUpTimer);o.onKeyUpTimer=undefined;if(!o.isUserTyping)
{o.Filter();o.isUserTyping=null;}}
if(o.onKeyUpTimer==undefined)
o.onKeyUpTimer=window.setInterval(filter,o.onKeyUpDelay);}else{window.clearInterval(o.onKeyUpTimer);o.onKeyUpTimer=undefined;}},_OnKeyDown:function(e)
{if(!o.onKeyUp)return;o.isUserTyping=true;},_OnInpBlur:function(e)
{if(o.onKeyUp){o.isUserTyping=false;window.clearInterval(o.onKeyUpTimer);}
if(this.value==''&&o.inpWatermark!=''){this.value=(o.isInpWatermarkArray)?o.inpWatermark[this.getAttribute('ct')]:o.inpWatermark;tf_AddClass(this,o.inpWatermarkCssClass);}
if(o.ezEditTable){if(o.editable)o.ezEditTable.Editable.Set();if(o.selectable)o.ezEditTable.Selection.Set();}},_OnInpFocus:function(e)
{var evt=e||window.event;o.activeFilterId=this.getAttribute('id');o.activeFlt=tf_Id(o.activeFilterId);if(!o.isInpWatermarkArray){if(this.value==o.inpWatermark&&o.inpWatermark!=''){this.value='';tf_RemoveClass(this,o.inpWatermarkCssClass);}}else{var inpWatermark=o.inpWatermark[this.getAttribute('ct')];if(this.value==inpWatermark&&inpWatermark!=''){this.value='';tf_RemoveClass(this,o.inpWatermarkCssClass);}}
if(o.popUpFilters){tf_CancelEvent(evt);tf_StopEvent(evt);}
if(o.ezEditTable){if(o.editable)o.ezEditTable.Editable.Remove();if(o.selectable)o.ezEditTable.Selection.Remove();}},_OnSlcFocus:function(e)
{var evt=e||window.event;o.activeFilterId=this.getAttribute('id');o.activeFlt=tf_Id(o.activeFilterId);if(o.fillSlcOnDemand&&this.getAttribute('filled')=='0')
{var ct=this.getAttribute('ct');o.PopulateSelect(ct);if(!tf_isIE)this.setAttribute('filled','1');}
if(o.popUpFilters){tf_CancelEvent(evt);tf_StopEvent(evt);}},_OnSlcChange:function(e)
{if(o.activeFlt&&o.activeFlt.getAttribute('colIndex')&&o['col'+o.activeFlt.getAttribute('colIndex')]==o.fltTypeCheckList&&!o.Evt._OnSlcChange.caller)return;var evt=e||window.event;if(o.popUpFilters)tf_StopEvent(evt);if(o.onSlcChange)o.Filter();},_OnSlcBlur:function()
{},_OnCheckListChange:function(e)
{if(!o.Evt._OnCheckListChange.caller)return;o.Evt._OnSlcChange(e);},_OnCheckListClick:function()
{if(o.fillSlcOnDemand&&this.getAttribute('filled')=='0')
{var ct=this.getAttribute('ct');o.PopulateCheckList(ct);o.checkListDiv[ct].onclick=null;o.checkListDiv[ct].title='';}},_OnCheckListFocus:function()
{o.activeFilterId=this.firstChild.getAttribute('id');o.activeFlt=tf_Id(o.activeFilterId);},_OnBtnClick:function()
{o.Filter();},_OnSlcPagesChangeEvt:null,_EnableSlc:function()
{this.firstChild.disabled=false;this.firstChild.focus();this.onclick=null;},_Clear:function()
{o.ClearFilters();},_OnHelpBtnClick:function()
{o._ToggleHelp();},_Paging:{nextEvt:null,prevEvt:null,lastEvt:null,firstEvt:null}};}}
TF.prototype={AddGrid:function()
{this._AddGrid();},Init:function(){this.AddGrid();},Initialize:function(){this.AddGrid();},init:function(){this.AddGrid();},initialize:function(){this.AddGrid();},_AddGrid:function()
{if(this.hasGrid)return;if(this.gridLayout)this.refRow=this.startRow==undefined?0:this.startRow;this.headersRow=(this.filtersRowIndex==0&&this.fltGrid)?1:0;var f=!this.fObj?{}:this.fObj;var n=(this.singleSearchFlt)?1:this.nbCells,inpclass;if(window['tf_'+this.id]==undefined)window['tf_'+this.id]=this;this.IncludeFile(this.stylesheetId,this.stylesheet,null,'link');if(this.hasThemes)this._LoadThemes();if(this.gridLayout)
{this.isExternalFlt=true;this.SetGridLayout();this.refRow=(tf_isIE||tf_isIE7)?(this.refRow+1):0;}
if(this.loader)this.SetLoader();if(this.popUpFilters)this.SetPopupFilterIcons();if(this.hasResultsPerPage)
{this.resultsPerPage=f['results_per_page']!=undefined?f['results_per_page']:this.resultsPerPage;if(this.resultsPerPage.length<2)
this.hasResultsPerPage=false;else
this.pagingLength=this.resultsPerPage[1][0];}
if(!this.fltGrid)
{this.refRow=(this.refRow-1);if(this.gridLayout)this.refRow=0;this.nbFilterableRows=this.GetRowsNb();this.nbVisibleRows=this.nbFilterableRows;this.nbRows=this.nbFilterableRows+this.refRow;}else{if(this.isFirstLoad)
{if(!this.gridLayout){var fltrow;var thead=tf_Tag(this.tbl,'thead');if(thead.length>0)
fltrow=thead[0].insertRow(this.filtersRowIndex);else
fltrow=this.tbl.insertRow(this.filtersRowIndex);if(this.fixedHeaders)this.SetFixedHeaders();fltrow.className=this.fltsRowCssClass;if(this.isExternalFlt&&(!this.gridLayout||this.popUpFilters))fltrow.style.display='none';}
this.nbFilterableRows=this.GetRowsNb();this.nbVisibleRows=this.nbFilterableRows;this.nbRows=this.tbl.rows.length;for(var i=0;i<n;i++){var fltcell=tf_CreateElm(this.fltCellTag);if(this.singleSearchFlt)fltcell.colSpan=this.nbCells;if(!this.gridLayout)fltrow.appendChild(fltcell);inpclass=(i==n-1&&this.displayBtn)?this.fltSmallCssClass:this.fltCssClass;if(this.popUpFilters)this.SetPopupFilter(i);if(this['col'+i]==undefined)
this['col'+i]=(f['col_'+i]==undefined)?this.fltTypeInp:f['col_'+i].tf_LCase();if(this.singleSearchFlt)
{this['col'+i]=this.fltTypeInp;inpclass=this.singleFltCssClass;}
if(this['col'+i]==this.fltTypeSlc||this['col'+i]==this.fltTypeMulti)
{var slc=tf_CreateElm(this.fltTypeSlc,['id',this.prfxFlt+i+'_'+this.id],['ct',i],['filled','0']);if(this['col'+i]==this.fltTypeMulti)
{slc.multiple=this.fltTypeMulti;slc.title=this.multipleSlcTooltip;}
slc.className=(this['col'+i].tf_LCase()==this.fltTypeSlc)?inpclass:this.fltMultiCssClass;if(this.isExternalFlt&&this.externalFltTgtIds&&tf_Id(this.externalFltTgtIds[i]))
{tf_Id(this.externalFltTgtIds[i]).appendChild(slc);this.externalFltEls.push(slc);}else{fltcell.appendChild(slc);}
this.fltIds.push(this.prfxFlt+i+'_'+this.id);if(!this.fillSlcOnDemand)this._PopulateSelect(i);slc.onkeypress=this.Evt._DetectKey;slc.onchange=this.Evt._OnSlcChange;slc.onfocus=this.Evt._OnSlcFocus;slc.onblur=this.Evt._OnSlcBlur;if(this.fillSlcOnDemand)
{var opt0=tf_CreateOpt(this.displayAllText,'');slc.appendChild(opt0);}
if(this.fillSlcOnDemand&&tf_isIE)

{slc.disabled=true;slc.title=this.activateSlcTooltip;slc.parentNode.onclick=this.Evt._EnableSlc;if(this['col'+i]==this.fltTypeMulti)
this.__deferMultipleSelection(slc,0);}}
else if(this['col'+i]==this.fltTypeCheckList)
{var divCont=tf_CreateElm('div',['id',this.prfxCheckListDiv+i+'_'+this.id],['ct',i],['filled','0']);divCont.className=this.checkListDivCssClass;if(this.isExternalFlt&&this.externalFltTgtIds&&tf_Id(this.externalFltTgtIds[i]))
{tf_Id(this.externalFltTgtIds[i]).appendChild(divCont);this.externalFltEls.push(divCont);}else{fltcell.appendChild(divCont);}
this.checkListDiv[i]=divCont;this.fltIds.push(this.prfxFlt+i+'_'+this.id);if(!this.fillSlcOnDemand)this._PopulateCheckList(i);divCont.onclick=this.Evt._OnCheckListFocus;if(this.fillSlcOnDemand)
{divCont.onclick=this.Evt._OnCheckListClick;divCont.appendChild(tf_CreateText(this.activateCheckListTxt));}}
else
{var inptype;(this['col'+i]==this.fltTypeInp)?inptype='text':inptype='hidden';var inp=tf_CreateElm(this.fltTypeInp,['id',this.prfxFlt+i+'_'+this.id],['type',inptype],['ct',i]);if(inptype!='hidden')
inp.value=(this.isInpWatermarkArray)?this.inpWatermark[i]:this.inpWatermark;inp.className=inpclass;if(this.inpWatermark!='')tf_AddClass(inp,this.inpWatermarkCssClass);inp.onfocus=this.Evt._OnInpFocus;if(this.isExternalFlt&&this.externalFltTgtIds&&tf_Id(this.externalFltTgtIds[i]))
{tf_Id(this.externalFltTgtIds[i]).appendChild(inp);this.externalFltEls.push(inp);}else{fltcell.appendChild(inp);}
this.fltIds.push(this.prfxFlt+i+'_'+this.id);inp.onkeypress=this.Evt._DetectKey;inp.onkeydown=this.Evt._OnKeyDown;inp.onkeyup=this.Evt._OnKeyUp;inp.onblur=this.Evt._OnInpBlur;if(this.rememberGridValues)
{var flts=tf_ReadCookie(this.fltsValuesCookie);var reg=new RegExp(',','g');var flts_values=flts.split(reg);if(flts_values[i]!=' ')
this.SetFilterValue(i,flts_values[i],false);}}
if(i==n-1&&this.displayBtn)
{var btn=tf_CreateElm(this.fltTypeInp,['id',this.prfxValButton+i+'_'+this.id],['type','button'],['value',this.btnText]);btn.className=this.btnCssClass;if(this.isExternalFlt&&this.externalFltTgtIds&&tf_Id(this.externalFltTgtIds[i]))
tf_Id(this.externalFltTgtIds[i]).appendChild(btn);else
fltcell.appendChild(btn);btn.onclick=this.Evt._OnBtnClick;}}}else{this.__resetGrid();}}
if(this.rowsCounter)this.SetRowsCounter();if(this.statusBar)this.SetStatusBar();if(this.fixedHeaders&&!this.isFirstLoad)this.SetFixedHeaders();if(this.paging)this.SetPaging();if(this.hasResultsPerPage&&this.paging)this.SetResultsPerPage();if(this.btnReset)this.SetResetBtn();if(this.helpInstructions)this.SetHelpInstructions();if(this.hasColWidth&&!this.gridLayout)this.SetColWidths();if(this.alternateBgs&&this.isStartBgAlternate)
this.SetAlternateRows();if(this.hasColOperation&&this.fltGrid)
{this.colOperation=f.col_operation;this.SetColOperation();}
if(this.sort||this.gridLayout)this.SetSort();if(this.selectable||this.editable)this.SetEditable();if(this.hasBindScript)
{if(this.bindScript['src']!=undefined)
{var scriptPath=this.bindScript['src'];var scriptName=(this.bindScript['name']!=undefined)?this.bindScript['name']:'';this.IncludeFile(scriptName,scriptPath,this.bindScript['target_fn']);}}
this.isFirstLoad=false;this.hasGrid=true;if(this.rememberGridValues||this.rememberPageLen||this.rememberPageNb)
this.ResetValues();if(!this.gridLayout)tf_AddClass(this.tbl,this.prfxTf);if(this.loader)this.ShowLoader('none');if(this.hasExtensions)this.LoadExtensions();if(this.onFiltersLoaded)
this.onFiltersLoaded.call(null,this);},EvtManager:function(evt,s)
{var o=this;var slcIndex=(s!=undefined&&s.slcIndex!=undefined)?s.slcIndex:null;var slcExternal=(s!=undefined&&s.slcExternal!=undefined)?s.slcExternal:false;var slcId=(s!=undefined&&s.slcId!=undefined)?s.slcId:null;var pgIndex=(s!=undefined&&s.pgIndex!=undefined)?s.pgIndex:null;function efx(){if(evt!=undefined)
switch(evt)
{case o.Evt.name.filter:(o.isModFilterFn)?o.modFilterFn.call(null,o):o._Filter();break;case o.Evt.name.populateselect:(o.refreshFilters)?o._PopulateSelect(slcIndex,true):o._PopulateSelect(slcIndex,false,slcExternal,slcId);break;case o.Evt.name.populatechecklist:o._PopulateCheckList(slcIndex,slcExternal,slcId);break;case o.Evt.name.changepage:o._ChangePage(pgIndex);break;case o.Evt.name.clear:o._ClearFilters();o._Filter();break;case o.Evt.name.changeresultsperpage:o._ChangeResultsPerPage();break;case o.Evt.name.resetvalues:o._ResetValues();o._Filter();break;case o.Evt.name.resetpage:o._ResetPage(o.pgNbCookie);break;case o.Evt.name.resetpagelength:o._ResetPageLength(o.pgLenCookie);break;case o.Evt.name.sort:void(0);break;case o.Evt.name.loadextensions:o._LoadExtensions();break;case o.Evt.name.loadthemes:o._LoadThemes();break;default:o['_'+evt].call(null,o,s);break;}
if(o.status||o.statusBar)o.StatusMsg('');if(o.loader)o.ShowLoader('none');}
if(this.loader||this.status||this.statusBar)
{try{this.ShowLoader('');this.StatusMsg(o['msg'+evt]);}catch(e){}
window.setTimeout(efx,this.execDelay);}else efx();},ImportModule:function(module)
{if(!module.path||!module.name)return;this.IncludeFile(module.name,module.path,module.init);},LoadExtensions:function()
{if(!this.Ext){var o=this;this.Ext={list:{},add:function(extName,extDesc,extPath,extCallBack)
{var file=extPath.split('/')[extPath.split('/').length-1];var re=new RegExp(file);var path=extPath.replace(re,'');o.Ext.list[extName]={name:extName,description:extDesc,file:file,path:path,callback:extCallBack};}};}
this.EvtManager(this.Evt.name.loadextensions);},_LoadExtensions:function()
{if(!this.hasExtensions)return;if(tf_IsArray(this.extensions.name)&&tf_IsArray(this.extensions.src)){var ext=this.extensions;for(var e=0;e<ext.name.length;e++){var extPath=ext.src[e];var extName=ext.name[e];var extInit=(ext.initialize&&ext.initialize[e])?ext.initialize[e]:null;var extDesc=(ext.description&&ext.description[e])?ext.description[e]:null;this.Ext.add(extName,extDesc,extPath,extInit);if(tf_IsImported(extPath))extInit.call(null,this);else this.IncludeFile(extName,extPath,extInit);}}},LoadThemes:function()
{this.EvtManager(this.Evt.name.loadthemes);},_LoadThemes:function()
{if(!this.hasThemes)return;if(!this.Thm){var o=this;this.Thm={list:{},add:function(thmName,thmDesc,thmPath,thmCallBack)
{var file=thmPath.split('/')[thmPath.split('/').length-1];var re=new RegExp(file);var path=thmPath.replace(re,'');o.Thm.list[thmName]={name:thmName,description:thmDesc,file:file,path:path,callback:thmCallBack};}};}
if(this.enableDefaultTheme){this.themes={name:['DefaultTheme'],src:[this.themesPath+'Default/TF_Default.css'],description:['Default Theme']};this.Thm.add('DefaultTheme',this.themesPath+'Default/TF_Default.css','Default Theme');}
if(tf_IsArray(this.themes.name)&&tf_IsArray(this.themes.src)){var thm=this.themes;for(var i=0;i<thm.name.length;i++){var thmPath=thm.src[i];var thmName=thm.name[i];var thmInit=(thm.initialize&&thm.initialize[i])?thm.initialize[i]:null;var thmDesc=(thm.description&&thm.description[i])?thm.description[i]:null;this.Thm.add(thmName,thmDesc,thmPath,thmInit);if(!tf_IsImported(thmPath,'link'))
this.IncludeFile(thmName,thmPath,null,'link');if(tf_IsFn(thmInit))thmInit.call(null,this);}}
this.btnResetText=null;this.btnResetHtml='<input type="button" value="" class="'+this.btnResetCssClass+'" title="Clear filters" />';this.btnPrevPageHtml='<input type="button" value="" class="'+this.btnPageCssClass+' previousPage" title="Previous page" />';this.btnNextPageHtml='<input type="button" value="" class="'+this.btnPageCssClass+' nextPage" title="Next page" />';this.btnFirstPageHtml='<input type="button" value="" class="'+this.btnPageCssClass+' firstPage" title="First page" />';this.btnLastPageHtml='<input type="button" value="" class="'+this.btnPageCssClass+' lastPage" title="Last page" />';this.loader=true;this.loaderHtml='<div class="defaultLoader"></div>';this.loaderText=null;},RemoveGrid:function()
{if(this.fltGrid&&this.hasGrid)
{var rows=this.tbl.rows;if(this.paging)this.RemovePaging();if(this.statusBar)this.RemoveStatusBar();if(this.rowsCounter)this.RemoveRowsCounter();if(this.btnReset)this.RemoveResetBtn();if(this.helpInstructions||this.helpInstructions==null)this.RemoveHelpInstructions();if(this.paging)this.RemoveResultsPerPage();if(this.isExternalFlt&&!this.popUpFilters)this.RemoveExternalFlts();if(this.fixedHeaders)this.RemoveFixedHeaders();if(this.infDiv)this.RemoveTopDiv();if(this.highlightKeywords)this.UnhighlightAll();if(this.sort)this.RemoveSort();if(this.loader)this.RemoveLoader();if(this.popUpFilters)this.RemovePopupFilters();if(this.markActiveColumns)this.ClearActiveColumns();if(this.editable||this.selectable)this.RemoveEditable();for(var j=this.refRow;j<this.nbRows;j++)
{rows[j].style.display='';try
{if(rows[j].hasAttribute('validRow'))
rows[j].removeAttribute('validRow');}
catch(e){for(var x=0;x<rows[j].attributes.length;x++)
{if(rows[j].attributes[x].nodeName.tf_LCase()=='validrow')
rows[j].removeAttribute('validRow');}}
if(this.alternateBgs)this.RemoveRowBg(j);}
if(this.fltGrid&&!this.gridLayout)
{this.fltGridEl=rows[this.filtersRowIndex];this.tbl.deleteRow(this.filtersRowIndex);}
if(this.gridLayout)this.RemoveGridLayout();tf_RemoveClass(this.tbl,this.prfxTf);this.activeFlt=null;this.isStartBgAlternate=true;this.hasGrid=false;}},SetTopDiv:function()
{if(this.infDiv!=null)return;var infdiv=tf_CreateElm('div',['id',this.prfxInfDiv+this.id]);infdiv.className=this.infDivCssClass;if(this.toolBarTgtId)
tf_Id(this.toolBarTgtId).appendChild(infdiv);else if(this.fixedHeaders&&this.contDiv)
this.contDiv.parentNode.insertBefore(infdiv,this.contDiv);else if(this.gridLayout){this.tblMainCont.appendChild(infdiv);infdiv.className=this.gridInfDivCssClass;}
else
this.tbl.parentNode.insertBefore(infdiv,this.tbl);this.infDiv=tf_Id(this.prfxInfDiv+this.id);var ldiv=tf_CreateElm('div',['id',this.prfxLDiv+this.id]);ldiv.className=this.lDivCssClass;;infdiv.appendChild(ldiv);this.lDiv=tf_Id(this.prfxLDiv+this.id);var rdiv=tf_CreateElm('div',['id',this.prfxRDiv+this.id]);rdiv.className=this.rDivCssClass;infdiv.appendChild(rdiv);this.rDiv=tf_Id(this.prfxRDiv+this.id);var mdiv=tf_CreateElm('div',['id',this.prfxMDiv+this.id]);mdiv.className=this.mDivCssClass;infdiv.appendChild(mdiv);this.mDiv=tf_Id(this.prfxMDiv+this.id);if(this.helpInstructions==null)this.SetHelpInstructions();},RemoveTopDiv:function()
{if(this.infDiv==null)return;this.infDiv.parentNode.removeChild(this.infDiv);this.infDiv=null;},RemoveExternalFlts:function()
{if(!this.isExternalFlt&&!this.externalFltTgtIds)return;for(var ct=0;ct<this.externalFltTgtIds.length;ct++)
if(tf_Id(this.externalFltTgtIds[ct]))
tf_Id(this.externalFltTgtIds[ct]).innerHTML='';},SetLoader:function()
{if(this.loaderDiv!=null)return;var f=this.fObj;this.loaderTgtId=f.loader_target_id!=undefined?f.loader_target_id:null;this.loaderDiv=null;this.loaderText=f.loader_text!=undefined?f.loader_text:'Loading...';this.loaderHtml=f.loader_html!=undefined?f.loader_html:null;this.loaderCssClass=f.loader_css_class!=undefined?f.loader_css_class:'loader';this.loaderCloseDelay=200;this.onShowLoader=tf_IsFn(f.on_show_loader)?f.on_show_loader:null;this.onHideLoader=tf_IsFn(f.on_hide_loader)?f.on_hide_loader:null;var containerDiv=tf_CreateElm('div',['id',this.prfxLoader+this.id]);containerDiv.className=this.loaderCssClass;var targetEl=(this.loaderTgtId==null)?(this.gridLayout?this.tblCont:this.tbl.parentNode):tf_Id(this.loaderTgtId);if(this.loaderTgtId==null)targetEl.insertBefore(containerDiv,this.tbl);else targetEl.appendChild(containerDiv);this.loaderDiv=tf_Id(this.prfxLoader+this.id);if(this.loaderHtml==null)
this.loaderDiv.appendChild(tf_CreateText(this.loaderText));else this.loaderDiv.innerHTML=this.loaderHtml;},RemoveLoader:function()
{if(this.loaderDiv==null)return;var targetEl=(this.loaderTgtId==null)?(this.gridLayout?this.tblCont:this.tbl.parentNode):tf_Id(this.loaderTgtId);targetEl.removeChild(this.loaderDiv);this.loaderDiv=null;},ShowLoader:function(p)
{if(!this.loader||!this.loaderDiv)return;if(this.loaderDiv.style.display==p)return;var o=this;function displayLoader(){if(!o.loaderDiv)return;if(o.onShowLoader&&p!='none')
o.onShowLoader.call(null,o);o.loaderDiv.style.display=p;if(o.onHideLoader&&p=='none')
o.onHideLoader.call(null,o);}
var t=(p=='none')?this.loaderCloseDelay:1;window.setTimeout(displayLoader,t);},SetSort:function()
{var fn=this.Evt._EnableSort;if(!tf_IsFn(fn)){var o=this;this.Evt._EnableSort=function()
{if(o.isSortEnabled&&!o.gridLayout)return;if(tf_IsImported(o.sortConfig.adapterSrc))
o.sortConfig.initialize.call(null,o);else
o.IncludeFile(o.sortConfig.name+'_adapter',o.sortConfig.adapterSrc,function(){o.sortConfig.initialize.call(null,o);});}}
if(tf_IsImported(this.sortConfig.src))
this.Evt._EnableSort();else
this.IncludeFile(this.sortConfig.name,this.sortConfig.src,this.Evt._EnableSort);},RemoveSort:function()
{if(!this.sort)return;this.sort=false;},Sort:function()
{this.EvtManager(this.Evt.name.sort);},SetEditable:function()
{if(tf_IsImported(this.ezEditTableConfig.src)){this._EnableEditable();}else{this.IncludeFile(this.ezEditTableConfig.name,this.ezEditTableConfig.src,this._EnableEditable);}
if(this.ezEditTableConfig.loadStylesheet&&!tf_IsImported(this.ezEditTableConfig.stylesheet,'link')){this.IncludeFile(this.ezEditTableConfig.stylesheetName,this.ezEditTableConfig.stylesheet,null,'link');}},RemoveEditable:function()
{if(this.ezEditTable){if(this.selectable){this.ezEditTable.Selection.ClearSelections();this.ezEditTable.Selection.Remove();}
if(this.editable)this.ezEditTable.Editable.Remove();}},ResetEditable:function()
{if(this.ezEditTable){if(this.selectable)this.ezEditTable.Selection.Set();if(this.editable)this.ezEditTable.Editable.Set();}},_EnableEditable:function(o)
{if(!o)o=this;var startRow;var thead=tf_Tag(o.tbl,'thead');if(thead.length>0&&!o.ezEditTableConfig.startRow)startRow=undefined;else startRow=o.ezEditTableConfig.startRow||o.refRow;o.ezEditTableConfig.scroll_into_view=o.ezEditTableConfig.scroll_into_view!=undefined?o.ezEditTableConfig.scroll_into_view:true;o.ezEditTableConfig.base_path=o.ezEditTableConfig.base_path!=undefined?o.ezEditTableConfig.base_path:o.basePath+'ezEditTable/';o.ezEditTableConfig.editable=o.editable=o.fObj.editable;o.ezEditTableConfig.selection=o.selectable=o.fObj.selectable;if(o.selectable)
o.ezEditTableConfig.default_selection=o.ezEditTableConfig.default_selection!=undefined?o.ezEditTableConfig.default_selection:'row';o.ezEditTableConfig.active_cell_css=o.ezEditTableConfig.active_cell_css!=undefined?o.ezEditTableConfig.active_cell_css:'ezETSelectedCell';o._lastValidRowIndex=0;o._lastRowIndex=0;if(o.selectable){function onAfterSelection(et,selecteElm,e){if(!o.validRowsIndex)return;var row=et.defaultSelection!='row'?selecteElm.parentNode:selecteElm;var cell=selecteElm.nodeName=='TD'?selecteElm:null;var keyCode=e!=undefined?et.Event.GetKey(e):0;var isRowValid=o.validRowsIndex.tf_Has(row.rowIndex);var nextRowIndex;var d=(keyCode==34||keyCode==33?(o.pagingLength||et.nbRowsPerPage):1);if(!isRowValid){if(row.rowIndex>o._lastRowIndex){if(row.rowIndex>=o.validRowsIndex[o.validRowsIndex.length-1])
nextRowIndex=o.validRowsIndex[o.validRowsIndex.length-1];else{var calcRowIndex=(o._lastValidRowIndex+d);if(calcRowIndex>(o.validRowsIndex.length-1))
nextRowIndex=o.validRowsIndex[o.validRowsIndex.length-1];else nextRowIndex=o.validRowsIndex[calcRowIndex];}}else{if(row.rowIndex<=o.validRowsIndex[0])nextRowIndex=o.validRowsIndex[0];else{var v=o.validRowsIndex[o._lastValidRowIndex-d];nextRowIndex=v?v:o.validRowsIndex[0];}}
o._lastRowIndex=row.rowIndex;DoSelection(nextRowIndex);}else{if(keyCode!=34&&keyCode!=33){o._lastValidRowIndex=o.validRowsIndex.tf_IndexByValue(row.rowIndex);o._lastRowIndex=row.rowIndex;}else{if(keyCode==34){if((o._lastValidRowIndex+d)<=(o.validRowsIndex.length-1))
nextRowIndex=o.validRowsIndex[o._lastValidRowIndex+d];else nextRowIndex=o.validRowsIndex[o.validRowsIndex.length-1];}else{if((o._lastValidRowIndex-d)<=(o.validRowsIndex[0]))
nextRowIndex=o.validRowsIndex[0];else nextRowIndex=o.validRowsIndex[o._lastValidRowIndex-d];}
o._lastRowIndex=nextRowIndex;o._lastValidRowIndex=o.validRowsIndex.tf_IndexByValue(nextRowIndex);DoSelection(nextRowIndex);}}
function DoSelection(nextRowIndex){if(et.defaultSelection=='row'){et.Selection.SelectRowByIndex(nextRowIndex);}else{et.ClearSelections();var cellIndex=selecteElm.cellIndex;var row=o.tbl.rows[nextRowIndex];if(et.defaultSelection=='both')et.Selection.SelectRowByIndex(nextRowIndex);if(row)et.Selection.SelectCell(row.cells[cellIndex]);}
if(o.validRowsIndex.length!=o.GetRowsNb()){var row=o.tbl.rows[nextRowIndex];if(row)row.scrollIntoView(false);if(cell){if(cell.cellIndex==(o.GetCellsNb()-1)&&o.gridLayout)o.tblCont.scrollLeft=100000000;else if(cell.cellIndex==0&&o.gridLayout)o.tblCont.scrollLeft=0;else cell.scrollIntoView(false);}}}}
function onBeforeSelection(et,selecteElm,e){var row=et.defaultSelection!='row'?selecteElm.parentNode:selecteElm;if(o.paging){if(o.nbPages>1){et.nbRowsPerPage=o.pagingLength;var pagingEndRow=parseInt(o.startPagingRow)+parseInt(o.pagingLength);var rowIndex=row.rowIndex;if((rowIndex==o.validRowsIndex[o.validRowsIndex.length-1])&&o.currentPageNb!=o.nbPages)o.SetPage('last');else if((rowIndex==o.validRowsIndex[0])&&o.currentPageNb!=1)o.SetPage('first');else if(rowIndex>o.validRowsIndex[pagingEndRow-1]&&rowIndex<o.validRowsIndex[o.validRowsIndex.length-1])o.SetPage('next');else if(rowIndex<o.validRowsIndex[o.startPagingRow]&&rowIndex>o.validRowsIndex[0])o.SetPage('previous');}}}
if(o.paging){o.onAfterChangePage=function(tf,i){var row=tf.ezEditTable.Selection.GetActiveRow();if(row)row.scrollIntoView(false);var cell=tf.ezEditTable.Selection.GetActiveCell();if(cell)cell.scrollIntoView(false);}}
if(o.ezEditTableConfig.default_selection=='row'){var fnB=o.ezEditTableConfig.on_before_selected_row;o.ezEditTableConfig.on_before_selected_row=function(){onBeforeSelection(arguments[0],arguments[1],arguments[2]);if(fnB)fnB.call(null,arguments[0],arguments[1],arguments[2]);};var fnA=o.ezEditTableConfig.on_after_selected_row;o.ezEditTableConfig.on_after_selected_row=function(){onAfterSelection(arguments[0],arguments[1],arguments[2]);if(fnA)fnA.call(null,arguments[0],arguments[1],arguments[2]);};}else{var fnB=o.ezEditTableConfig.on_before_selected_cell;o.ezEditTableConfig.on_before_selected_cell=function(){onBeforeSelection(arguments[0],arguments[1],arguments[2]);if(fnB)fnB.call(null,arguments[0],arguments[1],arguments[2]);};var fnA=o.ezEditTableConfig.on_after_selected_cell;o.ezEditTableConfig.on_after_selected_cell=function(){onAfterSelection(arguments[0],arguments[1],arguments[2]);if(fnA)fnA.call(null,arguments[0],arguments[1],arguments[2]);};}}
if(o.editable){var fnC=o.ezEditTableConfig.on_added_dom_row;o.ezEditTableConfig.on_added_dom_row=function(){o.nbFilterableRows++;if(!o.paging){o.RefreshNbRows();}
else{o.nbRows++;o.nbVisibleRows++;o.nbFilterableRows++;o.paging=false;o.RemovePaging();o.AddPaging(false);}
if(o.alternateBgs)o.SetAlternateRows();if(fnC)fnC.call(null,arguments[0],arguments[1],arguments[2]);};if(o.ezEditTableConfig.actions&&o.ezEditTableConfig.actions['delete']){var fnD=o.ezEditTableConfig.actions['delete'].on_after_submit;o.ezEditTableConfig.actions['delete'].on_after_submit=function(){o.nbFilterableRows--;if(!o.paging){o.RefreshNbRows();}
else{o.nbRows--;o.nbVisibleRows--;o.nbFilterableRows--;o.paging=false;o.RemovePaging();o.AddPaging(false);}
if(o.alternateBgs)o.SetAlternateRows();if(fnD)fnD.call(null,arguments[0],arguments[1]);}}}
o.ezEditTable=new EditTable(o.id,o.ezEditTableConfig,startRow);o.ezEditTable.Init();},SetPaging:function()
{if(!this.hasGrid&&!this.isFirstLoad)return;if(!this.paging||(!this.isPagingRemoved&&!this.isFirstLoad))return;var f=this.fObj;this.pagingTgtId=f.paging_target_id!=undefined?f.paging_target_id:null;this.pagingLength=f.paging_length!=undefined?f.paging_length:10;this.resultsPerPageTgtId=f.results_per_page_target_id!=undefined?f.results_per_page_target_id:null;this.pgSlcCssClass=f.paging_slc_css_class!=undefined?f.paging_slc_css_class:'pgSlc';this.pgInpCssClass=f.paging_inp_css_class!=undefined?f.paging_inp_css_class:'pgNbInp';this.resultsSlcCssClass=f.results_slc_css_class!=undefined?f.results_slc_css_class:'rspg';this.resultsSpanCssClass=f.results_span_css_class!=undefined?f.results_span_css_class:'rspgSpan';this.nbVisibleRows=0;this.nbHiddenRows=0;this.startPagingRow=0;this.nbPages=0;this.btnNextPageText=f.btn_next_page_text!=undefined?f.btn_next_page_text:'>';this.btnPrevPageText=f.btn_prev_page_text!=undefined?f.btn_prev_page_text:'<';this.btnLastPageText=f.btn_last_page_text!=undefined?f.btn_last_page_text:'>|';this.btnFirstPageText=f.btn_first_page_text!=undefined?f.btn_first_page_text:'|<';this.btnNextPageHtml=f.btn_next_page_html!=undefined?f.btn_next_page_html:(!this.enableIcons?null:'<input type="button" value="" class="'+this.btnPageCssClass+' nextPage" title="Next page" />');this.btnPrevPageHtml=f.btn_prev_page_html!=undefined?f.btn_prev_page_html:(!this.enableIcons?null:'<input type="button" value="" class="'+this.btnPageCssClass+' previousPage" title="Previous page" />');this.btnFirstPageHtml=f.btn_first_page_html!=undefined?f.btn_first_page_html:(!this.enableIcons?null:'<input type="button" value="" class="'+this.btnPageCssClass+' firstPage" title="First page" />');this.btnLastPageHtml=f.btn_last_page_html!=undefined?f.btn_last_page_html:(!this.enableIcons?null:'<input type="button" value="" class="'+this.btnPageCssClass+' lastPage" title="Last page" />');this.btnPageCssClass=f.paging_btn_css_class!=undefined?f.paging_btn_css_class:'pgInp';this.nbPgSpanCssClass=f.nb_pages_css_class!=undefined?f.nb_pages_css_class:'nbpg';this.hasPagingBtns=f.paging_btns==false?false:true;this.pagingBtnEvents=null;this.pageSelectorType=f.page_selector_type!=undefined?f.page_selector_type:this.fltTypeSlc;this.onBeforeChangePage=tf_IsFn(f.on_before_change_page)?f.on_before_change_page:null;this.onAfterChangePage=tf_IsFn(f.on_after_change_page)?f.on_after_change_page:null;var start_row=this.refRow;var nrows=this.nbRows;this.nbPages=Math.ceil((nrows-start_row)/this.pagingLength);if(!this.Evt._Paging.next)
{var o=this;this.Evt._Paging={slcIndex:function(){return(o.pageSelectorType==o.fltTypeSlc)?o.pagingSlc.options.selectedIndex:parseInt(o.pagingSlc.value)-1;},nbOpts:function(){return(o.pageSelectorType==o.fltTypeSlc)?parseInt(o.pagingSlc.options.length)-1:(o.nbPages-1);},next:function(){if(o.Evt._Paging.nextEvt)o.Evt._Paging.nextEvt();var nextIndex=(o.Evt._Paging.slcIndex()<o.Evt._Paging.nbOpts())?o.Evt._Paging.slcIndex()+1:0;o.ChangePage(nextIndex);},prev:function(){if(o.Evt._Paging.prevEvt)o.Evt._Paging.prevEvt();var prevIndex=o.Evt._Paging.slcIndex()>0?o.Evt._Paging.slcIndex()-1:o.Evt._Paging.nbOpts();o.ChangePage(prevIndex);},last:function(){if(o.Evt._Paging.lastEvt)o.Evt._Paging.lastEvt();o.ChangePage(o.Evt._Paging.nbOpts());},first:function(){if(o.Evt._Paging.firstEvt)o.Evt._Paging.firstEvt();o.ChangePage(0);},_detectKey:function(e)
{var evt=(e)?e:(window.event)?window.event:null;if(evt)
{var key=(evt.charCode)?evt.charCode:((evt.keyCode)?evt.keyCode:((evt.which)?evt.which:0));if(key=='13'){if(o.sorted){o.Filter();o.ChangePage(o.Evt._Paging.slcIndex());}
else o.ChangePage();this.blur();}}},nextEvt:null,prevEvt:null,lastEvt:null,firstEvt:null}}
if(!this.Evt._OnSlcPagesChange)
{this.Evt._OnSlcPagesChange=function()
{if(o.Evt._Paging._OnSlcPagesChangeEvt)
o.Evt._Paging._OnSlcPagesChangeEvt();o.ChangePage();this.blur();if(this.parentNode&&tf_isIE)
this.parentNode.focus();}}
if(this.pageSelectorType==this.fltTypeSlc)
{var slcPages=tf_CreateElm(this.fltTypeSlc,['id',this.prfxSlcPages+this.id]);slcPages.className=this.pgSlcCssClass;slcPages.onchange=this.Evt._OnSlcPagesChange;}
if(this.pageSelectorType==this.fltTypeInp)
{var slcPages=tf_CreateElm(this.fltTypeInp,['id',this.prfxSlcPages+this.id],['value',this.currentPageNb]);slcPages.className=this.pgInpCssClass;slcPages.onkeypress=this.Evt._Paging._detectKey;}
var btnNextSpan,btnPrevSpan,btnLastSpan,btnFirstSpan;btnNextSpan=tf_CreateElm('span',['id',this.prfxBtnNextSpan+this.id]);btnPrevSpan=tf_CreateElm('span',['id',this.prfxBtnPrevSpan+this.id]);btnLastSpan=tf_CreateElm('span',['id',this.prfxBtnLastSpan+this.id]);btnFirstSpan=tf_CreateElm('span',['id',this.prfxBtnFirstSpan+this.id]);if(this.hasPagingBtns)
{if(this.btnNextPageHtml==null)
{var btn_next=tf_CreateElm(this.fltTypeInp,['id',this.prfxBtnNext+this.id],['type','button'],['value',this.btnNextPageText],['title','Next']);btn_next.className=this.btnPageCssClass;btn_next.onclick=this.Evt._Paging.next;btnNextSpan.appendChild(btn_next);}else{btnNextSpan.innerHTML=this.btnNextPageHtml;btnNextSpan.onclick=this.Evt._Paging.next;}
if(this.btnPrevPageHtml==null)
{var btn_prev=tf_CreateElm(this.fltTypeInp,['id',this.prfxBtnPrev+this.id],['type','button'],['value',this.btnPrevPageText],['title','Previous']);btn_prev.className=this.btnPageCssClass;btn_prev.onclick=this.Evt._Paging.prev;btnPrevSpan.appendChild(btn_prev);}else{btnPrevSpan.innerHTML=this.btnPrevPageHtml;btnPrevSpan.onclick=this.Evt._Paging.prev;}
if(this.btnLastPageHtml==null)
{var btn_last=tf_CreateElm(this.fltTypeInp,['id',this.prfxBtnLast+this.id],['type','button'],['value',this.btnLastPageText],['title','Last']);btn_last.className=this.btnPageCssClass;btn_last.onclick=this.Evt._Paging.last;btnLastSpan.appendChild(btn_last);}else{btnLastSpan.innerHTML=this.btnLastPageHtml;btnLastSpan.onclick=this.Evt._Paging.last;}
if(this.btnFirstPageHtml==null)
{var btn_first=tf_CreateElm(this.fltTypeInp,['id',this.prfxBtnFirst+this.id],['type','button'],['value',this.btnFirstPageText],['title','First']);btn_first.className=this.btnPageCssClass;btn_first.onclick=this.Evt._Paging.first;btnFirstSpan.appendChild(btn_first);}else{btnFirstSpan.innerHTML=this.btnFirstPageHtml;btnFirstSpan.onclick=this.Evt._Paging.first;}}
if(this.pagingTgtId==null)this.SetTopDiv();var targetEl=(this.pagingTgtId==null)?this.mDiv:tf_Id(this.pagingTgtId);if(targetEl.innerHTML!='')targetEl.innerHTML='';targetEl.appendChild(btnPrevSpan);targetEl.appendChild(btnFirstSpan);var pgBeforeSpan=tf_CreateElm('span',['id',this.prfxPgBeforeSpan+this.id]);pgBeforeSpan.appendChild(tf_CreateText(' Page '));pgBeforeSpan.className=this.nbPgSpanCssClass;targetEl.appendChild(pgBeforeSpan);targetEl.appendChild(slcPages);var pgAfterSpan=tf_CreateElm('span',['id',this.prfxPgAfterSpan+this.id]);pgAfterSpan.appendChild(tf_CreateText(' of '));pgAfterSpan.className=this.nbPgSpanCssClass;targetEl.appendChild(pgAfterSpan)
var pgspan=tf_CreateElm('span',['id',this.prfxPgSpan+this.id]);pgspan.className=this.nbPgSpanCssClass;pgspan.appendChild(tf_CreateText(' '+this.nbPages+' '));targetEl.appendChild(pgspan);targetEl.appendChild(btnLastSpan);targetEl.appendChild(btnNextSpan);this.pagingSlc=tf_Id(this.prfxSlcPages+this.id);if(!this.rememberGridValues||this.isPagingRemoved)
this.SetPagingInfo();if(!this.fltGrid)
{this.ValidateAllRows();this.SetPagingInfo(this.validRowsIndex);}
this.pagingBtnEvents=this.Evt._Paging;this.isPagingRemoved=false;},RemovePaging:function()
{if(!this.hasGrid)return;if(this.pagingSlc==null)return;var btnNextSpan,btnPrevSpan,btnLastSpan,btnFirstSpan;var pgBeforeSpan,pgAfterSpan,pgspan;btnNextSpan=tf_Id(this.prfxBtnNextSpan+this.id);btnPrevSpan=tf_Id(this.prfxBtnPrevSpan+this.id);btnLastSpan=tf_Id(this.prfxBtnLastSpan+this.id);btnFirstSpan=tf_Id(this.prfxBtnFirstSpan+this.id);pgBeforeSpan=tf_Id(this.prfxPgBeforeSpan+this.id);pgAfterSpan=tf_Id(this.prfxPgAfterSpan+this.id);pgspan=tf_Id(this.prfxPgSpan+this.id);this.pagingSlc.parentNode.removeChild(this.pagingSlc);if(btnNextSpan!=null)
btnNextSpan.parentNode.removeChild(btnNextSpan);if(btnPrevSpan!=null)
btnPrevSpan.parentNode.removeChild(btnPrevSpan);if(btnLastSpan!=null)
btnLastSpan.parentNode.removeChild(btnLastSpan);if(btnFirstSpan!=null)
btnFirstSpan.parentNode.removeChild(btnFirstSpan);if(pgBeforeSpan!=null)
pgBeforeSpan.parentNode.removeChild(pgBeforeSpan);if(pgAfterSpan!=null)
pgAfterSpan.parentNode.removeChild(pgAfterSpan);if(pgspan!=null)
pgspan.parentNode.removeChild(pgspan);this.pagingBtnEvents=null;this.pagingSlc=null;this.isPagingRemoved=true;},SetPagingInfo:function(validRows)
{var row=this.tbl.rows;var mdiv=(this.pagingTgtId==null)?this.mDiv:tf_Id(this.pagingTgtId);var pgspan=tf_Id(this.prfxPgSpan+this.id);if(validRows!=undefined)this.validRowsIndex=validRows;else
{this.validRowsIndex=[];for(var j=this.refRow;j<this.nbRows;j++)
{if(!row[j])continue;var isRowValid=row[j].getAttribute('validRow');if(isRowValid=='true'||isRowValid==null)
this.validRowsIndex.push(j);}}
this.nbPages=Math.ceil(this.validRowsIndex.length/this.pagingLength);pgspan.innerHTML=this.nbPages;if(this.pageSelectorType==this.fltTypeSlc)
this.pagingSlc.innerHTML='';if(this.nbPages>0)
{mdiv.style.visibility='visible';if(this.pageSelectorType==this.fltTypeSlc)
for(var z=0;z<this.nbPages;z++)
{var currOpt=new Option((z+1),z*this.pagingLength,false,false);this.pagingSlc.options[z]=currOpt;}
else this.pagingSlc.value=this.currentPageNb;}else{mdiv.style.visibility='hidden';}
this.GroupByPage(this.validRowsIndex);},GroupByPage:function(validRows)
{var row=this.tbl.rows;var paging_end_row=parseInt(this.startPagingRow)+parseInt(this.pagingLength);if(validRows!=undefined)this.validRowsIndex=validRows;for(h=0;h<this.validRowsIndex.length;h++)
{if(h>=this.startPagingRow&&h<paging_end_row)
{var r=row[this.validRowsIndex[h]];if(r.getAttribute('validRow')=='true'||r.getAttribute('validRow')==undefined)
r.style.display='';if(this.alternateBgs)this.SetRowBg(this.validRowsIndex[h],h);}else{row[this.validRowsIndex[h]].style.display='none';if(this.alternateBgs)this.RemoveRowBg(this.validRowsIndex[h]);}}
this.nbVisibleRows=this.validRowsIndex.length;this.isStartBgAlternate=false;this.ApplyGridProps();},SetPage:function(cmd)
{if(this.hasGrid&&this.paging)
{var btnEvt=this.pagingBtnEvents,cmdtype=typeof cmd;if(cmdtype=='string')
{switch(cmd.tf_LCase())
{case'next':btnEvt.next();break;case'previous':btnEvt.prev();break;case'last':btnEvt.last();break;case'first':btnEvt.first();break;default:btnEvt.next();break;}}
if(cmdtype=='number')this.ChangePage((cmd-1));}},SetResultsPerPage:function()
{if(!this.hasGrid&&!this.isFirstLoad)return;if(this.resultsPerPageSlc!=null||this.resultsPerPage==null)return;if(!this.Evt._OnSlcResultsChange)
{var o=this;this.Evt._OnSlcResultsChange=function()
{o.ChangeResultsPerPage();this.blur();if(this.parentNode&&tf_isIE)
this.parentNode.focus();}}
var slcR=tf_CreateElm(this.fltTypeSlc,['id',this.prfxSlcResults+this.id]);slcR.className=this.resultsSlcCssClass;var slcRText=this.resultsPerPage[0],slcROpts=this.resultsPerPage[1];var slcRSpan=tf_CreateElm('span',['id',this.prfxSlcResultsTxt+this.id]);slcRSpan.className=this.resultsSpanCssClass;if(this.resultsPerPageTgtId==null)this.SetTopDiv();var targetEl=(this.resultsPerPageTgtId==null)?this.rDiv:tf_Id(this.resultsPerPageTgtId);slcRSpan.appendChild(tf_CreateText(slcRText));targetEl.appendChild(slcRSpan);targetEl.appendChild(slcR);this.resultsPerPageSlc=tf_Id(this.prfxSlcResults+this.id);for(var r=0;r<slcROpts.length;r++)
{var currOpt=new Option(slcROpts[r],slcROpts[r],false,false);this.resultsPerPageSlc.options[r]=currOpt;}
slcR.onchange=this.Evt._OnSlcResultsChange;},RemoveResultsPerPage:function()
{if(!this.hasGrid)return;if(this.resultsPerPageSlc==null||this.resultsPerPage==null)return;var slcR,slcRSpan;slcR=this.resultsPerPageSlc;slcRSpan=tf_Id(this.prfxSlcResultsTxt+this.id);if(slcR!=null)
slcR.parentNode.removeChild(slcR);if(slcRSpan!=null)
slcRSpan.parentNode.removeChild(slcRSpan);this.resultsPerPageSlc=null;},SetHelpInstructions:function()
{if(this.helpInstrBtnEl!=null)return;var f=this.fObj;this.helpInstrTgtId=f.help_instructions_target_id!=undefined?f.help_instructions_target_id:null;this.helpInstrContTgtId=f.help_instructions_container_target_id!=undefined?f.help_instructions_container_target_id:null;this.helpInstrText=f.help_instructions_text?f.help_instructions_text:'Use the filters above each column to filter and limit table data.';this.helpInstrHtml=f.help_instructions_html!=undefined?f.help_instructions_html:null;this.helpInstrBtnText=f.help_instructions_btn_text!=undefined?f.help_instructions_btn_text:'?';this.helpInstrBtnHtml=f.help_instructions_btn_html!=undefined?f.help_instructions_btn_html:null;this.helpInstrBtnCssClass=f.help_instructions_btn_css_class!=undefined?f.help_instructions_btn_css_class:'helpBtn';this.helpInstrContCssClass=f.help_instructions_container_css_class!=undefined?f.help_instructions_container_css_class:'helpCont';this.helpInstrBtnEl=null;this.helpInstrContEl=null;this.helpInstrDefaultHtml='<div class="helpFooter"><span>HTML Table Filter Generator</span> <span>v. '+this.version+'</span><br/>'+'<a href="http://tablefilter.free.fr" target="_blank">http://tablefilter.free.fr</a><br/>'+'<span>&copy;2009-2011 Max Guglielmi.</span><div align="center" style="margin-top:8px;">'+'<a href="javascript:;" onclick="window[\'tf_'+this.id+'\']._ToggleHelp();">Close</a></div></div>';var helpspan=tf_CreateElm('span',['id',this.prfxHelpSpan+this.id]);var helpdiv=tf_CreateElm('div',['id',this.prfxHelpDiv+this.id]);if(this.helpInstrTgtId==null)this.SetTopDiv();var targetEl=(this.helpInstrTgtId==null)?this.rDiv:tf_Id(this.helpInstrTgtId);targetEl.appendChild(helpspan);var divContainer=(this.helpInstrContTgtId==null)?helpspan:tf_Id(this.helpInstrContTgtId);if(this.helpInstrBtnHtml==null)
{divContainer.appendChild(helpdiv);var helplink=tf_CreateElm('a',['href','javascript:void(0);']);helplink.className=this.helpInstrBtnCssClass;helplink.appendChild(tf_CreateText(this.helpInstrBtnText));helpspan.appendChild(helplink);helplink.onclick=this.Evt._OnHelpBtnClick;}else{helpspan.innerHTML=this.helpInstrBtnHtml;var helpEl=helpspan.firstChild;helpEl.onclick=this.Evt._OnHelpBtnClick;divContainer.appendChild(helpdiv);}
if(this.helpInstrHtml==null)
{helpdiv.appendChild(tf_CreateText(this.helpInstrText));helpdiv.className=this.helpInstrContCssClass;helpdiv.ondblclick=this.Evt._OnHelpBtnClick;}else{if(this.helpInstrContTgtId)divContainer.appendChild(helpdiv);helpdiv.innerHTML=this.helpInstrHtml;if(!this.helpInstrContTgtId){helpdiv.className=this.helpInstrContCssClass;helpdiv.ondblclick=this.Evt._OnHelpBtnClick;}}
helpdiv.innerHTML+=this.helpInstrDefaultHtml;this.helpInstrContEl=helpdiv;this.helpInstrBtnEl=helpspan;},RemoveHelpInstructions:function()
{if(this.helpInstrBtnEl==null)return;this.helpInstrBtnEl.parentNode.removeChild(this.helpInstrBtnEl);this.helpInstrBtnEl=null;if(this.helpInstrContEl==null)return;this.helpInstrContEl.parentNode.removeChild(this.helpInstrContEl);this.helpInstrContEl=null;},_ToggleHelp:function()
{if(!this.helpInstrContEl)return;var divDisplay=this.helpInstrContEl.style.display;if(divDisplay==''||divDisplay=='none'){this.helpInstrContEl.style.display='block';var btnLeft=tf_ObjPosition(this.helpInstrBtnEl,[this.helpInstrBtnEl.nodeName])[0];if(!this.helpInstrContTgtId)
this.helpInstrContEl.style.left=(btnLeft-this.helpInstrContEl.clientWidth+25)+'px';}
else this.helpInstrContEl.style.display='none';},ChangePage:function(index)
{this.EvtManager(this.Evt.name.changepage,{pgIndex:index});},_ChangePage:function(index)
{if(!this.paging)return;if(index==undefined)
index=(this.pageSelectorType==this.fltTypeSlc)?this.pagingSlc.options.selectedIndex:(this.pagingSlc.value-1);if(index>=0&&index<=(this.nbPages-1))
{if(this.onBeforeChangePage)this.onBeforeChangePage.call(null,this,index);this.currentPageNb=parseInt(index)+1;if(this.pageSelectorType==this.fltTypeSlc)
this.pagingSlc.options[index].selected=true;else
this.pagingSlc.value=this.currentPageNb;if(this.rememberPageNb)this.RememberPageNb(this.pgNbCookie);this.startPagingRow=(this.pageSelectorType==this.fltTypeSlc)?this.pagingSlc.value:(index*this.pagingLength);this.GroupByPage();if(this.onAfterChangePage)this.onAfterChangePage.call(null,this,index);}},ChangeResultsPerPage:function()
{this.EvtManager(this.Evt.name.changeresultsperpage);},_ChangeResultsPerPage:function()
{if(!this.paging)return;var slcR=this.resultsPerPageSlc;var slcPagesSelIndex=(this.pageSelectorType==this.fltTypeSlc)?this.pagingSlc.selectedIndex:parseInt(this.pagingSlc.value-1);this.pagingLength=parseInt(slcR.options[slcR.selectedIndex].value);this.startPagingRow=this.pagingLength*slcPagesSelIndex;if(!isNaN(this.pagingLength))
{if(this.startPagingRow>=this.nbFilterableRows)
this.startPagingRow=(this.nbFilterableRows-this.pagingLength);this.SetPagingInfo();if(this.pageSelectorType==this.fltTypeSlc)
{var slcIndex=(this.pagingSlc.options.length-1<=slcPagesSelIndex)?(this.pagingSlc.options.length-1):slcPagesSelIndex;this.pagingSlc.options[slcIndex].selected=true;}
if(this.rememberPageLen)this.RememberPageLength(this.pgLenCookie);}},ResetPage:function(name)
{this.EvtManager(this.Evt.name.resetpage);},_ResetPage:function(name)
{var pgnb=tf_ReadCookie(name);if(pgnb!='')
this.ChangePage((pgnb-1));},ResetPageLength:function(name)
{this.EvtManager(this.Evt.name.resetpagelength);},_ResetPageLength:function(name)
{if(!this.paging)return;var pglenIndex=tf_ReadCookie(name);if(pglenIndex!='')
{this.resultsPerPageSlc.options[pglenIndex].selected=true;this.ChangeResultsPerPage();}},AddPaging:function(filterTable)
{if(!this.hasGrid||this.paging)return;this.paging=true;this.isPagingRemoved=true;this.SetPaging();if(filterTable)this.Filter();},PopulateSelect:function(colIndex,isExternal,extSlcId)
{this.EvtManager(this.Evt.name.populateselect,{slcIndex:colIndex,slcExternal:isExternal,slcId:extSlcId});},_PopulateSelect:function(colIndex,isRefreshed,isExternal,extSlcId)
{isExternal=(isExternal==undefined)?false:isExternal;var slcId=this.fltIds[colIndex];if(tf_Id(slcId)==null&&!isExternal)return;if(tf_Id(extSlcId)==null&&isExternal)return;var slc=(!isExternal)?tf_Id(slcId):tf_Id(extSlcId);var o=this,row=this.tbl.rows;var fillMethod=this.slcFillingMethod.tf_LCase();var optArray=[],slcInnerHtml='',opt0;var isCustomSlc=(this.hasCustomSlcOptions&&this.customSlcOptions.cols.tf_Has(colIndex));var optTxt=[];var activeFlt;if(isRefreshed&&this.activeFilterId){activeFlt=this.activeFilterId.split('_')[0];activeFlt=activeFlt.split(this.prfxFlt)[1];}
var flts_values=[],fltArr=[];if(this.rememberGridValues)
{flts_values=tf_CookieValueArray(this.fltsValuesCookie);fltArr=(flts_values[colIndex]!=undefined)?flts_values[colIndex].split(' '+this.orOperator+' '):flts_values[colIndex]=[];}
for(var k=this.refRow;k<this.nbRows;k++)
{if(this.hasVisibleRows&&this.visibleRows.tf_Has(k)&&!this.paging)
continue;var cell=row[k].cells;var nchilds=cell.length;if(nchilds==this.nbCells&&!isCustomSlc)
{for(var j=0;j<nchilds;j++)
{if((colIndex==j&&!isRefreshed)||(colIndex==j&&isRefreshed&&((row[k].style.display==''&&!this.paging)||(this.paging&&(!this.validRowsIndex||(this.validRowsIndex&&this.validRowsIndex.tf_Has(k)))&&((activeFlt==undefined||activeFlt==colIndex)||(activeFlt!=colIndex&&this.validRowsIndex.tf_Has(k)))))))
{var cell_data=this.GetCellData(j,cell[j]);var cell_string=cell_data.tf_MatchCase(this.matchCase);var isMatched=false;isMatched=optArray.tf_Has(cell_string,this.matchCase);if(!isMatched)
optArray.push(cell_data);}}}}
if(isCustomSlc)
{var customValues=this.__getCustomValues(colIndex);optArray=customValues[0];optTxt=customValues[1];}
if(this.sortSlc&&!isCustomSlc)
{if(!this.matchCase)optArray.sort(tf_IgnoreCaseSort);else optArray.sort();}
if(this.sortNumAsc&&this.sortNumAsc.tf_Has(colIndex))
{try{optArray.sort(tf_NumSortAsc);if(isCustomSlc)optTxt.sort(tf_NumSortAsc);}catch(e){optArray.sort();if(isCustomSlc)optTxt.sort();}}
if(this.sortNumDesc&&this.sortNumDesc.tf_Has(colIndex))
{try{optArray.sort(tf_NumSortDesc);if(isCustomSlc)optTxt.sort(tf_NumSortDesc);}catch(e){optArray.sort();if(isCustomSlc)optTxt.sort();}}
AddOpts();function AddOpt0()
{if(fillMethod=='innerhtml')
slcInnerHtml+='<option value="">'+o.displayAllText+'</option>';else{var opt0=tf_CreateOpt(o.displayAllText,'');slc.appendChild(opt0);if(o.enableEmptyOption){var opt1=tf_CreateOpt(o.emptyText,o.emOperator);slc.appendChild(opt1);}
if(o.enableNonEmptyOption){var opt2=tf_CreateOpt(o.nonEmptyText,o.nmOperator);slc.appendChild(opt2);}}}
function AddOpts()
{var slcValue=slc.value;slc.innerHTML='';AddOpt0();for(var y=0;y<optArray.length;y++)
{if(optArray[y]=='')continue;var val=optArray[y];var lbl=(isCustomSlc)?optTxt[y]:optArray[y];if(fillMethod=='innerhtml')
{var slcAttr='';if(o.fillSlcOnDemand&&slcValue==optArray[y])
slcAttr='selected="selected"';slcInnerHtml+='<option value="'+val+'" '
+slcAttr+'>'+lbl+'</option>';}else{var opt;if(o.fillSlcOnDemand&&slcValue==optArray[y]&&o['col'+colIndex]==o.fltTypeSlc)
opt=tf_CreateOpt(lbl,val,true);else{if(o['col'+colIndex]!=o.fltTypeMulti)
opt=tf_CreateOpt(lbl,val,(flts_values[colIndex]!=' '&&optArray[y]==flts_values[colIndex])?true:false);else
{opt=tf_CreateOpt(lbl,val,(fltArr.tf_Has(optArray[y].tf_MatchCase(o.matchCase),o.matchCase))?true:false);}}
slc.appendChild(opt);}}
if(fillMethod=='innerhtml')
slc.innerHTML+=slcInnerHtml;slc.setAttribute('filled','1');}},__deferMultipleSelection:function(slc,index,filter)
{if(slc.nodeName.tf_LCase()!='select')return;var doFilter=(filter==undefined)?false:filter;var o=this;window.setTimeout(function(){slc.options[0].selected=false;if(slc.options[index].value=='')
slc.options[index].selected=false;else
slc.options[index].selected=true;if(doFilter)o.Filter();},.1);},__getCustomValues:function(colIndex)
{if(colIndex==undefined)return;var isCustomSlc=(this.hasCustomSlcOptions&&this.customSlcOptions.cols.tf_Has(colIndex));if(!isCustomSlc)return;var optTxt=[],optArray=[];var index=this.customSlcOptions.cols.tf_IndexByValue(colIndex);var slcValues=this.customSlcOptions.values[index];var slcTexts=this.customSlcOptions.texts[index];var slcSort=this.customSlcOptions.sorts[index];for(var r=0;r<slcValues.length;r++)
{optArray.push(slcValues[r]);if(slcTexts[r]!=undefined)
optTxt.push(slcTexts[r]);else
optTxt.push(slcValues[r]);}
if(slcSort)
{optArray.sort();optTxt.sort();}
return[optArray,optTxt];},PopulateCheckList:function(colIndex,isExternal,extFltId)
{this.EvtManager(this.Evt.name.populatechecklist,{slcIndex:colIndex,slcExternal:isExternal,slcId:extFltId});},_PopulateCheckList:function(colIndex,isExternal,extFltId)
{isExternal=(isExternal==undefined)?false:isExternal;var divFltId=this.prfxCheckListDiv+colIndex+'_'+this.id;if(tf_Id(divFltId)==null&&!isExternal)return;if(tf_Id(extFltId)==null&&isExternal)return;var flt=(!isExternal)?this.checkListDiv[colIndex]:tf_Id(extFltId);var ul=tf_CreateElm('ul',['id',this.fltIds[colIndex]],['colIndex',colIndex]);ul.className=this.checkListCssClass;ul.onchange=this.Evt._OnCheckListChange;var o=this,row=this.tbl.rows;var optArray=[];var isCustomSlc=(this.hasCustomSlcOptions&&this.customSlcOptions.cols.tf_Has(colIndex));var optTxt=[];var activeFlt;if(this.refreshFilters&&this.activeFilterId){activeFlt=this.activeFilterId.split('_')[0];activeFlt=activeFlt.split(this.prfxFlt)[1];}
for(var k=this.refRow;k<this.nbRows;k++)
{if(this.hasVisibleRows&&this.visibleRows.tf_Has(k)&&!this.paging)
continue;var cells=row[k].cells;var ncells=cells.length;if(ncells==this.nbCells&&!isCustomSlc)
{for(var j=0;j<ncells;j++)
{if((colIndex==j&&!this.refreshFilters)||(colIndex==j&&this.refreshFilters&&((row[k].style.display==''&&!this.paging)||(this.paging&&((activeFlt==undefined||activeFlt==colIndex)||(activeFlt!=colIndex&&this.validRowsIndex.tf_Has(k)))))))
{var cell_data=this.GetCellData(j,cells[j]);var cell_string=cell_data.tf_MatchCase(this.matchCase);var isMatched=false;isMatched=optArray.tf_Has(cell_string,this.matchCase);if(!isMatched)
optArray.push(cell_data);}}}}
if(isCustomSlc)
{var customValues=this.__getCustomValues(colIndex);optArray=customValues[0];optTxt=customValues[1];}
if(this.sortSlc&&!isCustomSlc){if(!this.matchCase)optArray.sort(tf_IgnoreCaseSort);else optArray.sort();}
if(this.sortNumAsc&&this.sortNumAsc.tf_Has(colIndex))
{try{optArray.sort(tf_NumSortAsc);if(isCustomSlc)optTxt.sort(tf_NumSortAsc);}catch(e){optArray.sort();if(isCustomSlc)optTxt.sort();}}
if(this.sortNumDesc&&this.sortNumDesc.tf_Has(colIndex))
{try{optArray.sort(tf_NumSortDesc);if(isCustomSlc)optTxt.sort(tf_NumSortDesc);}catch(e){optArray.sort();if(isCustomSlc)optTxt.sort();}}
AddChecks();function AddTChecks()
{var chkCt=1;var li0=tf_CreateCheckItem(o.fltIds[colIndex]+'_0','',o.displayAllText);li0.className=o.checkListItemCssClass;ul.appendChild(li0);li0.check.onclick=function(e){o.__setCheckListValues(this);if(o.refreshFilters){}
else ul.onchange.call(null,e);};if(tf_isIE)
{li0.label.onclick=function(){li0.check.click();};}
if(o.enableEmptyOption){var li1=tf_CreateCheckItem(o.fltIds[colIndex]+'_1',o.emOperator,o.emptyText);li1.className=o.checkListItemCssClass;ul.appendChild(li1);li1.check.onclick=function(e){o.__setCheckListValues(this);ul.onchange.call(null,e);};if(tf_isIE)
{li1.label.onclick=function(){li1.check.click();};}
chkCt++;}
if(o.enableNonEmptyOption){var li2=tf_CreateCheckItem(o.fltIds[colIndex]+'_2',o.nmOperator,o.nonEmptyText);li2.className=o.checkListItemCssClass;ul.appendChild(li2);li2.check.onclick=function(e){o.__setCheckListValues(this);ul.onchange.call(null,e);};if(tf_isIE)
{li2.label.onclick=function(){li2.check.click();};}
chkCt++;}
return chkCt;}
function AddChecks()
{var chkCt=AddTChecks();var flts_values=[],fltArr=[];if(tf_CookieValueByIndex(o.fltsValuesCookie,colIndex)!=undefined)
fltArr=tf_CookieValueByIndex(o.fltsValuesCookie,colIndex).split(' '+o.orOperator+' ');for(var y=0;y<optArray.length;y++)
{var val=optArray[y];var lbl=(isCustomSlc)?optTxt[y]:optArray[y];var li=tf_CreateCheckItem(o.fltIds[colIndex]+'_'+(y+chkCt),val,lbl);li.className=o.checkListItemCssClass;ul.appendChild(li);li.check.onclick=function(e){o.__setCheckListValues(this);ul.onchange.call(null,e);};if(optArray[y]=='')li.style.display='none';if(o.rememberGridValues)
{if(fltArr.tf_Has(optArray[y].tf_MatchCase(o.matchCase),o.matchCase))
{li.check.checked=true;o.__setCheckListValues(li.check);}}
if(tf_isIE)
{li.label.onclick=function(){this.firstChild.click();};}}}
if(this.fillSlcOnDemand)
flt.innerHTML='';flt.appendChild(ul);flt.setAttribute('filled','1');if(o.rememberGridValues&&tf_isIE)
{var slcIndexes=ul.getAttribute('indexes');if(slcIndexes!=null)
{var indSplit=slcIndexes.split(',');for(var n=0;n<indSplit.length;n++)
{var cChk=tf_Id(this.fltIds[colIndex]+'_'+indSplit[n]);if(cChk)cChk.checked=true;}}}},__setCheckListValues:function(o)
{if(o==null)return;var chkValue=o.value;var chkIndex=parseInt(o.id.split('_')[2]);var filterTag='ul',itemTag='li';var n=o;while(n.nodeName.tf_LCase()!=filterTag)
n=n.parentNode;if(n.nodeName.tf_LCase()!=filterTag)return;var li=n.childNodes[chkIndex];var colIndex=n.getAttribute('colIndex');var fltValue=n.getAttribute('value');var fltIndexes=n.getAttribute('indexes');if(o.checked)
{if(chkValue=='')
{if((fltIndexes!=null&&fltIndexes!=''))
{var indSplit=fltIndexes.split(this.separator);for(var u=0;u<indSplit.length;u++)
{var cChk=tf_Id(this.fltIds[colIndex]+'_'+indSplit[u]);if(cChk)
{cChk.checked=false;tf_RemoveClass(n.childNodes[indSplit[u]],this.checkListSlcItemCssClass);}}}
n.setAttribute('value','');n.setAttribute('indexes','');}else{fltValue=(fltValue)?fltValue:'';chkValue=(fltValue+' '+chkValue+' '+this.orOperator).tf_Trim();chkIndex=fltIndexes+chkIndex+this.separator;n.setAttribute('value',chkValue);n.setAttribute('indexes',chkIndex);if(tf_Id(this.fltIds[colIndex]+'_0'))
tf_Id(this.fltIds[colIndex]+'_0').checked=false;}
if(li.nodeName.tf_LCase()==itemTag)
{tf_RemoveClass(n.childNodes[0],this.checkListSlcItemCssClass);tf_AddClass(li,this.checkListSlcItemCssClass);}}else{if(chkValue!='')
{var replaceValue=new RegExp(tf_RegexpEscape(chkValue+' '+this.orOperator));fltValue=fltValue.replace(replaceValue,'');n.setAttribute('value',fltValue.tf_Trim());var replaceIndex=new RegExp(tf_RegexpEscape(chkIndex+this.separator));fltIndexes=fltIndexes.replace(replaceIndex,'');n.setAttribute('indexes',fltIndexes);}
if(li.nodeName.tf_LCase()==itemTag)
tf_RemoveClass(li,this.checkListSlcItemCssClass);}},SetResetBtn:function()
{if(!this.hasGrid&&!this.isFirstLoad)return;if(this.btnResetEl!=null)return;var f=this.fObj;this.btnResetTgtId=f.btn_reset_target_id!=undefined?f.btn_reset_target_id:null;this.btnResetEl=null;this.btnResetText=f.btn_reset_text!=undefined?f.btn_reset_text:'Reset';this.btnResetTooltip=f.btn_reset_tooltip!=undefined?f.btn_reset_tooltip:'Clear filters';this.btnResetHtml=f.btn_reset_html!=undefined?f.btn_reset_html:(!this.enableIcons?null:'<input type="button" value="" class="'+this.btnResetCssClass+'" title="'+this.btnResetTooltip+'" />');var resetspan=tf_CreateElm('span',['id',this.prfxResetSpan+this.id]);if(this.btnResetTgtId==null)this.SetTopDiv();var targetEl=(this.btnResetTgtId==null)?this.rDiv:tf_Id(this.btnResetTgtId);targetEl.appendChild(resetspan);if(this.btnResetHtml==null)
{var fltreset=tf_CreateElm('a',['href','javascript:void(0);']);fltreset.className=this.btnResetCssClass;fltreset.appendChild(tf_CreateText(this.btnResetText));resetspan.appendChild(fltreset);fltreset.onclick=this.Evt._Clear;}else{resetspan.innerHTML=this.btnResetHtml;var resetEl=resetspan.firstChild;resetEl.onclick=this.Evt._Clear;}
this.btnResetEl=tf_Id(this.prfxResetSpan+this.id).firstChild;},RemoveResetBtn:function()
{if(!this.hasGrid)return;if(this.btnResetEl==null)return;var resetspan=tf_Id(this.prfxResetSpan+this.id);if(resetspan!=null)
resetspan.parentNode.removeChild(resetspan);this.btnResetEl=null;},SetStatusBar:function()
{if(!this.hasGrid&&!this.isFirstLoad)return;var f=this.fObj;this.statusBarTgtId=f.status_bar_target_id!=undefined?f.status_bar_target_id:null;this.statusBarDiv=null;this.statusBarSpan=null;this.statusBarSpanText=null;this.statusBarText=f.status_bar_text!=undefined?f.status_bar_text:'';this.statusBarCssClass=f.status_bar_css_class!=undefined?f.status_bar_css_class:'status';this.statusBarCloseDelay=250;var statusDiv=tf_CreateElm('div',['id',this.prfxStatus+this.id]);statusDiv.className=this.statusBarCssClass;var statusSpan=tf_CreateElm('span',['id',this.prfxStatusSpan+this.id]);var statusSpanText=tf_CreateElm('span',['id',this.prfxStatusTxt+this.id]);statusSpanText.appendChild(tf_CreateText(this.statusBarText));if(this.statusBarTgtId==null)this.SetTopDiv();var targetEl=(this.statusBarTgtId==null)?this.lDiv:tf_Id(this.statusBarTgtId);if(this.statusBarDiv&&tf_isIE)
this.statusBarDiv.outerHTML='';if(this.statusBarTgtId==null)
{statusDiv.appendChild(statusSpanText);statusDiv.appendChild(statusSpan);targetEl.appendChild(statusDiv);}
else
{targetEl.appendChild(statusSpanText);targetEl.appendChild(statusSpan);}
this.statusBarDiv=tf_Id(this.prfxStatus+this.id);this.statusBarSpan=tf_Id(this.prfxStatusSpan+this.id);this.statusBarSpanText=tf_Id(this.prfxStatusTxt+this.id);},RemoveStatusBar:function()
{if(!this.hasGrid)return;if(this.statusBarDiv)
{this.statusBarDiv.innerHTML='';this.statusBarDiv.parentNode.removeChild(this.statusBarDiv);this.statusBarSpan=null;this.statusBarSpanText=null;this.statusBarDiv=null;}},StatusMsg:function(t)
{if(t==undefined)this.StatusMsg('');if(this.status)this.WinStatusMsg(t);if(this.statusBar)this.StatusBarMsg(t);},WinStatusMsg:function(t)
{if(!this.status)return;window.status=t;},StatusBarMsg:function(t)
{if(!this.statusBar||!this.statusBarSpan)return;var o=this;function setMsg(){o.statusBarSpan.innerHTML=t;}
var d=(t=='')?(this.statusBarCloseDelay):1;window.setTimeout(setMsg,d);},SetRowsCounter:function()
{if(!this.hasGrid&&!this.isFirstLoad)return;if(this.rowsCounterSpan!=null)return;var f=this.fObj;this.rowsCounterTgtId=f.rows_counter_target_id!=undefined?f.rows_counter_target_id:null;this.rowsCounterDiv=null;this.rowsCounterSpan=null;this.rowsCounterText=f.rows_counter_text!=undefined?f.rows_counter_text:'Rows: ';this.totRowsCssClass=f.tot_rows_css_class!=undefined?f.tot_rows_css_class:'tot';var countDiv=tf_CreateElm('div',['id',this.prfxCounter+this.id]);countDiv.className=this.totRowsCssClass;var countSpan=tf_CreateElm('span',['id',this.prfxTotRows+this.id]);var countText=tf_CreateElm('span',['id',this.prfxTotRowsTxt+this.id]);countText.appendChild(tf_CreateText(this.rowsCounterText));if(this.rowsCounterTgtId==null)this.SetTopDiv();var targetEl=(this.rowsCounterTgtId==null)?this.lDiv:tf_Id(this.rowsCounterTgtId);if(this.rowsCounterDiv&&tf_isIE)
this.rowsCounterDiv.outerHTML='';if(this.rowsCounterTgtId==null)
{countDiv.appendChild(countText);countDiv.appendChild(countSpan);targetEl.appendChild(countDiv);}
else
{targetEl.appendChild(countText);targetEl.appendChild(countSpan);}
this.rowsCounterDiv=tf_Id(this.prfxCounter+this.id);this.rowsCounterSpan=tf_Id(this.prfxTotRows+this.id);this.RefreshNbRows();},RemoveRowsCounter:function()
{if(!this.hasGrid)return;if(this.rowsCounterSpan==null)return;if(this.rowsCounterTgtId==null&&this.rowsCounterDiv)
{if(tf_isIE)this.rowsCounterDiv.outerHTML='';else
this.rowsCounterDiv.parentNode.removeChild(this.rowsCounterDiv);}else{tf_Id(this.rowsCounterTgtId).innerHTML='';}
this.rowsCounterSpan=null;this.rowsCounterDiv=null;},RefreshNbRows:function(p)
{if(this.rowsCounterSpan==null)return;var totTxt;if(!this.paging)
{if(p!=undefined&&p!='')totTxt=p;else totTxt=(this.nbFilterableRows-this.nbHiddenRows-(this.hasVisibleRows?this.visibleRows.length:0));}else{var paging_start_row=parseInt(this.startPagingRow)+((this.nbVisibleRows>0)?1:0);var paging_end_row=(paging_start_row+this.pagingLength)-1<=this.nbVisibleRows?(paging_start_row+this.pagingLength)-1:this.nbVisibleRows;totTxt=paging_start_row+'-'+paging_end_row+' / '+this.nbVisibleRows;}
this.rowsCounterSpan.innerHTML=totTxt;},SetWatermark:function(set)
{if(!this.fltGrid)return;if(this.inpWatermark!=''){var set=(set||set==undefined)?true:false;for(var i=0;i<this.fltIds.length;i++){if(this['col'+i]!=this.fltTypeInp)continue;var inpWatermark=(!this.isInpWatermarkArray?this.inpWatermark:this.inpWatermark[i]);if(this.GetFilterValue(i)==(set?'':inpWatermark)){this.SetFilterValue(i,(!set?'':inpWatermark));tf_AddClass(this.GetFilterElement(i),this.inpWatermarkCssClass);}}}},SetGridLayout:function()
{if(!this.gridLayout)return;var f=this.fObj;this.gridWidth=f.grid_width!=undefined?f.grid_width:null;this.gridHeight=f.grid_height!=undefined?f.grid_height:null;this.gridMainContCssClass=f.grid_cont_css_class!=undefined?f.grid_cont_css_class:'grd_Cont';this.gridContCssClass=f.grid_tbl_cont_css_class!=undefined?f.grid_tbl_cont_css_class:'grd_tblCont';this.gridHeadContCssClass=f.grid_tblHead_cont_css_class!=undefined?f.grid_tblHead_cont_css_class:'grd_headTblCont';this.gridInfDivCssClass=f.grid_inf_grid_css_class!=undefined?f.grid_inf_grid_css_class:'grd_inf';this.gridHeadRowIndex=f.grid_headers_row_index!=undefined?f.grid_headers_row_index:0;this.gridHeadRows=f.grid_headers_rows!=undefined?f.grid_headers_rows:[0];this.gridEnableFilters=f.grid_enable_default_filters!=undefined?f.grid_enable_default_filters:true;this.gridDefaultColWidth=f.grid_default_col_width!=undefined?f.grid_default_col_width:'100px';this.gridEnableColResizer=f.grid_enable_cols_resizer!=undefined?f.grid_enable_cols_resizer:true;this.gridColResizerPath=f.grid_cont_col_resizer_path!=undefined?f.grid_cont_col_resizer_path:this.basePath+'TFExt_ColsResizer/TFExt_ColsResizer.js';if(!this.hasColWidth){this.colWidth=[];for(var k=0;k<this.nbCells;k++){var colW,cell=this.tbl.rows[this.gridHeadRowIndex].cells[k];if(cell.width!='')colW=cell.width;else if(cell.style.width!='')colW=parseInt(cell.style.width);else colW=this.gridDefaultColWidth;this.colWidth[k]=colW;}
this.hasColWidth=true;}
this.SetColWidths(this.gridHeadRowIndex);var tblW;if(this.tbl.width!='')tblW=this.tbl.width;else if(this.tbl.style.width!='')tblW=parseInt(this.tbl.style.width);else tblW=this.tbl.clientWidth;this.tblMainCont=tf_CreateElm('div',['id',this.prfxMainTblCont+this.id]);this.tblMainCont.className=this.gridMainContCssClass;if(this.gridWidth)this.tblMainCont.style.width=this.gridWidth;this.tbl.parentNode.insertBefore(this.tblMainCont,this.tbl);this.tblCont=tf_CreateElm('div',['id',this.prfxTblCont+this.id]);this.tblCont.className=this.gridContCssClass;if(this.gridWidth)this.tblCont.style.width=this.gridWidth;if(this.gridHeight)this.tblCont.style.height=this.gridHeight;this.tbl.parentNode.insertBefore(this.tblCont,this.tbl);var t=this.tbl.parentNode.removeChild(this.tbl);this.tblCont.appendChild(t);if(this.tbl.style.width=='')
this.tbl.style.width=(this.__containsStr('%',tblW)?this.tbl.clientWidth:tblW)+'px';var d=this.tblCont.parentNode.removeChild(this.tblCont);this.tblMainCont.appendChild(d);this.headTblCont=tf_CreateElm('div',['id',this.prfxHeadTblCont+this.id]);this.headTblCont.className=this.gridHeadContCssClass;if(this.gridWidth)this.headTblCont.style.width=this.gridWidth;this.headTbl=tf_CreateElm('table',['id',this.prfxHeadTbl+this.id]);var tH=tf_CreateElm('tHead');var hRow=this.tbl.rows[this.gridHeadRowIndex];var sortTriggers=[];for(var n=0;n<this.nbCells;n++){var cell=hRow.cells[n];var thId=cell.getAttribute('id');if(!thId||thId==''){thId=this.prfxGridTh+n+'_'+this.id
cell.setAttribute('id',thId);}
sortTriggers.push(thId);}
var filtersRow=tf_CreateElm('tr');if(this.gridEnableFilters&&this.fltGrid){this.externalFltTgtIds=[];for(var j=0;j<this.nbCells;j++)
{var fltTdId=this.prfxFlt+j+this.prfxGridFltTd+this.id;var c=tf_CreateElm(this.fltCellTag,['id',fltTdId]);filtersRow.appendChild(c);this.externalFltTgtIds[j]=fltTdId;}}
for(var i=0;i<this.gridHeadRows.length;i++)
{var headRow=this.tbl.rows[this.gridHeadRows[0]];tH.appendChild(headRow);}
this.headTbl.appendChild(tH);if(this.filtersRowIndex==0)tH.insertBefore(filtersRow,hRow);if(this.filtersRowIndex==1)tH.appendChild(filtersRow);this.headTblCont.appendChild(this.headTbl);this.tblCont.parentNode.insertBefore(this.headTblCont,this.tblCont);var thead=tf_Tag(this.tbl,'thead');if(thead.length>0)this.tbl.removeChild(thead[0]);this.headTbl.style.width=this.tbl.style.width;this.headTbl.style.tableLayout='fixed';this.tbl.style.tableLayout='fixed';this.headTbl.cellPadding=this.tbl.cellPadding;this.headTbl.cellSpacing=this.tbl.cellSpacing;this.headTblCont.style.width=this.tblCont.clientWidth+'px';this.SetColWidths();this.tbl.style.width='';if(tf_isIE||tf_isIE7)this.headTbl.style.width='';var o=this;this.tblCont.onscroll=function(){o.headTblCont.scrollLeft=this.scrollLeft;var _o=this;if(!o.isPointerXOverwritten){try{TF.Evt.pointerX=function(e)
{e=e||window.event;var scrollLeft=tf_StandardBody().scrollLeft+_o.scrollLeft;return(e.pageX+_o.scrollLeft)||(e.clientX+scrollLeft);}
o.isPointerXOverwritten=true;}catch(ee){o.isPointerXOverwritten=false;}}}
var f=this.fObj==undefined?{}:this.fObj;if(f.sort!=false){this.sort=true;this.sortConfig.asyncSort=true;this.sortConfig.triggerIds=sortTriggers;}
if(this.gridEnableColResizer){if(!this.hasExtensions){this.extensions={name:['ColumnsResizer_'+this.id],src:[this.gridColResizerPath],description:['Columns Resizing'],initialize:[function(o){o.SetColsResizer('ColumnsResizer_'+o.id);}]}
this.hasExtensions=true;}else{if(!this.__containsStr('colsresizer',this.extensions.src.toString().tf_LCase())){this.extensions.name.push('ColumnsResizer_'+this.id);this.extensions.src.push(this.gridColResizerPath);this.extensions.description.push('Columns Resizing');this.extensions.initialize.push(function(o){o.SetColsResizer('ColumnsResizer_'+o.id);});}}}
f.col_resizer_cols_headers_table=this.headTbl.getAttribute('id');f.col_resizer_cols_headers_index=this.gridHeadRowIndex;f.col_resizer_width_adjustment=0;f.col_enable_text_ellipsis=false;o.tblHasColTag=(tf_Tag(o.tbl,'col').length>0)?true:false;if(!tf_isIE&&!tf_isIE7){function createColTags(o)
{if(!o)return;for(var k=(o.nbCells-1);k>=0;k--)
{var col=tf_CreateElm('col',['id',o.id+'_col_'+k]);o.tbl.firstChild.parentNode.insertBefore(col,o.tbl.firstChild);col.style.width=o.colWidth[k];o.gridColElms[k]=col;}
o.tblHasColTag=true;}
if(!o.tblHasColTag)createColTags(o);else{var cols=tf_Tag(o.tbl,'col');for(var i=0;i<o.nbCells;i++){cols[i].setAttribute('id',o.id+'_col_'+i);cols[i].style.width=o.colWidth[i];o.gridColElms.push(cols[i]);}}}
if(tf_isIE||tf_isIE7){var tbody=tf_Tag(o.tbl,'tbody'),r;if(tbody.length>0)r=tbody[0].insertRow(0);else r=o.tbl.insertRow(0);r.style.height='0px';for(var i=0;i<o.nbCells;i++){var col=tf_CreateElm('td',['id',o.id+'_col_'+i]);col.style.width=o.colWidth[i];o.tbl.rows[1].cells[i].style.width='';r.appendChild(col);o.gridColElms.push(col);}
this.hasGridWidthsRow=true;o.leadColWidthsRow=o.tbl.rows[0];o.leadColWidthsRow.setAttribute('validRow','false');var beforeSortFn=tf_IsFn(f.on_before_sort)?f.on_before_sort:null;f.on_before_sort=function(o,colIndex){o.leadColWidthsRow.setAttribute('validRow','false');if(beforeSortFn!=null)beforeSortFn.call(null,o,colIndex);}
var afterSortFn=tf_IsFn(f.on_after_sort)?f.on_after_sort:null;f.on_after_sort=function(o,colIndex){if(o.leadColWidthsRow.rowIndex!=0){var r=o.leadColWidthsRow;if(tbody.length>0)
tbody[0].moveRow(o.leadColWidthsRow.rowIndex,0);else o.tbl.moveRow(o.leadColWidthsRow.rowIndex,0);}
if(afterSortFn!=null)afterSortFn.call(null,o,colIndex);}}
var afterColResizedFn=tf_IsFn(f.on_after_col_resized)?f.on_after_col_resized:null;f.on_after_col_resized=function(o,colIndex){if(colIndex==undefined)return;var w=o.crWColsRow.cells[colIndex].style.width;var col=o.gridColElms[colIndex];col.style.width=w;var thCW=o.crWColsRow.cells[colIndex].clientWidth;var tdCW=o.crWRowDataTbl.cells[colIndex].clientWidth;if(tf_isIE||tf_isIE7)
o.tbl.style.width=o.headTbl.clientWidth+'px';if(thCW!=tdCW&&!tf_isIE&&!tf_isIE7)
o.headTbl.style.width=o.tbl.clientWidth+'px';if(afterColResizedFn!=null)afterColResizedFn.call(null,o,colIndex);}
if(this.tbl.clientWidth!=this.headTbl.clientWidth)
this.tbl.style.width=this.headTbl.clientWidth+'px';},RemoveGridLayout:function()
{if(!this.gridLayout)return;var t=this.tbl.parentNode.removeChild(this.tbl);this.tblMainCont.parentNode.insertBefore(t,this.tblMainCont);this.tblMainCont.parentNode.removeChild(this.tblMainCont);this.tblMainCont=null;this.headTblCont=null;this.headTbl=null;this.tblCont=null;this.tbl.outerHTML=this.sourceTblHtml;this.tbl=tf_Id(this.id);},SetPopupFilterIcons:function()
{if(!this.popUpFilters)return;this.isExternalFlt=true;var f=this.fObj;this.popUpImgFlt=f.popup_filters_image!=undefined?f.popup_filters_image:this.themesPath+'icn_filter.gif';this.popUpImgFltActive=f.popup_filters_image_active!=undefined?f.popup_filters_image_active:this.themesPath+'icn_filterActive.gif';this.popUpImgFltHtml=f.popup_filters_image_html!=undefined?f.popup_filters_image_html:'<img src="'+this.popUpImgFlt+'" alt="Column filter" />';this.popUpDivCssClass=f.popup_div_css_class!=undefined?f.popup_div_css_class:'popUpFilter';this.onBeforePopUpOpen=tf_IsFn(f.on_before_popup_filter_open)?f.on_before_popup_filter_open:null;this.onAfterPopUpOpen=tf_IsFn(f.on_after_popup_filter_open)?f.on_after_popup_filter_open:null;this.onBeforePopUpClose=tf_IsFn(f.on_before_popup_filter_close)?f.on_before_popup_filter_close:null;this.onAfterPopUpClose=tf_IsFn(f.on_after_popup_filter_close)?f.on_after_popup_filter_close:null;this.filtersRowIndex=0;this.externalFltTgtIds=[];this.popUpFltSpans=[];this.popUpFltImgs=[];this.popUpFltElms=!this.popUpFltElmCache?[]:this.popUpFltElmCache;this.popUpFltAdjustToContainer=true;if(!this.gridLayout)this.headersRow--;var o=this;for(var i=0;i<this.nbCells;i++){if(this['col'+i]==this.fltTypeNone)continue;var popUpSpan=tf_CreateElm('span',['id',this.prfxPopUpSpan+this.id+'_'+i],['ci',i]);popUpSpan.innerHTML=this.popUpImgFltHtml;var header=this.GetHeaderElement(i);header.appendChild(popUpSpan);popUpSpan.onclick=function(e){var evt=e||window.event;var colIndex=parseInt(this.getAttribute('ci'));o.CloseAllPopupFilters(colIndex);o.TogglePopupFilter(colIndex);if(o.popUpFltAdjustToContainer){var popUpDiv=o.popUpFltElms[colIndex];var header=o.GetHeaderElement(colIndex);var headerWidth=header.clientWidth*.95;if(!tf_isNotIE){var headerLeft=tf_ObjPosition(header,[header.nodeName])[0];popUpDiv.style.left=(headerLeft)+'px';}
popUpDiv.style.width=parseInt(headerWidth)+'px';}
tf_CancelEvent(evt);tf_StopEvent(evt);};this.popUpFltSpans[i]=popUpSpan;this.popUpFltImgs[i]=popUpSpan.firstChild;}
if(!this.gridLayout)this.headersRow++;},SetPopupFilters:function()
{for(var i=0;i<this.popUpFltElmCache.length;i++)
this.SetPopupFilter(i,this.popUpFltElmCache[i]);},SetPopupFilter:function(colIndex,div)
{var popUpDiv=!div?tf_CreateElm('div',['id',this.prfxPopUpDiv+this.id+'_'+colIndex]):div;popUpDiv.className=this.popUpDivCssClass;this.externalFltTgtIds.push(this.prfxPopUpDiv+this.id+'_'+colIndex);var header=this.GetHeaderElement(colIndex);header.insertBefore(popUpDiv,header.firstChild);popUpDiv.onclick=function(e){tf_StopEvent(e||window.event);};this.popUpFltElms[colIndex]=popUpDiv;},TogglePopupFilter:function(colIndex)
{var popUpFltElm=this.popUpFltElms[colIndex];if(popUpFltElm.style.display=='none'||popUpFltElm.style.display==''){if(this.onBeforePopUpOpen!=null)this.onBeforePopUpOpen.call(null,this,this.popUpFltElms[colIndex],colIndex);popUpFltElm.style.display='block';if(this['col'+colIndex]==this.fltTypeInp)this.GetFilterElement(colIndex).focus();if(this.onAfterPopUpOpen!=null)this.onAfterPopUpOpen.call(null,this,this.popUpFltElms[colIndex],colIndex);}else{if(this.onBeforePopUpClose!=null)this.onBeforePopUpClose.call(null,this,this.popUpFltElms[colIndex],colIndex);popUpFltElm.style.display='none';if(this.onAfterPopUpClose!=null)this.onAfterPopUpClose.call(null,this,this.popUpFltElms[colIndex],colIndex);}},CloseAllPopupFilters:function(exceptColIndex)
{for(var i=0;i<this.popUpFltElms.length;i++){if(i==exceptColIndex)continue;var popUpFltElm=this.popUpFltElms[i];if(popUpFltElm)popUpFltElm.style.display='none';}},RemovePopupFilters:function()
{this.popUpFltElmCache=[];for(var i=0;i<this.popUpFltElms.length;i++){var popUpFltElm=this.popUpFltElms[i];var popUpFltSpan=this.popUpFltSpans[i];if(popUpFltElm){popUpFltElm.parentNode.removeChild(popUpFltElm);this.popUpFltElmCache[i]=popUpFltElm;}
popUpFltElm=null;if(popUpFltSpan)popUpFltSpan.parentNode.removeChild(popUpFltSpan);popUpFltSpan=null;}},SetPopupFilterIcon:function(colIndex,active)
{var activeImg=active==undefined?true:active;if(this.popUpFltImgs[colIndex])
this.popUpFltImgs[colIndex].src=(active)?this.popUpImgFltActive:this.popUpImgFlt;},SetAllPopupFiltersIcon:function(active)
{var activeImg=active==undefined?false:active;for(var i=0;i<this.popUpFltImgs.length;i++)
this.SetPopupFilterIcon(i,false);},RememberFiltersValue:function(name)
{var flt_values=[];for(var i=0;i<this.fltIds.length;i++)
{value=this.GetFilterValue(i);if(value=='')value=' ';flt_values.push(value);}
flt_values.push(this.fltIds.length);tf_WriteCookie(name,flt_values,this.cookieDuration);},RememberPageNb:function(name)
{tf_WriteCookie(name,this.currentPageNb,this.cookieDuration);},RememberPageLength:function(name)
{tf_WriteCookie(name,this.resultsPerPageSlc.selectedIndex,this.cookieDuration);},ResetValues:function()
{this.EvtManager(this.Evt.name.resetvalues);},_ResetValues:function()
{if(this.rememberGridValues&&this.fillSlcOnDemand)
this.ResetGridValues(this.fltsValuesCookie);if(this.rememberPageLen)this.ResetPageLength(this.pgLenCookie);if(this.rememberPageNb)this.ResetPage(this.pgNbCookie);},ResetGridValues:function(name)
{if(!this.fillSlcOnDemand)return;var flts=tf_ReadCookie(name);var reg=new RegExp(',','g');var flts_values=flts.split(reg);var slcFltsIndex=this.GetFiltersByType(this.fltTypeSlc,true);var multiFltsIndex=this.GetFiltersByType(this.fltTypeMulti,true);if(flts_values[(flts_values.length-1)]==this.fltIds.length)
{for(var i=0;i<(flts_values.length-1);i++)
{if(flts_values[i]==' ')continue;if(this['col'+i]==this.fltTypeSlc||this['col'+i]==this.fltTypeMulti)
{var slc=tf_Id(this.fltIds[i]);slc.options[0].selected=false;if(slcFltsIndex.tf_Has(i))
{var opt=tf_CreateOpt(flts_values[i],flts_values[i],true);slc.appendChild(opt);this.hasStoredValues=true;}
if(multiFltsIndex.tf_Has(i))
{var s=flts_values[i].split(' '+this.orOperator+' ');for(j=0;j<s.length;j++)
{if(s[j]=='')continue;var opt=tf_CreateOpt(s[j],s[j],true);slc.appendChild(opt);this.hasStoredValues=true;if(tf_isIE)
{this.__deferMultipleSelection(slc,j,false);hasStoredValues=false;}}}}
else if(this['col'+i]==this.fltTypeCheckList)
{var divChk=this.checkListDiv[i];divChk.title=divChk.innerHTML;divChk.innerHTML='';var ul=tf_CreateElm('ul',['id',this.fltIds[i]],['colIndex',i]);ul.className=this.checkListCssClass;var li0=tf_CreateCheckItem(this.fltIds[i]+'_0','',this.displayAllText);li0.className=this.checkListItemCssClass;ul.appendChild(li0);divChk.appendChild(ul);var s=flts_values[i].split(' '+this.orOperator+' ');for(j=0;j<s.length;j++)
{if(s[j]=='')continue;var li=tf_CreateCheckItem(this.fltIds[i]+'_'+(j+1),s[j],s[j]);li.className=this.checkListItemCssClass;ul.appendChild(li);li.check.checked=true;this.__setCheckListValues(li.check);this.hasStoredValues=true;}}}
if(!this.hasStoredValues&&this.paging)this.SetPagingInfo();}},SetRowBg:function(rIndex,index)
{if(!this.alternateBgs||isNaN(rIndex))return;var rows=this.tbl.rows;var i=(index==undefined)?rIndex:index;this.RemoveRowBg(rIndex);tf_AddClass(rows[rIndex],(i%2)?this.rowBgEvenCssClass:this.rowBgOddCssClass);},RemoveRowBg:function(index)
{if(isNaN(index))return;var rows=this.tbl.rows;tf_RemoveClass(rows[index],this.rowBgOddCssClass);tf_RemoveClass(rows[index],this.rowBgEvenCssClass);},SetAlternateRows:function()
{if(!this.hasGrid&&!this.isFirstLoad)return;var rows=this.tbl.rows;var noValidRowsIndex=this.validRowsIndex==null;var beginIndex=(noValidRowsIndex)?this.refRow:0;var indexLen=(noValidRowsIndex)?(this.nbFilterableRows+beginIndex):this.validRowsIndex.length;var idx=0;for(var j=beginIndex;j<indexLen;j++)
{var rIndex=(noValidRowsIndex)?j:this.validRowsIndex[j];this.SetRowBg(rIndex,idx);idx++;}},RemoveAlternateRows:function()
{if(!this.hasGrid)return;var row=this.tbl.rows;for(var i=this.refRow;i<this.nbRows;i++)
this.RemoveRowBg(i);this.isStartBgAlternate=true;},SetFixedHeaders:function()
{if((!this.hasGrid&&!this.isFirstLoad)||!this.fixedHeaders)return;if(this.contDiv)return;var thead=tf_Tag(this.tbl,'thead');if(thead.length==0)return;var tbody=tf_Tag(this.tbl,'tbody');if(tbody[0].clientHeight!=0)
{this.prevTBodyH=tbody[0].clientHeight;this.prevTBodyOverflow=tbody[0].style.overflow;this.prevTBodyOverflowX=tbody[0].style.overflowX;tbody[0].style.height=this.tBodyH+'px';tbody[0].style.overflow='auto';tbody[0].style.overflowX='hidden';}else{var contDiv=tf_CreateElm('div',['id',this.prfxContentDiv+this.id]);contDiv.className=this.contDivCssClass;this.tbl.parentNode.insertBefore(contDiv,this.tbl);contDiv.appendChild(this.tbl);this.contDiv=tf_Id(this.prfxContentDiv+this.id);this.contDiv.style.position='relative';var theadH=0;var theadTr=tf_Tag(thead[0],'tr');for(var i=0;i<theadTr.length;i++)
{theadTr[i].style.cssText+='position:relative; '+'top:expression(offsetParent.scrollTop);';theadH+=parseInt(theadTr[i].clientHeight);}
this.contDiv.style.height=(this.tBodyH+theadH)+'px';var tfoot=tf_Tag(this.tbl,'tfoot');if(tfoot.length==0)return;var tfootTr=tf_Tag(tfoot[0],'tr');for(var j=0;j<tfootTr.length;j++)
tfootTr[j].style.cssText+='position:relative; overflow-x: hidden; '+'top: expression(parentNode.parentNode.offsetHeight >= '+'offsetParent.offsetHeight ? 0 - parentNode.parentNode.offsetHeight + '+'offsetParent.offsetHeight + offsetParent.scrollTop : 0);';}},RemoveFixedHeaders:function()
{if(!this.hasGrid||!this.fixedHeaders)return;if(this.contDiv)
{this.contDiv.parentNode.insertBefore(this.tbl,this.contDiv);this.contDiv.parentNode.removeChild(this.contDiv);this.contDiv=null;var thead=tf_Tag(this.tbl,'thead');if(thead.length==0)return;var theadTr=tf_Tag(thead[0],'tr');if(theadTr.length==0)return;for(var i=0;i<theadTr.length;i++)
theadTr[i].style.cssText='';var tfoot=tf_Tag(this.tbl,'tfoot');if(tfoot.length==0)return;var tfootTr=tf_Tag(tfoot[0],'tr');for(var j=0;j<tfootTr.length;j++)
{tfootTr[j].style.position='relative';tfootTr[j].style.top='';tfootTr[j].style.overeflowX='';}}else{var tbody=tf_Tag(this.tbl,'tbody');if(tbody.length==0)return;tbody[0].style.height=this.prevTBodyH+'px';tbody[0].style.overflow=this.prevTBodyOverflow;tbody[0].style.overflowX=this.prevTBodyOverflowX;}},Filter:function()
{this.EvtManager(this.Evt.name.filter);},_Filter:function()
{if(!this.fltGrid||(!this.hasGrid&&!this.isFirstLoad))return;if(this.onBeforeFilter)this.onBeforeFilter.call(null,this);if(this.inpWatermark!='')this.SetWatermark(false);var row=this.tbl.rows;f=this.fObj!=undefined?this.fObj:[];var hiddenrows=0;this.validRowsIndex=[];var o=this;if(this.highlightKeywords)this.UnhighlightAll();if(this.popUpFilters)this.SetAllPopupFiltersIcon();if(this.markActiveColumns)this.ClearActiveColumns();this.searchArgs=this.GetFiltersValue();var num_cell_data,nbFormat;var re_le=new RegExp(this.leOperator),re_ge=new RegExp(this.geOperator);var re_l=new RegExp(this.lwOperator),re_g=new RegExp(this.grOperator);var re_d=new RegExp(this.dfOperator),re_lk=new RegExp(tf_RegexpEscape(this.lkOperator));var re_eq=new RegExp(this.eqOperator),re_st=new RegExp(this.stOperator);var re_en=new RegExp(this.enOperator),re_an=new RegExp(this.anOperator);var re_cr=new RegExp(this.curExp),re_em=this.emOperator;var re_nm=this.nmOperator;function highlight(str,ok,cell){if(o.highlightKeywords&&ok){str=str.replace(re_lk,'');str=str.replace(re_eq,'');str=str.replace(re_st,'');str=str.replace(re_en,'');var w=str;if(re_le.test(str)||re_ge.test(str)||re_l.test(str)||re_g.test(str)||re_d.test(str))
w=tf_GetNodeText(cell);if(w!='')
tf_HighlightWord(cell,w,o.highlightCssClass);}}
function hasArg(sA,cell_data,j)
{var occurence;var hasLO=re_l.test(sA),hasLE=re_le.test(sA);var hasGR=re_g.test(sA),hasGE=re_ge.test(sA);var hasDF=re_d.test(sA),hasEQ=re_eq.test(sA);var hasLK=re_lk.test(sA),hasAN=re_an.test(sA);var hasST=re_st.test(sA),hasEN=re_en.test(sA);var hasEM=(re_em==sA),hasNM=(re_nm==sA);var isLDate=(hasLO&&tf_IsValidDate(sA.replace(re_l,''),dtType));var isLEDate=(hasLE&&tf_IsValidDate(sA.replace(re_le,''),dtType));var isGDate=(hasGR&&tf_IsValidDate(sA.replace(re_g,''),dtType));var isGEDate=(hasGE&&tf_IsValidDate(sA.replace(re_ge,''),dtType));var isDFDate=(hasDF&&tf_IsValidDate(sA.replace(re_d,''),dtType));var isEQDate=(hasEQ&&tf_IsValidDate(sA.replace(re_eq,''),dtType));if(tf_IsValidDate(cell_data,dtType))
{var dte1=tf_FormatDate(cell_data,dtType);if(isLDate)
{var dte2=tf_FormatDate(sA.replace(re_l,''),dtType);occurence=(dte1<dte2);}
else if(isLEDate)
{var dte2=tf_FormatDate(sA.replace(re_le,''),dtType);occurence=(dte1<=dte2);}
else if(isGEDate)
{var dte2=tf_FormatDate(sA.replace(re_ge,''),dtType);occurence=(dte1>=dte2);}
else if(isGDate)
{var dte2=tf_FormatDate(sA.replace(re_g,''),dtType);occurence=(dte1>dte2);}
else if(isDFDate)
{var dte2=tf_FormatDate(sA.replace(re_d,''),dtType);occurence=(dte1.toString()!=dte2.toString());}
else if(isEQDate)
{var dte2=tf_FormatDate(sA.replace(re_eq,''),dtType);occurence=(dte1.toString()==dte2.toString());}
else if(re_lk.test(sA))
{occurence=o.__containsStr(sA.replace(re_lk,''),cell_data,null,false);}
else if(tf_IsValidDate(sA,dtType))
{var dte2=tf_FormatDate(sA,dtType);occurence=(dte1.toString()==dte2.toString());}
else if(hasEM)
occurence=(cell_data.tf_Trim()==''?true:false);else if(hasNM)
occurence=(cell_data.tf_Trim()!=''?true:false);}
else
{if(o.hasColNbFormat&&o.colNbFormat[j]!=null)
{num_cell_data=tf_RemoveNbFormat(cell_data,o.colNbFormat[j]);nbFormat=o.colNbFormat[j];}else{if(o.thousandsSeparator==','&&o.decimalSeparator=='.')
{num_cell_data=tf_RemoveNbFormat(cell_data,'us');nbFormat='us';}else{num_cell_data=tf_RemoveNbFormat(cell_data,'eu');nbFormat='eu';}}
if(hasLE)
occurence=num_cell_data<=tf_RemoveNbFormat(sA.replace(re_le,''),nbFormat);else if(hasGE)
occurence=num_cell_data>=tf_RemoveNbFormat(sA.replace(re_ge,''),nbFormat);else if(hasLO)
occurence=num_cell_data<tf_RemoveNbFormat(sA.replace(re_l,''),nbFormat);else if(hasGR)
occurence=num_cell_data>tf_RemoveNbFormat(sA.replace(re_g,''),nbFormat);else if(hasDF)
occurence=o.__containsStr(sA.replace(re_d,''),cell_data)?false:true;else if(hasLK)
occurence=o.__containsStr(sA.replace(re_lk,''),cell_data,null,false);else if(hasEQ)
occurence=o.__containsStr(sA.replace(re_eq,''),cell_data,null,true);else if(hasST)
occurence=cell_data.indexOf(sA.replace(re_st,''))==0?true:false;else if(hasEN)
{var searchArg=sA.replace(re_en,'');occurence=cell_data.lastIndexOf(searchArg,cell_data.length-1)==(cell_data.length-1)-(searchArg.length-1)&&cell_data.lastIndexOf(searchArg,cell_data.length-1)>-1?true:false;}
else if(hasEM)
occurence=(cell_data.tf_Trim()==''?true:false);else if(hasNM)
occurence=(cell_data.tf_Trim()!=''?true:false);else
occurence=o.__containsStr(sA,cell_data,(f['col_'+j]==undefined)?this.fltTypeInp:f['col_'+j]);}
return occurence;}
for(var k=this.refRow;k<this.nbRows;k++)
{if(row[k].style.display=='none')row[k].style.display='';var cell=row[k].cells;var nchilds=cell.length;if(nchilds!=this.nbCells)continue;var occurence=[];var isRowValid=(this.searchType=='include')?true:false;var singleFltRowValid=false;for(var j=0;j<nchilds;j++)
{var sA=this.searchArgs[(this.singleSearchFlt)?0:j];var dtType=(this.hasColDateType)?this.colDateType[j]:this.defaultDateType;if(sA=='')continue;var cell_data=this.GetCellData(j,cell[j]).tf_MatchCase(this.matchCase);var sAOrSplit=sA.split(this.orOperator);var hasMultiOrSA=(sAOrSplit.length>1)?true:false;var sAAndSplit=sA.split(this.anOperator);var hasMultiAndSA=(sAAndSplit.length>1)?true:false;if(hasMultiOrSA||hasMultiAndSA)
{var cS,occur=false;var s=(hasMultiOrSA)?sAOrSplit:sAAndSplit;for(var w=0;w<s.length;w++)
{cS=s[w].tf_Trim();occur=hasArg(cS,cell_data,j);highlight(cS,occur,cell[j]);if(hasMultiOrSA&&occur)break;if(hasMultiAndSA&&!occur)break;}
occurence[j]=occur;}
else{occurence[j]=hasArg(sA.tf_Trim(),cell_data,j);highlight(sA,occurence[j],cell[j]);}
if(!occurence[j])isRowValid=(this.searchType=='include')?false:true;if(this.singleSearchFlt&&occurence[j])singleFltRowValid=true;if(this.popUpFilters)this.SetPopupFilterIcon(j,true);if(this.markActiveColumns){if(k==this.refRow){if(this.onBeforeActiveColumn)this.onBeforeActiveColumn.call(null,this,j);tf_AddClass(this.GetHeaderElement(j),this.activeColumnsCssClass);if(this.onAfterActiveColumn)this.onAfterActiveColumn.call(null,this,j);}}}
if(this.singleSearchFlt&&singleFltRowValid)isRowValid=true;if(!isRowValid)
{this.SetRowValidation(k,false);if(this.hasVisibleRows&&this.visibleRows.tf_Has(k)&&!this.paging)
this.validRowsIndex.push(k);else
hiddenrows++;}else{this.SetRowValidation(k,true);this.validRowsIndex.push(k);if(this.alternateBgs)this.SetRowBg(k,this.validRowsIndex.length);if(this.onRowValidated)this.onRowValidated.call(null,this,k);}}
this.nbVisibleRows=this.validRowsIndex.length;this.nbHiddenRows=hiddenrows;this.isStartBgAlternate=false;if(this.rememberGridValues)this.RememberFiltersValue(this.fltsValuesCookie);if(!this.paging)this.ApplyGridProps();if(this.paging){this.startPagingRow=0;this.currentPageNb=1;this.SetPagingInfo(this.validRowsIndex);}
if(this.onAfterFilter)this.onAfterFilter.call(null,this);},ApplyGridProps:function()
{if(this.activeFlt&&this.activeFlt.nodeName.tf_LCase()==this.fltTypeSlc&&!this.popUpFilters)
{this.activeFlt.blur();if(this.activeFlt.parentNode)this.activeFlt.parentNode.focus();}
if(this.visibleRows)this.SetVisibleRows();if(this.colOperation)this.SetColOperation();if(this.refreshFilters)this.RefreshFiltersGrid();var nr=(!this.paging&&this.hasVisibleRows)?(this.nbVisibleRows-this.visibleRows.length):this.nbVisibleRows;if(this.rowsCounter)this.RefreshNbRows(nr);if(this.inpWatermark!='')this.SetWatermark(true);if(this.popUpFilters)this.CloseAllPopupFilters();},GetColValues:function(colindex,num,exclude)
{if(!this.fltGrid)return;var row=this.tbl.rows;var colValues=[];for(var i=this.refRow;i<this.nbRows;i++)
{var isExludedRow=false;if(exclude!=undefined&&tf_IsObj(exclude))
{isExludedRow=exclude.tf_Has(i);}
var cell=row[i].cells;var nchilds=cell.length;if(nchilds==this.nbCells&&!isExludedRow)
{for(var j=0;j<nchilds;j++)
{if(j==colindex&&row[i].style.display=='')
{var cell_data=this.GetCellData(j,cell[j]).tf_LCase();var nbFormat=this.colNbFormat?this.colNbFormat[colindex]:null;(num)?colValues.push(tf_RemoveNbFormat(cell_data,nbFormat)):colValues.push(cell_data);}}}}
return colValues;},GetFilterValue:function(index)
{if(!this.fltGrid)return;var fltValue;var flt=this.GetFilterElement(index);if(flt==null)return fltValue='';if(this['col'+index]!=this.fltTypeMulti&&this['col'+index]!=this.fltTypeCheckList)
fltValue=flt.value;else if(this['col'+index]==this.fltTypeMulti)
{fltValue='';for(var j=0;j<flt.options.length;j++)
if(flt.options[j].selected)
fltValue=fltValue.concat(flt.options[j].value+' '+
this.orOperator+' ');fltValue=fltValue.substr(0,fltValue.length-4);}
else if(this['col'+index]==this.fltTypeCheckList)
{if(flt.getAttribute('value')!=null)
{fltValue=flt.getAttribute('value');fltValue=fltValue.substr(0,fltValue.length-3);}else fltValue='';}
return fltValue;},GetFiltersValue:function()
{if(!this.fltGrid)return;var searchArgs=[];for(var i=0;i<this.fltIds.length;i++)
searchArgs.push(this.GetFilterValue(i).tf_MatchCase(this.matchCase).tf_Trim());return searchArgs;},GetFilterId:function(index)
{if(!this.fltGrid)return;return this.fltIds[i];},GetFiltersByType:function(type,bool)
{if(!this.fltGrid)return;var arr=[];for(var i=0;i<this.fltIds.length;i++)
{var fltType=this['col'+i];if(fltType==type.tf_LCase())
{var a=(bool)?i:this.fltIds[i];arr.push(a);}}
return arr;},GetFilterElement:function(index)
{if(!this.fltGrid)return null;return tf_Id(this.fltIds[index]);},GetCellsNb:function(rowIndex)
{var tr=(rowIndex==undefined)?this.tbl.rows[0]:this.tbl.rows[rowIndex];return tr.cells.length;},GetRowsNb:function()
{var s=this.refRow==undefined?0:this.refRow;var ntrs=this.tbl.rows.length;return parseInt(ntrs-s);},GetCellData:function(i,cell)
{if(i==undefined||cell==null)return"";if(this.customCellData&&this.customCellDataCols.tf_Has(i))
return this.customCellData.call(null,this,cell,i);else
return tf_GetNodeText(cell);},GetTableData:function()
{var row=this.tbl.rows;for(var k=this.refRow;k<this.nbRows;k++)
{var rowData,cellData;rowData=[k,[]];var cells=row[k].cells;for(var j=0;j<cells.length;j++)
{var cell_data=this.GetCellData(j,cells[j]);rowData[1].push(cell_data);}
this.tblData.push(rowData)}
return this.tblData;},GetFilteredData:function(includeHeaders)
{if(!this.validRowsIndex)return[];var row=this.tbl.rows;var filteredData=[];if(includeHeaders){var table=(this.gridLayout)?this.headTbl:this.tbl;var r=table.rows[this.headersRow];var rowData=[r.rowIndex,[]];for(var j=0;j<this.nbCells;j++)
{var headerText=this.GetCellData(j,r.cells[j]);rowData[1].push(headerText);}
filteredData.push(rowData);}
for(var i=0;i<this.validRowsIndex.length;i++)
{var rowData,cellData;rowData=[this.validRowsIndex[i],[]];var cells=row[this.validRowsIndex[i]].cells;for(var j=0;j<cells.length;j++)
{var cell_data=this.GetCellData(j,cells[j]);rowData[1].push(cell_data);}
filteredData.push(rowData);}
return filteredData;},GetFilteredDataCol:function(colIndex)
{if(colIndex==undefined)return[];var data=this.GetFilteredData();var colData=[];for(var i=0;i<data.length;i++)
{var r=data[i];var d=r[1];var c=d[colIndex];colData.push(c);}
return colData;},GetRowDisplay:function(row)
{if(!this.fltGrid&&!tf_IsObj(row))return;return row.style.display;},SetRowValidation:function(rowIndex,isValid)
{var row=this.tbl.rows[rowIndex];if(!row||(typeof isValid).tf_LCase()!='boolean')return;if(this.hasVisibleRows&&this.visibleRows.tf_Has(rowIndex)&&!this.paging)
isValid=true;var displayFlag=(isValid)?'':'none';var validFlag=(isValid)?'true':'false';row.style.display=displayFlag;if(this.paging)
row.setAttribute('validRow',validFlag);},ValidateAllRows:function()
{if(!this.hasGrid)return;this.validRowsIndex=[];for(var k=this.refRow;k<this.nbFilterableRows;k++)
{this.SetRowValidation(k,true);this.validRowsIndex.push(k);}},SetFilterValue:function(index,searcharg,doFilter)
{if((!this.fltGrid&&!this.isFirstLoad)||this.GetFilterElement(index)==null)return;var slc=this.GetFilterElement(index);var execFilter=(doFilter==undefined)?true:doFilter;searcharg=(searcharg==undefined)?'':searcharg;if(this['col'+index]!=this.fltTypeMulti&&this['col'+index]!=this.fltTypeCheckList){slc.value=searcharg;if(this['col'+index]==this.fltTypeInp&&this.inpWatermark!='')
tf_RemoveClass(slc,this.inpWatermarkCssClass);}
else if(this['col'+index]==this.fltTypeMulti)
{var s=searcharg.split(' '+this.orOperator+' ');var ct=0;for(var j=0;j<slc.options.length;j++)
{if(s=='')slc.options[j].selected=false;if(slc.options[j].value=='')slc.options[j].selected=false;if(slc.options[j].value!=''&&s.tf_Has(slc.options[j].value,true))
{if(tf_isIE)
{var filter=(ct==(s.length-1)&&execFilter)?true:false;this.__deferMultipleSelection(slc,j,filter);ct++;}
else
slc.options[j].selected=true;}}}
else if(this['col'+index]==this.fltTypeCheckList)
{searcharg=searcharg.tf_MatchCase(this.matchCase);var s=searcharg.split(' '+this.orOperator+' ');var fltValue=slc.setAttribute('value','');var fltIndex=slc.setAttribute('indexes','');for(var k=0;k<tf_Tag(slc,'li').length;k++)
{var li=tf_Tag(slc,'li')[k];var lbl=tf_Tag(li,'label')[0];var chk=tf_Tag(li,'input')[0];var lblTxt=tf_GetNodeText(lbl).tf_MatchCase(this.matchCase);if(lblTxt!=''&&s.tf_Has(lblTxt,true))
{chk.checked=true;this.__setCheckListValues(chk);}
else{chk.checked=false;this.__setCheckListValues(chk);}}}},SetColWidths:function(rowIndex)
{if(!this.fltGrid||!this.hasColWidth)return;var o=this,rIndex;if(rowIndex==undefined)rIndex=this.tbl.rows[0].style.display!='none'?0:1;else rIndex=rowIndex;setWidths(this.tbl.rows[rIndex]);function setWidths(row)
{if(!o&&(o.nbCells!=o.colWidth.length))return;if(o.nbCells==row.cells.length)
for(var k=0;k<o.nbCells;k++)
row.cells[k].style.width=o.colWidth[k];}},SetVisibleRows:function()
{if(this.hasGrid&&this.hasVisibleRows&&!this.paging)
{for(var i=0;i<this.visibleRows.length;i++)
{if(this.visibleRows[i]<=this.nbRows)
this.SetRowValidation(this.visibleRows[i],true);}}},ClearFilters:function()
{this.EvtManager(this.Evt.name.clear);},_ClearFilters:function()
{if(!this.fltGrid)return;for(var i=0;i<this.fltIds.length;i++)
this.SetFilterValue(i,'');if(this.refreshFilters){this.activeFilterId='';this.RefreshFiltersGrid();}
if(this.rememberPageLen)tf_RemoveCookie(this.pgLenCookie);if(this.rememberPageNb)tf_RemoveCookie(this.pgNbCookie);},ClearActiveColumns:function()
{for(var i=0;i<this.fltIds.length;i++)
tf_RemoveClass(this.GetHeaderElement(i),this.activeColumnsCssClass);},RefreshGrid:function(config)
{var configObj=!config?this.fObj:config;var hasSort=this.sort;if(hasSort)this.sort=false;this.nbRows=this.GetRowsNb();this.RemoveGrid();window['tf_'+this.id]=new TF(this.id,this.startRow,configObj);this.isFirstLoad=true;this.fltIds=[];this._AddGrid();if(hasSort){this.st.setTBody(this.tbl.tBodies[0]);this.sort=true;}},RefreshFiltersGrid:function()
{var slcA1=this.GetFiltersByType(this.fltTypeSlc,true);var slcA2=this.GetFiltersByType(this.fltTypeMulti,true);var slcA3=this.GetFiltersByType(this.fltTypeCheckList,true);var slcIndex=slcA1.concat(slcA2);slcIndex=slcIndex.concat(slcA3);if(this.activeFilterId!=null)
{var activeFlt=this.activeFilterId.split('_')[0];activeFlt=activeFlt.split(this.prfxFlt)[1];var slcSelectedValue;for(var i=0;i<slcIndex.length;i++)
{var curSlc=tf_Id(this.fltIds[slcIndex[i]]);slcSelectedValue=this.GetFilterValue(slcIndex[i]);if(activeFlt!=slcIndex[i]||(this.paging&&slcA1.tf_Has(slcIndex[i])&&activeFlt==slcIndex[i])||(!this.paging&&(slcA3.tf_Has(slcIndex[i])||slcA2.tf_Has(slcIndex[i])))||slcSelectedValue==this.displayAllText)
{if(slcA3.tf_Has(slcIndex[i]))
this.checkListDiv[slcIndex[i]].innerHTML='';else curSlc.innerHTML='';if(this.fillSlcOnDemand){var opt0=tf_CreateOpt(this.displayAllText,'');if(curSlc)curSlc.appendChild(opt0);}
if(slcA3.tf_Has(slcIndex[i]))
this._PopulateCheckList(slcIndex[i]);else
this._PopulateSelect(slcIndex[i],true);this.SetFilterValue(slcIndex[i],slcSelectedValue);}}}},SetColOperation:function()
{if(!this.isFirstLoad&&!this.hasGrid)return;if(this.onBeforeOperation)this.onBeforeOperation.call(null,this);var labelId=this.colOperation['id'];var colIndex=this.colOperation['col'];var operation=this.colOperation['operation'];var outputType=this.colOperation['write_method'];var totRowIndex=this.colOperation['tot_row_index'];var excludeRow=this.colOperation['exclude_row'];var decimalPrecision=this.colOperation['decimal_precision']!=undefined?this.colOperation['decimal_precision']:2;var ucolIndex=[];var ucolMax=0;ucolIndex[ucolMax]=colIndex[0];for(var i=1;i<colIndex.length;i++)
{saved=0;for(var j=0;j<=ucolMax;j++)
{if(ucolIndex[j]==colIndex[i])
saved=1;}
if(saved==0)
{ucolMax++;ucolIndex[ucolMax]=colIndex[i];}}
if((typeof labelId).tf_LCase()=='object'&&(typeof colIndex).tf_LCase()=='object'&&(typeof operation).tf_LCase()=='object')
{var row=this.tbl.rows;var colvalues=[];for(var ucol=0;ucol<=ucolMax;ucol++)
{colvalues.push(this.GetColValues(ucolIndex[ucol],true,excludeRow));var result,nbvalues=0,temp;var meanValue=0,sumValue=0,minValue=null,maxValue=null,q1Value=null,medValue=null,q3Value=null;var meanFlag=0,sumFlag=0,minFlag=0,maxFlag=0,q1Flag=0,medFlag=0,q3Flag=0;var theList=[];var opsThisCol=[],decThisCol=[],labThisCol=[],oTypeThisCol=[];var mThisCol=-1;for(var i=0;i<colIndex.length;i++)
{if(colIndex[i]==ucolIndex[ucol])
{mThisCol++;opsThisCol[mThisCol]=operation[i].tf_LCase();decThisCol[mThisCol]=decimalPrecision[i];labThisCol[mThisCol]=labelId[i];oTypeThisCol=(outputType!=undefined&&(typeof outputType).tf_LCase()=='object')?outputType[i]:null;switch(opsThisCol[mThisCol])
{case'mean':meanFlag=1;break;case'sum':sumFlag=1;break;case'min':minFlag=1;break;case'max':maxFlag=1;break;case'median':medFlag=1;break;case'q1':q1Flag=1;break;case'q3':q3Flag=1;break;}}}
for(var j=0;j<colvalues[ucol].length;j++)
{if((q1Flag==1)||(q3Flag==1)||(medFlag==1))
{if(j<colvalues[ucol].length-1)
{for(k=j+1;k<colvalues[ucol].length;k++){if(eval(colvalues[ucol][k])<eval(colvalues[ucol][j]))
{temp=colvalues[ucol][j];colvalues[ucol][j]=colvalues[ucol][k];colvalues[ucol][k]=temp;}}}}
var cvalue=parseFloat(colvalues[ucol][j]);theList[j]=parseFloat(cvalue);if(!isNaN(cvalue))
{nbvalues++;if((sumFlag==1)||(meanFlag==1))sumValue+=parseFloat(cvalue);if(minFlag==1)
{if(minValue==null)
{minValue=parseFloat(cvalue);}
else minValue=parseFloat(cvalue)<minValue?parseFloat(cvalue):minValue;}
if(maxFlag==1){if(maxValue==null)
{maxValue=parseFloat(cvalue);}
else{maxValue=parseFloat(cvalue)>maxValue?parseFloat(cvalue):maxValue;}}}}
if(meanFlag==1)meanValue=sumValue/nbvalues;if(medFlag==1)
{var aux=0;if(nbvalues%2==1)
{aux=Math.floor(nbvalues/2);medValue=theList[aux];}
else medValue=(theList[nbvalues/2]+theList[((nbvalues/2)-1)])/2;}
if(q1Flag==1)
{var posa=0.0;posa=Math.floor(nbvalues/4);if(4*posa==nbvalues){q1Value=(theList[posa-1]+theList[posa])/2;}
else{q1Value=theList[posa];}}
if(q3Flag==1)
{var posa=0.0;var posb=0.0;posa=Math.floor(nbvalues/4);if(4*posa==nbvalues)
{posb=3*posa;q3Value=(theList[posb]+theList[posb-1])/2;}
else
q3Value=theList[nbvalues-posa-1];}
for(var i=0;i<=mThisCol;i++)
{switch(opsThisCol[i])
{case'mean':result=meanValue;break;case'sum':result=sumValue;break;case'min':result=minValue;break;case'max':result=maxValue;break;case'median':result=medValue;break;case'q1':result=q1Value;break;case'q3':result=q3Value;break;}
var precision=decThisCol[i]!=undefined&&!isNaN(decThisCol[i])?decThisCol[i]:2;if(oTypeThisCol!=null&&result)
{result=result.toFixed(precision);if(tf_Id(labThisCol[i])!=undefined)
{switch(oTypeThisCol.tf_LCase())
{case'innerhtml':if(isNaN(result)||!isFinite(result)||(nbvalues==0))
tf_Id(labThisCol[i]).innerHTML='.';else
tf_Id(labThisCol[i]).innerHTML=result;break;case'setvalue':tf_Id(labThisCol[i]).value=result;break;case'createtextnode':var oldnode=tf_Id(labThisCol[i]).firstChild;var txtnode=tf_CreateText(result);tf_Id(labThisCol[i]).replaceChild(txtnode,oldnode);break;}}}else{try
{if(isNaN(result)||!isFinite(result)||(nbvalues==0))
tf_Id(labThisCol[i]).innerHTML='.';else
tf_Id(labThisCol[i]).innerHTML=result.toFixed(precision);}catch(e){}}}
if(totRowIndex!=undefined&&row[totRowIndex[ucol]])
row[totRowIndex[ucol]].style.display='';}}
if(this.onAfterOperation)this.onAfterOperation.call(null,this);},UnhighlightAll:function()
{if(this.highlightKeywords&&this.searchArgs!=null)
for(var y=0;y<this.searchArgs.length;y++)
tf_UnhighlightWord(this.tbl,this.searchArgs[y],this.highlightCssClass);},__resetGrid:function()
{if(this.isFirstLoad)return;if(!this.gridLayout){var thead=tf_Tag(this.tbl,'thead');if(thead.length>0)
if(this.filtersRowIndex==0)
thead[0].rows[this.filtersRowIndex].parentNode.insertBefore(this.fltGridEl,thead[0].rows[this.filtersRowIndex]);else
thead[0].appendChild(this.fltGridEl);else
this.tbl.rows[this.filtersRowIndex].parentNode.insertBefore(this.fltGridEl,this.tbl.rows[this.filtersRowIndex]);}
if(this.isExternalFlt)
{for(var ct=0;ct<this.externalFltTgtIds.length;ct++)
if(tf_Id(this.externalFltTgtIds[ct])){tf_Id(this.externalFltTgtIds[ct]).appendChild(this.externalFltEls[ct]);if(this.gridLayout&&this.externalFltEls[ct].innerHTML==''&&this['col'+ct]!=this.fltTypeInp){if(this['col'+ct]==this.fltTypeSlc||this['col'+ct]==this.fltTypeMulti)
this.PopulateSelect(ct);if(this['col'+ct]==this.fltTypeCheckList)this.PopulateCheckList(ct);}}}
this.nbFilterableRows=this.GetRowsNb();this.nbVisibleRows=this.nbFilterableRows;this.nbRows=this.tbl.rows.length;if(this.isSortEnabled)this.sort=true;if(this.tbl.rows[this.filtersRowIndex].innerHTML=='')
refreshFilters(this);else
if(this.popUpFilters)this.SetPopupFilters();function refreshFilters(o){o.tbl.deleteRow(o.filtersRowIndex);o.RemoveGrid();o.fltIds=[];o.isFirstLoad=true;if(o.popUpFilters)o.RemovePopupFilters();o._AddGrid();}
if(!this.gridLayout)tf_AddClass(this.tbl,this.prfxTf);this.hasGrid=true;},__containsStr:function(arg,data,fltType,forceMatch)
{var regexp;var modifier=(this.matchCase)?'g':'gi';var exactMatch=(forceMatch==undefined)?this.exactMatch:forceMatch;if(exactMatch||(fltType!=this.fltTypeInp&&fltType!=undefined))
regexp=new RegExp('(^\\s*)'+tf_RegexpEscape(arg)+'(\\s*$)',modifier);else
regexp=new RegExp(tf_RegexpEscape(arg),modifier);return regexp.test(data);},IncludeFile:function(fileId,filePath,callback,type)
{var ftype=(type==undefined)?'script':type;var isImported=tf_IsImported(filePath,ftype);if(isImported)return;var o=this,isLoaded=false,file;var head=tf_Tag(document,'head')[0];if(ftype.tf_LCase()=='link')
file=tf_CreateElm('link',['id',fileId],['type','text/css'],['rel','stylesheet'],['href',filePath]);else
file=tf_CreateElm('script',['id',fileId],['type','text/javascript'],['src',filePath]);file.onload=file.onreadystatechange=function()
{if(!isLoaded&&(!this.readyState||this.readyState=='loaded'||this.readyState=='complete'))
{isLoaded=true;if(typeof callback==='function')callback.call(null,o);}}
head.appendChild(file);},HasGrid:function()
{return this.hasGrid;},GetFiltersId:function()
{if(!this.hasGrid)return;return this.fltIds;},GetValidRowsIndex:function()
{if(!this.hasGrid)return;return this.validRowsIndex;},GetFiltersRowIndex:function()
{if(!this.hasGrid)return;return this.filtersRowIndex;},GetHeadersRowIndex:function()
{if(!this.hasGrid)return;return this.headersRow;},GetStartRowIndex:function()
{if(!this.hasGrid)return;return this.refRow;},GetLastRowIndex:function()
{if(!this.hasGrid)return;return(this.nbRows-1);},GetHeaderElement:function(colIndex)
{var table=(this.gridLayout)?this.headTbl:this.tbl;var header,tHead=tf_Tag(this.tbl,'thead');for(var i=0;i<this.nbCells;i++)
{if(i!=colIndex)continue;if(tHead.length==0)
header=table.rows[this.headersRow].cells[i];if(tHead.length==1)
header=tHead[0].rows[this.headersRow].cells[i];break;}
return header;}}
function tf_GetNodeText(n)
{var s=n.textContent||n.innerText||n.innerHTML.replace(/\<[^<>]+>/g,'');return s.replace(/^\s+/,'').replace(/\s+$/,'').tf_Trim();}
function tf_IsObj(v)
{var isO=false;if((typeof v).tf_LCase()=='string'){if(window[v]&&(typeof window[v]).tf_LCase()=='object')
isO=true;}else{if(v&&(typeof v).tf_LCase()=='object')
isO=true;}
return isO;}
function tf_IsFn(fn)
{return(fn&&fn.constructor==Function);}
function tf_IsArray(obj){return obj.constructor==Array;}
function tf_Id(id)
{return document.getElementById(id);}
function tf_Tag(o,tagname)
{return o.getElementsByTagName(tagname);}
function tf_RegexpEscape(s)
{function escape(e)
{a=new RegExp('\\'+e,'g');s=s.replace(a,'\\'+e);}
chars=new Array('\\','[','^','$','.','|','?','*','+','(',')');for(var e=0;e<chars.length;e++)escape(chars[e]);return s;}
function tf_CreateElm(tag)
{if(tag==undefined||tag==null||tag=='')return;var el=document.createElement(tag);if(arguments.length>1)
{for(var i=0;i<arguments.length;i++)
{var argtype=typeof arguments[i];switch(argtype.tf_LCase())
{case'object':if(arguments[i].length==2)
{el.setAttribute(arguments[i][0],arguments[i][1]);}
break;}}}
return el;}
function tf_CreateText(node)
{return document.createTextNode(node);}
function tf_CreateOpt(text,value,isSel)
{var isSelected=isSel?true:false;var opt=(isSelected)?tf_CreateElm('option',['value',value],['selected','true']):tf_CreateElm('option',['value',value]);opt.appendChild(tf_CreateText(text));return opt;}
function tf_CreateCheckItem(chkIndex,chkValue,labelText)
{if(chkIndex==undefined||chkValue==undefined||labelText==undefined)
return;var li=tf_CreateElm('li');var label=tf_CreateElm('label',['for',chkIndex]);var check=tf_CreateElm('input',['id',chkIndex],['name',chkIndex],['type','checkbox'],['value',chkValue]);label.appendChild(check);label.appendChild(tf_CreateText(labelText));li.appendChild(label);li.label=label;li.check=check;return li;}
function tf_AddEvent(obj,event_name,func_name,use_capture){if(obj.attachEvent)
obj.attachEvent('on'+event_name,func_name);else if(obj.addEventListener)
obj.addEventListener(event_name,func_name,(use_capture==undefined?false:use_capture));else
obj['on'+event_name]=func_name;}
function tf_RemoveEvent(obj,event_name,func_name,use_capture){if(obj.detachEvent)
obj.detachEvent('on'+event_name,func_name);else if(obj.removeEventListener)
obj.removeEventListener(event_name,func_name,(use_capture==undefined?false:use_capture));else
obj['on'+event_name]=null;}
function tf_StopEvent(e){if(!e)e=window.event;if(e.stopPropagation){e.stopPropagation();}else{e.cancelBubble=true;}}
function tf_CancelEvent(e){if(!e)e=window.event;if(e.preventDefault){e.preventDefault();}else{e.returnValue=false;}}
function tf_ObjPosition(obj,tag){var l=0,t=0;if(obj&&obj.offsetParent&&tag.tf_Has(obj.nodeName.tf_LCase())){do{l+=obj.offsetLeft;t+=obj.offsetTop;}while(obj=obj.offsetParent);}
return[l,t];}
function tf_NumSortAsc(a,b){return(a-b);}
function tf_NumSortDesc(a,b){return(b-a);}
function tf_IgnoreCaseSort(a,b){var x=a.tf_LCase();var y=b.tf_LCase();return((x<y)?-1:((x>y)?1:0));}
String.prototype.tf_MatchCase=function(mc){if(!mc)return this.tf_LCase();else return this.toString();}
String.prototype.tf_Trim=function()
{return this.replace(/(^[\s\xA0]*)|([\s\xA0]*$)/g,'');}
String.prototype.tf_LCase=function(){return this.toLowerCase();}
String.prototype.tf_UCase=function(){return this.toUpperCase();}
Array.prototype.tf_Has=function(s,mc){var sCase=(mc==undefined)?false:mc;for(i=0;i<this.length;i++)
if(this[i].toString().tf_MatchCase(sCase)==s)return true;return false;}
Array.prototype.tf_IndexByValue=function(s,mc){var sCase=(mc==undefined)?false:mc;for(i=0;i<this.length;i++)
if(this[i].toString().tf_MatchCase(sCase)==s)return i;return(-1);}
window['tf_isIE']=(window.innerHeight)?false:/msie|MSIE 6/.test(navigator.userAgent)?true:false;window['tf_isIE7']=(window.innerHeight)?false:/msie|MSIE 7/.test(navigator.userAgent)?true:false;function tf_HasClass(elm,cl){if(!elm)return false;return elm.className.match(new RegExp('(\\s|^)'+cl+'(\\s|$)'));}
function tf_AddClass(elm,cl){if(!elm)return;if(!tf_HasClass(elm,cl))
elm.className+=' '+cl;}
function tf_RemoveClass(elm,cl){if(!elm)return;if(!tf_HasClass(elm,cl))return;var reg=new RegExp('(\\s|^)'+cl+'(\\s|$)');elm.className=elm.className.replace(reg,'');}
function tf_IsValidDate(dateStr,format){if(format==null){format='DMY';}
format=format.toUpperCase();if(format.length!=3){if(format=='DDMMMYYYY'){var d=tf_FormatDate(dateStr,format);dateStr=d.getDate()+'/'+(d.getMonth()+1)+'/'+d.getFullYear();format='DMY';}}
if((format.indexOf('M')==-1)||(format.indexOf('D')==-1)||(format.indexOf('Y')==-1)){format='DMY';}
if(format.substring(0,1)=='Y'){var reg1=/^\d{2}(\-|\/|\.)\d{1,2}\1\d{1,2}$/;var reg2=/^\d{4}(\-|\/|\.)\d{1,2}\1\d{1,2}$/;}else if(format.substring(1,2)=='Y'){var reg1=/^\d{1,2}(\-|\/|\.)\d{2}\1\d{1,2}$/;var reg2=/^\d{1,2}(\-|\/|\.)\d{4}\1\d{1,2}$/;}else{var reg1=/^\d{1,2}(\-|\/|\.)\d{1,2}\1\d{2}$/;var reg2=/^\d{1,2}(\-|\/|\.)\d{1,2}\1\d{4}$/;}
if((reg1.test(dateStr)==false)&&(reg2.test(dateStr)==false)){return false;}
var parts=dateStr.split(RegExp.$1);if(format.substring(0,1)=='M'){var mm=parts[0];}else
if(format.substring(1,2)=='M'){var mm=parts[1];}else{var mm=parts[2];}
if(format.substring(0,1)=='D'){var dd=parts[0];}else
if(format.substring(1,2)=='D'){var dd=parts[1];}else{var dd=parts[2];}
if(format.substring(0,1)=='Y'){var yy=parts[0];}else
if(format.substring(1,2)=='Y'){var yy=parts[1];}else{var yy=parts[2];}
if(parseFloat(yy)<=50){yy=(parseFloat(yy)+2000).toString();}
if(parseFloat(yy)<=99){yy=(parseFloat(yy)+1900).toString();}
var dt=new Date(parseFloat(yy),parseFloat(mm)-1,parseFloat(dd),0,0,0,0);if(parseFloat(dd)!=dt.getDate()){return false;}
if(parseFloat(mm)-1!=dt.getMonth()){return false;}
return true;}
function tf_FormatDate(dateStr,format){if(format==null)format='DMY';var oDate,parts;function y2kDate(yr){if(yr==undefined)return 0;if(yr.length>2)return yr;var y;if(yr<=99&&yr>50)
y='19'+yr;if(yr<50||yr=='00')
y='20'+yr;return y;}
function mmm2mm(mmm){if(mmm==undefined)return 0;var mondigit;var MONTH_NAMES=new Array('january','february','march','april','may','june','july','august','september','october','november','december','jan','feb','mar','apr','may','jun','jul','aug','sep','oct','nov','dec');for(var m_i=0;m_i<MONTH_NAMES.length;m_i++){var month_name=MONTH_NAMES[m_i];if(mmm.toLowerCase()==month_name){mondigit=m_i+1;break;}}
if((mondigit>11)||(mondigit<23)){mondigit=mondigit-12;}
if((mondigit<1)||(mondigit>12)){return 0;}
return mondigit;}
switch(format.toUpperCase())
{case'DDMMMYYYY':parts=dateStr.replace(/[- \/.]/g,' ').split(' ');oDate=new Date(y2kDate(parts[2]),mmm2mm(parts[1])-1,parts[0]);break;case'DMY':parts=dateStr.replace(/^(0?[1-9]|[12][0-9]|3[01])([- \/.])(0?[1-9]|1[012])([- \/.])((\d\d)?\d\d)$/,'$1 $3 $5').split(' ');oDate=new Date(y2kDate(parts[2]),parts[1]-1,parts[0]);break;case'MDY':parts=dateStr.replace(/^(0?[1-9]|1[012])([- \/.])(0?[1-9]|[12][0-9]|3[01])([- \/.])((\d\d)?\d\d)$/,'$1 $3 $5').split(' ');oDate=new Date(y2kDate(parts[2]),parts[0]-1,parts[1]);break;case'YMD':parts=dateStr.replace(/^((\d\d)?\d\d)([- \/.])(0?[1-9]|1[012])([- \/.])(0?[1-9]|[12][0-9]|3[01])$/,'$1 $4 $6').split(' ');oDate=new Date(y2kDate(parts[0]),parts[1]-1,parts[2]);break;default:parts=dateStr.replace(/^(0?[1-9]|[12][0-9]|3[01])([- \/.])(0?[1-9]|1[012])([- \/.])((\d\d)?\d\d)$/,'$1 $3 $5').split(' ');oDate=new Date(y2kDate(parts[2]),parts[1]-1,parts[0]);break;}
return oDate;}
function tf_RemoveNbFormat(data,format){if(data==null)return;if(format==null)format='us';var n=data;if(format.tf_LCase()=='us')
n=+n.replace(/[^\d\.-]/g,'');else
n=+n.replace(/[^\d\,-]/g,'').replace(',','.');return n;}
function tf_IsImported(filePath,type){var isImported=false;var importType=(type==undefined)?'script':type;var attr=importType=='script'?'src':'href';var files=tf_Tag(document,importType);for(var i=0;i<files.length;i++)
{if(files[i][attr]==undefined)continue;if(files[i][attr].match(filePath))
{isImported=true;break;}}
return isImported;}
function tf_IsStylesheetImported(stylesheet){var isImported=false;if(!document.styleSheets)return isImported;var s=document.styleSheets;var regexp=new RegExp(stylesheet);for(var i=0;i<s.length;i++){if(s[i].imports){var imp=s[i].imports;for(var j=0;j<imp.length;j++){if(imp[j].href.tf_LCase()==stylesheet.tf_LCase()){isImported=true;break;}}}else{var r=(s[i].cssRules?s[i].cssRules:s[i].rules);for(var j=0;j<r.length;j++){if(regexp.test(r[j].cssText)){isImported=true;break;}}}}
return isImported;}
function tf_WriteCookie(name,value,hours){var expire='';if(hours!=null)
{expire=new Date((new Date()).getTime()+hours*3600000);expire='; expires='+expire.toGMTString();}
document.cookie=name+'='+escape(value)+expire;}
function tf_ReadCookie(name){var cookieValue='';var search=name+'=';if(document.cookie.length>0)
{offset=document.cookie.indexOf(search);if(offset!=-1)
{offset+=search.length;end=document.cookie.indexOf(';',offset);if(end==-1)end=document.cookie.length;cookieValue=unescape(document.cookie.substring(offset,end))}}
return cookieValue;}
function tf_CookieValueArray(name){var val=tf_ReadCookie(name);var arr=val.split(',');return arr;}
function tf_CookieValueByIndex(name,index){var val=tf_CookieValueArray(name);return val[index];}
function tf_RemoveCookie(name){tf_WriteCookie(name,'',-1);}
function tf_HighlightWord(node,word,cssClass)
{if(node.hasChildNodes)
for(var i=0;i<node.childNodes.length;i++)
tf_HighlightWord(node.childNodes[i],word,cssClass);if(node.nodeType==3)
{var tempNodeVal=node.nodeValue.tf_LCase();var tempWordVal=word.tf_LCase();if(tempNodeVal.indexOf(tempWordVal)!=-1)
{var pn=node.parentNode;if(pn.className!=cssClass)
{var nv=node.nodeValue;var ni=tempNodeVal.indexOf(tempWordVal);var before=tf_CreateText(nv.substr(0,ni));var docWordVal=nv.substr(ni,word.length);var after=tf_CreateText(nv.substr(ni+word.length));var hiwordtext=tf_CreateText(docWordVal);var hiword=tf_CreateElm('span');hiword.className=cssClass;hiword.appendChild(hiwordtext);pn.insertBefore(before,node);pn.insertBefore(hiword,node);pn.insertBefore(after,node);pn.removeChild(node);}}}}
function tf_UnhighlightWord(node,word,cssClass)
{if(node.hasChildNodes)
for(var i=0;i<node.childNodes.length;i++)
tf_UnhighlightWord(node.childNodes[i],word,cssClass);if(node.nodeType==3)
{var tempNodeVal=node.nodeValue.tf_LCase();var tempWordVal=word.tf_LCase();if(tempNodeVal.indexOf(tempWordVal)!=-1)
{var pn=node.parentNode;if(pn.className==cssClass)
{var prevSib=pn.previousSibling;var nextSib=pn.nextSibling;nextSib.nodeValue=prevSib.nodeValue+node.nodeValue+nextSib.nodeValue;prevSib.nodeValue='';node.nodeValue='';}}}}
function tf_SetOuterHtml(){if(document.body.__defineGetter__){if(HTMLElement){var element=HTMLElement.prototype;if(element.__defineGetter__){element.__defineGetter__("outerHTML",function(){var parent=this.parentNode;var el=tf_CreateElm(parent.tagName);el.appendChild(this);var shtml=el.innerHTML;parent.appendChild(this);return shtml;});}}}
if(element.__defineSetter__){HTMLElement.prototype.__defineSetter__("outerHTML",function(sHTML){var r=this.ownerDocument.createRange();r.setStartBefore(this);var df=r.createContextualFragment(sHTML);this.parentNode.replaceChild(df,this);return sHTML;});}}
function grabEBI(id){return tf_Id(id);}
function grabTag(obj,tagname){return tf_Tag(obj,tagname);}
function tf_GetCellText(n){return tf_GetNodeText(n);}
function tf_isObject(varname){return tf_IsObj(varname);}
function tf_isObj(v){return tf_IsObj(v);}
function tf_isFn(fn){return tf_IsFn(fn);}
function tf_isArray(obj){return tf_IsArray(obj);}
function tf_addEvent(obj,event_name,func_name){return tf_AddEvent(obj,event_name,func_name);}
function tf_removeEvent(obj,event_name,func_name){return tf_RemoveEvent(obj,event_name,func_name);}
function tf_addClass(elm,cl){tf_AddClass(elm,cl);}
function tf_removeClass(elm,cl){return tf_RemoveClass(elm,cl);}
function tf_hasClass(elm,cl){return tf_HasClass(elm,cl);}
function tf_isValidDate(dateStr,format){return tf_IsValidDate(dateStr,format);}
function tf_formatDate(dateStr,format){return tf_FormatDate(dateStr,format);}
function tf_removeNbFormat(data,format){return tf_RemoveNbFormat(data,format);}