<?php

@define('PLUGIN_EVENT_DSGVO_GDPR_NAME', 'DSGVO / GDPR: General Data Protection Regulation');
@define('PLUGIN_EVENT_DSGVO_GDPR_DESC', 'This plugin aims to help blog owners to apply conformity to the General Data Protection Regulation Act.');
@define('PLUGIN_EVENT_DSGVO_GDPR_MENU', 'GDPR statement and informational text modules');
@define('PLUGIN_EVENT_DSGVO_GDPR_STATEMENT', 'Your privacy statement / legal notice');
@define('PLUGIN_EVENT_DSGVO_GDPR_STATEMENT_DESC', 'You can see this automatic inspection above as a rough draft of information, which you can use to understand what to include to your sites privacy statement. Make sure that your privacy statement contains all relevant information. Contact a lawyer if you need help with this, we sadly cannot provide a bulletproof statement draft for you for liability reasons.');
@define('PLUGIN_EVENT_DSGVO_GDPR_URL', 'Optional URL to privacy statement');
@define('PLUGIN_EVENT_DSGVO_GDPR_URL_DESC', 'By default, an internal link is created that displays the text of your privacy statement with the text you enter here (see textarea input form "Your privacy statement / legal notice" down below). However if you have a specific URL (or a staticpage URL) that you want to link your visitors to, you can enter it here. Then the privacy statement text will not be displayed and does not need to be entered.');
@define('PLUGIN_EVENT_DSGVO_GDPR_COMMENTFORM_CHECKBOX', 'Require to accept privacy statement in send forms?');
@define('PLUGIN_EVENT_DSGVO_GDPR_COMMENTFORM_CHECKBOX_DESC', 'If enabled, visitors are required to check an additional checkbox for blog comments or contact forms to confirm your privacy statement.');

@define('PLUGIN_EVENT_DSGVO_GDPR_SAVENEWLANG', 'If this field has already been saved in another language, delete the contents and save again to obtain a customized language version for saving.');
@define('PLUGIN_EVENT_DSGVO_GDPR_COMMENTFORM_TEXT', 'Text for comment consent');
@define('PLUGIN_EVENT_DSGVO_GDPR_COMMENTFORM_TEXT_DESC', 'Enter the text here that is displayed to the user for accepting your terms of reference. Use %gdpr_url% as a placeholder for the URL.');
@define('PLUGIN_EVENT_DSGVO_GDPR_COMMENTFORM_TEXT_DEFAULT', 'I agree that my data will be stored. Please review the <a href="%gdpr_url%" target="_blank" rel="noopener">terms of usage / imprint</a> for further details.');
@define('PLUGIN_EVENT_DSGVO_GDPR_INFO', 'Information to your blog\'s GDPR relevance');
@define('PLUGIN_EVENT_DSGVO_GDPR_INFO_DESC', 'Serendipity allows plugins to specify, which impact they have on your blog\'s usage and handling of sensible data. At this place, this data is automatically evaluated and printed here for your information. Please be sure to always have the recent versions of plugins. You yourself are legally responsible to disclose any used services to the visitor. If you use any functionality outside of core and plugin Serendipity (custom plugins, custom templates, snippets) that is relevant, be sure to include them in your privacy statement!');

@define('PLUGIN_EVENT_DSGVO_GDPR_ANONYMIZE', 'Anonymize IPs?');
@define('PLUGIN_EVENT_DSGVO_GDPR_ANONYMIZE_DESC', 'If enabled, the last parts of the IP address (ipv4 and ipv6) will be replaced with "0". This means, all places where serendipity saves or utilizes the IP address of the visitor (also for anti-spam methods) the recorded IP will not be the actual IP of the user. In case of abuse, you will not be able to tell the actual IP used for a comment, for example.');

@define('PLUGIN_EVENT_DSGVO_GDPR_SHOW_IN_FOOTER', 'Show privacy statement link in footer?');
@define('PLUGIN_EVENT_DSGVO_GDPR_SHOW_IN_FOOTER_DESC', 'When enabled, a link to your privacy statement is included in the footer of your blog. You can adjust the displayed text. The placeholder %gdpr_url% can be used for that link.');
@define('PLUGIN_EVENT_DSGVO_GDPR_SHOW_IN_FOOTER_TEXT', 'Privacy statement link text');
@define('PLUGIN_EVENT_DSGVO_GDPR_SHOW_IN_FOOTER_TEXT_DESC', 'If the privacy statement link is enabled, enter the text you want to show up there');
@define('PLUGIN_EVENT_DSGVO_GDPR_SHOW_IN_FOOTER_TEXT_DEFAULT', '<a href="%gdpr_url%">Privacy statement / Imprint</a>');

