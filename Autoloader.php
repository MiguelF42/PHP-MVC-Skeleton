<?php
spl_autoload_register( 'autoloader' );
/**
 * An example of a project-specific implementation.
 *
 * @param string $class The fully-qualified class name.
 * @return void
 */
function autoloader($class) {

    // delete Application in namespace (Application = Source)
    $class_temp = str_replace('Application', '', $class);

    // splice the rest of namespace in array
    $class_array = explode('\\',$class_temp);

    // prepare $class_path to keep the file location
    $class_path = '';

    // count the number of part in $class_array
    $c = count($class_array);

    // reconstruction of the file location 
    for ($i = 1; $i < $c; $i ++) {
        $class_path = $class_path.'\\'.$class_array[$i];
    }

    // build the full file location 
    $file =  __DIR__ . '\src' . $class_path . '.php';

    // if the file exists, require it
    if (file_exists($file)) {
        require $file;
    }

}