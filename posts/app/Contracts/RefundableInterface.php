<?php

namespace App\Contracts;

use GuzzleHttp\Psr7\Response as guzzleResponse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Client\Response as clientResponse;
use Illuminate\Support\Collection;

interface RefundableInterface
{
    public function refundTransaction(
        string  $paymentId, 
        array   $payload, 
        bool    $void = false
    ) : clientResponse 
      | guzzleResponse 
      | Collection;
}
