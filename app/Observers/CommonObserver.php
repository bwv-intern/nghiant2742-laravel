<?php

namespace App\Observers;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CommonObserver
{
    /**
     * Handle the model "created" event.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function created(Model $model)
    {
        $model->created_by = Auth::id();
        $model->created_at = Carbon::now();
        $model->updated_at = Carbon::now();
        $model->save();
    }

    /**
     * Handle the model "updated" event.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function updated(Model $model)
    {
        $model->updated_by = Auth::id();
        $model->updated_at = Carbon::now();
        $model->save();
    }
}
