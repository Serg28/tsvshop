                                    /**
 * TSVshopLastViews
 *
 * Сниппет истории просмотренных товаров для TSVshop
 *
 * @category    snippet
 * @version     5.4
 * @license     http://www.gnu.org/copyleft/gpl.html GNU Public License (GPL)
 * @internal    @properties
 * @internal    @modx_category TSVshop
 * @internal    @installset base, sample
 *
 * @author      sazanof <m@sazanof.ru>, Telnij Sergey (Serg24) <privat_tel@mail.ru>, http://tsvshop.xyz
 * -----------------------------------------------------------------------------
 */
	
/*
* ВНИМАНИЕ:
* Сниппет нужно вызывать на всех страницах, которые нужно учитывать в историю просмотра, а также там, где нужно выводить эту историю.
* Страница, где нет вызова сниппета, не будет учитываться в историю. Если на ней не нужно выводить историю, а только учесть ее, нужно 
* указать в вызове сниппет параметр &mode=`save`
*
* placeholders
* [+count_recent+] - кол-во просмотренных ресурсов
* [+lines+] - наименования
* [+unset+] - ссылка на сброс истории просмотра
* [+itemId+] - ИД ресурса
* [+itemPageTitle+] - название ресурса pagetitle
*
* &id = ИД вызова (при нескольких вызовах сниппета на странице, для предотвращения конфликта)
* &mode = режим вывода: список ИД (значение: ids), 
		  сформированный html (значение: html), 
		  ничего не выводит - (значение: save), если нужно только учесть документ в историю, но ничего не выводить
* &templateID = список ИД шаблонов страницы, к которым применять историю
* &tpl = имя чанка с контейнером, куда выводится наименования ресурсов
* &itemTpl = имя чанка, выводящего каждое наименование ресурса
* &limit = кол-во выводимых в истории ресурсов (по-умолчанию 5)
* &toPH = если равно 1, то выводит результат выполнения сниппета в плейсхолдер id.output  (id - это то, что указано в &id)
*/

$docid = $modx->documentIdentifier;
$tpl = isset($tpl) ? $modx->getChunk($tpl) : '<div class="recent">[+count_recent+]<ul>[+lines+]</ul></div>';
$templateID = isset($templateID) ? $templateID : '4';
$id = isset($id) ? $id : '';
$prefix = isset($id) ? $id.'.' : '';
$toPH = isset($toPH) ? $toPH : '0';
$mode = isset($mode) ? $mode : 'ids'; // ids - выводит только ИД документов через запятую, иначе - сформированный HTML-код
$itemTpl = isset($itemTpl) ? $modx->getChunk($itemTpl) : '<li><a target="_blank" href="[~[+itemId+]~]">[+itemPageTitle+]</a></li>';
$limit = isset($limit) ? $limit : 5;
$unset = '<a class="unset_recent" href="[~[*id*]~]&unset=recent">очистить</a>'; //$count=1;
$ch = $modx->getDocument($docid);
$temp = explode(',', $templateID);

if(!empty($_GET['unset']) && $_GET['unset']=='recent') {
unset($_SESSION[$id.'goods']);
}

foreach($temp as $value)
{
	if ($ch['template'] == $value)
	{
		if (is_array($_SESSION[$id.'goods']['viewed']))
		{
			if (!in_array($docid, $_SESSION[$id.'goods']['viewed']))
			{
				$_SESSION[$id.'goods']['viewed'][] = $docid;
			}
		}
		else
		{
			$_SESSION[$id.'goods']['viewed'] = array();
		}
	}
}

if (count($_SESSION[$id.'goods']['viewed']) > $limit)
{
	array_shift($_SESSION[$id.'goods']['viewed']);
}

if (is_array($_SESSION[$id.'goods']['viewed']))
{
	$SV = array_reverse($_SESSION[$id.'goods']['viewed']);
	foreach($SV as $itemId)
	{
		$res = $modx->getDocument($itemId); //get need resource
		$tp.= str_replace(array(
			'[+itemId+]',
			'[+itemPageTitle+]'
		) , array(
			$res['id'],
			$res['pagetitle']
		) , $itemTpl);
	}

	$count = count($SV);
	$modx->setPlaceholder($prefix.'count_recent', $count);
	$modx->setPlaceholder($prefix.'lines', $tp);
	$modx->setPlaceholder($prefix.'unset', $unset);
	$output = $tpl;
}

if (!empty($SV))
{
	if ($mode=='ids' || empty($mode)) {
    return ($toPH) ? $modx->setPlaceholder($prefix.'output',$res) : $res;
	} else if ($mode=='html') {
    return ($toPH) ? $modx->setPlaceholder($prefix.'output',$output) : $output;
	} else if ($mode=='save') {
		return;
	} else return;
}

