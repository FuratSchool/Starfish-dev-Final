<?php

namespace App\Models;


/**
 * Class Dummy
 * @package App\Models
 */
class Dummy {

    const TAGS = [
        'markup' => [
            'h1' => ['<h1>', '</h1>'],
            'h2' => ['<h2>', '</h2>'],
            'h3' => ['<h3>', '</h3>'],
            'h4' => ['<h4>', '</h4>'],
            'h5' => ['<h5>', '</h5>'],
            'h6' => ['<h6>', '</h6>'],
            'p' => ['<p>', '</p>'],
            'hr' => ['<hr>', null],
            'br' => ['<br>', null],
            'b' => ['<b>', '</b>'],
            'i' => ['<i>', '</i>'],
            'u' => ['<u>', '</u>'],
        ],
        'table' => [
            'table' => ['<table>', '</table>'],
            'caption' => ['<caption>', '</caption>'],
            'th' => ['<th>', '</th>'],
            'tr' => ['<tr>', '</tr>'],
            'td' => ['<td>', '</td>'],
            'thead' => ['<thead>', '</thead>'],
            'tbody' => ['<tbody>', '</tbody>'],
            'tfoot' => ['<tfoot>', '</tfoot>'],
        ],
        'list' => [
            'ul' => ['<ul>', '</ul>'],
            'ol' => ['<ol>', '</ol>'],
            'li' => ['<li>', '</li>'],
        ]
    ];

    const TEXT = "Spicy jalapeno bacon ipsum dolor amet pork belly fatback corned beef meatloaf t-bone, hamburger landjaeger pancetta. Andouille pancetta meatball pork chop filet mignon jowl biltong turkey cupim. Biltong filet mignon landjaeger ham pig short loin, meatball pancetta porchetta fatback pork chop chicken leberkas ribeye. Porchetta short ribs turkey, kevin beef ribs sausage short loin. Burgdoggen tongue pork belly short loin, buffalo flank alcatra pork chop shankle meatball hamburger frankfurter short ribs pork loin spare ribs. Doner shank pork loin pig capicola. Cupim pancetta buffalo chicken shank Strip steak prosciutto pork, swine beef ribs bresaola spare ribs ham shoulder fatback. Frankfurter bresaola andouille, cow pancetta strip steak picanha sausage chuck ham hock t-bone ribeye porchetta. Salami pork loin sausage tail, doner shoulder cupim flank capicola shank. Shoulder shankle pastrami bacon shank pancetta cow pork chop andouille drumstick ham hock pork loin. Tail kevin ribeye ball tip. Tri-tip pork belly biltong sausage brisket. alcatra capicola pastrami jowl cow short ribs porchetta meatball t-bone.";

    /**
     * @param int $length
     * @param array $opts values =
     * @return string
     */
    public static function dummyHTML($length = 4, $opts = []) : string {
        $no_markup = $no_tables = $no_lists = $only_markup = $only_lists = $only_tables = false;
        $opt_keys = ['no_markup', 'no_tables', 'no_lists', 'only_markup', 'only_lists', 'only_tables'];
        foreach ($opts as $opt) {
            if(in_array($opt, $opt_keys)) {
                ${$opt} = true;
            }
        }
        $open = "<style>th, td {border solid 1px black;} caption, th, td {padding: 10px;} table, caption, tbody, thead, tfoot {border solid 2px black;} </style>";
        $code = "";
        $close = "<br><hr><br>";
        $seed = str_split(self::generateSeed($length, 3));
       foreach (range(0, $length-1) as $item){
           $val = (int) $seed[$item];
           $type = array_keys(self::TAGS)[$val];
           switch ($type) {
               case 'markup':
                   if ($no_markup or $only_lists or $only_tables) {
                       break;
                   }
                   $code .= self::generateMarkup();
                   break;
               case 'table':
                   if ($no_tables or $only_lists or $only_markup) {
                       break;
                   }
                   $code .= self::generateTable();
                   break;
               case 'list':
                   if ($no_lists or $only_tables or $only_markup) {
                       break;
                   }
                   $code .= self::generateList();
                   break;
           }
       }
       if($code == "") {
           $code = self::dummyHTML($length, $opts);
       } else {
           $code = "{$open}{$code}{$close}";
       }
       return $code;
    }


