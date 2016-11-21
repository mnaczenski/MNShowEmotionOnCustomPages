{extends file="parent:frontend/blog/detail.tpl"}


{block name='frontend_index_content' prepend}
    {if $showblogemotion == "showblogemotiony"}
        {include file='plugins/MNShowEmotionOnCustomPages/show_blog_detail_emotions.tpl'}
    {/if}
{/block}