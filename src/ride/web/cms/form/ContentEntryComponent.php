<?php

namespace ride\web\cms\form;

use ride\library\form\FormBuilder;

/**
 * Form to edit the properties of a content entry widget
 */
class ContentEntryComponent extends AbstractContentComponent {

    /**
     * Code of the locale of the entries
     * @var string
     */
    protected $locale;

    /**
     * Sets the locale for the entries
     * @param string $locale Code of the locale
     * @return null
     */
    public function setLocale($locale) {
        $this->locale = $locale;
    }

    /**
     * Parse the data to form values for the component rows
     * @param mixed $data
     * @return array $data
     */
    public function parseSetData($data) {
        if (!$data) {
            return null;
        }

        $result = parent::parseSetData($data);
        $result['entries'] = $data->getEntriesId();
        $result['maximum'] = $data->getMaximum();
        $result['condition'] = $data->getCondition();
        $result['title'] = $data->getTitle();
        $result['titleString'] = $data->getTitleString();
        $result['breadcrumb'] = $data->getBreadcrumb();

        return $result;
    }

    /**
     * Parse the form values to data of the component
     * @param array $data
     * @return mixed $data
     */
    public function parseGetData(array $data) {

        $result = parent::parseGetData($data);
        $result->setEntriesId($data['entries']);
        $result->setMaximum($data['maximum']);
        $result->setCondition($data['condition']);
        $result->setTitle($data['title']);
        $result->setTitleString($data['titleString']);
        $result->setBreadcrumb($data['breadcrumb']);

        return $result;
    }

    /**
     * Prepares the form builder by adding row definitions
     * @param \ride\library\form\FormBuilder $builder
     * @param array $options Extra options from the controller
     * @return null
     */
    public function prepareForm(FormBuilder $builder, array $options) {
        $data = $options['data'];

        parent::prepareForm($builder, $options);

        $translator = $options['translator'];
        $orm = $this->fieldService->getOrm();

        $modelName = $data->getModelName();
        if (!$modelName) {
            $modelOptions = $builder->getRow('model')->getOption('options');
            $modelName = reset($modelOptions);
        }

        $entryOptions = array('' => '---');
        $model = $orm->getModel($modelName);

        //$entries = $model->find(null, $this->locale);
        $query = $model->createQuery($this->locale);
        if ($data->getCondition()) {
            $query->addCondition($data->getCondition());
        }
        $entries = $query->query();
        $entryOptions += $model->getOptionsFromEntries($entries);

        $maximum = $data->getMaximum();
        if (!$maximum) {
            $maximum = 1;
        }
        $builder->addRow('entries', 'select', array(
            'label' => $translator->translate('label.entries'),
            'description' => $translator->translate('label.entries.description'),
            'validators' => array(
              'size' => array(
                  'maximum' => $maximum
              )
            ),
            'options' => $entryOptions,
            'multiple' => true
        ));
        $securityManager = $orm->getDependencyInjector()->get('ride\\library\\security\\SecurityManager');
        if ($securityManager->isPermissionGranted('cms.widget.orm.entry.options')) {
            $builder->addRow('maximum', 'select', array(
                'label' => $translator->translate('label.entries.maximum'),
                'description' => $translator->translate('label.entries.maximum.description'),
                'validators' => array(
                    'required' => array()
                ),
                'default' => 1,
                'options' => $this->getNumericOptions(1, 50),
            ));
            $builder->addRow('condition', 'text', array(
                'label' => $translator->translate('label.condition'),
                'description' => $translator->translate('label.condition.description'),
            ));
        }
        $builder->addRow('breadcrumb', 'boolean', array(
            'label' => $translator->translate('label.breadcrumb.add'),
            'description' => $translator->translate('label.breadcrumb.add.description'),
        ));
        $builder->addRow('title', 'boolean', array(
            'label' => $translator->translate('label.title'),
            'description' => $translator->translate('label.title.content.description'),
        ));
        $builder->addRow('titleString', 'string', array(
            'label' => $translator->translate('label.title.string')
        ));
    }

}
