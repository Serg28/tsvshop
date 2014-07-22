/*------------------------------------------------------------------------
	- HTML Table Filter Generator 
	- Rows counter feature v1.1
	- By Max Guglielmi (tablefilter.free.fr)
	- Licensed under the MIT License
-------------------------------------------------------------------------*/

TF.prototype.SetRowsCounter = function()
/*====================================================
	- Generates rows counter label
=====================================================*/
{
	if(!this.hasGrid && !this.isFirstLoad) return;
	if( this.rowsCounterSpan!=null ) return;
	var f = this.fObj;
	this.rowsCounterTgtId =		f.rows_counter_target_id!=undefined //id of custom container element
								? f.rows_counter_target_id : null;
	this.rowsCounterDiv =		null; //element containing tot nb rows
	this.rowsCounterSpan =		null; //element containing tot nb rows label
	this.rowsCounterText =		f.rows_counter_text!=undefined
									? f.rows_counter_text : 'Rows: '; //defines rows counter text
	this.totRowsCssClass =		f.tot_rows_css_class!=undefined //defines css class rows counter
									? f.tot_rows_css_class : 'tot';
	var countDiv = tf_CreateElm( 'div',['id',this.prfxCounter+this.id] ); //rows counter container
	countDiv.className = this.totRowsCssClass;
	var countSpan = tf_CreateElm( 'span',['id',this.prfxTotRows+this.id] ); //rows counter label
	var countText = tf_CreateElm( 'span',['id',this.prfxTotRowsTxt+this.id] );
	countText.appendChild( tf_CreateText(this.rowsCounterText) );
	
	// counter is added to defined element
	if(this.rowsCounterTgtId==null) this.SetTopDiv();
	var targetEl = ( this.rowsCounterTgtId==null ) ? this.lDiv : tf_Id( this.rowsCounterTgtId );
	
	//IE only: clears all for sure
	if(this.rowsCounterDiv && tf_isIE)
		this.rowsCounterDiv.outerHTML = '';
	
	if( this.rowsCounterTgtId==null )
	{//default container: 'lDiv'
		countDiv.appendChild(countText);
		countDiv.appendChild(countSpan);
		targetEl.appendChild(countDiv);
	}
	else
	{// custom container, no need to append statusDiv
		targetEl.appendChild(countText);
		targetEl.appendChild(countSpan);
	}
	this.rowsCounterDiv = tf_Id( this.prfxCounter+this.id );
	this.rowsCounterSpan = tf_Id( this.prfxTotRows+this.id );
	
	this.RefreshNbRows();	
}

TF.prototype.RemoveRowsCounter = function()
/*====================================================
	- Removes rows counter label
=====================================================*/
{
	if(!this.hasGrid) return;
	if( this.rowsCounterSpan==null ) return;
	
	if(this.rowsCounterTgtId==null && this.rowsCounterDiv)
	{
		//IE only: clears all for sure
		if(tf_isIE) this.rowsCounterDiv.outerHTML = '';
		else
			this.rowsCounterDiv.parentNode.removeChild( 
				this.rowsCounterDiv
			);
	} else {
		tf_Id( this.rowsCounterTgtId ).innerHTML = '';
	}
	this.rowsCounterSpan = null;
	this.rowsCounterDiv = null;
}

TF.prototype.RefreshNbRows = function(p)
/*====================================================
	- Shows total number of filtered rows
=====================================================*/
{
	if(this.rowsCounterSpan == null) return;
	var totTxt;
	if(!this.paging)
	{
		if(p!=undefined && p!='') totTxt=p;
		else totTxt = (this.nbFilterableRows - this.nbHiddenRows - (this.hasVisibleRows ? this.visibleRows.length : 0) );
	} else {
		var paging_start_row = parseInt(this.startPagingRow)+((this.nbVisibleRows>0) ? 1 : 0);//paging start row
		var paging_end_row = (paging_start_row+this.pagingLength)-1 <= this.nbVisibleRows 
			? (paging_start_row+this.pagingLength)-1 : this.nbVisibleRows;
		totTxt = paging_start_row+'-'+paging_end_row+' / '+this.nbVisibleRows;
	} 
	this.rowsCounterSpan.innerHTML = totTxt;
}