<?php

/**
 * Interface ButtonInterface
 */
interface ButtonInterface
{
    /**
     * @param string $textarea
     */
    public function __construct($textarea);

    /**
     * @param boolean $useNamedEnts
     */
    public function setUseNamedEnts($useNamedEnts);

    /**
     * @param string $openTag
     */
    public function setOpenTag($openTag);

    /**
     * @param string $closeTag
     */
    public function setCloseTag($closeTag);
    /**
     * @return string
     */
    public function render();
}
