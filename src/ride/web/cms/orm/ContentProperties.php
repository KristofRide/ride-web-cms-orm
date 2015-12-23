<?php

namespace ride\web\cms\orm;

use ride\library\orm\query\ModelQuery;
use ride\library\widget\WidgetProperties;

/**
 * Data container for the properties of a content widget
 */
class ContentProperties {

    /**
     * Name of the model name setting
     * @var string
     */
    const PROPERTY_MODEL_NAME = 'model';

    /**
     * Name of the model fields setting
     * @var string
     */
    const PROPERTY_MODEL_FIELDS = 'fields';

    /**
     * Name of the model fields setting
     * @var string
     */
    const PROPERTY_ENTRY = 'entries';

    /**
     * Name of the recursive depth setting
     * @var string
     */
    const PROPERTY_RECURSIVE_DEPTH = 'depth';

    /**
     * Name of the include unlocalized setting
     * @var string
     */
    const PROPERTY_INCLUDE_UNLOCALIZED = 'include.unlocalized';

    /**
     * Name of the condition setting
     * @var string
     */
    const PROPERTY_CONDITION = 'condition';

    /**
     * Name of the order setting
     * @var string
     */
    const PROPERTY_ORDER = 'order';

    /**
     * Name of the pagination enabled setting
     * @var string
     */
    const PROPERTY_PAGINATION_ENABLE = 'pagination.enable';

    /**
     * Name of the pagination rows setting
     * @var string
     */
    const PROPERTY_PAGINATION_ROWS = 'pagination.rows';

    /**
     * Name of the pagination offset setting
     * @var string
     */
    const PROPERTY_PAGINATION_OFFSET = 'pagination.offset';

    /**
     * Name of the pagination show setting
     * @var string
     */
    const PROPERTY_PAGINATION_SHOW = 'pagination.show';

    /**
     * Name of the pagination ajax setting
     * @var string
     */
    const PROPERTY_PAGINATION_AJAX = 'pagination.ajax';

    /**
     * Name of the more enabled setting
     * @var string
     */
    const PROPERTY_MORE_SHOW = 'more.show';

    /**
     * Name of the more node setting
     * @var string
     */
    const PROPERTY_MORE_NODE = 'more.node';

    /**
     * Name of the more label setting
     * @var string
     */
    const PROPERTY_MORE_LABEL = 'more.label';

    /**
     * Name of the parameters type setting
     * @var string
     */
    const PROPERTY_PARAMETERS = 'parameters';

    /**
     * Name of the no parameters action
     * @var string
     */
    const PROPERTY_PARAMETERS_NONE = 'parameters.none';

    /**
     * Name of the id field setting
     * @var string
     */
    const PROPERTY_ID_FIELD = 'field.id';

    /**
     * Name of the primary flag setting
     * @var string
     */
    const PROPERTY_PRIMARY = 'primary';

    /**
     * Name of the content mapper setting
     * @var string
     */
    const PROPERTY_MAPPER = 'mapper';

    /**
     * Name of the search setting
     * @var string
     */
    const PROPERTY_SEARCH = 'search';

    /**
     * Name of the filters field setting
     * @var string
     */
    const PROPERTY_FILTERS = 'filters';

    /**
     * Name of the template setting
     * @var string
     */
    const PROPERTY_TEMPLATE = 'template';

    /**
     * Name of the template setting
     * @var string
     */
    const PROPERTY_VIEW_PROCESSOR = 'view.processor';

    /**
     * Name of the title format setting
     * @var string
     */
    const PROPERTY_FORMAT_TITLE = 'format.title';

    /**
     * Name of the teaser format setting
     * @var string
     */
    const PROPERTY_FORMAT_TEASER = 'format.teaser';

    /**
     * Name of the image format setting
     * @var string
     */
    const PROPERTY_FORMAT_IMAGE = 'format.image';

    /**
     * Name of the date format setting
     * @var string
     */
    const PROPERTY_FORMAT_DATE = 'format.date';

    /**
     * Name of the og title format setting
     * @var string
     */
    const PROPERTY_FORMAT_TITLE_OG = 'format.title.og';

