<?php
namespace IccTest\base\Autoloader;

//echo 'vbvb';
class Loader
{
    public static $path = array();
    protected static $systemDir = null;
    
    public static function addPath($prefix, $path)
    {
        $incPath = explode(PATH_SEPARATOR, get_include_path());
        foreach ($incPath as $p) {
            if (true == is_dir($p . '/' . $path)) {
                self::$path[$prefix] = realpath($p . '/' . $path);
                return true;
            }
        }
        throw new \Exception("Can't found path '" . $path . "'");
        return false;
    }
    public static function addPaths($paths)
    {
        foreach ($paths as $prefix => $path) {
            self::addPath($prefix, $path);
        }
        return true;
    }
    public static function loadClass($className)
    {
        $dirs = self::$systemDir;
        //echo 'start load class = ' . $className . PHP_EOL.'</br>';
        if (class_exists($className, false) || interface_exists($className, false)) {
            return true;
        }
        $file = str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';
        //echo $file.'</br>'.$dirs.'</br>';
        self::loadFile($file, $dirs, true);
        if (!\class_exists($className, false) && !\interface_exists($className, false)) {
            throw new \Exception("File '$file' does not exist or class '$className' was not found in the file");
        }
    }
    public static function loadFile($filename, $dirs = null, $once = false)
    {
        $folders = ['systemdir' => $dirs['system_folder'],
            'controller' => $dirs['application_folder'].
            '/'.$dirs['application_subfolder']['controllers_folder'],
            'model' => $dirs['application_folder'].'/'.$dirs['application_subfolder']['models_folder'],
            'view' => $dirs['application_folder'].'/'.$dirs['application_subfolder']['views_folder'],
                                ];
        $incPath = false;
        $incPath2 = false;
        
        foreach ($folders as $value) {
            if (!empty($value) && (is_array($value) || is_string($value))) {
                if (is_array($value)) {
                    $dirs = implode(PATH_SEPARATOR, $value);
                }
                $incPath2 = '/home/stager3/workspace/TestedFramework';
                set_include_path($incPath2);
                $incPath = get_include_path();
                //echo $incPath.'</br>';
                set_include_path($incPath . PATH_SEPARATOR . $value);
                //echo get_include_path().'</br>';
            }
            //echo get_include_path().'</br>';
            //echo $filename.'</br>';
                        //echo $incPath.'/'. $value.'/'.$filename.' filename</br>';
            
            if (file_exists($incPath.'/'. $value.'/'.$filename)) {
                //echo get_include_path().' sisi</br>';
                //echo $filename;
                if ($once) {
                    include_once $filename;
                } else {
                    include $filename;
                }
                //echo $incPath.'</br>';
                if ($incPath) {
                    set_include_path($incPath);
                    //echo 'xyz.</br>';
                }
                return true;
            }
        }

        /*	if (!empty($dirs) && (is_array($dirs) || is_string($dirs))) {
			if (is_array($dirs)) {
				$dirs = implode(PATH_SEPARATOR, $dirs);
			}
		$incPath = get_include_path();
		set_include_path($incPath . PATH_SEPARATOR . $dirs);
		echo get_include_path();
		}
		echo get_include_path();
		echo $filename;
		if ($once) {
			include_once $filename;
		} else {
			include $filename;
		}
		if ($incPath) {
			set_include_path($incPath);
		}
		return true;*/
    }
    public static function setDir($dir)
    {
        self::$systemDir = $dir;
    }
    public static function initAutoloader($dirs = null)
    {
        self::setDir($dirs);
        //echo '</br>'.__NAMESPACE__ . '\Loader::loadClass</br>';
        spl_autoload_register(__NAMESPACE__ . '\Loader::loadClass');
        //spl_autoload_register(__NAMESPACE__ . '\Loader::');
        //echo self::$systemDir;
    }
}
