{if $plugin_usergallery_image_display == 'popup' && $plugin_usergallery_use_reltype !== true}
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

    <section id="page_{$staticpage_pagetitle|makeFilename}" class="serendipity_staticpage page serendipity_event_usergallery">
        <header>
           <h2>{$plugin_usergallery_title}</h2>
        </header>

        <div class="page_content">
            <div class="serendipity_gallery_navigation">
                <a href="{$plugin_usergallery_url}">{$plugin_usergallery_title}</a>{foreach $plugin_usergallery_bcrumb AS $gallery} &raquo; <a href="{$plugin_usergallery_urlplus}gallery={$gallery.path}">{$gallery.name}</a>{/foreach}{if $plugin_usergallery_limit_directory != ""} &raquo; <a href="{$plugin_usergallery_urlplus}gallery={$plugin_usergallery_currentgal}"><strong>{$plugin_usergallery_limit_directory}</strong></a>{/if}

            </div>
{if $plugin_usergallery_preface}
            <div class="serendipity_preface">{$plugin_usergallery_preface}</div>
{/if}

            <!-- album list -->
{if $plugin_usergallery_dir_list == 'yes'}

            <ul class="plainList serendipity_gallery_directory">
{if $plugin_usergallery_display_dir_tree == 'yes'}
            <!-- basefolder in treeview -->
                <!-- considering singular/plural form of "image" depending on the filecount -->
                <li class="open"><a href="{$plugin_usergallery_url}">{$plugin_usergallery_title} ({$plugin_usergallery_maindir_filecount} {if $plugin_usergallery_maindir_filecount == 1}{$CONST.IMAGE}{else}{$CONST.PLUGIN_EVENT_USERGALLERY_IMAGES}{/if})</a></li>
{else}
{if $plugin_usergallery_toplevel == 'no'}
                <!-- 'up-one-level' link in galleries -->
                <li class="up"><a href="{$plugin_usergallery_urlplus}gallery={$plugin_usergallery_uppath}">{$CONST.PLUGIN_EVENT_USERGALLERY_UPONELEVEL} ({$plugin_usergallery_maindir_filecount} {if $plugin_usergallery_maindir_filecount == 1}{$CONST.IMAGE}{else}{$CONST.PLUGIN_EVENT_USERGALLERY_IMAGES}{/if})</a></li>
{else}
                <!-- basefolder in listview -->
                <li class="open"><strong>{$head_title|default:$plugin_usergallery_title}</strong> ({$plugin_usergallery_maindir_filecount} {if $plugin_usergallery_maindir_filecount == 1}{$CONST.IMAGE}{else}{$CONST.PLUGIN_EVENT_USERGALLERY_IMAGES}{/if})</li>
{/if}
{/if}
                <!-- folders -->
{foreach $plugin_usergallery_subdirectories AS $dir}
{if $dir.filecount > 0}
                <li class="closed" style="padding-left: {$dir.pxdepth}px;"><a href="{$plugin_usergallery_urlplus}gallery={$dir.relpath}">{$dir.name} ({$dir.filecount} {if $dir.filecount == 1}{$CONST.IMAGE}{else}{$CONST.PLUGIN_EVENT_USERGALLERY_IMAGES}{/if})</a></li>
{/if}
{/foreach}
            </ul>
{/if}

            <!-- end album list -->
{if $plugin_usergallery_pagination}

            <!-- pagination -->
            <nav aria-label="usergallery_collection_display_top" title="usergallery_collection_display_top">
                <ul class="serendipity_gallery_pagination_top pagination justify-content-between">
                    <li class="page-item prev{if $plugin_usergallery_current_page == 1} disabled{/if}">
{if $plugin_usergallery_current_page != 1}
                        <a class="page-link" href="{$plugin_usergallery_urlplus}gallery={$plugin_usergallery_currentgal}&amp;page={$plugin_usergallery_previous_page}">
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-double-left" role="img" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                              <title id="title">{$CONST.PREVIOUS_PAGE}</title>
                              <path fill-rule="evenodd" d="M8.354 1.646a.5.5 0 0 1 0 .708L2.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                              <path fill-rule="evenodd" d="M12.354 1.646a.5.5 0 0 1 0 .708L6.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                            </svg>
                            <span class="sr-only">{$CONST.PREVIOUS_PAGE}</span>
                        </a>
{else}
                        <span class="page-link hidden"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-dot" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 9.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z"/></svg></span>
{/if}
                    </li>
                    <li class="page-item info"><span>({$CONST.PLUGIN_EVENT_USERGALLERY_PAGINATION|sprintf:$plugin_usergallery_current_page:$plugin_usergallery_total_pages:$plugin_usergallery_total_count})</span></li>
                    <li class="page-item next{if $plugin_usergallery_current_page == $plugin_usergallery_total_pages} disabled{/if}">
{if $plugin_usergallery_current_page != $plugin_usergallery_total_pages}
                        <a class="page-link" href="{$plugin_usergallery_urlplus}gallery={$plugin_usergallery_currentgal}&amp;page={$plugin_usergallery_next_page}">
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-double-right" role="img" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                              <title id="title">{$CONST.NEXT_PAGE}</title>
                              <path fill-rule="evenodd" d="M3.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L9.293 8 3.646 2.354a.5.5 0 0 1 0-.708z"/>
                              <path fill-rule="evenodd" d="M7.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L13.293 8 7.646 2.354a.5.5 0 0 1 0-.708z"/>
                            </svg>
                            <span class="sr-only">{$CONST.NEXT_PAGE}</span>
                        </a>
{else}
                        <span class="page-link hidden"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-dot" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 9.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z"/></svg></span>
{/if}
                    </li>
                </ul>
            </nav>
            <!-- pagination -->
{/if}

            <!-- images -->
            <div class="{if $plugin_usergallery_image_gallery|default:true}c{$plugin_usergallery_cols|default:3} col serendipity_image_block{else}row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-{$plugin_usergallery_cols}{/if}">
{foreach $plugin_usergallery_images AS $image}