    /**
     * Name of the og teaser format setting
     * @var string
     */
    const PROPERTY_FORMAT_TEASER_OG = 'format.teaser.og';

    /**
     * Name of the og image format setting
     * @var string
     */
    const PROPERTY_FORMAT_IMAGE_OG = 'format.image.og';

    /**
     * Name of the title setting
     * @var string
     */
    const PROPERTY_TITLE = 'title';

    /**
     * Name of the meta og setting
     * @var string
     */
    const PROPERTY_META_OG = 'meta.og';

    /**
     * Name of the empty result view setting
     * @var string
     */
    const PROPERTY_EMPTY_RESULT_VIEW = 'view.result.empty';

    /**
     * Name of the empty result message setting
     * @var string
     */
    const PROPERTY_EMPTY_RESULT_MESSAGE = 'message.result.empty';

    /**
     * Name of the add to breadcrumb setting
     * @var string
     */
    const PROPERTY_BREADCRUMB = 'breadcrumb';

    /**
     * Separator a list property
     * @var string
     */
    const SEPARATOR = ',';

    /**
     * 404 no parameters action
     * @var string
     */
    const NONE_404 = '404';

    /**
     * Ignore no parameters action
     * @var string
     */
    const NONE_IGNORE = 'ignore';

    /**
     * Ignore no parameters action
     * @var string
     */
    const NONE_RENDER = 'render';

    /**
     * Predefined view type
     * @var string
     */
    const VIEW_TYPE_PREDEFINED = 'predefined';

    /**
     * Custom view type
     * @var string
     */
    const VIEW_TYPE_CUSTOM = 'custom';

    /**
     * Name of the model to query
     * @var string
     */
    private $modelName;

    /**
     * Array with the fields to select, null to select all
     * @var array
     */
    private $modelFields;

    /**
     * Id's of the entries to select
     * @var array
     */
    private $entriesId;

    /**
     * Recursive depth for the relations of the model
     * @var integer
     */
    private $recursiveDepth;

    /**
     * Include unlocalized data flag for the query
     * @var string
     */
    private $includeUnlocalized;

    /**
     * Expression for the condition
     * @var string
     */
    private $condition;

    /**
     * Flag to see if a search query is exposed
     * @var boolean
     */
    private $hasSearch;

    /**
     * Exposed filter fields
     * @var array
     */
    private $filters;

    /**
     * Expression for the order by
     * @var string
     */
    private $order;

    /**
     * Flag to see if pagination is enabled
     * @var boolean
     */
    private $isPaginationEnabled;

    /**
     * Number of rows per page
     * @var integer
     */
    private $paginationRows;

    /**
     * Offset for the pagination
     * @var integer
     */
    private $paginationOffset;

    /**
     * Flag to see if the pagination should be showed
     * @var boolean
     */
    private $showPagination;

    /**
     * Flag to see if the pagination should be done with ajax
     * @var boolean
     */
    private $useAjaxForPagination;

    /**
     * Flag to see if the more link shouls be showed
     * @var boolean
     */
    private $showMore;

    /**
     * Node to link to for the more link
     * @var integer
     */
    private $moreNode;

    /**
     * Label for the more link
     * @var string
     */
    private $moreLabel;

    /**
     * An array with parameter names for named parameters, an integer for
     * numeric parameters, null otherwise
     * @var null|integer|array
     */
    private $parameters;

    /**
     * Name of the no parameters action
     * @var string
     */
    private $parametersNone;

    /**
     * Name of the id field for the detail
     * @var string
     */
    private $idField;

    /**
     * Flag to see if this detail widget is the primary content mapper
     * @var string
     */
    private $isPrimaryMapper;

    /**
     * Id of the content mapper to use
     * @var string
     */
    private $contentMapper;

    /**
     * Relative path to the template resource
     * @var string
     */
    private $template;

    /**
     * Id of the view processor
     * @var string
     */
    private $viewProcessor;

    /**
     * Format of the title
     * @var string
     */
    private $contentTitleFormat;

    /**
     * Format of the teaser
     * @var string
     */
    private $contentTeaserFormat;

    /**
     * Format of the image
     * @var string
     */
    private $contentImageFormat;

