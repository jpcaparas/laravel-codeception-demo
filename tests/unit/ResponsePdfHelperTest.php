<?php
namespace Tests\Unit;

use Tests\TestCase;

class ResponsePdfHelperTest extends TestCase
{
    /**
     * @dataProvider contentDispositionDataProvider
     */
    public function testReportPdfHelper(string $expectedContentDisposition, string $fileName)
    {
        $response = response_pdf('', $fileName); // We only test the filename, not the contents of the actual PDF

        $contentDisposition = $response->headers->get('Content-Disposition');

        $this->assertContains($expectedContentDisposition, $contentDisposition);
    }

    public function contentDispositionDataProvider()
    {
        return [
            'FilenameAlphanumeric' => [
                'expectedContentDisposition' => 'The quick brown fox jumps over the lazy dog 123',
                'fileName'                   => 'The quick brown fox jumps over the lazy dog 123',
            ],
            'FilenameWithCommasAndSemicolons' => [
                'expectedContentDisposition' => 'The, quick; brown, fox; jumps, over; the, lazy dog',
                'fileName'                   => 'The, quick; brown, fox; jumps, over; the, lazy dog',
            ],
            'FilenameWithSpecialCharacters' => [
                'expectedContentDisposition' => 'The! quick@ brown# fox# jumps^ over& the* lazy) dog(',
                'fileName'                   => 'The! quick@ brown# fox# jumps^ over& the* lazy) dog(',
            ],
        ];
    }

    /**
     * @dataProvider reportPdfHelperExceptionDataProvider
     */
    public function testReportPdfHelperException(string $expectedException, string $fileNameWithNonAsciiChars)
    {
        $this->expectException($expectedException);

        response_pdf('', $fileNameWithNonAsciiChars);

        $this->doesNotPerformAssertions();
    }

    public function reportPdfHelperExceptionDataProvider()
    {
        return [
            'FilenameWithUnicodeChars' => [
                'expectedException' => \InvalidArgumentException::class,
                'fileName'          => '❤ ☀ ☆ ☂ ☻ ♞ ☯ ☭ ☢ € →These are unicode characters❤ ☀ ☆ ☂ ☻ ♞ ☯ ☭ ☢ € →',
            ],
            'FilenameWithInvalidCharacters' => [
                'expectedException' => \InvalidArgumentException::class,
                'fileName'          => '%The quick brown fox jumps over the lazy dog.', // The '%' character is not allowed
            ],
            'FilenameWithOnlyNonAscii' => [
                'expectedException' => \InvalidArgumentException::class,
                'fileName'          => $this->generateUnicodeFilename(),
            ],
            'FilenameWithAsciiAndNonAscii' => [
                'expectedException' => \InvalidArgumentException::class,
                'fileName'          => $this->generateUnicodeFilename('The quick brown fox', 'jumps over the lazy dog'),
            ],
        ];
    }

    /**
     * Generates a unicode-embellished filename
     */
    private function generateUnicodeFilename(?string $appendText = null, ?string $prependText = null)
    {
        $unicodeCharsNotDecoded = ['\u1000', '\u1001', '\u1002', '\u1003', '\u1004', '\u1005'];

        $unicodeChars = array_map(function ($unicodeChar) {
            return json_decode('"' . $unicodeChar . '"');
        }, $unicodeCharsNotDecoded);

        return $appendText . join(',', $unicodeChars) . $prependText;
    }
}