    /**
     * @param int $length
     * @param int $base
     * @param bool $postinc
     * @return string
     */
    public static function generateSeed($length = 10, $base = 10, $postinc = false) : string {
        if ($length == null) {
            throw new TypeError('$length cannot be null');
        } else if($base == null) {
            throw new TypeError('$base cannot be null');
        }else if($base == 1) {
            throw new \InvalidArgumentException('$base cannot be 1');
        }else if($length > 18){
            throw new \InvalidArgumentException('$length cannot be higher then 18');
        }
        $prim =  random_int(10**($length-1), (10**($length))-1);
        $sub = (array) str_split($prim);
        for ($i = 0; $i <= count($sub) - 1; $i++) {
            $sub[$i] = (string) $sub[$i]%$base;
            if($postinc) {
                $sub[$i]++;
            }
        }
        $seed = (string) implode($sub);
        return $seed;
    }

    /**
     * @return string
     */
    public static function generateMarkup() : string {
        $markup = (string) null;
        $hso =  (string) null;
        $hsc = (string) null;
        $fo = (string) null;
        $fc = (string) null;
        $ft = (string) null;
        $seed = (string) null;
        $seedbuilder = [[6, true], [4, false], [2, false], [9, true], [4, false]];
        foreach ($seedbuilder as $item) {
            $part = self::generateSeed(1, $item[0], $item[1]);
            $seed .= $part;
        }
        $seed = str_split($seed);
        $heading = "h".$seed[0];
        if($seed[1]) {
            switch ($seed[1]) {
                case 1:
                    $style = "b";
                    break;
                case 2:
                    $style = "i";
                    break;
                case 3:
                    $style = "u";
                    break;
            }
            /** @var string $style */
            $hso = self::TAGS['markup'][$style][0];
            $hsc = self::TAGS['markup'][$style][1];
        }
        $ho = self::TAGS['markup'][$heading][0];
        $ht = explode(" ", self::TEXT)[0];
        $hc = self::TAGS['markup'][$heading][1];
        $hr = $seed[2] ? self::TAGS['markup']['hr'][0] : (string) null ;
        $po = self::TAGS['markup']['p'][0];
        $txt = explode(".", self::TEXT);
        $pt = "";
        foreach (range(0, $seed[3]) as $index) {
            $pt .= $txt[$index];
        }
        $pc = self::TAGS['markup']['p'][1];
        if($seed[4]) {
            switch ($seed[4]) {
                case 1:
                    $style = "b";
                    break;
                case 2:
                    $style = "i";
                    break;
                case 3:
                    $style = "u";
                    break;
            }
            /** @var string $style */
            $fo = self::TAGS['markup'][$style][0];
            $fc = self::TAGS['markup'][$style][1];
            $ft =$txt[0];
        }
        $markup = "{$ho}{$hso}{$ht}{$hsc}{$hc}{$po}{$pt}{$pc}{$fo}{$ft}{$fc}";
        return $markup;
    }

