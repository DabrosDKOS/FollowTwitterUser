<?php
declare(strict_types=1);

namespace App\Enum;

/**
 * @method HttpMethod GET()
 * @method HttpMethod POST()
 * @method HttpMethod PUT()
 * @method HttpMethod DELETE()
 */
class HttpMethod
{
    const GET = 'GET';
    const POST = 'POST';
    const PUT = 'PUT';
    const DELETE = 'DELETE';
}
