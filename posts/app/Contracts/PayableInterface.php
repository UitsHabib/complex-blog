<?php

namespace App\Contracts;

interface PayableInterface
{
    /**
     * @param $data
     *
     * @return mixed
     */
    public function pay($data);
}
