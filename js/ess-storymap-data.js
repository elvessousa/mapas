/*-----------------------------------------------------------------------

Storymaps data
Creates a storymap on the page and get data from the post.

------------------------------------------------------------------------*/
(function($) {

    var id, mapjson, src, str, autozoom, call, calltext, imagemode,
    font, type, storymap, maplang, language, langcode, line;

    // Options
    autozoom  = ess_storymap.autozoom;
    call      = ess_storymap.call;
    calltext  = ess_storymap.calltext;
    color     = ess_storymap.backcolor;
    font      = ess_storymap.font;
    id        = ess_storymap.id;
    imagemode = ess_storymap.imagemode;
    line      = ess_storymap.line;
    type      = ess_storymap.maptype;

    // Data
    mapjson   = ess_storymap.mapjson;
    data      = mapjson;
    src       = JSON.parse(data);

    //Detects navigator language if no language informed
    language = window.navigator.userLanguage || window.navigator.language;
    langcode = language.toLowerCase();
    maplang  = ess_storymap.lang;

    if (maplang === '') {
        maplang = langcode;
    }

    // Display
    storymap = new VCO.StoryMap(id, src, {
        calculate_zoom:       autozoom,
        call_to_action:       call,
        call_to_action_text:  calltext,
        font_css:             'stock:abril-droidsans',
        line_dash:            "5,5",
        line_follows_path:    true,
        line_opacity:         0.80,
        line_weight:          3,
        map_background_color: color,
        map_type:             type,
        map_as_image:         imagemode,
        show_history_line:    false,
        show_lines:           line,
        use_custom_markers:   true,
    } );
    storymap.updateDisplay();
    window.onresize = function(event) {
        storymap.updateDisplay();
    }

})(jQuery);
