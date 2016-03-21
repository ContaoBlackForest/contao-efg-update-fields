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

        $this->handleByCreate();
        $this->handleBySave();
    }

    protected function handleByCreate()
    {
        if (\Input::get('act') !== 'create') {
            return;
        }

        $formulaModel = \FormModel::findByPk(\Input::get('pid'));
        if (!$formulaModel->storeFormdata) {
            return;
        }

        $GLOBALS['TL_HOOKS']['outputBackendTemplate'][] = array(
            'ContaoBlackForest\EFG\UpdateFields\DataContainer\Controller',
            'updateFormDataDCAByCreate'
        );
    }

    protected function handleBySave()
    {
        if (!\Input::post('save')) {
            return;
        }

        $formulaModel = \FormModel::findByPk(\Input::get('pid'));
        if (!$formulaModel->storeFormdata) {
            return;
        }

        $GLOBALS['TL_DCA']['tl_form_field']['config']['onsubmit_callback'][] = array(
            'ContaoBlackForest\EFG\UpdateFields\DataContainer\Controller',
            'updateFormDataDCABySave'
        );
    }

    /**
     * @param $buffer
     * @param $template
     *
     * @return mixed
     */
    public function updateFormDataDCAByCreate($buffer, $template)
    {
        $formFieldId = \Input::get('id');
        \Input::setGet('id', \Input::get('pid'));
        $formTable = new \DC_Table('tl_form');

        $formDataBackend = new FormdataBackend();
        $formDataBackend->createFormdataDca($formTable);

        \Input::setGet('id', $formFieldId);

        return $buffer;
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
