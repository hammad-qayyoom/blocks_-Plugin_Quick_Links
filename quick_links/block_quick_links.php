<?php
class block_quicklinks extends block_base {
    public function init() {
        $this->title = get_string('pluginname', 'block_quicklinks');
    }

    public function get_content() {
        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new stdClass();
        $this->content->text = '';

        $number_of_links = $this->config->number_of_links ?? 0;
        for ($i = 1; $i <= $number_of_links; $i++) {
            $title = $this->config->{'title'.$i} ?? '';
            $link = $this->config->{'link'.$i} ?? '';

            if (!empty($title) && !empty($link)) {
                $this->content->text .= html_writer::link($link, $title) . '<br>';
            }
        }

        return $this->content;
    }

    public function instance_allow_multiple() {
        return true;
    }

    public function applicable_formats() {
        return array('site' => true);
    }

    public function has_config() {
        return true;
    }
}
