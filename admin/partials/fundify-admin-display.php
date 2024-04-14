<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://https://markdionniebulingit.vercel.app/
 * @since      1.0.0
 *
 * @package    Fundify
 * @subpackage Fundify/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">
    <h4>Fundify</h4>
</div>

<?php

//Admin page html callback
//Print out html for admin page
function admin_page_html()
{
    // check user capabilities


    //Get the active tab from the $_GET param
    $default_tab = null;
    $tab = isset($_GET['tab']) ? $_GET['tab'] : $default_tab;

?>
    <!-- Our admin page content should all be inside .wrap -->
    <div class="wrap">
        <!-- Print the page title -->
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <!-- Here are our tabs -->
        <nav class="nav-tab-wrapper">
            <a href="?page=my-plugin" class="nav-tab <?php if ($tab === null) : ?>nav-tab-active<?php endif; ?>">Default
                Tab</a>
            <a href="?page=my-plugin&tab=settings" class="nav-tab <?php if ($tab === 'settings') : ?>nav-tab-active<?php endif; ?>">Settings</a>
            <a href="?page=my-plugin&tab=tools" class="nav-tab <?php if ($tab === 'tools') : ?>nav-tab-active<?php endif; ?>">Tools</a>
        </nav>

        <div class="tab-content">
            <?php switch ($tab):
                case 'settings':
                    echo 'Settings'; //Put your HTML here
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
<?php

    echo admin_page_html();
}
