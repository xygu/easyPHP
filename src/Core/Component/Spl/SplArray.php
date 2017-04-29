<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2017/4/11
 * Time: 下午3:01
 */

namespace Core\Component\Spl;


class SplArray extends \ArrayObject
{
    function __get($name)
    {
        // TODO: Implement __get() method.
        if(!isset($this[$name])){
            return null;
        }
        return $this[$name];
    }

    function getArrayCopy()
    {
        $all = parent::getArrayCopy(); // TODO: Change the autogenerated stub
        foreach ($all as $key => $item){
            if($item instanceof SplArray){
                $all[$key] = $item->getArrayCopy();
            }
        }
        return $all;
    }

    function __set($name, $value)
    {
        // TODO: Implement __set() method.
        $this[$name] = $value;
    }

    function set($path,$value){
        $path = (new SplString($path))->explode(".")->getArrayCopy();
        $temp = $this;
        while ($key = array_shift($path)){
            $temp = &$temp[$key];
        }
        $temp = $value;
    }

    function get($path){
        $paths = (new SplString($path))->explode(".")->getArrayCopy();
        $temp = $this->getArrayCopy();
        foreach ($paths as $path){
            if(isset($temp[$path])){
                $temp = $temp[$path];
            }else{
                return null;
            }
        }
        return $temp;
    }


    function __toString()
    {
        // TODO: Implement __toString() method.
        return json_encode($this,JSON_UNESCAPED_UNICODE,JSON_UNESCAPED_SLASHES);
    }

}