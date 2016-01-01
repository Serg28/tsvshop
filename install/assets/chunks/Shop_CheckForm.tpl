/**
 * Shop_CheckForm
 *
 * Шаблон квитанции-счета для оплаты банковским платежем в TSVshop
 *
 * @category	chunk
 * @version 	5.3
 * @license 	http://www.gnu.org/copyleft/gpl.html GNU Public License (GPL)
 * @internal  @modx_category TSVshop
 * @internal  @installset base, sample
* @author     Telnij Sergey (Serg24) <privat_tel@mail.ru>, http://tsvshop.tsv.org.ua, http://tsvshop.xyz 
 */


<STYLE TYPE="text/css">
body { background: #ffffff; margin: 0; font-family: Arial; font-size: 8pt; font-style: normal; }
tr.R0{ height: 34pt; }
tr.R0 td.R0C1{ text-align: center; vertical-align: medium; }
tr.R0 td.R10C1{ font-family: Arial; font-size: 14pt; font-style: normal; font-weight: bold; vertical-align: medium; border-bottom: #000000 2px solid; }
td.R11C1{ font-family: Arial; font-size: 8pt; font-style: normal; font-weight: bold; }
td.R13C1{ font-family: Arial; font-size: 9pt; font-style: normal; vertical-align: medium; }
td.R13C7{ font-family: Arial; font-size: 9pt; font-style: normal; font-weight: bold; vertical-align: top; }
td.R1C1{ font-family: Arial; font-size: 10pt; font-style: normal; }
td.R21C1{ font-family: Arial; font-size: 10pt; font-style: normal; font-weight: bold; text-align: center; vertical-align: medium; border-left: #000000 2px solid; border-top: #000000 2px solid; }
td.R21C3{ font-family: Arial; font-size: 10pt; font-style: normal; font-weight: bold; text-align: center; vertical-align: medium; border-left: #000000 1px solid; border-top: #000000 2px solid; }
td.R21C33{ font-family: Arial; font-size: 10pt; font-style: normal; font-weight: bold; text-align: center; vertical-align: medium; border-left: #000000 1px solid; border-top: #000000 2px solid; border-right: #000000 2px solid; }
td.R22C1{ text-align: center; vertical-align: top; border-left: #000000 2px solid; border-top: #000000 1px solid; }
td.R22C24{ text-align: right; vertical-align: top; border-left: #000000 1px solid; border-top: #000000 1px solid; }
td.R22C3{ text-align: left; vertical-align: top; border-left: #000000 1px solid; border-top: #000000 1px solid; }
td.R22C33{ text-align: right; vertical-align: top; border-left: #000000 1px solid; border-top: #000000 1px solid; border-right: #000000 2px solid; }
tr.R23{ height: 7pt; }
tr.R23 td.R23C1{ vertical-align: top; border-top: #000000 2px solid; }
tr.R23 td.R23C29{ font-family: Arial; font-size: 10pt; font-style: normal; font-weight: bold; text-align: right; vertical-align: top; border-top: #000000 2px solid; }
tr.R23 td.R23C30{ border-top: #000000 2px solid; }
td.R24C1{ vertical-align: top; }
td.R24C29{ font-family: Arial; font-size: 10pt; font-style: normal; font-weight: bold; text-align: right; vertical-align: top; }
td.R25C1{ font-family: Arial; font-size: 10pt; font-style: normal; text-align: left; }
td.R26C1{ font-family: Arial; font-size: 10pt; font-style: normal; font-weight: bold; vertical-align: top; }
td.R2C1{ font-family: Arial; font-size: 10pt; font-style: normal; text-align: left; vertical-align: top; border-left: #000000 1px solid; border-top: #000000 1px solid; }
td.R2C19{ font-family: Arial; font-size: 10pt; font-style: normal; text-align: left; vertical-align: medium; border-left: #000000 1px solid; border-top: #000000 1px solid; }
td.R2C22{ font-family: Arial; font-size: 10pt; font-style: normal; text-align: left; vertical-align: medium; border-left: #000000 1px solid; border-top: #000000 1px solid; border-right: #000000 1px solid; }
td.R30C1{ font-family: Arial; font-size: 9pt; font-style: normal; font-weight: bold; vertical-align: medium; }
td.R30C17{ font-family: Arial; font-size: 9pt; font-style: normal; border-bottom: #000000 1px solid; }
td.R30C26{ border-bottom: #000000 1px solid; }
td.R30C27{ font-family: Arial; font-size: 9pt; font-style: normal; }
td.R30C7{ font-family: Arial; font-size: 10pt; font-style: normal; font-weight: bold; text-align: center; border-bottom: #000000 1px solid; }
td.R31C7{ text-align: center; vertical-align: top; }
td.R32C16{ font-family: Arial; font-size: 9pt; font-style: normal; border-bottom: #ffffff 1px none; }
td.R32C28{ font-family: Arial; font-size: 10pt; font-style: normal; font-weight: bold; text-align: center; border-bottom: #ffffff 1px none; }
td.R32C8{ border-bottom: #ffffff 1px none; }
td.R35C10{ text-align: right; vertical-align: medium; border-bottom: #ffffff 1px none; }
td.R35C6{ vertical-align: medium; border-bottom: #ffffff 1px none; }
td.R3C22{ font-family: Arial; font-size: 10pt; font-style: normal; text-align: left; vertical-align: top; border-left: #000000 1px solid; border-right: #000000 1px solid; }
td.R4C1{ font-family: Arial; font-size: 8pt; font-style: normal; border-left: #000000 1px solid; border-right: #000000 1px solid; }
td.R5C10{ font-family: Arial; font-size: 10pt; font-style: normal; text-align: left; vertical-align: medium; border-left: #000000 1px solid; border-top: #000000 1px solid; border-bottom: #000000 1px solid; }
td.R5C19{ font-family: Arial; font-size: 10pt; font-style: normal; vertical-align: top; border-left: #000000 1px solid; border-top: #000000 1px solid; border-bottom: #000000 1px solid; }
td.R5C22{ font-family: Arial; font-size: 10pt; font-style: normal; text-align: left; vertical-align: top; border-left: #000000 1px solid; border-top: #000000 1px solid; border-bottom: #000000 1px solid; border-right: #000000 1px solid; }
td.R5C3{ font-family: Arial; font-size: 10pt; font-style: normal; text-align: left; vertical-align: medium; border-top: #000000 1px solid; border-bottom: #000000 1px solid; }
td.R6C1{ font-family: Arial; font-size: 10pt; font-style: normal; text-align: left; vertical-align: top; border-left: #000000 1px solid; border-top: #000000 1px solid; border-right: #000000 1px solid; }
td.R8C1{ font-family: Arial; font-size: 8pt; font-style: normal; border-left: #000000 1px solid; border-bottom: #000000 1px solid; border-right: #000000 1px solid; }
table {table-layout: fixed; padding: 0 0 0 1px; width: 100%; font-family: Arial; font-size: 8pt; font-style: normal; }
td { padding-left: 3px; }
</STYLE>



<TABLE CELLSPACING=0>
<COL WIDTH="7">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">

<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">

<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="7">

<TR CLASS=R0>
<TD>&nbsp;</TD>
<TD CLASS=R0C1 COLSPAN=37>Внимание!&nbsp;Оплата&nbsp;данного&nbsp;счета&nbsp;означает&nbsp;согласие&nbsp;с&nbsp;условиями&nbsp;поставки&nbsp;товара.&nbsp;Уведомление&nbsp;об&nbsp;оплате&nbsp;<BR>&nbsp;обязательно,&nbsp;в&nbsp;противном&nbsp;случае&nbsp;не&nbsp;гарантируется&nbsp;наличие&nbsp;товара&nbsp;на&nbsp;складе.&nbsp;Товар&nbsp;отпускается&nbsp;по&nbsp;факту<BR>&nbsp;прихода&nbsp;денег&nbsp;на&nbsp;р/с&nbsp;Поставщика,&nbsp;самовывозом,&nbsp;при&nbsp;наличии&nbsp;доверенности&nbsp;и&nbsp;паспорта.</TD>

<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
</TR>
<TR>
<TD>&nbsp;</TD>
<TD CLASS=R1C1>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>

<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD CLASS=R1C1>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD CLASS=R1C1>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>

<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
</TR>
<TR>
<TD>&nbsp;</TD>
<TD CLASS=R2C1 COLSPAN=18 ROWSPAN=2>АКБ "АБСОЛЮТ БАНК" (ЗАО) Г. МОСКВА</TD>
<TD CLASS=R2C19 COLSPAN=3>БИК</TD>

<TD CLASS=R2C22 COLSPAN=16>044525976</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
</TR>
<TR>
<TD>&nbsp;</TD>
<TD CLASS=R2C1 COLSPAN=3 ROWSPAN=2>Сч.&nbsp;№</TD>
<TD CLASS=R3C22 COLSPAN=16 ROWSPAN=2>30101810500000000976</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
</TR>
<TR>
<TD>&nbsp;</TD>

<TD CLASS=R4C1 COLSPAN=18>Банк&nbsp;получателя</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
</TR>
<TR>
<TD>&nbsp;</TD>
<TD CLASS=R2C19 COLSPAN=2>ИНН</TD>
<TD CLASS=R5C3 COLSPAN=7>5008050193</TD>
<TD CLASS=R5C10 COLSPAN=2>КПП</TD>
<TD CLASS=R5C3 COLSPAN=7>500801001</TD>
<TD CLASS=R5C19 COLSPAN=3 ROWSPAN=4>Сч.&nbsp;№</TD>

<TD CLASS=R5C22 COLSPAN=16 ROWSPAN=4>40702810122000016053</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
</TR>
<TR>
<TD>&nbsp;</TD>
<TD CLASS=R6C1 COLSPAN=18 ROWSPAN=2>ООО "ЛеоРин Консалтинг"</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
</TR>
<TR>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
</TR>

<TR>
<TD>&nbsp;</TD>
<TD CLASS=R8C1 COLSPAN=18>Получатель</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
</TR>
<TR>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>

<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>

<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
</TR>
<TR CLASS=R0>
<TD>&nbsp;</TD>

<TD CLASS=R10C1 COLSPAN=37>Счет&nbsp;на&nbsp;оплату&nbsp;№&nbsp;[+shop.numorder_bukva+]&nbsp;от&nbsp;[+shop.dateorder_full+]</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
</TR>
<TR>
<TD>&nbsp;</TD>
<TD CLASS=R11C1 COLSPAN=39>Счет&nbsp;действителен&nbsp;в&nbsp;течении&nbsp;трех&nbsp;банковских&nbsp;дней.</TD>

</TR>
<TR>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>

<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>

<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
</TR>
<TR>
<TD>&nbsp;</TD>
<TD CLASS=R13C1 COLSPAN=6>Поставщик:</TD>
<TD CLASS=R13C7 COLSPAN=31>ООО "ЛеоРин Консалтинг", ИНН 5008050193, КПП 500801001, 141707, Московская обл, Долгопрудный г, Заводская ул, дом № 7</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>

</TR>
<TR>
<TD>&nbsp;</TD>
<TD CLASS=R13C1>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD CLASS=R13C7>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD CLASS=R13C7>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>

<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>

<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
</TR>
<TR>
<TD>&nbsp;</TD>
<TD CLASS=R13C1 COLSPAN=6>Грузоотправитель:</TD>
<TD CLASS=R13C7 COLSPAN=31>ООО "ЛеоРин Консалтинг", ИНН 5008050193, КПП 500801001, 141707, Московская обл, Долгопрудный г, Заводская ул, дом № 7</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>

</TR>
<TR>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>

<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>

<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
</TR>
<TR>
<TD>&nbsp;</TD>
<TD CLASS=R13C1 COLSPAN=6>Покупатель:</TD>
<TD CLASS=R13C7 COLSPAN=31>[+shop.company+], ИНН [+shop.inn+], КПП [+shop.kpp+], [+shop.adress+], тел.: [+shop.phone+]</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>

</TR>
<TR>
<TD>&nbsp;</TD>
<TD CLASS=R13C1>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD CLASS=R13C7>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>

<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>

<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
</TR>
<TR>
<TD>&nbsp;</TD>
<TD CLASS=R13C1 COLSPAN=6>Грузополучатель:</TD>
<TD CLASS=R13C7 COLSPAN=31>[+shop.company+], ИНН [+shop.inn+], КПП [+shop.kpp+], [+shop.adress+], тел.: [+shop.phone+]</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>

</TR>
<TR>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>

<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>

<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
</TR>
</TABLE>
<TABLE CELLSPACING=0>
<COL WIDTH="7">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">

<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">

<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<TR>
<TD>&nbsp;</TD>

<TD CLASS=R21C1 COLSPAN=2>№</TD>
<TD CLASS=R21C3 COLSPAN=4>Артикул</TD>
<TD CLASS=R21C3 COLSPAN=17>Товары&nbsp;(работы,&nbsp;услуги)</TD>
<TD CLASS=R21C3 COLSPAN=3>Кол-во</TD>
<TD CLASS=R21C3 COLSPAN=2>Ед.</TD>
<TD CLASS=R21C3 COLSPAN=4>Цена</TD>
<TD CLASS=R21C33 COLSPAN=5>Сумма</TD>
<TD>&nbsp;</TD>

</TR>
<!--table-->
<TR>
<TD>&nbsp;</TD>
<TD CLASS=R22C1 COLSPAN=2>[+shop.num+]</TD>
<TD CLASS=R22C3 COLSPAN=4>[+shop.id+]</TD>
<TD CLASS=R22C3 COLSPAN=17>[+shop.name+]</TD>
<TD CLASS=R22C24 COLSPAN=3>[+shop.quantity+]</TD>
<TD CLASS=R22C3 COLSPAN=2>шт</TD>
<TD CLASS=R22C24 COLSPAN=4>[+shop.cena+]</TD>
<TD CLASS=R22C33 COLSPAN=5>[+shop.price+]</TD>
<TD>&nbsp;</TD>
</TR>

<!--/table-->
<TR CLASS=R23>
<TD>&nbsp;</TD>
<TD CLASS=R23C1>&nbsp;</TD>
<TD CLASS=R23C1>&nbsp;</TD>
<TD CLASS=R23C1>&nbsp;</TD>
<TD CLASS=R23C1>&nbsp;</TD>
<TD CLASS=R23C1>&nbsp;</TD>
<TD CLASS=R23C1>&nbsp;</TD>
<TD CLASS=R23C1>&nbsp;</TD>
<TD CLASS=R23C1>&nbsp;</TD>
<TD CLASS=R23C1>&nbsp;</TD>
<TD CLASS=R23C1>&nbsp;</TD>
<TD CLASS=R23C1>&nbsp;</TD>
<TD CLASS=R23C1>&nbsp;</TD>
<TD CLASS=R23C1>&nbsp;</TD>
<TD CLASS=R23C1>&nbsp;</TD>

<TD CLASS=R23C1>&nbsp;</TD>
<TD CLASS=R23C1>&nbsp;</TD>
<TD CLASS=R23C1>&nbsp;</TD>
<TD CLASS=R23C1>&nbsp;</TD>
<TD CLASS=R23C1>&nbsp;</TD>
<TD CLASS=R23C1>&nbsp;</TD>
<TD CLASS=R23C1>&nbsp;</TD>
<TD CLASS=R23C1>&nbsp;</TD>
<TD CLASS=R23C1>&nbsp;</TD>
<TD CLASS=R23C1>&nbsp;</TD>
<TD CLASS=R23C1>&nbsp;</TD>
<TD CLASS=R23C1>&nbsp;</TD>
<TD CLASS=R23C1>&nbsp;</TD>
<TD CLASS=R23C1>&nbsp;</TD>
<TD CLASS=R23C29>&nbsp;</TD>
<TD CLASS=R23C30>&nbsp;</TD>
<TD CLASS=R23C30>&nbsp;</TD>

<TD CLASS=R23C30>&nbsp;</TD>
<TD CLASS=R23C29>&nbsp;</TD>
<TD CLASS=R23C30>&nbsp;</TD>
<TD CLASS=R23C30>&nbsp;</TD>
<TD CLASS=R23C30>&nbsp;</TD>
<TD CLASS=R23C30>&nbsp;</TD>
<TD>&nbsp;</TD>
</TR>
<TR>
<TD CLASS=R24C29 COLSPAN=33>Итого:</TD>
<TD CLASS=R24C29 COLSPAN=5>[+shop.total+]</TD>
<TD>&nbsp;</TD>
</TR>
</TABLE>
<TABLE CELLSPACING=0>

<COL WIDTH="7">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">

<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">

<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="21">
<COL WIDTH="7">
<TR>
<TD>&nbsp;</TD>
<TD CLASS=R25C1 COLSPAN=37>Всего&nbsp;наименований&nbsp;[+shop.count+],&nbsp;на&nbsp;сумму&nbsp;[+shop.total+]&nbsp;руб.</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>

</TR>
<TR>
<TD>&nbsp;</TD>
<TD CLASS=R26C1 COLSPAN=37>[+shop.total_propis+]</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
</TR>
<TR CLASS=R23>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>

<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>

<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>

<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
</TR>
<TR CLASS=R23>
<TD>&nbsp;</TD>
<TD CLASS=R23C30>&nbsp;</TD>
<TD CLASS=R23C30>&nbsp;</TD>
<TD CLASS=R23C30>&nbsp;</TD>
<TD CLASS=R23C30>&nbsp;</TD>
<TD CLASS=R23C30>&nbsp;</TD>
<TD CLASS=R23C30>&nbsp;</TD>
<TD CLASS=R23C30>&nbsp;</TD>
<TD CLASS=R23C30>&nbsp;</TD>
<TD CLASS=R23C30>&nbsp;</TD>
<TD CLASS=R23C30>&nbsp;</TD>

<TD CLASS=R23C30>&nbsp;</TD>
<TD CLASS=R23C30>&nbsp;</TD>
<TD CLASS=R23C30>&nbsp;</TD>
<TD CLASS=R23C30>&nbsp;</TD>
<TD CLASS=R23C30>&nbsp;</TD>
<TD CLASS=R23C30>&nbsp;</TD>
<TD CLASS=R23C30>&nbsp;</TD>
<TD CLASS=R23C30>&nbsp;</TD>
<TD CLASS=R23C30>&nbsp;</TD>
<TD CLASS=R23C30>&nbsp;</TD>
<TD CLASS=R23C30>&nbsp;</TD>
<TD CLASS=R23C30>&nbsp;</TD>
<TD CLASS=R23C30>&nbsp;</TD>
<TD CLASS=R23C30>&nbsp;</TD>
<TD CLASS=R23C30>&nbsp;</TD>
<TD CLASS=R23C30>&nbsp;</TD>
<TD CLASS=R23C30>&nbsp;</TD>

<TD CLASS=R23C30>&nbsp;</TD>
<TD CLASS=R23C30>&nbsp;</TD>
<TD CLASS=R23C30>&nbsp;</TD>
<TD CLASS=R23C30>&nbsp;</TD>
<TD CLASS=R23C30>&nbsp;</TD>
<TD CLASS=R23C30>&nbsp;</TD>
<TD CLASS=R23C30>&nbsp;</TD>
<TD CLASS=R23C30>&nbsp;</TD>
<TD CLASS=R23C30>&nbsp;</TD>
<TD CLASS=R23C30>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
</TR>
<TR>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>

<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>

<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>

<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
</TR>
<TR>
<TD>&nbsp;</TD>
<TD CLASS=R30C1 COLSPAN=5>Руководитель</TD>
<TD>&nbsp;</TD>
<TD CLASS=R30C7 COLSPAN=9>Генеральный&nbsp;директор</TD>
<TD>&nbsp;</TD>
<TD CLASS=R30C17>&nbsp;</TD>
<TD CLASS=R30C17>&nbsp;</TD>
<TD CLASS=R30C17>&nbsp;</TD>
<TD CLASS=R30C17>&nbsp;</TD>

<TD CLASS=R30C17>&nbsp;</TD>
<TD CLASS=R30C17>&nbsp;</TD>
<TD CLASS=R30C17>&nbsp;</TD>
<TD CLASS=R30C17>&nbsp;</TD>
<TD CLASS=R30C17>&nbsp;</TD>
<TD CLASS=R30C26>&nbsp;</TD>
<TD CLASS=R30C27>&nbsp;</TD>
<TD CLASS=R30C7 COLSPAN=10>Салихов&nbsp;Р.&nbsp;Р.</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
</TR>
<TR>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>

<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD CLASS=R31C7 COLSPAN=9>должность</TD>
<TD>&nbsp;</TD>
<TD CLASS=R31C7 COLSPAN=10>подпись</TD>
<TD CLASS=R31C7>&nbsp;</TD>
<TD CLASS=R31C7 COLSPAN=10>расшифровка&nbsp;подписи</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
</TR>

<TR>
<TD>&nbsp;</TD>
<TD CLASS=R30C1>&nbsp;</TD>
<TD CLASS=R30C1>&nbsp;</TD>
<TD CLASS=R30C1>&nbsp;</TD>
<TD CLASS=R30C1>&nbsp;</TD>
<TD CLASS=R30C1>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD CLASS=R32C8>&nbsp;</TD>
<TD CLASS=R32C8>&nbsp;</TD>
<TD CLASS=R32C8>&nbsp;</TD>
<TD CLASS=R32C8>&nbsp;</TD>
<TD CLASS=R32C8>&nbsp;</TD>
<TD CLASS=R32C8>&nbsp;</TD>
<TD CLASS=R32C8>&nbsp;</TD>
<TD CLASS=R32C8>&nbsp;</TD>

<TD CLASS=R32C16>&nbsp;</TD>
<TD CLASS=R32C16>&nbsp;</TD>
<TD CLASS=R32C16>&nbsp;</TD>
<TD CLASS=R32C16>&nbsp;</TD>
<TD CLASS=R32C16>&nbsp;</TD>
<TD CLASS=R32C16>&nbsp;</TD>
<TD CLASS=R32C16>&nbsp;</TD>
<TD CLASS=R32C16>&nbsp;</TD>
<TD CLASS=R32C16>&nbsp;</TD>
<TD CLASS=R32C8>&nbsp;</TD>
<TD CLASS=R32C8>&nbsp;</TD>
<TD CLASS=R32C16>&nbsp;</TD>
<TD CLASS=R32C28>&nbsp;</TD>
<TD CLASS=R32C8>&nbsp;</TD>
<TD CLASS=R32C8>&nbsp;</TD>
<TD CLASS=R32C8>&nbsp;</TD>
<TD CLASS=R32C8>&nbsp;</TD>

<TD CLASS=R32C8>&nbsp;</TD>
<TD CLASS=R32C8>&nbsp;</TD>
<TD CLASS=R32C8>&nbsp;</TD>
<TD CLASS=R32C8>&nbsp;</TD>
<TD CLASS=R32C8>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
</TR>
<TR>
<TD>&nbsp;</TD>
<TD CLASS=R30C1 COLSPAN=7>Главный&nbsp;(старший)&nbsp;бухгалтер</TD>
<TD CLASS=R32C8>&nbsp;</TD>
<TD CLASS=R32C8>&nbsp;</TD>
<TD CLASS=R32C8>&nbsp;</TD>

<TD CLASS=R32C8>&nbsp;</TD>
<TD CLASS=R32C8>&nbsp;</TD>
<TD CLASS=R32C8>&nbsp;</TD>
<TD CLASS=R32C8>&nbsp;</TD>
<TD CLASS=R32C8>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD CLASS=R30C17>&nbsp;</TD>
<TD CLASS=R30C17>&nbsp;</TD>
<TD CLASS=R30C17>&nbsp;</TD>
<TD CLASS=R30C17>&nbsp;</TD>
<TD CLASS=R30C17>&nbsp;</TD>
<TD CLASS=R30C17>&nbsp;</TD>
<TD CLASS=R30C17>&nbsp;</TD>
<TD CLASS=R30C17>&nbsp;</TD>
<TD CLASS=R30C17>&nbsp;</TD>
<TD CLASS=R30C26>&nbsp;</TD>
<TD CLASS=R30C27>&nbsp;</TD>

<TD CLASS=R30C7 COLSPAN=10>Салихов&nbsp;Р.&nbsp;Р.</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
</TR>
<TR>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>

<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD CLASS=R31C7 COLSPAN=10>подпись</TD>
<TD CLASS=R31C7>&nbsp;</TD>
<TD CLASS=R31C7 COLSPAN=10>расшифровка&nbsp;подписи</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
</TR>

<TR>
<TD>&nbsp;</TD>
<TD COLSPAN=5>&nbsp;</TD>
<TD CLASS=R35C6>&nbsp;</TD>
<TD CLASS=R35C6>&nbsp;</TD>
<TD CLASS=R35C6>&nbsp;</TD>
<TD CLASS=R35C6>&nbsp;</TD>
<TD CLASS=R35C10>&nbsp;</TD>
<TD CLASS=R35C10>&nbsp;</TD>
<TD CLASS=R35C10>&nbsp;</TD>
<TD CLASS=R35C10>&nbsp;</TD>
<TD CLASS=R35C10>&nbsp;</TD>
<TD CLASS=R30C27>&nbsp;</TD>
<TD CLASS=R30C27>&nbsp;</TD>
<TD CLASS=R30C27>&nbsp;</TD>
<TD CLASS=R30C27>&nbsp;</TD>
<TD CLASS=R30C27>&nbsp;</TD>

<TD CLASS=R30C27>&nbsp;</TD>
<TD CLASS=R30C27>&nbsp;</TD>
<TD CLASS=R30C27>&nbsp;</TD>
<TD CLASS=R30C27>&nbsp;</TD>
<TD CLASS=R30C27>&nbsp;</TD>
<TD CLASS=R30C27>&nbsp;</TD>
<TD CLASS=R30C27>&nbsp;</TD>
<TD CLASS=R30C27>&nbsp;</TD>
<TD CLASS=R30C27>&nbsp;</TD>
<TD CLASS=R30C27>&nbsp;</TD>
<TD CLASS=R30C27>&nbsp;</TD>
<TD CLASS=R30C27>&nbsp;</TD>
<TD CLASS=R30C27>&nbsp;</TD>
<TD CLASS=R30C27>&nbsp;</TD>
<TD CLASS=R30C27>&nbsp;</TD>
<TD CLASS=R30C27>&nbsp;</TD>
<TD CLASS=R30C27>&nbsp;</TD>

<TD CLASS=R30C27>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
</TR>
<TR>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>

<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>

<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
</TR>
<TR>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>

<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>

<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
<TD>&nbsp;</TD>

<TD>&nbsp;</TD>
<TD>&nbsp;</TD>
</TR>
</TABLE>


