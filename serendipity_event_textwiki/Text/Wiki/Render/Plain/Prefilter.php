<?php
// vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4:
/**
 * This class implements a Text_Wiki_Render_Plain to "pre-filter" source text so
 * that line endings are consistently \n, lines ending in a backslash \
 * are concatenated with the next line, and tabs are converted to spaces.
 *
 * PHP versions 4 and 5
 *
 * @category   Text
 * @package    Text_Wiki
 * @author     Paul M. Jones <pmjones@php.net>
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    CVS: $Id$
 * @link       http://pear.php.net/package/Text_Wiki
 */

class Text_Wiki_Render_Plain_Prefilter extends Text_Wiki_Render {
    function token()
    {
        return '';
    }
}
?>