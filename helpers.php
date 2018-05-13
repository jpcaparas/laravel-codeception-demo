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

if (!function_exists('response_pdf')) {
    /**
     * Returns a HTTP response for PDF downloads
     *
     * @param string $content
     * @param string $fileName
     * @param array $headers
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    function response_pdf(
        string $content,
        string $fileName,
        array $headers = []
    ): \Symfony\Component\HttpFoundation\Response {
        $response = response($content, \Illuminate\Http\Response::HTTP_OK, $headers);

        $dispositionHeader = $response->headers->makeDisposition(
            \Symfony\Component\HttpFoundation\ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $fileName
        );

        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-Disposition', $dispositionHeader);

        return $response;
    }
}
