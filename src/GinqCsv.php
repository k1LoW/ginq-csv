<?php
namespace Ginq;

class GinqCsv
{
    
    public static $options = array(
        'csvEncoding' => 'UTF-8',
        'delimiter' => ',',
        'enclosure' => '"',
        'newlineChar' => "\n",
        'forceEnclose' => true,
        'forceOutput' => false,
    );
    
    /**
     * toCsv
     *
     */
    public static function toCsv(Ginq $ginq, $options = array())
    {
        $options = array_merge(self::$options, $options);
        $encoding = $options['csvEncoding'];
        $d = $options['delimiter'];
        $e = $options['enclosure'];
        $nc = $options['newlineChar'];
        $fe = $options['forceEnclose'];
        if ($options['forceOutput']) {
            $fp = fopen('php://output','w');
            foreach ($ginq->getIterator() as $line) {
                $line = array_map(function($v) use ($e, $fe, $nc) {
                    $v = preg_replace('/' . $e . '/', $e . $e, $v);
                    if ($fe || preg_match('/' . $e . '/', $v) || preg_match('/[\r\n]/', $v)) {
                        return $e . $v . $e;
                    }
                    return $v;
                }, $line);
                if ($encoding !== 'UTF-8') {
                    fwrite($fp, mb_convert_encoding(implode($d, $line) . $nc, $encoding));
                } else {
                    fwrite($fp, implode($d, $line) . $nc);
                }
            }
            fclose($fp);
        } else {
            $out = '';
            foreach ($ginq->getIterator() as $line) {
                $line = array_map(function($v) use ($e, $fe, $nc) {
                    $v = preg_replace('/' . $e . '/', $e . $e, $v);
                    if ($fe || preg_match('/' . $e . '/', $v) || preg_match('/[\r\n]/', $v)) {
                        return $e . $v . $e;
                    }
                    return $v;
                }, $line);
                $out .= implode($d, $line) . $nc;
            }
            if ($encoding !== 'UTF-8') {
                return mb_convert_encoding($out, $encoding);
            }
            return $out;
        }
    }
    
}