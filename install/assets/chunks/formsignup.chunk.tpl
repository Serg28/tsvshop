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
 * @author      Telnij Sergey (Serg24) <tsv.art.com@gmail.com>, http://tsvshop.xyz 
 */

<!-- #declare:separator <hr> --> 
<!-- login form section-->
<p>Если вы еще не зарегистрированы, то можете сделать это, заполнив нижеприведенную форму.</p>

<form method="post" name="websignupfrm" action="[+action+]" class="form-horizontal">
<fieldset>
	<h4>Регистрация пользователя</h4> <p><small>Ячейки помеченые <span class="orange">*</span> обязательны для заполнения</small></p>
	
	
<div class="form-group">
    <label for="fusername" class="col-sm-2 control-label">Логин <span class="orange">*</span></label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="fusername" name="username" placeholder="login" value="[+username+]">
    </div>
  </div>	
	
  <div class="form-group">
    <label for="ffullname" class="col-sm-2 control-label">Ф.И.О</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="ffullname" name="fullname" placeholder="Иванов Иван Иванович" value="[+fullname+]">
    </div>
  </div>
	
  <div class="form-group">
    <label for="fphone" class="col-sm-2 control-label">Телефон</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="fphone" name="phone" placeholder="" value="[+phone+]">
    </div>
  </div>
	
  <div class="form-group">
    <label for="fpassword" class="col-sm-2 control-label">Пароль <span class="orange">*</span></label>
    <div class="col-sm-10">
      <input type="password" class="form-control" id="fpassword" name="password" placeholder="Password">
    </div>
  </div>	
	
  <div class="form-group">
    <label for="fconfirmpassword" class="col-sm-2 control-label">Пароль <span class="orange">*</span></label>
    <div class="col-sm-10">
      <input type="password" class="form-control" id="fconfirmpassword" name="confirmpassword" placeholder="Password">
    </div>
  </div>	
	
  <div class="form-group">
    <label for="femail" class="col-sm-2 control-label">Email <span class="orange">*</span></label>
    <div class="col-sm-10">
      <input type="email" class="form-control" id="femail" name="email" placeholder="email@email.com" value="[+email+]">
    </div>
  </div>
	
  <div class="form-group">
    <label for="femail" class="col-sm-2 control-label">Код проверки </label>
    <div class="col-sm-10">
      <a href="[+action+]"><img align="top" src="[+manager_folder+]/includes/veriword.php" width="148" height="60" alt="Если еcть проблемы с отображением кода, кликните по нему для генерации нового кода." style="border: 1px solid #039" /></a>
    </div>
  </div>
	
  <div class="form-group">
    <label for="fformcode" class="col-sm-2 control-label">Введите код <span class="orange">*</span></label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="fformcode" name="formcode" placeholder="" value="">
    </div>
  </div>
	

  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <div class="checkbox">
        <label>
          <input type="checkbox"> Запомнить меня
        </label>
      </div>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default" name="cmdwebsignup">Регистрация</button>
    </div>
  </div>
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
<div class="success  alert alert-success">Заполнение завершено! Ваш аккаунт создан. К вам на почту отправлено письмо с регистрационными данными. Теперь вы можете войти, воспользовавшись вышеприведенной формой.</p>
</div>
