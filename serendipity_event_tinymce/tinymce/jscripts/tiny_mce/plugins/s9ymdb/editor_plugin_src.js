/**
 * 
 *
 * @author Grischa Brockhaus
 * @copyright Copyright � 2004-2007, bitmotor.de, All rights reserved.
 */

/* Import plugin specific language pack */ 
tinyMCE.importPluginLanguagePack('s9ymdb');

var TinyMCE_S9Y_MediaDB_Plugin = {

	getInfo : function() {
		return {
			longname : 'S9Y Mediadatabase',
			author : 'bitmotor.de',
			authorurl : 'http://bitmotor.de',
			infourl : '',
			version : tinyMCE.majorVersion + "." + tinyMCE.minorVersion
		};
	},

	getControlHTML : function(cn) { 
		switch (cn) { 
			case "s9ymdb":
				return tinyMCE.getButtonHTML(cn, 'lang_s9ymdb_desc', '{$pluginurl}/images/s9ymdb.gif', 's9yMediaDb', true);
		}
		return ""; 
	},

	/**
	 * Gets executed when a TinyMCE editor instance is initialized.
	 *
	 * @param {TinyMCE_Control} Initialized TinyMCE editor control instance. 
	 */
	initInstance : function(inst) {
		// Register custom keyboard shortcut
		inst.addShortcut('ctrl', 'm', 'lang_s9ymdb_desc', 's9yMediaDb');
	},


	execCommand : function(editor_id, element, command, user_interface, value) { 
		var textarea = 'body';
		switch (command) { 
			case "s9yMediaDb": 
				if (editor_id == 'mce_editor_1')
					textarea = 'extended';
				if (user_interface) {
					var template = new Array(); 
					template['file']	= serendipityBaseUrl + '/serendipity_admin_image_selector.php?serendipity[textarea]=' + textarea; // Relative to theme 
					template['width']  = 800; 
					template['height'] = 600; 
					var plain_text = ""; 
					tinyMCE.openWindow(template); 
				}
				return true;
		}

		// Pass to next handler in chain 
		return false; 
	}

};

tinyMCE.addPlugin("s9ymdb", TinyMCE_S9Y_MediaDB_Plugin);
