
http://modx-shopkeeper.ru

---------------------------------------------

�������������� ������ ��������� UTF-8. 

---------------------------------------------

��� ���������/����������:

1. ������� ������� (�������� ����).

2. �������� �������� ��� WebLogin � WebSignup:
   &alerttpl - ��� ����� ��� ������ ��������� �� ������� ��������� ����� � �.�.
   � ��� ����� �������� ����������� [+msq+] ��� ������ ������ ���������.

3. ������ ������������ � �������������� ����� PHPMailer. ������������� �������� ����� �� ��c������ ������. ��� ����� �������� (http://sourceforge.net/projects/phpmailer/files/phpmailer%20for%20php5_6/) � ������� ���� manager/includes/controls/class.phpmailer.php.

4. � WebSignup ��������� ������� OnWUsrFormRender ��� ��������� ������� addWebUserFields.

5. �����, ������������, focus() �� ���� ������ �����������.

---------------------------------------------


������ ������ WebLogin:

[!WebLogin? &tpl=`weblogin`&alerttpl=`weblogin_alerttpl`&loginhomeid=`1`&logouthomeid=`1`!]



������ ������ WebSignup:

[!WebSignup? &tpl=`FormSignup`&alerttpl=`websignup_alerttpl`&groups=`Customers`&useCaptcha=`1`!]