{if $plugin_usergallery_image_gallery|default:false}
                <div class="serendipity_gallery_thumbs col">
{/if}
{if $image.isimage}
{if $plugin_usergallery_image_display === 'popup'}

                    <!-- popup -->
                    <a href="javascript:popImage('{$image.fullavif}','{$image.fullwebp}','{$image.fullimage}','{$image.name}','{$image.dimensions_width}','{$image.dimensions_height}')" class="serendipity_image_link" data-fallback="{$image.link}" title="{$image.title}"><picture><source srcset="{$image.thumbavif|default:''}" type="image/avif"><source srcset="{$image.thumbwebp|default:''}" type="image/webp"><img class="serendipity_image_left gallery_thumb" {if $plugin_usergallery_fixed_width !=0}height={$plugin_usergallery_fixed_width}px width={$plugin_usergallery_fixed_width}px{/if} loading="lazy" src="{$image.link}" alt=""></picture></a>
{else}

                    <!-- show thumb -->
{if $plugin_usergallery_uselightbox === true}{* NOTE: Both inline style width 100% are for col 2 alike galleries, to size images up and not rely on a content width / 2 smaller image width! *}

                    <a href="{$image.varimage|default:$image.fullimage}" {$plugin_usergallery_lightbox_type} class="serendipity_image_link" data-fallback="{$image.fullimage}" title="{$image.title}"><picture><source srcset="{$image.thumbavif|default:''}" type="image/avif"><source srcset="{$image.thumbwebp|default:''}" type="image/webp"><img class="serendipity_image_left gallery_thumb" {if $plugin_usergallery_fixed_width !=0}height={$plugin_usergallery_fixed_width}px width={$plugin_usergallery_fixed_width}px{/if} style="width: 100%;" loading="lazy" src="{$image.link}" alt=""></picture></a>
{else}

                    <a href="{$plugin_usergallery_urlplus}serendipity[image]={$image.id}" class="serendipity_image_link" title="{$image.title}"><picture><source srcset="{$image.thumbavif|default:''}" type="image/avif"><source srcset="{$image.thumbwebp|default:''}" type="image/webp"><img class="serendipity_image_left gallery_thumb" {if $plugin_usergallery_fixed_width !=0}height={$plugin_usergallery_fixed_width}px width={$plugin_usergallery_fixed_width}px{/if} style="width: 100%;" loading="lazy" src="{$image.link}" alt=""></picture></a>
{/if}
{/if}
{else}

                    <!-- download link -->
                    <a href="{$image.fullimage}" target="blank" class="serendipity_image_link" data-fallback="{$image.link}" title="{$image.title}"><picture><source srcset="{$image.thumbavif|default:''}" type="image/avif"><source srcset="{$image.thumbwebp|default:''}" type="image/webp"><img class="serendipity_image_left gallery_thumb" loading="lazy" src="{$image.link}" alt=""></picture></a><br><a href="{$image.fullimage}" target="blank">Download {$image.name}.{$image.extension}</a>
{/if}
{if $plugin_usergallery_image_gallery|default:false}
                </div>
{/if}
{/foreach}

            </div><!-- col/row end -->
            <!-- end images -->
{if $plugin_usergallery_pagination}

            <!-- pagination -->
            <nav aria-label="usergallery_collection_display_bot" title="usergallery_collection_display_bot">
                <ul class="serendipity_gallery_pagination_bottom pagination justify-content-between">
                    <li class="page-item prev{if $plugin_usergallery_current_page === 1} disabled{/if}">
{if $plugin_usergallery_current_page !== 1}
                        <a class="page-link" href="{$plugin_usergallery_urlplus}gallery={$plugin_usergallery_currentgal}&amp;page={$plugin_usergallery_previous_page}">
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-double-left" role="img" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                              <title id="title">{$CONST.PREVIOUS_PAGE}</title>
                              <path fill-rule="evenodd" d="M8.354 1.646a.5.5 0 0 1 0 .708L2.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                              <path fill-rule="evenodd" d="M12.354 1.646a.5.5 0 0 1 0 .708L6.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                            </svg>
                            <span class="sr-only">{$CONST.PREVIOUS_PAGE}</span>
                        </a>
{else}
                        <span class="page-link hidden"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-dot" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 9.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z"/></svg></span>
{/if}
                    </li>
                    <li class="page-item info"><span>({$CONST.PLUGIN_EVENT_USERGALLERY_PAGINATION|sprintf:$plugin_usergallery_current_page:$plugin_usergallery_total_pages:$plugin_usergallery_total_count})</span></li>
                    <li class="page-item next{if $plugin_usergallery_current_page == $plugin_usergallery_total_pages} disabled{/if}">
{if $plugin_usergallery_current_page != $plugin_usergallery_total_pages}
                        <a class="page-link" href="{$plugin_usergallery_urlplus}gallery={$plugin_usergallery_currentgal}&amp;page={$plugin_usergallery_next_page}">
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-double-right" role="img" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                              <title id="title">{$CONST.NEXT_PAGE}</title>
                              <path fill-rule="evenodd" d="M3.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L9.293 8 3.646 2.354a.5.5 0 0 1 0-.708z"/>
                              <path fill-rule="evenodd" d="M7.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L13.293 8 7.646 2.354a.5.5 0 0 1 0-.708z"/>
                            </svg>
                            <span class="sr-only">{$CONST.NEXT_PAGE}</span>
                        </a>
{else}
                        <span class="page-link hidden"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-dot" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 9.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z"/></svg></span>
{/if}
                    </li>
                </ul>
            </nav>
            <!-- end pagination -->
{/if}

        </div>
    </section>
{if $plugin_usergallery_uselightbox === true AND $plugin_usergallery_use_reltype !== true}

