<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::prefix('user')->group(function () {
    Route::post('/sign-in', [\App\Http\Controllers\User\UserController::class, 'signIn']);
    Route::post('/register', [\App\Http\Controllers\User\UserController::class, 'register']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/sign-out', [\App\Http\Controllers\User\UserController::class, 'signOut']);
        Route::post('/refresh-token', [\App\Http\Controllers\User\UserController::class, 'refreshToken']);
    });
});

Route::prefix('rfid')->group(function () {
    Route::get('/', ['', 'list']);

    Route::prefix('management')->group(function () {
        Route::put('/{account}', ['', 'edit']);
    });
});

// 內循環
Route::prefix('2b')->group(function () {
    // 供應商
    Route::prefix('supplier')->group(function () {
        Route::get('/', ['', 'list']);
        Route::post('/', ['', 'create']);

        Route::prefix('management')->group(function () {
            Route::put('/{id}', ['', 'edit']);
            Route::delete('/{id}', ['', 'delete']);
        });
    });

    // 廠區
    Route::prefix('factories')->group(function () {
        Route::get('/', ['', 'list']);
        Route::post('/', ['', 'create']);

        Route::prefix('management')->group(function () {
            Route::put('/{id}', ['', 'edit']);
            Route::delete('/{id}', ['', 'delete']);
        });
    });

    // 報表
    Route::prefix('reports')->group(function () {
        // 物流總表
        Route::prefix('logistics')->group(function () {
            Route::prefix('shipments')->group(function () {
                // 
            });

            Route::prefix('recipients')->group(function () {
                // 
            });

            Route::prefix('invoices')->group(function () {
                // 
            });
        });

        // 叫貨紀錄
        Route::prefix('procurement')->group(function () {
            Route::prefix('supplier')->group(function () {
                // 
            });

            Route::prefix('box-type')->group(function () {
                // 
            });

            Route::prefix('strap')->group(function () {
                // 
            });
        });

        // 供應商
        Route::prefix('supplier')->group(function () {
            // 
        });

        // 廠區
        Route::prefix('factories')->group(function () {
            // 
        });

        // 庫存
        Route::prefix('inventory')->group(function () {
            // 
        });
    });
});

// 外循環
Route::prefix('2c')->group(function () {
    // 電商
    Route::prefix('e-commerce')->group(function () {
        Route::get('/', ['', 'list']);
        Route::post('/', ['', 'create']);

        Route::prefix('management')->group(function () {
            Route::put('/{id}', ['', 'edit']);

            Route::prefix('on-line')->group(function () {
                Route::prefix('tracking')->group(function () {
                    Route::get('/', ['', 'list']);
                    Route::post('/sms', ['', 'sendSMS']);
                    Route::get('/csv/export', ['', 'export']);
                    Route::post('/sync', ['', 'sync']);
                });
            });

            Route::prefix('off-line')->group(function () {
                Route::prefix('tracking')->group(function () {
                    Route::get('/', ['', 'list']);
                    Route::post('/sms', ['', 'sendSMS']);
                    Route::post('/sync', ['', 'sync']);

                    Route::prefix('csv')->group(function () {
                        Route::get('/export', ['', 'export']);
                        Route::post('/import', ['', 'import']);
                    });
                });
            });
        });

        // 優惠券
        Route::prefix('coupons')->group(function () {
            Route::get('/', ['', 'list']);
            Route::post('/', ['', 'create']);

            Route::prefix('management')->group(function () {
                Route::get('/{id}', ['', 'details']);
                Route::put('/{id}', ['', 'edit']);
                Route::delete('/{id}', ['', 'delete']);
            });
        });
    });

    Route::prefix('line')->group(function () {
        Route::get('/{phone_number}', ['', 'get']);
        Route::get('/returns', ['', 'returns']);

        Route::prefix('management')->group(function () {
            Route::put('/{id}', ['', 'edit']);
            // Route::delete('/{id}', ['', 'delete']);
        });
    });

    // 歸還點
    Route::prefix('dropoff-locations')->group(function () {
        // 通路
        Route::prefix('channels')->group(function () {
            Route::prefix('events')->group(function () {
                Route::get('/', ['', 'list']);
                Route::post('/', ['', 'create']);

                Route::prefix('management')->group(function () {
                    Route::get('/{id}', ['', 'details']);
                    Route::put('/{id}', ['', 'edit']);
                    Route::delete('/{id}', ['', 'delete']);
                });
            });
        });

        // 歸還點
        Route::prefix('dropoffs')->group(function () {
            Route::get('/{channels_id}', ['', 'getByChannels']);
            Route::get('/{store_name}', ['', 'getByStoreName']);
            Route::post('/', ['', 'create']);

            Route::prefix('csv')->group(function () {
                Route::get('/export', ['', 'export']);
                Route::post('/import', ['', 'import']);
                Route::post('/import-quantity', ['', 'importQuantity']);
                Route::post('/import-hours', ['', 'importHours']);
            });

            Route::prefix('management')->group(function () {
                Route::prefix('qrcode')->group(function () {
                    Route::get('/{id}', ['', 'details']);
                    Route::get('/download/{id}', ['', 'download']);
                });

                Route::get('/{id}', ['', 'details']);
                Route::get('/history/{id}', ['', 'history']);
                Route::put('/{id}', ['', 'edit']);
                Route::delete('/{id}', ['', 'delete']);
            });
        });
    });
});

// 小作所
Route::prefix('processing-center')->group(function () {
    Route::get('/', ['', 'list']);
    Route::post('/', ['', 'create']);

    Route::prefix('management')->group(function () {
        Route::put('/{id}', ['', 'edit']);
        Route::delete('/{id}', ['', 'delete']);
    });
});

// 倉庫
Route::prefix('warehouses')->group(function () {
    Route::get('/', ['', 'list']);
    Route::post('/', ['', 'create']);

    Route::prefix('management')->group(function () {
        Route::put('/{id}', ['', 'edit']);
        Route::delete('/{id}', ['', 'delete']);
    });

    // 進出倉紀錄
    Route::prefix('stock-movements')->group(function () {
        Route::get('/', ['', 'get']);
        Route::get('/csv/export', ['', 'export']);
    });
});

// 包材
Route::prefix('packaging-materials')->group(function () {
    Route::get('/{id}', ['', 'get']);
    Route::get('/history/{id}', ['', 'history']);
    Route::get('/csv/export', ['', 'export']);
});