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
 * @author    Telnij Sergey (Serg24) <tsv.art.com@gmail.com>, http://tsvshop.xyz 
 */


<!-- #declare:separator <hr> --> 
<!-- login form section-->
<fieldset>
<form method="post" name="loginfrm" action="[+action+]" class="form-horizontal"> 
	<h4>Вход для клиентов</h4> <p><small>Важно: маленькие и большие буквы различаются</small></p>
	<input type="hidden" value="[+rememberme+]" name="rememberme" /> 
  <div class="form-group">
    <label for="username" class="col-sm-2 control-label">Логин:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="username" placeholder="login" name="username" tabindex="2"  value="[+username+]">
    </div>
  </div>
  <div class="form-group">
    <label for="password" class="col-sm-2 control-label">Пароль:</label>
    <div class="col-sm-10">
      <input type="password" class="form-control" id="password" placeholder="Пароль" tabindex="3" value="" >
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <div class="checkbox">
        <label for="chkbox">
          <input type="checkbox" id="chkbox" name="chkbox" tabindex="4" size="1" value="" [+checkbox+] onClick="webLoginCheckRemember()"> Запомнить меня
        </label>
      </div>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default" name="cmdweblogin">Войти</button>
		<a href="#" onclick="webLoginShowForm(2);return false;"><small>Забыли пароль?</small></a> 
    </div>
  </div>
</form>	
</fieldset>
<hr>
<!-- log out hyperlink section -->
<a href='[+action+]'>[+logouttext+]</a><br />
<a href='[~15~]'>Редактирование профиля</a>
<hr>
<!-- Password reminder form section -->
<fieldset>
<form class="form-horizontal" name="loginreminder" method="post" action="[+action+]">
	<h4>Напоминание забытого пароля</h4>
	<input type="hidden" name="txtpwdrem" value="0" />
  <div class="form-group">
    <label for="txtwebemail" class="col-sm-2 control-label">Ваш email:</label>
    <div class="col-sm-10">
      <input type="email" class="form-control" id="txtwebemail" placeholder="email@email.com">
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default" name="cmdweblogin">Напомнить</button>
	  <button type="reset" class="btn btn-default" name="cmdweblogin" name="cmdcancel" onclick="webLoginShowForm(1);">Отмена</button>
    </div>
  </div>
</form>	
</fieldset>