    /**
     * Format of the date
     * @var string
     */
    private $contentDateFormat;

    /**
     * Title for the view
     * @var string
     */
    private $title;

    /**
     * Return a view when the result is empty
     * @var boolean
     */
    private $emptyResultView;

    /**
     * Message when the result is empty
     * @var string
     */
    private $emptyResultMessage;

    /**
     * Flag to see if og meta should be set
     * @var boolean
     */
    private $metaOg;

    /**
     * Format of the title for the og meta
     * @var string
     */
    private $ogTitleFormat;

    /**
     * Format of the teaser for the og meta
     * @var string
     */
    private $ogTeaserFormat;

    /**
     * Format of the image for the of meta
     * @var string
     */
    private $ogImageFormat;

    /**
     * Flag to see if this should be added to the breadcrumb
     * @var boolean
     */
    private $breadcrumb;

    /**
     * Sets the model name
     * @param string $modelName
     * @return null
     */
    public function setModelName($modelName) {
        $this->modelName = $modelName;
    }

    /**
     * Gets the model name
     * @return string
     */
    public function getModelName() {
        return $this->modelName;
    }

    /**
     * Sets the model fields
     * @param array $fields Array with the name of the field as value;
     * @return null
     */
    public function setModelFields(array $fields = null) {
        $this->modelFields = $fields;
    }

    /**
     * Gets the model fields
     * @return array Array with the name of the field as value;
     */
    public function getModelFields() {
        return $this->modelFields;
    }

    /**
     * Sets the entries to show
     * @param integer $entryId Id of the entry
     * @return null
     */
    public function setEntriesId(array $entriesId) {
        $this->entriesId = implode(",", $entriesId);
    }

    /**
     * Gets the entries to show
     * @return array with id of the entries
     */
    public function getEntriesId() {
        $ids = explode(",", $this->entriesId);
        $resultArray = array();
        foreach ($ids as $id) {
            $resultArray[$id] = $id;
        }
        return $resultArray;
    }

    /**
     * Sets the recursive depth for the query
     * @param integer $recursiveDepth
     * @return null
     */
    public function setRecursiveDepth($recursiveDepth) {
        $this->recursiveDepth = $recursiveDepth;
    }

    /**
     * Gets the recursive depth for the query
     * @return integer
     */
    public function getRecursiveDepth() {
        return $this->recursiveDepth;
    }

    /**
     * Sets the include unlocalized flag for the query
     * @param string $includeUnlocalized
     * @return null
     */
    public function setIncludeUnlocalized($includeUnlocalized) {
        $this->includeUnlocalized = $includeUnlocalized;
    }

    /**
     * Gets the include unlocalized flag for the query
     * @return string
     */
    public function getIncludeUnlocalized() {
        return $this->includeUnlocalized;
    }

    /**
     * Sets the expression for the condition part of the query
     * @param string $expression Condition expression
     * @return null
     */
    public function setCondition($expression) {
        $this->condition = $expression;
    }

    /**
     * Gets the expression for the condition part of the query
     * @return string Condition expression
     */
    public function getCondition() {
        return $this->condition;
    }

    /**
     * Sets whether a search query is exposed
     * @param boolean $hasSearch
     * @return null
     */
    public function setHasSearch($hasSearch) {
        $this->hasSearch = $hasSearch;
    }

    /**
     * Gets whether a search query is exposed
     * @return boolean
     */
    public function hasSearch() {
        return $this->hasSearch;
    }

    /**
     * Sets the filters for the condition part of the query
     * @param string|array $filters
     * @return null
     */
    public function setFilters($filters) {
        $this->filters = $filters;
    }

    /**
     * Gets the filters for the condition part of the query
     * @return array
     */
    public function getFilters() {
        return $this->filters;
    }

    /**
     * Sets the expression for the order part of the query
     * @param string $expression Order expression
     * @return null
     */
    public function setOrder($expression) {
        $this->order = $expression;
    }

    /**
     * Gets the expression for the order part of the query
     * @return string Order expression
     */
    public function getOrder() {
        return $this->order;
    }

