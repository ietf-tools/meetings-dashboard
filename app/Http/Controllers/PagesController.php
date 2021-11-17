<?php

namespace App\Http\Controllers;

class PagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        // Get view file location from menu config
        $view = theme()->getOption('page', 'view');

        // Check if the page view file exist
        if (view()->exists('pages.'.$view)) {
            return view('pages.'.$view);
        }

        // Get the default inner page
        return view('inner');
    }
}
