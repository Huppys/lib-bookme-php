<?php

namespace BookMe;

class Extra implements Buildable {

    private string $_title;
    private float $_costs;
    private float $_taxAmount;
    private string $_description;

    public function __construct(string $_title, float $_costs, float $_taxAmount, string $_description) {
        $this->_title = $_title;
        $this->_costs = $_costs;
        $this->_taxAmount = $_taxAmount;
        $this->_description = $_description;
    }

    /**
     * @return string
     */
    public function get_description(): string {
        return $this->_description;
    }

    /**
     * @param string $description
     */
    public function set_description(string $description): void {
        $this->_description = $description;
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

    /**
     * @return float
     */
    public function get_costs(): float {
        return $this->_costs;
    }

    /**
     * @param float $costs
     */
    public function set_costs(float $costs): void {
        $this->_costs = $costs;
    }

    /**
     * @return float
     */
    public function get_taxAmount(): float {
        return $this->_taxAmount;
    }

    /**
     * @param float $taxAmount
     */
    public function set_taxAmount(float $taxAmount): void {
        $this->_taxAmount = $taxAmount;
    }
}