    /**
     * Sets if the pagination is enabled
     * @param boolean $flag True to enable the pagination, false otherwise
     * @return null
     */
    public function setIsPaginationEnabled($flag) {
        $this->isPaginationEnabled = $flag;
    }

    /**
     * Gets if the pagination is enabled
     * @return boolean True to enable the pagination, false otherwise
     */
    public function isPaginationEnabled() {
        return $this->isPaginationEnabled ? true : false;
    }

    /**
     * Sets the number of rows per page
     * @param integer $rows
     * @return null
     */
    public function setPaginationRows($rows) {
        $this->paginationRows = $rows;
    }

    /**
     * Gets the number of rows per page
     * @return integer
     */
    public function getPaginationRows() {
        return $this->paginationRows;
    }

    /**
     * Sets the offset for the pagination
     * @param integer $offset
     * @return null
     */
    public function setPaginationOffset($offset) {
        $this->paginationOffset = $offset;
    }

    /**
     * Gets the offset of the pagination
     * @return integer
     */
    public function getPaginationOffset() {
        return $this->paginationOffset;
    }

    /**
     * Sets the flag to show the pagination
     * @param boolean $flag
     * @return null
     */
    public function setWillShowPagination($flag) {
        $this->showPagination = $flag;
    }

    /**
     * Gets the flag to show the pagination
     * @return boolean
     */
    public function willShowPagination() {
        return $this->showPagination ? true : false;
    }

    /**
     * Sets the flag to use ajax for the pagination
     * @param boolean $flag
     * @return null
     */
    public function setUseAjaxForPagination($flag) {
        $this->useAjaxForPagination = $flag;
    }

    /**
     * Gets the flag to show the pagination
     * @return boolean
     */
    public function useAjaxForPagination() {
        return $this->useAjaxForPagination ? true : false;
    }

    /**
     * Sets the flag to show the more link
     * @param boolean $flag
     * @return null
     */
    public function setWillShowMoreLink($flag) {
        $this->showMore = $flag;
    }

    /**
     * Gets the flag to show the more link
     * @return boolean
     */
    public function willShowMoreLink() {
        return $this->showMore ? true : false;
    }

    /**
     * Sets the id of the node for the more link
     * @param integer $node
     * @return null
     */
    public function setMoreNode($node) {
        $this->moreNode = $node;
    }

    /**
     * Gets the id of the node for the more link
     * @return integer
     */
    public function getMoreNode() {
        return $this->moreNode;
    }

    /**
     * Sets the label for the more link
     * @param string $label
     * @return null
     */
    public function setMoreLabel($label) {
        $this->moreLabel = $label;
    }

    /**
     * Gets the label for the more link
     * @return string
     */
    public function getMoreLabel() {
        return !$this->moreLabel ? 'more ...' : $this->moreLabel;
    }

    /**
     * Sets the parameters type
     * @param boolean|integer|array $parameters An array with parameter names
     * for named parameters, an integer for numeric parameters, false otherwise
     * @return null
     */
    public function setParameters($parameters) {
        $this->parameters = $parameters;
    }

    /**
     * Gets the parameters type
     * @preturn boolean|integer|array An array with parameter names for named
     * parameters, an integer for numeric parameters, false otherwise
     */
    public function getParameters() {
        return $this->parameters;
    }

    /**
     * Sets the no parameters action
     * @param string $action
     * @return null
     */
    public function setNoParametersAction($action) {
        $this->parametersNone = $action;
    }

    /**
     * Gets the no parameters action
     * @return string
     */
    public function getNoParametersAction() {
        return $this->parametersNone;
    }

    /**
     * Set the name of the id field
     * @param string $idField
     * @return null
     */
    public function setIdField($idField) {
        $this->idField = $idField;
    }

    /**
     * Gets the name of the id field
     * @return string
     */
    public function getIdField() {
        return $this->idField;
    }

    /**
     * Sets the flag to see if detail widget should be resolved for the primary
     * content mapper
     * @param boolean $isPrimaryMapper
     * @return null
     */
    public function setIsPrimaryMapper($isPrimaryMapper) {
        $this->isPrimaryMapper = $isPrimaryMapper;
    }

