## Additional plugins for Serendipity Styx Edition.

The plugins contained here are automatically synced via XML with your Spartacus (plugin): __S P A R T A C U S__ :: **S**erendipity **P**lugin **A**ccess **R**epository **T**ool **A**nd **C**ustomization / **U**nification **S**ystem.
The XML sidebar or event plugin files in question are synced to contain new or updated submissions when required.

This will fully work with **Styx** only, which has some bugs fixed in core.


## Outdated and retired plugins

Here you see all removed plugins from *styx/additional_plugins*, which were set deprecated or got sorted out for better replacements or ended lifetime.

If you need them shown for (plugin) **idea** works, please run [this search query](https://github.com/search?q=repo%3Aophian%2Fadditional_plugins+Remove+%2B+plugin&type=commits), which should include them all in their latest state of retirement (_which might not match current API or consistency usage these days_). This search also shows some very few (search request expression) matches of existing plugin commits. But you'll sort this this out by yourself. This is the best I can do for you to punch you back some decades. 😁

This is the list of retired plugins for Styx:

```php
$n = array (
  0 => 'serendipity_event_advtypes',
  1 => 'serendipity_event_autosave',
  2 => 'serendipity_event_babelfish',
  3 => 'serendipity_event_browserid',
  4 => 'serendipity_event_cachesimple',
  5 => 'serendipity_event_cleanspam',
  6 => 'serendipity_event_dashboard',
  7 => 'serendipity_event_deletelink',
  8 => 'serendipity_event_fckeditor'
  9 => 'serendipity_event_feedflare',
  10 => 'serendipity_event_findmore',
  11 => 'serendipity_event_g2embed',
  12 => 'serendipity_event_galleryimage',
  13 => 'serendipity_event_gravatar',
  14 => 'serendipity_event_htmlvalidator',
  15 => 'serendipity_event_jquery',
  16 => 'serendipity_event_layout_linkmarkup',
  17 => 'serendipity_event_layout_quotemarkup',
  18 => 'serendipity_event_motm',
  19 => 'serendipity_event_phpopentracker',
  20 => 'serendipity_event_picasa',
  21 => 'serendipity_event_sidebaritemcollapse',
  22 => 'serendipity_event_smartymarkup',
  23 => 'serendipity_event_snapshotlinks',
  24 => 'serendipity_event_sort',
  25 => 'serendipity_event_webpasties',
  26 => 'serendipity_event_wrapurl',
  27 => 'serendipity_event_yq',
  28 => 'serendipity_event_xinha',
  29 => 'serendipity_plugin_audioscrobbler',
  30 => 'serendipity_plugin_delicious',
  31 => 'serendipity_plugin_feedburnersidebar',
  32 => 'serendipity_plugin_frappr',
  33 => 'serendipity_plugin_gallery_menalto_random',
  34 => 'serendipity_plugin_google_last_query',
  35 => 'serendipity_plugin_hitmaps',
  36 => 'serendipity_plugin_ipv6',
  37 => 'serendipity_plugin_quicksearch',
  38 => 'serendipity_plugin_smiletag',
  39 => 'serendipity_plugin_topreferers',
  40 => 'serendipity_plugin_weather',
  41 => 'serendipity_plugin_zooomr',
)
```


## Spartacus related changes for connects
* **Ignore** the following since the **Serendipity Styx 2.6-beta1** release, see [4th list element](https://ophian.github.io/2018/08/06/Serendipity-Styx-2.6-beta1-released/) Spartacus notes!
* - - -
* Spartacus connect changes - regarding plugin updates - require to set this url `https://raw.githubusercontent.com/ophian/additional_plugins/master/` into the "_Custom location for mirror_" **Spartacus** plugin option.
* Due to **bugs** in the previous (origin Serendipity) Spartacus plugin versions this does not work without **temporary fixing** the Spartacus plugin file by dropping this file https://raw.githubusercontent.com/ophian/styx-spartacus-up/master/serendipity_event_spartacus.php over the old file.
* It is a (temporary) helper file, to SET and GET plugin updates from this repository and should **NOT** be used without wanting to update to Serendipity Styx Edition via the "autoupdater", see **Styx 2.1-beta1** and the **Styx 2.1-rc1** release notes and (the _WIKI_) - or better, the [Styx Site - Installation Guide](https://ophian.github.io/hc/en/installation.html) - for upgrades!

XML and RSS synchronizing `make` files (`*.sh` and `*.php`) are heftily tweaked to run with my local environment needs. Make your own (these files here are just the origin clones)!
