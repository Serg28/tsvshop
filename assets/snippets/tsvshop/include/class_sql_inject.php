<?PHP
/****************************************************************
*****************************************************************

this class try to detect KNOWN form of SQL inject

Copyright (C) 2003  Matthieu MARY marym@ifrance.com.invalid
(remove the .invalid to write me)

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.

You can found more information about GPL licence at:
http://www.gnu.org/licenses/gpl.html

for contact me: marym@ifrance.com.invalid (remove the .invalid to write me)
****************************************************************
****************************************************************/

class sql_inject
{
    /**
	 * @shortdesc url to redirect if an sql inject attempt is detect. if unset, value is FALSE
	 * @private
	 * @type mixed
	 */
    var $urlRedirect;
    /**
	 * @shortdesc does the session must be destroy if an attempt is detect
	 * @private
	 * @type bool
	 */
    var $bdestroy_session;
    /**
	 * @shortdesc the SQL data currently test
	 * @private
	 * @type string
	 */
    var $rq;
    /**
	 * @shortdesc if not FALSE, the url to the log file
	 * @private
	 * @type mixed
	 */
    var $bLog;
    
    /**
	 * Builder
	 *
	 * @param bool bdestroy_session optional. does the session must be destroy if an attempt is detect?
	 * @param string urlRedirect optional. url to redirect if an sql inject attempt is detect
     * @public
	 * @type void
     */
    function sql_inject($mLog=FALSE,$bdestroy_session=FALSE,$urlRedirect=FALSE)
    {
        $this->bLog = (($mLog!=FALSE)?$mLog:'');
        $this->urlRedirect = (((trim($urlRedirect)!='') && file_exists($urlRedirect))?$urlRedirect:'');
        $this->bdestroy_session = $bdestroy_session;
        $this->rq = '';
    }

    /**
	 * @shortdesc test if there is a sql inject attempt detect
	 * test if there is a sql inject attempt detect
	 *
	 * @param string sRQ required. SQL Data to test
     * @public
	 * @type bool
     */
    function test($sRQ)
    {
        $sRQ = strtolower($sRQ);
        $this->rq = $sRQ;
        $aValues = array();
        $aTemp = array(); // temp array
        $aWords = array(); //
        $aSep = array(' and ',' or '); // separators for detect the
        $sConditions = '(';
        $matches = array();
        $sSep = '';
        // is there an attempt to unused part of the rq?
        if (is_int((strpos($sRQ,"#")))&&$this->_in_post('#')) return $this->detect();
        
        // is there a attempt to do a 2nd SQL requete ?
        if (is_int(strpos($sRQ,';'))){
            $aTemp = explode(';',$sRQ);
            if ($this->_in_post($aTemp[1])) return $this->detect();
        }
        
        $aTemp = explode(" where ",$sRQ);
        if (count($aTemp)==1) return FALSE;
        $sConditions = $aTemp[1];
        $aWords = explode(" ",$sConditions);
        if(strcasecmp($aWords[0],'select')!=0) $aSep[] = ',';
        $sSep = '('.implode('|',$aSep).')';
        $aValues = preg_split($sSep,$sConditions,-1, PREG_SPLIT_NO_EMPTY);

        // test the always true expressions
        foreach($aValues as $i => $v)
        {
            // SQL injection like 1=1 or a=a or 'za'='za'
            if (is_int(strpos($v,'=')))
            {
                 $aTemp = explode('=',$v);
                 if (trim($aTemp[0])==trim($aTemp[1])) return $this->detect();
            }
            
            //SQL injection like 1<>2
            if (is_int(strpos($v,'<>')))
            {
                $aTemp = explode('<>',$v);
                if ((trim($aTemp[0])!=trim($aTemp[1]))&& ($this->_in_post('<>'))) return $this->detect();
            }
        }
        
        if (strpos($sConditions,' null'))
        {
            if (preg_match("/null +is +null/",$sConditions)) return $this->detect();
            if (preg_match("/is +not +null/",$sConditions,$matches))
            {
                foreach($matches as $i => $v)
                {
                    if ($this->_in_post($v))return $this->detect();
                }
            }
        }
        
        if (preg_match("/[a-z0-9]+ +between +[a-z0-9]+ +and +[a-z0-9]+/",$sConditions,$matches))
        {
            $Temp = explode(' between ',$matches[0]);
            $Evaluate = $Temp[0];
            $Temp = explode(' and ',$Temp[1]);
            if ((strcasecmp($Evaluate,$Temp[0])>0) && (strcasecmp($Evaluate,$Temp[1])<0) && $this->_in_post($matches[0])) return $this->detect();
        }
        return FALSE;
    }

    function _in_post($value)
    {
        foreach($_POST as $i => $v)
        {
             if (is_int(strpos(strtolower($v),$value))) return TRUE;
        }
        return FALSE;
    }

    function detect()
    {
        // log the attempt to sql inject?
        if ($this->bLog)
        {
            $fp = @fopen($this->bLog,'a+');
            if ($fp)
            {
                fputs($fp,"\r\n".date("d-m-Y H:i:s").' ['.$this->rq.'] from '.$this->sIp = getenv("REMOTE_ADDR"));
                fclose($fp);
            }
        }
        // destroy session?
        if ($this->bdestroy_session) session_destroy();
        // redirect?
        if ($this->urlRedirect!=''){
             if (!headers_sent())  header("location: $this->urlRedirect");
        }
        return TRUE;
    }
}
?>
