<?php
require_once('../../../../../../wp-load.php');
?>
<!DOCTYPE html>
<head>
	<title>Story Map</title>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.js"></script>
	<script type="text/javascript" language="javascript" src="../tiny_mce_popup.js"></script>
	<link rel="stylesheet" href="../../../css/bootstrap.min.css">
	<link rel="stylesheet" href="../../../icons/icons.css">
	<style type="text/css">
	label { font-size: 12px; }
	input[type="text"] { padding: 5px; height: 25px; }
	.toggled { padding: 5px 0; }
	</style>
	<script type="text/javascript">
	// ----------------------------------------------------
	// Storymap dialog script
	// ----------------------------------------------------
	var StorymapDialog = {
		local_ed : 'ed',
		init : function(ed) {
			StorymapDialog.local_ed = ed;
			tinyMCEPopup.resizeToInnerSize();
		},
		insert : function insertStoryMap(ed) {

			// Try and remove existing style / blockquote
			tinyMCEPopup.execCommand('mceRemoveNode', false, null);

			// Set up variables to contain our input values
			var name      = document.getElementById('storymap-name').value;
			var width     = document.getElementById('storymap-width').value;
			var height    = document.getElementById('storymap-height').value;
			var imagemode = document.getElementById('storymap-imagemode').value;
			var type      = document.getElementById('storymap-type').value;
			var font      = document.getElementById('storymap-font').value;
			var call      = document.getElementById('storymap-call').value;
			var calltext  = document.getElementById('storymap-calltext').value;
			var autozoom  = document.getElementById('storymap-autozoom').value;
			var theme  	  = document.getElementById('storymap-theme').value;
			var lines  	  = document.getElementById('storymap-lines').value;
			var output    = '';

			// Setup the output of our shortcode
			output = '[ess-storymap';
			if(name) 		output += ' name="' + name + '"';
			if(width) 		output += ' width="' + width + '"';
			if(height) 		output += ' height="' + height + '"';
			if(imagemode) 	output += ' imagemode="' + imagemode + '"';
			if(type) 		output += ' type="' + type + '"';
			if(font) 		output += ' font="' + font + '"';
			if(call) 		output += ' call="' + call + '"';
			if(calltext) 	output += ' calltext="' + calltext + '"';
			if(theme) 		output += ' theme="' + theme + '"';
			if(autozoom) 	output += ' autozoom="' + autozoom + '"';
			if(lines) 		output += ' lines="' + lines + '"';

			// Check to see if the TEXT field is blank
			output += ']';
			tinyMCEPopup.execCommand('mceReplaceContent', false, output);

			// Return
			tinyMCEPopup.close();
		}
	};
	tinyMCEPopup.onInit.add(StorymapDialog.init, StorymapDialog);
	</script>