    /**
     * Gets the flag to see if detail widget should be resolved for the primary
     * content mapper
     * @return boolean
     */
    public function isPrimaryMapper() {
        return $this->isPrimaryMapper;
    }

    /**
     * Sets the id of the content mapper
     * @param string $contentMapper Id of the content mapper
     * @return null
     */
    public function setContentMapper($contentMapper) {
        $this->contentMapper = $contentMapper;
    }

    /**
     * Gets the id of the content mapper
     * @return string
     */
    public function getContentMapper() {
        return $this->contentMapper;
    }

    /**
     * Sets the resource for the template
     * @param string $template Relative path to the template resource
     * @return null
     */
    public function setTemplate($template) {
        $this->template = $template;
    }

    /**
     * Gets the path of the template resource
     * @return string
     */
    public function getTemplate() {
        return $this->template;
    }

    /**
     * Sets the view processor
     * @param string $viewProcessor Id of the view processor
     * @return null
     */
    public function setViewProcessor($viewProcessor) {
        $this->viewProcessor = $viewProcessor;
    }

    /**
     * Gets the view processor
     * @return string
     */
    public function getViewProcessor() {
        return $this->viewProcessor;
    }

    /**
     * Sets the format for the teaser of the content
     * @param string $format
     * @return null
     */
    public function setContentTeaserFormat($format) {
        $this->contentTeaserFormat = $format;
    }

    /**
     * Gets the format for the title of the content
     * @return string
     */
    public function getContentTeaserFormat() {
        return $this->contentTeaserFormat;
    }

    /**
     * Sets the format for the title of the content
     * @param string $format
     * @return null
     */
    public function setContentTitleFormat($format) {
        $this->contentTitleFormat = $format;
    }

    /**
     * Gets the format for the title of the content
     * @return string
     */
    public function getContentTitleFormat() {
        return $this->contentTitleFormat;
    }

    /**
     * Sets the format for the image of the content
     * @param string $format
     * @return null
     */
    public function setContentImageFormat($format) {
        $this->contentImageFormat = $format;
    }

    /**
     * Gets the format for the image of the content
     * @return string
     */
    public function getContentImageFormat() {
        return $this->contentImageFormat;
    }

    /**
     * Sets the format for the date of the content
     * @param string $format
     * @return null
     */
    public function setContentDateFormat($format) {
        $this->contentDateFormat = $format;
    }

    /**
     * Gets the format for the date of the content
     * @return string
     */
    public function getContentDateFormat() {
        return $this->contentDateFormat;
    }

    /**
     * Sets the title for the view
     * @param string $title
     * @return null
     */
    public function setTitle($title) {
        $this->title = $title;
    }

    /**
     * Gets the title for the view
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Sets the whether the widget has an empty result
     * @param boolean $hasEmptyResultView
     * @return null
     */
    public function setHasEmptyResultView($hasEmptyResultView) {
        $this->emptyResultView = $hasEmptyResultView;
    }

    /**
     * Gets the whether the widget has an empty result view
     * @return boolean
     */
    public function hasEmptyResultView() {
        return $this->emptyResultView;
    }

    /**
     * Sets the message for an empty result
     * @param string $message
     * @return null
     */
    public function setEmptyResultMessage($message) {
        $this->emptyResultMessage = $message;
    }

    /**
     * Gets the message for an empty result
     * @return string
     */
    public function getEmptyResultMessage() {
        return $this->emptyResultMessage;
    }

    /**
     * Sets the flag to see if og meta should be added
     * @param boolean $ogMeta
     */
    public function setMetaOg($metaOg) {
        $this->metaOg = $metaOg;
    }

    /**
     * Gets the flag to see if og meta should be added
     * @return boolean
     */
    public function getMetaOg() {
        return $this->metaOg;
    }

    /**
     * Sets the format for the title of the og meta
     * @param string $format
     * @return null
     */
    public function setOgTitleFormat($format) {
        $this->ogTitleFormat = $format;
    }

    /**
     * Gets the format for the title of the og meta
     * @return string
     */
    public function getOgTitleFormat() {
        return $this->ogTitleFormat;
    }

