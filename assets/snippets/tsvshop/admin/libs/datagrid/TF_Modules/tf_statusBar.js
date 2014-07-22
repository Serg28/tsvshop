/*------------------------------------------------------------------------
	- HTML Table Filter Generator 
	- Status bar feature v1.1
	- By Max Guglielmi (tablefilter.free.fr)
	- Licensed under the MIT License
-------------------------------------------------------------------------*/

TF.prototype.SetStatusBar = function()
/*====================================================
	- Generates status bar label
=====================================================*/
{
	if(!this.hasGrid && !this.isFirstLoad) return;
	var f = this.fObj;
	this.statusBarTgtId =		f.status_bar_target_id!=undefined //id of custom container element
									? f.status_bar_target_id : null;
	this.statusBarDiv =			null; //element containing status bar label
	this.statusBarSpan =		null; //status bar
	this.statusBarSpanText =	null; //status bar label
	this.statusBarText =		f.status_bar_text!=undefined
									? f.status_bar_text : ''; //defines status bar text
	this.statusBarCssClass =	f.status_bar_css_class!=undefined //defines css class status bar
									? f.status_bar_css_class : 'status';
	this.statusBarCloseDelay =	250; //delay for status bar clearing
	var statusDiv = tf_CreateElm( 'div',['id',this.prfxStatus+this.id] ); //status bar container
	statusDiv.className = this.statusBarCssClass;
	var statusSpan = tf_CreateElm( 'span',['id',this.prfxStatusSpan+this.id] ); //status bar label
	var statusSpanText = tf_CreateElm( 'span',['id',this.prfxStatusTxt+this.id] );//preceding text
	statusSpanText.appendChild( tf_CreateText(this.statusBarText) );

	// target element container
	if(this.statusBarTgtId==null) this.SetTopDiv();
	var targetEl = ( this.statusBarTgtId==null ) ? this.lDiv : tf_Id( this.statusBarTgtId );
	
	if(this.statusBarDiv && tf_isIE)
		this.statusBarDiv.outerHTML = '';
	
	if( this.statusBarTgtId==null )
	{//default container: 'lDiv'
		statusDiv.appendChild(statusSpanText);
		statusDiv.appendChild(statusSpan);
		targetEl.appendChild(statusDiv);		
	}
	else
	{// custom container, no need to append statusDiv
		targetEl.appendChild(statusSpanText);
		targetEl.appendChild(statusSpan);
	}

	this.statusBarDiv = tf_Id( this.prfxStatus+this.id );
	this.statusBarSpan = tf_Id( this.prfxStatusSpan+this.id );
	this.statusBarSpanText = tf_Id( this.prfxStatusTxt+this.id );
}

TF.prototype.RemoveStatusBar = function()
/*====================================================
	- Removes status bar div
=====================================================*/
{
	if(!this.hasGrid) return;
	if(this.statusBarDiv)
	{
		this.statusBarDiv.innerHTML = '';
		this.statusBarDiv.parentNode.removeChild( 
			this.statusBarDiv
		);
		this.statusBarSpan = null;
		this.statusBarSpanText = null;
		this.statusBarDiv = null;
	}
}

TF.prototype.StatusMsg = function(t)
/*====================================================
	- sets status messages
=====================================================*/
{
	if(t==undefined) this.StatusMsg('');
	if(this.status) this.WinStatusMsg(t);
	if(this.statusBar) this.StatusBarMsg(t);
}

TF.prototype.WinStatusMsg = function(t)
/*====================================================
	- sets window status messages
=====================================================*/
{
	if(!this.status) return;
	window.status = t;
}

TF.prototype.StatusBarMsg = function(t)
/*====================================================
	- sets status bar messages
=====================================================*/
{
	if(!this.statusBar || !this.statusBarSpan) return;
	var o = this;
	function setMsg(){
		o.statusBarSpan.innerHTML = t;
	}
	var d = (t=='') ? (this.statusBarCloseDelay) : 1;
	window.setTimeout(setMsg,d);
}