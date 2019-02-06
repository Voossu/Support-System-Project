<?php

class View {

    protected $result;

    /**
     * View constructor.
     * @param $template_path string
     * @param $_DATA array
     */
    protected function __construct($template_path, $_DATA) {
        global $_CONFIG, $_LANG, $_USER, $_ROUTING, $_MENU;
        ob_start();
        include $template_path;
        $this->result = ob_get_clean();
    }

    /**
     * @param $template string
     * @param $_DATA array
     * @return View
     */
    static function render($template, $_DATA = []) {
        $template_path = VIEW_DIR.$template.".php";
        return is_readable($template_path) ? new View($template_path, $_DATA) : null;
    }

    /**
     * @return string
     */
    function __toString() {
        return trim($this->result);
    }

    /**
     * display
     */
    function display() {
        echo trim($this->result);
    }

    /**
     * The prohibition of creating duplicates
     */
    private function __clone()  {}
    private function __wakeup() {}

}