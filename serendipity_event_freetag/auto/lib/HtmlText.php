<?php

/**
 * Shared HTML-to-plain-text conversion, used everywhere raw article HTML
 * needs to become tokenizable text.
 */
final class HtmlText
{
    /**
     * Strips tags while padding every "<"/">" with a space first, so
     * strip_tags() never fuses adjacent content together. PHP's strip_tags()
     * removes tags but inserts NO whitespace where they were - "<td>A</td>
     * <td>B</td>" becomes "AB", not "A B". Padding the brackets themselves
     * (rather than trying to match specific tag names) sidesteps parsing
     * tag syntax entirely, so it's robust to self-closing tags, malformed
     * markup, and any tag type - known or not - equally.
     *
     * Trade-off, deliberately accepted: inline styling placed mid-word
     * ("Rot<strong>wein</strong>") gets split into two words ("Rot wein").
     * That's a mild loss (still two real, usable word candidates) - far
     * preferable to the alternative of only handling a curated tag list,
     * which silently reproduces the original fusing bug for any tag not on
     * that list (figcaption, mark, ... - anything not anticipated).
     */
    public static function toPlainText(string $html): string
    {
        $decoded = html_entity_decode($html);
        $padded = str_replace(['<', '>'], [' <', '> '], $decoded);
        $stripped = strip_tags($padded);

        // Collapse the whitespace we just multiplied
        return trim(preg_replace('/\s+/u', ' ', $stripped));
    }
}
