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

use Efg\FormdataBackend;

/**
 * Class Controller
 *
 * @package ContaoBlackForest\EFG\UpdateFields\DataContainer
 */
class Controller
{
    /**
     * @param $table
     */
    public function initialiseFormDataDCA($table)
    {
        if (TL_MODE !== 'BE'
            || $table != 'tl_form_field'
        ) {
            return;
        }

        $formulaModel = \FormModel::findByPk(\Input::get('pid'));
        if (!$formulaModel->storeFormdata) {
            return;
        }

        $GLOBALS['TL_HOOKS']['outputBackendTemplate'][] = array(
            'ContaoBlackForest\EFG\UpdateFields\DataContainer\Controller',
            'updateFormDataDCA'
        );

        return;
    }

    /**
     * @param $buffer
     * @param $template
     *
     * @return mixed
     */
    public function updateFormDataDCA($buffer, $template)
    {
        $formFieldId = \Input::get('id');
        \Input::setGet('id', \Input::get('pid'));
        $formTable = new \DC_Table('tl_form');

        $formDataBackend = new FormdataBackend();
        $formDataBackend->createFormdataDca($formTable);

        \Input::setGet('id', $formFieldId);

        return $buffer;
    }
}
