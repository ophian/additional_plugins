## Additional plugins for Serendipity Styx Edition.

The plugins contained here are automatically synced via XML with your Spartacus (plugin): __S P A R T A C U S__ :: **S**erendipity **P**lugin **A**ccess **R**epository **T**ool **A**nd **C**ustomization / **U**nification **S**ystem.
The XML sidebar or event plugin files in question are synced to contain new or updated submissions when required.

This will fully work with **Styx** only, which has some bugs fixed in core.

## Spartacus related changes for connects
* **Ignore** the following since the **Serendipity Styx 2.6-beta1** release, see [4th list element](https://ophian.github.io/2018/08/06/Styx-2.6-beta1-released/) Spartacus notes!
* - - -
* Spartacus connect changes - regarding plugin updates - require to set this url `https://raw.githubusercontent.com/ophian/additional_plugins/master/` into the "_Custom location for mirror_" **Spartacus** plugin option.
* Due to **bugs** in the previous (origin Serendipity) Spartacus plugin versions this does not work without **temporary fixing** the Spartacus plugin file by dropping this file https://raw.githubusercontent.com/ophian/styx-spartacus-up/master/serendipity_event_spartacus.php over the old file.
* It is a (temporary) helper file, to SET and GET plugin updates from this repository and should **NOT** be used without wanting to update to Serendipity Styx Edition via the "autoupdater", see **Styx 2.1-beta1** and the **Styx 2.1-rc1** release notes and the WIKI for upgrades!

XML and RSS synchronizing `make` files (`*.sh` and `*.php`) are heftily tweaked to run with my local environment needs. Make your own (these files here are just the origin clones)!