    /**
     * @return string
     */
    public static function generateTable() : string {
        $table = (string)null;
        $co = (string)null;
        $ct = (string)null;
        $cc = (string)null;
        $tho = (string)null;
        $tht = (string)null;
        $thc = (string)null;
        $tbt = (string)null;
        $tfo = (string)null;
        $tft = (string)null;
        $tfc = (string)null;
        $to = self::TAGS['table']['table'][0];
        $tc = self::TAGS['table']['table'][1];
        $ro = self::TAGS['table']['tr'][0];
        $rc = self::TAGS['table']['tr'][1];
        $ho = self::TAGS['table']['th'][0];
        $hc = self::TAGS['table']['th'][1];
        $do = self::TAGS['table']['td'][0];
        $dc = self::TAGS['table']['td'][1];
        $txt = explode(" ", self::TEXT);
        $seed = (string) null;
        $seedbuilder = [[9, true], [2, false], [2, false], [9, true], [2, false]];
        foreach ($seedbuilder as $item) {
            $part = self::generateSeed(1, $item[0], $item[1]);
            $seed .= $part;
        }
        $seed = str_split($seed);
        $cols = $seed[0];
        if ($seed[1]) {
            $co = self::TAGS['table']['caption'][0];
            $ct = explode(" ", self::TEXT)[0];
            $cc = self::TAGS['table']['caption'][1];
        }
        if ($seed[2]) {
            $tho = self::TAGS['table']['thead'][0];
            $tht .= $ro;
            foreach (range(0, $cols) as $col) {
                $tht .= $ho . $txt[$col] . $hc;
            }
            $tht .= $rc;
            $thc = self::TAGS['table']['thead'][1];
        }
        $tbo = self::TAGS['table']['tbody'][0];
        foreach (range(0, $seed[3]) as $row) {
            $tbt .= $ro;
            foreach (range(0, $cols) as $col) {
                $tbt .= $do . $txt[$col] . $dc;
            }
            $tbt .= $rc;
        }
        $tbc = self::TAGS['table']['tbody'][1];
        if ($seed[4]) {
            $tfo = self::TAGS['table']['tfoot'][0];
            $tft .= $ro;
            foreach (range(0, $cols) as $col) {
                $tft .= $do . $txt[$col] . $dc;
            }
            $tft .= $rc;
            $tfc = self::TAGS['table']['tfoot'][1];
        }
        $table = "{$to}{$co}{$ct}{$cc}{$tho}{$tht}{$thc}{$tbo}{$tbt}{$tbc}{$tfo}{$tft}{$tfc}{$tc}";

        return $table;
    }

    /**
     * @return string
     */
    public static function generateList() : string {
        $list = (string) null;
        $lo = (string) null;
        $li = (string) null;
        $lc = (string) null;
        $io = self::TAGS['list']['li'][0];
        $ic = self::TAGS['list']['li'][1];
        $txt = explode(" ", self::TEXT);
        $seed = (string) null;
        $seedbuilder = [[2, false], [9, true]];
        foreach ($seedbuilder as $item) {
            $part = self::generateSeed(1, $item[0], $item[1]);
            $seed .= $part;
        }
        $seed = str_split($seed);
        $type = $seed[0];
        switch ($type) {
            case 0:
                $lo = self::TAGS['list']['ul'][0];
                $lc = self::TAGS['list']['ul'][1];
                break;
            case 1:
                $lo = self::TAGS['list']['ol'][0];
                $lc = self::TAGS['list']['ol'][1];
                break;
        }
        $items = $seed[1];
        foreach (range(0, $seed[1]) as $item) {
            $itype  = self::generateSeed(1, 2);
            $li .= $io;
            $li .= $txt[$item];
            if($itype == 1) {
                $li .= $lo;
                $isub = (int) self::generateSeed(1, 9, true);
                foreach (range(0, $isub) as $subitem) {
                    $li .= $io;
                    $li .= $txt[$subitem];
                    $li .= $ic;
                }
                $li .= $lc;
            }
            $li .= $ic;
        }
        $list = "{$lo}{$li}{$lc}";
        return $list;
   }

    /**
     * @param int $min
     * @param int $max
     * @param float|int $bias
     * @return float|int
     */
   public static function generateBiasedBetween($min = 0, $max = 1, $bias = 0.75) {
       $arr = [];
        $rand = random_int(0, 10)/10;
        $rand = $rand ** $bias;
        $num =  $min + ($max - $min) * $rand;
        return round($num);
   }
   /**
     * @param int $amount
     * @return string
     */
    public static function tester($amount = 1000) : string {
        ini_set('memory_limit', '-1');
        $result = [];
        foreach(range(0, abs($amount) - 1) as $item) {
            $part = self::generateSeed();
            $result[$item] = $part;
        }
        sort($result);
        $clean = implode("/", $result);
        return $clean;
    }

}
