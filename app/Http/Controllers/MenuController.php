<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MainMenu;
use App\Models\SubMenu;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;



class MenuController extends Controller
{

    
    public function addMainMenu()
    {
         $mainMenus = MainMenu::where('status', 'active')->get();

        return view('templeuser.add-menu',compact('mainMenus'));
    }

public function saveMainMenu(Request $request)
{
    try {
        $request->validate([
            'menu_name' => 'required|string|max:255',
            'url_type' => 'required|in:route,url',
            'menu_url' => 'required|string|max:255',
            'menu_icon' => 'nullable|string|max:255',
        ], [
            'menu_name.required' => 'Menu name is required.',
            'url_type.required' => 'Please select URL type.',
            'menu_url.required' => 'Menu URL or route name is required.',
        ]);

        $templeUser = Auth::guard('temples')->user();
        if (!$templeUser) {
            throw new \Exception('Temple user not authenticated.');
        }

        $templeId = $templeUser->temple_id;

        $url = $request->url_type === 'route'
            ? route($request->menu_url, [], false) // don't prefix full URL
            : $request->menu_url;

        MainMenu::create([
            'temple_id' => $templeId,
            'menu_name' => $request->menu_name,
            'url_type' => $request->url_type,
            'url' => $url,
            'icon' => $request->menu_icon,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Main menu saved successfully!',
        ]);
    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'status' => 'validation_error',
            'errors' => $e->errors()
        ], 422);
    } catch (\Exception $e) {
        Log::error('Main menu save failed: ' . $e->getMessage());

        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage(), // show real error
        ], 500);
    }
}

public function saveSubMenu(Request $request)
{
    try {
        $rules = [
            'menu_type' => 'required|in:sidebar,header',
            'url_type' => 'required|in:route,url',
            'menu_url' => 'required|string|max:255',
        ];

        if ($request->menu_type === 'sidebar') {
            $rules['menu_id'] = 'required|exists:main_menu,id';
            $rules['sub_menu_name'] = 'required|string|max:255';
            $rules['icon_type'] = 'required|in:icon,photo';

            if ($request->icon_type === 'icon') {
                $rules['icon'] = 'required|string|max:255';
            } elseif ($request->icon_type === 'photo') {
                $rules['icon_photo'] = 'required|image|mimes:jpg,jpeg,png,svg|max:2048';
            }
        }

        $request->validate($rules);

        $templeId = Auth::guard('temples')->user()?->temple_id;

        if (!$templeId) {
            throw new \Exception("Temple user not authenticated.");
        }

        $url = $request->url_type === 'route'
            ? (Route::has($request->menu_url)
                ? route($request->menu_url, [], false)
                : throw new \Exception("Invalid route name: {$request->menu_url}"))
            : $request->menu_url;

        $iconPhotoPath = null;
        if ($request->hasFile('icon_photo')) {
            $iconPhotoPath = $request->file('icon_photo')->store('uploads/icons', 'public');
        }

        SubMenu::create([
            'temple_id'     => $templeId,
            'menu_id'       => $request->menu_id,
            'menu_type'     => $request->menu_type,
            'sub_menu_name' => $request->sub_menu_name,
            'url_type'      => $request->url_type,
            'url'           => $url,
            'icon_type'     => $request->icon_type,
            'icon'          => $request->icon,
            'icon_photo'    => $iconPhotoPath,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Sub menu saved successfully!',
        ]);
    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'status' => 'validation_error',
            'errors' => $e->errors(),
        ], 422);
    } catch (\Throwable $e) {
        Log::error('Sub menu save failed: ' . $e->getMessage());

        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage(),
        ], 500);
    }
}

}