    /**
     * Sets the format for the teaser of the og meta
     * @param string $format
     * @return null
     */
    public function setOgTeaserFormat($format) {
        $this->ogTeaserFormat = $format;
    }

    /**
     * Gets the format for the title of the og meta
     * @return string
     */
    public function getOgTeaserFormat() {
        return $this->ogTeaserFormat;
    }
    /**
     * Sets the format for the image of the og meta
     * @param string $format
     * @return null
     */
    public function setOgImageFormat($format) {
        $this->ogImageFormat = $format;
    }

    /**
     * Gets the format for the image of the og meta
     * @return string
     */
    public function getOgImageFormat() {
        return $this->ogImageFormat;
    }

    /**
     * Sets the flag to see if this should be added to breadcrumb
     * @param boolean $ogMeta
     */
    public function setBreadcrumb($breadcrumb) {
        $this->breadcrumb = $breadcrumb;
    }

    /**
     * Gets the flag to see if this should be added to breadcrumb
     * @return boolean
     */
    public function getBreadcrumb() {
        return $this->breadcrumb;
    }

    /**
     * Read the properties of the content from the widget properties
     * @param \ride\library\widget\WidgetProperties $properties
     * @return null
     * @todo remove default value for condition
     */
    public function getFromWidgetProperties(WidgetProperties $properties, $locale) {
        $this->modelName = $properties->getWidgetProperty(self::PROPERTY_MODEL_NAME);
        $this->entriesId = $properties->getWidgetProperty(self::PROPERTY_ENTRY);
        $this->recursiveDepth = $properties->getWidgetProperty(self::PROPERTY_RECURSIVE_DEPTH);
        $this->includeUnlocalized = $properties->getWidgetProperty(self::PROPERTY_INCLUDE_UNLOCALIZED);
        $this->isPaginationEnabled = $properties->getWidgetProperty(self::PROPERTY_PAGINATION_ENABLE);
        $this->paginationRows = $properties->getWidgetProperty(self::PROPERTY_PAGINATION_ROWS);
        $this->paginationOffset = $properties->getWidgetProperty(self::PROPERTY_PAGINATION_OFFSET);
        $this->hasSearch = $properties->getWidgetProperty(self::PROPERTY_SEARCH);
        $this->condition = $properties->getLocalizedWidgetProperty($locale, self::PROPERTY_CONDITION);
        $this->order = $properties->getWidgetProperty(self::PROPERTY_ORDER);
        $this->parameters = $properties->getWidgetProperty(self::PROPERTY_PARAMETERS);
        $this->parametersNone = $properties->getWidgetProperty(self::PROPERTY_PARAMETERS_NONE);
        $this->idField = $properties->getWidgetProperty(self::PROPERTY_ID_FIELD);
        $this->isPrimaryMapper = $properties->getWidgetProperty(self::PROPERTY_PRIMARY);
        $this->contentMapper = $properties->getWidgetProperty(self::PROPERTY_MAPPER);
        $this->template = $properties->getWidgetProperty(self::PROPERTY_TEMPLATE);
        $this->viewProcessor = $properties->getWidgetProperty(self::PROPERTY_VIEW_PROCESSOR);
        $this->contentTitleFormat = $properties->getWidgetProperty(self::PROPERTY_FORMAT_TITLE);
        $this->contentTeaserFormat = $properties->getWidgetProperty(self::PROPERTY_FORMAT_TEASER);
        $this->contentImageFormat = $properties->getWidgetProperty(self::PROPERTY_FORMAT_IMAGE);
        $this->contentDateFormat = $properties->getWidgetProperty(self::PROPERTY_FORMAT_DATE);
        $this->title = $properties->getLocalizedWidgetProperty($locale, self::PROPERTY_TITLE);
        $this->emptyResultView = $properties->getWidgetProperty(self::PROPERTY_EMPTY_RESULT_VIEW, true);
        $this->emptyResultMessage = $properties->getLocalizedWidgetProperty($locale, self::PROPERTY_EMPTY_RESULT_MESSAGE);
        $this->showPagination = $properties->getWidgetProperty(self::PROPERTY_PAGINATION_SHOW);
        $this->useAjaxForPagination = $properties->getWidgetProperty(self::PROPERTY_PAGINATION_AJAX);
        $this->showMore = $properties->getLocalizedWidgetProperty($locale, self::PROPERTY_MORE_SHOW);
        $this->moreLabel = $properties->getLocalizedWidgetProperty($locale, self::PROPERTY_MORE_LABEL);
        $this->moreNode = $properties->getLocalizedWidgetProperty($locale, self::PROPERTY_MORE_NODE);
        $this->metaOg = $properties->getWidgetProperty(self::PROPERTY_META_OG);
        $this->ogTitleFormat = $properties->getWidgetProperty(self::PROPERTY_FORMAT_TITLE_OG);
        $this->ogTeaserFormat = $properties->getWidgetProperty(self::PROPERTY_FORMAT_TEASER_OG);
        $this->ogImageFormat = $properties->getWidgetProperty(self::PROPERTY_FORMAT_IMAGE_OG);
        $this->breadcrumb = $properties->getWidgetProperty(self::PROPERTY_BREADCRUMB);

        if ($this->parameters && !is_numeric($this->parameters)) {
            $this->parameters = explode(self::SEPARATOR, $this->parameters);
        }

        $this->filters = array();

        $filters = $properties->getWidgetProperty(self::PROPERTY_FILTERS);
        if ($filters) {
            $filters = explode(self::SEPARATOR, $filters);
            foreach ($filters as $filter) {
                list($filterName, $filterType, $filterField) = explode(':', $filter);

                $this->filters[$filterName] = array('name' => $filterName, 'type' => $filterType, 'field' => $filterField);
            }
                }

        $fieldsString = $properties->getWidgetProperty(self::PROPERTY_MODEL_FIELDS);
        if (!$fieldsString) {
            $this->modelFields = null;

            return;
        }

        $this->modelFields = array();

        $tokens = explode(self::SEPARATOR, $fieldsString);
        foreach ($tokens as $token) {
            $fieldName = trim($token);

            $this->modelFields[$fieldName] = $fieldName;
        }
    }

