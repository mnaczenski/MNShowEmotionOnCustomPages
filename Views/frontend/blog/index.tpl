{extends file="parent:frontend/blog/index.tpl"}


{block name='frontend_index_content' prepend}
    {if $showblogemotion == "showblogemotiony"}
        {include file='plugins/MNShowEmotionOnCustomPages/show_blog_emotions.tpl'}
    {/if}
{/block}