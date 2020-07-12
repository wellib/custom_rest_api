<?php

namespace App\Http;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class AppJsonResponse
 *
 * @package App\Http
 */
class AppJsonResponse extends JsonResponse
{

    public const APP_JSON_RESPONSE_SUCCESS = true;

    public const APP_JSON_RESPONSE_ERROR = false;

    /**
     * AppJsonResponse constructor.
     *
     * @param null $data
     * @param bool $type
     * @param int $status
     * @param array $headers
     * @param bool $json
     */
    public function __construct(
        $data = null,
        $type = self::APP_JSON_RESPONSE_SUCCESS,
        int $status = 200,
        array $headers = [],
        bool $json = false
    ) {

        $return = [
            'success' => $type,
        ];
        if ($type === self::APP_JSON_RESPONSE_ERROR) {
            $return['data']['error'] = $data;
        } else {
            $return['data'] = $data;
        }

        parent::__construct($return, $status, $headers, $json);

    }

}
