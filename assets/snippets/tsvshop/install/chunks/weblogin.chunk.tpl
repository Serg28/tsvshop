/**
 * weblogin
 *
 * Шаблон формы авторизации в личном кабинете магазина TSVshop
 *
 * @category	chunk
 * @version 	1.1
 * @license 	http://www.gnu.org/copyleft/gpl.html GNU Public License (GPL)
 * @internal  @modx_category TSVoffice
 * @internal  @installset base, sample
 * @author    Telnij Sergey (Serg24) <privat_tel@mail.ru>, http://tsvshop.tsv.org.ua, http://tsvshop.xyz 
 */


<!-- #declare:separator <hr> --> 
<!-- login form section-->
<fieldset>
<form method="post" name="loginfrm" action="[+action+]" style="margin: 0px; padding: 0px;"> 
<h4>Вход для клиентов</h4> <p><small>Важно: маленькие и большие буквы различаются</small></p>
<input type="hidden" value="[+rememberme+]" name="rememberme" /> 
<table>
<tr>
<td width="115">Логин: </td><td><input type="text" name="username" tabindex="2" onkeypress="return webLoginEnter(document.loginfrm.password);" class="text" value="[+username+]" onfocus="this.value=(this.value=='Логин')? '' : this.value ;"  /> </td>
</tr>
<tr>
<td>Пароль: </td><td><input type="password" name="password" tabindex="3" onkeypress="return webLoginEnter(document.loginfrm.cmdweblogin);" class="text" value="Пароль" onfocus="this.value=(this.value=='Пароль')? '' : this.value ;" /></td>
</tr>
<tr>
<td colspan="2" style="text-align:right">
 <label for="chkbox" style="cursor:pointer">Запомнить меня:&nbsp; </label> <input type="checkbox" id="chkbox" name="chkbox" tabindex="4" size="1" value="" [+checkbox+] onClick="webLoginCheckRemember()" />&nbsp;&nbsp;<input type="submit" class="submit" name="cmdweblogin" value="Войти" />

</td>
</tr>

<tr>
<td colspan="2">
<a href="#" onclick="webLoginShowForm(2);return false;"><small>Забыли пароль?</small></a> 
</td>
</tr>
</table>
		</form>
</fieldset>
<hr>
<!-- log out hyperlink section -->
<a href='[+action+]'>[+logouttext+]</a><br />
<a href='[~19~]'>Редактирование профиля</a>
<hr>
<!-- Password reminder form section -->
<fieldset>
<b>Напоминание забытого пароля</b><br />
<form name="loginreminder" method="post" action="[+action+]">
<input type="hidden" name="txtpwdrem" value="0" />
<p>Введите Ваш email адрес для восстановления пароля:</p>
<input type="text" class="text" name="txtwebemail" /><br />
<input type="submit" class="submit" value="Напомнить" name="cmdweblogin" /> 
<input type="reset" class="submit" value="Отмена" name="cmdcancel" onclick="webLoginShowForm(1);" />
</form>
</fieldset>