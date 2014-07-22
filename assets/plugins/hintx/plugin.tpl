/**
 * HINTx
 * 
 * add hints to chunks & templates editors (������ ��� ������ ��������� ��� �������������� ������ � ��������)
 *
 * @author	 	lecosson@gmail.com
 * @category 	plugin
 * @version 	0.01
 * @license 	http://www.opensource.org/licenses/gpl-2.0.php GNU Public License Version 2 (GPL2)
 * @internal	@events OnChunkFormRender, OnTempFormRender
 * @internal	@modx_category Manager and Admin
 * @config		&lang=hints language;string;ru
 */ 

global $modx;
if(!isset($hintx_path)) require_once MODX_BASE_PATH.'assets/plugins/hintx/hintx.php';


