/*-----------------------------------------------------------------------

	Tiny MCE custom buttons and popups
	- Storymaps
	- Timeline

------------------------------------------------------------------------*/
(function() {
	tinymce.create('tinymce.plugins.essCPTButtons', {
		init : function(ed, url) {

			// ----------------------------------------------------
			// Storymap
			// ----------------------------------------------------
			ed.addCommand('storymap-popup', function() {
				ed.windowManager.open({
					file : url + '/popups/storymaps-popup.php',
					width : 420,
					height : 470,
					inline : 1
				}, {
					plugin_url : url
				});
			});

			ed.addButton('storymap', {title : 'Storymap', cmd : 'storymap-popup', image: url + '/icons/storymap.png' });
		},

		createControl : function(n, cm) {
			return null;
		},
	});

	tinymce.PluginManager.add('storymap', tinymce.plugins.essCPTButtons);
	tinymce.PluginManager.add('timeline', tinymce.plugins.essCPTButtons);
})();
