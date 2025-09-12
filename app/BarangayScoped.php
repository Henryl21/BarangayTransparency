<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

trait BarangayScoped
{
    /**
     * Get the current admin's barangay
     */
    protected function getCurrentBarangay()
    {
        return Auth::guard('admin')->user()->barangay_role;
    }

    /**
     * Get the current admin's barangay display name
     */
    protected function getCurrentBarangayName()
    {
        return Auth::guard('admin')->user()->getBarangayNameAttribute();
    }

    /**
     * Scope query to current admin's barangay
     */
    protected function scopeToBarangay($query)
    {
        return $query->where('barangay', $this->getCurrentBarangay());
    }

    /**
     * Create a new model instance with barangay pre-filled
     */
    protected function newModelWithBarangay($modelClass)
    {
        $model = new $modelClass();
        $model->barangay = $this->getCurrentBarangay();
        return $model;
    }

    /**
     * Validate that a model belongs to current admin's barangay
     */
    protected function validateBarangayAccess(Model $model)
    {
        if (!isset($model->barangay) || $model->barangay !== $this->getCurrentBarangay()) {
            abort(403, 'Unauthorized access to this barangay\'s data.');
        }
        return true;
    }

    /**
     * Set barangay on request data
     */
    protected function setBarangayOnRequest(&$data)
    {
        $data['barangay'] = $this->getCurrentBarangay();
        return $data;
    }
}