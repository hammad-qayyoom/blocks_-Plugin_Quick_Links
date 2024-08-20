<?php

class block_quick_links_edit_form extends block_edit_form {

    protected function specific_definition($mform) {
        $mform->addElement('text', 'config_number_of_links', get_string('numberoflinks', 'block_quick_links'));
        $mform->setType('config_number_of_links', PARAM_INT);
        $mform->setDefault('config_number_of_links', 3);

        $number_of_links = $this->block->config->number_of_links ?? 3;

        for ($i = 1; $i <= $number_of_links; $i++) {
            $mform->addElement('text', 'config_link_title_' . $i, get_string('linktitle', 'block_quick_links', $i));
            $mform->setType('config_link_title_' . $i, PARAM_TEXT);

            $mform->addElement('text', 'config_link_url_' . $i, get_string('linkurl', 'block_quick_links', $i));
            $mform->setType('config_link_url_' . $i, PARAM_URL);
        }
    }

    function set_data($defaults) {
        parent::set_data($defaults);
        $defaults->config_number_of_links = $this->block->config->number_of_links ?? 3;
    }
}
