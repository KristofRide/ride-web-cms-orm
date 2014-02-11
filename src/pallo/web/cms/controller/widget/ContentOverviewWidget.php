<?php

namespace pallo\web\cms\controller\widget;

use pallo\library\cms\content\Content;
use pallo\library\cms\node\NodeModel;
use pallo\library\html\Pagination;
use pallo\library\http\Response;
use pallo\library\orm\query\ModelQuery;
use pallo\library\orm\model\data\format\DataFormatter;
use pallo\library\orm\OrmManager;
use pallo\library\router\Route;
use pallo\library\validation\exception\ValidationException;

use pallo\web\cms\content\mapper\OrmContentMapper;
use pallo\web\cms\controller\widget\AbstractWidget;
use pallo\web\cms\form\ContentOverviewComponent;
use pallo\web\cms\orm\ContentProperties;
use pallo\web\cms\orm\FieldService;

use \Exception;

/**
 * Widget to show a overview of a content type
 */
class ContentOverviewWidget extends AbstractWidget {

    /**
     * Machine name of this widget
     * @var string
     */
    const NAME = 'orm.overview';

    /**
     * Relative path to the icon of this widget
     * @var string
     */
    const ICON = 'img/cms/widget/content.overview.png';

    /**
     * Parameter name for the page
     * @var string
     */
    const PARAM_PAGE = 'page';

    /**
     * Instance of the model
     * @var pallo\library\orm\model\Model
     */
    private $model;

    /**
     * Data formatter for ORM data
     * @var pallo\library\orm\model\data\format\DataFormatter
     */
    private $dataFormatter;

    /**
     * Construct this widget
     * @return null
     */
    public function __construct() {
        $this->model = null;
        $this->dataFormatter = null;
    }

    /**
     * Gets the additional sub routes for this widget
     * @return array|null Array with a route path as key and the action method
     * as value
     */
    public function getRoutes() {
        $contentProperties = $this->getContentProperties();
        if (!$contentProperties->getParameters()) {
            return null;
        }

        $route = new Route('/', array($this, 'indexAction'), null, array('head', 'get'));
        $route->setIsDynamic(true);

        return array(
            $route,
        );
    }

    /**
     * Gets the templates used by this widget
     * @return array Array with the resource names of the templates
     */
    public function getTemplates() {
        $contentProperties = $this->getContentProperties();

        $view = $contentProperties->getView();
        if (!$view) {
            return null;
        }

        $view = $this->dependencyInjector->get('pallo\\web\\cms\\view\\widget\\ContentOverviewView', $view);

        return array($view->getTemplate()->getResource());
    }

    /**
     * Action to display the widget
     * @return null
     */
    public function indexAction(OrmManager $orm) {
        $contentProperties = $this->getContentProperties();
        $modelName = $contentProperties->getModelName();

        if (!$modelName) {
            if ($this->properties->isAutoCache()) {
                $this->properties->setCache(true);
            }

            return;
        }

        $parameters = $contentProperties->getParameters();
        $arguments = func_get_args();
        array_shift($arguments); // remove $orm

        if ($parameters) {
            if (is_array($parameters)) {
                if (count($arguments) != (count($parameters) * 2)) {
                    $this->response->setStatusCode(404);

                    return;
                }

                $arguments = $this->parseArguments($arguments);
            } else {
                if (count($arguments) != $parameters) {
                    $this->response->setStatusCode(404);
                    return;
                }

                foreach ($arguments as $index => $argument) {
                    $arguments[$index] = urldecode($argument);
                }
            }
        } elseif ($arguments) {
            $action = $contentProperties->getNoParametersAction();
            if (!$action || $action == ContentProperties::NONE_404 || $action == ContentProperties::NONE_IGNORE) {
                if ($action != ContentProperties::NONE_IGNORE) {
                    $this->response->setStatusCode(Response::STATUS_CODE_NOT_FOUND);
                }

                return;
            }
        } else {
            $arguments = null;
        }

        $page = 1;
        $pages = 1;
        if ($contentProperties->willShowPagination()) {
            $page = $this->request->getQueryParameter(self::PARAM_PAGE);
            if (!is_numeric($page) || $page <= 0) {
                $page = 1;
            }
        }

        $this->dataFormatter = $orm->getDataFormatter();
        $this->model = $orm->getModel($modelName);

        $query = $this->getModelQuery($contentProperties, $this->locale, $page, $arguments);

        if ($contentProperties->willShowPagination()) {
            $rows = max(0, $query->count() - $contentProperties->getPaginationOffset());
            $pages = ceil($rows / $contentProperties->getPaginationRows());

            if ($contentProperties->useAjaxForPagination() && $this->request->isXmlHttpRequest()) {
                $this->setIsContent(true);
            }
        }

//         try {
            $result = $this->getResult($contentProperties, $query);

            $view = $this->getView($contentProperties, $result, $pages, $page);
//         } catch (Exception $exception) {
//             $log = $this->zibo->getLog();
//             if ($log) {
//                 $log->logException($exception);
//             }

//             $view = null;
//         }

        if (!$view) {
            return;
        }

        if ($this->properties->isAutoCache()) {
            $this->properties->setCache(true);
            $this->properties->setCacheTtl(60);
        }

        $this->response->setView($view);
    }

