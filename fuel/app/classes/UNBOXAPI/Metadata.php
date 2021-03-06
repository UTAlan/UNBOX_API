<?php
/**
 * Created by PhpStorm.
 * User: mrussell
 * Date: 11/3/14
 * Time: 9:55 AM
 */

namespace UNBOXAPI;


class Metadata {

    protected static $_excluded_modules = array(
        'Oauth',
        'Users',
        'Request',
        'Versions'
    );

    public static function get_metaData(){
        $metadata = array(
            array(
                'key' => 'config',
                'value' => self::get_config(),
            ),
            array(
                'key' => 'modules',
                'value' => array(),
            ),
            array(
                'key' => 'layouts',
                'value' => array(),
            ),
            array(
                'key' => 'templates',
                'value' => \Config::load('templates')
            )
        );
        $modules = \Module::loaded();
        foreach ($modules as $module=>$path){
            if (!in_array($module,static::$_excluded_modules)) {
                $class = \UNBOXAPI\Data\Util\Module::classify($module);
                $Class = "\\$module\\$class";
                $moduleMeta = $Class::metadata();
                if (get_parent_class($Class) == 'UNBOXAPI\Module') {
                    if ($moduleMeta['config']['login']===true && $_SESSION['loggedIn']===true){
                        $metadata[1]['value'][] = $moduleMeta;
                    }else if ($moduleMeta['config']['login']===false){
                        $metadata[1]['value'][] = $moduleMeta;
                    }
                } else if (get_parent_class($Class) == 'UNBOXAPI\Layout') {
                    if ($moduleMeta['config']['login']===true && $_SESSION['loggedIn']===true){
                        $metadata[2]['value'][] = $moduleMeta;
                    }else if ($moduleMeta['config']['login']===false){
                        $metadata[2]['value'][] = $moduleMeta;
                    }
                }
                unset($Class);
            }
        }
        return $metadata;
    }
    public static function get_config(){
        $config = \Config::get("unbox");
        unset($config['oauth']);
        unset($config['google']);
        return $config;
    }

    public function install($config){
        try {
            if ($config['locked']===false){
                if ($this->configure_database($config['database'])){

                }
            }else{
                throw new \Exception("Installer is locked. Please set the 'locked' property of the install configuration to false and try again.");
            }
        }catch(\Exception $ex){
            return $ex->getMessage();
        }

    }

} 