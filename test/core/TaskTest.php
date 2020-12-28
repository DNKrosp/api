<?php

namespace Core;

use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase
{
    public function testTask()
    {
        $pathNewFile = PathRoot::getRoot()."/data/random.txt";
        $task = new Task("dd if=/dev/urandom of=$pathNewFile bs=100M count=1");
        $task->run();
        while ($task->getStatus() && sleep(1) == 0)
            $a = $task->read();

        $this->assertEquals(filesize($pathNewFile) > 0, true);
    }
}
