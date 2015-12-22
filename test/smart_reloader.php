/*
 *   Feb 3, 2015   9:50:18 PM
 *   @copyright (c) 2015,  Alex Shulzhenko,  contact@alexshulzhenko.ru
 *   @license GPL 3.0, http://opensource.org/licenses/GPL-3.0
 * 
 *   Builds list of files which should be watched
 */


/**
 * Specify extensions of files what you want to watch
 * @var String[]
 * 
 */
$extensions = array('js', 'css','php');

/**
 * Specify here the  directories which you want to watch, the more exact directory specified the better 
 * 
 * @var String[] - container 
 */
$dirs_to_watch = array('wp-content');


$files = get_list_of_files($dirs_to_watch, $extensions);
$total_time = check_for_changes($files);

echo $total_time;

/**
 *  returns formed list of all files with specified extensions
 * @param type $path
 */
function get_list_of_files($dirs_to_watch, $extensions = false)
{
    $full_list = [];
    $pattern = '';

    if ($extensions)
    {
        $pattern = '/^';

        foreach ($extensions as $elem)
        {
            $pattern .= '.+\.' . $elem . '|';
        }
        // trim last | symbol
        if (count($extensions) > 1)
        {
            $pattern = substr($pattern, 0, strlen($pattern) - 1);
        }

        $pattern .= '$/i';
    }
    else
    {
        return array(-1, "no extensions were specified");
    }


    foreach ($dirs_to_watch as $dir)
    {
        $directory = new RecursiveDirectoryIterator($dir);
        $iterator = new RecursiveIteratorIterator($directory);
        $filtered = new RegexIterator($iterator, $pattern, RecursiveRegexIterator::GET_MATCH);

        $arr = iterator_to_array($filtered, false);

        foreach ($arr as $value)
        {
            $full_list[] = $value[0];
        }
    }
    return $full_list;
}

/**
 * Checks for changes
 * @param array $list_of_files  list of files to be checked
 * @return int   total time 
 */
function check_for_changes($list_of_files)
{
    $sum = 0;
    foreach ($list_of_files as $elem)
    {
        clearstatcache($elem);
        
      // as practice showed this shoudn't be optimised  
        if (file_exists($elem))
        {
            $last_modified = filemtime($elem);

            if ($last_modified)
            {
                $sum+= $last_modified;
            }
        }
    }
    return $sum;
}