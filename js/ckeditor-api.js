// JavaScript Document
//<![CDATA[

// The instanceReady event is fired, when an instance of CKEditor has finished
// its initialization.
CKEDITOR.on( 'instanceReady', function( ev )
{
	// Show this sample buttons.
	// document.getElementById( 'eButtons' ).style.display = 'block';
});
/*
 * 描述：向编辑器里插入html
 * 注意：编辑器id为editor1
 * 参数：htmlValue要插入的html实体
 */
function InsertHTML(htmlValue)
{
	// Get the editor instance that we want to interact with.
	var oEditor = CKEDITOR.instances.editor1;
	//var value = document.getElementById( 'htmlArea' ).value;

	// Check the active editing mode.
	if ( oEditor.mode == 'wysiwyg' )
	{
		// Insert HTML code.
		// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.editor.html#insertHtml
		oEditor.insertHtml( htmlValue );
	}
	else
		alert( 'You must be in WYSIWYG mode!' );
}
// 插入text文字，类似InsertHtml
function InsertText(value)
{
	// Get the editor instance that we want to interact with.
	var oEditor = CKEDITOR.instances.editor1;
	//var value = document.getElementById( 'txtArea' ).value;

	// Check the active editing mode.
	if ( oEditor.mode == 'wysiwyg' )
	{
		// Insert as plain text.
		// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.editor.html#insertText
		oEditor.insertText( value );
	}
	else
		alert( 'You must be in WYSIWYG mode!' );
}
//把ckeditor的html内容设置为value
function SetContents(value)
{
	// Get the editor instance that we want to interact with.
	var oEditor = CKEDITOR.instances.editor1;
	// Set editor contents (replace current contents).
	// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.editor.html#setData
	oEditor.setData( value );
}
//获取编辑器的内容
function GetContents()
{
	// Get the editor instance that you want to interact with.
	var oEditor = CKEDITOR.instances.editor1;

	// Get editor contents
	// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.editor.html#getData
	return oEditor.getData();
}

function ExecuteCommand( commandName )
{
	// Get the editor instance that we want to interact with.
	var oEditor = CKEDITOR.instances.editor1;

	// Check the active editing mode.
	if ( oEditor.mode == 'wysiwyg' )
	{
		// Execute the command.
		// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.editor.html#execCommand
		oEditor.execCommand( commandName );
	}
	else
		alert( 'You must be in WYSIWYG mode!' );
}

function CheckDirty()
{
	// Get the editor instance that we want to interact with.
	var oEditor = CKEDITOR.instances.editor1;
	// Checks whether the current editor contents present changes when compared
	// to the contents loaded into the editor at startup
	// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.editor.html#checkDirty
	alert( oEditor.checkDirty() );
}

function ResetDirty()
{
	// Get the editor instance that we want to interact with.
	var oEditor = CKEDITOR.instances.editor1;
	// Resets the "dirty state" of the editor (see CheckDirty())
	// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.editor.html#resetDirty
	oEditor.resetDirty();
	alert( 'The "IsDirty" status has been reset' );
}

	//]]>