    /**
     * Gets the view
     * @param array $result
     * @param joppa\orm\model\ContentProperties $properties
     * @param integer $pages
     * @param integer $page
     * @return joppa\orm\view\ContentView
     */
    private function getView(ContentProperties $contentProperties, array $result, $pages = 1, $page = 1) {
        $view = $contentProperties->getView();

        $view = $this->dependencyInjector->get('pallo\\web\\cms\\view\\widget\\ContentOverviewView', $view);
        $view = clone $view;

        $pagination = null;
        if ($contentProperties->willShowPagination()) {
            $paginationUrl = $this->request->getUrl();
            if (strpos($paginationUrl, '?') !== false) {
                list($paginationUrl, $query) = explode('?', $paginationUrl, 2);
            }

            $paginationUrl .= '?' . self::PARAM_PAGE . '='. '%page%';

            $pagination = new Pagination($pages, $page);
            $pagination->setHref($paginationUrl);
        }

        $moreUrl = null;
        if ($contentProperties->willShowMoreLink()) {
            $nodeModel = $this->dependencyInjector->get('pallo\\library\\cms\\node\\NodeModel');

            $node = $nodeModel->getNode($contentProperties->getMoreNode());

            $moreUrl = $this->request->getBaseScript() . $node->getRoute($this->locale);
        }

        $view->setContent($this->locale, $this->id, $result, $contentProperties, $pagination, $moreUrl);

        return $view;
    }

    /**
     * Gets the result from the query
     * @param zibo\library\orm\model\Model $model
     * @param zibo\library\orm\query\ModelQuery $query
     * @param joppa\orm\model\ContentProperties $properties
     * @return array Array with Content objects
     */
    private function getResult(ContentProperties $contentProperties, ModelQuery $query) {
        $result = $query->query();
        if (!$result) {
            return $result;
        }

        $node = $this->properties->getNode();
        $meta = $this->model->getMeta();

        $modelTable = $meta->getModelTable();

        $titleFormat = $contentProperties->getContentTitleFormat();
        if (!$titleFormat) {
            $titleFormat = $modelTable->getDataFormat(DataFormatter::FORMAT_TITLE);
        }

        $teaserFormat = $contentProperties->getContentTeaserFormat();
        if (!$teaserFormat && $modelTable->hasDataFormat(DataFormatter::FORMAT_TEASER)) {
            $teaserFormat = $modelTable->getDataFormat(DataFormatter::FORMAT_TEASER);
        }

        $imageFormat = $contentProperties->getContentImageFormat();
        if (!$imageFormat && $modelTable->hasDataFormat(DataFormatter::FORMAT_IMAGE)) {
            $imageFormat = $modelTable->getDataFormat(DataFormatter::FORMAT_IMAGE);
        }

        $dateFormat = $contentProperties->getContentDateFormat();
        if (!$dateFormat && $modelTable->hasDataFormat(DataFormatter::FORMAT_DATE)) {
            $dateFormat = $modelTable->getDataFormat(DataFormatter::FORMAT_DATE);
        }

        try {
            $mapper = $this->getContentMapper($this->model->getName());
        } catch (Exception $e) {
            $this->dependencyInjector->get('pallo\\library\\log\\Log')->logException($e);

            $nodeModel = $this->dependencyInjector->get('pallo\\library\\cms\\node\\NodeModel');

            $mapper = new OrmContentMapper($nodeModel, $this->model, $this->dataFormatter);
        }

        $type = $this->model->getName();
        foreach ($result as $index => $data) {
            $title = $this->dataFormatter->formatData($data, $titleFormat);
            $url = null;
            $teaser = null;
            $image = null;
            $date = null;

            if ($teaserFormat) {
                $teaser = $this->dataFormatter->formatData($data, $teaserFormat);
            }

//             if ($data instanceof MediaItem) {
//                 $image = $data->getImage($this->zibo);
//             } elseif ($imageFormat) {
            if ($imageFormat) {
                $image = $this->dataFormatter->formatData($data, $imageFormat);
            }

            if ($dateFormat) {
                $date = $this->dataFormatter->formatData($data, $dateFormat);
            }

            if ($mapper) {
                $url = $mapper->getUrl($node->getRootNodeId(), $this->locale, $data);
            }

            $content = new Content($type, $title, $url, $teaser, $image, $date, $data);

            $result[$index] = $content;
        }

        return $result;
    }

