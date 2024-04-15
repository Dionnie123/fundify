<!-- Our admin page content should all be inside .wrap -->
<?php

// check user capabilities
if (!current_user_can('manage_options')) {
    return;
}

//Get the active tab from the $_GET param
$default_tab = null;
$tab = isset($_GET['tab']) ? $_GET['tab'] : $default_tab;


?>

<div class="wrap">
    <!-- Print the page title -->
    <h1> Fundify </h1>
    <!-- Here are our tabs -->
    <nav class="nav-tab-wrapper">
        <a href="?page=fundify-settings"
            class="nav-tab <?php if ($tab === null) : ?>nav-tab-active<?php endif; ?>">General</a>
        <a href="?page=fundify-settings&tab=settings"
            class="nav-tab <?php if ($tab === 'settings') : ?>nav-tab-active<?php endif; ?>">Settings</a>
        <a href="?page=fundify-settings&tab=tools"
            class="nav-tab <?php if ($tab === 'tools') : ?>nav-tab-active<?php endif; ?>">Tools</a>
    </nav>

    <div class="tab-content wrap">
        <?php switch ($tab):
            case 'settings':
               ?>
        <div class="wrap">
            <h1>Payment Integration Settings</h1>
            <form method="post" action="options.php">
                <?php
            // Add nonce for security
            settings_fields('payment_integration_group');
            // Get the current option values
            $options = get_option('payment_integration_options');
            ?>

                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">API Key</th>
                        <td><input type="text" name="payment_integration_options[api_key]"
                                value="<?php echo esc_attr($options['api_key']); ?>" /></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Secret Key</th>
                        <td><input type="text" name="payment_integration_options[secret_key]"
                                value="<?php echo esc_attr($options['secret_key']); ?>" /></td>
                    </tr>
                </table>
                <?php
            // Add a submit button
            submit_button('Save Settings');
            ?>
            </form>
        </div>
        <?php 
                break;
            case 'tools':
                echo 'Tools';
                break;
            default:
                echo 'Default tab';
                break;
        endswitch; ?>
    </div>
</div>