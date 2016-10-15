<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2015 NRE
 */

namespace nullref\fulladmin\interfaces;


interface IMenuBuilder
{
    /**
     * @param array $items
     * @return array
     */
    public function build($items);
} 