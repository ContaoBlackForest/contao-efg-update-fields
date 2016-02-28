<?php

/**
 * Copyright (C) contao-efg-update-fields
 *
 * @package   contao-efg-update-fields
 * @author    Sven Baumann <baumann.sv@gmail.com>
 * @author    Dominik Tomasi <dominik.tomasi@gmail.com>
 * @license   GNU/LGPL
 * @copyright Copyright 2016 ContaoBlackForest
 */

$GLOBALS['TL_DCA']['tl_form_field']['fields']['type']['save_callback'][] = array(
    'ContaoBlackForest\EFG\UpdateFields\DataContainer\Controller',
    'updateForm'
);
