<?php
// check user capabilities
if (!current_user_can('manage_options')) {
    return;
}

// add error/update messages

// check if the user have submitted the settings
// WordPress will add the "settings-updated" $_GET parameter to the url
if (isset($_GET['settings-updated'])) {
    // add settings saved message with the class of "updated"
    add_settings_error('fundify_messages', 'fundify_message', __('Settings Saved', 'fundify'), 'updated');
}


?>
<div class="card bg-primary">
    <h4 class="mb-0 text-white"><?php echo ucwords(strtolower(esc_html(get_admin_page_title()))); ?>
        <?php echo $this->version ?></h4>
</div>
<div class="wrap">



    <?php
    // show error/update messages
    settings_errors('fundify_messages');
    ?>



    <form action="options.php" method="post">
        <?php
        // output security fields for the registered setting "fundify"
        settings_fields('fundify');
        // output setting sections and their fields
        // (sections are registered for "fundify", each field is registered to a specific section)
        do_settings_sections('fundify');
        // output save settings button
        submit_button('Save Settings');
        ?>
    </form>
</div>