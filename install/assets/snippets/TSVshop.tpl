/**
 * TSVshop
 *
 * Сниппет магазина TSVshop
 *
 * @category    snippet
 * @version     5.4.5
 * @license     http://www.gnu.org/copyleft/gpl.html GNU Public License (GPL)
 * @internal    @properties
 * @internal    @modx_category TSVshop
 * @internal    @installset base, sample
 *
 * @author      Telnij Sergey (Serg24) <tsv.art.com@gmail.com>, Сайт проекта, дополнения, доработка под нужды: http://tsvshop.xyz
 * -----------------------------------------------------------------------------
 */

define("TSVSHOP_PATH", MODX_BASE_PATH."assets/snippets/tsvshop/");
define("TSVSHOP_URL", MODX_BASE_URL."assets/snippets/tsvshop/");
define("TSVSHOP_SURL", MODX_SITE_URL."assets/snippets/tsvshop/");
define("TSVSHOP_PUREPATH", "assets/snippets/tsvshop/");
define('IN_TSVSHOP_MODE','true');

global $cache, $session, $tsvshop, $shop_lang, $tables, $folders, $jsfiles;
$jsfiles = array();

include TSVSHOP_PATH."include/config.inc.php";
include_once (TSVSHOP_PATH. 'admin/includes/core.inc.php');
include_once (TSVSHOP_PATH. 'include/cart.inc.php'); 
include TSVSHOP_PATH."include/tsvshop.inc.php";
session_write_close();
session_set_cookie_params("",'/');
session_name($session);
session_start();
tsv_minregjs();
