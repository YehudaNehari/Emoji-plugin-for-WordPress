<?php
/**
* Plugin Name: Add-emoji-plugin
* Description: Add emoji in a post / page wordpress editor.
* Version: 1.0
* Author: Yehuda Nehari
* Author URI: https://www.yehuda-nehari.com/
**/


add_action( 'admin_enqueue_scripts', 'yn_gutenberg_editor_action' );
function yn_is_gutenberg_editor() {
    if( function_exists( 'is_gutenberg_page' ) && is_gutenberg_page() ) { 
        return true;
    }   
    
    $current_screen = get_current_screen();
    if ( method_exists( $current_screen, 'is_block_editor' ) && $current_screen->is_block_editor() ) {
        return true;
    }
    return false;
}
function yn_gutenberg_editor_action() {
    if( yn_is_gutenberg_editor() ) { 
        // your gutenberg editor related CODE here
    }   
    else {
        // this is not gutenberg.
        classic_editor();
        // this may not even be an editor, you need to check the screen if you need to check for another editor.
    }
}

// Deduplication smilies
function fa_get_emojis() {
    $ynmilies = array(
        "&#128512;",
        "&#128513;",
        "&#128514;",
        "&#128515;",
        "&#128516;",
        "&#128517;",
        "&#128518;",
        "&#128519;",
        "&#128520;",
        "&#128521;",
        "&#128522;",
        "&#128523;",
        "&#128524;",
        "&#128525;",
        "&#128526;",
        "&#128527;",
        "&#128528;",
        "&#128529;",
        "&#128530;",
        "&#128531;",
        "&#128532;",
        "&#128533;",
        "&#128534;",
        "&#128535;",
        "&#128536;",
        "&#128537;",
        "&#128538;",
        "&#128539;",
        "&#128540;",
        "&#128541;",
        "&#128542;",
        "&#128543;",
        "&#128544;",
        "&#128545;",
        "&#128546;",
        "&#128547;",
        "&#128548;",
        "&#128549;",
        "&#128550;",
        "&#128551;",
    );
    foreach($ynmilies as $emoji){
        $emojis .= $emoji;
    }
    return $emojis;
}

function classic_editor() {

add_action('media_buttons_context', 'fa_smilies_custom_button');
function fa_smilies_custom_button($context) {
    $context .= '
    <a id="insert-media-button" style="position:relative" class="button insert-smilies add_smilies" title="Add Emoji" data-editor="content" href="javascript:;">
        <span class="dashicons dashicons-smiley"></span>
            Add Emoji
    </a>

    <div class="smilies-wrap emoji-wrap" id="emoji-wrap">' . fa_get_emojis() . '</div>';
    return $context;
}

?>

<script>
window.addEventListener("load", (event) => {
    jQuery(document).ready(function(){
        jQuery(document).on("click", ".insert-smilies",function() { 
            if (!jQuery(".smilies-wrap").hasClass("is-active")) {
                jQuery(".smilies-wrap").addClass("is-active");
            } else {
                jQuery(".smilies-wrap").removeClass("is-active");
            }
        });

        jQuery(document).on("click", ".emoji",function() { 
            if(jQuery(".smilies-wrap").hasClass("ise")){
            }else{
                jQuery(".smilies-wrap").hasClass("ise")
                send_to_editor(" " + jQuery(this).attr("alt") + " ");
                jQuery(".smilies-wrap").removeClass("is-active");
            }});
    });
});
</script>


<style>
.emoji-wrap {
    background:#fff;
    border: 1px solid #ccc;
    box-shadow: 2px 2px 3px rgba(0, 0, 0, 0.24);
    padding: 10px;
    position: absolute;
    top: 4.2em;
    width: 400px;
    display:none
}
#emoji-wrap img {
    height: 24px !important;
    width: 24px !important;
    cursor: pointer;
    margin-bottom: 5px !important;
    padding: 4px !important;
}
.is-active{
    display:block;
}
</style>

<?php
}