    /**
     * Write the properties of the content to the widget properties
     * @param \ride\library\widget\WidgetSettings $properties
     * @return null
     */
    public function setToWidgetProperties(WidgetProperties $properties, $locale) {
        $fields = null;
        if ($this->modelFields) {
            $fields = implode(self::SEPARATOR, $this->modelFields);
        }

        $properties->setWidgetProperty(self::PROPERTY_MODEL_NAME, $this->modelName);
        $properties->setWidgetProperty(self::PROPERTY_ENTRY, $this->entriesId);
        $properties->setWidgetProperty(self::PROPERTY_MODEL_FIELDS, $fields);
        $properties->setWidgetProperty(self::PROPERTY_RECURSIVE_DEPTH, $this->recursiveDepth);
        $properties->setWidgetProperty(self::PROPERTY_INCLUDE_UNLOCALIZED, $this->includeUnlocalized);
        $properties->setWidgetProperty(self::PROPERTY_SEARCH, $this->hasSearch ? '1' : '0');
        $properties->setLocalizedWidgetProperty($locale, self::PROPERTY_CONDITION, $this->condition);
        $properties->setWidgetProperty(self::PROPERTY_ORDER, $this->order);
        $properties->setWidgetProperty(self::PROPERTY_PAGINATION_ENABLE, $this->isPaginationEnabled);
        if ($this->isPaginationEnabled) {
            $properties->setWidgetProperty(self::PROPERTY_PAGINATION_ROWS, $this->paginationRows);
            $properties->setWidgetProperty(self::PROPERTY_PAGINATION_OFFSET, $this->paginationOffset);
            $properties->setWidgetProperty(self::PROPERTY_PAGINATION_SHOW, $this->showPagination);
            $properties->setWidgetProperty(self::PROPERTY_PAGINATION_AJAX, $this->useAjaxForPagination);
            if ($this->showMore) {
                $properties->setLocalizedWidgetProperty($locale, self::PROPERTY_MORE_SHOW, $this->showMore);
                $properties->setLocalizedWidgetProperty($locale, self::PROPERTY_MORE_LABEL, $this->moreLabel);
                $properties->setLocalizedWidgetProperty($locale, self::PROPERTY_MORE_NODE, $this->moreNode);
            } else {
                $properties->setLocalizedWidgetProperty($locale, self::PROPERTY_MORE_SHOW, null);
                $properties->setLocalizedWidgetProperty($locale, self::PROPERTY_MORE_LABEL, null);
                $properties->setLocalizedWidgetProperty($locale, self::PROPERTY_MORE_NODE, null);
            }
        } else {
            $properties->setWidgetProperty(self::PROPERTY_PAGINATION_ROWS, null);
            $properties->setWidgetProperty(self::PROPERTY_PAGINATION_OFFSET, null);
            $properties->setWidgetProperty(self::PROPERTY_PAGINATION_SHOW, null);
            $properties->setWidgetProperty(self::PROPERTY_PAGINATION_AJAX, null);
            $properties->setLocalizedWidgetProperty($locale, self::PROPERTY_MORE_SHOW, null);
            $properties->setLocalizedWidgetProperty($locale, self::PROPERTY_MORE_LABEL, null);
            $properties->setLocalizedWidgetProperty($locale, self::PROPERTY_MORE_NODE, null);
        }

        $properties->setWidgetProperty(self::PROPERTY_ID_FIELD, $this->idField);
        $properties->setWidgetProperty(self::PROPERTY_PRIMARY, $this->isPrimaryMapper);
        $properties->setWidgetProperty(self::PROPERTY_MAPPER, $this->contentMapper);
        $properties->setWidgetProperty(self::PROPERTY_TEMPLATE, $this->template);
        $properties->setWidgetProperty(self::PROPERTY_VIEW_PROCESSOR, $this->viewProcessor);
        $properties->setWidgetProperty(self::PROPERTY_FORMAT_TITLE, $this->contentTitleFormat);
        $properties->setWidgetProperty(self::PROPERTY_FORMAT_TEASER, $this->contentTeaserFormat);
        $properties->setWidgetProperty(self::PROPERTY_FORMAT_IMAGE, $this->contentImageFormat);
        $properties->setWidgetProperty(self::PROPERTY_FORMAT_DATE, $this->contentDateFormat);
        $properties->setLocalizedWidgetProperty($locale, self::PROPERTY_TITLE, $this->title);
        $properties->setWidgetProperty(self::PROPERTY_EMPTY_RESULT_VIEW, $this->emptyResultView ? '1' : '0');
        $properties->setLocalizedWidgetProperty($locale, self::PROPERTY_EMPTY_RESULT_MESSAGE, $this->emptyResultMessage);
        $properties->setWidgetProperty(self::PROPERTY_META_OG, $this->metaOg);
        $properties->setWidgetProperty(self::PROPERTY_FORMAT_TITLE_OG, $this->ogTitleFormat);
        $properties->setWidgetProperty(self::PROPERTY_FORMAT_TEASER_OG, $this->ogTeaserFormat);
        $properties->setWidgetProperty(self::PROPERTY_FORMAT_IMAGE_OG, $this->ogImageFormat);
        $properties->setWidgetProperty(self::PROPERTY_BREADCRUMB, $this->breadcrumb ? '1' : '0');
        
        $parameters = $this->parameters;
        if ($parameters) {
            if (is_array($parameters)) {
                $parameters = implode(self::SEPARATOR, $parameters);
            }

            $properties->setWidgetProperty(self::PROPERTY_PARAMETERS, $parameters);
        } else {
            $properties->setWidgetProperty(self::PROPERTY_PARAMETERS, null);
        }

        $properties->setWidgetProperty(self::PROPERTY_PARAMETERS_NONE, $this->parametersNone);

        $filters = $this->filters;
        if (is_array($filters)) {
            $filterValues = array();
            foreach ($filters as $filter) {
                $filterValues[] = $filter['name'] . ':' . $filter['type'] . ':' . $filter['field'];
            }

            $properties->setWidgetProperty(self::PROPERTY_FILTERS, implode(self::SEPARATOR, $filterValues));
        } else {
            $properties->setWidgetProperty(self::PROPERTY_FILTERS, null);
        }
    }

}
