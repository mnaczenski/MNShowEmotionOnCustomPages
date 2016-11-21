{extends file="parent:frontend/custom/index.tpl"}


{block name="frontend_index_content" prepend}
    {if $showshoppageemotion == "showshoppageemotiony"}
        {include file='plugins/MNShowEmotionOnCustomPages/show_shoppages_emotions.tpl'}
    {/if}
{/block}