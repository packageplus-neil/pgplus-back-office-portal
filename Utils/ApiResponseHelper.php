<?php

namespace Utils;

class ApiResponseHelper
{
    // /vendor/symfony/http-foundation/Response.php
    protected $http_code = [
        'HTTP_OK' => '200',
        'HTTP_BAD_REQUEST' => '400',
        'HTTP_UNAUTHORIZED' => '401',
        'HTTP_FORBIDDEN' => '403',
        'HTTP_NOT_FOUND' => '404',
        'HTTP_UNPROCESSABLE_ENTITY'=> '422',
        'HTTP_INTERNAL_SERVER_ERROR' => '500',
    ];

    public function paginator($status, $data)
    {
        $transformData = [];
        $datas = collect($data)->toArray();

        if (isset($datas['data']) && !empty($datas['data'])) {
            foreach ($datas['data'] as $v) {
                $transformData[] = $v;
            }
        }

        $details = [
            'data' => $transformData,
            'current_page' => $datas['current_page'],
            'first_page_url' => $datas['first_page_url'],
            'last_page' => $datas['last_page'],
            'last_page_url' => $datas['last_page_url'],
            'next_page_url' => $datas['next_page_url'],
            'path' => $datas['path'],
            'per_page' => $datas['per_page'],
            'total' => $datas['total']
        ];

        return $this->array($status, $details);
    }

    public function array(string $status, $details)
    {
        return [
            'code' => $this->http_code[$status],
            'status' => $status,
            'details' => $details,
            'replyTime' => date("Y-m-d H:i:s", strtotime('now'))
        ];
    }

    public function error(string $status, array $details)
    {
        return [
            'code' => $this->http_code[$status],
            'status' => $status,
            'details' => [
                'target' => $details['target'],
                'message' => $details['message']
            ],
            'replyTime' => date("Y-m-d H:i:s", strtotime('now'))
        ];
    }

    public function validatorError(string $status, $msgs)
    {
        $details = [];
        $msgs = collect($msgs)->toArray();

        foreach ($msgs as $k => $v) {
            $details[] = [
                'target' => $k,
                'message' => $v
            ];
        }

        return [
            'code' => $this->http_code[$status],
            'status' => $status,
            'details' => $details,
            'replyTime' => date("Y-m-d H:i:s", strtotime('now'))
        ];
    }
}
