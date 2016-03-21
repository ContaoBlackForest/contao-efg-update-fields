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

        $this->handleBySave();
        $this->handleBySaveAndClose();
    }

    protected function handleBySave()
    {
        if (!\Input::post('save')) {
            return;
        }

        $formulaFieldModel = \FormFieldModel::findByPk(\Input::get('id'));
        $formulaModel = $formulaFieldModel->getRelated('pid');
        if (!$formulaModel->storeFormdata) {
            return;
        }

        $this->registerOnSubmitCallback();
    }

    protected function handleBySaveAndClose()
    {
        if (!\Input::post('saveNclose')) {
            return;
        }

        $formulaFieldModel = \FormFieldModel::findByPk(\Input::get('id'));
        $formulaModel = $formulaFieldModel->getRelated('pid');
        if (!$formulaModel->storeFormdata) {
            return;
        }

        $this->registerOnSubmitCallback();
    }


    protected function registerOnSubmitCallback()
    {
        $GLOBALS['TL_DCA']['tl_form_field']['config']['onsubmit_callback'][] = array(
            'ContaoBlackForest\EFG\UpdateFields\DataContainer\Controller',
            'updateFormDataDCABySave'
        );
    }

    /**
     * @param \DataContainer $dc
     */
    public function updateFormDataDCABySave(\DataContainer $dc)
    {
        $activeRecord = $dc->activeRecord;

        $formTable = new \DC_Table('tl_form');
        $formTable->id = $activeRecord->pid;

        $formDataBackend = new FormdataBackend();
        $formDataBackend->createFormdataDca($formTable);
    }
}
