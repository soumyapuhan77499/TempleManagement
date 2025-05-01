<?php

namespace App\Helpers;

class TransliterationHelper
{
   
function transliterateOdiaToEnglish($text) {
    $map = [
        'ଅ' => 'a', 'ଆ' => 'aa', 'ଇ' => 'i', 'ଈ' => 'ii',
        'ଉ' => 'u', 'ଊ' => 'uu', 'ଋ' => 'ri', 'ଏ' => 'e', 'ଐ' => 'ai',
        'ଓ' => 'o', 'ଔ' => 'au',
        'କ' => 'ka', 'ଖ' => 'kha', 'ଗ' => 'ga', 'ଘ' => 'gha', 'ଙ' => 'nga',
        'ଚ' => 'cha', 'ଛ' => 'chha', 'ଜ' => 'ja', 'ଝ' => 'jha', 'ଞ' => 'nya',
        'ଟ' => 'ta', 'ଠ' => 'tha', 'ଡ' => 'da', 'ଢ' => 'dha', 'ଣ' => 'na',
        'ତ' => 'ta', 'ଥ' => 'tha', 'ଦ' => 'da', 'ଧ' => 'dha', 'ନ' => 'na',
        'ପ' => 'pa', 'ଫ' => 'pha', 'ବ' => 'ba', 'ଭ' => 'bha', 'ମ' => 'ma',
        'ଯ' => 'ya', 'ର' => 'ra', 'ଲ' => 'la', 'ଳ' => 'la', 'ଵ' => 'va',
        'ଶ' => 'sha', 'ଷ' => 'sha', 'ସ' => 'sa', 'ହ' => 'ha',
        'ଂ' => 'm', 'ଃ' => 'h', 'ଁ' => 'n',
    ];

    return strtr($text, $map);
}

}
