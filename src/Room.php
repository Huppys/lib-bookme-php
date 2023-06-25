<?php declare(strict_types=1);

namespace BookMe;

class Room implements Buildable {

    private string $_title;

    function __construct(string $_title) {
        $this->_title = $_title;
    }

    /**
     * @return string
     */
    public function get_title(): string {
        return $this->_title;
    }

    /**
     * @param string $title
     */
    public function set_title(string $title): void {
        $this->_title = $title;
    }
}