<?php
require_once('../../config.php');
require_login();

$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/blocks/quicklinks/index.php'));
$PAGE->set_title(get_string('pluginname', 'block_quicklinks'));
$PAGE->set_heading(get_string('pluginname', 'block_quicklinks'));

echo $OUTPUT->header();

if (is_siteadmin()) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $num_links = required_param('num_links', PARAM_INT);
        set_config('numlinks', $num_links, 'block_quicklinks');

        // Save the title and link configurations based on the current number of links
        for ($i = 1; $i <= $num_links; $i++) {
            $title_param = 'title' . $i;
            $link_param = 'link' . $i;

            // These checks ensure that the fields are not required in the POST request unless they are present in the form
            if (optional_param($title_param, null, PARAM_TEXT) !== null && optional_param($link_param, null, PARAM_URL) !== null) {
                set_config($title_param, required_param($title_param, PARAM_TEXT), 'block_quicklinks');
                set_config($link_param, required_param($link_param, PARAM_URL), 'block_quicklinks');
            }
        }
    }

    // Retrieve the current number of links from configuration
    $num_links = get_config('block_quicklinks', 'numlinks') ?? 3;

    echo '<form method="POST">';
    echo '<div class="form-group">';
    echo '<label for="num_links">'.get_string('numlinks', 'block_quicklinks').'</label>';
    echo '<input type="number" class="form-control" id="num_links" name="num_links" value="' . $num_links . '" min="1" max="5" required>';
    echo '</div>';

    // Generate input fields based on the number of links
    for ($i = 1; $i <= $num_links; $i++) {
        $title_value = get_config('block_quicklinks', 'title' . $i) ?? '';
        $link_value = get_config('block_quicklinks', 'link' . $i) ?? '';

        echo '<div class="form-group">';
        echo '<label for="title'.$i.'">'.get_string('title', 'block_quicklinks')." $i".'</label>';
        echo '<input type="text" class="form-control" id="title'.$i.'" name="title'.$i.'" value="' . $title_value . '">';
        echo '</div>';
        echo '<div class="form-group">';
        echo '<label for="link'.$i.'">'.get_string('link', 'block_quicklinks')." $i".'</label>';
        echo '<input type="url" class="form-control" id="link'.$i.'" name="link'.$i.'" value="' . $link_value . '">';
        echo '</div>';
    }

    echo '<button type="submit" class="btn btn-primary">'.get_string('savechanges').'</button>';
    echo '</form>';
}

echo $OUTPUT->footer();
