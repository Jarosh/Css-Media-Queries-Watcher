<?php
header('Content-type: text/css');


$args = array(
    'resolution'            => array( 'min'=>20,  'max'=>500,  'step'=>1 ),
    'width'                 => array( 'min'=>100, 'max'=>4000, 'step'=>10 ),
    'height'                => array( 'min'=>100, 'max'=>2500, 'step'=>10 ),
    'device-width'          => array( 'min'=>100, 'max'=>4000, 'step'=>10 ),
    'device-height'         => array( 'min'=>100, 'max'=>2500, 'step'=>10 ),
    'aspect-ratio'          => array( 'bound'=>30 ),
    'device-aspect-ratio'   => array( 'bound'=>30 ),
);


$opts = array('minify', 'cclass::', 'prefix::');

foreach($args as $k1=>$v1)
{
    foreach ($v1 as $k2=>$v2)
    {
        $var = $k1.'-'.$k2;
        if (PHP_SAPI!='cli')
        {
            if (isset($_GET[$var]) && is_numeric($_GET[$var]) && intval($_GET[$var])>0)
                $args[$k1][$k2] = intval($_GET[$var]);
        }
        else
        {
            $opts[] = $var.'::';
        }
    }
}

$opts = getopt('', $opts);

if (PHP_SAPI=='cli')
{
    foreach($args as $k1=>$v1)
    {
        foreach ($v1 as $k2=>$v2)
        {
            $var = $k1.'-'.$k2;
            if (array_key_exists($var, $opts) && is_numeric($opts[$var]) && intval($opts[$var])>0)
            {
                $args[$k1][$k2] = intval($opts[$var]);
            }
        }
    }
}


define('MINIFY', (PHP_SAPI=='cli')
    ? ( array_key_exists('minify', $opts) )
    : ( isset($_GET['minify']) && !!$_GET['minify']) );
define('CCLASS', (PHP_SAPI=='cli')
    ? ( (array_key_exists('cclass', $opts) && strlen(trim($opts['cclass']))) ? trim($opts['cclass']) : 'JaroshCssMediaQueriesWatcher' )
    : ( (!empty($_GET['cclass']) && strlen(trim($_GET['cclass']))) ? trim($_GET['cclass']) : 'JaroshCssMediaQueriesWatcher' )
);
define('PREFIX', (PHP_SAPI=='cli')
    ? ( (array_key_exists('prefix', $opts) && strlen(trim($opts['prefix']))) ? trim($opts['prefix']) : '' )
    : ( (!empty($_GET['prefix']) && strlen(trim($_GET['prefix']))) ? trim($_GET['prefix']) : '' )
);

define('CHAR_SPC', !MINIFY?" ":'');
define('CHAR_TAB', !MINIFY?"\t":'');
define('CHAR_NLN', !MINIFY?"\r\n":'');


function gen_array($param, $set, $class=null)
{
    $r = '';
    foreach ($set as $v)
    {
        $r.= '@media'
            . ( empty($param) ? ' only '.$v : CHAR_SPC.'('.$param.':'.CHAR_SPC.$v.')' )
            . CHAR_NLN.CHAR_TAB
            . '{'.CHAR_SPC.'.'.CCLASS.' .'.PREFIX.(empty($class)?$param:$class).':before'.CHAR_SPC
            . '{'.CHAR_SPC.'content:'.CHAR_SPC.'"'.$v.'";'
            . CHAR_SPC.'}'.CHAR_SPC.'}'
            . CHAR_NLN;
    }
    return $r.CHAR_NLN;
}


function gen_range($param, $min, $max, $step, $unit='px')
{
    $r = '';
    for ($i=0; $i<$max; $i+=$step)
    {
        $r.= '@media'.CHAR_SPC
            . ( $i!=0 ? '(min-'.$param.':'.CHAR_SPC.($i+1).$unit.')'.CHAR_SPC.' and '.CHAR_SPC : '' )
            . '(max-'.$param.':'.CHAR_SPC.(($i==0)?$min:$i+$step).$unit.')'
            . CHAR_NLN.CHAR_TAB
            . '{'.CHAR_SPC.'.'.CCLASS.' .'.PREFIX.$param.':before'.CHAR_SPC
            . '{'.CHAR_SPC.'content:'.CHAR_SPC.'"'.(($i==0)?'<'.$min:$i+1).'";'
            . CHAR_SPC.'}'.CHAR_SPC.'}'
            . CHAR_NLN;
        $i += ($i==0) ? $min-1 : 0;
    }
    return $r.CHAR_NLN;
}


function gen_ratio($param, $bound)
{
    $r = '';
    for ($i=1; $i<=$bound; $i++)
    {
        for ($j=1; $j<=$bound; $j++)
        {
            $r.= '@media'.CHAR_SPC
                . '('.$param.':'.CHAR_SPC.$i.'/'.$j.')'
                . CHAR_NLN.CHAR_TAB
                . '{'.CHAR_SPC.'.'.CCLASS.' .'.PREFIX.$param.':before'.CHAR_SPC
                . '{'.CHAR_SPC.'content:'.CHAR_SPC.'"'.$i.'/'.$j.'";'
                . CHAR_SPC.'}'.CHAR_SPC.'}'
                . CHAR_NLN;
        }
    }
    return $r.CHAR_NLN;
}


echo gen_array(null, array(
    'aural',
    'braille',
    'handheld',
    'print',
    'projection',
    'screen',
    'tty',
    'tv',
    'embossed',
), 'type');

echo gen_array('orientation', array(
    'landscape',
    'portrait',
));

echo gen_array('scan', array(
    'progressive',
    'interlace',
));

foreach($args as $k=>$v)
{
    echo (count($v)==3)
        ? gen_range($k, $v['min'], $v['max'], $v['step'], (strtolower($k)!='resolution' ? 'px' : 'dpi'))
        : gen_ratio($k, $v['bound']);
}
