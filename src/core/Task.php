<?php


namespace Core;


use Swoole\Process;

class Task
{
    /**
     * @var false|resource
     */
    private $process;
    private $command;
    private $descriptors = [
        0 => array("pipe", "r"),  // stdin - канал, из которого дочерний процесс будет читать
        1 => array("pipe", "w"),  // stdout - канал, в который дочерний процесс будет записывать
        2 => array("pipe", "a") // stderr - файл для записи
    ];
    private $pipes;

    public function read() {
        return stream_get_contents($this->pipes[1]);
    }

    public function readErrors() {
        return stream_get_contents($this->pipes[2]);
    }

    public function write($msg) {
        fwrite($this->pipes[0], $msg);
    }

    public function kill() {
        return proc_terminate($this->process);
    }

    public function getStatus() {
        $status = proc_get_status($this->process);
        $status = $status["running"];
        return $status;
    }

    public function run() {
        $result = false;
        $this->process = proc_open($this->command, $this->descriptors, $this->pipes);
        if($this->process)
            $result = true;

        stream_set_blocking($this->pipes[1], false);
        stream_set_blocking($this->pipes[2], false);

        return $result;
    }

    public function __construct($command)
    {
        $this->command = $command;
    }
}