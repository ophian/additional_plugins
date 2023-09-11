<?php
if (IN_serendipity !== true) {
    die ("Don't hack!");
}

echo '
        <div class="tweeter">
            <h3 class="serendipity_admin_tweeter_header">' . $buffer_header . '</h3>';

            <ul id="serendipity_admin_tweeter_statuses">
            . echo $buffer; .
            </ul>

        </div>
';