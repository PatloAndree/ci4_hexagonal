<?php

namespace Src\admin\user\domain\value_objects;

class UserName
{
    private string $name;

    public function __construct(string $name)
    {
        if (strlen($name) < 3) {
            throw new \InvalidArgumentException('Username must be at least 3 characters long.');
        }

        $this->name = $name;
    }

    public function value(): string
    {
        return $this->name;
    }
}
