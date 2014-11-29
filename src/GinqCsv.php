<?php
namespace Ginq;

class GinqCsv
{    
    public static $options = array(
        'csvEncoding' => 'UTF-8',
        'delimiter' => ',',
        'enclosure' => '"',
        'newlineChar' => "\n",
        'forceOutput' => false,
    );
    
    /**
     * toCsv
     *
     */
    public static function toCsv(Ginq $ginq, $options = array())
    {
        $options = array_merge(self::$options, $options);
        $d = $options['delimiter'];
        $e = $options['enclosure'];
        $nc = $options['newlineChar'];
        if ($options['forceOutput']) {
            $fp = fopen('php://output','w');
            foreach ($ginq->getIterator() as $line) {
                $line = array_map(function($v) use ($e) { return $e . $v . $e;}, $line);
                if ($options['csvEncoding'] !== 'UTF-8') {
                    fwrite($fp, mb_convert_encoding(implode($d, $line) . $nc, $options['csvEncoding']));
                } else {
                    fwrite($fp, implode($d, $line) . $nc);
                }
            }
            fclose($fp);
        } else {
            $out = '';
            foreach ($ginq->getIterator() as $line) {
                $line = array_map(function($v) use ($e) { return $e . $v . $e;}, $line);
                $out .= implode($d, $line) . $nc;
            }
            if ($options['csvEncoding'] !== 'UTF-8') {
                return mb_convert_encoding($out, $options['csvEncoding']);
            }
            return $out;
        }
    }
    
}