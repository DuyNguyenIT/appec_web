<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SinhVien;

Route::group(['prefix' => 'sinh-vien','namespace' => 'App\Http\Controllers\SinhVien'], function () {
    //Route::post('ckeditor/image_upload', 'GVCKEditorController@upload')->name('uploadgv');
   
    Route::get('/', 'homeController@index');
    Route::group(['prefix' => 'hoc-phan'], function () {
        Route::get('/', 'SVhocPhanController@index');
        Route::get('/khao-sat-hoc-phan/{maHocPhan}/{maLop}', 'SVhocPhanController@monhoc');

        Route::group(['prefix' => 'pks-kqht'], function () {             
            Route::get('/{maHocPhan}/{maLop}', 'SVpkskqhtController@index');
            Route::post('/guiks-kqht/{maHocPhan}', 'SVpkskqhtController@guiks_kqht');
            
        });  
        Route::group(['prefix' => 'pks-cdr3'], function () {             
            Route::get('/{maHocPhan}/{maLop}', 'SVpkscdr3Controller@index');
            Route::post('/guiks-cdr3/{maHocPhan}', 'SVpkscdr3Controller@guiks_cdr3');

        });
        Route::group(['prefix' => 'pks-chuanabet'], function () {             
            Route::get('/{maHocPhan}/{maLop}', 'SVpkschuanabetController@index');
            Route::post('/guiks-chuanabet/{maHocPhan}', 'SVpkschuanabetController@guiks_chuanabet');

        });
        
    });
    
    Route::group(['prefix' => 'mon-hoc'], function () {
        Route::get('/', 'SVmonhocController@index');
    });
        
    Route::group(['prefix' => 'khao-sat-ctdt'], function () {   
        Route::get('/', 'SV_CTDTController@index');

        Route::group(['prefix' => 'khao-sat-cdr3'], function () {   
            Route::get('/{maLop}/{maSSV}', 'SVpkscdr3ctdtController@index');
            Route::post('/guiks-ctdt/{maLop}', 'SVpkscdr3ctdtController@guiks_ctdt');
        });

        Route::group(['prefix' => 'khao-sat-chuanabet'], function () {   
             
            Route::get('/{maLop}/{maSSV}', 'SVpkschuanabetctdtController@index');
            Route::post('/guiks-ctdt/{maLop}', 'SVpkschuanabetctdtController@guiks_ctdt');
        });
    });
    
        
    
       
            
              
         /*   Route::group(['prefix' => 'chuan-abet'], function () {
              
              Route::get('/{maHocPhan}', 'chuanAbetController@index');
              
          });
          Route::group(['prefix' => 'pks-cdr3'], function () {
              
              Route::get('/{maHocPhan}', 'pkscdr3Controller@index');
            
          }); 
          Route::group(['prefix' => 'pks-chuanabet'], function () {
              
              Route::get('/{maHocPhan}', 'pkschuanabetController@index');
            
    }); */     
});