{if $plugin_usergallery_lightbox_jquery}
        <script type="text/javascript" src="{$plugin_usergallery_lightbox_dir}/jquery-1.11.3.min.js" charset="utf-8"></script>
{/if}

{if $plugin_usergallery_lightbox_script == 'colorbox'}

        <link rel="stylesheet" type="text/css" href="{$plugin_usergallery_lightbox_dir}/colorbox/colorbox.css">
        <script type="text/javascript" src="{$plugin_usergallery_lightbox_dir}/colorbox/jquery.colorbox-min.js" charset="utf-8"></script>
        <script type="text/javascript">
            jQuery('a[rel^="colorbox"]').colorbox({
                slideshow: true,
                slideshowAuto: false,
                slideshowSpeed: 6000,
                scalePhotos: true,
                maxWidth: '98%'
            });
        </script>

{elseif $plugin_usergallery_lightbox_script == 'lightbox'}

        <link rel="stylesheet" type="text/css" href="{$plugin_usergallery_lightbox_dir}/lightbox2-jquery/css/lightbox.css">
        <script type="text/javascript"> jQuery(document).ready(function(){ jQuery(\'a[rel^="lightbox"]\').removeAttr("onclick"); }); </script>
        <script type="text/javascript" src="{$plugin_usergallery_lightbox_dir}/lightbox2-jquery/js/lightbox.min.js" charset="utf-8"></script>

{elseif $plugin_usergallery_lightbox_script == 'magnific'}

        <link rel="stylesheet" type="text/css" href="{$plugin_usergallery_lightbox_dir}/magnific-popup/magnific-popup.css">
        <script type="text/javascript" src="{$plugin_usergallery_lightbox_dir}/magnific-popup/jquery.magnific-popup.min.js" charset="utf-8"></script>
        <script type="text/javascript">
            jQuery(document).ready(function(){
                jQuery('a[rel^="magnificPopup"]').magnificPopup({
                    gallery:{
                        enabled:true
                    },
                    type:'image'
                });
            });
        </script>

{elseif $plugin_usergallery_lightbox_script == 'prettyphoto'}

        <link rel="stylesheet" type="text/css" href="{$plugin_usergallery_lightbox_dir}/prettyphoto/css/prettyPhoto.css">
        <script type="text/javascript" src="{$plugin_usergallery_lightbox_dir}/prettyphoto/js/jquery.prettyPhoto.min.js" charset="utf-8"></script>
        <script type="text/javascript">
            jQuery(document).ready(function(){
                jQuery('a[rel^="prettyPhoto"]').prettyPhoto({
                    social_tools: false
                });
            });
        </script>

{/if}
{/if}
