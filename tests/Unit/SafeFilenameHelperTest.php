<?php
namespace Tests\Unit;

use Tests\TestCase;

class SafeFileNameHelperTest extends TestCase
{
    /**
     * @dataProvider fileNameProvider
     */
    public function testSafeFileNameHelper($fileName, $stripSpaces, $expected, $description): void
    {
        $sanitisedFileName = safe_filename($fileName, $stripSpaces);

        $this->assertEquals($expected, $sanitisedFileName, $description);
    }

    public function fileNameProvider(): array
    {
        return [
            'FileNameWithSpacesTabsNewLinesAndCarriageReturns' => [
                'fileName'    => "\t\t\n\r\n Banana \n\r\n\t\t",
                'stripSpaces' => false,
                'expected'    => ' Banana ',
                'description' => 'File name with spaces, tabs, newlines, and carriage returns, with only spaces stripped',
            ],
            'FileNameWithSpacesTabsNewLinesAndCarriageReturnsStripSpaces' => [
                'fileName'    => "\t\t\n\r\n Banana \n\r\n\t\t",
                'stripSpaces' => true,
                'expected'    => 'Banana',
                'description' => 'File name with spaces, tabs, newlines, and carriage returns, with spaces stripped',
            ],
            'FileNameWithDisallowedPunctuationMarks' => [
                'fileName'    => '_-!@#%*&^`"\'+=~.,The quick brown fox,.\'~=+`"^&*%#@!-_',
                'stripSpaces' => false,
                'expected'    => '_-.The quick brown fox.-_',
                'description' => 'File name with disallowed punctuation marks',
            ],
            'FileNameWithDisallowedPunctuationMarksStripSpaces' => [
                'fileName'    => '_-!@#%*&^`"\'+=~./The quick brown fox/.\'~=+`"^&*%#@!-_',
                'stripSpaces' => true,
                'expected'    => '_-.Thequickbrownfox.-_',
                'description' => 'Filename with disallowed punctuation marks, with spaces stripped',
            ],
            'FileNameWithHungarianWords' => [
                'fileName'    => 'Ütvefúró tükörfúrógép',
                'stripSpaces' => false,
                'expected'    => 'tvefr tkrfrgp',
                'description' => 'File name with Hungarian words',
            ],
            'FileNameWithHungarianWordsStripSpaces' => [
                'fileName'    => 'Ütve     fúró     tükörfúrógép',
                'stripSpaces' => true,
                'expected'    => 'tvefrtkrfrgp',
                'description' => 'File name with Hungarian Words, with spaces stripped',
            ],
            'FileNameWithGeorgianWords' => [
                'fileName'    => 'საბეჭდი-და-ტიპოგრაფიული',
                'stripSpaces' => false,
                'expected'    => '--',
                'description' => 'File name with Georgian words',
            ],
            'FileNameWithUnicodeSymbols' => [
                'fileName'    => '❤ ☀ ☆ ☂ ☻ ♞ ☯ ☭ ☢ € →',
                'stripSpaces' => false,
                'expected'    => '          ', // 10 spaces, after stripping off all unicode characters
                'description' => 'Filename with unicode symbols',
            ],
            'FileNameWithUnicodeSymbolsStripSpaces' => [
                'fileName'    => '❤ ☀ ☆ ☂ ☻ ♞ ☯ ☭ ☢ € →',
                'stripSpaces' => true,
                'expected'    => '',
                'description' => 'Filename with unicode symbols, with spaces stripped',
            ],
        ];
    }
}
