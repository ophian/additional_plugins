{if !isset($plugin_usergallery_uselightbox) || $plugin_usergallery_uselightbox === false}{* Is affordable, when usergallery NOT uses lightbox !! *}
<script type="text/javascript">
    <!--
    {literal}
    function popImage(file_avif,file_webp,file_name,file_title,file_width,file_height) {
        if (parseInt(navigator.appVersion.charAt(0)) >= 4) {
            var optBrowser='scrollbars=yes,width='+file_width+',height='+file_height+',toolbar=no,menubar=no,location=no,resize=1,resizable=0';
            var imgWin=window.open('about:blank','',optBrowser);
            with (imgWin.document) {
                writeln('<html><head><title>Loading...</title>');
                writeln('<style>html{width:100vw}body{margin:0;padding:0;text-align:center;scrollbar-gutter:stable both-edges;overflow-x:hidden}img{border:0px}</style>');
                writeln('</head>');
                writeln('<sc'+'ript>');
                writeln('function doTitle(){document.title="'+file_title+'";}');
                writeln('</sc'+'ript>');
                writeln('<body onload="self.focus();doTitle()">');
                writeln('<a href="javascript:window.close()"><picture><source srcset="'+file_avif+'" type="image/avif"><source srcset="'+file_webp+'" type="image/webp"><img src="'+file_name+'" width="'+file_width+'" height="'+file_height+'" alt=""></picture></a>');
                writeln('</body></html>');
                close();
            }
        }
    }
    {/literal}
    //-->
    </script>
{/if}

    <section id="page_{$staticpage_pagetitle|makeFilename}" class="serendipity_staticpage page serendipity_event_usergallery_image_display">
        <header>
           <h2>{$plugin_usergallery_title}</h2>
        </header>

        <div class="page_content">

            <nav aria-label="usergallery_image_display" title="usergallery_image_display">
                <ul class="serendipity_gallery_navigation pagination justify-content-between">
                    <li class="page-item prev{if $plugin_usergallery_previousid == -1} disabled{/if}">
{if $plugin_usergallery_previousid != -1}
                        <a class="page-link" href="{$plugin_usergallery_urlplus}serendipity[image]={$plugin_usergallery_previousid}">
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-double-left" role="img" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                              <title id="title">{$CONST.PREVIOUS}</title>
                              <path fill-rule="evenodd" d="M8.354 1.646a.5.5 0 0 1 0 .708L2.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                              <path fill-rule="evenodd" d="M12.354 1.646a.5.5 0 0 1 0 .708L6.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                            </svg>
                            <span class="sr-only">{$CONST.PREVIOUS}</span>
                        </a>
{else}
                        <span class="page-link hidden"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-dot" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 9.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z"/></svg></span>
{/if}
                    </li>
                    <li class="page-item info{if empty($plugin_usergallery_bcrumb)} disabled{/if}"><a href="{$plugin_usergallery_url}">{$head_title|default:$plugin_usergallery_title}</a>{foreach $plugin_usergallery_bcrumb AS $ugbcrumb} &raquo; {if $ugbcrumb@last}<strong>{$ugbcrumb.name}</strong>{else}<a href="{$plugin_usergallery_urlplus}gallery={$ugbcrumb.path}">{$ugbcrumb.name}</a>{/if}{/foreach}</li>
                    <li class="page-item next{if plugin_usergallery_nextid == -1} disabled{/if}">
{if $plugin_usergallery_nextid != -1}
                        <a class="page-link" href="{$plugin_usergallery_urlplus}serendipity[image]={$plugin_usergallery_nextid}">
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-double-right" role="img" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                              <title id="title">{$CONST.NEXT}</title>
                              <path fill-rule="evenodd" d="M3.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L9.293 8 3.646 2.354a.5.5 0 0 1 0-.708z"/>
                              <path fill-rule="evenodd" d="M7.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L13.293 8 7.646 2.354a.5.5 0 0 1 0-.708z"/>
                            </svg>
                            <span class="sr-only">{$CONST.NEXT}</span>
                        </a>
{else}
                        <span class="page-link hidden"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-dot" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 9.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z"/></svg></span>
{/if}
                    </li>
                </ul>
            </nav>

            <div class="serendipity_gallery_entry">
                <h4 class="serendipity_gallery_title">{$plugin_usergallery_file.title}</h4>
{if $plugin_usergallery_file.is_image}
{if $plugin_usergallery_is_endsize}

                <!-- Image -->
                <picture><source srcset="{$plugin_usergallery_file.fullavif|default:''}" type="image/avif"><source srcset="{$plugin_usergallery_file.fullwebp|default:''}" type="image/webp"><img class="serendipity_image_center gallery_preview" width="{$plugin_usergallery_file.alt_width}px" height="{$plugin_usergallery_file.alt_height}px" src="{$plugin_usergallery_file.link}" alt=""></picture>
{else}

                <!-- Popup -->
                <a href="javascript:popImage('{$plugin_usergallery_file.fullavif}','{$plugin_usergallery_file.fullwebp}','{$plugin_usergallery_file.link}','{$plugin_usergallery_file.name}','{$plugin_usergallery_file.dimensions_width}','{$plugin_usergallery_file.dimensions_height}')" class="serendipity_image_link" data-fallback="{$plugin_usergallery_file.link}"><picture><source srcset="{$plugin_usergallery_file.fullavif|default:''}" type="image/avif"><source srcset="{$plugin_usergallery_file.fullwebp|default:''}" type="image/webp"><img class="serendipity_image_center gallery_preview" width="{$plugin_usergallery_file.alt_width}px" height="{$plugin_usergallery_file.alt_height}px" src="{$plugin_usergallery_file.link}" alt=""></picture></a>
{/if}
{else}

                <!-- download link -->
                <a href="{$plugin_usergallery_file.link}" alt="{$plugin_usergallery_file.name}">{$CONST.USERGALLERY_DOWNLOAD_HERE}</a>
{/if}

                <!-- file information -->
                <div class="serendipity_gallery_info">
                    <div>{if NOT $plugin_usergallery_is_endsize}{$CONST.USERGALLERY_SEE_FULLSIZED}.{else}Maximum image size{/if}</div>
{if is_array($plugin_usergallery_file.entries) AND count($plugin_usergallery_file.entries) > 0}

                    <h5>{$CONST.USERGALLERY_LINKED_ENTRIES}</h5>

                    <ol>
{foreach $plugin_usergallery_file.entries AS $link}
                        <li><a href="{$link.href}">{$link.title}</a></li>
{/foreach}
                    </ol>
{/if}
{if is_array($plugin_usergallery_file.staticpage_results) AND count($plugin_usergallery_file.staticpage_results) > 0}

                    <h5>{$CONST.USERGALLERY_LINKED_STATICPAGES}</h5>

                    <ol>
{foreach $plugin_usergallery_file.staticpage_results AS $result}
                        <li><a href="{$result.href}">{$result.title}</a></li>
{/foreach}
                    </ol>
{/if}

                    <dl>
                        <dt>{$plugin_usergallery_file.name}.{$plugin_usergallery_file.extension}</dt>
                        <dd>{$CONST.PLUGIN_EVENT_USERGALLERY_FILESIZE}: {$plugin_usergallery_file.size_txt} kb</dd>
{foreach $plugin_usergallery_extended_info AS $entry}
                        <dd>{$entry.name}: {$entry.value}</dd>
{/foreach}
{if $plugin_usergallery_file.is_image}
{if $plugin_usergallery_xtra_info}
                        <dd>{$plugin_usergallery_xtra_info}</dd>
{/if}
{/if}
                    </dl>
                </div>
            </div>
        </div>
    </section>