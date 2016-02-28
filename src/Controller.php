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

namespace ContaoBlackForest\EFG\UpdateFields\DataContainer;

class Controller
{
    public function updateForm($value, \DataContainer $dc)
    {
        $activeRecord = $dc->activeRecord;

        $formularModel = \FormModel::findByPk($activeRecord->pid);
        if (!$formularModel->storeFormdata) {
            return $value;
        }

        return $value;
    }
}
