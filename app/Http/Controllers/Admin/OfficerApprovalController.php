<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OfficerApprovalController extends Controller
{
    public function index()
    {
        return view('admin.officers.approval'); // Make sure this view exists
    }
}