</head>
<body>
	<div id="storymap-dialog">

		<form action="/" method="get" accept-charset="utf-8" class="form-horizontal">
			<div class="container">
				<h3>
					<i class="icon-location"></i>
					<?php _e('Insert Storymap', 'ess-storymap'); ?><br>
					<small><?php _e('Insert a storymap in the contents', 'ess-storymap'); ?></small>
				</h3>
				<hr>

				<!-- Storymap -->
				<div class="form-group">
					<label class="col-xs-4 control-label" for="storymap-name"><?php _e('Story', 'ess-storymap'); ?></label>
					<div class="col-xs-8">
						<select class="form-control" name="storymap-name" id="storymap-name" size="1">
							<option value="" selected="selected">Select a story</option>
							<?php
							$terms = get_terms( 'stories', 'orderby=count&hide_empty=1' );
							foreach ($terms as $term) {
								echo '<option value="'.$term->slug.'">'.$term->name.'</option>';
							} ?>
						</select>
					</div>
				</div>

				<!-- Size -->
				<div class="form-group">
					<label class="col-xs-4 control-label" for="storymap-width"><?php _e('Size', 'ess-storymap'); ?></label>
					<div class="col-xs-4">
						<input class="form-control" type="text" name="storymap-width" value="100%" id="storymap-width" />
					</div>
					<div class="col-xs-4">
						<input class="form-control" type="text" name="storymap-height" value="500px" id="storymap-height" />
					</div>
				</div>

				<!-- Image mode -->
				<div class="form-group">
					<label class="col-xs-4 control-label" for="storymap-imagemode"><?php _e('Mode', 'ess-storymap'); ?></label>
					<div class="col-xs-8">
						<select class="form-control" name="storymap-imagemode" id="storymap-imagemode" size="1">
							<option value="" selected="selected"><?php _e('Cartography','ess-storymap') ?></option>
							<option value="true"><?php _e('Image','ess-storymap') ?></option>
						</select>
					</div>
				</div>

				<!-- Font presets -->
				<div class="form-group">
					<label class="col-xs-4 control-label" for="storymap-font"><?php _e('Font preset', 'ess-storymap'); ?></label>
					<div class="col-xs-8">
						<select class="form-control" name="storymap-font" id="storymap-font" size="1">
							<option value="">Default</option>
							<option value="stock:abril-droidsans">Abril Fatface &amp; Droid Sans</option>
							<option value="stock:amatic-andika">Amatic &amp; Andika</option>
							<option value="stock:bitter-raleway">Bitter &amp; Raleway</option>
							<option value="stock:clicker-garamond">Clicker &amp; Garamond</option>
							<option value="stock:dancing-ledger">Dancing &amp; Ledger</option>
							<option value="stock:fjalla-average">Fjalla &amp; Average</option>
							<option value="stock:georgia-helvetica">Georgia &amp; Helvetica</option>
							<option value="stock:lustria-lato">Lustria &amp; Lato</option>
							<option value="stock:medula-lato">Medula One &amp; Lato</option>
							<option value="stock:oldstandard">Old Standard</option>
							<option value="stock:opensans-gentiumbook">Open Sans &amp; Gentium Book Basic</option>
							<option value="stock:playfair-faunaone">Playfair &amp; Fauna One</option>
							<option value="stock:playfair">Playfair SC &amp; Playfair</option>
							<option value="stock:pt">PT Sans &amp; PT Serif &amp; PT Sans Narrow</option>
							<option value="stock:roboto-megrim">Roboto Slab &amp; Megrim</option>
							<option value="stock:rufina-sintony">Rufina &amp; Sintony</option>
							<option value="stock:unicaone-volkorn">Unica One &amp; Vollkorn</option>
						</select>
					</div>
				</div>

				<!-- Map type -->
				<div class="form-group">
					<label class="col-xs-4 control-label" for="storymap-type"><?php _e('Type', 'ess-storymap'); ?></label>
					<div class="col-xs-8">
						<select class="form-control" name="storymap-type" id="storymap-type" size="1">
							<option value="" selected="selected">Custom</option>
							<option value="stamen:toner-lite"><?php _e('Stamen Maps: Toner Lite', 'ess-storymap'); ?></option>
							<option value="stamen:toner"><?php _e('Stamen Maps: Toner', 'ess-storymap'); ?></option>
							<option value="stamen:toner-lines"><?php _e('Stamen Maps: Toner Lines', 'ess-storymap'); ?></option>
							<option value="stamen:toner-labels"><?php _e('Stamen Maps: Toner Labels', 'ess-storymap'); ?></option>
							<option value="stamen:toner-background"><?php _e('Stamen Maps: Toner Background', 'ess-storymap'); ?></option>
							<option value="stamen:watercolor"><?php _e('Stamen Maps: Watercolor', 'ess-storymap'); ?></option>
							<option value="stamen:terrain"><?php _e('Stamen Maps: Terrain', 'ess-storymap'); ?></option>
							<option value="osm:standard"><?php _e('Open Street Maps: Standard', 'ess-storymap'); ?></option>
							<option value="mapbox'"><?php _e('Mapbox', 'ess-storymap'); ?></option>
						</select>
					</div>
				</div>

				<!-- Call to action -->
				<div class="form-group">
					<label class="col-xs-4 control-label" for="storymap-call"><?php _e('Call to action', 'ess-storymap'); ?></label>
					<div class="col-xs-8">
						<select class="form-control" name="storymap-call" id="storymap-call" size="1">
							<option value="" selected="selected"><?php _e('None','ess-storymap') ?></option>
							<option value="true"><?php _e('Use call to action','ess-storymap') ?></option>
						</select>
						<p class="toggled">
							<input class="form-control" type="text" name="storymap-calltext" placeholder="<?php _e('Button text: Start exploring', 'ess-storymap'); ?>" id="storymap-calltext" />
						</p>
					</div>
				</div>

				<!-- Theme -->
				<div class="form-group">
					<label class="col-xs-4 control-label" for="storymap-theme"><?php _e('Theme', 'ess-storymap'); ?></label>
					<div class="col-xs-8">
						<select class="form-control" name="storymap-theme" id="storymap-theme" size="1">
							<option value="" selected="selected"><?php _e('Light','ess-storymap') ?></option>
							<option value="dark"><?php _e('Dark','ess-storymap') ?></option>
						</select>
					</div>
				</div>

				<!-- Line -->
				<div class="form-group">
					<label class="col-xs-4 control-label" for="storymap-lines"><?php _e('Show lines', 'ess-storymap'); ?></label>
					<div class="col-xs-8">
						<select class="form-control" name="storymap-lines" id="storymap-lines" size="1">
							<option value="" selected="selected"><?php _e('Show lines','ess-storymap') ?></option>
							<option value="false"><?php _e('Hide lines','ess-storymap') ?></option>
						</select>
					</div>
				</div>

				<!-- Zoom -->
				<div class="form-group">
					<label class="col-xs-4 control-label" for="storymap-autozoom"><?php _e('Auto zoom', 'ess-storymap'); ?></label>
					<div class="col-xs-8">
						<select class="form-control" name="storymap-autozoom" id="storymap-autozoom" size="1">
							<option value="" selected="selected"><?php _e('Use automatic zoom','ess-storymap') ?></option>
							<option value="false"><?php _e('Use zoom defined in each slide','ess-storymap') ?></option>
						</select>
					</div>
				</div>

				<hr>
				<!-- Insert button -->
				<p><a class="btn btn-block btn-default" href="javascript:StorymapDialog.insert(StorymapDialog.local_ed)" id="inserto">Insert</a></p>
			</form>
		</div>
	</div>
	<script type="text/javascript">
	(function($) {
		$('.toggled').hide();
		$('#storymap-call').change( function () {
			var call = document.getElementById('storymap-call').value;
			if(call == 'true') {
				$('.toggled').show();
			} else {
				$('.toggled').hide();
			}
		});
	})(jQuery);
	</script>
</body>
</html>
