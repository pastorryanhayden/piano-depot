<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

abstract class AdminController extends Controller
{
    
    protected function getPageTitle(string $title): string
    {
        return $title . ' - Admin | Piano Depot';
    }
    
    protected function getSuccessMessage(string $action, string $item): string
    {
        return ucfirst($item) . ' ' . $action . ' successfully.';
    }
    
    protected function getErrorMessage(string $action, string $item): string
    {
        return 'Failed to ' . $action . ' ' . $item . '. Please try again.';
    }
}