<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace robote13\catalog\components;

/**
 *
 * @author Tartharia
 */
interface LeftoverUpdaterInterface
{
    /**
     *
     * @param type $items
     * @param string $message
     */
    public function reservation($items,$message = '');

    /**
     *
     * @param type $items
     * @param string $message
     */
    public function cancelReservation($items,$message = '');

    /**
     *
     * @param [] $items
     */
    public function income($items);

    /**
     *
     * @param [] $items
     */
    public function expense($items);
}
