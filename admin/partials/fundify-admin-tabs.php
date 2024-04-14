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
        <a href="?page=fundify-settings" class="nav-tab <?php if ($tab === null) : ?>nav-tab-active<?php endif; ?>">General</a>
        <a href="?page=fundify-settings&tab=settings" class="nav-tab <?php if ($tab === 'settings') : ?>nav-tab-active<?php endif; ?>">Settings</a>
        <a href="?page=fundify-settings&tab=tools" class="nav-tab <?php if ($tab === 'tools') : ?>nav-tab-active<?php endif; ?>">Tools</a>
    </nav>

    <div class="tab-content wrap">
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