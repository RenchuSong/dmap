/*
Copyright (c) 2003-2011, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	
	// 界面语言，默认为 'en'
    config.language = 'zh-cn';
	
    // 设置宽高
    config.width = 550;
    config.height = 250;
	
	// 工具栏（基础'Basic'、全能'Full'、自定义）plugins/toolbar/plugin.js
	//config.toolbar = 'Full';
	config.toolbar_Full = [
       ['Source'],
       ['Cut','Copy','Paste','PasteText'],
       ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
       ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
       ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
       ['Link','Unlink','Anchor'],
       ['Table','HorizontalRule'],
       ['Styles','Format','Font','FontSize'],
       ['TextColor','BGColor'],
	   ['Image',"Flash","Button"]
    ];
	
	//设置最大、小高、宽
	config.resize_maxHeight=400;
	config.resize_maxWidth=510;
	config.resize_minHeight=400;
	config.resize_minWidth=510;
	
};
