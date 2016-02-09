{include file="base/form.prototype"}

<form id="{$form->getId()}" class="form-horizontal form--selectize" action="{$app.url.request}" method="POST" role="form">
    <div class="form__group">
        <div class="tabbable">
            <ul class="tabs">
                <li class="tabs__tab active"><a href="#tabQuery" data-toggle="tab">{translate key="title.query"}</a></li>
                <li class="tabs__tab"><a href="#tabView" data-toggle="tab">{translate key="title.view"}</a></li>
            </ul>

            <div class="tabs__content">
                <div id="tabQuery" class="tabs__pane active">
                    {call formRow form=$form row="model"}
                    {call formRow form=$form row="entries"}

                    {call formRow form=$form row="maximum"}
                    {call formRow form=$form row="condition"}
                    {call formRow form=$form row="include-unlocalized"}
                </div>

                <div id="tabView" class="tabs__pane">
                    {call formRow form=$form row="template"}
                    {call formRow form=$form row="view-processor"}
                    {call formRow form=$form row="title"}
                    {call formRow form=$form row="titleString"}
                    {call formRow form=$form row="breadcrumb"}

                    <h4>{translate key="title.formats.data"}</h4>

                    {call formRow form=$form row="format-title"}
                    {call formRow form=$form row="format-teaser"}
                    {call formRow form=$form row="format-image"}
                    {call formRow form=$form row="format-date"}
                </div>
            </div>
        </div>

        <div class="form__actions">
            <button type="submit" class="btn btn--default">{translate key="button.save"}</button>
            <button type="submit" name="cancel" class="btn btn--link">{translate key="button.cancel"}</button>
        </div>
    </div>
</form>
