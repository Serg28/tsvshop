/**
 * formsignup
 *
 * Шаблон формы регистрации в личном кабинете магазина TSVshop
 *
 * @category	chunk
 * @version 	1.1
 * @license 	http://www.gnu.org/copyleft/gpl.html GNU Public License (GPL)
 * @internal  @modx_category TSVoffice
 * @internal  @installset base, sample
 * @author      Telnij Sergey (Serg24) <privat_tel@mail.ru>, http://tsvshop.tsv.org.ua, http://tsvshop.xyz 
 */

<!-- #declare:separator <hr> --> 
<!-- login form section-->
<p>Если вы еще не зарегистрированы, то можете сделать это, заполнив нижеприведенную форму.</p>
<form method="post" name="websignupfrm" action="[+action+]">
<fieldset>
<h4>Регистрация пользователя</h4> <p><small>Ячейки помеченые <span class="orange">*</span> обязательны для заполнения</small></p>
<table>
<tr>
<td width="110">Логин</td>
<td width="5"><span class="orange">*</span></td>
<td><input type="text" class="text" name="username" id="username" size="20" maxlength="30" value="[+username+]" /></td>
</tr>
<tr>
<td>Ф.И.О</td>
<td><span class="orange"></span></td>
<td><input type="text" class="text" name="fullname" id="fullname" size="20" maxlength="100" value="[+fullname+]" /></td>
</tr>

<tr>
<td>Телефон</td>
<td><span class="orange"></span></td>
<td><input type="text" class="text" name="phone" id="phone" size="20" maxlength="100" value="[+phone+]" /></td>
</tr>
<tr>
<td>Пароль</td>
<td><span class="orange">*</span></td>
<td><input type="password" name="password" class="text" id="password" size="20" /></td>
</tr>
<tr>
<td>Пароль</td>
<td><span class="orange">*</span></td>
<td><input type="password" class="text" name="confirmpassword" id="confirmpassword" size="20" /></td>
</tr>

<tr>
<td>E-mail</td>
<td width="5"><span class="orange">*</span></td>
<td><input type="text" name="email" class="text" id="email" size="20" value="[+email+]" /></td>
</tr>

<tr>
<td>Код проверки</td>
<td><span class="orange">*</span></td>
<td><a href="[+action+]"><img align="top" src="[+manager_folder+]/includes/veriword.php" style="border: 1px solid rgb(187, 187, 187); width="148" height="60" alt="Если емть проблемы с отображением кода, кликните по нему для генерации нового кода." style="border: 1px solid #039" /></a></td>
</tr>

<tr>
<td>Введите код</td>
<td><span class="orange">*</span></td>
<td><input class="text" type="text" name="formcode" class="text" size="20" /></td>
</tr>

<tr>
<td> </td>
<td></td>
<td align="right"><input type="submit" class="button" value="Регистрация" name="cmdwebsignup" /></td>
</tr>
</table>
</fieldset>
</form>

<script language="javascript" type="text/javascript"> 
	var id = "[+country+]";
	var f = document.websignupfrm;
	var i = parseInt(id);	
	if (!isNaN(i)) f.country.options[i].selected = true;
</script>
<hr>
<!-- notification section -->
<div class="success">Заполнение завершено! Ваш аккаунт создан. К вам на почту отправлено письмо с регистрационными данными. Теперь вы можете войти, воспользовавшись вышеприведенной формой.</p>
</div>
