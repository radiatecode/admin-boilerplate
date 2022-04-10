<?php

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

if (!function_exists('to_json')) {
    function to_json($data = [], $status = 200,array $headers = [], $options = 0): JsonResponse
    {
        return response()->json($data,$status,$headers,$options);
    }
}

if (!function_exists('toJsonWithSaveFlashMessage')) {
    function toJsonWithSaveFlashMessage($data = [], $status = 200,array $headers = [], $options = 0): JsonResponse
    {
        flash('You have successfully saved the data.')->success()->important();

        return response()->json($data,$status,$headers,$options);
    }
}

if (!function_exists('toJsonWithUpdateFlashMessage')) {
    function toJsonWithUpdateFlashMessage($data = [], $status = 200,array $headers = [], $options = 0): JsonResponse
    {
        flash('You have successfully updated the data.')->success()->important();

        return response()->json($data,$status,$headers,$options);
    }
}

if (!function_exists('toJsonWithDeleteFlashMessage')) {
    function toJsonWithDeleteFlashMessage($data = [], $status = 200,array $headers = [], $options = 0): JsonResponse
    {
        flash('You have successfully deleted the data.')->success()->important();

        return response()->json($data,$status,$headers,$options);
    }
}

if (!function_exists('toBackWithSaveMessage')) {
    function toBackWithSaveMessage(): RedirectResponse
    {
        flash('You have successfully saved the data.')->success()->important();

        return back();
    }
}

if (!function_exists('toBackWithUpdatedMessage')) {
    function toBackWithUpdatedMessage(): RedirectResponse
    {
        flash('You have successfully updated the data.')->success()->important();

        return back();
    }
}

if (!function_exists('toBackWithDeletedMessage')) {
    function toBackWithDeletedMessage(): RedirectResponse
    {
        flash('You have successfully deleted the data.')->success()->important();

        return back();
    }
}

if (!function_exists('toUrlWithSaveMessage')) {
    function toUrlWithSaveMessage(string $url): RedirectResponse
    {
        flash('You have successfully saved the data.')->success()->important();

        return redirect($url);
    }
}

if (!function_exists('toUrlWithUpdatedMessage')) {
    function toUrlWithUpdatedMessage(string $url): RedirectResponse
    {
        flash('You have successfully updated the data.')->success()->important();

        return redirect($url);
    }
}

if (!function_exists('toUrlWithDeletedMessage')) {
    function toUrlWithDeletedMessage(string $url): RedirectResponse
    {
        flash('You have successfully deleted the data.')->success()->important();

        return redirect($url);
    }
}
