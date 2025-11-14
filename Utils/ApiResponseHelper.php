<?php

namespace Utils;

class ApiResponseHelper
{
    protected $http_code = [
        'OK' => '200',
        'TEMPORARY_REDIRECT' => '307',
        'BAD_REQUEST' => '400',
        'INVALID_ARGUMENT' => '400',
        'FAILED_PRECONDITION' => '400',
        'OUT_OF_RANGE' => '400',
        'UNAUTHENTICATED' => '401',
        'PERMISSION_DENIED' => '403',
        'NOT_FOUND' => '404',
        'ABORTED' => '409',
        'ALREADY_EXISTS' => '409',
        'RESOURCE_EXHAUSTED' => '429',
        'CANCELLED' => '499',
        'DATA_LOSS' => '500',
        'UNKNOWN' => '500',
        'INTERNAL' => '500',
        'NOT_IMPLEMENTED' => '501',
        'UNAVAILABLE' => '503',
        'DEADLINE_EXCEEDED' => '504',
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
