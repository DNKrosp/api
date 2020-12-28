<?php


namespace Core;


class CommandParser
{
    private array $data = [];

    private $cmd;

    public function __set($name, $value)
    {
        if (key_exists($name, $this->data))
            $this->data[$name] = $value;

        return $this;
    }

    private function constructParams($key, $value)
    {
        if (strlen($key)==1)
            $result = " -$key $value";
        else
            $result = " $key=$value";

        return $result;
    }

    public function getCommand()
    {
        $cmd = $this->cmd;
        foreach ($this->data as $paramName => $params)
        {
            if (is_array($params))
            {
                if (isset($params[0])) // Если это обычный массив
                    $params = implode(" ", $params);
                else // Если это ассоциативный массив
                {
                    $paramsStr = "";
                    foreach ($params as $key => $value)
                        $paramsStr .= $this->constructParams($key, $value);

                    $params = $paramsStr;

                }
            } else //если передано только одно значение
                $params = $this->constructParams($paramName, $params);

            $cmd .= $params;
        }
        return $cmd;
    }

    public function __construct($command)
    {
        $command = explode(":", $command);
        $this->cmd = trim(array_shift($command));

        foreach ($command as $element)
            $this->data[$element] = null;
    }
}