<?php

namespace ride\web\cms\controller\widget;

use ride\library\cms\content\Content;
use ride\library\i18n\I18n;
use ride\library\orm\definition\ModelTable;
use ride\library\orm\entry\format\EntryFormatter;
use ride\library\orm\entry\LocalizedEntry;
use ride\library\orm\OrmManager;
use ride\library\reflection\ReflectionHelper;
use ride\library\router\Route;
use ride\library\validation\exception\ValidationException;

use ride\web\cms\form\ContentEntryComponent;
use ride\web\cms\orm\ContentProperties;
use ride\web\cms\orm\ContentService;
use ride\web\cms\orm\FieldService;

use \Exception;

/**
 * Widget to show the detail of a content type
 */
class ContentEntryWidget extends ContentDetailWidget {

    /**
     * Machine name of this widget
     * @var string
     */
    const NAME = 'orm.entry';

    /**
     * Namespace for the templates of this widget
     * @var string
     */
    const TEMPLATE_NAMESPACE = 'cms/widget/orm-entry';

    /**
     * Gets the additional sub routes for this widget
     * @return array|null Array with a route path as key and the action method
     * as value
     */
    public function getRoutes() {
        return array();
    }

     /**
     * Action to display the widget
     * @return null
     */
    public function indexAction(OrmManager $orm, ContentService $contentService, I18n $i18n, ReflectionHelper $reflectionHelper, $id = null) {
        $contentProperties = $this->getContentProperties();
        $ids = $contentProperties->getEntriesId();
        if ($ids === null) {
            return;
        }

        $modelName = $contentProperties->getModelName();
        if (!$modelName) {
            return;
        }

        $contentProperties->setIdField(ModelTable::PRIMARY_KEY);

        $this->entryFormatter = $orm->getEntryFormatter();
        $this->model = $orm->getModel($modelName);

        $result = null;
        foreach ($contentProperties->getEntriesId() as $index => $id) {
            $query = $this->getModelQuery($contentProperties, $this->locale, $id);

            $content = $this->getResult($contentProperties, $contentService, $query);

            if ($content && $content->data instanceof LocalizedEntry && !$content->data->isLocalized() && !$contentProperties->getIncludeUnlocalized()) {
                $content = null;
            }

//            if (!$content) {
//                return;
//            }

            if ($content) {
                $result[] =  $content; //$this->setContext('orm.entry.' . $id, $content);
            }

        }
        $this->setContext('orm.entries.' . $this->id, $result);
        if (count($result) == 1) {
            $content = array_shift($result);
            if ($contentProperties->getBreadcrumb()) {

                $url = $this->request->getBaseScript() . $this->properties->getNode()->getRoute($this->locale) . '/' . $id;
                $this->addBreadcrumb($url, $content->title);
            }

            if ($contentProperties->getTitle()) {
                $this->setPageTitle($content->title);
            }
        }

        $this->setView($contentProperties, $result);

        if ($this->properties->getWidgetProperty('region')) {
            $this->setIsRegion(true);
        }
        if ($this->properties->getWidgetProperty('section')) {
            $this->setIsSection(true);
        }
        if ($this->properties->getWidgetProperty('block')) {
            $this->setIsBlock(true);
        }
    }

    /**
     * Gets a preview of the properties of this widget
     * @return string
     */
    public function getPropertiesPreview() {
        $translator = $this->getTranslator();
        $contentProperties = $this->getContentProperties();

        $modelName = $contentProperties->getModelName();
        if (!$modelName) {
            return $translator->translate('label.widget.properties.unset');
        }

        $preview = '<strong>' . $translator->translate('label.model') . '</strong>: ' . $modelName . '<br />';
        if ($contentProperties->getEntriesId()) {
            $ids = implode (",", $contentProperties->getEntriesId());
            $preview .= '<strong>' . $translator->translate('label.entries') . '</strong>: ' . $ids . '<br />';
        }

        $maximum = $contentProperties->getMaximum();
        if ($maximum) {
             $preview .= '<strong>' . $translator->translate('label.entries.maximum') . '</strong>: ' . $maximum . '<br />';
        }

        $fields = $contentProperties->getModelFields();
        if ($fields) {
            $preview .= '<strong>' . $translator->translate('label.fields') . '</strong>: ' . implode(', ', $fields) . '<br />';
        }

        $recursiveDepth = $contentProperties->getRecursiveDepth();
        if ($recursiveDepth) {
            $preview .= '<strong>' . $translator->translate('label.depth.recursive') . '</strong>: ' . $recursiveDepth . '<br />';
        }

        $includeUnlocalized = $contentProperties->getIncludeUnlocalized();
        $preview .= '<strong>' . $translator->translate('label.unlocalized') . '</strong>: ' . $translator->translate($includeUnlocalized ? 'label.yes' : 'label.no') . '<br />';

        $idField = $contentProperties->getIdField();
        if ($idField && $idField != ModelTable::PRIMARY_KEY) {
            $preview .= '<strong>' . $translator->translate('label.field.id') . '</strong>: ' . $idField . '<br />';
        }

        $preview .= '<strong>' . $translator->translate('label.template') . '</strong>: ' . $this->getTemplate(static::TEMPLATE_NAMESPACE . '/block') . '<br>';

        return $preview;
    }

    /**
     * Action to show and edit the properties of this widget
     * @return null
     */
    public function propertiesAction(FieldService $fieldService) {
        $contentProperties = $this->getContentProperties();

        $viewProcessors = $this->dependencyInjector->getByTag('ride\\web\\cms\\orm\\processor\\ViewProcessor', 'detail');
        foreach ($viewProcessors as $id => $viewProcessors) {
            $viewProcessors[$id] = $id;
        }
        $viewProcessors = array('' => '---') + $viewProcessors;

        $component = new ContentEntryComponent($fieldService);
        $component->setLocale($this->locale);
        $component->setTemplates($this->getAvailableTemplates(static::TEMPLATE_NAMESPACE));
        $component->setViewProcessors($viewProcessors);

        $form = $this->buildForm($component, $contentProperties);
        if ($form->isSubmitted()) {
            if ($this->request->getBodyParameter('cancel')) {
                return false;
            }

            try {
                $form->validate();

                $contentProperties = $form->getData();
                $contentProperties->setToWidgetProperties($this->properties, $this->locale);

                return true;
            } catch (ValidationException $exception) {
                $this->setValidationException($exception, $form);
            }
        }

        $entriesAction = $this->getUrl('api.orm.list', array('model' => '%model%'));

        $view = $this->setTemplateView(static::TEMPLATE_NAMESPACE . '/properties.entry', array(
            'form' => $form->getView(),
        ));
        $view->addJavascript('js/cms/orm.js');
        $view->addInlineJavascript('joppaContentInitializeEntryProperties("' . $entriesAction . '");');

        return false;
    }

}
