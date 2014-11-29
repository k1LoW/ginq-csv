<?php
namespace GinqCsv\Tests;

use Ginq;
use Ginq\GinqCsv;

class GinqCsvTest extends \PHPUnit_Framework_TestCase
{

    /**
     * setUp
     *
     */
    public function setUp(){
        Ginq::register('Ginq\GinqCsv');
    }
    
    /**
     * test_registerGinqCsv
     *
     */
    public function test_registerGinqCsv(){
        $functions = Ginq::listRegisteredFunctions();
        $expected = array('toCsv' => array('Ginq\GinqCsv', 'toCsv'));
        $this->assertEquals($functions, $expected);
    }
    
    /**
     * test_toCsv
     * @dataProvider csvCaseProvider
     */
    public function test_toCsv($data, $options, $expected){
        $result = Ginq::from($data)
            ->toCsv($options);
        $this->assertEquals($result, $expected);
    }

    /**
     * test_toCsvForce
     * fwrite php://output by line
     *
     * @dataProvider csvCaseProvider
     */
    public function test_toCsvForce($data, $options, $expected){
        $options = array_merge($options, array('forceOutput' => true));
        ob_start();
        Ginq::from($data)
            ->toCsv($options);
        $result = ob_get_contents();
        ob_end_clean();
        
        $this->assertEquals($result, $expected);
    }
    
    /**
     * csvCaseProvider
     *
     */
    public function csvCaseProvider(){

        // jpn: デフォルト出力
        $data[] = array(
            array(
                'id' => 1,
                'title' => 'Title',
                'body' => 'Hello World',
                'created' => '2014-11-28 00:00:00',
            ),
            array(
                'id' => 2,
                'title' => 'タイトル',
                'body' => 'こんにちは世界',
                'created' => '2014-11-29 00:00:00',
            ),
        );
        $options[] = array();
        $csv = <<< EOF
"1","Title","Hello World","2014-11-28 00:00:00"
"2","タイトル","こんにちは世界","2014-11-29 00:00:00"

EOF;
        $expected[] = $csv;

        // jpn: delimiterを変更
        $data[] = array(
            array(
                'id' => 1,
                'title' => 'Title',
                'body' => 'Hello World',
                'created' => '2014-11-28 00:00:00',
            ),
            array(
                'id' => 2,
                'title' => 'タイトル',
                'body' => 'こんにちは世界',
                'created' => '2014-11-29 00:00:00',
            ),
        );
        $options[] = array('delimiter' => ';');
        $csv = <<< EOF
"1";"Title";"Hello World";"2014-11-28 00:00:00"
"2";"タイトル";"こんにちは世界";"2014-11-29 00:00:00"

EOF;
        $expected[] = $csv;

        // jpn: enclosureを変更
        $data[] = array(
            array(
                'id' => 1,
                'title' => 'Title',
                'body' => 'Hello World',
                'created' => '2014-11-28 00:00:00',
            ),
            array(
                'id' => 2,
                'title' => 'タイトル',
                'body' => 'こんにちは世界',
                'created' => '2014-11-29 00:00:00',
            ),
        );
        $options[] = array('enclosure' => "'");
        $csv = <<< EOF
'1','Title','Hello World','2014-11-28 00:00:00'
'2','タイトル','こんにちは世界','2014-11-29 00:00:00'

EOF;
        $expected[] = $csv;
        
        // jpn: SJIS-Winで出力
        $data[] = array(
            array(
                'id' => 1,
                'title' => 'Title',
                'body' => 'Hello World',
                'created' => '2014-11-28 00:00:00',
            ),
            array(
                'id' => 2,
                'title' => 'タイトル',
                'body' => 'こんにちは世界',
                'created' => '2014-11-29 00:00:00',
            ),
        );
        $options[] = array('csvEncoding' => 'SJIS-Win');
        $csv = <<< EOF
"1","Title","Hello World","2014-11-28 00:00:00"
"2","タイトル","こんにちは世界","2014-11-29 00:00:00"

EOF;
        $expected[] = mb_convert_encoding($csv, 'SJIS-Win');

        // jpn: forceEnclosureをfalseにしてSJIS-Winで出力 (Excel)
        $data[] = array(
            array(
                'id' => 1,
                'title' => 'Title',
                'body' => 'Hello World',
                'created' => '2014-11-28 00:00:00',
            ),
            array(
                'id' => 2,
                'title' => 'タイトル',
                'body' => 'こんにちは"世界"',
                'created' => '2014-11-29 00:00:00',
            ),
        );
        $options[] = array(
            'csvEncoding' => 'SJIS-Win',
            'forceEnclose' => false
        );
        $csv = <<< EOF
1,Title,Hello World,2014-11-28 00:00:00
2,タイトル,"こんにちは""世界""",2014-11-29 00:00:00

EOF;
        $expected[] = mb_convert_encoding($csv, 'SJIS-Win');
        
        $d = array();
        for($i = 0; $i < count($data); ++$i) {
            $d[] = array($data[$i], $options[$i], $expected[$i]);
        }
        return $d;
    }
}