    /**
     * Creates the model query from the provided properties
     * @param zibo\library\orm\model\Model $model
     * @param joppa\orm\model\ContentProperties $contentProperties
     * @param string $locale Code of the locale
     * @param integer $page Page number
     * @param array $arguments Arguments for the condition
     * @return zibo\library\orm\query\ModelQuery
     */
    public function getModelQuery(ContentProperties $contentProperties, $locale, $page = 1, array $arguments = null) {
        $includeUnlocalizedData = $contentProperties->getIncludeUnlocalized();

        $query = $this->model->createQuery($locale);
        $query->setRecursiveDepth($contentProperties->getRecursiveDepth());
        $query->setFetchUnlocalizedData($includeUnlocalizedData);

        $modelFields = $contentProperties->getModelFields();
        if ($modelFields) {
            foreach ($modelFields as $fieldName) {
                $query->addFields('{' . $fieldName . '}');
            }
        }

        $condition = $contentProperties->getCondition();
        if ($condition) {
            if ($arguments) {
                $query->addConditionWithVariables($condition, $arguments);
            } else {
                $query->addCondition($condition);
            }
        }

        $order = $contentProperties->getOrder();
        if ($order) {
            $query->addOrderBy($order);
        }

        if ($contentProperties->isPaginationEnabled()) {
            $paginationOffset = $contentProperties->getPaginationOffset();

            $rows = $contentProperties->getPaginationRows();
            $offset = ($page - 1) * $rows;

            if ($paginationOffset) {
                $offset += $paginationOffset;
            }

            $query->setLimit((integer) $rows, (integer) $offset);
        }

        return $query;
    }

    /**
     * Gets the callback for the properties action
     * @return null|callback Null if the widget does not implement a properties
     * action, a callback for the action otherwise
     */
    public function getPropertiesCallback() {
        return array($this, 'propertiesAction');
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

        $preview = $translator->translate('label.model') . ': ' . $modelName . '<br />';

        $fields = $contentProperties->getModelFields();
        if ($fields) {
            $preview .= $translator->translate('label.fields') . ': ' . implode(', ', $fields) . '<br />';
        }

        $preview .= $translator->translate('label.depth.recursive') . ': ' . $contentProperties->getRecursiveDepth() . '<br />';

        $includeUnlocalized = $contentProperties->getIncludeUnlocalized();
        if ($includeUnlocalized) {
            $preview .= $translator->translate('label.unlocalized') . ': ' . $translator->translate('label.yes') . '<br />';
        } else {
            $preview .= $translator->translate('label.unlocalized') . ': ' . $translator->translate('label.no') . '<br />';
        }

        $condition = $contentProperties->getCondition();
        if ($condition) {
            $preview .= $translator->translate('label.condition') . ': ' . $condition . '<br />';
        }

        $order = $contentProperties->getOrder();
        if ($order) {
            $preview .= $translator->translate('label.order') . ': ' . $order . '<br />';
        }

        if ($contentProperties->isPaginationEnabled()) {
            $parameters = array(
                'rows' => $contentProperties->getPaginationRows(),
                'offset' => $contentProperties->getPaginationOffset(),
            );

            $preview .= $translator->translate('label.pagination', $parameters) . '<br />';
        }

        $view = $contentProperties->getView();
        if ($view) {
            $preview .= $translator->translate('label.view') . ': ' . $view . '<br />';
        }

        return $preview;
    }

    /**
     * Action to show and edit the properties of this widget
     * @return null
     */
    public function propertiesAction(NodeModel $nodeModel, FieldService $fieldService) {
        $contentProperties = $this->getContentProperties();
        $translator = $this->getTranslator();
        $views = $this->dependencyInjector->getAll('pallo\\web\\cms\\view\\widget\\ContentOverviewView');

        $node = $this->properties->getNode();
        $rootNodeId = $node->getRootNodeId();
        $rootNode = $nodeModel->getNode($rootNodeId, null, true);
        $nodeList = $nodeModel->getListFromNodes(array($rootNode), $this->locale);
        $nodeOptions = array($rootNode->getId() => '/' . $rootNode->getName($this->locale)) + $nodeList;

        $component = new ContentOverviewComponent($fieldService);
        $component->setNodeOptions($nodeOptions);
        $component->setViews($views);

        $form = $this->buildForm($component, $contentProperties);
        if ($form->isSubmitted($this->request)) {
            if ($this->request->getBodyParameter('cancel')) {
                return false;
            }

            try {
                $form->validate();

                $contentProperties = $form->getData();
                $contentProperties->setToWidgetProperties($this->properties, $this->locale);

                return true;
            } catch (ValidationException $exception) {

            }
        }

        $selectFieldsAction = $this->getUrl('cms.ajax.orm.fields.select', array('model' => '%model%'));
        $orderFieldsAction = $this->getUrl('cms.ajax.orm.fields.order', array('model' => '%model%', 'recursiveDepth' => '%recursiveDepth%'));

        $view = $this->setTemplateView('cms/widget/orm/properties.overview', array(
        	'form' => $form->getView(),
        ));
        $view->addJavascript('js/cms/orm.js');
        $view->addInlineJavascript('joppaContentInitializeOverviewProperties("' . $selectFieldsAction . '", "' . $orderFieldsAction . '");');

        return false;
    }

    /**
     * Gets the properties
     * @return pallo\web\cms\orm\ContentProperties
     */
    private function getContentProperties() {
        $contentProperties = new ContentProperties();
        $contentProperties->getFromWidgetProperties($this->properties, $this->locale);

        return $contentProperties;
    }

}