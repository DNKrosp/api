<?php

namespace Core;

use PHPUnit\Framework\TestCase;

class CommandParserTest extends TestCase
{
    public function testNewCommand()
    {
        $pathNewFile = PathRoot::getRoot()."/data/random.txt";
        $command = new CommandParser("dd :params");

        /** @noinspection PhpUndefinedFieldInspection */
        $command->params = ["if"=>"/dev/urandom", "of"=>"$pathNewFile", "bs"=>"100M", "count"=>"1"];
        $cmd = $command->getCommand();
        $task = new Task($cmd);
        $task->run();
        while ($task->getStatus())
            sleep(1);

        $this->assertEquals(true, filesize($pathNewFile) > 0);
    }
}
