<?php

if (!function_exists('safe_filename')) {
    /**
     * Generates a sanitised filename
     *
     * Removes:
     * - unicode characters
     * - non-alphanumeric characters (excludes "-", "_", and ".")
     * - (optional) spaces and tabs
     *
     * @param string $fileName
     * @param bool $stripSpaces
     *
     * @return string
     */
    function safe_filename(string $fileName, bool $stripSpaces = false): string {
        // Remove non-filename characters
        // The "u" modifier deals with multibyte characters
        $fileName = preg_replace('/([^- _\.A-Za-z0-9])/u', '', $fileName);

        // Remove newlines, and carriage returns
        $fileName = preg_replace('/[\r\n|\n|\t]/', '', $fileName);

        if ($stripSpaces) {
            $fileName = str_replace(' ', '', $fileName);
        }

        return $fileName;
    }
}
