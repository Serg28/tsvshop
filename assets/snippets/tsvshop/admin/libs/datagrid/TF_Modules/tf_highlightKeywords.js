/*------------------------------------------------------------------------
	- HTML Table Filter Generator 
	- Highlight keywords feature v1.0
	- By Max Guglielmi (tablefilter.free.fr)
	- Licensed under the MIT License
-------------------------------------------------------------------------*/

TF.prototype.UnhighlightAll = function()
/*====================================================
	- removes keyword highlighting
=====================================================*/
{
	if( this.highlightKeywords && this.searchArgs!=null )
		for(var y=0; y<this.searchArgs.length; y++)
			tf_UnhighlightWord( 
				this.tbl,this.searchArgs[y],
				this.highlightCssClass 
			);
}

function tf_HighlightWord( node,word,cssClass )
/*====================================================
	- highlights keyword found in passed node
	- accepts the following params:
		- node
		- word to search
		- css class name for highlighting
=====================================================*/
{
	// Iterate into this nodes childNodes
	if(node.hasChildNodes) 
		for( var i=0; i<node.childNodes.length; i++ )
			tf_HighlightWord(node.childNodes[i],word,cssClass);

	// And do this node itself
	if(node.nodeType == 3) 
	{ // text node
		var tempNodeVal = node.nodeValue.tf_LCase();
		var tempWordVal = word.tf_LCase();
		if(tempNodeVal.indexOf(tempWordVal) != -1) 
		{
			var pn = node.parentNode;
			if(pn.className != cssClass) 
			{
				// word has not already been highlighted!
				var nv = node.nodeValue;
				var ni = tempNodeVal.indexOf(tempWordVal);
				// Create a load of replacement nodes
				var before = tf_CreateText(nv.substr(0,ni));
				var docWordVal = nv.substr(ni,word.length);
				var after = tf_CreateText(nv.substr(ni+word.length));
				var hiwordtext = tf_CreateText(docWordVal);
				var hiword = tf_CreateElm('span');
				hiword.className = cssClass;
				hiword.appendChild(hiwordtext);
				pn.insertBefore(before,node);
				pn.insertBefore(hiword,node);
				pn.insertBefore(after,node);
				pn.removeChild(node);
			}
		}
	}// if node.nodeType == 3
}

function tf_UnhighlightWord( node,word,cssClass )
/*====================================================
	- removes highlights found in passed node
	- accepts the following params:
		- node
		- word to search
		- css class name for highlighting
=====================================================*/
{
	// Iterate into this nodes childNodes
	if(node.hasChildNodes)
		for( var i=0; i<node.childNodes.length; i++ )
			tf_UnhighlightWord(node.childNodes[i],word,cssClass);

	// And do this node itself
	if(node.nodeType == 3) 
	{ // text node
		var tempNodeVal = node.nodeValue.tf_LCase();
		var tempWordVal = word.tf_LCase();
		if(tempNodeVal.indexOf(tempWordVal) != -1)
		{
			var pn = node.parentNode;
			if(pn.className == cssClass)
			{
				var prevSib = pn.previousSibling;
				var nextSib = pn.nextSibling;
				nextSib.nodeValue = prevSib.nodeValue + node.nodeValue + nextSib.nodeValue;
				prevSib.nodeValue = '';
				node.nodeValue = '';
			}
		}
	}// if node.nodeType == 3
}