<?php


namespace Server;


use Exception;
use ReflectionMethod;

/**
 * Class controller
 * @package Server
 */
class Controller
{
    /**
     * @param $actionName
     * @param array $args
     * @return mixed
     * @throws Exception
     */
    public function run($actionName, $args = [])
    {

        $method = new ReflectionMethod(static::class, $actionName . "Action");

        $sorted_args = [];
        if (!empty($method)) {
            foreach ($method->getParameters() as $parameter) {
                if (array_key_exists($parameter->getName(), $args)){
                    $sorted_args[]=$args[$parameter->getName()];
                }
                else {
                    if (!$parameter->isDefaultValueAvailable() && $check = false)
                        throw new Exception("Parameter " . $parameter->getName() . " have not default value", 1);
                    else
                        $sorted_args[] = $parameter->getDefaultValue();
                }
            }
        }
        return call_user_func_array([$this, $actionName.'Action'], $sorted_args);
    }
}