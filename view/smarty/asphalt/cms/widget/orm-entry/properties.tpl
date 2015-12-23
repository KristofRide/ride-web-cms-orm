{include file="base/form.prototype"}

<form id="{$form->getId()}" class="form-horizontal" action="{$app.url.request}" method="POST" role="form">
    <div class="form__group">
        <div class="tabbable">
            <ul class="tabs">
                <li class="tabs__tab active"><a href="#tabQuery" data-toggle="tab">{translate key="title.query"}</a></li>
                <li class="tabs__tab"><a href="#tabParameters" data-toggle="tab">{translate key="title.parameters.url"}</a></li>
                <li class="tabs__tab"><a href="#tabMapper" data-toggle="tab">{translate key="title.content.mapper"}</a></li>
                <li class="tabs__tab"><a href="#tabMeta" data-toggle="tab">{translate key="title.node.meta"}</a></li>
                <li class="tabs__tab"><a href="#tabView" data-toggle="tab">{translate key="title.view"}</a></li>
            </ul>

            <div class="tabs__content">
                <div id="tabQuery" class="tabs__pane active">
                    {call formRow form=$form row="model"}
                    {call formRow form=$form row="field-id"}
                    {call formRow form=$form row="include-unlocalized"}
                </div>

                <div id="tabParameters" class="tabs__pane">
                    {call formRow form=$form row="parameters-none"}
                </div>

                <div id="tabMapper" class="tabs__pane">
                    {call formRow form=$form row="primary"}
                </div>

                <div id="tabMeta" class="tabs__pane">
                    {call formRow form=$form row="meta-og"}
                    {call formRow form=$form row="format-title-og"}
                    {call formRow form=$form row="format-teaser-og"}
                    {call formRow form=$form row="format-image-og"}
                </div>

                <div id="tabView" class="tabs__pane">
                    {call formRow form=$form row="template"}
                    {call formRow form=$form row="view-processor"}
                    {call formRow form=$form row="title"}

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
