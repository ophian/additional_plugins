
<div class="serendipity_mediainsert_gallery">

{foreach $plugin_mediainsert_media AS $medium}

 {if isset($plugin_mediainsert_hideafter) AND isset($plugin_mediainsert_picperrow) AND $medium@iteration <= $plugin_mediainsert_hideafter}
  {if !$medium@first AND $plugin_mediainsert_picperrow > 0 AND $medium@index % $plugin_mediainsert_picperrow == 0}
  <div style="clear:both">&nbsp;</div>
  {/if}
 {/if}
 {if isset($plugin_mediainsert_hideafter) AND $medium@iteration > $plugin_mediainsert_hideafter}
  <div class="serendipity_imageComment_left" style="width: 0px; height: 0px; display: none">
 {else}
  <div class="serendipity_imageComment_left" style="width: {$medium.thumbwidth}px">
 {/if}
      <div class="serendipity_imageComment_img">
      <a class="serendipity_image_link" href="{$serendipityHTTPPath}uploads/{$medium.path}{$medium.realname}">
       <!-- s9ymdb:{$medium.id} -->
        <img width="{$medium.thumbwidth}" height="{$medium.thumbheight}" src="{$serendipityHTTPPath}uploads/{$medium.path}{$medium.name}.{$medium.thumbnail_name}.{$medium.extension}" />
      </a>
      </div>
      <div class="serendipity_imageComment_txt">{$medium.comment1}</div>
  </div>
{/foreach}

</div>
