<?php

namespace ride\web\cms\form;

use ride\library\form\FormBuilder;

/**
 * Form to edit the properties of a content detail widget
 */
class ContentDetailComponent extends AbstractContentComponent {

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
        $result['condition'] = $data->getCondition();
        $result['field-id'] = $data->getIdField();
        $result['primary'] = $data->isPrimaryMapper();
        $result['title'] = $data->getTitle();
        $result['meta-og'] = $data->getMetaOg();
        $result['format-title-og'] = $data->getOgTitleFormat();
        $result['format-teaser-og'] = $data->getOgTeaserFormat();
        $result['format-image-og'] = $data->getOgImageFormat();

        return $result;
    }

    /**
     * Parse the form values to data of the component
     * @param array $data
     * @return mixed $data
     */
    public function parseGetData(array $data) {
        $result = parent::parseGetData($data);
        $result->setCondition($data['condition']);
        $result->setIdField($data['field-id']);
        $result->setTitle($data['title']);
        $result->setIsPrimaryMapper($data['primary']);
        $result->setMetaOg($data['meta-og']);
        $result->setOgTitleFormat($data['format-title-og']);
        $result->setOgTeaserFormat($data['format-teaser-og']);
        $result->setOgImageFormat($data['format-image-og']);

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

        $modelName = $data->getModelName();
        if (!$modelName) {
            $modelOptions = $builder->getRow('model')->getOption('options');
            $modelName = reset($modelOptions);
        }

        $fieldIdOptions = $this->fieldService->getUniqueFields($modelName);

        $orm = $this->fieldService->getOrm();
        $securityManager = $orm->getDependencyInjector()->get('ride\\library\\security\\SecurityManager');
        if ($securityManager->isPermissionGranted('cms.widget.orm.entry.options')) {
            $builder->addRow('condition', 'text', array(
                'label' => $translator->translate('label.condition'),
                'description' => $translator->translate('label.condition.description'),
            ));
        }

        $builder->addRow('field-id', 'select', array(
            'label' => $translator->translate('label.field.id'),
            'description' => $translator->translate('label.field.id.description'),
            'options' => $fieldIdOptions,
        ));
        $builder->addRow('primary', 'boolean', array(
            'label' => $translator->translate('label.content.mapper.primary'),
            'description' => $translator->translate('label.content.mapper.primary.description'),
        ));
        $builder->addRow('title', 'boolean', array(
            'label' => $translator->translate('label.title'),
            'description' => $translator->translate('label.title.content.description'),
        ));
        $builder->addRow('meta-og', 'boolean', array(
            'label' => $translator->translate('label.meta.og'),
            'description' => $translator->translate('label.meta.og.description'),
            'attributes' => array(
                'data-toggle-dependant' => 'option-meta-og',
            ),
        ));
        $builder->addRow('format-title-og', 'string', array(
            'label' => $translator->translate('label.format.title'),
            'description' => $translator->translate('label.format.title.description'),
            'attributes' => array(
                'class' => 'option-meta-og option-meta-og-1',
            ),
            'filters' => array(
                'trim' => array(),
            ),
        ));
        $builder->addRow('format-teaser-og', 'string', array(
            'label' => $translator->translate('label.format.teaser'),
            'description' => $translator->translate('label.format.teaser.description'),
            'attributes' => array(
                'class' => 'option-meta-og option-meta-og-1',
            ),
            'filters' => array(
                'trim' => array(),
            ),
        ));
        $builder->addRow('format-image-og', 'string', array(
            'label' => $translator->translate('label.format.image'),
            'description' => $translator->translate('label.format.image.description'),
            'attributes' => array(
                'class' => 'option-meta-og option-meta-og-1',
            ),
            'filters' => array(
                'trim' => array(),
            ),
        ));
    }

}