@define('PLUGIN_EVENT_DSGVO_GDPR_COOKIE_MENU', 'CookieConsent');
@define('PLUGIN_EVENT_DSGVO_GDPR_COOKIE_CONSENT', 'Enable CookieConsent by Osano?');
@define('PLUGIN_EVENT_DSGVO_GDPR_COOKIE_CONSENT_DESC', 'If enabled, this displays a cookie banner in your blog. This uses the CookieConsent javascript library. It only supports the Cookie information compliance type. You can use the generator on <a href="https://cookieconsent.insites.com/download/">https://cookieconsent.insites.com/download/</a> to create the actual code; be sure to ONLY paste the main script-Part here and NOT the link to the CSS and JavaScript, to ensure that no code is loaded of foreign servers but only from yours.');
@define('PLUGIN_EVENT_DSGVO_GDPR_COOKIE_CONSENT_TEXT', 'CookieConsent Code');
@define('PLUGIN_EVENT_DSGVO_GDPR_COOKIE_CONSENT_TEXT_DESC', 'This javascript is easy to read, you can adapt all colors and texts here. You would need to enter your correct domain address and need to set the secure attribute to true or false, if your blog runs under a CA secured certificate. You can use %gdpr_url% as a placeholder for the link to your policy statement.');
@define('PLUGIN_EVENT_DSGVO_GDPR_COOKIE_CONSENT_TEXT_DEFAULT', '
<script>
    window.addEventListener("load", function(){
    const CC = window.CookieConsent;
    const cc = new CC({
      "palette": {
        "popup": {
          "background": "#FFFFFF",
          "text": "#000000"
        },
        "button": {
          "background": "#FFFFFF",
          "text": "#0c5e0a",
          "border": "#000000"
        }
      },
      "cookie": {
        "domain": "YOUR.DOMAIN.EXT",
        "secure": true
      },
      "content": {
        "message": "This website uses cookies.",
        "dismiss": "I understand",
        "link": "Read more in the privacy statement",
        "href": "%gdpr_url%"
      }
    })});
</script>
');

@define('PLUGIN_EVENT_DSGVO_GDPR_COOKIE_CONSENT_PATH', 'CookieConsent javascript location');
@define('PLUGIN_EVENT_DSGVO_GDPR_COOKIE_CONSENT_PATH_DESC', 'This plugin bundles the JS and CSS of the cookie consent site. You can refer to other directories here. Make sure the files are called cookieconsent.min.css and cookieconsent.min.js');
@define('PLUGIN_EVENT_DSGVO_GDPR_COMMENTFORM_ERROR', 'You must accept the terms to leave a comment.');
@define('PLUGIN_EVENT_DSGVO_GDPR_STATEMENT_ERROR', 'This blog has not yet created a privacy statement, it must be configured in the Plugin Configuration.');

@define('PLUGIN_EVENT_DSGVO_GDPR_SERENDIPITY_CORE', '

<h4>Serendipity Core</h4>

<p>Serendipity uses a so-called "Session cookie" for both frontend and backend. A visitor will receive a cookie with
a unique ID, which is used on the server to store temporary session user data (i.e. login validity, user preferences).
This cookie is mandatory for logging in to the backend, but optional for the frontend.
Certain plugins can use the session cookie to store additional temporary data.</p>

<p>The following data can be stored by the Serendipity application on the server (temporarily, invalidated after the server-configured timeout, usually in the range of hours):</p>

<ul>
    <li>HTTP browser referrer when entering the blog</li>
    <li>Unique author ID token</li>
    <li>User data of a logged in author as stored in the database for faster access:
        <ul>
            <li>Password</li>
            <li>ID of the user</li>
            <li>Configured language of the user</li>
            <li>Username</li>
            <li>E-Mail</li>
            <li>Login hashtype</li>
            <li>Publishing right</li>
        </ul>
    </li>
    <li>Last blog entry contents when saving</li>
    <li>Indicator if Smarty templating is used</li>
    <li>Possible content of a generated Captcha image</li>
    <li>The configured frontend theme</li>
</ul>

<p>The following data is stored in cookies:</p>

<ul>
    <li>PHP session ID</li>
    <li>State of entry editor toggle, sort, sort order and filter toggles, last used MediaLibrary directory (only if logged in)</li>
    <li>Author login token (only if logged in)</li>
    <li>Display language</li>
    <li>After commenting: Last name, E-Mail, URL, state of "Remember comments" (if enabled)</li>
</ul>

<p>The IP addresses of users are utilized at these places:</p>

<ul>
    <li>Stored in database when referrer tracking is enabled (Statistics)</li>
    <li>Database storage for comments of a visitor and displayed within the E-Mail that is sent to moderators</li>
    <li>Stored in logfile (if enabled) of the Antispam spamblock plugin</li>
    <li>Transmitted in Antispam filter for Akismet (if enabled)</li>
    <li>Temporary Read-only access for checking referrers, logins, IP flooding</li>
</ul>

<p>User input from visitors (not editors):</p>

<ul>
    <li>Comments (all comment metadata, is stored in the database table "serendipity_comments")</li>
    <li>Referring URL when entering the blog (if referrer tracking is enabled, in stored in the database table serendipity_referers)</li>
</ul>

<p>Additionally, the following plugins are currently enabled and this is their automatically generated manifest:</p>

');
@define('PLUGIN_EVENT_DSGVO_GDPR_SERENDIPITY_CORE_THEMES', '

<h2>Serendipity Core Themes</h2>

<p>Additionally, the following themes are active/available and this is their automatically generated manifest:</p>

');

@define('PLUGIN_EVENT_DSGVO_GDPR_PLUGINS_SERVICES_HEAD', 'Web services / Third Party');
@define('PLUGIN_EVENT_DSGVO_GDPR_PLUGINS_SESSIONDATA_HEAD', 'Session data');
@define('PLUGIN_EVENT_DSGVO_GDPR_PLUGINS_ATTR_HEAD', 'Plugin attributes');
@define('PLUGIN_EVENT_DSGVO_GDPR_PLUGINS_ATTR_STORAGE_USER_YES', 'Stores user data (like names, text, preferences) to a database, file or any other storage (like mail, cookie, ...)');
@define('PLUGIN_EVENT_DSGVO_GDPR_PLUGINS_ATTR_STORAGE_USER_NO', 'Does not store user data (or not specified)');
@define('PLUGIN_EVENT_DSGVO_GDPR_PLUGINS_ATTR_STORAGE_IP_YES', 'Stores IP data (written to storage)');
@define('PLUGIN_EVENT_DSGVO_GDPR_PLUGINS_ATTR_STORAGE_IP_NO', 'Does not store IP data (or not specified)');
@define('PLUGIN_EVENT_DSGVO_GDPR_PLUGINS_ATTR_USES_IP_YES', 'Operates on IP data (read-access, also when passing through metadata)');
@define('PLUGIN_EVENT_DSGVO_GDPR_PLUGINS_ATTR_USES_IP_NO', 'Does not operate on IP data (or not specified)');
@define('PLUGIN_EVENT_DSGVO_GDPR_PLUGINS_ATTR_TRANSMITS_YES', 'Transmits user input to services / third parties (not necessarily stored)');
@define('PLUGIN_EVENT_DSGVO_GDPR_PLUGINS_ATTR_TRANSMITS_NO', 'Does not transmit user input to services / third parties (or not specified)');

@define('PLUGIN_EVENT_DSGVO_GDPR_BACKEND', 'Backend of Data Protection Regulation Plugin');
@define('PLUGIN_EVENT_DSGVO_GDPR_BACKEND_SB_TITLE', 'Comments userdata');
@define('PLUGIN_EVENT_DSGVO_GDPR_BACKEND_TITLE', 'DSGVO/GDPR - Manage user comment-data');
@define('PLUGIN_EVENT_DSGVO_GDPR_BACKEND_INFO', 'Here you can enter an exactly matching username or e-mail address to wipe out all comment metadata or export the comments for that user. You can separate multiple names with a newline.');
@define('PLUGIN_EVENT_DSGVO_GDPR_BACKEND_DELFAIL', 'To export or delete data you must specify at least one username or e-mail address.');

@define('PLUGIN_EVENT_DSGVO_GDPR_BACKEND_CHECK_REQUESTS', 'At the moment, such a request for information or deletion is not clearly verifiable via email or only to a limited extent. Is the inquirer really also the commentator?');

