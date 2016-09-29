# Plugin serendipity_event_staticpage for Serendipity 2.1 and up

- - -

### ToDo: :arrow_down:
- [ ] deep check, if any change broke anything with some more enhanced staticpage options (all normal behaviour is checked working!)
- [ ] future Todo - check possibility for an automated integration to templates using $template_global_config = array('navigation' => true)
- [ ] future Todo - refactor related category associations
- [ ] check staticpage authorid vs $serendipity['authorid'] (0 != 1)!
- [ ] Keep new check_config() method check for dtree.css? Is it worth being expensive here?
- [ ] Check some last remaining questions pasted as '// RQ: ' notes (- - - -)


- - -

### Already done: :arrow_up:
- [x] Optimize serendipity_property_bag load actions
- [x] Cleanup - no custom sub-array in pagetype cases
- [x] Fix an issue switching from existing pagetype to a new form on submit did not change values
- [x] Some more optimizing for the staticpage backend CSS, which also removes some more leftovers for the 1.7 Series.
- [x] Optimize inspectConfig load for backend form generations by an abstract class, instead of a multiple loaded "template" file.
- [x] Set Serendipity 2.1.0+ requirement and removed old stuff
- [x] Remove old TODO and style_staticpage_backend.css files
- [x] Added undocumented feature since 3.50 to the Readme
- [x] Consistent cleanups - stringify booleans in config options, set and fix fallbacks and review sidebar plugin
- [x] Fix $nav array exception gathering values for an entry without any navigational options set
- [x] Workaround SQLite install bug, while not being able to ALTER and fully support other table changes (#377)
- [x] Changed SVG since SVG title attributes were not read - see https://gist.github.com/davidhund/564331193e1085208d7e
- [x] Changed requirement to min PHP 5.3, which removes deprecated sortByOrder() method.
- [x] Added a "default fallback" frontend "plugin_staticpage_includeentry.tpl file", for the case it was previously set in a template OR included by an entry, when switching to a new theme without having this file.
- [x] Fix access permissions in backend
- [x] Append all CSS to eventData (includes earlier fix for frontend CSS)
- [x] Consistent use of serendipity_db_bool() config default values
- [x] Now uses load_language API - extends sidebar plugin to v.1.27
- [x] Added S9y 2.0.0 - 2.0.99 backend configgroup placeholder ability by script
- [x] Minor markup space fixes, update simplepagination, include iconizr template, added title for parent staticpage in list
- [x] Fixed POST preview check
- [x] Minor improvements to CSS
- [x] Fixed $eventData[0]['type'] 'dir' replacements
- [x] Fixed $eventData being changed by backend_media_rename hook
- [x] Update simplePagination Lib
- [x] Fixed MediaLibrary item path replacements on MOVE with Serendipity 2.1 DEV
- [x] Note to use a theme unique filename for the related article template by freetags
- [x] Use the new simple fallback parameter in serendipity_getTemplateFile()
- [x] Remove RQ for double entry staticpage var
- [x] Move 2cd fetchPlugins() call to only apply if in need
- [x] Make db queries consistent
- [x] Added language field info
- [x] Fixed password protected pages not showing up
- [x] Fix sidebar plugin dependency config value check to append dtree.css into stream. Updated plugin_staticpage_sidebar.tpl.
- [x] Removed wrong used smartify sidebar dependency check for a certain CSS case - rule output not by option than by version now
- [x] Fix showlist db-boolean sets/gets
- [x] Add db-build case 21 for certain silent db error in the past (ALTER permissions). Now an error is shown in the backend only without spoiling the serendipity_editor.js
- [x] Fix two commits for database changes with v.3.98 commit 36fd48b Changed meta fields, no longer custom properties and v.3.97 commit 43e0f86 Breadcrumb navigation as an independent option, which could happen to not apply in every case.
- [x] Fix missing trim($str) and an empty output of the JS Tree Smarty var via template, while the empty(array) was not true. Sets the sidebar plugin to v.1.26
- [x] Fix icon-info image notifier not displayed embedded, when sidebar plugin is not installed
- [x] Update jquery.simplePagination.js
- [x] Removed icon font usage and added SVG sprites with 2.0 instead
- [x] Fixed JS spconfig_listPerPage and JS pagination function to happen on listentries pages only
- [x] Changed dtree usage page links world image to something more smart
- [x] Fixed styles now added to the END of eventData stream, while checking for existing styles (dtree)
- [x] Add configuration grouper
- [x] Add new config option to list entries pagination by N entries
- [x] Add separators to streamed CSS
- [x] ~~Removed $serendipity['staticpageplugin']['JS_init'] since this had no effect for the dtree.js call~~ [Keep it. Though still being in question!]
- [x] Fixed dtree.js being included more than once, by making the called script name unique
- [x] Fixed missing dtree.css includement, in case of having selected this option
- [x] Fixed cookie issue with backend form template. Set responsive_template.tpl as "default" fallback on S9y >= 2.0
- [x] Removed an old and wrong used registration, since 'in_array' already is an allowed $php_function, since S9y-1.7
- [x] Fixed default selected fallback backend form when unset or expired cookie
- [x] Fixed 2.0 backend template form chaining (4.08) and merge array backend form names uniquely
- [x] Fixed preview button for existing pages with 2.0
- [x] New: iconized entrylist/entryform tabbar for 2.0
- [x] Better use fixUTFEntity method only for frontend template vars (articleformatitle and headline)
- [x] Set backends form textformat option automatically to NO, on WYSIWYG usage (?) Yes. Has dependency in 2.0 entryproperties!
- [x] Added - automark an entry as written by Wysiwyg-Editor via custom fields, to disable nl2br markup formating
- [x] Fixed (html)specialchars double_encode to false for native ISO-8859-1 charsets for certain form input/testarea fields in backend and some Smarty output variables in backend/frontend (which updates plugin_staticpage_***.tpl files again)
- [x] Added check for new SQLite3 OO database layer with PHP 5.4+
- [x] Rename directory backend_templates. There is a risk that existing user template dirs have other files in it (not excluded by backend_show) (?) No.
- [x] Move new backend template files into own or current backend_template directory (?) No.
- [x] Renamed style_sp_s9yold.css to staticpage_backend.old.css
- [x] Renamed old_backend_staticpage.tpl to backend_staticpage.old.tpl
- [x] Re-integrated previously outsourced backend_show.php
- [x] Fixed htmlspecialchars() for PHP >=5.4 with native, non-utf-8 language installs, which changed with PHP 5.4 from ISO-8859-1 to UTF-8
- [x] Added new README_FOR_CUSTOM_FIELDS.txt
- [x] Added new custom template, which now holds existing examples for custom properties, based on responsive template. This removes the custom examples in the responsive template.
- [x] Some small fixes https://github.com/ophian/serendipity_event_staticpage/compare/v4.27...46320d9
- [x] Associated 1:1 relation for staticpage related categories. Touches staticpages and staticpage_categorypage tables to support the latter 1:1 relations only, as of now. Old entries don't get touched by this, until they will be updated.
- [x] Solve some last remaining questions pasted as '// RQ: ' notes (+ + + + +)
- [x] Removed commented $related_category_entries code, since being unneeded for the solution with serendipity_fetchPrintEntries and unworth to keep, since not really working.
- [x] Removed old and unused getSistersID method
- [x] Removed old and unused sequencer pageorder methods to use with javascript drag & drop only
- [x] Fixed 2.0 Markup in category hook, the example markup in related category Readme, set some more form info and minor association with related category id and the corresonding table on delete
- [x] Added more backend title attribute information for pageorder and entrylisting titles
- [x] Touch frontend templates (in this plugin dir) for HTML5, inline styles, Navigations, etc
- [x] Fix and correct entrypaging, breadcrumb and childpage navigations
- [x] Changed for 2.0: added title attribute #ID to sequencer pagetitle, to know which id is meant by childpages
- [x] Changed for 2.0: fixed save pageorder to work with current current 2.0 changes
- [x] Changed for 2.0: default config value for show entrylist is now true
- [x] Done for 2.0: since now using Smarty 3 only, some Smarty code will need a refresh (no need, but cleaner)
- [x] Main backend CSS was renamed to staticpage_backend.css and now includes separately into backends page header
- [x] Added for 2.0: include new staticpage_backend.js to templates page footer - no need to use 2.0 js hook
- [x] Hide/Show the top tab bar menu per JS hideaway, since not used very often
- [x] Add sorting filter function to entrylists - no need, since using simplePagination now (!)
- [x] Navigate with larger amount of entrylist pages per newly added simplePagination.js, fits nice from 8 to some deci- pages
- [x] Note, that some constants were added, removed or changed
- [x] Added some missing and changed some method PHPDocs
- [x] Added for 2.0: experimental entrylistings (entrylisting and pageorder sequencer) respect parent/child staticpages treeview listing in a simple way
- [x] Added for 2.0: collapsible boxes icon change and use a universal setLocalStorage() and another for retrieve
- [x] Added new simpler pageorder table fetcher
- [x] Added for 2.0: form submit save-toolbar-button is now disabled when using the CKEDITOR full-package
- [x] Added compat fallback to defaultform_template in case of cookie stored 'all fields/non-template' (old hardcoded) form
- [x] Changed method name getSystersID() to getSisterID()
- [x] Prepare everything to HTML5, which will be the default in future
- [x] Prepare everything and purge plugins hardcoded non-smarty output
- [x] Remove the 'no template' hardcoded stuff
- [x] Plain Editor button changes for the 2.0 backend
- [x] Extend required Serendipity version to 1.7 and Smarty 3.1, since the old_backend_staticpage.tpl would need too much old Smarty2 and CSS fixes
- [x] Added confirmation dialog on select change page events, to avoid saving into wrong page accidently
- [x] Moved listentries _new submit footer to also show up on empty list
- [x] Added new config option to show last_modified or created_on date in plugin_staticpage.tpl (needs to change templates with already supplied files!)
- [x] Applied some plain button changes for 2.0 previously bumped as 4.06
- [x] Added a responsive custom (mobile) template, to replace the old 'no Template' (previously named 'All Fields' form)
- [x] Finalize the version stylesheets for this
- [x] Finalize 'backend_staticpage.tpl' for Serendipity 2.0 only usage
- [x] Keep 'old_staticpage_backend.tpl' for previous S9y versions
- [x] Reworked default form template by switching new_backend
- [x] Added new 'pagetype' typeform template
- [x] Set required S9y version to 1.6, due to smarty usage in sequencer 'pageorder' drag&drop
- [x] Smartified the backend as much as possible
- [x] Outsourced and changed some heavy markup functions, due to a better overview
- [x] Changed form template names
- [x] Added in 'pageorder' a new drag&drop sequencer, to automatically set the new list order on drop
- [x] Added some CSS and include by version files
- [x] Fixed tabs and 'pageadd' markup/css
- [x] Fixed backend_templates/default_staticpage_backend.tpl smarty markup (escape and cke-wysiwyg)
- [x] Fixed some plugin file code inconsistencies
- [x] Fixed some minor markup errors
- [x] New option: sets publishstatus (default draft) as default
- [x] New option: sets listentries (selectbox default), due to errors in combination with selectlist
- [x] Fixed (4.06) new entrylist markup


- - -

### Undocumented Features

Postby garvinhicking » Wed Jun 13, 2007 12:36 pm in http://board.s9y.org/viewtopic.php?p=57362#57362
#### New staticpage feature: Show staticpages via Smarty

I just upgraded the staticpage plugin in CVS to version 3.50.

It now supports to use a custom smarty function to show static pages. This can be used in your custom template files (like the userprofile .tpls *) to emit specific staticpages depending on variables.

Go ahead and play with it. The API is quite basic and described in the new 'smarty.inc.php' file. It basically works like this:

(*) by the User-Profiles-Plugin

```Smarty
{staticpage_display template="$TEMPLATE" pagevar="$PAGEVAR" id="$ID" permalink="$PERMALINK" pagetitle="$PAGETITLE" authorid="$AUTHORID" query="$QUERY"}
```

Variable options:
 - `$TEMPLATE` can be replaced with the name of the staticpage template to parse. It defaults to "plugin_staticpage.tpl".
 - `$PAGEVAR` must match the variable prefix of the staticpage template. If you want to parse multiple staticpages, you might need to seperate those from each other. Always use the variable prefix that is also employed in the template file.

To retrieve a staticpage, you need to supply either one of those options:
 - `$ID` can be replaced with the ID of the staticpage you want to fetch.
 - `$PERMALINK` can be replaced with the fully configured permalink of a staticpage.
 - `$PAGETITLE` can be replaced with the URL shorthand/backwards compatibility name of a staticpage
 - `$AUTHORID` additionally can be combined with the variables above to restrict output to a specific author

If you need more customization, you can pass a SQL query directly using `$QUERY`.

EXAMPLE:
To fetch a static page with the URL shorthand name 'static' you simply put this in your template file (index.tpl, a userprofile .tpl or whatever):
```Smarty
{staticpage_display pagetitle='static'}
```
