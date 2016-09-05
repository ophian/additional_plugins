Additional plugins for Serendipity Weblog, Styx Edition.

The plugins contained here are automatically synced with Spartacus (plugin), the Serendipity **[S]**erendipity **[P]**lugin **[A]**ccess **[R]**epository **[T]**ool **[A]**nd **[C]**ustomization/**[U]**nification **[S]**ystem, if set this url **"https://raw.githubusercontent.com/ophian/additional_plugins/master/"** into the **"Custom location for mirror"** Spartacus plugin option.
The XML sidebar or event plugin files in question are synced to contain new or updated submissions when required.

This will work with **Styx** only, which has some bugs fixed in core.

## Styx related changes for updating
* **Styx** changes - regarding plugin updates - requires to set this url `https://raw.githubusercontent.com/ophian/additional_plugins/master/` into the "_Custom location for mirror_" **Spartacus** plugin option. Due to **bugs** in previous Spartacus versions this does not work without **temporary fixing** the Spartacus plugin file by dropping this file https://raw.githubusercontent.com/ophian/styx-spartacus-up/master/serendipity_event_spartacus.php over the old file.

XML and RSS synchronizing make files (`*.sh` and `*.php`) are heftily tweaked to run with my local environment needs. Make your own (these files here are just the origin clones)!
