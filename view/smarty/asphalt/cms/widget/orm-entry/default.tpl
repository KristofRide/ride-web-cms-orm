{* widget: orm.entry action: index; translation: template.orm.entry.block *}

<div class="widget widget-content-overview widget-content-entry-block {$app.cms.properties->getWidgetProperty('style.container')}" id="widget-{$app.cms.widget}">

{if $result}

    {foreach from=$result item="content"}
    <div class="content clearfix {cycle values="odd,even"}">
        
        <h3>{if $content->url}<a href="{$content->url}">{$content->title}</a>{else}{$content->title}{/if}</h3>
        <div class="teaser">{$content->teaser}</div>
    </div>
    {/foreach}
{/if}
</div>
